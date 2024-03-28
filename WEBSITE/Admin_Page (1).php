<?php

session_start();
if(!isset($_SESSION['ADMIN']))
{
	header('location:Login_Page.php');
}

 $page = $_SERVER['PHP_SELF'];
 $sec = "60";
 header("Refresh: $sec; url=$page");
//$GLOBALS['UID']=$_COOKIE['uid'];
//echo $_SESSION['ID'];
//echo phpinfo();
 
?>
<!DOCTYPE html>

<html>
<head>
	<title>Advance Data Monitoring System | Admin</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <link rel="stylesheet" type="text/css" href="All_pages.css">
    <link rel="stylesheet" type="text/css" href="card.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.cssJutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.3.js"integrity="sha256-IGWuzKD7mwVnNY01LtXxq3L84Tm/RJtNCYBfXZw3Je0="crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript">
		function toggle(){
			document.getElementById('sidebar').classList.toggle('active');
		}
	</script>
    
    <style type="text/css">
    nav li a{
        font-size:28px;
    }

	</style>

</head>
<body>
    

 <?php include 'header.php'; ?>

<div class="result">
	<?php include 'Admin_table.php'; ?>
</div>
<footer style="background-color:#98C5E1;height:40px;padding-top:10px;">
  
  <div class="text-center" style="padding-left:250px;">© 2019 Copyright:
    <a href="#">Advance Data Management System</a>
    <span style="float:right;padding-right:120px;"><a href="About_US.html">Development Team</a></span>
  </div>

</footer>
</body>
</html>
<!--<script type="text/javascript">-->
<!--function setid(id)-->
<!--{-->
    
<!--    $.ajax(-->
<!--  {-->
<!--    url:"edit_add_web.php",-->
<!--    type:'post',-->
<!--    data:{id:id},-->
<!--    success:function(data){-->
    
<!--  }-->
<!-- })-->
<!--}-->
<!--</script>-->
 
<!--// //session_start();-->
<!--// echo '<script>setid('.$_COOKIE['id'].');</script>';-->
<!--// -->