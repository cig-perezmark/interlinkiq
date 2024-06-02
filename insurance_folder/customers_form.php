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
if(isset($_POST["search_val"])) {
    if($_POST["search_val"] == 19){?>
            <h3>Customers</h3>
            <p>(Please List Your Companies 3 Largest Customers):</p>
            <br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><label class="form-control no-border B">Customer</label> </th>
                        <th><label class="form-control no-border B">Percentage of Sales</label> </th>
                        <th><label class="form-control no-border B">Products Manufactured</label> </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="dynamic_field_customer">
                    <tr>
                        <td><input class="form-control no-border" placeholder=""></td>
                        <td><input class="form-control no-border" placeholder=""></td>
                        <td><input class="form-control no-border" placeholder=""></td>
                        <td><button type="button" name="add_customer_row" id="add_customer_row" class="btn btn-success"><i class="fa fa-plus"></i></button></td>
                    </tr>
                </tbody>
            </table>
            <div clas="form-group">
                <div>
                    <input type="submit" class="btn blue btn-primary float-right" value="Save">
                </div>
            </div>
    <?php }
}
?>
