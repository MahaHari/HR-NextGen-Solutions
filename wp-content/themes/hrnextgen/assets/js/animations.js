/**
 * HR NextGen Solutions - Scroll Animations
 * Intersection Observer for reveal animations + counter animation
 */

(function() {
    'use strict';

    // ---- Intersection Observer for Reveal Animations ----
    var revealObserver;

    function initRevealObserver() {
        if (!('IntersectionObserver' in window)) {
            // Fallback: show everything immediately
            document.querySelectorAll('.reveal, .reveal--left, .reveal--right, .reveal--scale').forEach(function(el) {
                el.classList.add('revealed');
            });
            return;
        }

        revealObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -60px 0px',
        });

        document.querySelectorAll('.reveal, .reveal--left, .reveal--right, .reveal--scale').forEach(function(el) {
            revealObserver.observe(el);
        });
    }

    // ---- Counter Animation for Hero Stats ----
    var counterObserver;
    var countersAnimated = false;

    function initCounterObserver() {
        var statsContainer = document.querySelector('.hero-stats');
        if (!statsContainer) return;

        if (!('IntersectionObserver' in window)) {
            animateAllCounters();
            return;
        }

        counterObserver = new IntersectionObserver(function(entries) {
            if (entries[0].isIntersecting && !countersAnimated) {
                countersAnimated = true;
                animateAllCounters();
                counterObserver.disconnect();
            }
        }, { threshold: 0.5 });

        counterObserver.observe(statsContainer);
    }

    function animateAllCounters() {
        var statEls = document.querySelectorAll('.hero-stat-value[data-target]');
        statEls.forEach(function(el, index) {
            var raw    = el.getAttribute('data-target') || el.textContent;
            var parsed = HNGS.parseStat(raw);

            if (parsed.number > 0) {
                // Stagger the start of each counter
                setTimeout(function() {
                    HNGS.animateCounter(el, 0, parsed.number, 1800, parsed.suffix);
                }, index * 120);
            }
        });
    }

    // ---- Process Timeline Animation ----
    var processAnimated = false;

    function initProcessAnimation() {
        var processSection = document.getElementById('process-steps');
        var lineFill       = document.getElementById('process-line-fill');
        if (!processSection || !lineFill) return;

        if (!('IntersectionObserver' in window)) {
            activateAllSteps();
            return;
        }

        var processObserver = new IntersectionObserver(function(entries) {
            if (entries[0].isIntersecting && !processAnimated) {
                processAnimated = true;
                animateProcessLine();
                processObserver.disconnect();
            }
        }, { threshold: 0.3 });

        processObserver.observe(processSection);
    }

    function animateProcessLine() {
        var lineFill = document.getElementById('process-line-fill');
        var steps    = document.querySelectorAll('.process-step');
        if (!lineFill || !steps.length) return;

        var container   = document.getElementById('process-steps');
        var totalWidth  = container.offsetWidth - (container.offsetWidth / steps.length);
        lineFill.style.width = '0px';

        var startTime   = null;
        var duration    = 2000;
        var stepCount   = steps.length;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress   = Math.min((timestamp - startTime) / duration, 1);
            var eased      = HNGS.easeOutCubic(progress);
            var currentWidth = totalWidth * eased;

            lineFill.style.width = currentWidth + 'px';

            // Activate steps sequentially
            var activeStepIndex = Math.floor(eased * stepCount);
            steps.forEach(function(s, i) {
                if (i <= activeStepIndex) {
                    s.classList.add('active');
                }
            });

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                steps.forEach(function(s) { s.classList.add('active'); });
            }
        }

        requestAnimationFrame(step);
    }

    function activateAllSteps() {
        document.querySelectorAll('.process-step').forEach(function(s) { s.classList.add('active'); });
        var lineFill = document.getElementById('process-line-fill');
        if (lineFill) lineFill.style.width = '100%';
    }

    // ---- Feature blocks and card entrance animations ----
    function initStaggerObserver() {
        if (!('IntersectionObserver' in window)) return;

        var staggerObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var children = entry.target.querySelectorAll('.reveal');
                    children.forEach(function(child, i) {
                        setTimeout(function() {
                            child.classList.add('revealed');
                        }, i * 80);
                    });
                    staggerObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.stagger-children').forEach(function(el) {
            staggerObserver.observe(el);
        });
    }

    // ---- Initialize all on DOM ready ----
    document.addEventListener('DOMContentLoaded', function() {
        initRevealObserver();
        initCounterObserver();
        initProcessAnimation();
        initStaggerObserver();
    });

})();
