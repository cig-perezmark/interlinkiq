<?php
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
include '../database.php';

if(isset($_POST['show_id'])) {
    $user_id = $_COOKIE['ID'];
    $ID = $_POST['show_id'];
    $query = "SELECT *  FROM tbl_MyProject_Services_Show_hide";
    $result = mysqli_query($conn, $query);
                                
    while($row = mysqli_fetch_array($result))
    {
        $update = false;
        $done = false;
        if($row['user_ids'] == $user_id and $row['task_id'] == $ID and $row['show_status'] == 1){
            $done = true;
            break;
        }
        else if($row['user_ids'] == $user_id and $row['task_id'] == $ID and $row['show_status'] == 0){
            $update = true;
            break;
        }
        
    }
    if($update == true){
        $user_id = $_COOKIE['ID'];
        $ID = $_POST['show_id'];
        $sql = "UPDATE tbl_MyProject_Services_Show_hide set show_status= 1 where task_id = $ID and user_ids = $user_id";
        if(mysqli_query($conn, $sql)){}
    }
    else{
       
    }
    if($done == true){
        $user_id = $_COOKIE['ID'];
        $ID = $_POST['show_id'];
        $sql = "UPDATE tbl_MyProject_Services_Show_hide set show_status= 0 where task_id = $ID and user_ids = $user_id";
        if(mysqli_query($conn, $sql)){}
    }else{
        $user_id = $_COOKIE['ID'];
    	$ID = $_POST['show_id'];
    	$sql2 = "INSERT INTO tbl_MyProject_Services_Show_hide (task_id,user_ids,show_status)
    	VALUES ('$ID','$user_id',1)";
    	
    	if (mysqli_query($conn, $sql2)) {}
    }
}

if(isset($_POST['show_ids'])){
    if(!empty($_POST["Facilty_Functions"]))
    {
        foreach($_POST["Facilty_Functions"] as $Facilty_Functions)
            {
                $fFacilty_Functions .= $Facilty_Functions . ', ';
            }
    }
    $fFacilty_Functions = substr($fFacilty_Functions, 0, -2);
}
	// modal Get Status
if( isset($_GET['modal_filter_status']) ) {
	$ID = $_GET['modal_filter_status'];

	echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
	echo '
        <table class="table table-bordered ">
            <thead class="bg-info">
                <tr>
                    <th>Assign to</th>
                    <th>Task Name</th>
                    <th>Description</th>
                    <th>Desired Due Date</th>
                </tr>
            </thead>
             <tbody>';
        $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CIA_progress = 0 and Parent_MyPro_PK = $ID order by CAI_id DESC LIMIT 100";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
         { 
            echo '
                <tr>
                    '; 
                        $emp_id =$row['CAI_Assign_to'];
                        $query_emp = "SELECT * FROM tbl_hr_employee where ID = $emp_id";
                        $result_emp = mysqli_query($conn, $query_emp);
                        while($row_emp = mysqli_fetch_array($result_emp))
                         {
                             echo '<td>'.$row_emp['first_name'].'</td>';
                         }
                        echo'
                    <td>'.$row['CAI_filename'].'</td>
                    <td>'.$row['CAI_description'].'</td>
                    <td>'.$row['CAI_Action_date'].'</td>
                </tr>
                ';
         }
         echo '
            </tbody>
         </table>';
         
    }
    
if( isset($_GET['modal_filter_status_progress']) ) {
	$ID = $_GET['modal_filter_status_progress'];

	echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
	echo '
        <table class="table table-bordered ">
            <thead class="bg-info">
                <tr>
                    <th>Assign to</th>
                    <th>Task Name</th>
                    <th>Description</th>
                    <th>Due Date</th>
                </tr>
            </thead>
             <tbody>';
        $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CIA_progress = 1 and Parent_MyPro_PK = $ID order by CAI_Action_due_date ASC LIMIT 100";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
         { 
            echo '
                <tr>
                    '; 
                        $emp_id =$row['CAI_Assign_to'];
                        $query_emp = "SELECT * FROM tbl_hr_employee where ID = $emp_id";
                        $result_emp = mysqli_query($conn, $query_emp);
                        while($row_emp = mysqli_fetch_array($result_emp))
                         {
                             echo '<td>'.$row_emp['first_name'].'</td>';
                         }
                        echo'
                    <td>'.$row['CAI_filename'].'</td>
                    <td>'.$row['CAI_description'].'</td>
                    <td>'.$row['CAI_Action_due_date'].'</td>
                </tr>
                ';
         }
         echo '
            </tbody>
         </table>';
         
    }

if( isset($_GET['modal_filter_status_completed']) ) {
	$ID = $_GET['modal_filter_status_completed'];

	echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
	echo '
        <table class="table table-bordered ">
            <thead class="bg-info">
                <tr>
                    <th>Assign to</th>
                    <th>Task Name</th>
                    <th>Description</th>
                    <th>Date Completed</th>
                </tr>
            </thead>
             <tbody>';
        $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CIA_progress = 2 and Parent_MyPro_PK = $ID order by Date_Completed DESC LIMIT 100";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
         { 
            echo '
                <tr>
                    '; 
                        $emp_id =$row['CAI_Assign_to'];
                        $query_emp = "SELECT * FROM tbl_hr_employee where ID = $emp_id";
                        $result_emp = mysqli_query($conn, $query_emp);
                        while($row_emp = mysqli_fetch_array($result_emp))
                         {
                             echo '<td>'.$row_emp['first_name'].'</td>';
                         }
                        echo'
                    <td>'.$row['CAI_filename'].'</td>
                    <td>'.$row['CAI_description'].'</td>
                    <td>'.$row['Date_Completed'].'</td>
                </tr>
                ';
         }
         echo '
            </tbody>
         </table>';
         
    }
    
mysqli_close($conn);
?>
