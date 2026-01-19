<?php
/**
 * Archive Template
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<section class="archive-header"
    style="padding: 120px 0 60px; background: linear-gradient(135deg, var(--primary-900), var(--primary-700)); color: var(--white); text-align: center;">
    <div class="container">
        <?php
        the_archive_title('<h1 style="color: var(--white);">', '</h1>');
        the_archive_description('<p style="color: var(--white-80); max-width: 600px; margin: var(--space-4) auto 0;">', '</p>');
        ?>
    </div>
</section>

<section class="section blog-section">
    <div class="container">
        <?php if (have_posts()): ?>
            <div class="blog-grid">
                <?php while (have_posts()):
                    the_post(); ?>
                    <article class="blog-card">
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="blog-card-image">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('blog-thumbnail'); ?>
                            <?php else: ?>
                                <div
                                    style="width:100%;height:100%;background:linear-gradient(135deg, var(--primary-700), var(--primary-900));">
                                </div>
                            <?php endif; ?>
                        </a>
                        <div class="blog-card-body">
                            <div class="blog-card-meta">
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo esc_html(get_the_date()); ?>
                                </time>
                            </div>
                            <h3>
                                <a href="<?php echo esc_url(get_permalink()); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            <p>
                                <?php echo esc_html(get_the_excerpt()); ?>
                            </p>
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="read-more">
                                <?php esc_html_e('Read More', 'finance-theme'); ?>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <nav class="pagination"
                style="margin-top: var(--space-12); display: flex; justify-content: center; gap: var(--space-2);">
                <?php
                echo paginate_links([
                    'prev_text' => '← Previous',
                    'next_text' => 'Next →',
                ]);
                ?>
            </nav>

        <?php else: ?>
            <div class="no-posts" style="text-align: center; padding: var(--space-16) 0;">
                <h2>
                    <?php esc_html_e('No posts found', 'finance-theme'); ?>
                </h2>
                <p>
                    <?php esc_html_e('Check back soon for new content!', 'finance-theme'); ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
get_footer();
