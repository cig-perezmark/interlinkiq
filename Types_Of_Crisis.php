<?php 
    $title = "Crisis Incident";
    $site = "Types_Of_Crisis";
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
                                        <span class="caption-subject font-dark bold uppercase">List of Crisis Incidents</span>
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
                                                    <th>Id</th>
                                                    <th>Type of Crisis</th>
                                                    <th>Name</th>
                                                    <th>Supporting Files</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 <?php
                                                $i = 1;
                                                $usersQuery = $_COOKIE['ID'];
                                                $queries = "SELECT * FROM tbl_crisis_incidents where user_cookies = $usersQuery";
                                                $resultQuery = mysqli_query($conn, $queries);
                                                 
                                                while($row = mysqli_fetch_array($resultQuery)){ ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $row['Types_Of_Crisis']; ?></td>
                                                    <td><?php echo $row['disaster_name']; ?></td>
                                                    <td><a href="Crisis_Managements_Folder/download_disaster_files.php?inc_id=<?php echo $row['crisis_incidents_id']; ?>"><?php echo $row['disaster_Supporting_files']; ?></a></td>
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
                                            <h4 class="modal-title">ADD NEW CRISIS INCIDENTS</h4>
                                        </div>
                                    <div class="modal-body">
                                        <form action="Crisis_Managements_Folder/crisis_management_function.php" method="post" enctype="multipart/form-data" class="modalForm modalSave">
                                            <div class="mb-3 row">
                                              <label for="Types_Of_Crisis" class="col-md-3 form-label">Types Of Crisis</label>
                                              <div class="col-md-9">
                                                <!-- <input type="text" class="form-control" id="addPrimaryNameField" name="addPrimaryNameField"> -->
                                               
                                                <select class="form-control" name="Types_Of_Crisis" id="Types_Of_Crisis" required>
                                                  <option value="">Select</option>
                                                  <option value="Natural Crisis">Natural Crisis</option>
                                                  <option value="Crisis of Malevolence">Crisis of Malevolence</option>
                                                  <option value="Comfrontation Crisis">Comfrontation Crisis</option>
                                                  <option value="Workplace Violence Crisis">Workplace Violence Crisis</option>
                                                  <option value="Organization Crisis">Organization Crisis</option>
                                                  <option value="Financial Crisis">Financial Crisis</option>
                                                  <option value="Oil (CBRNE) Incendents">Oil (CBRNE) Incendents</option>
                                                  <option value="Disease Agent and Toxins">Disease Agent and Toxins</option>
                                                </select>
                                              </div>
                                            </div>
                                            <br>
                                            <div class="mb-3 row">
                                              <label class="col-md-3 form-label">Name</label>
                                              <div class="col-md-9">
                                                <input class="form-control" name="disaster_name" id="disaster_name">
                                              </div>
                                            </div>
                                            <br>
                                            <div class="mb-3 row">
                                              <label class="col-md-3 form-label">Supporting Files</label>
                                              <div class="col-md-9">
                                                <input type="file" class="form-control" name="disaster_Supporting_files" id="disaster_Supporting_files">
                                              </div>
                                            </div>
                                            <br>
                                           
                                    </div>
                                    <div class="modal-footer">
                                             <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                              <button type="submit" class="btn btn-success" name="btnSave_crisis_incedents">Save</button>
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