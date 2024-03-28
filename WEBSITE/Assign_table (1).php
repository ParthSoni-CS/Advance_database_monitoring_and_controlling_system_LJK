<?php

session_start();
if(!isset($_SESSION['ADMIN']))
{
	header('location:Login_Page.php');
}

?>

<!doctype html>
<html>
<head>
    <title>Advanced Data Monitoring System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <link rel="stylesheet" type="text/css" href="All_pages.css">
    <link rel="stylesheet" type="text/css" href="card.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-1.11.3.js"integrity="sha256-IGWuzKD7mwVnNY01LtXxq3L84Tm/RJtNCYBfXZw3Je0="crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript">
		function toggle(){
			document.getElementById('sidebar').classList.toggle('active');
		}
	</script>

    <script type = "text/javascript">

              function functwo() {
               
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
    <div ng-app="Assign_MainJS" ng-controller="controller">
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
                
                
                 <div class="col-sm-1 pull-right ">
                    <form method="post" action="Assign_Hours_CSV.php" align="center" style="margin-top:11px;margin-left:-20px;">  
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

                            <th>User id&nbsp;<a ng-click="sort_with('User_id');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th>Name&nbsp;<a ng-click="sort_with('Name');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th>Total hours&nbsp;<a ng-click="sort_with('Total_hours');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th>Add hours&nbsp;</a></th>

                        </thead>
                        <tbody>
                            <tr ng-repeat="data in searched = (file | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit">
                                <td>{{data.User_id}}</td>
                                <td>{{data.Name}}</td>
                                <td>{{data.Total_hours}}</td>
                                <td><a href="Assign_Add_hours.php?uid={{data.User_id}}&name={{data.Name}}&ttime={{data.Total_hours}}" class="btn btn-info btn-lg" style =" left: 600px; top: 20px;padding: 3px 2px;">Add Hours</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>


                <div class="col-md-12" ng-show="filter_data == 0">
                    <div class="col-md-12">
                        <h4>No records found..</h4>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-6 pull-left">
                        <h5>Showing {{ searched.length }} of {{ entire_user}} entries</h5>
                    </div>
                    <div class="col-md-6" ng-show="filter_data > 0">
                        <div pagination="" page="current_grid" on-select-page="page_position(page)" boundary-links="true" total-items="filter_data" items-per-page="data_limit" class="pagination-small pull-right" previous-text="&laquo;" next-text="&raquo;"></div>
                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.12/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.10.0/ui-bootstrap-tpls.min.js"></script>
    <script src="Assign_MainJS.js"></script>
</body>
</html>
