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
		$selectData = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails_BusinessStructure WHERE ID = $ID" );
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
                        <label>Name</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="name" value="'. $row['name'] .'" required />
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                     <div class="col-md-12">
                        <label>Supporting Document</label>
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" name="file_tmp" value="'.$row["files"].'" />
                        <input class="form-control '; echo !empty($files) ? 'hide':''; echo '" type="file" name="file" />
                        <p class="'; echo !empty($files) ? '':'hide'; echo '" style="margin: 0;"><a href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'" class="btn btn-link">View</a> | <button type="button" class="btn btn-link uploadNew" onclick="uploadNew(this)">Upload New</button></p>
                    </div>
                </div>
            </div>';

        }
        mysqli_close($conn);
	}
?>
