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
