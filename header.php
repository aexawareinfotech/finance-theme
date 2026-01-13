<?php
/**
 * Header Template
 *
 * @package FairGoFinance
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <a class="skip-link" href="#main-content">
        <?php esc_html_e('Skip to content', 'flavor'); ?>
    </a>

    <header class="site-header" id="site-header">
        <div class="container">
            <div class="header-inner">
                <!-- Logo -->
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo"
                    aria-label="<?php bloginfo('name'); ?>">
                    <?php if (has_custom_logo()): ?>
                        <?php the_custom_logo(); ?>
                    <?php else: ?>
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="40" height="40" rx="10" fill="#39d25d" />
                            <path d="M12 20c0-4.4 3.6-8 8-8s8 3.6 8 8-3.6 8-8 8" stroke="#fff" stroke-width="3"
                                stroke-linecap="round" />
                            <path d="M20 16v8M16 20h8" stroke="#fff" stroke-width="2.5" stroke-linecap="round" />
                        </svg>
                        <span>
                            <?php bloginfo('name'); ?>
                        </span>
                    <?php endif; ?>
                </a>

                <!-- Desktop Navigation -->
                <nav class="nav-menu" aria-label="<?php esc_attr_e('Primary Navigation', 'flavor'); ?>">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container' => false,
                        'items_wrap' => '%3$s',
                        'fallback_cb' => function () {
                            ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>"
                            class="<?php echo is_front_page() ? 'active' : ''; ?>">
                            <?php esc_html_e('Home', 'flavor'); ?>
                        </a>
                        <a href="<?php echo esc_url(home_url('/about')); ?>">
                            <?php esc_html_e('About Us', 'flavor'); ?>
                        </a>
                        <a href="<?php echo esc_url(home_url('/loans')); ?>">
                            <?php esc_html_e('Our Loans', 'flavor'); ?>
                        </a>
                        <a href="<?php echo esc_url(home_url('/blog')); ?>">
                            <?php esc_html_e('Blog', 'flavor'); ?>
                        </a>
                        <a href="<?php echo esc_url(home_url('/contact')); ?>">
                            <?php esc_html_e('Contact', 'flavor'); ?>
                        </a>
                        <?php
                        },
                    ]);
                    ?>
                </nav>

                <!-- Header CTA -->
                <div class="header-cta">
                    <a href="<?php echo esc_url(home_url('/apply')); ?>" class="btn btn-primary">
                        <?php esc_html_e('Apply Now', 'flavor'); ?>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" id="mobile-menu-toggle"
                    aria-label="<?php esc_attr_e('Toggle mobile menu', 'flavor'); ?>" aria-expanded="false"
                    aria-controls="mobile-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <nav class="mobile-menu" id="mobile-menu" aria-label="<?php esc_attr_e('Mobile Navigation', 'flavor'); ?>">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container' => false,
                'items_wrap' => '%3$s',
                'fallback_cb' => function () {
                    ?>
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php esc_html_e('Home', 'flavor'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/about')); ?>">
                    <?php esc_html_e('About Us', 'flavor'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/loans')); ?>">
                    <?php esc_html_e('Our Loans', 'flavor'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/blog')); ?>">
                    <?php esc_html_e('Blog', 'flavor'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/contact')); ?>">
                    <?php esc_html_e('Contact', 'flavor'); ?>
                </a>
                <?php
                },
            ]);
            ?>
            <a href="<?php echo esc_url(home_url('/apply')); ?>" class="btn btn-primary">
                <?php esc_html_e('Apply Now', 'flavor'); ?>
            </a>
        </nav>
    </header>

    <main id="main-content" class="site-main">