<?php
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
        if(isset($_FILES['file']['name'])){

           /* Getting file name */
           $filename = $_FILES['file']['name'];
           $page = $_POST['action_data'];
           $user_id = $_POST['user_id'];
           $file_title = $_POST['file_title'];
           $privacy = $_POST['privacy'];
           /* Location */
           $location = "uploads/pages_demo/".$filename;
           $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
           $imageFileType = strtolower($imageFileType);
        
           /* Valid extensions */
           $valid_extensions = array("mp4","webm","AVI");
        
           $response = 0;
           /* Check file extension */
           if(in_array(strtolower($imageFileType), $valid_extensions)) {
              /* Upload file */
              if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                 $sql = "INSERT INTO tbl_pages_demo_video (file_name,page,user_id,file_title,privacy) VALUES ('$filename','$page','$user_id','$file_title','$privacy')";
         		if (mysqli_query($conn, $sql)){
         			    $response = 1;
         		}
              }
           }
           echo $response;
           exit;
        }
        if(isset($_POST['post_action'])){
            /* Getting file name */
           $filename = $_FILES['file']['name'];
           $page = $_POST['action_data'];
           $user_id = $_POST['user_id'];
           $file_title = $_POST['file_title'];
           $privacy = $_POST['privacy'];
           /* Location */
           $location = "uploads/pages_demo/".$filename;
           $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
           $imageFileType = strtolower($imageFileType);
        
           /* Valid extensions */
           $valid_extensions = array("mp4","webm","AVI");
        
           $response = 0;
           /* Check file extension */
           if(in_array(strtolower($imageFileType), $valid_extensions)) {
              /* Upload file */
              if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                 $sql = "INSERT INTO tbl_pages_demo_video (file_name,page,user_id,file_title,privacy) VALUES ('$filename','$page','$user_id','$file_title','$privacy')";
         		if (mysqli_query($conn, $sql)){
         			    $response = 1;
         		}
              }
           }
           echo $response;
           exit;
        }
        
        
//Preventive Maintenance Control Start

    if(isset($_POST['submit_equipments'])){
        $filename=addslashes($_FILES['equipment_image']['name']);
        $equipment=mysqli_real_escape_string($sanition_connection,$_POST['equipment']);
        $serial=mysqli_real_escape_string($sanition_connection,$_POST['serial']);
        $equipmentid=mysqli_real_escape_string($sanition_connection,$_POST['equipmentid']);
        $location=mysqli_real_escape_string($sanition_connection,$_POST['location']);
        $processowner=mysqli_real_escape_string($sanition_connection,$_POST['processowner']);
        $freq=mysqli_real_escape_string($sanition_connection,$_POST['freq']);
        $supplier=mysqli_real_escape_string($sanition_connection,$_POST['supplier']);
        $status=mysqli_real_escape_string($sanition_connection,$_POST['status']);
        $enterprise_owner=mysqli_real_escape_string($sanition_connection,$_POST['enterprise_owner']);
        
        $equipment_file=$_FILES['manual_file']['name'];
        $size=$_FILES['manual_file']['size'];
        $type=$_FILES['manual_file']['type'];
        $temp2=$_FILES['manual_file']['tmp_name'];
        
        
        $filename=$_FILES['equipment_image']['name'];
        $size=$_FILES['equipment_image']['size'];
        $type=$_FILES['equipment_image']['type'];
        $temp1=$_FILES['equipment_image']['tmp_name'];
        

        move_uploaded_file($temp1,"uploads/pmp/$filename");
        
        // move_uploaded_file($temp1,"uploads/$filename");
        // $allowed = array("image/jpeg", "image/gif", "image/png");
        
        foreach (array_combine($temp2, $equipment_file) as $temp2 => $equipment_file){
          move_uploaded_file($temp2,"uploads/pmp/$equipment_file");
        }
        $query="INSERT INTO `equipment_reg` (`enterprise_owner`,`equipment`, `serial_no`, `equip_id_no`, `location`,  `process_owner`, `freq_maintain`, `supplier`, `status`, `pic_name`) 
        VALUES ('$enterprise_owner','$equipment', '$serial', '$equipmentid', '$location','$processowner', '$freq', '$supplier', '$status', '$filename')";
            //add data to equipment table
            $add=mysqli_query($sanition_connection,$query);
            if($add){
                $last_id = $sanition_connection->insert_id;
                $manual_name=$_POST['manual_name'];
                $manual_file=$_FILES['manual_file']['name'];
                foreach (array_combine($manual_name, $manual_file) as $manual_name => $manual_file){
                    $query="INSERT INTO `files` (`file_type_id`, `PK_id`,`file_file`,`file_name`) VALUES ('1','$last_id', '$manual_file','$manual_name')";
                    if ($sanition_connection->query($query) === TRUE) {
    			        
    		        }
    		        else{
    			        echo "Somethings wrong while saving";
    		        }
                }
                echo '<script>history.go(-1);</script>';
                exit();
                //echo $query;
            }   
            
    }


    if(isset($_POST['save_equipment_parts'])){

        $equipment_parts_name = $_POST['equipment_parts_name'];
        $parts_supplier = $_POST['parts_supplier'];
        $parts_serail = $_POST['parts_serail'];
        $parts_id_no = $_POST['parts_id_no'];
        $enterprise_owner = $_POST['enterprise_owner'];
        
        $equipment_file=$_FILES['equipment_file']['name'];
        $size=$_FILES['equipment_file']['size'];
        $type=$_FILES['equipment_file']['type'];
        $temp1=$_FILES['equipment_file']['tmp_name'];
        move_uploaded_file($temp1,"uploads/pmp/$equipment_file");
        
        $parts_file=$_FILES['manual_file']['name'];
        $size1=$_FILES['manual_file']['size'];
        $type2=$_FILES['manual_file']['type'];
        $temp2=$_FILES['manual_file']['tmp_name'];
        
        foreach (array_combine($temp2, $parts_file) as $temp2 => $parts_file){
          move_uploaded_file($temp2,"uploads/pmp/$parts_file");
        }
            $query="INSERT INTO `equipment_parts` (`enterprise_owner`,`equipment_file`,`equipment_name`,`parts_supplier`,`parts_serail`,`parts_id_no`) 
            VALUES ('$enterprise_owner','$equipment_file','$equipment_parts_name','$parts_supplier','$parts_serail','$parts_id_no')";
            if ($sanition_connection->query($query) === TRUE) {
        	   $last_id = $sanition_connection->insert_id; 
               $equipment_name = $_POST['equipment_name'];
        	   $checklist = $_POST['checklist'];
        	   $manual_name=$_POST['manual_name'];
                $manual_file=$_FILES['manual_file']['name'];
        	   foreach($checklist as $row){
            	   $insert="INSERT INTO `parts_checklist` (`PK_id`,`checklist`) VALUES ('$last_id','$row')";
                    if ($sanition_connection->query($insert) === TRUE) {
        
            	    }
        	   }
        	   foreach($equipment_name as $row1){
        	       $insert1="INSERT INTO `equipment_parts_owned` (`equipment_parts_owned_name`,`parts_PK_id`,`parts_flag_status`) VALUES ('$row1','$last_id','OK')";
                    if ($sanition_connection->query($insert1) === TRUE) {
        
            	    }
        	   }
        	   
        	   foreach (array_combine($manual_name, $manual_file) as $manual_name => $manual_file){
                    $query="INSERT INTO `files` (`file_type_id`, `PK_id`,`file_file`,`file_name`) VALUES ('2','$last_id', '$manual_file','$manual_name')";
                    if ($sanition_connection->query($query) === TRUE) {
    			        
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
        $remarks = $_POST['remarks'];
        $area = $_POST['area'];
        $customer = $_POST['customer'];
       echo $query="INSERT INTO `parts_maintainance` ( `customer`,`area`,`parts_status`,`remarks`,`equipment_PK_id`, `equipment_parts_PK_id`,`last_date_performed`,`job_no`,`assignee`,`type_of_activity`,`description`,`next_maintainance`,`frequency`) 
        VALUES ('$customer','$area','OK','$remarks','$equipment_PK_id', '$equipment_parts_PK_id','$last_date_performed','$job_no','$assignee','$type_of_activity','$description','$next_maintainance','$frequency')";
        if ($sanition_connection->query($query) === TRUE) {
    	   $last_id = $sanition_connection->insert_id; 
    	   $equipment_PK_id = $_POST['equipment_PK_id'];
    	   $last_date_performed = $_POST['last_date_performed'];
    	   $parts_checkedlist = $_POST['parts_checkedlist'];
    	   $remarks = $_POST['remarks'];
    	   
    	   $insert="INSERT INTO `parts_maintenance_history` (`PK_id`,`parts_remarks`, `part_status`, `date_performed`, `history_equipment_name`) VALUES ('$last_id','$remarks','OK','$last_date_performed','$equipment_PK_id')";
            if ($sanition_connection->query($insert) === TRUE) {
                $last_inserted_id = $sanition_connection->insert_id;
                foreach($parts_checkedlist as $row){
        	    $insert="INSERT INTO `parts_checked_list` (`PK_id`,`checklist_PK_id` , `checklist_equipment_name`,`date_performed`) VALUES ('$last_inserted_id','$row','$equipment_PK_id','$last_date_performed')";
                if ($sanition_connection->query($insert) === TRUE) {
    
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
    
    if(isset($_POST['save_new_maintenance'])){
        $PK_id = $_POST['PK_id'];
        $history_equipment_name = $_POST['history_equipment_name'];
        $date_performed = $_POST['date_performed'];
        $parts_status = $_POST['parts_status'];
        $equipment_parts_PK_id = $_POST['equipment_parts_PK_id'];
        $parts_remarks = $_POST['parts_remarks'];
        $query="INSERT INTO `parts_maintenance_history` (equipment_parts_PK_id,`PK_id`,`history_equipment_name`,`date_performed`,`part_status`,`parts_remarks`) VALUES ('$equipment_parts_PK_id','$PK_id','$history_equipment_name','$date_performed','$parts_status','$parts_remarks')";
        if ($sanition_connection->query($query) === TRUE) {
            $last_id = $sanition_connection->insert_id; 
            $parts_checkedlist = $_POST['parts_checkedlist'];
            $history_equipment_name = $_POST['history_equipment_name'];
            $date_performed = $_POST['date_performed'];
            foreach($parts_checkedlist as $row){
                $insert_query="INSERT INTO `parts_checked_list` (`PK_id`,`checklist_PK_id`,`checklist_equipment_name`,`date_performed`) VALUES ('$last_id','$row','$history_equipment_name','$date_performed')";
                if ($sanition_connection->query($insert_query) === TRUE) {
                        
                } 
            }
            $PK_id = $_POST['PK_id'];
            $parts_status = $_POST['parts_status'];
            $parts_remarks = $_POST['parts_remarks'];
            $equip_id = $_POST['equip_id'];
            $parts_owned_id = $_POST['parts_owned_id'];
            $equipment_parts_PK_id = $_POST['equipment_parts_PK_id'];
            $sql = mysqli_query($sanition_connection,"UPDATE parts_maintainance SET remarks = '$parts_remarks', parts_status = '$parts_status' WHERE parts_id= '$PK_id'");
            $sqls = mysqli_query($sanition_connection,"UPDATE equipment_parts_owned SET parts_flag_status = '$parts_status' WHERE id= '$parts_owned_id'");
            $query = "SELECT * FROM parts_maintainance WHERE parts_id = '$PK_id' ";
            $query_result = mysqli_query ($sanition_connection, $query);
            $rows = mysqli_fetch_assoc($query_result);
            $frequency = $rows['frequency'];
            
                if($frequency == "Daily"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 1 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($sanition_connection, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
                
                if($frequency == "Weekly"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 7 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($sanition_connection, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
                
                if($frequency == "Monthly"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 30 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($sanition_connection, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
                
                if($frequency == "Semi-Annual"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 186 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($sanition_connection, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
                
                if($frequency == "Annual"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 365 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($sanition_connection, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
                if($frequency == "Quarterly"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 91 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($sanition_connection, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
         }
    }
    if(isset($_POST['update_change_parts'])){
        $parts_id = $_POST['parts_id'];
        $parts_status = $_POST['parts_status'];
        $remarks = $_POST['remarks'];
        $sql = "UPDATE parts_maintainance SET parts_status = '$parts_status',remarks = '$remarks' WHERE parts_id= '$parts_id'";
        if (mysqli_query($sanition_connection, $sql)) {
            header('Location: ' . $_SERVER["HTTP_REFERER"] );
            exit;
        }
    }
    if(isset($_POST['add_new_parts'])){
        $parts_id = $_POST['parts_id'];
        $equip_id = $_POST['equip_id'];
        $sql = "INSERT INTO `equipment_parts_owned` (`equipment_parts_owned_name`,`parts_PK_id`,`parts_flag_status`) VALUES ('$equip_id','$parts_id','OK')";
        if (mysqli_query($sanition_connection, $sql)) {
            header('Location: ' . $_SERVER["HTTP_REFERER"] );
            exit;
        }
    }
    if(isset($_POST['update_new_change_parts'])){
        $equipment_PK_id = $_POST['equipment_PK_id'];
        $equip_id_parts = $_POST['equip_id_parts'];
        $old_equipment_parts = $_POST['old_equipment_parts'];
        $remarks = $_POST['remarks'];
        $sql = "UPDATE parts_maintainance SET remarks = '$remarks', equipment_parts_PK_id = '$equip_id_parts', parts_status = 'OK' WHERE equipment_PK_id= '$equipment_PK_id' AND equipment_parts_PK_id = '$old_equipment_parts' ";
        if (mysqli_query($sanition_connection, $sql)) {
            header('Location: ' . $_SERVER["HTTP_REFERER"] );
            exit;
        }
    }
    
    if(isset($_POST['save_area'])){
        $area_name = $_POST['area_name'];
        $enterprise_owner = $_POST['enterprise_owner'];
        $sql = "INSERT INTO `area_list` (`area_name`,`enterprise_owner`) VALUES ('$area_name','$enterprise_owner')";
        if (mysqli_query($sanition_connection, $sql)) {
            header('Location: ' . $_SERVER["HTTP_REFERER"] );
            exit;
        }
    }
    if(isset($_POST['save_video'])){
        $file_title = $_POST['file_title'];
        $switch_user_id = $_POST['switch_user_id'];
        $youtube_link = $_POST['youtube_link'];
        $page = $_POST['page'];
        $sql = "INSERT INTO `tbl_pages_demo_video` (`file_title`,`user_id`,`youtube_link`,`page`) VALUES ('$file_title','$switch_user_id','$youtube_link','$page')";
        if (mysqli_query($conn, $sql)) {
            header('Location: ' . $_SERVER["HTTP_REFERER"] );
            exit;
        }
    }
    if(isset($_POST['save_e_form_video'])){
        $file_title = $_POST['file_title'];
        $switch_user_id = $_POST['switch_user_id'];
        $youtube_link = $_POST['youtube_link'];
        $form_id = $_POST['form_video'];
        $sql = "INSERT INTO `tbl_form_videos` (`video_name`,`user_id`,`video_link`,`form_id`) VALUES ('$file_title','$switch_user_id','$youtube_link','$form_id')";
        if (mysqli_query($conn, $sql)) {
            header('Location: ' . $_SERVER["HTTP_REFERER"] );
            exit;
        }
    }
    if(isset($_POST['save_pto'])){
        $payeeid = $_POST['payeeid'];
        $leave_count = $_POST['leave_count'];
        if($_POST['remaining_leave'] == 0){
            $leave_type = 0;
        }
        else{
            $leave_type = $_POST['leave_type'];
        }
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $notes = $_POST['note'];
        $sql = "INSERT INTO `leave_details` (`leave_count`,`leave_id`,`start_date`,`end_date`,`notes`,`payeeid`,approve_status) VALUES ('$leave_count','$leave_type','$start_date','$end_date','$notes','$payeeid','0')";
        if (mysqli_query($conn, $sql)) {
            header('Location: ' . $_SERVER["HTTP_REFERER"] );
            exit;
        }
    }
    if(isset($_POST['update_employe'])){
        $user_for_approve = array();
        $user_id = $_POST['user_id'];
        $to_approve = $_POST['to_approve'];
        foreach($to_approve as $row){
            $user_for_approve[] = $row;
        }
        $user_for_approve = implode(',', $user_for_approve);
        $checker = mysqli_query($conn,"SELECT * FROM others_employee_details WHERE employee_id = '$user_id'");
 		$check_result = mysqli_fetch_array($checker);
 		if($check_result > 0){
 		    echo $update_query = "UPDATE others_employee_details SET pto_to_approved = '$user_for_approve' WHERE employee_id = '$user_id'";
            if (mysqli_query($conn, $update_query)) {
              return true;
            } else {
              echo "Error updating record: " . mysqli_error($conn);
            }
 		}
 		else{
 		    echo $insert_query = "INSERT INTO `others_employee_details`(`employee_id`,pto_to_approved) VALUES ( '$user_id' ,'$user_for_approve')";
 		    if (mysqli_query($conn, $insert_query)) {
              return true;
            } else {
              echo "Error updating record: " . mysqli_error($conn);
            }
 		}
    }
    
 //Preventive Maintenance Control End
   
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET['action'])){
        if($_GET['action'] == "view_equipment"){
            $equipment_id = $_GET['equipment_id'];
            $result = mysqli_query($sanition_connection,"SELECT * FROM equipment_reg WHERE equip_id = '$equipment_id' ");
            $row = mysqli_fetch_array($result);
            
            echo '
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="EquipmentDetails">Equipment Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!--Code Here-->
                <form action="controller.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="enterprise_owner" value="<?= $current_userEmployerID ?>">
                    <div id="add-modal-body" class="modal-body bg-white">
                        <div class="form-group">
                            <label>Equipment Image</label><br>
                            <img src="uploads/pmp/'.$row['pic_name'].'" style="width:150px;height:150px">
                        </div>
                        <div class="form-group">
                            <label for="inputEquipment">Equipment Name <span style="color:red">*</span></label>
                            <input type="text" name="equipment" value="'.$row['equipment'].'" class="form-control"  >
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="inputSerial">Serial # <span style="color:red">*</span></label>
                                <input type="text" name="serial" value="'.$row['serial_no'].'" class="form-control"  >
                            </div>
                            <div class="col-md-6">
                                <label for="inputEquipmentID">Equipment ID No. <span style="color:red">*</span></label>
                                <input type="text" name="equipmentid" value="'.$row['equip_id_no'].'" class="form-control"  >
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12">
                                <label for="inputLocation">Location <span style="color:red">*</span></label>
                                <input type="text" name="location" value="'.$row['location'].'" class="form-control"  >
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:15px">
                            <label for="inputProcessOwner">Assign to <span style="color:red">*</span></label>
                            <input type="text" name="processowner" value="'.$row['process_owner'].'" class="form-control"  >
                        </div>
                        <div class="form-group">
                            <label for="inputFrequency">Frequency of Maintenance <span style="color:red">*</span></label>
                            <input type="text" name="supplier" value="'.$row['freq_maintain'].'" class="form-control"  >
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputSupplier">Supplier Vendor <span style="color:red">*</span></label>
                                <input type="text" name="supplier" value="'.$row['supplier'].'" class="form-control"  >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputStatus">Status <span style="color:red">*</span></label>
                                <input type="text" name="supplier" value="'.$row['status'].'" class="form-control"  >
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-4">
                                <label>Equipment Registered Parts in Maintenance</label>
                            </div>
                            <div class="col-md-4">
                                <label>Status</label>
                            </div>
                            <div class="col-md-4">
                                <label>Action</label>
                            </div>
                        </div>';
                        $get= mysqli_query($sanition_connection,"SELECT * FROM parts_maintainance INNER JOIN equipment_parts ON parts_maintainance.equipment_parts_PK_id = equipment_parts.equipment_parts_id   WHERE parts_maintainance.equipment_PK_id = '$equipment_id' ");
                        while($row=mysqli_fetch_array($get)) {
                            echo '
                            <div class="row" style="margin-top:10px">
                                <div class="col-md-4">
                                    <a href="#">'.$row['equipment_name'].'</a>
                                </div>
                                <div class="col-md-4">
                                    <label>'.$row['parts_status'].'</label>
                                </div>
                                <div class="col-md-4">';
                                    if($row['parts_status'] == "OK"){
                                        echo '<a class="btn btn-primary" disabled>Update</a>';
                                    }
                                    else{
                                        echo '<a class="btn btn-primary" data-toggle="modal" data-target="#change_parts" parts_status_value="'.$row['parts_status'].'" parts_id="'.$row['parts_id'].'" id="update_equipment_parts" >Update</a>';
                                    }
                                    
                            echo'    </div>
                            </div>
                            
                            ';
                        }
                    echo ' <div class="row" id="dynamic_field" style="margin-top:15px">
                            <div class="inputs_container" >
                                <div class="col-md-12">
                                    <label for="inputParts">Manual File Name<span style="color:red">*</span></label> <br>';
                                    $get= mysqli_query($sanition_connection,"SELECT * FROM files WHERE PK_id = '$equipment_id' ");
                                    while($row=mysqli_fetch_array($get)) {
                                     echo '<a href="#">'.$row['file_name'].'</a>';  
                                    }
                                    
                    echo'                
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-white">
                        <button type="button" class="btn btn-light shadow-none" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info shadow-none" id="submit_equipments" name="submit_equipments" disabled>Save</button>
                    </div>
                </form>
            ';
        }
    }
    
    if($_GET['action'] == "get_equipment_parts_details"){
        $equipment_parts_id = $_GET['equipment_parts_id'];
        $result = mysqli_query($sanition_connection,"SELECT * FROM equipment_parts WHERE equipment_parts_id = '$equipment_parts_id'");
        $rows = mysqli_fetch_array($result);
        
        echo '
            <!--Code Here-->
            <form action="controller.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="enterprise_owner" value="<?= $current_userEmployerID ?>">
                <div id="add-modal-body" class="modal-body bg-white">
                    <div class="form-group">
                        <label>Equipment Parts Image<br>
                        <img src="uploads/pmp/'.$rows['equipment_file'].'" style="width:150px;height:150px">
                    </div>
                    <div class="row" id="dynamic_field1">
                        <div class="col-md-12">
                            <label for="inputParts">Parts Manual</label>
                        </div>
                        <div class="inputs_container" >
                            <div class="col-md-12">';
                            
                            //$PK_id = $row['equipment_parts_id'];
                            $get= mysqli_query($sanition_connection,"SELECT * FROM files WHERE PK_id ='$equipment_parts_id' ");
                            while($row=mysqli_fetch_array($get)) {
                             echo '<a href="#">'.$row['file_name'].'</a><br>';  
                            }
                                
                    echo'       </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <hr>
                        <label for="inputEquipment">Equipment Parts Name</label>
                        <input type="text" name="equipment_parts_name" value="'.$rows['equipment_name'].'" class="form-control"  >
                    </div>
                    <div class="form-group">
                        <label for="inputEquipment">Equipment Parts Supplier</label>
                        <input type="text" name="parts_supplier" value="'.$rows['parts_supplier'].'" class="form-control"  >
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputSerial">Serial #</label>
                            <input type="text" name="parts_serail" value="'.$rows['parts_serail'].'" class="form-control"  >
                        </div>
                        <div class="col-md-6">
                            <label for="inputEquipmentID">Equipment Part Model No.</label>
                            <input type="text" name="parts_id_no" value="'.$rows['parts_id_no'].'" class="form-control"  >
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:15px">
                        <label for="inputFrequency">Parts Owner</label><br>
                        <div style="display:flex;justify-content:flex-end">
                            <a data-toggle="modal" data-target="#add_parts_to_equipment" class="btn btn-primary add_parts_to_equipment" parts_id="'.$rows['equipment_parts_id'].'"> Add this part to an Equipment</a>
                        </div>
                        ';
                        $gets= mysqli_query($sanition_connection,"SELECT * FROM equipment_parts_owned INNER JOIN equipment_reg ON equipment_reg.equip_id = equipment_parts_owned.equipment_parts_owned_name WHERE equipment_parts_owned.parts_PK_id ='$equipment_parts_id' ");
                        while($rows=mysqli_fetch_array($gets)) {
                             echo '<a href="#">'.$rows['equipment'].'</a><br>';  
                        }
                    echo '</div>
                    <div class="form-group" id="checklist">
                        <label for="inputFrequency">Parts Checklist<br>';
                        
                         $get= mysqli_query($sanition_connection,"SELECT * FROM parts_checklist WHERE PK_id ='$equipment_parts_id' ");
                            while($row=mysqli_fetch_array($get)) {
                             echo '<a href="#">'.$row['checklist'].'</a><br>';  
                            }
                 echo'   </div>
                </div>
            </form>
        ';
    }
    
    if($_GET['action'] == "get_parts_checklist"){
        $parts_PK_id = $_GET['parts_PK_id'];
        $sql = "SELECT * FROM parts_checklist WHERE PK_id = '$parts_PK_id' " ; 
		$result = mysqli_query ($sanition_connection, $sql);
    	while($row = mysqli_fetch_array($result))
    	{
    	        echo '<div class="col-md-12">';
    	            echo '<input type="checkbox" name="parts_checkedlist[]" value="'.$row['id'].'" > <label for="vehicle1">'.$row['checklist'].'</label><br>';
    	        echo '</div>';
    	}
    }
    if($_GET['action'] == "get_equipment_parts"){
        $equipment_id = $_GET['equipment_id'];
        $sql = "SELECT * FROM equipment_parts_owned INNER JOIN equipment_parts ON equipment_parts_owned.parts_PK_id = equipment_parts.equipment_parts_id WHERE equipment_parts_owned.equipment_parts_owned_name = '$equipment_id' " ; 
		$result = mysqli_query ($sanition_connection, $sql);
		echo '<option disabled selected>Choose...</option>.';
    	while($row = mysqli_fetch_array($result))
    	{
    	    echo '<option parts_owned_id="'.$row['id'].'" parts_PK_id="'.$row['parts_PK_id'].'" value="'.$row['parts_PK_id'].'">'.$row['equipment_name'].'</option>';
    	}
    }
    if($_GET['action'] == "get_checklist"){
        $maintenance_id = $_GET['maintenance_id'];
        $sql = "SELECT * FROM parts_checklist WHERE PK_id = '$maintenance_id' " ;
        echo '<label style="margin-left:7px;margin-top:15px">Maintenance Checklist</label>';
		$result = mysqli_query ($sanition_connection, $sql);
    	while($row = mysqli_fetch_array($result))
    	{
    	        echo '<div class="col-md-12">';
    	            echo '<input type="checkbox" name="parts_checkedlist[]" value="'.$row['id'].'" > <label for="">'.$row['checklist'].'</label><br>';
    	        echo '</div>';
    	}
    }
    if($_GET['action'] == "get_parts_history"){
        $parts_id = $_GET['parts_id'];
        $equipment_history_name = $_GET['equipment'];
        
        $sql = "SELECT * FROM parts_maintenance_history 
        INNER JOIN equipment_parts ON parts_maintenance_history.equipment_parts_PK_id = equipment_parts.equipment_parts_id
        WHERE parts_maintenance_history.PK_id = '$parts_id' " ; 
		$result = mysqli_query ($sanition_connection, $sql);
    	while($row = mysqli_fetch_array($result))
    	{
    	   echo '<tr>
    	        <td><a class="show_maintenance_history" data-toggle="modal" data-target="#show_maintenance_history" maintenance_id="'.$row['id'].'"  style=" text-decoration: none">'.$row['equipment_name'].'</a></td>
    	        <td>'.$row['part_status'].'</td>
    	        <td>'.$row['date_performed'].'</td>
    	        <td>'.$row['parts_remarks'].'</td>
    	        </tr>
    	   ';
    	}
    }
    if($_GET['action'] == "get_maintenance_history_details"){
        $maintenance_id = $_GET['maintenance_id'];
        $sql = "SELECT * FROM parts_maintenance_history INNER JOIN equipment_parts ON parts_maintenance_history.equipment_parts_PK_id =equipment_parts.equipment_parts_id  WHERE parts_maintenance_history.id = '$maintenance_id' " ; 
        $result3 = mysqli_query($sanition_connection,$sql);
        $row= mysqli_fetch_array($result3);
        $maintenance_id = $row['id'];
       echo '
            <div class="row mt-4">
            <div class="col-md-6">
                <label>Parts Name</label>
                <input type="text" class="form-control"  name="'.$row['equipment_name'].'" readonly>
            </div>
            <div class="col-md-6">
                <labe>Date Performed</labe>
                <input type="text" class="form-control" value="'.$row['date_performed'].'" name="" readonly>
            </div>
        </div>
        
        <div class="row mt-3" style="margin-top:15px">
            <div class="col-md-6">
                <label>Equipment Name</label>
                <input type="text" class="form-control" value="'.$row['history_equipment_name'].'" name="" readonly>
            </div>
            <div class="col-md-6">
                <labe>Parts Status</labe>
                <input type="text" class="form-control" value="'.$row['part_status'].'" name="" readonly>
            </div>
        </div>
        
        <div class="row mt-3" style="margin-top:15px">
            <div class="col-md-6">
                <label>Remarks</label>
                <textarea class="form-control" style="height:70px" readonly>'.$row['parts_remarks'].'</textarea>
            </div>
        </div>
        
        <div class="row mt-3" style="margin-top:15px">
            <div class="col-md-6">
                <label>Checked List</label><br>';
            $sql = "SELECT * FROM parts_checked_list INNER JOIN parts_checklist ON parts_checklist.id = parts_checked_list.checklist_PK_id  WHERE parts_checked_list.PK_id = '$maintenance_id' " ; 
    		$result = mysqli_query ($sanition_connection, $sql);
        	while($rows = mysqli_fetch_array($result))
        	{
                echo '<input type="checkbox" checked><label> &nbsp; '.$rows['checklist'].'</label><br>';
        	}
            echo '
            </div>
        </div>
       ';
    }
    if($_GET['action'] == "show_change_parts"){
        $parts_id = $_GET['parts_id'];
        $sql = "SELECT * FROM parts_maintainance INNER JOIN equipment_parts ON parts_maintainance.equipment_parts_PK_id = equipment_parts.equipment_parts_id WHERE parts_maintainance.parts_id = '$parts_id' " ; 
        $result = mysqli_query($sanition_connection,$sql);
        $row= mysqli_fetch_array($result);
        
        echo '
            <div class="row">
                <div class="col-md-12">
                    <label>Parts Image</label><br>
                    <img src="uploads/pmp/'.$row['equipment_file'].'" style="width:150px;height:150px">
                </div>
                <div class="col-md-12" style="margin-top:15px">
                    <label>Parts Name</label>
                    <input type="hidden" name="parts_id" value="'.$row['parts_id'].'">
                    <input type="text" class="form-control" value="'.$row['equipment_name'].'" readonly>
                </div>
                <div class="col-md-4" style="margin-top:15px">
                    <label>Parts Status</label>
                    <select class="form-control" name="parts_status" id="parts_status_drop">
                        <option value="OK">OK</option>
                        <option value="DEFECT">DEFECT</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" style="margin-top:15px;">
                    <label>Remarks</label>
                    <textarea class="form-control" name="remarks" style="height:70px"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr><br>
                    <div>
                        <label>Change Equipment Parts</label>
                    </div>
                    <div style="display:flex;justify-content:flex-end">
                        <a data-toggle="modal" data-target="#new_parts" equipment_PK_id="'.$row['equipment_PK_id'].'" equipment_parts_PK_id="'.$row['equipment_parts_PK_id'].'" class="new_parts">New Parts ? </a>
                    </div>
                </div>
            </div>
        ';
    }

}

?>
