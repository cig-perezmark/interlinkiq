<?php 
    $title = "Service";
    $site = "job-ticket-service";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Job Ticket Tracker';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    /* DataTable*/
    .dt-buttons {
        margin: unset !important;
        float: left !important;
        margin-left: 15px !important;
    }
    div.dt-button-collection .dt-button.active:after {
        position: absolute;
        top: 50%;
        margin-top: -10px;
        right: 1em;
        display: inline-block;
        content: "✓";
        color: inherit;
    }
    .table {
        width: 100% !important;
    }
    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {
        position: relative;
    }
    .table thead tr th {
        vertical-align: middle;
    }
</style>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-earphones-alt font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Services</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_actions_assigned" data-toggle="tab">List</a>
                                        </li>
                                        <li>
                                            <a href="#tab_actions_completed" data-toggle="tab">Completed</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_actions_assigned">
                                            <div class="table-scrollablex">
                                                <table class="table table-bordered table-hover" id="tableDataServicesAssigned">
                                                    <thead>
                                                        <tr>
                                                            <th>ID#</th>
                                                            <th>Category</th>
                                                            <th>Service</th>
                                                            <th>Contact Info</th>
                                                            <th style="width: 135px;" class="text-center">Date Requested</th>
                                                            <th style="width: 135px;" class="text-center">Desire Due Date</th>
                                                            <th style="width: 135px;" class="text-center">Status</th>
                                                            <th style="width: 135px;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            // $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 0 AND deleted = 0 AND user_id = $current_userID AND (assigned_to_id IS NOT NULL OR assigned_to_id != '')" );
                                                            // if ($current_userID == 1 OR $current_userID == 2 OR $current_userID == 19 OR $current_userID == 17 OR $current_userID == 185) { $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 0 AND deleted = 0" ); }
                                                            // else { $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 0 AND deleted = 0 AND FIND_IN_SET($current_userEmployeeID, REPLACE(assigned_to_id, ' ', ''))" ); }
                                                            
                                                            // $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 0 AND deleted = 0 AND user_id = $current_userID" );
                                                            
                                                            // $sql_custom = '';
                                                            // if ( !empty(menu('job-ticket', $current_userEmployerID, $current_userEmployeeID)) ) {
                                                            //     $sql_custom = " AND FIND_IN_SET($current_userEmployeeID, REPLACE(assigned_to_id, ' ', '')) ";
                                                            // }
                                                            // $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 0 AND deleted = 0 AND user_id != $current_userID $sql_custom " );
                                                            
                                                            $sql_custom = '';
                                                            if ($switch_user_id != 34) {
                                                                $sql_custom .= ' AND r.switch_user_id = '.$switch_user_id;
                                                            }
                                                            if ( !empty(menu('job-ticket', $current_userEmployerID, $current_userEmployeeID)) ) {
                                                                $sql_custom .= " AND FIND_IN_SET($current_userEmployeeID, REPLACE(r.s_assigned_to_id, ' ', '')) ";
                                                            }
                                                            $result = mysqli_query( $conn,"
                                                                SELECT
                                                                *
                                                                FROM (
                                                                    SELECT 
                                                                    s.ID AS s_ID,
                                                                    s.category AS s_category,
                                                                    s.title AS s_title,
                                                                    s.description AS s_description,
                                                                    s.contact AS s_contact,
                                                                    s.email AS s_email,
                                                                    s.files AS s_files,
                                                                    s.due_date AS s_due_date,
                                                                    s.last_modified AS s_last_modified,
                                                                    s.assigned_to_id AS s_assigned_to_id,
                                                                    s.type AS s_type,
                                                                    u.ID AS u_ID,
                                                                    u.employee_id AS u_employee_id,
                                                                    u.first_name AS u_first_name,
                                                                    e.user_id AS e_user_id,
                                                                    CASE WHEN LENGTH(e.user_id) > 0 THEN e.user_id ELSE u.ID END AS switch_user_id

                                                                    FROM tbl_services AS s

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_user
                                                                    ) AS u
                                                                    ON s.user_id = u.ID

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_hr_employee
                                                                    ) AS e
                                                                    ON u.employee_id = e.ID

                                                                    WHERE s.status = 0 
                                                                    AND s.deleted = 0
                                                                ) r
                                                                WHERE r.u_ID != $current_userID
                                                                $sql_custom
                                                            " );
                                                            
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $category_id = $row["s_category"];
                                                                    $category = array(
                                                                        0 => 'Others',
                                                                        1 => 'IT Services',
                                                                        2 => 'Technical Services',
                                                                        3 => 'Sales',
                                                                        4 => 'Request Demo',
                                                                        5 => 'Suggestion',
                                                                        6 => 'Problem',
                                                                        7 => 'Praise'
                                                                    );

                                                                    $status_id = $row["s_type"];
                                                                    $status = array(
                                                                        0 => '<span class="label label-sm label-info">Assigned</span>',
                                                                        1 => '<span class="label label-sm label-primary">On Queue</span>',
                                                                        2 => '<span class="label label-sm label-warning">On Going</span>',
                                                                        3 => '<span class="label label-sm label-success">Fixed</span>',
                                                                        4 => '<span class="label label-sm label-danger">Unresolved</span>'
                                                                    );
                                                                    
                                                                    $file_files = $row["s_files"];
                                                                    if (!empty($file_files)) {
                                                                        $fileExtension = fileExtension($file_files);
                                                                        $src = $fileExtension['src'];
                                                                        $embed = $fileExtension['embed'];
                                                                        $type = $fileExtension['type'];
                                                                        $file_extension = $fileExtension['file_extension'];
                                                                        $url = $base_url.'uploads/services/';
                                                                    }
                                                                    
                                                                    echo '<tr id="tr_'. $row["s_ID"] .'">
                                                                        <td>'. $row["s_ID"] .'</td>
                                                                        <td>'. $category[$category_id].'</td>
                                                                        <td>
                                                                            <p style="margin: 0;"><b>'. $row["s_title"] .'</b></p>
                                                                            <p style="margin: 0;">'. $row["s_description"] .'</p>';
                                                                            echo !empty($file_files) ? '<p style="margin: 0;">File: <a data-src="'.$src.$url.rawurlencode($file_files).$embed.'" data-fancybox data-type="'.$type.'">'. $file_files .'</a></p>' : '';
                                                                        echo '</td>
                                                                        <td>
                                                                            <p style="margin: 0;">'. $row["s_contact"] .'</p>
                                                                            <p style="margin: 0;"><a href="mailto:'. $row["s_email"] .'" target="_blank">'. $row["s_email"] .'</a></p>
                                                                        </td>
                                                                        <td class="text-center">'. $row["s_last_modified"] .'</td>
                                                                        <td class="text-center">'. $row["s_due_date"] .'</td>
                                                                        <td class="text-center">'; echo empty($row["s_assigned_to_id"]) ? 'Pending':$status[$status_id]; echo '</td>
                                                                        <td class="text-center">
                                                                            <div class="btn-group btn-group-circle">
                                                                                <a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-id="'. $row["s_ID"] .'" data-toggle="modal" onclick="btnView('. $row["s_ID"] .')">View</a>
                                                                                <a href="javascript:;" class="btn btn-outlinex green btn-sm btnDone" data-id="'. $row["s_ID"] .'" onclick="btnDone('. $row["s_ID"] .')">Done</a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                            } else {
                                                                echo '<tr class="text-center text-default"><td colspan="8">Empty Record</td></tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_actions_completed">
                                            <div class="table-scrollablex">
                                                <table class="table table-bordered table-hover" id="tableDataServicesComplete">
                                                    <thead>
                                                        <tr>
                                                            <th>ID#</th>
                                                            <th>Category</th>
                                                            <th>Service</th>
                                                            <th>Contact Info</th>
                                                            <th class="text-center" style="width: 135px;">Desire Due Date</th>
                                                            <th class="text-center" style="width: 135px;">Completed</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            // if ($current_userID == 1 OR $current_userID == 2 OR $current_userID == 19 OR $current_userID == 17 OR $current_userID == 185) { $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 1 AND deleted = 0" ); }
                                                            // else { $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 1 AND deleted = 0 AND FIND_IN_SET($current_userEmployeeID, REPLACE(assigned_to_id, ' ', ''))" ); }
                                                            
                                                            // $sql_custom = '';
                                                            // if ( !empty(menu('job-ticket', $current_userEmployerID, $current_userEmployeeID)) ) {
                                                            //     $sql_custom = " AND FIND_IN_SET($current_userEmployeeID, REPLACE(assigned_to_id, ' ', '')) ";
                                                            // }
                                                            // $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 1 AND deleted = 0 AND user_id != $current_userID $sql_custom " );
                                                            
                                                            $sql_custom = '';
                                                            if ($switch_user_id != 34) {
                                                                $sql_custom .= ' AND r.switch_user_id = '.$switch_user_id;
                                                            }
                                                            if ( !empty(menu('job-ticket', $current_userEmployerID, $current_userEmployeeID)) ) {
                                                                $sql_custom .= " AND FIND_IN_SET($current_userEmployeeID, REPLACE(r.s_assigned_to_id, ' ', '')) ";
                                                            }
                                                            $result = mysqli_query( $conn,"
                                                                SELECT
                                                                *
                                                                FROM (
                                                                    SELECT 
                                                                    s.ID AS s_ID,
                                                                    s.category AS s_category,
                                                                    s.title AS s_title,
                                                                    s.description AS s_description,
                                                                    s.contact AS s_contact,
                                                                    s.email AS s_email,
                                                                    s.files AS s_files,
                                                                    s.due_date AS s_due_date,
                                                                    s.last_modified AS s_last_modified,
                                                                    s.assigned_to_id AS s_assigned_to_id,
                                                                    s.type AS s_type,
                                                                    u.ID AS u_ID,
                                                                    u.employee_id AS u_employee_id,
                                                                    u.first_name AS u_first_name,
                                                                    e.user_id AS e_user_id,
                                                                    CASE WHEN LENGTH(e.user_id) > 0 THEN e.user_id ELSE u.ID END AS switch_user_id

                                                                    FROM tbl_services AS s

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_user
                                                                    ) AS u
                                                                    ON s.user_id = u.ID

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_hr_employee
                                                                    ) AS e
                                                                    ON u.employee_id = e.ID

                                                                    WHERE s.status = 1
                                                                    AND s.deleted = 0
                                                                ) r
                                                                WHERE r.u_ID != $current_userID
                                                                $sql_custom
                                                            " );
                                                            
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $category_id = $row["s_category"];
                                                                    $category = array(
                                                                        0 => 'Others',
                                                                        1 => 'IT Services',
                                                                        2 => 'Technical Services',
                                                                        3 => 'Sales',
                                                                        4 => 'Request Demo',
                                                                        5 => 'Suggestion',
                                                                        6 => 'Problem',
                                                                        7 => 'Praise'
                                                                    );

                                                                    $file_files = $row["s_files"];
                                                                    if (!empty($file_files)) {
                                                                        $fileExtension = fileExtension($file_files);
                                                                        $src = $fileExtension['src'];
                                                                        $embed = $fileExtension['embed'];
                                                                        $type = $fileExtension['type'];
                                                                        $file_extension = $fileExtension['file_extension'];
                                                                        $url = $base_url.'uploads/services/';
                                                                    }
                                                                    
                                                                    echo '<tr id="tr_'. $row["s_ID"] .'">
                                                                        <td>'. $row["s_ID"] .'</td>
                                                                        <td>'. $category[$category_id].'</td>
                                                                        <td>
                                                                            <p style="margin: 0;">'. $row["s_title"] .'</p>
                                                                            <p style="margin: 0;">'. $row["s_description"] .'</p>';
                                                                            echo !empty($file_files) ? '<p style="margin: 0;">File: <a data-src="'.$src.$url.rawurlencode($file_files).$embed.'" data-fancybox data-type="'.$type.'">'. $file_files .'</a></p>' : '';
                                                                        echo '</td>
                                                                        <td>
                                                                            <p style="margin: 0;">'. $row["s_contact"] .'</p>
                                                                            <p style="margin: 0;"><a href="mailto:'. $row["s_email"] .'" target="_blank">'. $row["s_email"] .'</a></p>
                                                                        </td>
                                                                        <td class="text-center">'. $row["s_due_date"] .'</td>
                                                                        <td class="text-center">'. $row["s_last_modified"] .'</td>
                                                                    </tr>';
                                                                }
                                                            } else {
                                                                echo '<tr class="text-center text-default"><td colspan="6">Empty Record</td></tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Service Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_Service" id="btnUpdate_Service" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>

        <script type="text/javascript">
            $(document).ready(function(){
                $('#tableDataServicesAssigned, #tableDataServicesComplete').DataTable({
                    dom: 'lBfrtip',
                    lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                    buttons: [
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'csv',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        'colvis'
                    ]
                });
            });
            
            function btnDone(id) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will move to Completed Tab!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDone="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tr_'+id).remove();
                            
                            var obj = jQuery.parseJSON(response);
                            var result = '<tr id="tr_'+obj.ID+'">';
                                result += '<td>'+obj.ID+'</td>';
                                result += '<td>'+obj.category+'</td>';
                                result += '<td>';
                                    result += '<p style="margin: 0;">'+obj.title+'</p>';
                                    result += '<p style="margin: 0;">'+obj.description+'</p>';

                                    if (obj.files != "") {
                                        result += '<p style="margin: 0;">'+obj.files+'</p>';
                                    }

                                result += '</td>';
                                result += '<td>';
                                    result += '<p style="margin: 0;">'+obj.contact+'</p>';
                                    result += '<p style="margin: 0;"><a href="mailto:'+obj.email+'" target="_blank">'+obj.email+'</a></p>';
                                result += '</td>';
                                result += '<td class="text-center">'+obj.due_date+'</td>';
                                result += '<td class="text-center">'+obj.last_modified+'</td>';
                            result += '</tr>';

                            $('#tab_actions_completed #tableDataServicesComplete tbody').append(result);
                        }
                    });
                    swal("Done!", "This item has been moved to Completed Tab.", "success");
                });
            }

            function btnView(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Services="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);

                        selectMulti();
                    }
                });
            }
            $(".modalUpdate").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Service',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Service'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                l.setProgress(percentComplete / 100);
                            }
                       }, false);
                       return xhr;
                    },
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            if (obj.assigned_to_id != '') {
                                
                                var obj = jQuery.parseJSON(response);
                                var html = '<td>'+obj.ID+'</td>';
                                html += '<td>'+obj.category+'</td>';
                                html += '<td>';
                                    html += '<p style="margin: 0;"><b>'+obj.title+'</b></p>';
                                    html += '<p style="margin: 0;">'+obj.description+'</p>';

                                    if (obj.files != "") { html += '<p style="margin: 0;">'+obj.files+'</p>'; }

                                html += '</td>';
                                html += '<td>';
                                    html += '<p style="margin: 0;">'+obj.contact+'</p>';
                                    html += '<p style="margin: 0;"><a href="mailto:'+obj.email+'" target="_blank">'+obj.email+'</a></p>';
                                html += '</td>';
                                html += '<td class="text-center">'+obj.last_modified+'</td>';
                                html += '<td class="text-center">'+obj.due_date+'</td>';
                                html += '<td class="text-center">'+obj.status+'</td>';
                                html += '<td class="text-center">';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-id="'+obj.ID+'" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                        html += '<a href="javascript:;" class="btn btn-outlinex green btn-sm btnDone" data-id="'+obj.ID+'" onclick="btnDone('+obj.ID+')">Done</a>';
                                    html += '</div>';
                                html += '</td>';

                                $('#tab_actions_assigned #tableDataServicesAssigned tbody #tr_'+obj.ID).html(html);
                            }
                            $('#modalView').modal('hide');
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