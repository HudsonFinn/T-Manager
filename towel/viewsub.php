<?php
session_start();
include("connectDatabase.php");
$sub=$_COOKIE["SUB_ID"];
//$parent=$_COOKIE['parent'];
//$_COOKIE['parent']=$sub;
//echo $_COOKIE['parent'] ."<br>";
$task=$_COOKIE['TASK_ID'];
$user=$_SESSION['username'];

$sql="select * from subtasks where SUB_ID='$sub'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$parent=$row['parent'];

echo $row['name']."<br>";
$sql="select * from tasks where TASK_ID='$task'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);


$p=$parent;

echo "<a href='#' id='".$task."' onClick=\"gototask(this.id)\">".$row['name']."</a>"."/";
$s="";

while($p != $task){
    $sql="select * from subtasks where SUB_ID='$p'";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);
    $s= "<a href='#' id='".$p."' onClick=\"goto(this.id)\">".$row['name']."</a>"."/" .$s;
    $p=$row['parent'];  
    ?>
<script type="text/javascript">
    //console.log("<?php echo $s; ?>");
</script>
    <?php
}


echo $s;
$sql="select * from tasks where TASK_ID='$task'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
if($user==$row['USER_ID']){
        
        echo "
                <button onClick=\"setParent()\">Create subtask</button>
                </form>";
    }

?>
<html>
    <body>
    <button  onClick="updates()"><?php
        
        $sql="select * from user_subs where USER_ID='$user' and SUB_ID='$sub'";
        $result=mysqli_query($conn,$sql);
        $i=mysqli_num_rows($result);
        if($i !=0){
            echo "Create updates";
        }
        else{
            echo "View updates";
        }
        ?></button>
        
    
    <button onClick="subs()">View subtasks</button>
        <script type="text/javascript">
            /*window.addEventListener("beforeunload", function(event) { 
                document.cookie="SUB_ID"+"<?php echo $parent ?>";
                console.log("yup");
                //event.returnValue = '';
            });*/
            function gototask(click_id)
            {   
                //document.cookie = "TASK_ID=";
                window.location.href = "viewtask.php";
            }
            function goto(click_id)
            {   
                document.cookie = "SUB_ID="+click_id;
                window.location.href = "viewsub.php";
            }
            function setParent()
            {   
                document.cookie = "parent="+"<?php echo $sub?>";
                window.location.href = "createsub.php";
            }
            function subs()
            {   
                document.cookie = "parent="+"<?php echo $sub?>";
                console.log("parent="+"<?php echo $sub?>");
                window.location.href = "viewsubs.php";
            }
            function updates()
            {   
                //document.cookie = "parent="+"<?php echo $sub?>";
                document.cookie = "chatplace="+"<?php echo $sub?>";
                window.location.href = "chat/viewupdates.php";
            }
        </script>

           
    </body>
</html>