<?php
/**
 * توابع پوسته آگهی و دایرکتوری املاک امین (Amin Theme)
 * توسعه‌دهنده: علی فیروزی - شرکت هونا (hoonaco.ir)
 */

defined('ABSPATH') || exit;

define('AMIN_VERSION', '1.0.0');
define('AMIN_DIR', get_template_directory());
define('AMIN_URI', get_template_directory_uri());

require_once AMIN_DIR . '/inc/admin-options.php';
require_once AMIN_DIR . '/inc/meta-boxes.php';

function amin_theme_setup() {
    load_theme_textdomain('amin', AMIN_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

    register_nav_menus([
        'primary' => 'منوی بالای سایت امین',
        'footer'  => 'منوی فوتر امین'
    ]);
}
add_action('after_setup_theme', 'amin_theme_setup');

/**
 * ثبت پست تایپ آگهی‌ها و املاک
 */
function amin_register_listing_cpt() {
    $labels = [
        'name'          => 'آگهی‌ها و املاک',
        'singular_name' => 'آگهی',
        'add_new'       => 'ثبت آگهی جدید',
        'add_new_item'  => 'افزودن آگهی جدید',
        'edit_item'     => 'ویرایش آگهی',
        'all_items'     => 'همه آگهی‌ها',
        'menu_name'     => '🏢 املاک و آگهی امین'
    ];

    register_post_type('listing', [
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'listings'],
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'menu_icon'     => 'dashicons-building',
        'show_in_rest'  => true,
    ]);

    // دسته‌بندی آگهی (آپارتمان، ویلا، اداری، زمین...)
    register_taxonomy('listing_cat', 'listing', [
        'labels'        => ['name' => 'نوع ملک و آگهی', 'singular_name' => 'نوع ملک'],
        'hierarchical'  => true,
        'show_in_rest'  => true,
        'rewrite'       => ['slug' => 'listing-cat'],
    ]);

    // شهرهای آگهی
    register_taxonomy('listing_city', 'listing', [
        'labels'        => ['name' => 'شهرها و استان‌ها', 'singular_name' => 'شهر'],
        'hierarchical'  => true,
        'show_in_rest'  => true,
        'rewrite'       => ['slug' => 'city'],
    ]);
}
add_action('init', 'amin_register_listing_cpt');

function amin_enqueue_assets() {
    wp_enqueue_style('amin-main-style', AMIN_URI . '/assets/css/main.css', [], AMIN_VERSION);
    wp_enqueue_script('amin-main-script', AMIN_URI . '/assets/js/main.js', ['jquery'], AMIN_VERSION, true);

    wp_localize_script('amin-main-script', 'amin_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('amin_nonce_action')
    ]);
}
add_action('wp_enqueue_scripts', 'amin_enqueue_assets');
