<?php
    $title = "Forms";
    $site = "forms";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('database.php');
    include_once ('header.php'); 
    error_reporting(0);
?>
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
      width: 9rem;
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
    /*.prev,*/
    /*.next {*/
    /*  cursor: pointer;*/
    /*  position: absolute;*/
    /*  top: 40%;*/
    /*  width: auto;*/
    /*  padding: 16px;*/
    /*  margin-top: -50px;*/
    /*  color: #003865;*/
    /*  font-weight: bold;*/
    /*  font-size: 20px;*/
    /*  border-radius: 0 3px 3px 0;*/
    /*  user-select: none;*/
    /*  -webkit-user-select: none;*/
    /*}*/
    
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
    
    /* Style the tab */
    .tab {
      overflow: hidden;
      border: 1px solid #ccc;
      background-color: #f1f1f1;
    }
    
    /* Style the buttons inside the tab */
    .tab button {
      background-color: inherit;
      float: left;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 8px 10px;
      transition: 0.3s;
      font-size: 14px;
    }
    
    /* Change background color of buttons on hover */
    .tab button:hover {
      background-color: #ddd;
    }
    
    /* Create an active/current tablink class */
    .tab button.active {
     font-weight:600;
     color:#003865;
      background-color: #F1F1F1;
      border-bottom:solid #003865 4px;
    }
    
    /* Style the tab content */
    .tabcontent{
      display: none;
      padding: 6px 12px;
      border: 1px solid #ccc;
      border-top: none;
    }
    .tabcontent2{
      display: block;
      padding: 6px 12px;
      border: 1px solid #ccc;
      border-top: none;
    }
    
    
    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {
        position: relative;
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
                                <span class="caption-subject font-dark bold uppercase">Forms</span>
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
                                    
                            <table class="table table-bordered" id="tableForms">
                                <thead class="bg-primary">
                                    <tr>
                                        <td style="width: 60px;">#</td>
                                        <td>Form Name</td>
                                        <td>Description</td>
                                        <td class="text-center" style="width: 205px;">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $check_form_owned = mysqli_query($conn,"SELECT * FROM tbl_forms_owned WHERE user_id = $current_userID");
                                        $check_result = mysqli_fetch_array($check_form_owned);
                                        $array_counter = explode(",", $check_result["form_owned"]); 
                                                    
                                        $query = "SELECT * FROM tbl_afia_forms_list WHERE afl_status_flag = 'A' ORDER BY afl_form_name ASC";
                                        $result = mysqli_query($e_connection, $query);
                                            
                                        $form_counting = 1;
                                        while($row = mysqli_fetch_array($result)) {
                                            $style = '';
                                            if($row['is_new'] == 1){
                                                $style = 'class="bg-warning"';
                                            }
                                            if (!in_array($row['PK_id'], array(44, 52, 53, 54, 61, 55, 56, 57, 58, 59, 60))) {
                                                echo '<tr '.$style.'>
                                                     <td>'.$form_counting++.'</td>
                                                     <td>'.$row['afl_form_name'].'</td>
                                                     <td  eforms_id="'.$row['PK_id'].'" contenteditable oninput="change_Description(this)">'.$row['form_desc'].'</td>
                                                     <td class="text-center"> 
                                                        <a href="/e-forms/forms/interlink/'.$row['afl_form_code'].'" onclick="myfunction('.$current_userEmployerID.')" target="_blank" class="btn green btn-outline">View</a>';
                                                        
                                                        if($_COOKIE['ID'] == 108 OR $switch_user_id == 163 OR$_COOKIE['ID'] == 481) {
                                                           // foreach($array_counter as $form_id) {
                                                           //     if($row['PK_id'] == $form_id){
                                                                    
                                            //                         echo '<style type="text/css">.form_class'.$row['PK_id'].'{ display:none; }</style>';
                                                           //     }
                                                     //       }
                                                            echo '<a id="get_form" form_id="'.$row['PK_id'].' " class="btn blue btn-outline form_class'.$row['PK_id'].'">Clone</a>';
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
                <!--End of App Cards-->

                <!-- MODAL AREA-->

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
            function change_Description(label) {
                var newValue = label.textContent; // Get the new value of the label
                var eformsId = label.getAttribute('eforms_id'); // Get the eforms_id
            
                // Send an AJAX request to update the database
                $.ajax({
                    url: 'controller.php', // Your PHP script to update the database
                    method: 'POST',
                    data: {
                        save_form_desc: 1,
                        eforms_id: eformsId,
                        form_desc: newValue
                    },
                    success: function(response) {
                        console.log('Database updated successfully!');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating database:', error);
                    }
                });
            }
            $(document).ready(function() {
                $('#tableForms').dataTable({
                    paging: false
                });
            });
            
            
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

                            var obj = jQuery.parseJSON(response);
                            $('#tableModule').prepend(obj.data);
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

                            var obj = jQuery.parseJSON(response);
                            $("#tableModule tbody #tr_"+obj.ID).html(obj.data);
                            $('#modalViewModule').modal('hide');
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