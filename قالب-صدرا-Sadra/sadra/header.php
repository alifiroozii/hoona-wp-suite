<?php
/**
 * هدر پوسته آموزشی صدرا
 */
defined('ABSPATH') || exit;
$opts = get_option('sadra_options', []);
$academy_name = !empty($opts['academy_name']) ? esc_html($opts['academy_name']) : get_bloginfo('name');
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

<header class="sadra-navbar">
    <div class="sadra-nav-container">
        <div class="sadra-logo-wrap">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="sadra-brand">
                <span class="sadra-brand-badge">S</span>
                <span class="sadra-brand-text"><?php echo $academy_name; ?></span>
            </a>
        </div>

        <nav class="sadra-nav-menu">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'sadra-menu-list',
                    'fallback_cb'    => false,
                ]);
            } else {
                echo '<ul class="sadra-menu-list">
                    <li><a href="' . esc_url(home_url('/')) . '">صفحه اصلی</a></li>
                    <li><a href="#courses">دوره‌های آموزشی</a></li>
                    <li><a href="#instructors">اساتید</a></li>
                    <li><a href="#about">درباره آکادمی</a></li>
                </ul>';
            }
            ?>
        </nav>

        <div class="sadra-header-actions">
            <a href="#courses" class="sadra-btn-primary">🎓 ورود به دوره‌ها</a>
        </div>
    </div>
</header>
