function countdown(selector, endDate, callback) {
    let deadline = endDate
        .getTime();
    let x = setInterval(function () {
        let now = new Date().getTime();
        let t = deadline - now;
        if (t <= 0) {
            clearInterval(x);
            $(selector).html('')
            callback()
            return
        }
        const days = Math.floor(t / (1000 * 60 * 60 * 24));
        const hours = Math.floor(
            (t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor(
            (t % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor(
            (t % (1000 * 60)) / 1000);
        $(selector).html(
            days + "d " + hours + "h " +
            minutes + "m " + seconds + "s ");

    }, 1000);

}
