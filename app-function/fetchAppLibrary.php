<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalViewApp']) ) {
    		$id = $_GET['modalViewApp'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_appstore left join tbl_library on tbl_library.ID = tbl_appstore.appEntities 
    		left join tbl_library_file on 	tbl_library_file.library_id = tbl_library.ID  WHERE app_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '<input class="form-control" type="hidden" name="ID" value="'. $row['app_id'] .'" />
    		<div class="form-group">
                <div class="col-md-3">
                    <label class="control-label"><strong>Subscription Required:</strong></label>
                </div>
                <div class="col-md-9">
                    <label class="control-label">Please contact Services@ConsultareInc.com to activate</label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-3">
                    <label class="control-label"><strong>App Name:</strong></label>
                </div>
                <div class="col-md-9">
                    <label class="control-label">'. $row['application_name'] .'</label>
                </div>
            </div>
            <div class="form-group">
                 <div class="col-md-3">
                    <label class="control-label"><strong>Description:</strong></label>
                 </div
                 <div class="col-md-9">
                    <textarea class="form-control" style="border:transparent;">'. $row['descriptions'] .'</textarea>
                 </div
            </div> 
            
            
            ';
    
            mysqli_close($conn);
    	}

?>
