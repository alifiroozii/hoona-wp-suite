<?php
/**
 * Helma Theme Header
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

$page_id      = is_singular() ? get_queried_object_id() : 0;
$header_style = $page_id ? get_post_meta($page_id, '_helma_header_style', true) : 'default';
$cyber_grid   = $page_id ? get_post_meta($page_id, '_helma_cyber_grid', true) : 'yes';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ($cyber_grid !== 'no') : ?>
    <!-- Cyber Grid Background Canvas -->
    <div class="cyber-canvas-bg" aria-hidden="true"></div>
<?php endif; ?>

<?php if ($header_style !== 'hide') : ?>
    <!-- Floating Glass Header Navbar -->
    <header class="site-header <?php echo esc_attr($header_style === 'transparent' ? 'header-transparent' : ''); ?>" id="masthead">
        <div class="header-glass-wrapper">
            
            <!-- Brand Logo & Name -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="header-brand" rel="home">
                <div class="brand-icon-glow">H</div>
                <div>
                    <span class="brand-name"><?php bloginfo('name'); ?></span>
                </div>
            </a>

            <!-- Live Status Indicator Pill -->
            <?php if (helma_opt('show_status_pill', 1)) : ?>
                <div class="live-status-pill">
                    <span class="live-dot"></span>
                    <span><?php echo esc_html(helma_opt('status_pill_text', '🟢 تمامی مدل‌های هوش مصنوعی فعال است | نسخه ۳.۰')); ?></span>
                </div>
            <?php endif; ?>

            <!-- Desktop Navigation Links -->
            <nav class="header-nav-wrap" aria-label="<?php esc_attr_e('منوی اصلی', 'helma'); ?>">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'header-nav',
                        'fallback_cb'    => false,
                        'depth'          => 2,
                    ));
                } else {
                    ?>
                    <ul class="header-nav">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link active"><?php esc_html_e('صفحه اصلی', 'helma'); ?></a></li>
                        <li><a href="#simulator" class="nav-link"><?php esc_html_e('شبیه‌ساز AI', 'helma'); ?></a></li>
                        <li><a href="#bento" class="nav-link"><?php esc_html_e('امکانات', 'helma'); ?></a></li>
                        <li><a href="#showcase" class="nav-link"><?php esc_html_e('محیط نرم‌افزار', 'helma'); ?></a></li>
                        <li><a href="#pricing" class="nav-link"><?php esc_html_e('تعرفه‌ها', 'helma'); ?></a></li>
                        <li><a href="#testimonials" class="nav-link"><?php esc_html_e('نظرات', 'helma'); ?></a></li>
                        <li><a href="#blog" class="nav-link"><?php esc_html_e('وبلاگ', 'helma'); ?></a></li>
                    </ul>
                    <?php
                }
                ?>
            </nav>

            <!-- Actions: Theme Switcher & CTA -->
            <div class="header-actions">
                <button type="button" class="theme-toggle-btn" id="helma-theme-toggle" aria-label="<?php esc_attr_e('تغییر تم تاریک و روشن', 'helma'); ?>">
                    ☀️
                </button>

                <a href="<?php echo esc_url(helma_opt('header_cta_url', '#pricing')); ?>" class="btn-primary-glow">
                    <span><?php echo esc_html(helma_opt('header_cta_text', 'شروع آزمایش رایگان')); ?></span>
                    <span style="font-size: 0.95rem;">←</span>
                </a>

                <button type="button" class="mobile-toggle-btn" id="mobile-toggle" aria-label="<?php esc_attr_e('باز کردن منوی موبایل', 'helma'); ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </div>

        </div>
    </header>

    <!-- Mobile Drawer Overlay -->
    <div class="mobile-drawer-overlay" id="mobile-drawer-overlay">
        <div class="mobile-drawer">
            <div>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; padding-bottom:1rem; border-bottom:1px solid var(--border-subtle);">
                    <div style="display:flex; align-items:center; gap:0.5rem;">
                        <div class="brand-icon-glow" style="width:30px; height:30px; font-size:0.9rem;">H</div>
                        <span style="font-weight:800; font-size:1.1rem; color:var(--text-main);"><?php bloginfo('name'); ?></span>
                    </div>
                    <button type="button" id="close-drawer-btn" style="background:none; border:none; color:var(--text-muted); font-size:1.4rem; cursor:pointer;">✕</button>
                </div>
                
                <ul class="mobile-nav-list">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-nav-link active"><span><?php esc_html_e('صفحه اصلی', 'helma'); ?></span><span class="mobile-nav-arrow">←</span></a></li>
                    <li><a href="#simulator" class="mobile-nav-link"><span><?php esc_html_e('شبیه‌ساز هوش مصنوعی', 'helma'); ?></span><span class="mobile-nav-arrow">←</span></a></li>
                    <li><a href="#bento" class="mobile-nav-link"><span><?php esc_html_e('قابلیت‌های بنتو گرید', 'helma'); ?></span><span class="mobile-nav-arrow">←</span></a></li>
                    <li><a href="#showcase" class="mobile-nav-link"><span><?php esc_html_e('ویترین نرم‌افزار', 'helma'); ?></span><span class="mobile-nav-arrow">←</span></a></li>
                    <li><a href="#pricing" class="mobile-nav-link"><span><?php esc_html_e('پلن‌های تعرفه', 'helma'); ?></span><span class="mobile-nav-arrow">←</span></a></li>
                    <li><a href="#testimonials" class="mobile-nav-link"><span><?php esc_html_e('رضایت متخصصان', 'helma'); ?></span><span class="mobile-nav-arrow">←</span></a></li>
                    <li><a href="#blog" class="mobile-nav-link"><span><?php esc_html_e('وبلاگ تکنولوژی', 'helma'); ?></span><span class="mobile-nav-arrow">←</span></a></li>
                </ul>
            </div>

            <div style="padding-top:1.5rem; border-top:1px solid var(--border-subtle);">
                <a href="<?php echo esc_url(helma_opt('header_cta_url', '#pricing')); ?>" class="btn-primary-glow" style="width:100%; justify-content:center;">
                    <?php echo esc_html(helma_opt('header_cta_text', 'شروع آزمایش رایگان')); ?>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>
