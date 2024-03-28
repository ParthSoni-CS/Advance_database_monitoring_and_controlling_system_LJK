<html>
<body>
<?php
include 'source.php';

 
     $aid = 'ARD001';
     $sta = $data["st"];
     $consum = $data["con"];
	 $temp = $data["temp"];
     $hum = $data["hum"];
     $cid = '192.168.1.2';
$rdate = date('d/m/y' , time());

$rid='192.168.1.2';
$OFF='OFF';
$q1 = "SELECT In_time, Sr_no, User_id FROM Main_table WHERE Ardu_id = '$aid' AND Rasp_id = '$rid' AND Status = 'OFF'";
$ro= mysqli_query($connect,$q1);

//$f=  mysqli_fetch_array($ro,MYSQLI_ASSOC);

while ($f=mysqli_fetch_array($ro))
 {
$itime = $f['In_time'];
        echo $f['In_time'];
	echo "   ";
	echo $f['Sr_no'];
	echo "   ";
	echo $f['User_id'];

?>
	<br>
<?php
    }

  $cid = '192.168.1.2';
$qr3 = "SELECT `User_id` FROM `User_info` WHERE `Card_id` = '$cid' ";
        $roo = mysqli_query($connect,$qr3);
while ($f1=mysqli_fetch_array($roo))
 {
        echo $f1['User_id'];
	echo "   ";

?>
	<br>
<?php
    }

date_default_timezone_set('Asia/Kolkata');
$intime = date('H:i:s',time());
$rdate = date('d/m/y' , time());

echo $intime;
echo $rdate;
//function diff_time($itime, $intime)
{
    $str_arr = preg_split ("/\:/", $itime);
    $instr_arr = preg_split ("/\:/", $intime);
    $H = $instr_arr[0];

    $M = $instr_arr[1];

    $S = $instr_arr[2];
    echo $S;
    $h = $str_arr[0];
    echo $h;
    $m = $str_arr[1];
    echo $m;
    $s = $str_arr[2];
    echo $s;

    $ho[0] = $H - $h;
    echo $ho[0];

    if($M>=$m){
        $ho[1] = $M - $m;
        echo $ho[1];
    }
    else{
        $ho[0] = $ho[0] - 1;
        $ho[1] = $M + 60 - $m;
        echo $ho[1];
    }
    if($S>=$s){
        $ho[2] = $S - $s;
       echo $ho[2];
    }
    else{
        $ho[1] = $ho[1] - 1;
        if($ho[1]<0)
        {
            $ho[1] = $ho[1]+60;
        }
        $ho[2] = $S + 60 - $s;
       echo $ho[2];
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

if($uid != NULL && $uid1 != NULL)
        {
            echo $itime." ".$intime;
            $result = diff_time($itime, $intime);
            echo" ".$result;
            $qrr = "UPDATE `Main_table` SET `Out_time`='$intime',`Total_time`='$result',`Status`='$sta',`Consumption` = '$consum', `Humidity`= '$hum', `Temperature` = '$temp' WHERE Sr_no = '$srno'";
            $res = mysqli_query($connect, $qrr);
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
                    $status="false";
                }
            }
            else
            {
                $status="false";
            }
        }
echo $status;
?>
