<html>
<title> Add Task </title>
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <style>
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
}
.button:hover {
  background-color: black;
  color: #e6ffff;
  border: none;
  padding-top: 10px;
  padding-bottom: 10px;
  padding-left: 15px;
  padding-right: 15px;
}
</style>
</head>
<body>
  <div class="container">
 <!-- Trigger the modal with a button -->
 <button type="button" class="btn btn-default btn-lg" id="myBtn">Login</button>

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


  <b>Add task:</b>
  <br>
  <br>
  <form class="" action="TaskTest.php" method="POST">
  Task Name:
  <input type="text" name="taskName" value=""> </input>
  <br>

  Task Description:
  <input type="text" name="taskDescription" value=""> </input>
  <br>

  <button type="submit" name="button">Add task</button>
</form>
<?php

  include '../backEnd/connectDatabase.php';



 ?>

  </body>
</html>
