<?php
/**
 * فوتر پوسته صدرا
 */
defined('ABSPATH') || exit;
$opts = get_option('sadra_options', []);
$footer_text = !empty($opts['footer_text']) ? esc_html($opts['footer_text']) : 'تمامی حقوق متعلق به آکادمی صدرا است.';
?>
<footer class="sadra-footer">
    <div class="sadra-footer-container">
        <div class="sadra-footer-grid">
            <div class="footer-col">
                <div class="sadra-brand" style="margin-bottom: 14px;">
                    <span class="sadra-brand-badge">S</span>
                    <span class="sadra-brand-text"><?php echo !empty($opts['academy_name']) ? esc_html($opts['academy_name']) : 'آکادمی صدرا'; ?></span>
                </div>
                <p>مرجع آموزش‌های تخصصی و کاربردی برنامه‌نویسی، هوش مصنوعی و کسب‌وکار دیجیتال در ایران.</p>
            </div>
            <div class="footer-col">
                <h4>دسترسی سریع</h4>
                <ul>
                    <li><a href="#courses">همه دوره‌های آموزشی</a></li>
                    <li><a href="#features">مزایای یادگیری در صدرا</a></li>
                    <li><a href="#faq">سوالات متداول دانشجویان</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>پشتیبانی دانشجویان</h4>
                <p>تلفن پشتیبانی: <?php echo !empty($opts['support_phone']) ? esc_html($opts['support_phone']) : '021-88889999'; ?></p>
                <p>پشتیبانی ۲۴ ساعته تیکت و تلگرام</p>
            </div>
        </div>
        <div class="sadra-footer-bottom">
            <p><?php echo $footer_text; ?> | توسعه: <a href="https://hoonaco.ir" target="_blank">علی فیروزی (شرکت هونا)</a></p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
