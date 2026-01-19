<?php
/**
 * Template Part: Features Row
 * 
 * Reusable section showing key features/benefits (Fast, Personal, Progress)
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<section class="features-row-section">
    <div class="container">
        <div class="features-row-grid">
            <!-- Feature 1: Fast -->
            <div class="feature-row-item">
                <div class="feature-row-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <div class="feature-row-content">
                    <h3>
                        <?php esc_html_e('Fast', 'finance-theme'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Apply in minutes. Funds in 15 once approved.', 'finance-theme'); ?>
                    </p>
                </div>
            </div>

            <!-- Feature 2: Personal -->
            <div class="feature-row-item">
                <div class="feature-row-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <div class="feature-row-content">
                    <h3>
                        <?php esc_html_e('Personal', 'finance-theme'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('A tailored rate that fits you. Not one-size-fits-all.', 'finance-theme'); ?>
                    </p>
                </div>
            </div>

            <!-- Feature 3: Progress -->
            <div class="feature-row-item">
                <div class="feature-row-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <div class="feature-row-content">
                    <h3>
                        <?php esc_html_e('Progress', 'finance-theme'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('On-time repayments boost your credit score.', 'finance-theme'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>