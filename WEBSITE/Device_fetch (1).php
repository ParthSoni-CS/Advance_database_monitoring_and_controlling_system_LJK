<?php
include 'source.php';
$query = "SELECT `D_id`, `Rasp_id`, `Ardu_id`, `Building_name`, `Room_number`, `No_of_AC` FROM `Details_show` WHERE 1" ;
$result = $connect->query($query) or die($connect->error . __LINE__);
$fetch_data = array();
$no = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row+=array("id" => $no);
        $fetch_data[] = $row;
        $no++;
    }
}
$jResponse = json_encode($fetch_data);
echo $jResponse;
?>
