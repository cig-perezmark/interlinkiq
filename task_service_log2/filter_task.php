<?php
	require '../database.php';
	
if(isset($_POST['start_date_filter1']) && isset($_POST['end_date_filter1'])){
        $cookie = $_COOKIE['ID'];
    	$start = $_POST['start_date_filter1'];
    	$end = $_POST['end_date_filter1'];
	    $sql2 = $conn->query("SELECT *,ifnull(sum(minute), 0) as total_mim FROM tbl_service_logs left join tbl_user  on ID = user_id WHERE user_id = '$cookie' and task_date BETWEEN '$start' AND '$end' AND not_approved = 0 ");
		
		while($data2 = $sql2->fetch_array()) {
        ?>
		
        <div class="panel-group accordion" id="accordion3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1"> 
                            <div class="row">
                                <div class="col-md-6">
                                    <b><?= $data2['first_name']; ?> <?= $data2['last_name']; ?> </b>
                                </div>
                                <div class="col-md-3">
                                    <b>Total Tasks</b> (
                                    <?php
                                        $user_logs_id = $data2['ID'];
                                        $query_tasks = mysqli_query($conn, "select count(*) as total_task,task_date,user_id,minute from tbl_service_logs where user_id = '$user_logs_id' and task_date BETWEEN '$start' AND '$end' AND not_approved = 0 ");
                                        foreach($query_tasks as $task_row){
                                            echo $task_row['total_task'];
                                        }
                                    ?> )
                                </div>
                                <div class="col-md-3">
                                    <b>Total Hours</b> (
                                    <?php
                                        $time = $data2['total_mim'];
                                        $hours = floor($time / 60);
                                        $minutes = ($time % 60);
                                        if($minutes == 0 && $hours == 0){ echo '<i style="color:red;">No logs this week!</i>';}
                                        
                                        if($hours != 0){echo $hours;}
                                        if($hours != 0){ echo ' hour'; }
                                        if($hours > 1){ echo 's '; }
                                        
                                        if($minutes != 0 && $hours != 0){ echo ' & ';}
                                        if($minutes != 0){ echo $minutes;}
                                        if($minutes != 0){ echo ' minute';}
                                        if($minutes > 1){ echo 's';}
                                    ?>)
                                </div>
                            </div>
                        </a>
                    </h4>
                </div>
                <div id="collapse_3_1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Task ID</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                    <th>Comment</th>
                                    <th>Account</th>
                                    <th>Task Date</th>
                                    <th>Minute</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        $user_logs_id1 = $data2['ID'];
                                        $query_task_logs = mysqli_query($conn, "select * from tbl_service_logs where user_id = '$user_logs_id1' and task_date BETWEEN '$start' AND '$end' AND not_approved = 0");
                                        foreach($query_task_logs as $log_row){?>
                                            <tr>
                                                <td><?= $log_row['task_id']; ?></td>
                                                <td><?= $log_row['description']; ?></td>
                                                <td><?= $log_row['action']; ?></td>
                                                <td><?= $log_row['comment']; ?></td>
                                                <td><?= $log_row['account']; ?></td>
                                                <td><?= $log_row['task_date']; ?></td>
                                                <td><?= $log_row['minute']; ?></td>
                                            </tr>
                                        <?php }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
		<br>
	<?php	}
}


//view ot status
if( isset($_GET['GetAI']) ) {
	$ID = $_GET['GetAI'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="meeting_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tbl_service_logs where task_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Task ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                            <th>Comment</th>
                            <th>Account</th>
                            <th>Task Date</th>
                            <th>Minutes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $u_id = $row['user_id'];
                            $t_id = $row['task_date'];
                            $overtime_query = mysqli_query($conn, "select * from tbl_service_logs where not_approved = 0 and user_id = '$u_id' and task_date = '$t_id'");
                            foreach($overtime_query as $ot_row){?>
                           
                                <tr id="scope_<?= $ot_row['task_id']; ?>" >
                                   
                                    <td><?= $ot_row['task_id']; ?></td>
                                    <td>
                                        <?php 
                                            $uuser = $ot_row['user_id'];
                                            $query_user = mysqli_query($conn, "select * from tbl_user where ID = '$uuser'");
                                            foreach($query_user as $uuser_row){
                                                echo $uuser_row['first_name'].' '.$uuser_row['last_name'];
                                            }
                                        ?>
                                    </td>
                                    <td><?= $ot_row['description']; ?></td>
                                    <td><?= $ot_row['action']; ?></td>
                                    <td><?= $ot_row['comment']; ?></td>
                                    <td><?= $ot_row['account']; ?></td>
                                    <td>
                                          <?= $ot_row['task_date']; ?>
                                    </td>
                                    <td><?= $ot_row['minute']; ?></td>
                                    
                                </tr>
                            <?php }
                        ?>
                        <tr style="border:none;">
                            <td style="border:none;"></td>
                            <td style="border:none;"></td>
                            <td style="border:none;"></td>
                            <td style="border:none;"></td>
                            <td style="border:none;"></td>
                            <td style="border:none;"></td>
                            <td style="border:none;">
                                <b>Total</b>
                            </td>
                            <td style="border:none;">
                                <?php
                                    $u_id = $row['user_id'];
                                    $t_id = $row['task_date'];
                                    $scope_count = mysqli_query($conn, "select sum(minute) as count from tbl_service_logs where not_approved = 0 and user_id = '$u_id' and task_date = '$t_id'");
                                    foreach($scope_count as $count){
                                        echo '<b>'.$count['count'].'</b>';
                                    }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
    <?php } 
}
?>
