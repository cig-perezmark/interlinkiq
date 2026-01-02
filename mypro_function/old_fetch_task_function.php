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


    function subChild2($view_id, $data1, $id) {
    	global $conn;
    	$response = '';
    	
        $sql2 = $conn->query("
            SELECT 
            a.CAI_id AS a_ID,
            a.CIA_Indent_Id AS a_subchild,
            u.first_name AS u_first_name,
            a.CAI_filename AS a_name,
            a.CAI_description AS a_description,
            a.CAI_Accounts AS a_account,
            i.Action_Items_name AS i_name,
            e.first_name AS e_first_name,
            CASE 
            	WHEN a.CIA_progress = 2 THEN 'Completed'
                WHEN a.CIA_progress = 1 THEN 'Inprogress'
                ELSE 'Not Started'
            END AS a_status,
            a.CAI_Rendered_Minutes AS a_rendered,
            CASE WHEN a.CIA_progress = 2 THEN '100' ELSE '' END AS a_percentage,
            a.CAI_Action_date AS a_date_start,
            a.CAI_Action_due_date AS a_date_end,
            a.CAI_files AS a_file,
            COUNT(c.Task_ids) AS c_counts
            
            FROM tbl_MyProject_Services_Childs_action_Items  AS a
            
            LEFT JOIN (
            	SELECT
                ID,
                first_name
                FROM tbl_user
            ) AS u
            ON a.CAI_User_PK = u.ID
            
            LEFT JOIN (
            	SELECT
                ID,
                first_name
                FROM tbl_hr_employee
            ) AS e
            ON a.CAI_Assign_to = e.ID
            
            LEFT JOIN (
            	SELECT
                Action_Items_id,
                Action_Items_name
                FROM tbl_MyProject_Services_Action_Items
            ) AS i
            ON a.CAI_Action_taken = i.Action_Items_id
            
            LEFT JOIN (
            	SELECT
                Task_ids
                FROM tbl_MyProject_Services_Comment
            ) AS c
            ON a.CAI_id = c.Task_ids
            
            WHERE a.is_deleted = 0
            AND a.Parent_MyPro_PK = $view_id 
            AND a.Services_History_PK = $data1
            AND a.CIA_Indent_Id = $id
            
            GROUP BY a.CAI_id
        ");
        while($data2 = $sql2->fetch_array()) {
            $a_ID = $data2['a_ID'];
            $a_subchild = $data2['a_subchild'];
            $u_first_name = htmlentities($data2['u_first_name'] ?? '' );
            $a_name = htmlentities($data2['a_name'] ?? '' );
            $a_description = htmlentities($data2['a_description'] ?? '' );
            $a_account = htmlentities($data2['a_account'] ?? '' );
            $i_name = htmlentities($data2['i_name'] ?? '' );
            $e_first_name = htmlentities($data2['e_first_name'] ?? '' );
            $a_status = $data2['a_status'];
            $a_rendered = $data2['a_rendered'];
            $a_percentage = $data2['a_percentage'];
            $a_date_start = $data2['a_date_start'];
            $a_date_end = $data2['a_date_end'];
            $a_file = $data2['a_file'];
            $c_counts = $data2['c_counts'];
            
            $response .= '<tr id="sub_two_'.$a_ID.'">
        		<td id="'.$a_ID.'" class="child_border" width="50px">'.$a_ID.'</td>
        		<td class="child_2">From: '.$u_first_name.'</td>
        		<td class="child_2">';
        			$stringProduct = strip_tags($a_name); 
        			if(strlen($stringProduct) > 40) {
        				$stringCut = substr($stringProduct,0,40);
        				$endPoint = strrpos($stringCut,' ');
        				$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
        				$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub2" data-toggle="modal" onclick="get_moreDetails_sub2('.$a_ID.')"><i style="color:black;">More...</i></a>';
        			}
        			$response .= "$stringProduct";
        		$response .= '</td>
        		<td class="child_2" >';
        			$stringProduct = strip_tags($a_description); 
        			if(strlen($stringProduct) > 35) {
        				$stringCut = substr($stringProduct,0,35);
        				$endPoint = strrpos($stringCut,' ');
        				$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
        				$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$a_ID.')"><i style="color:black;">More...</i></a>';
        			}
        			$response .= "$stringProduct";
        		$response .= '</td>
        		<td class="child_2">'.$a_account.'</td>
        		<td class="child_2">'.$i_name.'</td>
        		<td class="child_2">Assign to: '.$e_first_name.'</td>
        		<td class="child_2"><b>'.$a_status.'</b></td>';
        		
        		if(!empty($a_rendered)){
        			$response .= '<td class="child_2">Rendered: '.$a_rendered.' minute(s)';
        		}
        		if(!empty($a_percentage)){
        			$response .= '<td class="child_2">'.$a_percentage.'%</td>';
        		}
        		
        		$response .= '<td class="child_2">Start: '.date("Y-m-d", strtotime($a_date_start)).'</td>
        		<td class="child_2">Due: '.date("Y-m-d", strtotime($a_date_end)).'</td>
        		<td class="child_2">';
        			if (!empty($a_file)) {
                    	$filesL9 = $a_file;
                    	$fileExtension = fileExtension($filesL9);
                    	$src = $fileExtension['src'];
                    	$embed = $fileExtension['embed'];
                    	$type = $fileExtension['type'];
                    	$file_extension = $fileExtension['file_extension'];
                    	$url = $base_url.'../MyPro_Folder_Files/';
                    	
        				$response .= '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
        					<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
        					<span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
        				</a>';
        			} else {
        				$response .= '<a style="color:#fff;" href="javascript:;" class="btn btn-link">
        					<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
        					<span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
        				</a>';
        			}
        		$response .= '</td>
        		<td class="child_2" style="min-width:80px;">
        		    <a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$a_ID.')">
    					<i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
    					<span class="badge" style="margin-left:-7px;background-color:'; if($c_counts == 0) { $response .= '#DC3535'; } else { $response .= 'blue'; } $response .= ';">
    						<b>'.$c_counts.'</b>
    					</span>
    				</a>
    			</td>
        		<td class="child_2" style="min-width:100px;">
        	        <a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGetHistory_Child2b" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$a_ID.')">Add</a>
        	        <a style="font-weight:800;color:#fff;" href="#modalGet_child2b" data-toggle="modal" class="btn red btn-xs" onclick="onclick_2('.$a_ID.')">Edit</a>
                </td>
        	</tr>';
            
            $response .= subChild($view_id, $data1, $a_ID);
        }
        
        return $response;
    }
    
    
    function subChild($view_id, $data1, $id) {
    	global $conn;
    	$response = '';
    	
        $sql2 = $conn->query("
            WITH RECURSIVE cte (TreeLevel, a_ID, a_parent, a_user, a_name, a_description, a_account, a_item, a_assign, a_status, a_rendered, a_date_start, a_date_end, a_file) AS
            (
                SELECT
                1 AS TreeLevel,
                a.CAI_id AS a_ID,
                a.Parent_MyPro_PK AS a_parent_id,
                a.CIA_Indent_Id AS a_parent,
                a.CAI_User_PK AS a_user,
                a.CAI_filename AS a_name,
                a.CAI_description AS a_description,
                a.CAI_Accounts AS a_account,
                a.CAI_Action_taken AS a_item,
                a.CAI_Assign_to AS a_assign,
                a.CIA_progress AS a_status,
                a.CAI_Rendered_Minutes AS a_rendered,
                a.CAI_Action_date AS a_date_start,
                a.CAI_Action_due_date AS a_date_end,
                a.CAI_files AS a_file
                FROM tbl_MyProject_Services_Childs_action_Items  AS a
                WHERE a.is_deleted = 0
                AND a.Parent_MyPro_PK = $view_id 
                AND a.Services_History_PK = $data1
                AND a.CIA_Indent_Id = $id
                
                UNION ALL
            
                SELECT 
                cte.TreeLevel+1 AS TreeLevel,
                a2.CAI_id AS a_ID,
                a2.Parent_MyPro_PK AS a_parent_id,
                a2.CIA_Indent_Id AS a_parent,
                a2.CAI_User_PK AS a_user,
                a2.CAI_filename AS a_name,
                a2.CAI_description AS a_description,
                a2.CAI_Accounts AS a_account,
                a2.CAI_Action_taken AS a_item,
                a2.CAI_Assign_to AS a_assign,
                a2.CIA_progress AS a_status,
                a2.CAI_Rendered_Minutes AS a_rendered,
                a2.CAI_Action_date AS a_date_start,
                a2.CAI_Action_due_date AS a_date_end,
                a2.CAI_files AS a_file
                FROM tbl_MyProject_Services_Childs_action_Items  AS a2
                
                JOIN cte ON cte.a_ID = a2.CIA_Indent_Id
                
                WHERE a2.is_deleted = 0
                AND a2.Parent_MyPro_PK = $view_id 
                AND a2.Services_History_PK = $data1
            )
            SELECT 
            TreeLevel, a_ID, a_parent, a_user, a_name, a_description, a_account, a_item, a_assign, a_status, a_rendered, a_date_start, a_date_end, a_file,
            u.first_name AS u_first_name,
            i.Action_Items_name AS i_name,
            e.first_name AS e_first_name,
            CASE 
            	WHEN a_status = 2 THEN 'Completed'
                WHEN a_status = 1 THEN 'Inprogress'
                ELSE 'Not Started'
            END AS a_statuses,
            CASE WHEN a_status = 2 THEN '100' ELSE '' END AS a_percentage,
            COUNT(c.Task_ids) AS c_counts
            FROM cte
            
            LEFT JOIN (
            	SELECT
                ID,
                first_name
                FROM tbl_user
            ) AS u
            ON a_user = u.ID
            
            LEFT JOIN (
            	SELECT
                ID,
                first_name
                FROM tbl_hr_employee
            ) AS e
            ON a_assign = e.ID
            
            LEFT JOIN (
            	SELECT
                Action_Items_id,
                Action_Items_name
                FROM tbl_MyProject_Services_Action_Items
            ) AS i
            ON a_item = i.Action_Items_id
            
            LEFT JOIN (
            	SELECT
                Task_ids
                FROM tbl_MyProject_Services_Comment
            ) AS c
            ON a_ID = c.Task_ids
    
            GROUP BY a_ID
            
            ORDER BY a_ID, a_parent
        ");
        while($data2 = $sql2->fetch_array()) {
            $a_ID = $data2['a_ID'];
            $a_parent_id = $data2['a_parent_id'];
            $TreeLevel = $data2['TreeLevel'];
            $u_first_name = htmlentities($data2['u_first_name'] ?? '' );
            $a_name = htmlentities($data2['a_name'] ?? '' );
            $a_description = htmlentities($data2['a_description'] ?? '' );
            $a_account = htmlentities($data2['a_account'] ?? '' );
            $i_name = htmlentities($data2['i_name'] ?? '' );
            $e_first_name = htmlentities($data2['e_first_name'] ?? '' );
            $a_status = $data2['a_statuses'];
            $a_rendered = $data2['a_rendered'];
            $a_percentage = $data2['a_percentage'];
            $a_date_start = $data2['a_date_start'];
            $a_date_end = $data2['a_date_end'];
            $a_file = $data2['a_file'];
            $c_counts = $data2['c_counts'];
            
            $response .= '<tr id="sub_two_'.$a_ID.'">
        		<td id="'.$a_ID.'" class="child_border" width="50px">'.$a_ID.'</td>
        		<td class="child_border" colspan="'.$TreeLevel.'"></td>
        		<td class="child_2">From: '.$u_first_name.'</td>
        		<td class="child_2">';
        			$stringProduct = strip_tags($a_name); 
        			if(strlen($stringProduct) > 40) {
        				$stringCut = substr($stringProduct,0,40);
        				$endPoint = strrpos($stringCut,' ');
        				$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
        				$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub2" data-toggle="modal" onclick="get_moreDetails_sub2('.$a_ID.')"><i style="color:black;">More...</i></a>';
        			}
        			$response .= "$stringProduct";
        		$response .= '</td>
        		<td class="child_2" >';
        			$stringProduct = strip_tags($a_description); 
        			if(strlen($stringProduct) > 35) {
        				$stringCut = substr($stringProduct,0,35);
        				$endPoint = strrpos($stringCut,' ');
        				$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
        				$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$a_ID.')"><i style="color:black;">More...</i></a>';
        			}
        			$response .= "$stringProduct";
        		$response .= '</td>
        		<td class="child_2">'.$a_account.'</td>
        		<td class="child_2">'.$i_name.'</td>
        		<td class="child_2">Assign to: '.$e_first_name.'</td>
        		<td class="child_2"><b>'.$a_status.'</b></td>';
        		
        		if(!empty($a_rendered)){
        			$response .= '<td class="child_2">Rendered: '.$a_rendered.' minute(s)';
        		}
        		if(!empty($a_percentage)){
        			$response .= '<td class="child_2">'.$a_percentage.'%</td>';
        		}
        		
        		$response .= '<td class="child_2">Start: '.date("Y-m-d", strtotime($a_date_start)).'</td>
        		<td class="child_2">Due: '.date("Y-m-d", strtotime($a_date_end)).'</td>
        		<td class="child_2">';
        			if (!empty($a_file)) {
                    	$filesL9 = $a_file;
                    	$fileExtension = fileExtension($filesL9);
                    	$src = $fileExtension['src'];
                    	$embed = $fileExtension['embed'];
                    	$type = $fileExtension['type'];
                    	$file_extension = $fileExtension['file_extension'];
                    	$url = $base_url.'../MyPro_Folder_Files/';
                    	
        				$response .= '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
        					<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
        					<span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
        				</a>';
        			} else {
        				$response .= '<a style="color:#fff;" href="javascript:;" class="btn btn-link">
        					<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
        					<span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
        				</a>';
        			}
        		$response .= '</td>
        		<td class="child_2" style="min-width:80px;">
        		    <a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$a_ID.')">
    					<i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
    					<span class="badge" style="margin-left:-7px;background-color:'; if($c_counts == 0) { $response .= '#DC3535'; } else { $response .= 'blue'; } $response .= ';">
    						<b>'.$c_counts.'</b>
    					</span>
    				</a>
    			</td>
        		<td class="child_2" style="min-width:100px;">
        	        <a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGetHistory_Child2b" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$a_ID.')">Add</a>
        	        <a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGet_child2b" data-toggle="modal" class="btn yellow btn-xs" onclick="onclick_2('.$a_ID.')">Edit</a>';
        	        if($_COOKIE['ID'] == 456 || $_COOKIE['ID'] == 43 ): 
        	        $response .= '<a style="font-weight:800;color:#fff;" class="btn red btn-xs remove-mypro" data-key="'.$a_parent_id.'" data-table="tbl_MyProject_Services_Childs_action_Items" data-id="'.$a_ID.'">Delete</a>';
        	        endif;
                $response .= '</td>
        	</tr>';
            
            // $response .= subChild($view_id, $data1, $a_ID);
        }
        
        return $response;
    }
    
    if (isset($_POST['key'])) {
    	$response = "";
    
    	if ($_POST['key'] == 'idss') {
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
                                        <a style="font-size:14px;" href="#modalGetHistoryb" data-toggle="modal" class="btn blue btn-xs btn-outline" onclick="btnNew_History('.$data1['History_id'].','.$data1['History_id'].')">Add</a>
                                        <a style="font-size:14px;" href="#modalGet_parent" data-toggle="modal" class="btn yellow btn-xs btn-outline" onclick="onclick_parent('.$data1['History_id'].')">Edit</a>';
                                        if($_COOKIE['ID'] == 456 || $_COOKIE['ID'] == 43 ): 
                            	            $response .= '<a style="font-size:14px;" class="btn red btn-xs btn-outline remove-mypro" data-key="'.$data1['Parent_MyPro_PK'].'" data-table="tbl_MyProject_Services_Childs_action_Items" data-id="'.$data1['History_id'].'">Delete</a>';
                            	        endif;
                                    $response .= '
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
    
    	if ($_POST['key'] == 'ids') {
            $current_userEmployeeID = $_COOKIE['employee_id'];
    	    $view_id = $_POST['view_id'];
    		$sql = $conn->query("
    		    SELECT 
                h.History_id AS h_ID,
                h.MyPro_PK AS h_parent_id,
                h.filename AS h_name,
                h.description AS h_description,
                h.files AS h_file,
                h.h_accounts AS h_account,
                h.Action_date AS h_date,
                a.Action_Items_name AS a_action,
                u.first_name AS u_first_name,
                e.first_name AS e_first_name,
                COUNT(i.Services_History_PK) AS i_count,
                SUM(i.completed) AS i_completed
                
                FROM tbl_MyProject_Services_History As h
                
                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_MyProject_Services_Action_Items
                ) AS a
                ON h.Action_taken = a.Action_Items_id
                
                LEFT JOIN (
                    SELECT
                    ID,
                    first_name
                    FROM tbl_user
                ) AS u
                ON h.user_id = u.ID
                
                LEFT JOIN (
                    SELECT
                    ID,
                    first_name
                    FROM tbl_hr_employee
                ) AS e
                ON h.Assign_to_history = e.ID
                
                LEFT JOIN (
                    SELECT
                    Services_History_PK,
                    CASE WHEN CIA_progress = 2 THEN 1 ELSE 0 END AS completed
                    FROM tbl_MyProject_Services_Childs_action_Items
                    -- WHERE CAI_Assign_to = $current_userEmployeeID
                ) AS i
                ON h.History_id = i.Services_History_PK
                
                WHERE h.MyPro_PK = $view_id
                
                GROUP BY h.History_id
            ");
    		while($data1 = $sql->fetch_array()) {
                $h_ID = $data1['h_ID'];
                $h_parent_id = $data1['h_parent_id'];
                $h_name = htmlentities($data1['h_name'] ?? '');
                $h_description = htmlentities($data1['h_description'] ?? '');
                $h_account = htmlentities($data1['h_account'] ?? '');
                $h_date = $data1['h_date'];
                $a_action = htmlentities($data1['a_action'] ?? '');
                $u_first_name = $data1['u_first_name'];
                $e_first_name = $data1['e_first_name'];
                
                $response .= '<div id="center_'.$h_ID.'"></div>
                <div class="panel-group accordion " id="accordion'.$h_ID.'" style="width:100%;">
                    <div class="panel panel">
                        <div class="panel-heading" style="background-color:#F5F5F5;color:black;padding: 5px 15px !important;" >
                            <div class="row">
                                <div class="col-md-9">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion'.$h_ID.'" href="#'.$h_ID.'"> 
                                        <table class="table table-resposive"  style="font-size:13px;margin-bottom: 0px !important;">
                                            <tbody>
                                                <tr onclick="view_more('.$h_ID.')" id="parents_'.$h_ID.'">
                                                    <th class="child_1" width="80px">'.$h_ID.'</th>
                                                    <th class="child_1">From: '.$u_first_name.'</th>
                                                    <th class="child_1">'.$h_name.'</th>
                                                    <th class="child_1" style="width:20%;">';
                                                        $stringProduct = strip_tags($h_description); 
                                                        if(strlen($stringProduct) > 76) {
                                                            $stringCut = substr($stringProduct,0,76);
                                                            $endPoint = strrpos($stringCut,' ');
                                                            $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                                                            $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail" data-toggle="modal" onclick="get_moreDetails('.$h_ID.')"><i style="color:black;">See more...</i></a>';
                                                        }
                                                        $response .= $stringProduct;
                                                    $response .= '</th>
                                                    <th class="child_1">Account: '.$h_account.'</th>
                                                    <th class="child_1">Assigned to: '.$e_first_name.'</th>
                                                    <th class="child_1">'.$a_action.'</th>
                                                    <th class="child_1">Due Date: '.date("Y-m-d", strtotime($h_date)).'</th>
                                                    <th class="child_1" width="5%">';
                                                        if (!empty($data1['h_file'])) {
                                                		    $files_p = $data1["h_file"];
                                                            $fileExtension = fileExtension($files_p);
                                                    		$src = $fileExtension['src'];
                                                    		$embed = $fileExtension['embed'];
                                                    		$type = $fileExtension['type'];
                                                    		$file_extension = $fileExtension['file_extension'];
                                                            $url = $base_url.'../MyPro_Folder_Files/';
                                                            
                                                            $response .= '<a style="color:;" data-src="'.$src.$url.rawurlencode($files_p).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                                                <i class="icon-doc" style="font-size:18px;color:;margin-left:12px;"></i>
                                                                <span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
                                                            </a>';
                                                        } else {
                                                            $response .= '<a style="color:;" href="javascript:;" class="btn btn-link">
                                                                <i class="icon-doc" style="font-size:18px;color:;margin-left:12px;"></i>
                                                                <span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
                                                            </a>';
                                                        }
                                                    $response .= '</th>
                                                    <th></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </a>
                                </div>
                                <div class="col-md-3">';
                                
                                    $ptc = 0;
                                    if($data1['i_count'] >= $data1['i_completed'] AND $data1['i_completed'] > 0){
                                        $ptc = round(($data1['i_completed'] / $data1['i_count']) * 100, 2);
                                    }
                                    
                                    $response .= '<a style="font-size:14px;" class="btn dark btn-xs btn-outline" onclick="get_myTask('.$current_userEmployeeID.','.$h_ID.')">My Task('.$data1['i_count'].')</a>
                                    <a style="font-size:14px;"  class="btn dark btn-xs btn-outline">Compliance('.$ptc.'%)</a>
                                    <a style="font-size:14px;" href="#modalGetHistoryb" data-toggle="modal" class="btn blue btn-xs btn-outline" onclick="btnNew_History('.$h_ID.','.$h_ID.')">Add</a>
                                    <a style="font-size:14px;" href="#modalGet_parent" data-toggle="modal" class="btn yellow btn-xs btn-outline" onclick="onclick_parent('.$h_ID.')">Edit</a>';
                                    if($_COOKIE['ID'] == 456 || $_COOKIE['ID'] == 43 ):  
                            	            $response .= '<a style="font-size:14px;" class="btn red btn-xs btn-outline remove-mypro" data-key="'.$h_parent_id.'" data-table="tbl_MyProject_Services_History" data-id="'.$h_ID.'">Delete</a>';
                            	        endif;
                                    $response .= '
                                </div>
                            </div>
                        </div>
                        <div id="'.$h_ID.'" class="panel-collapse collapse" >
                            <div class="panel-body" style="max-width: 84vw;max-height: 65vh;overflow: scroll;" >
                                <table class="" id="main_'.$h_ID.'" style=" width: 100%;font-size:12px;">
                                    <tbody id="data_child'.$h_ID.'" ><tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>';
    		}
    	}
    	
    	if($_POST['key'] == 'child_twos'){
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
                        $response .= '<a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGetHistory_Child2b" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$data2['CAI_id'].')">Add</a>';
                        $response .= '<a style="font-weight:800;color:#fff;" href="#modalGet_child2b" data-toggle="modal" class="btn red btn-xs" onclick="onclick_2('.$data2['CAI_id'].')">Edit</a>';
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
                        $response .= '<a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGetHistory_Child3b" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child3('.$data3['CAI_id'].')">Add</a>';
                        $response .= '<a style="font-weight:800;color:#fff;" href="#modalGet_child3b" data-toggle="modal" class="btn red btn-xs" onclick="onclick_3('.$data3['CAI_id'].')">Edit</a>';
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
                        $response .= '<a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGetHistory_Child4b" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child4('.$data4['CAI_id'].')">Add</a>';
                        $response .= '<a style="font-weight:800;color:#fff;" href="#modalGet_child4b" data-toggle="modal" class="btn red btn-xs" onclick="onclick_4('.$data4['CAI_id'].')">Edit</a>';
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
                        $response .= '<a style="font-weight:800;color:#fff;" href="#modalGet_child5b" data-toggle="modal" class="btn red btn-xs" onclick="onclick_5('.$data5['CAI_id'].')">Edit</a>';
                        $response .= '
                    </td>
    			</tr>
    		';
    		}
    			
    		}
    			
    		}
    			
    		}
    	}
    	
    	if($_POST['key'] == 'child_twos2'){
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
            	$response .= '<tr id="sub_two_'.$data2['CAI_id'].'">
            		<td id="'.$data2['CAI_id'].'" class="child_border" width="50px">'.$data2['CAI_id'].'</td>';
            		$owner  = $data2['CAI_User_PK'];
            		$query = "SELECT * FROM tbl_user where ID = $owner";
            		$result = mysqli_query($conn, $query);
            		while($row = mysqli_fetch_array($result)){ 
            			$response .= '<td class="child_2">From: '.$row['first_name'].'</td>';
            		}
            		$response .= '<td class="child_2">';
            			$stringProduct = strip_tags($data2['CAI_filename']); 
            			if(strlen($stringProduct) > 40) {
            				$stringCut = substr($stringProduct,0,40);
            				$endPoint = strrpos($stringCut,' ');
            				$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
            				$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub2" data-toggle="modal" onclick="get_moreDetails_sub2('.$data2['CAI_id'].')"><i style="color:black;">More...</i></a>';
            			}
            			$response .= "$stringProduct";
            		$response .= '</td>
            		<td class="child_2" >';
            			$stringProduct = strip_tags($data2['CAI_description']); 
            			if(strlen($stringProduct) > 35) {
            				$stringCut = substr($stringProduct,0,35);
            				$endPoint = strrpos($stringCut,' ');
            				$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
            				$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$data2['CAI_id'].')"><i style="color:black;">More...</i></a>';
            			}
            			$response .= "$stringProduct";
            		$response .= '</td>
            
            		<td class="child_2">'.$data2['CAI_Accounts'].'</td>
            		<td class="child_2">'.$data2['Action_Items_name'].'</td>
            		<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
            		if($data2['CIA_progress']== 1){ $response .= '<td class="child_2"><b>Inprogress</b></td>'; }
            		else if($data2['CIA_progress']== 2){ $response .= '<td class="child_2"><b>Completed</b></td>';}
            		else{ $response .= '<td class="child_2"><b>Not Started</b></td>';}
            		//rendered time
            		if(!empty($data2['CAI_Rendered_Minutes'])){
            			$response .= '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
            		}
            		if($data2['CIA_progress']==2){
            			$response .= '<td class="child_2">100%</td>';
            		}
            		$response .= '<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
            		<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
            		<td class="child_2">';
            			if (!empty($filesL9)) {
            				$response .= '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            					<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            					<span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
            				</a>';
            			} else {
            				$response .= '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            					<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            					<span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
            				</a>';
            			}
            		$response .= '</td>
            		<td class="child_2" style="min-width:80px;">';
            			$_comment  = $data2['CAI_id'];
            			$query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
            			$result_comment = mysqli_query($conn, $query_comment);
            			while($row_comment = mysqli_fetch_array($result_comment)) { 
            				$response .= '<a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$data2['CAI_id'].')">
            					<i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            					<span class="badge" style="margin-left:-7px;background-color:'; if($row_comment['count'] == 0){$response .= '#DC3535';}else{$response .= 'blue';}  $response .= ';">
            						<b>'.$row_comment['count'].'</b>
            					</span>
            				</a>';
            			}
            		$response .= '  </td>
            
            		<td class="child_2" style="min-width:100px;">';
            			$response .= '<a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGetHistory_Child2b" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$data2['CAI_id'].')">Add</a>';
            			$response .= '<a style="font-weight:800;color:#fff;" href="#modalGet_child2b" data-toggle="modal" class="btn red btn-xs" onclick="onclick_2('.$data2['CAI_id'].')">Edit</a>';
            		$response .= '</td>
            	</tr>';
            
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
            		$response .= '<tr id="sub_three_main'.$data3['CAI_id'].'">
            			<td  class="child_border" width="50px">'.$data3['CAI_id'].'</td>
            			<td class="child_border" width="80px"></td>';
            			$owner  = $data3['CAI_User_PK'];
            			$query = "SELECT * FROM tbl_user where ID = $owner";
            			$result = mysqli_query($conn, $query);
            			while($row = mysqli_fetch_array($result)){ 
            				$response .= '<td class="child_2">From: '.$row['first_name'].'</td>';
            			}
            			$response .= '<td class="child_2" style="width:;">';
            				$stringProduct = strip_tags($data3['CAI_filename']); 
            				if(strlen($stringProduct) > 40) {
            					$stringCut = substr($stringProduct,0,40);
            					$endPoint = strrpos($stringCut,' ');
            					$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
            					$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub3" data-toggle="modal" onclick="get_moreDetails_sub3('.$data3['CAI_id'].')"><i style="color:black;">More...</i></a>';
            				}
            				$response .= "$stringProduct";
            			$response .= '</td>
            			<td class="child_2" style="width:;">';
            				$stringProduct = strip_tags($data3['CAI_description']); 
            				if(strlen($stringProduct) > 35) {
            					$stringCut = substr($stringProduct,0,35);
            					$endPoint = strrpos($stringCut,' ');
            					$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
            					$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail3" data-toggle="modal" onclick="get_moreDetails3('.$data3['CAI_id'].')"><i style="color:black;">More...</i></a>';
            				}
            				$response .= "$stringProduct";
            			$response .= '</td>
            			<td class="child_2">'.$data3['CAI_Accounts'].'</td>
            			<td class="child_2">'.$data3['Action_Items_name'].'</td>
            			<td class="child_2">Assign to: '.$data3['first_name'].'</td>';
            			if($data3['CIA_progress']== 1){ $response .= '<td class="child_2"><b>Inprogress</b></td>'; }
            			else if($data3['CIA_progress']== 2){ $response .= '<td class="child_2"><b>Completed</b></td>';}
            			else{ $response .= '<td class="child_2"><b>Not Started</b></td>';}
            			//rendered time
            			if(!empty($data3['CAI_Rendered_Minutes'])){
            				$response .= '<td class="child_2">Rendered: '.$data3['CAI_Rendered_Minutes'].' minute(s)';
            			}
            			if($data3['CIA_progress']==2){
            				$response .= '<td class="child_2">100%</td>';
            			}
            			$response .= '<td class="child_2">Start: '.date("Y-m-d", strtotime($data3['CAI_Action_date'])).'</td>
            			<td class="child_2">Due: '.date("Y-m-d", strtotime($data3['CAI_Action_due_date'])).'</td>
            			<td class="child_2">';
            				if (!empty($filesL9)) {
            					$response .= '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            						<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            						<span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
            					</a>';
            				} else {
            					$response .= '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            						<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            						<span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
            					</a>';
            				}
            			$response .= '</td>
            			<td class="child_2">';
            				$_comment  = $data3['CAI_id'];
            				$query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
            				$result_comment = mysqli_query($conn, $query_comment);
            				while($row_comment = mysqli_fetch_array($result_comment)) { 
            					$response .= '<a href="#modalGet_Comments3" data-toggle="modal" onclick="btn_Comments3('.$data3['CAI_id'].')">
            						<i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            						<span class="badge" style="background-color:'; if($row_comment['count'] == 0){$response .= '#DC3535';}else{$response .= 'blue';}  $response .= ';margin-left:-7px;">
            							<b>'.$row_comment['count'].'</b>
            						</span>
            					</a>';
            				}
            			$response .= '</td>
            			<td class="child_2" style="min-width:100px;">';
            				$response .= '<a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGetHistory_Child3b" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child3('.$data3['CAI_id'].')">Add</a>';
            				$response .= '<a style="font-weight:800;color:#fff;" href="#modalGet_child3b" data-toggle="modal" class="btn red btn-xs" onclick="onclick_3('.$data3['CAI_id'].')">Edit</a>';
            			$response .= '</td>
            		</tr>';
            
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
            			$response .= '<tr id="sub_four_'.$data4['CAI_id'].'">
            				<td class="child_border" width="50px">'.$data4['CAI_id'].'</td>
            				<td class="child_border" width="80px"></td>
            				<td class="child_border" ></td>';
            				$owner  = $data4['CAI_User_PK'];
            				$query = "SELECT * FROM tbl_user where ID = $owner";
            				$result = mysqli_query($conn, $query);
            				while($row = mysqli_fetch_array($result)) { 
            					$response .= '<td class="child_2">From: '.$row['first_name'].'</td>';
            				}
            				$response .= '<td class="child_2" style="width:;">';
            					$stringProduct = strip_tags($data4['CAI_filename']); 
            					if(strlen($stringProduct) > 40) {
            						$stringCut = substr($stringProduct,0,40);
            						$endPoint = strrpos($stringCut,' ');
            						$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
            						$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub4" data-toggle="modal" onclick="get_moreDetails_sub4('.$data4['CAI_id'].')"><i style="color:black;">More...</i></a>';
            					}
            					$response .= "$stringProduct";
            				$response .= '</td>
            				<td class="child_2" style="width:;">';
            					$stringProduct = strip_tags($data4['CAI_description']); 
            					if(strlen($stringProduct) > 35) {
            						$stringCut = substr($stringProduct,0,35);
            						$endPoint = strrpos($stringCut,' ');
            						$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
            						$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail4" data-toggle="modal" onclick="get_moreDetails4('.$data4['CAI_id'].')"><i style="color:black;">More...</i></a>';
            					}
            					$response .= "$stringProduct";
            				$response .= '</td>
            				<td class="child_2" >'.$data4['CAI_Accounts'].'</td>
            				<td class="child_2">'.$data4['Action_Items_name'].'</td>
            				<td class="child_2">Assign to: '.$data4['first_name'].'</td>';
            				if($data4['CIA_progress']== 1){ $response .= '<td class="child_2"><b>Inprogress</b></td>'; }
            				else if($data4['CIA_progress']== 2){ $response .= '<td class="child_2"><b>Completed</b></td>';}
            				else{ $response .= '<td class="child_2"><b>Not Started</b></td>';}
            				//rendered time
            				if(!empty($data4['CAI_Rendered_Minutes'])){
            					$response .= '<td class="child_2">Rendered: '.$data4['CAI_Rendered_Minutes'].' minute(s)';
            				}
            				if($data4['CIA_progress']==2){
            					$response .= '<td class="child_2">100%</td>';
            				}
            				$response .= '<td class="child_2">Start: '.date("Y-m-d", strtotime($data4['CAI_Action_date'])).'</td>
            				<td class="child_2">Due: '.date("Y-m-d", strtotime($data4['CAI_Action_due_date'])).'</td>
            				<td class="child_2">';
            					if (!empty($filesL9)) {
            						$response .= '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            							<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            							<span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
            						</a>';
            					} else {
            						$response .= '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            							<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            							<span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
            						</a>';
            					}
            				$response .= '</td>
            				<td class="child_2">';
            					$_comment  = $data4['CAI_id'];
            					$query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
            					$result_comment = mysqli_query($conn, $query_comment);
            					while($row_comment = mysqli_fetch_array($result_comment)){ 
            						$response .= '<a href="#modalGet_Comments4" data-toggle="modal" onclick="btn_Comments4('.$data4['CAI_id'].')">
            							<i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            							<span class="badge" style="background-color:'; if($row_comment['count'] == 0){ $response .= '#DC3535'; } else { $response .= 'blue'; }  $response .= '; margin-left:-7px;">
            								<b>'.$row_comment['count'].'</b>
            							</span>
            						</a>';
            					}
            				$response .= '</td>';
            				$response .= '<td class="child_2" style="min-width:100px;">';
            					$response .= '<a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGetHistory_Child4b" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child4('.$data4['CAI_id'].')">Add</a>';
            					$response .= '<a style="font-weight:800;color:#fff;" href="#modalGet_child4b" data-toggle="modal" class="btn red btn-xs" onclick="onclick_4('.$data4['CAI_id'].')">Edit</a>';
            				$response .= '</td>
            			</tr>';
            
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
            				$response .= '<tr id="sub_five_'.$data5['CAI_id'].'">
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
            					$response .= '<td class="child_2" style="width:;">';
            						$stringProduct = strip_tags($data5['CAI_filename']); 
            						if(strlen($stringProduct) > 40) {
            							$stringCut = substr($stringProduct,0,40);
            							$endPoint = strrpos($stringCut,' ');
            							$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
            							$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub5" data-toggle="modal" onclick="get_moreDetails_sub5('.$data5['CAI_id'].')"><i style="color:black;">More...</i></a>';
            						}
            						$response .= "$stringProduct";
            					$response .= '</td>
            					<td class="child_2" style="width:;">';
            						$stringProduct = strip_tags($data5['CAI_description']); 
            						if(strlen($stringProduct) > 35) {
            							$stringCut = substr($stringProduct,0,35);
            							$endPoint = strrpos($stringCut,' ');
            							$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
            							$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail5" data-toggle="modal" onclick="get_moreDetails5('.$data5['CAI_id'].')"><i style="color:black;">More...</i></a>';
            						}
            						$response .= "$stringProduct";
            					$response .= '</td>
            					<td class="child_2">'.$data5['CAI_Accounts'].'</td>
            					<td class="child_2">'.$data5['Action_Items_name'].'</td>
            					<td class="child_2">Assign to: '.$data5['first_name'].'</td>';
            					if($data5['CIA_progress']== 1){ $response .= '<td class="child_2"><b>Inprogress</b></td>'; }
            					else if($data5['CIA_progress']== 2){ $response .= '<td class="child_2"><b>Completed</b></td>';}
            					else{ $response .= '<td class="child_2"><b>Not Started</b></td>';}
            					//rendered time
            					if(!empty($data5['CAI_Rendered_Minutes'])){
            						$response .= '<td class="child_2">Rendered: '.$data5['CAI_Rendered_Minutes'].' minute(s)';
            					}
            					if($data5['CIA_progress']==2){
            						$response .= '<td class="child_2">100%</td>';
            					}
            					$response .= '<td class="child_2">Start: '.date("Y-m-d", strtotime($data5['CAI_Action_date'])).'</td>
            					<td class="child_2">Due: '.date("Y-m-d", strtotime($data5['CAI_Action_due_date'])).'</td>
            					<td class="child_2">';
            						if (!empty($filesL9))
            						{
            							$response .= '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            								<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            								<span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
            							</a>';
            						} else {
            							$response .= '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            								<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            								<span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
            							</a>';
            						}
            					$response .= '</td>
            					<td class="child_2">';
            						$_comment  = $data5['CAI_id'];
            						$query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
            						$result_comment = mysqli_query($conn, $query_comment);
            						while($row_comment = mysqli_fetch_array($result_comment)){ 
            							$response .= '<a href="#modalGet_Comments5" data-toggle="modal" onclick="btn_Comments5('.$data5['CAI_id'].')" >
            								<i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            								<span class="badge" style="background-color:'; if($row_comment['count'] == 0){$response .= '#DC3535';}else{$response .= 'blue';}  $response .= ';margin-left:-7px;">
            									<b>'.$row_comment['count'].'</b>
            								</span>
            							</a>';
            						}
            					$response .= '</td>
            					<td class="child_2" style="min-width:100px;">';
            						$response .= '<a style="font-weight:800;color:#fff;" href="#modalGet_child5b" data-toggle="modal" class="btn red btn-xs" onclick="onclick_5('.$data5['CAI_id'].')">Edit</a>';
            					$response .= '</td>
            				</tr>';
            			}
            
            		}
            
            	}
            
            }
    	}
    	
    	if($_POST['key'] == 'child_two3'){
            //layer 2
            $data1 = $_POST['get_id'];
            $view_id = $_POST['view_id'];
            
            $sql2 = $conn->query("
                SELECT 
                a.CAI_id AS a_ID,
                a.CIA_Indent_Id AS a_subchild,
                u.first_name AS u_first_name,
                a.CAI_filename AS a_name,
                a.CAI_description AS a_description,
                a.CAI_Accounts AS a_account,
                i.Action_Items_name AS i_name,
                e.first_name AS e_first_name,
                CASE 
                	WHEN a.CIA_progress = 2 THEN 'Completed'
                    WHEN a.CIA_progress = 1 THEN 'Inprogress'
                    ELSE 'Not Started'
                END AS a_status,
                a.CAI_Rendered_Minutes AS a_rendered,
                CASE WHEN a.CIA_progress = 2 THEN '100' ELSE '' END AS a_percentage,
                a.CAI_Action_date AS a_date_start,
                a.CAI_Action_due_date AS a_date_end,
                a.CAI_files AS a_file,
                COUNT(c.Task_ids) AS c_counts
                
                FROM tbl_MyProject_Services_Childs_action_Items  AS a
                
                LEFT JOIN (
                	SELECT
                    ID,
                    first_name
                    FROM tbl_user
                ) AS u
                ON a.CAI_User_PK = u.ID
                
                LEFT JOIN (
                	SELECT
                    ID,
                    first_name
                    FROM tbl_hr_employee
                ) AS e
                ON a.CAI_Assign_to = e.ID
                
                LEFT JOIN (
                	SELECT
                    Action_Items_id,
                    Action_Items_name
                    FROM tbl_MyProject_Services_Action_Items
                ) AS i
                ON a.CAI_Action_taken = i.Action_Items_id
                
                LEFT JOIN (
                	SELECT
                    Task_ids
                    FROM tbl_MyProject_Services_Comment
                ) AS c
                ON a.CAI_id = c.Task_ids
                
                WHERE a.is_deleted = 0
                AND a.Parent_MyPro_PK = $view_id 
                AND a.Services_History_PK = $data1
                AND a.CIA_Indent_Id = $data1
                
                GROUP BY a.CAI_id
            ");
            while($data2 = $sql2->fetch_array()) {
                $a_ID = $data2['a_ID'];
                $a_subchild = $data2['a_subchild'];
                $u_first_name = htmlentities($data2['u_first_name'] ?? '' );
                $a_name = htmlentities($data2['a_name'] ?? '' );
                $a_description = htmlentities($data2['a_description'] ?? '' );
                $a_account = htmlentities($data2['a_account'] ?? '' );
                $i_name = htmlentities($data2['i_name'] ?? '' );
                $e_first_name = htmlentities($data2['e_first_name'] ?? '' );
                $a_status = $data2['a_status'];
                $a_rendered = $data2['a_rendered'];
                $a_percentage = $data2['a_percentage'];
                $a_date_start = $data2['a_date_start'];
                $a_date_end = $data2['a_date_end'];
                $a_file = $data2['a_file'];
                $c_counts = $data2['c_counts'];
                
                $response .= '<tr id="sub_two_'.$a_ID.'">
            		<td id="'.$a_ID.'" class="child_border" width="50px">'.$a_ID.'</td>
            		<td class="child_2">From: '.$u_first_name.'</td>
            		<td class="child_2">';
            			$stringProduct = strip_tags($a_name); 
            			if(strlen($stringProduct) > 40) {
            				$stringCut = substr($stringProduct,0,40);
            				$endPoint = strrpos($stringCut,' ');
            				$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
            				$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub2" data-toggle="modal" onclick="get_moreDetails_sub2('.$a_ID.')"><i style="color:black;">More...</i></a>';
            			}
            			$response .= "$stringProduct";
            		$response .= '</td>
            		<td class="child_2" >';
            			$stringProduct = strip_tags($a_description); 
            			if(strlen($stringProduct) > 35) {
            				$stringCut = substr($stringProduct,0,35);
            				$endPoint = strrpos($stringCut,' ');
            				$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
            				$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$a_ID.')"><i style="color:black;">More...</i></a>';
            			}
            			$response .= "$stringProduct";
            		$response .= '</td>
            		<td class="child_2">'.$a_account.'</td>
            		<td class="child_2">'.$i_name.'</td>
            		<td class="child_2">Assign to: '.$e_first_name.'</td>
            		<td class="child_2"><b>'.$a_status.'</b></td>';
            		
            		if(!empty($a_rendered)){
            			$response .= '<td class="child_2">Rendered: '.$a_rendered.' minute(s)';
            		}
            		if(!empty($a_percentage)){
            			$response .= '<td class="child_2">'.$a_percentage.'%</td>';
            		}
            		
            		$response .= '<td class="child_2">Start: '.date("Y-m-d", strtotime($a_date_start)).'</td>
            		<td class="child_2">Due: '.date("Y-m-d", strtotime($a_date_end)).'</td>
            		<td class="child_2">';
            			if (!empty($a_file)) {
                        	$filesL9 = $a_file;
                        	$fileExtension = fileExtension($filesL9);
                        	$src = $fileExtension['src'];
                        	$embed = $fileExtension['embed'];
                        	$type = $fileExtension['type'];
                        	$file_extension = $fileExtension['file_extension'];
                        	$url = $base_url.'../MyPro_Folder_Files/';
                        	
            				$response .= '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            					<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            					<span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
            				</a>';
            			} else {
            				$response .= '<a style="color:#fff;" href="javascript:;" class="btn btn-link">
            					<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            					<span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
            				</a>';
            			}
            		$response .= '</td>
            		<td class="child_2" style="min-width:80px;">
            		    <a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$a_ID.')">
        					<i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
        					<span class="badge" style="margin-left:-7px;background-color:'; if($c_counts == 0) { $response .= '#DC3535'; } else { $response .= 'blue'; } $response .= ';">
        						<b>'.$c_counts.'</b>
        					</span>
        				</a>
        			</td>
            		<td class="child_2" style="min-width:100px;">
            	        <a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGetHistory_Child2b" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$a_ID.')">Add</a>
            	        <a style="font-weight:800;color:#fff;" href="#modalGet_child2b" data-toggle="modal" class="btn red btn-xs" onclick="onclick_2('.$a_ID.')">Edit</a>
                    </td>
            	</tr>';
                
                $response .= subChild($view_id, $data1, $a_ID);
            }
    	}
    	
    	if($_POST['key'] == 'child_two4'){
            //layer 2
            $data1 = $_POST['get_id'];
            $view_id = $_POST['view_id'];
            
            $sql2 = $conn->query("
                SELECT 
                a.CAI_id AS a_ID,
                a.CIA_Indent_Id AS a_subchild,
                u.first_name AS u_first_name,
                a.CAI_filename AS a_name,
                a.CAI_description AS a_description,
                a.CAI_Accounts AS a_account,
                i.Action_Items_name AS i_name,
                e.first_name AS e_first_name,
                CASE 
                	WHEN a.CIA_progress = 2 THEN 'Completed'
                    WHEN a.CIA_progress = 1 THEN 'Inprogress'
                    ELSE 'Not Started'
                END AS a_status,
                a.CAI_Rendered_Minutes AS a_rendered,
                CASE WHEN a.CIA_progress = 2 THEN '100' ELSE '' END AS a_percentage,
                a.CAI_Action_date AS a_date_start,
                a.CAI_Action_due_date AS a_date_end,
                a.CAI_files AS a_file,
                COUNT(c.Task_ids) AS c_counts,
                COUNT(a2.CAI_id) AS a2_counts
                
                FROM tbl_MyProject_Services_Childs_action_Items  AS a
                
                LEFT JOIN (
                	SELECT
                    ID,
                    first_name
                    FROM tbl_user
                ) AS u
                ON a.CAI_User_PK = u.ID
                
                LEFT JOIN (
                	SELECT
                    ID,
                    first_name
                    FROM tbl_hr_employee
                ) AS e
                ON a.CAI_Assign_to = e.ID
                
                LEFT JOIN (
                	SELECT
                    Action_Items_id,
                    Action_Items_name
                    FROM tbl_MyProject_Services_Action_Items
                ) AS i
                ON a.CAI_Action_taken = i.Action_Items_id
                
                LEFT JOIN (
                	SELECT
                    Task_ids
                    FROM tbl_MyProject_Services_Comment
                ) AS c
                ON a.CAI_id = c.Task_ids
    
                LEFT JOIN (
                	SELECT
                    CAI_id,
                    CIA_Indent_Id
                    FROM tbl_MyProject_Services_Childs_action_Items
                	WHERE is_deleted = 0
                    AND Parent_MyPro_PK = $view_id 
                    AND Services_History_PK = $data1
                ) AS a2
                ON a.CAI_id = a2.CIA_Indent_Id
                
                WHERE a.is_deleted = 0
                AND a.Parent_MyPro_PK = $view_id 
                AND a.Services_History_PK = $data1
                AND a.CIA_Indent_Id = $data1
                
                GROUP BY a.CAI_id
            ");
            while($data2 = $sql2->fetch_array()) {
                $a_ID = $data2['a_ID'];
                $a_subchild = $data2['a_subchild'];
                $u_first_name = htmlentities($data2['u_first_name'] ?? '' );
                $a_name = htmlentities($data2['a_name'] ?? '' );
                $a_description = htmlentities($data2['a_description'] ?? '' );
                $a_account = htmlentities($data2['a_account'] ?? '' );
                $i_name = htmlentities($data2['i_name'] ?? '' );
                $e_first_name = htmlentities($data2['e_first_name'] ?? '' );
                $a_status = $data2['a_status'];
                $a_rendered = $data2['a_rendered'];
                $a_percentage = $data2['a_percentage'];
                $a_date_start = $data2['a_date_start'];
                $a_date_end = $data2['a_date_end'];
                $a_file = $data2['a_file'];
                $c_counts = $data2['c_counts'];
                
                $response .= '<tr id="sub_two_'.$a_ID.'">
            		<td id="'.$a_ID.'" class="child_border" width="50px">'.$a_ID.'</td>
            		<td class="child_2">From: '.$u_first_name.'</td>
            		<td class="child_2">';
            			$stringProduct = strip_tags($a_name); 
            			if(strlen($stringProduct) > 40) {
            				$stringCut = substr($stringProduct,0,40);
            				$endPoint = strrpos($stringCut,' ');
            				$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
            				$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub2" data-toggle="modal" onclick="get_moreDetails_sub2('.$a_ID.')"><i style="color:black;">More...</i></a>';
            			}
            			$response .= "$stringProduct";
            		$response .= '</td>
            		<td class="child_2" >';
            			$stringProduct = strip_tags($a_description); 
            			if(strlen($stringProduct) > 35) {
            				$stringCut = substr($stringProduct,0,35);
            				$endPoint = strrpos($stringCut,' ');
            				$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
            				$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$a_ID.')"><i style="color:black;">More...</i></a>';
            			}
            			$response .= "$stringProduct";
            		$response .= '</td>
            		<td class="child_2">'.$a_account.'</td>
            		<td class="child_2">'.$i_name.'</td>
            		<td class="child_2">Assign to: '.$e_first_name.'</td>
            		<td class="child_2"><b>'.$a_status.'</b></td>';
            		
            		if(!empty($a_rendered)){
            			$response .= '<td class="child_2">Rendered: '.$a_rendered.' minute(s)';
            		}
            		if(!empty($a_percentage)){
            			$response .= '<td class="child_2">'.$a_percentage.'%</td>';
            		}
            		
            		$response .= '<td class="child_2">Start: '.date("Y-m-d", strtotime($a_date_start)).'</td>
            		<td class="child_2">Due: '.date("Y-m-d", strtotime($a_date_end)).'</td>
            		<td class="child_2">';
            			if (!empty($a_file)) {
                        	$filesL9 = $a_file;
                        	$fileExtension = fileExtension($filesL9);
                        	$src = $fileExtension['src'];
                        	$embed = $fileExtension['embed'];
                        	$type = $fileExtension['type'];
                        	$file_extension = $fileExtension['file_extension'];
                        	$url = $base_url.'../MyPro_Folder_Files/';
                        	
            				$response .= '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            					<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            					<span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
            				</a>';
            			} else {
            				$response .= '<a style="color:#fff;" href="javascript:;" class="btn btn-link">
            					<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            					<span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
            				</a>';
            			}
            		$response .= '</td>
            		<td class="child_2" style="min-width:80px;">
            		    <a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$a_ID.')">
        					<i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
        					<span class="badge" style="margin-left:-7px;background-color:'; if($c_counts == 0) { $response .= '#DC3535'; } else { $response .= 'blue'; } $response .= ';">
        						<b>'.$c_counts.'</b>
        					</span>
        				</a>
        			</td>
            		<td class="child_2" style="min-width:100px;">
            	        <a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGetHistory_Child2b" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$a_ID.')">Add</a>
            	        <a style="font-weight:800;color:#fff;" href="#modalGet_child2b" data-toggle="modal" class="btn red btn-xs" onclick="onclick_2('.$a_ID.')">Edit</a>
                    </td>
            	</tr>';
            	
            	if ($data2['a2_counts'] > 0) {
                    $response .= subChild($view_id, $data1, $a_ID);
            	}
            }
    	}
    	
    	if($_POST['key'] == 'child_two'){
            //layer 2
            $data1 = $_POST['get_id'];
            $view_id = $_POST['view_id'];
            
            $sql2 = $conn->query("
                WITH RECURSIVE cte (TreeLevel, path, a_ID, a_parent_id, a_parent, a_user, a_name, a_description, a_account, a_item, a_assign, a_status, a_rendered, a_date_start, a_date_end, a_file) AS
                (
                    SELECT
                    0 AS TreeLevel,
                    CAST(a.CAI_id AS CHAR(255)) AS path,
                    -- a.CAI_id AS path,
                    -- CONCAT(a.CAI_id,'') AS path,
                    a.CAI_id AS a_ID,
                    a.Parent_MyPro_PK AS a_parent_id,
                    a.CIA_Indent_Id AS a_parent,
                    a.CAI_User_PK AS a_user,
                    a.CAI_filename AS a_name,
                    a.CAI_description AS a_description,
                    a.CAI_Accounts AS a_account,
                    a.CAI_Action_taken AS a_item,
                    a.CAI_Assign_to AS a_assign,
                    a.CIA_progress AS a_status,
                    a.CAI_Rendered_Minutes AS a_rendered,
                    a.CAI_Action_date AS a_date_start,
                    a.CAI_Action_due_date AS a_date_end,
                    a.CAI_files AS a_file
                    FROM tbl_MyProject_Services_Childs_action_Items  AS a
                    WHERE a.is_deleted = 0
                    AND a.Parent_MyPro_PK = $view_id 
                    AND a.Services_History_PK = $data1
                    AND a.CIA_Indent_Id = $data1
                    
                    UNION ALL
                
                    SELECT 
                    cte.TreeLevel+1 AS TreeLevel,
                    CONCAT(cte.path, '.', CONCAT(a2.CAI_id,'')) AS path,
                    -- cte.path+a2.CAI_id AS path,
                    -- CONCAT(cte.path, '.', CONCAT(a2.CAI_id,'')) AS path,
                    a2.CAI_id AS a_ID,
                    a2.Parent_MyPro_PK AS a_parent_id,
                    a2.CIA_Indent_Id AS a_parent,
                    a2.CAI_User_PK AS a_user,
                    a2.CAI_filename AS a_name,
                    a2.CAI_description AS a_description,
                    a2.CAI_Accounts AS a_account,
                    a2.CAI_Action_taken AS a_item,
                    a2.CAI_Assign_to AS a_assign,
                    a2.CIA_progress AS a_status,
                    a2.CAI_Rendered_Minutes AS a_rendered,
                    a2.CAI_Action_date AS a_date_start,
                    a2.CAI_Action_due_date AS a_date_end,
                    a2.CAI_files AS a_file
                    FROM tbl_MyProject_Services_Childs_action_Items  AS a2
                    
                    INNER JOIN cte ON cte.a_ID = a2.CIA_Indent_Id
                    
                    WHERE a2.is_deleted = 0
                    AND a2.Parent_MyPro_PK = $view_id 
                    AND a2.Services_History_PK = $data1
                )
                SELECT 
                TreeLevel, path, a_ID, a_parent_id, a_parent, a_user, a_name, a_description, a_account, a_item, a_assign, a_status, a_rendered, a_date_start, a_date_end, a_file,
                u.first_name AS u_first_name,
                i.Action_Items_name AS i_name,
                e.first_name AS e_first_name,
                CASE 
                	WHEN a_status = 2 THEN 'Completed'
                    WHEN a_status = 1 THEN 'Inprogress'
                    ELSE 'Not Started'
                END AS a_statuses,
                CASE WHEN a_status = 2 THEN '100' ELSE '' END AS a_percentage,
                COUNT(c.Task_ids) AS c_counts
                FROM cte
                
                LEFT JOIN (
                	SELECT
                    ID,
                    first_name
                    FROM tbl_user
                ) AS u
                ON a_user = u.ID
                
                LEFT JOIN (
                	SELECT
                    ID,
                    first_name
                    FROM tbl_hr_employee
                ) AS e
                ON a_assign = e.ID
                
                LEFT JOIN (
                	SELECT
                    Action_Items_id,
                    Action_Items_name
                    FROM tbl_MyProject_Services_Action_Items
                ) AS i
                ON a_item = i.Action_Items_id
                
                LEFT JOIN (
                	SELECT
                    Task_ids
                    FROM tbl_MyProject_Services_Comment
                ) AS c
                ON a_ID = c.Task_ids
        
                GROUP BY a_ID
                
                -- ORDER BY a_ID, a_parent
                ORDER BY cast(substring_index(path,'.',1) as unsigned),
                cast(substring_index(substring_index(path,'.',2),'.',-1) as unsigned),
                cast(substring_index(substring_index(path,'.',3),'.',-1) as unsigned),
                cast(substring_index(substring_index(path,'.',4),'.',-1) as unsigned),
                cast(substring_index(substring_index(path,'.',5),'.',-1) as unsigned),
                cast(substring_index(substring_index(path,'.',6),'.',-1) as unsigned),
                cast(substring_index(substring_index(path,'.',7),'.',-1) as unsigned)
            ");
            while($data2 = $sql2->fetch_array()) {
                $a_ID = $data2['a_ID'];
                $a_parent_id = $data2['a_parent_id'];
                $TreeLevel = $data2['TreeLevel'];
                $a_parent = $data2['a_parent'];
                $u_first_name = htmlentities($data2['u_first_name'] ?? '' );
                $a_name = htmlentities($data2['a_name'] ?? '' );
                $a_description = htmlentities($data2['a_description'] ?? '' );
                $a_account = htmlentities($data2['a_account'] ?? '' );
                $i_name = htmlentities($data2['i_name'] ?? '' );
                $e_first_name = htmlentities($data2['e_first_name'] ?? '' );
                $a_status = $data2['a_statuses'];
                $a_rendered = $data2['a_rendered'];
                $a_percentage = $data2['a_percentage'];
                $a_date_start = $data2['a_date_start'];
                $a_date_end = $data2['a_date_end'];
                $a_file = $data2['a_file'];
                $c_counts = $data2['c_counts'];
                
                $response .= '<tr id="sub_two_'.$a_ID.'">
            		<td id="'.$a_ID.'" class="child_border" width="50px">'.$a_ID.'</td>';
            		
            		if ($TreeLevel > 0) {
                		$response .= '<td class="child_border" colspan="'.$TreeLevel.'"></td>';
            		}
            		
            		$response .= '<td class="child_2">From: '.$u_first_name.'</td>
            		<td class="child_2">';
            			$stringProduct = strip_tags($a_name); 
            			if(strlen($stringProduct) > 40) {
            				$stringCut = substr($stringProduct,0,40);
            				$endPoint = strrpos($stringCut,' ');
            				$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
            				$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail_sub2" data-toggle="modal" onclick="get_moreDetails_sub2('.$a_ID.')"><i style="color:black;">More...</i></a>';
            			}
            			$response .= "$stringProduct";
            		$response .= '</td>
            		<td class="child_2" >';
            			$stringProduct = strip_tags($a_description); 
            			if(strlen($stringProduct) > 35) {
            				$stringCut = substr($stringProduct,0,35);
            				$endPoint = strrpos($stringCut,' ');
            				$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
            				$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$a_ID.')"><i style="color:black;">More...</i></a>';
            			}
            			$response .= "$stringProduct";
            		$response .= '</td>
            		<td class="child_2">'.$a_account.'</td>
            		<td class="child_2">'.$i_name.'</td>
            		<td class="child_2">Assign to: '.$e_first_name.'</td>
            		<td class="child_2"><b>'.$a_status.'</b></td>';
            		
            		if(!empty($a_rendered)){
            			$response .= '<td class="child_2">Rendered: '.$a_rendered.' minute(s)';
            		}
            		if(!empty($a_percentage)){
            			$response .= '<td class="child_2">'.$a_percentage.'%</td>';
            		}
            		
            		$response .= '<td class="child_2">Start: '.date("Y-m-d", strtotime($a_date_start)).'</td>
            		<td class="child_2">Due: '.date("Y-m-d", strtotime($a_date_end)).'</td>
            		<td class="child_2">';
            			if (!empty($a_file)) {
                        	$filesL9 = $a_file;
                        	$fileExtension = fileExtension($filesL9);
                        	$src = $fileExtension['src'];
                        	$embed = $fileExtension['embed'];
                        	$type = $fileExtension['type'];
                        	$file_extension = $fileExtension['file_extension'];
                        	$url = $base_url.'../MyPro_Folder_Files/';
                        	
            				$response .= '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            					<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            					<span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
            				</a>';
            			} else {
            				$response .= '<a style="color:#fff;" href="javascript:;" class="btn btn-link">
            					<i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
            					<span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
            				</a>';
            			}
            		$response .= '</td>
            		<td class="child_2" style="min-width:80px;">
            		    <a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$a_ID.')">
        					<i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
        					<span class="badge" style="margin-left:-7px;background-color:'; if($c_counts == 0) { $response .= '#DC3535'; } else { $response .= 'blue'; } $response .= ';">
        						<b>'.$c_counts.'</b>
        					</span>
        				</a>
        			</td>
            		<td class="child_2" style="min-width:100px;">
            	        <a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGetHistory_Child2b" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$a_ID.')">Add</a>
            	        <a style="font-weight:800;color:#fff;margin-right:3px;" href="#modalGet_child2b" data-toggle="modal" class="btn yellow btn-xs" onclick="onclick_2('.$a_ID.')">Edit</a>';
            	        if($_COOKIE['ID'] == 456 || $_COOKIE['ID'] == 43 ): 
            	            $response .= '<a style="font-weight:800;color:#fff;" class="btn red btn-xs remove-mypro" data-key="'.$a_parent_id.'" data-table="tbl_MyProject_Services_Childs_action_Items" data-id="'.$a_ID.'">Delete</a>';
            	        endif;
                        $response .= '
                    </td>
            	</tr>';
            }
    	}
    	exit($response);
    }
    
    	// modal Get Status
    if( isset($_GET['modal_filter_status']) ) {
    	$ID = $_GET['modal_filter_status'];
    
    	echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
    	echo '
            <table class="table table-bordered " id="tableData2">
                <thead class="bg-info">
                    <tr>
                        <th>Assign to</th>
                        <th>Task Name</th>
                        <th>Description</th>
                        <th>Desired Due Date</th>
                    </tr>
                </thead>
                 <tbody>';
            $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CIA_progress = 0 and Parent_MyPro_PK = $ID order by CAI_id DESC";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
             { 
                echo '
                    <tr>
                    <td>
                        '; 
                            $emp_id =$row['CAI_Assign_to'];
                            $query_emp = "SELECT * FROM tbl_hr_employee where ID = $emp_id";
                            $result_emp = mysqli_query($conn, $query_emp);
                            while($row_emp = mysqli_fetch_array($result_emp))
                             {
                                 echo $row_emp['first_name'];
                             }
                            echo'
                        </td>
                        <td>'.$row['CAI_filename'].'</td>
                        <td>'.$row['CAI_description'].'</td>
                        <td>'.$row['CAI_Action_date'].'</td>
                    </tr>
                    ';
             }
             echo '
                </tbody>
             </table>';
             
        }
        
    if( isset($_GET['modal_filter_status_progress']) ) {
    	$ID = $_GET['modal_filter_status_progress'];
    
    	echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
    	echo '
            <table class="table table-bordered " id="sample_1">
                <thead class="bg-info">
                    <tr>
                        <th>Assign to</th>
                        <th>Task Name</th>
                        <th>Description</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                 <tbody>';
            $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CIA_progress = 1 and Parent_MyPro_PK = $ID order by CAI_Action_due_date ASC";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
             { 
                echo '
                    <tr>
                    <td>
                        '; 
                            $emp_id =$row['CAI_Assign_to'];
                            $query_emp = "SELECT * FROM tbl_hr_employee where ID = $emp_id";
                            $result_emp = mysqli_query($conn, $query_emp);
                            while($row_emp = mysqli_fetch_array($result_emp))
                             {
                                 echo $row_emp['first_name'];
                             }
                            echo'
                        </td>
                        <td>'.$row['CAI_filename'].'</td>
                        <td>'.$row['CAI_description'].'</td>
                        <td>'.$row['CAI_Action_due_date'].'</td>
                    </tr>
                    ';
             }
             echo '
                </tbody>
             </table>';
             
        }
    
    if( isset($_GET['modal_filter_status_completed']) ) {
    $ID = $_GET['modal_filter_status_completed'];
    
    echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
    echo '
        <table class="table table-bordered " id="sample_4">
            <thead class="bg-info">
                <tr>
                    <th>Assign to</th>
                    <th>Task Name</th>
                    <th>Description</th>
                    <th>Date Completed</th>
                </tr>
            </thead>
             <tbody>';
        $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CIA_progress = 2 and Parent_MyPro_PK = $ID order by Date_Completed DESC";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
         { 
            echo '
                <tr>
                <td>
                    '; 
                        $emp_id =$row['CAI_Assign_to'];
                        $query_emp = "SELECT * FROM tbl_hr_employee where ID = $emp_id";
                        $result_emp = mysqli_query($conn, $query_emp);
                        while($row_emp = mysqli_fetch_array($result_emp))
                         {
                             echo $row_emp['first_name'];
                         }
                        echo'
                        </td>
                    <td>'.$row['CAI_filename'].'</td>
                    <td>'.$row['CAI_description'].'</td>
                    <td>'.$row['Date_Completed'].'</td>
                </tr>
                ';
         }
         echo '
            </tbody>
         </table>';
         
    }
    
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
    $(document).ready(function () {
            $('#tableData2').DataTable();
    });
</script>
