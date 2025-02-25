<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalViewApp']) ) {
    		$id = $_GET['modalViewApp'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tblFacilityDetails_Service_Team WHERE Service_Team_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
    		<input class="form-control" type="hidden" name="ID" value="'. $row['Service_Team_id'] .'" />
             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>First Name</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="Service_Team_name" id="Service_Team_name" value="'. $row['Service_Team_name'] .'" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Last Name</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="Service_Team_last_name" id="Service_Team_last_name" value="'. $row['Service_Team_last_name'] .'"  required />
                                    </div>
                                </div>
                            </div>
                           <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Title</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="Service_Team_title" id="Service_Team_title" value="'. $row['Service_Team_title'] .'" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Cell No.</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" id="Service_Team_cellno" name="Service_Team_cellno" value="'. $row['Service_Team_cellno'] .'"  />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Cell No.</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" id="Service_Team_phone" name="Service_Team_phone" value="'. $row['Service_Team_phone'] .'"  />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>Phone</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="Service_Team_emailAddress" id="Service_Team_emailAddress" value="'. $row['Service_Team_emailAddress'] .'"  required />
                                    </div>
                                </div>
                            </div>
            ';
    
            mysqli_close($conn);
    	}

     
    if( isset($_GET['modalViewCMT']) ) {
		$id = $_GET['modalViewCMT'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_critical_operation WHERE critical_operation_id  = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
            
    		echo '
    		<input type="hidden" id="ID" name="ID" value="'.$id.'">
    		<input type="hidden" id="ID" name="assign_area" value="'.$row['assign_area'].'">
    		<div class="mb-3 row">
                <label for="addOperationField" class="col-md-3 form-label">Operation</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="addOperationField" name="addOperationField" value="'.htmlentities($row['addOperationField'] ?? '').'" required>
                </div>
            </div>
            <br>
            <div class="mb-3 row">
                <label for="addPrimaryNameField" class="col-md-3 form-label">Primary Name</label>
                <div class="col-md-9">
                    <select class="form-control" name="addPrimaryNameField" id="addPrimaryNameField" required>
                        <option value="">Select</option>';
                        
                        $queries = "SELECT * FROM tbl_hr_employee where user_id = ".$row['user_cookies'];
                        $resultQuery = mysqli_query($conn, $queries);
                        while($rowcrm = mysqli_fetch_array($resultQuery)){ 
                            echo '<option value="'.$rowcrm['ID'].'"'; echo $rowcrm['ID']==$row['addPrimaryNameField'] ? 'SELECTED':''; echo '>'.htmlentities($rowcrm['first_name'] ?? '').' '.htmlentities($rowcrm['last_name'] ?? '').'</option>';
                        }
                    
                    echo '</select>
                </div>
            </div>
            <br>
            <div class="mb-3 row">
                <label for="addAlternateNameField" class="col-md-3 form-label">Alternate Name</label>
                <div class="col-md-9">
                
                    <select class="form-control" name="addAlternateNameField" id="addAlternateNameField" required>
                        <option value="">Select</option>';
                        
                        $queries = "SELECT * FROM tbl_hr_employee where user_id = ".$row['user_cookies'];
                        $resultQuery = mysqli_query($conn, $queries);
                        while($rowcrm = mysqli_fetch_array($resultQuery)){ 
                            echo '<option value="'.$rowcrm['ID'].'"'; echo $rowcrm['ID']==$row['addAlternateNameField'] ? 'SELECTED':''; echo '>'.htmlentities($rowcrm['first_name'] ?? '').' '.htmlentities($rowcrm['last_name'] ?? '').'</option>';
                        }
                        
                    echo '</select>
                </div>
            </div>';

        }

        mysqli_close($conn);
	}

?>
