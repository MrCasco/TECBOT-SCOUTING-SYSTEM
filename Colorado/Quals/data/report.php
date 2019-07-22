<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../bulma/css/bulma.css">
    <title>Report</title>
  </head>
  <body>
    <div>
      <br>
    </div>
    <h1 style="font-size:40px; text-align:center">Search by team number</h1>
    <div><br/></div>
    <form action="report.php" method="post">
      <input width="300px" name="taTeam" class="input is-rounded" type="text" placeholder="Team number">
      <div>
        <br>
      </div>
      <div class="control" style="text-align:center">
        <button type="submit" class="button is-primary">Search</button>
        <div class="button is-success" style="text-align:center">
          <a style="color:white" href="write.php?taTeam=<?php echo $_REQUEST['taTeam'] ?>">Write CSV</a>
        </div>
      </div>
    </form>

    <?php
      include "../db/db.php";
      global $con;

      $sql = "SELECT * FROM match_data";
      $res = mysqli_query($con, $sql);
      $taTeam = $_REQUEST['taTeam'];
      $i = 0;
      $useless = 0;

      //Left rocket variables
      $ALR_LU;
      $ALR_LM;
      $ALR_LD;
      $ALR_RU;
      $ALR_RM;
      $ALR_RD;

      //Right rocket variables
      $ARR_LU = 0;
      $ARR_LM = 0;
      $ARR_LD = 0;
      $ARR_RU = 0;
      $ARR_RM = 0;
      $ARR_RD = 0;

      //Cargo ship Variables
      $AC_L1 = 0;
      $AC_L2 = 0;
      $AC_L3 = 0;
      $AC_L4 = 0;
      $AC_R1 = 0;
      $AC_R2 = 0;
      $AC_R3 = 0;
      $AC_R4 = 0;

      //Left rocket variables
      $LR_LU;
      $LR_LM;
      $LR_LD;
      $LR_RU;
      $LR_RM;
      $LR_RD;

      //Right rocket variables
      $RR_LU = 0;
      $RR_LM = 0;
      $RR_LD = 0;
      $RR_RU = 0;
      $RR_RM = 0;
      $RR_RD = 0;

      //Cargo ship Variables
      $C_L1 = 0;
      $C_L2 = 0;
      $C_L3 = 0;
      $C_L4 = 0;
      $C_R1 = 0;
      $C_R2 = 0;
      $C_R3 = 0;
      $C_R4 = 0;

      $com1 = "";
      $com2 = "";
      $com3 = "";
      $com4 = "";
      $com5 = "";
      $com6 = "";

      echo "<h1 class='title is-1'>Team ".$taTeam." performance:</h1><br/>";

      while($row = mysqli_fetch_assoc($res)){
        $i++;
        list($teamNumber, $match, $levelAuto, $autoScore, $defense, $cargoDrop, $hatchDrop, $scale, $finalScore, $comments) = explode("&", $row['matchData']);
        list($useless, $ALR_LU, $ALR_LM, $ALR_LD, $ALR_RU, $ALR_RM, $ALR_RD, $ARR_LU, $ARR_LM, $ARR_LD, $ARR_RU, $ARR_RM, $ARR_RD, $AC_L1, $AC_L2, $AC_L3, $AC_L4, $AC_R1, $AC_R2, $AC_R3, $AC_R4) = explode("_", $autoScore);
        list($useless, $LR_LU, $LR_LM, $LR_LD, $LR_RU, $LR_RM, $LR_RD, $C_L1, $C_L2, $C_L3, $C_L4, $C_R1, $C_R2, $C_R3, $C_R4, $RR_LU, $RR_LM, $RR_LD, $RR_RU, $RR_RM, $RR_RD) = explode("_", $finalScore);
        list($useless, $com1, $com2, $com3, $com4, $com5, $com6) = explode("_", $comments);
        if($taTeam === $teamNumber){
          echo "<table class='table table is-hoverable' border='2'>
                  <tr>
                    <th> Match </th>
                    <th> Level Auto </th>
                    <th> ALR_LU </th>
                    <th> ALR_LM </th>
                    <th> ALR_LD </th>
                    <th> ALR_RU </th>
                    <th> ALR_RM </th>
                    <th> ALR_RD </th>

                    <th> ARR_LU </th>
                    <th> ARR_LM </th>
                    <th> ARR_LD </th>
                    <th> ARR_RU </th>
                    <th> ARR_RM </th>
                    <th> ARR_RD </th>
                  </tr>

                  <tr>
                    <td>".$match."</td>
                    <td>".$levelAuto."</td>

                    <td>".$ALR_LU."</td>
                    <td>".$ALR_LM."</td>
                    <td>".$ALR_LD."</td>
                    <td>".$ALR_RU."</td>
                    <td>".$ALR_RM."</td>
                    <td>".$ALR_RD."</td>

                    <td>".$ARR_LU."</td>
                    <td>".$ARR_LM."</td>
                    <td>".$ARR_LD."</td>
                    <td>".$ARR_RU."</td>
                    <td>".$ARR_RM."</td>
                    <td>".$ARR_RD."</td>
                  </tr>

                  <tr>
                    <th> AC_L4 </th>
                    <th> AC_L3 </th>
                    <th> AC_L2 </th>
                    <th> AC_L1 </th>
                    <th> AC_R4 </th>
                    <th> AC_R3 </th>
                    <th> AC_R2 </th>
                    <th> AC_R1 </th>

                    <th> LR_LU </th>
                    <th> LR_LM </th>
                    <th> LR_LD </th>
                    <th> LR_RU </th>
                    <th> LR_RM </th>
                    <th> LR_RD </th>
                  </tr>

                  <tr>
                    <td>".$AC_L1."</td>
                    <td>".$AC_L2."</td>
                    <td>".$AC_L3."</td>
                    <td>".$AC_L4."</td>
                    <td>".$AC_R1."</td>
                    <td>".$AC_R2."</td>
                    <td>".$AC_R3."</td>
                    <td>".$AC_R4."</td>

                    <td>".$LR_LU."</td>
                    <td>".$LR_LM."</td>
                    <td>".$LR_LD."</td>
                    <td>".$LR_RU."</td>
                    <td>".$LR_RM."</td>
                    <td>".$LR_RD."</td>
                  </tr>

                  <tr>
                    <th> RR_LU </th>
                    <th> RR_LM </th>
                    <th> RR_LD </th>
                    <th> RR_RU </th>
                    <th> RR_RM </th>
                    <th> RR_RD </th>

                    <th> C_L4 </th>
                    <th> C_L3 </th>
                    <th> C_L2 </th>
                    <th> C_L1 </th>
                    <th> C_R4 </th>
                    <th> C_R3 </th>
                    <th> C_R2 </th>
                    <th> C_R1 </th>
                  </tr>

                  <tr>
                    <td>".$RR_LU."</td>
                    <td>".$RR_LM."</td>
                    <td>".$RR_LD."</td>
                    <td>".$RR_RU."</td>
                    <td>".$RR_RM."</td>
                    <td>".$RR_RD."</td>

                    <td>".$C_L1."</td>
                    <td>".$C_L2."</td>
                    <td>".$C_L3."</td>
                    <td>".$C_L4."</td>
                    <td>".$C_R1."</td>
                    <td>".$C_R2."</td>
                    <td>".$C_R3."</td>
                    <td>".$C_R4."</td>
                  </tr>

                  <tr>
                    <th> Defense </th>
                    <th> Cargo Drop </th>
                    <th> Hatch Drop </th>
                    <th> Scale </th>

                    <th> C1 </th>
                    <th> C2 </th>
                    <th> C3 </th>
                    <th> C4 </th>
                    <th> C5 </th>
                    <th> C6 </th>
                  </tr>

                  <tr>
                    <td>".$defense."</td>
                    <td>".$cargoDrop."</td>
                    <td>".$hatchDrop."</td>
                    <td>".$scale."</td>

                    <td>".$com1."</td>
                    <td>".$com2."</td>
                    <td>".$com3."</td>
                    <td>".$com4."</td>
                    <td>".$com5."</td>
                    <td>".$com6."</td>
                  </tr>
                </table>";
        }
      }

      if($i === 0){
        echo "No data at database<br/><br/>";
      }

      mysqli_close($con);
    ?>
  </body>
</html>
