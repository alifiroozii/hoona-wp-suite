<?php
/**
 * Helma Theme Customizer
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

function helma_customize_register($wp_customize) {
    // Theme options section in Customizer
    $wp_customize->add_section('helma_color_section', array(
        'title'    => __('رنگ‌بندی نئونی حلما', 'helma'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('helma_glow_primary', array(
        'default'           => '#8b5cf6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'helma_glow_primary', array(
        'label'    => __('رنگ درخشش اصلی (Neon Glow)', 'helma'),
        'section'  => 'helma_color_section',
        'settings' => 'helma_glow_primary',
    )));
}
add_action('customize_register', 'helma_customize_register');
