var log ={}
log.fetchLogs = function () {
    $.ajax({
        url:'ajax/log.php',
        type: 'post',
        data:{method:'fetch'},
        success: function(data){
            $('.feed .logs').html(data);
        }
    });
}
log.fetchLogs();
/*
log.checkVotes = function () {
    $.ajax({
        url:'ajax/log.php',
        type: 'post',
        data:{method:'checkVotes'},
        success: function(data){
            $('.feed .logs').html(data);
        }
    });
}
*/

//$("#please").animate({ scrollTop: 1000 }, "fast");
log.interval= setInterval(log.fetchLogs, 5000);
//log.interval= setInterval(log.checkVotes, 30000);
