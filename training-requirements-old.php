<?php 
    $title = "Training Requirements";
    $site = "training-requirements";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'HR';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style>
    table {
        border-collapse: separate;
        border-spacing: 0px !important;
    }

    table tr>* {
        border: 1px solid #eee !important;
    }

    thead td {
        min-width: 120px;
        vertical-align: middle !important;
        border-bottom: none !important;
    }

    tr>*:nth-child(1),
    tr>*:nth-child(2) {
        position: sticky;
    }
    tbody tr>*:nth-child(1),
    tbody tr>*:nth-child(2) {
        background-color: #fff !important;
    }

    tr>*:nth-child(1) {
        min-width: 180px;
        max-width: 180px;
        left: 0;
    }

    tr>*:nth-child(2) {
        min-width: 120px;
        max-width: 120px;
        left: 180px;
    }

    .training {
        padding: 1rem;
        color: white;
        text-align: center;
    }

    .legend {
        display: flex;
        gap: 1rem;
        align-items: start;
        margin: 0;
        padding: 0;
    }

    .training.completed {
        background-color: #26C281;
    }

    .training.added {
        background-color: #F4D03F;
    }

    .training.expired {
        background-color: #D91E18;
    }

    .training.not-applicable {
        background-color: #E1E5EC;
    }

    .btn-transparent {
        border: none !important;
        background: transparent !important;
    }
    .bg-default {
        position: sticky;
        top: 0;
        z-index: 2;
    }
    .bg-default tr>*:nth-child(1),
    .bg-default tr>*:nth-child(2) {
        background-color: #e1e5ec !important;
    }
</style>


                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-graduation font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Training Requirements</span>
                                        <?php
                                            if($current_client == 0) {
                                                // $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND (user_id = $switch_user_id OR user_id = $current_userEmployerID OR user_id = 163)");
                                                $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site'");
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $type_id = $row["type"];
                                                    $file_title = $row["file_title"];
                                                    $video_url = $row["youtube_link"];
                                                    
                                                    $file_upload = $row["file_upload"];
                                                    if (!empty($file_upload)) {
                                        	            $fileExtension = fileExtension($file_upload);
                                        				$src = $fileExtension['src'];
                                        				$embed = $fileExtension['embed'];
                                        				$type = $fileExtension['type'];
                                        				$file_extension = $fileExtension['file_extension'];
                                        	            $url = $base_url.'uploads/instruction/';
                                        
                                                		$file_url = $src.$url.rawurlencode($file_upload).$embed;
                                                    }
                                                    
                                                    $icon = $row["icon"];
                                                    if (!empty($icon)) { echo '<img src="'.$src.$url.rawurlencode($icon).'" style="width: 32px; height: 32px; object-fit: contain; object-position: center;" />'; }
                                                    if ($type_id == 0) {
                                                        echo ' - <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'">'.$file_title.'</a>';
                                                    } else {
                                                        echo ' - <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox>'.$file_title.'</a>';
                                                    }
	                                            }
                                                
                                                if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163) {
                                                    echo ' <a data-toggle="modal" data-target="#modalInstruction" class="btn btn-circle btn-success btn-xs" onclick="btnInstruction()">Add New Instruction</a>';
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    
                                    
                                        
                                    <?php
                                        if ($current_client == 1) {
                                            echo '<div class="table-responsive">
                                                <table class="table border-dark">
                                                    <thead>
                                                        <tr class="bg-default">
                                                            <th>Employee Name</th>
                                                            <th>Position</th>
                                                            <th>No. of Trainings Completed</th>
                                                            <th>No. of Trainings Not Completed</th>
                                                            <th>No. of Training Records Expired</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>';
                                                        $selectEmployee = mysqli_query( $conn,"SELECT
                                                            e.ID AS e_ID,
                                                            e.user_id AS e_user_id,
                                                            e.portal_user AS e_portal_user,
                                                            e.first_name AS e_first_name,
                                                            e.last_name AS e_last_name,
                                                            e.job_description_id AS e_job_description_id,
                                                            u.ID AS u_ID

                                                            FROM tbl_hr_employee AS e

                                                            INNER JOIN (
                                                                SELECT
                                                                *
                                                                FROM tbl_user
                                                                WHERE is_active = 1
                                                            ) AS u
                                                            ON e.ID = u.employee_id

                                                            WHERE e.suspended = 0
                                                            AND e.status = 1
                                                            AND e.user_id = $switch_user_id

                                                            ORDER BY e.last_name" );
                                                        if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                            while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                                $employee_ID = $rowEmployee['e_ID'];
                                                                $employee_user_ID = $rowEmployee['u_ID'];

                                                                $position = array();
                                                                $jd = $rowEmployee["e_job_description_id"];
                                                                if (!empty($jd)) {
                                                                    $jd_arr = explode(", ", $jd);
                                                                    foreach ($jd_arr as $value) {
                                                                        $resultJD = mysqli_query( $conn,"SELECT title FROM tbl_hr_job_description WHERE ID = $value" );
                                                                        if ( mysqli_num_rows($resultJD) > 0 ) {
                                                                            $rowJD = mysqli_fetch_array($resultJD);
                                                                            array_push($position, htmlentities($rowJD["title"] ?? ''));
                                                                        }
                                                                    }
                                                                }
                                                                $position = implode(', ', $position);

                                                                $resultTraining = mysqli_query( $conn,"SELECT
                                                                    SUM(CASE WHEN q_result = 100 AND FREQ_D > CURRENT_DATE() THEN 1 ELSE 0 END) AS C,
                                                                    SUM(CASE WHEN q_result = 100 AND FREQ_D < CURRENT_DATE() THEN 1 ELSE 0 END) AS E,
                                                                    SUM(CASE WHEN q_result !=  100 THEN 1 ELSE 0 END) AS NC
                                                                    FROM (
                                                                        SELECT
                                                                        t.ID AS t_ID,
                                                                        t.title AS t_title,
                                                                        t.job_description_id AS t_job_description_id,
                                                                        replace(t.quiz_id , ' ','') AS t_quiz_id,
                                                                        t.last_modified AS t_last_modified,
                                                                        t.frequency AS t_frequency,
                                                                        CASE 
                                                                            WHEN t.frequency = 0 THEN DATE_ADD(q.last_modified, INTERVAL 1 MONTH)
                                                                            WHEN t.frequency = 1 THEN DATE_ADD(q.last_modified, INTERVAL 3 MONTH)
                                                                            WHEN t.frequency = 2 THEN DATE_ADD(q.last_modified, INTERVAL 6 MONTH)
                                                                            WHEN t.frequency = 3 THEN DATE_ADD(q.last_modified, INTERVAL 1 YEAR)
                                                                        END AS FREQ_D,
                                                                        q.ID AS q_ID,
                                                                        q.quiz_id AS q_quiz_id,
                                                                        COALESCE(q.result, 0) AS q_result,
                                                                        q.last_modified AS q_last_modified
                                                                        FROM tbl_hr_trainings AS t
                                                                        
                                                                        LEFT JOIN (
                                                                            SELECT * 
                                                                            FROM tbl_hr_quiz_result 
                                                                            WHERE ID IN 
                                                                            ( 
                                                                            SELECT MAX(ID) 
                                                                            FROM tbl_hr_quiz_result
                                                                            WHERE user_id = $employee_user_ID
                                                                            GROUP BY quiz_id 
                                                                            )
                                                                        ) AS q
                                                                        ON FIND_IN_SET(q.quiz_id, t.quiz_id) > 0
                                                                        
                                                                        WHERE t.status = 1
                                                                        AND t.deleted = 0
                                                                        AND t.user_id = $switch_user_id
                                                                    ) AS r" );
                                                                if ( mysqli_num_rows($resultTraining) > 0 ) {
                                                                    $rowTraining = mysqli_fetch_array($resultTraining);
                                                                    $training_C = htmlentities($rowTraining['C'] ?? '');

                                                                    echo '<tr>
                                                                        <td>'.htmlentities($rowEmployee['e_last_name'] ?? '').', '.htmlentities($rowEmployee['e_first_name'] ?? '').'</td>
                                                                        <td>'.$position.'</td>
                                                                        <td><a href="#modalTraining" type="button" data-toggle="modal" onclick="btnTraining('.$employee_ID.', 1)">'.htmlentities($rowTraining['C'] ?? '').'</a></td>
                                                                        <td><a href="#modalTraining" type="button" data-toggle="modal" onclick="btnTraining('.$employee_ID.', 2)">'.htmlentities($rowTraining['NC'] ?? '').'</a></td>
                                                                        <td><a href="#modalTraining" type="button" data-toggle="modal" onclick="btnTraining('.$employee_ID.', 3)">'.htmlentities($rowTraining['E'] ?? '').'</a></td>
                                                                    </tr>';
                                                                }
                                                            }
                                                        }
                                                    echo '</tbody>
                                                </table>
                                            </div>';
                                        } else {
                                            echo '<div style="margin: 0 0 2rem 0;">
                                                <div style="margin-bottom: 1rem;">
                                                    <strong>Color Legend:</strong>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h5 class="legend">
                                                            <div class="training completed"></div>
                                                            Training Completed
                                                        </h5>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <h5 class="legend">
                                                            <div class="training added"></div>
                                                            Training Added w/ No Training Record
                                                        </h5>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <h5 class="legend">
                                                            <div class="training expired"></div>
                                                            Training Record Expired
                                                        </h5>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <h5 class="legend">
                                                            <div class="training not-applicable"></div>
                                                            No Training Record/Not Applicable
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive" style="max-height: calc(100vh - 425px);">
                                                <table class="table border-dark">
                                                    <thead class="bg-default">
                                                        <tr>
                                                            <th>Employee Name</th>
                                                            <th>Position</th>';
                                                            $result = mysqli_query( $conn,"SELECT ID, title FROM tbl_hr_trainings WHERE status = 1 AND deleted = 0 AND user_id = $switch_user_id" );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                $i=0;
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    echo '<td><a href="#modalViewTraining" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnViewTraining('.$row["ID"].')">'.htmlentities($row["title"] ?? '').'</a></td>';
                                                                }
                                                            }
                                                        echo '</tr>
                                                    </thead>
                                                    <tbody>';
                                                        $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE user_id = $switch_user_id AND suspended = 0 AND status = 1 ORDER BY last_name" );
                                                        if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                            while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                                $employee_ID = htmlentities($rowEmployee['ID'] ?? '');
                                                                $employee_first_name = htmlentities($rowEmployee['first_name'] ?? '');
                                                                $employee_last_name = htmlentities($rowEmployee['last_name'] ?? '');
                                                                $employee_type = htmlentities($rowEmployee['type_id'] ?? '');
                                                                $type_arr = array(
                                                                    1 => 'Full-time',
                                                                    2 => 'Part-time',
                                                                    3 => 'OJT',
                                                                    4 => 'Freelance',
                                                                    5 => 'OJT Crossover',
                                                                    6 => 'Trainee',
                                                                    7 => 'Consultant'
                                                                );
    
                                                                $position = array();
                                                                $jd = $rowEmployee["job_description_id"];
                                                                if (!empty($jd)) {
                                                                    $jd_arr = explode(", ", $jd);
                                                                    foreach ($jd_arr as $value) {
                                                                        $resultJD = mysqli_query( $conn,"SELECT title FROM tbl_hr_job_description WHERE ID = $value" );
                                                                        if ( mysqli_num_rows($resultJD) > 0 ) {
                                                                            $rowJD = mysqli_fetch_array($resultJD);
                                                                            array_push($position, htmlentities($rowJD["title"] ?? ''));
                                                                        }
                                                                    }
                                                                }
                                                                $position = implode(', ', $position);
    
                                                                echo '<tr id="tr_'.$employee_ID.'">
                                                                    <td><a href="#modalViewEmployee" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnViewEmployee('.$employee_ID.')">'.$employee_last_name.', '.$employee_first_name.'</a></td>
                                                                    <td>'.$position.'</td>';
    
                                                                    $result = mysqli_query( $conn,"SELECT * FROM tbl_hr_trainings WHERE status = 1 AND deleted = 0 AND user_id = $switch_user_id" );
                                                                    if ( mysqli_num_rows($result) > 0 ) {
                                                                        $i=0;
                                                                        while($row = mysqli_fetch_array($result)) {
    
                                                                            $found = null;
                                                                            $array_rowEmployee = explode(", ", $rowEmployee["job_description_id"]);
                                                                            $array_rowTraining = explode(", ", $row["job_description_id"]);
                                                                            foreach($array_rowEmployee as $emp_JD) {
                                                                                if (in_array($emp_JD,$array_rowTraining)) {
                                                                                    $found = true;
                                                                                }
                                                                            }
    
                                                                            if ( $found == true ) {
                                                                                $trainingResult = 0;
                                                                                $completed_date = '';
                                                                                $due_date = '';
    
                                                                                $selectUser = mysqli_query( $conn,"SELECT ID FROM tbl_user WHERE employee_id = $employee_ID" );
                                                                                if ( mysqli_num_rows($selectUser) > 0 ) {
                                                                                    $rowUser = mysqli_fetch_array($selectUser);
                                                                                    $employee_user_ID = $rowUser['ID'];
    
                                                                                    $selectQuizResult = mysqli_query( $conn,"SELECT ID, quiz_id, result, last_modified FROM tbl_hr_quiz_result WHERE user_id = $employee_user_ID " );
                                                                                    if ( mysqli_num_rows($selectQuizResult) > 0 ) {
                                                                                        while($rowQuizResult = mysqli_fetch_array($selectQuizResult)) {
                                                                                            $trainingResultID = $rowQuizResult['ID'];
                                                                                            $trainingQuizID = $rowQuizResult['quiz_id'];
    
                                                                                            if (!empty($row['quiz_id'])) {
                                                                                                $array_quiz_id = explode(', ', $row['quiz_id']);
                                                                                                if (in_array($trainingQuizID, $array_quiz_id)) {
                                                                                                    $trainingResult = $rowQuizResult['result'];
                                                                                    
                                                                                                    $completed_date = $rowQuizResult['last_modified'];
                                                                                                    $completed_date = new DateTime($completed_date);
                                                                                                    $completed_date_o = $completed_date->format('Y/m/d');
                                                                                                    $completed_date = $completed_date->format('M d, Y');
                                                                                                    
                                                                                                    $due_date = date('Y-m-d', strtotime('+1 year', strtotime($completed_date)) );
                                                                                                    $due_date = new DateTime($due_date);
                                                                                                    $due_date_o = $due_date->format('Y/m/d');
                                                                                                    $due_date = $due_date->format('M d, Y');
    
                                                                                                    $current_date = date('M d, Y');
                                                                                                    $current_date = 'Oct 27, 2022';
                                                                                                    $current_date = new DateTime($current_date);
                                                                                                    $current_date_o = $current_date->format('Y/m/d');
                                                                                                    $current_date = $current_date->format('M d, Y');
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                        if ($trainingResult == 100) {
                                                                                            if ($current_date_o >= $due_date_o) {
                                                                                                echo '<td class="training expired">'.$completed_date.'</td>';
                                                                                            } else {
                                                                                                echo '<td class="training completed"><a href="#modalView" type="button" class="btn btn-outline btn-transparent btn-sm sbold default" data-toggle="modal" onclick="btnView('.$employee_user_ID.', '.$row['ID'].')">'.$completed_date.'</a></td>';
                                                                                            }
                                                                                        } else {
                                                                                            echo '<td class="training added"></td>';
                                                                                        }
                                                                                    } else {
                                                                                        echo '<td class="training added"></td>';
                                                                                    }
                                                                                } else {
                                                                                    echo '<td class="training not-applicable"></td>';
                                                                                }
                                                                            } else {
                                                                                echo '<td></td>';
                                                                            }
                                                                        }
                                                                    }
    
                                                                echo '</tr>';
                                                            }
                                                        }
                                                    echo '</tbody>
                                                </table>
                                            </div>';
                                        }
                                    
                                    ?>
                                </div>
                            </div>
                            <!-- END BORDERED TABLE PORTLET-->
                        </div>

                        <!-- MODAL AREA-->
                        <div class="modal fade bs-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalView">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Training Requirements</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_HR_Trainings" id="btnUpdate_HR_Trainings" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-modal-lg" id="modalViewEmployee" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalViewEmployee">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Employee Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-modal-lg" id="modalViewTraining" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalViewTraining">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Training Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-modal-lg" id="modalTraining" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalTraining">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Training Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- / END MODAL AREA -->
                        
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
        
        <script type="text/javascript">
            function btnView(id, training) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_HR_Trainings_Progress="+id+'&t='+training,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                    }
                });
            }
            function btnViewEmployee(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_HR_Employee_TP="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewEmployee .modal-body").html(data);
                    }
                });
            }
            function btnViewTraining(id) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_HR_Trainings_TP="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewTraining .modal-body").html(data);
                    }
                });
            }
            function btnTraining(id, type) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_HR_Employee_TP2="+id+"&type="+type,
                    dataType: "html",
                    success: function(data){
                        $("#modalTraining .modal-body").html(data);
                    }
                });
            }
        </script>
    </body>
</html>
