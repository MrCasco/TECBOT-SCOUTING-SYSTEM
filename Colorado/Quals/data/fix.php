<html>

  <head>
    <title>Fix</title>
  </head>

  <body>
    <?php

    include "../db/db.php";
    global $con;

    echo "A is the good team";
    echo "B is the bad team";
    $data = $_GET;

    $fromTeams = explode("," , $data["A"]);
    $badTeams = explode(",",$data["B"] );

    $fields = array();
    array_push($fields, array('playedMatches',0));
    array_push($fields, array('avgCargo',1));
    array_push($fields, array('avgHatch',1));
    array_push($fields, array('np',0));
    array_push($fields, array('disconnections',0));
    array_push($fields, array('def',0));
    array_push($fields, array('avgDropCargo',1));
    array_push($fields, array('avgDropHatch',1));
    array_push($fields, array('totalHatches',0));
    array_push($fields, array('totalCargo',0));
    array_push($fields, array('autTotalCargo',0));
    array_push($fields, array('autTotalHatches',0));
    array_push($fields, array('avgClimb',1));
    array_push($fields, array('totalClimbs',0));
    array_push($fields, array('totalClimbingScore',0));
    array_push($fields, array('totalParking',0));
    array_push($fields, array('totalLevelTwo',0));
    array_push($fields, array('totalLevelThree',0));
    array_push($fields, array('fell',0));
    array_push($fields, array('didNothing',0));
    array_push($fields, array('destroyed',0));
    array_push($fields, array('helpedClimb',0));
    array_push($fields, array('fellDuringMatch',0));
    array_push($fields, array('avgAutCargo',1));
    array_push($fields, array('avgAutHatch',1));
    array_push($fields, array('autFirstLevel',0));
    array_push($fields, array('autSecondLevel',0));


    for( $i = 0; $i < count($fromTeams) ; $i++){
      fixMatch($con, $fromTeams[$i] , $badTeams[$i], $fields);
    }

    mysqli_close($con);


    function fixMatch($con, $A, $B, $fields){

      echo "Im fixing $A and $B <br/>";
      $sqlMatchData = "SELECT * FROM ranking_data WHERE teamNumber IN ($A, $B)";
      $resMatchData = mysqli_query($con, $sqlMatchData);

      $rowA = mysqli_fetch_assoc($resMatchData);
      $rowB = mysqli_fetch_assoc($resMatchData);
      $rowC = $rowA;

      $updateSql = "";
      for($i = 0; $i < count($fields) ; $i++){
        if($fields[$i][1] == 0){ // update count
          $rowC[$fields[$i][0]] = $rowA[$fields[$i][0]] + $rowB[$fields[$i][0]];
        }
        else{ // update average
          $a = $rowA[$fields[$i][0]];
          $b = $rowB[$fields[$i][0]];
          $totalMatches = $rowA[$fields[0][0]] + $rowB[$fields[0][0]];
          $rowC[$fields[$i][0]] = round( $a*($totalMatches-1)/$totalMatches + $b/$totalMatches , 6 );
        }
        $updateSql .= ", ".$fields[$i][0]." ='".   $rowC[$fields[$i][0]] . "'";
      }

        $finalSql = ("UPDATE ranking_data SET id=".$rowA['id'] . $updateSql . " WHERE teamNumber = '" . $rowA['teamNumber'] . "'" );

        $finalSql2 = "DELETE FROM ranking_data WHERE id=".$rowB['id'];

        //echo $finalSql;

        mysqli_query($con,$finalSql);

        mysqli_query($con,$finalSql2);
        //echo mysqli_error($con);

        if(!mysqli_error($con)){
          echo "Update was succesful";
        }
        else {
          echo "<br/>error";
        }
    }
    ?>

  </body>
</html>
