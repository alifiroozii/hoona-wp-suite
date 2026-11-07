<?php
/**
 * The template for displaying comments
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            <?php
            $bahar_comment_count = get_comments_number();
            if ('1' === $bahar_comment_count) {
                printf(esc_html__('یک دیدگاه در «%1$s»', 'bahar'), '<span>' . wp_kses_post(get_the_title()) . '</span>');
            } else {
                printf(
                    /* translators: 1: comment count number, 2: title. */
                    esc_html(_nx('%1$s دیدگاه در «%2$s»', '%1$s دیدگاه در «%2$s»', $bahar_comment_count, 'comments title', 'bahar')),
                    number_format_i18n($bahar_comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h3>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 48,
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation();

        if (!comments_open()) :
            ?>
            <p class="no-comments"><?php esc_html_e('ارسال دیدگاه برای این نوشته بسته شده است.', 'bahar'); ?></p>
            <?php
        endif;

    endif;

    comment_form(array(
        'title_reply'          => esc_html__('دیدگاه خود را بنویسید', 'bahar'),
        'title_reply_to'       => esc_html__('پاسخ به %s', 'bahar'),
        'label_submit'         => esc_html__('ثبت دیدگاه', 'bahar'),
        'class_submit'         => 'btn btn-primary',
        'comment_notes_before' => '<p class="comment-notes" style="font-size:0.85rem; color:var(--text-muted); margin-bottom:1rem;">' . esc_html__('نشانی ایمیل شما منتشر نخواهد شد. بخش‌های موردنیاز علامت‌گذاری شده‌اند *', 'bahar') . '</p>',
    ));
    ?>

</div>
