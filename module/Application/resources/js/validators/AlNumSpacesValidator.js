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
