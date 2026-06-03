/**
 * HR NextGen Solutions - Utility Functions
 * Shared helpers used across all JS modules
 */

(function(window) {
    'use strict';

    var HNGS = window.HNGS = window.HNGS || {};

    /**
     * Debounce: delay execution until after wait ms have elapsed
     */
    HNGS.debounce = function(fn, wait) {
        var timer;
        return function() {
            var args = arguments;
            var ctx  = this;
            clearTimeout(timer);
            timer = setTimeout(function() { fn.apply(ctx, args); }, wait);
        };
    };

    /**
     * Throttle: execute at most once per wait ms
     */
    HNGS.throttle = function(fn, wait) {
        var last = 0;
        return function() {
            var now = Date.now();
            if (now - last >= wait) {
                last = now;
                fn.apply(this, arguments);
            }
        };
    };

    /**
     * Check if an element is in the viewport
     */
    HNGS.isInViewport = function(el, threshold) {
        threshold = threshold || 0.15;
        var rect = el.getBoundingClientRect();
        var windowHeight = window.innerHeight || document.documentElement.clientHeight;
        return rect.top <= windowHeight * (1 - threshold);
    };

    /**
     * Ease function: ease-out cubic
     */
    HNGS.easeOutCubic = function(t) {
        return 1 - Math.pow(1 - t, 3);
    };

    /**
     * Linear interpolation
     */
    HNGS.lerp = function(start, end, t) {
        return start + (end - start) * t;
    };

    /**
     * Animate a number from start to end
     */
    HNGS.animateCounter = function(el, start, end, duration, suffix) {
        var startTime = null;
        suffix = suffix || '';

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var eased    = HNGS.easeOutCubic(progress);
            var current  = Math.round(HNGS.lerp(start, end, eased));
            el.textContent = current + suffix;
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = end + suffix;
            }
        }
        requestAnimationFrame(step);
    };

    /**
     * Parse a stat value like "50+", "98%", "5+" into { number, suffix }
     */
    HNGS.parseStat = function(str) {
        str = String(str).trim();
        var match = str.match(/^(\d+\.?\d*)([^0-9.]*)$/);
        if (match) {
            return { number: parseFloat(match[1]), suffix: match[2] || '' };
        }
        return { number: 0, suffix: str };
    };

    /**
     * Smooth scroll to an element or anchor
     */
    HNGS.smoothScrollTo = function(target, offset) {
        offset = offset || 0;
        var el;
        if (typeof target === 'string') {
            el = document.querySelector(target);
        } else {
            el = target;
        }
        if (!el) return;
        var top = el.getBoundingClientRect().top + window.pageYOffset - offset;
        window.scrollTo({ top: top, behavior: 'smooth' });
    };

    /**
     * Map a value from one range to another
     */
    HNGS.mapRange = function(value, inMin, inMax, outMin, outMax) {
        return ((value - inMin) / (inMax - inMin)) * (outMax - outMin) + outMin;
    };

    /**
     * Clamp a value between min and max
     */
    HNGS.clamp = function(value, min, max) {
        return Math.max(min, Math.min(max, value));
    };

})(window);
