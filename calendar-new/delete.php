<?php

//delete.php

if(isset($_POST["id"]))
{
 $connect = new PDO('mysql:host=dbhost.cs.man.ac.uk;dbname=2019_comp10120_z1', 't25435gu', 'sharp123');
 $query = "
 DELETE from events WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':id' => $_POST['id']
  )
 );
}

?>
