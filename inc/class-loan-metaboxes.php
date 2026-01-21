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
        add_action('admin_head', [$this, 'add_admin_styles']);
    }

    /**
     * Add Admin Styles
     */
    public function add_admin_styles()
    {
        ?>
        <style>
            .flavor-metabox-wrapper {
                max-width: 100%;
            }

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
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 20px;
                margin-top: 15px;
            }

            .flavor-accordion {
                border: 1px solid #ddd;
                border-radius: 4px;
                margin-bottom: 10px;
            }

            .flavor-accordion-header {
                background: #f7f7f7;
                padding: 12px 15px;
                cursor: pointer;
                font-weight: 600;
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px solid #ddd;
            }

            .flavor-accordion-header:hover {
                background: #ebebeb;
            }

            .flavor-accordion-icon {
                transition: transform 0.3s;
            }

            .flavor-accordion.open .flavor-accordion-icon {
                transform: rotate(90deg);
            }

            .flavor-accordion-content {
                padding: 20px;
                display: none;
            }

            .flavor-accordion.open .flavor-accordion-content {
                display: block;
            }

            .loan-tier-box {
                padding: 15px;
                border-radius: 8px;
                border: 1px solid #ddd;
            }

            .loan-tier-box.small {
                background: #f9f9f9;
            }

            .loan-tier-box.medium {
                background: #e8f5e9;
                border-color: #4caf50;
            }

            .loan-tier-box.large {
                background: #e3f2fd;
                border-color: #2196f3;
            }

            .loan-tier-header {
                font-weight: bold;
                font-size: 1.1em;
                color: #2c3e50;
                margin-bottom: 10px;
                display: block;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.flavor-accordion-header').forEach(function(header) {
                    header.addEventListener('click', function() {
                        const accordion = this.parentElement;
                        accordion.classList.toggle('open');
                    });
                });
            });
        </script>
        <?php
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
        $this->render_basic_settings($post);
        $this->render_hero_section($post);
        $this->render_features_row_section($post);
        $this->render_why_choose_section($post);
        $this->render_eligibility_section($post);
        $this->render_how_to_apply_section($post);
        $this->render_comparison_section($post);
        $this->render_loan_examples($post);
        $this->render_section_order($post);
        $this->render_testimonials_faqs($post);
    }

    /**
     * Render Basic Settings
     */
    private function render_basic_settings($post)
    {
        $subtitle = get_post_meta($post->ID, '_loan_subtitle', true);
        $amount = get_post_meta($post->ID, '_loan_amount', true);
        $term = get_post_meta($post->ID, '_loan_term', true);
        $color = get_post_meta($post->ID, '_loan_color', true);
        $icon = get_post_meta($post->ID, '_loan_icon', true);

        $icons = [
            'default' => 'Default',
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
            <div class="flavor-accordion open">
                <div class="flavor-accordion-header">
                    <span>⚙️ Basic Settings</span>
                    <span class="flavor-accordion-icon">▶</span>
                </div>
                <div class="flavor-accordion-content">
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
                        <div style="display: flex; gap: 20px;">
                            <div style="flex: 1; max-width: 300px;">
                                <label for="loan_icon">
                                    <?php esc_html_e('Icon', 'finance-theme'); ?>
                                </label>
                                <select id="loan_icon" name="loan_icon">
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
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Render Hero Section Settings
     */
    private function render_hero_section($post)
    {
        // Convert old format to new textarea format
        $hero_features = get_post_meta($post->ID, '_hero_features', true);
        if (empty($hero_features)) {
            // Check for old individual fields and migrate
            $old_features = [];
            for ($i = 1; $i <= 4; $i++) {
                $feat = get_post_meta($post->ID, "_hero_feature_{$i}", true);
                if ($feat) $old_features[] = $feat;
            }
            if (!empty($old_features)) {
                $hero_features = implode("\n", $old_features);
            } else {
                $hero_features = "Borrow from $2,000 to $50,000\nDigital & Paperless Journey\nProudly Australian Lender\nInstant Decisions and Same-Day Cash";
            }
        }
        
        $calculator_heading = get_post_meta($post->ID, '_calculator_heading', true) ?: "I'd like to borrow";
        $calculator_button = get_post_meta($post->ID, '_calculator_button', true) ?: 'Apply Now';
        $calculator_note = get_post_meta($post->ID, '_calculator_note', true) ?: 'Online application in minutes!';
        ?>
        <div class="flavor-accordion">
            <div class="flavor-accordion-header">
                <span>🎯 Hero Section</span>
                <span class="flavor-accordion-icon">▶</span>
            </div>
            <div class="flavor-accordion-content">
                <div class="flavor-form-row">
                    <label for="hero_features"><?php esc_html_e('Hero Features (One per line - Add as many as you want!)', 'finance-theme'); ?></label>
                    <textarea id="hero_features" name="hero_features" rows="5" placeholder="Borrow from $2,000 to $50,000&#10;Digital &amp; Paperless Journey&#10;Proudly Australian Lender&#10;Add more features here..."><?php echo esc_textarea($hero_features); ?></textarea>
                    <p class="description"><?php esc_html_e('Enter one feature per line. You can add as many as you need!', 'finance-theme'); ?></p>
                </div>

                <div class="flavor-form-row">
                    <label for="calculator_heading"><?php esc_html_e('Calculator Heading', 'finance-theme'); ?></label>
                    <input type="text" id="calculator_heading" name="calculator_heading" value="<?php echo esc_attr($calculator_heading); ?>">
                </div>

                <div class="flavor-form-row">
                    <label for="calculator_button"><?php esc_html_e('Calculator Button Text', 'finance-theme'); ?></label>
                    <input type="text" id="calculator_button" name="calculator_button" value="<?php echo esc_attr($calculator_button); ?>">
                </div>

                <div class="flavor-form-row">
                    <label for="calculator_note"><?php esc_html_e('Calculator Note Text', 'finance-theme'); ?></label>
                    <input type="text" id="calculator_note" name="calculator_note" value="<?php echo esc_attr($calculator_note); ?>">
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Render Features Row Section (Fast / Personal / Progress)
     */
    private function render_features_row_section($post)
    {
        $feature_1_title = get_post_meta($post->ID, '_features_row_1_title', true) ?: 'Fast';
        $feature_1_desc = get_post_meta($post->ID, '_features_row_1_desc', true) ?: 'Apply in minutes. Funds in 15 once approved.';
        
        $feature_2_title = get_post_meta($post->ID, '_features_row_2_title', true) ?: 'Personal';
        $feature_2_desc = get_post_meta($post->ID, '_features_row_2_desc', true) ?: 'A tailored rate that fits you. Not one-size-fits-all.';
        
        $feature_3_title = get_post_meta($post->ID, '_features_row_3_title', true) ?: 'Progress';
        $feature_3_desc = get_post_meta($post->ID, '_features_row_3_desc', true) ?: 'On-time repayments boost your credit score.';
        ?>
        <div class="flavor-accordion">
            <div class="flavor-accordion-header">
                <span>⚡ Features Row (Fast / Personal / Progress)</span>
                <span class="flavor-accordion-icon">▶</span>
            </div>
            <div class="flavor-accordion-content">
                <p class="description" style="margin-bottom: 15px; background: #e8f5e9; padding: 10px; border-radius: 4px;">
                    <?php esc_html_e('This section appears below the hero on all loan pages.', 'finance-theme'); ?>
                </p>

                <h4>Feature 1</h4>
                <div class="flavor-form-row">
                    <label>Title</label>
                    <input type="text" name="features_row_1_title" value="<?php echo esc_attr($feature_1_title); ?>" placeholder="Fast">
                </div>
                <div class="flavor-form-row">
                    <label>Description</label>
                    <input type="text" name="features_row_1_desc" value="<?php echo esc_attr($feature_1_desc); ?>" placeholder="Apply in minutes...">
                </div>

                <hr style="margin: 20px 0;">

                <h4>Feature 2</h4>
                <div class="flavor-form-row">
                    <label>Title</label>
                    <input type="text" name="features_row_2_title" value="<?php echo esc_attr($feature_2_title); ?>" placeholder="Personal">
                </div>
                <div class="flavor-form-row">
                    <label>Description</label>
                    <input type="text" name="features_row_2_desc" value="<?php echo esc_attr($feature_2_desc); ?>" placeholder="A tailored rate...">
                </div>

                <hr style="margin: 20px 0;">

                <h4>Feature 3</h4>
                <div class="flavor-form-row">
                    <label>Title</label>
                    <input type="text" name="features_row_3_title" value="<?php echo esc_attr($feature_3_title); ?>" placeholder="Progress">
                </div>
                <div class="flavor-form-row">
                    <label>Description</label>
                    <input type="text" name="features_row_3_desc" value="<?php echo esc_attr($feature_3_desc); ?>" placeholder="On-time repayments...">
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Render Why Choose Section
     */
    private function render_why_choose_section($post)
    {
        $why_heading_template = get_post_meta($post->ID, '_why_heading_template', true) ?: 'Why Choose a %s';
        $why_description = get_post_meta($post->ID, '_why_description', true);
        
        $why_feature_1_title = get_post_meta($post->ID, '_why_feature_1_title', true) ?: 'Cash in as little as 60 minutes';
        $why_feature_1_desc = get_post_meta($post->ID, '_why_feature_1_desc', true) ?: 'Apply online and, if approved before 4:30 pm on a banking day, you could have the cash in your account in just 60 minutes.*';
        
        $why_feature_2_title = get_post_meta($post->ID, '_why_feature_2_title', true) ?: '100% online, zero paperwork';
        $why_feature_2_desc = get_post_meta($post->ID, '_why_feature_2_desc', true) ?: 'No queues, no printers, no problem. Our fast online process keeps things simple, smart, and hassle-free.';
        
        $why_feature_3_title = get_post_meta($post->ID, '_why_feature_3_title', true) ?: 'Real support, real fast';
        $why_feature_3_desc = get_post_meta($post->ID, '_why_feature_3_desc', true) ?: 'Need help choosing the right repayment plan? Our Aussie-based team is here with real answers and is always happy to help.';
        ?>
        <div class="flavor-accordion">
            <div class="flavor-accordion-header">
                <span>⭐ Why Choose This Loan Section</span>
                <span class="flavor-accordion-icon">▶</span>
            </div>
            <div class="flavor-accordion-content">
                <div class="flavor-form-row">
                    <label for="why_heading_template"><?php esc_html_e('Heading Template (use %s for loan title)', 'finance-theme'); ?></label>
                    <input type="text" id="why_heading_template" name="why_heading_template" value="<?php echo esc_attr($why_heading_template); ?>">
                </div>

                <div class="flavor-form-row">
                    <label for="why_description"><?php esc_html_e('Description (leave empty to use subtitle)', 'finance-theme'); ?></label>
                    <textarea id="why_description" name="why_description" rows="2"><?php echo esc_textarea($why_description); ?></textarea>
                </div>

                <hr style="margin: 20px 0;">
                
                <h4>Feature 1</h4>
                <div class="flavor-form-row">
                    <label>Title</label>
                    <input type="text" name="why_feature_1_title" value="<?php echo esc_attr($why_feature_1_title); ?>">
                </div>
                <div class="flavor-form-row">
                    <label>Description</label>
                    <textarea name="why_feature_1_desc" rows="2"><?php echo esc_textarea($why_feature_1_desc); ?></textarea>
                </div>

                <hr style="margin: 20px 0;">

                <h4>Feature 2</h4>
                <div class="flavor-form-row">
                    <label>Title</label>
                    <input type="text" name="why_feature_2_title" value="<?php echo esc_attr($why_feature_2_title); ?>">
                </div>
                <div class="flavor-form-row">
                    <label>Description</label>
                    <textarea name="why_feature_2_desc" rows="2"><?php echo esc_textarea($why_feature_2_desc); ?></textarea>
                </div>

                <hr style="margin: 20px 0;">

                <h4>Feature 3</h4>
                <div class="flavor-form-row">
                    <label>Title</label>
                    <input type="text" name="why_feature_3_title" value="<?php echo esc_attr($why_feature_3_title); ?>">
                </div>
                <div class="flavor-form-row">
                    <label>Description</label>
                    <textarea name="why_feature_3_desc" rows="2"><?php echo esc_textarea($why_feature_3_desc); ?></textarea>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Render Eligibility Section
     */
    private function render_eligibility_section($post)
    {
        $eligibility_heading = get_post_meta($post->ID, '_eligibility_heading', true) ?: 'Eligibility';
        $eligibility_intro = get_post_meta($post->ID, '_eligibility_intro', true) ?: 'As a responsible lender, our priority is ensuring your loan is affordable and suitable for your specific needs.';
        $eligibility_subtitle = get_post_meta($post->ID, '_eligibility_subtitle', true) ?: 'To be eligible, you must:';
        
        // Convert to textarea format
        $eligibility_requirements = get_post_meta($post->ID, '_eligibility_requirements', true);
        if (empty($eligibility_requirements)) {
            // Migrate from old format
            $old_reqs = [];
            for ($i = 1; $i <= 3; $i++) {
                $req = get_post_meta($post->ID, "_eligibility_req_{$i}", true);
                if ($req) $old_reqs[] = $req;
            }
            if (!empty($old_reqs)) {
                $eligibility_requirements = implode("\n", $old_reqs);
            } else {
                $eligibility_requirements = "Receive a regular income\nBe an Australian resident\nBe at least 18 years old or over";
            }
        }
        
        $eligibility_note = get_post_meta($post->ID, '_eligibility_note', true) ?: ' can benefit from a faster borrowing process. As your trust rating improves, you may borrow more money with any subsequent loan - as long as you meet loan payments, the loan meets your requirements and objectives and repay your loan in full, on time and can afford the higher amount.';
        ?>
        <div class="flavor-accordion">
            <div class="flavor-accordion-header">
                <span>✅ Eligibility Section</span>
                <span class="flavor-accordion-icon">▶</span>
            </div>
            <div class="flavor-accordion-content">
                <div class="flavor-form-row">
                    <label for="eligibility_heading"><?php esc_html_e('Section Heading', 'finance-theme'); ?></label>
                    <input type="text" id="eligibility_heading" name="eligibility_heading" value="<?php echo esc_attr($eligibility_heading); ?>">
                </div>

                <div class="flavor-form-row">
                    <label for="eligibility_intro"><?php esc_html_e('Intro Paragraph', 'finance-theme'); ?></label>
                    <textarea id="eligibility_intro" name="eligibility_intro" rows="2"><?php echo esc_textarea($eligibility_intro); ?></textarea>
                </div>

                <div class="flavor-form-row">
                    <label for="eligibility_subtitle"><?php esc_html_e('Requirements Subtitle', 'finance-theme'); ?></label>
                    <input type="text" id="eligibility_subtitle" name="eligibility_subtitle" value="<?php echo esc_attr($eligibility_subtitle); ?>">
                </div>

                <div class="flavor-form-row">
                    <label for="eligibility_requirements"><?php esc_html_e('Requirements (One per line - Add as many as needed)', 'finance-theme'); ?></label>
                    <textarea id="eligibility_requirements" name="eligibility_requirements" rows="4"><?php echo esc_textarea($eligibility_requirements); ?></textarea>
                    <p class="description"><?php esc_html_e('Enter one requirement per line. Add as many as you need!', 'finance-theme'); ?></p>
                </div>

                <div class="flavor-form-row">
                    <label for="eligibility_note"><?php esc_html_e('Bottom Note (after "Existing customers" link)', 'finance-theme'); ?></label>
                    <textarea id="eligibility_note" name="eligibility_note" rows="3"><?php echo esc_textarea($eligibility_note); ?></textarea>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Render How to Apply Section
     */
    private function render_how_to_apply_section($post)
    {
        $apply_heading = get_post_meta($post->ID, '_apply_heading', true) ?: 'How do I apply for a loan with Fair Go?';
        $apply_description = get_post_meta($post->ID, '_apply_description', true) ?: 'Applying for a %s is as simple as 4 easy steps.';
        $apply_button = get_post_meta($post->ID, '_apply_button', true) ?: 'Apply now';
        
        $apply_step_1_title = get_post_meta($post->ID, '_apply_step_1_title', true) ?: 'Apply in minutes';
        $apply_step_1_desc = get_post_meta($post->ID, '_apply_step_1_desc', true) ?: 'You can apply online anywhere, at any time. All you have to do is answer some simple questions and provide 90 day bank statements.';
        
        $apply_step_2_title = get_post_meta($post->ID, '_apply_step_2_title', true) ?: 'Get your loan offer';
        $apply_step_2_desc = get_post_meta($post->ID, '_apply_step_2_desc', true) ?: 'Get a conditional loan offer immediately* which outlines the terms of your loan while you wait for final approval.';
        
        $apply_step_3_title = get_post_meta($post->ID, '_apply_step_3_title', true) ?: 'Receive your loan approval';
        $apply_step_3_desc = get_post_meta($post->ID, '_apply_step_3_desc', true) ?: 'Our team is dedicated to balancing speed with responsible lending. We\'ll assess your application and let you know as soon as your loan is approved.*';
        
        $apply_step_4_title = get_post_meta($post->ID, '_apply_step_4_title', true) ?: 'Get your money';
        $apply_step_4_desc = get_post_meta($post->ID, '_apply_step_4_desc', true) ?: 'Once your loan is approved, your emergency cash will be digitally transferred to your bank account within 30 minutes via NPP instant transfers.**';
        ?>
        <div class="flavor-accordion">
            <div class="flavor-accordion-header">
                <span>📝 How to Apply Section</span>
                <span class="flavor-accordion-icon">▶</span>
            </div>
            <div class="flavor-accordion-content">
                <div class="flavor-form-row">
                    <label for="apply_heading"><?php esc_html_e('Section Heading', 'finance-theme'); ?></label>
                    <input type="text" id="apply_heading" name="apply_heading" value="<?php echo esc_attr($apply_heading); ?>">
                </div>

                <div class="flavor-form-row">
                    <label for="apply_description"><?php esc_html_e('Description (use %s for loan title)', 'finance-theme'); ?></label>
                    <input type="text" id="apply_description" name="apply_description" value="<?php echo esc_attr($apply_description); ?>">
                </div>

                <div class="flavor-form-row">
                    <label for="apply_button"><?php esc_html_e('Button Text', 'finance-theme'); ?></label>
                    <input type="text" id="apply_button" name="apply_button" value="<?php echo esc_attr($apply_button); ?>">
                </div>

                <hr style="margin: 20px 0;">

                <?php for ($i = 1; $i <= 4; $i++): 
                    $title_var = "apply_step_{$i}_title";
                    $desc_var = "apply_step_{$i}_desc";
                    $title = $$title_var;
                    $desc = $$desc_var;
                ?>
                <h4>Step <?php echo $i; ?></h4>
                <div class="flavor-form-row">
                    <label>Title</label>
                    <input type="text" name="apply_step_<?php echo $i; ?>_title" value="<?php echo esc_attr($title); ?>">
                </div>
                <div class="flavor-form-row">
                    <label>Description</label>
                    <textarea name="apply_step_<?php echo $i; ?>_desc" rows="2"><?php echo esc_textarea($desc); ?></textarea>
                </div>
                <?php if ($i < 4): ?><hr style="margin: 20px 0;"><?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Render Comparison Section
     */
    private function render_comparison_section($post)
    {
        $comparison_heading = get_post_meta($post->ID, '_comparison_heading', true) ?: '%s Examples';
        $hide_phone_mockup = get_post_meta($post->ID, '_hide_phone_mockup', true);
        
        // Convert to textarea format
        $phone_benefits = get_post_meta($post->ID, '_phone_benefits', true);
        if (empty($phone_benefits)) {
            // Migrate from old format
            $old_benefits = [];
            for ($i = 1; $i <= 4; $i++) {
                $benefit = get_post_meta($post->ID, "_phone_benefit_{$i}", true);
                if ($benefit) $old_benefits[] = $benefit;
            }
            if (!empty($old_benefits)) {
                $phone_benefits = implode("\n", $old_benefits);
            } else {
                $phone_benefits = "Borrow between $500 to $5,000\nFlexible payment terms\nNo hidden fees - payout early to reduce total repayment\nMoney in 60 minutes* of contract acceptance";
            }
        }
        ?>
        <div class="flavor-accordion">
            <div class="flavor-accordion-header">
                <span>📊 Comparison Section</span>
                <span class="flavor-accordion-icon">▶</span>
            </div>
            <div class="flavor-accordion-content">
                <div class="flavor-form-row">
                    <label for="comparison_heading"><?php esc_html_e('Section Heading (use %s for loan title)', 'finance-theme'); ?></label>
                    <input type="text" id="comparison_heading" name="comparison_heading" value="<?php echo esc_attr($comparison_heading); ?>">
                </div>

                <div class="flavor-form-row">
                    <label>
                        <input type="checkbox" name="hide_phone_mockup" value="1" <?php checked($hide_phone_mockup, '1'); ?>>
                        <?php esc_html_e('Hide phone mockup image (show only benefits list)', 'finance-theme'); ?>
                    </label>
                    <p class="description"><?php esc_html_e('Check this to remove the phone image and just show the benefits list.', 'finance-theme'); ?></p>
                </div>

                <div class="flavor-form-row">
                    <label for="phone_benefits"><?php esc_html_e('Benefits List (One per line - Add as many as needed)', 'finance-theme'); ?></label>
                    <textarea id="phone_benefits" name="phone_benefits" rows="5"><?php echo esc_textarea($phone_benefits); ?></textarea>
                    <p class="description"><?php esc_html_e('Enter one benefit per line. These appear next to (or instead of) the phone mockup.', 'finance-theme'); ?></p>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Render Loan Examples (Small, Medium, Large)
     */
    private function render_loan_examples($post)
    {
        // Small Loan
        $small_amount = get_post_meta($post->ID, '_loan_small_amount', true) ?: '$500 – $2,000';
        $small_term = get_post_meta($post->ID, '_loan_small_term', true) ?: '16 days – 12 months';
        $small_fees = get_post_meta($post->ID, '_loan_small_fees', true) ?: '20% establishment + 4% monthly (flat) | Other fees and charges may apply.';
        $small_repayment = get_post_meta($post->ID, '_loan_small_repayment', true) ?: '$70.00';
        $small_table_amount = get_post_meta($post->ID, '_loan_small_table_amount', true) ?: '$1,000';
        $small_table_term = get_post_meta($post->ID, '_loan_small_table_term', true) ?: '28 weeks';
        $small_table_fee = get_post_meta($post->ID, '_loan_small_table_fee', true) ?: '$200';
        $small_table_monthly = get_post_meta($post->ID, '_loan_small_table_monthly', true) ?: '$280';
        $small_table_total = get_post_meta($post->ID, '_loan_small_table_total', true) ?: '$1,480';

        // Medium Loan
        $medium_amount = get_post_meta($post->ID, '_loan_medium_amount', true) ?: '$2,001 – $5,000';
        $medium_term = get_post_meta($post->ID, '_loan_medium_term', true) ?: '9 weeks – 24 months';
        $medium_fees = get_post_meta($post->ID, '_loan_medium_fees', true) ?: 'up to $400 establishment fee | Interest: up to 47.80% p.a| Other fees and charges may apply.';
        $medium_repayment = get_post_meta($post->ID, '_loan_medium_repayment', true) ?: '$117.67';
        $medium_table_amount = get_post_meta($post->ID, '_loan_medium_table_amount', true) ?: '$2,500';
        $medium_table_term = get_post_meta($post->ID, '_loan_medium_table_term', true) ?: '28 Weeks';
        $medium_table_fee = get_post_meta($post->ID, '_loan_medium_table_fee', true) ?: '$400';
        $medium_table_interest = get_post_meta($post->ID, '_loan_medium_table_interest', true) ?: '$394.74';
        $medium_table_total = get_post_meta($post->ID, '_loan_medium_table_total', true) ?: '$3,289';

        // Large Loan (NEW)
        $large_amount = get_post_meta($post->ID, '_loan_large_amount', true) ?: '$5,001 – $50,000';
        $large_term = get_post_meta($post->ID, '_loan_large_term', true) ?: '12 weeks – 60 months';
        $large_fees = get_post_meta($post->ID, '_loan_large_fees', true) ?: 'up to $990 establishment fee | Interest: up to 47.80% p.a| Other fees and charges may apply.';
        $large_repayment = get_post_meta($post->ID, '_loan_large_repayment', true) ?: '$250.00';
        $large_table_amount = get_post_meta($post->ID, '_loan_large_table_amount', true) ?: '$10,000';
        $large_table_term = get_post_meta($post->ID, '_loan_large_table_term', true) ?: '52 Weeks';
        $large_table_fee = get_post_meta($post->ID, '_loan_large_table_fee', true) ?: '$990';
        $large_table_interest = get_post_meta($post->ID, '_loan_large_table_interest', true) ?: '$2,145.00';
        $large_table_total = get_post_meta($post->ID, '_loan_large_table_total', true) ?: '$13,135';
        ?>
        <div class="flavor-accordion open">
            <div class="flavor-accordion-header">
                <span>💰 Loan Examples (Small / Medium / Large)</span>
                <span class="flavor-accordion-icon">▶</span>
            </div>
            <div class="flavor-accordion-content">
                <div class="flavor-stats-grid">
                    <!-- Small Loan -->
                    <div class="loan-tier-box small">
                        <label class="loan-tier-header"><?php esc_html_e('Small Loan', 'finance-theme'); ?></label>
                        
                        <div style="margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                            <label style="font-weight: 600;">Header Details</label>
                            <input type="text" name="loan_small_amount" value="<?php echo esc_attr($small_amount); ?>" placeholder="Loan Amount Range" style="margin-bottom: 5px; width: 100%;">
                            <input type="text" name="loan_small_term" value="<?php echo esc_attr($small_term); ?>" placeholder="Loan Term Range" style="margin-bottom: 5px; width: 100%;">
                            <textarea name="loan_small_fees" rows="2" placeholder="Fees Description" style="width: 100%;"><?php echo esc_textarea($small_fees); ?></textarea>
                        </div>

                        <div>
                            <label style="font-weight: 600;">Table Example Data</label>
                            <input type="text" name="loan_small_table_amount" value="<?php echo esc_attr($small_table_amount); ?>" placeholder="Example Amount ($1,000)" style="margin-bottom: 5px; width: 100%;">
                            <input type="text" name="loan_small_table_term" value="<?php echo esc_attr($small_table_term); ?>" placeholder="Example Term (28 weeks)" style="margin-bottom: 5px; width: 100%;">
                            <input type="text" name="loan_small_table_fee" value="<?php echo esc_attr($small_table_fee); ?>" placeholder="Est. Fee ($200)" style="margin-bottom: 5px; width: 100%;">
                            <input type="text" name="loan_small_table_monthly" value="<?php echo esc_attr($small_table_monthly); ?>" placeholder="Monthly Fee ($280)" style="margin-bottom: 5px; width: 100%;">
                            <input type="text" name="loan_small_table_total" value="<?php echo esc_attr($small_table_total); ?>" placeholder="Total Repayable ($1,480)" style="margin-bottom: 5px; width: 100%;">
                            <hr style="margin: 10px 0;">
                            <label>Weekly Repayment:</label>
                            <input type="text" name="loan_small_repayment" value="<?php echo esc_attr($small_repayment); ?>" placeholder="$70.00" style="width: 100%;">
                        </div>
                    </div>

                    <!-- Medium Loan -->
                    <div class="loan-tier-box medium">
                        <label class="loan-tier-header"><?php esc_html_e('Medium Loan', 'finance-theme'); ?></label>

                        <div style="margin-bottom: 15px; border-bottom: 1px solid #a5d6a7; padding-bottom: 10px;">
                            <label style="font-weight: 600;">Header Details</label>
                            <input type="text" name="loan_medium_amount" value="<?php echo esc_attr($medium_amount); ?>" placeholder="Loan Amount Range" style="margin-bottom: 5px; width: 100%;">
                            <input type="text" name="loan_medium_term" value="<?php echo esc_attr($medium_term); ?>" placeholder="Loan Term Range" style="margin-bottom: 5px; width: 100%;">
                            <textarea name="loan_medium_fees" rows="2" placeholder="Fees Description" style="width: 100%;"><?php echo esc_textarea($medium_fees); ?></textarea>
                        </div>

                        <div>
                            <label style="font-weight: 600;">Table Example Data</label>
                            <input type="text" name="loan_medium_table_amount" value="<?php echo esc_attr($medium_table_amount); ?>" placeholder="Example Amount ($2,500)" style="margin-bottom: 5px; width: 100%;">
                            <input type="text" name="loan_medium_table_term" value="<?php echo esc_attr($medium_table_term); ?>" placeholder="Example Term (28 Weeks)" style="margin-bottom: 5px; width: 100%;">
                            <input type="text" name="loan_medium_table_fee" value="<?php echo esc_attr($medium_table_fee); ?>" placeholder="Est. Fee ($400)" style="margin-bottom: 5px; width: 100%;">
                            <input type="text" name="loan_medium_table_interest" value="<?php echo esc_attr($medium_table_interest); ?>" placeholder="Total Interest ($394.74)" style="margin-bottom: 5px; width: 100%;">
                            <input type="text" name="loan_medium_table_total" value="<?php echo esc_attr($medium_table_total); ?>" placeholder="Total Repayable ($3,289)" style="margin-bottom: 5px; width: 100%;">
                            <hr style="margin: 10px 0; border-color: #a5d6a7;">
                            <label>Weekly Repayment:</label>
                            <input type="text" name="loan_medium_repayment" value="<?php echo esc_attr($medium_repayment); ?>" placeholder="$117.67" style="width: 100%;">
                        </div>
                    </div>

                    <!-- Large Loan (NEW) -->
                    <div class="loan-tier-box large">
                        <label class="loan-tier-header"><?php esc_html_e('Large Loan', 'finance-theme'); ?> <span style="color: #2196f3;">(NEW)</span></label>

                        <div style="margin-bottom: 15px; border-bottom: 1px solid #90caf9; padding-bottom: 10px;">
                            <label style="font-weight: 600;">Header Details</label>
                            <input type="text" name="loan_large_amount" value="<?php echo esc_attr($large_amount); ?>" placeholder="Loan Amount Range" style="margin-bottom: 5px; width: 100%;">
                            <input type="text" name="loan_large_term" value="<?php echo esc_attr($large_term); ?>" placeholder="Loan Term Range" style="margin-bottom: 5px; width: 100%;">
                            <textarea name="loan_large_fees" rows="2" placeholder="Fees Description" style="width: 100%;"><?php echo esc_textarea($large_fees); ?></textarea>
                        </div>

                        <div>
                            <label style="font-weight: 600;">Table Example Data</label>
                            <input type="text" name="loan_large_table_amount" value="<?php echo esc_attr($large_table_amount); ?>" placeholder="Example Amount ($10,000)" style="margin-bottom: 5px; width: 100%;">
                            <input type="text" name="loan_large_table_term" value="<?php echo esc_attr($large_table_term); ?>" placeholder="Example Term (52 Weeks)" style="margin-bottom: 5px; width: 100%;">
                            <input type="text" name="loan_large_table_fee" value="<?php echo esc_attr($large_table_fee); ?>" placeholder="Est. Fee ($990)" style="margin-bottom: 5px; width: 100%;">
                            <input type="text" name="loan_large_table_interest" value="<?php echo esc_attr($large_table_interest); ?>" placeholder="Total Interest ($2,145)" style="margin-bottom: 5px; width: 100%;">
                            <input type="text" name="loan_large_table_total" value="<?php echo esc_attr($large_table_total); ?>" placeholder="Total Repayable ($13,135)" style="margin-bottom: 5px; width: 100%;">
                            <hr style="margin: 10px 0; border-color: #90caf9;">
                            <label>Weekly Repayment:</label>
                            <input type="text" name="loan_large_repayment" value="<?php echo esc_attr($large_repayment); ?>" placeholder="$250.00" style="width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Render Testimonials & FAQs Section Options
     */

    /**
     * Render Section Order & Visibility
     */
    private function render_section_order($post)
    {
        $section_order = get_post_meta($post->ID, '_section_order', true);
        if (empty($section_order)) {
            $section_order = [
                'why_choose' => ['enabled' => 1, 'order' => 1],
                'main_content' => ['enabled' => 1, 'order' => 2],
                'eligibility' => ['enabled' => 1, 'order' => 3],
                'how_to_apply' => ['enabled' => 1, 'order' => 4],
                'loan_examples' => ['enabled' => 1, 'order' => 5],
                'testimonials' => ['enabled' => 1, 'order' => 6],
                'faqs' => ['enabled' => 1, 'order' => 7],
            ];
        }
        ?>
        <div class="flavor-accordion">
            <div class="flavor-accordion-header">
                <span>🔀 Section Order & Visibility</span>
                <span class="flavor-accordion-icon">▶</span>
            </div>
            <div class="flavor-accordion-content">
                <p class="description" style="margin-bottom: 15px; background: #fff3cd; padding: 10px; border-radius: 4px; border-left: 3px solid #ffc107;">
                    <?php esc_html_e('Control which sections appear and in what order. Lower numbers appear first.', 'finance-theme'); ?>
                </p>

                <table class="form-table" style="width: 100%; max-width: 600px;">
                    <thead>
                        <tr>
                            <th style="width: 50%;">Section</th>
                            <th style="width: 25%;">Show?</th>
                            <th style="width: 25%;">Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Why Choose This Loan</strong></td>
                            <td>
                                <input type="checkbox" name="section_order[why_choose][enabled]" value="1" <?php checked($section_order['why_choose']['enabled'] ?? 1, 1); ?>>
                            </td>
                            <td>
                                <input type="number" name="section_order[why_choose][order]" value="<?php echo esc_attr($section_order['why_choose']['order'] ?? 1); ?>" min="1" max="10" style="width: 60px;">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Main Content</strong> <small>(post editor)</small></td>
                            <td>
                                <input type="checkbox" name="section_order[main_content][enabled]" value="1" <?php checked($section_order['main_content']['enabled'] ?? 1, 1); ?>>
                            </td>
                            <td>
                                <input type="number" name="section_order[main_content][order]" value="<?php echo esc_attr($section_order['main_content']['order'] ?? 2); ?>" min="1" max="10" style="width: 60px;">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Eligibility</strong></td>
                            <td>
                                <input type="checkbox" name="section_order[eligibility][enabled]" value="1" <?php checked($section_order['eligibility']['enabled'] ?? 1, 1); ?>>
                            </td>
                            <td>
                                <input type="number" name="section_order[eligibility][order]" value="<?php echo esc_attr($section_order['eligibility']['order'] ?? 3); ?>" min="1" max="10" style="width: 60px;">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>How to Apply</strong></td>
                            <td>
                                <input type="checkbox" name="section_order[how_to_apply][enabled]" value="1" <?php checked($section_order['how_to_apply']['enabled'] ?? 1, 1); ?>>
                            </td>
                            <td>
                                <input type="number" name="section_order[how_to_apply][order]" value="<?php echo esc_attr($section_order['how_to_apply']['order'] ?? 4); ?>" min="1" max="10" style="width: 60px;">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Loan Examples</strong> <small>(comparison)</small></td>
                            <td>
                                <input type="checkbox" name="section_order[loan_examples][enabled]" value="1" <?php checked($section_order['loan_examples']['enabled'] ?? 1, 1); ?>>
                            </td>
                            <td>
                                <input type="number" name="section_order[loan_examples][order]" value="<?php echo esc_attr($section_order['loan_examples']['order'] ?? 5); ?>" min="1" max="10" style="width: 60px;">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Testimonials</strong></td>
                            <td>
                                <input type="checkbox" name="section_order[testimonials][enabled]" value="1" <?php checked($section_order['testimonials']['enabled'] ?? 1, 1); ?>>
                            </td>
                            <td>
                                <input type="number" name="section_order[testimonials][order]" value="<?php echo esc_attr($section_order['testimonials']['order'] ?? 6); ?>" min="1" max="10" style="width: 60px;">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>FAQs</strong></td>
                            <td>
                                <input type="checkbox" name="section_order[faqs][enabled]" value="1" <?php checked($section_order['faqs']['enabled'] ?? 1, 1); ?>>
                            </td>
                            <td>
                                <input type="number" name="section_order[faqs][order]" value="<?php echo esc_attr($section_order['faqs']['order'] ?? 7); ?>" min="1" max="10" style="width: 60px;">
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p class="description" style="margin-top: 15px;">
                    <?php esc_html_e('💡 Tip: Set Order 1 for first section, Order 2 for second, etc. Uncheck "Show?" to hide a section completely.', 'finance-theme'); ?>
                </p>
            </div>
        </div>
        <?php
    }

    /**
     * Render Testimonials & FAQs Section
     */
    private function render_testimonials_faqs($post)
    {
        $testimonials_heading = get_post_meta($post->ID, '_testimonials_heading', true) ?: 'What Our Customers Say';
        $testimonials_description = get_post_meta($post->ID, '_testimonials_description', true) ?: 'Don\'t just take our word for it - hear from real customers who got a fair go.';
        $faqs_heading = get_post_meta($post->ID, '_faqs_heading', true) ?: 'Frequently Asked Questions';
        ?>
        <div class="flavor-accordion">
            <div class="flavor-accordion-header">
                <span>💬 Testimonials & FAQs</span>
                <span class="flavor-accordion-icon">▶</span>
            </div>
            <div class="flavor-accordion-content">
                <h4>Testimonials Section</h4>
                <div class="flavor-form-row">
                    <label for="testimonials_heading"><?php esc_html_e('Section Heading', 'finance-theme'); ?></label>
                    <input type="text" id="testimonials_heading" name="testimonials_heading" value="<?php echo esc_attr($testimonials_heading); ?>">
                </div>

                <div class="flavor-form-row">
                    <label for="testimonials_description"><?php esc_html_e('Description', 'finance-theme'); ?></label>
                    <input type="text" id="testimonials_description" name="testimonials_description" value="<?php echo esc_attr($testimonials_description); ?>">
                </div>

                <hr style="margin: 20px 0;">

                <h4>FAQs Section</h4>
                <div class="flavor-form-row">
                    <label for="faqs_heading"><?php esc_html_e('Section Heading', 'finance-theme'); ?></label>
                    <input type="text" id="faqs_heading" name="faqs_heading" value="<?php echo esc_attr($faqs_heading); ?>">
                </div>

                <p class="description"><?php esc_html_e('FAQs themselves are managed in the FAQs post type.', 'finance-theme'); ?></p>
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

        // List of all fields to save
        $fields = [
            // Basic settings
            'loan_subtitle',
            'loan_amount',
            'loan_term',
            'loan_color',
            'loan_icon',

            // Hero section (NEW: flexible textarea)
            'hero_features',
            'calculator_heading',
            'calculator_button',
            'calculator_note',

            // Features Row (NEW)
            'features_row_1_title',
            'features_row_1_desc',
            'features_row_2_title',
            'features_row_2_desc',
            'features_row_3_title',
            'features_row_3_desc',

            // Why Choose section
            'why_heading_template',
            'why_description',
            'why_feature_1_title',
            'why_feature_1_desc',
            'why_feature_2_title',
            'why_feature_2_desc',
            'why_feature_3_title',
            'why_feature_3_desc',

            // Eligibility section (NEW: flexible textarea)
            'eligibility_heading',
            'eligibility_intro',
            'eligibility_subtitle',
            'eligibility_requirements',
            'eligibility_note',

            // How to Apply section
            'apply_heading',
            'apply_description',
            'apply_button',
            'apply_step_1_title',
            'apply_step_1_desc',
            'apply_step_2_title',
            'apply_step_2_desc',
            'apply_step_3_title',
            'apply_step_3_desc',
            'apply_step_4_title',
            'apply_step_4_desc',

            // Comparison section (NEW: flexible textarea + hide option)
            'comparison_heading',
            'phone_benefits',

            // Small Loan Example
            'loan_small_amount',
            'loan_small_term',
            'loan_small_fees',
            'loan_small_repayment',
            'loan_small_table_amount',
            'loan_small_table_term',
            'loan_small_table_fee',
            'loan_small_table_monthly',
            'loan_small_table_total',

            // Medium Loan Example
            'loan_medium_amount',
            'loan_medium_term',
            'loan_medium_fees',
            'loan_medium_repayment',
            'loan_medium_table_amount',
            'loan_medium_table_term',
            'loan_medium_table_fee',
            'loan_medium_table_interest',
            'loan_medium_table_total',

            // Large Loan Example (NEW)
            'loan_large_amount',
            'loan_large_term',
            'loan_large_fees',
            'loan_large_repayment',
            'loan_large_table_amount',
            'loan_large_table_term',
            'loan_large_table_fee',
            'loan_large_table_interest',
            'loan_large_table_total',

            // Testimonials & FAQs
            'testimonials_heading',
            'testimonials_description',
            'faqs_heading',
        ];


        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                // Use appropriate sanitization
                if (strpos($field, '_desc') !== false || $field === 'loan_small_fees' || $field === 'loan_medium_fees' || $field === 'loan_large_fees' || $field === 'why_description' || $field === 'eligibility_intro' || $field === 'eligibility_note' || $field === 'hero_features' || $field === 'eligibility_requirements' || $field === 'phone_benefits') {
                    $value = sanitize_textarea_field($_POST[$field]);
                } else {
                    $value = sanitize_text_field($_POST[$field]);
                }
                update_post_meta($post_id, '_' . $field, $value);
            }
        }

        // Handle checkbox separately
        $hide_phone_mockup = isset($_POST['hide_phone_mockup']) ? '1' : '';
        update_post_meta($post_id, '_hide_phone_mockup', $hide_phone_mockup);

        // Handle section order (complex array)
        if (isset($_POST['section_order']) && is_array($_POST['section_order'])) {
            $section_order = [];
            foreach ($_POST['section_order'] as $section_key => $section_data) {
                $section_order[sanitize_key($section_key)] = [
                    'enabled' => isset($section_data['enabled']) ? 1 : 0,
                    'order' => absint($section_data['order'] ?? 1)
                ];
            }
            update_post_meta($post_id, '_section_order', $section_order);
        }
    }
}

// Initialize
new Flavor_Loan_Metaboxes();
