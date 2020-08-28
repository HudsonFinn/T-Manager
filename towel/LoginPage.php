<!DOCTYPE html>
<html lang="en">
<head>
  <title>register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <style>
    body {font-family: Arial, Helvetica, sans-serif;
      background-image: url("https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80");
      /* Photo by Perry Grone on Unsplash*/
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
    /*  background: #a78db8; */
    }

  button {
    background-color:#a78db8;
    color: black;
    padding: 14px 20px;
    margin: 8px 0;
    border: 1px solid rgba(0,0,0,0.5);
    cursor: pointer;
    width: 100%;
  }
  button:hover {
    opacity: 0.8;
    background-color: #a78db8;
  }
  .container {
    padding: 16px;

    /*background-color: rgb(218, 143, 45);*/
  }
  .jumbotron{
    background-color: #a78db8;
    height:10%; 
    padding-bottom:15px; 
    padding-top:15px;
    box-shadow: 5px 10px 20px #000000;
  }
  .text-center{
    font-family: Montserrat, sans-serif;
    letter-spacing: -2px;
    text-align: center;
  }

</style>
</head>
<body>

<div class="jumbotron">
  <h1 class="text-center">WELCOME</h1>
  <p class="text-center">TO T-MANAGER</p>
</div>
<?php
  session_start();
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
    if ($error == 'unavaliable') {
      $registerError = 'Sorry that username is unavaliable!';
      $loginError = '';
    } elseif ($error == 'incorrect') {
      $loginError = 'Login incorrect please try again!';
      $registerError = '';
    } else {
      $loginError = '';
      $registerError = '';
  }
  $form = ("
  <div class='container'>
    <div class='row'>
      <form action='LoginPage.php' method='post'>
      <div class='col-sm-2' style='width:40%; background-color: #e6d0f4; opacity: 0.8; display:inline-block; border: 3px solid rgba(0,0,0,0.5); margin-right: 25px; float: right'>
        <h3>ALREADY A MEMBER?</h3>
        <p>$loginError</p>
        <input type='hidden' name = 'func' value = 'login'>
        <label for='uname'><b>Username</b></label>
        <input type='text' placeholder='Enter Username' name='uname' required>
        <label for='psw'><b>Password</b></label>
        <input type='password' placeholder='Enter Password' name='psw' required>
        <button type='submit'>Login</button>
      </div>
    </form>

    <form action='LoginPage.php' method='POST'>
      <div class='col-sm-2' style='width:40%; display:inline-block; background-color: #e6d0f4; border: 3px solid rgba(0,0,0,0.5); opacity: 0.8; margin-left: 25px; float: left'>
        <h3>NEW MEMBER?</h3>
        <p>$registerError</p>
        <label for='uname'><b>Username</b></label>
        <input type='text' placeholder='Enter Username' name='uname' required>
        <label for='name'><b>Name</b></label>
        <input type='text' placeholder='Enter Name' name='name' required>
        <label for='surn'><b>Surname</b></label>
        <input type='text' placeholder='Enter surname' name='surn' required>
        <label for='psw'><b>Password</b></label>
        <input type='password' placeholder='Enter Password' name='psw' required>
        <label for='email'><b>Email</b></label>
        <input type='text' placeholder='Enter Email' name='email' required>
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
    $fname = $_POST['name'];
    $lname = $_POST['surn'];
    $email = $_POST['email'];
    $user = addUser($un, $pw, $fname, $lname, $email);
    if (!$user) {
      getInput('unavaliable');
    } else {
      $_SESSION['userID'] = $user;
      echo '<script>
        window.location.replace("groupRedirection.php");
      </script>';
    }
  }

  function proccessLogin() {
    echo('login');
    include("../backEnd/functions.php");
    $un = $_POST['uname'];
    $pw = $_POST['psw'];
    $user = checkUser($un, $pw);
    if (!$user) {
      getInput('incorrect');
    } else {
      $_SESSION['userID'] = $user;
      echo '<script>
            window.location.replace("groupRedirection.php");
      </script>';
    }
    echo('user:' . $user);
  }
?>

</body>
</html>
