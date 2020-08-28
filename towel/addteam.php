<?php
session_start();
header('location:home.php');
$con= mysqli_connect('localhost','root','password');
mysqli_select_db($con,'towel');
$name=$_POST['teamadd'];
$s=" select * from teams where team = '$name'";
$result = mysqli_query($con,$s);
$num= mysqli_num_rows($result);
if($num==1){
    echo"Teamname already taken";
}
else{
    $u=uniqid('TEAM_ID_', true);
    $reg="insert into teams(TEAM_ID,team) values ('$u','$name')";
    mysqli_query($con, $reg);
    echo "Registration successful";  
}
?>
