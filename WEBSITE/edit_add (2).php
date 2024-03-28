<?php
    include 'source.php';
// 	$json=file_get_contents('php://input');
// 	$data =  json_decode($json,TRUE);
// 	$temp = $data["temp"];
//      $hum = $data["hum"];
//      $rid = $data["rid"];
//      $aid = $data["aid"];
//      $cid = $data["cid"];
//      $Sta = $data["st"];
          if ($_GET["rid"]!='' and $_GET["hum"]!='' and $_GET["aid"]!='' and $_GET["cid"]!='' and $_GET["temp"]!='' and $_GET["st"]!='')
         {
        $rid = $_GET["rid"];
        $aid = $_GET["aid"];
        $Sta = $_GET["st"];
        $consum = $_GET["con"];
        $temp = $_GET["temp"];
        $hum = $_GET["hum"];
        $cid = $_GET["cid"];
        
          }
    // else 
    // {
    //     echo "connected, but error in data";
    // }
$status="";



//$con = mysqli_connect('localhost', 'id9736970_ljiet_project', '123456', 'id9736970_ac_project');


date_default_timezone_set('Asia/Kolkata');


//$dateS = date('m/d/Y h:i:s', time());
$rdate = date('d/m/y' , time());
$intime = date('H:i:s',time());
$otime = "-";
$ttime = "-";
$co = "-";
$qry1="SELECT `Room_number` FROM `Details_show` WHERE `Rasp_id`='$rid' AND `Ardu_id`='$aid'";
 $r1=mysqli_query($connect,$qry1);
 $row1=mysqli_fetch_array($r1);
 $rno=$row1["Room_number"];

 $qry2="SELECT `B_id` FROM `branch_building` WHERE `Rasp_id`='$rid'";
 $r2=mysqli_query($connect,$qry2);
 $row2=mysqli_fetch_array($r2);
 $bid=$row2["B_id"];

$qry3="SELECT `R_id` FROM `rooms` WHERE `B_id`='$bid' AND `room`='$rno'";
$r3=mysqli_query($connect,$qry3);
$row3=mysqli_fetch_array($r3);
$RID=$row3["R_id"];

$q1 = "SELECT `User_id` FROM `User_info` WHERE `Card_id` = '$cid' ";
$ro = mysqli_query($connect,$q1);
$f = mysqli_fetch_array($ro,MYSQLI_ASSOC);
$uid = $f['User_id'];
if($uid != NULL)
{
// 	$q = "SELECT Status FROM `Details_show` WHERE Ardu_id='$aid' and Rasp_id='$rid'";
// 	$r = mysqli_query($connect,$q);
// 	$ff = mysqli_fetch_array($r,MYSQLI_ASSOC);
// 	$stl = $ff['Status'];
	$qry4 = "SELECT `Status` FROM `rooms` WHERE `R_id` = '$RID'";
	$rs = mysqli_query($connect,$qry4);
	$row5 = mysqli_fetch_array($rs,MYSQLI_ASSOC);
	$st = $row5["Status"];
	if($st =='Unlocked')
	{
		$aqg="SELECT Total_hours FROM `Access_grant` WHERE User_id='$uid'";
		$rqg = mysqli_query($connect,$aqg);
		$fqg = mysqli_fetch_array($rqg,MYSQLI_ASSOC);
		$stl = $fqg['Total_hours'];
		$instr_arr = preg_split ("/\:/", $stl);
		$H = (int)$instr_arr[0];
		$M = (int)$instr_arr[1];
		//echo$H.$M;
		if($H>=0 AND $M>=0)
		{
		    $qry5 ="UPDATE `room_details` SET `Status_ac`='$Sta' WHERE `R_id`='$RID' AND `Ardu_id`='$aid'";
			$r5= mysqli_query($connect, $qry5);

			$qrr = "INSERT INTO `Main_table`(`Sr_no`, `Rasp_id`, `Ardu_id`, `User_id`, `Reading_date`, `In_time`, `Out_time`, `Total_time`, `Consumption`, `Humidity`, `Temperature`, `Status`) VALUES (NULL,'$rid','$aid','$uid','$rdate','$intime','$otime','$ttime','$consum','$hum','$temp','$Sta')";
			$res = mysqli_query($connect, $qrr);
			
			//echo var_dump($res);
			if($res)
			{
    			$row = mysqli_affected_rows($connect);
    			if($row>0)
    			{
    				$status="true";
    			}
    			 else {
    				 $status="false";
    			}
			}
			else
			{
			    $status = "Not inserted";
			}
			}
		
		else{
			$status = "Dont have sufficient balance";
		}
	}
	else
	{
		$status = "Access Denied";
	}
}
else{
	$status = "Invalud card";
}

header("Content-Type:application/json");
echo json_encode(array("status"=>$status));


?>
