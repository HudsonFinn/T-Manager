<?php
/* When run this will check if tables exist and if they do not will create them
for each table it first uses a query to see if the table exists, if it does then
it will display 'TABLE table already exists' if it doesn't it will create it and
display 'TABLE table created'*/
include("connectDatabase.php");
//Querys the database with the below instruction
$sql = 'SELECT 1 FROM `users`';
// If the table doesn't exist then when queried it will return False
if (($conn->query($sql)) !== False) {
  #Query evalueated to True
  echo('User table already exists');
  echo "<br>";
  }
else {
  #Query evaluated to False
  echo('User table created');
  echo "<br>";
  #Instruction to create a table
  $sql = "CREATE TABLE users (
    userID int unsigned auto_increment,
    userName VARCHAR(40) not null unique,
    firstName VARCHAR(40) not null,
    lastName VARCHAR(40) not null,
    password VARCHAR(40) not null,
    email VARCHAR(40) not null,
    PRIMARY KEY (userID)
  )";
  #Querys the database and will display any errors that occour.
  if (!($conn->query($sql)))
    echo("Error: " . $conn->error);
  };

$sql = 'SELECT 1 FROM `groups`';
if (($conn->query($sql)) !== False) {
  echo('Groups table already exists');
  echo "<br>";
  }
else {
  echo('Groups table created');
  echo "<br>";
  $sql = "CREATE TABLE groups (
    groupID int unsigned auto_increment,
    name VARCHAR(40) not null,
    password VARCHAR(40) not null,
    PRIMARY KEY (groupID)
  )";
  if (!($conn->query($sql)))
    echo("Error: " . $conn->error);
  };

$sql = 'SELECT 1 FROM `tasks`';
if (($conn->query($sql)) !== False) {
  echo('Tasks table already exists');
  echo "<br>";
  }
else {
  echo('Tasks table created');
  echo "<br>";
  $sql = "CREATE TABLE tasks (
    taskID int unsigned auto_increment,
    parentTask int unsigned,
    name VARCHAR(40) not null,
    description VARCHAR(100),
    creator VARCHAR(40) not null,
    pointValue int,
    deadline datetime,
    userID int unsigned,
    PRIMARY KEY (taskID),
    FOREIGN KEY (userID) REFERENCES users(userID)
  )";
  if (!($conn->query($sql)))
    echo("Error: " . $conn->error);
  };

$sql = 'SELECT 1 FROM `meetings`';
if (($conn->query($sql)) !== False) {
  echo('Meetings table already exists');
  echo "<br>";
  }
else {
  echo('Meetings table created');
  echo "<br>";
  $sql = "CREATE TABLE meetings (
    meetingID int unsigned auto_increment,
    name VARCHAR(40) not null,
    meetingDate datetime not null,
    creator VARCHAR(40),
    description VARCHAR (100),
    groupID int unsigned,
    FOREIGN KEY (groupID) REFERENCES groups(groupID),
    PRIMARY KEY (meetingID)
  )";
  if (!($conn->query($sql)))
    echo("Error: " . $conn->error);
  };

$sql = 'SELECT 1 FROM `comments`';
if (($conn->query($sql)) !== False) {
  echo('Comments table already exists');
  echo "<br>";
  }
else {
  echo('Comments table created');
  echo "<br>";
  $sql = "CREATE TABLE comments (
    commentID int unsigned auto_increment,
    commentDate datetime not null,
    creator VARCHAR(40),
    content VARCHAR (100),
    taskID int unsigned,
    userID int unsigned,
    FOREIGN KEY (taskID) REFERENCES tasks(taskID),
    FOREIGN KEY (userID) REFERENCES users(userID),
    PRIMARY KEY (commentID)
  )";
  if (!($conn->query($sql)))
    echo("Error: " . $conn->error);
  };

$sql = 'SELECT 1 FROM `userGroup`';
if (($conn->query($sql)) !== False) {
  echo('userGroup table already exists');
  echo "<br>";
  }
else {
  echo('userGroup table created');
  echo "<br>";
  $sql = "CREATE TABLE userGroup (
    points int unsigned,
    groupID int unsigned,
    userID int unsigned,
    FOREIGN KEY (groupID) REFERENCES groups(groupID),
    FOREIGN KEY (userID) REFERENCES users(userID),
    PRIMARY KEY (userID, groupID)
  )";
  if (!($conn->query($sql)))
    echo("Error: " . $conn->error);
  };
