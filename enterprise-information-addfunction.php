<?php
// $link = mysqli_connect("localhost", "brandons_interlinkiq", "L1873@2019new", "brandons_interlinkiq");
 include('database.php');
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
 if(isset($_POST['submitLN'])){
    $timestring = new DateTime();
    $now = $timestring->format('Y-m-d h:i:s');
    $no_images = "no_images.png";
    
    if (isset($_COOKIE['switchAccount'])) { $userID = $_COOKIE['switchAccount']; }
    else { $userID = $_COOKIE['ID']; }
    
    $name = mysqli_real_escape_string($conn, $_REQUEST['LegalNameNew']);
    $cage = mysqli_real_escape_string($conn, $_REQUEST['cage']);
    $country = mysqli_real_escape_string($conn, $_REQUEST['country']);
    $Bldg = mysqli_real_escape_string($conn, $_REQUEST['Bldg']);
    $city = mysqli_real_escape_string($conn, $_REQUEST['city']);
    $States = mysqli_real_escape_string($conn, $_REQUEST['States']);
    $ZipCode = mysqli_real_escape_string($conn, $_REQUEST['ZipCode']);
    $businesstelephone = mysqli_real_escape_string($conn, $_REQUEST['businesstelephone']);
    $businessfax = mysqli_real_escape_string($conn, $_REQUEST['businessfax']);
    $emailAddress = mysqli_real_escape_string($conn, $_REQUEST['businessemailAddress']);
    $businessemailAddress = str_replace(' ', '', $emailAddress);
    $businesswebsite = mysqli_real_escape_string($conn, $_REQUEST['businesswebsite']);
    // Attempt insert query execution
    $sql = "INSERT INTO tblEnterpiseDetails (BrandLogos,businessname,cage,country,Bldg,city,States,ZipCode,businessaddress,businesstelephone,businessfax,businessemailAddress,businesswebsite,contactpersonname,contactpersonlastname,title,contactpersonaddress,contactpersoncellno,contactpersonphone,contactpersonfax,contactpersonemailAddress,emergencyname,emergencycontact_last_name,emergency_contact_title,emergencyaddress,emergencycellno,emergencyphone,emergencyfax,emergencyemailAddress,BusinessStructure,SolePropreitorship,SolePropreitorship_File,GeneralPartnership,GeneralPartnership_File,Corporation,Corporation_File,LimitedLiabilityCompany,LimitedLiabilityCompany_File,LimitedPartnership,LimitedPartnership_File,LimitedLiabilityPartnership,LimitedLiabilityPartnership_File,otherbStructurefile,othersBusinessStructure,BusinessStructureSpecify,BusinessPurpose,AnnualGrossRevenue,trademarkStatus,TrademarkName,TrademarkNameFile,Tradename,Headquarters,ParentCompanyStates,ParentCompanycity,ParentCompanyZipCode,ParentCompanyName,YearEstablished,Dunn,DirectEmployee,EmployeeofParentCompany,SisterDivision,Subsidiary,ThirdParty,RelationshipEnterpriseStatus,AccountPayable,InformationSystem,CFO,Insurance,PrimaryAccountRepresntative,CEO,Marketing,FoodSafety,Operations,Executive,AccountReceivable,ProductSafety,Legal,Returns,Transportation,Compliance,Finance,HumanResources,Logistics,PurchaseOrder,Sales,Orders,positionEnterpriseStatus,positionEnterpriseOthers,Certification,othersCertification,GFSI,GFSIFILE,SQF,SQFFILE,BRC,BRCFILE,FSSC22000,FSSC22000FILE,ISO,ISOFILE,PrimusGFS,PrimusGFSFILE,HACCP,HACCPFILE,GMP,GMPFILE,CertificationOthers,OthersFILE,othersCertificationSpecify,Accreditation,othersAccreditation,Organic,OrganicFile,Halal,HalalFile,Kosher,KosherFile,NonGMO,NonGMOFile,PlantBased,PlantBasedFile,FacilityAccreditationOthers,othersAccreditationFile,FacilityAccreditationSpecify,FacilityAccreditationNone,FDA,othersRegulatory,FDAfile,USDA,USDAfile,ComplianceRequirementsOthers,ComplianceRequirementsfile,ComplianceRequirementsOthersSpecify,ComplianceRequirementsOthersNone,OthersRegulatoryfile,EnterpriseRecordsFile,DocumentTitle,DocumentDesciption,DocumentDueDate,enterpriseOperation,enterpriseEmployees,enterpriseImporter,enterpriseProducts,enterpriseServices,NumberofEmployees,Country_importer,ProductDesc,enterpriseexporter,Country_exporter,EnterpriseFunction,BusinessPROCESS,EnterpriseProcessSpecify,ServicesOffering,QualitySystem,SafetyCodes, users_entities,downloads) VALUES ('$no_images','$name','$cage','$country','$Bldg','$city','$States','$ZipCode',' ','$businesstelephone','$businessfax','$businessemailAddress','$businesswebsite',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ','$now',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ', '', '$userID',' ')";
    if(mysqli_query($conn, $sql)){
    echo '<script> window.location.href = "enterprise-info";</script>';
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
 }
// Close connection
mysqli_close($conn);
?>
