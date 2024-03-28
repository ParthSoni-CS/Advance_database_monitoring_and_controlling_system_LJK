<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Advanced Data Monitoring System</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
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
</head>
<body>
    
    <div ng-app="Faculty_MainJS" ng-controller="controller">
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
                    <form method="post" action="Faculty_CSV.php" align="center" style="margin-top:11px;margin-left:-20px;">  
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

                            <th>Sr no&nbsp;<a ng-click="sort_with('Sr_no');"><i class="glyphicon glyphicon-sort"></i></a></th>
                            <th>Building name&nbsp;<a ng-click="sort with('Building_name');"><i class="glyphicon glyphicon-sort"></i></a></th>
                            <th>Room number&nbsp;<a ng-click="sort_with('Room_number');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th>Reading date&nbsp;<a ng-click="sort_with('Reading_date');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th>In time&nbsp;<a ng-click="sort_with('In_time');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th>Out time&nbsp;<a ng-click="sort_with('Out_time');"><i class="glyphicon glyphicon-sort"></i></a></th>
                            <th>Total time&nbsp;<a ng-click="sort_with('Total_time');"><i class="glyphicon glyphicon-sort"></i></a></th>
                            <th>No of AC&nbsp;<a ng-click="sort_with('No_of_AC');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th>Temperature&nbsp;<a ng-click="sort_with('Temperature');"><i class="glyphicon glyphicon-sort"></i></a></th>
                            <th>Consumption&nbsp;<a ng-click="sort_with('Consumption');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th>Humidity&nbsp;<a ng-click="sort_with('Humidity');"><i class="glyphicon glyphicon-sort"></i></a></th>
							<th>Status&nbsp;<a ng-click="sort_with('Status');"><i class="glyphicon glyphicon-sort"></i></a></th>
                        </thead>
                        <tbody>
                            <tr ng-repeat="data in searched = (file | filter:search | orderBy : base :reverse) | beginning_data:(current_grid-1)*data_limit | limitTo:data_limit">
                                <td>{{data.Sr_no}}</td>
                                <td>{{data.Building_name}}</td>
                                <td>{{data.Room_number}}</td>
                                <td>{{data.Reading_date}}</td>
                                <td>{{data.In_time}}</td>
								<td>{{data.Out_time}}</td>
								<td>{{data.Total_time}}</td>
                                <td>{{data.No_of_AC}}</td>
                                <td>{{data.Consumption}}</td>
								<td>{{data.Temperature}}</td>
								<td>{{data.Humidity}}</td>
								<td>{{data.Status}}</td>
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
    <script src="Faculty_MainJS.js"></script>
</body>
</html>
