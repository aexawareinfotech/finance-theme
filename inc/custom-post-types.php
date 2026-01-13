<?php
/**
 * Custom Post Types Registration
 *
 * Registers custom post types for testimonials, FAQs, and loan types.
 * Originally part of a separate plugin, now integrated for theme compliance.
 *
 * @package FinanceTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Custom Post Types
 */
function finance_theme_register_post_types(): void
{
    // Testimonials
    register_post_type('testimonial', [
        'labels' => [
            'name' => __('Testimonials', 'flavor'),
            'singular_name' => __('Testimonial', 'flavor'),
            'add_new' => __('Add New', 'flavor'),
            'add_new_item' => __('Add New Testimonial', 'flavor'),
            'edit_item' => __('Edit Testimonial', 'flavor'),
            'new_item' => __('New Testimonial', 'flavor'),
            'view_item' => __('View Testimonial', 'flavor'),
            'search_items' => __('Search Testimonials', 'flavor'),
            'not_found' => __('No testimonials found', 'flavor'),
            'not_found_in_trash' => __('No testimonials found in Trash', 'flavor'),
        ],
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
    ]);

    // FAQs
    register_post_type('faq', [
        'labels' => [
            'name' => __('FAQs', 'flavor'),
            'singular_name' => __('FAQ', 'flavor'),
            'add_new' => __('Add New', 'flavor'),
            'add_new_item' => __('Add New FAQ', 'flavor'),
            'edit_item' => __('Edit FAQ', 'flavor'),
            'new_item' => __('New FAQ', 'flavor'),
            'view_item' => __('View FAQ', 'flavor'),
            'search_items' => __('Search FAQs', 'flavor'),
            'not_found' => __('No FAQs found', 'flavor'),
            'not_found_in_trash' => __('No FAQs found in Trash', 'flavor'),
        ],
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-editor-help',
        'supports' => ['title', 'editor'],
        'show_in_rest' => true,
    ]);

    // Loan Types
    register_post_type('loan_type', [
        'labels' => [
            'name' => __('Loan Types', 'flavor'),
            'singular_name' => __('Loan Type', 'flavor'),
            'add_new' => __('Add New', 'flavor'),
            'add_new_item' => __('Add New Loan Type', 'flavor'),
            'edit_item' => __('Edit Loan Type', 'flavor'),
            'new_item' => __('New Loan Type', 'flavor'),
            'view_item' => __('View Loan Type', 'flavor'),
            'search_items' => __('Search Loan Types', 'flavor'),
            'not_found' => __('No loan types found', 'flavor'),
            'not_found_in_trash' => __('No loan types found in Trash', 'flavor'),
        ],
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-money-alt',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'loans'],
    ]);
}
add_action('init', 'finance_theme_register_post_types');

/**
 * Add custom meta boxes for testimonials
 */
function finance_theme_add_testimonial_meta_boxes(): void
{
    add_meta_box(
        'testimonial_details',
        __('Testimonial Details', 'flavor'),
        'finance_theme_testimonial_meta_box_callback',
        'testimonial',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'finance_theme_add_testimonial_meta_boxes');

/**
 * Meta box callback
 */
function finance_theme_testimonial_meta_box_callback($post): void
{
    wp_nonce_field('finance_theme_testimonial_meta', 'finance_theme_testimonial_nonce');

    $rating = get_post_meta($post->ID, '_testimonial_rating', true);
    $loan_type = get_post_meta($post->ID, '_testimonial_loan_type', true);
    ?>
    <p>
        <label for="testimonial_rating"><strong>
                <?php esc_html_e('Rating (1-5):', 'flavor'); ?>
            </strong></label><br>
        <input type="number" id="testimonial_rating" name="testimonial_rating" value="<?php echo esc_attr($rating ?: 5); ?>"
            min="1" max="5" style="width: 60px;">
    </p>
    <p>
        <label for="testimonial_loan_type"><strong>
                <?php esc_html_e('Loan Type:', 'flavor'); ?>
            </strong></label><br>
        <input type="text" id="testimonial_loan_type" name="testimonial_loan_type"
            value="<?php echo esc_attr($loan_type); ?>" style="width: 100%;">
    </p>
    <?php
}

/**
 * Save meta box data
 */
function finance_theme_save_testimonial_meta($post_id): void
{
    if (!isset($_POST['finance_theme_testimonial_nonce'])) {
        return;
    }

    if (!wp_verify_nonce(sanitize_key($_POST['finance_theme_testimonial_nonce']), 'finance_theme_testimonial_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['testimonial_rating'])) {
        update_post_meta($post_id, '_testimonial_rating', absint($_POST['testimonial_rating']));
    }

    if (isset($_POST['testimonial_loan_type'])) {
        update_post_meta($post_id, '_testimonial_loan_type', sanitize_text_field(wp_unslash($_POST['testimonial_loan_type'])));
    }
}
add_action('save_post_testimonial', 'finance_theme_save_testimonial_meta');
