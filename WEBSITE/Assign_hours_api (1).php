<?php
include 'source.php';


extract($_POST);
if(isset($update))
{
	$val=$_POST['uid'];
	$toadd=$_POST['time'];


$q = "SELECT `Access_grant`.`Total_hours` FROM `Access_grant` WHERE `Access_grant`.`User_id` = '$val'";
$ro= mysqli_query($connect,$q);
$f=  mysqli_fetch_array($ro,MYSQLI_ASSOC);

$ttime = $f['Total_hours'];

//echo $ttime;



$str_arr = preg_split ("/\:/", $ttime);
$h = $str_arr[0];
$h = $h + $toadd;
$str_arr[0] = $h;
//echo $str_arr[0];
$updTime = implode(':', $str_arr);
//echo $updTime;


$query = "UPDATE `Access_grant` SET `Access_grant`.`Total_hours`= '$updTime' WHERE `Access_grant`.`User_id` = '$val'";

$res = mysqli_query($connect, $query);

$status = '';

if(mysqli_affected_rows($connect))
{
    $status="true";
    header("location:Assign_table.php");
    
}
 else {
     $status="false";
}

//echo $status;


}


?>

<?php

?>


