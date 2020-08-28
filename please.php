<!DOCTYPE html>
<html>
<body>
  <h1>PLEASE</h1>
  <?php
  include("backEnd/connectDatabase.php");
  $name=$_GET['userName'];
  $sql="select * from users where userName='$name'";
  $result=mysqli_query($conn,$sql);

  while($row=mysqli_fetch_assoc($result)){
    echo $row['firstName'];
  }
  ?>
</body>
</html>
