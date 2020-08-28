<?php
session_start();
include("../connectDatabase.php");
$user=$_SESSION['username'];
if(isset($_POST['method']) === true && empty($_POST['method']) === false){
    $method     =trim($_POST['method']);
    if($method =='isVisible'){
        $place=$_COOKIE["chatplace"];
        $sql="select * from user_subs where USER_ID='$user' and SUB_ID='$place'";
        $a=mysqli_query($conn,$sql);
        $sql="select * from tasks where USER_ID='$user' and TASK_ID='$place'";
        $b=mysqli_query($conn,$sql);
        $r=0;
        if(mysqli_num_rows($a) !=0 or mysqli_num_rows($b) !=0 ){
          $r=1;                  
        }
        echo $r;
    }
}
?>
