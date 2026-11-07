<?php
/**
 * موتور کش فوق‌سریع برگه رحیل (Page Cache Engine)
 */

defined('ABSPATH') || exit;

class Rahil_Cache_Engine {

    public static function init() {
        $opts = get_option('rahil_options', []);
        if (empty($opts['enable_cache'])) return;

        add_action('template_redirect', [__CLASS__, 'start_caching'], 1);
    }

    public static function get_cache_dir() {
        return WP_CONTENT_DIR . '/cache/rahil/';
    }

    public static function start_caching() {
        if (is_user_logged_in() || is_admin() || $_SERVER['REQUEST_METHOD'] !== 'GET') {
            return;
        }

        // بررسی ووکامرس (عدم کش سبد خرید و تسویه‌حساب)
        if (function_exists('is_cart') && (is_cart() || is_checkout() || is_account_page())) {
            return;
        }

        $cache_file = self::get_cache_file_path();
        if (file_exists($cache_file)) {
            $opts = get_option('rahil_options', []);
            $lifespan = !empty($opts['cache_lifespan']) ? intval($opts['cache_lifespan']) * 3600 : 86400;

            if (time() - filemtime($cache_file) < $lifespan) {
                header('X-Rahil-Cache: HIT (Powered by Hoona)');
                readfile($cache_file);
                exit;
            }
        }

        ob_start([__CLASS__, 'save_cache']);
    }

    public static function get_cache_file_path() {
        $url_hash = md5(!empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'home');
        return self::get_cache_dir() . $url_hash . '.html';
    }

    public static function save_cache($buffer) {
        if (empty($buffer) || strlen($buffer) < 200) {
            return $buffer;
        }

        $dir = self::get_cache_dir();
        if (!is_dir($dir)) {
            wp_mkdir_p($dir);
        }

        $cache_file = self::get_cache_file_path();
        $footer_note = "\n<!-- ⚡ Cached by Rahil Speed Pro (https://hoonaco.ir) at " . date('Y-m-d H:i:s') . " -->";
        file_put_contents($cache_file, $buffer . $footer_note);

        header('X-Rahil-Cache: MISS (Cached Now)');
        return $buffer;
    }

    public static function purge_all() {
        $dir = self::get_cache_dir();
        if (is_dir($dir)) {
            $files = glob($dir . '*');
            foreach ($files as $file) {
                if (is_file($file)) unlink($file);
            }
        }
    }
}

Rahil_Cache_Engine::init();
