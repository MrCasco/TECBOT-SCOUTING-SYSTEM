<?php
  if(isset($_SERVER["CONTENT_TYPE"])){
    $contentType = trim($_SERVER["CONTENT_TYPE"]);
  }
  //if($contentType === "text/csv"){
    $content = trim(file_get_contents("php://input"));
    echo $content;
  //}

  include "db.php";
  global $con;

  $sql = "insert into match_data_playoffs (matchDataPlayoffs) values('".$content."')";
  $query = mysqli_query($con, $sql);
  echo mysqli_error($con);

  if($query){
    echo 'data inserted succesfully';
  }

  //Variables to access db, specifically, everything from match_data table.
  $sqlMatchData = "SELECT * FROM match_data_playoffs";
  $resMatchData = mysqli_query($con, $sqlMatchData);

  //Arrays that contain all the data from each team, if you want to see the data from (x-number), x-number will be the index inside the array
  //Example: $teamNumber = 254; $totalCargoDrop[$teamNumber] = 9;
  $scores = array();
  $autScores = array();

  //Total times the comment was on
  $disconnections = array();
  $fellDuringMatch = array();
  $didNothing = array();
  $destroyed = array();
  $np = array();
  $helpedClimb = array();
  $def = array();

  //Game pieces
  $totalCargoPerTeam = array();
  $totalHatchPerTeam = array();
  $autTotalCargoPerTeam = array();
  $autTotalHatchPerTeam = array();
  $totalDropHatch = array();
  $totalCargoDrop = array();
  $ceilingHatch = array();
  $ceilingCargo = array();

  //Array that contains each teamNumber in the regional
  $teamNumbers = array();
  $playedMatches = array();

  //Climbing variables
  $parkingPerTeam = array();
  $secondLevelPerTeam = array();
  $thirdLevelPerTeam = array();
  $climbsPerTeam = array();
  $fallsPerTeam = array();
  $climbingScorePerTeam = array();
  $autFirstLevelPerTeam = array();
  $autSecondLevelPerTeam = array();

  //Variables that store the data from the last match
  $individualMatches = -1;
  $autTotalCargo = 0;
  $autTotalHatches = 0;
  $realTotalCargoPerMatch = 0;
  $realTotalHatchesPerMatch = 0;
  $totalHatches = 0;
  $totalCargo = 0;
  $climbingScore = 0;

  //Index of $teamNumbers where increases by 1 each time a new team comes into the db
  $a = 0;

  //String that contains 1 or 0 depending on the comments from the match
  $com1 = "";
  $com2 = "";
  $com3 = "";
  $com4 = "";
  $com5 = "";
  $com6 = "";
  $com7 = "";
  $com8 = "";
  $com9 = "";

  //This is a while that reads everything from the match_data db
  while($row = mysqli_fetch_assoc($resMatchData)){
    list($teamNumber, $match, $levelAuto, $autoScore, $defense, $cargoDrop, $hatchDrop, $scale, $finalScore, $comments) = explode("&", $row['matchDataPlayoffs']);
    list($useless, $com1, $com2, $com3, $com4, $com5, $com6, $com7, $com8, $com9) = explode("_", $comments);
    $individualMatches = $row['playedMatches'];

    $realTotalCargoPerMatch = 0;
    $realTotalHatchesPerMatch = 0;

    if($scale === '1'){
      $climbingScorePerTeam[$teamNumber] = $climbingScorePerTeam[$teamNumber] + 3;
      $parkingPerTeam[$teamNumber]++;
    }
    if($scale === '2'){
      $climbingScorePerTeam[$teamNumber] = $climbingScorePerTeam[$teamNumber] + 6;
      $climbsPerTeam[$teamNumber]++;
      $secondLevelPerTeam[$teamNumber]++;
    }
    if($scale === '3'){
      $climbingScorePerTeam[$teamNumber] = $climbingScorePerTeam[$teamNumber] + 12;
      $climbsPerTeam[$teamNumber]++;
      $thirdLevelPerTeam[$teamNumber]++;
    }

    if($levelAuto === '1'){
      $autFirstLevelPerTeam[$teamNumber]++;
    }
    if($levelAuto === '2'){
      $autSecondLevelPerTeam[$teamNumber]++;
    }

    if($defense === "1"){
      $def[$teamNumber]++;
    }

    if($com1 === '1'){
      $disconnections[$teamNumber]++;
    }

    if($com2 === "1"){
      $np[$teamNumber]++;
    }

    if($com3 === "1"){
      $helpedClimb[$teamNumber]++;
    }

    if($com4 === "1"){
      $fallsPerTeam[$teamNumber]++;
    }

    if($com5 === "1"){
      $didNothing[$teamNumber]++;
    }

    if($com6 === "1"){
      $destroyed[$teamNumber]++;
    }

    if($com7 === "1"){
      $fellDuringMatch[$teamNumber]++;
    }

    $totalDropHatch[$teamNumber] = $totalDropHatch[$teamNumber] + $hatchDrop;
    if($com8 === "1"){
      $totalDropHatch[$teamNumber]++;
    }

    $totalCargoDrop[$teamNumber] = $totalCargoDrop[$teamNumber] + $cargoDrop;
    if($com9 === "1"){
      $totalCargoDrop[$teamNumber]++;
    }

    $autScores[0] = strtok($autoScore, "_");
    $autScores[1] = strtok("_");
    $autScores[2] = strtok("_");
    $autScores[3] = strtok("_");
    $autScores[4] = strtok("_");
    $autScores[5] = strtok("_");
    $autScores[6] = strtok("_");
    $autScores[7] = strtok("_");
    $autScores[8] = strtok("_");
    $autScores[9] = strtok("_");
    $autScores[10] = strtok("_");
    $autScores[11] = strtok("_");
    $autScores[12] = strtok("_");
    $autScores[13] = strtok("_");
    $autScores[14] = strtok("_");
    $autScores[15] = strtok("_");
    $autScores[16] = strtok("_");
    $autScores[17] = strtok("_");
    $autScores[18] = strtok("_");
    $autScores[19] = strtok("_");
    $autScores[20] = strtok("_");

    foreach ($autScores as $s) {
      if($s === "1" || $s === "3"){
        $autTotalHatches = 0;
        $autTotalCargo = 0;

        if($s === "3"){
          $autTotalHatches++;
          $autTotalHatchPerTeam[$teamNumber] = $autTotalHatches + $autTotalHatchPerTeam[$teamNumber];
          $autTotalCargo++;
          $autTotalCargoPerTeam[$teamNumber] = $autTotalCargo + $autTotalCargoPerTeam[$teamNumber];
        }
        else{
          $autTotalHatches++;
          $autTotalHatchPerTeam[$teamNumber] = $autTotalHatches + $autTotalHatchPerTeam[$teamNumber];
        }
      }
      if($s === "2"){
        $autTotalCargo++;
        $autTotalCargoPerTeam[$teamNumber] = $autTotalCargo;
      }
    }

    $scores[0] = strtok($finalScore, "_");
    $scores[1] = strtok("_");
    $scores[2] = strtok("_");
    $scores[3] = strtok("_");
    $scores[4] = strtok("_");
    $scores[5] = strtok("_");
    $scores[6] = strtok("_");
    $scores[7] = strtok("_");
    $scores[8] = strtok("_");
    $scores[9] = strtok("_");
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
      $totalHatches = 0;
      $totalCargo = 0;

      if($s === "1" || $s === "3"){
        if($s === "3"){
          $realTotalCargoPerMatch++;
          $realTotalHatchesPerMatch++;

          $totalHatches++;
          $totalHatchPerTeam[$teamNumber] = $totalHatches + $totalHatchPerTeam[$teamNumber];
          $totalCargo++;
          $totalCargoPerTeam[$teamNumber] += $totalCargo;
        }
        else{
          $realTotalHatchesPerMatch++;
          $totalHatches++;
          $totalHatchPerTeam[$teamNumber] = $totalHatches + $totalHatchPerTeam[$teamNumber];
        }
      }
      if($s === "2"){
        $realTotalCargoPerMatch++;
        $totalCargo++;
        $totalCargoPerTeam[$teamNumber] += $totalCargo;
      }
    }

    $exists = checkExistence($teamNumbers, $teamNumber);

    if(empty($teamNumbers)){
      $teamNumbers[0] = $teamNumber;
      $playedMatches[$teamNumber] = 1;
      $a++;
      $ceilingCargo[$teamNumber] = $realTotalCargoPerMatch;
      $ceilingHatch[$teamNumber] = $realTotalHatchesPerMatch;
    }
    elseif($exists){
      $playedMatches[$teamNumber]++;
      if($ceilingHatch[$teamNumber] < $realTotalHatchesPerMatch){
        $ceilingHatch[$teamNumber] = $realTotalHatchesPerMatch;
      }
      if($ceilingCargo[$teamNumber] < $realTotalCargoPerMatch){
        $ceilingCargo[$teamNumber] = $realTotalCargoPerMatch;
      }
    }
    elseif(!$exists){
      $playedMatches[$teamNumber] = 1;
      $teamNumbers[$a] = $teamNumber;
      $a++;
      $ceilingCargo[$teamNumber] = $realTotalCargoPerMatch;
      $ceilingHatch[$teamNumber] = $realTotalHatchesPerMatch;
    }
  }
  
  plugNewData($con, $playedMatches, $teamNumber, $disconnections, $np, $def, $totalCargoDrop, $totalDropHatch, $totalCargoPerTeam, $totalHatchPerTeam, $autTotalCargoPerTeam, $autTotalHatchPerTeam, $climbsPerTeam, $climbingScorePerTeam, $parkingPerTeam, $secondLevelPerTeam, $thirdLevelPerTeam, $helpedClimb, $fallsPerTeam, $didNothing, $destroyed, $fellDuringMatch,
              $autFirstLevelPerTeam, $autSecondLevelPerTeam, $ceilingCargo, $ceilingHatch);

  function plugNewData($con, $playedMatches, $teamNumber, $disconnections, $np, $def, $totalCargoDrop, $totalDropHatch, $totalCargoPerTeam, $totalHatchPerTeam, $autTotalCargoPerTeam, $autTotalHatchPerTeam, $climbsPerTeam, $climbingScorePerTeam, $parkingPerTeam, $secondLevelPerTeam, $thirdLevelPerTeam, $helpedClimb, $fallsPerTeam, $didNothing, $destroyed, $fellDuringMatch,
                       $autFirstLevelPerTeam, $autSecondLevelPerTeam, $ceilingCargo, $ceilingHatch){

    $sqlRankingData = "SELECT * FROM ranking_data_playoffs WHERE teamNumber = $teamNumber";
    $resRankingData = mysqli_query($con, $sqlRankingData);

    $avgAutHatch = $autTotalHatchPerTeam[$teamNumber] / $playedMatches[$teamNumber];
    $avgAutCargo = $autTotalCargoPerTeam[$teamNumber] / $playedMatches[$teamNumber];

    $avgClimb = $climbsPerTeam[$teamNumber] / $playedMatches[$teamNumber];

    $avgDropCargo = $totalCargoDrop[$teamNumber] / $playedMatches[$teamNumber];
    $avgDropHatch = $totalDropHatch[$teamNumber] / $playedMatches[$teamNumber];

    $totalCargoToPlug = $totalCargoPerTeam[$teamNumber];
    $totalHatchesToPlug = $totalHatchPerTeam[$teamNumber];

    $avgCargoToPlug = $totalCargoToPlug / $playedMatches[$teamNumber];
    $avgHatchToPlug = $totalHatchesToPlug / $playedMatches[$teamNumber];

    if($row = mysqli_fetch_assoc($resRankingData) ){
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET avgCargo=$avgCargoToPlug WHERE teamNumber=$teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET disconnections=$disconnections[$teamNumber] WHERE teamNumber=$teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET np=$np[$teamNumber] WHERE teamNumber=$teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET def=$def[$teamNumber] WHERE teamNumber=$teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET avgDropHatch=$avgDropHatch WHERE teamNumber=$teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET avgDropCargo=$avgDropCargo WHERE teamNumber=$teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET totalHatches=$totalHatchesToPlug WHERE teamNumber=$teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET totalCargo=$totalCargoToPlug WHERE teamNumber=$teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET playedMatches=$playedMatches[$teamNumber] WHERE teamNumber=$teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET avgHatch = $avgHatchToPlug WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET autTotalCargo = $autTotalCargo[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET autTotalHatches = $autTotalHatches[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET avgAutCargo = $avgAutCargo WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET avgAutHatch = $avgAutHatch WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET avgClimb = $avgClimb WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET totalClimbs = $climbsPerTeam[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET totalClimbingScore = $climbingScorePerTeam[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET totalParking = $parkingPerTeam[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET totalLevelTwo = $secondLevelPerTeam[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET totalLevelThree = $thirdLevelPerTeam[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET fell = $fallsPerTeam[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET didNothing = $didNothing[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET destroyed = $destroyed[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET helpedClimb = $helpedClimb[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET fellDuringMatch = $fellDuringMatch[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET autFirstLevel = $autFirstLevelPerTeam[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET autSecondLevel = $autSecondLevelPerTeam[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET ceilCargo = $ceilingCargo[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
      $sqlUpdateData = "UPDATE ranking_data_playoffs SET ceilHatch = $ceilingHatch[$teamNumber] WHERE teamNumber = $teamNumber";
      $query = mysqli_query($con, $sqlUpdateData);
    }
    else{
      $sqlNewData = "
        insert into ranking_data_playoffs (teamNumber, playedMatches, avgCargo, avgHatch, np, disconnections, def, avgDropCargo, avgDropHatch, totalHatches, totalCargo, autTotalCargo, autTotalHatches, avgClimb, totalClimbs, totalClimbingScore, totalParking, totalLevelTwo, totalLevelThree, fell, didNothing, destroyed, helpedClimb, fellDuringMatch, avgAutCargo, avgAutHatch, autFirstLevel, autSecondLevel, ceilHatch, ceilCargo)
        values('".$teamNumber."', '".$playedMatches[$teamNumber]."', '".$avgCargoToPlug."', '".$avgHatchToPlug."', '".$np[$teamNumber]."', '".$disconnections[$teamNumber]."', '".$def[$teamNumber]."', '".$avgDropCargo."',
        '".$avgDropHatch."', '".$totalHatchesToPlug."', '".$totalCargoToPlug."', '".$autTotalCargo[$teamNumber]."', '".$autTotalHatches[$teamNumber]."', '".$avgClimb."', '".$climbsPerTeam[$teamNumber]."', '".$climbingScorePerTeam[$teamNumber]."', '".$parkingPerTeam[$teamNumber]."', '".$secondLevelPerTeam[$teamNumber]."',
        '".$thirdLevelPerTeam[$teamNumber]."', '".$fallsPerTeam[$teamNumber]."', '".$didNothing[$teamNumber]."', '".$destroyed[$teamNumber]."', '".$helpedClimb[$teamNumber]."', '".$fellDuringMatch[$teamNumber]."', '".$avgAutCargo."', '".$avgAutHatch."', '".$autFirstLevelPerTeam[$teamNumber]."', '".$autSecondLevelPerTeam[$teamNumber].
        "','".$ceilingHatch[$teamNumber]."','".$ceilingCargo[$teamNumber]."')";

      $query = mysqli_query($con, $sqlNewData);
    }
  }

  function checkExistence($teamNumbers, $teamNumber){
    $exists = false;
    for($i = 0; $i < count($teamNumbers); $i++){
      $t = $teamNumbers[$i];
      if($t === $teamNumber){
        return true;
      }
    }
    return $exists;
  }
 ?>
