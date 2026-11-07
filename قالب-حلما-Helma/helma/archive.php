<?php
/**
 * Helma Theme Archive Template
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

get_header();
?>

<main id="primary" class="site-main section">
    <div class="container">
        
        <header class="page-header" style="text-align:center; margin-bottom:3.5rem;">
            <div style="display:flex; justify-content:center; margin-bottom:1rem;">
                <?php helma_breadcrumbs(); ?>
            </div>
            <h1 class="section-title"><?php the_archive_title(); ?></h1>
            <?php the_archive_description('<div class="section-desc">', '</div>'); ?>
        </header>

        <?php if (have_posts()) : ?>
            <div class="blog-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/content', get_post_format());
                endwhile;
                ?>
            </div>
            <div style="margin-top:3.5rem; text-align:center;">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <?php get_template_part('template-parts/content', 'none'); ?>
        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
