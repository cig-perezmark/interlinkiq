<?php 
    $title = "Records Verification Management";
    $site = "rvm";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    /* DataTable*/
    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {
        position: relative;
    }

    #poss {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start; /* Adjusted to start from the top */
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            position: relative;
        }

    .draggable-container {
        display: flex;
        flex-direction: row; /* Changed to row for horizontal alignment */
        gap: 10px;
        width: 100%;
        justify-content: center; /* Center horizontally */
        margin-top: 10px; /* Add margin to separate from the top */
    }

    .draggable {
        padding: 10px;
        cursor: pointer;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-align: center;
        width: 180px;
        user-select: none;
        transition: background-color 0.3s, border-color 0.3s;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .draggable::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: inherit;
        filter: blur(5px);
        z-index: -1;
    }

    .draggable:hover {
        background-color: rgba(0, 0, 0, 0.2);
        border-color: #888;
    }

    #chart-container {
        width: 120%;
        max-width: 1100px;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px; /* Add margin to separate from draggable items */
    }

    #chartdiv {
        width: 110%;
        height: 400px;
    }

    #initial-message {
        margin-top: 10px;
        color: #333;
        font-size: 14px;
        text-align: center;
    }

    @media (max-width: 768px) {
        #chart-container {
            width: 110%;
        }

        .draggable {
            width: 100px;
            padding: 8px;
        }
    }

    @media (max-width: 480px) {
        #chart-container {
            width: 100%;
        }

        .draggable {
            width: 80px;
            padding: 6px;
        }
    }

    #filledOutChart, #signedChart, #complianceChart, #frequencyChart {
        width: 100%;
        height: 450px;
    }

    #chartdiv3 {
        width: 100%;
        max-width: 90%; /* Set the maximum width for the chart */
        height: 400px; /* Set the height for the chart */
        margin: 0 auto; /* Center the chart */
    }

    .chart-container {
            width: 100%;
            height: 100%;
            min-height: 300px; /* Adjust the minimum height as needed */
            display: flex;
            justify-content: center;
            align-items: center;
}
</style>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="actions">
                               <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#records" data-toggle="tab"> Records</a>
                                    </li>                                                                
                                    <li>
                                        <a href="#rvm_analytics" data-toggle="tab">Analytics </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="records">
                                <div class="col-md-3">
                                    <div class="portlet light portlet-fit">
                                        <div class="portlet-body">
                                            <div class="table-scrollable">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Department / Area</th>
                                                            <th>No. of Records</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <?php
                                                                $result = mysqli_query( $conn,"SELECT ID, name FROM tbl_eforms_department ORDER BY name" );
                                                                if ( mysqli_num_rows($result) > 0 ) {
                                                                    while($row = mysqli_fetch_array($result)) {
                                                                        $ID = htmlentities($row['ID'] ?? '');
                                                                        $name = htmlentities($row['name'] ?? '');
                                                                        $records = 0;

                                                                        $selectEForm = mysqli_query( $conn,'SELECT ID FROM tbl_eforms WHERE user_id="'.$switch_user_id.'" AND department_id="'. $ID .'"' );
                                                                        if ( mysqli_num_rows($selectEForm) > 0 ) {
                                                                            while($row = mysqli_fetch_array($selectEForm)) {
                                                                                $records++;
                                                                            }
                                                                        }

                                                                        if ($records > 0) {
                                                                            echo '<tr id="tr_'. $ID .'" onclick="btnViewDepartment('. $ID .', '.$FreeAccess.')">
                                                                                <td>'. $name .'</td>
                                                                                <td>'. $records .'</td>
                                                                            </tr>';
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php echo '<button class="btn btn-success hide" id="tableDataViewAll" onclick="btnViewDepartmentViewAll('.$switch_user_id.', '.$FreeAccess.')">View All</button>'; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="portlet light portlet-fit">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="icon-docs font-dark"></i>
                                                <span class="caption-subject font-dark bold uppercase">Records Verification Management</span>
                                            </div>
                                            <div class="actions">
                                                <div class="btn-group">
                                                    <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a data-toggle="modal" href="<?php echo $FreeAccess == false ? '#modalNew':'#modalService'; ?>" >Add New RVM</a>
                                                        </li>
                                                        <li class="divider"> </li>
                                                        <li>
                                                            <a href="javascript:;">Option 2</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">Option 3</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">Option 4</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-scrollable" style="border: 0;">
                                                <table class="table table-bordered table-hover" id="tableData">
                                                    <thead>
                                                        <tr>
                                                            <th>Record Name</th>
                                                            <th>Date Uploaded</th>
                                                            <th>Verified By</th>
                                                            <th style="width: 135px;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $result = mysqli_query( $conn,"SELECT ID, record, files_date, verified_by FROM tbl_eforms WHERE user_id=$switch_user_id ORDER BY files_date DESC" );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $ID = htmlentities($row['ID'] ?? '');
                                                                    $record = htmlentities($row['record'] ?? '');
                                                                    $files_date = htmlentities($row['files_date'] ?? '');
                                                                    $verified_by = htmlentities($row['verified_by'] ?? '');

                                                                    echo '<tr id="tr_'. $ID .'">
                                                                        <td>'. $record .'</td>
                                                                        <td>'. $files_date .'</td>
                                                                        <td>'. $verified_by .'</td>
                                                                        <td class="text-center">';

                                                                            if ($FreeAccess == false) {
                                                                                echo '<div class="btn-group btn-group-circle">
                                                                                    <a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('. $ID.')">Edit</a>
                                                                                    <a href="#modalViewFile" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnView('. $ID .', '.$FreeAccess.')">View</a>
                                                                                </div>';
                                                                            } else {
                                                                                echo '<a href="#modalViewFile" class="btn btn-success btn-sm btnView btn-circle" data-toggle="modal" onclick="btnView('. $ID .', '.$FreeAccess.')">View</a>';
                                                                            }

                                                                        echo '</td>
                                                                    </tr>';
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



                            
                            <div class="tab-pane" id="rvm_analytics">
                                <div class="widget-row">  
                                    <div class="col-md-12">
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                            <div class="widget-thumb-wrap">
                                                <h3 class="d-flex justify-content-center">Frequency of Collection</h3>
                                                <div id="frequencyChart" style="width: 100%; height: 500px;"></div>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="col-md-6">
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                            <!--<h4 class="widget-thumb-heading"></h4>-->
                                            <h3 class="d-flex justify-content-center">Properly Filled Out</h3>
                                            <div class="widget-thumb-wrap">
                                                <div id="filledOutChart" style="width: 100%; height: 500px;"></div>
                                            </div>
                                        </div>
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                            <div class="widget-thumb-wrap">
                                                <h3 class="d-flex justify-content-center">Compliant</h3>
                                                <div id="complianceChart" style="width: 100%; height: 500px;"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-0 hide">
                                            <div class="widget-thumb-wrap" id="poss">
                                                <h3>RVM Chart</h3>
                                                <div class="draggable-container">
                                                    <div class="draggable" draggable="true" data-field="filled_out" style="background-color: #023e8a;">Properly Filled Out</div>
                                                    <div class="draggable" draggable="true" data-field="signed" style="background-color: #0077b6;">Properly Signed</div>
                                                    <div class="draggable" draggable="true" data-field="compliance" style="background-color: #0096c7;">Compliant</div>
                                                    <div class="draggable" draggable="true" data-field="frequency" style="background-color: #00b4d8;">Frequency of Collection</div>
                                                    <!-- <div class="draggable" draggable="true" data-field="assigned_count" style="background-color: #48cae4;">Assigned</div> -->
                                                </div>
                                                <div id="chart-container">
                                                    <div id="chartdiv"></div>
                                                    <div id="initial-message">Drag and drop an item to see the results or click on an item</div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                      
                                    <div class="col-md-6">
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                            <!--<h4 class="widget-thumb-heading"></h4>-->
                                            <h3 class="d-flex justify-content-center">Properly Signed</h3>
                                            <div class="widget-thumb-wrap">
                                                <div id="signedChart" style="width: 100%; height: 500px;"></div>
                                            </div>
                                        </div>      
                                                                               
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                            <h3 class="d-flex justify-content-center">Assigned Form</h3>
                                            <div class="widget-thumb-wrap">
                                                <div id="assignedtochart" style="width: 100%; height: 500px;"></div>
                                            </div>
                                        </div>  

                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 hide">
                                            <h3 class="d-flex justify-content-center">Assigned to</h3>
                                            <div class="widget-thumb-wrap">
                                                <div id="chartdiv3" style="width: 100%; height: 500px;"></div>
                                            </div>
                                        </div>  
                                    </div>                                                    
                                </div>
                            </div>
                        </div>



                        <!-- MODAL SERVICE -->
                        <div class="modal fade" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalNew">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Records Verification Management</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Department / Area</label>
                                                        <select class="form-control select2" name="department_id" onchange="changeDepartment(this, 1)" style="width: 100%;" required>
                                                            <option value="">Select</option>
                                                            <?php
                                                                $result = mysqli_query($conn,"SELECT ID, name FROM tbl_eforms_department WHERE user_id = $switch_user_id ORDER BY name");
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $ID = htmlentities($row['ID'] ?? '');
                                                                    $name = htmlentities($row['name'] ?? '');
                                                                    echo '<option value="'. $ID .'">'. $name .'</option>';
                                                                }
                                                            ?>
                                                            <option value="other">Other</option>
                                                        </select>
                                                        <input type="text" class="form-control margin-top-15 display-none" name="department_id_other" id="department_id_other_1" placeholder="Specify others" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Record Name</label>
                                                        <input type="type" class="form-control" name="record" required/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Assigned To</label>
                                                        <select class="form-control mt-multiselect btn btn-default" name="assigned_to_id[]" multiple="multiple" required>
                                                            <?php
                                                                $selectEmployee = mysqli_query( $conn,"SELECT ID, first_name, last_name FROM tbl_hr_employee WHERE status = 1 AND user_id=$switch_user_id" );
                                                                if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                                    while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                                        $rowEmployeeID = $rowEmployee["ID"];
                                                                        $rowEmployeeFName = htmlentities($rowEmployee["first_name"] ?? '');
                                                                        $rowEmployeeLName = htmlentities($rowEmployee["last_name"] ?? '');

                                                                        echo '<option value="'. $rowEmployeeID .'">'. $rowEmployeeFName .' '. $rowEmployeeLName .'</option>';
                                                                    }
                                                                } else {
                                                                    echo '<option disabled>No Available</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Description</label>
                                                <textarea class="form-control" name="description" required></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4" id="filled_1">
                                                    <div class="form-group">
                                                        <label>Properly Filled Out ?</label>
                                                        <div class="mt-radio-line">
                                                            <label class="mt-radio mt-radio-outline"> Yes
                                                                <input type="radio" value="1" name="filled_out" onchange="radioFilled(this, 1)">
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio mt-radio-outline"> No
                                                                <input type="radio" value="0" name="filled_out" onchange="radioFilled(this, 1)" checked>
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <input type="text" class="form-control" name="filled_out_reason" id="filled_out_reason_1" placeholder="Enter your reason here" required/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" id="signed_1">
                                                    <div class="form-group">
                                                        <label>Properly Signed or Initialed ?</label>
                                                        <div class="mt-radio-line">
                                                            <label class="mt-radio mt-radio-outline"> Yes
                                                                <input type="radio" value="1" name="signed" onchange="radioSigned(this, 1)">
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio mt-radio-outline"> No
                                                                <input type="radio" value="0" name="signed" onchange="radioSigned(this, 1)" checked>
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <input type="text" class="form-control" name="signed_reason" id="signed_reason_1" placeholder="Enter your reason here" required/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" id="compliance_1">
                                                    <div class="form-group">
                                                        <label>Is Compliant ?</label>
                                                        <div class="mt-radio-line">
                                                            <label class="mt-radio mt-radio-outline"> Yes
                                                                <input type="radio" value="1" name="compliance" onchange="radioCompliance(this, 1)" disabled>
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio mt-radio-outline"> No
                                                                <input type="radio" value="0" name="compliance" onchange="radioCompliance(this, 1)" checked>
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <input type="text" class="form-control" name="compliance_reason" id="compliance_reason_1" placeholder="Enter your reason here" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Frequency of Collection</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mt-radio-list">
                                                                    <label class="mt-radio mt-radio-outline"> Daily
                                                                        <input type="radio" value="0" name="frequency" checked />
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio mt-radio-outline"> Weekly
                                                                        <input type="radio" value="1" name="frequency" />
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio mt-radio-outline"> Monthly
                                                                        <input type="radio" value="2" name="frequency" />
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mt-radio-list">
                                                                    <label class="mt-radio mt-radio-outline"> Quarterly
                                                                        <input type="radio" value="3" name="frequency" />
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio mt-radio-outline"> Biannual
                                                                        <input type="radio" value="4" name="frequency" />
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio mt-radio-outline"> Annually
                                                                        <input type="radio" value="5" name="frequency" />
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <label>Others</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <input type="radio" value="6" name="frequency" />
                                                                <span></span>
                                                            </span>
                                                            <input class="form-control "type="text" name="frequency_other" placeholder="Please specify" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="control-label">Upload Document</label>
                                                        <select class="form-control" name="filetype" onchange="changeType(this)" required>
                                                            <option value="0">Select option</option>
                                                            <option value="1">Manual Upload</option>
                                                            <option value="2">Youtube URL</option>
                                                            <option value="3">Google Drive URL</option>
                                                            <option value="4">Sharepoint URL</option>
                                                        </select>
                                                        <input class="form-control margin-top-15 fileUpload" type="file" name="file" style="display: none;" />
                                                        <input class="form-control margin-top-15 fileURL" type="url" name="fileurl" style="display: none;" placeholder="https://" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="ccontrol-label">Document Date</label>
                                                        <input class="form-control" type="date" name="file_date" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Verified By</label>
                                                        <input class="form-control" type="text" name="verified" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Comment/Notes</label>
                                                <textarea class="form-control" name="notes" placeholder="Write some comment or notes here" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_Eforms" id="btnSave_Eforms" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Records Verification Management</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_EForms" id="btnUpdate_EForms" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalViewFile" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Records Verification Management</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/plugins/legend.js"></script>
        <?php include_once ('footer.php'); ?>

        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>


        <script src="AnalyticsIQ/rvm_chart.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $.fn.modal.Constructor.prototype.enforceFocus = function() {};

                $('.select2').select2();
                $('#tableData').DataTable();

                fancyBoxes();
            });

            function uploadNew(e) {
                $(e).parent().hide();
                $(e).parent().parent().find('select').removeClass('hide');
            }
            function changeType(e) {
                $(e).parent().find('input').hide();
                $(e).parent().find('input').prop('required',false);
                if($(e).val() == 1) {
                    $(e).parent().find('.fileUpload').show();
                    $(e).parent().find('.fileUpload').prop('required',true);
                } else if($(e).val() == 2 || $(e).val() == 3) {
                    $(e).parent().find('.fileURL').show();
                    $(e).parent().find('.fileURL').prop('required',true);
                }
            }

            function btnEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Eforms="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                        $('.select2').select2();
                        selectMulti();
                    }
                });
            }
            function btnView(id, freeaccess) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewFile_Eforms="+id+"&freeaccess="+freeaccess,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewFile .modal-body").html(data);
                    }
                });
            }
            function btnViewDepartment(id, freeaccess) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewDepartment_Eforms="+id+"&freeaccess="+freeaccess,
                    dataType: "html",
                    success: function(data){
                        $('#tableDataViewAll').removeClass('hide');
                        $("#tableData tbody").html(data);
                    }
                });
            }
            function btnViewDepartmentViewAll(id, freeaccessd) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewDepartmentViewAll_Eforms="+id+"&freeaccess="+freeaccess,
                    dataType: "html",
                    success: function(data){
                        $('#tableDataViewAll').addClass('hide');
                        $("#tableData tbody").html(data);
                    }
                });
            }
            function changeDepartment(id, modal) {
                if (id.value == "other") {
                    $('#department_id_other_'+modal).show();
                } else {
                    $('#department_id_other_'+modal).hide();
                }
            }
            function radioFilled(id, modal) {
                $('#compliance_'+modal+' input:radio[value="'+id.value+'"]').prop('checked',true);
                $('#compliance_'+modal+' input:radio').prop('disabled',false);
                $('#compliance_reason_'+modal).addClass('hide');
                if (id.value == 0) {
                    $('#filled_out_reason_'+modal).removeClass('hide');

                    $('#compliance_'+modal+' input:radio[value="1"]').prop('disabled',true);
                    $('#compliance_reason_'+modal).removeClass('hide');
                } else {
                    $('#filled_out_reason_'+modal).addClass('hide');

                    var signed = $('#signed_'+modal+' input[type="radio"]:checked').val();
                    if (signed == 0) {
                        $('#compliance_'+modal+' input:radio[value="0"]').prop('checked',true);
                        $('#compliance_'+modal+' input:radio[value="1"]').prop('disabled',true);
                        $('#compliance_reason_'+modal).removeClass('hide');
                    }
                }
            }
            function radioSigned(id, modal) {
                $('#compliance_'+modal+' input:radio[value="'+id.value+'"]').prop('checked',true);
                $('#compliance_'+modal+' input:radio').prop('disabled',false);
                $('#compliance_reason_'+modal).addClass('hide');
                if (id.value == 0) {
                    $('#signed_reason_'+modal).removeClass('hide');

                    $('#compliance_'+modal+' input:radio[value="1"]').prop('disabled',true);
                    $('#compliance_reason_'+modal).removeClass('hide');
                } else {
                    $('#signed_reason_'+modal).addClass('hide');

                    var filled = $('#filled_'+modal+' input[type="radio"]:checked').val();
                    if (filled == 0) {
                        $('#compliance_'+modal+' input:radio[value="0"]').prop('checked',true);
                        $('#compliance_'+modal+' input:radio[value="1"]').prop('disabled',true);
                        $('#compliance_reason_'+modal).removeClass('hide');
                    }
                }
            }
            function radioCompliance(id, modal) {
                if (id.value == 0) {
                    $('#compliance_reason_'+modal).removeClass('hide');
                } else {
                    $('#compliance_reason_'+modal).addClass('hide');
                }
            }

            $(".modalNew").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Eforms',true);

                var l = Ladda.create(document.querySelector('#btnSave_Eforms'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                l.setProgress(percentComplete / 100);
                            }
                       }, false);
                       return xhr;
                    },
                    success:function(response) {
                        alert(response);
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            var result = '<tr id="tr_'+obj.ID+'">';
                                result += '<td>'+obj.record+'</td>';
                                result += '<td>'+obj.files_date+'</td>';
                                result += '<td>'+obj.verified+'</td>';
                                result += '<td class="text-center">';
                                    result += '<div class="btn-group btn-group-circle">';
                                        result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('+obj.ID+')">Edit</a>';
                                        result += '<a href="#modalViewFile" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                    result += '</div>';
                                result += '</td>';
                            result += '</tr>';

                            $("#tableData tbody").prepend(result);
                            $('#modalNew').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalUpdate").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_EForms',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_EForms'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                l.setProgress(percentComplete / 100);
                            }
                       }, false);
                       return xhr;
                    },
                    success:function(response) {
                        alert(response);
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            var result = '<td>'+obj.record+'</td>';
                            result += '<td>'+obj.files_date+'</td>';
                            result += '<td>'+obj.verified+'</td>';
                            result += '<td class="text-center">';
                                result += '<div class="btn-group btn-group-circle">';
                                    result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('+obj.ID+')">Edit</a>';
                                    result += '<a href="#modalViewFile" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                result += '</div>';
                            result += '</td>';

                            $("#tableData tbody #tr_"+obj.ID).html(result);
                            $('#modalView').modal('hide');
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