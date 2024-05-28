<?php
include_once ('../database.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if(isset($_POST['disapprove_pto'])){
        $approve_notes = mysqli_real_escape_string($conn,$_POST['approve_notes']);
        
        $leave_id = $_POST['leave_id'];
        $update_leave = "UPDATE leave_details SET approve_status='4',approve_notes = '$approve_notes' WHERE ids = '$leave_id'";
        if(mysqli_query($conn,$update_leave)){
            echo '<script>history.go(-1);</script>';
            exit();
        }
    }
    if(isset($_POST['cancel_pto'])){
        $notes = $_POST['user_notes'];
        $leave_id = $_POST['id_leave'];
        $update_leave = "UPDATE leave_details SET approve_status='5', notes = '$notes' WHERE ids = '$leave_id'";
        if(mysqli_query($conn,$update_leave)){
            echo '<script>history.go(-1);</script>';
            exit();
        }
    }
    if(isset($_POST['update_pto'])){
        $leave_count = $_POST['leave_count'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $notes = mysqli_real_escape_string($conn, $_POST['notes']);
        $leave_id = $_POST['leave_id'];
        $update_leave = "UPDATE leave_details SET approve_status='0',leave_count = '$leave_count',start_date = '$start_date',end_date = '$end_date',notes = '$notes' WHERE ids = '$leave_id'";
        if(mysqli_query($conn,$update_leave)){
            echo '<script>history.go(-1);</script>';
            exit();
        }
    }
    
    if(isset($_POST['action'])){ 
      
        if($_POST['action'] == "update_pay"){
            $payid = $_POST['payid'];

            $update_query = "UPDATE pay SET paidstatus= 'paid' WHERE payid = '$payid'";
            if (mysqli_query($payroll_connection, $update_query)) {
                return true;
            } else {
                echo "Error updating record: " . mysqli_error($payroll_connection);
            } 
        }
      
        if($_POST['action']=="get_form"){    
            $form_id = $_POST['form_id'];
            $enterprise = $_POST['enterprise'];
            $check_form_owned = mysqli_query($conn,"SELECT * FROM tbl_forms_owned WHERE user_id = '" . $_COOKIE['ID'] . "' AND enterprise_id = '$enterprise'");
            $check_result = mysqli_fetch_array($check_form_owned);
            $num_rows = mysqli_num_rows($check_form_owned);
            if($num_rows > 0){
                $form_owned = $check_result["form_owned"].',' .$form_id;
                $update_query = "UPDATE tbl_forms_owned SET form_owned='$form_owned' WHERE user_id = '" . $_COOKIE['ID'] . "' AND enterprise_id = '$enterprise' ";
                if (mysqli_query($conn, $update_query)) {
                    return true;
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                } 
            }
            else{
                $insert_query = "INSERT INTO `tbl_forms_owned`(`user_id`,enterprise_id,`form_owned`) VALUES ( '" . $_COOKIE['ID'] . "' ,'$enterprise' ,'$form_id')";
                if (mysqli_query($conn, $insert_query)) {
                    return true;
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            }
        }
      
        if($_POST['action'] == "insert_leave"){
          
            $end_date = $_POST['end_date'];
            $task_date = $_POST['task_date'];
            $user_id = $_POST['user_id'];
            $minute = $_POST['minute'];
            $checker = mysqli_query($conn,"SELECT * FROM tbl_user WHERE ID = '$user_id'");
            $check_result = mysqli_fetch_array($checker);
            $user_session_id = $check_result['employee_id'];
            $begin = new DateTime($_POST['task_date']);
            $end   = new DateTime($_POST['end_date']);
            for($i = $begin; $i <= $end; $i->modify('+1 day')){
                $task_date = $i->format("Y-m-d");
                $insert_query = "INSERT INTO `tbl_service_logs`(`user_id`,minute,`task_date`,description,comment,status) VALUES ('$user_id','$minute','$task_date','CONSULTAREINC','CONSULTAREINC',NULL)";
                if (mysqli_query($conn, $insert_query)) {
                    $update_query = "UPDATE leave_details SET approve_status='2' WHERE payeeid = '$user_id' AND start_date = '$task_date'";
                    if (mysqli_query($conn, $update_query)) {
                        
                    }
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            }
            $select = "SELECT * FROM others_employee_details WHERE employee_id = '$user_session_id'";
            $result = mysqli_query ($conn, $select);
            $row = mysqli_fetch_array($result);
            $leave_count = floatval($_POST['leave_count']);
            $total_leave = floatval($row['total_leave']);
            if($total_leave != 0){
                if($_POST['minute'] == -7){
                    $new_total_leave = $total_leave - .5;
                    $update_total_leave = "UPDATE others_employee_details SET total_leave='$new_total_leave' WHERE employee_id = '$user_session_id'"; 
                }
                if($_POST['minute'] == -5){
                    $new_total_leave = $total_leave - 0;
                    $update_total_leave = "UPDATE others_employee_details SET total_leave='$new_total_leave' WHERE employee_id = '$user_session_id'"; 
                }
                if($_POST['minute'] != -5 && $_POST['minute'] != -7){
                    $new_total_leaves = $total_leave - $leave_count;
                    $update_total_leave = "UPDATE others_employee_details SET total_leave='$new_total_leaves' WHERE employee_id = '$user_session_id'";
                }
                if(mysqli_query($conn,$update_total_leave)){
                }
            }
            return true;
        }
      
        if($_POST['action'] == "update_leave"){
            $user_id = $_POST['user_id'];
            $leave_id = $_POST['leave_ids'];
            $update_leave = "UPDATE leave_details SET approve_status='1' WHERE payeeid = '$user_id' AND ids = '$leave_id'";
            if(mysqli_query($conn,$update_leave)){
                return true;
            }
        }
      
        if($_POST['action'] == "cancel_pto"){
            $leave_count = $_POST['leave_count'];
            $leave_id = $_POST['leave_ids'];
            $users_id = $_POST['users_id'];
            $update_leave = "UPDATE leave_details SET approve_status='6' WHERE  ids = '$leave_id'";
            if(mysqli_query($conn,$update_leave)){
                $check_user = mysqli_query($conn,"SELECT * FROM tbl_user INNER JOIN others_employee_details ON tbl_user.employee_id = others_employee_details.employee_id  WHERE tbl_user.ID = '$users_id'");
                $check_result = mysqli_fetch_array($check_user);
                $new_total_leave = parseInt($check_result["total_leave"]) + parseInt($leave_count);
                $new_user_id = $check_result["employee_id"];
                $update_query = "UPDATE others_employee_details SET total_leave='$new_total_leave' WHERE employee_id = '$new_user_id'";
                if($update_query){
                    return true;
                }
            }
        }
      
        if($_POST['action'] == "add_form"){
            $eform_id = $_POST['eform_id'];
            $form_owner = $_POST['form_owner'];
            $enterprise_id = $_POST['enterprise_id'];
            $i = '';
            foreach($form_owner as $row){
                $check_form_owned = mysqli_query($conn,"SELECT * FROM tbl_forms_owned WHERE user_id = '$row' AND enterprise_id = '$enterprise_id' ");
                $check_result = mysqli_fetch_array($check_form_owned);
                if( mysqli_num_rows($check_form_owned) > 0 ) {
                    $array_counter = explode(",", $check_result["form_owned"]); 
                    if(!in_array($eform_id,$array_counter)){
                        array_push($array_counter,$eform_id);
                        $new_form_id =   implode(',',$array_counter);
                        $update_query = "UPDATE tbl_forms_owned SET form_owned='$new_form_id' WHERE user_id = '$row'";
                        if (mysqli_query($conn, $update_query)) {
                            return true;
                        } else {
                            echo "Error updating record: " . mysqli_error($conn);
                        }
                    }
                }
                else{
                    $insert_query = "INSERT INTO `tbl_forms_owned`(`user_id`,enterprise_id,`form_owned`) VALUES ( '$row' ,'$enterprise_id' ,'$eform_id')";
                    if (mysqli_query($conn, $insert_query)) {
                        return true;
                    } else {
                        echo "Error updating record: " . mysqli_error($conn);
                    }
                }
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Your GET request handling code here
}

?>
