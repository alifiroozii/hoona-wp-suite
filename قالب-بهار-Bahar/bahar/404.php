<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

get_header();
?>

<main id="primary" class="site-main section" style="min-height: 60vh; display: flex; align-items: center;">
    <div class="container container-narrow" style="text-align: center;">

        <div style="font-size: 7rem; font-weight: 900; line-height: 1; color: var(--color-primary); margin-bottom: 1rem; opacity: 0.85;">
            ۴۰۴
        </div>

        <h1 class="section-title"><?php esc_html_e('صفحه مورد نظر پیدا نشد!', 'bahar'); ?></h1>
        <p class="section-desc" style="margin-bottom: 2rem;">
            <?php esc_html_e('متأسفانه صفحه‌ای که به دنبال آن بودید حذف شده یا آدرس آن تغییر یافته است.', 'bahar'); ?>
        </p>

        <div style="max-width: 460px; margin: 0 auto 2.5rem;">
            <?php get_search_form(); ?>
        </div>

        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <?php esc_html_e('بازگشت به صفحه اصلی', 'bahar'); ?>
        </a>

    </div>
</main>

<?php
get_footer();
