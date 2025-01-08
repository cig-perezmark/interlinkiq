<?php 
    $title = "Quiz";
    $site = "quiz";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'HR';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-directions font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Comprehension Quiz</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#modalNew" onclick="btnReset('modalNew')" > Add New Quiz</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered table-hover" id="tableData">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th style="width: 80px;" class="text-center">Status</th>
                                                    <th style="width: 150px;" class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $result = mysqli_query( $conn,"SELECT ID, title, status FROM tbl_hr_quiz_set WHERE deleted = 0 AND user_id = $switch_user_id AND facility_switch = $facility_switch_user_id ORDER BY title" );
                                                    if ( mysqli_num_rows($result) > 0 ) {
                                                        $table_counter = 1;
                                                        while($row = mysqli_fetch_array($result)) {
                                                            echo '<tr id="tr_'. $row["ID"] .'">
                                                                <td>'. htmlentities($row["title"] ?? '') .'</td>
                                                                <td class="text-center">';

                                                                    if ( $row["status"] == 0 ) {
                                                                        echo '<span class="label label-sm label-danger">Inactive</span>';
                                                                    } else if ( $row["status"] == 1 ) {
                                                                        echo '<span class="label label-sm label-success">Active</span>';
                                                                    }
                                                                
                                                                echo '</td>
                                                                <td class="text-center">
                                                                    <a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('. $row["ID"].')">View</a>
                                                                    <a class="btn btn-danger red" onclick="btnDelete_Q('. $row["ID"].', this)">Delete</a>
                                                                </td>
                                                            </tr>';
                                                        }
                                                    } else {
                                                        echo '<tr class="text-center text-default"><td colspan="5">Empty Record</td></tr>';
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- END BORDERED TABLE PORTLET-->
                        </div>

                        <!-- MODAL AREA-->
                        <div class="modal fade" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalSave">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Quiz Form</h4>
                                        </div>
                                        <div class="modal-body"> 
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Title</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="title" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Language</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="language" required>
                                                        <option value="0">English</option>
                                                        <option value="1">English - Spanish</option>
                                                        <option value="2">English - Arabic</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Add Question</label>
                                                <div class="col-md-8">
                                                    <a href="#modalNew_HR_Quiz" data-toggle="modal" class="btn green" onclick="btnNew_Quiz(1)">Create</a>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Status</label>
                                                <div class="col-md-8">
                                                    <input type="checkbox" class="make-switch" name="status" data-on-text="Active" data-off-text="Inactive" data-on-color="success" data-off-color="danger" checked />
                                                </div>
                                            </div>

                                            <div class="table-scrollable">
                                                <table class="table table-bordered table-hover" id="tableData_Quiz_1">
                                                    <thead>
                                                        <tr>
                                                            <th>Item</th>
                                                            <th class="text-center" style="width: 80px;">Answer</th>
                                                            <th class="text-center" style="width: 135px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_HR_QuizSet" id="btnSave_HR_QuizSet" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-modal-lg" id="modalView" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Edit Quiz Form</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_HR_QuizSet" id="btnUpdate_HR_QuizSet" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade bs-modal-lg" id="modalNew_HR_Quiz" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalNew_HR_Quiz">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Create Question</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_HR_Quiz" id="btnSave_HR_Quiz" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-modal-lg" id="modalUpdate_HR_Quiz" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalUpdate_HR_Quiz">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Update Question</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_HR_Quiz" id="btnUpdate_HR_Quiz" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- / END MODAL AREA -->

                    </div><!-- END CONTENT BODY --> 

        <?php include_once ('footer.php'); ?>

        <script type="text/javascript">
            function repeaterForm() {
                var FormRepeater=function(){
                    return{
                        init:function(){
                            $(".mt-repeater").each(function(){
                                $(this).repeater({
                                    show:function(){
                                        $(this).slideDown();
                                        selectOptions();
                                    },
                                    hide:function(e){
                                        let text = "Are you sure you want to delete this row?";
                                        if (confirm(text) == true) {
                                            $(this).slideUp(e);
                                            setTimeout(function() { 
                                                selectOptions();
                                            }, 500);
                                        }
                                    },
                                    ready:function(e){}
                                })
                            })
                        }
                    }
                }();
                jQuery(document).ready(function(){FormRepeater.init()});
            }
            function selectOptions() {
                var countOption = $(".mt-repeater > div > div").length;
                var result = '';
                if (countOption > 0) {
                    for(var i=0; i<countOption; i++) {
                        var alphabet = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"]

                        result += '<option value="'+i+'">'+alphabet[i]+'</option>';
                    }
                } else {
                    result = '<option value="">Empty Data</option>';
                }

                $('#answer').html(result);
            }
            function btnReset(view) {
                $('#'+view+' form')[0].reset();
                $('#'+view+' form table tbody').html('');
            }

            function btnView(id) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalEdit_HR_QuizSet="+id,             
                    dataType: "html",                  
                    success: function(data){                    
                        $("#modalView .modal-body").html(data);
                        $(".make-switch").bootstrapSwitch();
                    }
                });
            }
            $(".modalSave").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_HR_QuizSet',true);

                var l = Ladda.create(document.querySelector('#btnSave_HR_QuizSet'));
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
                            var result = '<tr id="tr_'+obj.ID+'">';
                                result += '<td>'+obj.title+'</td>';
                                result += '<td class="text-center">';

                                    if ( obj.status == 0 ) { result += '<span class="label label-sm label-danger">Inactive</span>'; } 
                                    else if ( obj.status == 1 ) { result += '<span class="label label-sm label-success">Active</span>'; }
                                
                                result += '</td>';
                                result += '<td class="text-center">';
                                    result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                    result += '<a class="btn btn-danger red btn-sm" onclick="btnDelete_Q('+obj.ID+', this)">Delete</a>';
                                result += '</td>';
                            result += '</tr>';

                            $('#tableData tbody').append(result);
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            $(".modalUpdate").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_HR_QuizSet',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_HR_QuizSet'));
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
                            var result = '<td>'+obj.title+'</td>';
                            result += '<td class="text-center">';

                                if ( obj.status == 0 ) { result += '<span class="label label-sm label-danger">Inactive</span>'; } 
                                else if ( obj.status == 1 ) { result += '<span class="label label-sm label-success">Active</span>'; }
                            
                            result += '</td>';
                            result += '<td class="text-center">';
                                result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                result += '<a class="btn btn-danger red btn-sm" onclick="btnDelete_Q('+obj.ID+', this)">Delete</a>';
                            result += '</td>';

                            $('#tableData tbody #tr_'+obj.ID).html(result);
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));

            function btnNew_Quiz(modal) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNew_HR_Quiz="+modal,
                    dataType: "html",
                    success: function(data){
                        $("#modalNew_HR_Quiz .modal-body").html(data);
                        repeaterForm();
                    }
                });
            }
            $(".modalNew_HR_Quiz").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_HR_Quiz',true);

                var l = Ladda.create(document.querySelector('#btnSave_HR_Quiz'));
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
                            var result = '<tr id="tr_'+obj.ID+'">';
                                result += '<td><strong>'+obj.question+'</strong><br>'+obj.choices+'</td>';
                                result += '<td class="text-center">'+obj.answer+'</td>';
                                result += '<td class="text-center">';
                                    result += '<input class="form-control" type="hidden" name="item[]" value="'+obj.ID+'" />';
                                    result += '<div class="btn-group btn-group-circle">';
                                        result += '<a href="#modalUpdate_HR_Quiz" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnEdit_Quiz('+obj.ID+', '+obj.modal+')">Edit</a>';
                                        result += '<a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnDelete_Quiz('+obj.ID+', '+obj.modal+')">Delete</a>';
                                    result += '</div>';
                                result += '</td>';
                            result += '</tr>';

                            $('#tableData_Quiz_'+obj.modal+' tbody').append(result);
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnEdit_Quiz(id, modal) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalEdit_HR_Quiz="+id+"&m="+modal,
                    dataType: "html",
                    success: function(data){
                        $("#modalUpdate_HR_Quiz .modal-body").html(data);
                        repeaterForm();
                    }
                });
            }
            $(".modalUpdate_HR_Quiz").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_HR_Quiz',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_HR_Quiz'));
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
                            var result = '<td><strong>'+obj.question+'</strong><br>'+obj.choices+'</td>';
                            result += '<td class="text-center">'+obj.answer+'</td>';
                            result += '<td class="text-center">';
                                result += '<input class="form-control" type="hidden" name="item[]" value="'+obj.ID+'" />';
                                result += '<div class="btn-group btn-group-circle">';
                                    result += '<a href="#modalUpdate_HR_Quiz" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnEdit_Quiz('+obj.ID+', '+obj.modal+')">Edit</a>';
                                    result += '<a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnDelete_Quiz('+obj.ID+', '+obj.modal+')">Delete</a>';
                                result += '</div>';
                            result += '</td>';

                            $('#tableData_Quiz_'+obj.modal+' tbody #tr_'+obj.ID).html(result);
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnDelete_Quiz(id, modal) {
                swal({
                    title: "Are you sure?",
                    text: "Write some reason on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Reason"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_Quiz="+id+"&reason="+inputValue,
                        dataType: "html",
                        success: function(response){
                            $('#tableData_Quiz_'+modal+' tbody #tr_'+id).remove();
                        }
                    });
                    swal("Notification Sent!", "You wrote: " + inputValue, "success");
                });
            }
            function btnDelete_Q(id, e) {
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
                        url: "function.php?btnDelete_Q="+id,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
        </script>
    </body>
</html>