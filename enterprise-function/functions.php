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

    if(isset($_POST['btnSave_bs'])){
        $SolePropreitorship = mysqli_real_escape_string($conn,$_POST['SolePropreitorship']);
        $GeneralPartnership = mysqli_real_escape_string($conn,$_POST['GeneralPartnership']);
        $Corporation = mysqli_real_escape_string($conn,$_POST['Corporation']);
        $LimitedLiabilityCompany = mysqli_real_escape_string($conn,$_POST['LimitedLiabilityCompany']);
        $LimitedPartnership = mysqli_real_escape_string($conn,$_POST['LimitedPartnership']);
        $LimitedLiabilityPartnership = mysqli_real_escape_string($conn,$_POST['LimitedLiabilityPartnership']);
        $othersBusinessStructure = mysqli_real_escape_string($conn,$_POST['othersBusinessStructure']);
        $BusinessStructureSpecify = mysqli_real_escape_string($conn,$_POST['BusinessStructureSpecify']);
        
        $file1 = $_FILES['SolePropreitorship_File']['name'];
        if(!empty($file1))
        {
            $filename = pathinfo($file1, PATHINFO_FILENAME);
            $extension = end(explode(".", $_FILES['SolePropreitorship_File']['name']));
            $rand = rand(10,1000000);
            $file_attch =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
            $SolePropreitorship_File = $rand." - ".$filename.".".$extension;
            move_uploaded_file($_FILES['SolePropreitorship_File']['tmp_name'],'../companyDetailsFolder/'.$SolePropreitorship_File);
        }
        else{ $SolePropreitorship_File =  $_POST['SolePropreitorship_Files'];}
        
        $file2 = $_FILES['GeneralPartnership_File']['name'];
        if(!empty($file2))
        {
            $filename = pathinfo($file2, PATHINFO_FILENAME);
            $extension = end(explode(".", $_FILES['GeneralPartnership_File']['name']));
            $rand = rand(10,1000000);
            $file_attch =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
            $GeneralPartnership_File = $rand." - ".$filename.".".$extension;
            move_uploaded_file($_FILES['GeneralPartnership_File']['tmp_name'],'../companyDetailsFolder/'.$GeneralPartnership_File);
        }
        else{ $GeneralPartnership_File =  $_POST['GeneralPartnership_Files'];}
        
        $file3 = $_FILES['Corporation_File']['name'];
        if(!empty($file3))
        {
            $filename = pathinfo($file3, PATHINFO_FILENAME);
            $extension = end(explode(".", $_FILES['Corporation_File']['name']));
            $rand = rand(10,1000000);
            $file_attch =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
            $Corporation_File = $rand." - ".$filename.".".$extension;
            move_uploaded_file($_FILES['Corporation_File']['tmp_name'],'../companyDetailsFolder/'.$Corporation_File);
        }
        else{ $Corporation_File =  $_POST['Corporation_Files'];}
        
        $file4 = $_FILES['LimitedLiabilityCompany_File']['name'];
        if(!empty($file4))
        {
            $filename = pathinfo($file4, PATHINFO_FILENAME);
            $extension = end(explode(".", $_FILES['LimitedLiabilityCompany_File']['name']));
            $rand = rand(10,1000000);
            $file_attch =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
            $LimitedLiabilityCompany_File = $rand." - ".$filename.".".$extension;
            move_uploaded_file($_FILES['LimitedLiabilityCompany_File']['tmp_name'],'../companyDetailsFolder/'.$LimitedLiabilityCompany_File);
        }
        else{ $LimitedLiabilityCompany_File =  $_POST['LimitedLiabilityCompany_Files'];}
        
        $file5 = $_FILES['LimitedPartnership_File']['name'];
        if(!empty($file5))
        {
            $filename = pathinfo($file5, PATHINFO_FILENAME);
            $extension = end(explode(".", $_FILES['LimitedPartnership_File']['name']));
            $rand = rand(10,1000000);
            $file_attch =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
            $LimitedPartnership_File = $rand." - ".$filename.".".$extension;
            move_uploaded_file($_FILES['LimitedPartnership_File']['tmp_name'],'../companyDetailsFolder/'.$LimitedPartnership_File);
        }
        else{ $LimitedPartnership_File =  $_POST['LimitedPartnership_Files'];}
        
        $file6 = $_FILES['LimitedLiabilityPartnership_File']['name'];
        if(!empty($file6))
        {
            $filename = pathinfo($file6, PATHINFO_FILENAME);
            $extension = end(explode(".", $_FILES['LimitedLiabilityPartnership_File']['name']));
            $rand = rand(10,1000000);
            $file_attch =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
            $LimitedLiabilityPartnership_File = $rand." - ".$filename.".".$extension;
            move_uploaded_file($_FILES['LimitedLiabilityPartnership_File']['tmp_name'],'../companyDetailsFolder/'.$LimitedLiabilityPartnership_File);
        }
        else{ $LimitedLiabilityPartnership_File =  $_POST['LimitedLiabilityPartnership_Files'];}
        
        $file7 = $_FILES['otherbStructurefile']['name'];
        if(!empty($file7))
        {
            $filename = pathinfo($file7, PATHINFO_FILENAME);
            $extension = end(explode(".", $_FILES['otherbStructurefile']['name']));
            $rand = rand(10,1000000);
            $file_attch =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
            $otherbStructurefile = $rand." - ".$filename.".".$extension;
            move_uploaded_file($_FILES['otherbStructurefile']['tmp_name'],'../companyDetailsFolder/'.$otherbStructurefile);
        }
        else{ $otherbStructurefile =  $_POST['otherbStructurefiles'];}
        
        $sql = "UPDATE tblEnterpiseDetails SET SolePropreitorship ='$SolePropreitorship',GeneralPartnership='$GeneralPartnership',Corporation='$Corporation',LimitedLiabilityCompany='$LimitedLiabilityCompany',LimitedPartnership='$LimitedPartnership',LimitedLiabilityPartnership='$LimitedLiabilityPartnership',othersBusinessStructure='$othersBusinessStructure',BusinessStructureSpecify='$BusinessStructureSpecify',SolePropreitorship_File='$SolePropreitorship_File',GeneralPartnership_File='$GeneralPartnership_File',Corporation_File='$Corporation_File',LimitedLiabilityCompany_File='$LimitedLiabilityCompany_File',LimitedPartnership_File='$LimitedPartnership_File',LimitedLiabilityPartnership_File='$LimitedLiabilityPartnership_File',otherbStructurefile='$otherbStructurefile' WHERE users_entities=$user_id";
        if (mysqli_query($conn, $sql)) {
        $query = mysqli_query($conn, "select * from tblEnterpiseDetails WHERE users_entities=$user_id limit 1");
        foreach($query as $row){
        ?>
            <tr>
                <td> 
                    <label> 
                    <input type="checkbox"  name="SolePropreitorship" value="Sole Propreitorship" <?php if($row['SolePropreitorship']=='Sole Propreitorship'){echo 'checked';}else{echo '';} ?>>
                    Sole Proprietorship</label>
                </td>
                <td>
                    <?php if(!empty($row['SolePropreitorship'])): ?>
                    <a href="enterprise-details-download.php?pathSole=<?php echo $row['enterp_id']; ?>"><?php echo $row['SolePropreitorship_File']; ?></a>
                    <?php endif; ?>
                </td>
                <td>
                    <input type="hidden" name="SolePropreitorship_Files" class="form-control" value="<?php echo $row['SolePropreitorship_File']; ?>">
                    <input type="file" name="SolePropreitorship_File" class="form-control" >
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                    <input type="checkbox"  name="GeneralPartnership" value="General Partnership" <?php if($row['GeneralPartnership']=='General Partnership'){echo 'checked';}else{echo '';} ?>>
                     General Partnership</label>
                </td>
                <td>
                    <?php if(!empty($row['GeneralPartnership'])): ?>
                    <a href="enterprise-details-download.php?pathGP=<?php echo $row['enterp_id']; ?>"><?php echo $row['GeneralPartnership_File']; ?></a>
                    <?php endif; ?></td>
                <td>
                    <input type="hidden" name="GeneralPartnership_Files" class="form-control" value="<?php echo $row['GeneralPartnership_File']; ?>">
                    <input type="file" name="GeneralPartnership_File" class="form-control" >
                </td>
            </tr>
            <tr>
                <td>
                 <label>
                  <input type="checkbox" name="Corporation" value="Corporation" <?php if($row['Corporation']=='Corporation'){echo 'checked';}else{echo '';} ?>>
                     Corporation</label>
                </td>
                 <td>
                     <?php if(!empty($row['Corporation'])): ?>
                     <a href="enterprise-details-download.php?pathCorp=<?php echo $row['enterp_id']; ?>"><?php echo $row['Corporation_File']; ?></a>
                    <?php endif; ?></td>
                <td>
                    <input type="hidden" name="Corporation_Files" class="form-control" value="<?php echo $row['Corporation_File']; ?>">
                    <input type="file" name="Corporation_File" class="form-control" >
                </td>
            </tr>
            <tr> 
                <td>
                    <label>
                    <input type="checkbox" name="LimitedLiabilityCompany" value="Limited Liability Company" <?php if($row['Corporation']=='Limited Liability Company'){echo 'checked';}else{echo '';} ?>>
                        Limited Liability Company</label>
                </td>
                <td>
                    <?php if(!empty($row['LimitedLiabilityCompany'])): ?>
                    <a href="enterprise-details-download.php?pathLLC=<?php echo $row['enterp_id']; ?>"><?php echo $row['LimitedLiabilityCompany_File']; ?></a>
                    <?php endif; ?></td>
                <td>
                    <input type="hidden" name="LimitedLiabilityCompany_Files" class="form-control" value="<?php echo $row['LimitedLiabilityCompany_File']; ?>">
                    <input type="file" name="LimitedLiabilityCompany_File" class="form-control" >
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                    <input type="checkbox" name="LimitedPartnership" value="Limited Partnership" <?php if($row['LimitedPartnership']=='Limited Partnership'){echo 'checked';}else{echo '';} ?>>
                        Limited Partnership</label>
                </td>
                <td>
                    <?php if(!empty($row['LimitedPartnership'])): ?>
                    <a href="enterprise-details-download.php?pathLP=<?php echo $row['enterp_id']; ?>"><?php echo $row['LimitedPartnership_File']; ?></a>
                    <?php endif; ?></td>
                <td>
                    <input type="hidden" name="LimitedPartnership_Files" class="form-control" value="<?php echo $row['LimitedPartnership_File']; ?>">
                    <input type="file" name="LimitedPartnership_File" class="form-control" >
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                    <input type="checkbox" name="LimitedLiabilityPartnership" value="Limited Liability Partnership" <?php if($row['LimitedLiabilityPartnership']=='Limited Liability Partnership'){echo 'checked';}else{echo '';} ?>>
                        Limited Liability Partnership</label>
                </td>
                <td>
                    <?php if(!empty($row['LimitedLiabilityPartnership'])): ?>
                    <a href="enterprise-details-download.php?pathLPP=<?php echo $row['enterp_id']; ?>"><?php echo $row['LimitedLiabilityPartnership_File']; ?></a>
                    <?php endif; ?></td>
                <td>
                    <input type="hidden" name="LimitedLiabilityPartnership_Files" class="form-control" value="<?php echo $row['LimitedLiabilityPartnership_File']; ?>">
                    <input type="file" name="LimitedLiabilityPartnership_File" class="form-control" >
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                    <input type="checkbox" name="othersBusinessStructure" value="Others" <?php if($row['othersBusinessStructure']=='Others'){echo 'checked';}else{echo '';} ?>>
                         Others (Please Specify)</label>
                    <input name="BusinessStructureSpecify" class="form-control" value="<?php echo $row['BusinessStructureSpecify']; ?>" onchange="BusinessStructureSpecify(this.value,'<?php echo $row['enterp_id']; ?>')">
                </td>
                <td>
                    <?php if(!empty($row['othersBusinessStructure'])): ?>
                    <a href="enterprise-details-download.php?pathOBS=<?php echo $row['enterp_id']; ?>"><?php echo $row['otherbStructurefile']; ?></a>
                    <?php endif; ?>
                </td>
                <td>
                    <input type="hidden" name="otherbStructurefiles" class="form-control" value="<?php echo $row['otherbStructurefile']; ?>">
                    <input type="file" name="otherbStructurefile" class="form-control" >
                </td>
            </tr>
        <?php } }
    }

    // btnRegistration
    if( isset($_POST['btnRegistration']) ) {
      
        $cookie = $_COOKIE['ID'];
       
        $registration_name = mysqli_real_escape_string($conn,$_POST["registration_name"]);
        $registration_date = mysqli_real_escape_string($conn,$_POST["registration_date"]);
        $expiry_date = mysqli_real_escape_string($conn,$_POST["expiry_date"]);
        
        $file = $_FILES['supporting_file']['name'];
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['supporting_file']['name']));
        $rand = rand(10,1000000);
        $supporting_file =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['supporting_file']['tmp_name'],'../companyDetailsFolder/'.$to_File_Documents);
        
        $sql = "INSERT INTO tblFacilityDetails_registration(registration_name,supporting_file,registration_date,expiry_date,addedby,ownedby,table_entities) 
        VALUES('$registration_name','$supporting_file','$registration_date','$expiry_date','$cookie','$user_id',1)";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
             $query = mysqli_query($conn, "select * from tblFacilityDetails_registration where reg_id = $last_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row_plan){?>
                <tr id="row_registration<?=$row_plan['reg_id']; ?>">
                    <td><?=$row_plan['registration_name']; ?></td>
                    <td><a href="companyDetailsFolder/<?= $row_plan['supporting_file']; ?>" target="_blank"><?= $row_plan['supporting_file']; ?></a></td>
                    <td><?= date('Y-m-d', strtotime($row_plan['registration_date'])); ?></td>
                    <td><?= date('Y-m-d', strtotime($row_plan['expiry_date'])); ?></td>
                    <td width="150px">
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_registration" data-toggle="modal" type="button" id="update_registration" data-id="<?=$row_plan['reg_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_registration" data-toggle="modal" type="button" id="delete_registration" data-id="<?=$row_plan['reg_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } 
            }
         }
    }


    //update Registration
    if( isset($_GET['get_registration_id']) ) {
    	$ID = $_GET['get_registration_id'];

    	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
    	    ';
    	        $query = "SELECT * FROM tblFacilityDetails_registration where reg_id = $ID";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result))
                { ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Registration</label>
                            <input class="form-control" type="" name="registration_name" value="<?= $row['registration_name']; ?>">
                        </div>
                    </div>
                   <br>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Supporting Files</label>
                            <input class="form-control" type="file" name="supporting_file" >
                            <input class="form-control" type="hidden" name="supporting_file2" value="<?= $row['supporting_file']; ?>">
                        </div>
                    </div>
                    <br>
                     <div class="form-group">
                        <div class="col-md-6">
                            <label>Registration Date</label>
                            <input class="form-control" type="date"  name="registration_date" value="<?= date('Y-m-d', strtotime($row['registration_date'])); ?>">
                        </div>
                        <div class="col-md-6">
                            <label>Expiration Date</label>
                            <input class="form-control" type="date"  name="expiry_date" value="<?= date('Y-m-d', strtotime($row['expiry_date'])); ?>">
                        </div>
                    </div>
        <?php } 
    }
    if( isset($_POST['btnSave_registration']) ) {
      
        $cookie = $_COOKIE['ID'];
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $registration_name = mysqli_real_escape_string($conn,$_POST['registration_name']);
        $registration_date = mysqli_real_escape_string($conn,$_POST['registration_date']);
        $expiry_date = mysqli_real_escape_string($conn,$_POST['expiry_date']);
        
        $file = $_FILES['supporting_file']['name'];
        if(!empty($file)){
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $extension = end(explode(".", $_FILES['supporting_file']['name']));
            $rand = rand(10,1000000);
            $supporting_file =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
            $to_File_Documents = $rand." - ".$filename.".".$extension;
            move_uploaded_file($_FILES['supporting_file']['tmp_name'],'../companyDetailsFolder/'.$to_File_Documents);
        }
        else{
            $supporting_file  = mysqli_real_escape_string($conn,$_POST['supporting_file2']);
        }
       
    	$sql = "UPDATE tblFacilityDetails_registration set registration_name='$registration_name',registration_date='$registration_date',expiry_date='$expiry_date',supporting_file='$supporting_file',addedby='$cookie' where reg_id = $IDs";
        if(mysqli_query($conn, $sql)){
            $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
            $queryr = "SELECT * FROM tblFacilityDetails_registration where reg_id = $IDs";
            $resultr = mysqli_query($conn, $queryr);
            while($row_plan = mysqli_fetch_array($resultr))
                 { ?>
                    <td><?=$row_plan['registration_name']; ?></td>
                    <td><a href="companyDetailsFolder/<?= $row_plan['supporting_file']; ?>" target="_blank"><?= $row_plan['supporting_file']; ?></a></td>
                    <td><?= date('Y-m-d', strtotime($row_plan['registration_date'])); ?></td>
                    <td><?= date('Y-m-d', strtotime($row_plan['expiry_date'])); ?></td>
                    <td width="150px">
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_registration" data-toggle="modal" type="button" id="update_registration" data-id="<?=$row_plan['reg_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_registration" data-toggle="modal" type="button" id="delete_registration" data-id="<?=$row_plan['reg_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
              <?php }
              
              
        }
    }

    //delete Registration
    if( isset($_GET['delete_registration_id']) ) {
    	$ID = $_GET['delete_registration_id'];

    	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
    	    ';
    	        $query = "SELECT * FROM tblFacilityDetails_registration where reg_id = $ID";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result))
                { ?>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"><b>Regulatory: </b></label>
                            <i><?= $row['registration_name']; ?></i>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"><b>Supporting File: </b></label>
                            <i><?= $row['supporting_file']; ?></i>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"><b>Registration Date: </b></label>
                            <i><?= $row['registration_date']; ?></i>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"><b>Expiry Date: </b></label>
                            <i><?= $row['expiry_date']; ?></i>
                        </div>
                    </div>
        <?php } 
    }
    if( isset($_POST['btndelete_registration']) ) {
      $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    	$sql = "DELETE FROM tblFacilityDetails_registration  where reg_id = $IDs";
        if(mysqli_query($conn, $sql)){
              echo $IDs;
              
        }
    }


    // Accreditation
    if( isset($_POST['btnAccreditation']) ) {
      
        $cookie = $_COOKIE['ID'];
       
        $registration_name = mysqli_real_escape_string($conn,$_POST["registration_name"]);
        $registration_date = mysqli_real_escape_string($conn,$_POST["registration_date"]);
        $expiry_date = mysqli_real_escape_string($conn,$_POST["expiry_date"]);
        
        $file = $_FILES['supporting_file']['name'];
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['supporting_file']['name']));
        $rand = rand(10,1000000);
        $supporting_file =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['supporting_file']['tmp_name'],'../companyDetailsFolder/'.$to_File_Documents);
        
        $sql = "INSERT INTO tblFacilityDetails_registration(registration_name,supporting_file,registration_date,expiry_date,addedby,ownedby,table_entities) 
        VALUES('$registration_name','$supporting_file','$registration_date','$expiry_date','$cookie','$user_id',4)";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
             $query = mysqli_query($conn, "select * from tblFacilityDetails_registration where reg_id = $last_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row_plan){?>
                <tr id="row_Accreditation<?=$row_plan['reg_id']; ?>">
                    <td><?=$row_plan['registration_name']; ?></td>
                    <td><a href="companyDetailsFolder/<?= $row_plan['supporting_file']; ?>" target="_blank"><?= $row_plan['supporting_file']; ?></a></td>
                    <td><?= date('Y-m-d', strtotime($row_plan['registration_date'])); ?></td>
                    <td><?= date('Y-m-d', strtotime($row_plan['expiry_date'])); ?></td>
                    <td width="150px">
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_Accreditation" data-toggle="modal" type="button" id="update_Accreditation" data-id="<?=$row_plan['reg_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_Accreditation" data-toggle="modal" type="button" id="delete_Accreditation" data-id="<?=$row_plan['reg_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } 
            }
         }
    }


    //update Accreditation
    if( isset($_GET['get_Accreditation_id']) ) {
    	$ID = $_GET['get_Accreditation_id'];

    	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
    	    ';
    	        $query = "SELECT * FROM tblFacilityDetails_registration where reg_id = $ID";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result))
                { ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Registration</label>
                            <input class="form-control" type="" name="registration_name" value="<?= $row['registration_name']; ?>">
                        </div>
                    </div>
                   <br>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Supporting Files</label>
                            <input class="form-control" type="file" name="supporting_file" >
                            <input class="form-control" type="hidden" name="supporting_file2" value="<?= $row['supporting_file']; ?>">
                        </div>
                    </div>
                    <br>
                     <div class="form-group">
                        <div class="col-md-6">
                            <label>Registration Date</label>
                            <input class="form-control" type="date"  name="registration_date" value="<?= date('Y-m-d', strtotime($row['registration_date'])); ?>">
                        </div>
                        <div class="col-md-6">
                            <label>Expiration Date</label>
                            <input class="form-control" type="date"  name="expiry_date" value="<?= date('Y-m-d', strtotime($row['expiry_date'])); ?>">
                        </div>
                    </div>
        <?php } 
    }
    if( isset($_POST['btnSave_Accreditation']) ) {
      
        $cookie = $_COOKIE['ID'];
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $registration_name = mysqli_real_escape_string($conn,$_POST['registration_name']);
        $registration_date = mysqli_real_escape_string($conn,$_POST['registration_date']);
        $expiry_date = mysqli_real_escape_string($conn,$_POST['expiry_date']);
        
        $file = $_FILES['supporting_file']['name'];
        if(!empty($file)){
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $extension = end(explode(".", $_FILES['supporting_file']['name']));
            $rand = rand(10,1000000);
            $supporting_file =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
            $to_File_Documents = $rand." - ".$filename.".".$extension;
            move_uploaded_file($_FILES['supporting_file']['tmp_name'],'../companyDetailsFolder/'.$to_File_Documents);
        }
        else{
            $supporting_file  = mysqli_real_escape_string($conn,$_POST['supporting_file2']);
        }
       
    	$sql = "UPDATE tblFacilityDetails_registration set registration_name='$registration_name',registration_date='$registration_date',expiry_date='$expiry_date',supporting_file='$supporting_file',addedby='$cookie' where reg_id = $IDs";
        if(mysqli_query($conn, $sql)){
            $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
            $queryr = "SELECT * FROM tblFacilityDetails_registration where reg_id = $IDs";
            $resultr = mysqli_query($conn, $queryr);
            while($row_plan = mysqli_fetch_array($resultr))
                 { ?>
                    <td><?=$row_plan['registration_name']; ?></td>
                    <td><a href="companyDetailsFolder/<?= $row_plan['supporting_file']; ?>" target="_blank"><?= $row_plan['supporting_file']; ?></a></td>
                    <td><?= date('Y-m-d', strtotime($row_plan['registration_date'])); ?></td>
                    <td><?= date('Y-m-d', strtotime($row_plan['expiry_date'])); ?></td>
                    <td width="150px">
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_Accreditation" data-toggle="modal" type="button" id="update_Accreditation" data-id="<?=$row_plan['reg_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_Accreditation" data-toggle="modal" type="button" id="delete_Accreditation" data-id="<?=$row_plan['reg_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
              <?php }
              
              
        }
    }

    //delete Accreditation
    if( isset($_GET['delete_Accreditation_id']) ) {
    	$ID = $_GET['delete_Accreditation_id'];

    	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
    	    ';
    	        $query = "SELECT * FROM tblFacilityDetails_registration where reg_id = $ID";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result))
                { ?>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"><b>Accreditation: </b></label>
                            <i><?= $row['registration_name']; ?></i>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"><b>Supporting File: </b></label>
                            <i><?= $row['supporting_file']; ?></i>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"><b>Registration Date: </b></label>
                            <i><?= $row['registration_date']; ?></i>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"><b>Expiry Date: </b></label>
                            <i><?= $row['expiry_date']; ?></i>
                        </div>
                    </div>
        <?php } 
    }
    if( isset($_POST['btndelete_Accreditation']) ) {
      $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    	$sql = "DELETE FROM tblFacilityDetails_registration  where reg_id = $IDs";
        if(mysqli_query($conn, $sql)){
              echo $IDs;
              
        }
    }



    // Certification
    if( isset($_POST['btnCertification']) ) {
      
        $cookie = $_COOKIE['ID'];
       
        $registration_name = mysqli_real_escape_string($conn,$_POST["registration_name"]);
        $registration_date = mysqli_real_escape_string($conn,$_POST["registration_date"]);
        $expiry_date = mysqli_real_escape_string($conn,$_POST["expiry_date"]);
        
        $file = $_FILES['supporting_file']['name'];
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['supporting_file']['name']));
        $rand = rand(10,1000000);
        $supporting_file =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['supporting_file']['tmp_name'],'../companyDetailsFolder/'.$to_File_Documents);
        
        $sql = "INSERT INTO tblFacilityDetails_registration(registration_name,supporting_file,registration_date,expiry_date,addedby,ownedby,table_entities) 
        VALUES('$registration_name','$supporting_file','$registration_date','$expiry_date','$cookie','$user_id',3)";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
             $query = mysqli_query($conn, "select * from tblFacilityDetails_registration where reg_id = $last_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row_plan){?>
                <tr id="row_Certification<?=$row_plan['reg_id']; ?>">
                    <td><?=$row_plan['registration_name']; ?></td>
                    <td><a href="companyDetailsFolder/<?= $row_plan['supporting_file']; ?>" target="_blank"><?= $row_plan['supporting_file']; ?></a></td>
                    <td><?= date('Y-m-d', strtotime($row_plan['registration_date'])); ?></td>
                    <td><?= date('Y-m-d', strtotime($row_plan['expiry_date'])); ?></td>
                    <td width="150px">
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_Certification" data-toggle="modal" type="button" id="update_Certification" data-id="<?=$row_plan['reg_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_Certification" data-toggle="modal" type="button" id="delete_Certification" data-id="<?=$row_plan['reg_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } 
            }
         }
    }


    //update Certification
    if( isset($_GET['get_Certification_id']) ) {
    	$ID = $_GET['get_Certification_id'];

    	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
    	    ';
    	        $query = "SELECT * FROM tblFacilityDetails_registration where reg_id = $ID";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result))
                { ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Certification</label>
                            <input class="form-control" type="" name="registration_name" value="<?= $row['registration_name']; ?>">
                        </div>
                    </div>
                   <br>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Supporting Files</label>
                            <input class="form-control" type="file" name="supporting_file" >
                            <input class="form-control" type="hidden" name="supporting_file2" value="<?= $row['supporting_file']; ?>">
                        </div>
                    </div>
                    <br>
                     <div class="form-group">
                        <div class="col-md-6">
                            <label>Registration Date</label>
                            <input class="form-control" type="date"  name="registration_date" value="<?= date('Y-m-d', strtotime($row['registration_date'])); ?>">
                        </div>
                        <div class="col-md-6">
                            <label>Expiration Date</label>
                            <input class="form-control" type="date"  name="expiry_date" value="<?= date('Y-m-d', strtotime($row['expiry_date'])); ?>">
                        </div>
                    </div>
        <?php } 
    }
    if( isset($_POST['btnSave_Certification']) ) {
      
        $cookie = $_COOKIE['ID'];
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $registration_name = mysqli_real_escape_string($conn,$_POST['registration_name']);
        $registration_date = mysqli_real_escape_string($conn,$_POST['registration_date']);
        $expiry_date = mysqli_real_escape_string($conn,$_POST['expiry_date']);
        
        $file = $_FILES['supporting_file']['name'];
        if(!empty($file)){
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $extension = end(explode(".", $_FILES['supporting_file']['name']));
            $rand = rand(10,1000000);
            $supporting_file =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
            $to_File_Documents = $rand." - ".$filename.".".$extension;
            move_uploaded_file($_FILES['supporting_file']['tmp_name'],'../companyDetailsFolder/'.$to_File_Documents);
        }
        else{
            $supporting_file  = mysqli_real_escape_string($conn,$_POST['supporting_file2']);
        }
       
    	$sql = "UPDATE tblFacilityDetails_registration set registration_name='$registration_name',registration_date='$registration_date',expiry_date='$expiry_date',supporting_file='$supporting_file',addedby='$cookie' where reg_id = $IDs";
        if(mysqli_query($conn, $sql)){
            $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
            $queryr = "SELECT * FROM tblFacilityDetails_registration where reg_id = $IDs";
            $resultr = mysqli_query($conn, $queryr);
            while($row_plan = mysqli_fetch_array($resultr))
                 { ?>
                    <td><?=$row_plan['registration_name']; ?></td>
                    <td><a href="companyDetailsFolder/<?= $row_plan['supporting_file']; ?>" target="_blank"><?= $row_plan['supporting_file']; ?></a></td>
                    <td><?= date('Y-m-d', strtotime($row_plan['registration_date'])); ?></td>
                    <td><?= date('Y-m-d', strtotime($row_plan['expiry_date'])); ?></td>
                    <td width="150px">
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_Certification" data-toggle="modal" type="button" id="update_Certification" data-id="<?=$row_plan['reg_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_Certification" data-toggle="modal" type="button" id="delete_Certification" data-id="<?=$row_plan['reg_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
              <?php }
              
              
        }
    }

    //delete Certification
    if( isset($_GET['delete_Certification_id']) ) {
    	$ID = $_GET['delete_Certification_id'];

    	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
    	    ';
    	        $query = "SELECT * FROM tblFacilityDetails_registration where reg_id = $ID";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result))
                { ?>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"><b>Certification: </b></label>
                            <i><?= $row['registration_name']; ?></i>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"><b>Supporting File: </b></label>
                            <i><?= $row['supporting_file']; ?></i>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"><b>Registration Date: </b></label>
                            <i><?= $row['registration_date']; ?></i>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"><b>Expiry Date: </b></label>
                            <i><?= $row['expiry_date']; ?></i>
                        </div>
                    </div>
        <?php } 
    }
    if( isset($_POST['btndelete_Certification']) ) {
      $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    	$sql = "DELETE FROM tblFacilityDetails_registration  where reg_id = $IDs";
        if(mysqli_query($conn, $sql)){
              echo $IDs;
              
        }
    }

    //contact header
    if( isset($_GET['btnUpdate_EnterpriseContact']) ) {
        $content = '';
        // $content = explode(",", $content);
        // $content = implode(" | ",$content);
        // $content = json_decode($content,true);
        if (!empty($_POST['data'])) {
            $content = json_encode($_POST['data']); 
        }

        $selectData = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails_Header WHERE user_id = $user_id" );
        if ( mysqli_num_rows($selectData) > 0 ) {
            $rowData = mysqli_fetch_array($selectData);

            mysqli_query( $conn,"UPDATE tblEnterpiseDetails_Header set portal_user = $portal_user, content='". $content ."' WHERE user_id = $user_id" );
            
            $selectHeader = mysqli_query($conn, "SELECT * FROM tblEnterpiseDetails_Header WHERE user_id = $user_id");
            if(mysqli_num_rows($selectHeader) > 0) {
                $rowHeader = mysqli_fetch_assoc($selectHeader);
                $contactHeader = $rowHeader['content'];
                $output = '';
                
                if(!empty($contactHeader)) {
                    $data = json_decode($contactHeader, true);
                    $sections = array_column($data, "section"); 
                    $unique_sections = array_unique($sections);
                    // $unique_sections = count(array_unique(array_column($data, 'section')));
            
                    $output = '<div style="display: flex">';
                    
                        for ($x = 0; $x < count($unique_sections); $x++) {
                            $output .= '<div style="margin-right: 15px;">';
                                if($unique_sections[$x] == 1) { $output .= 'Contact Person'; }
                                else if($unique_sections[$x] == 2) { $output .= 'Emergency'; }
                                else if($unique_sections[$x] == 3) { $output .= 'Private Patrol Officer'; }
                                
                                $output .= '<ul class="list-inline">';
                                
                                    foreach ($data as $key => $value) {
                                        if ($unique_sections[$x] == $value['section']) {
                                            $output .= '<li class="list-inline-item">'.$value['value'].'</li>';
                                        }
                                    }
                            
                                $output .= '</ul>
                            </div>';
                        }
                        
                    $output .= '</div>';
                }
            }
        } else {
            $sql = "INSERT INTO tblEnterpiseDetails_Header (user_id, portal_user, content)
            VALUES ('$user_id', '$portal_user', '$content')";
            mysqli_query($conn, $sql);
            
            $last_id = mysqli_insert_id($conn);
            $selectHeader = mysqli_query($conn, "SELECT * FROM tblEnterpiseDetails_Header WHERE ID = $last_id");
            if(mysqli_num_rows($selectHeader) > 0) {
                $rowHeader = mysqli_fetch_assoc($selectHeader);
                $contactHeader = $rowHeader['content'];
                $output = '';
                
                if(!empty($contactHeader)) {
                    $data = json_decode($contactHeader, true);
                    $sections = array_column($data, "section"); 
                    $unique_sections = array_unique($sections);
                    // $unique_sections = count(array_unique(array_column($data, 'section')));
                    
                    $output = '<div style="display: flex">';
                    
                        for ($x = 0; $x < count($unique_sections); $x++) {
                            $output .= '<div style="margin-right: 15px;">';
                                if($unique_sections[$x] == 1) { $output .= 'Contact Person'; }
                                else if($unique_sections[$x] == 2) { $output .= 'Emergency'; }
                                else if($unique_sections[$x] == 3) { $output .= 'Private Patrol Officer'; }
                                
                                $output .= '<ul class="list-inline">';
                                
                                    foreach ($data as $key => $value) {
                                        if ($unique_sections[$x] == $value['section']) {
                                            $output .= '<li class="list-inline-item">'.$value['value'].'</li>';
                                        }
                                    }
                            
                                $output .= '</ul>
                            </div>';
                        }
                        
                    $output .= '</div>';
                }
            }
        }
        
        echo $output;
    }


    //dynamic contact section
    if( isset($_GET['btnDelete_ContactSet']) ) {
        $id = $_GET['btnDelete_ContactSet'];
        mysqli_query( $conn,"UPDATE tblEnterpiseDetails_Contact_Set set deleted = 1 WHERE ID = $id" );
    }
    if( isset($_GET['btnDelete_ContactSetData']) ) {
        $id = $_GET['btnDelete_ContactSetData'];
        mysqli_query( $conn,"UPDATE tblEnterpiseDetails_Contact_SetData set deleted = 1 WHERE ID = $id" );
    }
    if( isset($_GET['modalAddContactSet']) ) {
        $id = $_GET['modalAddContactSet'];

        echo '<input class="form-control" type="hidden" name="ID" value="'.$id.'" />
        <div class="form-group">
            <label>First Name</label>
            <input class="form-control" type="text" name="first_name" required />
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input class="form-control" type="text" name="last_name" required />
        </div>
        <div class="form-group">
            <label>Title</label>
            <input class="form-control" type="text" name="title" required />
        </div>
        <div class="form-group">
            <label>Cell No.</label>
            <input class="form-control" type="text" name="cell" />
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input class="form-control" type="text" name="phone" required />
        </div>
        <div class="form-group">
            <label>Fax</label>
            <input class="form-control" type="text" name="fax" />
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input class="form-control" type="email" name="email" required/>
        </div>
        <div class="form-group">
            <label>Department/Organization</label>
            <input class="form-control" type="text" name="organization" />
        </div>';
    }
    if( isset($_GET['modalViewContactSetData']) ) {
        $id = $_GET['modalViewContactSetData'];

        $selectData = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails_Contact_SetData WHERE ID = $id" );
        if ( mysqli_num_rows($selectData) > 0 ) {
            $rowData = mysqli_fetch_array($selectData);

            echo '<input class="form-control" type="hidden" name="ID" value="'.$id.'" />
            <input class="form-control" type="hidden" name="set_id" value="'.$rowData['set_id'].'" />
            <div class="form-group">
                <label>First Name</label>
                <input class="form-control" type="text" name="first_name" value="'.$rowData['first_name'].'" required />
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input class="form-control" type="text" name="last_name" value="'.$rowData['last_name'].'" required />
            </div>
            <div class="form-group">
                <label>Title</label>
                <input class="form-control" type="text" name="title" value="'.$rowData['title'].'" required />
            </div>
            <div class="form-group">
                <label>Cell No.</label>
                <input class="form-control" type="text" name="cell" value="'.$rowData['cell'].'" />
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input class="form-control" type="text" name="phone" value="'.$rowData['phone'].'" required />
            </div>
            <div class="form-group">
                <label>Fax</label>
                <input class="form-control" type="text" name="fax" value="'.$rowData['fax'].'" />
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input class="form-control" type="email" name="email" value="'.$rowData['email'].'" required/>
            </div>
            <div class="form-group">
                <label>Department/Organization</label>
                <input class="form-control" type="text" name="organization" value="'.$rowData['organization'].'" required/>
            </div>';
        }
    }
    if( isset($_POST['btnSave_ContactSet']) ) {
        $title = addslashes($_POST['title']);

        $sql = "INSERT INTO tblEnterpiseDetails_Contact_Set (user_id, portal_user, title)
        VALUES ('$user_id', '$portal_user', '$title')";
        if (mysqli_query($conn, $sql)) {
            $last_id = mysqli_insert_id($conn);

            $data = '<div id="contactSet_'.$last_id.'">
                <h4>
                    <strong>'.$title.'</strong>&nbsp;
                    <a data-toggle="modal" href="#modalAddContactSet" class="btn btn-xs btn-primary" onclick="btnSaveContactSet('.$last_id.')"><i class="fa fa-plus"></i> ADD</a>&nbsp;
                    <a type="button" class="btn btn-xs btn-danger" onclick="btnRemoveContactSet('.$last_id.', this)"><i class="fa fa-times"></i> REMOVE</a>
                </h4>
                <div class="row">
                    <table class="table">
                        <thead style="border-bottom:solid #003865 2px;">
                            <tr>';
                                    if ($_COOKIE['client'] == 1) {
                                        $data .= '<td></td>';
                                    }

                                $data .= '<td>First Name</td>
                                <td>Last Name</td>
                                <td>Title</td>
                                <td>Cell No.</td>
                                <td>Phone</td>
                                <td>Fax</td>
                                <td>Email Address</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>';

            $output = array(
                "data" => $data
            );
            echo json_encode($output);
        }
    }
    if( isset($_POST['btnSave_AddContactSet']) ) {
        $ID = $_POST['ID'];
        $first_name = addslashes($_POST['first_name']);
        $last_name = addslashes($_POST['last_name']);
        $title = addslashes($_POST['title']);
        $cell = addslashes($_POST['cell']);
        $phone = addslashes($_POST['phone']);
        $fax = addslashes($_POST['fax']);
        $email = addslashes($_POST['email']);
        $organization = addslashes($_POST['organization']);
        $contactPin = '';

        $sql = "INSERT INTO tblEnterpiseDetails_Contact_SetData (user_id, portal_user, set_id, first_name, last_name, title, cell, phone, fax, email, organization)
        VALUES ('$user_id', '$portal_user', '$ID', '$first_name', '$last_name', '$title', '$cell', '$phone', '$fax', '$email', '$organization')";
        if (mysqli_query($conn, $sql)) {
            $last_id = mysqli_insert_id($conn);

            if (!empty($phone)) { $contactPin = $phone; }
            if (!empty($cell)) { $contactPin = $cell; }

            $data = '<tr id="tr_'.$ID.'_'.$last_id.'">';

                if ($_COOKIE['client'] == 1) {
                    $data .= '<td>
                        <input type="checkbox" name="contactPin" value="'.$contactPin.'" onchange="changeCheck(this)" data-id="'.$last_id.'" data-section="4" />
                    </td>';
                }

                $data .= '<td>'.$first_name.'</td>
                <td>'.$last_name.'</td>
                <td>'.$title.'</td>
                <td>'.$cell.'</td>
                <td>'.$phone.'</td>
                <td>'.$fax.'</td>
                <td>'.$email.'</td>
                <td>'.$organization.'</td>
                <td style="text-align: right;">
                    <a class="btn blue btn-outline" data-toggle="modal" href="#modalViewContactSetData" data-id="'.$last_id.'" onClick="btnView_ContactSetData('.$last_id.')">VIEW</a>
                    <a class="btn btn-outline red" onclick="btnDelete_ContactSetData('.$last_id.', this)">Delete</a>
                </td>
            </tr>';

            $output = array(
                "ID" => $ID,
                "data" => $data
            );
            echo json_encode($output);
        }
    }
    if( isset($_POST['btnSave_UpdateContactSet']) ) {
        $ID = $_POST['ID'];
        $set_id = $_POST['set_id'];
        $first_name = addslashes($_POST['first_name']);
        $last_name = addslashes($_POST['last_name']);
        $title = addslashes($_POST['title']);
        $cell = addslashes($_POST['cell']);
        $phone = addslashes($_POST['phone']);
        $fax = addslashes($_POST['fax']);
        $email = addslashes($_POST['email']);
        $organization = addslashes($_POST['organization']);
        $contactPin = '';

        mysqli_query( $conn,"UPDATE tblEnterpiseDetails_Contact_SetData set first_name='". $first_name ."', last_name='". $last_name ."', title='". $title ."', cell='". $cell ."', phone='". $phone ."', fax='". $fax ."', email='". $email ."', organization='". $organization ."' WHERE ID='". $ID ."'" );
        if (!mysqli_error($conn)) {

            if (!empty($phone)) { $contactPin = $phone; }
            if (!empty($cell)) { $contactPin = $cell; }

            $data = '';
            if ($_COOKIE['client'] == 1) {
                $data .= '<td>
                    <input type="checkbox" name="contactPin" value="'.$contactPin.'" onchange="changeCheck(this)" data-id="'.$ID.'" data-section="4" />
                </td>';
            }

            $data .= '<td>'.$first_name.'</td>
            <td>'.$last_name.'</td>
            <td>'.$title.'</td>
            <td>'.$cell.'</td>
            <td>'.$phone.'</td>
            <td>'.$fax.'</td>
            <td>'.$email.'</td>
            <td>'.$organization.'</td>
            <td style="text-align: right;">
                <a class="btn blue btn-outline" data-toggle="modal" href="#modalViewContactSetData" data-id="'.$ID.'" onClick="btnView_ContactSetData('.$ID.')">VIEW</a>
                <a class="btn btn-outline red" onclick="btnDelete_ContactSetData('.$ID.', this)">Delete</a>
            </td>';

            $output = array(
                "ID" => $ID,
                "set_id" => $set_id,
                "data" => $data
            );
            echo json_encode($output);
        }
    }
    
    
	if( isset($_GET['btnDelete_Record']) ) {
		$ID = $_GET['btnDelete_Record'];

		mysqli_query( $conn,"UPDATE tblEnterpiseDetails_Records set deleted = 1 WHERE rec_id = $ID" );
	}
?>