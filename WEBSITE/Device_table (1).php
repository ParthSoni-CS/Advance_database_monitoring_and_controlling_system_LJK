<?php

session_start();
if(!isset($_SESSION['ADMIN']))
{
	header('location:Login_Page.php');
}

include 'source.php';

?>

<!doctype html>
<html>
<head>
    <title>Advanced Data Monitoring System</title>
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <link rel="stylesheet" type="text/css" href="All_pages.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.11.3.js"integrity="sha256-IGWuzKD7mwVnNY01LtXxq3L84Tm/RJtNCYBfXZw3Je0="crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script type = "text/javascript">

              function funcone() {
                 var retVal = confirm("Do you want to save the changes");
                 if( retVal == true ) {
                    document.write ("all the data is saved ");
                    return true;
                 } else {
                    document.write ("all the data is been reset");
                    return false;
                 }
              }

        </script>
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

    <div ng-app="Device_MainJS" ng-controller="controller">
        <div class="container">
            
            <div class="row">

                <div class="col-sm-2 pull-left">
                    <label>PageSize:</label>
                    <br/>
                    <select ng-model="data_limit" class="form-control">
                        <option>10</option>
                        <option>20</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>

                <div class="col-sm-1 pull-right">
                    <input type="button" value = "Add New Device"  class="btn btn-primary" data-toggle="modal" data-target="#addModal" style =" left: 600px;margin-top:21px;padding: 5px 6px;"/>
                </div>
                <!--
                <div class="col-sm-1 pull-right ">

                    <input type="button" value = "Download" onclick ="functwo()" style =" left: 600px;margin-top:21px;padding: 4px 6px;" class="btn btn-success"/>
                </div>
                -->
                <div class="col-sm-1 pull-right ">
                    <form method="post" action="Devices_CSV.php" align="center" style="margin-top:11px;margin-left:-20px;">  
                        <input type="submit" name="export" value="Download" class="btn btn-success" />
                        <input type="hidden" name="exportQuery" id="exportQuery" />  
                     </form>
                </div>

                <div class="col-sm-4 pull-right">
                    <br/>
                    <input type="text" ng-model="search" ng-change="filter()" placeholder="Search" class="form-control" />
                </div>

            </div>
            
            <br/>
            <div class="row">
                <div class="col-md-12" ng-show="filter_data > 0">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>Device id&nbsp;<a ng-click="sort with(`D_id`);"><i class="glyphicon glyphicon-sort"></i></a></th>
                            <th>Building name&nbsp;<a ng-click="sort with('Building_name');"><i class="glyphicon glyphicon-sort"></i></a></th>
                            <th>Room number&nbsp;<a ng-click="sort_with('Room_number');"><i class="glyphicon glyphicon-sort"></i></a></th>
                            <th>Raspberry id&nbsp;<a ng-click="sort_with('Rasp_id');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th>Arduino id&nbsp;<a ng-click="sort_with('Ardu_id');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th>No of AC&nbsp;<a ng-click="sort_with('No_of_AC');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th>Action&nbsp;<i class="glyphicon glyphicon-sort"></i></th>

                        </thead>
                        <tbody>
                            <tr ng-repeat="data in searched = (file | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit">
                                <td>{{data.id}}</td>
                                <td>{{data.Building_name}}</td>
                                <td>{{data.Room_number}}</td>
                                <td>{{data.Rasp_id}}</td>
                                <td>{{data.Ardu_id}}</td>
								<td>{{data.No_of_AC}}</td>
								<td><button id="{{data.D_id}}" onclick="Delete(this.id)" class="btn btn-danger">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12" ng-show="filter_data == 0">
                    <div class="col-md-12">
                        <h4>No records found..</h4>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-6 pull-left">
                        <h5>Showing {{searched.length}} of {{entire_user}} entries</h5>
                    </div>
                    <div class="col-md-6" ng-show="filter_data > 0">
                        <div pagination="" page="current_grid" on-select-page="page_position(page)" boundary-links="true" total-items="filter_data" items-per-page="data_limit" class="pagination-small pull-right" previous-text="&laquo;" next-text="&raquo;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.12/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.10.0/ui-bootstrap-tpls.min.js"></script>
    <script src="Device_MainJS.js"></script>

    <div class="modal fade" id="addModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h1 class="modal-title">Add Device</h1>
            <label>Enter All Field</label>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body" onmouseover="func()">
             <div class="form-group">
              <label>Building:</label>
              
              <select id="building" class="form-control">
              <?php 
              /* this is code is added */
                $query = "SELECT * FROM tbl_building";  
                $result = mysqli_query($connect, $query);  
           
                if(mysqli_num_rows($result) > 0)  
                {
          		    $output='<option value="">SELECT</option>';
                    while($row = mysqli_fetch_array($result))  
                    {  
                       echo '<option value="'.$row["building"].'">'.$row["building"].'</option>';  
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
              <label>No. of A.C:</label>
              <input type="del" name="" id="ac" class="form-control" />
            </div>

            <div class="form-group">
              <label>Raspbarry id:</label>
              <input type="text" name="" id="rid" class="form-control" />
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
    
    <footer style="background-color:#98C5E1;height:40px;padding-top:10px;">
  
  <div class="text-center" style="padding-left:250px;">© 2019 Copyright:
    <a href="#">Advance Data Management System</a>
    <span style="float:right;padding-right:120px;"><a href="About_US.html">Development Team</a></span>
  </div>

</footer>
</body>
</html>

<script>

function func(){
  var action='insert';
  var building=$('#building').val();
  var room_no=$('#room_no').val();
  var ac=$('#ac').val();
  var rid=$('#rid').val();
  var aid=$('#aid').val();
  if(building=='' || room_no=='' || ac=='' || rid=='' || aid=='')
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
  var rid=$('#rid').val();
  var aid=$('#aid').val();

  $.ajax(
  {
    url:"Device_table_ajax.php",
    type:'post',
    data:{action:action, building:building, room_no:room_no, ac:ac, rid:rid, aid:aid},
    success:function(data, status){
    $('#building').val('');
    $('#room_no').val('');
    $('#ac').val('');
    $('#rid').val('');
    $('#aid').val('');

    document.location.reload(true);
  }

  });
}

function Delete(id) 
{
    var action = "delete";
    var conf = confirm("Are you sure!");
    if (conf == true) 
    {
     $.ajax({
            url:"Device_table_ajax.php",
            type:'post',
            data:{action:action, id:id },
            success:function(data, status){
                document.location.reload(true);
            }
        });
    }
}
</script>