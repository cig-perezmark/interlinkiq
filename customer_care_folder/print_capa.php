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
if( isset($_GET['get_capa_id']) ) {
	$ID = $_GET['get_capa_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tbl_complaint_capa where comp_record_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
            <div class="form-group">
                <div class="col-md-12">
                    <center><h4><b>INVESTIGATION CORRECTIVE ACTION REPORT</b></h4></center>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-md-12">
                    <b>Date: </b><?php if(!empty($row['date_perform'] OR $row['date_perform'] != '')){ echo date('Y-m-d', strtotime($row['date_perform']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>
                </div>
            </div>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;">
                <tbody>
                    <tr>
                        <td width="200px"><b>Initiated by: </b></td>
                        <td>
                            <?php
                                $ib = $row['initiated_by'];
                                $query_initiated = "SELECT *  FROM tbl_hr_employee where user_id = $user_id and ID = '$ib' order by first_name ASC";
                                $result_initiated = mysqli_query($conn, $query_initiated);
                                                            
                                while($row_initiated = mysqli_fetch_array($result_initiated))
                                { ?> 
                                    <?= $row_initiated['first_name']; ?> <?= $row_initiated['last_name']; ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Product Affected: </b></td>
                        <td>
                            <?= $row['product_affected']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Lot Code/Batch#: </b></td>
                        <td>
                            <?= $row['capa_lot_code']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Production Line: </b></td>
                        <td>
                            <?= $row['production_line']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Summary of Complaint: </b></td>
                        <td>
                            <?= $row['capa_summary_complaint']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;">
                <tbody>
                    <tr>
                        <td><b>Investigation & Quality Members: </b></td>
                        <td></td>
                    </tr>
                    <?php
                    $query_emp = mysqli_query($conn, "select * from tbl_complaint_quality_members where qm_ownedby = '$user_id' and capa_record_id=$ID");
                    foreach($query_emp as $row_emp){?>
                        <tr>
                               <td>
                                    <?= $row_emp['quality_member']; ?>
                               </td>
                               <td>
                                    <?= $row_emp['qm_desc']; ?>
                               </td>
                        </tr>
                    <?php }
                   ?>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;">
                <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                 <label class="col-md-4"><b>Describe the Problem:</b></label>
                                <label class="col-md-8 border-left"><b>Please attach the image to the next page as much as possible.</b></label>
                           </div>
                        </td>
                    </tr>
                    <tr>
                       <td>
                            <div class="col-md-12">
                               <p><?= $row['capa_describe']; ?></p>
                           </div>
                       </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                 <label class="col-md-4"><b>Root Cause:</b></label>
                                <label class="col-md-8 border-left"><b>Please attach the image to the next page as much as possible.</b></label>
                           </div>
                        </td>
                    </tr>
                    <tr>
                       <td>
                            <div class="col-md-12">
                               <p><?= $row['root_cause']; ?></p>
                           </div>
                       </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                 <label class="col-md-4"><b>Corrective Actions:</b></label>
                                <label class="col-md-8 border-left"><b>Please attach the image to the next page as much as possible.</b></label>
                           </div>
                        </td>
                    </tr>
                    <tr>
                       <td>
                            <div class="col-md-12">
                               <p><?= $row['corrective_action']; ?></p>
                           </div>
                       </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;">
                <tbody>
                    <tr>
                        <td><b>PO#:</b> <?= $row['capa_po']; ?></td>
                        <td><b>Claim Received Date:</b> <?php if(!empty($row['claim_received_date'] OR $row['claim_received_date'] != '')){ echo date('Y-m-d', strtotime($row['claim_received_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?></td>
                    </tr>
                    <tr>
                        <td><b>Client #:</b> <?= $row['capa_client']; ?></td>
                        <td><b>Claim & Defect QTY:</b> <?= $row['claim_defect_qty']; ?></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;">
                <tbody>
                    <tr>
                        <td><b>Remarks</b></td>
                    </tr>
                    <tr>
                        <td><?= $row['remarks']; ?></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;">
                <tbody>
                    <tr>
                        <td><center>Image of the Problem</center></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="col-md-12" style="display: flex;justify-content: center;">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 250px; height: 250px;">
                                        <?php
                                            if ( empty($row['problem_img']) ) {
                                                echo '<img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />';
                                            } else {
                                                echo '<img src="customer_care_file/'.$row['problem_img'].'" class="img-responsive" alt="Avatar" />';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><center>Image of Root Cause for Explanation</center></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="col-md-12" style="display: flex;justify-content: center;">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 250px; height: 250px;">
                                        <?php
                                            if ( empty($row['root_cause_img']) ) {
                                                echo '<img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />';
                                            } else {
                                                echo '<img src="customer_care_file/'.$row['root_cause_img'].'" class="img-responsive" alt="Avatar" />';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><center>Image for Corrective Actions</center></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="col-md-12" style="display: flex;justify-content: center;">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 250px; height: 250px;">
                                        <?php
                                            if ( empty($row['corrective_action_img']) ) {
                                                echo '<img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />';
                                            } else {
                                                echo '<img src="customer_care_file/'.$row['corrective_action_img'].'" class="img-responsive" alt="Avatar" />';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;">
                <thead>
                    <tr>
                        <th>Status:</th>
                        <th width="300px">Date:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label>
                                <input type="checkbox" name="status_comp" value="1" <?php if($row['status_comp']== 1){echo 'checked'; } ?>>
                                Yes
                            </label>
                            &nbsp;
                            <label>
                                <input type="checkbox" name="status_comp" value="0" <?php if($row['status_comp']== 0){echo 'checked'; } ?>>
                                Closed
                            </label>
                            &nbsp;
                            <label>
                                <input type="checkbox" name="status_comp" value="2" <?php if($row['status_comp']== 2){echo 'checked'; } ?>>
                                Follow Up
                            </label>
                        </td>
                        <td>
                            <?php if(!empty($row['status_date'] OR $row['status_date'] != '')){ echo date('Y-m-d', strtotime($row['status_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <div class="col-md-12">
                    <label><b>Date Perform</b></label>
                    <input type="date" class="form-control border-none" name="date_perform" value="<?php if(!empty($row['date_perform'] OR $row['date_perform'] != '')){ echo date('Y-m-d', strtotime($row['date_perform']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>">
                </div>
            </div>
            <hr>
            <table class="table table-bordered" style="width:100%; table-layout: fixed;">
                <tbody>
                    <tr>
                        <td width="">
                            <b>Investigated By:</b>
                            <br><br>
                            <?php
                                $inv = $row['investigated_by'];
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
                             <?php if(!empty($row['investigated_date'] OR $row['investigated_date'] != '')){ echo date('Y-m-d', strtotime($row['investigated_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Verified By:</b>
                            <br><br>
                            <?php 
                                $vb =  $row['verified_by'];
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
                            <?php if(!empty($row['verified_date'] OR $row['verified_date'] != '')){ echo date('Y-m-d', strtotime($row['verified_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Approved By:</b>
                            <br><br>
                            <?php 
                                $appr = $row['approved_by'];
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
                            <?php if(!empty($row['approved_date'] OR $row['approved_date'] != '')){ echo date('Y-m-d', strtotime($row['approved_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>
                        </td>
                    </tr>
                </tbody>
            </table>
    <?php } 
}
?>
