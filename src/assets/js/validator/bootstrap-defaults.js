window.$ = window.jQuery = require('jquery');
require('jquery-validation');

$.validator.setDefaults({
    errorElement: "span",
    errorClass: "help-block",
    highlight: function(element, errorClass, validClass) {
        $(element).closest('.form-group').addClass('has-error');
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).closest('.form-group').removeClass('has-error');
    }
});