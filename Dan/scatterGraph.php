<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../design_template.css">
  <link rel="stylesheet" type="text/css" href="popupStyles.css">
    <style>
        .container2{
          float: left;
        }
</style>
    <script src="https://d3js.org/d3.v4.min.js"></script>
</head>
<body style="text-align:center;">
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
          <li><a href="../towel/logpage/viewlog.php">ACTIVITY LOG</a></li>
          <li><a href="../towel/viewtasks.php">TASKS</a></li>
          <li><a href="../calendar-new/index.php">MEETINGS</a></li>
          <li><a href="../Dan/performancePage.php">PERFORMANCE</a></li>
          <li><a href="../towel/profile.php">PROFILE</a></li>
          <li><a href="../towel/selectGroup.php">CHANGE GROUP</a></li>
          <li><a href="../towel/logout.php">LOGOUT</a></li>
        </ul>
      </div>
    </div>

  </nav>
  <br><br><br><br><br>
  <div class="popup" onclick="showInfo()" style="clear:both;"><h2>What am I Looking at?</h2>
    <span class="popuptext" id="myPopup">
    This scatter plot shows the time taken to complete each task in your
  project. The purple dots are your tasks whilst the other dots are from your
  team members. You can use this to judge your efficiency versus the other
  members of the team.</span>
  </div>
  <br>
  <script>
  function showInfo() {
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
  }
  </script>
<?php
session_start();
$id = $_SESSION['username'];
?>
<div id="scatplot" class="container2" style="clear:both;"></div>
<script>
var id = "<?php echo $id ?>";
var margin = {top: 150, right: 30, bottom: 180, left: 60},
  width = 900 - margin.left - margin.right,
  height = 800 - margin.top - margin.bottom;
// append the svg object to the body of the page
var svg2 = d3.select("#scatplot")
  .append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform",
          "translate(" + margin.left + "," + margin.top + ")")
//Read the data
  d3.csv("plot.csv", function(data) {
    // Add X axis
    var x = d3.scaleLinear()
      .domain([0, 0])
      .range([ 0, width ]);
    svg2.append("g")
      .attr("class", "myXaxis")
      .attr("transform", "translate(0," + height + ")")
      .call(d3.axisBottom(x))
      .attr("opacity", "0")

    // Add Y axis
    var y = d3.scaleLinear()
      .domain([0, d3.max(data, function(d) { return d.time})])
      .range([ height, 0]);
    svg2.append("g")
      .call(d3.axisLeft(y));

    svg2.append("g")
       .attr("transform", "translate(0," + height + ")")
       .call(d3.axisBottom(x))
       .append("text")
       .attr("y", height - 425)
       .attr("x", width - 100)
       .attr("text-anchor", "end")
       .attr("stroke", "black")
       .text("Points");

    svg2.append("g")
        .call(d3.axisLeft(y).tickFormat(function(d){
            return d;
        }).ticks(10))
        .append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 6)
        .attr("dy", "-5.1em")
        .attr("text-anchor", "end")
        .attr("stroke", "black")
        .text("Time Taken (h)");

    // Add dots
    svg2.append('g')
      .selectAll("dot")
      .data(data)
      .enter()
      .append("circle")
        .attr("cx", function (d) { return x(d.points); } )
        .attr("cy", function (d) { return y(d.time); } )
        .attr("r", 5)
        .style("fill", function(d){
          if (d.id == id){
            return "#a78db8";
          }
          else{
            return "#b2ebf2";
          }
        })


    // new X axis
    x.domain([0, 100])
    svg2.select(".myXaxis")
      .transition()
      .duration(2000)
      .attr("opacity", "1")
      .call(d3.axisBottom(x));

    svg2.selectAll("circle")
      .transition()
      .delay(function(d,i){return(i*10)})
      .duration(2000)
      .attr("cx", function (d) { return x(d.points); } )
      .attr("cy", function (d) { return y(d.time); } )
  })

</script>
</body>
</html>
