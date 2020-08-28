<?php

//load.php
session_start();
$un = $_SESSION['username'];
$gn = $_SESSION['TEAM_ID'];
$connect = new PDO('mysql:host=dbhost.cs.man.ac.uk;dbname=2019_comp10120_z1', 't25435gu', 'sharp123');

$data = array();

$query = "SELECT * FROM events WHERE teams = '$gn' ORDER BY id";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'title'   => $row["title"],
  'start'   => $row["start_event"],
  'end'   => $row["end_event"]
 );
}

echo json_encode($data);

?>
