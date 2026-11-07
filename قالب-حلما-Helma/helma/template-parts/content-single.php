<?php
/**
 * Template part for displaying single post content
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-post-entry'); ?>>
    <header class="entry-header" style="margin-bottom:2.5rem; text-align:center;">
        <div style="display:flex; justify-content:center; margin-bottom:1rem;">
            <?php helma_breadcrumbs(); ?>
        </div>

        <h1 class="entry-title" style="font-size:clamp(1.8rem, 4vw, 2.75rem); font-weight:800; color:var(--text-main); margin-bottom:1rem; line-height:1.3; letter-spacing:-0.5px;">
            <?php the_title(); ?>
        </h1>

        <div class="entry-meta" style="display:flex; justify-content:center; gap:1.25rem; font-size:0.85rem; color:var(--text-muted); flex-wrap:wrap;">
            <span><?php helma_posted_on(); ?></span>
            <span><?php helma_posted_by(); ?></span>
            <span>⏱️ <?php echo esc_html(helma_get_reading_time()); ?></span>
        </div>
    </header>

    <?php if (has_post_thumbnail()) : ?>
        <div class="entry-thumbnail" style="margin-bottom:2.5rem; border-radius:var(--radius-lg); overflow:hidden; border:1px solid var(--border-card); box-shadow:var(--shadow-card);">
            <?php the_post_thumbnail('helma-hero', array('style' => 'width:100%; height:auto; display:block;')); ?>
        </div>
    <?php endif; ?>

    <div class="entry-content" style="font-size:1.05rem; line-height:1.9; color:var(--text-main);">
        <?php the_content(); ?>
    </div>

    <!-- Author Box -->
    <div class="entry-author-box" style="margin-top:3.5rem; background:var(--bg-surface); border:1px solid var(--border-card); border-radius:var(--radius-md); padding:1.75rem; display:flex; align-items:center; gap:1.25rem;">
        <div class="avatar-ring" style="width:56px; height:56px;">
            <div class="avatar-img" style="font-size:1.1rem;"><?php echo esc_html(mb_substr(get_the_author(), 0, 1)); ?></div>
        </div>
        <div>
            <h4 style="font-size:1.1rem; font-weight:800; color:var(--text-main); margin-bottom:0.25rem;"><?php the_author(); ?></h4>
            <p style="font-size:0.85rem; color:var(--text-muted); margin:0;">
                <?php the_author_meta('description') ?: esc_html_e('نویسنده و پژوهشگر فناوری هوش مصنوعی در پلتفرم حلما.', 'helma'); ?>
            </p>
        </div>
    </div>
</article>
