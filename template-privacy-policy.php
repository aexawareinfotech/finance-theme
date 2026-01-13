<?php
/**
 * Template Name: Privacy Policy
 * Description: Privacy Policy page template
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<article class="legal-page" style="padding-top: 100px;">
    <div class="container" style="max-width: 900px;">
        <header class="page-header" style="margin-bottom: var(--space-8);">
            <h1>
                <?php esc_html_e('Privacy Policy', 'flavor'); ?>
            </h1>
            <p style="color: var(--primary-600);">
                <?php printf(esc_html__('Last updated: %s', 'flavor'), date('F j, Y')); ?>
            </p>
        </header>

        <div class="legal-content" style="line-height: 1.8;">
            <?php if (have_posts()):
                while (have_posts()):
                    the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; else: ?>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('1. Introduction', 'flavor'); ?>
                    </h2>
                    <p>
                        <?php echo esc_html(get_bloginfo('name')); ?> ("we", "us", "our") is committed to protecting your
                        privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information
                        when you visit our website or use our services.
                    </p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('2. Information We Collect', 'flavor'); ?>
                    </h2>
                    <p>We may collect personal information that you voluntarily provide to us when you:</p>
                    <ul style="margin: var(--space-4) 0; padding-left: var(--space-6); list-style: disc;">
                        <li>Apply for a loan or financial product</li>
                        <li>Register on our website</li>
                        <li>Subscribe to our newsletter</li>
                        <li>Contact us with inquiries</li>
                        <li>Participate in surveys or promotions</li>
                    </ul>
                    <p>This information may include your name, email address, phone number, postal address, date of birth,
                        financial information, employment details, and identification documents.</p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('3. How We Use Your Information', 'flavor'); ?>
                    </h2>
                    <p>We use the information we collect to:</p>
                    <ul style="margin: var(--space-4) 0; padding-left: var(--space-6); list-style: disc;">
                        <li>Process and assess your loan applications</li>
                        <li>Provide and manage our services</li>
                        <li>Communicate with you about your account</li>
                        <li>Send promotional communications (with your consent)</li>
                        <li>Comply with legal and regulatory requirements</li>
                        <li>Prevent fraud and enhance security</li>
                    </ul>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('4. Disclosure of Your Information', 'flavor'); ?>
                    </h2>
                    <p>We may share your information with:</p>
                    <ul style="margin: var(--space-4) 0; padding-left: var(--space-6); list-style: disc;">
                        <li>Credit reporting bodies</li>
                        <li>Identity verification services</li>
                        <li>Our business partners and service providers</li>
                        <li>Regulatory authorities as required by law</li>
                        <li>Professional advisers (lawyers, accountants)</li>
                    </ul>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('5. Your Rights Under Australian Privacy Law', 'flavor'); ?>
                    </h2>
                    <p>Under the Australian Privacy Act 1988, you have the right to:</p>
                    <ul style="margin: var(--space-4) 0; padding-left: var(--space-6); list-style: disc;">
                        <li>Access the personal information we hold about you</li>
                        <li>Request correction of inaccurate information</li>
                        <li>Make a privacy complaint</li>
                        <li>Opt out of direct marketing communications</li>
                    </ul>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('6. Credit Reporting', 'flavor'); ?>
                    </h2>
                    <p>As an Australian Credit Licensee, we may disclose your credit information to credit reporting bodies.
                        This information includes your credit liability information, repayment history, and any defaults or
                        serious credit infringements.</p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('7. Data Security', 'flavor'); ?>
                    </h2>
                    <p>We implement appropriate technical and organisational measures to protect your personal information
                        against unauthorised access, alteration, disclosure, or destruction.</p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('8. Contact Us', 'flavor'); ?>
                    </h2>
                    <p>If you have questions about this Privacy Policy or wish to exercise your rights, please contact us
                        at:</p>
                    <p>
                        <strong>
                            <?php echo esc_html(get_bloginfo('name')); ?>
                        </strong><br>
                        Email:
                        <?php echo esc_html(get_theme_mod('flavor_email', 'privacy@fairgofinance.com.au')); ?><br>
                        Phone:
                        <?php echo esc_html(get_theme_mod('flavor_phone', '1300 XXX XXX')); ?>
                    </p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('9. Complaints', 'flavor'); ?>
                    </h2>
                    <p>If you are not satisfied with our response, you may lodge a complaint with:</p>
                    <p>
                        <strong>Office of the Australian Information Commissioner (OAIC)</strong><br>
                        Website: <a href="https://www.oaic.gov.au" target="_blank" rel="noopener">www.oaic.gov.au</a><br>
                        Phone: 1300 363 992
                    </p>
                </section>

            <?php endif; ?>
        </div>
    </div>
</article>

<?php
get_footer();
