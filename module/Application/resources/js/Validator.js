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
