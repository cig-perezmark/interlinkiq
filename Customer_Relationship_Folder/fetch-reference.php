<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalView']) ) {
    		$id = $_GET['modalView'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_Customer_Relationship_References WHERE reference_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
    		<input class="form-control" type="hidden" name="ID" value="'. $row['reference_id'] .'" />
    		<div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Title</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" name="Title" value="'. $row['Title'].'">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Description</label>
                        <textarea class="form-control" name="Description">'. $row['Description'].'</textarea>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Date Added</label>
                        <input type="date" class="form-control" name="Date_Added" value="'.date("Y-m-d", strtotime($row['Date_Added'])).'">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Date End</label>
                        <input type="date" class="form-control" name="Date_End" value="'.date("Y-m-d", strtotime($row['Date_End'])).'">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-6">
                        <label>Documents</label>
                        <input class="form-control" name="" value="'. $row['Documents'].'" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>...</label>
                        <input type="file" class="form-control" name="Documents" value="'. $row['Documents'].'">
                    </div>
                </div>
            </div>
            
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
