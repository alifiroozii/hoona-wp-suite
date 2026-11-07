<?php
/**
 * پنل تنظیمات پیشرفته افزونه شتاب‌دهنده رحیل
 */

defined('ABSPATH') || exit;

class Rahil_Admin_Settings {

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'register_menu']);
        add_action('admin_init', [__CLASS__, 'register_settings']);
    }

    public static function register_menu() {
        add_menu_page(
            'تنظیمات شتاب‌دهنده رحیل',
            '⚡ شتاب‌دهنده رحیل',
            'manage_options',
            'rahil-speed-settings',
            [__CLASS__, 'render_settings_page'],
            'dashicons-performance',
            55
        );
    }

    public static function register_settings() {
        register_setting('rahil_group', 'rahil_options', [
            'sanitize_callback' => [__CLASS__, 'sanitize_options']
        ]);
    }

    public static function sanitize_options($input) {
        $clean = [];
        $clean['enable_cache']   = !empty($input['enable_cache']) ? 1 : 0;
        $clean['cache_lifespan'] = max(1, min(168, intval($input['cache_lifespan'] ?? 24)));
        $clean['auto_webp']      = !empty($input['auto_webp']) ? 1 : 0;
        $clean['preload_fonts']  = !empty($input['preload_fonts']) ? 1 : 0;
        $clean['minify_html']    = !empty($input['minify_html']) ? 1 : 0;
        return $clean;
    }

    public static function render_settings_page() {
        if (!current_user_can('manage_options')) return;

        $opts = get_option('rahil_options', [
            'enable_cache'   => 1,
            'cache_lifespan' => 24,
            'auto_webp'      => 1,
            'preload_fonts'  => 1,
            'minify_html'    => 1
        ]);
        ?>
        <div class="wrap rahil-wrap" dir="rtl">
            <div class="rahil-header">
                <span class="rahil-badge">نسخه ۱.۰.۰ — شتاب‌دهنده راکت و کش پیشرفته</span>
                <h1>⚡ تنظیمات شتاب‌دهنده و کش رحیل (Rahil Speed Pro)</h1>
                <p>توسعه‌یافته توسط: <strong>مهندس علی فیروزی</strong> | شرکت هونا (<a href="https://hoonaco.ir" target="_blank">hoonaco.ir</a>)</p>
            </div>

            <?php settings_errors(); ?>

            <div class="rahil-container">
                <nav class="rahil-tabs">
                    <a href="#tab-cache" class="rahil-tab-btn active">⚡ کش هوشمند برگه</a>
                    <a href="#tab-media" class="rahil-tab-btn">🖼️ تبدیل خودکار WebP</a>
                    <a href="#tab-font" class="rahil-tab-btn">🔤 بهینه‌سازی فونت و CSS</a>
                    <a href="#tab-about" class="rahil-tab-btn">ℹ️ درباره هونا</a>
                </nav>

                <form method="post" action="options.php" class="rahil-form">
                    <?php settings_fields('rahil_group'); ?>

                    <div id="tab-cache" class="rahil-content active">
                        <table class="form-table">
                            <tr>
                                <th>فعال‌سازی کش فوق‌سریع</th>
                                <td>
                                    <label class="rahil-switch">
                                        <input type="checkbox" name="rahil_options[enable_cache]" value="1" <?php checked($opts['enable_cache'] ?? 1, 1); ?>>
                                        <span class="slider"></span>
                                    </label>
                                    <span class="description">تولید خودکار صفحات استاتیک HTML جهت کاهش لود CPU به زیر ۱٪</span>
                                </td>
                            </tr>
                            <tr>
                                <th>مدت زمان نگهداری کش (ساعت)</th>
                                <td><input type="number" name="rahil_options[cache_lifespan]" value="<?php echo esc_attr($opts['cache_lifespan']); ?>" min="1" max="168" style="width:70px;"> ساعت</td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-media" class="rahil-content">
                        <table class="form-table">
                            <tr>
                                <th>تبدیل خودکار به فرمت نسل جدید WebP</th>
                                <td>
                                    <label class="rahil-switch">
                                        <input type="checkbox" name="rahil_options[auto_webp]" value="1" <?php checked($opts['auto_webp'] ?? 1, 1); ?>>
                                        <span class="slider"></span>
                                    </label>
                                    <span class="description">کاهش ۷۰٪ حجم تصاویر JPG و PNG آپلود شده بدون افت کیفیت</span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-font" class="rahil-content">
                        <table class="form-table">
                            <tr>
                                <th>پیش‌بارگذاری فونت‌های فارسی (Preload)</th>
                                <td>
                                    <label class="rahil-switch">
                                        <input type="checkbox" name="rahil_options[preload_fonts]" value="1" <?php checked($opts['preload_fonts'] ?? 1, 1); ?>>
                                        <span class="slider"></span>
                                    </label>
                                    <span class="description">بارگذاری آنی فونت‌های وزیرمتن قبل از رندر صفحه برای حذف پرش فونت (FOUT)</span>
                                </td>
                            </tr>
                            <tr>
                                <th>فشرده‌سازی خروجی HTML</th>
                                <td>
                                    <label class="rahil-switch">
                                        <input type="checkbox" name="rahil_options[minify_html]" value="1" <?php checked($opts['minify_html'] ?? 1, 1); ?>>
                                        <span class="slider"></span>
                                    </label>
                                    <span class="description">حذف فاصله‌ها و کامنت‌های اضافه جهت کاهش حجم پاسخ سرور</span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-about" class="rahil-content">
                        <div style="background:#f1f5f9; padding:20px; border-radius:10px; line-height:1.8;">
                            <h3>شرکت هوشمندسازی و وب هونا</h3>
                            <p>افزونه رحیل به عنوان جایگزین مطمئن، پاک و رایگان افزونه‌های کش تجاری گران‌قیمت (مثل WP Rocket) برای افزایش رتبه سئو و سرعت طراحی شده است.</p>
                            <p>👨‍💻 <strong>توسعه‌دهنده:</strong> مهندس علی فیروزی | 🌐 <a href="https://hoonaco.ir" target="_blank">hoonaco.ir</a></p>
                        </div>
                    </div>

                    <p class="submit">
                        <button type="submit" class="button button-primary button-hero">💾 ذخیره تنظیمات شتاب‌دهنده رحیل</button>
                    </p>
                </form>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.rahil-tab-btn');
            const contents = document.querySelectorAll('.rahil-content');
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
        .rahil-wrap { max-width: 1050px; margin-top: 25px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        .rahil-header { background: linear-gradient(135deg, #b91c1c 0%, #ef4444 100%); color:#fff; padding:24px 30px; border-radius:14px; margin-bottom:25px; box-shadow:0 10px 25px -5px rgba(239, 68, 68, 0.4); }
        .rahil-header h1 { color:#fff; margin:8px 0; font-size:22px; font-weight:800; }
        .rahil-header p { margin:0; color:#fee2e2; font-size:13px; }
        .rahil-header a { color:#fff; text-decoration:underline; font-weight:700; }
        .rahil-badge { background:rgba(255,255,255,0.2); padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600; display:inline-block; }
        .rahil-container { background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; }
        .rahil-tabs { display:flex; background:#f8fafc; border-bottom:1px solid #e2e8f0; padding:0 15px; }
        .rahil-tab-btn { padding:14px 18px; text-decoration:none; color:#475569; font-weight:600; font-size:13.5px; border-bottom:3px solid transparent; }
        .rahil-tab-btn:hover { color:#ef4444; }
        .rahil-tab-btn.active { color:#b91c1c; border-bottom-color:#b91c1c; background:#fff; }
        .rahil-content { display:none; padding:25px 30px; }
        .rahil-content.active { display:block; }
        .rahil-switch { position: relative; display: inline-block; width: 44px; height: 24px; vertical-align: middle; margin-left: 10px; }
        .rahil-switch input { opacity: 0; width: 0; height: 0; }
        .rahil-switch .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .3s; border-radius: 24px; }
        .rahil-switch .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .3s; border-radius: 50%; }
        .rahil-switch input:checked + .slider { background-color: #ef4444; }
        .rahil-switch input:checked + .slider:before { transform: translateX(20px); }
        </style>
        <?php
    }
}

Rahil_Admin_Settings::init();
