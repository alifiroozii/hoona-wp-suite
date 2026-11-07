<?php
/**
 * مدیریت احراز هویت، اعتبارسنجی OTP، ثبت‌نام و ورود کاربر
 */

defined('ABSPATH') || exit;

class Hoona_OTP_Auth {

    public static function init() {
        // ایجکس ارسال کد
        add_action('wp_ajax_hoona_send_otp', [__CLASS__, 'ajax_send_otp']);
        add_action('wp_ajax_nopriv_hoona_send_otp', [__CLASS__, 'ajax_send_otp']);

        // ایجکس تایید کد و لاگین
        add_action('wp_ajax_hoona_verify_otp', [__CLASS__, 'ajax_verify_otp']);
        add_action('wp_ajax_nopriv_hoona_verify_otp', [__CLASS__, 'ajax_verify_otp']);
    }

    /**
     * استانداردسازی و پاک‌سازی شماره موبایل ایرانی
     */
    public static function clean_phone($phone) {
        // تبدیل اعداد فارسی و عربی به انگلیسی
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $arabic  = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $english = ['0','1','2','3','4','5','6','7','8','9'];
        $phone   = str_replace($persian, $english, $phone);
        $phone   = str_replace($arabic, $english, $phone);

        // حذف فاصله‌ها و کاراکترهای اضافه
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // تبدیل +98 یا 0098 به 0
        if (substr($phone, 0, 4) === '0098') {
            $phone = '0' . substr($phone, 4);
        } elseif (substr($phone, 0, 3) === '098') {
            $phone = '0' . substr($phone, 3);
        } elseif (substr($phone, 0, 2) === '98') {
            $phone = '0' . substr($phone, 2);
        }

        return $phone;
    }

    /**
     * بررسی معتبر بودن فرمت شماره همراه ایرانی
     */
    public static function is_valid_iran_mobile($phone) {
        return (bool) preg_match('/^09[0-9]{9}$/', $phone);
    }

    /**
     * هندلر ایجکس ارسال کد
     */
    public static function ajax_send_otp() {
        check_ajax_referer('hoona_otp_nonce_action', 'nonce');

        $raw_phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        $phone     = self::clean_phone($raw_phone);

        if (!self::is_valid_iran_mobile($phone)) {
            wp_send_json_error(['message' => 'شماره موبایل وارد شده نامعتبر است. فرمت صحیح: 09xxxxxxxxx']);
        }

        // بررسی ضد اسپم و ریت لیمیت بر اساس آی‌پی و شماره
        $ip_hash      = md5(!empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown');
        $rate_key_ip  = 'hoona_otp_rate_ip_' . $ip_hash;
        $rate_key_ph  = 'hoona_otp_rate_ph_' . $phone;

        if (get_transient($rate_key_ph)) {
            wp_send_json_error(['message' => 'لطفاً تا اتمام زمان انتظار برای ارسال مجدد کد شکیبا باشید.']);
        }

        $ip_attempts = (int) get_transient($rate_key_ip);
        if ($ip_attempts >= 5) {
            wp_send_json_error(['message' => 'تعداد تلاش بیش از حد مجاز است. لطفاً ۱۵ دقیقه دیگر تلاش کنید.']);
        }

        // تولید کد تایید ۴ رقمی
        $settings    = get_option('hoona_otp_options', []);
        $code_length = !empty($settings['code_length']) ? intval($settings['code_length']) : 4;
        $expiry_time = !empty($settings['code_expiry']) ? intval($settings['code_expiry']) : 120;

        $min_code = ($code_length === 5) ? 10000 : 1000;
        $max_code = ($code_length === 5) ? 99999 : 9999;
        $code     = (string) wp_rand($min_code, $max_code);

        // ارسال از طریق درگاه پیامک
        $send_result = Hoona_OTP_Gateway::send_code($phone, $code);

        if (!$send_result['success']) {
            wp_send_json_error(['message' => $send_result['message']]);
        }

        // ذخیره کد با هش و مدت انقضا
        set_transient('hoona_otp_data_' . $phone, [
            'hash'     => wp_hash_password($code),
            'attempts' => 0
        ], $expiry_time);

        // تنظیم ریت لیمیت
        set_transient($rate_key_ph, true, $expiry_time);
        set_transient($rate_key_ip, $ip_attempts + 1, 900); // 15 دقیقه

        // آیا کاربر قبلاً عضو بوده است؟
        $user = self::get_user_by_phone($phone);
        $is_new = ($user === false);

        wp_send_json_success([
            'message' => 'کد تایید با موفقیت ارسال شد.',
            'phone'   => $phone,
            'is_new'  => $is_new,
            'timer'   => $expiry_time
        ]);
    }

    /**
     * هندلر ایجکس بررسی کد و لاگین
     */
    public static function ajax_verify_otp() {
        check_ajax_referer('hoona_otp_nonce_action', 'nonce');

        $raw_phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        $code      = isset($_POST['code']) ? sanitize_text_field($_POST['code']) : '';
        $fullname  = isset($_POST['fullname']) ? sanitize_text_field($_POST['fullname']) : '';
        $phone     = self::clean_phone($raw_phone);

        if (empty($code) || !self::is_valid_iran_mobile($phone)) {
            wp_send_json_error(['message' => 'لطفاً کد تایید و شماره همراه را صحیح وارد کنید.']);
        }

        $otp_data = get_transient('hoona_otp_data_' . $phone);

        if (!$otp_data || empty($otp_data['hash'])) {
            wp_send_json_error(['message' => 'کد تایید منقضی شده یا نامعتبر است. لطفاً مجدداً درخواست دهید.']);
        }

        // بررسی تعداد تلاش‌های اشتباه
        if ($otp_data['attempts'] >= 5) {
            delete_transient('hoona_otp_data_' . $phone);
            wp_send_json_error(['message' => 'به علت تلاش‌های اشتباه مکرر، این کد باطل شد. مجدداً کد بگیرید.']);
        }

        // بررسی صحت کد
        if (!wp_check_password($code, $otp_data['hash'])) {
            $otp_data['attempts']++;
            set_transient('hoona_otp_data_' . $phone, $otp_data, 120);
            $remaining = 5 - $otp_data['attempts'];
            wp_send_json_error(['message' => "کد وارد شده اشتباه است. ($remaining تلاش باقیمانده)"]);
        }

        // کد صحیح است؛ حذف کد از حافظه
        delete_transient('hoona_otp_data_' . $phone);
        delete_transient('hoona_otp_rate_ph_' . $phone);

        // پیدا کردن یا ساخت کاربر
        $user = self::get_user_by_phone($phone);

        if (!$user) {
            // ثبت‌نام کاربر جدید
            $username = 'user_' . substr($phone, 4);
            // اطمینان از یکتا بودن نام کاربری
            if (username_exists($username)) {
                $username = 'user_' . $phone;
            }

            $settings  = get_option('hoona_otp_options', []);
            $user_role = !empty($settings['default_role']) ? sanitize_text_field($settings['default_role']) : 'customer';

            $user_id = wp_insert_user([
                'user_login'   => $username,
                'user_pass'    => wp_generate_password(16, true),
                'display_name' => !empty($fullname) ? $fullname : 'کاربر ' . substr($phone, 7),
                'role'         => $user_role
            ]);

            if (is_wp_error($user_id)) {
                wp_send_json_error(['message' => 'خطا در ثبت‌نام: ' . $user_id->get_error_message()]);
            }

            // ذخیره شماره همراه در متادیتا (سازگار با ووکامرس)
            update_user_meta($user_id, 'billing_phone', $phone);
            update_user_meta($user_id, 'hoona_mobile', $phone);
            if (!empty($fullname)) {
                update_user_meta($user_id, 'first_name', $fullname);
            }

            $user = get_user_by('id', $user_id);
        }

        // لاگین خودکار کاربر
        wp_clear_auth_cookie();
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID, true);
        do_action('wp_login', $user->user_login, $user);

        $settings = get_option('hoona_otp_options', []);
        $redirect = !empty($settings['redirect_url']) ? esc_url($settings['redirect_url']) : home_url();

        wp_send_json_success([
            'message'  => 'ورود موفقیت‌آمیز بود. در حال انتقال به سایت...',
            'redirect' => $redirect
        ]);
    }

    /**
     * جستجوی کاربر در دیتابیس بر اساس شماره همراه
     */
    public static function get_user_by_phone($phone) {
        // ۱. جستجو بر اساس متای billing_phone (ووکامرس)
        $users = get_users([
            'meta_key'   => 'billing_phone',
            'meta_value' => $phone,
            'number'     => 1,
            'fields'     => 'all'
        ]);

        if (!empty($users)) {
            return $users[0];
        }

        // ۲. جستجو بر اساس متای hoona_mobile
        $users = get_users([
            'meta_key'   => 'hoona_mobile',
            'meta_value' => $phone,
            'number'     => 1,
            'fields'     => 'all'
        ]);

        if (!empty($users)) {
            return $users[0];
        }

        // ۳. بررسی نام کاربری
        $user_by_login = get_user_by('login', $phone);
        if ($user_by_login) {
            return $user_by_login;
        }

        return false;
    }
}

Hoona_OTP_Auth::init();
