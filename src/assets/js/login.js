'use strict';

window.$ = window.jQuery = require('jquery');
require('jquery-validation');
require('./validator/bootstrap-defaults');

$(document).ready(function() {
    $("#loginForm").validate();
})

$( "button" ).click(function() {
    $.post( "ajax.php", { method: "authTest"}, function( data ) {
        console.log(data);
    });
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
            email: "Bitte geben Sie eine gültige Email-Adresse ein!",
        }
    },
    submitHandler: function(form) {
        form.submit();
    }
});