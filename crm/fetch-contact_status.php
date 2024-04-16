<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalView']) ) {
    		$id = $_GET['modalView'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_Customer_Relationship_Task WHERE crmt_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
    		<input class="form-control" type="hidden" name="ID" value="'. $row['crmt_id'] .'" />
             <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Task Status</label>
                    </div>
                    <div class="col-md-12">
                        <select class="form-control" name="Task_Status">
                            <option value="1"'; if($row['Task_Status']==1){echo 'selected';}else{echo '';} echo' >Pending</option>
                            <option value="2" '; if($row['Task_Status']==2){echo 'selected';}else{echo '';} echo'>In-Progress</option>
                            <option value="3" '; if($row['Task_Status']==3){echo 'selected';}else{echo '';} echo'>Done</option>
                        </select>
                    </div>
                </div>
            </div>
               
                            
                </div>
            ';
    
            mysqli_close($conn);
    	}

?>