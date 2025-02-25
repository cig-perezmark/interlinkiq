<?php 
    include_once ('../database.php'); 
     
    function fileExtension($file) {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $src = 'https://view.officeapps.live.com/op/embed.aspx?src=';
        $embed = '&embedded=true';
        $type = 'iframe';
    	if (strtolower($extension) == "pdf") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-pdf-o"; }
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
	    $output['file_mime'] = $extension;
	    return $output;
    }
    
    if( isset($_GET['modalViewApp']) ) {
		$ID = $_GET['modalViewApp'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails_Account WHERE ID = $ID" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
            
            $files = $row["files"];
            $type = 'iframe';
            if (!empty($files)) {
                $fileExtension = fileExtension($files);
                $src = $fileExtension['src'];
                $embed = $fileExtension['embed'];
                $type = $fileExtension['type'];
                $file_extension = $fileExtension['file_extension'];
                $url = $base_url.'uploads/enterprise/';

                $files = $src.$url.rawurlencode($files).$embed;
            }

            echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Description</label>
                        <textarea class="form-control" name="description" required>'. $row['description'] .'</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>URL</label>
                        <input class="form-control" type="text" name="url" value="'. $row['url'] .'" required />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Username</label>
                        <input class="form-control" type="text" name="username" value="'. $row['username'] .'"  required />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Password</label>
                        <input class="form-control" type="text" name="password" value="'. $row['password'] .'"  required />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Remark</label>
                        <textarea class="form-control" name="remark" required>'. $row['remark'] .'</textarea>
                    </div>
                </div>
            </div>';

        }
        mysqli_close($conn);
	}
?>
