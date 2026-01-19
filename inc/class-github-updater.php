<?php
/**
 * GitHub Theme Updater
 *
 * Enables automatic theme updates from a GitHub repository.
 *
 * @package FinanceTheme
 * @author Aexaware Infotech
 */

if (!defined('ABSPATH')) {
    exit;
}

class Finance_Theme_GitHub_Updater
{
    private string $slug;
    private string $username;
    private string $repo;
    private string $branch;
    private ?string $authorize_token;
    private ?array $github_response;

    public function __construct()
    {
        $this->slug = 'finance-theme';
        $this->username = 'aexawareinfotech';
        $this->repo = 'finance-theme';
        $this->branch = 'main';
        $this->authorize_token = defined('GITHUB_ACCESS_TOKEN') ? GITHUB_ACCESS_TOKEN : null;
        $this->github_response = null;

        add_filter('pre_set_site_transient_update_themes', [$this, 'check_update']);
        add_filter('themes_api', [$this, 'theme_info'], 20, 3);
        add_filter('upgrader_source_selection', [$this, 'filter_source_selection'], 10, 4);
        add_filter('upgrader_post_install', [$this, 'after_install'], 10, 3);
        add_action('core_upgrade_preamble', [$this, 'display_update_info']);
    }

    /**
     * Filter source selection - FIX FOR WORDPRESS THEME UPGRADER
     * 
     * WordPress extracts ZIP to a temp folder. We need to find where style.css actually is
     * and return that path, otherwise WordPress fails with "missing style.css" error.
     */
    public function filter_source_selection($source, $remote_source, $upgrader, $hook_extra)
    {
        // Only handle our theme updates
        if (!isset($hook_extra['theme']) || $hook_extra['theme'] !== $this->slug) {
            return $source;
        }

        global $wp_filesystem;
        if (!$wp_filesystem) {
            return $source;
        }

        $source = untrailingslashit($source);

        // Log for debugging (can check in wp-content/debug.log if WP_DEBUG_LOG is enabled)
        error_log("Finance Theme Updater - Source: $source");
        error_log("Finance Theme Updater - Remote Source: $remote_source");

        // CASE 1: style.css is directly in source
        if ($wp_filesystem->exists($source . '/style.css')) {
            error_log("Finance Theme Updater - Found style.css directly in source");
            return trailingslashit($source);
        }

        // CASE 2: style.css is in a subdirectory (our ZIP structure: finance-theme/style.css)
        // Need to find the actual theme folder
        $dirlist = $wp_filesystem->dirlist($source);

        if (is_array($dirlist)) {
            foreach ($dirlist as $folder_name => $folder_info) {
                if ($folder_info['type'] !== 'd') {
                    continue;
                }

                $potential_theme_dir = $source . '/' . $folder_name;

                if ($wp_filesystem->exists($potential_theme_dir . '/style.css')) {
                    error_log("Finance Theme Updater - Found style.css in subfolder: $folder_name");

                    // WordPress wants the theme to be in a folder matching the slug
                    // If folder name already matches, just return it
                    if ($folder_name === $this->slug) {
                        return trailingslashit($potential_theme_dir);
                    }

                    // Folder name doesn't match slug - rename it
                    $correct_path = $source . '/' . $this->slug;

                    if ($wp_filesystem->exists($correct_path)) {
                        $wp_filesystem->delete($correct_path, true);
                    }

                    $moved = $wp_filesystem->move($potential_theme_dir, $correct_path);
                    error_log("Finance Theme Updater - Moved to $correct_path: " . ($moved ? 'success' : 'failed'));

                    if ($moved) {
                        return trailingslashit($correct_path);
                    }

                    // If move failed, return original (might still work)
                    return trailingslashit($potential_theme_dir);
                }
            }
        }

        // CASE 3: Check one more level deep (shouldn't happen with our ZIP but just in case)
        if (is_array($dirlist)) {
            foreach ($dirlist as $folder_name => $folder_info) {
                if ($folder_info['type'] !== 'd') {
                    continue;
                }

                $subdir = $source . '/' . $folder_name;
                $subdirlist = $wp_filesystem->dirlist($subdir);

                if (is_array($subdirlist)) {
                    foreach ($subdirlist as $subfolder_name => $subfolder_info) {
                        if ($subfolder_info['type'] !== 'd') {
                            continue;
                        }

                        $deep_path = $subdir . '/' . $subfolder_name;
                        if ($wp_filesystem->exists($deep_path . '/style.css')) {
                            error_log("Finance Theme Updater - Found style.css two levels deep: $deep_path");

                            $correct_path = $source . '/' . $this->slug;
                            if ($wp_filesystem->exists($correct_path)) {
                                $wp_filesystem->delete($correct_path, true);
                            }

                            if ($wp_filesystem->move($deep_path, $correct_path)) {
                                return trailingslashit($correct_path);
                            }

                            return trailingslashit($deep_path);
                        }
                    }
                }
            }
        }

        error_log("Finance Theme Updater - Could not find style.css anywhere!");
        error_log("Finance Theme Updater - Source contents: " . print_r($dirlist, true));

        return $source;
    }

    private function get_repository_info(): void
    {
        if (!empty($this->github_response)) {
            return;
        }

        $request_uri = sprintf(
            'https://api.github.com/repos/%s/%s/releases/latest',
            $this->username,
            $this->repo
        );

        $args = [
            'timeout' => 10,
            'headers' => [
                'Accept' => 'application/vnd.github.v3+json',
            ],
        ];

        if ($this->authorize_token) {
            $args['headers']['Authorization'] = 'token ' . $this->authorize_token;
        }

        $response = wp_remote_get($request_uri, $args);

        if (is_wp_error($response)) {
            return;
        }

        if (wp_remote_retrieve_response_code($response) !== 200) {
            return;
        }

        $this->github_response = json_decode(wp_remote_retrieve_body($response), true);
    }

    public function check_update($transient)
    {
        if (empty($transient->checked)) {
            return $transient;
        }

        $this->get_repository_info();

        if (empty($this->github_response)) {
            return $transient;
        }

        $theme = wp_get_theme($this->slug);
        if (!$theme->exists()) {
            return $transient;
        }

        $current_version = $theme->get('Version');
        $github_version = ltrim($this->github_response['tag_name'] ?? '', 'v');

        if ($github_version && version_compare($github_version, $current_version, '>')) {
            $package = $this->get_release_package();

            if ($this->authorize_token) {
                $package = add_query_arg(['access_token' => $this->authorize_token], $package);
            }

            $transient->response[$this->slug] = [
                'theme' => $this->slug,
                'new_version' => $github_version,
                'url' => $this->github_response['html_url'],
                'package' => $package,
            ];
        }

        return $transient;
    }

    public function theme_info($result, $action, $args)
    {
        if ($action !== 'theme_information' || !isset($args->slug) || $args->slug !== $this->slug) {
            return $result;
        }

        $this->get_repository_info();

        if (empty($this->github_response)) {
            return $result;
        }

        $theme = wp_get_theme($this->slug);

        return (object) [
            'name' => $theme->get('Name'),
            'slug' => $this->slug,
            'version' => ltrim($this->github_response['tag_name'], 'v'),
            'author' => $theme->get('Author'),
            'author_profile' => $theme->get('AuthorURI'),
            'requires' => $theme->get('RequiresWP'),
            'tested' => $theme->get('TestedUpTo'),
            'requires_php' => $theme->get('RequiresPHP'),
            'last_updated' => $this->github_response['published_at'],
            'homepage' => $theme->get('ThemeURI'),
            'sections' => [
                'description' => $theme->get('Description'),
                'changelog' => $this->get_changelog(),
            ],
            'download_link' => $this->get_release_package(),
        ];
    }

    private function get_release_package(): string
    {
        if (!empty($this->github_response['assets'])) {
            foreach ($this->github_response['assets'] as $asset) {
                if (($asset['name'] ?? '') === 'finance-theme.zip') {
                    return $asset['browser_download_url'];
                }
            }
            // Fallback to any ZIP
            foreach ($this->github_response['assets'] as $asset) {
                if (str_ends_with($asset['name'] ?? '', '.zip')) {
                    return $asset['browser_download_url'];
                }
            }
        }

        return $this->github_response['zipball_url'] ?? '';
    }

    private function get_changelog(): string
    {
        if (empty($this->github_response['body'])) {
            return '<p>No changelog available.</p>';
        }
        return '<pre>' . esc_html($this->github_response['body']) . '</pre>';
    }

    public function after_install($response, $hook_extra, $result)
    {
        global $wp_filesystem;

        if (!isset($hook_extra['theme']) || $hook_extra['theme'] !== $this->slug) {
            return $result;
        }

        $theme_dir = trailingslashit(get_theme_root()) . $this->slug;
        $source = untrailingslashit($result['destination'] ?? '');

        if (!$source || !$wp_filesystem) {
            return $result;
        }

        error_log("Finance Theme Updater after_install - Source: $source, Target: $theme_dir");

        if ($source !== $theme_dir) {
            if ($wp_filesystem->exists($theme_dir)) {
                $wp_filesystem->delete($theme_dir, true);
            }

            if ($wp_filesystem->move($source, $theme_dir)) {
                $result['destination'] = $theme_dir;
                $result['destination_name'] = $this->slug;
            }
        }

        if (get_option('template') === $this->slug) {
            switch_theme($this->slug);
        }

        return $result;
    }

    public function display_update_info(): void
    {
        $theme = wp_get_theme($this->slug);
        if (!$theme->exists()) {
            return;
        }
        ?>
        <div class="notice notice-info">
            <p>
                <strong><?php echo esc_html($theme->get('Name')); ?></strong>
                <?php esc_html_e('receives automatic updates from GitHub.', 'finance-theme'); ?>
                <a href="https://github.com/<?php echo esc_attr($this->username . '/' . $this->repo); ?>" target="_blank">
                    <?php esc_html_e('View on GitHub', 'finance-theme'); ?>
                </a>
            </p>
        </div>
        <?php
    }
}

new Finance_Theme_GitHub_Updater();
