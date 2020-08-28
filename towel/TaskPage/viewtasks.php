<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location:../login.php');
}
include('../connectDatabase.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Task Page</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="js/tasks.js"></script>
    </body>
</html>