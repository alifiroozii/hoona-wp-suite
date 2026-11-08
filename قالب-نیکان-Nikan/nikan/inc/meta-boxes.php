<?php
/**
 * Nikan Doctor & Service Meta Boxes
 *
 * @package Nikan
 */

if (!defined('ABSPATH')) {
    exit;
}

class Nikan_Meta_Boxes {

    public static function init() {
        add_action('add_meta_boxes', [__CLASS__, 'register_meta_boxes']);
        add_action('save_post', [__CLASS__, 'save_meta_boxes']);
    }

    public static function register_meta_boxes() {
        add_meta_box(
            'nikan_doctor_details',
            'اطلاعات و مشخصات تخصصی پزشک',
            [__CLASS__, 'render_doctor_box'],
            ['post', 'page'],
            'normal',
            'high'
        );
    }

    public static function render_doctor_box($post) {
        wp_nonce_field('nikan_save_meta_box', 'nikan_meta_box_nonce');

        $specialty   = get_post_meta($post->ID, '_nikan_doctor_specialty', true);
        $license_no  = get_post_meta($post->ID, '_nikan_doctor_license', true);
        $experience  = get_post_meta($post->ID, '_nikan_doctor_exp', true);
        $fee         = get_post_meta($post->ID, '_nikan_doctor_fee', true);
        $days        = get_post_meta($post->ID, '_nikan_doctor_days', true);
        ?>
        <div style="padding: 10px 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            <p>
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">تخصص و فلوشیپ پزشک:</label>
                <input type="text" name="nikan_doctor_specialty" value="<?php echo esc_attr($specialty); ?>" style="width: 100%;" placeholder="مثلاً: متخصص جراحی فک و صورت / بورد تخصصی">
            </p>
            <p>
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">شماره نظام پزشکی:</label>
                <input type="text" name="nikan_doctor_license" value="<?php echo esc_attr($license_no); ?>" style="width: 100%;" placeholder="مثلاً: ب-۱۲۳۴۵۶">
            </p>
            <p>
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">سابقه طبابت / جراحی (سال):</label>
                <input type="text" name="nikan_doctor_exp" value="<?php echo esc_attr($experience); ?>" style="width: 100%;" placeholder="مثلاً: ۱۵ سال سابقه">
            </p>
            <p>
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">مبلغ بیعانه نوبت‌دهی (تومان):</label>
                <input type="number" name="nikan_doctor_fee" value="<?php echo esc_attr($fee); ?>" style="width: 100%;" placeholder="مثلاً: 100000">
            </p>
            <p>
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">روزهای حضور در کلینیک:</label>
                <input type="text" name="nikan_doctor_days" value="<?php echo esc_attr($days); ?>" style="width: 100%;" placeholder="مثلاً: شنبه تا چهارشنبه، عصرها ۱۶ الی ۲۱">
            </p>
        </div>
        <?php
    }

    public static function save_meta_boxes($post_id) {
        if (!isset($_POST['nikan_meta_box_nonce']) || !wp_verify_nonce($_POST['nikan_meta_box_nonce'], 'nikan_save_meta_box')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['nikan_doctor_specialty'])) {
            update_post_meta($post_id, '_nikan_doctor_specialty', sanitize_text_field($_POST['nikan_doctor_specialty']));
        }
        if (isset($_POST['nikan_doctor_license'])) {
            update_post_meta($post_id, '_nikan_doctor_license', sanitize_text_field($_POST['nikan_doctor_license']));
        }
        if (isset($_POST['nikan_doctor_exp'])) {
            update_post_meta($post_id, '_nikan_doctor_exp', sanitize_text_field($_POST['nikan_doctor_exp']));
        }
        if (isset($_POST['nikan_doctor_fee'])) {
            update_post_meta($post_id, '_nikan_doctor_fee', sanitize_text_field($_POST['nikan_doctor_fee']));
        }
        if (isset($_POST['nikan_doctor_days'])) {
            update_post_meta($post_id, '_nikan_doctor_days', sanitize_text_field($_POST['nikan_doctor_days']));
        }
    }
}

Nikan_Meta_Boxes::init();
