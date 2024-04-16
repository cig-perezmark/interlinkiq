<?php
include "../database.php";
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

// new added 2
if( isset($_POST['btnNew_added']) ) {
	
	$cookie = $_COOKIE['ID'];
 	$ccandidates_pk = '';
	$jobs_name = mysqli_real_escape_string($conn,$_POST['jobs_name']);
 	$jobs_category_pk = mysqli_real_escape_string($conn,$_POST['jobs_category_pk']);
 	$is_active = mysqli_real_escape_string($conn,$_POST['is_active']);
 	
    if(!empty($_POST["candidates_pk"]))
    {
        foreach($_POST["candidates_pk"] as $candidates_pk)
        {
            $ccandidates_pk .= $candidates_pk.', ';
        }
         
    }
    $ccandidates_pk = substr($ccandidates_pk, 0, -2);
    $sql = "INSERT INTO tbl_hr_crm_jobs (jobs_name,jobs_category_pk,is_active,candidates_pk,jobs_addedby,jobs_ownedby) 
    VALUES ('$jobs_name','$jobs_category_pk','$is_active','$ccandidates_pk','$cookie','$user_id')";
    if(mysqli_query($conn, $sql)){
        $last_id = mysqli_insert_id($conn);
         $query = mysqli_query($conn,"select * from tbl_hr_crm_jobs where jobs_pk = '$last_id'");
            foreach($query as $row){?>
               <tr class="data_row<?= $row['jobs_category_pk']; ?>"  id="data_<?= $row['jobs_pk']; ?>">
                  <td><?= $row['jobs_name']; ?></td>
                  <td>
                       <?php
                            $array_data = explode(", ", $row["candidates_pk"]);
                            $candidate = mysqli_query($conn, "select * from tbl_hr_crm_jobs_candidates");
                            foreach($candidate as $row_can){
                            if(!empty(in_array($row_can['candidates_id'],$array_data))){?>
                                <?= $row_can['full_name'].', '; ?>
                            <?php } }
                        ?>
                  </td>
                  <td>
                    <?php
                        $job_id = $row['jobs_category_pk'];
                        $query_subs = mysqli_query($conn,"select * from tbl_hr_crm_category where category_pk = '$job_id'");
                        foreach($query_subs as $row_subs){?>
                            <?= $row_subs['category_name']; ?>
                        <?php }
                    ?>
                  </td>
                  <td>
                    <?php 
                        if($row['is_active'] == 0){ echo 'Active';}
                        else if($row['is_active'] == 1){ echo 'In-Active';}
                    ?>
                  </td>
                  <td>
                    <a href="#modal_update_status" data-toggle="modal" class="btn green btn-xs" type="button" id="update_status" data-id="<?= $row['jobs_pk']; ?>" >Edit</a>
                </td>
              </tr>
           <?php } 
         
    }
    else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
 
	mysqli_close($conn);
}

//update Jobs
if( isset($_GET['GetAI']) ) {
	$ID = $_GET['GetAI'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="job_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tbl_hr_crm_jobs where jobs_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
               
                <div class="form-group">
                   <div class="col-md-12">
                       <label>Jobs Title</label>
                       <input class="form-control" name="jobs_name" value="<?= $row['jobs_name']; ?>">
                   </div>
               </div>
               <div class="form-group">
                   <div class="col-md-12">
                       <label>Candidates</label>
                       <select class="form-control mt-multiselect btn btn-default" type="text" name="candidates_pk[]" multiple>
                            <?php
                            
                                $array_data = explode(", ", $row["candidates_pk"]);
                                $queryPres = "SELECT * FROM tbl_hr_crm_jobs_candidates where ownedby = '$user_id' and is_hired = 0 order by full_name ASC";
                                $resultPres = mysqli_query($conn, $queryPres);
                                while($rowPres = mysqli_fetch_array($resultPres))
                                { ?>
                                   <option value="<?= $rowPres['candidates_id']; ?>" <?php if(in_array($rowPres['candidates_id'],$array_data)){ echo 'selected'; } ?>><?= $rowPres['full_name']; ?></option>
                                <?php }
                             ?>
                             <option value="0">---Others---</option>
                        </select>
                   </div>
               </div>
               <div class="form-group">
                   <div class="col-md-6">
                       <label>Category</label>
                       <select class="form-control" name="jobs_category_pk">
                           <option value="0">---Select---</option>
                           <?php
                                $query_subs = mysqli_query($conn,"select * from tbl_hr_crm_category where cat_ownedby = '$user_id' order by category_name ASC");
                                foreach($query_subs as $row_subs){?>
                                    <option value="<?= $row_subs['category_pk'];?>" <?php if($row['jobs_category_pk']== $row_subs['category_pk']){ echo 'selected'; } ?>><?= $row_subs['category_name'];?></option>
                                <?php } ?>
                           ?>
                       </select>
                   </div>
                   <div class="col-md-6">
                       <label>Status</label>
                       <select class="form-control" name="is_active">
                           <option value="0" <?php if($row['is_active']== 0){ echo 'selected'; } ?>>Active</option>
                           <option value="1" <?php if($row['is_active']== 1){ echo 'selected'; } ?>>In-Active</option>
                       </select>
                   </div>
               </div>
    <?php } 
}
if( isset($_POST['btnSave_status']) ) {
  
    $cookie = $_COOKIE['ID'];
 	$ccandidates_pk = '';
 	$IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$jobs_name = mysqli_real_escape_string($conn,$_POST['jobs_name']);
 	$jobs_category_pk = mysqli_real_escape_string($conn,$_POST['jobs_category_pk']);
 	$is_active = mysqli_real_escape_string($conn,$_POST['is_active']);
 	
    if(!empty($_POST["candidates_pk"]))
    {
        foreach($_POST["candidates_pk"] as $candidates_pk)
        {
            $ccandidates_pk .= $candidates_pk.', ';
        }
         
    }
    $ccandidates_pk = substr($ccandidates_pk, 0, -2);
	$sql = "UPDATE tbl_hr_crm_jobs set jobs_name='$jobs_name',jobs_category_pk='$jobs_category_pk',is_active='$is_active',is_active='$is_active',candidates_pk ='$ccandidates_pk' where jobs_pk = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $query = mysqli_query($conn,"select * from tbl_hr_crm_jobs where jobs_pk = '$IDs'");
        foreach($query as $row){?>
              <td><?= $row['jobs_name']; ?></td>
              <td>
                   <?php
                        $array_data = explode(", ", $row["candidates_pk"]);
                        $candidate = mysqli_query($conn, "select * from tbl_hr_crm_jobs_candidates");
                        foreach($candidate as $row_can){
                        if(!empty(in_array($row_can['candidates_id'],$array_data))){?>
                            <?= $row_can['full_name'].', '; ?>
                        <?php } }
                    ?>
              </td>
              <td>
                <?php
                    $job_id = $row['jobs_category_pk'];
                    $query_subs = mysqli_query($conn,"select * from tbl_hr_crm_category where category_pk = '$job_id'");
                    foreach($query_subs as $row_subs){?>
                        <?= $row_subs['category_name']; ?>
                    <?php }
                ?>
              </td>
              <td>
                <?php 
                    if($row['is_active'] == 0){ echo 'Active';}
                    else if($row['is_active'] == 1){ echo 'In-Active';}
                ?>
              </td>
              <td>
                <a href="#modal_update_status" data-toggle="modal" class="btn green btn-xs" type="button" id="update_status" data-id="<?= $row['jobs_pk']; ?>" >Edit</a>
            </td>
       <?php } 
    }
}

//candidate
if( isset($_GET['get_candidate']) ) {
   
        $cookies = $_COOKIE['ID'];
        $query = "SELECT *  FROM tbl_hr_crm_jobs_candidates where ownedby = '$user_id' and is_deleted = 0";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
        {?>
            <tr id="row1_<?= $row['candidates_id']; ?>">
                <td><?= $row['full_name']; ?></td>
                <td><?= $row['email']; ?></td>
                <td>
                    <?php  
                        if($row['is_hired'] == 0){ echo 'Open'; }
                        else if($row['is_hired'] == 1){ echo 'Hired'; }
                    ?>
                </td>
                <td><?= date('Y-m-d', strtotime($row['invitation_date'])); ?></td>
                <td style="width:150px;">
                    <div class="btn-group btn-group">
                       <a href="#modal_update_candidates" data-toggle="modal" class="btn dark btn-outline btn-xs" type="button" id="update_candidate" data-id="<?= $row['candidates_id']; ?>">Edit</a>
                        <a href="#modal_delete_candidates" data-toggle="modal" class="btn red btn-xs" type="button" id="delete_candidate" data-id="<?= $row['candidates_id']; ?>">Delete</a>
                    </div>
                </td>
            </tr>
        <?php }
}

// new added candidates
if( isset($_POST['btnNew_candidate']) ) {
	
	$cookie = $_COOKIE['ID'];
	$full_name = mysqli_real_escape_string($conn,$_POST['full_name']);
 	$email = mysqli_real_escape_string($conn,$_POST['email']);
 	$is_hired = mysqli_real_escape_string($conn,$_POST['is_hired']);
 	$invitation_date = mysqli_real_escape_string($conn,$_POST['invitation_date']);
 	
    $sql = "INSERT INTO tbl_hr_crm_jobs_candidates (full_name,email,is_hired,invitation_date,addedby,ownedby) 
    VALUES ('$full_name','$email','$is_hired','$invitation_date','$cookie','$user_id')";
    if(mysqli_query($conn, $sql)){
        $last_id = mysqli_insert_id($conn);
        $query = "SELECT *  FROM tbl_hr_crm_jobs_candidates where candidates_id = '$last_id'";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
        {?>
            <tr id="row1_<?= $row['candidates_id']; ?>">
                <td><?= $row['full_name']; ?></td>
                <td><?= $row['email']; ?></td>
                <td>
                    <?php  
                        if($row['is_hired'] == 0){ echo 'Open'; }
                        else if($row['is_hired'] == 1){ echo 'Hired'; }
                    ?>
                </td>
                <td><?= date('Y-m-d', strtotime($row['invitation_date'])); ?></td>
                <td style="width:150px;">
                    <div class="btn-group btn-group">
                       <a href="#modal_update_candidates" data-toggle="modal" class="btn dark btn-outline btn-xs" type="button" id="update_candidate" data-id="<?= $row['candidates_id']; ?>">Edit</a>
                        <a href="#modal_delete_candidates" data-toggle="modal" class="btn red btn-xs" type="button" id="delete_candidate" data-id="<?= $row['candidates_id']; ?>">Delete</a>
                    </div>
                </td>
            </tr>
        <?php } 
    }
    else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
 
	mysqli_close($conn);
}

//update candidates
if( isset($_GET['GetCandidates']) ) {
	$ID = $_GET['GetCandidates'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="candidates_update_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tbl_hr_crm_jobs_candidates where candidates_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
              <div class="form-group">
                  <div class="col-md-12">
                      <label>Name</label>
                      <input class="form-control" name="full_name" value="<?= $row['full_name']; ?>">
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-12">
                      <label>Email</label>
                      <input class="form-control" name="email" value="<?= $row['email']; ?>">
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-6">
                      <label>Status</label>
                      <select class="form-control" name="is_hired">
                          <option value="0" <?php if($row['is_hired'] == 0){ echo 'selected'; } ?>>Open</option>
                          <option value="1" <?php if($row['is_hired'] == 1){ echo 'selected'; } ?>>Hired</option>
                      </select>
                  </div>
                  <div class="col-md-6">
                      <label>Status</label>
                      <input class="form-control" type="date" name="invitation_date" value="<?= date('Y-m-d', strtotime($row['invitation_date'])); ?>">
                  </div>
              </div>
              
                
    <?php } 
}
if( isset($_POST['btnSave_candidate']) ) {
  
    $cookie = $_COOKIE['ID'];
 	$IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$full_name = mysqli_real_escape_string($conn,$_POST['full_name']);
 	$email = mysqli_real_escape_string($conn,$_POST['email']);
 	$is_hired = mysqli_real_escape_string($conn,$_POST['is_hired']);
 	$invitation_date = mysqli_real_escape_string($conn,$_POST['invitation_date']);
 	
	$sql = "UPDATE tbl_hr_crm_jobs_candidates set full_name='$full_name',email='$email',is_hired='$is_hired',invitation_date='$invitation_date' where candidates_id = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $query = mysqli_query($conn,"select * from tbl_hr_crm_jobs_candidates where candidates_id = '$IDs'");
        foreach($query as $row){?>
               <td><?= $row['full_name']; ?></td>
                <td><?= $row['email']; ?></td>
                <td>
                    <?php  
                        if($row['is_hired'] == 0){ echo 'Open'; }
                        else if($row['is_hired'] == 1){ echo 'Hired'; }
                    ?>
                </td>
                <td><?= date('Y-m-d', strtotime($row['invitation_date'])); ?></td>
                <td style="width:150px;">
                    <div class="btn-group btn-group">
                       <a href="#modal_update_candidates" data-toggle="modal" class="btn dark btn-outline btn-xs" type="button" id="update_candidate" data-id="<?= $row['candidates_id']; ?>">Edit</a>
                        <a href="#modal_delete_candidates" data-toggle="modal" class="btn red btn-xs" type="button" id="delete_candidate" data-id="<?= $row['candidates_id']; ?>">Delete</a>
                    </div>
                </td>
       <?php } 
    }
}

//delete candidates
if( isset($_GET['GetCandidates_delete']) ) {
	$ID = $_GET['GetCandidates_delete'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="candidates_delete_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tbl_hr_crm_jobs_candidates where candidates_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
              <div class="form-group">
                  <div class="col-md-12">
                      <b>Name: </b><br>
                      <i><?= $row['full_name']; ?></i>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-12">
                      <b>Email: </b><br>
                      <i><?= $row['email']; ?></i>
                  </div>
              </div>
              
                
    <?php } 
}
if( isset($_POST['btnDelete_candidate']) ) {
  
    $cookie = $_COOKIE['ID'];
 	$IDs = mysqli_real_escape_string($conn,$_POST['ID']);
 	
	$sql = "UPDATE tbl_hr_crm_jobs_candidates set is_deleted = 1 where candidates_id = $IDs";
    if(mysqli_query($conn, $sql)){
        echo $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    }
}
?>