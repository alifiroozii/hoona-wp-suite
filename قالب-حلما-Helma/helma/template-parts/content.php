<?php
/**
 * Template part for displaying posts in a grid
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-card'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('helma-card', array('style' => 'width:100%; height:200px; object-fit:cover; display:block;')); ?>
        </a>
    <?php else : ?>
        <div class="blog-thumb-placeholder">⚡</div>
    <?php endif; ?>

    <div class="blog-card-body">
        <div>
            <?php
            $cats = get_the_category();
            if (!empty($cats)) : ?>
                <span class="blog-tag"><?php echo esc_html($cats[0]->name); ?></span>
            <?php endif; ?>

            <h3 class="blog-title">
                <a href="<?php the_permalink(); ?>" style="color:var(--text-main); text-decoration:none;">
                    <?php the_title(); ?>
                </a>
            </h3>

            <div class="blog-desc">
                <?php the_excerpt(); ?>
            </div>
        </div>

        <div class="blog-footer">
            <span>⏱️ <?php echo esc_html(helma_get_reading_time()); ?></span>
            <a href="<?php the_permalink(); ?>" style="color:var(--glow-primary); font-weight:700; text-decoration:none;">
                <?php esc_html_e('ادامه مطلب ←', 'helma'); ?>
            </a>
        </div>
    </div>
</article>
