<?php

    
    include 'source.php';
	// $json=file_get_contents('php://input');
	// $data =  json_decode($json,TRUE);
	// $temp = $data["temp"];
 //     $hum = $data["hum"];
 //     $rid = $data["rid"];
 //     $aid = $data["aid"];
 //     $cid = $data["cid"];
 //     $Sta = $data["st"];

if ($_GET["rid"]!='' and $_GET["hum"]!='' and $_GET["aid"]!='' and $_GET["temp"]!='' and $_GET["sta"]!='')
         {
        $rid = $_GET["rid"];
        $aid = $_GET["aid"];
        $sta = $_GET["sta"];
        $consum = $_GET["consum"];
        $temp = $_GET["temp"];
        $hum = $_GET["hum"];
          }

$status="";



//$con = mysqli_connect('localhost', 'id9736970_ljiet_project', '123456', 'id9736970_ac_project');


date_default_timezone_set('Asia/Kolkata');

//$dateS = date('m/d/Y h:i:s', time());
$rdate = date('d/m/y' , time());
$intime = date('H:i:s',time());
$otime = "-";
$ttime = "-";
$co = "-";
$uid="";
		
			$qrr = "INSERT INTO `Main_table`(`Sr_no`, `Rasp_id`, `Ardu_id`, `User_id`, `Reading_date`, `In_time`, `Out_time`, `Total_time`, `Consumption`, `Humidity`, `Temperature`, `Status`) VALUES (NULL,'$rid','$aid','$uid','$rdate','$intime','$otime','$ttime','$co','$hum','$temp','$sta')";
			$res = mysqli_query($connect, $qrr);
			$row = mysqli_affected_rows($connect);
			if($row>0)
			{
				$status="true";
			}
			 else {
				 $status="false";
			}
		
	

echo $status;


?>
