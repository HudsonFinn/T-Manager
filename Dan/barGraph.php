<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../design_template.css">
  <link rel="stylesheet" type="text/css" href="popupStyles.css">
    <style>
        .bar {
            fill: #b2ebf2;
        }

        .average {
            fill: orange;
        }

        .below {
          fill: red;
        }

        .above {
          fill: green;
        }
        .container{
          float: left;
        }

        .container2{
          float: left;
        }
</style>
    <script src="https://d3js.org/d3.v4.min.js"></script>
</head>
<body style="text-align: center;
            margin: 30px;">
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
  <br><br><br>
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
$max = $dataArray[1];
$avg = $dataArray[3];
$time = $dataArray[4];
$perc = $dataArray[5];
$perc = round($perc,0, PHP_ROUND_HALF_UP);
$avg = round($avg,0,PHP_ROUND_HALF_UP);
$time = round($time,0,PHP_ROUND_HALF_UP);
?>
<div class="popup" onclick="showInfo()" style="clear:both;"><h2>What am I Looking at?</h2>
  <span class="popuptext" id="myPopup">This bar graph shows statistics about
  yourself and your teammates. The information includes your current point total and
the highet, lowest and average point totals of your team respectively.
Aditionally, you can see your average time taken to complete a task as well as
the percentage of your tasks that you have completed!</span>
</div>
<div>
<svg width="900" height="700" class="container" style="clear:both;"></svg>
</div>
<script>
function showInfo() {
  var popup = document.getElementById("myPopup");
  popup.classList.toggle("show");
}
</script>
<script>

    var avg = <?php echo $avg ?>;
    var max = <?php echo $max ?>;
    var time = <?php echo $time?>;
    var perc = <?php echo $perc?>;

    var svg = d3.select("svg"),
        margin = 250,
        width = svg.attr("width") - margin,
        height = svg.attr("height") - margin;

    var x = d3.scaleBand().range([0, width]).padding(0.4),
        y = d3.scaleLinear().range([height, 0]);

    var g = svg.append("g")
            .attr("transform", "translate(" + 100 + "," + 120 + ")");

    d3.csv("stats.csv", function(error, data) {
        if (error) {
            throw error;
        }

        x.domain(data.map(function(d) { return d.category; }));
        y.domain([0, d3.max([max,time,perc])]);

        g.append("g")
         .attr("transform", "translate(0," + height + ")")
         .call(d3.axisBottom(x))
         .append("text")
         .attr("y", height - 400)
         .attr("x", width - 100)
         .attr("text-anchor", "end")
         .attr("stroke", "black")
         .text("Category");

        g.append("g")
         .call(d3.axisLeft(y).tickFormat(function(d){
             return d;
         }).ticks(10))
         .append("text")
         .attr("transform", "rotate(-90)")
         .attr("y", 6)
         .attr("dy", "-5.1em")
         .attr("text-anchor", "end")
         .attr("stroke", "black")
         .text("Points");

        g.selectAll(".bar")
         .data(data)
         .enter().append("rect")
         .attr("class", "bar")
         .on("mouseover", onMouseOver) //Add listener for the mouseover event
         .on("mouseout", onMouseOut)   //Add listener for the mouseout event
         .attr("x", function(d) { return x(d.category); })
         .attr("y", function(d) { return y(d.points); })
         .attr("width", x.bandwidth())
         .transition()
         .ease(d3.easeLinear)
         .duration(400)
         .delay(function (d, i) {
             return i * 75;
         })
         .attr("height", function(d) { return height - y(d.points); });
    });

    //mouseover event handler function
    function onMouseOver(d, i) {
        d3.select(this).attr('class', function(d, i){
          if (d.category == "% of tasks complete"){
            if (d.points < 30){
              return "below";
            }
            else if (d.points > 70){
              return "above";
            }
            else{
              return "average";
            }
          }
          if (d.category == "Task Time (h)"){
            if (d.points < 24){
              return "above";
            }
            else if (d.points > 72){
              return "below";
            }
            else{
              return "average";
            }
          }
          if (d.points > avg + 20){
            return "above";
          }
          else if (d.points < (avg - 20)){
            return "below";
          }
          else{
            return "average";
          }
        });
        d3.select(this)
          .transition()     // adds animation
          .duration(400)
          .attr('width', x.bandwidth() + 5)
          .attr("y", function(d) { return y(d.points) - 10; })
          .attr("height", function(d) { return height - y(d.points) + 10; });

        g.append("text")
         .attr('class', 'val')
         .attr('x', function() {
             return x(d.category);
         })
         .attr('y', function() {
             return y(d.points) - 15;
         })
         .text(function() {
             return [d.points];  // Value of the text
         });
    }

    //mouseout event handler function
    function onMouseOut(d, i) {
        // use the text label class to remove label on mouseout
        d3.select(this).attr('class', 'bar');
        d3.select(this)
          .transition()     // adds animation
          .duration(400)
          .attr('width', x.bandwidth())
          .attr("y", function(d) { return y(d.points); })
          .attr("height", function(d) { return height - y(d.points); });

        d3.selectAll('.val')
          .remove()
    }

</script>

</body>
</html>
