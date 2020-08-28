<?php
include("../backEnd/functions.php");
session_start();
if (!isset($_SESSION['userID'])) {
  header('location:LoginPage');
}

$userID = $_SESSION['userID'];
echo($userID);

if (isUserInGroup($userID)) {
  header('location:selectGroup.php');
} else {
  header('location:joinGroup.php');
}

 ?>
