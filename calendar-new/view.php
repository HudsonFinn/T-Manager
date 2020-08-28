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
$id = $_POST['id'];
//Get info about current event
$sql = "SELECT * FROM events WHERE id = '$id';";
if (!($result = $conn->query($sql))) {
  echo ("Error: " . $conn->error);
}
while ($row = $result->fetch_assoc()) {
  $title = $row['title'];
  $thisStart = $row['start_event'];
}
$thisStart = strtotime($thisStart);
//Get previous event
$sql = "SELECT * FROM events WHERE teams = '$gn' ORDER BY start_event LIMIT 1;";
if (!($result = $conn->query($sql))) {
  echo ("Error: " . $conn->error);
}
while ($row = $result->fetch_assoc()) {
  $backStart = $row['start_event'];
}
$backStart = strtotime($backStart);
$finnishedEventsList = array();
$hasTask = false;
$sql = "SELECT * FROM tasks WHERE TEAM_ID = '$gn' AND status = 'FINISHED' ORDER BY date_submitted;";
if (!($result = $conn->query($sql))) {
  echo ("Error: " . $conn->error);
}
while ($row = $result->fetch_assoc()) {
  if (($row['date_submitted'] > $backStart) and ($row['date_submitted'] < $thisStart)) {
    array_push($finnishedEventsList, $row['name'] . ": ". $row['status']);
    $hasTask = true;
  }
}
if ($hasTask) {
  $return = $title . "*" . "<h4>Finished:</h4>" .implode("<br>", $finnishedEventsList);
} else {
  $return = $title . "*". "<h4>Finished:</h4>" . "None";
}

$lateEventsList = array();
$hasTask = false;
$sql = "SELECT * FROM tasks WHERE TEAM_ID = '$gn' AND status = 'IN_PROGRESS' ORDER BY deadline;";
if (!($result = $conn->query($sql))) {
  echo ("Error: " . $conn->error);
}
while ($row = $result->fetch_assoc()) {
  if ($row['deadline'] < $thisStart) {
    array_push($lateEventsList, $row['name'] . ": ". $row['status']);
    $hasTask = true;
  }
}
if ($hasTask) {
  $return = $return . "<h4>Late:</h4>" . implode("<br>", $lateEventsList);
} else {
  $return = $return . "<h4>Late:</h4>" . "None";
}



$currentEventsList = array();
$hasTask = false;
$sql = "SELECT * FROM tasks WHERE TEAM_ID = '$gn' AND status = 'IN_PROGRESS' ORDER BY deadline;";
if (!($result = $conn->query($sql))) {
  echo ("Error: " . $conn->error);
}
while ($row = $result->fetch_assoc()) {
  if ($row['deadline'] > $thisStart) {
    array_push($currentEventsList, $row['name'] . ": ". $row['status']);
    $hasTask = true;
  }
}
if ($hasTask) {
  $return = $return . "<h4>Current:</h4>" .implode("<br>", $currentEventsList);
} else {
  $return = $return . "<h4>Current:</h4>" . "None";
}
echo($return);
}


// Get all tasks
// $eventsList = array();
// array_push($eventsList, "")
// $sql = "SELECT * FROM tasks WHERE TEAM_ID = '$gn' ORDER BY ;";
// if (!($result = $conn->query($sql))) {
//   echo ("Error: " . $conn->error);
// }
// while ($row = $result->fetch_assoc()) {
//   array_push($eventsList, $row['name'] . ": ". $row['status']);
// }
// $return = $title . "*" . implode("<br>", $eventsList);
// echo($return);
//
// }
?>
