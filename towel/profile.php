<!DOCTYPE html>
<html lang="en">
<head>
  <title>Activity log</title>
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
      height: 400px;
      width: 90%;
      margin-left: 5%;
      display: inline-block;
      color: black;
    }

  .container {
    padding: 16px;
  }

  .h3, .h2 {
    font-family: Arial, Helvetica, sans-serif;
  }


  /* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  overflow: auto; /* Enable scroll if needed */
  background-color: white;
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  font-family: Montserrat, sans-serif;
}

.roundBtn{
  margin: auto;
    margin-top: 4% !important;
    margin-left: 90% !important;
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
    width: 50px;
    height: 50px;
    padding: 6px 0px;
    font-size: 15px;
    line-height: 1.42857;
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease 0s;
    float:left;

}
.roundBtn:hover{
  background-color: #e6d0f4;
}
/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
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
        <li><a class="active" href="#about">PROFILE</a></li>
        <li><a href="selectGroup.php">CHANGE GROUP</a></li>
        <li><a href="logout.php">LOGOUT</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="jumbotron text-center">
  <h1>YOUR PROFILE</h1>
</div>

<!-- PHP CODE FOR SELECTING INFO FROM DATABASE, NEED TO FINISH -->
<div class='transbox'>
  <div class='row'>
    <form action='logPage.php' method='post'>
    <div class='col-sm-2' style='width:40%; margin-right: 25px; float: right'>
      <h2>GROUP INFORMATION</h2>
      <?php
      session_start();
      $un = $_SESSION['userID'];
      $gn = $_SESSION['TEAM_ID'];
      include("../backEnd/functions.php");
      //$name = $_SESSION['username'];
      $details = takeGroupInfo($un, $gn);
      echo "<h3>Group name: ". $details[0] ."</h3>";
      echo "<h3>Teammates: </h3>";
      foreach ($details[1] as $users) {
        echo "<h3>- " .$users."</h3>";
      }
      //takeUserInfo($name);
      ?>
    </div>
  </form>

  <form action='logPost.php' method='POST'>
    <div class='col-sm-2' style='width:40%; display:inline-block; margin-left: 25px; float: left'>
      <h2>PERSONAL INFORMATION</h2>
      <p>
        <?php
        $un = $_SESSION['userID'];
        $gn = $_SESSION['TEAM_ID'];
        //$name = $_SESSION['username'];
        $details = takeUserInfo($un);
        echo "<h3>Name: ". $details[0]. "</h3>";
        echo "<h3>Surname: ". $details[1]. "</h3>";
        echo "<h3>Username: ". $details[2]. "</h3>";
        echo "<h3>Email: ". $details[3]. "</h3>";

        //takeUserInfo($name);
        ?>
      </p>
    </div>
  </form>
  </div>
</div>

<button class="roundBtn" id="myBtn"></button>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>TEAM Z1</p>
    <p>COMP10120 PROJECT</p>
    <p>Team members</p>
    <a href="https://www.instagram.com/dannydevito0/?hl=en">Finlay Hudson</a><br>
    <a href="https://instagram.com/therock?igshid=1eonwkh3w9xtl">Matei Stan</a><br>
    <a href="https://instagram.com/therock?igshid=1eonwkh3w9xtl">Jang Belche</a><br>
    <a href="https://twitter.com/stephenking">Daniel King</a><br>
    <a href="https://twitter.com/dariatvshow">Angela Popovska</a><br>
    <a href="https://twitter.com/taylorswift13">Greta Urkyte</a><br>
    <a href="https://twitter.com/nbchouse">Alexandra Has</a><br><br>

    <p>Sources:</p>
    <a href="https://codepen.io/smlo/pen/JdMOej">Codepen</a><br>
    <a href="https://codepen.io/augbog/pen/LEXZKK">Codepen</a><br>
    <a href="https://www.youtube.com/watch?v=oyhVv0s6M3I&t=2175s">Video</a><br>
    <a href="https://fullcalendar.io/">Calendar</a><br>
    <a href="https://www.w3schools.com/">W3schools</a><br>
    <a href="https://d3js.org/">D3js</a><br>
   

  </div>

</div>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</body>
</html>
