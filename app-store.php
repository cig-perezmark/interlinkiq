<?php
    $title = "App Catalog";
    $site = "app-store";
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
                                <span class="caption-subject font-dark bold uppercase">App Catalog</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tabComply" data-toggle="tab">Compliance</a>
                                </li>
                                <li>
                                    <a href="#tabModule" data-toggle="tab">Modules</a>
                                </li>
                                <li>
                                    <a href="http://sopking.com/" target="_blank">SOPs</a>
                                </li>
                                <li class="hide">
                                    <a href="#FREE" data-toggle="tab">Free</a>
                                </li>
                                <li class="hide">
                                     <a href="#eForm" data-toggle="tab">E - Forms</a>
                                    <!--<a href="http://www.prpblaster.com/qc/forms/afia/list"  target="_blank" >E - Form</a>-->
                                </li>
                                <li class="hide">
                                    <a href="#Services" data-toggle="tab">Services</a>
                                </li>
                                <!--Emjay starts here-->
                                <li>
                                    <a href="#forms" data-toggle="tab">Forms</a>
                                </li>
                                <!--Emjay Codes ends here-->
                                 <?php if($_COOKIE['ID'] == 2 || $_COOKIE['ID'] == 19 || $_COOKIE['ID'] == 1 || $_COOKIE['ID'] == 117 || $_COOKIE['ID'] == 34 || $_COOKIE['ID'] == 163): ?>
                                    <li>
                                        <a href="#Pricing" data-toggle="tab">Pricing</a>
                                    </li>
                                     <li>
                                        <a href="#Clone" data-toggle="tab">Clone</a>
                                    </li>
                                <?php endif ?>
                                 <li>
                                    <a href="#pro_services" data-toggle="tab">Pro-Services</a>
                                </li>
                            </ul>
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
                            <div class="tab-content">
            					<div id="FREE" class="tab-pane hide">
        					    	<table class="table table-bordered">
                                        <thead class="bg-primary">
                                            <tr>
                                                <td>App Name</td>
                                                <td>Description</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $query = "SELECT * FROM tbl_GetApps ORDER BY get_id DESC";
                                            $resultGet = mysqli_query($conn, $query);
                                        
                                            while($rowGet = mysqli_fetch_array($resultGet)) {
                                                $get = $rowGet['apps_entities'];
                                            }
                                            
                                            $query = "SELECT * FROM tbl_appstore where appType = 'ENTERPRISE' ORDER BY app_id DESC";
                                            $result = mysqli_query($conn, $query);
                                            
                                            while($row = mysqli_fetch_array($result))
                                            {?> 
                                                <tr>
                                                    <td>  <?php echo $row['application_name']; ?></td>
                                                    <td> <?php echo $row['descriptions']; ?></td>
                                                    <td> 
                                                        <a class="btn blue btn-outline btnGetFree " data-toggle="modal" href="#modalGetFree" data-id="<?php echo $row["app_id"]; ?>">GET</a>
                                                        <a class="btn green btn-outline btnView " data-toggle="modal" href="#modalView" data-id="<?php echo $row["app_id"]; ?>">MORE</a>
                                                    </td>
                                                </tr>
                                            <?php } ?> 
                                            <!--<tbody class="hide">-->
                                            <?php
                                            $query = "SELECT * FROM tbl_GetApps ORDER BY get_id DESC";
                                            $resultGet = mysqli_query($conn, $query);
                                        
                                            while($rowGet = mysqli_fetch_array($resultGet)) {
                                                $get = $rowGet['apps_entities'];
                                            }
                                            
                                            $query = "SELECT * FROM tbl_appstore where appType = 'IA' ORDER BY app_id DESC";
                                            $result = mysqli_query($conn, $query);
                                            
                                            while($row = mysqli_fetch_array($result))
                                            {?> 
                                                <tr>
                                                    <td>  <?php echo $row['application_name']; ?></td>
                                                    <td> <?php echo $row['descriptions']; ?></td>
                                                    <td> 
                                                       <a class="btn blue btn-outline btnGetFree " data-toggle="modal" href="#modalGetFree" data-id="<?php echo $row["app_id"]; ?>">GET</a>
                                                       <a class="btn green btn-outline btnView " data-toggle="modal" href="#modalView" data-id="<?php echo $row["app_id"]; ?>">MORE</a>
                                                    </td>
                                                </tr>
                                            <?php } ?> 
                                        </tbody>
                                    </table>
            					</div>
            					<!--Emjay starts here-->
                                <div id="forms" class="tab-pane">
                                    <table class="table table-bordered" id="tableForms">
                                        <thead class="bg-primary">
                                            <tr>
                                                <td style="width: 60px;">#</td>
                                                <td>Form Name</td>
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
        					 
        					     <!--Emjay code ends here-->
        					 
                                <div id="tabComply" class="tab-pane active">
                                    <?php
                                        if ($switch_user_id == 1 || $switch_user_id == 19 || $switch_user_id == 163) {
                                            echo '<div class="row margin-bottom-15">
                                                <form method="post" enctype="multipart/form-data" class="formComply">
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="comply_name" placeholder="Quality Systems" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <textarea class="form-control" name="comply_description" placeholder="Description"></textarea>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="submit" class="btn btn-success btn-sm" name="btnSave_Comply" id="btnSave_Comply">Add</button>
                                                    </div>
                                                </form>
                                            </div>';
                                        }
                                    ?>
                                    
                                    <table class="table table-bordered" id="tableComply">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="width: 300px;">Quality Systems</th>
                                                <th>Description</th>
                                                <?php
                                                    if ($switch_user_id == 1 || $switch_user_id == 19 || $switch_user_id == 163) { echo '<th style="width: 135px;" class="text-center">Action</th>'; }
                                                ?>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $selectComply = mysqli_query( $conn,"SELECT * FROM tblDashboardForm WHERE deleted = 0 ORDER BY QualitySystems ASC, Descriptions ASC" );
                                                if ( mysqli_num_rows($selectComply) > 0 ) {
                                                    while($rowData = mysqli_fetch_array($selectComply)) {
                                                        $data_ID = $rowData['Dash_id'];
                                                        $data_name = stripcslashes($rowData['QualitySystems']);
                                                        $data_description = stripcslashes($rowData['Descriptions']);
                                                        
                                                        echo '<tr id="tr_'.$data_ID.'">
                                        	                <td>'.$data_name.'</td>
                                        	                <td>'.$data_description.'</td>';
                                        	                
                                    	                    if ($switch_user_id == 1 || $switch_user_id == 19 || $switch_user_id == 163) {
                                    	                        echo '<td class="text-center">
                                        	                        <div class="btn-group btn-group-circle">
                                        	                            <a href="#modalViewComply" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnViewComply('.$data_ID.')">View</a>
                                        	                            <a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnDeleteComply('.$data_ID.')">Delete</a>
                                                                    </div>
                                                                </td>';
                                    	                    }
                                    	                    
                                        	            echo '</tr>';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="tabModule" class="tab-pane">
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
                                    
                                    <table class="table table-bordered" id="tableModule">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="width: 300px;">Module Name</th>
                                                <th>Description</th>
                                                <?php
                                                    if ($switch_user_id == 1 || $switch_user_id == 19 || $switch_user_id == 163) { echo '<th style="width: 135px;" class="text-center">Action</th>'; }
                                                ?>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $selectModules = mysqli_query( $conn,"SELECT * FROM tblPlugins WHERE deleted = 0 ORDER BY plugin_name ASC" );
                                                if ( mysqli_num_rows($selectModules) > 0 ) {
                                                    while($rowData = mysqli_fetch_array($selectModules)) {
                                                        $data_ID = $rowData['plugin_id'];
                                                        $data_name = stripcslashes($rowData['plugin_name']);
                                                        $data_description = stripcslashes($rowData['plugin_description']);
                                                        $data_available = $rowData['available'];
                                                        $data_menu_id = $rowData['menu_id'];
                                                        
                                                        echo '<tr id="tr_'.$data_ID.'">
                                        	                <td>';
                                        	                
                                        	                    if ($data_available == 1) {
                                        	                        $selectMenu = mysqli_query( $conn,"SELECT * FROM tbl_menu WHERE ID = $data_menu_id" );
                                                                    if ( mysqli_num_rows($selectMenu) > 0 ) {
                                                                        $rowMenu = mysqli_fetch_array($selectMenu);
                                                                        $data_url = $rowMenu['url'];
                                                                        
                                                                        echo '<a href="'.$data_url.'" class="blue-steel bold" target="_blank">'.$data_name.'</a>';
                                                                    } else {
                                                                        echo $data_name;
                                                                    }
                                        	                    } else {
                                                                    echo $data_name;
                                                                }
                                                                
                                        	                echo '</td>
                                        	                <td>'.$data_description.'</td>';
                                        	                
                                    	                    if ($switch_user_id == 1 || $switch_user_id == 19 || $switch_user_id == 163) {
                                    	                        echo '<td class="text-center">
                                        	                        <div class="btn-group btn-group-circle">
                                        	                            <a href="#modalViewModule" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnViewModule('.$data_ID.')">View</a>
                                        	                            <a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnDeleteModule('.$data_ID.')">Delete</a>
                                                                    </div>
                                                                </td>';
                                    	                    }
                                    	                    
                                        	            echo '</tr>';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="tabSOP" class="tab-pane">
                                    <?php
                                        if ($switch_user_id == 1 || $switch_user_id == 19 || $switch_user_id == 163) {
                                            echo '<div class="row margin-bottom-15">
                                                <form method="post" enctype="multipart/form-data" class="formSOP">
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="category_name" placeholder="Category Name" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <textarea class="form-control" name="category_description" placeholder="Topic / Area"></textarea>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="submit" class="btn btn-success btn-sm" name="btnSave_SOP" id="btnSave_SOP">Add</button>
                                                    </div>
                                                </form>
                                            </div>';
                                        }
                                    ?>
                                    
                                    <table class="table table-bordered" id="tableSOP">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="width: 300px;">Category</th>
                                                <th>Topic / Area</th>
                                                <?php
                                                    if ($switch_user_id == 1 || $switch_user_id == 19 || $switch_user_id == 163) { echo '<th style="width: 135px;" class="text-center">Action</th>'; }
                                                ?>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $selectSOP = mysqli_query( $conn,"SELECT * FROM tbl_SOPs WHERE deleted = 0 ORDER BY Category ASC" );
                                                if ( mysqli_num_rows($selectSOP) > 0 ) {
                                                    while($rowData = mysqli_fetch_array($selectSOP)) {
                                                        $data_ID = $rowData['sops_id'];
                                                        $data_category = stripcslashes($rowData['Category']);
                                                        $data_description = stripcslashes($rowData['Topic_Area']);
                                                        
                                                        echo '<tr id="tr_'.$data_ID.'">
                                        	                <td>'.$data_category.'</td>
                                        	                <td>'.$data_description.'</td>';
                                        	                
                                    	                    if ($switch_user_id == 1 || $switch_user_id == 19 || $switch_user_id == 163) {
                                    	                        echo '<td class="text-center">
                                        	                        <div class="btn-group btn-group-circle">
                                        	                            <a href="#modalViewSOP" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnViewSOP('.$data_ID.')">View</a>
                                        	                            <a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnDeleteSOP('.$data_ID.')">Delete</a>
                                                                    </div>
                                                                </td>';
                                    	                    }
                                    	                    
                                        	            echo '</tr>';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                
        				        <div id="eForm" class="tab-pane">
            				        <table class="table table-bordered">
            				            <thead class="bg-primary">
            				                <tr>
            		                            <td style="width: 60px;">#</td>
            				                    <td>Category</td>
            				                    <td>Forms</td>
            				                    <td>Purpose</td>
            				                </tr>
            				            </thead>
            				            <tbody>
            				                <?php
                                            $query = "SELECT * FROM tbleForms";
                                            $result = mysqli_query($conn, $query);
                                                
                                            while($row = mysqli_fetch_array($result))
                                            {?> 
                				                <tr>
                					                 <td>
                					                     <?php echo $row['Category']; ?>
                					                 </td>
                					                 <td>
                					                     <?php echo $row['E-Forms']; ?>
                					                 </td>
                					                 <td>
                					                     <?php echo $row['Purpose']; ?>
                					                 </td>
                					             </tr>
            					            <?php }?>
            				            </tbody>
            				        </table>
            					</div>
        					    <div id="Clone" class="tab-pane">
        					        <table class="table table-bordered" id="tablePricing">
                                        <thead class="bg-primary">
                                            <tr>
                                                <td style="width: 60px;">#</td>
                                                <td>App Name</td>
                                                <td>Description</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                             $query = "SELECT * FROM tbl_GetApps ORDER BY get_id DESC";
                                            $resultGet = mysqli_query($conn, $query);
                                            $i = 1;
                                            while($rowGet = mysqli_fetch_array($resultGet)) {
                                                $get = $rowGet['apps_entities'];
                                            }
                                            
                                            $query = "SELECT * FROM tbl_appstore where appType = 'LIBRARY' ORDER BY app_id DESC";
                                            $result = mysqli_query($conn, $query);
                                            
                                            while($row = mysqli_fetch_array($result))
                                            {?> 
                                                <tr>
                                                    <td><?php echo $i++;?></td>
                                                    <td>  <?php echo $row['application_name']; ?></td>
                                                    <td> <?php echo $row['descriptions']; ?></td>
                                                    <td> 
                                                        <a href="javascript:;" class="btnClone btn default btn-outline" onclick="btnClone(<?php echo $row['appEntities']; ?>)">GET</a>
                                                       <!--<a class="btn green btn-outline btnView " data-toggle="modal" href="#modalView" data-id="<?php echo $row["app_id"]; ?>">-->
                                                       <!--                                 MORE-->
                                                       <!-- </a>-->
                                                    </td>
                                                </tr>
                                            <?php }?> 
                                        </tbody>
                                    </table>
                                    <div class="mt-element-card mt-card-round mt-element-overlay hide">
                                        <div class="row">
                                            <div >
                                                <?php
                                                $query = "SELECT * FROM tbl_GetApps ORDER BY get_id DESC";
                                                $resultGet = mysqli_query($conn, $query);
                                            
                                                while($rowGet = mysqli_fetch_array($resultGet)) {
                                                    $get = $rowGet['apps_entities'];
                                                }
                                            
                                                $query = "SELECT * FROM tbl_appstore where appType = 'LIBRARY' ORDER BY app_id DESC";
                                                $result = mysqli_query($conn, $query);
                                            
                                                while($row = mysqli_fetch_array($result))
                                                {?> 
                                                        <!--for library-->
                                                        <?php if($row['appType'] == 'LIBRARY') {?>
                                                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 " >
                                                           <div class="<?php if($row["pricing"] > 0 ){echo "card";}else{echo"cardFree";}?> " data-label="<?php if($row["pricing"] > 0 ){echo '$'.$row["pricing"];}else{echo"SUBSCRIBE";}  ?>">
                                                                <div class="mt-card-item" style="background-color:#EEEEEE; padding: 15px;">
                                                                   <div class="mt-card-avatar mt-overlay-1 mt-scroll-down">
                                                                       <img src="app-store-img/<?php echo $row["images_name"]; ?>" style="height:200px;">
                                                                       <div class="mt-overlay">
                                                                           <ul class="mt-info">
                                                                               <li>
                                                                                    <?php if($row["pricing"] > 0 ){ ?>
                                                                                        <a class="btn default btn-outline" href="javascript:void(0)" data-cb-type="checkout" data-cb-item-0="Library-software-USD-Monthly" data-cb-item-0-quantity="1" >GET</a>
                                                                                        <!--    <a class="btn default btn-outline  ">-->
                                                                                        <!--    GET-->
                                                                                        <!--</a>-->
                                                                                    <?php } else { ?>
                                                                                        <a href="javascript:;" class="btnClone btn default btn-outline" onclick="btnClone(<?php echo $row['appEntities']; ?>)">GET</a>
                                                                                    <?php } ?>
                                                                                </li>
                                                                                <li>
                                                                                    <a class="btn default btn-outline btnViewLibrary " data-toggle="modal" href="#modalViewLibrary" data-id="<?php echo $row["app_id"]; ?>">MORE</a>
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
                                                        <?php }
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="Services" class="tab-pane">
                                    <center><h3 style="color:#1C3879;font-weight:800;">Services are available as Project Based or as an End to End Full Support Services</h3></center>
                                    <br>
                                    <table class="table table-bordered">
                                        <thead class="bg-primary">
                                            <tr>
                                                <td>#</td>
                                                <td>Services</td>
                                                <td>Areas</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $query = "SELECT * FROM tblServicesIQ where Category = 'PB' order by iq_id ASC";
                                            $result = mysqli_query($conn, $query);
                                                
                                            while($row = mysqli_fetch_array($result))
                                            {?>
                                                <tr>
                                                    <td><?php echo $i++;?></td>
                                                    <td><?php echo $row["Services"]; ?></td>
                                                    <td><?php echo $row["Areas"]; ?> <i style="font-weight:800;color:#002B5B;">&nbsp;<?php  if($row["Status"] != ''){echo "(".$row["Status"].")";}else{echo '';} ?></i></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <thead class="bg-primary" style="border:transparent;font-size:18px;">
                                            <tr>
                                                <td style="text-align:right;border:transparent;font-size:18px;">QMS/QS/FSMS</td>
                                                <td style="border:transparent;font-size:18px;">Customization Management</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            $query = "SELECT * FROM tblServicesIQ where Category = 'QMS' order by iq_id ASC";
                                            $result = mysqli_query($conn, $query);
                                            
                                            while($row = mysqli_fetch_array($result))
                                            {?>
                                                <tr>
                                                    <td><?php echo $row["Services"]; ?></td>
                                                    <td><?php echo $row["Areas"]; ?> <i style="font-weight:800;color:#002B5B;">&nbsp;<?php  if($row["Status"] != ''){echo "(".$row["Status"].")";}else{echo '';} ?></i></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <thead class="bg-primary" style="border:transparent;font-size:18px;">
                                            <tr>
                                                <td style="text-align:right;border:transparent;font-size:18px;">Regulatory Compliance (CFR, FDA, 	</td>
                                                <td style="border:transparent;font-size:18px;">USDA, USDC, FTC) Management</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            $query = "SELECT * FROM tblServicesIQ where Category = 'RCM' order by iq_id ASC";
                                            $result = mysqli_query($conn, $query);
                                                
                                            while($row = mysqli_fetch_array($result))
                                            {?>
                                                <tr>
                                                    <td><?php echo $row["Services"]; ?></td>
                                                    <td><?php echo $row["Areas"]; ?> <i style="font-weight:800;color:#002B5B;">&nbsp;<?php  if($row["Status"] != ''){echo "(".$row["Status"].")";}else{echo '';} ?></i></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <table class="table table-bordered">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <td style="border:transparent;font-size:18px;text-align:center;">Customer Audit Requirements Management	</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = "SELECT * FROM tblServicesIQ where Category = 'CARM' ";
                                                    $result = mysqli_query($conn, $query);
                                                        
                                                    while($row = mysqli_fetch_array($result))
                                                    {?>
                                                        <tr>
                                                            <td><?php echo $row["Services"]; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <table class="table table-bordered">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <td style="border:transparent;font-size:18px;text-align:center;">Accreditation Requirements Management	</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = "SELECT * FROM tblServicesIQ where Category = 'ARM' ";
                                                    $result = mysqli_query($conn, $query);
                                                    
                                                    while($row = mysqli_fetch_array($result))
                                                    {?>
                                                        <tr>
                                                            <td><?php echo $row["Services"]; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <table class="table table-bordered">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <td style="border:transparent;font-size:18px;text-align:center;">Third-Party Document Control Management	</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = "SELECT * FROM tblServicesIQ where Category = 'DCM' ";
                                                    $result = mysqli_query($conn, $query);
                                                        
                                                    while($row = mysqli_fetch_array($result))
                                                    {?>
                                                        <tr>
                                                            <td><?php echo $row["Services"]; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="SAP" class="tab-pane">
                                    <div class="mt-element-card mt-card-round mt-element-overlay">
                                        <div class="row">
                                            <div >
                                                <?php
                                                
                                                $i = 1;
                                                 $query = "SELECT * FROM tbl_GetApps ORDER BY get_id DESC";
                                                $resultGet = mysqli_query($conn, $query);
                                            
                                                while($rowGet = mysqli_fetch_array($resultGet)) {
                                                    $get = $rowGet['apps_entities'];
                                                }
                                            
                                                $query = "SELECT * FROM tbl_appstore where appType = 'SAP' ORDER BY app_id DESC";
                                                $result = mysqli_query($conn, $query);
                                                
                                                while($row = mysqli_fetch_array($result))
                                                {?>
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 " >
                                                       <div class="<?php if($row["pricing"] > 0 ){echo "card";}else{echo"cardFree";}?> " data-label="<?php if($row["pricing"] > 0 ){echo '$'.$row["pricing"];}else{echo"FREE";}  ?>">
                                                            <div class="mt-card-item" style="background-color:#EEEEEE; padding: 15px;">
                                                                <div class="mt-card-avatar mt-overlay-1 mt-scroll-down">
                                                                    <img src="app-store-img/<?php echo $row["images_name"]; ?>" style="height:200px;">
                                                                    <div class="mt-overlay">
                                                                       <ul class="mt-info">
                                                                           <li>
                                                                                <?php  if($row["pricing"] > 0 ){ ?>
                                                                                <a class="btn default btn-outline" href="javascript:void(0)" data-cb-type="checkout" data-cb-item-0="Library-software-USD-Monthly" data-cb-item-0-quantity="1" >GET</a>
                                                                                <!--    <a class="btn default btn-outline  ">-->
                                                                                <!--    GET-->
                                                                                <!--</a>-->
                                                                                <?php } else{ ?>
                                                                                    <a class="btn default btn-outline btnGetFree " data-toggle="modal" href="#modalGetFree" data-id="<?php echo $row["app_id"]; ?>">GET</a>
                                                                                <?php } ?>
                                                                            </li>
                                                                            <li>
                                                                                <a class="btn default btn-outline btnView " data-toggle="modal" href="#modalView" data-id="<?php echo $row["app_id"]; ?>">MORE</a>
                                                                           </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-card-content">
                                                                   <h3 class="mt-card-name" style="color:#1F4690;font-weight:800;"><?php echo $row["application_name"]; ?></h3>
                                                                   <p class="mt-card-desc font-grey-mint" style=" height:140px;"><?php echo $row["descriptions"]; ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!--for library-->
                                                <?php } ?>
            
            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="Pricing" class="tab-pane">
                                    <?php if($_COOKIE['ID'] == 34 || $switch_user_id == 163): ?>
                                    <div class="panel panel-default" style="padding:0px;border:solid #fff 1px;">
                                        <div class="panel-heading" style="padding:0px;background-color:#fff;border:solid #fff 1px;">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#add_toggle"> 
                                                    <button class="btn btn-info btn-xs"><i class="fa fa-plus"></i> Add New</button>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="add_toggle" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                 <form method="post" class="form-horizontal modalForm modal_new_pricing">
                                                        <div class="form-group">
                                                            <div class="col-md-3">
                                                                <label class="control-label">Category</label>
                                                                <input class="form-control" name="Category" value="<?= $row['Category']; ?>">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="control-label">Description</label>
                                                                <textarea class="form-control" name="Description" ><?= $row['Description']; ?></textarea>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="control-label">Monthly Subscription</label>
                                                                <input class="form-control" type="number" name="MonthlySubscription" value="<?= $row['MonthlySubscription']; ?>">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="control-label" >Type</label>
                                                                <select class="form-control" id="Status_tbl" name="Status" required>
                                                                    <option value="">--Select--</option>
                                                                    <option value="Y">Dashboard</option>
                                                                    <option value="E">Enterprise</option>
                                                                    <option value="B">E - Forms</option>
                                                                    <option value="IT">IT Services</option>
                                                                    <option value="PT">Plugin Tools</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label class="control-label">...</label>
                                                                <input class="form-control btn green" type="submit" name="btnNew_pricing" id="btnNew_pricing" value="Save" >
                                                            </div>
                                                        </div>
                                                    </form>
                                            </div>
                                        </div>
                                    </div>  
                                    <?php endif; ?>
                                    
        					    	<table class="table table-bordered">
                                        <thead class="bg-primary">
                                            <tr>
                                                <td>Category</td>
                                                <td>Description</td>
                                                <td>Monthly Subscription</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody id="Y">
                                            <?php
                                            $query = "SELECT * FROM tblPricing where Status = 'Y'  ORDER BY pricing_id ASC";
                                            $result = mysqli_query($conn, $query);
                                            
                                            while($row = mysqli_fetch_array($result))
                                            {?> 
                                                <tr id="tbl_row_<?= $row['pricing_id']; ?>">
                                                    <td><?php echo $row['Category']; ?></td>
                                                    <td><?php echo $row['Description']; ?></td>
                                                    <td>$<?php echo $row['MonthlySubscription']; ?></td>
                                                    <td>
                                                        <?php if($_COOKIE['ID'] == 34 || $switch_user_id == 163): ?>
                                                        <div class="btn-group btn-group-circle">
                                                           
                            	                            <a  href="#modal_update_pricing" data-toggle="modal" type="button" id="update_pricing" data-id="<?php echo $row['pricing_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                    	                    <a href="#modal_delete_pricing" data-toggle="modal" type="button" id="delete_pricing" data-id="<?php echo $row['pricing_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                                        </div>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                            <tbody class="bg-success">
                                                <tr>
                                                    <td></td><td></td><td></td><td></td>
                                                </tr>
                                            </tbody>
                                            <tbody id="E">
                                            <?php
                                                $query = "SELECT * FROM tblPricing where Status = 'E'  ORDER BY pricing_id ASC";
                                                $result = mysqli_query($conn, $query);
                                                
                                                while($row = mysqli_fetch_array($result))
                                                {?> 
                                                    <tr id="tbl_row_<?= $row['pricing_id']; ?>">
                                                        <td><?php echo $row['Category']; ?></td>
                                                        <td><?php echo $row['Description']; ?></td>
                                                        <td>$<?php echo $row['MonthlySubscription']; ?></td>
                                                        <td>
                                                            <?php if($_COOKIE['ID'] == 34 || $switch_user_id == 163): ?>
                                                            <div class="btn-group btn-group-circle">
                                                               
                                	                            <a  href="#modal_update_pricing" data-toggle="modal" type="button" id="update_pricing" data-id="<?php echo $row['pricing_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                        	                    <a href="#modal_delete_pricing" data-toggle="modal" type="button" id="delete_pricing" data-id="<?php echo $row['pricing_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                                            </div>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                            <?php }?>
                                            </tbody>
                                            <tbody class="bg-success">
                                                <tr>
                                                    <td></td><td></td><td></td><td></td>
                                                </tr>
                                            </tbody>
                                            <tbody id="B">
                                            <?php
                                                $query = "SELECT * FROM tblPricing where Status = 'B'  ORDER BY pricing_id ASC";
                                                $result = mysqli_query($conn, $query);
                                                while($row = mysqli_fetch_array($result)){?> 
                                                <tr id="tbl_row_<?= $row['pricing_id']; ?>">
                                                    <td>  <?php echo $row['Category']; ?></td>
                                                    <td> <?php echo $row['Description']; ?></td>
                                                    <td> 
                                                      $<?php echo $row['MonthlySubscription']; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($_COOKIE['ID'] == 34 || $switch_user_id == 163): ?>
                                                        <div class="btn-group btn-group-circle">
                                                           
                            	                            <a  href="#modal_update_pricing" data-toggle="modal" type="button" id="update_pricing" data-id="<?php echo $row['pricing_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                    	                    <a href="#modal_delete_pricing" data-toggle="modal" type="button" id="delete_pricing" data-id="<?php echo $row['pricing_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                                        </div>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php }?> 
                                            </tbody>
                                            <tbody class="bg-success">
                                                <tr>
                                                    <td></td><td></td><td></td><td></td>
                                                </tr>
                                            </tbody>
                                            <tbody id="PT">
                                            <?php
                                               $query = "SELECT * FROM tblPricing where Status = 'PT'  ORDER BY Category ASC";
                                                $result = mysqli_query($conn, $query);
                                                while($row = mysqli_fetch_array($result))
                                                {?> 
                                                <tr id="tbl_row_<?= $row['pricing_id']; ?>">
                                                    <td>  <?php echo $row['Category']; ?></td>
                                                    <td> <?php echo $row['Description']; ?></td>
                                                    <td> 
                                                      $<?php echo $row['MonthlySubscription']; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($_COOKIE['ID'] == 34 || $switch_user_id == 163): ?>
                                                        <div class="btn-group btn-group-circle">
                                                           
                            	                            <a  href="#modal_update_pricing" data-toggle="modal" type="button" id="update_pricing" data-id="<?php echo $row['pricing_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                    	                    <a href="#modal_delete_pricing" data-toggle="modal" type="button" id="delete_pricing" data-id="<?php echo $row['pricing_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                                        </div>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php }?> 
                                            </tbody>
                                        <thead class="bg-primary">
                                            <tr>
                                                <td>Category</td>
                                                <td>Description</td>
                                                <td>Project Based Fee</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody id="IT">
                                            <?php
                                               
                                            
                                               $query = "SELECT * FROM tblPricing where Status = 'IT'  ORDER BY pricing_id ASC";
                                                $result = mysqli_query($conn, $query);
                                            
                                             while($row = mysqli_fetch_array($result))
                                                {?> 
                                            <tr id="tbl_row_<?= $row['pricing_id']; ?>">
                                                <td>  <?php echo $row['Category']; ?></td>
                                                <td> <?php echo $row['Description']; ?></td>
                                                <td> 
                                                  $<?php echo $row['MonthlySubscription']; ?>
                                                </td>
                                                <td>
                                                    <?php if($_COOKIE['ID'] == 34 || $switch_user_id == 163): ?>
                                                        <div class="btn-group btn-group-circle">
                                                           
                            	                            <a  href="#modal_update_pricing" data-toggle="modal" type="button" id="update_pricing" data-id="<?php echo $row['pricing_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                    	                    <a href="#modal_delete_pricing" data-toggle="modal" type="button" id="delete_pricing" data-id="<?php echo $row['pricing_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                                        </div>
                                                        <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php }?> 
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div id="pro_services" class="tab-pane">
                                    <?php
                                        if ($switch_user_id == 1 || $switch_user_id == 19 || $switch_user_id == 163) {
                                            echo '<div class="row margin-bottom-15">
                                                <form method="post" enctype="multipart/form-data" class="formProServices">
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="name" placeholder="Service Name" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="file" class="form-control" name="file" placeholder="Select File" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="submit" class="btn btn-success btn-sm" name="btnSave_ProServices" id="btnSave_ProServices">Add</button>
                                                    </div>
                                                </form>
                                            </div>';
                                        }
                                    ?>
                                    
                                    <table class="table table-bordered" id="tableProServices">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th>Services</th>
                                                <th class="text-center" style="width: 135px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $selectProServices = mysqli_query( $conn,"SELECT * FROM tbl_app_pro_service WHERE deleted = 0 ORDER BY name ASC" );
                                                if ( mysqli_num_rows($selectProServices) > 0 ) {
                                                    while($rowData = mysqli_fetch_array($selectProServices)) {
                                                        $data_ID = $rowData['ID'];
                                                        $data_name = stripcslashes($rowData['name']);
                    
                                                        $data_file = $rowData['file'];
                                                        $fileExtension = fileExtension($data_file);
                                                        $src = $fileExtension['src'];
                                                        $embed = $fileExtension['embed'];
                                                        $type = $fileExtension['type'];
                                                        $file_extension = $fileExtension['file_extension'];
                                                        $url = $base_url.'uploads/pro_services/';
                                                        
                                                        echo '<tr id="tr_'.$data_ID.'">
                                        	                <td>'.$data_name.'</td>
                                        	                <td class="text-center">';
                                        	                    if ($switch_user_id == 1 || $switch_user_id == 19 || $switch_user_id == 163) {
                                        	                        echo '<div class="btn-group btn-group-circle">
                                        	                            <a href="#modalProServiceNotice" data-toggle="modal" class="btn btn-outline dark btn-sm">View</a>
                                                	                    <a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnDelete('.$data_ID.')">Delete</a>
                                                                    </div>';
                                        	                    } else {
                                        	                        echo '<a href="#modalProServiceNotice" data-toggle="modal">View</a>';
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
            
            $(document).ready(function() {
                // $('#tableComply, #tableModule, #tableSOP, #tableProServices, #tableProServices, #tableProServices, #tableProServices').dataTable( {
                //   "columnDefs": [
                //     { "width": "auto" }
                //   ]
                // } );
                
                $('#tableComply, #tableModule, #tableSOP, #tableProServices, #tablepricing, #tableForms').dataTable();
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