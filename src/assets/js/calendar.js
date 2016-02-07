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
            submitHandler: function(form) {
                var jqxhr = $.post('ajax.php', $('#createEventForm').serialize())
                    .done(function() {
                        $('#calendar').fullCalendar('refetchEvents');
                        $('#createEventModal').modal('hide');
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
            submitHandler: function(form) {
                var jqxhr = $.post('ajax.php', $('#editEventForm').serialize())
                    .done(function() {
                        $('#calendar').fullCalendar('refetchEvents');
                        $('#editEventModal').modal('hide');
                    })
                    .fail(function() {
                        alert("Fehler beim editieren des Kalendereintrags!");
                    })
            }
        });

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

