/**
 * اسکریپت تعاملی و عملیات ایجکس سبد خرید کشویی هونا
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        initCartEvents();
        refreshCart();
    });

    function initCartEvents() {
        // باز کردن کشو با کلیک دکمه شناور یا شورت‌کد
        $(document).on('click', '#hoona-cart-launcher-btn, .hoona-open-cart-panel', function(e) {
            e.preventDefault();
            openDrawer();
        });

        // بستن کشو
        $(document).on('click', '#hoona-cart-close-btn, #hoona-cart-drawer-overlay', function() {
            closeDrawer();
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDrawer();
            }
        });

        // باز شدن خودکار پس از افزودن محصول در ووکامرس
        $(document.body).on('added_to_cart', function() {
            refreshCart(true);
            if (hoona_cart_params.auto_open) {
                openDrawer();
            }
        });

        // تغییر تعداد با دکمه‌های + و -
        $(document).on('click', '.hoona-qty-plus', function() {
            const key = $(this).data('key');
            const $val = $(this).siblings('.hoona-qty-val');
            const currentQty = parseInt($val.text()) || 1;
            updateQuantity(key, currentQty + 1);
        });

        $(document).on('click', '.hoona-qty-minus', function() {
            const key = $(this).data('key');
            const $val = $(this).siblings('.hoona-qty-val');
            const currentQty = parseInt($val.text()) || 1;
            if (currentQty > 1) {
                updateQuantity(key, currentQty - 1);
            } else {
                removeItem(key);
            }
        });

        // حذف آیتم
        $(document).on('click', '.hoona-remove-btn', function() {
            const key = $(this).data('key');
            removeItem(key);
        });

        // اعمال کد تخفیف
        $(document).on('click', '#hoona-coupon-btn', function() {
            applyCoupon();
        });
        $('#hoona-coupon-input').on('keypress', function(e) {
            if (e.which === 13) {
                applyCoupon();
            }
        });
    }

    function openDrawer() {
        $('#hoona-cart-drawer-overlay').addClass('active');
        $('#hoona-slide-cart-panel').addClass('active');
        $('body').css('overflow', 'hidden');
    }

    function closeDrawer() {
        $('#hoona-cart-drawer-overlay').removeClass('active');
        $('#hoona-slide-cart-panel').removeClass('active');
        $('body').css('overflow', '');
    }

    function refreshCart(skipOpen) {
        $.ajax({
            url: hoona_cart_params.ajax_url,
            type: 'POST',
            data: {
                action: 'hoona_cart_get_data',
                nonce: hoona_cart_params.nonce
            },
            success: function(res) {
                if (res.success) {
                    renderCartItems(res.data);
                }
            }
        });
    }

    function renderCartItems(data) {
        // بروزرسانی شمارنده‌ها
        $('#hoona-cart-counter, #hoona-header-count').text(data.count || 0);

        // نوار پیشرفت ارسال رایگان
        $('#hoona-shipping-progress').css('width', (data.shipping_percent || 0) + '%');
        $('#hoona-shipping-status').html(data.shipping_text || '');

        // جمع کل
        $('#hoona-cart-subtotal').html(data.subtotal || '۰ تومان');

        const $list = $('#hoona-cart-items-list');
        $list.empty();

        if (data.is_empty || !data.items || data.items.length === 0) {
            $list.html(`
                <div class="hoona-empty-cart">
                    <div class="hoona-empty-icon">🛍️</div>
                    <p>سبد خرید شما در حال حاضر خالی است.</p>
                </div>
            `);
            $('#hoona-cart-footer-area').hide();
            return;
        }

        $('#hoona-cart-footer-area').show();

        data.items.forEach(function(item) {
            const row = `
                <div class="hoona-cart-item" data-key="${item.key}">
                    <div class="hoona-item-thumb-wrap">
                        ${item.thumbnail || '<div class="hoona-item-thumb"></div>'}
                    </div>
                    <div class="hoona-item-details">
                        <a href="${item.permalink}" class="hoona-item-title">${item.name}</a>
                        <div class="hoona-item-price">${item.subtotal}</div>
                        <div class="hoona-item-actions">
                            <div class="hoona-qty-box">
                                <button type="button" class="hoona-qty-btn hoona-qty-minus" data-key="${item.key}">-</button>
                                <span class="hoona-qty-val">${item.quantity}</span>
                                <button type="button" class="hoona-qty-btn hoona-qty-plus" data-key="${item.key}">+</button>
                            </div>
                            <button type="button" class="hoona-remove-btn" data-key="${item.key}" title="حذف کالا">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            $list.append(row);
        });
    }

    function updateQuantity(key, qty) {
        $.ajax({
            url: hoona_cart_params.ajax_url,
            type: 'POST',
            data: {
                action: 'hoona_cart_update_qty',
                nonce: hoona_cart_params.nonce,
                key: key,
                quantity: qty
            },
            success: function(res) {
                if (res.success) {
                    renderCartItems(res.data);
                }
            }
        });
    }

    function removeItem(key) {
        $(`.hoona-cart-item[data-key="${key}"]`).css('opacity', '0.4');
        $.ajax({
            url: hoona_cart_params.ajax_url,
            type: 'POST',
            data: {
                action: 'hoona_cart_remove_item',
                nonce: hoona_cart_params.nonce,
                key: key
            },
            success: function(res) {
                if (res.success) {
                    renderCartItems(res.data);
                }
            }
        });
    }

    function applyCoupon() {
        const coupon = $('#hoona-coupon-input').val().trim();
        const $msg = $('#hoona-coupon-message');
        $msg.hide().removeClass('error success');

        if (!coupon) return;

        $.ajax({
            url: hoona_cart_params.ajax_url,
            type: 'POST',
            data: {
                action: 'hoona_cart_apply_coupon',
                nonce: hoona_cart_params.nonce,
                coupon_code: coupon
            },
            success: function(res) {
                if (res.success) {
                    $msg.addClass('success').text(res.data.message).fadeIn();
                    refreshCart();
                } else {
                    $msg.addClass('error').text(res.data.message).fadeIn();
                }
            }
        });
    }

})(window.jQuery || window.$);
