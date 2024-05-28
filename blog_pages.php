
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
                        	                                <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                            	                                <i class="fa fa-angle-down"></i>
                                	                        </a>
                                    	                    <ul class="dropdown-menu pull-right">
                                        	                    <li>
                                                                	<a data-toggle="modal" href="#addNewblog"> Add New Blog</a>
                                                            	</li>
                                                        	</ul>
                                                    	</div>
                                                	</div>
                                            	</div>
                                            </div>
                						</div>
                                        <div class="portlet light ">
                                              
                                            <div class="portlet-body">
                                                    <table class="table ">
                                                           <thead class="bg-primary">
                                                               <tr>
                                                                  <td>#</td>
                                                                  <td>Title</td>
                                                                  <td>Description</td>
                                                                  <td></td>
                                                                  <td></td>
                                                               </tr>
                                                           </thead>
                                                           <tbody>
                                                    <?php   
                                                    
                                                    $i = 1;
                                                    $users = $_COOKIE['ID'];
                                                    $query = "SELECT * FROM tbl_blogs_pages order by blogs_title ASC";
                                                    $result = mysqli_query($conn, $query);
                                                                                
                                                    while($row = mysqli_fetch_array($result))
                                                    {?>
                                                       
                                                               <tr>
                                                                   <td><?php echo $i++;?></td>
                                                                   <td><?php echo $row['blogs_title']; ?></td>
                                                                   <td style=""><p class="smalls"><?php echo $row['description_view']; ?></p></td>
                                                                   <td>
                                                                       <?php
                                                                        if($row['status_publish']==1) { ?>
                                                                        <a>Published</a>&nbsp;
                                                                        <a style="color:red;" href="blog-functions/add-blog.php?stop=<?php echo $row['blogs_id']; ?>">Stop</a>
                                                                      <?php }else{ ?>
                                                                      <a href="blog-functions/add-blog.php?publishid=<?php echo $row['blogs_id']; ?>">Publish</a>
                                                                      <?php } ?>
                                                                       
                                                                   </td>
                                                                   <td><a href="edit-blog.php?id=<?php echo $row['blogs_id']; ?>">View</a></td>
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
        <div class="modal fade" id="addNewblog" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg" style="width:100%;">
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