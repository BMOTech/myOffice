$.ajaxSetup({
    cache: false
});

$('#link_contacts').click(function() {

    $('#content').load('templates/kontakte.html', function() {
        var showContactDetails = function(id) {
            $.post('ajax.php', {
                id: id,
                method: 'contact_fetch_id'
            })
                .done(function(contact) {
                    $('#editContactModal [name="id"]').val(contact.contactID);
                    $('#editContactModal [name="vorname"]').val(contact.vorname);
                    $('#editContactModal [name="nachname"]').val(contact.nachname);
                    $('#editContactModal [name="firma"]').val(contact.firma);
                    $('#editContactModal [name="email"]').val(contact.email);
                    $('#editContactModal [name="telefon"]').val(contact.telefon);
                    $('#editContactModal [name="notizen"]').val(contact.notizen);
                    $('#editContactModal').modal('show');
                })
                .fail(function() {
                    alert("Fehler beim laden des Kontakts!");
                })
        }

        window.showContactDetails = showContactDetails;

        $('#createContact').click(function() {
            $('#createContactModal').modal('show');
        });

        $("#createContactForm").validate({
            debug: true,
            rules: {
                vorname: {
                    required: true
                },
                nachname: {
                    required: true
                },
                email: {
                    email: true
                }
            },
            submitHandler: function() {
                $.post('ajax.php', $('#createContactForm').serialize())
                    .done(function() {
                        fetchContacts();
                        $('#createContactModal').modal('hide');
                        resetForm();
                    })
                    .fail(function() {
                        alert("Fehler beim speichern des Kalendereintrags!");
                    })
            }
        });

        $("#editContactForm").validate({
            debug: true,
            rules: {
                vorname: {
                    required: true
                },
                nachname: {
                    required: true
                },
                email: {
                    email: true
                }
            },
            submitHandler: function() {
                $.post('ajax.php', $('#editContactForm').serialize())
                    .done(function() {
                        fetchContacts();
                        $('#editContactModal').modal('hide');
                        resetForm();
                    })
                    .fail(function() {
                        alert("Fehler beim speichern des Kalendereintrags!");
                    })
            }
        });

        $('#editContactModal [name="delete"]').click(function() {
            var id = $('#editContactModal [name="id"]').val();

            $.post('ajax.php', {
                    method: 'contact_delete',
                    id: id
                })
                .done(function() {
                    fetchContacts()
                    $('#editContactModal').modal('hide');
                })
                .fail(function() {
                    alert("Fehler beim löschen des Benutzers!");
                })
        });

        var resetForm = function() {
            $('#createContactForm').find("input[type=text], textarea").val("");
        }

        function newRow(contact) {
            return '<tr onclick="showContactDetails(' + contact.contactID + ')"><td>' + contact.vorname + '</td><td>' + contact.nachname + '</td><td>' + contact.email + '</td><td>' + contact.telefon + '</td></tr>';
        }

        function showContacts(contacts) {
            $.each(contacts, function(key, value) {
                $("#contactTable tbody").append(newRow(value));
            });
        }

        function fetchContacts() {
            $("#contactTable tbody").empty();
            $.post('ajax.php', {
                    method: 'contact_fetch'
                })
                .done(function(contacts) {
                    showContacts(contacts);
                })
                .fail(function() {
                    alert("Fehler beim löschen des Kalendereintrags!");
                })
        }

        fetchContacts();
    });
})