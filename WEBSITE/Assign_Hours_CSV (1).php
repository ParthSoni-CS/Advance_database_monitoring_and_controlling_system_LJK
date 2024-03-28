<?php  
 if(isset($_POST['export'])){
    include 'source.php';
      
      $filename = "Assign_table.csv";
      $fp = fopen('php://output', 'w');

    header('Content-type: application/csv');
    header('Content-Disposition: attachment; filename='.$filename);
    $header=array('User id','Name','Total Hours');
    fputcsv($fp, $header);
    
     $query = "SELECT `User_id`,`Name`,`Total_hours` FROM `Access_grant` WHERE 1" ;
    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_row($result)) {
    	fputcsv($fp, $row);
    }
    exit;
}
?>