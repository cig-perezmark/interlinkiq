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
	
	if ($_POST['key'] == 'get_default') {
	    $emp_assign = $_COOKIE['employee_id'];
	    $query = mysqli_query($conn, "SELECT * FROM tbl_MyProject_Services_History where Assign_to_history = '$emp_assign' group by MyPro_PK");
	    foreach($query as $row){
	        $project_id = $row['MyPro_PK'];
    		$sql1 = $conn->query("SELECT * FROM tbl_MyProject_Services where  MyPro_id = '$project_id' and Project_status !='2' order by Project_Name ASC");
    		while($data = $sql1->fetch_array()) {
    		        $us_id = $data['user_cookies'];
        			$response .= '
        			<div class="panel panel-default" style="padding:0px;">
                        <div class="panel-heading" style="padding:0px;">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#'.$data['MyPro_id'].'"> 
                                    <div class="todo-tasklist-item todo-tasklist-item-border-blue">';
                                        $user_query = mysqli_query($conn, "select * from tbl_user_info where user_id = '$us_id' limit 1");
                                        foreach($user_query as $row_us){
                                            if ( empty($row_us['avatar']) ) {
                                                $response .= '<img src="https://via.placeholder.com/150x150/EFEFEF/AAAAAA.png?text=no+image" class="todo-userpic pull-left" width="27px" height="27px">';
                                            } else {
                                                $response .= '<img src="uploads/avatar/'. $row_us['avatar'] .'" class="todo-userpic pull-left" width="27px" height="27px">';
                                            }
        		                        }
                                        $response .= '
                                        <div class="todo-tasklist-item-title"> '.$data['Project_Name'].' </div>
                                        <div class="todo-tasklist-item-text"> '.$data['Project_Description'].' </div>
                                        <div class="todo-tasklist-controls pull-left">
                                            <span class="todo-tasklist-date">
                                                <i class="fa fa-calendar"></i>Due: '.date('Y-m-d', strtotime($data['Desired_Deliver_Date'])).' </span>
                                            <span class="todo-tasklist-badge badge badge-roundless">Urgent</span>
                                        </div>
                                    </div>
                                </a>
                            </h4>
                        </div>
                        <div id="'.$data['MyPro_id'].'" class="panel-collapse collapse">
                            <div class="panel-body">';
                                $query_task = mysqli_query($conn, "SELECT * FROM tbl_MyProject_Services_History where Assign_to_history = '$emp_assign' group by MyPro_PK");
                        	    foreach($query_task as $row_task){
                                $response .= '
                                <a href="#" type="button" id="view_task" data-id="'.$row_task['History_id'].'" style="width:100%;text-decoration: none;">
                                <div class="todo-tasklist-item todo-tasklist-item-border-red">
                                    <div class="todo-tasklist-item-title"> '.$row_task['filename'].' </div>
                                    <div class="todo-tasklist-item-text"> '.$row_task['description'].' </div>
                                    <div class="todo-tasklist-controls pull-left">
                                        <span class="todo-tasklist-date">
                                            <i class="fa fa-calendar"></i>Due: '.date('Y-m-d', strtotime($row_task['Action_date'])).' </span>
                                        <span class="todo-tasklist-badge badge badge-roundless">Urgent</span>';
                                        $you = $row_task['Assign_to_history'];
                                        $query_you = mysqli_query($conn, "SELECT * FROM tbl_hr_employee where ID = '$you' limit 1");
                                	    foreach($query_you as $row_name){
                                        $response .= '
                                        <span class="todo-tasklist-badge badge badge-roundless">'.$row_name['first_name'].'</span>';
                                	    }
                                        $response .= '
                                    </div>
                                </div>
                                </a><br>';
                        	    }
                                $response .= '
                            </div>
                        </div>
                    </div>
        			';
    		}
	    }
	}
	
	else if ($_POST['key'] == 'get_your_project') {
		$sql1 = $conn->query("SELECT DISTINCT(Accounts_PK) FROM tbl_MyProject_Services where user_cookies = '$your_cookie' order by Accounts_PK ASC");
		while($data = $sql1->fetch_array()) {
    			$response .= '
    			    <ul class="nav nav-stacked">
                        <li>
                            <a href="javascript:;">
                                '.$data['Accounts_PK'].'
                            </a>
                        </li>
                    </ul>
    			';
		}
	}
	
	else if ($_POST['key'] == 'get_collab_project') {
	    $emp_cookie = $_COOKIE['employee_id'];
		$sql2 = $conn->query("SELECT * FROM tbl_MyProject_Services group by Accounts_PK");
		while($data2 = $sql2->fetch_array()) {
		        $array_data = explode(", ", $data2["Collaborator_PK"]);
		        if(in_array($emp_cookie,$array_data)){
    			$response .= '
    			    <ul class="nav nav-stacked">
                        <li>
                            <a href="javascript:;">
                                '.$data2['Accounts_PK'].'
                            </a>
                        </li>
                    </ul>
    			';
		        }
		}
	}
	
	

	exit($response);
}
	
?>
