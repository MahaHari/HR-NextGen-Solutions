/**
 * HR NextGen Solutions - Contact Form
 * Client-side validation and AJAX submission
 */

(function($) {
    'use strict';

    var $form         = $('#contact-form');
    var $submitBtn    = $('#form-submit');
    var $submitText   = $('#form-submit-text');
    var $submitLoading= $('#form-submit-loading');
    var $globalError  = $('#form-global-error');
    var $formSuccess  = $('#form-success');

    if (!$form.length) return;

    // ---- Validation Rules ----
    var rules = {
        full_name: { required: true, minLength: 2,  label: 'Full name' },
        email:     { required: true, email: true,    label: 'Email address' },
        message:   { required: true, minLength: 10,  label: 'Message' },
    };

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function showError(fieldName, message) {
        var $field = $form.find('[name="' + fieldName + '"]');
        var $error = $('#error-' + fieldName);
        $field.addClass('error').attr('aria-invalid', 'true');
        if ($error.length) {
            $error.text(message).show();
        }
    }

    function clearError(fieldName) {
        var $field = $form.find('[name="' + fieldName + '"]');
        var $error = $('#error-' + fieldName);
        $field.removeClass('error').attr('aria-invalid', 'false');
        if ($error.length) {
            $error.text('').hide();
        }
    }

    function clearAllErrors() {
        Object.keys(rules).forEach(clearError);
        $globalError.text('').hide();
    }

    function validate() {
        var valid = true;
        clearAllErrors();

        Object.keys(rules).forEach(function(fieldName) {
            var rule   = rules[fieldName];
            var $field = $form.find('[name="' + fieldName + '"]');
            var value  = $field.val().trim();

            if (rule.required && !value) {
                showError(fieldName, rule.label + ' is required.');
                valid = false;
                return;
            }
            if (value && rule.minLength && value.length < rule.minLength) {
                showError(fieldName, rule.label + ' must be at least ' + rule.minLength + ' characters.');
                valid = false;
                return;
            }
            if (value && rule.email && !validateEmail(value)) {
                showError(fieldName, 'Please enter a valid email address.');
                valid = false;
                return;
            }
        });

        return valid;
    }

    // Real-time validation on blur
    $form.find('input, textarea').on('blur', function() {
        var name = $(this).attr('name');
        if (rules[name]) {
            var value = $(this).val().trim();
            var rule  = rules[name];
            clearError(name);

            if (rule.required && !value) {
                showError(name, rule.label + ' is required.');
            } else if (value && rule.minLength && value.length < rule.minLength) {
                showError(name, rule.label + ' must be at least ' + rule.minLength + ' characters.');
            } else if (value && rule.email && !validateEmail(value)) {
                showError(name, 'Please enter a valid email address.');
            }
        }
    });

    // Clear errors on input
    $form.find('input, textarea').on('input', function() {
        var name = $(this).attr('name');
        if (rules[name]) clearError(name);
        $globalError.text('').hide();
    });

    // ---- Set loading state ----
    function setLoading(loading) {
        $submitBtn.prop('disabled', loading);
        if (loading) {
            $submitText.hide();
            $submitLoading.show();
            $submitBtn.css('opacity', '0.7');
        } else {
            $submitText.show();
            $submitLoading.hide();
            $submitBtn.css('opacity', '');
        }
    }

    // ---- Show success state ----
    function showSuccess() {
        $form.css({ opacity: 0, transition: 'opacity 0.4s ease' });
        setTimeout(function() {
            $form.hide();
            $formSuccess.addClass('show').css({ opacity: 0 });
            setTimeout(function() {
                $formSuccess.css({ opacity: 1, transition: 'opacity 0.4s ease' });
            }, 50);
        }, 400);
    }

    // ---- Form Submit ----
    $form.on('submit', function(e) {
        e.preventDefault();

        if (!validate()) {
            // Focus first error field
            $form.find('.error').first().focus();
            return;
        }

        setLoading(true);
        $globalError.text('').hide();

        var formData = $form.serializeArray();
        formData.push({ name: 'nonce', value: (window.hngsData && window.hngsData.nonce) || '' });
        formData.push({ name: 'action', value: 'hngs_submit_contact' });

        $.ajax({
            url:      (window.hngsData && window.hngsData.ajaxUrl) || '/wp-admin/admin-ajax.php',
            type:     'POST',
            data:     formData,
            dataType: 'json',
            timeout:  15000,
            success:  function(response) {
                setLoading(false);
                if (response && response.success) {
                    showSuccess();
                } else {
                    var msg = (response && response.data && response.data.message) || 'Something went wrong. Please try again.';
                    $globalError.text(msg).show();
                }
            },
            error: function(xhr, status) {
                setLoading(false);
                var msg = 'Connection error. Please check your internet connection and try again.';
                if (status === 'timeout') {
                    msg = 'The request timed out. Please try again.';
                }
                $globalError.text(msg).show();
            },
        });
    });

})(jQuery);
