var database;
var ref;
var red;
var blue;
var green;
var yellow;
window.onload=function(){

	var config = {
	    apiKey: "AIzaSyBcfnx14BexZMoP1gqvSbLZSfYigjUvfcXkroScK",
	    authDomain: "sports-b18ab.firebaseapp.com",
	    databaseURL: "https://sports-b18ab.firebaseio.com",
	    projectId: "sports-b18ab",
	    storageBucket: "",
	    messagingSenderId: "601386918554"
	};
	firebase.initializeApp(config);

  	database = firebase.database();
  	ref = database.ref('points');

    ref.on('value', gotData, errData);
};

function gotData(data)
{
  var housePoints = data.val();
  var keys = Object.keys(housePoints);
  
  blue = parseFloat(housePoints[keys[0]].point);
  green = parseFloat(housePoints[keys[1]].point);
  red = parseFloat(housePoints[keys[2]].point);
  yellow = parseFloat(housePoints[keys[3]].point);
  
  document.getElementById("red").textContent = red;
  document.getElementById("blue").textContent = blue;
  document.getElementById("green").textContent = green;
  document.getElementById("yellow").textContent = yellow;
  
  console.log(red);
  console.log(blue);
  console.log(green);
  console.log(yellow);
  
}

function errData(err) 
{
  console.log("Error!");
  console.log(data);
}