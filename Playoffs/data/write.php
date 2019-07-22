<?php

  $taTeam = $_GET['taTeam'];
  $write = "";
  $useless = "";
  $totalCargo = 0;
  $totalHatches = 0;

  $scores = array();
  $autScores = array();

  include "../db/db.php";
  global $con;

  $sql = "SELECT * FROM match_data_playoffs";
  $res = mysqli_query($con, $sql);

  echo "match".","."totalHatches".","."totalCargo <br>";

  while($row = mysqli_fetch_assoc($res)){

    $totalHatches = 0;
    $totalCargo = 0;

    list($teamNumber, $match, $levelAuto, $autoScore, $defense, $cargoDrop, $hatchDrop, $scale, $finalScore, $comments) = explode("&", $row['matchDataPlayoffs']);

    $scores[0]  = strtok($finalScore, "_");
    $scores[1]  = strtok("_");
    $scores[2]  = strtok("_");
    $scores[3]  = strtok("_");
    $scores[4]  = strtok("_");
    $scores[5]  = strtok("_");
    $scores[6]  = strtok("_");
    $scores[7]  = strtok("_");
    $scores[8]  = strtok("_");
    $scores[9]  = strtok("_");
    $scores[10] = strtok("_");
    $scores[11] = strtok("_");
    $scores[12] = strtok("_");
    $scores[13] = strtok("_");
    $scores[14] = strtok("_");
    $scores[15] = strtok("_");
    $scores[16] = strtok("_");
    $scores[17] = strtok("_");
    $scores[18] = strtok("_");
    $scores[19] = strtok("_");
    $scores[20] = strtok("_");

    foreach ($scores as $s) {
      if($s === "1" || $s === "3"){
        if($s === "3"){
          $totalHatches++;
          $totalCargo++;
        }
        else{
          $totalHatches++;
        }
      }
      if($s === "2"){
        $totalCargo++;
      }
      $score = $match.",".$totalHatches.",".$totalCargo;
    }

    if($taTeam === $teamNumber){
      echo $score . "<br>";
    }
  }
  mysqli_close($con);
?>
