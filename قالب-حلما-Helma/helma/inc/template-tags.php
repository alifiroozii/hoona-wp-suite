<?php
/**
 * Helma Theme Custom Template Tags
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

if (!function_exists('helma_posted_on')) :
    function helma_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date())
        );

        echo '<span class="posted-on">📅 ' . $time_string . '</span>';
    }
endif;

if (!function_exists('helma_posted_by')) :
    function helma_posted_by() {
        echo '<span class="byline">✍️ ' . esc_html(get_the_author()) . '</span>';
    }
endif;

if (!function_exists('helma_get_reading_time')) :
    function helma_get_reading_time($post_id = null) {
        $content = get_post_field('post_content', $post_id ?: get_the_ID());
        $word_count = count(preg_split('/\s+/u', strip_tags($content), -1, PREG_SPLIT_NO_EMPTY));
        $minutes = max(1, ceil($word_count / 180));
        return $minutes . ' ' . esc_html__('دقیقه مطالعه', 'helma');
    }
endif;

if (!function_exists('helma_breadcrumbs')) :
    function helma_breadcrumbs() {
        if (is_front_page()) return;

        echo '<nav class="breadcrumbs" aria-label="' . esc_attr__('مسیر راهنما', 'helma') . '" style="display:inline-flex; align-items:center; gap:0.5rem; font-size:0.8rem; color:var(--text-muted);">';
        echo '<a href="' . esc_url(home_url('/')) . '" style="color:var(--text-muted); text-decoration:none;">' . esc_html__('خانه', 'helma') . '</a>';
        echo '<span style="color:var(--text-dim);">/</span>';

        if (is_single()) {
            $categories = get_the_category();
            if (!empty($categories)) {
                echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '" style="color:var(--text-muted); text-decoration:none;">' . esc_html($categories[0]->name) . '</a>';
                echo '<span style="color:var(--text-dim);">/</span>';
            }
            echo '<span style="color:var(--text-main); font-weight:600;">' . esc_html(get_the_title()) . '</span>';
        } elseif (is_page()) {
            echo '<span style="color:var(--text-main); font-weight:600;">' . esc_html(get_the_title()) . '</span>';
        } elseif (is_category() || is_archive()) {
            echo '<span style="color:var(--text-main); font-weight:600;">' . esc_html(get_the_archive_title()) . '</span>';
        }
        echo '</nav>';
    }
endif;
