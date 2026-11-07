<?php
/**
 * Template part for displaying single post content
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="article-header">
        <!-- Breadcrumbs Navigation -->
        <?php bahar_breadcrumbs(); ?>

        <?php bahar_posted_on(); ?>
        
        <h1 class="article-title"><?php the_title(); ?></h1>
        
        <div class="article-meta">
            <?php bahar_posted_by(); ?>
            <span class="meta-dot">•</span>
            <span><?php comments_number('بدون دیدگاه', '۱ دیدگاه', '% دیدگاه'); ?></span>
        </div>
    </header>

    <?php if (has_post_thumbnail()) : ?>
        <div class="article-featured-image">
            <?php the_post_thumbnail('bahar-hero'); ?>
        </div>
    <?php endif; ?>

    <div class="article-content">
        <?php
        the_content(sprintf(
            wp_kses(__('ادامه خواندن<span class="screen-reader-text"> "%s"</span>', 'bahar'), array('span' => array('class' => array()))),
            wp_kses_post(get_the_title())
        ));

        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('صفحات:', 'bahar'),
            'after'  => '</div>',
        ));
        ?>
    </div>

    <!-- Article Tags -->
    <?php
    $tags_list = get_the_tag_list('', ' ');
    if ($tags_list) :
        ?>
        <div class="article-tags">
            <span style="font-weight: 600; color: var(--text-main); font-size: 0.9rem;"><?php esc_html_e('برچسب‌ها:', 'bahar'); ?></span>
            <?php echo wp_kses_post($tags_list); ?>
        </div>
    <?php endif; ?>

    <!-- Social Share Buttons -->
    <?php bahar_social_share(); ?>

    <!-- Author Box -->
    <div class="author-box">
        <div class="author-box-avatar">
            <?php echo get_avatar(get_the_author_meta('ID'), 72); ?>
        </div>
        <div class="author-box-info">
            <h4 class="author-box-name"><?php echo esc_html(get_the_author()); ?></h4>
            <p class="author-box-bio">
                <?php 
                $bio = get_the_author_meta('description');
                echo esc_html($bio ? $bio : __('نویسنده و پژوهشگر توسعه وب در وبلاگ شرکت هونا (hoonaco.ir).', 'bahar'));
                ?>
            </p>
        </div>
    </div>

    <!-- Post Navigation -->
    <div class="post-navigation-wrap" style="margin: 2.5rem 0; padding: 1.5rem 0; border-top: 1px solid var(--border-light); border-bottom: 1px solid var(--border-light);">
        <?php
        the_post_navigation(array(
            'prev_text' => '<span class="nav-subtitle" style="font-size:0.8rem; color:var(--text-muted); display:block;">« نوشته قبلی</span> <span class="nav-title" style="font-weight:700;">%title</span>',
            'next_text' => '<span class="nav-subtitle" style="font-size:0.8rem; color:var(--text-muted); display:block;">نوشته بعدی »</span> <span class="nav-title" style="font-weight:700;">%title</span>',
        ));
        ?>
    </div>

    <!-- Smart Related Posts -->
    <?php bahar_related_posts(); ?>
</article>
