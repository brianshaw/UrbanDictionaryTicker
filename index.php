<!doctype html>
<html>
  <head>
	  <title>Urban Dictionary Ticker</title>
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
  margin:0;
  padding:0;
}
#count { 
  position:absolute;
  top:5px;
  left:5px;
  font-size:14px;
  line-height: 34px;
  width:34px;
  height: 38px;
  background: rgba(255,255,255,0.4);
}
#stopper { 
  position:absolute;
  top:5px;
  right:15px;
  font-size:24px;
  cursor: pointer;
  line-height: 34px;
  width:34px;
  height: 38px;
  background: rgba(255,255,255,0.4);
}
#wrapper {
 text-align:center;
  max-width:1024px;
  margin:0 auto;
  height:100%;
  padding:0px;
}
#div1 {
	height:90%;
	padding-top:5%;
}
#word {
  font-size: 80px;
  height:20%;
  width:100%;
}
#definition{
	font-size:36px;
	height:80%;
	width: 100%;
}
#definition span {
	width: 100%;
    height: 100%;
    display: block;
}


.words {
  position: fixed;
    top: 50px;
    left: 0;
    right: 0;
    bottom: 0;
    overflow: scroll;
    /* padding-bottom: 150px; */
    background: green;
}

.words ul {
  padding-bottom: 50px
}
.words li {
  list-style:none;
  padding:5px;
  margin: 5px;
  font-size:24px;
  overflow-y: scroll;
}

#app {
  
}

html, body {
  height: 100%;
  width: 100%;
}

.noscroll { 
  overflow: hidden;
}

</style>



  </head>
  <body>

<div id="app">
  <div id="count" v-on:click="showHistory = !showHistory" >{{ count }}</div>
  <div id="stopper"><span v-if="isRunning" v-on:click="isRunning = !isRunning">||</span><span v-if="!isRunning" v-on:click="isRunning = !isRunning">&gt;</span></div>
    <div id="wrapper">
      <div id="div1">
        <div id="word" class="animated  bounceIn">{{ word }}</div>
        <div id="definition">{{ definition }}</div>
      </div>
    </div>
  <div class="words" v-if="showHistory && !isRunning">
  <ul >
    <li v-for="def in allResults" v-on:click="getDefById(def.defid)">
      {{ def.word }}
    </li>
  </ul>
  </div>
</div>
    
    
    <script type="application/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
<script type="application/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<script src="https://unpkg.com/vue"></script>
<script type="application/javascript" src="flowtype.js"></script>
<script>

var isRunning = false;
var runningTimer = 0;
var UDapp = new Vue({
  el: '#app',
  data: {
    isRunning: false,
    runningTimer: 0,
    urbanResults: [],
    allResults: [],
    currentTerm: '',
    word: '',
    definition: '',
    count: 0,
    cycleTime:20000, // 20000,
    showHistory: false
  },
  watch: {
    urbanResults: function(nV, oV){
      if (nV.length == 0){
        this.getMore();
      }else{
        //this.cycle();
      }
    },
    currentTerm: function (newValue, oldValue){
      //console.log(newValue);
      //if (typeof newValue == 'undefined'){
      //  this.getMore();
      //}else{
        this.word = this.currentTerm.word;
        this.definition = this.currentTerm.definition;
      //}
      
    },
    isRunning: function (nV, oV){
      //console.log(nV);
      if (!nV){
          clearTimeout(this.runningTimer);
      }else{
          //this.runningTimer = setInterval('cycle()', 20000);
          if (this.count == 0){
            this.cycle();
          }
          this.runningTimer = setInterval(function(){
            this.cycle();
          }.bind(this),this.cycleTime);
      }
    },
    showHistory: function(nV, oV){
      if (nV){
        this.isRunning = false;
      }
      $('body').toggleClass('noscroll', nV);
    }
  },
  mounted() {
    var self = this;
    //
    this.getMore();
    //this.getDefById(1388173);
    //toggleCycle();
  },
  methods: {
    getMore: function(){
      $.ajax({
        url: "https://api.urbandictionary.com/v0/random", 
        success: function(result){
          UDapp.urbanResults = result.list;
          //UDapp.allResults = UDapp.allResults.concat(UDapp.urbanResults);
          //goApp.startCycle();
          //goApp.isRunning = true;
          //goApp.cycleThrough();
          UDapp.isRunning = true;
          //cycle();
        }
      });
    },
    cycle: function(){
      this.count += 1;
      this.currentTerm = this.urbanResults.shift();
      UDapp.allResults.unshift({ 
         defid: this.currentTerm.defid, 
        word: this.currentTerm.word 
      });
      //console.log(this.currentTerm);
      this.isRunning = true;
      var color = niceColor();
      //var complement = goApp.invertColor(color);
      $('body').css('background-color', color);
    },
    getDefById: function(defid){
      // 1388173
      //console.log(defid);
      
      $.ajax({
        url: "https://api.urbandictionary.com/v0/define?defid="+defid, 
        success: function(result){
          //console.log(result.list[0]);
          this.isRunning = false;
          this.currentTerm = result.list[0];
          this.showHistory = false;
          //UDapp.urbanResults = result.list;
          //UDapp.allResults = UDapp.allResults.concat(UDapp.urbanResults);
          //UDapp.isRunning = true;
        }.bind(this)
      });
    }
  }
});


function niceColor(){
    var rand = getRandomInt(82,178);
    var colors = [178,82,rand];
    shuffle (colors);
    var theme_color = 'rgb('+colors[0]+','+colors[1]+','+colors[2]+')';
    return theme_color;
  }
function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
  }
function randomColor(){
    var color = '#'; // hexadecimal starting symbol
    var letters = ['000000','FF0000','00FF00','0000FF','FFFF00','00FFFF','FF00FF','C0C0C0']; //Set your colors here
    color += letters[Math.floor(Math.random() * letters.length)];
    return color;
  }
 function invertColor(hexTripletColor) {
      var color = hexTripletColor;
      color = color.substring(1);           // remove #
      color = parseInt(color, 16);          // convert to integer
      color = 0xFFFFFF ^ color;             // invert three bytes
      color = color.toString(16);           // convert to hex
      color = ("000000" + color).slice(-6); // pad with leading zeros
      color = "#" + color;                  // prepend #
      return color;
 }
function shuffle(a) {
    var j, x, i;
    for (i = a.length; i; i--) {
        j = Math.floor(Math.random() * i);
        x = a[i - 1];
        a[i - 1] = a[j];
        a[j] = x;
    }
}



</script>
    
  </body>
</html>
