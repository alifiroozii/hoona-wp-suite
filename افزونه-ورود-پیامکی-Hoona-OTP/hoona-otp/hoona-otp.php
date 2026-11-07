<?php
/**
 * Plugin Name: ورود پیامکی هونا | Hoona OTP Login
 * Plugin URI: https://hoonaco.ir
 * Description: افزونه حرفه‌ای، سبک و رایگان ورود و ثبت‌نام سریع با شماره موبایل و کد یکبار مصرف (SMS OTP) سازگار با ووکامرس و خطوط خدماتی ایران (کاوه نگار، فراز اس ام اس، ملی پیامک، sms.ir).
 * Version: 1.0.0
 * Author: علی فیروزی (شرکت هونا)
 * Author URI: https://hoonaco.ir
 * Text Domain: hoona-otp
 * Domain Path: /languages
 * License: GPL v2 or later
 */

defined('ABSPATH') || exit;

define('HOONA_OTP_VERSION', '1.0.0');
define('HOONA_OTP_PATH', plugin_dir_path(__FILE__));
define('HOONA_OTP_URL', plugin_dir_url(__FILE__));

// لود ماژول‌های اصلی
require_once HOONA_OTP_PATH . 'includes/class-hoona-otp-gateway.php';
require_once HOONA_OTP_PATH . 'includes/class-hoona-otp-auth.php';
if (is_admin()) {
    require_once HOONA_OTP_PATH . 'includes/admin-settings.php';
}

/**
 * کلاس اصلی راه‌انداز افزونه هونا او‌تی‌پی
 */
class Hoona_OTP_Plugin {
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
        add_action('wp_footer', [$this, 'render_modal_in_footer']);
        add_shortcode('hoona_otp_button', [$this, 'shortcode_login_button']);
        add_shortcode('hoona_otp_form', [$this, 'shortcode_inline_form']);
        
        // ادغام با ووکامرس
        add_action('woocommerce_before_customer_login_form', [$this, 'render_woocommerce_notice']);
    }

    public function init_plugin() {
        load_plugin_textdomain('hoona-otp', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    public function enqueue_assets() {
        wp_enqueue_style('hoona-otp-css', HOONA_OTP_URL . 'assets/css/hoona-otp.css', [], HOONA_OTP_VERSION);
        wp_enqueue_script('hoona-otp-js', HOONA_OTP_URL . 'assets/js/hoona-otp.js', ['jquery'], HOONA_OTP_VERSION, true);

        $settings = get_option('hoona_otp_options', []);
        $timer = !empty($settings['code_expiry']) ? intval($settings['code_expiry']) : 120;
        $primary_color = !empty($settings['primary_color']) ? sanitize_hex_color($settings['primary_color']) : '#6366f1';

        wp_localize_script('hoona-otp-js', 'hoona_otp_params', [
            'ajax_url'   => admin_url('admin-ajax.php'),
            'nonce'      => wp_create_nonce('hoona_otp_nonce_action'),
            'timer'      => $timer,
            'is_logged'  => is_user_logged_in(),
            'redirect'   => !empty($settings['redirect_url']) ? esc_url($settings['redirect_url']) : home_url(),
            'messages'   => [
                'invalid_phone'  => 'شماره موبایل وارد شده معتبر نیست (مثال: 09123456789)',
                'code_sent'      => 'کد تایید ۴ رقمی ارسال شد. لطفاً آن را وارد کنید.',
                'verify_success' => 'ورود با موفقیت انجام شد! در حال انتقال...',
                'rate_limit'     => 'تعداد تلاش بیش از حد مجاز است. لطفاً چند دقیقه صبر کنید.',
                'empty_code'     => 'لطفاً کد تایید دریافت شده را وارد نمایید.',
                'server_error'   => 'خطایی رخ داد. لطفاً مجدداً تلاش کنید.'
            ]
        ]);
    }

    /**
     * رندر پنجره پاپ‌آپ شیشه‌ای در فوتر
     */
    public function render_modal_in_footer() {
        if (is_user_logged_in()) {
            return;
        }
        $settings = get_option('hoona_otp_options', []);
        $modal_title = !empty($settings['modal_title']) ? esc_html($settings['modal_title']) : 'ورود یا ثبت‌نام سریع';
        $site_name = get_bloginfo('name');
        ?>
        <div id="hoona-otp-modal-overlay" class="hoona-otp-overlay" style="display: none;">
            <div class="hoona-otp-modal" role="dialog" aria-modal="true">
                <button type="button" class="hoona-otp-close" id="hoona-otp-close-btn" aria-label="بستن">&times;</button>
                
                <div class="hoona-otp-header">
                    <div class="hoona-otp-logo-badge">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <h3 class="hoona-otp-title"><?php echo $modal_title; ?></h3>
                    <p class="hoona-otp-subtitle">کد تایید یکبار مصرف به شماره موبایل شما ارسال خواهد شد.</p>
                </div>

                <!-- مرحله ۱: دریافت شماره موبایل -->
                <div id="hoona-step-phone" class="hoona-step active">
                    <form id="hoona-otp-phone-form" onsubmit="return false;">
                        <div class="hoona-field-group">
                            <label for="hoona_user_phone">شماره تلفن همراه</label>
                            <div class="hoona-input-wrapper">
                                <input type="tel" id="hoona_user_phone" name="phone" placeholder="09xxxxxxxxx" maxlength="11" dir="ltr" autocomplete="tel" required />
                                <span class="hoona-input-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                                </span>
                            </div>
                        </div>

                        <div id="hoona-phone-error" class="hoona-alert error" style="display: none;"></div>

                        <button type="button" id="hoona-btn-send-code" class="hoona-submit-btn">
                            <span class="btn-text">ارسال کد ورود</span>
                            <span class="btn-loader" style="display: none;"></span>
                        </button>
                    </form>
                </div>

                <!-- مرحله ۲: وارد کردن کد تایید -->
                <div id="hoona-step-verify" class="hoona-step" style="display: none;">
                    <form id="hoona-otp-verify-form" onsubmit="return false;">
                        <div class="hoona-verify-info">
                            <span>کد به شماره <strong id="hoona-display-phone" dir="ltr">09...</strong> ارسال شد.</span>
                            <button type="button" id="hoona-btn-change-phone" class="hoona-link-btn">ویرایش شماره</button>
                        </div>

                        <div class="hoona-field-group">
                            <label for="hoona_otp_code">کد تایید ۴ یا ۵ رقمی</label>
                            <div class="hoona-input-wrapper">
                                <input type="text" id="hoona_otp_code" name="code" placeholder="••••" maxlength="6" dir="ltr" inputmode="numeric" autocomplete="one-time-code" required />
                                <span class="hoona-input-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                </span>
                            </div>
                        </div>

                        <!-- فیلد نام در صورت ثبت نام جدید (اختیاری) -->
                        <div id="hoona-extra-fields" class="hoona-field-group" style="display: none;">
                            <label for="hoona_user_fullname">نام و نام خانوادگی (اختیاری)</label>
                            <div class="hoona-input-wrapper">
                                <input type="text" id="hoona_user_fullname" name="fullname" placeholder="مثلاً: علی فیروزی" />
                            </div>
                        </div>

                        <div class="hoona-timer-wrap">
                            <span id="hoona-timer-text">امکان ارسال مجدد کد تا: <strong id="hoona-countdown">02:00</strong></span>
                            <button type="button" id="hoona-btn-resend" class="hoona-link-btn" style="display: none;">ارسال مجدد کد</button>
                        </div>

                        <div id="hoona-verify-error" class="hoona-alert error" style="display: none;"></div>
                        <div id="hoona-verify-success" class="hoona-alert success" style="display: none;"></div>

                        <button type="button" id="hoona-btn-submit-verify" class="hoona-submit-btn">
                            <span class="btn-text">تایید و ورود به حساب</span>
                            <span class="btn-loader" style="display: none;"></span>
                        </button>
                    </form>
                </div>

                <div class="hoona-otp-footer">
                    <span>طراحی و توسعه: <a href="https://hoonaco.ir" target="_blank" rel="noopener">هونا (علی فیروزی)</a></span>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * شورت‌کد نمایش دکمه باز شدن پاپ‌آپ
     */
    public function shortcode_login_button($atts) {
        if (is_user_logged_in()) {
            return '<a href="' . wp_logout_url(home_url()) . '" class="hoona-btn-outline">خروج از حساب</a>';
        }
        $atts = shortcode_atts([
            'text'  => 'ورود / عضویت سریع با پیامک',
            'class' => 'hoona-trigger-btn'
        ], $atts);

        return sprintf(
            '<button type="button" class="%s hoona-open-otp-modal">%s</button>',
            esc_attr($atts['class']),
            esc_html($atts['text'])
        );
    }

    /**
     * پیام بالای صفحه ورود ووکامرس
     */
    public function render_woocommerce_notice() {
        echo '<div class="hoona-wc-notice">';
        echo '<span>ورود بدون نیاز به رمز عبور: </span>';
        echo '<button type="button" class="hoona-open-otp-modal hoona-btn-small">ورود سریع با پیامک (OTP)</button>';
        echo '</div>';
    }
}

Hoona_OTP_Plugin::instance();
