<?php
include 'source.php';
if(isset($_POST["action"]))
{
    if($_POST["action"] == "Fetch_json")
    {   
        $return_arr = array();

        $Building = $_POST["Building_name"];
        $Room = $_POST["Room_number"];
        $query = "SELECT `B_id` FROM `branch_building` WHERE `Building_name` = '$Building' ";
        $result = mysqli_query($connect,$query);
        $row = mysqli_fetch_array($result);
        $B_id = $row["B_id"];

        $query1 = "SELECT `R_id` FROM `rooms` WHERE `room` = '$Room' AND `B_id` = '$B_id' ";
        $result1 = mysqli_query($connect,$query1);
        $row1 = mysqli_fetch_array($result1);
        $R_id = $row1["R_id"];

        $query2 = "SELECT * FROM `room_cth_data` WHERE `R_id` = '$R_id' ORDER BY `date` ASC";
        $result2 = mysqli_query($connect,$query2);
        
        while($row2 = mysqli_fetch_array($result2))
        {
            $t = $row2["temperature"];
            $h= $row2["humidity"];
            $d = $row2["date"];
            $ti = $row2["time"];
            $c = $row2["consumption"];
            // $tot = $d." ".$ti;
            $return_arr[] = array(
                "temperature" => $t,
                "humidity" => $h,
                //"dt" => $d,
                "ti" => $ti,
                "tot" => $d,
                "consumption" => $c

            );
        }
        $json = json_encode($return_arr);
    echo $json;
    }
    
}

?>