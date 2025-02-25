<?php 
    include_once ('../database.php'); 
     
    if( isset($_GET['modalViewApp']) ) {
		$id = $_GET['modalViewApp'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails_Emergency WHERE emerg_id = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
        }

		echo '<input class="form-control" type="hidden" name="ID" value="'. $row['emerg_id'] .'" />
        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <label>First Name</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="text" name="emergencyname" id="emergencyname" value="'. $row['emergencyname'] .'" required />
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
                    <input class="form-control" type="text" name="emergencycontact_last_name" id="emergencycontact_last_name" value="'. $row['emergencycontact_last_name'] .'"  required />
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
                    <input class="form-control" type="text" name="emergency_contact_title" id="emergency_contact_title" value="'. $row['emergency_contact_title'] .'">
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
                    <input class="form-control" type="text" id="emergencycellno" name="emergencycellno" value="'. $row['emergencycellno'] .'"  />
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
                    <input class="form-control" type="text" id="emergencyphone" name="emergencyphone" id="emergencyphone" value="'. $row['emergencyphone'] .'" >
                </div>
            </div>
        </div>
        <br>
        <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <label>FAX</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="text" id="emergencyfax" name="emergencyfax" value="'. $row['emergencyfax'] .'" >
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <label>Email Address</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="text" id="emergencyemailAddress" name="emergencyemailAddress" value="'. $row['emergencyemailAddress'] .'"  required/>
                </div>
            </div>
        </div>';

        mysqli_close($conn);
	}
?>
