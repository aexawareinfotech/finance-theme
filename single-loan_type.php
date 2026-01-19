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


    <!-- Why Choose Us (Specific for single loan pages) -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2><?php esc_html_e('Why Choose This Loan?', 'finance-theme'); ?></h2>
            </div>
            <div class="why-choose-grid">
                <div class="why-card">
                    <div class="why-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                    </div>
                    <h3><?php esc_html_e('Fast Processing', 'finance-theme'); ?></h3>
                    <p><?php esc_html_e('We prioritize your application to get you funds when you need them.', 'finance-theme'); ?>
                    </p>
                </div>
                <div class="why-card">
                    <div class="why-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                    </div>
                    <h3><?php esc_html_e('Flexible Terms', 'finance-theme'); ?></h3>
                    <p><?php esc_html_e('Choose repayment options that suit your budget and schedule.', 'finance-theme'); ?>
                    </p>
                </div>
                <div class="why-card">
                    <div class="why-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                            <line x1="1" y1="10" x2="23" y2="10" />
                        </svg>
                    </div>
                    <h3><?php esc_html_e('No Hidden Costs', 'finance-theme'); ?></h3>
                    <p><?php esc_html_e('Transparent fee structure so you know exactly what you pay.', 'finance-theme'); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <?php
    // Get current post slug and build apply URL
    $loan_slug = get_post_field('post_name', get_post());
    $apply_url = add_query_arg('loan_type', $loan_slug, home_url('/apply'));

    // CTA Section
    get_template_part('template-parts/cta-section', null, [
        'title' => sprintf(__('Apply for a %s today', 'finance-theme'), get_the_title()),
        'subtitle' => __('It only takes a few minutes to complete our secure online application.', 'finance-theme'),
        'apply_url' => $apply_url,
    ]);

endwhile; // End of the loop.

get_footer();
?>