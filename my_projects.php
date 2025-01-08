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
    
    
//     function fileExtension($file) {
//         $extension = pathinfo($file, PATHINFO_EXTENSION);
//         $src = 'https://view.officeapps.live.com/op/embed.aspx?src=';
//         $embed = '&embedded=true';
//         $type = 'iframe';
//     	if ($extension == "pdf") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-pdf-o"; }
// 		else if (strtolower($extension) == "doc" OR strtolower($extension) == "docx") { $file_extension = "fa-file-word-o"; }
// 		else if (strtolower($extension) == "ppt" OR strtolower($extension) == "pptx") { $file_extension = "fa-file-powerpoint-o"; }
// 		else if (strtolower($extension) == "xls" OR strtolower($extension) == "xlsb" OR strtolower($extension) == "xlsm" OR strtolower($extension) == "xlsx" OR strtolower($extension) == "csv" OR strtolower($extension) == "xlsx") { $file_extension = "fa-file-excel-o"; }
// 		else if (strtolower($extension) == "gif" OR strtolower($extension) == "jpg"  OR strtolower($extension) == "jpeg" OR strtolower($extension) == "png" OR strtolower($extension) == "ico") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-image-o"; }
// 		else if (strtolower($extension) == "mp4" OR strtolower($extension) == "mov"  OR strtolower($extension) == "wmv" OR strtolower($extension) == "flv" OR strtolower($extension) == "avi" OR strtolower($extension) == "avchd" OR strtolower($extension) == "webm" OR strtolower($extension) == "mkv") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-video-o"; }
// 		else { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-code-o"; }

// 		$output['src'] = $src;
// 	    $output['embed'] = $embed;
// 	    $output['type'] = $type;
// 	    $output['file_extension'] = $file_extension;
// 	    return $output;
//     }
?>
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
        padding: 0px 10px;
    }
    #loading
    {
     text-align:center; 
     background: url('loader.gif') no-repeat center; 
     height: 150px;
    }
    .fc-time{
        display:none;
    }
    .min-width{
        min-width:150px !important;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light ">
            <div class="portlet-title tabbable-line tabbable-tabdrop">
                <div class="caption">
                    <i class="icon-earphones-alt font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">My Pro</span>
                </div>
                <ul class="nav nav-tabs">
                     <li class="active">
                        <a href="#tab_Calendar" data-toggle="tab"> Calendar </a>
                    </li>
                    <li>
                        <a href="#tab_Dashboard" data-toggle="tab"> Dashboard </a>
                    </li>
                    
                    <li>
                        <a href="#tab_Me" data-toggle="tab">My Task</a>
                    </li>
                   
                    <li>
                        <a href="#tab_Collaborator_Task" data-toggle="tab">Collaborator Task </a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_Calendar">
                         <div class="row">
                            <div class="col-md-12">
                                <div id="calendar_data" class="has-toolbar"> </div>
                            </div>
                         </div>
                    </div>
                    <div class="tab-pane" id="tab_Dashboard">
                        <h3>Dashboard &nbsp;<a class="btn btn-primary" data-toggle="modal" href="#addNew"> Create Project</a></h3>
                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_4">
                        <thead>
                            <tr>
                                <th>Tickets#</th>
                                 <th>Project Name</th>
                                <th>Description</th>
                                <th>Request Date</th>
                                <th>Desired Due Date</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i_user = $_COOKIE['ID'];
                                    if (isset($_COOKIE['switchAccount'])) { $i_user = $_COOKIE['switchAccount']; }
                                    
                                    $query = "SELECT *  FROM tbl_MyProject_Services left join tbl_MyProject_Services_Assigned on MyPro_PK = MyPro_id where tbl_MyProject_Services.user_cookies = $i_user and Project_status != 2";
                                    $result = mysqli_query($conn, $query);
                                                                
                                    while($row = mysqli_fetch_array($result))
                                    {?>
                                    <tr>
                                        <td><?php echo 'No.: '; echo $row['MyPro_id']; ?></td>
                                        <td><?php echo $row['Project_Name']; ?></td>
                                        <td><?php echo $row['Project_Description']; ?></td>
                                        <td><?php echo date("Y-m-d", strtotime($row['Start_Date'])); ?></td>
                                        <td><?php echo date("Y-m-d", strtotime($row['Desired_Deliver_Date'])); ?></td>
                                        <td>
                                             <?php if($_COOKIE['ID'] == 38): ?>
                                            <a class="btn blue btn-outline btnViewMyPro_update" data-toggle="modal" href="#modalGetMyPro_update" data-id="<?php echo $row['MyPro_id']; ?>">Edit</a>
                                            <?php endif; ?>
                                            <a href="my_project_details.php?view_id=<?php echo $row['MyPro_id'];  ?>" class="btn green btn-outline" >
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                <?php }?>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="tab_Me"> 
                        <?php
                            $query = "SELECT DISTINCT(CIA_progress) FROM tbl_MyProject_Services_Childs_action_Items where CIA_progress != 2";
                            $statement = $connect->prepare($query);
                            $statement->execute();
                            $result = $statement->fetchAll();
                            foreach($result as $row)
                            {?>
                                <div class="col-md-3">
                                    <label><input type="radio" name="radio" class="common_selector status" value="<?php echo $row['CIA_progress']; ?>"  > <?php  if($row['CIA_progress']== 1){echo 'Inprogress';}else if($row['CIA_progress']== 2){echo 'Completed';}else{echo 'Not Started';} ?></label>
                                </div>
                            <?php } ?>
                                <div class="col-md-3">
                                    <label><input type="radio" name="radio" class="common_selector_all status"> All</label>
                                </div>
                    	<table class="table table-bordered table-hover dt-responsive" id="tblAssignTask">
            				<tbody>
            				    <?php
            				    
                                $a_user = $_COOKIE['employee_id'];
                                $query = "SELECT *  FROM tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                                left join tbl_hr_employee on CAI_Assign_to = ID
                                left join tbl_MyProject_Services on MyPro_id = Parent_MyPro_PK
                                where CAI_Assign_to = $a_user and CAI_Assign_to !=0 and CAI_Assign_to !='' and CAI_Assign_to !=' ' and CIA_progress != 2 ";
                                if(!empty(isset($_GET["status"])))
                                {
                                    $status_filter = $_GET["status"];
                                	$query .= "
                                	 AND CIA_progress IN('".$status_filter."') order by CAI_id DESC
                                	";
                                }
                                else
                                {
                                    $query .= "
                                	 order by CAI_id DESC
                                	";
                                }
                            
                            $result = mysqli_query($conn, $query);
                                                        
                            while($row = mysqli_fetch_array($result))
                            {
                                $filesL3 = $row["CAI_files"];
                                $fileExtension = fileExtension($filesL3);
								$src = $fileExtension['src'];
								$embed = $fileExtension['embed'];
								$type = $fileExtension['type'];
								$file_extension = $fileExtension['file_extension'];
					           $url = $base_url.'MyPro_Folder_Files/';
                            ?>
                                <tr id="<?php echo $row["CAI_id"]; ?>"  class="parentTbls">
                                <td><?php echo $row["CAI_id"]; ?></td>
                                <td><b>Ticket #:</b><?php echo $row["Parent_MyPro_PK"]; ?> <br><a href="my_project_details.php?view_id=<?php echo $row['Parent_MyPro_PK'];  ?>#<?php echo $row["CAI_id"]; ?>"><?php echo $row["Project_Name"]; ?></a></td>
                                <td><b>Description:</b><br><?php echo $row["Project_Description"]; ?></td>
                                <td><b>Task:</b> <br><?php echo $row["CAI_filename"]; ?></td>
                                <td><?php echo $row["Action_Items_name"]; ?></td>
                                <td><?php echo $row["CAI_description"]; ?></td>
				        	    <td>
				        	        <a data-src="<?php echo $src.$url.rawurlencode($filesL3).$embed; ?>" data-fancybox data-type="<?php echo $type; ?>" class="btn btn-link">
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
				        	  <td> Assign to: <?php echo $row["first_name"]; ?></td>
				        	    <td>
				        	            <?php 
					        	            if($row['CIA_progress']== 1){ echo '<b class="inprogress">Inprogress</b>'; }
					        	            else if($row['CIA_progress']== 2){ echo '<b class="completed">Completed</b>';}
					        	            else{ echo '<b class="notstarted">Not Started</b>';}
				        	            ?>
				        	      </td>
                                <td>Estimated: <?php echo $row["CAI_Estimated_Time"]; ?> minutes</td>
				        	      <?php
					        	    if(!empty($row['CAI_Rendered_Minutes'])){ ?>
					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;">
					        	            <?php echo 'Rendered: '; ?>
					        	            <?php echo $row['CAI_Rendered_Minutes']; ?>
					        	            <?php echo 'minute(s)'; ?>
					        	        </td>
					        	    <?php } ?>
					        	    <?php
					        	    if($row['CIA_progress']==2){ ?>
					        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;">
					        	            <?php echo '100%'; ?>
					        	        </td>
					        	    <?php } ?>
					        	   <td>
				        	            <?php echo 'Date: '; ?>
				        	            <?php echo date("Y-m-d", strtotime($row['CAI_Action_date'])); ?>
				        	        </td>
                                <td>
                                    
                                    <!--<a style="font-weight:800;" href="#modalGetHistory_Child" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child(<?php //echo  $row['CAI_id']; ?>)">Add</a>-->
                                    <!--<a style="font-weight:800;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn btn-xs red" onclick="btnNew_History_update_Action_item(<?php //echo  $row['CAI_id']; ?>)">View</a>-->
                                </td>
                            </tr>
                            
            				<?php  } ?> 
            				</tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="tab_Collaborator_Task">
                        <h3>Dashboard &nbsp;<a class="btn btn-primary" data-toggle="modal" href="#addNew"> Create Project</a></h3>
                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
                        <thead>
                            <tr>
                                <th>Tickets#</th>
                                 <th>Project Name</th>
                                <th>Description</th>
                                <th>Request Date</th>
                                <th>Desired Due Date</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // $switch_user_id
                                    $loggin_emp = $_COOKIE['employee_id'];
                                    $query_emp = "SELECT *  FROM tbl_hr_employee where ID = $loggin_emp ";
                                    $result_emp = mysqli_query($conn, $query_emp);
                                    while($row_emp = mysqli_fetch_array($result_emp))
                                    {
                                        $temp_id = $row_emp['ID'];
                                        $query = "SELECT *  FROM tbl_MyProject_Services where  Project_status != 2 ";
                                        $result = mysqli_query($conn, $query);
                                        while($row = mysqli_fetch_array($result))
                                        {
                                            $array = explode(", ", $row['Collaborator_PK']);
                                            if(in_array($temp_id,$array)){
                                                ?>
                                                <tr>
                                                    <td><?php echo 'No.: '; echo $row['MyPro_id']; ?></td>
                                                    <td><?php echo $row['Project_Name']; ?></td>
                                                    <td><?php echo $row['Project_Description']; ?></td>
                                                    <td><?php echo date("Y-m-d", strtotime($row['Start_Date'])); ?></td>
                                                    <td><?php echo date("Y-m-d", strtotime($row['Desired_Deliver_Date'])); ?></td>
                                                    <td>
                                                        <?php if($_COOKIE['ID'] == 38): ?>
                                                        <a class="btn blue btn-outline btnViewMyPro_update" data-toggle="modal" href="#modalGetMyPro_update" data-id="<?php echo $row['MyPro_id']; ?>">Edit</a>
                                                        <?php endif; ?>
                                                        <a href="my_project_details.php?view_id=<?php echo $row['MyPro_id'];  ?>" class="btn green btn-outline" >
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>
                                         <?php }
                                        }
                                    }
                                 ?>
                                 <?php
                                 
                                    $loggin_user = $_COOKIE['ID'];
                                    $query_user = "SELECT *  FROM tbl_user where ID = $loggin_user ";
                                    $result_user = mysqli_query($conn, $query_user);
                                    while($row_user = mysqli_fetch_array($result_user))
                                    {
                                        $user_ids = $row_user['ID'];
                                        $query = "SELECT *  FROM tbl_MyProject_Services where  Project_status != 2 ";
                                        $result = mysqli_query($conn, $query);
                                        while($row = mysqli_fetch_array($result))
                                        {
                                            $array = explode(", ", $row['Collaborator_PK']);
                                            if(in_array($user_ids,$array)){
                                                ?>
                                                <tr>
                                                    <td><?php echo 'No.: '; echo $row['MyPro_id']; ?></td>
                                                    <td><?php echo $row['Project_Name']; ?></td>
                                                    <td><?php echo $row['Project_Description']; ?></td>
                                                    <td><?php echo date("Y-m-d", strtotime($row['Start_Date'])); ?></td>
                                                    <td><?php echo date("Y-m-d", strtotime($row['Desired_Deliver_Date'])); ?></td>
                                                    <td>
                                                        <?php if($_COOKIE['ID'] == 38): ?>
                                                        <a class="btn blue btn-outline btnViewMyPro_update" data-toggle="modal" href="#modalGetMyPro_update" data-id="<?php echo $row['MyPro_id']; ?>">Edit</a>
                                                        <?php endif; ?>
                                                        <a href="my_project_details.php?view_id=<?php echo $row['MyPro_id'];  ?>" class="btn green btn-outline" >
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>
                                         <?php }
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Certification MODAL AREA-->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="MyPro_Folders/mypro_action.php" method="POST" enctype="multipart/form-data">
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
                                <label>Account</label>
                                <select class="form-control mt-multiselect btn btn-default" type="text" name="h_accounts" required>
                                <?php
                                     $query_accounts = "SELECT * FROM tbl_service_logs_accounts order by name ASC";
                                    $result_accounts = mysqli_query($conn, $query_accounts);
                                    while($row_accounts = mysqli_fetch_array($result_accounts))
                                         { 
                                           echo '<option value="'.$row_accounts['name'].'" '; echo 'CONSULTAREINC' == $row_accounts['name'] ? 'selected':''; echo'>'.$row_accounts['name'].'</option>'; 
                                       } 
                                ?>
                                </select>
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
                                 <div class="col-md-12">
                                    <label>Image/file </label>
                                </div>
                                <div class="col-md-12">
                                    <input class="form-control" type="file" name="Sample_Documents">
                                </div>
                            </div>
                        </div>
                       
                        <br>
                       <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label>Start Date</label>
                                    <input class="form-control" type="date" name="Start_Date" value="<?php echo date("Y-m-d", strtotime(date("Y/m/d"))); ?>" required />
                                </div>
                                <div class="col-md-6" >
                                    <label>Desired Deliver Date</label>
                                    <input class="form-control" type="date" name="Desired_Deliver_Date" value="<?php echo date("Y-m-d", strtotime(date("Y/m/d"))); ?>" required />
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
                                    <select class="form-control" type="text" name="Collaborator[]" multiple required>
                                        <option value="">---Select---</option>
                                        <?php 
                                            
                                            $queryCollab = "SELECT *  FROM tbl_hr_employee where user_id = 34 and status = 1 order by first_name ASC";
                                            $resultCollab = mysqli_query($conn, $queryCollab);
                                                                        
                                            while($rowCollab = mysqli_fetch_array($resultCollab))
                                            { ?> 
                                            <option value="<?php echo $rowCollab['ID']; ?>"><?php echo $rowCollab['first_name']; ?> <?php echo $rowCollab['last_name']; ?></option>
                                        <?php } ?>
                                        
                                        <?php 
                                            
                                            $query = "SELECT *  FROM tbl_user where ID = 155 and ID = 308";
                                            $result = mysqli_query($conn, $query);
                                                                        
                                            while($row = mysqli_fetch_array($result))
                                            { ?> 
                                            <option value="<?php echo $row['ID']; ?>"><?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></option>
                                        <?php } ?>
                                         </select>
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
    <?php include"mypro_main_folder/mypro_main_modals.php"; ?>
    <!-- / END MODAL AREA -->
                 
</div><!-- END CONTENT BODY -->
        
<?php include_once ('footer.php'); ?>
<script src="assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
<script src="assets/pages/scripts/jquery.table2excel.js" type="text/javascript"></script>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
<script src="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
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
           
        }
    });
});

// View Contact
$(".btnViewMyPro_History").click(function() {
    var id = $(this).data("id");
    $.ajax({    
        type: "GET",
        url: "MyPro_Folders/Task_History.php?modalView="+id,
        dataType: "html",
        success: function(data){
            $("#modalGetMyPro_History .modal-body").html(data);
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
        }
    });
}
$(".modalGetHistory").on('submit',(function(e) {
    e.preventDefault();

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
                $( "#tblHistory" ).load( "MyPro.php #tblHistory" );
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
    var a_user = <?php $_COOKIE['employee_id']; ?>
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

                $("#tblAssignTask").load("MyPro.php? #tblAssignTask");
                 $('#modalGetHistory_Child').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
            
 // Update shortcut >
function onclick_shortcut(id){
    $.ajax({
        type: "GET",
        url: "mypro_main_folder/mypro_action.php?getId_shortcut="+id,
        dataType: "html",
        success: function(data){
            $("#modalGet_shortcut .modal-body").html(data);
            $(".modalForm").validate();
            selectMulti();
        }
    });
}
$(".modalGet_shortcut").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSubmit_shortcut',true);

    var l = Ladda.create(document.querySelector('#btnSubmit_shortcut'));
    l.start();

    $.ajax({
        url: "mypro_main_folder/mypro_action.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Sucessfully Save!";
                
                var obj = jQuery.parseJSON(response);
                    var data = '<td class="child_border" width="80px" style="border:solid yellow 1px;">'+obj.CAI_id+'</td>';
                    data += '<td class="child_2" style="border:solid yellow 1px;">From: '+obj.CAI_User_PK+'</td>';
                    data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_filename+'</td>';
                    data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_description+'</td>';
                    data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_Accounts+'</td>';
                    data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.Action_Items_name+'</td>';
                    data += '<td class="child_2" style="border:solid yellow 1px;">Assign to: '+obj.CAI_Assign_to+'</td>';
                    data += '<td class="child_2" style="border:solid yellow 1px;"><b>'+obj.CIA_progress+'</b></td>';
                    data += '<td class="child_2" style="border:solid yellow 1px;">Rendered: '+obj.CAI_Rendered_Minutes+'</td>';
                    data += '<td class="child_2" style="border:solid yellow 1px;">Start: '+obj.CAI_Action_date+'</td>';
                    data += '<td class="child_2" style="border:solid yellow 1px;">Due: '+obj.CAI_Action_due_date+'</td>';
                    data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_files+'</td>';
                    data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.comment+'</td>';
                    data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.action_btn+'</td>';
                    $('#cal_'+obj.CAI_id).empty();
                $('#cal_'+obj.CAI_id).append(data);
                 $('#modalGet_shortcut').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));
// File Section
function btnNew_History_update_Action_item(id) {
    $.ajax({
        type: "GET",
        url: "MyPro_Folders/MyPro_function.php?modal_update_Action_item="+id,
        dataType: "html",
        success: function(data){
            $("#modalGetHistory_update_Action_item .modal-body").html(data);
            $(".modalForm").validate();
        }
    });
}
$(".modalGetHistory_update_Action_item").on('submit',(function(e) {
    e.preventDefault();
    var ids = 134;
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
                $( "#tblAssignTask" ).load( "MyPro.php #tblAssignTask" );
                $( "#tblHistory" ).load( "MyPro.php #tblHistory" );
                 $('#modalGetHistory_update_Action_item').modal('hide');
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
        }
    });
}
$(".modalAddActionItem").on('submit',(function(e) {
    e.preventDefault();

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
                $( "#tblHistory" ).load( "MyPro.php #tblHistory" );
                 $('#modalAddActionItem').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
            
// for My Task 
$(document).ready(function(){

    // calendar
    var calendar = $('#calendar_data').fullCalendar({
        editable:true,
        header:{
            left:'prev,next today',
            center:'title',
            right:'month,agendaWeek,agendaDay'
        },
        events:'mypro_main_folder/calendar_fetch_data.php',
        editable:true,
        eventDrop:function(event){
            // alert(event.title + " was dropped on " + event.start.toISOString());
    
            var start = event.start.toISOString();
            var end = event.end.toISOString();
            var title = event.title;
            var id = event.id;
            $.ajax({
                url:"mypro_main_folder/calendar_drop_update.php",
                type:"POST",
                data:{
                    title:title,
                    start:start,
                    end:end,
                    id:id
                },
                success:function(data){
                    calendar.fullCalendar('refetchEvents');
                     //console.log('done : ' + data);
                }
            });
            
        },
        eventClick:  function(event) {
            // jQuery.noConflict();
            var id = event.id;
            $.ajax({
                type: "GET",
                url: "mypro_main_folder/calendar_event_click.php?postId="+id,
                dataType: "html",
                success: function(data){
                    $("#calendarModal .modal-body").html(data);
                    $('#calendarModal').modal('show');
                    // selectMulti();
                }
            });
            $('#calendarModal').modal('show');
        },
    }); 
    //filter
    function filter_data() {
        var stat = get_filter('status');
         //alert("MyPro.php?status="+stat+" #tblAssignTask");
        $("#tblAssignTask").load("MyPro.php?status="+stat+" #tblAssignTask");
    }
    
    function filter_data_all() {
        $("#tblAssignTask").load("MyPro.php #tblAssignTask");
    }
    
    function get_filter(class_name) {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

    $('.common_selector').click(function(){
        filter_data();
    });
    // view all
    $('.common_selector_all').click(function(){
        filter_data_all();
    });

});
           
</script>
</body>
</html>