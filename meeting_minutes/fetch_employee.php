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
       $response .= '
         <tr id="row'; $response .= $i;  $response .= '">
            <td><input type="text" name="action_details[]" placeholder="Action Items" class="form-control action_list" /></td>
            <td>
                <select class="form-control status_s" type="text" name="assigned_to[]">
                    <option value="0">---Select---</option>
                    ';
                    $queryApp = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                    $resultApp = mysqli_query($conn, $queryApp);
                    while($rowApp = mysqli_fetch_array($resultApp))
                         { 
                           $response .= '<option value="'.$rowApp['ID'].'">'.$rowApp['first_name'].'</option>'; 
                       }
                     $response .= '
                </select> 
            </td>
            <td>
                <input type="date" name="target_due_date[]" class="form-control duedate" value="'.date('Y-m-d', strtotime(date('Y-m-d'))).'">
            </td>
            <td>
                <select class="form-control status_s" type="text" name="status[]">
                    <option value="Open">Open</option>
                    <option value="Follow Up">Follow Up</option>
                    <option value="Close">Close</option>
                </select>
            </td>
            <td>
            <button type="button" name="remove" id="'; $response .= $i;  $response .= '" class="btn btn-danger btn_remove">Remove</button></td>
        </tr>
       ';
        }
   exit($response);
}
?>
