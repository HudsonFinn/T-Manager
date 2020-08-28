<!DOCTYPE html>
<html lang="en">
<head>
  <title>Activity log</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <style>
    body {font-family: Arial, Helvetica, sans-serif;
      background-image: url('ducs.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover;}

  input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
  }
  .transbox {                      /*transparent box for text*/
      margin-left: auto;
      margin-right: auto;
      height: 300px;
      width: 90%;
      position: relative;
      background: rgba(204, 204, 204, 0.6);
      margin-left: 5%;
      display: inline-block;
      white-space: nowrap;
      overflow: hidden;
    }

  button {
    background-color:#b2ebf2;
    color: black;
    padding: 14px 20px;
    margin: 8px 0;
    border: 1px solid rgba(0,0,0,0.5);
    cursor: pointer;
    width: 100%;
  }
  button:hover {
    opacity: 0.8;
    background-color: #EABFB9
  }
  .container {
    padding: 16px;

    /*background-color: rgb(218, 143, 45);*/
  }
    .navbar {
    margin-bottom: 0;
    background-color: #e6ffff ;
    z-index: 9999;
    border: 0;
    font-size: 12px !important;
    line-height: 1.42857143 !important;
    letter-spacing: 4px;
    border-radius: 0;
    font-family: Montserrat, sans-serif;
  }
  .navbar li a, .navbar .navbar-brand {
    color: #000000 !important;
  }
  .navbar-nav li a:hover, .navbar-nav li.active a {
    color: #e6ffff  !important;
    background-color: #000000 !important;
  }
  .navbar-default .navbar-toggle {
    border-color: transparent;
    color: #000000 !important;
  }
    .jumbotron {
    background-color: #e6ffff ;
    color: #000000;
    padding: 100px 25px;
    font-family: Montserrat, sans-serif;
  }
  #second {

  }

</style>
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
        <li><a href="logPage.php">ACTIVITY LOG</a></li>
        <li><a href="tasks.php">TASKS</a></li>
        <li><a href="meetings.php">MEETINGS</a></li>
        <li><a href="perf.php">PERFORMANCE</a></li>
        <li><a href="profile.php">PROFILE</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="jumbotron text-center">
  <h1>T-MANAGER</h1>
  <p>We specialize in team management, improvement and analysis of performance</p>
</div>

<?php
include("backEnd/connectDatabase.php");
$result = mysqli_query($conn, "SELECT * FROM users, groups");
?>
<!-- PHP CODE FOR SELECTING INFO FROM DATABASE, NEED TO FINISH -->
<div class='transbox'>
  <div class='row'>
    <form action='logPage.php' method='post'>
    <div class='col-sm-2' style='width:40%; margin-right: 25px; float: right'>
      <h3>GROUP INFORMATION</h3>
    </div>
  </form>

  <form action='logPost.php' method='POST'>
    <div class='col-sm-2' style='width:40%; display:inline-block; margin-left: 25px; float: left'>
      <h3>PERSONAL INFORMATION</h3>
    </div>
  </form>
</div>
</div>
</body>
</html>
