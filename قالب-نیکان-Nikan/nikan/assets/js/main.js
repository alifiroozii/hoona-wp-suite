/**
 * Nikan Medical & Clinic Theme — Main JavaScript
 * Author: مهندس علی فیروزی (شرکت هوشمندسازی و وب هونا)
 */

document.addEventListener('DOMContentLoaded', function () {

    // 1. Mobile Menu Toggle
    const toggleBtn = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.main-navigation');
    if (toggleBtn && nav) {
        toggleBtn.addEventListener('click', function () {
            nav.classList.toggle('active');
        });
    }

    // 2. Before / After Interactive Slider
    const baSlider = document.getElementById('baSlider');
    const baAfter = document.getElementById('baAfterLayer');
    const baHandle = document.getElementById('baHandle');

    if (baSlider && baAfter && baHandle) {
        let isDragging = false;

        function setSliderPosition(x) {
            const rect = baSlider.getBoundingClientRect();
            let pos = x - rect.left;
            if (pos < 0) pos = 0;
            if (pos > rect.width) pos = rect.width;
            const percentage = (pos / rect.width) * 100;

            baAfter.style.width = percentage + '%';
            baHandle.style.left = percentage + '%';
        }

        baSlider.addEventListener('mousedown', function (e) {
            isDragging = true;
            setSliderPosition(e.clientX);
        });

        window.addEventListener('mouseup', function () {
            isDragging = false;
        });

        window.addEventListener('mousemove', function (e) {
            if (!isDragging) return;
            setSliderPosition(e.clientX);
        });

        // Touch events for mobile/tablet
        baSlider.addEventListener('touchstart', function (e) {
            isDragging = true;
            if (e.touches[0]) setSliderPosition(e.touches[0].clientX);
        }, { passive: true });

        window.addEventListener('touchend', function () {
            isDragging = false;
        });

        window.addEventListener('touchmove', function (e) {
            if (!isDragging) return;
            if (e.touches[0]) setSliderPosition(e.touches[0].clientX);
        }, { passive: true });
    }

    // 3. Smooth Anchor Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
                if (nav && nav.classList.contains('active')) {
                    nav.classList.remove('active');
                }
            }
        });
    });

});

// Global Booking Handler function for form submit
function submitNikanBooking() {
    const docSelect = document.getElementById('bookDoctor');
    const dateSelect = document.getElementById('bookDate');
    const nameInput = document.getElementById('patientName');
    const phoneInput = document.getElementById('patientPhone');
    const timeSlot = document.querySelector('input[name="time_slot"]:checked');

    if (!docSelect.value) {
        alert('لطفاً پزشک معالج مورد نظر خود را انتخاب نمایید.');
        docSelect.focus();
        return;
    }
    if (!dateSelect.value) {
        alert('لطفاً تاریخ مراجعه را مشخص فرمایید.');
        dateSelect.focus();
        return;
    }
    if (!nameInput.value.trim()) {
        alert('لطفاً نام و نام خانوادگی بیمار را وارد کنید.');
        nameInput.focus();
        return;
    }
    const phoneVal = phoneInput.value.trim();
    if (!phoneVal || !/^09[0-9]{9}$/.test(phoneVal)) {
        alert('شماره تلفن همراه معتبر نمی‌باشد (مثال: 09123456789).');
        phoneInput.focus();
        return;
    }

    const btn = document.querySelector('.btn-submit-booking');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> در حال ثبت نوبت در پایگاه داده کلینیک...';
    btn.style.opacity = '0.7';

    setTimeout(() => {
        const randCode = 'NK-' + Math.floor(100000 + Math.random() * 900000);
        
        document.getElementById('resTrackingCode').innerText = randCode;
        document.getElementById('resDoctor').innerText = 'پزشک معالج: ' + docSelect.value;
        document.getElementById('resDate').innerText = 'زمان: ' + dateSelect.value + ' ساعت ' + (timeSlot ? timeSlot.value : '۱۶:۰۰');
        
        document.getElementById('bookingResultBox').style.display = 'block';
        document.getElementById('bookingResultBox').scrollIntoView({ behavior: 'smooth' });
        
        btn.innerHTML = '<i class="fas fa-check-circle"></i> نوبت ثبت شد!';
        btn.style.background = '#10b981';
        btn.style.opacity = '1';
    }, 600);
}
