<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "towel";
//if(!isset($_SESSION['username'])){
//    header('location:login.php');
//}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
echo 'hello '. $_SESSION['username']. '<br>';
$curuser=$_SESSION['username'];
$sql = "select teams.team,teams.TEAM_ID
        from teams
        inner join user_teams
        on user_teams.TEAM_ID=teams.TEAM_ID
        where USER_ID='$curuser'";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
    $stringTest = $row['team'];
    $id=$row['TEAM_ID'];
    echo "<div id='".$id."' onClick='reply_click(this.id)'>" .$stringTest ."</div>";
    echo '<br>';
}
?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
  function reply_click(clicked_id)
  {   
        //alert(clicked_id);
        //$.session.set("TEAM_ID", clicked_id);
        document.cookie = "TEAM_ID="+clicked_id;
        window.location.href = "viewteam.php";
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





