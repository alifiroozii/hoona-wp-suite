<?php
/**
 * Bahar Theme Header (Refined Pro Edition)
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Reading Progress Bar -->
<div class="reading-progress-bar"></div>

<?php
$bahar_page_id     = get_queried_object_id();
$bahar_header_mode = is_singular() ? get_post_meta($bahar_page_id, '_bahar_header_style', true) : 'default';

if ($bahar_header_mode !== 'hide') :
    $bahar_header_classes = array('site-header');
    if ($bahar_header_mode === 'transparent') {
        $bahar_header_classes[] = 'header-transparent';
    }
?>
<header class="<?php echo esc_attr(implode(' ', $bahar_header_classes)); ?>" id="masthead">
    <div class="container header-inner">
        
        <!-- Brand / Logo -->
        <div class="site-brand">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="site-title">
                    <span class="brand-dot"></span>
                    <span><?php bloginfo('name'); ?></span>
                </a>
                <?php
            }
            ?>
        </div>

        <!-- Desktop Navigation Menu (Refined 13.5px typography) -->
        <nav class="site-navigation" id="site-navigation" aria-label="<?php esc_attr_e('منوی اصلی', 'bahar'); ?>">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class'     => 'main-menu',
                'container'      => false,
                'fallback_cb'    => function () {
                    echo '<ul class="main-menu">';
                    echo '<li class="current-menu-item"><a href="' . esc_url(home_url('/')) . '">صفحه نخست</a></li>';
                    echo '<li><a href="' . esc_url(home_url('/#features')) . '">امکانات</a></li>';
                    echo '<li><a href="' . esc_url(home_url('/#pricing')) . '">تعرفه‌ها</a></li>';
                    echo '<li><a href="' . esc_url(home_url('/#about')) . '">درباره ما</a></li>';
                    echo '<li><a href="' . esc_url(home_url('/#testimonials')) . '">نظرات</a></li>';
                    echo '<li><a href="' . esc_url(home_url('/#faq')) . '">سوالات</a></li>';
                    echo '<li><a href="' . esc_url(home_url('/#blog')) . '">وبلاگ</a></li>';
                    echo '<li><a href="' . esc_url(home_url('/#contact')) . '">تماس</a></li>';
                    echo '</ul>';
                },
            ));
            ?>
        </nav>

        <!-- Header Actions: Search, Dark Mode, CTA & Mobile Hamburger -->
        <div class="header-actions">
            
            <!-- Quick Search Button -->
            <button class="search-trigger-btn" aria-label="<?php esc_attr_e('جستجو در سایت', 'bahar'); ?>" title="<?php esc_attr_e('جستجو (⌘K)', 'bahar'); ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <span><?php esc_html_e('جستجو', 'bahar'); ?></span>
                <span class="search-shortcut-badge">⌘K</span>
            </button>

            <!-- Dark / Light Mode Switcher -->
            <button class="theme-toggle-btn" aria-label="<?php esc_attr_e('تغییر تم شب و روز', 'bahar'); ?>" title="<?php esc_attr_e('سوئیچ حالت شب و روز', 'bahar'); ?>">
                <svg class="icon-moon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
                <svg class="icon-sun" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="5"></circle>
                    <line x1="12" y1="1" x2="12" y2="3"></line>
                    <line x1="12" y1="21" x2="12" y2="23"></line>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                    <line x1="1" y1="12" x2="3" y2="12"></line>
                    <line x1="21" y1="12" x2="23" y2="12"></line>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                    <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                </svg>
            </button>

            <?php if (get_theme_mod('bahar_show_header_cta', true)) : ?>
                <a href="<?php echo esc_url(get_theme_mod('bahar_header_cta_url', '#contact')); ?>" class="btn btn-primary btn-sm">
                    <?php echo esc_html(get_theme_mod('bahar_header_cta_text', __('شروع همکاری', 'bahar'))); ?>
                </a>
            <?php endif; ?>

            <!-- Mobile Drawer Toggle Button -->
            <button class="mobile-menu-toggle" aria-label="<?php esc_attr_e('باز کردن منوی موبایل', 'bahar'); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>

    </div>
</header>
<?php endif; ?>

<!-- Mobile Slide-over Drawer -->
<div class="mobile-drawer-backdrop" aria-hidden="true"></div>
<aside class="mobile-drawer" id="mobile-drawer" aria-label="<?php esc_attr_e('منوی همراه', 'bahar'); ?>">
    <div class="mobile-drawer-header">
        <div class="site-brand">
            <span class="brand-dot"></span>
            <span style="font-weight:700; color:var(--text-main); font-size:1.05rem;"><?php bloginfo('name'); ?></span>
        </div>
        <button class="mobile-drawer-close" aria-label="<?php esc_attr_e('بستن منو', 'bahar'); ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <nav class="mobile-drawer-menu">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="current-menu-item"><span>صفحه نخست</span><span>←</span></a>
        <a href="<?php echo esc_url(home_url('/#features')); ?>"><span>امکانات و خدمات</span><span>←</span></a>
        <a href="<?php echo esc_url(home_url('/#pricing')); ?>"><span>تعرفه‌ها و پلن‌ها</span><span>←</span></a>
        <a href="<?php echo esc_url(home_url('/#about')); ?>"><span>درباره شرکت هونا</span><span>←</span></a>
        <a href="<?php echo esc_url(home_url('/#testimonials')); ?>"><span>نظرات مشتریان</span><span>←</span></a>
        <a href="<?php echo esc_url(home_url('/#faq')); ?>"><span>سوالات متداول</span><span>←</span></a>
        <a href="<?php echo esc_url(home_url('/#blog')); ?>"><span>وبلاگ و مقالات</span><span>←</span></a>
        <a href="<?php echo esc_url(home_url('/#contact')); ?>"><span>تماس و مشاوره</span><span>←</span></a>
    </nav>

    <div class="mobile-drawer-footer">
        <a href="<?php echo esc_url(get_theme_mod('bahar_header_cta_url', '#contact')); ?>" class="btn btn-primary" style="width:100%; justify-content:center;">
            <?php echo esc_html(get_theme_mod('bahar_header_cta_text', __('شروع همکاری', 'bahar'))); ?>
        </a>
        <div style="font-size:0.75rem; color:var(--text-muted); text-align:center; margin-top:0.5rem;">
            طراحی و توسعه: علی فیروزی • شرکت هونا (hoonaco.ir)
        </div>
    </div>
</aside>

<!-- Global Search Modal -->
<div class="search-modal-backdrop" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('پنجره جستجو', 'bahar'); ?>">
    <div class="search-modal-box">
        <div class="search-modal-header">
            <span style="font-weight:700; color:var(--text-main); font-size:1rem; display:flex; align-items:center; gap:0.5rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <?php esc_html_e('جستجوی سریع در سایت', 'bahar'); ?>
            </span>
            <button class="search-modal-close" aria-label="<?php esc_attr_e('بستن', 'bahar'); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <?php get_search_form(); ?>
        <div style="margin-top:1rem; font-size:0.8rem; color:var(--text-muted); display:flex; justify-content:space-between;">
            <span>برای بستن کلید <kbd style="background:var(--bg-muted); padding:2px 6px; border-radius:4px; border:1px solid var(--border-light);">Esc</kbd> را بزنید</span>
            <span>شرکت هونا (hoonaco.ir)</span>
        </div>
    </div>
</div>
