<?php 
    $title = "Products";
    $site = "products";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';
    
    $facility_switch_user_id2 = 0;
    if (isset($_COOKIE['facilityswitchAccount'])) {
        $facility_switch_user_id2 = $_COOKIE['facilityswitchAccount'];
    }
    
    if(isset($_GET['fetchProducts'])) {
        
        include_once __DIR__ .'/database_iiq.php';
        include_once __DIR__ . '/alt-setup/setup.php';
        
        error_reporting(E_ALL);
        $switch_user_id = $user_id;
        
        // $result = mysqli_query( $conn,"SELECT ID, image, name, category, category_other, description, last_modified FROM tbl_products WHERE deleted = 0 AND user_id = $user_id" );
        // $result = mysqli_query( $conn,"SELECT
        //     ID, image, name, category, category_other, description, last_modified,
        //     CASE WHEN LENGTH(specifcation) > 0 THEN 1 ELSE 0 END AS specifcation_result,
        //     CASE WHEN LENGTH(artwork) > 0 THEN 1 ELSE 0 END AS artwork_result,
        //     CASE WHEN LENGTH(haccp) > 0 THEN 1 ELSE 0 END AS haccp_result,
        //     CASE WHEN LENGTH(label) > 0 THEN 1 ELSE 0 END AS label_result,
        //     CASE WHEN LENGTH(formulation) > 0 THEN 1 ELSE 0 END AS formulation_result,
        //     docs
            
        //     FROM tbl_products WHERE deleted = 0 AND user_id = $user_id" );
        // $data = [];
        // if ( mysqli_num_rows($result) > 0 ) {
        //     while($row = mysqli_fetch_array($result)) {
        //         $data_image = $row['image'];
        //         $url_base = "";
        //         $image_main = "https://via.placeholder.com/40x40/EFEFEF/AAAAAA&text=No+Image";

        //         if (!empty($data_image)) {

        //             $data_image_array = explode(", ", $data_image);
        //             if (!empty($data_image_array[0])) {
        //                 $url_base = "//interlinkiq.com/uploads/products/";

        //                 $image_main = $data_image_array[0];
        //             }
        //         }

        //         $data_category_id = $row['category'];
        //         if ($data_category_id == 9) {
        //             $category = $row['category_other'];
        //         } else {
        //             $resultCategory = mysqli_query( $conn,"SELECT * FROM tbl_products_category WHERE ID = $data_category_id" );
        //             $rowCategory = mysqli_fetch_array($resultCategory);
        //             $category = htmlentities($rowCategory['name'] ?? '');
        //         }
                
        //         // $docs_count = 0;
        //         // $docs_file_count = 0;
        //         // if (!empty($row['docs'])) {
        //         //     $docs_arr= json_decode($row["docs"], true);
        //         //     $docs_count = count($docs_arr);
        //         //     if ($docs_count > 0) {
        //         //         foreach ($docs_arr as $key => $value) {
        //         //             if (!empty($value['docs_file'])) {
        //         //                 $docs_file_count++;
        //         //             }
        //         //         }
        //         //     }
        //         // }
                
        //         // $compliance_tot = $row['specifcation_result'] + $row['artwork_result'] + $row['haccp_result'] + $row['label_result'] + $row['formulation_result'];
        //         // $compliance_per = (100 / (5 + $docs_count) ) * ($compliance_tot + $docs_file_count);
        //         //     'compliance' => round($compliance_per, 2),
                
                
                
        //         $data[] = [
        //             'id' => $row['ID'],
        //             'image' => $url_base.$image_main,
        //             'description' => htmlentities($row["description"] ?? ''),
        //             'name' => htmlentities($row["name"] ?? ''),
        //             'category' => $category,
        //             'last_update' => $row["last_modified"]
        //         ];
        //     }
        // }
        
        $data = [];
        $sql_custom = '';
        
        if ($switch_user_id == 1211) {
            $sql_custom = ' UNION ALL

                SELECT 
                m.ID AS p_ID,
                1 AS p_source,
                "" AS p_image,
                m.material_name AS p_name,
                m.description AS p_description,
                c.name AS p_category,
                "" AS p_last_modified

                FROM tbl_supplier_material AS m

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_products_category
                ) AS c
                ON m.category = c.ID

                INNER JOIN (
                    SELECT
                    *
                    FROM tbl_supplier
                    WHERE is_deleted = 0
                ) AS s
                ON FIND_IN_SET(m.ID, REPLACE(s.material, " ", ""))

                WHERE m.user_id = '.$switch_user_id;
        }
        
        $result = mysqli_query( $conn,"
            SELECT
            *
            FROM (
                SELECT 
                p.ID AS p_ID,
                0 AS p_source,
                p.image AS p_image, 
                p.name AS p_name, 
                p.description AS p_description, 
                CASE WHEN c.name = 'Other' THEN p.category_other ELSE c.name END AS p_category,
                p.last_modified AS p_last_modified
                FROM tbl_products AS p

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_products_category
                ) AS c
                ON p.category = c.ID
                
                WHERE p.deleted = 0 
                AND p.user_id = $switch_user_id
                AND facility_switch = $facility_switch_user_id2

                $sql_custom
             ) r
            ORDER BY r.p_name
        " );
        
        if ( $result && mysqli_num_rows($result) > 0 ) {
            while($row = mysqli_fetch_array($result)) {
                $files = '';
                if (!empty($row['p_image'])) {
                    $data_image_array = explode(", ", $row['p_image']);
                    if (!empty($data_image_array[0])) {
                        $base_url = "//interlinkiq.com/uploads/products/";

                        $files = $base_url.$data_image_array[0];
                    }
                }
                
                
                $data[] = [
                    'id' => $row['p_ID'],
                    'source' => $row['p_source'],
                    'image' => $files,
                    'description' => htmlentities($row["p_description"] ?? ''),
                    'name' => htmlentities($row["p_name"] ?? ''),
                    'category' => htmlentities($row["p_category"] ?? ''),
                    'last_update' => $row["p_last_modified"]
                ];

                // echo '<div class="mt-action" id="mt_action_'.$row["p_ID"].'_'.$row["p_source"].'">
                //     <div class="mt-action-img"><img src="'.$files.'" onerror="this.onerror=null;this.src=\'https://via.placeholder.com/40x40/EFEFEF/AAAAAA.png?text=no+image\';" style="width: 40px; height: 40px; object-fit: cover; object-position: center;" /></div>
                //     <div class="mt-action-body">
                //         <div class="mt-action-row">
                //             <div class="mt-action-info ">
                //                 <div class="mt-action-details">
                //                     <span class="mt-action-author">'.htmlentities($row["p_name"] ?? '').'</span>
                //                     <p class="mt-action-desc">'.htmlentities($row["p_description"] ?? '').'</p>
                //                 </div>
                //             </div>
                //             <div class="mt-action-datetime" style="width: 150px;">
                //                 <span class="label label-sm label-success btn-circle">'. htmlentities($row["p_category"] ?? '') .'</span>
                //             </div>
                //             <div class="mt-action-datetime">
                //                 <span class="mt-action-date">'. $row["p_last_modified"] .'</span>
                //             </div>
                //             <div class="mt-action-buttons">
                //                 <div class="btn-group btn-group-circle">
                //                     <a href="#modalView" data-toggle="modal" data-id="'. $row["p_ID"] .'" class="btn btn-outline dark btn-sm btnView" onclick="btnView('.$row["p_ID"].', '.$row["p_source"].')">View</a>
                //                     <a href="javascript:;" class="btn btn-outlinex red btn-sm btnDelete" data-id="'. $row["p_ID"] .'" onclick="btnDelete('.$row["p_ID"].', '.$row["p_source"].')">Delete</a>
                //                 </div>
                //             </div>
                //         </div>
                //     </div>
                // </div>';
            }
        }
        
        exit(json_encode($data)) ;
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


    #productsChartdiv {
        width: 100%;
        height: 500px;
        /* background-color: #f0f0f0;  */
    }

    /*.ui-autocomplete-loading {
        background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
    }*/
    .ui-autocomplete {
        max-height: 250px !important;
        overflow: auto;
        z-index: 215000000 !important;
        list-style: none;
        background: #fff;
        padding: 0;
        width: fit-content !important;
    }
    .ui-autocomplete > li:hover {
        background: #f1f1f1;
    }

</style>


                    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
                    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
                    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
                    <script src="https://cdn.amcharts.com/lib/5/plugins/legend.js"></script>
                    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>


                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="icon-puzzle font-dark"></span>
                                        <span class="caption-subject font-dark bold uppercase">Products</span>
                                        <?php
                                            // if($current_client == 0) {
                                            //     // $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND (user_id = $switch_user_id OR user_id = $current_userEmployerID OR user_id = 163)");
                                            //     $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site'");
                                            //     while ($row = mysqli_fetch_assoc($result)) {
                                            //         $type_id = $row["type"];
                                            //         $file_title = $row["file_title"];
                                            //         $video_url = $row["youtube_link"];
                                                    
                                            //         $file_upload = $row["file_upload"];
                                            //         if (!empty($file_upload)) {
                                        	   //         $fileExtension = fileExtension($file_upload);
                                        				// $src = $fileExtension['src'];
                                        				// $embed = $fileExtension['embed'];
                                        				// $type = $fileExtension['type'];
                                        				// $file_extension = $fileExtension['file_extension'];
                                        	   //         $url = $base_url.'uploads/instruction/';
                                        
                                            //     		$file_url = $src.$url.rawurlencode($file_upload).$embed;
                                            //         }
                                                    
                                            //         $icon = $row["icon"];
                                            //         if (!empty($icon)) { 
                                            //             if ($type_id == 0) {
                                            //                 echo ' <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'"><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                            //             } else {
                                            //                 echo ' <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                            //             }
                                            //         }
	                                           // }
                                            // }
                                        ?>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#modalNew" onclick="btnReset('modalNew')" >Add New Products</a>
                                                </li>
                                                <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163): ?>
                                                    <li>
                                                        <a data-toggle="modal" data-target="#modalInstruction" onclick="btnInstruction()">Add New Instruction</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>

                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_products" data-toggle="tab">Products</a>
                                        </li>
                                        <li>
                                            <a href="#tab_products_analytics" data-toggle="tab">Analytics</a>
                                        </li>									
                                    </ul>


                                </div>
                                <div class="portlet-body">
                                    <!-- BEGIN: Actions -->
                                    <div class="mt-actions hide">
                                        <?php
                                            // $result = mysqli_query( $conn,"SELECT * FROM tbl_products WHERE deleted = 0 AND user_id = $switch_user_id" );
                                            // if ( mysqli_num_rows($result) > 0 ) {
                                            //     while($row = mysqli_fetch_array($result)) {
                                            //         $data_image = $row['image'];
                                            //         $url_base = "";
                                            //         $image_main = "https://via.placeholder.com/40x40/EFEFEF/AAAAAA&text=No+Image";

                                            //         if (!empty($data_image)) {

                                            //             $data_image_array = explode(", ", $data_image);
                                            //             if (!empty($data_image_array[0])) {
                                            //                 $url_base = "//interlinkiq.com/uploads/products/";

                                            //                 $image_main = $data_image_array[0];
                                            //             }
                                            //         }

                                            //         $data_category_id = $row['category'];
                                            //         if ($data_category_id == 9) {
                                            //             $category = $row['category_other'];
                                            //         } else {
                                            //             $resultCategory = mysqli_query( $conn,"SELECT * FROM tbl_products_category WHERE ID = $data_category_id" );
                                            //             $rowCategory = mysqli_fetch_array($resultCategory);
                                            //             $category = $rowCategory['name'];
                                            //         }

                                            //         echo '<div class="mt-action" id="mt_action_'. $row["ID"] .'">
                                            //             <div class="mt-action-img"><img src="'. $url_base.$image_main .'" style="width: 40px; height: 40px; object-fit: cover; object-position: center;" /></div>
                                            //             <div class="mt-action-body">
                                            //                 <div class="mt-action-row">
                                            //                     <div class="mt-action-info ">
                                            //                         <div class="mt-action-details ">
                                            //                             <span class="mt-action-author">'. htmlentities($row["name"]) .'</span>
                                            //                             <p class="mt-action-desc">'. htmlentities($row["description"]) .'</p>
                                            //                         </div>
                                            //                     </div>
                                            //                     <div class="mt-action-datetime" style="width: 150px;">
                                            //                         <span class="label label-sm label-success btn-circle">'. $category .'</span>
                                            //                     </div>
                                            //                     <div class="mt-action-datetime ">
                                            //                         <span class="mt-action-date">'. $row["last_modified"] .'</span>
                                            //                     </div>
                                            //                     <div class="mt-action-buttons ">
                                            //                         <div class="btn-group btn-group-circle">
                                            //                             <a href="#modalView" data-toggle="modal" data-id="'. $row["ID"] .'" class="btn btn-outline dark btn-sm btnView" onclick="btnView('. $row["ID"] .')">View</a>
                                            //                             <a href="javascript:;" class="btn btn-outlinex red btn-sm btnDelete" data-id="'. $row["ID"] .'" onclick="btnDelete('. $row["ID"] .')">Delete</a>
                                            //                         </div>
                                            //                     </div>
                                            //                 </div>
                                            //             </div>
                                            //         </div>';
                                            //     }
                                            // }
                                        ?>
                                    </div>
                                    <!-- END: Actions -->

                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_products">
                                            <table class="table table-bordered table-hover" id="productsTable">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th style="width: 150px;">Category</th>
                                                        <th class="text-center" style="width: 135px;">Last Update</th>
                                                        <th class="text-center" style="width: 90px;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>

                                        <!-- Nelmar Products Analytics -->                                   									
                                        <div class="tab-pane" id="tab_products_analytics">                       
										    <div class="row widget-row">                       
                                                <div class="col-md-12">                                     
												    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">   
													    <h3 class="d-flex justify-content-center">Products</h3>   
														    <div class="widget-thumb-wrap">                                       
																<div id="productsChartdiv" style="width: 100%; height: 500px;">																		
															</div>                                        
														</div>
													</div>     
												</div> 
											</div>
										</div>																							
									</div>
                                </div>                 
                            </div>  <!-- END BORDERED TABLE PORTLET-->
                        </div>


                        <!-- MODAL AREA-->
                        <div class="modal fade" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalSave modalProduct">
                                        <div class="modal-header tabbable-line">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Product Form</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="tabbable tabbable-tabdrop">
                                                <input class="form-control" type="hidden" name="ID" value="<?php echo $switch_user_id; ?>" />
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#tabVendor" data-toggle="tab">Vendor Details</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabBasic" data-toggle="tab">Product Overview</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabCharacteristics" data-toggle="tab">Product Characteristics</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabPackaging" data-toggle="tab">Packaging</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabDocs" data-toggle="tab">Documents</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabManufactured" data-toggle="tab">Manufacturer</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content margin-top-20">
                                                    <div class="tab-pane active" id="tabVendor">
                                                        <input class="form-control" type="hidden" name="vendor_s_ID" id="vendor_s_ID" />
                                                        <input class="form-control" type="hidden" name="vendor_c_ID" id="vendor_c_ID" />
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Vendor ID</label>
                                                                    <input class="form-control" type="text" name="vendor_id" id="vendor_id" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Vendor Name</label>
                                                                    <input class="form-control" type="text" name="vendor_name" id="vendor_name" autocomplete="off" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Vendor/Item Code</label>
                                                                    <input class="form-control" type="text" name="vendor_code" id="vendor_code" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <label class="control-label">Address</label>
                                                                    <input class="form-control" type="text" name="vendor_address" id="vendor_address" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Contact Name</label>
                                                                    <input class="form-control" type="text" name="vendor_contact_name"  id="vendor_contact_name" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Phone</label>
                                                                    <input class="form-control" type="text" name="vendor_phone" id="vendor_phone" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Fax</label>
                                                                    <input class="form-control" type="text" name="vendor_fax" id="vendor_fax" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Email Address</label>
                                                                    <input class="form-control" type="text" name="vendor_email" id="vendor_email" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <h4><strong>Company Background</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <div class="form-group">
                                                                    <label class="control-label">Company Primary Business Description</label>
                                                                    <input class="form-control" type="text" name="vendor_business" id="vendor_business" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label class="control-label">Company Size</label>
                                                                    <input class="form-control" type="text" name="vendor_size" id="vendor_size" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <div class="form-group">
                                                                    <label class="control-label">Locations</label>
                                                                    <input class="form-control" type="text" name="vendor_location" id="vendor_location" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label class="control-label">Geographic Distribution Points</label>
                                                                    <input class="form-control" type="text" name="vendor_geographic" id="vendor_geographic" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label">Retail Accounts Listing</label>
                                                                    <input class="form-control" type="text" name="vendor_retail" id="vendor_retail" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <div class="form-group">
                                                                    <label class="control-label">Corporate Diversity Program Statement</label>
                                                                    <input class="form-control" type="text" name="vendor_diversity" id="vendor_diversity" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label class="control-label">Corporate Responsibility Program Statement</label>
                                                                    <input class="form-control" type="text" name="vendor_responsibility" id="vendor_responsibility" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabBasic">
                                                        <div class="row margin-bottom-20">
                                                            <div class="col-md-6 productMain">
                                                                <p><strong>Main Product View</strong></p>
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail">
                                                                        <img src="//placehold.co/400x250/EFEFEF/AAAAAA?text=no+image" class="img-responsive" alt="Avatar" />
                                                                    </div>
                                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                    <div>
                                                                        <span class="btn default btn-file btn-xs">
                                                                            <span class="fileinput-new"> Select image </span>
                                                                            <span class="fileinput-exists"> Change </span>
                                                                            <input class="form-control" type="file" name="image_main" accept="image/png,image/PNG,image/jpg,image/jpeg" />
                                                                        </span>
                                                                        <a href="javascript:;" class="btn default fileinput-exists btn-xs" data-dismiss="fileinput"> Remove </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 productAngle">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <p><strong>Top View</strong></p>
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-new thumbnail">
                                                                                <img src="//placehold.co/120x90/EFEFEF/AAAAAA?text=no+image" class="img-responsive" alt="Avatar" />
                                                                            </div>
                                                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                            <div>
                                                                                <span class="btn default btn-file btn-xs">
                                                                                    <span class="fileinput-new"> Select image </span>
                                                                                    <span class="fileinput-exists"> Change </span>
                                                                                    <input class="form-control" type="file" name="image_top" accept="image/png,image/PNG,image/jpg,image/jpeg" />
                                                                                </span>
                                                                                <a href="javascript:;" class="btn default fileinput-exists btn-xs" data-dismiss="fileinput"> Remove </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <p><strong>Front View</strong></p>
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-new thumbnail">
                                                                                <img src="//placehold.co/120x90/EFEFEF/AAAAAA?text=no+image" class="img-responsive" alt="Avatar" />
                                                                            </div>
                                                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                            <div>
                                                                                <span class="btn default btn-file btn-xs">
                                                                                    <span class="fileinput-new"> Select image </span>
                                                                                    <span class="fileinput-exists"> Change </span>
                                                                                    <input class="form-control" type="file" name="image_front" accept="image/png,image/PNG,image/jpg,image/jpeg" />
                                                                                </span>
                                                                                <a href="javascript:;" class="btn default fileinput-exists btn-xs" data-dismiss="fileinput"> Remove </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <p><strong>Left View</strong></p>
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-new thumbnail">
                                                                                <img src="//placehold.co/120x90/EFEFEF/AAAAAA?text=no+image" class="img-responsive" alt="Avatar" />
                                                                            </div>
                                                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                            <div>
                                                                                <span class="btn default btn-file btn-xs">
                                                                                    <span class="fileinput-new"> Select image </span>
                                                                                    <span class="fileinput-exists"> Change </span>
                                                                                    <input class="form-control" type="file" name="image_left" accept="image/png,image/PNG,image/jpg,image/jpeg" />
                                                                                </span>
                                                                                <a href="javascript:;" class="btn default fileinput-exists btn-xs" data-dismiss="fileinput"> Remove </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row margin-top-20">
                                                                    <div class="col-sm-4">
                                                                        <p><strong>Bottom View</strong></p>
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-new thumbnail">
                                                                                <img src="//placehold.co/120x90/EFEFEF/AAAAAA?text=no+image" class="img-responsive" alt="Avatar" />
                                                                            </div>
                                                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                            <div>
                                                                                <span class="btn default btn-file btn-xs">
                                                                                    <span class="fileinput-new"> Select image </span>
                                                                                    <span class="fileinput-exists"> Change </span>
                                                                                    <input class="form-control" type="file" name="image_bottom" accept="image/png,image/PNG,image/jpg,image/jpeg" />
                                                                                </span>
                                                                                <a href="javascript:;" class="btn default fileinput-exists btn-xs" data-dismiss="fileinput"> Remove </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <p><strong>Back View</strong></p>
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-new thumbnail">
                                                                                <img src="//placehold.co/120x90/EFEFEF/AAAAAA?text=no+image" class="img-responsive" alt="Avatar" />
                                                                            </div>
                                                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                            <div>
                                                                                <span class="btn default btn-file btn-xs">
                                                                                    <span class="fileinput-new"> Select image </span>
                                                                                    <span class="fileinput-exists"> Change </span>
                                                                                    <input class="form-control" type="file" name="image_back" accept="image/png,image/PNG,image/jpg,image/jpeg" />
                                                                                </span>
                                                                                <a href="javascript:;" class="btn default fileinput-exists btn-xs" data-dismiss="fileinput"> Remove </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <p><strong>Right View</strong></p>
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-new thumbnail">
                                                                                <img src="//placehold.co/120x90/EFEFEF/AAAAAA?text=no+image" class="img-responsive" alt="Avatar" />
                                                                            </div>
                                                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                            <div>
                                                                                <span class="btn default btn-file btn-xs">
                                                                                    <span class="fileinput-new"> Select image </span>
                                                                                    <span class="fileinput-exists"> Change </span>
                                                                                    <input class="form-control" type="file" name="image_right" accept="image/png,image/PNG,image/jpg,image/jpeg" />
                                                                                </span>
                                                                                <a href="javascript:;" class="btn default fileinput-exists btn-xs" data-dismiss="fileinput"> Remove </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label class="control-label">Product Name</label>
                                                                    <input class="form-control" type="text" name="name" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Category Group Description</label>
                                                                    <select class="form-control" name="category_group">
                                                                        <option value="0">Select</option>

                                                                        <?php
                                                                            $selectCategory = mysqli_query( $conn,"
                                                                                SELECT 
                                                                                g.id AS group_id,
                                                                                g.name AS group_name,
                                                                                d.id AS desciption_id,
                                                                                d.name AS desciption_name
                                                                                FROM tbl_products_category_group AS g

                                                                                LEFT JOIN (
                                                                                    SELECT
                                                                                    *
                                                                                    FROM tbl_products_category_group_description
                                                                                    WHERE deleted = 0
                                                                                ) AS d
                                                                                ON g.ID = d.category_id

                                                                                WHERE g.deleted = 0
                                                                            " );
                                                                            if ( mysqli_num_rows($selectCategory) > 0 ) {
                                                                                $category_group = array();
                                                                                $category_group_prev = 0;
                                                                                while($rowCategory = mysqli_fetch_array($selectCategory)) {

                                                                                    if (!in_array($rowCategory['group_id'], $category_group)) {
                                                                                        array_push($category_group, $rowCategory['group_id']);

                                                                                        if ($category_group_prev > 0 AND $category_group_prev != $rowCategory['group_id']) {
                                                                                            echo '</optgroup>';
                                                                                        }
                                                                                        $category_group_prev = $rowCategory['group_id'];

                                                                                        echo '<optgroup label="'.$rowCategory['group_name'].'">';
                                                                                    }

                                                                                    echo '<option value="'.$rowCategory['desciption_id'].'">'.$rowCategory['desciption_name'].'</option>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Product / Item Code</label>
                                                                            <input class="form-control" type="text" name="code" required />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Lead Time</label>
                                                                            <div class="input-group">
                                                                                <input class="form-control" type="number" name="leads" min="0" />
                                                                                <div class="input-group-addon" style="padding: 0;">
                                                                                    <select name="lead_type" style="border: 0; background: transparent;">
                                                                                        <option value="0">Day</option>
                                                                                        <option value="1">Week</option>
                                                                                        <option value="2">Month</option>
                                                                                        <option value="3">Year</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Private Label</label>
                                                                            <select class="form-control" name="private_label">
                                                                                <option value="0">No</option>
                                                                                <option value="1">Yes</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Cost</label>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon">$</span>
                                                                                <input class="form-control" type="number" name="cost" min="0" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Incoterms</label>
                                                                            <select class="form-control" name="incoterms">
                                                                                <option value="0">Select</option>

                                                                                <?php
                                                                                    $selectIncoterms = mysqli_query( $conn,"SELECT * from tbl_products_incoterms WHERE deleted = 0" );
                                                                                    if ( mysqli_num_rows($selectIncoterms) > 0 ) {
                                                                                        while($rowIncoterms = mysqli_fetch_array($selectIncoterms)) {
                                                                                            echo '<option value="'.$rowIncoterms['ID'].'">'.$rowIncoterms['name'].'</option>';
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">MOQ</label>
                                                                            <input class="form-control" type="number" name="moq" min="0" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Imports</label>
                                                                            <select class="form-control" name="imports">
                                                                                <option value="0">No</option>
                                                                                <option value="1">Yes</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label>Brand Logo</label>
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-new thumbnail">
                                                                                <img src="//placehold.co/120x90/EFEFEF/AAAAAA?text=no+image" class="img-responsive" alt="Avatar" />
                                                                            </div>
                                                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                            <div>
                                                                                <span class="btn default btn-file btn-xs">
                                                                                    <span class="fileinput-new"> Select image </span>
                                                                                    <span class="fileinput-exists"> Change </span>
                                                                                    <input class="form-control" type="file" name="image_brand" accept="image/png,image/PNG,image/jpg,image/jpeg" />
                                                                                </span>
                                                                                <a href="javascript:;" class="btn default fileinput-exists btn-xs" data-dismiss="fileinput"> Remove </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>QR Code</label>
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-new thumbnail">
                                                                                <img src="//placehold.co/120x90/EFEFEF/AAAAAA?text=no+image" class="img-responsive" alt="Avatar" />
                                                                            </div>
                                                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                            <div>
                                                                                <span class="btn default btn-file btn-xs">
                                                                                    <span class="fileinput-new"> Select image </span>
                                                                                    <span class="fileinput-exists"> Change </span>
                                                                                    <input class="form-control" type="file" name="image_qr" accept="image/png,image/PNG,image/jpg,image/jpeg" />
                                                                                </span>
                                                                                <a href="javascript:;" class="btn default fileinput-exists btn-xs" data-dismiss="fileinput"> Remove </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Product Description</label>
                                                                    <textarea class="form-control" name="description" required ></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Product Characteristics</label>
                                                                    <textarea class="form-control" name="feature"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label">Ingredients List</label>
                                                                    <textarea class="form-control" name="ingredients"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Product Claims</label>
                                                                    <select class="form-control mt-multiselect btn btn-default" name="claims[]" multiple="multiple">
                                                                        <?php
                                                                            $selectClaims = mysqli_query( $conn,"SELECT * FROM tbl_products_claims WHERE deleted = 0 ORDER BY name" );
                                                                            if ( mysqli_num_rows($selectClaims) > 0 ) {
                                                                                while($rowClaims = mysqli_fetch_array($selectClaims)) {
                                                                                    echo '<option value="'.$rowClaims['ID'].'">'.$rowClaims['name'].'</option>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Intended Use</label>
                                                                    <select class="form-control" name="intended">
                                                                        <option value="0">Select</option>
                                                                        <?php
                                                                            $selectIntended = mysqli_query( $conn,"SELECT * FROM tbl_products_intended WHERE deleted = 0 ORDER BY name" );
                                                                            if ( mysqli_num_rows($selectIntended) > 0 ) {
                                                                                while($rowIntended = mysqli_fetch_array($selectIntended)) {
                                                                                    $intended_ID = $rowIntended["ID"];
                                                                                    $intended_name = $rowIntended["name"];

                                                                                    echo '<option value="'.$intended_ID.'">'.$intended_name.'</option>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Intended Consumers</label>
                                                                    <input class="form-control" type="text" name="intended_consumers" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Allergens</label>
                                                                    <select class="form-control mt-multiselect btn btn-default" name="allergen[]" multiple="multiple">
                                                                        <?php
                                                                            $selectAllergens = mysqli_query( $conn,"SELECT * FROM tbl_products_allergens ORDER BY name" );
                                                                            if ( mysqli_num_rows($selectAllergens) > 0 ) {
                                                                                while($rowAllergens = mysqli_fetch_array($selectAllergens)) {
                                                                                    echo '<option value="'.$rowAllergens['ID'].'">'.$rowAllergens['name'].'</option>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Available Flavors</label>
                                                                    <input class="form-control" type="text" name="flavor" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Size/UOM</label>
                                                                    <div class="input-group">
                                                                        <input class="form-control" type="number" name="size_uom" min="0" />
                                                                        <div class="input-group-addon" style="padding: 0;">
                                                                            <select name="size_uom_type" style="border: 0; background: transparent;">
                                                                                <?php
                                                                                    $selectUOM = mysqli_query( $conn,"SELECT * FROM tbl_products_uom WHERE deleted = 0" );
                                                                                    if ( mysqli_num_rows($selectUOM) > 0 ) {
                                                                                        while($rowUOM = mysqli_fetch_array($selectUOM)) {
                                                                                            echo '<option value="'.$rowUOM['ID'].'">'.$rowUOM['name'].'</option>';
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Shelf Life</label>
                                                                    <div class="input-group">
                                                                        <input class="form-control" type="number" name="shelf" min="0" />
                                                                        <div class="input-group-addon" style="padding: 0;">
                                                                            <select name="shelf_type" style="border: 0; background: transparent;">
                                                                                <option value="0">Day</option>
                                                                                <option value="1">Week</option>
                                                                                <option value="2">Month</option>
                                                                                <option value="3">Year</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class="control-label">Temperature</label>
                                                                    <input class="form-control" type="text" name="temperature" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Retail Accounts</label>
                                                                    <textarea class="form-control" name="retail_accounts"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Competing Brands</label>
                                                                    <textarea class="form-control" name="competing_brands"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabCharacteristics">
                                                        <h4 class="pictogram-align">
                                                            <strong>Product Description, including Important Food Safety Characteristics</strong>
                                                            <?php
                                                                $pictogram = 'prod_desc';
                                                                if ($switch_user_id == 163) {
                                                                    echo '<div class="pictogram" href="#modalPictogram" data-toggle="modal" onclick="btnPictogram(\''.$pictogram.'\')"></div>';
                                                                } else {
                                                                    $selectPictogram = mysqli_query( $conn,"SELECT * FROM tbl_pictogram WHERE code = '$pictogram'" );
                                                                    if ( mysqli_num_rows($selectPictogram) > 0 ) {
                                                                        $row = mysqli_fetch_array($selectPictogram);
            
                                                                        $files = '';
                                                                        $type = 'iframe';
                                                                        if (!empty($row["files"])) {
                                                                            $arr_filename = explode(' | ', $row["files"]);
                                                                            $arr_filetype = explode(' | ', $row["filetype"]);
                                                                            $str_filename = '';
            
                                                                            foreach($arr_filename as $val_filename) {
                                                                                $str_filename = $val_filename;
                                                                            }
                                                                            foreach($arr_filetype as $val_filetype) {
                                                                                $str_filetype = $val_filetype;
                                                                            }
            
                                                                            $files = $row["files"];
                                                                            if ($row["filetype"] == 1) {
                                                                                $fileExtension = fileExtension($files);
                                                                                $src = $fileExtension['src'];
                                                                                $embed = $fileExtension['embed'];
                                                                                $type = $fileExtension['type'];
                                                                                $file_extension = $fileExtension['file_extension'];
                                                                                $url = $base_url.'uploads/pictogram/';
            
                                                                                $files = $src.$url.rawurlencode($files).$embed;
                                                                            } else if ($row["filetype"] == 3) {
                                                                                $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                            }
                                                                        }
            
                                                                        if (!empty($files)) {
                                                                            echo '<div class="pictogram" href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'"></div>';
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </h4>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label"> Organoleptic/Sensory Characteristics </label>
                                                                    <div class="chars-container">
                                                                        <div class="chars-template margin-bottom-10" style="display:flex; align-items:center; gap:1rem;">
                                                                            <input type="text" name="physical_chars[]" class="form-control" style="flex-grow:1;" placeholder="e.g. Color, Flavor, Texture, Form" />
                                                                            <button type="button" class="btn btn-danger" onclick="deleteChar(this)"><i class="fa fa-close"></i></button>
                                                                        </div>
                                                                    </div>
                                                                    <button type="button" class="btn btn-sm btn-link margin-top-10" data-name="physical_chars[]" data-placeholder="e.g. Color, Flavor, Texture, Form" onclick="addMoreChars(this)">
                                                                         <i class="fa fa-plus"></i> Add more
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Physico - Chemical Characteristics</label>
                                                                    <div class="chars-container">
                                                                        <div class="chars-template margin-bottom-10" style="display:flex; align-items:center; gap:1rem;">
                                                                            <input type="text" name="physico_chem_char[]" class="form-control" style="flex-grow:1;" placeholder="e.g. Moisture/Fat/Ash%, Brix, etc." />
                                                                            <button type="button" class="btn btn-danger" onclick="deleteChar(this)"><i class="fa fa-close"></i></button>
                                                                        </div>
                                                                    </div>
                                                                    <button type="button" class="btn btn-sm btn-link margin-top-10" data-name="physico_chem_char[]" data-placeholder="e.g. Moisture/Fat/Ash%, Brix, etc." onclick="addMoreChars(this)">
                                                                         <i class="fa fa-plus"></i> Add more
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Microbiological Characteristics</label>
                                                                    <div class="chars-container">
                                                                        <div class="chars-template margin-bottom-10" style="display:flex; align-items:center; gap:1rem;">
                                                                            <input type="text" name="microbial_char[]" class="form-control" style="flex-grow:1;" placeholder="e.g. E.coli, Salmonella, Coliform, APC/TPC, Y&M, Listeria" />
                                                                            <button type="button" class="btn btn-danger" onclick="deleteChar(this)"><i class="fa fa-close"></i></button>
                                                                        </div>
                                                                    </div>
                                                                    <button type="button" class="btn btn-sm btn-link margin-top-10" data-name="microbial_char[]" data-placeholder="e.g. E.coli, Salmonella, Coliform, APC/TPC, Y&M, Listeria" onclick="addMoreChars(this)">
                                                                         <i class="fa fa-plus"></i> Add more
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabPackaging">
                                                        <h4><strong>Primary</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label>&nbsp;</label>
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-new thumbnail">
                                                                                <img src="//placehold.co/120x90/EFEFEF/AAAAAA?text=no+image" class="img-responsive" alt="Avatar" />
                                                                            </div>
                                                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                            <div>
                                                                                <span class="btn default btn-file btn-xs">
                                                                                    <span class="fileinput-new"> Select image </span>
                                                                                    <span class="fileinput-exists"> Change </span>
                                                                                    <input class="form-control" type="file" name="packaging_1_image" accept="image/png,image/PNG,image/jpg,image/jpeg" />
                                                                                </span>
                                                                                <a href="javascript:;" class="btn default fileinput-exists btn-xs" data-dismiss="fileinput"> Remove </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Unit</label>
                                                                            <select class="form-control" name="packaging_1">
                                                                                <option value="0">Select</option>

                                                                                <?php
                                                                                    $selectPrimary = mysqli_query( $conn,"SELECT * from tbl_products_primary WHERE deleted = 0" );
                                                                                    if ( mysqli_num_rows($selectPrimary) > 0 ) {
                                                                                        while($rowPrimary = mysqli_fetch_array($selectPrimary)) {
                                                                                            echo '<option value="'.$rowPrimary['ID'].'">'.$rowPrimary['name'].'</option>';
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Dimension</label>
                                                                            <input class="form-control" type="text" name="packaging_1_dimension" placeholder="H x L x W" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">UPC</label>
                                                                            <input class="form-control" type="text" name="packaging_1_upc" placeholder="H x L x W" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Cube</label>
                                                                            <input class="form-control" type="text" name="packaging_1_cube" placeholder="H x L x W" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Ship Weight</label>
                                                                            <input class="form-control" type="text" name="packaging_1_weight" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">No. of Units</label>
                                                                            <input class="form-control" type="text" name="packaging_1_unit" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Size/UOM</label>
                                                                            <div class="input-group">
                                                                                <input class="form-control" type="number" name="packaging_1_size_uom" min="0" />
                                                                                <div class="input-group-addon" style="padding: 0;">
                                                                                    <select name="packaging_1_size_uom_type" style="border: 0; background: transparent;">
                                                                                        <?php
                                                                                            $selectUOM = mysqli_query( $conn,"SELECT * FROM tbl_products_uom WHERE deleted = 0" );
                                                                                            if ( mysqli_num_rows($selectUOM) > 0 ) {
                                                                                                while($rowUOM = mysqli_fetch_array($selectUOM)) {
                                                                                                    echo '<option value="'.$rowUOM['ID'].'">'.$rowUOM['name'].'</option>';
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>

                                                        <h4><strong>Secondary</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label>&nbsp;</label>
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-new thumbnail">
                                                                                <img src="//placehold.co/120x90/EFEFEF/AAAAAA?text=no+image" class="img-responsive" alt="Avatar" />
                                                                            </div>
                                                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                            <div>
                                                                                <span class="btn default btn-file btn-xs">
                                                                                    <span class="fileinput-new"> Select image </span>
                                                                                    <span class="fileinput-exists"> Change </span>
                                                                                    <input class="form-control" type="file" name="packaging_2_image" accept="image/png,image/PNG,image/jpg,image/jpeg" />
                                                                                </span>
                                                                                <a href="javascript:;" class="btn default fileinput-exists btn-xs" data-dismiss="fileinput"> Remove </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Case</label>
                                                                            <select class="form-control" name="packaging_2">
                                                                                <option value="0">Select</option>

                                                                                <?php
                                                                                    $selectSecondary = mysqli_query( $conn,"SELECT * from tbl_products_secondary WHERE deleted = 0" );
                                                                                    if ( mysqli_num_rows($selectSecondary) > 0 ) {
                                                                                        while($rowSecondary = mysqli_fetch_array($selectSecondary)) {
                                                                                            echo '<option value="'.$rowSecondary['ID'].'">'.$rowSecondary['name'].'</option>';
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Dimension</label>
                                                                            <input class="form-control" type="text" name="packaging_2_dimension" placeholder="H x L x W" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">UPC</label>
                                                                            <input class="form-control" type="text" name="packaging_2_upc" placeholder="H x L x W" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Cube</label>
                                                                            <input class="form-control" type="text" name="packaging_2_cube" placeholder="H x L x W" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Ship Weight</label>
                                                                            <input class="form-control" type="text" name="packaging_2_weight" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">No. of Units</label>
                                                                            <input class="form-control" type="text" name="packaging_2_unit" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Size/UOM</label>
                                                                            <div class="input-group">
                                                                                <input class="form-control" type="number" name="packaging_2_size_uom" min="0" />
                                                                                <div class="input-group-addon" style="padding: 0;">
                                                                                    <select name="packaging_2_size_uom_type" style="border: 0; background: transparent;">
                                                                                        <?php
                                                                                            $selectUOM = mysqli_query( $conn,"SELECT * FROM tbl_products_uom WHERE deleted = 0" );
                                                                                            if ( mysqli_num_rows($selectUOM) > 0 ) {
                                                                                                while($rowUOM = mysqli_fetch_array($selectUOM)) {
                                                                                                    echo '<option value="'.$rowUOM['ID'].'">'.$rowUOM['name'].'</option>';
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>

                                                        <h4><strong>Tertiary</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label>&nbsp;</label>
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-new thumbnail">
                                                                                <img src="//placehold.co/120x90/EFEFEF/AAAAAA?text=no+image" class="img-responsive" alt="Avatar" />
                                                                            </div>
                                                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                            <div>
                                                                                <span class="btn default btn-file btn-xs">
                                                                                    <span class="fileinput-new"> Select image </span>
                                                                                    <span class="fileinput-exists"> Change </span>
                                                                                    <input class="form-control" type="file" name="packaging_3_image" accept="image/png,image/PNG,image/jpg,image/jpeg" />
                                                                                </span>
                                                                                <a href="javascript:;" class="btn default fileinput-exists btn-xs" data-dismiss="fileinput"> Remove </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Master Pack</label>
                                                                            <select class="form-control" name="packaging_3">
                                                                                <option value="0">Select</option>

                                                                                <?php
                                                                                    $selectTertiary = mysqli_query( $conn,"SELECT * from tbl_products_tertiary WHERE deleted = 0" );
                                                                                    if ( mysqli_num_rows($selectTertiary) > 0 ) {
                                                                                        while($rowTertiary = mysqli_fetch_array($selectTertiary)) {
                                                                                            echo '<option value="'.$rowTertiary['ID'].'">'.$rowTertiary['name'].'</option>';
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Dimension</label>
                                                                            <input class="form-control" type="text" name="packaging_3_dimension" placeholder="H x L x W" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">UPC</label>
                                                                            <input class="form-control" type="text" name="packaging_3_upc" placeholder="H x L x W" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Cube</label>
                                                                            <input class="form-control" type="text" name="packaging_3_cube" placeholder="H x L x W" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Ship Weight</label>
                                                                            <input class="form-control" type="text" name="packaging_3_weight" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">No. of Units</label>
                                                                            <input class="form-control" type="text" name="packaging_3_unit" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Size/UOM</label>
                                                                            <div class="input-group">
                                                                                <input class="form-control" type="number" name="packaging_3_size_uom" min="0" />
                                                                                <div class="input-group-addon" style="padding: 0;">
                                                                                    <select name="packaging_3_size_uom_type" style="border: 0; background: transparent;">
                                                                                        <?php
                                                                                            $selectUOM = mysqli_query( $conn,"SELECT * FROM tbl_products_uom WHERE deleted = 0" );
                                                                                            if ( mysqli_num_rows($selectUOM) > 0 ) {
                                                                                                while($rowUOM = mysqli_fetch_array($selectUOM)) {
                                                                                                    echo '<option value="'.$rowUOM['ID'].'">'.$rowUOM['name'].'</option>';
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>

                                                        <h4><strong>Pallet Configuration</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label>&nbsp;</label>
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-new thumbnail">
                                                                                <img src="//placehold.co/120x90/EFEFEF/AAAAAA?text=no+image" class="img-responsive" alt="Avatar" />
                                                                            </div>
                                                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                            <div>
                                                                                <span class="btn default btn-file btn-xs">
                                                                                    <span class="fileinput-new"> Select image </span>
                                                                                    <span class="fileinput-exists"> Change </span>
                                                                                    <input class="form-control" type="file" name="pallet_image" accept="image/png,image/PNG,image/jpg,image/jpeg" />
                                                                                </span>
                                                                                <a href="javascript:;" class="btn default fileinput-exists btn-xs" data-dismiss="fileinput"> Remove </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Pallet Type</label>
                                                                            <select class="form-control" name="pallet_type">
                                                                                <option value="0">Select</option>

                                                                                <?php
                                                                                    $selectPallet = mysqli_query( $conn,"
                                                                                        SELECT 
                                                                                        p.id AS group_id,
                                                                                        p.name AS group_name,
                                                                                        t.id AS desciption_id,
                                                                                        t.name AS desciption_name
                                                                                        FROM tbl_products_pallet AS p

                                                                                        LEFT JOIN (
                                                                                            SELECT
                                                                                            *
                                                                                            FROM tbl_products_pallet_type
                                                                                            WHERE deleted = 0
                                                                                        ) AS t
                                                                                        ON p.ID = t.pallet_id

                                                                                        WHERE p.deleted = 0
                                                                                    " );
                                                                                    if ( mysqli_num_rows($selectPallet) > 0 ) {
                                                                                        $pallet_arr = array();
                                                                                        $pallet_arr_prev = 0;
                                                                                        while($rowPallet = mysqli_fetch_array($selectPallet)) {

                                                                                            if (!in_array($rowPallet['group_id'], $pallet_arr)) {
                                                                                                array_push($pallet_arr, $rowPallet['group_id']);

                                                                                                if ($pallet_arr_prev > 0 AND $pallet_arr_prev != $rowPallet['group_id']) {
                                                                                                    echo '</optgroup>';
                                                                                                }
                                                                                                $pallet_arr_prev = $rowPallet['group_id'];

                                                                                                echo '<optgroup label="'.$rowPallet['group_name'].'">';
                                                                                            }

                                                                                            echo '<option value="'.$rowPallet['desciption_id'].'">'.$rowPallet['desciption_name'].'</option>';
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Dimension</label>
                                                                            <input class="form-control" type="text" name="pallet_dimension" placeholder="H x L x W" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">UPC</label>
                                                                            <input class="form-control" type="text" name="pallet_upc" placeholder="H x L x W" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Cube</label>
                                                                            <input class="form-control" type="text" name="pallet_cube" placeholder="H x L x W" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Ship Weight</label>
                                                                            <input class="form-control" type="text" name="pallet_weight" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">No. of Units</label>
                                                                            <input class="form-control" type="text" name="pallet_unit" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">No. of Cartons/Boxes</label>
                                                                            <input class="form-control" type="text" name="pallet_boxes" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>

                                                        <h4><strong>Production</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">No. of Units / Day</label>
                                                                    <input class="form-control" type="text" name="production_day" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">No. of Units / Week</label>
                                                                    <input class="form-control" type="text" name="production_week" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Production Cost</label>
                                                                    <input class="form-control" type="text" name="production_cost" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Profit %</label>
                                                                    <input class="form-control" type="text" name="production_profit" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <h4><strong>Cost Calculation</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Operation</label>
                                                                    <input class="form-control" type="text" name="cost_operation" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Rent, Utilities</label>
                                                                    <input class="form-control" type="text" name="cost_rent" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Materials</label>
                                                                    <input class="form-control" type="text" name="cost_material" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Financing </label>
                                                                    <input class="form-control" type="text" name="cost_financing" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Transportation </label>
                                                                    <input class="form-control" type="text" name="cost_transportation" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <a href="#modalNewData" data-toggle="modal" class="btn green" onclick="btnNew_Data(1, 'Lead Time', 1)">Add Lead Times</a>
                                                                <div class="table-scrollable">
                                                                    <table class="table table-bordered table-hover tbl-data-1-1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Material Name</th>
                                                                                <th style="width: 100px;">Lead Time</th>
                                                                                <th style="width: 100px;">% in Formula</th>
                                                                                <th style="width: 100px;">Cost</th>
                                                                                <th class="text-center" style="width: 135px;">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabDocs">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h4>
                                                                    <strong>Regulatory</strong>
                                                                    <a href="#modalNewData" data-toggle="modal" class="btn green" onclick="btnNew_Data(1, 'Requirements', 5)"><i class="fa fa-plus"></i></a>
                                                                </h4>
                                                                <div class="table-scrollable">
                                                                    <table class="table table-bordered table-hover tbl-data-1-5">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Requirements Name</th>
                                                                                <th class="text-center" style="width: 100px;">File</th>
                                                                                <th class="text-center" style="width: 100px;">Document Date</th>
                                                                                <th class="text-center" style="width: 100px;">Review Due Date</th>
                                                                                <th class="text-center" style="width: 135px;">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h4>
                                                                    <strong>Product Certification & Document</strong>
                                                                    <a href="#modalNewData" data-toggle="modal" class="btn green" onclick="btnNew_Data(1, 'Documents', 6)"><i class="fa fa-plus"></i></a>
                                                                </h4>
                                                                <div class="table-scrollable">
                                                                    <table class="table table-bordered table-hover tbl-data-1-6">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Documents Name</th>
                                                                                <th class="text-center" style="width: 100px;">File</th>
                                                                                <th class="text-center" style="width: 100px;">Document Date</th>
                                                                                <th class="text-center" style="width: 100px;">Review Due Date</th>
                                                                                <th class="text-center" style="width: 135px;">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h4>
                                                                    <strong>Lab</strong>
                                                                    <a href="#modalNewLab" data-toggle="modal" class="btn green" onclick="btnNew_Lab(1)"><i class="fa fa-plus"></i></a>
                                                                </h4>
                                                                <div class="table-scrollable">
                                                                    <table class="table table-bordered table-hover" id="tableLab_1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Lot #</th>
                                                                                <th>Lab</th>
                                                                                <th>Analysis</th>
                                                                                <th>Method</th>
                                                                                <th>Sample Size</th>
                                                                                <th>Unit</th>
                                                                                <th class="text-center">Date Sent for Lab</th>
                                                                                <th class="text-center">Date Received</th>
                                                                                <th class="text-center">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <h4><strong>Exercises</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Mock Recall Exercise</label>
                                                                    <input class="form-control" type="date" name="mock_recall" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Product Trace Exercise</label>
                                                                    <input class="form-control" type="date" name="product_trace" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabManufactured">
                                                        <h4><strong>Manufactured By</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Manufacturer Name</label>
                                                                    <input class="form-control" type="text" name="manu_name" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Phone</label>
                                                                    <input class="form-control" type="text" name="manu_phone" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Contact</label>
                                                                    <input class="form-control" type="text" name="manu_contact" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Facility Address</label>
                                                                    <input class="form-control" type="text" name="manu_address" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Email</label>
                                                                    <input class="form-control" type="email" name="manu_email" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Website</label>
                                                                    <input class="form-control" type="text" name="manu_website" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Facility Registration No.</label>
                                                                    <input class="form-control" type="text" name="manu_reg_no" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Dunn No.</label>
                                                                    <input class="form-control" type="text" name="manu_dunn_no" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <a href="#modalNewData" data-toggle="modal" class="btn green" onclick="btnNew_Data(1, 'Certificate', 2)">Add Certificate</a>
                                                                <div class="table-scrollable">
                                                                    <table class="table table-bordered table-hover tbl-data-1-2">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Certification Name</th>
                                                                                <th class="text-center" style="width: 100px;">File</th>
                                                                                <th class="text-center" style="width: 100px;">Certification Date</th>
                                                                                <th class="text-center" style="width: 100px;">Due Date</th>
                                                                                <th class="text-center" style="width: 135px;">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <h4><strong>Broker Info</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Company Name</label>
                                                                    <input class="form-control" type="text" name="broker_name" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Phone</label>
                                                                    <input class="form-control" type="text" name="broker_phone" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Contact</label>
                                                                    <input class="form-control" type="text" name="broker_contact" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Address</label>
                                                                    <input class="form-control" type="text" name="broker_address" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Email</label>
                                                                    <input class="form-control" type="email" name="broker_email" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Website</label>
                                                                    <input class="form-control" type="text" name="broker_website" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Facility Registration No.</label>
                                                                    <input class="form-control" type="text" name="broker_reg_no" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Dunn No.</label>
                                                                    <input class="form-control" type="text" name="broker_dunn_no" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <a href="#modalNewData" data-toggle="modal" class="btn green" onclick="btnNew_Data(1, 'Certificate', 3)">Add Certificate</a>
                                                                <div class="table-scrollable">
                                                                    <table class="table table-bordered table-hover tbl-data-1-3">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Certification Name</th>
                                                                                <th class="text-center" style="width: 100px;">File</th>
                                                                                <th class="text-center" style="width: 100px;">Certification Date</th>
                                                                                <th class="text-center" style="width: 100px;">Due Date</th>
                                                                                <th class="text-center" style="width: 135px;">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <h4><strong>US Agent Name</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Company Name</label>
                                                                    <input class="form-control" type="text" name="agent_company" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Phone</label>
                                                                    <input class="form-control" type="text" name="agent_phone" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Contact</label>
                                                                    <input class="form-control" type="text" name="agent_contact" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Address</label>
                                                                    <input class="form-control" type="text" name="agent_address" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Email</label>
                                                                    <input class="form-control" type="email" name="agent_email" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Website</label>
                                                                    <input class="form-control" type="text" name="agent_website" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <h4><strong>Importer Info</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Importer Name</label>
                                                                    <input class="form-control" type="text" name="importer_name" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Phone</label>
                                                                    <input class="form-control" type="text" name="importer_phone" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Contact</label>
                                                                    <input class="form-control" type="text" name="importer_contact" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Address</label>
                                                                    <input class="form-control" type="text" name="importer_address" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Email</label>
                                                                    <input class="form-control" type="email" name="importer_email" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Website</label>
                                                                    <input class="form-control" type="text" name="importer_website" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Facility Registration No.</label>
                                                                    <input class="form-control" type="text" name="importer_reg_no" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Dunn No.</label>
                                                                    <input class="form-control" type="text" name="importer_dunn_no" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <a href="#modalNewData" data-toggle="modal" class="btn green" onclick="btnNew_Data(1, 'Certificate', 4)">Add Certificate</a>
                                                                <div class="table-scrollable">
                                                                    <table class="table table-bordered table-hover tbl-data-1-4">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Certification Name</th>
                                                                                <th class="text-center" style="width: 100px;">File</th>
                                                                                <th class="text-center" style="width: 100px;">Certification Date</th>
                                                                                <th class="text-center" style="width: 100px;">Due Date</th>
                                                                                <th class="text-center" style="width: 135px;">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <h4><strong>FSVP Requirements</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Date of FSVP Review</label>
                                                                    <input class="form-control" type="date" name="fsvp_date_review" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Last Date of FDA FSVP Audit</label>
                                                                    <input class="form-control" type="date" name="fsvp_date_audit" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Seasonal</label>
                                                                    <select class="form-control" name="fsvp_seasonal">
                                                                        <option value="0">No</option>
                                                                        <option value="1">Yes</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">If Yes, Available Date</label>
                                                                    <input class="form-control" type="date" name="fsvp_date_available" />
                                                                </div>
                                                            </div>
                                                        </div>
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
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Product Details</h4>
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
                                            <h4 class="modal-title pictogram-align">
                                                New Lab
                                                <?php
                                                    $pictogram = 'prod_lab_add';
                                                    if ($switch_user_id == 163) {
                                                        echo '<div class="pictogram" href="#modalPictogram" data-toggle="modal" onclick="btnPictogram(\''.$pictogram.'\')"></div>';
                                                    } else {
                                                        $selectPictogram = mysqli_query( $conn,"SELECT * FROM tbl_pictogram WHERE code = '$pictogram'" );
                                                        if ( mysqli_num_rows($selectPictogram) > 0 ) {
                                                            $row = mysqli_fetch_array($selectPictogram);

                                                            $files = '';
                                                            $type = 'iframe';
                                                            if (!empty($row["files"])) {
                                                                $arr_filename = explode(' | ', $row["files"]);
                                                                $arr_filetype = explode(' | ', $row["filetype"]);
                                                                $str_filename = '';

                                                                foreach($arr_filename as $val_filename) {
                                                                    $str_filename = $val_filename;
                                                                }
                                                                foreach($arr_filetype as $val_filetype) {
                                                                    $str_filetype = $val_filetype;
                                                                }

                                                                $files = $row["files"];
                                                                if ($row["filetype"] == 1) {
                                                                    $fileExtension = fileExtension($files);
                                                                    $src = $fileExtension['src'];
                                                                    $embed = $fileExtension['embed'];
                                                                    $type = $fileExtension['type'];
                                                                    $file_extension = $fileExtension['file_extension'];
                                                                    $url = $base_url.'uploads/pictogram/';

                                                                    $files = $src.$url.rawurlencode($files).$embed;
                                                                } else if ($row["filetype"] == 3) {
                                                                    $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                }
                                                            }

                                                            if (!empty($files)) {
                                                                echo '<div class="pictogram" href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'"></div>';
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </h4>
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
                                            <h4 class="modal-title pictogram-align">
                                                Lab Details
                                                <?php
                                                    $pictogram = 'prod_lab_edit';
                                                    if ($switch_user_id == 163) {
                                                        echo '<div class="pictogram" href="#modalPictogram" data-toggle="modal" onclick="btnPictogram(\''.$pictogram.'\')"></div>';
                                                    } else {
                                                        $selectPictogram = mysqli_query( $conn,"SELECT * FROM tbl_pictogram WHERE code = '$pictogram'" );
                                                        if ( mysqli_num_rows($selectPictogram) > 0 ) {
                                                            $row = mysqli_fetch_array($selectPictogram);

                                                            $files = '';
                                                            $type = 'iframe';
                                                            if (!empty($row["files"])) {
                                                                $arr_filename = explode(' | ', $row["files"]);
                                                                $arr_filetype = explode(' | ', $row["filetype"]);
                                                                $str_filename = '';

                                                                foreach($arr_filename as $val_filename) {
                                                                    $str_filename = $val_filename;
                                                                }
                                                                foreach($arr_filetype as $val_filetype) {
                                                                    $str_filetype = $val_filetype;
                                                                }

                                                                $files = $row["files"];
                                                                if ($row["filetype"] == 1) {
                                                                    $fileExtension = fileExtension($files);
                                                                    $src = $fileExtension['src'];
                                                                    $embed = $fileExtension['embed'];
                                                                    $type = $fileExtension['type'];
                                                                    $file_extension = $fileExtension['file_extension'];
                                                                    $url = $base_url.'uploads/pictogram/';

                                                                    $files = $src.$url.rawurlencode($files).$embed;
                                                                } else if ($row["filetype"] == 3) {
                                                                    $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                }
                                                            }

                                                            if (!empty($files)) {
                                                                echo '<div class="pictogram" href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'"></div>';
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </h4>
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
                        <div class="modal fade" id="modalNewData" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalNewData">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title"></h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Data" id="btnSave_Data" data-style="zoom-out"><span class="ladda-label">Add</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalEditData" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalEditData">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title"></h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Data" id="btnUpdate_Data" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- / END MODAL AREA -->
                        
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

                		<!--Nelmar Products Analytics Modal -->                                              
                        <div id="modalChart" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Product Name</h4>
                                    </div>
                                    <div class="modal-body">                                                                            
                                        <div class="row">
                                            <div class="col-md-12">                                                 
                                                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-1">   
                                                    <h3 class="d-flex justify-content-center">Documents</h3>   
                                                    <div class="widget-thumb-wrap">                                                                                              
                                                        <div id="documentsChartDiv" style="height: 400px;"></div>                                                              
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">                                                 
                                                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-1">   
                                                    <h3 class="d-flex justify-content-center">Compliance</h3>   
                                                    <div class="widget-thumb-wrap">                                                                                              
                                                        <div id="complianceChartDiv" style="height: 400px;"></div>                                                              
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">                                                 
                                                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-1">   
                                                    <h3 class="d-flex justify-content-center">Share to Marketplace</h3>   
                                                    <div class="widget-thumb-wrap">                                                                                              
                                                        <div id="radioChartDiv" style="height: 400px;"></div>                                                              
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">                                                 
                                                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-1">   
                                                    <h3 class="d-flex justify-content-center">Product Category</h3>   
                                                    <div class="widget-thumb-wrap">                                       
                                                        
                                                        <div id="categoryChartDiv" style="height: 400px;"></div>                                                              
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">                                     
                                                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-1">   
                                                    <h3 class="d-flex justify-content-center">Intended Use</h3>   
                                                    <div class="widget-thumb-wrap">                                       
                                                        
                                                        <div id="intendedChartDiv" style="height: 400px;"></div>                                                              
                                                    </div>
                                                </div>
                                            </div>                                                 
                                            <div class="col-md-12"> 
                                                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-1">                                         
                                                    <h3 class="d-flex justify-content-center">Product Claims</h3>
                                                    <div class="widget-thumb-wrap">
                                                       
                                                        <div id="claimsChartDiv" style="height: 400px;"></div>                                                                 
                                                    </div>
                                                </div>                                 
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline dark" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
        
        <!--<script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>-->
        <!--<script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>-->
        <script src="//code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
        <script src="AnalyticsIQ/products.js"></script>

        <script type="text/javascript">
            // Product Modal Analytics
            $(document).on('click', '.btnChart', function() {
                var productId = $(this).data('id');

                console.log("Button clicked. Product ID:", productId);

                $.ajax({
                    url: 'AnalyticsIQ/products_data.php', // Replace with your PHP file path
                    type: 'POST',
                    data: { id: productId },
                    dataType: 'json',
                    success: function(response) {
                        console.log("AJAX success. Response received:", response);
    
                        // Set the modal title to the product name
                        document.querySelector("#modalChart .modal-title").innerText = "Product Name: " + response.product_name;
    
                        // Function to handle chart creation and disposal
                        function createChart(chartDivId, responseData, seriesName, colors) {
                            var chartDiv = document.getElementById(chartDivId);
    
                            if (!chartDiv) {
                                console.error("Chart div not found:", chartDivId);
                                return;
                            }
    
                            // Dispose existing chart if any
                            if (chartDiv._chartRoot) {
                                console.log("Disposing existing chart for:", chartDivId);
                                chartDiv._chartRoot.dispose();
                                chartDiv._chartRoot = null;
                            }
    
                            // Clear chart container
                            chartDiv.innerHTML = '';
    
                            // Check if there's any data to display
                            if (Object.keys(responseData).length === 0) {
                                console.log("No data available for:", chartDivId);
                                chartDiv.innerHTML = '<p>No data available for this chart</p>';
                                return;
                            }
    
                            console.log("Creating new chart for:", chartDivId);
    
                            // Create a new Root
                            var root = am5.Root.new(chartDivId);
                            chartDiv._chartRoot = root;
    
                            var chart = root.container.children.push(am5xy.XYChart.new(root, {
                                panX: false,
                                panY: false,
                                wheelX: "none",
                                wheelY: "none",
                                pinchZoomX: false
                            }));
    
                            var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                                categoryField: "category",
                                renderer: am5xy.AxisRendererX.new(root, { minGridDistance: 30 })
                            }));
    
                            var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                                renderer: am5xy.AxisRendererY.new(root, {})
                            }));
    
                            var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                                name: seriesName,
                                xAxis: xAxis,
                                yAxis: yAxis,
                                valueYField: "value",
                                categoryXField: "category"
                            }));
    
                            var data = Object.keys(responseData).map(function(key, index) {
                                return { 
                                    category: key, 
                                    value: responseData[key], 
                                    color: colors[index % colors.length]  // Ensure a valid color is always used
                                };
                            });
    
                            console.log("Setting chart data:", data);
    
                            xAxis.data.setAll(data);
                            series.data.setAll(data);
    
                            series.columns.template.setAll({
                                tooltipText: "{category}: {valueY}",
                                tooltipY: 0,
                                strokeOpacity: 0
                            });
    
                            series.columns.template.adapters.add("fill", function(fill, target) {
                                return am5.color(target.dataItem.dataContext.color);
                            });
    
                            series.appear(1000);
                            chart.appear(1000, 100);
                        }
    
                        // Render Category Chart
                        createChart("categoryChartDiv", response.category_counts, "Category Count", ["rgba(54, 162, 235, 1)"]);
    
                        // Render Intended Chart
                        createChart("intendedChartDiv", response.intended_counts, "Intended Count", ["rgba(75, 192, 192, 1)"]);
    
                        // Render Claims Chart
                        createChart("claimsChartDiv", response.claim_counts, "Claim Count", ["rgba(255, 206, 86, 1)"]);
    
                        // Bar Chart for Documents with different colors for each
                        createChart("documentsChartDiv", {
                            'Total Documents': response.total_documents,
                            'Specification': response.specifcation ? 1 : 0,
                            'Artwork': response.artwork ? 1 : 0,
                            'HACCP': response.haccp ? 1 : 0,
                            'Label': response.label ? 1 : 0,
                            'Formulation': response.formulation ? 1 : 0
                        }, "Documents", ["#14948e", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40"]);
    
                        // Pie Chart for Radio Fields with compliance colors
                        function createPieChart(chartDivId, data) {
                            var chartDiv = document.getElementById(chartDivId);
                            if (!chartDiv) {
                                console.error("Chart div not found:", chartDivId);
                                return;
                            }
                
                            // Dispose of the existing chart if it exists
                            if (chartDiv._chartRoot) {
                                chartDiv._chartRoot.dispose();
                                chartDiv._chartRoot = null;
                            }
                
                            // Clear the div's inner HTML
                            chartDiv.innerHTML = '';
                
                            // Create the root element for the chart
                            var root = am5.Root.new(chartDivId);
                            chartDiv._chartRoot = root;
                
                            // Create the pie chart
                            var chart = root.container.children.push(am5percent.PieChart.new(root, {
                                layout: root.verticalLayout
                            }));
                
                            // Create the pie series
                            var series = chart.series.push(am5percent.PieSeries.new(root, {
                                valueField: "value",
                                categoryField: "category",
                                fillField: "color" // Directly use the color from the data
                            }));
                
                            // Set the label format
                            series.labels.template.setAll({
                                text: "{category}: {value}"
                            });
                
                            // Map data to chart
                            series.data.setAll(data);
                
                            // Animate the chart appearance
                            series.appear(1000, 100);
                        }
        
                        // Data preparation with explicit color assignment
                        var complianceData = [
                            { category: 'Specification Yes', value: response.specifcation_radio === 'Yes' ? 1 : 0, color: am5.color('#35dc79') },
                            { category: 'Artwork Yes', value: response.artwork_radio === 'Yes' ? 1 : 0, color: am5.color('#60e496') },
                            { category: 'HACCP Yes', value: response.haccp_radio === 'Yes' ? 1 : 0, color: am5.color('#4be087') },
                            { category: 'Label Yes', value: response.label_radio === 'Yes' ? 1 : 0, color: am5.color('#35dc79') },
                            { category: 'Formulation Yes', value: response.formulation_radio === 'Yes' ? 1 : 0, color: am5.color('#25d36c') },
                            { category: 'Specification No', value: response.specifcation_radio === 'No' ? 1 : 0, color: am5.color('#f09399') },
                            { category: 'Artwork No', value: response.artwork_radio === 'No' ? 1 : 0, color: am5.color('#ed7d84') },
                            { category: 'HACCP No', value: response.haccp_radio === 'No' ? 1 : 0, color: am5.color('#ea666f') },
                            { category: 'Label No', value: response.label_radio === 'No' ? 1 : 0, color: am5.color('#e7505a') },
                            { category: 'Formulation No', value: response.formulation_radio === 'No' ? 1 : 0, color: am5.color('#e43a45') }
                        ];
                
                        createPieChart("radioChartDiv", complianceData);
                
                        // Donut Chart for Compliance with direct color assignment
                        var compliancePercentageData = [
                            { category: 'Compliance', value: response.compliance_percentage, color: am5.color('#35dc79') },
                            { category: 'Non-Compliance', value: response.non_compliance_percentage, color: am5.color('#e7505a') }
                        ];
                
                        createPieChart("complianceChartDiv", compliancePercentageData);                
                    },
                    
                    error: function(xhr, status, error) {
                        console.error("AJAX error:", status, error);
                    }
    
                });
            });
            //End of Product Modal Analytics

            var productDT;
            $(document).ready(function(){
                fancyBoxes();
                widget_formRepeater();
                selectMulti();
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
                
                fetchProducts();
            });
            
            $("#vendor_name").autocomplete({
                source: "function.php?modalView_Vendor=1",
                minLength: 1,
                select: function(event, ui) {
                    $("#vendor_s_ID").val(ui.item.vendor_s_ID);
                    $("#vendor_c_ID").val(ui.item.vendor_c_ID);
                    $("#vendor_id").val(ui.item.vendor_id);
                    $("#vendor_name").val(ui.item.value);
                    $("#vendor_code").val(ui.item.vendor_code);
                    $("#vendor_address").val(ui.item.address);
                    $("#vendor_phone").val(ui.item.phone);
                    $("#vendor_fax").val(ui.item.fax);
                    $("#vendor_email").val(ui.item.email);
                    $("#vendor_business").val(ui.item.business);
                    $("#vendor_size").val(ui.item.size);
                    $("#vendor_location").val(ui.item.location);
                    $("#vendor_geographic").val(ui.item.geographic);
                    $("#vendor_retail").val(ui.item.retail);
                    $("#vendor_diversity").val(ui.item.diversity);
                    $("#vendor_responsibility").val(ui.item.responsibility);
                }
            }).data("ui-autocomplete")._renderItem = function( ul, item ) {
                return $( "<li class='mt-actions ui-autocomplete-row'></li>" )
                .data( "item.autocomplete", item )
                .append( item.label )
                .appendTo( ul );
            };
            
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
                        url: "function.php?btnDelete_Products="+id,
                        dataType: "html",
                        success: function(response){
                            // $('#mt_action_'+id).remove();
                            fetchProducts();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }

            function btnView(id, source) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Products="+id+"&s="+source,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                        $(".modalForm").validate();
                        widget_formRepeater();
                        selectMulti();

                        $("#vendor_name2").autocomplete({
                            source: "function.php?modalView_Vendor=1",
                            minLength: 1,
                            select: function(event, ui) {
                                $("#vendor_s_ID2").val(ui.item.vendor_s_ID);
                                $("#vendor_c_ID2").val(ui.item.vendor_c_ID);
                                $("#vendor_id2").val(ui.item.vendor_id);
                                $("#vendor_name2").val(ui.item.value);
                                $("#vendor_code2").val(ui.item.vendor_code);
                                $("#vendor_address2").val(ui.item.address);
                                $("#vendor_phone2").val(ui.item.phone);
                                $("#vendor_fax2").val(ui.item.fax);
                                $("#vendor_email2").val(ui.item.email);
                                $("#vendor_business2").val(ui.item.business);
                                $("#vendor_size2").val(ui.item.size);
                                $("#vendor_location2").val(ui.item.location);
                                $("#vendor_geographic2").val(ui.item.geographic);
                                $("#vendor_retail2").val(ui.item.retail);
                                $("#vendor_diversity2").val(ui.item.diversity);
                                $("#vendor_responsibility2").val(ui.item.responsibility);
                            }
                        }).data("ui-autocomplete")._renderItem = function( ul, item ) {
                            return $( "<li class='mt-actions ui-autocomplete-row'></li>" )
                            .data( "item.autocomplete", item )
                            .append( item.label )
                            .appendTo( ul );
                        };
                        
                        // $('[data-role="tagsinput2"').tagsinput();
                        // vendorDropdownChange();
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
                    url: "function.php",
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
                            fetchProducts();
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
                    url: "function.php",
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
                            fetchProducts();
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
                    url: "function.php?modalNew_Lab="+modal,
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
                    url: "function.php",
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
            function fetchProducts() {
                if(isFetching) {
                    console.log('Already fetching...');
                    return;
                }
                
                isFetching = true;
                
                $.ajax({    
                    type: "GET",
                    url: "?fetchProducts",
                    dataType: "json",                  
                    success: function(data){       
                        if(Array.isArray(data) && data.length) {
                            productDT.clear().draw();
                            data.forEach((d) => {
                                productDT.row.add([
                                    `
                                        <div style="display: flex; gap:1rem;">
                                            <img src="${d.image}" onerror="this.onerror=null;this.src=\'https://placehold.co/40x40/EFEFEF/AAAAAA?text=no+image\';" style="width: 40px; height: 40px; object-fit: cover; object-position: center;" />
                                            <div>
                                                <span style="font-weight: 600;">${d.name}</span>
                                                <p class="text-muted" style="padding:0; margin:0;">${d.description}</p>
                                            </div>    
                                        </div>
                                    `,
                                    `<span class="label label-sm label-success btn-circle">${d.category}</span>`,
                                    `<span class="text-muted">${d.last_update}</span>`,
                                    `
                                        <div class="btn-group btn-group-circle" style="position: unset;">
                                            <a href="#modalView" data-toggle="modal" data-id="${d.id}" class="btn btn-outline dark btn-sm btnView" onclick="btnView(${d.id}, ${d.source})">View</a>
                                            
                                            <!-- Button to Show Chart -->
                                            <a href="#modalChart" class="btn btn-info btn-sm btnChart" data-toggle="modal" data-id="${d.id}">
                                            <i class="fas fa-chart-line"></i></a>

                                            <a href="javascript:;" class="btn btn-outlinex red btn-sm btnDelete" data-id="${d.id}" onclick="btnDelete(${d.id})">Delete</a>
                                        </div>
                                    `,
                                ]).draw();
                                
                                
                                
                                // echo '<div class="mt-action" id="mt_action_'.$row["p_ID"].'_'.$row["p_source"].'">
                                //     <div class="mt-action-img"><img src="'.$files.'" onerror="this.onerror=null;this.src=\'https://via.placeholder.com/40x40/EFEFEF/AAAAAA.png?text=no+image\';" style="width: 40px; height: 40px; object-fit: cover; object-position: center;" /></div>
                                //     <div class="mt-action-body">
                                //         <div class="mt-action-row">
                                //             <div class="mt-action-info ">
                                //                 <div class="mt-action-details">
                                //                     <span class="mt-action-author">'.htmlentities($row["p_name"] ?? '').'</span>
                                //                     <p class="mt-action-desc">'.htmlentities($row["p_description"] ?? '').'</p>
                                //                 </div>
                                //             </div>
                                //             <div class="mt-action-datetime" style="width: 150px;">
                                //                 <span class="label label-sm label-success btn-circle">'. htmlentities($row["p_category"] ?? '') .'</span>
                                //             </div>
                                //             <div class="mt-action-datetime">
                                //                 <span class="mt-action-date">'. $row["p_last_modified"] .'</span>
                                //             </div>
                                //             <div class="mt-action-buttons">
                                //                 <div class="btn-group btn-group-circle">
                                //                     <a href="#modalView" data-toggle="modal" data-id="'. $row["p_ID"] .'" class="btn btn-outline dark btn-sm btnView" onclick="btnView('.$row["p_ID"].', '.$row["p_source"].')">View</a>
                                //                     <a href="javascript:;" class="btn btn-outlinex red btn-sm btnDelete" data-id="'. $row["p_ID"] .'" onclick="btnDelete('.$row["p_ID"].', '.$row["p_source"].')">Delete</a>
                                //                 </div>
                                //             </div>
                                //         </div>
                                //     </div>
                                // </div>';
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
                    url: "function.php?modalEdit_Lab="+id+"&modal="+modal,
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
                    url: "function.php",
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
                        url: "function.php?btnDelete_Lab="+id,
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


            function btnNew_Data(modal, title, section) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Data="+modal+"&s="+section,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalNewData .modal-title").html('New '+title);
                        $("#modalNewData .modal-body").html(data);
                    }
                });
            }
            function btnEdit_Data(id, modal, section) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalEdit_Data="+id+"&m="+modal+"&s="+section,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalEditData .modal-title").html('Edit Detail');
                        $("#modalEditData .modal-body").html(data);
                    }
                });
            }
            function btnRemove_Data(id, section, e) {
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
                        url: "function.php?btnDelete_Data="+id+"&s="+section,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            $(".modalNewData").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalNewData') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnSave_Data',true);

                var l = Ladda.create(document.querySelector('#btnSave_Data'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);


                            $('.tbl-data-'+obj.modal+'-'+obj.section+' tbody').append(obj.data);
                            $('#modalNewData').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalEditData").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalEditData') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Data',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Data'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);

                            $('.tbl-data-'+obj.modal+'-'+obj.section+' tbody #tr_'+obj.ID).html(obj.data);
                            $('#modalEditData').modal('hide');
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