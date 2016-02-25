import {IPages} from "./iPages";
import {Error} from "./error";

require("fullcalendar");
require("fullcalendar-de");
import moment = require("moment");

export class Calendar implements IPages {
    /**
     * Fügt die Notizen in den sichtbaren Bereich ein.
     */
    public show(): void {
        $("#content").load("templates/kalender.html", () => {
            this.fetch();
            new EventHandler();
        });
    }

    /**
     * Lädt die Notizen vom Server.
     */
    public fetch(): void {
        $("#calendar").fullCalendar({
            dayClick: date => {
                $("#createEventModal").find(".selectedDate").text(moment(date).format("Do MMMM YYYY"));
                $("#createEventModal").find('[name="date"]').val(moment(date).toISOString());
                $("#createEventModal").modal("show");
            },
            editable: true,
            eventClick: event => {
                $("#editEventModal").find(".selectedDate").text(event.start.format("Do MMMM YYYY"));
                $("#editEventModal").find('[name="id"]').val(event.id);
                $("#editEventModal").find('[name="title"]').val(event.title);
                $("#editEventModal").find('[name="text"]').val(event.title);
                $("#editEventModal").modal("show");
            },
            events: {
                url: "ajax.php",
                type: "POST",
                data: {
                    method: "cal_fetch"
                },
                success: () => {
                    Error.hide();
                },
                error: (error) => {
                    Error.show(error);
                },
            },
            selectable: true,
        });
    }
}

class EventHandler {
    constructor() {
        $("#createEventForm").validate({
            debug: true,
            rules: {
                title: {
                    required: true
                },
            },
            submitHandler: () => {
                $.post("ajax.php", $("#createEventForm").serialize())
                    .done(function () {
                        $("#calendar").fullCalendar("refetchEvents");
                        $("#createEventModal").modal("hide");
                        $("#createEventForm").find("input[type=text], textarea").val("");
                    })
                    .fail((error) => {
                        Error.show(error);
                    });
            },
        });

        $("#editEventForm").validate({
            debug: true,
            rules: {
                title: {
                    required: true
                },
            },
            submitHandler: function () {
                $.post("ajax.php", $("#editEventForm").serialize())
                    .done(function () {
                        $("#calendar").fullCalendar("refetchEvents");
                        $("#editEventModal").modal("hide");
                    })
                    .fail((error) => {
                        Error.show(error);
                    });
            },
        });

        $("#editEventModal").find('[name="delete"]').click(function () {
            let id = $('#editEventModal [name="id"]').val();

            $.post("ajax.php", {
                    method: "cal_delete",
                    id: id,
                })
                .done(function () {
                    $("#calendar").fullCalendar("refetchEvents");
                    $("#editEventModal").modal("hide");
                })
                .fail((error) => {
                    Error.show(error);
                });
        });
    }
}

