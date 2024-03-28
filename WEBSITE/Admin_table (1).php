<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Advanced Data Monitoring System</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body bgcolor="#A9A9A9">
    <div ng-app="Admin_MainJS" ng-controller="controller">
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
                    <form method="post" action="Admin_CSV.php" align="center" style="margin-top:11px;margin-left:-20px;">  
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
                    <table class="table table-bordered">
                         <thead class="table table-dark" >

                            <th class="h4" style="font:bold;">Sr no<a ng-click="sort_with('Sr_no');"><i class="glyphicon glyphicon-sort"></i></a></th>
                            <th class="h4" style="font:bold;">Building name&nbsp; <a ng-click="sort with('Building_name');"><i class="glyphicon glyphicon-sort"></i></a></th>
                            <th class="h4" style="font:bold;">Room number &nbsp;<a ng-click="sort_with('Room_number');"><i class="glyphicon glyphicon-sort"></i></a></th>
                            <th class="h4" style="font:bold;">User id<a ng-click="sort_with('User_id');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th class="h4" style="font:bold;">Reading date&nbsp;  <a ng-click="sort_with('Reading_date');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th class="h4" style="font:bold;" >In time &nbsp;<a ng-click="sort_with('In_time');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th class="h4" style="font:bold;">Out time &nbsp;<a ng-click="sort_with('Out_time');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th class="h4" style="font:bold;">Total time&nbsp;<a ng-click="sort_with('Total_time');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th class="h4" style="font:bold;">No of AC&nbsp;<a ng-click="sort_with('No_of_AC');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th class="h4" style="font:bold;">Temperature&nbsp;<a ng-click="sort_with('Temperature');"><i class="glyphicon glyphicon-sort"></i></a></th>
                            <th class="h4" style="font:bold;">Consumption&nbsp;<a ng-click="sort_with('Consumption');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th class="h4" style="font:bold;">Humidity&nbsp;<a ng-click="sort_with('Humidity');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th class="h4" style="font:bold;">Status&nbsp;<a ng-click="sort_with('Status');"><i class="glyphicon glyphicon-sort"></i></a></th>
							
                        </thead>
                        <tbody class="table table-active" >
                            <tr ng-repeat="data in searched = (file | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit">
                                <td class="h3" style="font:bold;">{{data.Sr_no}}</td>
                                <td class="h3" style="font:bold;">{{data.Building_name}}</td>
                                <td class="h3" style="font:bold;">{{data.Room_number}}</td>
                                <td class="h3" style="font:bold;">{{data.User_id}}</td>
                                <td class="h3" style="font:bold;">{{data.Reading_date}}</td>
                                <td class="h3" style="font:bold;">{{data.In_time}}</td>
								<td class="h3" style="font:bold;">{{data.Out_time}}</td>
								<td class="h3" style="font:bold;">{{data.Total_time}}</td>
								<td class="h3" style="font:bold;">{{data.No_of_AC}}</td>
								<td class="h3" style="font:bold;">{{data.Temperature}}</td>
								<td class="h3" style="font:bold;">{{data.Consumption}}</td>
								<td class="h3" style="font:bold;">{{data.Humidity}}</td>
								<td class="h3" style="font:bold;">{{data.Status}}</td>
								
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
                        <h5>Showing {{ searched.length }} of {{ entire_user}} entries</h5>
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
    <script src="Admin_MainJS.js"></script>
</body>
</html>
