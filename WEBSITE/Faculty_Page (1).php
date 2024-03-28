<?php

session_start();
if(!isset($_SESSION['FACULTY']))
{
	header('location:Login_Page.php');
}
include 'source.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Advance Data Monitoring System | Faculty</title>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <link rel="stylesheet" type="text/css" href="All_pages.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    
    <script src="https://code.jquery.com/jquery-1.11.3.js"integrity="sha256-IGWuzKD7mwVnNY01LtXxq3L84Tm/RJtNCYBfXZw3Je0="crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  
  <style type="text/css">
    nav li a{
        font-size:28px;
    }
  </style>
</head>
<body>
  <div class="container-fluid" style="padding-right:0; padding-left:0;">
     
  <nav class="navbar navbar-default">
      
      <div class="col-sm-8 col-md-8 col-lg-8">
        <div class="navbar-header">         
        <div class="logo">
          <img src="ljk.png" width="70px" height="70px" style="float:left;">
      </div>
        <h1 class="" style="margin-left:100px">Advance Data Monitoring System</h1>
      </div>
      </div>
      <div class="col-sm-4 col-md-4 col-xs-4" style="margin-bottom:15px;">
        <ul class="nav navbar-nav navbar-right" style="margin-right:2px;">
          <li><a href="Logout.php" class="btn btn-warning">Log out</a></li>
            <!--<li><p class="symbol">Faculty</p></li>-->
          </ul>
        </div>
  </nav>
</div>

<div class="container">
  <nav class="navbar navbar-default navbar-fixed alert-info">
      <div class="nav navbar-nav" style="padding-top:5px;padding-left:5px;">
      		<p class="navheading" style="font-family: times new roman;font-weight:bold;color:#E74C3C;">FACULTY: <?php echo $_COOKIE['Name']?></p>
      </div>
      
      
      <div class="nav navbar-nav" style="padding-top:5px;">
    	     <?php 
            $data = $_COOKIE['id'];
			$q = "SELECT  Access_grant.Total_hours FROM `Access_grant` WHERE Access_grant.User_id = '$data'";
			$re = mysqli_query($connect,$q);

			if ($re->num_rows > 0) {
			while ($r = $re->fetch_assoc()) {
			$rb = $r['Total_hours'];
		                                    }
                                    }
		    ?>
      		<p class="navheading" style="margin-left:100px;">Total Time Remaining : <span class="">
      		    <?php echo$rb;?></span></p>
    	</div>
      <!--
      <div class="nav navbar-nav navbar-left-right">
          <p class="navheading">Total Time Remaining : <span class="">4:21:47</span></p>
      </div>
      -->
      <ul class="nav navbar-nav navbar-right">
          
          <li><a href="#">help</a></li>
      </ul>
  </nav>
</div>
  <?php include 'Faculty_table.php'; ?>
<footer style="background-color:#98C5E1;height:40px;padding-top:10px;">
  
  <div class="text-center" style="padding-left:250px;">© 2019 Copyright:
    <a href="#">Advance Data Management System</a>
    <span style="float:right;padding-right:120px;"><a href="About_US.html">Development Team</a></span>
  </div>

</footer>
</body>
</html>