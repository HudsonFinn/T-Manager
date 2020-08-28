<?php

session_start();
include("../connectDatabase.php");
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
   
    
    $parent=$path1[count($path1)-1];
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


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Tree Example</title>

    <style>
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

    body {
        overflow: hidden;
    }

    </style>

  </head>

  <body>

<!-- load the d3.js library -->	
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js"></script>
<script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<div id="body"></div>
	
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

    var i = 0,
        duration = 750,
        rectW = 60,
        rectH = 30;

    var tree = d3.layout.tree().nodeSize([70, 40]);
    var diagonal = d3.svg.diagonal()
        .projection(function (d) {
        return [d.x + rectW / 2, d.y + rectH / 2];
    });

    var svg = d3.select("#body").append("svg").attr("width", 1000).attr("height", 1000)
        .call(zm = d3.behavior.zoom().scaleExtent([1,3]).on("zoom", redraw)).append("g")
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

    d3.select("#body").style("height", "800px");

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
        update(d);
    }

    //Redraw for zoom
    function redraw() {
      //console.log("here", d3.event.translate, d3.event.scale);
      svg.attr("transform",
          "translate(" + d3.event.translate + ")"
          + " scale(" + d3.event.scale + ")");
    }

</script>
	
  </body>
</html>