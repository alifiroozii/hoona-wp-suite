<?php
/**
 * پنل تنظیمات پیشرفته پوسته امین (Amin Theme Options)
 * توسعه‌دهنده: علی فیروزی - شرکت هونا (hoonaco.ir)
 */

defined('ABSPATH') || exit;

class Amin_Admin_Options {

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'add_admin_menu']);
        add_action('admin_init', [__CLASS__, 'register_settings']);
    }

    public static function add_admin_menu() {
        add_menu_page(
            'تنظیمات قالب امین',
            '⚡ تنظیمات امین',
            'manage_options',
            'amin-theme-options',
            [__CLASS__, 'render_options_page'],
            'dashicons-building',
            58
        );
    }

    public static function register_settings() {
        register_setting('amin_options_group', 'amin_options', [
            'sanitize_callback' => [__CLASS__, 'sanitize_options']
        ]);
    }

    public static function sanitize_options($input) {
        $clean = [];
        $clean['site_title']     = sanitize_text_field($input['site_title'] ?? 'سامانه هوشمند املاک و آگهی امین');
        $clean['hero_heading']   = sanitize_text_field($input['hero_heading'] ?? 'جستجو و ثبت رایگان آگهی ملک و املاک در سراسر ایران');
        $clean['default_city']   = sanitize_text_field($input['default_city'] ?? 'تهران');
        $clean['auto_approve']   = !empty($input['auto_approve']) ? 1 : 0;
        $clean['max_images']     = intval($input['max_images'] ?? 6);
        $clean['primary_color']  = sanitize_hex_color($input['primary_color'] ?? '#ea580c');
        $clean['support_tel']    = sanitize_text_field($input['support_tel'] ?? '021-77889900');
        $clean['footer_about']   = sanitize_text_field($input['footer_about'] ?? 'سامانه جامع معاملات و نیازمندی‌های املاک با مجوز رسمی.');
        return $clean;
    }

    public static function render_options_page() {
        if (!current_user_can('manage_options')) return;

        $opts = get_option('amin_options', [
            'site_title'    => 'سامانه هوشمند املاک و آگهی امین',
            'hero_heading'  => 'جستجو و ثبت رایگان آگهی ملک و املاک در سراسر ایران',
            'default_city'  => 'تهران',
            'auto_approve'  => 1,
            'max_images'    => 6,
            'primary_color' => '#ea580c',
            'support_tel'   => '021-77889900',
            'footer_about'  => 'سامانه جامع معاملات و نیازمندی‌های املاک با مجوز رسمی.'
        ]);
        ?>
        <div class="wrap amin-wrap" dir="rtl">
            <div class="amin-header">
                <span class="amin-badge">پوسته رسمی نیازمندی‌ها و املاک امین v1.0.0</span>
                <h1>🏢 تنظیمات پیشرفته سامانه آگهی و املاک امین (Amin)</h1>
                <p>توسعه‌یافته توسط: <strong>مهندس علی فیروزی</strong> | شرکت هونا (<a href="https://hoonaco.ir" target="_blank">hoonaco.ir</a>)</p>
            </div>

            <?php settings_errors(); ?>

            <div class="amin-container">
                <nav class="amin-tabs">
                    <a href="#tab-general" class="amin-tab-btn active">⚙️ عمومی و هدر</a>
                    <a href="#tab-search" class="amin-tab-btn">🔍 فیلترهای جستجو</a>
                    <a href="#tab-submission" class="amin-tab-btn">📝 فرم ثبت آگهی</a>
                    <a href="#tab-appearance" class="amin-tab-btn">🎨 ظاهر و برند</a>
                    <a href="#tab-about" class="amin-tab-btn">ℹ️ درباره هونا</a>
                </nav>

                <form method="post" action="options.php" class="amin-form">
                    <?php settings_fields('amin_options_group'); ?>

                    <div id="tab-general" class="amin-content active">
                        <table class="form-table">
                            <tr>
                                <th>عنوان سایت و برند</th>
                                <td><input type="text" name="amin_options[site_title]" value="<?php echo esc_attr($opts['site_title']); ?>" class="large-text"></td>
                            </tr>
                            <tr>
                                <th>تیتر هیرو جستجو</th>
                                <td><input type="text" name="amin_options[hero_heading]" value="<?php echo esc_attr($opts['hero_heading']); ?>" class="large-text"></td>
                            </tr>
                            <tr>
                                <th>شهر پیش‌فرض</th>
                                <td><input type="text" name="amin_options[default_city]" value="<?php echo esc_attr($opts['default_city']); ?>" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th>شماره تماس پشتیبانی</th>
                                <td><input type="text" name="amin_options[support_tel]" value="<?php echo esc_attr($opts['support_tel']); ?>" class="regular-text" dir="ltr"></td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-search" class="amin-content">
                        <table class="form-table">
                            <tr>
                                <th>فیلترهای فعال در باکس جستجو</th>
                                <td>
                                    <label><input type="checkbox" checked disabled> انتخاب نوع معامله (خرید/رهن و اجاره)</label><br>
                                    <label><input type="checkbox" checked disabled> انتخاب شهر و محله</label><br>
                                    <label><input type="checkbox" checked disabled> حداقل و حداکثر متراژ</label><br>
                                    <label><input type="checkbox" checked disabled> رنج قیمت و ودیعه</label>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-submission" class="amin-content">
                        <table class="form-table">
                            <tr>
                                <th>تایید خودکار آگهی‌ها</th>
                                <td>
                                    <label><input type="checkbox" name="amin_options[auto_approve]" value="1" <?php checked($opts['auto_approve'] ?? 1, 1); ?>> انتشار فوری آگهی کاربران بدون نیاز به بازبینی مدیر</label>
                                </td>
                            </tr>
                            <tr>
                                <th>حداکثر تصاویر مجاز هر آگهی</th>
                                <td><input type="number" name="amin_options[max_images]" value="<?php echo esc_attr($opts['max_images']); ?>" min="1" max="15"></td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-appearance" class="amin-content">
                        <table class="form-table">
                            <tr>
                                <th>رنگ سازمانی و دکمه ثبت آگهی</th>
                                <td><input type="color" name="amin_options[primary_color]" value="<?php echo esc_attr($opts['primary_color']); ?>"></td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-about" class="amin-content">
                        <div style="background:#f1f5f9; padding:20px; border-radius:10px; line-height:1.8;">
                            <h3>شرکت هوشمندسازی و وب هونا</h3>
                            <p>پوسته امین یک سیستم جامع و ارگونومیک برای راه‌اندازی دایرکتوری‌های املاک، نیازمندی‌ها و آگهی در وب فارسی است.</p>
                            <p>👨‍💻 <strong>توسعه‌دهنده:</strong> مهندس علی فیروزی | 🌐 <a href="https://hoonaco.ir" target="_blank">hoonaco.ir</a></p>
                        </div>
                    </div>

                    <p class="submit">
                        <button type="submit" class="button button-primary button-hero">💾 ذخیره تنظیمات پوسته امین</button>
                    </p>
                </form>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.amin-tab-btn');
            const contents = document.querySelectorAll('.amin-content');
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
        .amin-wrap { max-width: 1050px; margin-top: 25px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        .amin-header { background: linear-gradient(135deg, #c2410c 0%, #ea580c 100%); color:#fff; padding:24px 30px; border-radius:14px; margin-bottom:25px; box-shadow:0 10px 25px -5px rgba(234, 88, 12, 0.4); }
        .amin-header h1 { color:#fff; margin:8px 0; font-size:22px; font-weight:800; }
        .amin-header p { margin:0; color:#ffedd5; font-size:13px; }
        .amin-header a { color:#fff; text-decoration:underline; font-weight:700; }
        .amin-badge { background:rgba(255,255,255,0.2); padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600; display:inline-block; }
        .amin-container { background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; }
        .amin-tabs { display:flex; background:#f8fafc; border-bottom:1px solid #e2e8f0; padding:0 15px; }
        .amin-tab-btn { padding:14px 18px; text-decoration:none; color:#475569; font-weight:600; font-size:13.5px; border-bottom:3px solid transparent; }
        .amin-tab-btn:hover { color:#ea580c; }
        .amin-tab-btn.active { color:#ea580c; border-bottom-color:#ea580c; background:#fff; }
        .amin-content { display:none; padding:25px 30px; }
        .amin-content.active { display:block; }
        </style>
        <?php
    }
}

Amin_Admin_Options::init();
