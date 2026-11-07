<?php
/**
 * Plugin Name: شتاب‌دهنده موشکی و کش رحیل | Rahil Speed Pro
 * Plugin URI: https://hoonaco.ir
 * Description: افزونه رایگان و فوق‌سریع بهینه‌سازی سرعت وردپرس، کش صفحات، تبدیل خودکار تصاویر به WebP، پیش‌بارگذاری فونت‌های فارسی و فشرده‌سازی CSS/JS (جایگزین WP Rocket).
 * Version: 1.0.0
 * Author: مهندس علی فیروزی (شرکت هونا)
 * Author URI: https://hoonaco.ir
 * Text Domain: rahil-speed
 * License: GPL v2 or later
 */

defined('ABSPATH') || exit;

define('RAHIL_SPEED_VERSION', '1.0.0');
define('RAHIL_SPEED_PATH', plugin_dir_path(__FILE__));
define('RAHIL_SPEED_URL', plugin_dir_url(__FILE__));

require_once RAHIL_SPEED_PATH . 'includes/class-rahil-cache.php';
require_once RAHIL_SPEED_PATH . 'includes/class-rahil-optimizer.php';
if (is_admin()) {
    require_once RAHIL_SPEED_PATH . 'includes/admin-settings.php';
}

class Rahil_Speed_Plugin {
    private static $instance = null;

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', [$this, 'init_plugin']);
        add_action('admin_bar_menu', [$this, 'add_clear_cache_button'], 100);
        add_action('wp_ajax_rahil_purge_cache', [$this, 'ajax_purge_cache']);
    }

    public function init_plugin() {
        load_plugin_textdomain('rahil-speed', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    public function add_clear_cache_button($wp_admin_bar) {
        if (!current_user_can('manage_options')) return;

        $wp_admin_bar->add_node([
            'id'    => 'rahil_clear_cache',
            'title' => '⚡ پاک‌سازی کش رحیل',
            'href'  => wp_nonce_url(admin_url('admin-ajax.php?action=rahil_purge_cache'), 'rahil_purge_nonce'),
            'meta'  => ['title' => 'پاک‌سازی فوری تمام صفحات کش‌شده سایت']
        ]);
    }

    public function ajax_purge_cache() {
        check_admin_referer('rahil_purge_nonce');
        Rahil_Cache_Engine::purge_all();
        wp_safe_redirect(wp_get_referer() ?: admin_url());
        exit;
    }
}

Rahil_Speed_Plugin::instance();
