<!DOCTYPE html>
<html lang="en">
<head>
  <title>The Hive</title>
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

<div class="jumbotron text-center" style=' background-color: #4dd0e1; height:10%; padding-bottom:10px; padding-top:10px'>
  <h2>GROUP REGISTRATION</h2>
  <!--<p style="font-family: Arial, Helvetica, sans-serif;">TO T-MANAGER</p>-->
</div>
<?php
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
    } elseif ($error == 'incorrect') {
      $loginError = 'Login incorrect please try again!';
    } else {
      $loginError = '';
      $registerError = '';
    }

    $form = ("
    <div class='container'>
      <div class='row'>
        <form action='Landing_page.php' method='post'>
        <div class='col-sm-2' style='width:40%; background-color: #b2ebf2; opacity: 0.8; display:inline-block; border: 3px solid rgba(0,0,0,0.5); margin-right: 25px; float: right'>
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

      <form action='Landing_page.php' method='POST'>
        <div class='col-sm-2' style='width:40%; display:inline-block; background-color: #b2ebf2; border: 3px solid rgba(0,0,0,0.5); opacity: 0.8; margin-left: 25px; float: left'>
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
          <input type='hidden' name = 'func' value = 'register'>
          <button type='submit'>Login</button>
        </div>
      </form>
      </div>
    </div>");
    echo($form);
  }

  function proccessRegister() {
    include("functions.php");
    echo('register');
    $un = $_POST['uname'];
    $pw = $_POST['psw'];
    $user = addUser($un, $pw);
    if (!$user) {
      getInput('unavaliable');
    }
    else
    {
      echo '<script>
        window.location.replace("page2.php");
      </script>';
    }

  }

  function proccessLogin() {
    echo('login');
    include("functions.php");
    $un = $_POST['uname'];
    $pw = $_POST['psw'];
    $user = checkUser($un, $pw);
    if (!$user) {
      getInput('incorrect');
    }
    else
    {
      echo '<script>
        window.location.replace("page2.php");
      </script>';
    }

    echo('user:' . $user);
  }
?>

</body>
</html>