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
