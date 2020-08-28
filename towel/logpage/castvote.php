<?php
    session_start();
    include("../connectDatabase.php");
    header('location:viewlog.php');
    $vote = $_COOKIE['value'];
    $action=$_COOKIE['ACTION_ID'];
    $user=$_SESSION['username'];
    $sql="insert into has_voted(USER_ID,ACTION_ID) values('$user','$action')";
    mysqli_query($conn,$sql);
    $sql="select * from taskbuffer where ACTION_ID='$action'";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);
    $sum=$row['sum']+$vote;
    $i=$row['votes']+1;
    $sql="UPDATE taskbuffer
        SET sum = $sum, votes= $i
        WHERE ACTION_ID = '$action';";
    mysqli_query($conn,$sql);
    $team=$_SESSION["TEAM_ID"];
    $sql="select * from user_teams where TEAM_ID='$team'";
    $result=mysqli_query($conn,$sql);
    $count=mysqli_num_rows($result);
    echo $count;
    if($count==$i){
        //$avg=$l['sum']/$count;
                $sql="UPDATE logs
                SET type='PICK'
                WHERE ACTION_ID = '$action' and type='VOTE';";
                mysqli_query($conn,$sql);
    }
?>
