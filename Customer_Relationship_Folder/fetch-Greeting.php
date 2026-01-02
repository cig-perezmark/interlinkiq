<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalView']) ) {
    		$id = $_GET['modalView'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
    		<input class="form-control" type="hidden" name="ID" value="'. $row['Campaign_Id'] .'" />
    		<div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Campaign Name</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" name="Campaign_Name" value="'. $row['Campaign_Name'].'">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-6">
                        <label>Recipient</label>
                        <input class="form-control" name="Campaign_Recipients" value="'. $row['Campaign_Recipients'].'">
                    </div>
                    <div class="col-md-6">
                        <label>Subject</label>
                        <input class="form-control" name="Campaign_Subject" value="'. $row['Campaign_Subject'].'">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Body</label>
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control" name="Campaign_body" id="edit_greeting">'. $row['Campaign_body'].' </textarea>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                <div class="col-md-6">
                        <label>Date Schedule</label>
                        <input type="date" class="form-control" name="Target_Date" value="'.date("Y-m-d", strtotime($row['Target_Date'])).'" required>
                    </div>
                    <div class="col-md-6">
                        <label>Auto Email</label>
                        <select class="form-control" name="Auto_Send_Status">
                            <option value="0"'; if($row['Auto_Send_Status']==0){echo 'selected';}else{echo '';} echo' >Stop</option>
                            <option value="1" '; if($row['Auto_Send_Status']==1){echo 'selected';}else{echo '';} echo'>Activate</option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            ';
    
            mysqli_close($conn);
    	}

?>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
      <script>
       $(document).ready(function() {
            $("#edit_greeting").summernote({
                placeholder:'',
                height: 400
            });
            $('.dropdown-toggle').dropdown();
        });
      </script>
