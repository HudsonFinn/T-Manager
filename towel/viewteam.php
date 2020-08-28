<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location:login.php');
}
else{
    header('location:logpage/viewlog.php');
}
include('../backEnd/connectDatabase.php');
?>
<html>
    <head>
    <title>Task page</title>
    </head>
    <body>
        <a href='logout.php'>Logout</a>
    <h1>welcome <?php echo $_SESSION['username'];?></h1>
    <?php
        $team=$_SESSION['TEAM_ID'];
        $user=$_SESSION['username'];
        $sql="select * from teams where TEAM_ID='$team'";
        $result=mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($result);
        $t_name=$row['team'];
        echo '<h1>'. $t_name. '</h1>';

    ?>
    <form action="viewtasks.php" method='post'>
        <button type='submit' class=''>View tasks</button>
    </form>
    <form action="addtask.php" method="post">
        <button type='submit' class=''>Add task</button>
    </form>
    <form action="logpage/viewlog.php" method="post">
        <button type='submit' class=''>View log</button>
    </form>
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
    </body>

</html>
