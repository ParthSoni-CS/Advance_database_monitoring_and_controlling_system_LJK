<?php  
 if(isset($_POST['export'])){
    include 'source.php';
      
      $filename = "Devices_table.csv";
      $fp = fopen('php://output', 'w');

    header('Content-type: application/csv');
    header('Content-Disposition: attachment; filename='.$filename);
    $header=array('Raspberry id','Arduino id','Building Name','Room number','Number of A.C.');
    fputcsv($fp, $header);
    
     $query = "SELECT `Rasp_id`, `Ardu_id`, `Building_name`, `Room_number`, `No_of_AC` FROM `Details_show` WHERE 1" ;
    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_row($result)) {
    	fputcsv($fp, $row);
    }
    exit;
}
?>