<?php 
    $title = "Batch Production Management Software";
    $site = "batchproduction";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';
    
    if(isset($_GET['fetchBatch'])) {
        include_once __DIR__ .'/database_iiq.php';
        include_once __DIR__ . '/alt-setup/setup.php';
        
        $result = mysqli_query( $conn,"SELECT * FROM tbl_products WHERE deleted = 0 AND user_id = $user_id" );

        $data = [];
        if ( mysqli_num_rows($result) > 0 ) {
            while($row = mysqli_fetch_array($result)) {
                $data_image = $row['image'];
                $url_base = "";
                $image_main = "https://via.placeholder.com/40x40/EFEFEF/AAAAAA&text=No+Image";


                $data_category_id = $row['category'];
                if ($data_category_id == 9) {
                    $category = $row['category_other'];
                } else {
                    $resultCategory = mysqli_query( $conn,"SELECT * FROM tbl_products_category WHERE ID = $data_category_id" );
                    $rowCategory = mysqli_fetch_array($resultCategory);
                    $category = $rowCategory['name'];
                }
                
                $data[] = [
                    'id' => $row['ID'],
                    'ID' => $row['ID'],
                    'image' => $url_base.$image_main,
                    'description' => htmlentities($row["description"]),
                    'name' => htmlentities($row["name"]),
                    'code' => $row['code'],
                    'formulation' => $row['formulation'],
                    'upc' => htmlentities($row["upc"]),
                    'manufactured_by' => htmlentities($row["manufactured_by"]),
                    'manufactured_for' => htmlentities($row["manufactured_for"]),
                    'unit' => htmlentities($row["unit"]),
                    'boxes' => htmlentities($row["boxes"]),
                    'category' => $category,
                    'last_update' => $row["last_modified"]
                ];
            }
        }
        exit(json_encode($data));
    }

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

<style type="text/css">

    .modal .productMain p,
    .modal .productAngle p {
        margin: 0;
    }
    .modal .productMain .fileinput,
    .modal .productAngle .fileinput {
        width: 100%;
    }
    .modal .productMain .thumbnail {
        width: 100%;
        height: 250px;
    }
    .modal .productAngle .thumbnail {
        width: 100%;
        height: 90px;
    }
    .modal .productMain .fileinput-preview,
    .modal .productAngle .fileinput-preview {
        width: 100%;
        position: relative;
    }
    .modal .productMain .fileinput-preview img,
    .modal .productAngle .fileinput-preview img {
        margin: auto;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }
    .modal .productGallery {
        border: 1px solid #ddd;
        height:85px;
        overflow-y:scroll;
    }
    
    .manu-details .row {
        display: none;
    }
    
    .manu-details:has(input:checked) .row {
        display: block;
    }
    .manu-details:has(input:checked) label.mt-checkbox {
        font-weight: 600;
    }

    .mt-repeater > div > .mt-repeater-item-hide:first-child {
        display: none;
    }
    
    #productsTable td {
        vertical-align: middle !important;
    }


</style>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light portlet-fit box grey ">
                            <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <i class="icon-wrench font-dark"></i>
                                <span class="caption-subject font-dark bold uppercase">Batch Production</span>
                                </div>
                                    <div class="actions">
                                        <div class="btn-group">

                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>

                                            </a>
                                            <ul class="dropdown-menu pull-right">

                                                <li>

                                                <a data-toggle="modal" href="#modalNew" class="btn btn-light btn-shadow font-weight-bold mr-2" onclick="btnReset('modalNew')" >Add New</a>

                                                    <!-- <a data-toggle="modal" href="#modalNew" onclick="btnReset('modalNew')" >Add New</a> -->
                                                </li>

                                                <!-- <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163): ?>
                                                    <li>
                                                        <a data-toggle="modal" data-target="#modalInstruction" onclick="btnInstruction()">Add New Instruction</a>
                                                    </li>
                                                <?php endif; ?> -->

                                            </ul>
                                        </div>
                                    </div>

                                    <ul class="nav nav-tabs">
                                        <li class="active">

                                            <a href="#tab_actions_pdetails" data-toggle="tab">Product Details</a>
                                        </li>


                                        <li>
                                            <a href="#tab_actions_Reference" data-toggle="tab">Reference Documents</a>
                                        </li>

                                        <li>
                                            <a href="#tab_actions_Raw" data-toggle="tab">Raw Materials</a>
                                        </li>
                                        
                                        <li>
                                            <a href="#tab_actions_materials" data-toggle="tab">Packaging Materials</a>
                                        </li>

                                        <li >
                                            <a href="#tab_actions_Labels" data-toggle="tab">Labels</a>
                                        </li>

                                        <li >
                                            <a href="#tab_actions_Processing_Equipment" data-toggle="tab">Processing Equipment</a>
                                        </li>


                                        <li >
                                            <a href="#tab_actions_Production_Procedures" data-toggle="tab">Production Procedures</a>
                                        </li>


                                        <li class="hide">
                                            <a href="#tab_actions_Deviation_Record" data-toggle="tab">Deviation Record</a>
                                        </li>
                                                                       
                                        <!-- <li>
                                            <a href="#tab_actions_ingredients" data-toggle="tab">Ingredients</a>
                                        </li> -->

                                        <!-- <?php
                                            if ($current_client == 0) {
                                                echo '<li>
                                                    <a href="#tab_actions_template" data-toggle="tab">Materials</a>
                                                </li>';
                                            }
                                        ?> -->
                                        
                                    </ul>

                                </div>

                        <div class="portlet-body">

                            <div class="tab-content">

                                <div class="tab-pane active" id="tab_actions_pdetails">
                                    <table class="table table-bordered table-hover" id="productsTable">
                                        <thead>
                                            <tr>                                                                                   
                                                <th style="width: 20px;">Batch Record No.</th> 
                                                <th style="width: 180px;">Product Name</th>                                               
                                                <th style="width: 170px;">Product Code</th>
                                                <th style="width: 150px;">Formula Code</th>
                                                <th style="width: 135px;">Status</th>                                       
                                                <th style="width: 90px;">Actions</th>                                               
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                </div>

                                <div class="tab-pane" id="tab_actions_Reference">

                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>                                                                                          
                                                        <th >SOP No.</th> 
                                                        <th >Description</th>                                               
                                                        <th >Document</th>
                                                        <th >Verified by</th>
                                                        <th >Date Verified </th>                                                                                           
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                <tr>
                                                    <td class="text-left">123</td>
                                                    <td class="text-left">Sample description</td>
                                                    <td class="text-left">Sample document</td>
                                                    <td class="text-left">Cindy Complience</td>
                                                    <td class="text-left">2024-04-13 13:31:29</td>

                                                </tr>
                                                <tr>
                                                    <td class="text-left">456</td>
                                                    <td class="text-left">Sample1 description</td>
                                                    <td class="text-left">Sample1 document</td>
                                                    <td class="text-left">Jonh Doe</td>
                                                    <td class="text-left">2024-04-12 19:47:27</td>
                                                </tr>

                                                <tr>
                                                    <td class="text-left">789</td>
                                                    <td class="text-left">Sample2 description</td>
                                                    <td class="text-left">Sample2 document</td>
                                                    <td class="text-left">James Miller</td>
                                                    <td class="text-left">2023-05-03 16:53:34</td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                <div class="tab-pane" id="tab_actions_Raw">

                                            <table class="table table-bordered table-hover" id="tableData_2">
                                                <thead>
                                                    <tr>
                                                                                                                                   
                                                        <th rowspan="2">Raw Materials Name</th>                                    
                                                        <th rowspan="2">Lot No.</th>
                                                        <th rowspan="2">Supplier Name</th>
                                                        <th rowspan="2">Supplier Code</th>
                                                        <th rowspan="2">Expiration Date</th>
                                                        <th rowspan="2">Qty Staged</th>
                                                        <th rowspan="2">Performed by</th>
                                                        <th rowspan="2">Date Performed</th>
                                                        <th rowspan="2">Verified by</th>                                                         
                                                        <th rowspan="2">Date Verified </th> 
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                <tr>
                                                    <td class="text-left">Corn</td>
                                                    <td class="text-left">156</td>
                                                    <td class="text-left">Henry Sy</td>
                                                    <td class="text-left">829</td>
                                                    <td class="text-left">2025-05-03</td>
                                                    <td class="text-left">4</td>
                                                    <td class="text-left">John Doe</td>
                                                    <td class="text-left">2023-02-01 19:12:28</td>
                                                    <td class="text-left">Cindy Complience</td>
                                                    <td class="text-left">2023-05-03 16:53:34</td>                                                                                                                                                         
                                                </tr>

                                                <tr>
                                                    <td class="text-left">Minerals</td>
                                                    <td class="text-left">1589</td>
                                                    <td class="text-left">Juan Dele Cruz</td>
                                                    <td class="text-left">55829</td>
                                                    <td class="text-left">2024-05-03</td>
                                                    <td class="text-left">6</td>
                                                    <td class="text-left">John Doe</td>
                                                    <td class="text-left">2024-05-03 16:53:34</td>
                                                    <td class="text-left">Cindy Complience</td>
                                                    <td class="text-left">2023-05-03 18:43:30</td>                                                                                                                                                         
                                                </tr>

                                                <tr>
                                                    <td class="text-left">Coal</td>
                                                    <td class="text-left">8541</td>
                                                    <td class="text-left">James Tan</td>
                                                    <td class="text-left">55829</td>
                                                    <td class="text-left">2022-04-09</td>
                                                    <td class="text-left">8</td>
                                                    <td class="text-left">John Doe</td>
                                                    <td class="text-left">2022-07-06 17:23:15</td>
                                                    <td class="text-left">Cindy Complience</td>
                                                    <td class="text-left">2023-08-03 11:21:10</td>                                                                                                                                                         
                                                </tr>

                                                   

                                                </tbody>
                                                </table>
                                 </div>


                                 <div class="tab-pane" id="tab_actions_materials">
                                 <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>

                                                <th >Packaging Materials Name</th>
                                                <th >Description</th>
                                                <th >Lot No.</th>
                                                <th >Supplier Name</th>
                                                <th >Supplier Code</th>
                                                <th >Qty Staged</th>
                                                <th >Performed by</th>
                                                <th >Date Performed</th>
                                                <th >Verified by</th>
                                                <th >Date Verified</th>                                                                                                                                                                                                                      
                                            </tr>

                                            </thead>
                                            <tbody>

                                            <tr>
                                                <td class="text-left">Glass</td>
                                                <td class="text-left">Sample Description</td>                                            
                                                <td class="text-left">55829</td>
                                                <td class="text-left">Andy Lee</td>
                                                <td class="text-left">1564</td>
                                                <td class="text-left">8</td>
                                                <td class="text-left">John Doe</td>
                                                <td class="text-left">2022-07-06 17:23:15</td>
                                                <td class="text-left">Cindy Complience</td>
                                                <td class="text-left">2023-08-03 11:21:10</td>                                                                                                                                                         
                                            </tr> 
                                            
                                            

                                            <tr>
                                                <td class="text-left">Plastic</td>
                                                <td class="text-left">Sample1 Description</td>                                              
                                                <td class="text-left">2225</td>
                                                <td class="text-left">James Tan</td>
                                                <td class="text-left">9457</td>
                                                <td class="text-left">3</td>
                                                <td class="text-left">John Doe</td>
                                                <td class="text-left">2022-07-06 17:23:15</td>
                                                <td class="text-left">Cindy Complience</td>
                                                <td class="text-left">2023-08-03 11:21:10</td>                                                                                                                                                         
                                            </tr> 


                                            <tr>
                                                <td class="text-left">Aluminum</td>
                                                <td class="text-left">Sample2 Description</td>
                                                <td class="text-left">56411</td>
                                                <td class="text-left">Thom Dri</td>
                                                <td class="text-left">6228</td>
                                                <td class="text-left">2</td>
                                                <td class="text-left">John Doe</td>
                                                <td class="text-left">2022-07-06 17:23:15</td>
                                                <td class="text-left">Cindy Complience</td>
                                                <td class="text-left">2023-08-03 11:21:10</td>                                                                                                                                                         
                                            </tr> 


                                            </tbody>
                                        </table>
                                 </div>


                                 <div class="tab-pane" id="tab_actions_Labels">
                                 <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>                                          
                                                <th >Labels Name</th>
                                                <th >Description</th>
                                                <th >Lot No.</th>
                                                <th >Supplier Name</th>
                                                <th >Supplier Code</th>
                                                <th >Qty Staged</th>
                                                <th >Performed by</th>
                                                <th >Date Performed</th>
                                                <th >Verified by</th>
                                                <th >Date Verified</th>                                                                             

                                            </tr>

                                            </thead>
                                            <tbody>
                                
                                            <tr>
                                                <td class="text-left">Label Name1</td>
                                                <td class="text-left">Sample1 Description</td>
                                                <td class="text-left">456</td>
                                                <td class="text-left">Thom Dri</td>
                                                <td class="text-left">6228</td>
                                                <td class="text-left">4</td>
                                                <td class="text-left">John Doe</td>
                                                <td class="text-left">2022-07-06 17:23:15</td>
                                                <td class="text-left">Cindy Complience</td>
                                                <td class="text-left">2023-08-03 11:21:10</td>                                                                                                                                                         
                                            </tr> 


                                            <tr>
                                                <td class="text-left">Label Name1</td>
                                                <td class="text-left">Sample2 Description</td>
                                                <td class="text-left">145</td>
                                                <td class="text-left">James Tan</td>
                                                <td class="text-left">455</td>
                                                <td class="text-left">6</td>
                                                <td class="text-left">John Doe</td>
                                                <td class="text-left">2022-07-06 17:23:15</td>
                                                <td class="text-left">Cindy Complience</td>
                                                <td class="text-left">2023-08-03 11:21:10</td>                                                                                                                                                         
                                            </tr> 

                                            <tr>
                                                <td class="text-left">Label Name1</td>
                                                <td class="text-left">Sample3 Description</td>
                                                <td class="text-left">893</td>
                                                <td class="text-left">Andy Lee</td>
                                                <td class="text-left">955</td>
                                                <td class="text-left">8</td>
                                                <td class="text-left">John Doe</td>
                                                <td class="text-left">2022-07-06 17:23:15</td>
                                                <td class="text-left">Cindy Complience</td>
                                                <td class="text-left">2023-08-03 11:21:10</td>                                                                                                                                                         
                                            </tr> 
                                            </tbody>
                                        </table>
                                 </div>

                                 <div class="tab-pane" id="tab_actions_Processing_Equipment">
                                 <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>                                               
                                                <th >Equipment Name</th>
                                                <th >Description</th>
                                                <th >Equipment ID No.</th>
                                                <th >Calibration Date</th>
                                                <th >Calibration Required</th>
                                                <th >Performed by</th>
                                                <th >Date Performed</th>
                                               <th >Verified by</th>  
                                               <th >Date Verified</th>                                                                                                                       
                                            </tr>

                                            </thead>
                                            <tbody>

                                            <tr>
                                                <td class="text-left">EquipmentName1</td>
                                                <td class="text-left">Sample1 Description</td>
                                                <td class="text-left">456</td>
                                                <td class="text-left">2024-07-04</td>  
                                                <td class="text-left">Sample Calibration</td>                                               
                                                <td class="text-left">John Doe</td>
                                                <td class="text-left">2022-07-06 17:23:15</td>
                                                <td class="text-left">Cindy Complience</td>
                                                <td class="text-left">2022-08-03 11:21:10</td>                                                                                                                                                         
                                            </tr> 

                                            <tr>
                                                <td class="text-left">Equipment Name2</td>
                                                <td class="text-left">Sample2 Description</td>
                                                <td class="text-left">516</td>
                                                <td class="text-left">2023-04-08</td>  
                                                <td class="text-left">Sample Calibration</td>                                               
                                                <td class="text-left">John Doe</td>
                                                <td class="text-left">2022-07-06 17:23:15</td>
                                                <td class="text-left">Cindy Complience</td>
                                                <td class="text-left">2022-08-03 11:21:10</td>                                                                                                                                                         
                                            </tr> 

                                            <tr>
                                                <td class="text-left">Equipment Name3</td>
                                                <td class="text-left">Sample3 Description</td>
                                                <td class="text-left">698</td>
                                                <td class="text-left">2023-08-03</td>  
                                                <td class="text-left">Sample Calibration</td>                                               
                                                <td class="text-left">John Doe</td>
                                                <td class="text-left">2022-07-06 17:23:15</td>
                                                <td class="text-left">Cindy Complience</td>
                                                <td class="text-left">2022-08-03 11:21:10</td>                                                                                                                                                         
                                            </tr> 


                                            </tbody>
                                        </table>
                                 </div>


                                 <div class="tab-pane" id="tab_actions_Production_Procedures">
                                 <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>                                               
                                                <th >Processing Step</th>
                                                <th >Procedure Description</th>
                                                <th >SOP Reference</th>
                                                <th >Performed by</th>
                                                <th >Date Performed</th>
                                                <th >Verified by</th>
                                                <th >Date Verified</th>                                                                                                                                                          
                                            </tr>
                                            </thead>
                                            <tbody>
                                
                                            <tr>                                               
                                                <td class="text-left">Sample1 Processing Step</td>                                               
                                                <td class="text-left">Sample1 Procedure Description</td>  
                                                <td class="text-left">SOP Reference1</td>                                               
                                                <td class="text-left">John Doe</td>
                                                <td class="text-left">2024-07-06 17:23:15</td>
                                                <td class="text-left">Cindy Complience</td>
                                                <td class="text-left">2024-08-03 11:21:15</td>                                                                                                                                                         
                                            </tr> 

                                            <tr>                                               
                                                <td class="text-left">Sample2 Processing Step</td>                                               
                                                <td class="text-left">Sample2 Procedure Description</td>  
                                                <td class="text-left">SOP Reference1</td>                                               
                                                <td class="text-left">John Doe</td>
                                                <td class="text-left">2023-06-06 17:23:15</td>
                                                <td class="text-left">Cindy Complience</td>
                                                <td class="text-left">2023-06-03 11:21:11</td>                                                                                                                                                         
                                            </tr> 

                                            <tr>                                               
                                                <td class="text-left">Sample3 Processing Step</td>                                               
                                                <td class="text-left">Sample3 Procedure Description</td>  
                                                <td class="text-left">SOP Reference1</td>                                               
                                                <td class="text-left">John Doe</td>
                                                <td class="text-left">2022-05-06 17:23:15</td>
                                                <td class="text-left">Cindy Complience</td>
                                                <td class="text-left">2022-05-03 11:21:22</td>                                                                                                                                                         
                                            </tr> 


                                            </tbody>
                                        </table>
                                 </div>


                                 <div class="tab-pane" id="tab_actions_Deviation_Record">
                                 <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>                                               
                                                <th >Equipment Name</th>
                                                <th >Description</th>
                                                <th >Equipment ID No.</th>
                                                <th >Calibration Date</th>
                                                <th >Calibration Required</th>
                                                <th >Performed By/date/time</th>
                                                <th >Verified by/date/time</th>                                                                                                                         
                                            </tr>

                                            </thead>
                                            <tbody>
                                

                                            </tbody>
                                        </table>
                                 </div>


                            </div>
                        </div>
                            <!-- END BORDERED TABLE PORTLET-->
                    </div>
                </div>


                        <!-- MODAL AREA ADD NEW-->


                        <div class="modal fade" id="modalNew" tabindex="-1" role="product" aria-hidden="true">
               
                            
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content">

                                    <form method="post" enctype="multipart/form-data" class="modalForm modalSave modalProduct">

                                        <div class="modal-header tabbable-line bg-info">
                                       
                                        <button type="button" class="close info" data-dismiss="modal" aria-hidden="true"></button>

                                            <h4 class="modal-title"><strong>Add New Batch</strong></h4>
                                            
                                        </div>
                                        <div class="modal-body">
                                            <div class="tabbable tabbable-tabdrop">
                                                <input class="form-control" type="hidden" name="ID" value="<?php echo $switch_user_id; ?>" />
                                                <ul class="nav nav-tabs">


                                                    <li class="active">
                                                        <a href="#tabProduct" data-toggle="tab">Product Details</a>
                                                    </li>

                                                    <li>
                                                        <a href="#tabProductDescription" data-toggle="tab">Production Batch Record Issuance</a>
                                                    </li>

                                                    <li class="hide">
                                                        <a href="#tabAllergens" data-toggle="tab">Materials</a>
                                                    </li>
                                                    <li class="hide">
                                                        <a href="#tabDimensions" data-toggle="tab">Equipment</a>
                                                    </li>

                                                    <li class="hide">
                                                        <a href="#tabStorage" data-toggle="tab">Ingredients</a>
                                                    </li>
                                                    <li class="hide">
                                                        <a href="#tabManufacturing" data-toggle="tab">Records</a>
                                                    </li>

                                                    <li class="hide">
                                                        <a href="#tabExercises" data-toggle="tab">Production Yield</a>
                                                    </li>

                                                    <li class="hide">
                                                        <a href="#tabDocuments" data-toggle="tab">Representative</a>
                                                    </li>

                                                    <li class="hide">
                                                        <a href="#tabLabs" data-toggle="tab">Deviations and Approvals</a>
                                                    </li>

                                                    <li class="hide">
                                                        <a href="#tabLabel" data-toggle="tab">Label</a>
                                                    </li>

                                                    <li class="hide">
                                                        <a href="#tabFormulation" data-toggle="tab">Formulation</a>
                                                    </li>

                                                    <li class="hide">
                                                        <a href="#modalService" data-toggle="modal">FFVA</a>
                                                    </li>
                                                </ul>



                                                <div class="tab-content margin-top-20">
                                                    <div class="tab-pane active" id="tabProduct">
                                                                                                              
                                                        <div class="row margin-bottom-10">
                        
                                                        </div>                                                                                                       
                                                     
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Batch Record No.</label>
                                                                    <input class="form-control" type="text" name="b_record_no" placeholder="Enter Batch Record No." required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">

                                                            
                                                                <div class="form-group">

                                                                    <label class="control-label">Product Name</label>
                                                                    <!-- <input class="form-control" type="text" name="name" placeholder="Enter product name" required /> -->
                                                                    <select class="form-control" name="product_name">
                                                                        <option value="0" selected disabled>--Select Product--</option>

                                                                        <?php
                                                                            $selectConditions = mysqli_query( $conn,"SELECT * FROM tbl_products WHERE deleted = 0 ORDER BY name" );
                                                                            if ( mysqli_num_rows($selectConditions) > 0 ) {
                                                                                while($rowConditions = mysqli_fetch_array($selectConditions)) {
                                                                                    $conditions_ID = $rowConditions["ID"];
                                                                                    $conditions_name = $rowConditions["name"];

                                                                                    echo '<option value="'.$conditions_ID.'">'.$conditions_name.'</option>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                                                                                                                                          
                                                               </div>
                                                            </div>
                                                            

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Product Code</label>
                                                                    <input class="form-control" type="text" name="product_code" placeholder="Enter Product Code" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Formula Code</label>
                                                                    <input class="form-control" type="text" name="formula_code" placeholder="Enter Formula Code" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Product Label</label>
                                                                    <input class="form-control" type="text" name="product_label" placeholder="Enter Product Label" required />
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">MFG Date</label>
                                                                    <input class="form-control" type="date" name="mfg_date" required />
                                                                </div>
                                                             </div>
                                                            

                                                             <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Expiry Date</label>
                                                                    <input class="form-control" type="date" name="expiry_date" required />
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Description</label>
                                                                    <textarea class="form-control" name="description" required placeholder="Enter Description"></textarea>
                                                            </div>
                                                         </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Batch Qty</label>
                                                                    <textarea class="form-control" name="batch_qty" required placeholder="Enter Batch Qty"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- <h4><strong>Packaging</strong></h4> -->
                                                        <div class="row">

                                                            <div class="col-md-6">

                                                                <div class="form-group">
                                                                    <label class="control-label">Packaging</label>
                                                                    <input class="form-control" type="text" name="packaging" placeholder="Enter packaging" />
                                                                </div>                                                                                                 
                                                            </div>

                                                            <div class="col-md-6"> 
                                                                <div class="form-group">
                                                                    <label class="control-label">Storage Conditions</label>
                                                                    <select class="form-control" name="storage_conditions">
                                                                        <option value="0" selected disabled>--Select Storage onditions--</option>
                                                                        <?php
                                                                            $selectConditions = mysqli_query( $conn,"SELECT * FROM tbl_storage_conditions WHERE deleted = 0 ORDER BY name" );
                                                                            if ( mysqli_num_rows($selectConditions) > 0 ) {
                                                                                while($rowConditions = mysqli_fetch_array($selectConditions)) {
                                                                                    $conditions_ID = $rowConditions["ID"];
                                                                                    $conditions_name = $rowConditions["name"];

                                                                                    echo '<option value="'.$conditions_ID.'">'.$conditions_name.'</option>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>

                                                                </div>                                       
                                                            </div>


                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                     <label class="control-label">Prepared by</label>
                                                                     <input class="form-control" type="text" name="prepared_by" placeholder="Prepared by" />
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Date Prepared</label>                                                                   
                                                                    <input class="form-control" type="date" name="date_prepared" required />
                                                                </div>  
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Approved by</label>
                                                                    <input class="form-control" type="text" name="approved_by" placeholder="Approved by" />
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Date Approved </label>
                                                                    <input class="form-control" type="date" name="date_approved" required />
                                                                </div>
                                                            </div>  



                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Stutus</label>
                                                                    <input class="form-control" type="text" name="status" placeholder="Approved by" />
                                                                </div>
                                                            </div>

                                                        </div>      
                                                                                                                                                    
                                                    </div>



                                                <div class="tab-pane " id="tabProductDescription">

                                                    <div class="row margin-bottom-10"></div>
                                                        <!-- <h4><strong>Production Batch Record Issuance</strong></h4> -->

                                                        <div class="row">
                                                            
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label class="control-label">Issued by</label>
                                                                    <div class="chars-container">
                                                                        <div class="chars-template margin-bottom-10" style="display:flex; align-items:center; gap:1rem;">
                                                                            <input type="text" name="physical_chars[]" class="form-control" style="flex-grow:1;" placeholder="Issued by" />
                                                                                                                                                    
                                                                        </div>
                                                                    </div>                                                                                                                                    
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Date Issued</label>
                                                                    <input class="form-control" type="date" name="mock_recall" value="'. $row['mock_recall'] .'" />
                                                            </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label class="control-label">Accepted by</label>

                                                                    <div class="chars-container">
                                                                        <div class="chars-template margin-bottom-10" style="display:flex; align-items:center; gap:1rem;">
                                                                            <input type="text" name="microbial_char[]" class="form-control" style="flex-grow:1;" placeholder="Accepted by" />                                                                           
                                                                        </div>
                                                                    </div>                                                                  
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Date Accepted</label>
                                                                    <input class="form-control" type="date" name="mock_recall" value="'. $row['mock_recall'] .'" />
                                                            </div>
                                                            </div>


                                                        </div>

                                                    </div>


   
                                                    <div class="tab-pane" id="tabDocuments">
    
  
                                                    </div>
                        
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Products" id="btnSave_Products" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade bs-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate">

                                        <div class="modal-header bg-info">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title"><strong>Product Details</strong></h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Products" id="btnUpdate_Products" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalNewLab" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalNewLab">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Lab</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Lab" id="btnSave_Lab" data-style="zoom-out"><span class="ladda-label">Add Lab</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalEditLab" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalEditLab">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Lab Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Lab" id="btnUpdate_Lab" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- / END MODAL AREA -->
                        
                        
                        
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
                        
                        <div class="modal fade" id="view_video" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Demo Video</h4>
                                        </div>

                                        <div class="modal-body">
                                            <!--<video id="myVideo" width="320" height="240" controls style="width:100%;height:100%">-->
                                            <!--  <source src="" >-->
                                            <!--    Your browser does not support the video tag.-->
                                            <!--</video>-->
                                            <!--<iframe id="myVideo" class="embed-responsive-item" width="320" height="240" src="" allowfullscreen></iframe>-->
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe id="myVideo" class="embed-responsive-item" width="560" height="315" src="" allowfullscreen></iframe>
                                             </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
        
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script type="text/javascript">



            var productDT;
            $(document).ready(function(){
                fancyBoxes();
                widget_formRepeater();
                productDT = $('#productsTable').DataTable({
                    language: {
                        aria: {
                            sortAscending: ": activate to sort column ascending",
                            sortDescending: ": activate to sort column descending",
                        },
                        emptyTable: "No data available",
                        info: "Showing _START_ to _END_ of _TOTAL_ records",
                        infoEmpty: "No records found",
                        infoFiltered: "(filtered from _MAX_ total records)",
                        lengthMenu: "Show _MENU_",
                        search: "Search:",
                        zeroRecords: "No matching records found",
                        paginate: {
                            previous: "Prev",
                            next: "Next",
                            last: "Last",
                            first: "First",
                        },
                    },
                    bStateSave: false,
                    lengthMenu: [
                        [15, 20, 50, -1],
                        [15, 20, 50, "All"],
                    ],
                    pageLength: 15,
                    pagingType: "bootstrap_full_number",
                    columnDefs: [
                        {
                            orderable: false,
                            targets: [-1],
                        },
                        {
                            searchable: false,
                            targets: [-1],
                        },
                        {
                            className: "dt-right",
                        },
                        {
                            className: "text-center",
                            targets: [1]
                        }
                    ],
                });
                
                fetchBatch();
            });
            function widget_formRepeater() {
                var FormRepeater=function(){
                    return{
                        init:function(){
                            $(".mt-repeater").each(function(){
                                $(this).repeater({
                                    show:function(){
                                        $(this).slideDown();
                                    },
                                    hide:function(e){
                                        let text = "Are you sure you want to delete this row?";
                                        if (confirm(text) == true) {
                                            $(this).slideUp(e);
                                            setTimeout(function() { 
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
            function btnReset(view) {
                $('#'+view+' form')[0].reset();
                $('#'+view+' form table tbody').html('');
                $('#'+view+' form #image_preview').html('');
            }
            
            function uploadNew(e) {
                $(e).parent().hide();
                $(e).parent().prev('.form-control').removeClass('hide');
            }

            function inputInvalid(modal) {
                var error = 0;
                $('.'+modal+' .form-group > *:invalid').each(function () {
                    // Find the tab-pane that this element is inside, and get the id
                    var $closest = $(this).closest('.tab-pane');
                    var id = $closest.attr('id');

                    $(this).addClass('error');

                    // Find the link that corresponds to the pane and have it show
                    $('.'+modal+' .nav a[href="#' + id + '"]').tab('show');

                    // Only want to do it once
                    error++;
                });

                return error;
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
                        url: "function_production.php?btnDelete_Products="+id,
                        dataType: "html",
                        success: function(response){
                            // $('#mt_action_'+id).remove();
                            fetchBatch();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }

            function btnView(id) {
                $.ajax({
                    type: "GET",
                    url: "function_production.php?modalView_Products="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                        $(".modalForm").validate();
                        widget_formRepeater();
                        $('[data-role="tagsinput2"').tagsinput();
                        vendorDropdownChange();
                    }
                });
            }

            $(".modalSave").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalSave') > 0) { return false; }

                var formData = new FormData(this);
                formData.append('btnSave_Products',true);

                var l = Ladda.create(document.querySelector('#btnSave_Products'));
                l.start();

                $.ajax({
                    url: "function_production.php",
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
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            fetchBatch();
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

                if (inputInvalid('modalUpdate') > 0) { return false; }

                var formData = new FormData(this);
                formData.append('btnUpdate_Products',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Products'));
                l.start();

                $.ajax({
                    url: "function_production.php",
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
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            fetchBatch();
                            $('#modalView').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnNew_Lab(modal) {
                $.ajax({    
                    type: "GET",
                    url: "function_production.php?modalNew_Lab="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalNewLab .modal-body").html(data);
                    }
                });
            }
            $(".modalNewLab").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalNewLab') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnSave_Lab',true);

                var l = Ladda.create(document.querySelector('#btnSave_Lab'));
                l.start();

                $.ajax({
                    url: "function_production.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            $('#tableLab_'+obj.modal+' tbody').append(obj.data);
                            $('#modalNewLab').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            var isFetching = false;
            function fetchBatch() {
                if(isFetching) {
                    console.log('Already fetching...');
                    return;
                }
                
                isFetching = true;
                
                $.ajax({    
                    type: "GET",
                    url: "?fetchBatch",
                    dataType: "json",                  
                    success: function(data){       
                        if(Array.isArray(data) && data.length) {
                            productDT.clear().draw();
                            data.forEach((d) => {
                                productDT.row.add([

                                    `<span style="font-weight: 200;">${d.ID}</span>`,                                
                                   ` <div style="display: flex; gap:1rem;">
                                            
                                            <div>
                                                <span style="font-weight: 600;">${d.name}</span>
                                                
                                            </div>    
                                        </div>`,
                                    
                                    // `<p class="text-muted" style="text-align:justify;">${d.description}</p>`,
                                    // `<span style="font-weight: 200;">${d.upc}</span>`,
                                    // `<span style="font-weight: 200;">${d.manufactured_by}</span>`,
                                    // `<span style="font-weight: 200;">${d.manufactured_for}</span>`,
                                    `<span style="font-weight: 200;">${d.code}</span>`,
                                    `<span style="font-weight: 200;">${d.upc}</span>`,
                                    `<div class="btn btn-circle" style="position: unset;">
                                        <a class="btn btn-outline btn-circle font-weight-bold btn-pill btn-md">Pending</a>                                           
                                     </div>`,                                   
                                    `<div class="btn btn-circle" style="position: unset;">
                                        <a href="#modalView" data-toggle="modal" data-id="${d.id}" class="btn btn-outline btn-circle btn-info font-weight-bold btn-pill btn-md btnView" onclick="btnView(${d.id})">View</a>                                        
                                     </div>`,

                                ]).draw();
                            });
                        }
                    },
                    complete: function() {
                        isFetching = false;
                    }
                });
            }
            
            function btnEdit_Lab(id, modal) {
                $.ajax({    
                    type: "GET",
                    url: "function_production.php?modalEdit_Lab="+id+"&modal="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalEditLab .modal-body").html(data);
                    }
                });
            }
            $(".modalEditLab").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalEditLab') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Lab',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Lab'));
                l.start();

                $.ajax({
                    url: "function_production.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            $('#tableLab_'+obj.modal+' tbody #tr_'+obj.ID).html(obj.data);
                            $('#modalEditLab').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnRemove_Lab(id, e) {
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
                        url: "function_production.php?btnDelete_Lab="+id,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            
            function evaluateManufacturingDetails(event) {
                const idValue = parseInt(event.target.value) || null;
                const container = $(event.target.closest('.modal'));
                
                if(idValue) {
                    container.find('[data-manufacturing-details]').addClass('hide');
                    container.find('[data-manufacturing-details=default]').removeClass('hide'); // show the default fields
                    
                    container.find('[data-manufacturing-details]').each(function(index, el) {
                        const cat = el.getAttribute('data-manufacturing-details');
                        
                        if(cat && cat !== 'default') {
                            const ids = JSON.parse(cat) || null;
                            if(ids && ids.includes(idValue)) {
                                container.find('[data-manufacturing-details=default]').addClass('hide');
                                container.find(el).removeClass('hide');
                            }
                        } 
                    });
                }
            }
            
            function addMoreChars(evt) {
                const formgroup = evt.closest('.form-group');
                const charsContainer = $(formgroup).find('.chars-container');
                const name = evt.getAttribute('data-name') || '';
                const placeholder = evt.getAttribute('data-placeholder') || '';
                const template = $.parseHTML(`
                    <div class="chars-template margin-bottom-10" style="align-items:center; gap:1rem; display:none;">
                        <input type="text" name="${name}" class="form-control" style="flex-grow:1;" placeholder="${placeholder}" />
                        <button type="button" class="btn btn-danger" onclick="deleteChar(this)"><i class="fa fa-close"></i></button>
                    </div>
                `);
                
                charsContainer.append(template);
                $(template).fadeIn();
                $(template).css('display', 'flex');
            }
            
            function deleteChar(evt) {
                const template = evt.closest('.chars-template');
                $(template).fadeOut('slow', function() {
                    template.remove();
                });
            }
            
            function vendorDropdownChange(el) {
                $('#supplierNameSelectEdit[name="vendor_name"]').multiselect({
                    widthSynchronizationMode: 'ifPopupIsSmaller',
                    buttonWidth: "100%",
                    enableFiltering: true,
                    disableIfEmpty: true,
                    enableCaseInsensitiveFiltering: true,
                    maxHeight: 250,
                    // buttonClass: "mt-multiselect btn btn-default", 
                    onChange: function (element, checked, select) {
                        const id = $('#supplierNameSelectEdit[name="vendor_name"]').val();
                        $(element).closest('.modal').find('select[name=vendor_code]').val(id);
                    },
                  });
               $('#supplierNameSelectEdit[name="vendor_name"]').multiselect('select', $('#supplierNameSelectEdit[name="vendor_name"]').closest('.modal').find('select[name=vendor_code]').val())
            }
            // selectMulti();
            $('#supplierNameSelect[name="vendor_name"]').multiselect({
                widthSynchronizationMode: 'ifPopupIsSmaller',
                buttonWidth: "100%",
                enableFiltering: true,
                disableIfEmpty: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 250,
                // buttonClass: "mt-multiselect btn btn-default", 
                onChange: function (element, checked, select) {
                    const id = $('#supplierNameSelect[name="vendor_name"]').val();
                    $(element).closest('.modal').find('select[name=vendor_code]').val(id);
                },
              });
        </script>

    </body>
</html>
