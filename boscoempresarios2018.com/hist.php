<?php
header('Content-Type: application/json');
//database


define('DB_HOST', 'localhost');
define('DB_USERNAME', 'boscofes_bemp');
define('DB_PASSWORD', 'FatherJohnBoscoBoscoFest2018');
define('DB_NAME', 'boscofes_bemp');

//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$school=$_GET['school'];

if(!$mysqli){
  die("Connection failed: " . $mysqli->error);
}

//query to get data from the table
$query = sprintf("SELECT * FROM $school");

//execute query
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
  $data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
print json_encode($data);
/**$host="localhost";
$user="root";
$pass="";
$db="bemp2018";

mysql_connect($host,$user,$pass);
mysql_select_db($db);

$sql = "SELECT * FROM james";
$result = mysql_query($sql);
$json = array();

while($row = mysql_fetch_row($result))
{
	$json[] = $row;
}
echo json_encode($json);**/
?>