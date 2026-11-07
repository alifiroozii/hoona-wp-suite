<?php
/**
 * پنل تنظیمات پیشرفته افزونه فاکتور و برچسب پستی میثم
 */

defined('ABSPATH') || exit;

class Meysam_Invoice_Admin_Settings {

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'register_menu']);
        add_action('admin_init', [__CLASS__, 'register_settings']);
    }

    public static function register_menu() {
        add_menu_page(
            'تنظیمات فاکتور میثم',
            '🧾 فاکتور میثم',
            'manage_options',
            'meysam-invoice-settings',
            [__CLASS__, 'render_settings_page'],
            'dashicons-media-document',
            56
        );
    }

    public static function register_settings() {
        register_setting('meysam_inv_group', 'meysam_inv_options', [
            'sanitize_callback' => [__CLASS__, 'sanitize_options']
        ]);
    }

    public static function sanitize_options($input) {
        $clean = [];
        $clean['seller_name']     = sanitize_text_field($input['seller_name'] ?? get_bloginfo('name'));
        $clean['seller_phone']    = sanitize_text_field($input['seller_phone'] ?? '');
        $clean['seller_economic'] = sanitize_text_field($input['seller_economic'] ?? '');
        $clean['seller_national'] = sanitize_text_field($input['seller_national'] ?? '');
        $clean['seller_postcode'] = sanitize_text_field($input['seller_postcode'] ?? '');
        $clean['seller_address']  = sanitize_textarea_field($input['seller_address'] ?? '');
        $clean['tax_percent']     = floatval($input['tax_percent'] ?? 9);
        $clean['default_tpl']     = sanitize_text_field($input['default_tpl'] ?? 'standard');
        return $clean;
    }

    public static function render_settings_page() {
        if (!current_user_can('manage_options')) return;

        $opts = get_option('meysam_inv_options', [
            'seller_name'     => get_bloginfo('name'),
            'seller_phone'    => '021-88889999',
            'seller_economic' => '4111223344',
            'seller_national' => '1010203040',
            'seller_postcode' => '1998877665',
            'seller_address'  => 'تهران، میدان ونک، خیابان ملاصدرا، پلاک ۱۰۰',
            'tax_percent'     => 9,
            'default_tpl'     => 'standard'
        ]);
        ?>
        <div class="wrap meysam-wrap" dir="rtl">
            <div class="meysam-header">
                <span class="meysam-badge">نسخه ۱.۰.۰ — فاکتور رسمی و برچسب پستی</span>
                <h1>🧾 تنظیمات فاکتور پیشرفته ووکامرس میثم (Meysam Invoice)</h1>
                <p>توسعه‌دهنده رسمی: <strong>مهندس علی فیروزی</strong> | شرکت هونا (<a href="https://hoonaco.ir" target="_blank">hoonaco.ir</a>)</p>
            </div>

            <?php settings_errors(); ?>

            <div class="meysam-container">
                <nav class="meysam-tabs">
                    <a href="#tab-seller" class="meysam-tab-btn active">🏢 مشخصات فروشنده و دارایی</a>
                    <a href="#tab-template" class="meysam-tab-btn">🧾 قالب فاکتور و مالیات</a>
                    <a href="#tab-post" class="meysam-tab-btn">📦 برچسب پستی و تیپاکس</a>
                    <a href="#tab-thermal" class="meysam-tab-btn">🖨️ فیش حرارتی ۸ سانتی</a>
                    <a href="#tab-about" class="meysam-tab-btn">ℹ️ درباره هونا</a>
                </nav>

                <form method="post" action="options.php" class="meysam-form">
                    <?php settings_fields('meysam_inv_group'); ?>

                    <div id="tab-seller" class="meysam-content active">
                        <table class="form-table">
                            <tr>
                                <th>نام فروشگاه یا شرکت</th>
                                <td><input type="text" name="meysam_inv_options[seller_name]" value="<?php echo esc_attr($opts['seller_name']); ?>" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th>کد اقتصادی (اختیاری)</th>
                                <td><input type="text" name="meysam_inv_options[seller_economic]" value="<?php echo esc_attr($opts['seller_economic']); ?>" class="regular-text" dir="ltr"></td>
                            </tr>
                            <tr>
                                <th>شناسه ملی / کد ملی</th>
                                <td><input type="text" name="meysam_inv_options[seller_national]" value="<?php echo esc_attr($opts['seller_national']); ?>" class="regular-text" dir="ltr"></td>
                            </tr>
                            <tr>
                                <th>کد پستی فرستنده</th>
                                <td><input type="text" name="meysam_inv_options[seller_postcode]" value="<?php echo esc_attr($opts['seller_postcode']); ?>" class="regular-text" dir="ltr"></td>
                            </tr>
                            <tr>
                                <th>تلفن تماس فروشگاه</th>
                                <td><input type="text" name="meysam_inv_options[seller_phone]" value="<?php echo esc_attr($opts['seller_phone']); ?>" class="regular-text" dir="ltr"></td>
                            </tr>
                            <tr>
                                <th>نشانی کامل فروشگاه</th>
                                <td><textarea name="meysam_inv_options[seller_address]" rows="3" class="large-text"><?php echo esc_textarea($opts['seller_address']); ?></textarea></td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-template" class="meysam-content">
                        <table class="form-table">
                            <tr>
                                <th>قالب پیش‌فرض فاکتور</th>
                                <td>
                                    <select name="meysam_inv_options[default_tpl]">
                                        <option value="standard" <?php selected($opts['default_tpl'], 'standard'); ?>>فاکتور مدرن دیجی‌کالایی (A4 / A5 با بارکد و QR)</option>
                                        <option value="tax" <?php selected($opts['default_tpl'], 'tax'); ?>>فاکتور رسمی استاندارد اداره دارایی و مالیات</option>
                                        <option value="thermal" <?php selected($opts['default_tpl'], 'thermal'); ?>>فیش حرارتی ۸ سانتی‌متری (فیش‌پرینتر)</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>درصد مالیات بر ارزش افزوده (VAT)</th>
                                <td><input type="number" name="meysam_inv_options[tax_percent]" value="<?php echo esc_attr($opts['tax_percent']); ?>" step="0.5" class="small-text"> درصد</td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-post" class="meysam-content">
                        <table class="form-table">
                            <tr>
                                <th>چاپ بارکد سفارش روی برچسب پستی</th>
                                <td><label><input type="checkbox" checked> درج بارکد استاندارد جهت اسکن توسط مامور پست</label></td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-thermal" class="meysam-content">
                        <table class="form-table">
                            <tr>
                                <th>عرض کاغذ فیش‌پرینتر</th>
                                <td><label><input type="radio" checked> ۸۰ میلی‌متر (استاندارد رستورانی و انبارداری)</label></td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-about" class="meysam-content">
                        <div style="background:#f1f5f9; padding:20px; border-radius:10px; line-height:1.8;">
                            <h3>شرکت هوشمندسازی و وب هونا</h3>
                            <p>افزونه میثم با هدف رفع نیاز حیاتی فروشگاه‌های ایرانی به چاپ فاکتور قانونی، فیش انبار و برچسب پستی به صورت ۱۰۰٪ رایگان و آزاد منتشر شده است.</p>
                            <p>👨‍💻 <strong>توسعه‌دهنده:</strong> مهندس علی فیروزی | 🌐 <a href="https://hoonaco.ir" target="_blank">hoonaco.ir</a></p>
                        </div>
                    </div>

                    <p class="submit">
                        <button type="submit" class="button button-primary button-hero">💾 ذخیره تنظیمات فاکتور میثم</button>
                    </p>
                </form>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.meysam-tab-btn');
            const contents = document.querySelectorAll('.meysam-content');
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
        .meysam-wrap { max-width: 1050px; margin-top: 25px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        .meysam-header { background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%); color:#fff; padding:24px 30px; border-radius:14px; margin-bottom:25px; box-shadow:0 10px 25px -5px rgba(20, 184, 166, 0.4); }
        .meysam-header h1 { color:#fff; margin:8px 0; font-size:22px; font-weight:800; }
        .meysam-header p { margin:0; color:#ccfbf1; font-size:13px; }
        .meysam-header a { color:#fff; text-decoration:underline; font-weight:700; }
        .meysam-badge { background:rgba(255,255,255,0.2); padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600; display:inline-block; }
        .meysam-container { background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; }
        .meysam-tabs { display:flex; background:#f8fafc; border-bottom:1px solid #e2e8f0; padding:0 15px; }
        .meysam-tab-btn { padding:14px 18px; text-decoration:none; color:#475569; font-weight:600; font-size:13.5px; border-bottom:3px solid transparent; }
        .meysam-tab-btn:hover { color:#0f766e; }
        .meysam-tab-btn.active { color:#0f766e; border-bottom-color:#0f766e; background:#fff; }
        .meysam-content { display:none; padding:25px 30px; }
        .meysam-content.active { display:block; }
        </style>
        <?php
    }
}

Meysam_Invoice_Admin_Settings::init();
