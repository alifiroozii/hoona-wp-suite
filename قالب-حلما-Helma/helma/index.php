<?php
/**
 * Helma Theme Main Index Template
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
            <span class="section-badge"><?php esc_html_e('وبلاگ و مقالات', 'helma'); ?></span>
            <h1 class="section-title"><?php single_post_title(); ?></h1>
            <p class="section-desc"><?php esc_html_e('تازه‌ترین آموزش‌ها، اخبار و تحلیل‌های هوش مصنوعی و دنیای فناوری', 'helma'); ?></p>
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
