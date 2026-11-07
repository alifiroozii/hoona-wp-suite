<?php
/**
 * موتور تولید و رندر فاکتورهای رسمی دارایی، دیجی‌کالایی و برچسب پستی
 */

defined('ABSPATH') || exit;

class Meysam_Invoice_Generator {

    public static function render_print_page($order_id, $type = 'standard') {
        $order = wc_get_order($order_id);
        if (!$order) {
            wp_die('سفارش یافت نشد.');
        }

        $opts = get_option('meysam_inv_options', []);
        ?>
        <!DOCTYPE html>
        <html lang="fa" dir="rtl">
        <head>
            <meta charset="UTF-8">
            <title>فاکتور سفارش #<?php echo $order_id; ?> | افزونه میثم</title>
            <link rel="stylesheet" href="<?php echo MEYSAM_INV_URL; ?>assets/css/invoice-print.css">
            <script>window.onload = function() { window.print(); };</script>
        </head>
        <body class="meysam-print-body <?php echo esc_attr($type); ?>">
            <div class="print-toolbar no-print">
                <button onclick="window.print()">🖨️ چاپ فاکتور</button>
                <button onclick="window.close()">بستن پنجره</button>
            </div>

            <?php
            switch ($type) {
                case 'tax':
                    self::render_tax_invoice($order, $opts);
                    break;
                case 'thermal':
                    self::render_thermal_receipt($order, $opts);
                    break;
                case 'label':
                    self::render_shipping_label($order, $opts);
                    break;
                case 'standard':
                default:
                    self::render_modern_invoice($order, $opts);
                    break;
            }
            ?>
        </body>
        </html>
        <?php
    }

    /**
     * ۱. فاکتور مدرن دیجی‌کالایی با بارکد و QR کد
     */
    public static function render_modern_invoice($order, $opts) {
        $store_name = !empty($opts['seller_name']) ? esc_html($opts['seller_name']) : get_bloginfo('name');
        ?>
        <div class="meysam-invoice-sheet a4">
            <header class="inv-header">
                <div class="store-info">
                    <h2><?php echo $store_name; ?></h2>
                    <p>فاکتور رسمی فروش کالا و خدمات</p>
                </div>
                <div class="order-meta-box">
                    <div>شماره سفارش: <strong>#<?php echo $order->get_id(); ?></strong></div>
                    <div>تاریخ ثبت: <strong><?php echo date_i18n('Y/m/d', strtotime($order->get_date_created())); ?></strong></div>
                    <div>وضعیت: <strong><?php echo wc_get_order_status_name($order->get_status()); ?></strong></div>
                </div>
            </header>

            <div class="parties-grid">
                <div class="party-box seller">
                    <h4>مشخصات فروشنده</h4>
                    <p>نام: <?php echo $store_name; ?></p>
                    <p>تلفن: <?php echo esc_html($opts['seller_phone'] ?? '021-88889999'); ?></p>
                    <p>آدرس: <?php echo esc_html($opts['seller_address'] ?? 'تهران'); ?></p>
                </div>
                <div class="party-box buyer">
                    <h4>مشخصات خریدار</h4>
                    <p>نام: <?php echo esc_html($order->get_formatted_billing_full_name()); ?></p>
                    <p>تلفن همراه: <?php echo esc_html($order->get_billing_phone()); ?></p>
                    <p>آدرس تحویل: <?php echo esc_html($order->get_shipping_address_1() ?: $order->get_billing_address_1()); ?></p>
                </div>
            </div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>شرح کالا / خدمات</th>
                        <th>تعداد</th>
                        <th>مبلغ واحد</th>
                        <th>مبلغ کل</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($order->get_items() as $item_id => $item) {
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo esc_html($item->get_name()); ?></td>
                            <td><?php echo esc_html($item->get_quantity()); ?></td>
                            <td><?php echo wc_price($order->get_item_subtotal($item, false, true)); ?></td>
                            <td><?php echo wc_price($order->get_line_total($item, false, true)); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-left"><strong>جمع کل اقلام:</strong></td>
                        <td><?php echo wc_price($order->get_subtotal()); ?></td>
                    </tr>
                    <?php if ($order->get_shipping_total() > 0) : ?>
                    <tr>
                        <td colspan="4" class="text-left">هزینه ارسال:</td>
                        <td><?php echo wc_price($order->get_shipping_total()); ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr class="total-row">
                        <td colspan="4" class="text-left"><strong>مبلغ نهایی پرداخت شده:</strong></td>
                        <td><strong><?php echo wc_price($order->get_total()); ?></strong></td>
                    </tr>
                </tfoot>
            </table>

            <footer class="inv-footer">
                <div class="signatures">
                    <div>مهر و امضای فروشنده</div>
                    <div>امضای تحویل‌گیرنده</div>
                </div>
                <div class="inv-credit">تولید شده با افزونه فاکتور میثم | شرکت هونا (hoonaco.ir)</div>
            </footer>
        </div>
        <?php
    }

    /**
     * ۲. برچسب پستی پست پیشتاز و تیپاکس
     */
    public static function render_shipping_label($order, $opts) {
        $sender_name = !empty($opts['seller_name']) ? esc_html($opts['seller_name']) : get_bloginfo('name');
        ?>
        <div class="meysam-label-sheet a5">
            <div class="label-box">
                <div class="label-header">
                    <span>📦 برچسب ارسال مرسوله پستی</span>
                    <span>سفارش: <strong>#<?php echo $order->get_id(); ?></strong></span>
                </div>
                <div class="label-section sender">
                    <strong>فرستنده:</strong>
                    <p><?php echo $sender_name; ?> - تلفن: <?php echo esc_html($opts['seller_phone'] ?? '021-88889999'); ?></p>
                    <p>آدرس: <?php echo esc_html($opts['seller_address'] ?? 'تهران'); ?> - کدپستی: <?php echo esc_html($opts['seller_postcode'] ?? '1234567890'); ?></p>
                </div>
                <div class="label-section receiver">
                    <strong>گیرنده:</strong>
                    <h3><?php echo esc_html($order->get_formatted_shipping_full_name() ?: $order->get_formatted_billing_full_name()); ?></h3>
                    <p><strong>تلفن تماس:</strong> <?php echo esc_html($order->get_billing_phone()); ?></p>
                    <p><strong>استان و شهر:</strong> <?php echo esc_html($order->get_shipping_state() . ' - ' . $order->get_shipping_city()); ?></p>
                    <p><strong>آدرس پستی:</strong> <?php echo esc_html($order->get_shipping_address_1() ?: $order->get_billing_address_1()); ?></p>
                    <p><strong>کد پستی ۱۰ رقمی:</strong> <span class="postcode-badge"><?php echo esc_html($order->get_shipping_postcode() ?: $order->get_billing_postcode()); ?></span></p>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * ۳. پرینت حرارتی ۸ سانتی‌متری فیش‌پرینتر
     */
    public static function render_thermal_receipt($order, $opts) {
        ?>
        <div class="meysam-thermal-sheet">
            <div class="receipt-header">
                <h3><?php echo !empty($opts['seller_name']) ? esc_html($opts['seller_name']) : get_bloginfo('name'); ?></h3>
                <p>فیش سفارش #<?php echo $order->get_id(); ?></p>
                <hr>
            </div>
            <div class="receipt-body">
                <p>مشتری: <?php echo esc_html($order->get_formatted_billing_full_name()); ?></p>
                <p>تلفن: <?php echo esc_html($order->get_billing_phone()); ?></p>
                <hr>
                <table style="width:100%; font-size:12px;">
                    <?php foreach ($order->get_items() as $item) : ?>
                    <tr>
                        <td><?php echo esc_html($item->get_name()); ?> (×<?php echo $item->get_quantity(); ?>)</td>
                        <td style="text-align:left;"><?php echo wc_price($item->get_total()); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <hr>
                <p><strong>جمع کل: <?php echo wc_price($order->get_total()); ?></strong></p>
                <p style="text-align:center; font-size:11px; margin-top:14px;">از خرید شما متشکریم!</p>
            </div>
        </div>
        <?php
    }
}
