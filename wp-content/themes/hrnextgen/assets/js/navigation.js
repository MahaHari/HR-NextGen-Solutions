/**
 * HR NextGen Solutions - Navigation
 * Sticky header, mobile menu, smooth scroll, dropdowns
 */

(function($) {
    'use strict';

    var $header      = $('#site-header');
    var $hamburger   = $('#hamburger-btn');
    var $mobileMenu  = $('#mobile-menu');
    var $backToTop   = $('#back-to-top');
    var headerHeight = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--header-height')) || 80;
    var isMenuOpen   = false;

    // ---- Sticky Header on Scroll ----
    function handleScroll() {
        var scrollY = window.pageYOffset;

        // Add/remove scrolled class
        if (scrollY > 50) {
            $header.addClass('scrolled');
        } else {
            $header.removeClass('scrolled');
        }

        // Back to top button visibility
        if (scrollY > 400) {
            $backToTop.addClass('visible');
        } else {
            $backToTop.removeClass('visible');
        }
    }

    window.addEventListener('scroll', HNGS.throttle(handleScroll, 16), { passive: true });
    handleScroll(); // Run once on load

    // ---- Back to Top ----
    $backToTop.on('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // ---- Mobile Menu Toggle ----
    function openMenu() {
        isMenuOpen = true;
        $hamburger.addClass('open').attr('aria-expanded', 'true');
        $mobileMenu.addClass('open').attr('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        isMenuOpen = false;
        $hamburger.removeClass('open').attr('aria-expanded', 'false');
        $mobileMenu.removeClass('open').attr('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    $hamburger.on('click', function() {
        if (isMenuOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    // Close mobile menu when a link is clicked
    $mobileMenu.find('a').on('click', function() {
        closeMenu();
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isMenuOpen) {
            closeMenu();
            $hamburger.focus();
        }
    });

    // ---- Smooth Scroll for Anchor Links ----
    $(document).on('click', 'a[href^="#"]', function(e) {
        var href   = $(this).attr('href');
        if (href === '#') return;
        var target = document.querySelector(href);
        if (!target) return;

        e.preventDefault();
        closeMenu();

        // Get current header height (may be smaller when scrolled)
        var currentHeaderHeight = $header.hasClass('scrolled') ?
            parseInt(getComputedStyle(document.documentElement).getPropertyValue('--header-height-scrolled')) || 64 :
            headerHeight;

        var targetTop = target.getBoundingClientRect().top + window.pageYOffset - currentHeaderHeight - 8;
        window.scrollTo({ top: targetTop, behavior: 'smooth' });
    });

    // ---- Active nav link highlighting ----
    function updateActiveLink() {
        var scrollY = window.pageYOffset + headerHeight + 20;
        var sections = document.querySelectorAll('section[id]');
        var current  = '';

        sections.forEach(function(section) {
            if (section.offsetTop <= scrollY) {
                current = section.id;
            }
        });

        $('.nav-link').removeClass('active');
        if (current) {
            $('.nav-link[href="#' + current + '"]').addClass('active');
        }
    }

    window.addEventListener('scroll', HNGS.throttle(updateActiveLink, 100), { passive: true });
    updateActiveLink();

    // ---- Keyboard accessibility for dropdowns ----
    $('.nav-item').each(function() {
        var $item     = $(this);
        var $link     = $item.find('.nav-link').first();
        var $dropdown = $item.find('.nav-dropdown');

        if ($dropdown.length === 0) return;

        $link.on('focus', function() {
            $dropdown.css({ opacity: 1, pointerEvents: 'all', transform: 'translateX(-50%) translateY(0)' });
        });

        $item.on('focusout', function(e) {
            // Small delay to allow focus to move inside dropdown
            setTimeout(function() {
                if (!$item[0].contains(document.activeElement)) {
                    $dropdown.css({ opacity: '', pointerEvents: '', transform: '' });
                }
            }, 100);
        });
    });

})(jQuery);
