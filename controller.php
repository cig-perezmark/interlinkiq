<?php
    include "database.php";
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    
    
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
		$switch_user_id = $_COOKIE['switchAccount'];
	}
	else {
		$portal_user = $_COOKIE['ID'];
		$switch_user_id = employerID($portal_user);
	}
		
		
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['save_kpi_reviewer'])){
            if($_POST['collab_type'] == "performer"){
                $record_data = array(
                    'performer_id' => $this->input->post('employee_id_performer'),
                    'performer_frequency' => $this->input->post('performer_frequency'),
                    'form_code' => 'fscs'
                );
                $PK_id = $this->queries->insert($record_data, 'kpi_performer', true);
                if($PK_id){
                    echo '1';
                }
            }
        }
        if(isset($_POST['save_form_desc'])){
            // Update tbl_forms_owned table
            $id = $_POST['eforms_id'];
            $form_desc = $_POST['form_desc'];
            $update_query = "UPDATE tbl_afia_forms_list SET form_desc = '$form_desc'  WHERE PK_id = $id";
            $update_result = mysqli_query($e_connection, $update_query);
            if($update_result){
                header('Location: ' . $_SERVER["HTTP_REFERER"]);
             }
        }
        if(isset($_POST['save_category'])){
            $category_name = $_POST['category_name'];
            $label_color = $_POST['label_color'];
            $insert_query = "INSERT INTO tbl_eforms_category (category_name, label_color) VALUES ('$category_name','$label_color')";
            mysqli_query($conn, $insert_query);
            header('Location: ' . $_SERVER["HTTP_REFERER"]);
        }
        if(isset($_POST['submit_eform_category'])){
            // Check if the form data is submitted
            $PK_id = $_POST['parent_id'];
            if(isset($_POST['eform_id']) && is_array($_POST['eform_id'])){
                // Loop through each selected eform_id
                foreach($_POST['eform_id'] as $eform_id){
                    // Fetch form details from tbl_afia_forms_list
                    $query = "SELECT afl_form_name, afl_form_code FROM tbl_afia_forms_list WHERE PK_id = '$eform_id'";
                    $result = mysqli_query($e_connection, $query);
                    $row = mysqli_fetch_assoc($result);
        
                    // Check if the form details are fetched
                    if($row){
                        // Insert form details into tbl_eforms_forms
                        $form_name = $row['afl_form_name'];
                        $form_code = $row['afl_form_code'];
                        $insert_query = "INSERT INTO tbl_eforms_forms (PK_id,form_id, form_conde) VALUES ('$PK_id','$eform_id', '$form_code')";
                        mysqli_query($conn, $insert_query);
                        header('Location: ' . $_SERVER["HTTP_REFERER"]);
                    }
                }
                // Success message or any other action after inserting data
                // echo "Forms inserted successfully!";
            } else {
                // Handle case where no eform_id is selected
                echo "No forms selected!";
            }
        }
        if(isset($_POST['save_kpi_records'])){
            // Inserting the data into the database
            $action_items = $_POST['action_items'];
            $notes = mysqli_real_escape_string($e_connection, $_POST['notes']); // Sanitize input
        
            foreach($action_items as $index => $action_item) {
                $answer = isset($_POST['answer_'.$index]) ? mysqli_real_escape_string($e_connection, $_POST['answer_'.$index]) : null;
                $action_item = mysqli_real_escape_string($e_connection, $action_item);
                $performed = $_POST['performed'];
                $not_perform = $_POST['not_perform'];
                $sql = "INSERT INTO kpi_action_items_records (action_items, answer, notes,performed,not_perform) VALUES ('$action_item', '$answer', '$notes','$performed','$not_perform')";
                
                if (mysqli_query($e_connection, $sql)) {
                    header('Location: ' . $_SERVER["HTTP_REFERER"]);
                } else {
                    echo "Error inserting record: " . mysqli_error($e_connection);
                }
            }
        }
        if(isset($_POST['generate_form'])){
            $session_id = $_COOKIE['ID'];
            $form_name = $_POST['form_name'];
            $insert_query = "INSERT INTO tbl_afia_forms_list (afl_form_name,pending_records,afl_status_flag,afl_form_code) VALUES ('$form_name','1','C','checklist_form')";
            $result = mysqli_query($e_connection,$insert_query);
            // Get the last inserted ID
            $last_inserted_id = mysqli_insert_id($e_connection);
            
            // Update tbl_forms_owned table
            $select_user_table = "SELECT ID,employee_id FROM tbl_user WHERE ID = $session_id";
            $user_result = mysqli_query($conn,$select_user_table);
            $user_row = mysqli_fetch_assoc($user_result);
            $employee_id = $user_row['employee_id'];
            $hr_employee = "SELECT ID,user_id FROM tbl_hr_employee WHERE ID = $employee_id";
            $employee_resut = mysqli_query($conn,$hr_employee);
            $enterprise_id = mysqli_fetch_assoc($employee_resut);
            
            $employee_enterprise_id = $enterprise_id['user_id'];
            if(!$employee_enterprise_id){
                $employee_enterprise_id = $session_id;
            }
            // Check if a record exists
            $select_query = "SELECT * FROM tbl_forms_owned WHERE user_id = $session_id AND enterprise_id = $employee_enterprise_id";
            $select_result = mysqli_query($conn, $select_query);
            
            if($select_result) {
                // Record exists, perform an update
                $update_query = "UPDATE tbl_forms_owned SET form_owned = CONCAT(form_owned, ',', '$last_inserted_id') WHERE user_id = $session_id AND enterprise_id = $employee_enterprise_id";
                $update_result = mysqli_query($conn, $update_query);
                if($update_result) {
                    header('Location: ' . $_SERVER["HTTP_REFERER"]);
                } else {
                    // Handle update error
                    echo "Error updating record: " . mysqli_error($conn);
                }
            } else {
                // Record does not exist, perform an insert
                
                $insert_query = "INSERT INTO tbl_forms_owned (user_id, enterprise_id, form_owned) VALUES ('$session_id', '$employee_enterprise_id', '$last_inserted_id')";
                $insert_result = mysqli_query($conn, $insert_query);
                if($insert_result) {
                    header('Location: ' . $_SERVER["HTTP_REFERER"]);
                } else {
                    // Handle insert error
                    echo "Error inserting record: " . mysqli_error($conn);
                }
            }
            
        }
        if(isset($_POST['save_collab'])){
            // Handle form submission
            $enterprise_id = $_POST['enterprise_id'];
            $selected_employees = isset($_POST['employee_id']) ? $_POST['employee_id'] : [];
        
            // Fetch currently selected employees for the given enterprise_id
            $fetch_query = "SELECT employee_id FROM new_emp_collab WHERE enterprise_id = '$enterprise_id'";
            $fetch_result = mysqli_query($emp_connection, $fetch_query);
        
            $current_selected_ids = [];
            if ($fetch_result) {
                while ($row = mysqli_fetch_assoc($fetch_result)) {
                    $current_selected_ids[] = $row['employee_id'];
                }
            }
        
            // Identify newly selected employees
            $newly_selected = array_diff($selected_employees, $current_selected_ids);
            // Identify unselected employees
            $unselected = array_diff($current_selected_ids, $selected_employees);
        
            // Insert newly selected employees into the database
            foreach ($newly_selected as $employee_id) {
                $insert_query = "INSERT INTO new_emp_collab (enterprise_id, employee_id) VALUES ('$enterprise_id', '$employee_id')";
                mysqli_query($emp_connection, $insert_query);
            }
        
            // Remove unselected employees from the database
            foreach ($unselected as $employee_id) {
                $delete_query = "DELETE FROM new_emp_collab WHERE enterprise_id = '$enterprise_id' AND employee_id = '$employee_id'";
                mysqli_query($emp_connection, $delete_query);
            }
            header('Location: ' . $_SERVER["HTTP_REFERER"]);
        }
        if (isset($_POST['save_emp_record'])) {
            // Extract input arrays
            $parameter_ids = $_POST['parameter_id'];
            $oum = $_POST['oum'];
            $sampled_by = $_POST['sampled_by'];
            $sampled_date = $_POST['sampled_date'];
            $equip_ids = $_POST['equip_id'];
            $minimum_values = $_POST['minimum_value'];
            $maximum_values = $_POST['maximum_value'];
            $post_result = $_POST['result'];
            $remarks = $_POST['remarks'];
            $received_by = $_POST['received_by'];
            $received_date = $_POST['received_date'];
            
            // Create an array to store the test statuses
            $test_statuses = array();
        
            // Loop through the arrays and save records for each
            for ($i = 0; $i < count($parameter_ids); $i++) {
                $equip_id = $equip_ids[$i];
                $minimum_value = $minimum_values[$i];
                $maximum_value = $maximum_values[$i];
                $parameter_id = $parameter_ids[$i];
                $oum = $oum[$i];
                $result = $post_result[$i];
                $test_status = "Fail";
                
                if ($result >= $minimum_value && $result <= $maximum_value) {
                    $test_status = "Passed";
                    
                    // Update the status in the equipment_frequency table
                    $sql1 = "UPDATE new_emp_equipment_frequency SET status = 'Inspected' WHERE equipment_id = '$equip_id'";
                    $results = mysqli_query($emp_connection, $sql1);
                }
                
                // Insert the record into the database
               $sql = "INSERT INTO new_emp_records (oum,parameter_id,sampled_by, sampled_date, equip_id, minimum_value, maximum_value, result, remarks, received_by, received_date, test_status) VALUES ('$oum','$parameter_id','$sampled_by', '$sampled_date', '$equip_id', '$minimum_value', '$maximum_value', '$result', '$remarks', '$received_by', '$received_date', '$test_status')";
                
                if (mysqli_query($emp_connection, $sql)) {
                    // Store the test status for this records
                    $test_statuses[] = $test_status;
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($emp_connection);
                }
            }
        
            // Now you have an array $test_statuses that contains the test statuses for each record
            // You can use this array as needed, such as displaying it in your interface
            // ...
            
            // After processing all records, you can redirect or perform other actions
            header('Location: ' . $_SERVER["HTTP_REFERER"]);
        }
        if(isset($_POST['test_post'])){
            $minimum_inputs = $_POST['minimum_input'];  // Corrected variable name
            $parameter_ids = $_POST['parameter_id'];    // Corrected variable name
            $equipment_ids = $_POST['equip_id'];   // Corrected variable name
            $maximum_input = $_POST['maximum_input'];
            $owner_id = $_POST['owner_id'];
            $oum = $_POST['oum'];
            $input_oum = $_POST['input_oum'];
            for($i = 0;  $i < count($parameter_ids); $i++){
                $min_input = $minimum_inputs[$i];
                $param_id = $parameter_ids[$i];
                $equip_id = $equipment_ids[$i];
                $max_input = $maximum_input[$i];
                $oum_input = $oum[$i];
                if($input_oum[$i] != ''){
                    $oum_input = $input_oum[$i];
                    $insert_oum = "INSERT INTO new_emp_uom (uom,owner_id) VALUES('$oum_input','$owner_id')";
                    $result = mysqli_query($emp_connection,$insert_oum);
                }
                $sql_verifiy = "SELECT * FROM `new_emp_equipment_settings` WHERE equip_id = $equip_id AND parameter_id = {$param_id}";
                $sql_verify_result = mysqli_query($emp_connection,$sql_verifiy);
                $row_cnt = mysqli_num_rows($sql_verify_result);
                if($row_cnt <= 0){
                    $sql = "INSERT INTO new_emp_equipment_settings (minimum_input,parameter_id,equip_id,maximum_input,oum,owner_id) VALUES('$min_input','$param_id','$equip_id','$max_input','$oum_input','$owner_id')";
                }
                else{
                    $sql = "UPDATE new_emp_equipment_settings 
                    SET minimum_input = '$min_input', 
                        parameter_id = '$param_id', 
                        equip_id = '$equip_id', 
                        maximum_input = '$max_input', 
                        oum = '$oum_input', 
                        owner_id = '$owner_id' 
                    WHERE equip_id = '$equip_id' AND parameter_id = {$param_id} ";
                }
                $results = mysqli_query($emp_connection, $sql);
            }
            
            $equipments_id = $_POST['equipments_id'];
            $frequency = $_POST['frequency'];
            $day_of_the_week  = $_POST['day_of_the_week'];
            for($i = 0;  $i < count($equipments_id); $i++){
                $freq = $frequency[$i];
                $equips_id = $equipments_id[$i];
                $day = $day_of_the_week[$i];
                
                $sql_verifiy1 = "SELECT * FROM `new_emp_equipment_frequency` WHERE `equipment_id` = $equips_id";
                $sql_verify_result1 = mysqli_query($emp_connection,$sql_verifiy1);
                $row_cnt1 = mysqli_num_rows($sql_verify_result1);
                if($row_cnt1 <= 0){
                    $sql_insert = "INSERT INTO new_emp_equipment_frequency (frequency,equipment_id,day_of_the_week,owner_id) VALUES('$freq','$equips_id','$day','$owner_id')";
                }
                else{
                    $sql_insert = "UPDATE new_emp_equipment_frequency 
                       SET frequency = '$freq', 
                           equipment_id = '$equips_id', 
                           day_of_the_week = '$day', 
                           owner_id = '$owner_id' 
                       WHERE equipment_id = $equips_id";

                }
                
                $result = mysqli_query($emp_connection, $sql_insert);
                
                // Check if a file was uploaded for this equipment
                if ($_FILES['file_attachment']['error'][$i] === UPLOAD_ERR_OK) {
                    $file_name = $_FILES['file_attachment']['name'][$i];
                    $file_tmp = $_FILES['file_attachment']['tmp_name'][$i];
                    $file_destination = 'uploads/emp/' . $file_name;  // Set the appropriate upload directory path
            
                    // Move the uploaded file to the destination
                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        // File uploaded successfully, insert the record into the database
                        $sql_insert = "INSERT INTO new_emp_files (file_name, equipment_id,owner_id) VALUES ('$file_name', '$equips_id','$owner_id')";
                        $result = mysqli_query($emp_connection, $sql_insert);
                    } else {
                        // Handle file upload error
                        // You can add error handling code here
                    }
                }
                
            }
            header('Location: ' . $_SERVER["HTTP_REFERER"] );
        }
        
        if(isset($_POST['test_post_glp'])){
            $minimum_inputs = $_POST['minimum_input'];  // Corrected variable name
            $parameter_ids = $_POST['parameter_id'];    // Corrected variable name
            $equipment_ids = $_POST['equip_id'];   // Corrected variable name
            $maximum_input = $_POST['maximum_input'];
            $owner_id = $_POST['owner_id'];
            $oum = $_POST['oum'];
            $input_oum = $_POST['input_oum'];
            for($i = 0;  $i < count($parameter_ids); $i++){
                $min_input = $minimum_inputs[$i];
                $param_id = $parameter_ids[$i];
                $equip_id = $equipment_ids[$i];
                $max_input = $maximum_input[$i];
                $oum_input = $oum[$i];
                if($input_oum[$i] != ''){
                    $oum_input = $input_oum[$i];
                    $insert_oum = "INSERT INTO new_emp_uom_glp (uom,owner_id) VALUES('$oum_input','$owner_id')";
                    $result = mysqli_query($emp_connection,$insert_oum);
                }
                $sql_verifiy = "SELECT * FROM `new_emp_equipment_settings_glp` WHERE equip_id = $equip_id AND parameter_id = {$param_id}";
                $sql_verify_result = mysqli_query($emp_connection,$sql_verifiy);
                $row_cnt = mysqli_num_rows($sql_verify_result);
                if($row_cnt <= 0){
                    $sql = "INSERT INTO new_emp_equipment_settings_glp (minimum_input,parameter_id,equip_id,maximum_input,oum,owner_id) VALUES('$min_input','$param_id','$equip_id','$max_input','$oum_input','$owner_id')";
                }
                else{
                    $sql = "UPDATE new_emp_equipment_settings_glp 
                    SET minimum_input = '$min_input', 
                        parameter_id = '$param_id', 
                        equip_id = '$equip_id', 
                        maximum_input = '$max_input', 
                        oum = '$oum_input', 
                        owner_id = '$owner_id' 
                    WHERE equip_id = '$equip_id' AND parameter_id = {$param_id} ";
                }
                $results = mysqli_query($emp_connection, $sql);
            }
            
            $equipments_id = $_POST['equipments_id'];
            $frequency = $_POST['frequency'];
            $day_of_the_week  = $_POST['day_of_the_week'];
            for($i = 0;  $i < count($equipments_id); $i++){
                $freq = $frequency[$i];
                $equips_id = $equipments_id[$i];
                $day = $day_of_the_week[$i];
                
                $sql_verifiy1 = "SELECT * FROM `new_emp_equipment_frequency_glp` WHERE `equipment_id` = $equips_id";
                $sql_verify_result1 = mysqli_query($emp_connection,$sql_verifiy1);
                $row_cnt1 = mysqli_num_rows($sql_verify_result1);
                if($row_cnt1 <= 0){
                    $sql_insert = "INSERT INTO new_emp_equipment_frequency_glp (frequency,equipment_id,day_of_the_week,owner_id) VALUES('$freq','$equips_id','$day','$owner_id')";
                }
                else{
                    $sql_insert = "UPDATE new_emp_equipment_frequency_glp 
                       SET frequency = '$freq', 
                           equipment_id = '$equips_id', 
                           day_of_the_week = '$day', 
                           owner_id = '$owner_id' 
                       WHERE equipment_id = $equips_id";

                }
                
                $result = mysqli_query($emp_connection, $sql_insert);
                
                // Check if a file was uploaded for this equipment
                if ($_FILES['file_attachment']['error'][$i] === UPLOAD_ERR_OK) {
                    $file_name = $_FILES['file_attachment']['name'][$i];
                    $file_tmp = $_FILES['file_attachment']['tmp_name'][$i];
                    $file_destination = 'uploads/emp/' . $file_name;  // Set the appropriate upload directory path
            
                    // Move the uploaded file to the destination
                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        // File uploaded successfully, insert the record into the database
                        $sql_insert = "INSERT INTO new_emp_files_glp (file_name, equipment_id,owner_id) VALUES ('$file_name', '$equips_id','$owner_id')";
                        $result = mysqli_query($emp_connection, $sql_insert);
                    } else {
                        // Handle file upload error
                        // You can add error handling code here
                    }
                }
                
            }
            header('Location: ' . $_SERVER["HTTP_REFERER"] );
        }
        
        if(isset($_POST['save_new_emps'])){
             // Retrieve form data
            $equipment_area = $_POST['equipment_area'];
            $type = $_POST['type'];
            $sampled_by = $_POST['sampled_by'];
            $sampled_date = $_POST['sampled_date'];
            $result = $_POST['result'];
            $tolerance = $_POST['tolerance'];
            $received_by = $_POST['received_by'];
            $received_date = $_POST['recevied_date'];
            $zone_id  = $_POST['zone_id'];
            // File upload handling
            $targetDir = "uploads/emp/"; // Directory where uploaded files will be stored
            $image_sampling = $_FILES['image_sampling']['name'];
            $targetFilePath = $targetDir . $image_sampling;
            $fileUploaded = false;
        
            if (!empty($_FILES['image_sampling']['tmp_name']) && is_uploaded_file($_FILES['image_sampling']['tmp_name'])) {
                if (move_uploaded_file($_FILES['image_sampling']['tmp_name'], $targetFilePath)) {
                    $fileUploaded = true;
                }
            }
        
            // SQL query to insert data
            $sql = "INSERT INTO new_emps (equipment_area, image_sampling, type, sampled_by, sampled_date, result, tolerance, received_by, received_date, zone_id)
                    VALUES ('$equipment_area', '$image_sampling', '$type', '$sampled_by', '$sampled_date', '$result', '$tolerance', '$received_by', '$received_date','$zone_id')";
        
            if (mysqli_query($emp_connection, $sql)) {
                header('Location: ' . $_SERVER["HTTP_REFERER"] );
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($emp_connection);
            }
        
            mysqli_close($emp_connection);
        
            if ($fileUploaded) {
                echo "File uploaded successfully!";
            } else {
                echo "File upload failed!";
            }
        }
        if(isset($_POST['create_table_template'])){
            $zone_id = $_POST['zones_id'];
            $columnNames = $_POST["column_name"];
            $inputTypes = $_POST["input_type"];
            $columns = [];
            foreach ($columnNames as $index => $columnName) {
                echo $inputTypes[$index];
                $columnName = str_replace(' ', '_', $columnName);
                if ($columnName !== "") {
                    $inputType = isset($inputTypes[$index]) ? $inputTypes[$index] : "text";
                    $columns[] = "$columnName" . "_" . "$inputType" . " VARCHAR(150)";
                }
            }
            
            if (!empty($columns)) {
                $columnsString = implode(', ', $columns);
                echo $createTableSQL = "CREATE TABLE zone_$zone_id (id INT AUTO_INCREMENT PRIMARY KEY, $columnsString)";
                $results = mysqli_query($emp_connection, $createTableSQL);
                if ($results) {
                    // Modify this part to redirect or display a success message
                    echo '<script>alert("Table created successfully!"); window.history.go(-1);</script>';
                } else {
                    echo "Error creating table: " . mysqli_error($emp_connection);
                }
            }
        }
        if(isset($_POST['save_default'])){
            $parameter_ids = $_POST["parameter_id"];
            $parameter_cateogry_ids = $_POST["parameter_cateogry_id"];
            $zone_id = $_POST['zone_id'];
            $minimum_values = $_POST['minimum_value'];
            $maximum_values = $_POST['maximum_value'];
            $select_sql = "SELECT * FROM new_emp_default WHERE zone_id = $zone_id";
            $result_select = mysqli_query($emp_connection,$select_sql);
            $numRows = mysqli_num_rows($result_select);
            if($numRows < 1){
                for ($i = 0; $i < count($parameter_ids); $i++) {
                    // Get values from the arrays
                    $parameter_id = $parameter_ids[$i];
                    $parameter_cateogry_id = $parameter_cateogry_ids[$i];
                    $minimum_value = $minimum_values[$i];
                    $maximum_value = $maximum_values[$i];
                    // Construct the SQL query
                    $sql = "INSERT INTO new_emp_default (zone_id, parameter_id,parameter_cateogry_id,minimum_value,maximum_value) VALUES ('$zone_id', '$parameter_id', '$parameter_cateogry_id','$minimum_value','$maximum_value')";
                    $results = mysqli_query($emp_connection, $sql);
                    header('Location: ' . $_SERVER["HTTP_REFERER"] );
                    
                 }
            }
            else{
                for ($i = 0; $i < count($parameter_ids); $i++) {
                    // Get values from the arrays
                    $parameter_id = $parameter_ids[$i];
                    $parameter_cateogry_id = $parameter_cateogry_ids[$i];
                    $minimum_value = $minimum_values[$i];
                    $maximum_value = $maximum_values[$i];
                
                    // Construct the SQL query to update existing records
                    $sql = "UPDATE new_emp_default SET
                                parameter_cateogry_id = '$parameter_cateogry_id',
                                minimum_value = '$minimum_value',
                                maximum_value = '$maximum_value'
                            WHERE
                                zone_id = '$zone_id' AND parameter_id = '$parameter_id'";
                
                    $results = mysqli_query($emp_connection, $sql);
                }
                
            }
            
        }
    	if( isset($_POST['btnUpdate_LA']) ) {
    		$id = $_POST['id'];	 
    		$area_name = addslashes($_POST['area_name']);
    		$sql = mysqli_query( $pmp_connection,"UPDATE area_list set area_name = '".$area_name."' WHERE id = $id" );
    		
    		$selectData = mysqli_query( $pmp_connection,"SELECT * FROM area_list WHERE id = $id " );
            while($rowData = mysqli_fetch_array($selectData)) {
                $la_id = $rowData['id'];
                $la_area_name = $rowData['area_name'];
            }
    		$output = array(
    			'ID' => $la_id,
    			'data' => stripcslashes($la_area_name)
    		);
    		echo json_encode($output);
    	}
    	if(isset($_POST['action'])) {
    	    if($_POST['action'] == "get_report"){

    	        echo '
                    <table>
                        <thead>
                            <tr>';
                    $unique_dates = array(); // Array to store unique dates
                    $attendance_data = array(); // Array to store attendance data
                    $unique_parameters = array(); // Associative array to store unique parameters based on parameter_id
                    
                    $report_sql = "SELECT DISTINCT sampled_date FROM `new_emp_records` WHERE `equip_id` = {$_POST['equipment_id']}";
                    $report_result = mysqli_query($emp_connection, $report_sql);
                    
                    foreach ($report_result as $report_row) {
                        $unique_dates[] = $report_row['sampled_date'];
                    }
                    
                    // Get unique parameter data
                    $report_sql = "SELECT DISTINCT new_emp_records.parameter_id,new_emp_parameters.id, new_emp_parameters.parameter_name 
                                   FROM `new_emp_records` 
                                   INNER JOIN new_emp_parameters ON new_emp_parameters.id = new_emp_records.parameter_id  
                                   WHERE `new_emp_records`.`equip_id` = 110";
                    $report_result = mysqli_query($emp_connection, $report_sql);
                    
                    foreach ($report_result as $report_row) {
                        $parameter_id = $report_row['parameter_id'];
                    
                        // Only add the parameter if it doesn't already exist in the associative array
                        if (!isset($unique_parameters[$parameter_id])) {
                            $unique_parameters[$parameter_id] = array(
                                'parameter_id' => $parameter_id,
                                'parameter_name' => $report_row['parameter_name'],
                            );
                        }
                    }
                    
                    // Populate attendance data
                    foreach ($unique_dates as $date) {
                        foreach ($unique_parameters as $param) {
                            $parameter_id = $param['parameter_id'];
                            $parameter_name = $param['parameter_name'];
                    
                            $attendance_sql = "SELECT result, test_status FROM `new_emp_records` WHERE `equip_id` = 110 AND `sampled_date` = '$date' AND `parameter_id` = '$parameter_id'";
                            $attendance_result = mysqli_query($emp_connection, $attendance_sql);
                    
                            $results = array();
                            $test_results = array();
                    
                            foreach ($attendance_result as $attendance_row) {
                                $results[] = $attendance_row['result'];
                                $test_results[] = $attendance_row['test_status'];
                            }
                    
                            $attendance_data[$date][$parameter_id] = array(
                                'result' => implode(', ', $results),
                                'test_status' => implode(', ', $test_results),
                            );
                        }
                    }
                    
                    echo '<th>Parameter Name</th>';
                    foreach ($unique_dates as $date) {
                        echo '<th>' . $date . '</th>';
                    }
                    
                    echo '
                            </tr>
                        </thead>
                        <tbody>';
                    foreach ($unique_parameters as $param) {
                        echo '
                            <tr>
                                <td>' . $param['parameter_name'] . '</td>';
                        foreach ($unique_dates as $date) {
                            $attendance_value = isset($attendance_data[$date][$param['parameter_id']]['result']) ? $attendance_data[$date][$param['parameter_id']]['result'] : '';
                            $test_status = isset($attendance_data[$date][$param['parameter_id']]['test_status']) ? $attendance_data[$date][$param['parameter_id']]['test_status'] : '';
                    
                            $color = ($test_status == 'Passed') ? 'green' : 'red';
                    
                            echo '<td style="color:' . $color . ';font-weight:500">' . $attendance_value . '</td>';
                        }
                        echo '
                            </tr>';
                    }
                    
                    echo '
                        </tbody>
                    </table>';
    	    }
    	    if($_POST['action'] == "update_area_name"){
    	        $enterprise_id = $_POST['enterprise_id'];
    	        
    	        $sql = "SELECT area_name,id FROM area_list WHERE id = {$_POST['area_id']}";
    	        $sql_result = mysqli_query($pmp_connection,$sql);
    	        $result_assoc = mysqli_fetch_assoc($sql_result);

    	        echo $update_reg = "UPDATE equipment_reg SET location = '{$_POST['area_name']}' WHERE location = '{$result_assoc['area_name']}' AND enterprise_owner = {$_POST['enterprise_id']}  ";
    	        if(mysqli_query($pmp_connection,$update_reg)){
    	            $update = "UPDATE area_list SET area_name= '{$_POST['area_name']}' WHERE id = {$_POST['area_id']}  ";
    	            if(mysqli_query($pmp_connection,$update)){
    	                echo "success all";
    	            }
    	            else{
    	                echo "save fail 1";
    	            }
    	        }
    	        else{
    	            echo "save fail";
    	        }
    	       // $update = "UPDATE area_list SET area_name= '{$_POST['area_name']}' WHERE id = {$_POST['area_id']}  ";
    	       // if(mysqli_query($pmp_connection,$update)){
    	       //     $update_reg = "UPDATE equipment_reg SET location = '{$_POST['area_name']}' WHERE location = '{$_POST['area_name']}'  ";
    	       //     echo $update_reg;
    	       // }
    	       // else{
    	       //     echo "fail";
    	       // }
    	    }
    	    if($_POST['action'] == "update_emp_image"){
    	        // Handle file upload and database update
                $uploadDir = 'uploads/emp/';
                $uploadPath = $uploadDir . basename($_FILES['image']['name']);
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $response = ['success' => true, 'message' => 'Image uploaded successfully.'];
                
                    $sql = "UPDATE area_list SET image_blob = '$uploadPath' WHERE id = {$_POST['id']}"; // Change the query based on your table structure
                    if ($pmp_connection->query($sql) === TRUE) {
                        echo $imageName = basename($_FILES['image']['name']);
                        // $response = ['status' => 'success', 'imageName' => $imageName];

                    } else {
                        // $response = ['status' => 'error', 'message' => 'Error updating database'];

                    }
                } else {
                    // $response = ['success' => false, 'message' => 'No image selected.'];
                }
            
                // echo json_encode($response);
    	    }
    	    if($_POST['action'] == "update_emp_image_glp"){
    	        // Handle file upload and database update
                $uploadDir = 'uploads/emp/';
                $uploadPath = $uploadDir . basename($_FILES['image']['name']);
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $response = ['success' => true, 'message' => 'Image uploaded successfully.'];
                
                    $sql = "UPDATE area_list_glp SET image_blob = '$uploadPath' WHERE id = {$_POST['id']}"; // Change the query based on your table structure
                    if ($pmp_connection->query($sql) === TRUE) {
                        echo $imageName = basename($_FILES['image']['name']);
                        // $response = ['status' => 'success', 'imageName' => $imageName];

                    } else {
                        // $response = ['status' => 'error', 'message' => 'Error updating database'];

                    }
                } else {
                    // $response = ['success' => false, 'message' => 'No image selected.'];
                }
            
                // echo json_encode($response);
    	    }
    	    if ($_POST['action'] == "get_graphs") {
                $startDate = $_POST['startDate'];
                $equip_id = $_POST['equip_id'];
            
                $sql = "SELECT * FROM new_emp_equipment_settings INNER JOIN new_emp_parameters ON new_emp_parameters.id = new_emp_equipment_settings.parameter_id WHERE new_emp_equipment_settings.equip_id = $equip_id";
                $result = mysqli_query($emp_connection, $sql);
            
                $chartTypes = ['spline', 'line']; // An array of chart types
            
                while ($row = mysqli_fetch_assoc($result)) {
                    $parameter_id = $row['parameter_id'];
                    $chartType = $chartTypes[array_rand($chartTypes)]; // Randomly select a chart type
            
                    // Start echoing HTML and JavaScript as strings
                    echo '<div class="col-md-12" style="margin-top:20px">';
                    echo '<div id="chartContainer' . $parameter_id . '" style="height: 370px; width: 100%;"></div>';
                    echo '</div>';
            
                    echo '<script>';
                    echo 'var dataPoints' . $parameter_id . ' = [';
            
                    $chartDataQuery = "SELECT DATE_FORMAT(sampled_date, '%Y-%m-%d') AS date, SUM(result) AS total_result FROM new_emp_records WHERE parameter_id = $parameter_id AND equip_id = $equip_id AND sampled_date >= '$startDate' GROUP BY date ORDER BY date ASC";
                    $chartDataResult = mysqli_query($emp_connection, $chartDataQuery);
            
                    while ($chartDataRow = mysqli_fetch_assoc($chartDataResult)) {
                        $formattedDate = date('d-M', strtotime($chartDataRow['date'])); // Reformat the date
                        echo "{ x: new Date('" . $formattedDate . "'), y: " . $chartDataRow['total_result'] . " },";
                    }
            
                    echo '];';
            
                    echo 'var chart' . $parameter_id . ' = new CanvasJS.Chart("chartContainer' . $parameter_id . '", {';
                    echo 'animationEnabled: true,';
                    echo 'theme: "light2",';
                    echo 'title: {';
                    echo 'text: "' . $row['parameter_name'] . '"';
                    echo '},';
                    echo 'axisX: {';
                    echo 'valueFormatString: "DD-MMM",';
                    echo '},';
                    echo 'data: [{';
                    echo 'type: "' . $chartType . '",';
                    echo 'indexLabelFontSize: 16,';
                    echo 'dataPoints: dataPoints' . $parameter_id;
                    echo '}]';
                    echo '});';
                    echo 'chart' . $parameter_id . '.render();';
                    echo '</script>';
                }
            }
    	    if($_POST['action'] == "get_zones"){
    	        $zone_id = $_POST['zone_id'];
    	        $sql = "SELECT * FROM new_emp_zone_equipment WHERE zone_id = $zone_id";
                $result = mysqli_query($emp_connection, $sql);
                if($result){
                    foreach ($result as $row):
                        $equipmentIds = explode(',', $row['equipment_registered']);
                        foreach ($equipmentIds as $equipmentId):
                            // Fetch corresponding data from the equipment_parts table for each exploded value
                            $select_equipment = "SELECT * FROM equipment_parts WHERE equipment_parts_id = '$equipmentId'";
                            $equipment_result = mysqli_query($pmp_connection, $select_equipment);
                            $equipment_row = mysqli_fetch_assoc($equipment_result);
                            $chartContainerId = 'chartContainer_' . $equipmentId; // Unique ID for each chart container
                            if($equipment_row):
                            ?>
                    
                            <?php
                            echo '<div class="col-md-4">';
                            echo '<!-- BEGIN REGIONAL STATS PORTLET-->';
                            echo '<div class="portlet light ">';
                            echo '<div class="portlet-title">';
                            echo '<div class="caption">';
                            echo '<i class="icon-share font-dark hide"></i>';
                            echo '<span class="caption-subject font-dark bold uppercase">' . $equipment_row['equipment_name'] . '</span>';
                            echo '</div>';
                            echo '<div class="actions">';
                            echo '<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">';
                            echo '<i class="icon-cloud-upload"></i>';
                            echo '</a>';
                            echo '<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">';
                            echo '<i class="icon-wrench"></i>';
                            echo '</a>';
                            echo '<a class="btn btn-circle btn-icon-only btn-default" href="emp_equipment_trend.php?equip_id='.$equipmentId.'" target="_blank"> <i class="fa fa-arrows-v"></i> </a>';
                            echo '<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">';
                            echo '<i class="icon-trash"></i>';
                            echo '</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="portlet-body">';
                            echo '<div id="' . $chartContainerId . '" style="height: 370px; width: 100%;"></div>';
                            echo '</div>';
                            echo '</div>';
                            echo '<!-- END REGIONAL STATS PORTLET-->';
                            echo '</div>';
                    
                            echo '<script>';
                            echo 'var dataPoints' . $equipmentId . ' = [];';
                    
                            // Fetch data from new_emp_records
                            $records_query = "SELECT *
                                            FROM new_emp_records
                                            INNER JOIN new_emp_parameters ON new_emp_parameters.id = new_emp_records.parameter_id
                                            WHERE new_emp_records.equip_id = '$equipmentId'
                                            AND sampled_date = (
                                                SELECT MAX(sampled_date)
                                                FROM new_emp_records
                                                WHERE equip_id = '$equipmentId'
                                            )";
                    
                            $records_result = mysqli_query($emp_connection, $records_query);
                            foreach ($records_result as $record) {
                                $parameter_name = $record['parameter_name'];
                                $result = $record['result'];
                                if(!$result){
                                    $result = 0;
                                }
                                // Append data to the dataPoints array
                                echo 'dataPoints' . $equipmentId . '.push({ label: "' . $parameter_name . '", y: ' . $result . '});';
                            }
                    
                            echo 'var chart' . $equipmentId . ' = new CanvasJS.Chart("' . $chartContainerId . '", {';
                            echo 'animationEnabled: true,';
                            echo 'exportEnabled: true,';
                            echo 'theme: "light1",';
                            echo 'title: {';
                            echo 'text: "Latest Inspection Results"';
                            echo '},';
                            echo 'axisY: {';
                            echo 'includeZero: true';
                            echo '},';
                            echo 'data: [';
                            echo '{';
                            echo 'type: "column",';
                            echo 'indexLabelFontColor: "#5A5757",';
                            echo 'indexLabelPlacement: "outside",';
                            
                            echo 'dataPoints: dataPoints'.$equipmentId.'';
                            echo '}';
                            echo ']';
                            echo '});';
                            echo 'chart' . $equipmentId . '.render();';
                            echo '</script>';
                            ?>
                    
                        <?php endif; endforeach;
                    endforeach;
    	        }
    	    }
    	    
    	    if($_POST['action'] == "get_zones_bgl"){

    	        $area_name = $_POST['area_name'];
    	        $select_registered = "SELECT * FROM equipment_reg WHERE location = '{$area_name}' AND enterprise_owner = $switch_user_id AND deleted != 1";
                $result = mysqli_query($pmp_connection, $select_registered);
                if($result){
                    foreach ($result as $row):
                            $equipmentId = $row['equip_id'];
                            $chartContainerId = 'chartContainer_' . $equipmentId; // Unique ID for each chart container
                            ?>
                    
                            <?php
                            echo '<div class="col-md-4">';
                            echo '<!-- BEGIN REGIONAL STATS PORTLET-->';
                            echo '<div class="portlet light ">';
                            echo '<div class="portlet-title">';
                            echo '<div class="caption">';
                            echo '<i class="icon-share font-dark hide"></i>';
                            echo '<span class="caption-subject font-dark bold uppercase">' .$row['equipment']. '</span>';
                            echo '</div>';
                            echo '<div class="actions">';
                            echo '<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">';
                            echo '<i class="icon-cloud-upload"></i>';
                            echo '</a>';
                            echo '<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">';
                            echo '<i class="icon-wrench"></i>';
                            echo '</a>';
                            echo '<a class="btn btn-circle btn-icon-only btn-default" href="emp_equipment_trend.php?equip_id='.$equipmentId.'" target="_blank"> <i class="fa fa-arrows-v"></i> </a>';
                            echo '<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">';
                            echo '<i class="icon-trash"></i>';
                            echo '</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="portlet-body">';
                            echo '<div id="' . $chartContainerId . '" style="height: 370px; width: 100%;"></div>';
                            echo '</div>';
                            echo '</div>';
                            echo '<!-- END REGIONAL STATS PORTLET-->';
                            echo '</div>';
                    
                            echo '<script>';
                            echo 'var dataPoints' . $equipmentId . ' = [];';
                    
                            // Fetch data from new_emp_records
                           $records_query = "SELECT new_emp_records.id,parameter_id,equip_id, new_emp_parameters.parameter_name,MAX(result) AS result FROM new_emp_records INNER JOIN new_emp_parameters ON new_emp_parameters.id = new_emp_records.parameter_id WHERE equip_id = $equipmentId GROUP BY parameter_id; ";
                    
                            $records_result = mysqli_query($emp_connection, $records_query);
                            foreach ($records_result as $record) {
                                $parameter_name = $record['parameter_name'];
                                $result = $record['result'];
                                if(!$result){
                                    $result = 0;
                                }
                                // Append data to the dataPoints array
                                echo 'dataPoints' . $equipmentId . '.push({ label: "' . $parameter_name . '", y: ' . $result . '});';
                            }
                    
                            echo 'var chart' . $equipmentId . ' = new CanvasJS.Chart("' . $chartContainerId . '", {';
                            echo 'animationEnabled: true,';
                            echo 'exportEnabled: true,';
                            echo 'theme: "light1",';
                            echo 'title: {';
                            echo 'text: "Latest Inspection Results"';
                            echo '},';
                            echo 'axisY: {';
                            echo 'includeZero: true';
                            echo '},';
                            echo 'data: [';
                            echo '{';
                            echo 'type: "column",';
                            echo 'indexLabelFontColor: "#5A5757",';
                            echo 'indexLabelPlacement: "outside",';
                            
                            echo 'dataPoints: dataPoints'.$equipmentId.'';
                            echo '}';
                            echo ']';
                            echo '});';
                            echo 'chart' . $equipmentId . '.render();';
                            echo '</script>';
                            ?>
                    
                        <?php endforeach;
    	        }
    	    }
    	    if($_POST['action'] == "get_zones_glp"){

    	        $area_name = $_POST['area_name'];
    	        $select_registered = "SELECT * FROM equipment_reg_glp WHERE location = '{$area_name}' AND enterprise_owner = $switch_user_id AND deleted != 1";
                $result = mysqli_query($pmp_connection, $select_registered);
                if($result){
                    foreach ($result as $row):
                            $equipmentId = $row['equip_id'];
                            $chartContainerId = 'chartContainer_' . $equipmentId; // Unique ID for each chart container
                            ?>
                    
                            <?php
                            echo '<div class="col-md-4">';
                            echo '<!-- BEGIN REGIONAL STATS PORTLET-->';
                            echo '<div class="portlet light ">';
                            echo '<div class="portlet-title">';
                            echo '<div class="caption">';
                            echo '<i class="icon-share font-dark hide"></i>';
                            echo '<span class="caption-subject font-dark bold uppercase">' .$row['equipment']. '</span>';
                            echo '</div>';
                            echo '<div class="actions">';
                            echo '<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">';
                            echo '<i class="icon-cloud-upload"></i>';
                            echo '</a>';
                            echo '<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">';
                            echo '<i class="icon-wrench"></i>';
                            echo '</a>';
                            echo '<a class="btn btn-circle btn-icon-only btn-default" href="emp_equipment_trend.php?equip_id='.$equipmentId.'" target="_blank"> <i class="fa fa-arrows-v"></i> </a>';
                            echo '<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">';
                            echo '<i class="icon-trash"></i>';
                            echo '</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="portlet-body">';
                            echo '<div id="' . $chartContainerId . '" style="height: 370px; width: 100%;"></div>';
                            echo '</div>';
                            echo '</div>';
                            echo '<!-- END REGIONAL STATS PORTLET-->';
                            echo '</div>';
                    
                            echo '<script>';
                            echo 'var dataPoints' . $equipmentId . ' = [];';
                    
                            // Fetch data from new_emp_records
                           $records_query = "SELECT new_emp_records.id,parameter_id,equip_id, new_emp_parameters.parameter_name,MAX(result) AS result FROM new_emp_records INNER JOIN new_emp_parameters ON new_emp_parameters.id = new_emp_records.parameter_id WHERE equip_id = $equipmentId GROUP BY parameter_id; ";
                    
                            $records_result = mysqli_query($emp_connection, $records_query);
                            foreach ($records_result as $record) {
                                $parameter_name = $record['parameter_name'];
                                $result = $record['result'];
                                if(!$result){
                                    $result = 0;
                                }
                                // Append data to the dataPoints array
                                echo 'dataPoints' . $equipmentId . '.push({ label: "' . $parameter_name . '", y: ' . $result . '});';
                            }
                    
                            echo 'var chart' . $equipmentId . ' = new CanvasJS.Chart("' . $chartContainerId . '", {';
                            echo 'animationEnabled: true,';
                            echo 'exportEnabled: true,';
                            echo 'theme: "light1",';
                            echo 'title: {';
                            echo 'text: "Latest Inspection Results"';
                            echo '},';
                            echo 'axisY: {';
                            echo 'includeZero: true';
                            echo '},';
                            echo 'data: [';
                            echo '{';
                            echo 'type: "column",';
                            echo 'indexLabelFontColor: "#5A5757",';
                            echo 'indexLabelPlacement: "outside",';
                            
                            echo 'dataPoints: dataPoints'.$equipmentId.'';
                            echo '}';
                            echo ']';
                            echo '});';
                            echo 'chart' . $equipmentId . '.render();';
                            echo '</script>';
                            ?>
                    
                        <?php endforeach;
    	        }
    	    }
    	    if($_POST['action'] == "save_new_zones"){
    	        $zone_name = $_POST['zone_name'];
                $zone_location = $_POST['zone_location'];
            
                // File upload handling
                $file_name = $_FILES['file']['name'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_path = 'uploads/emp/' . $file_name; // Change 'uploads/' to your desired directory
            
                // Move the uploaded file to the desired directory
                move_uploaded_file($file_tmp, $file_path);
                
                $sql = "INSERT INTO new_emp_zones (zone_name, zone_location, zone_image) VALUES ('$zone_name', '$zone_location', '$file_path')";
        
                if (mysqli_query($emp_connection, $sql)) {
                    // Zone data and file path saved successfully
                    echo 'New zone saved successfully!';
                } else {
                    echo 'Error: ' . mysqli_error($emp_connection);
                }

    	    }
    	    if($_POST['action'] == "save_new_zones_bgl"){
    	        $zone_name = $_POST['zone_name'];
                $enterprise_owner = $_POST['enterprise_owner'];
                // File upload handling
                $file_name = $_FILES['file']['name'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_path = 'uploads/emp/' . $file_name; // Change 'uploads/' to your desired directory
            
                // Move the uploaded file to the desired directory
                move_uploaded_file($file_tmp, $file_path);
                
                $sql = "INSERT INTO area_list (area_name, image_blob,enterprise_owner) VALUES ('$zone_name', '$file_path','$enterprise_owner')";
        
                if (mysqli_query($pmp_connection, $sql)) {
                    // Zone data and file path saved successfully
                    echo 'New zone saved successfully!';
                } else {
                    echo 'Error: ' . mysqli_error($emp_connection);
                }

    	    }
    	    
    	    if($_POST['action'] == "save_new_zones_glp"){
    	        $zone_name = $_POST['zone_name'];
                $enterprise_owner = $_POST['enterprise_owner'];
                // File upload handling
                $file_name = $_FILES['file']['name'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_path = 'uploads/emp/' . $file_name; // Change 'uploads/' to your desired directory
            
                // Move the uploaded file to the desired directory
                move_uploaded_file($file_tmp, $file_path);
                
                $sql = "INSERT INTO area_list_glp (area_name, image_blob,enterprise_owner) VALUES ('$zone_name', '$file_path','$enterprise_owner')";
        
                if (mysqli_query($pmp_connection, $sql)) {
                    // Zone data and file path saved successfully
                    echo 'New zone saved successfully!';
                } else {
                    echo 'Error: ' . mysqli_error($emp_connection);
                }

    	    }
    	    
    	    if($_POST['action'] == "save_new_equipment_bgl"){
    	        $location = $_POST['location'];
                $enterprise_owner = $_POST['enterprise_owner'];
                $equipmentName = $_POST['equipmentName'];
                // File upload handling
                $file_name = $_FILES['file']['name'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_path = 'uploads/emp/' . $file_name; // Change 'uploads/' to your desired directory
            
                // Move the uploaded file to the desired directory
                move_uploaded_file($file_tmp, $file_path);
                
               $sql = "INSERT INTO equipment_reg (enterprise_owner, equipment,location,pic_name) VALUES ('$enterprise_owner', '$equipmentName','$location','$file_path')";
        
                if (mysqli_query($pmp_connection, $sql)) {
                    // Zone data and file path saved successfully
                    echo 'New zone saved successfully!';
                } else {
                    echo 'Error: ' . mysqli_error($emp_connection);
                }

    	    }
    	    
    	    if($_POST['action'] == "save_new_equipment_glp"){
    	        $location = $_POST['location'];
                $enterprise_owner = $_POST['enterprise_owner'];
                $equipmentName = $_POST['equipmentName'];
                // File upload handling
                $file_name = $_FILES['file']['name'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_path = 'uploads/emp/' . $file_name; // Change 'uploads/' to your desired directory
            
                // Move the uploaded file to the desired directory
                move_uploaded_file($file_tmp, $file_path);
                
               $sql = "INSERT INTO equipment_reg_glp (enterprise_owner, equipment,location,pic_name) VALUES ('$enterprise_owner', '$equipmentName','$location','$file_path')";
        
                if (mysqli_query($pmp_connection, $sql)) {
                    // Zone data and file path saved successfully
                    echo 'New zone saved successfully!';
                } else {
                    echo 'Error: ' . mysqli_error($emp_connection);
                }

    	    }
    	    
    	    if($_POST['action'] == "save_emp_registered"){
    	        $selectedOptions = $_POST['selectedOptions'];
    	        $zone_id = $_POST['zone_id'];
                // Sanitize and process the data
                $selectedOptions = mysqli_real_escape_string($emp_connection, $selectedOptions);
                
                // Fetch the current value from the database
                $sqlFetch = "SELECT equipment_registered FROM new_emp_zone_equipment WHERE zone_id =  {$zone_id}";
                $resultFetch = mysqli_query($emp_connection, $sqlFetch);
                
                if ($resultFetch && $row = mysqli_fetch_assoc($resultFetch)) {
                    // Concatenate the new options with the existing value, separated by a comma
                    $currentOptions = $row['equipment_registered'];
                    if (!empty($currentOptions)) {
                        $selectedOptions = $currentOptions . ',' . $selectedOptions;
                    }
                
                    // Update the database table with the updated value
                    $sqlUpdate = "UPDATE new_emp_zone_equipment SET equipment_registered = '$selectedOptions' WHERE zone_id = {$zone_id}";
                    $resultUpdate = mysqli_query($emp_connection, $sqlUpdate);
                
                    if ($resultUpdate) {
                        echo 'Options saved successfully.';
                    } else {
                        echo 'Error saving options.';
                    }
                } else {
                    $sql = "INSERT INTO new_emp_zone_equipment (zone_id,equipment_registered) VALUES ('$zone_id','$selectedOptions')";
        	        if (mysqli_query($emp_connection, $sql)) {
                        // Data was inserted successfully
                        echo "1";
                    }
                }
    	    }
    	    if($_POST['action'] == "save_micro"){
    	        $parameterName = $_POST['parameter_name'];
    	        $owner_id = $_POST['owner_id'];
    	        $sql = "INSERT INTO new_emp_parameters (parameter_name,owner_id) VALUES ('$parameterName','$owner_id')";
    	        if (mysqli_query($emp_connection, $sql)) {
                    // Data was inserted successfully
                    echo "1";
                } else {
                    // Error occurred during insertion
                    echo "Error: " . mysqli_error($emp_connection);
                }
    	    }
    	    if($_POST['action'] == "save_micro_glp"){
    	        $parameterName = $_POST['parameter_name'];
    	        $owner_id = $_POST['owner_id'];
    	        $sql = "INSERT INTO new_emp_parameters_glp (parameter_name,owner_id) VALUES ('$parameterName','$owner_id')";
    	        if (mysqli_query($emp_connection, $sql)) {
                    // Data was inserted successfully
                    echo "1";
                } else {
                    // Error occurred during insertion
                    echo "Error: " . mysqli_error($emp_connection);
                }
    	    }
    	    if($_POST['action'] == "save_uom"){
    	        $uom = $_POST['uom'];
    	        echo $sql = "INSERT INTO new_emp_uom (uom) VALUES ('$uom')";
    	        if (mysqli_query($emp_connection, $sql)) {
                    // Data was inserted successfully
                    echo "1";
                } else {
                    // Error occurred during insertion
                    echo "Error: " . mysqli_error($emp_connection);
                }
    	    }
    	    if($_POST['action'] == "save_category_value"){
    	         // Ensure that you have proper validation and sanitization for the incoming data.
                $zone_id = $_POST["zone_id"];
                $parameter_ids = $_POST["parameter_id"];
                $parameter_category_ids = $_POST["parameter_cateogry_id"];
                $default_values = $_POST["default_value"];
                
                for ($i = 0; $i < count($parameter_ids); $i++) {
                    $parameter_id = $parameter_ids[$i];
                    $parameter_category_id = $parameter_category_ids[$i];
                    $default_value = $default_values[$i];
            
                    // Insert data into your database table
                   $sql = "INSERT INTO new_emp_category_value (zone_id, parameter_id, parameter_cateogry_id, default_value) VALUES ('$zone_id', '$parameter_id', '$parameter_category_id', '$default_value')";
            
                    if (mysqli_query($emp_connection, $sql)) {
                        // Data was inserted successfully
                        echo "Data inserted successfully.";
                    } else {
                        // Error occurred during insertion
                        echo "Error: " . mysqli_error($emp_connection);
                    }
                }
    	    }
            if($_POST['action'] == "update_zone"){
                // Assuming you have a database connection
                echo $originalZoneName = $_POST["original_name"];
                echo '<br>';
                echo $newZoneName = $_POST["new_name"];
            
                // Update the zone name in the database
                $sql = "UPDATE new_emp_zones SET zone_name = '$newZoneName' WHERE zone_name = '$originalZoneName'";
                $results = mysqli_query($emp_connection, $sql);
            
                if ($results) {
                    echo "Update successful";
                } else {
                    echo "Update failed: " . mysqli_error($emp_connection);
                }
            }
            if($_POST['action'] == "save_zone"){
                $zoneName = $_POST["zone_name"];
                echo $sql = "INSERT INTO new_emp_zones (zone_name) VALUES ('$zoneName')";
                $results = mysqli_query ($emp_connection, $sql);
            }
            if ($_POST['action'] == "save_area") {
                $area_name = mysqli_real_escape_string($emp_connection, $_POST['area_name']);
                $common_options = $_POST['common_options'];
                $zone_id = $_POST['zone_id'];
                $category = 0;
                $filtered_results = 0;
            
                if (!empty($_POST['category'])) {
                    $category = intval($_POST['category']);
                    $filtered_results = intval($_POST['filtered_results']);
                }
            
                // Handle file upload
                $uploadDirectory = 'uploads/pmp/'; // Change this to your desired directory
                $fileName = '';
            
                if (isset($_FILES['file_attachment']) && $_FILES['file_attachment']['error'] === UPLOAD_ERR_OK) {
                    $uploadedFile = $_FILES['file_attachment'];
                    
                    $targetPath = $uploadDirectory . basename($uploadedFile['name']);
                    if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
                        // File moved successfully
                        $fileName = $uploadedFile['name']; // Get the original file name
                    } else {
                        echo "Error moving file.";
                        exit; // Exit the script if file upload fails
                    }
                }
            
                echo $sql = "INSERT INTO new_emp_area (area_name, equipment_id, equipment_parts_id, file, frequency, zone_id) VALUES ('$area_name', '$category', '$filtered_results', '$fileName', '$common_options','$zone_id')";
            
                if (mysqli_query($emp_connection, $sql)) {
                    echo "Data inserted successfully.";
                } else {
                    echo "Error inserting data: " . mysqli_error($emp_connection);
                }
            }
            
            
            if($_POST['action'] == "save_new_parameter"){
                $categoryName = mysqli_real_escape_string($emp_connection, $_POST['category_name']);
        
                // Insert the new category into the database
                $insertQuery = "INSERT INTO parameter_categories (category_name) VALUES ('$categoryName')";
                if (mysqli_query($emp_connection, $insertQuery)) {
                    $response = [
                        'success' => true,
                        'message' => 'Category added successfully',
                        'category_id' => mysqli_insert_id($emp_connection)
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Error adding category: ' . mysqli_error($emp_connection)
                    ];
                }
                echo json_encode($response);
            }
            if ($_POST['action'] == "save_parameter") {
                $category_id = $_POST['category_id'];
                $parameter_value = mysqli_real_escape_string($emp_connection, $_POST['parameter_value']);
            
                // Perform the database insert
                $sql = "INSERT INTO parameters (standard_PK_id, Parameter) VALUES ('$category_id', '$parameter_value')";
                
                if (mysqli_query($emp_connection, $sql)) {
                    echo "Data inserted successfully.";
                } else {
                    echo "Error inserting data: " . mysqli_error($emp_connection);
                }
            }
            if($_POST['action'] == "delete_parameter"){
                // SQL to delete a record based on ID
                $sql = "DELETE FROM new_emp_parameters WHERE id = {$_POST['parameter_id']}";
                
                if ($emp_connection->query($sql) === TRUE) {
                    echo "Record deleted successfully";
                } else {
                    echo "Error deleting record: " . $emp_connection->error;
                }
            }
            if($_POST['action'] == "delete_parameter_glp"){
                // SQL to delete a record based on ID
                $sql = "DELETE FROM new_emp_parameters_glp WHERE id = {$_POST['parameter_id']}";
                
                if ($emp_connection->query($sql) === TRUE) {
                    echo "Record deleted successfully";
                } else {
                    echo "Error deleting record: " . $emp_connection->error;
                }
            }
        }
        if(isset($_FILES['file']['name'])){

            /* Getting file name */
            $filename = $_FILES['file']['name'];
            $page = $_POST['action_data'];
            $user_id = $_POST['user_id'];
            $file_title = $_POST['file_title'];
            $privacy = $_POST['privacy'];
            /* Location */
            $location = "uploads/pages_demo/".$filename;
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);

            /* Valid extensions */
            $valid_extensions = array("mp4","webm","AVI");

            $response = 0;
            /* Check file extension */
            if(in_array(strtolower($imageFileType), $valid_extensions)) {
                /* Upload file */
                if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                    $sql = "INSERT INTO tbl_pages_demo_video (file_name,page,user_id,file_title,privacy) VALUES ('$filename','$page','$user_id','$file_title','$privacy')";
                    if (mysqli_query($conn, $sql)){
                        $response = 1;
                    }
                }
            }
            echo $response;
            exit;
        }
        if(isset($_POST['post_action'])){
            /* Getting file name */
            $filename = $_FILES['file']['name'];
            $page = $_POST['action_data'];
            $user_id = $_POST['user_id'];
            $file_title = $_POST['file_title'];
            $privacy = $_POST['privacy'];
            /* Location */
            $location = "uploads/pages_demo/".$filename;
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);

            /* Valid extensions */
            $valid_extensions = array("mp4","webm","AVI");

            $response = 0;
            /* Check file extension */
            if(in_array(strtolower($imageFileType), $valid_extensions)) {
                /* Upload file */
                if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                    $sql = "INSERT INTO tbl_pages_demo_video (file_name,page,user_id,file_title,privacy) VALUES ('$filename','$page','$user_id','$file_title','$privacy')";
                    if (mysqli_query($conn, $sql)){
                        $response = 1;
                    }
                }
            }
            echo $response;
            exit;
        }
        
        
        //Preventive Maintenance Control Start

        if(isset($_POST['submit_equipments'])){
            $filename=addslashes($_FILES['equipment_image']['name']);
            $equipment=mysqli_real_escape_string($pmp_connection,$_POST['equipment']);
            $serial=mysqli_real_escape_string($pmp_connection,$_POST['serial']);
            $equipmentid=mysqli_real_escape_string($pmp_connection,$_POST['equipmentid']);
            $location=mysqli_real_escape_string($pmp_connection,$_POST['location']);
            $processowner=mysqli_real_escape_string($pmp_connection,$_POST['processowner']);
            $freq=mysqli_real_escape_string($pmp_connection,$_POST['freq']);
            $supplier=mysqli_real_escape_string($pmp_connection,$_POST['supplier']);
            $status=mysqli_real_escape_string($pmp_connection,$_POST['status']);
            $enterprise_owner=mysqli_real_escape_string($pmp_connection,$_POST['enterprise_owner']);
            
            
               
            $filename=$_FILES['equipment_image']['name'];
            if (!empty($filename)) {
                $size=$_FILES['equipment_image']['size'];
                $type=$_FILES['equipment_image']['type'];
                $temp1=$_FILES['equipment_image']['tmp_name'];
                move_uploaded_file($temp1,"uploads/pmp/$filename");
            }
            
            $equipment_file=$_FILES['manual_file']['name'];
            $size=$_FILES['manual_file']['size'];
            $type=$_FILES['manual_file']['type'];
            $temp2=$_FILES['manual_file']['tmp_name'];
            
            // move_uploaded_file($temp1,"uploads/$filename");
            // $allowed = array("image/jpeg", "image/gif", "image/png");
            
            foreach (array_combine($temp2, $equipment_file) as $temp2 => $equipment_file){
                move_uploaded_file($temp2,"uploads/pmp/$equipment_file");
            }
            $query="INSERT INTO `equipment_reg` (`enterprise_owner`,`equipment`, `serial_no`, `equip_id_no`, `location`,  `process_owner`, `freq_maintain`, `supplier`, `status`, `pic_name`) 
            VALUES ('$enterprise_owner','$equipment', '$serial', '$equipmentid', '$location','$processowner', '$freq', '$supplier', '$status', '$filename')";
            //add data to equipment table
            $add=mysqli_query($pmp_connection,$query);
            if($add){
                $last_id = $pmp_connection->insert_id;
                $manual_name=$_POST['manual_name'];
                $manual_file=$_FILES['manual_file']['name'];
                foreach (array_combine($manual_name, $manual_file) as $manual_name => $manual_file){
                    $query="INSERT INTO `files` (`file_type_id`, `PK_id`,`file_file`,`file_name`) VALUES ('1','$last_id', '$manual_file','$manual_name')";
                    if ($pmp_connection->query($query) === TRUE) {
                        
                    }
                    else{
                        echo "Somethings wrong while saving";
                    }
                }
                echo '<script>history.go(-1);</script>';
                exit();
                //echo $query;
            }
        }
        
        if(isset($_POST['submit_equipments_glp'])){
            $filename=addslashes($_FILES['equipment_image']['name']);
            $equipment=mysqli_real_escape_string($pmp_connection,$_POST['equipment']);
            $serial=mysqli_real_escape_string($pmp_connection,$_POST['serial']);
            $equipmentid=mysqli_real_escape_string($pmp_connection,$_POST['equipmentid']);
            $location=mysqli_real_escape_string($pmp_connection,$_POST['location']);
            $processowner=mysqli_real_escape_string($pmp_connection,$_POST['processowner']);
            $freq=mysqli_real_escape_string($pmp_connection,$_POST['freq']);
            $supplier=mysqli_real_escape_string($pmp_connection,$_POST['supplier']);
            $status=mysqli_real_escape_string($pmp_connection,$_POST['status']);
            $enterprise_owner=mysqli_real_escape_string($pmp_connection,$_POST['enterprise_owner']);
            
            $uploadDirectory = "uploads/pmp/";
            // Function to move uploaded files to the destination directory with unique file names
            function moveUploadedFile($fileName, $uploadDirectory)
            {
                $originalFileName = basename($_FILES[$fileName]['name']);
                $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
                
                // Generate a unique filename
                $uniqueFileName = uniqid() . "_" . time() . "." . $fileExtension;
            
                $targetPath = $uploadDirectory . $uniqueFileName;
                move_uploaded_file($_FILES[$fileName]['tmp_name'], $targetPath);
            
                return $targetPath;
            }
            
            $certificatePath = moveUploadedFile('equipment_certificate', $uploadDirectory);
            $procedurePath = moveUploadedFile('procedure', $uploadDirectory);
            $manualPath = moveUploadedFile('equipment_manual', $uploadDirectory);

            $filename=$_FILES['equipment_image']['name'];
            if (!empty($filename)) {
                $size=$_FILES['equipment_image']['size'];
                $type=$_FILES['equipment_image']['type'];
                $temp1=$_FILES['equipment_image']['tmp_name'];
                move_uploaded_file($temp1,"uploads/pmp/$filename");
            }
            
            $equipment_file=$_FILES['manual_file']['name'];
            $size=$_FILES['manual_file']['size'];
            $type=$_FILES['manual_file']['type'];
            $temp2=$_FILES['manual_file']['tmp_name'];
            
            // move_uploaded_file($temp1,"uploads/$filename");
            // $allowed = array("image/jpeg", "image/gif", "image/png");
            
            foreach (array_combine($temp2, $equipment_file) as $temp2 => $equipment_file){
                move_uploaded_file($temp2,"uploads/pmp/$equipment_file");
            }
            
            
            $query="INSERT INTO `equipment_reg_glp` (`enterprise_owner`,`equipment`, `serial_no`, `equip_id_no`, `location`,  `process_owner`, `freq_maintain`, `supplier`, `status`, `pic_name`, `equipment_procedure`, `equipment_certificate`, `equipment_manual`) 
            VALUES ('$enterprise_owner','$equipment', '$serial', '$equipmentid', '$location','$processowner', '$freq', '$supplier', '$status', '$filename','$procedurePath','$certificatePath','$manualPath')";
            //add data to equipment table
            $add=mysqli_query($pmp_connection,$query);
            if($add){
                $last_id = $pmp_connection->insert_id;
                $manual_name=$_POST['manual_name'];
                $manual_file=$_FILES['manual_file']['name'];
                foreach (array_combine($manual_name, $manual_file) as $manual_name => $manual_file){
                    $query="INSERT INTO `files_glp` (`file_type_id`, `PK_id`,`file_file`,`file_name`) VALUES ('1','$last_id', '$manual_file','$manual_name')";
                    if ($pmp_connection->query($query) === TRUE) {
                        
                    }
                    else{
                        echo "Somethings wrong while saving";
                    }
                }
                echo '1';
                exit();
                //echo $query;
            }
        }


        if(isset($_POST['save_equipment_parts'])){

            $equipment_parts_name = $_POST['equipment_parts_name'];
            $parts_supplier = $_POST['parts_supplier'];
            $parts_serail = $_POST['parts_serail'];
            $parts_id_no = $_POST['parts_id_no'];
            $enterprise_owner = $_POST['enterprise_owner'];
            
            $equipment_file=$_FILES['equipment_file']['name'];
            $size=$_FILES['equipment_file']['size'];
            $type=$_FILES['equipment_file']['type'];
            $temp1=$_FILES['equipment_file']['tmp_name'];
            move_uploaded_file($temp1,"uploads/pmp/$equipment_file");
            
            $parts_file=$_FILES['manual_file']['name'];
            $size1=$_FILES['manual_file']['size'];
            $type2=$_FILES['manual_file']['type'];
            $temp2=$_FILES['manual_file']['tmp_name'];
            
            foreach (array_combine($temp2, $parts_file) as $temp2 => $parts_file){
              move_uploaded_file($temp2,"uploads/pmp/$parts_file");
            }
            $query="INSERT INTO `equipment_parts` (`enterprise_owner`,`equipment_file`,`equipment_name`,`parts_supplier`,`parts_serail`,`parts_id_no`) 
            VALUES ('$enterprise_owner','$equipment_file','$equipment_parts_name','$parts_supplier','$parts_serail','$parts_id_no')";
            if ($pmp_connection->query($query) === TRUE) {
                $last_id = $pmp_connection->insert_id; 
                $equipment_name = $_POST['equipment_name'];
                $checklist = $_POST['checklist'];
                $manual_name=$_POST['manual_name'];
                $manual_file=$_FILES['manual_file']['name'];
                foreach($checklist as $row){
                   $insert="INSERT INTO `parts_checklist` (`PK_id`,`checklist`) VALUES ('$last_id','$row')";
                    if ($pmp_connection->query($insert) === TRUE) {
        
                    }
                }
                $insert1="INSERT INTO `equipment_parts_owned` (`equipment_parts_owned_name`,`parts_PK_id`,`parts_flag_status`) VALUES ('$equipment_name','$last_id','OK')";
                mysqli_query($pmp_connection,$insert1);
                
                foreach (array_combine($manual_name, $manual_file) as $manual_name => $manual_file){
                    $query="INSERT INTO `files` (`file_type_id`, `PK_id`,`file_file`,`file_name`) VALUES ('2','$last_id', '$manual_file','$manual_name')";
                    if ($pmp_connection->query($query) === TRUE) {
                        
                    }
                    else{
                        echo "Somethings wrong while saving";
                    }
                }
                
                exit;
            }
            else{
                echo "Somethings wrong while saving";
            }
        }
        
        if(isset($_POST['save_equipment_parts_glp'])){

            $equipment_parts_name = $_POST['equipment_parts_name'];
            $parts_supplier = $_POST['parts_supplier'];
            $parts_serail = $_POST['parts_serail'];
            $parts_id_no = $_POST['parts_id_no'];
            $enterprise_owner = $_POST['enterprise_owner'];
            
            $equipment_file=$_FILES['equipment_file']['name'];
            $size=$_FILES['equipment_file']['size'];
            $type=$_FILES['equipment_file']['type'];
            $temp1=$_FILES['equipment_file']['tmp_name'];
            move_uploaded_file($temp1,"uploads/pmp/$equipment_file");
            
            $parts_file=$_FILES['manual_file']['name'];
            $size1=$_FILES['manual_file']['size'];
            $type2=$_FILES['manual_file']['type'];
            $temp2=$_FILES['manual_file']['tmp_name'];
            
            foreach (array_combine($temp2, $parts_file) as $temp2 => $parts_file){
              move_uploaded_file($temp2,"uploads/pmp/$parts_file");
            }
            $query="INSERT INTO `equipment_parts_glp` (`enterprise_owner`,`equipment_file`,`equipment_name`,`parts_supplier`,`parts_serail`,`parts_id_no`) 
            VALUES ('$enterprise_owner','$equipment_file','$equipment_parts_name','$parts_supplier','$parts_serail','$parts_id_no')";
            if ($pmp_connection->query($query) === TRUE) {
                $last_id = $pmp_connection->insert_id; 
                $equipment_name = $_POST['equipment_name'];
                $checklist = $_POST['checklist'];
                $manual_name=$_POST['manual_name'];
                $manual_file=$_FILES['manual_file']['name'];
                foreach($checklist as $row){
                   $insert="INSERT INTO `parts_checklist_glp` (`PK_id`,`checklist`) VALUES ('$last_id','$row')";
                    if ($pmp_connection->query($insert) === TRUE) {
        
                    }
                }
                
               $insert1="INSERT INTO `equipment_parts_owned_glp` (`equipment_parts_owned_name`,`parts_PK_id`,`parts_flag_status`) VALUES ('$equipment_name','$last_id','OK')";
                mysqli_query($pmp_connection,$insert1);
                
               
                foreach (array_combine($manual_name, $manual_file) as $manual_name => $manual_file){
                    $query="INSERT INTO `files_glp` (`file_type_id`, `PK_id`,`file_file`,`file_name`) VALUES ('2','$last_id', '$manual_file','$manual_name')";
                    if ($pmp_connection->query($query) === TRUE) {
                        
                    }
                    else{
                        echo "Somethings wrong while saving";
                    }
                }
                
                echo '1';
                header('Location: ' . $_SERVER["HTTP_REFERER"] );
                exit;
            }
            else{
                echo "Somethings wrong while saving";
            }
        }
    
        if(isset($_POST['save_maintainance'])){
            $equipment_PK_id = $_POST['equipment_PK_id'];
            $equipment_parts_PK_id = $_POST['equipment_parts_PK_id'];
            $last_date_performed = $_POST['last_date_performed'];
            $job_no = $_POST['job_no'];
            $type_of_activity = $_POST['type_of_activity'];
            $description = $_POST['description'];
            $next_maintainance = $_POST['next_maintainance'];
            $frequency = $_POST['frequency'];
            $remarks = $_POST['remarks'];
            
            $assignee = 0;
            if ($_POST['assigneeSelect'] == 'customOption') {
                if (!empty($_POST['assigneeText'])) {
                    $assignee = $_POST['assigneeText'];
                }
            } else {
                $assignee = $_POST['assigneeSelect'];
            }
           
            $query="INSERT INTO `parts_maintainance` ( `parts_status`,`remarks`,`equipment_PK_id`, `equipment_parts_PK_id`,`last_date_performed`,`job_no`,`assignee`,`type_of_activity`,`description`,`next_maintainance`,`frequency`) VALUES
            ('OK','$remarks','$equipment_PK_id', '$equipment_parts_PK_id','$last_date_performed','$job_no','$assignee','$type_of_activity','$description','$next_maintainance','$frequency')";
            if ($pmp_connection->query($query) === TRUE) {
                $last_id = $pmp_connection->insert_id; 
                $equipment_PK_id = $_POST['equipment_PK_id'];
                $last_date_performed = $_POST['last_date_performed'];
                $parts_checkedlist = $_POST['parts_checkedlist'];
                $remarks = $_POST['remarks'];
               
                $insert="INSERT INTO `parts_maintenance_history` (`PK_id`,`parts_remarks`, `part_status`, `date_performed`, `history_equipment_name`) VALUES ('$last_id','$remarks','OK','$last_date_performed','$equipment_PK_id')";
                if ($pmp_connection->query($insert) === TRUE) {
                    $last_inserted_id = $pmp_connection->insert_id;
                    foreach($parts_checkedlist as $row) {
                        $insert="INSERT INTO `parts_checked_list` (`PK_id`,`checklist_PK_id` , `checklist_equipment_name`,`date_performed`) VALUES ('$last_inserted_id','$row','$equipment_PK_id','$last_date_performed')";
                        if ($pmp_connection->query($insert) === TRUE) {
            
                        } 
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
             
            }
            else{
                echo "Somethings wrong while saving";
            }
        }
        if(isset($_POST['save_maintainance_glp'])){
            $equipment_PK_id = $_POST['equipment_PK_id'];
            $equipment_parts_PK_id = $_POST['equipment_parts_PK_id'];
            $last_date_performed = $_POST['last_date_performed'];
            $job_no = $_POST['job_no'];
            $type_of_activity = $_POST['type_of_activity'];
            $description = $_POST['description'];
            $next_maintainance = $_POST['next_maintainance'];
            $frequency = $_POST['frequency'];
            $remarks = $_POST['remarks'];
            
            $assignee = 0;
            if ($_POST['assigneeSelect'] == 'customOption') {
                if (!empty($_POST['assigneeText'])) {
                    $assignee = $_POST['assigneeText'];
                }
            } else {
                $assignee = $_POST['assigneeSelect'];
            }
           
            $query="INSERT INTO `parts_maintainance_glp` ( `parts_status`,`remarks`,`equipment_PK_id`, `equipment_parts_PK_id`,`last_date_performed`,`job_no`,`assignee`,`type_of_activity`,`description`,`next_maintainance`,`frequency`) VALUES
            ('OK','$remarks','$equipment_PK_id', '$equipment_parts_PK_id','$last_date_performed','$job_no','$assignee','$type_of_activity','$description','$next_maintainance','$frequency')";
            if ($pmp_connection->query($query) === TRUE) {
                $last_id = $pmp_connection->insert_id; 
                $equipment_PK_id = $_POST['equipment_PK_id'];
                $last_date_performed = $_POST['last_date_performed'];
                $parts_checkedlist = $_POST['parts_checkedlist'];
                $remarks = $_POST['remarks'];
               
                $insert="INSERT INTO `parts_maintenance_history_glp` (`PK_id`,`parts_remarks`, `part_status`, `date_performed`, `history_equipment_name`) VALUES ('$last_id','$remarks','OK','$last_date_performed','$equipment_PK_id')";
                if ($pmp_connection->query($insert) === TRUE) {
                    $last_inserted_id = $pmp_connection->insert_id;
                    foreach($parts_checkedlist as $row) {
                        $insert="INSERT INTO `parts_checked_list_glp` (`PK_id`,`checklist_PK_id` , `checklist_equipment_name`,`date_performed`) VALUES ('$last_inserted_id','$row','$equipment_PK_id','$last_date_performed')";
                        if ($pmp_connection->query($insert) === TRUE) {
            
                        } 
                        echo "1";
                        exit;
                    }
                }
             
            }
            else{
                echo "Somethings wrong while saving";
            }
        }
    
        if(isset($_POST['save_new_maintenance'])){
            $PK_id = $_POST['PK_id'];
            $history_equipment_name = $_POST['history_equipment_name'];
            $date_performed = $_POST['date_performed'];
            $parts_status = $_POST['parts_status'];
            $equipment_parts_PK_id = $_POST['equipment_parts_PK_id'];
            $parts_remarks = $_POST['parts_remarks'];
            
            $assignee = 0;
            if ($_POST['assigneeSelect'] == 'customOption') {
                if (!empty($_POST['assigneeText'])) {
                    $assignee = $_POST['assigneeText'];
                }
            } else {
                $assignee = $_POST['assigneeSelect'];
            }
            
            
            $query="INSERT INTO `parts_maintenance_history` (equipment_parts_PK_id,`PK_id`,`history_equipment_name`,`date_performed`,`part_status`,`parts_remarks`) VALUES ('$equipment_parts_PK_id','$PK_id','$history_equipment_name','$date_performed','$parts_status','$parts_remarks')";
            if ($pmp_connection->query($query) === TRUE) {
                $last_id = $pmp_connection->insert_id; 
                $parts_checkedlist = $_POST['parts_checkedlist'];
                $history_equipment_name = $_POST['history_equipment_name'];
                $date_performed = $_POST['date_performed'];
                foreach($parts_checkedlist as $row){
                    $insert_query="INSERT INTO `parts_checked_list` (`PK_id`,`checklist_PK_id`,`checklist_equipment_name`,`date_performed`) VALUES ('$last_id','$row','$history_equipment_name','$date_performed')";
                    if ($pmp_connection->query($insert_query) === TRUE) {
                            
                    } 
                }
                $PK_id = $_POST['PK_id'];
                $parts_status = $_POST['parts_status'];
                $parts_remarks = $_POST['parts_remarks'];
                $equip_id = $_POST['equip_id'];
                $parts_owned_id = 26; //$_POST['parts_owned_id'];
                $equipment_parts_PK_id = $_POST['equipment_parts_PK_id'];
                
                mysqli_query( $pmp_connection,"UPDATE parts_maintainance SET assignee = '$assignee', remarks = '$parts_remarks', parts_status = '$parts_status' WHERE parts_id= '$PK_id'" );
                mysqli_query( $pmp_connection,"UPDATE equipment_parts_owned SET parts_flag_status = '$parts_status' WHERE id= '$parts_owned_id'" );
                
                $query = "SELECT * FROM parts_maintainance WHERE parts_id = '$PK_id' ";
                $query_result = mysqli_query ($pmp_connection, $query);
                $rows = mysqli_fetch_assoc($query_result);
                $frequency = $rows['frequency'];
                
                if($frequency == "Daily"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 1 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                        echo mysqli_error($pmp_connection);
                    if (mysqli_query($pmp_connection, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    } else {
                    }
                }
                
                if($frequency == "Weekly"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 7 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($pmp_connection, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
                
                if($frequency == "Monthly"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 30 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($pmp_connection, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
                
                if($frequency == "Semi-Annual"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 186 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($pmp_connection, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
                
                if($frequency == "Annual"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 365 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($pmp_connection, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
                if($frequency == "Quarterly"){
                    $new_date = date('Y-m-d', strtotime($date_performed. ' + 91 days'));
                    $sql = "UPDATE parts_maintainance SET last_date_performed = '$date_performed', next_maintainance = '$new_date' WHERE parts_id= '$PK_id'";
                    if (mysqli_query($pmp_connection, $sql)) {
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                        exit;
                    }
                }
            }
        }
        if(isset($_POST['update_change_parts'])){
            $parts_id = $_POST['parts_id'];
            $parts_status = $_POST['parts_status'];
            $remarks = $_POST['remarks'];
            $sql = "UPDATE parts_maintainance SET parts_status = '$parts_status',remarks = '$remarks' WHERE parts_id= '$parts_id'";
            if (mysqli_query($pmp_connection, $sql)) {
                header('Location: ' . $_SERVER["HTTP_REFERER"] );
                exit;
            }
        }
        if(isset($_POST['add_new_parts'])){
            $parts_id = $_POST['parts_id'];
            $equip_id = $_POST['equip_id'];
            $sql = "INSERT INTO `equipment_parts_owned` (`equipment_parts_owned_name`,`parts_PK_id`,`parts_flag_status`) VALUES ('$equip_id','$parts_id','OK')";
            if (mysqli_query($pmp_connection, $sql)) {
                header('Location: ' . $_SERVER["HTTP_REFERER"] );
                exit;
            }
        }
        if(isset($_POST['update_new_change_parts'])){
            $equipment_PK_id = $_POST['equipment_PK_id'];
            $equip_id_parts = $_POST['equip_id_parts'];
            $old_equipment_parts = $_POST['old_equipment_parts'];
            $remarks = $_POST['remarks'];
            $sql = "UPDATE parts_maintainance SET remarks = '$remarks', equipment_parts_PK_id = '$equip_id_parts', parts_status = 'OK' WHERE equipment_PK_id= '$equipment_PK_id' AND equipment_parts_PK_id = '$old_equipment_parts' ";
            if (mysqli_query($pmp_connection, $sql)) {
                header('Location: ' . $_SERVER["HTTP_REFERER"] );
                exit;
            }
        }
        
        if(isset($_POST['save_area'])){
            $area_name = $_POST['area_name'];
            $enterprise_owner = $_POST['enterprise_owner'];
            $sql = "INSERT INTO `area_list` (`area_name`,`enterprise_owner`) VALUES ('$area_name','$enterprise_owner')";
            if (mysqli_query($pmp_connection, $sql)) {
                header('Location: ' . $_SERVER["HTTP_REFERER"] );
                exit;
            }
        }
        if(isset($_POST['save_area_glp'])){
            $area_name = $_POST['area_name'];
            $enterprise_owner = $_POST['enterprise_owner'];
            $sql = "INSERT INTO `area_list_glp` (`area_name`,`enterprise_owner`) VALUES ('$area_name','$enterprise_owner')";
            if (mysqli_query($pmp_connection, $sql)) {
                echo '1';
                exit();
            }
        }
        if(isset($_POST['save_video'])){
            $file_title = $_POST['file_title'];
            $switch_user_id = $_POST['switch_user_id'];
            $youtube_link = $_POST['youtube_link'];
            $page = $_POST['page'];
            $sql = "INSERT INTO `tbl_pages_demo_video` (`file_title`,`user_id`,`youtube_link`,`page`) VALUES ('$file_title','$switch_user_id','$youtube_link','$page')";
            if (mysqli_query($conn, $sql)) {
                header('Location: ' . $_SERVER["HTTP_REFERER"] );
                exit;
            }
        }
        if(isset($_POST['save_e_form_video'])){
            $file_title = $_POST['file_title'];
            $switch_user_id = $_POST['switch_user_id'];
            $youtube_link = $_POST['youtube_link'];
            $form_id = $_POST['form_video'];
            $sql = "INSERT INTO `tbl_form_videos` (`video_name`,`user_id`,`video_link`,`form_id`) VALUES ('$file_title','$switch_user_id','$youtube_link','$form_id')";
            if (mysqli_query($conn, $sql)) {
                header('Location: ' . $_SERVER["HTTP_REFERER"] );
                exit;
            }
        }
        if(isset($_POST['save_pto'])){
            $payeeid = $_POST['payeeid'];
            $leave_count = $_POST['leave_count'];
            if($_POST['remaining_leave'] == 0){
                $leave_type = -5;
            }
            else{
                $leave_type = $_POST['leave_type'];
            }
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            // Create DateTime objects for start and end dates
            $start_datetime = new DateTime($start_date);
            $end_datetime = new DateTime($end_date);
            
            // Include the end date in the count
            $end_datetime->modify('+1 day');
            
            // Calculate the difference between the two dates
            $interval = $start_datetime->diff($end_datetime);
            
            // Access the days property of the interval
            $days_difference = $interval->days;


            $notes = $conn->real_escape_string($_POST['note']);
            $sql = "INSERT INTO `leave_details` (`leave_count`,`leave_id`,`start_date`,`end_date`,`notes`,`payeeid`,approve_status) VALUES ('$days_difference','$leave_type','$start_date','$end_date','$notes','$payeeid','0')";
            if (mysqli_query($conn, $sql)) {
                header('Location: ' . $_SERVER["HTTP_REFERER"] );
                exit;
            }
        }
        if(isset($_POST['update_employe'])){
            $user_for_approve = array();
            $user_id = $_POST['user_id'];
            $to_approve = $_POST['to_approve'];
            $total_leave = $_POST['total_leave'];
            $employee_lvl = $_POST['employee_lvl'];
            $contact_no = $_POST['contact_no'];
            $address = $_POST['address'];
            $personal_email = $_POST['personal_email'];
            $company_email = $_POST['company_email'];
            foreach($to_approve as $row){
                $user_for_approve[] = $row;
            }
            $user_for_approve = implode(',', $user_for_approve);
            $checker = mysqli_query($conn,"SELECT * FROM others_employee_details WHERE employee_id = '$user_id'");
            $check_result = mysqli_fetch_array($checker);
            if($check_result > 0){
                echo $update_query = "UPDATE others_employee_details SET pto_to_approved = '$user_for_approve', total_leave = '$total_leave', employee_lvl = '$employee_lvl', contact_no='$contact_no', address = '$address', personal_email = '$personal_email',company_email = '$company_email' WHERE employee_id = '$user_id'";
                if (mysqli_query($conn, $update_query)) {
                  return true;
                } else {
                  echo "Error updating record: " . mysqli_error($conn);
                }
            }
            else{
                echo $insert_query = "INSERT INTO `others_employee_details`(`employee_id`,pto_to_approved,total_leave,employee_lvl,contact_no,address,personal_email,company_email) VALUES ( '$user_id' ,'$user_for_approve','$total_leave','$employee_lvl','$contact_no','$address','$personal_email','$company_email')";
                if (mysqli_query($conn, $insert_query)) {
                  return true;
                } else {
                  echo "Error updating record: " . mysqli_error($conn);
                }
            }
        }
        
        if(isset($_POST['save_clone_form'])){
            $afl_form_name = $_POST['afl_form_name'];

            $sql = "INSERT INTO `tbl_afia_forms_list` (`afl_form_name`,`afl_form_code`,afl_status_flag) VALUES ( '$afl_form_name','gmp_pcqi_checklist','C')";
            if (mysqli_query($e_connection, $sql)) {
                $eform_id = mysqli_insert_id($e_connection);
                $check_form_owned = mysqli_query($conn,"SELECT * FROM tbl_forms_owned WHERE user_id = '163' AND enterprise_id = '163'");
                $check_result = mysqli_fetch_array($check_form_owned);
                if( mysqli_num_rows($check_form_owned) > 0 ) {
                    $array_counter = explode(",", $check_result["form_owned"]); 
                    if(!in_array($eform_id,$array_counter)){
                        array_push($array_counter,$eform_id);
                        $new_form_id =   implode(',',$array_counter);
                        $update_query = "UPDATE tbl_forms_owned SET form_owned='$new_form_id' WHERE user_id = '163' AND enterprise_id = '163'";
                        if (mysqli_query($conn, $update_query)) {
                            header('Location: ' . $_SERVER["HTTP_REFERER"] );
                            exit;
                        } else {
                          echo "Error updating record: " . mysqli_error($conn);
                        }
                    }
                }
                
            }
        }
        if(isset($_POST['submit_survey'])){
            $full_time = $_POST['full_time'];
            $part_time = $_POST['part_time'];
            $temps = $_POST['temps'];
            $states_with_pay = $_POST['states_with_pay'];
            $q1 = $_POST['q1'];
            $q2 = $_POST['q2'];
            $q3 = $_POST['q3'];
            $q4 = $_POST['q4'];
            $q5 = $_POST['q5'];
            $q6 = $_POST['q6'];
            $q7 = $_POST['q7'];
            $q8 = $_POST['q8'];
            $q9 = $_POST['q9'];
            $q10 = $_POST['q10'];
            $q11 = $_POST['q11'];
            $owner_id = $_COOKIE['user_company_id'];
            $sql = "INSERT INTO tbl_survey (full_time,part_time,temps,states_with_pay,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,owner_id) VALUES ('$full_time','$part_time','$temps','$states_with_pay','$q1','$q2','$q3','$q4','$q5','$q6','$q7','$q8','$q9','$q10','$q11','$owner_id')";
            if(mysqli_query($conn,$sql)){
                header('Location: ' . $_SERVER["HTTP_REFERER"] );
            }
        }
        if(isset($_POST['save_others'])){
            $personal_email = $_POST['personal_email'];
            $company_email = $_POST['company_email'];
            $apartment_number = isset($_POST['apartment_number']) && !empty($_POST['apartment_number']) ? $_POST['apartment_number'] . '' : 'N/A';
            $street = isset($_POST['street']) && !empty($_POST['street']) ? $_POST['street'] . '' : 'N/A';
            $barangay = isset($_POST['barangay']) && !empty($_POST['barangay']) ? $_POST['barangay'] . '' : 'N/A';
            $city = isset($_POST['city']) && !empty($_POST['city']) ? $_POST['city'] . '' : 'N/A';
            $province = isset($_POST['province']) && !empty($_POST['province']) ? $_POST['province'] . '' : 'N/A';
            $region = isset($_POST['region']) && !empty($_POST['region']) ? $_POST['region'] . '' : 'N/A';
            $postal_code = isset($_POST['postal_code']) && !empty($_POST['postal_code']) ? $_POST['postal_code'] . '' : 'N/A';
            
            $address = $apartment_number. '|'. $street .'|'. $barangay . '|' . $city . '|' . $province . '|' . $region . '|' . $postal_code;

            $contact_no = $_POST['contact_no'];
            $employee_id = $_POST['employee_id'];
            $accountname = $_POST['accountname'];
            $bankno = $_POST['bankno'];
            $accountno = $_POST['accountno'];
            $emergency_name = $_POST['emergency_name'];
            $emergency_address = $_POST['emergency_address'];
            $emergency_contact_no = $_POST['emergency_contact_no'];
            $emergency_email = $_POST['emergency_email'];
            $emergency_relation = $_POST['relationship'];
            
            // Insert data into the destination table
            $sourceTable = "others_employee_details";
            $destinationTable = "others_employee_details_old"; // Replace with the name of your destination table
            
            // Select all columns from the source table
            $sourceSql = "SELECT * FROM $sourceTable WHERE employee_id = '$employee_id'";
            $sourceResult = mysqli_query($conn, $sourceSql);
            
            if ($sourceResult) {
                // Fetch rows from the source table
                while ($row = mysqli_fetch_assoc($sourceResult)) {
                    // Insert each row into the destination table
                    $columns = implode(", ", array_keys($row));
                    $values = implode("', '", $row);
                    $insertQuery = "INSERT INTO $destinationTable ($columns) VALUES ('$values')";
                    mysqli_query($conn, $insertQuery);
                }
            } else {
                echo "Error selecting data from the source table: " . mysqli_error($conn);
            }
            
            // Update other_employee_details table
            $check_employee = mysqli_query($conn, "SELECT * FROM others_employee_details WHERE employee_id = '$employee_id'");
            $check_result = mysqli_fetch_array($check_employee);
            
            $check_employee_bank = mysqli_query($payroll_connection, "SELECT * FROM payee WHERE payeeid = '$employee_id'");
            $check_result_bank = mysqli_fetch_array($check_employee_bank);
            
            $notification_message = ""; // Initialize as an empty string
            if ($check_result_bank['accountname'] != $accountname) {
                $notification_message .= "Bank Account name,";
            }
            if ($check_result_bank['bankno'] != $bankno) {
                $notification_message .= "Bank Account,";
            }
            if ($check_result_bank['accountno'] != $accountno) {
                $notification_message .= "Bank Account Number,";
            }
            if ($check_result['personal_email'] != $personal_email) {
                $notification_message .= "Personal email,";
            }
            if ($company_email != $check_result['company_email']) {
                $notification_message .= "Company email,";
            }
            if ($address != $check_result['address']) {
                $notification_message .= "Address,";
            }
            if ($contact_no != $check_result['contact_no']) {
                $notification_message .= "Contact Number,";
            }
            if ($emergency_name != $check_result['emergency_name']) {
                $notification_message .= "Emergency contact name,";
            }
            if ($emergency_address != $check_result['emergency_address']) {
                $notification_message .= "Emergency contact Address,";
            }
            if ($emergency_contact_no != $check_result['emergency_contact_no']) {
                $notification_message .= "Emergency contact Number,";
            }
            if ($emergency_email != $check_result['emergency_email']) {
                $notification_message .= "Emergency contact Email,";
            }
            if ($emergency_relation != $check_result['emergency_relation']) {
                $notification_message .= "Emergency contact Relation,";
            }
            // Remove the trailing comma if it exists
            $notification_message = rtrim($notification_message, ',');
            
            $insert_sql = "INSERT INTO others_notification (notification_message,employee_id) VALUES ('$notification_message',$employee_id)";
            mysqli_query($conn, $insert_sql);
     
            
            $check_payee = mysqli_query($payroll_connection, "SELECT * FROM payee WHERE payeeid = '$employee_id'");
            $check_payee_result = mysqli_fetch_array($check_payee);
            if (mysqli_num_rows($check_payee) > 0) {
              $update_update_query = "UPDATE payee SET bankno = '$bankno',accountname = '$accountname',accountno = '$accountno' WHERE payeeid = '$employee_id'";
            }
            else{
                $update_update_query = "INSERT INTO `payee` (`bankno`,`accountno`,accountname,payeeid) VALUES ( '$bankno','$accountno','$accountname','$employee_id')";
            }
            if (mysqli_num_rows($check_employee) > 0) {
                $update_query = "UPDATE others_employee_details SET emergency_relation = '$emergency_relation', emergency_email = '$emergency_email', emergency_contact_no='$emergency_contact_no', emergency_address = '$emergency_address', emergency_name='$emergency_name', personal_email='$personal_email',company_email='$company_email',address='$address',contact_no='$contact_no' WHERE employee_id = '$employee_id'";
                if (mysqli_query($conn, $update_query)) {
                    // Update other_employee_details table
                    if(mysqli_query($payroll_connection,$update_update_query)){
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                    }
                }
            } else {
                $sql = "INSERT INTO `others_employee_details` (`personal_email`,`company_email`,address,contact_no,employee_id,emergency_name,emergency_address,emergency_contact_no,emergency_email,emergency_relation) VALUES ( '$personal_email','$company_email','$address','$contact_no','$employee_id','$emergency_name','$emergency_address','$emergency_contact_no','$emergency_email','$emergency_relation')";
                if (mysqli_query($conn, $sql)) {
                    if(mysqli_query($payroll_connection,$update_update_query)){
                        header('Location: ' . $_SERVER["HTTP_REFERER"] );
                    }
                }
            }
             header('Location: ' . $_SERVER["HTTP_REFERER"] );
            // Close the database connection
            mysqli_close($conn);
        }
    }
        
        if(isset($_POST['generate_pto'])) {
            // Include PHPExcel library
            require_once 'PHPExcel/PHPExcel/PHPExcel.php';
            
            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            
            // Set default properties
            $objPHPExcel->getProperties()->setCreator('Your Name')
                ->setLastModifiedBy('Your Name')
                ->setTitle('Leave Details')
                ->setSubject('Leave Details')
                ->setDescription('Leave details exported from the database')
                ->setKeywords('leave details')
                ->setCategory('Leave Details');
            
            // Add data to the Excel file
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Payee ID');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Leave Count');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Leave Type');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Start Date');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', 'End Date');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Leave ID');
            $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Approved By');
            $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Notes');
            $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Approve Status');
            
            // Fetch data from the database
            // Replace with your database connection code
            $dbHost = 'localhost';
            $dbUsername = 'brandons_interlinkiq';
            $dbPassword = 'L1873@2019new';
            $dbName = 'brandons_interlinkiq';
            
            $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "SELECT payeeid, leave_count, leave_type, start_date, end_date, leave_id, approved_by, notes, approve_status FROM leave_details";
            $result = mysqli_query($conn, $sql);
            
            $rowNumber = 2; // Start from row 2 to leave space for the header row
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowNumber, $row['payeeid']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowNumber, $row['leave_count']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowNumber, $row['leave_type']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowNumber, $row['start_date']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $rowNumber, $row['end_date']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowNumber, $row['leave_id']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowNumber, $row['approved_by']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowNumber, $row['notes']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $rowNumber, $row['approve_status']);
            
                    $rowNumber++;
                }
            }
            
            // Set column widths
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            
            // Set header row styles
            $headerStyle = $objPHPExcel->getActiveSheet()->getStyle('A1:I1');
            $headerStyle->getFont()->setBold(true);
            $headerStyle->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $headerStyle->getFill()->getStartColor()->setARGB('FFC0C0C0'); // Light Gray
            
            // Save Excel file
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $filename = 'leave_details.xlsx';
            $objWriter->save($filename);
            
            // Download the Excel file
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $objWriter->save('php://output');
            exit();
        }
        //Preventive Maintenance Control End
   
    

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($_GET['action'])){
            if($_GET['action'] == "get_uom"){
                // Fetch the data from the database
                $uom_sql = "SELECT * FROM new_emp_uom";
                $uom_result = mysqli_query($emp_connection, $uom_sql);
                
                $uom_data = array();
                
                if ($uom_result && mysqli_num_rows($uom_result) > 0) {
                    while ($row = mysqli_fetch_assoc($uom_result)) {
                        $uom_data[] = $row['uom'];
                    }
                }
                
                // Return the data as JSON
                header('Content-Type: application/json');
                echo json_encode($uom_data);
            }
            if($_GET['action'] == "get_new_parameters"){
                $sql = "SELECT * FROM parameter_categories";
                $result = mysqli_query($emp_connection, $sql);
                $data = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
                echo json_encode($data);
            }
            if($_GET['action'] == "view_equipment"){
                $equipment_id = $_GET['equipment_id'];
                $result = mysqli_query($pmp_connection,"SELECT * FROM equipment_reg WHERE equip_id = '$equipment_id' ");
                $row = mysqli_fetch_array($result);
                
                echo '
                    <div class="modal-header">
                        <h5 class="modal-title text-white" id="EquipmentDetails">Equipment Details</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline:none;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!--Code Here-->
                    <form action="controller.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="enterprise_owner" value="'.$switch_user_id.'">
                        <div id="add-modal-body" class="modal-body bg-white">
                            <div class="form-group">
                                <label>Equipment Image</label><br>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 150px; height: 150px; object-fit: contain;">';
                                    
                                        if ( empty($row['pic_name']) ) {
                                            echo '<img src="https://via.placeholder.com/150x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" style="width: 150px; height: 150px; object-fit: contain;" />';
                                        } else {
                                            echo '<img src="uploads/pmp/'. $row['pic_name'] .'" class="img-responsive" style="width: 150px; height: 150px; object-fit: contain;"/>';
                                        }
                                            
                                    echo '</div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="width: 150px; height: 150px; max-width: 150px; max-height: 150px; object-fit: contain;"> </div>
                                    <div>
                                        <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input class="form-control" type="file" name="equipment_image" />
                                        </span>
                                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="font-weight:600" for="inputEquipment">Equipment Name <span style="color:red">*</span></label>
                                <input type="hidden" name="equip_id" value="'.$equipment_id.'">
                                <input type="text" name="equipment" value="'.$row['equipment'].'" class="form-control"  >
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-weight:600" for="inputSerial">Serial # <span style="color:red">*</span></label>
                                        <input type="text" name="serial_no" value="'.$row['serial_no'].'" class="form-control"  >
                                    </div>
                                </div>
                                <div class="col-md-6 '; echo $_COOKIE['client'] == 1 ? 'hide':''; echo '">
                                    <div class="form-group">
                                        <label style="font-weight:600" for="inputEquipmentID">Equipment ID No. <span style="color:red">*</span></label>
                                        <input type="text" name="equip_id_no" value="'.$row['equip_id_no'].'" class="form-control"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-weight:600" for="inputLocation">Location <span style="color:red">*</span></label>
                                        <input type="text" name="location" value="'.$row['location'].'" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-weight:600" for="inputProcessOwner">Assign to'; echo $_COOKIE['client'] == 1 ? '':' <span style="color:red">*</span>'; echo '</label>
                                        <input type="text" name="process_owner" value="'.$row['process_owner'].'" class="form-control"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-weight:600" for="inputFrequency">Frequency of Maintenance <span style="color:red">*</span></label>
                                        <input type="text" name="freq_maintain" value="'.$row['freq_maintain'].'" class="form-control"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-weight:600" for="inputSupplier">Supplier Vendor'; echo $_COOKIE['client'] == 1 ? '':' <span style="color:red">*</span>'; echo '</label>
                                        <input type="text" name="supplier" value="'.$row['supplier'].'" class="form-control"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-weight:600" for="inputStatus">Status'; echo $_COOKIE['client'] == 1 ? '':' <span style="color:red">*</span>'; echo '</label>';
                                        echo '<select name="status" class="custom-select form-control">';
                                            echo '<option value="" selected disabled>Choose...</option>';
                                            $options = array('In Use', 'Not In Use', 'Out of Service', 'Clean', 'Soiled', 'Calibrated');
                                            foreach ($options as $option) {
                                                $selected = ($row['status'] == $option) ? 'selected' : '';
                                                echo "<option value='$option' $selected>$option</option>";
                                            }
                                            echo '</select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px">
                                <div class="col-md-4">
                                    <label style="font-weight:600">Equipment Registered Parts in Maintenance</label>
                                </div>
                                <div class="col-md-4">
                                    <label style="font-weight:600">Status</label>
                                </div>
                                <div class="col-md-4">
                                    <label style="font-weight:600">Action</label>
                                </div>
                            </div>';
                            $get= mysqli_query($pmp_connection,"SELECT * FROM parts_maintainance INNER JOIN equipment_parts ON parts_maintainance.equipment_parts_PK_id = equipment_parts.equipment_parts_id   WHERE parts_maintainance.equipment_PK_id = '$equipment_id' ");
                            while($row=mysqli_fetch_array($get)) {
                                echo '
                                <div class="row" style="margin-top:10px">
                                    <div class="col-md-4">
                                        <a href="#">'.$row['equipment_name'].'</a>
                                    </div>
                                    <div class="col-md-4">
                                        <label>'.$row['parts_status'].'</label>
                                    </div>
                                    <div class="col-md-4">';
                                        if($row['parts_status'] == "OK"){
                                            echo '<a class="btn btn-primary" disabled>Update</a>';
                                        }
                                        else{
                                            echo '<a class="btn btn-primary" data-toggle="modal" data-target="#change_parts" parts_status_value="'.$row['parts_status'].'" parts_id="'.$row['parts_id'].'" id="update_equipment_parts" >Update</a>';
                                        }
                                        
                                echo'    </div>
                                </div>
                                
                                ';
                            }
                        echo ' <div class="row" id="dynamic_field" style="margin-top:15px">
                                <div class="inputs_container" >
                                    <div class="col-md-12">
                                        <label for="inputParts">Manual File Name'; echo $_COOKIE['client'] == 1 ? '':' <span style="color:red">*</span>'; echo '</label> <br>';
                                        $get= mysqli_query($pmp_connection,"SELECT * FROM files WHERE PK_id = '$equipment_id' ");
                                        while($row=mysqli_fetch_array($get)) {
                                            echo '<a href="uploads/pmp/'. $row['file_file'] .'" target="_blank">'.$row['file_name'].'</a>';  
                                        }
                                        
                        echo'                
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer bg-white">
                            <button type="button" class="btn btn-light shadow-none" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info shadow-none" id="update_equipment" name="update_equipment">Update</button>
                        </div>
                    </form>
                ';
            }
            if($_GET['action'] == "view_equipment_glp"){
                $equipment_id = $_GET['equipment_id'];
                $result = mysqli_query($pmp_connection,"SELECT * FROM equipment_reg_glp WHERE equip_id = '$equipment_id' ");
                $row = mysqli_fetch_array($result);
                
                echo '
                    <div class="modal-header">
                        <h5 class="modal-title text-white" id="EquipmentDetails">Equipment Details</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline:none;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!--Code Here-->
                    <form action="controller.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="enterprise_owner" value="'.$switch_user_id.'">
                        <div id="add-modal-body" class="modal-body bg-white">
                            <div class="form-group">
                                <label>Equipment Image</label><br>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 150px; height: 150px; object-fit: contain;">';
                                    
                                        if ( empty($row['pic_name']) ) {
                                            echo '<img src="https://via.placeholder.com/150x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" style="width: 150px; height: 150px; object-fit: contain;" />';
                                        } else {
                                            echo '<img src="uploads/pmp/'. $row['pic_name'] .'" class="img-responsive" style="width: 150px; height: 150px; object-fit: contain;"/>';
                                        }
                                            
                                    echo '</div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="width: 150px; height: 150px; max-width: 150px; max-height: 150px; object-fit: contain;"> </div>
                                    <div>
                                        <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input class="form-control" type="file" name="equipment_image" />
                                        </span>
                                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="font-weight:600" for="inputEquipment">Equipment Name <span style="color:red">*</span></label>
                                <input type="hidden" name="equip_id" value="'.$equipment_id.'">
                                <input type="text" name="equipment" value="'.$row['equipment'].'" class="form-control"  >
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-weight:600" for="inputSerial">Serial # <span style="color:red">*</span></label>
                                        <input type="text" name="serial_no" value="'.$row['serial_no'].'" class="form-control"  >
                                    </div>
                                </div>
                                <div class="col-md-6 '; echo $_COOKIE['client'] == 1 ? 'hide':''; echo '">
                                    <div class="form-group">
                                        <label style="font-weight:600" for="inputEquipmentID">Equipment ID No. <span style="color:red">*</span></label>
                                        <input type="text" name="equip_id_no" value="'.$row['equip_id_no'].'" class="form-control"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-weight:600" for="inputLocation">Location <span style="color:red">*</span></label>
                                        <input type="text" name="location" value="'.$row['location'].'" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-weight:600" for="inputProcessOwner">Assign to'; echo $_COOKIE['client'] == 1 ? '':' <span style="color:red">*</span>'; echo '</label>
                                        <input type="text" name="process_owner" value="'.$row['process_owner'].'" class="form-control"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-weight:600" for="inputFrequency">Frequency of Maintenance <span style="color:red">*</span></label>
                                        <input type="text" name="freq_maintain" value="'.$row['freq_maintain'].'" class="form-control"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-weight:600" for="inputSupplier">Supplier Vendor'; echo $_COOKIE['client'] == 1 ? '':' <span style="color:red">*</span>'; echo '</label>
                                        <input type="text" name="supplier" value="'.$row['supplier'].'" class="form-control"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-weight:600" for="inputStatus">Status'; echo $_COOKIE['client'] == 1 ? '':' <span style="color:red">*</span>'; echo '</label>';
                                        echo '<select name="status" class="custom-select form-control">';
                                            echo '<option value="" selected disabled>Choose...</option>';
                                            $options = array('In Use', 'Not In Use', 'Out of Service', 'Clean', 'Soiled', 'Calibrated');
                                            foreach ($options as $option) {
                                                $selected = ($row['status'] == $option) ? 'selected' : '';
                                                echo "<option value='$option' $selected>$option</option>";
                                            }
                                            echo '</select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px">
                                <div class="col-md-4">
                                    <label style="font-weight:600">Equipment Registered Parts in Maintenance</label>
                                </div>
                                <div class="col-md-4">
                                    <label style="font-weight:600">Status</label>
                                </div>
                                <div class="col-md-4">
                                    <label style="font-weight:600">Action</label>
                                </div>
                            </div>';
                            $get= mysqli_query($pmp_connection,"SELECT * FROM parts_maintainance_glp INNER JOIN equipment_parts_glp ON parts_maintainance_glp.equipment_parts_PK_id = equipment_parts_glp.equipment_parts_id   WHERE parts_maintainance_glp.equipment_PK_id = '$equipment_id' ");
                            while($row=mysqli_fetch_array($get)) {
                                echo '
                                <div class="row" style="margin-top:10px">
                                    <div class="col-md-4">
                                        <a href="#">'.$row['equipment_name'].'</a>
                                    </div>
                                    <div class="col-md-4">
                                        <label>'.$row['parts_status'].'</label>
                                    </div>
                                    <div class="col-md-4">';
                                        if($row['parts_status'] == "OK"){
                                            echo '<a class="btn btn-primary" disabled>Update</a>';
                                        }
                                        else{
                                            echo '<a class="btn btn-primary" data-toggle="modal" data-target="#change_parts" parts_status_value="'.$row['parts_status'].'" parts_id="'.$row['parts_id'].'" id="update_equipment_parts" >Update</a>';
                                        }
                                        
                                echo'    </div>
                                </div>
                                
                                ';
                            }
                        echo ' <div class="row" id="dynamic_field" style="margin-top:15px">
                                <div class="inputs_container" >
                                    <div class="col-md-12">
                                        <label for="inputParts">Manual File Name'; echo $_COOKIE['client'] == 1 ? '':' <span style="color:red">*</span>'; echo '</label> <br>';
                                        $get= mysqli_query($pmp_connection,"SELECT * FROM files_glp WHERE PK_id = '$equipment_id' ");
                                        while($row=mysqli_fetch_array($get)) {
                                            echo '<a href="uploads/pmp/'. $row['file_file'] .'" target="_blank">'.$row['file_name'].'</a>';  
                                        }
                                        
                        echo'                
                                    </div>
                                </div>';
                                $equipment_id = $_GET['equipment_id'];
                                $result = mysqli_query($pmp_connection,"SELECT * FROM equipment_reg_glp WHERE equip_id = '$equipment_id' ");
                                $rows = mysqli_fetch_array($result);
                                echo'<div class="row">
                                    <div class="col-md-12"><hr></div>
                                    <div class="col-md-6">
                                        <label>Equipment Certificate: </label><br>';
                                         echo '<a href="'. $rows['equipment_certificate'] .'" target="_blank">Click To View file</a>';  
                                   echo' </div>
                                   <div class="col-md-6">
                                        <label>Equipment Manual: </label><br>';
                                         echo '<a href="'. $rows['equipment_manual'] .'" target="_blank">Click To View file</a>';  
                                   echo' </div>
                                   <div class="col-md-6">
                                        <label>Equipment Procedure: </label><br>';
                                         echo '<a href="'. $rows['equipment_procedure'] .'" target="_blank">Click To View file</a>';  
                                   echo' </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer bg-white">
                            <button type="button" class="btn btn-light shadow-none" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info shadow-none" id="update_equipment_glp" name="update_equipment_glp">Update</button>
                        </div>
                    </form>
                ';
            }
            if($_GET['action'] == "get_equipment_parts_details"){
                $equipment_parts_id = $_GET['equipment_parts_id'];
                $result = mysqli_query($pmp_connection,"SELECT * FROM equipment_parts WHERE equipment_parts_id = '$equipment_parts_id'");
                $rows = mysqli_fetch_array($result);
                
                echo '
                    <!--Code Here-->
                    <form action="controller.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="enterprise_owner" value="<?= $current_userEmployerID ?>">
                        <div id="add-modal-body" class="modal-body bg-white">
                            <div class="form-group">
                                <label>Equipment Parts Image<br>
                                <img src="uploads/pmp/'.$rows['equipment_file'].'" style="width:150px;height:150px">
                            </div>
                            <div class="row" id="dynamic_field1">
                                <div class="col-md-12">
                                    <label for="inputParts">Parts Manual</label>
                                </div>
                                <div class="inputs_container" >
                                    <div class="col-md-12">';
                                    
                                    //$PK_id = $row['equipment_parts_id'];
                                    $get= mysqli_query($pmp_connection,"SELECT * FROM files WHERE PK_id ='$equipment_parts_id' ");
                                    while($row=mysqli_fetch_array($get)) {
                                     echo '<a href="#">'.$row['file_name'].'</a><br>';  
                                    }
                                        
                            echo'       </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <hr>
                                <label for="inputEquipment">Equipment Parts Name</label>
                                <input type="text" name="equipment_parts_name" value="'.$rows['equipment_name'].'" class="form-control"  >
                            </div>
                            <div class="form-group">
                                <label for="inputEquipment">Equipment Parts Supplier</label>
                                <input type="text" name="parts_supplier" value="'.$rows['parts_supplier'].'" class="form-control"  >
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="inputSerial">Serial #</label>
                                    <input type="text" name="parts_serail" value="'.$rows['parts_serail'].'" class="form-control"  >
                                </div>
                                <div class="col-md-6 '; echo $_COOKIE['client'] == 1 ? 'hide':''; echo '">
                                    <label for="inputEquipmentID">Equipment Part Model No.</label>
                                    <input type="text" name="parts_id_no" value="'.$rows['parts_id_no'].'" class="form-control"  >
                                </div>
                            </div>
                            <div class="form-group" style="margin-top:15px">
                                <label for="inputFrequency">Parts Owner</label><br>
                                <div style="display:flex;justify-content:flex-end">
                                    <a data-toggle="modal" data-target="#add_parts_to_equipment" class="btn btn-primary add_parts_to_equipment" parts_id="'.$rows['equipment_parts_id'].'"> Add this part to an Equipment</a>
                                </div>
                                ';
                                $gets= mysqli_query($pmp_connection,"SELECT * FROM equipment_parts_owned INNER JOIN equipment_reg ON equipment_reg.equip_id = equipment_parts_owned.equipment_parts_owned_name WHERE equipment_parts_owned.parts_PK_id ='$equipment_parts_id' ");
                                while($rows=mysqli_fetch_array($gets)) {
                                     echo '<a href="#">'.$rows['equipment'].'</a><br>';  
                                }
                            echo '</div>
                            <div class="form-group" id="checklist">
                                <label for="inputFrequency">Parts Checklist<br>';
                                
                                 $get= mysqli_query($pmp_connection,"SELECT * FROM parts_checklist WHERE PK_id ='$equipment_parts_id' ");
                                    while($row=mysqli_fetch_array($get)) {
                                     echo '<a href="#">'.$row['checklist'].'</a><br>';  
                                    }
                         echo'   </div>
                        </div>
                    </form>
                ';
            }
            
            if($_GET['action'] == "get_parts_checklist"){
                $parts_PK_id = $_GET['parts_PK_id'];
                $sql = "SELECT * FROM parts_checklist WHERE PK_id = '$parts_PK_id' " ; 
                $result = mysqli_query ($pmp_connection, $sql);
                while($row = mysqli_fetch_array($result))
                {
                        echo '<div class="col-md-12">';
                            echo '<input type="checkbox" name="parts_checkedlist[]" value="'.$row['id'].'" > <label for="vehicle1">'.$row['checklist'].'</label><br>';
                        echo '</div>';
                }
            }
            if($_GET['action'] == "get_parts_checklist_glp"){
                $parts_PK_id = $_GET['parts_PK_id'];
                $sql = "SELECT * FROM parts_checklist_glp WHERE PK_id = '$parts_PK_id' " ; 
                $result = mysqli_query ($pmp_connection, $sql);
                while($row = mysqli_fetch_array($result))
                {
                        echo '<div class="col-md-12">';
                            echo '<input type="checkbox" name="parts_checkedlist[]" value="'.$row['id'].'" > <label for="vehicle1">'.$row['checklist'].'</label><br>';
                        echo '</div>';
                }
            }
            if($_GET['action'] == "get_equipment_parts"){
                $equipment_id = $_GET['equipment_id'];
                $sql = "SELECT * FROM equipment_parts_owned INNER JOIN equipment_parts ON equipment_parts_owned.parts_PK_id = equipment_parts.equipment_parts_id WHERE equipment_parts_owned.equipment_parts_owned_name = '$equipment_id' " ; 
                $result = mysqli_query ($pmp_connection, $sql);
                echo '<option disabled selected>Choose...</option>.';
                while($row = mysqli_fetch_array($result))
                {
                    echo '<option parts_owned_id="'.$row['id'].'" parts_PK_id="'.$row['parts_PK_id'].'" value="'.$row['parts_PK_id'].'">'.$row['equipment_name'].'</option>';
                }
            }
            if($_GET['action'] == "get_equipment_parts_glp"){
                $equipment_id = $_GET['equipment_id'];
                $sql = "SELECT * FROM equipment_parts_owned_glp INNER JOIN equipment_parts_glp ON equipment_parts_owned_glp.parts_PK_id = equipment_parts_glp.equipment_parts_id WHERE equipment_parts_owned_glp.equipment_parts_owned_name = '$equipment_id' " ; 
                $result = mysqli_query ($pmp_connection, $sql);
                echo '<option disabled selected>Choose...</option>.';
                while($row = mysqli_fetch_array($result))
                {
                    echo '<option parts_owned_id="'.$row['id'].'" parts_PK_id="'.$row['parts_PK_id'].'" value="'.$row['parts_PK_id'].'">'.$row['equipment_name'].'</option>';
                }
            }
            if($_GET['action'] == "get_checklist"){
                $maintenance_id = $_GET['maintenance_id'];
                $sql = "SELECT * FROM parts_checklist WHERE PK_id = '$maintenance_id' " ;
                echo '<label style="margin-left:7px;margin-top:15px">Maintenance Checklist</label>';
                $result = mysqli_query ($pmp_connection, $sql);
                while($row = mysqli_fetch_array($result))
                {
                        echo '<div class="col-md-12">';
                            echo '<input type="checkbox" name="parts_checkedlist[]" value="'.$row['id'].'" > <label for="">'.$row['checklist'].'</label><br>';
                        echo '</div>';
                }
            }
            if($_GET['action'] == "get_parts_history"){
                $parts_id = $_GET['parts_id'];
                $equipment_history_name = $_GET['equipment'];
                
                $sql = "SELECT * FROM parts_maintenance_history 
                INNER JOIN equipment_parts ON parts_maintenance_history.equipment_parts_PK_id = equipment_parts.equipment_parts_id
                WHERE parts_maintenance_history.PK_id = '$parts_id' " ; 
                $result = mysqli_query ($pmp_connection, $sql);
                while($row = mysqli_fetch_array($result))
                {
                   echo '<tr>
                        <td><a class="show_maintenance_history" data-toggle="modal" data-target="#show_maintenance_history" maintenance_id="'.$row['id'].'"  style=" text-decoration: none">'.$row['equipment_name'].'</a></td>
                        <td>'.$row['part_status'].'</td>
                        <td>'.$row['date_performed'].'</td>
                        <td>'.$row['parts_remarks'].'</td>
                        </tr>
                   ';
                }
            }
            if($_GET['action'] == "get_maintenance_history_details"){
                $maintenance_id = $_GET['maintenance_id'];
                $sql = "SELECT * FROM parts_maintenance_history INNER JOIN equipment_parts ON parts_maintenance_history.equipment_parts_PK_id =equipment_parts.equipment_parts_id  WHERE parts_maintenance_history.id = '$maintenance_id' " ; 
                $result3 = mysqli_query($pmp_connection,$sql);
                $row= mysqli_fetch_array($result3);
                $maintenance_id = $row['id'];
               echo '
                    <div class="row mt-4">
                    <div class="col-md-6">
                        <label>Parts Name</label>
                        <input type="text" class="form-control"  name="'.$row['equipment_name'].'" readonly>
                    </div>
                    <div class="col-md-6">
                        <labe>Date Performed</labe>
                        <input type="text" class="form-control" value="'.$row['date_performed'].'" name="" readonly>
                    </div>
                </div>
                
                <div class="row mt-3" style="margin-top:15px">
                    <div class="col-md-6">
                        <label>Equipment Name</label>
                        <input type="text" class="form-control" value="'.$row['history_equipment_name'].'" name="" readonly>
                    </div>
                    <div class="col-md-6">
                        <labe>Parts Status</labe>
                        <input type="text" class="form-control" value="'.$row['part_status'].'" name="" readonly>
                    </div>
                </div>
                
                <div class="row mt-3" style="margin-top:15px">
                    <div class="col-md-6">
                        <label>Remarks</label>
                        <textarea class="form-control" style="height:70px" readonly>'.$row['parts_remarks'].'</textarea>
                    </div>
                </div>
                
                <div class="row mt-3" style="margin-top:15px">
                    <div class="col-md-6">
                        <label>Checked List</label><br>';
                    $sql = "SELECT * FROM parts_checked_list INNER JOIN parts_checklist ON parts_checklist.id = parts_checked_list.checklist_PK_id  WHERE parts_checked_list.PK_id = '$maintenance_id' " ; 
                    $result = mysqli_query ($pmp_connection, $sql);
                    while($rows = mysqli_fetch_array($result))
                    {
                        echo '<input type="checkbox" checked><label> &nbsp; '.$rows['checklist'].'</label><br>';
                    }
                    echo '
                    </div>
                </div>
               ';
            }
            if($_GET['action'] == "show_change_parts"){
                $parts_id = $_GET['parts_id'];
                $sql = "SELECT * FROM parts_maintainance INNER JOIN equipment_parts ON parts_maintainance.equipment_parts_PK_id = equipment_parts.equipment_parts_id WHERE parts_maintainance.parts_id = '$parts_id' " ; 
                $result = mysqli_query($pmp_connection,$sql);
                $row= mysqli_fetch_array($result);
                
                echo '
                    <div class="row">
                        <div class="col-md-12">
                            <label>Parts Image</label><br>
                            <img src="uploads/pmp/'.$row['equipment_file'].'" style="width:150px;height:150px">
                        </div>
                        <div class="col-md-12" style="margin-top:15px">
                            <label>Parts Name</label>
                            <input type="hidden" name="parts_id" value="'.$row['parts_id'].'">
                            <input type="text" class="form-control" value="'.$row['equipment_name'].'" readonly>
                        </div>
                        <div class="col-md-4" style="margin-top:15px">
                            <label>Parts Status</label>
                            <select class="form-control" name="parts_status" id="parts_status_drop">
                                <option value="OK">OK</option>
                                <option value="DEFECT">DEFECT</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="margin-top:15px;">
                            <label>Remarks</label>
                            <textarea class="form-control" name="remarks" style="height:70px"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr><br>
                            <div>
                                <label>Change Equipment Parts</label>
                            </div>
                            <div style="display:flex;justify-content:flex-end">
                                <a data-toggle="modal" data-target="#new_parts" equipment_PK_id="'.$row['equipment_PK_id'].'" equipment_parts_PK_id="'.$row['equipment_parts_PK_id'].'" class="new_parts">New Parts ? </a>
                            </div>
                        </div>
                    </div>
                ';
            }
            if($_GET['action'] == "get_emp_parts"){
                $equipment_id = $_GET['category'];
                $display_part = "SELECT * FROM equipment_parts_owned INNER JOIN equipment_parts ON equipment_parts.equipment_parts_id = equipment_parts_owned.parts_PK_id WHERE equipment_parts_owned.equipment_parts_owned_name = $equipment_id";
                $results = mysqli_query ($pmp_connection, $display_part);
                echo '
                    ';
                 foreach($results as $row){
                    echo '<option value="'.$row['equipment_parts_id'].'">'.$row['equipment_name'].'</option>';
                 }          
            }
            if($_GET['action'] == "get_emp_parts_image"){
                $parts_id = $_GET['category'];
                $display_part = "SELECT * FROM equipment_parts WHERE equipment_parts_id = $parts_id";
                $results = mysqli_query ($pmp_connection, $display_part);
                 foreach($results as $row){
                    echo '<img style="width:80px;height:80px" src="uploads/pmp/' . $row['equipment_file'] . '">';
                 }          
            }
            if($_GET['action'] == "pto_tracker"){
                $user_id = $_GET['option'];
                $get_pto = mysqli_query($conn,"SELECT * FROM tbl_user INNER JOIN leave_details ON leave_details.payeeid = tbl_user.ID INNER JOIN leave_types ON leave_types.leave_id =  leave_details.leave_id WHERE tbl_user.ID = $user_id");
                foreach($get_pto as $rows){
                echo '<tr>
                    <td>'.$rows['first_name'].' '.$rows['last_name'].' </td>
                    <td></td>
                    <td>'. $rows['leave_name'] .'</td>
                    <td>'.$rows['leave_count'] .'</td>
                    <td>'. $rows['start_date'] .'</td>
                    <td>'. $rows['end_date'] .'</td>
                    <td>'. $rows['notes'] .'</td>
                    <td>';
                            if($rows['approve_status'] == 0){
                                echo '<span class="badge badge-success">For Approval</span>';
                            }
                            if($rows['approve_status'] == 1){
                                echo '<span class="badge badge-warning">Approved by Manager</span>';
                            }
                            if($rows['approve_status'] == 2){
                                echo '<span class="badge badge-primary">Approved by HR</span>';
                            }
                            if($rows['approve_status'] == 4){
                                echo '<span class="badge badge-danger">Disapproved</span>'; 
                            }
                            if($rows['approve_status'] == 5){
                                echo '<span class="badge badge-danger">For Cancel</span>'; 
                            }
                            if($rows['approve_status'] == 6){
                                echo '<span class="badge badge-info">Cancelled</span>'; 
                            }

                echo'    </td>
                </tr>';
                }
                
            }
            if($_GET['action'] == "get_video"){
                $page = $_GET['page'];
                $sql = "SELECT * FROM tbl_pages_demo_video WHERE page = '$page' " ; 
                $result = mysqli_query($conn,$sql);
                $row= mysqli_fetch_array($result);
                echo $row['file_name'];
            }
            if($_GET['action'] == "get_employee_checklist"){
                $checker = mysqli_query($conn, "SELECT * FROM others_employee_details WHERE employee_id='" . $_GET['id'] . "'");
                $new_check_result = []; // Initialize as an empty array
                $check_result = []; // Initialize as an empty array
            
                if ($checker) {
                    $check_result = mysqli_fetch_array($checker);
                    if (!empty($check_result['pto_to_approved'])) {
                        $new_check_result = explode(",", $check_result['pto_to_approved']);
                    }
                }

                $total_leave = $check_result['total_leave'] ?? '';
                $employee_lvl = $check_result['employee_lvl'] ?? '';
                $contact_no = $check_result['contact_no'] ?? '';
                $address = $check_result['address'] ?? '';
                $emergency_name = $check_result['emergency_name'] ?? '';
                $personal_email = $check_result['personal_email'] ?? '';
                $company_email = $check_result['company_email'] ?? '';
                $emergency_address = $check_result['emergency_address'] ?? '';
                $emergency_contact_no = $check_result['emergency_contact_no'] ?? '';
                $emergency_email = $check_result['emergency_email'] ?? '';
                $emergency_relation = $check_result['emergency_relation'] ?? '';

                $sql = "SELECT *,tbl_user.ID as user_cookie FROM tbl_hr_employee INNER JOIN tbl_user ON tbl_hr_employee.ID = tbl_user.employee_id WHERE tbl_hr_employee.user_id = 34 AND tbl_hr_employee.suspended = 0 AND tbl_hr_employee.status = 1 ";
                $result = mysqli_query($conn, $sql);

                foreach ($result as $row) {
                    echo '
                    <div class="col-md-4">
                        <div class="form-check form-check-inline">';
                    echo ' <input class="form-check-input" name="to_approve[]" value="' . $row['user_cookie'] . '" type="checkbox" id="' . $row['first_name'] . '"' . (in_array($row['user_cookie'], $new_check_result) ? 'checked' : '') . ' >
                        <label class="form-check-label" for="' . $row['first_name'] . '">' . $row['first_name'] . ' ' . $row['last_name'] . '</label>';
                    echo '   </div>
                    </div>
                    ';
                    echo '
                    </div>
                        </div>
                    ';
                }

                echo '
                    <div class="row" style="margin-left:5px">
                    </div>
                    <div class="row" style="margin-left:5px">
                        <div class="col-md-4">
                            <H5>Set PTO</H5>
                            <input type="text" name="total_leave" value="' . $total_leave . '" class="form-control">
                        </div>
                    </div>
                    <div class="row" style="margin-left:5px">
                        <div class="col-md-4">
                            <H5>Employee Level</H5>
                            <input type="text" name="employee_lvl" value="' . $employee_lvl . '" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <H5>Contact Number</H5>
                            <input type="text" name="contact_no" value="' . $contact_no . '" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <H5>Address</H5>
                            <input type="text" name="address" value="' . $address. '" class="form-control">
                </div>
                </div>
                <div class="row" style="margin-left:5px">
                <div class="col-md-4">
                <H5>Personal Email</H5>
                <input type="text" name="personal_email" value="' . $personal_email . '" class="form-control">
                </div>
                <div class="col-md-4">
                <H5>Company Email</H5>
                <input type="text" name="company_email" value="' . $company_email . '" class="form-control">
                </div>
                </div>
                <div class="row" style="margin-left:5px">
                <div class="col-md-12">
                <hr>
                </div>
                </div>
                <div class="row" style="margin-left:5px">
                <div class="col-md-12">
                Emergency Contact
                </div>
                </div>
                <div class="row" style="margin-left:5px">
                <div class="col-md-4">
                <H5>Contact Person</H5>
                <input type="text" name="emergency_name" value="' . $emergency_name . '" class="form-control">
                </div>
                <div class="col-md-4">
                <H5>Address</H5>
                <input type="text" name="emergency_address" value="' . $emergency_address . '" class="form-control">
                </div>
                <div class="col-md-4">
                <H5>Contact Number</H5>
                <input type="text" name="emergency_contact_no" value="' . $emergency_contact_no . '" class="form-control">
                </div>
                </div>
                <div class="row" style="margin-left:5px">
                <div class="col-md-4">
                <H5>Email Address</H5>
                <input type="text" name="emergency_email" value="' . $emergency_email . '" class="form-control">
                </div>
                <div class="col-md-4">
                <H5>Relation</H5>
                <input type="text" name="emergency_relation" value="' . $emergency_relation . '" class="form-control">
                </div>
                </div>
                ';
            }
        }
    }
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    function send_mail($employee_id,$employee_email,$employee_name) {
         require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            //  $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
            $mail->Host       = 'interlinkiq.com';
            $mail->CharSet    = 'UTF-8';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'admin@interlinkiq.com';
            $mail->Password   = 'L1873@2019new';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->clearAddresses();
            $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
            $mail->addAddress("marcjhonel.t.ojt@gmail.com", "interlinkiq.com");

            $mail->isHTML(true);
            $mail->Subject = "InterlinkIQ User Update";
            $mail->Body    = $employee_email.' has updated his/her bank details to view the details please see this link<br> <br> https://interlinkiq.com/Accounting_system/Pages/bank_comparison/'.$employee_id;

            $mail->send();
            $msg = 'Message has been sent';
        } catch (Exception $e) {
            $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        return $msg;
    }

    // PMP
    if( isset($_GET['pmp_la_view']) ) {
        $id = $_GET['pmp_la_view'];
        
        $selectData = mysqli_query( $pmp_connection,"SELECT * FROM area_list WHERE id = $id" );
        if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);

			$area_id = $row['id'];
			$area_name = $row['area_name'];
			
			echo '<label>Area Name</label>
            <input type="hidden" name="id" value="'.$area_id.'" />
            <input type="hidden" name="action" value="" />
            <input type="text" name="area_name" class="form-control" value="'.$area_name.'" required />';
        }
    }
    if( isset($_GET['pmp_la_del']) ) {
        $id = $_GET['pmp_la_del'];
        $sql = mysqli_query( $pmp_connection,"UPDATE area_list set deleted = 1 WHERE id = $id" );
    }
    if( isset($_GET['pmp_la_del_glp']) ) {
        $id = $_GET['pmp_la_del_glp'];
        $sql = mysqli_query( $pmp_connection,"UPDATE area_list_glp set deleted = 1 WHERE id = $id" );
    }
    if( isset($_GET['pmp_ep_del']) ) {
        $id = $_GET['pmp_ep_del'];
        $sql = mysqli_query( $pmp_connection,"UPDATE equipment_reg set deleted = 1 WHERE equip_id = $id" );
    }
    if( isset($_GET['pmp_ep_del_glp']) ) {
        $id = $_GET['pmp_ep_del_glp'];
        $sql = mysqli_query( $pmp_connection,"UPDATE equipment_reg_glp set deleted = 1 WHERE equip_id = $id" );
    }
    if( isset($_GET['pmp_pr_del']) ) {
        $id = $_GET['pmp_pr_del'];
        $sql = mysqli_query( $pmp_connection,"UPDATE equipment_parts set deleted = 1 WHERE equipment_parts_id = $id" );
    }
    if(isset($_POST['update_equipment'])){
        
        $equipment_id = $_POST['equip_id'];
        $equipment = $_POST['equipment'];
        $serial_no = $_POST['serial_no'];
        $equip_id_no = $_POST['equip_id_no'];
        $location = $_POST['location'];
        $process_owner = $_POST['process_owner'];
        $freq_maintain = $_POST['freq_maintain'];
        $supplier = $_POST['supplier'];
        $status = $_POST['status'];  
        
        $filename=$_FILES['equipment_image']['name'];
        if (!empty($filename)) {
            $size=$_FILES['equipment_image']['size'];
            $type=$_FILES['equipment_image']['type'];
            $temp1=$_FILES['equipment_image']['tmp_name'];
            move_uploaded_file($temp1,"uploads/pmp/$filename");
            
            mysqli_query( $pmp_connection,"UPDATE equipment_reg set pic_name='".$filename."' WHERE equip_id='". $equipment_id ."'" );
        }
        
        $sql = "UPDATE equipment_reg 
                SET 
                    equipment = '$equipment',
                    serial_no = '$serial_no',
                    equip_id_no = '$equip_id_no',
                    location = '$location',
                    process_owner = '$process_owner',
                    freq_maintain = '$freq_maintain',
                    supplier = '$supplier',
                    status = '$status'
                WHERE 
                    equip_id = '$equipment_id'";
        
        // Execute the update
        if (mysqli_query($pmp_connection, $sql)) {
            header('Location: ' . $_SERVER["HTTP_REFERER"] );
        } else {
            echo "Error updating record: " . mysqli_error($pmp_connection);
        }
        
        // Close the database connection
        mysqli_close($pmp_connection);
    }
    
    if(isset($_POST['update_equipment_glp'])){
        
        $equipment_id = $_POST['equip_id'];
        $equipment = $_POST['equipment'];
        $serial_no = $_POST['serial_no'];
        $equip_id_no = $_POST['equip_id_no'];
        $location = $_POST['location'];
        $process_owner = $_POST['process_owner'];
        $freq_maintain = $_POST['freq_maintain'];
        $supplier = $_POST['supplier'];
        $status = $_POST['status'];  
        
        $filename=$_FILES['equipment_image']['name'];
        if (!empty($filename)) {
            $size=$_FILES['equipment_image']['size'];
            $type=$_FILES['equipment_image']['type'];
            $temp1=$_FILES['equipment_image']['tmp_name'];
            move_uploaded_file($temp1,"uploads/pmp/$filename");
            
            mysqli_query( $pmp_connection,"UPDATE equipment_reg_glp set pic_name='".$filename."' WHERE equip_id='". $equipment_id ."'" );
        }
        
        $sql = "UPDATE equipment_reg_glp 
                SET 
                    equipment = '$equipment',
                    serial_no = '$serial_no',
                    equip_id_no = '$equip_id_no',
                    location = '$location',
                    process_owner = '$process_owner',
                    freq_maintain = '$freq_maintain',
                    supplier = '$supplier',
                    status = '$status'
                WHERE 
                    equip_id = '$equipment_id'";
        
        // Execute the update
        if (mysqli_query($pmp_connection, $sql)) {
            header('Location: ' . $_SERVER["HTTP_REFERER"] );
        } else {
            echo "Error updating record: " . mysqli_error($pmp_connection);
        }
        
        // Close the database connection
        mysqli_close($pmp_connection);
    }
?>