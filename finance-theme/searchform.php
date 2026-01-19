<?php
/**
 * Search Form Template
 *
 * @package FinanceTheme
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<form method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="screen-reader-text" for="search-field">
        <?php esc_html_e('Search for:', 'finance-theme'); ?>
    </label>
    <input type="search" id="search-field" class="search-input"
        placeholder="<?php esc_attr_e('Search...', 'finance-theme'); ?>"
        value="<?php echo esc_attr(get_search_query()); ?>" name="s">
    <button type="submit" class="search-submit">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35" />
        </svg>
        <span class="screen-reader-text">
            <?php esc_html_e('Search', 'finance-theme'); ?>
        </span>
    </button>
</form>