<?php
/**
 * Demo Data Importer
 *
 * Handles importing of demo content for the theme.
 *
 * @package FinanceTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

class Finance_Theme_Demo_Importer
{
    private $loan_types = [];
    private $testimonials = [];
    private $faqs = [];

    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'handle_import']);

        // Define loan types data with all metadata
        $this->loan_types = [
            [
                'title' => 'Emergency Loans',
                'description' => 'When unexpected expenses arise, our emergency loans provide fast access to funds when you need them most.',
                'image' => 'emergency-loan.webp',
                'meta' => [
                    '_loan_subtitle' => 'Fast access to funds when you need them most.',
                    '_loan_amount' => '$500 - $10,000',
                    '_loan_term' => '16 days - 24 months',
                    '_loan_features' => "Same-day approval available\nNo hidden fees\nFlexible repayment options\nBad credit considered",
                    '_loan_color' => 'var(--accent-500)',
                    '_loan_icon' => 'default',
                    '_loan_stat_1_number' => '$10k',
                    '_loan_stat_1_label' => 'Max Amount',
                    '_loan_stat_2_number' => '60 min*',
                    '_loan_stat_2_label' => 'Fast Funding',
                    '_loan_stat_3_number' => '100%',
                    '_loan_stat_3_label' => 'Online Process'
                ]
            ],
            [
                'title' => 'Wedding Loans',
                'description' => 'Make your special day unforgettable without the financial stress. Our wedding loans help you spread the cost of your dream wedding with manageable repayments.',
                'image' => 'wedding.webp',
                'meta' => [
                    '_loan_subtitle' => 'Make your special day unforgettable without the stress.',
                    '_loan_amount' => '$2,000 - $25,000',
                    '_loan_term' => '12 - 36 months',
                    '_loan_features' => "Cover venue, catering & more\nCompetitive interest rates\nQuick online application\nPredictable monthly payments",
                    '_loan_color' => '#e75480',
                    '_loan_icon' => 'heart',
                    '_loan_stat_1_number' => '$25k',
                    '_loan_stat_1_label' => 'Max Amount',
                    '_loan_stat_2_number' => '24 hrs',
                    '_loan_stat_2_label' => 'Approval Time',
                    '_loan_stat_3_number' => 'Low',
                    '_loan_stat_3_label' => 'Interest Rates'
                ]
            ],
            [
                'title' => 'Education Loans',
                'description' => 'Invest in your future with our education financing options. Cover tuition, books, equipment, or any study-related expenses.',
                'image' => 'education.webp',
                'meta' => [
                    '_loan_subtitle' => 'Invest in your future with flexible financing.',
                    '_loan_amount' => '$1,000 - $20,000',
                    '_loan_term' => '12 - 48 months',
                    '_loan_features' => "Fund courses & certifications\nEquipment & supplies included\nDeferred payment options\nNo early repayment fees",
                    '_loan_color' => '#3498db',
                    '_loan_icon' => 'briefcase',
                    '_loan_stat_1_number' => '$20k',
                    '_loan_stat_1_label' => 'Max Amount',
                    '_loan_stat_2_number' => '48 mos',
                    '_loan_stat_2_label' => 'Max Term',
                    '_loan_stat_3_number' => '0',
                    '_loan_stat_3_label' => 'Early Fees'
                ]
            ],
            [
                'title' => 'Travel Loans',
                'description' => 'Turn your travel dreams into reality. Whether it\'s a family vacation, honeymoon, or adventure trip, our travel loans make it possible.',
                'image' => 'online.webp',
                'meta' => [
                    '_loan_subtitle' => 'Turn your travel dreams into reality.',
                    '_loan_amount' => '$1,000 - $15,000',
                    '_loan_term' => '6 - 24 months',
                    '_loan_features' => "Book now, pay later\nCover flights, hotels & tours\nQuick approval process\nFlexible terms available",
                    '_loan_color' => '#27ae60',
                    '_loan_icon' => 'plane',
                    '_loan_stat_1_number' => '$15k',
                    '_loan_stat_1_label' => 'Max Amount',
                    '_loan_stat_2_number' => 'Fast',
                    '_loan_stat_2_label' => 'Approval',
                    '_loan_stat_3_number' => 'Flex',
                    '_loan_stat_3_label' => 'Repayments'
                ]
            ],
            [
                'title' => 'Bond Loans',
                'description' => 'Moving to a new place? Our bond loans help you cover rental bond deposits quickly, so you can secure your new home without stress.',
                'image' => 'bond-loan.webp',
                'meta' => [
                    '_loan_subtitle' => 'Secure your new home without stress.',
                    '_loan_amount' => '$500 - $5,000',
                    '_loan_term' => '21 days - 12 months',
                    '_loan_features' => "21 days interest-free option\nFast approval for renters\nCover bond & moving costs\nSimple application process",
                    '_loan_color' => '#9b59b6',
                    '_loan_icon' => 'home',
                    '_loan_stat_1_number' => '$5k',
                    '_loan_stat_1_label' => 'Max Amount',
                    '_loan_stat_2_number' => '21 days',
                    '_loan_stat_2_label' => 'Interest Free',
                    '_loan_stat_3_number' => 'Fast',
                    '_loan_stat_3_label' => 'Transfer'
                ]
            ],
            [
                'title' => 'Car Repair Loans',
                'description' => 'Don\'t let car troubles keep you off the road. Our car repair loans provide quick funding for mechanical repairs, servicing, and maintenance.',
                'image' => 'car-repairs.webp',
                'meta' => [
                    '_loan_subtitle' => 'Get back on the road quickly.',
                    '_loan_amount' => '$500 - $8,000',
                    '_loan_term' => '6 - 18 months',
                    '_loan_features' => "Cover any repair costs\nSame-day funding available\nWork with any mechanic\nAffordable repayments",
                    '_loan_color' => '#e67e22',
                    '_loan_icon' => 'car',
                    '_loan_stat_1_number' => '$8k',
                    '_loan_stat_1_label' => 'Max Amount',
                    '_loan_stat_2_number' => 'Same Day',
                    '_loan_stat_2_label' => 'Funding',
                    '_loan_stat_3_number' => 'Any',
                    '_loan_stat_3_label' => 'Mechanic'
                ]
            ],
            [
                'title' => 'Vet Loans',
                'description' => 'Your furry family members deserve the best care. Our vet loans help cover unexpected veterinary bills, surgeries, and ongoing treatments.',
                'image' => 'vet-loans.webp',
                'meta' => [
                    '_loan_subtitle' => 'Care for your furry family members.',
                    '_loan_amount' => '$500 - $10,000',
                    '_loan_term' => '6 - 24 months',
                    '_loan_features' => "Emergency vet care covered\nSurgery & treatments included\nQuick decisions made\nNo upfront payments",
                    '_loan_color' => '#1abc9c',
                    '_loan_icon' => 'heart',
                    '_loan_stat_1_number' => '$10k',
                    '_loan_stat_1_label' => 'Max Amount',
                    '_loan_stat_2_number' => 'Quick',
                    '_loan_stat_2_label' => 'Decisions',
                    '_loan_stat_3_number' => 'No',
                    '_loan_stat_3_label' => 'Upfront'
                ]
            ],
            [
                'title' => 'Cosmetic Loans',
                'description' => 'Finance your cosmetic procedures with confidence. From dental work to aesthetic treatments, our cosmetic loans help you look and feel your best.',
                'image' => 'cosmetic-surgery.webp',
                'meta' => [
                    '_loan_subtitle' => 'Look and feel your best with flexible financing.',
                    '_loan_amount' => '$2,000 - $30,000',
                    '_loan_term' => '12 - 48 months',
                    '_loan_features' => "All procedures covered\nWork with any provider\nDiscreet application\nFlexible payment plans",
                    '_loan_color' => '#e74c3c',
                    '_loan_icon' => 'medical',
                    '_loan_stat_1_number' => '$30k',
                    '_loan_stat_1_label' => 'Max Amount',
                    '_loan_stat_2_number' => 'Discreet',
                    '_loan_stat_2_label' => 'Process',
                    '_loan_stat_3_number' => 'Flex',
                    '_loan_stat_3_label' => 'Plans'
                ]
            ],
            [
                'title' => 'Medium Loans',
                'description' => 'For those mid-sized expenses that require a bit more flexibility. Our medium loans offer competitive rates for amounts between $2,001 and $5,000.',
                'image' => 'medium-loans.webp',
                'meta' => [
                    '_loan_subtitle' => 'Flexible mid-sized loans for your needs.',
                    '_loan_amount' => '$2,001 - $5,000',
                    '_loan_term' => '9 weeks - 24 months',
                    '_loan_features' => "Competitive interest rates\nFlexible repayment schedules\nNo hidden charges\nQuick approval process",
                    '_loan_color' => '#2980b9',
                    '_loan_icon' => 'default',
                    '_loan_stat_1_number' => '$5k',
                    '_loan_stat_1_label' => 'Max Amount',
                    '_loan_stat_2_number' => 'Low',
                    '_loan_stat_2_label' => 'Rates',
                    '_loan_stat_3_number' => 'Quick',
                    '_loan_stat_3_label' => 'Process'
                ]
            ],
            [
                'title' => 'Large Loans',
                'description' => 'For significant expenses and major life events. Our large loans provide access to up to $50,000 with flexible terms tailored to your needs.',
                'image' => 'large-loans.webp',
                'meta' => [
                    '_loan_subtitle' => 'Funding for life\'s big moments.',
                    '_loan_amount' => '$5,001 - $50,000',
                    '_loan_term' => '12 - 60 months',
                    '_loan_features' => "Higher loan amounts\nLonger repayment terms\nPersonalised rates\nDedicated support",
                    '_loan_color' => '#34495e',
                    '_loan_icon' => 'default',
                    '_loan_stat_1_number' => '$50k',
                    '_loan_stat_1_label' => 'Max Amount',
                    '_loan_stat_2_number' => '60 mos',
                    '_loan_stat_2_label' => 'Max Term',
                    '_loan_stat_3_number' => 'VIP',
                    '_loan_stat_3_label' => 'Support'
                ]
            ],
        ];

        // Define testimonials data
        $this->testimonials = [
            [
                'title' => 'Great Service!',
                'content' => 'Fair Go Finance helped me when I needed it most. The process was quick and easy.',
                'loan_type' => 'Emergency Loans',
                'rating' => 5
            ],
            [
                'title' => 'Highly Recommended',
                'content' => 'I was able to pay for my wedding expenses without stress. Thank you!',
                'loan_type' => 'Wedding Loans',
                'rating' => 5
            ],
            [
                'title' => 'Fast Approval',
                'content' => 'Exceptional service and fast approval time. Very happy with the outcome.',
                'loan_type' => 'Car Repairs',
                'rating' => 4
            ],
            [
                'title' => 'Friendly Team',
                'content' => 'The team was very helpful and explained everything clearly. Would recommend.',
                'loan_type' => 'Education Loans',
                'rating' => 5
            ],
        ];

        // Define FAQs data
        $this->faqs = [
            [
                'title' => 'How long does the application take?',
                'content' => 'Our online application takes less than 5 minutes to complete.'
            ],
            [
                'title' => 'When will I get the money?',
                'content' => 'Most customers receive their funds within 24 hours of approval.'
            ],
            [
                'title' => 'What documents do I need?',
                'content' => 'You will need 100 points of ID and your recent bank statements.'
            ],
            [
                'title' => 'Can I pay out my loan early?',
                'content' => 'Yes, you can pay out your loan early at any time without penalty.'
            ],
            [
                'title' => 'Do you perform credit checks?',
                'content' => 'Yes, we perform credit checks as part of our responsible lending obligations.'
            ],
        ];
    }

    /**
     * Add admin menu page
     */
    public function add_admin_menu()
    {
        add_theme_page(
            'Theme Setup',
            'Theme Setup',
            'manage_options',
            'finance-theme-setup',
            [$this, 'render_page']
        );
    }

    /**
     * Render the setup page
     */
    public function render_page()
    {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

            <div class="card" style="max-width: 600px; padding: 20px; margin-top: 20px;">
                <h2><?php esc_html_e('Import Demo Content', 'finance-theme'); ?></h2>
                <p><?php esc_html_e('Click the button below to import the demo content. This will create editable posts for:', 'finance-theme'); ?>
                </p>
                <ul style="list-style: disc; margin-left: 20px; margin-bottom: 20px;">
                    <li><?php esc_html_e('Loan Types (with images and full details)', 'finance-theme'); ?></li>
                    <li><?php esc_html_e('Testimonials', 'finance-theme'); ?></li>
                    <li><?php esc_html_e('FAQs', 'finance-theme'); ?></li>
                </ul>
                <p><strong><?php esc_html_e('Note:', 'finance-theme'); ?></strong>
                    <?php esc_html_e('This performs an update-if-exists operation for Loan Types metadata.', 'finance-theme'); ?>
                </p>

                <form method="post" action="">
                    <?php wp_nonce_field('finance_theme_import_demo', 'finance_theme_import_nonce'); ?>
                    <input type="hidden" name="finance_theme_action" value="import_demo">
                    <?php submit_button(__('Import / Update Demo Data', 'finance-theme'), 'primary'); ?>
                </form>
            </div>
        </div>
        <?php
    }

    /**
     * Handle the import process
     */
    public function handle_import()
    {
        if (!isset($_POST['finance_theme_action']) || $_POST['finance_theme_action'] !== 'import_demo') {
            return;
        }

        if (!check_admin_referer('finance_theme_import_demo', 'finance_theme_import_nonce')) {
            return;
        }

        if (!current_user_can('manage_options')) {
            return;
        }

        $count = 0;

        // Import Loan Types
        foreach ($this->loan_types as $loan) {
            // Create or Get Post
            $post_id = $this->ensure_post_exists($loan['title'], $loan['description'], 'loan_type');

            if ($post_id) {
                // Update Metadata
                if (isset($loan['meta']) && is_array($loan['meta'])) {
                    foreach ($loan['meta'] as $key => $value) {
                        update_post_meta($post_id, $key, $value);
                    }
                }

                // Set Image
                $this->sideload_image($post_id, $loan['image']);
                $count++;
            }
        }

        // Import Testimonials
        foreach ($this->testimonials as $testimonial) {
            $post_id = $this->ensure_post_exists($testimonial['title'], $testimonial['content'], 'testimonial');
            if ($post_id) {
                update_post_meta($post_id, '_testimonial_rating', $testimonial['rating']);
                update_post_meta($post_id, '_testimonial_loan_type', $testimonial['loan_type']);
                $count++;
            }
        }

        // Import FAQs
        foreach ($this->faqs as $faq) {
            if ($this->ensure_post_exists($faq['title'], $faq['content'], 'faq')) {
                $count++;
            }
        }

        add_action('admin_notices', function () use ($count) {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo sprintf(esc_html__('Successfully processed import! %d items checked/updated.', 'finance-theme'), $count); ?>
                </p>
            </div>
            <?php
        });
    }

    /**
     * Ensure post exists (create if not, return ID if yes)
     */
    private function ensure_post_exists($title, $content, $type)
    {
        $existing = get_page_by_title($title, OBJECT, $type);

        if ($existing) {
            return $existing->ID;
        }

        $post_id = wp_insert_post([
            'post_title' => $title,
            'post_content' => $content,
            'post_excerpt' => ($type === 'loan_type' || $type === 'testimonial') ? $content : '',
            'post_type' => $type,
            'post_status' => 'publish',
        ]);

        return !is_wp_error($post_id) ? $post_id : false;
    }

    /**
     * Sideload image from theme assets to Media Library
     */
    private function sideload_image($post_id, $filename)
    {
        // Don't re-upload if already has thumbnail
        if (has_post_thumbnail($post_id)) {
            return;
        }

        $image_path = get_template_directory() . '/assets/images/loans/' . $filename;

        if (!file_exists($image_path)) {
            return;
        }

        // Initialize WP_Filesystem
        global $wp_filesystem;
        if (!function_exists('WP_Filesystem')) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }
        WP_Filesystem();

        $upload_dir = wp_upload_dir();
        $image_data = $wp_filesystem->get_contents($image_path);

        if ($image_data === false) {
            return;
        }

        $filename_base = basename($filename);
        $file = $upload_dir['path'] . '/' . $filename_base;

        // Save file to uploads directory using WP Filesystem API
        $wp_filesystem->put_contents($file, $image_data, FS_CHMOD_FILE);

        $wp_filetype = wp_check_filetype($filename, null);

        $attachment = [
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        ];

        $attach_id = wp_insert_attachment($attachment, $file, $post_id);

        require_once ABSPATH . 'wp-admin/includes/image.php';

        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
        wp_update_attachment_metadata($attach_id, $attach_data);

        set_post_thumbnail($post_id, $attach_id);
    }
}

new Finance_Theme_Demo_Importer();
