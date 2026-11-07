/**
 * منطق تعاملی پاپ‌آپ و ایجکس افزونه ورود پیامکی هونا
 */

(function($) {
    'use strict';

    let countdownInterval = null;
    let remainingTime = 120;
    let currentPhone = '';

    $(document).ready(function() {
        initModalEvents();
        initFormEvents();
    });

    function initModalEvents() {
        // باز کردن مدال
        $(document).on('click', '.hoona-open-otp-modal', function(e) {
            e.preventDefault();
            openModal();
        });

        // بستن مدال
        $(document).on('click', '#hoona-otp-close-btn', function() {
            closeModal();
        });

        $(document).on('click', '#hoona-otp-modal-overlay', function(e) {
            if ($(e.target).is('#hoona-otp-modal-overlay')) {
                closeModal();
            }
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $('#hoona-otp-modal-overlay').hasClass('hoona-active')) {
                closeModal();
            }
        });
    }

    function openModal() {
        $('#hoona-otp-modal-overlay').show();
        setTimeout(function() {
            $('#hoona-otp-modal-overlay').addClass('hoona-active');
            $('#hoona_user_phone').focus();
        }, 10);
    }

    function closeModal() {
        $('#hoona-otp-modal-overlay').removeClass('hoona-active');
        setTimeout(function() {
            $('#hoona-otp-modal-overlay').hide();
            resetForms();
        }, 300);
    }

    function resetForms() {
        clearInterval(countdownInterval);
        $('#hoona-step-phone').addClass('active').show();
        $('#hoona-step-verify').removeClass('active').hide();
        $('#hoona-phone-error, #hoona-verify-error, #hoona-verify-success').hide().text('');
        $('#hoona_user_phone').val('');
        $('#hoona_otp_code').val('');
    }

    function initFormEvents() {
        // ارسال کد با زدن دکمه یا فشردن اینتر در فیلد شماره
        $('#hoona-btn-send-code').on('click', handleSendCode);
        $('#hoona_user_phone').on('keypress', function(e) {
            if (e.which === 13) {
                handleSendCode();
            }
        });

        // تغییر شماره در مرحله تایید
        $('#hoona-btn-change-phone').on('click', function() {
            clearInterval(countdownInterval);
            $('#hoona-step-verify').hide();
            $('#hoona-step-phone').fadeIn();
            $('#hoona_user_phone').focus();
        });

        // ارسال مجدد کد
        $('#hoona-btn-resend').on('click', function() {
            handleSendCode();
        });

        // تایید کد و ورود
        $('#hoona-btn-submit-verify').on('click', handleVerifyCode);
        $('#hoona_otp_code').on('keypress', function(e) {
            if (e.which === 13) {
                handleVerifyCode();
            }
        });
    }

    function handleSendCode() {
        const phone = $('#hoona_user_phone').val().trim();
        const $btn = $('#hoona-btn-send-code');
        const $error = $('#hoona-phone-error');

        $error.hide().text('');

        if (!phone || phone.length < 10) {
            $error.text(hoona_otp_params.messages.invalid_phone).fadeIn();
            return;
        }

        // لودینگ
        $btn.prop('disabled', true);
        $btn.find('.btn-text').hide();
        $btn.find('.btn-loader').show();

        $.ajax({
            url: hoona_otp_params.ajax_url,
            type: 'POST',
            data: {
                action: 'hoona_send_otp',
                nonce: hoona_otp_params.nonce,
                phone: phone
            },
            success: function(response) {
                $btn.prop('disabled', false);
                $btn.find('.btn-text').show();
                $btn.find('.btn-loader').hide();

                if (response.success) {
                    currentPhone = response.data.phone;
                    $('#hoona-display-phone').text(currentPhone);

                    if (response.data.is_new) {
                        $('#hoona-extra-fields').show();
                    } else {
                        $('#hoona-extra-fields').hide();
                    }

                    $('#hoona-step-phone').hide();
                    $('#hoona-step-verify').fadeIn();
                    $('#hoona_otp_code').val('').focus();

                    startCountdown(response.data.timer || hoona_otp_params.timer);
                } else {
                    $error.text(response.data.message || hoona_otp_params.messages.server_error).fadeIn();
                }
            },
            error: function() {
                $btn.prop('disabled', false);
                $btn.find('.btn-text').show();
                $btn.find('.btn-loader').hide();
                $error.text(hoona_otp_params.messages.server_error).fadeIn();
            }
        });
    }

    function startCountdown(seconds) {
        clearInterval(countdownInterval);
        remainingTime = seconds;
        $('#hoona-btn-resend').hide();
        $('#hoona-timer-text').show();

        updateTimerDisplay();

        countdownInterval = setInterval(function() {
            remainingTime--;
            updateTimerDisplay();

            if (remainingTime <= 0) {
                clearInterval(countdownInterval);
                $('#hoona-timer-text').hide();
                $('#hoona-btn-resend').fadeIn();
            }
        }, 1000);
    }

    function updateTimerDisplay() {
        const m = Math.floor(remainingTime / 60);
        const s = remainingTime % 60;
        const display = (m < 10 ? '0' + m : m) + ':' + (s < 10 ? '0' + s : s);
        $('#hoona-countdown').text(display);
    }

    function handleVerifyCode() {
        const code = $('#hoona_otp_code').val().trim();
        const fullname = $('#hoona_user_fullname').val().trim();
        const $btn = $('#hoona-btn-submit-verify');
        const $error = $('#hoona-verify-error');
        const $success = $('#hoona-verify-success');

        $error.hide().text('');
        $success.hide().text('');

        if (!code) {
            $error.text(hoona_otp_params.messages.empty_code).fadeIn();
            return;
        }

        $btn.prop('disabled', true);
        $btn.find('.btn-text').hide();
        $btn.find('.btn-loader').show();

        $.ajax({
            url: hoona_otp_params.ajax_url,
            type: 'POST',
            data: {
                action: 'hoona_verify_otp',
                nonce: hoona_otp_params.nonce,
                phone: currentPhone,
                code: code,
                fullname: fullname
            },
            success: function(response) {
                $btn.prop('disabled', false);
                $btn.find('.btn-text').show();
                $btn.find('.btn-loader').hide();

                if (response.success) {
                    $success.text(response.data.message || hoona_otp_params.messages.verify_success).fadeIn();
                    clearInterval(countdownInterval);
                    setTimeout(function() {
                        window.location.href = response.data.redirect || hoona_otp_params.redirect;
                    }, 1200);
                } else {
                    $error.text(response.data.message || hoona_otp_params.messages.server_error).fadeIn();
                    $('#hoona_otp_code').focus();
                }
            },
            error: function() {
                $btn.prop('disabled', false);
                $btn.find('.btn-text').show();
                $btn.find('.btn-loader').hide();
                $error.text(hoona_otp_params.messages.server_error).fadeIn();
            }
        });
    }

})(window.jQuery || window.$);
