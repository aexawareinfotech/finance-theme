<?php
/**
 * Template Part: CTA Section
 * 
 * A reusable call-to-action section for page templates.
 * 
 * Usage:
 * get_template_part('template-parts/cta-section', null, [
 *     'title' => 'Ready to Get Started?',
 *     'subtitle' => 'Apply in just 6 minutes...',
 *     'style' => 'default', // 'default', 'card', or 'minimal'
 *     'apply_url' => '/apply', // Custom apply URL
 * ]);
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get passed arguments with defaults
$title = $args['title'] ?? __('Ready to Get Started?', 'finance-theme');
$subtitle = $args['subtitle'] ?? __('Apply in just 6 minutes and get your funds the same day. No hidden fees, no surprises.', 'finance-theme');
$style = $args['style'] ?? 'default';
$show_phone = $args['show_phone'] ?? true;
$apply_url = $args['apply_url'] ?? home_url('/apply');
?>

<?php if ($style === 'card'): ?>
    <!-- Card Style CTA -->
    <section class="section cta-section cta-section-card">
        <div class="container">
            <div class="cta-card">
                <div class="cta-content">
                    <h2>
                        <?php echo esc_html($title); ?>
                    </h2>
                    <p>
                        <?php echo esc_html($subtitle); ?>
                    </p>
                </div>
                <div class="cta-actions">
                    <a href="<?php echo esc_url($apply_url); ?>" class="btn btn-primary btn-lg">
                        <?php esc_html_e('Apply Now', 'finance-theme'); ?>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                    <?php if ($show_phone): ?>
                        <a href="tel:<?php echo esc_attr(get_theme_mod('flavor_phone', '1300XXXXXX')); ?>"
                            class="btn btn-outline btn-lg">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path
                                    d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z" />
                            </svg>
                            <?php esc_html_e('Call Us', 'finance-theme'); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div style="display: flex; align-items: center; justify-content: center; gap: var(--space-6); margin-top: var(--space-8); flex-wrap: wrap;">
                    <span style="color: var(--white-80); font-size: var(--text-sm);"><?php esc_html_e('Licensed by ASIC', 'finance-theme'); ?> · <?php esc_html_e('Member of AFCA', 'finance-theme'); ?></span>
                    <div style="display: flex; gap: var(--space-4); align-items: center;">
                        <a href="https://asic.gov.au" target="_blank" rel="noopener noreferrer" style="display: flex; background: var(--white); padding: var(--space-2) var(--space-3); border-radius: var(--radius-md);">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/asic-logo.png'); ?>" alt="ASIC" style="height: 28px; width: auto;">
                        </a>
                        <a href="https://afca.org.au" target="_blank" rel="noopener noreferrer" style="display: flex; background: var(--white); padding: var(--space-2) var(--space-3); border-radius: var(--radius-md);">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/afca-logo.png'); ?>" alt="AFCA" style="height: 28px; width: auto;">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <!-- Default Full-Width CTA -->
    <section class="section cta-section cta-section-default">
        <div class="container">
            <h2>
                <?php echo esc_html($title); ?>
            </h2>
            <p>
                <?php echo esc_html($subtitle); ?>
            </p>
            <div class="cta-buttons">
                <a href="<?php echo esc_url($apply_url); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e('Apply Now', 'finance-theme'); ?>
                </a>
                <?php if ($show_phone): ?>
                    <a href="tel:<?php echo esc_attr(get_theme_mod('flavor_phone', '1300XXXXXX')); ?>"
                        class="btn btn-outline btn-lg">
                        <?php esc_html_e('Call Us', 'finance-theme'); ?>
                    </a>
                <?php endif; ?>
            </div>
            <div style="display: flex; align-items: center; justify-content: center; gap: var(--space-6); margin-top: var(--space-8); flex-wrap: wrap;">
                <span style="color: var(--white-80); font-size: var(--text-sm);"><?php esc_html_e('Licensed by ASIC', 'finance-theme'); ?> · <?php esc_html_e('Member of AFCA', 'finance-theme'); ?></span>
                <div style="display: flex; gap: var(--space-4); align-items: center;">
                    <a href="https://asic.gov.au" target="_blank" rel="noopener noreferrer" style="display: flex; background: var(--white); padding: var(--space-2) var(--space-3); border-radius: var(--radius-md);">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/asic-logo.png'); ?>" alt="ASIC" style="height: 28px; width: auto;">
                    </a>
                    <a href="https://afca.org.au" target="_blank" rel="noopener noreferrer" style="display: flex; background: var(--white); padding: var(--space-2) var(--space-3); border-radius: var(--radius-md);">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/afca-logo.png'); ?>" alt="AFCA" style="height: 28px; width: auto;">
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>