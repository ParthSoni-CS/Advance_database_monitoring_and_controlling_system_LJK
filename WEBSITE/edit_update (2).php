<?php
    
// 	$json=file_get_contents('php://input');
// 	$data =  json_decode($json,TRUE);

//      $rid = $data["rid"];
//      $aid = $data["aid"];
//      $sta = $data["st"];
//      $consum = $data["con"];
// 	 $temp = $data["temp"];
//      $hum = $data["hum"];
//      $cid = $data["c_id"];

//'hum': Hum , 'rid': Rid ,'aid': Aid ,'con': Con, 'cid': Cid ,'temp': Temp,'st': St
       if ($_GET["rid"]!='' and $_GET["hum"]!='' and $_GET["aid"]!='' and $_GET["cid"]!='' and $_GET["temp"]!='' and $_GET["st"]!='')
         {
        $rid = $_GET["rid"];
        $aid = $_GET["aid"];
        $sta = $_GET["st"];
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



include 'source.php';


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

 $qry1="SELECT `Room_number` FROM `Details_show` WHERE `Rasp_id`='$rid' AND `Ardu_id`='$aid'";
 $r1=mysqli_query($connect,$qry1);
 $row1=mysqli_fetch_array($r1);
 $rno=$row1["Room_number"];

 $qry2="SELECT `B_id` FROM `branch_building` WHERE `Rasp_id`='$rid'";
 $r2=mysqli_query($connect,$qry2);
 $row2=mysqli_fetch_array($r2);
 $bid=$row2["B_id"];

$q3="SELECT `R_id` FROM `rooms` WHERE `B_id`='$bid' AND `room`='$rno'";
$r3=mysqli_query($connect,$q3);
$row3=mysqli_fetch_array($r3);
$RID=$row3["R_id"];

 $q1 = "SELECT In_time, Sr_no, User_id FROM `Main_table` WHERE Ardu_id = '$aid' AND Rasp_id = '$rid' AND Status = 'ON' AND Reading_date = '$rdate' ";
// $q1 = "SELECT In_time, Sr_no, User_id FROM `Main_table` WHERE Ardu_id = '$aid' AND Rasp_id = '$rid' AND Status = 'ON' ";
$ro= mysqli_query($connect,$q1);
$f=  mysqli_fetch_array($ro,MYSQLI_ASSOC);
$itime = $f['In_time'];
$srno = $f['Sr_no'];
$uid = $f['User_id'];
if($srno != NULL)
    {
        $qr3 = "SELECT `User_id` FROM `User_info` WHERE `Card_id` = '$cid' ";
        $roo = mysqli_query($connect,$qr3);
        $fo = mysqli_fetch_array($roo,MYSQLI_ASSOC);
        $uid1 = $fo['User_id'];

        if($uid != NULL && $uid1 != NULL)
        {
            //echo $itime." ".$intime;
            $result = diff_time($itime, $intime);
            //echo" ".$result;
            $qrr = "UPDATE `Main_table` SET `Out_time`='$intime',`Total_time`='$result',`Status`='$sta',`Consumption` = '$consum', `Humidity`= '$hum', `Temperature` = '$temp'  WHERE Sr_no = '$srno'  ";
            $res = mysqli_query($connect, $qrr);
            
            $qry5="UPDATE `room_details` SET `Status_ac`='$sta' WHERE `Ardu_id`='$aid' AND `R_id`='$RID'";
            $r5= mysqli_query($connect,$qry5);
            if(mysqli_affected_rows($connect))
            {
                $q2 = "SELECT Total_hours FROM `Access_grant` WHERE User_id='$uid'";
                $r = mysqli_query($connect,$q2);
                $ff = mysqli_fetch_array($r,MYSQLI_ASSOC);
                $th = $ff['Total_hours'];

                $re = diff_time($result,$th);
                //echo$th." ".$re;

                $q = "UPDATE Access_grant SET Total_hours= '$re' WHERE User_id='$uid'";

                $ress = mysqli_query($connect, $q);
                if(mysqli_affected_rows($connect))
                {
                    $status="true";
                }
                else
                {
                    $status="fal";
                }
            }
            else
            {
                $status="fals";
            }
        }
        else
        {
            $status="Invalud card";
        }
    }
    else
    {
        $status ="false";
    }

header("Content-Type:application/json");
echo json_encode(array("status"=>$status));

?>
