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

// officer function
if(isset($_POST['key'])){
    if($_POST['key'] == 'get_desc_of_product'){
        $query_product = mysqli_query($conn, "select * from tblEnterpiseDetails WHERE users_entities = $user_id"); 
        foreach($query_product as $row){?>
            <div class="form-group">
                <div class="col-md-4">
                    <label>Does the enterprise offer products?</label>
                </div>
                <div class="col-md-2">
                    <label><input type="radio" placeholder="" name="enterpriseProducts" value="Yes" <?php if($row['enterpriseProducts']=='Yes'){echo 'checked';}else{echo '';} ?>> Yes</label>&nbsp;
                    <label><input type="radio" placeholder="" name="enterpriseProducts" value="No" <?php if($row['enterpriseProducts']=='No'){echo 'checked';}else{echo '';} ?>> No</label>
                </div>
            </div>
            
            <br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Products <i style="font-size:12px;color:orange;">(If yes)</i></th>
                        <!--<th></th>-->
                    </tr>
                </thead>
                <tbody id="dynamic_dp">
                    <tr>
                        <td><textarea class="form-control no-border" rows="10" name="ProductDesc"><?php echo $row['ProductDesc']; ?></textarea></td>
                        <!--<td>-->
                        <!--    <button type="button" name="add_dp_row" id="add_dp_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button>-->
                        <!--</td>-->
                    </tr>
                </tbody>
            </table>
        <?php }
    
    }
}

?>
