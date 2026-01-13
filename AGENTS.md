# AGENTS.md - Finance Theme Development Guide

## Build, Lint, and Test Commands

### Theme Release
```bash
npm run release          # Run semantic-release to create a new version
```

### GitHub Actions Workflow
The release workflow (`.github/workflows/release.yml`) is triggered on push to `main`:
- Installs npm dependencies (`npm install`)
- Creates a theme zip excluding node_modules, .git, .github, and config files
- Runs semantic-release to generate changelog and GitHub release

### PHP Linting (Recommended)
```bash
# Install PHP_CodeSniffer with WordPress standards
composer require --dev wp-coding-standards/wpcs squizlabs/php_codesniffer

# Run WordPress coding standards check
./vendor/bin/phpcs --standard=WordPressCore functions.php inc/

# Auto-fix issues
./vendor/bin/phpcbf --standard=WordPressCore functions.php inc/
```

### CSS Validation
```bash
# Validate CSS using W3C validator (external service)
# No local tool configured - validate via https://jigsaw.w3.org/css-validator/
```

## Code Style Guidelines

### PHP (WordPress Standards)
- Use `declare(strict_types=1);` at the top of PHP files
- Always define `ABSPATH` check: `if (!defined('ABSPATH')) { exit; }`
- Prefix all functions with `flavor_` or `finance_`
- Use PascalCase for classes, snake_case for functions
- Return types required for PHP 7.4+: `function name(): return_type`
- Use WordPress escaping functions: `esc_html__()`, `esc_attr()`, `esc_url()`
- Use WordPress i18n functions: `__()`, `_e()`, `esc_html__()`
- Hooks must use proper priority: `add_action('hook', 'callback', priority)`
- Constants use `FINANCE_THEME_` prefix: `define('FINANCE_THEME_VERSION', '1.0.0');`

Example:
```php
function flavor_get_loan_types(): array {
    $loans = get_posts([...]);
    if (empty($loans)) {
        return [...];
    }
    return array_map(fn($loan) => [...], $loans);
}
```

### JavaScript
- Use ES6+ syntax
- Modular functions with single responsibility
- Event listeners wrapped in DOMContentLoaded
- Use strict equality (`===`) and null coalescing (`??`)
- Accessibility: include `aria-*` attributes where appropriate
- Prefix init functions with `init`: `function initMobileMenu()`

Example:
```javascript
function initMobileMenu() {
    const toggle = document.getElementById('mobile-menu-toggle');
    if (!toggle) return;
    toggle.addEventListener('click', () => {
        // handler
    });
}
```

### CSS
- Use CSS custom properties (variables) for all values
- Prefix variables with `--`: `--primary-900`, `--space-4`
- Mobile-first responsive design (min-width media queries)
- Use BEM-like naming: `.block__element--modifier`
- Color palette: Primary (dark teal/slate), Accent (lime green), Neutral
- Spacing scale: `--space-1` through `--space-24` (0.25rem increments)
- Font sizes: `--text-xs` through `--text-6xl`
- Transitions: `--transition-fast` (150ms), `--transition-base` (250ms)
- Border radius: `--radius-sm` through `--radius-full`
- Shadows: `--shadow-sm` through `--shadow-2xl`
- Z-index scale: `--z-dropdown` (100) through `--z-tooltip` (700)

### File Organization
- Main PHP files: `functions.php`, `header.php`, `footer.php`, `front-page.php`, etc.
- Template files: `template-*.php` for custom page templates
- Includes: `inc/` directory for core functionality
- Assets: `assets/js/` for JavaScript, `style.css` for styles
- Text domain: `finance-theme` (defined in style.css header)

### WordPress Theme Requirements
- Theme header in style.css required fields: Theme Name, Author, Version, License
- Text domain must match style.css header: `finance-theme`
- Use WordPress Customizer for theme settings (`$wp_customize->add_setting()`)
- Register nav menus with `register_nav_menus()`
- Register sidebars with `register_sidebar()`
- Add theme support in `after_setup_theme` hook
- Enqueue scripts/styles in `wp_enqueue_scripts` hook

### Error Handling
- PHP: Return early for empty states, use `empty()` checks
- JavaScript: Early returns for missing DOM elements
- WordPress: Use `is_wp_error()` for HTTP responses
- Graceful degradation for missing features

### Accessibility
- Use semantic HTML5 elements (`<nav>`, `<main>`, `<section>`)
- Include `skip-link` for keyboard navigation
- Focus visible styles with `:focus-visible`
- `aria-expanded`, `aria-controls` for interactive elements
- `prefers-reduced-motion` media query support