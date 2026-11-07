<?php
/**
 * Helma Theme Sidebar
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}
?>

<div class="site-sidebar" style="display:flex; flex-direction:column; gap:2rem;">
    <!-- Search Widget -->
    <div style="background:var(--bg-surface); border:1px solid var(--border-card); border-radius:var(--radius-md); padding:1.5rem;">
        <h4 style="font-size:1.05rem; font-weight:700; color:var(--text-main); margin-bottom:1rem;"><?php esc_html_e('جستجو در مطالب', 'helma'); ?></h4>
        <?php get_search_form(); ?>
    </div>

    <!-- AI Promo Widget -->
    <div style="background:linear-gradient(135deg, rgba(139, 92, 246, 0.12) 0%, rgba(6, 182, 212, 0.08) 100%); border:1px solid rgba(139, 92, 246, 0.3); border-radius:var(--radius-md); padding:1.75rem; text-align:center;">
        <div style="font-size:2rem; margin-bottom:0.5rem;">⚡</div>
        <h4 style="font-size:1.1rem; font-weight:800; color:var(--text-main); margin-bottom:0.5rem;"><?php esc_html_e('پوسته هوش مصنوعی حلما', 'helma'); ?></h4>
        <p style="font-size:0.85rem; color:var(--text-muted); line-height:1.7; margin-bottom:1.25rem;">
            <?php esc_html_e('زیرساخت مقیاس‌پذیر و فوق‌سریع برای نرم‌افزارهای ابری و استارتاپ‌ها.', 'helma'); ?>
        </p>
        <a href="https://hoonaco.ir" target="_blank" class="btn-primary-glow" style="font-size:0.82rem; padding:0.45rem 1.25rem; justify-content:center;">
            <?php esc_html_e('ارتباط با شرکت هونا', 'helma'); ?>
        </a>
    </div>
</div>
