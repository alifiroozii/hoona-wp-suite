<?php
/**
 * Bahar Theme Footer
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}
?>

<?php
$bahar_hide_footer = is_singular() ? get_post_meta(get_queried_object_id(), '_bahar_hide_footer', true) : 'no';

if ($bahar_hide_footer !== 'yes') :
?>
<footer class="site-footer" id="colophon">
    <div class="container">
        
        <!-- Footer Widgets -->
        <div class="footer-widgets">
            <!-- Brand / About Column -->
            <div class="footer-widget footer-brand-widget">
                <h4 class="footer-widget-title"><?php bloginfo('name'); ?></h4>
                <p>
                    <?php 
                    echo esc_html(bahar_opt('footer_about', __('پوسته حرفه‌ای و امن بهار؛ طراحی و پیاده‌سازی شده با معماری مدرن و بهینه توسط شرکت هونا برای کسب‌وکارهای نوآور.', 'bahar'))); 
                    ?>
                </p>
                <?php
                $tg = bahar_opt('social_telegram');
                $ig = bahar_opt('social_instagram');
                $li = bahar_opt('social_linkedin');
                $tw = bahar_opt('social_x');
                $wa = bahar_opt('social_whatsapp');
                if ($tg || $ig || $li || $tw || $wa) :
                ?>
                    <div class="footer-social-links" style="display:flex; gap:0.75rem; margin-top:1.25rem;">
                        <?php if ($tg) : ?><a href="<?php echo esc_url($tg); ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" title="تلگرام" style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:50%; background:var(--bg-muted); border:1px solid var(--border-light); text-decoration:none; font-size:0.9rem;">✈️</a><?php endif; ?>
                        <?php if ($ig) : ?><a href="<?php echo esc_url($ig); ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" title="اینستاگرام" style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:50%; background:var(--bg-muted); border:1px solid var(--border-light); text-decoration:none; font-size:0.9rem;">📷</a><?php endif; ?>
                        <?php if ($li) : ?><a href="<?php echo esc_url($li); ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" title="لینکدین" style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:50%; background:var(--bg-muted); border:1px solid var(--border-light); text-decoration:none; font-size:0.9rem;">💼</a><?php endif; ?>
                        <?php if ($tw) : ?><a href="<?php echo esc_url($tw); ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" title="توییتر / X" style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:50%; background:var(--bg-muted); border:1px solid var(--border-light); text-decoration:none; font-size:0.9rem;">✖️</a><?php endif; ?>
                        <?php if ($wa) : ?><a href="<?php echo esc_url($wa); ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" title="واتس‌اپ" style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:50%; background:var(--bg-muted); border:1px solid var(--border-light); text-decoration:none; font-size:0.9rem;">💬</a><?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Dynamic Sidebars or Fallback Links -->
            <?php if (is_active_sidebar('footer-1')) : ?>
                <?php dynamic_sidebar('footer-1'); ?>
            <?php else : ?>
                <div class="footer-widget">
                    <h4 class="footer-widget-title"><?php esc_html_e('دسترسی سریع', 'bahar'); ?></h4>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('صفحه اصلی', 'bahar'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/#features')); ?>"><?php esc_html_e('امکانات و خدمات', 'bahar'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/#about')); ?>"><?php esc_html_e('درباره ما', 'bahar'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/#blog')); ?>"><?php esc_html_e('آخرین مقالات', 'bahar'); ?></a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (is_active_sidebar('footer-2')) : ?>
                <?php dynamic_sidebar('footer-2'); ?>
            <?php else : ?>
                <div class="footer-widget">
                    <h4 class="footer-widget-title"><?php esc_html_e('پشتیبانی و امنیت', 'bahar'); ?></h4>
                    <ul>
                        <li><a href="#"><?php esc_html_e('گواهینامه امنیت و استانداردهای کد', 'bahar'); ?></a></li>
                        <li><a href="#"><?php esc_html_e('راهنمای سفارشی‌سازی قالب', 'bahar'); ?></a></li>
                        <li><a href="#"><?php esc_html_e('پرسش‌های متداول (FAQ)', 'bahar'); ?></a></li>
                        <li><a href="#"><?php esc_html_e('حریم خصوصی و شرایط استفاده', 'bahar'); ?></a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (is_active_sidebar('footer-3')) : ?>
                <?php dynamic_sidebar('footer-3'); ?>
            <?php else : ?>
                <div class="footer-widget">
                    <h4 class="footer-widget-title"><?php esc_html_e('ارتباط با هونا', 'bahar'); ?></h4>
                    <p style="font-size: 0.9rem; line-height: 1.8;">
                        <?php esc_html_e('طراح و برنامه‌نویس: علی فیروزی', 'bahar'); ?><br>
                        <?php esc_html_e('وب‌سایت: hoonaco.ir', 'bahar'); ?><br>
                        <a href="https://hoonaco.ir" target="_blank" rel="noopener noreferrer" style="display:inline-block; margin-top:0.5rem; color:var(--color-primary); font-weight:600;">
                            مشاهده وب‌سایت رسمی هونا ←
                        </a>
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Bottom Copyright & Credit Strip -->
        <div class="footer-bottom">
            <p>
                <?php 
                echo esc_html(bahar_opt('copyright_text', sprintf(__('تمامی حقوق محفوظ است © %s | طراح و برنامه‌نویس: علی فیروزی - شرکت هونا (hoonaco.ir)', 'bahar'), date_i18n('Y')))); 
                ?>
            </p>
            <div class="footer-credit">
                <span>طراح و برنامه‌نویس: <a href="https://hoonaco.ir" target="_blank" rel="noopener noreferrer" style="font-weight:700; color:var(--text-main);">علی فیروزی</a></span>
                <span style="margin: 0 6px; color:var(--text-muted);">|</span>
                <span>شرکت <a href="https://hoonaco.ir" target="_blank" rel="noopener noreferrer" style="color:var(--color-primary); font-weight:700;">هونا (hoonaco.ir)</a></span>
            </div>
        </div>

    </div>
</footer>
<?php endif; ?>

<!-- Floating Scroll to Top Button -->
<button class="scroll-to-top" aria-label="<?php esc_attr_e('بازگشت به ابتدای صفحه', 'bahar'); ?>">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="18 15 12 9 6 15"></polyline>
    </svg>
</button>

<?php wp_footer(); ?>
</body>
</html>
