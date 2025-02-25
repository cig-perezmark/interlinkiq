<?php
    $title = "Module";
    $site = "module";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    .img_cover {
        width: 100px;
        height: 100px;
        object-fit: contain;
        object-position: center;
        border-radius: 100% !important;
        border: 1px solid #c1c1c1;
        overflow: hidden;
        margin: auto;
        position: relative;
    }
    .img_cover img {
        width: 100%;
    }
    .img_cover button {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        display: none;
    }
    .img_cover:hover button {
        display: block;
    }
</style>

            <!--Start of App Cards-->
            <!-- BEGIN : USER CARDS -->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <i class="icon-grid font-dark"></i>
                                <span class="caption-subject font-dark bold uppercase">Module</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php if($_COOKIE['ID'] == 2): ?>
        						<div class="row">
        							<div class="col-lg-12">
                                		<div class="portlet-title" style="margin-bottom:10px;float:right">
                                        	<div class="actions">
                                            	<div class="btn-group">
                	                                <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                    	                                <i class="fa fa-angle-down"></i>
                        	                        </a>
                            	                    <ul class="dropdown-menu pull-right">
                                	                    <li>
                                                        	<a data-toggle="modal" href="#imageModal"> Add External App</a>
                                                    	</li>
                                                    	<li>
                                                        	<a data-toggle="modal" href="#"> Add Library</a>
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
                                        	</div>
                                    	</div>
                                    </div>
        						</div>
            	            <?php endif ?>
    						<!-- List of apps in tbl_app_store table -->
                            <?php
                                if ($switch_user_id == 1 OR $switch_user_id == 19 OR $switch_user_id == 163 OR $switch_user_id == 464) {
                                    echo '<div class="row margin-bottom-15">
                                        <form method="post" enctype="multipart/form-data" class="formModule">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="module_name" placeholder="Module Name" />
                                            </div>
                                            <div class="col-md-6">
                                                <textarea class="form-control" name="module_description" placeholder="Description"></textarea>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-success btn-sm" name="btnSave_Module" id="btnSave_Module">Add</button>
                                            </div>
                                        </form>
                                    </div>';
                                }

                                echo '<div class="row margin-bottom-15">';
                                    // $selectModules = mysqli_query( $conn,"SELECT * FROM tblPlugins WHERE deleted = 0 ORDER BY plugin_name" );
                                    $selectData = mysqli_query( $conn,"SELECT 
                                        p.plugin_id AS p_plugin_id,
                                        p.plugin_name AS p_plugin_name,
                                        p.available AS p_available,
                                        p.file_attachment AS p_file_attachment,
                                        m.url AS m_url
                                        FROM tblPlugins AS p

                                        LEFT JOIN (
                                            SELECT
                                            *
                                            FROM
                                            tbl_menu
                                            WHERE deleted = 0
                                        ) AS m
                                        ON p.menu_id = m.ID

                                        WHERE p.deleted = 0 

                                        ORDER BY p.plugin_name" );
                                    if ( mysqli_num_rows($selectData) > 0 ) {
                                        while($rowData = mysqli_fetch_array($selectData)) {
                                            $p_plugin_id = $rowData['p_plugin_id'];
                                            $p_plugin_name = stripcslashes($rowData['p_plugin_name']);
                                            $p_available = stripcslashes($rowData['p_available']);
                                            $p_file_attachment = $rowData['p_file_attachment'];
                                            $m_url = $rowData['m_url'];
                                            
                                            echo '<div class="col-md-3 text-center margin-bottom-15" style="height: 230px; min-height: 230px;">
                                                <div class="img_cover margin-bottom-15">
                                                    <img src="data:image/png;base64,'.$p_file_attachment.'" onerror="this.onerror=null;this.src=\'https://via.placeholder.com/100x100/EFEFEF/AAAAAA.png?text=no+image\';"  />';

                                                    if($_COOKIE['ID'] == 481){
                                                        echo '<button class="btn btn-danger upload-btn" data-id="'.$p_plugin_id.'" data-toggle="modal" data-target="#upload_file">Upload</button>';
                                                    }
                                                echo '</div>';

                                                if ($switch_user_id == 1 OR $switch_user_id == 19 OR $switch_user_id == 163 OR $switch_user_id == 464) {
                                                    echo '<div class="text-center margin-bottom-15">
                                                        <a href="#modalViewModule" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnViewModule('.$p_plugin_id.')">View</a>
                                                        <a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnDeleteModule('.$p_plugin_id.')">Delete</a>
                                                    </div>';
                                                }

                                                if ($m_url) {
                                                    echo '<a href="'.$m_url.'" class="blue-steel bold" target="_blank">'.$p_plugin_name.'</a>';
                                                } else {
                                                    echo $p_plugin_name;
                                                }
                                            echo '</div>';
                                        }
                                    }
                                echo '</div>';
                            ?>
        				</div>
                    </div>
                </div>
                <!--End of App Cards-->

                <!-- MODAL AREA-->
                <!-- Modal -->
                <div class="modal fade" id="demo_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal Demo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="app">
                                    <?php
                                         $select_image = "SELECT file_attachment FROM tblPlugins WHERE deleted = 0 AND file_attachment != '' ORDER BY plugin_name ASC";
                                         $result = mysqli_query($conn,$select_image);
                                         foreach($result as $row):
                                             $file_attachment = $row['file_attachment'];
                                    ?>
                                        <div class="icon" draggable="true" id="icon1">
                                            <img src="data:image/png;base64,<?= $file_attachment ?>" style="width:40px;height:40px">
                                        </div>
                                    <?php endforeach; ?>
                                  </div>
                            </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div id="imageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">View Image</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Image will be injected here by jQuery -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="uploadForm">
                    <div class="modal fade" id="upload_file" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Upload File </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" id="data_id">
                                            <input type="file" id="fileInput" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
                <div class="modal fade" id="modalProServiceNotice" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="post" class="form-horizontal modalForm modalProServiceNotice">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Contact Customer Success Team</h4>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        To review and clarify the action items, contact the Customer Success Team at <a href="mailto:csuccess@consultareinc.com" target="_blank">csuccess@consultareinc.com</a> or <a href="mailto:hello@consultareinc.com" target="_blank">hello@consultareinc.com</a>, or call 1-202-982-3002.
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--Update Status-->
                <div class="modal fade" id="modal_update_pricing" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog ">
                        <div class="modal-content">
                            <form method="post" class="form-horizontal modalForm modal_update_pricing">
                                <div class="modal-header">
                                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Pricing Details</h4>
                                </div>
                                <div class="modal-body">
                                   
                                </div>
                                <div class="modal-footer">
                                   <input class="btn btn-info" type="submit" name="btnSave_pricing" id="btnSave_pricing" value="Save" >
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--Update Status-->
                <div class="modal fade" id="modal_delete_pricing" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog ">
                        <div class="modal-content">
                            <form method="post" class="form-horizontal modalForm modal_delete_pricing">
                                <div class="modal-header">
                                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Are You Sure You Want to delete the details below?</h4>
                                </div>
                                <div class="modal-body">
                                   
                                </div>
                                <div class="modal-footer">
                                   <input class="btn btn-warning" type="submit" name="btndelete_pricing" id="btndelete_pricing" value="Yes" >
                                   <input type="button" class="btn btn-info" data-dismiss="modal" value="No" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                 <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" >
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form id="image_form" method="post"  class="form-horizontal modalSave" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">NEW APP DESCRIPTION FORM</h4>
                                </div>
                                <div class="modal-body"> 
                                    <div class="form-group">
                                            <label class="col-md-2 control-label"></label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="hidden" name="apptype" id="apptype" value="LINK" />
                                            </div>
                                        </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Name</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="application_name" id="application_name" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Description</label>
                                        <div class="col-md-10">
                                            <textarea class="form-control" name="descriptions" id="descriptions" rows="3" required ></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Pricing</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="number" name="pricing" id="pricing" value="0" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">App URL</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="app_url" id="app_url" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Image/Logo</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="file" id="image" name="image" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Developer</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" id="developer" name="developer" id="developer" required />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="row">
                                             <div class="col-md-6">
                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Image 1</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" type="file" id="image1" name="image1" required/>
                                                </div>
                                             </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                    <label class="col-md-3 control-label">Image 2</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control" type="file" id="image2" name="image2" required/>
                                                    </div>
                                                 </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-md-6">
                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Image 3</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" type="file" id="image3" name="image3" required/>
                                                </div>
                                             </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                    <label class="col-md-3 control-label">Image 4</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control" type="file" id="image4" name="image4" required />
                                                    </div>
                                                 </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-md-6">
                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Image 5</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" type="file" id="image5" name="image5" required/>
                                                </div>
                                             </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                    <label class="col-md-3 control-label">Image 6</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control" type="file" id="image6" name="image6" required/>
                                                    </div>
                                                 </div>
                                             </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    <input type="hidden" name="action" id="action" value="insert" />
                                    <input type="hidden" name="app_id" id="app_id" />
                                    <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-info" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!--get free app modal-->
                <div class="modal fade bs-modal-lg" id="modalGetFree" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form id="getFreeAppForm" method="post" class="form-horizontal modalForm modalUpdate">
                                <div class="modal-header bg-primary">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">App Details</h4>
                                </div>
                                <div class="modal-body"></div>
                                <div class="modal-footer">
                                    <input type="hidden" name="action" id="action" value="insert" />
                                    <input type="submit" class="btn green" name="insert" id="insert" value="Subscribe" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!--view modal-->

                <div class="modal fade bs-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="post" class="form-horizontal modalForm modalUpdate">
                                <div class="modal-header bg-primary">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">App Details</h4>
                                </div>
                                <div class="modal-body"></div>
                                <div class="modal-footer">
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                                
                <!--view modal library-->

                <div class="modal fade bs-modal-lg" id="modalViewLibrary" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="post" class="form-horizontal modalForm modalUpdate">
                                <div class="modal-header bg-primary">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">App Details</h4>
                                </div>
                                <div class="modal-body"></div>
                                <div class="modal-footer">
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="modalViewComply" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalViewComply">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Compliance Details</h4>
                                </div>
                                <div class="modal-body"></div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn green ladda-button" name="btnUpdate_Comply" id="btnUpdate_Comply" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modalViewModule" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalViewModule">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Module Details</h4>
                                </div>
                                <div class="modal-body"></div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn green ladda-button" name="btnUpdate_Module" id="btnUpdate_Module" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modalViewSOP" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalViewSOP">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">SOP Details</h4>
                                </div>
                                <div class="modal-body"></div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn green ladda-button" name="btnUpdate_SOP" id="btnUpdate_SOP" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
    			<?php // include('app-function/app_modal.php'); ?>
                <!-- / END MODAL AREA -->
    	    </div><!-- END CONTENT BODY -->
        
    	<?php include('footer.php'); ?>
    	
    	
        <script src="assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
        <script>
            const icons = document.querySelectorAll('.icon');
        
            let dragSrcEl = null;

            function handleDragStart(e) {
            dragSrcEl = this;
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.innerHTML);
            }

            function handleDragOver(e) {
            if (e.preventDefault) {
            e.preventDefault();
            }
            e.dataTransfer.dropEffect = 'move';
            return false;
            }

            function handleDragEnter(e) {
            this.classList.add('over');
            }

            function handleDragLeave() {
            this.classList.remove('over');
            }

            function handleDrop(e) {
            if (e.stopPropagation) {
            e.stopPropagation();
            }

            if (dragSrcEl !== this) {
            dragSrcEl.innerHTML = this.innerHTML;
            this.innerHTML = e.dataTransfer.getData('text/html');
            }

            return false;
            }

            function handleDragEnd() {
            icons.forEach(icon => {
            icon.classList.remove('over');
            });
            }

            icons.forEach(icon => {
            icon.addEventListener('dragstart', handleDragStart);
            icon.addEventListener('dragenter', handleDragEnter);
            icon.addEventListener('dragover', handleDragOver);
            icon.addEventListener('dragleave', handleDragLeave);
            icon.addEventListener('drop', handleDrop);
            icon.addEventListener('dragend', handleDragEnd);
            });
        </script>
        <script> 
            
            $(document).ready(function() {
                $('.view-btn').click(function() {
                    var imageSrc = $(this).data('image');
                    // Create an image element
                    var imgElement = '<img src="' + imageSrc + '" alt="Uploaded Image" style="width: 100%; height: auto;" />';
                    
                    // Display the image in a modal or a dedicated container
                    $('#imageModal .modal-body').html(imgElement);
                    $('#imageModal').modal('show');
                });
                
                $('.upload-btn').click(function(){
                    var dataID = $(this).data('id');
                    $('#data_id').val(dataID);
                });
                
                $('#uploadForm').submit(function(e){
                    e.preventDefault(); // Prevent default form submission
                    var dataID = $('#data_id').val(); // Get data ID from input field
                    var file = $('#fileInput')[0].files[0]; // Get selected file
                    if(!file) {
                        alert("Please select a file.");
                        return;
                    }
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var base64String = e.target.result.split('base64,')[1]; // Get Base64 string
                        // AJAX request to update the file_attachment column with the Base64 string
                        $.ajax({
                            url: 'controller.php', // Replace with your PHP script URL
                            method: 'POST',
                            data: {
                                data_id: dataID, 
                                file_attachment: base64String,
                                action:"upload_module_img"
                            },
                            success: function(response){
                                // Reload table or do any other necessary actions
                                // $('#tableModule').load(location.href + ' #tableModule');
                                // $('#upload_file').modal('hide'); // Hide the modal after successful upload
                                msg = "Sucessfully Uploaded!";
                                bootstrapGrowl(msg);
                                $('#upload_file').modal('hide');
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                alert('Error uploading file. Please try again.');
                            }
                        });
                    };
                    reader.readAsDataURL(file); // Convert file to Base64 string
                });
                
                
                
                
                
                // $('#tableComply, #tableModule, #tableSOP, #tableProServices, #tableProServices, #tableProServices, #tableProServices').dataTable( {
                //   "columnDefs": [
                //     { "width": "auto" }
                //   ]
                // } );
                
                // $('#tableComply, #tableModule, #tableSOP, #tableProServices, #tablepricing, #tableForms').dataTable();

                $('#tableModule').dataTable({
                    paging: false
                });
            } );
            
            
            // modal_new_pricing
            $(".modal_new_pricing").on('submit',(function(e) {
                e.preventDefault();
                 var row_tbl = $("#Status_tbl").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnNew_pricing',true);
            
                var l = Ladda.create(document.querySelector('#btnNew_pricing'));
                l.start();
            
                $.ajax({
                    url: "app-function/add_pricing.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Added!";
                            $('#'+row_tbl).append(response);
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
            
                        bootstrapGrowl(msg);
                    }
                });
            }));
            //delete pricing
            $(document).on('click', '#delete_pricing', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "app-function/fetch_pricing.php?delete_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_delete_pricing .modal-body").html(data);
                    }
                });
            });
            $(".modal_delete_pricing").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                var Status_row = $("#Status").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btndelete_pricing',true);
            
                var l = Ladda.create(document.querySelector('#btndelete_pricing'));
                l.start();
            
                $.ajax({
                    url: "app-function/fetch_pricing.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Deleted!!!";
                            $('#tbl_row_'+row_id).empty();
                            $('#'+row_id).empty();
                             $('#modal_delete_pricing').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
            
                        bootstrapGrowl(msg);
                    }
                });
            }));

            //update pricing
            $(document).on('click', '#update_pricing', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "app-function/fetch_pricing.php?get_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_update_pricing .modal-body").html(data);
                    }
                });
            });
            $(".modal_update_pricing").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_pricing',true);
            
                var l = Ladda.create(document.querySelector('#btnSave_pricing'));
                l.start();
            
                $.ajax({
                    url: "app-function/fetch_pricing.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            $('#tbl_row_'+row_id).empty();
                             $('#tbl_row_'+row_id).append(response);
                             $('#modal_update_pricing').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
            
                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(document).ready(function(){
             
                //  Emjay script start
            
                $('[id*="get_form"]').click(function(){
                    var form_id =  ($(this).attr('form_id'));
                    enterprise = <?= $switch_user_id ?> ;
                    $.ajax({
                        url:"app-function/controller.php",
                        method:"POST",
                        data:{
                            action:"get_form",
                            form_id:form_id,
                            enterprise:enterprise
                        },
                        success:function(data) {
                            window.location.reload();
                            // console.log(data);
                        }
                    })
                });
                
                function myfunction(id){
                    const d = new Date();
                    d.setTime(d.getTime() + (1*24*60*60*1000));
                    let expires = "expires="+ d.toUTCString();
                    document.cookie = 'user_company_id' + "=" + id + ";" + expires + ";path=/";
                }
                function form_code(id){
                    $('#form_ownded').val(id);
                }
                function myfunction1(id){
                    const d = new Date();
                    d.setTime(d.getTime() + (1*24*60*60*1000));
                    let expires = "expires="+ d.toUTCString();
                    document.cookie = 'user_company_id' + "=" + id + ";" + expires + ";path=/";
                }
                
                // Emjay script end
            
            
                fetch_data();
                function fetch_data() {
                    var action = "fetch";
                    $.ajax({
                        url:"app-function/action.php",
                        method:"POST",
                        data:{action:action},
                        success:function(data) {
                            $('#image_data').html(data);
                        }
                    })
                }
                $('#add').click(function(){
                    $('#imageModal').modal('show');
                    $('#image_form')[0].reset();
                    $('.modal-title').text("Add Image");
                    $('#app_id').val('');
                    $('#action').val('insert');
                    $('#insert').val("Insert");
                });
             
                $('#image_form').submit(function(event){
                    event.preventDefault();
                    var application_name = $('#application_name').val();
                    var descriptions = $('#descriptions').val();
                    var pricing = $('#pricing').val();
                    var app_url = $('#app_url').val();
                    var image_name = $('#image').val();
                    var image_name1 = $('#image1').val();
                    var image_name2 = $('#image2').val();
                    var image_name3 = $('#image3').val();
                    var image_name4 = $('#image4').val();
                    var image_name5 = $('#image5').val();
                    var image_name6 = $('#image6').val();
                    var developer = $('#developer').val();
                    
                    if(image_name == '') {
                        alert("Please Select Image");
                        return false;
                    } else {
                        var extension = $('#image').val().split('.').pop().toLowerCase();
                        if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1) {
                            alert("Invalid Image File");
                            $('#image').val('');
                            return false;
                        } else {
                            $.ajax({
                                url:"app-function/action.php",
                                method:"POST",
                                data:new FormData(this),
                                contentType:false,
                                processData:false,
                                success:function(data) {
                                    fetch_data();
                                    $('#image_form')[0].reset();
                                    $('#imageModal').modal('hide');
                                    location.reload();
                                }
                            });
                        }
                    }
                });
             
                //  for get free app
                $('#getFreeAppForm').submit(function(event){
                    event.preventDefault();
                    var getID = $('#getID').val();
                    //   var btnClone = $('#btnClone').val();
                    
                    $.ajax({
                        url:"app-function/getFreeAppAction.php",
                        method:"POST",
                        data:new FormData(this),
                        contentType:false,
                        processData:false,
                        success:function(data) {
                            $('#getFreeAppForm')[0].reset();
                            $('#modalGetFree').modal('hide');
                            location.reload();
                        }
                    });
                });
             
                //  for get clone library
                $('#geCloneAppForm').submit(function(event){
                    event.preventDefault();
                    var id = $('#ID').val();
                    var userID = $('#userID').val();
                    var companydetails = $('#companydetails').val();
                    
                    $.ajax({
                        url:"app-function/cloneLibrary.php",
                        method:"POST",
                        data:new FormData(this),
                        contentType:false,
                        processData:false,
                        success:function(data) {
                            $('#getFreeAppForm')[0].reset();
                            location.reload();
                        }
                    });
                });
             
                // Data Fetch
                $(".btnView").click(function() {
                    var id = $(this).data("id");
                    $.ajax({    
                        type: "GET",
                        url: "app-function/fetchApp.php?modalViewApp="+id,
                        dataType: "html",
                        success: function(data){
                            $("#modalView .modal-body").html(data);
                        }
                    });
                });
                        
                // Data Fetch
                $(".btnViewLibrary").click(function() {
                    var id = $(this).data("id");
                    $.ajax({    
                        type: "GET",
                        url: "app-function/fetchAppLibrary.php?modalViewApp="+id,
                        dataType: "html",
                        success: function(data){
                            $("#modalViewLibrary .modal-body").html(data);
                        }
                    });
                });
                        
                // Data Get free 
                $(".btnGetFree").click(function() {
                    var id = $(this).data("id");
                    $.ajax({    
                        type: "GET",
                        url: "app-function/getFreeApp.php?modalGetFreeApp="+id,
                        dataType: "html",
                        success: function(data){
                            $("#modalGetFree .modal-body").html(data);
                        }
                    });
                });
                
                $(document).on('click', '.update', function(){
                    $('#app_id').val($(this).attr("id"));
                    $('#action').val("update");
                    $('.modal-title').text("Update Image");
                    $('#insert').val("Update");
                    $('#imageModal').modal("show");
                });
                $(document).on('click', '.delete', function(){
                    var image_id = $(this).attr("id");
                    var action = "delete";
                    if(confirm("Are you sure you want to remove this?")) {
                        $.ajax({
                            url:"action.php",
                            method:"POST",
                            data:{app_id:app_id, action:action},
                            success:function(data) {
                                alert(data);
                                fetch_data();
                            }
                        })
                    } else {
                        return false;
                    }
                });
            }); 
            
            // for gallery
            
            // let slideIndex = 1;
            // showSlides(slideIndex);
            
            // Next/previous controls
            function plusSlides(n) {
                showSlides(slideIndex += n);
            }
            
            // Thumbnail image controls
            // function currentSlide(n) {
            //   showSlides(slideIndex = n);
            // }
            
            // function showSlides(n) {
            //   let i;
            //   let slides = document.getElementsByClassName("mySlides");
            //   let dots = document.getElementsByClassName("demo");
            //   let captionText = document.getElementById("caption");
            //   if (n > slides.length) {slideIndex = 1}
            //   if (n < 1) {slideIndex = slides.length}
            //   for (i = 0; i < slides.length; i++) {
            //     slides[i].style.display = "none";
            //   }
            //   for (i = 0; i < dots.length; i++) {
            //     dots[i].className = dots[i].className.replace(" active", "");
            //   }
            //   slides[slideIndex-1].style.display = "block";
            //   dots[slideIndex-1].className += " active";
            //   captionText.innerHTML = dots[slideIndex-1].alt;
            // }
            
            function apps(evt, appName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(appName).style.display = "block";
                evt.currentTarget.className += " active";
            }
            
            function btnClone(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?btnClone="+id,
                    dataType: "html",
                    success: function(data){
                        // $("#modalReport .modal-body").html(data);
            
                        alert(data);
                    }
                });
            }
            
            // Pro Services Section
            $(".formProServices").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_ProServices',true);

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
                            $('#tableProServices').prepend(obj.data);
                        } else {
                            msg = "Error!"
                        }

                        bootstrapGrowl(msg);
                    }
                });
            });
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
                        url: "function.php?btnDelete_ProService="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tableProServices #tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            
            // Comply Section
            function btnDeleteComply(id) {
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
                        url: "function.php?btnDelete_Comply="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tableComply #tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            $(".formComply").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Comply',true);

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
                            $('#tableComply').prepend(obj.data);
                        } else {
                            msg = "Error!"
                        }

                        bootstrapGrowl(msg);
                    }
                });
            });
            function btnViewComply(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Comply="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewComply .modal-body").html(data);
                    }
                });
            }
            $(".modalViewComply").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Comply',true);

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
                            $("#tableComply tbody #tr_"+obj.ID).html(obj.data);
                            $('#modalViewComply').modal('hide');
                        } else {
                            msg = "Error!"
                        }

                        bootstrapGrowl(msg);
                    }
                });
            });
            
            // Module Section
            function btnDeleteModule(id) {
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
                        url: "function.php?btnDelete_Module="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tableModule #tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            $(".formModule").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Module',true);

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

                            location.reload();
                            // var obj = jQuery.parseJSON(response);
                            // $('#tableModule').prepend(obj.data);
                        } else {
                            msg = "Error!"
                        }

                        bootstrapGrowl(msg);
                    }
                });
            });
            function btnViewModule(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Module="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewModule .modal-body").html(data);
                        $('.selectpicker').selectpicker();
                    }
                });
            }
            $(".modalViewModule").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Module',true);

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

                            location.reload();
                            // var obj = jQuery.parseJSON(response);
                            // $("#tableModule tbody #tr_"+obj.ID).html(obj.data);
                            // $('#modalViewModule').modal('hide');
                        } else {
                            msg = "Error!"
                        }

                        bootstrapGrowl(msg);
                    }
                });
            });
            
            // SOP Section
            function btnDeleteSOP(id) {
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
                        url: "function.php?btnDelete_SOP="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tableSOP #tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            $(".formSOP").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_SOP',true);

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
                            $('#tableSOP').prepend(obj.data);
                        } else {
                            msg = "Error!"
                        }

                        bootstrapGrowl(msg);
                    }
                });
            });
            function btnViewSOP(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_SOP="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewSOP .modal-body").html(data);
                    }
                });
            }
            $(".modalViewSOP").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_SOP',true);

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
                            $("#tableSOP tbody #tr_"+obj.ID).html(obj.data);
                            $('#modalViewSOP').modal('hide');
                        } else {
                            msg = "Error!"
                        }

                        bootstrapGrowl(msg);
                    }
                });
            });
        </script>
    </body>
</html>
