<?php 
include 'source.php';
if(isset($_POST['action']))
{
    if($_POST['action'] == "Fetch_Data")
    {
        $return_arry = array();
        $Building_name = $_POST['Building_name'];
        $Room_number = $_POST['Room_number'];
        $query1 = "SELECT `B_id` FROM `branch_building` WHERE `Building_name` = '$Building_name' ";
        $result1 = mysqli_query($connect,$query1);
        $row1 = mysqli_fetch_array($result1);

        $B_id = $row1["B_id"];

        $query2 = "SELECT `R_id` FROM `rooms` WHERE `B_id`='$B_id' AND `room` = '$Room_number' ";
        $result2 = mysqli_query($connect,$query2);
        $row2 = mysqli_fetch_array($result2);

        $R_id = $row2["R_id"];

        
        $query = "SELECT * FROM `room_cth_data` WHERE `R_id` = '1' ORDER BY `date` DESC LIMIT 1";
        $result = mysqli_query($connect,$query);
        $row = mysqli_fetch_array($result);

        $query3 = "SELECT SUM(`consumption`) AS 'Total_consumption' FROM `room_cth_data` WHERE `R_id` = '$R_id' ";
        $result3 = mysqli_query($connect,$query3);
        $row3 = mysqli_fetch_array($result3);

        $temperature = $row["temperature"];
        $humidity = $row["humidity"];
        $consumption = $row["consumption"];
        $Total_consumption = $row3["Total_consumption"];

        $return_arry[] = array(
            "Temperature" => $temperature,
            "Humidity" => $humidity,
            "Consumption" => $consumption,
            "TotalConsumption" => $Total_consumption
        );
        // $return_arry[] = array(
        //     "Temperature" => "A",
        //     "Humidity" => "B",
        //     "Consumption" => "C"
        //     //"TotalConsumption" => $Total_consumption
        // );

        $json = json_encode($return_arry);
        echo $json;
        
        // $max_date = $row["max_date"];
        
        // $query = 
    }
}


?>