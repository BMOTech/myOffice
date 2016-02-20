/// <reference path="definitlytyped/jquery.d.ts" />
/// <reference path="definitlytyped/jquery-ui.d.ts" />

require("jquery-ui");

$.ajaxSetup({
    cache: false
});

class Note {
    private noteID: number;
    private title: string;
    private desc: string;
    private col: number;
    private row: number;
    private note: JQuery;

    constructor(note: JQuery) {
        if (!note.hasClass("portlet")) {
            note = note.closest(".portlet");
        }
        this.note = note;
        this.noteID = parseInt(note.attr("data-id"), 10);
        this.title = note.children("div.panel-heading.portlet-header").text().trim();
        this.desc = note.children("div.panel-body").text().trim();
    }

    public showModal() {
        $('#editNotizForm [name="id"]').val(this.noteID);
        $('#editNotizForm [name="heading"]').val(this.title);
        $('#editNotizForm [name="text"]').val(this.desc);
        $("#editNotizModal").modal("show");
    }
}

$("#link_notizen").click(function () {

    $("#content").load("templates/notizen.html", function () {

        $.post("ajax.php", {
                method: "notes_fetch"
            })
            .done(notes => {
                notes.sort(function (a, b) {
                    if (a.row < b.row)
                        return -1;
                    else if (a.row > b.row)
                        return 1;
                    else
                        return 0;
                });
                $.each(notes, function (index, value) {
                    let html = `
                    <div class="panel panel-warning portlet" data-id="1">
                        <div class="panel-heading portlet-header">
                            ${value.title}
                        </div>
                        <div class="panel-body">
                            ${value.desc}
                        </div>
                    </div>
                    `;
                    $("#column-" + value.col).append(html);
                });

                $(".col-md-4").sortable({
                    connectWith: ".col-md-4",
                    items: ".portlet",
                    placeholder: "sortable-placeholder",
                    start: function (e, ui) {
                        ui.placeholder.height(ui.helper.outerHeight());
                    },
                    stop: function (e, ui) {
                        console.log(ui.item);
                        let newNote = new Note(ui.item);
                        console.log(newNote);
                    }
                });
            })
            .fail(function () {
                alert("Fehler beim laden der Notizen!");
            });

        $('body').on('click', '.panel-body', function () {
            let note = $(this);
            console.log("test");
            let newNote = new Note(note);
            newNote.showModal();
        });
    });
})
