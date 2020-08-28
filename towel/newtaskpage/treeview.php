<?php
include("../connectDatabase.php");
$task=$_COOKIE["TASK_ID"];
function f($parent,$children){
    include("../connectDatabase.php");
    $r=array();
    if(!array_key_exists($parent,$children)){
        return null;
    }
    foreach($children[$parent] as $c){
        $sql="select name from subtasks where SUB_ID='$c'";
        $result=mysqli_query($conn,$sql);
        $rows=mysqli_fetch_assoc($result);
        $temp=array('name'=>$rows['name'],'ID'=>$c,'children'=>f($c,$children));
        array_push($r,$temp);
    }
    return $r;
}
$task_root=$_COOKIE["TASK_ID"];
$team=$_SESSION["TEAM_ID"];
$sql="SELECT * FROM tasks where TASK_ID='$task_root'";
$result=mysqli_query($conn,$sql);
$rows=mysqli_fetch_assoc($result);
$task_name=$rows['name'];
$parent=$task_root;
$sql="SELECT * FROM subtasks where parent='$parent'";
$result=mysqli_query($conn,$sql);
$len=mysqli_num_rows($result);
//$path=array();
$path1=array($parent);
$found=array();
array_push($found,$parent);
while($row=mysqli_fetch_assoc($result)){
    array_push($found,$row["SUB_ID"]);
}
$children=array('hehe'=>1);
$done=array();

while(count($found) != count($done)){
   /* print_r($pathname);
    print_r("<br>");
    print_r(count($done));
    print_r("<br>");
    print_r(count($found));
    print_r("<br>");*/

    if(count($path1)!=0){
        $parent=$path1[count($path1)-1];
    }
    $sql="select * from subtasks where parent='$parent'";
    $result=mysqli_query($conn,$sql);
    $temp=array();
    $tempname=array();
    while($row=mysqli_fetch_assoc($result)){
        if(!in_array($row["SUB_ID"],$done)){
            array_push($temp,$row["SUB_ID"]);
            //array_push($tempname,$row["name"]);
        }
    }

    if(count($temp)==0){
        array_push($done,$parent);
        array_pop($path1);
        //array_pop($pathname);
    }
    else{
        if(!array_key_exists($parent,$children)){
           $children[$parent]=$temp;
            array_push($found,$temp);
        }
        array_push($path1,$temp[0]);
        //array_push($pathname,$tempname[0]);
    }
}
$output=array('name'=>$task_name,'ID'=>$task_root,'children'=>f($task_root,$children));
//print("<pre>");
//print_r(json_encode($output));
//print("</pre>");
?>
