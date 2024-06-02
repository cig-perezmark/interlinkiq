<?php
include_once '../database.php';
if(isset($_GET['pathPermits']))
{
$id = $_GET['pathPermits'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblFacilityDetails_Permits WHERE Permits_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = '../facility_files_Folder/' . $file['Permits'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('../facility_files_Folder/' . $file['Permits']));
        readfile('companyDetailsFolder/' . $file['Permits']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblFacilityDetails_Permits SET downloads=$newCount WHERE Permits_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#fo";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['FDA_files']))
{
$id = $_GET['FDA_files'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblFacilityDetails_Registration_Organization_FDA WHERE Reg_Org_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = '../facility_files_Folder/' . $file['Reg_Org_Supporting_files_FDA'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('../facility_files_Folder/' . $file['Reg_Org_Supporting_files_FDA']));
        readfile('companyDetailsFolder/' . $file['Reg_Org_Supporting_files_FDA']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblFacilityDetails_Registration_Organization_FDA SET downloads=$newCount WHERE Reg_Org_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#fo";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['USDA_files']))
{
$id = $_GET['USDA_files'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblFacilityDetails_Registration_Organization_USDA WHERE Reg_Org_id_USDA=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = '../facility_files_Folder/' . $file['Reg_Org_Supporting_files_USDA'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('../facility_files_Folder/' . $file['Reg_Org_Supporting_files_USDA']));
        readfile('companyDetailsFolder/' . $file['Reg_Org_Supporting_files_USDA']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblFacilityDetails_Registration_Organization_USDA SET downloads=$newCount WHERE Reg_Org_id_USDA=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#fo";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['Others_files']))
{
$id = $_GET['Others_files'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblFacilityDetails_Registration_Organization_Others WHERE Reg_Org_id_Others=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = '../facility_files_Folder/' . $file['Reg_Org_Supporting_files_Others'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('../facility_files_Folder/' . $file['Reg_Org_Supporting_files_Others']));
        readfile('companyDetailsFolder/' . $file['Reg_Org_Supporting_files_Others']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblFacilityDetails_Registration_Organization_Others SET downloads=$newCount WHERE Reg_Org_id_Others=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#fo";</script>';
        }
       
        exit;
       
    }
}

//accreditation
if(isset($_GET['accreditation_files']))
{
$id = $_GET['accreditation_files'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblFacilityDetails_Accreditation WHERE Accreditation_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = '../facility_files_Folder/' . $file['Accreditation'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('../facility_files_Folder/' . $file['Accreditation']));
        readfile('companyDetailsFolder/' . $file['Accreditation']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblFacilityDetails_Accreditation SET downloads=$newCount WHERE Accreditation_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#CA";</script>';
        }
       
        exit;
       
    }
}

//Certification
if(isset($_GET['Certification_files']))
{
$id = $_GET['Certification_files'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblFacilityDetails_Certification WHERE Certification_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = '../facility_files_Folder/' . $file['Certification'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('../facility_files_Folder/' . $file['Certification']));
        readfile('companyDetailsFolder/' . $file['Certification']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblFacilityDetails_Certification SET downloads=$newCount WHERE Certification_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#CA";</script>';
        }
       
        exit;
       
    }
}
?>
