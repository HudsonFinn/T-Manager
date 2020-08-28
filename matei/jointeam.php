<?php
session_start();
header('location:home.php');
$con= mysqli_connect('localhost','root','password');
mysqli_select_db($con,'userregistration');
$name=$_POST['teamjoin'];
$currentuser=$_SESSION['username'];
$reg="insert into user_teams(user, team) values ('$currentuser', '$name')";
mysqli_query($con, $reg);
?>
