<?php
/**
 * The template for displaying all single pages (Per-Page Custom Layouts)
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

get_header();

$page_id      = get_the_ID();
$layout       = get_post_meta($page_id, '_bahar_layout', true) ?: 'default';
$show_title   = get_post_meta($page_id, '_bahar_show_title', true) ?: 'yes';
$subtitle     = get_post_meta($page_id, '_bahar_subtitle', true) ?: '';
$accent_color = sanitize_hex_color(get_post_meta($page_id, '_bahar_accent_color', true));
$breadcrumbs  = get_post_meta($page_id, '_bahar_breadcrumbs', true) ?: 'default';

// Determine container class
$container_class = 'container';
if ($layout === 'full') {
    $container_class = 'container-fluid';
} elseif ($layout === 'contained') {
    $container_class = 'container container-narrow';
}
?>

<?php if (!empty($accent_color)) : ?>
    <style>
        :root {
            --color-primary: <?php echo esc_attr($accent_color); ?>;
        }
    </style>
<?php endif; ?>

<?php if ($show_title === 'banner') : ?>
    <!-- Page Title Banner -->
    <div class="page-title-banner" style="background: linear-gradient(135deg, rgba(37,99,235,0.08) 0%, rgba(13,148,136,0.06) 100%), var(--bg-muted); border-bottom: 1px solid var(--border-light); padding: 4.5rem 0 4rem; text-align: center;">
        <div class="container">
            <?php if ($breadcrumbs !== 'hide') : ?>
                <div style="display:flex; justify-content:center; margin-bottom:1.25rem;">
                    <?php bahar_breadcrumbs(); ?>
                </div>
            <?php endif; ?>
            <h1 style="font-size: 2.75rem; font-weight: 800; color: var(--text-main); margin: 0; letter-spacing: -0.5px;"><?php the_title(); ?></h1>
            <?php if (!empty($subtitle)) : ?>
                <p style="font-size: 1.15rem; color: var(--text-muted); margin: 0.75rem auto 0; max-width: 680px; line-height: 1.7;"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<main id="primary" class="site-main section">
    <div class="<?php echo esc_attr($container_class); ?>">
        
        <?php if ($layout === 'sidebar-right') : ?>
            <div style="display: grid; grid-template-columns: 1fr 320px; gap: 3rem; align-items: start;">
                <div class="page-main-content">
                    <?php
                    while (have_posts()) :
                        the_post();
                        get_template_part('template-parts/content-page');
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
            <div style="display: grid; grid-template-columns: 320px 1fr; gap: 3rem; align-items: start;">
                <aside class="sidebar-left">
                    <?php get_sidebar(); ?>
                </aside>
                <div class="page-main-content">
                    <?php
                    while (have_posts()) :
                        the_post();
                        get_template_part('template-parts/content-page');
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;
                    endwhile;
                    ?>
                </div>
            </div>
        <?php else : ?>
            <?php
            while (have_posts()) :
                the_post();
                get_template_part('template-parts/content-page');
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
            endwhile;
            ?>
        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
