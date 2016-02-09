$.ajaxSetup({
    cache: false
});

$('#link_tasks').click(function() {

    $('#content').load('templates/aufgaben.html', function() {

        $('#tasks').on('click', "button[name='timer']", function() {
            var $this = $(this);
            toggleWatch($this);
        });

        function displayTime(watch) {
            var time = moment(this.text(), 'HH : mm : ss');
            this.text(time.add(1, 's').format('HH : mm : ss'));
        }

        function toggleWatch(watch) {
            var id = watch.closest('div').data('id');
            if (watch.run === false) {
                var myTimer = setInterval(displayTime.bind(watch), 1000);
                watch[run] = true;
            } else {
                clearInterval(myTimer);
            }
        }

        function getTimers(tasks) {
            var timers = "<ul>";
            $.each(tasks.timers, function(key, value) {
                timers = timers.concat("<li>" + value.start + " - " + value.end + "</li>");
            });
            timers = timers.concat("</ul>")
            return timers;
        }

        function showTasks(tasks) {
            $.each(tasks, function(key, value) {
                var task = '<li class="list-group-item clearfix task">' +
                    '<p>' + value.description + '</p>' +
                    '<div id="taskDetails">' + getTimers(value) + '</div>' +
                    '<div data-id="' + value.taskID + '"><span class="pull-left">' +
                    '<button name="timer" class="btn btn-default btn-xs">00 : 00 : 00</></span></button></span>' +
                    '<span class="pull-right"><button onClick="editTask(1)" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></button>' +
                    '<button onClick="deleteTask(1)" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>' +
                    '</span></div></li>';
                $("#tasks").append(task);
            });
        }

        function fetchTasks() {
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

        $("#tasks").empty();
        fetchTasks();
    })
});