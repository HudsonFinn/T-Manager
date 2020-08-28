<?php

session_start();
header('location:login.php');
$con= mysqli_connect('localhost','root','password');
mysqli_select_db($con,'towel');
$name=$_POST['user'];
$pass=$_POST['password'];
$s=" select * from usertable where USER_ID = '$name'";
$result = mysqli_query($con,$s);
$num= mysqli_num_rows($result);
if($num==1){
    echo"Username already taken";
}
else{
    $u=uniqid('UID_', true);
    $reg="insert into users (USER_ID, password) values ('$name', '$pass')";
    mysqli_query($con, $reg);
    echo "Registration successful";
}


?>
