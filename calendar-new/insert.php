<?php
//insert.php
// I swear I have malformed dendrites
$servername = "dbhost.cs.man.ac.uk";
$username = "t25435gu";
$password = "sharp123";
$db = "2019_comp10120_z1";

$conn = mysqli_connect($servername, $username, $password, $db);
session_start();
$un = $_SESSION['username'];
$gn = $_SESSION['TEAM_ID'];
if(isset($_REQUEST))
{
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];
$sql = "INSERT INTO events (title, teams, start_event, end_event) VALUES ('$title', '$gn', '$start', '$end');";
if (!($result = $conn->query($sql))) {
  echo ("Error: " . $conn->error);
}
}

?>
