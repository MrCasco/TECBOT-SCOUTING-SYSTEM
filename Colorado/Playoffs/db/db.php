<?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  $db = 'colorado';

  $con = mysqli_connect($host, $user, $pass, $db);
  if(!$con){
    die('cant connect to database');
    exit();
  }
?>
