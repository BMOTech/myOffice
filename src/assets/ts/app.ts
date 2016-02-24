import $ = require("jquery");

require("bootstrap");

require("jquery-ui");
require("jquery-validation");

import {Notes} from "./notes.ts";
import {Overviews} from "./overview.ts";
import {Contacts} from "./contacts.ts";
import {Error} from "./error.ts";
import {Tasks} from "./tasks";
import "./register.ts";

$.ajaxSetup({
    cache: false
});

let showPage = function (option: String): void {
    let notes = new Notes();
    let overview = new Overviews();
    let contacts = new Contacts();
    let tasks = new Tasks();
    
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
        case "":
            overview.show();
            break;
        default:
            Error.showErrorPage();
            break;
    }
}

$(() => {
    let url = window.location.hash.replace("#", "");
    showPage(url);
});

function locationHashChanged() {
    showPage(location.hash.replace("#", ""));
}

window.onhashchange = locationHashChanged;
