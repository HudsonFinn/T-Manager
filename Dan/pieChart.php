<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../design_template.css">
  <link rel="stylesheet" type="text/css" href="popupStyles.css">
    <style>
    .grid-container {
      display: grid;
      grid-template-columns: auto auto auto;
      background-color: #a78db8;
      margin-top: 20vh;
      height: auto;
      padding: 10px;
      width: 70%;
      margin-top: 2%;
      margin-left: 15%;
      margin-right: auto;
    }
    .grid-item {
      background-color: #e6d0f4;
      border: 1px solid rgba(0, 0, 0, 0.8);
      margin-left: 5%;
      margin-right: 5%;
      margin-bottom: 2%;
      padding: 20px;
      font-size: 30px;
      text-align: center;
    }
    .modal-header, h4, .close {
        background-color: #a78db8;
        color:black !important;
        text-align: center;
        font-size: 30px;
      }
      .modal-footer {
        background-color: #a78db8;
      }

      .task_form{
        margin-left: 30%;
        margin-right:30%;
        height: 45%;
      }
      .btn-circle
      {
        background-color: #a78db8;
        border: none;
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        border-radius: 40px;
        text-align: center;
        font-family: Montserrat, sans-serif;
        text-transform: uppercase;
        letter-spacing: -1px;
        width: 65px;
        height: 65px;
        padding: 6px 0px;
        font-size: 12px;
        line-height: 1.42857;
        margin-left: 20%
      }
      .btn-circle:hover{
        background-color: #e6d0f4;
        box-shadow: 0px 15px 18px rgba(0, 0, 0, 0.1);
        color: #fff;
      }
      .modal-content
      {
        z-index: 5;
        margin-top: 25%;}

    .btn-group {
      text-align: center;
      margin-left: 34%;
    }
    .btn-group button {
      background-color: #e6d0f4 !important; /* Green background */
      border: 1px solid black; /* Green border */
      margin-top: 10vh;
      color: black; /* White text */
      padding: 10px 24px; /* Some padding */
      cursor: pointer; /* Pointer/hand icon */
      float: left; /* Float the buttons side by side */
    }
    .btn-group button:not(:last-child) {
      border-right: none; /* Prevent double borders */
    }
    /* Clear floats (clearfix hack) */
    .btn-group:after {
      content: "";
      clear: both;
      display: table;
    }
    /* Add a background color on hover */
    .btn-group button:hover {
      background-color: #e6d0f4;
    }
</style>
    <script src="https://d3js.org/d3.v4.min.js"></script>
    <script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>
</head>
<body>
  <nav class="navbar navbar-default navbar-fixed-top">
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
  <br><br><br><br>
<?php
session_start();

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

function getTeamPoints($teamDetails){
  // Returns an array containing all of the points of the users given an array
  // of their Ids.
  $pointsArray = [];
  for ($x = 0; $x <= count($teamDetails)-1; $x++){
    $currentUser = $teamDetails[$x];
    $currentUserPoints = getUserPoints($currentUser);
    $currentProjectedPoints = getAllPoints($currentUser);
    array_push($pointsArray, [$currentUserPoints,$currentProjectedPoints]);
  }
  return $pointsArray;
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

function getCompleted($userID) {
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
  return [$done, $total];
}

function getAllPoints($userID) {
  //Gets all user's points.
  $points = 0;
  include ("../backEnd/connectDatabase.php");
  $sql="select points from tasks where USER_ID = '$userID'";
  $result=mysqli_query($conn,$sql);

  while($row=mysqli_fetch_assoc($result)){
    $points += $row['points'];
  }
  return $points;
}

$userPoints = getUserPoints($_SESSION['username']);
$proUserPoints = getAllPoints($_SESSION['username']);
$teamDetails = takeGroupInfo($_SESSION['username'], $_SESSION['TEAM_ID']);
$teamPoints = getTeamPoints($teamDetails[1]);
$doneTotal = getCompleted($_SESSION['username']);
$totalCur = -$userPoints;
$totalPro = -$proUserPoints;
$done = $doneTotal[0];
$total = $doneTotal[1];
$teamTotal = 0;
$teamDone = 0;
foreach($teamPoints as $point){
  $totalCur += $point[0];
  $totalPro += $point[1];
}
foreach($teamDetails[1] as $user){
  $curDoneTotal = getCompleted($user);
  $teamTotal += $curDoneTotal[1];
  $teamDone += $curDoneTotal[0];
}
$teamTotal -= $teamDone;
$total -= $done;
?>
<div class="popup" onclick="showInfo()"><h2 style="text-align:center!important;">What am I looking at?</h2>
  <span class="popuptext" id="myPopup">These pie charts show many different things.
  The first shows how many tasks you have (orange) and haven't (green) completed.
  The second shows how many tasks your team has (orange) and hasn't (green) completed.
  The third shows how many points you have (green) and the rest of your team has (orange) contributed.
  The final shows how may points you will (green) and the rest of your team will (orange) contribute
  if all current tasks are finished.</span>
</div>
<div class="btn-group" style="width:100%">
  <button id="yComplete" style="width:15.3%;" onclick="updateChart(data1)">Your Completion</button>
  <button id="tComplete" style="width:15.3%" onclick="updateChart(data2)">Team Completion</button>
  <button id="cContrib" style="width:15.3%" onclick="updateChart(data3)">Current Contribution</button>
  <button id="pContrib" style="width:15.3%" onclick="updateChart(data4)">Projected Contribution</button>
</div>
<div id="pie_chart"></div>
<script>
function showInfo() {
  var popup = document.getElementById("myPopup");
  popup.classList.toggle("show");
}
</script>
<script>
  var cUPoints = <?php echo $userPoints ?>;
  var pUPoints = <?php echo $proUserPoints ?>;
  var cTPoints = <?php echo $totalCur ?>;
  var pTPoints = <?php echo $totalPro ?>;
  var uDone = <?php echo $done ?>;
  var uTotal = <?php echo $total ?>;
  var tTotal = <?php echo $teamTotal ?>;
  var tDone = <?php echo $teamDone ?>;

  var width = 450
      height = 450
      margin = 40;

  var radius = Math.min(width, height) / 2 - margin;

  var svg = d3.select("#pie_chart")
              .append("svg")
              .attr("height", height)
              .attr("width", width)
            .append("g")
              .attr("transform", "translate(" + width / 2 + "," + height/2 + ")");

  var data2 = {a: tTotal, b: tDone};
  var data1 = {a: uDone, b: uTotal};
  var data3 = {a: cUPoints, b: cTPoints};
  var data4 = {a: pUPoints, b: pTPoints};

  var color = d3.scaleOrdinal()
                .domain(["a", "b", "c", "d", "e", "f"])
                .range(d3.schemeDark2);

  function updateChart(data) {
      var pie = d3.pie()
                  .value(function(d) {return d.value})
                  .sort(function(a, b) { console.log(a) ; return d3.ascending(a.key, b.key);})

      var data_inp = pie(d3.entries(data));

      var map = svg.selectAll("path")
                   .data(data_inp);

      map
        .enter()
        .append("path")
        .merge(map)
        .transition()
        .duration(1000)
        .attr('d', d3.arc()
          .innerRadius(0)
          .outerRadius(radius)
        )
        .attr("fill", function(d){ return(color(d.data.key))})
        .attr("stroke", "white")
        .style("stroke-width", "2px")
        .style("opacity", 1)

      map
        .exit()
        .remove()
  }

  updateChart(data1);
</script>
</body>
</html>
