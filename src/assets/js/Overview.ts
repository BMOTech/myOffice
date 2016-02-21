/// <reference path="definitlytyped/jquery.d.ts" />
/// <reference path="definitlytyped/jquery-ui.d.ts" />
/// <reference path="definitlytyped/bootstrap.d.ts" />

$.ajaxSetup({
    cache: false
});

$("#link_overview").click(function () {

    $("#content").load("templates/ueberblick.html", function () {
        $.post("ajax.php", {
                method: "overview",
            })
            .done(overview => {
                $.each(overview, function (key, value) {
                    $.each(value, function (key2, value2) {
                        if (value2.Events) {
                            let startFormatted = moment(value2.Events.start, "YYYY-MM-DD HH:mm:ss").format("DD.MM.YY");
                            let events = `<li>${value2.Events.title} beginnt am ${startFormatted}</li>`;
                            $("#overview_events").append(events);
                        } else if (value2.Tasks) {
                            let tasks = `<li>${value2.Tasks.description}</li>`;
                            $("#overview_tasks").append(tasks);
                        } else if (value2.Contacts) {
                            let contacts = `<li>${value2.Contacts.vorname} ${value2.Contacts.nachname}</li>`;
                            $("#overview_contacts").append(contacts);
                        } else if (value2.Notes) {
                            let notes = `<li>${value2.Notes.title}</li>`;
                            $("#overview_notes").append(notes);
                        }
                    });
                });
            })
            .fail(function () {
                alert("Fehler beim abfragen des Überblicks!");
            });
    });
});
