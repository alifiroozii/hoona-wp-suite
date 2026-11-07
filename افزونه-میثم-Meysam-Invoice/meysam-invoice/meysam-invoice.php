<?php
/**
 * Plugin Name: فاکتور و برچسب پستی میثم | Meysam Invoice Pro
 * Plugin URI: https://hoonaco.ir
 * Description: افزونه صدور فاکتور رسمی دارایی ووکامرس، فاکتور مدرن دیجی‌کالایی با بارکد و QR کد، پرینت حرارتی فیش‌پرینتر ۸ سانتی‌متری و چاپ برچسب پستی پست و تیپاکس.
 * Version: 1.0.0
 * Author: مهندس علی فیروزی (شرکت هونا)
 * Author URI: https://hoonaco.ir
 * Text Domain: meysam-invoice
 * License: GPL v2 or later
 */

defined('ABSPATH') || exit;

define('MEYSAM_INV_VERSION', '1.0.0');
define('MEYSAM_INV_PATH', plugin_dir_path(__FILE__));
define('MEYSAM_INV_URL', plugin_dir_url(__FILE__));

require_once MEYSAM_INV_PATH . 'includes/class-meysam-generator.php';
if (is_admin()) {
    require_once MEYSAM_INV_PATH . 'includes/admin-settings.php';
}

class Meysam_Invoice_Plugin {
    private static $instance = null;

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', [$this, 'init_plugin']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);

        // اضافه کردن دکمه‌های چاپ در ستون سفارشات ووکامرس
        add_filter('woocommerce_admin_order_actions', [$this, 'add_order_actions'], 10, 2);
        
        // هندلر نمایش و چاپ فاکتور
        add_action('admin_init', [$this, 'handle_print_action']);
    }

    public function init_plugin() {
        load_plugin_textdomain('meysam-invoice', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    public function enqueue_assets() {
        wp_enqueue_style('meysam-inv-print', MEYSAM_INV_URL . 'assets/css/invoice-print.css', [], MEYSAM_INV_VERSION);
    }

    public function enqueue_admin_assets() {
        wp_enqueue_style('meysam-inv-print', MEYSAM_INV_URL . 'assets/css/invoice-print.css', [], MEYSAM_INV_VERSION);
    }

    public function add_order_actions($actions, $order) {
        $order_id = $order->get_id();
        $actions['meysam_print_invoice'] = [
            'url'    => wp_nonce_url(admin_url('admin-ajax.php?action=meysam_print&type=standard&order_id=' . $order_id), 'meysam_print_nonce'),
            'name'   => 'چاپ فاکتور میثم',
            'action' => 'view print-invoice',
        ];
        $actions['meysam_print_label'] = [
            'url'    => wp_nonce_url(admin_url('admin-ajax.php?action=meysam_print&type=label&order_id=' . $order_id), 'meysam_print_nonce'),
            'name'   => 'چاپ برچسب پستی',
            'action' => 'view print-label',
        ];
        return $actions;
    }

    public function handle_print_action() {
        if (isset($_GET['action']) && $_GET['action'] === 'meysam_print' && isset($_GET['order_id'])) {
            check_admin_referer('meysam_print_nonce');
            $order_id = intval($_GET['order_id']);
            $type = sanitize_text_field($_GET['type'] ?? 'standard');
            Meysam_Invoice_Generator::render_print_page($order_id, $type);
            exit;
        }
    }
}

Meysam_Invoice_Plugin::instance();
