class Validator {
    constructor(value) {
        this.value = value;
        this.reset();
    }

    reset() {
        this.is_valid = true;
        this.messages = [];
    }

    isValid() {
        this.reset();
        return this.is_valid;
    }

    getMessages() {
        return this.messages;
    }

    addError(message) {
        this.is_valid = false;
        this.messages.push(message);
    }
}

class SimpleStringValidator extends Validator {
    isValid() {
        this.reset();

        if (this.value.length < 3) {
            this.addError('Value is too short');
        }

        if (this.value.length > 200) {
            this.addError('Must contain fewer than 200 characters');
        }

        if (/[^a-zA-Z0-9._;, -]/.test(this.value)) {
            this.addError('Contains invalid characters');
        }

        return this.is_valid;
    }
}

function validate_input(element) {
    var is_valid = true;
    var validator;
    var errors = [];

    element.attr('validate')
        .split(' ')
        .forEach(function(validation_type) {
            switch (validation_type + 'Validator') {
                case 'SimpleStringValidator':
                    validator = new SimpleStringValidator(element.val());
                    break;
                default:
                    validator = '';
            }

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

$(function () {
    $('input[validate]').blur(function () {
        validate_input($(this));
    });

    $('form input[type=submit]').click(function(event) {
        if (! validate_all()) {
            window.alert('Please correct errors before submitting.');
            event.preventDefault();
        }
    });
});
