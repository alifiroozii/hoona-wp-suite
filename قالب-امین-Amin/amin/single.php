<?php
/**
 * The template for displaying all single posts and properties
 *
 * @package Amin
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main" style="padding: 50px 0; min-height: 60vh;">
    <div class="container" style="max-width: 900px; margin: 0 auto; padding: 0 20px;">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header" style="margin-bottom: 30px; text-align: center;">
                    <h1 class="entry-title" style="font-size: 32px; font-weight: 900; color: #1e293b; margin-bottom: 15px;">
                        <?php the_title(); ?>
                    </h1>
                    <div class="entry-meta" style="color: #64748b; font-size: 13.5px;">
                        <span>تاریخ انتشار: <?php echo get_the_date(); ?></span> &bull; 
                        <span>مشاور / نویسنده: <?php the_author(); ?></span>
                    </div>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="entry-thumbnail" style="margin-bottom: 30px; border-radius: 16px; overflow: hidden;">
                        <?php the_post_thumbnail('full', ['style' => 'width: 100%; height: auto; border-radius: 16px;']); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content" style="line-height: 1.8; font-size: 16px; color: #334155;">
                    <?php the_content(); ?>
                </div>

                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php
get_footer();
