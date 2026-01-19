<?php
/**
 * Template part for displaying post content
 *
 * @package FinanceTheme
 * @since 1.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}
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
            <?php
            if (is_singular()):
                the_title('<h1 class="entry-title">', '</h1>');
            else:
                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>');
            endif;
            ?>
            <div class="entry-meta">
                <span class="posted-on">
                    <?php echo esc_html(get_the_date()); ?>
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