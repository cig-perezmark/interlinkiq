<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalView']) ) {
    		$id = $_GET['modalView'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_Customer_Relationship left join tbl_hr_employee on ID = contact_name WHERE crm_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
    		<input class="form-control" type="hidden" name="ID" value="'. $row['crm_id'] .'" />
             <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Contact Name</label>
                    </div>
                    <div class="col-md-12">
                    <input class="form-control" name="contact_name" value="'.$row['contact_name'].'" >
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
                        <input class="form-control" type="text" name="contact_title" id="contact_title" value="'. $row['contact_title'] .'"  />
                    </div>
                </div>
            </div>
                <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Report to</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="contact_report" id="contact_report" value="'. $row['contact_report'] .'"  />
                    </div>
                </div>
            </div>
             <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Address</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="contact_address" id="contact_address" value="'. $row['contact_address'] .'"  />
                    </div>
                </div>
            </div>
                <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Email</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="contact_email" id="contact_email" value="'. $row['contact_email'] .'"  />
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
                        <input class="form-control" type="text" name="contact_phone" id="contact_phone" value="'. $row['contact_phone'] .'"  />
                    </div>
                </div>
            </div>
                <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Fax</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="contact_fax" id="contact_fax" value="'. $row['contact_fax'] .'"  />
                    </div>
                </div>
            </div>
                            
                </div>
            ';
    
            mysqli_close($conn);
    	}

?>
