<?php

class Tasks extends Core{
    public function fetchTasks(){
        //query db
       
        console.log("alive!");
        $team=$_SESSION['TEAM_ID'];
        $user=$_SESSION['username'];
        $sql="
            SELECT *
            FROM tasks
            where TEAM_ID='$team'";
        $this->query("
            SELECT *
            FROM tasks
            where TEAM_ID='$team'");
         ?>
            console.log(<?php echo $sql?>);
        <?php
        return $this->rows();
        //return rows
    }
}
?>
