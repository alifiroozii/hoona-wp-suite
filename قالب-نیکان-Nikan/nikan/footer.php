<?php
/**
 * The template for displaying the footer
 *
 * @package Nikan
 */

if (!defined('ABSPATH')) {
    exit;
}

$opts = get_option('nikan_theme_options', []);
$clinic_name  = $opts['clinic_name'] ?? 'کلینیک تخصصی و جراحی نیکان';
$clinic_phone = $opts['clinic_phone'] ?? '021-88776655';
$address      = $opts['address'] ?? 'تهران، خیابان ولیعصر، بالاتر از توانیر، ساختمان پزشکان نیکان';
$footer_text  = $opts['footer_text'] ?? 'تمامی حقوق مادی و معنوی برای کلینیک تخصصی نیکان محفوظ است.';
?>

    <footer id="colophon" class="site-footer">
        <div class="container footer-grid">
            <!-- Col 1 -->
            <div class="footer-widget widget-about">
                <div class="logo-box footer-logo">
                    <div class="logo-icon"><i class="fas fa-heartbeat"></i></div>
                    <div class="logo-text">
                        <span class="brand-title"><?php echo esc_html($clinic_name); ?></span>
                        <span class="brand-tagline">مرکز تخصصی و معتبر درمانی</span>
                    </div>
                </div>
                <p class="footer-desc">
                    کلینیک نیکان با بهره‌گیری از کادر درمانی مجرب، اساتید دانشگاهی و پیشرفته‌ترین تجهیزات تشخیصی روز دنیا، خدمات پزشکی و درمانی استاندارد را در محیطی استریل و آرام به بیماران عزیز ارائه می‌دهد.
                </p>
                <div class="footer-socials">
                    <a href="#" aria-label="اینستاگرام کلینیک"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="تلگرام کلینیک"><i class="fab fa-telegram-plane"></i></a>
                    <a href="#" aria-label="واتساپ مشاوره"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Col 2 -->
            <div class="footer-widget widget-links">
                <h4 class="widget-title">دپارتمان‌های تخصصی</h4>
                <ul>
                    <li><a href="#services"><i class="fas fa-chevron-left"></i> کلینیک فوق‌تخصصی قلب و عروق</a></li>
                    <li><a href="#services"><i class="fas fa-chevron-left"></i> دندان‌پزشکی دیجیتال و ایمپلنت</a></li>
                    <li><a href="#services"><i class="fas fa-chevron-left"></i> پوست، مو، لیزر و جراحی زیبایی</a></li>
                    <li><a href="#services"><i class="fas fa-chevron-left"></i> کلینیک چکاپ و آزمایشگاه تشخیص طبی</a></li>
                    <li><a href="#services"><i class="fas fa-chevron-left"></i> ارتوپدی و فیزیوتراپی پیشرفته</a></li>
                </ul>
            </div>

            <!-- Col 3 -->
            <div class="footer-widget widget-contact">
                <h4 class="widget-title">ارتباط با درمانگاه</h4>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><?php echo esc_html($address); ?></span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <span>خط مستقیم پذیرش: <strong><?php echo esc_html($clinic_phone); ?></strong></span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-clock"></i>
                    <span>پذیرش همه روزه ۸ صبح الی ۲۱ شب</span>
                </div>
            </div>

            <!-- Col 4 -->
            <div class="footer-widget widget-badges">
                <h4 class="widget-title">مجوزهای قانونی درمان</h4>
                <div class="badges-row">
                    <div class="med-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>مجوز رسمی وزارت بهداشت</span>
                    </div>
                    <div class="med-badge">
                        <i class="fas fa-certificate"></i>
                        <span>تاییدیه سازمان نظام پزشکی</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-info">
            <div class="container site-info-flex">
                <p><?php echo esc_html($footer_text); ?></p>
                <p class="author-credits">
                    طراحی و توسعه اختصاصی توسط <strong>مهندس علی فیروزی</strong> | <a href="https://hoonaco.ir" target="_blank">شرکت هوشمندسازی و وب هونا (hoonaco.ir)</a>
                </p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
