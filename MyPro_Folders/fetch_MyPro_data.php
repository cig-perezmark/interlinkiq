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
// if(isset($_POST['search'])){
// 	    $search = $_POST['search'];
//  	    $query = "SELECT * FROM tbl_MyProject_Services_History left join tbl_MyProject_Services_Action_Items on Action_Items_id = Action_taken
//         left join tbl_hr_employee on Assign_to_history = ID left join tbl_user on employee_id = tbl_hr_employee.ID
//         WHERE MyPro_PK LIKE '{$search}%'";
//  		$result = mysqli_query($conn, $query);
//  		if(mysqli_num_rows($result) > 0){
//  		    while($row = mysqli_fetch_assoc($result)) {
//  		    ?>
 		        
//  		        <tr>
//  					<td><?php //echo $row['History_id']; ?></td>
 					
//  				</tr>
				
// 	        <?php	//}
//  		}
//  		else{
//  		    echo '<h6>No data found</h6>';
//  		}
         
// }

if (isset($_POST['key'])) {
	$response = "";
	if ($_POST['key'] == 'ids') {
	    $view_id = $_POST['view_id'];
		$sql = $conn->query("SELECT * FROM tbl_MyProject_Services_History left join tbl_MyProject_Services_Action_Items on Action_Items_id = Action_taken
         left join tbl_hr_employee on Assign_to_history = ID left join tbl_user on employee_id = tbl_hr_employee.ID where MyPro_PK = $view_id");
		while($data1 = $sql->fetch_array()) {
			$response .= '
				<tr>
					<td class="child_1">'.$data1['History_id'].'</td>
					';
					    $owner  = $data1['user_id'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $response .= '<td class="child_1">From: '.$row['first_name'].'</td>';
                        }
					$response .= '
					<td class="child_1">'.$data1['filename'].'</td>
					<td class="child_1">'.$data1['description'].'</td>
					<td class="child_1">'.$data1['files'].'</td>
					<td class="child_1">Assign to: '.$data1['first_name'].'</td>
				</tr>
			';
            //layer 2
			$data1 = $data1['History_id'];
    	    $view_id = $_POST['view_id'];
    	    
    		$sql2 = $conn->query("SELECT * FROM tbl_MyProject_Services_Childs_action_Items 
    		left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
            left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
    		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = '$data1' and Services_History_PK = '$data1' ");
    		
    		while($data2 = $sql2->fetch_array()) {
		    $filesL9 = $data2["CAI_files"];
            $fileExtension = fileExtension($filesL9);
			$src = $fileExtension['src'];
			$embed = $fileExtension['embed'];
			$type = $fileExtension['type'];
			$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
			$response .= '
				<tr>
				    <td>'.$data2['CAI_id'].'</td>';
					    $owner  = $data2['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $response .= '<td class="child_2">From: '.$row['first_name'].'</td>';
                        }
					$response .= '
					<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
					<td class="child_2" style="width:;">'.$data2['CAI_description'].'</td>
					<td class="child_2">
    					<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                    	   <i class="icon-doc" style="font-size:24px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:#0014FF;margin-left:-7px;margin-top:-25;position:;z-index:;"> 1 </span>
            	        </a>
					</td>
					<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
					if($data2['CIA_progress']== 1){ $response .= '<td class="child_2"><b>Inprogress</b></td>'; }
    	            else if($data2['CIA_progress']== 2){ $response .= '<td class="child_2"><b>Completed</b></td>';}
    	            else{ $response .= '<td class="child_2"><b>Not Started</b></td>';}
    	            //rendered time
    	            if(!empty($data2['CAI_Rendered_Minutes'])){
            	        $response .= '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
            	            
            	       if($data2['Service_log_Status'] !=1 && $data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
            	           $response .= ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs('.$data2['CAI_id'].')">Add logs</a>';
            	       }else{
                	       if($data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
            	              $response .= '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Services Added</a></td>';
                	        }
            	       }
            	    }
            	    if($data2['CIA_progress']==2){
	        	        $response .= '<td class="child_2">100%</td>';
	        	    }
					$response .= '
					<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
					<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
					<td class="child_2">
                         <a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$data2['CAI_id'].')">
                            <i class="icon-speech" style="font-size:24px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:#DC3535;margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> 7 </span>
                        </a>
                    </td>
                    <td class="child_2">';
                        $response .= '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child('.$data2['CAI_id'].')">Add</a>';
                        if($data2["CAI_Assign_to"] == 0){
                            $response .= '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item('.$data2['CAI_id'].')">Edit</a>';
                        }
                        if($data2["CAI_Assign_to"] == $_COOKIE['employee_id'] && $data2["Acceptance_Status"] != 2){
                        if($data2['Acceptance_Status'] == 1 && $data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
                            $response .= '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item('.$data2['CAI_id'].')">Edit</a>';
                        } else if($data2["CAI_User_PK"] == $_COOKIE['ID']){
                            $response .= '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item('.$data2['CAI_id'].')">Edit</a>';
                        }else{
                            $response .= '<a style="font-weight:800;color:#fff;" href="#modalGet_Accept_status" data-toggle="modal" class="btn green btn-xs" onclick="btn_Accept_status('.$data2['CAI_id'].')">View</a>';
                        }
                        }
                        $response .= '
                    </td>
				</tr>
			';
			//layer 3
			$data2 = $data2['CAI_id'];
    	    $view_id = $_POST['view_id'];
    	    
    		$sql3 = $conn->query("SELECT * FROM tbl_MyProject_Services_Childs_action_Items 
    		left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
            left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
    		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = '$data2' ");
    		
    		while($data3 = $sql3->fetch_array()) {
		    $filesL9 = $data3["CAI_files"];
            $fileExtension = fileExtension($filesL9);
			$src = $fileExtension['src'];
			$embed = $fileExtension['embed'];
			$type = $fileExtension['type'];
			$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
			$response .= '
				<tr>
				    <td>'.$data3['CAI_id'].'</td>
				    <td></td>';
					    $owner  = $data3['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $response .= '<td class="child_2">From: '.$row['first_name'].'</td>';
                        }
					$response .= '
					<td class="child_2" style="width:;">'.$data3['CAI_filename'].'</td>
					<td class="child_2" style="width:;">'.$data3['CAI_description'].'</td>
					<td class="child_2">
    					<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                    	   <i class="fa fa-file-o" style="font-size:24px;color:#fff;padding:10px;"></i>
            	        </a>
					</td>
					<td class="child_2">Assign to: '.$data3['first_name'].'</td>';
					if($data3['CIA_progress']== 1){ $response .= '<td class="child_2"><b>Inprogress</b></td>'; }
    	            else if($data3['CIA_progress']== 2){ $response .= '<td class="child_2"><b>Completed</b></td>';}
    	            else{ $response .= '<td class="child_2"><b>Not Started</b></td>';}
    	            //rendered time
    	            if(!empty($data3['CAI_Rendered_Minutes'])){
            	        $response .= '<td class="child_2">Rendered: '.$data3['CAI_Rendered_Minutes'].' minute(s)';
            	            
            	       if($data3['Service_log_Status'] !=1 && $data3["CAI_Assign_to"] == $_COOKIE['employee_id']){
            	           $response .= ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs('.$data3['CAI_id'].')">Add logs</a>';
            	       }else{
                	       if($data3["CAI_Assign_to"] == $_COOKIE['employee_id']){
            	              $response .= '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Services Added</a></td>';
                	        }
            	       }
            	    }
            	    if($data3['CIA_progress']==2){
	        	        $response .= '<td class="child_2">100%</td>';
	        	    }
					$response .= '
					<td class="child_2">Start: '.date("Y-m-d", strtotime($data3['CAI_Action_date'])).'</td>
					<td class="child_2">Due: '.date("Y-m-d", strtotime($data3['CAI_Action_due_date'])).'</td>
					<td class="child_2">
                        <a style="font-weight:800;color:#fff;" href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$data3['CAI_id'].')">
                            <i class="fa fa-comments-o" style="font-size:24px;color:#fff;padding:10px;"></i>
                        </a>
                    </td>
                    <td class="child_2">';
                        $response .= '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child('.$data3['CAI_id'].')">Add</a>';
                        if($data3["CAI_Assign_to"] == 0){
                            $response .= '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item('.$data3['CAI_id'].')">Edit</a>';
                        }
                        if($data3["CAI_Assign_to"] == $_COOKIE['employee_id'] && $data3["Acceptance_Status"] != 2){
                        if($data3['Acceptance_Status'] == 1 && $data3["CAI_Assign_to"] == $_COOKIE['employee_id']){
                            $response .= '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item('.$data3['CAI_id'].')">Edit</a>';
                        } else if($data3["CAI_User_PK"] == $_COOKIE['ID']){
                            $response .= '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item('.$data3['CAI_id'].')">Edit</a>';
                        }else{
                            $response .= '<a style="font-weight:800;color:#fff;" href="#modalGet_Accept_status" data-toggle="modal" class="btn green btn-xs" onclick="btn_Accept_status('.$data3['CAI_id'].')">View</a>';
                        }
                        }
                        $response .= '
                    </td>
				</tr>
			';
    		}
    		}
		}
	}
	exit($response);
}
	
?>