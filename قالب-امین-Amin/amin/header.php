<?php
/**
 * هدر پوسته آگهی و املاک امین
 */
defined('ABSPATH') || exit;
$opts = get_option('amin_options', []);
$title = !empty($opts['site_title']) ? esc_html($opts['site_title']) : get_bloginfo('name');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="amin-navbar">
    <div class="amin-nav-container">
        <div class="amin-logo-wrap">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="amin-brand">
                <span class="amin-brand-icon">🏢</span>
                <span class="amin-brand-title"><?php echo $title; ?></span>
            </a>
            <span class="amin-city-badge">📍 <?php echo !empty($opts['default_city']) ? esc_html($opts['default_city']) : 'تهران'; ?></span>
        </div>

        <nav class="amin-nav-links">
            <a href="#listings">آگهی‌های فوری</a>
            <a href="#map">نقشه محله‌ها</a>
            <a href="#about">درباره امین</a>
        </nav>

        <div class="amin-nav-actions">
            <button type="button" class="amin-btn-add-listing" id="open-listing-modal">
                <span>➕ ثبت رایگان آگهی</span>
            </button>
        </div>
    </div>
</header>
