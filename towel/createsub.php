<!DOCTYPE html>
<html lang="en">
<head>
  <title>Subtasks</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../design_template.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <style>

  body{
    background-image: url("https://images.unsplash.com/photo-1570884745218-1275bb172d97?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1267&q=80");
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
      margin-top: 5%;
      height: 89vh;
      width: 90%;
      margin-left: 5%;
      display: inline-block;
      color: black;
      font-family: Montserrat, sans-serif;
      text-align: center;
      padding-top: 5%;
    }

  .container {
    padding: 16px;
  }
  button {
    width: 20%;
  }

  .col-75 {
    /*padding: 12px 20px;

    border: 2px solid #ccc;
    border-radius: 4px;
    background-color: #f8f8f8;*/
    box-sizing: border-box;
    font-size: 16px;
    resize: none;
    margin-top: 6px;
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
          <li><a href="viewtasks.php">TASKS</a></li>
          <li><a href="../calendar-new/index.php">MEETINGS</a></li>
          <li><a href="../Dan/performancePage.php">PERFORMANCE</a></li>
          <li><a href="profile.php">PROFILE</a></li>
          <li><a href="logout.php">LOGOUT</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <?php
  session_start();
  if(!isset($_SESSION['username'])){
      header('location:login.php');
  }
  ?>
  <!--<a href='logout.php'>Logout</a>-->
  <div class='transbox'>
    <h3>create a substask in  <?php echo " ".$_COOKIE['parent'];?></h3>
    <form action="insertsub.php" method="post">
      <div class="col-75">
        <textarea rows="5" cols="120" type="pass" name="subname" required></textarea>
      <!--class="form-control" in textarea-->
      </div>
      <button type='submit' class=''>Create subtask</button>
    </form>
  </div>

  </body>
</html>
