import moment = require("moment");

$(document).ready(function () {
    let lastSucLogin = Cookies.get("lastSucLogin");
    if (lastSucLogin) {
        let lastLogin = moment(Cookies.get("lastSucLogin")).format("DD.MM.YYYY HH:mm:ss");
        $("#loginForm").prepend(`
        <div class="alert alert-info" role="alert">Letzter erfolgreicher Login am ${lastLogin}</div>
        `);
    }
    $("#loginForm").validate();
});


$("#loginForm").validate({
    debug: true,
    rules: {
        email: {
            email: true,
            required: true,
        },
        messages: {
            email: {
                email: "Bitte geben Sie eine gültige Email-Adresse ein!",
                required: "Bitte geben Sie eine Email-Adresse ein!",
            },
        },
        password: {
            required: true
        },
    },
    submitHandler: function (form) {
        let loginCount = 1;
        let loginCounter = Cookies.get("logincounter");
        if (loginCounter) {
            loginCount = parseInt(Cookies.get("logincounter"), 10) + 1;
        }
        Cookies.set("logincounter", loginCount);
        form.submit();
    },
});
