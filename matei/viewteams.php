<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "userregistration";
//if(!isset($_SESSION['username'])){
//    header('location:login.php');
//}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
echo 'hello '. $_SESSION['username']. '<br>';
$curuser=$_SESSION['username'];
$sql = "select teams.teamname
        from teams
        inner join user_teams
        on user_teams.team=teams.teamname
        where user='$curuser'";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
      $stringTest = $row['teamname'];
      echo $stringTest;
    echo '<br>';
}


$conn->close();
?>