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
      height: 600px;
      width: 80%;
      background-color: #ffffff;
      border: 2px solid black;
      background: #FAEBD7
    }


  .container {
    padding: 16px;

    /*background-color: rgb(218, 143, 45);*/
  }

    .navbar {
    margin-bottom: 0;
    background-color: #e6ffff;
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
    color: #e6ffff !important;
    background-color: #000000 !important;
  }
  .navbar-default .navbar-toggle {
    border-color: transparent;
    color: #000000 !important;
  }
    .jumbotron {
    background-color: #e6ffff;
    color: #000000;
    padding: 100px 25px;
    font-family: Montserrat, sans-serif;
  }

</style>
</head>
<body>

<!--<div class="jumbotron text-center" style=' background-color: #e6ffff; height:10%; padding-bottom:20px; padding-top:20px'>
  <h2 style="font-family: Arial, Helvetica, sans-serif; text-align: left; padding-left: 20px">T-MANAGER</h2>
</div>
<div style='width:100%; height:100%; background-color: #b2ebf2; opacity: 0.8; display:inline-block'>
  <p>Your information: </p>
</div>-->
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
        <li><a href="#about">ACTIVITY LOG</a></li>
        <li><a href="#services">TASKS</a></li>
        <li><a href="#portfolio">MEETINGS</a></li>
        <li><a href="#pricing">PERFORMANCE</a></li>
      </ul>
    </div>
  </div>
</nav>

</body>
</html>
