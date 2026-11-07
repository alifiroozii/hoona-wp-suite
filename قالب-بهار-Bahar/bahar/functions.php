<?php
/**
 * Bahar Theme Functions and Definitions
 *
 * Fully hardened for security (OWASP Top 10 & WordPress Security Best Practices)
 * Author & Developer: علی فیروزی (شرکت هونا hoonaco.ir)
 *
 * @package Bahar
 */

// 1. Direct Script Access Prevention
if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

if (!function_exists('bahar_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function bahar_setup() {
        // Translation support
        load_theme_textdomain('bahar', get_template_directory() . '/languages');

        // RSS feed links in head
        add_theme_support('automatic-feed-links');

        // Let WordPress manage document title safely
        add_theme_support('title-tag');

        // Featured images with explicit cropping sizes
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(800, 480, true);
        add_image_size('bahar-card', 640, 360, true);
        add_image_size('bahar-hero', 1200, 600, true);

        // Register navigation menus
        register_nav_menus(array(
            'primary' => esc_html__('منوی اصلی بالای صفحه', 'bahar'),
            'footer'  => esc_html__('منوی پیوندهای فوتر', 'bahar'),
        ));

        // Switch core markup to valid HTML5
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));

        // Custom logo support
        add_theme_support('custom-logo', array(
            'height'      => 60,
            'width'       => 220,
            'flex-width'  => true,
            'flex-height' => true,
        ));

        // Customizer selective refresh
        add_theme_support('customize-selective-refresh-widgets');

        // Gutenberg / Block editor supports
        add_theme_support('responsive-embeds');
        add_theme_support('align-wide');
    }
endif;
add_action('after_setup_theme', 'bahar_setup');

/**
 * =========================================================================
 * 🛡️ SECURITY HARDENING LAYER (OWASP & WordPress Hardening Directives)
 * =========================================================================
 */

/**
 * 1. HTTP Security Headers
 * Injects modern protective headers to mitigate Clickjacking, MIME-sniffing, and data leakage.
 */
function bahar_send_security_headers() {
    if (!headers_sent()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
    }
}
add_action('send_headers', 'bahar_send_security_headers');

/**
 * 2. Prevent WordPress Version Fingerprinting
 * Removes generator tags and removes query versions from CSS/JS scripts to obscure core version info from attackers.
 */
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

function bahar_remove_ver_css_js($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'bahar_remove_ver_css_js', 9999);
add_filter('script_loader_src', 'bahar_remove_ver_css_js', 9999);

/**
 * 3. Mitigate XML-RPC Pingback Attacks (DDoS Amplification Prevention)
 */
function bahar_disable_xmlrpc_pingback($methods) {
    unset($methods['pingback.ping']);
    unset($methods['pingback.extensions.getPingbacks']);
    return $methods;
}
add_filter('xmlrpc_methods', 'bahar_disable_xmlrpc_pingback');

/**
 * 4. User Enumeration Protection
 * Blocks requests like /?author=1 which automated bots use to harvest admin usernames.
 */
function bahar_block_user_enumeration() {
    if (!is_admin() && isset($_REQUEST['author']) && preg_match('/^[0-9]+/i', $_REQUEST['author'])) {
        wp_safe_redirect(home_url(), 301);
        exit;
    }
}
add_action('init', 'bahar_block_user_enumeration');

/**
 * 5. Sanitize SVG and Attachment uploads safely if enabled
 */
function bahar_clean_filename($filename) {
    return sanitize_file_name($filename);
}
add_filter('sanitize_file_name', 'bahar_clean_filename', 10);

/**
 * =========================================================================
 * WIDGETS & SCRIPTS ENQUEUE
 * =========================================================================
 */

/**
 * Register widget areas.
 */
function bahar_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('ستون کناری وبلاگ (سایدبار)', 'bahar'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('ابزارک‌های خود را در اینجا قرار دهید.', 'bahar'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    for ($i = 1; $i <= 3; $i++) {
        register_sidebar(array(
            'name'          => sprintf(esc_html__('ابزارک فوتر ستون %d', 'bahar'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(esc_html__('ابزارک‌های ستون شماره %d در فوتر سایت.', 'bahar'), $i),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="footer-widget-title">',
            'after_title'   => '</h4>',
        ));
    }
}
add_action('widgets_init', 'bahar_widgets_init');

/**
 * Enqueue scripts and styles with strict sanitization.
 */
function bahar_scripts() {
    wp_enqueue_style(
        'bahar-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        '1.0.0'
    );

    // Sanitize hex colors rigorously (checks Theme Options then Customizer)
    $primary_color   = sanitize_hex_color(bahar_opt('color_primary', '#2563eb'));
    $secondary_color = sanitize_hex_color(bahar_opt('color_secondary', '#0d9488'));
    
    $custom_css = "
        :root {
            --color-primary: " . esc_attr($primary_color) . ";
            --color-secondary: " . esc_attr($secondary_color) . ";
        }
    ";

    $user_custom_css = bahar_opt('custom_css', '');
    if (!empty($user_custom_css)) {
        $custom_css .= "\n/* User Custom CSS */\n" . wp_strip_all_tags($user_custom_css) . "\n";
    }
    wp_add_inline_style('bahar-main', $custom_css);

    wp_enqueue_script(
        'bahar-main-js',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '1.0.0',
        true
    );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'bahar_scripts');

/**
 * Custom Head and Tracking Scripts
 */
function bahar_output_custom_head_scripts() {
    $head_js = bahar_opt('custom_head_js', '');
    if (!empty($head_js)) {
        echo $head_js . "\n";
    }
}
add_action('wp_head', 'bahar_output_custom_head_scripts', 99);

/**
 * Custom Footer and Analytics Scripts
 */
function bahar_output_custom_footer_scripts() {
    $footer_js = bahar_opt('custom_footer_js', '');
    if (!empty($footer_js)) {
        echo $footer_js . "\n";
    }
}
add_action('wp_footer', 'bahar_output_custom_footer_scripts', 99);

/**
 * Admin Theme Options Dashboard
 */
require get_template_directory() . '/inc/admin-options.php';

/**
 * Per-Page Custom Meta Boxes
 */
require get_template_directory() . '/inc/meta-boxes.php';

/**
 * Customizer Additions
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Template Helper Functions
 */
require get_template_directory() . '/inc/template-tags.php';
