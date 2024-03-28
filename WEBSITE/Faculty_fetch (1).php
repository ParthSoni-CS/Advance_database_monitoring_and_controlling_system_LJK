<?php
$id = $_COOKIE['id'];
include 'source.php';
$query = "SELECT `Main_table`.`Sr_no`, `Main_table`.`User_id`, `Main_table`.`Reading_date`, `Main_table`.`In_time`, `Main_table`.`Out_time`, `Main_table`.`Total_time`, `Main_table`.`Consumption`,`Main_table`.`Humidity`, `Main_table`.`Temperature`, `Main_table`.`Status`, `Details_show`.`Building_name`, `Details_show`.`No_of_AC`, `Details_show`.`Room_number` FROM `Main_table`, `Details_show`, User_info WHERE `User_info`.`User_id`='$id' AND `User_info`.`User_id`=`Main_table`.`User_id`  AND `Main_table`.`Ardu_id` = `Details_show`.`Ardu_id` ORDER BY Sr_no DESC" ;
$result = $connect->query($query) or die($connect->error . __LINE__);
$fetch_data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fetch_data[] = $row;
    }
}
$jResponse = json_encode($fetch_data);
echo $jResponse;
?>
