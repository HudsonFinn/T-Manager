<?php

session_start();
include("connectDatabase.php");
$team=$_SESSION["TEAM_ID"];
$sql="select * from `tasks` where `TEAM_ID`='$team'";
$result=mysqli_query($conn,$sql);

$allts=array();
$all1=array();

while($row=mysqli_fetch_assoc($result)){
    array_push($allts,$row['TASK_ID']);
    //print_r($row["TASK_ID"]);
    //print("\n");
}

foreach($allts as $t){
    $parent=$t;
    $sql="SELECT * FROM subtasks where parent='$parent'";
    $result=mysqli_query($conn,$sql);
    $len=mysqli_num_rows($result);
    $path1=array($parent);
    $found=array();
    array_push($found,$parent);
    while($row=mysqli_fetch_assoc($result)){
        array_push($found,$row["SUB_ID"]);
    }
    $children=array('hehe'=>1);
    $done=array();

    while(count($found) != count($done)){
       
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
                array_push($tempname,$row["name"]);
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
                array_push($all1,$temp);
            }
            array_push($path1,$temp[0]);
            //array_push($pathname,$tempname[0]);
        } 
    }
    
}
$all=array();
foreach($all1 as $a){
    foreach($a as $elem){
        array_push($all,$elem);
    }
}
$sql="select * from user_teams where `TEAM_ID`='$team'";
$result=mysqli_query($conn,$sql);
$m=array();
while($row=mysqli_fetch_assoc($result)){
    array_push($m,$row['USER_ID']);
}
$tots=array();
foreach($all as $q){
    $tots[$q]=array();
    foreach($m as $w){
        $tots[$q][$w]=0;
    }
}
foreach($all as $place){
    $sql="select * from `chat` where `SUB_ID`='$place'";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
        $words=explode(" ", $row['message']);
        $tots[$place][$row['USER_ID']]=$tots[$place][$row['USER_ID']]+count($words);
    }
}
$rel=array();
foreach($m as $u1){
    $rel[$u1]=array();
    foreach($m as $u2){
        $rel[$u1][$u2]=0;
    }
}
$i=0;
$n=count($m);
while($i<$n-1){
    $j=$i+1;
    while($j<$n){
        foreach($all as $e){
            if($tots[$e][$m[$i]]!=0 && $tots[$e][$m[$j]]!=0){
                $rel[$m[$i]][$m[$j]]=$rel[$m[$i]][$m[$j]]+$tots[$e][$m[$i]];
                $rel[$m[$j]][$m[$i]]=$rel[$m[$j]][$m[$i]]+$tots[$e][$m[$j]];
            }
        }
        $j=$j+1;
    }
    $i=$i+1;
}
$nodes=array();
$dumb=array();
foreach($m as $o){
    $temp=array("userID"=>$o, "in" =>0, "out" =>0);
    array_push($nodes,$temp);
}
$i=0;
$n=count($m);
while($i<$n-1){
    $temp=array("userID"=>$i, "in" =>0, "out" =>0);
    array_push($nodes,$temp);
    $i=$i+1;
}
$links=array();
$links2=array();
$i=0;
$n=count($m);
while($i<$n-1){
    $j=$i+1;
    while($j<$n){
        $a=$rel[$m[$i]][$m[$j]];
        $b=$rel[$m[$j]][$m[$i]];
        $score=(($a+$b)*($a+$b))/(abs($a-$b)+1);
        if($score !=0 ){
            $score=log10($score);
        }
        $temp=array("source"=>$m[$i],"score"=>$score,"target"=>$m[$j]);
        array_push($links,$temp);
        $temp=array("source"=>$m[$j],"score"=>$score,"target"=>$m[$i]);
        array_push($links,$temp);
        $temp=array("source"=>$i,"score"=>$score,"target"=>$j);
        array_push($links2,$temp);
        $temp=array("source"=>$j,"score"=>$score,"target"=>$i);
        array_push($links2,$temp);
        $j=$j+1;
    }
    $i=$i+1;
}
//print("<pre>");
//print_r(json_encode($links));
//print("</pre>");
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
        <link rel="stylesheet" href="fabstyle.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>
        <link rel="stylesheet" href="../design_template.css">
    <title>Network view</title>

    <style>
        
        svg circle.node {
          fill: #3b5998;
          stroke: #1b3978;
          stroke-width: 1.5px;
        }

        svg line.link {
          stroke: #222;
          stroke-opacity: .6;
          stroke-width: 2px;
        }

        div.tooltip {   
          position: absolute;           
          text-align: center;
          opacity: 0;
          visibility: hidden;
          width: 80px;                  
          height: 28px;                 
          padding: 2px;             
          font: 12px sans-serif;        
          background: #a78db8;   
          border: 0px;      
          border-radius: 8px;           
          pointer-events: none;         
        }
        svg{
          
          
          border-radius: 10px;
          opacity: 0.5;
          zoom: 
          
        }
        #body{
            width: 90vw;
            height: auto;
            margin-left: 5vw;
            margin-right: 5 vw;
            margin-top:15vh;
            background-color:#FFCFCF;
            opacity: 0.6;
            border:1px solid #fff;
            border-radius: 5px;

        }
        #body:hover{
            opacity: 0.7;
        }
        
    </style>

  </head>

  <body>
      <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">T-MANAGER</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="logpage/viewlog.php">ACTIVITY LOG</a></li>
              <li><a href="viewtasks.php">TASKS</a></li>
              <li><a href="../calendar-new/index.php">MEETINGS</a></li>
              <li><a href="../Dan/performancePage.php">PERFORMANCE</a></li>
              <li><a href="profile.php">PROFILE</a></li>
              <li><a href="selectGroup.php">CHANGE GROUP</a></li>
              <li><a href="logout.php">LOGOUT</a></li>
            </ul>
          </div>
        </div>

      </nav>
<div class="tooltip"></div>
<!-- load the d3.js library -->	
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js"></script>
<script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<div id="body"></div>
	
<script>
    //Source:https://codepen.io/smlo/pen/JdMOej
        
        var w = 1280,
            h = 600,
            fbBlue = d3.rgb("#917B93"),
            fill = [fbBlue.brighter(2),fbBlue.brighter(),fbBlue,fbBlue.darker()];
        var users=JSON.parse('<?php echo json_encode($m);?>');
        var nodes = d3.range(0,<?php echo count($m);?>).map(function(i){
              return {
                userID: users[i],
                in: 0,
                out: 0
              }
            }); 
        var vis = d3.select("#body").append("svg:svg")
            .attr("width", w)
            .attr("height", h);
        var links=JSON.parse('<?php echo json_encode($links2);?>');
        

        
        links.forEach(function(d, i){
          nodes[d.source].out++;
          nodes[d.target].in++;
        });
       
        var force = d3.layout.force()
            .charge(-80)
            .linkDistance(25)
            .linkStrength(0.2)
            .size([w, h])
            .nodes(nodes)
            .links(links)
            .start();

        
        var link = vis.selectAll(".link")
            .data(links)
            .enter()
            .append("line")
            .attr("class", "link")
            .style("stroke-width", function (d) { return d.score*d.score; });

        var node = vis.selectAll("circle.node")
            .data(nodes)
          .enter().append("svg:circle")
            .attr("class", "node")
            .attr("cx", function(d) { return d.x; }) //x
            .attr("cy", function(d) { return d.y; }) //y
            .attr("r", 8)
            .style("fill", function(d, i) {
              return fill[parseInt((d.in+1)/3)];
            })
            .call(force.drag);

        vis.style("opacity", 1e-6)
           .transition()
           .duration(1000)
           .style("opacity", 1);

        force.on("tick", function(e) {
         
          link.attr("x1", function(d) { return d.source.x; })
              .attr("y1", function(d) { return d.source.y; })
              .attr("x2", function(d) { return d.target.x; })
              .attr("y2", function(d) { return d.target.y; });

          node.attr("cx", function(d) { return d.x; })
              .attr("cy", function(d) { return d.y; });
        });

        var div = d3.select("div.tooltip");
        d3.selectAll(".node").on("mouseover", function(d, i){
          div.style("visibility", "visible")
             .transition()
             .duration(200)
             .style("opacity", .9);
          var html;
          if(d.in == d.out)
            html = "User "+d.userID+"<br/>"
          else
            html = "User "+d.userID+"<br/>"
          div.html(html)
             .style("left", (d.x + 15) + "px")
             .style("top", (d.y - 30) + "px");
        }).on("mouseout", function(d, i){
          div.transition()
             .duration(500)
             .style("opacity", 0)
             .each("end", function(){
               div.style("visibility", "hidden")
             });
        });
</script>
	
  </body>
</html>
