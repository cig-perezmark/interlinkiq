<?php
include '../database.php';
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
 if (!empty($_COOKIE['switchAccount'])) {
	$portal_user = $_COOKIE['ID'];
	$user_id = $_COOKIE['switchAccount'];
}
else {
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
}
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
// add more contact person
if (isset($_POST['btnContactMore'])) { 
    $userID = $_COOKIE['ID'];
    $ids = $_POST['ids'];
    $contactpersonname = mysqli_real_escape_string($conn,$_POST['contactpersonname']);
    $contactpersonlastname = mysqli_real_escape_string($conn,$_POST['contactpersonlastname']);
    $titles = mysqli_real_escape_string($conn,$_POST['titles']);
    $contactpersoncellno = mysqli_real_escape_string($conn,$_POST['contactpersoncellno']);
    $contactpersonphone = mysqli_real_escape_string($conn,$_POST['contactpersonphone']);
    $contactpersonfax = mysqli_real_escape_string($conn,$_POST['contactpersonfax']);
    $contactpersonemailAddress = mysqli_real_escape_string($conn,$_POST['contactpersonemailAddress']);
    
    $sql = "INSERT INTO tblFacilityDetails_contact (contactpersonname,contactpersonlastname,titles,contactpersoncellno,contactpersonphone,contactpersonfax,contactpersonemailAddress,user_cookies,facility_entities) VALUES ('$contactpersonname','$contactpersonlastname','$titles','$contactpersoncellno','$contactpersonphone','$contactpersonfax','$contactpersonemailAddress','$user_id','$ids')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'";</script>';
    }
}
// for contact update
if (isset($_POST['btnContactMoreUpdate'])) { 
    $userID = $_POST['ID'];
   $ids = $_POST['ids'];
    $contactpersonname = mysqli_real_escape_string($conn,$_POST['contactpersonname']);
    $contactpersonlastname = mysqli_real_escape_string($conn,$_POST['contactpersonlastname']);
    $titles = mysqli_real_escape_string($conn,$_POST['titles']);
    $contactpersoncellno = mysqli_real_escape_string($conn,$_POST['contactpersoncellno']);
    $contactpersonphone = mysqli_real_escape_string($conn,$_POST['contactpersonphone']);
    $contactpersonfax = mysqli_real_escape_string($conn,$_POST['contactpersonfax']);
    $contactpersonemailAddress = mysqli_real_escape_string($conn,$_POST['contactpersonemailAddress']);
    
    mysqli_query($conn,"update tblFacilityDetails_contact set contactpersonname='$contactpersonname', contactpersonlastname='$contactpersonlastname', titles='$titles', contactpersoncellno='$contactpersoncellno', contactpersonphone='$contactpersonphone', contactpersonfax='$contactpersonfax', contactpersonemailAddress='$contactpersonemailAddress' where con_id='$userID'");  
     echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'";</script>';
}


// add more emergency contact person
if (isset($_POST['btnEmergencyMore'])) { 
    $userID = $_COOKIE['ID'];
    $ids = $_POST['ids'];
    $emergencyname = mysqli_real_escape_string($conn,$_POST['emergencyname']);
    $emergencycontact_last_name = mysqli_real_escape_string($conn,$_POST['emergencycontact_last_name']);
    $emergency_contact_title = mysqli_real_escape_string($conn,$_POST['emergency_contact_title']);
    $emergencycellno = mysqli_real_escape_string($conn,$_POST['emergencycellno']);
    $emergencyphone = mysqli_real_escape_string($conn,$_POST['emergencyphone']);
    $emergencyfax = mysqli_real_escape_string($conn,$_POST['emergencyfax']);
    $emergencyemailAddress = mysqli_real_escape_string($conn,$_POST['emergencyemailAddress']);
    
    $sql = "INSERT INTO tblFacilityDetails_Emergency (emergencyname,emergencycontact_last_name,emergency_contact_title,emergencycellno,emergencyphone,emergencyfax,emergencyemailAddress,user_cookies,emergency_contact_entities) VALUES ('$emergencyname','$emergencycontact_last_name','$emergency_contact_title','$emergencycellno','$emergencyphone','$emergencyfax','$emergencyemailAddress','$user_id','$ids')";
    if(mysqli_query($conn, $sql)){
         echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'";</script>';
    }
}

// for emergency contact update
if (isset($_POST['btnEmergencyMoreUpdate'])) { 
    $userID = $_POST['ID'];
   $ids = $_POST['ids'];
    $emergencyname = mysqli_real_escape_string($conn,$_POST['emergencyname']);
    $emergencycontact_last_name = mysqli_real_escape_string($conn,$_POST['emergencycontact_last_name']);
    $emergency_contact_title = mysqli_real_escape_string($conn,$_POST['emergency_contact_title']);
    $emergencycellno = mysqli_real_escape_string($conn,$_POST['emergencycellno']);
    $emergencyphone = mysqli_real_escape_string($conn,$_POST['emergencyphone']);
    $emergencyfax = mysqli_real_escape_string($conn,$_POST['emergencyfax']);
    $emergencyemailAddress = mysqli_real_escape_string($conn,$_POST['emergencyemailAddress']);
    
    mysqli_query($conn,"update tblFacilityDetails_Emergency set emergencyname='$emergencyname', emergencycontact_last_name='$emergencycontact_last_name', emergency_contact_title='$emergency_contact_title', emergencycellno='$emergencycellno', emergencyphone='$emergencyphone', emergencyfax='$emergencyfax', emergencyemailAddress='$emergencyemailAddress' where emerg_id='$userID'");  
      echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'";</script>';
}

// add Permits person
if (isset($_POST['btnPermits'])) { 
    $userID = $_COOKIE['ID'];
    $ids = $_POST['ids'];
    $file = $_FILES['Permits']['name'];
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $extension = end(explode(".", $_FILES['Permits']['name']));
    $Permits =  rand(10,1000000)." - ".$filename.".".$extension;
    move_uploaded_file($_FILES['Permits']['tmp_name'],'../facility_files_Folder/'.$Permits);
    $Type_s = mysqli_real_escape_string($conn,$_POST['Type_s']);
    $Descriptions = mysqli_real_escape_string($conn,$_POST['Descriptions']);
    $Issue_Date = mysqli_real_escape_string($conn,$_POST['Issue_Date']);
    $Expiration_Date = mysqli_real_escape_string($conn,$_POST['Expiration_Date']);
    
    $sql = "INSERT INTO tblFacilityDetails_Permits (Permits,Type_s,Descriptions,Issue_Date,Expiration_Date,user_cookies,facility_entities) VALUES ('$Permits','$Type_s','$Descriptions','$Issue_Date','$Expiration_Date','$user_id','$ids')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#fo";</script>';
    }
}

// add Accreditation
if (isset($_POST['btnAccreditation'])) { 
    $userID = $_COOKIE['ID'];
    $ids = $_POST['ids'];
    $file = $_FILES['Accreditation']['name'];
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $extension = end(explode(".", $_FILES['Accreditation']['name']));
    $Accreditation =  rand(10,1000000)." - ".$filename.".".$extension;
    move_uploaded_file($_FILES['Accreditation']['tmp_name'],'../facility_files_Folder/'.$Accreditation);
    
    $Type_Accreditation = mysqli_real_escape_string($conn,$_POST['Type_Accreditation']);
    $Descriptions_Accreditation = mysqli_real_escape_string($conn,$_POST['Descriptions_Accreditation']);
    $Issue_Date_Type_Accreditation = mysqli_real_escape_string($conn,$_POST['Issue_Date_Type_Accreditation']);
    $Expiration_Date_Type_Accreditation = mysqli_real_escape_string($conn,$_POST['Expiration_Date_Type_Accreditation']);
    
    $sql = "INSERT INTO tblFacilityDetails_Accreditation (Accreditation,Type_Accreditation,Descriptions_Accreditation,Issue_Date_Type_Accreditation,Expiration_Date_Type_Accreditation,user_cookies,facility_entities) VALUES ('$Accreditation','$Type_Accreditation','$Descriptions_Accreditation','$Issue_Date_Type_Accreditation','$Expiration_Date_Type_Accreditation','$user_id','$ids')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#CA";</script>';
    }
}

// add Certification
if (isset($_POST['btnCertification'])) { 
    $userID = $_COOKIE['ID'];
    $ids = $_POST['ids'];
    $file = $_FILES['Certification']['name'];
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $extension = end(explode(".", $_FILES['Certification']['name']));
    $Certification =  rand(10,1000000)." - ".$filename.".".$extension;
    move_uploaded_file($_FILES['Certification']['tmp_name'],'../facility_files_Folder/'.$Certification);
    
    $Type_Certification = mysqli_real_escape_string($conn,$_POST['Type_Certification']);
    $Descriptions_Certification = mysqli_real_escape_string($conn,$_POST['Descriptions_Certification']);
    $Issue_Date_Certification = mysqli_real_escape_string($conn,$_POST['Issue_Date_Certification']);
    $Expiration_Date_Certification = mysqli_real_escape_string($conn,$_POST['Expiration_Date_Certification']);
    
    $sql = "INSERT INTO tblFacilityDetails_Certification (Certification,Type_Certification,Descriptions_Certification,Issue_Date_Certification,Expiration_Date_Certification,user_cookies,facility_entities) VALUES ('$Certification','$Type_Certification','$Descriptions_Certification','$Issue_Date_Certification','$Expiration_Date_Certification','$user_id','$ids')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#CA";</script>';
    }
}
// add FDA Registration Organization
if (isset($_POST['btnRegistration_Organization_FDA'])) { 
    $userID = $_COOKIE['ID'];
    $ids = $_POST['ids'];
    $file = $_FILES['Reg_Org_Supporting_files_FDA']['name'];
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $extension = end(explode(".", $_FILES['Reg_Org_Supporting_files_FDA']['name']));
    $Reg_Org_Supporting_files_FDA =  rand(10,1000000)." - ".$filename.".".$extension;
    move_uploaded_file($_FILES['Reg_Org_Supporting_files_FDA']['tmp_name'],'../facility_files_Folder/'.$Reg_Org_Supporting_files_FDA);
    
    $Reg_Org_Certificate_name_FDA = mysqli_real_escape_string($conn,$_POST['Reg_Org_Certificate_name_FDA']);
    $Reg_Org_Registration_Date_FDA = mysqli_real_escape_string($conn,$_POST['Reg_Org_Registration_Date_FDA']);
    $Reg_Org_Expiry_Date_FDA = mysqli_real_escape_string($conn,$_POST['Reg_Org_Expiry_Date_FDA']);
    
    $sql = "INSERT INTO tblFacilityDetails_Registration_Organization_FDA (Reg_Org_Certificate_name_FDA,Reg_Org_Supporting_files_FDA,Reg_Org_Registration_Date_FDA,Reg_Org_Expiry_Date_FDA,user_entities,facility_entities) VALUES ('$Reg_Org_Certificate_name_FDA','$Reg_Org_Supporting_files_FDA','$Reg_Org_Registration_Date_FDA','$Reg_Org_Expiry_Date_FDA','$user_id','$ids')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#ro";</script>';
    }
}
// add USDA Registration Organization
if (isset($_POST['btnRegistration_Organization_USDA'])) { 
    $userID = $_COOKIE['ID'];
    $ids = $_POST['ids'];
    $file = $_FILES['Reg_Org_Supporting_files_USDA']['name'];
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $extension = end(explode(".", $_FILES['Reg_Org_Supporting_files_USDA']['name']));
    $Reg_Org_Supporting_files_USDA =  rand(10,1000000)." - ".$filename.".".$extension;
    move_uploaded_file($_FILES['Reg_Org_Supporting_files_USDA']['tmp_name'],'../facility_files_Folder/'.$Reg_Org_Supporting_files_USDA);
    
    $Reg_Org_Certificate_name_USDA = mysqli_real_escape_string($conn,$_POST['Reg_Org_Certificate_name_USDA']);
    $Reg_Org_Registration_Date_USDA = mysqli_real_escape_string($conn,$_POST['Reg_Org_Registration_Date_USDA']);
    $Reg_Org_Expiry_Date_USDA = mysqli_real_escape_string($conn,$_POST['Reg_Org_Expiry_Date_USDA']);
    
    $sql = "INSERT INTO tblFacilityDetails_Registration_Organization_USDA (Reg_Org_Certificate_name_USDA,Reg_Org_Supporting_files_USDA,Reg_Org_Registration_Date_USDA,Reg_Org_Expiry_Date_USDA,user_entities,facility_entities) VALUES ('$Reg_Org_Certificate_name_USDA','$Reg_Org_Supporting_files_USDA','$Reg_Org_Registration_Date_USDA','$Reg_Org_Expiry_Date_USDA','$user_id','$ids')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#ro";</script>';
    }
}
// add Others Registration Organization
if (isset($_POST['btnRegistration_Organization_Others'])) { 
    $userID = $_COOKIE['ID'];
    $ids = $_POST['ids'];
    $file = $_FILES['Reg_Org_Supporting_files_Others']['name'];
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $extension = end(explode(".", $_FILES['Reg_Org_Supporting_files_Others']['name']));
    $Reg_Org_Supporting_files_Others =  rand(10,1000000)." - ".$filename.".".$extension;
    move_uploaded_file($_FILES['Reg_Org_Supporting_files_Others']['tmp_name'],'../facility_files_Folder/'.$Reg_Org_Supporting_files_Others);
    
    $Reg_Org_Certificate_name_Others = mysqli_real_escape_string($conn,$_POST['Reg_Org_Certificate_name_Others']);
    $Reg_Org_Registration_Date_Others = mysqli_real_escape_string($conn,$_POST['Reg_Org_Registration_Date_Others']);
    $Reg_Org_Expiry_Date_Others = mysqli_real_escape_string($conn,$_POST['Reg_Org_Expiry_Date_Others']);
    
    $sql = "INSERT INTO tblFacilityDetails_Registration_Organization_Others (Reg_Org_Certificate_name_Others,Reg_Org_Supporting_files_Others,Reg_Org_Registration_Date_Others,Reg_Org_Expiry_Date_Others,user_entities,facility_entities) VALUES ('$Reg_Org_Certificate_name_Others','$Reg_Org_Supporting_files_Others','$Reg_Org_Registration_Date_Others','$Reg_Org_Expiry_Date_Others','$user_id','$ids')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#ro";</script>';
    }
}

// add  Facility Organization
if (isset($_POST['btnOrganizationMore'])) { 
    $userID = $_COOKIE['ID'];
    $ids = $_POST['ids'];
    
    $Organization_name = mysqli_real_escape_string($conn,$_POST['Organization_name']);
    $Organization_last_name = mysqli_real_escape_string($conn,$_POST['Organization_last_name']);
    $Organization_title = mysqli_real_escape_string($conn,$_POST['Organization_title']);
    $Organization_cellno = mysqli_real_escape_string($conn,$_POST['Organization_cellno']);
    $Organization_phone = mysqli_real_escape_string($conn,$_POST['Organization_phone']);
    $Organization_emailAddress = mysqli_real_escape_string($conn,$_POST['Organization_emailAddress']);
    
    $sql = "INSERT INTO tblFacilityDetails_Facility_Organization (Organization_name,Organization_last_name,Organization_title,Organization_cellno,Organization_phone,Organization_emailAddress,user_entities,facility_entities) VALUES ('$Organization_name','$Organization_last_name','$Organization_title','$Organization_cellno','$Organization_phone','$Organization_emailAddress','$user_id','$ids')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#ro";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// add  Service_Team
if (isset($_POST['btnService_Team'])) { 
    $userID = $_COOKIE['ID'];
    $ids = $_POST['ids'];
    
    $Service_Team_name = mysqli_real_escape_string($conn,$_POST['Service_Team_name']);
    $Service_Team_last_name = mysqli_real_escape_string($conn,$_POST['Service_Team_last_name']);
    $Service_Team_title = mysqli_real_escape_string($conn,$_POST['Service_Team_title']);
    $Service_Team_cellno = mysqli_real_escape_string($conn,$_POST['Service_Team_cellno']);
    $Service_Team_phone = mysqli_real_escape_string($conn,$_POST['Service_Team_phone']);
    $Service_Team_emailAddress = mysqli_real_escape_string($conn,$_POST['Service_Team_emailAddress']);
    
    $sql = "INSERT INTO tblFacilityDetails_Service_Team (Service_Team_name,Service_Team_last_name,Service_Team_title,Service_Team_cellno,Service_Team_phone,Service_Team_emailAddress,user_entities,facility_entities) VALUES ('$Service_Team_name','$Service_Team_last_name','$Service_Team_title','$Service_Team_cellno','$Service_Team_phone','$Service_Team_emailAddress','$user_id','$ids')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#cc";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
