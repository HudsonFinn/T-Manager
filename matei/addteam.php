<?php
session_start();
header('location:home.php');
$con= mysqli_connect('localhost','root','password');
mysqli_select_db($con,'userregistration');
$name=$_POST['teamadd'];
$s=" select * from usertable where name = '$name'";
$result = mysqli_query($con,$s);
$num= mysqli_num_rows($result);
if($num==1){
    echo"Username already taken";
    
}
else{
    $reg="insert into teams(teamname) values ('$name')";
    mysqli_query($con, $reg);
    echo "Registration successful";  
}
?>
