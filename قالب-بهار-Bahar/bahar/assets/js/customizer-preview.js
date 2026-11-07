/**
 * Bahar Theme Customizer Live Preview
 */
(function ($) {
    'use strict';

    // Primary Color
    wp.customize('bahar_color_primary', function (value) {
        value.bind(function (newVal) {
            document.documentElement.style.setProperty('--color-primary', newVal);
        });
    });

    // Secondary Color
    wp.customize('bahar_color_secondary', function (value) {
        value.bind(function (newVal) {
            document.documentElement.style.setProperty('--color-secondary', newVal);
        });
    });

    // Header CTA Text
    wp.customize('bahar_header_cta_text', function (value) {
        value.bind(function (newVal) {
            $('.header-actions .btn-primary').text(newVal);
        });
    });

    // Hero Badge
    wp.customize('bahar_hero_badge', function (value) {
        value.bind(function (newVal) {
            $('.hero-badge').text(newVal);
        });
    });

    // Hero Title
    wp.customize('bahar_hero_title', function (value) {
        value.bind(function (newVal) {
            $('.hero-title-text').text(newVal);
        });
    });

    // Hero Description
    wp.customize('bahar_hero_desc', function (value) {
        value.bind(function (newVal) {
            $('.hero-lead').text(newVal);
        });
    });

    // Copyright
    wp.customize('bahar_copyright_text', function (value) {
        value.bind(function (newVal) {
            $('.footer-bottom p').text(newVal);
        });
    });

})(jQuery);
