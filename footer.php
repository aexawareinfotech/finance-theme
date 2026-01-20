<?php
/**
 * Footer Template
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

$phone = get_theme_mod('flavor_phone', '1300 XXX XXX');
$email = get_theme_mod('flavor_email', 'info@fairgofinance.com.au');
$address = get_theme_mod('flavor_address', 'Sydney, NSW, Australia');
$asic_number = get_theme_mod('flavor_asic_number', '');
$afca_number = get_theme_mod('flavor_afca_number', '');
$facebook = get_theme_mod('flavor_facebook', '');
$twitter = get_theme_mod('flavor_twitter', '');
$linkedin = get_theme_mod('flavor_linkedin', '');
$instagram = get_theme_mod('flavor_instagram', '');
?>

</main><!-- #main-content -->

<!-- CTA Section (appears on all pages) -->
<section class="section footer-cta"
    style="background: linear-gradient(135deg, var(--primary-900), var(--primary-700)); text-align: center; color: var(--white);">
    <div class="container">
        <h2 style="color: var(--white); margin-bottom: var(--space-4);">
            <?php esc_html_e('Ready to Get Started?', 'finance-theme'); ?>
        </h2>
        <p style="color: var(--white-80); max-width: 600px; margin: 0 auto var(--space-8);">
            <?php esc_html_e('Apply in just 6 minutes and get your funds the same day. No hidden fees, no surprises.', 'finance-theme'); ?>
        </p>
        <div style="display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap;">
            <a href="<?php echo esc_url(home_url('/apply')); ?>" class="btn btn-primary btn-lg">
                <?php esc_html_e('Apply Now', 'finance-theme'); ?>
            </a>
            <a href="tel:<?php echo esc_attr(get_theme_mod('flavor_phone', '1300XXXXXX')); ?>"
                class="btn btn-outline btn-lg">
                <?php esc_html_e('Call Us', 'finance-theme'); ?>
            </a>
        </div>

        <!-- License Section -->
        <div
            style="background: var(--white); border-radius: var(--radius-xl); padding: var(--space-8); margin-top: var(--space-10); max-width: 700px; margin-left: auto; margin-right: auto;">
            <h3
                style="color: var(--primary-900); font-size: var(--text-lg); font-weight: 600; margin-bottom: var(--space-6); text-align: center;">
                <?php esc_html_e('Licensed by ASIC · Member of AFCA', 'finance-theme'); ?>
            </h3>
            <div
                style="display: flex; justify-content: center; align-items: center; gap: var(--space-10); flex-wrap: wrap;">
                <a href="https://asic.gov.au" target="_blank" rel="noopener noreferrer"
                    style="display: flex; align-items: center;">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/asic-logo.png'); ?>"
                        alt="<?php esc_attr_e('ASIC - Australian Securities & Investments Commission', 'finance-theme'); ?>"
                        style="height: 60px; width: auto;">
                </a>
                <a href="https://afca.org.au" target="_blank" rel="noopener noreferrer"
                    style="display: flex; align-items: center;">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/afca-logo.png'); ?>"
                        alt="<?php esc_attr_e('AFCA - Australian Financial Complaints Authority', 'finance-theme'); ?>"
                        style="height: 60px; width: auto;">
                </a>
            </div>
        </div>
    </div>
</section>

<footer class="site-footer">
    <!-- Main Footer -->
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <!-- Brand Column -->
                <div class="footer-brand">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo">
                        <?php
                        $footer_logo_id = get_theme_mod('flavor_footer_logo', '');
                        if ($footer_logo_id) {
                            echo wp_get_attachment_image($footer_logo_id, 'medium', false, ['class' => 'footer-logo-img']);
                        } elseif (has_custom_logo()) {
                            the_custom_logo();
                        } else { ?>
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="40" height="40" rx="10" fill="#39d25d" />
                                <path d="M12 20c0-4.4 3.6-8 8-8s8 3.6 8 8-3.6 8-8 8" stroke="#fff" stroke-width="3"
                                    stroke-linecap="round" />
                                <path d="M20 16v8M16 20h8" stroke="#fff" stroke-width="2.5" stroke-linecap="round" />
                            </svg>
                            <span>
                                <?php bloginfo('name'); ?>
                            </span>
                        <?php } ?>
                    </a>
                    <p>
                        <?php echo esc_html(get_theme_mod('flavor_footer_tagline', 'Get the funding you need, when you need it. Fair Go Finance provides fast, flexible loans for all Australians.')); ?>
                    </p>

                    <!-- Social Links -->
                    <?php if ($facebook || $twitter || $linkedin || $instagram): ?>
                        <div class="footer-social">
                            <?php if ($facebook): ?>
                                <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener noreferrer"
                                    aria-label="Facebook">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                            <?php if ($twitter): ?>
                                <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener noreferrer"
                                    aria-label="Twitter">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                            <?php if ($linkedin): ?>
                                <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer"
                                    aria-label="LinkedIn">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2zM4 2a2 2 0 1 1 0 4 2 2 0 0 1 0-4z" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                            <?php if ($instagram): ?>
                                <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer"
                                    aria-label="Instagram">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Quick Links -->
                <div class="footer-column">
                    <h4>
                        <?php esc_html_e('Quick Links', 'finance-theme'); ?>
                    </h4>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/')); ?>">
                                <?php esc_html_e('Home', 'finance-theme'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/about')); ?>">
                                <?php esc_html_e('About Us', 'finance-theme'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/how-it-works')); ?>">
                                <?php esc_html_e('How It Works', 'finance-theme'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/blog')); ?>">
                                <?php esc_html_e('Blog', 'finance-theme'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact')); ?>">
                                <?php esc_html_e('Contact', 'finance-theme'); ?>
                            </a></li>
                    </ul>
                </div>

                <!-- Loan Types -->
                <div class="footer-column">
                    <h4>
                        <?php esc_html_e('Our Loans', 'finance-theme'); ?>
                    </h4>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/loans/personal')); ?>">
                                <?php esc_html_e('Personal Loans', 'finance-theme'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/loans/car')); ?>">
                                <?php esc_html_e('Car Loans', 'finance-theme'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/loans/business')); ?>">
                                <?php esc_html_e('Business Loans', 'finance-theme'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/loans/debt-consolidation')); ?>">
                                <?php esc_html_e('Debt Consolidation', 'finance-theme'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/loans')); ?>">
                                <?php esc_html_e('View All Loans', 'finance-theme'); ?>
                            </a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="footer-column">
                    <h4>
                        <?php esc_html_e('Contact Us', 'finance-theme'); ?>
                    </h4>
                    <ul class="footer-contact">
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"
                                aria-label="<?php esc_attr_e('Call us', 'finance-theme'); ?>">
                                <?php echo esc_html($phone); ?>
                            </a>
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                            <a href="mailto:<?php echo esc_attr($email); ?>">
                                <?php echo esc_html($email); ?>
                            </a>
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            <span>
                                <?php echo esc_html($address); ?>
                            </span>
                        </li>
                    </ul>
                </div>

                <?php if (is_active_sidebar('footer-1')): ?>
                    <div class="footer-column footer-widget-area">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-2')): ?>
                    <div class="footer-column footer-widget-area">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>



    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner">
                <p class="copyright">
                    <?php
                    $custom_copyright = get_theme_mod('flavor_copyright', '');
                    if ($custom_copyright) {
                        echo esc_html($custom_copyright);
                    } else {
                        printf(
                            esc_html__('© %1$s %2$s. All rights reserved.', 'finance-theme'),
                            esc_html(date_i18n('Y')),
                            esc_html(get_bloginfo('name'))
                        );
                    }
                    ?>
                </p>
                <nav class="legal-links" aria-label="<?php esc_attr_e('Legal Links', 'finance-theme'); ?>">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'legal',
                        'container' => false,
                        'items_wrap' => '%3$s',
                        'fallback_cb' => function () {
                            ?>
                        <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">
                            <?php esc_html_e('Privacy Policy', 'finance-theme'); ?>
                        </a>
                        <a href="<?php echo esc_url(home_url('/disclaimer')); ?>">
                            <?php esc_html_e('Disclaimer', 'finance-theme'); ?>
                        </a>
                        <a href="<?php echo esc_url(home_url('/terms-conditions')); ?>">
                            <?php esc_html_e('Terms & Conditions', 'finance-theme'); ?>
                        </a>
                        <?php
                        },
                    ]);
                    ?>
                </nav>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>