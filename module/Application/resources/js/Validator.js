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
