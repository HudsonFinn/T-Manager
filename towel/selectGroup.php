<!DOCTYPE html>
<html lang="en">
<head>
  <title>The Hive</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../design_template.css">

  <style>
  body
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
</head>
<body>

<div class="jumbotron">
  <h1>GROUP SELECTION</h1>
  <p>WORK WITH ONE OF YOUR TEAMS OR CREATE A NEW ONE</p>
</div>
<?php
  session_start();
  if (!isset($_SESSION['userID'])) {
    header('location:LoginPage');
  }
  $userID = $_SESSION['userID'];
  if (!isset($_POST['groupID'])) {
    displayTeams($userID);
  } else {
    $_SESSION['username'] = $_SESSION['userID'];
    $_SESSION['TEAM_ID'] = $_POST['groupID'];
    $_COOKIE['TEAM_ID']= $_POST['groupID'];
    echo '<script>
      window.location.replace("viewteam.php");
    </script>';
  }

  function displayTeams($userID) {
    include("../backEnd/connectDatabase.php");
    $groups = array();
    $sql = "SELECT * FROM user_teams WHERE USER_ID = '$userID'";
    if (!($result = $conn->query($sql)))
      echo ("Error: " . $conn->error);
    while ($row = $result->fetch_assoc()) {
      array_push($groups, $row['TEAM_ID']);
    }

    foreach ($groups as $groupID) {
      $sql = "SELECT * FROM teams WHERE TEAM_ID = '$groupID'";
      if (!($result = $conn->query($sql)))
        echo ("Error: " . $conn->error);
      while ($row = $result->fetch_assoc()) {
        $group = $row['team'];
        echo("<form action='$_SERVER[PHP_SELF]' method='POST'>
                  <input class='btn-round' type='submit' value=$group></td>
                  <input type='hidden' name = 'groupID' value = '$groupID'>
              </form>");
      }
    }
    echo("<form action='joinGroup.php' method='POST'>
            <input class='btn-round' type='submit' style='font-size: 120px; background-color: #69608A;' value='＋'>
          </form>");
  }
?>

</body>
</html>
