<?php
/**
 * Helma Theme Functions and Definitions
 *
 * Fully hardened for security (OWASP Top 10 & WordPress Security Standards)
 * Author & Developer: علی فیروزی (شرکت هونا hoonaco.ir)
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

if (!function_exists('helma_setup')) :
    function helma_setup() {
        load_theme_textdomain('helma', get_template_directory() . '/languages');

        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');

        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(800, 480, true);
        add_image_size('helma-card', 640, 360, true);
        add_image_size('helma-hero', 1200, 600, true);

        register_nav_menus(array(
            'primary' => esc_html__('منوی ناوبری اصلی هدر', 'helma'),
            'footer'  => esc_html__('منوی پیوندهای فوتر', 'helma'),
        ));

        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));

        add_theme_support('custom-logo', array(
            'height'      => 60,
            'width'       => 220,
            'flex-width'  => true,
            'flex-height' => true,
        ));

        add_theme_support('responsive-embeds');
        add_theme_support('align-wide');
    }
endif;
add_action('after_setup_theme', 'helma_setup');

/**
 * =========================================================================
 * 🛡️ SECURITY HARDENING LAYER (OWASP Security Directives)
 * =========================================================================
 */

// 1. HTTP Security Headers
function helma_send_security_headers() {
    if (helma_opt('enable_sec_headers', 1) && !headers_sent()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
    }
}
add_action('send_headers', 'helma_send_security_headers');

// 2. Prevent WordPress Version Fingerprinting
if (helma_opt('hide_wp_version', 1)) {
    remove_action('wp_head', 'wp_generator');
    add_filter('the_generator', '__return_empty_string');

    function helma_remove_ver_css_js($src) {
        if (strpos($src, 'ver=')) {
            $src = remove_query_arg('ver', $src);
        }
        return $src;
    }
    add_filter('style_loader_src', 'helma_remove_ver_css_js', 9999);
    add_filter('script_loader_src', 'helma_remove_ver_css_js', 9999);
}

// 3. Block User Enumeration Attacks (?author=1)
function helma_block_user_enumeration() {
    if (helma_opt('block_user_enum', 1) && !is_admin() && isset($_REQUEST['author'])) {
        wp_die(
            esc_html__('دسترسی به این منبع به دلایل امنیتی مسدود شده است.', 'helma'),
            esc_html__('خطای امنیتی', 'helma'),
            array('response' => 403)
        );
    }
}
add_action('init', 'helma_block_user_enumeration');

// 4. Disable XML-RPC Pingback Attacks
function helma_disable_xmlrpc_pingback($methods) {
    if (helma_opt('disable_xmlrpc_ping', 1)) {
        unset($methods['pingback.ping']);
    }
    return $methods;
}
add_filter('xmlrpc_methods', 'helma_disable_xmlrpc_pingback');

/**
 * =========================================================================
 * Enqueue Scripts and Styles
 * =========================================================================
 */
function helma_scripts() {
    wp_enqueue_style(
        'helma-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        '1.0.0'
    );

    $glow_primary   = sanitize_hex_color(helma_opt('glow_primary', '#8b5cf6'));
    $glow_secondary = sanitize_hex_color(helma_opt('glow_secondary', '#06b6d4'));

    $custom_css = "
        :root {
            --glow-primary: " . esc_attr($glow_primary) . ";
            --glow-secondary: " . esc_attr($glow_secondary) . ";
        }
    ";

    $user_custom_css = helma_opt('custom_css', '');
    if (!empty($user_custom_css)) {
        $custom_css .= "\n/* User Custom CSS */\n" . wp_strip_all_tags($user_custom_css) . "\n";
    }
    wp_add_inline_style('helma-main', $custom_css);

    wp_enqueue_script(
        'helma-main-js',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '1.0.0',
        true
    );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'helma_scripts');

/**
 * Custom Head and Footer Scripts
 */
function helma_output_custom_head_scripts() {
    $head_js = helma_opt('custom_head_js', '');
    if (!empty($head_js)) {
        echo $head_js . "\n";
    }
}
add_action('wp_head', 'helma_output_custom_head_scripts', 99);

function helma_output_custom_footer_scripts() {
    $footer_js = helma_opt('custom_footer_js', '');
    if (!empty($footer_js)) {
        echo $footer_js . "\n";
    }
}
add_action('wp_footer', 'helma_output_custom_footer_scripts', 99);

/**
 * Load Modules
 */
require get_template_directory() . '/inc/admin-options.php';
require get_template_directory() . '/inc/meta-boxes.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/template-tags.php';
