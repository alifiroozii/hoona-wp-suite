<?php
/**
 * The sidebar containing the main widget area
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}
?>

<aside id="secondary" class="widget-area" style="display:flex; flex-direction:column; gap:2rem;">
    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <?php dynamic_sidebar('sidebar-1'); ?>
    <?php else : ?>
        <!-- Default Fallback Widgets -->
        <section class="widget" style="background:var(--bg-surface); border:1px solid var(--border-light); border-radius:var(--radius-lg); padding:1.75rem; box-shadow:var(--shadow-xs);">
            <h3 class="widget-title" style="font-size:1.15rem; font-weight:700; margin-bottom:1.25rem; color:var(--text-main); position:relative; padding-bottom:0.5rem;">
                <?php esc_html_e('جستجو در سایت', 'bahar'); ?>
            </h3>
            <?php get_search_form(); ?>
        </section>

        <section class="widget" style="background:var(--bg-surface); border:1px solid var(--border-light); border-radius:var(--radius-lg); padding:1.75rem; box-shadow:var(--shadow-xs);">
            <h3 class="widget-title" style="font-size:1.15rem; font-weight:700; margin-bottom:1.25rem; color:var(--text-main); position:relative; padding-bottom:0.5rem;">
                <?php esc_html_e('دسته‌بندی مقالات', 'bahar'); ?>
            </h3>
            <ul style="display:flex; flex-direction:column; gap:0.6rem;">
                <?php
                wp_list_categories(array(
                    'title_li'   => '',
                    'show_count' => true,
                ));
                ?>
            </ul>
        </section>

        <section class="widget" style="background:linear-gradient(135deg, var(--color-primary-light) 0%, var(--bg-muted) 100%); border:1px solid var(--border-light); border-radius:var(--radius-lg); padding:1.75rem; text-align:center;">
            <div style="font-size:1.5rem; margin-bottom:0.5rem;">💡</div>
            <h4 style="font-size:1.05rem; font-weight:700; color:var(--text-main); margin-bottom:0.5rem;">مشاوره اختصاصی هونا</h4>
            <p style="font-size:0.85rem; color:var(--text-secondary); margin-bottom:1.25rem;">برای دریافت راهکارهای امنیتی و توسعه وب با کارشناسان ما تماس بگیرید.</p>
            <a href="https://hoonaco.ir" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm" style="width:100%; justify-content:center;">
                ورود به وب‌سایت هونا
            </a>
        </section>
    <?php endif; ?>
</aside>
