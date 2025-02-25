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
		$selectData = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails_Agent WHERE ID = $ID" );
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
            
            $date_start = new DateTime($row['date_start']);
            $date_start = $date_start->format('m/d/Y');
            
            $date_end = new DateTime($row['date_end']);
            $date_end = $date_end->format('m/d/Y');

            echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Country</label>
                    </div>
                    <div class="col-md-12">';
                    
                        $resultcountry = mysqli_query($conn, "SELECT * FROM countries order by name ASC");
                        if ( mysqli_num_rows($resultcountry) > 0 ) {
                            echo '<select class="form-control" name="country">
                                <option value="0">---Select---</option>';
                                
                                while($rowcountry = mysqli_fetch_array($resultcountry)) {
                                    echo '<option value="'.$rowcountry['id'],'" '; echo $row["country"] == $rowcountry['id'] ? 'SELECTED':'';  echo '>'.utf8_encode($rowcountry['name']).'</option>';
                                }
                                
                            echo '</select>';
                        }
                        
                    echo '</div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Agent Name</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="name" value="'.$row['name'].'" required />
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Phone</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="phone" value="'.$row['phone'].'" required />
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Email</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="email" name="email" value="'.$row['email'].'" required />
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Address</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="address" value="'.$row['address'].'" required />
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Website</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="url" name="website" value="'.$row['website'].'" required />
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
                        <input class="form-control '; echo !empty($files) ? 'hide':''; echo '" type="file" name="file" />
                        <p class="'; echo !empty($files) ? '':'hide'; echo '" style="margin: 0;"><a href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'" class="btn btn-link">View</a> | <button type="button" class="btn btn-link uploadNew" onclick="uploadNew(this)">Upload New</button></p>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Expiration Date</label>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="text" class="form-control daterange" name="daterange" value="'.$date_start.' - '.$date_end.'" />
                            <span class="input-group-btn">
                                <button class="btn default date-range-toggle" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>';

        }
        mysqli_close($conn);
	}
?>
