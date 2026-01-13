<?php
/**
 * Single Post Template
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?> style="padding-top: 100px;">
    <div class="container" style="max-width: 800px;">
        <?php while (have_posts()):
            the_post(); ?>

            <header class="post-header" style="margin-bottom: var(--space-8);">
                <div class="post-meta" style="color: var(--primary-600); margin-bottom: var(--space-2);">
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php echo esc_html(get_the_date()); ?>
                    </time>
                    <span> • </span>
                    <span>
                        <?php echo esc_html(get_the_author()); ?>
                    </span>
                </div>
                <h1 style="margin-bottom: var(--space-4);">
                    <?php the_title(); ?>
                </h1>
                <?php if (has_post_thumbnail()): ?>
                    <div class="post-thumbnail"
                        style="margin-top: var(--space-6); border-radius: var(--radius-xl); overflow: hidden;">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
            </header>

            <div class="post-content" style="line-height: 1.8; font-size: var(--text-lg);">
                <?php the_content(); ?>
                <?php
                wp_link_pages([
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'finance-theme'),
                    'after' => '</div>',
                ]);
                ?>
            </div>

            <footer class="post-footer"
                style="margin-top: var(--space-10); padding-top: var(--space-6); border-top: 1px solid var(--gray-300);">
                <?php if (has_category()): ?>
                    <div class="post-categories" style="margin-bottom: var(--space-4);">
                        <strong>
                            <?php esc_html_e('Categories:', 'finance-theme'); ?>
                        </strong>
                        <?php the_category(', '); ?>
                    </div>
                <?php endif; ?>

                <?php if (has_tag()): ?>
                    <div class="post-tags">
                        <strong>
                            <?php esc_html_e('Tags:', 'finance-theme'); ?>
                        </strong>
                        <?php the_tags('', ', ', ''); ?>
                    </div>
                <?php endif; ?>
            </footer>

        <?php endwhile; ?>

        <!-- Post Navigation -->
        <nav class="post-navigation"
            style="display: flex; justify-content: space-between; margin-top: var(--space-10); padding-top: var(--space-6); border-top: 1px solid var(--gray-300);">
            <div class="nav-previous">
                <?php previous_post_link('%link', '← %title'); ?>
            </div>
            <div class="nav-next">
                <?php next_post_link('%link', '%title →'); ?>
            </div>
        </nav>

        <!-- Comments -->
        <?php if (comments_open() || get_comments_number()): ?>
            <div class="comments-section" style="margin-top: var(--space-12);">
                <?php comments_template(); ?>
            </div>
        <?php endif; ?>
    </div>
</article>

<!-- Related Posts -->
<section class="section blog-section">
    <div class="container">
        <div class="section-header">
            <h2>
                <?php esc_html_e('Related Posts', 'finance-theme'); ?>
            </h2>
        </div>
        <div class="blog-grid">
            <?php
            $related = get_posts([
                'post_type' => 'post',
                'posts_per_page' => 3,
                'post__not_in' => [get_the_ID()],
                'orderby' => 'rand',
            ]);

            foreach ($related as $post):
                setup_postdata($post);
                ?>
                <article class="blog-card">
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="blog-card-image">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('blog-thumbnail'); ?>
                        <?php else: ?>
                            <div style="width:100%;height:100%;background:var(--gray-300);"></div>
                        <?php endif; ?>
                    </a>
                    <div class="blog-card-body">
                        <div class="blog-card-meta">
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                <?php echo esc_html(get_the_date()); ?>
                            </time>
                        </div>
                        <h3><a href="<?php echo esc_url(get_permalink()); ?>">
                                <?php the_title(); ?>
                            </a></h3>
                        <p>
                            <?php echo esc_html(get_the_excerpt()); ?>
                        </p>
                    </div>
                </article>
            <?php endforeach;
            wp_reset_postdata(); ?>
        </div>
    </div>
</section>

<?php
get_footer();
