<?php
/**
 * The template for displaying all pages
 *
 * @package Nikan
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main" style="padding: 50px 0; min-height: 60vh;">
    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header" style="margin-bottom: 30px; text-align: center;">
                    <h1 class="entry-title" style="font-size: 30px; font-weight: 800; color: #1e293b;">
                        <?php the_title(); ?>
                    </h1>
                </header>

                <div class="entry-content" style="line-height: 1.8; font-size: 15.5px; color: #334155;">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php
get_footer();
