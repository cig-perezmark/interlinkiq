<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalViewApp']) ) {
    		$id = $_GET['modalViewApp'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails_Records WHERE rec_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
    		<input class="form-control" type="hidden" name="ID" value="'. $row['rec_id'] .'" />
                             <div class="row">
                                 <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Document</label>
                                    </div><div class="col-md-6">
                                        <input class="form-control" type="text" name="retain" id="retain" placeholder="'. $row['EnterpriseRecordsFile'] .'"  disabled />
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="file" name="EnterpriseRecordsFile" id="EnterpriseRecordsFile">
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Document Title</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="DocumentTitle" id="DocumentTitle" value="'. $row['DocumentTitle'] .'"  required />
                                    </div>
                                </div>
                            </div>
                           <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Desciption</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="DocumentDesciption" id="DocumentDesciption" value="'. $row['DocumentDesciption'] .'" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Document DueDate.</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="date" id="DocumentDueDate" name="DocumentDueDate" value="'. $row['DocumentDueDate'] .'"  />
                                    </div>
                                </div>
                            </div>
                </div>
            ';
    
            mysqli_close($conn);
    	}

?>