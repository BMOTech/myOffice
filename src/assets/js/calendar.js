require('fullcalendar');

$('#link_calendar').click(function() {
    $('#content').load('templates/kalender.html', function() {
        $('#calendar').fullCalendar({})
    });
    return false;
});
