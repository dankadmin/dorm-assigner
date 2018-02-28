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
