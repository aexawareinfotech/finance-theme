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
    private string $theme_data;
    private string $username;
    private string $repo;
    private string $branch;
    private ?string $authorize_token;
    private ?array $github_response;

    public function __construct()
    {
        $this->slug = get_option('template');
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

    public function filter_source_selection($source, $remote_source, $upgrader, $hook_extra)
    {
        if (!isset($hook_extra['theme']) || $hook_extra['theme'] !== $this->slug) {
            return $source;
        }

        global $wp_filesystem;

        if (!$wp_filesystem) {
            return $source;
        }

        $resolved_source = $this->resolve_source_dir($source, $wp_filesystem);
        $base_dir = untrailingslashit($remote_source);
        $proper_source = $base_dir . '/' . $this->slug;

        if ($resolved_source === $proper_source) {
            return $resolved_source;
        }

        if (!$this->is_matching_theme_dir($resolved_source)) {
            return $source;
        }

        if ($wp_filesystem->exists($proper_source)) {
            $wp_filesystem->delete($proper_source, true);
        }

        if ($wp_filesystem->move($resolved_source, $proper_source)) {
            return $proper_source;
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

        $args = [];
        if ($this->authorize_token) {
            $args['headers'] = [
                'Authorization' => 'token ' . $this->authorize_token,
            ];
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
        $current_version = $theme->get('Version');
        $github_version = ltrim($this->github_response['tag_name'], 'v');

        if (version_compare($github_version, $current_version, '>')) {
            // Try to get the release asset (our properly named zip)
            $package = null;
            if (!empty($this->github_response['assets'])) {
                foreach ($this->github_response['assets'] as $asset) {
                    if (strpos($asset['name'], '.zip') !== false) {
                        $package = $asset['browser_download_url'];
                        break;
                    }
                }
            }

            // Fallback to zipball if no asset found
            if (!$package) {
                $package = $this->github_response['zipball_url'];
            }

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
            'download_link' => $this->github_response['zipball_url'],
        ];
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

    private function resolve_source_dir(string $source_dir, $filesystem): string
    {
        $source_dir = untrailingslashit($source_dir);

        if ($filesystem->exists($source_dir . '/style.css')) {
            return $source_dir;
        }

        $source_files = $filesystem->dirlist($source_dir);
        if (!$source_files || !is_array($source_files)) {
            return $source_dir;
        }

        if (isset($source_files[$this->slug]) && $source_files[$this->slug]['type'] === 'd') {
            $candidate = $source_dir . '/' . $this->slug;
            if ($filesystem->exists($candidate . '/style.css')) {
                return $candidate;
            }
        }

        foreach ($source_files as $folder => $details) {
            if (!is_array($details) || $details['type'] !== 'd') {
                continue;
            }

            $candidate = $source_dir . '/' . $folder;
            if ($filesystem->exists($candidate . '/style.css')) {
                return $candidate;
            }
        }

        if (count($source_files) === 1) {
            $subfolder = key($source_files);
            if ($source_files[$subfolder]['type'] === 'd') {
                $candidate = $source_dir . '/' . $subfolder;
                if ($filesystem->exists($candidate . '/style.css')) {
                    return $candidate;
                }
            }
        }

        return $source_dir;
    }

    private function is_matching_theme_dir(string $source_dir): bool
    {
        $stylesheet = untrailingslashit($source_dir) . '/style.css';

        if (!file_exists($stylesheet)) {
            return false;
        }

        $headers = get_file_data(
            $stylesheet,
            [
                'name' => 'Theme Name',
                'textdomain' => 'Text Domain',
            ],
            'theme'
        );

        $theme_name = strtolower(trim((string) $headers['name']));
        $theme_domain = strtolower(trim((string) $headers['textdomain']));
        $current_theme = wp_get_theme($this->slug);
        $current_name = strtolower(trim((string) $current_theme->get('Name')));

        if ($theme_domain && $theme_domain === $this->slug) {
            return true;
        }

        return $theme_name !== '' && $theme_name === $current_name;
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
        $source_dir = $result['destination'];
        $resolved_source_dir = $this->resolve_source_dir($source_dir, $wp_filesystem);

        if ($resolved_source_dir === $theme_dir) {
            return $result;
        }

        if (!$this->is_matching_theme_dir($resolved_source_dir)) {
            return $result;
        }

        if (strpos($resolved_source_dir, $theme_dir . '/') === 0) {
            $temp_dir = $theme_dir . '-tmp';
            if ($wp_filesystem->exists($temp_dir)) {
                $wp_filesystem->delete($temp_dir, true);
            }
            $wp_filesystem->move($resolved_source_dir, $temp_dir);
            if ($wp_filesystem->exists($theme_dir)) {
                $wp_filesystem->delete($theme_dir, true);
            }
            $wp_filesystem->move($temp_dir, $theme_dir);
        } else {
            if ($wp_filesystem->exists($theme_dir)) {
                $wp_filesystem->delete($theme_dir, true);
            }
            $wp_filesystem->move($resolved_source_dir, $theme_dir);
        }

        $result['destination'] = $theme_dir;
        $result['destination_name'] = $this->slug;

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
