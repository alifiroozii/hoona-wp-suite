<?php
/**
 * The main template file for Amin Real Estate & Directory Theme
 *
 * @package Amin
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main" style="padding: 60px 0; min-height: 60vh;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <header class="page-header" style="margin-bottom: 40px; text-align: center;">
            <h1 class="page-title" style="font-size: 28px; font-weight: 800; color: #1e293b;">
                <?php
                if (is_home() && !is_front_page()) {
                    single_post_title();
                } else {
                    esc_html_e('جدیدترین آگهی‌های املاک و مقالات', 'amin');
                }
                ?>
            </h1>
        </header>

        <div class="content-area">
            <?php if (have_posts()) : ?>
                <div class="posts-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px;">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('property-card'); ?> style="background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium_large', ['style' => 'width: 100%; height: 200px; object-fit: cover;']); ?></a>
                                </div>
                            <?php endif; ?>
                            <div style="padding: 20px;">
                                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 10px;">
                                    <a href="<?php the_permalink(); ?>" style="color: #0f172a; text-decoration: none;"><?php the_title(); ?></a>
                                </h2>
                                <div style="font-size: 13.5px; color: #64748b; line-height: 1.6; margin-bottom: 15px;">
                                    <?php the_excerpt(); ?>
                                </div>
                                <a href="<?php the_permalink(); ?>" style="display: inline-block; background: #059669; color: #fff; padding: 8px 18px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 700;">مشاهده جزئیات ملک</a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="pagination" style="margin-top: 40px; text-align: center;">
                    <?php the_posts_pagination(); ?>
                </div>
            <?php else : ?>
                <p style="text-align: center; color: #64748b; font-size: 16px;"><?php esc_html_e('هنوز آگهی یا مقاله‌ای در این بخش ثبت نشده است.', 'amin'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
get_footer();
