<?php
/**
 * بهینه‌ساز کدهای CSS/JS، فونت‌ها و تبدیل خودکار به WebP
 */

defined('ABSPATH') || exit;

class Rahil_Optimizer {

    public static function init() {
        $opts = get_option('rahil_options', []);

        // تبدیل تصویر به WebP هنگام آپلود
        if (!empty($opts['auto_webp'])) {
            add_filter('wp_handle_upload', [__CLASS__, 'convert_to_webp']);
        }

        // پیش‌بارگذاری فونت‌های فارسی
        if (!empty($opts['preload_fonts'])) {
            add_action('wp_head', [__CLASS__, 'preload_persian_fonts'], 1);
        }
    }

    public static function convert_to_webp($upload) {
        if ($upload['type'] === 'image/jpeg' || $upload['type'] === 'image/png') {
            $file_path = $upload['file'];
            $webp_path = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file_path);

            if (function_exists('imagewebp')) {
                if ($upload['type'] === 'image/jpeg') {
                    $img = imagecreatefromjpeg($file_path);
                } else {
                    $img = imagecreatefrompng($file_path);
                    imagepalettetotruecolor($img);
                    imagealphablending($img, true);
                    imagesavealpha($img, true);
                }
                if ($img) {
                    imagewebp($img, $webp_path, 82);
                    imagedestroy($img);
                }
            }
        }
        return $upload;
    }

    public static function preload_persian_fonts() {
        echo '<link rel="preload" href="' . esc_url(get_template_directory_uri() . '/assets/fonts/Vazirmatn-Bold.woff2') . '" as="font" type="font/woff2" crossorigin>' . "\n";
        echo '<link rel="preload" href="' . esc_url(get_template_directory_uri() . '/assets/fonts/Vazirmatn-Regular.woff2') . '" as="font" type="font/woff2" crossorigin>' . "\n";
    }
}

Rahil_Optimizer::init();
