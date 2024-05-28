<?php

ini_set('display_errors', 1);
error_reporting(-1);
include 'connection/config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if($_GET['action'] == "get_equipment_parts"){
        $equipment_id = $_GET['equipment_id'];
        $sql = "SELECT * FROM equipment_parts_owned INNER JOIN equipment_parts ON equipment_parts_owned.parts_PK_id = equipment_parts.equipment_parts_id WHERE equipment_parts_owned.equipment_parts_owned_name = '$equipment_id' " ; 
		$result = mysqli_query ($conn, $sql);
		echo '<option disabled selected>Choose...</option>.';
    	while($row = mysqli_fetch_array($result))
    	{
    	    echo '<option parts_PK_id="'.$row['parts_PK_id'].'" value="'.$row['parts_PK_id'].'">'.$row['equipment_name'].'</option>';
    	}
    }
    
    if($_GET['action'] == "get_parts_checklist"){
        $parts_PK_id = $_GET['parts_PK_id'];
        $sql = "SELECT * FROM parts_checklist WHERE PK_id = '$parts_PK_id' " ; 
		$result = mysqli_query ($conn, $sql);
    	while($row = mysqli_fetch_array($result))
    	{
    	        echo '<div class="col-md-12">';
    	            echo '<input type="checkbox" name="parts_checkedlist[]" value="'.$row['id'].'" > <label for="vehicle1">'.$row['checklist'].'</label><br>';
    	        echo '</div>';
    	}
    }
    
    if($_GET['action'] == "get_parts_history"){
        $parts_id = $_GET['parts_id'];
        $equipment_history_name = $_GET['equipment'];
        
        $sql = "SELECT * FROM parts_maintenance_history 
        INNER JOIN parts_maintainance ON parts_maintenance_history.PK_id = parts_maintainance.parts_id
        INNER JOIN equipment_parts ON parts_maintainance.equipment_parts_PK_id = equipment_parts.equipment_parts_id
        WHERE parts_maintenance_history.PK_id = '$parts_id' AND parts_maintenance_history.history_equipment_name = '$equipment_history_name' " ; 
		$result = mysqli_query ($conn, $sql);
    	while($row = mysqli_fetch_array($result))
    	{
    	   echo '<tr>
    	        <td><a href="checklist_details.php?id='.$row['id'].'" target="_blank" style=" text-decoration: none">'.$row['equipment_name'].'</a></td>
    	        <td>'.$row['part_status'].'</td>
    	        <td>'.$row['date_performed'].'</td>
    	        <td>'.$row['parts_remarks'].'</td>
    	        </tr>
    	   ';
    	}
    }
    
    if($_GET['action'] == "get_checklist"){
        $maintenance_id = $_GET['maintenance_id'];
        $sql = "SELECT * FROM parts_checklist WHERE PK_id = '$maintenance_id' " ;
        echo '<label class="mt-3">Maintenance Checklist</label>';
		$result = mysqli_query ($conn, $sql);
    	while($row = mysqli_fetch_array($result))
    	{
    	        echo '<div class="col-md-12">';
    	            echo '<input type="checkbox" name="parts_checkedlist[]" value="'.$row['id'].'" > <label for="">'.$row['checklist'].'</label><br>';
    	        echo '</div>';
    	}
    }
    
    if($_GET['action'] == "get_equipment_calibration"){
        $equipment_id = $_GET['equipment_id'];
        $result1 = mysqli_query($conn,"SELECT * FROM equipment_reg WHERE equip_id_no = '$equipment_id' ");
        $row= mysqli_fetch_array($result1);
        $supplier = $row['supplier'];
        echo '
            <div class="form-group">
                <label for="inputEquipment">Equipment Manufacturer<span style="color:red">*</span></label>
                <input type="text" name="" value="'.$row['supplier'].'" class="form-control"  >
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputSerial">Serial # <span style="color:red">*</span></label>
                    <input type="text" name="" value="'.$row['serial_no'].'" class="form-control"  >
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEquipmentID">Calibration Period <span style="color:red">*</span></label>
                    <input type="date" name="calibration_period" class="form-control"  >
                </div>
            </div>
            <div class="form-group">
                <label for="inputEquipment">Equipment Description <span style="color:red">*</span></label>
                <textarea name="equipment_description" class="form-control" style="height:70px"></textarea>
            </div>
            <div class="form-group">
                <label for="inputFrequency">Last Calibration Date <span style="color:red">*</span></label>
                <input type="date" name="last_calibration_date" class="form-control"  >
            </div>
            <div class="form-group">
                <label for="inputFrequency">Calibration Due Date<span style="color:red">*</span></label>
                <input type="date" name="calibration_due_date" class="form-control"  >
            </div>
            <div class="form-group">
                <label for="inputFrequency">Calibration Body/Organization<span style="color:red">*</span></label>
                <input type="text" name="calibration_body_organization" class="form-control"  >
            </div>
        
        ';
    }
    
    if($_GET['action'] == "get_equipment_manual"){
        $equipment_id = $_GET['equipment_id'];
        $sql = "SELECT * FROM files WHERE PK_id = '$equipment_id' " ;
        $result = mysqli_query ($conn, $sql);
        while($row = mysqli_fetch_array($result))
    	{
    	        echo '
    	            <label for="inputEquipment">Equipment Manual/s</label>
    	            <a href="read_download_file.php?path=uploads/'.$row['file_file'].'">'.$row['file_name'].'</a>
    	        ';
    	}
    }
    
    if($_GET['action'] == "get_equipment_parts_details"){
        $equipment_parts_id = $_GET['equipment_parts_id'];
        $sql = "SELECT * FROM equipment_parts WHERE equipment_parts_id = '$equipment_parts_id' " ;
        $result = mysqli_query ($conn, $sql);
        while($row = mysqli_fetch_array($result))
    	{
    	    $PK_id = $row['equipment_parts_id'];
        echo '
            <div class="form-group">
                <label>Equipment Parts Image <span style="color:red"> :</span></label>
                <div class="custom-file">
                    <img src="uploads/'.$row['equipment_file'].'" alt="User Image" style="height:70px">
                </div>
            </div>
            <div class="row form-group" style="margin-top:50px" id="dynamic_field">
                <label for="inputParts">Parts Manual</label>
                    <div class="inputs_container row" >';
                    $sql1 = "SELECT * FROM files WHERE PK_id = '$PK_id' " ;
                    $result1 = mysqli_query ($conn, $sql1);
                    while($row1 = mysqli_fetch_array($result1))
            	    {
            	        echo '
            	        <div class="col-md-6">
                            <a href="#">'.$row1['file_name'].'</a>
                        </div>
                        ';
            	    }
                        
    
        echo'           </div>
            </div>
            <div class="form-group mt-3">
                <label for="inputEquipment">Equipment Parts Name <span style="color:red"> :</span></label>
                <input type="text" value="'.$row['equipment_name'].'" name="equipment_parts_name" class="form-control"  >
            </div>
            <div class="form-group">
                <label for="inputEquipment">Equipment Parts Supplier<span style="color:red">:</span></label>
                <input type="text" value="'.$row['parts_supplier'].'" name="parts_supplier" class="form-control"  >
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputSerial">Serial # <span style="color:red"> :</span></label>
                    <input type="text" value="'.$row['parts_serail'].'" name="parts_serail" class="form-control"  >
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEquipmentID">Equipment Part Model No. <span style="color:red"> :</span></label>
                    <input type="text" value="'.$row['parts_id_no'].'" name="parts_id_no" class="form-control"  >
                </div>
            </div>
            <div class="form-group">
                <label for="inputFrequency">Parts Owner <span style="color:red"> :</span></label><br>
            ';
            $sql1 = "SELECT * FROM equipment_parts_owned WHERE parts_PK_id = '$PK_id' " ;
            $result1 = mysqli_query ($conn, $sql1);
            while($row1 = mysqli_fetch_array($result1))
    	    {
    	        echo '<a href="#">'.$row1['equipment_parts_owned_name'].'</a><br>';
    	    }
    echo'       
            </div>
            <div class="form-group" id="checklist">
                <label for="inputFrequency">Parts Checklist<span style="color:red"> :</span></label><br>';
            $sql1 = "SELECT * FROM parts_checklist WHERE PK_id = '$PK_id' " ;
            $result1 = mysqli_query ($conn, $sql1);
            while($row1 = mysqli_fetch_array($result1))
    	    {
    	        echo '<label>'.$row1['checklist'].'</label> <br>';
    	    }
    echo'   </div>
        
        ';
    	}
    }
    
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['action'])){
	    
	}
    // if they click the button to submit/add new data
    if (isset($_POST['submit'])) {
        
        
        $filename=addslashes($_FILES['equipment_image']['name']);
        $equipment=mysqli_real_escape_string($conn,$_POST['equipment']);
        $serial=mysqli_real_escape_string($conn,$_POST['serial']);
        $equipmentid=mysqli_real_escape_string($conn,$_POST['equipmentid']);
        $location=mysqli_real_escape_string($conn,$_POST['location']);
        $processowner=mysqli_real_escape_string($conn,$_POST['processowner']);
        $freq=mysqli_real_escape_string($conn,$_POST['freq']);
        $supplier=mysqli_real_escape_string($conn,$_POST['supplier']);
        $status=mysqli_real_escape_string($conn,$_POST['status']);

        $equipment_file=$_FILES['manual_file']['name'];
        $size=$_FILES['manual_file']['size'];
        $type=$_FILES['manual_file']['type'];
        $temp2=$_FILES['manual_file']['tmp_name'];
        
        
        $filename=$_FILES['equipment_image']['name'];
        $size=$_FILES['equipment_image']['size'];
        $type=$_FILES['equipment_image']['type'];
        $temp1=$_FILES['equipment_image']['tmp_name'];
        

        move_uploaded_file($temp1,"uploads/$filename");
        
        // move_uploaded_file($temp1,"uploads/$filename");
        // $allowed = array("image/jpeg", "image/gif", "image/png");
        
        foreach (array_combine($temp2, $equipment_file) as $temp2 => $equipment_file){
          move_uploaded_file($temp2,"uploads/$equipment_file");
        }
        $query="INSERT INTO `equipment_reg` (`equipment`, `serial_no`, `equip_id_no`, `location`,  `process_owner`, `freq_maintain`, `supplier`, `status`, `pic_name`) VALUES ('$equipment', '$serial', '$equipmentid', '$location','$processowner', '$freq', '$supplier', '$status', '$filename')";
            //add data to equipment table
            $add=mysqli_query($conn,"INSERT INTO `equipment_reg` (`equipment`, `serial_no`, `equip_id_no`, `location`,  `process_owner`, `freq_maintain`, `supplier`, `status`, `pic_name`) VALUES ('$equipment', '$serial', '$equipmentid', '$location','$processowner', '$freq', '$supplier', '$status', '$filename')");
            if($add){
                $last_id = $conn->insert_id;
                $manual_name=$_POST['manual_name'];
                $manual_file=$_FILES['manual_file']['name'];
                foreach (array_combine($manual_name, $manual_file) as $manual_name => $manual_file){
                    $query="INSERT INTO `files` (`file_type_id`, `PK_id`,`file_file`,`file_name`) VALUES ('1','$last_id', '$manual_file','$manual_name')";
                    if ($conn->query($query) === TRUE) {
    			        
    		        }
    		        else{
    			        echo "Somethings wrong while saving";
    		        }
                }
                Header('Location:equipment_register.php');
                exit();
            }   
            echo $query;
            
    }
    
    if(isset($_POST['save_maintainance'])){
        $equipment_PK_id = $_POST['equipment_PK_id'];
        $equipment_parts_PK_id = $_POST['equipment_parts_PK_id'];
        $last_date_performed = $_POST['last_date_performed'];
        $job_no = $_POST['job_no'];
        $assignee = $_POST['assignee'];
        $type_of_activity = $_POST['type_of_activity'];
        $description = $_POST['description'];
        $next_maintainance = $_POST['next_maintainance'];
        $frequency = $_POST['frequency'];
       
        $query="INSERT INTO `parts_maintainance` (`equipment_PK_id`, `equipment_parts_PK_id`,`last_date_performed`,`job_no`,`assignee`,`type_of_activity`,`description`,`next_maintainance`,`frequency`) VALUES ('$equipment_PK_id', '$equipment_parts_PK_id','$last_date_performed','$job_no','$assignee','$type_of_activity','$description','$next_maintainance','$frequency')";
        if ($conn->query($query) === TRUE) {
    	   $last_id = $conn->insert_id; 
    	   $equipment_PK_id = $_POST['equipment_PK_id'];
    	   $last_date_performed = $_POST['last_date_performed'];
    	   $parts_checkedlist = $_POST['parts_checkedlist'];
    	   $remarks = $_POST['remarks'];
    	   
    	   $insert="INSERT INTO `parts_maintenance_history` (`PK_id`,`parts_remarks`, `part_status`, `date_performed`, `history_equipment_name`) VALUES ('$last_id','$remarks','OK','$last_date_performed','$equipment_PK_id')";
            if ($conn->query($insert) === TRUE) {
                $last_inserted_id = $conn->insert_id;
                foreach($parts_checkedlist as $row){
        	    $insert="INSERT INTO `parts_checked_list` (`PK_id`,`checklist_PK_id` , `checklist_equipment_name`,`date_performed`) VALUES ('$last_inserted_id','$row','$equipment_PK_id','$last_date_performed')";
                if ($conn->query($insert) === TRUE) {
    
        	    } 
        	    header('Location: ' . $_SERVER["HTTP_REFERER"] );
                exit;
    	    }
    	    
    	 }
    	 
    	}
    	else{
    		echo "Somethings wrong while saving";
    	}
    }
    
    if(isset($_POST['save_equipment_parts'])){

        $equipment_parts_name = $_POST['equipment_parts_name'];
        $parts_supplier = $_POST['parts_supplier'];
        $parts_serail = $_POST['parts_serail'];
        $parts_id_no = $_POST['parts_id_no'];
        
        $equipment_file=$_FILES['equipment_file']['name'];
        $size=$_FILES['equipment_file']['size'];
        $type=$_FILES['equipment_file']['type'];
        $temp1=$_FILES['equipment_file']['tmp_name'];
        move_uploaded_file($temp1,"uploads/$equipment_file");
        
        $parts_file=$_FILES['manual_file']['name'];
        $size1=$_FILES['manual_file']['size'];
        $type2=$_FILES['manual_file']['type'];
        $temp2=$_FILES['manual_file']['tmp_name'];
        
        foreach (array_combine($temp2, $parts_file) as $temp2 => $parts_file){
          move_uploaded_file($temp2,"uploads/$parts_file");
        }
            $query="INSERT INTO `equipment_parts` (`equipment_file`,`equipment_name`,`parts_supplier`,`parts_serail`,`parts_id_no`) VALUES ('$equipment_file','$equipment_parts_name','$parts_supplier','$parts_serail','$parts_id_no')";
            if ($conn->query($query) === TRUE) {
        	   $last_id = $conn->insert_id; 
               $equipment_name = $_POST['equipment_name'];
        	   $checklist = $_POST['checklist'];
        	   $manual_name=$_POST['manual_name'];
                $manual_file=$_FILES['manual_file']['name'];
        	   foreach($checklist as $row){
            	   $insert="INSERT INTO `parts_checklist` (`PK_id`,`checklist`) VALUES ('$last_id','$row')";
                    if ($conn->query($insert) === TRUE) {
        
            	    }
        	   }
        	   foreach($equipment_name as $row){
        	       $insert="INSERT INTO `equipment_parts_owned` (`equipment_parts_owned_name`,`parts_PK_id`,`parts_flag_status`) VALUES ('$row','$last_id','OK')";
                    if ($conn->query($insert) === TRUE) {
        
            	    }
        	   }
        	   
        	   foreach (array_combine($manual_name, $manual_file) as $manual_name => $manual_file){
                    $query="INSERT INTO `files` (`file_type_id`, `PK_id`,`file_file`,`file_name`) VALUES ('2','$last_id', '$manual_file','$manual_name')";
                    if ($conn->query($query) === TRUE) {
    			        
    		        }
    		        else{
    			        echo "Somethings wrong while saving";
    		        }
                }
                
        	   
        	header('Location: ' . $_SERVER["HTTP_REFERER"] );
            exit;
        	}
        	else{
        		echo "Somethings wrong while saving";
        	}
    }
    
    if(isset($_POST['save_new_maintenance'])){
        $PK_id = $_POST['PK_id'];
        $history_equipment_name = $_POST['history_equipment_name'];
        $date_performed = $_POST['date_performed'];
        $parts_status = $_POST['parts_status'];
        $parts_remarks = $_POST['parts_remarks'];
        $query="INSERT INTO `parts_maintenance_history` (`PK_id`,`history_equipment_name`,`date_performed`,`part_status`,`parts_remarks`) VALUES ('$PK_id','$history_equipment_name','$date_performed','$parts_status','$parts_remarks')";
        if ($conn->query($query) === TRUE) {
            $last_id = $conn->insert_id; 
            $parts_checkedlist = $_POST['parts_checkedlist'];
            $history_equipment_name = $_POST['history_equipment_name'];
            $date_performed = $_POST['date_performed'];
            foreach($parts_checkedlist as $row){
                $insert_query="INSERT INTO `parts_checked_list` (`PK_id`,`checklist_PK_id`,`checklist_equipment_name`,`date_performed`) VALUES ('$last_id','$row','$history_equipment_name','$date_performed')";
                if ($conn->query($insert_query) === TRUE) {
                        
                } 
            }
            $PK_id = $_POST['PK_id'];
            $query = "SELECT * FROM parts_maintainance WHERE parts_id = '$PK_id' ";
            $query_result = mysqli_query ($conn, $query);
            $rows = mysqli_fetch_assoc($query_result);
            $frequency = $rows['frequency'];
            
                if($frequency == "Daily"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 1 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($conn, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
                
                if($frequency == "Weekly"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 7 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($conn, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
                
                if($frequency == "Monthly"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 30 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($conn, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
                
                if($frequency == "Semi-Annual"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 186 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($conn, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
                
                if($frequency == "Annual"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 365 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($conn, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
                if($frequency == "Quarterly"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 91 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($conn, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
         }
    }
    
    if(isset($_POST['save_equipment_calibration'])){
        $equipment_id_no = $_POST['equipment_id_no'];
        $equipment_description = $_POST['equipment_description'];
        $calibration_period = $_POST['calibration_period'];
        $last_calibration_date = $_POST['last_calibration_date'];
        $calibration_due_date = $_POST['calibration_due_date'];
        $calibration_body_organization = $_POST['calibration_body_organization'];
     
        
        $insert_query="INSERT INTO `equipment_calibration` (`equipment_id_no`,`equipment_description`,`calibration_period`,`last_calibration_date`,`calibration_due_date`,`calibration_body_organization`) 
          VALUES ('$equipment_id_no','$equipment_description','$calibration_period','$last_calibration_date','$calibration_due_date','$calibration_body_organization')";
            if ($conn->query($insert_query) === TRUE) {
                header('Location: ' . $_SERVER["HTTP_REFERER"] );
                exit;   
            } 
        
    }
    
    if(isset($_POST['submit_equipment_calibration'])){
        $verified_by = $_POST['verified_by'];
        $performed_by = $_POST['performed_by'];
        $verified_date = $_POST['verified_date'];
        $performed_date = $_POST['performed_date'];

        $insert_query = "INSERT INTO `equipment_calibration_review` (`verified_by`,`performed_by`,`verified_date`,`performed_date`) 
         VALUES ('$verified_by','$performed_by','$verified_date','$performed_date')";
         if ($conn->query($insert_query) === TRUE) {
             $last_id = $conn->insert_id; 
             $calibration_id = $_POST['calibration_id'];
             foreach($calibration_id as $row){
                 $sql = "UPDATE equipment_calibration SET PK_id = '$last_id', status = '1' WHERE id= '$row'";
                    if (mysqli_query($conn, $sql)) {
                        
                    }
             }
            header('Location: ' . $_SERVER["HTTP_REFERER"] );
            exit;   
        } 
    }
    
    if(isset($_POST['edit_equipment'])){
        $e_equipment = $_POST['e_equipment'];
        $e_serial = $_POST['e_serial'];
        $e_equipmentid = $_POST['e_equipmentid'];
        $e_location = $_POST['e_location'];
        $e_parts = $_POST['e_parts'];
        $e_processowner = $_POST['e_processowner'];
        $e_freq = $_POST['e_freq'];
        $e_supplier = $_POST['e_supplier'];
        $e_status = $_POST['e_status'];
        $m_action = $_POST['m_action'];
        $e_id = $_POST['e_id'];
        
        $edit=mysqli_query($conn,"UPDATE equipment_reg SET equipment='$e_equipment', serial_no='$e_serial', equip_id_no='$e_equipmentid', location='$e_location', parts_to_maintain='$e_parts', process_owner='$e_processowner', freq_maintain='$e_freq', supplier='$e_supplier', status='$e_status' WHERE equip_id ='$e_id'");
        
        if($edit){
            $equipment_calibration = $_POST['equipment_calibration'];
            if($equipment_calibration == "Yes"){
                $equipment_id_no = $_POST['e_equipmentid'];
                $calibration_period = $_POST['calibration_period'];
                $last_calibration_date = $_POST['last_calibration_date'];
                $calibration_due_date = $_POST['calibration_due_date'];
                $calibration_body_organization = $_POST['calibration_body_organization'];
                $result = $_POST['result'];
                $insert_query="INSERT INTO `equipment_calibration` (`equipment_id_no`,`calibration_period`,`last_calibration_date`,`calibration_due_date`,`calibration_body_organization`,`result`) 
                  VALUES ('$equipment_id_no','$calibration_period','$last_calibration_date','$calibration_due_date','$calibration_body_organization','$result')";
                    if ($conn->query($insert_query) === TRUE) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;   
                    } 
                
            }
            else{
                header('Location: ' . $_SERVER["HTTP_REFERER"] );
                exit;   
            }
        }
    }
}

?>