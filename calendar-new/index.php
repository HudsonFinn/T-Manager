<?php
//index.php
session_start();
$un = $_SESSION['username'];
$gn = $_SESSION['TEAM_ID'];

?>
<!DOCTYPE html>
<html>
 <head>
   <title>Jquery Fullcalandar Integration with PHP and Mysql</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" /> -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="../design_template.css">
   <!-- <script src="https://code.jquery.com/jquery-1.10.2.js"></script> -->
   <style>
   {box-sizing: border-box;}

/* Button used to open the contact form - fixed at the bottom of the page */
.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
  bottom: 23px;
  right: 28px;
  width: 280px;
}
/* buttons override above the calendar*/

.fc-state-default.fc-corner-left {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    height:50px;
    width: 100px;

    }

.fc-state-default.fc-corner-right {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    height:50px;
    width: 100px;

}
.fc .fc-button-group > * {
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
  height:50px;
  width: 100px;
    float: left;
    margin: 0 0 0 8px;
    font-size: 20px;
}

.fc-today-button {
  visibility: hidden;
}

/* The popup form - hidden by default */
.form-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
</style>
  <script>
  function createCookie(name, value, days) {
    var expires;
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = "; expires=" + date.toGMTString();
    }
    else {
      expires = "";
    }
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
  }

  function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
  }

  function openForm() {
    var fullreturn = getCookie('tasks');
    var splitreturn = fullreturn.split("*");
    document.getElementById("title").innerHTML = splitreturn[0];
    document.getElementById("tasks").innerHTML = splitreturn[1];
    document.getElementById("myForm").style.display = "block";
  }

  function closeForm() {
    document.getElementById("myForm").style.display = "none";
  }

  function removeEvent() {
    var id = getCookie('id')
    $.ajax({
      url:"delete.php",
      type:"POST",
      data:{id:id},
      success:function(error)
      {
      }
    })
    closeForm();
    $('#calendar').fullCalendar( 'refetchEvents' )
  }

  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events: 'load.php',
    selectable:true,
    selectHelper:true,
    select: function(start, end, allDay)
    {
     var title = prompt("Enter Event Title");
     if(title)
     {
      var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
      $.ajax({
       url:"insert.php",
       type:"POST",
       data:{title:title, group:title, start:start, end:end},
       success:function(error)
       {
        calendar.fullCalendar('refetchEvents');
       }
      })
     }
    },
    editable:true,

    eventResize:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function(){
       calendar.fullCalendar('refetchEvents');
      }
     })
    },

    eventDrop:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
      }
     });
    },

    eventClick:function(event)
     {
       var id = event.id;
       $.ajax({
        url:"view.php",
        type:"POST",
        data:{id:id},
        success:function(error)
        {
          calendar.fullCalendar('refetchEvents');
          createCookie("tasks", error, "1");
          createCookie("id", id, "1");
          closeForm();
          openForm();
        }
        })
     },



    });
   });

  </script>

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
           <li><a href="../towel/logpage/viewlog.php">ACTIVITY LOG</a></li>
           <li><a href="../towel/viewtasks.php">TASKS</a></li>
           <li><a href="index.php">MEETINGS</a></li>
           <li><a href="../Dan/performancePage.php">PERFORMANCE</a></li>
           <li><a href="../towel/profile.php">PROFILE</a></li>
           <li><a href="../towel/selectGroup.php">CHANGE GROUP</a></li>
           <li><a href="../towel/logout.php">LOGOUT</a></li>
         </ul>
       </div>
   </nav>
<br>
<br>
<br>
<br>
<br>
<br>


  <div class="container">
   <div id="calendar"></div>
  <div class="form-popup" id="myForm">
  <form id="event" class='form-container'>
    <h1 id="title"></h1>
    <p id = "tasks">This is a task:</p>
    <button type='button' class='btn' onclick="removeEvent()">Delete</button>
    <button type='button' class='btn cancel' onclick='closeForm()'>Close</button>
  </form>
  </div>
  </div>
 </body>
</html>
