<?php
include "source.php";

$dst=$_GET['DST'];
$rid=$_GET['rid'];
$roomno=$_GET['rno'];
$aid="ARD".$roomno;


$QR="SELECT `B_id` FROM `branch_building` WHERE `Rasp_id`='$rid'";
$RES=mysqli_query($connect,$QR);
$ROW=mysqli_fetch_array($RES);
$bid=$ROW['B_id'];

$QR1="SELECT `R_id` FROM `rooms` WHERE `B_id`='$bid' AND `room`='$roomno'";
$RES2=mysqli_query($connect,$QR1);
$ROW2=mysqli_fetch_array($RES2);
$Roomid=$ROW2['R_id'];


date_default_timezone_set('Asia/Kolkata');
$intime = date('H:i:s',time());
$rdate = date('d/m/y' , time());

function diff_time($itime, $intime)
{
    $str_arr = preg_split ("/\:/", $itime);
    $instr_arr = preg_split ("/\:/", $intime);
    $H = $instr_arr[0];

    $M = $instr_arr[1];

    $S = $instr_arr[2];
    //echo $S;
    $h = $str_arr[0];
    //echo $h;
    $m = $str_arr[1];
    //echo $m;
    $s = $str_arr[2];
    //echo $s;

    $ho[0] = $H - $h;
    //echo $ho[0];

    if($M>=$m){
        $ho[1] = $M - $m;
       // echo $ho[1];
    }
    else{
        $ho[0] = $ho[0] - 1;
        $ho[1] = $M + 60 - $m;
       // echo $ho[1];
    }
    if($S>=$s){
        $ho[2] = $S - $s;
       // echo $ho[2];
    }
    else{
        $ho[1] = $ho[1] - 1;
        if($ho[1]<0)
        {
            $ho[1] = $ho[1]+60;
        }
        $ho[2] = $S + 60 - $s;
      //  echo $ho[2];
    }
    if ($ho[0]==0){
        $ho[0]='00';
    }
    if ($ho[1]==0){
        $ho[1]='00';
    }
    if ($ho[2]==0){
        $ho[2]='00';
    }

    $ttime = implode(':', $ho);
    return$ttime;
}
if ($dst=="OFFLINE")
{
	$qrr = "SELECT In_time, Sr_no, User_id FROM `Main_table` WHERE Ardu_id = '$aid' AND Rasp_id = '$rid' AND Status = 'ON' AND Reading_date = '$rdate' ";
// $q1 = "SELECT In_time, Sr_no, User_id FROM `Main_table` WHERE Ardu_id = '$aid' AND Rasp_id = '$rid' AND Status = 'ON' ";
$ro= mysqli_query($connect,$qrr);
$f=  mysqli_fetch_array($ro,MYSQLI_ASSOC);
$itime = $f['In_time'];
$srno = $f['Sr_no'];
$uid = $f['User_id'];
$aida= $aid."A";
$qrr1 = "SELECT In_time, Sr_no, User_id FROM `Main_table` WHERE Ardu_id = '$aida' AND Rasp_id = '$rid' AND Status = 'ON' AND Reading_date = '$rdate'";

$ro1= mysqli_query($connect,$qrr1);
$f1=  mysqli_fetch_array($ro1,MYSQLI_ASSOC);
$itime1 = $f1['In_time'];
$srno1 = $f1['Sr_no'];
if($srno != NULL)
    {# code...
    	$result = diff_time($itime, $intime);
    	$qrr2 = "UPDATE `Main_table` SET `Out_time`='$intime',`Total_time`='$result',`Status`='OFFLINE',`Consumption` = '$consum', `Humidity`= '$hum', `Temperature` = '$temp'  WHERE Sr_no = '$srno'";
            $res = mysqli_query($connect, $qrr2);
            $qrr6="UPDATE `room_details` SET `Status_ac`='OFF' WHERE `R_id`='$Roomid' AND `Ardu_id`='$aid'";
            $res6=mysqli_query($connect,$qrr6);
            $qrr7="UPDATE `room_details` SET `Status_ac`='OFF' WHERE `R_id`='$Roomid' AND `Ardu_id`='$aida'";
            $res7=mysqli_query($connect,$qrr7);
        if($srno1 != NULL)
        {
           $result1 = diff_time($itime1, $intime);
     	   $qrr3 = "UPDATE `Main_table` SET `Out_time`='$intime',`Total_time`='$result1',`Status`='OFFLINE',`Consumption` = '$consum', `Humidity`= '$hum', `Temperature` = '$temp'  WHERE Sr_no = '$srno1'  ";
            $res3 = mysqli_query($connect, $qrr3);
        	
        }    

                $qrr4 = "SELECT Total_hours FROM `Access_grant` WHERE User_id='$uid'";
                $res4 = mysqli_query($connect,$qrr4);
                $ff = mysqli_fetch_array($res4,MYSQLI_ASSOC);
                $th = $ff['Total_hours'];

                $re = diff_time($result,$th);
                //echo$th." ".$re;

                $qrr5 = "UPDATE Access_grant SET Total_hours= '$re' WHERE User_id='$uid'";

                $ress5 = mysqli_query($connect, $qrr5);
    }
}
$q="SELECT `B_id` FROM `branch_building` WHERE `Rasp_id`='$rid' ";
$r=mysqli_query($connect,$q);
$row=mysqli_fetch_array($r);
$rno=$row['B_id'];
$q1="UPDATE `rooms` SET `d_st`='$dst' WHERE `B_id`='$rno' AND `room`='$roomno'";
$r1=mysqli_query($connect,$q1);
if(mysqli_affected_rows($connect))
{
    $status="true";
}
else
{
    $status="Not updated";
}
echo $status;


?>