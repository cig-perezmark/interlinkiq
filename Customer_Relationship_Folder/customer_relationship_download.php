<?php
include '../database.php';
if(isset($_GET['pathDoc']))
{
 echo $id = $_GET['pathDoc'];
    
    // fetch file to download from database
    $sql = "SELECT * FROM tbl_Customer_Relationship_References WHERE reference_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = '../Customer_Relationship_files_Folder/'.$file['Documents'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('../Customer_Relationship_files_Folder/'.$file['Documents']));
        readfile('../Customer_Relationship_files_Folder/'.$file['Documents']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tbl_Customer_Relationship_References SET downloads=$newCount WHERE reference_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            //  echo '<script> window.location.href = "../Customer_Relationship_Management";</script>';
        }
       
        exit;
       
    }
}

if(isset($_GET['pathDocFSE']))
{
$id = $_GET['pathDocFSE'];

    // fetch file to download from database
    $sql = "SELECT * FROM tbl_Customer_Relationship_FSE WHERE FSE_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = '../Customer_Relationship_files_Folder/' . $file['FSE_Documents'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('../Customer_Relationship_files_Folder/'.$file['FSE_Documents']));
        readfile('../Customer_Relationship_files_Folder/' . $file['FSE_Documents']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tbl_Customer_Relationship_FSE SET downloads=$newCount WHERE FSE_id=$id";
        if(mysqli_query($conn, $updateQuery)){
             echo '<script> window.location.href = "../Customer_Relationship_Management";</script>';
        }
       
        exit;
       
    }
}
?>
