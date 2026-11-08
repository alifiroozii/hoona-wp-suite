<?php
/**
 * Nikan Medical & Clinic Theme functions and definitions
 *
 * @package Nikan
 */

if (!defined('ABSPATH')) {
    exit;
}

define('NIKAN_VERSION', '1.0.0');
define('NIKAN_DIR', get_template_directory());
define('NIKAN_URI', get_template_directory_uri());

function nikan_setup() {
    load_theme_textdomain('nikan', NIKAN_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 220,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ]);

    register_nav_menus([
        'primary' => esc_html__('منوی اصلی کلینیک', 'nikan'),
        'footer'  => esc_html__('منوی فوتر', 'nikan'),
    ]);
}
add_action('after_setup_theme', 'nikan_setup');

function nikan_scripts() {
    // Main stylesheet
    wp_enqueue_style('nikan-style', get_stylesheet_uri(), [], NIKAN_VERSION);
    wp_enqueue_style('nikan-main', NIKAN_URI . '/assets/css/main.css', [], NIKAN_VERSION);
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', [], '6.4.0');

    // Main JavaScript
    wp_enqueue_script('nikan-main', NIKAN_URI . '/assets/js/main.js', ['jquery'], NIKAN_VERSION, true);

    // Pass AJAX and Nonce
    wp_localize_script('nikan-main', 'nikanData', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('nikan_booking_nonce'),
        'success' => esc_html__('نوبت شما با موفقیت ثبت شد. کد پیگیری به شماره موبایل شما پیامک می‌شود.', 'nikan'),
        'error'   => esc_html__('خطایی در ثبت نوبت رخ داد. لطفاً مجدداً تلاش فرمایید.', 'nikan')
    ]);
}
add_action('wp_enqueue_scripts', 'nikan_scripts');

// Include Modules
require_once NIKAN_DIR . '/inc/admin-options.php';
require_once NIKAN_DIR . '/inc/meta-boxes.php';
require_once NIKAN_DIR . '/inc/booking-handler.php';
