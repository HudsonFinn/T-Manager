<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location:login.php');
}
?>
<html>
    <head>
    <title>Home page</title>
        
    </head>
    <body>
        <a href='logout.php'>Logout</a>
    <h1>welcome <?php echo $_SESSION['username'];?></h1>
    <form action="viewteams.php" method='post'>
    
    <button type='submit' class=''>View teams</button>
    </form>
    <form action="addteam.php" method="post">
    <input type="pass" name="teamadd" class="form-control" required>
    <button type='submit' class=''>Add team</button>
    </form>
    <form action="jointeam.php" method="post">
    <input type="pass" name="teamjoin" class="form-control" required>
    <button type='submit' class=''>Join team</button>
    </form>
        
    </body>
</html>