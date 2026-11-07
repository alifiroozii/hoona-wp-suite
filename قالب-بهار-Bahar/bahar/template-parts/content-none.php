<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}
?>

<section class="no-results not-found" style="text-align: center; padding: 4rem 1rem;">
    <div style="width: 72px; height: 72px; margin: 0 auto 1.5rem; border-radius: 50%; background-color: var(--bg-subtle); display: flex; align-items: center; justify-content: center; color: var(--text-muted);">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            <line x1="11" y1="8" x2="11" y2="14"></line>
            <line x1="8" y1="11" x2="14" y2="11"></line>
        </svg>
    </div>

    <h2 class="section-title"><?php esc_html_e('موردی یافت نشد', 'bahar'); ?></h2>

    <div class="page-content" style="max-width: 500px; margin: 0 auto;">
        <?php if (is_home() && current_user_can('publish_posts')) : ?>
            <p><?php printf(wp_kses(__('آماده انتشار اولین نوشته خود هستید؟ <a href="%1$s">از اینجا شروع کنید</a>.', 'bahar'), array('a' => array('href' => array()))), esc_url(admin_url('post-new.php'))); ?></p>
        <?php elseif (is_search()) : ?>
            <p><?php esc_html_e('متأسفانه هیچ نتیجه‌ای با عبارت جستجوی شما مطابقت نداشت. لطفاً با کلمات کلیدی دیگری امتحان کنید.', 'bahar'); ?></p>
            <div style="margin-top: 1.5rem;">
                <?php get_search_form(); ?>
            </div>
        <?php else : ?>
            <p><?php esc_html_e('به نظر می‌رسد محتوایی که به دنبال آن بودید پیدا نشد. شاید جستجو بتواند کمک کند.', 'bahar'); ?></p>
            <div style="margin-top: 1.5rem;">
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
