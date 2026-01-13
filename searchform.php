<?php
/**
 * Search Form Template
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>"
    style="display: flex; gap: var(--space-2); max-width: 400px; margin: 0 auto;">
    <label class="sr-only" for="search-field">
        <?php esc_html_e('Search for:', 'flavor'); ?>
    </label>
    <input type="search" id="search-field" class="search-field"
        placeholder="<?php esc_attr_e('Search...', 'flavor'); ?>" value="<?php echo get_search_query(); ?>" name="s"
        style="flex: 1; padding: var(--space-3) var(--space-4); border: 2px solid var(--gray-300); border-radius: var(--radius-lg); font-size: var(--text-base);">
    <button type="submit" class="btn btn-primary" style="padding: var(--space-3) var(--space-4);">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35" />
        </svg>
        <span class="sr-only">
            <?php esc_html_e('Search', 'flavor'); ?>
        </span>
    </button>
</form>