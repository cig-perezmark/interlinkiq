<?php 
    $title = "Archive";
    $site = "archive";
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
                                                    <th>No. of Files</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $result = mysqli_query( $conn,"SELECT * FROM tbl_archiving_department ORDER BY name" );
                                                    if ( mysqli_num_rows($result) > 0 ) {
                                                        while($row = mysqli_fetch_array($result)) {
                                                            $ID = $row['ID'];
                                                            $name = $row['name'];
                                                            $records = 0;

                                                            $selectEForm = mysqli_query( $conn,'SELECT * FROM tbl_archiving WHERE user_id="'.$switch_user_id.'" AND department_id="'. $ID .'"' );
                                                            if ( mysqli_num_rows($selectEForm) > 0 ) {
                                                                while($row = mysqli_fetch_array($selectEForm)) {
                                                                    $records++;
                                                                }
                                                            }

                                                            if ($records > 0) {
                                                                echo '<tr id="tr_'. $ID .'" onclick="btnViewDepartment('. $ID .', '.$FreeAccess.')">
                                                                    <td>'. htmlentities($name) .'</td>
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
                                        <i class="icon-folder-alt font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Archived Records</span>
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
                                                    
                                                    if ($type_id == 0) {
                                                		echo ' - <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'"><i class="fa '. $file_extension .'"></i> '.$file_title.'</a>';
                                                	} else {
                                                		echo ' - <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox><i class="fa fa-youtube"></i> '.$file_title.'</a>';
                                                	}
	                                            }
                                            }
                                        ?>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="<?php echo $FreeAccess == false ? '#modalNew':'#modalService'; ?>" >Add New Archiving</a>
                                                </li>
                                                <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163): ?>
                                                    <li>
                                                        <a data-toggle="modal" data-target="#modalInstruction" onclick="btnInstruction()">Add New Instruction</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
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
                                                    $result = mysqli_query( $conn,"SELECT * FROM tbl_archiving WHERE user_id=$switch_user_id ORDER BY files_date DESC" );
                                                    if ( mysqli_num_rows($result) > 0 ) {
                                                        while($row = mysqli_fetch_array($result)) {
                                                            $ID = $row['ID'];
                                                            $record = $row['record'];
                                                            $files_date = $row['files_date'];

                                                            echo '<tr id="tr_'. $ID .'">
                                                                <td>'. htmlentities($record) .'</td>
                                                                <td class="text-center">'. $files_date .'</td>
                                                                <td class="text-center">';
                                                                
                                                                    if ($FreeAccess == false) {
                                                                        echo '<div class="btn-group btn-group-circle">
                                                                            <a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('. $ID.')">Edit</a>
                                                                            <a href="#modalViewFile" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnView('. $ID .', '.$FreeAccess.')">View</a>
                                                                        </div>';
                                                                    } else {
                                                                        echo '<a href="#modalViewFile" class="btn btn-success btn-sm btnView btn-circle" data-toggle="modal" onclick="btnView('. $ID .', '.$FreeAccess.')">View</a>';
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
                                            <h4 class="modal-title">Archive</h4>
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
                                                                    FROM tbl_archiving_department AS d

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_archiving
                                                                    ) AS a
                                                                    ON a.department_id = d.ID

                                                                    WHERE a.user_id = $switch_user_id

                                                                    GROUP BY d.name

                                                                    ORDER BY d.name");
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $ID = $row['d_ID'];
                                                                    $name = $row['d_name'];
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
                                            <button type="submit" class="btn green ladda-button" name="btnSave_archiving" id="btnSave_archiving" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
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
                                            <h4 class="modal-title">Archive</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_archiving" id="btnUpdate_archiving" data-style="zoom-out"><span class="ladda-label">Save</span></button>
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
                                        <h4 class="modal-title">Archive</h4>
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
                } else if($(e).val() == 2 || $(e).val() == 3) {
                    $(e).parent().find('.fileURL').show();
                    $(e).parent().find('.fileURL').prop('required',true);
                }
            }

            function btnEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_archiving="+id,
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
                    url: "function.php?modalViewFile_archiving="+id+"&freeaccess="+freeaccess,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewFile .modal-body").html(data);
                    }
                });
            }
            function btnViewDepartment(id, freeaccess) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewDepartment_archiving="+id+"&freeaccess="+freeaccess,
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
                    url: "function.php?modalViewDepartmentViewAll_archiving="+id+"&freeaccess="+freeaccess,
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
                formData.append('btnSave_archiving',true);

                var l = Ladda.create(document.querySelector('#btnSave_archiving'));
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
                formData.append('btnUpdate_archiving',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_archiving'));
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