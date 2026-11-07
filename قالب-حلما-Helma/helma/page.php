<?php
/**
 * Helma Theme Single Page Template
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

get_header();

$page_id      = get_the_ID();
$layout       = get_post_meta($page_id, '_helma_layout', true) ?: 'default';
$show_title   = get_post_meta($page_id, '_helma_show_title', true) ?: 'yes';
$subtitle     = get_post_meta($page_id, '_helma_subtitle', true) ?: '';
$glow_color   = sanitize_hex_color(get_post_meta($page_id, '_helma_glow_color', true));

$container_class = 'container';
if ($layout === 'full') {
    $container_class = 'container-fluid';
} elseif ($layout === 'contained') {
    $container_class = 'container container-narrow';
}
?>

<?php if (!empty($glow_color)) : ?>
    <style>
        :root {
            --glow-primary: <?php echo esc_attr($glow_color); ?>;
        }
    </style>
<?php endif; ?>

<?php if ($show_title === 'banner') : ?>
    <!-- Page Banner -->
    <div class="page-title-banner" style="background: radial-gradient(circle at 50% 0%, rgba(139,92,246,0.15) 0%, transparent 70%), var(--bg-surface); border-bottom: 1px solid var(--border-subtle); padding: 4.5rem 0 3.5rem; text-align: center;">
        <div class="container">
            <div style="display:flex; justify-content:center; margin-bottom:1rem;">
                <?php helma_breadcrumbs(); ?>
            </div>
            <h1 style="font-size: 2.75rem; font-weight: 800; color: var(--text-main); margin: 0; letter-spacing: -0.5px;"><?php the_title(); ?></h1>
            <?php if (!empty($subtitle)) : ?>
                <p style="font-size: 1.1rem; color: var(--text-muted); margin: 0.75rem auto 0; max-width: 680px; line-height: 1.7;"><?php echo esc_html($subtitle); ?></p>
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
        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
