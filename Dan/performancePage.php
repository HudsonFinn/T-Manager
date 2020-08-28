<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../design_template.css">
    <style>
    {font-family: Monserrat, sans-serif;
          background: url("https://images.unsplash.com/photo-1570884745218-1275bb172d97?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1267&q=80");
            <!-- Photo by Nathan Queloz on Unsplash -->
          background-repeat: no-repeat;
          background-attachment: fixed;
          background-size: cover;}
    .jumbotron{
      background-color: #a78db8;
      padding-top: 5%;
      padding-bottom: 5%;
      box-shadow: 5px 3px 20px #000000;
    }
    .jumbotron .h1, .jumbotron h1{
      font-family: Montserrat, sans-serif;
      letter-spacing: -2px;
      text-align: center;
    }
    .jumbotron p{
      font-family: Montserrat, sans-serif;
      letter-spacing: -1px;
      text-align: center;
    }
    .btn-round{
      margin: auto;
      margin-top: 4% !important;
      margin-left: 10% !important;
      margin-bottom: 3%;
      display: block;
      background-color: #a78db8;
      border: none;
      cursor: pointer;
      border-radius: 50%;
      text-align: center;
      font-family: Montserrat, sans-serif;
      text-transform: uppercase;
      font-weight: lighter;
      letter-spacing: -1px;
      width: 250px;
      height: 250px;
      padding: 6px 0px;
      font-size: 25px;
      line-height: 1.42857;
      box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease 0s;
      float:left;
    }
    .btn-round:hover{
      background-color: #e6d0f4;
      box-shadow: 0px 20px 20px rgba(0, 0, 0, 0.1);
      color: #fff;
      transform: translateX(-30px);
    }
    </style>
    <script src="https://d3js.org/d3.v4.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top" style = "box-shadow: 0px 0px 0px #000000;">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand">T-MANAGER</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="../towel/logpage/viewlog.php">ACTIVITY LOG</a></li>
          <li><a href="../towel/viewtasks.php">TASKS</a></li>
          <li><a href="../calendar-new/index.php">MEETINGS</a></li>
          <li><a href="../Dan/performancePage.php">PERFORMANCE</a></li>
          <li><a href="../towel/profile.php">PROFILE</a></li>
          <li><a href="../towel/selectGroup.php">CHANGE GROUP</a></li>
          <li><a href="../towel/logout.php">LOGOUT</a></li>
        </ul>
      </div>
    </div>
  </nav>
<div class="jumbotron">
  <h1> Your Performance Analysis </h1>
  <p> Select one of the analysis graphs below to find out what kind of t-mate
    you are! </p>
  </div>
<form action='barGraph.php' method='POST'>
  <input class='btn-round' type='submit' value='Bar Graph'>
</form>
<form action='scatterGraph.php' method='POST'>
  <input class='btn-round' type='submit' value='Scatter Graph'>
</form>
<form action='pieChart.php' method='POST'>
  <input class='btn-round' type='submit' value='Pie Chart'>
</form>
<form action='../towel/networkview.php' method='POST'>
  <input class='btn-round' type='submit' value='Relations'>
</form>
<?php
session_start();

function getAverageTime($userID) {
  //Gets the average time for a completed task of a user.
  include("../backEnd/connectDatabase.php");
  $sql="select status,date_created,date_submitted from tasks where USER_ID = '$userID'";
  $result=mysqli_query($conn,$sql);
  $timeTaken = 0;
  $count = 0;

  while($row=mysqli_fetch_assoc($result)){
    $status = $row['status'];
    $create = $row['date_created'];
    $submit = $row['date_submitted'];
    if ($status == 'FINISHED'){
      $timeTaken += $submit - $create;
      $count += 1;
    }
  }
  if ($count == 0){
    return 0;
  }
  $averageTime = $timeTaken / $count;
  $averageTime = $averageTime/3600;
  $averageTime = round($averageTime,PHP_ROUND_HALF_UP);
  return $averageTime;
}

function getPercentageCompleted($userID) {
  //Gets the percentage of the user's tasks completed.
  $done = 0;
  $total = 0;
  include("../backEnd/connectDatabase.php");
  $sql="select status from tasks where USER_ID = '$userID'";
  $result=mysqli_query($conn,$sql);

  while($row=mysqli_fetch_assoc($result)){
    $total += 1;
    if ($row['status'] == 'FINISHED'){
      $done += 1;
    }
  }
  if ($total == 0){
    return 0;
  }
  $percentageDone = $done/$total*100;
  return $percentageDone;
}

function getUserPoints($userID) {
  //Accesses the tasks table and adds up all of the points for the given
  //user ID.
  $points = 0;
  include("../backEnd/connectDatabase.php");
  $sql="select points, status from tasks where USER_ID ='$userID'";
  $result=mysqli_query($conn,$sql);

  while($row=mysqli_fetch_assoc($result)){
    $status = $row['status'];
    $details = $row['points'];
    if ($status == 'FINISHED'){
      $points = $details + $points;
    }
  }
  return $points;
}

function takeGroupInfo($userID, $GroupID) {
  // Returns all other users given the current user and their
  // logged in group.
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

function getTeamPoints($teamDetails){
  // Returns an array containing all of the points of the users given an array
  // of their Ids.
  $pointsArray = [];
  for ($x = 0; $x <= count($teamDetails)-1; $x++){
    $currentUser = $teamDetails[$x];
    $currentUserPoints = getUserPoints($currentUser);
    array_push($pointsArray, $currentUserPoints);
  }
  return $pointsArray;
}

function getPointTimes($userID){
  //Returns the points and time taken for each task of a given user.
  $pointTime = [];
  include("../backEnd/connectDatabase.php");
  $sql="select date_created, date_submitted, points from tasks where USER_ID='$userID' and status='FINISHED'";
  $result = mysqli_query($conn,$sql);

  while($row=mysqli_fetch_assoc($result)){
    $start = $row['date_created'];
    $end = $row['date_submitted'];
    $point = $row['points'];
    $time = $end - $start;
    $time = $time/3600;
    $time = round($time, 0, PHP_ROUND_HALF_UP);
    array_push($pointTime,[$point,$time,$userID]);
  }
  return $pointTime;
}

function runLogic(){
  //Gets all of the necessary data from the database to draw the graphs.
  //All user ids and points for a given team.
  $totalPoints = 0;
  $userPoints = getUserPoints($_SESSION['username']);
  $teamDetails = takeGroupInfo($_SESSION['username'], $_SESSION['TEAM_ID']);
  $teamPoints = getTeamPoints($teamDetails[1]);
  $userTime = getAverageTime($_SESSION['username']);
  $userPercent = getPercentageCompleted($_SESSION['username']);
  foreach ($teamPoints as $points){
    $totalPoints += $points;
  }
  $teamNames = [];
  foreach($teamDetails[1] as $name){
    array_push($teamNames, $name);
  }
  $avgPoints = $totalPoints/count($teamDetails[1]);
  $maxPoints = max($teamPoints);
  $minPoints = min($teamPoints);
  return [$userPoints, $maxPoints, $minPoints, $avgPoints,
          $userTime,$userPercent,$teamNames];
}

$dataArray = runLogic();
$user = $dataArray[0];
$max = $dataArray[1];
$min = $dataArray[2];
$avg = $dataArray[3];
$time = $dataArray[4];
$perc = $dataArray[5];
$teamD = $dataArray[6];
$perc = round($perc,0, PHP_ROUND_HALF_UP);
$avg = round($avg,0,PHP_ROUND_HALF_UP);
$time = round($time,0,PHP_ROUND_HALF_UP);
$toWrite = array(
  array("points", "category"),
  array($user,"Your Score"),
  array($max,"Max Score"),
  array($min,"Min Score"),
  array($avg,"Avg Score"),
  array($time,"Task Time (h)"),
  array($perc,"% of tasks complete")
);
$file = fopen("stats.csv", "w");
foreach ($toWrite as $line){
  fputcsv($file, $line);
}
fclose($file);
$toWrite2 = [["points","time","id"]];
foreach ($teamD as $mem){
  $memDets = getPointTimes($mem);
  foreach ($memDets as $det){
    array_push($toWrite2, $det);
  }
}
$file2 = fopen("plot.csv", "w");
foreach($toWrite2 as $line){
  fputcsv($file2, $line);
}
fclose($file2);
?>
<script>
</script>
</body>
</html>
