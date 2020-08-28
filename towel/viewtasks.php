<?php
session_start();
include("connectDatabase.php");
$curuser=$_SESSION['username'];
$team=$_SESSION['TEAM_ID'];
$sql = "select *
        from tasks
        where TEAM_ID='$team'";
$result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="fabstyle.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
 <link rel="stylesheet" href="style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>
  <link rel="stylesheet" href="../design_template.css">
<style>
body{
  overflow-x: hidden;
  overflow-y: scroll;
}
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
  border-radius: 10px;
  opacity: 0.9;
}
.grid-item {
  background-color: #e6d0f4;
  box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.3);
  margin-left: 5%;
  margin-right: 5%;
  margin-bottom: 2%;
  padding: 20px;
  font-size: 30px;
  text-align: center;
  border-radius: 10px
}
.grid-item button:hover {
  opacity: 0.6;
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
  width:100%;
  height:100%;
  text-align: center;
  margin-left: 34%;
  border-radius: 10px;

  padding-top: 50px;
  padding-bottom: 0px;

}
.btn-group button {
  background-color: #917B93 !important; /* Green background */
  border-style: dotted;
   border-color: purple;
  border-radius: 10px;
  box-shadow: 0px 15px 18px rgba(255, 255, 255, 0.1);
  margin-top: 10vh;
  color: black; /* White text */

  cursor: pointer; /* Pointer/hand icon */
  float: left; /* Float the buttons side by side */

}



.btn-group button:not(:last-child) {
  border-right: none; /* Prevent double borders */
  border-radius: 10px;


}

/* Clear floats (clearfix hack) */
.btn-group:after {
  content: "";
  clear: both;
  display: table;
  border-radius: 15px;

}

/* Add a background color on hover */
.btn-group button:hover {
  background-color: black;
  color: black;
  opacity: 0.6;
  border-radius: 15px;
}

</style>
<script>
function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function submitForm()
{
  var dayValue = document.getElementById("daypick").value;
  var monthValue = document.getElementById("monthpick").value;
  var yearValue = document.getElementById("yearpick").value;
  if ((!isNumeric(dayValue)) || !(isNumeric(monthValue)) || !(isNumeric(yearValue))) {
    document.getElementById("ErrorMessage").innerHTML = "Invalid Date";
 } else {
   dayValue = parseInt(dayValue);
   monthValue = parseInt(monthValue);
   yearValue = parseInt(yearValue);
   if(dayValue < 1 || dayValue > 31) {
     document.getElementById("ErrorMessage").innerHTML = "Invalid Date - DAY";
     return(0);
   }
   if(monthValue < 1 || monthValue > 12) {
     document.getElementById("ErrorMessage").innerHTML = "Invalid Date - Month";
     return(0);
   }
   if(yearValue < 1902 || yearValue > 2100) {
     document.getElementById("ErrorMessage").innerHTML = "Invalid Date - Year";
     return(0);
   }
   document.getElementById("ErrorMessage").innerHTML = "";
   document.forms["newTaskForm"].submit();
 }
}

function getMyTasks() {
  $.ajax({
   url:"ajaxGetTasks.php",
   type:"POST",
   data:{},
   success:function(error) {
     var splitreturn = error.split("*");
     document.getElementById("task-container").innerHTML = "<h2>In progress: </h2><br><h2>    </h2>" + splitreturn[0];
     document.getElementById("finnished-task-container").innerHTML = "<h2>Finnished: </h2><br><h2>    </h2>" + splitreturn[1];
   }
})
}
function getOurTasks() {
  $.ajax({
   url:"ajaxGetTasksGroups.php",
   type:"POST",
   data:{},
   success:function(error) {
     var splitreturn = error.split("*");
     document.getElementById("task-container").innerHTML = "<h2>In progress: </h2><br><h2>    </h2>" + splitreturn[0];
     document.getElementById("finnished-task-container").innerHTML = "<h2>Finnished: </h2><br><h2>    </h2>" + splitreturn[1];
   }
})
}
</script>
</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand">T-MANAGER</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logpage/viewlog.php">ACTIVITY LOG</a></li>
        <li><a class="active" href="#about">TASKS</a></li>
        <li><a href="../calendar-new/index.php">MEETINGS</a></li>
        <li><a href="../Dan/performancePage.php">PERFORMANCE</a></li>
        <li><a href="profile.php">PROFILE</a></li>
        <li><a href="selectGroup.php">CHANGE GROUP</a></li>
        <li><a href="logout.php">LOGOUT</a></li>
      </ul>
  </div>
</nav>

<div class="fab span4 proj-div" style = "margin-bottom: 2%; margin-left: 90vw"data-toggle="modal" data-target="#GSCCModal">
  <span class="fab-action-button">
        <i class="fab-action-button__icon"></i>
    </span>
</div>
    

<div id="GSCCModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
 <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 style="color:black"><span style="font-family: Montserrat, sans-serif; text-transform: uppercase; font-weight: lighter; letter-spacing: -2px;">&#9745;</span> New task</h4>
      </div>
      <div class = "task_form">
          <form id = "newTaskForm" action="createbuffer.php" method="post">
           <label for="taskName" style="font-family: Montserrat, sans-serif; margin-top:5%; text-transform: uppercase; font-weight: lighter; letter-spacing: -1px;">Task Name:</label><br>
           <input type="text" id="taskName" name="taskname"><br>
            <label for="datepicker" style="font-family: Montserrat, sans-serif; margin-top:5%; text-transform: uppercase; font-weight: lighter; letter-spacing: -1px;">Deadline:</label><br>
            <label id = "ErrorMessage" for="datepicker" style="font-family: Montserrat, sans-serif; margin-top:5%; text-transform: uppercase; font-weight: lighter; letter-spacing: -1px;"></label><br>
            <div>
            <input type="text" id="daypick" name="day" maxlength="2" placeholder="dd" size="2" style="width: 30% !important;">
            <input type="text" id="monthpick" name="month" maxlength="2" placeholder="mm" size="2" style="width: 30% !important;">
            <input type="text" id="yearpick" name="year" maxlength="4" placeholder="yyyy" size="4"style="width: 30% !important;">
            </div>

           <label for="taskDesc" style="font-family: Montserrat, sans-serif; margin-top:5%; text-transform: uppercase; font-weight: lighter; letter-spacing: -1px;">Task Description:</label><br>

            <input type="text" id="taskDesc" name="taskdesc" rows="10"><br>
           <button type="button" onclick = "submitForm()" class="btn-circle">Submit</button>
         </form>
       </div>
    </div>
  </div>
</div>
<div class="btn-group" >
  <button id="my-tasks" style='width:15.3%; margin-right: 1%; color:#1b0d24;font-size: 20px; font-family: "Arial", Times, serif' onclick="getMyTasks()">My tasks</button>
  &nbsp
  <button id="all-tasks" style="width:15.3%; color:#1b0d24;font-size: 20px; font-family: "Arial", Times, serif" onclick="getOurTasks()">Group tasks</button>
</div>
<div id="task-container" class="grid-container">
<h2>In progress: </h2>
<br>
<h2>    </h2>
<script>
getOurTasks();
</script>

<script type="text/javascript">
  function reply_click(clicked_id)
  {
        //alert(clicked_id);
        //$.session.set("TEAM_ID", clicked_id);
        document.cookie = "TASK_ID="+clicked_id;
        document.cookie = "chatplace="+clicked_id;
        window.location.href = "newtaskpage/viewtask.php";
  }
</script>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

</div >
<div id="finnished-task-container" class="grid-container">
<h2>Finished: </h2>
<br>
<h2>    </h2>
<script>
getOurTasks();

</script>
?>

</div>
</body>
</html>
