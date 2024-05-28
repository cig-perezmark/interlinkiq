<?php 
include "../database.php";

// user identifier
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
// Community Relations
if( isset($_POST['btnCst']) ) {
  
    $cookie = $_COOKIE['ID'];
    $facility_id = $_POST['facility_id'];
   
    $cst_title = mysqli_real_escape_string($conn,$_POST["cst_title"]);
    $expiry_date = mysqli_real_escape_string($conn,$_POST["expiry_date"]);
    
    
    $file = $_FILES['cst_files']['name'];
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $extension = end(explode(".", $_FILES['cst_files']['name']));
    $rand = rand(10,1000000);
    $cst_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
    $to_File_Documents = $rand." - ".$filename.".".$extension;
    move_uploaded_file($_FILES['cst_files']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    
    $sql = "INSERT INTO tblFacilityDetails_community(cst_title,cst_files,expiry_date,addedby,enterprise_pk, facility_entities) 
    VALUES('$cst_title','$cst_files','$expiry_date','$cookie','$user_id','$facility_id')";
    if(mysqli_query($conn, $sql)){
        $last_id = mysqli_insert_id($conn);
         $query = mysqli_query($conn, "select * from tblFacilityDetails_community where cst_pk = $last_id");
        if(mysqli_fetch_row($query)){
        foreach($query as $row_cst){?>
            <tr id="row_cst<?=$row_cst['cst_pk']; ?>">
                <td><?=$row_cst['cst_title']; ?></td>
                <td><a href="facility_files_Folder/<?= $row_cst['cst_files']; ?>" target="_blank"><?= $row_cst['cst_files']; ?></a></td>
                <td><?= date('Y-m-d', strtotime($row_cst['expiry_date'])); ?></td>>
                <td width="150px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_cst" data-toggle="modal" type="button" id="update_cst" data-id="<?=$row_cst['cst_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_cst" data-toggle="modal" type="button" id="delete_diagram" data-id="<?=$row_cst['cst_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
            </tr>
        <?php } 
        }
     }
}
//update get_cst_id
if( isset($_GET['get_cst_id']) ) {
	$ID = $_GET['get_cst_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
        $query = "SELECT * FROM tblFacilityDetails_community where cst_pk = $ID";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
        { ?>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control" type="text" name="cst_title" value="<?= $row['cst_title']; ?>">
                </div>
            </div>
           <br>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Supporting Files</label>
                    <input class="form-control" type="file" name="cst_files">
                    <input class="form-control" type="hidden" name="cst_files2" value="<?= $row['cst_files']; ?>">
                </div>
            </div>
            <br>
             <div class="form-group">
                <div class="col-md-12">
                    <label>Expiration Date</label>
                    <input class="form-control" type="date"  name="expiry_date" value="<?= date('Y-m-d', strtotime($row['expiry_date'])); ?>">
                </div>
            </div>
    <?php } 
}
if( isset($_POST['btnSave_cst']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $cst_title = mysqli_real_escape_string($conn,$_POST['cst_title']);
    $expiry_date = mysqli_real_escape_string($conn,$_POST['expiry_date']);
    
    $file = $_FILES['cst_files']['name'];
    if(!empty($file)){
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['cst_files']['name']));
        $rand = rand(10,1000000);
        $cst_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['cst_files']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    }
    else{
        $cst_files  = mysqli_real_escape_string($conn,$_POST['cst_files2']);
    }
   
	$sql = "UPDATE tblFacilityDetails_community set cst_title ='$cst_title', cst_files ='$cst_files', expiry_date='$expiry_date', addedby='$cookie' where cst_pk = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblFacilityDetails_community where cst_pk = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row_cst = mysqli_fetch_array($resultr))
             { ?>
                <td><?=$row_cst['cst_title']; ?></td>
                <td><a href="facility_files_Folder/<?= $row_cst['cst_files']; ?>" target="_blank"><?= $row_cst['cst_files']; ?></a></td>
                <td><?= date('Y-m-d', strtotime($row_cst['expiry_date'])); ?></td>>
                <td width="150px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_cst" data-toggle="modal" type="button" id="update_cst" data-id="<?=$row_cst['cst_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_cst" data-toggle="modal" type="button" id="delete_diagram" data-id="<?=$row_cst['cst_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete diagram
if( isset($_GET['delete_cst_id']) ) {
	$ID = $_GET['delete_cst_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblFacilityDetails_community where cst_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Title: </b></label>
                        <i><?= $row['cst_title']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Supporting File: </b></label>
                        <i><?= $row['cst_files']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Expiry Date: </b></label>
                        <i><?= $row['expiry_date']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_cst']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "DELETE FROM tblFacilityDetails_community  where cst_pk = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}




// btnAdd_specific_coverage
if( isset($_POST['btnDiagram']) ) {
  
    $cookie = $_COOKIE['ID'];
    $facility_id = $_POST['facility_id'];
   
    $diagram_title = mysqli_real_escape_string($conn,$_POST["diagram_title"]);
    $expiry_date = mysqli_real_escape_string($conn,$_POST["expiry_date"]);
    
    
    $file = $_FILES['diagram_files']['name'];
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $extension = end(explode(".", $_FILES['diagram_files']['name']));
    $rand = rand(10,1000000);
    $diagram_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
    $to_File_Documents = $rand." - ".$filename.".".$extension;
    move_uploaded_file($_FILES['diagram_files']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    
    $sql = "INSERT INTO tblFacilityDetails_Diagram(diagram_title,diagram_files,expiry_date,addedby,enterprise_pk, facility_id) 
    VALUES('$diagram_title','$diagram_files','$expiry_date','$cookie','$user_id','$facility_id')";
    if(mysqli_query($conn, $sql)){
        $last_id = mysqli_insert_id($conn);
         $query = mysqli_query($conn, "select * from tblFacilityDetails_Diagram where diagram_pk = $last_id");
        if(mysqli_fetch_row($query)){
        foreach($query as $row_pm){?>
            <tr id="row_diagram<?=$row_pm['diagram_pk']; ?>">
                <td><?=$row_pm['diagram_title']; ?></td>
                <td><a href="facility_files_Folder/<?= $row_pm['diagram_files']; ?>" target="_blank"><?= $row_pm['diagram_files']; ?></a></td>
                <td><?= $row_pm['expiry_date']; ?></td>
                <td width="150px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_diagram" data-toggle="modal" type="button" id="update_diagram" data-id="<?=$row_pm['diagram_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_diagram" data-toggle="modal" type="button" id="delete_diagram" data-id="<?=$row_pm['diagram_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
            </tr>
        <?php } 
        }
     }
}
//update get_diagram_id
if( isset($_GET['get_diagram_id']) ) {
	$ID = $_GET['get_diagram_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
        $query = "SELECT * FROM tblFacilityDetails_Diagram where diagram_pk = $ID";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
        { ?>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control" type="text" name="diagram_title" value="<?= $row['diagram_title']; ?>">
                </div>
            </div>
           <br>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Supporting Files</label>
                    <input class="form-control" type="file" name="diagram_files">
                    <input class="form-control" type="hidden" name="diagram_files2" value="<?= $row['diagram_files']; ?>">
                </div>
            </div>
            <br>
             <div class="form-group">
                <div class="col-md-12">
                    <label>Expiration Date</label>
                    <input class="form-control" type="date"  name="expiry_date" value="<?= date('Y-m-d', strtotime($row['expiry_date'])); ?>">
                </div>
            </div>
    <?php } 
}
if( isset($_POST['btnSave_diagram']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $diagram_title = mysqli_real_escape_string($conn,$_POST['diagram_title']);
    $expiry_date = mysqli_real_escape_string($conn,$_POST['expiry_date']);
    
    $file = $_FILES['diagram_files']['name'];
    if(!empty($file)){
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['diagram_files']['name']));
        $rand = rand(10,1000000);
        $diagram_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['diagram_files']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    }
    else{
        $diagram_files  = mysqli_real_escape_string($conn,$_POST['diagram_files2']);
    }
   
	$sql = "UPDATE tblFacilityDetails_Diagram set diagram_title ='$diagram_title', diagram_files ='$diagram_files', expiry_date='$expiry_date', addedby='$cookie' where diagram_pk = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblFacilityDetails_Diagram where diagram_pk = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                <td><?=$row['diagram_title']; ?></td>
                <td><a href="facility_files_Folder/<?= $row['diagram_files']; ?>" target="_blank"><?= $row['diagram_files']; ?></a></td>
                <td><?= $row['expiry_date']; ?></td>
                <td width="150px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_diagram" data-toggle="modal" type="button" id="update_diagram" data-id="<?=$row['diagram_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_diagram" data-toggle="modal" type="button" id="delete_diagram" data-id="<?=$row['diagram_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete diagram
if( isset($_GET['delete_diagram_id']) ) {
	$ID = $_GET['delete_diagram_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblFacilityDetails_Diagram where diagram_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Title: </b></label>
                        <i><?= $row['diagram_title']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Supporting File: </b></label>
                        <i><?= $row['diagram_files']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Expiry Date: </b></label>
                        <i><?= $row['expiry_date']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_diagram']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "DELETE FROM tblFacilityDetails_Diagram  where diagram_pk = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}


// Security Plan
if( isset($_POST['btnPlan']) ) {
  
    $cookie = $_COOKIE['ID'];
    $facility_id = $_POST['facility_id'];
   
    $plan_title = mysqli_real_escape_string($conn,$_POST["plan_title"]);
    $expiry_date = mysqli_real_escape_string($conn,$_POST["expiry_date"]);
    
    
    $file = $_FILES['plan_files']['name'];
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $extension = end(explode(".", $_FILES['plan_files']['name']));
    $rand = rand(10,1000000);
    $plan_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
    $to_File_Documents = $rand." - ".$filename.".".$extension;
    move_uploaded_file($_FILES['plan_files']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    
    $sql = "INSERT INTO tblFacilityDetails_Plan(plan_title,plan_files,expiry_date,addedby,enterprise_pk, facility_id) 
    VALUES('$plan_title','$plan_files','$expiry_date','$cookie','$user_id','$facility_id')";
    if(mysqli_query($conn, $sql)){
        $last_id = mysqli_insert_id($conn);
         $query = mysqli_query($conn, "select * from tblFacilityDetails_Plan where plan_pk = $last_id");
        if(mysqli_fetch_row($query)){
        foreach($query as $row_plan){?>
            <tr id="row_plan<?=$row_plan['plan_pk']; ?>">
                <td><?=$row_plan['plan_title']; ?></td>
                <td><a href="facility_files_Folder/<?= $row_plan['plan_files']; ?>" target="_blank"><?= $row_plan['plan_files']; ?></a></td>
                <td><?= $row_plan['expiry_date']; ?></td>
                <td width="150px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_plan" data-toggle="modal" type="button" id="update_plan" data-id="<?= $row_plan['plan_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_plan" data-toggle="modal" type="button" id="delete_plan" data-id="<?= $row_plan['plan_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
            </tr>
        <?php } 
        }
     }
}
//update get_plan_id
if( isset($_GET['get_plan_id']) ) {
	$ID = $_GET['get_plan_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblFacilityDetails_Plan where plan_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Title</label>
                        <input class="form-control" type="text" name="plan_title" value="<?= $row['plan_title']; ?>">
                    </div>
                </div>
               <br>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Supporting Files</label>
                        <input class="form-control" type="file" name="plan_files" >
                        <input class="form-control" type="hidden" name="plan_files2" value="<?= $row['plan_files']; ?>">
                    </div>
                </div>
                <br>
                 <div class="form-group">
                    <div class="col-md-12">
                        <label>Expiration Date</label>
                        <input class="form-control" type="date"  name="expiry_date" value="<?= date('Y-m-d', strtotime($row['expiry_date'])); ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_plan']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $plan_title = mysqli_real_escape_string($conn,$_POST['plan_title']);
    $expiry_date = mysqli_real_escape_string($conn,$_POST['expiry_date']);
    
    $file = $_FILES['plan_files']['name'];
    if(!empty($file)){
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['plan_files']['name']));
        $rand = rand(10,1000000);
        $plan_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['plan_files']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    }
    else{
        $plan_files  = mysqli_real_escape_string($conn,$_POST['plan_files2']);
    }
   
	$sql = "UPDATE tblFacilityDetails_Plan set plan_title='$plan_title',plan_files='$plan_files',expiry_date='$expiry_date',addedby='$cookie' where plan_pk = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblFacilityDetails_Plan where plan_pk = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                <td><?=$row['plan_title']; ?></td>
                <td><a href="facility_files_Folder/<?= $row['plan_files']; ?>" target="_blank"><?= $row['plan_files']; ?></a></td>
                <td><?= $row['expiry_date']; ?></td>
                <td width="150px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_plan" data-toggle="modal" type="button" id="update_plan" data-id="<?= $row['plan_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_plan" data-toggle="modal" type="button" id="delete_plan" data-id="<?= $row['plan_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete Plan
if( isset($_GET['delete_plan_id']) ) {
	$ID = $_GET['delete_plan_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblFacilityDetails_Plan where plan_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Title: </b></label>
                        <i><?= $row['plan_title']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Supporting File: </b></label>
                        <i><?= $row['plan_files']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Expiry Date: </b></label>
                        <i><?= $row['expiry_date']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_plan']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "DELETE FROM tblFacilityDetails_Plan  where plan_pk = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}



// Insurance and Bond
if( isset($_POST['btnInsurance']) ) {
  
    $cookie = $_COOKIE['ID'];
   
    $ib_title = mysqli_real_escape_string($conn,$_POST["ib_title"]);
    $expiry_date = mysqli_real_escape_string($conn,$_POST["expiry_date"]);
    
    
    $file = $_FILES['ib_files']['name'];
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $extension = end(explode(".", $_FILES['ib_files']['name']));
    $rand = rand(10,1000000);
    $ib_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
    $to_File_Documents = $rand." - ".$filename.".".$extension;
    move_uploaded_file($_FILES['ib_files']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    
    $sql = "INSERT INTO tblFacilityDetails_Bond(ib_title,ib_files,expiry_date,addedby,enterprise_pk) 
    VALUES('$ib_title','$ib_files','$expiry_date','$cookie','$user_id')";
    if(mysqli_query($conn, $sql)){
        $last_id = mysqli_insert_id($conn);
         $query = mysqli_query($conn, "select * from tblFacilityDetails_Bond where bond_pk = $last_id");
        if(mysqli_fetch_row($query)){
        foreach($query as $row_plan){?>
            <tr id="row_bond<?=$row_plan['bond_pk']; ?>">
                <td><?=$row_plan['ib_title']; ?></td>
                <td><a href="facility_files_Folder/<?= $row_plan['ib_files']; ?>" target="_blank"><?= $row_plan['ib_files']; ?></a></td>
                <td><?= $row_plan['expiry_date']; ?></td>
                <td width="150px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_bond" data-toggle="modal" type="button" id="update_bond" data-id="<?=$row_plan['bond_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_bond" data-toggle="modal" type="button" id="delete_bond" data-id="<?=$row_plan['bond_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
            </tr>
        <?php } 
        }
     }
}
if( isset($_POST['btnInsurance1']) ) {
  
    $cookie = $_COOKIE['ID'];
    $facility_id = $_POST['facility_id'];
   
    $ib_title = mysqli_real_escape_string($conn,$_POST["ib_title"]);
    $expiry_date = mysqli_real_escape_string($conn,$_POST["expiry_date"]);
    $policy_number = mysqli_real_escape_string($conn,$_POST["policy_number"]);
    $effective_date = mysqli_real_escape_string($conn,$_POST["effective_date"]);
    $policy_type = mysqli_real_escape_string($conn,$_POST["policy_type"]);
    $in_status = mysqli_real_escape_string($conn,$_POST["in_status"]);
    
    
    $file = $_FILES['ib_files']['name'];
    if(!empty($file)){
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['ib_files']['name']));
        $rand = rand(10,1000000);
        $ib_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['ib_files']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    }
    
    $sql = "INSERT INTO tblFacilityDetails_Bond(ib_title,ib_files,policy_number,policy_type,in_status,effective_date,expiry_date,addedby,enterprise_pk,type_id, facility_id) 
    VALUES('$ib_title','$ib_files','$policy_number','$policy_type','$in_status','$effective_date','$expiry_date','$cookie','$user_id',1, '$facility_id')";
    if(mysqli_query($conn, $sql)){
        $last_id = mysqli_insert_id($conn);
         $query = mysqli_query($conn, "select * from tblFacilityDetails_Bond where bond_pk = $last_id");
        if(mysqli_fetch_row($query)){
        foreach($query as $row_plan){?>
            <tr id="row_bond<?=$row_plan['bond_pk']; ?>">
                <td><?=$row_plan['ib_title']; ?></td>
                <td><?= $row_plan['policy_number']; ?></td>
                <td><?= date('Y-m-d', strtotime($row_plan['effective_date'])); ?></td>
                <td><?= date('Y-m-d', strtotime($row_plan['expiry_date'])); ?></td>
                <td><?= $row_plan['policy_type']; ?></td>
                <td>
                    <?php 
                        if($row_plan['in_status'] == 1){ echo 'Active';}else{ echo 'Inactive'; }
                    ?>
                </td>
                <td><a href="facility_files_Folder/<?= $row_plan['ib_files']; ?>" target="_blank"><?= $row_plan['ib_files']; ?></a></td>
                <td width="150px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_bond1" data-toggle="modal" type="button" id="update_bond1" data-id="<?=$row_plan['bond_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_bond" data-toggle="modal" type="button" id="delete_bond" data-id="<?=$row_plan['bond_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
            </tr>
        <?php } 
        }
     }
}
//update get_insurance_id 1
if( isset($_GET['get_insurance_id1']) ) {
	$ID = $_GET['get_insurance_id1'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblFacilityDetails_Bond where bond_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                 <div class="form-group">
                    <div class="col-md-12">
                        <label>Insurance Company Name</label>
                        <input class="form-control" type="text" name="ib_title" value="<?= $row['ib_title']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Policy Number</label>
                        <input class="form-control" type="text" name="policy_number" value="<?= $row['policy_number']; ?>">
                    </div>
                </div>
                <div class="form-group"> 
                    <div class="col-md-12">
                        <label>Supporting Files</label>
                        <input class="form-control" type="file" name="ib_files">
                        <input class="form-control" type="hidden" name="ib_files2" value="<?= $row['ib_files']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label>Effective Date</label>
                        <input class="form-control" type="date"  name="effective_date" value="<?= date('Y-m-d', strtotime($row['effective_date'])); ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Expiration Date</label>
                        <input class="form-control" type="date"  name="expiry_date" value="<?= date('Y-m-d', strtotime($row['expiry_date'])); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label>Policy Type</label>
                        <input class="form-control" type=""  name="policy_type" value="<?= $row['policy_type']; ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Status</label>
                        <br>
                        <label>
                            <input type="radio"  name="in_status" value="1" <?php if($row['in_status']==1){ echo 'checked'; } ?>> Active
                        </label>
                        &nbsp;
                        <label>
                            <input  type="radio"  name="in_status" value="0" <?php if($row['in_status']==0){ echo 'checked'; }?>> Inactive
                        </label>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_insurance1']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $ib_title = mysqli_real_escape_string($conn,$_POST["ib_title"]);
    $expiry_date = mysqli_real_escape_string($conn,$_POST["expiry_date"]);
    $policy_number = mysqli_real_escape_string($conn,$_POST["policy_number"]);
    $effective_date = mysqli_real_escape_string($conn,$_POST["effective_date"]);
    $policy_type = mysqli_real_escape_string($conn,$_POST["policy_type"]);
    $in_status = mysqli_real_escape_string($conn,$_POST["in_status"]);
    
    $file = $_FILES['ib_files']['name'];
    if(!empty($file)){
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['ib_files']['name']));
        $rand = rand(10,1000000);
        $ib_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['ib_files']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    }
    else{
        $ib_files  = mysqli_real_escape_string($conn,$_POST['ib_files2']);
    }
   
	$sql = "UPDATE tblFacilityDetails_Bond set ib_title='$ib_title',policy_number='$policy_number',in_status='$in_status',policy_type='$policy_type',ib_files='$ib_files',effective_date='$effective_date',expiry_date='$expiry_date',addedby='$cookie' where bond_pk = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblFacilityDetails_Bond where bond_pk = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                <td><?=  $row['ib_title']; ?></td>
                <td><?= $row['policy_number']; ?></td>
                <td><?= date('Y-m-d', strtotime($row['effective_date'])); ?></td>
                <td><?= date('Y-m-d', strtotime($row['expiry_date'])); ?></td>
                <td><?= $row['policy_type']; ?></td>
                <td>
                    <?php 
                        if($row['in_status'] == 1){ echo 'Active';}else{ echo 'Inactive'; }
                    ?>
                </td>
                <td><a href="facility_files_Folder/<?= $row['ib_files']; ?>" target="_blank"><?= $row['ib_files']; ?></a></td>
                <td width="150px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_bond1" data-toggle="modal" type="button" id="update_bond1" data-id="<?=$row['bond_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_bond" data-toggle="modal" type="button" id="delete_bond" data-id="<?=$row['bond_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}


if( isset($_POST['btnInsurance2']) ) {
  
    $cookie = $_COOKIE['ID'];
    $facility_id = $_POST['facility_id'];
   
    $ib_title = mysqli_real_escape_string($conn,$_POST["ib_title"]);
    $expiry_date = mysqli_real_escape_string($conn,$_POST["expiry_date"]);
    $policy_number = mysqli_real_escape_string($conn,$_POST["policy_number"]);
    $effective_date = mysqli_real_escape_string($conn,$_POST["effective_date"]);
    $policy_type = mysqli_real_escape_string($conn,$_POST["policy_type"]);
    
    
    $file = $_FILES['ib_files']['name'];
    if(!empty($file)){
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['ib_files']['name']));
        $rand = rand(10,1000000);
        $ib_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['ib_files']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    }
    
    $sql = "INSERT INTO tblFacilityDetails_Bond(ib_title,ib_files,policy_number,policy_type,effective_date,expiry_date,addedby,enterprise_pk,type_id, facility_id) 
    VALUES('$ib_title','$ib_files','$policy_number','$policy_type','$effective_date','$expiry_date','$cookie','$user_id',2, '$facility_id')";
    if(mysqli_query($conn, $sql)){
        $last_id = mysqli_insert_id($conn);
         $query = mysqli_query($conn, "select * from tblFacilityDetails_Bond where bond_pk = $last_id");
        if(mysqli_fetch_row($query)){
        foreach($query as $row_plan){?>
            <tr id="row_bond<?=$row_plan['bond_pk']; ?>">
                <td><?=  $row_plan['ib_title']; ?></td>
                <td><?= $row_plan['policy_number']; ?></td>
                <td><?= date('Y-m-d', strtotime($row_plan['effective_date'])); ?></td>
                <td><?= date('Y-m-d', strtotime($row_plan['expiry_date'])); ?></td>
                <td><?= $row_plan['policy_type']; ?></td>
                <td><a href="facility_files_Folder/<?= $row_plan['ib_files']; ?>" target="_blank"><?= $row_plan['ib_files']; ?></a></td>
                <td width="150px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_bond" data-toggle="modal" type="button" id="update_bond" data-id="<?=$row_plan['bond_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_bond" data-toggle="modal" type="button" id="delete_bond" data-id="<?=$row_plan['bond_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
            </tr>
        <?php } 
        }
     }
}
//update get_insurance_id 2
if( isset($_GET['get_insurance_id2']) ) {
	$ID = $_GET['get_insurance_id2'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblFacilityDetails_Bond where bond_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                 <div class="form-group">
                    <div class="col-md-12">
                        <label>Bond Company Name</label>
                        <input class="form-control" type="text" name="ib_title" value="<?= $row['ib_title']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Bond Number</label>
                        <input class="form-control" type="text" name="policy_number" value="<?= $row['policy_number']; ?>">
                    </div>
                </div>
                <div class="form-group"> 
                    <div class="col-md-12">
                        <label>Supporting Files</label>
                        <input class="form-control" type="file" name="ib_files">
                        <input class="form-control" type="hidden" name="ib_files2" value="<?= $row['ib_files']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label>Effective Date</label>
                        <input class="form-control" type="date"  name="effective_date" value="<?= date('Y-m-d', strtotime($row['effective_date'])); ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Expiration Date</label>
                        <input class="form-control" type="date"  name="expiry_date" value="<?= date('Y-m-d', strtotime($row['expiry_date'])); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Cannabis Bond Type</label>
                        <input class="form-control" type=""  name="policy_type" value="<?= $row['policy_type']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_insurance2']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $ib_title = mysqli_real_escape_string($conn,$_POST["ib_title"]);
    $expiry_date = mysqli_real_escape_string($conn,$_POST["expiry_date"]);
    $policy_number = mysqli_real_escape_string($conn,$_POST["policy_number"]);
    $effective_date = mysqli_real_escape_string($conn,$_POST["effective_date"]);
    $policy_type = mysqli_real_escape_string($conn,$_POST["policy_type"]);
    
    $file = $_FILES['ib_files']['name'];
    if(!empty($file)){
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['ib_files']['name']));
        $rand = rand(10,1000000);
        $ib_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['ib_files']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    }
    else{
        $ib_files  = mysqli_real_escape_string($conn,$_POST['ib_files2']);
    }
   
	$sql = "UPDATE tblFacilityDetails_Bond set ib_title='$ib_title',policy_number='$policy_number',policy_type='$policy_type',ib_files='$ib_files',effective_date='$effective_date',expiry_date='$expiry_date',addedby='$cookie' where bond_pk = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblFacilityDetails_Bond where bond_pk = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row = mysqli_fetch_array($resultr))
             { ?>
                <td><?=  $row['ib_title']; ?></td>
                <td><?= $row['policy_number']; ?></td>
                <td><?= date('Y-m-d', strtotime($row['effective_date'])); ?></td>
                <td><?= date('Y-m-d', strtotime($row['expiry_date'])); ?></td>
                <td><?= $row['policy_type']; ?></td>
                <td><a href="facility_files_Folder/<?= $row['ib_files']; ?>" target="_blank"><?= $row['ib_files']; ?></a></td>
                <td width="150px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_bond" data-toggle="modal" type="button" id="update_bond" data-id="<?=$row['bond_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_bond" data-toggle="modal" type="button" id="delete_bond" data-id="<?=$row['bond_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete insurance
if( isset($_GET['delete_insurance_id']) ) {
	$ID = $_GET['delete_insurance_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblFacilityDetails_Bond where bond_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Name: </b></label>
                        <i><?= $row['ib_title']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Number: </b></label>
                        <i><?= $row['policy_number']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Effective Date: </b></label>
                        <i><?= $row['effective_date']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Expiry Date: </b></label>
                        <i><?= $row['expiry_date']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_insurance']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "UPDATE tblFacilityDetails_Bond set is_deleted= 1 where bond_pk = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

// btnRegistration
if( isset($_POST['btnRegistration']) ) {
  
    $facility_id = $_POST['facility_id'];
    $registration_name = $_POST['registration_name'];
    $registration_date = $_POST['registration_date'];
    $expiry_date = $_POST['expiry_date'];
   
    // $registration_name = mysqli_real_escape_string($conn,$_POST["registration_name"]);
    // $registration_date = mysqli_real_escape_string($conn,$_POST["registration_date"]);
    // $expiry_date = mysqli_real_escape_string($conn,$_POST["expiry_date"]);
    
	$path = '../facility_files_Folder/';
	$random = rand(1000,1000000);
    $file = $_FILES['supporting_file']['name'];
    $size = $_FILES['supporting_file']['size'];
	$tmp = $_FILES['supporting_file']['tmp_name'];
	$file_final = $random.' - '.$file;
	$final_path = $path.$file_final;
	move_uploaded_file($tmp, $final_path);
	
    // $file = $_FILES['supporting_file']['name'];
    // $filename = pathinfo($file, PATHINFO_FILENAME);
    // $extension = end(explode(".", $_FILES['supporting_file']['name']));
    // $rand = rand(10,1000000);
    // $supporting_file =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
    // $to_File_Documents = $rand." - ".$filename.".".$extension;
    // move_uploaded_file($_FILES['supporting_file']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    
    // $sql = "INSERT INTO tblFacilityDetails_registration(facility_id, registration_name, supporting_file, registration_date, expiry_date, addedby, ownedby, table_entities) 
    // VALUES('$facility_id', $registration_name', '$file_final','$registration_date','$expiry_date', '$user_id','$portal_user',2)";
    // if(mysqli_query($conn, $sql)){
        
        
	$sql = "INSERT INTO tblFacilityDetails_registration (facility_id, registration_name, supporting_file, registration_date, expiry_date, addedby, ownedby, table_entities)
	VALUES ('$facility_id', '$registration_name', '$file_final', '$registration_date', '$expiry_date', '$user_id','$portal_user', 2)";
	
	if (mysqli_query($conn, $sql)) {
        $last_id = mysqli_insert_id($conn);
        $query = mysqli_query($conn, "select * from tblFacilityDetails_registration where reg_id = $last_id");
        if(mysqli_fetch_row($query)){
            foreach($query as $row_plan){?>
                <tr id="row_registration<?=$row_plan['reg_id']; ?>">
                    <td><?=$row_plan['registration_name']; ?></td>
                    <td><a href="facility_files_Folder/<?= $row_plan['supporting_file']; ?>" target="_blank"><?= $row_plan['supporting_file']; ?></a></td>
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
        echo "enter";
    } else {
        echo "elses";
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
  
    $IDs = $_POST['ID'];
    $registration_name = $_POST['registration_name'];
    $registration_date = $_POST['registration_date'];
    $expiry_date = $_POST['expiry_date'];
    
    
    
    
    
    // $cookie = $_COOKIE['ID'];
    // $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    // $registration_name = mysqli_real_escape_string($conn,$_POST['registration_name']);
    // $registration_date = mysqli_real_escape_string($conn,$_POST['registration_date']);
    // $expiry_date = mysqli_real_escape_string($conn,$_POST['expiry_date']);
    
    $file = $_FILES['supporting_file']['name'];
    if(!empty($file)) {

        $path = '../facility_files_Folder/';
        $random = rand(1000,1000000);
        $size = $_FILES['supporting_file']['size'];
        $tmp = $_FILES['supporting_file']['tmp_name'];
        $file = $random.' - '.$file;
        $final_path = $path.$file;
        move_uploaded_file($tmp, $final_path);


        // $filename = pathinfo($file, PATHINFO_FILENAME);
        // $extension = end(explode(".", $_FILES['supporting_file']['name']));
        // $rand = rand(10,1000000);
        // $supporting_file =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        // $to_File_Documents = $rand." - ".$filename.".".$extension;
        // move_uploaded_file($_FILES['supporting_file']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    }
    else{
        $file = $_POST['supporting_file2'];
        // $supporting_file  = mysqli_real_escape_string($conn,$_POST['supporting_file2']);
    }
   
    $sql = "UPDATE tblFacilityDetails_registration set registration_name='".$registration_name."', registration_date='".$registration_date."', expiry_date='".$expiry_date."', supporting_file='".$file."', addedby='".$user_id."' where reg_id = $IDs";
    if(mysqli_query($conn, $sql)) {
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblFacilityDetails_registration where reg_id = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row_plan = mysqli_fetch_array($resultr)) { 
            echo '<td>'.$row_plan['registration_name'].'</td>
            <td><a href="facility_files_Folder/'.$row_plan['supporting_file'].'" target="_blank">'.$row_plan['supporting_file'].'</a></td>
            <td>'.date('Y-m-d', strtotime($row_plan['registration_date'])).'</td>
            <td>'.date('Y-m-d', strtotime($row_plan['expiry_date'])).'</td>
            <td width="150px">
                <div class="btn-group btn-group-circle">
                    <a  href="#modal_update_registration" data-toggle="modal" type="button" id="update_registration" data-id="'.$row_plan['reg_id'].'" class="btn btn-outline dark btn-sm">Edit</a>
                    <a href="#modal_delete_registration" data-toggle="modal" type="button" id="delete_registration" data-id="'.$row_plan['reg_id'].'" class="btn btn-danger btn-sm" onclick="">Delete</a>
                </div>
            </td>';
        }
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
                        <label class="control-label"><b>Registration: </b></label>
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

// Add Vehicles
if( isset($_POST['btnVehicles']) ) {
  
    $cookie = $_COOKIE['ID'];
    $facility_id = $_POST['facility_id'];
    
    $driver_name = mysqli_real_escape_string($conn,$_POST["driver_name"]);
    $lisence_plate = mysqli_real_escape_string($conn,$_POST["lisence_plate"]);
    $vehicle_yr = mysqli_real_escape_string($conn,$_POST["vehicle_yr"]);
    $vehicle_make = mysqli_real_escape_string($conn,$_POST["vehicle_make"]);
    $vehicle_model = mysqli_real_escape_string($conn,$_POST["vehicle_model"]);
    $vin_number = mysqli_real_escape_string($conn,$_POST["vin_number"]);
    $vehicle_color = mysqli_real_escape_string($conn,$_POST["vehicle_color"]);
    $vehicle_status = mysqli_real_escape_string($conn,$_POST["vehicle_status"]);
    
    $file = $_FILES['vehicle_files']['name'];
    if(!empty($file)){
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['vehicle_files']['name']));
        $rand = rand(10,1000000);
        $vehicle_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['vehicle_files']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    }
    
    $sql = "INSERT INTO tblFacilityDetails_vehicles(driver_name,lisence_plate,vehicle_yr,vehicle_make,vehicle_model,vin_number,vehicle_color,vehicle_status,vehicle_files,vehicle_addedby,enterprise_pk, facility_id) 
    VALUES('$driver_name','$lisence_plate','$vehicle_yr','$vehicle_make','$vehicle_model','$vin_number','$vehicle_color','$vehicle_status','$vehicle_files','$cookie','$user_id','$facility_id')";
    if(mysqli_query($conn, $sql)){
        $last_id = mysqli_insert_id($conn);
         $query = mysqli_query($conn, "select * from tblFacilityDetails_vehicles where vehicle_pk = $last_id");
        if(mysqli_fetch_row($query)){
        foreach($query as $row_v){?>
            <tr id="row_vehicle<?=$row_v['vehicle_pk']; ?>">
                <td>
                    <?php
                        $drivers_id = $row_v['driver_name']; 
                        $drivers = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$drivers_id'");
                        foreach($drivers as $name_driver){
                             echo $name_driver['first_name'].' '.$name_driver['last_name'];
                        }
                    ?>
                </td>
                <td><?=$row_v['lisence_plate']; ?></td>
                <td><?=$row_v['vehicle_yr']; ?></td>
                <td><?=$row_v['vehicle_make']; ?></td>
                <td><?=$row_v['vehicle_model']; ?></td>
                <td><?=$row_v['vin_number']; ?></td>
                <td><?=$row_v['vehicle_color']; ?></td>
                <td>
                    <?php 
                        if($row_v['vehicle_status']== 1){ echo 'Active'; }else{ echo'Inactive'; } 
                    ?>
                </td>
                <td><a href="facility_files_Folder/<?= $row_v['vehicle_files']; ?>" target="_blank"><?= $row_v['vehicle_files']; ?></a></td>
                <td width="150px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_vehicle" data-toggle="modal" type="button" id="update_vehicle" data-id="<?=$row_v['vehicle_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_vehicle" data-toggle="modal" type="button" id="delete_vehicle" data-id="<?=$row_v['vehicle_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
            </tr>
        <?php } 
        }
     }
}

//update vehicle
if( isset($_GET['get_vehicle_id']) ) {
	$ID = $_GET['get_vehicle_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblFacilityDetails_vehicles where vehicle_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Driver's Name</label>
                        <select class="form-control mt-multiselect btn btn-default" type="text" name="driver_name" required>
                            <option value="">---Select---</option>
                            <?php
                                $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = '$user_id' order by first_name ASC";
                                $resultAssignto = mysqli_query($conn, $queryAssignto);
                                while($rowAssignto = mysqli_fetch_array($resultAssignto))
                                { 
                                   echo '<option value="'.$rowAssignto['ID'].'" '; echo $row['driver_name'] == $rowAssignto['ID'] ? 'selected' : ''; echo'>'.$rowAssignto['first_name'].' '.$rowAssignto['last_name'].'</option>'; 
                                }
                               
                             ?>
                             <option value="0">Others</option> 
                        </select>
                    </div>
                </div>
               <div class="form-group">
                    <div class="col-md-12">
                        <label>License Plate Number</label>
                        <input class="form-control" type="text" name="lisence_plate" value="<?= $row['lisence_plate']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Year</label>
                        <input class="form-control" type="text" name="vehicle_yr" value="<?= $row['vehicle_yr']; ?>">
                    </div>
                </div>
               <div class="form-group">
                    <div class="col-md-12">
                        <label>Make</label>
                        <input class="form-control" type="text" name="vehicle_make" value="<?= $row['vehicle_make']; ?>">
                    </div>
                </div>
               <div class="form-group">
                    <div class="col-md-6">
                        <label>Model</label>
                        <input class="form-control" type="text" name="vehicle_model" value="<?= $row['vehicle_model']; ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Vin #.</label>
                        <input class="form-control" type="text" name="vin_number" value="<?= $row['vin_number']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label>Color</label>
                        <input class="form-control" type="text" name="vehicle_color" value="<?= $row['vehicle_color']; ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Status</label>
                        <br>
                        <label>
                            <input type="radio" name="vehicle_status" value="1" <?php if($row['vehicle_status'] == 1){echo 'checked';} ?>> Active
                        </label>
                        &nbsp;
                        <label>
                            <input type="radio" name="vehicle_status" value="0" <?php if($row['vehicle_status'] == 0){echo 'checked';} ?>> Inactive
                        </label>
                        
                    </div>
                </div>
                <div class="form-group"> 
                    <div class="col-md-12">
                        <label>Supporting Files</label>
                        <input class="form-control" type="file" name="vehicle_files">
                        <input class="form-control" type="hidden" name="vehicle_files2" value="<?= $row['vehicle_files']; ?>">
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnSave_vehicle']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $driver_name = mysqli_real_escape_string($conn,$_POST["driver_name"]);
    $lisence_plate = mysqli_real_escape_string($conn,$_POST["lisence_plate"]);
    $vehicle_yr = mysqli_real_escape_string($conn,$_POST["vehicle_yr"]);
    $vehicle_make = mysqli_real_escape_string($conn,$_POST["vehicle_make"]);
    $vehicle_model = mysqli_real_escape_string($conn,$_POST["vehicle_model"]);
    $vin_number = mysqli_real_escape_string($conn,$_POST["vin_number"]);
    $vehicle_color = mysqli_real_escape_string($conn,$_POST["vehicle_color"]);
    $vehicle_status = mysqli_real_escape_string($conn,$_POST["vehicle_status"]);
    
    $file = $_FILES['vehicle_files']['name'];
    if(!empty($file)){
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['vehicle_files']['name']));
        $rand = rand(10,1000000);
        $vehicle_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['vehicle_files']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    }
    else{
        $vehicle_files  = mysqli_real_escape_string($conn,$_POST['vehicle_files2']);
    }
   
	$sql = "UPDATE tblFacilityDetails_vehicles set driver_name='$driver_name',lisence_plate='$lisence_plate',vehicle_yr='$vehicle_yr',vehicle_make='$vehicle_make',vehicle_model='$vehicle_model',vin_number='$vin_number',vehicle_color='$vehicle_color',vehicle_status='$vehicle_status',vehicle_files='$vehicle_files',vehicle_addedby='$cookie' where vehicle_pk = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblFacilityDetails_vehicles where vehicle_pk = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row_v = mysqli_fetch_array($resultr))
             { ?>
                <td>
                    <?php
                        $drivers_id = $row_v['driver_name']; 
                        $drivers = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$drivers_id'");
                        foreach($drivers as $name_driver){
                            echo $name_driver['first_name'].' '.$name_driver['last_name'];
                        }
                    ?>
                </td>
                <td><?=$row_v['lisence_plate']; ?></td>
                <td><?=$row_v['vehicle_yr']; ?></td>
                <td><?=$row_v['vehicle_make']; ?></td>
                <td><?=$row_v['vehicle_model']; ?></td>
                <td><?=$row_v['vin_number']; ?></td>
                <td><?=$row_v['vehicle_color']; ?></td>
                <td>
                    <?php 
                        if($row_v['vehicle_status']== 1){ echo 'Active'; }else{ echo'Inactive'; } 
                    ?>
                </td>
                <td><a href="facility_files_Folder/<?= $row_v['vehicle_files']; ?>" target="_blank"><?= $row_v['vehicle_files']; ?></a></td>
                <td width="150px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_vehicle" data-toggle="modal" type="button" id="update_vehicle" data-id="<?=$row_v['vehicle_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_vehicle" data-toggle="modal" type="button" id="delete_vehicle" data-id="<?=$row_v['vehicle_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete delete_vehicle_id
if( isset($_GET['delete_vehicle_id']) ) {
	$ID = $_GET['delete_vehicle_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblFacilityDetails_vehicles where vehicle_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Year: </b></label>
                        <i><?= $row['vehicle_yr']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Make: </b></label>
                        <i><?= $row['vehicle_make']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Model: </b></label>
                        <i><?= $row['vehicle_model']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Color: </b></label>
                        <i><?= $row['vehicle_color']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_vehicle']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "UPDATE tblFacilityDetails_vehicles set is_deleted=1  where vehicle_pk = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}



// Add Deficiency
if( isset($_POST['btnDeficiency']) ) {
  
    $cookie = $_COOKIE['ID'];
    $facility_id = $_POST['facility_id'];
   
    $regulatory_agency = mysqli_real_escape_string($conn,$_POST["regulatory_agency"]);
    $date_issuance = mysqli_real_escape_string($conn,$_POST["date_issuance"]);
    $date_due = mysqli_real_escape_string($conn,$_POST["date_due"]);
    $date_responded = mysqli_real_escape_string($conn,$_POST["date_responded"]);
    $number_violations = mysqli_real_escape_string($conn,$_POST["number_violations"]);
    
    $file = $_FILES['deficiency_files']['name'];
    if(!empty($file)){
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['deficiency_files']['name']));
        $rand = rand(10,1000000);
        $deficiency_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['deficiency_files']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    }
    
    $sql = "INSERT INTO tblFacilityDetails_deficiency(regulatory_agency,date_issuance,date_due,date_responded,number_violations,deficiency_files,deficiency_addedby,enterprise_pk,facility_id) 
    VALUES('$regulatory_agency','$date_issuance','$date_due','$date_responded','$number_violations','$deficiency_files','$cookie','$user_id','$facility_id')";
    if(mysqli_query($conn, $sql)){
        $last_id = mysqli_insert_id($conn);
         $query = mysqli_query($conn, "select * from tblFacilityDetails_deficiency where deficiency_pk = $last_id");
        if(mysqli_fetch_row($query)){
        foreach($query as $row_deficiency){?>
            <tr id="row_deficiency<?=$row_deficiency['deficiency_pk']; ?>">
                <td><?=$row_deficiency['regulatory_agency']; ?></td>
                <td><?= date('Y-m-d', strtotime($row_deficiency['date_issuance'])); ?></td>
                <td><?= date('Y-m-d', strtotime($row_deficiency['date_due'])); ?></td>
                <td><?= $row_deficiency['number_violations']; ?></td>
                <td><a href="facility_files_Folder/<?= $row_deficiency['deficiency_files']; ?>" target="_blank"><?= $row_deficiency['deficiency_files']; ?></a></td>
                <td width="150px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_deficiency" data-toggle="modal" type="button" id="update_deficiency" data-id="<?=$row_deficiency['deficiency_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_deficiency" data-toggle="modal" type="button" id="delete_deficiency" data-id="<?=$row_deficiency['deficiency_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
            </tr>
        <?php } 
        }
     }
}

//update Deficiency
if( isset($_GET['get_deficiency_id']) ) {
	$ID = $_GET['get_deficiency_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblFacilityDetails_deficiency where deficiency_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
               <div class="form-group">
                    <label>Regulatory Agency</label>
                    <input class="form-control" type="text" name="regulatory_agency" value="<?= $row['regulatory_agency']; ?>">
                </div>
                <div class="form-group">
                    <label>Date of Issuance</label>
                    <input class="form-control" type="date" name="date_issuance" value="<?= date('Y-m-d', strtotime($row['date_issuance'])); ?>">
                </div>
                <div class="form-group">
                    <label>Date Due</label>
                    <input class="form-control" type="date" name="date_due" value="<?= date('Y-m-d', strtotime($row['date_due'])); ?>">
                </div>
                <div class="form-group <?php echo $_COOKIE['client'] == 1 ? '':'hide'; ?> ?>">
                    <label>Date Responded</label>
                    <input class="form-control" type="date" name="date_responded" value="<?= $row['date_responded']; ?>">
                </div>
                <div class="form-group">
                    <label>Number of Violations</label>
                    <input class="form-control" type="text" name="number_violations" value="<?= $row['number_violations']; ?>">
                </div>
                <div class="form-group"> 
                    <label>Supporting Files</label>
                    <input class="form-control" type="file" name="deficiency_files">
                    <input class="form-control" type="hidden" name="deficiency_files2" value="<?= $row['deficiency_files']; ?>">
                </div>
    <?php } 
}
if( isset($_POST['btnSave_deficiency']) ) {
  
    $cookie = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $regulatory_agency = mysqli_real_escape_string($conn,$_POST["regulatory_agency"]);
    $date_due = mysqli_real_escape_string($conn,$_POST["date_due"]);
    $date_responded = mysqli_real_escape_string($conn,$_POST["date_responded"]);
    $date_issuance = mysqli_real_escape_string($conn,$_POST["date_issuance"]);
    $number_violations = mysqli_real_escape_string($conn,$_POST["number_violations"]);
    
    $file = $_FILES['deficiency_files']['name'];
    if(!empty($file)){
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['deficiency_files']['name']));
        $rand = rand(10,1000000);
        $deficiency_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['deficiency_files']['tmp_name'],'../facility_files_Folder/'.$to_File_Documents);
    }
    else{
        $deficiency_files  = mysqli_real_escape_string($conn,$_POST['deficiency_files2']);
    }
   
	$sql = "UPDATE tblFacilityDetails_deficiency set regulatory_agency='$regulatory_agency',date_due='$date_due',date_responded='$date_responded',date_issuance='$date_issuance',number_violations='$number_violations',deficiency_files='$deficiency_files',deficiency_addedby='$cookie' where deficiency_pk = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tblFacilityDetails_deficiency where deficiency_pk = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($row_deficiency = mysqli_fetch_array($resultr))
             { ?>
                <td><?=$row_deficiency['regulatory_agency']; ?></td>
                <td><?= date('Y-m-d', strtotime($row_deficiency['date_issuance'])); ?></td>
                <td><?= date('Y-m-d', strtotime($row_deficiency['date_due'])); ?></td>
                <td><?= $row_deficiency['number_violations']; ?></td>
                <td><a href="facility_files_Folder/<?= $row_deficiency['deficiency_files']; ?>" target="_blank"><?= $row_deficiency['deficiency_files']; ?></a></td>
                <td width="150px">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_deficiency" data-toggle="modal" type="button" id="update_deficiency" data-id="<?=$row_deficiency['deficiency_pk']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_deficiency" data-toggle="modal" type="button" id="delete_deficiency" data-id="<?=$row_deficiency['deficiency_pk']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
          <?php }
          
          
    }
}

//delete Deficiency
if( isset($_GET['delete_deficiency_id']) ) {
	$ID = $_GET['delete_deficiency_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tblFacilityDetails_deficiency where deficiency_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Regulatory Agency: </b></label>
                        <i><?= $row['regulatory_agency']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Date of Issuance: </b></label>
                        <i><?= $row['date_issuance']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Date Due: </b></label>
                        <i><?= $row['date_due']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Number of Violations: </b></label>
                        <i><?= $row['number_violations']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btndelete_deficiency']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "UPDATE tblFacilityDetails_deficiency set is_deleted=1  where deficiency_pk = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}
    if( isset($_GET['btnDelete_F_Contact']) ) {
        $id = $_GET['btnDelete_F_Contact'];
        mysqli_query( $conn,"UPDATE tblFacilityDetails_contact set deleted = 1 WHERE con_id = $id" );
    }
    if( isset($_GET['btnDelete_F_Emergency']) ) {
        $id = $_GET['btnDelete_F_Emergency'];
        mysqli_query( $conn,"UPDATE tblFacilityDetails_Emergency set deleted = 1 WHERE emerg_id = $id" );
    }
?>