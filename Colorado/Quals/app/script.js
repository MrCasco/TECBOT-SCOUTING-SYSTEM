var teamNumber = 0000;
var match = 000;
var levelAuto = 0;
var autoScore = 0;
var defense = 0;
var cargoDrop = 0;
var hatchDrop = 0;
var scale = 0;
var finalScore="";
var heightDev;
var scoreToSend = false;

var comments="";
$(document).ready(function() {
    heightDev = $(window).height();
    $("#screen").css({'height': heightDev+"px" });
});

$(function(){
    // Bind the swipeHandler callback function to the swipe event on div.box
    $(".target").on("swipeleft",swipeHatch );
    $(".target").on("swiperight",swipeCargo );
    $(".target").on("swipedown",swipeComplete );
    $(".target").on("swipeup",swipeClear );
    $(".comment").on("click", setComments);

    function addComments(id,param) {
        commentsArray[id] = param;
    }

    function setComments(event) {
        if (commentsArray[event.target.id] == 0) {
            addComments(event.target.id,1);
            $(event.target).addClass('commentSelected');
        } else {
            addComments(event.target.id,0);
            $(event.target).removeClass('commentSelected');
        }
    }

    function setControlArray(id,param){
        //console.log(id + " : " + param);
        controlArray[id] = param;
    }

    // Callback function references the event target and adds the 'swipe' class to it
    function swipeHatch( event ){
        $(event.target).removeClass("cargo");
        $(event.target).removeClass("completed");
        $(event.target).addClass( "hatch" );
        //console.log(event.target.id);
        setControlArray(event.target.id,1);

    }
    function swipeCargo( event ){
        $(event.target).removeClass("hatch");
        $(event.target).removeClass("completed");
        $(event.target).addClass("cargo");
        //console.log(event.target.id);
        setControlArray(event.target.id,2);
    }
    function swipeComplete( event ){
        $(event.target).removeClass("hatch");
        $(event.target).removeClass("cargo");
        $(event.target).addClass("completed");
        //console.log(event.target.id);
        setControlArray(event.target.id,3);
    }
    function swipeClear(event) {
        $(event.target).removeClass("hatch");
        $(event.target).removeClass("cargo");
        $(event.target).removeClass("completed");
        //console.log(event.target.id);
        setControlArray(event.target.id,0);
    }
});


function startTimer() {
    var timer2 = "02:30";
    var interval = setInterval(function() {
    var timer = timer2.split(':');
    var minutes = parseInt(timer[0], 10);
    var seconds = parseInt(timer[1], 10);
    var currentStatus = "Sandstorm";
    var colorHex = ['#5cb85c','#f0ad4e','#d9534f','black'];

    //Timer
    --seconds;
    minutes = (seconds < 0) ? --minutes : minutes;
    if (minutes < 0) clearInterval(interval);
    seconds = (seconds < 0) ? 59 : seconds;
    seconds = (seconds < 10) ? '0' + seconds : seconds;
    $('#timer').html(minutes + ':' + seconds);
    timer2 = minutes + ':' + seconds;

    if(currentStatus == "Sandstorm"){
        $('body').css({'background-color':colorHex[0]})
        $('#sandstorm').css({'display':'flex'});
        $('#teleop').css({'display':'none'});
        $('#endgame').css({'display':'none'});
    }
    var i = 0;
    if ((minutes <= 2 && seconds <= 15) || (minutes == 1 && seconds <= 59) || (minutes == 0 && seconds>30)) {
        if (minutes >= 2 && seconds >= 15 && !scoreToSend){
            scoreToSend = true;
            for(var elem in controlArray){
              autoScore+="_"+controlArray[elem];
            }
        }
        currentStatus = "Teleop"
        $('#currentPeriod').html(currentStatus); //Set Teleop
        $('#sandstorm').css({'display':'none'});
        $('#teleop').css({'display':'flex'});
        $('#endgame').css({'display':'none'});
        $('body').css({'background-color':colorHex[1]})
    }
    if (minutes == 0 && seconds <= 30) {
        currentStatus = "Endgame"
        $('#currentPeriod').html(currentStatus); //Set Teleop
        $('#sandstorm').css({'display':'none'});
        $('#teleop').css({'display':'none'});
        $('#endgame').css({'display':'flex'});
        $('body').css({'background-color':colorHex[2]})
    }
    if (seconds == 59 && minutes == -1) {
        $('#timer').html("Finished");
        currentStatus = "Finished";
        $('#currentPeriod').html(currentStatus); //Set Endgame
        $('#sandstorm').css({'display':'none'});
        $('#teleop').css({'display':'none'});
        $('#endgame').css({'display':'flex'});
        $('.buttonEndgame').css({'background-color':'black'});
        $('.buttonEndgame').css({'color':'white'});
        $('body').css({'background-color':colorHex[3]});
        $('#stagePeriodText').css({'display':'none'});
        $('#currentPeriod').css({'display':'none'});
        $('#readyEndgame').css({'display':'flex'});
    }
  }, 1000);
}

function displayComments(){
    $('#field').css({"display":'none'});
    $('#endgame').css({"display":'none'});
    $('#field').css({'display':'none'});
    $('#finalFeedback').css({'display':'flex'});
    $('#time').css({'display':'none'});
    $('#readyEndgame').css({'display':'none'});
}

function startGame() {
    $("#screen").css({'height': (heightDev-30)+"px" });
    startTimer();
    $('#startContainer').css({'display': 'none'});
    $('#frame').css({'display': 'flex'});

    teamNumber = document.getElementById("taTeam").value;
    $('#teamNumber').html("Team Number  : " + teamNumber);
    match = document.getElementById("match").value;
    $('#matchNumber').html("Match: " + match);
}

var supportTouch = $.support.touch,
    scrollEvent = "touchmove scroll",
    touchStartEvent = supportTouch ? "touchstart" : "mousedown",
    touchStopEvent = supportTouch ? "touchend" : "mouseup",
    touchMoveEvent = supportTouch ? "touchmove" : "mousemove";
    $.event.special.swipeupdown = {
        setup: function() {
            var thisObject = this;
            var $this = $(thisObject);
            $this.bind(touchStartEvent, function(event) {
                var data = event.originalEvent.touches ?
                        event.originalEvent.touches[ 0 ] :
                        event,
                        start = {
                            time: (new Date).getTime(),
                            coords: [ data.pageX, data.pageY ],
                            origin: $(event.target)
                        },
                        stop;

                function moveHandler(event) {
                    if (!start) {
                        return;
                    }
                    var data = event.originalEvent.touches ?
                            event.originalEvent.touches[ 0 ] :
                            event;
                    stop = {
                        time: (new Date).getTime(),
                        coords: [ data.pageX, data.pageY ]
                    };

                    // prevent scrolling
                    if (Math.abs(start.coords[1] - stop.coords[1]) > 10) {
                        event.preventDefault();
                    }
                }
                $this
                        .bind(touchMoveEvent, moveHandler)
                        .one(touchStopEvent, function(event) {
                    $this.unbind(touchMoveEvent, moveHandler);
                    if (start && stop) {
                        if (stop.time - start.time < 1000 &&
                                Math.abs(start.coords[1] - stop.coords[1]) > 30 &&
                                Math.abs(start.coords[0] - stop.coords[0]) < 75) {
                            start.origin
                                    .trigger("swipeupdown")
                                    .trigger(start.coords[1] > stop.coords[1] ? "swipeup" : "swipedown");
                        }
                    }
                    start = stop = undefined;
                });
            });
        }
    };
    $.each({
        swipedown: "swipeupdown",
        swipeup: "swipeupdown"
    }, function(event, sourceEvent){
        $.event.special[event] = {
            setup: function(){
                $(this).bind(sourceEvent, $.noop);
            }
        };
    });

/// Score Manager
var controlArray = {'LR_LU':0,'LR_LM':0,'LR_LD':0,'LR_RU':0,'LR_RM':0,'LR_RD':0,'C_L1':0,'C_L2':0,'C_L3':0,'C_L4':0,'C_R1':0,'C_R2':0,'C_R3':0,'C_R4':0,'RR_LU':0,'RR_LM':0,'RR_LD':0,'RR_RU':0,'RR_RM':0,'RR_RD':0};
var commentsArray = {'COM1':0,'COM2':0,'COM3':0,'COM4':0,'COM5':0,'COM6':0,'COM7':0,'COM8':0};

//Update Variables values.
function setSandstormValue(id) {
    if(id == "levelOneCross"){
        $('#levelTwoCross').removeClass('buttonSandstormActive');
        $('#noCross').removeClass('buttonSandstormActive');
        $('#levelOneCross').addClass('buttonSandstormActive');
        levelAuto = 1;
    }
    if (id == "levelTwoCross") {
        $('#levelOneCross').removeClass('buttonSandstormActive');
        $('#noCross').removeClass('buttonSandstormActive');
        $('#levelTwoCross').addClass('buttonSandstormActive');
        levelAuto = 2;
    }
    if(id == "noCross"){
        $('#levelTwo').removeClass('buttonSandstormActive');
        $('#levelOneCross').removeClass('buttonSandstormActive');
        $('#noCross').addClass('buttonSandstormActive');
        levelAuto = 0;
    }
}

function setDefense() {
    if (defense == 0) {
        $("#btn-df").addClass('buttonTeleopActive');
        defense = 1;
    }else{
        $("#btn-df").removeClass('buttonTeleopActive');
        defense = 0;
    }
    //console.log(defense);
}

function setDroppedHatchValue(id) {
    var btnHTText = $("#btn-hatchDrop").html().split(":");
    hatchDrop = btnHTText[1];
    if(id == "mn-hatch" && hatchDrop>=1){
        hatchDrop--;
    }
    if (id == "pl-hatch") {
        hatchDrop++;
    }
    $("#btn-hatchDrop").html("Hatch Drop:"+hatchDrop);
}

function setDroppedCargoValue(id) {
    var btnCGText = $("#btn-cargoDrop").html().split(":");
    cargoDrop = btnCGText[1];
    if(id == "mn-cg" && cargoDrop>=1){
        cargoDrop--;
    }
    if (id == "pl-cg") {
        cargoDrop++;
    }
    $("#btn-cargoDrop").html("Cargo Drop:"+cargoDrop);
}

function setScaleValue(id) {
    if(id == "noScale"){
        $('#levelThree').removeClass('buttonFinishedActive');
        $('#levelTwo').removeClass('buttonFinishedActive');
        $('#park').removeClass('buttonFinishedActive');
        $('#noScale').addClass('buttonFinishedActive');
        scale = 0;
    }
    if (id == "park") {
        $('#levelThree').removeClass('buttonFinishedActive');
        $('#levelTwo').removeClass('buttonFinishedActive');
        $('#park').addClass('buttonFinishedActive');
        $('#noScale').removeClass('buttonFinishedActive');
        scale = 1;
    }
    if(id == "levelTwo"){
        $('#levelThree').removeClass('buttonFinishedActive');
        $('#levelTwo').addClass('buttonFinishedActive');
        $('#park').removeClass('buttonFinishedActive');
        $('#noScale').removeClass('buttonFinishedActive');
        scale = 2;
    }
    if(id == "levelThree"){
        $('#levelThree').addClass('buttonFinishedActive');
        $('#levelTwo').removeClass('buttonFinishedActive');
        $('#park').removeClass('buttonFinishedActive');
        $('#noScale').removeClass('buttonFinishedActive');
        scale = 3;
    }
}



function submitData(){
    for(var elem in controlArray){
        finalScore+="_"+controlArray[elem];
    }
    for(var comment in commentsArray){
        comments+="_"+commentsArray[comment];
    }

    var finalData = teamNumber+"&"+match+"&"+levelAuto+"&"+autoScore+"&"+defense+"&"+cargoDrop+"&"+hatchDrop+"&"+scale+"&"+finalScore+"&"+comments;
    //console.log(finalData);

    fetch("../db/results.php", {
      method: "POST",
      mode: "same-origin",
      credentials: "same-origin",
      headers: {
        "Content-Type": "text/csv"
      },
      body: finalData
    });
    alert("Data Submitted");
}
