
<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalView']) ) {
            $usersid = $_COOKIE['ID'];
    		$id = $_GET['modalView'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_Customer_Relationship left join tbl_Customer_Relationship_collaboration on crm_id = ccrm_id left join tbl_user on ID = userID   WHERE crm_id = $id " );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
    		<input class="form-control" type="hidden" name="ID" value="'. $row['crm_id'] .'" />
             <div class="row">
              <div class="form-group">
                    <div class="col-md-12">
                        <label>Invite Email</label>
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" class="form-control" name="from" value="'.$row['email'].'">
                        <input type="email" class="form-control" name="invite_mail">
                    </div>
                   
                </div>
            </div>
            <br>
            <div class="row">
              <div class="form-group">
                    <div class="col-md-12">
                        <label>Message</label>
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control" type="text" name="body_content" id="your_summernote" rows="4" required /></textarea>
                    </div>
                   
                </div>
            </div>
            <hr>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label></label>
                    </div>
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Shared to</th>
                                </tr>
                            </thead>
                            <tbody>
                                ';
                                    
                                    $querys = "SELECT * FROM tbl_Customer_Relationship_collaboration where ccrm_id = $id ";
                                    $results = mysqli_query($conn, $querys);                
                                    while($rows = mysqli_fetch_array($results))
                                    {
                                        echo'<tr><td>'.$rows['invite_mail'].'</td><td>'.$rows['body_content'].'</td> </tr>';
                                        
                                    }
                                    echo'
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            ';
    
            mysqli_close($conn);
    	}

?>
