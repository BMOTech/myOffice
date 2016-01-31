'use strict';

window.$ = window.jQuery = require('jquery');
require('jquery-validation');
require('./validator/bootstrap-defaults');

$(document).ready(function() {
    $("#registerForm").validate();
})

$('#registerForm').validate({
    debug: true,
    rules: {
        password: {
            required: true
        },
        email: {
            required: true,
            email: true,
            remote: {
                url: "ajax.php",
                type: "post",
                data: {
                    method: 'emailAvailable',
                    email: function() {
                        return $('#registerForm :input[name="email"]').val();
                    }
                }
            }
        }
    },
    messages: {
        email: {
            required: "Bitte geben Sie eine Email-Adresse ein!",
            email: "Bitte geben Sie eine gültige Email-Adresse ein!",
            remote: "Die Email-Adresse wird bereits benutzt."
        }
    },
    submitHandler: function(form) {
        form.submit();
    }
});