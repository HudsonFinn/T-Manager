<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location:../LoginPage.php');
}
include('../connectDatabase.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title> Activity Log</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../../design_template.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!--      <link rel="stylesheet" type="text/css" href="css/styles.css"> -->


  <style>
  body{

    background: url("https://images.unsplash.com/photo-1570884745218-1275bb172d97?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1267&q=80") no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;

  }
  input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
  }
  .logs {                      /*transparent box for text*/
    margin-left: auto;
    margin-right: auto;
    height: 80vh;
    width: 90%;
    position: relative;
    background: #fef;
    border-radius: 10px;

    margin-left: 5%;
    margin-top:15vh;
    border: 0;
    padding-top:5vh;
    padding-left:5vw;
    display: inline-block;
    white-space: nowrap;
    overflow-y: scroll;
    opacity: 0.6;
    }
  .container {
    padding: 16px;

  }
    .navbar {
    z-index: 9999;
  }
  .feed .log a{
      color:#940c59;
      font-family: sans-serif;

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
        <li><a class="active" href="#about">ACTIVITY LOG</a></li>
        <li><a href="../viewtasks.php">TASKS</a></li>
        <li><a href="../../calendar-new/index.php">MEETINGS</a></li>
        <li><a href="../../Dan/performancePage.php">PERFORMANCE</a></li>
        <li><a href="../profile.php">PROFILE</a></li>
        <li><a href="../selectGroup.php">CHANGE GROUP</a></li>
        <li><a href="../logout.php">LOGOUT</a></li>
      </ul>
    </div>
  </div>
</nav>


  <div class="feed" id="please">
      <div class="logs"></div>
  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="js/log.js"></script>
  <script type="text/javascript">

          //many good neurons have died for this crap
          $('html, body, div').animate({ scrollTop: 100000 }, 'fast');
  </script>
</body>
</html>
