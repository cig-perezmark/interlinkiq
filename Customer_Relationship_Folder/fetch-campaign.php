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
                        <textarea class="form-control" name="Campaign_body" id="edit_campaign">'. $row['Campaign_body'].' </textarea>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
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

      <!--          <div class="col-md-6">-->
      <!--                  <label>Frequency</label>-->
      <!--                  <select class="form-control" name="Frequency">-->
						<!--	<option value="1" '; echo $row['Frequency'] == 1 ? 'selected': ' '; echo '>Once Per Day</option>-->
						<!--	<option value="2" '; echo $row['Frequency'] == 2 ? 'selected': ''; echo '>Once Per Week</option>-->
						<!--	<option value="3" '; echo $row['Frequency'] == 3 ? 'selected': ''; echo '>On the 1st and 15th of the Month</option>-->
						<!--	<option value="4" '; echo $row['Frequency'] == 4 ? 'selected': ''; echo '>Once Per Month</option>-->
						<!--	<option value="6" '; echo $row['Frequency'] == 6 ? 'selected': ''; echo '>Once Per Two Months (Every Other Month)</option>-->
						<!--	<option value="7" '; echo $row['Frequency'] == 7 ? 'selected': ''; echo '>Once Per Three Months (Quarterly)</option>-->
						<!--	<option value="8" '; echo $row['Frequency'] == 8 ? 'selected': ''; echo '>Once Per Six Months (Bi-Annual)</option>-->
						<!--	<option value="5" '; echo $row['Frequency'] == 5 ? 'selected': ''; echo '>Once Per Year</option>-->
						<!--</select>-->
      <!--              </div>-->

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
      <script>
       $(document).ready(function() {
            $("#edit_campaign").summernote({
                placeholder:'',
                height: 400
            });
            $('.dropdown-toggle').dropdown();
        });
      </script>
