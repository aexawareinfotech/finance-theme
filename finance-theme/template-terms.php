<?php
/**
 * Template Name: Terms and Conditions
 * Description: Terms and Conditions page template
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
                <?php esc_html_e('Terms & Conditions', 'finance-theme'); ?>
            </h1>
            <p style="color: var(--primary-600);">
                <?php printf(esc_html__('Last updated: %s', 'finance-theme'), date('F j, Y')); ?>
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
                        <?php esc_html_e('1. Acceptance of Terms', 'finance-theme'); ?>
                    </h2>
                    <p>By accessing and using this website, you accept and agree to be bound by these Terms and Conditions.
                        If you do not agree to these terms, please do not use this website.</p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('2. About Us', 'finance-theme'); ?>
                    </h2>
                    <p>
                        <?php echo esc_html(get_bloginfo('name')); ?> is an Australian company that provides personal and
                        business lending services. We hold an Australian Credit Licence issued by the Australian Securities
                        and Investments Commission (ASIC) and are a member of the Australian Financial Complaints Authority
                        (AFCA).
                    </p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('3. Use of Website', 'finance-theme'); ?>
                    </h2>
                    <p>You may use this website for lawful purposes only. You must not:</p>
                    <ul style="margin: var(--space-4) 0; padding-left: var(--space-6); list-style: disc;">
                        <li>Use the website in any way that breaches applicable laws or regulations</li>
                        <li>Use the website in any way that is fraudulent or harmful</li>
                        <li>Transmit or upload any material that contains viruses or malicious code</li>
                        <li>Attempt to gain unauthorised access to our systems</li>
                        <li>Reproduce, duplicate, or copy any part of the website without permission</li>
                    </ul>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('4. Loan Applications', 'finance-theme'); ?>
                    </h2>
                    <p>When you submit a loan application through our website:</p>
                    <ul style="margin: var(--space-4) 0; padding-left: var(--space-6); list-style: disc;">
                        <li>You warrant that all information provided is true, accurate, and complete</li>
                        <li>You authorise us to verify your information with third parties</li>
                        <li>You acknowledge that approval is subject to our credit assessment criteria</li>
                        <li>You understand that submitting an application does not guarantee loan approval</li>
                    </ul>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('5. Credit Checks', 'finance-theme'); ?>
                    </h2>
                    <p>By applying for a loan, you consent to us conducting credit checks and obtaining information from
                        credit reporting bodies. This may affect your credit score. We may also provide information to
                        credit reporting bodies about your loan if approved.</p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('6. Intellectual Property', 'finance-theme'); ?>
                    </h2>
                    <p>All content on this website, including text, graphics, logos, images, and software, is the property
                        of
                        <?php echo esc_html(get_bloginfo('name')); ?> or its licensors and is protected by Australian and
                        international copyright laws.
                    </p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('7. Limitation of Liability', 'finance-theme'); ?>
                    </h2>
                    <p>To the extent permitted by law, we exclude all warranties, representations, and guarantees relating
                        to this website and its content. We will not be liable for any loss or damage arising from your use
                        of this website, including any indirect, special, or consequential loss.</p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('8. Indemnity', 'finance-theme'); ?>
                    </h2>
                    <p>You agree to indemnify and hold harmless
                        <?php echo esc_html(get_bloginfo('name')); ?>, its officers, directors, employees, and agents from
                        any claims, losses, or damages arising from your use of this website or breach of these Terms and
                        Conditions.
                    </p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('9. Privacy', 'finance-theme'); ?>
                    </h2>
                    <p>Your use of this website is also governed by our <a
                            href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a>, which describes
                        how we collect, use, and protect your personal information.</p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('10. Changes to Terms', 'finance-theme'); ?>
                    </h2>
                    <p>We reserve the right to modify these Terms and Conditions at any time. Changes will be effective
                        immediately upon posting to this website. Your continued use of the website after changes are posted
                        constitutes your acceptance of the revised terms.</p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('11. Governing Law', 'finance-theme'); ?>
                    </h2>
                    <p>These Terms and Conditions are governed by the laws of Australia. Any disputes arising from these
                        terms will be subject to the exclusive jurisdiction of the courts of Australia.</p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('12. Contact', 'finance-theme'); ?>
                    </h2>
                    <p>If you have any questions about these Terms and Conditions, please contact us at:</p>
                    <p>
                        <strong>
                            <?php echo esc_html(get_bloginfo('name')); ?>
                        </strong><br>
                        Email:
                        <?php echo esc_html(get_theme_mod('flavor_email', 'info@fairgofinance.com.au')); ?><br>
                        Phone:
                        <?php echo esc_html(get_theme_mod('flavor_phone', '1300 XXX XXX')); ?>
                    </p>
                </section>

            <?php endif; ?>
        </div>
    </div>
</article>

<?php
get_footer();
