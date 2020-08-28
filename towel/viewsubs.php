<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "towel";
include("connectDatabase.php");
//$conn = new mysqli($servername, $username, $password, $dbname);
$user=$_SESSION['username'];
$team=$_SESSION['TEAM_ID'];
$parent=$_COOKIE['parent'];
$sql = "select *
        from subtasks
        where parent='$parent'";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
    $stringTest = $row['name'];
    $id=$row['SUB_ID'];
    echo "<div id='".$id."' onClick='reply_click(this.id)'>".$stringTest."</div>";
    echo '<br>';
}
?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
  function reply_click(clicked_id)
  {
        //alert(clicked_id);
        //$.session.set("TEAM_ID", clicked_id);
        document.cookie = "SUB_ID="+clicked_id;
        window.location.href = "viewsub.php";
  }
</script>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<?php


$conn->close();
?>
