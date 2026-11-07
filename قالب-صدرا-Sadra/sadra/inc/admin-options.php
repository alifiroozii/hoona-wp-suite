<?php
/**
 * پنل تنظیمات پیشرفته پوسته آموزشی صدرا (Sadra Theme Options)
 * توسعه‌دهنده: علی فیروزی - شرکت هونا (hoonaco.ir)
 */

defined('ABSPATH') || exit;

class Sadra_Admin_Options {

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'add_admin_menu']);
        add_action('admin_init', [__CLASS__, 'register_settings']);
    }

    public static function add_admin_menu() {
        add_menu_page(
            'تنظیمات قالب صدرا',
            '⚡ تنظیمات صدرا',
            'manage_options',
            'sadra-theme-options',
            [__CLASS__, 'render_options_page'],
            'dashicons-welcome-learn-more',
            57
        );
    }

    public static function register_settings() {
        register_setting('sadra_options_group', 'sadra_options', [
            'sanitize_callback' => [__CLASS__, 'sanitize_options']
        ]);
    }

    public static function sanitize_options($input) {
        $clean = [];
        $clean['academy_name']   = sanitize_text_field($input['academy_name'] ?? 'آکادمی صدرا');
        $clean['hero_title']     = sanitize_text_field($input['hero_title'] ?? 'مسیر حرفه‌ای یادگیری مهارت‌های روز دنیا');
        $clean['hero_subtitle']  = sanitize_text_field($input['hero_subtitle'] ?? 'بیش از ۵۰ دوره جامع برنامه‌نویسی، هوش مصنوعی، دیجیتال مارکتینگ و طراحی با تدریس برترین اساتید ایران.');
        $clean['support_phone']  = sanitize_text_field($input['support_phone'] ?? '021-88889999');
        $clean['stat_students']  = sanitize_text_field($input['stat_students'] ?? '+۱۲,۵۰۰ دانشجو');
        $clean['stat_courses']   = sanitize_text_field($input['stat_courses'] ?? '+۸۵ دوره تخصصی');
        $clean['stat_satisfy']   = sanitize_text_field($input['stat_satisfy'] ?? '۹۸.۴٪ رضایت');
        $clean['primary_color']  = sanitize_hex_color($input['primary_color'] ?? '#2563eb');
        $clean['cta_text']       = sanitize_text_field($input['cta_text'] ?? 'مشاهده همه دوره‌ها');
        $clean['footer_text']    = sanitize_text_field($input['footer_text'] ?? 'تمامی حقوق متعلق به آکادمی صدرا است. طراحی توسط شرکت هونا.');
        return $clean;
    }

    public static function render_options_page() {
        if (!current_user_can('manage_options')) return;

        $opts = get_option('sadra_options', [
            'academy_name'  => 'آکادمی صدرا',
            'hero_title'    => 'مسیر حرفه‌ای یادگیری مهارت‌های روز دنیا',
            'hero_subtitle' => 'بیش از ۵۰ دوره جامع برنامه‌نویسی، هوش مصنوعی، دیجیتال مارکتینگ و طراحی با تدریس برترین اساتید ایران.',
            'support_phone' => '021-88889999',
            'stat_students' => '+۱۲,۵۰۰ دانشجو',
            'stat_courses'  => '+۸۵ دوره تخصصی',
            'stat_satisfy'  => '۹۸.۴٪ رضایت',
            'primary_color' => '#2563eb',
            'cta_text'      => 'مشاهده همه دوره‌ها',
            'footer_text'   => 'تمامی حقوق متعلق به آکادمی صدرا است. طراحی توسط شرکت هونا.'
        ]);
        ?>
        <div class="wrap sadra-wrap" dir="rtl">
            <div class="sadra-header">
                <span class="sadra-badge">نسخه ۱.۰.۰ — پوسته رسمی آکادمی و LMS</span>
                <h1>🎓 تنظیمات پیشرفته آکادمی صدرا (Sadra LMS)</h1>
                <p>توسعه‌یافته توسط: <strong>مهندس علی فیروزی</strong> | شرکت هونا (<a href="https://hoonaco.ir" target="_blank">hoonaco.ir</a>)</p>
            </div>

            <?php settings_errors(); ?>

            <div class="sadra-container">
                <nav class="sadra-tabs">
                    <a href="#tab-general" class="sadra-tab-btn active">⚙️ عمومی و هدر</a>
                    <a href="#tab-hero" class="sadra-tab-btn">🚀 بخش هیرو و آمار</a>
                    <a href="#tab-courses" class="sadra-tab-btn">📚 دوره‌ها و پلیر</a>
                    <a href="#tab-appearance" class="sadra-tab-btn">🎨 رنگ‌بندی و برند</a>
                    <a href="#tab-footer" class="sadra-tab-btn">🦶 فوتر و حقوق</a>
                    <a href="#tab-about" class="sadra-tab-btn">ℹ️ درباره توسعه‌دهنده</a>
                </nav>

                <form method="post" action="options.php" class="sadra-form">
                    <?php settings_fields('sadra_options_group'); ?>

                    <div id="tab-general" class="sadra-content active">
                        <table class="form-table">
                            <tr>
                                <th>نام آکادمی / برند</th>
                                <td><input type="text" name="sadra_options[academy_name]" value="<?php echo esc_attr($opts['academy_name']); ?>" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th>شماره تماس مشاوره</th>
                                <td><input type="text" name="sadra_options[support_phone]" value="<?php echo esc_attr($opts['support_phone']); ?>" class="regular-text" dir="ltr"></td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-hero" class="sadra-content">
                        <table class="form-table">
                            <tr>
                                <th>تیتر بزرگ صفحه اصلی</th>
                                <td><input type="text" name="sadra_options[hero_title]" value="<?php echo esc_attr($opts['hero_title']); ?>" class="large-text"></td>
                            </tr>
                            <tr>
                                <th>توضیح زیر تیتر</th>
                                <td><textarea name="sadra_options[hero_subtitle]" rows="3" class="large-text"><?php echo esc_textarea($opts['hero_subtitle']); ?></textarea></td>
                            </tr>
                            <tr>
                                <th>آمار دانشجویان</th>
                                <td><input type="text" name="sadra_options[stat_students]" value="<?php echo esc_attr($opts['stat_students']); ?>"></td>
                            </tr>
                            <tr>
                                <th>آمار دوره‌ها</th>
                                <td><input type="text" name="sadra_options[stat_courses]" value="<?php echo esc_attr($opts['stat_courses']); ?>"></td>
                            </tr>
                            <tr>
                                <th>درصد رضایت</th>
                                <td><input type="text" name="sadra_options[stat_satisfy]" value="<?php echo esc_attr($opts['stat_satisfy']); ?>"></td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-courses" class="sadra-content">
                        <table class="form-table">
                            <tr>
                                <th>متن دکمه ثبت‌نام دوره</th>
                                <td><input type="text" name="sadra_options[cta_text]" value="<?php echo esc_attr($opts['cta_text']); ?>"></td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-appearance" class="sadra-content">
                        <table class="form-table">
                            <tr>
                                <th>رنگ سازمانی و دکمه‌ها</th>
                                <td><input type="color" name="sadra_options[primary_color]" value="<?php echo esc_attr($opts['primary_color']); ?>"></td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-footer" class="sadra-content">
                        <table class="form-table">
                            <tr>
                                <th>متن پاورقی و کپی رایت</th>
                                <td><input type="text" name="sadra_options[footer_text]" value="<?php echo esc_attr($opts['footer_text']); ?>" class="large-text"></td>
                            </tr>
                        </table>
                    </div>

                    <div id="tab-about" class="sadra-content">
                        <div style="background:#f1f5f9; padding:20px; border-radius:10px; line-height:1.8;">
                            <h3>شرکت هوشمندسازی و وب هونا</h3>
                            <p>پوسته آموزشی صدرا برای موسسات، اساتید و مدرسان آنلاین با هدف سرعت بالا، بدون نیاز به صفحه‌سازهای سنگین طراحی گردیده است.</p>
                            <p>👨‍💻 <strong>توسعه‌دهنده:</strong> مهندس علی فیروزی | 🌐 <a href="https://hoonaco.ir" target="_blank">hoonaco.ir</a></p>
                        </div>
                    </div>

                    <p class="submit">
                        <button type="submit" class="button button-primary button-hero">💾 ذخیره تنظیمات پوسته صدرا</button>
                    </p>
                </form>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.sadra-tab-btn');
            const contents = document.querySelectorAll('.sadra-content');
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
        .sadra-wrap { max-width: 1050px; margin-top: 25px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        .sadra-header { background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%); color:#fff; padding:24px 30px; border-radius:14px; margin-bottom:25px; box-shadow:0 10px 25px -5px rgba(37, 99, 235, 0.4); }
        .sadra-header h1 { color:#fff; margin:8px 0; font-size:22px; font-weight:800; }
        .sadra-header p { margin:0; color:#bfdbfe; font-size:13px; }
        .sadra-header a { color:#fff; text-decoration:underline; font-weight:700; }
        .sadra-badge { background:rgba(255,255,255,0.2); padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600; display:inline-block; }
        .sadra-container { background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; }
        .sadra-tabs { display:flex; background:#f8fafc; border-bottom:1px solid #e2e8f0; padding:0 15px; }
        .sadra-tab-btn { padding:14px 18px; text-decoration:none; color:#475569; font-weight:600; font-size:13.5px; border-bottom:3px solid transparent; }
        .sadra-tab-btn:hover { color:#2563eb; }
        .sadra-tab-btn.active { color:#2563eb; border-bottom-color:#2563eb; background:#fff; }
        .sadra-content { display:none; padding:25px 30px; }
        .sadra-content.active { display:block; }
        </style>
        <?php
    }
}

Sadra_Admin_Options::init();
