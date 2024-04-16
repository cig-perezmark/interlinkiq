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

if(isset($_GET['print_id'])){
   $id = $_GET['print_id'];
   $query = mysqli_query($conn, "select * from tbl_project_management where project_pk = '$id'");
   foreach($query as $row_proj){?>
        <center><h2><b>Project Management Form</b></h2></center><br><br><br>
        <table class="table table-bordered" style="table-layout:fixed;width:100%;">
            <tr>
                <td><b>Project Name:</b> <?= $row_proj['project_name'];?></td>
                <td><b>Date:</b> <?php echo date('Y-m-d', strtotime($row_proj['project_date'])); ?></td>
            </tr>
            <tr>
                <td><b>Description:</b><br> <?= $row_proj['descriptions'];?></td>
                <td>
                    <b>Project No.:</b> <?= $row_proj['project_no'];?><hr>
                    <b>Start Date:</b> <?php echo date('Y-m-d', strtotime($row_proj['start_date'])); ?><hr>
                    <b>Target Completion Date:</b> <?php echo date('Y-m-d', strtotime($row_proj['completion_date'])); ?>
                </td>
            </tr>
        </table>
        <table class="table table-bordered" style="table-layout:fixed;width:100%;">
            <thead>
                <th>Scope of Work</th>
                <th>Action Items</th>
                <th>Assigned To</th>
                <th>Completion Date</th>
                <th>Hour</th>
                <th>Status</th>
            </thead>
            <tbody id="dynamic_field2">
                <?php
                    $proj_pk = $row_proj['project_pk'];
                    $scope_query = mysqli_query($conn, "select * from tbl_project_management_scope where project_id =  '$proj_pk' and is_deleted = 0");
                    foreach($scope_query as $scope){?>
                        <tr>
                            <td><?= $scope['scope_work']; ?></td>
                            <td><?= $scope['action_item']; ?></td>
                            <td>
                                <?php 
                                    $emp_id = $scope['assigned_to']; 
                                    $assign_query = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$emp_id'");
                                    foreach($assign_query as $row_emp){
                                        echo $row_emp['first_name'].' '.$row_emp['last_name'];
                                    }
                                ?>
                            </td>
                            <td><?= date('Y-m-d', strtotime($scope['completion_date'])); ?></td>
                            <td><?= $scope['hours']; ?></td>
                            <td><?= $scope['status_action']; ?></td>
                        </tr>
                    <?php }
                ?>
                <tr >
                    <td style="border:solid transparent 1px !important;border-left:solid #ccc 1px !important;border-bottom:solid #ccc 1px !important;"><b>Total Hours</b></td>
                    <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                    <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                    <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                    <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;">
                        <?php
                            $proj_pk = $row_proj['project_pk'];
                            $scope_count = mysqli_query($conn, "select sum(hours) as count from tbl_project_management_scope where project_id =  '$proj_pk' and is_deleted = 0");
                            foreach($scope_count as $count){
                                echo '<b>'.$count['count'].'</b>';
                            }
                        ?>
                    </td>
                    <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;border-right:solid #ccc 1px !important;"></td>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered" style="table-layout:fixed;width:100%;">
            <tbody>
               <tr>
                   <td>
                       <b>Remarks:</b><br>
                       <?= $row_proj['remarks'];?>
                   </td>
               </tr> 
            </tbody>
        </table>
        <br><br><br>
        <table class="" style="table-layout:fixed;width:100%;border:none;">
            <tbody>
               <tr>
                   <td>
                       <b>Prepared By</b><br><br>
                       <?php
                            $prep = $row_proj['prepared_by'];
                            $queryVeri = "SELECT * FROM tbl_hr_employee where ID = '$prep'";
                            $resultVeri = mysqli_query($conn, $queryVeri);
                            while($rowVeri = mysqli_fetch_array($resultVeri))
                            { ?>
                               <?= $rowVeri['first_name']; ?> <?= $rowVeri['last_name']; ?>
                            <?php }
                         ?>
                   </td>
                   <td>
                       <b>Date</b><br><br>
                       <?= date('Y-m-d', strtotime($row_proj['prepared_date'])); ?>
                   </td>
               </tr>
               <tr>
                   <td><br><br>
                       <b>Approved By</b><br><br>
                       <?php
                            $appr = $row_proj['approved_by'];
                            $queryVeri = "SELECT * FROM tbl_hr_employee where ID = '$appr'";
                            $resultVeri = mysqli_query($conn, $queryVeri);
                            while($rowVeri = mysqli_fetch_array($resultVeri))
                            { ?>
                               <?= $rowVeri['first_name']; ?> <?= $rowVeri['last_name']; ?>
                            <?php }
                         ?>
                   </td>
                   <td><br><br>
                       <b>Date</b><br><br>
                       <?= date('Y-m-d', strtotime($row_proj['approved_date'])); ?>
                   </td>
               </tr> 
            </tbody>
        </table>
        
   <?php }
}
?>
