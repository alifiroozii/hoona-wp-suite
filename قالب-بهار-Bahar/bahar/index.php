<?php
/**
 * The main template file
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
        
        <?php if (is_home() && !is_front_page()) : ?>
            <header class="section-header">
                <span class="section-subtitle"><?php esc_html_e('وبلاگ', 'bahar'); ?></span>
                <h1 class="section-title"><?php single_post_title(); ?></h1>
            </header>
        <?php endif; ?>

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
