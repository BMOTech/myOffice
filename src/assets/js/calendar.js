require('fullcalendar');
require('fullcalendar-de');

$.ajaxSetup({
    cache: false
});

$('#link_calendar').click(function() {

    $('#content').load('templates/kalender.html', function() {

        $('#eventForm').on('submit', function(event) {
            var title = $('#title').val(),
                date = $('#date').val();

            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                data: {
                    method: 'cal_save',
                    date: date,
                    title: title
                },
                error: function() {
                    alert('there was an error while sending events!');
                },
                success: function() {
                    $('#createEventModal').modal('hide');
                    $('#calendar').fullCalendar( 'refetchEvents' );
                }
            });
            event.preventDefault();
        });

        $('#calendar').fullCalendar({
            lang: 'de',
            editable: true,
            selectable: true,
            dayClick: function(date) {
                var selectedDate = $.fullCalendar.moment(date);
                $('#createEventModal #selectedDate').text(selectedDate.format('Do MMMM YYYY'));
                $('#date').val(selectedDate);
                $('#createEventModal').modal('show');
            },
            events: {
                url: 'ajax.php',
                type: 'POST',
                data: {
                    method: 'cal_fetch'
                },
                error: function() {
                    alert('there was an error while fetching events!');
                }
            }
        });
    });
});