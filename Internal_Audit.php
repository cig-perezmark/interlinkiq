<?php 
    $title = "Internal Audit";
    
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Pages';
    $site = "blog_pages";
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
    
    
?>

                    <div class="row">
                        <div class="col-md-12">
                            <?php  ?>
                        
                            <!-- BEGIN PROFILE CONTENT -->
                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
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
                                                                	<a data-toggle="modal" href="#addNew"> Add New</a>
                                                            	</li>
                                                            	<li>
                                                                	<a data-toggle="modal" href="#modalMultiUpload"> Add Multiple</a>
                                                            	</li>
                                                        	</ul>
                                                    	</div>
                                                	</div>
                                            	</div>
                                            </div>
                						</div>
                                        <div class="portlet light ">
                                              
                                            <div class="portlet-body">
                                                    <table class="table table-bordered table-hover" id="sample_4">
                                                           <thead class="bg-primary" >
                                                               <tr>
                                                                  <td>#</td>
                                                                  <td>Account</td>
                                                                  <td>Category</td>
                                                                  <td>Area</td>
                                                                  <td>Description</td>
                                                                  <td></td>
                                                               </tr>
                                                           </thead>
                                                           <tbody>
                                                    <?php   
                                                    
                                                    $i = 1;
                                                    $users = $_COOKIE['ID'];
                                                    $query = "SELECT * FROM tbl_Internal_Audit";
                                                    $result = mysqli_query($conn, $query);
                                                                                
                                                    while($row = mysqli_fetch_array($result))
                                                    {?>
                                                       
                                                               <tr>
                                                                   <td><?php echo $i++;?></td>
                                                                   <td><?php echo $row['IA_Account']; ?></td>
                                                                   <td><?php echo $row['IA_Category']; ?></td>
                                                                   <td><?php echo $row['IA_Areas']; ?></td>
                                                                   <td><?php echo $row['IA_Description']; ?></td>
                                                                   <td>
                                                                       <a class="btn blue btn-outline btnView" data-toggle="modal" href="#modalGetIA" data-id="<?php echo $row["IA_id"]; ?>" style="float:right;margin-right:20px;">
                                                                                        VIEW
                                                                        </a>
                                                                   </td>
                                                               </tr>
                                                    <?php } ?>
                                                           </tbody>
                                                       </table>
                                            </div>
                                           
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- END PROFILE CONTENT -->
                        </div>
                    </div>
          
          
       
        <!--Certification MODAL AREA-->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="Internal_Audit_Function/Internal_Audit_Function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">ADD NEW</h4>
                        </div>
                        <div class="modal-body">
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Department</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="text" name="IA_Category" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Account</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="text" name="IA_Account" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Area</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="text" name="IA_Areas" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Descriptions</label>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" type="text" name="IA_Description" rows="4" required /></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="save_IA" value="Save" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
         <!-- MODAL AREA-->
            <div class="modal fade" id="modalMultiUpload" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="post" action="Internal_Audit_Function/Internal_Audit_Function.php" enctype="multipart/form-data" class="modalForm modalSave">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Add Multiple <a href="Internal_Audit_Function/Internal_Audit_Template.php">&nbsp;<i style="font-size:14px;">(Template here...)</i></a></h4>
                            </div>
                            <div class="modal-body">
                                <div class="tabbable tabbable-tabdrop">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Upload Template</label>
                                                        <input class="form-control" type="hidden" name="from" id="from" value="<?php echo $current_userEmail; ?>">
                                                        <input class="form-control-plaintext mb-2" type="file" name="file" accept=".csv">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                                    <button type="submit" class="btn btn-success ladda-button" name="btn_Multi_IT" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                 <!--view modal-->
         <div class="modal fade bs-modal-lg" id="modalGetIA" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                     <form action="Internal_Audit_Function/Internal_Audit_Function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Internal Audit</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <!--<input type="submit" name="btnContactMoreUpdate" value="Save" class="btn btn-info">       -->
                         </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include_once ('footer.php'); ?>
<script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
 <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- Summernote JS - CDN Link -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#your_summernote").summernote({
                placeholder:'',
                height: 400
            });
            $('.dropdown-toggle').dropdown();
        });
    </script>
    <!-- //Summernote JS - CDN Link -->
      <script>
         // View  Contact
         $(".btnView").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "Internal_Audit_Function/fetch-IA.php?modalViewApp="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetIA .modal-body").html(data);
                       
                    }
                });
            });
            
        </script>
        
        
 <!--        lang: 'en-EN',-->
 <!--dialogsInBody: true,-->
 <!--height: 120,-->
 <!--minHeight: null, -->
 <!--maxHeight: null, -->
 <!--shortCuts: false,-->
 <!--fontSize: 14,-->
 <!--disableDragAndDrop: false,-->
 <!--toolbar: [-->
 <!--['style', ['bold', 'italic', 'underline', 'clear']],-->
 <!--['font', ['strikethrough', 'superscript', 'subscript']],-->
 <!--['fontsize', ['fontsize']],-->
 <!--['color', ['color']],-->
 <!--['para', ['ul', 'ol', 'paragraph']],-->
 <!--['height', ['height']],-->
 <!--['Insert', ['picture']],-->
 <!--['Other', ['fullscreen', 'codeview']]-->
 <!--]-->
        <!-- MODALS FOR PROFILE SIDEBAR -->
        <script src="profileSidebar.js" type="text/javascript"></script>
       <style>
       tr td p .smalls {
          line-height: 0.7;
        }
        
       tr td p.big {
          line-height: 1.8;
        }
       .brandAv{
           height:300px;
           width:300px;
           position:relative;
           border-radius:50%;
           border:solid 3px #fff;
           background-color:#F6FBF4;
           background-size:100% 100%;
           margin:5px auto;
           overflow:hidden;
       }
       .uuploader{
           position:absolute;
           bottom:0;
           outline:none;
           color:transparent;
           width:100%;
           box-sizing:border-box;
           padding:15px 140px;
           cursor:pointer;
             transition: 0.5s;
         background:rgba(0,0,0,0.5);
         opacity:0;
       }
       .uuploader::-webkit-file-upload-button{
        visibility:hidden;
    }
    .uuploader::before{
    	content:'\f030';
    	font-family:fontAwesome;
    	font-size:20px;
        color:#fff;
        display:inline-block;
        text-align:center;
        float:center;
        -webkit-user-select:none;
        }
        /*.uuploader::after{*/
        /*     width:100%;*/
        /*   content:'Update';*/
        /*  font-family:'arial';*/
        /*   font-weight:bold;*/
        /*    color:#fff;*/
        /*    display:block;*/
        /*    top:30px;-->*/
        /*   font-size:12px;*/
        /*   position:abosolute;*/
        /*    text-align:center;*/
        /*}*/
        .uuploader:hover{
         opacity:1;
        }
       </style>

        <!-- MODALS FOR PROFILE SIDEBAR -->
        <script src="profileSidebar.js" type="text/javascript"></script>
    </body>
</html>
