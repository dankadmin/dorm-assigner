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

    // If element is required and empty, no need to look further, otherwise, use validators
    if (element.prop('required') && element.val() === '') {
        errors = ["This field is required"];
        is_valid = false;
    } else {
        element.attr('validate')
            .split(' ')
            .forEach(function(validation_type) {
                console.log("VT: '" + validation_type + "'");
                validator = VALIDATORS.create(validation_type, element.val());

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
            console.log($(this).attr('name') + ' is false');
            is_valid = false;
        }
    });

    return is_valid;
}

function init_validation() {
    // Validate field when focus is lost
    $('[validate]').blur(function () {
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
