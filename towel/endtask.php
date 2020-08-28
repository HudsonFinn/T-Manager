<?php
    include("connectDatabase.php");
    header("location:logpage/viewlog.php");
    session_start();
    $user=$_SESSION['username'];
    $task = $_COOKIE['TASK_ID'];
    $now=time();
    $sql="update tasks
            set status='FINISHED',
            date_submitted=$now
            where TASK_ID='$task'";
    //echo $sql;
    mysqli_query($conn,$sql);
    
    $sql=  "update logs
            set type='FINISHED'
            where ACTION_ID='$task'";
    mysqli_query($conn,$sql);
    


?>