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
                                        <span class="caption-subject font-dark bold uppercase">My Pro</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_Dashboard" data-toggle="tab"> Dashboard </a>
                                        </li>
                                        <li>
                                            <a href="#tab_Collaborator_Task" data-toggle="tab">Collaborator Task </a>
                                        </li>
                                        <li>
                                            <a href="#tab_Completed" data-toggle="tab"> Completed </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_Dashboard">
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
                                                        $query = "SELECT *  FROM tbl_MyProject_Services left join tbl_MyProject_Services_Assigned on MyPro_PK = MyPro_id where tbl_MyProject_Services.user_cookies = $i_user";
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
                                                                <a class="btn blue btn-outline btnViewMyPro_update" data-toggle="modal" href="#modalGetMyPro_update" data-id="<?php echo $row['MyPro_id']; ?>">Edit</a>
                                                                <a href="MyPro_Action_Items.php?view_id=<?php echo $row['MyPro_id'];  ?>" class="btn green btn-outline" >
                                                                    View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php }?>
                                                    
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
                                                    
                                                        $i_user = $_COOKIE['ID'];
                                                        
                                                        $query = "SELECT *  FROM tbl_MyProject_Services left join tbl_MyProject_Services_Assigned on MyPro_PK = MyPro_id";
                                                        $result = mysqli_query($conn, $query);
                                                                                    
                                                        while($row = mysqli_fetch_array($result))
                                                        {
                                                            $queryCollab = "SELECT *  FROM tbl_user left join tbl_hr_employee on tbl_hr_employee.ID = employee_id where tbl_user.ID = $i_user";
                                                            $resultCollab = mysqli_query($conn, $queryCollab);
                                                                                        
                                                            while($rowCollab = mysqli_fetch_array($resultCollab))
                                                            {
                                                                $array = explode(", ", $row['Collaborator_PK']);
                                                                echo in_array($rowCollab['ID'], $array);
                                                                if(in_array($rowCollab['ID'], $array) && !empty($row['Collaborator_PK'])){
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo 'No.: '; echo $row['MyPro_id']; ?></td>
                                                                    <td><?php echo $row['Project_Name']; ?></td>
                                                                    <td><?php echo $row['Project_Description']; ?></td>
                                                                    <td><?php echo date("Y-m-d", strtotime($row['Start_Date'])); ?></td>
                                                                    <td><?php echo date("Y-m-d", strtotime($row['Desired_Deliver_Date'])); ?></td>
                                                                    <td>
                                                                        <a class="btn blue btn-outline btnViewMyPro_update" data-toggle="modal" href="#modalGetMyPro_update" data-id="<?php echo $row['MyPro_id']; ?>">Edit</a>
                                                                        <a href="MyPro_Action_Items.php?view_id=<?php echo $row['MyPro_id'];  ?>" class="btn green btn-outline" >
                                                                            View
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                    <?php }}}?>
                                                    
                                                </tbody>
                                            </table>
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
                                        <select class="form-control mt-multiselect btn btn-default" type="text" name="Collaborator[]" multiple required>
                                            <option value="">---Select---</option>
                                            <?php 
                                                
                                                $queryCollab = "SELECT *  FROM tbl_hr_employee where user_id = 34 and status = 1 order by first_name ASC";
                                                $resultCollab = mysqli_query($conn, $queryCollab);
                                                                            
                                                while($rowCollab = mysqli_fetch_array($resultCollab))
                                                { ?> 
                                                <option value="<?php echo $rowCollab['ID']; ?>"><?php echo $rowCollab['first_name']; ?> <?php echo $rowCollab['last_name']; ?></option>
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
                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
       <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
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
        </style>
    </body>
</html>