<?php
include 'source.php';
$query = "SELECT `User_id`, `Total_hours`, `Name` FROM `Access_grant` WHERE 1" ;
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
