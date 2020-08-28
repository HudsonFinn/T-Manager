<?php
/* Sets up the connection for the database so that other files can use the
connection without having to write it out 300 times */
//Address of our server
$servername = "dbhost.cs.man.ac.uk";
//My username
$username = "t25435gu";
//My password (Please don't steal it) :) (too late)
$password = "sharp123";
//The name of our group database
$db = "2019_comp10120_z1";

//Command which returns true if the connection is successful, if not returns an error message
$conn = mysqli_connect($servername, $username, $password, $db);

//Outputs any error message
if (!$conn)
  die("connection failed: " . mysqli_connect_error());
?>
