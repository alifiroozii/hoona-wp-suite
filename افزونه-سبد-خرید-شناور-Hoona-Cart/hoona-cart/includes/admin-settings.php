<?php
/**
 * پنل تنظیمات پیشرفته افزونه سبد خرید شناور هونا در پیشخوان وردپرس
 */

defined('ABSPATH') || exit;

class Hoona_Cart_Admin_Settings {

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'register_menu']);
        add_action('admin_init', [__CLASS__, 'register_settings']);
    }

    public static function register_menu() {
        add_menu_page(
            'تنظیمات سبد خرید شناور هونا',
            'سبد خرید هونا',
            'manage_options',
            'hoona-cart-settings',
            [__CLASS__, 'render_settings_page'],
            'dashicons-cart',
            59
        );
    }

    public static function register_settings() {
        register_setting('hoona_cart_group', 'hoona_cart_options', [
            'sanitize_callback' => [__CLASS__, 'sanitize_options']
        ]);
    }

    public static function sanitize_options($input) {
        $clean = [];
        $clean['is_enabled']        = !empty($input['is_enabled']) ? 1 : 0;
        $clean['auto_open']         = !empty($input['auto_open']) ? 1 : 0;
        $clean['launcher_position'] = in_array($input['launcher_position'] ?? 'bottom-right', ['bottom-right', 'bottom-left']) ? $input['launcher_position'] : 'bottom-right';
        $clean['drawer_position']   = in_array($input['drawer_position'] ?? 'right', ['right', 'left']) ? $input['drawer_position'] : 'right';
        $clean['free_shipping_min'] = floatval($input['free_shipping_min'] ?? 500000);
        $clean['free_shipping_txt'] = sanitize_text_field($input['free_shipping_txt'] ?? 'تنها {amount} تا ارسال رایگان باقی مانده است!');
        $clean['free_shipping_done']= sanitize_text_field($input['free_shipping_done'] ?? '🎉 تبریک! سفارش شما شامل ارسال رایگان شد.');
        $clean['primary_color']     = sanitize_hex_color($input['primary_color'] ?? '#10b981');
        return $clean;
    }

    public static function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        $opts = get_option('hoona_cart_options', [
            'is_enabled'        => 1,
            'auto_open'         => 1,
            'launcher_position' => 'bottom-right',
            'drawer_position'   => 'right',
            'free_shipping_min' => 500000,
            'free_shipping_txt' => 'تنها {amount} تا ارسال رایگان باقی مانده است!',
            'free_shipping_done'=> '🎉 تبریک! سفارش شما شامل ارسال رایگان شد.',
            'primary_color'     => '#10b981'
        ]);
        ?>
        <div class="wrap hoona-admin-wrap" dir="rtl">
            <div class="hoona-header-bar">
                <div class="hoona-title-area">
                    <span class="hoona-badge">نسخه ۱.۰.۰ — رایگان، بدون لایسنس و فوق‌سریع</span>
                    <h1>🛒 تنظیمات سبد خرید شناور و تسویه‌حساب سریع هونا</h1>
                    <p>طراحی و توسعه اختصاصی: <strong>علی فیروزی</strong> | شرکت هونا (<a href="https://hoonaco.ir" target="_blank">hoonaco.ir</a>)</p>
                </div>
            </div>

            <?php settings_errors(); ?>

            <div class="hoona-tabs-container">
                <nav class="hoona-nav-tabs">
                    <a href="#tab-cart-general" class="hoona-tab-btn active">⚙️ عمومی و رفتار</a>
                    <a href="#tab-cart-shipping" class="hoona-tab-btn">🚚 نوار ارسال رایگان</a>
                    <a href="#tab-cart-appearance" class="hoona-tab-btn">🎨 ظاهر و رنگ‌بندی</a>
                    <a href="#tab-cart-about" class="hoona-tab-btn">ℹ️ درباره هونا</a>
                </nav>

                <form method="post" action="options.php" class="hoona-form">
                    <?php settings_fields('hoona_cart_group'); ?>

                    <!-- تب ۱: عمومی -->
                    <div id="tab-cart-general" class="hoona-tab-content active">
                        <h3>تنظیمات عمومی کشوی سبد خرید</h3>
                        <table class="form-table">
                            <tr>
                                <th scope="row">فعال بودن سبد شناور</th>
                                <td>
                                    <label class="hoona-switch">
                                        <input type="checkbox" name="hoona_cart_options[is_enabled]" value="1" <?php checked($opts['is_enabled'] ?? 1, 1); ?>>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">باز شدن خودکار کشو</th>
                                <td>
                                    <label class="hoona-switch">
                                        <input type="checkbox" name="hoona_cart_options[auto_open]" value="1" <?php checked($opts['auto_open'] ?? 1, 1); ?>>
                                        <span class="slider"></span>
                                    </label>
                                    <span class="description">با کلیک کاربر روی «افزودن به سبد خرید»، کشو فوراً باز شود بدون اینکه صفحه رفرش شود.</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">موقعیت دکمه شناور</th>
                                <td>
                                    <select name="hoona_cart_options[launcher_position]">
                                        <option value="bottom-right" <?php selected($opts['launcher_position'], 'bottom-right'); ?>>پایین، گوشه راست صفحه</option>
                                        <option value="bottom-left" <?php selected($opts['launcher_position'], 'bottom-left'); ?>>پایین، گوشه چپ صفحه</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">جهت باز شدن کشو</th>
                                <td>
                                    <select name="hoona_cart_options[drawer_position]">
                                        <option value="right" <?php selected($opts['drawer_position'], 'right'); ?>>از سمت راست (استاندارد زبان فارسی RTL)</option>
                                        <option value="left" <?php selected($opts['drawer_position'], 'left'); ?>>از سمت چپ</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- تب ۲: نوار ارسال رایگان -->
                    <div id="tab-cart-shipping" class="hoona-tab-content">
                        <h3>تنظیمات نوار پیشرفت هوشمند ارسال رایگان</h3>
                        <p class="description">این ویژگی نرخ سبد خرید مشتری را به طور چشمگیری افزایش می‌دهد.</p>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="hoona_ship_min">حداقل مبلغ ارسال رایگان (تومان)</label></th>
                                <td>
                                    <input type="number" id="hoona_ship_min" name="hoona_cart_options[free_shipping_min]" value="<?php echo esc_attr($opts['free_shipping_min']); ?>" step="10000" class="regular-text">
                                    <p class="description">مثال: ۵۰۰,۰۰۰ تومان</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="hoona_ship_txt">پیام انگیزشی قبل از تکمیل</label></th>
                                <td>
                                    <input type="text" id="hoona_ship_txt" name="hoona_cart_options[free_shipping_txt]" value="<?php echo esc_attr($opts['free_shipping_txt']); ?>" class="large-text">
                                    <p class="description">متغیر <code>{amount}</code> به صورت خودکار با مبلغ باقیمانده جایگزین می‌شود.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="hoona_ship_done">پیام تبریک پس از رسیدن به سقف</label></th>
                                <td>
                                    <input type="text" id="hoona_ship_done" name="hoona_cart_options[free_shipping_done]" value="<?php echo esc_attr($opts['free_shipping_done']); ?>" class="large-text">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- تب ۳: ظاهر -->
                    <div id="tab-cart-appearance" class="hoona-tab-content">
                        <h3>سفارشی‌سازی ظاهر و رنگ‌بندی کشو</h3>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="hoona_cart_color">رنگ اصلی دکمه تسویه‌حساب و نوار پیشرفت</label></th>
                                <td>
                                    <input type="color" id="hoona_cart_color" name="hoona_cart_options[primary_color]" value="<?php echo esc_attr($opts['primary_color']); ?>">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- تب ۴: درباره -->
                    <div id="tab-cart-about" class="hoona-tab-content">
                        <div class="hoona-dev-card">
                            <h2>افزونه سبد خرید شناور هونا (Hoona Cart)</h2>
                            <p>طراحی شده برای افزایش نرخ تبدیل (Conversion Rate) فروشگاه‌های ووکامرسی فارسی، با سریع‌ترین انیمیشن‌های روان و تجربه کاربری بدون اصطکاک.</p>
                            <ul>
                                <li>👨‍💻 <strong>توسعه‌دهنده:</strong> مهندس علی فیروزی</li>
                                <li>🌐 <strong>وب‌سایت رسمی:</strong> <a href="https://hoonaco.ir" target="_blank" rel="noopener">hoonaco.ir</a></li>
                                <li>📦 <strong>مجوز:</strong> نرم‌افزار آزاد و رایگان (GPLv2+)</li>
                            </ul>
                        </div>
                    </div>

                    <p class="submit">
                        <button type="submit" class="button button-primary button-hero">💾 ذخیره تغییرات تنظیمات سبد خرید</button>
                    </p>
                </form>
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
        .hoona-header-bar { background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: #fff; padding: 24px 30px; border-radius: 14px; margin-bottom: 25px; box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4); }
        .hoona-header-bar h1 { color: #fff; margin: 8px 0; font-size: 22px; font-weight: 800; }
        .hoona-header-bar p { margin: 0; color: #d1fae5; }
        .hoona-header-bar a { color: #fff; text-decoration: underline; font-weight: 700; }
        .hoona-badge { background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
        .hoona-tabs-container { background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; overflow: hidden; }
        .hoona-nav-tabs { display: flex; background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 0 15px; }
        .hoona-tab-btn { padding: 14px 18px; text-decoration: none; color: #475569; font-weight: 600; font-size: 14px; border-bottom: 3px solid transparent; transition: all 0.2s; }
        .hoona-tab-btn:hover { color: #10b981; }
        .hoona-tab-btn.active { color: #059669; border-bottom-color: #059669; background: #fff; }
        .hoona-tab-content { display: none; padding: 25px 30px; }
        .hoona-tab-content.active { display: block; }
        .hoona-dev-card { background: #f0fdf4; border-right: 4px solid #10b981; padding: 20px; border-radius: 8px; }
        .hoona-switch { position: relative; display: inline-block; width: 44px; height: 24px; vertical-align: middle; margin-left: 10px; }
        .hoona-switch input { opacity: 0; width: 0; height: 0; }
        .hoona-switch .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .3s; border-radius: 24px; }
        .hoona-switch .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .3s; border-radius: 50%; }
        .hoona-switch input:checked + .slider { background-color: #10b981; }
        .hoona-switch input:checked + .slider:before { transform: translateX(20px); }
        </style>
        <?php
    }
}

Hoona_Cart_Admin_Settings::init();
