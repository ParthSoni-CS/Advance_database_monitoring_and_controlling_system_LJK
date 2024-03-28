<?php  
 if(isset($_POST['export'])){
    include 'source.php';
    
      
      $filename = "Admin_table.csv";
      $fp = fopen('php://output', 'w');

    header('Content-type: application/csv');
    header('Content-Disposition: attachment; filename='.$filename);
    $header=array('Sr_no', 'User_id','Reading_date','In_time','Out_time','Total_time','Consumption','Humidity','Temperature','Status','Building_name','No_of_AC','Room_number');
    fputcsv($fp, $header);
    
     $query = "SELECT `Main_table`.`Sr_no`, `Main_table`.`User_id`, `Main_table`.`Reading_date`, `Main_table`.`In_time`, `Main_table`.`Out_time`, `Main_table`.`Total_time`, `Main_table`.`Consumption`,`Main_table`.`Humidity`, `Main_table`.`Temperature`, `Main_table`.`Status`, `Details_show`.`Building_name`, `Details_show`.`No_of_AC`, `Details_show`.`Room_number` FROM `Main_table`, `Details_show` WHERE `Main_table`.`Ardu_id` = `Details_show`.`Ardu_id` " ;
    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_row($result)) {
    	fputcsv($fp, $row);
    }
    exit;
}
?>