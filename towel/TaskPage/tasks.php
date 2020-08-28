<!DOCTYPE html>
<html>
<head>
<title>Tasks</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="design_template.css">

<style>
  .task
  {
    background-color: #e6ffff;
    display: inline-block;
    color: black;
    margin-top: 10%;
    margin-left: 10%;
    padding: 20px;
    font-family: Montserrat, sans-serif;
    height: 400px;
    width: 400px;
  }
  .modal-header, h4, .close {
    background-color: #e6ffff;
    color:black !important;
    text-align: center;
    font-size: 30px;
  }
  .modal-footer {
    background-color: #e6ffff;
  }

  .task_form{
    margin-left: 30%;
  }
  .button
  {
    background-color: #e6ffff;
    color: black;
    text-align: center;
    font-family: Montserrat, sans-serif;
    cursor: pointer;
    margin-top: 10%;
    transition: 0.3s;
    border: none;
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 15px;
    padding-right: 15px;
    height: 38px;
    width: 50px;
  }
.button:hover {
  background-color: black;
  color: #e6ffff;
  border: none;
  padding-top: 8px;
  padding-bottom: 8px;
  padding-left: 15px;
  padding-right: 15px;
  height: 38px;
  width: 50px;
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
          <li><a href="#about">ACTIVITY LOG</a></li>
          <li><a class="active" href="#tasks">TASKS</a></li>
          <li><a href="../calendar.html">MEETINGS</a></li>
          <li><a href="../Dan/performancePage.php">PERFORMANCE</a></li>
          <li><a href="../profile.php">PROFILE</a></li>
        </ul>
      </div>
    </div>
  </nav>

 <?php
   include '../backEnd/connectDatabase.php';
   session_start();

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
//echo "something";
     while ($row = mysqli_fetch_assoc($result)) {
       $taskName = $row['name'];
       $taskDesription = $row['description'];
       $taskCreator = "JANGO";

       //$content =  '<b>Task Name:</b><br>'. $taskName. '<br><br> <b>Description:</b><br>'. $taskDesription.'<br><br> <b>Creator: </b><br>'. $taskCreator ;

       if(is_null($row['userID'])){
         echo"<div class='task'><form action='tasks.php' method='POST'>
         <b>Task Name:</b><br> $taskName <br><br> <b>Description:</b><br> $taskDesription<br> <br>
         <input type='hidden' name='selectBtn' value='$taskName'>
         <input name='selectTask' value='select' type='submit'>

         </form></div>";
       }else{
         echo"<div class='task'><form action='tasks.php' method='POST'>
         <b>Task Name:</b><br> $taskName <br><br> <b>Description:</b><br> $taskDesription<br> <br>  <b>task selected by:</b><br> $row[userID]<br> <br>
         <input type='hidden' name='selectBtn' value='$taskName'>
         <input name='selectTask' value='select' type='submit'>

         </form></div>";
       }
     }


   }
   $sql = "SELECT * FROM tasks WHERE userID=2;" ;
   $result2 = mysqli_query($conn, $sql);
   $resultsCheck2 = mysqli_num_rows($result);
   if($resultsCheck2 > 0){

     while ($row = mysqli_fetch_assoc($result2)) {
       $taskName = $row['name'];
       $taskDesription = $row['description'];
       //$taskCreator = "JANGO";
       //$file = 'task.php';
       //if(!is_file($file)){
       //$content =  '<b>Task Name:</b><br>'. $taskName. '<br><br> <b>Description:</b><br>'. $taskDesription.'<br><br> <b>Creator: </b><br>'. $taskCreator .'</div>' ;

       echo"<div class='task'><form action='tasks.php' method='POST'>
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
     echo'Successfully selected';
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
     echo'Successfully selected';
   }
 }
 ?>
    <div class="container">
   <!-- Trigger the modal with a button -->
     <button type="submit" class="btn btn-default btn-lg button" id="myBtn" >+</button>
   <!-- Modal -->
   <div class="modal fade" id="myModal" role="dialog">
     <div class="modal-dialog">
       <!-- Modal content-->
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 style="color:black"><span style="font-family: Montserrat, sans-serif">&#9745;</span> New task</h4>
         </div>
         <div class = "task_form">
          <form action="TaskTest.php">
           <label for="taskName" style="font-family: Montserrat, sans-serif; margin-top:5%;">Task name:</label><br>
           <input type="text" id="taskName" name="taskName"><br>
           <label for="taskDescription" style="font-family: Montserrat, sans-serif; margin-top:5%;">Task Description:</label><br>
           <input type="text" id="taskDescription" name="taskDeskrition"><br><br>
           <textarea id=taskDescription"" rows="10"></textarea>
           <button type="submit" class="button">Add</button>
         </form>
       </div>
         </div>
       </div>
     </div>
   </div>
  </div>
  <script>
  $(document).ready(function(){
    $("#myBtn").click(function(){
      $("#myModal").modal();
    });
  });
  </script>



   <script>
   if ( window.history.replaceState ) {
       window.history.replaceState( null, null, window.location.href );
   }
   </script>
</body>
</html>
