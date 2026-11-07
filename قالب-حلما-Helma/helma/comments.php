<?php
/**
 * Helma Theme Comments Template
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area" style="margin-top:4rem; padding-top:2.5rem; border-top:1px solid var(--border-subtle);">
    <?php if (have_comments()) : ?>
        <h3 class="comments-title" style="font-size:1.4rem; font-weight:800; color:var(--text-main); margin-bottom:1.5rem;">
            <?php
            $comment_count = get_comments_number();
            printf(
                esc_html(_nx('%1$s دیدگاه ثبت شده', '%1$s دیدگاه برای این مطلب', $comment_count, 'comments title', 'helma')),
                number_format_i18n($comment_count)
            );
            ?>
        </h3>

        <ol class="comment-list" style="list-style:none; display:flex; flex-direction:column; gap:1.25rem;">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size'=> 44,
            ));
            ?>
        </ol>
    <?php endif; ?>

    <?php comment_form(); ?>
</div>
