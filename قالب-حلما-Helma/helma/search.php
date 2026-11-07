<?php
/**
 * Helma Theme Search Results Template
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
            <span class="section-badge"><?php esc_html_e('نتایج جستجو', 'helma'); ?></span>
            <h1 class="section-title">
                <?php printf(esc_html__('نتایج جستجو برای: %s', 'helma'), '<span>' . get_search_query() . '</span>'); ?>
            </h1>
        </header>

        <?php if (have_posts()) : ?>
            <div class="blog-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/content', 'search');
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
