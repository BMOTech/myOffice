/// <reference path="definitlytyped/jquery.d.ts" />
/// <reference path="definitlytyped/moment.d.ts" />

import {Task} from "./Task";

export class StopWatch {
    private taskID: number;
    private interval: any;
    private watch: JQuery;
    private currentTime: any;
    private timerID: number;
    private task: Task;

    constructor(watch, task) {
        this.currentTime = watch.text();
        this.watch = watch;
        this.taskID = watch.closest("div").data("id");
        this.task = task;
    }

    public startWatch() {
        $.post("ajax.php", {
                id: this.taskID,
                method: "timer_start",
            })
            .done(timer => {
                this.timerID = timer.timerID;
                this.interval = setInterval(() => this.displayTime(), 1000);
            })
            .fail(function () {
                alert("Fehler beim starten des Timers!");
            });
    }

    public restartWatch(timerID) {
        this.timerID = timerID;
        this.interval = setInterval(() => this.displayTime(), 1000);
    }

    public stopWatch() {
        $.post("ajax.php", {
                method: "timer_stop",
                taskID: this.taskID,
                timerID: this.timerID,
            })
            .done(timer => {
                clearInterval(this.interval);
                $('#stopWatchForm [name="notiz"]').val("");
                $('#stopWatchForm [name="id"]').val(this.timerID);
                $("#stopWatchModal").modal("show");
            })
            .fail(function () {
                alert("Fehler beim stoppen des Timers!");
            });
    }

    private displayTime() {
        let time = moment(this.currentTime, "HH : mm : ss");
        this.currentTime = time.add(1, "s").format("HH : mm : ss")
        this.watch.text(this.currentTime);
    }
}

