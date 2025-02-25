<?php
	require '../database.php';
	$base_url = "https://interlinkiq.com/";
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
if(isset($_POST['search_val'])){
    	$identifier = $_POST['search_val'];
	$sql2 = $conn->query("SELECT * FROM tbl_MyProject_Services_Childs_action_Items 
		left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
        left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
		where CAI_id = '$identifier'");
		
		while($data2 = $sql2->fetch_array()) {
		$files_p = $data2["CAI_files"];
        $fileExtension = fileExtension($files_p);
		$src = $fileExtension['src'];
		$embed = $fileExtension['embed'];
		$type = $fileExtension['type'];
		$file_extension = $fileExtension['file_extension'];
        $url = $base_url.'../MyPro_Folder_Files/';
        ?>
		
		<!--onclick="view_more('<?php //echo $data2['Services_History_PK']; ?>')"-->
		    <tr id="shortcut_<?php echo $data2['CAI_id']; ?>">
		        <td class="child_border" width="50px"><?php echo $data2['CAI_id']; ?></td>
		        <?php
				    $owner  = $data2['CAI_User_PK'];
                    $query = "SELECT * FROM tbl_user where ID = $owner";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result)){ 
                        echo '<td class="child_2">From: '.$row['first_name'].'</td>';
                    }
				?>
				<td class="child_2">
				    <?php
				    $stringProduct = strip_tags($data2['CAI_filename']); 
                   if(strlen($stringProduct) > 40):
                       $stringCut = substr($stringProduct,0,40);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub2" data-toggle="modal" onclick="get_moreDetails_sub2('.$data2['CAI_id'].')">
                       <i style="color:black;">More...</i></a>';
                   endif;
                   echo $stringProduct;
                   ?>
				</td>
				<td class="child_2" >
				<?php
				    $stringProduct = strip_tags($data2['CAI_description']); 
                   if(strlen($stringProduct) > 35):
                       $stringCut = substr($stringProduct,0,35);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$data2['CAI_id'].')">
                       <i style="color:black;">More...</i></a>';
                   endif;
                   echo $stringProduct;
                   ?>
				</td>
			
				<td class="child_2"><?php echo $data2['CAI_Accounts']; ?></td>
				<td class="child_2"><?php echo $data2['Action_Items_name']; ?></td>
				<td class="child_2">Assign to: <?php echo $data2['first_name']; ?></td>
				<?php 
				
				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}
	            //rendered time
	            if(!empty($data2['CAI_Rendered_Minutes'])){
        	        echo '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
        	            
        	       if($data2['Service_log_Status'] !=1 && $data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
        	           echo ' <a style="font-weight:800;color:#fff;" href="#modal_get_newlogs" data-toggle="modal" class="btn red btn-xs" onclick="btnLogs('.$data2['CAI_id'].')">Add logs</a>';
        	       }else{
            	       if($data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
        	              echo '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
            	        }
        	       }
        	    }
        	    if($data2['CIA_progress']==2){
        	        echo '<td class="child_2">100%</td>';
        	    }
				?>
				<td class="child_2">Start: <?php echo date("Y-m-d", strtotime($data2['CAI_Action_date'])); ?></td>
				<td class="child_2">Due: <?php echo date("Y-m-d", strtotime($data2['CAI_Action_due_date'])); ?></td>
					<td class="child_2">
					<?php 
                        
                            if (!empty($files_p))
            			     {
            			         echo '
            			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($files_p).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                        	        </a>
                        	    ';
            			     }
            			     else
            			     {
            			         echo '
            			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($files_p).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                        <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                        	        </a>
            			         ';
            			     }
            			?>  
                        
    				</td>
    				<td class="child_2">
    				<?php
                    $_comment  = $data2['CAI_id'];
                    $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                    $result_comment = mysqli_query($conn, $query_comment);
                    while($row_comment = mysqli_fetch_array($result_comment)){ 
                        echo '
                        <a href="#modalGet_Comments_filter" data-toggle="modal" onclick="btn_Comments_filter('.$data2['CAI_id'].')">
                        <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'; if($row_comment['count'] == 0){ echo '#DC3535';}else{ echo 'blue';} echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                <b>'.$row_comment['count'].'</b>
                            </span>
                        </a>
                        ';
                    }
                  ?> 
                </td>
                
                <td class="child_2">
                    <?php
                     echo '<a style="color:#fff;" href="#modalGet_shortcut" data-toggle="modal" class="btn red btn-xs" onclick="onclick_shortcut('.$data2['CAI_id'].')">Edit</a>';
                    ?>
                </td>
		    </tr>
	<?php	}
}


if(isset($_GET['post_id'])){
	$post_id = $_GET['post_id'];
	$h_id = $_GET['h_id'];
	$sql2 = $conn->query("SELECT * FROM tbl_MyProject_Services_Childs_action_Items 
		left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
        left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
		where CAI_Assign_to = $post_id and Services_History_PK = $h_id");
		
		while($data2 = $sql2->fetch_array()) {
		    $files_p = $data2["CAI_files"];
            $fileExtension = fileExtension($files_p);
    		$src = $fileExtension['src'];
    		$embed = $fileExtension['embed'];
    		$type = $fileExtension['type'];
    		$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
		    $data_id = $data2['Services_History_PK'];
		?>
		
		<!--onclick="view_more('<?php echo $data2['Services_History_PK']; ?>')"-->
		    <tr id="shortcut_<?php echo $data2['CAI_id']; ?>">
		        <td class="child_border" width="50px"><?php echo $data2['CAI_id']; ?></td>
		        <?php
				    $owner  = $data2['CAI_User_PK'];
                    $query = "SELECT * FROM tbl_user where ID = $owner";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result)){ 
                        echo '<td class="child_2">From: '.$row['first_name'].'</td>';
                    }
				?>
				<td class="child_2">
				    <?php
				    $stringProduct = strip_tags($data2['CAI_filename']); 
                   if(strlen($stringProduct) > 40):
                       $stringCut = substr($stringProduct,0,40);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub2" data-toggle="modal" onclick="get_moreDetails_sub2('.$data2['CAI_id'].')">
                       <i style="color:black;">More...</i></a>';
                   endif;
                   echo $stringProduct;
                   ?>
				</td>
				<td class="child_2" >
				<?php
				    $stringProduct = strip_tags($data2['CAI_description']); 
                   if(strlen($stringProduct) > 35):
                       $stringCut = substr($stringProduct,0,35);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$data2['CAI_id'].')">
                       <i style="color:black;">More...</i></a>';
                   endif;
                   echo $stringProduct;
                   ?>
				</td>
			
				<td class="child_2"><?php echo $data2['CAI_Accounts']; ?></td>
				<td class="child_2"><?php echo $data2['Action_Items_name']; ?></td>
				<td class="child_2">Assign to: <?php echo $data2['first_name']; ?></td>
				<?php 
				
				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}
	            //rendered time
	            if(!empty($data2['CAI_Rendered_Minutes'])){
        	        echo '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
        	            
        	       if($data2['Service_log_Status'] !=1 && $data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
        	           echo ' <a style="font-weight:800;color:#fff;" href="#modal_get_newlogs" data-toggle="modal" class="btn red btn-xs" onclick="btnLogs('.$data2['CAI_id'].')">Add logs</a>';
        	       }else{
            	       if($data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
        	              echo '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
            	        }
        	       }
        	    }
        	    if($data2['CIA_progress']==2){
        	        echo '<td class="child_2">100%</td>';
        	    }
				?>
				<td class="child_2">Start: <?php echo date("Y-m-d", strtotime($data2['CAI_Action_date'])); ?></td>
				<td class="child_2">Due: <?php echo date("Y-m-d", strtotime($data2['CAI_Action_due_date'])); ?></td>
					<td class="child_2">
					<?php 
                        
                            if (!empty($files_p))
            			     {
            			         echo '
            			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($files_p).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                        	        </a>
                        	    ';
            			     }
            			     else
            			     {
            			         echo '
            			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($files_p).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                        <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                        	        </a>
            			         ';
            			     }
            			?>  
                        
    				</td>
    				<td class="child_2">
    				<?php
                    $_comment  = $data2['CAI_id'];
                    $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                    $result_comment = mysqli_query($conn, $query_comment);
                    while($row_comment = mysqli_fetch_array($result_comment)){ 
                        echo '
                        <a href="#modalGet_Comments_filter" data-toggle="modal" onclick="btn_Comments_filter('.$data2['CAI_id'].')">
                        <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'; if($row_comment['count'] == 0){ echo '#DC3535';}else{ echo 'blue';} echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                <b>'.$row_comment['count'].'</b>
                            </span>
                        </a>
                        ';
                    }
                  ?> 
                </td>
                
                <td class="child_2">
                    <?php
                     echo '<a style="color:#fff;" href="#modalGet_shortcut" data-toggle="modal" class="btn red btn-xs" onclick="onclick_shortcut('.$data2['CAI_id'].')">Edit</a>';
                    ?>
                </td>
		    </tr>
	<?php	            
		    
		}
}
?>
