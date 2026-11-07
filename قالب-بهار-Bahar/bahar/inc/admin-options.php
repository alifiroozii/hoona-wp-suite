<?php
/**
 * Bahar Theme - Admin Theme Options Panel
 *
 * Dedicated, native WordPress Settings Dashboard for Bahar Enterprise.
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

/**
 * Register Admin Menu Page
 */
function bahar_register_admin_options_menu() {
    add_menu_page(
        __('تنظیمات پوسته بهار', 'bahar'),
        __('تنظیمات بهار', 'bahar'),
        'manage_options',
        'bahar-settings',
        'bahar_render_theme_options_page',
        'dashicons-superhero-alt',
        59
    );
}
add_action('admin_menu', 'bahar_register_admin_options_menu');

/**
 * Register Theme Settings in Settings API
 */
function bahar_register_theme_settings() {
    register_setting(
        'bahar_theme_options_group',
        'bahar_theme_options',
        'bahar_sanitize_theme_options'
    );
}
add_action('admin_init', 'bahar_register_theme_settings');

/**
 * Sanitize all options safely
 */
function bahar_sanitize_theme_options($input) {
    $clean = array();

    if (!is_array($input)) {
        return $clean;
    }

    // Colors
    $clean['color_primary']   = isset($input['color_primary']) ? sanitize_hex_color($input['color_primary']) : '#2563eb';
    $clean['color_secondary'] = isset($input['color_secondary']) ? sanitize_hex_color($input['color_secondary']) : '#0d9488';
    $clean['default_theme']   = isset($input['default_theme']) && in_array($input['default_theme'], array('light', 'dark', 'auto'), true) ? $input['default_theme'] : 'light';

    // Header
    $clean['sticky_header']     = !empty($input['sticky_header']) ? 1 : 0;
    $clean['show_search']       = !empty($input['show_search']) ? 1 : 0;
    $clean['show_theme_toggle'] = !empty($input['show_theme_toggle']) ? 1 : 0;
    $clean['show_header_cta']   = !empty($input['show_header_cta']) ? 1 : 0;
    $clean['header_cta_text']   = isset($input['header_cta_text']) ? sanitize_text_field($input['header_cta_text']) : __('شروع همکاری', 'bahar');
    $clean['header_cta_url']    = isset($input['header_cta_url']) ? esc_url_raw($input['header_cta_url']) : '#contact';

    // Homepage Modules
    $clean['show_hero']         = !empty($input['show_hero']) ? 1 : 0;
    $clean['hero_badge']        = isset($input['hero_badge']) ? sanitize_text_field($input['hero_badge']) : '';
    $clean['hero_title']        = isset($input['hero_title']) ? sanitize_text_field($input['hero_title']) : '';
    $clean['hero_desc']         = isset($input['hero_desc']) ? sanitize_textarea_field($input['hero_desc']) : '';
    $clean['show_features']     = !empty($input['show_features']) ? 1 : 0;
    $clean['show_pricing']      = !empty($input['show_pricing']) ? 1 : 0;
    $clean['show_testimonials'] = !empty($input['show_testimonials']) ? 1 : 0;
    $clean['show_faq']          = !empty($input['show_faq']) ? 1 : 0;
    $clean['show_blog']         = !empty($input['show_blog']) ? 1 : 0;
    $clean['show_cta']          = !empty($input['show_cta']) ? 1 : 0;

    // Security
    $clean['enable_sec_headers']   = !empty($input['enable_sec_headers']) ? 1 : 0;
    $clean['hide_wp_version']      = !empty($input['hide_wp_version']) ? 1 : 0;
    $clean['block_user_enum']      = !empty($input['block_user_enum']) ? 1 : 0;
    $clean['disable_xmlrpc_ping']  = !empty($input['disable_xmlrpc_ping']) ? 1 : 0;

    // Blog
    $clean['show_reading_progress']= !empty($input['show_reading_progress']) ? 1 : 0;
    $clean['show_reading_time']    = !empty($input['show_reading_time']) ? 1 : 0;
    $clean['show_social_share']    = !empty($input['show_social_share']) ? 1 : 0;
    $clean['show_related_posts']   = !empty($input['show_related_posts']) ? 1 : 0;

    // Footer
    $clean['footer_about']      = isset($input['footer_about']) ? sanitize_textarea_field($input['footer_about']) : '';
    $clean['copyright_text']    = isset($input['copyright_text']) ? sanitize_text_field($input['copyright_text']) : '';

    // Social & Contacts
    $clean['social_telegram']   = isset($input['social_telegram']) ? esc_url_raw($input['social_telegram']) : '';
    $clean['social_instagram']  = isset($input['social_instagram']) ? esc_url_raw($input['social_instagram']) : '';
    $clean['social_linkedin']   = isset($input['social_linkedin']) ? esc_url_raw($input['social_linkedin']) : '';
    $clean['social_x']          = isset($input['social_x']) ? esc_url_raw($input['social_x']) : '';
    $clean['social_whatsapp']   = isset($input['social_whatsapp']) ? esc_url_raw($input['social_whatsapp']) : '';
    $clean['contact_phone']     = isset($input['contact_phone']) ? sanitize_text_field($input['contact_phone']) : '';
    $clean['contact_email']     = isset($input['contact_email']) ? sanitize_email($input['contact_email']) : '';

    // Custom Code & Scripts (Only users with unfiltered_html can save raw scripts)
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
 * Helper to fetch options (checks Theme Options first, then Customizer, then Default)
 */
function bahar_opt($key, $default = null) {
    $options = get_option('bahar_theme_options');
    if (is_array($options) && isset($options[$key])) {
        return $options[$key];
    }
    // Fallback to get_theme_mod
    $mod = get_theme_mod('bahar_' . $key);
    if ($mod !== false && $mod !== null) {
        return $mod;
    }
    return $default;
}

/**
 * Render Theme Options Dashboard
 */
function bahar_render_theme_options_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $opts = get_option('bahar_theme_options', array());
    ?>
    <div class="wrap bahar-admin-wrap" style="direction: rtl; text-align: right; max-width: 1200px; margin: 20px 20px 0 0;">
        
        <!-- Header Banner -->
        <div style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: #ffffff; padding: 2rem 2.5rem; border-radius: 14px; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.35);">
            <div>
                <div style="background: rgba(255,255,255,0.2); display: inline-block; padding: 3px 12px; border-radius: 999px; font-size: 0.8rem; font-weight: 700; margin-bottom: 0.5rem;">نسخه ۲.۰ اینترپرایز</div>
                <h1 style="color: #ffffff; font-size: 1.8rem; font-weight: 800; margin: 0 0 0.5rem 0;">مرکز مدیریت و تنظیمات پوسته بهار (Bahar)</h1>
                <p style="color: rgba(255,255,255,0.85); margin: 0; font-size: 0.95rem;">مدیریت کامل هویت برند، امنیت، بخش‌های صفحه نخست، هدر، فوتر و بهینه‌سازی سرعت.</p>
            </div>
            <div style="text-align: left; background: rgba(255,255,255,0.12); padding: 1rem 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.2);">
                <div style="font-size: 0.8rem; opacity: 0.85;">طراح و برنامه‌نویس:</div>
                <div style="font-weight: 800; font-size: 1.05rem;">علی فیروزی</div>
                <div style="font-size: 0.85rem; margin-top: 2px;"><a href="https://hoonaco.ir" target="_blank" style="color: #93c5fd; text-decoration: none; font-weight: 600;">شرکت هونا (hoonaco.ir) ↗</a></div>
            </div>
        </div>

        <?php settings_errors(); ?>

        <form method="post" action="options.php" style="display: grid; grid-template-columns: 260px 1fr; gap: 1.75rem; align-items: start;">
            <?php
            settings_fields('bahar_theme_options_group');
            ?>

            <!-- Tabs Navigation -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <ul class="bahar-nav-tabs" style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 0.35rem;">
                    <li><button type="button" class="bahar-tab-btn active" data-tab="tab-general">🎨 عمومی و رنگ‌ها</button></li>
                    <li><button type="button" class="bahar-tab-btn" data-tab="tab-header">🧭 هدر و ناوبری</button></li>
                    <li><button type="button" class="bahar-tab-btn" data-tab="tab-homepage">🏠 بخش‌های صفحه نخست</button></li>
                    <li><button type="button" class="bahar-tab-btn" data-tab="tab-security">🛡️ امنیت و سرعت</button></li>
                    <li><button type="button" class="bahar-tab-btn" data-tab="tab-blog">📰 وبلاگ و مقالات</button></li>
                    <li><button type="button" class="bahar-tab-btn" data-tab="tab-footer">🦶 فوتر و کپی‌رایت</button></li>
                    <li><button type="button" class="bahar-tab-btn" data-tab="tab-social">📱 شبکه‌های اجتماعی و تماس</button></li>
                    <li><button type="button" class="bahar-tab-btn" data-tab="tab-custom">💻 کدهای سفارشی و اسکریپت‌ها</button></li>
                    <li><button type="button" class="bahar-tab-btn" data-tab="tab-backup">💾 خروجی و پشتیبان‌گیری</button></li>
                </ul>

                <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid #f1f5f9; text-align: center;">
                    <?php submit_button(__('ذخیره تمام تنظیمات', 'bahar'), 'primary large', 'submit', false, array('style' => 'width:100%; border-radius:8px; height:42px;')); ?>
                </div>
            </div>

            <!-- Tab Contents Container -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); min-height: 500px;">
                
                <!-- TAB 1: General & Colors -->
                <div class="bahar-tab-pane active" id="tab-general">
                    <h2 class="bahar-pane-title">رنگ‌بندی و هویت بصری پوسته</h2>
                    <p class="bahar-pane-desc">رنگ‌های اصلی سازمانی و تم پیش‌فرض سایت را مشخص کنید.</p>

                    <table class="form-table">
                        <tr>
                            <th scope="row">رنگ اصلی (Primary Accent)</th>
                            <td>
                                <input type="color" name="bahar_theme_options[color_primary]" value="<?php echo esc_attr($opts['color_primary'] ?? '#2563eb'); ?>" style="height:40px; width:60px; padding:0; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" />
                                <span class="description" style="margin-right:10px;">رنگ دکمه‌های اصلی، لینک‌ها و المان‌های فوکوس.</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">رنگ ثانویه (Secondary Accent)</th>
                            <td>
                                <input type="color" name="bahar_theme_options[color_secondary]" value="<?php echo esc_attr($opts['color_secondary'] ?? '#0d9488'); ?>" style="height:40px; width:60px; padding:0; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" />
                                <span class="description" style="margin-right:10px;">رنگ المان‌های کمکی و گرادیان‌ها.</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">حالت نمایشی پیش‌فرض</th>
                            <td>
                                <select name="bahar_theme_options[default_theme]" class="regular-text">
                                    <option value="light" <?php selected($opts['default_theme'] ?? 'light', 'light'); ?>>حالت روشن (Clean Light - پیش‌فرض)</option>
                                    <option value="dark" <?php selected($opts['default_theme'] ?? 'light', 'dark'); ?>>حالت تیره (Dark Mode)</option>
                                    <option value="auto" <?php selected($opts['default_theme'] ?? 'light', 'auto'); ?>>همگام با تم سیستم‌عامل کاربر</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- TAB 2: Header -->
                <div class="bahar-tab-pane" id="tab-header">
                    <h2 class="bahar-pane-title">تنظیمات هدر و دکمه اقدام</h2>
                    <p class="bahar-pane-desc">رفتار و دکمه‌های ناوبری بالای سایت را شخصی‌سازی کنید.</p>

                    <table class="form-table">
                        <tr>
                            <th scope="row">هدر چسبان هوشمند</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="bahar_theme_options[sticky_header]" value="1" <?php checked($opts['sticky_header'] ?? 1, 1); ?> />
                                    چسبیدن هدر به بالای صفحه با افکت بلورین هنگام اسکرول
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">جستجوی سریع ⌘K</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="bahar_theme_options[show_search]" value="1" <?php checked($opts['show_search'] ?? 1, 1); ?> />
                                    نمایش دکمه و کلید میانبر جستجوی زنده در هدر
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">سوئیچر حالت شب/روز</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="bahar_theme_options[show_theme_toggle]" value="1" <?php checked($opts['show_theme_toggle'] ?? 1, 1); ?> />
                                    نمایش دکمه تغییر تم تیره و روشن در هدر
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">دکمه اقدام هدر (CTA)</th>
                            <td>
                                <label style="display:block; margin-bottom:0.75rem;">
                                    <input type="checkbox" name="bahar_theme_options[show_header_cta]" value="1" <?php checked($opts['show_header_cta'] ?? 1, 1); ?> />
                                    نمایش دکمه اقدام در هدر
                                </label>
                                <input type="text" name="bahar_theme_options[header_cta_text]" value="<?php echo esc_attr($opts['header_cta_text'] ?? __('شروع همکاری', 'bahar')); ?>" placeholder="متن دکمه" class="regular-text" style="margin-bottom:0.5rem;" /><br>
                                <input type="url" name="bahar_theme_options[header_cta_url]" value="<?php echo esc_attr($opts['header_cta_url'] ?? '#contact'); ?>" placeholder="نشانی اینترنتی دکمه" class="regular-text" />
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- TAB 3: Homepage Modules -->
                <div class="bahar-tab-pane" id="tab-homepage">
                    <h2 class="bahar-pane-title">مدیریت بخش‌های صفحه اصلی</h2>
                    <p class="bahar-pane-desc">سکشن‌های دلخواه خود را در صفحه اصلی فعال یا غیرفعال کنید.</p>

                    <table class="form-table">
                        <tr>
                            <th scope="row">بخش هیرو (Hero)</th>
                            <td>
                                <label><input type="checkbox" name="bahar_theme_options[show_hero]" value="1" <?php checked($opts['show_hero'] ?? 1, 1); ?> /> نمایش بخش هیرو و معرفی اولیه</label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">بخش امکانات و خدمات</th>
                            <td>
                                <label><input type="checkbox" name="bahar_theme_options[show_features]" value="1" <?php checked($opts['show_features'] ?? 1, 1); ?> /> نمایش ۶ کارت معرفی خدمات و مزایا</label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">بخش نظرات مشتریان</th>
                            <td>
                                <label><input type="checkbox" name="bahar_theme_options[show_testimonials]" value="1" <?php checked($opts['show_testimonials'] ?? 1, 1); ?> /> نمایش کارت‌های بازخورد ۵ ستاره مشتریان</label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">بخش تعرفه‌ها و قیمت‌گذاری</th>
                            <td>
                                <label><input type="checkbox" name="bahar_theme_options[show_pricing]" value="1" <?php checked($opts['show_pricing'] ?? 1, 1); ?> /> نمایش جدول پلن‌های قیمت‌گذاری خدمات</label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">بخش سوالات متداول (FAQ)</th>
                            <td>
                                <label><input type="checkbox" name="bahar_theme_options[show_faq]" value="1" <?php checked($opts['show_faq'] ?? 1, 1); ?> /> نمایش آکاردئون پرسش‌های متداول</label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">بخش آخرین مقالات وبلاگ</th>
                            <td>
                                <label><input type="checkbox" name="bahar_theme_options[show_blog]" value="1" <?php checked($opts['show_blog'] ?? 1, 1); ?> /> نمایش ۳ مقاله جدید وبلاگ در صفحه اصلی</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- TAB 4: Security -->
                <div class="bahar-tab-pane" id="tab-security">
                    <h2 class="bahar-pane-title">امنیت سخت‌گیرانه و بهینه‌سازی (OWASP)</h2>
                    <p class="bahar-pane-desc">تنظیمات حفاظتی برای جلوگیری از آسیب‌پذیری‌ها و حملات سایبری.</p>

                    <table class="form-table">
                        <tr>
                            <th scope="row">هدرهای امنیتی HTTP</th>
                            <td>
                                <label><input type="checkbox" name="bahar_theme_options[enable_sec_headers]" value="1" <?php checked($opts['enable_sec_headers'] ?? 1, 1); ?> /> فعال‌سازی خودکار هدرهای X-Frame-Options و MIME-Sniffing</label>
                                <p class="description">از حملات فیشینگ کلیک‌جکینگ و اسنیف فایل‌های مخرب جلوگیری می‌کند.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">مخفی‌سازی نسخه وردپرس</th>
                            <td>
                                <label><input type="checkbox" name="bahar_theme_options[hide_wp_version]" value="1" <?php checked($opts['hide_wp_version'] ?? 1, 1); ?> /> حذف متاتگ ژنراتور و رشته نگارش (?ver=) از اسکریپت‌ها</label>
                                <p class="description">ربات‌های اسکنر هک نمی‌توانند نسخه هسته وردپرس شما را تشخیص دهند.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">مسدودسازی استخراج نام کاربری</th>
                            <td>
                                <label><input type="checkbox" name="bahar_theme_options[block_user_enum]" value="1" <?php checked($opts['block_user_enum'] ?? 1, 1); ?> /> مسدودسازی درخواست‌های هکری /?author=1</label>
                                <p class="description">مانع از لو رفتن نام کاربری اصلی مدیر سایت در حملات بروت‌فورس می‌شود.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">خنثی‌سازی دیداس پینگ‌بک</th>
                            <td>
                                <label><input type="checkbox" name="bahar_theme_options[disable_xmlrpc_ping]" value="1" <?php checked($opts['disable_xmlrpc_ping'] ?? 1, 1); ?> /> غیرفعال‌سازی پینگ‌بک در XML-RPC</label>
                                <p class="description">از سوءاستفاده از سرور شما به عنوان زامبی در حملات تقویتی DDoS جلوگیری می‌کند.</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- TAB 5: Blog -->
                <div class="bahar-tab-pane" id="tab-blog">
                    <h2 class="bahar-pane-title">تنظیمات مطالعه مقالات و وبلاگ</h2>
                    <p class="bahar-pane-desc">امکانات هوشمند برای افزایش ماندگاری کاربر روی نوشته‌های وبلاگ.</p>

                    <table class="form-table">
                        <tr>
                            <th scope="row">نوار پیشرفت مطالعه</th>
                            <td>
                                <label><input type="checkbox" name="bahar_theme_options[show_reading_progress]" value="1" <?php checked($opts['show_reading_progress'] ?? 1, 1); ?> /> نمایش نوار گرادیانی درصد خوانده شده مقاله در بالای صفحه</label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">محاسبه هوشمند زمان مطالعه</th>
                            <td>
                                <label><input type="checkbox" name="bahar_theme_options[show_reading_time]" value="1" <?php checked($opts['show_reading_time'] ?? 1, 1); ?> /> نمایش تخمین مدت‌زمان مطالعه بر اساس تعداد کلمات فارسی</label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">دکمه‌های اشتراک‌گذاری اجتماعی</th>
                            <td>
                                <label><input type="checkbox" name="bahar_theme_options[show_social_share]" value="1" <?php checked($opts['show_social_share'] ?? 1, 1); ?> /> نمایش دکمه‌های تلگرام، واتساپ، X و کپی آسان لینک</label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">پیشنهاد هوشمند مقالات مرتبط</th>
                            <td>
                                <label><input type="checkbox" name="bahar_theme_options[show_related_posts]" value="1" <?php checked($opts['show_related_posts'] ?? 1, 1); ?> /> بارگذاری خودکار ۳ نوشته مرتبط در انتهای هر مقاله</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- TAB 6: Footer -->
                <div class="bahar-tab-pane" id="tab-footer">
                    <h2 class="bahar-pane-title">تنظیمات فوتر، کپی‌رایت و اطلاعات برند</h2>
                    <p class="bahar-pane-desc">متون بخش پایانی سایت و معرفی شرکت را مدیریت کنید.</p>

                    <table class="form-table">
                        <tr>
                            <th scope="row">متن معرفی در فوتر</th>
                            <td>
                                <textarea name="bahar_theme_options[footer_about]" rows="4" class="large-text"><?php echo esc_textarea($opts['footer_about'] ?? __('پوسته حرفه‌ای و امن بهار؛ طراحی و پیاده‌سازی شده با معماری مدرن و بهینه توسط شرکت هونا (hoonaco.ir) برای کسب‌وکارهای پیشرو.', 'bahar')); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">متن کپی‌رایت انتهای سایت</th>
                            <td>
                                <input type="text" name="bahar_theme_options[copyright_text]" value="<?php echo esc_attr($opts['copyright_text'] ?? __('تمامی حقوق محفوظ است © ۲۰۲۶ | طراح و برنامه‌نویس: علی فیروزی - شرکت هونا (hoonaco.ir)', 'bahar')); ?>" class="large-text" />
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- TAB 7: Social & Contact Info -->
                <div class="bahar-tab-pane" id="tab-social">
                    <h2 class="bahar-pane-title">شبکه‌های اجتماعی و راه‌های ارتباطی</h2>
                    <p class="bahar-pane-desc">لینک کانال‌ها و صفحات اجتماعی خود را برای نمایش خودکار در هدر، فوتر و منوی موبایل وارد کنید.</p>

                    <table class="form-table">
                        <tr>
                            <th scope="row">کانال یا آیدی تلگرام</th>
                            <td>
                                <input type="url" name="bahar_theme_options[social_telegram]" value="<?php echo esc_attr($opts['social_telegram'] ?? ''); ?>" placeholder="https://t.me/yourcompany" class="regular-text" style="direction:ltr; text-align:left;" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">صفحه اینستاگرام</th>
                            <td>
                                <input type="url" name="bahar_theme_options[social_instagram]" value="<?php echo esc_attr($opts['social_instagram'] ?? ''); ?>" placeholder="https://instagram.com/yourcompany" class="regular-text" style="direction:ltr; text-align:left;" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">صفحه لینکدین</th>
                            <td>
                                <input type="url" name="bahar_theme_options[social_linkedin]" value="<?php echo esc_attr($opts['social_linkedin'] ?? ''); ?>" placeholder="https://linkedin.com/company/yourcompany" class="regular-text" style="direction:ltr; text-align:left;" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">حساب توییتر / X</th>
                            <td>
                                <input type="url" name="bahar_theme_options[social_x]" value="<?php echo esc_attr($opts['social_x'] ?? ''); ?>" placeholder="https://x.com/yourcompany" class="regular-text" style="direction:ltr; text-align:left;" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">شماره یا لینک واتس‌اپ</th>
                            <td>
                                <input type="url" name="bahar_theme_options[social_whatsapp]" value="<?php echo esc_attr($opts['social_whatsapp'] ?? ''); ?>" placeholder="https://wa.me/989120000000" class="regular-text" style="direction:ltr; text-align:left;" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">شماره تماس ثابت یا همراه</th>
                            <td>
                                <input type="text" name="bahar_theme_options[contact_phone]" value="<?php echo esc_attr($opts['contact_phone'] ?? ''); ?>" placeholder="۰۲۱-۸۸۸۸۸۸۸۸" class="regular-text" style="direction:ltr; text-align:right;" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">ایمیل رسمی پشتیبانی</th>
                            <td>
                                <input type="email" name="bahar_theme_options[contact_email]" value="<?php echo esc_attr($opts['contact_email'] ?? ''); ?>" placeholder="info@hoonaco.ir" class="regular-text" style="direction:ltr; text-align:left;" />
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- TAB 8: Custom Code & Tracking Scripts -->
                <div class="bahar-tab-pane" id="tab-custom">
                    <h2 class="bahar-pane-title">کدهای سفارشی CSS و اسکریپت‌های ره‌گیری</h2>
                    <p class="bahar-pane-desc">بدون نیاز به ویرایش فایل‌های قالب یا ایجاد Child Theme، کدهای اختصاصی خود را اضافه کنید.</p>

                    <table class="form-table">
                        <tr>
                            <th scope="row">کدهای استایل CSS سفارشی</th>
                            <td>
                                <textarea name="bahar_theme_options[custom_css]" rows="6" class="large-text code" style="direction:ltr; text-align:left;" placeholder="/* استایل‌های اختصاصی شما */&#10;.custom-btn { border-radius: 20px; }"><?php echo esc_textarea($opts['custom_css'] ?? ''); ?></textarea>
                                <p class="description">این کدها به صورت ایمن و خودکار در هدر تمام صفحات سایت بارگذاری می‌شوند.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">اسکریپت‌های سربرگ (Head Scripts)</th>
                            <td>
                                <textarea name="bahar_theme_options[custom_head_js]" rows="5" class="large-text code" style="direction:ltr; text-align:left;" placeholder="<!-- کد گوگل آنالیتیکس یا اسکریپت ره‌گیری -->&#10;<script>...</script>"><?php echo esc_textarea($opts['custom_head_js'] ?? ''); ?></textarea>
                                <p class="description">کدهای ره‌گیری نظیر Google Analytics، تگ منیجر یا متاتگ‌های تایید هویت دامنه.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">اسکریپت‌های پاورقی (Footer Scripts)</th>
                            <td>
                                <textarea name="bahar_theme_options[custom_footer_js]" rows="5" class="large-text code" style="direction:ltr; text-align:left;" placeholder="<!-- کد ابزارک چت آنلاین یا اسکریپت‌های انتهایی -->&#10;<script>...</script>"><?php echo esc_textarea($opts['custom_footer_js'] ?? ''); ?></textarea>
                                <p class="description">کدهایی که قبل از بسته شدن تگ &lt;/body&gt; اجرا می‌شوند (مانند گفتینو، رایچت و غیره).</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- TAB 9: Backup & Export -->
                <div class="bahar-tab-pane" id="tab-backup">
                    <h2 class="bahar-pane-title">پشتیبان‌گیری و انتقال تنظیمات</h2>
                    <p class="bahar-pane-desc">از تمام تنظیمات اعمال شده روی قالب بهار یک نسخه پشتیبان JSON تهیه کنید تا بتوانید روی سایت‌های دیگر بازیابی کنید.</p>

                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1.25rem; margin-bottom: 1.5rem;">
                        <h4 style="margin: 0 0 0.5rem 0; font-size: 1rem; color: #0f172a;">کد پیکربندی زنده قالب (JSON):</h4>
                        <textarea readonly id="bahar_export_box" rows="8" class="large-text code" style="direction:ltr; text-align:left; background:#ffffff;"><?php echo esc_textarea(wp_json_encode($opts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></textarea>
                        <div style="margin-top: 0.75rem; display: flex; gap: 0.75rem;">
                            <button type="button" class="button button-secondary" onclick="navigator.clipboard.writeText(document.getElementById('bahar_export_box').value); alert('کد پیکربندی در کلیپ‌بورد کپی شد!');">📋 کپی کردن کد تنظیمات</button>
                        </div>
                    </div>

                    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 1.25rem;">
                        <h4 style="margin: 0 0 0.5rem 0; font-size: 0.95rem; color: #1e40af;">💡 پشتیبانی و توسعه مداوم</h4>
                        <p style="margin: 0; font-size: 0.85rem; color: #1e3a8a; line-height: 1.7;">
                            پوسته اختصاصی بهار توسط <strong>علی فیروزی</strong> و تحت نظارت شرکت فناوری <strong>هونا (hoonaco.ir)</strong> توسعه یافته است. در صورت نیاز به افزودن قابلیت‌های تجاری اختصاصی، با ما در ارتباط باشید.
                        </p>
                    </div>
                </div>

            </div>
        </form>

    </div>

    <style>
        .bahar-tab-btn {
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
        .bahar-tab-btn:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }
        .bahar-tab-btn.active {
            background-color: #eff6ff;
            color: #2563eb;
            font-weight: 700;
        }
        .bahar-tab-pane {
            display: none;
        }
        .bahar-tab-pane.active {
            display: block;
        }
        .bahar-pane-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 0.4rem 0;
        }
        .bahar-pane-desc {
            color: #64748b;
            font-size: 0.9rem;
            margin: 0 0 1.5rem 0;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabBtns = document.querySelectorAll('.bahar-tab-btn');
            const tabPanes = document.querySelectorAll('.bahar-tab-pane');

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
