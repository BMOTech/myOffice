import $ = require("jquery");

require("bootstrap");
require("jquery-ui");
require("jquery-validation");

$.validator.setDefaults({
    errorClass: "help-block",
    errorElement: "span",
    highlight: function(element, errorClass, validClass) {
        $(element).closest(".form-group").addClass("has-error");
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).closest(".form-group").removeClass("has-error");
    },
});

import {Notes} from "./notes.ts";
import {Overviews} from "./overview.ts";
import {Contacts} from "./contacts.ts";
import {Error} from "./error.ts";
import {Tasks} from "./tasks";
import {Calendar} from "./calendar";
import "./register.ts";
import "./login.ts";

//$.ajaxSetup({
//    cache: false
//});

let showPage = function (option: String): void {
    switch (option) {
        case "notes":
            let notes = new Notes();
            notes.show();
            break;
        case "overview":
            let overview = new Overviews();
            overview.show();
            break;
        case "contacts":
            let contacts = new Contacts();
            contacts.show();
            break;
        case "tasks":
            let tasks = new Tasks();
            tasks.show();
            break;
        case "calendar":
            let calendar = new Calendar();
            calendar.show();
            break;
        case "":
            let def = new Overviews();
            def.show();
            break;
        default:
            Error.showErrorPage();
            break;
    }
};

$(() => {
    let windowLoc = $(location).attr("pathname");

    if (windowLoc === "/intern.php") {
        Cookies.set("logincounter", 0);
        Cookies.set("lastSucLogin", moment(), { expires: 365 });
        let url = window.location.hash.replace("#", "");
        showPage(url);
    }
});

function locationHashChanged() {
    showPage(location.hash.replace("#", ""));
}

window.onhashchange = locationHashChanged;
