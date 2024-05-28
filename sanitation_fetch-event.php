<?php
    include 'database.php';
    if (isset($_COOKIE['switchAccount'])) { $userID = $_COOKIE['switchAccount']; }
    else { $userID = $_COOKIE['ID']; }
    
    $data = array();
    $sql = "SELECT * FROM parts_maintainance 
    INNER JOIN equipment_reg ON parts_maintainance.equipment_PK_id = equipment_reg.equip_id 
    INNER JOIN equipment_parts ON parts_maintainance.equipment_parts_PK_id = equipment_parts.equipment_parts_id
    WHERE equipment_reg.enterprise_owner = '$userID' ORDER BY parts_id " ; 
	$result = mysqli_query ($sanition_connection, $sql);

    foreach($result as $row){
        $title = $row['equipment'].": ".$row['equipment_name'];
        $data[] = array(
            'id' => $row['parts_id'],
            'title' => $title,
            'equipment_parts_PK_id' => $row['equipment_parts_PK_id'],
            'start' => $row['next_maintainance'],
            'parts_name' => $row['equipment_name'],
            'end' => $row['next_maintainance']
        );
    }
    echo json_encode($data);
?>