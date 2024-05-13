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
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light ">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-earphones-alt font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">My Pro</span>
                    <?php if($_COOKIE['ID'] == 34 OR $_COOKIE['ID'] == 387 OR $_COOKIE['ID'] == 32 OR $_COOKIE['ID'] == 54 OR $_COOKIE['ID'] == 38): ?>
                        <a class="btn btn-primary btn-xs" data-toggle="modal" href="#addNew_payroll_periods">Add Event</a>
                    <?php endif; ?>
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
                                <div id="calendar_data"> </div>
                            </div>
                         </div>
                    </div>
                    <div class="tab-pane" id="tab_Dashboard">
                        <h3>Dashboard &nbsp;<a class="btn btn-primary" data-toggle="modal" href="<?php echo $FreeAccess == false ? '#addNew':'#modalService'; ?>"> Create Project</a></h3>
                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_4">
                        <thead>
                            <tr>
                                <th>Tickets#</th>
                                 <th>Project Name</th>
                                <th>Task Description</th>
                                <th>Request Date</th>
                                <th>Desired Due Date</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="project_data">
                                <?php
                                    $childcolor1 ='';
                                    $i_user = $_COOKIE['ID'];
                                    if (isset($_COOKIE['switchAccount'])) { $i_user = $_COOKIE['switchAccount']; }
                                    
                                    $query = "SELECT * FROM tbl_MyProject_Services left join tbl_MyProject_Services_Assigned on MyPro_PK = MyPro_id where tbl_MyProject_Services.user_cookies = $i_user and Project_status != 2 and is_deleted = 0";
                                    $result = mysqli_query($conn, $query);
                                                                
                                    while($row = mysqli_fetch_array($result))
                                    {?>
                                    <tr id="row_proj_<?= $row['MyPro_id']; ?>">
                                        <td><?php echo 'No.: '; echo $row['MyPro_id']; ?></td>
                                        <td><?php echo $row['Project_Name']; ?></td>
                                        <td><?php echo $row['Project_Description']; ?></td>
                                        <td><?php echo date("Y-m-d", strtotime($row['Start_Date'])); ?></td>
                                        <td><?php echo date("Y-m-d", strtotime($row['Desired_Deliver_Date'])); ?></td>
                                        <td>
                                             <?php if($_COOKIE['ID'] == 38): ?>
                                            <a class="btn blue btn-outline btnViewMyPro_update" data-toggle="modal" href="#modalGetMyPro_update" data-id="<?php echo $row['MyPro_id']; ?>">Edit</a>
                                            <?php endif; ?>
                                            <a href="mypro_task.php?view_id=<?php echo $row['MyPro_id'];  ?>" class="btn green btn-outline" >
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
                            $connect = new PDO("mysql:host=localhost;dbname=brandons_interlinkiq", "brandons_interlinkiq", "iz8gbjBQqhcy~+WNSj");
                            $query = "SELECT DISTINCT(CIA_progress) FROM tbl_MyProject_Services_Childs_action_Items where CIA_progress != 2";
                            $statement = $connect->prepare($query);
                            $statement->execute();
                            $result = $statement->fetchAll();
                            foreach($result as $row)
                            { ?>
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
                                <td><b>Ticket #:</b><?php echo $row["Parent_MyPro_PK"]; ?> <br><a href="mypro_task.php?view_id=<?php echo $row['Parent_MyPro_PK'];  ?>#<?php echo $row["CAI_id"]; ?>"><?php echo $row["Project_Name"]; ?></a></td>
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
				        	  <td> Assigned To: <?php echo $row["first_name"]; ?></td>
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
                        <h3>Dashboard &nbsp;<a class="btn btn-primary" data-toggle="modal" href="<?php echo $FreeAccess == false ? '#addNew':'#modalService'; ?>"> Create Project</a></h3>
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
                                                        <a href="mypro_task.php?view_id=<?php echo $row['MyPro_id'];  ?>" class="btn green btn-outline" >
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
                                                        <a href="mypro_task.php?view_id=<?php echo $row['MyPro_id'];  ?>" class="btn green btn-outline" >
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
    <!--Create Project MODAL AREA-->
     <!--Certification MODAL AREA-->
   
    <?php include "mypro_function/modals.php"; ?>
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
$(document).ready(function(){
    //summer notes
    $("#your_summernotes").summernote({
        placeholder:'',
        height: 100
    });
    $('.dropdown-toggle').dropdown();
});
$(document).ready(function(){
    //summer notes
     $("#your_summernotes2").summernote({
        placeholder:'',
        height: 100
    });
    $('.dropdown-toggle').dropdown();
});
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
        events:'mypro_function/fetch_calendar.php',
        editable:true,
        eventDrop:function(event){
    
            var start = event.start.toISOString();
            var end = event.end.toISOString();
            var title = event.title;
            var id = event.id;
            $.ajax({
                url:"mypro_function/update-task-calendar.php",
                type:"POST",
                data:{
                    title:title,
                    start:start,
                    end:end,
                    id:id
                },
                success:function(data){
                    calendar.fullCalendar('refetchEvents');
                }
            });
            
        },
        eventClick:  function(event) {
             // jQuery.noConflict();
            var id = event.id;
            $.ajax({
                type: "GET",
                url: "mypro_function/calendar_event_click.php?postId="+id,
                dataType: "html",
                success: function(data){
                    $("#calendarModal .modal-body").html(data);
                    $('#calendarModal').modal('show');
                    selectMulti();
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

// Edit on calendar modal
$(".calendarModal").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSubmit_calendar',true);

    var l = Ladda.create(document.querySelector('#btnSubmit_calendar'));
    l.start();

    $.ajax({
        url: "mypro_function/action.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Updated Sucessfully!";
                $('#get_calendar_data').empty();
                $('#get_calendar_data').append(response);
                selectMulti();
                //  $('#calendarModal').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));

// add event modal
$(".addNew_payroll_periods").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnAdd_payroll_periods',true);

    var l = Ladda.create(document.querySelector('#btnAdd_payroll_periods'));
    l.start();

    $.ajax({
        url: "mypro_function/action.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Added Sucessfully!";
                location.reload();
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));

// add event modal
$(".addNew").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnCreate_Project',true);

    var l = Ladda.create(document.querySelector('#btnCreate_Project'));
    l.start();

    $.ajax({
        url: "mypro_function/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Added Sucessfully!";
                $('#project_data').append(response);
                $('#addNew').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));
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
        padding: 0px 10px;
    }
    #loading
    {
     text-align:center; 
     background: url('loader.gif') no-repeat center; 
     height: 150px;
    }
   .fc-event .fc-time{
        display:none !important;
        color:transparent;
    }
    b{
        /*color:black;*/
    }
</style>
</body>
</html>