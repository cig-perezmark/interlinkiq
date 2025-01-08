<?php
    include '../database.php';
    
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
    
    if (!empty($_COOKIE['switchAccount'])) {
    	$portal_user = $_COOKIE['ID'];
    	$user_id = $_COOKIE['switchAccount'];
    	$userID = $_COOKIE['switchAccount'];
    } else {
    	$portal_user = $_COOKIE['ID'];
    	$user_id = employerID($portal_user);
    	$userID = $_COOKIE['ID'];
    }

    $data = array();
    $result = mysqli_query ($conn, "
        SELECT 
        u.email AS u_email,
        c.assign_task AS c_task,
        c.Task_added AS c_date_start,
        c.Deadline AS c_date_end,
        c.crm_ids AS c_ID
        FROM tbl_user AS u
        
        LEFT JOIN (
        	SELECT
            assign_task,
            Assigned_to,
            Task_added,
            Deadline,
            crm_ids
            FROM tbl_Customer_Relationship_Task
            WHERE Task_Status = 1
        ) AS c
        ON u.email = c.Assigned_to
        
        WHERE u.ID = $userID
    ");
    foreach($result as $row){
        // $end = 2023-01-01 00:00:00;
        $id = $row['c_ID'];
        $start = $row['c_date_start'];
        $end = $row['c_date_end'];
        // $end = date('Y-m-d h:m:s', strtotime($end. ' + 10 hours'));
        $title = htmlentities($row['c_task'] ?? '');
        $data[] = array(
            'id' => $id,
            'title' => $title,
            'start' => $end,
            'task_name' => '',
            'end' => $end,
            'allDay' => true,
            'url'=> 'customer_details.php?view_id='.$id.'#contact_tasks'
        );
    }
    echo json_encode($data);
?>