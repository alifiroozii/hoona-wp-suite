<?php
/**
 * Plugin Name: سبد خرید شناور هونا | Hoona Slide Cart
 * Plugin URI: https://hoonaco.ir
 * Description: افزونه حرفه‌ای سبد خرید کشویی و شناور ایجکس (Ajax Drawer Cart) ووکامرس به همراه نوار پیشرفت ارسال رایگان، اعمال کد تخفیف آنی، پیشنهاد محصولات مکمل و پرداخت سریع.
 * Version: 1.0.0
 * Author: علی فیروزی (شرکت هونا)
 * Author URI: https://hoonaco.ir
 * Text Domain: hoona-cart
 * Domain Path: /languages
 * License: GPL v2 or later
 */

defined('ABSPATH') || exit;

define('HOONA_CART_VERSION', '1.0.0');
define('HOONA_CART_PATH', plugin_dir_path(__FILE__));
define('HOONA_CART_URL', plugin_dir_url(__FILE__));

require_once HOONA_CART_PATH . 'includes/class-hoona-cart-ajax.php';
if (is_admin()) {
    require_once HOONA_CART_PATH . 'includes/admin-settings.php';
}

class Hoona_Slide_Cart {
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
        add_action('wp_footer', [$this, 'render_drawer_and_launcher']);
        add_shortcode('hoona_cart_launcher', [$this, 'shortcode_launcher']);
    }

    public function init_plugin() {
        load_plugin_textdomain('hoona-cart', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    public function enqueue_assets() {
        wp_enqueue_style('hoona-cart-css', HOONA_CART_URL . 'assets/css/hoona-cart.css', [], HOONA_CART_VERSION);
        wp_enqueue_script('hoona-cart-js', HOONA_CART_URL . 'assets/js/hoona-cart.js', ['jquery'], HOONA_CART_VERSION, true);

        $opts = get_option('hoona_cart_options', []);
        $threshold = !empty($opts['free_shipping_min']) ? floatval($opts['free_shipping_min']) : 500000;
        $currency = function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : 'تومان';

        wp_localize_script('hoona-cart-js', 'hoona_cart_params', [
            'ajax_url'            => admin_url('admin-ajax.php'),
            'nonce'               => wp_create_nonce('hoona_cart_nonce_action'),
            'free_shipping_limit' => $threshold,
            'currency_symbol'     => $currency,
            'auto_open'           => !empty($opts['auto_open']) ? 1 : 0,
            'checkout_url'        => function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout'),
            'cart_url'            => function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart')
        ]);
    }

    /**
     * رندر دکمه شناور و کشوی سبد خرید در فوتر
     */
    public function render_drawer_and_launcher() {
        $opts = get_option('hoona_cart_options', [
            'is_enabled'        => 1,
            'launcher_position' => 'bottom-right',
            'drawer_position'   => 'right',
            'free_shipping_min' => 500000,
            'free_shipping_txt' => 'تنها {amount} تا ارسال رایگان باقی مانده است!',
            'free_shipping_done'=> '🎉 تبریک! سفارش شما شامل ارسال رایگان شد.'
        ]);

        if (empty($opts['is_enabled'])) {
            return;
        }

        $count = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
        $launcher_pos = esc_attr($opts['launcher_position'] ?? 'bottom-right');
        $drawer_pos   = esc_attr($opts['drawer_position'] ?? 'right');
        ?>
        <!-- آیکون شناور سبد خرید -->
        <button type="button" id="hoona-cart-launcher-btn" class="hoona-floating-cart <?php echo $launcher_pos; ?>" aria-label="مشاهده سبد خرید">
            <span class="hoona-cart-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </span>
            <span id="hoona-cart-counter" class="hoona-badge-count"><?php echo esc_html($count); ?></span>
        </button>

        <!-- پس‌زمینه تیره کشو -->
        <div id="hoona-cart-drawer-overlay" class="hoona-drawer-overlay"></div>

        <!-- کشوی کناری شناور -->
        <div id="hoona-slide-cart-panel" class="hoona-slide-cart <?php echo $drawer_pos; ?>" role="dialog" aria-modal="true">
            <div class="hoona-cart-header">
                <div class="hoona-header-title">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    <h3>سبد خرید شما (<span id="hoona-header-count"><?php echo esc_html($count); ?></span>)</h3>
                </div>
                <button type="button" id="hoona-cart-close-btn" class="hoona-close-btn" aria-label="بستن سبد">&times;</button>
            </div>

            <!-- نوار پیشرفت ارسال رایگان -->
            <div class="hoona-shipping-bar-container">
                <div class="hoona-shipping-text" id="hoona-shipping-status">در حال محاسبه ارسال رایگان...</div>
                <div class="hoona-progress-track">
                    <div class="hoona-progress-fill" id="hoona-shipping-progress" style="width: 0%;"></div>
                </div>
            </div>

            <!-- لیست اقلام سبد خرید -->
            <div class="hoona-cart-items-wrapper" id="hoona-cart-items-list">
                <!-- قطعات سبد خرید از طریق ایجکس بارگذاری می‌شوند -->
                <div class="hoona-empty-cart">
                    <div class="hoona-empty-icon">🛍️</div>
                    <p>سبد خرید شما در حال حاضر خالی است.</p>
                </div>
            </div>

            <!-- فوتر کشو: کد تخفیف، جمع کل و دکمه پرداخت سریع -->
            <div class="hoona-cart-footer" id="hoona-cart-footer-area">
                <!-- فیلد کد تخفیف -->
                <div class="hoona-coupon-row">
                    <input type="text" id="hoona-coupon-input" placeholder="کد تخفیف دارید؟" dir="ltr" />
                    <button type="button" id="hoona-coupon-btn">اعمال</button>
                </div>
                <div id="hoona-coupon-message" class="hoona-coupon-msg" style="display: none;"></div>

                <!-- مبالغ -->
                <div class="hoona-summary-row">
                    <span>مبلغ کل سبد خرید:</span>
                    <strong id="hoona-cart-subtotal">۰ تومان</strong>
                </div>

                <!-- دکمه‌های اقدام -->
                <div class="hoona-action-buttons">
                    <a href="<?php echo function_exists('wc_get_checkout_url') ? esc_url(wc_get_checkout_url()) : '#'; ?>" id="hoona-btn-checkout" class="hoona-btn-checkout-primary">
                        <span>تسویه‌حساب سریع</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="hoona-cart-branding">
                    طراحی اختصاصی: <a href="https://hoonaco.ir" target="_blank" rel="noopener">هونا (علی فیروزی)</a>
                </div>
            </div>
        </div>
        <?php
    }

    public function shortcode_launcher($atts) {
        return '<button type="button" class="hoona-cart-trigger-btn hoona-open-cart-panel">🛒 مشاهده سبد خرید</button>';
    }
}

Hoona_Slide_Cart::instance();
