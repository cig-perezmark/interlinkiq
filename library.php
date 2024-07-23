<?php 
    $title = "Library";
    $site = "library";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {
        position: relative;
    }
</style>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="portlet light portlet-fit">
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Department / Area</th>
                                                    <th>No. of Template</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $result = mysqli_query( $conn,"SELECT * FROM tbl_lib_department ORDER BY name" );
                                                    if ( mysqli_num_rows($result) > 0 ) {
                                                        while($row = mysqli_fetch_array($result)) {
                                                            $ID = htmlentities($row['ID'] ?? '');
                                                            $name = htmlentities($row['name'] ?? '');
                                                            $records = 0;

                                                            $selectEForm = mysqli_query( $conn,'SELECT * FROM tbl_lib WHERE department_id="'. $ID .'"' );
                                                            if ( mysqli_num_rows($selectEForm) > 0 ) {
                                                                while($row = mysqli_fetch_array($selectEForm)) {
                                                                    $records++;
                                                                }
                                                            }

                                                            if ($records > 0) {
                                                                echo '<tr id="tr_'. $ID .'" onclick="btnViewDepartment('. $ID .', '.$FreeAccess.')">
                                                                    <td>'. $name .'</td>
                                                                    <td>'. $records .'</td>
                                                                </tr>';
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php echo '<button class="btn btn-success hide" id="tableDataViewAll" onclick="btnViewDepartmentViewAll('.$switch_user_id.', '.$FreeAccess.')">View All</button>'; ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="portlet light portlet-fit">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-folder font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Template List</span>
                                    </div>
                                    <?php
                                        if($switch_user_id == 34 || $switch_user_id == 163) {
                                            echo '<div class="actions">
                                                <div class="btn-group">
                                                    <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a data-toggle="modal" href="'; echo $FreeAccess == false ? '#modalNew':'#modalService'; echo '" >Add New Library</a>
                                                        </li>
                                                        <li class="divider"> </li>
                                                        <li>
                                                            <a href="javascript:;">Option 2</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">Option 3</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">Option 4</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>';
                                        }
                                    ?>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable" style="border: 0;">
                                        <table class="table table-bordered table-hover" id="tableData">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th class="text-center" style="width: 135px;">Document Date</th>
                                                    <th style="width: 135px;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $result = mysqli_query( $conn,"SELECT ID, record, files_date FROM tbl_lib ORDER BY files_date DESC" );
                                                    if ( mysqli_num_rows($result) > 0 ) {
                                                        while($row = mysqli_fetch_array($result)) {
                                                            $ID = htmlentities($row['ID'] ?? '');
                                                            $record = htmlentities($row['record'] ?? '');
                                                            $files_date = htmlentities($row['files_date'] ?? '');

                                                            echo '<tr id="tr_'. $ID .'">
                                                                <td>'. $record .'</td>
                                                                <td class="text-center">'. $files_date .'</td>
                                                                <td class="text-center">';

                                                                    if ($FreeAccess == false && $switch_user_id == 34) {
                                                                        echo '<div class="btn-group btn-group-circle">
                                                                            <a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('. $ID.')">Edit</a>
                                                                            <a href="#modalViewFile" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnView('. $ID .', '.$FreeAccess.')">View</a>
                                                                            <a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('.$ID.')">Delete</a>
                                                                        </div>';
                                                                    } else {
                                                                        echo '<div class="btn-group btn-group-circle">
                                                                            <a href="#modalViewFile" class="btn btn-success btn-sm btnView btn-circle" data-toggle="modal" onclick="btnView('. $ID .', '.$FreeAccess.')">View</a>
                                                                            <a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('.$ID.')">Delete</a>
                                                                        </div>';
                                                                    }

                                                                echo '</td>
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

                        <!-- MODAL SERVICE -->
                        <div class="modal fade" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalNew">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Library</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Department / Area</label>
                                                        <select class="form-control select2" name="department_id" onchange="changeDepartment(this, 1)" style="width: 100%;">
                                                            <option value="">Select</option>
                                                            <?php
                                                                $result = mysqli_query($conn,"SELECT 
                                                                    d.ID AS d_ID,
                                                                    d.name AS d_name
                                                                    FROM tbl_lib_department AS d

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_lib
                                                                    ) AS l
                                                                    ON l.department_id = d.ID

                                                                    WHERE l.user_id = $switch_user_id

                                                                    GROUP BY d.name

                                                                    ORDER BY d.name");
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $ID = $row['d_ID'];
                                                                    $name = htmlentities($row['d_name'] ?? '');
                                                                    echo '<option value="'. $ID .'">'. $name .'</option>';
                                                                }
                                                            ?>
                                                            <option value="other">Other</option>
                                                        </select>
                                                        <input type="text" class="form-control margin-top-15 display-none" name="department_id_other" id="department_id_other_1" placeholder="Specify others" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Name</label>
                                                        <input type="type" class="form-control" name="record" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Upload Document</label>
                                                        <select class="form-control" name="filetype" onchange="changeType(this)" required>
                                                            <option value="0">Select option</option>
                                                            <option value="1">Manual Upload</option>
                                                            <option value="2">Youtube URL</option>
                                                            <option value="3">Google Drive URL</option>
                                                            <option value="4">Sharepoint URL</option>
                                                        </select>
                                                        <input class="form-control margin-top-15 fileUpload" type="file" name="file" style="display: none;" />
                                                        <input class="form-control margin-top-15 fileURL" type="url" name="fileurl" style="display: none;" placeholder="https://" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="ccontrol-label">Document Date</label>
                                                        <input class="form-control" type="date" name="file_date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Description</label>
                                                <textarea class="form-control" name="description" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Comment/Notes</label>
                                                <textarea class="form-control" name="notes" placeholder="Write some comment or notes here" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_library" id="btnSave_library" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Library</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_library" id="btnUpdate_library" data-style="zoom-out"><span class="ladda-label">Save</span></button>
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
                                        <h4 class="modal-title">Library</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>

        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $.fn.modal.Constructor.prototype.enforceFocus = function() {};

                $('.select2').select2();

                fancyBoxes();
                $('#tableData').DataTable();
            });

            function uploadNew(e) {
                $(e).parent().hide();
                $(e).parent().parent().find('select').removeClass('hide');
            }
            function changeType(e) {
                $(e).parent().find('input').hide();
                $(e).parent().find('input').prop('required',false);
                if($(e).val() == 1) {
                    $(e).parent().find('.fileUpload').show();
                    $(e).parent().find('.fileUpload').prop('required',true);
                } else if($(e).val() == 2 || $(e).val() == 3 || $(e).val() == 4) {
                    $(e).parent().find('.fileURL').show();
                    $(e).parent().find('.fileURL').prop('required',true);
                }
            }

            function btnEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_library="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                        $('.select2').select2();
                        selectMulti();
                    }
                });
            }
            function btnView(id, freeaccess) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewFile_library="+id+"&freeaccess="+freeaccess,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewFile .modal-body").html(data);
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
                        url: "function.php?btnDelete_Library="+id,
                        dataType: "html",
                        success: function(response){
                            $('tbody #tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            function btnViewDepartment(id, freeaccess) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewDepartment_library="+id+"&freeaccess="+freeaccess,
                    dataType: "html",
                    success: function(data){
                        $('#tableDataViewAll').removeClass('hide');
                        $("#tableData tbody").html(data);
                    }
                });
            }
            function btnViewDepartmentViewAll(id, freeaccess) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewDepartmentViewAll_library="+id+"&freeaccess="+freeaccess,
                    dataType: "html",
                    success: function(data){
                        $('#tableDataViewAll').addClass('hide');
                        $("#tableData tbody").html(data);
                    }
                });
            }
            function changeDepartment(id, modal) {
                if (id.value == "other") {
                    $('#department_id_other_'+modal).show();
                } else {
                    $('#department_id_other_'+modal).hide();
                }
            }

            $(".modalNew").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_library',true);

                var l = Ladda.create(document.querySelector('#btnSave_library'));
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
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            var result = '<tr id="tr_'+obj.ID+'">';
                                result += '<td>'+obj.record+'</td>';
                                result += '<td class="text-center">'+obj.files_date+'</td>';
                                result += '<td class="text-center">';
                                    result += '<div class="btn-group btn-group-circle">';
                                        result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('+obj.ID+')">Edit</a>';
                                        result += '<a href="#modalViewFile" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                        result += '<a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                    result += '</div>';
                                result += '</td>';
                            result += '</tr>';

                            $("#tableData tbody").prepend(result);
                            $('#modalNew').modal('hide');
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
                formData.append('btnUpdate_library',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_library'));
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
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            var result = '<td>'+obj.record+'</td>';
                            result += '<td class="text-center">'+obj.files_date+'</td>';
                            result += '<td class="text-center">';
                                result += '<div class="btn-group btn-group-circle">';
                                    result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('+obj.ID+')">Edit</a>';
                                    result += '<a href="#modalViewFile" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                    result += '<a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                result += '</div>';
                            result += '</td>';

                            $("#tableData tbody #tr_"+obj.ID).html(result);
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