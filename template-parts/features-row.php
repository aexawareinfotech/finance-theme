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

// Get values from current post (loan) or use defaults
global $post;
$feature_1_title = get_post_meta($post->ID, '_features_row_1_title', true) ?: 'Fast';
$feature_1_desc = get_post_meta($post->ID, '_features_row_1_desc', true) ?: 'Apply in minutes. Funds in 15 once approved.';

$feature_2_title = get_post_meta($post->ID, '_features_row_2_title', true) ?: 'Personal';
$feature_2_desc = get_post_meta($post->ID, '_features_row_2_desc', true) ?: 'A tailored rate that fits you. Not one-size-fits-all.';

$feature_3_title = get_post_meta($post->ID, '_features_row_3_title', true) ?: 'Progress';
$feature_3_desc = get_post_meta($post->ID, '_features_row_3_desc', true) ?: 'On-time repayments boost your credit score.';
?>

<section class="features-row-section">
    <div class="container">
        <div class="features-row-grid">
            <!-- Feature 1 -->
            <div class="feature-row-item">
                <div class="feature-row-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <div class="feature-row-content">
                    <h3>
                        <?php echo esc_html($feature_1_title); ?>
                    </h3>
                    <p>
                        <?php echo esc_html($feature_1_desc); ?>
                    </p>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="feature-row-item">
                <div class="feature-row-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <div class="feature-row-content">
                    <h3>
                        <?php echo esc_html($feature_2_title); ?>
                    </h3>
                    <p>
                        <?php echo esc_html($feature_2_desc); ?>
                    </p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="feature-row-item">
                <div class="feature-row-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <div class="feature-row-content">
                    <h3>
                        <?php echo esc_html($feature_3_title); ?>
                    </h3>
                    <p>
                        <?php echo esc_html($feature_3_desc); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>