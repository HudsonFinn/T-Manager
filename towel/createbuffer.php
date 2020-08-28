<?php
session_start();
header("location:viewteam.php");
include("connectDatabase.php");
$con=$conn;
mysqli_select_db($con,'towel');

$team=$_SESSION['TEAM_ID'];
$user=$_SESSION['username'];
$name=$_POST['taskname'];
$desc=$_POST['taskdesc'];
$d=$_POST['day']."/".$_POST['month']."/".$_POST['year'];
$date = date_create_from_format('d/m/Y', $d);
$unix=date_timestamp_get($date);
$u=uniqid('TASK_ID_', true);
$t=time();
$sql="insert into taskbuffer(`ACTION_ID`,`USER_ID`,`TEAM_ID`,`sum`,`votes`,`taskname`,`deadline`,`desc`) values ('$u','$user','$team',0,0,'$name',
$unix,'$desc')";
//echo $sql;
mysqli_query($con,$sql);



$u2=uniqid('LOG_',true);
$sql="insert into logs(LOG_ID,type,ACTION_ID,TEAM_ID,name) values ('$u2','VOTE','$u','$team','$name')";
mysqli_query($con,$sql);

?>
