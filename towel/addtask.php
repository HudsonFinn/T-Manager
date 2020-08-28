
<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location:login.php');
}
?>
<html>
    <head>
    <title>Add task</title>
        
    </head>
    <body>
        <a href='logout.php'>Logout</a>
    <h1>yello <?php echo $_SESSION['username'] ." in ".$_SESSION['TEAM_ID'];?></h1>
    <form action="createbuffer.php" method="post">
    <input type="pass" name="taskname" class="form-control" required>
    <button type='submit' class=''>Propose task</button>
    </form>
        
    </body>
</html>