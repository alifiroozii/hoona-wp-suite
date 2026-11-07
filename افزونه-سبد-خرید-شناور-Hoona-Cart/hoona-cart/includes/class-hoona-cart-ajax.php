<?php
/**
 * مدیریت عملیات ایجکس، بروزرسانی سبد خرید و محاسبه نوار پیشرفت ارسال رایگان
 */

defined('ABSPATH') || exit;

class Hoona_Cart_Ajax {

    public static function init() {
        add_action('wp_ajax_hoona_cart_get_data', [__CLASS__, 'ajax_get_cart_data']);
        add_action('wp_ajax_nopriv_hoona_cart_get_data', [__CLASS__, 'ajax_get_cart_data']);

        add_action('wp_ajax_hoona_cart_update_qty', [__CLASS__, 'ajax_update_qty']);
        add_action('wp_ajax_nopriv_hoona_cart_update_qty', [__CLASS__, 'ajax_update_qty']);

        add_action('wp_ajax_hoona_cart_remove_item', [__CLASS__, 'ajax_remove_item']);
        add_action('wp_ajax_nopriv_hoona_cart_remove_item', [__CLASS__, 'ajax_remove_item']);

        add_action('wp_ajax_hoona_cart_apply_coupon', [__CLASS__, 'ajax_apply_coupon']);
        add_action('wp_ajax_nopriv_hoona_cart_apply_coupon', [__CLASS__, 'ajax_apply_coupon']);
    }

    /**
     * واکشی اطلاعات کامل سبد خرید جهت ساخت کشوی شناور
     */
    public static function ajax_get_cart_data() {
        check_ajax_referer('hoona_cart_nonce_action', 'nonce');

        if (!function_exists('WC') || !WC()->cart) {
            wp_send_json_error(['message' => 'ووکامرس فعال نیست.']);
        }

        $items = [];
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0) {
                $thumbnail = $_product->get_image('woocommerce_thumbnail');
                $price     = WC()->cart->get_product_price($_product);
                $subtotal  = WC()->cart->get_product_subtotal($_product, $cart_item['quantity']);

                $items[] = [
                    'key'       => $cart_item_key,
                    'id'        => $product_id,
                    'name'      => $_product->get_name(),
                    'permalink' => $_product->get_permalink(),
                    'thumbnail' => $thumbnail,
                    'price'     => $price,
                    'subtotal'  => $subtotal,
                    'quantity'  => $cart_item['quantity']
                ];
            }
        }

        $opts = get_option('hoona_cart_options', []);
        $threshold = !empty($opts['free_shipping_min']) ? floatval($opts['free_shipping_min']) : 500000;
        $cart_subtotal_raw = WC()->cart->get_subtotal();

        $remaining = max(0, $threshold - $cart_subtotal_raw);
        $percent   = ($threshold > 0) ? min(100, round(($cart_subtotal_raw / $threshold) * 100)) : 100;

        $shipping_text = '';
        if ($remaining <= 0) {
            $shipping_text = !empty($opts['free_shipping_done']) ? $opts['free_shipping_done'] : '🎉 تبریک! سفارش شما شامل ارسال رایگان شد.';
        } else {
            $formatted_rem = number_format($remaining) . ' ' . (function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : 'تومان');
            $raw_tpl = !empty($opts['free_shipping_txt']) ? $opts['free_shipping_txt'] : 'تنها {amount} تا ارسال رایگان باقی مانده است!';
            $shipping_text = str_replace('{amount}', '<strong>' . $formatted_rem . '</strong>', $raw_tpl);
        }

        wp_send_json_success([
            'count'            => WC()->cart->get_cart_contents_count(),
            'subtotal'         => WC()->cart->get_cart_subtotal(),
            'total'            => WC()->cart->get_total(),
            'items'            => $items,
            'is_empty'         => WC()->cart->is_empty(),
            'shipping_percent' => $percent,
            'shipping_text'    => $shipping_text
        ]);
    }

    /**
     * بروزرسانی تعداد محصول در کشو
     */
    public static function ajax_update_qty() {
        check_ajax_referer('hoona_cart_nonce_action', 'nonce');

        $key = isset($_POST['key']) ? sanitize_text_field($_POST['key']) : '';
        $qty = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

        if (!empty($key) && function_exists('WC') && WC()->cart) {
            if ($qty > 0) {
                WC()->cart->set_quantity($key, $qty, true);
            } else {
                WC()->cart->remove_cart_item($key);
            }
            WC()->cart->calculate_totals();
            self::ajax_get_cart_data();
        } else {
            wp_send_json_error(['message' => 'آیتم یافت نشد.']);
        }
    }

    /**
     * حذف محصول از سبد خرید
     */
    public static function ajax_remove_item() {
        check_ajax_referer('hoona_cart_nonce_action', 'nonce');

        $key = isset($_POST['key']) ? sanitize_text_field($_POST['key']) : '';

        if (!empty($key) && function_exists('WC') && WC()->cart) {
            WC()->cart->remove_cart_item($key);
            WC()->cart->calculate_totals();
            self::ajax_get_cart_data();
        } else {
            wp_send_json_error(['message' => 'شناسه نامعتبر است.']);
        }
    }

    /**
     * اعمال کد تخفیف داخل کشوی سبد
     */
    public static function ajax_apply_coupon() {
        check_ajax_referer('hoona_cart_nonce_action', 'nonce');

        $coupon_code = isset($_POST['coupon_code']) ? sanitize_text_field($_POST['coupon_code']) : '';

        if (empty($coupon_code)) {
            wp_send_json_error(['message' => 'لطفاً کد تخفیف را وارد کنید.']);
        }

        if (function_exists('WC') && WC()->cart) {
            if (WC()->cart->has_discount($coupon_code)) {
                wp_send_json_error(['message' => 'این کد تخفیف قبلاً اعمال شده است.']);
            }

            $applied = WC()->cart->apply_coupon($coupon_code);
            if ($applied) {
                WC()->cart->calculate_totals();
                wp_send_json_success(['message' => 'کد تخفیف با موفقیت اعمال گردید!']);
            } else {
                $err = wc_get_notices('error');
                wc_clear_notices();
                $msg = !empty($err) ? strip_tags($err[0]['notice']) : 'کد تخفیف نامعتبر یا منقضی شده است.';
                wp_send_json_error(['message' => $msg]);
            }
        } else {
            wp_send_json_error(['message' => 'ووکامرس فعال نیست.']);
        }
    }
}

Hoona_Cart_Ajax::init();
