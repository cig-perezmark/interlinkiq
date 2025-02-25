<?php
include_once 'database.php';
if(isset($_GET['pathSole']))
{
$id = $_GET['pathSole'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['SolePropreitorship_File'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['SolePropreitorship_File']));
        readfile('companyDetailsFolder/' . $file['SolePropreitorship_File']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathGP']))
{
$id = $_GET['pathGP'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['GeneralPartnership_File'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['GeneralPartnership_File']));
        readfile('companyDetailsFolder/' . $file['GeneralPartnership_File']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathCorp']))
{
$id = $_GET['pathCorp'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['Corporation_File'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['Corporation_File']));
        readfile('companyDetailsFolder/' . $file['Corporation_File']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}

if(isset($_GET['pathLLC']))
{
$id = $_GET['pathLLC'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['LimitedLiabilityCompany_File'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['LimitedLiabilityCompany_File']));
        readfile('companyDetailsFolder/' . $file['LimitedLiabilityCompany_File']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathLP']))
{
$id = $_GET['pathLP'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['LimitedPartnership_File'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['LimitedPartnership_File']));
        readfile('companyDetailsFolder/' . $file['LimitedPartnership_File']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathLPP']))
{
$id = $_GET['pathLPP'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['LimitedLiabilityPartnership_File'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['LimitedLiabilityPartnership_File']));
        readfile('companyDetailsFolder/' . $file['LimitedLiabilityPartnership_File']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathOBS']))
{
$id = $_GET['pathOBS'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['otherbStructurefile'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['otherbStructurefile']));
        readfile('companyDetailsFolder/' . $file['otherbStructurefile']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathTN']))
{
$id = $_GET['pathTN'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['TrademarkNameFile'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['TrademarkNameFile']));
        readfile('companyDetailsFolder/' . $file['TrademarkNameFile']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathCSP']))
{
$id = $_GET['pathCSP'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['GFSIFILE'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['GFSIFILE']));
        readfile('companyDetailsFolder/' . $file['GFSIFILE']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathSQF']))
{
$id = $_GET['pathSQF'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['SQFFILE'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['SQFFILE']));
        readfile('companyDetailsFolder/' . $file['SQFFILE']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathBRC']))
{
$id = $_GET['pathBRC'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['BRCFILE'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['BRCFILE']));
        readfile('companyDetailsFolder/' . $file['BRCFILE']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathFSSC']))
{
$id = $_GET['pathFSSC'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['FSSC22000FILE'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['FSSC22000FILE']));
        readfile('companyDetailsFolder/' . $file['FSSC22000FILE']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathISO']))
{
$id = $_GET['pathISO'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['ISOFILE'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['ISOFILE']));
        readfile('companyDetailsFolder/' . $file['ISOFILE']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathPrimusGFS']))
{
$id = $_GET['pathPrimusGFS'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['PrimusGFSFILE'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['PrimusGFSFILE']));
        readfile('companyDetailsFolder/' . $file['PrimusGFSFILE']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathHACCP']))
{
$id = $_GET['pathHACCP'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['HACCPFILE'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['HACCPFILE']));
        readfile('companyDetailsFolder/' . $file['HACCPFILE']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathGMP']))
{
$id = $_GET['pathGMP'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['GMPFILE'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['GMPFILE']));
        readfile('companyDetailsFolder/' . $file['GMPFILE']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathcOther']))
{
$id = $_GET['pathcOther'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['OthersFILE'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['OthersFILE']));
        readfile('companyDetailsFolder/' . $file['OthersFILE']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathOrganic']))
{
$id = $_GET['pathOrganic'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['OrganicFile'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['OrganicFile']));
        readfile('companyDetailsFolder/' . $file['OrganicFile']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathHalal']))
{
$id = $_GET['pathHalal'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['HalalFile'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['HalalFile']));
        readfile('companyDetailsFolder/' . $file['HalalFile']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathKosher']))
{
$id = $_GET['pathKosher'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['KosherFile'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['KosherFile']));
        readfile('companyDetailsFolder/' . $file['KosherFile']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathNonGMO']))
{
$id = $_GET['pathNonGMO'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['NonGMOFile'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['NonGMOFile']));
        readfile('companyDetailsFolder/' . $file['NonGMOFile']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathPlantBased']))
{
$id = $_GET['pathPlantBased'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['PlantBasedFile'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['PlantBasedFile']));
        readfile('companyDetailsFolder/' . $file['PlantBasedFile']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathFAO']))
{
$id = $_GET['pathFAO'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['othersAccreditationFile'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['othersAccreditationFile']));
        readfile('companyDetailsFolder/' . $file['othersAccreditationFile']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathFDA']))
{
$id = $_GET['pathFDA'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['FDAfile'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['FDAfile']));
        readfile('companyDetailsFolder/' . $file['FDAfile']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathUSDA']))
{
$id = $_GET['pathUSDA'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['USDAfile'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['USDAfile']));
        readfile('companyDetailsFolder/' . $file['USDAfile']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathCRO']))
{
$id = $_GET['pathCRO'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails WHERE enterp_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['ComplianceRequirementsfile'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['ComplianceRequirementsfile']));
        readfile('companyDetailsFolder/' . $file['ComplianceRequirementsfile']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails SET downloads=$newCount WHERE enterp_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
if(isset($_GET['pathERF']))
{
$id = $_GET['pathERF'];

    // fetch file to download from database
    $sql = "SELECT * FROM tblEnterpiseDetails_Records WHERE rec_id =$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'companyDetailsFolder/' . $file['EnterpriseRecordsFile'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('companyDetailsFolder/' . $file['EnterpriseRecordsFile']));
        readfile('companyDetailsFolder/' . $file['EnterpriseRecordsFile']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE tblEnterpiseDetails_Records SET downloads=$newCount WHERE rec_id=$id";
        if(mysqli_query($conn, $updateQuery)){
            echo '<script> window.location.href = "enterprise-information#contactperson";</script>';
        }
       
        exit;
       
    }
}
?>
