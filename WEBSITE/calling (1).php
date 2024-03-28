<?php
    function allBuilding($b_name,$switch){
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
}
?>