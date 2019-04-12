<?php
session_start();
date_default_timezone_set("Asia/Calcutta");

$host="localhost";
$user="boscofes_bemp";
$pass="FatherJohnBoscoBoscoFest2018";
$db="boscofes_bemp";

$conn = mysqli_connect($host,$user,$pass,$db);

if(!isset($_SESSION['adminValid'])){
        header('Location:index.php');
}

if(!isset($_SESSION['username'])){
    header('Location:index-2.php');
}

if (isset($_POST['dashboard'])) {
  session_start();
  session_destroy();
    header('Location:dashboard.php');
  exit();
}


mysql_connect($host,$user,$pass);
mysql_select_db($db);
$currentschool=$_SESSION['username'];
echo $currentschool;


$longName= array("Lakshmipat Singhania Academy","Loreto House","Don Bosco Liluah","Modern High School For Girls","St.Josephs Convent","St.James School","Mahadevi Birla World Academy","La Martiniere For Boys","St.Xaviers Collegiate School","Don Bosco Park Circus","Delhi Public School Mega City");

global $arr;
$_SESSION['count']++;
$arr=array();
for($i=0;$i<count($longName);$i++){
$sql= "SELECT * FROM share_prices WHERE schoolname='".$longName[$i]."' LIMIT 1";
    $result = mysql_query($sql);
  $row = mysql_fetch_row($result);
    $price= $row[2] + $row[5] + $row[6] + $row[7] + $row[8] + $row[9] + $row[10] + $row[11] + $row[12] + $row[13] + $row[14] + $row[15] + $row[16];
    $arr[$i]=$price;
}

if(!isset($_POST['submit']) || $_SESSION['count']%2==1){
$_SESSION['prices']=$arr;
}




    
    
if(isset($_POST['submit'])){
  $schoolTrade = $_POST['schoolTrade'];
  $shortTrade=getShortTrade($schoolTrade);
  $transactionType = $_POST['transactionType'];
  $shareAmount=$_POST['shareAmount'];
  
  if(strcmp($currentschool,$schoolTrade)==0){
      echo "<script>alert('Cannot trade in shares of your own school');</script>";
  }
  else{
      $newArr=$_SESSION['prices'];
      for($i=0;$i<count($longName);$i++)
         if(strcmp($longName[$i],$schoolTrade)==0)
            $price=$newArr[$i];


  
  if($shareAmount>0){
      $date=date('d-m-Y H:i:s a');
      //echo $date;

  $sql = "SELECT balance FROM bank_balance WHERE schoolname='".$currentschool."' ";
  $result = mysql_query($sql);
  $row = mysql_fetch_row($result);
    $balance=$row[0];



  
    $sql = "SELECT $shortTrade FROM holdings WHERE schoolname='".$currentschool."' ";
    $result = mysql_query($sql);
  $row = mysql_fetch_row($result);
    $shares=$row[0];

    $transactionAmount = $shareAmount * $price;
    $flag=false;
    if(strcmp($transactionType,"Buy")==0){
      if($transactionAmount>$balance){  // not successful transaction
        echo "<script>alert('Your balance $balance is not enough to complete this transaction');</script>";
       }
       else{   
            $flag=true;                          // successful transaction
            $balance=$balance-$transactionAmount;
            
           $rangeCount=getSchoolCount($currentschool,$schoolTrade,$transactionAmount);
           $sql="SELECT * FROM transaction_record WHERE schoolname = '$currentschool' AND share_name = '$schoolTrade' AND transaction_type = 'Buy' ORDER by id DESC";
            $result=mysql_query($sql);
            $investment=0;
            while($row=mysql_fetch_assoc($result)){
                $investment = $investment + ($row['share_price']*$row['current_held']);
            }
            $investment=$investment+$transactionAmount;
            
            $doFlag=true;
            if($investment>250000){
           
           if($rangeCount>1 || $investment>500000){
               echo "<script>alert('Cannot have more than one school in the range of 2.5L to 5L, or invest more than 5L');</script>";
               $doFlag=false;
               $flag=false;
               
           }
            }
           
            
            if($doFlag){
            $sql = "UPDATE bank_balance SET balance = '$balance'   WHERE schoolname='$currentschool'";
            $result = mysql_query($sql);


            $shares=$shares+$shareAmount;
            $sql = "UPDATE holdings SET  $shortTrade= '$shares' WHERE schoolname='$currentschool'";
            $result = mysql_query($sql);

            $sql = "INSERT INTO transaction_record (schoolname, transaction_type, share_name, share_price, share_amount,timestamp,current_held) VALUES ('$currentschool', '$transactionType', '$schoolTrade', '$price', '$shareAmount','$date','$shareAmount')";
            $result=mysql_query($sql);

        }
       }
    }
    else{
      if($shares<$shareAmount){
        echo "<script>alert('Your holding of shares $shares is not enough to complete this transaction');</script>";
      }
      else{
        $flag=true;
        $balance=$balance+$transactionAmount;
        $sql = "UPDATE bank_balance SET balance = '$balance'   WHERE schoolname='$currentschool'";
            $result = mysql_query($sql);

            $shares=$shares-$shareAmount;
            $sql = "UPDATE holdings SET  $shortTrade= '$shares' WHERE schoolname='$currentschool'";
            $result = mysql_query($sql);
            
            $sql="SELECT * FROM transaction_record WHERE schoolname = '$currentschool' AND share_name = '$schoolTrade' AND transaction_type = 'Buy' ORDER by id DESC";
            $result=mysql_query($sql);
            $copy=$shareAmount;
            $i=0;
            while($row=mysql_fetch_assoc($result)){
                $currentShare=$row['current_held'];
                $id=$row['id'];
                if($currentShare<=$copy){
                    $copy=$copy-$currentShare;
                    $currentShare=0;
                $sql="UPDATE transaction_record SET current_held='$currentShare' WHERE id='$id'";
                $res=mysql_query($sql);
                }
                else{
                    $currentShare=$currentShare-$copy;
                    $sql="UPDATE transaction_record SET current_held='$currentShare' WHERE id='$id'";
                    $res=mysql_query($sql);
                    break;
                }

            }
            
            

            $sql = "INSERT INTO transaction_record (schoolname, transaction_type, share_name, share_price, share_amount,timestamp) VALUES ('$currentschool', '$transactionType', '$schoolTrade', '$price', '$shareAmount','$date')";
            $result=mysql_query($sql);
      }


    }
  if($flag)
   echo "<script>alert('Transaction completed successfully');</script>";
  }
  else
    echo "<script>alert('Cannot trade a negative value of shares');</script>";
  }
}


function getShortTrade($schoolTrade){
$longName= array("Lakshmipat Singhania Academy","Loreto House","Don Bosco Liluah","Modern High School For Girls","St.Josephs Convent","St.James School","Mahadevi Birla World Academy","La Martiniere For Boys","St.Xaviers Collegiate School","Don Bosco Park Circus","Delhi Public School Mega City");
$shortName = array("lsa","lh","dbl","mhs","sjc","james","mbwa","lmb","sxcs","dbpc","dps");
    for($i=0;$i<count($longName);$i++){
      if(strcmp($longName[$i],$schoolTrade)==0)
             return $shortName[$i];
    }
}

function getSchoolCount($currentschool,$schoolTrade,$transactionAmount){
$host="localhost";
$user="boscofes_bemp";
$pass="FatherJohnBoscoBoscoFest2018";
$db="boscofes_bemp";
mysql_connect($host,$user,$pass);
mysql_select_db($db);
$count=0;
    $longName= array("Lakshmipat Singhania Academy","Loreto House","Don Bosco Liluah","Modern High School For Girls","St.Josephs Convent","St.James School","Mahadevi Birla World Academy","La Martiniere For Boys","St.Xaviers Collegiate School","Don Bosco Park Circus","Delhi Public School Mega City");
    for($i=0;$i<count($longName);$i++){
        if(strcmp($currentschool,$longName[$i])!=0){
           $sql="SELECT * FROM transaction_record WHERE schoolname = '$currentschool' AND share_name = '$longName[$i]' AND transaction_type = 'Buy' ORDER by id DESC";
            $result=mysql_query($sql);
            $investment=0;
            while($row=mysql_fetch_assoc($result)){
                $investment = $investment + ($row['share_price']*$row['current_held']);
            }
            if(strcmp($longName[$i],$schoolTrade)==0)
                $investment=$investment + $transactionAmount;
            //echo "<script>alert('$transactionAmount');</script>";
            //echo "<script>alert('$investment for $longName[$i]');</script>";
            if($investment>500000)
             return 100;
            if($investment>250000){
                $count++;
            }
        }
    }
    
return $count;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title>Bosco Empresarios 2018</title>
    <meta name="theme-color" content="#fd961a">
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
						<form method="post" action="buysell.php">
							<!-- Input Field Starts -->
							<div class="form-group">
							    
							    
							    <select required class="form-control" name="transactionType">
									<option value="">Select Transaction Type</option>
									<option value="Buy">Buy</option>
									<option value="Sell">Sell</option>
								</select>
								<br>
								<select required class="form-control" name="schoolTrade">
									<option value="">Select Share Name</option>
									<option value="Lakshmipat Singhania Academy">Lakshmipat Singhania Academy : <?php echo $arr[0]; ?></option>
									<option value="Loreto House">Loreto House : <?php echo $arr[1]; ?></option>
									<option value="Don Bosco Liluah">Don Bosco Liluah : <?php echo $arr[2]; ?></option>
									<option value="Modern High School For Girls">Modern High School For Girls : <?php echo $arr[3]; ?></option>
									<option value="St.Josephs Convent">St.Josephs Convent : <?php echo $arr[4]; ?></option>
									<option value="St.James School">St.James School : <?php echo $arr[5]; ?></option>
									<option value="Mahadevi Birla World Academy">Mahadevi Birla World Academy : <?php echo $arr[6]; ?></option>
									<option value="La Martiniere For Boys">La Martiniere For Boys : <?php echo $arr[7]; ?></option>
									<option value="St.Xaviers Collegiate School">St.Xaviers Collegiate School : <?php echo $arr[8]; ?></option>
									<option value="Don Bosco Park Circus">Don Bosco Park Circus : <?php echo $arr[9]; ?></option>
									<option value="Delhi Public School Mega City">Delhi Public School Mega City : <?php echo $arr[10]; ?></option>
								</select>
							</div>
							<br>
							<!-- Input Field Ends -->
							<!-- Input Field Starts -->
							<div class="form-group">
								<input class="form-control" name="shareAmount" type="number"  min="1" autocomplete="off" placeholder="Enter Share Amount" required>
							</div>
							<!-- Input Field Ends -->
							<!-- Submit Form Button Starts -->
							<div class="form-group">
								<button class="btn btn-primary" name="submit" type="submit">Submit</button>	&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="dashboard.php"><button class="btn btn-primary" name="dash" type="button">Back To Dashboard</button></a>
							</div
							
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