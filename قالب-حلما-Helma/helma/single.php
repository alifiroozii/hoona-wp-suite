<?php
/**
 * Helma Theme Single Post Template
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

get_header();

$post_id    = get_the_ID();
$layout     = get_post_meta($post_id, '_helma_layout', true) ?: 'contained';
$glow_color = sanitize_hex_color(get_post_meta($post_id, '_helma_glow_color', true));
?>

<?php if (!empty($glow_color)) : ?>
    <style>
        :root {
            --glow-primary: <?php echo esc_attr($glow_color); ?>;
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
