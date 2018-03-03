class Validator {
    constructor(element) {
        this.element = element;
        this.value = element.val();
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

    create(string, element) {
        if (typeof this.validators[string] === 'function' ) {
            return new this.validators[string](element);
        } else {
            return null;
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

class BirthDateValidator extends Validator {
    isValid() {
        this.reset();


        if (! /^([0-9]{4})-[0-2][0-9]-[0-3][0-9]$/.test(this.value)) {
            this.addError('Date must be in the format YYYY-mm-dd');
            return this.is_valid;
        }

        var date = new Date(this.value);

        if (date === "Invalid Date" || isNaN(date)) {
            this.addError('Date does not appear to be a valid date');
            return this.is_valid;
        }

        var today = new Date();
        if ((new Date(today.getFullYear() - 100, today.getMonth(), today.getDate())) > date) {
            this.addError('Date cannot be older than 100 years');
        }

        if ((new Date(today.getFullYear() - 10, today.getMonth(), today.getDate())) < date) {
            this.addError('Date cannot be less than 10 years ago');
        }

        return this.is_valid;
    }
}

VALIDATORS.register('BirthDate', BirthDateValidator);

class PhoneNumberValidator extends Validator {
    isValid() {
        this.reset();

        this.value = this.value.replace(/[^0-9]/g, '');


        if (! /^[0-9]{10}$/.test(this.value)) {
            this.addError('Phone number must be exactly 10 digits, and no other characters');
        }

        this.element.val(this.value);

        return this.is_valid;
    }
}

VALIDATORS.register('PhoneNumber', PhoneNumberValidator);

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

function init_datepicker() {
    var date_input=$('input[name="birth_date"]');
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    var options={
        format: 'yyyy-mm-dd',
        container: container,
        autoclose: true,
        title: 'Date of Birth',
        startDate: '-100y',
        endDate: '-10y',
        startView: 2,
    };
    date_input.datepicker(options);
}

$(function () {
    init_validation();
    init_datepicker();
});
