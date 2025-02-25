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

if (isset($_POST['key'])) {
    $your_cookie= $_COOKIE['ID'];
    
	$response = "";
	
	
	if ($_POST['key'] == 'get_your_project') {
		$sql1 = $conn->query("SELECT * FROM tbl_project_management where addedby = $your_cookie and is_completed = 2");
		while($data = $sql1->fetch_array()) {
    			$response .= '
    			    <ul class="nav nav-stacked">
                        <li>
                            <a href="javascript:;">
                                '.$data['project_name'].' '.$data['descriptions'].'
                            </a>
                        </li>
                    </ul>
    			';
		}
	}
	
	

	exit($response);
}
	
?>
