<?php
    include '../database.php';
    if (isset($_COOKIE['switchAccount'])) { $userID = $_COOKIE['switchAccount']; }
    else { $userID = $_COOKIE['ID']; }
    
    $userIds = $_COOKIE['employee_id'];
    $data = array();
    $sql = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
    WHERE CAI_Assign_to	 = '$userIds' and CIA_progress != 2  and CAI_Assign_to !=0 and CAI_Assign_to !='' and CAI_Assign_to !=' ' ORDER BY CAI_id" ; 
	$result = mysqli_query ($conn, $sql);

    foreach($result as $row){
        // $end = 2023-01-01 00:00:00;
        $start = $row['CAI_Action_date'];
        $end = $row['CAI_Action_due_date'];
        if(empty($end)) { 
            $end = $row['CAI_Action_date'];
        } else if($end < $start) { 
            $end = $row['CAI_Action_date'];
        } else if (str_contains($end, '1970-01-01')) {
            $end = $row['CAI_Action_date'];
        }
        $end = date('Y-m-d h:m:s', strtotime($end. ' + 10 hours'));
        
        $title = $row['CAI_filename'];
        $data[] = array(
            'id' => $row['CAI_id'],
            'title' => $title,
            'start' => $row['CAI_Action_date'],
            'task_name' => $row['CAI_filename'],
            'end' => $end
        );
    }
    echo json_encode($data);
?>