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
        $title = $row['CAI_filename'];
        $data[] = array(
            'id' => $row['CAI_id'],
            'title' => $title,
            'start' => $row['CAI_Action_date'],
            'task_name' => $row['CAI_filename'],
            'end' => $row['CAI_Action_date']
        );
    }
    echo json_encode($data);
?>