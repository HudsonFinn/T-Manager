<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location:../LoginPage.php');
}
include('../connectDatabase.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Activity Log</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <div class="feed" id="please">
            <div class="logs"></div> 
        </div>
        
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        
        <script src="js/log.js"></script>
        
        <script type="text/javascript">
            
                //many good neurons have died for this crap
                $('html, body,div').animate({ scrollTop: 100000 }, 'fast');
        </script>
    </body>
</html>
