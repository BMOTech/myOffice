import $ = require("jquery");

require("bootstrap");
require("jquery-ui");
require("jquery-validation");
import moment = require("moment");

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
import "./register.ts";
import "./login.ts";
import {Calendar} from "./calendar";

$.ajaxSetup({
    cache: false
});

let showPage = function (option: String): void {
    let notes = new Notes();
    let overview = new Overviews();
    let contacts = new Contacts();
    let tasks = new Tasks();
    let calendar = new Calendar();
    switch (option) {
        case "notes":
            notes.show();
            break;
        case "overview":
            overview.show();
            break;
        case "contacts":
            contacts.show();
            break;
        case "tasks":
            tasks.show();
            break;
        case "calendar":
            calendar.show();
            break;
        case "":
            overview.show();
            break;
        default:
            Error.showErrorPage();
            break;
    }
}

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
