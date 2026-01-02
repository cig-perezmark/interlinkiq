<?php 
    $title = "My Pro";
    $site = "MyPro";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';
    $base_url = "https://interlinkiq.com/";
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
    
    
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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-earphones-alt font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase"><a href="https://interlinkiq.com/MyPro.php#tab_Me">My Pro</a></span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_Dashboard" data-toggle="tab"> Dashboard </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_Dashboard">
                                            <!--<h3>Dashboard &nbsp;<a class="btn btn-primary" data-toggle="modal" href="#addNew"> Create Project</a></h3>-->
                                                            <?php
                                                             $i_user = $_COOKIE['ID'];
                                                             $myProMain = $_GET['view_id'];
                                                            $queryMain = "SELECT *  FROM tbl_MyProject_Services left join tbl_MyProject_Services_Assigned on MyPro_PK = MyPro_id where MyPro_id = $myProMain";
                                                            $resultMain = mysqli_query($conn, $queryMain);
                                                                                        
                                                            while($rowMain = mysqli_fetch_array($resultMain))
                                                            {?>
                                                                    <table class="table bg-primary">
                                                                        <thead>
                                                                            <tr style="color:#fff;font-size:16px;font-weight:800;">
                                                                                
                                                                                <th>
                                                                                    Ticket#
                                                                                </th>
                                                                                <th>
                                                                                    Project Name
                                                                                </th>
                                                                                <th>
                                                                                    Description
                                                                                </th>
                                                                                <th>
                                                                                   Request Date
                                                                                </th>
                                                                                <th>
                                                                                    Due Date
                                                                                </th>
                                                                                <th>
                                        
                                                                                </th>
                                                                                <th>
                                        
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td> <?php echo 'No.: '; echo $rowMain['MyPro_id']; ?></td>
                                                                                <td><?php echo $rowMain['Project_Name']; ?></td>
                                                                                <td><?php echo $rowMain['Project_Description']; ?></td>
                                                                                <td><?php echo date("Y-m-d", strtotime($rowMain['Start_Date'])); ?></td>
                                                                                <td><?php echo date("Y-m-d", strtotime($rowMain['Desired_Deliver_Date'])); ?></td>
                                                                                <td>
                                                                                    
                                                                                    
                                                                                </td>
                                                                                <td>
                                                                                    <a style="color:#fff;" href="#modalAddActionItem" data-toggle="modal" class="btn green btn-outline btn-xs" onclick="btnNew_File(<?php echo  $rowMain['MyPro_id']; ?>)">New Action Item</a>
                                                                                    <a style="color:#fff;" class="btn blue btn-outline btn-xs btnViewMyPro_update" data-toggle="modal" href="#modalGetMyPro_update" data-id="<?php echo $rowMain["MyPro_id"]; ?>">View</a>
                                                                                    <a style="font-weight:800;color:#fff;" href="#modalGet_Notification" data-toggle="modal" class="btn green btn-xs" onclick="btnNew_Notification(<?php echo  $rowMain['MyPro_id']; ?>)">
                                                                                        <i class="fa fa-envelope"></i> Mail
                                                                                    </a>
                                                                                    <a style="font-weight:800;color:#fff;" href="#modalGet_history_Notification" data-toggle="modal" class="btn red btn-xs" onclick="btnHistory_Notification(<?php echo  $rowMain['MyPro_id']; ?>)">
                                                                                            History
                                                                                        </a>
                                                                                </td>
                                                                            </tr>
                                                                    </table>
                                                            <?php } ?>
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <td>
                                                                            <?php
                                                                                $project_id = $_GET['view_id'];
                                                                                $Not_started = 1;
                                                                                $select_NS = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CIA_progress = 0 and Parent_MyPro_PK = $project_id" );
                                                        					    while($row_NS = mysqli_fetch_array($select_NS)) {  $count_NS = $Not_started++;  } ?>
                                                        					   <b>Not Started <i style="color:#C0B236;">(<?php if(!empty($count_NS)){echo $count_NS;}else{echo '0';} ?>)</i></b>
                                                        					 </td>
                                                                            <td>
                                                                                <?php
                                                                                $project_id = $_GET['view_id'];
                                                                                $inprogress = 1;
                                                                                $select_in = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CIA_progress = 1 and Parent_MyPro_PK = $project_id" );
                                                        					    while($row_in = mysqli_fetch_array($select_in)) {  $count_in = $inprogress++;  } ?>
                                                                                <b>In-Progress <i style="color:#D36B00;">(<?php if(!empty($count_in)){echo $count_in;}else{echo '0';} ?>)</i>
                                                                            </b>
                                                                           
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $project_id = $_GET['view_id'];
                                                                                $Completed = 1;
                                                                                $select_Completed = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CIA_progress = 2 and Parent_MyPro_PK = $project_id" );
                                                        					    while($row_Completed = mysqli_fetch_array($select_Completed)) {  $count_Completed = $Completed++;  } ?>
                                                                                <b>Completed <i class="completed">(<?php if(!empty($count_Completed)){ echo $count_Completed;}else{echo '0';} ?>)</i></b>
                                                                            </td>
                                                                            <td></td>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                              
                                                            <div id="overflowTable">
                                                                
                                                                    <!--<div class="table-scrollable">-->
                                                                    <table class="table-bordered" style="border:solid #fff 1px;" id="tblHistory">
                                                                        <tbody>
                                                                        <?php
                                                                            
                                                                            // layer 1
                                                                            $indent_a = 1;
                                                                            $indent_break = 1;
                                                                            $project_id = $_GET['view_id'];
                                                                            $myPro = $_GET['view_id'];
                                                    		                $selectFile = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_History left join tbl_MyProject_Services_Action_Items on Action_Items_id = Action_taken
                                                    		                left join tbl_hr_employee on Assign_to_history = ID left join tbl_user on employee_id = tbl_hr_employee.ID
                                                    		                WHERE MyPro_PK = '$myPro'" );
                                                    				        if ( mysqli_num_rows($selectFile) > 0 ) {
                                                    					        while($rowFile = mysqli_fetch_array($selectFile)) { 
                                                                                    $files = $rowFile["files"];
                                                                                    $fileExtension = fileExtension($files);
                                                    								$src = $fileExtension['src'];
                                                    								$embed = $fileExtension['embed'];
                                                    								$type = $fileExtension['type'];
                                                    								$file_extension = $fileExtension['file_extension'];
                                                    					           $url = $base_url.'MyPro_Folder_Files/';
                                                    					           $parentcolor = '#084594';
                                                    					           $childcolor1 = '#42855B';
                                                    					        ?>
                                                    					        	<tr id="<?php echo $rowFile["History_id"]; ?>" style="background-color:<?php echo $parentcolor; ?>;color:#fff;hover:black;" class="parentTbls">
                                                    					        	    <td><?php echo $rowFile["History_id"];
                                                    					        	    //echo $indent = $indent_a++;?></td>
                                                                                        <td class="paddId">
                                                    					        	        Assign to: <?php echo $rowFile["first_name"]; ?></td>
                                                                                        <td class="paddId"><?php echo $rowFile["filename"]; ?></td>
                                                                                        <td class="paddId"><?php echo $rowFile["description"]; ?></td>
                                                                                        <td class="paddId">Estimated: <?php echo $rowFile["Estimated_Time"]; ?> minutes</td>
                                                                                        <td class="paddId"><?php echo $rowFile["Action_Items_name"]; ?></td>
                                                    					        	    <td class="paddId">
                                                    					        	        <a style="color:#fff;" data-src="<?php echo $src.$url.rawurlencode($files).$embed; ?>" data-fancybox data-type="<?php echo $type; ?>" class="btn btn-link">
                                                    					        	        <?php  $ext = pathinfo($files, PATHINFO_EXTENSION); 
                                                    					        	                if($ext == 'pdf'){
                                                    					        	                    echo '<i class="fa fa-file-pdf-o" style="font-size:24px;color:red;"></i>';
                                                    					        	                }
                                                    					        	                else if($ext == 'docx'){
                                                    					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                    					        	                }
                                                    					        	                else if($ext == 'doc'){
                                                    					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                    					        	                }
                                                    					        	                else if($ext == 'csv'){
                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                    					        	                }
                                                    					        	                else if($ext == 'xlsx'){
                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                    					        	                }
                                                    					        	                else if($ext == 'xlsm'){
                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                    					        	                }
                                                    					        	                else if($ext == 'xls'){
                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                    					        	                }
                                                    					        	                else{
                                                    					        	                  echo '<i class="fa fa-file-o" style="font-size:24px;"></i>';
                                                    					        	                }
                                                    					        	            ?>
                                                    					        	            </a>
                                                    					        	    </td>
                                                    					        	    <?php //if($indent_break == $indent): ?>
                                                    					        	    <td>
                                                    					        	    <?php
                                                    					        	      
                                                                    					   ?>
                                                            					        	       
                                                            					        	            
                                                        					        	</td>
                                                    					        	    <?php //endif; ?>
                                                                                        <td>
                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory" data-toggle="modal" class="btn btn-xs blue" onclick="btnNew_History(<?php echo  $rowFile['History_id']; ?>)">Add</a>
                                                                                           <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item_History" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item_History(<?php echo  $rowFile['History_id']; ?>)">View</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php 
                                                                                    // layer 2
                                                    					            $childcolor1 = '#18978F';
                                                    					            $parentcolor = '#1C6758';
                                                    					            $childCount = 1;
                                                    					            $project_id = $_GET['view_id'];
                                                    					            $rand_id = $rowFile["rand_id"];
                                                    					            $parent_id = $rowFile["History_id"];
                                                                                    $selectCAI = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                                                    		                         left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
                                                    		                       WHERE Parent_MyPro_PK = $project_id and CIA_Indent_Id = '$parent_id' and Services_History_PK = '$parent_id' " );
                                                        					        while($rowCAI = mysqli_fetch_array($selectCAI)) { 
                                                        					        
                                                        					        $filesChild = $rowCAI["CAI_files"];
                                                                                    $fileExtension = fileExtension($filesChild);
                                                                                    $src = $fileExtension['src'];
                                                    								$embed = $fileExtension['embed'];
                                                    								$type = $fileExtension['type'];
                                                    								$file_extension = $fileExtension['file_extension'];
                                                                                    
                                                    					           $url = $base_url.'MyPro_Folder_Files/';?>
                                                                                        <tr id="<?php echo $rowCAI["CAI_id"]; ?>" style="border:solid <?php if($rowCAI["CAI_Assign_to"]== $_COOKIE['employee_id']){echo '#083AA9';}else{echo '#fff';} ?> 2px;">
                                                                                             <td><?php echo $rowCAI["CAI_id"]; ?></td>
                                                                                             
                                                                                            <td class="paddId" style="background-color:<?php if($rowCAI['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;"><?php echo  $rowCAI['CAI_filename']; ?></td>
                                                                                            <td class="paddId" style="background-color:<?php if($rowCAI['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;"><?php echo  $rowCAI['Action_Items_name']; ?></td>
                                                                                            <td class="paddId" style="background-color:<?php if($rowCAI['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;"><?php echo  $rowCAI['CAI_description']; ?></td>
                                                                                            
                                                        					        	    <?php
                                                        					        	    if(!empty($rowCAI['CAI_Comment'])){ ?>
                                                        					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                        					        	            <?php echo $rowCAI['CAI_Comment']; ?>
                                                        					        	        </td>
                                                        					        	    <?php } ?>
                                                        					        	    <?php
                                                        					        	    if(!empty($filesChild)){ ?>
                                                        					        	        <td class="paddId" style="background-color:<?php if($rowCAI['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                        					        	        <a style="color:#fff;" data-src="<?php echo $src.$url.rawurlencode($filesChild).$embed; ?>" data-fancybox data-type="<?php echo $type; ?>" class="btn btn-link">
                                                        					        	        <?php  $ext = pathinfo($filesChild, PATHINFO_EXTENSION); 
                                                    					        	                if($ext == 'pdf'){
                                                    					        	                    echo '<i class="fa fa-file-pdf-o" style="font-size:24px;color:red;"></i>';
                                                    					        	                }
                                                    					        	                else if($ext == 'docx'){
                                                    					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                    					        	                }
                                                    					        	                else if($ext == 'doc'){
                                                    					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                    					        	                }
                                                    					        	                else if($ext == 'csv'){
                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                    					        	                }
                                                    					        	                else if($ext == 'xlsx'){
                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                    					        	                }
                                                    					        	                else if($ext == 'xlsm'){
                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                    					        	                }
                                                    					        	                else if($ext == 'xls'){
                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                    					        	                }
                                                    					        	                else{
                                                    					        	                  echo '<i class="fa fa-file-o" style="font-size:24px;"></i>';
                                                    					        	                }
                                                    					        	            ?>
                                                        					        	        </a>
                                                        					        	        </td>
                                                        					        	    <?php } ?>
                                                                                            <td class="paddId" style="background-color:<?php if($rowCAI['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">Assign to: <?php echo  $rowCAI['first_name']; ?></td>
                                                        					        	    <td class="paddId" style="background-color:<?php if($rowCAI['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                        					        	            <?php 
                                                            					        	            if($rowCAI['CIA_progress']== 1){ echo '<b class="inprogress">Inprogress</b>'; }
                                                            					        	            else if($rowCAI['CIA_progress']== 2){ echo '<b class="completed">Completed</b>';}
                                                            					        	            else{ echo '<b class="notstarted">Not Started</b>';}
                                                        					        	            ?>
                                                        					        	      </td>
                                                                                            <td class="paddId" style="background-color:<?php if($rowCAI['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">Estimated: <?php echo $rowCAI["CAI_Estimated_Time"]; ?> minutes</td>
                                                        					        	       <?php
                                                            					        	    if(!empty($rowCAI['CAI_Rendered_Minutes'])){ ?>
                                                            					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                            					        	            <?php echo 'Rendered: '; ?>
                                                            					        	            <?php echo $rowCAI['CAI_Rendered_Minutes']; ?>
                                                            					        	            <?php echo 'minute(s)'; ?>
                                                            					        	            
                                                            					        	            <?php if($rowCAI['Service_log_Status'] !=1 && $rowCAI["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                            					        	            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs(<?php echo  $rowCAI['CAI_id']; ?>)">Add logs</a>
                                                            					        	            <?php }else{ ?>
                                                            					        	                <?php if($rowCAI["CAI_Assign_to"] == $_COOKIE['employee_id']): ?>
                                                            					        	                <a style="font-weight:800;color:#fff;" class="btn green btn-xs"><?php echo 'Services Added'; ?></a>
                                                            					        	                <?php endif; ?>
                                                            					        	            <?php } ?>
                                                            					        	            
                                                            					        	        </td>
                                                            					        	    <?php } ?>
                                                            					        	    <?php
                                                            					        	    if($rowCAI['CIA_progress']==2){ ?>
                                                            					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                            					        	            <?php echo '100%'; ?>
                                                            					        	        </td>
                                                            					        	    <?php } ?>
                                                            					        	   <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                    					        	            <?php echo 'Start Date: '; ?>
                                                    					        	            <?php echo date("Y-m-d", strtotime($rowCAI['CAI_Action_date'])); ?>
                                                    					        	            </td>
                                                    					        	            
                                                    					        	            <?php if(!empty($rowCAI['CAI_Action_due_date'])){ ?>
                                                    					        	            <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                    					        	            <?php echo 'Due Date: '; ?>
                                                    					        	            <?php echo date("Y-m-d", strtotime($rowCAI['CAI_Action_due_date'])); ?>
                                                    					        	            </td>
                                                    					        	            <?php } ?>
                                                    					        	            
                                                                                            <td class="paddId" style="background-color:<?php if($rowCAI['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                <a style="font-weight:800;color:#fff;" href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments(<?php echo  $rowCAI['CAI_id']; ?>)">
                                                                                                    <i class="fa fa-comments-o" style="font-size:24px;color:#fff;padding:10px;"></i>
                                                                                                </a>
                                                                                            </td>
                                                                                            <td class="paddId" style="background-color:<?php if($rowCAI['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                <a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child(<?php echo  $rowCAI['CAI_id']; ?>)">Add</a>
                                                                                                <?php if($rowCAI["CAI_Assign_to"] == 0){ ?>
                                                                                                    <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowCAI['CAI_id']; ?>)">Edit</a>
                                                                                                <?php } ?>
                                                                                                 <?php if($rowCAI["CAI_Assign_to"] == $_COOKIE['employee_id'] && $rowCAI["Acceptance_Status"] != 2): ?>
                                                                                                <?php if($rowCAI['Acceptance_Status'] == 1 && $rowCAI["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                                <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowCAI['CAI_id']; ?>)">Edit</a>
                                                                                                <?php } else if($rowCAI["CAI_User_PK"] == $_COOKIE['ID']){ ?>
                                                                                                    <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowCAI['CAI_id']; ?>)">Edit</a>
                                                                                                <?php }else{ ?>
                                                                                                    <a style="font-weight:800;color:#fff;" href="#modalGet_Accept_status" data-toggle="modal" class="btn green btn-xs" onclick="btn_Accept_status(<?php echo  $rowCAI['CAI_id']; ?>)">View</a>
                                                                                                <?php } ?>
                                                                                                
                                                                                            <?php endif; ?>
                                                                                            </td>
                                                                                        </tr>
                                                                                            <?php
                                                                                                // layer 3
                                                                                                $project_id = $_GET['view_id'];
                                                                                                $childLayer2 = $rowCAI['CAI_id'];
                                                                                                $selectLayer3 = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                                                                    		                         left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
                                                                    		                       WHERE Parent_MyPro_PK=$project_id and CIA_Indent_Id = '$childLayer2'" );
                                                                    					        while($rowLayer3 = mysqli_fetch_array($selectLayer3)) {  
                                                                    					        $filesL3 = $rowLayer3["CAI_files"];
                                                                                                $fileExtension = fileExtension($filesL3);
                                                                								$src = $fileExtension['src'];
                                                                								$embed = $fileExtension['embed'];
                                                                								$type = $fileExtension['type'];
                                                                								$file_extension = $fileExtension['file_extension'];
                                                                					           $url = $base_url.'MyPro_Folder_Files/';?>
                                                                                                <tr id="<?php echo $rowLayer3["CAI_id"]; ?>"  class="parentTbls" style="border:solid <?php if($rowLayer3["CAI_Assign_to"]== $_COOKIE['employee_id']){echo '#083AA9';}else{echo '#fff';} ?> 2px;">
                                                                                                    <td><?php echo $rowLayer3["CAI_id"]; ?></td>
                                                                                                    <td></td>
                                                                                                    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer3["CAI_filename"]; ?></td>
                                                                                                    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer3["Action_Items_name"]; ?></td>
                                                                                                    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer3["CAI_description"]; ?></td>
                                                                					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                					        	        <a style="color:#fff;" data-src="<?php echo $src.$url.rawurlencode($filesL3).$embed; ?>" data-fancybox data-type="<?php echo $type; ?>" class="btn btn-link">
                                                                					        	            <?php  $ext = pathinfo($filesL3, PATHINFO_EXTENSION); 
                                                                					        	                if($ext == 'pdf'){
                                                                					        	                    echo '<i class="fa fa-file-pdf-o" style="font-size:24px;color:red;"></i>';
                                                                					        	                }
                                                                					        	                else if($ext == 'docx'){
                                                                					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                					        	                }
                                                                					        	                else if($ext == 'doc'){
                                                                					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                					        	                }
                                                                					        	                else if($ext == 'csv'){
                                                                					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                					        	                }
                                                                					        	                else if($ext == 'xlsx'){
                                                                					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                					        	                }
                                                                					        	                else if($ext == 'xlsm'){
                                                                					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                					        	                }
                                                                					        	                else if($ext == 'xls'){
                                                                					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                					        	                }
                                                                					        	                else{
                                                                					        	                  echo '<i class="fa fa-file-o" style="font-size:24px;"></i>';
                                                                					        	                }
                                                                					        	            ?>
                                                                					        	        </a>
                                                                					        	    </td>
                                                                					        	  <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"> Assign to: <?php echo $rowLayer3["first_name"]; ?></td>
                                                                					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                					        	            <?php 
                                                                    					        	            if($rowLayer3['CIA_progress']== 1){ echo '<b class="inprogress">Inprogress</b>'; }
                                                                    					        	            else if($rowLayer3['CIA_progress']== 2){ echo '<b class="completed">Completed</b>';}
                                                                    					        	            else{ echo '<b class="notstarted">Not Started</b>';}
                                                                					        	            ?>
                                                                					        	      </td>
                                                                                                    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">Estimated: <?php echo $rowLayer3["CAI_Estimated_Time"]; ?> minutes</td>
                                                                					        	      <?php
                                                                    					        	    if(!empty($rowLayer3['CAI_Rendered_Minutes'])){ ?>
                                                                    					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                    					        	            <?php echo 'Rendered: '; ?>
                                                                    					        	            <?php echo $rowLayer3['CAI_Rendered_Minutes']; ?>
                                                                    					        	            <?php echo 'minute(s)'; ?>
                                                                    					        	            
                                                                    					        	            <?php if($rowLayer3['Service_log_Status'] !=1 && $rowLayer3["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                    					        	            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs(<?php echo  $rowLayer3['CAI_id']; ?>)">Add logs</a>
                                                                    					        	            <?php }else{ ?>
                                                                    					        	                <?php if($rowLayer3["CAI_Assign_to"] == $_COOKIE['employee_id']): ?>
                                                                    					        	                <a style="font-weight:800;color:#fff;" class="btn green btn-xs"><?php echo 'Services Added'; ?></a>
                                                                    					        	                <?php endif; ?>
                                                                    					        	            <?php } ?>
                                                                    					        	            
                                                                    					        	        </td>
                                                                    					        	    <?php } ?>
                                                                    					        	    <?php
                                                                    					        	    if($rowLayer3['CIA_progress']==2){ ?>
                                                                    					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                    					        	            <?php echo '100%'; ?>
                                                                    					        	        </td>
                                                                    					        	    <?php } ?>
                                                                    					        	   <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                					        	            <?php echo 'Start Date: '; ?>
                                                                					        	            <?php echo date("Y-m-d", strtotime($rowLayer3['CAI_Action_date'])); ?>
                                                                					        	        </td>
                                                                					        	        
                                                                					        	        <?php if(!empty($rowLayer3['CAI_Action_due_date'])){ ?>
                                                            					        	            <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                            					        	            <?php echo 'Due Date: '; ?>
                                                            					        	            <?php echo date("Y-m-d", strtotime($rowLayer3['CAI_Action_due_date'])); ?>
                                                            					        	            </td>
                                                            					        	            <?php } ?>
                                                            					        	            
                                                                                                   <td class="paddId" style="background-color:<?php if($rowLayer3['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                        <a style="font-weight:800;color:#fff;" href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments(<?php echo  $rowLayer3['CAI_id']; ?>)">
                                                                                                            <i class="fa fa-comments-o" style="font-size:24px;color:#fff;padding:10px;"></i>
                                                                                                        </a>
                                                                                                    </td>
                                                                                                    <td class="paddId" style="background-color:<?php if($rowLayer3['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                        
                                                                                                        <a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child(<?php echo  $rowLayer3['CAI_id']; ?>)">Add</a>
                                                                                                        <?php if($rowLayer3["CAI_Assign_to"] == 0){ ?>
                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer3['CAI_id']; ?>)">Edit</a>
                                                                                                        <?php } ?>
                                                                                                         <?php if($rowLayer3["CAI_Assign_to"] == $_COOKIE['employee_id'] && $rowLayer3["Acceptance_Status"] != 2): ?>
                                                                                                        <?php if($rowLayer3['Acceptance_Status'] == 1 && $rowLayer3["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                                        <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer3['CAI_id']; ?>)">Edit</a>
                                                                                                        <?php } else if($rowLayer3["CAI_User_PK"] == $_COOKIE['ID']){ ?>
                                                                                                        <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer3['CAI_id']; ?>)">Edit</a>
                                                                                                        <?php }else{ ?>
                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGet_Accept_status" data-toggle="modal" class="btn green btn-xs" onclick="btn_Accept_status(<?php echo  $rowLayer3['CAI_id']; ?>)">View</a>
                                                                                                        <?php } ?>
                                                                                                    <?php endif; ?>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                  <?php
                                                                                                        // layer 4
                                                                                                        $project_id = $_GET['view_id'];
                                                                                                        $childLayer3 = $rowLayer3['CAI_id'];
                                                                                                        $selectLayer4 = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                                                                            		                         left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
                                                                            		                       WHERE Parent_MyPro_PK = $project_id and CIA_Indent_Id = '$childLayer3'" );
                                                                                					        while($rowLayer4 = mysqli_fetch_array($selectLayer4)) { 
                                                                                					            $filesL4 = $rowLayer4["CAI_files"];
                                                                                                                $fileExtension = fileExtension($filesL4);
                                                                                								$src = $fileExtension['src'];
                                                                                								$embed = $fileExtension['embed'];
                                                                                								$type = $fileExtension['type'];
                                                                                								$file_extension = $fileExtension['file_extension'];
                                                                                					           $url = $base_url.'MyPro_Folder_Files/';
                                                                                					           ?>
                                                                                					          
                                                                                                            <tr id="<?php echo $rowLayer4["CAI_id"]; ?>"  class="parentTbls" style="border:solid <?php if($rowLayer4["CAI_Assign_to"]== $_COOKIE['employee_id']){echo '#083AA9';}else{echo '#fff';} ?> 2px;">
                                                                                                                <td><?php echo $rowLayer4["CAI_id"]; ?></td>
                                                                                                                <td></td>
                                                                                                                <td></td>
                                                                                                                <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer4["CAI_filename"]; ?></td>
                                                                                                                <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer4["Action_Items_name"]; ?></td>
                                                                                                                <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer4["CAI_description"]; ?></td>
                                                                            					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                            					        	        <a style="color:#fff;" data-src="<?php echo $src.$url.rawurlencode($filesL4).$embed; ?>" data-fancybox data-type="<?php echo $type; ?>" class="btn btn-link">
                                                                            					        	        <?php  $ext = pathinfo($filesL4, PATHINFO_EXTENSION); 
                                                                        					        	                if($ext == 'pdf'){
                                                                        					        	                    echo '<i class="fa fa-file-pdf-o" style="font-size:24px;color:red;"></i>';
                                                                        					        	                }
                                                                        					        	                else if($ext == 'docx'){
                                                                        					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                        					        	                }
                                                                        					        	                else if($ext == 'doc'){
                                                                        					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                        					        	                }
                                                                        					        	                else if($ext == 'csv'){
                                                                        					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                        					        	                }
                                                                        					        	                else if($ext == 'xlsx'){
                                                                        					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                        					        	                }
                                                                        					        	                else if($ext == 'xlsm'){
                                                                        					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                        					        	                }
                                                                        					        	                else if($ext == 'xls'){
                                                                        					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                        					        	                }
                                                                        					        	                else{
                                                                        					        	                  echo '<i class="fa fa-file-o" style="font-size:24px;"></i>';
                                                                        					        	                }
                                                                        					        	            ?>
                                                                            					        	        </a>
                                                                            					        	    </td>
                                                                            					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"> Assign to: <?php echo $rowLayer4["first_name"]; ?></td>
                                                                            					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                            					        	            <?php 
                                                                                					        	            if($rowLayer4['CIA_progress']== 1){ echo '<b class="inprogress">Inprogress</b>'; }
                                                                                					        	            else if($rowLayer4['CIA_progress']== 2){ echo '<b class="completed">Completed</b>';}
                                                                                					        	            else{ echo '<b class="notstarted">Not Started</b>';}
                                                                            					        	            ?>
                                                                            					        	      </td>
                                                                                                                <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">Estimated: <?php echo $rowLayer4["CAI_Estimated_Time"]; ?> minutes</td>
                                                                            					        	      <?php
                                                                                					        	    if(!empty($rowLayer4['CAI_Rendered_Minutes'])){ ?>
                                                                                					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                					        	            <?php echo 'Rendered: '; ?>
                                                                                					        	            <?php echo $rowLayer4['CAI_Rendered_Minutes']; ?>
                                                                                					        	            <?php echo 'minute(s)'; ?>
                                                                                					        	            
                                                                                					        	            <?php if($rowLayer4['Service_log_Status'] !=1 && $rowLayer4["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                					        	            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs(<?php echo  $rowLayer4['CAI_id']; ?>)">Add logs</a>
                                                                                					        	            <?php }else{ ?>
                                                                                					        	                <?php if($rowLayer4["CAI_Assign_to"] == $_COOKIE['employee_id']): ?>
                                                                                					        	                <a style="font-weight:800;color:#fff;" class="btn green btn-xs"><?php echo 'Services Added'; ?></a>
                                                                                					        	                <?php endif; ?>
                                                                                					        	            <?php } ?>
                                                                                					        	            
                                                                                					        	        </td>
                                                                                					        	    <?php } ?>
                                                                                					        	    <?php
                                                                                					        	    if($rowLayer4['CAI_Completed']==1){ ?>
                                                                                					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                					        	            <?php echo '100%'; ?>
                                                                                					        	        </td>
                                                                                					        	    <?php } ?>
                                                                                					        	  <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                        					        	            <?php echo 'Start Date: '; ?>
                                                                        					        	            <?php echo date("Y-m-d", strtotime($rowLayer4['CAI_Action_date'])); ?>
                                                                        					        	        </td>
                                                                        					        	        
                                                                        					        	            <?php if(!empty($rowLayer4['CAI_Action_due_date'])){ ?>
                                                                        					        	            <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                        					        	            <?php echo 'Due Date: '; ?>
                                                                        					        	            <?php echo date("Y-m-d", strtotime($rowLayer4['CAI_Action_due_date'])); ?>
                                                                        					        	            </td>
                                                                        					        	            <?php } ?>
                                                                        					        	        
                                                                                                               <td class="paddId" style="background-color:<?php if($rowLayer4['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                                    <a style="font-weight:800;color:#fff;" href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments(<?php echo  $rowLayer4['CAI_id']; ?>)">
                                                                                                                        <i class="fa fa-comments-o" style="font-size:24px;color:#fff;padding:10px;"></i>
                                                                                                                    </a>
                                                                                                                </td>
                                                                                                                <td class="paddId" style="background-color:<?php if($rowLayer4['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                                    <a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child(<?php echo  $rowLayer4['CAI_id']; ?>)">Add</a>
                                                                                                                    <?php if($rowLayer4["CAI_Assign_to"] == 0){ ?>
                                                                                                                        <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer4['CAI_id']; ?>)">Edit</a>
                                                                                                                    <?php } ?>
                                                                                                                     <?php if($rowLayer4["CAI_Assign_to"] == $_COOKIE['employee_id'] && $rowLayer4["Acceptance_Status"] != 2): ?>
                                                                                                                    <?php if($rowLayer4['Acceptance_Status'] == 1 && $rowLayer4["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                                                    <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer4['CAI_id']; ?>)">Edit</a>
                                                                                                                    <?php } else if($rowLayer4["CAI_User_PK"] == $_COOKIE['ID']){ ?>
                                                                                                                    <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer4['CAI_id']; ?>)">Edit</a>
                                                                                                                    <?php }else{ ?>
                                                                                                                        <a style="font-weight:800;color:#fff;" href="#modalGet_Accept_status" data-toggle="modal" class="btn green btn-xs" onclick="btn_Accept_status(<?php echo  $rowLayer4['CAI_id']; ?>)">View</a>
                                                                                                                    <?php } ?>
                                                                                                                    <?php endif; ?>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                                <?php
                                                                                                            // layer 5
                                                                                                            $project_id = $_GET['view_id'];
                                                                                                            $childLayer4 = $rowLayer4['CAI_id'];
                                                                                                            $selectLayer5 = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                                                                                		                         left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
                                                                                		                       WHERE Parent_MyPro_PK = $project_id and CIA_Indent_Id = '$childLayer4'" );
                                                                                    					        while($rowLayer5 = mysqli_fetch_array($selectLayer5)) { 
                                                                                    					        $filesL5 = $rowLayer5["CAI_files"];
                                                                                                                $fileExtension = fileExtension($filesL5);
                                                                                								$src = $fileExtension['src'];
                                                                                								$embed = $fileExtension['embed'];
                                                                                								$type = $fileExtension['type'];
                                                                                								$file_extension = $fileExtension['file_extension'];
                                                                                					           $url = $base_url.'MyPro_Folder_Files/';
                                                                                    					        ?>
                                                                                    					          
                                                                                                                <tr id="<?php echo $rowLayer5["CAI_id"]; ?>"  class="parentTbls" style="border:solid <?php if($rowLayer5["CAI_Assign_to"]== $_COOKIE['employee_id']){echo '#083AA9';}else{echo '#fff';} ?> 2px;">
                                                                                                                    <td><?php echo $rowLayer5["CAI_id"]; ?></td>
                                                                                                                    <td></td>
                                                                                                                    <td></td>
                                                                                                                    <td></td>
                                                                                                                    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer5["CAI_filename"]; ?></td>
                                                                                                                    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer5["Action_Items_name"]; ?></td>
                                                                                                                    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer5["CAI_description"]; ?></td>
                                                                                					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                					        	        <a style="color:#fff;" data-src="<?php echo $src.$url.rawurlencode($filesL5).$embed; ?>" data-fancybox data-type="<?php echo $type; ?>" class="btn btn-link">
                                                                                					        	        <?php  $ext = pathinfo($filesL5, PATHINFO_EXTENSION); 
                                                                            					        	                if($ext == 'pdf'){
                                                                            					        	                    echo '<i class="fa fa-file-pdf-o" style="font-size:24px;color:red;"></i>';
                                                                            					        	                }
                                                                            					        	                else if($ext == 'docx'){
                                                                            					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                            					        	                }
                                                                            					        	                else if($ext == 'doc'){
                                                                            					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                            					        	                }
                                                                            					        	                else if($ext == 'csv'){
                                                                            					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                            					        	                }
                                                                            					        	                else if($ext == 'xlsx'){
                                                                            					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                            					        	                }
                                                                            					        	                else if($ext == 'xlsm'){
                                                                            					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                            					        	                }
                                                                            					        	                else if($ext == 'xls'){
                                                                            					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                            					        	                }
                                                                            					        	                else{
                                                                            					        	                  echo '<i class="fa fa-file-o" style="font-size:24px;"></i>';
                                                                            					        	                }
                                                                            					        	            ?>
                                                                                					        	        </a>
                                                                                					        	    </td>
                                                                                					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"> Assign to: <?php echo $rowLayer5["first_name"]; ?></td>
                                                                                					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                					        	            <?php 
                                                                                    					        	            if($rowLayer5['CIA_progress']== 1){ echo '<b class="inprogress">Inprogress</b>'; }
                                                                                    					        	            else if($rowLayer5['CIA_progress']== 2){ echo '<b class="completed">Completed</b>';}
                                                                                    					        	            else{ echo '<b class="notstarted">Not Started</b>';}
                                                                                					        	            ?>
                                                                                					        	      </td>
                                                                                                                    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">Estimated: <?php echo $rowLayer5["CAI_Estimated_Time"]; ?> minutes</td>
                                                                                					        	      <?php
                                                                                    					        	    if(!empty($rowLayer5['CAI_Rendered_Minutes'])){ ?>
                                                                                    					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                    					        	            <?php echo 'Rendered: '; ?>
                                                                                    					        	            <?php echo $rowLayer5['CAI_Rendered_Minutes']; ?>
                                                                                    					        	            <?php echo 'minute(s)'; ?>
                                                                                    					        	            
                                                                                    					        	            <?php if($rowLayer5['Service_log_Status'] !=1 && $rowLayer5["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                    					        	            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs(<?php echo  $rowLayer5['CAI_id']; ?>)">Add logs</a>
                                                                                    					        	            <?php }else{ ?>
                                                                                    					        	                <?php if($rowLayer5["CAI_Assign_to"] == $_COOKIE['employee_id']): ?>
                                                                                    					        	                <a style="font-weight:800;color:#fff;" class="btn green btn-xs"><?php echo 'Services Added'; ?></a>
                                                                                    					        	                <?php endif; ?>
                                                                                    					        	            <?php } ?>
                                                                                    					        	        </td>
                                                                                    					        	    <?php } ?>
                                                                                    					        	     <?php
                                                                                        					        	    if($rowLayer5['CIA_progress']==2){ ?>
                                                                                        					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                        					        	            <?php echo '100%'; ?>
                                                                                        					        	        </td>
                                                                                        					        	    <?php } ?>
                                                                                        					        	 <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                					        	            <?php echo 'Start Date: '; ?>
                                                                                					        	            <?php echo date("Y-m-d", strtotime($rowLayer5['CAI_Action_date'])); ?>
                                                                                					        	        </td>
                                                                                					        	        
                                                                                					        	         <?php if(!empty($rowLayer5['CAI_Action_due_date'])){ ?>
                                                                                					        	            <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                					        	            <?php echo 'Due Date: '; ?>
                                                                                					        	            <?php echo date("Y-m-d", strtotime($rowLayer5['CAI_Action_due_date'])); ?>
                                                                                					        	            </td>
                                                                                					        	            <?php } ?>
                                                                                					        	        
                                                                                                                    <td class="paddId" style="background-color:<?php if($rowLayer5['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                                        <a style="font-weight:800;color:#fff;" href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments(<?php echo  $rowLayer5['CAI_id']; ?>)">
                                                                                                                            <i class="fa fa-comments-o" style="font-size:24px;color:#fff;padding:10px;"></i>
                                                                                                                        </a>
                                                                                                                    </td>
                                                                                                                    <td class="paddId" style="background-color:<?php if($rowLayer5['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                                        <a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child(<?php echo  $rowLayer5['CAI_id']; ?>)">Add</a>
                                                                                                                        <?php if($rowLayer5["CAI_Assign_to"] == 0){ ?>
                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer5['CAI_id']; ?>)">Edit</a>
                                                                                                                        <?php } ?>
                                                                                                                        <?php if($rowLayer5["CAI_Assign_to"] == $_COOKIE['employee_id'] && $rowLayer5["Acceptance_Status"] != 2): ?>
                                                                                                                        <?php if($rowLayer5['Acceptance_Status'] == 1 && $rowLayer5["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                                                        <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer5['CAI_id']; ?>)">Edit</a>
                                                                                                                        <?php } else if($rowLayer5["CAI_User_PK"] == $_COOKIE['ID']){ ?>
                                                                                                                        <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer5['CAI_id']; ?>)">Edit</a>
                                                                                                                        <?php }else{ ?>
                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGet_Accept_status" data-toggle="modal" class="btn green btn-xs" onclick="btn_Accept_status(<?php echo  $rowLayer5['CAI_id']; ?>)">View</a>
                                                                                                                        <?php } ?>
                                                                                                                    <?php endif; ?>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                                <?php
                                                                                                                // layer 6
                                                                                                                $project_id = $_GET['view_id'];
                                                                                                                $childLayer5 = $rowLayer5['CAI_id'];
                                                                                                                $selectLayer6 = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                                                                                    		                         left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
                                                                                    		                       WHERE Parent_MyPro_PK = $project_id and CIA_Indent_Id = '$childLayer5'" );
                                                                                        					        while($rowLayer6 = mysqli_fetch_array($selectLayer6)) { 
                                                                                        					        $filesL6 = $rowLayer6["CAI_files"];
                                                                                                                    $fileExtension = fileExtension($filesL6);
                                                                                    								$src = $fileExtension['src'];
                                                                                    								$embed = $fileExtension['embed'];
                                                                                    								$type = $fileExtension['type'];
                                                                                    								$file_extension = $fileExtension['file_extension'];
                                                                                    					           $url = $base_url.'MyPro_Folder_Files/';
                                                                                        					        ?>
                                                                                        					          
                                                                                                                    <tr id="<?php echo $rowLayer6["CAI_id"]; ?>"  class="parentTbls" style="border:solid <?php if($rowLayer6["CAI_Assign_to"]== $_COOKIE['employee_id']){echo '#083AA9';}else{echo '#fff';} ?> 2px;">
                                                                                                                        <td><?php echo $rowLayer6["CAI_id"]; ?></td>
                                                                                                                        <td></td>
                                                                                                                        <td></td>
                                                                                                                        <td></td>
                                                                                                                        <td></td>
                                                                                                                        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer6["CAI_filename"]; ?></td>
                                                                                                                        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer6["Action_Items_name"]; ?></td>
                                                                                                                        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer6["CAI_description"]; ?></td>
                                                                                    					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                    					        	        <a style="color:#fff;" data-src="<?php echo $src.$url.rawurlencode($filesL6).$embed; ?>" data-fancybox data-type="<?php echo $type; ?>" class="btn btn-link">
                                                                                    					        	            <?php  $ext = pathinfo($filesL6, PATHINFO_EXTENSION); 
                                                                                    					        	                if($ext == 'pdf'){
                                                                                    					        	                    echo '<i class="fa fa-file-pdf-o" style="font-size:24px;color:red;"></i>';
                                                                                    					        	                }
                                                                                    					        	                else if($ext == 'docx'){
                                                                                    					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                                    					        	                }
                                                                                    					        	                else if($ext == 'doc'){
                                                                                    					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                                    					        	                }
                                                                                    					        	                else if($ext == 'csv'){
                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                    					        	                }
                                                                                    					        	                else if($ext == 'xlsx'){
                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                    					        	                }
                                                                                    					        	                else if($ext == 'xlsm'){
                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                    					        	                }
                                                                                    					        	                else if($ext == 'xls'){
                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                    					        	                }
                                                                                    					        	                else{
                                                                                    					        	                  echo '<i class="fa fa-file-o" style="font-size:24px;"></i>';
                                                                                    					        	                }
                                                                                    					        	            ?>
                                                                                    					        	        </a>
                                                                                    					        	    </td>
                                                                                    					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"> Assign to: <?php echo $rowLayer6["first_name"]; ?></td>
                                                                                    					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                    					        	            <?php 
                                                                                        					        	            if($rowLayer6['CIA_progress']== 1){ echo '<b class="inprogress">Inprogress</b>'; }
                                                                                        					        	            else if($rowLayer6['CIA_progress']== 2){ echo '<b class="completed">Completed</b>';}
                                                                                        					        	            else{ echo '<b class="notstarted">Not Started</b>';}
                                                                                    					        	            ?>
                                                                                    					        	      </td>
                                                                                                                        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">Estimated: <?php echo $rowLayer6["CAI_Estimated_Time"]; ?> minutes</td>
                                                                                    					        	      <?php
                                                                                        					        	    if(!empty($rowLayer6['CAI_Rendered_Minutes'])){ ?>
                                                                                        					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                        					        	            <?php echo 'Rendered: '; ?>
                                                                                        					        	            <?php echo $rowLayer6['CAI_Rendered_Minutes']; ?>
                                                                                        					        	            <?php echo 'minute(s)'; ?>
                                                                                        					        	            
                                                                                        					        	            <?php if($rowLayer6['Service_log_Status'] !=1 && $rowLayer6["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                        					        	            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs(<?php echo  $rowLayer6['CAI_id']; ?>)">Add logs</a>
                                                                                        					        	            <?php }else{ ?>
                                                                                        					        	                <?php if($rowLayer6["CAI_Assign_to"] == $_COOKIE['employee_id']): ?>
                                                                                        					        	                <a style="font-weight:800;color:#fff;" class="btn green btn-xs"><?php echo 'Services Added'; ?></a>
                                                                                        					        	                <?php endif; ?>
                                                                                        					        	            <?php } ?>
                                                                                        					        	        </td>
                                                                                        					        	    <?php } ?>
                                                                                        					        	    <?php
                                                                                        					        	    if($rowLayer6['CIA_progress']==2){ ?>
                                                                                        					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                        					        	            <?php echo '100%'; ?>
                                                                                        					        	        </td>
                                                                                        					        	    <?php } ?>
                                                                                        					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                    					        	            <?php echo 'Start Date: '; ?>
                                                                                    					        	            <?php echo date("Y-m-d", strtotime($rowLayer6['CAI_Action_date'])); ?>
                                                                                    					        	        </td>
                                                                                    					        	        
                                                                                    					        	        <?php if(!empty($rowLayer6['CAI_Action_due_date'])){ ?>
                                                                                					        	            <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                					        	            <?php echo 'Due Date: '; ?>
                                                                                					        	            <?php echo date("Y-m-d", strtotime($rowLayer6['CAI_Action_due_date'])); ?>
                                                                                					        	            </td>
                                                                                					        	            <?php } ?>
                                                                                    					        	        
                                                                                                                           <td class="paddId" style="background-color:<?php if($rowLayer6['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments(<?php echo  $rowLayer6['CAI_id']; ?>)">
                                                                                                                                <i class="fa fa-comments-o" style="font-size:24px;color:#fff;padding:10px;"></i>
                                                                                                                            </a>
                                                                                                                        </td>
                                                                                                                        <td class="paddId" style="background-color:<?php if($rowLayer6['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child(<?php echo  $rowLayer6['CAI_id']; ?>)">Add</a>
                                                                                                                            <?php if($rowLayer6["CAI_Assign_to"] == 0){ ?>
                                                                                                                                <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer6['CAI_id']; ?>)">Edit</a>
                                                                                                                            <?php } ?>
                                                                                                                             <?php if($rowLayer6["CAI_Assign_to"] == $_COOKIE['employee_id'] && $rowLayer6["Acceptance_Status"] != 2): ?>
                                                                                                                            <?php if($rowLayer6['Acceptance_Status'] == 1 && $rowLayer6["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer6['CAI_id']; ?>)">Edit</a>
                                                                                                                            <?php } else if($rowLayer6["CAI_User_PK"] == $_COOKIE['ID']){ ?>
                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer6['CAI_id']; ?>)">Edit</a>
                                                                                                                            <?php }else{ ?>
                                                                                                                                <a style="font-weight:800;color:#fff;" href="#modalGet_Accept_status" data-toggle="modal" class="btn green btn-xs" onclick="btn_Accept_status(<?php echo  $rowLayer6['CAI_id']; ?>)">View</a>
                                                                                                                            <?php } ?>
                                                                                                                             <?php endif; ?>
                                                                                                                        </td>
                                                                                                                       
                                                                                                                    </tr>
                                                                                                                    <?php
                                                                                                                        // layer 7
                                                                                                                        $project_id = $_GET['view_id'];
                                                                                                                        $childLayer6 = $rowLayer6['CAI_id'];
                                                                                                                        $selectLayer7 = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                                                                                            		                         left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
                                                                                            		                       WHERE Parent_MyPro_PK = $project_id and CIA_Indent_Id = '$childLayer6'" );
                                                                                                					        while($rowLayer7 = mysqli_fetch_array($selectLayer7)) { 
                                                                                                					        $filesL7 = $rowLayer7["CAI_files"];
                                                                                                                            $fileExtension = fileExtension($filesL7);
                                                                                            								$src = $fileExtension['src'];
                                                                                            								$embed = $fileExtension['embed'];
                                                                                            								$type = $fileExtension['type'];
                                                                                            								$file_extension = $fileExtension['file_extension'];
                                                                                            					           $url = $base_url.'MyPro_Folder_Files/';
                                                                                                					        ?>
                                                                                                					          
                                                                                                                            <tr id="<?php echo $rowLayer7["CAI_id"]; ?>"  class="parentTbls" style="border:solid <?php if($rowLayer7["CAI_Assign_to"]== $_COOKIE['employee_id']){echo '#083AA9';}else{echo '#fff';} ?> 2px;">
                                                                                                                                <td><?php echo $rowLayer7["CAI_id"]; ?></td>
                                                                                                                                <td></td>
                                                                                                                                <td></td>
                                                                                                                                <td></td>
                                                                                                                                <td></td>
                                                                                                                                <td></td>
                                                                                                                                <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer7["CAI_filename"]; ?></td>
                                                                                                                                <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer7["Action_Items_name"]; ?></td>
                                                                                                                                <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer7["CAI_description"]; ?></td>
                                                                                            					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                            					        	        <a style="color:#fff;" data-src="<?php echo $src.$url.rawurlencode($filesL7).$embed; ?>" data-fancybox data-type="<?php echo $type; ?>" class="btn btn-link">
                                                                                            					        	            <?php  $ext = pathinfo($filesL7, PATHINFO_EXTENSION); 
                                                                                            					        	                if($ext == 'pdf'){
                                                                                            					        	                    echo '<i class="fa fa-file-pdf-o" style="font-size:24px;color:red;"></i>';
                                                                                            					        	                }
                                                                                            					        	                else if($ext == 'docx'){
                                                                                            					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                                            					        	                }
                                                                                            					        	                else if($ext == 'doc'){
                                                                                            					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                                            					        	                }
                                                                                            					        	                else if($ext == 'csv'){
                                                                                            					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                            					        	                }
                                                                                            					        	                else if($ext == 'xlsx'){
                                                                                            					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                            					        	                }
                                                                                            					        	                else if($ext == 'xlsm'){
                                                                                            					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                            					        	                }
                                                                                            					        	                else if($ext == 'xls'){
                                                                                            					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                            					        	                }
                                                                                            					        	                else{
                                                                                            					        	                  echo '<i class="fa fa-file-o" style="font-size:24px;"></i>';
                                                                                            					        	                }
                                                                                            					        	            ?>
                                                                                            					        	        </a>
                                                                                            					        	    </td>
                                                                                            					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"> Assign to: <?php echo $rowLayer7["first_name"]; ?></td>
                                                                                            					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                            					        	            <?php 
                                                                                                					        	            if($rowLayer7['CIA_progress']== 1){ echo '<b class="inprogress">Inprogress</b>'; }
                                                                                                					        	            else if($rowLayer7['CIA_progress']== 2){ echo '<b class="completed">Completed</b>';}
                                                                                                					        	            else{ echo '<b class="notstarted">Not Started</b>';}
                                                                                            					        	            ?>
                                                                                            					        	      </td>
                                                                                                                                <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">Estimated: <?php echo $rowLayer7["CAI_Estimated_Time"]; ?> minutes</td>
                                                                                            					        	      <?php
                                                                                                					        	    if(!empty($rowLayer7['CAI_Rendered_Minutes'])){ ?>
                                                                                                					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                					        	            <?php echo 'Rendered: '; ?>
                                                                                                					        	            <?php echo $rowLayer7['CAI_Rendered_Minutes']; ?>
                                                                                                					        	            <?php echo 'minute(s)'; ?>
                                                                                                					        	            
                                                                                                					        	            <?php if($rowLayer7['Service_log_Status'] !=1 && $rowLayer7["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                                					        	            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs(<?php echo  $rowLayer7['CAI_id']; ?>)">Add logs</a>
                                                                                                					        	            <?php }else{ ?>
                                                                                                					        	                <?php if($rowLayer7["CAI_Assign_to"] == $_COOKIE['employee_id']): ?>
                                                                                                					        	                <a style="font-weight:800;color:#fff;" class="btn green btn-xs"><?php echo 'Services Added'; ?></a>
                                                                                                					        	                <?php endif; ?>
                                                                                                					        	            <?php } ?>
                                                                                                					        	        </td>
                                                                                                					        	    <?php } ?>
                                                                                                					        	    <?php
                                                                                                					        	    if($rowLayer7['CIA_progress']==2){ ?>
                                                                                                					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                					        	            <?php echo '100%'; ?>
                                                                                                					        	        </td>
                                                                                                					        	    <?php } ?>
                                                                                                					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                            					        	            <?php echo 'Start Date: '; ?>
                                                                                            					        	            <?php echo $rowLayer7['CAI_Action_date']; ?>
                                                                                            					        	        </td>
                                                                                            					        	        
                                                                                            					        	        <?php if(!empty($rowLayer7['CAI_Action_due_date'])){ ?>
                                                                                        					        	            <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                        					        	            <?php echo 'Due Date: '; ?>
                                                                                        					        	            <?php echo date("Y-m-d", strtotime($rowLayer7['CAI_Action_due_date'])); ?>
                                                                                        					        	            </td>
                                                                                        					        	            <?php } ?>
                                                                                            					        	        
                                                                                                                               <td class="paddId" style="background-color:<?php if($rowLayer7['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                                                    <a style="font-weight:800;color:#fff;" href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments(<?php echo  $rowLayer7['CAI_id']; ?>)">
                                                                                                                                        <i class="fa fa-comments-o" style="font-size:24px;color:#fff;padding:10px;"></i>
                                                                                                                                    </a>
                                                                                                                                </td>
                                                                                                                                <td class="paddId" style="background-color:<?php if($rowLayer7['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                                                    <a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child(<?php echo  $rowLayer7['CAI_id']; ?>)">Add</a>
                                                                                                                                    <?php if($rowLayer7["CAI_Assign_to"] == 0){ ?>
                                                                                                                                        <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer7['CAI_id']; ?>)">Edit</a>
                                                                                                                                    <?php } ?>
                                                                                                                                     <?php if($rowLayer7["CAI_Assign_to"] == $_COOKIE['employee_id'] && $rowLayer7["Acceptance_Status"] != 2): ?>
                                                                                                                                    <?php if($rowLayer7['Acceptance_Status'] == 1 && $rowLayer7["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                                                                    <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer7['CAI_id']; ?>)">Edit</a>
                                                                                                                                    <?php } else if($rowLayer7["CAI_User_PK"] == $_COOKIE['ID']){ ?>
                                                                                                                                    <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer7['CAI_id']; ?>)">Edit</a>
                                                                                                                                    <?php }else{ ?>
                                                                                                                                        <a style="font-weight:800;color:#fff;" href="#modalGet_Accept_status" data-toggle="modal" class="btn green btn-xs" onclick="btn_Accept_status(<?php echo  $rowLayer7['CAI_id']; ?>)">View</a>
                                                                                                                                    <?php } ?>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <?php
                                                                                                                                // layer 8
                                                                                                                                $project_id = $_GET['view_id'];
                                                                                                                                $childLayer7 = $rowLayer7['CAI_id'];
                                                                                                                                $selectLayer8 = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                                                                                                    		                         left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
                                                                                                    		                       WHERE Parent_MyPro_PK = $project_id and CIA_Indent_Id = '$childLayer7'" );
                                                                                                        					        while($rowLayer8 = mysqli_fetch_array($selectLayer8)) { 
                                                                                                        					             $filesL8 = $rowLayer8["CAI_files"];
                                                                                                                                        $fileExtension = fileExtension($filesL8);
                                                                                                        								$src = $fileExtension['src'];
                                                                                                        								$embed = $fileExtension['embed'];
                                                                                                        								$type = $fileExtension['type'];
                                                                                                        								$file_extension = $fileExtension['file_extension'];
                                                                                                        					           $url = $base_url.'MyPro_Folder_Files/';
                                                                                                        					        ?>
                                                                                                        					          
                                                                                                                                    <tr id="<?php echo $rowLayer8["CAI_id"]; ?>"  class="parentTbls" style="border:solid <?php if($rowLayer8["CAI_Assign_to"]== $_COOKIE['employee_id']){echo '#083AA9';}else{echo '#fff';} ?> 2px;">
                                                                                                                                        <td><?php echo $rowLayer8["CAI_id"]; ?></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer8["CAI_filename"]; ?></td>
                                                                                                                                        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer8["Action_Items_name"]; ?></td>
                                                                                                                                        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer8["CAI_description"]; ?></td>
                                                                                                    					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                    					        	        <a style="color:#fff;" data-src="<?php echo $src.$url.rawurlencode($filesL8).$embed; ?>" data-fancybox data-type="<?php echo $type; ?>" class="btn btn-link">
                                                                                                    					        	            
                                                                                                    					        	            <?php  $ext = pathinfo($filesL8, PATHINFO_EXTENSION); 
                                                                                                    					        	                if($ext == 'pdf'){
                                                                                                    					        	                    echo '<i class="fa fa-file-pdf-o" style="font-size:24px;color:red;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'docx'){
                                                                                                    					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'doc'){
                                                                                                    					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'csv'){
                                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'xlsx'){
                                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'xlsm'){
                                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'xls'){
                                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else{
                                                                                                    					        	                  echo '<i class="fa fa-file-o" style="font-size:24px;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	            ?>
                                                                                                    					        	        </a>
                                                                                                    					        	    </td>
                                                                                                    					        	    
                                                                                                    					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"> Assign to: <?php echo $rowLayer8["first_name"]; ?></td>
                                                                                                    					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                    					        	            <?php 
                                                                                                        					        	            if($rowLayer8['CIA_progress']== 1){ echo '<b class="inprogress">Inprogress</b>'; }
                                                                                                        					        	            else if($rowLayer8['CIA_progress']== 2){ echo '<b class="completed">Completed</b>';}
                                                                                                        					        	            else{ echo '<b class="notstarted">Not Started</b>';}
                                                                                                    					        	            ?>
                                                                                                    					        	      </td>
                                                                                                    					        	      
                                                                                                                                        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">Estimated: <?php echo $rowLayer8["CAI_Estimated_Time"]; ?> minutes</td>
                                                                                                    					        	      <?php
                                                                                                        					        	    if(!empty($rowLayer8['CAI_Rendered_Minutes'])){ ?>
                                                                                                        					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                        					        	            <?php echo 'Rendered: '; ?>
                                                                                                        					        	            <?php echo $rowLayer8['CAI_Rendered_Minutes']; ?>
                                                                                                        					        	            <?php echo 'minute(s)'; ?>
                                                                                                        					        	            
                                                                                                        					        	            <?php if($rowLayer8['Service_log_Status'] !=1 && $rowLayer8["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                                        					        	            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs(<?php echo  $rowLayer8['CAI_id']; ?>)">Add logs</a>
                                                                                                        					        	            <?php }else{ ?>
                                                                                                        					        	                <?php if($rowLayer8["CAI_Assign_to"] == $_COOKIE['employee_id']): ?>
                                                                                                        					        	                <a style="font-weight:800;color:#fff;" class="btn green btn-xs"><?php echo 'Services Added'; ?></a>
                                                                                                        					        	                <?php endif; ?>
                                                                                                        					        	            <?php } ?>
                                                                                                        					        	        </td>
                                                                                                        					        	    <?php } ?>
                                                                                                        					        	    <?php
                                                                                                        					        	    if($rowLayer8['CIA_progress']==2){ ?>
                                                                                                        					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                        					        	            <?php echo '100%'; ?>
                                                                                                        					        	        </td>
                                                                                                        					        	    <?php } ?>
                                                                                                        					        	     <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                        					        	            <?php echo 'Start Date: '; ?>
                                                                                                        					        	            <?php echo date("Y-m-d", strtotime($rowLayer8['CAI_Action_date'])); ?>
                                                                                                        					        	        </td>
                                                                                                        					        	        
                                                                                                        					        	        <?php if(!empty($rowLayer8['CAI_Action_due_date'])){ ?>
                                                                                                    					        	            <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                    					        	            <?php echo 'Due Date: '; ?>
                                                                                                    					        	            <?php echo date("Y-m-d", strtotime($rowLayer8['CAI_Action_due_date'])); ?>
                                                                                                    					        	            </td>
                                                                                                    					        	            <?php } ?>
                                                                                        					        	            
                                                                                                                                        <td class="paddId" style="background-color:<?php if($rowLayer8['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments(<?php echo  $rowLayer8['CAI_id']; ?>)">
                                                                                                                                                <i class="fa fa-comments-o" style="font-size:24px;color:#fff;padding:10px;"></i>
                                                                                                                                            </a>
                                                                                                                                        </td>
                                                                                                                                        <td class="paddId" style="background-color:<?php if($rowLayer8['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child(<?php echo  $rowLayer8['CAI_id']; ?>)">Add</a>
                                                                                                                                            <?php if($rowLayer8["CAI_Assign_to"] == 0){ ?>
                                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer8['CAI_id']; ?>)">Edit</a>
                                                                                                                                        <?php } ?>
                                                                                                                                            <?php if($rowLayer8["CAI_Assign_to"] == $_COOKIE['employee_id'] && $rowLayer8["Acceptance_Status"] != 2): ?>
                                                                                                                                            <?php if($rowLayer8['Acceptance_Status'] == 1 && $rowLayer8["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer8['CAI_id']; ?>)">Edit</a>
                                                                                                                                            <?php } else if($rowLayer8["CAI_User_PK"] == $_COOKIE['ID']){ ?>
                                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer8['CAI_id']; ?>)">Edit</a>
                                                                                                                                            <?php }else{ ?>
                                                                                                                                                <a style="font-weight:800;color:#fff;" href="#modalGet_Accept_status" data-toggle="modal" class="btn green btn-xs" onclick="btn_Accept_status(<?php echo  $rowLayer8['CAI_id']; ?>)">View</a>
                                                                                                                                            <?php } ?>
                                                                                                                                        <?php endif; ?>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                         
                                                                                                                           <?php
                                                                                                                                // layer 9
                                                                                                                                $project_id = $_GET['view_id'];
                                                                                                                                $childLayer8 = $rowLayer8['CAI_id'];
                                                                                                                                $selectLayer9 = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                                                                                                    		                         left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
                                                                                                    		                       WHERE Parent_MyPro_PK = $project_id and CIA_Indent_Id = '$childLayer8'" );
                                                                                                        					        while($rowLayer9 = mysqli_fetch_array($selectLayer9)) { 
                                                                                                        					             $filesL9 = $rowLayer9["CAI_files"];
                                                                                                                                        $fileExtension = fileExtension($filesL9);
                                                                                                        								$src = $fileExtension['src'];
                                                                                                        								$embed = $fileExtension['embed'];
                                                                                                        								$type = $fileExtension['type'];
                                                                                                        								$file_extension = $fileExtension['file_extension'];
                                                                                                        					           $url = $base_url.'MyPro_Folder_Files/';
                                                                                                        					        ?>
                                                                                                        					          
                                                                                                                                    <tr id="<?php echo $rowLayer9["CAI_id"]; ?>"  class="parentTbls" style="border:solid <?php if($rowLayer9["CAI_Assign_to"]== $_COOKIE['employee_id']){echo '#083AA9';}else{echo '#fff';} ?> 2px;">
                                                                                                                                        <td><?php echo $rowLayer9["CAI_id"]; ?></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer9["CAI_filename"]; ?></td>
                                                                                                                                        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer9["CAI_description"]; ?></td>
                                                                                                    					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                    					        	        <a style="color:#fff;" data-src="<?php echo $src.$url.rawurlencode($filesL9).$embed; ?>" data-fancybox data-type="<?php echo $type; ?>" class="btn btn-link">
                                                                                                    					        	            
                                                                                                    					        	            <?php  $ext = pathinfo($filesL9, PATHINFO_EXTENSION); 
                                                                                                    					        	                if($ext == 'pdf'){
                                                                                                    					        	                    echo '<i class="fa fa-file-pdf-o" style="font-size:24px;color:red;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'docx'){
                                                                                                    					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'doc'){
                                                                                                    					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'csv'){
                                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'xlsx'){
                                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'xlsm'){
                                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'xls'){
                                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else{
                                                                                                    					        	                  echo '<i class="fa fa-file-o" style="font-size:24px;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	            ?>
                                                                                                    					        	        </a>
                                                                                                    					        	    </td>
                                                                                                    					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"> Assign to: <?php echo $rowLayer9["first_name"]; ?></td>
                                                                                                                                        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer9["Action_Items_name"]; ?></td>
                                                                                                    					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                    					        	            <?php 
                                                                                                        					        	            if($rowLayer9['CIA_progress']== 1){ echo '<b class="inprogress">Inprogress</b>'; }
                                                                                                        					        	            else if($rowLayer9['CIA_progress']== 2){ echo '<b class="completed">Completed</b>';}
                                                                                                        					        	            else{ echo '<b class="notstarted">Not Started</b>';}
                                                                                                    					        	            ?>
                                                                                                    					        	      </td>
                                                                                                                                        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">Estimated: <?php echo $rowLayer9["CAI_Estimated_Time"]; ?> minutes</td>
                                                                                                    					        	      <?php
                                                                                                        					        	    if(!empty($rowLayer9['CAI_Rendered_Minutes'])){ ?>
                                                                                                        					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                        					        	            <?php echo 'Rendered: '; ?>
                                                                                                        					        	            <?php echo $rowLayer9['CAI_Rendered_Minutes']; ?>
                                                                                                        					        	            <?php echo 'minute(s)'; ?>
                                                                                                        					        	            
                                                                                                        					        	            <?php if($rowLayer9['Service_log_Status'] !=1 && $rowLayer9["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                                        					        	            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs(<?php echo  $rowLayer9['CAI_id']; ?>)">Add logs</a>
                                                                                                        					        	            <?php }else{ ?>
                                                                                                        					        	                <?php if($rowLayer9["CAI_Assign_to"] == $_COOKIE['employee_id']): ?>
                                                                                                        					        	                <a style="font-weight:800;color:#fff;" class="btn green btn-xs"><?php echo 'Services Added'; ?></a>
                                                                                                        					        	                <?php endif; ?>
                                                                                                        					        	            <?php } ?>
                                                                                                        					        	        </td>
                                                                                                        					        	    <?php } ?>
                                                                                                        					        	    <?php
                                                                                                        					        	    if($rowLayer9['CIA_progress']==2){ ?>
                                                                                                        					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                        					        	            <?php echo '100%'; ?>
                                                                                                        					        	        </td>
                                                                                                        					        	    <?php } ?>
                                                                                                        					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                        					        	            <?php echo 'Start Date: '; ?>
                                                                                                        					        	            <?php echo date("Y-m-d", strtotime($rowLayer9['CAI_Action_date'])); ?>
                                                                                                        					        	        </td>
                                                                                                                                        <?php if(!empty($rowLayer9['CAI_Action_due_date'])){ ?>
                                                                                                    					        	            <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                    					        	            <?php echo 'Due Date: '; ?>
                                                                                                    					        	            <?php echo date("Y-m-d", strtotime($rowLayer9['CAI_Action_due_date'])); ?>
                                                                                                    					        	            </td>
                                                                                                    					        	            <?php } ?>
                                                                                        					        	            
                                                                                                                                       <td class="paddId" style="background-color:<?php if($rowLayer9['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments(<?php echo  $rowLayer9['CAI_id']; ?>)">
                                                                                                                                                <i class="fa fa-comments-o" style="font-size:24px;color:#fff;padding:10px;"></i>
                                                                                                                                            </a>
                                                                                                                                        </td>
                                                                                                                                        <td class="paddId" style="background-color:<?php if($rowLayer9['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child(<?php echo  $rowLayer9['CAI_id']; ?>)">Add</a>
                                                                                                                                                <?php if($rowLayer9["CAI_Assign_to"] == 0){ ?>
                                                                                                                                                <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer9['CAI_id']; ?>)">Edit</a>
                                                                                                                                            <?php } ?>
                                                                                                                                             <?php if($rowLayer9["CAI_Assign_to"] == $_COOKIE['employee_id'] && $rowLayer9["Acceptance_Status"] != 2): ?>
                                                                                                                                            <?php if($rowLayer9['Acceptance_Status'] == 1 && $rowLayer9["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer9['CAI_id']; ?>)">Edit</a>
                                                                                                                                            <?php } else if($rowLayer9["CAI_User_PK"] == $_COOKIE['ID']){ ?>
                                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer9['CAI_id']; ?>)">Edit</a>
                                                                                                                                            <?php }else{ ?>
                                                                                                                                                <a style="font-weight:800;color:#fff;" href="#modalGet_Accept_status" data-toggle="modal" class="btn green btn-xs" onclick="btn_Accept_status(<?php echo  $rowLayer9['CAI_id']; ?>)">View</a>
                                                                                                                                            <?php } ?>
                                                                                                                                        <?php endif; ?>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                    <?php
                                                                                                                                // layer 10
                                                                                                                                $project_id = $_GET['view_id'];
                                                                                                                                $childLayer9 = $rowLayer9['CAI_id'];
                                                                                                                                $selectLayer10 = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                                                                                                    		                         left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
                                                                                                    		                       WHERE Parent_MyPro_PK = $project_id and CIA_Indent_Id = '$childLayer9'" );
                                                                                                        					        while($rowLayer10 = mysqli_fetch_array($selectLayer10)) { 
                                                                                                        					             $filesL10 = $rowLayer10["CAI_files"];
                                                                                                                                        $fileExtension = fileExtension($filesL10);
                                                                                                        								$src = $fileExtension['src'];
                                                                                                        								$embed = $fileExtension['embed'];
                                                                                                        								$type = $fileExtension['type'];
                                                                                                        								$file_extension = $fileExtension['file_extension'];
                                                                                                        					           $url = $base_url.'MyPro_Folder_Files/';
                                                                                                        					        ?>
                                                                                                        					          
                                                                                                                                    <tr id="<?php echo $rowLayer10["CAI_id"]; ?>"  class="parentTbls" style="border:solid <?php if($rowLayer10["CAI_Assign_to"]== $_COOKIE['employee_id']){echo '#083AA9';}else{echo '#fff';} ?> 2px;">
                                                                                                                                        <td><?php echo $rowLayer10["CAI_id"]; ?></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td></td>
                                                                                                                                        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer10["CAI_filename"]; ?></td>
                                                                                                                                        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer10["Action_Items_name"]; ?></td>
                                                                                                                                        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"><?php echo $rowLayer10["CAI_description"]; ?></td>
                                                                                                    					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                    					        	        <a style="color:#fff;" data-src="<?php echo $src.$url.rawurlencode($filesL10).$embed; ?>" data-fancybox data-type="<?php echo $type; ?>" class="btn btn-link">
                                                                                                    					        	            
                                                                                                    					        	            <?php  $ext = pathinfo($filesL10, PATHINFO_EXTENSION); 
                                                                                                    					        	                if($ext == 'pdf'){
                                                                                                    					        	                    echo '<i class="fa fa-file-pdf-o" style="font-size:24px;color:red;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'docx'){
                                                                                                    					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'doc'){
                                                                                                    					        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'csv'){
                                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'xlsx'){
                                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'xlsm'){
                                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else if($ext == 'xls'){
                                                                                                    					        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	                else{
                                                                                                    					        	                  echo '<i class="fa fa-file-o" style="font-size:24px;"></i>';
                                                                                                    					        	                }
                                                                                                    					        	            ?>
                                                                                                    					        	        </a>
                                                                                                    					        	    </td>
                                                                                                    					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;"> Assign to: <?php echo $rowLayer10["first_name"]; ?></td>
                                                                                                    					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                    					        	            <?php 
                                                                                                        					        	            if($rowLayer10['CIA_progress']== 1){ echo '<b class="inprogress">Inprogress</b>'; }
                                                                                                        					        	            else if($rowLayer10['CIA_progress']== 2){ echo '<b class="completed">Completed</b>';}
                                                                                                        					        	            else{ echo '<b class="notstarted">Not Started</b>';}
                                                                                                    					        	            ?>
                                                                                                    					        	      </td>
                                                                                                                                            <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">Estimated: <?php echo $rowLayer10["CAI_Estimated_Time"]; ?> minutes</td>
                                                                                                    					        	      <?php
                                                                                                        					        	    if(!empty($rowLayer10['CAI_Rendered_Minutes'])){ ?>
                                                                                                        					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                        					        	            <?php echo 'Rendered: '; ?>
                                                                                                        					        	            <?php echo $rowLayer10['CAI_Rendered_Minutes']; ?>
                                                                                                        					        	            <?php echo 'minute(s)'; ?>
                                                                                                        					        	            
                                                                                                        					        	            <?php if($rowLayer10['Service_log_Status'] !=1 && $rowLayer10["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                                        					        	            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs(<?php echo  $rowLayer10['CAI_id']; ?>)">Add logs</a>
                                                                                                        					        	            <?php }else{ ?>
                                                                                                        					        	                <?php if($rowLayer10["CAI_Assign_to"] == $_COOKIE['employee_id']): ?>
                                                                                                        					        	                <a style="font-weight:800;color:#fff;" class="btn green btn-xs"><?php echo 'Services Added'; ?></a>
                                                                                                        					        	                <?php endif; ?>
                                                                                                        					        	            <?php } ?>
                                                                                                        					        	        </td>
                                                                                                        					        	    <?php } ?>
                                                                                                        					        	    <?php
                                                                                                        					        	    if($rowLayer10['CIA_progress']==2){ ?>
                                                                                                        					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                        					        	            <?php echo '100%'; ?>
                                                                                                        					        	        </td>
                                                                                                        					        	    <?php } ?>
                                                                                                        					        	    <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                        					        	            <?php echo 'Start Date Date: '; ?>
                                                                                                        					        	            <?php echo date("Y-m-d", strtotime($rowLayer10['CAI_Action_date'])); ?>
                                                                                                        					        	        </td>
                                                                                                                                        
                                                                                                                                        
                                                                                                                                        
                                                                                                                                        <?php if(!empty($rowLayer10['CAI_Action_due_date'])){ ?>
                                                                                                    					        	            <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;color:#fff;">
                                                                                                    					        	            <?php echo 'Due Date: '; ?>
                                                                                                    					        	            <?php echo date("Y-m-d", strtotime($rowLayer10['CAI_Action_due_date'])); ?>
                                                                                                    					        	            </td>
                                                                                                    					        	            <?php } ?>
                                                                                        					        	            
                                                                                                                                        <td class="paddId" style="background-color:<?php if($rowLayer10['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments(<?php echo  $rowLayer10['CAI_id']; ?>)">
                                                                                                                                                <i class="fa fa-comments-o" style="font-size:24px;color:#fff;padding:10px;"></i>
                                                                                                                                            </a>
                                                                                                                                        </td>
                                                                                                                                        <td class="paddId" style="background-color:<?php if($rowLayer10['Parent_MyPro_PK'] == $parent_id){ echo $parentcolor;}else{echo $childcolor1;} ?>;color:#fff;">
                                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child(<?php echo  $rowLayer10['CAI_id']; ?>)">Add</a>
                                                                                                                                             <?php if($rowLayer10["CAI_Assign_to"] == 0){ ?>
                                                                                                                                                <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer10['CAI_id']; ?>)">Edit</a>
                                                                                                                                            <?php } ?>
                                                                                                                                            <?php if($rowLayer10["CAI_Assign_to"] == $_COOKIE['employee_id'] && $rowLayer10["Acceptance_Status"] != 2): ?>
                                                                                                                                            <?php if($rowLayer10['Acceptance_Status'] == 1 && $rowLayer10["CAI_Assign_to"] == $_COOKIE['employee_id']){ ?>
                                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer10['CAI_id']; ?>)">Edit</a>
                                                                                                                                            <?php } else if($rowLayer10["CAI_User_PK"] == $_COOKIE['ID']){ ?>
                                                                                                                                            <a style="font-weight:800;color:#fff;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_update_Action_item(<?php echo  $rowLayer10['CAI_id']; ?>)">Edit</a>
                                                                                                                                            <?php }else{ ?>
                                                                                                                                                <a style="font-weight:800;color:#fff;" href="#modalGet_Accept_status" data-toggle="modal" class="btn green btn-xs" onclick="btn_Accept_status(<?php echo  $rowLayer10['CAI_id']; ?>)">View</a>
                                                                                                                                            <?php } ?>
                                                                                                                                        <?php endif; ?>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                           <?php // End layer 9 
                                                                                                                           }?>
                                                                                                                           <?php // End layer 9 
                                                                                                                           }?>
                                                                                                                             <?php // End layer 8 
                                                                                                        					        }?>
                                                                                                                           
                                                                                                                   <?php // End layer 7 
                                                                                                                   }?>
                                                                                                           <?php // End layer 6 
                                                                                                           }?>
                                                                                                       <?php // End layer 5 
                                                                                                       }?>
                                                                                                   <?php // End layer 4 
                                                                                                   }?>
                                                                                           <?php }?>
                                                        					        <?php } ?>
                                                    				      <?php  } } ?>
                                                    				      
                                                                        </table>
                                                                <!--</div>-->
                                                        </div>
                                        </div>
                                        <div class="tab-pane" id="tab_Completed">
                                                    <h3>Completed</h3>
                                            <div class="table-scrollable">
                                                <table class="table table-bordered table-hover" id="tableDataServices">
                                                    <thead>
                                                        <tr>
                                                            <th>Task ID</th>
                                                            <th>PROJECT NAME</th>
                                                            <th style="width: 135px;" class="text-center">Date</th>
                                                            <th style="width: 90px;" class="text-center">Status</th>
                                                            <th style="width: 135px;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                     <?php
                                                            //$i_user=1;
                                                            //$query = "SELECT *  FROM tbl_MyProject_Services";
                                                            //$result = mysqli_query($conn, $query);
                                                                                        
                                                            //while($row = mysqli_fetch_array($result))
                                                            //{?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        <?php //}?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Certification MODAL AREA-->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="MyPro_Folders/MyPro_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Project</h4>
                        </div>
                        <div class="modal-body">
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Project Name</label>
                                        <input class="form-control" type="text" name="Project_Name" required />
                                    </div>
                                    <div class="col-md-6" >
                                    <label>Image/file <i style="color:#1746A2;font-size:12px;"> ( Sample/Supporting files )</i></label>
                                        <input class="form-control" type="file" name="Sample_Documents">
                                    </div>
                                </div>
                            </div>
                           <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Descriptions</label>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" type="text" name="Project_Description" rows="4" required /></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Start Date</label>
                                        <input class="form-control" type="date" name="Start_Date" required />
                                    </div>
                                    <div class="col-md-6" >
                                        <label>Desired Deliver Date</label>
                                        <input class="form-control" type="date" name="Desired_Deliver_Date" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Collaborator</h4>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?php 
                                            
                                            $queryCollab = "SELECT *  FROM tbl_hr_employee where user_id = 34 and status = 1 order by first_name ASC";
                                            $resultCollab = mysqli_query($conn, $queryCollab);
                                                                        
                                            while($rowCollab = mysqli_fetch_array($resultCollab))
                                            { ?>
                                            <div class="col-md-4">
                                                <input type="checkbox" name="Collaborator[]" value="<?php echo $rowCollab['ID']; ?>"> 
                                                <label><?php echo $rowCollab['first_name']; ?> <?php echo $rowCollab['last_name']; ?></label>
                                            </div>
                                         <?php   } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="btnCreate_Project" value="Create" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--view modal-->
         <div class="modal fade bs-modal-lg" id="modalGetMyPro_update" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                     <form action="MyPro_Folders/MyPro_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Project Details</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <input type="submit" name="update_Project" value="Update" class="btn btn-info">       
                         </div>
                    </form>
                </div>
            </div>
        </div>
        
          <!--view modalGetMyPro_History-->
         <div class="modal fade bs-modal-lg" id="modalGetMyPro_History" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width:80%;">
                <div class="modal-content">
                     <form action="MyPro_Folders/MyPro_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Task Action</h4>
                        </div>
                        <div class="modal-body">
                            
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
         <!--view modal-->
         <div class="modal fade bs-modal-lg" id="modalGetMyPro" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content">
                     <form action="MyPro_Folders/MyPro_function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Project Details</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <input type="submit" name="btnAssign_Project" value="Assign" class="btn btn-info">       
                         </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Employee File -->
            <div class="modal fade" id="modalAddActionItem" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modalAddActionItem">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">New Action Item</h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                <button type="submit" class="btn green ladda-button" name="btnSave_History" id="btnSave_History" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- modalGetHistory File -->
            <div class="modal fade" id="modalGetHistory" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modalGetHistory">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">New Action Item</h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                <button type="submit" class="btn green ladda-button" name="btnSave_AddChildItem" id="btnSave_AddChildItem" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- modalGetHistory_Child add Child layer -->
            <div class="modal fade" id="modalGetHistory_Child" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modalGetHistory_Child">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">New Action Item</h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                <button type="submit" class="btn green ladda-button" name="btnSave_AddChildItem_layer" id="btnSave_AddChildItem_layer" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- modalGet Notification -->
            <div class="modal fade" id="modalGet_Notification" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modalGet_Notification">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Mail Details</h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                <button type="submit" class="btn green ladda-button" name="btnSave_Notification" id="btnSave_Notification" data-style="zoom-out"><span class="ladda-label">Send</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Hhistory Notification -->
            <div class="modal fade" id="modalGet_history_Notification" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-lg" style="width:60%;">
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modalGet_history_Notification">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Mail History</h4>
                            </div>
                            <div class="modal-body"></div>
                            
                        </form>
                    </div>
                </div>
            </div>
            
            <!--__update_Action_item -->
            <div class="modal fade" id="modalGetHistory_update_Action_item" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modalGetHistory_update_Action_item">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">New Action Item</h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                <button type="submit" class="btn green ladda-button" name="btnSave_update_Action_item" id="btnSave_update_Action_item" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Accept Status Modal -->
            <div class="modal fade" id="modalGet_Accept_status" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modalGet_Accept_status">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Action Item</h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                
                                <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                <button type="submit" class="btn green ladda-button" name="btnSave_Status_flag" id="btnSave_Status_flag" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Comments Status Modal -->
            <div class="modal fade" id="modalGet_Comments" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modalGet_Comments">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Comments</h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                
                                <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                <button type="submit" class="btn green ladda-button" name="btnSave_Comments" id="btnSave_Comments" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!--Add Services -->
            <div class="modal fade" id="modalGetHistory_logs" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modalGetHistory_logs">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Add Service Log 
                                    (<i style="color:#B73E3E;font-size:12px;font-weight:600;">Please double check the date completed and Account. Thank you</i>)
                                </h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                <button type="submit" class="btn green ladda-button" name="btnSave_add_logs" id="btnSave_add_logs" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
             <!--__update_Action_item history -->
            <div class="modal fade" id="modalGetHistory_update_Action_item_History" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modalGetHistory_update_Action_item_History">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">New Action Item</h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                <button type="submit" class="btn green ladda-button" name="btnSave_update_Action_item_history" id="btnSave_update_Action_item_history" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
       <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>

        <script src="assets/pages/scripts/jquery.table2excel.js" type="text/javascript"></script>
         <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        <script type="text/javascript">
       
          // View Contact
         $(".btnViewMyPro_update").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "MyPro_Folders/fetch_MyPro.php?modalView="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetMyPro_update .modal-body").html(data);
                        selectMulti();
                       
                    }
                });
            });
            
              // View Contact
         $(".btnViewMyPro").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "MyPro_Folders/fetch-Assign.php?modalView="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetMyPro .modal-body").html(data);
                       selectMulti();
                    }
                });
            });
            //Task_History
             // View Contact
         $(".btnViewMyPro_History").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "MyPro_Folders/Task_History.php?modalView="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetMyPro_History .modal-body").html(data);
                        selectMulti();
                    }
                });
            });
            
             // File Section
            function btnNew_History(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/MyPro_function.php?modalAddHistory="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetHistory .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGetHistory").on('submit',(function(e) {
                e.preventDefault();
                var ids = <?= $_GET['view_id'] ?>;
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_AddChildItem',true);

                var l = Ladda.create(document.querySelector('#btnSave_AddChildItem'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/MyPro_function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                           
                            $("#tblHistory").load("MyPro_Action_Items.php?view_id="+ids+" #tblHistory");
                             $('#modalGetHistory').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
             // add new Child
            function btnNew_History_Child(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/MyPro_function.php?modalAddHistory_Child="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetHistory_Child .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGetHistory_Child").on('submit',(function(e) {
                e.preventDefault();
                var ids = <?= $_GET['view_id'] ?>;
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_AddChildItem_layer',true);

                var l = Ladda.create(document.querySelector('#btnSave_AddChildItem_layer'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/MyPro_function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

    
                            $("#tblHistory").load("MyPro_Action_Items.php?view_id="+ids+" #tblHistory");
                             $('#modalGetHistory_Child').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            
            // manaul Notification
            function btnNew_Notification(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Mail_Notification.php?modalAdd_Notification="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_Notification .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_Notification").on('submit',(function(e) {
                e.preventDefault();
                var ids = <?= $_GET['view_id'] ?>;
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Notification',true);

                var l = Ladda.create(document.querySelector('#btnSave_Notification'));
                l.start();

                $.ajax({
                    url: "MyPro_Mail_Notification.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            // $("#tblHistory").load("MyPro_Action_Items.php?view_id="+ids+" #tblHistory");
                             $('#modalGet_Notification').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            
             // Update Action Item
            function btnNew_History_update_Action_item(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/MyPro_function.php?modal_update_Action_item="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetHistory_update_Action_item .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGetHistory_update_Action_item").on('submit',(function(e) {
                e.preventDefault();
                 var ids = <?= $_GET['view_id'] ?>;
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_update_Action_item',true);

                var l = Ladda.create(document.querySelector('#btnSave_update_Action_item'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/MyPro_function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";

                            // var obj = jQuery.parseJSON(response);
                            // var html = '<tr id="tr_'+obj.CAI_id+'">';
                            //     html += '<td >Assign to : '+obj.first_name+'</td>';
                            //     html += '<td >'+obj.CAI_filename+'</td>';
                            //     html += '<td >'+obj.CAI_description+'</td>';
                            //     html += '<td >For '+obj.Action_Items_name+'</td>';
                            //     html += '<td >Estimated: '+obj.CAI_Estimated_Time+' minutes</td>';
                            //     html += '<td >'+obj.CAI_files+'</td>';
                            // html += '</tr>';

                            // $('#accordion2 table tbody').append(html);
                            $("#tblHistory").load("MyPro_Action_Items.php?view_id="+ids+" #tblHistory");
                             $('#modalGetHistory_update_Action_item').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // Accept status
            function btn_Accept_status(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/MyPro_function.php?modal_Status_flag="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_Accept_status .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_Accept_status").on('submit',(function(e) {
                e.preventDefault();
                 var ids = <?= $_GET['view_id'] ?>;
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Status_flag',true);

                var l = Ladda.create(document.querySelector('#btnSave_Status_flag'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/MyPro_function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            $("#tblHistory").load("MyPro_Action_Items.php?view_id="+ids+" #tblHistory");
                             $('#modalGet_Accept_status').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // Comments status
            function btn_Comments(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/MyPro_function.php?modal_Comments="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_Comments .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_Comments").on('submit',(function(e) {
                e.preventDefault();
                 var ids = <?= $_GET['view_id'] ?>;
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Comments',true);

                var l = Ladda.create(document.querySelector('#btnSave_Comments'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/MyPro_function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            $("#tblHistory").load("MyPro_Action_Items.php?view_id="+ids+" #tblHistory");
                             $('#modalGet_Comments').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // Add service log
            function btnNew_History_logs(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/MyPro_function.php?modal_add_logs="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetHistory_logs .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGetHistory_logs").on('submit',(function(e) {
                e.preventDefault();
                 var ids = <?= $_GET['view_id'] ?>;
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_add_logs',true);

                var l = Ladda.create(document.querySelector('#btnSave_add_logs'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/MyPro_function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            $("#tblHistory").load("MyPro_Action_Items.php?view_id="+ids+" #tblHistory");
                             $('#modalGetHistory_logs').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // Update Action Item history
            function btnNew_History_update_Action_item_History(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/MyPro_function.php?modal_update_Action_item_history="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetHistory_update_Action_item_History .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGetHistory_update_Action_item_History").on('submit',(function(e) {
                e.preventDefault();
                 var ids = <?= $_GET['view_id'] ?>;
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_update_Action_item_history',true);

                var l = Ladda.create(document.querySelector('#btnSave_update_Action_item_history'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/MyPro_function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";

                            // var obj = jQuery.parseJSON(response);
                            // var html = '<tr id="tr_'+obj.CAI_id+'">';
                            //     html += '<td >Assign to : '+obj.first_name+'</td>';
                            //     html += '<td >'+obj.CAI_filename+'</td>';
                            //     html += '<td >'+obj.CAI_description+'</td>';
                            //     html += '<td >For '+obj.Action_Items_name+'</td>';
                            //     html += '<td >Estimated: '+obj.CAI_Estimated_Time+' minutes</td>';
                            //     html += '<td >'+obj.CAI_files+'</td>';
                            // html += '</tr>';

                            // $('#accordion2 table tbody').append(html);
                            $("#tblHistory").load("MyPro_Action_Items.php?view_id="+ids+" #tblHistory");
                             $('#modalGetHistory_update_Action_item_History').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            
            function btnNew_File(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/MyPro_function.php?modalNew_File="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalAddActionItem .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalAddActionItem").on('submit',(function(e) {
                e.preventDefault();
                 var ids = <?= $_GET['view_id'] ?>;
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_History',true);

                var l = Ladda.create(document.querySelector('#btnSave_History'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/MyPro_function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            // var obj = jQuery.parseJSON(response);
                            // var html = '<tr  id="tr_'+obj.History_id+'">';
                            //     html += '<td class="paddId">Assign to: '+obj.first_name+'</td>';
                            //     html += '<td class="paddId">'+obj.filename+'</td>';
                            //     html += '<td class="paddId">'+obj.description+'</td>';
                            //     html += '<td class="paddId">Estimated Time: '+obj.Estimated_Time+' minutes</td>';
                            //     html += '<td class="paddId">For '+obj.Action_Items_name+'</td>';
                            //     html += '<td class="paddId">'+obj.files+'</td>';
                            //     html += '<td class="paddId"><a style="font-weight:800;" href="#modalGetHistory" class="btn btn-xs" data-toggle="modal" onclick="btnNew_History('+obj.History_id+')">View</a></td>';
                            // html += '</tr>';

                            // $('#accordion2 table tbody').append(html);
                            $("#tblHistory").load("MyPro_Action_Items.php?view_id="+ids+" #tblHistory");
                             $('#modalAddActionItem').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // Mail history Notification
            function btnHistory_Notification(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Mail_Notification.php?modalHistory_Notification="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_history_Notification .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
        </script>
        <script>
            $(document).ready(function() {
                $("#your_summernotes").summernote({
                    placeholder:'',
                    height: 400
                });
                $('.dropdown-toggle').dropdown();
            });
            function accept_status() {
              document.getElementById("get_status").value = "1";
            }
            function decline_status() {
              document.getElementById("get_status").value = "2";
            }
        </script>
        <style>
            .parentTbls{
              padding: 0px 10px;
            }
            .childTbls td {
                border:solid grey 1px;
              padding: 0px 10px;
            }
            .child-1{
                background-color:#3D8361;
                color:#fff;
                border:solid grey 1px;
                padding: 0px 10px;
            }
            .font-14{
                font-size:14px;
            }
            .paddId{
                font-weight: 600;
                padding: 0px 5px;
              /*white-space: nowrap;*/
            }
            #overflowTable {
              width: 100%;
              height: 100%;
              overflow: scroll;
              border: 1px solid #ccc;
            }
            .completed{
                color:#001E6C;
            }
            .inprogress{
                color:#FBDF07;
            }
            .notstarted{
                color:#FFF7BC;
            }
             .paddId{
             
            }
        </style>
    </body>
</html>
