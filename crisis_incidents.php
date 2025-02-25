<?php 
    $title = "Crisis Incident Management";
    $site = "crisis_incidents";
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
                                        <span class="caption-subject font-dark bold uppercase">Crisis Incidents Management</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="<?php echo $FreeAccess == false ? '#modalNew':'#modalService'; ?>" > Add New Crisis Incidents</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered table-hover" id="tableData">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Type of Crisis</th>
                                                    <th>Disaster Name</th>
                                                    <th>Crisis Preparedness</th>
                                                    <th>Initiated by</th>
                                                    <th>Team Meeting Location</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 <?php
                                                $i = 1;
                                                $usersQuery = $_COOKIE['ID'];
                                                $queries = "SELECT * FROM tbl_crisis_incidents_managements left join tbl_hr_employee on ID = Initiated_by left join tbl_crisis_incidents on crisis_incidents_id = Types_Of_Disaster where tbl_crisis_incidents_managements.user_cookies = $usersQuery";
                                                $resultQuery = mysqli_query($conn, $queries);
                                                 
                                                while($row = mysqli_fetch_array($resultQuery)){ ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo htmlentities($row['Types_Of_Crisis'] ?? ''); ?></td>
                                                    <td><?php echo htmlentities($row['disaster_name'] ?? ''); ?></td>
                                                    <td><?php echo htmlentities($row['Crisis_Preparedness'] ?? ''); ?></td>
                                                    <td><?php echo htmlentities($row['first_name'] ?? ''); ?> <?php echo $row['last_name']; ?></td>
                                                    <td><?php echo htmlentities($row['Meeting_Location'] ?? ''); ?></td>
                                                    <td></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- END BORDERED TABLE PORTLET-->
                        </div>
 <!-- MODAL AREA-->
                        <div class="modal fade" id="modalNew"  tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">ADD NEW CRISIS MANAGEMENT</h4>
                                        </div>
                                    <div class="modal-body">
                                        <form action="Crisis_Managements_Folder/crisis_management_function.php" method="post" enctype="multipart/form-data" class="modalForm modalSave">
                                            <div class="mb-3 row">
                                              <label for="Types_Of_Disaster" class="col-md-3 form-label">Types Of Disaster</label>
                                              <div class="col-md-9">
                                                <!-- <input type="text" class="form-control" id="addPrimaryNameField" name="addPrimaryNameField"> -->
                                               
                                                <select class="form-control" name="Types_Of_Disaster" id="Types_Of_Disaster" required>
                                                  <option value="">Select</option>
                                                   <?php
                                                $i = 1;
                                                $usersQuery = $_COOKIE['ID'];
                                                $queries = "SELECT * FROM tbl_crisis_incidents where user_cookies = $usersQuery";
                                                $resultQuery = mysqli_query($conn, $queries);
                                                 
                                                while($row = mysqli_fetch_array($resultQuery)){ ?>
                                                    <option value="<?php echo $row['crisis_incidents_id']; ?>"><?php echo htmlentities($row['disaster_name'] ?? ''); ?></option>
                                                <?php } ?>
                                                </select>
                                              </div>
                                            </div>
                                            <br>
                                            <div class="mb-3 row">
                                              <label class="col-md-3 form-label">Crisis Preparedness</label>
                                              <div class="col-md-9">
                                                <select class="form-control" name="Crisis_Preparedness" id="Crisis_Preparedness">
                                                    <option value="Planning">Planning</option>
                                                    <option value="Drills">Drills</option>
                                                    <option value="Seminars/Trainings">Seminars/Trainings</option>
                                                            
                                                </select>
                                              </div>
                                            </div>
                                            <br>
                                            <div class="mb-3 row">
                                              <label class="col-md-3 form-label">Initiated by</label>
                                              <div class="col-md-9">
                                                <select class="form-control" name="Initiated_by" id="Initiated_by" required>
                                                  <option value="">Select</option>
                                                   <?php
                                                $i = 1;
                                                $usersQuery = $_COOKIE['ID'];
                                                $queries = "SELECT * FROM tbl_hr_employee where user_id = $current_userEmployerID ";
                                                $resultQuery = mysqli_query($conn, $queries);
                                                 
                                                while($row = mysqli_fetch_array($resultQuery)){ ?>
                                                    <option value="<?php echo $row['ID']; ?>"><?php echo htmlentities($row['first_name'] ?? '')'; ?> <?php echo htmlentities($row['last_name'] ?? ''); ?></option>
                                                <?php } ?>
                                                </select>
                                              </div>
                                            </div>
                                             <br>
                                            <div class="mb-3 row">
                                              <label class="col-md-3 form-label">Team Meeting Location</label>
                                              <div class="col-md-9">
                                                <input class="form-control" name="Meeting_Location" id="Meeting_Location">
                                              </div>
                                            </div>
                                            <br>
                                           
                                    </div>
                                    <div class="modal-footer">
                                             <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                              <button type="submit" class="btn btn-success" name="btnSave_crisis_managements">Save</button>
                                          </form>
                                    </div>
                                 </div>
                            </div>
                        </div>
                        
                        
                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
        
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script type="text/javascript">
          
        </script>
    </body>
</html>
