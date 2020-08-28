<?php
session_start();
include("../connectDatabase.php");
$user=$_SESSION['username'];
//$sub=$_COOKIE['SUB_ID'];
//$u=uniqid("HELPER_",true);
//$s="INSERT INTO user_subs(USER_SUBS_ID, SUB_ID,USER_ID)
//    VALUES ('".$u."','" .$sub. "','".$user."')";
//echo $s;

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Updates</title>
        <link rel="stylesheet" type="text/css" href="../../design_template.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">


        <style>
        html {
          height: 100%;
        }
        body {
          /* background-color: #ffe0fd; */
          background-image: linear-gradient(to bottom right, rgba(149, 0, 186,0.9), rgba(255, 0, 0,0.3));
          scrollbar-color: red yellow;
          }
          ::-webkit-scrollbar {
            width: 0px;
          }
        .messages{
          background-color:#FFCFCF;
           opacity: 0.6;
           border:1px solid #fff;
          border-radius: 5px;
           width:1000px;
           height:300px;
           padding:10px;
           overflow-y: scroll;
           scrollbar-color: red yellow;

       }


      .entry{
         opacity: 0.9;
          border-radius: 10px;
          background-color: #FFCFCF;
          border:1px solid #fff;
           width: 800px;
           height:50px;
           padding: 5px;
           margin-top: 50px;
           font: 1em Aria;
       }
       .chat .message a{
           color:#620399;
       }
       .chat .message p{
           margin: 10px 0;
       }
       .pad {

         padding: 115px 50px 25px;

        }
        .intext{
          padding: 5px;
           opacity: 1;
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
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">T-MANAGER</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="../logpage/viewlog.php">ACTIVITY LOG</a></li>
              <li><a href="../viewtasks.php">TASKS</a></li>
              <li><a href="../calendar.html">MEETINGS</a></li>
              <li><a href="../performance.php">PERFORMANCE</a></li>
              <li><a href="../profile.php">PROFILE</a></li>
            </ul>
          </div>
        </div>

      </nav>
      <header>
      <h1>
        <center><div class="pad"><font  size="+10" color="#f6dba4">
          Chat Updates</font></center></div>
      </h1>
      </header>
        <div class="chat">
            <center><div class="messages"></div></center>
            <?php
                $place=$_COOKIE["chatplace"];
                $sql="select * from user_subs where USER_ID='$user' and SUB_ID='$place'";
                $a=mysqli_query($conn,$sql);
                $sql="select * from tasks where USER_ID='$user' and TASK_ID='$place'";
                $b=mysqli_query($conn,$sql);
                if(mysqli_num_rows($a) !=0 or mysqli_num_rows($b) !=0 ){
                    echo "<center><textarea class=\"entry\" placeholder=\"Type here...\"></textarea></center>";
                }
            ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="js/chat2.js"></script>
        <script>
         $('html, body,div').animate({ scrollTop: 100000 }, 'fast');
        </script>
    </body>
</html>
