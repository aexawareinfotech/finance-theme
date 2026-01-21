<?php
/**
 * Post Template: Single Loan Type
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()):
    the_post();
    $post_id = get_the_ID();

    // Get ALL dynamic meta values with defaults
    $subtitle = get_post_meta($post_id, '_loan_subtitle', true);
    if (empty($subtitle)) {
        $subtitle = get_the_excerpt();
    }

    // Hero section - Parse textarea into array
    $hero_features_text = get_post_meta($post_id, '_hero_features', true);
    if (empty($hero_features_text)) {
        // Fallback to old format or defaults
        $hero_features = [
            get_post_meta($post_id, '_hero_feature_1', true) ?: 'Borrow from $2,000 to $50,000',
            get_post_meta($post_id, '_hero_feature_2', true) ?: 'Digital & Paperless Journey',
            get_post_meta($post_id, '_hero_feature_3', true) ?: 'Proudly Australian Lender',
            get_post_meta($post_id, '_hero_feature_4', true) ?: 'Instant Decisions and Same-Day Cash',
        ];
    } else {
        $hero_features = array_filter(array_map('trim', explode("\n", $hero_features_text)));
    }
    $calculator_heading = get_post_meta($post_id, '_calculator_heading', true) ?: "I'd like to borrow";
    $calculator_button = get_post_meta($post_id, '_calculator_button', true) ?: 'Apply Now';
    $calculator_note = get_post_meta($post_id, '_calculator_note', true) ?: 'Online application in minutes!';

    // Why Choose section
    $why_heading_template = get_post_meta($post_id, '_why_heading_template', true) ?: 'Why Choose a %s';
    $why_description = get_post_meta($post_id, '_why_description', true);
    if (empty($why_description)) {
        $why_description = $subtitle;
    }
    
    $why_features = [
        [
            'title' => get_post_meta($post_id, '_why_feature_1_title', true) ?: 'Cash in as little as 60 minutes',
            'desc' => get_post_meta($post_id, '_why_feature_1_desc', true) ?: 'Apply online and, if approved before 4:30 pm on a banking day, you could have the cash in your account in just 60 minutes.*'
        ],
        [
            'title' => get_post_meta($post_id, '_why_feature_2_title', true) ?: '100% online, zero paperwork',
            'desc' => get_post_meta($post_id, '_why_feature_2_desc', true) ?: 'No queues, no printers, no problem. Our fast online process keeps things simple, smart, and hassle-free.'
        ],
        [
            'title' => get_post_meta($post_id, '_why_feature_3_title', true) ?: 'Real support, real fast',
            'desc' => get_post_meta($post_id, '_why_feature_3_desc', true) ?: 'Need help choosing the right repayment plan? Our Aussie-based team is here with real answers and is always happy to help.'
        ]
    ];

    // Eligibility section - Parse textarea into array
    $eligibility_heading = get_post_meta($post_id, '_eligibility_heading', true) ?: 'Eligibility';
    $eligibility_intro = get_post_meta($post_id, '_eligibility_intro', true) ?: 'As a responsible lender, our priority is ensuring your loan is affordable and suitable for your specific needs.';
    $eligibility_subtitle = get_post_meta($post_id, '_eligibility_subtitle', true) ?: 'To be eligible, you must:';
    
    $eligibility_requirements_text = get_post_meta($post_id, '_eligibility_requirements', true);
    if (empty($eligibility_requirements_text)) {
        // Fallback to old format or defaults
        $eligibility_requirements = [
            get_post_meta($post_id, '_eligibility_req_1', true) ?: 'Receive a regular income',
            get_post_meta($post_id, '_eligibility_req_2', true) ?: 'Be an Australian resident',
            get_post_meta($post_id, '_eligibility_req_3', true) ?: 'Be at least 18 years old or over'
        ];
    } else {
        $eligibility_requirements = array_filter(array_map('trim', explode("\n", $eligibility_requirements_text)));
    }
    
    $eligibility_note = get_post_meta($post_id, '_eligibility_note', true) ?: ' can benefit from a faster borrowing process. As your trust rating improves, you may borrow more money with any subsequent loan - as long as you meet loan payments, the loan meets your requirements and objectives and repay your loan in full, on time and can afford the higher amount.';

    // How to Apply section
    $apply_heading = get_post_meta($post_id, '_apply_heading', true) ?: 'How do I apply for a loan with Fair Go?';
    $apply_description = get_post_meta($post_id, '_apply_description', true) ?: 'Applying for a %s is as simple as 4 easy steps.';
    $apply_button = get_post_meta($post_id, '_apply_button', true) ?: 'Apply now';
    
    $apply_steps = [
        [
            'title' => get_post_meta($post_id, '_apply_step_1_title', true) ?: 'Apply in minutes',
            'desc' => get_post_meta($post_id, '_apply_step_1_desc', true) ?: 'You can apply online anywhere, at any time. All you have to do is answer some simple questions and provide 90 day bank statements.'
        ],
        [
            'title' => get_post_meta($post_id, '_apply_step_2_title', true) ?: 'Get your loan offer',
            'desc' => get_post_meta($post_id, '_apply_step_2_desc', true) ?: 'Get a conditional loan offer immediately* which outlines the terms of your loan while you wait for final approval.'
        ],
        [
            'title' => get_post_meta($post_id, '_apply_step_3_title', true) ?: 'Receive your loan approval',
            'desc' => get_post_meta($post_id, '_apply_step_3_desc', true) ?: 'Our team is dedicated to balancing speed with responsible lending. We\'ll assess your application and let you know as soon as your loan is approved.*'
        ],
        [
            'title' => get_post_meta($post_id, '_apply_step_4_title', true) ?: 'Get your money',
            'desc' => get_post_meta($post_id, '_apply_step_4_desc', true) ?: 'Once your loan is approved, your emergency cash will be digitally transferred to your bank account within 30 minutes via NPP instant transfers.**'
        ]
    ];

    // Comparison section - Parse textarea into array
    $comparison_heading = get_post_meta($post_id, '_comparison_heading', true) ?: '%s Examples';
    $hide_phone_mockup = get_post_meta($post_id, '_hide_phone_mockup', true);
    // Hide phone by default if not explicitly set
    if ($hide_phone_mockup === '') {
        $hide_phone_mockup = '1'; // Hide by default
    }
    
    $phone_benefits_text = get_post_meta($post_id, '_phone_benefits', true);
    if (empty($phone_benefits_text)) {
        // Fallback to old format or defaults
        $phone_benefits = [
            get_post_meta($post_id, '_phone_benefit_1', true) ?: 'Borrow between $500 to $5,000',
            get_post_meta($post_id, '_phone_benefit_2', true) ?: 'Flexible payment terms',
            get_post_meta($post_id, '_phone_benefit_3', true) ?: 'No hidden fees - payout early to reduce total repayment',
            get_post_meta($post_id, '_phone_benefit_4', true) ?: 'Money in 60 minutes* of contract acceptance'
        ];
    } else {
        $phone_benefits = array_filter(array_map('trim', explode("\n", $phone_benefits_text)));
    }

    // Testimonials & FAQs
    $testimonials_heading = get_post_meta($post_id, '_testimonials_heading', true) ?: 'What Our Customers Say';
    $testimonials_description = get_post_meta($post_id, '_testimonials_description', true) ?: "Don't just take our word for it - hear from real customers who got a fair go.";
    $faqs_heading = get_post_meta($post_id, '_faqs_heading', true) ?: 'Frequently Asked Questions';

    // Section Visibility Settings
    $section_order = get_post_meta($post_id, '_section_order', true);
    if (empty($section_order)) {
        // Default: all sections visible
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
    
    // Helper function to check if section is visible
    $is_section_visible = function($section_key) use ($section_order) {
        return !empty($section_order[$section_key]['enabled']);
    };

    ?>

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="container">
            <div class="hero-grid">
                <!-- Left Content -->
                <div class="hero-left">
                    <h1 class="hero-title">
                        <?php echo esc_html(get_the_title()); ?>
                    </h1>
                    <p class="hero-subtitle">
                        <?php echo esc_html($subtitle); ?>
                    </p>

                </div>

                <!-- Right Calculator Card -->
                <div class="hero-right">
                    <div class="calculator-card">
                        <h3 class="calculator-title"><?php echo esc_html($calculator_heading); ?></h3>

                        <div class="calculator-amount" id="loan-amount-display">$5,000</div>

                        <div class="calculator-slider-wrap">
                            <input type="range" id="loan-amount-slider" class="calculator-slider" min="2000" max="50000"
                                step="500" value="5000">
                            <div class="slider-labels">
                                <span>$2,000</span>
                                <span>$50,000</span>
                            </div>
                        </div>

                        <a href="<?php echo esc_url(add_query_arg('loan_type', get_post_field('post_name', get_post()), home_url('/apply'))); ?>"
                            class="btn btn-primary btn-block">
                            <?php echo esc_html($calculator_button); ?>
                        </a>
                    </div>

                    <p class="hero-note"><?php echo esc_html($calculator_note); ?></p>
                </div>

                <!-- Hero Features (Moved for mobile layout) -->
                <ul class="hero-features">
                    <?php foreach ($hero_features as $feature): ?>
                        <li>
                            <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                            <span><?php echo esc_html($feature); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <?php
    // Features Row (Site-wide benefits)
    get_template_part('template-parts/features-row');
    ?>

    <!-- Why Choose This Loan Section -->
    <?php if ($is_section_visible('why_choose')): ?>
    <section class="section why-choose-loan-section">
        <div class="container">
            <div class="why-choose-loan-grid">
                <div class="why-choose-image">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('large', ['style' => 'width: 100%; height: auto; display: block;']); ?>
                    <?php else: ?>
                        <img src="https://www.shutterstock.com/shutterstock/videos/3718668489/thumb/1.jpg?ip=x480"
                            alt="<?php echo esc_attr(get_the_title()); ?>" style="width: 100%; height: auto; display: block;">
                    <?php endif; ?>
                </div>
                <div class="why-choose-content">
                    <h2>
                        <?php printf(esc_html($why_heading_template), get_the_title()); ?>
                    </h2>
                    <p>
                        <?php echo esc_html($why_description); ?>
                    </p>

                    <div class="why-choose-features">
                        <?php foreach ($why_features as $feature): ?>
                            <div class="why-feature-item">
                                <div class="why-feature-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <path d="M12 6v6l4 2" />
                                    </svg>
                                </div>
                                <div>
                                    <h4>
                                        <?php echo esc_html($feature['title']); ?>
                                    </h4>
                                    <p>
                                        <?php echo esc_html($feature['desc']); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>



    <!-- Main Content -->
    <?php if ($is_section_visible('main_content')): ?>
    <section class="section loan-content-section" style="padding-top: var(--space-12);">
        <div class="container" style="max-width: 900px;">
            <div class="entry-content" style="font-size: var(--text-lg); line-height: 1.8;">
                <?php the_content(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Eligibility Section -->
    <?php if ($is_section_visible('eligibility')): ?>
    <section class="section eligibility-section" style="background: #fff;">
        <div class="container">
            <div class="eligibility-grid">
                <!-- Image first for mobile (will be on right on desktop) -->
                <div class="eligibility-image" style="border-radius: var(--radius-2xl); overflow: hidden;">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/eligibility.jpg'); ?>"
                        alt="<?php esc_attr_e('Eligibility', 'finance-theme'); ?>"
                        style="width: 100%; height: auto; display: block;">
                </div>
                <div class="eligibility-content">
                    <h2
                        style="font-size: var(--text-3xl); font-weight: 700; color: var(--primary-900); margin-bottom: var(--space-4); text-decoration: underline; text-decoration-color: var(--accent-500); text-underline-offset: 8px;">
                        <?php echo esc_html($eligibility_heading); ?>
                    </h2>
                    <p style="color: var(--primary-700); margin-bottom: var(--space-6); font-size: var(--text-lg);">
                        <?php echo esc_html($eligibility_intro); ?>
                    </p>
                    <p style="font-weight: 600; color: var(--primary-900); margin-bottom: var(--space-4);">
                        <?php echo esc_html($eligibility_subtitle); ?>
                    </p>
                    <ul style="list-style: none; padding: 0; margin-bottom: var(--space-6);">
                        <?php foreach ($eligibility_requirements as $requirement): ?>
                            <li style="display: flex; align-items: center; gap: var(--space-3); margin-bottom: var(--space-3);">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-500)"
                                    stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                <span>
                                    <?php echo esc_html($requirement); ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <p style="color: var(--primary-700); font-size: var(--text-sm); line-height: 1.6;">
                        <a href="<?php echo esc_url(home_url('/apply')); ?>"
                            style="color: var(--accent-600); font-weight: 600;">
                            <?php esc_html_e('Existing customers', 'finance-theme'); ?>
                        </a>
                        <?php echo esc_html($eligibility_note); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- How to Apply Section -->
    <?php if ($is_section_visible('how_to_apply')): ?>
    <section class="section how-to-apply-section" style="background: var(--gray-100);">
        <div class="container">
            <div class="how-to-apply-grid">
                <!-- Heading and Intro -->
                <div class="how-to-apply-intro">
                    <h2
                        style="font-size: var(--text-3xl); font-weight: 700; color: var(--primary-900); margin-bottom: var(--space-4);">
                        <?php echo esc_html($apply_heading); ?>
                    </h2>
                    <p style="color: var(--primary-700); margin-bottom: var(--space-6); font-size: var(--text-lg);">
                        <?php printf(esc_html($apply_description), get_the_title()); ?>
                    </p>
                    <a href="<?php echo esc_url(add_query_arg('loan_type', get_post_field('post_name', get_post()), home_url('/apply'))); ?>"
                        class="btn how-to-apply-btn"
                        style="display: inline-block; border: 1px solid var(--primary-400); background: transparent; color: var(--primary-900); padding: var(--space-3) var(--space-8); border-radius: var(--radius-md); text-decoration: none; font-weight: 500;">
                        <?php echo esc_html($apply_button); ?>
                    </a>
                </div>
                <div class="how-to-apply-steps" style="display: flex; flex-direction: column; gap: 0; position: relative;">
                    <?php foreach ($apply_steps as $index => $step): ?>
                        <div class="apply-step"
                            style="display: flex; gap: var(--space-5); align-items: flex-start; position: relative; <?php echo $index < 3 ? 'padding-bottom: var(--space-8);' : ''; ?>">
                            <?php if ($index < 3): ?>
                                <!-- Line connector -->
                                <div
                                    style="position: absolute; left: 19px; top: 40px; bottom: 0; width: 2px; background: var(--gray-300);">
                                </div>
                            <?php endif; ?>
                            <div class="step-number"
                                style="width: 40px; height: 40px; background: var(--accent-500); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; flex-shrink: 0; position: relative; z-index: 1;">
                                <?php echo ($index + 1); ?></div>
                            <div>
                                <h4
                                    style="font-size: var(--text-lg); font-weight: 600; color: var(--primary-900); margin-bottom: var(--space-2);">
                                    <?php echo esc_html($step['title']); ?>
                                </h4>
                                <p style="color: var(--primary-700); line-height: 1.6;">
                                    <?php echo esc_html($step['desc']); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Loan Comparison Section -->
    <?php if ($is_section_visible('loan_examples')): ?>
    <section class="section comparison-section" id="loan-examples">
        <div class="container">
            <h2 class="comparison-title">
                <?php printf(esc_html($comparison_heading), get_the_title()); ?><sup>2</sup>
            </h2>

            <!-- Loan Tables Only -->
            <div class="comparison-tables">

                <?php
                // Get dynamic values for tables
                // Small Loan
                $small_amount = get_post_meta($post_id, '_loan_small_amount', true) ?: '$500 – $2,000';
                $small_term = get_post_meta($post_id, '_loan_small_term', true) ?: '16 days – 12 months';
                $small_fees = get_post_meta($post_id, '_loan_small_fees', true) ?: '20% establishment + 4% monthly (flat) | Other fees and charges may apply.';
                $small_repayment = get_post_meta($post_id, '_loan_small_repayment', true) ?: '$70.00';

                $small_table_amount = get_post_meta($post_id, '_loan_small_table_amount', true) ?: '$1,000';
                $small_table_term = get_post_meta($post_id, '_loan_small_table_term', true) ?: '28 weeks';
                $small_table_fee = get_post_meta($post_id, '_loan_small_table_fee', true) ?: '$200';
                $small_table_monthly = get_post_meta($post_id, '_loan_small_table_monthly', true) ?: '$280';
                $small_table_total = get_post_meta($post_id, '_loan_small_table_total', true) ?: '$1,480';

                // Medium Loan
                $medium_amount = get_post_meta($post_id, '_loan_medium_amount', true) ?: '$2,001 – $5,000';
                $medium_term = get_post_meta($post_id, '_loan_medium_term', true) ?: '9 weeks – 24 months';
                $medium_fees = get_post_meta($post_id, '_loan_medium_fees', true) ?: 'up to $400 establishment fee | Interest: up to 47.80% p.a| Other fees and charges may apply.';
                $medium_repayment = get_post_meta($post_id, '_loan_medium_repayment', true) ?: '$117.67';

                $medium_table_amount = get_post_meta($post_id, '_loan_medium_table_amount', true) ?: '$2,500';
                $medium_table_term = get_post_meta($post_id, '_loan_medium_table_term', true) ?: '28 Weeks';
                $medium_table_fee = get_post_meta($post_id, '_loan_medium_table_fee', true) ?: '$400';
                $medium_table_interest = get_post_meta($post_id, '_loan_medium_table_interest', true) ?: '$394.74';
                $medium_table_total = get_post_meta($post_id, '_loan_medium_table_total', true) ?: '$3,289';

                // Large Loan (NEW)
                $large_amount = get_post_meta($post_id, '_loan_large_amount', true) ?: '$5,001 – $50,000';
                $large_term = get_post_meta($post_id, '_loan_large_term', true) ?: '12 weeks – 60 months';
                $large_fees = get_post_meta($post_id, '_loan_large_fees', true) ?: 'up to $990 establishment fee | Interest: up to 47.80% p.a| Other fees and charges may apply.';
                $large_repayment = get_post_meta($post_id, '_loan_large_repayment', true) ?: '$250.00';

                $large_table_amount = get_post_meta($post_id, '_loan_large_table_amount', true) ?: '$10,000';
                $large_table_term = get_post_meta($post_id, '_loan_large_table_term', true) ?: '52 Weeks';
                $large_table_fee = get_post_meta($post_id, '_loan_large_table_fee', true) ?: '$990';
                $large_table_interest = get_post_meta($post_id, '_loan_large_table_interest', true) ?: '$2,145.00';
                $large_table_total = get_post_meta($post_id, '_loan_large_table_total', true) ?: '$13,135';
                ?>

                <!-- Small Loan -->
                    <div class="loan-table">
                        <div class="loan-table-header loan-table-header-small">
                            <h4><?php esc_html_e('Small Loan', 'finance-theme'); ?></h4>
                            <p><?php printf(
                                esc_html__('Loan amount: %s | Loan term: %s | Fees: %s', 'finance-theme'),
                                esc_html($small_amount),
                                esc_html($small_term),
                                esc_html($small_fees)
                            ); ?>
                            </p>
                        </div>
                        <div class="loan-table-body">
                            <h5><?php esc_html_e('Example', 'finance-theme'); ?></h5>
                            <table>
                                <tr>
                                    <td><?php esc_html_e('Repayments', 'finance-theme'); ?></td>
                                    <td><strong><?php esc_html_e('Weekly', 'finance-theme'); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e('Loan Amount', 'finance-theme'); ?></td>
                                    <td><strong><?php echo esc_html($small_table_amount); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e('Term', 'finance-theme'); ?></td>
                                    <td><strong><?php echo esc_html($small_table_term); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e('Establishment fee', 'finance-theme'); ?></td>
                                    <td><strong><?php echo esc_html($small_table_fee); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e('Total monthly fee (over 28 weeks)', 'finance-theme'); ?></td>
                                    <td><strong><?php echo esc_html($small_table_monthly); ?></strong></td>
                                </tr>
                                <tr class="total-row">
                                    <td><?php esc_html_e('Total repayable', 'finance-theme'); ?></td>
                                    <td><strong><?php echo esc_html($small_table_total); ?></strong></td>
                                </tr>
                            </table>
                            <div class="weekly-repayment weekly-repayment-small">
                                <span><?php esc_html_e('Weekly repayment', 'finance-theme'); ?></span>
                                <strong><?php echo esc_html($small_repayment); ?></strong>
                            </div>
                        </div>
                    </div>

                    <!-- Medium Loan -->
                    <div class="loan-table">
                        <div class="loan-table-header loan-table-header-medium">
                            <h4><?php esc_html_e('Medium Loan', 'finance-theme'); ?></h4>
                            <p><?php printf(
                                esc_html__('Loan amount: %s | Loan term: %s | Fees: %s', 'finance-theme'),
                                esc_html($medium_amount),
                                esc_html($medium_term),
                                esc_html($medium_fees)
                            ); ?>
                            </p>
                        </div>
                        <div class="loan-table-body">
                            <h5><?php esc_html_e('Example', 'finance-theme'); ?></h5>
                            <table>
                                <tr>
                                    <td><?php esc_html_e('Repayments', 'finance-theme'); ?></td>
                                    <td><strong><?php esc_html_e('Weekly', 'finance-theme'); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e('Loan Amount', 'finance-theme'); ?></td>
                                    <td><strong><?php echo esc_html($medium_table_amount); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e('Term', 'finance-theme'); ?></td>
                                    <td><strong><?php echo esc_html($medium_table_term); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e('Establishment fee', 'finance-theme'); ?></td>
                                    <td><strong><?php echo esc_html($medium_table_fee); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e('Total interest (over 28 weeks)', 'finance-theme'); ?></td>
                                    <td><strong><?php echo esc_html($medium_table_interest); ?></strong></td>
                                </tr>
                                <tr class="total-row">
                                    <td><?php esc_html_e('Total repayable', 'finance-theme'); ?></td>
                                    <td><strong><?php echo esc_html($medium_table_total); ?></strong></td>
                                </tr>
                            </table>
                            <div class="weekly-repayment weekly-repayment-medium">
                                <span><?php esc_html_e('Weekly repayment', 'finance-theme'); ?></span>
                                <strong><?php echo esc_html($medium_repayment); ?></strong>
                            </div>
                        </div>
                    </div>

                    <!-- Large Loan (NEW) -->
                    <div class="loan-table">
                        <div class="loan-table-header loan-table-header-large">
                            <h4><?php esc_html_e('Large Loan', 'finance-theme'); ?></h4>
                            <p><?php printf(
                                esc_html__('Loan amount: %s | Loan term: %s | Fees: %s', 'finance-theme'),
                                esc_html($large_amount),
                                esc_html($large_term),
                                esc_html($large_fees)
                            ); ?>
                            </p>
                        </div>
                        <div class="loan-table-body">
                            <h5><?php esc_html_e('Example', 'finance-theme'); ?></h5>
                            <table>
                                <tr>
                                    <td><?php esc_html_e('Repayments', 'finance-theme'); ?></td>
                                    <td><strong><?php esc_html_e('Weekly', 'finance-theme'); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e('Loan Amount', 'finance-theme'); ?></td>
                                    <td><strong><?php echo esc_html($large_table_amount); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e('Term', 'finance-theme'); ?></td>
                                    <td><strong><?php echo esc_html($large_table_term); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e('Establishment fee', 'finance-theme'); ?></td>
                                    <td><strong><?php echo esc_html($large_table_fee); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e('Total interest', 'finance-theme'); ?></td>
                                    <td><strong><?php echo esc_html($large_table_interest); ?></strong></td>
                                </tr>
                                <tr class="total-row">
                                    <td><?php esc_html_e('Total repayable', 'finance-theme'); ?></td>
                                    <td><strong><?php echo esc_html($large_table_total); ?></strong></td>
                                </tr>
                            </table>
                            <div class="weekly-repayment weekly-repayment-large">
                                <span><?php esc_html_e('Weekly repayment', 'finance-theme'); ?></span>
                                <strong><?php echo esc_html($large_repayment); ?></strong>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Testimonials Section -->
    <?php if ($is_section_visible('testimonials')): ?>
    <section class="section testimonials-section" id="testimonials">
        <div class="container">
            <div class="section-header">
                <h2>
                    <?php echo esc_html($testimonials_heading); ?>
                </h2>
                <p>
                    <?php echo esc_html($testimonials_description); ?>
                </p>
            </div>

            <div class="testimonials-grid" id="testimonials-slider-track">
                <?php
                $testimonials = flavor_get_testimonials();
                foreach (array_slice($testimonials, 0, 6) as $testimonial): ?>
                    <div class="testimonial-card">
                        <?php echo flavor_render_stars($testimonial['rating']); ?>
                        <p class="testimonial-content">"
                            <?php echo esc_html($testimonial['content']); ?>"
                        </p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">
                                <?php echo esc_html(substr($testimonial['author'], 0, 1)); ?>
                            </div>
                            <div class="testimonial-info">
                                <h4>
                                    <?php echo esc_html($testimonial['author']); ?>
                                </h4>
                                <span>
                                    <?php echo esc_html($testimonial['loan_type']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="slider-nav">
                <button class="slider-btn slider-btn-prev" id="testimonials-prev"
                    aria-label="<?php esc_attr_e('Previous', 'finance-theme'); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M15 18l-6-6 6-6" />
                    </svg>
                </button>
                <div class="slider-progress">
                    <div class="slider-progress-bar" id="testimonials-progress"></div>
                </div>
                <button class="slider-btn slider-btn-next" id="testimonials-next"
                    aria-label="<?php esc_attr_e('Next', 'finance-theme'); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </button>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- FAQs Section -->
    <?php if ($is_section_visible('faqs')): ?>
    <section class="section faqs-section" style="background: #fff;">
        <div class="container" style="max-width: 800px;">
            <div class="section-header" style="text-align: center; margin-bottom: var(--space-10);">
                <h2 style="font-size: var(--text-3xl); font-weight: 700; color: var(--gray-900);">
                    <?php echo esc_html($faqs_heading); ?>
                </h2>
            </div>

            <?php
            // Fetch FAQs
            $faqs = get_posts([
                'post_type' => 'faq',
                'posts_per_page' => 5,
                'orderby' => 'menu_order',
                'order' => 'ASC',
            ]);

            if (!empty($faqs)):
                ?>
                <div class="faq-list" style="display: flex; flex-direction: column; gap: var(--space-4);">
                    <?php foreach ($faqs as $index => $faq): ?>
                        <div class="faq-item"
                            style="border: 1px solid var(--gray-200); border-radius: var(--radius-lg); overflow: hidden;">
                            <details>
                                <summary
                                    style="padding: var(--space-5); cursor: pointer; font-weight: 600; color: var(--gray-900); display: flex; justify-content: space-between; align-items: center; list-style: none;">
                                    <?php echo esc_html(get_the_title($faq)); ?>
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" style="flex-shrink: 0;">
                                        <polyline points="6 9 12 15 18 9" />
                                    </svg>
                                </summary>
                                <div style="padding: 0 var(--space-5) var(--space-5); color: var(--gray-600); line-height: 1.7;">
                                    <?php echo wp_kses_post(get_the_content(null, false, $faq)); ?>
                                </div>
                            </details>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Fallback FAQs -->
                <div class="faq-list" style="display: flex; flex-direction: column; gap: var(--space-4);">
                    <div class="faq-item"
                        style="border: 1px solid var(--gray-200); border-radius: var(--radius-lg); overflow: hidden;">
                        <details>
                            <summary
                                style="padding: var(--space-5); cursor: pointer; font-weight: 600; color: var(--gray-900); display: flex; justify-content: space-between; align-items: center; list-style: none;">
                                <?php esc_html_e('How quickly can I get my money?', 'finance-theme'); ?>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </summary>
                            <div style="padding: 0 var(--space-5) var(--space-5); color: var(--gray-600); line-height: 1.7;">
                                <?php esc_html_e('Once approved, funds can be transferred to your account within 60 minutes via NPP instant transfers during business hours.', 'finance-theme'); ?>
                            </div>
                        </details>
                    </div>
                    <div class="faq-item"
                        style="border: 1px solid var(--gray-200); border-radius: var(--radius-lg); overflow: hidden;">
                        <details>
                            <summary
                                style="padding: var(--space-5); cursor: pointer; font-weight: 600; color: var(--gray-900); display: flex; justify-content: space-between; align-items: center; list-style: none;">
                                <?php esc_html_e('What documents do I need to apply?', 'finance-theme'); ?>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </summary>
                            <div style="padding: 0 var(--space-5) var(--space-5); color: var(--gray-600); line-height: 1.7;">
                                <?php esc_html_e('You\'ll need 100 points of ID and access to your online banking so we can securely verify your income.', 'finance-theme'); ?>
                            </div>
                        </details>
                    </div>
                    <div class="faq-item"
                        style="border: 1px solid var(--gray-200); border-radius: var(--radius-lg); overflow: hidden;">
                        <details>
                            <summary
                                style="padding: var(--space-5); cursor: pointer; font-weight: 600; color: var(--gray-900); display: flex; justify-content: space-between; align-items: center; list-style: none;">
                                <?php esc_html_e('Can I pay off my loan early?', 'finance-theme'); ?>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </summary>
                            <div style="padding: 0 var(--space-5) var(--space-5); color: var(--gray-600); line-height: 1.7;">
                                <?php esc_html_e('Yes! You can pay off your loan early at any time with no early repayment penalties.', 'finance-theme'); ?>
                            </div>
                        </details>
                    </div>
                    <div class="faq-item"
                        style="border: 1px solid var(--gray-200); border-radius: var(--radius-lg); overflow: hidden;">
                        <details>
                            <summary
                                style="padding: var(--space-5); cursor: pointer; font-weight: 600; color: var(--gray-900); display: flex; justify-content: space-between; align-items: center; list-style: none;">
                                <?php esc_html_e('Will applying affect my credit score?', 'finance-theme'); ?>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </summary>
                            <div style="padding: 0 var(--space-5) var(--space-5); color: var(--gray-600); line-height: 1.7;">
                                <?php esc_html_e('We perform a credit check as part of our responsible lending assessment. This is a standard enquiry that all lenders make.', 'finance-theme'); ?>
                            </div>
                        </details>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>


    <?php
endwhile; // End of the loop.

get_footer();
?>