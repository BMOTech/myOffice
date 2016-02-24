import {IPages} from "./iPages";
import {Error} from "./error";
import moment = require("moment");

export class Overviews implements IPages {
    public fetch(): void {
        $.post("ajax.php", {
                method: "overview"
            })
            .done(overview => {
                $.each(overview, (key, overviewItem) => {
                    console.log(overviewItem);
                    $.each(overviewItem, (key2, item) => {
                        console.log(item);
                        switch (Object.getOwnPropertyNames(item)[0]) {
                            case "Events":
                                let startFormatted = moment(item.Events.start, "YYYY-MM-DD HH:mm:ss").format("DD.MM.YY");
                                let events = `<li>${item.Events.title} beginnt am ${startFormatted}</li>`;
                                $("#overview_events").append(events);
                                break;
                            case "Tasks":
                                let tasks = `<li>${item.Tasks.description}</li>`;
                                $("#overview_tasks").append(tasks);
                                break;
                            case "Contacts":
                                let contacts = `<li>${item.Contacts.vorname} ${item.Contacts.nachname}</li>`;
                                $("#overview_contacts").append(contacts);
                                break;
                            case "Notes":
                                let notes = `<li>${item.Notes.title}</li>`;
                                $("#overview_notes").append(notes);
                                break;
                            case "date":
                                let lastLoginFormatted = moment(item.date, "YYYY-MM-DD HH:mm:ss").format("DD.MM.YY HH:mm:ss");
                                let lastlogin = `Letzter erfolgreicher Login am ${lastLoginFormatted}.`;
                                $("#lastLogin").text(lastlogin);
                        }
                    });
                });
            })
            .fail((error) => {
                Error.show(error);
            });
    }

    public show(): void {
        $("#content").load("templates/ueberblick.html", () => {
            this.fetch();
        });
    }
}

