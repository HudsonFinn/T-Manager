<?php

class Chat extends Core{
    public function fetchMessages($sub){
        //query db
        $this->query("
            SELECT message, USER_ID
            FROM chat
            where SUB_ID='$sub'
            ORDER BY timestamp ASC
                   
        ");
        return $this->rows();
        //return rows
    }
    public function throwMessage($user_id,$message,$sub){
        //insert into db
        $u=uniqid("TXT_",true);
        $this->query("
            INSERT INTO chat (MES_ID, SUB_ID,USER_ID,message,timestamp)
            VALUES ('".$u."','" .$sub. "','".$user_id."','" . $this ->db->real_escape_string(htmlentities($message)) . "', UNIX_TIMESTAMP() );");
    }
     public function adduser($user_id,$sub){
        //insert into db
        $u=uniqid("USER_SUBS_ID_",true);
        
        $this->query("
        INSERT INTO user_subs(USER_SUBS_ID, SUB_ID,USER_ID)
        VALUES ('".$u."','" .$sub. "','".$user_id."')");
        
        
    }
    
}
?>
