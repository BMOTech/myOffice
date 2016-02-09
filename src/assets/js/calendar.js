require('fullcalendar');
require('fullcalendar-de');

$.ajaxSetup({
    cache: false
});

$('#link_calendar').click(function() {

    $('#content').load('templates/kalender.html', function() {

        $("#createEventForm").validate({
            debug: true,
            rules: {
                title: {
                    required: true
                }
            },
            submitHandler: function() {
                $.post('ajax.php', $('#createEventForm').serialize())
                    .done(function() {
                        $('#calendar').fullCalendar('refetchEvents');
                        $('#createEventModal').modal('hide');
                        resetForm();
                    })
                    .fail(function() {
                        alert("Fehler beim speichern des Kalendereintrags!");
                    })
            }
        });

        $("#editEventForm").validate({
            debug: true,
            rules: {
                title: {
                    required: true
                }
            },
            submitHandler: function() {
                $.post('ajax.php', $('#editEventForm').serialize())
                    .done(function() {
                        $('#calendar').fullCalendar('refetchEvents');
                        $('#editEventModal').modal('hide');
                    })
                    .fail(function() {
                        alert("Fehler beim editieren des Kalendereintrags!");
                    })
            }
        });

        $('#editEventModal [name="delete"]').click(function() {
            var id = $('#editEventModal [name="id"]').val();

            $.post('ajax.php', {
                    method: 'cal_delete',
                    id: id
                })
                .done(function() {
                    $('#calendar').fullCalendar('refetchEvents');
                    $('#editEventModal').modal('hide');
                })
                .fail(function() {
                    alert("Fehler beim löschen des Kalendereintrags!");
                })
        });

        var resetForm = function() {
            $('#createEventForm').find("input[type=text], textarea").val("");
        }

        $('#calendar').fullCalendar({
            editable: true,
            selectable: true,
            dayClick: function(date) {
                var selectedDate = $.fullCalendar.moment(date);
                $('#createEventModal .selectedDate').text(selectedDate.format('Do MMMM YYYY'));
                $('#createEventModal [name="date"]').val(selectedDate);
                $('#createEventModal').modal('show');
            },
            eventClick: function(event) {
                $('#editEventModal .selectedDate').text(event.start.format('Do MMMM YYYY'));
                $('#editEventModal [name="id"]').val(event.id);
                $('#editEventModal [name="title"]').val(event.title);
                $('#editEventModal [name="text"]').val(event.text);
                $('#editEventModal').modal('show');
            },
            events: {
                url: 'ajax.php',
                type: 'POST',
                data: {
                    method: 'cal_fetch'
                },
                error: function() {
                    alert('Fehler beim abholen der Kalendereinträge!');
                }
            }
        });
    });
});

