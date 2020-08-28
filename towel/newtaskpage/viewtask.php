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
//echo $row['name']. "</div>";
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
        <link rel="stylesheet" href="../fabstyle.css">
        <link rel="stylesheet" type="text/css" href="../../design_template.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>


        <style>
        html {
          height: 100%;
        }
        body {
              /* background-color: #ffe0fd; */
              background: url("https://images.unsplash.com/photo-1570884745218-1275bb172d97?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1267&q=80") no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
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
            padding-top: 7px;
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
            padding-top: 7px;
            color:white;
        }
        .createBtn:hover{
            opacity: 0.9;
        }
        .endBtn:hover{
            opacity: 0.9;
        }
        .modal-header, h4, .close {
            background-color: #a78db8;
            color:black !important;
            text-align: center;
            font-size: 30px;
            border-radius:5px
          }
          .modal-footer {
            background-color: #a78db8;
          }

          .task_form{
            margin-left: 30%;
            margin-right:30%;
            height: 45%;
          }
          .btn-circle
          {
            background-color: #a78db8;
            border: none;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            border-radius: 40px;
            text-align: center;
            font-family: Montserrat, sans-serif;
            text-transform: uppercase;
            letter-spacing: -1px;
            width: 65px;
            height: 65px;
            padding: 6px 0px;
            font-size: 12px;
            line-height: 1.42857;
            margin-left: 38%
          }
          .btn-circle:hover{
            background-color: #e6d0f4;
            box-shadow: 0px 15px 18px rgba(0, 0, 0, 0.1);
            color: #fff;
          }
          .modal-content
          {
            z-index: 5;
            margin-top: 25%;}

        .btn-group {
          text-align: center;
          margin-left: 34%;
        }
        .btn-group button {
          background-color: #e6d0f4 !important; /* Green background */
          border: 1px solid black; /* Green border */
          margin-top: 10vh;
          color: black; /* White text */
          padding: 10px 24px; /* Some padding */
          cursor: pointer; /* Pointer/hand icon */
          float: left; /* Float the buttons side by side */
        }


        .btn-group button:not(:last-child) {
          border-right: none; /* Prevent double borders */
        }

        /* Clear floats (clearfix hack) */
        .btn-group:after {
          content: "";
          clear: both;
          display: table;
        }

        /* Add a background color on hover */
        .btn-group button:hover {
          background-color: #e6d0f4;
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
              <li><a href="../../calendar-new/index.php">MEETINGS</a></li>
              <li><a href="../../Dan/performancePage.php">PERFORMANCE</a></li>
              <li><a href="../profile.php">PROFILE</a></li>
              <li><a href="../selectGroup.php">CHANGE GROUP</a></li>
              <li><a href="../logout.php">LOGOUT</a></li>
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
      <br>
      <br>
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

                        }
                        echo "<div class=\"cont2\" id ='myBox'>
                            <textarea class=\"entry\" placeholder=\"Type here...\"></textarea>
                            <div>
                            <div data-toggle='modal' data-target='#GSCCModal'>
                            <div id= 'btn1' class ='createBtn'>Create subtask in $task_name</div>
                            </div>
                            <div btn2 = 'btn2' class= 'endBtn'onclick='endTask()'>End task $task_name</div></div></div>";
                            //onclick='createSUB()'
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


        <script type="text/javascript">
            //source:https://codepen.io/augbog/pen/LEXZKK
            var pl="<?php echo $task;?>";
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
                pl=d.ID;
                update(d);
                $.ajax({
                    url:'ajax/chat.php',
                    type: 'post',
                    data:{method:'fetch'},
                    success: function(data){
                    $('.chat .messages').html(data);
                    }
                });
                var v=0;
                $.ajax({
                    url:'makeVisible.php',
                    type: 'post',
                    data:{method:'isVisible'},
                    success: function(data){
                        v=data;
                        console.log("THIS IS IT: "+v);
                        if(v==1){
                            document.getElementById("myBox").style.visibility = "visible";
                        }
                        else{
                            document.getElementById("myBox").style.visibility = "hidden";
                        }
                    }
                });

                var t=d.name;
                if(d.ID!="<?php echo $task; ?>"){
                    t=t+" in "+"<?php echo $task_name; ?>";
                }
                document.getElementById("title").innerHTML = t;
                document.getElementById("btn1").innerHTML = "Create subtask in "+d.name;

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
            function createSUB(){
                /*
                var d= decodeURIComponent(document.cookie);
                var  list1= d.split(';');
                var str="";
                for(var i=0;i<list1.length;i++){
                    if(list1[i].includes("chatplace=")){
                        str=list1[i].replace(" chatplace=",'');
                        break;
                    }
                }
                */
                var subName = document.getElementById("taskName").value;
                document.getElementById("taskName").value = ""
                document.cookie = "parent="+ pl;
                console.log("parent="+ pl);
                $.ajax({
                  url:"insertsub.php",
                  type:"POST",
                  data:{subname:subName},
                  success:function(error) {
                  }
                });
                $.ajax({
                  url:"treeview.php",
                  type:"POST",
                  data:{},
                  success:function(error) {
                    location.reload();
                  }
                });

                // window.location.href = "createsub.php";
            }
            function endTask(){
                window.location.href = "../endtask.php";
            }
        </script>

        <div id="GSCCModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"style="width:15.3%">&times;</button>
                <h4 style="color:black"><span style="margin-left: 15%; font-family: Montserrat, sans-serif; text-transform: uppercase; font-weight: lighter; letter-spacing: -2px;">&#9745;</span> New task</h4>
              </div>
              <div class = "task_form">
                   <label for="taskName" style="font-family: Montserrat, sans-serif; margin-top:5%; text-transform: uppercase; font-weight: lighter; letter-spacing: -1px;">Task Name:</label><br>
                   <input type="text" id="taskName" name="taskname"><br>
                   <button type="button" onclick = "createSUB()" class="btn-circle" data-dismiss="modal" style="margin-bottom:5%;">Submit</button>
               </div>
            </div>
          </div>
        </div>
        </div>
    </body>
</html>
