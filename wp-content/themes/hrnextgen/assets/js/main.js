/**
 * HR NextGen Solutions - Main JS
 * Initializer and global interactions
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        // ---- Page Preloader ----
        // Fade in body smoothly on first load
        document.body.style.opacity = '0';
        document.body.style.transition = 'opacity 0.4s ease';
        requestAnimationFrame(function() {
            document.body.style.opacity = '1';
        });

        // ---- External links open in new tab ----
        $('a[href^="http"]').not('a[href*="' + window.location.hostname + '"]').each(function() {
            if (!$(this).attr('target')) {
                $(this).attr('target', '_blank').attr('rel', 'noopener noreferrer');
            }
        });

        // ---- Lazy load images polyfill ----
        if ('loading' in HTMLImageElement.prototype) {
            // Native lazy load supported, nothing to do
        } else {
            // Basic intersection observer fallback for lazy images
            var lazyImages = document.querySelectorAll('img[loading="lazy"]');
            if ('IntersectionObserver' in window) {
                var lazyObserver = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            var img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.removeAttribute('data-src');
                            }
                            lazyObserver.unobserve(img);
                        }
                    });
                });
                lazyImages.forEach(function(img) { lazyObserver.observe(img); });
            }
        }

        // ---- Marquee duplicate for seamless loop (if not already doubled) ----
        // Already handled in PHP, but ensure the track is wide enough
        var $track = $('#marquee-track');
        if ($track.length) {
            // Verify items fill the container; add more if needed
            var trackWidth = $track[0].scrollWidth;
            var containerWidth = $track.parent()[0].offsetWidth;
            if (trackWidth < containerWidth * 2) {
                var $items = $track.children().clone();
                $track.append($items);
            }
        }

        // ---- Button ripple effect ----
        $(document).on('click', '.btn-primary', function(e) {
            var $btn  = $(this);
            var btnEl = this;
            var rect  = btnEl.getBoundingClientRect();
            var x     = e.clientX - rect.left;
            var y     = e.clientY - rect.top;

            var $ripple = $('<span>').css({
                position:    'absolute',
                width:       '4px',
                height:      '4px',
                borderRadius:'50%',
                background:  'rgba(255,255,255,0.4)',
                left:        x + 'px',
                top:         y + 'px',
                transform:   'scale(0)',
                pointerEvents: 'none',
                animation:   'rippleExpand 0.5s ease-out forwards',
            });

            $btn.append($ripple);
            setTimeout(function() { $ripple.remove(); }, 600);
        });

        // Add ripple keyframe if not already added
        if (!document.getElementById('ripple-style')) {
            var style = document.createElement('style');
            style.id  = 'ripple-style';
            style.textContent = '@keyframes rippleExpand { to { transform: scale(80); opacity: 0; } }';
            document.head.appendChild(style);
        }

        // ---- Highlight active nav section on load ----
        window.dispatchEvent(new Event('scroll'));

    }); // end ready

})(jQuery);
