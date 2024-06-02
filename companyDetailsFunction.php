 <?php
           include_once 'database.php';
        
if($_POST['ids'] == ''){
     if(isset($_POST["submitnew"]))
          {
           $bType = '';
           $oType = '';
            $user = $_COOKIE['ID'];
            $purpose = $_POST["purpose"];
            $companyName = $_POST["companyName"];
            $description = $_POST["description"];
            $primaryContact = $_POST["primaryContact"];
            $address = $_POST["address"];
            $City_State_Zip = $_POST["City_State_Zip"];
            $country = $_POST["country"];
            $telephone = $_POST["telephone"];
            $fax = $_POST["fax"];
            $emailAddress = $_POST["emailAddress"];
            $website = $_POST["website"];
            $trademarkName = $_POST["trademarkName"];
            $tradenames = $_POST["tradenames"];
            $headquarters = $_POST["headquarters"];
            $productionPlant = $_POST["productionPlant"];
            $parentCompany = $_POST["parentCompany"];
            $subsidiaries = $_POST["subsidiaries"];
            $yearEstablished	= $_POST["yearEstablished"];
            
            $inspectionAudit1 = $_POST["inspectionAudit1"];
            $inspectionAudit2 = $_POST["inspectionAudit2"];
            $inspectionAudit3 = $_POST["inspectionAudit3"];
            $auditType1 = $_POST["auditType1"];
            $auditType2 = $_POST["auditType2"];
            $auditType3 = $_POST["auditType3"];
            $auditSegment1 = $_POST["auditSegment1"];
            $auditSegment2 = $_POST["auditSegment2"];
            $auditSegment3 = $_POST["auditSegment3"];
            $inspectionAuthority1 = $_POST["inspectionAuthority1"];
            $inspectionAuthority2 = $_POST["inspectionAuthority2"];
            $inspectionAuthority3 = $_POST["inspectionAuthority3"];
            $scopeCertification1 = $_POST["scopeCertification1"];
            $scopeCertification2 = $_POST["scopeCertification2"];
            $scopeCertification3 = $_POST["scopeCertification3"];
            $ratingStatus1 = $_POST["ratingStatus1"];
            $ratingStatus2 = $_POST["ratingStatus2"];
            $ratingStatus3 = $_POST["ratingStatus3"];
            
            $businessActivity = $_POST["businessActivity"];
            $certifications = $_POST["certifications"];
            $operationsManager = $_POST["operationsManager"];
            $emailOM = $_POST["emailOM"];
            $phoneNumberOM = $_POST["phoneNumberOM"];
            $qualityAssurance = $_POST["qualityAssurance"];
            $emailQA = $_POST["emailQA"];
            $phoneNuberQA = $_POST["phoneNuberQA"];
            $SQFPractitioner = $_POST["SQFPractitioner"];
            $emailSP = $_POST["emailSP"];
            $phoneNumberSP = $_POST["phoneNumberSP"];
            $documentApprover = $_POST["documentApprover"];
            $emailDA = $_POST["emailDA"];
            $phoneNumberDA = $_POST["phoneNumberDA"];
            $employees = $_POST["employees"];
            $languages = $_POST["languages"];
            $othersBusiness = $_POST["othersBusiness"];
            $othersOrg = $_POST["othersOrg"];
            
            $partnerOwners1 = $_POST["partnerOwners1"];
            $partnerOwners2 = $_POST["partnerOwners2"];
            $partnerOwners3 = $_POST["partnerOwners3"];
            $assignedCoordinator = $_POST["assignedCoordinator"];
            $alternateCoordinator = $_POST["alternateCoordinator"];
            
           
            $filename1 = $_FILES['plantFacility']['name'];
            $file1 = $_FILES['plantFacility']['tmp_name'];
            $filename2 = $_FILES['auditInformations']['name'];
            $file2 = $_FILES['auditInformations']['tmp_name'];
            $destination1 = 'companyDetailsFolder/' . $filename1;
            $destination2 = 'companyDetailsFolder/' . $filename2;
            
            move_uploaded_file($file1, $destination1);
            move_uploaded_file($file2, $destination2);
            
            if(!empty($_POST["organizationType"]))
            {
               if(!empty($_POST["businessType"]))
               {
                foreach($_POST["businessType"] as $businessType)
                {
                 $bType .= $businessType . ', ';
                }
                foreach($_POST["organizationType"] as $organizationType)
                {
                 $oType .= $organizationType . ', ';
                }
                $bType = substr($bType, 0, -2);
                $query = "INSERT INTO tbl_companyDetails (purpose,companyName,description,primaryContact,address,City_State_Zip,country,telephone,fax,emailAddress,website,trademarkName,tradenames,headquarters,productionPlant,parentCompany,subsidiaries,yearEstablished,inspectionAudit1,inspectionAudit2,inspectionAudit3,auditType1,auditType2,auditType3,auditSegment1,auditSegment2,auditSegment3,inspectionAuthority1,inspectionAuthority2,inspectionAuthority3,scopeCertification1,scopeCertification2,scopeCertification3,ratingStatus1,ratingStatus2,ratingStatus3,businessActivity,certifications,businessType,operationsManager,emailOM,phoneNumberOM,qualityAssurance,emailQA,phoneNuberQA,SQFPractitioner,emailSP,phoneNumberSP,documentApprover,emailDA,phoneNumberDA,employees,languages,organizationType,partnerOwners1,partnerOwners2,partnerOwners3,assignedCoordinator,alternateCoordinator,plantFacility,auditInformations,othersBusiness,othersOrg,usersEntities) VALUES ('$purpose','$companyName','$description','$primaryContact','$address','$City_State_Zip','$country','$telephone','$fax','$emailAddress','$website','$trademarkName','$tradenames','$headquarters','$productionPlant','$parentCompany','$subsidiaries','$yearEstablished','$inspectionAudit1','$inspectionAudit2','$inspectionAudit3','$auditType1','$auditType2','$auditType3','$auditSegment1','$auditSegment2','$auditSegment3','$inspectionAuthority1','$inspectionAuthority2','$inspectionAuthority3','$scopeCertification1','$scopeCertification2','$scopeCertification3','$ratingStatus1','$ratingStatus2','$ratingStatus3','$businessActivity','$certifications','$bType','$operationsManager','$emailOM','$phoneNumberOM','$qualityAssurance','$emailQA','$phoneNuberQA','$SQFPractitioner','$emailSP','$phoneNumberSP','$documentApprover','$emailDA','$phoneNumberDA','$employees','$languages','$organizationType','$partnerOwners1','$partnerOwners2','$partnerOwners3','$assignedCoordinator','$alternateCoordinator','$filename1','$filename2','$othersBusiness','$othersOrg','$user')";
                if(mysqli_query($conn, $query))
                {
                      echo '<script> window.location.href = "company-details";</script>';
                }
               }
               else
               {
                echo "<label class='text-danger'>* Error</label>";
               }
              }
          }
}else{
     //   for update
         if(isset($_POST["submitnew"]))
          {
            $dateUpdated = date("Y/m/d");
           $bType = '';
           $oType = '';
            $user = $_COOKIE['ID'];
             $ids = $_POST["ids"];
            $purpose = $_POST["purpose"];
            $companyName = $_POST["companyName"];
            $description = $_POST["description"];
            $primaryContact = $_POST["primaryContact"];
            $address = $_POST["address"];
            $City_State_Zip = $_POST["City_State_Zip"];
            $country = $_POST["country"];
            $telephone = $_POST["telephone"];
            $fax = $_POST["fax"];
            $emailAddress = $_POST["emailAddress"];
            $website = $_POST["website"];
            $trademarkName = $_POST["trademarkName"];
            $tradenames = $_POST["tradenames"];
            $headquarters = $_POST["headquarters"];
            $productionPlant = $_POST["productionPlant"];
            $parentCompany = $_POST["parentCompany"];
            $subsidiaries = $_POST["subsidiaries"];
            $yearEstablished	= $_POST["yearEstablished"];
            
            $inspectionAudit1 = $_POST["inspectionAudit1"];
            $inspectionAudit2 = $_POST["inspectionAudit2"];
            $inspectionAudit3 = $_POST["inspectionAudit3"];
            $auditType1 = $_POST["auditType1"];
            $auditType2 = $_POST["auditType2"];
            $auditType3 = $_POST["auditType3"];
            $auditSegment1 = $_POST["auditSegment1"];
            $auditSegment2 = $_POST["auditSegment2"];
            $auditSegment3 = $_POST["auditSegment3"];
            $inspectionAuthority1 = $_POST["inspectionAuthority1"];
            $inspectionAuthority2 = $_POST["inspectionAuthority2"];
            $inspectionAuthority3 = $_POST["inspectionAuthority3"];
            $scopeCertification1 = $_POST["scopeCertification1"];
            $scopeCertification2 = $_POST["scopeCertification2"];
            $scopeCertification3 = $_POST["scopeCertification3"];
            $ratingStatus1 = $_POST["ratingStatus1"];
            $ratingStatus2 = $_POST["ratingStatus2"];
            $ratingStatus3 = $_POST["ratingStatus3"];
            
            $businessActivity = $_POST["businessActivity"];
            $certifications = $_POST["certifications"];
            $operationsManager = $_POST["operationsManager"];
            $emailOM = $_POST["emailOM"];
            $phoneNumberOM = $_POST["phoneNumberOM"];
            $qualityAssurance = $_POST["qualityAssurance"];
            $emailQA = $_POST["emailQA"];
            $phoneNuberQA = $_POST["phoneNuberQA"];
            $SQFPractitioner = $_POST["SQFPractitioner"];
            $emailSP = $_POST["emailSP"];
            $phoneNumberSP = $_POST["phoneNumberSP"];
            $documentApprover = $_POST["documentApprover"];
            $emailDA = $_POST["emailDA"];
            $phoneNumberDA = $_POST["phoneNumberDA"];
            $employees = $_POST["employees"];
            $languages = $_POST["languages"];
            $othersBusiness = $_POST["othersBusiness"];
            $othersOrg = $_POST["othersOrg"];
            
            $partnerOwners1 = $_POST["partnerOwners1"];
            $partnerOwners2 = $_POST["partnerOwners2"];
            $partnerOwners3 = $_POST["partnerOwners3"];
            $assignedCoordinator = $_POST["assignedCoordinator"];
            $alternateCoordinator = $_POST["alternateCoordinator"];
            
           
            $filename1 = $_FILES['plantFacility']['name'];
            $file1 = $_FILES['plantFacility']['tmp_name'];
            $filename2 = $_FILES['auditInformations']['name'];
            $file2 = $_FILES['auditInformations']['tmp_name'];
            $destination1 = 'companyDetailsFolder/' . $filename1;
            $destination2 = 'companyDetailsFolder/' . $filename2;
            
            move_uploaded_file($file1, $destination1);
            move_uploaded_file($file2, $destination2);
            
            if(!empty($_POST["organizationType"]))
            {
               if(!empty($_POST["businessType"]))
               {
                foreach($_POST["businessType"] as $businessType)
                {
                 $bType .= $businessType . ', ';
                }
                foreach($_POST["organizationType"] as $organizationType)
                {
                 $oType .= $organizationType . ', ';
                }
                $bType = substr($bType, 0, -2);
                $updateQuery = "UPDATE tbl_companyDetails SET purpose='$purpose',companyName='$companyName' ,dateUpdated='$dateUpdated' ,description='$description' ,primaryContact='$primaryContact' ,address='$address' ,City_State_Zip='$City_State_Zip',country='$country' ,telephone='$telephone',fax='$fax' ,emailAddress='$emailAddress' ,website='$website' ,trademarkName='$trademarkName',tradenames='$tradenames' ,headquarters='$headquarters',productionPlant='$productionPlant' ,parentCompany='$parentCompany',subsidiaries='$subsidiaries' ,yearEstablished='$yearEstablished',inspectionAudit1='$inspectionAudit1' ,inspectionAudit2='$inspectionAudit2',inspectionAudit3='$inspectionAudit3' ,auditType1='$auditType1',auditType2='$auditType2',auditType3='$auditType3' ,auditSegment1='$auditSegment1',auditSegment2='$auditSegment2',auditSegment3='$auditSegment3' ,inspectionAuthority1='$inspectionAuthority1',inspectionAuthority2='$inspectionAuthority2',inspectionAuthority3='$inspectionAuthority3' ,scopeCertification1='$scopeCertification1',scopeCertification2='$scopeCertification2',scopeCertification3='$scopeCertification3' ,ratingStatus1='$ratingStatus1',ratingStatus2='$ratingStatus2',ratingStatus3='$ratingStatus3' ,businessActivity='$businessActivity',certifications='$certifications',businessType='$bType' ,operationsManager='$operationsManager',emailOM='$emailOM',phoneNumberOM='$phoneNumberOM' ,qualityAssurance='$qualityAssurance',emailQA='$emailQA',phoneNuberQA='$phoneNuberQA' ,SQFPractitioner='$SQFPractitioner',emailSP='$emailSP',phoneNumberSP='$phoneNumberSP' ,documentApprover='$documentApprover',emailDA='$emailDA',phoneNumberDA='$phoneNumberDA' ,employees='$employees',languages='$languages' ,organizationType='$oType' ,partnerOwners1='$partnerOwners1',partnerOwners2='$partnerOwners2',partnerOwners3='$partnerOwners3' ,assignedCoordinator='$assignedCoordinator',alternateCoordinator='$alternateCoordinator' ,plantFacility='$filename1',auditInformations='$filename2' ,othersBusiness='$othersBusiness',othersOrg='$othersOrg' WHERE details_id=$ids";
                if(mysqli_query($conn, $updateQuery))
                {
                   echo '<script> window.location.href = "company-details";</script>'; 
                }
               }
               else
               {
                echo "<label class='text-danger'>* Error</label>";
               }
              }
          }
}
         
          
       
                  
          ?>