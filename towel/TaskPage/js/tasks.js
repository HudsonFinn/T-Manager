var tasks ={}

tasks.fetchTasks = function () {
    $.ajax({
        url:'ajax/tasks.php',
        type: 'post',
        data:{method:'fetch'},
        success: function(data){
            $('.task').html(data);
        }
    });
}
tasks.fetchTasks();
tasks.interval= setInterval(tasks.fetchTasks, 5000);