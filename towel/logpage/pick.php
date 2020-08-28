<?php
    include("../connectDatabase.php");
    header("location:viewlog.php");
    session_start();
    $user=$_SESSION['username'];
    $team=$_SESSION['TEAM_ID'];
    $action= $_COOKIE['ACTION_ID'];
    
    $sql="SELECT * from taskbuffer where ACTION_ID='$action'";
    $result=mysqli_query($conn,$sql);
    $buffer=mysqli_fetch_assoc($result);

    $task_name=$buffer['taskname'];
    $task_desc=$buffer['desc'];
    $deadline=$buffer['deadline'];
    $now=time();
    $desc=$buffer['desc'];
    $points=$buffer['sum']/$buffer['votes'];
    $sql="insert into tasks(`TASK_ID`,`USER_ID`,`TEAM_ID`,`name`,`points`,`deadline`,`date_created`,`date_submitted`,`status`,`desc`) values('$action','$user','$team','$task_name',$points,$deadline,$now,0,'IN_PROGRESS','$desc')";
    echo $sql;
    mysqli_query($conn,$sql);
    
    $sql=  "update logs
            set type='TAKEN'
            where ACTION_ID='$action'";
    mysqli_query($conn,$sql);
    

?>
    