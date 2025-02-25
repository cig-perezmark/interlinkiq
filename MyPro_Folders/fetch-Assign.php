<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalView']) ) {
    		$id = $_GET['modalView'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
    		<input class="form-control" type="hidden" name="ID" value="'. $row['MyPro_id'] .'" />
             <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Project Name</label>
                    </div>
                    <div class="col-md-12" >
                        <input class="form-control" type="text" value="'.$row['Project_Name'].'" readonly>
                    </div>
                </div>
            </div>
            <br>
           <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Image/file <i style="color:#1746A2;font-size:12px;"> ( Sample/Supporting files )</i></label>
                    </div>
                    <div class="col-md-12" >
                        <input class="form-control" type="text" name="" value="'.$row['Sample_Documents'].'" readonly>
                    </div>
                </div>
            </div>
           <br>
            <div class="row">
                <div class="form-group">
                     <div class="col-md-12">
                        <label>Descriptions</label>
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control" type="text" name="Project_Description" rows="4" disabled>'.$row['Project_Description'].'</textarea>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Assign to</label>
                    </div>
                    <div class="col-md-12">
                        <select class="form-control mt-multiselect btn btn-default" type="text" name="User_Assign_PK" required>
                            <option value="">---Select---</option>
                            ';
                                $queryType = "SELECT * FROM tbl_hr_employee left join tbl_user on tbl_hr_employee.ID = employee_id where user_id = 34 and tbl_hr_employee.status = 1 order by tbl_user.first_name ASC";
                            $resultType = mysqli_query($conn, $queryType);
                            while($rowType = mysqli_fetch_array($resultType))
                                 { 
                                   echo '<option value="'.$rowType['ID'].'">'.$rowType['first_name'].' '.$rowType['last_name'].'</option>'; 
                               } 
                             echo '
                        </select>
                    </div>
                </div>
            </div>
            <br>
          
            ';
    
            mysqli_close($conn);
    	}

?>
