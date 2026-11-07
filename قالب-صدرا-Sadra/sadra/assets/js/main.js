/**
 * اسکریپت تعاملی پوسته صدرا
 */
(function($) {
    'use strict';
    $(document).ready(function() {
        // تغییر درس‌های پلیر ویدیو
        $('.lesson-item').on('click', function() {
            $('.lesson-item').removeClass('active');
            $(this).addClass('active');
            const lessonTitle = $(this).find('strong').text();
            $('.video-mockup h4').text(lessonTitle);
        });

        // پلی کردن ویدیو نمایشی
        $('.play-btn').on('click', function() {
            $(this).css('transform', 'scale(0.9)');
            setTimeout(() => {
                alert('🎥 در حال بارگذاری استریم ویدیوی جلسه اول با کیفیت 1080p...');
                $(this).css('transform', 'none');
            }, 200);
        });
    });
})(window.jQuery || window.$);
