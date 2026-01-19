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

    // Get dynamic meta values
    $subtitle = get_post_meta($post_id, '_loan_subtitle', true);
    if (empty($subtitle)) {
        $subtitle = get_the_excerpt();
    }

    // Get dynamic stats
    $stats = [];

    // Stat 1
    $stat_1_num = get_post_meta($post_id, '_loan_stat_1_number', true);
    $stat_1_label = get_post_meta($post_id, '_loan_stat_1_label', true);
    if ($stat_1_num && $stat_1_label) {
        $stats[] = ['number' => $stat_1_num, 'label' => $stat_1_label];
    } else {
        // Fallback default
        $stats[] = ['number' => '$50k', 'label' => __('Max Loan Amount', 'finance-theme')];
    }

    // Stat 2
    $stat_2_num = get_post_meta($post_id, '_loan_stat_2_number', true);
    $stat_2_label = get_post_meta($post_id, '_loan_stat_2_label', true);
    if ($stat_2_num && $stat_2_label) {
        $stats[] = ['number' => $stat_2_num, 'label' => $stat_2_label];
    } else {
        // Fallback default
        $stats[] = ['number' => '60 min*', 'label' => __('Fast Funding', 'finance-theme')];
    }

    // Stat 3
    $stat_3_num = get_post_meta($post_id, '_loan_stat_3_number', true);
    $stat_3_label = get_post_meta($post_id, '_loan_stat_3_label', true);
    if ($stat_3_num && $stat_3_label) {
        $stats[] = ['number' => $stat_3_num, 'label' => $stat_3_label];
    } else {
        // Fallback default
        $stats[] = ['number' => '100%', 'label' => __('Online Process', 'finance-theme')];
    }

    // Page Hero
    get_template_part('template-parts/page-hero', null, [
        'badge' => __('Personal Loan', 'finance-theme'),
        'title' => get_the_title(),
        'subtitle' => $subtitle,
        'show_stats' => true,
        'stats' => $stats
    ]);

    // Features Row (Site-wide benefits)
    get_template_part('template-parts/features-row');
    ?>

    <!-- Why Choose This Loan Section -->
    <section class="section why-choose-loan-section" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd9 100%);">
        <div class="container">
            <div class="why-choose-loan-grid"
                style="display: grid; grid-template-columns: 1fr 1.2fr; gap: var(--space-12); align-items: center;">
                <div class="why-choose-image" style="border-radius: var(--radius-2xl); overflow: hidden;">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('large', ['style' => 'width: 100%; height: auto; display: block;']); ?>
                    <?php else: ?>
                        <img src="https://www.shutterstock.com/shutterstock/videos/3718668489/thumb/1.jpg?ip=x480"
                            alt="<?php echo esc_attr(get_the_title()); ?>" style="width: 100%; height: auto; display: block;">
                    <?php endif; ?>
                </div>
                <div class="why-choose-content">
                    <h2
                        style="font-size: var(--text-3xl); font-weight: 700; color: var(--gray-900); margin-bottom: var(--space-4);">
                        <?php printf(esc_html__('Why Choose a %s', 'finance-theme'), get_the_title()); ?>
                    </h2>
                    <p style="color: var(--gray-700); margin-bottom: var(--space-8); font-size: var(--text-lg);">
                        <?php echo esc_html($subtitle); ?>
                    </p>

                    <div class="why-choose-features" style="display: flex; flex-direction: column; gap: var(--space-6);">
                        <!-- Feature 1 -->
                        <div class="why-feature-item" style="display: flex; gap: var(--space-4); align-items: flex-start;">
                            <div class="why-feature-icon"
                                style="width: 48px; height: 48px; background: var(--accent-500); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 6v6l4 2" />
                                </svg>
                            </div>
                            <div>
                                <h4
                                    style="font-size: var(--text-lg); font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-1);">
                                    <?php esc_html_e('Cash in as little as 60 minutes', 'finance-theme'); ?>
                                </h4>
                                <p style="color: var(--gray-600); font-size: var(--text-base); line-height: 1.6;">
                                    <?php esc_html_e('Apply online and, if approved before 4:30 pm on a banking day, you could have the cash in your account in just 60 minutes.*', 'finance-theme'); ?>
                                </p>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div class="why-feature-item" style="display: flex; gap: var(--space-4); align-items: flex-start;">
                            <div class="why-feature-icon"
                                style="width: 48px; height: 48px; background: var(--accent-500); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
                                    <line x1="8" y1="21" x2="16" y2="21" />
                                    <line x1="12" y1="17" x2="12" y2="21" />
                                </svg>
                            </div>
                            <div>
                                <h4
                                    style="font-size: var(--text-lg); font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-1);">
                                    <?php esc_html_e('100% online, zero paperwork', 'finance-theme'); ?>
                                </h4>
                                <p style="color: var(--gray-600); font-size: var(--text-base); line-height: 1.6;">
                                    <?php esc_html_e('No queues, no printers, no problem. Our fast online process keeps things simple, smart, and hassle-free.', 'finance-theme'); ?>
                                </p>
                            </div>
                        </div>

                        <!-- Feature 3 -->
                        <div class="why-feature-item" style="display: flex; gap: var(--space-4); align-items: flex-start;">
                            <div class="why-feature-icon"
                                style="width: 48px; height: 48px; background: var(--accent-500); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                            </div>
                            <div>
                                <h4
                                    style="font-size: var(--text-lg); font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-1);">
                                    <?php esc_html_e('Real support, real fast', 'finance-theme'); ?>
                                </h4>
                                <p style="color: var(--gray-600); font-size: var(--text-base); line-height: 1.6;">
                                    <?php esc_html_e('Need help choosing the right repayment plan? Our Aussie-based team is here with real answers and is always happy to help.', 'finance-theme'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="section loan-content-section" style="padding-top: var(--space-12);">
        <div class="container" style="max-width: 900px;">
            <div class="entry-content" style="font-size: var(--text-lg); line-height: 1.8;">
                <?php the_content(); ?>
            </div>

            <?php
            // Display Features List if entered
            $features_text = get_post_meta($post_id, '_loan_features', true);
            if (!empty($features_text)):
                $features_list = array_filter(array_map('trim', explode("\n", $features_text)));
                if (!empty($features_list)):
                    ?>
                    <div class="loan-features-list"
                        style="margin-top: var(--space-8); background: var(--gray-100); padding: var(--space-8); border-radius: var(--radius-xl);">
                        <h3 style="margin-bottom: var(--space-6);"><?php esc_html_e('Key Features', 'finance-theme'); ?></h3>
                        <ul class="loan-features"
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--space-4);">
                            <?php foreach ($features_list as $feature): ?>
                                <li style="display: flex; gap: var(--space-3); align-items: center;">
                                    <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="var(--accent-500)"
                                        stroke-width="2.5" style="width: 20px; height: 20px;">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                    <span><?php echo esc_html($feature); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php
                endif;
            endif;
            ?>
        </div>
    </section>

    <!-- Eligibility Section -->
    <section class="section eligibility-section" style="background: #fff;">
        <div class="container">
            <div class="eligibility-grid"
                style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-12); align-items: center;">
                <div class="eligibility-content">
                    <h2
                        style="font-size: var(--text-3xl); font-weight: 700; color: var(--gray-900); margin-bottom: var(--space-4); text-decoration: underline; text-decoration-color: var(--accent-500); text-underline-offset: 8px;">
                        <?php esc_html_e('Eligibility', 'finance-theme'); ?>
                    </h2>
                    <p style="color: var(--gray-700); margin-bottom: var(--space-6); font-size: var(--text-lg);">
                        <?php esc_html_e('As a responsible lender, our priority is ensuring your loan is affordable and suitable for your specific needs.', 'finance-theme'); ?>
                    </p>
                    <p style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-4);">
                        <?php esc_html_e('To be eligible, you must:', 'finance-theme'); ?>
                    </p>
                    <ul style="list-style: none; padding: 0; margin-bottom: var(--space-6);">
                        <li style="display: flex; align-items: center; gap: var(--space-3); margin-bottom: var(--space-3);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-500)"
                                stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            <span>
                                <?php esc_html_e('Receive a regular income', 'finance-theme'); ?>
                            </span>
                        </li>
                        <li style="display: flex; align-items: center; gap: var(--space-3); margin-bottom: var(--space-3);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-500)"
                                stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            <span>
                                <?php esc_html_e('Be an Australian resident', 'finance-theme'); ?>
                            </span>
                        </li>
                        <li style="display: flex; align-items: center; gap: var(--space-3); margin-bottom: var(--space-3);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-500)"
                                stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            <span>
                                <?php esc_html_e('Be at least 18 years old or over', 'finance-theme'); ?>
                            </span>
                        </li>
                    </ul>
                    <p style="color: var(--gray-600); font-size: var(--text-sm); line-height: 1.6;">
                        <a href="<?php echo esc_url(home_url('/apply')); ?>"
                            style="color: var(--accent-600); font-weight: 600;">
                            <?php esc_html_e('Existing customers', 'finance-theme'); ?>
                        </a>
                        <?php esc_html_e('can benefit from a faster borrowing process. As your trust rating improves, you may borrow more money with any subsequent loan - as long as you meet loan payments, the loan meets your requirements and objectives and repay your loan in full, on time and can afford the higher amount.', 'finance-theme'); ?>
                    </p>
                </div>
                <div class="eligibility-image" style="border-radius: var(--radius-2xl); overflow: hidden;">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/eligibility.jpg'); ?>"
                        alt="<?php esc_attr_e('Eligibility', 'finance-theme'); ?>"
                        style="width: 100%; height: auto; display: block;">
                </div>
            </div>
        </div>
    </section>

    <!-- How to Apply Section -->
    <section class="section how-to-apply-section" style="background: #f5f0eb;">
        <div class="container">
            <div class="how-to-apply-grid"
                style="display: grid; grid-template-columns: 1fr 1.5fr; gap: var(--space-12); align-items: flex-start;">
                <div class="how-to-apply-intro">
                    <h2
                        style="font-size: var(--text-3xl); font-weight: 700; color: var(--gray-900); margin-bottom: var(--space-4);">
                        <?php esc_html_e('How do I apply for a loan with Fair Go?', 'finance-theme'); ?>
                    </h2>
                    <p style="color: var(--gray-700); margin-bottom: var(--space-6);">
                        <?php printf(esc_html__('Applying for a %s is as simple as 4 easy steps.', 'finance-theme'), get_the_title()); ?>
                    </p>
                    <a href="<?php echo esc_url(add_query_arg('loan_type', get_post_field('post_name', get_post()), home_url('/apply'))); ?>"
                        class="btn"
                        style="display: inline-block; border: 1px solid var(--gray-400); background: transparent; color: var(--gray-900); padding: var(--space-3) var(--space-8); border-radius: var(--radius-md); text-decoration: none; font-weight: 500;">
                        <?php esc_html_e('Apply now', 'finance-theme'); ?>
                    </a>
                </div>
                <div class="how-to-apply-steps" style="display: flex; flex-direction: column; gap: 0; position: relative;">
                    <!-- Step 1 -->
                    <div class="apply-step"
                        style="display: flex; gap: var(--space-5); align-items: flex-start; position: relative; padding-bottom: var(--space-8);">
                        <!-- Line connector -->
                        <div
                            style="position: absolute; left: 19px; top: 40px; bottom: 0; width: 2px; background: var(--gray-300);">
                        </div>
                        <div class="step-number"
                            style="width: 40px; height: 40px; background: var(--gray-900); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; flex-shrink: 0; position: relative; z-index: 1;">
                            1</div>
                        <div>
                            <h4
                                style="font-size: var(--text-lg); font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-2);">
                                <?php esc_html_e('Apply in minutes', 'finance-theme'); ?>
                            </h4>
                            <p style="color: var(--gray-600); line-height: 1.6;">
                                <?php esc_html_e('You can apply online anywhere, at any time. All you have to do is answer some simple questions and provide 90 day bank statements.', 'finance-theme'); ?>
                            </p>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="apply-step"
                        style="display: flex; gap: var(--space-5); align-items: flex-start; position: relative; padding-bottom: var(--space-8);">
                        <!-- Line connector -->
                        <div
                            style="position: absolute; left: 19px; top: 40px; bottom: 0; width: 2px; background: var(--gray-300);">
                        </div>
                        <div class="step-number"
                            style="width: 40px; height: 40px; background: var(--gray-900); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; flex-shrink: 0; position: relative; z-index: 1;">
                            2</div>
                        <div>
                            <h4
                                style="font-size: var(--text-lg); font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-2);">
                                <?php esc_html_e('Get your loan offer', 'finance-theme'); ?>
                            </h4>
                            <p style="color: var(--gray-600); line-height: 1.6;">
                                <?php esc_html_e('Get a conditional loan offer immediately* which outlines the terms of your loan while you wait for final approval.', 'finance-theme'); ?>
                            </p>
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="apply-step"
                        style="display: flex; gap: var(--space-5); align-items: flex-start; position: relative; padding-bottom: var(--space-8);">
                        <!-- Line connector -->
                        <div
                            style="position: absolute; left: 19px; top: 40px; bottom: 0; width: 2px; background: var(--gray-300);">
                        </div>
                        <div class="step-number"
                            style="width: 40px; height: 40px; background: var(--gray-900); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; flex-shrink: 0; position: relative; z-index: 1;">
                            3</div>
                        <div>
                            <h4
                                style="font-size: var(--text-lg); font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-2);">
                                <?php esc_html_e('Receive your loan approval', 'finance-theme'); ?>
                            </h4>
                            <p style="color: var(--gray-600); line-height: 1.6;">
                                <?php esc_html_e('Our team is dedicated to balancing speed with responsible lending. We\'ll assess your application and let you know as soon as your loan is approved.*', 'finance-theme'); ?>
                            </p>
                        </div>
                    </div>
                    <!-- Step 4 (last - no line) -->
                    <div class="apply-step"
                        style="display: flex; gap: var(--space-5); align-items: flex-start; position: relative;">
                        <div class="step-number"
                            style="width: 40px; height: 40px; background: var(--gray-900); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; flex-shrink: 0; position: relative; z-index: 1;">
                            4</div>
                        <div>
                            <h4
                                style="font-size: var(--text-lg); font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-2);">
                                <?php esc_html_e('Get your money', 'finance-theme'); ?>
                            </h4>
                            <p style="color: var(--gray-600); line-height: 1.6;">
                                <?php esc_html_e('Once your loan is approved, your emergency cash will be digitally transferred to your bank account within 30 minutes via NPP instant transfers.**', 'finance-theme'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Example Loan Costs Section -->
    <section class="section loan-costs-section" style="background: #fff;">
        <div class="container">
            <div class="section-header" style="text-align: center; margin-bottom: var(--space-10);">
                <h2 style="font-size: var(--text-3xl); font-weight: 700; color: var(--gray-900);">
                    <?php esc_html_e('Example Loan Costs', 'finance-theme'); ?>
                </h2>
                <p style="color: var(--gray-600); max-width: 600px; margin: 0 auto;">
                    <?php esc_html_e('Here are some examples of what your loan repayments could look like. Actual rates may vary based on your circumstances.', 'finance-theme'); ?>
                </p>
            </div>

            <div class="loan-costs-grid"
                style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-6); max-width: 900px; margin: 0 auto;">
                <!-- Example 1 -->
                <div class="loan-cost-card"
                    style="background: var(--gray-50); border-radius: var(--radius-xl); padding: var(--space-6); text-align: center;">
                    <div style="font-size: var(--text-sm); color: var(--gray-500); margin-bottom: var(--space-2);">
                        <?php esc_html_e('Borrow', 'finance-theme'); ?>
                    </div>
                    <div
                        style="font-size: var(--text-2xl); font-weight: 700; color: var(--gray-900); margin-bottom: var(--space-4);">
                        $1,000</div>
                    <div style="font-size: var(--text-sm); color: var(--gray-500);">
                        <?php esc_html_e('Over 12 months', 'finance-theme'); ?>
                    </div>
                    <div
                        style="font-size: var(--text-lg); font-weight: 600; color: var(--accent-600); margin-top: var(--space-2);">
                        $95/fortnight*</div>
                </div>
                <!-- Example 2 -->
                <div class="loan-cost-card"
                    style="background: var(--accent-50); border: 2px solid var(--accent-500); border-radius: var(--radius-xl); padding: var(--space-6); text-align: center; position: relative;">
                    <div
                        style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: var(--accent-500); color: white; padding: 4px 16px; border-radius: var(--radius-full); font-size: var(--text-xs); font-weight: 600;">
                        <?php esc_html_e('POPULAR', 'finance-theme'); ?>
                    </div>
                    <div style="font-size: var(--text-sm); color: var(--gray-500); margin-bottom: var(--space-2);">
                        <?php esc_html_e('Borrow', 'finance-theme'); ?>
                    </div>
                    <div
                        style="font-size: var(--text-2xl); font-weight: 700; color: var(--gray-900); margin-bottom: var(--space-4);">
                        $3,000</div>
                    <div style="font-size: var(--text-sm); color: var(--gray-500);">
                        <?php esc_html_e('Over 24 months', 'finance-theme'); ?>
                    </div>
                    <div
                        style="font-size: var(--text-lg); font-weight: 600; color: var(--accent-600); margin-top: var(--space-2);">
                        $75/fortnight*</div>
                </div>
                <!-- Example 3 -->
                <div class="loan-cost-card"
                    style="background: var(--gray-50); border-radius: var(--radius-xl); padding: var(--space-6); text-align: center;">
                    <div style="font-size: var(--text-sm); color: var(--gray-500); margin-bottom: var(--space-2);">
                        <?php esc_html_e('Borrow', 'finance-theme'); ?>
                    </div>
                    <div
                        style="font-size: var(--text-2xl); font-weight: 700; color: var(--gray-900); margin-bottom: var(--space-4);">
                        $5,000</div>
                    <div style="font-size: var(--text-sm); color: var(--gray-500);">
                        <?php esc_html_e('Over 36 months', 'finance-theme'); ?>
                    </div>
                    <div
                        style="font-size: var(--text-lg); font-weight: 600; color: var(--accent-600); margin-top: var(--space-2);">
                        $85/fortnight*</div>
                </div>
            </div>
            <p style="text-align: center; color: var(--gray-500); font-size: var(--text-sm); margin-top: var(--space-6);">
                <?php esc_html_e('*Representative examples only. Your actual repayments may differ based on credit assessment.', 'finance-theme'); ?>
            </p>
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="section reviews-section" style="background: var(--gray-50);">
        <div class="container">
            <div class="section-header" style="text-align: center; margin-bottom: var(--space-10);">
                <h2 style="font-size: var(--text-3xl); font-weight: 700; color: var(--gray-900);">
                    <?php esc_html_e('What Our Customers Say', 'finance-theme'); ?>
                </h2>
            </div>

            <?php
            // Fetch testimonials
            $testimonials = get_posts([
                'post_type' => 'testimonial',
                'posts_per_page' => 3,
                'orderby' => 'rand',
            ]);

            if (!empty($testimonials)):
                ?>
                <div class="reviews-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-6);">
                    <?php foreach ($testimonials as $testimonial):
                        $rating = get_post_meta($testimonial->ID, '_testimonial_rating', true) ?: 5;
                        ?>
                        <div class="review-card"
                            style="background: #fff; border-radius: var(--radius-xl); padding: var(--space-6); box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                            <!-- Stars -->
                            <div style="display: flex; gap: 4px; margin-bottom: var(--space-4);">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <svg width="20" height="20" viewBox="0 0 24 24"
                                        fill="<?php echo $i < $rating ? '#fbbf24' : '#e5e7eb'; ?>">
                                        <path
                                            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                    </svg>
                                <?php endfor; ?>
                            </div>
                            <p style="color: var(--gray-700); line-height: 1.6; margin-bottom: var(--space-4);">
                                "
                                <?php echo esc_html(get_the_excerpt($testimonial) ?: get_the_content(null, false, $testimonial)); ?>"
                            </p>
                            <div style="font-weight: 600; color: var(--gray-900);">
                                <?php echo esc_html(get_the_title($testimonial)); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Fallback reviews -->
                <div class="reviews-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-6);">
                    <div class="review-card"
                        style="background: #fff; border-radius: var(--radius-xl); padding: var(--space-6); box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                        <div style="display: flex; gap: 4px; margin-bottom: var(--space-4);">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="#fbbf24">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <p style="color: var(--gray-700); line-height: 1.6; margin-bottom: var(--space-4);">"Fast and easy
                            process. Got my funds the same day!"</p>
                        <div style="font-weight: 600; color: var(--gray-900);">Sarah M.</div>
                    </div>
                    <div class="review-card"
                        style="background: #fff; border-radius: var(--radius-xl); padding: var(--space-6); box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                        <div style="display: flex; gap: 4px; margin-bottom: var(--space-4);">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="#fbbf24">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <p style="color: var(--gray-700); line-height: 1.6; margin-bottom: var(--space-4);">"The team was super
                            helpful and explained everything clearly."</p>
                        <div style="font-weight: 600; color: var(--gray-900);">James T.</div>
                    </div>
                    <div class="review-card"
                        style="background: #fff; border-radius: var(--radius-xl); padding: var(--space-6); box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                        <div style="display: flex; gap: 4px; margin-bottom: var(--space-4);">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="#fbbf24">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <p style="color: var(--gray-700); line-height: 1.6; margin-bottom: var(--space-4);">"Highly recommend!
                            No hidden fees and great rates."</p>
                        <div style="font-weight: 600; color: var(--gray-900);">Lisa K.</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- FAQs Section -->
    <section class="section faqs-section" style="background: #fff;">
        <div class="container" style="max-width: 800px;">
            <div class="section-header" style="text-align: center; margin-bottom: var(--space-10);">
                <h2 style="font-size: var(--text-3xl); font-weight: 700; color: var(--gray-900);">
                    <?php esc_html_e('Frequently Asked Questions', 'finance-theme'); ?>
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


    <?php
endwhile; // End of the loop.

get_footer();
?>