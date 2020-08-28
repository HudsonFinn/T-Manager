<!DOCTYPE html>
<html>
<title> Task Page </title>
<head>
  <style>

div {
  display: inline-block;
  background-color: white;
  width: 170px;
  height: 170px;
  border: 2px solid black;
  padding: 50px;
  margin: 5px;
}
</style>

 <b>Current Tasks: </b>
 <br>
 <form class="" action="addTask.php" method="post">
 <button type="submit" name="button">Add task</button>
</form>
</head>
<body>
<br>
<br>

<?php
  include 'backEnd/connectDatabase.php';
  session_start();
  $name = " ";

  if(isset($_POST['taskName']) && isset($_POST['taskDescription'])){
    $name = $_POST['taskName'];
    $description =$_POST['taskDescription'];


    $check = "SELECT * FROM tasks WHERE name = '$name'";
    $result = mysqli_query($conn, $check);

    $count = mysqli_fetch_array($result, MYSQLI_NUM);
    if($count[0]>1){
      echo'<div2 style="color:red">Error: task already exists, not inserted<br> </div2>';

    }else{
      $sql = "INSERT INTO tasks (name, description, creator) VALUES ('$name','$description','JANGO')";

    if(!mysqli_query($conn, $sql)){
      echo 'Not inserted';


    }else{
      echo'<div2 style="color:green">Successfully inserted<br> </div2>';
    }
  }
}

  $sql = "SELECT * FROM tasks;" ;
  $result = mysqli_query($conn, $sql);
  $resultsCheck = mysqli_num_rows($result);
  if($resultsCheck > 0){
    $array1=array();
    $array2=array();
    $i=0;
    while ($row = mysqli_fetch_assoc($result)) {
      $taskName = $row['name'];
      $taskDesription = $row['description'];
      $taskCreator = "JANGO";
      //$file = 'task.php';
      //if(!is_file($file)){
      $content =  '<b>Task Name:</b><br>'. $taskName. '<br><br> <b>Description:</b><br>'. $taskDesription.'<br><br> <b>Creator: </b><br>'. $taskCreator .'</div>' ;
      if(is_null($row['userID'])){
        echo"<div><form action='TaskTest.php' method='POST'>
        <b>Task Name:</b><br> $taskName <br><br> <b>Description:</b><br> $taskDesription<br> <br>
        <input type='hidden' name='selectBtn' value='$taskName'>
        <input name='selectTask' value='select' type='submit'>

        </form></div>";
      }else{
        echo"<div><form action='TaskTest.php' method='POST'>
        <b>Task Name:</b><br> $taskName <br><br> <b>Description:</b><br> $taskDesription<br> <br>  <b>task selected by:</b><br> $row[userID]<br> <br>
        <input type='hidden' name='selectBtn' value='$taskName'>
        <input name='selectTask' value='select' type='submit'>

        </form></div>";
      }

      //$i+=1;

      //echo ("Name: "). $row['name'] . "<br>";
      //echo ("Descirption: ").$row['description'] . "<br>";
      // code...
    }


  }

  $sql = "SELECT * FROM tasks WHERE userID=2;" ;
  $result2 = mysqli_query($conn, $sql);
  $resultsCheck2 = mysqli_num_rows($result);
  if($resultsCheck2 > 0){
    $array1=array();
    $array2=array();
    $i=0;
    echo "<br> <br> <br> <b>Selected tasks from user 'userID=2': </b> <br>";
    while ($row = mysqli_fetch_assoc($result2)) {
      $taskName = $row['name'];
      $taskDesription = $row['description'];
      //$taskCreator = "JANGO";
      //$file = 'task.php';
      //if(!is_file($file)){
      //$content =  '<b>Task Name:</b><br>'. $taskName. '<br><br> <b>Description:</b><br>'. $taskDesription.'<br><br> <b>Creator: </b><br>'. $taskCreator .'</div>' ;

      echo"<div><form action='TaskTest.php' method='POST'>
      <b>Task Name:</b><br> $taskName <br><br> <b>Description:</b><br> $taskDesription<br> <br>
      <input type='hidden' name='removeBtn' value='$taskName'>
      <input name='removeTask' value='Remove task' type='submit'>

      </form></div>";
      //$i+=1;

      //echo ("Name: "). $row['name'] . "<br>";
      //echo ("Descirption: ").$row['description'] . "<br>";
      // code...
    }


  }


if(isset($_POST['selectTask'])){
  $newName = $_POST['selectBtn'];
  //echo $newName;
  echo("<meta http-equiv='refresh' content='1'>");
  $sql = "UPDATE tasks SET userID=2 WHERE name='$newName'";
  if(!mysqli_query($conn, $sql)){
    echo 'Not inserted';
  }else{
    echo'<div2 style="color:green">Successfully selected<br> </div2>';
  }
}

if(isset($_POST['removeTask'])){
  $newName = $_POST['removeBtn'];
  //echo $newName;
  echo("<meta http-equiv='refresh' content='1'>");
  $sql = "UPDATE tasks SET userID=null WHERE name='$newName'";
  if(!mysqli_query($conn, $sql)){
    echo 'Not inserted';
  }else{
    echo'<div2 style="color:green">Successfully selected<br> </div2>';
  }
}
?>

</body>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</html>
