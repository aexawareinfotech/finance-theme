<?php
/**
 * Archive Template for Loan Types
 * 
 * Displays all loan types in a comprehensive single-page view
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<!-- Page Hero Section -->
<section class="loans-hero">
    <div class="container">
        <div class="loans-hero-content">
            <span class="loans-hero-badge">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                </svg>
                <?php esc_html_e('Our Loan Products', 'finance-theme'); ?>
            </span>
            <h1>
                <?php esc_html_e('Personal Loans for', 'finance-theme'); ?> <span class="text-accent">
                    <?php esc_html_e('Every Need', 'finance-theme'); ?>
                </span>
            </h1>
            <p class="loans-hero-subtitle">
                <?php esc_html_e('Whether it\'s an emergency, a big life event, or just getting ahead - we\'ve got a loan for that. Fast approvals, competitive rates, and flexible terms.', 'finance-theme'); ?>
            </p>
            <div class="loans-hero-stats">
                <div class="stat-item">
                    <span class="stat-number">$50k</span>
                    <span class="stat-label">
                        <?php esc_html_e('Max Loan Amount', 'finance-theme'); ?>
                    </span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-number">60 min*</span>
                    <span class="stat-label">
                        <?php esc_html_e('Fast Funding', 'finance-theme'); ?>
                    </span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-number">100%</span>
                    <span class="stat-label">
                        <?php esc_html_e('Online Process', 'finance-theme'); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Fetch loan types from WordPress
$loan_posts = get_posts([
    'post_type' => 'loan_type',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
]);
?>

<!-- Quick Navigation -->
<?php if (!empty($loan_posts)): ?>
    <section class="loans-quick-nav">
        <div class="container">
            <div class="quick-nav-wrapper">
                <span class="quick-nav-label">
                    <?php esc_html_e('Jump to:', 'finance-theme'); ?>
                </span>
                <div class="quick-nav-pills">
                    <?php foreach ($loan_posts as $loan_post): ?>
                        <a href="#<?php echo esc_attr($loan_post->post_name); ?>" class="nav-pill">
                            <?php echo esc_html(get_the_title($loan_post)); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Loan Categories Grid -->
<section class="section loans-grid-section">
    <div class="container">
        <?php if (!empty($loan_posts)): ?>
            <?php foreach ($loan_posts as $index => $loan_post):
                $post_id = $loan_post->ID;
                $image = get_the_post_thumbnail_url($loan_post, 'large') ?: get_template_directory_uri() . '/assets/images/loans/default.webp';
                $subtitle = get_post_meta($post_id, '_loan_subtitle', true) ?: get_the_excerpt($loan_post);
                $amount = get_post_meta($post_id, '_loan_amount', true) ?: '$500 - $50,000';
                $term = get_post_meta($post_id, '_loan_term', true) ?: '6 - 60 months';
                $features_raw = get_post_meta($post_id, '_loan_features', true);
                $features = !empty($features_raw) ? array_filter(explode("\n", $features_raw)) : ['Fast approval', 'Flexible terms', 'No hidden fees', 'Bad credit OK'];
                $color = get_post_meta($post_id, '_loan_color', true) ?: 'var(--accent-500)';
                $loan_url = get_permalink($loan_post);
                ?>
                <div class="loan-category-card <?php echo $index % 2 === 0 ? '' : 'reversed'; ?>"
                    id="<?php echo esc_attr($loan_post->post_name); ?>">
                    <div class="loan-category-image">
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title($loan_post)); ?>"
                            loading="lazy">
                        <div class="loan-amount-badge" style="background: <?php echo esc_attr($color); ?>">
                            <?php echo esc_html($amount); ?>
                        </div>
                    </div>
                    <div class="loan-category-content">
                        <h2>
                            <?php echo esc_html(get_the_title($loan_post)); ?>
                        </h2>
                        <p class="loan-description">
                            <?php echo esc_html($subtitle); ?>
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
                                        <?php echo esc_html($term); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="loan-detail-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                                </svg>
                                <div>
                                    <span class="detail-label">
                                        <?php esc_html_e('Loan Amount', 'finance-theme'); ?>
                                    </span>
                                    <span class="detail-value">
                                        <?php echo esc_html($amount); ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <ul class="loan-features">
                            <?php foreach ($features as $feature): ?>
                                <li>
                                    <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="var(--accent-500)"
                                        stroke-width="2.5">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                    <span>
                                        <?php echo esc_html(trim($feature)); ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="loan-actions">
                            <a href="<?php echo esc_url($loan_url); ?>" class="btn btn-primary">
                                <?php esc_html_e('Learn More', 'finance-theme'); ?>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                            </a>
                            <a href="<?php echo esc_url(home_url('/calculator')); ?>" class="btn btn-secondary">
                                <?php esc_html_e('Calculate Repayments', 'finance-theme'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align: center; padding: var(--space-16);">
                <p style="color: var(--gray-600); font-size: var(--text-lg);">
                    <?php esc_html_e('No loan types found. Please add some loan types in the WordPress admin.', 'finance-theme'); ?>
                </p>
            </div>
        <?php endif; ?>
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


<?php get_footer(); ?>