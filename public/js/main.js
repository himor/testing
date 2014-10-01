function makeTime (seconds) {
    if (seconds > 0) {
        var t = new Date(1970, 0, 1);
            t.setSeconds(seconds);

        var s = t.toTimeString().substr(0,8);

        if (seconds > 86399) {
            s = Math.floor((t - Date.parse("1/1/70")) / 3600000) + s.substr(2);
        }

        $('#time').html('Доступное время: ' + s);
    } else {
        location.reload();
    }
}

$(function () {
    var xhr = $.ajax({
        url: path,
        dataType: 'json'
    }).done(function (data) {
        var term = data.duration - data.time;

        makeTime(term);

        setInterval(function () {
            term--;
            makeTime(term);
        }, 1000);
    });
});