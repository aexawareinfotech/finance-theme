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
        // Hard-code the slug to ensure consistency
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

        // Add update check info to theme details
        add_action('core_upgrade_preamble', [$this, 'display_update_info']);
    }

    /**
     * Filter source selection to handle ZIP structure
     */
    public function filter_source_selection($source, $remote_source, $upgrader, $hook_extra)
    {
        // Only handle our theme
        if (!isset($hook_extra['theme']) || $hook_extra['theme'] !== $this->slug) {
            return $source;
        }

        global $wp_filesystem;

        if (!$wp_filesystem) {
            return $source;
        }

        // The source should already be correct since we create the ZIP with finance-theme/ folder
        // But let's verify and handle edge cases
        $source = untrailingslashit($source);

        // Check if style.css exists directly in source
        if ($wp_filesystem->exists($source . '/style.css')) {
            // Source is correct, check if folder name matches
            $source_name = basename($source);
            if ($source_name === $this->slug) {
                return trailingslashit($source);
            }

            // Folder name doesn't match, rename it
            $proper_destination = dirname($source) . '/' . $this->slug;
            if ($wp_filesystem->exists($proper_destination)) {
                $wp_filesystem->delete($proper_destination, true);
            }

            if ($wp_filesystem->move($source, $proper_destination)) {
                return trailingslashit($proper_destination);
            }
        }

        // Check subdirectories for style.css
        $dirlist = $wp_filesystem->dirlist($source);
        if (is_array($dirlist)) {
            foreach ($dirlist as $name => $details) {
                if ($details['type'] !== 'd') {
                    continue;
                }

                $subdir = $source . '/' . $name;
                if ($wp_filesystem->exists($subdir . '/style.css')) {
                    // Found the theme in a subdirectory
                    $proper_destination = dirname($source) . '/' . $this->slug;

                    if ($wp_filesystem->exists($proper_destination)) {
                        $wp_filesystem->delete($proper_destination, true);
                    }

                    if ($wp_filesystem->move($subdir, $proper_destination)) {
                        return trailingslashit($proper_destination);
                    }
                    return trailingslashit($subdir);
                }
            }
        }

        return $source;
    }

    /**
     * Get repository info from GitHub
     */
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

        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code !== 200) {
            return;
        }

        $body = wp_remote_retrieve_body($response);
        $this->github_response = json_decode($body, true);
    }

    /**
     * Check for theme updates
     */
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

        if (!$github_version) {
            return $transient;
        }

        if (version_compare($github_version, $current_version, '>')) {
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

    /**
     * Return theme info for the update popup
     */
    public function theme_info($result, $action, $args)
    {
        if ($action !== 'theme_information') {
            return $result;
        }

        if (!isset($args->slug) || $args->slug !== $this->slug) {
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
            'rating' => 100,
            'num_ratings' => 0,
            'downloaded' => 0,
            'last_updated' => $this->github_response['published_at'],
            'homepage' => $theme->get('ThemeURI'),
            'sections' => [
                'description' => $theme->get('Description'),
                'changelog' => $this->get_changelog(),
            ],
            'download_link' => $this->get_release_package(),
        ];
    }

    /**
     * Get the release package URL (prefer ZIP asset over zipball)
     */
    private function get_release_package(): string
    {
        $package = '';

        if (!empty($this->github_response['assets'])) {
            foreach ($this->github_response['assets'] as $asset) {
                if (!isset($asset['name'], $asset['browser_download_url'])) {
                    continue;
                }

                if ($asset['name'] === 'finance-theme.zip') {
                    return $asset['browser_download_url'];
                }

                if ($package === '' && substr($asset['name'], -4) === '.zip') {
                    $package = $asset['browser_download_url'];
                }
            }
        }

        if ($package !== '') {
            return $package;
        }

        return $this->github_response['zipball_url'] ?? '';
    }

    /**
     * Get changelog from release body
     */
    private function get_changelog(): string
    {
        if (empty($this->github_response['body'])) {
            return '<p>No changelog available.</p>';
        }

        return '<pre>' . esc_html($this->github_response['body']) . '</pre>';
    }

    /**
     * Fix folder name after install
     */
    public function after_install($response, $hook_extra, $result)
    {
        global $wp_filesystem;

        if (!isset($hook_extra['theme']) || $hook_extra['theme'] !== $this->slug) {
            return $result;
        }

        $theme_dir = trailingslashit(get_theme_root()) . $this->slug;
        $source = $result['destination'] ?? '';

        if (empty($source) || !$wp_filesystem) {
            return $result;
        }

        $source = untrailingslashit($source);

        // If already in the correct location, nothing to do
        if ($source === $theme_dir) {
            // Reactivate theme if it was active
            if (get_option('template') === $this->slug) {
                switch_theme($this->slug);
            }
            return $result;
        }

        // Move to correct location if needed
        if ($wp_filesystem->exists($theme_dir)) {
            $wp_filesystem->delete($theme_dir, true);
        }

        if ($wp_filesystem->move($source, $theme_dir)) {
            $result['destination'] = $theme_dir;
            $result['destination_name'] = $this->slug;
        }

        // Reactivate theme if it was active
        if (get_option('template') === $this->slug) {
            switch_theme($this->slug);
        }

        return $result;
    }

    /**
     * Display update info
     */
    public function display_update_info(): void
    {
        $theme = wp_get_theme($this->slug);
        if (!$theme->exists()) {
            return;
        }
        ?>
        <div class="notice notice-info">
            <p>
                <strong>
                    <?php echo esc_html($theme->get('Name')); ?>
                </strong>
                <?php esc_html_e('receives automatic updates from GitHub.', 'finance-theme'); ?>
                <a href="https://github.com/<?php echo esc_attr($this->username . '/' . $this->repo); ?>" target="_blank">
                    <?php esc_html_e('View on GitHub', 'finance-theme'); ?>
                </a>
            </p>
        </div>
        <?php
    }
}

// Initialize the updater
new Finance_Theme_GitHub_Updater();
