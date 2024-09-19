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


if(isset($_GET['post_id2'])){
	$post_id = $_GET['post_id'];
	$h_id = $_GET['h_id'];
	$response = "";
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
if(isset($_GET['post_id'])){
	$post_id = $_GET['post_id'];
	$h_id = $_GET['h_id'];
	$response = "";
	
	if($_POST['key'] == 'child_two'){
        //layer 2
        $data1 = $_POST['get_id'];
        $view_id = $_POST['view_id'];
        
        $sql2 = $conn->query("
            WITH RECURSIVE cte (TreeLevel, path, a_ID, a_parent, a_user, a_name, a_description, a_account, a_item, a_assign, a_status, a_rendered, a_date_start, a_date_end, a_file) AS
            (
                SELECT
                0 AS TreeLevel,
                CAST(a.CAI_id AS CHAR(255)) AS path,
                -- a.CAI_id AS path,
                -- CONCAT(a.CAI_id,'') AS path,
                a.CAI_id AS a_ID,
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
                AND a.CAI_Assign_to = $post_id
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
                AND a2.CAI_Assign_to = $post_id
                AND a2.Parent_MyPro_PK = $view_id 
                AND a2.Services_History_PK = $data1
            )
            SELECT 
            TreeLevel, path, a_ID, a_parent, a_user, a_name, a_description, a_account, a_item, a_assign, a_status, a_rendered, a_date_start, a_date_end, a_file,
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
        if ( mysqli_num_rows($sql2) > 0 ) {
            while($data2 = $sql2->fetch_array()) {
                $a_ID = $data2['a_ID'];
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
            		<td class="child_2">Assign tos: '.$e_first_name.'</td>
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
            }
        }
	}
	exit($response);
}
?>