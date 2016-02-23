/// <reference path="definitlytyped/jquery.d.ts" />
/// <reference path="definitlytyped/jquery-ui.d.ts" />
/// <reference path="definitlytyped/bootstrap.d.ts" />

require("jquery-ui");

$.ajaxSetup({
    cache: false
});

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
            .fail(function () {
                alert("Fehler beim speichern der Position!");
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

$("#link_notizen").click(function () {

    $("#content").load("templates/notizen.html", function () {

        let displayNote = function (value) {
            if (value.descr === null) {
                value.descr = "";
            }
            let html = `
                    <div class="panel panel-warning portlet" data-id=${value.noteID}>
                        <div class="panel-heading portlet-header">
                            ${value.title}
                        </div>
                        <div class="panel-body">
                            ${value.descr}
                        </div>
                    </div>
                    `;
            $("#column-" + value.col).append(html);
        };

        let fetchNotes = function () {
            $.post("ajax.php", {
                    method: "notes_fetch"
                })
                .done(notes => {
                    $(".ui-sortable").empty();
                    notes.sort(function (a, b) {
                        return a.row < b.row ? -1 : a.row > b.row ? 1 : 0;
                    });
                    $.each(notes, function (index, value) {
                        displayNote(value);
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
                .fail(function () {
                    alert("Fehler beim laden der Notizen!");
                });
        };

        fetchNotes();

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
                        fetchNotes();
                    })
                    .fail(function () {
                        alert("Fehler beim laden der Notizen!");
                    });
            });

        $("#editNotizModal").on("click", "button[name='delete']", function (event) {
            let id = $('#editNotizModal [name="id"]').val();
            $.post("ajax.php", {
                    id: id,
                    method: "notes_delete",
                })
                .done(function () {
                    fetchNotes();
                    $("#editNotizModal").modal("hide");
                })
                .fail(function () {
                    alert("Fehler beim löschen der Notiz!");
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
                    .done(function () {
                        fetchNotes();
                        $("#editNotizModal").modal("hide");
                    })
                    .fail(function () {
                        alert("Fehler beim speichern der Notiz!");
                    });
            },
        });
    });
});
