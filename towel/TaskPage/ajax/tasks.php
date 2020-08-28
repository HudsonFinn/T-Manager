<?php
require '../core/init.php';
if(isset($_POST['method']) === true && empty($_POST['method']) === false){
    $t      =new Tasks();
    $method     =trim($_POST['method']);
    if($method ==='fetch'){
        //fetch message and ouput
        $tasks= $t->fetchTasks();
         ?>
            console.log("alive!");
        <?php
        if(empty($tasks)===true){
            echo 'there are no tasks yet';
            
        }else{
            foreach($tasks as $task){
            ?>
                <div class="task" id="<?php echo $task['TASK_ID'];?>" onClick="reply_click(this.id)">
                    <a href="#" > User: <?php echo $task['USER_ID'];?></a>:
                    <p><?php echo nl2br($task['name'])?></p>
                </div>
            <?php
            }
            ?>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script type="text/javascript">
            
            function reply_click(type, clicked_id)
                {   
                    console.log("alive!");
                    alert(clicked_id);
                    
                }
        </script>
        <?php
        }
        
    }
}
?>
