<?php 
    $title = "Legal & Expert";
    $site = "Legal_Expert";
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
                                        <span class="caption-subject font-dark bold uppercase">Legal & Expert</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="<?php echo $FreeAccess == false ? '#modalNew':'#modalService'; ?>" > Add New Legal & Expert</a>
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
                                                    <th>Area</th>
                                                    <th>Agency</th>
                                                    <th>Contact Person</th>
                                                    <th>Phone 1</th>
                                                    <th>Phone 2</th>
                                                    <th>Email</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                             
                                                $i = 1;
                                                $usersQuery = $_COOKIE['ID'];
                                                $queries = "SELECT * FROM tbl_Legal_experts where user_cookies = $usersQuery";
                                                $resultQuery = mysqli_query($conn, $queries);
                                                while($rowcrm = mysqli_fetch_array($resultQuery)){ ?>
                                                <tr>
                                                    <td><?php echo $i++;  ?></td>
                                                    <td><?php echo htmlentities($rowcrm['Area_name'] ?? '');  ?></td>
                                                    <td><?php echo htmlentities($rowcrm['Agency_name'] ?? '');  ?></td>
                                                    <td><?php echo htmlentities($rowcrm['Contact_Person'] ?? '');  ?></td>
                                                    <td><?php echo htmlentities($rowcrm['Phone_1'] ?? '');  ?></td>
                                                    <td><?php echo htmlentities($rowcrm['Phone_2'] ?? '');  ?></td>
                                                    <td><?php echo htmlentities($rowcrm['legal_email'] ?? '');  ?></td>
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
                        <div class="modal fade" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="Crisis_Managements_Folder/crisis_management_function.php" method="post" enctype="multipart/form-data" class="modalForm modalSave">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Add Sources of Legal and Expert Advice</h4>
                                        </div>
                                        <div class="modal-body"> 
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Area</label>
                                                        <input class="form-control" type="text" name="Area_name" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Agency</label>
                                                        <input class="form-control" type="text" name="Agency_name" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Contact Person</label>
                                                        <input class="form-control" type="text" name="Contact_Person" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Phone 1</label>
                                                        <input class="form-control" type="text" name="Phone_1" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group"> 
                                                        <label class="control-label">Phone 2</label>
                                                        <input class="form-control" type="text" name="Phone_2">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group"> 
                                                        <label class="control-label">Email</label>
                                                        <input class="form-control" type="email" name="legal_email">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Legal" data-style="zoom-out"><span class="ladda-label">Save</span></button>
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
        <script type="text/javascript">
           
        </script>
    </body>
</html>