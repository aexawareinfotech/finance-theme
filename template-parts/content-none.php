<?php
/**
 * Template part for displaying a message when no posts found
 *
 * @package FinanceTheme
 * @since 1.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title">
            <?php esc_html_e('Nothing Found', 'finance-theme'); ?>
        </h1>
    </header>

    <div class="page-content">
        <?php if (is_search()): ?>
            <p>
                <?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'finance-theme'); ?>
            </p>
            <?php get_search_form(); ?>
        <?php else: ?>
            <p>
                <?php esc_html_e('It seems we can\'t find what you\'re looking for.', 'finance-theme'); ?>
            </p>
        <?php endif; ?>
    </div>
</section>