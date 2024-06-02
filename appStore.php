<?php 
    $title = "Consultare FSMS";
    $site = "app-store";

    include_once ('header.php'); 


?>

	<div class="row">
	

        <!--Start of App Cards-->
        <!-- BEGIN : USER CARDS -->
        <div class="rowx">
            <div class="col-md-12">
                <div class="portlet light portlet-fit ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green bold uppercase">Interlink Apps</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <!--BEGIN SEARCH BAR        -->
                		<div class="search-bar bordered" style="margin-bottom:30px;">
                        	<div class="row">
                            	<div class="col-lg-12">
                                	<div class="input-group">
                                    	<input type="text" class="form-control" placeholder="Search for..." style="height:50px;">
                                    	<span class="input-group-btn">
                                        	<button class="btn green-soft uppercase bold" type="button" style="height:50px;">Search</button>
                                    	</span>
                                	</div>
                            	</div>
                        	</div>
                 		</div>
                        <!--END SEARCH BAR-->

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

						<!-- List of apps in tbl_app_store table -->
                        <div class="mt-element-card mt-card-round mt-element-overlay">
                            <div class="row">
                                <div >
                                    <?php
                                         $query = "SELECT * FROM tbl_GetApps ORDER BY get_id DESC";
                                        $resultGet = mysqli_query($conn, $query);
                                    
                                         while($rowGet = mysqli_fetch_array($resultGet))
                                            {
                                                $get = $rowGet['apps_entities'];
                                            }
                                    
                                       $query = "SELECT * FROM tbl_appstore ORDER BY app_id DESC";
                                        $result = mysqli_query($conn, $query);
                                    
                                     while($row = mysqli_fetch_array($result))
                                        {?>
                                            <?php if($row['appType'] != 'LIBRARY') {?>
                                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 " >
                                               <div class="<?php if($row["pricing"] > 0 ){echo "card";}else{echo"cardFree";}?> " data-label="<?php if($row["pricing"] > 0 ){echo '$'.$row["pricing"];}else{echo"FREE";}  ?>">
                                                   <div class="mt-card-item" style="background-color:#EEEEEE; padding: 15px;">
                                                       <div class="mt-card-avatar mt-overlay-1 mt-scroll-down">
                                                           <img src="admin_2/app-store-img/<?php echo $row["images_name"]; ?>" style="height:200px;">
                                                           <div class="mt-overlay">
                                                               <ul class="mt-info">
                                                                   <li>
                                                                       <?php 
                                                                        if($row["pricing"] > 0 ){ ?>
                                                                        <a class="btn default btn-outline" href="javascript:void(0)" data-cb-type="checkout" data-cb-item-0="Library-software-USD-Monthly" data-cb-item-0-quantity="1" >GET</a>
                                                                        <!--    <a class="btn default btn-outline  ">-->
                                                                        <!--    GET-->
                                                                        <!--</a>-->
                                                                       <?php }
                                                                        else{ ?>
                                                                           
                                                                            <a class="btn default btn-outline btnGetFree " data-toggle="modal" href="#modalGetFree" data-id="<?php echo $row["app_id"]; ?>">
                                                                                 GET
                                                                            </a>
                                                                      <?php  }
                                                                        
                                                                       ?>
                                                                    </li>
                                                                    <li>
                                                                        <a class="btn default btn-outline btnView " data-toggle="modal" href="#modalView" data-id="<?php echo $row["app_id"]; ?>">
                                                                            MORE
                                                                        </a>
                                                                   </li>
                                                               </ul>
                                                           </div>
                                                           
                                                       </div>
                                                       <div class="mt-card-content">
                                                           <h3 class="mt-card-name" style="color:#1F4690;font-weight:800;"><?php echo $row["application_name"]; ?></h3>
                                                           <p class="mt-card-desc font-grey-mint" style=" height:110px;"><?php echo $row["descriptions"]; ?></p>
                                                       </div>
                                                   </div>
                                               </div>
                                               </div>
                                               
                                               <!--for library-->
                                               <?php } else if($row['appType'] == 'LIBRARY') {?>
                                               <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 " >
                                               <div class="<?php if($row["pricing"] > 0 ){echo "card";}else{echo"cardFree";}?> " data-label="<?php if($row["pricing"] > 0 ){echo '$'.$row["pricing"];}else{echo"FREE";}  ?>">
                                                   <div class="mt-card-item" style="background-color:#EEEEEE; padding: 15px;">
                                                       <div class="mt-card-avatar mt-overlay-1 mt-scroll-down">
                                                           <img src="admin_2/app-store-img/<?php echo $row["images_name"]; ?>" style="height:200px;">
                                                           <div class="mt-overlay">
                                                               <ul class="mt-info">
                                                                   <li>
                                                                       <?php 
                                                                        if($row["pricing"] > 0 ){ ?>
                                                                        <a class="btn default btn-outline" href="javascript:void(0)" data-cb-type="checkout" data-cb-item-0="Library-software-USD-Monthly" data-cb-item-0-quantity="1" >GET</a>
                                                                        <!--    <a class="btn default btn-outline  ">-->
                                                                        <!--    GET-->
                                                                        <!--</a>-->
                                                                       <?php }
                                                                        else{ ?>
                                                                        
                                                                            <a href="javascript:;" class="btnClone btn default btn-outline" onclick="btnClone(<?php echo $row['appEntities']; ?>)">GET</a>
                                                                      <?php  }
                                                                        
                                                                       ?>
                                                                    </li>
                                                                    <li>
                                                                        <a class="btn default btn-outline btnViewLibrary " data-toggle="modal" href="#modalViewLibrary" data-id="<?php echo $row["app_id"]; ?>">
                                                                            MORE
                                                                        </a>
                                                                   </li>
                                                               </ul>
                                                           </div>
                                                           
                                                       </div>
                                                       <div class="mt-card-content">
                                                       
                                                               <h3 class="mt-card-name" style="color:#1F4690;font-weight:800;"><?php echo $row["application_name"]; ?></h3>
                                                               <p class="mt-card-desc font-grey-mint" style=" height:110px;"><?php echo $row["descriptions"]; ?></p>
                                                         
                                                       </div>
                                                   </div>
                                               </div>
                                               </div>
                                      <?php } }
                                    
                                    ?>


                                </div>
                            </div>
                        </div>
            </div>
        </div>
        <!--End of App Cards-->

        <!-- MODAL AREA-->
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
                                        <div class="modal-header">
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
                                        <div class="modal-header">
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
                                        <div class="modal-header">
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
        <!-- / END MODAL AREA -->

	</div><!-- END CONTENT BODY -->

	<?php include_once ('footer.php'); ?>
    <script>  
$(document).ready(function(){
 
 fetch_data();

 function fetch_data()
 {
  var action = "fetch";
  $.ajax({
   url:"admin_2/app-function/action.php",
   method:"POST",
   data:{action:action},
   success:function(data)
   {
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

  if(image_name == '')
  {
   alert("Please Select Image");
   return false;
  }
  else
  {
   var extension = $('#image').val().split('.').pop().toLowerCase();
   if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
   {
    alert("Invalid Image File");
    $('#image').val('');
    return false;
   }
   else
   {
    $.ajax({
     url:"admin_2/app-function/action.php",
     method:"POST",
     data:new FormData(this),
     contentType:false,
     processData:false,
     success:function(data)
     {
    //   alert(data);
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
     url:"admin_2/app-function/getFreeAppAction.php",
     method:"POST",
     data:new FormData(this),
     contentType:false,
     processData:false,
     success:function(data)
     {
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
     url:"admin_2//app-function/cloneLibrary.php",
     method:"POST",
     data:new FormData(this),
     contentType:false,
     processData:false,
     success:function(data)
     {
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
                    url: "admin_2/app-function/fetchApp.php?modalViewApp="+id,
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
        url: "admin_2/app-function/fetchAppLibrary.php?modalViewApp="+id,
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
                    url: "admin_2/app-function/getFreeApp.php?modalGetFreeApp="+id,
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
  if(confirm("Are you sure you want to remove this?"))
  {
   $.ajax({
    url:"action.php",
    method:"POST",
    data:{app_id:app_id, action:action},
    success:function(data)
    {
     alert(data);
     fetch_data();
    }
   })
  }
  else
  {
   return false;
  }
 });
}); 


// for gallery

let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("demo");
  let captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}

function btnClone(id) {
    $.ajax({
        type: "GET",
        url: "admin_2/function.php?btnClone="+id,
        dataType: "html",
        success: function(data){
            // $("#modalReport .modal-body").html(data);

            alert(data);
        }
    });
}
</script>

	<style>
    .mt_element_card .mt_card_item {
        border: 1px solid;
        border-color: #e7ecf1;
        position: relative;
        margin-bottom: 30px;
    }
    .mt_element_card .mt_card_item .mt_card_avatar {
        margin-bottom: 15px;
    }
    .mt_element_card.mt_card_round .mt_card_item {
        padding: 50px 50px 10px 50px;
    }
    .mt_element_card.mt_card_round .mt_card_item .mt_card_avatar {
        border-radius: 50% !important;
        -webkit-mask-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAA5JREFUeNpiYGBgAAgwAAAEAAGbA+oJAAAAAElFTkSuQmCC);
    }
    .mt_element_card .mt_card_item .mt_card_content {
        text-align: center;
    }
    .mt_element_card .mt_card_item .mt_card_content .mt_card_name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .mt_element_card .mt_card_item .mt_card_content .mt_card_desc {
        font-size: 14px;
        margin: 0 0 10px 0;
       
    }
    .mt_element_overlay .mt_overlay_1 {
        width: 100%;
        height: 100%;
        float: left;
        overflow: hidden;
        position: relative;
        text-align: center;
        cursor: default;
    }
    .mt_element_overlay .mt_overlay_1 img {
        display: block;
        position: relative;
        -webkit-transition: all .4s linear;
        transition: all .4s linear;
        width: 100%;
        height: auto;
        opacity: 0.5;
    }
    
.card{
  width: 25rem;
  border-radius: 1rem;
  background: white;
  box-shadow: 4px 4px 15px rgba(#000, 0.15);
  position : relative;
  color: #434343;
}

.card::before{
  position: absolute;
  top:2rem;
  right:-0.5rem;
  content: '';
  background: #283593;
  height: 28px;
  width: 28px;
  transform : rotate(45deg);
}

.card::after{
  position: absolute;
  content: attr(data-label);
  top: 5px;
  right: -14px;
  padding: 0.5rem;
  width: 6rem;
  background: #3949ab;
  color: white;
  text-align: center;
  font-family: 'Roboto', sans-serif;
  box-shadow: 4px 4px 15px rgba(26, 35, 126, 0.2);
  border-radius: 5px;
}

/*for free cards*/
.cardFree{
  width: 25rem;
  border-radius: 1rem;
  background: white;
  box-shadow: 4px 4px 15px rgba(#000, 0.15);
  position : relative;
  color: #434343;
}

.cardFree::before{
  position: absolute;
  top:2rem;
  right:-0.5rem;
  content: '';
  background: #3CCF4E;
  height: 28px;
  width: 28px;
  transform : rotate(45deg);
}

.cardFree::after{
  position: absolute;
  content: attr(data-label);
  top: 5px;
  right: -14px;
  padding: 0.5rem;
  width: 6rem;
  background: #3CCF4E;
  color: white;
  text-align: center;
  font-family: 'Roboto', sans-serif;
  box-shadow: 4px 4px 15px rgba(26, 35, 126, 0.2);
  border-radius: 5px;
}

/*for gallery view*/

.container-gallery {
  position: relative;
}

/* Hide the images by default */
.mySlides {
  display: none;
}

/* Add a pointer when hovering over the thumbnail images */
.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 40%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: #003865;
  font-weight: bold;
  font-size: 20px;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: #A6D1E6;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* Container for image text */
.caption-container {
  text-align: center;
  background-color: #003865;
  padding: 2px;
  color: white;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Six columns side by side */
.column {
  float: left;
  width: 16.66%;
}

/* Add a transparency effect for thumnbail images */
.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}
    
	</style>
    </body>
</html>