/// <reference path="definitlytyped/jquery.d.ts" />
/// <reference path="definitlytyped/moment.d.ts" />

import {StopWatch} from "./Stopwatch";

export class Task {

    public fetchTasks() {
        $.post("ajax.php", {
                method: "task_fetch"
            })
            .done(tasks => this.displayTasks(JSON.parse(tasks)))
            .fail(function () {
                alert("Fehler beim laden der Aufgaben!");
            });
    }

    private displayTasks(tasks) {
        $("#tasks").empty();
        $.each(tasks, (key, value) => {
            let description = value.description;
            let task_id = value.taskID;
            let details = this.showDetails(value);
            let html = `
            <li class="list-group-item clearfix task">
                <p>${description}</p>
                <div class="taskDetails">
                    <p>${details}</p>
                </div>
                <div data-id="${task_id}">
                    <span class="pull-left">
                        <button name="timer" class="btn btn-default btn-xs">00 : 00 : 00</button>
                    </span>
                    <span class="pull-right">
                        <button name="showDetails" class="btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-zoom-in"></span>
                        </button>
                        <button name="editTask" class="btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        <button name="deleteTask" class="btn btn-danger btn-xs">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </span>
                </div>
            </li>
            `;
            $("#tasks").append(html);
            $(".taskDetails").hide();
        });

        let tasksNotFinished = $("li[data-notfinished]");

        $.each(tasksNotFinished, (key, value) => {
            let taskID = $(value).attr("data-notfinished");
            let watch = $("div[data-id=" + taskID + "]").find('button[name="timer"]');
            let timerID = $(value).attr("data-id");
            let now = moment();
            let start = moment($(value).attr("data-start"), "X").add(60, "m");
            let difference = moment(now.diff(start)).format("HH : mm : ss");


            if (timerID != null) {
                watch.text(difference);
                let stopWatch = new StopWatch(watch, this);
                watch.data("myWatch", stopWatch);
                stopWatch.restartWatch(timerID);
            }
        });
    }

    private showDetails(task) {
        let timers = task.timers;
        let listItems = "";

        $.each(timers, function (key, value) {
            let timerID = value.timerID;
            let start = value.start;
            let end = value.end;
            let notiz = value.notiz;
            let startFormatted = moment(start, "YYYY-MM-DD HH:mm:ss").format("DD.MM.YY");
            let startTimestamp = moment(start, "YYYY-MM-DD HH:mm:ss").format("X");
            let difference = moment.utc(moment(end).diff(moment(start))).format("HH:mm:ss");
            let notFinished = "";
            let dataStart = "";
            let lastStr = "";

            if (!notiz) {
                notiz = "";
            } else {
                notiz = "<br>Notiz: " + notiz;
            }

            if (start) {
                if (!end) {
                    lastStr = "Noch nicht beendet!";
                    notFinished = 'data-notfinished="' + task.taskID + '"';
                    dataStart = 'data-start="' + startTimestamp + '"';
                } else {
                    lastStr = difference;
                }
                let listItem = `
                    <li data-id="${timerID}" ${notFinished} ${dataStart} class="list-group-item">
                    ${startFormatted}: <i>${lastStr}</i> an der Aufgabe gearbeitet. ${notiz}
                    </li>
                `;

                listItems += listItem;
            }
        });

        let html = `
                <ul class="list-group">
                    ${listItems}
                </ul>
                `;

        return html;
    }
}


$("#link_tasks").click(function () {

    $("#content").load("templates/aufgaben.html", function () {
        let task = new Task();
        task.fetchTasks();

        $("#tasks")
            .on("click", "button[name='timer']", function () {
                let watch = $(this);
                let watchData: StopWatch = watch.data("myWatch");

                if (watchData) {
                    watchData.stopWatch();
                    watch.data("myWatch", null);
                } else {
                    console.log(watch);
                    let stopWatch = new StopWatch(watch, task);
                    watch.data("myWatch", stopWatch);
                    stopWatch.startWatch();
                }
            })
            .on("click", "button[name='deleteTask']", function () {
                let taskID = $(this).closest("div").data("id");
                $.post("ajax.php", {
                        id: taskID,
                        method: "task_delete",
                    })
                    .done(function () {
                        task.fetchTasks();
                    })
                    .fail(function () {
                        alert("Fehler beim laden der Aufgaben!");
                    });
            })
            .on("click", "button[name='showDetails']", function () {
                $(this).closest("li").find('.taskDetails').toggle();

            })
            .on("click", "button[name='editTask']", function () {
                let taskID = $(this).closest("div").data("id");
                let taskname = $(this).closest("li").find("p").text().trim();
                $('#editTaskModal [name="name"]').val(taskname);
                $('#editTaskModal [name="id"]').val(taskID);
                $("#editTaskModal").modal("show");
            });

        $("#editTaskForm").validate({
            debug: true,
            rules: {
                name: {
                    required: true
                },
            },
            submitHandler: function () {
                $.post("ajax.php", $("#editTaskForm").serialize())
                    .done(function () {
                        task.fetchTasks();
                        $("#editTaskModal").modal("hide");
                    })
                    .fail(function () {
                        alert("Fehler beim speichern der Aufgabe!");
                    });
            },
        });

        $("#content")
            .on("click", "button[name='addEvent']", function () {
                let text = $("#taskInput").val();
                $.post("ajax.php", {
                        description: text,
                        method: "task_save",
                    })
                    .done(function () {
                        task.fetchTasks();
                    })
                    .fail(function () {
                        alert("Fehler beim laden der Aufgaben!");
                    });

            });

        $("#stopWatchForm").validate({
            debug: true,
            rules: {
                notiz: {
                    required: false
                },
            },
            submitHandler: function () {
                $.post("ajax.php", $("#stopWatchForm").serialize())
                    .done(function () {
                        task.fetchTasks();
                        $("#stopWatchModal").modal("hide");
                    })
                    .fail(function () {
                        alert("Fehler beim speichern der Notiz!");
                    });
            },
        });

        $('#stopWatchModal').on('hidden.bs.modal', function () {
            task.fetchTasks();
        });
    });
});
