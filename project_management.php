<?php 
$date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
$today_tx = $date_default_tx->format('Y-m-d');
    $title = "Project Management";
    $site = "project_management";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php');
?>
<style type="text/css">
    .bootstrap-tagsinput { min-height: 100px; }
    .mt-checkbox-list {
        column-count: 3;
        column-gap: 40px;
    }
    #tableData_Contact input,
    #tableData_Material input,
    #tableData_Service input {
        border: 0 !important;
        background: transparent;
        outline: none;
    }
</style>


<div class="row">
    <div class="col-md-12">
        <!-- BEGIN BORDERED TABLE PORTLET-->
        <div class="portlet light portlet-fit ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">Project Management</span>
                </div>
                <div class="actions">
                    <div class="portlet-title tabbable-line">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_Calendar" data-toggle="tab">Calendar</a>
                            </li>
                            <li>
                                <a href="#tab_Project" data-toggle="tab" >Project List</a>
                            </li>
                            <li>
                                <a href="#tab_Completed" data-toggle="tab" onclick="completed_btn();">Completed</a>
                            </li>
                            <?php
                               $userIds = $_COOKIE['employee_id'];
                                $filter_ = mysqli_query($conn, "select * from tbl_hr_employee where ID = $userIds and department_id = 39 or department_id = 36 GROUP BY department_id limit 1");
                                foreach($filter_ as $f_row){?>
                                    <li>
                                        <a href="#tab_for_pay" data-toggle="tab" onclick="topay_btn();">For Pay</a>
                                    </li>
                                    <!--<li>-->
                                    <!--    <a href="#tab_Paid" data-toggle="tab" onclick="paid_btn();">Paid</a>-->
                                    <!--</li>-->
                                <?php }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                        <div class="tab-pane active" id="tab_Calendar">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="todo-ui">
                                        <!-- BEGIN TODO CONTENT -->
                                        <div class="todo-content">
                                            <div class="portlet light ">
                                                <!-- PROJECT HEAD -->
                                                <div class="portlet-title">
                                                    
                                                    <div class="tools">
                                                        <a href="" class="collapse"> </a>
                                                        <a href="" class="fullscreen"> </a>
                                                    </div>
                                                    <div class="caption">
                                                        <i class="icon-bar-chart font-blue-sharp hide"></i>
                                                        <!--<span class="caption-helper">Your Projects:</span> &nbsp;-->
                                                        <span class="caption-subject font-blue-sharp bold uppercase">Calendar</span>
                                                    </div>
                                                    
                                                </div>
                                                <!-- end PROJECT HEAD -->
                                                <div class="portlet-body">
                                                    <div class="row">
                                                        <div class="todo-tasklist-devider"> </div>
                                                            <div class="col-md-12">
                                                                <!-- TASK HEAD -->
                                                                <div id="calendar_data" > </div>
                                                            </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END TODO CONTENT -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_Project">
                            <div class="portlet-title">
                                 <div class="actions">
                                    <div class="btn-group">
                                        <a class="btn green btn-outline btn btn-sm" href="#modalAdd_details" data-toggle="modal" class="btn btn-outline dark btn-sm"  data-close-others="true"> 
                                            Add New
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-scrollable" style="border:none;">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
                                          <thead>
                                            <tr>
                                                <th></th>
                                              <th>Project Name </th>
                                              <th>Descriptions </th>
                                              <th>Assigned To </th>
                                              <th>Project Date </th>
                                              <th>Project No </th>
                                              <th>Start Date</th>
                                              <th>Completion Date </th>
                                              <th>Allocated Hour/s </th>
                                              <th>Area</th>
                                              <th>Supporting Files</th>
                                              <th></th>
                                            </tr>
                                          </thead>
                                          <tbody id="data_project">
                                            <?php
                                                
                                                $cookies = $_COOKIE['ID'];
                                                $query = "SELECT *  FROM tbl_project_management where addedby = '$cookies' and is_completed = 0";
                                                $result = mysqli_query($conn, $query);
                                                while($row = mysqli_fetch_array($result))
                                                {?>
                                                    <tr id="row_<?= $row['project_pk']; ?>">
                                                        <td><a href="#modal_completed_plan" data-toggle="modal" type="button" id="completed_btn" data-id="<?= $row['project_pk']; ?>" class="btn green btn-xs" onclick=""><i class="fa fa-check"></i></a></td>
                                                        <td><?= $row['project_name']; ?></td>
                                                        <td><?= $row['descriptions']; ?></td>
                                                        <td>
                                                            <?php
                                                                $your_emp = $_COOKIE['employee_id'];
                                                                $project_pk = $row['project_pk'];
                                                                $qry = mysqli_query($conn, "select DISTINCT(assigned_to),project_id from tbl_project_management_scope where project_id = '$project_pk' and is_deleted = 0");
                                                                foreach($qry as $assg_row){
                                                                    $assigned_to = $assg_row['assigned_to'];
                                                                    $emp_qry = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$assigned_to'");
                                                                    foreach($emp_qry as $emp_assg){
                                                                        echo $emp_assg['first_name'].' '.$emp_assg['last_name'].'<br>';
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?= date('Y-m-d', strtotime($row['project_date'])); ?></td>
                                                        <td><?= $row['project_no']; ?></td>
                                                        <td><?= date('Y-m-d', strtotime($row['start_date'])); ?></td>
                                                        <td><?= date('Y-m-d', strtotime($row['completion_date'])); ?></td>
                                                        <td><?= $row['allocate_hour']; ?></td>
                                                        <td><?= $row['project_area']; ?></td>
                                                        <td><a href="project_management_file/<?= $row['supporting_files']; ?>" target="_blank"><?= $row['supporting_files']; ?></a></td>
                                                        <td style="width:100px;">
                                                            <div class="btn-group btn-group-circle">
                                                               <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details(<?php echo  $row['project_pk']; ?>)">Edit</a>
                                                                <a class="btn red btn-sm" type="button" id="print_btn" data-id="<?php echo  $row['project_pk']; ?>">PDF</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            ?>
                                            <?php
                                                $cookies = $_COOKIE['ID'];
                                                $emp_cookies = $_COOKIE['employee_id'];
                                                $query = "SELECT *  FROM tbl_project_management where addedby != '$cookies' and is_completed = 0";
                                                $result = mysqli_query($conn, $query);
                                                while($row = mysqli_fetch_array($result))
                                                {
                                                    $array_data = explode(", ", $row["collaborator_pk"]);
                                                    if(in_array($emp_cookies,$array_data)){?>
                                                    <tr id="row_<?= $row['project_pk']; ?>">
                                                        <td><a href="#modal_completed_plan" data-toggle="modal" type="button" id="completed_btn" data-id="<?= $row['project_pk']; ?>" class="btn green btn-xs" onclick=""><i class="fa fa-check"></i></a></td>
                                                        <td><?= $row['project_name']; ?></td>
                                                        <td><?= $row['descriptions']; ?></td>
                                                        <td><?= date('Y-m-d', strtotime($row['project_date'])); ?></td>
                                                        <td><?= $row['project_no']; ?></td>
                                                        <td><?= date('Y-m-d', strtotime($row['start_date'])); ?></td>
                                                        <td><?= date('Y-m-d', strtotime($row['completion_date'])); ?></td>
                                                        <td><?= $row['allocate_hour']; ?></td>
                                                        <td><?= $row['project_area']; ?></td>
                                                        <td><a href="project_management_file/<?= $row['supporting_files']; ?>" target="_blank"><?= $row['supporting_files']; ?></a></td>
                                                        <td style="width:100px;">
                                                            <div class="btn-group btn-group-circle">
                                                               <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details(<?php echo  $row['project_pk']; ?>)">Edit</a>
                                                                <a class="btn red btn-sm" type="button" id="print_btn" data-id="<?php echo  $row['project_pk']; ?>">PDF</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } }
                                            ?>
                                          </tbody>
                                    </table>
                                </div>
                            </div>
                      </div>
                      <div class="tab-pane" id="tab_Completed">
                          <div class="table-scrollable" style="border:none;">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="" style="table-layout: fixed;">
                                      <thead>
                                        <tr>
                                          <th>Project Name </th>
                                          <th>Descriptions </th>
                                          <th>Assigned To </th>
                                          <th>Project Date </th>
                                          <th>Project No </th>
                                          <th>Start Date</th>
                                          <th>Completion Date </th>
                                          <th>Allocated Hour/s </th>
                                          <th>Area</th>
                                          <th>Supporting Files</th>
                                          <th style="width:120px;"></th>
                                        </tr>
                                      </thead>
                                      <tbody id="data_completed">
                                        
                                      </tbody>
                                </table>
                            </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="tab_for_pay">
                          <div class="table-scrollable" style="border:none;">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="" style="table-layout: fixed;">
                                      <thead>
                                        <tr>
                                          <th>Project Name </th>
                                          <th>Descriptions </th>
                                          <th>Assigned To </th>
                                          <th>Project Date </th>
                                          <th>Project No </th>
                                          <th>Start Date</th>
                                          <th>Completion Date </th>
                                          <th>Allocated Hour/s </th>
                                          <th>Area</th>
                                          <th>Supporting Files</th>
                                          <th style="width:120px;"></th>
                                        </tr>
                                      </thead>
                                      <tbody id="data_pay">
                                        
                                      </tbody>
                                </table>
                            </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="tab_Paid">
                          <div class="table-scrollable" style="border:none;">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id=""  style="table-layout: fixed;">
                                      <thead>
                                        <tr>
                                          <th>Project Name </th>
                                          <th>Descriptions </th>
                                          <th>Assigned To </th>
                                          <th>Project Date </th>
                                          <th>Project No </th>
                                          <th>Start Date</th>
                                          <th>Completion Date </th>
                                          <th>Allocated Hour/s </th>
                                          <th>Area</th>
                                          <th>Supporting Files</th>
                                          <th style="width:120px;"></th>
                                        </tr>
                                      </thead>
                                      <tbody id="data_paid">
                                        
                                      </tbody>
                                </table>
                            </div>
                        </div>
                      </div>
                      
                  </div>
            </div>
        </div>
        <!-- END BORDERED TABLE PORTLET-->
    </div>
   <!-- MODAL AREA -->
   <!-- new task modal -->
   
   <!-- Get status -->

 <!-- add new -->
<div class="modal fade" id="modalAdd_details" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-full" >
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalAdd_details">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <center><h4 class="modal-title"><b>Project Management Form</b></h4></center>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <label class="control-label">Project Name:</label>
                                <input class="form-control border-bottom" type="" name="project_name" required>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">Description:</label>
                                <textarea class="form-control border-bottom" name="descriptions" rows="6"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <label class="control-label">Date</label>
                                <input class="form-control border-bottom" type="date" name="project_date" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d'))); ?>" required>
                                <br>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">Project No.:</label>
                                <input class="form-control border-bottom" type="" name="project_no">
                                <br>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Start Date:</label>
                                <input class="form-control border-bottom" type="date" name="start_date" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d'))); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Target Completion Date:</label>
                                <input class="form-control border-bottom" type="date" name="completion_date" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d'))); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="control-label">Allocated hour/s:</label>
                            <input class="form-control border-bottom" type="number" name="allocate_hour">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Supporting Files:</label>
                            <input class="form-control border-bottom" type="file" name="supporting_files">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="control-label">Involve Personnel/s:</label>
                            <select class="form-control mt-multiselect btn btn-default" type="text" name="collaborator_pk[]" multiple>
                                <option value="">---Select---</option>
                                
                                <?php 
                                    
                                    $queryCollab = "SELECT *  FROM tbl_hr_employee where user_id = $switch_user_id order by first_name ASC";
                                    $resultCollab = mysqli_query($conn, $queryCollab);
                                                                
                                    while($rowCollab = mysqli_fetch_array($resultCollab))
                                    { ?> 
                                    <option value="<?php echo $rowCollab['ID']; ?>"><?php echo $rowCollab['first_name']; ?> <?php echo $rowCollab['last_name']; ?></option>
                                <?php } ?>
                                
                                <?php 
                                    
                                    $query = "SELECT *  FROM tbl_user where ID = $switch_user_id";
                                    $result = mysqli_query($conn, $query);
                                                                
                                    while($row = mysqli_fetch_array($result))
                                    { ?> 
                                    <option value="<?php echo $row['ID']; ?>"><?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></option>
                                <?php } 
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Area</label>
                            <input class="form-control" name="project_area" required>
                        </div>
                    </div>
                    <br>
                    <div class="table table-scrollable">
                        <table class="table table-bordered" >
                            <thead>
                                <th>Scope of Work</th>
                                <th>Action Items</th>
                                <th>Assign To</th>
                                <th>Completion Date</th>
                                <th>Hour</th>
                                <th>Status</th>
                                <th width="10px"></th>
                            </thead>
                            <tbody id="dynamic_field">
                                <tr>
                                    <td><textarea class="form-control border-none" name="scope_work[]"></textarea></td>
                                    <td><textarea class="form-control border-none" name="action_item[]"></textarea></td>
                                    <td>
                                        <select class="form-control border-none" type="text" name="assigned_to[]">
                                            <option value="0">---Select---</option>
                                            <?php
                                                $queryApp = "SELECT * FROM tbl_hr_employee where user_id = $switch_user_id and status = 1 order by first_name ASC";
                                            $resultApp = mysqli_query($conn, $queryApp);
                                            while($rowApp = mysqli_fetch_array($resultApp))
                                                 { 
                                                   echo '<option value="'.$rowApp['ID'].'">'.$rowApp['first_name'].' '.$rowApp['last_name'].'</option>'; 
                                               }
                                             ?>
                                        </select>
                                    </td>
                                    <td><input type="date" name="scope_completion_date[]" placeholder="" class="form-control border-none" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>"></td>
                                    <td><input type="number" name="hours[]" placeholder="" class="form-control border-none" ></td>
                                    <td>
                                        <select class="form-control border-none" type="text" name="status_action[]">
                                            <option value="Open">Open</option>
                                            <option value="Follow Up">Follow Up</option>
                                            <option value="Close">Close</option>
                                        </select>
                                    </td>
                                    <td><button type="button" name="add" id="add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label">Remarks:</label>
                            <textarea class="form-control border-bottom" name="remarks" rows="2"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="control-label">Prepared By</label>
                            <select class="form-control mt-multiselect btn btn-default" type="text" name="prepared_by">
                                <option value="0">---Select---</option>
                                <?php
                                    $queryVeri = "SELECT * FROM tbl_hr_employee where user_id = $switch_user_id and status = 1 order by first_name ASC";
                                $resultVeri = mysqli_query($conn, $queryVeri);
                                while($rowVeri = mysqli_fetch_array($resultVeri))
                                     { 
                                       echo '<option value="'.$rowVeri['ID'].'">'.$rowVeri['first_name'].' '.$rowVeri['last_name'].'</option>'; 
                                   }
                                 ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Date</label>
                            <input type="date" name="prepared_date" placeholder="" class="form-control" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="control-label">Approved By</label>
                            <select class="form-control mt-multiselect btn btn-default" type="text" name="approved_by">
                                <option value="0">---Select---</option>
                                <?php
                                    $queryVeri = "SELECT * FROM tbl_hr_employee where user_id = $switch_user_id and status = 1 order by first_name ASC";
                                $resultVeri = mysqli_query($conn, $queryVeri);
                                while($rowVeri = mysqli_fetch_array($resultVeri))
                                     { 
                                       echo '<option value="'.$rowVeri['ID'].'">'.$rowVeri['first_name'].' '.$rowVeri['last_name'].'</option>'; 
                                   }
                                 ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Date</label>
                            <input type="date" name="approved_date" placeholder="" class="form-control" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                <button type="submit" class="btn green ladda-button" name="btnNew_added" id="btnNew_added" data-style="zoom-out"><span class="ladda-label">Save</span></button>
            </div>
        </form>
    </div>
    </div>
</div>

<!-- Update Details -->
<div class="modal fade" id="modalGet_details" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-full" >
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_details">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Project Management Details</h4>
                </div>
                <div class="modal-body">
                </div>
                 <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_details2" id="btnSave_details2" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalGet_details1" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-full" >
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_details1">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Project Management Details</h4>
                </div>
                <div class="modal-body">
                </div>
                 <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <!--<button type="submit" class="btn green ladda-button" name="btnSave_details1" id="btnSave_details1" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>-->
            </div>
            </form>
        </div>
    </div>
</div>
<!--completed-->
<div class="modal fade" id="modal_completed_plan" tabindex="-1" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_completed_plan">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <center><h2 class="modal-title"><b style="color:#262A56;">Completed?</b></h2></center>
                </div>
                <center>
                    <div class="modal-body"></div>
                    <input type="submit" name="btnCompleted_plan" id="btnCompleted_plan" value="Yes" class="btn btn-success">
                    <input type="button" class="btn btn-outline" data-dismiss="modal" value="No">
                    <br><br><br>
                </center>
            </form>
        </div>
    </div>
</div>

<!--delete-->
<div class="modal fade" id="modal_delete_plan" tabindex="-1" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_delete_plan">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Are You sure You want to delete the details below?</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer" style="margin-top:10px;">
                    <input type="submit" name="btnDelete_plan" id="btnDelete_plan" value="Yes" class="btn btn-warning">
                    <input type="button" class="btn btn-info" data-dismiss="modal" value="No">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_delete_plan1" tabindex="-1" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_delete_plan1">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Are You sure You want to delete the details below?</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer" style="margin-top:10px;">
                    <input type="submit" name="btnDelete_plan1" id="btnDelete_plan1" value="Yes" class="btn btn-warning">
                    <input type="button" class="btn btn-info" data-dismiss="modal" value="No">
                </div>
            </form>
        </div>
    </div>
</div>

<!--completed-->
<div class="modal fade" id="modal_edit_plan" tabindex="-1" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_edit_plan">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Action Item Details</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer" style="margin-top:10px;">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <input type="submit" name="btnEdit_plan" id="btnEdit_plan" value="Save" class="btn green  ladda-button">
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_edit_plan1" tabindex="-1" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_edit_plan1">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Action Item Details</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer" style="margin-top:10px;">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <input type="submit" name="btnEdit_plan1" id="btnEdit_plan1" value="Save" class="btn green  ladda-button">
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- / END MODAL AREA -->
<div id="pdf_generate"></div>               
</div><!-- END CONTENT BODY -->
<?php include_once ('footer.php'); ?>
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

<script>
// $(document).ready(function(){
// 	$("#checkAll").click(function(){
// 		if($(this).is(":checked")){
// 			$(".checkItem").prop('checked',true);
// 		}
// 		else{
// 			$(".checkItem").prop('checked',false);
// 		}
// 	});
// });
// $(document).on('click', '#checkAll', function(){
//     var id = $(this).attr('data-id');
//     if($(this).is(":checked")){
// 		$(".checkItem").prop('checked',true);
// 	}
// 	else{
// 		$(".checkItem").prop('checked',false);
// 	}
// });

$(document).ready(function(){
    getData('get_your_project');
});

function getData(key){
    $.ajax({
       url:'project_management_folder/fetch_account.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
           if (key == 'get_your_project'){
               $('#your_projects').append(response);
           }
       }
    });
}
$(document).ready(function(){
    // calendar
    var calendar = $('#calendar_data').fullCalendar({
        editable:true,
        header:{
            left:'prev,next today',
            center:'title',
            right:'month,agendaWeek,agendaDay'
        },
        events:'project_management_folder/fetch_calendar.php',
        editable:true,
        eventDrop:function(event){
    
            var start = event.start.toISOString();
            var end = event.end.toISOString();
            var title = event.title;
            var id = event.id;
            $.ajax({
                url:"project_management_folder/update-task-calendar.php",
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
            // var id = event.id;
            // $.ajax({
            //     type: "GET",
            //     url: "project_management_folder/calendar_event_click.php?postId="+id,
            //     dataType: "html",
            //     success: function(data){
            //         $("#calendarModal .modal-body").html(data);
            //         $('#calendarModal').modal('show');
            //         selectMulti();
            //     }
            // });
            // $('#calendarModal').modal('show');
        },
    });
});
// print
$(document).on('click', '#print_btn', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "project_management_folder/pdf_print.php?print_id="+id,
        dataType: "html",
        success: function(data){
            $("#pdf_generate").html(data);
            window.print();
        }
    });
});
// Project list
function list_btn(id) {
    $.ajax({
        type: "GET",
        url: "project_management_folder/to_pay.php?get_list="+id,
        dataType: "html",
        success: function(data){
            $("#data_project").html(data);
        }
    });
}
// topay fetch
function topay_btn(id) {
   
    $.ajax({
        type: "GET",
        url: "project_management_folder/to_pay.php?get_topay="+id,
        dataType: "html",
        success: function(data){
            $("#data_pay").html(data);
        }
    });
}
//paid_btn
function paid_btn(id) {
   
    $.ajax({
        type: "GET",
        url: "project_management_folder/to_pay.php?get_paid="+id,
        dataType: "html",
        success: function(data){
            $("#data_paid").html(data);
        }
    });
}
// completed_btn
function completed_btn(id) {
    $.ajax({
        type: "GET",
        url: "project_management_folder/to_pay.php?get_completed="+id,
        dataType: "html",
        success: function(data){
            $("#data_completed").html(data);
        }
    });
}
// new added
$(".modalAdd_details").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnNew_added',true);

    var l = Ladda.create(document.querySelector('#btnNew_added'));
    l.start();

    $.ajax({
        url: "project_management_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            console.log(response);
            if ($.trim(response)) {
                msg = "Sucessfully Save!";
                $('#data_project').append(response);
                 $('#modalAdd_details').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));

// update  details
function btnUpdate_meeting_details(id) {
    $.ajax({
        type: "GET",
        url: "project_management_folder/function.php?postDetails2="+id,
        dataType: "html",
        success: function(data){
            $("#modalGet_details .modal-body").html(data);
            $(".modalForm").validate();
            selectMulti();
        }
    });
}
$(".modalGet_details").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_details2',true);

    var l = Ladda.create(document.querySelector('#btnSave_details2'));
    l.start();

    $.ajax({
        url: "project_management_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Sucessfully Save!";
                $('#row_'+row_id).empty();
                 $('#row_'+row_id).append(response);
                 $('#modalGet_details').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
// 1
function btnUpdate_meeting_details1(id) {
    $.ajax({
        type: "GET",
        url: "project_management_folder/function.php?postDetails1="+id,
        dataType: "html",
        success: function(data){
            $("#modalGet_details1 .modal-body").html(data);
            $(".modalForm").validate();
            selectMulti();
        }
    });
}
$(".modalGet_details1").on('submit',(function(e) {
    e.preventDefault();
     var row_id1 = $("#row_id1").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_details1',true);

    var l = Ladda.create(document.querySelector('#btnSave_details1'));
    l.start();

    $.ajax({
        url: "project_management_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Sucessfully Save!";
                $('#row1_'+row_id1).empty();
                 $('#row1_'+row_id1).append(response);
                 $('#modalGet_details1').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
// add more field
$(document).ready(function(){
     var key = 'ids';
     //
    $('#add').click(function(){
        $.ajax({
           url:'project_management_folder/dynamic_field.php',
           method: 'POST',
           dataType: 'html',
           data: {
               key: key
           }, success: function (response) {
            $('#dynamic_field').append(response);
           }
        });
    });
   
    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id");
        $('#row'+button_id+'').remove();
    });
   
});
// add more field 2
$(document).on('click', '#add2', function(){
    var key = 'ids';
  $.ajax({
      url:'project_management_folder/dynamic_field.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_field2').append(response);
      }
    });
});

// completed
$(document).on('click', '#completed_btn', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "project_management_folder/function.php?complete_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_completed_plan .modal-body").html(data);
        }
    });
});
$(".modal_completed_plan").on('submit',(function(e) {
    e.preventDefault();
     var row_id = $("#row_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnCompleted_plan',true);

    var l = Ladda.create(document.querySelector('#btnCompleted_plan'));
    l.start();

    $.ajax({
        url: "project_management_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Project Completed!!!";
                $('#row_'+row_id).empty();
                 $('#modal_completed_plan').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

// delete action items
$(document).on('click', '#delete_btn', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "project_management_folder/function.php?delete_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_delete_plan .modal-body").html(data);
        }
    });
});
$(".modal_delete_plan").on('submit',(function(e) {
    e.preventDefault();
     var emp_id = $("#emp_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnDelete_plan',true);

    var l = Ladda.create(document.querySelector('#btnDelete_plan'));
    l.start();

    $.ajax({
        url: "project_management_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully deleted!!!";
                $('#emp_'+emp_id).empty();
                $('#modal_delete_plan').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

// delete action items close
$(document).on('click', '#delete_btn1', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "project_management_folder/function.php?delete_id1="+id,
        dataType: "html",
        success: function(data){
            $("#modal_delete_plan1 .modal-body").html(data);
        }
    });
});
$(".modal_delete_plan1").on('submit',(function(e) {
    e.preventDefault();
     var emp_id1 = $("#emp_id1").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnDelete_plan1',true);

    var l = Ladda.create(document.querySelector('#btnDelete_plan1'));
    l.start();

    $.ajax({
        url: "project_management_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully deleted!!!";
                $('#emp1_'+emp_id1).empty();
                $('#modal_delete_plan1').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

// edit action items
$(document).on('click', '#edit_btn', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "project_management_folder/function.php?edit_id="+id,
        dataType: "html",
        success: function(data){
            $("#modal_edit_plan .modal-body").html(data);
        }
    });
});
$(".modal_edit_plan").on('submit',(function(e) {
    e.preventDefault();
     //var emp_id = $("#emp_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnEdit_plan',true);

    var l = Ladda.create(document.querySelector('#btnEdit_plan'));
    l.start();

    $.ajax({
        url: "project_management_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Updated!!!";
                $('#data_scope').empty();
                $('#data_scope').append(response);
                $('#modal_edit_plan').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

// edit action items close
$(document).on('click', '#edit_btn1', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "project_management_folder/function.php?edit_id1="+id,
        dataType: "html",
        success: function(data){
            $("#modal_edit_plan1 .modal-body").html(data);
        }
    });
});
$(".modal_edit_plan1").on('submit',(function(e) {
    e.preventDefault();
     //var emp_id = $("#emp_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnEdit_plan1',true);

    var l = Ladda.create(document.querySelector('#btnEdit_plan1'));
    l.start();

    $.ajax({
        url: "project_management_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Successfully Updated!!!";
                $('#data_scope1').empty();
                $('#data_scope1').append(response);
                $('#modal_edit_plan1').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

$(document).on('click', '#btn_paid_update', function(){
    
       var scope_update_id = [];
           
        $('.update_scope:checked').each(function(i){
            scope_update_id[i] = $(this).val();
        });
           
        if(scope_update_id.length === 0) //tell you if the array is empty
        {
            alert("Please Select atleast one checkbox");
        }
        else
        {
            $.ajax({
                url:'project_management_folder/action_paid.php',
                method:'POST',
                data:{scope_update_id:scope_update_id},
                success:function()
                {
                    for(var i=0; i<scope_update_id.length; i++)
                    {
                        $('tr#scope_'+scope_update_id[i]+'').css('background-color', '#ccc');
                        $('tr#scope_'+scope_update_id[i]+'').fadeOut('slow');
                    }
                }
            });
        }
});
$(document).ready(function(){
 
 $('#btn_paid_update3').click(function(){
  
    if(confirm("Are you sure you want to delete this?"))
    {
        var id = [];
           
        $(':checkbox:checked').each(function(i){
            id[i] = $(this).val();
        });
           
        if(id.length === 0) //tell you if the array is empty
        {
            alert("Please Select atleast one checkbox");
        }
        else
        {
            $.ajax({
                url:'project_management_folder/action_paid.php',
                method:'POST',
                data:{id:id},
                success:function()
                {
                    for(var i=0; i<id.length; i++)
                    {
                        $('tr#'+id[i]+'').css('background-color', '#ccc');
                        $('tr#'+id[i]+'').fadeOut('slow');
                    }
                }
            });
        }
       
    }
    else
    {
       return false;
    }
 });
 
});
</script>
<style>
/*Start meeting minutes*/
@media screen {
  #pdf_generate {
      display: none;
  }
}

@media print {
  body * {
    visibility:hidden;
  }
  #pdf_generate, #pdf_generate * {
    visibility:visible;
  }
  #pdf_generate {
    font-size:12px;
    position:absolute;
    left:0;
    top:0;
  }
}


/*end meeting minutes*/
            /*Loader*/
.loader {
  display: inline-block;
  width: 30px;
  height: 30px;
  position: relative;
  border: 4px solid #Fff;
  top: 50%;
  animation: loader 2s infinite ease;
}

.loader-inner {
  vertical-align: top;
  display: inline-block;
  width: 100%;
  background-color: #fff;
  animation: loader-inner 2s infinite ease-in;
}
.border-bottom{
    border:none;
    border-bottom:solid grey 1px;
}
.border-none{
    border:none;
}

@keyframes loader {
  0% {
    transform: rotate(0deg);
  }
  
  25% {
    transform: rotate(180deg);
  }
  
  50% {
    transform: rotate(180deg);
  }
  
  75% {
    transform: rotate(360deg);
  }
  
  100% {
    transform: rotate(360deg);
  }
}

@keyframes loader-inner {
  0% {
    height: 0%;
  }
  
  25% {
    height: 0%;
  }
  
  50% {
    height: 100%;
  }
  
  75% {
    height: 100%;
  }
  
  100% {
    height: 0%;
  }
}
        </style>
    </body>
</html>
