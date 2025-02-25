<?php

    include_once 'database.php';
    
    if (isset($_POST['add_schedule'])) {
        $time = $_POST['time'];
        $to = $_POST['to'];
        $from = $_POST['from'];
        $userid = $_POST['userid'];
        $employee_name = $_POST['employee_name'];
        $flag = 'Pending';
        
        $from_mysql_format = date('Y-m-d', strtotime($from));
        $to_mysql_format = date('Y-m-d', strtotime($to));
        $date_span = date_diff(date_create($from), date_create($to))->format('%a');
    
        // Check if the userid already exists
        $checkSql = 'SELECT COUNT(*) FROM tbl_employee_schedule WHERE userid = ?';
        $checkStmt = mysqli_prepare($conn, $checkSql);
    
        if (!$checkStmt) {
            die('Error in preparing statement: ' . mysqli_error($conn));
        }
    
        mysqli_stmt_bind_param($checkStmt, 'i', $userid);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_bind_result($checkStmt, $count);
        mysqli_stmt_fetch($checkStmt);
        mysqli_stmt_close($checkStmt);
    
        if ($count > 0) {
            $response = array('status' => 'error', 'message' => 'You`ve already established a timetable.');
            echo json_encode($response);
        } else {
            // User ID does not exist, proceed with insertion
            $insertSql = 'INSERT INTO tbl_employee_schedule(userid, time_schedule, date_from, date_to, employee_name, schedule_span, status_flag) VALUES (?,?,?,?,?,?,?)';
            $insertStmt = mysqli_prepare($conn, $insertSql);
    
            if (!$insertStmt) {
                die('Error in preparing statement: ' . mysqli_error($conn));
            }
    
            mysqli_stmt_bind_param($insertStmt, 'issssis', $userid, $time, $from, $to, $employee_name, $date_span, $flag);
    
            mysqli_stmt_execute($insertStmt);
    
            $success = mysqli_stmt_affected_rows($insertStmt) > 0;
    
            mysqli_stmt_close($insertStmt);
    
            if ($success) {
                $response = array('status' => 'success', 'message' => 'Schedule set successfully.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Error setting schedule.');
                echo json_encode($response);
            }
        }
    }
    
    if(isset($_POST['approve_schedule'])) {
        $id = $_POST['scheduleid'];
        // $id = 4;
        
        $checkSql = 'SELECT COUNT(*) FROM tbl_employee_schedule WHERE scheduleid = ?';
        $checkStmt = mysqli_prepare($conn, $checkSql);
        
        if (!$checkStmt) {
            die('Error in preparing statement: ' . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($checkStmt, 'i', $id);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_bind_result($checkStmt, $count);
        mysqli_stmt_fetch($checkStmt);
        mysqli_stmt_close($checkStmt);
        
        if(empty($count)) {
            $response = array('status' => 'error', 'message' => 'Schedule not found.');
            echo json_encode($response);
        } else {
        // Assuming you have an update query like this
        $updateSql = 'UPDATE tbl_employee_schedule SET status_flag = ?, is_approved = ? WHERE scheduleid = ?';
        $updateStmt = mysqli_prepare($conn, $updateSql);

            if (!$updateStmt) {
                die('Error in preparing update statement: ' . mysqli_error($conn));
            }
    
            // Replace column1, column2 with your actual column names
            $status_flag = 'Active';
            $is_approved = 'Yes';
    
            mysqli_stmt_bind_param($updateStmt, 'ssi', $status_flag, $is_approved, $id);
    
            if(mysqli_stmt_execute($updateStmt)) {
                $response = array('status' => 'success', 'message' => 'Schedule approved successfully.');
            } else {
                $response = array('status' => 'error', 'message' => 'Error updating timetable: ' . mysqli_error($conn));
            }
    
            echo json_encode($response);
    
            mysqli_stmt_close($updateStmt);
        }
    }
    
    if(isset($_POST['load_schedule'])) {
        $status = 'Yes';
        $sql = "SELECT * FROM tbl_employee_schedule WHERE is_approved != ? ORDER BY timestamp DESC";
    
        $stmt = mysqli_prepare($conn, $sql);
    
        if ($stmt === false) {
            die("Error in preparing the statement: " . mysqli_error($conn));
        }
    
        mysqli_stmt_bind_param($stmt, 's', $status);
    
        mysqli_stmt_execute($stmt);
    
        $result = mysqli_stmt_get_result($stmt);
        $output ='';
        if(mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)) {
                $date_from = date_create($row['date_from']);
                $date_to = date_create($row['date_to']);
                $output .= '
                    <tr role="row">
                        <td>'.$row['employee_name'].'</td>
                        <td>'.$row['time_schedule'].'</td>
                        <td>'.date_format($date_from,"F d, Y").' - '.date_format($date_to,"F d, Y").'</td>
                        <td class="text-center"><button type="button" class="btn btn-primary approveSchedule" id="'.$row['scheduleid'].'">Approve</button></td>
                    </tr>
                ';
            }
        echo $output;
        }
        mysqli_stmt_close($stmt);
        mysqli_free_result($result);
    
    }

?>
