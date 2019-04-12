<?php
global $event;
global $type;
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>DBPC Sports '16 Tabulation</title>
<link href="css/index.css" rel="stylesheet" type="text/css">
    <link href="css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
    body,td,th {
	color: #FFFFFF;
	
}
.styled select {
	-webkit-appearance: button;
    -moz-appearance: button;
    -webkit-user-select: none;
    -moz-user-select: none;
    -webkit-padding-end: 20px;
    -moz-padding-end: 20px;
    -webkit-padding-start: 2px;
    -moz-padding-start: 2px;
	color:#555;
	padding-top: 2px;
    padding-bottom: 2px;
    text-overflow: ellipsis;
	input[type=text], textarea {
  -webkit-transition: all 0.30s ease-in-out;
  -moz-transition: all 0.30s ease-in-out;
  -ms-transition: all 0.30s ease-in-out;
  -o-transition: all 0.30s ease-in-out;
      box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);

  outline: none;
  padding: 3px 0px 3px 3px;
  margin: 5px 1px 3px 0px;
  border: 1px solid #DDDDDD;
}
 
input[type=text]:focus, textarea:focus {
  box-shadow: 0 0 5px rgba(81, 203, 238, 1);
  padding: 3px 0px 3px 3px;
  margin: 5px 1px 3px 0px;
  border: 1px solid rgba(81, 203, 238, 1);
}
	
  background: transparent;
  width: 150px;
  font-size: 20px;
  border: 1px solid #ccc;
  height: 34px;
}
.styled {
  margin: 50px;
  width: 120x;
  height: 34px;
  border: 1px solid #111;
  border-radius: 3px;
  overflow: hidden;
  
}
</style>
</head>

<body>
<?php
session_start();
include("header1.php");
include("header.php");
include("conn.php");

$event = $_GET['event'];
$type = $_GET['type'];
/**
if(strcmp($type,"grp")==0)
{
    
    header('Location: points.php?event='.$event.'&type='.$type);
}
else
{
    //do nothing
}**/

if(isset($_POST['submit'])){
    echo "<script>alert($event);</script>";
	$division=$_POST['division'];
	header('Location: points.php?event='.$event.'&type='.$type.'&division='.$division);
	
}
?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<form method="post" name="indexform">
<font size="+2">Division: </font>
<select name="division" id="name1" class="styled">
    <option value="a">A</option>
    <option value="b">B</option>
    <option value="c">C</option>
    <option value="d">D</option>
    <option value="e">E</option>
    <option value="f">F</option>
</select>
<p>
<button class="snip1339" name="submit" id="submit" onClick="submit()">Submit<i class="ion-plus-round"></i></button>
</p>
</form>
</body>
</html>