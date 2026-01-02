<?php 
     include_once ('../database.php'); 
     
    if( isset($_GET['modalView']) ) {
    		$id = $_GET['modalView'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_Customer_Relationship_Notes WHERE notes_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
    		<input class="form-control" type="hidden" name="ID" value="'. $row['notes_id'] .'" />
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Notes</label>
                        <textarea class="form-control" rows="8" cols="5" name="Notes">'. $row['Notes'].'</textarea>
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
