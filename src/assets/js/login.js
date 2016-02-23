'use strict';

require('jquery-validation');
require('./validator/bootstrap-defaults');

$(document).ready(function() {
    $("#loginForm").validate();
});

$('#loginForm').validate({
    debug: true,
    rules: {
        password: {
            required: true
        },
        email: {
            required: true,
            email: true
        }
    },
    messages: {
        email: {
            required: "Bitte geben Sie eine Email-Adresse ein!",
            email: "Bitte geben Sie eine gültige Email-Adresse ein!"
        }
    },
    submitHandler: function(form) {
        form.submit();
    }
});