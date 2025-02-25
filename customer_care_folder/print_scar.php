<?php
require '../database.php';

if (!empty($_COOKIE['switchAccount'])) {
	$portal_user = $_COOKIE['ID'];
	$user_id = $_COOKIE['switchAccount'];
}
else {
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
}
function employerID($ID) {
	global $conn;

	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $ID" );
    $rowUser = mysqli_fetch_array($selectUser);
    $current_userEmployeeID = $rowUser['employee_id'];

    $current_userEmployerID = $ID;
    if ($current_userEmployeeID > 0) {
        $selectEmployer = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID" );
        if ( mysqli_num_rows($selectEmployer) > 0 ) {
            $rowEmployer = mysqli_fetch_array($selectEmployer);
            $current_userEmployerID = $rowEmployer["user_id"];
        }
    }

    return $current_userEmployerID;
}


//get capa report
if( isset($_GET['get_scar_id']) ) {
	$ID = $_GET['get_scar_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tbl_complaint_scar where scar_record_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
            <div class="form-group">
                <div class="col-md-12">
                    <center><h4><b>Supplier Corrective Action Request (SCAR)<br>CUSTOMER SERVICE USE ONLY</b></h4></center>
                </div>
            </div>
            <br>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;">
                <tbody>
                    <tr>
                        <td>
                            <b>SCAR Number:</b><br>
                            <?= $row['scar_number']; ?>
                        </td>
                        <td>
                            <b>Request Date:</b><br>
                            <?php if(!empty($row['request_date'] OR $row['request_date'] != '')){ echo date('Y-m-d', strtotime($row['request_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>
                        </td>
                        <td width="300px">
                            <b>Received (SCAR Completed) Date:</b><br>
                            <?php if(!empty($row['received_date'] OR $row['received_date'] != '')){ echo date('Y-m-d', strtotime($row['received_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Submitted By:</b><br>
                            <?= $row['submitted_by']; ?>
                        </td>
                        <td>
                            <b>Date / Time</b><br>
                            <?php if(!empty($row['date_time'] OR $row['date_time'] != '')){ echo date('Y-m-d', strtotime($row['date_time']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>"
                        </td>
                        <td>
                            <b>Submitted To (Supplier) </b><br>
                            <?= $row['submitted_to']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;">
                <tbody>
                    <tr>
                        <td>
                            <b>Customer Name: </b>
                            <?= $row['customer_name']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;margin-top:-20px;">
                <tbody>
                    <tr>
                        <td>
                            <b>Address: </b>
                            <?= $row['scar_address']; ?>
                        </td>
                        <td>
                            <b>Phone: </b>
                            <?= $row['scar_phone']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Contact: </b>
                            <?= $row['scar_contact']; ?>
                        </td>
                        <td>
                            <b>Email: </b>
                            <?= $row['scar_email']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;margin-top:-20px;">
                <tbody>
                    <tr>
                        <td>
                            <b>Location Issuing the SCAR: </b>
                            <?= $row['location_issuing']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;margin-top:-20px;">
                <tbody>
                    <tr>
                        <td>
                            <b>Supplier Product: </b>
                            <?= $row['supplier_product']; ?>
                        </td>
                        <td>
                            <b>Product Code: </b>
                            <?= $row['product_code']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;margin-top:-20px;">
                <tbody>
                    <tr>
                        <td>
                            <b>Product Lot: </b><br>
                            <?= $row['product_lot']; ?>
                        </td>
                        <td>
                            <b>PO number: </b><br>
                            <?= $row['scar_po_number']; ?>
                        </td>
                        <td>
                            <b>Product Quantity: </b><br>
                            <?= $row['product_quantity']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;">
                <tbody>
                    <tr>
                        <td>
                            <center>
                                <h5><b>STEP 1 – NON-CONFORMANCE DESCRIPTION:</b></h5>
                                <p>Identify the finding / issue(s) which requires  Corrective Action (CA) <br> Preventative Action (PA) / and Root Cause Analysis (RCA).<br>
                                Include the Requirement(s), the finding, and the “as evidence by” stated on the CAR.</p>
                            </center>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;margin-top:-20px;">
                <tbody>
                    <tr>
                        <td>
                            <b>Description of Discrepancy (Required): </b><br>
                            <?= $row['desc_discrepancy']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Findings: </b><br>
                            <?= $row['findings']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>As Evidenced By: </b><br>
                            <?= $row['as_evidenced_by']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;margin-top:-20px;">
                <tbody>
                    <tr>
                        <td>
                            <center><b>Image Reference</b></center>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <div class="col-md-6">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 450px; height: 450px;">
                                            <?php
                                                if ( empty($row['image_reference']) ) {
                                                    echo '<img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />';
                                                } else {
                                                    echo '<img src="customer_care_file/'.$row['image_reference'].'" class="img-responsive" alt="Avatar" />';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </center>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;">
                <tbody>
                    <tr>
                        <td>
                            <center>
                                <h5><b>FOR SUPPLIER USE ONLY</b></h5>
                                <p>Please complete Step 2 within 3 Business Days (72 HOURS) of the Issue Date</p>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>STEP 2 – CONTAINMENT ACTIONS:</b>
                            <p>Detail the containment Actions taken, the dates of containment ( if complete, just type “complete” ),
                            and who performed the task for potential areas affected, at the customer, WIP, items in stock, at the supplier, and any other areas affected.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;margin-top:-20px;">
                <tbody>
                    <tr>
                        <td>
                            <center><label><b>Respond to each question. If the question does not apply to this response, please put N/A.</b></label></center>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;margin-top:-20px;">
                <tbody>
                    <tr>
                        <td width="20px">
                            
                        </td>
                        <td>
                            Extent of Condition
                        </td>
                        <td>
                            Responsible Party
                        </td>
                    </tr>
                    <tr>
                        <td width="20px">
                            1.
                        </td>
                        <td>
                            a) How many total products were affected?
                                <br><br>
                                b) Where are they?
                        </td>
                        <td>
                            <label>Qty:</label><br>
                            <?= $row['scar_qty']; ?>
                            <hr>
                            <label>Shipping:</label><br>
                            <?= $row['scar_shipping']; ?>
                            <hr>
                            <label>Stock In:</label><br>
                            <?= $row['stock_in']; ?>
                            <hr>
                            <label>Transit:</label><br>
                            <?= $row['transit']; ?>
                            <hr>
                            <label>Other:</label><br>
                            <?= $row['scar_other']; ?>
                        </td>
                        <td>
                            <?= $row['responsible_party1']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="20px">
                            2
                        </td>
                        <td>
                            How many are conforming?
                        </td>
                        <td>
                            <label>Qty:</label><br>
                            <?= $row['conforming_qty']; ?>
                        </td>
                        <td>
                            <?= $row['responsible_party2']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="20px">
                            3
                        </td>
                        <td>
                            How many are nonconforming (NC)?
                        </td>
                        <td>
                            <label>NC Tag #:</label><br>
                            <?= $row['nc_tag']; ?>
                        </td>
                        <td>
                            <?= $row['responsible_party3']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="20px">
                            4
                        </td>
                        <td>
                            What steps were taken to ensure the nonconforming product does not leave suppliers’ premises (i.e., Quality Alert, Stop Shipment, etc.)?
                        </td>
                        <td>
                            <?= $row['nonconforming_step']; ?>
                        </td>
                        <td>
                            <?= $row['responsible_party4']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="20px">
                            5
                        </td>
                        <td>
                             Was the sub-tier supplier at fault?
                            <br><br>
                            If yes, enter the Supplier CAR number.
                        </td>
                        <td>
                             <label>
                                <input type="radio" name="is_yes" value="1" <?php if($row['is_yes']==1){echo 'checked';} ?>> Yes
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" name="is_yes" value="0" <?php if($row['is_yes']==0){echo 'checked';} ?>> No
                            </label>
                            <br>
                            <?= $row['supplier_car_number']; ?>
                        </td>
                        <td>
                            <?= $row['responsible_party5']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;margin-top:-20px;">
                <tbody>
                    <tr>
                        <td width="20px">
                            
                        </td>
                        <td>
                            <b>Communication of non-conformance to ALL affected parties.</b>
                        </td>
                        <td>
                            List all parties notified of escape (internal and external) and the date notified.
                        </td>
                        <td>
                            Responsible Party
                        </td>
                    </tr>
                    <tr>
                        <td width="20px">
                            6
                        </td>
                        <td>
                            Was there a Post Delivery Notification issued to the customer?
                             <br><br>
                                If yes, enter the record number.
                        </td>
                        <td>
                            <label>
                                <input type="radio" name="record_number_is_yes" value="1" <?php if($row['record_number_is_yes']==1){echo 'checked';} ?>> Yes
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" name="record_number_is_yes" value="0" <?php if($row['record_number_is_yes']==0){echo 'checked';} ?>> No
                            </label>
                            <br><hr>
                            <?= $row['if_yes_car_number']; ?>
                        </td>
                        <td>
                            <?= $row['responsible_party6']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td></td>
                        <td>Party or Persons Notified</td>
                        <td>Date</td>
                        <td>Responsible Party</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $count = 1;
                        $query_notify = mysqli_query($conn, "select * from tbl_complaint_person_notify where scar_record_pk = '$ID'");
                        foreach($query_notify as $row_notify){?>
                            <tr id="row_data_notify_<?= $row_notify['notify_id']; ?>">
                                <td><?= $count++; ?></td>
                                <td><?= $row_notify['person_notified']; ?></td>
                                <td><?= date('Y-m-d', strtotime($row_notify['date_notify'])); ?></td>
                                <td><?= $row_notify['responsible_party']; ?></td>
                            </tr>
                        <?php }
                    ?>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td></td>
                        <td>Containment Actions were taken to correct the immediate non-conformance. <i style="color:red;">Include the activities. Include objective evidence that a completed response was acted on.</i></td>
                        <td>Responsible Party</td>
                        <td>Expected Completion</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $count1 = 1;
                        $query_non_conformance = mysqli_query($conn, "select * from tbl_complaint_non_conformance where scar_record_pk = '$ID'");
                        foreach($query_non_conformance as $row_non){?>
                            <tr id="row_data_non_<?= $row_non['non_id']; ?>">
                                <td><?= $count1++; ?></td>
                                <td><?= $row_non['non_conformance']; ?></td>
                                <td><?= $row_non['responsible_party']; ?></td>
                                <td><?= date('Y-m-d', strtotime($row_non['expected_completion'])); ?></td>
                            </tr>
                        <?php }
                    ?>
                </tbody>
            </table>
            <div class="form-group">
                <center><h5><b>Please complete steps 3, 4, 5, and 6 within 7 days of Issue Date (or return of part)</b></h5></center>
            </div>
            <div class="col-md-12">
                <p><b>STEP 3 – ROOT CAUSE:</b><br>
                Perform a 5-Why analysis for each finding and each significant contributor to the problem. For escapes, include a 5-Why for the final inspection failure prior to shipping.</p>
            </div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td width="100px">Finding 1</td>
                        <td><?= $row['finding1']; ?></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td><?= $row['f1_why1']; ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><?= $row['f1_why2']; ?></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td><?= $row['f1_why3']; ?></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td><?= $row['f1_why4']; ?></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td><?= $row['f1_why5']; ?></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td width="100px">Finding 2</td>
                        <td><?= $row['finding2']; ?></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td><?= $row['f2_why1']; ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><?= $row['f2_why2']; ?></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td><?= $row['f2_why3']; ?></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td><?= $row['f2_why4']; ?></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td><?= $row['f2_why5']; ?></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td width="100px">Finding 3</td>
                        <td><?= $row['finding3']; ?></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td><?= $row['f3_why1']; ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><?= $row['f3_why2']; ?></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td><?= $row['f3_why3']; ?></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td><?= $row['f3_why4']; ?></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td><?= $row['f3_why5']; ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <center><b>If another Root Cause methodology is used, other than the 5-Why, please attach to this form for objective evidence.<br></b></center>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <p>
                         <b>Root Cause Statement:</b><br>
                        The Root Cause is the most basic reason for a deficiency which, if eliminated, would prevent the problem from recurring.)
                        – Include what failed in manufacturing and/or inspection. If you have identified a supplier is responsible, including the supplier’s Root Cause Corrective Action (RCCA) with this response.
                    </p>
                </div>
            </div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td width="150px">Finding 1</td>
                        <td><?= $row['root_cause_finding1']; ?></td>
                    </tr>
                    <tr>
                        <td>Finding 2 (if utilized):</td>
                        <td><?= $row['root_cause_finding2']; ?></td>
                    </tr>
                    <tr>
                        <td>Finding 3 (if utilized):</td>
                        <td><?= $row['root_cause_finding3']; ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <div class="col-md-12">
                    <p>
                         <b>STEP 4 – CORRECTIVE / PREVENTATIVE ACTION TASKS:</b><br>
                        List all the corrective/preventative actions to be taken for each Root Cause. Ensure that the proposed actions address the identified root cause(s). 
                        Include responsible parties and targeted completion dates in your response. Include either objective evidence that a completed response was acted on; this is required.
                    </p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <p>
                         <b>NOTES:</b><br>
                            1.) If your CA/PA actions reference attachments, they must be submitted with your response to [Enter Company Name]
                            <br>
                            2.) Is the CA/PA applicable to other areas? If so, identify the owner responsible for implementing Corrective Action in other areas.
                    </p>
                </div>
            </div>
            <div class="table table-scrollable">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td></td>
                            <td>CA/PA Required</td>
                            <td>Responsible Party</td>
                            <td>Expected Date of Completion</td>
                        </tr>
                    </thead>
                    <tbody>
                         <?php 
                            $count1 = 1;
                            $query_non_conformance = mysqli_query($conn, "select * from tbl_complaint_action_reference where scar_record_pk = '$ID'");
                            foreach($query_non_conformance as $row_non){?>
                                <tr id="row_data_capa_<?= $row_non['cap_id']; ?>">
                                    <td><?= $count1++; ?></td>
                                    <td><?= $row_non['capa_required']; ?></td>
                                    <td><?= $row_non['capa_responsible']; ?></td>
                                    <td><?= date('Y-m-d', strtotime($row_non['capa_expected_completion'])); ?></td>
                                </tr>
                            <?php }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                   <label>Comments</label>
                   <textarea class="form-control border-bottom" rows="3" name="step_4_comments"><?= $row['step_4_comments']; ?></textarea>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-md-12">
                    <center><b>List other products, processes, equipment, etc., that, upon review, may have similar issues. Does the identified problem in other products,
                    processes, equipment, etc.? Does the problem affect other suppliers or vendor areas? Is it Plant-wide? Include these in your CA/PA actions</b></center>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td></td>
                        <td>List other products, procedures, equipment, etc.</td>
                        <td>Supplier / Vendor Affected</td>
                        <td>Plant-wide?</td>
                        <td>Responsible Party</td>
                        <td>Expected Date of Completion</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $count1 = 1;
                        $query_affected = mysqli_query($conn, "select * from tbl_complaint_affected where scar_record_pk = '$ID'");
                        foreach($query_affected as $row_affected){?>
                            <tr id="row_data_capa_<?= $row_affected['cap_id']; ?>">
                                <td><?= $count1++; ?></td>
                                <td><?= $row_affected['list_other_products']; ?></td>
                                <td><?= $row_affected['supplier_vendor']; ?></td>
                                <td><?= $row_affected['plant_wide']; ?></td>
                                <td><?= $row_affected['affected_reponsible']; ?></td>
                                <td><?= date('Y-m-d', strtotime($row_affected['affected_completion'])); ?></td>
                            </tr>
                        <?php }
                    ?>
                </tbody>
            </table>
            <div class="form-group">
                <div class="col-md-12">
                   <label>Comments</label><br>
                   <?= $row['list_products_comments']; ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <p><b>STEP 5 – VERIFY THE EFFECTIVENESS OF THE CORRECTIVE/PREVENTATIVE ACTION:</b><br>
                        Describe the process used to monitor/measure the CA/PA effectiveness in eliminating the Root Cause(s) and to ensure that the permanent actions taken have prevented the recurrence of the problem.
                        <br><br>
                        Evidence of completed action is mandatory; include changes in any process, procedures, equipment, training, including any rework documentation, policies, and work instructions with this document via attachment.
                        <br><br>
                        Ensure that the responsible party and the effective date are identified for each completed action
                    </p>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-md-12">
                    <center>
                        <b>List actions to verify each CA/PA action listed in Step 4.</b>
                    </center>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td></td>
                        <td>Verification Action Plan</td>
                        <td>Responsible Party</td>
                        <td>Expected Completion Date</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $count1 = 1;
                        $query_verification = mysqli_query($conn, "select * from tbl_complaint_verification where scar_record_pk = '$ID'");
                        foreach($query_verification as $row_verification){?>
                            <tr id="row_data_verification_<?= $row_verification['verification_id']; ?>">
                                <td><?= $count1++; ?></td>
                                <td><?= $row_verification['verification_plan']; ?></td>
                                <td><?= $row_verification['verification_party']; ?></td>
                                <td><?= date('Y-m-d', strtotime($row_verification['verification_date'])); ?></td>
                            </tr>
                        <?php }
                    ?>
                </tbody>
            </table>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>
                            Is a planning change required?
                            <br><br><br>
                            If yes, identify who, where, when, and how the planning change was validated.
                        </td>
                        <td>
                            <label>
                                <input type="radio" name="is_planning_change" value="1" <?php if($row['is_planning_change']==1){echo 'checked';} ?>> Yes
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" name="is_planning_change" value="0" <?php if($row['is_planning_change']==0){echo 'checked';} ?>> No
                            </label>
                            <br>
                            <hr>
                            <?= $row['planning_specify']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Are any documents to be modified relative to this response (i.e., Policies, SOPs, Forms, etc.)?
                        </td>
                        <td>
                            <label>
                                <input type="radio" name="is_document_modified" value="1" <?php if($row['is_document_modified']==1){echo 'checked';} ?>> Yes
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" name="is_document_modified" value="0" <?php if($row['is_document_modified']==0){echo 'checked';} ?>> No
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <div class="col-md-12">
                    <center>
                        <b>List the documents to be modified and the date of the modification: (documents will be sent electronically or via fax when they are approved and released)</b>
                    </center>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td></td>
                        <td>List of Documents</td>
                        <td>Date</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $count1 = 1;
                        $query_verification = mysqli_query($conn, "select * from tbl_complaint_documents where scar_record_pk = '$ID'");
                        foreach($query_verification as $row_verification){?>
                            <tr id="row_data_documents_<?= $row_verification['list_id']; ?>">
                                <td><?= $count1++; ?></td>
                                <td><?= $row_verification['list_document']; ?></td>
                                <td><?= date('Y-m-d', strtotime($row_verification['list_date'])); ?></td>
                            </tr>
                        <?php }
                    ?>
                </tbody>
            </table>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Comments</label>
                </div>
                <div class="col-md-12">
                    <textarea class="form-control border-bottom" rows="3" name="modified_comment"><?= $row['modified_comment']; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <p>
                        <b>STEP 6 – FOLLOW-UP:</b>
                        Determine and include any actions to ensure the corrective action continues to be effective in precluding recurrence of the non-conformance(s) – this may include
                    </p>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td></td>
                        <td>Follow-Up Actions</td>
                        <td>Responsible Party</td>
                        <td>Date Performed</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $count1 = 1;
                        $query_verification = mysqli_query($conn, "select * from tbl_complaint_followup where scar_record_pk = '$ID'");
                        foreach($query_verification as $row_verification){?>
                            <tr id="row_data_followup_<?= $row_verification['followup_id']; ?>">
                                <td><?= $count1++; ?></td>
                                <td><?= $row_verification['followup_action']; ?></td>
                                <td><?= $row_verification['followup_responsible']; ?></td>
                                <td><?= date('Y-m-d', strtotime($row_verification['followup_date_performed'])); ?></td>
                            </tr>
                        <?php }
                    ?>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;">
                <tbody>
                    <tr>
                        <td width="">
                            <b>Investigated By:</b>
                            <br><br>
                            <?php
                                $inv = $row['scar_investigated_by'];
                                $query_investigated = "SELECT *  FROM tbl_hr_employee where user_id = $user_id and ID = '$inv' order by first_name ASC";
                                $result_investigated = mysqli_query($conn, $query_investigated);
                                                            
                                while($row_investigated = mysqli_fetch_array($result_investigated))
                                { ?> 
                                    <?= $row_investigated['first_name']; ?> <?= $row_investigated['last_name']; ?>
                            <?php } ?>
                        </td>
                        <td width="">
                            <b>Date:</b>
                            <br><br>
                             <?php if(!empty($row['scar_investigated_date'] OR $row['scar_investigated_date'] != '')){ echo date('Y-m-d', strtotime($row['scar_investigated_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Verified By:</b>
                            <br><br>
                            <?php 
                                $vb =  $row['scar_verified_by'];
                                $query_verified_by = "SELECT *  FROM tbl_hr_employee where user_id = $user_id and ID = '$vb' order by first_name ASC";
                                $result_verified_by = mysqli_query($conn, $query_verified_by);
                                                            
                                while($row_verified_by = mysqli_fetch_array($result_verified_by))
                                { ?> 
                                    <?= $row_verified_by['first_name']; ?> <?= $row_verified_by['last_name']; ?>
                            <?php } ?>
                        </td>
                        <td>
                            <b>Date:</b>
                            <br><br>
                            <?php if(!empty($row['scar_verified_date'] OR $row['scar_verified_date'] != '')){ echo date('Y-m-d', strtotime($row['scar_verified_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Approved By:</b>
                            <br><br>
                            <?php 
                                $appr = $row['scar_approved_by'];
                                $query_approved_by = "SELECT *  FROM tbl_hr_employee where user_id = $user_id and ID = '$appr' order by first_name ASC";
                                $result_approved_by = mysqli_query($conn, $query_approved_by);
                                                            
                                while($row_approved_by = mysqli_fetch_array($result_approved_by))
                                { ?> 
                                    <?= $row_approved_by['first_name']; ?> <?= $row_approved_by['last_name']; ?>
                            <?php } ?>
                        </td>
                        <td>
                            <b>Date:</b>
                            <br><br>
                            <?php if(!empty($row['scar_approved_date'] OR $row['scar_approved_date'] != '')){ echo date('Y-m-d', strtotime($row['scar_approved_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>
                        </td>
                    </tr>
                </tbody>
            </table>
    <?php } 
}
?>
