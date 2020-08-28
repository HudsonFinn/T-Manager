<?php
session_start();
$parent= $_COOKIE['parent'];
header("location:viewtask.php");
echo $parent;
include("../connectDatabase.php");
$con= $conn;
mysqli_select_db($con,'towel');

$team=$_SESSION['TEAM_ID'];
$user=$_SESSION['username'];
$name=$_POST['subname'];
$name=trim($name);


$u=uniqid('SUB_ID_', true);
$sql="insert into subtasks(SUB_ID,name,parent) values('$u','$name','$parent')";
mysqli_query($con,$sql);




$u2=uniqid('LOG_',true);
$s=$parent;
$sql="insert into logs(LOG_ID,type,ACTION_ID,TEAM_ID,name) values ('$u2','SUB CREATED','$u','$team','$s')";
mysqli_query($con,$sql);

$u3=uniqid('USER_SUBS_ID_', true);
$sql="insert into user_subs(USER_SUBS_ID,SUB_ID,USER_ID) values('$u3','$u','$user')";
mysqli_query($con,$sql);
echo("erro");
?>
