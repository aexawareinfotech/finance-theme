<?php
/**
 * Finance Theme Functions
 *
 * @package FinanceTheme
 * @author Aexaware Infotech
 * @since 1.0.0
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

define('FINANCE_THEME_VERSION', '1.16.0');
define('FINANCE_THEME_DIR', get_template_directory());
define('FINANCE_THEME_URI', get_template_directory_uri());

// Backwards compatibility
define('FLAVOR_VERSION', FINANCE_THEME_VERSION);
define('FLAVOR_DIR', FINANCE_THEME_DIR);
define('FLAVOR_URI', FINANCE_THEME_URI);

require_once FINANCE_THEME_DIR . '/inc/class-demo-importer.php';
require_once FINANCE_THEME_DIR . '/inc/class-loan-metaboxes.php';


/**
 * Theme Setup
 */
function flavor_setup(): void
{
    // Make theme available for translation
    load_theme_textdomain('finance-theme', FLAVOR_DIR . '/languages');

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Add support for block styles
    add_theme_support('wp-block-styles');

    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style();

    // Add support for full and wide align images
    add_theme_support('align-wide');

    // Add custom image sizes
    add_image_size('blog-thumbnail', 600, 400, true);
    add_image_size('hero-image', 1920, 1080, true);

    // Register navigation menus
    register_nav_menus([
        'primary' => esc_html__('Primary Menu', 'finance-theme'),
        'footer' => esc_html__('Footer Menu', 'finance-theme'),
        'legal' => esc_html__('Legal Links', 'finance-theme'),
    ]);

    // Switch default core markup to valid HTML5
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for custom logo
    add_theme_support('custom-logo', [
        'height' => 100,
        'width' => 300,
        'flex-height' => true,
        'flex-width' => true,
    ]);

    // Add support for wide alignment
    add_theme_support('align-wide');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add support for custom background
    add_theme_support('custom-background', [
        'default-color' => 'ffffff',
    ]);

    // Add support for custom header (recommended)
    add_theme_support('custom-header', [
        'default-image' => '',
        'width' => 1920,
        'height' => 400,
        'flex-height' => true,
        'flex-width' => true,
        'header-text' => false,
    ]);
}
add_action('after_setup_theme', 'flavor_setup');

/**
 * Create essential pages on theme activation
 * 
 * This function creates the required pages for the theme to function properly.
 * Pages are only created if they don't already exist.
 */
function finance_theme_create_essential_pages(): void
{
    // Define essential pages with their templates
    $essential_pages = [
        [
            'title' => 'Loans',
            'slug' => 'loans',
            'content' => '',
            'template' => '', // page-loans.php is auto-applied via slug
        ],
        [
            'title' => 'Apply Now',
            'slug' => 'apply',
            'content' => '<!-- Apply form content can be added here or via page builder -->',
            'template' => '',
        ],
        [
            'title' => 'Privacy Policy',
            'slug' => 'privacy-policy',
            'content' => '',
            'template' => 'template-privacy-policy.php',
        ],
        [
            'title' => 'Terms & Conditions',
            'slug' => 'terms-and-conditions',
            'content' => '',
            'template' => 'template-terms.php',
        ],
        [
            'title' => 'Disclaimer',
            'slug' => 'disclaimer',
            'content' => '',
            'template' => 'template-disclaimer.php',
        ],
    ];

    foreach ($essential_pages as $page_data) {
        // Check if page with this slug already exists
        $existing_page = get_page_by_path($page_data['slug']);

        if (!$existing_page) {
            // Create the page
            $page_id = wp_insert_post([
                'post_title' => $page_data['title'],
                'post_name' => $page_data['slug'],
                'post_content' => $page_data['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_author' => 1,
            ]);

            // Set page template if specified
            if ($page_id && !is_wp_error($page_id) && !empty($page_data['template'])) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
        }
    }

    // Flush rewrite rules to ensure new pages are accessible
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'finance_theme_create_essential_pages');

/**
 * Register Custom Post Types
 * 
 * Registers the loan_type custom post type for the theme.
 * This allows /loans/ URL to work via archive-loan_type.php template.
 */
function finance_theme_register_post_types(): void
{
    // Register Loan Type CPT
    register_post_type('loan_type', [
        'labels' => [
            'name' => __('Loan Types', 'finance-theme'),
            'singular_name' => __('Loan Type', 'finance-theme'),
            'menu_name' => __('Loan Types', 'finance-theme'),
            'add_new' => __('Add New', 'finance-theme'),
            'add_new_item' => __('Add New Loan Type', 'finance-theme'),
            'edit_item' => __('Edit Loan Type', 'finance-theme'),
            'new_item' => __('New Loan Type', 'finance-theme'),
            'view_item' => __('View Loan Type', 'finance-theme'),
            'search_items' => __('Search Loan Types', 'finance-theme'),
            'not_found' => __('No loan types found', 'finance-theme'),
            'not_found_in_trash' => __('No loan types found in trash', 'finance-theme'),
        ],
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-money-alt',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'has_archive' => 'loans', // This makes /loans/ use archive-loan_type.php
        'rewrite' => [
            'slug' => 'loan',
            'with_front' => false,
        ],
    ]);
}
add_action('init', 'finance_theme_register_post_types');

/**
 * Flush rewrite rules on theme activation to ensure custom post types work
 */
function finance_theme_flush_rewrite_rules(): void
{
    finance_theme_register_post_types();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'finance_theme_flush_rewrite_rules');

/**
 * Clear default WordPress widgets on theme activation
 * Removes Archives, Categories, Meta widgets that WP adds by default
 */
function finance_theme_clear_default_widgets(): void
{
    // Get all sidebar widget assignments
    $sidebars_widgets = get_option('sidebars_widgets');

    if (is_array($sidebars_widgets)) {
        // Clear all widget areas
        foreach ($sidebars_widgets as $sidebar_id => $widgets) {
            if ($sidebar_id !== 'wp_inactive_widgets' && $sidebar_id !== 'array_version') {
                $sidebars_widgets[$sidebar_id] = [];
            }
        }
        update_option('sidebars_widgets', $sidebars_widgets);
    }
}
add_action('after_switch_theme', 'finance_theme_clear_default_widgets');

/**
 * Enqueue scripts and styles
 */
function flavor_scripts(): void
{
    // Preconnect to Google Fonts for performance
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';

    // Google Fonts with font-display swap for better performance
    wp_enqueue_style(
        'flavor-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap',
        [],
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'flavor-style',
        get_stylesheet_uri(),
        ['flavor-fonts'],
        FLAVOR_VERSION
    );

    // Main JavaScript
    wp_enqueue_script(
        'flavor-main',
        FLAVOR_URI . '/assets/js/main.js',
        [],
        FLAVOR_VERSION,
        true
    );

    // Slider JavaScript
    wp_enqueue_script(
        'flavor-slider',
        FLAVOR_URI . '/assets/js/slider.js',
        [],
        FLAVOR_VERSION,
        true
    );

    // Localize script with ajax url
    wp_localize_script('flavor-main', 'flavorAjax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('flavor_nonce'),
    ]);

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'flavor_scripts');

/**
 * Register widget areas
 */
function flavor_widgets_init(): void
{
    register_sidebar([
        'name' => esc_html__('Footer Widget 1', 'finance-theme'),
        'id' => 'footer-1',
        'description' => esc_html__('Add widgets here for footer column 1.', 'finance-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ]);

    register_sidebar([
        'name' => esc_html__('Footer Widget 2', 'finance-theme'),
        'id' => 'footer-2',
        'description' => esc_html__('Add widgets here for footer column 2.', 'finance-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ]);
}
add_action('widgets_init', 'flavor_widgets_init');

/**
 * Register block styles for Gutenberg
 */
function flavor_register_block_styles(): void
{
    // Button block style
    register_block_style('core/button', [
        'name' => 'finance-primary',
        'label' => __('Primary Button', 'finance-theme'),
    ]);

    register_block_style('core/button', [
        'name' => 'finance-secondary',
        'label' => __('Secondary Button', 'finance-theme'),
    ]);

    // Group block style
    register_block_style('core/group', [
        'name' => 'finance-card',
        'label' => __('Card Style', 'finance-theme'),
    ]);
}
add_action('init', 'flavor_register_block_styles');

/**
 * Register block pattern category
 */
function flavor_register_block_patterns(): void
{
    register_block_pattern_category('finance-theme', [
        'label' => __('Finance Theme', 'finance-theme'),
    ]);
}
add_action('init', 'flavor_register_block_patterns');

/**
 * Theme Customizer
 */
function flavor_customize_register($wp_customize): void
{
    // ========================================
    // HEADER SETTINGS SECTION
    // ========================================
    $wp_customize->add_section('flavor_header_settings', [
        'title' => __('Header Settings', 'finance-theme'),
        'priority' => 25,
    ]);

    // Show Search
    $wp_customize->add_setting('flavor_show_search', [
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('flavor_show_search', [
        'label' => __('Show Search Icon', 'finance-theme'),
        'section' => 'flavor_header_settings',
        'type' => 'checkbox',
    ]);

    // Show CTA Button
    $wp_customize->add_setting('flavor_show_cta', [
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('flavor_show_cta', [
        'label' => __('Show CTA Button', 'finance-theme'),
        'section' => 'flavor_header_settings',
        'type' => 'checkbox',
    ]);

    // CTA Button Text
    $wp_customize->add_setting('flavor_cta_text', [
        'default' => 'Apply Now',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('flavor_cta_text', [
        'label' => __('CTA Button Text', 'finance-theme'),
        'section' => 'flavor_header_settings',
        'type' => 'text',
    ]);

    // CTA Button URL
    $wp_customize->add_setting('flavor_cta_url', [
        'default' => '/apply',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('flavor_cta_url', [
        'label' => __('CTA Button URL', 'finance-theme'),
        'section' => 'flavor_header_settings',
        'type' => 'url',
    ]);

    // ========================================
    // FOOTER SETTINGS SECTION
    // ========================================
    $wp_customize->add_section('flavor_footer_settings', [
        'title' => __('Footer Settings', 'finance-theme'),
        'priority' => 45,
    ]);

    // Footer Logo
    $wp_customize->add_setting('flavor_footer_logo', [
        'default' => '',
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'flavor_footer_logo', [
        'label' => __('Footer Logo', 'finance-theme'),
        'section' => 'flavor_footer_settings',
        'mime_type' => 'image',
        'description' => __('Leave empty to use site logo', 'finance-theme'),
    ]));

    // Footer Tagline
    $wp_customize->add_setting('flavor_footer_tagline', [
        'default' => 'Get the funding you need, when you need it. Fair Go Finance provides fast, flexible loans for all Australians.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('flavor_footer_tagline', [
        'label' => __('Footer Tagline', 'finance-theme'),
        'section' => 'flavor_footer_settings',
        'type' => 'textarea',
    ]);

    // Copyright Text
    $wp_customize->add_setting('flavor_copyright', [
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('flavor_copyright', [
        'label' => __('Custom Copyright Text', 'finance-theme'),
        'section' => 'flavor_footer_settings',
        'type' => 'text',
        'description' => __('Leave empty for default: © [Year] [Site Name]. All rights reserved.', 'finance-theme'),
    ]);

    // Show License Section
    $wp_customize->add_setting('flavor_show_license', [
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('flavor_show_license', [
        'label' => __('Show ASIC/AFCA License Section', 'finance-theme'),
        'section' => 'flavor_footer_settings',
        'type' => 'checkbox',
    ]);

    // ========================================
    // COMPANY INFO SECTION
    // ========================================
    $wp_customize->add_section('flavor_company_info', [
        'title' => __('Company Information', 'finance-theme'),
        'priority' => 30,
    ]);

    // Company Phone
    $wp_customize->add_setting('flavor_phone', [
        'default' => '1300 XXX XXX',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('flavor_phone', [
        'label' => __('Phone Number', 'finance-theme'),
        'section' => 'flavor_company_info',
        'type' => 'text',
    ]);

    // Company Email
    $wp_customize->add_setting('flavor_email', [
        'default' => 'info@fairgofinance.com.au',
        'sanitize_callback' => 'sanitize_email',
    ]);
    $wp_customize->add_control('flavor_email', [
        'label' => __('Email Address', 'finance-theme'),
        'section' => 'flavor_company_info',
        'type' => 'email',
    ]);

    // Company Address
    $wp_customize->add_setting('flavor_address', [
        'default' => 'Sydney, NSW, Australia',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('flavor_address', [
        'label' => __('Address', 'finance-theme'),
        'section' => 'flavor_company_info',
        'type' => 'text',
    ]);

    // ========================================
    // COMPLIANCE SECTION
    // ========================================
    $wp_customize->add_section('flavor_compliance', [
        'title' => __('Compliance & Licensing', 'finance-theme'),
        'priority' => 35,
    ]);

    // ASIC License Number
    $wp_customize->add_setting('flavor_asic_number', [
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('flavor_asic_number', [
        'label' => __('ASIC Credit License Number', 'finance-theme'),
        'section' => 'flavor_compliance',
        'type' => 'text',
        'description' => __('Your Australian Credit License number', 'finance-theme'),
    ]);

    // AFCA Membership Number
    $wp_customize->add_setting('flavor_afca_number', [
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('flavor_afca_number', [
        'label' => __('AFCA Membership Number', 'finance-theme'),
        'section' => 'flavor_compliance',
        'type' => 'text',
        'description' => __('Your AFCA membership number', 'finance-theme'),
    ]);

    // ========================================
    // SOCIAL MEDIA SECTION
    // ========================================
    $wp_customize->add_section('flavor_social', [
        'title' => __('Social Media', 'finance-theme'),
        'priority' => 40,
    ]);

    $social_networks = ['facebook', 'twitter', 'linkedin', 'instagram'];
    foreach ($social_networks as $network) {
        $wp_customize->add_setting("flavor_{$network}", [
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control("flavor_{$network}", [
            'label' => ucfirst($network) . ' URL',
            'section' => 'flavor_social',
            'type' => 'url',
        ]);
    }
}
add_action('customize_register', 'flavor_customize_register');

/**
 * Helper functions
 */
function flavor_get_loan_types(): array
{
    $loans = get_posts([
        'post_type' => 'loan_type',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ]);

    if (empty($loans)) {
        // Return default loan types if none exist
        return [
            ['title' => 'Personal Loans', 'description' => 'Flexible personal loans for any purpose with competitive rates.', 'icon' => 'user'],
            ['title' => 'Car Loans', 'description' => 'Get behind the wheel with our affordable car finance options.', 'icon' => 'car'],
            ['title' => 'Business Loans', 'description' => 'Grow your business with tailored commercial lending solutions.', 'icon' => 'briefcase'],
            ['title' => 'Home Loans', 'description' => 'Make your property dreams a reality with our home loan products.', 'icon' => 'home'],
            ['title' => 'Debt Consolidation', 'description' => 'Simplify your finances by combining multiple debts into one.', 'icon' => 'refresh'],
            ['title' => 'Wedding Loans', 'description' => 'Finance your special day without breaking the bank.', 'icon' => 'heart'],
            ['title' => 'Holiday Loans', 'description' => 'Take that dream vacation with our travel finance options.', 'icon' => 'plane'],
            ['title' => 'Medical Loans', 'description' => 'Cover medical expenses with our healthcare financing.', 'icon' => 'medical'],
        ];
    }

    return array_map(function ($loan) {
        return [
            'title' => $loan->post_title,
            'description' => $loan->post_excerpt ?: wp_trim_words($loan->post_content, 20),
            'icon' => get_post_meta($loan->ID, '_loan_icon', true) ?: 'default',
            'link' => get_permalink($loan->ID),
        ];
    }, $loans);
}

function flavor_get_testimonials(): array
{
    $testimonials = get_posts([
        'post_type' => 'testimonial',
        'posts_per_page' => 6,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);

    if (empty($testimonials)) {
        // Return sample testimonials if none exist
        return [
            [
                'content' => 'Fair Go Finance made the whole process so easy! I had my funds within 24 hours. Highly recommend their personal loan service.',
                'author' => 'Sarah M.',
                'loan_type' => 'Personal Loan',
                'rating' => 5,
            ],
            [
                'content' => 'After being knocked back by the big banks, Fair Go Finance gave me a chance. Now I\'m driving my dream car!',
                'author' => 'James T.',
                'loan_type' => 'Car Loan',
                'rating' => 5,
            ],
            [
                'content' => 'The team was incredibly helpful and explained everything clearly. No hidden fees, just honest lending.',
                'author' => 'Michelle K.',
                'loan_type' => 'Debt Consolidation',
                'rating' => 5,
            ],
            [
                'content' => 'Fast approval and great rates. Exactly what I needed to grow my small business.',
                'author' => 'David R.',
                'loan_type' => 'Business Loan',
                'rating' => 4,
            ],
            [
                'content' => 'They really do give everyone a fair go. The application was simple and the support was fantastic.',
                'author' => 'Emma L.',
                'loan_type' => 'Personal Loan',
                'rating' => 5,
            ],
            [
                'content' => 'Consolidated all my credit cards into one easy payment. Saving money every month now!',
                'author' => 'Chris P.',
                'loan_type' => 'Debt Consolidation',
                'rating' => 5,
            ],
        ];
    }

    return array_map(function ($testimonial) {
        return [
            'content' => $testimonial->post_content,
            'author' => $testimonial->post_title,
            'loan_type' => get_post_meta($testimonial->ID, '_testimonial_loan_type', true),
            'rating' => (int) get_post_meta($testimonial->ID, '_testimonial_rating', true) ?: 5,
        ];
    }, $testimonials);
}

function flavor_get_faqs(): array
{
    $faqs = get_posts([
        'post_type' => 'faq',
        'posts_per_page' => 10,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ]);

    if (empty($faqs)) {
        // Return sample FAQs if none exist
        return [
            [
                'question' => 'How quickly can I get approved?',
                'answer' => 'Our online application takes just 6 minutes to complete, and most applications receive a decision within hours. Once approved, funds can be in your account the same day.',
            ],
            [
                'question' => 'What documents do I need to apply?',
                'answer' => 'You\'ll need proof of identity (driver\'s license or passport), proof of income (recent payslips or bank statements), and your current address details.',
            ],
            [
                'question' => 'Can I apply if I have bad credit?',
                'answer' => 'Yes! We believe everyone deserves a fair go. While we do assess creditworthiness, we look at your overall financial situation, not just your credit score.',
            ],
            [
                'question' => 'What are your interest rates?',
                'answer' => 'Our rates are personalised based on your individual circumstances. We\'re committed to transparent, competitive rates with no hidden fees.',
            ],
            [
                'question' => 'How do I make repayments?',
                'answer' => 'Repayments are automatically deducted from your nominated bank account on your chosen frequency - weekly, fortnightly, or monthly.',
            ],
            [
                'question' => 'Is Fair Go Finance licensed?',
                'answer' => 'Yes, we hold an Australian Credit License issued by ASIC and are a member of AFCA (Australian Financial Complaints Authority).',
            ],
        ];
    }

    return array_map(function ($faq) {
        return [
            'question' => $faq->post_title,
            'answer' => $faq->post_content,
        ];
    }, $faqs);
}

function flavor_get_latest_posts(int $count = 3): array
{
    return get_posts([
        'post_type' => 'post',
        'posts_per_page' => $count,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);
}

/**
 * Render star rating
 */
function flavor_render_stars(int $rating): string
{
    $output = '<div class="testimonial-stars">';
    for ($i = 1; $i <= 5; $i++) {
        $filled = $i <= $rating ? 'filled' : '';
        $output .= '<svg class="star ' . $filled . '" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
    }
    $output .= '</div>';
    return $output;
}

/**
 * Add body classes
 */
function flavor_body_classes(array $classes): array
{
    if (is_front_page()) {
        $classes[] = 'front-page';
    }

    if (is_singular()) {
        $classes[] = 'singular';
    }

    return $classes;
}
add_filter('body_class', 'flavor_body_classes');

/**
 * Custom excerpt length
 */
function flavor_excerpt_length(int $length): int
{
    return 20;
}
add_filter('excerpt_length', 'flavor_excerpt_length');

/**
 * Custom excerpt more
 */
function flavor_excerpt_more(string $more): string
{
    return '...';
}
add_filter('excerpt_more', 'flavor_excerpt_more');

/**
 * Get loan icon SVG by name
 */
function flavor_get_loan_icon(string $icon): string
{
    $icons = [
        'user' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
        'car' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H5.24a2 2 0 0 0-1.8 1.1l-.8 1.63A6 6 0 0 0 2 12.42V16h2"/><circle cx="6.5" cy="16.5" r="2.5"/><circle cx="16.5" cy="16.5" r="2.5"/></svg>',
        'briefcase' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>',
        'home' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
        'refresh' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 4v6h-6"/><path d="M1 20v-6h6"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>',
        'heart' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
        'plane' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>',
        'medical' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>',
        'default' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
    ];

    return $icons[$icon] ?? $icons['default'];
}

