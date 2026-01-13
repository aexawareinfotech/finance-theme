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
?>

<!-- Hero Section -->
<section class="hero" id="hero">
    <div class="container">
        <div class="hero-grid">
            <!-- Left Content -->
            <div class="hero-left">
                <h1 class="hero-title">
                    <?php esc_html_e('Need', 'flavor'); ?>
                    <span class="text-accent"><?php esc_html_e('Money?', 'flavor'); ?></span>
                </h1>
                <p class="hero-subtitle">
                    <?php esc_html_e('Get up to $50,000 paid within 60 min*', 'flavor'); ?>
                </p>

                <ul class="hero-features">
                    <li>
                        <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        <span><?php esc_html_e('Borrow from $2,000 to $50,000', 'flavor'); ?></span>
                    </li>
                    <li>
                        <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        <span><?php esc_html_e('Digital & Paperless Journey', 'flavor'); ?></span>
                    </li>
                    <li>
                        <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        <span><?php esc_html_e('Proudly Australian Lender', 'flavor'); ?></span>
                    </li>
                    <li>
                        <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        <span><?php esc_html_e('Instant Decisions and Same-Day Cash', 'flavor'); ?></span>
                    </li>
                </ul>
            </div>

            <!-- Right Calculator Card -->
            <div class="hero-right">
                <div class="calculator-card">
                    <h3 class="calculator-title"><?php esc_html_e("I'd like to borrow", 'flavor'); ?></h3>

                    <div class="calculator-amount" id="loan-amount-display">$5,000</div>

                    <div class="calculator-slider-wrap">
                        <input type="range" id="loan-amount-slider" class="calculator-slider" min="2000" max="50000"
                            step="500" value="5000">
                        <div class="slider-labels">
                            <span>$2,000</span>
                            <span>$50,000</span>
                        </div>
                    </div>

                    <a href="<?php echo esc_url(home_url('/apply')); ?>" class="btn btn-primary btn-block">
                        <?php esc_html_e('Apply Now', 'flavor'); ?>
                    </a>
                </div>

                <p class="hero-note"><?php esc_html_e('Online application in minutes!', 'flavor'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Loan Types Slider Section -->
<section class="section loan-types-section" id="loans">
    <div class="container">
        <div class="loan-types-header">
            <h2><?php esc_html_e("Online Loans for all Life's Moments", 'flavor'); ?></h2>
            <a href="<?php echo esc_url(home_url('/loans')); ?>" class="btn btn-outline-dark">
                <?php esc_html_e('View All Personal Loans', 'flavor'); ?>
            </a>
        </div>

        <div class="loan-types-slider" id="loan-slider">
            <div class="loan-types-track" id="loan-slider-track">
                <?php
                $loan_cards = [
                    [
                        'title' => 'Emergency Loans',
                        'description' => 'Get yourself unstuck and borrow up to $10,000 for emergencies.',
                        'image' => get_template_directory_uri() . '/assets/images/loans/emergency-loan.jpg',
                    ],
                    [
                        'title' => 'Wedding Loans',
                        'description' => 'Spread the costs of your big day with a loan up to $10,000.',
                        'image' => get_template_directory_uri() . '/assets/images/loans/wedding.jpg',
                    ],
                    [
                        'title' => 'Education Loans',
                        'description' => 'This smarter personal loan can help with all things related to studying.',
                        'image' => get_template_directory_uri() . '/assets/images/loans/education.jpg',
                    ],
                    [
                        'title' => 'Travel Loans',
                        'description' => 'Take a well-deserved break with up to $10,000 for your adventure.',
                        'image' => get_template_directory_uri() . '/assets/images/loans/online.jpg',
                    ],
                    [
                        'title' => 'Bond Loans',
                        'description' => 'Our 21-day interest-free bond loans lend a hand on moving day.',
                        'image' => get_template_directory_uri() . '/assets/images/loans/bond-loan.jpg',
                    ],
                    [
                        'title' => 'Car Repairs',
                        'description' => 'Get your car back on the road quickly with repair financing.',
                        'image' => get_template_directory_uri() . '/assets/images/loans/car-repairs.jpg',
                    ],
                    [
                        'title' => 'Household Bills',
                        'description' => 'Cover unexpected household expenses when you need it most.',
                        'image' => get_template_directory_uri() . '/assets/images/loans/online.jpg',
                    ],
                    [
                        'title' => 'Vet Loans',
                        'description' => 'Take care of your furry friends with quick vet expense financing.',
                        'image' => get_template_directory_uri() . '/assets/images/loans/vet-loans.jpg',
                    ],
                    [
                        'title' => 'Cosmetic Loans',
                        'description' => 'Finance your cosmetic procedures with flexible payment options.',
                        'image' => get_template_directory_uri() . '/assets/images/loans/cosmetic-surgery.jpg',
                    ],
                    [
                        'title' => 'Medium Loans',
                        'description' => 'Borrow between $2,001 to $5,000 for medium-sized expenses.',
                        'image' => get_template_directory_uri() . '/assets/images/loans/medium-loans.jpg',
                    ],
                    [
                        'title' => 'Large Loans',
                        'description' => 'Access up to $50,000 for major purchases and investments.',
                        'image' => get_template_directory_uri() . '/assets/images/loans/large-loans.jpg',
                    ],
                ];

                foreach ($loan_cards as $loan):
                    ?>
                    <a href="<?php echo esc_url(home_url('/apply')); ?>" class="loan-type-card">
                        <div class="loan-type-image">
                            <img src="<?php echo esc_url($loan['image']); ?>" alt="<?php echo esc_attr($loan['title']); ?>"
                                loading="lazy">
                        </div>
                        <div class="loan-type-content">
                            <h3><?php echo esc_html($loan['title']); ?></h3>
                            <p><?php echo esc_html($loan['description']); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="slider-nav">
            <button class="slider-btn slider-btn-prev" id="slider-prev"
                aria-label="<?php esc_attr_e('Previous', 'flavor'); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </button>
            <div class="slider-progress">
                <div class="slider-progress-bar" id="slider-progress"></div>
            </div>
            <button class="slider-btn slider-btn-next" id="slider-next"
                aria-label="<?php esc_attr_e('Next', 'flavor'); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="section process-section" id="process">
    <div class="container">
        <div class="section-header">
            <h2>
                <?php esc_html_e('Our Process', 'flavor'); ?>
            </h2>
            <p>
                <?php esc_html_e('How Fair Go Finance works - quick, easy, and transparent.', 'flavor'); ?>
            </p>
        </div>

        <div class="process-grid">
            <!-- Step 1 -->
            <div class="process-step">
                <div class="process-number">1</div>
                <h3>
                    <?php esc_html_e('Apply Now', 'flavor'); ?>
                </h3>
                <p>
                    <?php esc_html_e('Our online application takes just six minutes to complete.', 'flavor'); ?>
                </p>
            </div>

            <!-- Step 2 -->
            <div class="process-step">
                <div class="process-number">2</div>
                <h3>
                    <?php esc_html_e('Accept Our Offer', 'flavor'); ?>
                </h3>
                <p>
                    <?php esc_html_e('We send you the loan terms. You accept with a secure SMS code. It couldn\'t be easier.', 'flavor'); ?>
                </p>
            </div>

            <!-- Step 3 -->
            <div class="process-step">
                <div class="process-number">3</div>
                <h3>
                    <?php esc_html_e('Get Your Funds', 'flavor'); ?>
                </h3>
                <p>
                    <?php esc_html_e('Our real-time funding means your funds are in your account on the same day.', 'flavor'); ?>
                </p>
            </div>

            <!-- Step 4 -->
            <div class="process-step">
                <div class="process-number">4</div>
                <h3>
                    <?php esc_html_e('Stay Supported', 'flavor'); ?>
                </h3>
                <p>
                    <?php esc_html_e('We stick around to help with repayments, questions and credit score boosts.', 'flavor'); ?>
                </p>
            </div>
        </div>

        <div class="text-center" style="margin-top: var(--space-10);">
            <a href="<?php echo esc_url(home_url('/apply')); ?>" class="btn btn-primary btn-lg">
                <?php esc_html_e('Start Your Application', 'flavor'); ?>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Trusted by Australians Section -->
<section class="section australia-section" id="about">
    <div class="container">
        <div class="australia-grid">
            <div class="australia-content">
                <h2><?php esc_html_e('Trusted by Australians', 'flavor'); ?></h2>
                <p class="australia-intro">
                    <?php
                    $company_name = get_bloginfo('name');
                    $asic_number = get_theme_mod('flavor_asic_number', 'XXXXXX');
                    $afca_number = get_theme_mod('flavor_afca_number', 'XXXXXX');
                    printf(
                        esc_html__('%s holds Australian Credit Licence %s and is a member of AFCA (%s). We provide straightforward loan options that put transparency, security, and responsible lending first.', 'flavor'),
                        esc_html($company_name),
                        esc_html($asic_number),
                        esc_html($afca_number)
                    );
                    ?>
                </p>

                <ul class="australia-features">
                    <li>
                        <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points=" 20 6 9 17 4 12" />
                        </svg>
                        <span><?php esc_html_e('100% Australian owned', 'flavor'); ?></span>
                    </li>
                    <li>
                        <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        <span><?php esc_html_e('Bad Credit? No Problem.', 'flavor'); ?></span>
                    </li>
                    <li>
                        <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        <span>
                            <?php esc_html_e('100% Secure Process', 'flavor'); ?>
                        </span>
                    </li>
                </ul>

                <a href="<?php echo esc_url(home_url('/apply')); ?>" class="btn btn-australia">
                    <?php esc_html_e('Apply Now', 'flavor'); ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
                <p class="australia-note">
                    <?php esc_html_e('Safe and Secure. 5 min application*', 'flavor'); ?>
                </p>
            </div>

            <div class="australia-image">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/australia-people.png'); ?>"
                    alt="<?php esc_attr_e('Australia made of people', 'flavor'); ?>" loading="lazy">
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section testimonials-section" id="testimonials">
    <div class="container">
        <div class="section-header">
            <h2>
                <?php esc_html_e('What Our Customers Say', 'flavor'); ?>
            </h2>
            <p>
                <?php esc_html_e('Don\'t just take our word for it - hear from real customers who got a fair go.', 'flavor'); ?>
            </p>
        </div>

        <div class="testimonials-grid">
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
    </div>
</section>

<!-- FAQ Section -->
<section class="section faq-section" id="faq">
    <div class="container">
        <div class="section-header">
            <h2>
                <?php esc_html_e('Frequently Asked Questions', 'flavor'); ?>
            </h2>
            <p>
                <?php esc_html_e('Got questions? We\'ve got answers.', 'flavor'); ?>
            </p>
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

<!-- Latest Blogs Section -->
<section class="section blog-section" id="blog">
    <div class="container">
        <div class="section-header">
            <h2>
                <?php esc_html_e('Latest from Our Blog', 'flavor'); ?>
            </h2>
            <p>
                <?php esc_html_e('Tips, insights, and news about personal finance in Australia.', 'flavor'); ?>
            </p>
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
                                <?php esc_html_e('Read More', 'flavor'); ?>
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
                                <?php esc_html_e('Read More', 'flavor'); ?>
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
                <?php esc_html_e('View All Posts', 'flavor'); ?>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section"
    style="background: linear-gradient(135deg, var(--primary-900), var(--primary-700)); text-align: center; color: var(--white);">
    <div class="container">
        <h2 style="color: var(--white); margin-bottom: var(--space-4);">
            <?php esc_html_e('Ready to Get Started?', 'flavor'); ?>
        </h2>
        <p style="color: var(--white-80); max-width: 600px; margin: 0 auto var(--space-8);">
            <?php esc_html_e('Apply in just 6 minutes and get your funds the same day. No hidden fees, no surprises.', 'flavor'); ?>
        </p>
        <div style="display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap;">
            <a href="<?php echo esc_url(home_url('/apply')); ?>" class="btn btn-primary btn-lg">
                <?php esc_html_e('Apply Now', 'flavor'); ?>
            </a>
            <a href="tel:<?php echo esc_attr(get_theme_mod('flavor_phone', '1300XXXXXX')); ?>"
                class="btn btn-outline btn-lg">
                <?php esc_html_e('Call Us', 'flavor'); ?>
            </a>
        </div>
    </div>
</section>

<?php
get_footer();

