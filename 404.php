<?php
/**
 * 404 Template
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<section class="error-404"
    style="min-height: 80vh; display: flex; align-items: center; justify-content: center; text-align: center; padding-top: 80px;">
    <div class="container">
        <div style="max-width: 600px; margin: 0 auto;">
            <div
                style="font-size: 120px; font-weight: 800; color: var(--accent-500); line-height: 1; font-family: var(--font-heading);">
                404</div>
            <h1 style="margin: var(--space-4) 0;">
                <?php esc_html_e('Page Not Found', 'finance-theme'); ?>
            </h1>
            <p style="color: var(--primary-600); margin-bottom: var(--space-8);">
                <?php esc_html_e('Oops! The page you\'re looking for doesn\'t exist or has been moved.', 'finance-theme'); ?>
            </p>
            <div style="display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap;">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                    <?php esc_html_e('Go Home', 'finance-theme'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-secondary">
                    <?php esc_html_e('Contact Us', 'finance-theme'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
