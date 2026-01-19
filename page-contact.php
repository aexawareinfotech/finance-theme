<?php
/**
 * Page Template: Contact
 * 
 * Automatically used for pages with slug 'contact'
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$phone = get_theme_mod('flavor_phone', '1300 XXX XXX');
$email = get_theme_mod('flavor_email', 'hello@example.com.au');
$address = get_theme_mod('flavor_address', 'Sydney, NSW, Australia');
?>

<?php
// Hero Section
get_template_part('template-parts/page-hero', null, [
    'badge' => __('Contact Us', 'finance-theme'),
    'title' => __("We're Here to", 'finance-theme'),
    'title_accent' => __('Help', 'finance-theme'),
    'subtitle' => __('Have questions about our loans or need assistance with your application? Our friendly team is ready to help you get the support you need.', 'finance-theme'),
]);
?>

<!-- Contact Details Section -->
<section class="section contact-details-section">
    <div class="container">
        <div class="contact-grid">
            <!-- Contact Cards -->
            <div class="contact-cards">
                <div class="contact-card">
                    <div class="contact-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z" />
                        </svg>
                    </div>
                    <h3>
                        <?php esc_html_e('Call Us', 'finance-theme'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Speak directly with our team', 'finance-theme'); ?>
                    </p>
                    <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>" class="contact-link">
                        <?php echo esc_html($phone); ?>
                    </a>
                    <span class="contact-hours">
                        <?php esc_html_e('Mon-Fri: 9am - 5pm AEST', 'finance-theme'); ?>
                    </span>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </div>
                    <h3>
                        <?php esc_html_e('Email Us', 'finance-theme'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Get a response within 24 hours', 'finance-theme'); ?>
                    </p>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-link">
                        <?php echo esc_html($email); ?>
                    </a>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <h3>
                        <?php esc_html_e('Location', 'finance-theme'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Our headquarters', 'finance-theme'); ?>
                    </p>
                    <span class="contact-address">
                        <?php echo esc_html($address); ?>
                    </span>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrapper">
                <div class="contact-form-card">
                    <h2>
                        <?php esc_html_e('Send Us a Message', 'finance-theme'); ?>
                    </h2>
                    <p class="form-subtitle">
                        <?php esc_html_e('Fill out the form below and we\'ll get back to you as soon as possible.', 'finance-theme'); ?>
                    </p>

                    <?php
                    // Check if Contact Form 7 shortcode exists
                    $cf7_shortcode = get_theme_mod('flavor_contact_form_shortcode', '');
                    if ($cf7_shortcode && shortcode_exists('contact-form-7')):
                        echo do_shortcode($cf7_shortcode);
                    else:
                        ?>
                        <form class="contact-form" action="#" method="post">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contact-name">
                                        <?php esc_html_e('Full Name', 'finance-theme'); ?>
                                    </label>
                                    <input type="text" id="contact-name" name="name" required
                                        placeholder="<?php esc_attr_e('Your name', 'finance-theme'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="contact-email">
                                        <?php esc_html_e('Email Address', 'finance-theme'); ?>
                                    </label>
                                    <input type="email" id="contact-email" name="email" required
                                        placeholder="<?php esc_attr_e('your@email.com', 'finance-theme'); ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contact-phone">
                                        <?php esc_html_e('Phone Number', 'finance-theme'); ?>
                                    </label>
                                    <input type="tel" id="contact-phone" name="phone"
                                        placeholder="<?php esc_attr_e('04XX XXX XXX', 'finance-theme'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="contact-subject">
                                        <?php esc_html_e('Subject', 'finance-theme'); ?>
                                    </label>
                                    <select id="contact-subject" name="subject">
                                        <option value="">
                                            <?php esc_html_e('Select a topic', 'finance-theme'); ?>
                                        </option>
                                        <option value="loan-enquiry">
                                            <?php esc_html_e('Loan Enquiry', 'finance-theme'); ?>
                                        </option>
                                        <option value="existing-loan">
                                            <?php esc_html_e('Existing Loan', 'finance-theme'); ?>
                                        </option>
                                        <option value="payment-help">
                                            <?php esc_html_e('Payment Assistance', 'finance-theme'); ?>
                                        </option>
                                        <option value="complaint">
                                            <?php esc_html_e('Complaint', 'finance-theme'); ?>
                                        </option>
                                        <option value="other">
                                            <?php esc_html_e('Other', 'finance-theme'); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group full-width">
                                <label for="contact-message">
                                    <?php esc_html_e('Message', 'finance-theme'); ?>
                                </label>
                                <textarea id="contact-message" name="message" rows="5" required
                                    placeholder="<?php esc_attr_e('How can we help you?', 'finance-theme'); ?>"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <?php esc_html_e('Send Message', 'finance-theme'); ?>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" />
                                </svg>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Quick Links Section -->
<section class="section contact-faq-section">
    <div class="container">
        <div class="section-header">
            <h2>
                <?php esc_html_e('Frequently Asked Questions', 'finance-theme'); ?>
            </h2>
            <p>
                <?php esc_html_e('Find quick answers to common questions.', 'finance-theme'); ?>
            </p>
        </div>

        <div class="faq-quick-grid">
            <a href="<?php echo esc_url(home_url('/#faq')); ?>" class="faq-quick-card">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
                <h4>
                    <?php esc_html_e('How do I apply?', 'finance-theme'); ?>
                </h4>
            </a>
            <a href="<?php echo esc_url(home_url('/#faq')); ?>" class="faq-quick-card">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 6v6l4 2" />
                </svg>
                <h4>
                    <?php esc_html_e('How long does approval take?', 'finance-theme'); ?>
                </h4>
            </a>
            <a href="<?php echo esc_url(home_url('/#faq')); ?>" class="faq-quick-card">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
                <h4>
                    <?php esc_html_e('Is my data secure?', 'finance-theme'); ?>
                </h4>
            </a>
            <a href="<?php echo esc_url(home_url('/#faq')); ?>" class="faq-quick-card">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                </svg>
                <h4>
                    <?php esc_html_e('Bad credit options?', 'finance-theme'); ?>
                </h4>
            </a>
        </div>
    </div>
</section>

<?php
// CTA Section
get_template_part('template-parts/cta-section', null, [
    'style' => 'default',
    'title' => __('Ready to Apply?', 'finance-theme'),
    'subtitle' => __('Skip the wait and apply online now. Get a decision in minutes.', 'finance-theme'),
]);

get_footer();
?>