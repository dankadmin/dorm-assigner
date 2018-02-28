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
