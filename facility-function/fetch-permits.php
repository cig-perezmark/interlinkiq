<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalView']) ) {
    		$id = $_GET['modalView'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tblFacilityDetails_Permits WHERE Permits_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
    		<input class="form-control" type="hidden" name="ID" value="'. $row['Permits_id'] .'" />
             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Permits</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="" name="" id="" value="'. $row['Permits'] .'"  readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="file" name="Permits" id="Permits">
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Type_s</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="Type_s" id="Type_s" value="'. $row['Type_s'] .'"  required />
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
                                        <textarea class="form-control" type="text" name="Descriptions" id="Descriptions" required>'. $row['Descriptions'] .'</textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Issue Date</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="date" id="Issue_Date" name="Issue_Date" value="'. $row['Issue_Date'] .'"  />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>Expiration Date</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="date" id="Expiration_Date" name="Expiration_Date" value="'. $row['Expiration_Date'] .'"  required />
                                    </div>
                                </div>
                            </div>
                </div>
            ';
    
            mysqli_close($conn);
    	}

?>
