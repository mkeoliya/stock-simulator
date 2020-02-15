<?php
session_start();
date_default_timezone_set("Asia/Calcutta");
global $date;
$date=date('d-m-Y H:i:s a');

$host="localhost";
$user="boscofes_bemp";
$pass="FatherJohnBoscoBoscoFest2018";
$db="boscofes_bemp";

if(!isset($_SESSION['crazyValid'])){
  session_start();
  session_destroy();
  header('Location:index.php');
  exit();
}


if (isset($_POST['logout'])) {
  session_start();
  session_destroy();
  header('Location: crazyLogin.php');
  exit();
}

mysql_connect($host,$user,$pass);
mysql_select_db($db);
//$currentCr=$_SESSION['username'];
if(isset($_POST['submit'])){
  $event_name=$_POST['event_name'];
  $schoolname=$_POST['schoolname'];

  $sql = "SELECT $event_name FROM share_prices WHERE schoolname='$schoolname'";
  $result=mysql_query($sql);
  $row = mysql_fetch_row($result);
  $currentCrazy=$row[0];

  $currentCrazy=$currentCrazy + $_POST['shareChange'];

  $sql = "UPDATE share_prices SET $event_name = '$currentCrazy' WHERE schoolname='$schoolname'";
  $result=mysql_query($sql); 

  $sql = "SELECT * FROM share_prices WHERE schoolname='$schoolname'";
  $result=mysql_query($sql);
  $row=mysql_fetch_assoc($result);
  $price = $row['base_price'] + $row['boulevard'] + $row['ballyhoo'] + $row['boardroom'] + $row['quidproquo'] + $row['bpl']+ $row['builder']+ $row['indemnity']+ $row['subterfuge']+ $row['lockout']+ $row['contingency']+ $row['linkingpin']+ $row['freakonomics'];
  $old = $row['curr_price'];
  
  $sql = "SELECT indice FROM bse WHERE id=(SELECT MAX(id) FROM bse)";
  $result=mysql_query($sql);
  $row=mysql_fetch_row($result);
  $oldBSI=$row[0];
  
  $newBSI= ($oldBSI/10 + $_POST['shareChange'])*10;
  $sql="INSERT INTO bse (indice,time) VALUES ('$newBSI','$date')";
  $res=mysql_query($sql);
 

  $sql = "UPDATE share_prices SET prev_price = '".$old."', curr_price = '".$price."' WHERE schoolname='$schoolname'";
  $result=mysql_query($sql);
  
  $table = getShortTrade($schoolname);
  
  $sql = "INSERT INTO $table (price,time) VALUES ($price,'$date')";
  $result = mysql_query($sql); 
  
  $shareChange=$_POST['shareChange'];
            $sql = "INSERT INTO speculator_record (event_name, schoolname, shareChange, oldPrice, newPrice) VALUES ('$event_name', '$schoolname', '$shareChange', '$old', '$price')";
            $result=mysql_query($sql);
  
  $result = mysql_query($sql); 



 // echo "<script>alert('$shareAmount + $balance + $price + $transactionAmount');</script>";
      
}


function getShortTrade($schoolTrade){
  $longName= array("Lakshmipat Singhania Academy","Loreto House","Don Bosco Liluah","Modern High School For Girls","St.Josephs Convent","St.James School","Mahadevi Birla World Academy","La Martiniere For Boys","St.Xaviers Collegiate School","Don Bosco Park Circus","Delhi Public School Mega City");
    $shortName = array("lsa","lh","dbl","mhs","sjc","sjs","mbwa","lmb","sxcs","dbpc","dps");
    for($i=0;$i<count($longName);$i++){
      if(strcmp($longName[$i],$schoolTrade)==0)
             return $shortName[$i];
    }
    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title>Bosco Empresarios 2018</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="http://boscoempresarios2018.com/images/favicon.png">

    <!-- Template CSS Files -->
    <link rel="stylesheet" href="http://boscoempresarios2018.com/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://boscoempresarios2018.com/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://boscoempresarios2018.com/css/magnific-popup.css">
    <link rel="stylesheet" href="http://boscoempresarios2018.com/css/select2.min.css">
    <link rel="stylesheet" href="http://boscoempresarios2018.com/css/style.css">
	<link rel="stylesheet" href="http://boscoempresarios2018.com/css/skins/orange.css">
	
	<!-- Live Style Switcher - demo only -->
    <link rel="alternate stylesheet" type="text/css" title="orange" href="http://boscoempresarios2018.com/css/skins/orange.css" /> 

    <!-- Template JS Files -->
    <script src="http://boscoempresarios2018.com/js/modernizr.js"></script>

    <script type="text/javascript">
        function myFunction() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("myBtn");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less"; 
    moreText.style.display = "inline";
  }
}
    </script>


    <style>      
      .chart-container {
        width: 90%;
        height: auto;        
      }
      @media (max-width: 576px) {
      .chart-container {
          width: 95%;
          height: auto;
        }
      }
      #more {display: none;}
    </style>

</head>

<body>
    
    <!-- Wrapper Starts -->
    <div class="wrapper">
        <!-- Header Starts -->
        <header class="header">
            <div class="container">
                <div class="row">
                    <!-- Logo Starts -->
                    <div class="main-logo col-xs-12 col-md-3 col-md-2 col-lg-2 hidden-xs">
                        <a href="index.php">
                            <img id="logo" class="img-responsive" src="http://boscoempresarios2018.com/images/logo-dark.png" alt="logo">
                        </a>
                    </div>
                    <!-- Logo Ends -->
                    <!-- Statistics Starts -->
                    <div class="col-md-7 col-lg-7">
                        <marquee><ul class="unstyled bitcoin-stats text-center">

                                 <?php
                                $host="localhost";
                                $user="boscofes_bemp";
                                $pass="FatherJohnBoscoBoscoFest2018";
                                $db="boscofes_bemp";

                                 $con=mysqli_connect($host,$user,$pass,$db);
                                 if (mysqli_connect_errno())
                                 {
                                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                 }                                 
                                 $sql= "SELECT * FROM share_prices";
                                 $result=mysqli_query($con,$sql);
                                 while($row = mysqli_fetch_array($result)){
                                    if($row['curr_price']>$row['prev_price'])
                                        echo "<li><h6 style=\"display: inline-block;\">" . $row['curr_price'] . "</h6><div style=\"display: inline-block; margin-left: 5px\" class=\"arrow-up\"></div><div><span>" . $row['schoolname'] . "</span></div></li>";
                                    else if($row['curr_price']<$row['prev_price'])
                                        echo "<li><h6 style=\"display: inline-block;\">" . $row['curr_price'] . "</h6><div style=\"display: inline-block; margin-left: 5px\" class=\"arrow-down\"></div><div><span>" . $row['schoolname'] . "</span></div></li>";
                                    else
                                        echo "<li><h6 style=\"display: inline-block;\">" . $row['curr_price'] . "</h6><div style=\"display: inline-block; margin-left: 5px\" class=\"arrow-no-change\"></div><div><span>" . $row['schoolname'] . "</span></div></li>";
                                }
                                  

                            ?>
                        </ul></marquee>
                    </div>
                    <!-- Statistics Ends -->
                    <!-- User Sign In/Sign Up Starts -->
                    <div class="col-md-3 col-lg-3">
                        <ul class="unstyled user">
                            <li class="sign-in"><a href="http://boscoempresarios2018.com/shares.php" class="btn btn-primary" target="_blank">Stock Exchange</a></li>
                        </ul>
                    </div>
                    <!-- User Sign In/Sign Up Ends -->
                </div>
            </div>
        </header>
        <!-- Header Ends -->
        <!-- Features Section Starts -->

        <!-- Features Section Ends -->
        <!-- About Section Starts -->
        <section class="about-us">
            <div class="container">
                <!-- Section Title Ends -->
                <!-- Section Content Starts -->
                <div class="row about-content">
                    <!-- Image Starts -->
                    <div class="col-sm-12 col-md-5 col-lg-6 text-center">
                        <img id="about-us" class="img-responsive img-about-us" src="http://boscoempresarios2018.com/images/about-us.png" alt="about us">
                    </div>
                    <!-- Image Ends -->                    
                    <!-- Content Starts -->
                    <div class="col-sm-12 col-md-7 col-lg-6">                        
                    	<div class="form-container">
					<div>
						<br class="hidden-xs"><br class="hidden-xs">
						<!-- Section Title Starts -->
						<div class="row text-center">
							<h2 class="title-head">Bosco Stock <span>Exchange</span></h2>
						</div>
						<!-- Section Title Ends -->
						<!-- Form Starts -->
						<form method="post" action="crazyChange.php">
							<!-- Input Field Starts -->
							<div class="form-group">								
								<select class="form-control" name="event_name">
									<option value="select">Select Event</option>
							       <option value="boulevard">boulevard</option>
							       <option value="ballyhoo">ballyhoo</option>
							       <option value="boardroom">boardroom</option>
							       <option value="quidproquo">quid pro quo</option>
							       <option value="bpl">premier league</option>
							       <option value="builder">builder</option>
							       <option value="indemnity">indemnity</option>
							       <option value="subterfuge">subterfuge</option>
							       <option value="lockout">lockout</option>
							       <option value="contingency">contingency</option>
							       <option value="linkingpin">linkingpin</option>
							       <option value="freakonomics">freakonomics</option>
							       </select>
							      </div>
						
							<br>
							
							<div class="form-group">
							<select class="form-control" name="schoolname">
									<option value="select">Select School</option>
									<option value="Lakshmipat Singhania Academy">Lakshmipat Singhania Academy</option>
									<option value="Loreto House">Loreto House</option>
									<option value="Don Bosco Liluah">Don Bosco Liluah</option>
									<option value="Modern High School For Girls">Modern High School For Girls</option>
									<option value="St.Josephs Convent">St.Josephs Convent</option>
									<option value="St.James School">St.James School</option>
									<option value="Mahadevi Birla World Academy">Mahadevi Birla World Academy</option>
									<option value="La Martiniere For Boys">La Martiniere For Boys</option>
									<option value="St.Xaviers Collegiate School">St.Xaviers Collegiate School</option>
									<option value="Don Bosco Park Circus">Don Bosco Park Circus</option>
									<option value="Delhi Public School Mega City">Delhi Public School Mega City</option>
														
								</select>
							</div>
							<br>
							<!-- Input Field Ends -->
							<!-- Input Field Starts -->
							<div class="form-group">
								<input class="form-control" name="shareChange" placeholder="Enter amount to change price by" type="number"  required>
							</div>
							<!-- Input Field Ends -->
							<!-- Submit Form Button Starts -->
							<div class="form-group">
								<button class="btn btn-primary" name="submit" type="submit">Submit</button>								
							</div>
							<!-- Submit Form Button Ends -->
						</form>
						<!-- Form Ends -->
					</div>      
                    </div>
                    <!-- Content Ends -->
                </div>
                <!-- Section Content Ends -->
            </div>
        </section>
        <!-- About Section Ends -->
        <!-- Footer Starts -->
        <footer class="footer">            
            <!-- Footer Top Area Ends -->
            <!-- Footer Bottom Area Starts -->
            <div class="bottom-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- Copyright Text Starts -->
                            <p class="text-center">Copyright © 2018 Don Bosco School Park Circus</p>
                            <!-- Copyright Text Ends -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Bottom Area Ends -->
        </footer>
        <!-- Footer Ends -->
		<!-- Back To Top Starts  -->
        <a href="#" id="back-to-top" class="back-to-top fa fa-arrow-up"></a>
		<!-- Back To Top Ends  -->
		
        <!-- Template JS Files -->
        <script src="http://boscoempresarios2018.com/js/jquery-2.2.4.min.js"></script>
        <script src="http://boscoempresarios2018.com/js/bootstrap.min.js"></script>
        <script src="http://boscoempresarios2018.com/js/select2.min.js"></script>
        <script src="http://boscoempresarios2018.com/js/jquery.magnific-popup.min.js"></script>
        <script src="http://boscoempresarios2018.com/js/custom.js"></script>
		
        <script type="text/javascript" src="http://boscoempresarios2018.com/js/jquery.min.js"></script>
        <script type="text/javascript" src="http://boscoempresarios2018.com/js/Chart.min.js"></script>

		<!-- Live Style Switcher JS File - only demo -->
		<script src="js/styleswitcher.js"></script>

    </div>
    <!-- Wrapper Ends -->
</body>

</html>