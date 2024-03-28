<?php
include 'source.php';

if(isset($_POST['action']))
{
    //show
    if($_POST['action']=='show')
    {
        $output='';
        $building=$_POST['building'];
        $query="SELECT `Rasp_id` FROM `branch_building` WHERE Building_name LIKE '% ".$building." %'";
        mysqli_query($connect,$query);
        while($row = mysqli_fetch_array($result))
        {
            $output.=' <label>Raspbarry id:</label>
              
             <input type="text" disabled="disabled" name="" id="rid" value="'.$row[Rasp_id].'" class="form-control" /> ';
        }
        echo $output;
    }
    //insert
     if ($_POST['action']=='insert')
  {
    $building=$_POST['building'];
   
    $rid=$_POST['rid'];
   
    $sta= "Unlocked";

    //$query="INSERT INTO device (Rasp_id, Ardu_id, Building_name, Room_number, No_of_AC) VALUES ('$rid', '$aid', '$building', '$room_no', '$ac')";
    $query="INSERT INTO `branch_building`(`Rasp_id`,  `Building_name`, `Status`) VALUES ('$rid',  '$building', '$sta' )";
    mysqli_query($connect, $query);
  }
    //fetch
  if($_POST['action']=='fetchData')
  {
    $output = '';
    if(isset($_POST["query"])) 
    {
      $query = "SELECT * FROM `branch_building` WHERE Building_name LIKE '%".$_POST["query"]."%'";
    }
    else
    {
       $query = "SELECT * FROM `branch_building` ";
    }

    $result = mysqli_query($connect, $query);
    
    

    if(mysqli_num_rows($result) > 0)
    {
         $output .='<section id="facilities">
 <div class="container">
  <div class="row">';
        
         while($row = mysqli_fetch_array($result))
         {
            $B_id = $row["B_id"];
            $no_of_system = 0;
            $no_of_system_on = 0;
            $no_of_rooms = 0;
            $query1 = "SELECT * FROM `rooms` WHERE `B_id` = '$B_id' ";
            $result1 = mysqli_query($connect,$query1);
            if(mysqli_num_rows($result1) > 0){
                
                while($row1 = mysqli_fetch_array($result1))
                {
                    $no_of_rooms = mysqli_num_rows($result1);
                    $R_id = $row1["R_id"];
                    $query3 = "SELECT * FROM `room_details` WHERE `R_id` = '$R_id' ";
                    $result3 = mysqli_query($connect,$query3);
                    $no =  mysqli_num_rows($result3);
                    $no_of_system = $no_of_system + $no ; 

                    $query4 = "SELECT * FROM `room_details` WHERE `R_id` = '$R_id' AND `Status_ac` = 'ON'  ";
                    $result4 = mysqli_query($connect,$query4);
                    $no1 =  mysqli_num_rows($result4);
                    $no_of_system_on = $no_of_system_on + $no1;
                }
            }



            // $output .= '
            // // <tr>
            // //   <td>'.$row["Building_name"].' </td>
            // //   <td>'.(($row['Status']=='Locked') ? '<button onclick="change(\'Unlocked\', \''.$row["Building_name"]. '\')" class="btn btn-danger"><i class="fa fa-lock" aria-hidden="true"></i></button>':'<button onclick="change(\'Locked\', \''.$row["Building_name"]. '\')" class="btn btn-success"><i class="fa fa-unlock" aria-hidden="true"></i></button>').'</td>
            // //   <td>'.$row["Room_number"].'</td>
              
            // //   <td>'.(($row['Status']=='Locked') ? '<button onclick="changeroom(\'Unlocked\', \''.$row["Building_name"]. '\',\''.$row["Room_number"]. '\')" class="btn btn-danger"><i class="fa fa-lock" aria-hidden="true"></i></button>':'<button onclick="changeroom(\'Locked\', \''.$row["Building_name"].'\',\''.$row["Room_number"].'\')" class="btn btn-success"><i class="fa fa-unlock" aria-hidden="true"></i></button>').
            //   '</td>
            // </tr>';
               $output .='<div class="col-md-3 adjust">
               <a style = "text-decoration:none" href="Room_view.php?qry='.$row["B_id"].'">          
    <div class="card" style="background-color: 	#000000">
    
    
       <p class="cardhead"><font color="white">'.$row["Building_name"].'</font></p>
      <div class="card-body"  style="background-color: #F0F8FF">
     <h6>Active : <font color="#32CD32	">'.$no_of_system_on.'</font></h6> <h6> Total : <font color="	#000080">'.$no_of_system.'</font></h6>
      <h6>'.(($row['Status']=='Locked') ? '<font color="red">'
      .$row["Status"].'</font>':'<font color="#008000	">'.$row["Status"].'</font>').
    '</h6>
    <h6>Total Rooms : '
      .$no_of_rooms.
    '</h6>
    </div>
    
    </div>
    </a>
   </div>';
         }
          $output .= ' </div>
 </div>
</section>';
         echo $output;
    }
    else
    {
        echo '<div align="center">
                <h2>Data Not Found</h2>
              </div>';
    }
  }
}
  
  ?>