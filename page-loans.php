<?php
/**
 * Page Template: Loans
 * 
 * Automatically used for pages with slug 'loans'
 * Also works as a page template.
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Fetch Dynamic Loan Types
$loan_posts = get_posts([
    'post_type' => 'loan_type',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
]);

$loan_categories = [];

if (!empty($loan_posts)) {
    foreach ($loan_posts as $post) {
        $features_text = get_post_meta($post->ID, '_loan_features', true);
        $features_list = !empty($features_text) ? array_filter(array_map('trim', explode("\n", $features_text))) : []; // Clean features array

        // If no custom features, provide a default generic one
        if (empty($features_list)) {
            $features_list = [
                __('Fast approval process', 'finance-theme'),
                __('Transparent terms', 'finance-theme')
            ];
        }

        $loan_categories[] = [
            'title' => get_the_title($post),
            'slug' => $post->post_name,
            'description' => get_the_excerpt($post),
            'image' => get_the_post_thumbnail_url($post, 'large') ?: get_template_directory_uri() . '/assets/images/loans/default.webp', // Need a fallback image
            'amount' => get_post_meta($post->ID, '_loan_amount', true) ?: '$500 - $10,000',
            'term' => get_post_meta($post->ID, '_loan_term', true) ?: 'Flexible Terms',
            'color' => get_post_meta($post->ID, '_loan_color', true) ?: 'var(--accent-500)',
            'features' => $features_list
        ];
    }
} else {
    // FALLBACK DATA (Keep original hardcoded data if no posts found, to ensure page isn't empty on first install)
    $loan_categories = [
        [
            'title' => 'Emergency Loans',
            'slug' => 'emergency-loans',
            'description' => 'When unexpected expenses arise, our emergency loans provide fast access to funds when you need them most.',
            'image' => get_template_directory_uri() . '/assets/images/loans/emergency-loan.webp',
            'amount' => '$500 - $10,000',
            'term' => '16 days - 24 months',
            'features' => ['Same-day approval', 'No hidden fees', 'Flexible repayment', 'Bad credit considered'],
            'color' => 'var(--accent-500)'
        ],
        // ... (I could re-add all, but for brevity/cleanliness, I'll assume users will create posts. 
        // Actually, the user asked for dynamic. If they delete posts, they expect empty or dynamic. 
        // I'll keep just one example as fallback so it's not totally broken.)
        [
            'title' => 'Personal Loans',
            'slug' => 'personal-loans',
            'description' => 'Flexible personal loans for any purpose. Competitive rates and fast approval.',
            'image' => get_template_directory_uri() . '/assets/images/loans/default.webp',
            'amount' => '$2,000 - $50,000',
            'term' => '12 - 60 months',
            'features' => ['Low rates', 'Fast funding', 'No early payout fees'],
            'color' => '#3498db'
        ],
    ];
}
?>

<?php
// Page Hero
get_template_part('template-parts/page-hero', null, [
    'badge' => __('Our Loan Products', 'finance-theme'),
    'title' => __('Personal Loans for', 'finance-theme'),
    'title_accent' => __('Every Need', 'finance-theme'),
    'subtitle' => __('Whether it\'s an emergency, a big life event, or just getting ahead - we\'ve got a loan for that. Fast approvals, competitive rates, and flexible terms.', 'finance-theme'),
    'show_stats' => true,
    'stats' => [
        ['number' => '$50k', 'label' => __('Max Loan Amount', 'finance-theme')],
        ['number' => '60 min*', 'label' => __('Fast Funding', 'finance-theme')],
        ['number' => '100%', 'label' => __('Online Process', 'finance-theme')],
    ]
]);

// Features Row
get_template_part('template-parts/features-row');
?>

<!-- Quick Navigation -->
<section class="loans-quick-nav">
    <div class="container">
        <div class="quick-nav-wrapper">
            <span class="quick-nav-label">
                <?php esc_html_e('Jump to:', 'finance-theme'); ?>
            </span>
            <div class="quick-nav-pills">
                <?php foreach ($loan_categories as $index => $loan): ?>
                    <a href="#<?php echo esc_attr($loan['slug']); ?>" class="nav-pill">
                        <?php echo esc_html($loan['title']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Loan Categories Grid -->
<section class="section loans-grid-section">
    <div class="container">
        <?php foreach ($loan_categories as $index => $loan): ?>
            <div class="loan-category-card <?php echo $index % 2 === 0 ? '' : 'reversed'; ?>"
                id="<?php echo esc_attr($loan['slug']); ?>">
                <div class="loan-category-image">
                    <?php if ($loan['image'] && strpos($loan['image'], 'default.webp') === false): ?>
                        <img src="<?php echo esc_url($loan['image']); ?>" alt="<?php echo esc_attr($loan['title']); ?>"
                            loading="lazy">
                    <?php else: ?>
                        <!-- Fallback Placeholder if no image -->
                        <div
                            style="width: 100%; height: 300px; background: var(--gray-200); display: flex; align-items: center; justify-content: center; color: var(--gray-400);">
                            <span><?php esc_html_e('No Image Available', 'finance-theme'); ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="loan-amount-badge" style="background: <?php echo esc_attr($loan['color']); ?>">
                        <?php echo esc_html($loan['amount']); ?>
                    </div>
                </div>
                <div class="loan-category-content">
                    <h2>
                        <a href="<?php echo esc_url(home_url('/loan/' . $loan['slug'])); ?>"
                            style="text-decoration: none; color: inherit;">
                            <?php echo esc_html($loan['title']); ?>
                        </a>
                    </h2>
                    <p class="loan-description">
                        <?php echo esc_html($loan['description']); ?>
                    </p>

                    <div class="loan-details">
                        <div class="loan-detail-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg>
                            <div>
                                <span class="detail-label">
                                    <?php esc_html_e('Loan Term', 'finance-theme'); ?>
                                </span>
                                <span class="detail-value">
                                    <?php echo esc_html($loan['term']); ?>
                                </span>
                            </div>
                        </div>
                        <div class="loan-detail-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                            </svg>
                            <div>
                                <span class="detail-label">
                                    <?php esc_html_e('Loan Amount', 'finance-theme'); ?>
                                </span>
                                <span class="detail-value">
                                    <?php echo esc_html($loan['amount']); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <ul class="loan-features">
                        <?php foreach ($loan['features'] as $feature): ?>
                            <li>
                                <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="var(--accent-500)"
                                    stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                <span>
                                    <?php echo esc_html($feature); ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="loan-actions">
                        <a href="<?php echo esc_url(add_query_arg('loan_type', $loan['slug'], home_url('/apply'))); ?>"
                            class="btn btn-primary">
                            <?php esc_html_e('Apply Now', 'finance-theme'); ?>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                        <a href="<?php echo esc_url(home_url('/loan/' . $loan['slug'])); ?>" class="btn btn-secondary">
                            <?php esc_html_e('Learn More', 'finance-theme'); ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="section loans-why-section">
    <div class="container">
        <div class="section-header">
            <h2>
                <?php esc_html_e('Why Choose Fair Go Finance?', 'finance-theme'); ?>
            </h2>
            <p>
                <?php esc_html_e('We\'re committed to giving Australians a fair go with transparent, responsible lending.', 'finance-theme'); ?>
            </p>
        </div>

        <div class="why-choose-grid">
            <div class="why-card">
                <div class="why-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 6v6l4 2" />
                    </svg>
                </div>
                <h3>
                    <?php esc_html_e('Fast Decisions', 'finance-theme'); ?>
                </h3>
                <p>
                    <?php esc_html_e('Get an answer within minutes, not days. Our streamlined process means you\'re not left waiting.', 'finance-theme'); ?>
                </p>
            </div>

            <div class="why-card">
                <div class="why-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                </div>
                <h3>
                    <?php esc_html_e('100% Secure', 'finance-theme'); ?>
                </h3>
                <p>
                    <?php esc_html_e('Your data is protected with bank-grade encryption. We never share your information.', 'finance-theme'); ?>
                </p>
            </div>

            <div class="why-card">
                <div class="why-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                    </svg>
                </div>
                <h3>
                    <?php esc_html_e('Bad Credit OK', 'finance-theme'); ?>
                </h3>
                <p>
                    <?php esc_html_e('We look at your whole situation, not just credit scores. Everyone deserves a fair go.', 'finance-theme'); ?>
                </p>
            </div>

            <div class="why-card">
                <div class="why-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                        <line x1="1" y1="10" x2="23" y2="10" />
                    </svg>
                </div>
                <h3>
                    <?php esc_html_e('No Hidden Fees', 'finance-theme'); ?>
                </h3>
                <p>
                    <?php esc_html_e('What you see is what you pay. Transparent pricing with no surprises along the way.', 'finance-theme'); ?>
                </p>
            </div>
        </div>
    </div>
</section>

<?php
// CTA Section
get_template_part('template-parts/cta-section', null, [
    'title' => __('Ready to Get Started?', 'finance-theme'),
    'subtitle' => __('Apply in just 6 minutes and get your funds the same day. It\'s quick, easy, and 100% online.', 'finance-theme'),
]);

get_footer();
?>