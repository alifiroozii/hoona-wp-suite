<?php
/**
 * The template for displaying all single posts (Custom Layouts)
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

get_header();

$post_id      = get_the_ID();
$layout       = get_post_meta($post_id, '_bahar_layout', true) ?: 'contained';
$accent_color = sanitize_hex_color(get_post_meta($post_id, '_bahar_accent_color', true));
?>

<?php if (!empty($accent_color)) : ?>
    <style>
        :root {
            --color-primary: <?php echo esc_attr($accent_color); ?>;
        }
    </style>
<?php endif; ?>

<main id="primary" class="site-main section">
    <?php if ($layout === 'sidebar-right') : ?>
        <div class="container" style="display: grid; grid-template-columns: 1fr 320px; gap: 3rem; align-items: start;">
            <div class="post-main-content">
                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/content-single');
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                endwhile;
                ?>
            </div>
            <aside class="sidebar-right">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    <?php elseif ($layout === 'sidebar-left') : ?>
        <div class="container" style="display: grid; grid-template-columns: 320px 1fr; gap: 3rem; align-items: start;">
            <aside class="sidebar-left">
                <?php get_sidebar(); ?>
            </aside>
            <div class="post-main-content">
                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/content-single');
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                endwhile;
                ?>
            </div>
        </div>
    <?php elseif ($layout === 'full') : ?>
        <div class="container-fluid" style="padding: 0 2rem;">
            <?php
            while (have_posts()) :
                the_post();
                get_template_part('template-parts/content-single');
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
            endwhile;
            ?>
        </div>
    <?php else : ?>
        <div class="container container-narrow">
            <?php
            while (have_posts()) :
                the_post();
                get_template_part('template-parts/content-single');
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
            endwhile;
            ?>
        </div>
    <?php endif; ?>
</main>

<?php
get_footer();
