var moment = require('moment');

$.ajaxSetup({
    cache: false
});

$('#link_tasks').click(function() {

    $('#content').load('templates/aufgaben.html', function() {



        function getTimers(tasks) {
            var output = "";
            if (tasks.timers.length === 1 && tasks.timers[0].start === null) {
                output = "<p>Noch keine Details vorhanden!</p>";
            } else {
                output = output.concat('<ul class="list-group">');
                $.each(tasks.timers, function(key, value) {
                    if (!value.end) {

                        output = output.concat('<li data-id="' + value.timerID + '" class="list-group-item">An der Aufgabe gearbeitet am: ' + moment(value.start, "YYYY-MM-DD HH:mm:ss").format("DD.MM.YY") + ' - Noch nicht beendet!');
                    } else {
                        var diff = moment.utc(moment(value.end, "YYYY-MM-DD HH:mm:ss").diff(moment(value.start, "YYYY-MM-DD HH:mm:ss"))).format("HH:mm:ss")
                        output = output.concat('<li data-id="' + value.timerID + '" class="list-group-item">An der Aufgabe gearbeitet am: ' + moment(value.start, "YYYY-MM-DD HH:mm:ss").format("DD.MM.YY") + ' - Dauer: ' + diff + '</li>');
                    }
                });
                output = output.concat("</ul>")
            }
            return output;
        }

        function showTasks(tasks) {
            $.each(tasks, function(key, value) {
                var task = '<li class="list-group-item clearfix task">' +
                    '<p>' + value.description + '</p>' +
                    '<div id="taskDetails">' + getTimers(value) + '</div>' +
                    '<div data-id="' + value.taskID + '"><span class="pull-left">' +
                    '<button name="timer" class="btn btn-default btn-xs">00 : 00 : 00</></span></button></span>' +
                    '<span class="pull-right"><button name="editTask" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></button>' +
                    '<button name="deleteTask" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>' +
                    '</span></div></li>';
                $("#tasks").append(task);
            });
        }

        var fetchTasks = function() {
            $("#tasks").empty();
            $.post('ajax.php', {
                    method: 'task_fetch'
                })
                .done(function(tasks) {
                    showTasks(JSON.parse(tasks));
                })
                .fail(function() {
                    alert("Fehler beim laden der Aufgaben!");
                })
        }
        window.fetchTasks = fetchTasks;

        fetchTasks();
    })
});