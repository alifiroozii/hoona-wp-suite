/**
 * اسکریپت تعاملی پوسته امین
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // باز و بسته کردن مدال ثبت آگهی
        $('#open-listing-modal').on('click', function() {
            $('#listing-modal').fadeIn(200);
        });

        $('#close-modal, #listing-modal').on('click', function(e) {
            if (e.target === this) {
                $('#listing-modal').fadeOut(200);
            }
        });

        // سوئیچ تب‌های خرید/رهن
        $('.s-tab').on('click', function() {
            $('.s-tab').removeClass('active');
            $(this).addClass('active');
        });

        // جستجوی زنده آگهی‌ها
        $('#btn-search-listings').on('click', function() {
            const selectedCity = $('#filter-city').val();
            const selectedType = $('#filter-type').val();

            let visibleCount = 0;
            $('.listing-card').each(function() {
                const cardCity = $(this).data('city');
                const cardType = $(this).data('type');

                let matchCity = (selectedCity === 'all' || cardCity === selectedCity);
                let matchType = (selectedType === 'all' || cardType === selectedType);

                if (matchCity && matchType) {
                    $(this).fadeIn();
                    visibleCount++;
                } else {
                    $(this).fadeOut();
                }
            });

            $('#total-count').text(visibleCount);
        });

        // ثبت آنی آگهی جدید در دمو
        $('#btn-submit-listing').on('click', function() {
            const title = $('#m-title').val().trim();
            const loc = $('#m-loc').val().trim();
            const area = $('#m-area').val().trim();
            const price = $('#m-price').val().trim();
            const tel = $('#m-tel').val().trim();

            if (!title || !price || !tel) {
                alert('لطفاً عنوان، قیمت و شماره تماس را تکمیل فرمایید.');
                return;
            }

            const newCard = `
                <article class="listing-card" style="border: 2px solid #ea580c;">
                    <div class="card-thumb">
                        <span class="tag-urgent" style="background:#ea580c;">تازه منتشر شده</span>
                        <div class="thumb-bg" style="background: linear-gradient(135deg, #ea580c, #c2410c);">✨</div>
                        <span class="location-tag">${loc || 'ایران'}</span>
                    </div>
                    <div class="card-content">
                        <h3>${title}</h3>
                        <div class="listing-specs">
                            <span>📐 ${area || '100'} متر</span>
                            <span>🛏️ ۲ خواب</span>
                            <span>🚗 پارکینگ</span>
                        </div>
                        <div class="card-footer">
                            <div class="price-box">
                                <small>قیمت اعلامی:</small>
                                <strong>${price} تومان</strong>
                            </div>
                            <button type="button" class="btn-contact" onclick="alert('📞 تماس با آگهی‌دهنده: ${tel}')">📞 اطلاعات تماس</button>
                        </div>
                    </div>
                </article>
            `;

            $('#listings-container').prepend(newCard);
            $('#listing-modal').fadeOut(200);
            $('#new-listing-form')[0].reset();
            alert('🎉 تبریک! آگهی شما با موفقیت و به صورت رایگان در سامانه امین ثبت گردید.');
        });
    });

})(window.jQuery || window.$);
