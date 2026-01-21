<?php
/**
 * Front Page Template
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Get data
$loan_types = flavor_get_loan_types();
$testimonials = flavor_get_testimonials();
$faqs = flavor_get_faqs();
$latest_posts = flavor_get_latest_posts(3);

// Get Customizer values for Hero
$hero_title = get_theme_mod('homepage_hero_title', 'Need');
$hero_title_accent = get_theme_mod('homepage_hero_title_accent', 'Money?');
$hero_subtitle = get_theme_mod('homepage_hero_subtitle', 'Get up to $50,000 paid within 60 min*');
$hero_features_raw = get_theme_mod('homepage_hero_features', "Borrow from \$2,000 to \$50,000\nDigital & Paperless Journey\nProudly Australian Lender\nInstant Decisions and Same-Day Cash");
$hero_features = array_filter(array_map('trim', explode("\n", $hero_features_raw)));
$calculator_heading = get_theme_mod('homepage_calculator_heading', "I'd like to borrow");
$calculator_min = get_theme_mod('homepage_calculator_min', 2000);
$calculator_max = get_theme_mod('homepage_calculator_max', 50000);
$calculator_button = get_theme_mod('homepage_calculator_button', 'Apply Now');
$calculator_note = get_theme_mod('homepage_calculator_note', 'Online application in minutes!');
?>

<!-- Hero Section -->
<section class="hero" id="hero">
    <div class="container">
        <div class="hero-grid">
            <!-- Left Content -->
            <div class="hero-left">
                <h1 class="hero-title">
                    <?php echo esc_html($hero_title); ?>
                    <span class="text-accent"><?php echo esc_html($hero_title_accent); ?></span>
                </h1>
                <p class="hero-subtitle">
                    <?php echo esc_html($hero_subtitle); ?>
                </p>

            </div>

            <!-- Right Calculator Card -->
            <div class="hero-right">
                <div class="calculator-card">
                    <h3 class="calculator-title"><?php echo esc_html($calculator_heading); ?></h3>

                    <div class="calculator-amount" id="loan-amount-display">$<?php echo number_format($calculator_min + (($calculator_max - $calculator_min) / 2)); ?></div>

                    <div class="calculator-slider-wrap">
                        <input type="range" id="loan-amount-slider" class="calculator-slider" min="<?php echo esc_attr($calculator_min); ?>" max="<?php echo esc_attr($calculator_max); ?>"
                            step="500" value="<?php echo esc_attr($calculator_min + (($calculator_max - $calculator_min) / 2)); ?>">
                        <div class="slider-labels">
                            <span>$<?php echo number_format($calculator_min); ?></span>
                            <span>$<?php echo number_format($calculator_max); ?></span>
                        </div>
                    </div>

                    <a href="<?php echo esc_url(home_url('/apply')); ?>" class="btn btn-primary btn-block">
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
// Loan Types Section customizer values
$loans_title = get_theme_mod('homepage_loans_title', "Online Loans for all Life's Moments");
$loans_button_text = get_theme_mod('homepage_loans_button_text', 'View All Personal Loans');
$loans_button_url = get_theme_mod('homepage_loans_button_url', '/loans');
?>

<!-- Loan Types Slider Section -->
<section class="section loan-types-section" id="loans">
    <div class="container">
        <div class="loan-types-header">
            <h2><?php echo esc_html($loans_title); ?></h2>
            <a href="<?php echo esc_url(home_url($loans_button_url)); ?>" class="btn btn-outline-dark">
                <?php echo esc_html($loans_button_text); ?>
            </a>
        </div>

        <div class="loan-types-slider" id="loan-slider">
            <div class="loan-types-track" id="loan-slider-track">
                <?php
                // Fetch dynamic loan types
                $loan_posts = get_posts([
                    'post_type' => 'loan_type',
                    'posts_per_page' => 12,
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                ]);

                if (!empty($loan_posts)):
                    foreach ($loan_posts as $loan_post):
                        $image = get_the_post_thumbnail_url($loan_post, 'medium') ?: get_template_directory_uri() . '/assets/images/loans/default.webp';
                        $loan_url = get_permalink($loan_post);
                        ?>
                        <a href="<?php echo esc_url($loan_url); ?>" class="loan-type-card">
                            <div class="loan-type-image">
                                <img src="<?php echo esc_url($image); ?>"
                                    alt="<?php echo esc_attr(get_the_title($loan_post)); ?>" loading="lazy">
                            </div>
                            <div class="loan-type-content">
                                <h3><?php echo esc_html(get_the_title($loan_post)); ?></h3>
                                <p><?php echo esc_html(get_the_excerpt($loan_post)); ?></p>
                            </div>
                        </a>
                    <?php endforeach;
                else:
                    // Fallback if no posts exist
                    $fallback_loans = [
                        ['title' => 'Emergency Loans', 'slug' => 'emergency-loans', 'description' => 'Get yourself unstuck and borrow up to $10,000 for emergencies.', 'image' => get_template_directory_uri() . '/assets/images/loans/emergency-loan.webp'],
                        ['title' => 'Wedding Loans', 'slug' => 'wedding-loans', 'description' => 'Spread the costs of your big day with a loan up to $10,000.', 'image' => get_template_directory_uri() . '/assets/images/loans/wedding.webp'],
                        ['title' => 'Education Loans', 'slug' => 'education-loans', 'description' => 'This smarter personal loan can help with all things related to studying.', 'image' => get_template_directory_uri() . '/assets/images/loans/education.webp'],
                    ];
                    foreach ($fallback_loans as $loan): ?>
                        <a href="<?php echo esc_url(home_url('/loan/' . $loan['slug'])); ?>" class="loan-type-card">
                            <div class="loan-type-image">
                                <img src="<?php echo esc_url($loan['image']); ?>" alt="<?php echo esc_attr($loan['title']); ?>"
                                    loading="lazy">
                            </div>
                            <div class="loan-type-content">
                                <h3><?php echo esc_html($loan['title']); ?></h3>
                                <p><?php echo esc_html($loan['description']); ?></p>
                            </div>
                        </a>
                    <?php endforeach;
                endif;
                ?>
            </div>
        </div>


        <div class="slider-nav">
            <button class="slider-btn slider-btn-prev" id="slider-prev"
                aria-label="<?php esc_attr_e('Previous', 'finance-theme'); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </button>
            <div class="slider-progress">
                <div class="slider-progress-bar" id="slider-progress"></div>
            </div>
            <button class="slider-btn slider-btn-next" id="slider-next"
                aria-label="<?php esc_attr_e('Next', 'finance-theme'); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </button>
        </div>
    </div>
</section>

<?php
// Process Section customizer values
$process_label = get_theme_mod('homepage_process_label', 'Our Process');
$process_title = get_theme_mod('homepage_process_title', 'How Fair Go Finance works');
$process_description = get_theme_mod('homepage_process_description', "Our personal loan rates are customised to you and your circumstances. And we've got loans for just about anything you need. Learn how much you could borrow and what the repayments could be.");
$process_btn1_text = get_theme_mod('homepage_process_btn1_text', 'How it works');
$process_btn2_text = get_theme_mod('homepage_process_btn2_text', 'Calculate Repayments');
$process_btn2_url = get_theme_mod('homepage_process_btn2_url', '/calculator');

$process_steps = [
    1 => [
        'title' => get_theme_mod('homepage_process_step1_title', 'Apply now'),
        'desc' => get_theme_mod('homepage_process_step1_desc', 'Our online application takes just six minutes to complete.'),
    ],
    2 => [
        'title' => get_theme_mod('homepage_process_step2_title', 'Accept our offer'),
        'desc' => get_theme_mod('homepage_process_step2_desc', "We send you the loan terms. You accept with a secure SMS code. It couldn't be easier."),
    ],
    3 => [
        'title' => get_theme_mod('homepage_process_step3_title', 'Get your funds'),
        'desc' => get_theme_mod('homepage_process_step3_desc', 'Our real-time funding means your funds are in your account on the same day.'),
    ],
    4 => [
        'title' => get_theme_mod('homepage_process_step4_title', 'Stay supported'),
        'desc' => get_theme_mod('homepage_process_step4_desc', 'We stick around to help with repayments, questions and credit score boosts.'),
    ],
];
?>

<!-- Process Section -->
<section class="section process-section" id="process">
    <div class="container">
        <div class="process-hero-grid">
            <!-- Left: Image -->
            <div class="process-image-wrapper">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/process-image.webp'); ?>"
                    alt="<?php echo esc_attr($process_title); ?>" loading="lazy">
            </div>

            <!-- Right: Content -->
            <div class="process-content">
                <span class="process-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                    </svg>
                    <?php echo esc_html($process_label); ?>
                </span>
                <h2 class="process-title">
                    <?php echo esc_html($process_title); ?>
                </h2>
                <p class="process-description">
                    <?php echo esc_html($process_description); ?>
                </p>
                <div class="process-buttons">
                    <a href="#process-steps" class="btn btn-outline">
                        <?php echo esc_html($process_btn1_text); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url($process_btn2_url)); ?>" class="btn btn-outline">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="4" y="2" width="16" height="20" rx="2" />
                            <line x1="8" y1="6" x2="16" y2="6" />
                            <line x1="8" y1="10" x2="16" y2="10" />
                            <line x1="8" y1="14" x2="12" y2="14" />
                            <line x1="8" y1="18" x2="12" y2="18" />
                        </svg>
                        <?php echo esc_html($process_btn2_text); ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Process Steps Grid -->
        <div class="process-grid" id="process-steps">
            <?php 
            $icons = [
                1 => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14" /><path d="M12 5l7 7-7 7" /></svg>',
                2 => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4" /><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" /></svg>',
                3 => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><path d="M12 6v6l4 2" /><path d="M8 3v2M16 3v2" /></svg>',
                4 => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" /><polyline points="9 22 9 12 15 12 15 22" /></svg>',
            ];
            
            foreach ($process_steps as $i => $step): ?>
            <div class="process-step">
                <div class="process-icon process-icon-<?php echo $i; ?>">
                    <?php echo $icons[$i]; ?>
                </div>
                <div class="process-step-content">
                    <h3><?php echo esc_html($step['title']); ?></h3>
                    <p><?php echo esc_html($step['desc']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
</section>

<?php
// Loan Comparison Section customizer values
$comparison_title = get_theme_mod('homepage_comparison_title', 'Fair Go Loans Examples');

// Small Loan
$small_tier_title = get_theme_mod('homepage_loan_small_tier_title', 'Small Loan');
$small_amount_range = get_theme_mod('homepage_loan_small_amount_range', 'Loan amount: $500 – $2,000');
$small_term_range = get_theme_mod('homepage_loan_small_term_range', 'Loan term: 16 days – 12 months');
$small_fees = get_theme_mod('homepage_loan_small_fees', 'Fees: 20% establishment + 4% monthly (flat) | Other fees and charges may apply.');
$small_example_amount = get_theme_mod('homepage_loan_small_example_amount', '$1,000');
$small_example_term = get_theme_mod('homepage_loan_small_example_term', '28 weeks');
$small_est_fee = get_theme_mod('homepage_loan_small_est_fee', '$200');
$small_monthly_fee = get_theme_mod('homepage_loan_small_monthly_fee', '$280');
$small_total = get_theme_mod('homepage_loan_small_total', '$1,480');
$small_weekly = get_theme_mod('homepage_loan_small_weekly', '$70.00');

// Medium Loan
$medium_tier_title = get_theme_mod('homepage_loan_medium_tier_title', 'Medium Loan');
$medium_amount_range = get_theme_mod('homepage_loan_medium_amount_range', 'Loan amount: $2,001 – $5,000');
$medium_term_range = get_theme_mod('homepage_loan_medium_term_range', 'Loan term: 9 weeks – 24 months');
$medium_fees = get_theme_mod('homepage_loan_medium_fees', 'Fees: up to $400 establishment fee | Interest: up to 47.80% p.a| Other fees and charges may apply.');
$medium_example_amount = get_theme_mod('homepage_loan_medium_example_amount', '$2,500');
$medium_example_term = get_theme_mod('homepage_loan_medium_example_term', '28 Weeks');
$medium_est_fee = get_theme_mod('homepage_loan_medium_est_fee', '$400');
$medium_interest = get_theme_mod('homepage_loan_medium_interest', '$394.74');
$medium_total = get_theme_mod('homepage_loan_medium_total', '$3,289');
$medium_weekly = get_theme_mod('homepage_loan_medium_weekly', '$117.67');

// Large Loan
$large_tier_title = get_theme_mod('homepage_loan_large_tier_title', 'Large Loan');
$large_amount_range = get_theme_mod('homepage_loan_large_amount_range', 'Loan amount: $5,001 – $50,000');
$large_term_range = get_theme_mod('homepage_loan_large_term_range', 'Loan term: 12 weeks – 60 months');
$large_fees = get_theme_mod('homepage_loan_large_fees', 'Fees: up to $990 establishment fee | Interest: up to 47.80% p.a| Other fees and charges may apply.');
$large_example_amount = get_theme_mod('homepage_loan_large_example_amount', '$10,000');
$large_example_term = get_theme_mod('homepage_loan_large_example_term', '52 Weeks');
$large_est_fee = get_theme_mod('homepage_loan_large_est_fee', '$990');
$large_interest = get_theme_mod('homepage_loan_large_interest', '$2,145.00');
$large_total = get_theme_mod('homepage_loan_large_total', '$13,135');
$large_weekly = get_theme_mod('homepage_loan_large_weekly', '$250.00');
?>

<!-- Loan Comparison Section -->
<section class="section comparison-section" id="loan-examples">
    <div class="container">
        <h2 class="comparison-title">
            <?php echo esc_html($comparison_title); ?><sup>2</sup>
        </h2>

        <div class="comparison-grid">
            <!-- Loan Tables Only - Benefits List Removed -->
            <div class="comparison-tables" style="grid-column: 1 / -1;">
                <!-- Small Loan -->
                <div class="loan-table">
                    <div class="loan-table-header loan-table-header-small">
                        <h4><?php echo esc_html($small_tier_title); ?></h4>
                        <p><?php echo esc_html($small_amount_range . ' | ' . $small_term_range . ' | ' . $small_fees); ?></p>
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
                                <td><strong><?php echo esc_html($small_example_amount); ?></strong></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Term', 'finance-theme'); ?></td>
                                <td><strong><?php echo esc_html($small_example_term); ?></strong></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Establishment fee', 'finance-theme'); ?></td>
                                <td><strong><?php echo esc_html($small_est_fee); ?></strong></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Total monthly fee', 'finance-theme'); ?></td>
                                <td><strong><?php echo esc_html($small_monthly_fee); ?></strong></td>
                            </tr>
                            <tr class="total-row">
                                <td><?php esc_html_e('Total repayable', 'finance-theme'); ?></td>
                                <td><strong><?php echo esc_html($small_total); ?></strong></td>
                            </tr>
                        </table>
                        <div class="weekly-repayment weekly-repayment-small">
                            <span><?php esc_html_e('Weekly repayment', 'finance-theme'); ?></span>
                            <strong><?php echo esc_html($small_weekly); ?></strong>
                        </div>
                    </div>
                </div>

                <!-- Medium Loan -->
                <div class="loan-table">
                    <div class="loan-table-header loan-table-header-medium">
                        <h4><?php echo esc_html($medium_tier_title); ?></h4>
                        <p><?php echo esc_html($medium_amount_range . ' | ' . $medium_term_range . ' | ' . $medium_fees); ?></p>
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
                                <td><strong><?php echo esc_html($medium_example_amount); ?></strong></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Term', 'finance-theme'); ?></td>
                                <td><strong><?php echo esc_html($medium_example_term); ?></strong></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Establishment fee', 'finance-theme'); ?></td>
                                <td><strong><?php echo esc_html($medium_est_fee); ?></strong></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Total interest', 'finance-theme'); ?></td>
                                <td><strong><?php echo esc_html($medium_interest); ?></strong></td>
                            </tr>
                            <tr class="total-row">
                                <td><?php esc_html_e('Total repayable', 'finance-theme'); ?></td>
                                <td><strong><?php echo esc_html($medium_total); ?></strong></td>
                            </tr>
                        </table>
                        <div class="weekly-repayment weekly-repayment-medium">
                            <span><?php esc_html_e('Weekly repayment', 'finance-theme'); ?></span>
                            <strong><?php echo esc_html($medium_weekly); ?></strong>
                        </div>
                    </div>
                </div>

                <!-- Large Loan -->
                <div class="loan-table">
                    <div class="loan-table-header loan-table-header-large">
                        <h4><?php echo esc_html($large_tier_title); ?></h4>
                        <p><?php echo esc_html($large_amount_range . ' | ' . $large_term_range . ' | ' . $large_fees); ?></p>
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
                                <td><strong><?php echo esc_html($large_example_amount); ?></strong></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Term', 'finance-theme'); ?></td>
                                <td><strong><?php echo esc_html($large_example_term); ?></strong></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Establishment fee', 'finance-theme'); ?></td>
                                <td><strong><?php echo esc_html($large_est_fee); ?></strong></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Total interest', 'finance-theme'); ?></td>
                                <td><strong><?php echo esc_html($large_interest); ?></strong></td>
                            </tr>
                            <tr class="total-row">
                                <td><?php esc_html_e('Total repayable', 'finance-theme'); ?></td>
                                <td><strong><?php echo esc_html($large_total); ?></strong></td>
                            </tr>
                        </table>
                        <div class="weekly-repayment weekly-repayment-large">
                            <span><?php esc_html_e('Weekly repayment', 'finance-theme'); ?></span>
                            <strong><?php echo esc_html($large_weekly); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Australia Section customizer values
$australia_title = get_theme_mod('homepage_australia_title', 'Trusted by Australians');
$australia_intro_template = get_theme_mod('homepage_australia_intro', '');
$australia_feature1 = get_theme_mod('homepage_australia_feature1', '100% Australian owned');
$australia_feature2 = get_theme_mod('homepage_australia_feature2', 'Bad Credit? No Problem.');
$australia_feature3 = get_theme_mod('homepage_australia_feature3', '100% Secure Process');
$australia_button = get_theme_mod('homepage_australia_button', 'Apply Now');
$australia_note = get_theme_mod('homepage_australia_note', 'Safe and Secure. 5 min application*');

$company_name = get_bloginfo('name');
$asic_number = get_theme_mod('flavor_asic_number', 'XXXXXX');
$afca_number = get_theme_mod('flavor_afca_number', 'XXXXXX');

// Build intro text - use template if set, otherwise use default
if (empty($australia_intro_template)) {
    $australia_intro = sprintf(
        '%s holds Australian Credit Licence %s and is a member of AFCA (%s). We provide straightforward loan options that put transparency, security, and responsible lending first.',
        $company_name,
        $asic_number,
        $afca_number
    );
} else {
    $australia_intro = sprintf($australia_intro_template, $company_name, $asic_number, $afca_number);
}
?>

<!-- Trusted by Australians Section -->
<section class="section australia-section" id="about">
    <div class="container">
        <div class="australia-grid">
            <div class="australia-content">
                <h2><?php echo esc_html($australia_title); ?></h2>
                <p class="australia-intro">
                    <?php echo esc_html($australia_intro); ?>
                </p>

                <ul class="australia-features">
                    <li>
                        <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points=" 20 6 9 17 4 12" />
                        </svg>
                        <span><?php echo esc_html($australia_feature1); ?></span>
                    </li>
                    <li>
                        <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        <span><?php echo esc_html($australia_feature2); ?></span>
                    </li>
                    <li>
                        <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        <span><?php echo esc_html($australia_feature3); ?></span>
                    </li>
                </ul>

                <a href="<?php echo esc_url(home_url('/apply')); ?>" class="btn btn-australia">
                    <?php echo esc_html($australia_button); ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
                <p class="australia-note">
                    <?php echo esc_html($australia_note); ?>
                </p>
            </div>

            <div class="australia-image">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/australia-people.png'); ?>"
                    alt="<?php echo esc_attr($australia_title); ?>" loading="lazy">
            </div>
        </div>
    </div>
</section>

<?php
// Testimonials Section customizer values
$testimonials_title = get_theme_mod('homepage_testimonials_title', 'What Our Customers Say');
$testimonials_subtitle = get_theme_mod('homepage_testimonials_subtitle', "Don't just take our word for it - hear from real customers who got a fair go.");
?>

<!-- Testimonials Section -->
<section class="section testimonials-section" id="testimonials">
    <div class="container">
        <div class="section-header">
            <h2><?php echo esc_html($testimonials_title); ?></h2>
            <p><?php echo esc_html($testimonials_subtitle); ?></p>
        </div>

        <div class="testimonials-grid" id="testimonials-slider-track">
            <?php foreach (array_slice($testimonials, 0, 6) as $testimonial): ?>
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

<?php
// FAQ Section customizer values
$faq_title = get_theme_mod('homepage_faq_title', 'Frequently Asked Questions');
$faq_subtitle = get_theme_mod('homepage_faq_subtitle', "Got questions? We've got answers.");
?>

<!-- FAQ Section -->
<section class="section faq-section" id="faq">
    <div class="container">
        <div class="section-header">
            <h2><?php echo esc_html($faq_title); ?></h2>
            <p><?php echo esc_html($faq_subtitle); ?></p>
        </div>

        <div class="faq-list">
            <?php foreach ($faqs as $index => $faq): ?>
                <div class="faq-item<?php echo $index === 0 ? ' active' : ''; ?>">
                    <button class="faq-question" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                        <span>
                            <?php echo esc_html($faq['question']); ?>
                        </span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6" />
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <?php echo wp_kses_post($faq['answer']); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
// Blog Section customizer values
$blog_title = get_theme_mod('homepage_blog_title', 'Latest from Our Blog');
$blog_subtitle = get_theme_mod('homepage_blog_subtitle', 'Tips, insights, and news about personal finance in Australia.');
$blog_button = get_theme_mod('homepage_blog_button', 'View All Posts');
?>

<!-- Latest Blogs Section -->
<section class="section blog-section" id="blog">
    <div class="container">
        <div class="section-header">
            <h2><?php echo esc_html($blog_title); ?></h2>
            <p><?php echo esc_html($blog_subtitle); ?></p>
        </div>

        <div class="blog-grid">
            <?php if (!empty($latest_posts)): ?>
                <?php foreach ($latest_posts as $post):
                    setup_postdata($post); ?>
                    <article class="blog-card">
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="blog-card-image">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('blog-thumbnail'); ?>
                            <?php else: ?>
                                <div
                                    style="width:100%;height:100%;background:var(--gray-300);display:flex;align-items:center;justify-content:center;">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gray-400)"
                                        stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                        <polyline points="21 15 16 10 5 21" />
                                    </svg>
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
                <?php endforeach;
                wp_reset_postdata(); ?>
            <?php else: ?>
                <!-- Sample blog posts if no posts exist -->
                <?php
                $sample_posts = [
                    ['title' => '5 Tips to Improve Your Credit Score in 2026', 'date' => 'January 10, 2026', 'excerpt' => 'Your credit score impacts everything from loan rates to rental applications. Here are our top tips for boosting your score.'],
                    ['title' => 'How to Create a Budget That Actually Works', 'date' => 'January 8, 2026', 'excerpt' => 'Budgeting doesn\'t have to be complicated. Learn our simple system for managing your money effectively.'],
                    ['title' => 'Understanding Loan Interest Rates in Australia', 'date' => 'January 5, 2026', 'excerpt' => 'Fixed vs variable, comparison rates, and more - we break down everything you need to know about interest rates.'],
                ];
                foreach ($sample_posts as $sample):
                    ?>
                    <article class="blog-card">
                        <div class="blog-card-image">
                            <div
                                style="width:100%;height:100%;background:linear-gradient(135deg, var(--primary-700), var(--primary-900));display:flex;align-items:center;justify-content:center;">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--white-50)"
                                    stroke-width="1.5">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                                </svg>
                            </div>
                        </div>
                        <div class="blog-card-body">
                            <div class="blog-card-meta">
                                <time>
                                    <?php echo esc_html($sample['date']); ?>
                                </time>
                            </div>
                            <h3>
                                <?php echo esc_html($sample['title']); ?>
                            </h3>
                            <p>
                                <?php echo esc_html($sample['excerpt']); ?>
                            </p>
                            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="read-more">
                                <?php esc_html_e('Read More', 'finance-theme'); ?>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="text-center" style="margin-top: var(--space-10);">
            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="btn btn-secondary">
                <?php echo esc_html($blog_button); ?>
            </a>
        </div>
    </div>
</section>


<?php
get_footer();

