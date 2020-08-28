<html>
<title> Selected Task </title>
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
div2 {
  display: inline-block;

}
</style>
</head>

<?php
include 'backEnd/connectDatabase.php';
session_start();
echo $_POST['taskName'];
echo'<br>';

echo " <div2><br> <br><input type='submit' name='insert' value='TAKE this task'> ";


echo '<form class="" action="TaskTest.php">';
echo " <br> <br><button>return </button></div2>";


 ?>


 </html>
