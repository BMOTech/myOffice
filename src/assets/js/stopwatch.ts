class StopWatch {

    run: boolean;

    startWatch() {
        this.run = true;
    }

    stopWatch() {
        this.run = false;
    }

    displayTime() {
        var time = moment(this.text(), 'HH : mm : ss');
        console.log(time.isValid());
        this.text(time.add(1, 's').format('HH : mm : ss'));
    }


}