<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" type="text/css" href="All_pages.css">
        <style>
        body
        {
            
         
        }
        .bg-image{
            
            /* The image used */
            background-image: url("ljk.png");
            
              /* Add the blur effect */
            filter: blur(4px);
            -webkit-filter: blur(4px);
            
              /* Full height */
            height: 100%; 
            
              /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: 50% ;
        
            
        }
        .maindiv
        { 
           
              
              
              
              position: absolute;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -50%);
              z-index: 2;
              width: 250px;
              padding: 25px;
              text-align: center;
            
              
        	
        
        }
        .cls
        {
           color: black;
           text-align: center;
        }
        .text{
        	background-color: transparent;
        	border: 2px solid black;
        	border-radius: 12px;
        	width: 95%;
        	margin-bottom: 10px;
        	padding: 10px;
        	color: black;
        	font-weight:bold;
        	
        }
        .button
        {
        	border-radius: 15px;
        	background-color: green;
        	width:100%;
        	height:40px;
        }
        .name
        {
        	color: black;
        }
    </style>
    </head>
    
<body>
<?php

	include 'source.php';

	extract($_GET);

	$usr_id=$_GET['uid'];
	$nname=$_GET['name'];
	$ttime=$_GET['ttime'];


?>
<div class ="bg-image"></div>
<div class="maindiv">
    
    <form method="post" action="Assign_hours_api.php">
        <table class="">
	    <tr>
    	    <th><pre class="name" style="font-family: times new roman;font-weight:bold;margin:5px 0 5px 20px;">User id:</pre></th>
    	    <td><input type="text" class="text" name="uid" value="<?php echo $usr_id;?>" readonly></td>
    	</tr>
    	<tr>
    	    <th><pre class="name" style="font-family: times new roman;font-weight:bold;margin:5px 0 5px 20px;">Name:</pre></th>
    	    <td><input type="text" class="text" name="name" value="<?php echo $nname;?>"readonly></td>
    	</tr>
    	<tr>
    	    <th><pre class="name" style="font-family: times new roman;font-weight:bold;margin:5px 0 5px 20px;">Total time:</pre></th>
    	    <td><input type="text" class="text" name="ttime" value="<?php echo $ttime;?>"readonly></td>
    	</tr>
    	<tr>
    	    <th><pre class="name" style="font-family: times new roman;font-weight:bold;margin:5px 0 5px 20px;">Enter hours:</pre></th>
    	    <td><input type="text" class="text" name="time" value=""></td>
    	</tr>
    	<tr>
    	    <td colspan="2"><input type="submit" class="button" name="update"  value="Submit"></td>
    	</tr>
	</form>
	
</div>


</body>
</html>