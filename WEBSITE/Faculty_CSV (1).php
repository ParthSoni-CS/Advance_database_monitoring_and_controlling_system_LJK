<?php  
 if(isset($_POST['export'])){
    $id = $_COOKIE['id'];
    include 'source.php';
      
      $filename = "Faculty_table.csv";
      $fp = fopen('php://output', 'w');

    header('Content-type: application/csv');
    header('Content-Disposition: attachment; filename='.$filename);
    $header=array('Sr no','Reading date','In time','Out time','Total time','Consumption','Humidity','Temperature','Status','Building name','Number of A.C.','Room number');
    fputcsv($fp, $header);
    
     $query = "SELECT `Main_table`.`Sr_no`, `Main_table`.`Reading_date`, `Main_table`.`In_time`, `Main_table`.`Out_time`, `Main_table`.`Total_time`, `Main_table`.`Consumption`,`Main_table`.`Humidity`, `Main_table`.`Temperature`, `Main_table`.`Status`, `Details_show`.`Building_name`, `Details_show`.`No_of_AC`, `Details_show`.`Room_number` FROM `Main_table`, `Details_show`, User_info WHERE `User_info`.`User_id`='$id' AND `User_info`.`User_id`=`Main_table`.`User_id`  AND `Main_table`.`Ardu_id` = `Details_show`.`Ardu_id`" ;
    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_row($result)) {
    	fputcsv($fp, $row);
    }
    exit;
}
?>