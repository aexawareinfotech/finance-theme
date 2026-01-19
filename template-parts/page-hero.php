<?php
/**
 * Template Part: Page Hero
 * 
 * A reusable hero section for page templates.
 * 
 * Usage:
 * get_template_part('template-parts/page-hero', null, [
 *     'badge' => 'Badge Text',
 *     'title' => 'Page Title',
 *     'title_accent' => 'Accent Word',
 *     'subtitle' => 'Page description text',
 *     'show_stats' => true,
 *     'stats' => [
 *         ['number' => '$50k', 'label' => 'Max Loan'],
 *         ['number' => '60 min*', 'label' => 'Fast Funding'],
 *         ['number' => '100%', 'label' => 'Online Process'],
 *     ]
 * ]);
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get passed arguments with defaults
$badge = $args['badge'] ?? '';
$title = $args['title'] ?? get_the_title();
$title_accent = $args['title_accent'] ?? '';
$subtitle = $args['subtitle'] ?? '';
$show_stats = $args['show_stats'] ?? false;
$stats = $args['stats'] ?? [];
?>

<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <?php if ($badge): ?>
                <span class="page-hero-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                    </svg>
                    <?php echo esc_html($badge); ?>
                </span>
            <?php endif; ?>

            <h1>
                <?php echo esc_html($title); ?>
                <?php if ($title_accent): ?>
                    <span class="text-accent">
                        <?php echo esc_html($title_accent); ?>
                    </span>
                <?php endif; ?>
            </h1>

            <?php if ($subtitle): ?>
                <p class="page-hero-subtitle">
                    <?php echo esc_html($subtitle); ?>
                </p>
            <?php endif; ?>

            <?php if ($show_stats && !empty($stats)): ?>
                <div class="page-hero-stats">
                    <?php foreach ($stats as $index => $stat): ?>
                        <?php if ($index > 0): ?>
                            <div class="stat-divider"></div>
                        <?php endif; ?>
                        <div class="stat-item">
                            <span class="stat-number">
                                <?php echo esc_html($stat['number']); ?>
                            </span>
                            <span class="stat-label">
                                <?php echo esc_html($stat['label']); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>