<?php
/**
 * فایل اصلی توابع پوسته آموزشی صدرا (Sadra Theme)
 * توسعه‌دهنده: علی فیروزی - شرکت هونا (hoonaco.ir)
 */

defined('ABSPATH') || exit;

define('SADRA_VERSION', '1.0.0');
define('SADRA_DIR', get_template_directory());
define('SADRA_URI', get_template_directory_uri());

require_once SADRA_DIR . '/inc/admin-options.php';
require_once SADRA_DIR . '/inc/meta-boxes.php';

function sadra_theme_setup() {
    load_theme_textdomain('sadra', SADRA_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height'      => 70,
        'width'       => 220,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    register_nav_menus([
        'primary' => 'منوی اصلی بالای آکادمی',
        'footer'  => 'منوی پیوندهای فوتر'
    ]);
}
add_action('after_setup_theme', 'sadra_theme_setup');

/**
 * ثبت پست تایپ اختصاصی دوره‌های آموزشی
 */
function sadra_register_course_cpt() {
    $labels = [
        'name'               => 'دوره‌های آموزشی',
        'singular_name'      => 'دوره آموزشی',
        'add_new'            => 'افزودن دوره جدید',
        'add_new_item'       => 'افزودن دوره آموزشی جدید',
        'edit_item'          => 'ویرایش دوره آموزشی',
        'all_items'          => 'همه دوره‌ها',
        'search_items'       => 'جستجوی دوره‌ها',
        'menu_name'          => '📚 آکادمی صدرا'
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'courses'],
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'comments'],
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'show_in_rest'       => true,
    ];

    register_post_type('course', $args);

    // دسته‌بندی دوره‌ها
    register_taxonomy('course_cat', 'course', [
        'labels' => [
            'name'          => 'دسته‌بندی دوره‌ها',
            'singular_name' => 'دسته دوره',
        ],
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'course-cat'],
    ]);
}
add_action('init', 'sadra_register_course_cpt');

/**
 * لود استایل‌ها و اسکریپت‌ها
 */
function sadra_enqueue_assets() {
    wp_enqueue_style('sadra-main-style', SADRA_URI . '/assets/css/main.css', [], SADRA_VERSION);
    wp_enqueue_script('sadra-main-script', SADRA_URI . '/assets/js/main.js', ['jquery'], SADRA_VERSION, true);

    wp_localize_script('sadra-main-script', 'sadra_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('sadra_theme_nonce')
    ]);
}
add_action('wp_enqueue_scripts', 'sadra_enqueue_assets');
