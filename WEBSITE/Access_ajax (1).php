<?php
include 'source.php';
include 'calling.php';
if(isset($_POST['action']))
{
  if($_POST['action']=='fetchData')
  {
    $output = '';
    if(isset($_POST["query"]))
    {
      $query = "SELECT * FROM `Details_show` WHERE Building_name LIKE '%".$_POST["query"]."%'";
    }
    else
    {
      $query = "SELECT * FROM `Details_show`";
    }

    $result = mysqli_query($connect, $query);
    
    

    if(mysqli_num_rows($result) > 0)
    {
         $output .= '
         <div class="table-responsive">
          <table class="table table-striped tabel-hover table-bordered">
            <tr style="background-color:black;color:white;">
            <th>Building name</th>
            <th>Building access</th>
            <th>Room number</th>
            <th>Room number access</th>
            </tr>
         ';


         while($row = mysqli_fetch_array($result))
         {

            $output .= '
            <tr>
              <td>'.$row["Building_name"].' </td>
              <td>'.(($row['Status']=='Locked') ? '<button onclick="change(\'Unlocked\', \''.$row["Building_name"]. '\')" class="btn btn-danger"><i class="fa fa-lock" aria-hidden="true"></i></button>':'<button onclick="change(\'Locked\', \''.$row["Building_name"]. '\')" class="btn btn-success"><i class="fa fa-unlock" aria-hidden="true"></i></button>').'</td>
              <td>'.$row["Room_number"].'</td>
              
              <td>'.(($row['Status']=='Locked') ? '<button onclick="changeroom(\'Unlocked\', \''.$row["Building_name"]. '\',\''.$row["Room_number"]. '\')" class="btn btn-danger"><i class="fa fa-lock" aria-hidden="true"></i></button>':'<button onclick="changeroom(\'Locked\', \''.$row["Building_name"].'\',\''.$row["Room_number"].'\')" class="btn btn-success"><i class="fa fa-unlock" aria-hidden="true"></i></button>').
              '</td>
            </tr>';

         }
         $output .= '</table></div>';
         echo $output;
    }
    else
    {
        echo '<div align="center">
                <h2>Data Not Found</h2>
              </div>';
    }
  }
  //status update for building
  if($_POST['action']=='status')
  {
      if(isset($_POST['statusID']))
      {
          $status=$_POST['statusID'];
          $Building_name=$_POST['Building_name'];
          $qq = "SELECT Rasp_id, Ardu_id FROM `Details_show` WHERE Building_name = '$Building_name'";
		  $rresult = mysqli_query($connect, $qq);
		   
		   while($rrow = mysqli_fetch_assoc($rresult)) {
		        $final_result = array();
		        array_push($final_result,$status, $rrow['Rasp_id'],$rrow['Ardu_id']);
		       $url = 'http://ec2-52-66-201-249.ap-south-1.compute.amazonaws.com/Final_php_file.php';
		       //$url = 'https://ljietproject.000webhostapp.com/global/received.php';
                $ch = curl_init($url);
                $jsonData =  $final_result;
                $jsonDataEncoded = json_encode($jsonData);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
                $result = curl_exec($ch);
                unset($final_result);
		   }
          if($status=='Unlocked')
          {
            $q="UPDATE `Details_show` SET `Status`='Unlocked' WHERE Building_name = '$Building_name'";
             mysqli_query($connect, $q);
            allBuilding($Building_name,'Unlock');
          }
          else{
            $q="UPDATE `Details_show` SET `Status`='Locked' WHERE Building_name = '$Building_name'";
             mysqli_query($connect, $q);
            allBuilding($Building_name,'Lock');
              
          }
         
      }
  }
  //status update for room
  if($_POST['action']=='room_status')
  {
      if(isset($_POST['statusID']))
      {
          $status=$_POST['statusID'];
          $Building_name=$_POST['Building_name'];
          $Room_number=$_POST['Room_number'];
          $qq = "SELECT Rasp_id, Ardu_id FROM `Details_show` WHERE Building_name = '$Building_name ' and Room_number ='$Room_number'";
		  $rresult = mysqli_query($connect, $qq);
		   
		   $final_result = array();
		  // array_push($final_result,"Room_mode");
		  // array_push($final_result,$status);
		   while($rrow = mysqli_fetch_assoc($rresult)) {
		      
		       array_push($final_result,$status, $rrow['Rasp_id'],$rrow['Ardu_id']);
		       $url = 'http://ec2-52-66-201-249.ap-south-1.compute.amazonaws.com/Final_php_file.php';
		       //$url = 'https://ljietproject.000webhostapp.com/global/received.php';
                $ch = curl_init($url);
                $jsonData =  $final_result;
                $jsonDataEncoded = json_encode($jsonData);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
                $result = curl_exec($ch);
                unset($final_result);
		   }
		   
          if($status=='Unlocked')
          {
            $q="UPDATE `Details_show` SET `Status`='Unlocked' WHERE Building_name = '$Building_name' AND Room_number = '$Room_number'";
            mysqli_query($connect, $q);
            room($Building_name,'Unlock',$Room_number);
          }
          else{
            $q="UPDATE `Details_show` SET `Status`='Locked' WHERE Building_name = '$Building_name' AND Room_number = '$Room_number'";
            mysqli_query($connect, $q);
            room($Building_name,'Lock',$Room_number);
              
          }
          
      }
  }

}
 

































/*function allBuilding($b_name,$switch){
	include 'source.php';
	$query = "SELECT `Rasp_id`, `Ardu_id` FROM `Details_show` WHERE `Building_name`='$b_name'";
	$result = $connect->query($query) or die($connect->error . __LINE__);
	if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $url = 'https://amidhruv98.000webhostapp.com/client1.php'; // intialize url as per our ip address of gateway followed by slash script-name with php extension.
 
	//Initiate cURL.
	$ch = curl_init($url);
 
	//The JSON data.
	$jsonData = array( // put status here with specific variable.
		'Ardu_id' => $row['Ardu_id'],
		'Rasp_id' => $row['Rasp_id'],
		'Status' => $switch
	);
 
	//Encode the array into JSON.
	$jsonDataEncoded = json_encode($jsonData);
 
	//Tell cURL that we want to send a POST request.
	curl_setopt($ch, CURLOPT_POST, 1);
 
	//Attach our encoded JSON string to the POST fields.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
 
	//Set the content type to application/json
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
 
	//Execute the request
	$result = curl_exec($ch);
    }
}
}

function room($b_name,$switch,$r_no){
	include 'source.php';
	$query = "SELECT `Rasp_id`, `Ardu_id` FROM `Details_show` WHERE `Building_name`='$b_name' and `Room_number` = '$r_no'";
	$result = $connect->query($query) or die($connect->error . __LINE__);
	if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $url = 'https://amidhruv98.000webhostapp.com/client1.php'; // intialize url as per our ip address of gateway followed by slash script-name with php extension.
 
	//Initiate cURL.
	$ch = curl_init($url);
 
	//The JSON data.
	$jsonData = array( // put status here with specific variable.
		'Ardu_id' => $row['Ardu_id'],
		'Rasp_id' => $row['Rasp_id'],
		'Status' => $switch
	);
 
	//Encode the array into JSON.
	$jsonDataEncoded = json_encode($jsonData);
 
	//Tell cURL that we want to send a POST request.
	curl_setopt($ch, CURLOPT_POST, 1);
 
	//Attach our encoded JSON string to the POST fields.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
 
	//Set the content type to application/json
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
 
	//Execute the request
	$result = curl_exec($ch);
    }
}
}*/

?>