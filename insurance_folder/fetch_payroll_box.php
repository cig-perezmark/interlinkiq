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

if(isset($_POST['key'])){
    $response = "";
    $i = 1;
    if ($_POST['key'] == 'ids') {
        $i++;
        ?>
         <tr id="row_tblpayroll<?= $i; ?>">
            <td><input class="form-control no-border" name="payroll_state[]" placeholder=""></td>
            <td><input class="form-control no-border" name="payroll_code[]" placeholder=""></td>
            <td><input class="form-control no-border" name="payroll_classification[]" placeholder=""></td>
            <td><input class="form-control no-border" name="payroll_estimated[]" placeholder=""></td>
            <td><input class="form-control no-border" name="payroll_projected[]" placeholder=""></td>
            <td><input class="form-control no-border" name="payroll_full_time[]" placeholder=""></td>
            <td><input class="form-control no-border" name="payroll_part_time[]" placeholder=""></td>
            <td><button type="button" name="remove" id="<?= $i; ?>" class="btn btn-danger float-right btn_remove_payroll_row"><i class="fa fa-close"></i></button></td>
        </tr>
    <?php } 
    else if ($_POST['key'] == 'get_payroll_form'){ ?>
        <div class="table-scrollable">
            <table class="table table-bordered">
                <thead>
                    <?php 
                        $query = mysqli_query($conn, "select * from tblEnterpise_payroll_header where payroll_h_enterprise_id = '$user_id'");
                        if(mysqli_fetch_row($query)){
                        foreach($query as $row_payroll){?>
                            <tr>
                                <th>State</th>
                                <th>Code</th>
                                <th>Classification</th>
                                <th width="350px">Estimated <input style="font-size:12px;" type="date" name="payroll_estimated_from" class=" no-border" value="<?= date('Y-m-d', strtotime($row_payroll['payroll_estimated_from'])); ?>"> 
                                To <input style="font-size:12px;" type="date" name="payroll_estimated_to" class=" no-border" value="<?= date('Y-m-d', strtotime($row_payroll['payroll_estimated_to'])); ?>"></th>
                                <th width="350px">Projected <input style="font-size:12px;" type="date" name="payroll_projected_from" class=" no-border" value="<?= date('Y-m-d', strtotime($row_payroll['payroll_projected_from'])); ?>"> 
                                To <input style="font-size:12px;" type="date" name="payroll_projected_to" class=" no-border" value="<?= date('Y-m-d', strtotime($row_payroll['payroll_projected_to'])); ?>"></th>
                                <th>Full Time <i style="font-size:10px;color:orange;">(No. of)</i></th>
                                <th>Part Time <i style="font-size:10px;color:orange;">(No. of)</i></th>
                                <th></th>
                            </tr>
                        <?php }
                        }else {?> 
                            <tr>
                                <th>State</th>
                                <th>Code</th>
                                <th>Classification</th>
                                <th width="350px">Estimated <input style="font-size:12px;" type="date" name="payroll_estimated_from" class=" no-border" required> 
                                To <input style="font-size:12px;" type="date" name="payroll_estimated_to" class=" no-border" required></th>
                                <th width="350px">Projected <input style="font-size:12px;" type="date" name="payroll_projected_from" class=" no-border" required> 
                                To <input style="font-size:12px;" type="date" name="payroll_projected_to" class=" no-border" required></th>
                                <th>Full Time <i style="font-size:10px;color:orange;">(No. of)</i></th>
                                <th>Part Time <i style="font-size:10px;color:orange;">(No. of)</i></th>
                                <th></th>
                            </tr>
                        <?php }
                    ?>
                    
                </thead>
                <tbody id="data_payroll">
                    <?php 
                        $data_query = mysqli_query($conn, "select * from tblEnterpise_payroll where payroll_enterprise_entities = '$user_id'");
                        foreach($data_query as $row_payroll){?>
                            <tr id="payroll_row<?= $row_payroll['payroll_id']; ?>">
                                <td><?= $row_payroll['payroll_state']; ?></td>
                                <td><?= $row_payroll['payroll_code']; ?></td>
                                <td><?= $row_payroll['payroll_classification']; ?></td>
                                <td><?= $row_payroll['payroll_estimated']; ?></td>
                                <td><?= $row_payroll['payroll_projected']; ?></td>
                                <td><?= $row_payroll['payroll_full_time']; ?></td>
                                <td><?= $row_payroll['payroll_part_time']; ?></td>
                                <td width="200px">
                                    <div class="btn-group btn-group-circle">
                                        <a  href="#modal_update_payroll" data-toggle="modal" type="button" id="update_payroll" data-id="<?= $row_payroll['payroll_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                	                    <a href="#modal_delete_payroll" data-toggle="modal" type="button" id="delete_payroll" data-id="<?= $row_payroll['payroll_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    ?>
                </tbody>
                <tbody id="dynamic_field_payroll">
                    <tr>
                        <td><input class="form-control no-border" name="payroll_state[]" placeholder=""></td>
                        <td><input class="form-control no-border" name="payroll_code[]" placeholder=""></td>
                        <td><input class="form-control no-border" name="payroll_classification[]" placeholder=""></td>
                        <td><input class="form-control no-border" name="payroll_estimated[]" placeholder=""></td>
                        <td><input class="form-control no-border" name="payroll_projected[]" placeholder=""></td>
                        <td><input class="form-control no-border" name="payroll_full_time[]" placeholder=""></td>
                        <td><input class="form-control no-border" name="payroll_part_time[]" placeholder=""></td>
                        <td><button type="button" name="add_payroll_row" id="add_payroll_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br><br>
        <div class="form-group">
            <div class="col-md-6">
                <div class="col-md-4">
                    <label class="form-control no-border">Annual WC Premiums: </label>
                </div>
                <div class="col-md-8">
                    <?php 
                        $query_premium = mysqli_query($conn, "select * from tblEnterpise_payroll_header where payroll_h_enterprise_id = '$user_id'");
                        if(mysqli_fetch_row($query_premium)){
                        foreach($query_premium as $row){?>
                            <input class="form-control bottom-border" placeholder="$" name="annual_premium" value="<?= $row['annual_premium']; ?>">
                        <?php }
                        }else {?> 
                            <input class="form-control bottom-border" placeholder="$" name="annual_premium">
                        <?php }
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <input class="btn green float-right" type="submit" name="btnAdd_payroll" id="btnAdd_payroll" value="Save" >
            </div>
        </div>
    <?php }
}
?>
