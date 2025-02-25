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
                        <label>Types</label>
                    </div>
                    <div class="col-md-12">
                        <select class="form-control mt-multiselect btn btn-default" type="text" name="Notes_Types" required>
                            <option value="">---Select---</option>
                            ';
                                $queryType = "SELECT * FROM tbl_Notes_Type order by Notes_type ASC";
                            $resultType = mysqli_query($conn, $queryType);
                            while($rowType = mysqli_fetch_array($resultType))
                                 { 
                                   echo '<option value="'.$rowType['NoteType_Id'].'" '; echo $rowType['NoteType_Id'] == $row['Notes_Types'] ? 'selected': '';  echo'>'.$rowType['Notes_type'].'</option>'; 
                               } 
                             echo '
                             <option value="0">Others</option> 
                        </select>
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
                        <input class="form-control" name="Title" value="'. $row['Title'].'">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Notes</label>
                        <textarea class="form-control" name="Notes">'. $row['Notes'].'</textarea>
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
