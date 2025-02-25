<?php
    $title = "Module";
    $site = "module";
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
                                if ($switch_user_id == 1 || $switch_user_id == 19 || $switch_user_id == 163) {
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
                            ?>
                                    
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="text-center image-container">
                                        <img src="uploads/HACCP.webp" class="rounded" alt="..." style="height:150px">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center image-container">
                                        <img src="uploads/HACCP.webp" class="rounded" alt="..." style="height:150px">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center image-container">
                                        <img src="uploads/HACCP.webp" class="rounded" alt="..." style="height:150px">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center image-container">
                                        <img src="uploads/HACCP.webp" class="rounded" alt="..." style="height:150px">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center image-container">
                                        <img src="uploads/HACCP.webp" class="rounded" alt="..." style="height:150px">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center image-container">
                                        <img src="uploads/HACCP.webp" class="rounded" alt="..." style="height:150px">
                                    </div>
                                </div>
                            </div>
        				</div>
                    </div>
                </div>
                <!--End of App Cards-->

                
    			<?php // include('app-function/app_modal.php'); ?>
                <!-- / END MODAL AREA -->
    	    </div><!-- END CONTENT BODY -->
        
    	<?php include('footer.php'); ?>
    	
    	
        <script src="assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    </body>
</html>
<style>
    .image-container {
        transition: transform 0.3s ease;
    }
    .image-container:hover {
        transform: scale(1.1);
        cursor:pointer;
    }
</style>
