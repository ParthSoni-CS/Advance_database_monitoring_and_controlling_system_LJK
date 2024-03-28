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
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="card.css">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
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
<div class="container">
    <dic class="row">
    <div class="col-md-4 input-group">
        <span class="input-group-addon">Search</span>
        <input type="text" name="search_text" id="search_text" class="form-control" />
    </div>
      <div class="col-sm-1 ">
                    <input type="button" value = "Add New Device"  class="btn btn-primary" data-toggle="modal" data-target="#addModal" style =" left: 600px;padding: 5px 6px;"/>
     </div>
     <div class="col-sm-1 offset-sm-1">
                    <input type="button" value = "Add New Building"  class="btn btn-primary" data-toggle="modal" data-target="#addBuilding" style ="left: 600px;padding: 5px 6px;"/>
     </div>
    </div>
    </div>
    <br/>
    <div id="res"></div>

</div>
<div  class="modal fade" id="addModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h1 class="modal-title">Add Device</h1>
            <label>Enter All Field</label>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body" onmouseover="fun()">
             <div class="form-group">
              <label>Building:</label>
              
              <select id="building" class="form-control">
              <?php 
               include 'source.php';
              /* this is code is added */
                $query = "SELECT `Building_name` FROM `branch_building` ";  
                $result = mysqli_query($connect, $query);  
           
                if(mysqli_num_rows($result) > 0)  
                {
          		    $output='<option value="">SELECT</option>';
                    while($row = mysqli_fetch_array($result))  
                    {  
                       echo '<option value="'.$row["Building_name"].'">'.$row["Building_name"].'</option>';  
                    } 
             
                }
                /* end */
                ?>
                </select>
            </div>

            <div class="form-group">
              <label>Room Number:</label>
              <input type="text" name="" id="room_no" class="form-control" />
            </div>

            <div class="form-group">
              <label>Which No. of A.C:</label>
              <input type="del" name="" id="ac" class="form-control" />
            </div>

           

            <div class="form-group">
              <label>Arduino id:</label>
              <input type="text" name="" id="aid" class="form-control" />
            </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" id="add" class="btn btn-success" data-dismiss="modal" onclick="add()">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="addBuilding">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h1 class="modal-title">Add building</h1>
            <label>Enter All Field</label>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body" onmouseover="func()">
             <div class="form-group">
              <label>Building:</label>
               <input type="text" name="" id="building_name" class="form-control" />
             </div>

            <div class="form-group">
              <label>Raspberry pi id:</label>
              <input type="text" name="" id="rid" class="form-control" />
            </div>

         

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" id="add" class="btn btn-success" data-dismiss="modal" onclick="addb()">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>
  </div>
    <br/>
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
            url:"Device_table_ajax1.php",
            method:"POST",
            data:{action:action, query:query},
            success:function(data)
            {
                $('#res').html(data);
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
 
 function func(){
  var action='insert';
  var building=$('#building').val();
  var rid=$('#rid').val();

  if(building==''  || rid=='' )
  {
    document.getElementById('add').disabled=true;
  }
  else{
    document.getElementById('add').disabled=false;
  }
}

function fun(){
  var action='insertbuilding';
  var building=$('#building').val();
  var aid=$('#aid').val();
  var ac=$('#ac').val();
  var rn=$('#roomno').val();
  
  if(building==''  || aid=='' || ac=='' || rc=='')
  {
    document.getElementById('add').disabled=true;
  }
  else{
    document.getElementById('add').disabled=false;
  }
}

/* add data on database using ajax*/
function add()
{
 var action='insert';
  var building=$('#building').val();
  var room_no=$('#room_no').val();
  var ac=$('#ac').val();
  
  var aid=$('#aid').val();

  $.ajax(
  {
    url:"Device_table_ajax.php",
    type:'post',
    data:{action:action, building:building, room_no:room_no, ac:ac, aid:aid},
    success:function(data, status){
    $('#building').val('');
    $('#room_no').val('');
    $('#ac').val('');
    $('#aid').val('');

    document.location.reload(true);
  }

  });
}

// add building
function addb()
{
 var action='insertbuilding';
  var bname=$('#building_name').val();
  var rid=$('#rid').val();
  

  $.ajax({
      
    url:"Device_table_ajax.php",
    type:'post',
    data:{action:action, building:bname, rid:rid},
    success:function(data, status){
   
    $('#building_name').val('');
    $('#rid').val('');

    document.location.reload(true);
  }

  });
}




</script>