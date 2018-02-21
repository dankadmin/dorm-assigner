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

class ValidatorFactory
{
    constructor() {
        this.validators = [];
    }

    register(string, validator) {
        this.validators[string] = validator;
    }

    create(string, value) {
        if (typeof this.validators[string] === 'function' ) {
            return new this.validators[string](value);
        } else {
            return new Validator;
        }
    }
}

var VALIDATORS = new ValidatorFactory();

class EmailAddressValidator extends Validator {
    isValid() {
        this.reset();

        if (!/^[a-zA-Z0-9]{2,}@[a-z][a-zA-Z0-9]{3,}\.[a-z]{2,15}$/.test(this.value)) {
            this.addError('Not a valid email address');
        }

        return this.is_valid;
    }
}

VALIDATORS.register('EmailAddress', EmailAddressValidator);

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

VALIDATORS.register('SimpleString', SimpleStringValidator);

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

$(function () {
    // Validate field when focus is lost
    $('input[validate]').blur(function () {
        validate_input($(this));
    });

    // Validate all fields before submitting form
    $('form input[type=submit]').click(function(event) {
        if (! validate_all()) {
            window.alert('Please correct errors before submitting.');
            event.preventDefault();
        }
    });
});
