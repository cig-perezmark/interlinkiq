<?php

//fetch.php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_FILES['servicelog_file']['name'])) {

        // die($_FILES['servicelog_file']['tmp_name']);

        $file_data = fopen($_FILES['servicelog_file']['tmp_name'], 'r');
        $column = fgetcsv($file_data);
        while($row = fgetcsv($file_data)) {
            $row_data[] = array(
                'service_description'  => $row[0],
                'service_action'  => $row[1],
                'service_comment'  => $row[2],
                'service_account'  =>  $row[3] ,
                'service_date'  =>  $row[4],
                'service_time'  => $row[5]
            );
        }
        $output = array(
            'column'  => $column,
            'row_data'  => $row_data
        );
    
        echo json_encode($output);
    }
}

?>