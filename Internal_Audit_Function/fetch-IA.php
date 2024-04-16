<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalViewApp']) ) {
    		$id = $_GET['modalViewApp'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_Internal_Audit WHERE IA_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
    		<input class="form-control" type="hidden" name="ID" value="'. $row['IA_id'] .'" />
             <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Category</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="" id="" value="'. $row['IA_Category'] .'" readonly>
                    </div>
                </div>
            </div>
            <br>
             <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Area</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="IA_Areas" id="IA_Areas" value="'. $row['IA_Areas'] .'"  readonly>
                    </div>
                </div>
            </div>
           <br>
            <div class="row">
                <div class="form-group">
                     <div class="col-md-12">
                        <label>Description</label>
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control" type="text" name="IA_Description" id="IA_Description" readonly>'. $row['IA_Description'] .'</textarea>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                     <div class="col-md-12">
                        <label>Compliance</label>
                    </div>
                    <div class="col-md-12">
                        <select class="form-control" name=" required>
                            <option value="">---Select---</option>
                            <option value="1">No</option>
                            <option value="2">N/A</option>
                            <option value="3">Yes</option>
                        </select>
                    </div>
                </div>
            </div>                 
            ';
    
            mysqli_close($conn);
    	}

?>