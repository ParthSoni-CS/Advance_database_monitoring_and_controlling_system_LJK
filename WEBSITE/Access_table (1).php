<?php

session_start();
if(!isset($_SESSION['ADMIN']))
{
	header('location:Login_Page.php');
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<meta name="viewport" content="width=device-width,initial-scale=1">-->
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="card.css">
    <link rel="stylesheet" href="All_pages.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
		function toggle(){
			document.getElementById('sidebar').classList.toggle('active');
		}
	</script>
    
    <!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="  crossorigin="anonymous"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.11.3.js"integrity="sha256-IGWuzKD7mwVnNY01LtXxq3L84Tm/RJtNCYBfXZw3Je0="crossorigin="anonymous"></script>-->
    
    
    <style type="text/css">
    nav li a{
        font-size:28px;
    }
    .btn-warning:hover {
    background-position: 0 -50px;
    }
	</style>
</head>
<body>
<?php include 'header.php';?>    
<div align="center" class="container">
<br/>
    <div class="input-group">
        <span class="input-group-addon">Search</span>
        <input type="text" name="search_text" id="search_text" class="form-control" />
    </div>
    <br/>
    <div id="result"></div>

</div>
<footer style="background-color:#98C5E1;height:40px;padding-top:10px;">
  
  <div class="text-center" style="padding-left:250px;">© 2019 Copyright:
    <a href="#">Advance Data Management System</a>
    <span style="float:right;padding-right:120px;"><a href="About_US.html">Development Team</a></span>
  </div>

</footer>
</body>
</html>
<script type="text/javascript">
 $(document).ready(function(){
    load_data();

});
//fetch
 function load_data(query)
 {
    var action='fetchData';
    $.ajax({
            url:"Access_ajax.php",
            method:"POST",
            data:{action:action, query:query},
            success:function(data)
            {
                $('#result').html(data);
            }
    });
 }
 //search
 $('#search_text').keyup(function(){
      var search = $(this).val();

      if(search != '')
      {
        load_data(search);
      }
      else
      {
        load_data();
      }
 });
 function change(statusID, Building_name)
{
    var action='status';
    console.log("building:"+statusID);
    $.ajax({
            url:"Access_ajax.php",
            type:'post',
            data:{action:action, statusID:statusID, Building_name:Building_name },
            success:function(data, status){

                load_data();
            }
        });
}
function changeroom(statusID, Building_name,Room_number)
{
   var action='room_status';
   console.log("rooom="+statusID);

   $.ajax({
           url:"Access_ajax.php",
           type:'post',
           data:{action:action, statusID:statusID, Building_name:Building_name, Room_number:Room_number },
           success:function(data, status){

               load_data();
           }
       });
}

</script>
