<?php
/**
 * Generic Page Template
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<article class="page-content" style="padding-top: 100px; min-height: 60vh;">
    <div class="container" style="max-width: 900px;">
        <?php while (have_posts()):
            the_post(); ?>

            <header class="page-header" style="margin-bottom: var(--space-8); text-align: center;">
                <h1>
                    <?php the_title(); ?>
                </h1>
            </header>

            <div class="entry-content" style="line-height: 1.8;">
                <?php the_content(); ?>
            </div>

        <?php endwhile; ?>
    </div>
</article>

<?php
get_footer();
