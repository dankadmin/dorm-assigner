function validate_input(element) {
    var is_valid = true;
    var validator;
    var errors = [];

    element.attr('validate')
        .split(' ')
        .forEach(function(validation_type) {
            validator = VALIDATORS.create(validation_type, element.val());

            if (validator instanceof Validator) {
                if (! validator.isValid()) {
                    errors = errors.concat(validator.getMessages());
                    is_valid = false;
                }
            }
        });

    element.siblings('.help-block').remove()
    if (!is_valid) {
        element.parent().parent().removeClass("has-success");
        element.parent().parent().addClass("has-error");
        errors.forEach(function(error) {
            var help_block = $('<span />')
                .addClass('help-block')
                .html(error);
            element.after(help_block);
        });
        return false;
    } else {
        element.parent().parent().removeClass("has-error");
        element.parent().parent().addClass("has-success");
        return true;
    }
}

function validate_all() {
    var is_valid = true;
    $('input[validate]').each(function () {
        if (!validate_input($(this))) {
            is_valid = false;
        }
    });

    return is_valid;
}
