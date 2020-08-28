<?php
include("connectDatabase.php");
$sql = 'SELECT 1 FROM `users`';
if (($conn->query($sql)) !== False) {
  echo('User table already exists');
  echo "<br>";
  }
else {
  echo('User table created');
  echo "<br>";
  #Instruction to create a table
  $sql = "CREATE TABLE `users` (
  `USER_ID` VARCHAR(255) NOT NULL ,
  `firstName` VARCHAR(40) NOT NULL,
  `lastName` VARCHAR(40) NOT NULL,
  `password` VARCHAR(40) NOT NULL,
  `email` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`USER_ID`))
  ENGINE = InnoDB;
  ";
  if (!($conn->query($sql)))
    echo("Error: " . $conn->error);
  };


$sql = 'SELECT 1 FROM `teams`';
if (($conn->query($sql)) !== False) {
  echo('Teams table already exists');
  echo "<br>";
  }
else {
  echo('Teams table created');
  echo "<br>";
  #Instruction to create a table
  $sql = "CREATE TABLE `teams` (
  `TEAM_ID` VARCHAR(255) NOT NULL ,
  `team` VARCHAR(255) NOT NULL ,
  `password` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`TEAM_ID`))
  ENGINE = InnoDB;
  ";
  if (!($conn->query($sql)))
    echo("Error: " . $conn->error);
  };


$sql = 'SELECT 1 FROM `user_teams`';
if (($conn->query($sql)) !== False) {
  echo('User_teams table already exists');
  echo "<br>";
  }
else {
  echo('User_teams table created');
  echo "<br>";
  #Instruction to create a table
  $sql = "CREATE TABLE `user_teams` (
  `USER_ID` VARCHAR(255) NOT NULL ,
  `TEAM_ID` VARCHAR(255) NOT NULL ,
  `points` int unsigned,
  PRIMARY KEY (`USER_ID`, `TEAM_ID`))
  ENGINE = InnoDB;
  ";
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
  #Instruction to create a table
  $sql = "CREATE TABLE `tasks` (
  `TASK_ID` VARCHAR(255) NOT NULL ,
  `USER_ID` VARCHAR(255) NOT NULL ,
  `TEAM_ID` VARCHAR(255) NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  `points` int NOT NULL ,
  `desc` VARCHAR(255) NOT NULL,
  `deadline` int NOT NULL,
  `status` VARCHAR(255) NOT NULL,
  `date_created` int NOT NULL,
  `date_submitted` int NOT NULL,
  PRIMARY KEY (`TASK_ID`))
  ENGINE = InnoDB;
  ";
  if (!($conn->query($sql)))
    echo("Error: " . $conn->error);
  };


$sql = 'SELECT 1 FROM `subtasks`';
if (($conn->query($sql)) !== False) {
  echo('SubTasks table already exists');
  echo "<br>";
  }
else {
  echo('Subtasks table created');
  echo "<br>";
  #Instruction to create a table
  $sql = "CREATE TABLE `subtasks` (
  `SUB_ID` VARCHAR(255) NOT NULL ,
  `parent` VARCHAR(255) NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`SUB_ID`))
  ENGINE = InnoDB;
  ";
  if (!($conn->query($sql)))
    echo("Error: " . $conn->error);
  };


$sql = 'SELECT 1 FROM `user_subs`';
if (($conn->query($sql)) !== False) {
  echo('user_subs table already exists');
  echo "<br>";
  }
else {
  echo('user_subs table created');
  echo "<br>";
  #Instruction to create a table
  $sql = "CREATE TABLE `user_subs` (
  `USER_SUBS_ID` VARCHAR(255) NOT NULL ,
  `SUB_ID` VARCHAR(255) NOT NULL ,
  `USER_ID` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`USER_SUBS_ID`))
  ENGINE = InnoDB;
  ";
  if (!($conn->query($sql)))
    echo("Error: " . $conn->error);
  };



$sql = 'SELECT 1 FROM `chat`';
if (($conn->query($sql)) !== False) {
  echo('chat table already exists');
  echo "<br>";
  }
else {
  echo('chat table created');
  echo "<br>";
  #Instruction to create a table
  $sql = "CREATE TABLE `chat` (
  `MES_ID` VARCHAR(255) NOT NULL ,
  `SUB_ID` VARCHAR(255) NOT NULL ,
  `USER_ID` VARCHAR(255) NOT NULL ,
  `message` VARCHAR(255) NOT NULL ,
  `timestamp` int NOT NULL,
  PRIMARY KEY (`MES_ID`))
  ENGINE = InnoDB;
  ";
  if (!($conn->query($sql)))
    echo("Error: " . $conn->error);
  };




$sql = 'SELECT 1 FROM `logs`';
if (($conn->query($sql)) !== False) {
  echo('logs table already exists');
  echo "<br>";
  }
else {
  echo('logs table created');
  echo "<br>";
  #Instruction to create a table
  $sql = "CREATE TABLE `logs` (
  `LOG_ID` VARCHAR(255) NOT NULL ,
  `type` VARCHAR(255) NOT NULL ,
  `ACTION_ID` VARCHAR(255) NOT NULL ,
  `TEAM_ID` VARCHAR(255) NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`LOG_ID`))
  ENGINE = InnoDB;
  ";
  if (!($conn->query($sql)))
    echo("Error: " . $conn->error);
  };


$sql = 'SELECT 1 FROM `taskbuffer`';
if (($conn->query($sql)) !== False) {
  echo('taskbuffer table already exists');
  echo "<br>";
  }
else {
  echo('taskbuffer table created');
  echo "<br>";
  #Instruction to create a table
  $sql = "CREATE TABLE `taskbuffer` (
  `ACTION_ID` VARCHAR(255) NOT NULL ,
  `USER_ID` VARCHAR(255) NOT NULL ,
  `TEAM_ID` VARCHAR(255) NOT NULL ,
  `taskname` VARCHAR(255) NOT NULL ,
  `sum` int NOT NULL ,
  `votes` int NOT NULL ,
  `deadline` int NOT NULL ,
  `desc` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`ACTION_ID`))
  ENGINE = InnoDB;
  ";
  if (!($conn->query($sql)))
    echo("Error: " . $conn->error);
  };


$sql = 'SELECT 1 FROM `has_voted`';
if (($conn->query($sql)) !== False) {
  echo('has_voted table already exists');
  echo "<br>";
  }
else {
  echo('has_voted table created');
  echo "<br>";
  #Instruction to create a table
  $sql = "CREATE TABLE `has_voted` (
  `VOTE_ID` int unsigned auto_increment,
  `USER_ID` VARCHAR(255) NOT NULL ,
  `ACTION_ID` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`VOTE_ID`))
  ENGINE = InnoDB;
  ";
  if (!($conn->query($sql)))
    echo("Error: " . $conn->error);
  };
