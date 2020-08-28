<!DOCTYPE html>
<html lang="en">
<head>
  <title>Activity log</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="design_template.css">

  <style>

  body{
    background: url('ducs.jpg');
  }
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
      border: 0;
      display: inline-block;
      white-space: nowrap;
      overflow: hidden;
    }

  .container {
    padding: 16px;

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
        <li><a href="logpage/viewlog.php">ACTIVITY LOG</a></li>
        <li><a href="viewtask.php">TASKS</a></li>
        <li><a href="calendar.html">MEETINGS</a></li>
        <li><a href="performance.php">PERFORMANCE</a></li>
        <li><a href="profile.php">PROFILE</a></li>
      </ul>
    </div>
  </div>
  <div class="jumbotron text-center">
  <h1>YOUR PROFILE</h1>
</div>
</nav>



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
      <p>
        <?php
        session_start();
        $un = $_SESSION['userID'];
        include("../backEnd/functions.php");
        //$name = $_SESSION['username'];
        $name = takeUserInfo($un);
        echo($name);


        //takeUserInfo($name);
        ?>
      </p>
    </div>
  </form>
  </div>
</div>
</body>
</html>
