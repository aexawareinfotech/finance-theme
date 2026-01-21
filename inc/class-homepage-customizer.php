<?php
/**
 * Homepage Customizer Settings
 *
 * Registers all customizer options for the homepage content.
 * Allows clients to edit every piece of text on the homepage.
 *
 * @package FinanceTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

class Finance_Theme_Homepage_Customizer
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('customize_register', [$this, 'register_customizer_settings']);
    }

    /**
     * Register all Homepage Customizer settings
     */
    public function register_customizer_settings($wp_customize)
    {
        // Add Homepage Settings Panel
        $wp_customize->add_panel('homepage_settings', [
            'title' => __('Homepage Settings', 'finance-theme'),
            'description' => __('Edit all content on your homepage', 'finance-theme'),
            'priority' => 20,
        ]);

        // Register all sections
        $this->register_hero_section($wp_customize);
        $this->register_loan_types_section($wp_customize);
        $this->register_process_section($wp_customize);
        $this->register_comparison_section($wp_customize);
        $this->register_australia_section($wp_customize);
        $this->register_testimonials_section($wp_customize);
        $this->register_faq_section($wp_customize);
        $this->register_blog_section($wp_customize);
    }

    /**
     * Hero Section Settings
     */
    private function register_hero_section($wp_customize)
    {
        $wp_customize->add_section('homepage_hero', [
            'title' => __('🎯 Hero Section', 'finance-theme'),
            'panel' => 'homepage_settings',
            'priority' => 10,
        ]);

        // Hero Title
        $wp_customize->add_setting('homepage_hero_title', [
            'default' => 'Need',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_hero_title', [
            'label' => __('Hero Title', 'finance-theme'),
            'section' => 'homepage_hero',
            'type' => 'text',
        ]);

        // Hero Title Accent (colored word)
        $wp_customize->add_setting('homepage_hero_title_accent', [
            'default' => 'Money?',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_hero_title_accent', [
            'label' => __('Hero Title Accent Word', 'finance-theme'),
            'description' => __('This word will be highlighted in accent color', 'finance-theme'),
            'section' => 'homepage_hero',
            'type' => 'text',
        ]);

        // Hero Subtitle
        $wp_customize->add_setting('homepage_hero_subtitle', [
            'default' => 'Get up to $50,000 paid within 60 min*',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_hero_subtitle', [
            'label' => __('Hero Subtitle', 'finance-theme'),
            'section' => 'homepage_hero',
            'type' => 'text',
        ]);

        // Hero Features (one per line)
        $wp_customize->add_setting('homepage_hero_features', [
            'default' => "Borrow from \$2,000 to \$50,000\nDigital & Paperless Journey\nProudly Australian Lender\nInstant Decisions and Same-Day Cash",
            'sanitize_callback' => 'sanitize_textarea_field',
        ]);
        $wp_customize->add_control('homepage_hero_features', [
            'label' => __('Hero Features (one per line)', 'finance-theme'),
            'description' => __('Each line will appear as a feature with a checkmark', 'finance-theme'),
            'section' => 'homepage_hero',
            'type' => 'textarea',
        ]);

        // Calculator settings
        $wp_customize->add_setting('homepage_calculator_heading', [
            'default' => "I'd like to borrow",
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_calculator_heading', [
            'label' => __('Calculator Heading', 'finance-theme'),
            'section' => 'homepage_hero',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('homepage_calculator_min', [
            'default' => '2000',
            'sanitize_callback' => 'absint',
        ]);
        $wp_customize->add_control('homepage_calculator_min', [
            'label' => __('Calculator Minimum Amount', 'finance-theme'),
            'section' => 'homepage_hero',
            'type' => 'number',
        ]);

        $wp_customize->add_setting('homepage_calculator_max', [
            'default' => '50000',
            'sanitize_callback' => 'absint',
        ]);
        $wp_customize->add_control('homepage_calculator_max', [
            'label' => __('Calculator Maximum Amount', 'finance-theme'),
            'section' => 'homepage_hero',
            'type' => 'number',
        ]);

        $wp_customize->add_setting('homepage_calculator_button', [
            'default' => 'Apply Now',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_calculator_button', [
            'label' => __('Calculator Button Text', 'finance-theme'),
            'section' => 'homepage_hero',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('homepage_calculator_note', [
            'default' => 'Online application in minutes!',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_calculator_note', [
            'label' => __('Calculator Note Text', 'finance-theme'),
            'section' => 'homepage_hero',
            'type' => 'text',
        ]);
    }

    /**
     * Loan Types Section Settings
     */
    private function register_loan_types_section($wp_customize)
    {
        $wp_customize->add_section('homepage_loan_types', [
            'title' => __('💳 Loan Types Section', 'finance-theme'),
            'panel' => 'homepage_settings',
            'priority' => 20,
        ]);

        $wp_customize->add_setting('homepage_loans_title', [
            'default' => "Online Loans for all Life's Moments",
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_loans_title', [
            'label' => __('Section Title', 'finance-theme'),
            'section' => 'homepage_loan_types',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('homepage_loans_button_text', [
            'default' => 'View All Personal Loans',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_loans_button_text', [
            'label' => __('Button Text', 'finance-theme'),
            'section' => 'homepage_loan_types',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('homepage_loans_button_url', [
            'default' => '/loans',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control('homepage_loans_button_url', [
            'label' => __('Button URL', 'finance-theme'),
            'section' => 'homepage_loan_types',
            'type' => 'url',
        ]);
    }

    /**
     * Process Section Settings
     */
    private function register_process_section($wp_customize)
    {
        $wp_customize->add_section('homepage_process', [
            'title' => __('⚙️ Process Section', 'finance-theme'),
            'panel' => 'homepage_settings',
            'priority' => 30,
        ]);

        // Section header
        $wp_customize->add_setting('homepage_process_label', [
            'default' => 'Our Process',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_process_label', [
            'label' => __('Section Label', 'finance-theme'),
            'section' => 'homepage_process',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('homepage_process_title', [
            'default' => 'How Fair Go Finance works',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_process_title', [
            'label' => __('Section Title', 'finance-theme'),
            'section' => 'homepage_process',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('homepage_process_description', [
            'default' => "Our personal loan rates are customised to you and your circumstances. And we've got loans for just about anything you need. Learn how much you could borrow and what the repayments could be.",
            'sanitize_callback' => 'sanitize_textarea_field',
        ]);
        $wp_customize->add_control('homepage_process_description', [
            'label' => __('Section Description', 'finance-theme'),
            'section' => 'homepage_process',
            'type' => 'textarea',
        ]);

        $wp_customize->add_setting('homepage_process_btn1_text', [
            'default' => 'How it works',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_process_btn1_text', [
            'label' => __('Button 1 Text', 'finance-theme'),
            'section' => 'homepage_process',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('homepage_process_btn2_text', [
            'default' => 'Calculate Repayments',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_process_btn2_text', [
            'label' => __('Button 2 Text', 'finance-theme'),
            'section' => 'homepage_process',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('homepage_process_btn2_url', [
            'default' => '/calculator',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control('homepage_process_btn2_url', [
            'label' => __('Button 2 URL', 'finance-theme'),
            'section' => 'homepage_process',
            'type' => 'url',
        ]);

        // Process steps
        $steps = [
            1 => ['title' => 'Apply now', 'desc' => 'Our online application takes just six minutes to complete.'],
            2 => ['title' => 'Accept our offer', 'desc' => "We send you the loan terms. You accept with a secure SMS code. It couldn't be easier."],
            3 => ['title' => 'Get your funds', 'desc' => 'Our real-time funding means your funds are in your account on the same day.'],
            4 => ['title' => 'Stay supported', 'desc' => 'We stick around to help with repayments, questions and credit score boosts.'],
        ];

        foreach ($steps as $i => $step) {
            $wp_customize->add_setting("homepage_process_step{$i}_title", [
                'default' => $step['title'],
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control("homepage_process_step{$i}_title", [
                'label' => sprintf(__('Step %d Title', 'finance-theme'), $i),
                'section' => 'homepage_process',
                'type' => 'text',
            ]);

            $wp_customize->add_setting("homepage_process_step{$i}_desc", [
                'default' => $step['desc'],
                'sanitize_callback' => 'sanitize_textarea_field',
            ]);
            $wp_customize->add_control("homepage_process_step{$i}_desc", [
                'label' => sprintf(__('Step %d Description', 'finance-theme'), $i),
                'section' => 'homepage_process',
                'type' => 'textarea',
            ]);
        }
    }

    /**
     * Loan Comparison Section Settings
     */
    private function register_comparison_section($wp_customize)
    {
        $wp_customize->add_section('homepage_comparison', [
            'title' => __('💰 Loan Comparison Section', 'finance-theme'),
            'panel' => 'homepage_settings',
            'priority' => 40,
        ]);

        $wp_customize->add_setting('homepage_comparison_title', [
            'default' => 'Fair Go Loans Examples',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_comparison_title', [
            'label' => __('Section Title', 'finance-theme'),
            'section' => 'homepage_comparison',
            'type' => 'text',
        ]);

        // Small Loan
        $this->add_loan_tier_settings($wp_customize, 'small', 'Small Loan', [
            'tier_title' => 'Small Loan',
            'amount_range' => 'Loan amount: $500 – $2,000',
            'term_range' => 'Loan term: 16 days – 12 months',
            'fees' => 'Fees: 20% establishment + 4% monthly (flat) | Other fees and charges may apply.',
            'example_amount' => '$1,000',
            'example_term' => '28 weeks',
            'est_fee' => '$200',
            'monthly_fee' => '$280',
            'total' => '$1,480',
            'weekly' => '$70.00',
        ]);

        // Medium Loan
        $this->add_loan_tier_settings($wp_customize, 'medium', 'Medium Loan', [
            'tier_title' => 'Medium Loan',
            'amount_range' => 'Loan amount: $2,001 – $5,000',
            'term_range' => 'Loan term: 9 weeks – 24 months',
            'fees' => 'Fees: up to $400 establishment fee | Interest: up to 47.80% p.a| Other fees and charges may apply.',
            'example_amount' => '$2,500',
            'example_term' => '28 Weeks',
            'est_fee' => '$400',
            'interest' => '$394.74',
            'total' => '$3,289',
            'weekly' => '$117.67',
        ]);

        // Large Loan
        $this->add_loan_tier_settings($wp_customize, 'large', 'Large Loan', [
            'tier_title' => 'Large Loan',
            'amount_range' => 'Loan amount: $5,001 – $50,000',
            'term_range' => 'Loan term: 12 weeks – 60 months',
            'fees' => 'Fees: up to $990 establishment fee | Interest: up to 47.80% p.a| Other fees and charges may apply.',
            'example_amount' => '$10,000',
            'example_term' => '52 Weeks',
            'est_fee' => '$990',
            'interest' => '$2,145.00',
            'total' => '$13,135',
            'weekly' => '$250.00',
        ]);
    }

    /**
     * Helper: Add loan tier settings
     */
    private function add_loan_tier_settings($wp_customize, $tier, $label, $defaults)
    {
        $fields = [
            'tier_title' => 'Tier Title',
            'amount_range' => 'Amount Range',
            'term_range' => 'Term Range',
            'fees' => 'Fees Description',
            'example_amount' => 'Example Loan Amount',
            'example_term' => 'Example Term',
            'est_fee' => 'Establishment Fee',
            'total' => 'Total Repayable',
            'weekly' => 'Weekly Repayment',
        ];

        // Add interest/monthly fee field based on tier
        if ($tier === 'small') {
            $fields['monthly_fee'] = 'Total Monthly Fee';
        } else {
            $fields['interest'] = 'Total Interest';
        }

        foreach ($fields as $key => $field_label) {
            $setting_id = "homepage_loan_{$tier}_{$key}";
            $default = isset($defaults[$key]) ? $defaults[$key] : '';

            $wp_customize->add_setting($setting_id, [
                'default' => $default,
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control($setting_id, [
                'label' => "{$label}: {$field_label}",
                'section' => 'homepage_comparison',
                'type' => 'text',
            ]);
        }
    }

    /**
     * Australia Section Settings
     */
    private function register_australia_section($wp_customize)
    {
        $wp_customize->add_section('homepage_australia', [
            'title' => __('🇦🇺 Trusted by Australians', 'finance-theme'),
            'panel' => 'homepage_settings',
            'priority' => 50,
        ]);

        $wp_customize->add_setting('homepage_australia_title', [
            'default' => 'Trusted by Australians',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_australia_title', [
            'label' => __('Section Title', 'finance-theme'),
            'section' => 'homepage_australia',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('homepage_australia_intro', [
            'default' => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ]);
        $wp_customize->add_control('homepage_australia_intro', [
            'label' => __('Intro Paragraph', 'finance-theme'),
            'description' => __('Use %s placeholders for: Company Name, ASIC Number, AFCA Number. Leave empty for default text.', 'finance-theme'),
            'section' => 'homepage_australia',
            'type' => 'textarea',
        ]);

        // Feature items
        $features = [
            1 => '100% Australian owned',
            2 => 'Bad Credit? No Problem.',
            3 => '100% Secure Process',
        ];

        foreach ($features as $i => $default) {
            $wp_customize->add_setting("homepage_australia_feature{$i}", [
                'default' => $default,
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control("homepage_australia_feature{$i}", [
                'label' => sprintf(__('Feature %d', 'finance-theme'), $i),
                'section' => 'homepage_australia',
                'type' => 'text',
            ]);
        }

        $wp_customize->add_setting('homepage_australia_button', [
            'default' => 'Apply Now',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_australia_button', [
            'label' => __('Button Text', 'finance-theme'),
            'section' => 'homepage_australia',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('homepage_australia_note', [
            'default' => 'Safe and Secure. 5 min application*',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_australia_note', [
            'label' => __('Note Text', 'finance-theme'),
            'section' => 'homepage_australia',
            'type' => 'text',
        ]);
    }

    /**
     * Testimonials Section Settings
     */
    private function register_testimonials_section($wp_customize)
    {
        $wp_customize->add_section('homepage_testimonials', [
            'title' => __('⭐ Testimonials Section', 'finance-theme'),
            'panel' => 'homepage_settings',
            'priority' => 60,
        ]);

        $wp_customize->add_setting('homepage_testimonials_title', [
            'default' => 'What Our Customers Say',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_testimonials_title', [
            'label' => __('Section Title', 'finance-theme'),
            'section' => 'homepage_testimonials',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('homepage_testimonials_subtitle', [
            'default' => "Don't just take our word for it - hear from real customers who got a fair go.",
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_testimonials_subtitle', [
            'label' => __('Section Subtitle', 'finance-theme'),
            'section' => 'homepage_testimonials',
            'type' => 'text',
        ]);
    }

    /**
     * FAQ Section Settings
     */
    private function register_faq_section($wp_customize)
    {
        $wp_customize->add_section('homepage_faq', [
            'title' => __('❓ FAQ Section', 'finance-theme'),
            'panel' => 'homepage_settings',
            'priority' => 70,
        ]);

        $wp_customize->add_setting('homepage_faq_title', [
            'default' => 'Frequently Asked Questions',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_faq_title', [
            'label' => __('Section Title', 'finance-theme'),
            'section' => 'homepage_faq',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('homepage_faq_subtitle', [
            'default' => "Got questions? We've got answers.",
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_faq_subtitle', [
            'label' => __('Section Subtitle', 'finance-theme'),
            'section' => 'homepage_faq',
            'type' => 'text',
        ]);
    }

    /**
     * Blog Section Settings
     */
    private function register_blog_section($wp_customize)
    {
        $wp_customize->add_section('homepage_blog', [
            'title' => __('📝 Blog Section', 'finance-theme'),
            'panel' => 'homepage_settings',
            'priority' => 80,
        ]);

        $wp_customize->add_setting('homepage_blog_title', [
            'default' => 'Latest from Our Blog',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_blog_title', [
            'label' => __('Section Title', 'finance-theme'),
            'section' => 'homepage_blog',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('homepage_blog_subtitle', [
            'default' => 'Tips, insights, and news about personal finance in Australia.',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_blog_subtitle', [
            'label' => __('Section Subtitle', 'finance-theme'),
            'section' => 'homepage_blog',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('homepage_blog_button', [
            'default' => 'View All Posts',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('homepage_blog_button', [
            'label' => __('Button Text', 'finance-theme'),
            'section' => 'homepage_blog',
            'type' => 'text',
        ]);
    }
}

// Initialize
new Finance_Theme_Homepage_Customizer();
