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
$tasks = array();
$finnishedTasks = array();
$sql = "SELECT * FROM tasks WHERE USER_ID = '$un' AND TEAM_ID = '$gn';";
if (!($result = $conn->query($sql)))
  echo ("Error: " . $conn->error);
while ($row = $result->fetch_assoc()) {
  $stringTest = $row['name'];
  $id=$row['TASK_ID'];
  if ($row['status'] == "IN_PROGRESS") {
    array_push($tasks, "<div class ='grid-item' id='".$id."' onClick='reply_click(this.id)'>".$stringTest."</div>");
  } else {
    array_push($finnishedTasks, "<div class ='grid-item' id='".$id."' onClick='reply_click(this.id)'>".$stringTest."</div>");
  }
}
$return = implode("", $tasks) . "*" . implode("", $finnishedTasks);
echo($return);
?>
