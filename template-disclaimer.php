<?php
/**
 * Template Name: Disclaimer
 * Description: Financial services disclaimer page template
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
                <?php esc_html_e('Disclaimer', 'flavor'); ?>
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

                <div
                    style="background: var(--accent-300); padding: var(--space-6); border-radius: var(--radius-lg); margin-bottom: var(--space-8);">
                    <p style="margin: 0; font-weight: 600; color: var(--primary-900);">
                        <strong>Important Notice:</strong>
                        <?php echo esc_html(get_bloginfo('name')); ?> holds an Australian Credit Licence issued by the
                        Australian Securities and Investments Commission (ASIC) and is a member of the Australian Financial
                        Complaints Authority (AFCA).
                    </p>
                </div>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('General Information Only', 'flavor'); ?>
                    </h2>
                    <p>The information provided on this website is for general informational purposes only. It does not
                        constitute financial advice, credit assistance, or a recommendation for any particular loan product.
                        You should consider seeking independent legal, financial, taxation, or other advice to check how the
                        information relates to your unique circumstances.</p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('Credit Assessment', 'flavor'); ?>
                    </h2>
                    <p>All loan applications are subject to our credit assessment criteria and approval process. We are
                        required by responsible lending laws to assess whether a credit product is suitable for you, taking
                        into account your requirements, objectives, and financial situation. Approval, loan amount, and
                        terms are subject to this assessment.</p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('Interest Rates and Fees', 'flavor'); ?>
                    </h2>
                    <p>Interest rates, fees, and charges mentioned on this website are indicative only and may vary based on
                        individual circumstances. The actual rate and terms you receive will depend on factors including
                        your credit history, income, loan amount, and loan term. Please refer to your loan contract for the
                        specific terms applicable to your loan.</p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('Comparison Rates', 'flavor'); ?>
                    </h2>
                    <p>WARNING: Comparison rates are true only for the examples given and may not include all fees and
                        charges. Different terms, fees, or other loan amounts might result in a different comparison rate.
                    </p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('Credit Reporting', 'flavor'); ?>
                    </h2>
                    <p>Applying for a loan will result in a credit enquiry being recorded on your credit file. Multiple
                        credit enquiries in a short period may affect your credit score. We may obtain information about you
                        from credit reporting bodies and other sources as part of our credit assessment process.</p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('External Links', 'flavor'); ?>
                    </h2>
                    <p>This website may contain links to external websites. We are not responsible for the content, privacy
                        policies, or practices of any third-party websites. Accessing linked websites is at your own risk.
                    </p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('No Guarantees', 'flavor'); ?>
                    </h2>
                    <p>While we strive to provide accurate and up-to-date information, we make no warranties or
                        representations about the accuracy, reliability, completeness, or timeliness of any information on
                        this website. Your use of the information on this website is at your own risk.</p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('Limitation of Liability', 'flavor'); ?>
                    </h2>
                    <p>To the maximum extent permitted by law, we exclude all liability for any loss or damage arising from
                        the use of this website or reliance on any information contained herein, including but not limited
                        to direct, indirect, incidental, special, or consequential damages.</p>
                </section>

                <section style="margin-bottom: var(--space-8);">
                    <h2>
                        <?php esc_html_e('Regulatory Information', 'flavor'); ?>
                    </h2>
                    <p>
                        <?php echo esc_html(get_bloginfo('name')); ?> is:<br>
                        • Licensed by the Australian Securities and Investments Commission (ASIC)
                        <?php $asic = get_theme_mod('flavor_asic_number');
                        echo $asic ? ' - ACL: ' . esc_html($asic) : ''; ?><br>
                        • A member of the Australian Financial Complaints Authority (AFCA)
                        <?php $afca = get_theme_mod('flavor_afca_number');
                        echo $afca ? ' - Member: ' . esc_html($afca) : ''; ?>
                    </p>
                </section>

            <?php endif; ?>
        </div>
    </div>
</article>

<?php
get_footer();
