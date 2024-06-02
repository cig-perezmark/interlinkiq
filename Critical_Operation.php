<?php 
    $title = "Critical Operations";
    $site = "Critical_Operation";
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
                                        <span class="caption-subject font-dark bold uppercase">Critical Operations</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="<?php echo $FreeAccess == false ? '#modalNew':'#modalService'; ?>" > Add New Critical Operation</a>
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
                                                    <th>Area</th>
                                                    <th>Operation</th>
                                                    <th>Primary Name</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Alternate Name</th>
                                                     <th>Phone</th>
                                                    <th>Email</th>
                                                    <td></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                $usersQuery = $_COOKIE['ID'];
                                                $queriesPri = "SELECT * FROM tbl_critical_operation left join tbl_hr_employee on ID = addPrimaryNameField left join tblFacilityDetails on assign_area = facility_id where user_cookies = $usersQuery";
                                                $resultQuery = mysqli_query($conn, $queriesPri);
                                                 
                                                while($rowPri = mysqli_fetch_array($resultQuery)){ 
                                                $alt = $rowPri['addAlternateNameField'];
                                                $queriesAlt = "SELECT * FROM tbl_hr_employee where ID = $alt";
                                                $resultQueryAlt = mysqli_query($conn, $queriesAlt);
                                                ?>
                                                <tr>
                                                    <td><?php echo $i++;  ?></td>
                                                    <td><?php echo $rowPri['facility_category'];  ?></td>
                                                    <td><?php echo $rowPri['addOperationField'];  ?></td>
                                                    <td><?php echo $rowPri['first_name'];  ?> <?php echo $rowPri['last_name'];  ?></td>
                                                    <td></td>
                                                    <td><?php echo $rowPri['email'];  ?></td>
                                                     <?php while($rowAlt = mysqli_fetch_array($resultQueryAlt)){ ?>
                                                    <td>
                                                        <?php echo $rowAlt['first_name'];  ?> <?php echo $rowAlt['last_name'];  ?>
                                                    </td>
                                                    <td></td>
                                                    <td> 
                                                        <?php echo $rowAlt['email'];  ?> 
                                                    </td>
                                                     <?php } ?>
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
                                            <h4 class="modal-title">ADD NEW CRITICAL OPERATION</h4>
                                        </div>
                                    <div class="modal-body">
                                        <form action="Crisis_Managements_Folder/crisis_management_function.php" method="post" enctype="multipart/form-data" class="modalForm modalSave">
                                             <div class="mb-3 row">
                                              <label for="ids" class="col-md-3 form-label">Assign Area</label>
                                              <div class="col-md-9">
                                                <select class="form-control" name="ids" id="ids" required>
                                                  <option value="">Select</option>
                                                  <?php
                                             
                                                $u = 1;
                                                $usersQuery = $_COOKIE['ID'];
                                                //  where user_cookies = $usersQuery
                                                $queries = "SELECT * FROM tblFacilityDetails where users_entities = $usersQuery";
                                                $resultQuery = mysqli_query($conn, $queries);
                                                while($rowcrma = mysqli_fetch_array($resultQuery)){ ?>
                                                    <option value="<?php echo $rowcrma['facility_id']; ?>"><?php echo $rowcrma['facility_category']; ?></option>
                                                <?php } ?>
                                                </select>
                                              </div>
                                            </div>
                                            <br>
                                            <div class="mb-3 row">
                                              <label for="addOperationField" class="col-md-3 form-label">Operation</label>
                                              <div class="col-md-9">
                                                <input type="text" class="form-control" id="addOperationField" name="addOperationField" required>
                                              </div>
                                            </div>
                                            <br>
                                            <div class="mb-3 row">
                                              <label for="addPrimaryNameField" class="col-md-3 form-label">Primary Name</label>
                                              <div class="col-md-9">
                                                <!-- <input type="text" class="form-control" id="addPrimaryNameField" name="addPrimaryNameField"> -->
                                               
                                                <select class="form-control" name="addPrimaryNameField" id="addPrimaryNameField" required>
                                                  <option value="">Select</option>
                                                  <?php
                                             
                                                $u = 1;
                                                $usersQuery = $_COOKIE['ID'];
                                                //  where user_cookies = $usersQuery
                                                $queries = "SELECT * FROM tbl_hr_employee where user_id = $current_userEmployerID";
                                                $resultQuery = mysqli_query($conn, $queries);
                                                while($rowcrm = mysqli_fetch_array($resultQuery)){ ?>
                                                    <option value="<?php echo $rowcrm['ID']; ?>"><?php echo $rowcrm['first_name']; ?> <?php echo $rowcrm['last_name']; ?></option>
                                                <?php } ?>
                                              
                                                </select>
                                              </div>
                                            </div>
                                            <br>
                                            <div class="mb-3 row">
                                              <label for="addAlternateNameField" class="col-md-3 form-label">Alternate Name</label>
                                              <div class="col-md-9">
                                                
                                                <select class="form-control" name="addAlternateNameField" id="addAlternateNameField" required>
                                                  <option value="">Select</option>
                                               <?php
                                             
                                                $u = 1;
                                                $usersQuery = $_COOKIE['ID'];
                                                //  where user_cookies = $usersQuery
                                                $queries = "SELECT * FROM tbl_hr_employee where user_id = $current_userEmployerID ";
                                                $resultQuery = mysqli_query($conn, $queries);
                                                while($rowcrm = mysqli_fetch_array($resultQuery)){ ?>
                                                    <option value="<?php echo $rowcrm['ID']; ?>"><?php echo $rowcrm['first_name']; ?> <?php echo $rowcrm['last_name']; ?></option>
                                                <?php } ?>
                                                </select>
                                              </div>
                                            </div>
                                            <br>
                                           
                                    </div>
                                    <div class="modal-footer">
                                             <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                              <button type="submit" class="btn btn-success" name="btnSave_critical_operation">Save</button>
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