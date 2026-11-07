<?php
/**
 * مدیریت اتصال به درگاه‌ها و خطوط خدماتی پیامک ایران (کاوه نگار، فراز اس‌ام‌اس، ملی‌پیامک، sms.ir)
 */

defined('ABSPATH') || exit;

class Hoona_OTP_Gateway {

    /**
     * ارسال کد اعتبارسنجی از طریق درگاه انتخاب‌شده
     *
     * @param string $phone شماره موبایل مخاطب (مثلاً 09123456789)
     * @param string $code کد تایید ارسالی
     * @return array ['success' => bool, 'message' => string]
     */
    public static function send_code($phone, $code) {
        $settings = get_option('hoona_otp_options', []);
        $gateway  = !empty($settings['gateway']) ? $settings['gateway'] : 'test';
        $api_key  = !empty($settings['api_key']) ? trim($settings['api_key']) : '';
        $pattern  = !empty($settings['pattern_code']) ? trim($settings['pattern_code']) : '';

        // حالت تست یا نبود کلید درگاه
        if ($gateway === 'test' || empty($api_key)) {
            // ذخیره کد در لاگ برای سهولت در تست توسعه‌دهنده
            update_option('hoona_otp_last_test_code_' . $phone, [
                'code' => $code,
                'time' => current_time('mysql')
            ]);
            return [
                'success' => true,
                'message' => 'پیامک در حالت تستی شبیه‌سازی شد (کد تایید: ' . $code . ')'
            ];
        }

        switch ($gateway) {
            case 'kavenegar':
                return self::send_kavenegar($phone, $code, $api_key, $pattern);
            case 'farazsms':
            case 'ippanel':
                return self::send_ippanel($phone, $code, $api_key, $pattern, $settings);
            case 'melipayamak':
                return self::send_melipayamak($phone, $code, $api_key, $pattern);
            case 'smsir':
                return self::send_smsir($phone, $code, $api_key, $pattern);
            default:
                return [
                    'success' => false,
                    'message' => 'درگاه پیامک معتبری تنظیم نشده است.'
                ];
        }
    }

    /**
     * کاوه نگار - متد اعتبارسنجی Lookup (خط خدماتی بدون بلک‌لیست)
     */
    private static function send_kavenegar($phone, $code, $api_key, $template) {
        if (empty($template)) {
            $template = 'verify';
        }
        $url = sprintf(
            'https://api.kavenegar.com/v1/%s/verify/lookup.json?receptor=%s&token=%s&template=%s',
            rawurlencode($api_key),
            rawurlencode($phone),
            rawurlencode($code),
            rawurlencode($template)
        );

        $response = wp_remote_get($url, ['timeout' => 10]);
        if (is_wp_error($response)) {
            return ['success' => false, 'message' => 'خطا در برقراری ارتباط با کاوه‌نگار: ' . $response->get_error_message()];
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($body['return']['status']) && $body['return']['status'] == 200) {
            return ['success' => true, 'message' => 'کد تایید با موفقیت ارسال شد.'];
        }

        $error_msg = isset($body['return']['message']) ? $body['return']['message'] : 'خطای نامشخص از درگاه کاوه‌نگار';
        return ['success' => false, 'message' => $error_msg];
    }

    /**
     * آی‌پی پنل / فراز اس‌ام‌اس - ارسال پترن سریع (زیر ۳ ثانیه)
     */
    private static function send_ippanel($phone, $code, $api_key, $pattern, $settings) {
        $sender = !empty($settings['sender_number']) ? trim($settings['sender_number']) : '+983000505';
        $url    = 'https://rest.ippanel.com/v1/messages/patterns/send';

        $body = [
            'pattern_code' => $pattern,
            'originator'   => $sender,
            'recipient'    => $phone,
            'values'       => [
                'code' => $code
            ]
        ];

        $response = wp_remote_post($url, [
            'timeout' => 10,
            'headers' => [
                'Authorization' => 'AccessKey ' . $api_key,
                'Content-Type'  => 'application/json'
            ],
            'body'    => wp_json_encode($body)
        ]);

        if (is_wp_error($response)) {
            return ['success' => false, 'message' => 'خطا در ارتباط با فراز اس‌ام‌اس: ' . $response->get_error_message()];
        }

        $status_code = wp_remote_retrieve_response_code($response);
        $res_body    = json_decode(wp_remote_retrieve_body($response), true);

        if ($status_code == 200 || (isset($res_body['code']) && $res_body['code'] == 0)) {
            return ['success' => true, 'message' => 'کد تایید با موفقیت ارسال شد.'];
        }

        $err = isset($res_body['message']) ? $res_body['message'] : 'کد خطا: ' . $status_code;
        return ['success' => false, 'message' => $err];
    }

    /**
     * ملی پیامک - وب‌سرویس SendByBaseNumber
     */
    private static function send_melipayamak($phone, $code, $api_key, $body_id) {
        $url = 'https://rest.melipayamak.com/v1/Messages/SendByBaseNumber';
        $payload = [
            'text'   => [$code],
            'to'     => $phone,
            'bodyId' => intval($body_id)
        ];

        $response = wp_remote_post($url, [
            'timeout' => 10,
            'headers' => [
                'Authorization' => $api_key,
                'Content-Type'  => 'application/json'
            ],
            'body'    => wp_json_encode($payload)
        ]);

        if (is_wp_error($response)) {
            return ['success' => false, 'message' => 'خطا در ملی پیامک: ' . $response->get_error_message()];
        }

        $res_body = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($res_body['value']) && intval($res_body['value']) > 15) {
            return ['success' => true, 'message' => 'پیامک با موفقیت ارسال شد.'];
        }

        return ['success' => false, 'message' => 'خطا در پاسخ ملی‌پیامک: ' . wp_remote_retrieve_body($response)];
    }

    /**
     * سامانه جدید SMS.ir - متد Verify
     */
    private static function send_smsir($phone, $code, $api_key, $template_id) {
        $url = 'https://api.sms.ir/v1/send/verify';
        $payload = [
            'mobile'     => $phone,
            'templateId' => intval($template_id),
            'parameters' => [
                [
                    'name'  => 'CODE',
                    'value' => (string)$code
                ]
            ]
        ];

        $response = wp_remote_post($url, [
            'timeout' => 10,
            'headers' => [
                'X-API-KEY'    => $api_key,
                'Content-Type' => 'application/json'
            ],
            'body'    => wp_json_encode($payload)
        ]);

        if (is_wp_error($response)) {
            return ['success' => false, 'message' => 'خطا در سامانه SMS.ir: ' . $response->get_error_message()];
        }

        $res_body = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($res_body['status']) && $res_body['status'] == 1) {
            return ['success' => true, 'message' => 'کد تایید ارسال شد.'];
        }

        $err = isset($res_body['message']) ? $res_body['message'] : 'خطای درگاه SMS.ir';
        return ['success' => false, 'message' => $err];
    }
}
