<?php 
    $title = "Listing";
    $site = "listing";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

<style>
    .modal .bs-select small {
        display: block;
    }
    .bootstrap-tagsinput { min-height: 100px; }
</style>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-briefcase font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Listing</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tabSpecialist" data-toggle="tab">Specialist</a>
                                        </li>
                                        <li>
                                            <a class="hide" href="#tabJob" data-toggle="tab">Jobs</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tabSpecialist">
                                            <table id="tableDataSpecialist" class="table table-bordered table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Availability</th>
                                                        <th>Preference</th>
                                                        <th class="text-center" style="width: 240px;">Status</th>
                                                        <th class="text-center" style="width: 135px;">Date</th>
                                                        <th class="text-center" style="width: 135px;">Action</th>
                                                        <th class="hide">Organization</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $selectJob = mysqli_query( $conn,"SELECT * FROM tbl_user_job ORDER BY ID DESC" );
                                                        if ( mysqli_num_rows($selectJob) > 0 ) {
                                                            while($rowJob = mysqli_fetch_array($selectJob)) {
                                                                $job_ID = $rowJob['ID'];
                                                                $job_user_id = $rowJob['user_id'];
                                                                $job_is_active = $rowJob['is_active'];
                                                                $job_last_modified = $rowJob['last_modified'];

                                                                $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $job_user_id" );
                                                                if ( mysqli_num_rows($selectUser) > 0 ) {
                                                                    $rowUser = mysqli_fetch_array($selectUser);
                                                                    $user_fullname = $rowUser['first_name'] .' '. $rowUser['last_name'];
                                                                }

                                                                $job_user_id_empr = employerID($job_user_id);
                                                                $selectUserEmpr = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $job_user_id_empr" );
                                                                if ( mysqli_num_rows($selectUserEmpr) > 0 ) {
                                                                    $rowUser = mysqli_fetch_array($selectUserEmpr);
                                                                    $user_fullname_empr = $rowUser['first_name'] .' '. $rowUser['last_name'];
                                                                }

                                                                $array_availability_data = array();
                                                                $array_availability = array(
                                                                    1 => 'Full-time',
                                                                    2 => 'Part-time',
                                                                    3 => 'Freelance',
                                                                    4 => 'Contract',
                                                                    5 => 'Remote'
                                                                );
                                                                if (!empty($rowJob['availability'])) {
                                                                    $job_availability = explode(', ', $rowJob['availability']);
                                                                    foreach($job_availability as $value) {
                                                                        array_push($array_availability_data, $array_availability[$value]);
                                                                    }
                                                                }
                                                                $array_availability_data = implode(', ', $array_availability_data);

                                                                $array_preference_data = array();
                                                                $array_preference = array(
                                                                    1 => 'On-Site',
                                                                    2 => 'Virtual',
                                                                    3 => 'Willing to Travel'
                                                                );
                                                                if (!empty($rowJob['preference'])) {
                                                                    $job_preference = explode(', ', $rowJob['preference']);
                                                                    foreach($job_preference as $value) {
                                                                        array_push($array_preference_data, $array_preference[$value]);
                                                                    }
                                                                }
                                                                $array_preference_data = implode(', ', $array_preference_data);

                                                                echo '<tr id="tr_'.$job_ID.'">
                                                                    <td>'.$user_fullname.'</td>
                                                                    <td>'.$array_availability_data.'</td>
                                                                    <td>'.$array_preference_data.'</td>
                                                                    <td class="text-center">'; echo $job_is_active == 1 ? 'Approved':'Unapproved'; echo '</td>
                                                                    <td class="text-center">'.$job_last_modified.'</td>
                                                                    <td class="text-center">
                                                                        <a href="#modalView" class="btn btn-success btn-sm btn-circle" data-toggle="modal" onclick="btnView('. $job_user_id .')">View</a>
                                                                    </td>
                                                                    <td class="hide">'.$user_fullname_empr.'</td>
                                                                </tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="7">Organization</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tabJob">
                                            <a href="#modalNew" class="btn btn-circle btn-success pull-right margin-bottom-15" data-toggle="modal" > Add New Job</a>
                                            <table class="table table-bordered table-hover" id="tableDataJob">
                                                <thead>
                                                    <tr>
                                                        <th>Job</th>
                                                        <th style="width: 135px;">Type</th>
                                                        <th style="width: 135px;">Date Posted</th>
                                                        <th style="width: 135px;">Applicants</th>
                                                        <th style="width: 135px;">Status</th>
                                                        <th style="width: 200px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $result = mysqli_query( $conn,"SELECT * FROM tbl_job_listing WHERE is_deleted=0 AND user_id=$current_userEmployerID" );
                                                        if ( mysqli_num_rows($result) > 0 ) {
                                                            while($row = mysqli_fetch_array($result)) {
                                                                $ID = $row['ID'];
                                                                $title = $row['title'];
                                                                $short_description = $row['short_description'];
                                                                $employment_type = $row['employment_type'];
                                                                $date_posted = $row['date_posted'];
                                                                $status = $row['status'];

                                                                echo '<tr id="tr_'. $ID .'">
                                                                    <td><b>'. $title .'</b><br><span class="text-muted">'. $short_description .'</span></td>
                                                                    <td>'. $employment_type .'</td>
                                                                    <td>'. $date_posted .'</td>
                                                                    <td>0</td>
                                                                    <td><input type="checkbox" class="make-switch" name="status" data-on-text="Open" data-off-text="Close" data-on-color="success" onchange="changedStatus(this, '. $ID .')" data-off-color="default" '; echo $status === "1" ? "checked" : "";  echo '></td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group btn-group-circle">
                                                                            <a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('. $ID.')">Edit</a>
                                                                            <a href="#modalViewFile" class="btn btn-success btn-sm btnPreview" data-toggle="modal" onclick="btnPreview('. $ID .')">Preview</a>
                                                                            <a href="javascript:;" class="btn btn-danger btn-sm btnDelete" data-toggle="modal" onclick="btnDelete('. $ID .')">Delete</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL AREA -->
                        <div class="modal fade" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalNew">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Job</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input class="form-control" type="hidden" name="ID" value="<?php echo $current_userEmployerID; ?>" />
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Job Title</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="title" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Short Description</label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" name="short_description" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Category</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="category" id="typeahead_category" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Employment Type</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="employment" required>
                                                        <option value="">Select</option>
                                                        <?php
                                                            $selectEmployment = mysqli_query( $conn,"SELECT * FROM tbl_job_employment" );
                                                            if ( mysqli_num_rows($selectEmployment) > 0 ) {
                                                                while($rowEmpoyment = mysqli_fetch_array($selectEmployment)) {
                                                                    $ID = $rowEmpoyment['ID'];
                                                                    $name = $rowEmpoyment['name'];

                                                                    echo '<option value="'.$ID.'">'.$name.'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Workplace Type</label>
                                                <div class="col-md-8">
                                                    <select class="form-control bs-select" name="workplace" required>
                                                        <?php
                                                            $selectWorkplace = mysqli_query( $conn,"SELECT * FROM tbl_job_workplace" );
                                                            if ( mysqli_num_rows($selectWorkplace) > 0 ) {
                                                                while($rowWorkplace = mysqli_fetch_array($selectWorkplace)) {
                                                                    $ID = $rowWorkplace['ID'];
                                                                    $name = $rowWorkplace['name'];
                                                                    $description = $rowWorkplace['description'];

                                                                    echo '<option value="'.$ID.'" data-subtext="'.$description.'">'.$name.'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Location</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="location" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Full Job Description</label>
                                                <div class="col-md-8">
                                                    <textarea class="summernote" name="long_description"></textarea>
                                                    <span class="text-muted">
                                                        Add a job description to pick out your future applicants<br><br>
                                                        or you may upload your document here
                                                    </span>
                                                    <input type="file" name="file" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Add skills/tags</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control tagsinput" name="skills" data-role="tagsinput" placeholder="Enter skill" required />
                                                    <span class="text-muted">
                                                        Include skill keywords to make your job post more visible<br>
                                                        (Hit enter to add new entry)
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Preview" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_JobListing" id="btnSave_JobListing" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalViewFile" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Records Verification Management</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalView">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Specialist Details</h4>
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

        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.bs-select').selectpicker();
                $('#typeahead_category').typeahead({
                    source: function (query, process) {
                        return $.get('function.php?job_cat=1', { query: query }, function (data) {
                            data = $.parseJSON(data);
                            return process(data);
                        });
                    },
                    showHintOnFocus:'all'
                });

                widget_summerNote()
                fancyBoxes();
                widget_inputTag();

                // $('#tableDataSpecialist').DataTable();
                $('#tableDataSpecialist').DataTable({
                    initComplete: function () {
                        this.api()
                            .columns()
                            .every(function () {
                                var column = this;
                                var select = $('<select><option value=""></option></select>')
                                    .appendTo($(column.footer()).empty())
                                    .on('change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
             
                                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                                    });
             
                                column
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function (d, j) {
                                        select.append('<option value="' + d + '">' + d + '</option>');
                                    });
                            });
                    },
                });
            });

            function changedStat(val, id) {
                var checked = val.checked
                var v = checked ? 1 : 0;

                $.ajax({
                    url: 'function.php?specialist_status='+id+'&v='+v,
                    dataType: "html",
                    success: function(data){
                        // alert(data);
                        // changedCompliant(parent_id);
                        var status = 'Unapproved';
                        if (v == 1) { status = 'Approved'; }
                        $('#tabSpecialist #tr_'+id+' > td:nth-child(4)').html(status);
                    }
                });
            }
            function btnView(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Specialist="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                        $(".make-switch").bootstrapSwitch();
                    }
                });
            }

            function changedStatus(val, id) {
                var checked = val.checked
                var v = checked ? 1 : 0;

                $.ajax({
                    url: 'function.php?job_status='+id+'&v='+v,
                    dataType: "html",
                    success: function(data){
                        alert(data);
                        // changedCompliant(parent_id);
                    }
                });
            }

            function widget_inputTag() {
                var ComponentsBootstrapTagsinput=function(){
                    var t=function(){
                        var t=$(".tagsinput");
                        t.tagsinput()
                    };
                    return{
                        init:function(){t()}
                    }
                }();
                jQuery(document).ready(function(){ComponentsBootstrapTagsinput.init()});
            }

            function widget_summerNote() {
                $('.summernote').summernote({
                    height: 300
                });
            }

            function btnEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_JobListing="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                        $('.select2').select2();
                        widget_inputTag();
                        widget_summerNote();
                    }
                });
            }

            function btnDelete(id) {
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
                        url: "function.php?btnDelete_JobListing="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tableData tbody #tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }

            $(".modalNew").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_JobListing',true);

                var l = Ladda.create(document.querySelector('#btnSave_JobListing'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            var result = '<tr id="tr_'+obj.ID+'">';
                                result += '<td><b>'+obj.title+'</b><br><span class="text-muted">'+obj.short_description+'</span></td>';
                                result += '<td>'+obj.employment+'</td>';
                                result += '<td>'+obj.date_posted+'</td>';
                                result += '<td>0</td>';
                                result += '<td><input type="checkbox" class="make-switch" name="status" data-on-text="Open" data-off-text="Close" data-on-color="success" onchange="changedStatus(this, '+obj.ID+')" data-off-color="default" checked></td>';
                                result += '<td class="text-center">';
                                    result += '<div class="btn-group btn-group-circle">';
                                        result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('+obj.ID+')">Edit</a>';
                                        result += '<a href="#modalViewFile" class="btn btn-success btn-sm btnPreiew" data-toggle="modal" onclick="btnPreiew('+obj.ID+')">Preview</a>';
                                        result += '<a href="#modalViewFile" class="btn btn-danger btn-sm btnDelete" data-toggle="modal" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                    result += '</div>';
                                result += '</td>';
                            result += '</tr>';

                            $("#tableData tbody").append(result);
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        $(".make-switch").bootstrapSwitch();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            $(".modalUpdate").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_JobListing',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_JobListing'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            var result = '<td><b>'+obj.title+'</b><br><span class="text-muted">'+obj.short_description+'</span></td>';
                            result += '<td>'+obj.employment+'</td>';
                            result += '<td>'+obj.date_posted+'</td>';
                            result += '<td>0</td>';
                            result += '<td><input type="checkbox" class="make-switch" name="status" data-on-text="Open" data-off-text="Close" data-on-color="success" onchange="changedStatus(this, '+obj.ID+')" data-off-color="default" '; result += (obj.status == 1) ? 'checked':''; result += '></td>';
                            result += '<td class="text-center">';
                                result += '<div class="btn-group btn-group-circle">';
                                    result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('+obj.ID+')">Edit</a>';
                                    result += '<a href="#modalViewFile" class="btn btn-success btn-sm btnPreiew" data-toggle="modal" onclick="btnPreiew('+obj.ID+')">Preview</a>';
                                    result += '<a href="#modalViewFile" class="btn btn-danger btn-sm btnDelete" data-toggle="modal" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                result += '</div>';
                            result += '</td>';

                            $("#tableData tbody #tr_"+obj.ID).html(result);
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        $(".make-switch").bootstrapSwitch();

                        bootstrapGrowl(msg);
                    }
                });
            }));
        </script>
    </body>
</html>