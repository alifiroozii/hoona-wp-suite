<?php
/**
 * Helma Theme 404 Error Page Template
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

get_header();
?>

<main id="primary" class="site-main section" style="text-align:center; padding:7rem 0;">
    <div class="container container-narrow">
        <div style="font-size:6rem; font-weight:800; background:var(--gradient-glow); -webkit-background-clip:text; -webkit-text-fill-color:transparent; line-height:1; margin-bottom:1.5rem;">
            ۴۰۴
        </div>
        <h1 style="font-size:2rem; font-weight:800; color:var(--text-main); margin-bottom:1rem;">
            <?php esc_html_e('صفحه مورد نظر یافت نشد!', 'helma'); ?>
        </h1>
        <p style="color:var(--text-muted); font-size:1rem; margin-bottom:2.5rem; line-height:1.8;">
            <?php esc_html_e('نشانی وارد شده اشتباه است یا ممکن است این صفحه توسط هوش مصنوعی بازآرایی یا حذف شده باشد.', 'helma'); ?>
        </p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary-glow" style="padding:0.75rem 2rem;">
            <?php esc_html_e('بازگشت به صفحه اصلی', 'helma'); ?> ←
        </a>
    </div>
</main>

<?php
get_footer();
