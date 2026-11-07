<?php
/**
 * Helma Theme Footer
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

$page_id     = is_singular() ? get_queried_object_id() : 0;
$hide_footer = $page_id ? get_post_meta($page_id, '_helma_hide_footer', true) : 'no';

if ($hide_footer !== 'yes') :
?>
<footer class="site-footer" id="colophon">
    <div class="footer-glow-radial" aria-hidden="true"></div>

    <div class="container">
        
        <div class="footer-widgets">
            
            <!-- Column 1: Brand & About -->
            <div>
                <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:1rem;">
                    <div class="brand-icon-glow" style="width:32px; height:32px; font-size:1rem;">H</div>
                    <span style="font-weight:800; font-size:1.25rem; color:var(--text-main);"><?php bloginfo('name'); ?></span>
                </div>
                <p style="color:var(--text-muted); font-size:0.88rem; line-height:1.8; margin-bottom:1.5rem;">
                    <?php 
                    echo esc_html(helma_opt('footer_about', __('پوسته پیشرفته حلما؛ تلفیقی از هوش مصنوعی، سرعت خیره‌کننده و طراحی نئومدرن ۲۰۲۶ برای رشد مقیاس‌پذیر استارتاپ‌ها و محصولات SaaS.', 'helma')));
                    ?>
                </p>
                <div style="display:flex; gap:0.75rem;">
                    <?php if ($tg = helma_opt('social_telegram')) : ?>
                        <a href="<?php echo esc_url($tg); ?>" target="_blank" rel="noopener noreferrer" style="color:var(--text-muted); text-decoration:none; font-size:1.1rem;" title="تلگرام">✈️</a>
                    <?php endif; ?>
                    <?php if ($ig = helma_opt('social_instagram')) : ?>
                        <a href="<?php echo esc_url($ig); ?>" target="_blank" rel="noopener noreferrer" style="color:var(--text-muted); text-decoration:none; font-size:1.1rem;" title="اینستاگرام">📷</a>
                    <?php endif; ?>
                    <?php if ($li = helma_opt('social_linkedin')) : ?>
                        <a href="<?php echo esc_url($li); ?>" target="_blank" rel="noopener noreferrer" style="color:var(--text-muted); text-decoration:none; font-size:1.1rem;" title="لینکدین">💼</a>
                    <?php endif; ?>
                    <?php if ($tw = helma_opt('social_x')) : ?>
                        <a href="<?php echo esc_url($tw); ?>" target="_blank" rel="noopener noreferrer" style="color:var(--text-muted); text-decoration:none; font-size:1.1rem;" title="توییتر / X">✖️</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Column 2: Navigation Links -->
            <div>
                <h4 class="footer-col-title"><?php esc_html_e('محصول و امکانات', 'helma'); ?></h4>
                <ul class="footer-links">
                    <li><a href="#simulator"><?php esc_html_e('شبیه‌ساز هوش مصنوعی', 'helma'); ?></a></li>
                    <li><a href="#bento"><?php esc_html_e('قابلیت‌های بنتو گرید', 'helma'); ?></a></li>
                    <li><a href="#showcase"><?php esc_html_e('ویترین نرم‌افزار', 'helma'); ?></a></li>
                    <li><a href="#pricing"><?php esc_html_e('پلن‌های تعرفه و قیمت', 'helma'); ?></a></li>
                </ul>
            </div>

            <!-- Column 3: Resources -->
            <div>
                <h4 class="footer-col-title"><?php esc_html_e('مستندات و منابع', 'helma'); ?></h4>
                <ul class="footer-links">
                    <li><a href="#blog"><?php esc_html_e('وبلاگ و اخبار هوش مصنوعی', 'helma'); ?></a></li>
                    <li><a href="#"><?php esc_html_e('مستندات اتصال به API', 'helma'); ?></a></li>
                    <li><a href="#"><?php esc_html_e('استانداردهای امنیتی OWASP', 'helma'); ?></a></li>
                    <li><a href="#"><?php esc_html_e('حریم خصوصی و شرایط سرویس', 'helma'); ?></a></li>
                </ul>
            </div>

            <!-- Column 4: Hoona Contact -->
            <div>
                <h4 class="footer-col-title"><?php esc_html_e('طراح و توسعه‌دهنده', 'helma'); ?></h4>
                <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.8;">
                    <strong>طراح و برنامه‌نویس:</strong> علی فیروزی<br>
                    <strong>شرکت فناوری:</strong> هونا (hoonaco.ir)<br>
                    <a href="https://hoonaco.ir" target="_blank" rel="noopener noreferrer" style="display:inline-block; margin-top:0.75rem; color:var(--glow-primary); font-weight:700;">
                        مشاهده وب‌سایت هونا ←
                    </a>
                </p>
            </div>

        </div>

        <!-- Bottom Copyright -->
        <div class="footer-bottom">
            <p>
                <?php 
                echo esc_html(helma_opt('copyright_text', sprintf(__('تمامی حقوق محفوظ است © %s | طراح و برنامه‌نویس: علی فیروزی - شرکت هونا (hoonaco.ir)', 'helma'), date_i18n('Y'))));
                ?>
            </p>
            <div>
                <span>پوسته اختصاصی حلما نسل جدید AI & SaaS</span>
            </div>
        </div>

    </div>
</footer>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
