<html>
    <head>
    <title>View task</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../design_template.css">
    <link rel="stylesheet" href="fabstyle.css">



    <style>
      .big_box{
        text-align:center;
        font-family: Montserrat, sans-serif;
        background-color:#e6ffff;
        padding-top: 105px;
        padding-bottom: 70px;
        position: ;
        left: 0%;
        right: 0%;
        position: fixed;
        z-index: 1;
        margin-top: auto;
      }

      .description
      {
        text-align: center;
        margin-top: 20%;

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
              <li><a href="logpage/viewlog.php">ACTIVITY LOG</a></li>
              <li><a href="viewtasks.php">TASKS</a></li>
              <li><a href="calendar.html">MEETINGS</a></li>
              <li><a href="performance.php">PERFORMANCE</a></li>
              <li><a href="profile.php">PROFILE</a></li>
            </ul>
          </div>
        </div>

      </nav>


      <?php
          session_start();
          include("connectDatabase.php");
          $user=$_SESSION['username'];
          $team=$_SESSION['TEAM_ID'];
          $task = $_COOKIE['TASK_ID'];
          //echo $task;
          $sql="select * from tasks where TASK_ID='$task'";
          $result=mysqli_query($conn,$sql);
          $row=mysqli_fetch_assoc($result);
          $count=mysqli_num_rows($result);

          echo $row['name']. "</div>";

          echo "<div class='description'>" .$row['USER_ID']. " is responsible for ".$row['name']. "</div>";


          $i=$row["points"];
          if($i<=25){
              echo "<div class='description' style='color:green;'>SUPER EASY</div>";
          }
          else if($i<=50){
              echo "<div class='description' style='color:yellow;'>EASY</div>";
          }
          else if($i<=75){
              echo "<div class='description' style='color:orange;'>DIFFICULT</div>";
          }
          else if($i<=100){
              echo "<div class='description' style='color:red;'>SUPER DIFFICULT</div>";
          }
          if($user==$row['USER_ID']){
              echo "<button onClick=\"setParent()\">Create subtask</button>";
          }


      ?>

    <div class="big_box">
    <!--    <a href='logout.php'>Logout</a> -->
    <form action="viewteam.php" method='post'>
    <button type='submit' class=''>Back to team</button>
    </form>
    <button  onClick="updates()">
    <?php
        if($user==$row['USER_ID']){
            echo "Create updates";
        }
        else{
            echo "View updates";
        }
        ?></button>
    <button onClick="subs(this.id)" style="margin-top:10%;">View subtasks</button>
        <script type="text/javascript">
                function setParent()
                    {
                    document.cookie = "parent="+"<?php echo $task?>";
                    window.location.href = "createsub.php";
                    }
                function subs()
                    {
                    //alert(clicked_id);

                    document.cookie = "parent="+"<?php echo $task?>";
                    window.location.href = "viewsubs.php";
                    }
            function updates()
                    {
                    //alert(clicked_id);

                    document.cookie = "chatplace="+"<?php echo $task?>";
                    window.location.href = "chat/viewupdates.php";
                    }
        </script>
    </div>

    </body>
</html>
