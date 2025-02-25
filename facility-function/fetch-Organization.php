<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalViewApp']) ) {
    		$id = $_GET['modalViewApp'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tblFacilityDetails_Facility_Organization WHERE Org_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
    		<input class="form-control" type="hidden" name="ID" value="'. $row['Org_id'] .'" />
             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>First Name</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="Organization_name" id="Organization_name" value="'. $row['Organization_name'] .'" required />
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
                                        <input class="form-control" type="text" name="Organization_last_name" id="Organization_last_name" value="'. $row['Organization_last_name'] .'"  required />
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
                                        <input class="form-control" type="text" name="Organization_title" id="Organization_title" value="'. $row['Organization_title'] .'"  />
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
                                        <input class="form-control" type="text" id="Organization_cellno" name="Organization_cellno" value="'. $row['Organization_cellno'] .'"  />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Phone No.</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" id="Organization_phone" name="Organization_phone" value="'. $row['Organization_phone'] .'"  />
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
                                        <input class="form-control" type="text" name="Organization_emailAddress" id="Organization_emailAddress" value="'. $row['Organization_emailAddress'] .'">
                                    </div>
                                </div>
                            </div>
            ';
    
            mysqli_close($conn);
    	}

?>
