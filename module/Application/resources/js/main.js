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
