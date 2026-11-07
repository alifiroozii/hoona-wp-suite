<?php
/**
 * متاباکس‌های اختصاصی آگهی‌های املاک در پوسته امین
 */

defined('ABSPATH') || exit;

class Amin_Listing_Meta_Boxes {

    public static function init() {
        add_action('add_meta_boxes', [__CLASS__, 'add_meta_boxes']);
        add_action('save_post_listing', [__CLASS__, 'save_meta_boxes']);
    }

    public static function add_meta_boxes() {
        add_meta_box(
            'amin_listing_details',
            '🏢 مشخصات فنی ملک و آگهی امین',
            [__CLASS__, 'render_listing_details'],
            'listing',
            'normal',
            'high'
        );
    }

    public static function render_listing_details($post) {
        wp_nonce_field('amin_listing_meta_action', 'amin_listing_nonce');

        $price_total = get_post_meta($post->ID, '_listing_price_total', true);
        $rent_mortgage = get_post_meta($post->ID, '_listing_rent_mortgage', true);
        $area        = get_post_meta($post->ID, '_listing_area', true);
        $rooms       = get_post_meta($post->ID, '_listing_rooms', true);
        $floor       = get_post_meta($post->ID, '_listing_floor', true);
        $parking     = get_post_meta($post->ID, '_listing_parking', true);
        $elevator    = get_post_meta($post->ID, '_listing_elevator', true);
        $contact_tel = get_post_meta($post->ID, '_listing_contact_tel', true);
        $location    = get_post_meta($post->ID, '_listing_location', true);
        ?>
        <table class="form-table" dir="rtl">
            <tr>
                <th><label for="listing_price_total">قیمت کل / ودیعه (تومان):</label></th>
                <td><input type="text" id="listing_price_total" name="listing_price_total" value="<?php echo esc_attr($price_total); ?>" class="regular-text" placeholder="مثلاً: ۴,۸۰۰,۰۰۰,۰۰۰ تومان"></td>
            </tr>
            <tr>
                <th><label for="listing_rent_mortgage">اجاره ماهانه (در صورت اجاره):</label></th>
                <td><input type="text" id="listing_rent_mortgage" name="listing_rent_mortgage" value="<?php echo esc_attr($rent_mortgage); ?>" class="regular-text" placeholder="مثلاً: ۱۵,۰۰۰,۰۰۰ تومان"></td>
            </tr>
            <tr>
                <th><label for="listing_area">متراژ (متر مربع):</label></th>
                <td><input type="number" id="listing_area" name="listing_area" value="<?php echo esc_attr($area); ?>" class="small-text" placeholder="110"> متر</td>
            </tr>
            <tr>
                <th><label for="listing_rooms">تعداد اتاق خواب:</label></th>
                <td><input type="number" id="listing_rooms" name="listing_rooms" value="<?php echo esc_attr($rooms); ?>" class="small-text" min="0" max="10"></td>
            </tr>
            <tr>
                <th>امکانات ملک:</th>
                <td>
                    <label><input type="checkbox" name="listing_parking" value="1" <?php checked($parking, 1); ?>> پارکینگ سندی</label>&nbsp;&nbsp;
                    <label><input type="checkbox" name="listing_elevator" value="1" <?php checked($elevator, 1); ?>> آسانسور</label>
                </td>
            </tr>
            <tr>
                <th><label for="listing_location">محله / منطقه:</label></th>
                <td><input type="text" id="listing_location" name="listing_location" value="<?php echo esc_attr($location); ?>" class="regular-text" placeholder="مثلاً: تهران، سعادت‌آباد"></td>
            </tr>
            <tr>
                <th><label for="listing_contact_tel">شماره تماس آگهی‌دهنده:</label></th>
                <td><input type="text" id="listing_contact_tel" name="listing_contact_tel" value="<?php echo esc_attr($contact_tel); ?>" class="regular-text" dir="ltr" placeholder="09121234567"></td>
            </tr>
        </table>
        <?php
    }

    public static function save_meta_boxes($post_id) {
        if (!isset($_POST['amin_listing_nonce']) || !wp_verify_nonce($_POST['amin_listing_nonce'], 'amin_listing_meta_action')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        $fields = ['listing_price_total', 'listing_rent_mortgage', 'listing_area', 'listing_rooms', 'listing_location', 'listing_contact_tel'];
        foreach ($fields as $f) {
            if (isset($_POST[$f])) {
                update_post_meta($post_id, '_' . $f, sanitize_text_field($_POST[$f]));
            }
        }
        update_post_meta($post_id, '_listing_parking', !empty($_POST['listing_parking']) ? 1 : 0);
        update_post_meta($post_id, '_listing_elevator', !empty($_POST['listing_elevator']) ? 1 : 0);
    }
}

Amin_Listing_Meta_Boxes::init();
