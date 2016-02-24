import {IPages} from "./iPages";
import {Error} from "./error";

export class Contacts implements IPages {
    public show(): void {
        $("#content").load("templates/kontakte.html", () => {
            this.fetch();
        });
    }

    public fetch(): void {
        $.post("ajax.php", {
                method: "contact_fetch"
            })
            .done(contacts => {
                Error.hide();
                this.clear();
                this.showContacts(contacts);
                new EventHandler();
            })
            .fail((error) => {
                Error.show(error);
            });
    }

    private showContacts(contacts): void {
        $.each(contacts, (key, contact: Contact) => {
            console.log(contact);
            let c = new Contact(contact.contactID, contact.vorname, contact.nachname, contact.email, contact.telefon);
            $("#contactTable tbody").append(this.addNewContact(c));
        });
    };

    private addNewContact(contact: Contact): string {
        let html = `
        <tr data-id="${contact.contactID}">
        <td>${contact.vorname}</td>
        <td>${contact.nachname}</td>
        <td>${contact.email}</td>
        <td>${contact.telefon}</td>
        </tr>
        `;
        return html;
    };

    private clear() {
        $("#contactTable tbody").empty();
    };
}

class Contact {
    public contactID: number;
    public vorname: string;
    public nachname: string;
    public email: string;
    public telefon: string;
    public notizen: string;
    public firma: string;

    constructor(id, vorname, nachname, email, telefon) {
        this.contactID = id;
        this.vorname = vorname;
        this.nachname = nachname;
        this.email = email;
        this.telefon = telefon;
    }
}

class EventHandler {
    constructor() {
        let contacts = new Contacts();

        let rules = {
            email: {
                email: true
            },
            nachname: {
                required: true
            },
            vorname: {
                required: true
            },
        };

        $("#createContact").on("click", event => {
            $("#createContactModal").modal("show");
        });

        $("#createContactForm").validate({
            debug: true,
            rules: rules,
            submitHandler: () => {
                $.post("ajax.php", $("#createContactForm").serialize())
                    .done(() => {
                        contacts.fetch();
                        $("#createContactModal").modal("hide");
                        this.resetForm();
                    })
                    .fail((error) => {
                        Error.show(error);
                    });
            },
        });

        $("#editContactForm").validate({
            debug: true,
            rules: rules,
            submitHandler: function () {
                $.post("ajax.php", $("#editContactForm").serialize())
                    .done(() => {
                        contacts.fetch();
                        $("#editContactModal").modal("hide");
                        this.resetForm();
                    })
                    .fail((error) => {
                        Error.show(error);
                    });
            },
        });

        $("#editContactModal").find('[name="delete"]').click(function () {
            let id = $('#editContactModal [name="id"]').val();

            $.post("ajax.php", {
                    id: id,
                    method: "contact_delete",
                })
                .done(() => {
                    contacts.fetch();
                    $("#editContactModal").modal("hide");
                })
                .fail((error) => {
                    Error.show(error);
                });
        });

        $("tr").on("click", function () {
            let id = $(this).attr("data-id");
            $.post("ajax.php", {
                    id: id,
                    method: "contact_fetch_id",
                })
                .done(function(contact: Contact) {
                    $("#editContactModal").find('[name="id"]').val(contact.contactID);
                    $("#editContactModal").find('[name="vorname"]').val(contact.vorname);
                    $("#editContactModal").find('[name="nachname"]').val(contact.nachname);
                    $("#editContactModal").find('[name="firma"]').val(contact.firma);
                    $("#editContactModal").find('[name="email"]').val(contact.email);
                    $("#editContactModal").find('[name="telefon"]').val(contact.telefon);
                    $("#editContactModal").find('[name="notizen"]').val(contact.notizen);
                    $("#editContactModal").modal("show");
                })
                .fail((error) => {
                    Error.show(error);
                });
        });
    }

    private resetForm() {
        $("#createContactForm").find("input[type=text], textarea").val("");
    }
}
