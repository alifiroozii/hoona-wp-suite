<?php
/**
 * Helma Theme - Admin Theme Options Dashboard
 *
 * Dedicated WordPress Settings Dashboard for Helma Next-Gen AI & SaaS.
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

/**
 * Register Admin Menu Page
 */
function helma_register_admin_options_menu() {
    add_menu_page(
        __('تنظیمات پوسته حلما', 'helma'),
        __('تنظیمات حلما', 'helma'),
        'manage_options',
        'helma-settings',
        'helma_render_theme_options_page',
        'dashicons-superhero-alt',
        59
    );
}
add_action('admin_menu', 'helma_register_admin_options_menu');

/**
 * Register Theme Settings in Settings API
 */
function helma_register_theme_settings() {
    register_setting(
        'helma_theme_options_group',
        'helma_theme_options',
        'helma_sanitize_theme_options'
    );
}
add_action('admin_init', 'helma_register_theme_settings');

/**
 * Sanitize all options safely
 */
function helma_sanitize_theme_options($input) {
    $clean = array();

    if (!is_array($input)) {
        return $clean;
    }

    // Colors & Glow
    $clean['glow_primary']   = isset($input['glow_primary']) ? sanitize_hex_color($input['glow_primary']) : '#8b5cf6';
    $clean['glow_secondary'] = isset($input['glow_secondary']) ? sanitize_hex_color($input['glow_secondary']) : '#06b6d4';
    $clean['default_theme']   = isset($input['default_theme']) && in_array($input['default_theme'], array('dark', 'light'), true) ? $input['default_theme'] : 'dark';

    // Header & Live Status
    $clean['show_status_pill']  = !empty($input['show_status_pill']) ? 1 : 0;
    $clean['status_pill_text']  = isset($input['status_pill_text']) ? sanitize_text_field($input['status_pill_text']) : '🟢 تمامی مدل‌های هوش مصنوعی فعال است | نسخه ۳.۰';
    $clean['header_cta_text']   = isset($input['header_cta_text']) ? sanitize_text_field($input['header_cta_text']) : 'شروع آزمایش رایگان';
    $clean['header_cta_url']    = isset($input['header_cta_url']) ? esc_url_raw($input['header_cta_url']) : '#pricing';

    // Homepage Modules
    $clean['show_hero']         = !empty($input['show_hero']) ? 1 : 0;
    $clean['show_simulator']    = !empty($input['show_simulator']) ? 1 : 0;
    $clean['show_bento']        = !empty($input['show_bento']) ? 1 : 0;
    $clean['show_showcase']     = !empty($input['show_showcase']) ? 1 : 0;
    $clean['show_pricing']      = !empty($input['show_pricing']) ? 1 : 0;
    $clean['show_testimonials'] = !empty($input['show_testimonials']) ? 1 : 0;
    $clean['show_blog']         = !empty($input['show_blog']) ? 1 : 0;
    $clean['show_cta']          = !empty($input['show_cta']) ? 1 : 0;

    // AI Simulator
    $clean['simulator_badge']       = isset($input['simulator_badge']) ? sanitize_text_field($input['simulator_badge']) : 'Helma-Ultra-3.0';
    $clean['simulator_placeholder'] = isset($input['simulator_placeholder']) ? sanitize_text_field($input['simulator_placeholder']) : 'یک دستور بنویسید (مثلاً: استراتژی بازاریابی، کد پایتون یا گزارش مالی)...';

    // Pricing
    $clean['price_starter_mo']  = isset($input['price_starter_mo']) ? sanitize_text_field($input['price_starter_mo']) : '۴۹۰,۰۰۰';
    $clean['price_starter_yr']  = isset($input['price_starter_yr']) ? sanitize_text_field($input['price_starter_yr']) : '۳۹۰,۰۰۰';
    $clean['price_pro_mo']      = isset($input['price_pro_mo']) ? sanitize_text_field($input['price_pro_mo']) : '۱,۴۹۰,۰۰۰';
    $clean['price_pro_yr']      = isset($input['price_pro_yr']) ? sanitize_text_field($input['price_pro_yr']) : '۱,۱۹۰,۰۰۰';
    $clean['price_ent_mo']      = isset($input['price_ent_mo']) ? sanitize_text_field($input['price_ent_mo']) : '۳,۹۰۰,۰۰۰';
    $clean['price_ent_yr']      = isset($input['price_ent_yr']) ? sanitize_text_field($input['price_ent_yr']) : '۳,۱۲۰,۰۰۰';

    // Security
    $clean['enable_sec_headers']   = !empty($input['enable_sec_headers']) ? 1 : 0;
    $clean['hide_wp_version']      = !empty($input['hide_wp_version']) ? 1 : 0;
    $clean['block_user_enum']      = !empty($input['block_user_enum']) ? 1 : 0;
    $clean['disable_xmlrpc_ping']  = !empty($input['disable_xmlrpc_ping']) ? 1 : 0;

    // Footer
    $clean['footer_about']      = isset($input['footer_about']) ? sanitize_textarea_field($input['footer_about']) : '';
    $clean['copyright_text']    = isset($input['copyright_text']) ? sanitize_text_field($input['copyright_text']) : '';

    // Social Links
    $clean['social_telegram']   = isset($input['social_telegram']) ? esc_url_raw($input['social_telegram']) : '';
    $clean['social_instagram']  = isset($input['social_instagram']) ? esc_url_raw($input['social_instagram']) : '';
    $clean['social_linkedin']   = isset($input['social_linkedin']) ? esc_url_raw($input['social_linkedin']) : '';
    $clean['social_x']          = isset($input['social_x']) ? esc_url_raw($input['social_x']) : '';

    // Custom Code
    $clean['custom_css']        = isset($input['custom_css']) ? wp_strip_all_tags($input['custom_css']) : '';
    if (current_user_can('unfiltered_html')) {
        $clean['custom_head_js']   = isset($input['custom_head_js']) ? $input['custom_head_js'] : '';
        $clean['custom_footer_js'] = isset($input['custom_footer_js']) ? $input['custom_footer_js'] : '';
    } else {
        $clean['custom_head_js']   = isset($input['custom_head_js']) ? wp_strip_all_tags($input['custom_head_js']) : '';
        $clean['custom_footer_js'] = isset($input['custom_footer_js']) ? wp_strip_all_tags($input['custom_footer_js']) : '';
    }

    return $clean;
}

/**
 * Helper to fetch options safely
 */
function helma_opt($key, $default = null) {
    $options = get_option('helma_theme_options');
    if (is_array($options) && isset($options[$key])) {
        return $options[$key];
    }
    return $default;
}

/**
 * Render Theme Options Dashboard
 */
function helma_render_theme_options_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $opts = get_option('helma_theme_options', array());
    ?>
    <div class="wrap helma-admin-wrap" style="direction: rtl; text-align: right; max-width: 1240px; margin: 20px 20px 0 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        
        <!-- Header Banner with Cyber Glow -->
        <div style="background: linear-gradient(135deg, #1e1b4b 0%, #0f172a 100%); border: 1px solid rgba(139, 92, 246, 0.35); color: #ffffff; padding: 2.25rem 2.5rem; border-radius: 16px; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 10px 30px -5px rgba(139, 92, 246, 0.25);">
            <div>
                <div style="background: rgba(139, 92, 246, 0.2); border: 1px solid rgba(139, 92, 246, 0.4); color: #c4b5fd; display: inline-block; padding: 3px 14px; border-radius: 999px; font-size: 0.8rem; font-weight: 700; margin-bottom: 0.6rem;">نسخه ۱.۰ نسل جدید AI & SaaS</div>
                <h1 style="color: #ffffff; font-size: 1.85rem; font-weight: 800; margin: 0 0 0.5rem 0; letter-spacing: -0.5px;">مرکز مدیریت و تنظیمات پوسته حلما (Helma)</h1>
                <p style="color: rgba(255,255,255,0.8); margin: 0; font-size: 0.95rem;">شخصی‌سازی نورپردازی نئونی، شبیه‌ساز زنده هوش مصنوعی، قیمت‌ها، امنیت و معماری بنتو گرید.</p>
            </div>
            <div style="text-align: left; background: rgba(255,255,255,0.06); padding: 1.1rem 1.75rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.12);">
                <div style="font-size: 0.8rem; color: #94a3b8;">طراح و برنامه‌نویس:</div>
                <div style="font-weight: 800; font-size: 1.1rem; color: #ffffff;">علی فیروزی</div>
                <div style="font-size: 0.85rem; margin-top: 3px;"><a href="https://hoonaco.ir" target="_blank" style="color: #a78bfa; text-decoration: none; font-weight: 600;">شرکت هونا (hoonaco.ir) ↗</a></div>
            </div>
        </div>

        <?php settings_errors(); ?>

        <form method="post" action="options.php" style="display: grid; grid-template-columns: 270px 1fr; gap: 1.75rem; align-items: start;">
            <?php
            settings_fields('helma_theme_options_group');
            ?>

            <!-- Tabs Navigation -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 0.85rem; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
                <ul class="helma-nav-tabs" style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 0.4rem;">
                    <li><button type="button" class="helma-tab-btn active" data-tab="tab-colors">🔮 نورپردازی و رنگ‌های نئونی</button></li>
                    <li><button type="button" class="helma-tab-btn" data-tab="tab-header">🧭 هدر و وضعیت زنده</button></li>
                    <li><button type="button" class="helma-tab-btn" data-tab="tab-homepage">🏠 بخش‌های صفحه نخست</button></li>
                    <li><button type="button" class="helma-tab-btn" data-tab="tab-simulator">🤖 شبیه‌ساز هوش مصنوعی</button></li>
                    <li><button type="button" class="helma-tab-btn" data-tab="tab-pricing">💎 موتور قیمت‌گذاری پلن‌ها</button></li>
                    <li><button type="button" class="helma-tab-btn" data-tab="tab-security">🛡️ فایروال و امنیت OWASP</button></li>
                    <li><button type="button" class="helma-tab-btn" data-tab="tab-custom">💻 کدهای سفارشی CSS / JS</button></li>
                    <li><button type="button" class="helma-tab-btn" data-tab="tab-backup">💾 پشتیبان‌گیری و خروجی JSON</button></li>
                </ul>

                <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid #f1f5f9; text-align: center;">
                    <?php submit_button(__('ذخیره تمام تنظیمات', 'helma'), 'primary large', 'submit', false, array('style' => 'width:100%; border-radius:8px; height:44px; font-weight:700;')); ?>
                </div>
            </div>

            <!-- Tab Panes Container -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 2.25rem; box-shadow: 0 2px 6px rgba(0,0,0,0.04); min-height: 540px;">
                
                <!-- TAB 1: Glow & Colors -->
                <div class="helma-tab-pane active" id="tab-colors">
                    <h2 class="helma-pane-title">نورپردازی نئونی و پالت رنگی قالب حلما</h2>
                    <p class="helma-pane-desc">رنگ‌های درخشش هیرو، حاشیه‌های شیشه‌ای و تم پیش‌فرض را شخصی‌سازی کنید.</p>

                    <table class="form-table">
                        <tr>
                            <th scope="row">رنگ درخشش اصلی (Neon Glow Accent)</th>
                            <td>
                                <input type="color" name="helma_theme_options[glow_primary]" value="<?php echo esc_attr($opts['glow_primary'] ?? '#8b5cf6'); ?>" style="height:40px; width:60px; padding:0; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" />
                                <span class="description" style="margin-right:12px;">رنگ درخشش دکمه‌های اصلی، کارت پرطرفدار و نور پس‌زمینه (پیش‌فرض بنفش نئونی #8b5cf6).</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">رنگ درخشش ثانویه (Cyber Cyan Accent)</th>
                            <td>
                                <input type="color" name="helma_theme_options[glow_secondary]" value="<?php echo esc_attr($opts['glow_secondary'] ?? '#06b6d4'); ?>" style="height:40px; width:60px; padding:0; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" />
                                <span class="description" style="margin-right:12px;">رنگ دوم گرادیان‌ها و آیکون‌ها (پیش‌فرض فیروزه‌ای سایبرنتیک #06b6d4).</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">حالت نمایش پیش‌فرض</th>
                            <td>
                                <select name="helma_theme_options[default_theme]" class="regular-text">
                                    <option value="dark" <?php selected($opts['default_theme'] ?? 'dark', 'dark'); ?>>حالت دارک عمیق (Deep Dark - پیش‌فرض و پیشنهاد هونا)</option>
                                    <option value="light" <?php selected($opts['default_theme'] ?? 'dark', 'light'); ?>>حالت لایت مدرن (Cyber Light)</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- TAB 2: Header & Live Status -->
                <div class="helma-tab-pane" id="tab-header">
                    <h2 class="helma-pane-title">تنظیمات هدر شناور و نشانگر زنده وضعیت</h2>
                    <p class="helma-pane-desc">نشانگر سبز تپنده بالای هدر و دکمه‌های اقدام را کنترل کنید.</p>

                    <table class="form-table">
                        <tr>
                            <th scope="row">نشانگر وضعیت زنده سیستم (Live Status Pill)</th>
                            <td>
                                <label style="display:block; margin-bottom:0.75rem;">
                                    <input type="checkbox" name="helma_theme_options[show_status_pill]" value="1" <?php checked($opts['show_status_pill'] ?? 1, 1); ?> />
                                    نمایش نشانگر سبز تپنده وضعیت در هدر
                                </label>
                                <input type="text" name="helma_theme_options[status_pill_text]" value="<?php echo esc_attr($opts['status_pill_text'] ?? '🟢 تمامی مدل‌های هوش مصنوعی فعال است | نسخه ۳.۰'); ?>" class="large-text" placeholder="متن نشانگر زنده" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">دکمه اقدام سریع (Header CTA)</th>
                            <td>
                                <input type="text" name="helma_theme_options[header_cta_text]" value="<?php echo esc_attr($opts['header_cta_text'] ?? 'شروع آزمایش رایگان'); ?>" class="regular-text" placeholder="متن دکمه" style="margin-bottom:0.5rem;" /><br>
                                <input type="url" name="helma_theme_options[header_cta_url]" value="<?php echo esc_attr($opts['header_cta_url'] ?? '#pricing'); ?>" class="regular-text" placeholder="لینک دکمه" />
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- TAB 3: Homepage Modules -->
                <div class="helma-tab-pane" id="tab-homepage">
                    <h2 class="helma-pane-title">مدیریت بخش‌های صفحه اصلی</h2>
                    <p class="helma-pane-desc">سکشن‌های صفحه اول را با یک کلیک خاموش یا روشن کنید.</p>

                    <table class="form-table">
                        <tr>
                            <th scope="row">سکشن هیرو (Hero Banner)</th>
                            <td><label><input type="checkbox" name="helma_theme_options[show_hero]" value="1" <?php checked($opts['show_hero'] ?? 1, 1); ?> /> فعال بودن بنر اصلی</label></td>
                        </tr>
                        <tr>
                            <th scope="row">شبیه‌ساز زنده پرامپت (AI Simulator)</th>
                            <td><label><input type="checkbox" name="helma_theme_options[show_simulator]" value="1" <?php checked($opts['show_simulator'] ?? 1, 1); ?> /> فعال بودن کادر تست پرامپت تعاملی</label></td>
                        </tr>
                        <tr>
                            <th scope="row">بنتو گرید ۲.۰ (Bento Grid)</th>
                            <td><label><input type="checkbox" name="helma_theme_options[show_bento]" value="1" <?php checked($opts['show_bento'] ?? 1, 1); ?> /> فعال بودن کارت‌های شبکه‌ای فیچرها</label></td>
                        </tr>
                        <tr>
                            <th scope="row">تب‌های ویترین نرم‌افزار (App Showcase)</th>
                            <td><label><input type="checkbox" name="helma_theme_options[show_showcase]" value="1" <?php checked($opts['show_showcase'] ?? 1, 1); ?> /> فعال بودن بخش معرفی تعاملی محیط نرم‌افزار</label></td>
                        </tr>
                        <tr>
                            <th scope="row">جدول تعرفه‌ها و قیمت‌ها (Pricing Matrix)</th>
                            <td><label><input type="checkbox" name="helma_theme_options[show_pricing]" value="1" <?php checked($opts['show_pricing'] ?? 1, 1); ?> /> فعال بودن کارت‌های پلن و سوئیچر ماهانه/سالانه</label></td>
                        </tr>
                        <tr>
                            <th scope="row">دیوار رضایت متخصصان (Wall of Love)</th>
                            <td><label><input type="checkbox" name="helma_theme_options[show_testimonials]" value="1" <?php checked($opts['show_testimonials'] ?? 1, 1); ?> /> فعال بودن نظرات و کارت‌های شیشه‌ای رضایت‌نامه</label></td>
                        </tr>
                        <tr>
                            <th scope="row">وبلاگ و اخبار تکنولوژی AI</th>
                            <td><label><input type="checkbox" name="helma_theme_options[show_blog]" value="1" <?php checked($opts['show_blog'] ?? 1, 1); ?> /> فعال بودن نمایش آخرین مقالات وبلاگ</label></td>
                        </tr>
                    </table>
                </div>

                <!-- TAB 4: AI Simulator Settings -->
                <div class="helma-tab-pane" id="tab-simulator">
                    <h2 class="helma-pane-title">شبیه‌ساز پرامپت هوش مصنوعی در هیرو</h2>
                    <p class="helma-pane-desc">متن‌های پیش‌فرض و عنوان مدل را در کادر تست تعاملی صفحه اول تنظیم کنید.</p>

                    <table class="form-table">
                        <tr>
                            <th scope="row">عنوان مدل هوش مصنوعی</th>
                            <td>
                                <input type="text" name="helma_theme_options[simulator_badge]" value="<?php echo esc_attr($opts['simulator_badge'] ?? 'Helma-Ultra-3.0'); ?>" class="regular-text" />
                                <span class="description" style="margin-right:10px;">نظیر Helma-Ultra-3.0 یا Helma-GPT.</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">متن راهنمای اینپوت (Placeholder)</th>
                            <td>
                                <input type="text" name="helma_theme_options[simulator_placeholder]" value="<?php echo esc_attr($opts['simulator_placeholder'] ?? 'یک دستور بنویسید (مثلاً: استراتژی بازاریابی، کد پایتون یا گزارش مالی)...'); ?>" class="large-text" />
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- TAB 5: Pricing Engine -->
                <div class="helma-tab-pane" id="tab-pricing">
                    <h2 class="helma-pane-title">موتور مدیریت مبالغ پلن‌های تعرفه</h2>
                    <p class="helma-pane-desc">مبالغ ماهانه و سالانه هر یک از ۳ پلن را بدون نیاز به کدنویسی تغییر دهید.</p>

                    <table class="form-table">
                        <tr>
                            <th scope="row">پلن استارتر (Starter)</th>
                            <td>
                                ماهانه: <input type="text" name="helma_theme_options[price_starter_mo]" value="<?php echo esc_attr($opts['price_starter_mo'] ?? '۴۹۰,۰۰۰'); ?>" class="small-text" style="width:120px;" /> تومان
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                سالانه (ماهیانه با تخفیف): <input type="text" name="helma_theme_options[price_starter_yr]" value="<?php echo esc_attr($opts['price_starter_yr'] ?? '۳۹۰,۰۰۰'); ?>" class="small-text" style="width:120px;" /> تومان
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">پلن حرفه‌ای (Pro - پرطرفدار)</th>
                            <td>
                                ماهانه: <input type="text" name="helma_theme_options[price_pro_mo]" value="<?php echo esc_attr($opts['price_pro_mo'] ?? '۱,۴۹۰,۰۰۰'); ?>" class="small-text" style="width:120px;" /> تومان
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                سالانه (ماهیانه با تخفیف): <input type="text" name="helma_theme_options[price_pro_yr]" value="<?php echo esc_attr($opts['price_pro_yr'] ?? '۱,۱۹۰,۰۰۰'); ?>" class="small-text" style="width:120px;" /> تومان
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">پلن سازمانی (Enterprise)</th>
                            <td>
                                ماهانه: <input type="text" name="helma_theme_options[price_ent_mo]" value="<?php echo esc_attr($opts['price_ent_mo'] ?? '۳,۹۰۰,۰۰۰'); ?>" class="small-text" style="width:120px;" /> تومان
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                سالانه (ماهیانه با تخفیف): <input type="text" name="helma_theme_options[price_ent_yr]" value="<?php echo esc_attr($opts['price_ent_yr'] ?? '۳,۱۲۰,۰۰۰'); ?>" class="small-text" style="width:120px;" /> تومان
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- TAB 6: Security -->
                <div class="helma-tab-pane" id="tab-security">
                    <h2 class="helma-pane-title">تنظیمات امنیت سازمانی (OWASP Hardening)</h2>
                    <p class="helma-pane-desc">سپرهای محافظتی بومی حلما برای ایمن‌سازی حداکثری سایت در برابر اتک‌ها.</p>

                    <table class="form-table">
                        <tr>
                            <th scope="row">هدرهای حفاظتی HTTP</th>
                            <td><label><input type="checkbox" name="helma_theme_options[enable_sec_headers]" value="1" <?php checked($opts['enable_sec_headers'] ?? 1, 1); ?> /> تزریق خودکار هدرهای X-Frame-Options, X-Content-Type-Options و Referrer-Policy</label></td>
                        </tr>
                        <tr>
                            <th scope="row">مخفی‌سازی نگارش وردپرس</th>
                            <td><label><input type="checkbox" name="helma_theme_options[hide_wp_version]" value="1" <?php checked($opts['hide_wp_version'] ?? 1, 1); ?> /> حذف تگ‌های generator و رشته‌های ver= از فایل‌های اسکریپت و استایل</label></td>
                        </tr>
                        <tr>
                            <th scope="row">مسدودسازی اسکن نام کاربری</th>
                            <td><label><input type="checkbox" name="helma_theme_options[block_user_enum]" value="1" <?php checked($opts['block_user_enum'] ?? 1, 1); ?> /> مسدودسازی درخواست‌های شناسایی نویسنده از طریق (?author=1)</label></td>
                        </tr>
                        <tr>
                            <th scope="row">خنثی‌سازی حملات پینگ‌بک</th>
                            <td><label><input type="checkbox" name="helma_theme_options[disable_xmlrpc_ping]" value="1" <?php checked($opts['disable_xmlrpc_ping'] ?? 1, 1); ?> /> غیرفعال‌سازی متد pingback.ping در XML-RPC جهت جلوگیری از حملات دیداس</label></td>
                        </tr>
                    </table>
                </div>

                <!-- TAB 7: Custom Code -->
                <div class="helma-tab-pane" id="tab-custom">
                    <h2 class="helma-pane-title">کدهای سفارشی و اسکریپت‌های ره‌گیری</h2>
                    <p class="helma-pane-desc">بدون دستکاری فایل‌ها، استایل‌های دلخواه و اسکریپت‌های آمارگیر را اضافه کنید.</p>

                    <table class="form-table">
                        <tr>
                            <th scope="row">استایل‌های CSS اختصاصی</th>
                            <td><textarea name="helma_theme_options[custom_css]" rows="6" class="large-text code" style="direction:ltr; text-align:left;"><?php echo esc_textarea($opts['custom_css'] ?? ''); ?></textarea></td>
                        </tr>
                        <tr>
                            <th scope="row">اسکریپت‌های سربرگ (&lt;head&gt;)</th>
                            <td><textarea name="helma_theme_options[custom_head_js]" rows="5" class="large-text code" style="direction:ltr; text-align:left;"><?php echo esc_textarea($opts['custom_head_js'] ?? ''); ?></textarea></td>
                        </tr>
                        <tr>
                            <th scope="row">اسکریپت‌های پاورقی (&lt;/body&gt;)</th>
                            <td><textarea name="helma_theme_options[custom_footer_js]" rows="5" class="large-text code" style="direction:ltr; text-align:left;"><?php echo esc_textarea($opts['custom_footer_js'] ?? ''); ?></textarea></td>
                        </tr>
                    </table>
                </div>

                <!-- TAB 8: Backup -->
                <div class="helma-tab-pane" id="tab-backup">
                    <h2 class="helma-pane-title">خروجی و پشتیبان‌گیری JSON تنظیمات</h2>
                    <p class="helma-pane-desc">کد پیکربندی زنده قالب را برای انتقال فوری به سایر سایت‌ها کپی کنید.</p>

                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1.25rem;">
                        <textarea readonly id="helma_export_box" rows="8" class="large-text code" style="direction:ltr; text-align:left; background:#ffffff;"><?php echo esc_textarea(wp_json_encode($opts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></textarea>
                        <div style="margin-top: 0.75rem;">
                            <button type="button" class="button button-secondary" onclick="navigator.clipboard.writeText(document.getElementById('helma_export_box').value); alert('کد پیکربندی حلما در کلیپ‌بورد کپی شد!');">📋 کپی کردن کد تنظیمات</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>

    <style>
        .helma-tab-btn {
            width: 100%;
            text-align: right;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: none;
            background: none;
            font-size: 0.92rem;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            font-family: inherit;
        }
        .helma-tab-btn:hover { background-color: #f8fafc; color: #0f172a; }
        .helma-tab-btn.active { background-color: #f5f3ff; color: #7c3aed; font-weight: 700; border-right: 3px solid #7c3aed; }
        .helma-tab-pane { display: none; }
        .helma-tab-pane.active { display: block; }
        .helma-pane-title { font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 0.4rem 0; }
        .helma-pane-desc { color: #64748b; font-size: 0.9rem; margin: 0 0 1.5rem 0; padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabBtns = document.querySelectorAll('.helma-tab-btn');
            const tabPanes = document.querySelectorAll('.helma-tab-pane');

            tabBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const target = this.getAttribute('data-tab');
                    tabBtns.forEach(b => b.classList.remove('active'));
                    tabPanes.forEach(p => p.classList.remove('active'));
                    this.classList.add('active');
                    const activePane = document.getElementById(target);
                    if (activePane) activePane.classList.add('active');
                });
            });
        });
    </script>
    <?php
}
