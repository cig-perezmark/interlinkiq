 <?php
 
 
    include_once 'database.php';
    if(isset($_POST["submit"]))
    {
            $rRegulatory = '';
            $bStructure = '';
            $cCertification = '';
            $aAccreditation = '';
            
            $eEnterpriseFunction = '';
            $bBusinessPROCESS = '';
            $sServicesOffering = '';
            $qQualitySystem = '';
            
            // $user = $_COOKIE['ID'];
            if (isset($_COOKIE['switchAccount'])) { $user = $_COOKIE['switchAccount']; }
            else { $user = $_COOKIE['ID']; }
                                    
            $businessname = $_POST["businessname"];
            $businessaddress = $_POST["businessaddress"];
            $businesstelephone = $_POST["businesstelephone"];
            $businessfax = $_POST["businessfax"];
            $businessemailAddress = $_POST["businessemailAddress"];
            $businesswebsite = $_POST["businesswebsite"];
            
            $contactpersonname = $_POST["contactpersonname"];
            $title = $_POST["title"];
            $contactpersonaddress = $_POST["contactpersonaddress"];
            $contactpersoncellno = $_POST["contactpersoncellno"];
            $contactpersonphone = $_POST["contactpersonphone"];
            $contactpersonfax = $_POST["contactpersonfax"];
            $contactpersonemailAddress = $_POST["contactpersonemailAddress"];
            
            $emergencyname = $_POST["emergencyname"];
            $emergencytitle = $_POST["emergencytitle"];
            $emergencyaddress = $_POST["emergencyaddress"];
            $emergencycellno = $_POST["emergencycellno"];
            $emergencyphone = $_POST["emergencyphone"];
            $emergencyfax = $_POST["emergencyfax"];
            $emergencyemailAddress = $_POST["emergencyemailAddress"];
            
             // for upload bs file
                $bSfilename = $_FILES['SolePropreitorship']['name'];
                move_uploaded_file($_FILES['SolePropreitorship']['tmp_name'],'companyDetailsFolder/'.$bSfilename);
                $GeneralPartnership = $_FILES['GeneralPartnership']['name'];
                move_uploaded_file($_FILES['GeneralPartnership']['tmp_name'],'companyDetailsFolder/'.$GeneralPartnership);
                $Corporation = $_FILES['Corporation']['name'];
                move_uploaded_file($_FILES['Corporation']['tmp_name'],'companyDetailsFolder/'.$Corporation);
                $LimitedLiabilityCompany = $_FILES['LimitedLiabilityCompany']['name'];
                move_uploaded_file($_FILES['LimitedLiabilityCompany']['tmp_name'],'companyDetailsFolder/'.$LimitedLiabilityCompany);
                $LimitedPartnership = $_FILES['LimitedPartnership']['name'];
                move_uploaded_file($_FILES['LimitedPartnership']['tmp_name'],'companyDetailsFolder/'.$LimitedPartnership);
                $LimitedLiabilityParnership = $_FILES['LimitedLiabilityParnership']['name'];
                move_uploaded_file($_FILES['LimitedLiabilityParnership']['tmp_name'],'companyDetailsFolder/'.$LimitedLiabilityParnership);
                $otherbStructurefile = $_FILES['otherbStructurefile']['name'];
                move_uploaded_file($_FILES['otherbStructurefile']['tmp_name'],'companyDetailsFolder/'.$otherbStructurefile);
            // end for upload bs file
            
            $othersBusinessStructure = $_POST["othersBusinessStructure"];
            $BusinessPurpose = $_POST["BusinessPurpose"];
            $TrademarkName = $_POST["TrademarkName"];
            
            $TrademarkNameFile = $_FILES['TrademarkNameFile']['name'];
            move_uploaded_file($_FILES['TrademarkNameFile']['tmp_name'],'companyDetailsFolder/'.$TrademarkNameFile);
            
            $Tradename = $_POST["Tradename"];
            $Headquarters = $_POST["Headquarters"];
            $ParentCompanyName = $_POST["ParentCompanyName"];
            $YearEstablished = $_POST["YearEstablished"];
            $Dunn = $_POST["Dunn"];
            $othersCertification = $_POST["othersCertification"];
            
            
            // for upload cetification file
                $GFSIFILE = $_FILES['GFSIFILE']['name'];
                move_uploaded_file($_FILES['GFSIFILE']['tmp_name'],'companyDetailsFolder/'.$GFSIFILE);
                $SQFFILE = $_FILES['SQFFILE']['name'];
                move_uploaded_file($_FILES['SQFFILE']['tmp_name'],'companyDetailsFolder/'.$SQFFILE);
                $BRCFILE = $_FILES['BRCFILE']['name'];
                move_uploaded_file($_FILES['BRCFILE']['tmp_name'],'companyDetailsFolder/'.$BRCFILE);
                $FSSC22000FILE = $_FILES['FSSC22000FILE']['name'];
                move_uploaded_file($_FILES['FSSC22000FILE']['tmp_name'],'companyDetailsFolder/'.$FSSC22000FILE);
                $ISOFILE = $_FILES['ISOFILE']['name'];
                move_uploaded_file($_FILES['ISOFILE']['tmp_name'],'companyDetailsFolder/'.$ISOFILE);
                $PrimusGFSFILE = $_FILES['PrimusGFSFILE']['name'];
                move_uploaded_file($_FILES['PrimusGFSFILE']['tmp_name'],'companyDetailsFolder/'.$PrimusGFSFILE);
                $HACCPFILE = $_FILES['HACCPFILE']['name'];
                move_uploaded_file($_FILES['HACCPFILE']['tmp_name'],'companyDetailsFolder/'.$HACCPFILE);
                $GMPFILE = $_FILES['GMPFILE']['name'];
                move_uploaded_file($_FILES['GMPFILE']['tmp_name'],'companyDetailsFolder/'.$GMPFILE);
                $OthersFILE = $_FILES['OthersFILE']['name'];
                move_uploaded_file($_FILES['OthersFILE']['tmp_name'],'companyDetailsFolder/'.$OthersFILE);
            // end for upload cetification file
            $othersAccreditation = $_POST["othersAccreditation"];
             // for upload cetification file
                $OrganicFile = $_FILES['OrganicFile']['name'];
                move_uploaded_file($_FILES['OrganicFile']['tmp_name'],'companyDetailsFolder/'.$OrganicFile);
                $HalalFile = $_FILES['HalalFile']['name'];
                move_uploaded_file($_FILES['HalalFile']['tmp_name'],'companyDetailsFolder/'.$HalalFile);
                $KosherFile = $_FILES['KosherFile']['name'];
                move_uploaded_file($_FILES['KosherFile']['tmp_name'],'companyDetailsFolder/'.$KosherFile);
                $NonGMOFile = $_FILES['NonGMOFile']['name'];
                move_uploaded_file($_FILES['NonGMOFile']['tmp_name'],'companyDetailsFolder/'.$NonGMOFile);
                $PlantBasedFile = $_FILES['PlantBasedFile']['name'];
                move_uploaded_file($_FILES['PlantBasedFile']['tmp_name'],'companyDetailsFolder/'.$PlantBasedFile);
                $othersAccreditationFile = $_FILES['othersAccreditationFile']['name'];
                move_uploaded_file($_FILES['othersAccreditationFile']['tmp_name'],'companyDetailsFolder/'.$othersAccreditationFile);  
            // end for upload cetification file
             $othersRegulatory = $_POST["othersRegulatory"];
              // for upload FDAfile file
                $FDAfile = $_FILES['FDAfile']['name'];
                move_uploaded_file($_FILES['FDAfile']['tmp_name'],'companyDetailsFolder/'.$FDAfile);
                $USDAfile = $_FILES['USDAfile']['name'];
                move_uploaded_file($_FILES['USDAfile']['tmp_name'],'companyDetailsFolder/'.$USDAfile);
                $OthersRegulatoryfile = $_FILES['OthersRegulatoryfile']['name'];
                move_uploaded_file($_FILES['OthersRegulatoryfile']['tmp_name'],'companyDetailsFolder/'.$OthersRegulatoryfile);
                
            // end for upload cetification file
            
            $EnterpriseRecordsFile = $_FILES['EnterpriseRecordsFile']['name'];
            move_uploaded_file($_FILES['EnterpriseRecordsFile']['tmp_name'],'companyDetailsFolder/'.$EnterpriseRecordsFile);
            $DocumentTitle = $_POST["DocumentTitle"];
            $DocumentDesciption = $_POST["DocumentDesciption"];
            $DocumentDueDate = $_POST["DocumentDueDate"];
            $enterpriseOperation = $_POST["enterpriseOperation"];
            $enterpriseEmployees = $_POST["enterpriseEmployees"];
            $SafetyCodes = $_POST["SafetyCodes"];
            
             if(!empty($_POST["EnterpriseFunction"]))
               {
                if(!empty($_POST["BusinessPROCESS"]))
               {
                if(!empty($_POST["ServicesOffering"]))
               {
                if(!empty($_POST["QualitySystem"]))
               {
             if(!empty($_POST["Regulatory"]))
               {
             if(!empty($_POST["Accreditation"]))
               {
            if(!empty($_POST["Certification"]))
               {
                if(!empty($_POST["BusinessStructure"]))
               {
                foreach($_POST["BusinessStructure"] as $BusinessStructure)
                {
                 $bStructure .= $BusinessStructure . ', ';
                }
                foreach($_POST["Certification"] as $Certification)
                {
                 $cCertification .= $Certification . ', ';
                }
                foreach($_POST["Accreditation"] as $Accreditation)
                {
                 $aAccreditation .= $Accreditation . ', ';
                }
                foreach($_POST["Regulatory"] as $Regulatory)
                {
                 $rRegulatory .= $Regulatory . ', ';
                }
                foreach($_POST["EnterpriseFunction"] as $EnterpriseFunction)
                {
                 $eEnterpriseFunction .= $EnterpriseFunction . ', ';
                }
                foreach($_POST["BusinessPROCESS"] as $BusinessPROCESS)
                {
                 $bBusinessPROCESS .= $BusinessPROCESS . ', ';
                }
                foreach($_POST["ServicesOffering"] as $ServicesOffering)
                {
                 $sServicesOffering .= $ServicesOffering . ', ';
                }
                foreach($_POST["QualitySystem"] as $QualitySystem)
                {
                 $qQualitySystem .= $QualitySystem . ', ';
                }
                
                $bStructure = substr($bStructure, 0, -2);
                $cCertification = substr($cCertification, 0, -2);
                $aAccreditation = substr($aAccreditation, 0, -2);
                $rRegulatory = substr($rRegulatory, 0, -2);
                
                $eEnterpriseFunction = substr($eEnterpriseFunction, 0, -2);
                $bBusinessPROCESS = substr($bBusinessPROCESS, 0, -2);
                $sServicesOffering = substr($sServicesOffering, 0, -2);
                $qQualitySystem = substr($qQualitySystem, 0, -2);
                $query = "INSERT INTO tblEnterpiseDetails (businessname,businessaddress,businesstelephone,businessfax,businessemailAddress,businesswebsite,users_entities,contactpersonname,title,contactpersonaddress,contactpersoncellno,contactpersonphone,contactpersonfax,contactpersonemailAddress,emergencyname,emergencytitle,emergencyaddress,emergencycellno,emergencyphone,emergencyfax,emergencyemailAddress,BusinessStructure,SolePropreitorship,GeneralPartnership,Corporation,LimitedLiabilityCompany,LimitedPartnership,LimitedLiabilityParnership,otherbStructurefile,othersBusinessStructure,BusinessPurpose,TrademarkName,TrademarkNameFile,Tradename,Headquarters,ParentCompanyName,YearEstablished,Dunn,Certification,othersCertification,GFSIFILE, SQFFILE, BRCFILE, FSSC22000FILE, ISOFILE, PrimusGFSFILE, HACCPFILE, GMPFILE, OthersFILE,Accreditation,othersAccreditation,OrganicFile,HalalFile,KosherFile,NonGMOFile,PlantBasedFile,othersAccreditationFile,Regulatory, othersRegulatory,FDAfile, USDAfile, OthersRegulatoryfile,EnterpriseRecordsFile, DocumentTitle , DocumentDesciption , DocumentDueDate,enterpriseOperation , enterpriseEmployees , EnterpriseFunction, BusinessPROCESS, ServicesOffering, QualitySystem, SafetyCodes) VALUES ('$businessname','$businessaddress','$businesstelephone','$businessfax','$businessemailAddress','$businesswebsite','$user','$contactpersonname','$title','$contactpersonaddress','$contactpersoncellno','$contactpersonphone','$contactpersonfax','$contactpersonemailAddress','$emergencyname','$emergencytitle','$emergencyaddress','$emergencycellno','$emergencyphone','$emergencyfax','$emergencyemailAddress','$bStructure','$bSfilename','$GeneralPartnership','$Corporation','$LimitedLiabilityCompany','$LimitedPartnership','$LimitedLiabilityParnership','$otherbStructurefile','$othersBusinessStructure','$BusinessPurpose','$TrademarkName','$TrademarkNameFile','$Tradename','$Headquarters','$ParentCompanyName','$YearEstablished','$Dunn','$cCertification','$othersCertification','$GFSIFILE', '$SQFFILE', '$BRCFILE', '$FSSC22000FILE', '$ISOFILE', '$PrimusGFSFILE', '$HACCPFILE', '$GMPFILE', '$OthersFILE','$aAccreditation','$othersAccreditation','$OrganicFile','$HalalFile','$KosherFile','$NonGMOFile','$PlantBasedFile','$othersAccreditationFile','$rRegulatory', '$othersRegulatory','$FDAfile', '$USDAfile', '$OthersRegulatoryfile','$EnterpriseRecordsFile', '$DocumentTitle' , '$DocumentDesciption' , '$DocumentDueDate','$enterpriseOperation' , '$enterpriseEmployees' , '$eEnterpriseFunction' , '$bBusinessPROCESS', '$sServicesOffering', '$qQualitySystem', '$SafetyCodes')";
                if(mysqli_query($conn, $query))
                {
                      echo '<script> window.location.href = "enterprise-details";</script>';
                }
               }
               }
            }
              }
               }
               }
               }
               }
                 else
                {
                       echo '<script> window.location.href = "enterprise-details";</script>'; 
                } 
    }
    //   for update
    
     if(isset($_POST["submitUpdate"]))
    {
             
             //   for update
             $bStructure = '';
            $dateUpdated = date("Y/m/d");
            $ids = $_POST["idss"];
            $businessname = $_POST["businessname"];
            $businessaddress = $_POST["businessaddress"];
            $businesstelephone = $_POST["businesstelephone"];
            $businessfax = $_POST["businessfax"];
            $businessemailAddress = $_POST["businessemailAddress"];
            $businesswebsite = $_POST["businesswebsite"];
            
            $contactpersonname = $_POST["contactpersonname"];
            $title = $_POST["title"];
            $contactpersonaddress = $_POST["contactpersonaddress"];
            $contactpersoncellno = $_POST["contactpersoncellno"];
            $contactpersonphone = $_POST["contactpersonphone"];
            $contactpersonfax = $_POST["contactpersonfax"];
            $contactpersonemailAddress = $_POST["contactpersonemailAddress"];
            
            $emergencyname = $_POST["emergencyname"];
            $emergencytitle = $_POST["emergencytitle"];
            $emergencyaddress = $_POST["emergencyaddress"];
            $emergencycellno = $_POST["emergencycellno"];
            $emergencyphone = $_POST["emergencyphone"];
            $emergencyfax = $_POST["emergencyfax"];
            $emergencyemailAddress = $_POST["emergencyemailAddress"];
            $countbSfiles = count($_FILES['bStructurefile']['name']);
            
            // for upload bs file
                $bSfilename = $_FILES['SolePropreitorship']['name'];
                move_uploaded_file($_FILES['SolePropreitorship']['tmp_name'],'companyDetailsFolder/'.$bSfilename);
                $GeneralPartnership = $_FILES['GeneralPartnership']['name'];
                move_uploaded_file($_FILES['GeneralPartnership']['tmp_name'],'companyDetailsFolder/'.$GeneralPartnership);
                $Corporation = $_FILES['Corporation']['name'];
                move_uploaded_file($_FILES['Corporation']['tmp_name'],'companyDetailsFolder/'.$Corporation);
                $LimitedLiabilityCompany = $_FILES['LimitedLiabilityCompany']['name'];
                move_uploaded_file($_FILES['LimitedLiabilityCompany']['tmp_name'],'companyDetailsFolder/'.$LimitedLiabilityCompany);
                $LimitedPartnership = $_FILES['LimitedPartnership']['name'];
                move_uploaded_file($_FILES['LimitedPartnership']['tmp_name'],'companyDetailsFolder/'.$LimitedPartnership);
                $LimitedLiabilityParnership = $_FILES['LimitedLiabilityParnership']['name'];
                move_uploaded_file($_FILES['LimitedLiabilityParnership']['tmp_name'],'companyDetailsFolder/'.$LimitedLiabilityParnership);
                $otherbStructurefile = $_FILES['otherbStructurefile']['name'];
                move_uploaded_file($_FILES['otherbStructurefile']['tmp_name'],'companyDetailsFolder/'.$otherbStructurefile);
            // end for upload bs file
            if(!empty($_POST["BusinessStructure"]))
               {
                foreach($_POST["BusinessStructure"] as $BusinessStructure)
                {
                 $bStructure .= $BusinessStructure . ', ';
                }
                $bStructure = substr($bStructure, 0, -2);
                $updateQuery = "UPDATE tblEnterpiseDetails SET businessname='$businessname',businessaddress='$businessaddress',businesstelephone='$businesstelephone',businessfax='$businessfax',businessemailAddress='$businessemailAddress',businesswebsite='$businesswebsite',enterpUpdated='$dateUpdated',contactpersonname='$contactpersonname',title='$title',contactpersonaddress='$contactpersonaddress',contactpersoncellno='$contactpersoncellno',contactpersonphone='$contactpersonphone',contactpersonfax='$contactpersonfax',contactpersonemailAddress='$contactpersonemailAddress',emergencyname = '$emergencyname',emergencytitle = '$emergencytitle',emergencyaddress = '$emergencyaddress',emergencycellno = '$emergencycellno',emergencyphone = '$emergencyphone',emergencyfax = '$emergencyfax',emergencyemailAddress = '$emergencyemailAddress', BusinessStructure = '$bStructure' , SolePropreitorship ='$bSfilename' ,GeneralPartnership = '$GeneralPartnership',Corporation = '$Corporation',LimitedLiabilityCompany = '$LimitedLiabilityCompany',LimitedPartnership = '$LimitedPartnership',LimitedLiabilityParnership = '$LimitedLiabilityParnership',otherbStructurefile = '$otherbStructurefile'  WHERE enterp_id=$ids";
                if(mysqli_query($conn, $updateQuery))
                {
                      echo '<script> window.location.href = "enterprise-details";</script>'; 
                }
                
             }
            else
            {
              echo '<script> window.location.href = "enterprise-details";</script>'; 
            }
        }
?>