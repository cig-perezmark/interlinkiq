<?php
include_once '../database.php';
if(isset($_GET['inc_id']))
{
$id = $_GET['inc_id'];

// fetch file to download from database
$sql = "SELECT * FROM tbl_crisis_incidents WHERE crisis_incidents_id=$id";
$result = mysqli_query($conn, $sql);

$file = mysqli_fetch_assoc($result);
$filepath = '../Disaster_Supporting_files_Folder/' . $file['disaster_Supporting_files'];

if (file_exists($filepath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($filepath));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize('../Disaster_Supporting_files_Folder/' . $file['disaster_Supporting_files']));
    readfile('companyDetailsFolder/' . $file['disaster_Supporting_files']);

    // Now update downloads count
    $newCount = $file['downloads'] + 1;
    $updateQuery = "UPDATE tbl_crisis_incidents SET downloads=$newCount WHERE crisis_incidents_id=$id";
    if(mysqli_query($conn, $updateQuery)){
        echo '<script> window.location.href = "../Types_Of_Crisis";</script>';
    }
   
    exit;
   
}
}
?>
