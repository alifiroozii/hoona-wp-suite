<?php
/**
 * The template for displaying archive pages
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

get_header();
?>

<main id="primary" class="site-main section">
    <div class="container">

        <header class="section-header">
            <?php
            the_archive_title('<h1 class="section-title">', '</h1>');
            the_archive_description('<div class="section-desc">', '</div>');
            ?>
        </header>

        <?php if (have_posts()) : ?>

            <div class="posts-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/content');
                endwhile;
                ?>
            </div>

            <div style="margin-top: 3.5rem; display: flex; justify-content: center;">
                <?php bahar_pagination(); ?>
            </div>

        <?php else : ?>

            <?php get_template_part('template-parts/content-none'); ?>

        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
