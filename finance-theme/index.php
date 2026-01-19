<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @package FinanceTheme
 */

get_header();
?>

<div class="blog-archive">
    <div class="container">
        <?php if (have_posts()): ?>

            <?php if (is_home() && !is_front_page()): ?>
                <header class="page-header">
                    <h1 class="page-title">
                        <?php single_post_title(); ?>
                    </h1>
                </header>
            <?php endif; ?>

            <div class="posts-grid">
                <?php
                while (have_posts()):
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('blog-card'); ?>>
                        <?php if (has_post_thumbnail()): ?>
                            <div class="blog-card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="blog-card-content">
                            <header class="entry-header">
                                <h2 class="entry-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                <div class="entry-meta">
                                    <span class="posted-on">
                                        <?php echo get_the_date(); ?>
                                    </span>
                                </div>
                            </header>

                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="read-more">
                                <?php esc_html_e('Read More', 'finance-theme'); ?>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php the_posts_navigation(); ?>

        <?php else: ?>

            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title">
                        <?php esc_html_e('Nothing Found', 'finance-theme'); ?>
                    </h1>
                </header>
                <div class="page-content">
                    <p>
                        <?php esc_html_e('It seems we can\'t find what you\'re looking for.', 'finance-theme'); ?>
                    </p>
                </div>
            </section>

        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
