<?php 
    $title = "My Pro";
    $site = "MyPro_Customer_Services";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';
$base_url = "https://interlinkiq.com/";
    include_once ('header.php'); 
?>
        
                
                    
                    <!--Category-->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_1">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        
                                        <h3 class="font-green-sharp"><span><?php echo '0'; ?></span></h3>
                                        <small>Not Started (Internal)</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-pie-chart" aria-hidden="true"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_2">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                       
                                        <h3 class="font-red-haze"><span><?php echo '0'; ?></span></h3>
                                        <small>In-Progress (Internal)</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-pie-chart" aria-hidden="true"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_3">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                      
                                        <h3 class="font-blue-sharp"><span><?php echo '0';  ?></span></h3>
                                        <small>Not Started (External)</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-bar-chart" aria-hidden="true"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_4">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                       
                                        <h3 class="font-purple-soft"><span><?php echo '0';  ?></span></h3>
                                        <small>In-Progress (External)</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-bar-chart" aria-hidden="true"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                            <a href="#tab_Find_Job" data-toggle="tab"> Find Job </a>
                                        </li>
                                        <li>
                                            <a href="#tab_Internal" data-toggle="tab"> Internal Services </a>
                                        </li>
                                        <li>
                                            <a href="#tab_External" data-toggle="tab"> External Services </a>
                                        </li>
                                        <li>
                                            <a href="#tab_Archived" data-toggle="tab"> Archived </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_Find_Job">
                                                    <h3>Dashboard</h3>
                                             <table class="table table-bordered table-hover" id="sample_4">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Project Name</th>
                                                            <th>Description</th>
                                                            <th>Duration</th>
                                                            <th>Desired Due Date</th>
                                                            <th>Supporting Files</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                         <?php
                                                            $i_user=1;
                                                            $query = "SELECT *  FROM tbl_MyProject_Services";
                                                            $result = mysqli_query($conn, $query);
                                                                                        
                                                            while($row = mysqli_fetch_array($result))
                                                            {?>
                                                            <tr>
                                                                <td><?php echo 'Ticket No.: '.$row['MyPro_id']; ?></td>
                                                                <td><?php echo $row['Project_Name']; ?></td>
                                                                <td><?php echo $row['Project_Description']; ?></td>
                                                                <td><?php echo $row['Project_Duration'].' day/s'; ?></td>
                                                                <td><?php echo date("Y-m-d", strtotime($row['Desired_Deliver_Date'])); ?></td>
                                                                <td><a href="MyPro_Folder_Files/<?php echo $row["Sample_Documents"]; ?>"><?php echo $row["Sample_Documents"]; ?></a></td>
                                                                <td>
                                                                    <a class="btn blue btn-outline btnViewMyPro" data-toggle="modal" href="#modalGetMyPro" data-id="<?php echo $row["MyPro_id"]; ?>" style="float:right;margin-right:20px;">
                                                                            VIEW
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                        </div>
                                        <div class="tab-pane" id="tab_Internal">
                                                    <h3>Internal Services</h3>
                                            <div class="table-scrollable">
                                                <table class="table table-bordered table-hover" id="tableDataServices">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Project Name</th>
                                                            <th>Description</th>
                                                            <th>Assign to</th>
                                                            <th>Duration</th>
                                                            <th>Desired Due Date</th>
                                                            <th>Supporting Files</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $queryInternal = "SELECT *  FROM tbl_MyProject_Services left join tbl_MyProject_Services_Assigned on MyPro_PK = MyPro_id 
                                                            left join tbl_user on ID = User_Assign_PK where Assigned_Status = 1";
                                                            $resultInternal = mysqli_query($conn, $queryInternal);
                                                                                        
                                                            while($rowInternal = mysqli_fetch_array($resultInternal))
                                                            {?>
                                                                <tr>
                                                                    <td><?php echo 'Ticket No.: '.$rowInternal['MyPro_id']; ?></td>
                                                                    <td><?php echo $rowInternal['Project_Name']; ?></td>
                                                                    <td><?php echo $rowInternal['Project_Description']; ?></td>
                                                                    <td><?php echo  $rowInternal['first_name']; ?></td>
                                                                    <td><?php echo $rowInternal['Project_Duration'].' day/s'; ?></td>
                                                                    <td><?php echo date("Y-m-d", strtotime($rowInternal['Desired_Deliver_Date'])); ?></td>
                                                                    <td><a href="MyPro_Folder_Files/<?php echo $rowInternal["Sample_Documents"]; ?>"><?php echo $rowInternal["Sample_Documents"]; ?></a></td>
                                                                    <td>
                                                                        <a class="btn blue btn-outline btnViewMyPro_History" data-toggle="modal" href="#modalGetMyPro_History" data-id="<?php echo $rowInternal["MyPro_id"]; ?>" style="float:right;margin-right:20px;">
                                                                                VIEW
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_External">
                                                    <h3>External Services</h3>
                                            <div class="table-scrollable">
                                                <table class="table table-bordered table-hover" id="tableDataServices">
                                                    <thead>
                                                        <tr>
                                                            <th>Task ID</th>
                                                            <th>PROJECT NAME</th>
                                                            <th style="width: 90px;" class="text-center">TASK PROGRESS</th>
                                                            <th style="width: 135px;" class="text-center">Date Requested</th>
                                                            <th style="width: 135px;" class="text-center">Desire Due Date</th>
                                                            <th style="width: 135px;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_Archived">
                                                    <h3>Archived</h3>
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
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
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
              <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
     <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
     <script type="text/javascript">
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

                            var obj = jQuery.parseJSON(response);
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td >'+obj.files+'</td>';
                                html += '<td >'+obj.filename+'</td>';
                                html += '<td >'+obj.description+'</td>';
                                html += '<td >'+obj.Action_Items_name+' by: '+obj.first_name+'</td>';
                                html += '<td >Rendered: '+obj.Rendered_Minutes+' minutes</td>';
                            html += '</tr>';

                            $('#modalGetMyPro_History table tbody').append(html);
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
           
        </script>  
    </body>
</html>
