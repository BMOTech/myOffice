import {IPages} from "./iPages";
import {Error} from "./error";
import moment = require("moment");

export class Overviews implements IPages {
    /**
     * Lädt die Daten des Überblicks vom Server.
     */
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
                                this.appendEvents(item);
                                break;
                            case "Tasks":
                                this.appendTasks(item);
                                break;
                            case "Contacts":
                                this.appendContacts(item);
                                break;
                            case "Notes":
                                this.appendNotes(item);
                                break;
                            case "date":
                                this.appendDate(item);
                                break;
                        }
                    });
                });
            })
            .fail((error) => {
                Error.show(error);
            });
    }

    /**
     * Fügt den Überblick in den sichtbaren Bereich ein.
     */
    public show(): void {
        $("#content").load("templates/ueberblick.html", () => {
            this.fetch();
        });
    }

    /**
     * Fügt dem Überblick das letzte Login-Datum hinzu.
     *
     * @type {Object}
     *
     * @param item
     */
    private appendDate(item) {
        let lastLoginFormatted = moment(item.date, "YYYY-MM-DD HH:mm:ss").format("DD.MM.YY HH:mm:ss");
        let lastlogin = `Letzter erfolgreicher Login am ${lastLoginFormatted}.`;
        $("#lastLogin").text(lastlogin);
    };

    /**
     * Fügt dem Überblick die zuletzt hinzugefügten Notizen hinzu.
     *
     * @type {Object}
     *
     * @param {{Notes: Object}} item
     */
    private appendNotes(item) {
        let notes = `<li>${item.Notes.title}</li>`;
        $("#overview_notes").append(notes);
    };

    /**
     * Fügt dem Überblick die zuletzt hinzugefügten Kontakte hinzu.
     *
     * @type {Object}
     *
     * @param {{Contacts: Object}} item
     */
    private appendContacts(item) {
        let contacts = `<li>${item.Contacts.vorname} ${item.Contacts.nachname}</li>`;
        $("#overview_contacts").append(contacts);
    };

    /**
     * Fügt dem Überblick die zuletzt hinzugefügten Aufgaben hinzu.
     *
     * @type {Object}
     *
     * @param {{Tasks: Object}} item
     */
    private appendTasks(item) {
        let tasks = `<li>${item.Tasks.description}</li>`;
        $("#overview_tasks").append(tasks);
    };

    /**
     * Fügt dem Überblick die nächsten Kalendereinträge hinzu.
     *
     * @type {Object}
     *
     * @param {{Events: Object}} item
     */
    private appendEvents(item) {
        let startFormatted = moment(item.Events.start, "YYYY-MM-DD HH:mm:ss").format("DD.MM.YY");
        let events = `<li>${item.Events.title} beginnt am ${startFormatted}</li>`;
        $("#overview_events").append(events);
    };
}

