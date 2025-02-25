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

if(isset($_GET['get_data'])){
    $id = $_GET['get_data'];
    ?>
    <div class="col-md-4 column sortable">
        <div class="portlet portlet-sortable box red-sunglo">
        <?php 
            $task_ns = mysqli_query($conn,"select * from tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id' and CIA_progress = 0 and CIA_progress = ''");
            foreach($task_ns as $row_ns){?>
                    <div class="portlet-title">
                        <div class="caption">
                            Not Started
                        </div>
                        <div class="actions">
                            <a href="javascript:;" class="btn btn-default btn-sm">
                                <i class="fa fa-pencil"></i> Edit </a>
                            <a class="btn btn-sm btn-icon-only btn-default fullscreen" href="javascript:;"></a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <h4><?= $row_ns['CAI_filename']; ?></h4>
                        <p> <?= $row_ns['CAI_description']; ?> </p>
                    </div>
           <?php }
        ?>
        </div>
        <!-- empty sortable porlet required for each columns! -->
        <div class="portlet portlet-sortable-empty"> </div>
    </div>
    <div class="col-md-4 column sortable">
        <div class="portlet portlet-sortable box blue-hoki">
            <?php 
                $task_ip = mysqli_query($conn,"select * from tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id' and CIA_progress = 1");
                foreach($task_ip as $row_ip){?>
                        <div class="portlet-title">
                            <div class="caption">
                                In-Progress
                            </div>
                            <div class="actions">
                                <a href="javascript:;" class="btn btn-default btn-sm">
                                    <i class="fa fa-pencil"></i> Edit </a>
                                <a class="btn btn-sm btn-icon-only btn-default fullscreen" href="javascript:;"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <h4><?= $row_ip['CAI_filename']; ?></h4>
                            <p> <?= $row_ip['CAI_description']; ?> </p>
                        </div>
               <?php }
            ?>
        </div>
        <!-- empty sortable porlet required for each columns! -->
        <div class="portlet portlet-sortable-empty"> </div>
    </div>
    <div class="col-md-4 column sortable"> 
        <div class="portlet portlet-sortable box green-haze">
            <?php 
                $task_c = mysqli_query($conn,"select * from tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id' and CIA_progress = 2");
                foreach($task_c as $row_c){?>
                        <div class="portlet-title">
                            <div class="caption">
                                Completed
                            </div>
                            <div class="actions">
                                <a href="javascript:;" class="btn btn-default btn-sm">
                                    <i class="fa fa-pencil"></i> Edit </a>
                                <a class="btn btn-sm btn-icon-only btn-default fullscreen" href="javascript:;"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <h4><?= $row_c['CAI_filename']; ?></h4>
                            <p><?= $row_c['CAI_description']; ?> </p>
                        </div> 
               <?php }
            ?>
        </div>
        <!-- empty sortable porlet required for each columns! -->
        <div class="portlet portlet-sortable-empty"> </div>  
    </div> 
    <div class="row">
        <div class="col-md-12">
            <div class="tabbable-line">
                <ul class="nav nav-tabs ">
                    <li class="active">
                        <a href="#tab_1" data-toggle="tab"> Comments </a>
                    </li>
                    <li>
                        <a href="#tab_2" data-toggle="tab"> History </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <!-- TASK COMMENTS -->
                        <div class="form-group">
                            <div class="col-md-12">
                                <ul class="media-list">
                                    <li class="media">
                                        <a class="pull-left" href="javascript:;">
                                            <img class="todo-userpic" src="assets/pages/media/users/avatar8.jpg" width="27px" height="27px"> </a>
                                        <div class="media-body todo-comment">
                                            <button type="button" class="todo-comment-btn btn btn-circle btn-default btn-sm">&nbsp; Reply &nbsp;</button>
                                            <p class="todo-comment-head">
                                                <span class="todo-comment-username">Christina Aguilera</span> &nbsp;
                                                <span class="todo-comment-date">17 Sep 2014 at 2:05pm</span>
                                            </p>
                                            <p class="todo-text-color"> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.
                                                </p>
                                            <!-- Nested media object -->
                                            <div class="media">
                                                <a class="pull-left" href="javascript:;">
                                                    <img class="todo-userpic" src="assets/pages/media/users/avatar4.jpg" width="27px" height="27px"> </a>
                                                <div class="media-body">
                                                    <p class="todo-comment-head">
                                                        <span class="todo-comment-username">Carles Puyol</span> &nbsp;
                                                        <span class="todo-comment-date">17 Sep 2014 at 4:30pm</span>
                                                    </p>
                                                    <p class="todo-text-color"> Thanks so much my dear! </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <a class="pull-left" href="javascript:;">
                                            <img class="todo-userpic" src="assets/pages/media/users/avatar5.jpg" width="27px" height="27px"> </a>
                                        <div class="media-body todo-comment">
                                            <button type="button" class="todo-comment-btn btn btn-circle btn-default btn-sm">&nbsp; Reply &nbsp;</button>
                                            <p class="todo-comment-head">
                                                <span class="todo-comment-username">Andres Iniesta</span> &nbsp;
                                                <span class="todo-comment-date">18 Sep 2014 at 9:22am</span>
                                            </p>
                                            <p class="todo-text-color"> Cras sit amet nibh libero, in gravida nulla. Scelerisque ante sollicitudin commodo Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum
                                                in vulputate at, tempus viverra turpis.
                                                <br> </p>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <a class="pull-left" href="javascript:;">
                                            <img class="todo-userpic" src="assets/pages/media/users/avatar6.jpg" width="27px" height="27px"> </a>
                                        <div class="media-body todo-comment">
                                            <button type="button" class="todo-comment-btn btn btn-circle btn-default btn-sm">&nbsp; Reply &nbsp;</button>
                                            <p class="todo-comment-head">
                                                <span class="todo-comment-username">Olivia Wilde</span> &nbsp;
                                                <span class="todo-comment-date">18 Sep 2014 at 11:50am</span>
                                            </p>
                                            <p class="todo-text-color"> Cras sit amet nibh libero, in gravida nulla. Scelerisque ante sollicitudin commodo Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum
                                                in vulputate at, tempus viverra turpis.
                                                <br> </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- END TASK COMMENTS -->
                        <!-- TASK COMMENT FORM -->
                        <div class="form-group">
                            <div class="col-md-12">
                                <ul class="media-list">
                                    <li class="media">
                                        <a class="pull-left" href="javascript:;">
                                            <img class="todo-userpic" src="assets/pages/media/users/avatar4.jpg" width="27px" height="27px"> </a>
                                        <div class="media-body">
                                            <textarea class="form-control todo-taskbody-taskdesc" rows="4" placeholder="Type comment..."></textarea>
                                        </div>
                                    </li>
                                </ul>
                                <button type="button" class="pull-right btn btn-sm btn-circle blue"> &nbsp; Submit &nbsp; </button>
                            </div>
                        </div>
                        <!-- END TASK COMMENT FORM -->
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <ul class="todo-task-history">
                            <li>
                                <div class="todo-task-history-date"> 20 Jun, 2014 at 11:35am </div>
                                <div class="todo-task-history-desc"> Task created </div>
                            </li>
                            <li>
                                <div class="todo-task-history-date"> 21 Jun, 2014 at 10:35pm </div>
                                <div class="todo-task-history-desc"> Task category status changed to "Top Priority" </div>
                            </li>
                            <li>
                                <div class="todo-task-history-date"> 22 Jun, 2014 at 11:35am </div>
                                <div class="todo-task-history-desc"> Task owner changed to "Nick Larson" </div>
                            </li>
                            <li>
                                <div class="todo-task-history-date"> 30 Jun, 2014 at 8:09am </div>
                                <div class="todo-task-history-desc"> Task completed by "Nick Larson" </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php    
}
?>
