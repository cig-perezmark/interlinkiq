<?php 
    $title = "Compliance Dashboard";
    $site = "dashboard";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs.'</span><i class="fa fa-angle-right"></i></li>';
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
    
    /*compliance report chart and dashboard style*/
    
    
    .table {
        margin: 0 auto;

        .reportable, #reportable {
            width:100%;
        }

        .table h2 {
            text-align:left;
        }
    }
    .reportable tr, #reportable tr {
        padding:5px;

        td:first-of-type {
            background:#ddd;
        }
    }
    .reportable tr .centertd, #reportable tr .centertd {
        text-align:center;
    }

    .reportable th, #reportable th {
        border: 1px solid grey;
        padding: 5px 20px;
        background:#ddd;
    }

    .reportable td, #reportable td { 
        border: 1px solid grey;
        padding: 5px 20px;
        cursor:pointer;
    }

    /* DataTable*/
    .dt-buttons {
        margin: unset !important;
        float: left !important;
        margin-left: 15px !important;
    }
    div.dt-button-collection .dt-button.active:after {
        position: absolute;
        top: 50%;
        margin-top: -10px;
        right: 1em;
        display: inline-block;
        content: "✓";
        color: inherit;
    }
    .table {
        width: 100% !important;
    }
    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {
        position: relative;
    }
    .table thead tr th {
        vertical-align: middle;
    }

    #comchartdiv {
        width: 100%;
        height: 400px;
        max-width: 100%;
    }
    @media (max-width: 1024px) {
        #comchartdiv {
            height: 350px;
        }
    }
    @media (max-width: 768px) {
        #comchartdiv {
            height: 300px;
        }
    }
    @media (max-width: 600px) {
        #comchartdiv {
            height: 250px;
        }
    }

    /* Summer Note Table*/
    #modalChanges table,
    #modalHistory table,
    #parent table {
        width: 100% !important;
        margin-left: unset !important;
        margin-right: unset !important;
    }
</style>


                <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
                <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
                <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
                <script src="https://cdn.amcharts.com/lib/5/plugins/legend.js"></script>
                
                <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
                <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
                <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>


                    <?php
                        function dashboardChild($parent_id, $user_id, $dashboard_result) {
                    		global $conn;
                    		
                            $selectDashboard = mysqli_query($conn, "SELECT 
                            *
                            FROM (
                                SELECT
                                t1.ID AS mainID,
                                t1.parent_id AS parentID,
                                t1.collaborator_id AS parentCollab,
                                t1.name AS parentName,
                                COUNT(t2.ID) AS childRow,
                                COALESCE(c.count_ID, 0) AS complyRow,
                                COALESCE(c.sum_compliant, 0) as complySum,
                                COALESCE(c.percent_compliant, 0) as complyPercentage,
                                COALESCE(f.count_ID, 0) AS fileRow,
                                COALESCE(f.expired_files, 0) AS fileExpire,
                                COALESCE(f.expired_files30, 0) AS fileExpire30,
                                COALESCE(f.expired_files90, 0) AS fileExpire90
                                FROM tbl_library AS t1 
                                
                                LEFT JOIN (
                                    SELECT * FROM tbl_library WHERE deleted = 0 AND parent_id <> 0
                                ) AS t2 
                                ON t1.ID = t2.parent_id
                                
                                LEFT JOIN (
                                    SELECT
                                    ID,
                                    library_id,
                                    action_items,
                                    COUNT(ID) AS count_ID, 
                                    SUM(compliant) as sum_compliant,
                                    CASE WHEN COUNT(ID) = SUM(compliant = 1) THEN 100 ELSE 0 END AS percent_compliant 
                                    FROM tbl_library_compliance 
                                    WHERE deleted = 0
                                    AND parent_id = 0
                                    GROUP BY library_id
                                ) AS c 
                                ON t1.ID = c.library_id
                                
                                LEFT JOIN (
                                    SELECT
                                    ID,
                                    library_id,
                                    COUNT(ID) AS count_ID,
                                    COUNT(CASE WHEN due_date < CURDATE() THEN 1 END) AS expired_files,
                                    CASE WHEN DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 30 DAY)) >= 0 AND DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 30 DAY)) <= 30 THEN 1 ELSE 0 END AS expired_files30,
                                    CASE WHEN DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 30 DAY)) >= 60 AND DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 90 DAY)) <= 30 THEN 1 ELSE 0 END AS expired_files90
                                    FROM tbl_library_file
                                    WHERE deleted = 0
                                    GROUP BY library_id
                                ) AS f
                                ON t1.ID = f.library_id
                                
                                WHERE t1.deleted = 0
                                AND t1.parent_id = $parent_id
                                AND t1.user_id = $user_id
                                GROUP BY t1.ID
                            ) AS r");
                            if ( mysqli_num_rows($selectDashboard) > 0 ) {
                                while($rowDashboard = mysqli_fetch_array($selectDashboard)) {
                                    $dashboard_ID = $rowDashboard["mainID"];
                                    $dashboard_complyPercentage = $rowDashboard["complyPercentage"];
                                    $dashboard_fileRow = $rowDashboard["fileRow"];
                                    $dashboard_fileExpire = $rowDashboard["fileExpire"];
                                    $dashboard_fileExpire30 = $rowDashboard["fileExpire30"];
                                    $dashboard_fileExpire90 = $rowDashboard["fileExpire90"];

                                    $data_output = array (
                                        'compliance' => $dashboard_complyPercentage,
                                        'file_count' => $dashboard_fileRow,
                                        'file_expired' => $dashboard_fileExpire,
                                        'file_expired30' => $dashboard_fileExpire30,
                                        'file_expired90' => $dashboard_fileExpire90
                                    );
                                    array_push($dashboard_result, $data_output);

                                    $dashboard_result = dashboardChild($dashboard_ID, $user_id, $dashboard_result);
                                }
                            }

                            return $dashboard_result;
                        }
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

                                if ($current_userAdminAccess == 0) {
                                    $collabUser = 1;
                                }
                            } else {
                                $selectDashboard = mysqli_query( $conn,"SELECT * from tbl_library WHERE deleted = 0 AND user_id = $switch_user_id" );
                                if ( mysqli_num_rows($selectDashboard) > 0 ) {
                                    $newUser = 0;
                                }
                            }
                        }
                        
                        if($switch_user_id == 253 AND $switch_user_id == 1) { $newUser = 1; }
                        // if($switch_user_id == 423) { $newUser = 0; }
                        $newUser = 0;
                    ?>

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
                                
                                $icon = $row["icon"];
                                if (!empty($icon)) { 
                                    if ($type_id == 0) {
                                        echo ' <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'"><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                    } else {
                                        echo ' <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                    }
                                }
                            }
                            
                            if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163) {
                                echo ' <a data-toggle="modal" data-target="#modalInstruction" class="btn btn-circle btn-success btn-xs" onclick="btnInstruction()">Add New Instruction</a>';
                            }
                        }
                    ?>

                    <?php if($newUser == 0) { ?>
                        <div class="row">
                            <div class="actions">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#home" data-toggle="tab">Home</a>
                                    </li>
                                    <?php if($switch_user_id == 464 OR $switch_user_id == 1457 OR $switch_user_id == 1649 OR $switch_user_id == 1) { ?>
                                         <li>
                                            <a href="#com_analytics" data-toggle="tab">Analytics </a>
                                        </li>
                                    <?php } ?>
                                    <?php if($switch_user_id == 1649 OR $switch_user_id == 1) { ?>
                                         <li>
                                            <a href="#com_poam" data-toggle="tab">POAM</a>
                                        </li>
                                         <li>
                                            <a href="#com_report" data-toggle="tab">CMMC Not Met Report</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home"> 
                                <div class="col-md-4" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <input class="form-control" id="deliverable_search" type="text" placeholder="Search" />
                                        <?php if ($current_userID == 34 OR $current_userID == 1 OR $current_userID == 2 OR $current_userID == 19 OR $current_userID == 163 OR $current_userEmployerID == 27 OR $switch_user_id == 464 OR $switch_user_id == 1622) { ?>
                                            <div class="input-group-btn">
                                                <button type="button" class="btn green dropdown-toggle" data-toggle="dropdown">Action
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu pull-right">
                                                    <li>
                                                        <a href="#modalArea" data-toggle="modal"> Add New </a>
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
                                
                                <?php
                                    if (empty($_GET['d']) AND ($current_userID == 3111 OR  $switch_user_id == 550111 OR $current_client == 1) ) {
                                ?>
                                        <div class="left" style="display: flex; flex-direction: column-reverse;">
                                            <div class="table">
                                                <h3 class="table-title">Compliance Breakdown</h3>
                                                <table id="reportable">
                                                    <tbody>                                       
                                                        <?php 
                                                            // $show_reportsummary=mysqli_query($conn,"select t1.child_id as chd2, t1.collaborator_id, t1.ID, t1.name, count(distinct(t1.child_id)) as count_child, count(file_id) as file_count
                                                            // , count(t1.no_upload_flag) as 'count_no_upload', count(t1.expired_flag) as 'count_expired', sum(coalesce(t1.30_days,0)) as 'count_30_days', sum(coalesce(t1.90_days,0)) as 'count_90_days'
                                                            // , t1.count_actions, t1.sum_compliant,  round(avg(t1.child_percentage_compliance),2) as 'child_percentage_compliance'
                                                            // FROM(
                                                            // SELECT t1.child_id as chd2, t1.collaborator_id, t1.ID, t1.name, child.name as child_name, child.id as child_id, t2.ID as file_id
                                                            // , case when count(t2.ID)=0 then 1 end as 'no_upload_flag' 
                                                            // , case when t2.due_date<CURRENT_TIMESTAMP then 1 end as 'expired_flag' 
                                                            // , case when DATEDIFF(t2.due_date, CURRENT_TIMESTAMP)>0 and DATEDIFF(t2.due_date, CURRENT_TIMESTAMP)<=30 then 1 end as '30_days'
                                                            // , case when DATEDIFF(t2.due_date, CURRENT_TIMESTAMP)>30 and DATEDIFF(t2.due_date, CURRENT_TIMESTAMP)<=90 then 1 end as '90_days'    
                                                            // , t3.sum_compliant, t3.count_actions, COALESCE(t3.percentage_compliance,0) as 'child_percentage_compliance'
                                                            // FROM tbl_library t1
                                                            // left join (
                                                            // select * from tbl_library 
                                                            // where 1=1
                                                            // and parent_id<>0
                                                            // and deleted=0
                                                            // )child on t1.ID=child.parent_id
                                                            // left join tbl_library_file t2
                                                            // on child.ID=t2.library_id
                                                            // left join (
                                                            // select t1.library_id, count(id) as count_actions, sum(compliant) as sum_compliant, case when count(id)>0 then (sum(compliant)/count(id))*100 end as 'percentage_compliance'
                                                            // from tbl_library_compliance t1
                                                            // group by t1.library_id
                                                            // )t3 on child.ID=t3.library_id
                                                            // WHERE 1=1
                                                            // and t1.deleted=0
                                                            // and t1.parent_id=0
                                                            // and t1.user_id=$current_userEmployerID
                                                            // group by t1.ID, t1.name, child.name, child.id, t2.id, t1.child_id, t1.collaborator_id
                                                            // order by 1 
                                                            // ) t1
                                                            // WHERE 1=1
                                                            // group by t1.id, t1.name  ");
        
                                                            // $total_uploaded=0;
                                                            // $total_compliance=0;
                                                            // while ($rowTree = mysqli_fetch_array($show_reportsummary)) {
            
                                                            //     $library_ID = $rowTree["ID"];
                                                            //     $library_name = $rowTree["name"];
                                                            //     $library_collaborator_id = $rowTree["collaborator_id"];
                                                            //     $count_expired = $rowTree["count_expired"];
                                                            //     $count_1_30days =  $rowTree["count_30_days"];
                                                            //     $count_30_90days = $rowTree["count_90_days"];
                                                            //     $count_no_upload = $rowTree["count_no_upload"];
                                                            //     $percentage_compliance = $rowTree["child_percentage_compliance"];
                                                            //     $count_child=$rowTree["count_child"];
            
                                                            //     $total_uploaded += $count_no_upload;
                                                            //     $total_compliance += $percentage_compliance;
            
                                                            //     $library_child = false;
                                                            //     if (!empty($rowTree["chd2"])) { $library_child = true; }
            
                                                            //     $array_name_id = explode(", ", $library_name);
                                                            //     if ( count($array_name_id) == 4 ) {
                                                            //         $data_name = array();
            
                                                            //         $selectType = mysqli_query($conn,"SELECT * FROM tbl_library_type WHERE ID = '".$array_name_id[0]."'");
                                                            //         if ( mysqli_num_rows($selectType) > 0 ) {
                                                            //             while($rowType = mysqli_fetch_array($selectType)) {
                                                            //                 array_push($data_name, $rowType["name"]);
                                                            //             }
                                                            //         }
            
                                                            //         $selectCategory = mysqli_query($conn,"SELECT * FROM tbl_library_category WHERE ID = '".$array_name_id[1]."'");
                                                            //         if ( mysqli_num_rows($selectCategory) > 0 ) {
                                                            //             while($rowCategory = mysqli_fetch_array($selectCategory)) {
                                                            //                 array_push($data_name, $rowCategory["name"]);
                                                            //             }
                                                            //         }
            
                                                            //         $selectScope = mysqli_query($conn,"SELECT * FROM tbl_library_scope WHERE ID = '".$array_name_id[2]."'");
                                                            //         if ( mysqli_num_rows($selectScope) > 0 ) {
                                                            //             while($rowScope = mysqli_fetch_array($selectScope)) {
                                                            //                 array_push($data_name, $rowScope["name"]);
                                                            //             }
                                                            //         }
            
                                                            //         $selectModule = mysqli_query($conn,"SELECT * FROM tbl_library_module WHERE ID = '".$array_name_id[3]."'");
                                                            //         if ( mysqli_num_rows($selectModule) > 0 ) {
                                                            //             while($rowModule = mysqli_fetch_array($selectModule)) {
                                                            //                 array_push($data_name, $rowModule["name"]);
                                                            //             }
                                                            //         }
            
                                                            //         $library_name = implode(" - ",$data_name);
                                                            //     }
                                                            //     $display = false;
                                                            //     if($collabUser == 1 AND !isset($_COOKIE['switchAccount'])) {
                                                            //         if (!empty($library_collaborator_id)) {
                                                            //             $collab = json_decode($library_collaborator_id, true);
                                                            //             foreach ($collab as $key => $value) {
                                                            //                 if ($current_userEmployerID == $key) {
                                                            //                     if (in_array($current_userEmployeeID, $value['assigned_to_id'])) {
                                                            //                         $display = true;
            
                                                            //                         break;
                                                            //                     }
                                                            //                 }
                                                            //             }
                                                            //         }
                                                            //     } else {
                                                            //         $display = true;
                                                            //     }
            
                                                            //     if ($display == true) {
                                                            //         echo '<tr>
                                                            //             <td onClick="btnLoadDashboard('.$library_ID.')">'.$library_name.'</td>
                                                            //             <td class="centertd">'.$percentage_compliance.'%</td>
                                                            //             <td class="centertd">'.$count_no_upload.'</td>
                                                            //             <td class="centertd">'.$count_expired.'</td>
                                                            //             <td class="centertd">'.$count_1_30days.'</td>
                                                            //             <td class="centertd">'.$count_30_90days.'</td>
                                                            //         </tr>';
                                                            //     }
                                                            // }
                                                            
                                                            
                                                            $selectDashboard = mysqli_query($conn, "SELECT 
                                                            *
                                                            FROM (
                                                                SELECT
                                                                t1.ID AS mainID,
                                                                t1.parent_id AS parentID,
                                                                t1.collaborator_id AS parentCollab,
                                                                t1.name AS parentName,
                                                                COUNT(t2.ID) AS childRow,
                                                                COALESCE(c.count_ID, 0) AS complyRow,
                                                                COALESCE(c.sum_compliant, 0) as complySum,
                                                                COALESCE(c.percent_compliant, 0) as complyPercentage,
                                                                COALESCE(f.count_ID, 0) AS fileRow,
                                                                COALESCE(f.expired_files, 0) AS fileExpire,
                                                                COALESCE(f.expired_files30, 0) AS fileExpire30,
                                                                COALESCE(f.expired_files90, 0) AS fileExpire90
                                                                FROM tbl_library AS t1 
                                                                
                                                                LEFT JOIN (
                                                                    SELECT * FROM tbl_library WHERE deleted = 0 AND parent_id <> 0
                                                                ) AS t2 
                                                                ON t1.ID = t2.parent_id
                                                                
                                                                LEFT JOIN (
                                                                    SELECT
                                                                    ID,
                                                                    library_id,
                                                                    action_items,
                                                                    COUNT(ID) AS count_ID, 
                                                                    SUM(compliant) as sum_compliant,
                                                                    CASE WHEN COUNT(ID) = SUM(compliant = 1) THEN 100 ELSE 0 END AS percent_compliant 
                                                                    FROM tbl_library_compliance 
                                                                    WHERE deleted = 0
                                                                    AND parent_id = 0
                                                                    GROUP BY library_id
                                                                ) AS c 
                                                                ON t1.ID = c.library_id
                                                                
                                                                LEFT JOIN (
                                                                    SELECT
                                                                    ID,
                                                                    library_id,
                                                                    COUNT(ID) AS count_ID,
                                                                    COUNT(CASE WHEN due_date < CURDATE() THEN 1 END) AS expired_files,
                                                                    CASE WHEN DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 30 DAY)) >= 0 AND DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 30 DAY)) <= 30 THEN 1 ELSE 0 END AS expired_files30,
                                                                    CASE WHEN DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 30 DAY)) >= 60 AND DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 90 DAY)) <= 30 THEN 1 ELSE 0 END AS expired_files90
                                                                    FROM tbl_library_file
                                                                    WHERE deleted = 0
                                                                    GROUP BY library_id
                                                                ) AS f
                                                                ON t1.ID = f.library_id
                                                                
                                                                WHERE t1.deleted = 0
                                                                -- AND t1.parent_id = 0
                                                                AND t1.user_id = $switch_user_id
                                                                GROUP BY t1.ID
                                                            ) AS r");
                                                            if (mysqli_num_rows($selectDashboard) > 0) {
                                                                $file_uploaded = 0;
                                                                $compliance_count = 0;
                                                                $compliance_overall = 0;
                                                                $compliance_average = 0;
                                                                while($rowDashboard = mysqli_fetch_array($selectDashboard)) {
                                                                    $dashboard_ID = $rowDashboard["mainID"];
                                                                    $dashboard_parentID = $rowDashboard["parentID"];
                                                                    $dashboard_complyRow = $rowDashboard["complyRow"];
                                                                    $dashboard_complySum = $rowDashboard["complySum"];
                                                                    $dashboard_complyPercentage = $rowDashboard["complyPercentage"];
                                                                    $dashboard_fileRow = $rowDashboard["fileRow"];
                                                                    $dashboard_fileExpire = $rowDashboard["fileExpire"];
                                                                    $dashboard_fileExpire30 = $rowDashboard["fileExpire30"];
                                                                    $dashboard_fileExpire90 = $rowDashboard["fileExpire90"];
                        
                                                                    if ($dashboard_parentID == 0) {
                                                                        // $dashboard_result = array();
                                                                        // $data_output = array (
                                                                        //     'compliance' => $dashboard_complyPercentage,
                                                                        //     'file_count' => $dashboard_fileRow,
                                                                        //     'file_expired' => $dashboard_fileExpire,
                                                                        //     'file_expired30' => $dashboard_fileExpire30,
                                                                        //     'file_expired90' => $dashboard_fileExpire90
                                                                        // );
                                                                        // array_push($dashboard_result, $data_output);
                            
                                                                        $dashboard_name = $rowDashboard["parentName"];
                                                                        $array_name_id = explode(", ", $dashboard_name);
                                                                        if ( count($array_name_id) == 4 ) {
                                                                            $data_name = array();
                            
                                                                            $selectType = mysqli_query($conn,"SELECT * FROM tbl_library_type WHERE ID = '".$array_name_id[0]."'");
                                                                            if ( mysqli_num_rows($selectType) > 0 ) {
                                                                                while($rowType = mysqli_fetch_array($selectType)) {
                                                                                    array_push($data_name, $rowType["name"]);
                                                                                }
                                                                            }
                            
                                                                            $selectCategory = mysqli_query($conn,"SELECT * FROM tbl_library_category WHERE ID = '".$array_name_id[1]."'");
                                                                            if ( mysqli_num_rows($selectCategory) > 0 ) {
                                                                                while($rowCategory = mysqli_fetch_array($selectCategory)) {
                                                                                    array_push($data_name, $rowCategory["name"]);
                                                                                }
                                                                            }
                            
                                                                            $selectScope = mysqli_query($conn,"SELECT * FROM tbl_library_scope WHERE ID = '".$array_name_id[2]."'");
                                                                            if ( mysqli_num_rows($selectScope) > 0 ) {
                                                                                while($rowScope = mysqli_fetch_array($selectScope)) {
                                                                                    array_push($data_name, $rowScope["name"]);
                                                                                }
                                                                            }
                            
                                                                            $selectModule = mysqli_query($conn,"SELECT * FROM tbl_library_module WHERE ID = '".$array_name_id[3]."'");
                                                                            if ( mysqli_num_rows($selectModule) > 0 ) {
                                                                                while($rowModule = mysqli_fetch_array($selectModule)) {
                                                                                    array_push($data_name, $rowModule["name"]);
                                                                                }
                                                                            }
                            
                                                                            $dashboard_name = implode(" - ",$data_name);
                                                                        }
                                    
                                                                        // $dashboard_result = dashboardChild($dashboard_ID, $current_userEmployerID, $dashboard_result);
                            
                                                                        // $compliance_average = 0;
                                                                        // $compliance_total = array_reduce($dashboard_result, function($carry, $item) {
                                                                        //     return $carry + intval($item["compliance"]);
                                                                        // }, 0);
                                                                        // if (count($dashboard_result) > 0) { $compliance_average = $compliance_total / count($dashboard_result); }
                                                                        // $compliance_overall += $compliance_average;
                            
                                                                        // $file_total = array_reduce($dashboard_result, function($carry, $item) {
                                                                        //     return $carry + intval($item["file_count"]);
                                                                        // }, 0);
                                                                        // $file_uploaded += $file_total;
                            
                                                                        // $file_total_expired = array_reduce($dashboard_result, function($carry, $item) {
                                                                        //     return $carry + intval($item["file_expired"]);
                                                                        // }, 0);
                            
                                                                        // $file_total_expired30 = array_reduce($dashboard_result, function($carry, $item) {
                                                                        //     return $carry + intval($item["file_expired30"]);
                                                                        // }, 0);
                            
                                                                        // $file_total_expired90 = array_reduce($dashboard_result, function($carry, $item) {
                                                                        //     return $carry + intval($item["file_expired90"]);
                                                                        // }, 0);
                                                                        
                                                                        
                                                                        
                                                                        $selectCompliance = mysqli_query( $conn, "WITH RECURSIVE cte (mainID, parentID, parentCollab, parentName) AS
                                                                            (
                                                                                SELECT 
                                                                                    t1.ID AS mainID,
                                                                                    t1.parent_id AS parentID,
                                                                                    t1.collaborator_id AS parentCollab,
                                                                                    t1.name AS parentName
                                                                                FROM tbl_library AS t1
                                                                                WHERE t1.deleted = 0 AND t1.user_id = $switch_user_id AND t1.parent_id = 0 AND t1.ID = $dashboard_ID
                                                                                
                                                                                UNION ALL
                                                                                
                                                                                SELECT 
                                                                                    t2.ID AS mainID,
                                                                                    t2.parent_id AS parentID,
                                                                                    t2.collaborator_id AS parentCollab,
                                                                                    t2.name AS parentName
                                                                                FROM tbl_library AS t2
                                                                                JOIN cte ON cte.mainID = t2.parent_id
                                                                                WHERE t2.deleted = 0 AND t2.user_id = $switch_user_id
                                                                            )
                                                                            SELECT 
                                                                            mainID, parentID, parentCollab, parentName,
                                                                            CASE WHEN COUNT(mainID) > 0 THEN SUM(percent_compliant) / COUNT(mainID) END AS compliantPercentage
                                                                            FROM cte
                    
                                                                            LEFT JOIN (
                                                                            SELECT
                                                                                ID,
                                                                                library_id,
                                                                                action_items,
                                                                                COUNT(ID) AS count_ID, 
                                                                                SUM(compliant) as sum_compliant,
                                                                                CASE WHEN COUNT(ID) = SUM(compliant = 1) THEN 100 ELSE 0 END AS percent_compliant 
                                                                                FROM tbl_library_compliance 
                                                                                WHERE deleted = 0
                                                                                AND parent_id = 0
                                                                                GROUP BY library_id
                                                                            ) AS c 
                                                                            ON cte.mainID = c.library_id" );
                                                                        if ( mysqli_num_rows($selectCompliance) > 0 ) {
                                                                            $rowCompliance = mysqli_fetch_array($selectCompliance);
                                                                            $compliance_average = number_format(floatval($rowCompliance["compliantPercentage"]), 2);
                                                                        }
                                                                        $compliance_count++;
                                                                        $compliance_overall += $compliance_average;
            
                                                                        $selectFileCount = mysqli_query( $conn,"WITH RECURSIVE cte (mainID, parentID, parentCollab, parentName) AS
                                                                            (
                                                                                SELECT 
                                                                                    t1.ID AS mainID,
                                                                                    t1.parent_id AS parentID,
                                                                                    t1.collaborator_id AS parentCollab,
                                                                                    t1.name AS parentName
                                                                                FROM tbl_library AS t1
                                                                                WHERE t1.deleted = 0 AND t1.user_id = $switch_user_id AND t1.parent_id = 0 AND t1.ID = $dashboard_ID
                                                                                
                                                                                UNION ALL
                                                                                
                                                                                SELECT 
                                                                                    t2.ID AS mainID,
                                                                                    t2.parent_id AS parentID,
                                                                                    t2.collaborator_id AS parentCollab,
                                                                                    t2.name AS parentName
                                                                                FROM tbl_library AS t2
                                                                                JOIN cte ON cte.mainID = t2.parent_id
                                                                                WHERE t2.deleted = 0 AND t2.user_id = $switch_user_id
                                                                            )
                                                                            SELECT 
                                                                            COUNT(mainID) AS fileCount, mainID, parentID, parentCollab, parentName
                                                                            FROM cte
                    
                                                                            LEFT JOIN (
                                                                                SELECT library_id, files, name, last_modified, due_date FROM tbl_library_file WHERE deleted = 0
                                                                            ) AS f
                                                                            ON cte.mainID = f.library_id
                                                                            WHERE f.name IS NOT NULL");
                                                                        if ( mysqli_num_rows($selectFileCount) > 0 ) {
                                                                            $rowFile = mysqli_fetch_array($selectFileCount);
                                                                            $file_total = $rowFile["fileCount"];
                                                                        }
                                                                        $file_uploaded += $file_total;
                    
                                                                        $selectFileCountExpired = mysqli_query( $conn,"WITH RECURSIVE cte (mainID, parentID, parentCollab, parentName) AS
                                                                            (
                                                                                SELECT 
                                                                                    t1.ID AS mainID,
                                                                                    t1.parent_id AS parentID,
                                                                                    t1.collaborator_id AS parentCollab,
                                                                                    t1.name AS parentName
                                                                                FROM tbl_library AS t1
                                                                                WHERE t1.deleted = 0 AND t1.user_id = $switch_user_id AND t1.parent_id = 0 AND t1.ID = $dashboard_ID
                                                                                
                                                                                UNION ALL
                                                                                
                                                                                SELECT 
                                                                                    t2.ID AS mainID,
                                                                                    t2.parent_id AS parentID,
                                                                                    t2.collaborator_id AS parentCollab,
                                                                                    t2.name AS parentName
                                                                                FROM tbl_library AS t2
                                                                                JOIN cte ON cte.mainID = t2.parent_id
                                                                                WHERE t2.deleted = 0 AND t2.user_id = $switch_user_id
                                                                            )
                                                                            SELECT 
                                                                            COUNT(mainID) AS fileCount, mainID, parentID, parentCollab, parentName
                                                                            FROM cte
                    
                                                                            LEFT JOIN (
                                                                                SELECT library_id, files, name, last_modified, due_date FROM tbl_library_file WHERE deleted = 0 AND due_date < CURDATE()
                                                                            ) AS f
                                                                            ON cte.mainID = f.library_id
                                                                            WHERE f.name IS NOT NULL");
                                                                        if ( mysqli_num_rows($selectFileCountExpired) > 0 ) {
                                                                            $rowFileExpired = mysqli_fetch_array($selectFileCountExpired);
                                                                            $file_total_expired = $rowFileExpired["fileCount"];
                                                                        }
                    
                                                                        $selectFileCountExpired30 = mysqli_query( $conn,"WITH RECURSIVE cte (mainID, parentID, parentCollab, parentName) AS
                                                                            (
                                                                                SELECT 
                                                                                    t1.ID AS mainID,
                                                                                    t1.parent_id AS parentID,
                                                                                    t1.collaborator_id AS parentCollab,
                                                                                    t1.name AS parentName
                                                                                FROM tbl_library AS t1
                                                                                WHERE t1.deleted = 0 AND t1.user_id = $switch_user_id AND t1.parent_id = 0 AND t1.ID = $dashboard_ID
                                                                                
                                                                                UNION ALL
                                                                                
                                                                                SELECT 
                                                                                    t2.ID AS mainID,
                                                                                    t2.parent_id AS parentID,
                                                                                    t2.collaborator_id AS parentCollab,
                                                                                    t2.name AS parentName
                                                                                FROM tbl_library AS t2
                                                                                JOIN cte ON cte.mainID = t2.parent_id
                                                                                WHERE t2.deleted = 0 AND t2.user_id = $switch_user_id
                                                                            )
                                                                            SELECT 
                                                                            COUNT(mainID) AS fileCount, mainID, parentID, parentCollab, parentName
                                                                            FROM cte
                    
                                                                            LEFT JOIN (
                                                                                SELECT library_id, files, name, last_modified, due_date FROM tbl_library_file WHERE deleted = 0 AND DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 30 DAY)) >= 0 AND DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 30 DAY)) <= 30
                                                                            ) AS f
                                                                            ON cte.mainID = f.library_id
                                                                            WHERE f.name IS NOT NULL");
                                                                        if ( mysqli_num_rows($selectFileCountExpired30) > 0 ) {
                                                                            $rowFileExpired30 = mysqli_fetch_array($selectFileCountExpired30);
                                                                            $file_total_expired30 = $rowFileExpired30["fileCount"];
                                                                        }
                    
                                                                        $selectFileCountExpired90 = mysqli_query( $conn,"WITH RECURSIVE cte (mainID, parentID, parentCollab, parentName) AS
                                                                            (
                                                                                SELECT 
                                                                                    t1.ID AS mainID,
                                                                                    t1.parent_id AS parentID,
                                                                                    t1.collaborator_id AS parentCollab,
                                                                                    t1.name AS parentName
                                                                                FROM tbl_library AS t1
                                                                                WHERE t1.deleted = 0 AND t1.user_id = $switch_user_id AND t1.parent_id = 0 AND t1.ID = $dashboard_ID
                                                                                
                                                                                UNION ALL
                                                                                
                                                                                SELECT 
                                                                                    t2.ID AS mainID,
                                                                                    t2.parent_id AS parentID,
                                                                                    t2.collaborator_id AS parentCollab,
                                                                                    t2.name AS parentName
                                                                                FROM tbl_library AS t2
                                                                                JOIN cte ON cte.mainID = t2.parent_id
                                                                                WHERE t2.deleted = 0 AND t2.user_id = $switch_user_id
                                                                            )
                                                                            SELECT 
                                                                            COUNT(mainID) AS fileCount, mainID, parentID, parentCollab, parentName
                                                                            FROM cte
                    
                                                                            LEFT JOIN (
                                                                                SELECT library_id, files, name, last_modified, due_date FROM tbl_library_file WHERE deleted = 0 AND DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 30 DAY)) >= 0 AND DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 30 DAY)) <= 30
                                                                            ) AS f
                                                                            ON cte.mainID = f.library_id
                                                                            WHERE f.name IS NOT NULL");
                                                                        if ( mysqli_num_rows($selectFileCountExpired90) > 0 ) {
                                                                            $rowFileExpired90 = mysqli_fetch_array($selectFileCountExpired90);
                                                                            $file_total_expired90 = $rowFileExpired90["fileCount"];
                                                                        }
                                                                        
                                                                        echo '<tr>
                                                                            <td href="#modalReport" data-toggle="modal" onClick="btnReport('.$dashboard_ID.')">'.$dashboard_name.'</td>
                                                                            <td class="text-center" href="#modalComplianceList" data-toggle="modal" onclick="btnComplianceList('.$dashboard_ID.')">'.$compliance_average.'%</td>
                                                                            <td class="text-center" href="#modalFileUploads" data-toggle="modal" onclick="btnFileUploads('.$dashboard_ID.', 1)">'.$file_total.'</td>
                                                                            <td class="text-center" href="#modalFileUploads" data-toggle="modal" onclick="btnFileUploads('.$dashboard_ID.', 2)">'.$file_total_expired.'</td>
                                                                            <td class="text-center" href="#modalFileUploads" data-toggle="modal" onclick="btnFileUploads('.$dashboard_ID.', 3)">'.$file_total_expired30.'</td>
                                                                            <td class="text-center" href="#modalFileUploads" data-toggle="modal" onclick="btnFileUploads('.$dashboard_ID.', 4)">'.$file_total_expired90.'</td>
                                                                        </tr>';
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                    <thead>
                                                        <tr class="header">
                                                            <th>Item</th>
                                                            <th>Compliance %</th>
                                                            <th><?php echo $file_uploaded; ?> File Upload</th>
                                                            <th>EXPIRED</th>
                                                            <th>1-30 DAYS</th>
                                                            <th>30-90 DAYS</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                
                                                <h3 class="table-title">Enterprise</h3>
                                                <table class="reportable">
                                                    <thead>
                                                        <tr>
                                                            <th>Items</th>
                                                            <th class="text-center">File Upload</th>
                                                            <th class="text-center">EXPIRED</th>
                                                            <th class="text-center">1-30 DAYS</th>
                                                            <th class="text-center">30-90 DAYS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                    					                    $selectEnterprise = mysqli_query( $conn,"WITH RECURSIVE cte (type, item, total_uploaded, sum_expired, sum_expired30, sum_expired90) AS
                                                                (
                                                                    SELECT
                                                                    type,
                                                                	CASE
                                                                		WHEN type = 1 THEN 'Regulatory'
                                                                		WHEN type = 2 THEN 'Other'
                                                                		WHEN type = 3 THEN 'Certification'
                                                                		WHEN type = 4 THEN 'Accreditation'
                                                                	END AS item,
                                                                	COUNT(*) AS total_uploaded,
                                                                	COALESCE(SUM(expired), 0) AS sum_expired,
                                                                	COALESCE(SUM(expired30), 0) AS sum_expired30,
                                                                	COALESCE(SUM(expired90), 0) AS sum_expired90
                                                                	FROM (
                                                                		SELECT
                                                                	    table_entities AS type,
                                                                		CASE 
                                                                		    WHEN
                                                                		    	expiry_date IS NULL
                                                                		        OR LENGTH(expiry_date) = 0 
                                                                		        OR DATE(expiry_date) < CURDATE()
                                                                		    THEN 1
                                                                		    ELSE 0
                                                                		END AS expired,
                                                                		CASE 
                                                                		    WHEN
                                                                		    	expiry_date IS NOT NULL
                                                                		        AND LENGTH(expiry_date) > 0
    		                                                                    AND expiry_date BETWEEN CURDATE() AND CURDATE() - INTERVAL 30 DAY
                                                                		    THEN 1 
                                                                		    ELSE 0 
                                                                		END AS expired30,
                                                                		CASE 
                                                                		    WHEN
                                                                		    	expiry_date IS NOT NULL
                                                                		        AND LENGTH(expiry_date) > 0
    		                                                                    AND expiry_date BETWEEN CURDATE() - INTERVAL 31 DAY AND CURDATE() - INTERVAL 90 DAY
                                                                		    THEN 1
                                                                		    ELSE 0
                                                                		END AS expired90
                                                                
                                                                		FROM tblFacilityDetails_registration 
                                                                
                                                                		WHERE ownedby = $switch_user_id
                                                                		AND table_entities != 2
                                                                	) AS o1
                                                                
                                                                	GROUP BY o1.type
                                                                    
                                                                    UNION ALL
                                                                    
                                                                    SELECT
                                                                    0 AS type,
                                                                	'Record' AS item,
                                                                	COUNT(*) AS total_uploaded,
                                                                	COALESCE(SUM(expired), 0) AS sum_expired,
                                                                	COALESCE(SUM(expired30), 0) AS sum_expired30,
                                                                	COALESCE(SUM(expired90), 0) AS sum_expired90
                                                                	FROM (
                                                                		SELECT
                                                                		CASE 
                                                                		    WHEN
                                                                		    	DocumentDueDate IS NULL
                                                                		        OR LENGTH(DocumentDueDate) = 0 
                                                                		        OR DATE(DocumentDueDate) < CURDATE()
                                                                		    THEN 1
                                                                		    ELSE 0
                                                                		END AS expired,
                                                                		CASE 
                                                                		    WHEN
                                                                		    	DocumentDueDate IS NOT NULL
                                                                		        AND LENGTH(DocumentDueDate) > 0
    		                                                                    AND DocumentDueDate BETWEEN CURDATE() AND CURDATE() - INTERVAL 30 DAY
                                                                		    THEN 1 
                                                                		    ELSE 0 
                                                                		END AS expired30,
                                                                		CASE 
                                                                		    WHEN
                                                                		    	DocumentDueDate IS NOT NULL
                                                                		        AND LENGTH(DocumentDueDate) > 0
    		                                                                    AND DocumentDueDate BETWEEN CURDATE() - INTERVAL 31 DAY AND CURDATE() - INTERVAL 90 DAY
                                                                		    THEN 1
                                                                		    ELSE 0
                                                                		END AS expired90
                                                                		FROM tblEnterpiseDetails_Records
                                                                
                                                                		WHERE user_cookies = $switch_user_id
                                                                	) AS o2
                                                                )
                                                                SELECT 
                                                                type, item, total_uploaded, sum_expired, sum_expired30, sum_expired90
                                                                FROM cte
                                                                
                                                                ORDER BY cte.item" );
                    					                    if ( mysqli_num_rows($selectEnterprise) > 0 ) {
                    					                    	while($rowEnterprise = mysqli_fetch_array($selectEnterprise)) {
                    					                    	    
                    					                    	    echo '<tr>
                                                                        <td>'.$rowEnterprise["item"].'</td>
                                                                        <td class="text-center" href="#modalFileUploadOther" data-toggle="modal" onclick="btnFileUploadOther('.$rowEnterprise["type"].', 1, 1)">'.$rowEnterprise["total_uploaded"].'</td>
                                                                        <td class="text-center" href="#modalFileUploadOther" data-toggle="modal" onclick="btnFileUploadOther('.$rowEnterprise["type"].', 1, 2)">'.$rowEnterprise["sum_expired"].'</td>
                                                                        <td class="text-center" href="#modalFileUploadOther" data-toggle="modal" onclick="btnFileUploadOther('.$rowEnterprise["type"].', 1, 3)">'.$rowEnterprise["sum_expired30"].'</td>
                                                                        <td class="text-center" href="#modalFileUploadOther" data-toggle="modal" onclick="btnFileUploadOther('.$rowEnterprise["type"].', 1, 4)">'.$rowEnterprise["sum_expired90"].'</td>
                                                                    </tr>';
                    					                    	}
                    		                            	}
                                                        ?>
                                                    </tbody>
                                                </table>
                                                
                                                <h3 class="table-title">Facility</h3>
                                                <table class="reportable">
                                                    <thead>
                                                        <tr>
                                                            <th>Items</th>
                                                            <th class="text-center">File Upload</th>
                                                            <th class="text-center">EXPIRED</th>
                                                            <th class="text-center">1-30 DAYS</th>
                                                            <th class="text-center">30-90 DAYS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                    					                    $selectFacility = mysqli_query( $conn,"WITH RECURSIVE cte (type, item, total_uploaded, sum_expired, sum_expired30, sum_expired90) AS
                                                                (
                                                                	SELECT
                                                                    1 AS type,
                                                                	'Accreditation' AS item,
                                                                	COUNT(*) AS total_uploaded,
                                                                	COALESCE(SUM(expired), 0) AS sum_expired,
                                                                	COALESCE(SUM(expired30), 0) AS sum_expired30,
                                                                	COALESCE(SUM(expired90), 0) AS sum_expired90
                                                                	FROM (
                                                                		SELECT
                                                                		CASE 
                                                                		    WHEN
                                                                		    	Expiration_Date_Type_Accreditation IS NULL
                                                                		        OR LENGTH(Expiration_Date_Type_Accreditation) = 0 
                                                                		        OR DATE(Expiration_Date_Type_Accreditation) < CURDATE()
                                                                		    THEN 1
                                                                		    ELSE 0
                                                                		END AS expired,
                                                                		CASE 
                                                                		    WHEN
                                                                		    	Expiration_Date_Type_Accreditation IS NOT NULL
                                                                		        AND LENGTH(Expiration_Date_Type_Accreditation) > 0
    		                                                                    AND Expiration_Date_Type_Accreditation BETWEEN CURDATE() AND CURDATE() - INTERVAL 30 DAY
                                                                		    THEN 1 
                                                                		    ELSE 0 
                                                                		END AS expired30,
                                                                		CASE 
                                                                		    WHEN
                                                                		    	Expiration_Date_Type_Accreditation IS NOT NULL
                                                                		        AND LENGTH(Expiration_Date_Type_Accreditation) > 0
    		                                                                    AND Expiration_Date_Type_Accreditation BETWEEN CURDATE() - INTERVAL 31 DAY AND CURDATE() - INTERVAL 90 DAY
                                                                		    THEN 1
                                                                		    ELSE 0
                                                                		END AS expired90
                                                                		FROM tblFacilityDetails_Accreditation
                                                                
                                                                		WHERE user_cookies = $switch_user_id
                                                                	) a
                                                                
                                                                	UNION ALL
                                                                
                                                                	SELECT
                                                                    2 AS type,
                                                                	'Certification' AS item,
                                                                	COUNT(*) AS total_uploaded,
                                                                	COALESCE(SUM(expired), 0) AS sum_expired,
                                                                	COALESCE(SUM(expired30), 0) AS sum_expired30,
                                                                	COALESCE(SUM(expired90), 0) AS sum_expired90
                                                                	FROM (
                                                                		SELECT
                                                                		CASE 
                                                                		    WHEN
                                                                		    	Expiration_Date_Certification IS NULL
                                                                		        OR LENGTH(Expiration_Date_Certification) = 0 
                                                                		        OR DATE(Expiration_Date_Certification) < CURDATE()
                                                                		    THEN 1
                                                                		    ELSE 0
                                                                		END AS expired,
                                                                		CASE 
                                                                		    WHEN
                                                                		    	Expiration_Date_Certification IS NOT NULL
                                                                		        AND LENGTH(Expiration_Date_Certification) > 0
    		                                                                    AND Expiration_Date_Certification BETWEEN CURDATE() AND CURDATE() - INTERVAL 30 DAY
                                                                		    THEN 1 
                                                                		    ELSE 0 
                                                                		END AS expired30,
                                                                		CASE 
                                                                		    WHEN
                                                                		    	Expiration_Date_Certification IS NOT NULL
                                                                		        AND LENGTH(Expiration_Date_Certification) > 0
    		                                                                    AND Expiration_Date_Certification BETWEEN CURDATE() - INTERVAL 31 DAY AND CURDATE() - INTERVAL 90 DAY
                                                                		    THEN 1
                                                                		    ELSE 0
                                                                		END AS expired90
                                                                		FROM tblFacilityDetails_Certification
                                                                
                                                                		WHERE user_cookies = $switch_user_id
                                                                	) c
                                                                
                                                                	UNION ALL
                                                                
                                                                	SELECT
                                                                    3 AS type,
                                                                    'Permits' AS item,
                                                                    COUNT(*) AS total_uploaded,
                                                                    COALESCE(SUM(expired), 0) AS sum_expired,
                                                                    COALESCE(SUM(expired30), 0) AS sum_expired30,
                                                                    COALESCE(SUM(expired90), 0) AS sum_expired90
                                                                    FROM (
                                                                    	SELECT
                                                                    	CASE 
                                                                    	    WHEN
                                                                    	    	Expiration_Date IS NULL
                                                                    	        OR LENGTH(Expiration_Date) = 0 
                                                                    	        OR DATE(Expiration_Date) < CURDATE()
                                                                    	    THEN 1
                                                                    	    ELSE 0
                                                                    	END AS expired,
                                                                    	CASE 
                                                                    	    WHEN
                                                                    	    	Expiration_Date IS NOT NULL
                                                                    	        AND LENGTH(Expiration_Date) > 0
    		                                                                    AND Expiration_Date BETWEEN CURDATE() AND CURDATE() - INTERVAL 30 DAY
                                                                    	    THEN 1 
                                                                    	    ELSE 0 
                                                                    	END AS expired30,
                                                                    	CASE 
                                                                    	    WHEN
                                                                    	    	Expiration_Date IS NOT NULL
                                                                    	        AND LENGTH(Expiration_Date) > 0
    		                                                                    AND Expiration_Date BETWEEN CURDATE() - INTERVAL 31 DAY AND CURDATE() - INTERVAL 90 DAY
                                                                    	    THEN 1
                                                                    	    ELSE 0
                                                                    	END AS expired90
                                                                    	FROM tblFacilityDetails_Permits
                                                                    
                                                                    	WHERE user_cookies = $switch_user_id
                                                                    ) p
                                                                
                                                                	UNION ALL
                                                                    
                                                                    SELECT
                                                                    4 AS type,
                                                                    'Regulatory' AS item,
                                                                    COUNT(*) AS total_uploaded,
                                                                    COALESCE(SUM(expired), 0) AS sum_expired,
                                                                    COALESCE(SUM(expired30), 0) AS sum_expired30,
                                                                    COALESCE(SUM(expired90), 0) AS sum_expired90
                                                                    FROM (
                                                                    	SELECT
                                                                    	CASE 
                                                                    	    WHEN
                                                                    	    	expiry_date IS NULL
                                                                    	        OR LENGTH(expiry_date) = 0 
                                                                    	        OR DATE(expiry_date) < CURDATE()
                                                                    	    THEN 1
                                                                    	    ELSE 0
                                                                    	END AS expired,
                                                                    	CASE 
                                                                    	    WHEN
                                                                    	    	expiry_date IS NOT NULL
                                                                    	        AND LENGTH(expiry_date) > 0
    		                                                                    AND expiry_date BETWEEN CURDATE() AND CURDATE() - INTERVAL 30 DAY
                                                                    	    THEN 1 
                                                                    	    ELSE 0 
                                                                    	END AS expired30,
                                                                    	CASE 
                                                                    	    WHEN
                                                                    	    	expiry_date IS NOT NULL
                                                                    	        AND LENGTH(expiry_date) > 0
    		                                                                    AND expiry_date BETWEEN CURDATE() - INTERVAL 31 DAY AND CURDATE() - INTERVAL 90 DAY
                                                                    	    THEN 1
                                                                    	    ELSE 0
                                                                    	END AS expired90
                                                                    	FROM tblFacilityDetails_registration
                                                                    
                                                                    	WHERE ownedby = $switch_user_id
                                                                    	AND table_entities = 2
                                                                    ) r
                                                                )
                                                                SELECT 
                                                                type, item, total_uploaded, sum_expired, sum_expired30, sum_expired90
                                                                FROM cte
                                                                
                                                                ORDER BY cte.item" );
                    					                    if ( mysqli_num_rows($selectFacility) > 0 ) {
                    					                    	while($rowFacility = mysqli_fetch_array($selectFacility)) {
                    					                    	    
                    					                    	    echo '<tr>
                                                                        <td>'.$rowFacility["item"].'</td>
                                                                        <td class="text-center" href="#modalFileUploadOther" data-toggle="modal" onclick="btnFileUploadOther('.$rowFacility["type"].', 2, 1)">'.$rowFacility["total_uploaded"].'</td>
                                                                        <td class="text-center" href="#modalFileUploadOther" data-toggle="modal" onclick="btnFileUploadOther('.$rowFacility["type"].', 2, 2)">'.$rowFacility["sum_expired"].'</td>
                                                                        <td class="text-center" href="#modalFileUploadOther" data-toggle="modal" onclick="btnFileUploadOther('.$rowFacility["type"].', 2, 3)">'.$rowFacility["sum_expired30"].'</td>
                                                                        <td class="text-center" href="#modalFileUploadOther" data-toggle="modal" onclick="btnFileUploadOther('.$rowFacility["type"].', 2, 4)">'.$rowFacility["sum_expired90"].'</td>
                                                                    </tr>';
                    					                    	}
                    		                            	}
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php
                                                $percentage = number_format($compliance_overall / $compliance_count, 2);
                                                if($percentage > 95){ $color = "#006400"; }
                                                elseif ($percentage < 95 AND $percentage > 74 ){ $color = "#FF8C00"; }
                                                else{ $color = "#CD5C5C"; }
                                            ?>
                                            <div style="width:100%; height:270px; text-align:center; border:solid white 1px; padding:20px; background-color:#dde0e3;">
                                                <div class="piereporting animate" style="--p:<?php echo $percentage; ?>;--c:<?php echo $color; ?>"> <?php echo $percentage; ?>%</div>
                                                <h5>Overall Compliance %</h5>
                                                <br/>
                                                <ul class="Legend">
                                                    <?php
                                                        if ($current_client == 1) {
                                                            echo '<li class="Legend-item">
                                                                <span class="Legend-colorBox" style="background-color: #006400;"></span>
                                                                <span class="Legend-label">On-Track</span>
                                                            </li>
                                                            <li class="Legend-item">
                                                                <span class="Legend-colorBox" style="background-color: #FF8C00;"></span>
                                                                <span class="Legend-label">At-Risk</span>
                                                            </li>
                                                            <li class="Legend-item">
                                                                <span class="Legend-colorBox" style="background-color: #CD5C5C;"></span>
                                                                <span class="Legend-label">Off-Track</span>
                                                            </li>';
                                                        } else {
                                                            echo '<li class="Legend-item">
                                                                <span class="Legend-colorBox" style="background-color: #006400;"></span>
                                                                <span class="Legend-label">Good</span>
                                                            </li>
                                                            <li class="Legend-item">
                                                                <span class="Legend-colorBox" style="background-color: #FF8C00;"></span>
                                                                <span class="Legend-label">Moderate</span>
                                                            </li>
                                                            <li class="Legend-item">
                                                                <span class="Legend-colorBox" style="background-color: #CD5C5C;"></span>
                                                                <span class="Legend-label">Alarming</span>
                                                            </li>';
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
        
                                        <style>
                                            /*Piechart styling for overall compliance percentage*/
                                            @property --p{
                                                syntax: '<number>';
                                                inherits: true;
                                                initial-value: 0;
                                            }
        
                                            .piereporting {
                                                --p:20;
                                                --b:22px;
                                                --c:darkred;
                                                --w:150px;
        
                                                width:var(--w);
                                                aspect-ratio:1;
                                                position:relative;
                                                display:inline-grid;
                                                margin:5px;
                                                place-content:center;
                                                font-size:25px;
                                                font-weight:bold;
                                                font-family:sans-serif;
                                            }
                                            .piereporting:before,
                                            .piereporting:after {
                                                content:"";
                                                position:absolute;
                                                border-radius:50%;
                                            }
                                            .piereporting:before {
                                                inset:0;
                                                background:
                                                radial-gradient(farthest-side,var(--c) 98%,#0000) top/var(--b) var(--b) no-repeat,
                                                conic-gradient(var(--c) calc(var(--p)*1%),#0000 0);
                                                -webkit-mask:radial-gradient(farthest-side,#0000 calc(99% - var(--b)),#000 calc(100% - var(--b)));
                                                mask:radial-gradient(farthest-side,#0000 calc(99% - var(--b)),#000 calc(100% - var(--b)));
                                            }
                                            .piereporting:after {
                                                inset:calc(50% - var(--b)/2);
                                                background:var(--c);
                                                transform:rotate(calc(var(--p)*3.6deg)) translateY(calc(50% - var(--w)/2));
                                            }
                                            .animate {
                                                animation:p 1s .5s both;
                                            }
                                            .no-round:before {
                                                background-size:0 0,auto;
                                            }
                                            .no-round:after {
                                                content:none;
                                            }
                                            @keyframes p {
                                                from{--p:0}
                                            }
                                            /*End of piechart styling*/
        
                                            * {
                                                box-sizing:border-box;
                                            }
        
        
                                            .left, .right {
                                                position:relative;
                                                float:left;
                                                width:50%;
                                                min-width:600px;
                                                margin:auto;
                                                padding:20px;
                                                margin-left:50px;
                                            }
        
                                            .chart, .legend, .titles {
                                                margin:auto;
                                            }
        
                                            .chart {
                                                margin-top:-60px;
                                                border-top:1px solid black;
                                                border-left:1px solid black;
                                                height:450px;
                                                width:300px;
                                                transform: rotate(-90deg);
                                            }
        
                                            .bar {
                                                background:#66C0CC;
                                                margin-top:10px;
                                                /*animation: height 0.8s ease;*/
                                                padding:10px;
                                            }
        
                                            .x-axis {
                                                margin-top:-30px;
                                                padding-bottom:10px;
                                            }
        
                                            .legend {
                                                clear:both;
                                                color:#66C0CC;
                                                width:450px;
                                                div {
                                                    float:left;
                                                    margin-left:10px;
                                                }
                                            }
        
                                            .titles {
                                                clear:both;
                                                width:450px;
                                                margin-top:-60px;
                                                div {
                                                    float:left;
                                                    margin-left:10px;
                                                }
                                            }
        
                                            @keyframes height {
                                                0% {width:0;}
                                            }
        
                                            /*Legend Styling*/
                                            .Legend-colorBox {
                                                width: 1.5rem;
                                                height: 1.5rem;
                                                display: inline-block;
                                                background-color: blue;
                                            }
                                            .Legend-item{
                                                display:inline;
                                                margin-left:30px;
                                            }
                                        </style>
                                <?php } ?>
                                <div class="col-md-8" id="dashboardData" style="min-height: 300px;">
                                    <div class="panel-group accordion" id="parent"></div>
                                </div>
                            </div>   

                            <?php if($switch_user_id == 1649 OR $switch_user_id == 1) { ?>
                                <div class="tab-pane" id="com_report">
                                    <?php
                                        if($switch_user_id == 1649 OR $switch_user_id == 1) {
                                            
                                            $sql_Collab = "";
                                            if ($collabUser == 1) {
                                                $sql_Collab = " AND LENGTH(collaborator_id) > 0 AND collaborator_id LIKE '%\"$current_userEmployeeID\"%' ";
                                            }
                                            
                                            echo '<ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#nm_compliance" data-toggle="tab">Compliance</a>
                                                </li>
                                                <li>
                                                    <a href="#nm_review" data-toggle="tab">Annual Review</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="nm_compliance">
                                                    <table class="table table-bordered table-hover">
                                                        <thead class="bg-primary">
                                                            <tr>
                                                                <th>Requirements</th>
                                                                <th>Action Items</th>
                                                                <th>Frequency</th>
                                                                <th class="text-center" style="width: 130px;">Uploaded Files</th>
                                                                <th style="width: 175px;"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>';
            
                                                            $hasLibrary = mysqli_query( $conn,"SELECT ID FROM tbl_library WHERE user_id = $switch_user_id" );
                                                            $resultCompliance = mysqli_query( $conn,"
                                                                SELECT
                                                                *
                                                                FROM
                                                                (
                                                                    SELECT
                                                                    r.mainID,
                                                                    r.portal_userID,
                                                                    r.parentID,
                                                                    r.childIDs,
                                                                    r.type,
                                                                    r.free_access,
                                                                    r.parentCollab,
                                                                    r.parentName,
                                                                    r.points,
                                                                    com.ID AS com_ID,
                                                                    com.user_id AS com_user_id,
                                                                    com.parent_id AS com_parent_id,
                                                                    com.child_id AS com_child_id,
                                                                    com.compliant AS com_compliant,
                                                                    com.frequency AS com_frequency,
                                                                    com.schedule AS com_schedule,
                                                                    com.filetype AS com_filetype,
                                                                    com.files AS com_files,
                                                                    com.requirements AS com_requirements,
                                                                    com.action_items AS com_action_items
                                                                
                                                                    FROM (
                                                                        SELECT 
                                                                        ID AS mainID,
                                                                        portal_user AS portal_userID,
                                                                        parent_id AS parentID,
                                                                        child_id AS childIDs,
                                                                        type AS type,
                                                                        free_access AS free_access,
                                                                        collaborator_id AS parentCollab,
                                                                        name AS parentName,
                                                                        points AS points
                                                                        FROM tbl_library
                                                                
                                                                        WHERE deleted = 0
                                                                        AND user_id = $switch_user_id
                                                                        AND parent_id = 0
                                                                        $sql_Collab
                                                                
                                                                        UNION ALL
                                                                
                                                                        SELECT 
                                                                        ID AS mainID,
                                                                        portal_user AS portal_userID,
                                                                        parent_id AS parentID,
                                                                        child_id AS childIDs,
                                                                        type AS type,
                                                                        free_access AS free_access,
                                                                        collaborator_id AS parentCollab,
                                                                        name AS parentName,
                                                                        points AS points
                                                                        FROM tbl_library
                                                                
                                                                        WHERE deleted = 0
                                                                        AND user_id = $switch_user_id
                                                                        AND parent_id > 0
                                                                        AND parent_id IN (
                                                                            SELECT DISTINCT ID FROM tbl_library WHERE deleted = 0 AND user_id = $switch_user_id
                                                                        )
                                                                    ) r
                                                                
                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_library_compliance 
                                                                        WHERE parent_id = 0 
                                                                        AND deleted = 0
                                                                        AND compliant = 0
                                                                    ) AS com
                                                                    ON r.mainID = com.library_id
                                                                
                                                                    -- GROUP BY r.mainID
                                                                
                                                                    ORDER BY r.mainID
                                                                ) rr
                                                                
                                                                WHERE rr.com_ID IS NOT NULL
                                                            " );
                                                            if ( mysqli_num_rows($resultCompliance) > 0 ) {
                                                                while($rowComplinace = mysqli_fetch_array($resultCompliance)) {
                                                                    $compliance_ID = $rowComplinace["com_ID"];
                                                                    $compliance_child_id = $rowComplinace["com_child_id"];
            
                                                                    $compliance_user_id = $rowComplinace["com_user_id"];
                                                                    $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $compliance_user_id " );
                                                                    $rowUser = mysqli_fetch_array($selectUser);
                                                                    $compliance_user = $rowUser["first_name"] .' '. $rowUser["last_name"];
                                                                    if (employerID($compliance_user_id) == 34 AND $user_id != 34) {
                                                                        $compliance_user = 'Compliance';
                                                                    }
            
                                                                    $compliance_frequency = $rowComplinace['com_frequency'];
                                                                    $compliance_schedule_id = $rowComplinace['com_schedule'];
                                                                    $array_schedule_id = explode(", ", $compliance_schedule_id);
                                                                    $days = array(
                                                                        1 => 'Monday',
                                                                        2 => 'Tuesday',
                                                                        3 => 'Wednesday',
                                                                        4 => 'Thursday',
                                                                        5 => 'Friday',
                                                                        6 => 'Saturday',
                                                                        7 => 'Sunday'
                                                                    );
                                                                    $frequency = $compliance_frequency;
                                                                    if ( count($array_schedule_id) == 4 ) {
                                                                        $time = $array_schedule_id[0];
                                                                        $time_f = date_create($time);
                                                                        $day_ms = $array_schedule_id[1];
                                                                        $day_num = $array_schedule_id[2];
                                                                        $month = $array_schedule_id[3];
            
                                                                        if ($compliance_frequency == 1) {             // Daily
                                                                            // $sec = 1000;
                                                                            // $min = 60 * $sec;   // 60,000
                                                                            // $hr = 60 * $min;    // 3,600,000
                                                                            // $day = 24 * $hr;    // 86,4000,000
            
                                                                            // $due_hr = date_format($time,"G") * $hr;
                                                                            // $due_min = date_format($time,"i") * $min;
                                                                            // $due_before = 2 * $hr;
                                                                            // $due = ($due_hr + $due_min) - $due_before;
            
                                                                            // $cur_time = date("G:i:s");
                                                                            // $cur_hr = 1 * $hr;
                                                                            // $cur_min = 1 * $min;
                                                                            // $cur = ($cur_hr + $cur_min) - $due;
            
                                                                            // $frequency = 'Every '. date_format($time,"g:i A") .' daily '. $due_hr .' : '. $due_min .' - '. $due_before .' = '. $due .' | '. $cur_time .' : '. $cur_hr .' - '. $cur_min .' = '. $cur;
                                                                            
                                                                            $frequency = 'Daily';
                                                                            if (!empty($time)) {
                                                                                $frequency = 'Every '. date_format($time_f,"g:i A") .' daily';
                                                                            }
                                                                        } else if ($compliance_frequency == 2) {      // Weekly
            
                                                                            $frequency = 'Weekly';
                                                                            if (!empty($day_ms) AND !empty($time)) {
                                                                                $frequency = 'Every '. $days[$day_ms] .' at '. date_format($time_f,"g:i A");
                                                                            }
                                                                        } else if ($compliance_frequency == 3) {      // Monthly
            
                                                                            $frequency = 'Monthly';
                                                                            if (!empty($day_num) AND !empty($time)) {
                                                                                $frequency = 'Every '. $day_num.date("S", mktime(0, 0, 0, 0, intval($day_num), 0)) .' day of the Month at '. date_format($time_f,"g:i A");
                                                                            }
                                                                        } else if ($compliance_frequency == 4) {      // Yearly
            
                                                                            $frequency = 'Yearly';
                                                                            if (!empty($day_num) AND !empty($time) AND !empty($month)) {
                                                                                $frequency = 'Every '. $day_num.date("S", mktime(0, 0, 0, 0, intval($day_num), 0)) .' day of '. date("F", mktime(0, 0, 0, intval($month)+1, 0, 0)) .' at '. date_format($time_f,"g:i A");
                                                                            }
                                                                        }
                                                                    }
            
                                                                    $filetype = $rowComplinace['com_filetype'];
                                                                    $files = $rowComplinace["com_files"];
                                                                    $files_download = '';
                                                                    $type = 'iframe';
                                                                    $target = '';
                                                                    $file_extension = 'fa-youtube-play';
                                                                    $datafancybox = 'data-fancybox';
                                                                    if (!empty($files)) {
                                                                        if ($filetype == 1) {
                                                                            $fileExtension = fileExtension($files);
                                                                            $src = $fileExtension['src'];
                                                                            $embed = $fileExtension['embed'];
                                                                            $type = $fileExtension['type'];
                                                                            $file_extension = $fileExtension['file_extension'];
                                                                            $url = $base_url.'uploads/library/';
            
                                                                            $files = $src.$url.rawurlencode($files).$embed;
                                                                            $files_download = 'data-caption="&lt;a href=&quot;'.$url.rawurlencode($files).'&quot; target=&quot;_blank&quot; &gt; Download &lt;/a&gt; "';
                                                                        } else if ($filetype == 3) {
                                                                            $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                            $file_extension = 'fa-google';
                                                                        } else if ($filetype == 4) {
                                                                            $file_extension = 'fa-strikethrough';
                                                                            $target = '_blank';
                                                                            $datafancybox = '';
                                                                        }
                                                                        $files = '<a href="'.$files.'" data-src="'.$files.'" '.$datafancybox.' '.$files_download.' data-type="'.$type.'" target="'.$target.'">View</a>';
                                                                    }
            
                                                                    $displayLibrary = false;
                                                                    if (mysqli_num_rows($hasLibrary) == 0) {
                                                                        if ($rowComplinace["free_access"] == 1) {
                                                                            $displayLibrary = true;
                                                                        }
                                                                    } else {
                                                                        if ($rowComplinace["free_access"] == 0) {
                                                                            $displayLibrary = true;
                                                                        }
                                                                    }
            
                                                                    if ($displayLibrary == true) {
                                                                        echo '<tr class="bg-white" id="tr_'. $compliance_ID .'">
                                                                            <td>'. htmlentities($rowComplinace["com_requirements"] ?? '') .'</td>
                                                                            <td>'. htmlentities($rowComplinace["com_action_items"] ?? '') .'</td>
                                                                            <td>'. $frequency .'</td>
                                                                            <td class="text-center">'.$files.'</td>
                                                                            <td>
                                                                                <div class="btn-group btn-group-circle">
                                                                                    <a href="#modalComplianceEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnComplianceEdit('. $compliance_ID .')">Edit</a>
                                                                                    <a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnComplianceDelete('. $compliance_ID .')">Delete</a>
                                                                                    <a href="#modalComplianceMore" type="button" class="btn blue btn-sm" data-toggle="modal" onclick="btnComplianceMore('.$compliance_ID.')">Action</a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>';
                                                                    }
            
                                                                    if (!empty($compliance_child_id)) {
                                                                        $array_child_id = explode(", ", $compliance_child_id);
                                                                        foreach ($array_child_id as $value) {
                                                                            $resultComplianceItem = mysqli_query( $conn,"SELECT * FROM tbl_library_compliance WHERE deleted = 0 AND ID = $value " );
                                                                            if ( mysqli_num_rows($resultComplianceItem) > 0 ) {
                                                                                while($rowComplinaceItem = mysqli_fetch_array($resultComplianceItem)) {
                                                                                    $compliance_ID = $rowComplinaceItem["ID"];
                                                                                    $compliance_parent_id = $rowComplinaceItem["parent_id"];
                                                                                    $compliance_comment = $rowComplinaceItem["comment"];
                                                                                    $compliance_remark = $rowComplinaceItem["remark"];
            
                                                                                    $compliance_user_id = $rowComplinaceItem["user_id"];
                                                                                    $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $compliance_user_id " );
                                                                                    $rowUser = mysqli_fetch_array($selectUser);
                                                                                    $compliance_user = $rowUser["first_name"] .' '. $rowUser["last_name"];
                                                                                    if (employerID($compliance_user_id) == 34 AND $user_id != 34) {
                                                                                        $compliance_user = 'Compliance';
                                                                                    }
            
                                                                                    $filetype = $rowComplinaceItem['filetype'];
                                                                                    $files = $rowComplinaceItem["files"];
                                                                                    $files_download = '';
                                                                                    $type = 'iframe';
                                                                                    $file_extension = 'fa-youtube-play';
                                                                                    $datafancybox = 'data-fancybox';
                                                                                    if (!empty($files)) {
                                                                                        if ($filetype == 1) {
                                                                                            $fileExtension = fileExtension($files);
                                                                                            $src = $fileExtension['src'];
                                                                                            $embed = $fileExtension['embed'];
                                                                                            $type = $fileExtension['type'];
                                                                                            $file_extension = $fileExtension['file_extension'];
                                                                                            $url = $base_url.'uploads/library/';
            
                                                                                            $files = $src.$url.rawurlencode($files).$embed;
                                                                                            $files_download = 'data-caption="&lt;a href=&quot;'.$url.rawurlencode($files).'&quot; target=&quot;_blank&quot; &gt; Download &lt;/a&gt; "';
                                                                                        } else if ($filetype == 3) {
                                                                                            $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                                            $file_extension = 'fa-google';
                                                                                        } else if ($filetype == 4) {
                                                                                            $file_extension = 'fa-strikethrough';
                                                                                            $target = '_blank';
                                                                                            $datafancybox = '';
                                                                                        }
                                                                                        $files = '<a href="'.$files.'" data-src="'.$files.'" '.$datafancybox.' '.$files_download.' data-type="'.$type.'" target="'.$target.'">View</a>';
                                                                                    }
            
                                                                                    $compliance_type = $rowComplinaceItem["type"];
                                                                                    $ctype = array(
                                                                                        0 => 'Observed',
                                                                                        1 => 'Performed',
                                                                                        2 => 'Verified',
                                                                                        3 => 'Reviewed'
                                                                                    );
            
                                                                                    $compliance_last_modified = $rowComplinaceItem["last_modified"];
                                                                                    $compliance_last_modified = new DateTime($compliance_last_modified);
                                                                                    $compliance_last_modified = $compliance_last_modified->format('M d, Y');
            
                                                                                    $displayLibrary = false;
                                                                                    if (mysqli_num_rows($hasLibrary) == 0) {
                                                                                        if ($rowComplinaceItem["free_access"] == 1) {
                                                                                            $displayLibrary = true;
                                                                                        }
                                                                                    } else {
                                                                                        if ($rowComplinaceItem["free_access"] == 0) {
                                                                                            $displayLibrary = true;
                                                                                        }
                                                                                    }
            
                                                                                    if ($displayLibrary == true) {
                                                                                        echo '<tr id="tr_'. $compliance_ID .'" class="bg-grey-silver child_'.$compliance_parent_id.'">
                                                                                            <td colspan="2">
                                                                                                <strong>'.$compliance_user.'</strong> <i>('.$ctype[$compliance_type].')</i><br>';
            
                                                                                                if (!empty($compliance_comment)) { echo '<span class="text-muted">'.htmlentities($compliance_comment ?? '').'</span><br>'; }
                                                                                                
                                                                                                echo '<div class="remark_action">';
                                                                                                    if (!empty($compliance_remark)) {
                                                                                                        if ($compliance_remark == "1") { echo '<span class="text-success">Accepted</span>'; }
                                                                                                        else { echo '<span class="text-danger">'.htmlentities($compliance_remark ?? '').'</span>'; }
                                                                                                    } else {
                                                                                                        echo '<a href="javascript:;" type="button" class="btn btn-sm btn-link" onclick="btnComplianceAccept('. $compliance_ID .')">Accept</a> |
                                                                                                        <a href="javascript:;" type="button" class="btn btn-sm btn-link" onclick="btnComplianceReject('. $compliance_ID .')">Reject</a>';
                                                                                                    }
                                                                                                echo '</div>';
                                                                                                
                                                                                            echo '</td>
                                                                                            <td>Date: <b>'. $compliance_last_modified .'</b></td>
                                                                                            <td class="text-center">'.$files.'</td>
                                                                                            <td>
                                                                                                <div class="btn-group btn-group-circle">
                                                                                                    <a href="#modalComplianceMoreEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnComplianceMoreEdit('. $compliance_ID .')">Edit</a>
                                                                                                    <a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnComplianceDelete('. $compliance_ID .')">Delete</a>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>';
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            
                                                        echo '</tbody>
                                                    </table>
                                                </div> 
                                                <div class="tab-pane" id="nm_review">
                                                    <table class="table table-bordered table-hover">
                                                        <thead class="bg-primary">
                                                            <tr>
                                                                <th>Requirements</th>
                                                                <th>Action Items</th>
                                                                <th style="width: 130px;" class="text-center">File</th>
                                                                <th style="width: 180px;"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>';
            
                                                        $resultReview= mysqli_query( $conn,"
                                                            SELECT
                                                            *
                                                            FROM
                                                            (
                                                                SELECT
                                                                r.mainID,
                                                                r.portal_userID,
                                                                r.parentID,
                                                                r.childIDs,
                                                                r.type,
                                                                r.free_access,
                                                                r.parentCollab,
                                                                r.parentName,
                                                                r.points,
                                                                rev.ID AS rev_ID,
                                                                rev.compliant AS rev_compliant,
                                                                rev.user_id AS rev_user_id,
                                                                rev.parent_id AS rev_parent_id,
                                                                rev.child_id AS rev_child_id,
                                                                rev.filetype AS rev_filetype,
                                                                rev.files AS rev_files,
                                                                rev.title AS rev_title,
                                                                rev.type AS rev_type,
                                                                rev.comment AS rev_comment,
                                                                rev.requirements AS rev_requirements,
                                                                rev.action_items AS rev_action_items,
                                                                rev.template AS rev_template,
                                                                rev.last_modified AS rev_last_modified
             
                                                                FROM (
                                                                    SELECT 
                                                                    ID AS mainID,
                                                                    portal_user AS portal_userID,
                                                                    parent_id AS parentID,
                                                                    child_id AS childIDs,
                                                                    type AS type,
                                                                    free_access AS free_access,
                                                                    collaborator_id AS parentCollab,
                                                                    name AS parentName,
                                                                    points AS points
                                                                    FROM tbl_library
            
                                                                    WHERE deleted = 0
                                                                    AND user_id = $switch_user_id
                                                                    AND parent_id = 0
                                                                    $sql_Collab
            
                                                                    UNION ALL
            
                                                                    SELECT 
                                                                    ID AS mainID,
                                                                    portal_user AS portal_userID,
                                                                    parent_id AS parentID,
                                                                    child_id AS childIDs,
                                                                    type AS type,
                                                                    free_access AS free_access,
                                                                    collaborator_id AS parentCollab,
                                                                    name AS parentName,
                                                                    points AS points
                                                                    FROM tbl_library
            
                                                                    WHERE deleted = 0
                                                                    AND user_id = $switch_user_id
                                                                    AND parent_id > 0
                                                                    AND parent_id IN (
                                                                        SELECT DISTINCT ID FROM tbl_library WHERE deleted = 0 AND user_id = $switch_user_id
                                                                    )
                                                                ) r
            
                                                                LEFT JOIN (
                                                                    SELECT
                                                                    *
                                                                    FROM tbl_library_review 
                                                                    WHERE parent_id = 0 
                                                                    AND is_deleted = 0
                                                                    AND compliant = 0
                                                                ) AS rev
                                                                ON r.mainID = rev.library_id
            
                                                                -- GROUP BY r.mainID
            
                                                                ORDER BY r.mainID
                                                            ) rr
            
            
                                                            WHERE rr.rev_ID IS NOT NULL
                                                        " );
                                                        if ( mysqli_num_rows($resultReview) > 0 ) {
                                                            while($rowReview = mysqli_fetch_array($resultReview)) {
                                                                $review_ID = $rowReview["rev_ID"];
                                                                $review_compliant = $rowReview["rev_compliant"];
                                                                $review_title = htmlentities($rowReview["rev_title"] ?? '');
                                                                $review_child_id = $rowReview["rev_child_id"];
                                                                $review_action_items = $rowReview["rev_action_items"];
                                                                $review_requirements = $rowReview["rev_requirements"];
            
                                                                $review_user_id = $rowReview["rev_user_id"];
                                                                $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $review_user_id " );
                                                                $rowUser = mysqli_fetch_array($selectUser);
                                                                $review_name = $rowUser["first_name"] .' '. $rowUser["last_name"];
                                                                if (employerID($review_user_id) == 34 AND $user_id != 34) {
                                                                    $review_name = 'Compliance';
                                                                }
            
                                                                $review_template = $rowReview["rev_template"];
                                                                if ($review_template == 1) {
                                                                    $review_comment = "No Changes Noted During Review";
                                                                } else {
                                                                    $review_comment = $rowReview["rev_comment"];
                                                                }
            
                                                                $review_type = $rowReview["rev_type"];
                                                                $rtype = array(
                                                                    0 => 'Observed',
                                                                    1 => 'Corrected',
                                                                    2 => 'Verified',
                                                                    3 => 'Approved',
                                                                    4 => 'Reviewed'
                                                                );
            
                                                                $review_last_modified = $rowReview["rev_last_modified"];
                                                                $review_last_modified = new DateTime($review_last_modified);
                                                                $review_last_modified = $review_last_modified->format('M d, Y');
            
                                                                $files = '';
                                                                $type = 'iframe';
                                                                $file_extension = 'fa-youtube-play';
                                                                $datafancybox = 'data-fancybox';
                                                                if (!empty($rowReview["rev_files"])) {
                                                                    $arr_filename = explode(' | ', $rowReview["rev_files"]);
                                                                    $arr_filetype = explode(' | ', $rowReview["rev_filetype"]);
                                                                    $str_filename = '';
            
                                                                    foreach($arr_filename as $val_filename) {
                                                                        $str_filename = $val_filename;
                                                                    }
                                                                    foreach($arr_filetype as $val_filetype) {
                                                                        $str_filetype = $val_filetype;
                                                                    }
            
                                                                    $files = $str_filename;
                                                                    $files_download = '';
                                                                    if ($str_filetype == 1) {
                                                                        $fileExtension = fileExtension($str_filename);
                                                                        $src = $fileExtension['src'];
                                                                        $embed = $fileExtension['embed'];
                                                                        $type = $fileExtension['type'];
                                                                        $file_extension = $fileExtension['file_extension'];
                                                                        $url = $base_url.'uploads/library/';
            
                                                                        $files = $src.$url.rawurlencode($str_filename).$embed;
                                                                        $files_download = 'data-caption="&lt;a href=&quot;'.$url.rawurlencode($str_filename).'&quot; target=&quot;_blank&quot; &gt; Download &lt;/a&gt; "';
                                                                    } else if ($str_filetype == 3) {
                                                                        $files = preg_replace('#[^/]*$#', '', $str_filename).'preview';
                                                                        $file_extension = 'fa-google';
                                                                    } else if ($str_filetype == 4) {
                                                                        $file_extension = 'fa-strikethrough';
                                                                        $target = '_blank';
                                                                        $datafancybox = '';
                                                                    }
                                                                    $files = '<a href="'.$files.'" data-src="'.$files.'" '.$datafancybox.' '.$files_download.' data-type="'.$type.'" target="'.$target.'">View</a>';
                                                                }
            
                                                                $displayLibrary = false;
                                                                if (mysqli_num_rows($hasLibrary) == 0) {
                                                                    if ($rowReview["free_access"] == 1) {
                                                                        $displayLibrary = true;
                                                                    }
                                                                } else {
                                                                    if ($rowReview["free_access"] == 0) {
                                                                        $displayLibrary = true;
                                                                    }
                                                                }
            
                                                                $library_ID = $rowReview["mainID"];
            
                                                                if ($displayLibrary == true) {
                                                                    echo '<tr class="bg-white" id="tr_'.$review_ID.'">
                                                                        <td>'.htmlentities($review_requirements ?? '').'</td>
                                                                        <td>'.htmlentities($review_action_items ?? '').'</td>
                                                                        <td class="text-center">'.$files.'</td>
                                                                        <td>
                                                                            <div class="btn-group btn-group-circle">
                                                                                <a href="#modalReviewEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnReviewEdit('.$review_ID.')">Edit</a>
                                                                                <a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnReviewDelete('.$review_ID.', '.$library_ID.')">Delete</a>';
            
                                                                                if ($review_compliant == 0) {
                                                                                    echo '<a href="#modalReviewAction" type="button" class="btn blue btn-sm" data-toggle="modal" onclick="btnReviewAction('.$review_ID.')">Review</a>';
                                                                                }
            
                                                                            echo '</div>
                                                                        </td>
                                                                    </tr>';
                                                                }
            
                                                                if (!empty($review_child_id)) {
                                                                    $array_child_id = explode(", ", $review_child_id);
                                                                    foreach ($array_child_id as $value) {
                                                                        $selectReviewItem = mysqli_query( $conn,"SELECT * FROM tbl_library_review WHERE is_deleted = 0 AND ID=$value" );
                                                                        if ( mysqli_num_rows($selectReviewItem) > 0 ) {
                                                                            while($rowReviewItem = mysqli_fetch_array($selectReviewItem)) {
                                                                                $review_ID = $rowReviewItem["ID"];
                                                                                $review_compliant = $rowReviewItem["compliant"];
                                                                                $review_title = $rowReviewItem["title"];
                                                                                $review_parent_id = $rowReviewItem["parent_id"];
                                                                                $review_child_id = $rowReviewItem["child_id"];
            
                                                                                $review_user_id = $rowReviewItem["user_id"];
                                                                                $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $review_user_id " );
                                                                                $rowUser = mysqli_fetch_array($selectUser);
                                                                                $review_name = $rowUser["first_name"] .' '. $rowUser["last_name"];
                                                                                if (employerID($review_user_id) == 34 AND $user_id != 34) {
                                                                                    $review_name = 'Compliance';
                                                                                }
            
                                                                                $review_template = $rowReviewItem["template"];
                                                                                if ($review_template == 1) {
                                                                                    $review_comment = "No Changes Noted During Review";
                                                                                } else {
                                                                                    $review_comment = $rowReviewItem["comment"];
                                                                                }
                                                                                $review_remark = $rowReviewItem["remark"];
            
                                                                                $review_type = $rowReviewItem["type"];
                                                                                $rtype = array(
                                                                                    0 => 'Observed',
                                                                                    1 => 'Corrected',
                                                                                    2 => 'Verified',
                                                                                    3 => 'Approved',
                                                                                    4 => 'Reviewed'
                                                                                );
            
                                                                                $review_last_modified = $rowReviewItem["last_modified"];
                                                                                $review_last_modified = new DateTime($review_last_modified);
                                                                                $review_last_modified = $review_last_modified->format('M d, Y');
            
                                                                                $files = '';
                                                                                $type = 'iframe';
                                                                                $file_extension = 'fa-youtube-play';
                                                                                $datafancybox = 'data-fancybox';
                                                                                if (!empty($rowReferences["files"])) {
                                                                                    $arr_filename = explode(' | ', $rowReviewItem["files"]);
                                                                                    $arr_filetype = explode(' | ', $rowReviewItem["filetype"]);
                                                                                    $str_filename = '';
            
                                                                                    foreach($arr_filename as $val_filename) {
                                                                                        $str_filename = $val_filename;
                                                                                    }
                                                                                    foreach($arr_filetype as $val_filetype) {
                                                                                        $str_filetype = $val_filetype;
                                                                                    }
            
                                                                                    $files = $str_filename;
                                                                                    $files_download = '';
                                                                                    if ($str_filetype == 1) {
                                                                                        $fileExtension = fileExtension($str_filename);
                                                                                        $src = $fileExtension['src'];
                                                                                        $embed = $fileExtension['embed'];
                                                                                        $type = $fileExtension['type'];
                                                                                        $file_extension = $fileExtension['file_extension'];
                                                                                        $url = $base_url.'uploads/library/';
            
                                                                                        $files = $src.$url.rawurlencode($str_filename).$embed;
                                                                                        $files_download = 'data-caption="&lt;a href=&quot;'.$url.rawurlencode($str_filename).'&quot; target=&quot;_blank&quot; &gt; Download &lt;/a&gt; "';
                                                                                    } else if ($str_filetype == 3) {
                                                                                        $files = preg_replace('#[^/]*$#', '', $str_filename).'preview';
                                                                                        $file_extension = 'fa-google';
                                                                                    } else if ($str_filetype == 4) {
                                                                                        $file_extension = 'fa-strikethrough';
                                                                                        $target = '_blank';
                                                                                        $datafancybox = '';
                                                                                    }
                                                                                    $files = '<a href="'.$files.'" data-src="'.$files.'" '.$datafancybox.' '.$files_download.' data-type="'.$type.'" target="'.$target.'">View</a>';
                                                                                }
            
                                                                                $displayLibrary = false;
                                                                                if (mysqli_num_rows($hasLibrary) == 0) {
                                                                                    if ($rowReviewItem["free_access"] == 1) {
                                                                                        $displayLibrary = true;
                                                                                    }
                                                                                } else {
                                                                                    if ($rowReviewItem["free_access"] == 0) {
                                                                                        $displayLibrary = true;
                                                                                    }
                                                                                }
            
                                                                                if ($displayLibrary == true) {
                                                                                    echo '<tr id="tr_'. $review_ID .'" class="bg-grey-silver child_'.$review_parent_id.'">
                                                                                        <td colspan="2">
                                                                                            <b>'.$review_name.'</b> <i>('.$rtype[$review_type].')</i> | '.$review_last_modified.'<br>';
            
                                                                                            if (!empty($review_title)) { echo '<span class="text-muted">'.htmlentities($review_title ?? '').'</span><br>'; }
                                                                                            if (!empty($review_comment)) { echo '<span class="text-muted">'.htmlentities($review_comment ?? '').'</span><br>'; }
                                                                                            
                                                                                            echo '<div class="remark_action">';
                                                                                                if (!empty($review_remark)) {
                                                                                                    if ($review_remark == "1") { echo '<span class="text-success">Accepted!</span>'; }
                                                                                                    else { echo '<span class="text-danger">'.htmlentities($review_remark ?? '').'</span>'; }
                                                                                                } else {
                                                                                                    echo '<a href="javascript:;" type="button" class="btn btn-sm btn-link" onclick="btnReviewAccept('. $review_ID .')">Accept</a> |
                                                                                                    <a href="javascript:;" type="button" class="btn btn-sm btn-link" onclick="btnReviewReject('. $review_ID .')">Reject</a>';
                                                                                                }
                                                                                            echo '</div>
                                                                                        </td>
                                                                                        <td class="text-center">'.$files.'</td>
                                                                                        <td>
                                                                                            <div class="btn-group btn-group-circle">
                                                                                                <a href="#modalReviewActionEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnReviewActionEdit('.$review_ID.')">Edit</a>
                                                                                                <a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnReviewDelete('.$review_ID.', '.$library_ID.')">Delete</a>';
            
                                                                                                if ($review_compliant == 0) {
                                                                                                    echo '<a href="#modalReviewMore" type="button" class="btn blue btn-sm" data-toggle="modal" onclick="btnReviewMore('.$review_ID.')">Action</a>';
                                                                                                }
                                                                                            
                                                                                            echo '</div>
                                                                                        </td>
                                                                                    </tr>';
                                                                                }
            
                                                                                if (!empty($review_child_id)) {
                                                                                    $array_child_id = explode(", ", $review_child_id);
                                                                                    foreach ($array_child_id as $value) {
                                                                                        $selectReviewItem = mysqli_query( $conn,"SELECT * FROM tbl_library_review WHERE is_deleted = 0 AND ID=$value" );
                                                                                        if ( mysqli_num_rows($selectReviewItem) > 0 ) {
                                                                                            while($rowReviewItem = mysqli_fetch_array($selectReviewItem)) {
                                                                                                $review_ID = $rowReviewItem["ID"];
                                                                                                $review_compliant = $rowReviewItem["compliant"];
                                                                                                $review_title = $rowReviewItem["title"];
                                                                                                $review_parent_id_action = $rowReviewItem["parent_id"];
                                                                                                $review_child_id_action = $rowReviewItem["child_id"];
            
                                                                                                $review_user_id = $rowReviewItem["user_id"];
                                                                                                $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $review_user_id " );
                                                                                                $rowUser = mysqli_fetch_array($selectUser);
                                                                                                $review_name = $rowUser["first_name"] .' '. $rowUser["last_name"];
                                                                                                if (employerID($review_user_id) == 34 AND $user_id != 34) {
                                                                                                    $review_name = 'Compliance';
                                                                                                }
            
                                                                                                $review_template = $rowReviewItem["template"];
                                                                                                if ($review_template == 1) {
                                                                                                    $review_comment = "No Changes Noted During Review";
                                                                                                } else {
                                                                                                    $review_comment = $rowReviewItem["comment"];
                                                                                                }
                                                                                                $review_remark = $rowReviewItem["remark"];
            
                                                                                                $review_type = $rowReviewItem["type"];
                                                                                                $rtype = array(
                                                                                                    0 => 'Observed',
                                                                                                    1 => 'Corrected',
                                                                                                    2 => 'Verified',
                                                                                                    3 => 'Approved',
                                                                                                    4 => 'Reviewed'
                                                                                                );
            
                                                                                                $review_last_modified = $rowReviewItem["last_modified"];
                                                                                                $review_last_modified = new DateTime($review_last_modified);
                                                                                                $review_last_modified = $review_last_modified->format('M d, Y');
            
                                                                                                $files = '';
                                                                                                $type = 'iframe';
                                                                                                $file_extension = 'fa-youtube-play';
                                                                                                $datafancybox = 'data-fancybox';
                                                                                                if (!empty($rowReferences["files"])) {
                                                                                                    $arr_filename = explode(' | ', $rowReviewItem["files"]);
                                                                                                    $arr_filetype = explode(' | ', $rowReviewItem["filetype"]);
                                                                                                    $str_filename = '';
            
                                                                                                    foreach($arr_filename as $val_filename) {
                                                                                                        $str_filename = $val_filename;
                                                                                                    }
                                                                                                    foreach($arr_filetype as $val_filetype) {
                                                                                                        $str_filetype = $val_filetype;
                                                                                                    }
            
                                                                                                    $files = $str_filename;
                                                                                                    $files_download = '';
                                                                                                    if ($str_filetype == 1) {
                                                                                                        $fileExtension = fileExtension($str_filename);
                                                                                                        $src = $fileExtension['src'];
                                                                                                        $embed = $fileExtension['embed'];
                                                                                                        $type = $fileExtension['type'];
                                                                                                        $file_extension = $fileExtension['file_extension'];
                                                                                                        $url = $base_url.'uploads/library/';
            
                                                                                                        $files = $src.$url.rawurlencode($str_filename).$embed;
                                                                                                        $files_download = 'data-caption="&lt;a href=&quot;'.$url.rawurlencode($str_filename).'&quot; target=&quot;_blank&quot; &gt; Download &lt;/a&gt; "';
                                                                                                    } else if ($str_filetype == 3) {
                                                                                                        $files = preg_replace('#[^/]*$#', '', $str_filename).'preview';
                                                                                                        $file_extension = 'fa-google';
                                                                                                    } else if ($str_filetype == 4) {
                                                                                                        $file_extension = 'fa-strikethrough';
                                                                                                        $target = '_blank';
                                                                                                        $datafancybox = '';
                                                                                                    }
                                                                                                    $files = '<a href="'.$files.'" data-src="'.$files.'" '.$datafancybox.' '.$files_download.' data-type="'.$type.'" target="'.$target.'">View</a>';
                                                                                                }
            
                                                                                                $displayLibrary = false;
                                                                                                if (mysqli_num_rows($hasLibrary) == 0) {
                                                                                                    if ($rowReviewItem["free_access"] == 1) {
                                                                                                        $displayLibrary = true;
                                                                                                    }
                                                                                                } else {
                                                                                                    if ($rowReviewItem["free_access"] == 0) {
                                                                                                        $displayLibrary = true;
                                                                                                    }
                                                                                                }
            
                                                                                                if ($displayLibrary == true) {
                                                                                                    echo '<tr id="tr_'. $review_ID .'" class="bg-grey-silver child_'.$review_parent_id.' child_action_'.$review_parent_id_action.'">
                                                                                                        <td colspan="2">
                                                                                                            <b>'.$review_name.'</b> <i>('.$rtype[$review_type].')</i> | '.$review_last_modified.'<br>';
            
                                                                                                            if (!empty($review_title)) { echo '<span class="text-muted">'.htmlentities($review_title ?? '').'</span><br>'; }
                                                                                                            if (!empty($review_comment)) { echo '<span class="text-muted">'.htmlentities($review_comment ?? '').'</span><br>'; }
                                                                                                            
                                                                                                            echo '<div class="remark_action">';
                                                                                                                if (!empty($review_remark)) {
                                                                                                                    if ($review_remark == "1") { echo '<span class="text-success">Accepted!</span>'; }
                                                                                                                    else { echo '<span class="text-danger">'.htmlentities($review_remark ?? '').'</span>'; }
                                                                                                                } else {
                                                                                                                    echo '<a href="javascript:;" type="button" class="btn btn-sm btn-link" onclick="btnReviewAccept('. $review_ID .')">Accept</a> |
                                                                                                                    <a href="javascript:;" type="button" class="btn btn-sm btn-link" onclick="btnReviewReject('. $review_ID .')">Reject</a>';
                                                                                                                }
                                                                                                            echo '</div>
                                                                                                        </td>
                                                                                                        <td class="text-center">'.$files.'</td>
                                                                                                        <td>
                                                                                                            <div class="btn-group btn-group-circle">
                                                                                                                <a href="#modalReviewMoreEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnReviewMoreEdit('.$review_ID.')">Edit</a>
                                                                                                                <a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnReviewDelete('.$review_ID.', '.$library_ID.')">Delete</a>
                                                                                                            </div>
                                                                                                        </td>
                                                                                                    </tr>';
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
            
                                                        echo '</tbody>
                                                    </table>
                                                </div>
                                            </div>';
                                        }
                                    ?>
                                </div>
                                <div class="tab-pane" id="com_poam">
                                    <table class="table table-bordered table-hover">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th>Not Met</th>
                                                <th>Weaknesses</th>
                                                <th>Responsible Office/Organization</th>
                                                <th>Schedule Completion Date</th>
                                                <th>Milestone</th>
                                                <th>Status <small>(Ongoing or Complete)</small></th>
                                                <th style="width: 85px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php
                                                $resultCompliance2 = mysqli_query( $conn,"
                                                    SELECT
                                                    *
                                                    FROM
                                                    (
                                                        SELECT
                                                        r.mainID,
                                                        r.portal_userID,
                                                        r.parentID,
                                                        r.childIDs,
                                                        r.type,
                                                        r.free_access,
                                                        r.parentCollab,
                                                        r.parentName,
                                                        r.points,
                                                        com.ID AS com_ID,
                                                        com.requirements AS com_requirements,
                                                        com.action_items AS com_action_items,
                                                        p.weakness AS p_weakness,
                                                        p.responsible AS p_responsible,
                                                        p.resource AS p_resource,
                                                        p.date_schedule_completion AS p_date_schedule_completion,
                                                        p.milestone AS p_milestone,
                                                        p.identified AS p_identified,
                                                        p.status AS p_status
        
                                                        FROM (
                                                            SELECT 
                                                            ID AS mainID,
                                                            portal_user AS portal_userID,
                                                            parent_id AS parentID,
                                                            child_id AS childIDs,
                                                            type AS type,
                                                            free_access AS free_access,
                                                            collaborator_id AS parentCollab,
                                                            name AS parentName,
                                                            points AS points
                                                            FROM tbl_library
        
                                                            WHERE deleted = 0
                                                            AND user_id = $switch_user_id
                                                            AND parent_id = 0
                                                            $sql_Collab
        
                                                            UNION ALL
        
                                                            SELECT 
                                                            ID AS mainID,
                                                            portal_user AS portal_userID,
                                                            parent_id AS parentID,
                                                            child_id AS childIDs,
                                                            type AS type,
                                                            free_access AS free_access,
                                                            collaborator_id AS parentCollab,
                                                            name AS parentName,
                                                            points AS points
                                                            FROM tbl_library
        
                                                            WHERE deleted = 0
                                                            AND user_id = $switch_user_id
                                                            AND parent_id > 0
                                                            AND parent_id IN (
                                                                SELECT DISTINCT ID FROM tbl_library WHERE deleted = 0 AND user_id = $switch_user_id
                                                            )
                                                        ) r
        
                                                        LEFT JOIN (
                                                            SELECT
                                                            *
                                                            FROM tbl_library_compliance 
                                                            WHERE parent_id = 0 
                                                            AND deleted = 0
                                                            AND compliant = 0
                                                        ) AS com
                                                        ON r.mainID = com.library_id
        
                                                        LEFT JOIN (
                                                            SELECT
                                                            *
                                                            FROM tbl_library_poam 
                                                            WHERE deleted = 0
                                                        ) AS p
                                                        ON p.compliance_id = com.ID
        
                                                        -- GROUP BY r.mainID
        
                                                        ORDER BY r.mainID
                                                    ) rr
        
                                                    WHERE rr.com_ID IS NOT NULL
                                                " );
                                                if ( mysqli_num_rows($resultCompliance2) > 0 ) {
                                                    while($rowComplinace = mysqli_fetch_array($resultCompliance2)) {
                                                        $compliance_ID = $rowComplinace["com_ID"];
        
                                                        $displayLibrary = false;
                                                        if (mysqli_num_rows($hasLibrary) == 0) {
                                                            if ($rowComplinace["free_access"] == 1) {
                                                                $displayLibrary = true;
                                                            }
                                                        } else {
                                                            if ($rowComplinace["free_access"] == 0) {
                                                                $displayLibrary = true;
                                                            }
                                                        }
        
                                                        $status = $rowComplinace["p_status"];
                                                        $status_type = array(
                                                            '' => '-',
                                                            0 => '-',
                                                            1 => 'Ongoing',
                                                            2 => 'Complete'
                                                        );
        
                                                        $milestone = '';
                                                        if (!empty($rowComplinace["p_milestone"])) {
                                                            $milestone = '<a href="#modalViewMilestone" type="button" class="btn btn-sm" data-toggle="modal" onclick="btnViewMilestone('. $compliance_ID .')">View</a>';
                                                        }
        
                                                        if ($displayLibrary == true) {
                                                            echo '<tr class="bg-white" id="tr_poam_'. $compliance_ID.'">
                                                                <td>
                                                                    '.htmlentities($rowComplinace["com_requirements"] ?? '').'<br>
                                                                    <i class="help-block">'.htmlentities($rowComplinace["com_action_items"] ?? '').'</i>
                                                                </td>
                                                                <td>'.htmlentities($rowComplinace["p_weakness"] ?? '').'</td>
                                                                <td>'.htmlentities($rowComplinace["p_responsible"] ?? '').'</td>
                                                                <td>'.htmlentities($rowComplinace["p_date_schedule_completion"] ?? '').'</td>
                                                                <td class="text-center">'.$milestone.'</td>
                                                                <td>'.$status_type[$status].'</td>
                                                                <td class="text-center">
                                                                    <a href="#modalViewPoam" type="button" class="btn btn-success btn-sm" data-toggle="modal" onclick="btnViewPoam('. $compliance_ID .')">View</a>
                                                                </td>
                                                            </tr>';
                                                        }
                                                    }
                                                }
                                            ?>
    
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                            
                            <!-- Nelmar Analytics -->
                            <div class="tab-pane" id="com_analytics">
                                <div class="row widget-row">
                                    <div class="col-md-12">
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                            <h3 class="d-flex justify-content-center">CMMC Percentage</h3>
                                            <div class="widget-thumb-wrap">
                                                <div id="chartMet" style="width: 100%; height: 500px;"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                            <h3 class="d-flex justify-content-center">CMMC Points</h3>
                                            <div class="widget-thumb-wrap">
                                                <div id="chartMet2" style="width: 100%; height: 500px;"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                            <h3 class="d-flex justify-content-center">Compliance</h3>
                                            <div class="widget-thumb-wrap">
                                                <div id="chartdiv4" style="width: 100%; height: 500px;"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                            <h3 class="d-flex justify-content-center">Annual Review</h3>
                                            <div class="widget-thumb-wrap">
                                                <div id="chartdiv3" style="width: 100%; height: 500px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">                                     
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                            <!-- <h3 class="d-flex justify-content-center">Analytics</h3>    -->
                                            <div class="widget-thumb-wrap">
                                                <div id="comchartdiv" style="width: 100%; height: 500px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"> 
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                                            <!-- <h3 class="d-flex justify-content-center">Analytics</h3>-->
                                            <div class="widget-thumb-wrap">
                                                <div id="comchartdiv1" style="width: 100%; height: 500px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div> 
                    <?php } ?>

                    <!-- Item Section -->
                    <div class="modal fade" id="modalArea" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalArea">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title pictogram-align">
                                            New Item in Dashboard
                                            <?php
                                                $pictogram = 'cd_item_add';
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
                                    <div class="modal-body">
                                        <?php
                                            echo '<div class="form-group '; echo $switch_user_id == 1649 ? '':'hide'; echo '">
                                                <label class="col-md-3 control-label">Applicable</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="applicable" onchange="selApplicable(this);">
                                                        <option value="1">Implemented</option>
                                                        <option value="2">Plan to Implement</option>
                                                        <option value="0">Not Applicable</option>
                                                    </select>
                                                    <textarea class="form-control margin-top-15 hide" name="na_reason" placeholder="Your Reason"></textarea>
                                                    <small class="help-block hide">What is your reason?</small>
                                                </div>
                                            </div>
                                            <div class="form-group '; echo $switch_user_id == 1649 ? '':'hide'; echo '">
                                                <label class="col-md-3 control-label">CMMC Points</label>
                                                <div class="col-md-8">
                                                    <input type="number" min="0" class="form-control" name="points" />
                                                </div>
                                            </div>
                                            <div class="form-group '; echo $switch_user_id == 1649 ? '':'hide'; echo '">
                                                <label class="col-md-3 control-label">CMMC Abbreviation</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="code" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Business Type</label>
                                                <div class="col-md-8">';

                                                    if ($current_client == 1) {
                                                        echo '<input type="hidden" class="hide" name="type" value="16" />
                                                        <input type="text" class="form-control" name="type_others" />';
                                                    } else {
                                                        echo '<select class="form-control" name="type" onchange="changedType(this.value)">
                                                            <option value="">Select</option>';

                                                            $resultType = mysqli_query( $conn,"SELECT * FROM tbl_library_type WHERE ID<>16 ORDER BY name" );
                                                            if ( mysqli_num_rows($resultType) > 0 ) {
                                                                while($rowType = mysqli_fetch_array($resultType)) {
                                                                    $type_ID = $rowType["ID"];
                                                                    $type_name = $rowType["name"];

                                                                    echo '<option value="'.$type_ID.'">'.$type_name.'</option>';
                                                                }
                                                            }

                                                            echo '<option value="16">Others</option>
                                                        </select>
                                                        <input type="text" class="form-control hide type_others" name="type_others" placeholder="Leave Blank or Enter Specific Business Type" style="margin-top: 15px;" />
                                                        <span class="help-block" style="margin: 0;">Services / Product</span>';
                                                    }

                                                echo '</div>
                                            </div>
                                            <div class="form-group '; echo $current_client == 1 ? 'hide':''; echo '">
                                                <label class="col-md-3 control-label">Category</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="category" onchange="changedCategory(this.value)">
                                                        <option value="">Select</option>';

                                                        $resultCategory = mysqli_query( $conn,"SELECT * FROM tbl_library_category WHERE ID<>9 ORDER BY name" );
                                                        if ( mysqli_num_rows($resultCategory) > 0 ) {
                                                            while($rowCategory = mysqli_fetch_array($resultCategory)) {
                                                                $category_ID = $rowCategory["ID"];
                                                                $category_name = $rowCategory["name"];

                                                                echo '<option value="'.$category_ID.'">'.$category_name.'</option>';
                                                            }
                                                        }

                                                        echo '<option value="9">Others</option>
                                                    </select>
                                                    <input type="text" class="form-control hide category_others" name="category_others" placeholder="Leave Blank or Enter Category Name" style="margin-top: 15px;" />
                                                </div>
                                            </div>
                                            <div class="form-group '; echo $current_client == 1 ? 'hide':''; echo '">
                                                <label class="col-md-3 control-label">Scope</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="scope" onchange="changedScope(this.value)">
                                                        <option value="">Select</option>';

                                                        $resultScope = mysqli_query( $conn,"SELECT * FROM tbl_library_scope WHERE ID<>5 ORDER BY name" );
                                                        if ( mysqli_num_rows($resultScope) > 0 ) {
                                                            while($rowScope = mysqli_fetch_array($resultScope)) {
                                                                $scope_ID = $rowScope["ID"];
                                                                $scope_name = $rowScope["name"];

                                                                echo '<option value="'.$scope_ID.'">'.$scope_name.'</option>';
                                                            }
                                                        }

                                                        echo '<option value="5">Others</option>
                                                    </select>
                                                    <input type="text" class="form-control hide scope_others" name="scope_others" placeholder="Leave Blank or Enter Scope Name" style="margin-top: 15px;" />
                                                    <span class="help-block" style="margin: 0;">Certification / Accreditation / Regulatory</span>
                                                </div>
                                            </div>
                                            <div class="form-group '; echo $current_client == 1 ? 'hide':''; echo '">
                                                <label class="col-md-3 control-label">Module / Section</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="module" onchange="changedModule(this.value)">
                                                        <option value="">Select</option>';

                                                        $resultModule = mysqli_query( $conn,"SELECT * FROM tbl_library_module WHERE ID<>13 ORDER BY name" );
                                                        if ( mysqli_num_rows($resultModule) > 0 ) {
                                                            while($rowModule = mysqli_fetch_array($resultModule)) {
                                                                $module_ID = $rowModule["ID"];
                                                                $module_name = $rowModule["name"];

                                                                echo '<option value="'.$module_ID.'">'.$module_name.'</option>';
                                                            }
                                                        }

                                                        echo '<option value="13">Others</option>
                                                    </select>
                                                    <input type="text" class="form-control hide module_others" name="module_others" placeholder="Leave Blank or Enter Module / Section Name" style="margin-top: 15px;" />
                                                </div>
                                            </div>
                                            <div class="form-group '; echo $switch_user_id == 1 OR $switch_user_id == 464 ? '':'hide'; echo '">
                                                <label class="col-md-3 control-label">Reviewer</label>
                                                <div class="col-md-8">
                                                    <select class="form-control mt-multiselect" name="reviewer">
                                                        <option value="0">Select</option>';
                                                        $selectEmployeee = mysqli_query( $conn,"SELECT 
                                                            u.ID AS u_ID,
                                                            e.ID AS e_ID,
                                                            e.first_name AS e_first_name,
                                                            e.last_name AS e_last_name
                                                            FROM tbl_hr_employee AS e

                                                            INNER JOIN (
                                                                SELECT
                                                                *
                                                                FROM tbl_user
                                                            ) AS u
                                                            ON e.ID = u.employee_id

                                                            WHERE e.suspended = 0 
                                                            AND e.status = 1 
                                                            AND e.user_id = $switch_user_id 

                                                            ORDER BY e.first_name" );
                                                        if ( mysqli_num_rows($selectEmployeee) > 0 ) {
                                                            while($rowEmployee = mysqli_fetch_array($selectEmployeee)) {
                                                                $emp_ID = $rowEmployee["u_ID"];
                                                                $emp_name = $rowEmployee["e_first_name"] .' '. $rowEmployee["e_last_name"];

                                                                echo '<option value="'.$emp_ID.'">'.$emp_name.'</option>';
                                                            }
                                                        }
                                                    echo '</select>
                                                </div>
                                            </div>
                                            <div class="form-group '; echo $switch_user_id == 1 OR $switch_user_id == 464 ? '':'hide'; echo '">
                                                <label class="col-md-3 control-label">Approver</label>
                                                <div class="col-md-8">
                                                    <select class="form-control mt-multiselect" name="approver">
                                                        <option value="0">Select</option>';
                                                        $selectEmployeee = mysqli_query( $conn,"SELECT 
                                                            u.ID AS u_ID,
                                                            e.ID AS e_ID,
                                                            e.first_name AS e_first_name,
                                                            e.last_name AS e_last_name
                                                            FROM tbl_hr_employee AS e

                                                            INNER JOIN (
                                                                SELECT
                                                                *
                                                                FROM tbl_user
                                                            ) AS u
                                                            ON e.ID = u.employee_id

                                                            WHERE e.suspended = 0 
                                                            AND e.status = 1 
                                                            AND e.user_id = $switch_user_id 

                                                            ORDER BY e.first_name" );
                                                        if ( mysqli_num_rows($selectEmployeee) > 0 ) {
                                                            while($rowEmployee = mysqli_fetch_array($selectEmployeee)) {
                                                                $emp_ID = $rowEmployee["u_ID"];
                                                                $emp_name = $rowEmployee["e_first_name"] .' '. $rowEmployee["e_last_name"];

                                                                echo '<option value="'.$emp_ID.'">'.$emp_name.'</option>';
                                                            }
                                                        }
                                                    echo '</select>
                                                </div>
                                            </div>';
                                        ?>
                                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Description</label>
                                            <div class="col-md-8">
                                                <textarea class="form-control summernote" name="description" onkeyup="description_count('Area')"></textarea>
                                                <span class="words_count label label-sm label-info hide"><span class="textcount">0</span></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Description of Changes</label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="changes" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Enable Annual Review?</label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="enable_annual" onchange="changedAnnual(this.value)">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="enable_annual hide">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Requirements</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control tagsinput" id="requirements" name="requirements" data-role="tagsinput" required />
                                                    <span class="form-text text-muted">Enter multiple requirements separated by comma</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Compliance Action Items</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control tagsinput" id="action_items" name="action_items" data-role="tagsinput" required />
                                                    <span class="form-text text-muted">Enter multiple action items separated by comma</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Upload Document</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="filetype" onchange="changeType(this)" required>
                                                        <option value="0">Select option</option>
                                                        <option value="1">Manual Upload</option>
                                                        <option value="3">Google Drive URL</option>
                                                        <option value="4">Sharepoint URL</option>
                                                    </select>
                                                    <input class="form-control margin-top-15 fileUpload" type="file" name="file" style="display: none;" />
                                                    <input class="form-control margin-top-15 fileURL" type="url" name="fileurl" style="display: none;" placeholder="https://" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Annual Review Date</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="date" name="due_date" value="<?php echo date('Y-m-d'); ?>" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Area" id="btnSave_Area" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title pictogram-align">
                                            Edit Item in Dashboard
                                            <?php
                                                $pictogram = 'cd_item_edit';
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
                                    <div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Area" id="btnUpdate_Area" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalChanges" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalChanges">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Description</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalSubItem" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modalSubItem">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title pictogram-align">
                                            New Sub-item in Dashboard
                                            <?php
                                                $pictogram = 'cd_item_sub_add';
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
                                    <div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_SubItem" id="btnSave_SubItem" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalEdit_SubItem" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modalEdit_SubItem">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title pictogram-align">
                                            Edit Item in Dashboard
                                            <?php
                                                $pictogram = 'cd_item_sub_edit';
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
                                    <div class="modal-footer modal-footer--sticky bg-white">
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
                                        <h4 class="modal-title pictogram-align">
                                            Add Files
                                            <?php
                                                $pictogram = 'cd_file_add';
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
                                        <h4 class="modal-title pictogram-align">
                                            Edit Files
                                            <?php
                                                $pictogram = 'cd_file_edit';
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
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Attached" id="btnUpdate_Attached" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalViewInt" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalViewInt">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Internal Details</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnSaveInt_File" id="btnSaveInt_File" data-style="zoom-out"><span class="ladda-label">Save</span></button>
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
                                        <h4 class="modal-title pictogram-align">
                                            Add Comment
                                            <?php
                                                $pictogram = 'cd_comment';
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
                                        <h4 class="modal-title pictogram-align">
                                            Add Compliance Instruction
                                            <?php
                                                $pictogram = 'cd_com_add';
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
                                        <h4 class="modal-title pictogram-align">
                                            Edit Compliance Instruction
                                            <?php
                                                $pictogram = 'cd_com_edit';
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
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Compliance" id="btnUpdate_Compliance" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalComplianceMore" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalComplianceMore">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title pictogram-align">
                                            Action Compliance
                                            <?php
                                                $pictogram = 'cd_com_more_add';
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
                                        <button type="submit" class="btn green ladda-button" name="btnSaveMore_Compliance" id="btnSaveMore_Compliance" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalComplianceMoreEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalComplianceMoreEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title pictogram-align">
                                            Action Compliance
                                            <?php
                                                $pictogram = 'cd_com_more_edit';
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
                                        <h4 class="modal-title pictogram-align">
                                            Add New Review
                                            <?php
                                                $pictogram = 'cd_rev_add';
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
                                        <h4 class="modal-title pictogram-align">
                                            Edit Review
                                            <?php
                                                $pictogram = 'cd_rev_edit';
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
                                        <h4 class="modal-title pictogram-align">
                                            Action Review
                                            <?php
                                                $pictogram = 'cd_rev_act_add';
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
                                        <h4 class="modal-title pictogram-align">
                                            Edit Action Review
                                            <?php
                                                $pictogram = 'cd_rev_act_edit';
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
                                        <h4 class="modal-title pictogram-align">
                                            Action Review
                                            <?php
                                                $pictogram = 'cd_rev_more_add';
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
                                        <h4 class="modal-title pictogram-align">
                                            Edit Action Review
                                            <?php
                                                $pictogram = 'cd_rev_more_edit';
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
                                        <h4 class="modal-title pictogram-align">
                                            Add New Template
                                            <?php
                                                $pictogram = 'cd_temp_add';
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
                                        <h4 class="modal-title pictogram-align">
                                            Edit Template
                                            <?php
                                                $pictogram = 'cd_temp_edit';
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
                                        <h4 class="modal-title pictogram-align">
                                            Add New Reference
                                            <?php
                                                $pictogram = 'cd_ref_add';
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
                                        <h4 class="modal-title pictogram-align">
                                            Edit Reference
                                            <?php
                                                $pictogram = 'cd_ref_edit';
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
                                        <h4 class="modal-title pictogram-align">
                                            Add New Video
                                            <?php
                                                $pictogram = 'cd_vid_add';
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
                                        <h4 class="modal-title pictogram-align">
                                            Edit Video
                                            <?php
                                                $pictogram = 'cd_vid_edit';
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
                                        <h4 class="modal-title pictogram-align">
                                            Add New Task
                                            <?php
                                                $pictogram = 'cd_task_add';
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
                                        <h4 class="modal-title pictogram-align">
                                            Edit Task
                                            <?php
                                                $pictogram = 'cd_task_edit';
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
                                        <h4 class="modal-title pictogram-align">
                                            Clone
                                            <?php
                                                $pictogram = 'cd_clone';
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
                                        <h4 class="modal-title pictogram-align">
                                            Table Report
                                            <?php
                                                $pictogram = 'cd_report';
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
                                    <div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="button" class="btn green ladda-button" name="btnExport" id="btnExport" data-style="zoom-out"><span class="ladda-label">Export</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalViewFiles" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title pictogram-align">Files Details</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Language</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="modal-footer modal-footer--sticky bg-white">
                                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalViewTemplates" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title pictogram-align">Templates Details</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Language</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="modal-footer modal-footer--sticky bg-white">
                                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalCollaborator" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modalCollaborator">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title pictogram-align">
                                            Collaborator
                                            <?php
                                                $pictogram = 'cd_collab';
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
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Collaborator" id="btnSave_Collaborator" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- File Uploads and Compliance Viewer -->
                    <div class="modal fade" id="modalFileUploads" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modalFileUploads">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">File Uploads</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-default">
                                                    <td>Location</td>
                                                    <td>File(s)</td>
                                                    <td class="text-center" style="width: 130px;">Document Date</td>
                                                    <td class="text-center" style="width: 130px;">Due Date</td>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalFileUploadOther" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modalFileUploadOther">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">File Uploads</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-default">
                                                    <td>File(s)</td>
                                                    <td class="text-center" style="width: 130px;">Document Date</td>
                                                    <td class="text-center" style="width: 130px;">Due Date</td>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalComplianceList" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modalComplianceList">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Compliance List</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-default">
                                                    <td>Location</td>
                                                    <td class="text-center" style="width: 130px;">Compliance %</td>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- History Section -->
                    <div class="modal fade" id="modalHistory" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <form method="post" class="form-horizontal modalForm modalHistory">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title pictogram-align">
                                            History
                                            <?php
                                                $pictogram = 'cd_history';
                                                if ($switch_user_id == 5) {
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
                                    <div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- POAM Section -->
                    <div class="modal fade" id="modalViewPoam" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalViewPoam">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Details</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnSave_Poam" id="btnSave_Poam" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalAddMiles" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalAddMiles">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Details</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Milestones with Interim Completion Dates</label>
                                            <div class="col-md-8">
                                                <input type="date" class="form-control" name="date_milestone" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Changes to Milestones</label>
                                            <div class="col-md-8">
                                                <textarea class="form-control" name="changes_milestone"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnSave_Miles" id="btnSave_Miles" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalEditMiles" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalEditMiles">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Details</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnEdit_Miles" id="btnEdit_Miles" data-style="zoom-out"><span class="ladda-label">Update</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalViewMilestone" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalViewMilestone">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Details</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <td>Milestones with Interim Completion Dates</td>
                                                    <td>Changes to Milestones</td>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
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

        
        <?php if($switch_user_id == 464 OR $switch_user_id == 1457 OR $switch_user_id == 1649) { ?>
            
            <script src='AnalyticsIQ/compliance_chart.js?i=<?php echo $switch_user_id; ?>'></script>
        <?php } ?>


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
        					// console.log('done : ' + data);
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
            function changeStatus(id, e) {
                val = $(e).val();
                swal_val = $(e).find("option:selected").text();

                swal({
                    title: "Are you sure?",
                    text: "Please confirm if you select "+swal_val,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Yes, confirm it!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type: "GET",
                        url: "function.php?modalChangesStatus_Area="+id+"&v="+val,
                        dataType: "html",
                        success: function(response){
                            if ($.trim(response)) {
                                var obj = jQuery.parseJSON(response);
                                $('.panel_'+obj.ID+' .panel-body > .row #tabDescription_'+obj.ID).html(obj.description);
                            }
                            // $('#modalChanges').modal('hide');
                        }
                    });
                    swal(swal_val, "Status Updated", "success");
                });
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
            function changedAnnual(val) {
                if (val == 1) {
                    $('.enable_annual').removeClass('hide');
                } else {
                    $('.enable_annual').addClass('hide');
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
            var cmmcPoints = [];
            var switch_user_ids = '<?php echo $switch_user_id; ?>';
            var dataON = 'Yes';
            var dataOFF = 'No';
            if (switch_user_ids == 1649) {
                dataON = 'Met';
                dataOFF = 'NotMet';
            }
            
            $(document).ready(function(){
                var collabUser = '<?php echo $collabUser; ?>';
                widget_summernote();
                widget_tagInput();
                
                $.ajax({
                    async: true,
                    type: 'GET',
                    url: 'function.php?jstree_HTML2='+collabUser,
                    dataType: 'json',
                    success: function (json) {
                        
                        const data = json;

                        // Create a map of id to its children
                        const childrenMap = data.reduce((acc, item) => {
                          if (!acc[item.parent]) {
                            acc[item.parent] = [];
                          }
                          acc[item.parent].push(item);
                          return acc;
                        }, {});

                        // Set of valid ids (including root #)
                        const validIds = new Set(['#']);

                        // Function to collect valid ids recursively
                        function collectValidIds(id) {
                          if (childrenMap[id]) {
                            childrenMap[id].forEach(child => {
                              validIds.add(child.id);
                              collectValidIds(child.id);
                            });
                          }
                        }

                        // Start with the root parents (those whose parent is '#')
                        collectValidIds('#');

                        // Filter the data to keep only valid items
                        const filteredData = data.filter(item => validIds.has(item.id));
                        
                        // Sorting Alphanumeric
                        if (switch_user_id != 1649) {
                            filteredData.sort((a, b) => a.text.localeCompare(b.text));
                            filteredData.sort((a, b) => a.text.localeCompare(b.text, 'en', { numeric: true }));
                        }
                        // console.log(filteredData);
                        

                        // Step 1-4 for Analytics
                        // // Step 1: Find all first-level items
                        // const firstLevelItems = filteredData.filter(item => item.parent === "#");

                        // // Step 2: Recursively find all children of a given item (second-level and beyond)
                        // function findDescendants(parentId) {
                        //   let descendants = [];
                          
                        //   // Find all items with this parentId
                        //   const children = filteredData.filter(item => item.parent === parentId);
                        //   children.forEach(child => {
                        //     descendants.push(child); // Add the child to the descendants list
                        //     // Recursively add its children as well
                        //     descendants = descendants.concat(findDescendants(child.id));
                        //   });
                          
                        //   return descendants;
                        // }

                        // // Step 3: Count the totals based on applicable and cmmc values
                        // function countTotals(records) {
                        //   let notApplicable = 0;
                        //   let notMet = 0;
                        //   let met = 0;
                          
                        //   records.forEach(item => {
                        //     if (item.applicable === "0") {
                        //       notApplicable++;
                        //     } else if (item.applicable === "1" && item.cmmc === "0") {
                        //       notMet++;
                        //     } else if (item.applicable === "1" && item.cmmc === "1") {
                        //       met++;
                        //     }
                        //   });
                          
                        //   return { notApplicable, notMet, met };
                        // }

                        // // Step 4: Summarize results for each first-level item
                        // const summary = firstLevelItems.map(firstLevel => {
                        //   // Get all descendants (second-level and beyond)
                        //   const descendants = findDescendants(firstLevel.id, data);
                        //   const subData = [];
                          
                        //   // Count totals for these descendants
                        //   const totals = countTotals(descendants);
                          

                        //     // Populate the subData array based on the calculated totals
                        //     if (totals.notApplicable > 0) {
                        //       subData.push({ name: "Total Not Applicable", value: totals.notApplicable });
                        //     }
                        //     if (totals.notMet > 0) {
                        //       subData.push({ name: "Total Not Met", value: totals.notMet });
                        //     }
                        //     if (totals.met > 0) {
                        //       subData.push({ name: "Total Met", value: totals.met });
                        //     }

                        //   return {
                        //     country: firstLevel.text,
                        //     litres: subData.reduce((sum, item) => sum + item.value, 0), // Total sum of values in subData
                        //     subData: subData
                        //   };
                        // });
                        
                        
                        // Step 1: Find all top-level parents (parent === "#")
                        const topLevelItems = filteredData.filter(item => item.parent === "#");

                        // Step 2: Count applicable statuses for each top-level item
                        const results = topLevelItems.map(parentItem => {
                            let notApplicable = 0;
                            let notMet = 0;
                            let met = 0;

                            // Find all descendants (recursively)
                            const findDescendants = (id) => {
                                const children = data.filter(item => item.parent === id);
                                let all = [...children];
                                for (let child of children) {
                                    all = all.concat(findDescendants(child.id));
                                }
                                return all;
                            };

                            const descendants = findDescendants(parentItem.id);

                            // Include the parent item itself in the evaluation
                            const allRelevant = [parentItem, ...descendants];

                            allRelevant.forEach(item => {
                                if (item.applicable === "0") {
                                    notApplicable++;
                                } else if (item.applicable === "1" && item.cmmc === "0") {
                                    notMet++;
                                } else if (item.applicable === "1" && item.cmmc === "1") {
                                    met++;
                                }
                            });

                            
                            // // Populate the subData array based on the calculated totals
                            // const subData = [];
                            // if (notApplicable > 0) {
                            //   subData.push({ name: "Total Not Applicable", value: notApplicable });
                            // }
                            // if (notMet > 0) {
                            //   subData.push({ name: "Total Not Met", value: notMet });
                            // }
                            // if (met > 0) {
                            //   subData.push({ name: "Total Met", value: met });
                            // }

                            return {
                                text: parentItem.cmmc_code,
                                percent: allRelevant.length,
                                point: parseInt(parentItem.cmmc_point),
                                subData: [
                                    {
                                        name: "Total Not Applicable",
                                        value: notApplicable
                                    },
                                    {
                                        name: "Total Not Met",
                                        value: notMet
                                    },
                                    {
                                        name: "Total Met",
                                        value: met
                                    }
                                ]
                            };
                        });
                        // cmmcAnalytics = JSON.stringify(summary, null, 2);
                        console.log(JSON.stringify(results, null, 2));
                        cmmcPie(results);

                        removeInapplicable = removeInapplicable(filteredData);
                        // console.log(removeInapplicable);
 
                        // Commented 20250430
                        // negativeCMMCPoints = negativeCMMCPoints(removeInapplicable);
                        // // console.log(negativeCMMCPoints);
                        // cmmcPoints = negativeCMMCPoints;
                        
                        

                        calculateCMMC = calculateCMMC(removeInapplicable);
                        console.log(calculateCMMC);
                        
                        // Step 1: Find all top-level parents (parent === "#")
                        const topLevelItems2 = calculateCMMC.filter(item => item.parent === "#");

                        // Step 2: Count applicable statuses for each top-level item
                        const results2 = topLevelItems2.map(parentItem => {
                            let notApplicable = 0;
                            let notMet = 0;
                            let met = 0;

                            // Find all descendants (recursively)
                            const findDescendants = (id) => {
                                const children = data.filter(item => item.parent === id);
                                let all = [...children];
                                for (let child of children) {
                                    all = all.concat(findDescendants(child.id));
                                }
                                return all;
                            };

                            const descendants = findDescendants(parentItem.id);

                            // Include the parent item itself in the evaluation
                            const allRelevant = [parentItem, ...descendants];

                            allRelevant.forEach(item => {
                                if (item.applicable === "0") {
                                    notApplicable++;
                                } else if (item.applicable === "1" && item.cmmc === "0") {
                                    notMet++;
                                } else if (item.applicable === "1" && item.cmmc === "1") {
                                    met++;
                                }
                            });

                            
                            // // Populate the subData array based on the calculated totals
                            // const subData = [];
                            // if (notApplicable > 0) {
                            //   subData.push({ name: "Total Not Applicable", value: notApplicable });
                            // }
                            // if (notMet > 0) {
                            //   subData.push({ name: "Total Not Met", value: notMet });
                            // }
                            // if (met > 0) {
                            //   subData.push({ name: "Total Met", value: met });
                            // }

                            return {
                                text: parentItem.cmmc_code,
                                percent: allRelevant.length,
                                point: parseInt(parentItem.cmmc_point),
                                subData: [
                                    {
                                        name: "Total Not Applicable",
                                        value: notApplicable
                                    },
                                    {
                                        name: "Total Not Met",
                                        value: notMet
                                    },
                                    {
                                        name: "Total Met",
                                        value: met
                                    }
                                ]
                            };
                        });
                        // cmmcAnalytics = JSON.stringify(summary, null, 2);
                        // console.log(JSON.stringify(results, null, 2));
                        cmmcPie2(results2);
                        
                        
                        cmmcPoints = calculateCMMC;
                        
                        createJSTree(filteredData);
                        
                        
                        // const inputNodes = deductPoints(filteredData);
                        // const inputNodes = updatePoints(filteredData);
                        // cmmcPoints = inputNodes;
                        
                        
                        // alert(json);
                        // json.sort((a, b) => a.text.localeCompare(b.text));
                        // json.sort((a, b) => a.text.localeCompare(b.text, 'en', { numeric: true }));
                        // createJSTree(json);
                    },

                    error: function (xhr, ajaxOptions, thrownError) {
                        // alert(xhr.status);
                        // alert(thrownError);
                    }
                });

                function removeInapplicable(data) {
                    const map = new Map();

                    // Create a map with each ID and its children
                    data.forEach(item => {
                        map.set(item.id, { ...item, children: [] });
                        if (item.parent !== '#') {
                            map.get(item.parent)?.children.push(item.id);
                        }
                    });

                    // Recursive function to get all descendants of an ID
                    function getDescendants(id) {
                        const descendants = [];
                        const stack = [id];
                        while (stack.length > 0) {
                            const current = stack.pop();
                            descendants.push(current);
                            if (map.get(current)?.children) {
                                stack.push(...map.get(current).children);
                            }
                        }
                        return descendants;
                    }

                    // Find all IDs to remove (with applicable = 0)
                    const toRemove = new Set();
                    data.forEach(item => {
                        if (item.applicable === '0') {
                            const descendants = getDescendants(item.id);
                            descendants.forEach(id => toRemove.add(id));
                        }
                    });

                    // Filter the data by removing the unwanted IDs
                    return data.filter(item => !toRemove.has(item.id));
                }
                function calculateCMMC(data) {
                    // Helper to build tree structure
                    const buildChildrenMap = (data) => {
                      const map = {};
                      for (const node of data) {
                        if (!map[node.parent]) {
                          map[node.parent] = [];
                        }
                        map[node.parent].push(node);
                      }
                      return map;
                    };

                    const childrenMap2 = buildChildrenMap(data);

                    const hasAnyCmmc0 = (node, map) => {
                      if (node.cmmc === "0") return true;
                      const children = map[node.id] || [];
                      return children.some(child => hasAnyCmmc0(child, map));
                    };

                    // Apply rules to second-level nodes
                    for (const node of data) {
                      if (data.find(d => d.parent === node.id)) {
                        // Has children
                        if (!hasAnyCmmc0(node, childrenMap2)) {
                          // all cmmc = 1, do nothing
                        } else if (node.cmmc === "0") {
                          node.cmmc_point = String(-Math.abs(Number(node.cmmc_point)));
                        }
                      } else if (data.find(d => d.id === node.parent && d.parent === '#')) {
                        // Direct child of first level (2nd level) with no children
                        if (node.cmmc === "0") {
                          node.cmmc_point = String(-Math.abs(Number(node.cmmc_point)));
                        }
                      }
                    }

                    // Apply rules to first-level nodes
                    // for (const node of data) {
                    //   if (node.parent === '#') {
                    //     const children = data.filter(d => d.parent === node.id);
                    //     if (children.length === 0) {
                    //       if (node.cmmc === "0") {
                    //         node.cmmc_point = String(110 - Number(node.cmmc_point));
                    //       }
                    //     } else {
                    //       let negativeSum = 0;
                    //       for (const child of children) {
                    //         const val = Number(child.cmmc_point);
                    //         if (val < 0) negativeSum += Math.abs(val);
                    //       }
                    //       node.cmmc_point = String(110 - negativeSum);
                    //     }
                    //   }
                    // }

                    // Updated 1st-level logic
                    // for (const node of data) {
                    //   if (node.parent === '#') {
                    //     const children = data.filter(d => d.parent === node.id);
                    //     if (children.length === 0) {
                    //       if (node.cmmc === "0") {
                    //         node.cmmc_point = String(-Math.abs(Number(node.cmmc_point)));
                    //       }
                    //       // cmmc === "1" → do nothing
                    //     } else {
                    //       // Count 2nd-level children only
                    //       const secondLevel = children;
                    //       const negSum = secondLevel.reduce((sum, child) => {
                    //         const val = Number(child.cmmc_point);
                    //         return val < 0 ? sum + Math.abs(val) : sum;
                    //       }, 0);
                    //       node.cmmc_point = String(secondLevel.length - negSum);
                    //     }
                    //   }
                    // }
                    
                    return data;
                }
                function updateLevel2Points(data) {
                  // Create a map to store children relationships
                  const parentMap = {};
                  data.forEach(item => {
                    if (!parentMap[item.parent]) {
                      parentMap[item.parent] = [];
                    }
                    parentMap[item.parent].push(item);
                  });

                  // Recursive function to check cmmc values
                  function checkZeroCMMC(parentId) {
                    const children = parentMap[parentId] || [];
                    for (let child of children) {
                      if (child.cmmc === 0 || checkZeroCMMC(child.id)) {
                        return true;
                      }
                    }
                    return false;
                  }

                  // Update level 2 cmmc_points if necessary
                  data.forEach(item => {
                    if (item.parent !== '#' && parentMap[item.parent]) {
                      const parentItem = data.find(parent => parent.id === item.parent);
                      if (parentItem && parentItem.parent === '#' && checkZeroCMMC(item.id)) {
                        item.cmmc_point = 0;
                      }
                    }
                  });

                  return data;
                }
                function updateCMMCPoints(data) {
                  // Create a map to store child-parent relationships
                  const parentMap = {};
                  data.forEach(item => {
                    if (!parentMap[item.parent]) {
                      parentMap[item.parent] = [];
                    }
                    parentMap[item.parent].push(item);
                  });

                  // Recursive function to check if any child has cmmc = 0
                  function hasZeroCMMC(parentId) {
                    const children = parentMap[parentId] || [];
                    for (let child of children) {
                      if (child.cmmc === "0" || hasZeroCMMC(child.id)) {
                        return true;
                      }
                    }
                    return false;
                  }

                  // Update cmmc_point of parent items
                  data.forEach(item => {
                    if (hasZeroCMMC(item.id)) {
                      item.cmmc_point = "0";
                    }
                  });

                  return data;
                }
                function adjustCmmcPoints_old(nodes) {
                    // Function to determine node levels
                    const getNodeLevels = (nodes) => {
                        let levels = {};
                        let parentMap = Object.fromEntries(nodes.map(n => [n.id, n.parent]));
                        
                        const findLevel = (nodeId) => {
                            if (parentMap[nodeId] === '#') return 0;
                            return 1 + findLevel(parentMap[nodeId]);
                        };
                        
                        nodes.forEach(node => levels[node.id] = findLevel(node.id));
                        return levels;
                    };

                    let levels = getNodeLevels(nodes);

                    // Identify levels where cmmc = 0 exists
                    let cmmcZeroLevels = new Set();
                    nodes.forEach(node => {
                        if (node.cmmc === '0') {
                            cmmcZeroLevels.add(levels[node.id]);
                        }
                    });

                    // Update cmmc_point to 0 for all nodes in affected levels
                    nodes.forEach(node => {
                        if (cmmcZeroLevels.has(levels[node.id])) {
                            node.cmmc_point = '0';
                        }
                    });

                    return nodes;
                }
                function adjustCmmcPoints(nodes) {
                    // Step 1: Create a parent-child mapping
                    const parentMap = {};
                    nodes.forEach(node => {
                        if (!parentMap[node.parent]) parentMap[node.parent] = [];
                        parentMap[node.parent].push(node.id);
                    });

                    // Step 2: Assign levels iteratively
                    const levels = {};
                    const queue = [{ id: '#', level: -1 }];  // Start from root level (-1)

                    while (queue.length > 0) {
                        let { id, level } = queue.shift();
                        if (parentMap[id]) {
                            parentMap[id].forEach(childId => {
                                levels[childId] = level + 1;
                                queue.push({ id: childId, level: level + 1 });
                            });
                        }
                    }

                    // Step 3: Identify levels where cmmc = 0 exists
                    const cmmcZeroLevels = new Set();
                    nodes.forEach(node => {
                        if (node.cmmc === '0') cmmcZeroLevels.add(levels[node.id]);
                    });

                    // Step 4: Update cmmc_point to 0 for all nodes in affected levels
                    nodes.forEach(node => {
                        if (cmmcZeroLevels.has(levels[node.id])) {
                            node.cmmc_point = '0';
                        }
                    });

                    return nodes;
                }
                function negativeCMMCPoints(data) {
                    // Step 1: Create a map for fast parent-to-children lookup
                    const childrenMap = {};
                    data.forEach(node => {
                      if (!childrenMap[node.parent]) {
                        childrenMap[node.parent] = [];
                      }
                      childrenMap[node.parent].push(node);
                    });
                    
                    // Step 2: Helper to get all descendants of a node
                    function getAllDescendants(id) {
                      let descendants = [];
                      const children = childrenMap[id] || [];
                      for (const child of children) {
                        descendants.push(child);
                        descendants = descendants.concat(getAllDescendants(child.id));
                      }
                      return descendants;
                    }
                    
                    // Step 3: Identify all 2nd-level nodes
                    const secondLevelNodes = data.filter(node => {
                      const parent = data.find(p => p.id === node.parent);
                      return parent && parent.parent === '#';
                    });
                    
                    // Step 4: Apply rule only if 2nd-level node has children
                    secondLevelNodes.forEach(node => {
                      const descendants = getAllDescendants(node.id);
                    
                      if (descendants.length > 0) {
                        const allNodes = [node, ...descendants]; // include self
                    
                        const hasCmmc0 = allNodes.some(n => n.cmmc === "0");
                    
                        if (hasCmmc0) {
                          node.cmmc_point = (-Math.abs(parseInt(node.cmmc_point))).toString();
                        }
                        // if all are "1" – do nothing
                      }
                      // if no descendants – skip (rule says do nothing)
                    });

                    return data;
                }
                function createJSTree(jsondata) {            
                    $('#jstreeAjax').jstree({
                        'core': {
                            'data': jsondata
                        },
                        types:{
                            "default":{
                                icon:"fa fa-folder icon-state-warning"
                            },
                            file:{
                                icon:"fa fa-file icon-state-danger"
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
                }
                // function deductPoints(nodes) {
                //     const nodeMap = new Map();
                //     nodes.forEach(node => nodeMap.set(node.id, { ...node, children: [], point: parseInt(node.point, 10) }));

                //     nodes.forEach(node => {
                //         if (node.parent !== '#') {
                //             nodeMap.get(node.parent).children.push(nodeMap.get(node.id));
                //         }
                //     });

                //     function calculateAndDeductPoints(node) {
                //         let deductedPoints = node.point;
                //         node.children.forEach(child => {
                //             deductedPoints -= calculateAndDeductPoints(child);
                //         });
                //         return deductedPoints;
                //     }

                //     nodes.forEach(node => {
                //         if (node.parent === '#') {
                //             nodeMap.get(node.id).point = calculateAndDeductPoints(nodeMap.get(node.id));
                //         }
                //     });

                //     return Array.from(nodeMap.values()).map(node => ({ id: node.id, parent: node.parent, point: node.point }));
                // }
                // function updatePoints(data) {
                //     const updatedData = [...data];

                //     const getChildPoints = (id) => {
                //         const children = updatedData.filter(child => child.parent === id);
                //         const childPoints = children.map(child => {
                //             const totalChildPoints = getChildPoints(child.id);
                //             child.point = Math.max(0, child.point - totalChildPoints);
                //             return child.point;
                //         });
                //         return childPoints.reduce((acc, curr) => acc + curr, 0);
                //     };

                //     updatedData.forEach(item => {
                //         if (item.parent === '#') {
                //             item.point = Math.max(0, item.point - getChildPoints(item.id));
                //         }
                //     });

                //     return updatedData;
                // }
                
                // if (current_userEmployerID == 19) {
                    // Data loaded as JSON Format (Display Once - Option 3)
                    // $('#jstreeAjax').jstree({
                    //     'core' : {
                    //         'themes' : { responsive:!1 },
                    //         'data'   : {
                    //             'url' : function (node) {
                    //                 return node.id === '#' ? 'function.php?jstreeList='+collabUser : 'function.php?jstreeListItem='+node.id;
                    //             },
                    //             'data' : function (node) {
                    //                 return { 'id' : node.id };
                    //             },
                    //             'dataType': "json"
                    //         }
                    //     },
                    //     types:{
                    //         "default":{
                    //             icon:"fa fa-folder icon-state-warning icon-lg"
                    //         },
                    //         file:{
                    //             icon:"fa fa-file icon-state-warning icon-lg"
                    //         }
                    //     },
                    //     height: "200px",
                    //     search: {
                    //         case_insensitive: false,
                    //         show_only_matches : true,
                    //         show_only_matches_children : true
                    //     },
                    //     plugins : ["types", "search" ]
                    // });
                // } else {
                //     // Data at the top as PHP Format (Display All - Option 1)
                    // $('#jstree_PHP').jstree();
    
                    // Data loaded as HTML UL > LI Format (Display All - Option 2)
                    // jstree_uiBlock_();
                    // $.ajax({
                    //     type: 'GET',
                    //     url: 'function.php?jstree_HTML='+collabUser,
                    //     dataType: "html",
                    //     success: function(data){
                    //         $('#jstree_HTML').jstree({
                    //             'themes' : { responsive:!1 },
                    //             'core': {
                    //                 'data': data,
                    //             },
                    //             'types' : {
                    //                 "default" : {
                    //                     "icon" : "fa fa-folder icon-state-warning"
                    //                 },
                    //                 "file" : {
                    //                     "icon" : "fa fa-file icon-state-danger"
                    //                 },
                    //                 "folder" : {
                    //                     "icon" : "fa fa-file icon-state-info"
                    //                 }
                    //             },
                    //             search: {
                    //                 case_insensitive: false,
                    //                 show_only_matches : true,
                    //                 show_only_matches_children : true
                    //             },
                    //             plugins : ["types", "search" ]
                    //         });
                    //         $('#jstree_HTML').unblock();
                    //     }
                    // });
                    // fancyBoxes();
                // }
            });

            // Load data base on selected Folder
            if (current_userEmployerID == 19) { var jstree_data = 'jstreeAjax'; }
            else { var jstree_data = 'jstree_HTML'; }
            var jstree_data = 'jstreeAjax';
            $("#"+jstree_data).on("click", "li > a", function() {
                
               $(".left").hide();
                
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
                            findCMMC();
                        }
                    });
                }
                fancyBoxes();
            });
            
            function btnLoadDashboard(id) {
                uiBlock();
                $.ajax({
                    type: "GET",
                    url: "function.php?modalDashboard="+id,
                    dataType: "html",
                    success: function(data){
                        $(".left").hide();
                        $("#parent").html(data);
                        $('#dashboardData').unblock();
                        $('#item_'+id).collapse('show');
                        $(".make-switch").bootstrapSwitch();
                        $(".tabbable-tabdrop").tabdrop();
                    }
                });
            }

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
            function widget_summernote() {
                $('.summernote').summernote();
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
                            findCMMC();
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
            function findCMMC() {
                var elements = document.querySelectorAll('[id^="cmmc_"]');
                elements.forEach(function(element) {
                    var id = element.id;
                    var integerPart = parseInt(id.split('_')[1]);
                    pointValue = getPointValueById(integerPart.toString());
                    $('#'+id).text(pointValue);
                });
            }
            function getPointValueById(id) {
                return cmmcPoints.find(node => node.id === id)?.cmmc_point || 0;
            }
            
            // Approval Section
            function btnDeleteAction(action, type, id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalDashboardAction="+action+"&t="+type+"&i="+id,
                    dataType: "html",
                    success: function(data){
                        if (type == 1) {
                            if (action == 1) {
                                $('.panel_'+id).remove();
                            } else {
                                $('.panel_'+id+' .itemWarning').remove();
                            }
                        } else if (type == 2) {
                            if (action == 1) {
                                $('.mt-action-'+id).remove();
                            } else {
                                $('.mt-action-'+id+' .itemWarning').remove();
                            }
                        }
                        
                    }
                });
            }
            <?php if (!empty($_GET['d'])) { ?>
                var req_id = '<?php echo $_GET['d']; ?>';
                var s = 0;
                <?php if (isset($_GET['s']) AND $_GET['s'] == 1) { ?>
                    s = '<?php echo $_GET['s']; ?>';
                <?php }; ?>
                
                uiBlock();
                $.ajax({
                    type: "GET",
                    url: "function.php?modalDashboard="+req_id+"&s="+s,
                    dataType: "html",
                    success: function(data){
                        $(".left").hide();
                        $("#parent").html(data);
                        $('#dashboardData').unblock();
                        $('#item_'+req_id).collapse('show');
                        $(".make-switch").bootstrapSwitch();
                        $(".tabbable-tabdrop").tabdrop();
                    }
                });
            <?php } ?>
            
            // Item Section
            function description_count(modal){
                const areatextarea = $('.modal'+modal+' textarea');
                const areatext = $('.modal'+modal+' textarea').val().length;
                const textcount = $('.modal'+modal+' .textcount');
                const wordcount = $('.modal'+modal+' .words_count');
                textcount.html(areatext);
            }
            function btnChangesView(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalChanges_Area="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalChanges .modal-body").html(data);
                    }
                });
            }
            $(".modalChanges").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnComment_changes',true);

                var l = Ladda.create(document.querySelector('#btnComment_changes'));
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
                            $('#modalChanges').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnChangesAccept(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalChangesAccept_Area="+id,
                    dataType: "html",
                    success: function(data){
                        alert('Accepted');
                    }
                });
            }
            function btnChangesReject(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalChangesReject_Area="+id,
                    dataType: "html",
                    success: function(data){
                        alert('Rejected');
                    }
                });
            }
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

                                                        <?php if ($_COOKIE['client'] == 0) { ?>
                                                            html += '<li><a href="#modalAttached" class="btnAttached" data-toggle="modal" onclick="btnAttached('+obj.ID+')">Attach File</a></li>';
                                                        <?php } ?>

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

                                                    <?php if ($_COOKIE['client'] == 0) { ?>
                                                        html += '<li class=""><a href="#tabFiles_'+obj.ID+'" data-toggle="tab" aria-expanded="true">Files</a></li>';
                                                    <?php } ?>
                                                    
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

                                                    <?php if ($_COOKIE['client'] == 0) { ?>
                                                        html += '<div class="tab-pane" id="tabFiles_'+obj.ID+'">';
                                                            html += '<div class="mt-actions"></div>';
                                                            html += '<a href="#modalAttached" class="btn btn-circle btn-success btnAttached" data-toggle="modal" onclick="btnAttached('+obj.ID+')" style="margin: 15px;">Attach File</a>';
                                                        html += '</div>';
                                                    <?php } ?>
                                                    
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

                                                    <?php if ($_COOKIE['client'] == 0) { ?>
                                                        html += '<div class="tab-pane" id="tabReferences_'+obj.ID+'">';
                                                            html += '<div class="mt-actions"></div>';
                                                            html += '<a href="#modalRef" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnRef('+obj.ID+')" style="margin: 15px;">Add References</a>';
                                                        html += '</div>';
                                                        html += '<div class="tab-pane" id="tabVideo_'+obj.ID+'">';
                                                            html += '<div class="mt-actions"></div>';
                                                            html += '<a href="#modalVideo" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnVideo('+obj.ID+')" style="margin: 15px;">Add Video</a>';
                                                        html += '</div>';
                                                    <?php } ?>
                                                    
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
                        selectMulti();
                        widget_summernote();
                        widget_tagInput();
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
                    success:function(response) {

                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            $('.panel_'+obj.ID+' > .panel-heading h4 a').html(obj.name);
                            $('.panel_'+obj.ID+' .panel-body > .row #tabDescription_'+obj.ID).html(obj.description);
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
                        selectMulti();
                        widget_summernote();
                        widget_tagInput();
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
                                                html += '<li><span href="#modalReport" class="btnReport" data-toggle="modal" onclick="btnReport('+obj.ID+')"><i class="fa fa-table"></i> Report</span></li>';
                                                html += '<li><span href="#modalCollaborator" class="btnCollaborator" data-toggle="modal" onclick="btnCollaborator('+obj.ID+')"><i class="fa fa-cogs"></i> Collaborator</span></li>';
                                                html += '<li><i class="fa fa-list-ol"></i> Compliance 0%</li>';
                                                html += '<li><i class="fa fa-calendar-check-o"></i> Annual Review 0%</li></ul>';
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

                                                        <?php if ($_COOKIE['client'] == 0) { ?>
                                                            html += '<li><a href="#modalAttached" class="btnAttached" data-toggle="modal" onclick="btnAttached('+obj.item_id+')">Attach File</a></li>';
                                                        <?php } ?>

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
                                                    
                                                    <?php if ($_COOKIE['client'] == 0) { ?>
                                                        html += '<li class=""><a href="#tabFiles_'+obj.item_id+'" data-toggle="tab" aria-expanded="true">Files</a></li>';
                                                    <?php } ?>
                                                    
                                                    html += '<li class=""><a href="#tabComments_'+obj.item_id+'" data-toggle="tab" aria-expanded="false">Comments</a></li>';
                                                    html += '<li class="hide"><a href="#tabHistory_'+obj.item_id+'" data-toggle="tab" aria-expanded="false">History</a></li>';
                                                    html += '<li class=""><a href="#tabCompliance_'+obj.item_id+'" data-toggle="tab" aria-expanded="false">Compliance</a></li>';
                                                    html += '<li class=""><a href="#tabReview_'+obj.item_id+'" data-toggle="tab" aria-expanded="false">Annual Review</a></li>';
                                                    html += '<li class=""><a href="#tabTemplate_'+obj.item_id+'" data-toggle="tab" aria-expanded="false">Templates</a></li>';
                                                    
                                                    <?php if ($_COOKIE['client'] == 0) { ?>
                                                        html += '<li class=""><a href="#tabReferences_'+obj.item_id+'" data-toggle="tab" aria-expanded="false">References</a></li>';
                                                        html += '<li class=""><a href="#tabVideo_'+obj.ID+'" data-toggle="tab" aria-expanded="false">Video</a></li>';
                                                    <?php } ?>

                                                    html += '<li class=""><a href="#tabTask_'+obj.ID+'" data-toggle="tab" aria-expanded="false">Task</a></li>';
                                                html += '</ul>';
                                                html += '<div class="tab-content">';
                                                    html += '<div class="tab-pane active" id="tabDescription_'+obj.item_id+'">';
                                                        html += '<h5 style="padding: 0 15px;">'+obj.description+'</h5>';
                                                    html += '</div>';

                                                    <?php if ($_COOKIE['client'] == 0) { ?>
                                                        html += '<div class="tab-pane" id="tabFiles_'+obj.item_id+'">';
                                                            html += '<div class="mt-actions"></div>';
                                                            html += '<a href="#modalAttached" class="btn btn-circle btn-success btnAttached" data-toggle="modal" onclick="btnAttached('+obj.item_id+')" style="margin: 15px;">Attach File</a>';
                                                        html += '</div>';
                                                    <?php } ?>

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

                                                    <?php if ($_COOKIE['client'] == 0) { ?>
                                                        html += '<div class="tab-pane" id="tabReferences_'+obj.item_id+'">';
                                                            html += '<div class="mt-actions"></div>';
                                                            html += '<a href="#modalRef" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnRef('+obj.item_id+')" style="margin: 15px;">Add References</a>';
                                                        html += '</div>';
                                                        html += '<div class="tab-pane" id="tabVideo_'+obj.ID+'">';
                                                            html += '<div class="mt-actions"></div>';
                                                            html += '<a href="#modalVideo" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnVideo('+obj.ID+')" style="margin: 15px;">Add Video</a>';
                                                        html += '</div>';
                                                    <?php } ?>

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
                        selectMulti();
                        widget_summernote();
                        widget_tagInput();
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
                            $('.panel_'+obj.ID+' .panel-body > .row #tabDescription_'+obj.ID).html(obj.description);
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
                        selectMulti();
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

                            var obj = jQuery.parseJSON(response);
                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabFiles_'+obj.parent_id+' .mt-actions').prepend(obj.data);
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
                        selectMulti();
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

                            var obj = jQuery.parseJSON(response);
                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabFiles_'+obj.parent_id+' .mt-actions .mt-action-'+obj.ID).html(obj.data);
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
            function selStatus(val) {
                if (val == 2) {
                    $('.intComment').removeClass('hide');
                    $('.intComment textarea').prop('required', true);

                    $('.intVerify').addClass('hide');
                    $('.intVerify select').prop('required', false);
                } else if (val == 1) {
                    $('.intComment').addClass('hide');
                    $('.intComment textarea').prop('required', false);

                    $('.intVerify').removeClass('hide');
                    $('.intVerify select').prop('required', true);
                } else {
                    $('.intComment').addClass('hide');
                    $('.intComment textarea').prop('required', false);

                    $('.intVerify').addClass('hide');
                    $('.intVerify select').prop('required', false);
                }
            }
            function selApplicable(e) {
                if(e.value == 0) {
                    $(e).nextAll().removeClass('hide');
                } else {
                    $(e).nextAll().addClass('hide');
                }
            }
            function btnInt(id, type) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalInt_File="+id+"&type="+type,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewInt .modal-body").html(data);
                        selectMulti();
                    }
                });
            }
            $(".modalViewInt").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSaveInt_File',true);

                var l = Ladda.create(document.querySelector('#btnSaveInt_File'));
                l.start();
 
                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        // console.log(response);
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            $('#modalViewInt').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
 
                        bootstrapGrowl(msg);
                    }
                });
            }));

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
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td class="text-center"><input type="checkbox" class="make-switch" name="status" data-on-text="'+dataON+'" data-off-text="'+dataOFF+'" data-on-color="success" onchange="changedStatus(this, '+obj.ID+', '+obj.parent_id+')" data-off-color="danger" readonly /></td>';
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
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            var html = '<td class="text-center"><input type="checkbox" class="make-switch" name="status" data-on-text="'+dataON+'" data-off-text="'+dataOFF+'" data-on-color="success" onchange="changedStatus(this, '+obj.ID+', '+obj.parent_id+')" data-off-color="danger" readonly /></td>';
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
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="'+dataON+'" data-off-text="'+dataOFF+'" data-on-color="success" data-off-color="danger" checked readonly />';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:first-child').html(makeSwitch);

                                var button = '<a href="#modalComplianceEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnComplianceEdit('+obj.parent_id+')">Edit</a>';
                                button += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnComplianceDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:last-child > div').html(button);
                            } else {
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="'+dataON+'" data-off-text="'+dataOFF+'" data-on-color="success" data-off-color="danger" readonly />';
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
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="'+dataON+'" data-off-text="'+dataOFF+'" data-on-color="success" data-off-color="danger" checked readonly />';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:first-child').html(makeSwitch);

                                var button = '<a href="#modalComplianceEdit" type="button" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnComplianceEdit('+obj.parent_id+')">Edit</a>';
                                button += '<a href="javascript:;" type="button" class="btn red btn-sm" onclick="btnComplianceDelete('+obj.ID+', '+obj.parent_id+')">Delete</a>';
                                $('.panel_'+obj.library_id+' .panel-body .tab-content #tabCompliance_'+obj.library_id+' table tbody #tr_'+obj.parent_id+' > td:last-child > div').html(button);
                            } else {
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="'+dataON+'" data-off-text="'+dataOFF+'" data-on-color="success" data-off-color="danger" readonly />';
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
            function btnAnnualReviewTemplate(id) {
                swal({
                    title: "Are you sure?",
                    text: "Please confirm if you want to apply the Annual Review Template on this folder and sub-folder!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Yes, confirm it!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type: "GET",
                        url: "function.php?AnnualReviewTemplate="+id,
                        dataType: "html",
                        success: function(response){
                            // console.log(response);
                        }
                    });
                    swal("Accepted!", "Data is confirmed", "success");
                });
            }
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

                            var obj = jQuery.parseJSON(response);
                            var result = '<tr id="tr_'+obj.ID+'">';
                                result += '<td class="text-center"><input type="checkbox" class="make-switch" name="status" data-on-text="'+dataON+'" data-off-text="'+dataOFF+'" data-on-color="success" onchange="changedStatus(this, 1, 1)" data-off-color="danger" '; if(obj.compliant == 1) { result += 'checked'; } result += ' readonly /></td>';
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

                            var obj = jQuery.parseJSON(response);
                            var result = '<td class="text-center"><input type="checkbox" class="make-switch" name="status" data-on-text="'+dataON+'" data-off-text="'+dataOFF+'" data-on-color="success" onchange="changedStatus(this, 1, 1)" data-off-color="danger" '; if(obj.compliant == 1) { result += 'checked'; } result += ' readonly /></td>';
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
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="'+dataON+'" data-off-text="'+dataOFF+'" data-on-color="success" data-off-color="danger" checked readonly />';
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
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="'+dataON+'" data-off-text="'+dataOFF+'" data-on-color="success" data-off-color="danger" checked readonly />';
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
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="'+dataON+'" data-off-text="'+dataOFF+'" data-on-color="success" data-off-color="danger" checked readonly />';
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
                                var makeSwitch = '<input type="checkbox" class="make-switch" data-on-text="'+dataON+'" data-off-text="'+dataOFF+'" data-on-color="success" data-off-color="danger" checked readonly />';
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

                            var obj = jQuery.parseJSON(response);
                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabTemplate_'+obj.parent_id+' .mt-actions').prepend(obj.data);
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

                            var obj = jQuery.parseJSON(response);
                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabTemplate_'+obj.parent_id+' .mt-actions .mt-action-'+obj.ID).html(obj.data);
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

                            var obj = jQuery.parseJSON(response);
                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabReferences_'+obj.parent_id+' .mt-actions').prepend(obj.data);
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

                            var obj = jQuery.parseJSON(response);
                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabReferences_'+obj.parent_id+' .mt-actions .mt-action-'+obj.ID).html(obj.data);
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
            function selectType(id, modal) {
                // console.log(id);
                $('.selVideo').addClass('hide');
                if (id == 0) { $('#selFile_'+modal).removeClass('hide'); }
                else { $('#selURL_'+modal).removeClass('hide'); }
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

                            $('.panel_'+obj.parent_id+' .panel-body .tab-content #tabVideo_'+obj.parent_id+' .mt-actions').prepend(result);
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

                            var obj = jQuery.parseJSON(response);
                            var result = '<div class="mt-action mt-action-'+obj.ID+'">';
                                result += '<div class="mt-action-body">';
                                    result += '<div class="mt-action-row">';
                                        result += '<div class="mt-action-info">';
                                            result += '<div class="mt-action-icon">'+obj.files+'</div>';
                                            result += '<div class="mt-action-details" style="vertical-align: middle;">';
                                                result += '<p class="mt-action-desc">';
                                                    result += '<span class="font-dark"><b>'+obj.description+'</b></span><br>';
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

                            var obj = jQuery.parseJSON(response);
                            var result = '<div class="mt-action-body">';
                                result += '<div class="mt-action-row">';
                                    result += '<div class="mt-action-info">';
                                        result += '<div class="mt-action-icon">'+obj.files+'</div>';
                                        result += '<div class="mt-action-details" style="vertical-align: middle;">';
                                            result += '<p class="mt-action-desc">';
                                                result += '<span class="font-dark"><b>'+obj.description+'</b></span><br>';
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
            function selectUser(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalCloneFacility="+id,
                    dataType: "html",
                    success: function(data){
                        $("#facility").html(data);
                        $("#facility").multiselect('destroy');
                        selectMulti();
                    }
                });
            }
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
                $("#modalReport .modal-body").html('');
                $.ajax({
                    type: "GET",
                    url: "function.php?modalReport="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalReport .modal-body").html(data);

                        $('#table2excel').DataTable({
                            "aaSorting": [],
                            dom: 'lBfrtip',
                            lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                            buttons: [
                                {
                                    extend: 'print',
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL',
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL',
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                },
                                {
                                    extend: 'csv',
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                },
                                // {
                                //     extend: 'excel',
                                //     autoFilter: true,
                                //     exportOptions: {
                                //         columns: ':visible'
                                //     }
                                // },
                                {
                                    extend: 'excelHtml5',
                                    customize: function ( xlsx ) {
                                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                 
                                        $('row', sheet).each(function(x) {
                                            const str = $('c[r=C'+x+'] t', sheet).text();
                                            const token = 'title placement only';
                                            
                                            if (str.toLowerCase().includes(token.toLowerCase()) == true) {
                                                $('row:nth-child('+x+') c', sheet).attr('s', '39');
                                            }
                                        });
                                    }
                                }
                            ]
                        });
                    }
                });
            }
            function btnViewFiles(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewFiles="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewFiles .modal-body tbody").html(data);
                    }
                });
            }
            function btnViewTemplates(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewTemplates="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewTemplates .modal-body tbody").html(data);
                    }
                });
            }
            function selLang(e, id) {
                $("#modalReport .modal-body").html('');
                $.ajax({
                    type: "GET",
                    url: "function.php?modalReport2="+id+"&l="+e.value,
                    dataType: "html",
                    success: function(data){
                        $("#modalReport .modal-body").html(data);

                        $('#table2excel').DataTable({
                            "aaSorting": [],
                            dom: 'lBfrtip',
                            lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                            buttons: [
                                {
                                    extend: 'print',
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL',
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL',
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                },
                                {
                                    extend: 'csv',
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                },
                                {
                                    extend: 'excel',
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                },
                                {
                                    extend: 'excel',
                                    autoFilter: true,
                                    exportOptions: {
                                        columns: ':visible',
                                        stripNewlines: true,
                                        stripHtml: true
                                    },
                                    customize: function (xlsx) {
                                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                 
                                        // Loop over the cells in column `C`
                                        sheet.querySelectorAll('row c[r^="B"]').forEach((row) => {
                                            // Get the value
                                            let cell = row.querySelector('is t');
                 
                                            if (cell && cell.textContent === 'Program') {
                                                row.setAttribute('s', '20');
                                            }
                                        });
                                    }
                                },
                                {
                                    extend: 'excelHtml5',
                                    customize: function ( xlsx ) {
                                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                 
                                        $('row', sheet).each(function(x) {
                                          // if ($('c[r=C'+x+'] t', sheet).text() === 'y') {

                                            const str = $('c[r=C'+x+'] t', sheet).text();
                                            const token = 'g';
                                            
                                            if (str.toLowerCase().includes(token.toLowerCase()) == true) {
                                                $('row:nth-child('+x+') c', sheet).attr('s', '39');
                                            }

                                          // }
                                        });
                                    }
                                }
                            ]
                        });
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


            // Download File
            function btnDownload(id) {
                window.location.href = 'export/function.php?modalDownload='+id;
            }
            function btnExportFiles(id) {
                window.location.href = 'export/function.php?modalDLCD='+id;
            }
            
            // File Upload and Compliance Checking
            function btnFileUploads(id, type) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalFileUploads="+id+"&type="+type,
                    dataType: "html",
                    success: function(data){
                        $("#modalFileUploads .modal-body table tbody").html(data);
                    }
                });
            }
            function btnFileUploadOther(id, section, type) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalFileUploadOther="+id+"&section="+section+"&type="+type,
                    dataType: "html",
                    success: function(data){
                        $("#modalFileUploadOther .modal-body table tbody").html(data);
                    }
                });
            }
            function btnComplianceList(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalComplianceList="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalComplianceList .modal-body table tbody").html(data);
                    }
                });
            }

            // History Section
            function btnHistory(id) {
                $("#modalHistory .modal-body").html('');

                $.ajax({
                    type: "GET",
                    url: "function.php?modalHistory="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalHistory .modal-body").html(data);
                    }
                });
            }
            function btnRevision(id) {
                $("#modalHistory .revision").html('');

                $.ajax({
                    type: "GET",
                    url: "function.php?modalHistoryRevision="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalHistory .revision").html(data);
                    }
                });
            }
            function printDiv() {
                var divContents = document.getElementById("revisionContent").innerHTML;
                var a = window.open('', '');
                a.document.write('<html>');
                a.document.write('<body >');
                a.document.write('<style>table { width: 100% !important; margin-left: unset !important; margin-right: unset !important; }</style>');
                a.document.write(divContents);
                a.document.write('</body></html>');
                a.document.close();
                a.print();
            }


            function btnViewPoam(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewPoam="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewPoam .modal-body").html(data);
                    }
                });
            }
            function btnViewMilestone(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewMilestone="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewMilestone .modal-body tbody").html(data);
                    }
                });
            }
            $(".modalViewPoam").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Poam',true);

                var l = Ladda.create(document.querySelector('#btnSave_Poam'));
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
                            $('#modalViewPoam').modal('hide');

                            var obj = jQuery.parseJSON(response);
                            $('#tr_poam_'+obj.ID).html(obj.data);
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalAddMiles").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Miles',true);

                var l = Ladda.create(document.querySelector('#btnSave_Miles'));
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
                            $('#modalAddMiles').modal('hide');

                            var obj = jQuery.parseJSON(response);
                            $('#modalViewPoam table tbody').append(obj.data);
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnEditMiles(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalEdit_Miles="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalEditMiles .modal-body").html(data);
                    }
                });
            }
            $(".modalEditMiles").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnEdit_Miles',true);

                var l = Ladda.create(document.querySelector('#btnEdit_Miles'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        alert(response);
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            $('#modalEditMiles').modal('hide');

                            var obj = jQuery.parseJSON(response);
                            $('#modalViewPoam table tbody #tr_'+obj.ID).html(obj.data);
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnDeleteMiles(id) {
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
                        url: "function.php?modalDelete_Miles="+id,
                        dataType: "html",
                        success: function(response){
                            $('#modalViewPoam tbody #tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            
            
            function cmmcPie(cmmcAnalytics) {
                am4core.ready(function() {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                var container = am4core.create("chartMet", am4core.Container);
                container.width = am4core.percent(100);
                container.height = am4core.percent(100);
                container.layout = "horizontal";


                var chart = container.createChild(am4charts.PieChart);
                chart.data = cmmcAnalytics;

                // Add and configure Series
                var pieSeries = chart.series.push(new am4charts.PieSeries());
                pieSeries.dataFields.value = "percent";
                pieSeries.dataFields.category = "text";
                pieSeries.slices.template.states.getKey("active").properties.shiftRadius = 0;
                //pieSeries.labels.template.text = "{category}\n{value.percent.formatNumber('#.#')}%";

                pieSeries.slices.template.events.on("hit", function(event) {
                  selectSlice(event.target.dataItem);
                })

                var chart2 = container.createChild(am4charts.PieChart);
                chart2.width = am4core.percent(30);
                chart2.radius = am4core.percent(80);

                // Add and configure Series
                var pieSeries2 = chart2.series.push(new am4charts.PieSeries());
                pieSeries2.dataFields.value = "value";
                pieSeries2.dataFields.category = "name";
                pieSeries2.slices.template.states.getKey("active").properties.shiftRadius = 0;
                //pieSeries2.labels.template.radius = am4core.percent(50);
                //pieSeries2.labels.template.inside = true;
                //pieSeries2.labels.template.fill = am4core.color("#ffffff");
                pieSeries2.labels.template.disabled = true;
                pieSeries2.ticks.template.disabled = true;
                pieSeries2.alignLabels = false;
                pieSeries2.events.on("positionchanged", updateLines);

                var interfaceColors = new am4core.InterfaceColorSet();

                var line1 = container.createChild(am4core.Line);
                line1.strokeDasharray = "2,2";
                line1.strokeOpacity = 0.5;
                line1.stroke = interfaceColors.getFor("alternativeBackground");
                line1.isMeasured = false;

                var line2 = container.createChild(am4core.Line);
                line2.strokeDasharray = "2,2";
                line2.strokeOpacity = 0.5;
                line2.stroke = interfaceColors.getFor("alternativeBackground");
                line2.isMeasured = false;

                var selectedSlice;

                function selectSlice(dataItem) {

                  selectedSlice = dataItem.slice;

                  var fill = selectedSlice.fill;

                  var count = dataItem.dataContext.subData.length;
                  pieSeries2.colors.list = [];
                  for (var i = 0; i < count; i++) {
                    pieSeries2.colors.list.push(fill.brighten(i * 2 / count));
                  }

                  chart2.data = dataItem.dataContext.subData;
                  pieSeries2.appear();

                  var middleAngle = selectedSlice.middleAngle;
                  var firstAngle = pieSeries.slices.getIndex(0).startAngle;
                  var animation = pieSeries.animate([{ property: "startAngle", to: firstAngle - middleAngle }, { property: "endAngle", to: firstAngle - middleAngle + 360 }], 600, am4core.ease.sinOut);
                  animation.events.on("animationprogress", updateLines);

                  selectedSlice.events.on("transformed", updateLines);

                //  var animation = chart2.animate({property:"dx", from:-container.pixelWidth / 2, to:0}, 2000, am4core.ease.elasticOut)
                //  animation.events.on("animationprogress", updateLines)
                }


                function updateLines() {
                  if (selectedSlice) {
                    var p11 = { x: selectedSlice.radius * am4core.math.cos(selectedSlice.startAngle), y: selectedSlice.radius * am4core.math.sin(selectedSlice.startAngle) };
                    var p12 = { x: selectedSlice.radius * am4core.math.cos(selectedSlice.startAngle + selectedSlice.arc), y: selectedSlice.radius * am4core.math.sin(selectedSlice.startAngle + selectedSlice.arc) };

                    p11 = am4core.utils.spritePointToSvg(p11, selectedSlice);
                    p12 = am4core.utils.spritePointToSvg(p12, selectedSlice);

                    var p21 = { x: 0, y: -pieSeries2.pixelRadius };
                    var p22 = { x: 0, y: pieSeries2.pixelRadius };

                    p21 = am4core.utils.spritePointToSvg(p21, pieSeries2);
                    p22 = am4core.utils.spritePointToSvg(p22, pieSeries2);

                    line1.x1 = p11.x;
                    line1.x2 = p21.x;
                    line1.y1 = p11.y;
                    line1.y2 = p21.y;

                    line2.x1 = p12.x;
                    line2.x2 = p22.x;
                    line2.y1 = p12.y;
                    line2.y2 = p22.y;
                  }
                }

                chart.events.on("datavalidated", function() {
                  setTimeout(function() {
                    selectSlice(pieSeries.dataItems.getIndex(0));
                  }, 1000);
                });


                }); // end am4core.ready()
            }
            function cmmcPie2(cmmcAnalytics) {
                am4core.ready(function() {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                var container = am4core.create("chartMet2", am4core.Container);
                container.width = am4core.percent(100);
                container.height = am4core.percent(100);
                container.layout = "horizontal";


                var chart = container.createChild(am4charts.PieChart);
                chart.data = cmmcAnalytics;

                // Add and configure Series
                var pieSeries = chart.series.push(new am4charts.PieSeries());
                pieSeries.dataFields.value = "point";
                pieSeries.dataFields.category = "text";
                pieSeries.slices.template.states.getKey("active").properties.shiftRadius = 0;
                pieSeries.labels.template.text = "{category} ({value} pts.)";

                pieSeries.slices.template.events.on("hit", function(event) {
                  selectSlice(event.target.dataItem);
                })

                var chart2 = container.createChild(am4charts.PieChart);
                chart2.width = am4core.percent(30);
                chart2.radius = am4core.percent(80);

                // Add and configure Series
                var pieSeries2 = chart2.series.push(new am4charts.PieSeries());
                pieSeries2.dataFields.value = "value";
                pieSeries2.dataFields.category = "name";
                pieSeries2.slices.template.states.getKey("active").properties.shiftRadius = 0;
                //pieSeries2.labels.template.radius = am4core.percent(50);
                //pieSeries2.labels.template.inside = true;
                //pieSeries2.labels.template.fill = am4core.color("#ffffff");
                pieSeries2.labels.template.disabled = true;
                pieSeries2.ticks.template.disabled = true;
                pieSeries2.alignLabels = false;
                pieSeries2.events.on("positionchanged", updateLines);

                var interfaceColors = new am4core.InterfaceColorSet();

                var line1 = container.createChild(am4core.Line);
                line1.strokeDasharray = "2,2";
                line1.strokeOpacity = 0.5;
                line1.stroke = interfaceColors.getFor("alternativeBackground");
                line1.isMeasured = false;

                var line2 = container.createChild(am4core.Line);
                line2.strokeDasharray = "2,2";
                line2.strokeOpacity = 0.5;
                line2.stroke = interfaceColors.getFor("alternativeBackground");
                line2.isMeasured = false;

                var selectedSlice;

                function selectSlice(dataItem) {

                  selectedSlice = dataItem.slice;

                  var fill = selectedSlice.fill;

                  var count = dataItem.dataContext.subData.length;
                  pieSeries2.colors.list = [];
                  for (var i = 0; i < count; i++) {
                    pieSeries2.colors.list.push(fill.brighten(i * 2 / count));
                  }

                  chart2.data = dataItem.dataContext.subData;
                  pieSeries2.appear();

                  var middleAngle = selectedSlice.middleAngle;
                  var firstAngle = pieSeries.slices.getIndex(0).startAngle;
                  var animation = pieSeries.animate([{ property: "startAngle", to: firstAngle - middleAngle }, { property: "endAngle", to: firstAngle - middleAngle + 360 }], 600, am4core.ease.sinOut);
                  animation.events.on("animationprogress", updateLines);

                  selectedSlice.events.on("transformed", updateLines);

                //  var animation = chart2.animate({property:"dx", from:-container.pixelWidth / 2, to:0}, 2000, am4core.ease.elasticOut)
                //  animation.events.on("animationprogress", updateLines)
                }


                function updateLines() {
                  if (selectedSlice) {
                    var p11 = { x: selectedSlice.radius * am4core.math.cos(selectedSlice.startAngle), y: selectedSlice.radius * am4core.math.sin(selectedSlice.startAngle) };
                    var p12 = { x: selectedSlice.radius * am4core.math.cos(selectedSlice.startAngle + selectedSlice.arc), y: selectedSlice.radius * am4core.math.sin(selectedSlice.startAngle + selectedSlice.arc) };

                    p11 = am4core.utils.spritePointToSvg(p11, selectedSlice);
                    p12 = am4core.utils.spritePointToSvg(p12, selectedSlice);

                    var p21 = { x: 0, y: -pieSeries2.pixelRadius };
                    var p22 = { x: 0, y: pieSeries2.pixelRadius };

                    p21 = am4core.utils.spritePointToSvg(p21, pieSeries2);
                    p22 = am4core.utils.spritePointToSvg(p22, pieSeries2);

                    line1.x1 = p11.x;
                    line1.x2 = p21.x;
                    line1.y1 = p11.y;
                    line1.y2 = p21.y;

                    line2.x1 = p12.x;
                    line2.x2 = p22.x;
                    line2.y1 = p12.y;
                    line2.y2 = p22.y;
                  }
                }

                chart.events.on("datavalidated", function() {
                  setTimeout(function() {
                    selectSlice(pieSeries.dataItems.getIndex(0));
                  }, 1000);
                });


                }); // end am4core.ready()
            }
        </script>
    </body>
</html>
