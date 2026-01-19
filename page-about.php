<?php
/**
 * Page Template: About
 * 
 * Automatically used for pages with slug 'about'
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$company_name = get_bloginfo('name');
$asic_number = get_theme_mod('flavor_asic_number', 'XXXXXX');
$afca_number = get_theme_mod('flavor_afca_number', 'XXXXXX');
?>

<?php
// Hero Section
get_template_part('template-parts/page-hero', null, [
    'badge' => __('About Us', 'finance-theme'),
    'title' => __('Giving Australians a', 'finance-theme'),
    'title_accent' => __('Fair Go', 'finance-theme'),
    'subtitle' => __('We believe everyone deserves access to fair, transparent, and responsible lending. Our mission is simple: to help Australians get the funds they need, when they need them.', 'finance-theme'),
    'show_stats' => true,
    'stats' => [
        ['number' => '10+', 'label' => __('Years Experience', 'finance-theme')],
        ['number' => '50k+', 'label' => __('Happy Customers', 'finance-theme')],
        ['number' => '4.8★', 'label' => __('Customer Rating', 'finance-theme')],
    ]
]);
?>

<!-- Our Story Section -->
<section class="section about-story-section">
    <div class="container">
        <div class="about-story-grid">
            <div class="about-story-content">
                <span class="section-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                    </svg>
                    <?php esc_html_e('Our Story', 'finance-theme'); ?>
                </span>
                <h2>
                    <?php esc_html_e('Built on Trust, Driven by Purpose', 'finance-theme'); ?>
                </h2>
                <p>
                    <?php printf(
                        esc_html__('%s was founded with a simple belief: that everyone deserves a fair chance at financial support. We understand that life doesn\'t always go to plan, and that\'s okay.', 'finance-theme'),
                        esc_html($company_name)
                    ); ?>
                </p>
                <p>
                    <?php esc_html_e('Whether it\'s an unexpected car repair, medical expense, or helping make ends meet between paydays, we\'re here to provide straightforward lending solutions without the judgement.', 'finance-theme'); ?>
                </p>
                <p>
                    <?php esc_html_e('As a proudly Australian-owned lender, we\'re committed to responsible lending practices and treating every customer with the respect they deserve.', 'finance-theme'); ?>
                </p>
            </div>
            <div class="about-story-image">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/australia-people.png'); ?>"
                    alt="<?php esc_attr_e('Our team helping Australians', 'finance-theme'); ?>" loading="lazy">
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="section about-values-section">
    <div class="container">
        <div class="section-header">
            <h2>
                <?php esc_html_e('Our Values', 'finance-theme'); ?>
            </h2>
            <p>
                <?php esc_html_e('The principles that guide everything we do.', 'finance-theme'); ?>
            </p>
        </div>

        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                </div>
                <h3>
                    <?php esc_html_e('Transparency', 'finance-theme'); ?>
                </h3>
                <p>
                    <?php esc_html_e('No hidden fees, no surprises. We believe in clear communication and honest pricing from start to finish.', 'finance-theme'); ?>
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 6v6l4 2" />
                    </svg>
                </div>
                <h3>
                    <?php esc_html_e('Speed', 'finance-theme'); ?>
                </h3>
                <p>
                    <?php esc_html_e('We know time matters. Our streamlined process means fast decisions and same-day funding when you need it most.', 'finance-theme'); ?>
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                    </svg>
                </div>
                <h3>
                    <?php esc_html_e('Fairness', 'finance-theme'); ?>
                </h3>
                <p>
                    <?php esc_html_e('We look beyond credit scores. Everyone deserves a fair assessment based on their complete financial picture.', 'finance-theme'); ?>
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <h3>
                    <?php esc_html_e('Responsibility', 'finance-theme'); ?>
                </h3>
                <p>
                    <?php esc_html_e('We lend responsibly. Our assessments ensure loans are suitable and affordable for each customer.', 'finance-theme'); ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Trust & Compliance Section -->
<section class="section about-trust-section">
    <div class="container">
        <div class="trust-content">
            <h2>
                <?php esc_html_e('Licensed & Regulated', 'finance-theme'); ?>
            </h2>
            <p>
                <?php printf(
                    esc_html__('%s holds an Australian Credit Licence issued by the Australian Securities and Investments Commission (ASIC) and is a member of the Australian Financial Complaints Authority (AFCA).', 'finance-theme'),
                    esc_html($company_name)
                ); ?>
            </p>

            <div class="trust-badges">
                <div class="trust-badge">
                    <span class="badge-label">
                        <?php esc_html_e('ASIC Credit Licence', 'finance-theme'); ?>
                    </span>
                    <span class="badge-number">
                        <?php echo esc_html($asic_number); ?>
                    </span>
                </div>
                <div class="trust-badge">
                    <span class="badge-label">
                        <?php esc_html_e('AFCA Member', 'finance-theme'); ?>
                    </span>
                    <span class="badge-number">
                        <?php echo esc_html($afca_number); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// CTA Section
get_template_part('template-parts/cta-section', null, [
    'style' => 'card',
    'title' => __('Ready to Get a Fair Go?', 'finance-theme'),
    'subtitle' => __('Apply online in minutes. Fast approval, flexible terms, and support every step of the way.', 'finance-theme'),
]);

get_footer();
?>