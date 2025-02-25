<?php
	require '../database.php';
	// Get status only
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

if( isset($_GET['get_topay']) ) {?>
   
        <?php
            
            $cookies = $_COOKIE['ID'];
            $query = "SELECT *  FROM tbl_project_management where project_ownedby = '$user_id'";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            {
                $proj_pk = $row['project_pk'];
                $scope_query = mysqli_query($conn, "select * from tbl_project_management_scope where project_id =  '$proj_pk' and is_deleted = 0 and status_action = 'Close'");
                $row_scope = mysqli_fetch_array($scope_query);
                if($proj_pk == $row_scope['project_id']){
                ?>
                    <tr id="row1_<?= $row['project_pk']; ?>">
                        <td><?= $row['project_name']; ?></td>
                        <td><?= $row['descriptions']; ?></td>
                        <td>
                            <?php
                                $your_emp = $_COOKIE['employee_id'];
                                $project_pk = $row['project_pk'];
                                $qry = mysqli_query($conn, "select DISTINCT(assigned_to),project_id from tbl_project_management_scope where project_id = '$project_pk' and is_deleted = 0");
                                foreach($qry as $assg_row){
                                    $assigned_to = $assg_row['assigned_to'];
                                    $emp_qry = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$assigned_to'");
                                    foreach($emp_qry as $emp_assg){
                                        echo $emp_assg['first_name'].' '.$emp_assg['last_name'].'<br>';
                                    }
                                }
                            ?>
                        </td>
                        <td><?= date('Y-m-d', strtotime($row['project_date'])); ?></td>
                        <td><?= $row['project_no']; ?></td>
                        <td><?= date('Y-m-d', strtotime($row['start_date'])); ?></td>
                        <td><?= date('Y-m-d', strtotime($row['completion_date'])); ?></td>
                        <td><?= $row['allocate_hour']; ?></td>
                        <td><?= $row['project_area']; ?></td>
                        <td><a href="project_management_file/<?= $row['supporting_files']; ?>" target="_blank"><?= $row['supporting_files']; ?></a></td>
                        <td style="width:100px;">
                            <div class="btn-group btn-group-circle">
                               <a href="#modalGet_details1" data-toggle="modal" class="btn btn-outline green btn-sm" type="button" onclick="btnUpdate_meeting_details1(<?php echo  $row['project_pk']; ?>)">View</a>
                                <a class="btn red btn-sm" type="button" id="print_btn" data-id="<?php echo  $row['project_pk']; ?>">PDF</a>
                            </div>
                        </td>
                    </tr>
            <?php } }
        ?>
<?php }
else if( isset($_GET['get_paid']) ) {?>
   
       
        <?php
            $cookies = $_COOKIE['ID'];
            $emp_cookies = $_COOKIE['employee_id'];
            $query = "SELECT *  FROM tbl_project_management where project_ownedby = '$user_id' and is_completed = 3";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            {
                $array_data = explode(", ", $row["collaborator_pk"]);
                if(in_array($emp_cookies,$array_data)){?>
                <tr id="row2_<?= $row['project_pk']; ?>">
                    <td><?= $row['project_name']; ?></td>
                    <td><?= $row['descriptions']; ?></td>
                    <td>
                        <?php
                            $your_emp = $_COOKIE['employee_id'];
                            $project_pk = $row['project_pk'];
                            $qry = mysqli_query($conn, "select DISTINCT(assigned_to),project_id from tbl_project_management_scope where project_id = '$project_pk' and is_deleted = 0");
                            foreach($qry as $assg_row){
                                $assigned_to = $assg_row['assigned_to'];
                                $emp_qry = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$assigned_to'");
                                foreach($emp_qry as $emp_assg){
                                    echo $emp_assg['first_name'].' '.$emp_assg['last_name'].'<br>';
                                }
                            }
                        ?>
                    </td>
                    <td><?= date('Y-m-d', strtotime($row['project_date'])); ?></td>
                    <td><?= $row['project_no']; ?></td>
                    <td><?= date('Y-m-d', strtotime($row['start_date'])); ?></td>
                    <td><?= date('Y-m-d', strtotime($row['completion_date'])); ?></td>
                    <td><?= $row['allocate_hour']; ?></td>
                    <td><?= $row['project_area']; ?></td>
                    <td><a href="project_management_file/<?= $row['supporting_files']; ?>" target="_blank"><?= $row['supporting_files']; ?></a></td>
                    <td style="width:100px;">
                        <div class="btn-group btn-group-circle">
                           <a href="#modalGet_details1" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details1(<?php echo  $row['project_pk']; ?>)">Edit</a>
                            <a class="btn red btn-sm" type="button" id="print_btn" data-id="<?php echo  $row['project_pk']; ?>">PDF</a>
                        </div>
                    </td>
                </tr>
            <?php } }
        ?>
<?php }

else if( isset($_GET['get_completed']) ) {?>
   
       <?php
            $cookies = $_COOKIE['ID'];
            $emp_cookies = $_COOKIE['employee_id'];
            $query = "SELECT *  FROM tbl_project_management where addedby = '$cookies' and is_completed != 0";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            {
                ?>
                <tr id="row2_<?= $row['project_pk']; ?>">
                    <td><?= $row['project_name']; ?></td>
                    <td><?= $row['descriptions']; ?></td>
                    <td>
                        <?php
                            $your_emp = $_COOKIE['employee_id'];
                            $project_pk = $row['project_pk'];
                            $qry = mysqli_query($conn, "select DISTINCT(assigned_to),project_id from tbl_project_management_scope where project_id = '$project_pk' and is_deleted = 0");
                            foreach($qry as $assg_row){
                                $assigned_to = $assg_row['assigned_to'];
                                $emp_qry = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$assigned_to'");
                                foreach($emp_qry as $emp_assg){
                                    echo $emp_assg['first_name'].' '.$emp_assg['last_name'].'<br>';
                                }
                            }
                        ?>
                    </td>
                    <td><?= date('Y-m-d', strtotime($row['project_date'])); ?></td>
                    <td><?= $row['project_no']; ?></td>
                    <td><?= date('Y-m-d', strtotime($row['start_date'])); ?></td>
                    <td><?= date('Y-m-d', strtotime($row['completion_date'])); ?></td>
                    <td><?= $row['allocate_hour']; ?></td>
                    <td><?= $row['project_area']; ?></td>
                    <td><a href="project_management_file/<?= $row['supporting_files']; ?>" target="_blank"><?= $row['supporting_files']; ?></a></td>
                    <td style="width:100px;">
                        <div class="btn-group btn-group-circle">
                           <a href="#modalGet_details1" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details1(<?php echo  $row['project_pk']; ?>)">Edit</a>
                            <a class="btn red btn-sm" type="button" id="print_btn" data-id="<?php echo  $row['project_pk']; ?>">PDF</a>
                        </div>
                    </td>
                </tr>
            <?php } 
        ?>
        <?php
            $cookies = $_COOKIE['ID'];
            $emp_cookies = $_COOKIE['employee_id'];
            $query = "SELECT *  FROM tbl_project_management where addedby != '$cookies' and is_completed != 0";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            {
                $array_data = explode(", ", $row["collaborator_pk"]);
                if(in_array($emp_cookies,$array_data)){?>
                <tr id="row2_<?= $row['project_pk']; ?>">
                    <td><?= $row['project_name']; ?></td>
                    <td><?= $row['descriptions']; ?></td>
                    <td>
                        <?php
                            $your_emp = $_COOKIE['employee_id'];
                            $project_pk = $row['project_pk'];
                            $qry = mysqli_query($conn, "select DISTINCT(assigned_to),project_id from tbl_project_management_scope where project_id = '$project_pk' and is_deleted = 0");
                            foreach($qry as $assg_row){
                                $assigned_to = $assg_row['assigned_to'];
                                $emp_qry = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$assigned_to'");
                                foreach($emp_qry as $emp_assg){
                                    echo $emp_assg['first_name'].' '.$emp_assg['last_name'].'<br>';
                                }
                            }
                        ?>
                    </td>
                    <td><?= date('Y-m-d', strtotime($row['project_date'])); ?></td>
                    <td><?= $row['project_no']; ?></td>
                    <td><?= date('Y-m-d', strtotime($row['start_date'])); ?></td>
                    <td><?= date('Y-m-d', strtotime($row['completion_date'])); ?></td>
                    <td><?= $row['allocate_hour']; ?></td>
                    <td><?= $row['project_area']; ?></td>
                    <td><a href="project_management_file/<?= $row['supporting_files']; ?>" target="_blank"><?= $row['supporting_files']; ?></a></td>
                    <td style="width:100px;">
                        <div class="btn-group btn-group-circle">
                           <a href="#modalGet_details1" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details1(<?php echo  $row['project_pk']; ?>)">Edit</a>
                            <a class="btn red btn-sm" type="button" id="print_btn" data-id="<?php echo  $row['project_pk']; ?>">PDF</a>
                        </div>
                    </td>
                </tr>
            <?php } }
        ?>
<?php }
else if( isset($_GET['get_list']) ) {?>
     <?php
                                                
        $cookies = $_COOKIE['ID'];
        $query = "SELECT *  FROM tbl_project_management where addedby = '$cookies' and is_completed = 0";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
        {?>
            <tr id="row_<?= $row['project_pk']; ?>">
                <td><a href="#modal_completed_plan" data-toggle="modal" type="button" id="completed_btn" data-id="<?= $row['project_pk']; ?>" class="btn green btn-xs" onclick=""><i class="fa fa-check"></i></a></td>
                <td><?= $row['project_name']; ?></td>
                <td><?= $row['descriptions']; ?></td>
                <td>
                    <?php
                        $your_emp = $_COOKIE['employee_id'];
                        $project_pk = $row['project_pk'];
                        $qry = mysqli_query($conn, "select DISTINCT(assigned_to),project_id from tbl_project_management_scope where project_id = '$project_pk' and is_deleted = 0");
                        foreach($qry as $assg_row){
                            $assigned_to = $assg_row['assigned_to'];
                            $emp_qry = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$assigned_to'");
                            foreach($emp_qry as $emp_assg){
                                echo $emp_assg['first_name'].' '.$emp_assg['last_name'].'<br>';
                            }
                        }
                    ?>
                </td>
                <td><?= date('Y-m-d', strtotime($row['project_date'])); ?></td>
                <td><?= $row['project_no']; ?></td>
                <td><?= date('Y-m-d', strtotime($row['start_date'])); ?></td>
                <td><?= date('Y-m-d', strtotime($row['completion_date'])); ?></td>
                <td><?= $row['allocate_hour']; ?></td>
                <td><?= $row['project_area']; ?></td>
                <td><a href="project_management_file/<?= $row['supporting_files']; ?>" target="_blank"><?= $row['supporting_files']; ?></a></td>
                <td style="width:100px;">
                    <div class="btn-group btn-group-circle">
                       <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details(<?php echo  $row['project_pk']; ?>)">Edit</a>
                        <a class="btn red btn-sm" type="button" id="print_btn" data-id="<?php echo  $row['project_pk']; ?>">PDF</a>
                    </div>
                </td>
            </tr>
        <?php }
    ?>
    <?php
        $cookies = $_COOKIE['ID'];
        $emp_cookies = $_COOKIE['employee_id'];
        $query = "SELECT *  FROM tbl_project_management where addedby != '$cookies' and is_completed = 0";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
        {
            $array_data = explode(", ", $row["collaborator_pk"]);
            if(in_array($emp_cookies,$array_data)){?>
            <tr id="row_<?= $row['project_pk']; ?>">
                <td><a href="#modal_completed_plan" data-toggle="modal" type="button" id="completed_btn" data-id="<?= $row['project_pk']; ?>" class="btn green btn-xs" onclick=""><i class="fa fa-check"></i></a></td>
                <td><?= $row['project_name']; ?></td>
                <td><?= $row['descriptions']; ?></td>
                <td><?= date('Y-m-d', strtotime($row['project_date'])); ?></td>
                <td><?= $row['project_no']; ?></td>
                <td><?= date('Y-m-d', strtotime($row['start_date'])); ?></td>
                <td><?= date('Y-m-d', strtotime($row['completion_date'])); ?></td>
                <td><?= $row['allocate_hour']; ?></td>
                <td><?= $row['project_area']; ?></td>
                <td><a href="project_management_file/<?= $row['supporting_files']; ?>" target="_blank"><?= $row['supporting_files']; ?></a></td>
                <td style="width:100px;">
                    <div class="btn-group btn-group-circle">
                       <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details(<?php echo  $row['project_pk']; ?>)">Edit</a>
                        <a class="btn red btn-sm" type="button" id="print_btn" data-id="<?php echo  $row['project_pk']; ?>">PDF</a>
                    </div>
                </td>
            </tr>
        <?php } }
    ?>
<?php }
?>
