<?php
  include "db.php";
  global $con;

  $sqlRankingData = "SELECT * FROM ranking_data";
  $resRankingData = mysqli_query($con, $sqlRankingData);

  $toDisplay = $_GET['toDisplay'];

  
?>
