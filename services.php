<?php 
    $title = "Services";
    $site = "services";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light portlet-fit">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="icon-earphones-alt font-dark"></span>
                                        <span class="caption-subject font-dark bold uppercase">Services</span>
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
                                                    if (!empty($icon)) { 
                                                        if ($type_id == 0) {
                                                            echo ' <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'"><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                                        } else {
                                                            echo ' <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                                        }
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
                                                    <a data-toggle="modal" href="#modalNew" > Add New Service</a>
                                                </li>
                                                <li class="divider"> </li>
                                                <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163): ?>
                                                    <li>
                                                        <a data-toggle="modal" data-target="#modalInstruction" onclick="btnInstruction()">Add New Instruction</a>
                                                    </li>
                                                <?php endif; ?>
                                                <li>
                                                    <a href="javascript:;">Option 3</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">Option 4</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="table-scrollable">
                                            <table class="table table-bordered table-hover" id="tableData">
                                                <thead>
                                                    <tr>
                                                        <th>Service Category</th>
                                                        <th>Service Area</th>
                                                        <th>Description</th>
                                                        <th style="width: 135px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $result = mysqli_query( $conn,"
                                                            SELECT 
                                                            s.ID AS s_ID,
                                                            s.description AS s_description,
                                                            s.location AS s_location,
                                                            CASE WHEN s.category_id > 0 THEN c.service_category ELSE s.category_other END AS c_category,
                                                            CASE WHEN s.area_id > 0 THEN a.area_category ELSE s.area_other END AS a_category
                                                            FROM tbl_service AS s

                                                            LEFT JOIN (
                                                                SELECT
                                                                *
                                                                FROM tbl_service_category
                                                            ) AS c
                                                            ON s.category_id = c.id

                                                            LEFT JOIN (
                                                                SELECT
                                                                *
                                                                FROM tbl_service_area
                                                            ) AS a
                                                            ON s.area_id = a.id

                                                            WHERE s.is_deleted = 0
                                                            AND user_id = $switch_user_id
                                                        " );
                                                        if ( mysqli_num_rows($result) > 0 ) {
                                                            while($row = mysqli_fetch_array($result)) {
                                                                $ID = $row['s_ID'];
                                                                $description = htmlentities($row['s_description'] ?? '');
                                                                $location = htmlentities($row['s_location'] ?? '');
                                                                $category = htmlentities($row['c_category'] ?? '');
                                                                $area = htmlentities($row['a_category'] ?? '');
                                                                $file_files = htmlentities($row["files"] ?? '');

                                                                echo '<tr id="tr_'. $ID .'">
                                                                    <td>'. $category .'</td>
                                                                    <td>'. $area .'</td>
                                                                    <td>'. $description .'</td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group btn-group-circle">
                                                                            <a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('. $ID.')">View</a>
                                                                            <a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('. $ID .')">Delete</a>
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

                        <!-- MODAL SERVICE -->
                        <div class="modal fade" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalNew">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Service</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input class="form-control" type="hidden" name="count_file" value="1" />
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Service Category</label>
                                                <div class="col-md-8">
                                                    <select class="form-control select2" name="category" onchange="serviceCategory(this.value)" style="width: 100%;" required>
                                                        <option value="">Select</option>
                                                        <?php
                                                            $result = mysqli_query($conn,"SELECT * FROM tbl_service_category ORDER BY service_category ASC");
                                                            while($row = mysqli_fetch_array($result)) {
                                                                $ID = $row['id'];
                                                                $name = htmlentities($row['service_category'] ?? '');
                                                                echo '<option value="'. $ID .'">'. $name .'</option>';
                                                            }
                                                        ?>
                                                        <option value="others">Others</option>
                                                    </select>
                                                    <input type="text" class="form-control margin-top-15 hide category_other" name="category_other" placeholder="Please enter your category here" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Area</label>
                                                <div class="col-md-8 area"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Description of Service</label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" name="description" placeholder="Specialties" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Location of Service</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="location" placeholder="Remote, On-site, US Only, etc." required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Service Offering <p class="text-muted" style="margin: 0;"><small>(Brochure,Resume,Sample of Work, etc.)</small></p></label>
                                                <div class="col-md-8">
                                                    <div class="mt-repeater mt-repeater-file">
                                                        <div data-repeater-list="offering">
                                                            <div class="mt-repeater-item row" data-repeater-item>
                                                                <div class="col-md-10">
                                                                    <input class="form-control" type="file" name="file" />
                                                                </div>
                                                                <div class="col-md-2 text-right">
                                                                    <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add"><i class="fa fa-plus"></i> Add more</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_Servicess" id="btnSave_Servicess" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Service Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_Services" id="btnUpdate_Services" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!--Emjay modal-->
                        
                        <div class="modal fade" id="modal_video" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" action="controller.php">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Upload Demo Video</h4>
                                        </div>
                                        <div class="modal-body">
                                                <label>Video Title</label>
                                                <input type="text" id="file_title" name="file_title" class="form-control mt-2">
                                                <?php if($switch_user_id != ''): ?>
                                                    <input type="hidden" id="switch_user_id" name="switch_user_id" value="<?= $switch_user_id ?>">
                                                <?php else: ?>
                                                    <input type="hidden" id="switch_user_id" name="switch_user_id" value="<?= $current_userEmployerID ?>">
                                                <?php endif; ?>
                                                <label style="margin-top:15px">Video Link</label>
                                                <!--<input type="file" id="file" name="file" class="form-control mt-2">-->
                                                <input type="text" class="form-control" name="youtube_link">
                                                <input type="hidden" name="page" value="<?= $site ?>">

                                                <!--<label style="margin-top:15px">Privacy</label>-->
                                                <!--<select class="form-control" name="privacy" id="privacy" required>-->
                                                <!--    <option value="Private">Private</option>-->
                                                <!--    <option value="Public">Public</option>-->
                                                <!--</select>-->
                                            
                                            <div style="margin-top:15px" id="message">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success" name="save_video"><span id="save_video_text">Save</span></button>
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
                $.fn.modal.Constructor.prototype.enforceFocus = function() {};
                
                $('.select2').select2();

                repeaterForm('');
                serviceCategory();
                serviceArea();

                fancyBoxes();
                
                // Emjay script starts here
                $('#save_video').click(function(){
                $('#save_video').attr('disabled','disabled');
                $('#save_video_text').text("Uploading...");
                var action_data = "services";
                var user_id = $('#switch_user_id').val();
                var privacy = $('#privacy').val();
                var file_title = $('#file_title').val();
                
                 var fd = new FormData();
                 var files = $('#file')[0].files;
                 fd.append('file',files[0]);
                 fd.append('action_data',action_data);
                 fd.append('user_id',user_id);
                 fd.append('privacy',privacy);
                 fd.append('file_title',file_title);
    			    $.ajax({
        				method:"POST",
        				url:"controller.php",
        				data:fd,
        				processData: false, 
                        contentType: false,  
                        timeout: 6000000,
        				success:function(data){
        					console.log('done : ' + data);
        					if(data == 1){
        					    window.location.reload();
        					}
        					else{
        					    $('#message').html('<span class="text-danger">Invalid Video Format</span>');
        					}
        				}
    				});
    			});
    			
                // Emjay script ends here
            });

            function repeaterForm(modal) {
                if (modal == "") { modal = "modalNew"; }

                var FormRepeater=function(){
                    return{
                        init:function(){
                            $(".mt-repeater").each(function(){
                                $(this).repeater({
                                    show:function(){
                                        $(this).slideDown();
                                        count_file(modal);
                                    },
                                    hide:function(e){
                                        let text = "Are you sure you want to delete this row?";
                                        if (confirm(text) == true) {
                                            $(this).slideUp(e);
                                            setTimeout(function() { 
                                                count_file(modal)
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
            function count_file(modal) {
                var count_file = $("."+modal+" .mt-repeater-file > div > div").length;
                $('.modalForm [name="count_file"]').val(count_file);
            }
            function serviceCategory(val) {
                if (val == "others") {
                    $('.category_other').removeClass('hide');

                    $('.area select').addClass('hide');
                    $('.area_other').removeClass('hide');
                    $('.area_other').removeClass('margin-top-15');
                } else {
                    $('.category_other').addClass('hide');

                    $('.area select').removeClass('hide');
                    $('.area_other').addClass('hide');
                    $('.area_other').addClass('margin-top-15');

                    $.ajax({
                        type: "GET",
                        url: "function.php?modalView_Services_Category="+val,
                        dataType: "html",
                        success: function(data){
                            $(".modalForm .area").html(data);
                            $('.select2').select2();
                        }
                    });
                } 
            }
            function serviceArea(val) {
                if (val == "others") {
                    $('.area_other').removeClass('hide');
                } else {
                    $('.area_other').addClass('hide');
                } 
            }

            function btnEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Servicess="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                        $('.select2').select2();
                        repeaterForm('modalUpdate');
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
                        url: "function.php?modalDelete_Servicess="+id,
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
                formData.append('btnSave_Servicess',true);

                var l = Ladda.create(document.querySelector('#btnSave_Servicess'));
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
                                result += '<td>'+obj.category+'</td>';
                                result += '<td>'+obj.area+'</td>';
                                result += '<td>'+obj.description+'</td>';
                                result += '<td class="text-center">';
                                    result += '<div class="btn-group btn-group-circle">';
                                        result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('+obj.ID+')">View</a>';
                                        result += '<a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                    result += '</div>';
                                result += '</td>';
                            result += '</tr>';

                            $("#tableData tbody").append(result);
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
                formData.append('btnUpdate_Services',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Services'));
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
                            var result = '<td>'+obj.category+'</td>';
                            result += '<td>'+obj.area+'</td>';
                            result += '<td>'+obj.description+'</td>';
                            result += '<td class="text-center">';
                                result += '<div class="btn-group btn-group-circle">';
                                    result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('+obj.ID+')">View</a>';
                                    result += '<a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                result += '</div>';
                            result += '</td>';

                            $("#tableData tbody #tr_"+obj.ID).html(result);
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