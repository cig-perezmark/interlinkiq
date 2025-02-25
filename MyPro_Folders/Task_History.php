<?php 
     include_once ('../database.php'); 
     $base_url = "https://interlinkiq.com/";
    if( isset($_GET['modalView']) ) {
    		$id = $_GET['modalView'];
    		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $id" );
    		if ( mysqli_num_rows($selectData) > 0 ) {
                $row = mysqli_fetch_array($selectData);
            }
    
    		echo '
             <div class="row">
                <div class="form-group">
                    <div class="col-md-3">
                    <input class="form-control" type="text" value="'.'Ticket No.:'.' '.$row['MyPro_id'].'" readonly>
                    </div>
                    <div class="col-md-9" >
                        <input class="form-control" type="text" value="'.$row['Project_Name'].'" readonly>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    	
                    <div class="table-scrollable">
                        <table class="table table-hover">
                            <thead>
                               
                            </thead>
                            <tbody>';
                                $myPro = $row['MyPro_id'];
				                $selectFile = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_History left join tbl_MyProject_Services_Action_Items on Action_Items_id = Action_taken
				                left join tbl_user on tbl_MyProject_Services_History.user_id = ID WHERE MyPro_PK = $id" );
						        if ( mysqli_num_rows($selectFile) > 0 ) {
							        while($rowFile = mysqli_fetch_array($selectFile)) {
                                        $file_ID = $rowFile["History_id"];
                                        $files = $rowFile["files"];
                                        $fileExtension = fileExtension($files);
										$src = $fileExtension['src'];
										$embed = $fileExtension['embed'];
										$type = $fileExtension['type'];
										$file_extension = $fileExtension['file_extension'];
							            $url = $base_url.'MyPro_Folder_Files/';
							            
                                        $file_name = $rowFile["filename"];
                                        $description = $rowFile["description"];
                                        $Action_taken = $rowFile["Action_Items_name"];
                                        $name = $rowFile["first_name"];
                                        $minutes = $rowFile["Rendered_Minutes"];
                                        

							        	echo '<tr id="tr_'.$file_ID.'">
		                                    <td >'.$Action_taken.' '.'by:'.' '.$name.'</td>
		                                    <td >'.$file_name.'</td>
		                                    <td >'.$description.'</td>
		                                    <td >'.'Rendered: '.$minutes.' '.'minutes'.'</td>
							        	    <td>
							        	        <a data-src="'.$src.$url.rawurlencode($files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">'.$files.'</a>
							        	    </td>
		                                </tr>';
							        }
						        }

                             echo '</tbody>
                        </table>
                    </div>
                    <a style="float:right;" href="#modalAddActionItem" data-toggle="modal" class="btn green btn-xs" onclick="btnNew_File('.$row['MyPro_id'].')">New Action Item</a>
                </div>
            </div>
           
            ';
    
            mysqli_close($conn);
    	}
function fileExtension($file) {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $src = 'https://view.officeapps.live.com/op/embed.aspx?src=';
        $embed = '&embedded=true';
        $type = 'iframe';
    	if ($extension == "pdf") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-pdf-o"; }
		else if (strtolower($extension) == "doc" OR strtolower($extension) == "docx") { $file_extension = "fa-file-word-o"; }
		else if (strtolower($extension) == "ppt" OR strtolower($extension) == "pptx") { $file_extension = "fa-file-powerpoint-o"; }
		else if (strtolower($extension) == "xls" OR strtolower($extension) == "xlsb" OR strtolower($extension) == "xlsm" OR strtolower($extension) == "xlsx" OR strtolower($extension) == "csv" OR strtolower($extension) == "xlsx") { $file_extension = "fa-file-excel-o"; }
		else if (strtolower($extension) == "gif" OR strtolower($extension) == "jpg"  OR strtolower($extension) == "jpeg" OR strtolower($extension) == "png" OR strtolower($extension) == "ico") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-image-o"; }
		else if (strtolower($extension) == "mp4" OR strtolower($extension) == "mov"  OR strtolower($extension) == "wmv" OR strtolower($extension) == "flv" OR strtolower($extension) == "avi" OR strtolower($extension) == "avchd" OR strtolower($extension) == "webm" OR strtolower($extension) == "mkv") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-video-o"; }
		else { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-code-o"; }

		$output['src'] = $src;
	    $output['embed'] = $embed;
	    $output['type'] = $type;
	    $output['file_extension'] = $file_extension;
	    return $output;
    }
?>
