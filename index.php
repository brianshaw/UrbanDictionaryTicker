<!doctype html>
<html>
  <head>
  <link href='https://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>
  
<style>
html, body {
  font-family: 'Playfair Display', serif;
  text-align:center;
  height:100%;
  width:100%;
  color:black;
  -webkit-transition: background-color 1000ms linear;
        -moz-transition: background-color 1000ms linear;
        -o-transition: background-color 1000ms linear;
        -ms-transition: background-color 1000ms linear;
        transition: background-color 1000ms linear;
}
#count { 
  position:absolute;
  top:5px;
  left:5px;
  font-size:14px;
}
#stopper { 
  position:absolute;
  top:5px;
  right:15px;
  font-size:24px;
  cursor: pointer;
}
#wrapper {
 text-align:center;
  max-width:1024px;
  margin:100px auto;
  height:100%;
  padding:40px;
}

#word {
  font-size: 80px;
}
#definition{
font-size:36px;
}
</style>


<script type="application/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
<script type="application/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>

<script>
	//

function shuffle(a) {
    var j, x, i;
    for (i = a.length; i; i--) {
        j = Math.floor(Math.random() * i);
        x = a[i - 1];
        a[i - 1] = a[j];
        a[j] = x;
    }
}

var goApp = {
  urbanResults: [],
  nonStopRunning: true,
  isRunning: false,
  shownCount: 0,
  init: function($ctx){
    $.ajax({
      url: "http://api.urbandictionary.com/v0/random", 
      success: function(result){
        goApp.urbanResults = result.list;
        goApp.startCycle();
        goApp.isRunning = true;
        goApp.cycleThrough();
      }
    });
  },
  
  cycleThrough: function() {
    
    //console.log(goApp.urbanResults);
    var currentWord = goApp.urbanResults.shift();
    goApp.shownCount++;
    //console.log(currentWord);
    //console.log(goApp.urbanResults);
    //console.log('ran '+currentWord.word);
   //var color = goApp.randomColor();
    var color = goApp.niceColor();
    //var complement = goApp.invertColor(color);
    $('body').css('background-color', color);
    //$('body').css('color', complement);
    $("#div1 #word").html(currentWord.word);
    $("#div1 #definition").html(currentWord.definition);
    $("#count").text('word count: '+goApp.shownCount);
    if (goApp.urbanResults.length == 0){
      //console.log('stopping');
      goApp.stopAutoLoad();
      if (goApp.nonStopRunning){
        goApp.init($('body'));
      }
    }
  },
  stopAutoLoad: function(){
    goApp.isRunning = false;
    clearTimeout(goApp.runningTimer);
  },
  startCycle: function(){
    //if (!goApp.isRunning){
    //  goApp.cycleThrough();
    //}
    goApp.isRunning = true;
    //goApp.cycleThrough();
    goApp.runningTimer = setInterval('goApp.cycleThrough()', 20000);
  },
  niceColor: function(){
    var rand = goApp.getRandomInt(82,178);
    var colors = [178,82,rand];
    shuffle (colors);
    var theme_color = 'rgb('+colors[0]+','+colors[1]+','+colors[2]+')';
    return theme_color;
  },
  getRandomInt: function(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
  },
  randomColor: function(){
    var color = '#'; // hexadecimal starting symbol
    var letters = ['000000','FF0000','00FF00','0000FF','FFFF00','00FFFF','FF00FF','C0C0C0']; //Set your colors here
    color += letters[Math.floor(Math.random() * letters.length)];
    return color;
  },
  invertColor: function(hexTripletColor) {
      var color = hexTripletColor;
      color = color.substring(1);           // remove #
      color = parseInt(color, 16);          // convert to integer
      color = 0xFFFFFF ^ color;             // invert three bytes
      color = color.toString(16);           // convert to hex
      color = ("000000" + color).slice(-6); // pad with leading zeros
      color = "#" + color;                  // prepend #
      return color;
  }
};

$(document).ready(function(){
  $('#stopper').click(function(){
    if (goApp.isRunning) {
      //goApp.nonStopRunning = false;
      goApp.stopAutoLoad();
      $(this).text('>');
    }else{
      //goApp.nonStopRunning = true;
      goApp.startCycle();
      $(this).text('||');
    }
  });
  
  goApp.init($('body'));
  //goApp.cycleThrough();
  
});

</script>
  </head>
  <body>
    <div id="count"></div>
    <div id="stopper">||</div>
    <div id="wrapper">
      <div id="div1">
        <div id="word" class="animated  bounceIn">Gettin'r Done</div>
        <div id="definition"></div>
      </div>
    </div>
    
  </body>
</html>
