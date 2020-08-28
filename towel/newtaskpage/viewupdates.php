<?php
session_start();
include("../connectDatabase.php");
include("treeview.php");
$user=$_SESSION['username'];
$task=$_COOKIE["TASK_ID"];
$_COOKIE["chatplace"]=$_COOKIE["TASK_ID"];
$sql="select * from tasks where TASK_ID='$task'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$count=mysqli_num_rows($result);
echo $row['name']. "</div>";
$text1 =$row['USER_ID']. " is responsible for ".$row['name'];
$task_name=$row['name'];
$i=$row["points"];
$diff="";
if($i<=25){
  $diff="VERY EASY";
}
else if($i<=50){
  $diff="EASY";
}
else if($i<=75){
  $diff="DIFFICULT";
}
else if($i<=100){
 $diff="VERY DIFFICULT";
}
                    
$text2="Difficulty: ".$diff;
$deadline=gmdate("d/m/Y", $row["deadline"]);
$text3="Deadline: ".$deadline;
$text4="Created on: " .gmdate("d/m/Y", $row["date_created"]);
$text5="Description: ".$row["desc"];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Updates</title>
        <link rel="stylesheet" type="text/css" href="../../design_template.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">


        <style>
        html {
          height: 100%;
        }
        body {
              /* background-color: #ffe0fd; */
              background-image: linear-gradient(45deg, #d61a9b , #ff144f);
            /*background-image: linear-gradient(#a78db8 , #fff);*/
              scrollbar-color: red yellow;
        }
        ::-webkit-scrollbar {
              width: 0px;
        }
        .messages{
            background-color:#FFCFCF;
            opacity: 0.6;
            border:1px solid #fff;
            border-radius: 5px;
            width:40vw;
            height:55vh;
            padding:10px;
            overflow-y: scroll;
            scrollbar-color: red yellow;
        }
        .messages:hover{
            opacity: 0.7; 
        }
            
        .entry{
            opacity: 0.7;
            border-radius: 5px;
            background-color: #FFCFCF;
            border:1px solid #fff;
            width: 20vw;
            height: 10vh;
            padding: 5px;
            margin-top: 5vh;
            font: 1em Aria;
        }
        .entry:hover{
                opacity: 0.9;
        }
       .chat .message a{
           color:#620399;
       }
       .chat .message p{
           margin: 10px 0;
       }
       .pad {
         padding: 115px 50px 25px;

        }
        .intext{
            padding: 5px;
            opacity: 1;
        }
            
        .node {
            cursor: pointer;
        }
        .node circle {
            fill: #fff;
            stroke: steelblue;
            stroke-width: 1.5px;
        }
        .node text {
            font: 10px sans-serif;
        }
        .link {
            fill: none;
            stroke: #ccc;
            stroke-width: 1.5px;
        }
        .grid-container{
            display: grid;
            grid-template-columns: auto auto;
            margin-left:7vw;
            
        }
        #title{
            margin-top: 7vh;  
            margin-bottom: 5vh;
            height: 5vh;
            color: black;
        }
        #title:hover{
             color: white; 
            
        }
        #body{
            width: 40vw;
            height: 70vh;
            background-color:#FFCFCF;
            opacity: 0.6;
            border:1px solid #fff;
            border-radius: 5px;
            
        }
        #body:hover{
            opacity: 0.7;
        }
        svg{
            width: 40vw;
            height: 70vh;    
        }
        .cont2{
            display: grid;
            grid-template-columns: auto auto;   
        }
        .createBtn{
            margin-top: 3vh;
            width: 13vw;
            height: 5vh; 
            opacity: 0.5;
            border-radius: 5px;
            background-color: orangered; 
            text-align: center;
            color:white;
        }
        .endBtn{
            margin-top: 2vh;
            width: 13vw;
            height: 5vh; 
            opacity: 0.5;
            border-radius: 5px;
            background-color: darkgreen;   
            text-align: center;
            color:white;
        }
        .createBtn:hover{
            opacity: 0.9;   
        }
        .endBtn:hover{
            opacity: 0.9; 
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
              <li><a href="../logpage/viewlog.php">ACTIVITY LOG</a></li>
              <li><a href="../viewtasks.php">TASKS</a></li>
              <li><a href="../calendar.html">MEETINGS</a></li>
              <li><a href="../performance.php">PERFORMANCE</a></li>
              <li><a href="../profile.php">PROFILE</a></li>
            </ul>
          </div>
        </div>

      </nav>
      <!--<header>
      <h1>
        <center><div class="pad"><font  size="+10" color="#f6dba4">
          Chat Updates</font></center></div>
      </h1>
      </header>-->
        <center><h1 id="title" onclick="viewDetails()"><?php
            $p=$_COOKIE["TASK_ID"];
            //$task=$_COOKIE["TASK_ID"];
            //$sql="select * from tasks where SUB_ID='$p'";
            //$a=mysqli_query($conn,$sql);
            $sql="select * from tasks where TASK_ID='$p'";
            $b=mysqli_query($conn,$sql);
            $c=mysqli_fetch_assoc($b);
            if($b!=null){
                $title=$c["name"];
                echo $title;
            }
            ?></h1>
        </center>
            <div class="grid-container">
                <div class="chat">
                    <div class="messages"></div>
                    <?php
                        $place=$_COOKIE["chatplace"];
                        $sql="select * from user_subs where USER_ID='$user' and SUB_ID='$place'";
                        $a=mysqli_query($conn,$sql);
                        $sql="select * from tasks where USER_ID='$user' and TASK_ID='$place'";
                        $b=mysqli_query($conn,$sql);
                        if(mysqli_num_rows($a) !=0 or mysqli_num_rows($b) !=0 ){
                            echo "<div class=\"cont2\">
                            <textarea class=\"entry\" placeholder=\"Type here...\"></textarea>
                            <div>
                            <div class ='createBtn' onclick='createSUB()'>Create subtask in '$task_name'</div>
                            <div class= 'endBtn'onclick='endTask()'>End task '$task_name'</div></div></div>";
                        }
                    ?>
                </div>
                <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
                <script src="js/chat2.js"></script>
                <script>
                 $('html, body,div').animate({ scrollTop: 100000 }, 'fast');
                </script>
                <!-- load the d3.js library -->	
                <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js"></script>
                <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
                <div id="body"></div>
            </div>
        
	
        <script>
            var margin = {
                top: 20,
                right: 120,
                bottom: 20,
                left: 120
            },
            width = 960 - margin.right - margin.left,
            height = 800 - margin.top - margin.bottom;

            var root = JSON.parse('<?php echo json_encode($output);?>');
            console.log(root);

            var i = 0, duration = 750, rectW = 60, rectH = 30;

            var tree = d3.layout.tree().nodeSize([70, 40]);
            var diagonal = d3.svg.diagonal()
                .projection(function (d) {
                return [d.x + rectW / 2, d.y + rectH / 2];
            });

            var svg = d3.select("#body").append("svg").attr("width", 500).attr("height", 500)
                .call(zm = d3.behavior.zoom().scaleExtent([0.5,3]).on("zoom", redraw)).append("g")
                .attr("transform", "translate(" + 350 + "," + 20 + ")");

            //necessary so that zoom knows where to zoom and unzoom from
            zm.translate([350, 20]);

            root.x0 = 0;
            root.y0 = height / 2;

            function collapse(d) {
                if (d.children) {
                    d._children = d.children;
                    d._children.forEach(collapse);
                    d.children = null;
                }
            }

            root.children.forEach(collapse);
            update(root);

            function update(source) {

                // Compute the new tree layout.
                var nodes = tree.nodes(root).reverse(),
                    links = tree.links(nodes);

                // Normalize for fixed-depth.
                nodes.forEach(function (d) {
                    d.y = d.depth * 180;
                });

                // Update the nodes…
                var node = svg.selectAll("g.node")
                    .data(nodes, function (d) {
                    return d.id || (d.id = ++i);
                });

                // Enter any new nodes at the parent's previous position.
                var nodeEnter = node.enter().append("g")
                    .attr("class", "node")
                    .attr("transform", function (d) {
                    return "translate(" + source.x0 + "," + source.y0 + ")";
                })
                    .on("click", click);

                nodeEnter.append("rect")
                    .attr("width", rectW)
                    .attr("height", rectH)
                    .attr("stroke", "black")
                    .attr("stroke-width", 1)
                    .style("fill", function (d) {
                    return d._children ? "lightsteelblue" : "#fff";
                });

                nodeEnter.append("text")
                    .attr("x", rectW / 2)
                    .attr("y", rectH / 2)
                    .attr("dy", ".35em")
                    .attr("text-anchor", "middle")
                    .text(function (d) {
                    return d.name;
                });

                // Transition nodes to their new position.
                var nodeUpdate = node.transition()
                    .duration(duration)
                    .attr("transform", function (d) {
                    return "translate(" + d.x + "," + d.y + ")";
                });

                nodeUpdate.select("rect")
                    .attr("width", rectW)
                    .attr("height", rectH)
                    .attr("stroke", "black")
                    .attr("stroke-width", 1)
                    .style("fill", function (d) {
                    return d._children ? "lightsteelblue" : "#fff";
                });

                nodeUpdate.select("text")
                    .style("fill-opacity", 1);

                // Transition exiting nodes to the parent's new position.
                var nodeExit = node.exit().transition()
                    .duration(duration)
                    .attr("transform", function (d) {
                    return "translate(" + source.x + "," + source.y + ")";
                })
                    .remove();

                nodeExit.select("rect")
                    .attr("width", rectW)
                    .attr("height", rectH)
                //.attr("width", bbox.getBBox().width)""
                //.attr("height", bbox.getBBox().height)
                .attr("stroke", "black")
                    .attr("stroke-width", 1);

                nodeExit.select("text");

                // Update the links…
                var link = svg.selectAll("path.link")
                    .data(links, function (d) {
                    return d.target.id;
                });

                // Enter any new links at the parent's previous position.
                link.enter().insert("path", "g")
                    .attr("class", "link")
                    .attr("x", rectW / 2)
                    .attr("y", rectH / 2)
                    .attr("d", function (d) {
                    var o = {
                        x: source.x0,
                        y: source.y0
                    };
                    return diagonal({
                        source: o,
                        target: o
                    });
                });

                // Transition links to their new position.
                link.transition()
                    .duration(duration)
                    .attr("d", diagonal);

                // Transition exiting nodes to the parent's new position.
                link.exit().transition()
                    .duration(duration)
                    .attr("d", function (d) {
                    var o = {
                        x: source.x,
                        y: source.y
                    };
                    return diagonal({
                        source: o,
                        target: o
                    });
                })
                    .remove();

                // Stash the old positions for transition.
                nodes.forEach(function (d) {
                    d.x0 = d.x;
                    d.y0 = d.y;
                });
            }

            // Toggle children on click.
            function click(d) {
                if (d.children) {
                    d._children = d.children;
                    d.children = null;
                } else {
                    d.children = d._children;
                    d._children = null;
                }
                console.log(d.ID);
                document.cookie = "chatplace="+d.ID;
                update(d);
                $.ajax({
                    url:'ajax/chat.php',
                    type: 'post',
                    data:{method:'fetch'},
                    success: function(data){
                    $('.chat .messages').html(data);
                    }
                });
                var t=d.name;
                if(d.ID!="<?php echo $task; ?>"){
                    t=t+" in "+"<?php echo $task_name; ?>";
                }
                document.getElementById("title").innerHTML = t;
                
            }

            //Redraw for zoom
            function redraw() {
              //console.log("here", d3.event.translate, d3.event.scale);
              svg.attr("transform",
                  "translate(" + d3.event.translate + ")"
                  + " scale(" + d3.event.scale + ")");
            }
            function viewDetails(){
                 var s="<?php echo $text1;?>"+"\n"+"<?php echo $text2;?>"+"\n"+"<?php echo $text3;?>"+"\n"+"<?php echo $text4;?>"+"\n"+"<?php echo $text5;?>";
                 
		      alert(s);
            }
        </script>
    </body>
</html>
