<?php
/**
 * پنل تنظیمات پیشرفته افزونه ورود پیامکی هونا در پیشخوان وردپرس
 */

defined('ABSPATH') || exit;

class Hoona_OTP_Admin_Settings {

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'register_menu']);
        add_action('admin_init', [__CLASS__, 'register_settings']);
    }

    public static function register_menu() {
        add_menu_page(
            'تنظیمات ورود پیامکی هونا',
            'ورود پیامکی هونا',
            'manage_options',
            'hoona-otp-settings',
            [__CLASS__, 'render_settings_page'],
            'dashicons-smartphone',
            58
        );
    }

    public static function register_settings() {
        register_setting('hoona_otp_group', 'hoona_otp_options', [
            'sanitize_callback' => [__CLASS__, 'sanitize_options']
        ]);
    }

    public static function sanitize_options($input) {
        $clean = [];
        $clean['is_enabled']     = !empty($input['is_enabled']) ? 1 : 0;
        $clean['gateway']        = sanitize_text_field($input['gateway'] ?? 'test');
        $clean['api_key']        = sanitize_text_field($input['api_key'] ?? '');
        $clean['pattern_code']   = sanitize_text_field($input['pattern_code'] ?? '');
        $clean['sender_number']  = sanitize_text_field($input['sender_number'] ?? '');
        $clean['code_length']    = in_array($input['code_length'] ?? '4', ['4', '5']) ? intval($input['code_length']) : 4;
        $clean['code_expiry']    = max(60, min(300, intval($input['code_expiry'] ?? 120)));
        $clean['redirect_url']   = esc_url_raw($input['redirect_url'] ?? home_url());
        $clean['default_role']   = sanitize_text_field($input['default_role'] ?? 'customer');
        $clean['modal_title']    = sanitize_text_field($input['modal_title'] ?? 'ورود یا ثبت‌نام سریع');
        $clean['primary_color']  = sanitize_hex_color($input['primary_color'] ?? '#6366f1');
        return $clean;
    }

    public static function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        $opts = get_option('hoona_otp_options', [
            'is_enabled'    => 1,
            'gateway'       => 'test',
            'api_key'       => '',
            'pattern_code'  => '',
            'sender_number' => '',
            'code_length'   => 4,
            'code_expiry'   => 120,
            'redirect_url'  => home_url(),
            'default_role'  => 'customer',
            'modal_title'   => 'ورود یا ثبت‌نام سریع',
            'primary_color' => '#6366f1'
        ]);

        // تست ارسال پیامک تستی در صورت ارسال فرم تست
        $test_notice = '';
        if (isset($_POST['hoona_test_sms']) && check_admin_referer('hoona_test_sms_action')) {
            $test_mobile = sanitize_text_field($_POST['test_mobile'] ?? '');
            if (preg_match('/^09[0-9]{9}$/', $test_mobile)) {
                $res = Hoona_OTP_Gateway::send_code($test_mobile, '1234');
                if ($res['success']) {
                    $test_notice = '<div class="notice notice-success is-dismissible"><p><strong>نتیجه تست:</strong> ' . esc_html($res['message']) . '</p></div>';
                } else {
                    $test_notice = '<div class="notice notice-error is-dismissible"><p><strong>خطای تست:</strong> ' . esc_html($res['message']) . '</p></div>';
                }
            } else {
                $test_notice = '<div class="notice notice-warning is-dismissible"><p>شماره موبایل برای تست نامعتبر است.</p></div>';
            }
        }
        ?>
        <div class="wrap hoona-admin-wrap" dir="rtl">
            <div class="hoona-header-bar">
                <div class="hoona-title-area">
                    <span class="hoona-badge">نسخه ۱.۰.۰ — کاملاً رایگان و اوپن‌سورس</span>
                    <h1>⚡ تنظیمات پیشرفته ورود پیامکی هونا (Hoona OTP)</h1>
                    <p>طراحی و توسعه اختصاصی: <strong>علی فیروزی</strong> | شرکت هونا (<a href="https://hoonaco.ir" target="_blank">hoonaco.ir</a>)</p>
                </div>
            </div>

            <?php echo $test_notice; ?>
            <?php settings_errors(); ?>

            <div class="hoona-tabs-container">
                <nav class="hoona-nav-tabs">
                    <a href="#tab-general" class="hoona-tab-btn active">⚙️ عمومی و رفتار</a>
                    <a href="#tab-gateway" class="hoona-tab-btn">📡 درگاه‌های پیامک ایران</a>
                    <a href="#tab-appearance" class="hoona-tab-btn">🎨 ظاهر و پاپ‌آپ</a>
                    <a href="#tab-security" class="hoona-tab-btn">🛡️ امنیت و ضداسپم</a>
                    <a href="#tab-test" class="hoona-tab-btn">🧪 تست زنده ارسال</a>
                    <a href="#tab-about" class="hoona-tab-btn">ℹ️ درباره توسعه‌دهنده</a>
                </nav>

                <form method="post" action="options.php" class="hoona-form">
                    <?php settings_fields('hoona_otp_group'); ?>

                    <!-- تب ۱: عمومی -->
                    <div id="tab-general" class="hoona-tab-content active">
                        <h3>تنظیمات عمومی ورود و ثبت‌نام</h3>
                        <table class="form-table">
                            <tr>
                                <th scope="row">وضعیت کلی افزونه</th>
                                <td>
                                    <label class="hoona-switch">
                                        <input type="checkbox" name="hoona_otp_options[is_enabled]" value="1" <?php checked($opts['is_enabled'] ?? 1, 1); ?>>
                                        <span class="slider"></span>
                                    </label>
                                    <span class="description">فعال بودن ورود و ثبت‌نام با پیامک در سایت</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="hoona_redirect">آدرس هدایت پس از ورود</label></th>
                                <td>
                                    <input type="url" id="hoona_redirect" name="hoona_otp_options[redirect_url]" value="<?php echo esc_attr($opts['redirect_url']); ?>" class="regular-text" dir="ltr">
                                    <p class="description">کاربر پس از ورود موفق به این آدرس منتقل می‌شود (پیش‌فرض: صفحه اصلی سایت).</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="hoona_role">نقش کاربر جدید</label></th>
                                <td>
                                    <select id="hoona_role" name="hoona_otp_options[default_role]">
                                        <option value="customer" <?php selected($opts['default_role'], 'customer'); ?>>مشتری (ووکامرس)</option>
                                        <option value="subscriber" <?php selected($opts['default_role'], 'subscriber'); ?>>مشترک (ساده وردپرس)</option>
                                    </select>
                                    <p class="description">کاربرانی که برای اولین بار با شماره موبایل ثبت‌نام می‌کنند این نقش را خواهند داشت.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">کد کوتاه (Shortcode)</th>
                                <td>
                                    <code>[hoona_otp_button text="ورود یا ثبت‌نام با پیامک"]</code>
                                    <p class="description">می‌توانید این شورت‌کد را در هدر، فوتر، منو یا هر برگه‌ای از سایت قرار دهید.</p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- تب ۲: درگاه پیامک -->
                    <div id="tab-gateway" class="hoona-tab-content">
                        <h3>تنظیمات درگاه پیامک ایران (پترن و خط خدماتی)</h3>
                        <p class="description">برای ارسال فوق‌سریع زیر ۳ ثانیه و عبور از لیست سیاه مخابرات (بلک‌لیست)، از وب‌سرویس الگو/پترن استفاده کنید.</p>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="hoona_gateway_select">انتخاب سامانه پیامک</label></th>
                                <td>
                                    <select id="hoona_gateway_select" name="hoona_otp_options[gateway]">
                                        <option value="test" <?php selected($opts['gateway'], 'test'); ?>>🧪 حالت تست شبیه‌ساز (بدون نیاز به پیامک واقعی)</option>
                                        <option value="kavenegar" <?php selected($opts['gateway'], 'kavenegar'); ?>>کاوه نگار (Kavenegar - متد Verify Lookup)</option>
                                        <option value="ippanel" <?php selected($opts['gateway'], 'ippanel'); ?>>فراز اس‌ام‌اس / IPPanel / MaxSMS (متد Pattern)</option>
                                        <option value="melipayamak" <?php selected($opts['gateway'], 'melipayamak'); ?>>ملی پیامک (متد SendByBaseNumber)</option>
                                        <option value="smsir" <?php selected($opts['gateway'], 'smsir'); ?>>سامانه جدید SMS.ir (متد Fast Verify)</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="hoona_api_key">کلید وب‌سرویس (API Key)</label></th>
                                <td>
                                    <input type="password" id="hoona_api_key" name="hoona_otp_options[api_key]" value="<?php echo esc_attr($opts['api_key']); ?>" class="large-text" dir="ltr" placeholder="مثلاً: 356472483829472...">
                                    <p class="description">کلید دریافتی از پنل پیامکی خود را اینجا وارد نمایید.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="hoona_pattern">کد الگو / پترن (Pattern Code)</label></th>
                                <td>
                                    <input type="text" id="hoona_pattern" name="hoona_otp_options[pattern_code]" value="<?php echo esc_attr($opts['pattern_code']); ?>" class="regular-text" dir="ltr" placeholder="مثلاً: verify یا 12485">
                                    <p class="description">کد قالبی که در پنل پیامک با متغیر <code>%token%</code> یا <code>{code}</code> تایید کرده‌اید.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="hoona_sender">شماره اختصاصی فرستنده (اختیاری)</label></th>
                                <td>
                                    <input type="text" id="hoona_sender" name="hoona_otp_options[sender_number]" value="<?php echo esc_attr($opts['sender_number']); ?>" class="regular-text" dir="ltr" placeholder="+983000505">
                                    <p class="description">مخصوص خط خدماتی اشتراکی یا اختصاصی آی‌پی‌پنل/فراز اس‌ام‌اس.</p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- تب ۳: ظاهر و استایل -->
                    <div id="tab-appearance" class="hoona-tab-content">
                        <h3>سفارشی‌سازی ظاهر پاپ‌آپ ورود</h3>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="hoona_modal_title">عنوان پنجره ورود</label></th>
                                <td>
                                    <input type="text" id="hoona_modal_title" name="hoona_otp_options[modal_title]" value="<?php echo esc_attr($opts['modal_title']); ?>" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="hoona_primary_color">رنگ سازمانی و دکمه‌ها</label></th>
                                <td>
                                    <input type="color" id="hoona_primary_color" name="hoona_otp_options[primary_color]" value="<?php echo esc_attr($opts['primary_color']); ?>">
                                    <span class="description">کد رنگ اصلی پنجره و دکمه‌های ورود</span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- تب ۴: امنیت -->
                    <div id="tab-security" class="hoona-tab-content">
                        <h3>تنظیمات امنیت، ضداسپم و اکسپایر</h3>
                        <table class="form-table">
                            <tr>
                                <th scope="row">طول کد تایید پیامکی</th>
                                <td>
                                    <label><input type="radio" name="hoona_otp_options[code_length]" value="4" <?php checked($opts['code_length'], 4); ?>> ۴ رقم (پیشنهادی و سریع‌تر برای کاربر)</label><br>
                                    <label><input type="radio" name="hoona_otp_options[code_length]" value="5" <?php checked($opts['code_length'], 5); ?>> ۵ رقم</label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="hoona_expiry">مدت اعتبار کد (ثانیه)</label></th>
                                <td>
                                    <input type="number" id="hoona_expiry" name="hoona_otp_options[code_expiry]" value="<?php echo esc_attr($opts['code_expiry']); ?>" min="60" max="300" step="10">
                                    <span class="description">پیش‌فرض: ۱۲۰ ثانیه (۲ دقیقه). تا پایان این زمان امکان ارسال مجدد وجود ندارد.</span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <p class="submit">
                        <button type="submit" class="button button-primary button-hero">💾 ذخیره تغییرات تنظیمات</button>
                    </p>
                </form>

                <!-- تب ۵: تست زنده -->
                <div id="tab-test" class="hoona-tab-content">
                    <h3>🧪 تست زنده ارسال پیامک</h3>
                    <p>جهت اطمینان از صحت کلید API و کد پترن، شماره موبایل خود را وارد کرده و دکمه تست را بزنید:</p>
                    <form method="post" action="">
                        <?php wp_nonce_field('hoona_test_sms_action'); ?>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="test_mobile">شماره همراه تست:</label></th>
                                <td>
                                    <input type="tel" id="test_mobile" name="test_mobile" placeholder="09123456789" class="regular-text" dir="ltr" required>
                                </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <button type="submit" name="hoona_test_sms" value="1" class="button button-secondary">🚀 ارسال پیامک تستی</button>
                        </p>
                    </form>
                </div>

                <!-- تب ۶: درباره توسعه دهنده -->
                <div id="tab-about" class="hoona-tab-content">
                    <div class="hoona-dev-card">
                        <h2>شرکت هوشمندسازی و وب هونا (Hoona)</h2>
                        <p>این افزونه با بالاترین استانداردهای امنیتی وردپرس (OWASP)، بدون هیچ‌گونه قفل لایسنس، بدون ionCube و با کدنویسی تمیز و بهینه جهت خدمت به جامعه وب‌مسترهای ایرانی توسعه داده شده است.</p>
                        <ul>
                            <li>👨‍💻 <strong>توسعه‌دهنده:</strong> مهندس علی فیروزی</li>
                            <li>🌐 <strong>وب‌سایت رسمی:</strong> <a href="https://hoonaco.ir" target="_blank" rel="noopener">hoonaco.ir</a></li>
                            <li>📦 <strong>مجوز:</strong> نرم‌افزار آزاد و اوپن‌سورس (GPLv2+)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.hoona-tab-btn');
            const contents = document.querySelectorAll('.hoona-tab-content');
            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    tabs.forEach(t => t.classList.remove('active'));
                    contents.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) target.classList.add('active');
                });
            });
        });
        </script>

        <style>
        .hoona-admin-wrap { max-width: 1050px; margin-top: 25px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        .hoona-header-bar { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #fff; padding: 24px 30px; border-radius: 14px; margin-bottom: 25px; box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4); }
        .hoona-header-bar h1 { color: #fff; margin: 8px 0; font-size: 22px; font-weight: 800; }
        .hoona-header-bar p { margin: 0; color: #e0e7ff; }
        .hoona-header-bar a { color: #fff; text-decoration: underline; }
        .hoona-badge { background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .hoona-tabs-container { background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; overflow: hidden; }
        .hoona-nav-tabs { display: flex; background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 0 15px; }
        .hoona-tab-btn { padding: 14px 18px; text-decoration: none; color: #475569; font-weight: 600; font-size: 14px; border-bottom: 3px solid transparent; transition: all 0.2s; }
        .hoona-tab-btn:hover { color: #4f46e5; }
        .hoona-tab-btn.active { color: #4f46e5; border-bottom-color: #4f46e5; background: #fff; }
        .hoona-tab-content { display: none; padding: 25px 30px; }
        .hoona-tab-content.active { display: block; }
        .hoona-dev-card { background: #f1f5f9; border-right: 4px solid #4f46e5; padding: 20px; border-radius: 8px; }
        .hoona-switch { position: relative; display: inline-block; width: 44px; height: 24px; vertical-align: middle; margin-left: 10px; }
        .hoona-switch input { opacity: 0; width: 0; height: 0; }
        .hoona-switch .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .3s; border-radius: 24px; }
        .hoona-switch .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .3s; border-radius: 50%; }
        .hoona-switch input:checked + .slider { background-color: #4f46e5; }
        .hoona-switch input:checked + .slider:before { transform: translateX(20px); }
        </style>
        <?php
    }
}

Hoona_OTP_Admin_Settings::init();
