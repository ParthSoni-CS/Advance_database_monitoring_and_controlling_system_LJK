<?php 
include 'source.php';

 

 $rid = $_GET["rid"];
 $aid = $_GET["aid"];
 $sta = $_GET["sta"];
 $sta2 = $_GET["sta2"];
 $hum = $_GET["hum"];
 $temp = $_GET["temp"];
 $consum = $_GET["consum"];
 $aid2= "$aid"."A";

 $q1="SELECT `Room_number` FROM `Details_show` WHERE `Rasp_id`='$rid' AND `Ardu_id`='$aid'";
 $r1=mysqli_query($connect,$q1);
 $row1=mysqli_fetch_array($r1);
 $rno=$row1["Room_number"];

 $q2="SELECT `B_id` FROM `branch_building` WHERE `Rasp_id`='$rid'";
 $r2=mysqli_query($connect,$q2);
 $row2=mysqli_fetch_array($r2);
 $bid=$row2["B_id"];

$q3="SELECT `R_id` FROM `rooms` WHERE `B_id`='$bid' AND `room`='$rno'";
$r3=mysqli_query($connect,$q3);
$row3=mysqli_fetch_array($r3);
$RID=$row3["R_id"];



 $q4="SELECT `Status_ac` FROM `room_details` WHERE `Ardu_id`='$aid' AND `R_id`='$RID'";
 $r4=mysqli_query($connect,$q4);
 $row4=mysqli_fetch_array($r4);
 $live_sta=$row4["Status_ac"];

 $q7="SELECT `Status_ac` FROM `room_details` WHERE `Ardu_id`='$aid2' AND `R_id`='$RID' ";
 $r7=mysqli_query($connect,$q7);
 $row7=mysqli_fetch_array($r7);
 $live_sta2=$row7["Status_ac"];
 
date_default_timezone_set('Asia/Kolkata');
$intime = date('H:i:s',time());
//$rdate = date('d/m/y' , time());
//$RDATE = date('Y-d-m', strtotime(str_replace('-', '/', $rdate)));
$RDATE = date("Y/m/d");
$DT = "$RDATE"." "."$intime";




if ($live_sta!=$sta)
{
  $status="$live_sta";
  if($live_sta2!=$sta2)
  {
      $status2="$live_sta2"."2";
  }
  else
  {
      $status2="no change";
  }
  
  // $result = diff_time($itime, $intime);
  //           //echo" ".$result;
  //           $q6 = "UPDATE `Main_table` SET `Out_time`='$intime',`Total_time`='$result',`Status`='$live_sta',`Consumption` = '$consum', `Humidity`= '$hum', `Temperature` = '$temp' WHERE Sr_no = '$srno'";
  //           $r6 = mysqli_query($connect, $q6);
  // 	# code...
}
 else
  {
    if($live_sta2!=$sta2)
  {
      $status2="$live_sta2"."2";
  } 
  else
  {
      $status2="no change";
  }

  	$q5 = "SELECT Sr_no FROM `Main_table` WHERE Ardu_id = '$aid' AND Rasp_id = '$rid' AND Status = 'ON' AND Reading_date = '$rdate' ";
    $r5= mysqli_query($connect,$q5);
    $f=  mysqli_fetch_array($r5,MYSQLI_ASSOC);
    $srno = $f['Sr_no'];
     $qrr1 = "INSERT INTO `room_cth_data`(`R_id`, `id`, `date`, `time`, `temperature`, `humidity`, `consumption`) VALUES ('$RID',NULL,'$DT','$intime','$temp','$hum','$consum')";
            $ress1 = mysqli_query($connect, $qrr1);
            if (mysqli_affected_rows($connect))
             {
                $status="DATA ADDED SUCCESSFULLY IN GRAPH ";  	# code...
              }
           

    if($srno != NULL)
         {
    	
            //echo" ".$result;
            $qrr = "UPDATE `Main_table` SET `Consumption` = '$consum', `Humidity`= '$hum', `Temperature` = '$temp' WHERE Sr_no = '$srno'";
            $res = mysqli_query($connect, $qrr);
            if (mysqli_affected_rows($connect))
             {
                $status.=" & DATA UPDATED..NO CHANGE IN STATUS";  	# code...
              }
             
         }
    else
    {
        $status.=" & NO CHANGE in status";
    }
 	# code...
 }
 
 $st=array();
 $st[]=array("AC_1" => $status, "AC_2" => $status2);
$js = json_encode($st);
echo $js;
 ?>