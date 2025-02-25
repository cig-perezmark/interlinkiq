<?php 
    $title = "Blog Pages";
    
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Blog';
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
                        	                                <a class="btn dark btn-outline btn-circle btn-sm" href="blog_pages.php">  Back to Blog page
                            	                                <i class="fa fa-angle-down"></i>
                                	                        </a>
                                    	                   
                                                    	</div>
                                                	</div>
                                            	</div>
                                            </div>
                						</div>
                                        <div class="portlet light ">
                                              
                                            <div class="row">
                                            <form action="blog-functions/add-blog.php" method="POST" enctype="multipart/form-data">
                                                <div class="col-md-12">
                                                   
                                                    <?php   
                                                    
                                                    $users = $_COOKIE['ID'];
                                                    $blogid = $_GET['id'] ;
                                                    $query = "SELECT * FROM tbl_blogs_pages where blogs_id = '$blogid' ";
                                                    $result = mysqli_query($conn, $query);
                                                                                
                                                    while($row = mysqli_fetch_array($result))
                                                    {?>
                                                            <input class="form-control" type="hidden" name="ids" value="<?php echo $row['blogs_id']; ?>">
                                                            <input class="form-control" name="blogs_title" value="<?php echo $row['blogs_title']; ?>">
                                                            <br>
                                                            <input class="form-control" name="description_view" value="<?php echo $row['description_view']; ?>">
                                                            <br>
                                                            <textarea id="your_summernote" name="description" style="height:500px;width:100%;"><?php echo $row['descriptions']; ?></textarea>
                                                        <?php } ?>
                                                        <br>
                                                        <input type="submit" name="edit_blog" value="Save" class="btn btn-info">
                                                </div>
                                                
                                            </form>
                                           </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- END PROFILE CONTENT -->
                        </div>
                    </div>
          
          
          <!--view modal-->
         <div class="modal fade bs-modal-lg" id="modalGetContact" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                     <form action="facility-function/add-contact-function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
    		            <input class="form-control" type="hidden" name="ids" id="ids" value="<?php echo $_GET['facility_id']; ?>" />
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Contact Person</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <input type="submit" name="btnContactMoreUpdate" value="Update" class="btn btn-info">       
                         </div>
                    </form>
                </div>
            </div>
        </div>   
       
        <!--Certification MODAL AREA-->
        <div class="modal fade" id="addNewblog" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="blog-functions/add-blog.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">ADD NEW BLOGS</h4>
                        </div>
                        <div class="modal-body">
                             <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Title</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="text" name="blogs_title" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Descriptions</label>
                                    </div>
                                    <div class="col-md-12" >
                                        <input class="form-control" type="text" name="description_view" required />
                                    </div>
                                </div>
                            </div>
                           <br>
                            <div class="row">
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label>Content</label>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" type="text" name="description" id="your_summernote" rows="4" required /></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top:10px;">
                            <input type="submit" name="save_blog" value="Save" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include_once ('footer.php'); ?>
<script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
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
     
         // View permits
         $(".btnViewPermits").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "facility-function/fetch-permits.php?modalView="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetPermits .modal-body").html(data);
                       
                    }
                });
            });
            
        </script>
     
        <!-- MODALS FOR PROFILE SIDEBAR -->
        <script src="profileSidebar.js" type="text/javascript"></script>
       <style>
        .smalls {
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
