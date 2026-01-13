/**
 * Main JavaScript for Fair Go Finance Theme
 * Mobile navigation, header scroll, FAQ accordion, animations
 */

document.addEventListener('DOMContentLoaded', function () {
    // Mobile Menu Toggle
    initMobileMenu();

    // Header Scroll Effect
    initHeaderScroll();

    // FAQ Accordion
    initFAQAccordion();

    // Smooth Scroll for Anchor Links
    initSmoothScroll();

    // Loan Calculator Slider
    initLoanCalculator();

    // Animate on Scroll
    initScrollAnimations();

    // Search Overlay
    initSearchOverlay();
});

/**
 * Loan Calculator Slider
 */
function initLoanCalculator() {
    const slider = document.getElementById('loan-amount-slider');
    const display = document.getElementById('loan-amount-display');

    if (!slider || !display) return;

    function updateSlider() {
        const value = parseInt(slider.value);
        const min = parseInt(slider.min);
        const max = parseInt(slider.max);
        const percent = ((value - min) / (max - min)) * 100;

        // Update display with formatted number
        display.textContent = '$' + value.toLocaleString();

        // Update slider track color
        slider.style.setProperty('--slider-percent', percent + '%');
    }

    slider.addEventListener('input', updateSlider);

    // Initialize
    updateSlider();
}

/**
 * Mobile Menu Toggle
 */
function initMobileMenu() {
    const toggle = document.getElementById('mobile-menu-toggle');
    const menu = document.getElementById('mobile-menu');
    const body = document.body;

    if (!toggle || !menu) return;

    toggle.addEventListener('click', function () {
        const isActive = toggle.classList.toggle('active');
        menu.classList.toggle('active');
        toggle.setAttribute('aria-expanded', isActive);

        // Prevent body scroll when menu is open
        if (isActive) {
            body.style.overflow = 'hidden';
        } else {
            body.style.overflow = '';
        }
    });

    // Close menu when clicking on a link
    menu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function () {
            toggle.classList.remove('active');
            menu.classList.remove('active');
            toggle.setAttribute('aria-expanded', 'false');
            body.style.overflow = '';
        });
    });

    // Close menu on escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && menu.classList.contains('active')) {
            toggle.classList.remove('active');
            menu.classList.remove('active');
            toggle.setAttribute('aria-expanded', 'false');
            body.style.overflow = '';
        }
    });
}

/**
 * Header Scroll Effect
 */
function initHeaderScroll() {
    const header = document.getElementById('site-header');
    if (!header) return;

    let lastScrollY = window.scrollY;
    let ticking = false;

    function updateHeader() {
        const scrollY = window.scrollY;

        if (scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        lastScrollY = scrollY;
        ticking = false;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) {
            window.requestAnimationFrame(updateHeader);
            ticking = true;
        }
    }, { passive: true });
}

/**
 * FAQ Accordion
 */
function initFAQAccordion() {
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');

        if (question) {
            question.addEventListener('click', function () {
                const isActive = item.classList.contains('active');

                // Close all other items
                faqItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                        otherItem.querySelector('.faq-question')?.setAttribute('aria-expanded', 'false');
                    }
                });

                // Toggle current item
                item.classList.toggle('active');
                question.setAttribute('aria-expanded', !isActive);
            });
        }
    });
}

/**
 * Smooth Scroll for Anchor Links
 */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                const headerHeight = document.getElementById('site-header')?.offsetHeight || 0;
                const targetPosition = target.getBoundingClientRect().top + window.scrollY - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

/**
 * Animate Elements on Scroll - Disabled
 */
function initScrollAnimations() {
    // Animations disabled for cleaner aesthetic
    return;

    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -20px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe elements that should animate
    const animateElements = document.querySelectorAll(
        '.hero-block, .loan-card, .process-step, .testimonial-card, .blog-card, .stat-item'
    );

    animateElements.forEach((el, index) => {
        // Set initial state with CSS
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        el.style.transitionDelay = `${index * 0.05}s`;

        // Immediately check if element is already in view
        const rect = el.getBoundingClientRect();
        const isInView = rect.top < window.innerHeight && rect.bottom > 0;

        if (isInView) {
            // Element is already visible, animate it immediately
            setTimeout(() => {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, 100 + (index * 50));
        } else {
            // Observe for scroll
            observer.observe(el);
        }
    });
}

/**
 * Utility: Debounce function
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Utility: Throttle function
 */
function throttle(func, limit) {
    let inThrottle;
    return function (...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

/**
 * Search Overlay Toggle
 */
function initSearchOverlay() {
    const searchToggle = document.getElementById('search-toggle');
    const searchOverlay = document.getElementById('search-overlay');
    const searchClose = document.getElementById('search-close');
    const searchInput = document.getElementById('search-field');

    if (!searchToggle || !searchOverlay) return;

    function openSearch() {
        searchOverlay.classList.add('active');
        searchOverlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        // Focus the input after animation
        setTimeout(() => {
            if (searchInput) searchInput.focus();
        }, 100);
    }

    function closeSearch() {
        searchOverlay.classList.remove('active');
        searchOverlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';

        // Return focus to toggle button
        searchToggle.focus();
    }

    // Toggle button click
    searchToggle.addEventListener('click', openSearch);

    // Close button click
    if (searchClose) {
        searchClose.addEventListener('click', closeSearch);
    }

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
            closeSearch();
        }
    });

    // Close when clicking outside the form
    searchOverlay.addEventListener('click', function (e) {
        if (e.target === searchOverlay) {
            closeSearch();
        }
    });
}
