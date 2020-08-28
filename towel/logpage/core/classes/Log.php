<?php


class Log extends Core{
    public function fetchLogs(){
        $team=$_SESSION['TEAM_ID'];
        //query db
        $this->query("
            SELECT logs.type, logs.ACTION_ID,logs.name
            FROM logs
            where TEAM_ID='$team'
                   
        ");
        return $this->rows();
        //return rows
    }
    
}
?>
