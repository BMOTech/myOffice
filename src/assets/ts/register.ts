$(document).ready(function() {
    $("#registerForm").validate();
});

$('#registerForm').validate({
    rules: {
        vorname: {
            required: true
        },
        nachname: {
            required: true
        },
        geschlecht: {
            required: true
        },
        password: {
            required: true
        },
        password2: {
            equalTo: "#password"
        },
        email: {
            required: true,
            email: true,
            remote: {
                url: "register.php",
                type: "post",
                data: {
                    method: 'emailAvailable',
                    email: function() {
                        return $('#registerForm :input[name="email"]').val();
                    }
                }
            }
        },
        land: {
            required: true
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