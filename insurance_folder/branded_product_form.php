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
    if($_POST["search_val"] == 15){?>
            <h3>Branded Products</h3>
            <p>(Please provide percentage of branded, non-branded, and/or own label):</p>
            <br>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Your Brands</td>
                        <td><input class="form-control no-border" value="" placeholder="%"></td>
                    </tr>
                    <tr>
                        <td>Non-Branded</td>
                        <td>
                            <input class="form-control no-border" value="" placeholder="%">
                        </td>
                    </tr>
                    <tr>
                        <td>3 rd Party’s Brand(s)</td>
                        <td><input class="form-control no-border" value="" placeholder="%"></td>
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
