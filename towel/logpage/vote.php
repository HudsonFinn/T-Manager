<?php
include("core/classes/connectDatabase.php");
session_start();
$user=$_SESSION['username'];
$action= $_COOKIE['ACTION_ID'];

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{

  background: url("https://images.unsplash.com/photo-1570884745218-1275bb172d97?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1267&q=80") no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;

}
.slidecontainer {
  width: 80%;
  display: block;
 margin-left: auto;
 margin-right: auto;

}

.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 15px;
  border-radius: 15px;
  background: #290f3d;
  opacity: 0.9;
  outline: none;

  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider:hover {
  opacity: 0.8;
}

.slider::-webkit-slider-thumb {
  opacity: 1;
  -webkit-appearance: none;
  appearance: none;
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background: #fce279;
  cursor: pointer;

}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background: black;
  cursor: pointer;
}
html {
  height: 100%;
  overflow: hidden;
}


</style>
</head>
<body>

  <h1 style="color:#5c2570; text-shadow: 2px 2px 5px #e0be6e;text-align:center;font: 55px arial, sans-serif;">Select Difficulty:</h1>
<div class="slidecontainer">
  <input type="range" min="1" max="100" value="50" class="slider" id="myRange">
  <p style="color:#4d0f47;text-shadow: 1px 1px 3px #e0be6e;text-align:left;font: 25px arial, sans-serif;">Value: <span id="demo"></span></p>
</div>

<script>
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = "easy";
//output.innerHTML = slider.value;

slider.oninput = function() {
    if(this.value<=25){
        output.innerHTML = "super duper easy";
    }
    else if(this.value<=50){
        output.innerHTML = "easy";
    }
    else if(this.value<=75){
        output.innerHTML = "difficult";
    }
    else if(this.value<=100){
        output.innerHTML = "super duper difficult";
    }
    document.cookie="value="+this.value;
    //output.innerHTML = this.value;
}
</script>
<?php
        $vote=$_COOKIE['value'];
        $sql="select * from has_voted where USER_ID='$user' and ACTION_ID='$action'";
        $result=mysqli_query($conn,$sql);
        //$row=mysqli_fetch_assoc($result);
        if(mysqli_num_rows($result) == 0){
            echo "  <form action=\"castvote.php\" method=\"post\">
                    <center><button style='
                    background-color: #7f4cb0;
                    border: none;
                    color: #edd66d;
                    padding: 30px 50px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 16px;
                    margin: 40px 2px;
                    cursor: pointer;'
                    type='submit' class=''>VOTE</button><center>
                    </form>";
        }




?>
</body>

</html>
