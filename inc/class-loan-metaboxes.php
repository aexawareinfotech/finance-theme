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
                    <?php esc_html_e('Subtitle / Short Description', 'finance-theme'); ?>
                </label>
                <input type="text" id="loan_subtitle" name="loan_subtitle" value="<?php echo esc_attr($subtitle); ?>"
                    placeholder="e.g. Fast access to funds when you need them most.">
                <p class="description">
                    <?php esc_html_e('Displayed under the title on single pages and cards.', 'finance-theme'); ?>
                </p>
            </div>

            <div class="flavor-form-row">
                <div style="display: flex; gap: 20px;">
                    <div style="flex: 1; max-width: 300px;">
                        <label for="loan_amount">
                            <?php esc_html_e('Loan Amount Text', 'finance-theme'); ?>
                        </label>
                        <input type="text" id="loan_amount" name="loan_amount" value="<?php echo esc_attr($amount); ?>"
                            placeholder="e.g. $500 - $10,000">
                    </div>
                    <div style="flex: 1; max-width: 300px;">
                        <label for="loan_term">
                            <?php esc_html_e('Loan Term Text', 'finance-theme'); ?>
                        </label>
                        <input type="text" id="loan_term" name="loan_term" value="<?php echo esc_attr($term); ?>"
                            placeholder="e.g. 16 days - 24 months">
                    </div>
                </div>
            </div>

            <div class="flavor-form-row">
                <label for="loan_features">
                    <?php esc_html_e('Key Features', 'finance-theme'); ?>
                </label>
                <textarea id="loan_features" name="loan_features" rows="5"
                    placeholder="Enter one feature per line..."><?php echo esc_textarea($features); ?></textarea>
                <p class="description">
                    <?php esc_html_e('Enter each feature on a new line.', 'finance-theme'); ?>
                </p>
            </div>

            <div class="flavor-form-row">
                <div style="display: flex; gap: 20px;">
                    <div style="flex: 1; max-width: 300px;">
                        <label for="loan_icon">
                            <?php esc_html_e('Icon', 'finance-theme'); ?>
                        </label>
                        <select id="loan_icon" name="loan_icon">
                            <option value="default">
                                <?php esc_html_e('Default', 'finance-theme'); ?>
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
                            <?php esc_html_e('Accent Color', 'finance-theme'); ?>
                        </label>
                        <input type="text" id="loan_color" name="loan_color" value="<?php echo esc_attr($color); ?>"
                            placeholder="#e75480 or var(--accent-500)">
                    </div>
                </div>
            </div>



            <h3>
                <?php esc_html_e('Loan Comparison Examples', 'finance-theme'); ?>
            </h3>
            <p class="description">
                <?php esc_html_e('Configure the Small and Medium loan examples shown on the single loan page.', 'finance-theme'); ?>
            </p>

            <?php
            // Small Loan Defaults
            $small_amount = get_post_meta($post->ID, '_loan_small_amount', true) ?: '$500 – $2,000';
            $small_term = get_post_meta($post->ID, '_loan_small_term', true) ?: '16 days – 12 months';
            $small_fees = get_post_meta($post->ID, '_loan_small_fees', true) ?: '20% establishment + 4% monthly (flat) | Other fees and charges may apply.';
            $small_repayment = get_post_meta($post->ID, '_loan_small_repayment', true) ?: '$70.00';
            
            $small_table_amount = get_post_meta($post->ID, '_loan_small_table_amount', true) ?: '$1,000';
            $small_table_term = get_post_meta($post->ID, '_loan_small_table_term', true) ?: '28 weeks';
            $small_table_fee = get_post_meta($post->ID, '_loan_small_table_fee', true) ?: '$200';
            $small_table_monthly = get_post_meta($post->ID, '_loan_small_table_monthly', true) ?: '$280';
            $small_table_total = get_post_meta($post->ID, '_loan_small_table_total', true) ?: '$1,480';

            // Medium Loan Defaults
            $medium_amount = get_post_meta($post->ID, '_loan_medium_amount', true) ?: '$2,001 – $5,000';
            $medium_term = get_post_meta($post->ID, '_loan_medium_term', true) ?: '9 weeks – 24 months';
            $medium_fees = get_post_meta($post->ID, '_loan_medium_fees', true) ?: 'up to $400 establishment fee | Interest: up to 47.80% p.a| Other fees and charges may apply.';
            $medium_repayment = get_post_meta($post->ID, '_loan_medium_repayment', true) ?: '$117.67';

            $medium_table_amount = get_post_meta($post->ID, '_loan_medium_table_amount', true) ?: '$2,500';
            $medium_table_term = get_post_meta($post->ID, '_loan_medium_table_term', true) ?: '28 Weeks';
            $medium_table_fee = get_post_meta($post->ID, '_loan_medium_table_fee', true) ?: '$400';
            $medium_table_interest = get_post_meta($post->ID, '_loan_medium_table_interest', true) ?: '$394.74';
            $medium_table_total = get_post_meta($post->ID, '_loan_medium_table_total', true) ?: '$3,289';
            ?>

            <div class="flavor-stats-grid" style="grid-template-columns: 1fr 1fr; margin-top: 15px;">
                <!-- Small Loan -->
                <div style="background: #f9f9f9; padding: 15px; border-radius: 8px;">
                    <label style="display: block; margin-bottom: 10px; font-weight: bold; font-size: 1.1em; color: #2c3e50;">
                        <?php esc_html_e('Small Loan', 'finance-theme'); ?>
                    </label>
                    
                    <!-- Header Info -->
                    <div style="margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                        <label style="font-weight: 600;">Header Details</label>
                        <input type="text" name="loan_small_amount" value="<?php echo esc_attr($small_amount); ?>" placeholder="Loan Amount Range" style="margin-bottom: 5px; width: 100%;">
                        <input type="text" name="loan_small_term" value="<?php echo esc_attr($small_term); ?>" placeholder="Loan Term Range" style="margin-bottom: 5px; width: 100%;">
                        <textarea name="loan_small_fees" rows="2" placeholder="Fees Description" style="width: 100%;"><?php echo esc_textarea($small_fees); ?></textarea>
                    </div>

                    <!-- Table Data -->
                    <div>
                        <label style="font-weight: 600;">Table Example Data</label>
                        <input type="text" name="loan_small_table_amount" value="<?php echo esc_attr($small_table_amount); ?>" placeholder="Example Amount ($1,000)" style="margin-bottom: 5px;">
                        <input type="text" name="loan_small_table_term" value="<?php echo esc_attr($small_table_term); ?>" placeholder="Example Term (28 weeks)" style="margin-bottom: 5px;">
                        <input type="text" name="loan_small_table_fee" value="<?php echo esc_attr($small_table_fee); ?>" placeholder="Est. Fee ($200)" style="margin-bottom: 5px;">
                        <input type="text" name="loan_small_table_monthly" value="<?php echo esc_attr($small_table_monthly); ?>" placeholder="Monthly Fee ($280)" style="margin-bottom: 5px;">
                        <input type="text" name="loan_small_table_total" value="<?php echo esc_attr($small_table_total); ?>" placeholder="Total Repayable ($1,480)" style="margin-bottom: 5px;">
                        <hr style="margin: 10px 0;">
                        <label>Weekly Repayment:</label>
                        <input type="text" name="loan_small_repayment" value="<?php echo esc_attr($small_repayment); ?>" placeholder="$70.00">
                    </div>
                </div>

                <!-- Medium Loan -->
                <div style="background: #e8f5e9; padding: 15px; border-radius: 8px; border: 1px solid #4caf50;">
                    <label style="display: block; margin-bottom: 10px; font-weight: bold; font-size: 1.1em; color: #2c3e50;">
                        <?php esc_html_e('Medium Loan', 'finance-theme'); ?>
                    </label>

                    <!-- Header Info -->
                    <div style="margin-bottom: 15px; border-bottom: 1px solid #a5d6a7; padding-bottom: 10px;">
                        <label style="font-weight: 600;">Header Details</label>
                        <input type="text" name="loan_medium_amount" value="<?php echo esc_attr($medium_amount); ?>" placeholder="Loan Amount Range" style="margin-bottom: 5px; width: 100%;">
                        <input type="text" name="loan_medium_term" value="<?php echo esc_attr($medium_term); ?>" placeholder="Loan Term Range" style="margin-bottom: 5px; width: 100%;">
                        <textarea name="loan_medium_fees" rows="2" placeholder="Fees Description" style="width: 100%;"><?php echo esc_textarea($medium_fees); ?></textarea>
                    </div>

                    <!-- Table Data -->
                    <div>
                        <label style="font-weight: 600;">Table Example Data</label>
                        <input type="text" name="loan_medium_table_amount" value="<?php echo esc_attr($medium_table_amount); ?>" placeholder="Example Amount ($2,500)" style="margin-bottom: 5px;">
                        <input type="text" name="loan_medium_table_term" value="<?php echo esc_attr($medium_table_term); ?>" placeholder="Example Term (28 Weeks)" style="margin-bottom: 5px;">
                        <input type="text" name="loan_medium_table_fee" value="<?php echo esc_attr($medium_table_fee); ?>" placeholder="Est. Fee ($400)" style="margin-bottom: 5px;">
                        <input type="text" name="loan_medium_table_interest" value="<?php echo esc_attr($medium_table_interest); ?>" placeholder="Total Interest ($394.74)" style="margin-bottom: 5px;">
                        <input type="text" name="loan_medium_table_total" value="<?php echo esc_attr($medium_table_total); ?>" placeholder="Total Repayable ($3,289)" style="margin-bottom: 5px;">
                        <hr style="margin: 10px 0; border-color: #a5d6a7;">
                        <label>Weekly Repayment:</label>
                        <input type="text" name="loan_medium_repayment" value="<?php echo esc_attr($medium_repayment); ?>" placeholder="$117.67">
                    </div>
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

            // Small Loan Example
            'loan_small_amount',
            'loan_small_term',
            'loan_small_fees',
            'loan_small_repayment', // Weekly repayment

            // Small Table Details
            'loan_small_table_amount',
            'loan_small_table_term',
            'loan_small_table_fee', // Establishment fee
            'loan_small_table_monthly', // Monthly fee
            'loan_small_table_total', // Total repayable

            // Medium Loan Example
            'loan_medium_amount',
            'loan_medium_term',
            'loan_medium_fees',
            'loan_medium_repayment', // Weekly repayment

            // Medium Table Details
            'loan_medium_table_amount',
            'loan_medium_table_term',
            'loan_medium_table_fee', // Establishment fee
            'loan_medium_table_interest', // Total interest
            'loan_medium_table_total', // Total repayable

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
