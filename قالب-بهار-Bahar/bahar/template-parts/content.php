<?php
/**
 * Template part for displaying posts in a grid
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
    <div class="post-thumbnail-wrap">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('bahar-card'); ?>
            <?php else : ?>
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg, #eff6ff 0%, #f1f5f9 100%);color:var(--color-primary);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                </div>
            <?php endif; ?>
        </a>
    </div>

    <div class="post-card-body">
        <?php bahar_posted_on(); ?>

        <h3 class="post-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <div class="post-card-excerpt">
            <?php the_excerpt(); ?>
        </div>

        <div class="post-card-footer">
            <?php bahar_posted_by(); ?>
            <a href="<?php the_permalink(); ?>" class="read-more-link">
                <?php esc_html_e('ادامه مطلب', 'bahar'); ?>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
        </div>
    </div>
</article>
