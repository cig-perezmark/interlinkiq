<?php
include_once 'database.php';
 // Downloads files
if (isset($_GET['file_id_plantFacility'])) {
    $id = $_GET['file_id_plantFacility'];

    // fetch file to download from database
    $sql = "SELECT * FROM tbl_companyDetails WHERE details_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['plantFacility'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['plantFacility']));
        readfile('companyDetailsFolder/' . $file['plantFacility']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tbl_companyDetails SET downloads=$newCount WHERE details_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            header('location:index.php');
        }
       
        exit;
       
    }

}


if (isset($_GET['file_id_auditInformations'])) {
    $id = $_GET['file_id_auditInformations'];

    // fetch file to download from database
    $sql = "SELECT * FROM tbl_companyDetails WHERE details_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['auditInformations'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['auditInformations']));
        readfile('companyDetailsFolder/' . $file['auditInformations']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tbl_companyDetails SET downloads=$newCount WHERE details_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            header('location:index.php');
        }
       
        exit;
       
    }

}
 
?>
