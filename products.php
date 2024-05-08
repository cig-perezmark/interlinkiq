<?php 
    $title = "Products";
    $site = "products";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';
    
    if(isset($_GET['fetchProducts'])) {
        include_once __DIR__ .'/database_iiq.php';
        include_once __DIR__ . '/alt-setup/setup.php';
        
        $result = mysqli_query( $conn,"SELECT * FROM tbl_products WHERE deleted = 0 AND user_id = $user_id" );
        $data = [];
        if ( mysqli_num_rows($result) > 0 ) {
            while($row = mysqli_fetch_array($result)) {
                $data_image = $row['image'];
                $url_base = "";
                $image_main = "https://via.placeholder.com/40x40/EFEFEF/AAAAAA&text=No+Image";

                if (!empty($data_image)) {

                    $data_image_array = explode(", ", $data_image);
                    if (!empty($data_image_array[0])) {
                        $url_base = "//interlinkiq.com/uploads/products/";

                        $image_main = $data_image_array[0];
                    }
                }

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
                    'image' => $url_base.$image_main,
                    'description' => htmlentities($row["description"]),
                    'name' => htmlentities($row["name"]),
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
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-puzzle font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Products</span>
                                        <?php
                                            if($current_client == 0) {
                                                // $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND (user_id = $switch_user_id OR user_id = $current_userEmployerID OR user_id = 163)");
                                                $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site'");
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $type_id = $row["type"];
                                                    $file_title = $row["file_title"];
                                                    $video_url = $row["youtube_link"];
                                                    
                                                    $file_upload = $row["file_upload"];
                                                    if (!empty($file_upload)) {
                                        	            $fileExtension = fileExtension($file_upload);
                                        				$src = $fileExtension['src'];
                                        				$embed = $fileExtension['embed'];
                                        				$type = $fileExtension['type'];
                                        				$file_extension = $fileExtension['file_extension'];
                                        	            $url = $base_url.'uploads/instruction/';
                                        
                                                		$file_url = $src.$url.rawurlencode($file_upload).$embed;
                                                    }
                                                    
                                                    if ($type_id == 0) {
                                                		echo ' - <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'"><i class="fa '. $file_extension .'"></i> '.$file_title.'</a>';
                                                	} else {
                                                		echo ' - <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox><i class="fa fa-youtube"></i> '.$file_title.'</a>';
                                                	}
	                                            }
                                            }
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
                                    <table class="table table-bordered table-hover" id="productsTable">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th style="width: 150px;">Category</th>
                                                <th style="width: 135px;">Last Update</th>
                                                <th style="width: 90px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END BORDERED TABLE PORTLET-->
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
                                                        <a href="#tabBasic" data-toggle="tab">Basic Details</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabProductDescription" data-toggle="tab">Product Characteristics</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabAllergens" data-toggle="tab">Allergens</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabDimensions" data-toggle="tab">Dimensions</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabStorage" data-toggle="tab">Storage & Distribution</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabManufacturing" data-toggle="tab">Manufacturing Details</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabExercises" data-toggle="tab">Exercises</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabDocuments" data-toggle="tab">Documents</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabLabs" data-toggle="tab">Labs</a>
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
                                                    <div class="tab-pane active" id="tabBasic">
                                                        <h4><strong>Basic Details</strong></h4>
                                                        <div class="row margin-bottom-20">
                                                            <div class="col-md-6 productMain">
                                                                <p><strong>Main Product View</strong></p>
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail">
                                                                        <img src="https://via.placeholder.com/400x250/EFEFEF/AAAAAA&text=Main+Product+View" class="img-responsive" alt="Avatar" />
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
                                                                                <img src="https://via.placeholder.com/120x90/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />
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
                                                                                <img src="https://via.placeholder.com/120x90/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />
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
                                                                                <img src="https://via.placeholder.com/120x90/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />
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
                                                                                <img src="https://via.placeholder.com/120x90/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />
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
                                                                                <img src="https://via.placeholder.com/120x90/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />
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
                                                                                <img src="https://via.placeholder.com/120x90/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />
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

                                                        <label class="control-label hide">Product Images</label>
                                                        <div class="row hide">
                                                            <div class="col-md-12" id="displayProductImages">
                                                                <div class="rowx g-1 productGallery" id="displayProductImages-row"></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="file" class="form-controlx borderx border-darkx" id="uploadProductImages" name="uploadProductImages[]" accept="image/png,image/PNG,image/jpg,image/jpeg" multiple>
                                                            </div>
                                                        </div>
                                                        <div class="row margin-top-20">
                                                            <div class="col-md-12">
                                                               <div class="form-group">
                                                                    <label class="control-label">Labeling Instructions</label>
                                                                    <textarea class="form-control" name="labeling_instructions" row="3" placeholder="Add labeling instructions"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Product Code</label>
                                                                    <input class="form-control" type="text" name="code" placeholder="Enter product code" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <label class="control-label">Product Name</label>
                                                                    <input class="form-control" type="text" name="name" placeholder="Enter product name" required />
                                                                </div>
                                                            </div>
                                                            
                                                            <?php 
                                                                $supplierData = $conn->query("SELECT ID,name,vendor_code FROM tbl_supplier WHERE page = 2 AND user_id=$switch_user_id AND is_deleted = 0 ORDER BY name ASC");
                                                                $supplierInfo = [];
                                                                if($supplierData->num_rows) while($sr = $supplierData->fetch_assoc()) {
                                                                    $supplierInfo[] = $sr;
                                                                }
                                                            ?>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Vendor Code</label>
                                                                    <select class="form-control" name="vendor_code" disabled title="Automatically set when selecting a vendor name">
                                                                        <option value="" selected disabled>--Select--</option>
                                                                        <?php foreach($supplierInfo as $s) echo '<option value="'.$s['ID'].'">'.(isset($s['vendor_code']) ? $s['vendor_code'] : 'No vendor code').'</option>'; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Vendor Name</label>
                                                                    <select class="form-control mt-multiselect btn btn-default" id="supplierNameSelect" name="vendor_name">
                                                                        <option value="" selected disabled>--Select--</option>
                                                                        <?php foreach($supplierInfo as $s) echo '<option value="'.$s['ID'].'">'.$s['name'].'</option>'; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Product Category</label>
                                                                    <select class="form-control" name="category" required onchange="evaluateManufacturingDetails(event)">
                                                                        <option value="" selected disabled>--Select category--</option>
                                                                        <?php
                                                                            $selectProductCategory = mysqli_query( $conn,"SELECT * FROM tbl_products_category ORDER BY name" );
                                                                            if ( mysqli_num_rows($selectProductCategory) > 0 ) {
                                                                                while($rowPC = mysqli_fetch_array($selectProductCategory)) {
                                                                                    $pc_ID = $rowPC['ID'];
                                                                                    $pc_name = $rowPC['name'];
                                                                                    echo '<option value="'. $pc_ID .'">'. $pc_name .'</option>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">(Specify if other)</label>
                                                                    <input class="form-control" type="text" name="category_other" placeholder="(If not in list)" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Ingredient List</label>
                                                                    <textarea class="form-control" name="ingredient" required placeholder="Enter product ingredients"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Description</label>
                                                                    <textarea class="form-control" name="description" required placeholder="Add product description"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <h4><strong>Packaging Details</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Primary/Unit</label>
                                                                    <input class="form-control" type="text" name="packaging_1" placeholder="Enter primary/unit packaging" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Secondary/Case</label>
                                                                    <input class="form-control" type="text" name="packaging_2" placeholder="Enter secondary/case packaging" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Tertiary/Master Pack</label>
                                                                    <input class="form-control" type="text" name="packaging_3" placeholder="Enter tertiary/master pack packaging" />
                                                                </div>
                                                                 <div class="form-group">
                                                                    <label class="control-label">Packaging Temperature</label>
                                                                    <input class="form-control" type="text" name="packaging_temperature" placeholder="Enter packaging temperature" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Intended Use</label>
                                                                    <select class="form-control" name="intended">
                                                                        <option value="0" selected disabled>--Select intended use--</option>
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
                                                                <div class="form-group">
                                                                    <label class="control-label">Intended Consumers</label>
                                                                    <input class="form-control" type="text" name="intended_consumers" placeholder="Enter intended consumers" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Product Claims</label>
                                                                    <div class="mt-checkbox-list" style="column-count: 3;">
                                                                        <?php
                                                                            $selectClaims = mysqli_query( $conn,"SELECT * FROM tbl_products_claims WHERE deleted = 0 ORDER BY name" );
                                                                            if ( mysqli_num_rows($selectClaims) > 0 ) {
                                                                                while($rowClaims = mysqli_fetch_array($selectClaims)) {
                                                                                    $claims_ID = $rowClaims["ID"];
                                                                                    $claims_name = $rowClaims["name"];

                                                                                    echo '<label class="mt-checkbox mt-checkbox-outline"> '.$claims_name.'
                                                                                        <input type="checkbox" value="'.$claims_ID.'" name="claims[]">
                                                                                        <span></span>
                                                                                    </label>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row hide">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label">Packaging Material List</label>
                                                                    <textarea class="form-control" name="material"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabProductDescription">
                                                        <h4><strong>Product Description, including Important Food Safety Characteristics</strong></h4>
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
                                                    <div class="tab-pane" id="tabAllergens">
                                                        <h4><strong>Allergens</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <div class="mt-checkbox-list">
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Milk
                                                                            <input type="checkbox" value="1" name="allergen[]">
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Eggs
                                                                            <input type="checkbox" value="2" name="allergen[]">
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Fish (e.g., bass, flounder, cod)
                                                                            <input type="checkbox" value="3" name="allergen[]">
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Crustacean shellfish (e.g., crab, lobster, shrimp)
                                                                            <input type="checkbox" value="4" name="allergen[]">
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <div class="mt-checkbox-list">
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Tree nuts (e.g., almonds, walnuts, pecans)
                                                                            <input type="checkbox" value="5" name="allergen[]">
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Peanuts
                                                                            <input type="checkbox" value="6" name="allergen[]">
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Wheat
                                                                            <input type="checkbox" value="7" name="allergen[]">
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Soybeans
                                                                            <input type="checkbox" value="8" name="allergen[]">
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <div class="mt-checkbox-list">
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Sesame
                                                                            <input type="checkbox" value="9" name="allergen[]">
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-checkbox mt-checkbox-outline"> None
                                                                            <input type="checkbox" value="10" name="allergen[]">
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-checkbox mt-checkbox-outline"> Other
                                                                            <input type="checkbox" value="11" name="allergen[]">
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                    <input class="form-control" type="text" name="allergen_other" placeholder="(Specify if Other)" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabDimensions">
                                                        <h4><strong>Dimensions</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Unit Dimension/s</label>
                                                                    <input class="form-control" type="text" name="unit" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Box Dimension/s</label>
                                                                    <input class="form-control" type="text" name="boxes" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Pallet Dimension/s</label>
                                                                    <input class="form-control" type="text" name="pallet" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <h4><strong>Count</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">How many units per carton/box?</label>
                                                                    <input class="form-control" type="text" name="count_unit_box" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">How many units per pallet?</label>
                                                                    <input class="form-control" type="text" name="count_unit_pallet" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">How many carton/box per pallet?</label>
                                                                    <input class="form-control" type="text" name="count_unit_carton" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabStorage">
                                                        <h4><strong>Storage</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Shelf Life</label>
                                                                    <input class="form-control" type="text" name="shelf" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Storage and Handling Requirement</label>
                                                                    <input class="form-control" type="text" name="storage" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Storage/Warehouse Location</label>
                                                                    <input class="form-control" type="text" name="warehouse" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">UPC Code</label>
                                                                    <input class="form-control" type="text" name="upc" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">GTIN Number</label>
                                                                    <input class="form-control" type="text" name="gtin" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Lead Time</label>
                                                                    <input class="form-control" type="text" name="lead" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Minimum Order Quantity</label>
                                                                    <input class="form-control" type="text" name="moq" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <h4><strong>Distribution</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Type of Distribution</label>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio mt-radio-outline">
                                                                            <input type="radio" name="export" value="0" checked=""> Local
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio mt-radio-outline">
                                                                            <input type="radio" name="export" value="1"> International
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label class="control-label">Specify the country</label>
                                                                    <textarea class="form-control" name="countries"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabManufacturing">
                                                        <h4><strong>Manufacturing Details</strong></h4>
                                                        <div class="row" data-manufacturing-details="default">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Manufactured by</label>
                                                                    <input class="form-control" type="text" name="manufactured_by" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Manufactured for</label>
                                                                    <input class="form-control" type="text" name="manufactured_for" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Distributed by</label>
                                                                    <input class="form-control" type="text" name="distributed_by" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row hide" data-manufacturing-details="[27,28]">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Enterprise Name</label>
                                                                    <!-- mb = *manufactured/distributed* -->
                                                                    <input class="form-control" type="text" name="mb_enterprise_name" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Lot Code</label>
                                                                    <input class="form-control" type="text" name="mb_lot_code" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Manufactured Date</label>
                                                                    <input class="form-control" type="date" name="mb_manufactured_date" />
                                                                </div>
                                                            </div>
                                                             <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Expiry Date</label>
                                                                    <input class="form-control" type="date" name="mb_expiry_date" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row hide" data-manufacturing-details="[29]">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Supplier Name</label>
                                                                    <input class="form-control" type="text" name="traded_supplier_name" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Supplied for</label>
                                                                    <input class="form-control" type="text" name="traded_supplied_for" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Supplier-issued Lot Code</label>
                                                                    <input class="form-control" type="text" name="traded_supplied_lot_code" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Manufactured Date</label>
                                                                    <input class="form-control" type="date" name="traded_manufactured_date" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Expiry Date</label>
                                                                    <input class="form-control" type="date" name="traded_expiry_date" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row hide" data-manufacturing-details="[30]">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Manufactured by</label>
                                                                    <input class="form-control" type="text" name="branded_manufactured_by" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Manufactured for</label>
                                                                    <input class="form-control" type="text" name="branded_manufactured_for" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Manufactured Date</label>
                                                                    <input class="form-control" type="date" name="branded_manufactured_date" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Expiry Date</label>
                                                                    <input class="form-control" type="date" name="branded_expiry_date" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Lot Code assigned by Manufacturer</label>
                                                                    <input class="form-control" type="text" name="branded_lot_code_by_manufacturer" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Lot code assigned by Enterprise</label>
                                                                    <input class="form-control" type="text" name="branded_lot_code_by_enterprise" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h4><strong>Receiving Details</strong></h4>
                                                        <div class="row">
                                                            <?php 
                                                                $countriesArr = [];
                                                                $countriesResult = $conn->query("SELECT iso2,name FROM countries");
                                                                if($countriesResult->num_rows) while($row = $countriesResult->fetch_assoc()) {
                                                                    $countriesArr[] = $row;
                                                                }
                                                            ?>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Country of Purchase</label>
                                                                    <select class="form-control" name="country_of_purchase">
                                                                        <option value="" selected disabled>--Select--</option>
                                                                        <?php foreach($countriesArr as $c) echo '<option value="'.$c['iso2'].'">'.$c['name'].'</option>'; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Country of Origin</label>
                                                                    <select class="form-control" name="country_of_origin">
                                                                        <option value="" selected disabled>--Select--</option>
                                                                        <?php foreach($countriesArr as $c) echo '<option value="'.$c['iso2'].'">'.$c['name'].'</option>'; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Delivered from</label>
                                                                    <select class="form-control" name="delivered_from">
                                                                        <option value="" selected disabled>--Select--</option>
                                                                        <?php foreach($countriesArr as $c) echo '<option value="'.$c['iso2'].'">'.$c['name'].'</option>'; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabExercises">
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
                                                    <div class="tab-pane" id="tabDocuments">
                                                        <h4><strong>Documents</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Product Specification</label>
                                                                    <input class="form-control" type="file" name="specifcation" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Due Date</label>
                                                                    <input class="form-control" type="date" name="specifcation_date" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Share to Marketplace?</label>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio mt-radio-outline"> No
                                                                            <input type="radio" value="0" name="specifcation_radio" checked />
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio mt-radio-outline"> Yes
                                                                            <input type="radio" value="1" name="specifcation_radio" />
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Packaging Artwork</label>
                                                                    <input class="form-control" type="file" name="artwork" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Due Date</label>
                                                                    <input class="form-control" type="date" name="artwork_date" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Share to Marketplace?</label>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio mt-radio-outline"> No
                                                                            <input type="radio" value="0" name="artwork_radio" checked />
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio mt-radio-outline"> Yes
                                                                            <input type="radio" value="1" name="artwork_radio" />
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Food Safety Plan/HACCP</label>
                                                                    <input class="form-control" type="file" name="haccp" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Due Date</label>
                                                                    <input class="form-control" type="date" name="haccp_date" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Share to Marketplace?</label>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio mt-radio-outline"> No
                                                                            <input type="radio" value="0" name="haccp_radio" checked />
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio mt-radio-outline"> Yes
                                                                            <input type="radio" value="1" name="haccp_radio" />
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Label</label>
                                                                    <input class="form-control" type="file" name="label" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Due Date</label>
                                                                    <input class="form-control" type="date" name="label_date" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Share to Marketplace?</label>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio mt-radio-outline"> No
                                                                            <input type="radio" value="0" name="label_radio" checked />
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio mt-radio-outline"> Yes
                                                                            <input type="radio" value="1" name="label_radio" />
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Formulation</label>
                                                                    <input class="form-control" type="file" name="formulation" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Due Date</label>
                                                                    <input class="form-control" type="date" name="formulation_date" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Share to Marketplace?</label>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio mt-radio-outline"> No
                                                                            <input type="radio" value="0" name="formulation_radio" checked />
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio mt-radio-outline"> Yes
                                                                            <input type="radio" value="1" name="formulation_radio" />
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-repeater mt-repeater-docs">
                                                            <div data-repeater-list="docs">
                                                                <div class="mt-repeater-item row" data-repeater-item>
                                                                    <div class="col-lg-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Document Name</label>
                                                                            <input class="form-control" type="text" name="docs_label" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Document</label>
                                                                            <input class="form-control" type="file" name="docs_file" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Date</label>
                                                                            <input class="form-control" type="date" name="docs_date" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Share to Marketplace?</label>
                                                                            <div class="mt-radio-inline" style="position: relative;">
                                                                                <label class="mt-radio mt-radio-outline"> No
                                                                                    <input type="radio" value="0" name="docs_radio" checked />
                                                                                    <span></span>
                                                                                </label>
                                                                                <label class="mt-radio mt-radio-outline"> Yes
                                                                                    <input type="radio" value="1" name="docs_radio" />
                                                                                    <span></span>
                                                                                </label>
                                                                                <a href="javascript:;" data-repeater-delete class="btn btn-danger" style="position: absolute; right: 0; top: 0;"><i class="fa fa-close"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add btnEducation"><i class="fa fa-plus"></i> Add more Document</a>
                                                        </div>


                                                        <div class="row hidden">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label class="control-label">Certificate of Origin</label>
                                                                    <input class="form-control" type="file" name="origin" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Share to Marketplace?</label>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio mt-radio-outline"> No
                                                                            <input type="radio" value="0" name="origin_radio" checked />
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio mt-radio-outline"> Yes
                                                                            <input type="radio" value="1" name="origin_radio" />
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row hidden">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label class="control-label">Finish Product Recall Procedures</label>
                                                                    <input class="form-control" type="file" name="procedures" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Share to Marketplace?</label>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio mt-radio-outline"> No
                                                                            <input type="radio" value="0" name="procedures_radio" checked />
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio mt-radio-outline"> Yes
                                                                            <input type="radio" value="1" name="procedures_radio" />
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row hidden">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label class="control-label">Certificate of Analysis</label>
                                                                    <input class="form-control" type="file" name="analysis" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Share to Marketplace?</label>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio mt-radio-outline"> No
                                                                            <input type="radio" value="0" name="analysis_radio" checked />
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio mt-radio-outline"> Yes
                                                                            <input type="radio" value="1" name="analysis_radio" />
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row hidden">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label class="control-label">Safety Data Sheet</label>
                                                                    <input class="form-control" type="file" name="sheet" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Share to Marketplace?</label>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio mt-radio-outline"> No
                                                                            <input type="radio" value="0" name="sheet_radio" checked />
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio mt-radio-outline"> Yes
                                                                            <input type="radio" value="1" name="sheet_radio" />
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row hidden">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label class="control-label">Certificate of Guarantee</label>
                                                                    <input class="form-control" type="file" name="guarantee" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Share to Marketplace?</label>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio mt-radio-outline"> No
                                                                            <input type="radio" value="0" name="guarantee_radio" checked />
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio mt-radio-outline"> Yes
                                                                            <input type="radio" value="1" name="guarantee_radio" />
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row hidden">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label class="control-label">Certificate of Conformance</label>
                                                                    <input class="form-control" type="file" name="conformance" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Share to Marketplace?</label>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio mt-radio-outline"> No
                                                                            <input type="radio" value="0" name="conformance_radio" checked />
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio mt-radio-outline"> Yes
                                                                            <input type="radio" value="1" name="conformance_radio" />
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row hidden">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label class="control-label">Product Liability Insurance</label>
                                                                    <input class="form-control" type="file" name="insurance" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Share to Marketplace?</label>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio mt-radio-outline"> No
                                                                            <input type="radio" value="0" name="insurance_radio" checked />
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio mt-radio-outline"> Yes
                                                                            <input type="radio" value="1" name="insurance_radio" />
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabLabs">
                                                        <a href="#modalNewLab" data-toggle="modal" class="btn green" onclick="btnNew_Lab(1)">Add New Lab</a>
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
                
                fetchProducts();
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

            function btnView(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Products="+id,
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
                                            <img src="${d.image}" style="width: 40px; height: 40px; object-fit: cover; object-position: center; border-radius:50% !important;" />
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
                                            <a href="#modalView" data-toggle="modal" data-id="${d.id}" class="btn btn-outline dark btn-sm btnView" onclick="btnView(${d.id})">View</a>
                                            <a href="javascript:;" class="btn btn-outlinex red btn-sm btnDelete" data-id="${d.id}" onclick="btnDelete(${d.id})">Delete</a>
                                        </div>
                                    `,
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
        </script>

    </body>
</html>