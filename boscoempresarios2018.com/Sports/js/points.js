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
  	
  	document.getElementById("submit").onclick = function() 
  	{	
  		pointsUpload();
  	};

};

function pointsUpload()
{
    var point1 = document.getElementById("point1").value;
    var house1 = document.getElementById("house1").value;
    getPoint(house1,point1);
    
    var point2 = document.getElementById("point2").value;
    var house2 = document.getElementById("house2").value;
    getPoint(house2,point2);
    
    var point3 = document.getElementById("point3").value;
    var house3 = document.getElementById("house3").value;
    getPoint(house3,point3);
    
    var point4 = document.getElementById("point4").value;
    var house4 = document.getElementById("house4").value;
    getPoint(house4,point4);
    
    var data = {
		red: {
		    point:red
		},
		blue: {
		    point:blue
		},
		green: {
		    point:green
		},
		yellow: {
		    point:yellow
		}
	}
    
    //database.ref("points/red/point").set(red);
    database.ref('points').set(data);
    //database.ref("points/blue/point").set(blue);
    //database.ref('points');
    //database.ref("points/green/point").set(green);
    //database.ref('points');
    //database.ref("points/yellow/point").set(yellow);
    //database.ref('points');
    //database.ref("points/"+house4).set(point4);
    
}

function gotData(data)
{
  var housePoints = data.val();
  var keys = Object.keys(housePoints);
  
  blue = parseFloat(housePoints[keys[0]].point);
  green = parseFloat(housePoints[keys[1]].point);
  red = parseFloat(housePoints[keys[2]].point);
  yellow = parseFloat(housePoints[keys[3]].point);
  
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

function getPoint(house, point)
{
    switch(house)
    {
        case 'red':
            red = parseFloat(red) + parseFloat(point);
            break;
        case 'blue':
            blue = parseFloat(blue) + parseFloat(point);
            break;
        case 'green':
            green = parseFloat(green) + parseFloat(point);
            break;
        case 'yellow':
            yellow = parseFloat(yellow) + parseFloat(point);
            break;
    }
}