<?php
     include_once '../database.php';
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
    
    if (isset($_POST['submitFacility_Details'])) { 
        
        $userID = $_COOKIE['ID'];
        $ids = $_POST['ids'];
        $facility_category = mysqli_real_escape_string($conn,$_POST['facility_category']);
        $country = $_POST['countrys'];
        $Bldg = $_POST['Bldg'];
        $city = $_POST['city'];
        $States = $_POST['States'];
        $ZipCode = $_POST['ZipCode'];
        $facility_phone = $_POST['facility_phone'];
        $facility_fax = $_POST['facility_fax'];
        $facility_Address = $_POST['facility_Address'];
        $facility_website = $_POST['facility_website'];
        
        mysqli_query($conn,"update tblFacilityDetails set facility_category ='".$facility_category."', country='".$country."', Bldg='".$Bldg."', city='".$city."', States='".$States."', ZipCode='".$ZipCode."', facility_phone='".$facility_phone."', facility_fax='".$facility_fax."', facility_Address='".$facility_Address."', facility_website='".$facility_website."' where facility_id=$ids");  
         echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'";</script>';
    }
    
    if (isset($_POST['save_Btnsq'])) { 
        
        $userID = $_COOKIE['ID'];
        $ids = $_POST['ids'];
        $Facility_Plant_Total_Sq = mysqli_real_escape_string($conn,$_POST['Facility_Plant_Total_Sq']);
        $Cooler_Chiller_Sq = mysqli_real_escape_string($conn,$_POST['Cooler_Chiller_Sq']);
        $Production_Area_Sq = mysqli_real_escape_string($conn,$_POST['Production_Area_Sq']);
        $Farm_Area_Sq = mysqli_real_escape_string($conn,$_POST['Farm_Area_Sq']);
        $Warehouse_Sq = mysqli_real_escape_string($conn,$_POST['Warehouse_Sq']);
        $Freezer_Sq = mysqli_real_escape_string($conn,$_POST['Freezer_Sq']);
        $Packaging_Area_Sq = mysqli_real_escape_string($conn,$_POST['Packaging_Area_Sq']);
        
        
        
        $nN_A = '';
        if (!empty($_POST["N_A"])) {
    		$nN_A = implode(", ", $_POST["N_A"]);
    	}
        // if(!empty($_POST["N_A"]))
        // {
        //     foreach($_POST["N_A"] as $N_A)
        //         {
        //             $nN_A .= $N_A . ', ';
        //         }
        // }
        // $nN_A = substr($nN_A, 0, -2);
        mysqli_query($conn,"update tblFacilityDetails set Facility_Plant_Total_Sq ='$Facility_Plant_Total_Sq', Cooler_Chiller_Sq ='$Cooler_Chiller_Sq', Production_Area_Sq='$Production_Area_Sq', Farm_Area_Sq='$Farm_Area_Sq', Warehouse_Sq='$Warehouse_Sq', Freezer_Sq='$Freezer_Sq', Packaging_Area_Sq='$Packaging_Area_Sq',N_A='$nN_A' where facility_id='$ids'");  
         echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#ppf";</script>';
    }
    
    //Facilty Functions
    if(isset($_POST["btn_form_function"]))
        {
           
        $fFacilty_Functions = '';
        $userID = $_COOKIE['ID'];
        $ids = $_POST["ids"];
        $Number_of_Shifts = mysqli_real_escape_string($conn,$_POST["Number_of_Shifts"]);
        $Number_of_Employees = mysqli_real_escape_string($conn,$_POST["Number_of_Employees"]);
        $Number_of_Lines = mysqli_real_escape_string($conn,$_POST["Number_of_Lines"]);
        $Number_of_HACCPs = mysqli_real_escape_string($conn,$_POST["Number_of_HACCPs"]);
        $Year_Establish = mysqli_real_escape_string($conn,$_POST["Year_Establish"]);
    
        if(!empty($_POST["Facilty_Functions"]))
        {
            foreach($_POST["Facilty_Functions"] as $Facilty_Functions)
                {
                    $fFacilty_Functions .= $Facilty_Functions . ', ';
                }
        }
        $fFacilty_Functions = substr($fFacilty_Functions, 0, -2);
        mysqli_query($conn,"update tblFacilityDetails set Facilty_Functions ='$fFacilty_Functions',Number_of_Shifts='$Number_of_Shifts',Number_of_Employees='$Number_of_Employees',Number_of_Lines='$Number_of_Lines',Number_of_HACCPs='$Number_of_HACCPs',Year_Establish='$Year_Establish' where facility_id='$ids'");  
       echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#fo";</script>';
    }
    
    //Permits Update Functions
    if(isset($_POST["btnPermitsUpdate"]))
        {
           
        if(!empty($_FILES['Permits']['name'])){
            $permitsID = $_POST['ID'];
            $ids = $_POST["ids"];
            
            $file = $_FILES['Permits']['name'];
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $extension = end(explode(".", $_FILES['Permits']['name']));
            $Permits =  rand(10,1000000)." - ".$filename.".".$extension;
            move_uploaded_file($_FILES['Permits']['tmp_name'],'../facility_files_Folder/'.$Permits);
            $Type_s = mysqli_real_escape_string($conn,$_POST["Type_s"]);
            $Descriptions = mysqli_real_escape_string($conn,$_POST["Descriptions"]);
            $Issue_Date = mysqli_real_escape_string($conn,$_POST["Issue_Date"]);
            $Expiration_Date = mysqli_real_escape_string($conn,$_POST["Expiration_Date"]);
            
            mysqli_query($conn,"update tblFacilityDetails_Permits set Permits='$Permits',Type_s ='$Type_s',Descriptions='$Descriptions',Issue_Date='$Issue_Date',Expiration_Date='$Expiration_Date' where Permits_id='$permitsID'");  
           echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#fo";</script>';
        }else{
            $permitsID = $_POST['ID'];
            $ids = $_POST["ids"];
            $Type_s = mysqli_real_escape_string($conn,$_POST["Type_s"]);
            $Descriptions = mysqli_real_escape_string($conn,$_POST["Descriptions"]);
            $Issue_Date = mysqli_real_escape_string($conn,$_POST["Issue_Date"]);
            $Expiration_Date = mysqli_real_escape_string($conn,$_POST["Expiration_Date"]);
            
            mysqli_query($conn,"update tblFacilityDetails_Permits set Type_s ='$Type_s',Descriptions='$Descriptions',Issue_Date='$Issue_Date',Expiration_Date='$Expiration_Date' where Permits_id='$permitsID'");  
           echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#fo";</script>';
        }
    }
    
    //Allergen and Quality System Functions
    if(isset($_POST["btn_aqs_function"]))
        {
        $aAllergens = '';
        $qQuality_System = '';
        $userID = $_COOKIE['ID'];
        $ids = $_POST["ids"];
        $Allergens_specify = $_POST["Allergens_specify"];
        $Quality_System_specify = $_POST["Quality_System_specify"];
    
        if(!empty($_POST["Allergens"]))
        {
            foreach($_POST["Allergens"] as $Allergens)
            {
                        $aAllergens .= $Allergens . ', ';
            }
            
        }
        if(!empty($_POST["Quality_System"]))
            {
                foreach($_POST["Quality_System"] as $Quality_System)
                    {
                        $qQuality_System .= $Quality_System . ', ';
                    }
                    
            }
        
        $qQuality_System = substr($qQuality_System, 0, -2);
        $aAllergens = substr($aAllergens, 0, -2);
        mysqli_query($conn,"update tblFacilityDetails set Quality_System ='$qQuality_System', Allergens='$aAllergens', Allergens_specify='$Allergens_specify', Quality_System_specify='$Quality_System_specify' where facility_id='$ids'");  
       echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#aq";</script>';
    }
    
    //btnOrganizationUpdate
    if(isset($_POST["btnOrganizationUpdate"])) {
       
        $ID = $_POST['ID'];
        $ids = $_POST["ids"];
        $Organization_name = $_POST["Organization_name"];
        $Organization_last_name = $_POST["Organization_last_name"];
        $Organization_title = $_POST["Organization_title"];
        $Organization_cellno = $_POST["Organization_cellno"];
        $Organization_phone = $_POST["Organization_phone"];
        $Organization_emailAddress = $_POST["Organization_emailAddress"];
    
        
        mysqli_query($conn,"update tblFacilityDetails_Facility_Organization set Organization_name ='$Organization_name', Organization_last_name='$Organization_last_name', Organization_title='$Organization_title', Organization_cellno='$Organization_cellno', Organization_phone='$Organization_phone', Organization_emailAddress='$Organization_emailAddress' where Org_id='$ID'");  
       echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#ro";</script>';
    }
    
    //btnOrganizationUpdate
    if(isset($_POST["btnService_Team"])) {
       
        $ID = $_POST['ID'];
        $ids = $_POST["ids"];
        $Service_Team_name = $_POST["Service_Team_name"];
        $Service_Team_last_name = $_POST["Service_Team_last_name"];
        $Service_Team_title = $_POST["Service_Team_title"];
        $Service_Team_cellno = $_POST["Service_Team_cellno"];
        $Service_Team_phone = $_POST["Service_Team_phone"];
        $Service_Team_emailAddress = $_POST["Service_Team_emailAddress"];
    
        
        mysqli_query($conn,"update tblFacilityDetails_Service_Team set Service_Team_name ='$Service_Team_name', Service_Team_last_name='$Service_Team_last_name', Service_Team_title='$Service_Team_title', Service_Team_cellno='$Service_Team_cellno', Service_Team_phone='$Service_Team_phone', Service_Team_emailAddress='$Service_Team_emailAddress' where Service_Team_id='$ID'");  
       echo '<script> window.location.href = "../facility-info?facility_id='.$ids.'#cc";</script>';
    }
    if(isset($_POST["btnViewCMT_Update"])) {
       
        $critical_operation_id  = $_POST['ID'];
        $assign_area  = $_POST['assign_area'];
        $addOperationField = $_POST["addOperationField"];
        $addPrimaryNameField = $_POST["addPrimaryNameField"];
        $addAlternateNameField = $_POST["addAlternateNameField"];
        
        mysqli_query($conn,"update tbl_critical_operation SET addOperationField ='$addOperationField', addPrimaryNameField='$addPrimaryNameField', addAlternateNameField='$addAlternateNameField' WHERE critical_operation_id ='$critical_operation_id '");  
        echo '<script> window.location.href = "../facility-info?facility_id='.$assign_area.'#cc";</script>';
    }
?>