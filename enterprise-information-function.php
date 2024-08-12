<?php
include_once 'database.php';
$local_date = date('Y-m-d');
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
// add New

if (isset($_POST['submitEmp_Details'])) { 
    // $userID = $_COOKIE['ID'];
    if (isset($_COOKIE['switchAccount'])) { $userID = $_COOKIE['switchAccount']; }
    else { $userID = $_COOKIE['ID']; }
    
    $businessname = mysqli_real_escape_string($conn,$_POST['LegalNameUpdate']);
    $country = mysqli_real_escape_string($conn,$_POST['country']);
    $Bldg = mysqli_real_escape_string($conn,$_POST['Bldg']);
    $city = mysqli_real_escape_string($conn,$_POST['city']);
    $States = mysqli_real_escape_string($conn,$_POST['States']);
    $ZipCode = mysqli_real_escape_string($conn,$_POST['ZipCode']);
    $businesstelephone = mysqli_real_escape_string($conn,$_POST['businesstelephone']);
    $businessfax = mysqli_real_escape_string($conn,$_POST['businessfax']);
    $mailer = mysqli_real_escape_string($conn,$_POST['businessemailAddress']);
    $businesswebsite = mysqli_real_escape_string($conn,$_POST['businesswebsite']);
    $businessemailAddress = str_replace(' ', '', $mailer);
    
    mysqli_query($conn,"update tblEnterpiseDetails set businessname ='$businessname', country='$country', Bldg='$Bldg', city='$city', States='$States', ZipCode='$ZipCode', businesstelephone='$businesstelephone', businessfax='$businessfax', businessemailAddress='$businessemailAddress', businesswebsite='$businesswebsite' where users_entities='$user_id'");  
     echo '<script> window.location.href = "enterprise-info";</script>';
}


// for contact update
if (isset($_POST['btnContactMoreUpdate'])) { 
    $userID = $_POST['ID'];
   
    $contactpersonname = mysqli_real_escape_string($conn,$_POST['contactpersonname']);
    $contactpersonlastname = mysqli_real_escape_string($conn,$_POST['contactpersonlastname']);
    $titles = mysqli_real_escape_string($conn,$_POST['titles']);
    $contactpersoncellno = mysqli_real_escape_string($conn,$_POST['contactpersoncellno']);
    $contactpersonphone = mysqli_real_escape_string($conn,$_POST['contactpersonphone']);
    $contactpersonfax = mysqli_real_escape_string($conn,$_POST['contactpersonfax']);
    $contactpersonemailAddress = mysqli_real_escape_string($conn,$_POST['contactpersonemailAddress']);
    
    mysqli_query($conn,"update tblEnterpiseDetails_Contact set contactpersonname='$contactpersonname', contactpersonlastname='$contactpersonlastname', titles='$titles', contactpersoncellno='$contactpersoncellno', contactpersonphone='$contactpersonphone', contactpersonfax='$contactpersonfax', contactpersonemailAddress='$contactpersonemailAddress' where con_id='$userID'");  
     echo '<script> window.location.href = "enterprise-info";</script>';
}
// for add facility
if(isset($_POST['btnFacilityMore'])){
    $userID = $_COOKIE['ID'];
    $facility_category = mysqli_real_escape_string($conn,$_POST['facility_category']);
     $sql = "INSERT INTO tblFacilityDetails (facility_category,users_entities) VALUES ('$facility_category','$user_id')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "enterprise-info#ED";</script>';
    }
}
// for emergency contact update
if (isset($_POST['btnEmergencyMoreUpdate'])) { 
    $userID = $_POST['ID'];
   
    $emergencyname = mysqli_real_escape_string($conn,$_POST['emergencyname']);
    $emergencycontact_last_name = mysqli_real_escape_string($conn,$_POST['emergencycontact_last_name']);
    $emergency_contact_title = mysqli_real_escape_string($conn,$_POST['emergency_contact_title']);
    $emergencycellno = mysqli_real_escape_string($conn,$_POST['emergencycellno']);
    $emergencyphone = mysqli_real_escape_string($conn,$_POST['emergencyphone']);
    $emergencyfax = mysqli_real_escape_string($conn,$_POST['emergencyfax']);
    $emergencyemailAddress = mysqli_real_escape_string($conn,$_POST['emergencyemailAddress']);
    
    mysqli_query($conn,"update tblEnterpiseDetails_Emergency set emergencyname='$emergencyname', emergencycontact_last_name='$emergencycontact_last_name', emergency_contact_title='$emergency_contact_title', emergencycellno='$emergencycellno', emergencyphone='$emergencyphone', emergencyfax='$emergencyfax', emergencyemailAddress='$emergencyemailAddress' where emerg_id='$userID'");  
    echo '<script> window.location.href = "enterprise-info";</script>';
}
if (isset($_POST['btnPrivatePatrolMoreUpdate'])) { 
    $ID = $_POST['ID'];
   
    $first_name = mysqli_real_escape_string($conn,$_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn,$_POST['last_name']);
    $title = mysqli_real_escape_string($conn,$_POST['title']);
    $cell = mysqli_real_escape_string($conn,$_POST['cell']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $fax = mysqli_real_escape_string($conn,$_POST['fax']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    
    mysqli_query($conn,"UPDATE tblEnterpiseDetails_PrivatePatrol set first_name='$first_name', last_name='$last_name', title='$title', cell='$cell', phone='$phone', fax='$fax', email='$email' WHERE ID='$ID'");  
    echo '<script> window.location.href = "enterprise-info";</script>';
}
if (isset($_POST['btnTrademarkUpdate'])) { 
    $ID = $_POST['ID'];
   
    $trademark_name = $_POST['trademark_name'];
    $trade_name = $_POST['trade_name'];
    
	$files = $_FILES['file']['name'];
	if (!empty($files)) {
		$path = 'uploads/enterprise/';
		$tmp = $_FILES['file']['tmp_name'];
		$files = rand(1000,1000000) . ' - ' . $files;
		$path = $path.$files;
		move_uploaded_file($tmp,$path);
	}
    
    mysqli_query($conn,"UPDATE tblEnterpiseDetails_Trademark set trademark_name='$trademark_name', trade_name='$trade_name', files='$files', last_modified='$local_date' WHERE ID='$ID'");  
    echo '<script> window.location.href = "enterprise-info";</script>';
}
if (isset($_POST['btnAccountUpdate'])) { 
    $ID = $_POST['ID'];
   
    $description = $_POST['description'];
    $url = $_POST['url'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remark = $_POST['remark'];
    
    mysqli_query($conn,"UPDATE tblEnterpiseDetails_Account set description='$description', url='$url', username='$username', password='$password', remark='$remark' WHERE ID='$ID'");  
    echo '<script> window.location.href = "enterprise-info";</script>';
}

if (isset($_POST['emerg_id'])) { 
    // $userID = $_COOKIE['ID'];
    if (isset($_COOKIE['switchAccount'])) { $userID = $_COOKIE['switchAccount']; }
    else { $userID = $_COOKIE['ID']; }
    
    $contactpersonname = mysqli_real_escape_string($conn,$_POST['contactpersonname']);
    $contactpersonlastname = mysqli_real_escape_string($conn,$_POST['contactpersonlastname']);
    $titles = mysqli_real_escape_string($conn,$_POST['titles']);
    $contactpersoncellno = mysqli_real_escape_string($conn,$_POST['contactpersoncellno']);
    $contactpersonphone = mysqli_real_escape_string($conn,$_POST['contactpersonphone']);
    $contactpersonfax = mysqli_real_escape_string($conn,$_POST['contactpersonfax']);
    $contactpersonemailAddress = mysqli_real_escape_string($conn,$_POST['contactpersonemailAddress']);
    $emergencyname = mysqli_real_escape_string($conn,$_POST['emergencyname']);
    $emergencycontact_last_name = mysqli_real_escape_string($conn,$_POST['emergencycontact_last_name']);
    $emergency_contact_title = mysqli_real_escape_string($conn,$_POST['emergency_contact_title']);
    $emergencycellno = mysqli_real_escape_string($conn,$_POST['emergencycellno']);
    $emergencyphone = mysqli_real_escape_string($conn,$_POST['emergencyphone']);
    $emergencyfax = mysqli_real_escape_string($conn,$_POST['emergencyfax']);
    $emergencyemailAddress = mysqli_real_escape_string($conn,$_POST['emergencyemailAddress']);
    
    mysqli_query($conn,"update tblEnterpiseDetails set contactpersonname='$contactpersonname', contactpersonlastname='$contactpersonlastname', title='$titles', contactpersoncellno='$contactpersoncellno', contactpersonphone='$contactpersonphone', contactpersonfax='$contactpersonfax', contactpersonemailAddress='$contactpersonemailAddress', emergencyname='$emergencyname', emergencycontact_last_name='$emergencycontact_last_name', emergency_contact_title='$emergency_contact_title', emergencycellno='$emergencycellno', emergencyphone='$emergencyphone', emergencyfax='$emergencyfax', emergencyemailAddress='$emergencyemailAddress' where users_entities='$user_id'");  
     echo '<script> window.location.href = "enterprise-info";</script>';
}


// add more contact person
if (isset($_POST['btnContactMore'])) { 
    // $userID = $_COOKIE['ID'];
    if (isset($_COOKIE['switchAccount'])) { $userID = $_COOKIE['switchAccount']; }
    else { $userID = $_COOKIE['ID']; }
    
    $contactpersonname = mysqli_real_escape_string($conn,$_POST['contactpersonname']);
    $contactpersonlastname = mysqli_real_escape_string($conn,$_POST['contactpersonlastname']);
    $titles = mysqli_real_escape_string($conn,$_POST['titles']);
    $contactpersoncellno = mysqli_real_escape_string($conn,$_POST['contactpersoncellno']);
    $contactpersonphone = mysqli_real_escape_string($conn,$_POST['contactpersonphone']);
    $contactpersonfax = mysqli_real_escape_string($conn,$_POST['contactpersonfax']);
    $contactpersonemailAddress = mysqli_real_escape_string($conn,$_POST['contactpersonemailAddress']);
    
    $sql = "INSERT INTO tblEnterpiseDetails_Contact (contactpersonname,contactpersonlastname,titles,contactpersoncellno,contactpersonphone,contactpersonfax,contactpersonemailAddress,user_cookies) VALUES ('$contactpersonname','$contactpersonlastname','$titles','$contactpersoncellno','$contactpersonphone','$contactpersonfax','$contactpersonemailAddress','$user_id')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "enterprise-info";</script>';
    }
}

// add more private patrol contact person
if (isset($_POST['btnPrivatePatrolMore'])) { 
    // $userID = $_COOKIE['ID'];
    if (isset($_COOKIE['switchAccount'])) { $userID = $_COOKIE['switchAccount']; }
    else { $userID = $_COOKIE['ID']; }
    
    $first_name = mysqli_real_escape_string($conn,$_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn,$_POST['last_name']);
    $title = mysqli_real_escape_string($conn,$_POST['title']);
    $cell = mysqli_real_escape_string($conn,$_POST['cell']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $fax = mysqli_real_escape_string($conn,$_POST['fax']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    
    $sql = "INSERT INTO tblEnterpiseDetails_PrivatePatrol (user_id, portal_user, first_name, last_name, title, cell, phone, fax, email) 
    VALUES ('$user_id', '$portal_user', '$first_name', '$last_name', '$title', '$cell', '$phone', '$fax', '$email')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "enterprise-info";</script>';
    }
}
if (isset($_POST['btnTrademarks'])) { 
    if (isset($_COOKIE['switchAccount'])) { $userID = $_COOKIE['switchAccount']; }
    else { $userID = $_COOKIE['ID']; }
    
    $trademark_name = mysqli_real_escape_string($conn,$_POST['trademark_name']);
    $trade_name = mysqli_real_escape_string($conn,$_POST['trade_name']);
    
	$files = $_FILES['file']['name'];
	if (!empty($files)) {
		$path = 'uploads/enterprise/';
		$tmp = $_FILES['file']['tmp_name'];
		$files = rand(1000,1000000) . ' - ' . $files;
		$path = $path.$files;
		move_uploaded_file($tmp,$path);
	}
    
    $sql = "INSERT INTO tblEnterpiseDetails_Trademark (user_id, portal_user, trademark_name, trade_name, filesm last_modified)
    VALUES ('$user_id', '$portal_user', '$trademark_name', '$trade_name', '$files', '$local_date')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "enterprise-info";</script>';
    }
    // echo $sql;
    // echo '<script> window.location.href = "enterprise-info";</script>';
}
if (isset($_POST['btnAccounts'])) { 
    if (isset($_COOKIE['switchAccount'])) { $userID = $_COOKIE['switchAccount']; }
    else { $userID = $_COOKIE['ID']; }
    
    $description = mysqli_real_escape_string($conn,$_POST['description']);
    $url = mysqli_real_escape_string($conn,$_POST['url']);
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $remark = mysqli_real_escape_string($conn,$_POST['remark']);
    
    $sql = "INSERT INTO tblEnterpiseDetails_Account (user_id, portal_user, description, url, username, password, remark)
    VALUES ('$user_id', '$portal_user', '$description', '$url', '$username', '$password', '$remark')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "enterprise-info";</script>';
    }
}
// add more emergency contact person
if (isset($_POST['btnEmergencyMore'])) { 
    // $userID = $_COOKIE['ID'];
    if (isset($_COOKIE['switchAccount'])) { $userID = $_COOKIE['switchAccount']; }
    else { $userID = $_COOKIE['ID']; }
    
    $emergencyname = mysqli_real_escape_string($conn,$_POST['emergencyname']);
    $emergencycontact_last_name = mysqli_real_escape_string($conn,$_POST['emergencycontact_last_name']);
    $emergency_contact_title = mysqli_real_escape_string($conn,$_POST['emergency_contact_title']);
    $emergencycellno = mysqli_real_escape_string($conn,$_POST['emergencycellno']);
    $emergencyphone = mysqli_real_escape_string($conn,$_POST['emergencyphone']);
    $emergencyfax = mysqli_real_escape_string($conn,$_POST['emergencyfax']);
    $emergencyemailAddress = mysqli_real_escape_string($conn,$_POST['emergencyemailAddress']);
    
    $sql = "INSERT INTO tblEnterpiseDetails_Emergency (emergencyname,emergencycontact_last_name,emergency_contact_title,emergencycellno,emergencyphone,emergencyfax,emergencyemailAddress,user_cookies) VALUES ('$emergencyname','$emergencycontact_last_name','$emergency_contact_title','$emergencycellno','$emergencyphone','$emergencyfax','$emergencyemailAddress','$user_id')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "enterprise-info";</script>';
    }
}

// add Enterprise Record
if(isset($_POST["submitERFS"])) {
    // $userID = $_COOKIE['ID'];
    if (isset($_COOKIE['switchAccount'])) { $userID = $_COOKIE['switchAccount']; }
    else { $userID = $_COOKIE['ID']; }
    
    $DocumentTitle = mysqli_real_escape_string($conn,$_POST['DocumentTitle']);
    $DocumentDesciption = mysqli_real_escape_string($conn,$_POST['DocumentDesciption']);
    $DocumentDueDate = mysqli_real_escape_string($conn,$_POST['DocumentDueDate']);
    $file = $_FILES['EnterpriseRecordsFile']['name'];
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $extension = end(explode(".", $_FILES['EnterpriseRecordsFile']['name']));
    $EnterpriseRecordsFile =  rand(10,1000000)." - ".$filename.".".$extension;
    move_uploaded_file($_FILES['EnterpriseRecordsFile']['tmp_name'],'companyDetailsFolder/'.$EnterpriseRecordsFile);
    $sql = "INSERT INTO tblEnterpiseDetails_Records (EnterpriseRecordsFile,DocumentTitle,DocumentDesciption,DocumentDueDate,user_cookies) VALUES ('$EnterpriseRecordsFile','$DocumentTitle','$DocumentDesciption','$DocumentDueDate','$user_id')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "enterprise-info#Rec";</script>';
    }else{
        echo "error";
    }
}
// Update Enterprise Record
if(isset($_POST["submitERFUpdate"])) {
    if(empty($file = $_FILES['EnterpriseRecordsFile']['name'])){
        $ID = $_POST['ID'];
        $DocumentTitle = mysqli_real_escape_string($conn,$_POST['DocumentTitle']);
        $DocumentDesciption = mysqli_real_escape_string($conn,$_POST['DocumentDesciption']);
        $DocumentDueDate = mysqli_real_escape_string($conn,$_POST['DocumentDueDate']);
        mysqli_query($conn,"update tblEnterpiseDetails_Records set DocumentTitle ='$DocumentTitle', DocumentDesciption ='$DocumentDesciption', DocumentDueDate ='$DocumentDueDate' where rec_id='$ID'");  
        echo '<script> window.location.href = "enterprise-info#Rec";</script>';
    }else{  
        $ID = $_POST['ID'];
        $DocumentTitle = mysqli_real_escape_string($conn,$_POST['DocumentTitle']);
        $DocumentDesciption = mysqli_real_escape_string($conn,$_POST['DocumentDesciption']);
        $DocumentDueDate = mysqli_real_escape_string($conn,$_POST['DocumentDueDate']);
        $file = $_FILES['EnterpriseRecordsFile']['name'];
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['EnterpriseRecordsFile']['name']));
        $EnterpriseRecordsFile =  rand(10,1000000)." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['EnterpriseRecordsFile']['tmp_name'],'companyDetailsFolder/'.$EnterpriseRecordsFile);
        mysqli_query($conn,"update tblEnterpiseDetails_Records set EnterpriseRecordsFile ='$EnterpriseRecordsFile', DocumentTitle ='$DocumentTitle', DocumentDesciption ='$DocumentDesciption', DocumentDueDate ='$DocumentDueDate' where rec_id='$ID'");  
        echo '<script> window.location.href = "enterprise-info#Rec";</script>';
    }
}
   
//update
if (isset($_GET['id']) && isset($_GET['LegalNameUpdate'])) {  
      $id=$_GET['id'];
      $businessname =$_GET['LegalNameUpdate'];   
      mysqli_query($conn,"update tblEnterpiseDetails set businessname ='$businessname' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info";</script>';
 }
if (isset($_GET['id']) && isset($_GET['country'])) {  
      $id=$_GET['id'];
      $country =$_GET['country'];   
      mysqli_query($conn,"update tblEnterpiseDetails set country ='$country' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['Bldg'])) {  
      $id=$_GET['id'];
      $Bldg =$_GET['Bldg'];   
      mysqli_query($conn,"update tblEnterpiseDetails set Bldg ='$Bldg' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['city'])) {  
      $id=$_GET['id'];
      $city =$_GET['city'];   
      mysqli_query($conn,"update tblEnterpiseDetails set city ='$city' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['States'])) {  
      $id=$_GET['id'];
      $States =$_GET['States'];   
      mysqli_query($conn,"update tblEnterpiseDetails set States ='$States' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['ZipCode'])) {  
      $id=$_GET['id'];
      $ZipCode =$_GET['ZipCode'];   
      mysqli_query($conn,"update tblEnterpiseDetails set ZipCode ='$ZipCode' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['ZipCode'])) {  
      $id=$_GET['id'];
      $ZipCode =$_GET['ZipCode'];   
      mysqli_query($conn,"update tblEnterpiseDetails set ZipCode ='$ZipCode' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info";</script>';
 }
  if (isset($_GET['id']) && isset($_GET['businesstelephone'])) {  
      $id=$_GET['id'];
      $businesstelephone =$_GET['businesstelephone'];   
      mysqli_query($conn,"update tblEnterpiseDetails set businesstelephone ='$businesstelephone' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['businessfax'])) {  
      $id=$_GET['id'];
      $businessfax =$_GET['businessfax'];   
      mysqli_query($conn,"update tblEnterpiseDetails set businessfax ='$businessfax' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info";</script>';
 }
  if (isset($_GET['id']) && isset($_GET['businessemailAddress'])) {  
      $id=$_GET['id'];
      $businessemailAddress =$_GET['businessemailAddress'];   
      mysqli_query($conn,"update tblEnterpiseDetails set businessemailAddress ='$businessemailAddress' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['businesswebsite'])) {  
      $id=$_GET['id'];
      $businesswebsite =$_GET['businesswebsite'];   
      mysqli_query($conn,"update tblEnterpiseDetails set businesswebsite ='$businesswebsite' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['contactpersonname'])) {  
      $id=$_GET['id'];
      $contactpersonname =$_GET['contactpersonname'];   
      mysqli_query($conn,"update tblEnterpiseDetails set contactpersonname ='$contactpersonname' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#contactperson";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['contactpersonlastname'])) {  
      $id=$_GET['id'];
      $contactpersonlastname =$_GET['contactpersonlastname'];   
      mysqli_query($conn,"update tblEnterpiseDetails set contactpersonlastname ='$contactpersonlastname' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#contactperson";</script>';
 }
  if (isset($_GET['id']) && isset($_GET['titles'])) {  
      $id=$_GET['id'];
      $title =$_GET['titles'];   
      mysqli_query($conn,"update tblEnterpiseDetails set title ='$title' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#contactperson";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['contactpersoncellno'])) {  
      $id=$_GET['id'];
      $contactpersoncellno =$_GET['contactpersoncellno'];   
      mysqli_query($conn,"update tblEnterpiseDetails set contactpersoncellno ='$contactpersoncellno' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#contactperson";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['contactpersonphone'])) {  
      $id=$_GET['id'];
      $contactpersonphone =$_GET['contactpersonphone'];   
      mysqli_query($conn,"update tblEnterpiseDetails set contactpersonphone ='$contactpersonphone' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#contactperson";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['contactpersonfax'])) {  
      $id=$_GET['id'];
      $contactpersonfax =$_GET['contactpersonfax'];   
      mysqli_query($conn,"update tblEnterpiseDetails set contactpersonfax ='$contactpersonfax' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#contactperson";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['contactpersonfax'])) {  
      $id=$_GET['id'];
      $contactpersonfax =$_GET['contactpersonfax'];   
      mysqli_query($conn,"update tblEnterpiseDetails set contactpersonfax ='$contactpersonfax' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#contactperson";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['emergencyname'])) {  
      $id=$_GET['id'];
      $emergencyname =$_GET['emergencyname'];   
      mysqli_query($conn,"update tblEnterpiseDetails set emergencyname ='$emergencyname' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#contactperson";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['emergencycontact_last_name'])) {  
      $id=$_GET['id'];
      $emergencycontact_last_name =$_GET['emergencycontact_last_name'];   
      mysqli_query($conn,"update tblEnterpiseDetails set emergencycontact_last_name ='$emergencycontact_last_name' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#contactperson";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['emergency_contact_title'])) {  
      $id=$_GET['id'];
      $emergency_contact_title =$_GET['emergency_contact_title'];   
      mysqli_query($conn,"update tblEnterpiseDetails set emergency_contact_title ='$emergency_contact_title' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#contactperson";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['emergencycellno'])) {  
      $id=$_GET['id'];
      $emergencycellno =$_GET['emergencycellno'];   
      mysqli_query($conn,"update tblEnterpiseDetails set emergencycellno ='$emergencycellno' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#contactperson";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['emergencyphone'])) {  
      $id=$_GET['id'];
      $emergencyphone =$_GET['emergencyphone'];   
      mysqli_query($conn,"update tblEnterpiseDetails set emergencyphone ='$emergencyphone' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#contactperson";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['emergencyfax'])) {  
      $id=$_GET['id'];
      $emergencyfax =$_GET['emergencyfax'];   
      mysqli_query($conn,"update tblEnterpiseDetails set emergencyfax ='$emergencyfax' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#contactperson";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['emergencyemailAddress'])) {  
      $id=$_GET['id'];
      $emergencyemailAddress =$_GET['emergencyemailAddress'];   
      mysqli_query($conn,"update tblEnterpiseDetails set emergencyemailAddress ='$emergencyemailAddress' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#contactperson";</script>';
 }

 
if (isset($_GET['id']) && isset($_GET['contactpersonemailAddress'])) {  
      $id=$_GET['id'];
      $contactpersonemailAddress =$_GET['contactpersonemailAddress'];   
      mysqli_query($conn,"update tblEnterpiseDetails set contactpersonemailAddress ='$contactpersonemailAddress' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#contactperson";</script>';
 }
 if(isset($_POST["submitSole"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['SolePropreitorship_File']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['SolePropreitorship_File']['name']));
          $SolePropreitorship_File =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['SolePropreitorship_File']['tmp_name'],'companyDetailsFolder/'.$SolePropreitorship_File);
          mysqli_query($conn,"update tblEnterpiseDetails set SolePropreitorship_File ='$SolePropreitorship_File' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#BS";</script>';
}
if (isset($_GET['id']) && isset($_GET['SolePropreitorship'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['SolePropreitorship'])){
          $SolePropreitorship = $_GET['SolePropreitorship'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set SolePropreitorship ='$SolePropreitorship' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
      else{
          $SolePropreitorship = '';
           mysqli_query($conn,"update tblEnterpiseDetails set SolePropreitorship ='$SolePropreitorship' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
      
 }
 if(isset($_POST["submitGP"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['GeneralPartnership_File']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['GeneralPartnership_File']['name']));
          $GeneralPartnership_File =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['GeneralPartnership_File']['tmp_name'],'companyDetailsFolder/'.$GeneralPartnership_File);
          mysqli_query($conn,"update tblEnterpiseDetails set GeneralPartnership_File ='$GeneralPartnership_File' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#BS";</script>';
}
if (isset($_GET['id']) && isset($_GET['GeneralPartnership'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['GeneralPartnership'])){
          $GeneralPartnership = $_GET['GeneralPartnership'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set GeneralPartnership ='$GeneralPartnership' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
      else{
          $GeneralPartnership = '';
           mysqli_query($conn,"update tblEnterpiseDetails set GeneralPartnership ='$GeneralPartnership' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
 }
 if(isset($_POST["submitCorp"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['Corporation_File']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['Corporation_File']['name']));
          $Corporation_File =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['Corporation_File']['tmp_name'],'companyDetailsFolder/'.$Corporation_File);
          mysqli_query($conn,"update tblEnterpiseDetails set Corporation_File ='$Corporation_File' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#BS";</script>';
}
if (isset($_GET['id']) && isset($_GET['Corporation'])) {  
      $id=$_GET['id'];
     if(!empty($_GET['Corporation'])){
          $Corporation = $_GET['Corporation'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Corporation ='$Corporation' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
      else{
          $Corporation = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Corporation ='$Corporation' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
 }
 if(isset($_POST["submitLLC"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['LimitedLiabilityCompany_File']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['LimitedLiabilityCompany_File']['name']));
          $LimitedLiabilityCompany_File =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['LimitedLiabilityCompany_File']['tmp_name'],'companyDetailsFolder/'.$LimitedLiabilityCompany_File);
          mysqli_query($conn,"update tblEnterpiseDetails set LimitedLiabilityCompany_File ='$LimitedLiabilityCompany_File' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#BS";</script>';
}
if (isset($_GET['id']) && isset($_GET['LimitedLiabilityCompany'])) {  
      $id=$_GET['id'];
     if(!empty($_GET['LimitedLiabilityCompany'])){
          $LimitedLiabilityCompany = $_GET['LimitedLiabilityCompany'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set LimitedLiabilityCompany ='$LimitedLiabilityCompany' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
      else{
          $LimitedLiabilityCompany = '';
           mysqli_query($conn,"update tblEnterpiseDetails set LimitedLiabilityCompany ='$LimitedLiabilityCompany' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
 }

if(isset($_POST["submitLP"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['LimitedPartnership_File']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['LimitedPartnership_File']['name']));
          $LimitedPartnership_File =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['LimitedPartnership_File']['tmp_name'],'companyDetailsFolder/'.$LimitedPartnership_File);
          mysqli_query($conn,"update tblEnterpiseDetails set LimitedPartnership_File ='$LimitedPartnership_File' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#BS";</script>';
}
if (isset($_GET['id']) && isset($_GET['LimitedPartnership'])) {  
      $id=$_GET['id'];
     if(!empty($_GET['LimitedPartnership'])){
          $LimitedPartnership = $_GET['LimitedPartnership'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set LimitedPartnership ='$LimitedPartnership' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
      else{
          $LimitedPartnership = '';
           mysqli_query($conn,"update tblEnterpiseDetails set LimitedPartnership ='$LimitedPartnership' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
 }
 
 if(isset($_POST["submitLPP"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['LimitedLiabilityPartnership_File']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['LimitedLiabilityPartnership_File']['name']));
          $LimitedLiabilityPartnership_File =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['LimitedLiabilityPartnership_File']['tmp_name'],'companyDetailsFolder/'.$LimitedLiabilityPartnership_File);
          mysqli_query($conn,"update tblEnterpiseDetails set LimitedLiabilityPartnership_File ='$LimitedLiabilityPartnership_File' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#BS";</script>';
}
if (isset($_GET['id']) && isset($_GET['LimitedLiabilityPartnership'])) {  
      $id=$_GET['id'];
     if(!empty($_GET['LimitedLiabilityPartnership'])){
          $LimitedLiabilityPartnership = $_GET['LimitedLiabilityPartnership'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set LimitedLiabilityPartnership ='$LimitedLiabilityPartnership' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
      else{
          $LimitedLiabilityPartnership = '';
           mysqli_query($conn,"update tblEnterpiseDetails set LimitedLiabilityPartnership ='$LimitedLiabilityPartnership' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
 }
 if(isset($_POST["submitOBS"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['otherbStructurefile']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['otherbStructurefile']['name']));
          $otherbStructurefile =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['otherbStructurefile']['tmp_name'],'companyDetailsFolder/'.$otherbStructurefile);
          mysqli_query($conn,"update tblEnterpiseDetails set otherbStructurefile ='$otherbStructurefile' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#BS";</script>';
}
if (isset($_GET['id']) && isset($_GET['othersBusinessStructure'])) {  
      $id=$_GET['id'];
     if(!empty($_GET['othersBusinessStructure'])){
          $othersBusinessStructure = $_GET['othersBusinessStructure'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set othersBusinessStructure ='$othersBusinessStructure' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
      else{
          $othersBusinessStructure = '';
           mysqli_query($conn,"update tblEnterpiseDetails set othersBusinessStructure ='$othersBusinessStructure' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['BusinessStructureSpecify'])) {  
      $id=$_GET['id'];
      $BusinessStructureSpecify =$_GET['BusinessStructureSpecify'];   
      mysqli_query($conn,"update tblEnterpiseDetails set BusinessStructureSpecify ='$BusinessStructureSpecify' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#BS";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['BusinessPurpose'])) {  
      $id=$_GET['id'];
      $BusinessPurpose =$_GET['BusinessPurpose'];   
      mysqli_query($conn,"update tblEnterpiseDetails set BusinessPurpose ='$BusinessPurpose' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#ED";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['AnnualGrossRevenue'])) {  
      $id=$_GET['id'];
      $AnnualGrossRevenue =$_GET['AnnualGrossRevenue'];   
      mysqli_query($conn,"update tblEnterpiseDetails set AnnualGrossRevenue ='$AnnualGrossRevenue' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#BS";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['trademarkStatus'])) {  
       $id=$_GET['id'];
     if(!empty($_GET['trademarkStatus'])){
          $trademarkStatus = $_GET['trademarkStatus'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set trademarkStatus ='$trademarkStatus' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
      else{
          $trademarkStatus = '';
           mysqli_query($conn,"update tblEnterpiseDetails set trademarkStatus ='$trademarkStatus' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#BS";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['TrademarkName'])) {  
      $id=$_GET['id'];
      $TrademarkName =$_GET['TrademarkName'];   
      mysqli_query($conn,"update tblEnterpiseDetails set TrademarkName ='$TrademarkName' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#BS";</script>';
 }
 if(isset($_POST["submitTN"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['TrademarkNameFile']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['TrademarkNameFile']['name']));
          $TrademarkNameFile =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['TrademarkNameFile']['tmp_name'],'companyDetailsFolder/'.$TrademarkNameFile);
          mysqli_query($conn,"update tblEnterpiseDetails set TrademarkNameFile ='$TrademarkNameFile' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#BS";</script>';
}
if (isset($_GET['id']) && isset($_GET['Tradename'])) {  
      $id=$_GET['id'];
      $Tradename =$_GET['Tradename'];   
      mysqli_query($conn,"update tblEnterpiseDetails set Tradename ='$Tradename' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#BS";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['ParentCompanyStates'])) {  
      $id=$_GET['id'];
      $ParentCompanyStates =$_GET['ParentCompanyStates'];   
      mysqli_query($conn,"update tblEnterpiseDetails set ParentCompanyStates ='$ParentCompanyStates' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['ParentCompanycity'])) {  
      $id=$_GET['id'];
      $ParentCompanycity =$_GET['ParentCompanycity'];   
      mysqli_query($conn,"update tblEnterpiseDetails set ParentCompanycity ='$ParentCompanycity' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['Headquarters'])) {  
      $id=$_GET['id'];
      $Headquarters =$_GET['Headquarters'];   
      mysqli_query($conn,"update tblEnterpiseDetails set Headquarters ='$Headquarters' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['ParentCompanyZipCode'])) {  
      $id=$_GET['id'];
      $ParentCompanyZipCode =$_GET['ParentCompanyZipCode'];   
      mysqli_query($conn,"update tblEnterpiseDetails set ParentCompanyZipCode ='$ParentCompanyZipCode' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['ParentCompanyName'])) {  
      $id=$_GET['id'];
      $ParentCompanyName =$_GET['ParentCompanyName'];   
      mysqli_query($conn,"update tblEnterpiseDetails set ParentCompanyName ='$ParentCompanyName' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['YearEstablished'])) {  
      $id=$_GET['id'];
      $YearEstablished =$_GET['YearEstablished'];   
      mysqli_query($conn,"update tblEnterpiseDetails set YearEstablished ='$YearEstablished' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['Dunn'])) {  
      $id=$_GET['id'];
      $Dunn =$_GET['Dunn'];   
      mysqli_query($conn,"update tblEnterpiseDetails set Dunn ='$Dunn' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
 }
 if (isset($_GET['id']) && isset($_GET['ein'])) {  
      $id=$_GET['id'];
      $ein =$_GET['ein'];   
      mysqli_query($conn,"update tblEnterpiseDetails set ein ='$ein' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
 }
if( isset($_GET['btnDelete_EI_Contact']) ) {
    $id = $_GET['btnDelete_EI_Contact'];
    $sql = mysqli_query( $conn,"UPDATE tblEnterpiseDetails_Contact set deleted = 1 WHERE con_id = $id" );
}
if( isset($_GET['btnDelete_EI_Emergency']) ) {
    $id = $_GET['btnDelete_EI_Emergency'];
    $sql = mysqli_query( $conn,"UPDATE tblEnterpiseDetails_Emergency set deleted = 1 WHERE emerg_id = $id" );
}
if( isset($_GET['btnDelete_Trademark']) ) {
    $ID = $_GET['btnDelete_Trademark'];
    $sql = mysqli_query( $conn,"UPDATE tblEnterpiseDetails_Trademark SET deleted = 1 WHERE ID = $ID" );
}
if( isset($_GET['btnDelete_EI_Private']) ) {
    $ID = $_GET['btnDelete_EI_Private'];
    $sql = mysqli_query( $conn,"UPDATE tblEnterpiseDetails_PrivatePatrol SET deleted = 1 WHERE ID = $ID" );
}
if (isset($_GET['id']) && isset($_GET['DirectEmployee'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['DirectEmployee'])){
          $DirectEmployee = $_GET['DirectEmployee'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set DirectEmployee ='$DirectEmployee' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $DirectEmployee = '';
           mysqli_query($conn,"update tblEnterpiseDetails set DirectEmployee ='$DirectEmployee' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['EmployeeofParentCompany'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['EmployeeofParentCompany'])){
          $EmployeeofParentCompany = $_GET['EmployeeofParentCompany'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set EmployeeofParentCompany ='$EmployeeofParentCompany' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $EmployeeofParentCompany = '';
           mysqli_query($conn,"update tblEnterpiseDetails set EmployeeofParentCompany ='$EmployeeofParentCompany' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['SisterDivision'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['SisterDivision'])){
          $SisterDivision = $_GET['SisterDivision'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set SisterDivision ='$SisterDivision' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $SisterDivision = '';
           mysqli_query($conn,"update tblEnterpiseDetails set SisterDivision ='$SisterDivision' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['Subsidiary'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Subsidiary'])){
          $Subsidiary = $_GET['Subsidiary'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Subsidiary ='$Subsidiary' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $Subsidiary = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Subsidiary ='$Subsidiary' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['ThirdParty'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['ThirdParty'])){
          $ThirdParty = $_GET['ThirdParty'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set ThirdParty ='$ThirdParty' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $ThirdParty = '';
           mysqli_query($conn,"update tblEnterpiseDetails set ThirdParty ='$ThirdParty' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['RelationshipEnterpriseStatus'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['RelationshipEnterpriseStatus'])){
          $RelationshipEnterpriseStatus = $_GET['RelationshipEnterpriseStatus'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set RelationshipEnterpriseStatus ='$RelationshipEnterpriseStatus' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $RelationshipEnterpriseStatus = '';
           mysqli_query($conn,"update tblEnterpiseDetails set RelationshipEnterpriseStatus ='$RelationshipEnterpriseStatus' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['AccountPayable'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['AccountPayable'])){
          $AccountPayable = $_GET['AccountPayable'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set AccountPayable ='$AccountPayable' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $AccountPayable = '';
           mysqli_query($conn,"update tblEnterpiseDetails set AccountPayable ='$AccountPayable' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['InformationSystem'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['InformationSystem'])){
          $InformationSystem = $_GET['InformationSystem'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set InformationSystem ='$InformationSystem' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $InformationSystem = '';
           mysqli_query($conn,"update tblEnterpiseDetails set InformationSystem ='$InformationSystem' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['CFO'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['CFO'])){
          $CFO = $_GET['CFO'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set CFO ='$CFO' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $CFO = '';
           mysqli_query($conn,"update tblEnterpiseDetails set CFO ='$CFO' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['Insurance'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Insurance'])){
          $Insurance = $_GET['Insurance'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Insurance ='$Insurance' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $Insurance = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Insurance ='$Insurance' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['PrimaryAccountRepresntative'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['PrimaryAccountRepresntative'])){
          $PrimaryAccountRepresntative = $_GET['PrimaryAccountRepresntative'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set PrimaryAccountRepresntative ='$PrimaryAccountRepresntative' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $PrimaryAccountRepresntative = '';
           mysqli_query($conn,"update tblEnterpiseDetails set PrimaryAccountRepresntative ='$PrimaryAccountRepresntative' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['CEO'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['CEO'])){
          $CEO = $_GET['CEO'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set CEO ='$CEO' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $CEO = '';
           mysqli_query($conn,"update tblEnterpiseDetails set CEO ='$CEO' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['Marketing'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Marketing'])){
          $Marketing = $_GET['Marketing'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Marketing ='$Marketing' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $Marketing = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Marketing ='$Marketing' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['FoodSafety'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['FoodSafety'])){
          $FoodSafety = $_GET['FoodSafety'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set FoodSafety ='$FoodSafety' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $FoodSafety = '';
           mysqli_query($conn,"update tblEnterpiseDetails set FoodSafety ='$FoodSafety' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['Operations'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Operations'])){
          $Operations = $_GET['Operations'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Operations ='$Operations' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $$Operations = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Operations ='$Operations' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['Executive'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Executive'])){
          $Executive = $_GET['Executive'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Executive ='$Executive' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $Executive = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Executive ='$Executive' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['AccountReceivable'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['AccountReceivable'])){
          $AccountReceivable = $_GET['AccountReceivable'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set AccountReceivable ='$AccountReceivable' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $AccountReceivable = '';
           mysqli_query($conn,"update tblEnterpiseDetails set AccountReceivable ='$AccountReceivable' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['ProductSafety'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['ProductSafety'])){
          $ProductSafety = $_GET['ProductSafety'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set ProductSafety ='$ProductSafety' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $ProductSafety = '';
           mysqli_query($conn,"update tblEnterpiseDetails set ProductSafety ='$ProductSafety' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['Legal'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Legal'])){
          $Legal = $_GET['Legal'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Legal ='$Legal' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $Legal = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Legal ='$Legal' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['Returns'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Returns'])){
          $Returns = $_GET['Returns'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Returns ='$Returns' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $Returns = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Returns ='$Returns' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['Transportation'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Transportation'])){
          $Transportation = $_GET['Transportation'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Transportation ='$Transportation' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $Transportation = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Transportation ='$Transportation' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['Compliance'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Compliance'])){
          $Compliance = $_GET['Compliance'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Compliance ='$Compliance' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $Compliance = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Compliance ='$Compliance' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['Finance'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Finance'])){
          $Finance = $_GET['Finance'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Finance ='$Finance' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $Finance = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Finance ='$Finance' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['HumanResources'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['HumanResources'])){
          $HumanResources = $_GET['HumanResources'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set HumanResources ='$HumanResources' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $HumanResources = '';
           mysqli_query($conn,"update tblEnterpiseDetails set HumanResources ='$HumanResources' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['Logistics'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Logistics'])){
          $Logistics = $_GET['Logistics'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Logistics ='$Logistics' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $Logistics = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Logistics ='$Logistics' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['PurchaseOrder'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['PurchaseOrder'])){
          $PurchaseOrder = $_GET['PurchaseOrder'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set PurchaseOrder ='$PurchaseOrder' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $PurchaseOrder = '';
           mysqli_query($conn,"update tblEnterpiseDetails set PurchaseOrder ='$PurchaseOrder' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['Sales'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Sales'])){
          $Sales = $_GET['Sales'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Sales ='$Sales' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $Sales = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Sales ='$Sales' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['Orders'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Orders'])){
          $Orders = $_GET['Orders'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Orders ='$Orders' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $Orders = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Orders ='$Orders' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['positionEnterpriseStatus'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['positionEnterpriseStatus'])){
          $positionEnterpriseStatus = $_GET['positionEnterpriseStatus'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set positionEnterpriseStatus ='$positionEnterpriseStatus' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $positionEnterpriseStatus = '';
           mysqli_query($conn,"update tblEnterpiseDetails set positionEnterpriseStatus ='$positionEnterpriseStatus' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['positionEnterpriseOthers'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['positionEnterpriseOthers'])){
          $positionEnterpriseOthers = $_GET['positionEnterpriseOthers'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set positionEnterpriseOthers ='$positionEnterpriseOthers' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
      else{
          $positionEnterpriseOthers = '';
           mysqli_query($conn,"update tblEnterpiseDetails set positionEnterpriseOthers ='$positionEnterpriseOthers' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#PC";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['GFSI'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['GFSI'])){
          $GFSI = $_GET['GFSI'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set GFSI ='$GFSI' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $GFSI = '';
           mysqli_query($conn,"update tblEnterpiseDetails set GFSI ='$GFSI' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 
 if(isset($_POST["submitCSP"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['GFSIFILE']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['GFSIFILE']['name']));
          $GFSIFILE =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['GFSIFILE']['tmp_name'],'companyDetailsFolder/'.$GFSIFILE);
          mysqli_query($conn,"update tblEnterpiseDetails set GFSIFILE ='$GFSIFILE' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#CA";</script>';
}
if (isset($_GET['id']) && isset($_GET['SQF'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['SQF'])){
          $SQF = $_GET['SQF'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set SQF ='$SQF' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $SQF = '';
           mysqli_query($conn,"update tblEnterpiseDetails set SQF ='$SQF' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 
 if(isset($_POST["submitSQF"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['SQFFILE']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['SQFFILE']['name']));
          $SQFFILE =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['SQFFILE']['tmp_name'],'companyDetailsFolder/'.$SQFFILE);
          mysqli_query($conn,"update tblEnterpiseDetails set SQFFILE ='$SQFFILE' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#CA";</script>';
}
if (isset($_GET['id']) && isset($_GET['BRC'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['BRC'])){
          $BRC = $_GET['BRC'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set BRC ='$BRC' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $BRC = '';
           mysqli_query($conn,"update tblEnterpiseDetails set BRC ='$BRC' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 
 if(isset($_POST["submitBRC"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['BRCFILE']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['BRCFILE']['name']));
          $BRCFILE =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['BRCFILE']['tmp_name'],'companyDetailsFolder/'.$BRCFILE);
          mysqli_query($conn,"update tblEnterpiseDetails set BRCFILE ='$BRCFILE' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#CA";</script>';
}
if (isset($_GET['id']) && isset($_GET['FSSC22000'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['FSSC22000'])){
          $FSSC22000 = $_GET['FSSC22000'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set FSSC22000 ='$FSSC22000' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $FSSC22000 = '';
           mysqli_query($conn,"update tblEnterpiseDetails set FSSC22000 ='$FSSC22000' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 
 if(isset($_POST["submitFSSC"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['FSSC22000FILE']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['FSSC22000FILE']['name']));
          $FSSC22000FILE =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['FSSC22000FILE']['tmp_name'],'companyDetailsFolder/'.$FSSC22000FILE);
          mysqli_query($conn,"update tblEnterpiseDetails set FSSC22000FILE ='$FSSC22000FILE' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#CA";</script>';
}
if (isset($_GET['id']) && isset($_GET['ISO'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['ISO'])){
          $ISO = $_GET['ISO'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set ISO ='$ISO' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $ISO = '';
           mysqli_query($conn,"update tblEnterpiseDetails set ISO ='$ISO' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 
 if(isset($_POST["submitISO"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['ISOFILE']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['ISOFILE']['name']));
          $ISOFILE =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['ISOFILE']['tmp_name'],'companyDetailsFolder/'.$ISOFILE);
          mysqli_query($conn,"update tblEnterpiseDetails set ISOFILE ='$ISOFILE' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#CA";</script>';
}
if (isset($_GET['id']) && isset($_GET['PrimusGFS'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['PrimusGFS'])){
          $PrimusGFS = $_GET['PrimusGFS'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set PrimusGFS ='$PrimusGFS' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $PrimusGFS = '';
           mysqli_query($conn,"update tblEnterpiseDetails set PrimusGFS ='$PrimusGFS' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 
 if(isset($_POST["submitPrimusGFS"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['PrimusGFSFILE']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['PrimusGFSFILE']['name']));
          $PrimusGFSFILE =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['PrimusGFSFILE']['tmp_name'],'companyDetailsFolder/'.$PrimusGFSFILE);
          mysqli_query($conn,"update tblEnterpiseDetails set PrimusGFSFILE ='$PrimusGFSFILE' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#CA";</script>';
}
if (isset($_GET['id']) && isset($_GET['HACCP'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['HACCP'])){
          $HACCP = $_GET['HACCP'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set HACCP ='$HACCP' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $HACCP = '';
           mysqli_query($conn,"update tblEnterpiseDetails set HACCP ='$HACCP' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 
 if(isset($_POST["submitHACCP"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['HACCPFILE']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['HACCPFILE']['name']));
          $HACCPFILE =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['HACCPFILE']['tmp_name'],'companyDetailsFolder/'.$HACCPFILE);
          mysqli_query($conn,"update tblEnterpiseDetails set HACCPFILE ='$HACCPFILE' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#CA";</script>';
}
if (isset($_GET['id']) && isset($_GET['GMP'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['GMP'])){
          $GMP = $_GET['GMP'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set GMP ='$GMP' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $GMP = '';
           mysqli_query($conn,"update tblEnterpiseDetails set GMP ='$GMP' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 
 if(isset($_POST["submitGMP"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['GMPFILE']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['GMPFILE']['name']));
          $GMPFILE =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['GMPFILE']['tmp_name'],'companyDetailsFolder/'.$GMPFILE);
          mysqli_query($conn,"update tblEnterpiseDetails set GMPFILE ='$GMPFILE' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#CA";</script>';
}
if (isset($_GET['id']) && isset($_GET['CertificationOthers'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['CertificationOthers'])){
          $CertificationOthers = $_GET['CertificationOthers'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set CertificationOthers ='$CertificationOthers' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $CertificationOthers = '';
           mysqli_query($conn,"update tblEnterpiseDetails set CertificationOthers ='$CertificationOthers' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 
 if(isset($_POST["submitcOther"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['OthersFILE']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['OthersFILE']['name']));
          $OthersFILE =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['OthersFILE']['tmp_name'],'companyDetailsFolder/'.$OthersFILE);
          mysqli_query($conn,"update tblEnterpiseDetails set OthersFILE ='$OthersFILE' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#CA";</script>';
}
if (isset($_GET['id']) && isset($_GET['othersCertificationSpecify'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['othersCertificationSpecify'])){
          $othersCertificationSpecify = $_GET['othersCertificationSpecify'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set othersCertificationSpecify ='$othersCertificationSpecify' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $othersCertificationSpecify = '';
           mysqli_query($conn,"update tblEnterpiseDetails set othersCertificationSpecify ='$othersCertificationSpecify' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
  if(isset($_POST["submitOrganic"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['OrganicFile']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['OrganicFile']['name']));
          $OrganicFile =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['OrganicFile']['tmp_name'],'companyDetailsFolder/'.$OrganicFile);
          mysqli_query($conn,"update tblEnterpiseDetails set OrganicFile ='$OrganicFile' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#CA";</script>';
}
if (isset($_GET['id']) && isset($_GET['Organic'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Organic'])){
          $Organic = $_GET['Organic'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Organic ='$Organic' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $Organic = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Organic ='$Organic' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 if(isset($_POST["submitHalal"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['HalalFile']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['HalalFile']['name']));
          $HalalFile =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['HalalFile']['tmp_name'],'companyDetailsFolder/'.$HalalFile);
          mysqli_query($conn,"update tblEnterpiseDetails set HalalFile ='$HalalFile' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#CA";</script>';
}
if (isset($_GET['id']) && isset($_GET['Halal'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Halal'])){
          $Halal = $_GET['Halal'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Halal ='$Halal' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $Halal = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Halal ='$Halal' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 if(isset($_POST["submitKosher"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['KosherFile']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['KosherFile']['name']));
          $KosherFile =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['KosherFile']['tmp_name'],'companyDetailsFolder/'.$KosherFile);
          mysqli_query($conn,"update tblEnterpiseDetails set KosherFile ='$KosherFile' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#CA";</script>';
}
if (isset($_GET['id']) && isset($_GET['Kosher'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Kosher'])){
          $Kosher = $_GET['Kosher'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Kosher ='$Kosher' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $Kosher = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Kosher ='$Kosher' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 if(isset($_POST["submitNonGMO"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['NonGMOFile']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['NonGMOFile']['name']));
          $NonGMOFile =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['NonGMOFile']['tmp_name'],'companyDetailsFolder/'.$NonGMOFile);
          mysqli_query($conn,"update tblEnterpiseDetails set NonGMOFile ='$NonGMOFile' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#CA";</script>';
}
if (isset($_GET['id']) && isset($_GET['NonGMO'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['NonGMO'])){
          $NonGMO = $_GET['NonGMO'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set NonGMO ='$NonGMO' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $NonGMO = '';
           mysqli_query($conn,"update tblEnterpiseDetails set NonGMO ='$NonGMO' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 if(isset($_POST["submitPlantBased"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['PlantBasedFile']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['PlantBasedFile']['name']));
          $PlantBasedFile =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['PlantBasedFile']['tmp_name'],'companyDetailsFolder/'.$PlantBasedFile);
          mysqli_query($conn,"update tblEnterpiseDetails set PlantBasedFile ='$PlantBasedFile' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#CA";</script>';
}
if (isset($_GET['id']) && isset($_GET['PlantBased'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['PlantBased'])){
          $PlantBased = $_GET['PlantBased'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set PlantBased ='$PlantBased' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $PlantBased = '';
           mysqli_query($conn,"update tblEnterpiseDetails set PlantBased ='$PlantBased' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 if(isset($_POST["submitFAO"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['othersAccreditationFile']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['othersAccreditationFile']['name']));
          $othersAccreditationFile =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['othersAccreditationFile']['tmp_name'],'companyDetailsFolder/'.$othersAccreditationFile);
          mysqli_query($conn,"update tblEnterpiseDetails set othersAccreditationFile ='$othersAccreditationFile' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#CA";</script>';
}
if (isset($_GET['id']) && isset($_GET['FacilityAccreditationOthers'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['FacilityAccreditationOthers'])){
          $FacilityAccreditationOthers = $_GET['FacilityAccreditationOthers'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set FacilityAccreditationOthers ='$FacilityAccreditationOthers' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $FacilityAccreditationOthers = '';
           mysqli_query($conn,"update tblEnterpiseDetails set FacilityAccreditationOthers ='$FacilityAccreditationOthers' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['FacilityAccreditationSpecify'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['FacilityAccreditationSpecify'])){
          $FacilityAccreditationSpecify = $_GET['FacilityAccreditationSpecify'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set FacilityAccreditationSpecify ='$FacilityAccreditationSpecify' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $FacilityAccreditationSpecify = '';
           mysqli_query($conn,"update tblEnterpiseDetails set FacilityAccreditationSpecify ='$FacilityAccreditationSpecify' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['FacilityAccreditationNone'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['FacilityAccreditationNone'])){
          $FacilityAccreditationNone = $_GET['FacilityAccreditationNone'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set FacilityAccreditationNone ='$FacilityAccreditationNone' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
      else{
          $FacilityAccreditationNone = '';
           mysqli_query($conn,"update tblEnterpiseDetails set FacilityAccreditationNone ='$FacilityAccreditationNone' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#CA";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['FDA'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['FDA'])){
          $FDA = $_GET['FDA'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set FDA ='$FDA' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#Regulatory";</script>';
      }
      else{
          $FDA = '';
           mysqli_query($conn,"update tblEnterpiseDetails set FDA ='$FDA' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#Regulatory";</script>';
      }
 }
 if(isset($_POST["submitFDA"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['FDAfile']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['FDAfile']['name']));
          $FDAfile =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['FDAfile']['tmp_name'],'companyDetailsFolder/'.$FDAfile);
          mysqli_query($conn,"update tblEnterpiseDetails set FDAfile ='$FDAfile' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#Regulatory";</script>';
}
if (isset($_GET['id']) && isset($_GET['USDA'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['USDA'])){
          $USDA = $_GET['USDA'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set USDA ='$USDA' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#Regulatory";</script>';
      }
      else{
          $USDA = '';
           mysqli_query($conn,"update tblEnterpiseDetails set USDA ='$USDA' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#Regulatory";</script>';
      }
 }
 if(isset($_POST["submitUSDA"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['USDAfile']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['USDAfile']['name']));
          $USDAfile =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['USDAfile']['tmp_name'],'companyDetailsFolder/'.$USDAfile);
          mysqli_query($conn,"update tblEnterpiseDetails set USDAfile ='$USDAfile' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#Regulatory";</script>';
}
if (isset($_GET['id']) && isset($_GET['ComplianceRequirementsOthers'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['ComplianceRequirementsOthers'])){
          $ComplianceRequirementsOthers = $_GET['ComplianceRequirementsOthers'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set ComplianceRequirementsOthers ='$ComplianceRequirementsOthers' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#Regulatory";</script>';
      }
      else{
          $ComplianceRequirementsOthers = '';
           mysqli_query($conn,"update tblEnterpiseDetails set ComplianceRequirementsOthers ='$ComplianceRequirementsOthers' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#Regulatory";</script>';
      }
 }
 if(isset($_POST["submitCRO"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['ComplianceRequirementsfile']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['ComplianceRequirementsfile']['name']));
          $ComplianceRequirementsfile =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['ComplianceRequirementsfile']['tmp_name'],'companyDetailsFolder/'.$ComplianceRequirementsfile);
          mysqli_query($conn,"update tblEnterpiseDetails set ComplianceRequirementsfile ='$ComplianceRequirementsfile' where enterp_id='$id'");  
          echo '<script> window.location.href = "enterprise-info#Regulatory";</script>';
}
if (isset($_GET['id']) && isset($_GET['ComplianceRequirementsOthersSpecify'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['ComplianceRequirementsOthersSpecify'])){
          $ComplianceRequirementsOthersSpecify = $_GET['ComplianceRequirementsOthersSpecify'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set ComplianceRequirementsOthersSpecify ='$ComplianceRequirementsOthersSpecify' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#Regulatory";</script>';
      }
      else{
          $ComplianceRequirementsOthersSpecify = '';
           mysqli_query($conn,"update tblEnterpiseDetails set ComplianceRequirementsOthersSpecify ='$ComplianceRequirementsOthersSpecify' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#Regulatory";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['ComplianceRequirementsOthersNone'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['ComplianceRequirementsOthersNone'])){
          $ComplianceRequirementsOthersNone = $_GET['ComplianceRequirementsOthersNone'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set ComplianceRequirementsOthersNone ='$ComplianceRequirementsOthersNone' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#Regulatory";</script>';
      }
      else{
          $ComplianceRequirementsOthersNone = '';
           mysqli_query($conn,"update tblEnterpiseDetails set ComplianceRequirementsOthersNone ='$ComplianceRequirementsOthersNone' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#Regulatory";</script>';
      }
 }
 
if (isset($_GET['id']) && isset($_GET['DocumentTitle'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['DocumentTitle'])){
          $DocumentTitle = $_GET['DocumentTitle'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set DocumentTitle ='$DocumentTitle' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#Rec";</script>';
      }
      else{
          $DocumentTitle = '';
           mysqli_query($conn,"update tblEnterpiseDetails set DocumentTitle ='$DocumentTitle' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#Rec";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['DocumentDesciption'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['DocumentDesciption'])){
          $DocumentDesciption = $_GET['DocumentDesciption'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set DocumentDesciption ='$DocumentDesciption' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#Rec";</script>';
      }
      else{
          $DocumentDesciption = '';
           mysqli_query($conn,"update tblEnterpiseDetails set DocumentDesciption ='$DocumentDesciption' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#Rec";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['DocumentDueDate'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['DocumentDueDate'])){
          $DocumentDueDate = $_GET['DocumentDueDate'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set DocumentDueDate ='$DocumentDueDate' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#Rec";</script>';
      }
      else{
          $DocumentDueDate = '';
           mysqli_query($conn,"update tblEnterpiseDetails set DocumentDueDate ='$DocumentDueDate' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#Rec";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['enterpriseOperation'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['enterpriseOperation'])){
          $enterpriseOperation = $_GET['enterpriseOperation'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set enterpriseOperation ='$enterpriseOperation' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
      else{
          $enterpriseOperation = '';
           mysqli_query($conn,"update tblEnterpiseDetails set enterpriseOperation ='$enterpriseOperation' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['enterpriseEmployees'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['enterpriseEmployees'])){
          $enterpriseEmployees = $_GET['enterpriseEmployees'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set enterpriseEmployees ='$enterpriseEmployees' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
      else{
          $enterpriseEmployees = '';
           mysqli_query($conn,"update tblEnterpiseDetails set enterpriseEmployees ='$enterpriseEmployees' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['enterpriseImporter'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['enterpriseImporter'])){
          $enterpriseImporter = $_GET['enterpriseImporter'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set enterpriseImporter ='$enterpriseImporter' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
      else{
          $enterpriseImporter = '';
           mysqli_query($conn,"update tblEnterpiseDetails set enterpriseImporter ='$enterpriseImporter' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['enterpriseProducts'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['enterpriseProducts'])){
          $enterpriseProducts = $_GET['enterpriseProducts'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set enterpriseProducts ='$enterpriseProducts' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
      else{
          $enterpriseProducts = '';
           mysqli_query($conn,"update tblEnterpiseDetails set enterpriseProducts ='$enterpriseProducts' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['enterpriseServices'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['enterpriseServices'])){
          $enterpriseServices = $_GET['enterpriseServices'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set enterpriseServices ='$enterpriseServices' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
      else{
          $enterpriseServices = '';
           mysqli_query($conn,"update tblEnterpiseDetails set enterpriseServices ='$enterpriseServices' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['NumberofEmployees'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['NumberofEmployees'])){
          $NumberofEmployees = $_GET['NumberofEmployees'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set NumberofEmployees ='$NumberofEmployees' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
      else{
          $NumberofEmployees = '';
           mysqli_query($conn,"update tblEnterpiseDetails set NumberofEmployees ='$NumberofEmployees' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['Country_importer'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Country_importer'])){
          $Country_importer = $_GET['Country_importer'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Country_importer ='$Country_importer' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
      else{
          $Country_importer = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Country_importer ='$Country_importer' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['ProductDesc'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['ProductDesc'])){
          $ProductDesc = $_GET['ProductDesc'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set ProductDesc ='$ProductDesc' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
      else{
          $ProductDesc = '';
           mysqli_query($conn,"update tblEnterpiseDetails set ProductDesc ='$ProductDesc' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['enterpriseexporter'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['enterpriseexporter'])){
          $enterpriseexporter = $_GET['enterpriseexporter'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set enterpriseexporter ='$enterpriseexporter' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
      else{
          $enterpriseexporter = '';
           mysqli_query($conn,"update tblEnterpiseDetails set enterpriseexporter ='$enterpriseexporter' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
 }
 if (isset($_GET['id']) && isset($_GET['Country_exporter'])) {  
      $id=$_GET['id'];
      if(!empty($_GET['Country_exporter'])){
          $Country_exporter = $_GET['Country_exporter'];
      
      mysqli_query($conn,"update tblEnterpiseDetails set Country_exporter ='$Country_exporter' where enterp_id='$id'");  
      echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
      else{
          $Country_exporter = '';
           mysqli_query($conn,"update tblEnterpiseDetails set Country_exporter ='$Country_exporter' where enterp_id='$id'");  
         echo '<script> window.location.href = "enterprise-info#ED";</script>';
      }
 }
if(isset($_POST["submitPROCESS"]))
    {
       
        $bPROCESS = '';
        $cCategories = '';
        $id = $_POST["ids"];
        $BusinessPurpose = mysqli_real_escape_string($conn,$_POST["BusinessPurpose"]);
        $enterpriseOperation = mysqli_real_escape_string($conn,$_POST["enterpriseOperation"]);
        $enterpriseEmployees = mysqli_real_escape_string($conn,$_POST["enterpriseEmployees"]);
        $NumberofEmployees = mysqli_real_escape_string($conn,$_POST["NumberofEmployees"]);
        $enterpriseImporter = mysqli_real_escape_string($conn,$_POST["enterpriseImporter"]);
        $Country_importer = mysqli_real_escape_string($conn,$_POST["Country_importer"]);
        $enterpriseexporter = mysqli_real_escape_string($conn,$_POST["enterpriseexporter"]);
        $Country_exporter = mysqli_real_escape_string($conn,$_POST["Country_exporter"]);
        $enterpriseProducts = mysqli_real_escape_string($conn,$_POST["enterpriseProducts"]);
        $ProductDesc = mysqli_real_escape_string($conn,$_POST["ProductDesc"]);
        $enterpriseServices = mysqli_real_escape_string($conn,$_POST["enterpriseServices"]); 
         $EnterpriseProcessSpecify = $_POST["EnterpriseProcessSpecify"];
       
    if(!empty($_POST["Categories"]))
    {
    foreach($_POST["Categories"] as $Categories)
        {
            $cCategories .= $Categories . ', ';
        }
       
    }
     if(!empty($_POST["BusinessPROCESS"]))
     {
        foreach($_POST["BusinessPROCESS"] as $businessPROCESS)
        {
            $bPROCESS .= $businessPROCESS . ', ';
        }
            
    }
            $bPROCESS = substr($bPROCESS, 0, -2);
            $cCategories = substr($cCategories, 0, -2);
            mysqli_query($conn,"update tblEnterpiseDetails set BusinessPROCESS ='$bPROCESS',Categories ='$cCategories', EnterpriseProcessSpecify = '$EnterpriseProcessSpecify', BusinessPurpose= '$BusinessPurpose',enterpriseOperation='$enterpriseOperation',enterpriseEmployees='$enterpriseEmployees',NumberofEmployees='$NumberofEmployees',enterpriseImporter='$enterpriseImporter',Country_importer='$Country_importer',enterpriseexporter='$enterpriseexporter',Country_exporter='$Country_exporter',enterpriseProducts='$enterpriseProducts',ProductDesc='$ProductDesc',enterpriseServices='$enterpriseServices' where enterp_id='$id'");  
            echo '<script> window.location.href = "enterprise-info#ED";</script>';
}

 if(isset($_POST["submitBrandLogos"]))
    {
          $id=$_POST['ids'];
          $file = $_FILES['BrandLogos']['name'];
          $filename = pathinfo($file, PATHINFO_FILENAME);
          $extension = end(explode(".", $_FILES['BrandLogos']['name']));
          $BrandLogos =  rand(10,1000000)." - ".$filename.".".$extension;
          move_uploaded_file($_FILES['BrandLogos']['tmp_name'],'companyDetailsFolder/'.$BrandLogos);
          mysqli_query($conn,"update tblEnterpiseDetails set BrandLogos ='$BrandLogos' where users_entities='$user_id'");  
          echo '<script> window.location.href = "enterprise-info#Logo";</script>';
}

?>
 

