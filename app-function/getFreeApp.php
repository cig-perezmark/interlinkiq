<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalGetFreeApp']) ) {
    		$id = $_GET['modalGetFreeApp'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_appstore WHERE app_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '<input class="form-control" type="hidden" name="ID" value="'. $row['app_id'] .'" />
    		<div class="form-group">
                <div class="col-md-2">
                    <label class="control-label"><strong></strong></label>
                </div>
                <div class="col-md-10">
                    <input type="hidden" class="form-control" name="userID" value="'.$_COOKIE['ID'].'">
                </div>
            </div>
    		<div class="form-group">
                <div class="col-md-2">
                    <label class="control-label"><strong>Price:</strong></label>
                </div>
                <div class="col-md-10">
                    <label class="control-label">'. $row['pricing'] .'</label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-2">
                    <label class="control-label"><strong>App Name:</strong></label>
                </div>
                <div class="col-md-10">
                    <label class="control-label">'. $row['application_name'] .'</label>
                </div>
            </div>
            <div class="form-group">
                 <div class="col-md-2">
                    <label class="control-label"><strong>Description:</strong></label>
                 </div
                 <div class="col-md-10">
                    <textarea class="form-control" style="border:transparent;">'. $row['descriptions'] .'</textarea>
                 </div>
            </div>
             <div class="row" style="margin-left:5px;">
                <div class="col-md-11">
                     <div class="form-group">
                        <label class="control-label"><strong>Company Details / Website Links:*</strong>
                        <i class="bg-warning">
                             Provide information this is subjected for Company Verification.
                        </i>
                        </label>
                     </div>
                </div>
            </div>
            <div class="row" style="margin-left:5px;">
                <div class="col-md-11">
                    <div class="form-group">
                        <textarea class="form-control" name="companydetails" id="companydetails" required></textarea>
                     </div>
                </div>
            </div>
            
            
            ';
    
            mysqli_close($conn);
    	}

?>
