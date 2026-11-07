<?php
/**
 * فوتر پوسته امین
 */
defined('ABSPATH') || exit;
$opts = get_option('amin_options', []);
?>
<footer class="amin-footer">
    <div class="amin-footer-container">
        <div class="amin-footer-grid">
            <div>
                <h4>سامانه املاک و آگهی امین</h4>
                <p><?php echo !empty($opts['footer_about']) ? esc_html($opts['footer_about']) : 'پلتفرم سریع خرید، فروش، رهن و اجاره آپارتمان، ویلا و زمین در سراسر کشور.'; ?></p>
            </div>
            <div>
                <h4>پشتیبانی معاملات</h4>
                <p>تلفن پشتیبانی: <?php echo !empty($opts['support_tel']) ? esc_html($opts['support_tel']) : '021-77889900'; ?></p>
                <p>ساعات پاسخگویی: ۹ صبح الی ۲۱</p>
            </div>
        </div>
        <div class="amin-footer-bottom">
            <p>توسعه‌یافته توسط: <a href="https://hoonaco.ir" target="_blank">علی فیروزی (شرکت هونا)</a> | تمامی حقوق محفوظ است.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
