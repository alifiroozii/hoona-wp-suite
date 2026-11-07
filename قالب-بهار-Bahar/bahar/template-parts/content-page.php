<?php
/**
 * Template part for displaying page content in page.php
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

$page_id     = get_the_ID();
$show_title  = get_post_meta($page_id, '_bahar_show_title', true) ?: 'yes';
$breadcrumbs = get_post_meta($page_id, '_bahar_breadcrumbs', true) ?: 'default';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <?php if ($breadcrumbs !== 'hide' && $show_title !== 'banner') : ?>
        <div style="padding-top: 1rem;">
            <?php bahar_breadcrumbs(); ?>
        </div>
    <?php endif; ?>

    <?php if ($show_title === 'yes') : ?>
        <header class="article-header">
            <h1 class="article-title"><?php the_title(); ?></h1>
        </header>
    <?php endif; ?>

    <?php if (has_post_thumbnail()) : ?>
        <div class="article-featured-image">
            <?php the_post_thumbnail('bahar-hero'); ?>
        </div>
    <?php endif; ?>

    <div class="article-content">
        <?php
        the_content();

        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('صفحات:', 'bahar'),
            'after'  => '</div>',
        ));
        ?>
    </div>
</article>
