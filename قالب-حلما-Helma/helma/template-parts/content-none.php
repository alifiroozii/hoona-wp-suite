<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}
?>

<div class="no-results not-found" style="text-align:center; padding:4rem 0;">
    <h2 style="font-size:1.6rem; font-weight:800; color:var(--text-main); margin-bottom:1rem;">
        <?php esc_html_e('موردی یافت نشد', 'helma'); ?>
    </h2>
    <p style="color:var(--text-muted); font-size:0.95rem; margin-bottom:2rem;">
        <?php esc_html_e('به نظر می‌رسد هیچ نوشته‌ای مطابق با عبارت درخواستی شما وجود ندارد.', 'helma'); ?>
    </p>
    <div style="max-width:440px; margin:0 auto;">
        <?php get_search_form(); ?>
    </div>
</div>
