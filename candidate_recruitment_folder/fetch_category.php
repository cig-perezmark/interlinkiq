<?php
require '../database.php';
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

if (isset($_POST['key'])) {
	
	if ($_POST['key'] == 'get_default') {
	    $query = mysqli_query($conn,"select * from tbl_hr_crm_jobs where jobs_ownedby = '$user_id' and is_deleted = 0");
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
        
       else if ($_POST['key'] == 'get_count_jobs') {
	    $query1 = mysqli_query($conn,"select count(*) as count from tbl_hr_crm_jobs where jobs_ownedby = '$user_id' and is_deleted = 0 and is_active= 0");
        foreach($query1 as $row){?>
            <?= $row['count']; ?>
        <?php } 
        }
        
        
        else if ($_POST['key'] == 'get_count_candidates') {
	    $query2 = mysqli_query($conn,"select count(*) as count from tbl_hr_crm_jobs_candidates where ownedby = '$user_id' and is_deleted = 0 and is_hired= 0");
        foreach($query2 as $row){?>
            <?= $row['count']; ?>
        <?php } 
        } 
}
	
?>
