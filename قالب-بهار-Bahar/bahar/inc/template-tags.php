<?php
/**
 * Bahar Theme Custom Template Tags & Enterprise Helpers
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

/**
 * Calculate post reading time in minutes
 */
function bahar_get_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $content = get_post_field('post_content', $post_id);
    $word_count = count(preg_split('/\s+/u', strip_tags($content), -1, PREG_SPLIT_NO_EMPTY));
    $reading_time = ceil($word_count / 200);
    return max(1, (int)$reading_time);
}

/**
 * Display post meta information (Date, Category, Reading Time)
 */
function bahar_posted_on() {
    $time_string = sprintf(
        '<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date())
    );

    $reading_time = bahar_get_reading_time();

    echo '<div class="post-meta-top">';
    
    // Category
    $categories = get_the_category();
    if (!empty($categories)) {
        echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '" class="post-category-tag">' . esc_html($categories[0]->name) . '</a>';
    }

    echo '<span class="post-date">' . $time_string . '</span>';
    echo '<span class="meta-dot">•</span>';
    echo '<span class="reading-time">' . esc_html($reading_time) . ' دقیقه مطالعه</span>';
    echo '</div>';
}

/**
 * Post author display with avatar
 */
function bahar_posted_by() {
    $author_id = get_the_author_meta('ID');
    echo '<div class="post-author">';
    echo get_avatar($author_id, 24);
    echo '<span>' . esc_html(get_the_author()) . '</span>';
    echo '</div>';
}

/**
 * Custom numeric pagination
 */
function bahar_pagination() {
    the_posts_pagination(array(
        'mid_size'           => 2,
        'prev_text'          => __('« قبلی', 'bahar'),
        'next_text'          => __('بعدی »', 'bahar'),
        'screen_reader_text' => __('ناوبری نوشته‌ها', 'bahar'),
        'class'              => 'bahar-pagination',
    ));
}

/**
 * Breadcrumbs Navigation with Schema.org Microdata
 */
function bahar_breadcrumbs() {
    if (is_front_page()) {
        return;
    }

    echo '<nav class="bahar-breadcrumbs" aria-label="' . esc_attr__('مسیر راهنما', 'bahar') . '">';
    echo '<a href="' . esc_url(home_url('/')) . '">';
    echo '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>';
    echo '<span>' . esc_html__('صفحه اصلی', 'bahar') . '</span>';
    echo '</a>';

    echo '<span class="breadcrumb-separator">/</span>';

    if (is_category() || is_single()) {
        $category = get_the_category();
        if (!empty($category)) {
            echo '<a href="' . esc_url(get_category_link($category[0]->term_id)) . '">' . esc_html($category[0]->name) . '</a>';
        }
        if (is_single()) {
            echo '<span class="breadcrumb-separator">/</span>';
            echo '<span class="breadcrumb-current">' . esc_html(wp_trim_words(get_the_title(), 6)) . '</span>';
        }
    } elseif (is_page()) {
        echo '<span class="breadcrumb-current">' . esc_html(get_the_title()) . '</span>';
    } elseif (is_search()) {
        echo '<span class="breadcrumb-current">' . esc_html__('نتایج جستجو', 'bahar') . '</span>';
    } elseif (is_404()) {
        echo '<span class="breadcrumb-current">' . esc_html__('خطای ۴۰۴', 'bahar') . '</span>';
    }

    echo '</nav>';
}

/**
 * Social Sharing Buttons
 */
function bahar_social_share() {
    $title = urlencode(get_the_title());
    $url   = urlencode(get_permalink());

    echo '<div class="social-share-bar">';
    echo '<span class="social-share-title">' . esc_html__('اشتراک‌گذاری مطلب:', 'bahar') . '</span>';

    // Telegram
    echo '<a href="https://t.me/share/url?url=' . $url . '&text=' . $title . '" target="_blank" rel="noopener noreferrer" class="share-btn">';
    echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .37z"/></svg>';
    echo '<span>تلگرام</span>';
    echo '</a>';

    // WhatsApp
    echo '<a href="https://api.whatsapp.com/send?text=' . $title . '%20' . $url . '" target="_blank" rel="noopener noreferrer" class="share-btn">';
    echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.196 8.196 0 01-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24m4.52 11.63c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.05-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.44-.06-.13-.56-1.34-.76-1.84-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.23.9 2.43 1.03 2.6.13.17 1.77 2.7 4.29 3.79.6.26 1.07.41 1.44.53.61.19 1.16.17 1.6.1.49-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.06-.11-.22-.17-.47-.29z"/></svg>';
    echo '<span>واتساپ</span>';
    echo '</a>';

    // Twitter / X
    echo '<a href="https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title . '" target="_blank" rel="noopener noreferrer" class="share-btn">';
    echo '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>';
    echo '<span>X</span>';
    echo '</a>';

    // Copy Link
    echo '<button type="button" class="share-btn share-btn-copy">';
    echo '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>';
    echo '<span>کپی لینک</span>';
    echo '</button>';

    echo '</div>';
}

/**
 * Smart Related Posts based on categories
 */
function bahar_related_posts() {
    $categories = get_the_category();
    if (empty($categories)) {
        return;
    }

    $related = new WP_Query(array(
        'category__in'        => wp_list_pluck($categories, 'term_id'),
        'post__not_in'        => array(get_the_ID()),
        'posts_per_page'      => 3,
        'ignore_sticky_posts' => 1,
    ));

    if ($related->have_posts()) :
        ?>
        <div class="related-posts-section">
            <h3 class="related-posts-title"><?php esc_html_e('نوشته‌های مرتبط پیشنهادی', 'bahar'); ?></h3>
            <div class="posts-grid">
                <?php
                while ($related->have_posts()) :
                    $related->the_post();
                    get_template_part('template-parts/content');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php
    endif;
}
