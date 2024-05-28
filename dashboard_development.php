<?php 
    $title = "Dashboard";
    $site = "dashboard";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    .bootstrap-switch-container > span {
        opacity: 1 !important;
    }
    .todo-task-history {
        max-height: 400px;
        overflow: auto;
        padding: 0 15px;
    }
    .todo-task-history li {
        padding:  10px;
        list-style: none;
    }
    .todo-task-history li:nth-child(odd) {
        background: #e1e1e1;
    }
</style>

                    <?php
                        $newUser = 1;
                        $collabUser = 0;
                        if (!empty($_COOKIE['switchAccount'])) {
                            $selectDashboard = mysqli_query( $conn,"SELECT * from tbl_library WHERE deleted = 0 AND user_id = $switch_user_id" );
                            if ( mysqli_num_rows($selectDashboard) > 0 ) {
                                $newUser = 0;
                            }
                        } else {
                            if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) {
                                $newUser = 0;
                                $collabUser = 1;
                            } else {
                                $selectDashboard = mysqli_query( $conn,"SELECT * from tbl_library WHERE deleted = 0 AND user_id = $switch_user_id" );
                                if ( mysqli_num_rows($selectDashboard) > 0 ) {
                                    $newUser = 0;
                                }
                            }
                        }
                    ?>

                    <div class="row <?php echo $newUser == 1 ? '':'hide'; ?>">
                        <?php
                                $get_category=mysqli_query($conn,"SELECT * FROM tbl_dashboard_cards ORDER BY sort_by");
                                while ($row=mysqli_fetch_array($get_category)) {
                            ?>
                            <?php
                                $category_name = $row['category_name'];
                                $get_videos = mysqli_query($conn,"SELECT youtube_link FROM tbl_pages_demo_video WHERE page = '$category_name'");
                                $get_videos_result = mysqli_fetch_array($get_videos);
                                if($get_videos_result):
                                    foreach($get_videos_result as $video_rows):
                            ?>
                                <div class="col-md-2">
                                    <a data-toggle="modal" data-src="<?= $video_rows ?>" data-fancybox >
                                        <img src="/uploads/bgBlue.png" class="img-thumbnail" style="width: 100%;"/>
                                        <div class="cover" style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; padding: 15px 30px; display: flex;">
                                            <h3 class="font-white" style="margin: auto; font-weight: bold; font-size: clamp(18px, 1.5vw, 22px); text-align: center;">  <?= $row['category_name'] ?></h3>
                                        </div>
                                    </a>
                                </div>
                            <?php break; endforeach; else: ?>
                                <div class="col-md-2">
                                    <a data-toggle="modal" data-target="#modalService" >
                                        <img src="/uploads/bgBlue.png" class="img-thumbnail" style="width: 100%;"/>
                                        <div class="cover" style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; padding: 15px 30px; display: flex;">
                                            <h3 class="font-white" style="margin: auto; font-weight: bold; font-size: clamp(18px, 1.5vw, 22px); text-align: center;"> <?= $row['category_name'] ?></h3>
                                        </div>
                                    </a>
                                </div>
                            <?php endif;  
                                }
                            ?>
                    </div>

                    <div class="row <?php echo $newUser == 0 ? '':'hide'; ?>">
                        <div class="col-md-3" style="margin-top: 5px;">
                            <div class="input-group">
                                <input class="form-control" id="deliverable_search" type="text" placeholder="Search" />
                                <?php if ($current_userID == 1 OR $current_userID == 2 OR $current_userID == 19 OR $current_userID == 163) { ?>
                                    <div class="input-group-btn">
                                        <button type="button" class="btn green dropdown-toggle" data-toggle="dropdown">Action
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a href="#modalArea" data-toggle="modal"> Add New </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;"> Another action </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;"> Something else here </a>
                                            </li>
                                            <li class="divider"> </li>
                                            <li>
                                                <a href="javascript:;"> Separated link </a>
                                            </li>
                                        </ul>
                                    </div>
                                <?php } ?>
                            </div>
                            <div id="jstreeContainer">
                                <div id="jstreeAjax"></div>
                                <div id="jstree_HTML"></div>
                                <div class="hide" id="jstree_PHP">
                                    <ul>
                                        <?php
                                            // function tree_item($parent_id) {
                                            //     global $conn;
                                            //     $output = '';

                                            //     $resultTreeItem = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE deleted = 0 AND parent_id = $parent_id" );
                                            //     if ( mysqli_num_rows($resultTreeItem) > 0 ) {
                                            //         $output .= '<ul>';
                                            //             while($rowTreeItem = mysqli_fetch_array($resultTreeItem)) {
                                            //                 $item_ID = $rowTreeItem["ID"];
                                            //                 $item_name = $rowTreeItem["name"];
                                            //                 $item_parent_id = $rowTreeItem["parent_id"];
                                            //                 $item_child_id = $rowTreeItem["child_id"];

                                            //                 $item_child = false;
                                            //                 if (!empty($rowTreeItem["child_id"])) { $item_child = true; }

                                            //                 $output .= '<li>'.$item_ID .' '. $item_name;

                                            //                     if (!empty($item_child_id)) {
                                            //                         $output .= tree_item($item_ID);
                                            //                     }

                                            //                 $output .= '</li>';
                                            //             }
                                            //         $output .= '</ul>';
                                            //     }

                                            //     return $output;
                                            // }

                                            // $resultTree = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE parent_id = 0 AND deleted = 0 AND user_id = $current_userEmployerID" );
                                            // if ($collabUser == 1 AND !isset($_COOKIE['switchAccount'])) { $resultTree = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE deleted = 0 AND collaborator_id <> ''" ); }
                                        
                                            // if ( mysqli_num_rows($resultTree) > 0 ) {
                                            //     while($rowTree = mysqli_fetch_array($resultTree)) {
                                            //         $library_ID = $rowTree["ID"];
                                            //         $library_name = $rowTree["name"];
                                            //         $library_collaborator_id = $rowTree["collaborator_id"];

                                            //         $library_child = false;
                                            //         if (!empty($rowTree["child_id"])) { $library_child = true; }

                                            //         $array_name_id = explode(", ", $library_name);
                                            //         if ( count($array_name_id) == 4 ) {
                                            //             $data_name = array();

                                            //             $selectType = mysqli_query($conn,"SELECT * FROM tbl_library_type WHERE ID = '".$array_name_id[0]."'");
                                            //             if ( mysqli_num_rows($selectType) > 0 ) {
                                            //                 while($rowType = mysqli_fetch_array($selectType)) {
                                            //                     array_push($data_name, $rowType["name"]);
                                            //                 }
                                            //             }

                                            //             $selectCategory = mysqli_query($conn,"SELECT * FROM tbl_library_category WHERE ID = '".$array_name_id[1]."'");
                                            //             if ( mysqli_num_rows($selectCategory) > 0 ) {
                                            //                 while($rowCategory = mysqli_fetch_array($selectCategory)) {
                                            //                     array_push($data_name, $rowCategory["name"]);
                                            //                 }
                                            //             }

                                            //             $selectScope = mysqli_query($conn,"SELECT * FROM tbl_library_scope WHERE ID = '".$array_name_id[2]."'");
                                            //             if ( mysqli_num_rows($selectScope) > 0 ) {
                                            //                 while($rowScope = mysqli_fetch_array($selectScope)) {
                                            //                     array_push($data_name, $rowScope["name"]);
                                            //                 }
                                            //             }

                                            //             $selectModule = mysqli_query($conn,"SELECT * FROM tbl_library_module WHERE ID = '".$array_name_id[3]."'");
                                            //             if ( mysqli_num_rows($selectModule) > 0 ) {
                                            //                 while($rowModule = mysqli_fetch_array($selectModule)) {
                                            //                     array_push($data_name, $rowModule["name"]);
                                            //                 }
                                            //             }

                                            //             $library_name = implode(" - ",$data_name);
                                            //         }

                                            //         echo '<li>'.$library_name;

                                            //             if ($library_child == true) {
                                            //                 echo tree_item($library_ID);
                                            //             }

                                            //         echo '</li>';
                                            //     }
                                            // }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <button id="btnTree" type="button" class="btn btn-sm btn-primary hide" style="margin-top:10px;">View All</button>
                        </div>
                        <div class="col-md-9" id="dashboardData" style="min-height: 300px;">
                            <div class="panel-group accordion" id="parent"></div>
                        </div>
                    </div>

                    <!-- Item Section -->
                    <div class="modal fade" id="modalArea" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalArea">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">New Item in Dashboard</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Business Type</label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="type" onchange="changedType(this.value)">
                                                    <option value="">Select</option>
                                                    <?php
                                                        $resultType = mysqli_query( $conn,"SELECT * FROM tbl_library_type WHERE ID<>16 ORDER BY name" );
                                                        if ( mysqli_num_rows($resultType) > 0 ) {
                                                            while($rowType = mysqli_fetch_array($resultType)) {
                                                                $type_ID = $rowType["ID"];
                                                                $type_name = $rowType["name"];

                                                                echo '<option value="'.$type_ID.'">'.$type_name.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    <option value="16">Others</option>
                                                </select>
                                                <input type="text" class="form-control hide type_others" name="type_others" placeholder="Leave Blank or Enter Specific Business Type" style="margin-top: 15px;" />
                                                <span class="help-block" style="margin: 0;">Services / Product</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Category</label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="category" onchange="changedCategory(this.value)">
                                                    <option value="">Select</option>
                                                    <?php
                                                        $resultCategory = mysqli_query( $conn,"SELECT * FROM tbl_library_category WHERE ID<>9 ORDER BY name" );
                                                        if ( mysqli_num_rows($resultCategory) > 0 ) {
                                                            while($rowCategory = mysqli_fetch_array($resultCategory)) {
                                                                $category_ID = $rowCategory["ID"];
                                                                $category_name = $rowCategory["name"];

                                                                echo '<option value="'.$category_ID.'">'.$category_name.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    <option value="9">Others</option>
                                                </select>
                                                <input type="text" class="form-control hide category_others" name="category_others" placeholder="Leave Blank or Enter Category Name" style="margin-top: 15px;" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Scope</label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="scope" onchange="changedScope(this.value)">
                                                    <option value="">Select</option>
                                                    <?php
                                                        $resultScope = mysqli_query( $conn,"SELECT * FROM tbl_library_scope WHERE ID<>5 ORDER BY name" );
                                                        if ( mysqli_num_rows($resultScope) > 0 ) {
                                                            while($rowScope = mysqli_fetch_array($resultScope)) {
                                                                $scope_ID = $rowScope["ID"];
                                                                $scope_name = $rowScope["name"];

                                                                echo '<option value="'.$scope_ID.'">'.$scope_name.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    <option value="5">Others</option>
                                                </select>
                                                <input type="text" class="form-control hide scope_others" name="scope_others" placeholder="Leave Blank or Enter Scope Name" style="margin-top: 15px;" />
                                                <span class="help-block" style="margin: 0;">Certification / Accreditation / Regulatory</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Module / Section</label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="module" onchange="changedModule(this.value)">
                                                    <option value="">Select</option>
                                                    <?php
                                                        $resultModule = mysqli_query( $conn,"SELECT * FROM tbl_library_module WHERE ID<>13 ORDER BY name" );
                                                        if ( mysqli_num_rows($resultModule) > 0 ) {
                                                            while($rowModule = mysqli_fetch_array($resultModule)) {
                                                                $module_ID = $rowModule["ID"];
                                                                $module_name = $rowModule["name"];

                                                                echo '<option value="'.$module_ID.'">'.$module_name.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    <option value="13">Others</option>
                                                </select>
                                                <input type="text" class="form-control hide module_others" name="module_others" placeholder="Leave Blank or Enter Module / Section Name" style="margin-top: 15px;" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Description</label>
                                            <div class="col-md-8">
                                                <textarea class="form-control" name="description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Area" id="btnSave_Area" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Item in Dashboard</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Area" id="btnUpdate_Area" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalSubItem" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modalSubItem">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">New Sub-item in Dashboard</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_SubItem" id="btnSave_SubItem" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalEdit_SubItem" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modalEdit_SubItem">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Item in Dashboard</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Area_SubItem" id="btnUpdate_Area_SubItem" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- File Section -->
                    <div class="modal fade" id="modalAttached" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalAttached">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add Files</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Attached" id="btnSave_Attached" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalAttachedEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalAttachedEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Files</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Attached" id="btnUpdate_Attached" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Comment Section -->
                    <div class="modal fade" id="modalComment" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modalComment">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add Comment</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Comment" id="btnSave_Comment" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Compliance Section -->
                    <div class="modal fade" id="modalCompliance" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalCompliance">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add Compliance Instruction</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Compliance" id="btnSave_Compliance" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalComplianceEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalComplianceEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Compliance Instruction</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Compliance" id="btnUpdate_Compliance" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalComplianceMore" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalComplianceMore">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Action Compliance</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSaveMore_Compliance" id="btnSaveMore_Compliance" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalComplianceMoreEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalComplianceMoreEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Action Compliance</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdateMore_Compliance" id="btnUpdateMore_Compliance" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Annual Review Section -->
                    <div class="modal fade" id="modalReview" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalReview">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add New Review</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Review" id="btnSave_Review" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalReviewEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalReviewEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Review</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Review" id="btnUpdate_Review" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalReviewAction" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalReviewAction">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Action Review</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSaveAction_Review" id="btnSaveAction_Review" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalReviewActionEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalReviewActionEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Action Review</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdateAction_Review" id="btnUpdateAction_Review" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalReviewMore" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalReviewMore">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Action Review</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSaveMore_Review" id="btnSaveMore_Review" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalReviewMoreEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalReviewMoreEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Action Review</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdateMore_Review" id="btnUpdateMore_Review" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Template Section -->
                    <div class="modal fade" id="modalTemplate" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalTemplate">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add New Template</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Template" id="btnSave_Template" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalTemplateEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalTemplateEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Template</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Template" id="btnUpdate_Template" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- References Section -->
                    <div class="modal fade" id="modalRef" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalRef">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add New Reference</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Ref" id="btnSave_Ref" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalRefEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalRefEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Reference</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Ref" id="btnUpdate_Ref" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Video Section -->
                    <div class="modal fade" id="modalVideo" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalVideo">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add New Video</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Video" id="btnSave_Video" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalVideoEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalVideoEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Video</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Video" id="btnUpdate_Video" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Task Section -->
                    <div class="modal fade" id="modalTask" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalTask">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add New Task</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Task" id="btnSave_Task" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalTaskEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalTaskEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Task</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Task" id="btnUpdate_Task" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Clone Section -->
                    <div class="modal fade" id="modalClone" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modalClone">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Clone</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Clone" id="btnSave_Clone" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!--Report Section-->
                    <div class="modal fade" id="modalReport" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modalReport">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Table Report</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="button" class="btn green ladda-button" name="btnExport" id="btnExport" data-style="zoom-out"><span class="ladda-label">Export</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalCollaborator" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modalCollaborator">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Collaborator</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Collaborator" id="btnSave_Collaborator" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!--Emjay modal starts here-->
                    
                    <div class="modal fade" id="view_page_videos" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Demo Video</h4>
                                    </div>

                                    <div class="modal-body">
                                        <video id="myVideo" width="320" height="240" controls style="width:100%;height:100%">
                                          <source src="" >
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

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
                                            <label style="margin-top:15px">Category</label>
                                            <select class="form-control" name="page" id="pages" required>
                                                <?php
                                                    $get_category=mysqli_query($conn,"SELECT * FROM tbl_dashboard_cards ");
                                                    while ($row=mysqli_fetch_array($get_category)) {
                                                ?>
                                                    <option value="<?php echo $row['category_name']; ?>"><?php echo $row['category_name']; ?></option> 
                                                <?php
                                                    }
                                                ?>
                                            </select>

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
                    
                    <!--EMjay modal ends here-->
                    
                    <!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>

        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>

        <script src="assets/pages/scripts/jquery.table2excel.js" type="text/javascript"></script>
        <script>
            $("#btnExport").click(function(){
                $("#table2excel").table2excel({
                    exclude:".noExl",           // exclude CSS class
                    name:"Worksheet Name",
                    filename:"Download",        //do not include extension
                    fileext:".xlsx",             // file extension
                    exclude_img:true,
                    exclude_links:true,
                    exclude_inputs:true
                });
            });
        </script>
        <!--Emjay codes start here-->
        <script>
            $(document).ready(function(){
                fancyBoxes();
                $('#save_video').click(function(){
                $('#save_video').attr('disabled','disabled');
                $('#save_video_text').text("Uploading...");
                var action_data = "supplier";
                var user_id = $('#switch_user_id').val();
                var privacy = $('#privacy').val();
                var file_title = $('#file_title').val();
                
                 var fd = new FormData();
                 var files = $('#file')[0].files;
                 fd.append('file',files[0]);
                 fd.append('action_data',action_data);
                 fd.append('user_id',user_id);
                 fd.append('privacy',privacy);
                 fd.append('file_title',file_title);
    			    $.ajax({
        				method:"POST",
        				url:"controller.php",
        				data:fd,
        				processData: false, 
                        contentType: false,  
                        timeout: 6000000,
        				success:function(data){
        					console.log('done : ' + data);
        					if(data == 1){
        					    window.location.reload();
        					}
        					else{
        					    $('#message').html('<span class="text-danger">Invalid Video Format</span>');
        					}
        				}
    				});
    			});
            });
            
        </script>
        <!--Emjay codes ends here-->
        <script src="assets/pages/scripts/ui-tree.min.js" type="text/javascript"></script>
        <script>
            function changedType(val) {
                if (val == 16) {
                    $('.type_others').removeClass('hide');
                } else {
                    $('.type_others').addClass('hide');
                } 
            }
            function changedCategory(val) {
                if (val == 9) {
                    $('.category_others').removeClass('hide');
                } else {
                    $('.category_others').addClass('hide');
                }
            }
            function changedScope(val) {
                if (val == 5) {
                    $('.scope_others').removeClass('hide');
                } else {
                    $('.scope_others').addClass('hide');
                }
            }
            function changedModule(val) {
                if (val == 13) {
                    $('.module_others').removeClass('hide');
                } else {
                    $('.module_others').addClass('hide');
                }
            }
            function changedFrequency(val) {
                if (val == 1) {
                    $('.frequency').addClass('hide');
                    $('.frequency-container').removeClass('hide');
                    $('.frequency-time').removeClass('hide');
                } else if (val == 2) {
                    $('.frequency').addClass('hide');
                    $('.frequency-container').removeClass('hide');
                    $('.frequency-time').removeClass('hide');
                    $('.frequency-days').removeClass('hide');
                } else if (val == 3) {
                    $('.frequency').addClass('hide');
                    $('.frequency-container').removeClass('hide');
                    $('.frequency-time').removeClass('hide');
                    $('.frequency-day').removeClass('hide');
                } else if (val == 4) {
                    $('.frequency').addClass('hide');
                    $('.frequency-container').removeClass('hide');
                    $('.frequency-time').removeClass('hide');
                    $('.frequency-day').removeClass('hide');
                    $('.frequency-month').removeClass('hide');
                } else {
                    $('.frequency').addClass('hide');
                }
            }
            function changedStatus(val, id, parent_id) {
                var checked = val.checked
                var v = checked ? 1 : 0;

                $.ajax({
                    url: 'function.php?compliant='+id+'&v='+v,
                    dataType: "html",
                    success: function(data){
                        changedCompliant(parent_id);
                    }
                });
            }
            function changedCompliant(parent_id) {
                var statusCount = $('#tabCompliance_'+parent_id+' table tbody > tr input:checkbox').length;
                var statusCompleted = $('#tabCompliance_'+parent_id+' table tbody > tr input:checkbox:checked').length;
                if (statusCount == statusCompleted) { status = 100; } else { status = 0; }
                $('#tabCompliance_'+parent_id+' tfoot tr th:first-child').html(status + "%");
            }
            function changedTemplate(val) {
                if (val == 1) {
                    $('.description_template').addClass('hide');
                } else {
                    $('.description_template').removeClass('hide');
                } 
            }
        </script>
        <script type="text/javascript">
            var current_userEmployerID = '<?php echo $current_userEmployerID; ?>';
            $(document).ready(function(){
                var collabUser = '<?php echo $collabUser; ?>';
                
                // if (current_userEmployerID == 19) {
                    // Data loaded as JSON Format (Display Once - Option 3)
                    $('#jstreeAjax').jstree({
                        'core' : {
                            'themes' : { responsive:!1 },
                            'data'   : {
                                'url' : function (node) {
                                    return node.id === '#' ? 'function.php?jstreeList='+collabUser : 'function.php?jstreeListItem='+node.id;
                                },
                                'data' : function (node) {
                                    return { 'id' : node.id };
                                },
                                'dataType': "json"
                            }
                        },
                        types:{
                            "default":{
                                icon:"fa fa-folder icon-state-warning icon-lg"
                            },
                            file:{
                                icon:"fa fa-file icon-state-warning icon-lg"
                            }
                        },
                        height: "200px",
                        search: {
                            case_insensitive: false,
                            show_only_matches : true,
                            show_only_matches_children : true
                        },
                        plugins : ["types", "search" ]
                    });
                // } else {
                //     // Data at the top as PHP Format (Display All - Option 1)
                //     // $('#jstree_PHP').jstree();
    
                //     // Data loaded as HTML UL > LI Format (Display All - Option 2)
                //     jstree_uiBlock_();
                //     $.ajax({
                //         type: 'GET',
                //         url: 'function.php?jstree_HTML='+collabUser,
                //         dataType: "html",
                //         success: function(data){
                //             $('#jstree_HTML').jstree({
                //                 'themes' : { responsive:!1 },
                //                 'core': {
                //                     'data': data,
                //                 },
                //                 'types' : {
                //                     "default" : {
                //                         "icon" : "fa fa-folder icon-state-warning"
                //                     },
                //                     "file" : {
                //                         "icon" : "fa fa-file icon-state-danger"
                //                     },
                //                     "folder" : {
                //                         "icon" : "fa fa-file icon-state-info"
                //                     }
                //                 },
                //                 search: {
                //                     case_insensitive: false,
                //                     show_only_matches : true,
                //                     show_only_matches_children : true
                //                 },
                //                 plugins : ["types", "search" ]
                //             });
                //             $('#jstree_HTML').unblock();
                //         }
                //     });
                //     fancyBoxes();
                // }
            });

            // Load data base on selected Folder
            if (current_userEmployerID == 19) { var jstree_data = 'jstreeAjax'; }
            else { var jstree_data = 'jstree_HTML'; }
            var jstree_data = 'jstreeAjax';
            $("#"+jstree_data).on("click", "li > a", function() {
                var id = $(this).closest("li").attr("id");
                var data = $(this).closest("li").attr("data-type");

                if (data == "file") {
                    var src = $(this).closest("li > a").attr("data-src");
                    var type = $(this).closest("li > a").attr("data-ftype");

                    Fancybox.show([
                        {
                            src: src,
                            type: type,
                            preload: true,
                        },
                    ]);
                } else {
                    $(this).siblings(".jstree-icon").click();

                    uiBlock();
                    $.ajax({
                        type: "GET",
                        url: "function.php?modalDashboard="+id,
                        dataType: "html",
                        success: function(data){
                            $("#parent").html(data);
                            $('#dashboardData').unblock();
                            $('#item_'+id).collapse('show');
                            $(".make-switch").bootstrapSwitch();
                            $(".tabbable-tabdrop").tabdrop();
                        }
                    });
                }
                fancyBoxes();
            });

            // Search data base on JSTree
            var to = false;
            $('#deliverable_search').keyup(function () {
                if(to) { clearTimeout(to); }
                to = setTimeout(function () {
                    var v = $('#deliverable_search').val();
                    $("#"+jstree_data).jstree(true).search(v);
                }, 250);
            });
            
            $('#btnTree').on('click', function(){
                $('#parent > .panel').removeClass('hide');
                $('#btnTree').addClass('hide');
            });
            
            function uploadNew(e) {
                $(e).parent().hide();
                $(e).parent().prev('.form-control').removeClass('hide');
            }
            function widget_tagInput() {
                var ComponentsBootstrapTagsinput=function(){
                    var t=function(){
                        var t=$(".tagsinput");
                        t.tagsinput()
                    };
                    return{
                        init:function(){t()}
                    }
                }();
                jQuery(document).ready(function(){ComponentsBootstrapTagsinput.init()});
            }
            function selectedItem(id, parent_id) {
                // $('#item_'+id).parents('.panel-collapse').collapse('show');
                // $('#item_'+id).collapse('show');

                // $('#parent > .panel').addClass('hide');
                // $('#parent > .panel_'+parent_id).removeClass('hide');
                // $('#btnTree').removeClass('hide');

                uiBlock();
                $.ajax({
                    type: "GET",
                    url: "function.php?modalDashboard="+id,
                    dataType: "html",
                    success: function(data){
                        $("#parent").html(data);
                        $('#dashboardData').unblock();
                        $('#item_'+id).collapse('show');
                        $(".make-switch").bootstrapSwitch();
                        fancyBoxes();
                    }
                });
            }
            function selectedAccordion(id) {
                var newwParent = $('#item_'+id+' > div');

                if (newwParent.length == 0) {
                    uiBlock();
                    $.ajax({
                        type: "GET",
                        url: "function.php?modalDashboardItem="+id,
                        dataType: "html",
                        success: function(data){
                            $("#item_"+id).html(data);
                            $('#dashboardData').unblock();
                            $('#item_'+id).collapse('show');
                            $(".make-switch").bootstrapSwitch();
                            fancyBoxes();
                        }
                    });
                }
            }
            function uiBlock() {
                $('#dashboardData').block({ 
                    message: '<div class="loading-message loading-message-boxed bg-white"><img src="assets/global/img/loading-spinner-grey.gif" align=""><span>&nbsp;&nbsp;LOADING...</span></div>', 
                    css: { border: '0', width: 'auto' } 
                });
            }
            function jstree_uiBlock_() {
                $('#jstree_HTML').block({
                    message: '<div class="loading-message loading-message-boxed bg-white"><img src="assets/global/img/loading-spinner-grey.gif" align=""><span>&nbsp;&nbsp;LOADING...</span></div>', 
                    css: { border: '0', width: 'auto' } 
                });
            }
            
            // Approval Section
            function btnDeleteAction(action, type, id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalDashboardAction="+action+"&t="+type+"&i="+id,
                    dataType: "html",
                    success: function(data){
                        if (action == 1) {
                            $('.panel_'+id).remove();
                        } else {
                            $('.panel_'+id+' .itemWarning').remove();
                        }
                        
                    }
                });
            }
            <?php if (!empty($_GET['d'])) { ?>
                var req_id = '<?php echo $_GET['d']; ?>';
                uiBlock();
                $.ajax({
                    type: "GET",
                    url: "function.php?modalDashboard="+req_id,
                    dataType: "html",
                    success: function(data){
                        $("#parent").html(data);
                        $('#dashboardData').unblock();
                        $('#item_'+req_id).collapse('show');
                        $(".make-switch").bootstrapSwitch();
                        $(".tabbable-tabdrop").tabdrop();
                    }
                });
            <?php } ?>
            
            // Item Section
            $(".modalArea").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Area',true);

                var l = Ladda.create(document.querySelector('#btnSave_Area'));
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
                            var html = '<div class="panel panel-default panel_'+obj.ID+'">';
                                html += '<div class="panel-heading">';
                                    html += '<div class="row">';
                                        html += '<div class="col-md-10">';
                                            html += '<h4 class="panel-title bold"><a class="accordion-toggle font-dark" data-toggle="collapse" data-parent="#parent" href="#item_'+obj.ID+'">'+obj.name+'</a></h4>';
                                            html += '<ul class="list-inline muted h6">';
                                                html += '<li><a href="#modalReport" class="btnReport font-dark" data-toggle="modal" onclick="btnReport('+obj.ID+')"><i class="fa fa-table"></i> Report</a></li>';
                                                html += '<li><a href="#modalCollaborator" class="btnCollaborator font-dark" data-toggle="modal" onclick="btnCollaborator('+obj.ID+')"><i class="fa fa-cogs"></i> Collaborator</a></li>';
                                            html += '</ul>';
                                        html += '</div>';
                                        html += '<div class="col-md-2">';
                                            html += '<div class="actions pull-right">';
                                                html += '<div class="btn-group">';
                                                    html += '<a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Select Action <i class="fa fa-angle-down"></i></a>';
                                                    html += '<ul class="dropdown-menu pull-right">';
                                                        html += '<li><a href="#modalEdit" class="btnEdit" data-toggle="modal" onclick="btnEdit('+obj.ID+')">Edit</a></li>';
                                                        html += '<li><a href="javascript:;" class="btnDelete" onclick="btnDelete('+obj.ID+')">Delete</a></li>';
                                                        html += '<li><a href="#modalReport" class="btnReport" data-toggle="modal" onclick="btnReport('+obj.ID+')">Report</a></li>';

                                                        html += '<li class="divider"> </li>';

                                                        html += '<li><a href="#modalAttached" class="btnAttached" data-toggle="modal" onclick="btnAttached('+obj.ID+')">Attach File</a></li>';
                                                        html += '<li><a href="#modalCompliance" class="btnCompliance" data-toggle="modal" onclick="btnCompliance('+obj.ID+')">Add Compliance</a></li>';
                                                        html += '<li><a href="#modalComment" class="btnComment" data-toggle="modal" onclick="btnComment('+obj.ID+')">Add Comments</a></li>';

                                                        html += '<li class="divider"> </li>';
                                                        
                                                        html += '<li><a href="#modalSubItem" class="btnSubItem" data-type="1" data-toggle="modal" onclick="btnSubItem('+obj.ID+', 1)">Add Programs</a></li>';
                                                        html += '<li><a href="#modalSubItem" class="btnSubItem" data-type="2" data-toggle="modal" onclick="btnSubItem('+obj.ID+', 2)">Add Policy</a></li>';
                                                        html += '<li><a href="#modalSubItem" class="btnSubItem" data-type="3" data-toggle="modal" onclick="btnSubItem('+obj.ID+', 3)">Add Procedure</a></li>';
                                                        html += '<li><a href="#modalSubItem" class="btnSubItem" data-type="5" data-toggle="modal" onclick="btnSubItem('+obj.ID+', 5)">Add Form</a></li>';
                                                        html += '<li><a href="#modalSubItem" class="btnSubItem" data-type="4" data-toggle="modal" onclick="btnSubItem('+obj.ID+', 4)">Add Training</a></li>';
                                                    html += '</ul>';
                                                html += '</div>';
                                            html += '</div>';
                                        html += '</div>';
                                    html += '</div>';
                                html += '</div>';
                                html += '<div id="item_'+obj.ID+'" class="panel-collapse collapse">';
                                    html += '<div class="panel-body">';
                                        html += '<div class="row">';
                                            html += '<div class="tabbable-line tabbable tabbable-tabdrop">';
                                                html += '<ul class="nav nav-tabs">';
                                                    html += '<li class="active"><a href="#tabDescription_'+obj.ID+'" data-toggle="tab" aria-expanded="true">Description</a></li>';
                                                    html += '<li class=""><a href="#tabFiles_'+obj.ID+'" data-toggle="tab" aria-expanded="true">Files</a></li>';
                                                    html += '<li class=""><a href="#tabComments_'+obj.ID+'" data-toggle="tab" aria-expanded="false">Comments</a></li>';
                                                    html += '<li class="hide"><a href="#tabHistory_'+obj.ID+'" data-toggle="tab" aria-expanded="false">History</a></li>';
                                                    html += '<li class=""><a href="#tabCompliance_'+obj.ID+'" data-toggle="tab" aria-expanded="false">Compliance</a></li>';
                                                    html += '<li class=""><a href="#tabReview_'+obj.ID+'" data-toggle="tab" aria-expanded="false">Annual Review</a></li>';
                                                    html += '<li class=""><a href="#tabTemplate_'+obj.ID+'" data-toggle="tab" aria-expanded="false">Templates</a></li>';
                                                    html += '<li class=""><a href="#tabReferences_'+obj.ID+'" data-toggle="tab" aria-expanded="false">References</a></li>';
                                                    html += '<li class=""><a href="#tabVideo_'+obj.ID+'" data-toggle="tab" aria-expanded="false">Video</a></li>';
                                                    html += '<li class=""><a href="#tabTask_'+obj.ID+'" data-toggle="tab" aria-expanded="false">Task</a></li>';
                                                html += '</ul>';
                                                html += '<div class="tab-content">';
                                                    html += '<div class="tab-pane active" id="tabDescription_'+obj.ID+'">';
                                                        html += '<h5 style="padding: 0 15px;">'+obj.description+'</h5>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabFiles_'+obj.ID+'">';
                                                        html += '<div class="mt-actions"></div>';
                                                        html += '<a href="#modalAttached" class="btn btn-circle btn-success btnAttached" data-toggle="modal" onclick="btnAttached('+obj.ID+')" style="margin: 15px;">Attach File</a>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabComments_'+obj.ID+'">';
                                                        html += '<div class="mt-actions"></div>';
                                                        html += '<a href="#modalComment" class="btn btn-circle btn-success btnComment" data-toggle="modal" onclick="btnComment('+obj.ID+')" style="margin: 15px;">Add Comment</a>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabHistory_'+obj.ID+'">';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabCompliance_'+obj.ID+'" style="padding: 0 15px;">';
                                                        html += '<div class="table-scrollable">';
                                                            html += '<table class="table table-bordered table-hover">';
                                                                html += '<thead>';
                                                                    html += '<tr>';
                                                                        html += '<th class="text-center" style="width: 130px;">Completed</th>';
                                                                        html += '<th>Requirements</th>';
                                                                        html += '<th>Action Items</th>';
                                                                        html += '<th style="width: 300px;">Frequency</th>';
                                                                        html += '<th class="text-center" style="width: 130px;">Uploaded Files</th>';
                                                                        html += '<th style="width: 175px;"></th>';
                                                                    html += '</tr>';
                                                                html += '</thead>';
                                                                html += '<tbody></tbody>';
                                                                html += '<tfoot>';
                                                                    html += '<tr>';
                                                                        html += '<th class="text-center">0%</th>';
                                                                        html += '<th colspan="5">Compliant</th>';
                                                                    html += '</tr>';
                                                                html += '</tfoot>';
                                                            html += '</table>';
                                                        html += '</div>';
                                                        html += '<a href="#modalCompliance" class="btn btn-circle btn-success btnCompliance" data-toggle="modal" onclick="btnCompliance('+obj.ID+')" style="margin: 15px 0;">Add Compliance</a>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabReview_'+obj.ID+'" style="padding: 0 15px;">';
                                                        html += '<div class="table-scrollable">';
                                                            html += '<table class="table table-bordered table-hover">';
                                                                html += '<thead>';
                                                                    html += '<tr>';
                                                                        html += '<th style="width: 130px;" class="text-center">Compliant</th>';
                                                                        html += '<th>Observation Action</th>';
                                                                        html += '<th>Performed By</th>';
                                                                        html += '<th style="width: 130px;" class="text-center">Date</th>';
                                                                        html += '<th style="width: 175px;"></th>';
                                                                    html += '</tr>';
                                                                html += '</thead>';
                                                                html += '<tbody></tbody>';
                                                            html += '</table>';
                                                        html += '</div>';
                                                        html += '<a href="#modalReview" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnReview('+obj.ID+')" style="margin: 15px 0;">Add Review</a>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabTemplate_'+obj.ID+'">';
                                                        html += '<div class="mt-actions"></div>';
                                                        html += '<a href="#modalTemplate" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnTemplate('+obj.ID+')" style="margin: 15px;">Add Templates</a>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabReferences_'+obj.ID+'">';
                                                        html += '<div class="mt-actions"></div>';
                                                        html += '<a href="#modalRef" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnRef('+obj.ID+')" style="margin: 15px;">Add References</a>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabVideo_'+obj.ID+'">';
                                                        html += '<div class="mt-actions"></div>';
                                                        html += '<a href="#modalVideo" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnVideo('+obj.ID+')" style="margin: 15px;">Add Video</a>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabTask_'+obj.ID+'">';
                                                        html += '<div class="mt-actions"></div>';
                                                        html += '<a href="#modalTask" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnTask('+obj.ID+')" style="margin: 15px;">Add Task</a>';
                                                    html += '</div>';
                                                html += '</div>';
                                            html += '</div>';
                                        html += '</div>';
                                        html += '<div class="panel-group accordion" id="parent'+obj.ID+'"></div>';
                                    html += '</div>';
                                html += '</div>';
                            html += '</div>';

                            $('#parent').append(html);
                            $('#modalArea').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalEdit_Area="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalEdit .modal-body").html(data);
                    }
                });
            }
            $(".modalEdit").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Area',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Area'));
                l.start();
                
                $.ajax({
                    url:'function.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {

                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            $('.panel_'+obj.ID+' > .panel-heading h4 a').html(obj.name);
                            $('.panel_'+obj.ID+' .panel-body > .row #tabDescription_'+obj.ID+' h5').html(obj.description);
                            $('#modalEdit').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            });
            function btnSubItem(id, type) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalSubItem_Area="+id+"&type="+type,
                    dataType: "html",
                    success: function(data){
                        $("#modalSubItem .modal-body").html(data);
                    }
                });
            }
            $(".modalSubItem").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_SubItem',true);

                var l = Ladda.create(document.querySelector('#btnSave_SubItem'));
                l.start();

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
                            if (obj.type == 1) {
                                panelBG = "bg-blue-chambray bg-font-blue-chambray"; //Program
                            } else if (obj.type == 2) {
                                panelBG = "bg-blue-dark bg-font-blue-dark"; //Policy
                            } else if (obj.type == 3) {
                                panelBG = "bg-blue-soft bg-font-blue-soft"; //Procedure
                            } else if (obj.type == 4) {
                                panelBG = "bg-blue-sharp bg-font-blue-sharp"; //Training
                            } else if (obj.type == 5) {
                                panelBG = "bg-green-jungle bg-font-green-jungle"; //Form
                            }

                            var html = '<div class="panel panel-default panel_'+obj.item_id+'">';
                                html += '<div class="panel-heading '+panelBG+'">';
                                    html += '<div class="row">';
                                        html += '<div class="col-md-10">';
                                            html += '<h4 class="panel-title bold"><a class="accordion-toggle font-white" data-toggle="collapse" data-parent="#parent'+obj.parent_id+'" href="#item_'+obj.item_id+'">'+obj.name+'</a></h4>';
                                            html += '<ul class="list-inline muted h6">';
                                                html += '<li><a href="#modalReport" class="btnReport font-white" data-toggle="modal" onclick="btnReport('+obj.ID+')"><i class="fa fa-table"></i> Report</a></li>';
                                                html += '<li><a href="#modalCollaborator" class="btnCollaborator font-white" data-toggle="modal" onclick="btnCollaborator('+obj.ID+')"><i class="fa fa-cogs"></i> Collaborator</a></li>';
                                            html += '</ul>';
                                        html += '</div>';
                                        html += '<div class="col-md-2">';
                                            html += '<div class="actions pull-right">';
                                                html += '<div class="btn-group">';
                                                    html += '<a class="btn white btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Select Action <i class="fa fa-angle-down"></i></a>';
                                                    html += '<ul class="dropdown-menu pull-right">';
                                                        html += '<li><a href="#modalEdit_SubItem" class="btnEdit_SubItem" data-toggle="modal" onclick="btnEdit_SubItem('+obj.item_id+')">Edit</a></li>';
                                                        html += '<li><a href="javascript:;" class="btnDelete" onclick="btnDelete('+obj.item_id+')">Delete</a></li>';
                                                        html += '<li><a href="#modalReport" class="btnReport" data-toggle="modal" onclick="btnReport('+obj.item_id+')">Report</a></li>';

                                                        html += '<li class="divider"> </li>';

                                                        html += '<li><a href="#modalAttached" class="btnAttached" data-toggle="modal" onclick="btnAttached('+obj.item_id+')">Attach File</a></li>';
                                                        html += '<li><a href="#modalCompliance" class="btnCompliance" data-toggle="modal" onclick="btnCompliance('+obj.item_id+')">Add Compliance</a></li>';
                                                        html += '<li><a href="#modalComment" class="btnComment" data-toggle="modal" onclick="btnComment('+obj.item_id+')">Add Comments</a></li>';

                                                        html += '<li class="divider"> </li>';
                                                        
                                                        html += '<li><a href="#modalSubItem" class="btnSubItem" data-type="1" data-toggle="modal" onclick="btnSubItem('+obj.item_id+', 1)">Add Programs</a></li>';
                                                        html += '<li><a href="#modalSubItem" class="btnSubItem" data-type="2" data-toggle="modal" onclick="btnSubItem('+obj.item_id+', 2)">Add Policy</a></li>';
                                                        html += '<li><a href="#modalSubItem" class="btnSubItem" data-type="3" data-toggle="modal" onclick="btnSubItem('+obj.item_id+', 3)">Add Procedure</a></li>';
                                                        html += '<li><a href="#modalSubItem" class="btnSubItem" data-type="5" data-toggle="modal" onclick="btnSubItem('+obj.item_id+', 5)">Add Form</a></li>';
                                                        html += '<li><a href="#modalSubItem" class="btnSubItem" data-type="4" data-toggle="modal" onclick="btnSubItem('+obj.item_id+', 4)">Add Training</a></li>';
                                                    html += '</ul>';
                                                html += '</div>';
                                            html += '</div>';
                                        html += '</div>';
                                    html += '</div>';
                                html += '</div>';
                                html += '<div id="item_'+obj.item_id+'" class="panel-collapse collapse">';
                                    html += '<div class="panel-body">';
                                        html += '<div class="row">';
                                            html += '<div class="tabbable-line tabbable tabbable-tabdrop">';
                                                html += '<ul class="nav nav-tabs">';
                                                    html += '<li class="active"><a href="#tabDescription_'+obj.item_id+'" data-toggle="tab" aria-expanded="true">Description</a></li>';
                                                    html += '<li class=""><a href="#tabFiles_'+obj.item_id+'" data-toggle="tab" aria-expanded="true">Files</a></li>';
                                                    html += '<li class=""><a href="#tabComments_'+obj.item_id+'" data-toggle="tab" aria-expanded="false">Comments</a></li>';
                                                    html += '<li class="hide"><a href="#tabHistory_'+obj.item_id+'" data-toggle="tab" aria-expanded="false">History</a></li>';
                                                    html += '<li class=""><a href="#tabCompliance_'+obj.item_id+'" data-toggle="tab" aria-expanded="false">Compliance</a></li>';
                                                    html += '<li class=""><a href="#tabReview_'+obj.item_id+'" data-toggle="tab" aria-expanded="false">Annual Review</a></li>';
                                                    html += '<li class=""><a href="#tabTemplate_'+obj.item_id+'" data-toggle="tab" aria-expanded="false">Templates</a></li>';
                                                    html += '<li class=""><a href="#tabReferences_'+obj.item_id+'" data-toggle="tab" aria-expanded="false">References</a></li>';
                                                    html += '<li class=""><a href="#tabVideo_'+obj.ID+'" data-toggle="tab" aria-expanded="false">Video</a></li>';
                                                    html += '<li class=""><a href="#tabTask_'+obj.ID+'" data-toggle="tab" aria-expanded="false">Task</a></li>';
                                                html += '</ul>';
                                                html += '<div class="tab-content">';
                                                    html += '<div class="tab-pane active" id="tabDescription_'+obj.item_id+'">';
                                                        html += '<h5 style="padding: 0 15px;">'+obj.description+'</h5>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabFiles_'+obj.item_id+'">';
                                                        html += '<div class="mt-actions"></div>';
                                                        html += '<a href="#modalAttached" class="btn btn-circle btn-success btnAttached" data-toggle="modal" onclick="btnAttached('+obj.item_id+')" style="margin: 15px;">Attach File</a>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabComments_'+obj.item_id+'">';
                                                        html += '<div class="mt-actions"></div>';
                                                        html += '<a href="#modalComment" class="btn btn-circle btn-success btnComment" data-toggle="modal" onclick="btnComment('+obj.item_id+')" style="margin: 15px;">Add Comment</a>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane hide" id="tabHistory_'+obj.item_id+'">';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabCompliance_'+obj.item_id+'" style="padding: 0 15px;">';
                                                        html += '<div class="table-scrollable">';
                                                            html += '<table class="table table-bordered table-hover">';
                                                                html += '<thead>';
                                                                    html += '<tr>';
                                                                        html += '<th class="text-center" style="width: 130px;">Completed</th>';
                                                                        html += '<th>Requirements</th>';
                                                                        html += '<th>Action Items</th>';
                                                                        html += '<th style="width: 300px;">Frequency</th>';
                                                                        html += '<th class="text-center" style="width: 130px;">Uploaded Files</th>';
                                                                        html += '<th style="width: 175px;"></th>';
                                                                    html += '</tr>';
                                                                html += '</thead>';
                                                                html += '<tbody></tbody>';
                                                                html += '<tfoot>';
                                                                    html += '<tr>';
                                                                        html += '<th class="text-center">0%</th>';
                                                                        html += '<th colspan="5">Compliant</th>';
                                                                    html += '</tr>';
                                                                html += '</tfoot>';
                                                            html += '</table>';
                                                        html += '</div>';
                                                        html += '<a href="#modalCompliance" class="btn btn-circle btn-success btnCompliance" data-toggle="modal" onclick="btnCompliance('+obj.item_id+')" style="margin: 15px 0;">Add Compliance</a>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabReview_'+obj.item_id+'" style="padding: 0 15px;">';
                                                        html += '<div class="table-scrollable">';
                                                            html += '<table class="table table-bordered table-hover">';
                                                                html += '<thead>';
                                                                    html += '<tr>';
                                                                        html += '<th style="width: 130px;" class="text-center">Compliant</th>';
                                                                        html += '<th>Observation Action</th>';
                                                                        html += '<th>Performed By</th>';
                                                                        html += '<th style="width: 130px;" class="text-center">Date</th>';
                                                                        html += '<th style="width: 175px;"></th>';
                                                                    html += '</tr>';
                                                                html += '</thead>';
                                                                html += '<tbody></tbody>';
                                                            html += '</table>';
                                                        html += '</div>';
                                                        html += '<a href="#modalReview" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnReview('+obj.item_id+')" style="margin: 15px 0;">Add Review</a>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabTemplate_'+obj.item_id+'">';
                                                        html += '<div class="mt-actions"></div>';
                                                        html += '<a href="#modalTemplate" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnTemplate('+obj.item_id+')" style="margin: 15px;">Add Templates</a>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabReferences_'+obj.item_id+'">';
                                                        html += '<div class="mt-actions"></div>';
                                                        html += '<a href="#modalRef" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnRef('+obj.item_id+')" style="margin: 15px;">Add References</a>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabVideo_'+obj.ID+'">';
                                                        html += '<div class="mt-actions"></div>';
                                                        html += '<a href="#modalVideo" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnVideo('+obj.ID+')" style="margin: 15px;">Add Video</a>';
                                                    html += '</div>';
                                                    html += '<div class="tab-pane" id="tabTask_'+obj.ID+'">';
                                                        html += '<div class="mt-actions"></div>';
                                                        html += '<a href="#modalTask" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnTask('+obj.ID+')" style="margin: 15px;">Add Task</a>';
                                                    html += '</div>';
                                                html += '</div>';
                                            html += '</div>';
                                        html += '</div>';
                                        html += '<div class="panel-group accordion" id="parent'+obj.ID+'"></div>';
                                    html += '</div>';
                                html += '</div>';
                            html += '</div>';

                            $('.panel_'+obj.parent_id+' .panel-body > #parent'+obj.parent_id).append(html);
                            $('#modalSubItem').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            });
            function btnEdit_SubItem(id) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalEdit_SubItem="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalEdit_SubItem .modal-body").html(data);
                    }
                });
            }
            $(".modalEdit_SubItem").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Area_SubItem',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Area_SubItem'));
                l.start();

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
                            if (obj.type == 1) {
                                panelBG = "bg-blue-chambray bg-font-blue-chambray"; //Program
                            } else if (obj.type == 2) {
                                panelBG = "bg-blue-dark bg-font-blue-dark"; //Policy
                            } else if (obj.type == 3) {
                                panelBG = "bg-blue-soft bg-font-blue-soft"; //Procedure
                            } else if (obj.type == 4) {
                                panelBG = "bg-blue-sharp bg-font-blue-sharp"; //Training
                            } else if (obj.type == 5) {
                                panelBG = "bg-green-jungle bg-font-green-jungle"; //Form
                            }

                            $('.panel_'+obj.ID+' > div:first-child').attr( "class", "panel-heading "+panelBG );
                            $('.panel_'+obj.ID+' > .panel-heading h4 a').html(obj.name);
                            $('.panel_'+obj.ID+' .panel-body > .row #tabDescription_'+obj.ID+' h5').html(obj.description);
                            $('#modalEdit_SubItem').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            });
            function btnDelete(id) {
                swal({
                    title: "Are you sure?",
                    text: "Write some reason on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Reason"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_Area="+id+"&reason="+inputValue,
                        dataType: "html",
                        success: function(response){
                            $('.panel_'+id+' > .panel-heading h4 a').append('<i class="fa fa-warning font-red" style="margin-left: 5px;"></i>');
                        }
                    });
                    swal("Notification Sent!", "You wrote: " + inputValue, "success");
                });
            }

            // File Section
            function btnAttached(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalAttached="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalAttached .modal-body").html(data);
                    }
                });
            }
            $(".modalAttached").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Attached',true);

                var l = Ladda.create(document.querySelector('#btnSave_Attached'));
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
                            var result = '<div class="mt-action mt-action-'+obj.ID+'">';
                                result += '<div class="mt-action-body">';
                                    result += '<div class="mt-action-row">';
                                        result += '<div class="mt-action-info">';
                                            result += '<div class="mt-action-icon">'+obj.files+'</div>';
                                            result += '<div class="mt-action-details" style="vertical-align: middle;">';
                                                result += '<span class="mt-action-author">'+obj.name+'</span>';
                                                result += '<p class="mt-action-desc">';
                                                    result += '<span class="font-dark">'+obj.comment+'</span><br>';
                                                    result += 'Uploaded by: '+obj.user;
                                                result += '</p>';
                                            result += '</div>';
                                        result += '</div>';
                                        result += '<div class="mt-action-datetime">';
                                            result += '<span class="mt-action-date">'+obj.due_date+'</span>';
                                        result += '</div>';
                                        result += '<div class="mt-action-buttons">';
                                            result += '<div class="btn-group btn-group-circle">';
                                                result += '<a href="#modalAttachedEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnAttachedEdit('+obj.ID+')">Edit</a>';
                                                result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnDeleteFile('+obj.ID+')">Delete</a>';
                                            result += '</div>';
                                        result += '</div>';
                                    result += '</div>';
                                result += '</div>';
                            result += '</div>';

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabFiles_'+obj.parent_id+' .mt-actions').prepend(result);
                            $('#modalAttached').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnAttachedEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalAttached_Edit="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalAttachedEdit .modal-body").html(data);
                    }
                });
            }
            $(".modalAttachedEdit").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Attached',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Attached'));
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
                            var result = '<div class="mt-action-body">';
                                result += '<div class="mt-action-row">';
                                    result += '<div class="mt-action-info">';
                                        result += '<div class="mt-action-icon">'+obj.files+'</div>';
                                        result += '<div class="mt-action-details" style="vertical-align: middle;">';
                                            result += '<span class="mt-action-author">'+obj.name+'</span>';
                                            result += '<p class="mt-action-desc">';
                                                result += '<span class="font-dark">'+obj.comment+'</span><br>';
                                                result += 'Uploaded by: '+obj.user;
                                            result += '</p>';
                                        result += '</div>';
                                    result += '</div>';
                                    result += '<div class="mt-action-datetime">';
                                        result += '<span class="mt-action-date">'+obj.due_date+'</span>';
                                    result += '</div>';
                                    result += '<div class="mt-action-buttons">';
                                        result += '<div class="btn-group btn-group-circle">';
                                            result += '<a href="#modalAttachedEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnAttachedEdit('+obj.ID+')">Edit</a>';
                                            result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnDeleteFile('+obj.ID+')">Delete</a>';
                                        result += '</div>';
                                    result += '</div>';
                                result += '</div>';
                            result += '</div>';

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabFiles_'+obj.parent_id+' .mt-actions .mt-action-'+obj.ID).html(result);
                            $('#modalAttachedEdit').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnDeleteFile(id) {
                swal({
                    title: "Are you sure?",
                    text: "Write some reason on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Reason"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_File="+id+"&reason="+inputValue,
                        dataType: "html",
                        success: function(response){
                            $('.mt-action-'+id+' .mt-action-details .mt-action-author').append('<i class="fa fa-warning font-red" style="margin-left: 5px;"></i>');
                        }
                    });
                    swal("Notification Sent!", "You wrote: " + inputValue, "success");
                });
            }

            // Comment Section
            function btnComment(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalComment="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalComment .modal-body").html(data);
                    }
                });
            }
            $(".modalComment").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Comment',true);

                var l = Ladda.create(document.querySelector('#btnSave_Comment'));
                l.start();

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
                            var html = '<div class="mt-action mt-action-'+obj.ID+'">';
                                html += '<div class="mt-action-body" style="padding-right: 15px;">';
                                    html += '<div class="mt-action-row">';
                                        html += '<div class="mt-action-info">';
                                            html += '<div class="mt-action-icon">';
                                                html += '<img class="img-circle" src="'+obj.avatar+'" alt="'+obj.name+'" style="width: 40px; height: 40px; object-fit: cover;"/>';
                                            html += '</div>';
                                            html += '<div class="mt-action-details" style="vertical-align: middle;">';
                                                html += '<p class="mt-action-desc">';
                                                    html += '<span class="font-dark"><b>'+obj.title+'</b> '+obj.comment+'</span><br>';
                                                    html += 'Commented by: '+obj.name;
                                                html += '</p>';
                                            html += '</div>';
                                        html += '</div>';
                                        html += '<div class="mt-action-datetime">';
                                            html += '<span class="mt-action-date">'+obj.last_modified+'</span>';
                                        html += '</div>';
                                    html += '</div>';
                                html += '</div>';
                            html += '</div>';

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabComments_'+obj.parent_id+' .mt-actions').prepend(html);
                            $('#modalComment').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
    
                        bootstrapGrowl(msg);
                    }
                });
            });
           
            function countComment(id, count) {
                if (count > 0) {
                    $.ajax({
                        type: "GET",
                        url: "function.php?modalCommentCount="+id,
                        dataType: "html",
                        success: function(data){
                            $('#item_'+id+' .badge').hide();
                        }
                    });
                }
            }

            // Compliance Section
            function btnCompliance(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalCompliance="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalCompliance .modal-body").html(data);

                        widget_tagInput();
                        selectMulti();
                    }
                });
            }
            $(".modalCompliance").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Compliance',true);

                var l = Ladda.create(document.querySelector('#btnSave_Compliance'));
                l.start();

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
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td class="text-center"><input type="checkbox" class="make-switch" name="status" data-on-text="Yes" data-off-text="No" data-on-color="success" onchange="changedStatus(this, '+obj.ID+', '+obj.parent_id+')" data-off-color="danger" readonly /></td>';
                                html += '<td>'+obj.requirements+'</td>';
                                html += '<td>'+obj.action_items+'</td>';
                                html += '<td>'+obj.frequency+'</td>';
                                html += '<td class="text-center">'+obj.files+'</td>';
                                html += '<td>';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalComplianceEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnComplianceEdit('+obj.ID+')">Edit</a>';
                                        html += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnComplianceDelete('+obj.ID+')">Delete</a>';

                                        if(obj.compliant == 0) { html += '<a href="#modalComplianceMore" type="button" class="btn blue btn-sm" data-toggle="modal" onclick="btnComplianceMore('+obj.ID+')">Action</a>'; }
                                    html += '</div>';
                                html += '</td>';
                            html += '</tr>';

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabCompliance_'+obj.parent_id+' table tbody').append(html);

                            changedCompliant(obj.parent_id);
                            $('#modalCompliance').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        $(".make-switch").bootstrapSwitch();

                        bootstrapGrowl(msg);
                    }
                });
            });
            function btnComplianceEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalCompliance_Edit="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalComplianceEdit .modal-body").html(data);

                        widget_tagInput();
                    }
                });
            }
            $(".modalComplianceEdit").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Compliance',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Compliance'));
                l.start();

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
                            var html = '<td class="text-center"><input type="checkbox" class="make-switch" name="status" data-on-text="Yes" data-off-text="No" data-on-color="success" onchange="changedStatus(this, '+obj.ID+', '+obj.parent_id+')" data-off-color="danger" readonly /></td>';
                            html += '<td>'+obj.requirements+'</td>';
                            html += '<td>'+obj.action_items+'</td>';
                            html += '<td>'+obj.frequency+'</td>';
                            html += '<td class="text-center">'+obj.files+'</td>';
                            html += '<td>';
                                html += '<div class="btn-group btn-group-circle">';
                                    html += '<a href="#modalComplianceEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnComplianceEdit('+obj.ID+')">Edit</a>';
                                    html += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnComplianceDelete('+obj.ID+')">Delete</a>';

                                    if(obj.compliant == 0) { html += '<a href="#modalComplianceMore" type="button" class="btn blue btn-sm" data-toggle="modal" onclick="btnComplianceMore('+obj.ID+')">Action</a>'; }
                                html += '</div>';
                            html += '</td>';

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabCompliance_'+obj.parent_id+' table tbody #tr_'+obj.ID).html(html);

                            changedCompliant(obj.parent_id);
                            $('#modalComplianceEdit').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        $(".make-switch").bootstrapSwitch();

                        bootstrapGrowl(msg);
                    }
                });
            });
            function btnComplianceMore(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalCompliance_More="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalComplianceMore .modal-body").html(data);
                    }
                });
            }
            $(".modalComplianceMore").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSaveMore_Compliance',true);

                var l = Ladda.create(document.querySelector('#btnSaveMore_Compliance'));
                l.start();

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
                            var html = '<tr id="tr_'+obj.ID+'" class="child_'+obj.parent_id+'">';
                                html += '<td style="border: 0;"></td>';
                                html += '<td colspan="2">';
                                    html += '<strong>'+obj.user+'</strong> <i>('+obj.type+')</i><br>';

                                    if (obj.comment != "") { html += '<span class="text-muted">'+obj.comment+'</span><br>'; }
                                    
                                    html += '<div class="remark_action">';
                                        html += '<a href="javascript:;" type="button" class="btn btn-sm btn-link" onclick="btnComplianceAccept('+obj.ID+')">Accept</a> |';
                                        html += '<a href="javascript:;" type="button" class="btn btn-sm btn-link" onclick="btnComplianceReject('+obj.ID+')">Reject</a>';
                                    html += '</div>';
                                    
                                html += '</td>';
                                html += '<td>Date: <b>'+obj.last_modified+'</b></td>';
                                html += '<td class="text-center">'+obj.files+'</td>';
                                html += '<td>';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalComplianceMoreEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnComplianceMoreEdit('+obj.ID+')">Edit</a>';
                                        html += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnComplianceDelete('+obj.ID+')">Delete</a>';
                                    html += '</div>';
                                html += '</td>';
                            html += '</tr>';

                            var child = $('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody > .child_'+obj.parent_id).length;
                            if (child > 0) {
                                $(html).insertAfter('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody .child_'+obj.parent_id+':last');
                            } else {
                                $(html).insertAfter('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody #tr_'+obj.parent_id);
                            }

                            if (obj.type_id == 3) {
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" checked readonly />';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:first-child').html(makeSwitch);

                                var button = '<a href="#modalComplianceEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnComplianceEdit('+obj.parent_id+')">Edit</a>';
                                button += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnComplianceDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:last-child > div').html(button);
                            } else {
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" readonly />';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:first-child').html(makeSwitch);

                                var button = '<a href="#modalComplianceEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnComplianceEdit('+obj.parent_id+')">Edit</a>';
                                button += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnComplianceDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                button += '<a href="#modalComplianceMore" type="button" class="btn blue btn-sm" data-toggle="modal" onclick="btnComplianceMore('+obj.parent_id+')">Action</a>';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:last-child > div').html(button);
                            }

                            changedCompliant(obj.library_id);
                            $('#modalComplianceMore').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        $(".make-switch").bootstrapSwitch();

                        bootstrapGrowl(msg);
                    }
                });
            });
            function btnComplianceMoreEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalCompliance_MoreEdit="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalComplianceMoreEdit .modal-body").html(data);
                    }
                });
            }
            $(".modalComplianceMoreEdit").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdateMore_Compliance',true);

                var l = Ladda.create(document.querySelector('#btnUpdateMore_Compliance'));
                l.start();

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
                            var html = '<td style="border: 0;"></td>';
                            html += '<td colspan="2">';
                                html += '<strong>'+obj.user+'</strong> <i>('+obj.type+')</i><br>';

                                if (obj.comment != "") { html += '<span class="text-muted">'+obj.comment+'</span><br>'; }
                                
                                html += '<div class="remark_action">'+obj.action+'</div>';
                                
                            html += '</td>';
                            html += '<td>Date: <b>'+obj.last_modified+'</b></td>';
                            html += '<td class="text-center">'+obj.files+'</td>';
                            html += '<td>';
                                html += '<div class="btn-group btn-group-circle">';
                                    html += '<a href="#modalComplianceMoreEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnComplianceMoreEdit('+obj.ID+')">Edit</a>';
                                    html += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnComplianceDelete('+obj.ID+')">Delete</a>';
                                html += '</div>';
                            html += '</td>';

                            $('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody #tr_'+obj.ID).html(html);

                            if (obj.type_id == 3) {
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" checked readonly />';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:first-child').html(makeSwitch);

                                var button = '<a href="#modalComplianceEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnComplianceEdit('+obj.parent_id+')">Edit</a>';
                                button += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnComplianceDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:last-child > div').html(button);
                            } else {
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" readonly />';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:first-child').html(makeSwitch);

                                var button = '<a href="#modalComplianceEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnComplianceEdit('+obj.parent_id+')">Edit</a>';
                                button += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnComplianceDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                button += '<a href="#modalComplianceMore" type="button" class="btn blue btn-sm" data-toggle="modal" onclick="btnComplianceMore('+obj.parent_id+')">Action</a>';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:last-child > div').html(button);
                            }

                            changedCompliant(obj.library_id);
                            $('#modalComplianceMoreEdit').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        $(".make-switch").bootstrapSwitch();

                        bootstrapGrowl(msg);
                    }
                });
            });
            function btnComplianceDelete(id) {
                swal({
                    title: "Are you sure?",
                    text: "Write some reason on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Reason"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_Compliance="+id+"&reason="+inputValue,
                        dataType: "html",
                        success: function(response){
                            $('#tr_'+id).remove();
                        }
                    });
                    swal("Notification Sent!", "You wrote: " + inputValue, "success");
                });
            }
            function btnComplianceAccept(id) {
                swal({
                    title: "Are you sure?",
                    text: "Please confirm if the data are correct!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Yes, confirm it!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnAccept_Compliance="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tr_'+id+' .remark_action').html('<span class="text-success">Accepted!</span>');
                        }
                    });
                    swal("Accepted!", "Data is confirmed", "success");
                });
            }
            function btnComplianceReject(id) {
                swal({
                    title: "Are you sure?",
                    text: "Write some reason on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Reason"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnReject_Compliance="+id+"&reason="+inputValue,
                        dataType: "html",
                        success: function(response){
                            $('#tr_'+id+' .remark_action').html('<span class="text-danger">'+inputValue+'</span>');
                        }
                    });
                    swal("Notification Sent!", "You wrote: " + inputValue, "success");
                });
            }

            // Annual Review Section
            function btnReview(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalReview="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalReview .modal-body").html(data);
                        $(".make-switch").bootstrapSwitch();

                        widget_tagInput();
                    }
                });
            }
            $(".modalReview").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Review',true);

                var l = Ladda.create(document.querySelector('#btnSave_Review'));
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
                            var result = '<tr id="tr_'+obj.ID+'">';
                                result += '<td class="text-center"><input type="checkbox" class="make-switch" name="status" data-on-text="Yes" data-off-text="No" data-on-color="success" onchange="changedStatus(this, 1, 1)" data-off-color="danger" '; if(obj.compliant == 1) { result += 'checked'; } result += ' readonly /></td>';
                                result += '<td>'+obj.requirements+'</td>';
                                result += '<td>'+obj.action_items+'</td>';
                                result += '<td class="text-center">'+obj.files+'</td>';
                                result += '<td>';
                                    result += '<div class="btn-group btn-group-circle">';
                                        result += '<a href="#modalReviewEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnReviewEdit('+obj.ID+')">Edit</a>';
                                        result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnReviewDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';

                                        if (obj.compliant == 0) {
                                            result += '<a href="#modalReviewAction" type="button" class="btn blue btn-sm" data-toggle="modal" onclick="btnReviewAction('+obj.ID+')">Review</a>';
                                        }

                                    result += '</div>';
                                result += '</td>';
                            result += '</tr>';

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabReview_'+obj.parent_id+' table tbody').append(result);
                            $('#modalReview').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        $(".make-switch").bootstrapSwitch();
                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnReviewEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalReview_Edit="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalReviewEdit .modal-body").html(data);
                        $(".make-switch").bootstrapSwitch();
                    }
                });
            }
            $(".modalReviewEdit").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Review',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Review'));
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
                            var result = '<td class="text-center"><input type="checkbox" class="make-switch" name="status" data-on-text="Yes" data-off-text="No" data-on-color="success" onchange="changedStatus(this, 1, 1)" data-off-color="danger" '; if(obj.compliant == 1) { result += 'checked'; } result += ' readonly /></td>';
                            result += '<td>'+obj.requirements+'</td>';
                            result += '<td>'+obj.action_items+'</td>';
                            result += '<td class="text-center">'+obj.files+'</td>';
                            result += '<td>';
                                result += '<div class="btn-group btn-group-circle">';
                                    result += '<a href="#modalReviewEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnReviewEdit('+obj.ID+')">Edit</a>';
                                    result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnReviewDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';

                                    if (obj.compliant == 0) {
                                        result += '<a href="#modalReviewAction" type="button" class="btn blue btn-sm" data-toggle="modal" onclick="btnReviewAction('+obj.ID+')">Review</a>';
                                    }

                                result += '</div>';
                            result += '</td>';

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabReview_'+obj.parent_id+' table tbody #tr_'+obj.ID).html(result);
                            $('#modalReviewEdit').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        $(".make-switch").bootstrapSwitch();
                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnReviewAction(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalReview_Action="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalReviewAction .modal-body").html(data);
                        $(".make-switch").bootstrapSwitch();
                    }
                });
            }
            $(".modalReviewAction").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSaveAction_Review',true);

                var l = Ladda.create(document.querySelector('#btnSaveAction_Review'));
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
                            var result = '<tr id="tr_'+obj.ID+'" class="child_'+obj.review_parent_id+'">';
                                result += '<td style="border: 0;"></td>';
                                result += '<td colspan="2">';
                                    result += '<b>'+obj.name+'</b> <i>('+obj.type+')</i> | '+obj.last_modified+'<br>';

                                    if (obj.title != "") { result += '<span class="text-muted">'+obj.title+'</span><br>'; }
                                    if (obj.comment != "") { result += '<span class="text-muted">'+obj.comment+'</span><br>'; }
                                    
                                    result += '<div class="remark_action">';
                                        result += '<a href="javascript:;" type="button" class="btn btn-sm btn-link" onclick="btnReviewAccept('+obj.ID+')">Accept</a> |';
                                        result += '<a href="javascript:;" type="button" class="btn btn-sm btn-link" onclick="btnReviewReject('+obj.ID+')">Reject</a>';
                                    result += '</div>';

                                result += '</td>';
                                result += '<td class="text-center">'+obj.files+'</td>';
                                result += '<td>';
                                    result += '<div class="btn-group btn-group-circle">';
                                        result += '<a href="#modalReviewActionEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnReviewActionEdit('+obj.ID+')">Edit</a>';
                                        result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnReviewDelete('+obj.ID+', '+obj.library_id+')">Delete</a>';
                                    
                                        if (obj.compliant == 0) {
                                            result += '<a href="#modalReviewMore" type="button" class="btn blue btn-sm" data-toggle="modal" onclick="btnReviewMore('+obj.ID+')">Action</a>';
                                        }
                                    result += '</div>';
                                result += '</td>';
                            result += '</tr>';

                            var child = $('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody > .child_'+obj.review_parent_id).length;
                            if (child > 0) {
                                $(result).insertAfter('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody .child_'+obj.review_parent_id+':last');
                            } else {
                                $(result).insertAfter('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody #tr_'+obj.review_parent_id);
                            }

                            if (obj.compliant == 1) {
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" checked readonly />';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody #tr_'+obj.review_parent_id+' > td:first-child').html(makeSwitch);
                            
                                var button = '<a href="#modalReviewEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnReviewEdit('+obj.review_parent_id+')">Edit</a>';
                                button += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnReviewDelete('+obj.ID+', '+obj.review_parent_id+')">Delete</a>';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody #tr_'+obj.review_parent_id+' > td:last-child > div').html(button);
                            }
                            $('#modalReviewAction').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        $(".make-switch").bootstrapSwitch();
                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnReviewActionEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalReview_ActionEdit="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalReviewActionEdit .modal-body").html(data);
                        $(".make-switch").bootstrapSwitch();
                    }
                });
            }
            $(".modalReviewActionEdit").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdateAction_Review',true);

                var l = Ladda.create(document.querySelector('#btnUpdateAction_Review'));
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
                            var result = '<td style="border: 0;"></td>';
                            result += '<td colspan="2">';
                                result += '<b>'+obj.name+'</b> <i>('+obj.type+')</i> | '+obj.last_modified+'<br>';

                                if (obj.title != "") { result += '<span class="text-muted">'+obj.title+'</span><br>'; }
                                if (obj.comment != "") { result += '<span class="text-muted">'+obj.comment+'</span><br>'; }
                                
                                result += '<div class="remark_action">'+obj.action+'</div>';

                            result += '</td>';
                            result += '<td class="text-center">'+obj.files+'</td>';
                            result += '<td>';
                                result += '<div class="btn-group btn-group-circle">';
                                    result += '<a href="#modalReviewActionEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnReviewActionEdit('+obj.ID+')">Edit</a>';
                                    result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnReviewDelete('+obj.ID+', '+obj.library_id+')">Delete</a>';
                                
                                    if (obj.compliant == 0) {
                                        result += '<a href="#modalReviewMore" type="button" class="btn blue btn-sm" data-toggle="modal" onclick="btnReviewMore('+obj.ID+')">Action</a>';
                                    }
                                result += '</div>';
                            result += '</td>';

                            $('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody #tr_'+obj.ID).html(result);

                            if (obj.compliant == 1) {
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" checked readonly />';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody #tr_'+obj.review_parent_id+' > td:first-child').html(makeSwitch);
                            
                                var button = '<a href="#modalReviewEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnReviewEdit('+obj.review_parent_id+')">Edit</a>';
                                button += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnReviewDelete('+obj.ID+', '+obj.review_parent_id+')">Delete</a>';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody #tr_'+obj.review_parent_id+' > td:last-child > div').html(button);
                            }
                            $('#modalReviewActionEdit').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        $(".make-switch").bootstrapSwitch();
                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnReviewMore(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalReview_More="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalReviewMore .modal-body").html(data);
                    }
                });
            }
            $(".modalReviewMore").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSaveMore_Review',true);

                var l = Ladda.create(document.querySelector('#btnSaveMore_Review'));
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
                            var result = '<tr id="tr_'+obj.ID+'" class="child_'+obj.parent_id+' child_action_'+obj.review_parent_id+'">';
                                result += '<td style="border: 0;"></td>';
                                result += '<td colspan="2">';
                                    result += '<b>'+obj.name+'</b> <i>('+obj.type+')</i> | '+obj.last_modified+'<br>';

                                    if (obj.title != "") { result += '<span class="text-muted">'+obj.title+'</span><br>'; }
                                    if (obj.comment != "") { result += '<span class="text-muted">'+obj.comment+'</span><br>'; }
                                    
                                    result += '<div class="remark_action">';
                                        result += '<a href="javascript:;" type="button" class="btn btn-sm btn-link" onclick="btnReviewAccept('+obj.ID+')">Accept</a> |';
                                        result += '<a href="javascript:;" type="button" class="btn btn-sm btn-link" onclick="btnReviewReject('+obj.ID+')">Reject</a>';
                                    result += '</div>';

                                result += '</td>';
                                result += '<td class="text-center">'+obj.files+'</td>';
                                result += '<td>';
                                    result += '<div class="btn-group btn-group-circle">';
                                        result += '<a href="#modalReviewMoreEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnReviewMoreEdit('+obj.ID+')">Edit</a>';
                                        result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnReviewDelete('+obj.ID+', '+obj.library_id+')">Delete</a>';
                                    result += '</div>';
                                result += '</td>';
                            result += '</tr>';

                            var child = $('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody > .child_action_'+obj.review_parent_id).length;
                            if (child > 0) {
                                $(result).insertAfter('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody .child_action_'+obj.review_parent_id+':last');
                            } else {
                                $(result).insertAfter('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody .child_'+obj.parent_id);
                            }

                            if (obj.type_id == 3) {
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" checked readonly />';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:first-child').html(makeSwitch);
                            
                                var button = '<a href="#modalReviewEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnReviewEdit('+obj.parent_id+')">Edit</a>';
                                button += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnReviewDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:last-child > div').html(button);
                            
                                var buttonRev = '<a href="#modalReviewMoreEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnReviewMoreEdit('+obj.review_parent_id+')">Edit</a>';
                                buttonRev += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnReviewDelete('+obj.ID+', '+obj.review_parent_id+')">Delete</a>';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody #tr_'+obj.review_parent_id+' > td:last-child > div').html(buttonRev);
                            }
                            $('#modalReviewMore').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        $(".make-switch").bootstrapSwitch();
                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnReviewMoreEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalReview_MoreEdit="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalReviewMoreEdit .modal-body").html(data);
                    }
                });
            }
            $(".modalReviewMoreEdit").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdateMore_Review',true);

                var l = Ladda.create(document.querySelector('#btnUpdateMore_Review'));
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
                            var result = '<td style="border: 0;"></td>';
                            result += '<td colspan="2">';
                                result += '<b>'+obj.name+'</b> <i>('+obj.type+')</i> | '+obj.last_modified+'<br>';

                                if (obj.title != "") { result += '<span class="text-muted">'+obj.title+'</span><br>'; }
                                if (obj.comment != "") { result += '<span class="text-muted">'+obj.comment+'</span><br>'; }

                                result += '<div class="remark_action">'+obj.action+'</div>';

                            result += '</td>';
                            result += '<td class="text-center">'+obj.files+'</td>';
                            result += '<td>';
                                result += '<div class="btn-group btn-group-circle">';
                                    result += '<a href="#modalReviewMoreEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnReviewMoreEdit('+obj.ID+')">Edit</a>';
                                    result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnReviewDelete('+obj.ID+', '+obj.library_id+')">Delete</a>';
                                result += '</div>';
                            result += '</td>';

                            $('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody #tr_'+obj.ID).html(result);

                            if (obj.type_id == 3) {
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" checked readonly />';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:first-child').html(makeSwitch);
                            
                                var button = '<a href="#modalReviewEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnReviewEdit('+obj.parent_id+')">Edit</a>';
                                button += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnReviewDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:last-child > div').html(button);
                            
                                var buttonRev = '<a href="#modalReviewMoreEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnReviewMoreEdit('+obj.review_parent_id+')">Edit</a>';
                                buttonRev += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnReviewDelete('+obj.ID+', '+obj.review_parent_id+')">Delete</a>';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabReview_'+obj.library_id+' table tbody #tr_'+obj.review_parent_id+' > td:last-child > div').html(buttonRev);
                            }
                            $('#modalReviewMoreEdit').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        $(".make-switch").bootstrapSwitch();
                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnReviewDelete(id, parent_id) {
                swal({
                    title: "Are you sure?",
                    text: "Write some reason on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Reason"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_Review="+id+"&reason="+inputValue,
                        dataType: "html",
                        success: function(response){
                            $('.panel_'+parent_id+' .panel-body .tab-content #tabReview_'+parent_id+' table tbody #tr_'+id).remove();
                        }
                    });
                    swal("Notification Sent!", "You wrote: " + inputValue, "success");
                });
            }
            function btnReviewAccept(id) {
                swal({
                    title: "Are you sure?",
                    text: "Please confirm if the data are correct!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Yes, confirm it!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnAccept_Review="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tr_'+id+' .remark_action').html('<span class="text-success">Accepted!</span>');
                        }
                    });
                    swal("Accepted!", "Data is confirmed", "success");
                });
            }
            function btnReviewReject(id) {
                swal({
                    title: "Are you sure?",
                    text: "Write some reason on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Reason"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnReject_Review="+id+"&reason="+inputValue,
                        dataType: "html",
                        success: function(response){
                            $('#tr_'+id+' .remark_action').html('<span class="text-danger">'+inputValue+'</span>');
                        }
                    });
                    swal("Notification Sent!", "You wrote: " + inputValue, "success");
                });
            }

            // Template Section
            function btnTemplate(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalTemplate="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalTemplate .modal-body").html(data);
                    }
                });
            }
            $(".modalTemplate").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Template',true);

                var l = Ladda.create(document.querySelector('#btnSave_Template'));
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
                            var result = '<div class="mt-action mt-action-'+obj.ID+'">';
                                result += '<div class="mt-action-body">';
                                    result += '<div class="mt-action-row">';
                                        result += '<div class="mt-action-info">';
                                            result += '<div class="mt-action-icon">'+obj.files+'</div>';
                                            result += '<div class="mt-action-details" style="vertical-align: middle;">';
                                                result += '<p class="mt-action-desc">';
                                                    result += '<span class="font-dark">'+obj.description+'</span><br>';
                                                    result += 'Uploaded by: '+obj.name;
                                                result += '</p>';
                                            result += '</div>';
                                        result += '</div>';
                                        result += '<div class="mt-action-datetime">';
                                            result += '<span class="mt-action-date">'+obj.last_modified+'</span>';
                                        result += '</div>';
                                        result += '<div class="mt-action-buttons">';
                                            result += '<div class="btn-group btn-group-circle">';
                                                result += '<a href="#modalTemplateEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnTemplateEdit('+obj.ID+')">Edit</a>';
                                                result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnTemplateDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                            result += '</div>';
                                        result += '</div>';
                                    result += '</div>';
                                result += '</div>';
                            result += '</div>';

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabTemplate_'+obj.parent_id+' .mt-actions').append(result);
                            $('#modalTemplate').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnTemplateEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalTemplate_Edit="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalTemplateEdit .modal-body").html(data);
                    }
                });
            }
            $(".modalTemplateEdit").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Template',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Template'));
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
                            var result = '<div class="mt-action-body">';
                                result += '<div class="mt-action-row">';
                                    result += '<div class="mt-action-info">';
                                        result += '<div class="mt-action-icon">'+obj.files+'</div>';
                                        result += '<div class="mt-action-details" style="vertical-align: middle;">';
                                            result += '<p class="mt-action-desc">';
                                                result += '<span class="font-dark">'+obj.description+'</span><br>';
                                                result += 'Uploaded by: '+obj.name;
                                            result += '</p>';
                                        result += '</div>';
                                    result += '</div>';
                                    result += '<div class="mt-action-datetime">';
                                        result += '<span class="mt-action-date">'+obj.last_modified+'</span>';
                                    result += '</div>';
                                    result += '<div class="mt-action-buttons">';
                                        result += '<div class="btn-group btn-group-circle">';
                                            result += '<a href="#modalTemplateEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnTemplateEdit('+obj.ID+')">Edit</a>';
                                            result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnTemplateDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                        result += '</div>';
                                    result += '</div>';
                                result += '</div>';
                            result += '</div>';

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabTemplate_'+obj.parent_id+' .mt-actions .mt-action-'+obj.ID).html(result);
                            $('#modalTemplateEdit').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnTemplateDelete(id, parent_id) {
                swal({
                    title: "Are you sure?",
                    text: "Write some reason on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Reason"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_Template="+id+"&reason="+inputValue,
                        dataType: "html",
                        success: function(response){
                            $('#tabTemplate_'+parent_id+' .mt-action-'+id).remove();
                        }
                    });
                    swal("Notification Sent!", "You wrote: " + inputValue, "success");
                });
            }

            // References Section
            function btnRef(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalRef="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalRef .modal-body").html(data);
                    }
                });
            }
            $(".modalRef").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Ref',true);

                var l = Ladda.create(document.querySelector('#btnSave_Ref'));
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
                            var result = '<div class="mt-action mt-action-'+obj.ID+'">';
                                result += '<div class="mt-action-body">';
                                    result += '<div class="mt-action-row">';
                                        result += '<div class="mt-action-info">';
                                            result += '<div class="mt-action-icon">'+obj.files+'</div>';
                                            result += '<div class="mt-action-details" style="vertical-align: middle;">';
                                                result += '<p class="mt-action-desc">';
                                                    result += '<span class="font-dark">'+obj.description+'</span><br>';
                                                    result += 'Uploaded by: '+obj.name;
                                                result += '</p>';
                                            result += '</div>';
                                        result += '</div>';
                                        result += '<div class="mt-action-datetime">';
                                            result += '<span class="mt-action-date">'+obj.last_modified+'</span>';
                                        result += '</div>';
                                        result += '<div class="mt-action-buttons">';
                                            result += '<div class="btn-group btn-group-circle">';
                                                result += '<a href="#modalRefEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnRefEdit('+obj.ID+')">Edit</a>';
                                                result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnRefDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                            result += '</div>';
                                        result += '</div>';
                                    result += '</div>';
                                result += '</div>';
                            result += '</div>';

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabReferences_'+obj.parent_id+' .mt-actions').append(result);
                            $('#modalRef').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnRefEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalRef_Edit="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalRefEdit .modal-body").html(data);
                    }
                });
            }
            $(".modalRefEdit").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Ref',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Ref'));
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
                            var result = '<div class="mt-action-body">';
                                result += '<div class="mt-action-row">';
                                    result += '<div class="mt-action-info">';
                                        result += '<div class="mt-action-icon">'+obj.files+'</div>';
                                        result += '<div class="mt-action-details" style="vertical-align: middle;">';
                                            result += '<p class="mt-action-desc">';
                                                result += '<span class="font-dark">'+obj.description+'</span><br>';
                                                result += 'Uploaded by: '+obj.name;
                                            result += '</p>';
                                        result += '</div>';
                                    result += '</div>';
                                    result += '<div class="mt-action-datetime">';
                                        result += '<span class="mt-action-date">'+obj.last_modified+'</span>';
                                    result += '</div>';
                                    result += '<div class="mt-action-buttons">';
                                        result += '<div class="btn-group btn-group-circle">';
                                            result += '<a href="#modalRefEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnRefEdit('+obj.ID+')">Edit</a>';
                                            result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnRefDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                        result += '</div>';
                                    result += '</div>';
                                result += '</div>';
                            result += '</div>';

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabReferences_'+obj.parent_id+' .mt-actions .mt-action-'+obj.ID).html(result);
                            $('#modalRefEdit').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnRefDelete(id, parent_id) {
                swal({
                    title: "Are you sure?",
                    text: "Write some reason on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Reason"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_Ref="+id+"&reason="+inputValue,
                        dataType: "html",
                        success: function(response){
                            $('#tabReferences_'+parent_id+' .mt-action-'+id).remove();
                        }
                    });
                    swal("Notification Sent!", "You wrote: " + inputValue, "success");
                });
            }

            // Video Section
            function selectType(id) {
                console.log(id);
                $('.selVideo').addClass('hide');
                if (id == 0) { $('#selFile').removeClass('hide'); }
                else { $('#selURL').removeClass('hide'); }
            }
            function btnVideo(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalVideo="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalVideo .modal-body").html(data);
                    }
                });
            }
            $(".modalVideo").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Video',true);

                var l = Ladda.create(document.querySelector('#btnSave_Video'));
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
                            var result = '<div class="mt-action mt-action-'+obj.ID+'">';
                                result += '<div class="mt-action-body">';
                                    result += '<div class="mt-action-row">';
                                        result += '<div class="mt-action-info">';
                                            result += '<div class="mt-action-icon">'+obj.files+'</div>';
                                            result += '<div class="mt-action-details" style="vertical-align: middle;">';
                                                result += '<p class="mt-action-desc">';
                                                    result += '<span class="font-dark">'+obj.description+'</span><br>';
                                                    result += 'Uploaded by: '+obj.name;
                                                result += '</p>';
                                            result += '</div>';
                                        result += '</div>';
                                        result += '<div class="mt-action-datetime">';
                                            result += '<span class="mt-action-date">'+obj.last_modified+'</span>';
                                        result += '</div>';
                                        result += '<div class="mt-action-buttons">';
                                            result += '<div class="btn-group btn-group-circle">';
                                                result += '<a href="#modalVideoEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnVideoEdit('+obj.ID+')">Edit</a>';
                                                result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnVideoDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                            result += '</div>';
                                        result += '</div>';
                                    result += '</div>';
                                result += '</div>';
                            result += '</div>';

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabVideo_'+obj.parent_id+' .mt-actions').append(result);
                            $('#modalVideo').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnVideoEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalVideo_Edit="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalVideoEdit .modal-body").html(data);
                    }
                });
            }
            $(".modalVideoEdit").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Video',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Video'));
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
                            var result = '<div class="mt-action-body">';
                                result += '<div class="mt-action-row">';
                                    result += '<div class="mt-action-info">';
                                        result += '<div class="mt-action-icon">'+obj.files+'</div>';
                                        result += '<div class="mt-action-details" style="vertical-align: middle;">';
                                            result += '<p class="mt-action-desc">';
                                                result += '<span class="font-dark">'+obj.description+'</span><br>';
                                                result += 'Uploaded by: '+obj.name;
                                            result += '</p>';
                                        result += '</div>';
                                    result += '</div>';
                                    result += '<div class="mt-action-datetime">';
                                        result += '<span class="mt-action-date">'+obj.last_modified+'</span>';
                                    result += '</div>';
                                    result += '<div class="mt-action-buttons">';
                                        result += '<div class="btn-group btn-group-circle">';
                                            result += '<a href="#modalVideoEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnVideoEdit('+obj.ID+')">Edit</a>';
                                            result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnVideoDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                        result += '</div>';
                                    result += '</div>';
                                result += '</div>';
                            result += '</div>';

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabVideo_'+obj.parent_id+' .mt-actions .mt-action-'+obj.ID).html(result);
                            $('#modalVideoEdit').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnVideoDelete(id, parent_id) {
                swal({
                    title: "Are you sure?",
                    text: "Write some reason on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Reason"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_Video="+id+"&reason="+inputValue,
                        dataType: "html",
                        success: function(response){
                            $('#tabVideo_'+parent_id+' .mt-action-'+id).remove();
                        }
                    });
                    swal("Notification Sent!", "You wrote: " + inputValue, "success");
                });
            }

            // Task Section
            function btnTask(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalTask="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalTask .modal-body").html(data);
                        selectMulti();
                    }
                });
            }
            $(".modalTask").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Task',true);

                var l = Ladda.create(document.querySelector('#btnSave_Task'));
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
                            var result = '<div class="mt-action mt-action-'+obj.ID+'">';
                                result += '<div class="mt-action-body">';
                                    result += '<div class="mt-action-row">';
                                        result += '<div class="mt-action-info">';
                                            result += '<div class="mt-action-icon">'+obj.files+'</div>';
                                            result += '<div class="mt-action-details" style="vertical-align: middle;">';
                                                result += '<p class="mt-action-desc">';
                                                    result += '<span class="font-dark"><b>'+obj.name+'</b></span><br>';
                                                    result += '<span class="font-dark">'+obj.description+'</span><br>';
                                                    result += 'Assigned to: '+obj.assigned_name;
                                                result += '</p>';
                                            result += '</div>';
                                        result += '</div>';
                                        result += '<div class="mt-action-datetime">';
                                            result += '<span class="mt-action-date">'+obj.start_date+'</span>';
                                            result += '<span class="mt-action-dot bg-green"></span>';
                                            result += '<span class="mt-action-date">'+obj.desired_date+'</span>';
                                        result += '</div>';
                                        result += '<div class="mt-action-buttons">';
                                            result += '<div class="btn-group btn-group-circle">';
                                                result += '<a href="#modalTaskEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnTaskEdit('+obj.ID+')">Edit</a>';
                                                result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnTaskDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                                result += '<a href="#" type="button" class="btn btn-success btn-sm" target="_blank">View</a>';
                                            result += '</div>';
                                        result += '</div>';
                                    result += '</div>';
                                result += '</div>';
                            result += '</div>';

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabTask_'+obj.parent_id+' .mt-actions').append(result);
                            $('#modalTask').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnTaskEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalTask_Edit="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalTaskEdit .modal-body").html(data);
                        selectMulti();
                    }
                });
            }
            $(".modalTaskEdit").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Task',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Task'));
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
                            var result = '<div class="mt-action-body">';
                                result += '<div class="mt-action-row">';
                                    result += '<div class="mt-action-info">';
                                        result += '<div class="mt-action-icon">'+obj.files+'</div>';
                                        result += '<div class="mt-action-details" style="vertical-align: middle;">';
                                            result += '<p class="mt-action-desc">';
                                                result += '<span class="font-dark"><b>'+obj.name+'</b></span><br>';
                                                result += '<span class="font-dark">'+obj.description+'</span><br>';
                                                result += 'Uploaded by: '+obj.assigned_name;
                                            result += '</p>';
                                        result += '</div>';
                                    result += '</div>';
                                    result += '<div class="mt-action-datetime">';
                                        result += '<span class="mt-action-date">'+obj.start_date+'</span>';
                                        result += '<span class="mt-action-dot bg-green"></span>';
                                        result += '<span class="mt-action-date">'+obj.desired_date+'</span>';
                                    result += '</div>';
                                    result += '<div class="mt-action-buttons">';
                                        result += '<div class="btn-group btn-group-circle">';
                                            result += '<a href="#modalTaskEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnTaskEdit('+obj.ID+')">Edit</a>';
                                            result += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnTaskDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                            result += '<a href="#" type="button" class="btn btn-success btn-sm" target="_blank">View</a>';
                                        result += '</div>';
                                    result += '</div>';
                                result += '</div>';
                            result += '</div>';

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabTask_'+obj.parent_id+' .mt-actions .mt-action-'+obj.ID).html(result);
                            $('#modalTaskEdit').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            function btnTaskDelete(id, parent_id) {
                swal({
                    title: "Are you sure?",
                    text: "Write some reason on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Reason"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_Task="+id+"&reason="+inputValue,
                        dataType: "html",
                        success: function(response){
                            $('#tabTask_'+parent_id+' .mt-action-'+id).remove();
                        }
                    });
                    swal("Notification Sent!", "You wrote: " + inputValue, "success");
                });
            }

            // Clone Section
            function btnClone(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?btnClone="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalClone .modal-body").html(data);
                        selectMulti();
                    }
                });
            }
            $(".modalClone").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Clone',true);

                var l = Ladda.create(document.querySelector('#btnSave_Clone'));
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
                            $('#modalClone').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));

            function btnReport(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalReport="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalReport .modal-body").html(data);
                    }
                });
            }

            function btnCollaborator(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalCollaborator="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalCollaborator .modal-body").html(data);
                        selectMulti();
                    }
                });
            }
            $(".modalCollaborator").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Collaborator',true);

                var l = Ladda.create(document.querySelector('#btnSave_Collaborator'));
                l.start();

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
                            $('#modalCollaborator').modal('hide');
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