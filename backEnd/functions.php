<?php
function addUser($userName, $userPassword, $firstName, $lastName, $email) {
  include("../backEnd/connectDatabase.php");
  $sql = 'SELECT * FROM users WHERE USER_ID = ?';
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('s', $userName); // 's' specifies the variable type => 'string'
    $stmt->execute();
    $result = $stmt->get_result();
  }

  if (mysqli_num_rows($result) == 0) {
    //echo('insert');
    $sql = 'INSERT INTO users (USER_ID, firstName, lastName, password, email) VALUES (?, ?, ?, ?, ?)';
    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param('sssss', $userName, $firstName, $lastName, $userPassword, $email);
      $stmt->execute();
      $result = $stmt->get_result();
    } else {
      echo ("Error: " . $conn->error);
      return False;
    }
    return $userName;
  } else {
    return False;
  }
}

function addTeam($teamName, $teamPassword, $userID) {
  include("../backEnd/connectDatabase.php");
  //echo('select');
  $sql = 'SELECT * FROM teams WHERE team = ?';
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('s', $teamName);
    $stmt->execute();
    $result = $stmt->get_result();
  } else {
    echo ("Error: " . $conn->error);
    return False;
  }
  if (mysqli_num_rows($result) == 0) {
    //echo('insert');
    $uniqueID = uniqid('TEAM_ID_', true);
    $sql = "INSERT INTO teams (TEAM_ID, team, password) VALUES ('$uniqueID', '$teamName', '$teamPassword');";
    if (!($result = $conn->query($sql)))
      echo ("Error: " . $conn->error);
    $sql = "SELECT * FROM teams WHERE team = '$teamName'";
    if (!($result = $conn->query($sql)))
      echo ("Error: " . $conn->error);
    while ($row = $result->fetch_assoc()) {
      $groupID = $row['TEAM_ID'];
    $sql = "INSERT INTO user_teams (TEAM_ID, USER_ID, points) VALUES ('$groupID', '$userID', 0);";
    if (!($result = $conn->query($sql)))
      echo ("Error: " . $conn->error);
    return $groupID;
    }
  } else {
    //echo ('False');
    return False;
  }
}

function checkUser($userName, $userPassword) {
  include("../backEnd/connectDatabase.php");
  //echo('check');
  $sql = "SELECT * FROM users WHERE USER_ID = '$userName' AND password = '$userPassword'";
  if (!($result = $conn->query($sql)))
    echo ("Error: " . $conn->error);
  if (mysqli_num_rows($result) == 0) {
      return False;
  } else {
    while ($row = $result->fetch_assoc()) {
      $un = $row['USER_ID'];
      return $un;
    }
  }
}

function joinTeam($teamName, $teamPassword, $userID) {
  include("../backEnd/connectDatabase.php");
  //echo('check');
  $sql = "SELECT * FROM teams WHERE team = '$teamName' AND password = '$teamPassword'";
  if (!($result = $conn->query($sql)))
    echo ("Error: " . $conn->error);
  if (mysqli_num_rows($result) == 0) {
      return False;
  } else {
    while ($row = $result->fetch_assoc()) {
      $groupID = $row['TEAM_ID'];
      $sql = "SELECT * FROM user_teams WHERE TEAM_ID = '$groupID' AND USER_ID = '$userID'";
      if (!($result = $conn->query($sql))) {
        echo ("Error: " . $conn->error);
        return False;
      }
      if (mysqli_num_rows($result) > 0) {
        return False;
      }
      $sql = "INSERT INTO user_teams (TEAM_ID, USER_ID, points) VALUES ('$groupID', '$userID', 0);";
      if (!($result = $conn->query($sql)))
        echo ("Error: " . $conn->error);
      return $groupID;
    }
  }
}


function isUserInGroup ($userID) {
  include("../backEnd/connectDatabase.php");
  $sql = "SELECT * FROM user_teams WHERE USER_ID = '$userID'";
  if (!($result = $conn->query($sql)))
    echo ("Error: " . $conn->error);
  if (mysqli_num_rows($result) > 0) {
    return True;
  } else {
    return False;
  }
}

function getEvents ($userID, $GroupID) {
  include ("../backEnd/connectDatabase.php");
  $sql = "SELECT * FROM events WHERE GROUP_ID = '$GroupID'";
  $events = array();
  if (!($result = $conn->query($sql)))
    echo ("Error: " . $conn->error);
  while ($row = $resuly->fetch_assoc()) {
    array_push($events, array($row['name'], $row['start_time'], $row['end_time']));
  }
  return $events;
}

function addEvent ($GroupID, $name, $start, $end) {
  include ("../backEnd/connectDatabase.php");
  $sql = "INSERT INTO teams (GROUP_ID, name, start_time, end_time) VALUES ('$GroupID', '$name', '$start', '$end');";
  if (!($result = $conn->query($sql))) {
    echo ("Error: " . $conn->error);
    return false;
  }
  return true;
}

function takeUserInfo($userID) {
  include("../backEnd/connectDatabase.php");
  $sql="select * from users where USER_ID ='$userID'";
  $result=mysqli_query($conn,$sql);

  while($row=mysqli_fetch_assoc($result)){
    $details = array($row['firstName'], $row['lastName'], $row['USER_ID'], $row['email']);
    return $details;
  }
}

function takeGroupInfo($userID, $GroupID) {
  include("../backEnd/connectDatabase.php");
  $sql="SELECT * FROM teams WHERE TEAM_ID ='$GroupID'";
  $result=mysqli_query($conn,$sql);
  while($row=mysqli_fetch_assoc($result)){
    $name = $row['team'];
  $sql="SELECT * FROM user_teams WHERE TEAM_ID ='$GroupID'";
  $result=mysqli_query($conn,$sql);
  $users = array();
  while($row=mysqli_fetch_assoc($result)){
    array_push($users, $row['USER_ID']);
  }
  $details = array($name, $users);
  return $details;
  }
}
?>
