<?php 
require '../database.php';
	// Get status only
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
//add pricing
if( isset($_POST['btnNew_pricing']) ) {
    $user_id = $user_id;
    $Category = mysqli_real_escape_string($conn,$_POST['Category']);
    $Description = mysqli_real_escape_string($conn,$_POST['Description']);
    $MonthlySubscription = mysqli_real_escape_string($conn,$_POST['MonthlySubscription']);
    $Status = mysqli_real_escape_string($conn,$_POST['Status']);
    
	$sql = "INSERT INTO tblPricing (Category,Description,MonthlySubscription,Status,added_by) VALUES ('$Category','$Description','$MonthlySubscription','$Status','$user_id')";
    if(mysqli_query($conn, $sql)){
        
        $last_id = mysqli_insert_id($conn);
        $queryr = "SELECT * FROM tblPricing where pricing_id = $last_id";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                
                <tr id="<?= $row['pricing_id']; ?>">
                    <td><?php echo $row['Category']; ?></td>
                    <td><?php echo $row['Description']; ?></td>
                    <td>$<?php echo $row['MonthlySubscription']; ?></td>
                    <td>
                        <div class="btn-group btn-group-circle">
                           
                            <a  href="#modal_update_pricing" data-toggle="modal" type="button" id="update_pricing" data-id="<?php echo $row['pricing_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_pricing" data-toggle="modal" type="button" id="delete_pricing" data-id="<?php echo $row['pricing_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td> 
                </tr>
                
          <?php }
    }
}
?>