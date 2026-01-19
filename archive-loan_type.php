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

// Loan Categories Data
$loan_categories = [
    [
        'title' => 'Emergency Loans',
        'slug' => 'emergency-loans',
        'description' => 'When unexpected expenses arise, our emergency loans provide fast access to funds when you need them most. Get up to $10,000 deposited into your account within 60 minutes* of approval.',
        'image' => get_template_directory_uri() . '/assets/images/loans/emergency-loan.webp',
        'amount' => '$500 - $10,000',
        'term' => '16 days - 24 months',
        'features' => [
            'Same-day approval available',
            'No hidden fees',
            'Flexible repayment options',
            'Bad credit considered'
        ],
        'color' => 'var(--accent-500)'
    ],
    [
        'title' => 'Wedding Loans',
        'slug' => 'wedding-loans',
        'description' => 'Make your special day unforgettable without the financial stress. Our wedding loans help you spread the cost of your dream wedding with manageable repayments.',
        'image' => get_template_directory_uri() . '/assets/images/loans/wedding.webp',
        'amount' => '$2,000 - $25,000',
        'term' => '12 - 36 months',
        'features' => [
            'Cover venue, catering & more',
            'Competitive interest rates',
            'Quick online application',
            'Predictable monthly payments'
        ],
        'color' => '#e75480'
    ],
    [
        'title' => 'Education Loans',
        'slug' => 'education-loans',
        'description' => 'Invest in your future with our education financing options. Cover tuition, books, equipment, or any study-related expenses with our flexible education loans.',
        'image' => get_template_directory_uri() . '/assets/images/loans/education.webp',
        'amount' => '$1,000 - $20,000',
        'term' => '12 - 48 months',
        'features' => [
            'Fund courses & certifications',
            'Equipment & supplies included',
            'Deferred payment options',
            'No early repayment fees'
        ],
        'color' => '#3498db'
    ],
    [
        'title' => 'Travel Loans',
        'slug' => 'travel-loans',
        'description' => 'Turn your travel dreams into reality. Whether it\'s a family vacation, honeymoon, or adventure trip, our travel loans make it possible without depleting your savings.',
        'image' => get_template_directory_uri() . '/assets/images/loans/online.webp',
        'amount' => '$1,000 - $15,000',
        'term' => '6 - 24 months',
        'features' => [
            'Book now, pay later',
            'Cover flights, hotels & tours',
            'Quick approval process',
            'Flexible terms available'
        ],
        'color' => '#27ae60'
    ],
    [
        'title' => 'Bond Loans',
        'slug' => 'bond-loans',
        'description' => 'Moving to a new place? Our bond loans help you cover rental bond deposits quickly, so you can secure your new home without stress.',
        'image' => get_template_directory_uri() . '/assets/images/loans/bond-loan.webp',
        'amount' => '$500 - $5,000',
        'term' => '21 days - 12 months',
        'features' => [
            '21 days interest-free option',
            'Fast approval for renters',
            'Cover bond & moving costs',
            'Simple application process'
        ],
        'color' => '#9b59b6'
    ],
    [
        'title' => 'Car Repair Loans',
        'slug' => 'car-repairs',
        'description' => 'Don\'t let car troubles keep you off the road. Our car repair loans provide quick funding for mechanical repairs, servicing, and maintenance.',
        'image' => get_template_directory_uri() . '/assets/images/loans/car-repairs.webp',
        'amount' => '$500 - $8,000',
        'term' => '6 - 18 months',
        'features' => [
            'Cover any repair costs',
            'Same-day funding available',
            'Work with any mechanic',
            'Affordable repayments'
        ],
        'color' => '#e67e22'
    ],
    [
        'title' => 'Vet Loans',
        'slug' => 'vet-loans',
        'description' => 'Your furry family members deserve the best care. Our vet loans help cover unexpected veterinary bills, surgeries, and ongoing treatments.',
        'image' => get_template_directory_uri() . '/assets/images/loans/vet-loans.webp',
        'amount' => '$500 - $10,000',
        'term' => '6 - 24 months',
        'features' => [
            'Emergency vet care covered',
            'Surgery & treatments included',
            'Quick decisions made',
            'No upfront payments'
        ],
        'color' => '#1abc9c'
    ],
    [
        'title' => 'Cosmetic Loans',
        'slug' => 'cosmetic-loans',
        'description' => 'Finance your cosmetic procedures with confidence. From dental work to aesthetic treatments, our cosmetic loans help you look and feel your best.',
        'image' => get_template_directory_uri() . '/assets/images/loans/cosmetic-surgery.webp',
        'amount' => '$2,000 - $30,000',
        'term' => '12 - 48 months',
        'features' => [
            'All procedures covered',
            'Work with any provider',
            'Discreet application',
            'Flexible payment plans'
        ],
        'color' => '#e74c3c'
    ],
    [
        'title' => 'Medium Loans',
        'slug' => 'medium-loans',
        'description' => 'For those mid-sized expenses that require a bit more flexibility. Our medium loans offer competitive rates for amounts between $2,001 and $5,000.',
        'image' => get_template_directory_uri() . '/assets/images/loans/medium-loans.webp',
        'amount' => '$2,001 - $5,000',
        'term' => '9 weeks - 24 months',
        'features' => [
            'Competitive interest rates',
            'Flexible repayment schedules',
            'No hidden charges',
            'Quick approval process'
        ],
        'color' => '#2980b9'
    ],
    [
        'title' => 'Large Loans',
        'slug' => 'large-loans',
        'description' => 'For significant expenses and major life events. Our large loans provide access to up to $50,000 with flexible terms tailored to your needs.',
        'image' => get_template_directory_uri() . '/assets/images/loans/large-loans.webp',
        'amount' => '$5,001 - $50,000',
        'term' => '12 - 60 months',
        'features' => [
            'Higher loan amounts',
            'Longer repayment terms',
            'Personalised rates',
            'Dedicated support'
        ],
        'color' => '#34495e'
    ]
];
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
                    <img src="<?php echo esc_url($loan['image']); ?>" alt="<?php echo esc_attr($loan['title']); ?>"
                        loading="lazy">
                    <div class="loan-amount-badge" style="background: <?php echo esc_attr($loan['color']); ?>">
                        <?php echo esc_html($loan['amount']); ?>
                    </div>
                </div>
                <div class="loan-category-content">
                    <h2>
                        <?php echo esc_html($loan['title']); ?>
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
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
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
                        <a href="<?php echo esc_url(home_url('/apply')); ?>" class="btn btn-primary">
                            <?php esc_html_e('Apply Now', 'finance-theme'); ?>
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

<!-- CTA Section -->
<section class="section loans-cta-section">
    <div class="container">
        <div class="loans-cta-card">
            <div class="cta-content">
                <h2>
                    <?php esc_html_e('Ready to Get Started?', 'finance-theme'); ?>
                </h2>
                <p>
                    <?php esc_html_e('Apply in just 6 minutes and get your funds the same day. It\'s quick, easy, and 100% online.', 'finance-theme'); ?>
                </p>
            </div>
            <div class="cta-actions">
                <a href="<?php echo esc_url(home_url('/apply')); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e('Apply Now', 'finance-theme'); ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="tel:<?php echo esc_attr(get_theme_mod('flavor_phone', '1300XXXXXX')); ?>"
                    class="btn btn-outline btn-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z" />
                    </svg>
                    <?php esc_html_e('Call Us', 'finance-theme'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>