<?php
/**
 * Class: Loan Metaboxes
 * 
 * Handles registration and saving of custom metaboxes for Loan Types.
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

class Flavor_Loan_Metaboxes
{

    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post', [$this, 'save_meta_boxes']);
    }

    /**
     * Add Meta Boxes
     */
    public function add_meta_boxes()
    {
        add_meta_box(
            'flavor_loan_details',
            __('Loan Details', 'finance-theme'),
            [$this, 'render_loan_details'],
            'loan_type',
            'normal',
            'high'
        );
    }

    /**
     * Render Loan Details Meta Box
     */
    public function render_loan_details($post)
    {
        // Add nonce for security
        wp_nonce_field('flavor_save_loan_details', 'flavor_loan_details_nonce');

        // Retrieve existing values
        $subtitle = get_post_meta($post->ID, '_loan_subtitle', true);
        $amount = get_post_meta($post->ID, '_loan_amount', true);
        $term = get_post_meta($post->ID, '_loan_term', true);
        $color = get_post_meta($post->ID, '_loan_color', true);
        $icon = get_post_meta($post->ID, '_loan_icon', true);
        $features = get_post_meta($post->ID, '_loan_features', true);

        // Stats
        $stat_1_number = get_post_meta($post->ID, '_loan_stat_1_number', true);
        $stat_1_label = get_post_meta($post->ID, '_loan_stat_1_label', true);
        $stat_2_number = get_post_meta($post->ID, '_loan_stat_2_number', true);
        $stat_2_label = get_post_meta($post->ID, '_loan_stat_2_label', true);
        $stat_3_number = get_post_meta($post->ID, '_loan_stat_3_number', true);
        $stat_3_label = get_post_meta($post->ID, '_loan_stat_3_label', true);

        // Icons list
        $icons = [
            'user' => 'User (Personal)',
            'car' => 'Car',
            'home' => 'Home',
            'briefcase' => 'Briefcase (Business)',
            'refresh' => 'Refresh (Consolidation)',
            'heart' => 'Heart (Wedding/Medical)',
            'plane' => 'Plane (Travel)',
            'medical' => 'Medical',
        ];
        ?>
        <div class="flavor-metabox-wrapper">
            <style>
                .flavor-form-row {
                    margin-bottom: 20px;
                }

                .flavor-form-row label {
                    display: block;
                    font-weight: bold;
                    margin-bottom: 5px;
                }

                .flavor-form-row input[type="text"],
                .flavor-form-row select,
                .flavor-form-row textarea {
                    width: 100%;
                    max-width: 600px;
                }

                .flavor-stats-grid {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 20px;
                    max-width: 900px;
                }
            </style>

            <div class="flavor-form-row">
                <label for="loan_subtitle">
                    <?php _e('Subtitle / Short Description', 'finance-theme'); ?>
                </label>
                <input type="text" id="loan_subtitle" name="loan_subtitle" value="<?php echo esc_attr($subtitle); ?>"
                    placeholder="e.g. Fast access to funds when you need them most.">
                <p class="description">
                    <?php _e('Displayed under the title on single pages and cards.', 'finance-theme'); ?>
                </p>
            </div>

            <div class="flavor-form-row">
                <div style="display: flex; gap: 20px;">
                    <div style="flex: 1; max-width: 300px;">
                        <label for="loan_amount">
                            <?php _e('Loan Amount Text', 'finance-theme'); ?>
                        </label>
                        <input type="text" id="loan_amount" name="loan_amount" value="<?php echo esc_attr($amount); ?>"
                            placeholder="e.g. $500 - $10,000">
                    </div>
                    <div style="flex: 1; max-width: 300px;">
                        <label for="loan_term">
                            <?php _e('Loan Term Text', 'finance-theme'); ?>
                        </label>
                        <input type="text" id="loan_term" name="loan_term" value="<?php echo esc_attr($term); ?>"
                            placeholder="e.g. 16 days - 24 months">
                    </div>
                </div>
            </div>

            <div class="flavor-form-row">
                <label for="loan_features">
                    <?php _e('Key Features', 'finance-theme'); ?>
                </label>
                <textarea id="loan_features" name="loan_features" rows="5"
                    placeholder="Enter one feature per line..."><?php echo esc_textarea($features); ?></textarea>
                <p class="description">
                    <?php _e('Enter each feature on a new line.', 'finance-theme'); ?>
                </p>
            </div>

            <div class="flavor-form-row">
                <div style="display: flex; gap: 20px;">
                    <div style="flex: 1; max-width: 300px;">
                        <label for="loan_icon">
                            <?php _e('Icon', 'finance-theme'); ?>
                        </label>
                        <select id="loan_icon" name="loan_icon">
                            <option value="default">
                                <?php _e('Default', 'finance-theme'); ?>
                            </option>
                            <?php foreach ($icons as $key => $label): ?>
                                <option value="<?php echo esc_attr($key); ?>" <?php selected($icon, $key); ?>>
                                    <?php echo esc_html($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div style="flex: 1; max-width: 300px;">
                        <label for="loan_color">
                            <?php _e('Accent Color', 'finance-theme'); ?>
                        </label>
                        <input type="text" id="loan_color" name="loan_color" value="<?php echo esc_attr($color); ?>"
                            placeholder="#e75480 or var(--accent-500)">
                    </div>
                </div>
            </div>

            <hr>
            <h3>
                <?php _e('Hero Statistics', 'finance-theme'); ?>
            </h3>
            <div class="flavor-stats-grid">
                <div>
                    <label>
                        <?php _e('Stat 1', 'finance-theme'); ?>
                    </label>
                    <input type="text" name="loan_stat_1_number" value="<?php echo esc_attr($stat_1_number); ?>"
                        placeholder="Value (e.g. $50k)" style="margin-bottom: 5px;">
                    <input type="text" name="loan_stat_1_label" value="<?php echo esc_attr($stat_1_label); ?>"
                        placeholder="Label (e.g. Max Amount)">
                </div>
                <div>
                    <label>
                        <?php _e('Stat 2', 'finance-theme'); ?>
                    </label>
                    <input type="text" name="loan_stat_2_number" value="<?php echo esc_attr($stat_2_number); ?>"
                        placeholder="Value (e.g. 60 min*)" style="margin-bottom: 5px;">
                    <input type="text" name="loan_stat_2_label" value="<?php echo esc_attr($stat_2_label); ?>"
                        placeholder="Label (e.g. Fast Funding)">
                </div>
                <div>
                    <label>
                        <?php _e('Stat 3', 'finance-theme'); ?>
                    </label>
                    <input type="text" name="loan_stat_3_number" value="<?php echo esc_attr($stat_3_number); ?>"
                        placeholder="Value (e.g. 100%)" style="margin-bottom: 5px;">
                    <input type="text" name="loan_stat_3_label" value="<?php echo esc_attr($stat_3_label); ?>"
                        placeholder="Label (e.g. Online Process)">
                </div>
            </div>

            <hr>
            <h3>
                <?php _e('Example Loan Costs', 'finance-theme'); ?>
            </h3>
            <p class="description">
                        <?php _e('Configure the example loan cost cards shown on single loan pages.', 'finance-theme'); ?></p>

            <?php
            // Get loan cost examples
            $cost_1_amount = get_post_meta($post->ID, '_loan_cost_1_amount', true) ?: '$1,000';
            $cost_1_term = get_post_meta($post->ID, '_loan_cost_1_term', true) ?: 'Over 12 months';
            $cost_1_repayment = get_post_meta($post->ID, '_loan_cost_1_repayment', true) ?: '$95/fortnight*';

            $cost_2_amount = get_post_meta($post->ID, '_loan_cost_2_amount', true) ?: '$3,000';
            $cost_2_term = get_post_meta($post->ID, '_loan_cost_2_term', true) ?: 'Over 24 months';
            $cost_2_repayment = get_post_meta($post->ID, '_loan_cost_2_repayment', true) ?: '$75/fortnight*';

            $cost_3_amount = get_post_meta($post->ID, '_loan_cost_3_amount', true) ?: '$5,000';
            $cost_3_term = get_post_meta($post->ID, '_loan_cost_3_term', true) ?: 'Over 36 months';
            $cost_3_repayment = get_post_meta($post->ID, '_loan_cost_3_repayment', true) ?: '$85/fortnight*';
            ?>

            <div class="flavor-stats-grid" style="margin-top: 15px;">
                <div style="background: #f9f9f9; padding: 15px; border-radius: 8px;">
                    <label style="display: block; margin-bottom: 10px; font-weight: bold;">
                        <?php _e('Example 1', 'finance-theme'); ?>
                    </label>
                    <input type="text" name="loan_cost_1_amount" value="<?php echo esc_attr($cost_1_amount); ?>"
                        placeholder="Amount (e.g. $1,000)" style="margin-bottom: 5px;">
                    <input type="text" name="loan_cost_1_term" value="<?php echo esc_attr($cost_1_term); ?>"
                        placeholder="Term (e.g. Over 12 months)" style="margin-bottom: 5px;">
                    <input type="text" name="loan_cost_1_repayment" value="<?php echo esc_attr($cost_1_repayment); ?>"
                        placeholder="Repayment (e.g. $95/fortnight*)">
                </div>
                <div style="background: #e8f5e9; padding: 15px; border-radius: 8px; border: 2px solid #4caf50;">
                    <label style="display: block; margin-bottom: 10px; font-weight: bold;">
                        <?php _e('Example 2 (Popular)', 'finance-theme'); ?>
                    </label>
                    <input type="text" name="loan_cost_2_amount" value="<?php echo esc_attr($cost_2_amount); ?>"
                        placeholder="Amount (e.g. $3,000)" style="margin-bottom: 5px;">
                    <input type="text" name="loan_cost_2_term" value="<?php echo esc_attr($cost_2_term); ?>"
                        placeholder="Term (e.g. Over 24 months)" style="margin-bottom: 5px;">
                    <input type="text" name="loan_cost_2_repayment" value="<?php echo esc_attr($cost_2_repayment); ?>"
                        placeholder="Repayment (e.g. $75/fortnight*)">
                </div>
                <div style="background: #f9f9f9; padding: 15px; border-radius: 8px;">
                    <label style="display: block; margin-bottom: 10px; font-weight: bold;">
                        <?php _e('Example 3', 'finance-theme'); ?>
                    </label>
                    <input type="text" name="loan_cost_3_amount" value="<?php echo esc_attr($cost_3_amount); ?>"
                        placeholder="Amount (e.g. $5,000)" style="margin-bottom: 5px;">
                    <input type="text" name="loan_cost_3_term" value="<?php echo esc_attr($cost_3_term); ?>"
                        placeholder="Term (e.g. Over 36 months)" style="margin-bottom: 5px;">
                    <input type="text" name="loan_cost_3_repayment" value="<?php echo esc_attr($cost_3_repayment); ?>"
                        placeholder="Repayment (e.g. $85/fortnight*)">
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Save Meta Box Data
     */
    public function save_meta_boxes($post_id)
    {
        // Check nonce
        if (!isset($_POST['flavor_loan_details_nonce']) || !wp_verify_nonce($_POST['flavor_loan_details_nonce'], 'flavor_save_loan_details')) {
            return;
        }

        // Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check permissions
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // List of fields to save
        $fields = [
            'loan_subtitle',
            'loan_amount',
            'loan_term',
            'loan_color',
            'loan_icon',
            'loan_features',
            'loan_stat_1_number',
            'loan_stat_1_label',
            'loan_stat_2_number',
            'loan_stat_2_label',
            'loan_stat_3_number',
            'loan_stat_3_label',
            // Loan Cost Examples
            'loan_cost_1_amount',
            'loan_cost_1_term',
            'loan_cost_1_repayment',
            'loan_cost_2_amount',
            'loan_cost_2_term',
            'loan_cost_2_repayment',
            'loan_cost_3_amount',
            'loan_cost_3_term',
            'loan_cost_3_repayment',
        ];

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $value = sanitize_text_field($_POST[$field]);
                // For textarea, we want to preserve newlines but sanitize content
                if ($field === 'loan_features') {
                    $value = sanitize_textarea_field($_POST[$field]);
                }
                update_post_meta($post_id, '_' . $field, $value);
            }
        }
    }
}

// Initialize
new Flavor_Loan_Metaboxes();
