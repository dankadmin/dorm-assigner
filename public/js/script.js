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

class AlNumSpacesValidator extends Validator {
    isValid() {
        this.reset();

        if (this.value.length < 3) {
            this.addError('Value is too short');
        }

        if (this.value.length > 200) {
            this.addError('Must contain fewer than 200 characters');
        }

        if (/[^a-zA-Z0-9 ]/.test(this.value)) {
            this.addError('Contains invalid characters');
        }

        return this.is_valid;
    }
}

VALIDATORS.register('AlNumSpaces', AlNumSpacesValidator);

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

STATE_LIST = [
    'Alabama',
    'Alaska',
    'Arizona',
    'Arkansas',
    'California',
    'Colorado',
    'Connecticut',
    'Delaware',
    'Florida',
    'Georgia',
    'Hawaii',
    'Idaho',
    'Illinois',
    'Indiana',
    'Iowa',
    'Kansas',
    'Kentucky',
    'Louisiana',
    'Maine',
    'Maryland',
    'Massachusetts',
    'Michigan',
    'Minnesota',
    'Mississippi',
    'Missouri',
    'Montana',
    'Nebraska',
    'Nevada',
    'New Hampshire',
    'New Jersey',
    'New Mexico',
    'New York',
    'North Carolina',
    'North Dakota',
    'Ohio',
    'Oklahoma',
    'Oregon',
    'Pennsylvania',
    'Rhode Island',
    'South Carolina',
    'South Dakota',
    'Tennessee',
    'Texas',
    'Utah',
    'Vermont',
    'Virginia',
    'Washington',
    'West Virginia',
    'Wisconsin',
    'Wyoming',
];

class StateNameValidator extends Validator {
    isValid() {
        this.reset();

        if (STATE_LIST.indexOf(this.value) !== -1) {
            return true;
        }

        this.addError('"' + this.value + '" is not a valid state');
        return false;
    }
}

VALIDATORS.register('StateName', StateNameValidator);

class StudentIdValidator extends Validator {
    isValid() {
        this.reset();

        if (! /^[A-Z]{2}[0-9]{6}$/.test(this.value)) {
            this.addError('Student ID must be in format LLDDDDDD, where L is a capital letter, and D is a digit.');
        }

        return this.is_valid;
    }
}

VALIDATORS.register('StudentId', StudentIdValidator);

class ZipCodeValidator extends Validator {
    isValid() {
        this.reset();

        if (! /^[0-9]+$/.test(this.value)) {
            this.addError('Must contain only digits');
        }

        if (this.value.length < 5 || this.value.length > 5) {
            this.addError('Zip code must be exactly 5 characters');
        }

        return this.is_valid;
    }
}

VALIDATORS.register('ZipCode', ZipCodeValidator);

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

$(function () {
    init_validation();
});
