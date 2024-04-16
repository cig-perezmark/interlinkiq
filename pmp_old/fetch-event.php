<?php
    include 'connection/config.php';

    $data = array();
    $sql = "SELECT * FROM parts_maintainance ORDER BY parts_id " ; 
	$result = mysqli_query ($conn, $sql);

    foreach($result as $row){
        $data[] = array(
            'id' => $row['parts_id'],
            'title' => $row['equipment_PK_id'],
            'equipment_parts_PK_id' => $row['equipment_parts_PK_id'],
            'start' => $row['next_maintainance'],
            'end' => $row['next_maintainance']
        );
    }
    echo json_encode($data);
?>