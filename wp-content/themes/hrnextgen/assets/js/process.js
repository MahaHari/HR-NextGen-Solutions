/**
 * HR NextGen Solutions - Process Section
 * Mobile accordion toggle
 */

(function($) {
    'use strict';

    // ---- Mobile Accordion ----
    $('.process-accordion-header').on('click keydown', function(e) {
        if (e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ') return;
        if (e.type === 'keydown') e.preventDefault();

        var $header = $(this);
        var $item   = $header.closest('.process-accordion-item');
        var $body   = $item.find('.process-accordion-body');
        var isOpen  = $item.hasClass('open');

        // Close all others
        $('.process-accordion-item').each(function() {
            if ($(this)[0] !== $item[0]) {
                $(this).removeClass('open');
                $(this).find('.process-accordion-body').slideUp(300);
                $(this).find('.process-accordion-header').attr('aria-expanded', 'false');
            }
        });

        // Toggle current
        if (isOpen) {
            $item.removeClass('open');
            $body.slideUp(300);
            $header.attr('aria-expanded', 'false');
        } else {
            $item.addClass('open');
            $body.slideDown(300);
            $header.attr('aria-expanded', 'true');
        }
    });

    // Open the first step by default on mobile
    function initFirstStep() {
        if ($(window).width() <= 768) {
            var $first = $('.process-accordion-item').first();
            $first.addClass('open');
            $first.find('.process-accordion-body').show();
            $first.find('.process-accordion-header').attr('aria-expanded', 'true');
        }
    }

    $(document).ready(initFirstStep);

})(jQuery);
