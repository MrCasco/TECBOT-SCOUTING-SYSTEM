<?php
  echo "
  <div><br></div>
  <h1 class = 'title' style = 'text-align:center'>QUALIFICATIONS</h1>
  <form action='rankings.php' method='post'>
    <div>
      <br>
    </div>
    <br>
    <div class='control' style='text-align:center'>
      <button class='button is-primary' name='hatch/cargo' value='Auto Hatch'>Auto Hatch</button>
      <button class='button is-primary' name='hatch/cargo' value='Auto Cargo'>Auto Cargo</button>

      <button class='button is-primary' name='hatch/cargo' value='hatch'>Hatch</button>
      <button class='button is-primary' name='hatch/cargo' value='cargo'>Cargo</button>

      <button class='button is-primary' name='hatch/cargo' value='scorer'>Climbing Score</button>
      <button class='button is-primary' name='hatch/cargo' value='avgClimber'>Climbing Effectiveness</button>
      <button class='button is-primary' name='hatch/cargo' value='other'>Other Comments</button>
    </div>
  </form>";
  $toDisplay = $_REQUEST['hatch/cargo'];
  echo "
    <div style='text-align:center'>
      <a href = '../db/write_ranking_csv.php?toDisplay=" . $toDisplay . "'class='button is-success'>Write CSV</a>
    </div>";
  echo "<h1 class='subtitle' style='font-size:30px'>Displaying by top ".$toDisplay." team</h1>";

  if($toDisplay == "cargo" || $toDisplay === "hatch"){
    echo "
    <table class='table'>
      <thead>
        <tr>
          <th><abbr>Pos</abbr></th>
          <th>Team</th>
          <th><abbr>Pld</abbr></th>
          <th><abbr>Avg ".$toDisplay."</abbr></th>
          <th><abbr>Ceiling ".$toDisplay."</abbr></th>
          <th><abbr>Drop ".$toDisplay."</abbr></th>
          <th><abbr>Didnt show</abbr></th>
          <th><abbr>Def</abbr></th>
          <th><abbr>Disconnection</abbr></th>
        </tr>
      </thead>
    </table>";
  }
  elseif($toDisplay === "Auto Hatch" || $toDisplay === "Auto Cargo"){
    echo "
    <table class='table'>
      <thead>
        <tr>
          <th><abbr>Pos</abbr></th>
          <th>Team</th>
          <th><abbr>Pld</abbr></th>
          <th><abbr>Avg ".$toDisplay."</abbr></th>
          <th><abbr>First Level</abbr></th>
          <th><abbr>Second Level</abbr></th>
        </tr>
      </thead>
    </table>";
  }
  elseif($toDisplay === "scorer"){
    echo "
    <table class='table'>
      <thead>
        <tr>
          <th><abbr>Pos</abbr></th>
          <th>Team</th>
          <th><abbr>Pld</abbr></th>
          <th><abbr>ClimbingScore</abbr></th>
          <th><abbr>Fell</abbr></th>
          <th><abbr>Helped Climbing</abbr></th>
          <th><abbr>Parking</abbr></th>
          <th><abbr>Level 2</abbr></th>
          <th><abbr>Level 3</abbr></th>
        </tr>
      </thead>
    </table>";
  }
  elseif($toDisplay === "avgClimber"){
    echo "
    <table class='table'>
      <thead>
        <tr>
          <th><abbr>Pos</abbr></th>
          <th>Team</th>
          <th><abbr>Pld</abbr></th>
          <th><abbr>Effectiveness</abbr></th>
          <th><abbr>Fell</abbr></th>
          <th><abbr>Helped Climbing</abbr></th>
          <th><abbr>Parking</abbr></th>
          <th><abbr>Level 2</abbr></th>
          <th><abbr>Level 3</abbr></th>
        </tr>
      </thead>
    </table>";
  }
  else{
    echo "
    <table class='table'>
      <thead>
        <tr>
          <th><abbr>Pos</abbr></th>
          <th>Team</th>
          <th><abbr>Pld</abbr></th>
          <th><abbr>Did nothing</abbr></th>
          <th><abbr>Robot breaking down</abbr></th>
          <th><abbr>Fell During Match</abbr></th>
        </tr>
      </thead>
    </table>";
  }


  include "db.php";
  global $con;
  $i = 0;

  if($toDisplay === "hatch"){

    $sqlRankingData = "SELECT * FROM ranking_data ORDER BY ranking_data . avgHatch DESC ";
    $resRankingData = mysqli_query($con, $sqlRankingData);

    while ($row = mysqli_fetch_assoc($resRankingData)) {
      $teamNumber = $row['teamNumber'];
      $individualMatches = $row['playedMatches'];
      $avgHatch = number_format($row['avgHatch'], 1);
      $ceilingHatch = $row['ceilHatch'];
      $avgDropHatch = number_format($row['avgDropHatch'], 1);
      $com1 = $row['disconnections'];
      $np = $row['np'];
      $def = $row['def'];
      $i++;

      if(strlen($individualMatches) == 1){
        $individualMatches = $individualMatches . "&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 3){
        $teamNumber = $teamNumber . "&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 2){
        $teamNumber = $teamNumber . "&nbsp&nbsp&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 1){
        $teamNumber = "&nbsp&nbsp&nbsp&nbsp&nbsp".$teamNumber;
      }
      if(strlen($i) < 2){
        $teamNumber = "&nbsp&nbsp".$teamNumber;
      }
      echo "
      <table class='table'>
        <tr>
          <td><b>".$i."</b></td>
          <td>".$teamNumber."<td>
          <td>".$individualMatches."<td>
          <td>".$avgHatch."<td>
          <td>&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$ceilingHatch."<td>
          <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$avgDropHatch."<td>
          <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$np."</td>
          <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$def."</td>
          <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$com1."</td>
        </tr>
      </table>";
    }
  }

  if($toDisplay === "cargo"){
    $sqlRankingData = "SELECT * FROM ranking_data ORDER BY ranking_data . avgCargo DESC ";
    $resRankingData = mysqli_query($con, $sqlRankingData);

    while ($row = mysqli_fetch_assoc($resRankingData)) {
      $teamNumber = $row['teamNumber'];
      $individualMatches = $row['playedMatches'];
      $avgCargo = number_format($row['avgCargo'], 1);
      $ceilingCargo = $row['ceilCargo'];
      $avgDropCargo = number_format($row['avgDropCargo'], 1);
      $com1 = $row['disconnections'];
      $np = $row['np'];
      $def = $row['def'];
      $i++;

      if(strlen($individualMatches) == 1){
        $individualMatches = $individualMatches . "&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 3){
        $teamNumber = $teamNumber . "&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 2){
        $teamNumber = $teamNumber . "&nbsp&nbsp&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 1){
        $teamNumber = "&nbsp&nbsp&nbsp&nbsp&nbsp".$teamNumber;
      }
      if(strlen($i) < 2){
        $teamNumber = "&nbsp&nbsp".$teamNumber;
      }

      echo "
      <table class='table'>
        <tr>
          <td><b>".$i."</b></td>
          <td>".$teamNumber."<td>
          <td>".$individualMatches."<td>
          <td>".$avgCargo."<td>
          <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$ceilingCargo."<td>
          <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$avgDropCargo."<td>
          <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$np."</td>
          <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$def."</td>
          <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$com1."</td>
        </tr>
      </table>";
    }
  }

  if($toDisplay === "scorer"){

    $sqlRankingData = "SELECT * FROM ranking_data ORDER BY ranking_data . totalClimbingScore DESC ";
    $resRankingData = mysqli_query($con, $sqlRankingData);

    while ($row = mysqli_fetch_assoc($resRankingData)) {
      $teamNumber = $row['teamNumber'];
      $individualMatches = $row['playedMatches'];
      $climbingScore = $row['totalClimbingScore'];
      $parking = $row['totalParking'];
      $levelTwo = $row['totalLevelTwo'];
      $levelThree = $row['totalLevelThree'];
      $helpedClimb = $row['helpedClimb'];
      $fell = $row['fell'];
      $i++;

      if(strlen($individualMatches) == 1){
        $individualMatches = $individualMatches . "&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 3){
        $teamNumber = $teamNumber . "&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 2){
        $teamNumber = $teamNumber . "&nbsp&nbsp&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 1){
        $teamNumber = "&nbsp&nbsp&nbsp&nbsp&nbsp".$teamNumber;
      }
      if(strlen($i) < 2){
        $teamNumber = "&nbsp&nbsp".$teamNumber;
      }
      echo "
      <table class='table'>
        <tr>
          <td><b>".$i."</b></td>
          <td>".$teamNumber."<td>
          <td>".$individualMatches."<td>
          <td>&nbsp</td>
          <td>".$climbingScore."</td>
          <td>&nbsp</td>
          <td>&nbsp</td>
          <td>".$fell."</td>
          <td>&nbsp</td>
          <td>&nbsp</td>
          <td>".$helpedClimb."</td>
          <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
          <td>&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$parking."</td>
          <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$levelTwo."</td>
          <td>&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$levelThree."</td>
        </tr>
      </table>";
    }
  }
  if($toDisplay === "avgClimber"){

    $sqlRankingData = "SELECT * FROM ranking_data ORDER BY ranking_data . avgClimb DESC ";
    $resRankingData = mysqli_query($con, $sqlRankingData);

    while ($row = mysqli_fetch_assoc($resRankingData)) {
      $teamNumber = $row['teamNumber'];
      $individualMatches = $row['playedMatches'];
      $avgClimb = number_format($row['avgClimb'], 1);
      $parking = $row['totalParking'];
      $levelTwo = $row['totalLevelTwo'];
      $levelThree = $row['totalLevelThree'];
      $helpedClimb = $row['helpedClimb'];
      $fell = $row['fell'];
      $i++;

      if(strlen($individualMatches) == 1){
        $individualMatches = $individualMatches . "&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 3){
        $teamNumber = $teamNumber . "&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 2){
        $teamNumber = $teamNumber . "&nbsp&nbsp&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 1){
        $teamNumber = "&nbsp&nbsp&nbsp&nbsp&nbsp".$teamNumber;
      }
      if(strlen($i) < 2){
        $teamNumber = "&nbsp&nbsp".$teamNumber;
      }
      echo "
      <table class='table'>
        <tr>
          <td><b>".$i."</b></td>
          <td>".$teamNumber."<td>
          <td>".$individualMatches."&nbsp&nbsp&nbsp<td>
          <td>".$avgClimb."</td>
          <td>&nbsp</td>
          <td>&nbsp</td>
          <td>".$fell."</td>
          <td>&nbsp</td>
          <td>&nbsp</td>
          <td>".$helpedClimb."</td>
          <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
          <td>&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$parking."</td>
          <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$levelTwo."</td>
          <td>&nbsp&nbsp&nbsp&nbsp</td>
          <td>".$levelThree."</td>
        </tr>
      </table>";
    }
  }

  if($toDisplay === "other"){

    $sqlRankingData = "SELECT * FROM ranking_data ORDER BY ranking_data . destroyed DESC ";
    $resRankingData = mysqli_query($con, $sqlRankingData);

    while ($row = mysqli_fetch_assoc($resRankingData)) {
      $teamNumber = $row['teamNumber'];
      $individualMatches = $row['playedMatches'];
      $didNothing = $row['didNothing'];
      $destroyed = $row['destroyed'];
      $fellDuringMatch = $row['fellDuringMatch'];
      $i++;

      if(strlen($individualMatches) == 1){
        $individualMatches = $individualMatches . "&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 3){
        $teamNumber = $teamNumber . "&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 2){
        $teamNumber = $teamNumber . "&nbsp&nbsp&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 1){
        $teamNumber = "&nbsp&nbsp&nbsp&nbsp&nbsp".$teamNumber;
      }
      if(strlen($i) < 2){
        $teamNumber = "&nbsp&nbsp".$teamNumber;
      }
      echo "
      <table class='table'>
        <tr>
          <td><b>".$i."</b></td>
          <td>".$teamNumber."<td>
          <td>".$individualMatches."&nbsp&nbsp&nbsp&nbsp<td>
          <td>".$didNothing."<td>
          <td>&nbsp</td>
          <td>&nbsp</td>
          <td>&nbsp&nbsp</td>
          <td>".$destroyed."<td>
          <td>&nbsp</td>
          <td>&nbsp&nbsp</td>
          <td>&nbsp</td>
          <td>&nbsp</td>
          <td>".$fellDuringMatch."</td>
        </tr>
      </table>";
    }
  }

  if($toDisplay === "Auto Cargo"){
    $sqlRankingData = "SELECT * FROM ranking_data ORDER BY ranking_data . avgAutCargo DESC ";
    $resRankingData = mysqli_query($con, $sqlRankingData);

    while ($row = mysqli_fetch_assoc($resRankingData)) {
      $teamNumber = $row['teamNumber'];
      $individualMatches = $row['playedMatches'];
      $avgAutCargo = number_format($row['avgAutCargo'], 1);
      $autFirstLevel   = $row['autFirstLevel'];
      $autSecondLevel   = $row['autSecondLevel'];
      $i++;

      if(strlen($individualMatches) == 1){
        $individualMatches = $individualMatches . "&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 3){
        $teamNumber = $teamNumber . "&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 2){
        $teamNumber = $teamNumber . "&nbsp&nbsp&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 1){
        $teamNumber = "&nbsp&nbsp&nbsp&nbsp&nbsp".$teamNumber;
      }
      if(strlen($i) < 2){
        $teamNumber = "&nbsp&nbsp".$teamNumber;
      }

      echo "
      <table class='table'>
        <tr>
          <td><b>".$i."</b></td>
          <td>".$teamNumber."<td>
          <td>".$individualMatches."<td>
          <td>&nbsp</td>
          <td>".$avgAutCargo."<td>
          <td>&nbsp</td>
          <td>&nbsp</td>
          <td>".$autFirstLevel."<td>
          <td>&nbsp</td>
          <td>&nbsp</td>
          <td>".$autSecondLevel."<td>
        </tr>
      </table>";
    }
  }

  if($toDisplay === "Auto Hatch"){
    $sqlRankingData = "SELECT * FROM ranking_data ORDER BY ranking_data . avgAutHatch DESC ";
    $resRankingData = mysqli_query($con, $sqlRankingData);

    while ($row = mysqli_fetch_assoc($resRankingData)) {
      $teamNumber = $row['teamNumber'];
      $individualMatches = $row['playedMatches'];
      $avgAutHatch = number_format($row['avgAutHatch'], 1);
      $autFirstLevel   = $row['autFirstLevel'];
      $autSecondLevel   = $row['autSecondLevel'];
      $i++;

      if(strlen($individualMatches) == 1){
        $individualMatches = $individualMatches . "&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 3){
        $teamNumber = $teamNumber . "&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 2){
        $teamNumber = $teamNumber . "&nbsp&nbsp&nbsp&nbsp";
      }
      if(strlen($teamNumber) === 1){
        $teamNumber = "&nbsp&nbsp&nbsp&nbsp&nbsp".$teamNumber;
      }
      if(strlen($i) < 2){
        $teamNumber = "&nbsp&nbsp".$teamNumber;
      }

      echo "
      <table class='table'>
        <tr>
          <td><b>".$i."</b></td>
          <td>".$teamNumber."<td>
          <td>".$individualMatches."<td>
          <td>&nbsp</td>
          <td>".$avgAutHatch."<td>
          <td>&nbsp</td>
          <td>&nbsp</td>
          <td>".$autFirstLevel."<td>
          <td>&nbsp</td>
          <td>&nbsp</td>
          <td>".$autSecondLevel."<td>
        </tr>
      </table>";
    }
  }

  if($i === 0){
    echo "No data was found in the database lol";
  }
  mysqli_close($con);
?>
