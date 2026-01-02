<?php 
    include_once ('../database.php'); 
     
    if( isset($_GET['modalViewApp']) ) {
		$id = $_GET['modalViewApp'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails_Records WHERE rec_id = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
        }
    
		echo '<input class="form-control" type="hidden" name="ID" value="'. $row['rec_id'] .'" />
        <div class="form-group">
            <label>Document</label>
            <input class="form-control" type="hidden" name="retain" id="retain" placeholder="'. $row['EnterpriseRecordsFile'] .'"  disabled />
            <input class="form-control" type="file" name="EnterpriseRecordsFile" id="EnterpriseRecordsFile" />
        </div>
        <div class="form-group">
            <label>Document Title</label>
            <input class="form-control" type="text" name="DocumentTitle" id="DocumentTitle" value="'. $row['DocumentTitle'] .'"  required />
        </div>
        <div class="form-group">
            <label>Description</label>
            <input class="form-control" type="text" name="DocumentDesciption" id="DocumentDesciption" value="'. $row['DocumentDesciption'] .'" required />
        </div>
		<div class="form-group">
		    <div class="row">
    			<label class="col-md-3 control-label">Non Expiry</label>
    			<div class="col-md-8 control-label" style="text-align: left;">
    				<input type="checkbox" name="non_expiry" onchange="changeExpiry(this)" value="'.$row['non_expiry'].'" '; echo $row['non_expiry'] == 0 ? '':'checked'; echo '>
    			</div>
			</div>
		</div>
        <div class="form-group document_date '; echo $row['non_expiry'] == 0 ? '':'hide'; echo '">
            <label>Document Due Date</label>
            <input class="form-control" type="date" id="DocumentDueDate" name="DocumentDueDate" value="'. $row['DocumentDueDate'] .'"  />
        </div>';
    
        mysqli_close($conn);
	}

?>
