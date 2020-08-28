<?php
require '../core/init.php';

if(isset($_POST['method']) === true && empty($_POST['method']) === false){
    $chat       =new Chat();
    $method     =trim($_POST['method']);
    if($method ==='fetch'){
        //fetch message and ouput
        $messages= $chat->fetchMessages($_COOKIE['chatplace']);
        if(empty($messages)===true){
            echo 'there are no messages in the chat';

        }else{
            foreach($messages as $message){
            ?>
                <div class="message">
                    <div style="text-align:left"><div style="opacity: 1 color:white"<a href="#"><?php echo "<b>". $message['USER_ID'] ."</b>";?></a> says: </div></div>
                    <div style="text-align:left"><p><?php echo ">  &nbsp &nbsp &nbsp         ".nl2br($message['message']); ?></p></div>
                </div>
            <?php
            }
        }

    }else if($method === 'throw' && isset($_POST['message'])===true){
        //throw message into database
        $message =trim($_POST['message']);
        if(empty($message)===false){
            $chat->throwMessage($_SESSION['username'],$message,$_COOKIE["chatplace"]);
        }
    }
    else if($method === 'adduser'){
        //throw message into database
        $useradd =trim($_POST['useradd']);
        $team=$_SESSION['TEAM_ID'];
        $servername = "dbhost.cs.man.ac.uk";
        //My username
        $username = "t25435gu";
        //My password (Please don't steal it) :) (too late)
        $password = "sharp123";
        //The name of our group database
        $db = "2019_comp10120_z1";
        $con= mysqli_connect($servername,$username,$password);
        mysqli_select_db($con,$db);
        $sql="select * from user_teams where USER_ID='$useradd' and TEAM_ID='$team'";
        $result=mysqli_query($con,$sql);
        $i=mysqli_num_rows($result);
        if($i>0){
            $chat->adduser($useradd,$_COOKIE["chatplace"]);
        }

    }
}
?>
