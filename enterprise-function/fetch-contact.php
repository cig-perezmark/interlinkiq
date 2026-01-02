<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalViewApp']) ) {
    		$id = $_GET['modalViewApp'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails_Contact WHERE con_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
    		<input class="form-control" type="hidden" name="ID" value="'.$row['con_id'].'" />
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>First Name</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="contactpersonname" id="contactpersonname" value="'. $row['contactpersonname'] .'" required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Last Name</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="contactpersonlastname" id="contactpersonlastname" value="'.$row['contactpersonlastname'].'"  required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                     <div class="col-md-12">
                        <label>Title</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="titles" id="titles" value="'.$row['titles'].'" required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Cell No.</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" id="contactpersoncellno" name="contactpersoncellno" value="'.$row['contactpersoncellno'].'" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Phone</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" id="contactpersonphone" name="contactpersonphone" value="'.$row['contactpersonphone'].'">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>FAX</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" id="contactpersonfax" name="contactpersonfax" value="'.$row['contactpersonfax'].'">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Email Address</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" id="contactpersonemailAddress" name="contactpersonemailAddress" value="'.$row['contactpersonemailAddress'].'"  required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Office Address</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" id="contactpersonOfficeAddress" name="contactpersonOfficeAddress" value="'.$row['contactpersonOfficeAddress'].'" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Type</label>
                    </div>
                    <div class="col-md-12">
                        <select class="form-control" id="contactpersonType" name="contactpersonType">
                            <option value="0">Select</option>
                            <option value="1"'; echo $row['contactpersonType'] == 1 ? 'SELECTED':''; echo '>Information Owner</option>
                            <option value="2"'; echo $row['contactpersonType'] == 2 ? 'SELECTED':''; echo '>System Owner</option>
                            <option value="3"'; echo $row['contactpersonType'] == 3 ? 'SELECTED':''; echo '>System Security Officer</option>
                        </select>
                    </div>
                </div>
            </div>';
    
            mysqli_close($conn);
    	}

?>