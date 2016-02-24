/// <reference path="definitlytyped/jquery.d.ts" />
/// <reference path="definitlytyped/jquery-ui.d.ts" />
/// <reference path="definitlytyped/bootstrap.d.ts" />
$.ajaxSetup({
    cache: false
});
$("#link_overview").click(function () {
    $("#content").load("templates/ueberblick.html", function () {
        $.post("ajax.php", {
            method: "overview"
        })
            .done(function (overview) {
            $.each(overview, function (key, value) {
                $.each(value, function (key2, value2) {
                    if (value2.Events) {
                        var startFormatted = moment(value2.Events.start, "YYYY-MM-DD HH:mm:ss").format("DD.MM.YY");
                        var events = "<li>" + value2.Events.title + " beginnt am " + startFormatted + "</li>";
                        $("#overview_events").append(events);
                    }
                    else if (value2.Tasks) {
                        var tasks = "<li>" + value2.Tasks.description + "</li>";
                        $("#overview_tasks").append(tasks);
                    }
                    else if (value2.Contacts) {
                        var contacts = "<li>" + value2.Contacts.vorname + " " + value2.Contacts.nachname + "</li>";
                        $("#overview_contacts").append(contacts);
                    }
                    else if (value2.Notes) {
                        var notes = "<li>" + value2.Notes.title + "</li>";
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
//# sourceMappingURL=Overview.js.map