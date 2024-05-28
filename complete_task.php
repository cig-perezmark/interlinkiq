<?php
if (!isset($_COOKIE['ID'])) {
    echo '<script>
            if (document.referrer == "") {
                window.location.href = "login";
            } else {
                window.history.back();
            }
        </script>';
}
 include_once ('database.php'); 
$title = "My Pro";
$site = "MyPro";
$breadcrumbs = '';
$sub_breadcrumbs = '';
$base_url = "https://interlinkiq.com/";
  include_once ('header.php'); 
if ($sub_breadcrumbs) {
    $breadcrumbs .= '<li><span>' . $sub_breadcrumbs . '</span><i class="fa fa-angle-right"></i></li>';
}
$breadcrumbs .= '<li><span>' . $title . '</span></li>';
if(isset($_GET['comp_subtask_id'])) {
    $user_id = $_COOKIE['ID'];
    $subtask_id = $_GET['comp_subtask_id'];
     
    // Sanitize input
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $subtask_id = mysqli_real_escape_string($conn, $subtask_id);
    // Check user access
    $selectUser = mysqli_query($conn, "SELECT * FROM tbl_user WHERE ID = '$user_id'");
    if (mysqli_num_rows($selectUser) > 0) {
        $rowUser = mysqli_fetch_array($selectUser);
        $check_user_id = $rowUser['employee_id'];

        // Check subtask assignment
        $sql_MyTask = $conn->prepare("SELECT * FROM tbl_MyProject_Services_Childs_action_Items WHERE CAI_id = ? AND CAI_Assign_to = ?");
        $sql_MyTask->bind_param("ii", $subtask_id, $check_user_id);
        $sql_MyTask->execute();
        $result_MyTask = $sql_MyTask->get_result();
        if ($result_MyTask->num_rows > 0) {
            $rowData = mysqli_fetch_array($result_MyTask);
            $subtask_data = $rowData['CAI_id'];
            $CAI_Assign = $rowData['CAI_Assign_to'];

            // Update subtask progress if user has the right
            if ($check_user_id == $CAI_Assign) {
                $update_sql = "UPDATE tbl_MyProject_Services_Childs_action_Items
                               SET CIA_progress = 2
                               WHERE CAI_id = ?";
                $update_stmt = $conn->prepare($update_sql);
                
                if ($update_stmt) {
                    $update_stmt->bind_param("i", $subtask_data);
                    
                    if ($update_stmt->execute()) {
                     echo'
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
                    <script>
                        Swal.fire({
                            icon: "success",
                            title: "Task Completed",
                            text: "The task has been successfully completed.",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            // Redirect to the desired URL after the popup is closed
                            window.location.href = "https://interlinkiq.com/test_task_mypro?view_id='.$rowData['MyPro_PK'].'";
                        });
                    </script>';
                    } else {
                        echo "error";
                    }
                } else {
                    echo "Error in SQL query: " . $conn->error;
                }
            } else {
                echo "No right to complete this task";
            }
        } else {
            echo "No matching data found.";
        }

        $sql_MyTask->close();
    } else {
        echo "No matching user data found.";
    }
} else {
    echo "Incomplete or missing parameters.";
}

// for task mother

if(isset($_GET['comp_mothtask_id'])) {
    $user_id = $_COOKIE['ID'];
    $moth_id = $_GET['comp_mothtask_id'];
     
    // Sanitize input
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $moth_id = mysqli_real_escape_string($conn, $moth_id);
    // Check user access
    $selectUser = mysqli_query($conn, "SELECT * FROM tbl_user WHERE ID = '$user_id'");
    if (mysqli_num_rows($selectUser) > 0) {
        $rowUser = mysqli_fetch_array($selectUser);
        $check_user_id = $rowUser['employee_id'];

        // Check subtask assignment
        $sql_Task = $conn->prepare("SELECT * FROM tbl_MyProject_Services_History WHERE History_id = ? AND Assign_to_history = ?");
        $sql_Task->bind_param("ii", $moth_id, $check_user_id);
        $sql_Task->execute();
        $result_Task = $sql_Task->get_result();
        if ($result_Task->num_rows > 0) {
            $rowData = mysqli_fetch_array($result_Task);
            $task_data = $rowData['History_id'];
            $CAI_Assign = $rowData['Assign_to_history'];

            // Update subtask progress if user has the right
            if ($check_user_id == $CAI_Assign) {
                $update_sql = "UPDATE tbl_MyProject_Services_History
                               SET tmsh_column_status = 2
                               WHERE History_id = ?";
                $update_stmt = $conn->prepare($update_sql);
                
                if ($update_stmt) {
                    $update_stmt->bind_param("i", $task_data);
                    
                    if ($update_stmt->execute()) {
                     echo'
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
                    <script>
                        Swal.fire({
                            icon: "success",
                            title: "Task Completed",
                            text: "The task has been successfully completed.",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            // Redirect to the desired URL after the popup is closed
                            window.location.href = "https://interlinkiq.com/test_MyPro";
                        });
                    </script>';
                    } else {
                        echo "error";
                    }
                } else {
                    echo "Error in SQL query: " . $conn->error;
                }
            } else {
                echo "No right to complete this task";
            }
        } else {
            echo "No matching data found.";
        }

        $sql_Task->close();
    } else {
        echo "No matching user data found.";
    }
} else {
    echo "Incomplete or missing parameters.";
}
?>
