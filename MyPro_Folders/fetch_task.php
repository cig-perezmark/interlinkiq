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
if (!empty($_COOKIE['switchAccount'])) {
	$portal_user = $_COOKIE['ID'];
	$user_id = $_COOKIE['switchAccount'];
}
else {
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
}
function employerID($ID) {
	global $conn;

	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $ID" );
    $rowUser = mysqli_fetch_array($selectUser);
    $current_userEmployeeID = $rowUser['employee_id'];

    $current_userEmployerID = $ID;
    if ($current_userEmployeeID > 0) {
        $selectEmployer = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID" );
        if ( mysqli_num_rows($selectEmployer) > 0 ) {
            $rowEmployer = mysqli_fetch_array($selectEmployer);
            $current_userEmployerID = $rowEmployer["user_id"];
        }
    }

    return $current_userEmployerID;
}

if (isset($_POST['key'])) {
	$response = "";

	if ($_POST['key'] == 'ids') {
	    $view_id = $_POST['view_id'];
		$sql = $conn->query("SELECT *,tbl_MyProject_Services_History.user_id as owner FROM tbl_MyProject_Services_History left join tbl_MyProject_Services_Action_Items on Action_Items_id = Action_taken
         left join tbl_hr_employee on Assign_to_history = ID left join tbl_user on employee_id = tbl_hr_employee.ID where MyPro_PK = $view_id");
        //  $i = 0;
		while($data1 = $sql->fetch_array()) {
		    $files_p = $data1["files"];
            $fileExtension = fileExtension($files_p);
    		$src = $fileExtension['src'];
    		$embed = $fileExtension['embed'];
    		$type = $fileExtension['type'];
    		$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
			$response .= '
            <div id="center_'.$data1['History_id'].'"></div>
			<div class="panel-group accordion " id="accordion1" style="width:100%;">
                <div class="panel panel">
                    <div class="panel-heading" style="background-color:#F5F5F5;color:black;padding: 5px 15px !important;" >
                           <div class="row">
                                 <div class="col-md-9">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#'.$data1['History_id'].'"> 
                                    	<table class="table table-resposive"  style="font-size:13px;margin-bottom: 0px !important;">
                                    	    <tbody>
                                    	        <tr onclick="view_more('.$data1['History_id'].')" id="parents_'.$data1['History_id'].'">
                                					<th class="child_1" width="80px">'.$data1['History_id'].'</th>
                                					';
                                					    $owner  = $data1['owner'];
                                                        $query = "SELECT * FROM tbl_user where ID = '$owner'";
                                                        $result = mysqli_query($conn, $query);
                                                        while($row = mysqli_fetch_array($result)){ 
                                                            $response .= '<th class="child_1">From: '.$row['first_name'].'</th>';
                                                        }
                                					$response .= '
                                					<th class="child_1">'.$data1['filename'].'</th>
                                					<th class="child_1" style="width:20%;">';
                                					$stringProduct = strip_tags($data1['description']); 
                                                       if(strlen($stringProduct) > 76):
                                                           $stringCut = substr($stringProduct,0,76);
                                                           $endPoint = strrpos($stringCut,' ');
                                                           $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                                                           $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail" data-toggle="modal" onclick="get_moreDetails('.$data1['History_id'].')">
                                                           <i style="color:black;">See more...</i></a>';
                                                       endif;
                                                       $response .= "$stringProduct";
                                                       $response .= '
                                					</th>
                                					<th class="child_1">Account: '.$data1['h_accounts'].'</th>
                                					<th class="child_1">Assigned to: '.$data1['first_name'].'</th>
                                					<th class="child_1">'.$data1['Action_Items_name'].'</th>
                                					<th class="child_1">Due Date: '.date("Y-m-d", strtotime($data1['Action_date'])).'</th>
                                					<th class="child_1" width="5%">
                                					    ';
                                                            if (!empty($files_p))
                                            			     {
                                            			         $response .= '
                                            			            <a style="color:;" data-src="'.$src.$url.rawurlencode($files_p).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                                                	   <i class="icon-doc" style="font-size:18px;color:;margin-left:12px;"></i>
                                                                        <span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
                                                        	        </a>
                                                        	    ';
                                            			     }
                                            			     else
                                            			     {
                                            			         $response .= '
                                            			            <a style="color:;" data-src="'.$src.$url.rawurlencode($files_p).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                                                	   <i class="icon-doc" style="font-size:18px;color:;margin-left:12px;"></i>
                                                                        <span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
                                                        	        </a>
                                            			         ';
                                            			     }
                                            			  $response .= '
                                					</th>
                                					<th>
                                					    
                                					</th>
                                				</tr>
                                    	    </tbody>
                                    	</table>
                                    </a>
                                </div>
                                <div class="col-md-3">';
                                    $id_st = $data1['History_id'];
                                    $ck = $_COOKIE['employee_id'];
                                    $counter = 1;
                                    $counter_result = 0;
                                    $MyTask = '';
                                    $h_id = '';
                                    $ptc = '';
                                    
                                	$sql__MyTask = $conn->query("SELECT * FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and CAI_Assign_to = $ck ");
                                		while($data_MyTask = $sql__MyTask->fetch_array()) {
                                		    $MyTask = $data_MyTask['CAI_Assign_to'];
                                		    $h_id = $data_MyTask['Services_History_PK'];
                                		    $counter_result = $counter++;
                                		    
                                		}
                                		
                                		$view_id = $_POST['view_id'];
                                		$sql_counter = $conn->query("SELECT COUNT(*) as counter FROM tbl_MyProject_Services_Childs_action_Items where Parent_MyPro_PK = '$view_id'");
                                		while($data_counter = $sql_counter->fetch_array()) {
                                		       $count_result = $data_counter['counter'];
                                		}
                                	    $sql_compliance = $conn->query("SELECT COUNT(*) as compliance FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress = 2");
                                		while($data_compliance = $sql_compliance->fetch_array()) {
                                		       $comp = $data_compliance['compliance'];
                                		}
                                		$sql_none_compliance = $conn->query("SELECT COUNT(*) as non_comp FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress != 2");
                                		while($data_none_compliance = $sql_none_compliance->fetch_array()) {
                                		       $non = $data_none_compliance['non_comp'];
                                		}
                                		$ptc = 0;
                                 		if( !empty($comp) && !empty($non) ){ 
                                 		    $percent = $comp / $count_result;
                                	        $ptc = number_format($percent * 100, 2) . '%';
                                 		}
                                 		else if(empty($non) && !empty($comp)){ $ptc = '100%';}
                                 		else{ $ptc = '0%';}
                                 		
                                		
                                    $response .= '<a style="font-size:14px;"  class="btn dark btn-xs btn-outline" onclick="get_myTask('.$MyTask.','.$h_id.')">My Task('; if(!empty($counter_result)){$response .= $counter_result; }else{$response .= 0;} $response .= ')</a>
                                    <a style="font-size:14px;"  class="btn dark btn-xs btn-outline">Compliance('; $response .= $ptc; $response .= ')</a>';
                                    $response .= '
                                    <a style="font-size:14px;" href="#modalGetHistory" data-toggle="modal" class="btn blue btn-xs btn-outline" onclick="btnNew_History('.$data1['History_id'].','.$data1['History_id'].')">Add</a>
                                    <a style="font-size:14px;" href="#modalGet_parent" data-toggle="modal" class="btn red btn-xs btn-outline" onclick="onclick_parent('.$data1['History_id'].')">Edit</a>
                                </div>
                           </div>
                    </div>
                    <div id="'.$data1['History_id'].'" class="panel-collapse collapse" >
                            <div class="panel-body" style="max-width: 84vw;max-height: 65vh;overflow: scroll;" >
                                <table class="" id="main_" style=" width: 100%;font-size:12px;">
                                    <tbody id="data_child'.$data1['History_id'].'" >
                                    <tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
			<table style=" width: 100%;font-size:12px;">';
			    $id_s = $data1['History_id'];
            	$sql_s = $conn->query("SELECT * FROM tbl_MyProject_Services_Childs_action_Items 
        		left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
        		where Services_History_PK = '$id_s' ");
            		while($data_search = $sql_s->fetch_array()) {
            		  $response .= '<tbody id="hide_box">
            		    <tr id="searched_data'.$data_search['CAI_id'].'"></tr>
                        <tbody>';
                }
			    $response .='
            </table>
            <table style=" width: 100%;font-size:12px;">
                <tbody id="main_task">
                    <tr id="my_task_'.$data1['History_id'].'"></tr>
            	<tbody>
            </table>
			';
		}
	}
	
	if($_POST['key'] == 'child_two'){
       //layer 2
		$data1 = $_POST['get_id'];
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
			<tr id="sub_two_'.$data2['CAI_id'].'">
			    <td id="'.$data2['CAI_id'].'" class="child_border" width="50px">'.$data2['CAI_id'].'</td>';
				    $owner  = $data2['CAI_User_PK'];
                    $query = "SELECT * FROM tbl_user where ID = $owner";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result)){ 
                        $response .= '<td class="child_2">From: '.$row['first_name'].'</td>';
                    }
				$response .= '
				<td class="child_2">
				    ';
				    $stringProduct = strip_tags($data2['CAI_filename']); 
                   if(strlen($stringProduct) > 40):
                       $stringCut = substr($stringProduct,0,40);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub2" data-toggle="modal" onclick="get_moreDetails_sub2('.$data2['CAI_id'].')">
                       <i style="color:black;">More...</i></a>';
                   endif;
                   $response .= "$stringProduct";
                   $response .= '
				</td>
				<td class="child_2" >
				';
				    $stringProduct = strip_tags($data2['CAI_description']); 
                   if(strlen($stringProduct) > 35):
                       $stringCut = substr($stringProduct,0,35);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$data2['CAI_id'].')">
                       <i style="color:black;">More...</i></a>';
                   endif;
                   $response .= "$stringProduct";
                   $response .= '
				</td>
			
				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
				<td class="child_2">'.$data2['Action_Items_name'].'</td>
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
        	              $response .= '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
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
					';
                        
                            if (!empty($filesL9))
            			     {
            			         $response .= '
            			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                        <span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
                        	        </a>
                        	    ';
            			     }
            			     else
            			     {
            			         $response .= '
            			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                        <span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
                        	        </a>
            			         ';
            			     }
            			  $response .= '   
                        
    				</td>
    				<td class="child_2" style="min-width:80px;">
    				';
                    $_comment  = $data2['CAI_id'];
                    $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                    $result_comment = mysqli_query($conn, $query_comment);
                    while($row_comment = mysqli_fetch_array($result_comment)){ 
                        $response .= '
                        <a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$data2['CAI_id'].')">
                        <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="margin-left:-7px;background-color:'; if($row_comment['count'] == 0){$response .= '#DC3535';}else{$response .= 'blue';}  $response .= ';">
                                <b>'.$row_comment['count'].'</b>
                            </span>
                        </a>
                        ';
                    }
                  $response .= '  
                </td>
                
                <td class="child_2" style="min-width:100px;">';
                    $response .= '<a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGetHistory_Child2" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$data2['CAI_id'].')">Add</a>';
                    $response .= '<a style="font-weight:800;color:#fff;" href="#modalGet_child2" data-toggle="modal" class="btn red btn-xs" onclick="onclick_2('.$data2['CAI_id'].')">Edit</a>';
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
		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = '$data2'");
		
		while($data3 = $sql3->fetch_array()) {
	    $filesL9 = $data3["CAI_files"];
        $fileExtension = fileExtension($filesL9);
		$src = $fileExtension['src'];
		$embed = $fileExtension['embed'];
		$type = $fileExtension['type'];
		$file_extension = $fileExtension['file_extension'];
        $url = $base_url.'../MyPro_Folder_Files/';
		$response .= '
			<tr id="sub_three_main'.$data3['CAI_id'].'">
			    <td  class="child_border" width="50px">'.$data3['CAI_id'].'</td>
			    <td class="child_border" width="80px"></td>';
				    $owner  = $data3['CAI_User_PK'];
                    $query = "SELECT * FROM tbl_user where ID = $owner";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result)){ 
                        $response .= '<td class="child_2">From: '.$row['first_name'].'</td>';
                    }
				$response .= '
				<td class="child_2" style="width:;">
				    ';
				    $stringProduct = strip_tags($data3['CAI_filename']); 
                   if(strlen($stringProduct) > 40):
                       $stringCut = substr($stringProduct,0,40);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub3" data-toggle="modal" onclick="get_moreDetails_sub3('.$data3['CAI_id'].')">
                       <i style="color:black;">More...</i></a>';
                   endif;
                   $response .= "$stringProduct";
                   $response .= '
				</td>
				<td class="child_2" style="width:;">
				';
				    $stringProduct = strip_tags($data3['CAI_description']); 
                   if(strlen($stringProduct) > 35):
                       $stringCut = substr($stringProduct,0,35);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail3" data-toggle="modal" onclick="get_moreDetails3('.$data3['CAI_id'].')">
                       <i style="color:black;">More...</i></a>';
                   endif;
                   $response .= "$stringProduct";
                   $response .= '
                   </td>
				<td class="child_2">'.$data3['CAI_Accounts'].'</td>
				<td class="child_2">'.$data3['Action_Items_name'].'</td>
				<td class="child_2">Assign to: '.$data3['first_name'].'</td>';
				if($data3['CIA_progress']== 1){ $response .= '<td class="child_2"><b>Inprogress</b></td>'; }
	            else if($data3['CIA_progress']== 2){ $response .= '<td class="child_2"><b>Completed</b></td>';}
	            else{ $response .= '<td class="child_2"><b>Not Started</b></td>';}
	            //rendered time
	            if(!empty($data3['CAI_Rendered_Minutes'])){
        	        $response .= '<td class="child_2">Rendered: '.$data3['CAI_Rendered_Minutes'].' minute(s)';
        	            
        	       if($data3['Service_log_Status'] !=1 && $data3["CAI_Assign_to"] == $_COOKIE['employee_id']){
        	           $response .= ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs3" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs3('.$data3['CAI_id'].')">Add logs</a>';
        	       }else{
            	       if($data3["CAI_Assign_to"] == $_COOKIE['employee_id']){
        	              $response .= '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
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
					';
                        
                            if (!empty($filesL9))
            			     {
            			         $response .= '
            			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                        <span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
                        	        </a>
                        	    ';
            			     }
            			     else
            			     {
            			         $response .= '
            			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                        <span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
                        	        </a>
            			         ';
            			     }
            			  $response .= '   
                        
				</td>
				<td class="child_2">
				';
                    $_comment  = $data3['CAI_id'];
                    $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                    $result_comment = mysqli_query($conn, $query_comment);
                    while($row_comment = mysqli_fetch_array($result_comment)){ 
                        $response .= '
                        <a href="#modalGet_Comments3" data-toggle="modal" onclick="btn_Comments3('.$data3['CAI_id'].')">
                        <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'; if($row_comment['count'] == 0){$response .= '#DC3535';}else{$response .= 'blue';}  $response .= ';margin-left:-7px;">
                                <b>'.$row_comment['count'].'</b>
                            </span>
                        </a>
                        ';
                    }
                  $response .= '  
                </td>
                <td class="child_2" style="min-width:100px;">';
                    $response .= '<a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGetHistory_Child3" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child3('.$data3['CAI_id'].')">Add</a>';
                    $response .= '<a style="font-weight:800;color:#fff;" href="#modalGet_child3" data-toggle="modal" class="btn red btn-xs" onclick="onclick_3('.$data3['CAI_id'].')">Edit</a>';
                    $response .= '
                </td>
			</tr>
		';
		//layer 4
		$data3 = $data3['CAI_id'];
	    $view_id = $_POST['view_id'];
	    
		$sql4 = $conn->query("SELECT * FROM tbl_MyProject_Services_Childs_action_Items 
		left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
        left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = '$data3'");
		
		while($data4 = $sql4->fetch_array()) {
	    $filesL9 = $data4["CAI_files"];
        $fileExtension = fileExtension($filesL9);
		$src = $fileExtension['src'];
		$embed = $fileExtension['embed'];
		$type = $fileExtension['type'];
		$file_extension = $fileExtension['file_extension'];
        $url = $base_url.'../MyPro_Folder_Files/';
		$response .= '
			<tr id="sub_four_'.$data4['CAI_id'].'">
			    <td class="child_border" width="50px">'.$data4['CAI_id'].'</td>
			    <td class="child_border" width="80px"></td>
			    <td class="child_border" ></td>';
				    $owner  = $data4['CAI_User_PK'];
                    $query = "SELECT * FROM tbl_user where ID = $owner";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result)){ 
                        $response .= '<td class="child_2">From: '.$row['first_name'].'</td>';
                    }
				$response .= '
				<td class="child_2" style="width:;">
				    ';
				    $stringProduct = strip_tags($data4['CAI_filename']); 
                   if(strlen($stringProduct) > 40):
                       $stringCut = substr($stringProduct,0,40);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub4" data-toggle="modal" onclick="get_moreDetails_sub4('.$data4['CAI_id'].')">
                       <i style="color:black;">More...</i></a>';
                   endif;
                   $response .= "$stringProduct";
                   $response .= '
				</td>
				<td class="child_2" style="width:;">
				';
				    $stringProduct = strip_tags($data4['CAI_description']); 
                   if(strlen($stringProduct) > 35):
                       $stringCut = substr($stringProduct,0,35);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail4" data-toggle="modal" onclick="get_moreDetails4('.$data4['CAI_id'].')">
                       <i style="color:black;">More...</i></a>';
                   endif;
                   $response .= "$stringProduct";
                   $response .= '
				</td>
				<td class="child_2" >'.$data4['CAI_Accounts'].'</td>
				<td class="child_2">'.$data4['Action_Items_name'].'</td>
				<td class="child_2">Assign to: '.$data4['first_name'].'</td>';
				if($data4['CIA_progress']== 1){ $response .= '<td class="child_2"><b>Inprogress</b></td>'; }
	            else if($data4['CIA_progress']== 2){ $response .= '<td class="child_2"><b>Completed</b></td>';}
	            else{ $response .= '<td class="child_2"><b>Not Started</b></td>';}
	            //rendered time
	            if(!empty($data4['CAI_Rendered_Minutes'])){
        	        $response .= '<td class="child_2">Rendered: '.$data4['CAI_Rendered_Minutes'].' minute(s)';
        	            
        	       if($data4['Service_log_Status'] !=1 && $data4["CAI_Assign_to"] == $_COOKIE['employee_id']){
        	           $response .= ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs4" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs4('.$data4['CAI_id'].')">Add logs</a>';
        	       }else{
            	       if($data4["CAI_Assign_to"] == $_COOKIE['employee_id']){
        	              $response .= '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
            	        }
        	       }
        	    }
        	    if($data4['CIA_progress']==2){
        	        $response .= '<td class="child_2">100%</td>';
        	    }
				$response .= '
				<td class="child_2">Start: '.date("Y-m-d", strtotime($data4['CAI_Action_date'])).'</td>
				<td class="child_2">Due: '.date("Y-m-d", strtotime($data4['CAI_Action_due_date'])).'</td>
				<td class="child_2">
					';
                        
                            if (!empty($filesL9))
            			     {
            			         $response .= '
            			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                        <span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
                        	        </a>
                        	    ';
            			     }
            			     else
            			     {
            			         $response .= '
            			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                        <span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
                        	        </a>
            			         ';
            			     }
            			  $response .= '   
                        
				</td>
				<td class="child_2">
				';
                    $_comment  = $data4['CAI_id'];
                    $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                    $result_comment = mysqli_query($conn, $query_comment);
                    while($row_comment = mysqli_fetch_array($result_comment)){ 
                        $response .= '
                        <a href="#modalGet_Comments4" data-toggle="modal" onclick="btn_Comments4('.$data4['CAI_id'].')">
                        <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'; if($row_comment['count'] == 0){$response .= '#DC3535';}else{$response .= 'blue';}  $response .= ';margin-left:-7px;">
                                <b>'.$row_comment['count'].'</b>
                            </span>
                        </a>
                        ';
                    }
                  $response .= '  
                </td>
                <td class="child_2" style="min-width:100px;">';
                    $response .= '<a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGetHistory_Child4" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child4('.$data4['CAI_id'].')">Add</a>';
                    $response .= '<a style="font-weight:800;color:#fff;" href="#modalGet_child4" data-toggle="modal" class="btn red btn-xs" onclick="onclick_4('.$data4['CAI_id'].')">Edit</a>';
                    $response .= '
                </td>
			</tr>
		';
		    //layer 5
		$data4 = $data4['CAI_id'];
	    $view_id = $_POST['view_id'];
	    
		$sql5 = $conn->query("SELECT * FROM tbl_MyProject_Services_Childs_action_Items 
		left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
        left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = '$data4'");
		
		while($data5 = $sql5->fetch_array()) {
	    $filesL9 = $data5["CAI_files"];
        $fileExtension = fileExtension($filesL9);
		$src = $fileExtension['src'];
		$embed = $fileExtension['embed'];
		$type = $fileExtension['type'];
		$file_extension = $fileExtension['file_extension'];
        $url = $base_url.'../MyPro_Folder_Files/';
		$response .= '
			<tr id="sub_five_'.$data5['CAI_id'].'">
			    <td class="child_border" width="50px">'.$data5['CAI_id'].'</td>
			    <td class="child_border" width="80px"></td>
			    <td class="child_border"></td>
			    <td class="child_border"></td>';
				    $owner  = $data5['CAI_User_PK'];
                    $query = "SELECT * FROM tbl_user where ID = '$owner'";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result)){ 
                        $response .= '<td class="child_2">From: '.$row['first_name'].'</td>';
                    }
				$response .= '
				<td class="child_2" style="width:;">
				    ';
				    $stringProduct = strip_tags($data5['CAI_filename']); 
                   if(strlen($stringProduct) > 40):
                       $stringCut = substr($stringProduct,0,40);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub5" data-toggle="modal" onclick="get_moreDetails_sub5('.$data5['CAI_id'].')">
                       <i style="color:black;">More...</i></a>';
                   endif;
                   $response .= "$stringProduct";
                   $response .= '
				</td>
				<td class="child_2" style="width:;">';
				$stringProduct = strip_tags($data5['CAI_description']); 
                   if(strlen($stringProduct) > 35):
                       $stringCut = substr($stringProduct,0,35);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail5" data-toggle="modal" onclick="get_moreDetails5('.$data5['CAI_id'].')">
                       <i style="color:black;">More...</i></a>';
                   endif;
                   $response .= "$stringProduct";
                   $response .= '
				</td>
				<td class="child_2">'.$data5['CAI_Accounts'].'</td>
				<td class="child_2">'.$data5['Action_Items_name'].'</td>
				<td class="child_2">Assign to: '.$data5['first_name'].'</td>';
				if($data5['CIA_progress']== 1){ $response .= '<td class="child_2"><b>Inprogress</b></td>'; }
	            else if($data5['CIA_progress']== 2){ $response .= '<td class="child_2"><b>Completed</b></td>';}
	            else{ $response .= '<td class="child_2"><b>Not Started</b></td>';}
	            //rendered time
	            if(!empty($data5['CAI_Rendered_Minutes'])){
        	        $response .= '<td class="child_2">Rendered: '.$data5['CAI_Rendered_Minutes'].' minute(s)';
        	            
        	       if($data5['Service_log_Status'] !=1 && $data5["CAI_Assign_to"] == $_COOKIE['employee_id']){
        	           $response .= ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs5" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs5('.$data5['CAI_id'].')">Add logs</a>';
        	       }else{
            	       if($data5["CAI_Assign_to"] == $_COOKIE['employee_id']){
        	              $response .= '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
            	        }
        	       }
        	    }
        	    if($data5['CIA_progress']==2){
        	        $response .= '<td class="child_2">100%</td>';
        	    }
				$response .= '
				<td class="child_2">Start: '.date("Y-m-d", strtotime($data5['CAI_Action_date'])).'</td>
				<td class="child_2">Due: '.date("Y-m-d", strtotime($data5['CAI_Action_due_date'])).'</td>
				<td class="child_2">
					';
                        
                            if (!empty($filesL9))
            			     {
            			         $response .= '
            			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                        <span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
                        	        </a>
                        	    ';
            			     }
            			     else
            			     {
            			         $response .= '
            			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                        <span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
                        	        </a>
            			         ';
            			     }
            			  $response .= '   
                        
				</td>
				<td class="child_2">
				';
                    $_comment  = $data5['CAI_id'];
                    $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                    $result_comment = mysqli_query($conn, $query_comment);
                    while($row_comment = mysqli_fetch_array($result_comment)){ 
                        $response .= '
                        <a href="#modalGet_Comments5" data-toggle="modal" onclick="btn_Comments5('.$data5['CAI_id'].')" >
                        <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'; if($row_comment['count'] == 0){$response .= '#DC3535';}else{$response .= 'blue';}  $response .= ';margin-left:-7px;">
                                <b>'.$row_comment['count'].'</b>
                            </span>
                        </a>
                        ';
                    }
                  $response .= '  
                </td>
                <td class="child_2" style="min-width:100px;">';
                    $response .= '<a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGetHistory_Child5" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child5('.$data5['CAI_id'].')">Add</a>';
                    $response .= '<a style="font-weight:800;color:#fff;" href="#modalGet_child5" data-toggle="modal" class="btn red btn-xs" onclick="onclick_5('.$data5['CAI_id'].')">Edit</a>';
                    $response .= '
                </td>
			</tr>
		';
		   //layer 6
		$data5 = $data5['CAI_id'];
	    $view_id = $_POST['view_id'];
	    
		$sql6 = $conn->query("SELECT * FROM tbl_MyProject_Services_Childs_action_Items 
		left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
        left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = '$data5'");
		
		while($data6 = $sql6->fetch_array()) {
	    $filesL9 = $data6["CAI_files"];
        $fileExtension = fileExtension($filesL9);
		$src = $fileExtension['src'];
		$embed = $fileExtension['embed'];
		$type = $fileExtension['type'];
		$file_extension = $fileExtension['file_extension'];
        $url = $base_url.'../MyPro_Folder_Files/';
		$response .= '
			<tr id="sub_six_'.$data6['CAI_id'].'">
			    <td class="child_border" width="50px">'.$data6['CAI_id'].'</td>
			    <td class="child_border" width="80px"></td>
			    <td class="child_border"></td>
			    <td class="child_border" ></td>
			    <td class="child_border" ></td>';
				    $owner  = $data6['CAI_User_PK'];
                    $query = "SELECT * FROM tbl_user where ID = '$owner'";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result)){ 
                        $response .= '<td class="child_2">From: '.$row['first_name'].'</td>';
                    }
				$response .= '
				<td class="child_2" style="width:;">
				    ';
				    $stringProduct = strip_tags($data6['CAI_filename']); 
                   if(strlen($stringProduct) > 40):
                       $stringCut = substr($stringProduct,0,40);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub6" data-toggle="modal" onclick="get_moreDetails_sub6('.$data6['CAI_id'].')">
                       <i style="color:black;">More...</i></a>';
                   endif;
                   $response .= "$stringProduct";
                   $response .= '
				</td>
				<td class="child_2" style="width:;">
				';
				$stringProduct = strip_tags($data6['CAI_description']); 
                   if(strlen($stringProduct) > 35):
                       $stringCut = substr($stringProduct,0,35);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail6" data-toggle="modal" onclick="get_moreDetails6('.$data6['CAI_id'].')">
                       <i style="color:black;">More...</i></a>';
                   endif;
                   $response .= "$stringProduct";
                   $response .= '
				</td>
				<td class="child_2">'.$data6['CAI_Accounts'].'</td>
				<td class="child_2">'.$data6['Action_Items_name'].'</td>
				<td class="child_2">Assign to: '.$data6['first_name'].'</td>';
				if($data6['CIA_progress']== 1){ $response .= '<td class="child_2"><b>Inprogress</b></td>'; }
	            else if($data6['CIA_progress']== 2){ $response .= '<td class="child_2"><b>Completed</b></td>';}
	            else{ $response .= '<td class="child_2"><b>Not Started</b></td>';}
	            //rendered time
	            if(!empty($data6['CAI_Rendered_Minutes'])){
        	        $response .= '<td class="child_2">Rendered: '.$data6['CAI_Rendered_Minutes'].' minute(s)';
        	            
        	       if($data6['Service_log_Status'] !=1 && $data6["CAI_Assign_to"] == $_COOKIE['employee_id']){
        	           $response .= ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs6" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs6('.$data6['CAI_id'].')">Add logs</a>';
        	       }else{
            	       if($data6["CAI_Assign_to"] == $_COOKIE['employee_id']){
        	              $response .= '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
            	        }
        	       }
        	    }
        	    if($data6['CIA_progress']==2){
        	        $response .= '<td class="child_2">100%</td>';
        	    }
				$response .= '
				<td class="child_2">Start: '.date("Y-m-d", strtotime($data6['CAI_Action_date'])).'</td>
				<td class="child_2">Due: '.date("Y-m-d", strtotime($data6['CAI_Action_due_date'])).'</td>
				<td class="child_2">
					';
                        
                            if (!empty($filesL9))
            			     {
            			         $response .= '
            			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                        <span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
                        	        </a>
                        	    ';
            			     }
            			     else
            			     {
            			         $response .= '
            			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                        <span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
                        	        </a>
            			         ';
            			     }
            			  $response .= '   
                        
				</td>
				<td class="child_2">
				';
                    $_comment  = $data6['CAI_id'];
                    $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                    $result_comment = mysqli_query($conn, $query_comment);
                    while($row_comment = mysqli_fetch_array($result_comment)){ 
                        $response .= '
                        <a href="#modalGet_Comments6" data-toggle="modal" onclick="btn_Comments6('.$data6['CAI_id'].')">
                        <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'; if($row_comment['count'] == 0){$response .= '#DC3535';}else{$response .= 'blue';}  $response .= ';margin-left:-7px;">
                                <b>'.$row_comment['count'].'</b>
                            </span>
                        </a>
                        ';
                    }
                  $response .= '  
                </td>
                <td class="child_2" style="min-width:100px;">';
                    $response .= '<a style="font-weight:800;color:#fff;" href="#modalGet_child6" data-toggle="modal" class="btn red btn-xs" onclick="onclick_6('.$data6['CAI_id'].')">Edit</a>';
                    $response .= '
                </td>
			</tr>
		';
		}
		}
			
		}
			
		}
			
		}
	}
	exit($response);
}


	// modal Get Status
if( isset($_GET['modal_filter_status']) ) {
	$ID = $_GET['modal_filter_status'];
    ?>
	<input class="form-control" type="hidden" name="ID" value="<?= $ID; ?>'" />
	 <?php if($_COOKIE['ID'] == 38): ?>
       <div class="col-md-12">
           <div class="form-group">
                <a style="float:right;" class="btn red btn-xs" type="button" id="pdf_report_notstarted" data-id="<?= $ID; ?>"><i class="fa fa-print"></i> PDF</a>
           </div>
       </div>
    <?php endif; ?>
        <table class="table table-bordered " id="tableData22">
            <thead class="bg-info">
                <tr>
                    <th>Assign to</th>
                    <th>Task Name</th>
                    <th>Description</th>
                    <th>Desired Due Date</th>
                </tr>
            </thead>
             <tbody>
                 <?php
                    $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where is_deleted=0 and CIA_progress = 0 and Parent_MyPro_PK = $ID order by CAI_id DESC";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result))
                     { ?>
                            <tr>
                            <td>
                                <?php
                                    $emp_id =$row['CAI_Assign_to'];
                                    $query_emp = "SELECT * FROM tbl_hr_employee where ID = $emp_id";
                                    $result_emp = mysqli_query($conn, $query_emp);
                                    while($row_emp = mysqli_fetch_array($result_emp))
                                     {
                                         echo $row_emp['first_name'];
                                     }
                                ?>
                                </td>
                                <td><?= $row['CAI_filename']; ?></td>
                                <td><?= $row['CAI_description']; ?></td>
                                <td><?= $row['CAI_Action_due_date']; ?></td>
                            </tr>
                    <?php }
                 ?>
            </tbody>
         </table>
         
   <?php }
    
if( isset($_GET['modal_filter_status_progress']) ) {
	$ID = $_GET['modal_filter_status_progress'];
?>
	<input class="form-control" type="hidden" name="ID" value="<?= $ID; ?>" />
	 <?php if($_COOKIE['ID'] == 38): ?>
       <div class="col-md-12">
           <div class="form-group">
                <a style="float:right;" class="btn red btn-xs" type="button" id="pdf_report_inprogress" data-id="<?= $ID; ?>"><i class="fa fa-print"></i> PDF</a>
           </div>
       </div>
    <?php endif; ?>
        <table class="table table-bordered " id="sample_11">
            <thead class="bg-info">
                <tr>
                    <th>Assign to</th>
                    <th>Task Name</th>
                    <th>Description</th>
                    <th>Due Date</th>
                </tr>
            </thead>
             <tbody>
                 <?php
                    $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where is_deleted=0 and CIA_progress = 1 and Parent_MyPro_PK = $ID order by CAI_Action_due_date ASC";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result))
                     { ?>
                            <tr>
                                <td>
                                <?php 
                                    $emp_id =$row['CAI_Assign_to'];
                                    $query_emp = "SELECT * FROM tbl_hr_employee where ID = $emp_id";
                                    $result_emp = mysqli_query($conn, $query_emp);
                                    while($row_emp = mysqli_fetch_array($result_emp))
                                     {
                                         echo $row_emp['first_name'];
                                     }
                                ?>
                                </td>
                                <td><?= $row['CAI_filename']; ?></td>
                                <td><?= $row['CAI_description']; ?></td>
                                <td><?= $row['CAI_Action_due_date']; ?></td>
                            </tr>
                   <?php  }
                ?>
            </tbody>
         </table>
         
  <?php  }

if( isset($_GET['modal_filter_status_completed']) ) {
$ID = $_GET['modal_filter_status_completed'];
?>
<input class="form-control" type="hidden" name="ID" value="<?= $ID; ?>" />
    <?php if($_COOKIE['ID'] == 38): ?>
       <div class="col-md-12">
           <div class="form-group">
                <a style="float:right;" class="btn red btn-xs" type="button" id="pdf_report_completed" data-id="<?= $ID; ?>"><i class="fa fa-print"></i> PDF</a>
           </div>
       </div>
    <?php endif; ?>
    <table class="table table-bordered " id="sample_44">
        <thead class="bg-info">
            <tr>
                <th>Assign to</th>
                <th>Task Name</th>
                <th>Description</th>
                <th>Date Completed</th>
            </tr>
        </thead>
         <tbody>
             <?php
                $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where is_deleted=0 and CIA_progress = 2 and Parent_MyPro_PK = $ID order by Date_Completed DESC";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result))
                 { ?>

                        <tr>
                            <td>
                                <?php
                                    $emp_id =$row['CAI_Assign_to'];
                                    $query_emp = "SELECT * FROM tbl_hr_employee where ID = $emp_id";
                                    $result_emp = mysqli_query($conn, $query_emp);
                                    while($row_emp = mysqli_fetch_array($result_emp))
                                     {
                                         echo $row_emp['first_name'];
                                     }
                                ?>
                                </td>
                            <td><?= $row['CAI_filename']; ?></td>
                            <td><?= $row['CAI_description']; ?></td>
                            <td><?= $row['Date_Completed']; ?></td>
                        </tr>
                <?php }
             ?>
        </tbody>
     </table>
     
<?php }

// add new parent
if( isset($_GET['modalNew_File']) ) {
	$ID = $_GET['modalNew_File'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="project_id" value="'. $ID .'" />
	    ';
	        $query_proj = "SELECT * FROM tbl_MyProject_Services where MyPro_id = $ID";
            $result_proj = mysqli_query($conn, $query_proj);
            while($row_proj = mysqli_fetch_array($result_proj))
            { 
             
	    echo'
        <div class="form-group">
            <div class="col-md-12">
                <label>Task Name</label>
            </div>
            <div class="col-md-12">
                <input class="form-control" type="text" name="filename" required />
            </div>
        </div>
    	<div class="form-group">
    	    <div class="col-md-12">
                <label>Supporting File</label>
            </div>
            <div class="col-md-12">
                <input class="form-control" type="file" name="file">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label>Action Items</label>
                 <select class="form-control mt-multiselect btn btn-default" type="text" name="Action_taken" required>
                    <option value="">---Select---</option>
                    ';
                        $queryType = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
                    $resultType = mysqli_query($conn, $queryType);
                    while($rowType = mysqli_fetch_array($resultType))
                         { 
                           echo '<option value="'.$rowType['Action_Items_id'].'" >'.$rowType['Action_Items_name'].'</option>'; 
                       } 
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
            <div class="col-md-6">
                <label>Account</label>
                <select class="form-control mt-multiselect btn btn-default" type="text" name="h_accounts" required>
                    <option value="">---Select---</option>
                    ';
                        if($user_id == 34){
                            $query_accounts = "SELECT * FROM tbl_service_logs_accounts order by name ASC";
                            $result_accounts = mysqli_query($conn, $query_accounts);
                            while($row_accounts = mysqli_fetch_array($result_accounts))
                                 { 
                                   echo '<option value="'.$row_accounts['name'].'" '; echo $row_proj['Accounts_PK'] == $row_accounts['name'] ? 'selected':''; echo'>'.$row_accounts['name'].'</option>'; 
                               } 
                        }
                        else if($user_id == 247){ echo '<option value="SFI">SFI</option>';}
                        else if($user_id == 266){ echo '<option value="RFP">RFP</option>';}
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label>Description</label>
            </div>
            <div class="col-md-12">
                <textarea class="form-control" name="description" required></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label>Estimated Time (minutes)</label>
                <input class="form-control" type="number" name="Estimated_Time" value="0" required />
            </div>
            <div class="col-md-6">
                <label>Desired Due Date</label>
                <input class="form-control" type="date" name="Action_date" value="'.date("Y-m-d", strtotime(date("Y/m/d"))).'" required />
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label>Assign to</label>
            </div>
            <div class="col-md-12">
                <select class="form-control mt-multiselect btn btn-default" type="text" name="Assign_to_history" required>
                    <option value="">---Select---</option>
                    ';
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { 
                           echo '<option value="'.$rowAssignto['ID'].'" >'.$rowAssignto['first_name'].'</option>'; 
                       }
                       
                        $queryQuest = "SELECT * FROM tbl_user where ID = 155 and ID = 308 and ID = 189";
                    $resultQuest = mysqli_query($conn, $queryQuest);
                    while($rowQuest = mysqli_fetch_array($resultQuest))
                         { 
                           echo '<option value="'.$rowQuest['ID'].'" >'.$rowQuest['first_name'].'</option>'; 
                       }
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
        </div>';
    }
}
if( isset($_POST['btnSave_History']) ) {
	
    $user_id = $_COOKIE['ID'];
	$ID = $_POST['ID'];
	$filename = mysqli_real_escape_string($conn,$_POST['filename']);
	$description = mysqli_real_escape_string($conn,$_POST['description']);
	$h_accounts = mysqli_real_escape_string($conn,$_POST['h_accounts']);
	$Estimated_Time = $_POST['Estimated_Time'];
	$Assign_to_history = $_POST['Assign_to_history'];
	$Action_taken = $_POST['Action_taken'];
	$Action_date = $_POST['Action_date'];
	$rand_id = rand(10,1000000);
    
    $to_Db_files = "";
	$files = $_FILES['file']['name'];
	if (!empty($files)) {
		$path = '../MyPro_Folder_Files/';
		$tmp = $_FILES['file']['tmp_name'];
		$files = rand(1000,1000000) . ' - ' . $files;
		$to_Db_files = mysqli_real_escape_string($conn,$files);
		$path = $path.$files;
		move_uploaded_file($tmp,$path);
	}

	$sql = "INSERT INTO tbl_MyProject_Services_History (user_id,MyPro_PK,files, filename, description,Estimated_Time,Action_taken,Action_date,Assign_to_history,Services_History_Status,rand_id,h_accounts)
	VALUES ('$user_id','$ID', '$to_Db_files', '$filename', '$description','$Estimated_Time','$Action_taken','$Action_date','$Assign_to_history',1,'$rand_id','$h_accounts')";
	
	if (mysqli_query($conn, $sql)) {
		$last_id = mysqli_insert_id($conn);

		$selectData = mysqli_query( $conn,'SELECT *,tbl_MyProject_Services_History.user_id as owner FROM tbl_MyProject_Services_History left join tbl_MyProject_Services_Action_Items on Action_Items_id = Action_taken
			                left join tbl_hr_employee on Assign_to_history = ID WHERE  History_id="'. $last_id .'" ORDER BY History_id LIMIT 1' );
		if ( mysqli_num_rows($selectData) > 0 ) {
			$rowData = mysqli_fetch_array($selectData);
			$data_ID = $rowData['History_id'];
			$data_filename = $rowData['filename'];
			$data_description = $rowData['description'];
			$Action_Items_name = $rowData['Action_Items_name'];
			$first_name = $rowData['first_name'];
			$first_name = $rowData['first_name'];
			$h_accounts = $rowData['h_accounts'];

			    $data_files = $rowData['files'];
	            $fileExtension = fileExtension($data_files);
				$src = $fileExtension['src'];
				$embed = $fileExtension['embed'];
				$type = $fileExtension['type'];
				$file_extension = $fileExtension['file_extension'];
	            $url = $base_url.'MyPro_Folder_Files/';

			$Action_date = $rowData['Action_date'];
            $Action_date = new DateTime($Action_date);
            $Action_date = $Action_date->format('M d, Y');
            
            echo'
           	<div class="panel-group accordion " id="accordion1" style="">
                <div class="panel panel" >
                    <div class="panel-heading bg-primary" style="background-color:#f5f5f5;color:;" >
                           <div class="row">
                                 <div class="col-md-9">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#'.$rowData['History_id'].'"> 
                                    	<table style="table-layout: fixed; width: 100%;font-size:13px;">
                                    	    <tbody>
                                    	        <tr onclick="view_more('.$rowData['History_id'].')">
                                					<th class="child_1" width="80px">'.$rowData['History_id'].'</th>
                                					';
                                					    $owner  = $rowData['owner'];
                                                        $query = "SELECT * FROM tbl_user where ID = '$owner'";
                                                        $result = mysqli_query($conn, $query);
                                                        while($row = mysqli_fetch_array($result)){ 
                                                            echo '<th class="child_1">From: '.$row['first_name'].'</th>';
                                                        }
                                					echo '
                                					<th class="child_1">'.$rowData['filename'].'</th>
                                					<th class="child_1" width="20%">';
                                					$stringProduct = strip_tags($rowData['description']); 
                                                       if(strlen($stringProduct) > 76):
                                                           $stringCut = substr($stringProduct,0,76);
                                                           $endPoint = strrpos($stringCut,' ');
                                                           $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                                                           $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail" data-toggle="modal" onclick="get_moreDetails('.$data1['History_id'].')">
                                                           <i style="color:black;">See more...</i></a>';
                                                       endif;
                                                       echo $stringProduct;
                                                       echo '</th>
                                					
                                					<th class="child_1">Account: '.$rowData['h_accounts'].'</th>
                                					<th class="child_1">Assign to: '.$rowData['first_name'].'</th>
                                					<th class="child_1">'.$rowData['Action_Items_name'].'</th>
                                					<th class="child_1">Desired Date: '.date("Y-m-d", strtotime($rowData['Action_date'])).'</th>
                                					<th class="child_1" width="5%">';
                                    					if (!empty($data_files))
                                                			     {
                                                			         echo '
                                                			            <a style="color:;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                                                    	   <i class="icon-doc" style="font-size:18px;color:;margin-left:12px;"></i>
                                                                            <span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
                                                            	        </a>
                                                            	    ';
                                                			     }
                                                			     else
                                                			     {
                                                			         echo '
                                                			            <a style="color:;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                                                    	   <i class="icon-doc" style="font-size:18px;color:;margin-left:12px;"></i>
                                                                            <span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
                                                            	        </a>
                                                			         ';
                                                			     }
                                					
                                					echo'</th>
                                					<th>
                                					    
                                					</th>
                                				</tr>
                                    	    </tbody>
                                    	</table>
                                    </a>
                                </div>
                                <div class="col-md-3">';
                                 $id_st = $rowData['History_id'];
                                    $ck = $_COOKIE['employee_id'];
                                    $counter = 1;
                                    $counter_result = 0;
                                	$sql__MyTask = $conn->query("SELECT * FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and CAI_Assign_to = $ck ");
                                		while($data_MyTask = $sql__MyTask->fetch_array()) {
                                		    $MyTask = $data_MyTask['CAI_Assign_to'];
                                		    $h_id = $data_MyTask['Services_History_PK'];
                                		    $counter_result = $counter++;
                                		    
                                		}
                                		
                                		$view_id = $rowData['MyPro_PK'];
                                		$sql_counter = $conn->query("SELECT COUNT(*) as counter FROM tbl_MyProject_Services_Childs_action_Items where Parent_MyPro_PK = '$view_id'");
                                		while($data_counter = $sql_counter->fetch_array()) {
                                		       $count_result = $data_counter['counter'];
                                		}
                                	    $sql_compliance = $conn->query("SELECT COUNT(*) as compliance FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress = 2");
                                		while($data_compliance = $sql_compliance->fetch_array()) {
                                		       $comp = $data_compliance['compliance'];
                                		}
                                		$sql_none_compliance = $conn->query("SELECT COUNT(*) as non_comp FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress != 2");
                                		while($data_none_compliance = $sql_none_compliance->fetch_array()) {
                                		       $non = $data_none_compliance['non_comp'];
                                		}
                                		$ptc = 0;
                                 		if( !empty($comp) && !empty($non) ){ 
                                 		    $percent = $comp / $count_result;
                                	        $ptc = number_format($percent * 100, 2) . '%';
                                 		}
                                 		else if(empty($non) && !empty($comp)){ $ptc = '100%';}
                                 		else{ $ptc = '0%';}
                                 		
                                		
                                    echo '<a style="font-size:14px;"  class="btn dark btn-xs btn-outline" onclick="get_myTask('.$MyTask.','.$h_id.')">My Task('; if(!empty($counter_result)){echo $counter_result; }else{echo '0';} echo')</a>
                                    <a style="font-size:14px;"  class="btn dark btn-xs btn-outline">Compliance('; echo $ptc; echo ')</a>';
                                    echo '
                                
                                    <a style="font-weight:800;font-size:14px;" href="#modalGetHistory" data-toggle="modal" class="btn green btn-xs btn-outline" onclick="btnNew_History('.$rowData['History_id'].')">Add</a>
                                    <a style="font-weight:800;font-size:14px;" href="#modalGet_parent" data-toggle="modal" class="btn red btn-xs btn-outline" onclick="onclick_parent('.$rowData['History_id'].')">Edit</a>
                                </div>
                           </div>
                    </div>
                    <div id="'.$rowData['History_id'].'" class="panel-collapse collapse">
                        <div class="panel-body" >
                        <div id="data_child'.$rowData['History_id'].'">
                        </div>
                        </div>
                    </div>
                </div>
            </div>
    	';

		}
	}
	else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	    echo $message;
	}
	mysqli_close($conn);
}
?>
<script src="assets/global/plugins/datatables/datatable_custom.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
<script>
    // $(document).ready(function () {
    //         $('#tableData2').DataTable();
    //           $('#sample_4').DataTable();
    //             $('#sample_1').DataTable();
    // });
</script>