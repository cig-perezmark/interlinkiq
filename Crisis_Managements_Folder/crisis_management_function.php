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

// add Legal
if (isset($_POST['btnSave_Legal'])) {  
    $userID = $_COOKIE['ID'];
    $Area_name = mysqli_real_escape_string($conn,$_POST['Area_name']);
    $Agency_name = mysqli_real_escape_string($conn,$_POST['Agency_name']);
    $Contact_Person = mysqli_real_escape_string($conn,$_POST['Contact_Person']);
    $Phone_1 = mysqli_real_escape_string($conn,$_POST['Phone_1']);
    $Phone_2 = mysqli_real_escape_string($conn,$_POST['Phone_2']);
    $legal_email = mysqli_real_escape_string($conn,$_POST['legal_email']);
    
    $sql = "INSERT INTO tbl_Legal_experts(Area_name,Agency_name,Contact_Person,Phone_1,Phone_2,legal_email,user_cookies) VALUES ('$Area_name','$Agency_name','$Contact_Person','$Phone_1','$Phone_2','$legal_email','$user_id')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../Legal_Expert";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// add Critical Operation
if (isset($_POST['btnSave_critical_operation'])) {  
    $userID = $_COOKIE['ID'];
    $ids = mysqli_real_escape_string($conn,$_POST['ids']);
    $addOperationField = mysqli_real_escape_string($conn,$_POST['addOperationField']);
    $addPrimaryNameField = mysqli_real_escape_string($conn,$_POST['addPrimaryNameField']);
    $addAlternateNameField = mysqli_real_escape_string($conn,$_POST['addAlternateNameField']);
    
    $sql = "INSERT INTO tbl_critical_operation(assign_area,addOperationField,addPrimaryNameField,addAlternateNameField,user_cookies) VALUES ('$ids','$addOperationField','$addPrimaryNameField','$addAlternateNameField','$user_id')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../Critical_Operation";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// add Critical Operation Facility
if (isset($_POST['btnSave_critical_operation_facility'])) {  
    $userID = $_COOKIE['ID'];
    $ids = mysqli_real_escape_string($conn,$_POST['ids']);
    $addOperationField = mysqli_real_escape_string($conn,$_POST['addOperationField']);
    $addPrimaryNameField = mysqli_real_escape_string($conn,$_POST['addPrimaryNameField']);
    $addAlternateNameField = mysqli_real_escape_string($conn,$_POST['addAlternateNameField']);
    
    $sql = "INSERT INTO tbl_critical_operation(assign_area,addOperationField,addPrimaryNameField,addAlternateNameField,user_cookies) VALUES ('$ids','$addOperationField','$addPrimaryNameField','$addAlternateNameField','$user_id')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#cc";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// add Crisis Incidents
if (isset($_POST['btnSave_crisis_incedents'])) {  
    $userID = $_COOKIE['ID'];
    $Types_Of_Crisis = mysqli_real_escape_string($conn,$_POST['Types_Of_Crisis']);
   $disaster_name = mysqli_real_escape_string($conn,$_POST['disaster_name']);
   
   $file = $_FILES['disaster_Supporting_files']['name'];
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $extension = end(explode(".", $_FILES['disaster_Supporting_files']['name']));
    $disaster_Supporting_files =  rand(10,1000000)." - ".$filename.".".$extension;
    move_uploaded_file($_FILES['disaster_Supporting_files']['tmp_name'],'../Disaster_Supporting_files_Folder/'.$disaster_Supporting_files);
    
    $sql = "INSERT INTO tbl_crisis_incidents(Types_Of_Crisis,disaster_name,disaster_Supporting_files,user_cookies) VALUES ('$Types_Of_Crisis','$disaster_name','$disaster_Supporting_files','$user_id')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../Types_Of_Crisis";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// add Crisis Incidents Managements
if (isset($_POST['btnSave_crisis_managements'])) {  
   $userID = $_COOKIE['ID'];
   $Types_Of_Disaster = mysqli_real_escape_string($conn,$_POST['Types_Of_Disaster']);
   $Crisis_Preparedness = mysqli_real_escape_string($conn,$_POST['Crisis_Preparedness']);
   $Initiated_by = mysqli_real_escape_string($conn,$_POST['Initiated_by']);
   $Meeting_Location = mysqli_real_escape_string($conn,$_POST['Meeting_Location']);
    
    $sql = "INSERT INTO tbl_crisis_incidents_managements(Types_Of_Disaster,Crisis_Preparedness,Initiated_by,Meeting_Location,user_cookies) VALUES ('$Types_Of_Disaster','$Crisis_Preparedness','$Initiated_by','$Meeting_Location','$user_id')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../crisis_incidents";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// add Crisis Incidents Managements Management Plan_form
if (isset($_POST['btnSave_management_plan_category'])) {  
   $userID = $_COOKIE['ID'];
   $management_plan_area = mysqli_real_escape_string($conn,$_POST['management_plan_area']);
   $management_plan_category = mysqli_real_escape_string($conn,$_POST['management_plan_category']);
    
    $sql = "INSERT INTO tbl_crisis_incidents_management_plan_form(management_plan_area,management_plan_category,user_cookies) VALUES ('$management_plan_area','$management_plan_category','$user_id')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../crisis_annual_review";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Filled Form
if (isset($_POST['save_FilledForm'])) { 
   $userID = $_COOKIE['ID'];
   $Plan_code = rand(10,1000000);
   $Plan_Notes = $_POST['Plan_Notes'];
   $Plan_Action_Items = $_POST['Plan_Action_Items'];
   
   $Approved_by = $_POST['Approved_by'];
   $Approved_Date = $_POST['Approved_Date'];
   $Verified_by = $_POST['Verified_by'];
   $Verified_Date = $_POST['Verified_Date'];
    $management_plan_area_category = $_POST['management_plan_area_category'];
    
    if(!empty($management_plan_area_category)){
        
        for($i = 0;$i < count($_POST['management_plan_area_category']);$i++){
            
            $management_plan_area_filled = $_POST['management_plan_area_filled'][$i];
            $management_plan_area_answer = $_POST['management_plan_area_answer'][$i];
            $management_plan_area_category = $_POST['management_plan_area_category'][$i];
                
             $sql = "INSERT INTO tbl_crisis_incidents_management_plan_filled_form(management_plan_area_filled,management_plan_area_category,management_plan_area_answer,Plan_Notes,Plan_Action_Items,Approved_by,Approved_Date,Verified_by,Verified_Date,user_cookies,Plan_code) 
             VALUES ('$management_plan_area_filled','$management_plan_area_category','$management_plan_area_answer','$Plan_Notes','$Plan_Action_Items','$Approved_by','$Approved_Date','$Verified_by','$Verified_Date','$user_id','$Plan_code')";
             if(mysqli_query($conn, $sql)){
                echo '<script> window.location.href = "../crisis_annual_review";</script>';
             }
              else{
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
             
        }
        
    }
    
}

// Update Customer Relationship Account
if (isset($_POST['update_details_account'])) {  
    $userID = $_COOKIE['ID'];
    $crm_ids = mysqli_real_escape_string($conn,$_POST['ids']);
    $account_name = mysqli_real_escape_string($conn,$_POST['account_name']);
    $parent_account = mysqli_real_escape_string($conn,$_POST['parent_account']);
    $account_status = mysqli_real_escape_string($conn,$_POST['account_status']);
    $account_email = mysqli_real_escape_string($conn,$_POST['account_email']);
    $account_phone = mysqli_real_escape_string($conn,$_POST['account_phone']);
    $account_fax = mysqli_real_escape_string($conn,$_POST['account_fax']);
    $account_address = mysqli_real_escape_string($conn,$_POST['account_address']);
    $account_country = mysqli_real_escape_string($conn,$_POST['account_country']);
    $contact_website = mysqli_real_escape_string($conn,$_POST['contact_website']);
    $contact_interlink = mysqli_real_escape_string($conn,$_POST['contact_interlink']);
    $contact_facebook = mysqli_real_escape_string($conn,$_POST['contact_facebook']);
    $contact_twitter = mysqli_real_escape_string($conn,$_POST['contact_twitter']);
    $contact_linkedin = mysqli_real_escape_string($conn,$_POST['contact_linkedin']);
    
    
    $sql = "UPDATE tbl_Customer_Relationship set account_name = '$account_name',parent_account = '$parent_account',account_status = '$account_status',account_email = '$account_email',account_phone = '$account_phone',account_fax = '$account_fax',account_address = '$account_address',account_country = '$account_country',contact_website = '$contact_website',contact_interlink = '$contact_interlink',contact_facebook = '$contact_facebook',contact_twitter = '$contact_twitter',contact_linkedin = '$contact_linkedin' where crm_id = '$crm_ids' ";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}



$conn->close();
?>