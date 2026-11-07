<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

$page_id    = get_the_ID();
$show_title = get_post_meta($page_id, '_helma_show_title', true) ?: 'yes';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('page-entry'); ?>>
    <?php if ($show_title === 'yes') : ?>
        <header class="entry-header" style="margin-bottom:2rem;">
            <div style="margin-bottom:0.75rem;">
                <?php helma_breadcrumbs(); ?>
            </div>
            <h1 class="entry-title" style="font-size:2.2rem; font-weight:800; color:var(--text-main); margin:0;">
                <?php the_title(); ?>
            </h1>
        </header>
    <?php endif; ?>

    <div class="entry-content" style="font-size:1.02rem; line-height:1.9; color:var(--text-main);">
        <?php the_content(); ?>
    </div>
</article>
