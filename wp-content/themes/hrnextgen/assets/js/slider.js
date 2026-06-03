/**
 * HR NextGen Solutions - Testimonials Slider
 * Vanilla JS auto-play slider with touch support and keyboard navigation
 */

(function() {
    'use strict';

    var track      = document.getElementById('testimonials-track');
    var prevBtn    = document.getElementById('slider-prev');
    var nextBtn    = document.getElementById('slider-next');
    var dotsContainer = document.getElementById('slider-dots');

    if (!track) return;

    var slides     = track.querySelectorAll('.testimonial-slide');
    var dots       = dotsContainer ? dotsContainer.querySelectorAll('.slider-dot') : [];
    var totalSlides = slides.length;
    var current    = 0;
    var autoPlayTimer;
    var AUTOPLAY_DELAY = 5000;
    var TRANSITION_MS  = 600;
    var isTransitioning = false;

    // Touch state
    var touchStartX = 0;
    var touchStartY = 0;
    var touchEndX   = 0;

    function goTo(index) {
        if (isTransitioning) return;
        if (totalSlides <= 1) return;

        isTransitioning = true;

        // Wrap around
        current = (index + totalSlides) % totalSlides;

        // Move track
        track.style.transform = 'translateX(-' + (current * 100) + '%)';

        // Update dots
        dots.forEach(function(dot, i) {
            dot.classList.toggle('active', i === current);
            dot.setAttribute('aria-selected', i === current ? 'true' : 'false');
        });

        // Update aria-hidden on slides for accessibility
        slides.forEach(function(slide, i) {
            slide.setAttribute('aria-hidden', i !== current ? 'true' : 'false');
        });

        setTimeout(function() {
            isTransitioning = false;
        }, TRANSITION_MS);
    }

    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }

    function startAutoPlay() {
        stopAutoPlay();
        autoPlayTimer = setInterval(next, AUTOPLAY_DELAY);
    }

    function stopAutoPlay() {
        clearInterval(autoPlayTimer);
    }

    // Button events
    if (nextBtn) nextBtn.addEventListener('click', function() { next(); startAutoPlay(); });
    if (prevBtn) prevBtn.addEventListener('click', function() { prev(); startAutoPlay(); });

    // Dot events
    dots.forEach(function(dot, i) {
        dot.addEventListener('click', function() {
            goTo(i);
            startAutoPlay();
        });
    });

    // Pause on hover/focus
    var sliderWrapper = document.querySelector('.testimonials-slider-wrapper');
    if (sliderWrapper) {
        sliderWrapper.addEventListener('mouseenter', stopAutoPlay);
        sliderWrapper.addEventListener('mouseleave', startAutoPlay);
        sliderWrapper.addEventListener('focusin', stopAutoPlay);
        sliderWrapper.addEventListener('focusout', startAutoPlay);
    }

    // Touch / swipe support
    track.addEventListener('touchstart', function(e) {
        touchStartX = e.touches[0].clientX;
        touchStartY = e.touches[0].clientY;
        stopAutoPlay();
    }, { passive: true });

    track.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].clientX;
        var diffX  = touchStartX - touchEndX;
        var diffY  = Math.abs(e.changedTouches[0].clientY - touchStartY);

        // Only swipe if horizontal movement dominates
        if (Math.abs(diffX) > 50 && Math.abs(diffX) > diffY) {
            if (diffX > 0) {
                next();
            } else {
                prev();
            }
        }
        startAutoPlay();
    }, { passive: true });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        var section = document.getElementById('testimonials');
        if (!section) return;
        var rect = section.getBoundingClientRect();
        if (rect.top > window.innerHeight || rect.bottom < 0) return;

        if (e.key === 'ArrowLeft') { prev(); startAutoPlay(); }
        if (e.key === 'ArrowRight') { next(); startAutoPlay(); }
    });

    // Initial state
    goTo(0);
    startAutoPlay();

    // Set initial aria-hidden
    slides.forEach(function(slide, i) {
        if (i !== 0) slide.setAttribute('aria-hidden', 'true');
    });

})();
