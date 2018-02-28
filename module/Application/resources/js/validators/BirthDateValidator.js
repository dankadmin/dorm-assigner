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
