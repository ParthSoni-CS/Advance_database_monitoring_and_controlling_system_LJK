<?php
include 'source.php';
if(isset($_POST['action']))
{
	//insert data
	if ($_POST['action']=='insert')
	{
		$building=$_POST['building'];
		$room_no=$_POST['room_no'];
		$ac=$_POST['ac'];
		$rid=$_POST['rid'];
		$aid=$_POST['aid'];
		$sta= "Unlocked";

		//$query="INSERT INTO device (Rasp_id, Ardu_id, Building_name, Room_number, No_of_AC) VALUES ('$rid', '$aid', '$building', '$room_no', '$ac')";
		$query="INSERT INTO `Details_show`(`Rasp_id`, `Ardu_id`, `Building_name`, `Room_number`, `No_of_AC`, `Status`) VALUES ('$rid', '$aid', '$building', '$room_no', '$ac' , '$sta' )";
		mysqli_query($connect, $query);
		$q1="SELECT `B_id` FROM `branch_building` WHERE `Building_name`='$building'";
		$res1=mysqli_query($connect,$q1);
		$row1=mysqli_fetch_array($res1);
		$bid=$row1['B_id'];
		$q2="INSERT INTO `rooms`(`R_id`, `room` , `Status`,`B_id`) VALUES (NULL, '$room_no', '$sta', '$bid' )";
		mysqli_query($connect,$q2);
		$q3="SELECT `R_id` FROM `rooms` WHERE `room`='$room_no' && `B_id`='$bid'";
		$res2=mysqli_query($connect,$q3);
		$row2=mysqli_fetch_array($res2);
		$roomid=$row2['R_id'];
		$q4="INSERT INTO `room_details`(`R_id`, `id` , `Ardu_id`,`Status_ac`) VALUES ($roomid, NULL, '$aid', 'OFF' )";
		mysqli_query($connect,$q4);
		
	}
	
	//insertbuilding
	if($_POST['action']=='insertbuilding')
	{
	    $bname=$_POST['building'];
	    $rid=$_POST['rid'];
	  
	        $q2="INSERT INTO `branch_building`(`B_id`,`Rasp_id`,`Building_name`,`Status`) VALUES(NULL,'$rid','$bname','unlocked')";
	        mysqli_query($connect,$q2);
	    
	}
	
	//getDetail
	if ($_POST['action']=='delete')
	{
		if(isset($_POST['id']))
		{
		  $query = "DELETE FROM Details_show WHERE D_id = '".$_POST["id"]."'";
		  $result = mysqli_query($connect, $query);  
	  	}
	}

}

?>
