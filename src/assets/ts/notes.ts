import {IPages} from "./iPages";
import {Error} from "./error";

export class Notes implements IPages {
    public show(): void {
        $("#content").load("templates/notizen.html", () => {
            this.fetch();
            new EventHandler();
        });
    }

    public fetch(): void {
        $.post("ajax.php", {
                method: "notes_fetch"
            })
            .done(notes => {
                Error.hide();
                this.clear();
                this.sort(notes);
                $.each(notes, (index, value) => {
                    this.displayNote(value);
                });
                $(".col-md-4").sortable({
                    connectWith: ".col-md-4",
                    handle: ".portlet-header",
                    items: ".portlet",
                    placeholder: "sortable-placeholder",
                    start: function (e, ui) {
                        ui.placeholder.height(ui.helper.outerHeight());
                    },
                    stop: function (e, ui) {
                        let newNote = new Note(ui.item);
                        newNote.savePos();
                        $.each(newNote.getPrev(), function (key, value) {
                            let prevNote = new Note($(value));
                            prevNote.savePos();
                        });
                    },
                });
            })
            .fail((error) => {
                Error.show(error);
            });
    }

    private sort(notes) {
        notes.sort(function (a, b) {
            return a.row < b.row ? -1 : a.row > b.row ? 1 : 0;
        });
    };

    private clear() {
        $(".ui-sortable").empty();
    };

    private displayNote(note) {
        if (note.descr === null) {
            note.descr = "";
        }
        let html = `
                    <div class="panel panel-primary portlet" data-id=${note.noteID}>
                        <div class="panel-heading portlet-header">
                            ${note.title}
                        </div>
                        <div class="panel-body">
                            ${note.descr}
                        </div>
                    </div>
                    `;
        $("#column-" + note.col).append(html);
    }
}

class Note {
    private noteID: number;
    private title: string;
    private descr: string;
    private note: JQuery;

    constructor(note: JQuery) {
        if (!note.hasClass("portlet")) {
            note = note.closest(".portlet");
        }
        this.note = note;
        this.noteID = parseInt(note.attr("data-id"), 10);
        this.title = note.children("div.panel-heading.portlet-header").text().trim();
        this.descr = note.children("div.panel-body").text().trim();
    }

    public showModal(): void {
        $('#editNotizForm [name="id"]').val(this.noteID);
        $('#editNotizForm [name="heading"]').val(this.title);
        $('#editNotizForm [name="text"]').val(this.descr);
        $("#editNotizModal").modal("show");
    }

    public savePos(): void {
        $.post("ajax.php", {
                column: this.getColumn(),
                id: this.noteID,
                method: "notes_save_pos",
                row: this.getRow(),
            })
            .fail((error) => {
                Error.show(error);
            });
    }

    public getPrev() {
        return this.note.prevAll();
    }

    private getRow() {
        return this.note.prevAll().length + 1;
    }

    private getColumn() {
        return parseInt(this.note.closest(".ui-sortable").attr("id").replace("column-", ""), 10);
    }

}

class EventHandler {

    constructor() {
        let notes = new Notes();

        $(".notizen")
            .on("click", ".panel-body", function () {
                let note = $(this);
                let newNote = new Note(note);
                newNote.showModal();
            })
            .on("click", "button[name='addNote']", function (event) {
                event.stopImmediatePropagation();
                let text = $("#noteInput").val();
                $.post("ajax.php", {
                        method: "notes_save",
                        title: text,
                    })
                    .done(function () {
                        notes.show();
                    })
                    .fail((error) => {
                        Error.show(error);
                    });
            });

        $("#editNotizModal").on("click", "button[name='delete']", function (event) {
            event.stopImmediatePropagation();
            let id = $('#editNotizModal [name="id"]').val();
            $.post("ajax.php", {
                    id: id,
                    method: "notes_delete",
                })
                .done(function () {
                    notes.fetch();
                    $(".modal").modal("hide");
                })
                .fail((error) => {
                    Error.show(error);
                });
        });

        $("#editNotizForm").validate({
            debug: true,
            rules: {
                heading: {
                    required: true
                },
                text: {
                    required: false
                },
            },
            submitHandler: function () {
                $.post("ajax.php", $("#editNotizForm").serialize())
                    .done(() => {
                        notes.fetch();
                        $(".modal").modal("hide");
                    })
                    .fail((error) => {
                        Error.show(error);
                    });
            },
        });
    }
}

