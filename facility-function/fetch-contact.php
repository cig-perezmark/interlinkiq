<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalViewApp']) ) {
    		$id = $_GET['modalViewApp'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tblFacilityDetails_contact WHERE con_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
    		<input class="form-control" type="hidden" name="ID" value="'. $row['con_id'] .'" />
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
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Last Name</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="contactpersonlastname" id="contactpersonlastname" value="'. $row['contactpersonlastname'] .'"  required />
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
                                        <input class="form-control" type="text" name="titles" id="titles" value="'. $row['titles'] .'" >
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
                                        <input class="form-control" type="text" id="contactpersoncellno" name="contactpersoncellno" value="'. $row['contactpersoncellno'] .'"  />
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
                                        <input class="form-control" type="text" id="contactpersonphone" name="contactpersonphone" value="'. $row['contactpersonphone'] .'" >
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
                                        <input class="form-control" type="text" id="contactpersonfax" name="contactpersonfax" value="'. $row['contactpersonfax'] .'" >
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
                                        <input class="form-control" type="text" id="contactpersonemailAddress" name="contactpersonemailAddress" value="'. $row['contactpersonemailAddress'] .'"  required/>
                                    </div>
                                </div>
                </div>
            ';
    
            mysqli_close($conn);
    	}

?>
