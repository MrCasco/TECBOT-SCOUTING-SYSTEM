<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="jquery-1.6.4.min.js"></script>
    <script src="jquery-1.11.3.min.js"></script>
    <script src="jquery.mobile-1.4.5.min.js"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
    <link href="fonts.css" rel="stylesheet">
    <title>SCOUTING</title>
</head>
<body>
  <?php
    foreach ($_POST as $post_var) {
      echo mb_strtoupper($post_var) . "<br />";
    }
  ?>
  <div id="screen">
      <div id="startContainer">
        <h3> Enter Team Number:</h3>
        <textarea maxlength="4" placeholder="0000" id="taTeam" cols="4" rows="2"></textarea>
        <h3>Match: </h3>
        <textarea maxlength="5" placeholder="000" id="match" cols="4" rows="2"></textarea>
        <div id="buttonStart" onclick="startGame()">Start</div>
      </div>

      <div id="frame" class="figure">

        <div id="teamInfo">

          <div id="teamNumberContainer">
            <h3 id="teamNumber"> Team Number:</h3>
          </div>

          <div id="teamNumberContainer">
            <h3 id="matchNumber"> Match:</h3>
          </div>

          <div id="stage">
            <div id="readyEndgame" onclick="displayComments()">Ready</div>
            <h3 id="stagePeriodText">Period: </h3>
            <h4 id="currentPeriod">Sandstorm</h4>
          </div>

          <div id="time">
            <h3>Time:</h3>
            <h4 id="timer">2:30</h4>
          </div>

        </div>

        <div id="field">
          <div class="rocket figure teleopContent">
            <div class="rocket-col">
              <div id="LR_LU" class="rocket-level figure teleopContent target"></div>
              <div id="LR_LM" class="rocket-level figure teleopContent target"></div>
              <div id="LR_LD" class="rocket-level figure teleopContent target"></div>
            </div>
            <div class="rocket-col">
              <div id="LR_RU" class="rocket-level figure teleopContent target"></div>
              <div id="LR_RM" class="rocket-level figure teleopContent target"></div>
              <div id="LR_RD" class="rocket-level figure teleopContent target"></div>
            </div>
          </div>
          <div id="cargoShip" class="figure teleopContent">
            <div class="cargo-side">
              <div id="C_L1" class="cargobay figure teleopContent target"></div>
              <div id="C_L2" class="cargobay figure teleopContent target"></div>
              <div id="C_L3" class="cargobay figure teleopContent target"></div>
              <div id="C_L4" class="cargobay figure teleopContent target"></div>
            </div>
            <div class="cargo-side">
              <div id="C_R1" class="cargobay figure teleopContent target"></div>
              <div id="C_R2" class="cargobay figure teleopContent target"></div>
              <div id="C_R3" class="cargobay figure teleopContent target"></div>
              <div id="C_R4" class="cargobay figure teleopContent target"></div>
            </div>
          </div>
          <div class="rocket figure teleopContent">
            <div class="rocket-col">
              <div id="RR_LU" class="rocket-level figure teleopContent target"></div>
              <div id="RR_LM" class="rocket-level figure teleopContent target"></div>
              <div id="RR_LD" class="rocket-level figure teleopContent target"></div>
            </div>
            <div class="rocket-col">
              <div id="RR_RU" class="rocket-level figure teleopContent target"></div>
              <div id="RR_RM" class="rocket-level figure teleopContent target"></div>
              <div id="RR_RD" class="rocket-level figure teleopContent target"></div>
            </div>
          </div>
        </div>

        <div id="sandstorm" class="gamePeriodBar">
          <h3>Auto Period Cross:</h3>
          <div class="buttonSandstorm buttonSandstormActive" id="noCross" onclick="setSandstormValue('noCross')"><a href="">None</a></div>
          <div class="buttonSandstorm" id="levelOneCross" onclick="setSandstormValue('levelOneCross')"><a href="">Level 1</a></div>
          <div class="buttonSandstorm" id="levelTwoCross" onclick="setSandstormValue('levelTwoCross')"><a href="">Level 2</a></div>
        </div>
        <div id="teleop" class="gamePeriodBar">
          <div class="buttonTeleop" id="btn-df">
            <div class="buttonDefense" onclick="setDefense()">
              Defense
            </div>
          </div>
          <div class="buttonTeleop">
            <div class="minus" id="mn-hatch" onclick="setDroppedHatchValue('mn-hatch')">-</div>
            <div class="buttonText" id="btn-hatchDrop">Hatch Drop: 0</div>
            <div class="plus" id="pl-hatch" onclick="setDroppedHatchValue('pl-hatch')">+</div>
          </div>
          <div class="buttonTeleop">
            <div class="minus" id="mn-cg" onclick="setDroppedCargoValue('mn-cg')">-</div>
            <div class="buttonText" id="btn-cargoDrop">Cargo Drop: 0</div>
            <div class="plus" id="pl-cg" onclick="setDroppedCargoValue('pl-cg')">+</div>
          </div>
        </div>

        <div id="endgame" class="gamePeriodBar">
          <h3>Climb: </h3>
          <div class="buttonEndgame" id="noScale" onclick="setScaleValue('noScale')">No</div>
          <div class="buttonEndgame" id="park" onclick="setScaleValue('park')">Park</div>
          <div class="buttonEndgame" id="levelTwo" onclick="setScaleValue('levelTwo')">Level 2</div>
          <div class="buttonEndgame" id="levelThree" onclick="setScaleValue('levelThree')">Level 3</div>
        </div>

        <div id="finalFeedback">
          <div id="COM1" class="comment">Se desconect&oacute</div>
          <div id="COM2" class="comment">No se present&oacute</div>
          <div id="COM3" class="comment">Ayud&oacute a escalar a otro robot</div>
          <div id="COM4" class="comment">Se cay&oacute intentando escalar</div>
          <div id="COM5" class="comment">No se movi&oacute</div>
          <div id="COM6" class="comment">Se le cay&oacute parte del robot</div>
          <div id="COM7" class="comment">Se cay&oacute durante match</div>
          <div id="COM8" class="comment">Hatch drop despu&eacutes 30s</div>
          <div id="COM9" class="comment">Cargo drop despu&eacutes 30s</div>
          <div id="buttonSubmit" onclick="submitData()">Submit</div>
        </div>
      </div>
    </div>
  </body>
</html>
