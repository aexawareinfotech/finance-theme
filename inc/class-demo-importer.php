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

        // Define loan types data
        $this->loan_types = [
            [
                'title' => 'Emergency Loans',
                'description' => 'Get yourself unstuck and borrow up to $10,000 for emergencies.',
                'image' => 'emergency-loan.jpg',
            ],
            [
                'title' => 'Wedding Loans',
                'description' => 'Spread the costs of your big day with a loan up to $10,000.',
                'image' => 'wedding.jpg',
            ],
            [
                'title' => 'Education Loans',
                'description' => 'This smarter personal loan can help with all things related to studying.',
                'image' => 'education.jpg',
            ],
            [
                'title' => 'Travel Loans',
                'description' => 'Take a well-deserved break with up to $10,000 for your adventure.',
                'image' => 'online.jpg',
            ],
            [
                'title' => 'Bond Loans',
                'description' => 'Our 21-day interest-free bond loans lend a hand on moving day.',
                'image' => 'bond-loan.jpg',
            ],
            [
                'title' => 'Car Repairs',
                'description' => 'Get your car back on the road quickly with repair financing.',
                'image' => 'car-repairs.jpg',
            ],
            [
                'title' => 'Household Bills',
                'description' => 'Cover unexpected household expenses when you need it most.',
                'image' => 'online.jpg', // Reusing online.jpg
            ],
            [
                'title' => 'Vet Loans',
                'description' => 'Take care of your furry friends with quick vet expense financing.',
                'image' => 'vet-loans.jpg',
            ],
            [
                'title' => 'Cosmetic Loans',
                'description' => 'Finance your cosmetic procedures with flexible payment options.',
                'image' => 'cosmetic-surgery.jpg',
            ],
            [
                'title' => 'Medium Loans',
                'description' => 'Borrow between $2,001 to $5,000 for medium-sized expenses.',
                'image' => 'medium-loans.jpg',
            ],
            [
                'title' => 'Large Loans',
                'description' => 'Access up to $50,000 for major purchases and investments.',
                'image' => 'large-loans.jpg',
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
                <h2><?php esc_html_e('Import Demo Content', 'flavor'); ?></h2>
                <p><?php esc_html_e('Click the button below to import the demo content. This will create editable posts for:', 'flavor'); ?>
                </p>
                <ul style="list-style: disc; margin-left: 20px; margin-bottom: 20px;">
                    <li><?php esc_html_e('Loan Types (with images)', 'flavor'); ?></li>
                    <li><?php esc_html_e('Testimonials', 'flavor'); ?></li>
                    <li><?php esc_html_e('FAQs', 'flavor'); ?></li>
                </ul>
                <p><?php esc_html_e('NOTE: Please ensure you run this only once to avoid duplicate content.', 'flavor'); ?></p>

                <form method="post" action="">
                    <?php wp_nonce_field('finance_theme_import_demo', 'finance_theme_import_nonce'); ?>
                    <input type="hidden" name="finance_theme_action" value="import_demo">
                    <?php submit_button(__('Import All Demo Data', 'flavor'), 'primary'); ?>
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
            if ($this->create_post_if_not_exists($loan['title'], $loan['description'], 'loan_type')) {
                // We need the ID to attach image.
                $post = get_page_by_title($loan['title'], OBJECT, 'loan_type');
                if ($post) {
                    $this->sideload_image($post->ID, $loan['image']);
                    $count++;
                }
            }
        }

        // Import Testimonials
        foreach ($this->testimonials as $testimonial) {
            if ($this->create_post_if_not_exists($testimonial['title'], $testimonial['content'], 'testimonial')) {
                $post = get_page_by_title($testimonial['title'], OBJECT, 'testimonial');
                if ($post) {
                    update_post_meta($post->ID, '_testimonial_rating', $testimonial['rating']);
                    update_post_meta($post->ID, '_testimonial_loan_type', $testimonial['loan_type']);
                    $count++;
                }
            }
        }

        // Import FAQs
        foreach ($this->faqs as $faq) {
            if ($this->create_post_if_not_exists($faq['title'], $faq['content'], 'faq')) {
                $count++;
            }
        }

        add_action('admin_notices', function () use ($count) {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo sprintf(esc_html__('Successfully processed import! %d items checked/created.', 'flavor'), $count); ?>
                </p>
            </div>
            <?php
        });
    }

    /**
     * Helper to create post if it doesn't exist
     */
    private function create_post_if_not_exists($title, $content, $type)
    {
        $exists = get_posts([
            'post_type' => $type,
            'title' => $title,
            'posts_per_page' => 1,
            'post_status' => 'any'
        ]);

        if (!empty($exists)) {
            return false;
        }

        $post_id = wp_insert_post([
            'post_title' => $title,
            'post_content' => $content,
            'post_excerpt' => ($type === 'loan_type') ? $content : '',
            'post_type' => $type,
            'post_status' => 'publish',
        ]);

        return !is_wp_error($post_id);
    }

    /**
     * Sideload image from theme assets to Media Library
     */
    private function sideload_image($post_id, $filename)
    {
        $image_path = get_template_directory() . '/assets/images/loans/' . $filename;

        if (!file_exists($image_path)) {
            return;
        }

        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($image_path);

        if ($image_data === false) {
            return;
        }

        $filename_base = basename($filename);
        $file = $upload_dir['path'] . '/' . $filename_base;

        // Save file to uploads directory
        file_put_contents($file, $image_data);

        $wp_filetype = wp_check_filetype($filename, null);

        $attachment = [
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        ];

        $attach_id = wp_insert_attachment($attachment, $file, $post_id);

        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
        wp_update_attachment_metadata($attach_id, $attach_data);

        set_post_thumbnail($post_id, $attach_id);
    }
}

new Finance_Theme_Demo_Importer();
