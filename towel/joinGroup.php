<!DOCTYPE html>
<html lang="en">
<head>
  <title>The Hive</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <style>
    body {font-family: Monserrat, sans-serif;
      background-image: url('https://images.unsplash.com/photo-1570884745218-1275bb172d97?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1267&q=80');
      /* Photo by Nathan Queloz on Unsplash */
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

</style>
</head>
<body>

<div class="jumbotron text-center" style=' background-color: #e6ffff; padding-top: 15px; padding-bottom: 15px'>
  <h1>GROUP REGISTRATION</h1>
  <p style="font-family: Monserrat, sans-serif;">CREATE OR JOIN A TEAM</p>
</div>
<?php
  session_start();
  if (!isset($_SESSION['userID'])) {
    header('location:LoginPage');
  }
  if (!isset($_POST['func'])) {
      getInput('');
  } else {
    if ($_POST['func'] == 'login') {
      echo('login');
      proccessLogin();
    } else {
      echo('register');
      proccessRegister();
    }
  }
  function getInput($error) {
    $loginError = '';
    $registerError = '';
    if ($error == 'unavaliable') {
      $registerError = 'Sorry that group name is unavaliable!';
    } elseif ($error == 'incorrect') {
      $loginError = 'Incorrect login/Already in team!';
    }


    $form = ("
    <div class='container' style='padding-top: 40px'>
      <div class='row'>
        <form action='joinGroup.php' method='post'>
        <div class='col-sm-2' style='width:40%; background-color: #b2ebf2; opacity: 0.8; display:inline-block; border: 3px solid rgba(0,0,0,0.5); margin-right: 25px; float: right'>
          <h3>JOIN A GROUP</h3>
          <p>$loginError</p>
          <input type='hidden' name = 'func' value = 'login'>
          <label for='name'><b>Team Name</b></label>
          <input type='text' placeholder='Enter the name' name='uname' required>
          <label for='psw'><b>Password</b></label>
          <input type='password' placeholder='Enter Password' name='psw' required>
          <button type='submit'>Login</button>
        </div>
      </form>

      <form action='joinGroup.php' method='POST'>
        <div class='col-sm-2' style='width:40%; display:inline-block; background-color: #b2ebf2; border: 3px solid rgba(0,0,0,0.5); opacity: 0.8; margin-left: 25px; float: left'>
          <h3>CREATE A GROUP</h3>
          <p>$registerError</p>
          <label for='name'><b>Team Name</b></label>
          <input type='text' placeholder='Enter Name' name='uname' required>
          <label for='psw'><b>Password</b></label>
          <input type='password' placeholder='Enter Password' name='psw' required>
          <input type='hidden' name = 'func' value = 'register'>
          <button type='submit'>Login</button>
        </div>
      </form>
      </div>
    </div>");
    echo($form);
  }

  function proccessRegister() {
    include("../backEnd/functions.php");
    echo('register');
    $un = $_POST['uname'];
    $pw = $_POST['psw'];
    $groupID = addTeam($un, $pw, $_SESSION['userID']);
    if (!$groupID) {
      getInput('unavaliable');
    } else {
      echo '<script>
        window.location.replace("selectGroup.php");
      </script>';
    }

  }

  function proccessLogin() {
    echo('login');
    include("../backend/functions.php");
    $un = $_POST['uname'];
    $pw = $_POST['psw'];
    $user = joinTeam($un, $pw, $_SESSION['userID']);
    if (!$user) {
      getInput('incorrect');
    } else {
      echo '<script>
        window.location.replace("selectGroup.php");
      </script>';
    }

    echo('user:' . $user);
  }
?>

</body>
</html>
