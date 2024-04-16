<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalViewApp']) ) {
    		$id = $_GET['modalViewApp'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tblFacilityDetails_Service_Team WHERE Service_Team_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
    		<input class="form-control" type="hidden" name="ID" value="'. $row['Service_Team_id'] .'" />
             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>First Name</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="Service_Team_name" id="Service_Team_name" value="'. $row['Service_Team_name'] .'" required />
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
                                        <input class="form-control" type="text" name="Service_Team_last_name" id="Service_Team_last_name" value="'. $row['Service_Team_last_name'] .'"  required />
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
                                        <input class="form-control" type="text" name="Service_Team_title" id="Service_Team_title" value="'. $row['Service_Team_title'] .'" required />
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
                                        <input class="form-control" type="text" id="Service_Team_cellno" name="Service_Team_cellno" value="'. $row['Service_Team_cellno'] .'"  />
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
                                        <input class="form-control" type="text" id="Service_Team_phone" name="Service_Team_phone" value="'. $row['Service_Team_phone'] .'"  />
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
                                        <input class="form-control" type="text" name="Service_Team_emailAddress" id="Service_Team_emailAddress" value="'. $row['Service_Team_emailAddress'] .'"  required />
                                    </div>
                                </div>
                            </div>
            ';
    
            mysqli_close($conn);
    	}

?>