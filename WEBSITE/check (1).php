<?php
   $arr = array();
   array_push($arr,"Building_mode");
   array_push($arr,"Locked");
   $a = array(1,"dhruv");
   $a1 = array(2,"heli");
   array_push($arr, $a, $a1);
   //$arr = array("Room_mode", "Locked", "123", "fgh");
   $data = $arr;
   $storing_data = " "; 
   $storing_data =  $storing_data." ".$data[0];
	if ($data[0] == "Building_mode")
	{
	    $storing_data = $storing_data." ".$data[1];
	    unset($data[0]);
	    unset($data[1]);
	    foreach ($data as $pdata){
	       $storing_data = " ".$storing_data ." ". implode(" ",$pdata); ;
	    } 
	 }
	 else if ($data[0] == "Room_mode")
	    {
	    $storing_data = $storing_data." ".$data[1];
	    unset($data[0]);
	    unset($data[1]);
	    $storing_data = $storing_data." ".$data[2]." ".$data[3]; 
	    echo $storing_data;
	    }
    echo $storing_data;

	?>