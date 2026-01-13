<?php
/**
 * Theme Required Plugins
 *
 * Uses TGM Plugin Activation to require the CPT plugin.
 *
 * @package FinanceTheme
 * @author Aexaware Infotech
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once FINANCE_THEME_DIR . '/inc/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'finance_theme_register_required_plugins');

/**
 * Register the required plugin for this theme.
 */
function finance_theme_register_required_plugins(): void
{
    $plugins = [
        [
            'name' => 'Finance Theme - Custom Post Types',
            'slug' => 'finance-theme-cpt',
            'source' => FINANCE_THEME_DIR . '/inc/plugins/finance-theme-cpt.zip',
            'required' => true,
            'version' => '1.0.0',
            'force_activation' => false,
            'force_deactivation' => false,
        ],
    ];

    $config = [
        'id' => 'finance-theme',
        'default_path' => '',
        'menu' => 'tgmpa-install-plugins',
        'parent_slug' => 'themes.php',
        'capability' => 'edit_theme_options',
        'has_notices' => true,
        'dismissable' => false,
        'dismiss_msg' => '',
        'is_automatic' => true,
        'message' => '',
        'strings' => [
            'page_title' => __('Install Required Plugin', 'finance-theme'),
            'menu_title' => __('Install Plugin', 'finance-theme'),
            'installing' => __('Installing Plugin: %s', 'finance-theme'),
            'updating' => __('Updating Plugin: %s', 'finance-theme'),
            'oops' => __('Something went wrong with the plugin API.', 'finance-theme'),
            'notice_can_install_required' => _n_noop(
                'Finance Theme requires the following plugin: %1$s.',
                'Finance Theme requires the following plugins: %1$s.',
                'finance-theme'
            ),
            'notice_can_activate_required' => _n_noop(
                'The following required plugin is currently inactive: %1$s.',
                'The following required plugins are currently inactive: %1$s.',
                'finance-theme'
            ),
            'install_link' => _n_noop(
                'Begin installing plugin',
                'Begin installing plugins',
                'finance-theme'
            ),
            'activate_link' => _n_noop(
                'Begin activating plugin',
                'Begin activating plugins',
                'finance-theme'
            ),
            'return' => __('Return to Required Plugins Installer', 'finance-theme'),
            'plugin_activated' => __('Plugin activated successfully.', 'finance-theme'),
            'activated_successfully' => __('The following plugin was activated successfully:', 'finance-theme'),
            'plugin_already_active' => __('No action taken. Plugin %1$s was already active.', 'finance-theme'),
            'complete' => __('All plugins installed and activated successfully. %1$s', 'finance-theme'),
            'dismiss' => __('Dismiss this notice', 'finance-theme'),
            'notice_cannot_install_activate' => __('There is a required plugin to install and activate.', 'finance-theme'),
            'contact_admin' => __('Please contact the administrator of this site for help.', 'finance-theme'),
        ],
    ];

    tgmpa($plugins, $config);
}
