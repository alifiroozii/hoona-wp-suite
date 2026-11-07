<?php
/**
 * Bahar Theme Customizer Settings (Enterprise Version)
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

function bahar_customize_register($wp_customize) {
    // -------------------------------------------------------------
    // Panel: تنظیمات جامع پوسته بهار
    // -------------------------------------------------------------
    $wp_customize->add_panel('bahar_theme_panel', array(
        'title'       => __('تنظیمات پیشرفته پوسته بهار (Bahar)', 'bahar'),
        'description' => __('مدیریت رنگ‌بندی، هدر، بخش‌های صفحه نخست، قیمت‌ها، نظرات و سوالات متداول - توسعه‌داده شده توسط علی فیروزی (شرکت هونا hoonaco.ir)', 'bahar'),
        'priority'    => 20,
    ));

    // =============================================================
    // 1. بخش رنگ‌بندی اختصاصی
    // =============================================================
    $wp_customize->add_section('bahar_colors_section', array(
        'title'    => __('رنگ‌بندی و پالت برند', 'bahar'),
        'panel'    => 'bahar_theme_panel',
        'priority' => 10,
    ));

    $wp_customize->add_setting('bahar_color_primary', array(
        'default'           => '#2563eb',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bahar_color_primary', array(
        'label'    => __('رنگ اصلی (Primary Accent)', 'bahar'),
        'section'  => 'bahar_colors_section',
        'settings' => 'bahar_color_primary',
    )));

    $wp_customize->add_setting('bahar_color_secondary', array(
        'default'           => '#0d9488',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bahar_color_secondary', array(
        'label'    => __('رنگ ثانویه (Secondary Accent)', 'bahar'),
        'section'  => 'bahar_colors_section',
        'settings' => 'bahar_color_secondary',
    )));

    // =============================================================
    // 2. بخش هدر و دکمه اقدام
    // =============================================================
    $wp_customize->add_section('bahar_header_section', array(
        'title'    => __('تنظیمات هدر و دکمه اقدام', 'bahar'),
        'panel'    => 'bahar_theme_panel',
        'priority' => 20,
    ));

    $wp_customize->add_setting('bahar_show_header_cta', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('bahar_show_header_cta', array(
        'label'    => __('نمایش دکمه اقدام در هدر', 'bahar'),
        'section'  => 'bahar_header_section',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting('bahar_header_cta_text', array(
        'default'           => __('شروع همکاری', 'bahar'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('bahar_header_cta_text', array(
        'label'    => __('متن دکمه هدر', 'bahar'),
        'section'  => 'bahar_header_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('bahar_header_cta_url', array(
        'default'           => '#contact',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('bahar_header_cta_url', array(
        'label'    => __('لینک دکمه هدر', 'bahar'),
        'section'  => 'bahar_header_section',
        'type'     => 'url',
    ));

    // =============================================================
    // 3. بخش هیرو صفحه نخست (Hero Section)
    // =============================================================
    $wp_customize->add_section('bahar_hero_section', array(
        'title'    => __('صفحه نخست: بخش هیرو (Hero)', 'bahar'),
        'panel'    => 'bahar_theme_panel',
        'priority' => 30,
    ));

    $wp_customize->add_setting('bahar_show_hero', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('bahar_show_hero', array(
        'label'    => __('نمایش بخش هیرو در صفحه اصلی', 'bahar'),
        'section'  => 'bahar_hero_section',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting('bahar_hero_badge', array(
        'default'           => __('✨ نسخه ۱.۰ پوسته چندمنظوره بهار | شرکت هونا', 'bahar'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('bahar_hero_badge', array(
        'label'    => __('متن نشان بالای عنوان (Badge)', 'bahar'),
        'section'  => 'bahar_hero_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('bahar_hero_title', array(
        'default'           => __('خلق تجربه دیجیتال مدرن، پرسرعت و امن', 'bahar'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('bahar_hero_title', array(
        'label'    => __('عنوان اصلی هیرو', 'bahar'),
        'section'  => 'bahar_hero_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('bahar_hero_desc', array(
        'default'           => __('طراحی و توسعه یافته توسط علی فیروزی در شرکت هونا (hoonaco.ir) با تمرکز بر امنیت نفوذناپذیر، سرعت لود زیر ۱ ثانیه و تایپوگرافی فارسی استاندارد.', 'bahar'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('bahar_hero_desc', array(
        'label'    => __('توضیحات هیرو', 'bahar'),
        'section'  => 'bahar_hero_section',
        'type'     => 'textarea',
    ));

    // =============================================================
    // 4. بخش تعرفه‌ها و قیمت‌گذاری (Pricing Section)
    // =============================================================
    $wp_customize->add_section('bahar_pricing_section', array(
        'title'    => __('صفحه نخست: بخش تعرفه‌ها (Pricing)', 'bahar'),
        'panel'    => 'bahar_theme_panel',
        'priority' => 35,
    ));

    $wp_customize->add_setting('bahar_show_pricing', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('bahar_show_pricing', array(
        'label'    => __('نمایش بخش تعرفه‌ها در صفحه اصلی', 'bahar'),
        'section'  => 'bahar_pricing_section',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting('bahar_pricing_title', array(
        'default'           => __('تعرفه‌ها و پلن‌های سرمایه‌گذاری شفاف', 'bahar'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('bahar_pricing_title', array(
        'label'    => __('عنوان بخش قیمت‌گذاری', 'bahar'),
        'section'  => 'bahar_pricing_section',
        'type'     => 'text',
    ));

    // =============================================================
    // 5. بخش نظرات مشتریان (Testimonials Section)
    // =============================================================
    $wp_customize->add_section('bahar_testimonials_section', array(
        'title'    => __('صفحه نخست: نظرات مشتریان (Testimonials)', 'bahar'),
        'panel'    => 'bahar_theme_panel',
        'priority' => 40,
    ));

    $wp_customize->add_setting('bahar_show_testimonials', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('bahar_show_testimonials', array(
        'label'    => __('نمایش بخش نظرات مشتریان در صفحه اصلی', 'bahar'),
        'section'  => 'bahar_testimonials_section',
        'type'     => 'checkbox',
    ));

    // =============================================================
    // 6. بخش پرسش‌های متداول (FAQ Section)
    // =============================================================
    $wp_customize->add_section('bahar_faq_section', array(
        'title'    => __('صفحه نخست: پرسش‌های متداول (FAQ)', 'bahar'),
        'panel'    => 'bahar_theme_panel',
        'priority' => 45,
    ));

    $wp_customize->add_setting('bahar_show_faq', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('bahar_show_faq', array(
        'label'    => __('نمایش بخش سوالات متداول در صفحه اصلی', 'bahar'),
        'section'  => 'bahar_faq_section',
        'type'     => 'checkbox',
    ));

    // =============================================================
    // 7. بخش فوتر و کپی‌رایت
    // =============================================================
    $wp_customize->add_section('bahar_footer_section', array(
        'title'    => __('تنظیمات فوتر و کپی‌رایت', 'bahar'),
        'panel'    => 'bahar_theme_panel',
        'priority' => 50,
    ));

    $wp_customize->add_setting('bahar_footer_about', array(
        'default'           => __('پوسته حرفه‌ای و امن بهار؛ طراحی و پیاده‌سازی شده با معماری مدرن و بهینه توسط شرکت هونا (hoonaco.ir) برای کسب‌وکارهای پیشرو.', 'bahar'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('bahar_footer_about', array(
        'label'    => __('متن درباره سایت در فوتر', 'bahar'),
        'section'  => 'bahar_footer_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('bahar_copyright_text', array(
        'default'           => __('تمامی حقوق محفوظ است © ۲۰۲۶ | طراح و برنامه‌نویس: علی فیروزی - شرکت هونا (hoonaco.ir)', 'bahar'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('bahar_copyright_text', array(
        'label'    => __('متن کپی‌رایت انتهای فوتر', 'bahar'),
        'section'  => 'bahar_footer_section',
        'type'     => 'text',
    ));
}
add_action('customize_register', 'bahar_customize_register');

/**
 * Enqueue scripts for Customizer live preview
 */
function bahar_customizer_preview_js() {
    wp_enqueue_script(
        'bahar-customizer-preview',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array('customize-preview', 'jquery'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'bahar_customizer_preview_js');
