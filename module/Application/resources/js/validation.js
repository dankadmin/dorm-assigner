function set_error_messages(element, is_valid, errors){
    // Clear existing messages
    element.siblings('.help-block').remove()

    if (!is_valid) {
        // Set containing label to error class
        element.parent().parent().removeClass("has-success");
        element.parent().parent().addClass("has-error");

        // Added error messages
        errors.forEach(function(error) {
            var help_block = $('<span />')
                .addClass('help-block')
                .html(error);
            element.after(help_block);
        });
    } else {
        // Set containing label to success class
        element.parent().parent().removeClass("has-error");
        element.parent().parent().addClass("has-success");
    }
}

function validate_input(element) {
    var is_valid = true;
    var validator;
    var errors = [];

    // If element isn't required and it's empty, then no problem
    if (! element.prop('required') && element.val() === '') {
        return true;
    // If element is required and empty, it's false
    } else if (element.val() === '') {
        errors = ["This field is required"];
        is_valid = false;
    // Otherwise, use validator
    } else {
        element.attr('validate')
            .split(' ')
            .forEach(function(validation_type) {
                validator = VALIDATORS.create(validation_type, element);

                if (validator instanceof Validator) {
                    if (! validator.isValid()) {
                        errors = errors.concat(validator.getMessages());
                        is_valid = false;
                    }
                }
            });
    }

    set_error_messages(element, is_valid, errors);
    return is_valid;
}

function validate_all() {
    var is_valid = true;
    $('[validate]').each(function () {
        if (!validate_input($(this))) {
            is_valid = false;
        }
    });

    return is_valid;
}

function init_validation() {
    // Validate field when focus is lost
    $('[validate]').change(function () {
        validate_input($(this));
    });

    // Validate all fields before submitting form
    $('form input[type=submit]').click(function(event) {
        if (! validate_all()) {
            window.alert('Please correct errors before submitting.');
            event.preventDefault();
        }
    });
}
