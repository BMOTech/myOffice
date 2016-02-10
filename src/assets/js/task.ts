/// <reference path="definitlytyped/jquery.d.ts" />
/// <reference path="definitlytyped/moment.d.ts" />

class Task {

    private displayTasks(tasks) {
        var that = this;
        $.each(tasks, function (key, value) {
            var description = value.description;
            var details = that.showDetails(value);
            var task_id = value.taskID;

            var html = `
            <li class="list-group-item clearfix task">
                <p>${description}</p>
                <div id="taskDetails">
                    <p>${details}</p>
                </div>
                <div data-id="${task_id}">
                    <span class="pull-left">
                        <button name="timer" class="btn btn-default btn-xs">00 : 00 : 00</button>
                    </span>
                    <span class="pull-right">
                        <button name="editTask" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></button>
                        <button name="deleteTask" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>
                    </span>
                </div>
            </li>
            `;

            $("#tasks").append(html);
        });

        var tasksNotFinished = $("li[data-notfinished]");

        $.each(tasksNotFinished, function (key, value) {
            var taskID = $(this).attr('data-notfinished');
            var watch = $("div[data-id=" + taskID + "]").find('button[name="timer"]');
            var timerID = $(this).attr('data-id');
            var now = moment();
            var start = moment($(this).attr('data-start'), "X").add(120, 'm');
            console.log(moment($(this).attr('data-start'), "X").format("HH : mm : ss"));
            var difference = moment(now.diff(start)).format("HH : mm : ss");

            if (timerID != null) {
                watch.text(difference);
                var stopWatch = new StopWatch(watch, that);
                stopWatch.timerID = parseInt(timerID);
                watch.data('myWatch', stopWatch);
                stopWatch.restartWatch();
            }
        });

    }

    private showDetails(task) {
        var that = this;
        var timers = task.timers;
        var listItems = "";

        $.each(timers, function (key, value) {
            var timerID = value.timerID;
            var start = value.start;
            var end = value.end;
            var startFormatted = moment(start, "YYYY-MM-DD HH:mm:ss").format("DD.MM.YY");
            var startTimestamp = moment(start, "YYYY-MM-DD HH:mm:ss").format("X");

            var difference = moment.utc(moment(end, "YYYY-MM-DD HH:mm:ss").diff(moment(start, "YYYY-MM-DD HH:mm:ss"))).format("HH:mm:ss");
            var notFinished = "";
            var dataStart = "";
            var lastStr = "";

            if(start) {
                if (!end) {
                    lastStr = "Noch nicht beendet!";
                    notFinished = 'data-notfinished="' + task.taskID + '"';
                    dataStart = 'data-start="' + startTimestamp + '"';
                } else {
                    lastStr = "Dauer: " + difference;
                }
                var listItem = `
                    <li data-id="${timerID}" ${notFinished} ${dataStart} class="list-group-item">An der Aufgabe gearbeitet am: ${startFormatted} - ${lastStr}</li>
                `;

            listItems += listItem;
            }
        });

        var html = `
                <ul class="list-group">
                    ${listItems}
                </ul>
                `;

        return html;
    }

    fetchTasks() {
        $("#tasks").empty();
        var that = this;
        $.post('ajax.php', {
                method: 'task_fetch'
            })
            .done(tasks => that.displayTasks(JSON.parse(tasks)))
            .fail(function () {
                alert("Fehler beim laden der Aufgaben!");
            })
    }
}

class StopWatch {

    taskID:number;
    interval:any;
    watch:JQuery;
    currentTime:any;
    timerID:number;
    task:Task;

    constructor(watch, task) {
        this.currentTime = watch.text();
        this.watch = watch;
        this.taskID = watch.closest('div').data('id');
        this.task = task;
    }

    startWatch() {
        var that = this;
        $.post('ajax.php', {
                id: this.taskID,
                method: 'timer_start'
            })
            .done(function (timer) {
                that.timerID = timer.timerID;
                that.interval = setInterval(() => that.displayTime(), 1000);
            })
            .fail(function () {
                alert("Fehler beim starten des Timers!");
            })
    }

    restartWatch() {
        this.interval = setInterval(() => this.displayTime(), 1000);
    }

    stopWatch() {
        var that = this;
        $.post('ajax.php', {
                method: 'timer_stop',
                taskID: that.taskID,
                timerID: that.timerID
            })
            .done(function (timer) {
                clearInterval(that.interval);
                that.task.fetchTasks();
            })
            .fail(function () {
                alert("Fehler beim stoppen des Timers!");
            })
    }

    displayTime() {
        var time = moment(this.currentTime, 'HH : mm : ss');
        this.currentTime = time.add(1, 's').format('HH : mm : ss')
        this.watch.text(this.currentTime);
    }

}


$('#link_tasks').click(function () {

    $('#content').load('templates/aufgaben.html', function () {
        var task = new Task();
        task.fetchTasks();

        $('#tasks').on('click', "button[name='timer']", function () {
            var watch = $(this);
            var watchData:StopWatch = watch.data('myWatch');

            if (watchData) {
                watchData.stopWatch();
                watch.data('myWatch', null);
            } else {
                console.log(watch);
                var stopWatch = new StopWatch(watch, task);
                watch.data('myWatch', stopWatch);
                stopWatch.startWatch();
            }
        });
    });
});
