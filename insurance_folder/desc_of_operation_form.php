<?php 
include "../database.php";

// user identifier
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

//crm data
if(isset($_POST["key"])) {
    if($_POST["key"] == 'get_business_process'){
    $query = mysqli_query($conn, "select * from tblEnterpiseDetails where users_entities = $user_id");
    foreach($query as $row){
    $array_busi = explode(", ", $row["BusinessPROCESS"]); 
    ?>
            <div class="form-group">
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="16" <?php if(in_array('16', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Bottler
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="13" <?php if(in_array('13', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Brand Owner
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="9" <?php if(in_array('9', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Broker
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="7" <?php if(in_array('7', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Buyer
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="4" <?php if(in_array('4', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Co-Manufacturer
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="3"  <?php if(in_array('3', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Co-Packer
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="14" <?php if(in_array('14', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Cultivation
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="17" <?php if(in_array('17', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Distributor
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="2" <?php if(in_array('2', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Distribution
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="18" <?php if(in_array('18', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Importer
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="12" <?php if(in_array('12', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        IT Services
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="1" <?php if(in_array('1', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Manufacturing
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="19" <?php if(in_array('19', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Packing
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="10" <?php if(in_array('10', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Packaging
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="11" <?php if(in_array('11', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Professional Services
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="5" <?php if(in_array('5', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Retailer
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="6" <?php if(in_array('6', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Reseller
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="20" <?php if(in_array('20', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Supplier of Ingredients
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="8" <?php if(in_array('8', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Seller
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="21" <?php if(in_array('21', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Wholesaler
                    </label>
                </div>
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="BusinessPROCESS[]" value="15" <?php if(in_array('15', $array_busi)){echo 'checked';}else{echo '';} ?>>
                        Others
                    </label>
                </div>
            </div>
    <?php }
    }
}
?>
