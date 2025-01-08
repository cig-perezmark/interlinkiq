<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once ('../../database_iiq.php');
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
    } else {
    	$portal_user = $_COOKIE['ID'];
    	$user_id = employerID($portal_user);
    }
    
    $enterprise_id = $user_id;

    // INSERT FORM FUNCTION
    if (isset($_POST['add_form'])) {
        $name = $_POST['name'];
    
        if (empty($_FILES['file']) || $_FILES['file']['error'] !== 0) {
            echo "No file uploaded or file upload error.";
            return;
        }
    
        $fileInfo = pathinfo($_FILES['file']['name']);
        $fileExt = strtolower($fileInfo['extension']);
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
    
        // Validate file type
        if (!in_array($fileExt, $allowed)) {
            echo "Invalid file type.";
            return;
        }
    
        // Sanitize the filename to remove spaces, commas, and hyphens
        $originalFileName = preg_replace("/[\s, -]+/", "_", $fileInfo['filename']) . "." . $fileExt;
        $fileDestination = '../../library/eforms/files/' . $originalFileName;
    
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $fileDestination)) {
            echo "Error moving file.";
            return;
        }
    
        $stmt = $conn->prepare("INSERT INTO tbl_eform_library (enterprise_id, form_name, file) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $enterprise_id, $name, $originalFileName);
    
        if ($stmt->execute()) {
            echo "Record added successfully.";
        } else {
            echo "Error adding record: " . $stmt->error;
        }
    }


    
    // UPDATE UPLOADED FILE FUNCTION
    if (isset($_POST['update_file'])) {
        $id = $_POST['id'];
        $file = $_FILES['file'];
    
        if (empty($file) || $file['error'] !== 0) {
            echo "No file uploaded or file upload error.";
            return;
        }
    
        $stmt = $conn->prepare("SELECT file FROM tbl_eform_library WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows === 0) {
            echo "No record found with this ID.";
            return;
        }
    
        $row = $result->fetch_assoc();
        $oldFileName = $row['file'];
        $oldFilePath = '../../library/eforms/files/' . $oldFileName;
    
        $fileInfo = pathinfo($file['name']);
        $fileExt = strtolower($fileInfo['extension']);
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
    
        if (!in_array($fileExt, $allowed)) {
            echo "Invalid file type.";
            return;
        }
    
        // Use original filename, sanitized
        $newFileName = preg_replace("/[\s, -]+/", "_", $fileInfo['filename']) . "." . $fileExt;
        $fileDestination = '../../library/eforms/files/' . $newFileName;
    
        if (!move_uploaded_file($file['tmp_name'], $fileDestination)) {
            echo "Error moving file.";
            return;
        }
    
        if (file_exists($oldFilePath)) {
            if (!unlink($oldFilePath)) {
                echo "Error deleting the old file.";
                return;
            }
        }
    
        $stmt = $conn->prepare("UPDATE tbl_eform_library SET file = ? WHERE id = ?");
        $stmt->bind_param("si", $newFileName, $id);
    
        if ($stmt->execute()) {
            echo "File updated successfully.";
        } else {
            echo "Error updating record: " . $stmt->error;
        }
    }


