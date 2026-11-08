<?php
/**
 * Nikan Medical Theme Options & Management Dashboard
 *
 * @package Nikan
 */

if (!defined('ABSPATH')) {
    exit;
}

class Nikan_Admin_Options {

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'add_theme_menu']);
        add_action('admin_init', [__CLASS__, 'register_settings']);
    }

    public static function add_theme_menu() {
        add_menu_page(
            'تنظیمات قالب پزشکی نیکان',
            '🏥 تنظیمات نیکان',
            'manage_options',
            'nikan-options',
            [__CLASS__, 'render_options_page'],
            'dashicons-heart',
            58
        );
    }

    public static function register_settings() {
        register_setting('nikan_options_group', 'nikan_theme_options', [
            'sanitize_callback' => [__CLASS__, 'sanitize_options']
        ]);
    }

    public static function sanitize_options($input) {
        $clean = [];
        $clean['clinic_name']     = sanitize_text_field($input['clinic_name'] ?? 'کلینیک تخصصی و جراحی نیکان');
        $clean['clinic_phone']    = sanitize_text_field($input['clinic_phone'] ?? '021-88776655');
        $clean['emergency_phone'] = sanitize_text_field($input['emergency_phone'] ?? '09120000000');
        $clean['whatsapp']        = sanitize_text_field($input['whatsapp'] ?? '09120000000');
        $clean['address']         = sanitize_text_field($input['address'] ?? 'تهران، خیابان ولیعصر، بالاتر از توانیر، ساختمان پزشکان نیکان');
        $clean['working_hours']   = sanitize_text_field($input['working_hours'] ?? 'همه روزه از ۸ صبح الی ۲۱');
        
        $clean['enable_booking']  = !empty($input['enable_booking']) ? 1 : 0;
        $clean['booking_fee']     = intval($input['booking_fee'] ?? 100000);
        $clean['slot_duration']   = intval($input['slot_duration'] ?? 20);
        
        $clean['primary_color']   = sanitize_hex_color($input['primary_color'] ?? '#0d9488');
        $clean['secondary_color'] = sanitize_hex_color($input['secondary_color'] ?? '#0284c7');
        
        $clean['enable_sms']      = !empty($input['enable_sms']) ? 1 : 0;
        $clean['sms_provider']    = sanitize_text_field($input['sms_provider'] ?? 'kavenegar');
        $clean['sms_api_key']     = sanitize_text_field($input['sms_api_key'] ?? '');
        $clean['footer_text']     = sanitize_text_field($input['footer_text'] ?? 'تمامی حقوق متعلق به کلینیک تخصصی نیکان می‌باشد.');

        return $clean;
    }

    public static function render_options_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        $opts = get_option('nikan_theme_options', [
            'clinic_name'     => 'کلینیک تخصصی و جراحی نیکان',
            'clinic_phone'    => '021-88776655',
            'emergency_phone' => '09120000000',
            'whatsapp'        => '09120000000',
            'address'         => 'تهران، خیابان ولیعصر، بالاتر از توانیر، ساختمان پزشکان نیکان',
            'working_hours'   => 'همه روزه از ۸ صبح الی ۲۱',
            'enable_booking'  => 1,
            'booking_fee'     => 100000,
            'slot_duration'   => 20,
            'primary_color'   => '#0d9488',
            'secondary_color' => '#0284c7',
            'enable_sms'      => 1,
            'sms_provider'    => 'kavenegar',
            'sms_api_key'     => '',
            'footer_text'     => 'تمامی حقوق برای کلینیک تخصصی نیکان محفوظ است.'
        ]);

        $bookings = get_option('nikan_all_bookings', []);
        ?>
        <div class="wrap nikan-wrap" style="max-width: 1050px; margin-top: 25px; direction: rtl;">
            <div style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%); color: #fff; padding: 25px 30px; border-radius: 14px; margin-bottom: 25px; box-shadow: 0 10px 25px -5px rgba(13, 148, 136, 0.4);">
                <span style="background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">نسخه ۱.۰.۰ &bull; کاملاً اختصاصی و متن‌باز GPLv2</span>
                <h1 style="color: #fff; margin: 10px 0 6px; font-size: 24px; font-weight: 800;">🏥 پنل مدیریت کلینیک و نوبت‌دهی آنلاین نیکان</h1>
                <p style="margin: 0; color: #ccfbf1; font-size: 13.5px;">توسعه‌یافته توسط مهندس علی فیروزی | شرکت هوشمندسازی و وب هونا (<a href="https://hoonaco.ir" target="_blank" style="color: #fff; text-decoration: underline; font-weight: 700;">hoonaco.ir</a>)</p>
            </div>

            <?php if (isset($_GET['settings-updated'])) : ?>
                <div class="notice notice-success is-dismissible" style="padding: 12px; border-radius: 8px;">
                    <p><strong>تنظیمات کلینیک نیکان با موفقیت ذخیره شد.</strong></p>
                </div>
            <?php endif; ?>

            <div style="background: #fff; border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <div style="display: flex; background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 0 15px;">
                    <button class="nikan-tab active" onclick="openTab(event, 'tab-info')"><i class="dashicons dashicons-building"></i> ۱. مشخصات کلینیک</button>
                    <button class="nikan-tab" onclick="openTab(event, 'tab-booking')"><i class="dashicons dashicons-calendar-alt"></i> ۲. نوبت‌دهی آنلاین</button>
                    <button class="nikan-tab" onclick="openTab(event, 'tab-slider')"><i class="dashicons dashicons-images-alt2"></i> ۳. اسلایدر قبل/بعد</button>
                    <button class="nikan-tab" onclick="openTab(event, 'tab-design')"><i class="dashicons dashicons-art"></i> ۴. رنگ و برندینگ</button>
                    <button class="nikan-tab" onclick="openTab(event, 'tab-list')"><i class="dashicons dashicons-groups"></i> ۵. لیست نوبت‌ها (<?php echo count($bookings); ?>)</button>
                    <button class="nikan-tab" onclick="openTab(event, 'tab-sms')"><i class="dashicons dashicons-email-alt"></i> ۶. پیامک هوشمند</button>
                    <button class="nikan-tab" onclick="openTab(event, 'tab-footer')"><i class="dashicons dashicons-admin-generic"></i> ۷. فوتر و کپی‌رایت</button>
                </div>

                <form method="post" action="options.php" style="padding: 30px;">
                    <?php settings_fields('nikan_options_group'); ?>

                    <!-- Tab 1 -->
                    <div id="tab-info" class="nikan-content" style="display: block;">
                        <h3>مشخصات و آدرس کلینیک</h3>
                        <table class="form-table">
                            <tr>
                                <th>نام کلینیک / مجتمع پزشکی:</th>
                                <td><input type="text" name="nikan_theme_options[clinic_name]" value="<?php echo esc_attr($opts['clinic_name']); ?>" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th>تلفن پذیرش و نوبت‌دهی:</th>
                                <td><input type="text" name="nikan_theme_options[clinic_phone]" value="<?php echo esc_attr($opts['clinic_phone']); ?>" class="regular-text" style="direction: ltr;"></td>
                            </tr>
                            <tr>
                                <th>شماره تماس اورژانس:</th>
                                <td><input type="text" name="nikan_theme_options[emergency_phone]" value="<?php echo esc_attr($opts['emergency_phone']); ?>" class="regular-text" style="direction: ltr;"></td>
                            </tr>
                            <tr>
                                <th>شماره واتساپ مشاوره:</th>
                                <td><input type="text" name="nikan_theme_options[whatsapp]" value="<?php echo esc_attr($opts['whatsapp']); ?>" class="regular-text" style="direction: ltr;"></td>
                            </tr>
                            <tr>
                                <th>آدرس مطب / کلینیک:</th>
                                <td><input type="text" name="nikan_theme_options[address]" value="<?php echo esc_attr($opts['address']); ?>" class="large-text"></td>
                            </tr>
                            <tr>
                                <th>ساعات کاری و پذیرش:</th>
                                <td><input type="text" name="nikan_theme_options[working_hours]" value="<?php echo esc_attr($opts['working_hours']); ?>" class="regular-text"></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tab 2 -->
                    <div id="tab-booking" class="nikan-content" style="display: none;">
                        <h3>پیکربندی سامانه رزرو نوبت آنلاین</h3>
                        <table class="form-table">
                            <tr>
                                <th>فعال‌سازی رزرو آنلاین:</th>
                                <td>
                                    <label><input type="checkbox" name="nikan_theme_options[enable_booking]" value="1" <?php checked(1, $opts['enable_booking']); ?>> فعال بودن فرم رزرو نوبت در سایت</label>
                                </td>
                            </tr>
                            <tr>
                                <th>مبلغ بیعانه هر ویزیت (تومان):</th>
                                <td><input type="number" name="nikan_theme_options[booking_fee]" value="<?php echo esc_attr($opts['booking_fee']); ?>" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th>طول بازه زمانی هر ویزیت (دقیقه):</th>
                                <td>
                                    <select name="nikan_theme_options[slot_duration]">
                                        <option value="15" <?php selected(15, $opts['slot_duration']); ?>>۱۵ دقیقه</option>
                                        <option value="20" <?php selected(20, $opts['slot_duration']); ?>>۲۰ دقیقه (پیشنهادی)</option>
                                        <option value="30" <?php selected(30, $opts['slot_duration']); ?>>۳۰ دقیقه</option>
                                        <option value="45" <?php selected(45, $opts['slot_duration']); ?>>۴۵ دقیقه</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tab 3 -->
                    <div id="tab-slider" class="nikan-content" style="display: none;">
                        <h3>اسلایدر لمسی قبل و بعد جراحی و درمان</h3>
                        <p style="color: #64748b;">این اسلایدر به مراجعین اجازه می‌دهد با کشیدن یک خط جداکننده لمسی، تفاوت قبل و بعد جراحی یا خدمات زیبایی را مشاهده کنند.</p>
                        <div style="background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                            <p><strong>جفت تصویر شماره ۱ (نمونه جراحی زیبایی / ایمپلنت):</strong></p>
                            <p>تصویر قبل درمان (Before): <input type="text" class="regular-text" value="assets/images/before-sample.jpg" placeholder="آدرس تصویر"></p>
                            <p>تصویر بعد درمان (After): <input type="text" class="regular-text" value="assets/images/after-sample.jpg" placeholder="آدرس تصویر"></p>
                            <p>برچسب نمونه: <input type="text" class="regular-text" value="ایمپلنت دیجیتال کامل فک بالا"></p>
                        </div>
                    </div>

                    <!-- Tab 4 -->
                    <div id="tab-design" class="nikan-content" style="display: none;">
                        <h3>رنگ‌بندی سازمانی و هویت بصری</h3>
                        <table class="form-table">
                            <tr>
                                <th>رنگ اصلی کلینیک (Medical Teal):</th>
                                <td><input type="color" name="nikan_theme_options[primary_color]" value="<?php echo esc_attr($opts['primary_color']); ?>"></td>
                            </tr>
                            <tr>
                                <th>رنگ ثانویه (Cobalt Blue):</th>
                                <td><input type="color" name="nikan_theme_options[secondary_color]" value="<?php echo esc_attr($opts['secondary_color']); ?>"></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tab 5 -->
                    <div id="tab-list" class="nikan-content" style="display: none;">
                        <h3>آخرین نوبت‌های ثبت‌شده بیماران</h3>
                        <?php if (empty($bookings)) : ?>
                            <p style="color: #64748b;">هنوز نوبتی در سایت ثبت نشده است.</p>
                        <?php else : ?>
                            <table class="widefat striped">
                                <thead>
                                    <tr>
                                        <th>کد پیگیری</th>
                                        <th>نام بیمار</th>
                                        <th>شماره تماس</th>
                                        <th>پزشک انتخابی</th>
                                        <th>تاریخ و ساعت</th>
                                        <th>وضعیت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_reverse($bookings) as $b) : ?>
                                        <tr>
                                            <td><strong><?php echo esc_html($b['tracking_code']); ?></strong></td>
                                            <td><?php echo esc_html($b['name']); ?></td>
                                            <td><?php echo esc_html($b['phone']); ?></td>
                                            <td><?php echo esc_html($b['doctor']); ?></td>
                                            <td><?php echo esc_html($b['date'] . ' ساعت ' . $b['time']); ?></td>
                                            <td><span style="background: #dcfce7; color: #15803d; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">تایید شده</span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>

                    <!-- Tab 6 -->
                    <div id="tab-sms" class="nikan-content" style="display: none;">
                        <h3>تنظیمات پیامک نوبت‌دهی</h3>
                        <table class="form-table">
                            <tr>
                                <th>ارسال پیامک تایید نوبت:</th>
                                <td><label><input type="checkbox" name="nikan_theme_options[enable_sms]" value="1" <?php checked(1, $opts['enable_sms']); ?>> ارسال خودکار پیامک حاوی تاریخ، ساعت و کد پیگیری به بیمار</label></td>
                            </tr>
                            <tr>
                                <th>سامانه پیامکی:</th>
                                <td>
                                    <select name="nikan_theme_options[sms_provider]">
                                        <option value="kavenegar" <?php selected('kavenegar', $opts['sms_provider']); ?>>کاوه نگار (Kavenegar)</option>
                                        <option value="farazsms" <?php selected('farazsms', $opts['sms_provider']); ?>>فراز اس‌ام‌اس / IPPanel</option>
                                        <option value="melipayamak" <?php selected('melipayamak', $opts['sms_provider']); ?>>ملی پیامک</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>کلید وب‌سرویس (API Key):</th>
                                <td><input type="text" name="nikan_theme_options[sms_api_key]" value="<?php echo esc_attr($opts['sms_api_key']); ?>" class="regular-text" style="direction: ltr;"></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tab 7 -->
                    <div id="tab-footer" class="nikan-content" style="display: none;">
                        <h3>فوتر و مجوزهای درمانی</h3>
                        <table class="form-table">
                            <tr>
                                <th>متن کپی‌رایت فوتر:</th>
                                <td><input type="text" name="nikan_theme_options[footer_text]" value="<?php echo esc_attr($opts['footer_text']); ?>" class="large-text"></td>
                            </tr>
                        </table>
                    </div>

                    <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #f1f5f9;">
                        <?php submit_button('ذخیره تغییرات قالب نیکان', 'primary', 'submit', false, ['style' => 'background: #0d9488; border-color: #0f766e; font-weight: bold; padding: 6px 24px; border-radius: 8px;']); ?>
                    </div>
                </form>
            </div>
        </div>

        <script>
        function openTab(evt, tabName) {
            evt.preventDefault();
            var contents = document.getElementsByClassName("nikan-content");
            for (var i = 0; i < contents.length; i++) {
                contents[i].style.display = "none";
            }
            var tabs = document.getElementsByClassName("nikan-tab");
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove("active");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.classList.add("active");
        }
        </script>

        <style>
        .nikan-tab {
            padding: 14px 18px;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            font-size: 13.5px;
            font-weight: 700;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .nikan-tab:hover { color: #0d9488; }
        .nikan-tab.active {
            color: #0d9488;
            border-bottom-color: #0d9488;
            background: #fff;
        }
        </style>
        <?php
    }
}

Nikan_Admin_Options::init();
