<?php
/**
 * متاباکس‌های اختصاصی دوره‌های آموزشی در پوسته صدرا
 */

defined('ABSPATH') || exit;

class Sadra_Course_Meta_Boxes {

    public static function init() {
        add_action('add_meta_boxes', [__CLASS__, 'add_meta_boxes']);
        add_action('save_post_course', [__CLASS__, 'save_meta_boxes']);
    }

    public static function add_meta_boxes() {
        add_meta_box(
            'sadra_course_details',
            '🎓 جزئیات دوره آموزشی صدرا',
            [__CLASS__, 'render_course_details'],
            'course',
            'normal',
            'high'
        );
    }

    public static function render_course_details($post) {
        wp_nonce_field('sadra_course_meta_action', 'sadra_course_nonce');

        $duration   = get_post_meta($post->ID, '_course_duration', true);
        $instructor = get_post_meta($post->ID, '_course_instructor', true);
        $level      = get_post_meta($post->ID, '_course_level', true);
        $students   = get_post_meta($post->ID, '_course_students', true);
        $video_url  = get_post_meta($post->ID, '_course_video_url', true);
        $price      = get_post_meta($post->ID, '_course_price', true);
        ?>
        <table class="form-table" dir="rtl">
            <tr>
                <th><label for="course_instructor">مدرس دوره:</label></th>
                <td><input type="text" id="course_instructor" name="course_instructor" value="<?php echo esc_attr($instructor); ?>" class="regular-text" placeholder="مثلاً: مهندس علی فیروزی"></td>
            </tr>
            <tr>
                <th><label for="course_duration">مدت زمان آموزش:</label></th>
                <td><input type="text" id="course_duration" name="course_duration" value="<?php echo esc_attr($duration); ?>" class="regular-text" placeholder="مثلاً: ۲۴ ساعت ویدیو"></td>
            </tr>
            <tr>
                <th><label for="course_level">سطح دوره:</label></th>
                <td>
                    <select id="course_level" name="course_level">
                        <option value="مقدماتی تا پیشرفته" <?php selected($level, 'مقدماتی تا پیشرفته'); ?>>مقدماتی تا پیشرفته</option>
                        <option value="پیشرفته و تخصصی" <?php selected($level, 'پیشرفته و تخصصی'); ?>>پیشرفته و تخصصی</option>
                        <option value="مقدماتی" <?php selected($level, 'مقدماتی'); ?>>مقدماتی</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="course_students">تعداد دانشجویان:</label></th>
                <td><input type="text" id="course_students" name="course_students" value="<?php echo esc_attr($students); ?>" class="regular-text" placeholder="مثلاً: ۱,۴۲۰ نفر"></td>
            </tr>
            <tr>
                <th><label for="course_price">شهریه دوره (تومان):</label></th>
                <td><input type="text" id="course_price" name="course_price" value="<?php echo esc_attr($price); ?>" class="regular-text" placeholder="مثلاً: ۸۵۰,۰۰۰ تومان"></td>
            </tr>
            <tr>
                <th><label for="course_video_url">لینک ویدیو معرفی (پیش‌نمایش رایگان):</label></th>
                <td><input type="url" id="course_video_url" name="course_video_url" value="<?php echo esc_attr($video_url); ?>" class="large-text" dir="ltr" placeholder="https://example.com/intro.mp4"></td>
            </tr>
        </table>
        <?php
    }

    public static function save_meta_boxes($post_id) {
        if (!isset($_POST['sadra_course_nonce']) || !wp_verify_nonce($_POST['sadra_course_nonce'], 'sadra_course_meta_action')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        $fields = ['course_instructor', 'course_duration', 'course_level', 'course_students', 'course_price', 'course_video_url'];
        foreach ($fields as $f) {
            if (isset($_POST[$f])) {
                update_post_meta($post_id, '_' . $f, sanitize_text_field($_POST[$f]));
            }
        }
    }
}

Sadra_Course_Meta_Boxes::init();
