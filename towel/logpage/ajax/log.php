<?php
include("../../connectDatabase.php");
require '../core/init.php';
if(isset($_POST['method']) === true && empty($_POST['method']) === false){
    $log       =new Log();
    $method     =trim($_POST['method']);
    if($method ==='fetch'){
        //fetch message and ouput
        $logs= $log->fetchLogs();
        //$team=$_COOKIE["TEAM_ID"];
        //$sql="select * from user_teams where TEAM_ID='$team'";
        //$result=mysqli_query($conn,$sql);
        //$count=mysqli_num_rows($result);
        if(empty($logs)===true){
            echo 'no logs in here';

        }else{
            foreach($logs as $l){

            ?>
                <div class="log" id="<?php echo $l['ACTION_ID'];?>" onClick="reply_click('<?php echo $l['type']?>',this.id)">
                    <a href="#" ><b>event: <?php echo $l['type'];?>:</b></a>
                    <p><?php
                            $s="";
                            $a=$l['ACTION_ID'];
                            $txt=$l['name'];   
                            if($l['type']=='VOTE'){
                                $sql="select votes from taskbuffer where ACTION_ID='$a'";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $s = "votes: ".$s.$row['votes'];
                            }
                
                            if($l['type'] == 'SUB CREATED'){
                                $t = $l['name'];
                                $sql = "select name from tasks where TASK_ID='$t'";
                                $result = mysqli_query($conn, $sql);
                                if($result != null && mysqli_num_rows($result)!=0 ){
                                    $row=mysqli_fetch_assoc($result);
                                    $txt=$row['name'];
                                }
                                else{
                                    $sql = "select name from subtasks where SUB_ID='$t'";
                                    $result = mysqli_query($conn, $sql); 
                                    $row=mysqli_fetch_assoc($result);
                                    $txt=$row['name'];
                                    
                                }
                                $sub=$l['ACTION_ID'];
                                $sql = "select name from subtasks where SUB_ID='$sub'"; 
                                $result = mysqli_query($conn, $sql); 
                                $row=mysqli_fetch_assoc($result);
                                $txt=$row['name']. " created in " . $txt;
                                
                            }
                            
                            


                            echo nl2br("> &nbsp &nbsp &nbsp".$txt)."  ".$s; ?></p><br>
                </div>
            <?php
                /*
                $a=$l["ACTION_ID"];
                $sql="select * from taskbuffer where ACTION_ID='$a'";
                $result=mysqli_query($conn,$sql);
                $row=mysqli_fetch_assoc($result);
                $votes=$row['votes'];
                if($votes ==$count){
                    //$avg=$l['sum']/$count;
                    $sql="UPDATE logs
                        SET type='PICK'
                        WHERE ACTION_ID = '$a' and type='VOTE';";
                    mysqli_query($conn,$sql);
                }
                */
            }
            ?>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script type="text/javascript">
            function reply_click(type, clicked_id)
                {
                    //alert(type);
                    //$.session.set("TEAM_ID", clicked_id);
                    document.cookie = "ACTION_ID="+clicked_id;
                    if(type=="VOTE"){
                        window.location.href = "vote.php";
                    }
                    if(type=="PICK"){
                        window.location.href="pick.php";
                    }
                }
        </script>
        <?php
        }

    }
    /*else if ($method==='checkVotes'){
        $logs= $log->fetchLogs();
        $team=$_COOKIE["TEAM_ID"];
        $sql="select * from user_teams where TEAM_ID='$team'";
        $result=mysqli_query($conn,$sql);
        $count=mysqli_num_rows($result);

        if(empty($logs)===false){

            foreach($logs as $l){

                $a=$l["ACTION_ID"];
                $sql="select * from taskbuffer where ACTION_ID='$a'";
                $result=mysqli_query($conn,$sql);
                $row=mysqli_fetch_assoc($result);
                $votes=$row['votes'];
                if($votes ==$count){
                    //$avg=$l['sum']/$count;
                    $sql="UPDATE logs
                        SET type='PICK'
                        WHERE ACTION_ID = '$a' and type='VOTE';";
                    mysqli_query($conn,$sql);
                }
            }
            $t2=time();

                ?>
                    <script>console.log(<?php echo ($t2); ?>);</script>
                <?php

        }


    }*/
}
?>
