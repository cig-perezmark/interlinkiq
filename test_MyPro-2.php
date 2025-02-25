<?php 
    $title = "My Pro";
    $site = "MyPro";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style>
    .parentTbls{
     	padding: 0px 10px;
    }
    .childTbls td {
        border:solid grey 1px;
     	padding: 0px 10px;
    }
    .child-1{
        background-color:#3D8361;
        color:#fff;
        border:solid grey 1px;
        padding: 0px 10px;
    }
    .font-14{
        font-size:14px;
    }
    .paddId{
        padding: 0px 10px;
    }
    #loading {
		text-align:center; 
		background: url('loader.gif') no-repeat center; 
		height: 150px;
    }
   .fc-event .fc-time{
        display:none !important;
        color:transparent;
    }
</style>


					<div class="row">
					    <div class="col-md-12">
					        <div class="portlet light ">
					            <div class="portlet-title tabbable-line">
					                <div class="caption">
					                    <i class="icon-earphones-alt font-dark"></i>
					                    <span class="caption-subject font-dark bold uppercase">My Pro</span>
					                    <?php if($_COOKIE['ID'] == 34 OR $_COOKIE['ID'] == 387 OR $_COOKIE['ID'] == 32 OR $_COOKIE['ID'] == 54 OR $_COOKIE['ID'] == 38): ?>
					                        <a class="btn btn-primary btn-xs" data-toggle="modal" href="#addNew_payroll_periods">Add Event</a>
					                    <?php endif; ?>
					                </div>
					                <ul class="nav nav-tabs">
					                    <li class="active">
					                        <a href="#tab_Dashboard2" data-toggle="tab">Dashboard</a>
					                    </li>
					                     <li>
					                        <a href="#tab_Calendar" data-toggle="tab">Calendar</a>
					                    </li>
					                    <li>
					                        <a href="#tab_Dashboard" data-toggle="tab">Project</a>
					                    </li>
					                    <li class="hide">
					                        <a href="#tab_Me" data-toggle="tab">My Task</a>
					                    </li>
					                    <li class="hide">
					                        <a href="#tab_Collaborator_Task" data-toggle="tab">Collaborator Task</a>
					                    </li>
					                    <?php
					                        if ($current_userEmployeeID > 0) {
                            					$selectAccess = mysqli_query( $conn,"SELECT * FROM tbl_access WHERE page = 1 AND FIND_IN_SET($current_userEmployeeID, REPLACE(collab, ' ',''))" );
                            					if ( mysqli_num_rows($selectAccess) > 0 ) {
                            						echo '<li>
            					                        <a href="#tab_Archive" data-toggle="tab">
            					                            Archived
            					                            <i class="fa fa-users" data-toggle="modal" href="#modalAccess" style="color: #ed6b75 !important;" onclick="btnModalAccess(1)"></i>
            					                        </a>
            					                    </li>';
                            					}
					                        } else {
                        						echo '<li>
        					                        <a href="#tab_Archive" data-toggle="tab">
        					                            Archived
        					                            <i class="fa fa-users" data-toggle="modal" href="#modalAccess" style="color: #ed6b75 !important;" onclick="btnModalAccess(1)"></i>
        					                        </a>
        					                    </li>';
					                        }
					                    ?>
					                </ul>
					            </div>
					            <div class="portlet-body">
					                <div class="tab-content">
					                    <div class="tab-pane active" id="tab_Dashboard2">
							                <ul class="nav nav-tabs">
							                    <li class="active">
							                        <a href="#tab_Upcoming" data-toggle="tab">My Task</a>
							                    </li>
        					                    <?php
        					                        if ($current_userEmployeeID > 0) {
                                    					$selectAccess = mysqli_query( $conn,"SELECT * FROM tbl_access WHERE page = 1 AND FIND_IN_SET($current_userEmployeeID, REPLACE(collab, ' ',''))" );
                                    					if ( mysqli_num_rows($selectAccess) > 0 ) {
                                    						echo '<li>
            							                        <a href="#tab_Summary" data-toggle="tab">
            							                            Summary Report
            					                                    <i class="fa fa-users" data-toggle="modal" href="#modalAccess" style="color: #ed6b75 !important;" onclick="btnModalAccess(2)"></i>
            							                        </a>
            							                    </li>';
                                    					}
        					                        } else {
                                						echo '<li>
        							                        <a href="#tab_Summary" data-toggle="tab">
        							                            Summary Report
        					                                    <i class="fa fa-users" data-toggle="modal" href="#modalAccess" style="color: #ed6b75 !important;" onclick="btnModalAccess(2)"></i>
        							                        </a>
        							                    </li>';
        					                        }
        					                    ?>
							                </ul>
							                <div class="tab-content">
							                    <div class="tab-pane active" id="tab_Upcoming">
							                    	<?php

														$countPending = 0;
														$countDue = 0;
														$countCompleted = 0;
														$countTotal = 0;
					                    				if (!empty($_COOKIE['switchAccount']) OR $current_userAdminAccess == 1) {
						                    				$result = mysqli_query($conn, "SELECT
																SUM(CASE WHEN o.task_status = 2 THEN 1 ELSE 0 END) AS countCompleted,
																SUM(CASE WHEN o.task_status != 2 THEN 1 ELSE 0 END) AS countPending,
																SUM(CASE WHEN o.task_status != 2 AND DATE(o.task_due) < CURDATE() THEN 1 ELSE 0 END) AS countDue,
																COUNT(o.task_ID) AS countTotal

																FROM (
																	SELECT
																	m.MyPro_id AS m_ID,
																	m.Project_Name AS m_name,
																	m.Project_Description AS m_description,
																	m.Start_Date AS m_start,
																	m.Desired_Deliver_Date AS m_due,
																	h_ID,
																	h_MP_ID,
																	h_name,
																	h_description,
																	h_start,
																	h_due,
																	h_status,
																	c_ID,
																	c_name,
																	c_description,
																	c_start,
																	c_due,
																	c_status,

																	CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
																	CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
																	CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
																	CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
																	CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
																	CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

																	FROM (
																		SELECT
																		h.History_id AS h_ID,
																		h.MyPro_PK AS h_MP_ID,
																		h.filename AS h_name,
																		h.description AS h_description,
																		h.history_added AS h_start,
																		h.Action_date AS h_due,
																		h.tmsh_column_status AS h_status,
																		c.CAI_id AS c_ID,
																		c.CAI_filename AS c_name,
																		c.CAI_description AS c_description,
																		c.CAI_Action_date AS c_start,
																		c.CAI_Action_due_date AS c_due,
																		c.CIA_progress AS c_status
																		
																		FROM tbl_MyProject_Services_History AS h

																		LEFT JOIN (
																			SELECT
																		    *
																		    FROM tbl_MyProject_Services_Childs_action_Items
																		    WHERE is_deleted = 0
																		) AS c
																		ON h.History_id = c.Services_History_PK

																		WHERE h.is_deleted = 0
																	) r

																	RIGHT JOIN (
																	 	SELECT
																	    *
																	    FROM tbl_MyProject_Services
																	    WHERE is_deleted = 0
																	    AND switch_id = $switch_user_id
																	) as m
																	ON m.MyPro_id = r.h_MP_ID

																	WHERE LENGTH(r.h_ID) > 0
																) o
															");
						                    			} else {
						                    				$result = mysqli_query($conn, "SELECT
																SUM(CASE WHEN o.task_status = 2 THEN 1 ELSE 0 END) AS countCompleted,
																SUM(CASE WHEN o.task_status != 2 THEN 1 ELSE 0 END) AS countPending,
																SUM(CASE WHEN o.task_status != 2 AND DATE(o.task_due) < CURDATE() THEN 1 ELSE 0 END) AS countDue,
																COUNT(o.task_ID) AS countTotal
																
																FROM (
																	SELECT
																	m.MyPro_id AS m_ID,
																	m.Project_Name AS m_name,
																	m.Project_Description AS m_description,
																	m.Start_Date AS m_start,
																	m.Desired_Deliver_Date AS m_due,
																	h_ID,
																	h_MP_ID,
																	h_name,
																	h_description,
																	h_start,
																	h_due,
																	h_status,
																	c_ID,
																	c_name,
																	c_description,
																	c_start,
																	c_due,
																	c_status,

																	CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
																	CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
																	CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
																	CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
																	CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
																	CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

																	FROM (
																		SELECT
																		h.History_id AS h_ID,
																		h.MyPro_PK AS h_MP_ID,
																		h.filename AS h_name,
																		h.description AS h_description,
																		h.history_added AS h_start,
																		h.Action_date AS h_due,
																		h.tmsh_column_status AS h_status,
																		c.CAI_id AS c_ID,
																		c.CAI_filename AS c_name,
																		c.CAI_description AS c_description,
																		c.CAI_Action_date AS c_start,
																		c.CAI_Action_due_date AS c_due,
																		c.CIA_progress AS c_status
																		
																		FROM tbl_MyProject_Services_History AS h

																		LEFT JOIN (
																			SELECT
																		    *
																		    FROM tbl_MyProject_Services_Childs_action_Items
																		    WHERE is_deleted = 0
																		) AS c
																		ON h.History_id = c.Services_History_PK

																		WHERE h.is_deleted = 0
																	) r

																	RIGHT JOIN (
																	 	SELECT
																	    *
																	    FROM tbl_MyProject_Services
																	    WHERE is_deleted = 0
																	    AND switch_id = $switch_user_id
																	) as m
																	ON m.MyPro_id = r.h_MP_ID

																	WHERE LENGTH(r.h_ID) > 0
																	AND (m.user_cookies = $current_userID OR FIND_IN_SET($current_userEmployeeID, REPLACE(m.Collaborator_PK, ' ', '')) > 0)
																) o
															");
						                    			}
					                                	while($row = mysqli_fetch_array($result)) {
															$countCompleted = $row['countCompleted'];
															$countPending = $row['countPending'];
															$countDue = $row['countDue'];
															$countTotal = $row['countTotal'];
					                                	}
							                    		echo '<h4 class="text-center">
							                    			'.date("l").' - '.date("M d, Y").'<br>
							                    			<b>Good day, '.$current_userFName.'.</b>
							                    		</h4>
							                    		<div class="row margin-bottom-20">
							                    			<div class="col-md-6 col-md-offset-3">
				                                                <div class="input-group">
				                                                    <span class="input-group-addon bg-white input-circle-left">
				                                                        <select class="form-control" style="border: 0;" onchange="selectOption(this.value)">
					                                                        <option value="#tab_All">All</option>
					                                                        <option value="#tab_Daily">Daily</option>
					                                                        <option value="#tab_Weekly">Weekly</option>
					                                                        <option value="#tab_Monthly">Monthly</option>
					                                                        <option value="#tab_Overdue">Overdue</option>
					                                                        <option value="#tab_Completed">Completed</option>
					                                                    </select>
				                                                    </span>
				                                                    <span class="input-group-addon bg-white" style="border: 1px solid #ccc;">'.$countCompleted.' - Task Completed</span>
				                                                    <span class="input-group-addon bg-white input-circle-right">'.$countTotal.' - Task Total</span>
				                                                </div>
							                    			</div>
							                    		</div>';
							                    	?>

						                    		<div class="row">
						                    			<div class="col-md-6">
											                <ul class="nav nav-tabs hide">
											                    <li class="active">
											                        <a href="#tab_All" data-toggle="tab">tab_All</a>
											                    </li>
											                    <li>
											                        <a href="#tab_Daily" data-toggle="tab">tab_Daily</a>
											                    </li>
											                    <li>
											                        <a href="#tab_Weekly" data-toggle="tab">tab_Weekly</a>
											                    </li>
											                    <li>
											                        <a href="#tab_Monthly" data-toggle="tab">tab_Monthly</a>
											                    </li>
											                    <li>
											                        <a href="#tab_Overdue" data-toggle="tab">tab_Overdue</a>
											                    </li>
											                    <li>
											                        <a href="#tab_Completed" data-toggle="tab">tab_Completed</a>
											                    </li>
											                </ul>
						                    				<div class="tab-content">
											                    <div class="tab-pane active" id="tab_All">
											                    	<table class="table table-striped table-bordered table-hover" id="tableData_All">
											                    		<thead>
											                    			<tr>
											                    				<th>Task Name</th>
											                    				<th>Project Name</th>
											                    				<th>Start Date</th>
											                    				<th>Due Date</th>
											                    			</tr>
											                    		</thead>
											                    		<tbody>
											                    			<?php
											                    				if (!empty($_COOKIE['switchAccount']) OR $current_userAdminAccess == 1) {
												                    				$result = mysqli_query($conn, "SELECT
																						*
																						FROM (
																							SELECT
																							m.MyPro_id AS m_ID,
																							m.Project_Name AS m_name,
																							m.Project_Description AS m_description,
																							m.Start_Date AS m_start,
																							m.Desired_Deliver_Date AS m_due,
																							h_ID,
																							h_MP_ID,
																							h_name,
																							h_description,
																							h_start,
																							h_due,
																							h_status,
																							c_ID,
																							c_name,
																							c_description,
																							c_start,
																							c_due,
																							c_status,

																							CASE WHEN c_ID IS NULL THEN 0 ELSE 1 END AS task_path,
																							CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
																							CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
																							CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
																							CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
																							CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
																							CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

																							FROM (
																								SELECT
																								h.History_id AS h_ID,
																								h.MyPro_PK AS h_MP_ID,
																								h.filename AS h_name,
																								h.description AS h_description,
																								h.history_added AS h_start,
																								h.Action_date AS h_due,
				        																		h.tmsh_column_status AS h_status,
																								c.CAI_id AS c_ID,
																								c.CAI_filename AS c_name,
																								c.CAI_description AS c_description,
																								c.CAI_Action_date AS c_start,
																								c.CAI_Action_due_date AS c_due,
																								c.CIA_progress AS c_status
																								
																								FROM tbl_MyProject_Services_History AS h

																								LEFT JOIN (
																									SELECT
																								    *
																								    FROM tbl_MyProject_Services_Childs_action_Items
																								    WHERE is_deleted = 0
																								) AS c
																								ON h.History_id = c.Services_History_PK

																								WHERE h.is_deleted = 0
																							) r

																							RIGHT JOIN (
																							 	SELECT
																							    *
																							    FROM tbl_MyProject_Services
																							    WHERE is_deleted = 0
																							    AND switch_id = $switch_user_id
																							) as m
																							ON m.MyPro_id = r.h_MP_ID

																							WHERE LENGTH(r.h_ID) > 0
																						) o
																						WHERE o.task_status != 2
																					");
												                    			} else {
												                    				$result = mysqli_query($conn, "SELECT
																						*
																						FROM (
																							SELECT
																							m.MyPro_id AS m_ID,
																							m.Project_Name AS m_name,
																							m.Project_Description AS m_description,
																							m.Start_Date AS m_start,
																							m.Desired_Deliver_Date AS m_due,
																							h_ID,
																							h_MP_ID,
																							h_name,
																							h_description,
																							h_start,
																							h_due,
																							h_status,
																							c_ID,
																							c_name,
																							c_description,
																							c_start,
																							c_due,
																							c_status,

																							CASE WHEN c_ID IS NULL THEN 0 ELSE 1 END AS task_path,
																							CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
																							CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
																							CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
																							CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
																							CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
																							CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

																							FROM (
																								SELECT
																								h.History_id AS h_ID,
																								h.MyPro_PK AS h_MP_ID,
																								h.filename AS h_name,
																								h.description AS h_description,
																								h.history_added AS h_start,
																								h.Action_date AS h_due,
				        																		h.tmsh_column_status AS h_status,
																								c.CAI_id AS c_ID,
																								c.CAI_filename AS c_name,
																								c.CAI_description AS c_description,
																								c.CAI_Action_date AS c_start,
																								c.CAI_Action_due_date AS c_due,
																								c.CIA_progress AS c_status

																								FROM tbl_MyProject_Services_History AS h

																								LEFT JOIN (
																									SELECT
																								    *
																								    FROM tbl_MyProject_Services_Childs_action_Items
																								    WHERE is_deleted = 0
																								) AS c
																								ON h.History_id = c.Services_History_PK

																								WHERE h.is_deleted = 0
																							) r

																							RIGHT JOIN (
																							 	SELECT
																							    *
																							    FROM tbl_MyProject_Services
																							    WHERE is_deleted = 0
																							    AND switch_id = $switch_user_id
																							) as m
																							ON m.MyPro_id = r.h_MP_ID

																							WHERE LENGTH(r.h_ID) > 0
																							AND (m.user_cookies = $current_userID OR FIND_IN_SET($current_userEmployeeID, REPLACE(m.Collaborator_PK, ' ', '')) > 0)
																						) o
																						WHERE o.task_status != 2
																					");
												                    			}
											                                	while($row = mysqli_fetch_array($result)) {
																					$task_start = $row['task_start'];
																					$task_start = new DateTime($task_start);
																					$task_start = $task_start->format('M d, Y');
											                                		
																					$task_due = $row['task_due'];
																					$task_due = new DateTime($task_due);
																					$task_due = $task_due->format('M d, Y');

											                                		echo '<tr id="tr_'.$row['task_path'].'_'.$row['task_ID'].'">
													                    				<td>
													                    					<a href="javascript:;" class="btn btn-xs btn-success" onclick="btnComplete_Project('.$row['task_ID'].', '.$row['task_path'].', this)" title="Complete"><i class="fa fa-check"></i></a>
													                    					<b><a href="test_task_mypro.php?view_id='.$row['m_ID'].'">'.$row['task_name'].'</a></b><br>
													                    					<i>'.$row['task_description'].'</i>
													                    				</td>
													                    				<td>'.$row['m_name'].'</td>
													                    				<td href="#modalDateSelect" data-toggle="modal" onClick="btnDateSelect('.$row['task_ID'].', '.$row['task_path'].', 0)">'.$task_start.'</td>
													                    				<td href="#modalDateSelect" data-toggle="modal"  onClick="btnDateSelect('.$row['task_ID'].', '.$row['task_path'].', 1)">'.$task_due.'</td>
													                    			</tr>';
											                                	}
											                    			?>
											                    		</tbody>
											                    	</table>
											                    </div>
											                    <div class="tab-pane" id="tab_Daily">
											                    	<table class="table table-striped table-bordered table-hover" id="tableData_Daily">
											                    		<thead>
											                    			<tr>
											                    				<th>Task Name</th>
											                    				<th>Project Name</th>
											                    				<th>Start Date</th>
											                    				<th>Due Date</th>
											                    			</tr>
											                    		</thead>
											                    		<tbody>
											                    			<?php
											                    				if (!empty($_COOKIE['switchAccount']) OR $current_userAdminAccess == 1) {
												                    				$result = mysqli_query($conn, "SELECT
																						*
																						FROM (
																							SELECT
																							m.MyPro_id AS m_ID,
																							m.Project_Name AS m_name,
																							m.Project_Description AS m_description,
																							m.Start_Date AS m_start,
																							m.Desired_Deliver_Date AS m_due,
																							h_ID,
																							h_MP_ID,
																							h_name,
																							h_description,
																							h_start,
																							h_due,
																							h_status,
																							c_ID,
																							c_name,
																							c_description,
																							c_start,
																							c_due,
																							c_status,

																							CASE WHEN c_ID IS NULL THEN 0 ELSE 1 END AS task_path,
																							CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
																							CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
																							CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
																							CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
																							CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
																							CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

																							FROM (
																								SELECT
																								h.History_id AS h_ID,
																								h.MyPro_PK AS h_MP_ID,
																								h.filename AS h_name,
																								h.description AS h_description,
																								h.history_added AS h_start,
																								h.Action_date AS h_due,
				        																		h.tmsh_column_status AS h_status,
																								c.CAI_id AS c_ID,
																								c.CAI_filename AS c_name,
																								c.CAI_description AS c_description,
																								c.CAI_Action_date AS c_start,
																								c.CAI_Action_due_date AS c_due,
																								c.CIA_progress AS c_status
																								
																								FROM tbl_MyProject_Services_History AS h

																								LEFT JOIN (
																									SELECT
																								    *
																								    FROM tbl_MyProject_Services_Childs_action_Items
																								    WHERE is_deleted = 0
																								) AS c
																								ON h.History_id = c.Services_History_PK

																								WHERE h.is_deleted = 0
																							) r

																							RIGHT JOIN (
																							 	SELECT
																							    *
																							    FROM tbl_MyProject_Services
																							    WHERE is_deleted = 0
																							    AND switch_id = $switch_user_id
																							) as m
																							ON m.MyPro_id = r.h_MP_ID

																							WHERE LENGTH(r.h_ID) > 0
																						) o
																						WHERE DATE(o.task_due) = CURDATE()
																						AND o.task_status != 2
																					");
												                    			} else {
												                    				$result = mysqli_query($conn, "SELECT
																						*
																						FROM (
																							SELECT
																							m.MyPro_id AS m_ID,
																							m.Project_Name AS m_name,
																							m.Project_Description AS m_description,
																							m.Start_Date AS m_start,
																							m.Desired_Deliver_Date AS m_due,
																							h_ID,
																							h_MP_ID,
																							h_name,
																							h_description,
																							h_start,
																							h_due,
																							h_status,
																							c_ID,
																							c_name,
																							c_description,
																							c_start,
																							c_due,
																							c_status,

																							CASE WHEN c_ID IS NULL THEN 0 ELSE 1 END AS task_path,
																							CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
																							CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
																							CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
																							CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
																							CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
																							CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

																							FROM (
																								SELECT
																								h.History_id AS h_ID,
																								h.MyPro_PK AS h_MP_ID,
																								h.filename AS h_name,
																								h.description AS h_description,
																								h.history_added AS h_start,
																								h.Action_date AS h_due,
				        																		h.tmsh_column_status AS h_status,
																								c.CAI_id AS c_ID,
																								c.CAI_filename AS c_name,
																								c.CAI_description AS c_description,
																								c.CAI_Action_date AS c_start,
																								c.CAI_Action_due_date AS c_due,
																								c.CIA_progress AS c_status

																								FROM tbl_MyProject_Services_History AS h

																								LEFT JOIN (
																									SELECT
																								    *
																								    FROM tbl_MyProject_Services_Childs_action_Items
																								    WHERE is_deleted = 0
																								) AS c
																								ON h.History_id = c.Services_History_PK

																								WHERE h.is_deleted = 0
																							) r

																							RIGHT JOIN (
																							 	SELECT
																							    *
																							    FROM tbl_MyProject_Services
																							    WHERE is_deleted = 0
																							    AND switch_id = $switch_user_id
																							) as m
																							ON m.MyPro_id = r.h_MP_ID

																							WHERE LENGTH(r.h_ID) > 0
																							AND (m.user_cookies = $current_userID OR FIND_IN_SET($current_userEmployeeID, REPLACE(m.Collaborator_PK, ' ', '')) > 0)
																						) o
																						WHERE DATE(o.task_due) = CURDATE()
																						AND o.task_status != 2
																					");
												                    			}
											                                	while($row = mysqli_fetch_array($result)) {
																					$task_start = $row['task_start'];
																					$task_start = new DateTime($task_start);
																					$task_start = $task_start->format('M d, Y');
											                                		
																					$task_due = $row['task_due'];
																					$task_due = new DateTime($task_due);
																					$task_due = $task_due->format('M d, Y');

											                                		echo '<tr id="tr_'.$row['task_path'].'_'.$row['task_ID'].'">
													                    				<td>
													                    					<a href="javascript:;" class="btn btn-xs btn-success" onclick="btnComplete_Project('.$row['task_ID'].', '.$row['task_path'].', this)" title="Complete"><i class="fa fa-check"></i></a>
													                    					<b><a href="test_task_mypro.php?view_id='.$row['m_ID'].'">'.$row['task_name'].'</a></b><br>
													                    					<i>'.$row['task_description'].'</i>
													                    				</td>
													                    				<td>'.$row['m_name'].'</td>
													                    				<td href="#modalDateSelect" data-toggle="modal" onClick="btnDateSelect('.$row['task_ID'].', '.$row['task_path'].', 0)">'.$task_start.'</td>
													                    				<td href="#modalDateSelect" data-toggle="modal"  onClick="btnDateSelect('.$row['task_ID'].', '.$row['task_path'].', 1)">'.$task_due.'</td>
													                    			</tr>';
											                                	}
											                    			?>
											                    		</tbody>
											                    	</table>
											                    </div>
											                    <div class="tab-pane" id="tab_Weekly">
											                    	<table class="table table-striped table-bordered table-hover" id="tableData_Weekly">
											                    		<thead>
											                    			<tr>
											                    				<th>Task Name</th>
											                    				<th>Project Name</th>
											                    				<th>Start Date</th>
											                    				<th>Due Date</th>
											                    			</tr>
											                    		</thead>
											                    		<tbody>
											                    			<?php
											                    				if (!empty($_COOKIE['switchAccount']) OR $current_userAdminAccess == 1) {
												                    				$result = mysqli_query($conn, "SELECT
																						*
																						FROM (
																							SELECT
																							m.MyPro_id AS m_ID,
																							m.Project_Name AS m_name,
																							m.Project_Description AS m_description,
																							m.Start_Date AS m_start,
																							m.Desired_Deliver_Date AS m_due,
																							h_ID,
																							h_MP_ID,
																							h_name,
																							h_description,
																							h_start,
																							h_due,
																							h_status,
																							c_ID,
																							c_name,
																							c_description,
																							c_start,
																							c_due,
																							c_status,

																							CASE WHEN c_ID IS NULL THEN 0 ELSE 1 END AS task_path,
																							CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
																							CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
																							CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
																							CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
																							CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
																							CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

																							FROM (
																								SELECT
																								h.History_id AS h_ID,
																								h.MyPro_PK AS h_MP_ID,
																								h.filename AS h_name,
																								h.description AS h_description,
																								h.history_added AS h_start,
																								h.Action_date AS h_due,
				        																		h.tmsh_column_status AS h_status,
																								c.CAI_id AS c_ID,
																								c.CAI_filename AS c_name,
																								c.CAI_description AS c_description,
																								c.CAI_Action_date AS c_start,
																								c.CAI_Action_due_date AS c_due,
																								c.CIA_progress AS c_status
																								
																								FROM tbl_MyProject_Services_History AS h

																								LEFT JOIN (
																									SELECT
																								    *
																								    FROM tbl_MyProject_Services_Childs_action_Items
																								    WHERE is_deleted = 0
																								) AS c
																								ON h.History_id = c.Services_History_PK

																								WHERE h.is_deleted = 0
																							) r

																							RIGHT JOIN (
																							 	SELECT
																							    *
																							    FROM tbl_MyProject_Services
																							    WHERE is_deleted = 0
																							    AND switch_id = $switch_user_id
																							) as m
																							ON m.MyPro_id = r.h_MP_ID

																							WHERE LENGTH(r.h_ID) > 0
																						) o
																						WHERE WEEK(o.task_due) = WEEK(NOW())
																						AND o.task_status != 2
																					");
												                    			} else {
												                    				$result = mysqli_query($conn, "SELECT
																						*
																						FROM (
																							SELECT
																							m.MyPro_id AS m_ID,
																							m.Project_Name AS m_name,
																							m.Project_Description AS m_description,
																							m.Start_Date AS m_start,
																							m.Desired_Deliver_Date AS m_due,
																							h_ID,
																							h_MP_ID,
																							h_name,
																							h_description,
																							h_start,
																							h_due,
																							h_status,
																							c_ID,
																							c_name,
																							c_description,
																							c_start,
																							c_due,
																							c_status,

																							CASE WHEN c_ID IS NULL THEN 0 ELSE 1 END AS task_path,
																							CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
																							CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
																							CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
																							CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
																							CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
																							CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

																							FROM (
																								SELECT
																								h.History_id AS h_ID,
																								h.MyPro_PK AS h_MP_ID,
																								h.filename AS h_name,
																								h.description AS h_description,
																								h.history_added AS h_start,
																								h.Action_date AS h_due,
				        																		h.tmsh_column_status AS h_status,
																								c.CAI_id AS c_ID,
																								c.CAI_filename AS c_name,
																								c.CAI_description AS c_description,
																								c.CAI_Action_date AS c_start,
																								c.CAI_Action_due_date AS c_due,
																								c.CIA_progress AS c_status
																								
																								FROM tbl_MyProject_Services_History AS h

																								LEFT JOIN (
																									SELECT
																								    *
																								    FROM tbl_MyProject_Services_Childs_action_Items
																								    WHERE is_deleted = 0
																								) AS c
																								ON h.History_id = c.Services_History_PK

																								WHERE h.is_deleted = 0
																							) r

																							RIGHT JOIN (
																							 	SELECT
																							    *
																							    FROM tbl_MyProject_Services
																							    WHERE is_deleted = 0
																							    AND switch_id = $switch_user_id
																							) as m
																							ON m.MyPro_id = r.h_MP_ID

																							WHERE LENGTH(r.h_ID) > 0
																							AND (m.user_cookies = $current_userID OR FIND_IN_SET($current_userEmployeeID, REPLACE(m.Collaborator_PK, ' ', '')) > 0)
																						) o
																						WHERE WEEK(o.task_due) = WEEK(NOW())
																						AND o.task_status != 2
																					");
												                    			}
											                                	while($row = mysqli_fetch_array($result)) {
																					$task_start = $row['task_start'];
																					$task_start = new DateTime($task_start);
																					$task_start = $task_start->format('M d, Y');
											                                		
																					$task_due = $row['task_due'];
																					$task_due = new DateTime($task_due);
																					$task_due = $task_due->format('M d, Y');

											                                		echo '<tr id="tr_'.$row['task_path'].'_'.$row['task_ID'].'">
													                    				<td>
													                    					<a href="javascript:;" class="btn btn-xs btn-success" onclick="btnComplete_Project('.$row['task_ID'].', '.$row['task_path'].', this)" title="Complete"><i class="fa fa-check"></i></a>
													                    					<b><a href="test_task_mypro.php?view_id='.$row['m_ID'].'">'.$row['task_name'].'</a></b><br>
													                    					<i>'.$row['task_description'].'</i>
													                    				</td>
													                    				<td>'.$row['m_name'].'</td>
													                    				<td href="#modalDateSelect" data-toggle="modal" onClick="btnDateSelect('.$row['task_ID'].', '.$row['task_path'].', 0)">'.$task_start.'</td>
													                    				<td href="#modalDateSelect" data-toggle="modal"  onClick="btnDateSelect('.$row['task_ID'].', '.$row['task_path'].', 1)">'.$task_due.'</td>
													                    			</tr>';
											                                	}
											                    			?>
											                    		</tbody>
											                    	</table>
											                    </div>
											                    <div class="tab-pane" id="tab_Monthly">
											                    	<table class="table table-striped table-bordered table-hover" id="tableData_Monthly">
											                    		<thead>
											                    			<tr>
											                    				<th>Task Name</th>
											                    				<th>Project Name</th>
											                    				<th>Start Date</th>
											                    				<th>Due Date</th>
											                    			</tr>
											                    		</thead>
											                    		<tbody>
											                    			<?php
											                    				if (!empty($_COOKIE['switchAccount']) OR $current_userAdminAccess == 1) {
												                    				$result = mysqli_query($conn, "SELECT
																						*
																						FROM (
																							SELECT
																							m.MyPro_id AS m_ID,
																							m.Project_Name AS m_name,
																							m.Project_Description AS m_description,
																							m.Start_Date AS m_start,
																							m.Desired_Deliver_Date AS m_due,
																							h_ID,
																							h_MP_ID,
																							h_name,
																							h_description,
																							h_start,
																							h_due,
																							h_status,
																							c_ID,
																							c_name,
																							c_description,
																							c_start,
																							c_due,
																							c_status,

																							CASE WHEN c_ID IS NULL THEN 0 ELSE 1 END AS task_path,
																							CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
																							CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
																							CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
																							CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
																							CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
																							CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

																							FROM (
																								SELECT
																								h.History_id AS h_ID,
																								h.MyPro_PK AS h_MP_ID,
																								h.filename AS h_name,
																								h.description AS h_description,
																								h.history_added AS h_start,
																								h.Action_date AS h_due,
				        																		h.tmsh_column_status AS h_status,
																								c.CAI_id AS c_ID,
																								c.CAI_filename AS c_name,
																								c.CAI_description AS c_description,
																								c.CAI_Action_date AS c_start,
																								c.CAI_Action_due_date AS c_due,
																								c.CIA_progress AS c_status
																								
																								FROM tbl_MyProject_Services_History AS h

																								LEFT JOIN (
																									SELECT
																								    *
																								    FROM tbl_MyProject_Services_Childs_action_Items
																								    WHERE is_deleted = 0
																								) AS c
																								ON h.History_id = c.Services_History_PK

																								WHERE h.is_deleted = 0
																							) r

																							RIGHT JOIN (
																							 	SELECT
																							    *
																							    FROM tbl_MyProject_Services
																							    WHERE is_deleted = 0
																							    AND switch_id = $switch_user_id
																							) as m
																							ON m.MyPro_id = r.h_MP_ID

																							WHERE LENGTH(r.h_ID) > 0
																						) o
																						WHERE MONTH(o.task_due) = MONTH(NOW())
																						AND o.task_status != 2
																					");
												                    			} else {
												                    				$result = mysqli_query($conn, "SELECT
																						*
																						FROM (
																							SELECT
																							m.MyPro_id AS m_ID,
																							m.Project_Name AS m_name,
																							m.Project_Description AS m_description,
																							m.Start_Date AS m_start,
																							m.Desired_Deliver_Date AS m_due,
																							h_ID,
																							h_MP_ID,
																							h_name,
																							h_description,
																							h_start,
																							h_due,
																							h_status,
																							c_ID,
																							c_name,
																							c_description,
																							c_start,
																							c_due,
																							c_status,

																							CASE WHEN c_ID IS NULL THEN 0 ELSE 1 END AS task_path,
																							CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
																							CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
																							CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
																							CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
																							CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
																							CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

																							FROM (
																								SELECT
																								h.History_id AS h_ID,
																								h.MyPro_PK AS h_MP_ID,
																								h.filename AS h_name,
																								h.description AS h_description,
																								h.history_added AS h_start,
																								h.Action_date AS h_due,
				        																		h.tmsh_column_status AS h_status,
																								c.CAI_id AS c_ID,
																								c.CAI_filename AS c_name,
																								c.CAI_description AS c_description,
																								c.CAI_Action_date AS c_start,
																								c.CAI_Action_due_date AS c_due,
																								c.CIA_progress AS c_status
																								
																								FROM tbl_MyProject_Services_History AS h

																								LEFT JOIN (
																									SELECT
																								    *
																								    FROM tbl_MyProject_Services_Childs_action_Items
																								    WHERE is_deleted = 0
																								) AS c
																								ON h.History_id = c.Services_History_PK

																								WHERE h.is_deleted = 0
																							) r

																							RIGHT JOIN (
																							 	SELECT
																							    *
																							    FROM tbl_MyProject_Services
																							    WHERE is_deleted = 0
																							    AND switch_id = $switch_user_id
																							) as m
																							ON m.MyPro_id = r.h_MP_ID

																							WHERE LENGTH(r.h_ID) > 0
																							AND (m.user_cookies = $current_userID OR FIND_IN_SET($current_userEmployeeID, REPLACE(m.Collaborator_PK, ' ', '')) > 0)
																						) o
																						WHERE MONTH(o.task_due) = MONTH(NOW())
																						AND o.task_status != 2
																					");
												                    			}
											                                	while($row = mysqli_fetch_array($result)) {
																					$task_start = $row['task_start'];
																					$task_start = new DateTime($task_start);
																					$task_start = $task_start->format('M d, Y');
											                                		
																					$task_due = $row['task_due'];
																					$task_due = new DateTime($task_due);
																					$task_due = $task_due->format('M d, Y');

											                                		echo '<tr id="tr_'.$row['task_path'].'_'.$row['task_ID'].'">
													                    				<td>
													                    					<a href="javascript:;" class="btn btn-xs btn-success" onclick="btnComplete_Project('.$row['task_ID'].', '.$row['task_path'].', this)" title="Complete"><i class="fa fa-check"></i></a>
													                    					<b><a href="test_task_mypro.php?view_id='.$row['m_ID'].'">'.$row['task_name'].'</a></b><br>
													                    					<i>'.$row['task_description'].'</i>
													                    				</td>
													                    				<td>'.$row['m_name'].'</td>
													                    				<td href="#modalDateSelect" data-toggle="modal" onClick="btnDateSelect('.$row['task_ID'].', '.$row['task_path'].', 0)">'.$task_start.'</td>
													                    				<td href="#modalDateSelect" data-toggle="modal"  onClick="btnDateSelect('.$row['task_ID'].', '.$row['task_path'].', 1)">'.$task_due.'</td>
													                    			</tr>';
											                                	}
											                    			?>
											                    		</tbody>
											                    	</table>
											                    </div>
											                    <div class="tab-pane" id="tab_Overdue">
											                    	<table class="table table-striped table-bordered table-hover" id="tableData_Overdue">
											                    		<thead>
											                    			<tr>
											                    				<th>Task Name</th>
											                    				<th>Project Name</th>
											                    				<th>Start Date</th>
											                    				<th>Due Date</th>
											                    			</tr>
											                    		</thead>
											                    		<tbody>
											                    			<?php
											                    				if (!empty($_COOKIE['switchAccount']) OR $current_userAdminAccess == 1) {
												                    				$result = mysqli_query($conn, "SELECT
																						*
																						FROM (
																							SELECT
																							m.MyPro_id AS m_ID,
																							m.Project_Name AS m_name,
																							m.Project_Description AS m_description,
																							m.Start_Date AS m_start,
																							m.Desired_Deliver_Date AS m_due,
																							h_ID,
																							h_MP_ID,
																							h_name,
																							h_description,
																							h_start,
																							h_due,
																							h_status,
																							c_ID,
																							c_name,
																							c_description,
																							c_start,
																							c_due,
																							c_status,

																							CASE WHEN c_ID IS NULL THEN 0 ELSE 1 END AS task_path,
																							CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
																							CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
																							CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
																							CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
																							CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
																							CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

																							FROM (
																								SELECT
																								h.History_id AS h_ID,
																								h.MyPro_PK AS h_MP_ID,
																								h.filename AS h_name,
																								h.description AS h_description,
																								h.history_added AS h_start,
																								h.Action_date AS h_due,
				        																		h.tmsh_column_status AS h_status,
																								c.CAI_id AS c_ID,
																								c.CAI_filename AS c_name,
																								c.CAI_description AS c_description,
																								c.CAI_Action_date AS c_start,
																								c.CAI_Action_due_date AS c_due,
																								c.CIA_progress AS c_status
																								
																								FROM tbl_MyProject_Services_History AS h

																								LEFT JOIN (
																									SELECT
																								    *
																								    FROM tbl_MyProject_Services_Childs_action_Items
																								    WHERE is_deleted = 0
																								) AS c
																								ON h.History_id = c.Services_History_PK

																								WHERE h.is_deleted = 0
																							) r

																							RIGHT JOIN (
																							 	SELECT
																							    *
																							    FROM tbl_MyProject_Services
																							    WHERE is_deleted = 0
																							    AND switch_id = $switch_user_id
																							) as m
																							ON m.MyPro_id = r.h_MP_ID

																							WHERE LENGTH(r.h_ID) > 0
																						) o
																						WHERE DATE(o.task_due) < CURDATE()
																						AND o.task_status != 2
																					");
												                    			} else {
												                    				$result = mysqli_query($conn, "SELECT
																						*
																						FROM (
																							SELECT
																							m.MyPro_id AS m_ID,
																							m.Project_Name AS m_name,
																							m.Project_Description AS m_description,
																							m.Start_Date AS m_start,
																							m.Desired_Deliver_Date AS m_due,
																							h_ID,
																							h_MP_ID,
																							h_name,
																							h_description,
																							h_start,
																							h_due,
																							h_status,
																							c_ID,
																							c_name,
																							c_description,
																							c_start,
																							c_due,
																							c_status,

																							CASE WHEN c_ID IS NULL THEN 0 ELSE 1 END AS task_path,
																							CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
																							CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
																							CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
																							CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
																							CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
																							CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

																							FROM (
																								SELECT
																								h.History_id AS h_ID,
																								h.MyPro_PK AS h_MP_ID,
																								h.filename AS h_name,
																								h.description AS h_description,
																								h.history_added AS h_start,
																								h.Action_date AS h_due,
				        																		h.tmsh_column_status AS h_status,
																								c.CAI_id AS c_ID,
																								c.CAI_filename AS c_name,
																								c.CAI_description AS c_description,
																								c.CAI_Action_date AS c_start,
																								c.CAI_Action_due_date AS c_due,
																								c.CIA_progress AS c_status
																								
																								FROM tbl_MyProject_Services_History AS h

																								LEFT JOIN (
																									SELECT
																								    *
																								    FROM tbl_MyProject_Services_Childs_action_Items
																								    WHERE is_deleted = 0
																								) AS c
																								ON h.History_id = c.Services_History_PK

																								WHERE h.is_deleted = 0
																							) r

																							RIGHT JOIN (
																							 	SELECT
																							    *
																							    FROM tbl_MyProject_Services
																							    WHERE is_deleted = 0
																							    AND switch_id = $switch_user_id
																							) as m
																							ON m.MyPro_id = r.h_MP_ID

																							WHERE LENGTH(r.h_ID) > 0
																							AND (m.user_cookies = $current_userID OR FIND_IN_SET($current_userEmployeeID, REPLACE(m.Collaborator_PK, ' ', '')) > 0)
																						) o
																						WHERE DATE(o.task_due) < CURDATE()
																						AND o.task_status != 2
																					");
												                    			}
											                                	while($row = mysqli_fetch_array($result)) {
																					$task_start = $row['task_start'];
																					$task_start = new DateTime($task_start);
																					$task_start = $task_start->format('M d, Y');
											                                		
																					$task_due = $row['task_due'];
																					$task_due = new DateTime($task_due);
																					$task_due = $task_due->format('M d, Y');

											                                		echo '<tr id="tr_'.$row['task_path'].'_'.$row['task_ID'].'">
													                    				<td>
													                    					<a href="javascript:;" class="btn btn-xs btn-success" onclick="btnComplete_Project('.$row['task_ID'].', '.$row['task_path'].', this)" title="Complete"><i class="fa fa-check"></i></a>
													                    					<b><a href="test_task_mypro.php?view_id='.$row['m_ID'].'">'.$row['task_name'].'</a></b><br>
													                    					<i>'.$row['task_description'].'</i>
													                    				</td>
													                    				<td>'.$row['m_name'].'</td>
													                    				<td href="#modalDateSelect" data-toggle="modal" onClick="btnDateSelect('.$row['task_ID'].', '.$row['task_path'].', 0)">'.$task_start.'</td>
													                    				<td href="#modalDateSelect" data-toggle="modal"  onClick="btnDateSelect('.$row['task_ID'].', '.$row['task_path'].', 1)">'.$task_due.'</td>
													                    			</tr>';
											                                	}
											                    			?>
											                    		</tbody>
											                    	</table>
											                    </div>
											                    <div class="tab-pane" id="tab_Completed">
											                    	<table class="table table-striped table-bordered table-hover" id="tableData_Completed">
											                    		<thead>
											                    			<tr>
											                    				<th>Task Name</th>
											                    				<th>Project Name</th>
											                    				<th>Start Date</th>
											                    				<th>Due Date</th>
											                    			</tr>
											                    		</thead>
											                    		<tbody>
											                    			<?php
											                    				if (!empty($_COOKIE['switchAccount']) OR $current_userAdminAccess == 1) {
												                    				$result = mysqli_query($conn, "SELECT
																						*
																						FROM (
																							SELECT
																							m.MyPro_id AS m_ID,
																							m.Project_Name AS m_name,
																							m.Project_Description AS m_description,
																							m.Start_Date AS m_start,
																							m.Desired_Deliver_Date AS m_due,
																							h_ID,
																							h_MP_ID,
																							h_name,
																							h_description,
																							h_start,
																							h_due,
																							h_status,
																							c_ID,
																							c_name,
																							c_description,
																							c_start,
																							c_due,
																							c_status,

																							CASE WHEN c_ID IS NULL THEN 0 ELSE 1 END AS task_path,
																							CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
																							CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
																							CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
																							CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
																							CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
																							CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

																							FROM (
																								SELECT
																								h.History_id AS h_ID,
																								h.MyPro_PK AS h_MP_ID,
																								h.filename AS h_name,
																								h.description AS h_description,
																								h.history_added AS h_start,
																								h.Action_date AS h_due,
				        																		h.tmsh_column_status AS h_status,
																								c.CAI_id AS c_ID,
																								c.CAI_filename AS c_name,
																								c.CAI_description AS c_description,
																								c.CAI_Action_date AS c_start,
																								c.CAI_Action_due_date AS c_due,
																								c.CIA_progress AS c_status
																								
																								FROM tbl_MyProject_Services_History AS h

																								LEFT JOIN (
																									SELECT
																								    *
																								    FROM tbl_MyProject_Services_Childs_action_Items
																								    WHERE is_deleted = 0
																								) AS c
																								ON h.History_id = c.Services_History_PK

																								WHERE h.is_deleted = 0
																							) r

																							RIGHT JOIN (
																							 	SELECT
																							    *
																							    FROM tbl_MyProject_Services
																							    WHERE is_deleted = 0
																							    AND switch_id = $switch_user_id
																							) as m
																							ON m.MyPro_id = r.h_MP_ID

																							WHERE LENGTH(r.h_ID) > 0
																						) o
																						WHERE DATE(o.task_due) < CURDATE()
																						AND o.task_status = 2
																					");
												                    			} else {
												                    				$result = mysqli_query($conn, "SELECT
																						*
																						FROM (
																							SELECT
																							m.MyPro_id AS m_ID,
																							m.Project_Name AS m_name,
																							m.Project_Description AS m_description,
																							m.Start_Date AS m_start,
																							m.Desired_Deliver_Date AS m_due,
																							h_ID,
																							h_MP_ID,
																							h_name,
																							h_description,
																							h_start,
																							h_due,
																							h_status,
																							c_ID,
																							c_name,
																							c_description,
																							c_start,
																							c_due,
																							c_status,

																							CASE WHEN c_ID IS NULL THEN 0 ELSE 1 END AS task_path,
																							CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
																							CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
																							CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
																							CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
																							CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
																							CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

																							FROM (
																								SELECT
																								h.History_id AS h_ID,
																								h.MyPro_PK AS h_MP_ID,
																								h.filename AS h_name,
																								h.description AS h_description,
																								h.history_added AS h_start,
																								h.Action_date AS h_due,
				        																		h.tmsh_column_status AS h_status,
																								c.CAI_id AS c_ID,
																								c.CAI_filename AS c_name,
																								c.CAI_description AS c_description,
																								c.CAI_Action_date AS c_start,
																								c.CAI_Action_due_date AS c_due,
																								c.CIA_progress AS c_status
																								
																								FROM tbl_MyProject_Services_History AS h

																								LEFT JOIN (
																									SELECT
																								    *
																								    FROM tbl_MyProject_Services_Childs_action_Items
																								    WHERE is_deleted = 0
																								) AS c
																								ON h.History_id = c.Services_History_PK

																								WHERE h.is_deleted = 0
																							) r

																							RIGHT JOIN (
																							 	SELECT
																							    *
																							    FROM tbl_MyProject_Services
																							    WHERE is_deleted = 0
																							    AND switch_id = $switch_user_id
																							) as m
																							ON m.MyPro_id = r.h_MP_ID

																							WHERE LENGTH(r.h_ID) > 0
																							AND (m.user_cookies = $current_userID OR FIND_IN_SET($current_userEmployeeID, REPLACE(m.Collaborator_PK, ' ', '')) > 0)
																						) o
																						WHERE DATE(o.task_due) < CURDATE()
																						AND o.task_status = 2
																					");
												                    			}
											                                	while($row = mysqli_fetch_array($result)) {
																					$task_start = $row['task_start'];
																					$task_start = new DateTime($task_start);
																					$task_start = $task_start->format('M d, Y');
											                                		
																					$task_due = $row['task_due'];
																					$task_due = new DateTime($task_due);
																					$task_due = $task_due->format('M d, Y');

											                                		echo '<tr id="tr_'.$row['task_path'].'_'.$row['task_ID'].'">
													                    				<td>
													                    					<b><a href="test_task_mypro.php?view_id='.$row['m_ID'].'">'.$row['task_name'].'</a></b><br>
													                    					<i>'.$row['task_description'].'</i>
													                    				</td>
													                    				<td>'.$row['m_name'].'</td>
													                    				<td href="#modalDateSelect" data-toggle="modal" onClick="btnDateSelect('.$row['task_ID'].', '.$row['task_path'].', 0)">'.$task_start.'</td>
													                    				<td href="#modalDateSelect" data-toggle="modal"  onClick="btnDateSelect('.$row['task_ID'].', '.$row['task_path'].', 1)">'.$task_due.'</td>
													                    			</tr>';
											                                	}
											                    			?>
											                    		</tbody>
											                    	</table>
											                    </div>
						                    				</div>
						                    			</div>
						                    			<div class="col-md-6">
									                    	<table class="table table-striped table-bordered table-hover" id="tableData_Proj">
									                    		<thead>
									                    			<tr>
									                    				<th>Project Name</th>
									                    			</tr>
									                    		</thead>
									                    		<tbody>
									                    			<?php
									                    				if (!empty($_COOKIE['switchAccount']) OR $current_userAdminAccess == 1) {
										                    				$result = mysqli_query($conn, "SELECT
										                    				    MyPro_id,
																				Project_Name
																				FROM tbl_MyProject_Services
																				WHERE is_deleted = 0
																				AND switch_id = $switch_user_id
																			");
										                    			} else {
										                    				$result = mysqli_query($conn, "SELECT
										                    				    MyPro_id,
																				Project_Name
																				FROM tbl_MyProject_Services
																				WHERE is_deleted = 0
																				AND switch_id = $switch_user_id
																				AND (user_cookies = $current_userID OR FIND_IN_SET($current_userEmployeeID, REPLACE(Collaborator_PK, ' ', '')) > 0)
																			");
										                    			}
									                                	while($row = mysqli_fetch_array($result)) {
									                                		echo '<tr>
													                    		<td><a href="test_task_mypro.php?view_id='.$row['MyPro_id'].'">'.$row['Project_Name'].'</a></td>
											                    			</tr>';
									                                	}
									                    			?>
									                    		</tbody>
									                    	</table>
						                    			</div>
						                    		</div>
							                    </div>
							                    <div class="tab-pane" id="tab_Summary">
							                    	<div class="row">
								                        <div class="col-md-3">
								                            <a class="dashboard-stat dashboard-stat-v2 green" href="#">
								                                <div class="visual">
								                                    <i class="fa fa-check"></i>
								                                </div>
								                                <div class="details">
								                                    <div class="number">
								                                    	<?php echo '<span data-counter="counterup" data-value="'.$countCompleted.'">'.$countCompleted.'</span>'; ?>
								                                   	</div>
								                                    <div class="desc">Completed Tasks</div>
								                                </div>
								                            </a>
								                        </div>
								                        <div class="col-md-3">
								                            <a class="dashboard-stat dashboard-stat-v2 yellow" href="#">
								                                <div class="visual">
								                                    <i class="fa fa-close"></i>
								                                </div>
								                                <div class="details">
								                                    <div class="number">
								                                    	<?php echo '<span data-counter="counterup" data-value="'.$countPending.'">'.$countPending.'</span>'; ?>
								                                   	</div>
								                                    <div class="desc">Pending Tasks</div>
								                                </div>
								                            </a>
								                        </div>
								                        <div class="col-md-3">
								                            <a class="dashboard-stat dashboard-stat-v2 red" href="#">
								                                <div class="visual">
								                                    <i class="fa fa-exclamation-triangle"></i>
								                                </div>
								                                <div class="details">
								                                    <div class="number">
								                                    	<?php echo '<span data-counter="counterup" data-value="'.$countDue.'">'.$countDue.'</span>'; ?>
								                                   	</div>
								                                    <div class="desc">Overdue Tasks</div>
								                                </div>
								                            </a>
								                        </div>
								                        <div class="col-md-3">
								                            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
								                                <div class="visual">
								                                    <i class="fa fa-bar-chart-o"></i>
								                                </div>
								                                <div class="details">
								                                    <div class="number">
								                                    	<?php echo '<span data-counter="counterup" data-value="'.$countTotal.'">'.$countTotal.'</span>'; ?>
								                                   	</div>
								                                    <div class="desc">Total Tasks</div>
								                                </div>
								                            </a>
								                        </div>
								                    </div>
								                    <div class="row margin-top-20">
								                    	<div class="col-md-6"><div id="chartPending"></div></div>
								                    	<div class="col-md-6">
        							                    	<?php
        							                    	    echo '<select class="form-controlx" style="border: 0; border: 0; margin-top: 35px; margin-left: 8px; position: absolute; z-index: 1;" onchange="highchart_completed(this.value)">
        							                    	        <option value="">Select Project</option>';
            					                    				if (!empty($_COOKIE['switchAccount']) OR $current_userAdminAccess == 1) {
            						                    				$result = mysqli_query($conn, "SELECT
            																o.m_ID,
            																o.m_name,
            																COUNT(o.task_ID) AS m_count
            																FROM (
            																	SELECT
            																	m.MyPro_id AS m_ID,
            																	m.Project_Name AS m_name,
            																	m.Project_Description AS m_description,
            																	m.Start_Date AS m_start,
            																	m.Desired_Deliver_Date AS m_due,
            																	h_ID,
            																	h_MP_ID,
            																	h_name,
            																	h_description,
            																	h_start,
            																	h_due,
            																	h_status,
            																	c_ID,
            																	c_name,
            																	c_description,
            																	c_start,
            																	c_due,
            																	c_status,
            
            																	CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
            																	CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
            																	CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
            																	CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
            																	CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
            																	CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status
            
            																	FROM (
            																		SELECT
            																		h.History_id AS h_ID,
            																		h.MyPro_PK AS h_MP_ID,
            																		h.filename AS h_name,
            																		h.description AS h_description,
            																		h.history_added AS h_start,
            																		h.Action_date AS h_due,
            																		h.tmsh_column_status AS h_status,
            																		c.CAI_id AS c_ID,
            																		c.CAI_filename AS c_name,
            																		c.CAI_description AS c_description,
            																		c.CAI_Action_date AS c_start,
            																		c.CAI_Action_due_date AS c_due,
            																		c.CIA_progress AS c_status
            																		
            																		FROM tbl_MyProject_Services_History AS h
            
            																		LEFT JOIN (
            																			SELECT
            																		    *
            																		    FROM tbl_MyProject_Services_Childs_action_Items
            																		    WHERE is_deleted = 0
            																		) AS c
            																		ON h.History_id = c.Services_History_PK
            
            																		WHERE h.is_deleted = 0
            																	) r
            
            																	RIGHT JOIN (
            																	 	SELECT
            																	    *
            																	    FROM tbl_MyProject_Services
            																	    WHERE is_deleted = 0
            																	    AND switch_id = $switch_user_id
            																	) as m
            																	ON m.MyPro_id = r.h_MP_ID
            
            																	WHERE LENGTH(r.h_ID) > 0
            																) o
            																WHERE o.task_status != 2
            
            																GROUP BY o.m_ID
            																
            																ORDER BY o.m_name
            															");
            						                    			} else {
            						                    				$result = mysqli_query($conn, "SELECT
            																o.m_ID,
            																o.m_name,
            																COUNT(o.task_ID) AS m_count
            																FROM (
            																	SELECT
            																	m.MyPro_id AS m_ID,
            																	m.Project_Name AS m_name,
            																	m.Project_Description AS m_description,
            																	m.Start_Date AS m_start,
            																	m.Desired_Deliver_Date AS m_due,
            																	h_ID,
            																	h_MP_ID,
            																	h_name,
            																	h_description,
            																	h_start,
            																	h_due,
            																	h_status,
            																	c_ID,
            																	c_name,
            																	c_description,
            																	c_start,
            																	c_due,
            																	c_status,
            
            																	CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
            																	CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
            																	CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
            																	CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
            																	CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
            																	CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status
            
            																	FROM (
            																		SELECT
            																		h.History_id AS h_ID,
            																		h.MyPro_PK AS h_MP_ID,
            																		h.filename AS h_name,
            																		h.description AS h_description,
            																		h.history_added AS h_start,
            																		h.Action_date AS h_due,
            																		h.tmsh_column_status AS h_status,
            																		c.CAI_id AS c_ID,
            																		c.CAI_filename AS c_name,
            																		c.CAI_description AS c_description,
            																		c.CAI_Action_date AS c_start,
            																		c.CAI_Action_due_date AS c_due,
            																		c.CIA_progress AS c_status
            																		
            																		FROM tbl_MyProject_Services_History AS h
            
            																		LEFT JOIN (
            																			SELECT
            																		    *
            																		    FROM tbl_MyProject_Services_Childs_action_Items
            																		    WHERE is_deleted = 0
            																		) AS c
            																		ON h.History_id = c.Services_History_PK
            
            																		WHERE h.is_deleted = 0
            																	) r
            
            																	RIGHT JOIN (
            																	 	SELECT
            																	    *
            																	    FROM tbl_MyProject_Services
            																	    WHERE is_deleted = 0
            																	    AND switch_id = $switch_user_id
            																	) as m
            																	ON m.MyPro_id = r.h_MP_ID
            
            																	WHERE LENGTH(r.h_ID) > 0
            																	AND (m.user_cookies = $current_userID OR FIND_IN_SET($current_userEmployeeID, REPLACE(m.Collaborator_PK, ' ', '')) > 0)
            																) o
            																WHERE o.task_status != 2
            
            																GROUP BY o.m_ID
            																
            																ORDER BY o.m_name
            															");
            						                    			}
            					                                	while($row = mysqli_fetch_array($result)) {
            															echo '<option value="'.$row['m_ID'].'">'.$row['m_name'].'</option>';
            					                                	}
            					                                echo '</select>';
    					                                	?>
								                    	    <div id="chartCompleted"></div>
								                        </div>
								                    </div>
							                    </div>
							                </div>
					                    </div>
					                    <div class="tab-pane" id="tab_Calendar">
					                         <div class="row">
					                            <div class="col-md-12">
					                                <div id="calendar_data"> </div>
					                            </div>
					                         </div>
					                    </div>
					                    <div class="tab-pane" id="tab_Dashboard">
					                        <h3>Project &nbsp;<a class="btn btn-primary" data-toggle="modal" href="<?php echo $FreeAccess == false ? '#addNew':'#modalService'; ?>"> Create Project</a></h3>
					                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_4">
					                            <thead>
					                                <tr>
					                                    <th rowspan="2" class="<?php echo $current_client == 1 ? 'hide':''; ?>">Tickets#</th>
					                                    <th rowspan="2">Project Name</th>
					                                    <th colspan="3" class="text-center">Task Status</th>
					                                    <th rowspan="2">Task Description</th>
					                                    <th rowspan="2">Request Date</th>
					                                    <th rowspan="2">Desired Due Date</th>
					                                    <th rowspan="2" class="text-center" style="width: 125px;">Action</th>
					                                </tr>
					                                <tr>
					                                    <th class="text-center">Not Started</th>
					                                    <th class="text-center">In Progress</th>
					                                    <th class="text-center">Completed</th>
					                                </tr>
					                            </thead>
					                            <tbody id="project_data">
					                                <?php
					                                    $childcolor1 ='';
					                                    
				                                		if (!empty($_COOKIE['switchAccount']) OR $current_userAdminAccess == 1) {
				                                			$result = mysqli_query($conn, "SELECT
																project_ID,
																project_name,
																project_description,
																date_stated,
																date_delivery,
																user_collab,
																user_cookies,
																user_switch,
																COALESCE(count_NS, 0) AS count_NS,
																COALESCE(count_IP, 0) AS count_IP,
																COALESCE(count_C, 0) AS count_C,
																COUNT(ma.CAI_id) AS count_RES,
																COALESCE(SUM(ma.CIA_progress = 2), 0) AS count_COMP,
																COALESCE(SUM(ma.CIA_progress != 2), 0) AS count_NON

																FROM (
																SELECT
																mp.MyPro_id AS project_ID,
																mp.Project_Name AS project_name,
																mp.Project_Description AS project_description,
																mp.Start_Date AS date_stated,
																mp.Desired_Deliver_Date AS date_delivery,
																mp.Collaborator_PK AS user_collab,
																mp.user_cookies AS user_cookies,
																mp.switch_id AS user_switch,
																SUM(mh.tmsh_column_status = 0) AS count_NS,
																SUM(mh.tmsh_column_status = 1) AS count_IP,
																SUM(mh.tmsh_column_status = 2) AS count_C

																FROM tbl_MyProject_Services AS mp

																LEFT JOIN (
																	SELECT
																   	*
																    FROM tbl_MyProject_Services_History
																    WHERE is_deleted = 0
																) AS mh
																ON mp.MyPro_ID = mh.MyPro_PK

																WHERE  mp.Project_status != 2
																AND mp.is_deleted=0
																AND mp.switch_id = $switch_user_id

																GROUP BY mp.MyPro_id
																) r

																LEFT JOIN (
																	SELECT
																   	*
																    FROM tbl_MyProject_Services_Childs_action_Items
																    WHERE is_deleted = 0
																) AS ma
																ON r.project_ID = ma.Parent_MyPro_PK

																GROUP BY r.project_ID");
				                                		} else {
				                                			$result = mysqli_query($conn, "SELECT
																project_ID,
																project_name,
																project_description,
																date_stated,
																date_delivery,
																user_collab,
																user_cookies,
																user_switch,
																COALESCE(count_NS, 0) AS count_NS,
																COALESCE(count_IP, 0) AS count_IP,
																COALESCE(count_C, 0) AS count_C,
																COUNT(ma.CAI_id) AS count_RES,
																COALESCE(SUM(ma.CIA_progress = 2), 0) AS count_COMP,
																COALESCE(SUM(ma.CIA_progress != 2), 0) AS count_NON

																FROM (
																SELECT
																mp.MyPro_id AS project_ID,
																mp.Project_Name AS project_name,
																mp.Project_Description AS project_description,
																mp.Start_Date AS date_stated,
																mp.Desired_Deliver_Date AS date_delivery,
																mp.Collaborator_PK AS user_collab,
																mp.user_cookies AS user_cookies,
																mp.switch_id AS user_switch,
																SUM(mh.tmsh_column_status = 0) AS count_NS,
																SUM(mh.tmsh_column_status = 1) AS count_IP,
																SUM(mh.tmsh_column_status = 2) AS count_C

																FROM tbl_MyProject_Services AS mp

																LEFT JOIN (
																	SELECT
																   	*
																    FROM tbl_MyProject_Services_History
																    WHERE is_deleted = 0
																) AS mh
																ON mp.MyPro_ID = mh.MyPro_PK

																WHERE  mp.Project_status != 2
																AND mp.is_deleted=0
																AND (mp.user_cookies = $current_userID OR FIND_IN_SET($current_userEmployeeID, REPLACE(mp.Collaborator_PK, ' ', '')) > 0)

																GROUP BY mp.MyPro_id
																) r

																LEFT JOIN (
																	SELECT
																   	*
																    FROM tbl_MyProject_Services_Childs_action_Items
																    WHERE is_deleted = 0
																) AS ma
																ON r.project_ID = ma.Parent_MyPro_PK

																GROUP BY r.project_ID");
				                                		}
					                                	while($row = mysqli_fetch_array($result)) {
					                                		$ptc = 0;
			                                                if (!empty($row['count_COMP']) && !empty($row['count_NON'])) {
			                                                    $percent = $row['count_COMP'] / $row['count_RES'];
			                                                    $ptc = number_format($percent * 100, 2) . '%';
			                                                } else if (empty($row['count_NON']) && !empty($row['count_COMP'])) {
			                                                    $ptc = '100%';
			                                                } else {
			                                                    $ptc = '0%';
			                                                }

															echo '<tr id="project_'.$row['project_ID'].'">
				                                                <td class="'; echo $current_client == 1 ? 'hide':''; echo '">No.: '.$row['project_ID'].'</td>
				                                                <td>
				                                                	'.$row['project_name'].'<br>
						                                            <div class="progress">
						                                                <div class="progress-bar" role="progressbar" style="width: '.$ptc.'" aria-valuenow="'.$ptc.'" aria-valuemin="0" aria-valuemax="100">'.$ptc.'</div>
						                                            </div>
				                                                </td>
				                                                <td class="text-center">'.$row['count_NS'].'</td>
				                                                <td class="text-center">'.$row['count_IP'].'</td>
				                                                <td class="text-center">'.$row['count_C'].'</td>
				                                                <td>'.$row['project_description'].'</td>
				                                                <td>'.$row['date_stated'].'</td>
				                                                <td>'.$row['date_delivery'].'</td>
				                                                <td class="text-center">
				                                                	<a href="#modalEdit_Project" data-toggle="modal" class="btn btn-xs dark m-0" onclick="btnEdit_Project('.$row['project_ID'].')" title="Edit"><i class="fa fa-pencil"></i></a>
				                                                	<a href="test_task_mypro.php?view_id='.$row['project_ID'].'" class="btn btn-xs btn-success m-0" title="View"><i class="fa fa-search"></i></a>
				                                                    <a href="javascript:;" class="btn btn-xs btn-danger m-0" onclick="btnDelete_Project('.$row['project_ID'].', this)" title="Delete"><i class="fa fa-trash"></i></a>
				                                                    <a href="javascript:;" class="btn btn-xs btn-info m-0" onclick="btnArchive_Project('.$row['project_ID'].', this)" title="Archive"><i class="fa fa-cloud-upload"></i></a>
				                                                </td>
				                                            </tr>';
														}
					                                ?>
					                            </tbody>
					                        </table>
					                    </div>
					                    <div class="tab-pane hide" id="tab_Me"> 
					                        <?php
					                            $connect = new PDO("mysql:host=localhost;dbname=brandons_interlinkiq", "brandons_interlinkiq", "L1873@2019new");
					                            $query = "SELECT DISTINCT(CIA_progress) FROM tbl_MyProject_Services_Childs_action_Items where is_deleted=0 AND CIA_progress != 2";
					                            $statement = $connect->prepare($query);
					                            $statement->execute();
					                            $result = $statement->fetchAll();
					                            foreach($result as $row)
					                            { ?>
					                                <div class="col-md-3">
					                                    <label><input type="radio" name="radio" class="common_selector status" value="<?php echo $row['CIA_progress']; ?>"  > <?php  if($row['CIA_progress']== 1){echo 'Inprogress';}else if($row['CIA_progress']== 2){echo 'Completed';}else{echo 'Not Started';} ?></label>
					                                </div>
					                                 
					                            <?php } ?>
					                                <div class="col-md-3">
					                                    <label><input type="radio" name="radio" class="common_selector_all status"> All</label>
					                                </div>
					                    	<table class="table table-bordered table-hover dt-responsive" id="tblAssignTask">
					            				<tbody>
					            				    <?php
					            				    
					                                 $a_user = $_COOKIE['employee_id'];
					                                $query = "SELECT *  FROM tbl_MyProject_Services_Childs_action_Items 
					                                left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
					                                left join tbl_hr_employee on CAI_Assign_to = ID
					                                left join tbl_MyProject_Services on MyPro_id = Parent_MyPro_PK
					                                where CAI_Assign_to = $a_user and CAI_Assign_to !=0 and CAI_Assign_to !='' AND tbl_MyProject_Services.is_deleted!=1 
					                                AND tbl_MyProject_Services_Childs_action_Items.is_deleted!=1 
					                                AND tbl_MyProject_Services_Childs_action_Items.switch_id = $switch_user_id ";
					                                if(!empty(isset($_GET["status"])))
					                                {
					                                    $status_filter = $_GET["status"];
					                                	$query .= "
					                                	 AND CIA_progress IN('".$status_filter."') order by CAI_id DESC
					                                	";
					                                }
					                                else
					                                {
					                                    $query .= "
					                                	 order by CAI_id DESC
					                                	";
					                                }
					                            
					                            $result = mysqli_query($conn, $query);
					                                                        
					                            while($row = mysqli_fetch_array($result))
					                            {
					                                $filesL3 = $row["CAI_files"];
					                                $fileExtension = fileExtension($filesL3);
													$src = $fileExtension['src'];
													$embed = $fileExtension['embed'];
													$type = $fileExtension['type'];
													$file_extension = $fileExtension['file_extension'];
										           $url = $base_url.'MyPro_Folder_Files/';
					                            ?>
					                                <tr id="<?php echo $row["CAI_id"]; ?>"  class="parentTbls">
					                                <td><?php echo $row["CAI_id"]; ?></td>
					                                <td><b>Ticket #:</b><?php echo $row["Parent_MyPro_PK"]; ?> <br><a href="test_task_mypro.php?view_id=<?php echo $row['Parent_MyPro_PK'];  ?>#<?php echo $row["CAI_id"]; ?>"><?php echo $row["Project_Name"]; ?></a></td>
					                                <td><b>Description:</b><br><?php echo $row["Project_Description"]; ?></td>
					                                <td><b>Task:</b> <br><?php echo $row["CAI_filename"]; ?></td>
					                                <td><?php echo $row["Action_Items_name"]; ?></td>
					                                <td><?php echo $row["CAI_description"]; ?></td>
									        	    <td>
									        	        <a data-src="<?php echo $src.$url.rawurlencode($filesL3).$embed; ?>" data-fancybox data-type="<?php echo $type; ?>" class="btn btn-link">
									        	            <?php  $ext = pathinfo($filesL3, PATHINFO_EXTENSION); 
									        	                if($ext == 'pdf'){
									        	                    echo '<i class="fa fa-file-pdf-o" style="font-size:24px;color:red;"></i>';
									        	                }
									        	                else if($ext == 'docx'){
									        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
									        	                }
									        	                else if($ext == 'doc'){
									        	                    echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue;"></i>';
									        	                }
									        	                else if($ext == 'csv'){
									        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
									        	                }
									        	                else if($ext == 'xlsx'){
									        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
									        	                }
									        	                else if($ext == 'xlsm'){
									        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
									        	                }
									        	                else if($ext == 'xls'){
									        	                    echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green;"></i>';
									        	                }
									        	                else{
									        	                  echo '<i class="fa fa-file-o" style="font-size:24px;"></i>';
									        	                }
									        	            ?>
									        	        </a>
									        	    </td>
									        	  <td> Assigned To: <?php echo $row["first_name"]; ?></td>
									        	    <td>
									        	            <?php 
										        	            if($row['CIA_progress']== 1){ echo '<b class="inprogress">Inprogress</b>'; }
										        	            else if($row['CIA_progress']== 2){ echo '<b class="completed">Completed</b>';}
										        	            else{ echo '<b class="notstarted">Not Started</b>';}
									        	            ?>
									        	      </td>
									        	      <?php if ($current_client != 1) {?>
					                                     <td>Estimated: <?php echo $row["CAI_Estimated_Time"]; ?> minutes</td>
									        	      <?php
									        	      }
										        	    if(!empty($row['CAI_Rendered_Minutes'])){ ?>
										        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;">
										        	            <?php echo 'Rendered: '; ?>
										        	            <?php echo $row['CAI_Rendered_Minutes']; ?>
										        	            <?php echo 'minute(s)'; ?>
										        	        </td>
										        	    <?php }?>
										        	    <?php
										        	    if($row['CIA_progress']==2){ ?>
										        	        <td class="paddId" style="background-color:<?php echo $childcolor1; ?>;">
										        	            <?php echo '100%'; ?>
										        	        </td>
										        	    <?php } ?>
					    					        	   <td>
					    				        	            <?php echo 'Date: '; ?>
					    				        	            <?php echo date("Y-m-d", strtotime($row['CAI_Action_date'])); ?>
					    				        	        </td>
					                                <td>
					                                    
					                                    <!--<a style="font-weight:800;" href="#modalGetHistory_Child" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child(<?php //echo  $row['CAI_id']; ?>)">Add</a>-->
					                                    <!--<a style="font-weight:800;" href="#modalGetHistory_update_Action_item" data-toggle="modal" class="btn btn-xs red" onclick="btnNew_History_update_Action_item(<?php //echo  $row['CAI_id']; ?>)">View</a>-->
					                                </td>
					                            </tr>
					                            
					            				<?php  } ?> 
					            				</tbody>
					                        </table>
					                    </div>
					                    <div class="tab-pane hide" id="tab_Collaborator_Task">
					                        <h3>Dashboard &nbsp;<a class="btn btn-primary" data-toggle="modal" href="<?php echo $FreeAccess == false ? '#addNew':'#modalService'; ?>"> Create Project</a></h3>
					                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
					                            <thead>
					                                <tr>
					                                    <th>Tickets#</th>
					                                    <th>Project Name</th>
					                                    <th colspan="3" style="text-align:center;">Task Status</th>
					                                    <th>Description</th>
					                                    <th>Request Date</th>
					                                    <th>Desired Due Date</th>
					                                    <th></th>
					                                </tr>
					                                <tr>
					                                  <th></th>
					                                  <th></th>
					                                  <th style="text-align:center;">Not Started</th>
					                                  <th style="text-align:center;">In Progress</th>
					                                  <th style="text-align:center;">Completed</th>
					                                  <th></th>
					                                  <th></th>
					                                  <th></th>
					                                  <th></th>
					                                </tr>
					                            </thead>
					                            <tbody>
					                                <?php
					                                    // $switch_user_id
					                                    $loggin_emp = $_COOKIE['employee_id'];
					                                    $query_emp = "SELECT *  FROM tbl_hr_employee where ID = $loggin_emp ";
					                                    $result_emp = mysqli_query($conn, $query_emp);
					                                    while($row_emp = mysqli_fetch_array($result_emp)) {
					                                        $temp_id = $row_emp['ID'];
					                                        $query = "SELECT *  FROM tbl_MyProject_Services where  Project_status != 2 and is_deleted=0";
					                                        $result = mysqli_query($conn, $query);
					                                        while($row = mysqli_fetch_array($result))
					                                        {
					                                            $array = explode(", ", $row['Collaborator_PK']);
					                                            if(in_array($temp_id,$array)){
					                                                ?>
					                                                <tr>
					                                                    <td><?php echo 'No.: '; echo $row['MyPro_id']; ?></td>
					                                                    <td><?php echo $row['Project_Name']; ?></td>
					                                                     <td style="text-align:center;">
					                                                        <?php
					                                                          $mypro_id = $row['MyPro_id'];
					                                                          $sql_compliance_not_started = $conn->query("SELECT COUNT(*) as compliance FROM tbl_MyProject_Services_History where MyPro_PK = $mypro_id and tmsh_column_status = 0 and is_deleted=0");
					                                                                    while ($data_compliance_not_started = $sql_compliance_not_started->fetch_array()) {
					                                                                        $not_started = $data_compliance_not_started['compliance'];
					                                                                        echo $not_started;
					                                                           }
					                                                        ?>
					                                                    </td>
					                                                    <td style="text-align:center;">
					                                                            <?php
					                                                          $mypro_id = $row['MyPro_id'];
					                                                          $sql_compliance_in_progress = $conn->query("SELECT COUNT(*) as compliance FROM tbl_MyProject_Services_History where MyPro_PK = $mypro_id and tmsh_column_status = 1 and is_deleted=0");
					                                                                    while ($data_compliance_in_progress = $sql_compliance_in_progress->fetch_array()) {
					                                                                        $in_progress = $data_compliance_in_progress['compliance'];
					                                                                        
					                                                                        echo $in_progress;
					                                                           }
					                                                        ?>
					                                                        
					                                                    </td>
					                                                    <td style="text-align:center;">
					                                                                <?php
					                                                          $mypro_id = $row['MyPro_id'];
					                                                          $sql_compliance_completed = $conn->query("SELECT COUNT(*) as compliance FROM tbl_MyProject_Services_History where MyPro_PK = $mypro_id and tmsh_column_status = 2 and is_deleted=0");
					                                                                    while ($data_compliance_completed = $sql_compliance_completed->fetch_array()) {
					                                                                        $completed = $data_compliance_completed['compliance'];
					                                                                        
					                                                                        echo $completed;
					                                                           }
					                                                        ?>
					                                                    </td>
					                                                    <td><?php echo $row['Project_Description']; ?></td>
					                                                    <td><?php echo date("Y-m-d", strtotime($row['Start_Date'])); ?></td>
					                                                    <td><?php echo date("Y-m-d", strtotime($row['Desired_Deliver_Date'])); ?></td>
					                                                    <td>
					                                                        <?php if($_COOKIE['ID'] == 38): ?>
					                                                        <a class="btn blue btn-outline btnViewMyPro_update" data-toggle="modal" href="#modalGetMyPro_update" data-id="<?php echo $row['MyPro_id']; ?>">Edit</a>
					                                                        <?php endif; ?>
					                                                        <a href="test_task_mypro.php?view_id=<?php echo $row['MyPro_id'];  ?>" class="btn green btn-outline" >
					                                                            View
					                                                        </a>
					                                                    </td>
					                                                </tr>
					                                         <?php }
					                                        }
					                                    }
					                                 ?>
					                                 <?php
					                                    $loggin_user = $_COOKIE['ID'];
					                                    $query_user = "SELECT *  FROM tbl_user where ID = $loggin_user ";
					                                    $result_user = mysqli_query($conn, $query_user);
					                                    while($row_user = mysqli_fetch_array($result_user))
					                                    {
					                                        $user_ids = $row_user['ID'];
					                                        $query = "SELECT *  FROM tbl_MyProject_Services where  Project_status != 2 and is_deleted=0";
					                                        $result = mysqli_query($conn, $query);
					                                        while($row = mysqli_fetch_array($result))
					                                        {
					                                            $array = explode(", ", $row['Collaborator_PK']);
					                                            if(in_array($user_ids,$array)){
					                                                ?>
					                                                <tr>
					                                                    <td><?php echo 'No.: '; echo $row['MyPro_id']; ?></td>
					                                                    <td><?php echo $row['Project_Name']; ?></td>
					                                                    <td><?php echo $row['Project_Description']; ?></td>
					                                                    <td><?php echo date("Y-m-d", strtotime($row['Start_Date'])); ?></td>
					                                                    <td><?php echo date("Y-m-d", strtotime($row['Desired_Deliver_Date'])); ?></td>
					                                                    <td>
					                                                        <?php if($_COOKIE['ID'] == 38): ?>
					                                                        <a class="btn blue btn-outline btnViewMyPro_update" data-toggle="modal" href="#modalGetMyPro_update" data-id="<?php echo $row['MyPro_id']; ?>">Edit</a>
					                                                        <?php endif; ?>
					                                                        <a href="test_task_mypro.php?view_id=<?php echo $row['MyPro_id'];  ?>" class="btn green btn-outline" >
					                                                            View
					                                                        </a>
					                                                    </td>
					                                                </tr>
					                                         <?php }
					                                        }
					                                    }
					                                ?>
					                            </tbody>
					                        </table>
					                    </div>
					                    <div class="tab-pane" id="tab_Archive">
					                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="dataTable_Arcive">
					                            <thead>
					                                <tr>
					                                    <th rowspan="2" class="<?php echo $current_client == 1 ? 'hide':''; ?>">Tickets#</th>
					                                    <th rowspan="2">Project Name</th>
					                                    <th colspan="3" class="text-center">Task Status</th>
					                                    <th rowspan="2">Task Description</th>
					                                    <th rowspan="2">Request Date</th>
					                                    <th rowspan="2">Desired Due Date</th>
					                                    <th rowspan="2" class="text-center" style="width: 125px;">Action</th>
					                                </tr>
					                                <tr>
					                                    <th class="text-center">Not Started</th>
					                                    <th class="text-center">In Progress</th>
					                                    <th class="text-center">Completed</th>
					                                </tr>
					                            </thead>
					                            <tbody id="project_data_archive">
					                                <?php
					                                    $childcolor1 ='';
					                                    
				                                		if (!empty($_COOKIE['switchAccount']) OR $current_userAdminAccess == 1) {
				                                			$result = mysqli_query($conn, "SELECT
																project_ID,
																project_name,
																project_description,
																date_stated,
																date_delivery,
																user_collab,
																user_cookies,
																user_switch,
																COALESCE(count_NS, 0) AS count_NS,
																COALESCE(count_IP, 0) AS count_IP,
																COALESCE(count_C, 0) AS count_C,
																COUNT(ma.CAI_id) AS count_RES,
																COALESCE(SUM(ma.CIA_progress = 2), 0) AS count_COMP,
																COALESCE(SUM(ma.CIA_progress != 2), 0) AS count_NON

																FROM (
																SELECT
																mp.MyPro_id AS project_ID,
																mp.Project_Name AS project_name,
																mp.Project_Description AS project_description,
																mp.Start_Date AS date_stated,
																mp.Desired_Deliver_Date AS date_delivery,
																mp.Collaborator_PK AS user_collab,
																mp.user_cookies AS user_cookies,
																mp.switch_id AS user_switch,
																SUM(mh.tmsh_column_status = 0) AS count_NS,
																SUM(mh.tmsh_column_status = 1) AS count_IP,
																SUM(mh.tmsh_column_status = 2) AS count_C

																FROM tbl_MyProject_Services AS mp

																LEFT JOIN (
																	SELECT
																   	*
																    FROM tbl_MyProject_Services_History
																    WHERE is_deleted = 0
																) AS mh
																ON mp.MyPro_ID = mh.MyPro_PK

																WHERE  mp.Project_status != 2
																AND mp.is_deleted = 2
																AND mp.switch_id = $switch_user_id

																GROUP BY mp.MyPro_id
																) r

																LEFT JOIN (
																	SELECT
																   	*
																    FROM tbl_MyProject_Services_Childs_action_Items
																    WHERE is_deleted = 0
																) AS ma
																ON r.project_ID = ma.Parent_MyPro_PK

																GROUP BY r.project_ID");
				                                		} else {
				                                			$result = mysqli_query($conn, "SELECT
																project_ID,
																project_name,
																project_description,
																date_stated,
																date_delivery,
																user_collab,
																user_cookies,
																user_switch,
																COALESCE(count_NS, 0) AS count_NS,
																COALESCE(count_IP, 0) AS count_IP,
																COALESCE(count_C, 0) AS count_C,
																COUNT(ma.CAI_id) AS count_RES,
																COALESCE(SUM(ma.CIA_progress = 2), 0) AS count_COMP,
																COALESCE(SUM(ma.CIA_progress != 2), 0) AS count_NON

																FROM (
																SELECT
																mp.MyPro_id AS project_ID,
																mp.Project_Name AS project_name,
																mp.Project_Description AS project_description,
																mp.Start_Date AS date_stated,
																mp.Desired_Deliver_Date AS date_delivery,
																mp.Collaborator_PK AS user_collab,
																mp.user_cookies AS user_cookies,
																mp.switch_id AS user_switch,
																SUM(mh.tmsh_column_status = 0) AS count_NS,
																SUM(mh.tmsh_column_status = 1) AS count_IP,
																SUM(mh.tmsh_column_status = 2) AS count_C

																FROM tbl_MyProject_Services AS mp

																LEFT JOIN (
																	SELECT
																   	*
																    FROM tbl_MyProject_Services_History
																    WHERE is_deleted = 0
																) AS mh
																ON mp.MyPro_ID = mh.MyPro_PK

																WHERE  mp.Project_status != 2
																AND mp.is_deleted = 2
																AND (mp.user_cookies = $current_userID OR FIND_IN_SET($current_userEmployeeID, REPLACE(mp.Collaborator_PK, ' ', '')) > 0)

																GROUP BY mp.MyPro_id
																) r

																LEFT JOIN (
																	SELECT
																   	*
																    FROM tbl_MyProject_Services_Childs_action_Items
																    WHERE is_deleted = 0
																) AS ma
																ON r.project_ID = ma.Parent_MyPro_PK

																GROUP BY r.project_ID");
				                                		}
					                                	while($row = mysqli_fetch_array($result)) {
					                                		$ptc = 0;
			                                                if (!empty($row['count_COMP']) && !empty($row['count_NON'])) {
			                                                    $percent = $row['count_COMP'] / $row['count_RES'];
			                                                    $ptc = number_format($percent * 100, 2) . '%';
			                                                } else if (empty($row['count_NON']) && !empty($row['count_COMP'])) {
			                                                    $ptc = '100%';
			                                                } else {
			                                                    $ptc = '0%';
			                                                }

															echo '<tr id="project_'.$row['project_ID'].'">
				                                                <td class="'; echo $current_client == 1 ? 'hide':''; echo '">No.: '.$row['project_ID'].'</td>
				                                                <td>
				                                                	'.$row['project_name'].'<br>
						                                            <div class="progress">
						                                                <div class="progress-bar" role="progressbar" style="width: '.$ptc.'" aria-valuenow="'.$ptc.'" aria-valuemin="0" aria-valuemax="100">'.$ptc.'</div>
						                                            </div>
				                                                </td>
				                                                <td class="text-center">'.$row['count_NS'].'</td>
				                                                <td class="text-center">'.$row['count_IP'].'</td>
				                                                <td class="text-center">'.$row['count_C'].'</td>
				                                                <td>'.$row['project_description'].'</td>
				                                                <td>'.$row['date_stated'].'</td>
				                                                <td>'.$row['date_delivery'].'</td>
				                                                <td class="text-center">
				                                                	<a href="test_task_mypro.php?view_id='.$row['project_ID'].'" class="btn btn-xs btn-success m-0" title="View"><i class="fa fa-search"></i></a>
				                                                </td>
				                                            </tr>';
														}
					                                ?>
					                            </tbody>
					                        </table>
					                    </div>
					                </div>
					            </div>
					        </div>
					    </div>
					    <!--Create Project MODAL AREA-->
					    <!--Certification MODAL AREA-->
					   
					    <?php include "mypro_function/modals.php"; ?>

                        <div class="modal fade" id="modalDateSelect" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalDateSelect">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Select Date</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Date" id="btnSave_Date" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalAccess" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalAccess">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Collaborator</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Access" id="btnSave_Access" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
					    <!-- / END MODAL AREA -->
					                 
					</div><!-- END CONTENT BODY -->

        <!--<script src="assets/global/plugins/highcharts/js/highcharts.js" type="text/javascript"></script>-->
        <!--<script src="assets/global/plugins/highcharts/js/highcharts-3d.js" type="text/javascript"></script>-->
        <!--<script src="assets/global/plugins/highcharts/js/highcharts-more.js" type="text/javascript"></script>-->
		<?php include_once ('footer.php'); ?>
		        
		<script src="assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>

		<script src="assets/pages/scripts/jquery.table2excel.js" type="text/javascript"></script>

		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL SCRIPTS -->
		<script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
		
		
        <!--<script src="assets/pages/scripts/charts-highcharts.min.js" type="text/javascript"></script>-->

        <script src="//code.highcharts.com/highcharts.js"></script>
        <script src="//code.highcharts.com/modules/data.js"></script>
        <script src="//code.highcharts.com/highcharts-more.js"></script>
        <!--<script src="//code.highcharts.com/modules/exporting.js"></script>-->
        <!--<script src="//code.highcharts.com/modules/export-data.js"></script>-->
        <!--<script src="//code.highcharts.com/modules/accessibility.js"></script>-->

		<script type="text/javascript">
			var access = <?php echo $current_userAdminAccess; ?>

			function selectOption(e) {
				$('a[href="' + e + '"]').tab('show');
			}

            function btnDelete_Project(id, e) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be deleted!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "mypro_function/function.php?btnDelete_Project="+id,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            function btnArchive_Project(id, e) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be achived!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "mypro_function/function.php?btnArchive_Project="+id,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been achived.", "success");
                });
            }
            function btnEdit_Project(id) {
                $.ajax({
                    type: "GET",
                    url: "mypro_function/function.php?btnEdit_Project="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalEdit_Project .modal-body").html(data);
                        selectMulti();
                    }
                });
            }

            function highchart_pending() {
                Highcharts.getJSON(
                    'mypro_function/function.php?mypro_pending=1&a='+access,
                    function (data) {
                        var obj = JSON.stringify(data.series);
                        var series = jQuery.parseJSON(obj);
                        // console.log(obj);
                        // console.log(data.series);
                        // console.log(series);

						Highcharts.chart('chartPending', {
						    chart: {
						        type: 'column'
						    },
						    title: {
						        text: 'Pending Task By Project',
						        align: 'left'
						    },
                            colors:['#c49f47'],
						    xAxis: {
						        type: 'category',
						        labels: {
                                    style: {
                                        fontSize:'14px'
                                    }
                                }
						    },
						    yAxis: {
                                allowDecimals: false,
						        min: 0,
						        title: {
						            text: ''
						        },
						        labels: {
                                    style: {
                                        fontSize:'14px'
                                    }
                                }
						    },
						    plotOptions: {
						        column: {
						            pointPadding: 0.2,
						            borderWidth: 0
						        }
						    },
						    legend:{ enabled:false },
						    series: [{
						        data: series,
						        dataLabels: {
						            enabled: true,
						            format: '{point.y:.0f}'
						        },
						        label: {
                                    style: {
                                        fontSize:'14px'
                                    }
                                },
						        tooltip: {
						            pointFormat: 'Pending Task: <b>{point.y}</b>'
						        },
						        borderRadius: 3,
						        colorByPoint: true
						    }]
						});
                    }
                );
            }
            function highchart_completed(e) {
                // console.log(e);
                Highcharts.getJSON(
                    'mypro_function/function.php?mypro_completed='+e+'&a='+access,
                    function (data) {
                        var obj = JSON.stringify(data.series);
                        var series = jQuery.parseJSON(obj);
                        // console.log(obj);
                        // console.log(data.series);
                        // console.log(series);
        
        				Highcharts.chart('chartCompleted', {
        				    chart: {
        				        type: 'pie'
        				    },
        				    title: {
        				        text: 'Total Task Completion Status By This Project',
        						align: 'left'
        				    },
                            colors:['#32c5d2','#c49f47','#e7505a'],
        				    plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                        enabled: false
                                    },
    						        label: {
                                        style: {
                                            fontSize:'14px'
                                        }
                                    },
                                    showInLegend: true
                                },
        				        series: {
        				            allowPointSelect: true,
        				            cursor: 'pointer',
        				            dataLabels: [{
        				                enabled: false,
        				                distance: 20,
                                        style: {
                                            fontSize: '14px'  
                                        }
        				            }, {
        				                enabled: true,
        				                distance: -40,
        				                format: '{point.y:.0f}',
        				                style: {
        				                    fontSize: '14px',
        				                    textOutline: 'none',
        				                    opacity: 0.7
        				                },
        				                filter: {
        				                    operator: '>',
        				                    property: 'percentage',
        				                    value: 10
        				                }
        				            }]
        				        }
        				    },
        				    series: series
        				});
                    }
                );
            }

            // Select and Update Date
            function btnDateSelect(id, path, type) {
                $.ajax({
                    type: "GET",
                    url: "mypro_function/function.php?modalDate_Select="+id+"&p="+path+"&t="+type,
                    dataType: "html",
                    success: function(data){
                        $("#modalDateSelect .modal-body").html(data);
                    }
                });
            }
            function btnComplete_Project(id, path, e) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be completed!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "mypro_function/function.php?btnComplete_Project="+id+"&p="+path,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been completed.", "success");
                });
            }
			$(".modalDateSelect").on('submit',(function(e) {
			    e.preventDefault();
			    formObj = $(this);
			    if (!formObj.validate().form()) return false;
			        
			    var formData = new FormData(this);
			    formData.append('btnSave_Date',true);

			    var l = Ladda.create(document.querySelector('#btnSave_Date'));
			    l.start();

			    $.ajax({
			        url: "mypro_function/function.php",
			        type: "POST",
			        data: formData,
			        contentType: false,
			        processData:false,
			        cache: false,
			        success: function(response) {
			            if ($.trim(response)) {
			                msg = "Updated Sucessfully!";
			                var obj = jQuery.parseJSON(response);

			                if (obj.type == 1) {
			                	$('#tr_'+obj.path+'_'+obj.ID+' > td:last-child').html(obj.date);
			                } else {
			                	$('#tr_'+obj.path+'_'+obj.ID+' > td:nth-last-child(2)').html(obj.date);
			                }

			                $('#modalDateSelect').modal('hide');
			            } else {
			                msg = "Error!"
			            }
			            l.stop();
			            bootstrapGrowl(msg);
			        }
			    });
			}));

			// for My Task 
			$(document).ready(function(){
				
			    // calendar
			    var calendar = $('#calendar_data').fullCalendar({
			        editable:true,
			        header:{
			            left:'prev,next today',
			            center:'title',
			            right:'month,agendaWeek,agendaDay'
			        },
			        events:'mypro_function/fetch_calendar.php',
			        editable:true,
			        eventDrop:function(event){
			    
			            var start = event.start.toISOString();
			            var end = event.end.toISOString();
			            var title = event.title;
			            var id = event.id;
			            $.ajax({
			                url:"mypro_function/update-task-calendar.php",
			                type:"POST",
			                data:{
			                    title:title,
			                    start:start,
			                    end:end,
			                    id:id
			                },
			                success:function(data){
			                    calendar.fullCalendar('refetchEvents');
			                }
			            });
			            
			        },
			        eventClick:  function(event) {
			             // jQuery.noConflict();
			            var id = event.id;
			            $.ajax({
			                type: "GET",
			                url: "mypro_function/calendar_event_click.php?postId="+id,
			                dataType: "html",
			                success: function(data){
			                    $("#calendarModal .modal-body").html(data);
			                    $('#calendarModal').modal('show');
			                    selectMulti();
			                }
			            });
			            $('#calendarModal').modal('show');
			        },
			    });
			    //filter
			    function filter_data() {
			        var stat = get_filter('status');
			         //alert("MyPro.php?status="+stat+" #tblAssignTask");
			        $("#tblAssignTask").load("MyPro.php?status="+stat+" #tblAssignTask");
			    }
			    
			    function filter_data_all() {
			        $("#tblAssignTask").load("MyPro.php #tblAssignTask");
			    }
			    
			    function get_filter(class_name) {
			        var filter = [];
			        $('.'+class_name+':checked').each(function(){
			            filter.push($(this).val());
			        });
			        return filter;
			    }

			    $('.common_selector').click(function(){
			        filter_data();
			    });
			    // view all
			    $('.common_selector_all').click(function(){
			        filter_data_all();
			    });
			    
			    $('#dataTable_Arcive, #tableData_All, #tableData_Daily, #tableData_Weekly, #tableData_Monthly, #tableData_Overdue, #tableData_Completed, #tableData_Proj').dataTable();


			    highchart_pending();
			    highchart_completed(null);
			});

			// Edit on calendar modal
			$(".calendarModal").on('submit',(function(e) {
			    e.preventDefault();
			    formObj = $(this);
			    if (!formObj.validate().form()) return false;
			        
			    var formData = new FormData(this);
			    formData.append('btnSubmit_calendar',true);

			    var l = Ladda.create(document.querySelector('#btnSubmit_calendar'));
			    l.start();

			    $.ajax({
			        url: "mypro_function/action.php",
			        type: "POST",
			        data: formData,
			        contentType: false,
			        processData:false,
			        cache: false,
			        success: function(response) {
			            if ($.trim(response)) {
			                // console.log(response);
			                msg = "Updated Sucessfully!";
			                $('#get_calendar_data').empty();
			                $('#get_calendar_data').append(response);
			                selectMulti();
			                //  $('#calendarModal').modal('hide');
			            } else {
			                msg = "Error!"
			            }
			            l.stop();
			            bootstrapGrowl(msg);
			        }
			    });
			}));

			// add event modal
			$(".addNew_payroll_periods").on('submit',(function(e) {
			    e.preventDefault();
			    formObj = $(this);
			    if (!formObj.validate().form()) return false;
			        
			    var formData = new FormData(this);
			    formData.append('btnAdd_payroll_periods',true);

			    var l = Ladda.create(document.querySelector('#btnAdd_payroll_periods'));
			    l.start();

			    $.ajax({
			        url: "mypro_function/action.php",
			        type: "POST",
			        data: formData,
			        contentType: false,
			        processData:false,
			        cache: false,
			        success: function(response) {
			            if ($.trim(response)) {
			                // console.log(response);
			                msg = "Added Sucessfully!";
			                location.reload();
			            } else {
			                msg = "Error!"
			            }
			            l.stop();
			            bootstrapGrowl(msg);
			        }
			    });
			}));

			// PROJECT SECTION
			$(".addNew").on('submit',(function(e) {
			    e.preventDefault();
			    formObj = $(this);
			    if (!formObj.validate().form()) return false;
			        
			    var formData = new FormData(this);
			    formData.append('btnCreate_Project',true);

			    var l = Ladda.create(document.querySelector('#btnCreate_Project'));
			    l.start();

			    $.ajax({
			        url: "mypro_function/function.php",
			        type: "POST",
			        data: formData,
			        contentType: false,
			        processData:false,
			        cache: false,
			        success: function(response) {
			            if ($.trim(response)) {
			                // console.log(response);
			                msg = "Added Sucessfully!";
			                $('#project_data').append(response);
			                $('#addNew').modal('hide');
			            } else {
			                msg = "Error!"
			            }
			            l.stop();
			            bootstrapGrowl(msg);
			        }
			    });
			}));
			$(".modalEdit_Project").on('submit',(function(e) {
			    e.preventDefault();
			    formObj = $(this);
			    if (!formObj.validate().form()) return false;
			        
			    var formData = new FormData(this);
			    formData.append('btnUpdate_Project',true);

			    var l = Ladda.create(document.querySelector('#btnUpdate_Project'));
			    l.start();

			    $.ajax({
			        url: "mypro_function/function.php",
			        type: "POST",
			        data: formData,
			        contentType: false,
			        processData:false,
			        cache: false,
			        success: function(response) {
			            if ($.trim(response)) {
			                msg = "Save Sucessfully!";
			                var obj = jQuery.parseJSON(response);
			                
			                $('#project_data #project_'+obj.ID).html(obj.data);
			                $('#modalEdit_Project').modal('hide');
			            } else {
			                msg = "Error!"
			            }
			            l.stop();
			            bootstrapGrowl(msg);
			        }
			    });
			}));
			
			// EXTRA COLLAB
			function btnModalAccess(page) {
                $.ajax({
                    type: "GET",
                    url: "mypro_function/function.php?btnModalAccess="+page,
                    dataType: "html",
                    success: function(data){
                        $("#modalAccess .modal-body").html(data);
                        selectMulti();
                    }
                });
			}
			$(".modalAccess").on('submit',(function(e) {
			    e.preventDefault();
			    formObj = $(this);
			    if (!formObj.validate().form()) return false;
			        
			    var formData = new FormData(this);
			    formData.append('btnSave_Access',true);

			    var l = Ladda.create(document.querySelector('#btnSave_Access'));
			    l.start();

			    $.ajax({
			        url: "mypro_function/function.php",
			        type: "POST",
			        data: formData,
			        contentType: false,
			        processData:false,
			        cache: false,
			        success: function(response) {
			            if ($.trim(response)) {
			                // console.log(response);
			                msg = "Added Sucessfully!";
			                $('#modalAccess').modal('hide');
			            } else {
			                msg = "Error!"
			            }
			            l.stop();
			            bootstrapGrowl(msg);
			        }
			    });
			}));
		</script>
	</body>
</html>
