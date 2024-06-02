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
         <tr id="row_tblofficer'; $response .= $i;  $response .= '">
            <td><input class="form-control no-border" placeholder="" name="officer_name[]" required></td>
            <td><input class="form-control no-border" placeholder="" name="officer_title[]"></td>
            <td><input class="form-control no-border" placeholder="" name="ownership[]"></td>
            <td><input class="form-control no-border" placeholder="" name="class_code[]"></td>
            <td><input class="form-control no-border" placeholder="" name="comp_coverage[]"></td>
            <td><button type="button" name="remove" id="'; $response .= $i;  $response .= '" class="btn btn-danger float-right btn_remove_officer_row"><i class="fa fa-close"></i></button></td>
        </tr>
       ';
    }
    if ($_POST['key'] == 'fetch_officer') {
       $queryr = "SELECT * FROM tblEnterpise_officer where enterprise_id = $user_id";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
         {
       $response .= '
         <tr id="row_tblofficer'.$row['officer_id'].'">
            <td>'.$row['officer_name'].'</td>
            <td>'.$row['officer_title'].'</td>
            <td>'.$row['ownership'].'</td>
            <td>'.$row['class_code'].'</td>
            <td>'.$row['comp_coverage'].'</td>
            <td>
                <div class="btn-group btn-group-circle">
                    <a  href="#modal_update_officer" data-toggle="modal" type="button" id="update_officer" data-id="'.$row['officer_id'].'" class="btn btn-outline dark btn-sm">Edit</a>
                    <a href="#modal_delete_officer" data-toggle="modal" type="button" id="delete_officer" data-id="'.$row['officer_id'].'" class="btn btn-danger btn-sm" onclick="">Delete</a>
                </div>
            </td>
        </tr>
       ';
     }
    }
   exit($response);
}
?>
