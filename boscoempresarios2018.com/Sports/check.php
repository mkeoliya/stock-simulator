<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Review the Entry</title>
<link href="css/index.css" rel="stylesheet" type="text/css">
    <link href="css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
body,td,th {
	color: #EFEFEF;
}
</style>
</head>

<body>
<?php
session_start();
include("header1.php");
include("header.php");
include("conn.php");
$pos1 = $_SESSION['pos1'];
$pos2 = $_SESSION['pos2'];
$pos3 = $_SESSION['pos3'];
$pos4 = $_SESSION['pos4'];
$event = $_SESSION['event'];
$type = $_SESSION['type'];
$division = $_SESSION['division'];

$sql1 = mysqli_query($con,"SELECT * FROM participants WHERE part_name = '". $pos1 ."'");
while($data1=mysqli_fetch_array($sql1)){
	extract($data1);
	$house1 = $data1['house'];
}
$sql2 = mysqli_query($con,"SELECT * FROM participants WHERE part_name = '". $pos2 ."'");
while($data2=mysqli_fetch_array($sql2)){
	extract($data2);
	$house2 = $data2['house'];
}
$sql3 = mysqli_query($con,"SELECT * FROM participants WHERE part_name = '". $pos3 ."'");
while($data3=mysqli_fetch_array($sql3)){
	extract($data3);
	$house3 = $data3['house'];
}
$sql4 = mysqli_query($con,"SELECT * FROM participants WHERE part_name = '". $pos4 ."'");
while($data4=mysqli_fetch_array($sql4)){
	extract($data4);
	$house4 = $data4['house'];
}
$sql_eventPoint = mysqli_query($con,"SELECT * FROM events WHERE event_name= '".$event."'");
while($data4=mysqli_fetch_array($sql_eventPoint)){
	extract($data4);
	$point1 = $data4['point1'];
		
}
$sql_eventPoint = mysqli_query($con,"SELECT * FROM events WHERE event_name= '".$event."'");
while($data4=mysqli_fetch_array($sql_eventPoint)){
	extract($data4);
	$point2 = $data4['point2'];
}
	$sql_eventPoint2 = mysqli_query($con,"SELECT * FROM events WHERE event_name= '".$event."'");
while($data4=mysqli_fetch_array($sql_eventPoint2)){
	
	extract($data4);
	
	$point3 = $data4['point3'];
}
	$sql_eventPoint3 = mysqli_query($con,"SELECT * FROM events WHERE event_name= '".$event."'");

while($data4=mysqli_fetch_array($sql_eventPoint3)){
	extract($data4);

	$point4 = $data4['point4'];
}
$sql_eventCat="SELECT * FROM events WHERE event_name = '".$event."'";
$result_sql_eventCat = mysqli_query($con,$sql_eventCat);
while($dataCat=mysqli_fetch_array($result_sql_eventCat)){
	extract($dataCat);
	$event_cat=$dataCat['event_cat'];
}
$sql_eventtype="SELECT * FROM events WHERE event_name = '".$event."'";
$result_sql_eventtype = mysqli_query($con,$sql_eventtype);
while($datatype=mysqli_fetch_array($result_sql_eventtype)){
	extract($datatype);
	$event_type=$datatype['event_type'];
}

//die("UPDATE ".$house1." SET ".$event." = ".$event." + '".$point1."'");
if(isset($_POST['submit'])){
	//$query = "UPDATE green SET 100mts = 100mts + 15";
	$query1 = "UPDATE ".$house1." SET ".$event." = ".$event." + '".$point1."'";
$result_point1 = mysqli_query($con,$query1);
$query2 = "UPDATE ".$house2." SET ".$event." = ".$event." + '".$point2."'";
$result_point2 = mysqli_query($con,$query2);
$query3 = "UPDATE ".$house3." SET ".$event." = ".$event." + '".$point3."'";
$result_point3 = mysqli_query($con,$query3);
$query4 = "UPDATE ".$house4." SET ".$event." = ".$event." + '".$point4."'";
$result_point4 = mysqli_query($con,$query4);
if($event_cat == "track" && $event_type == "ind"){
	$part_point1 = mysqli_query($con,"UPDATE participants SET points = points + '".$point1."' WHERE part_name = '".$pos1."'");
	$part_point2 = mysqli_query($con,"UPDATE participants SET points = points + '".$point2."' WHERE part_name = '".$pos2."'");
	$part_point3 = mysqli_query($con,"UPDATE participants SET points = points + '".$point3."' WHERE part_name = '".$pos3."'");
	$part_point4 = mysqli_query($con,"UPDATE participants SET points = points + '".$point4."' WHERE part_name = '".$pos4."'");
}
$red_add = mysqli_query($con,"UPDATE red SET total = 100m + 200m + 400m + 800m + long_jump + high_jump + shotput + discuss + javelin + hurdles + obstacle + sacrace + slow_cycle + piggy_back + tug_o_war + tunnel_ball + relay_race + drill_jr + drill_sr + march_past + discipline + predecided");

$blue_add = mysqli_query($con,"UPDATE blue SET total = 100m + 200m + 400m + 800m + long_jump + high_jump + shotput + discuss + javelin + hurdles + obstacle + sacrace + slow_cycle + piggy_back + tug_o_war + tunnel_ball + relay_race + drill_jr + drill_sr + march_past + discipline + predecided");

$green_add = mysqli_query($con,"UPDATE green SET total = 100m + 200m + 400m + 800m + long_jump + high_jump + shotput + discuss + javelin + hurdles + obstacle + sacrace + slow_cycle + piggy_back + tug_o_war + tunnel_ball + relay_race + drill_jr + drill_sr + march_past + discipline + predecided");

$yellow_add = mysqli_query($con,"UPDATE yellow SET total = 100m + 200m + 400m + 800m + long_jump + high_jump + shotput + discuss + javelin + hurdles + obstacle + sacrace + slow_cycle + piggy_back + tug_o_war + tunnel_ball + relay_race + drill_jr + drill_sr + march_past + discipline + predecided");

if((strcmp($event,"discipline")!=0) || (strcmp($event,"march_past")!=0) || (strcmp($event,"drill_sr")!=0) || (strcmp($event,"drill_jr")!=0))
{
    if((strcmp($event,"tug_o_war")==0) || (strcmp($event,"tunnel_ball")==0))
    {
        insert_part_position($pos1,"FIRST","",$event);
        insert_part_position($pos2,"SECOND","",$event);
        insert_part_position($pos3,"THIRD","",$event);
    }
    else if((strcmp($event,"piggy_back")==0) || (strcmp($event,"relay_race")==0))
    {
        $division=$_SESSION['division'];
        insert_part_position($pos1,"FIRST",$division,$event);
        insert_part_position($pos2,"SECOND",$division,$event);
        insert_part_position($pos3,"THIRD",$division,$event);
    }
    else
    {
        $division=$_SESSION['division'];
        $event_div = $event.' ('.$division.')';
        insert_ind($pos1,"FIRST",$event_div,$house1);
        insert_ind($pos2,"SECOND",$event_div,$house2);
        insert_ind($pos3,"THIRD",$event_div,$house3);
    }
}

header('Location: hello.php');
}

function insert_ind($part,$position,$event_div,$house)
{
    include("conn.php");
    $sql = "INSERT INTO certificate (name,event,position,house) VALUES ('$part','$event_div','$position','$house')";
    $res = mysqli_query($con,$sql);
}

function insert_part($sql,$position,$divi,$event)
{
    include("conn.php");
    $result = mysqli_query($con,$sql);
    while($part=mysqli_fetch_array($result)){
	   extract($part);
	   $part_name=$part['part_name'];
	   $house=$part['house'];
	   if(strcmp($divi,"")==0)
	   {
	       $sql_ins = "INSERT INTO certificate (name,event,position,house) VALUES ('$part_name','$event','$position','$house')";
	       $res_ins = mysqli_query($con,$sql_ins);
	   }
	   else
	   {
	       $event_div = $event.$divi;
	       $sql_ins = "INSERT INTO certificate (name,event,position,house) VALUES ('$part_name','$event_div','$position','$house')";
	       $res_ins = mysqli_query($con,$sql_ins);
	   }
    }
}

function insert_part_position($pos,$position,$divi,$event)
{
    if(strcmp($divi,"")==0)
    {
        //EVENT 1
        $sql = "SELECT * FROM participants WHERE house = '".$pos."' AND event_1 = '".$event."'";
        insert_part($sql,$position,$divi,$event);
        
        //EVENT 2
        $sql = "SELECT * FROM participants WHERE house = '".$pos."' AND event_2 = '".$event."'";
        insert_part($sql,$position,$divi,$event);
        
        //EVENT 3
        $sql = "SELECT * FROM participants WHERE house = '".$pos."' AND event_3 = '".$event."'";
        insert_part($sql,$position,$divi,$event);
        
        //EVENT 4
        $sql = "SELECT * FROM participants WHERE house = '".$pos."' AND event_4 = '".$event."'";
        insert_part($sql,$position,$divi,$event);
        
        //EVENT 5
        $sql = "SELECT * FROM participants WHERE house = '".$pos."' AND event_5 = '".$event."'";
        insert_part($sql,$position,$divi,$event);
    }
    else
    {
        //EVENT 1
        $sql = "SELECT * FROM participants WHERE house = '".$pos."' AND event_1 = '".$event."' AND division = '".$divi."'";
        insert_part($sql,$position,$divi,$event);
        
        //EVENT 2
        $sql = "SELECT * FROM participants WHERE house = '".$pos."' AND event_2 = '".$event."' AND division = '".$divi."'";
        insert_part($sql,$position,$divi,$event);
        
        //EVENT 3
        $sql = "SELECT * FROM participants WHERE house = '".$pos."' AND event_3 = '".$event."' AND division = '".$divi."'";
        insert_part($sql,$position,$divi,$event);
        
        //EVENT 4
        $sql = "SELECT * FROM participants WHERE house = '".$pos."' AND event_4 = '".$event."' AND division = '".$divi."'";
        insert_part($sql,$position,$divi,$event);
        
        //EVENT 5
        $sql = "SELECT * FROM participants WHERE house = '".$pos."' AND event_5 = '".$event."' AND division = '".$divi."'";
        insert_part($sql,$position,$divi,$event);
    }
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
<form name="check_form" method="post">
<font size="+3">Event: <u><b><?php echo $event; ?></b></u></font>
<p>
<label ><font size="+2">
Position 1:</font></label><p>Name: <input type="text" value="<?php echo $pos1 ?>" disabled>
House: <input type="text" id="house1" value="<?php echo $house1 ?>" disabled>
Points: <input type="text" id="point1" value="<?php echo $point1 ?>" disabled>
<p>
<label ><font size="+2">
Position 2:</font></label><p>Name: <input type="text" value="<?php echo $pos2 ?>" disabled>
House: <input type="text" id="house2" value="<?php echo $house2 ?>" disabled>
Points: <input type="text" id="point2" value="<?php echo $point2 ?>" disabled>
<p>
<label ><font size="+2">
Position 3:</font></label><p>Name: <input type="text" value="<?php echo $pos3 ?>" disabled>
House: <input type="text" id="house3" value="<?php echo $house3 ?>" disabled>
Points: <input type="text" id="point3" value="<?php echo $point3 ?>" disabled>
<p>
<label ><font size="+2">
Position 4:</font></label><p>Name: <input type="text" value="<?php echo $pos4 ?>" disabled>
House: <input type="text" id="house4" value="<?php echo $house4 ?>" disabled>
Points: <input type="text" id="point4" value="<?php echo $point4 ?>" disabled>
<p>
<button class="snip1339" name="submit" id="submit" >Submit<i class="ion-plus-round"></i></button>
</p>


</form>
<script src="https://www.gstatic.com/firebasejs/5.5.4/firebase.js"></script>
<script language="javascript" type="text/javascript" src="js/points.js"></script>
</body>
</html>