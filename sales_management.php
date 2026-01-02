<?php 

    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    $today_tx = $date_default_tx->format('Y-m-d');
    $title = "Sales Management";
    $site = "sales_management";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }

    $breadcrumbs .= '<li><span>'. $title .'</span></li>';
    include_once ('header.php');
?>
<style>
    .bi {
        cursor: pointer;
    }
    .mt-1, .mb-1 {
        margin-top: 0.5rem !important;
    }
    .mt-2, .mb-2 {
        margin-top: 1rem !important;
    }
    .mt-3, .mb-3 {
        margin-top: 1.5rem !important;
    }
    .mt-4, .mb-4 {
        margin-top: 2rem !important;
    }
    .mt-5, .mb-5 {
        margin-top: 2.5rem !important;
    }
    .mb-1 {
        margin-bottom: 0.5rem !important;
    }
    .mb-2 {
        margin-bottom: 1rem !important;
    }
    .mb-3 {
        margin-bottom: 1.5rem !important;
    }
    .mb-4 {
        margin-bottom: 2rem !important;
    }
    .mb-5 {
        margin-top: 2.5rem !important;
    }
    .m-1 {
        margin: 0.5rem !important;
    }
    .m-2 {
        margin: 1rem !important;
    }
    .m-3 {
        margin: 1.5rem !important;
    }
    .m-4 {
        margin: 2rem !important;
    }
    .m-5 {
        margin: 0.5rem !important;
    }
    .d-none {
        display: none;
    }
</style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <div class="row">
            <div class="col-md-12">
                 <div class="portlet light portlet-fit">
                    <div class="portlet-title">
                        <div class="d-flex justify-content-between">
                        <a data-toggle="modal" href="#modal_add_quotation" class="btn btn-primary"><i class="icon-plus"></i>
                            <span class="">Quotation</span></a>
                            <div class="d-flex justify-content-between" style="gap: 2rem;">
                                <form id="searchFormEmail">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn default border" type="button" style="background: transparent"><i class="fa fa-filter"></i></button>
                                        </span>
                                    </div>
                                </form>
                                <form id="searchFormEmail">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="" style="width: 280px">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn default border" type="button" style="background: transparent;"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div></div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-scrollable" style="border:none;">
                            <div class="col-md-12" style="padding: 0">
                                <div class="clearfix d-none mb-3" id="actionBtn">
                                    <div class="btn-group btn-group-solid">
                                        <a class="btn btn-sm default border tooltips statusValue" data-value="close">Close</a>
                                        <a class="btn btn-sm green tooltips statusValue" data-value="invoice">Create Invoice</a>
                                        <a class="btn btn-sm blue tooltips statusValue" data-value="activity">Activity</a>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="table_data_tr">
                                    <thead>
                                        <tr>
                                            <th width="1%"><input type="checkbox" class="checkbox_action"></th>
                                            <th>Number</th>
                                            <th>Created Date</th>
                                            <th>Company Name</th>
                                            <th>Salesperson</th>
                                            <th>Activities</th>
                                            <th>Total Amount</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="checkbox" class="checkbox_action" name=""></td>
                                            <td>S0001</td>
                                            <td>20240229</td>
                                            <td>ABC Company</td>
                                            <td>Cherry Rose Damayo</td>
                                            <td>Send Email</td>
                                            <td>$ 660.00</td>
                                            <td class="text-center"><span class="badge bg-green">Send Proposal</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="modal_add_quotation" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog" style="min-width: 90%">
                    <div class="modal-content">  
                        <form method="post" class="form-horizontal">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Add Quotation</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="details_ids" name="meeting_ids">
                                <div class="form-group">
                                    <div class="col-md-6">  
                                        <label class="control-label">Email</label>
                                        <select class="form-control mt-multiselect btn btn-default" type="text" required>
                                            <?php
                                                $flag = 1;
                                                $status = 'Manual';      
                                                $stmt = mysqli_prepare($conn, 'SELECT crm_id, account_email FROM tbl_Customer_Relationship WHERE flag = ? AND account_status != ? LIMIT 200');
                                                mysqli_stmt_bind_param($stmt, 'is', $flag, $status);
                                                mysqli_stmt_execute($stmt);

                                                if(!$stmt) {
                                                    die('Error: ' . mysqli_error($conn));
                                                }
                                                mysqli_stmt_bind_result($stmt, $crm_id, $account_email);
                                                while(mysqli_stmt_fetch($stmt)) {
                                                    echo '<option value="'.$crm_id.'">'.$account_email.'</option>';
                                                }
                                             ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Date</label>
                                        <input class="form-control" name="action_details" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="control-label">Company Name</label>
                                        <input class="form-control" name="action_details" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Start Date</label>
                                        <input class="form-control" name="action_details" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="control-label">Contact Person</label>
                                        <input class="form-control" name="action_details" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Target Completion</label>
                                        <input class="form-control" name="action_details" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="control-label">Address</label>
                                        <input class="form-control" name="action_details" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Quotation Number</label>
                                        <input class="form-control" name="action_details" value="">
                                    </div>
                                </div>
                                <div class="form-group mb-5">
                                    <div class="col-md-6">
                                        <label class="control-label">Phone</label>
                                        <input class="form-control" name="action_details" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Payment Terms</label>
                                        <input class="form-control" name="action_details" value="">
                                    </div>
                                </div>
                                <div class="table-scrollable mt-5" style="border:none;">
                                    <div class="col-md-12" style="padding: 0px ">
                                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="table_data_tr">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Product/Services</th>
                                                    <th>Description</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Taxes</th>
                                                    <th>Tax Excl.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="2"><input type="text" name="service[]" class="form-control"></td>
                                                    <td><input type="text" name="description[]" class="form-control"></td>
                                                    <td><input type="text" name="quantity[]" class="form-control"></td>
                                                    <td><input type="text" name="price[]" class="form-control"></td>
                                                    <td><input type="text" name="taxes[]" class="form-control"></td>
                                                    <td><input type="text" name="excl[]" class="form-control"></td>
                                                </tr>
                                            </tbody>
                                            <tbody id="newRow"></tbody> 
                                        </table>
                                        <a href="#" id="addRow"><i class="bi bi-plus-circle"></i> Add line</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <label class="control-label">Remarks</label>
                                        <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-4 mb-5">
                                        <table class="table dt-responsive mt-2" width="100%" id="table_data_tr">
                                            <tr class="text-right">
                                                <td width="30%">Untaxed Amount:</td>
                                                <td>$</td>
                                            </tr>
                                            <tr class="text-right">
                                                <td width="30%">VAT %:</td>
                                                <td>$</td>
                                            </tr>
                                            <tr class="text-right">
                                                <td width="30%"><strong>Total:</strong></td>
                                                <td>$</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="col-md-12 d-flex justify-content-between">
                                    <a class="btn btn-info" type="submit" name="btnSave_action_item">Preview</a>
                                    <div class="d-flex justify-content-between">
                                        <a class="btn btn-info" type="submit" name="btnSave_action_item">Draft</a>
                                        <a class="btn btn-info" type="submit" name="btnSave_action_item">Send by Email</a>
                                        <a class="btn btn-info" type="submit" name="btnSave_action_item">Confirm</a>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
        <?php include_once ('footer.php'); ?>
        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        <!--<script src="ssm/script.js"></script>-->
    </body>
</html>
