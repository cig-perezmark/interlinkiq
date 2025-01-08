<?php 
    $title = "Supplier";
    $site = "supplier";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    .bootstrap-tagsinput { min-height: 100px; }
    .mt-checkbox-list {
        column-count: 3;
        column-gap: 40px;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }

    /* DataTable*/
    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {
        position: relative;
    }
    .table thead tr th {
        vertical-align: middle;
    }
</style>

                    <div class="row hide">
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_1">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-green-sharp"><span>0</span></h3>
                                        <small>Total Active Supplier</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-user-following"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success green-sharp"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_2">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-red-haze"><span>0</span></h3>
                                        <small>Total Inactive Supplier</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-user-unfollow"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success red-haze"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2  counterup_3">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-blue-sharp"><span>0</span></h3>
                                        <small>Current Inactive Supplier</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-calendar"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success blue-sharp"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage for this month</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_4">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-purple-soft"><span>0</span></h3>
                                        <small>Total Supplier</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-users"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success purple-soft"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-basket-loaded font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">List of Supplier  </span> - 
                                        <?php
                                            $sql = "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND user_id = '$switch_user_id' OR page = '$site' AND user_id = '163' OR page = '$site' AND user_id = '$current_userEmployerID' " ; 
                                            $result = mysqli_query ($conn, $sql);
                                            while ($row = mysqli_fetch_assoc($result)){?>   
                                                <!--<a data-toggle="modal" data-target="#view_video" class="view_videos"  file_name="<?= $row['youtube_link'] ?>"><?= $row['file_title'] ?></a>-->
                                                <a class="view_videos" data-src="<?= $row['youtube_link'] ?>" data-fancybox><i class="fa fa-youtube"></i><?= $row['file_title'] ?></a>
                                                <?= "/" ?>
                                        <?php } ?>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#modalNew" >Add New Supplier</a>
                                                </li>
                                                <li class="divider"> </li>
                                                <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163): ?>
                                                <li>
                                                    <a data-toggle="modal" data-target="#modal_video">Add Video</a>
                                                </li>
                                                <?php endif; ?>
                                                <li>
                                                    <a href="javascript:;">Option 3</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">Option 4</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_actions_all" data-toggle="tab">All</a>
                                        </li>
                                        <li>
                                            <a href="#tab_actions_sent" data-toggle="tab">Sent</a>
                                        </li>
                                        <li>
                                            <a href="#tab_actions_received" data-toggle="tab">Received</a>
                                        </li>
                                        <li>
                                            <a href="#tab_actions_template" data-toggle="tab">Template</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_actions_all">
                                            <div class="table-scrollable" style="border: 0;">
                                                <table class="table table-bordered table-hover" id="tableData_4">
                                                    <thead>
                                                        <tr>
                                                            <th>ID#</th>
                                                            <th>Supplier Name</th>
                                                            <th>From Name</th>
                                                            <th>From Email</th>
                                                            <th>To Name</th>
                                                            <th>To Email</th>
                                                            <th>Requirement</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            // $result = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE notification = 1 AND is_deleted = 0 AND ID = 558 ORDER BY name" );
                                                            $result = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE notification = 1 AND is_deleted = 0 ORDER BY name" );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $ID = $row["ID"];
                                                                    $user_id = $row["user_id"];
                                                                    $page = $row["page"];
                                                                    $name = $row["name"];
                                                                    $email = $row["email"];
                                                                    $contact = $row["contact"];
                                                                    $status = $row["status"];

                                                                    $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $user_id" );
                                                                    if ( mysqli_num_rows($selectUser) > 0 ) {
                                                                        $rowUser = mysqli_fetch_array($selectUser);
                                                                        $rowUser_name = $rowUser["first_name"] .' '. $rowUser["last_name"];
                                                                        $rowUser_email = $rowUser["email"];
                                                                    }

                                                                    $document = $row["document"];
                                                                    $document_arr = explode(", ", $document);

                                                                    $document_other = $row["document_other"];
                                                                    $document_other_arr = explode(", ", $document_other);

                                                                    $compliance = 0;
                                                                    $compliance_counter = 0;
                                                                    $compliance_approved = 0;

                                                                    $name_arr = array();
                                                                    $email_arr = array();
                                                                    $req_arr = array();
                                                                    // if ($status == 1) {
                                                                        array_push($name_arr, $name);
                                                                        array_push($email_arr, $email);

                                                                        if (!empty($contact)) {
                                                                            $contact_arr = explode(", ", $contact);
                                                                            foreach ($contact_arr as $value) {
                                                                                $selectContact = mysqli_query( $conn,"SELECT * FROM tbl_supplier_contact WHERE ID=$value" );
                                                                                if ( mysqli_num_rows($selectContact) > 0 ) {
                                                                                    while($rowContact = mysqli_fetch_array($selectContact)) {
                                                                                        $contact_name = $rowContact["name"];
                                                                                        $contact_email = $rowContact["email"];

                                                                                        array_push($name_arr, $contact_name);
                                                                                        array_push($email_arr, $contact_email);
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        if (!empty($document)) {
                                                                            $selectRequirement = mysqli_query( $conn,"SELECT * FROM tbl_supplier_requirement ORDER BY name" );
                                                                            while($rowRequirement = mysqli_fetch_array($selectRequirement)) {
                                                                                $req_id = $rowRequirement["ID"];
                                                                                $req_name = $rowRequirement["name"];

                                                                                foreach ($document_arr as $value) {
                                                                                    if ( $value == $req_id ) {
                                                                                        $selectDocument = mysqli_query( $conn,"SELECT * FROM tbl_supplier_document WHERE user_id = $user_id AND supplier_id = $ID AND type = 0 AND name = '".$req_id."'" );
                                                                                        if ( mysqli_num_rows($selectDocument) > 0 ) {
                                                                                            $rowDocument = mysqli_fetch_array($selectDocument);
                                                                                            $doc_file = $rowDocument["file"];

                                                                                            if (empty($doc_file)) {
                                                                                                array_push($req_arr, $req_name);
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        if (!empty($document_other)) {
                                                                            $count_other = 0;
                                                                            foreach ($document_other_arr as $value) {
                                                                                $selectDocument = mysqli_query( $conn,"SELECT * FROM tbl_supplier_document WHERE user_id = $user_id AND supplier_id = $ID AND type = 1 AND name = '".$value."'" );
                                                                                if ( mysqli_num_rows($selectDocument) > 0 ) {
                                                                                    $rowDocument = mysqli_fetch_array($selectDocument);
                                                                                    $doc_file = $rowDocument["file"];

                                                                                    if (empty($doc_file)) {
                                                                                        array_push($req_arr, $value);
                                                                                    }
                                                                                }
                                                                            }
                                                                        }


                                                                        if (!empty($req_arr)) {
                                                                            echo '<tr id="tr_'. $ID .'">
                                                                                <td>'. $ID .'</td>
                                                                                <td>'. $name .'</td>
                                                                                <td>'. $rowUser_name .'</td>
                                                                                <td>'. $rowUser_email .'</td>
                                                                                <td>'. implode(' | ', $name_arr) .'</td>
                                                                                <td>'. implode(' | ', $email_arr) .'</td>
                                                                                <td>'. implode(' | ', $req_arr) .'</td>
                                                                            </tr>';
                                                                        }
                                                                    // }

                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_actions_sent">
                                            <div class="table-scrollable" style="border: 0;">
                                            <table class="table table-bordered table-hover" id="tableData_1">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">ID#</th>
                                                        <th rowspan="2">Supplier Name</th>
                                                        <th rowspan="2">Category</th>
                                                        <th rowspan="2">Materials/Services</th>
                                                        <th colspan="3" class="text-center">Contact Details</th>
                                                        <th rowspan="2" style="width: 155px;" class="text-center">Annual Review Due</th>
                                                        <th rowspan="2" style="width: 100px;" class="text-center">Compliance</th>
                                                        <th rowspan="2" style="width: 100px;" class="text-center">Status</th>
                                                        <th rowspan="2" style="width: 135px;" class="text-center">Action</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Address</th>
                                                        <th>Contact Info</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $result = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE page = 1 AND is_deleted = 0 AND user_id = $switch_user_id ORDER BY name" );
                                                        // $result = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE is_deleted = 0" );
                                                        if ( mysqli_num_rows($result) > 0 ) {
                                                            $table_counter = 1;
                                                            while($row = mysqli_fetch_array($result)) {
                                                                $ID = $row["ID"];
                                                                $page = $row["page"];
                                                                $data_user_id = $row["user_id"];
                                                                $name = $row["name"];
                                                                $email = $row["email"];
                                                                $contact = $row["contact"];
                                                                $compliance = $row["compliance"];
                                                                $reviewed_due = $row["reviewed_due"];
                                                                $status = $row["status"];
                                                                $status_type = array(
                                                                    0 => 'Pending',
                                                                    1 => 'Approved',
                                                                    2 => 'Non Approved',
                                                                    3 => 'Emergency Use Only',
                                                                    4 => 'Do Not Use'
                                                                );
    
                                                                $category = $row["category"];
                                                                $category_name = "";
                                                                if (!empty($category)) {
                                                                    $selectCategory = mysqli_query( $conn,'SELECT * FROM tbl_supplier_category WHERE ID="'. $category .'" ORDER BY ID LIMIT 1' );
                                                                    $rowCategory = mysqli_fetch_array($selectCategory);
                                                                    $category_name = $rowCategory['name'];
                                                                }
    
                                                                if ($page == "1") {
                                                                    if ($category == "3") {
                                                                        $material = $row["service"];
                                                                        if (!empty($material)) {
                                                                            $material_result = array();
                                                                            $material_arr = explode(", ", $material);
                                                                            foreach ($material_arr as $value) {
                                                                                $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_supplier_service WHERE ID=$value" );
                                                                                $rowMaterial = mysqli_fetch_array($selectMaterial);
                                                                                array_push($material_result, $rowMaterial['service_name']);
                                                                            }
                                                                            $material = implode(', ', $material_result);
                                                                        }
                                                                    } else {
                                                                        $material = $row["material"];
                                                                        if (!empty($material)) {
                                                                            $material_result = array();
                                                                            $material_arr = explode(", ", $material);
                                                                            foreach ($material_arr as $value) {
                                                                                $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_supplier_material WHERE ID=$value" );
                                                                                $rowMaterial = mysqli_fetch_array($selectMaterial);
                                                                                array_push($material_result, $rowMaterial['material_name']);
                                                                            }
                                                                            $material = implode(', ', $material_result);
                                                                        }
                                                                    }
    
                                                                    echo '<tr id="tr_'. $ID .'">
                                                                        <td>'. $table_counter++ .'</td>
                                                                        <td>'. $name .'</td>
                                                                        <td>'. $category_name .'</td>
                                                                        <td>'. $material .'</td>';

                                                                        if (!empty($contact)) {
                                                                            $contact_arr = explode(", ", $contact);
                                                                            foreach ($contact_arr as $value) {
                                                                                $selectContact = mysqli_query( $conn,"SELECT * FROM tbl_supplier_contact WHERE ID=$value" );
                                                                                if ( mysqli_num_rows($selectContact) > 0 ) {
                                                                                    $rowContact = mysqli_fetch_array($selectContact);
                                                                                    $contact_name = $rowContact["name"];
                                                                                    $contact_address = $rowContact["address"];
                                                                                    $contact_email = $rowContact["email"];
                                                                                    $contact_phone = $rowContact["phone"];
                                                                                    $contact_cell = $rowContact["cell"];
                                                                                    $contact_fax = $rowContact["fax"];
    
                                                                                    echo '<td>'.$contact_name.'</td>
                                                                                    <td>'.$contact_address.'</td>
                                                                                    <td class="text-center">
                                                                                        <ul class="list-inline">';
                                                                                        if ($contact_email != "") { echo '<li><a href="mailto:'.$contact_email.'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
                                                                                        if ($contact_phone != "") { echo '<li><a href="tel:'.$contact_phone.'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
                                                                                        if ($contact_cell != "") { echo '<li><a href="tel:'.$contact_cell.'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
                                                                                        if ($contact_fax != "") { echo '<li><a href="tel:'.$contact_fax.'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
                                                                                        echo '</ul>
                                                                                    </td>';
    
                                                                                    break;
                                                                                }
                                                                            }
                                                                        } else {
                                                                            echo '<td></td><td></td><td></td>';
                                                                        }
                                                                        
                                                                        echo '<td class="text-center">'. $reviewed_due .'</td>
                                                                        <td class="text-center">'.intval($compliance).'%</td>
                                                                        <td class="text-center">'.$status_type[$status].'</td>';
                                                                        
                                                                        echo '<td class="text-center">
                                                                            <div class="btn-group btn-group-circle">
                                                                                <a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('. $ID .')">View</a>
                                                                                <a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('. $ID .')">Delete</a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>
                                        <div class="tab-pane" id="tab_actions_received">
                                            <div class="table-scrollable" style="border: 0;">
                                            <table class="table table-bordered table-hover" id="tableData_2">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">ID#</th>
                                                        <th rowspan="2">Supplier Name</th>
                                                        <th rowspan="2">Category</th>
                                                        <th rowspan="2">Materials/Services</th>
                                                        <th colspan="3" class="text-center">Contact Details</th>
                                                        <th rowspan="2" style="width: 155px;" class="text-center">Annual Review Due</th>
                                                        <th rowspan="2" style="width: 100px;" class="text-center">Compliance</th>
                                                        <th rowspan="2" style="width: 100px;" class="text-center">Status</th>
                                                        <th rowspan="2" style="width: 135px;" class="text-center">Action</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Address</th>
                                                        <th>Contact Info</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $result = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE page = 2 AND is_deleted = 0 AND email = '".$current_userEmail."' ORDER BY name" );
                                                        // $result = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE is_deleted = 0" );
                                                        if ( mysqli_num_rows($result) > 0 ) {
                                                            $table_counter = 1;
                                                            while($row = mysqli_fetch_array($result)) {
                                                                $ID = $row["ID"];
                                                                $page = $row["page"];
                                                                $data_user_id = $row["user_id"];
                                                                $name = $row["name"];
                                                                $email = $row["email"];
                                                                $contact = $row["contact"];
                                                                $compliance = $row["compliance"];
                                                                $reviewed_due = $row["reviewed_due"];
                                                                $status = $row["status"];
                                                                $status_type = array(
                                                                    0 => 'Pending',
                                                                    1 => 'Approved',
                                                                    2 => 'Non Approved',
                                                                    3 => 'Emergency Use Only',
                                                                    4 => 'Do Not Use'
                                                                );
    
                                                                $category = $row["category"];
                                                                $category_name = "";
                                                                if (!empty($category)) {
                                                                    $selectCategory = mysqli_query( $conn,'SELECT * FROM tbl_supplier_category WHERE ID="'. $category .'" ORDER BY ID LIMIT 1' );
                                                                    $rowCategory = mysqli_fetch_array($selectCategory);
                                                                    $category_name = $rowCategory['name'];
                                                                }
    
                                                                if ($page == "2") {
                                                                    if ($category == "3") {
                                                                        $material = $row["service"];
                                                                        if (!empty($material)) {
                                                                            $material_result = array();
                                                                            $material_arr = explode(", ", $material);
                                                                            foreach ($material_arr as $value) {
                                                                                $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_supplier_service WHERE ID=$value" );
                                                                                $rowMaterial = mysqli_fetch_array($selectMaterial);
                                                                                $service_id = $rowMaterial['service_name'];
    
                                                                                $selectServiceCategory = mysqli_query( $conn,"SELECT * FROM tbl_service_category WHERE id=$service_id" );
                                                                                $rowServiceCategory = mysqli_fetch_array($selectServiceCategory);
                                                                                array_push($material_result, $rowServiceCategory['service_category']);
                                                                            }
                                                                            $material = implode(', ', $material_result);
                                                                        }
                                                                    } else {
                                                                        $material = $row["material"];
                                                                        if (!empty($material)) {
                                                                            $material_result = array();
                                                                            $material_arr = explode(", ", $material);
                                                                            foreach ($material_arr as $value) {
                                                                                $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_supplier_material WHERE ID=$value" );
                                                                                $rowMaterial = mysqli_fetch_array($selectMaterial);
                                                                                $material_id = $rowMaterial['material_name'];
    
                                                                                $selectProduct = mysqli_query( $conn,"SELECT * FROM tbl_products WHERE ID=$material_id" );
                                                                                $rowProduct = mysqli_fetch_array($selectProduct);
                                                                                array_push($material_result, $rowProduct['name']);
                                                                            }
                                                                            $material = implode(', ', $material_result);
                                                                        }
                                                                    }
                                                                    
                                                                    $name = "";
                                                                    $selectEnterprise = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails WHERE users_entities = $data_user_id" );
                                                                    if ( mysqli_num_rows($selectEnterprise) > 0 ) {
                                                                        $rowEnterprise = mysqli_fetch_array($selectEnterprise);
                                                                        $name = $rowEnterprise["businessname"];
                                                                    }
    
                                                                    echo '<tr id="tr_'. $ID .'">
                                                                        <td>'. $table_counter++ .'</td>
                                                                        <td>'. $name .'</td>
                                                                        <td>'. $category_name .'</td>
                                                                        <td>'. $material .'</td>';

                                                                        if (!empty($contact)) {
                                                                            $contact_arr = explode(", ", $contact);
                                                                            foreach ($contact_arr as $value) {
                                                                                $selectContact = mysqli_query( $conn,"SELECT * FROM tbl_supplier_contact WHERE ID=$value" );
                                                                                if ( mysqli_num_rows($selectContact) > 0 ) {
                                                                                    $rowContact = mysqli_fetch_array($selectContact);
                                                                                    $contact_name = $rowContact["name"];
                                                                                    $contact_address = $rowContact["address"];
                                                                                    $contact_email = $rowContact["email"];
                                                                                    $contact_phone = $rowContact["phone"];
                                                                                    $contact_cell = $rowContact["cell"];
                                                                                    $contact_fax = $rowContact["fax"];

                                                                                    echo '<td>'.$contact_name.'</td>
                                                                                    <td>'.$contact_address.'</td>
                                                                                    <td class="text-center">
                                                                                        <ul class="list-inline">';
                                                                                        if ($contact_email != "") { echo '<li><a href="mailto:'.$contact_email.'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
                                                                                        if ($contact_phone != "") { echo '<li><a href="tel:'.$contact_phone.'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
                                                                                        if ($contact_cell != "") { echo '<li><a href="tel:'.$contact_cell.'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
                                                                                        if ($contact_fax != "") { echo '<li><a href="tel:'.$contact_fax.'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
                                                                                        echo '</ul>
                                                                                    </td>';

                                                                                    break;
                                                                                }
                                                                            }
                                                                        } else {
                                                                            echo '<td></td><td></td><td></td>';
                                                                        }

                                                                        echo '<td class="text-center">'. $reviewed_due .'</td>
                                                                        <td class="text-center">'.intval($compliance).'%</td>
                                                                        <td class="text-center">'.$status_type[$status].'</td>';
                                                                        
                                                                        echo '<td class="text-center">
                                                                            <a href="#modalView" class="btn btn-outline btn-success btn-sm btn-circle btnView" data-toggle="modal" onclick="btnView('. $ID .')">View</a>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>
                                        <div class="tab-pane" id="tab_actions_template">
                                            <div class="table-scrollable">
                                                <table class="table table-bordered table-hover" id="tableData_3">
                                                    <thead>
                                                        <tr>
                                                            <th>Template Name</th>
                                                            <th class="text-center" style="width: 185px;">File</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $result = mysqli_query( $conn,"SELECT * FROM tbl_supplier_requirement ORDER BY name" );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $ID = $row["ID"];
                                                                    $name = $row["name"];

                                                                    echo '<tr id="tr_'.$ID.'">
                                                                        <td>'.$name.'</td>
                                                                        <td class="text-center">';

                                                                            $selectTemplate = mysqli_query( $conn,"SELECT * FROM tbl_supplier_template WHERE user_id = $switch_user_id AND requirement_id = $ID" );
                                                                            if ( mysqli_num_rows($selectTemplate) > 0 ) {
                                                                                $rowTemplate = mysqli_fetch_array($selectTemplate);
                                                                                $temp_ID = $rowTemplate["ID"];
                                                                                $temp_file = $rowTemplate["file"];

                                                                                $fileExtension = fileExtension($temp_file);
                                                                                $src = $fileExtension['src'];
                                                                                $embed = $fileExtension['embed'];
                                                                                $type = $fileExtension['type'];
                                                                                $file_extension = $fileExtension['file_extension'];
                                                                                $url = $base_url.'uploads/supplier/';

                                                                                echo '<p style="margin: 0;">
                                                                                    <a href="'.$src.$url.rawurlencode($temp_file).$embed.'" data-src="'.$src.$url.rawurlencode($temp_file).$embed.'" data-fancybox data-fancybox data-type="'.$type.'" class="btn btn-link">View</a> |
                                                                                    <a href="#modalTemplate" class="btn btn-link" data-toggle="modal" onclick="btnTemplate('.$ID.', '.$temp_ID.')">Upload</a>
                                                                                </p>';
                                                                            } else {
                                                                                echo '<a href="#modalTemplate" class="btn btn-link" data-toggle="modal" onclick="btnTemplate('.$ID.', 0)">Upload</a>';
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
                            <!-- END BORDERED TABLE PORTLET-->
                        </div>

                        <!-- MODAL AREA-->
                        <div class="modal fade" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-full">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalSave">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Supplier Form</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="tabbable tabbable-tabdrop">
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#tabBasic_1" data-toggle="tab">Details</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabContact_1" data-toggle="tab">Contacts</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabDocuments_1" data-toggle="tab">Requirements</a>
                                                    </li>
                                                    <li class="tabMaterials">
                                                        <a href="#tabMaterials_1" data-toggle="tab">Materials</a>
                                                    </li>
                                                    <li class="tabService hide">
                                                        <a href="#tabService_1" data-toggle="tab">Services</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tabAuditReview_1" data-toggle="tab">Audit & Review</a>
                                                    </li>
                                                    <li class="hide">
                                                        <a href="#tabFSVP_1" data-toggle="tab">FSVP</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content margin-top-20">
                                                    <div class="tab-pane active" id="tabBasic_1">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Supplier Name</label>
                                                                    <input class="form-control" type="text" name="supplier_name" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Category</label>
                                                                    <select class="form-control" name="supplier_category" onchange="changedCategory(this)" required>
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                            $selectCategory = mysqli_query( $conn,"SELECT * FROM tbl_supplier_category" );
                                                                            if ( mysqli_num_rows($selectCategory) > 0 ) {
                                                                                while($row = mysqli_fetch_array($selectCategory)) {
                                                                                    echo '<option value="'.$row["ID"].'">'.$row["name"].'</option>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Industry</label>
                                                                    <select class="form-control" name="supplier_industry" onchange="changeIndustry(this.value, 1)" required>
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                            $selectIndustry = mysqli_query( $conn,"SELECT * FROM tbl_supplier_industry" );
                                                                            if ( mysqli_num_rows($selectIndustry) > 0 ) {
                                                                                while($row = mysqli_fetch_array($selectIndustry)) {
                                                                                    echo '<option value="'.$row["ID"].'">'.$row["name"].'</option>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Country</label>
                                                                    <select class="form-control" name="supplier_countries" onchange="changeCountry(1)">
                                                                        <option value="US">United States of America</option>

                                                                        <?php
                                                                            $selectCountry = mysqli_query( $conn,"SELECT * FROM countries WHERE iso2 <> 'US'" );
                                                                            while($rowCountry = mysqli_fetch_array($selectCountry)) {
                                                                                echo '<option value="'.$rowCountry["iso2"].'">'.$rowCountry["name"].'</option>';
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Bldg No./Street</label>
                                                                    <input class="form-control" type="text" name="supplier_address_street" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">City</label>
                                                                    <input class="form-control" type="text" name="supplier_address_city" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">State</label>
                                                                    <input class="form-control" type="text" name="supplier_address_state" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Zip Code</label>
                                                                    <input class="form-control" type="text" name="supplier_address_code" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Email</label>
                                                                    <input class="form-control" type="email" name="supplier_email" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Phone</label>
                                                                    <input class="form-control" type="text" name="supplier_phone" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Fax</label>
                                                                    <input class="form-control" type="text" name="supplier_fax" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Website</label>
                                                                    <input class="form-control" type="text" name="supplier_website" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Status</label>
                                                                    <select class="form-control" name="supplier_status">
                                                                        <option value="0">Pending</option>
                                                                        <option value="1">Approved</option>
                                                                        <option value="2">Non-Approved</option>
                                                                        <option value="3">Emergency Use Only</option>
                                                                        <option value="4">Do Not Use</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabContact_1">
                                                        <a href="#modalNewContact" data-toggle="modal" class="btn green" onclick="btnNew_Contact(<?php echo $current_userEmployerID; ?>, 1)">Add New Contact</a>
                                                        <div class="table-scrollable">
                                                            <table class="table table-bordered table-hover" id="tableData_Contact_1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Title</th>
                                                                        <th>Address</th>
                                                                        <th class="text-center" style="width: 145px;">Contact Details</th>
                                                                        <th class="text-center hide" style="width: 145px;">Emergency Person</th>
                                                                        <th class="text-center" style="width: 140px;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabDocuments_1">
                                                        <div class="mt-checkbox-list">
                                                            <?php
                                                                $selectRequirement2 = mysqli_query( $conn,"SELECT * FROM tbl_supplier_requirement ORDER BY name" );
                                                                if ( mysqli_num_rows($selectRequirement2) > 0 ) {
                                                                    while($row = mysqli_fetch_array($selectRequirement2)) {
                                                                        echo '<label class="mt-checkbox mt-checkbox-outline"> '.$row["name"].'
                                                                            <input type="checkbox" value="'.$row["ID"].'" name="document[]"  onchange="checked_Requirement(this, 1)" />
                                                                            <span></span>
                                                                        </label>';
                                                                    }
                                                                }
                                                            ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Other</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="inputRequirementOther" id="inputRequirementOther_1" placeholder="Specify">
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-success" type="button" onclick="btnNew_Requirement(1)">Add</button>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="table-scrollable">
                                                            <table class="table table-bordered table-hover" id="tableData_Requirement_1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Requirements</th>
                                                                        <th style="width: 175px;">Document</th>
                                                                        <th>File Name</th>
                                                                        <th style="width: 170px;">Document Date (From Start to Due)</th>
                                                                        <th class="text-center" style="width: 105px;">Compliance</th>
                                                                        <th class="text-center" style="width: 225px;">Template</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabMaterials_1">
                                                        <a href="#modalNewMaterial" data-toggle="modal" class="btn green" onclick="btnNew_Material(<?php echo $current_userEmployerID; ?>, 1)">Add New Material</a>
                                                        <div class="table-scrollable">
                                                            <table class="table table-bordered table-hover" id="tableData_Material_1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Material Name</th>
                                                                        <th>Material ID</th>
                                                                        <th>Description</th>
                                                                        <th class="text-center" style="width: 135px;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabService_1">
                                                        <a href="#modalNewService" data-toggle="modal" class="btn green" onclick="btnNew_Service(<?php echo $current_userEmployerID; ?>, 1)">Add New Service</a>
                                                        <div class="table-scrollable">
                                                            <table class="table table-bordered table-hover" id="tableData_Service_1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Service Name</th>
                                                                        <th>Service ID</th>
                                                                        <th>Description</th>
                                                                        <th class="text-center" style="width: 135px;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabAuditReview_1">
                                                        <h4><strong>Auditing Body</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Audit Report</label>
                                                                    <input class="form-control" type="file" name="audit_report_file" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Document Date</label>
                                                                    <input class="form-control" type="date" name="audit_report_date" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Document Due Date</label>
                                                                    <input class="form-control" type="date" name="audit_report_due" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Comments / Notes</label>
                                                                    <input class="form-control" type="text" name="audit_report_note" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Audit Certificate</label>
                                                                    <input class="form-control" type="file" name="audit_certificate_file" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Document Date</label>
                                                                    <input class="form-control" type="date" name="audit_certificate_date" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Document Due Date</label>
                                                                    <input class="form-control" type="date" name="audit_certificate_due" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Comments / Notes</label>
                                                                    <input class="form-control" type="text" name="audit_certificate_note" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Audit Corrective Action</label>
                                                                    <input class="form-control" type="file" name="audit_action_file" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Document Date</label>
                                                                    <input class="form-control" type="date" name="audit_action_date" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Document Due Date</label>
                                                                    <input class="form-control" type="date" name="audit_action_due" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Comments / Notes</label>
                                                                    <input class="form-control" type="text" name="audit_action_note" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 hide">
                                                                <h4><strong>Auditing Body</strong></h4>
                                                                <div class="form-group">
                                                                    <label class="control-label">Add Auditing</label>
                                                                    <input type="text" class="form-control tagsinput" name="audit" data-role="tagsinput" placeholder="Specify" />
                                                                    <span class="form-text text-muted">Hit enter button to add more</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <h4><strong>Annual Review</strong></h4>
                                                                <div class="form-group">
                                                                    <label class="control-label">Reviewed by</label>
                                                                    <input class="form-control" type="text" name="reviewed_by" />
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Date of Review</label>
                                                                            <input class="form-control" type="date" name="reviewed_date" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Due Date</label>
                                                                            <input class="form-control" type="date" name="reviewed_due" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier" id="btnSave_Supplier" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-full">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Supplier Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Supplier" id="btnUpdate_Supplier" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalNewContact" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalSave_Contact">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Contact</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Contact" id="btnSave_Supplier_Contact" data-style="zoom-out"><span class="ladda-label">Add Contact</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalEditContact" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate_Contact">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Contact Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Supplier_Contact" id="btnUpdate_Supplier_Contact" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalNewMaterial" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalSave_Material">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Material</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Material" id="btnSave_Supplier_Material" data-style="zoom-out"><span class="ladda-label">Add Material</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalEditMaterial" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate_Material">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Material Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Supplier_Material" id="btnUpdate_Supplier_Material" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalNewService" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalSave_Service">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Service</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Service" id="btnSave_Supplier_Service" data-style="zoom-out"><span class="ladda-label">Add Service</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalEditService" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate_Service">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Service Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Supplier_Service" id="btnUpdate_Supplier_Service" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalTemplate" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalSave_Template">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Template File</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Template" id="btnSave_Supplier_Template" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalTemplate2" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalSave_Template2">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Template File</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Template2" id="btnSave_Supplier_Template2" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
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
                        
                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
        
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>

        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        
        <script type="text/javascript">
            $(document).ready(function(){
                // Emjay script starts here
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
    			
                // Emjay script ends here
                
                var site = '<?php echo $site; ?>';
                $.ajax({
                    url: 'function.php?counterup='+site,
                    context: document.body,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        var obj = jQuery.parseJSON(response);
                        var pct_counter1 = (parseInt(obj.statusActive) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter2 = (parseInt(obj.statusInactive) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter3 = (parseInt(obj.statusInactiveMonth) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter4 = (parseInt(obj.statusTotal) / parseInt(obj.statusTotal)) * 100;
                        $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                        $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                        $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                        $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                        $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                        $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                        $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactiveMonth+'"></span>');
                        $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                        $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                        $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusTotal+'"></span>');
                        $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                        $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');
                        
                        $('.counterup').counterUp();
                    }
                });

                if(window.location.href.indexOf('#new') != -1) {
                    $('#modalNew').modal('show');
                }
                $('#tableData_1, #tableData_2, #tableData_4').DataTable();

                changeIndustry(0, 1);

                widget_tagInput();
                widget_formRepeater();
            });

            function uploadNew(e) {
                $(e).parent().hide();
                $(e).parent().prev('.form-control').removeClass('hide');
            }
            function inputInvalid(modal) {
                var error = 0;
                $('.'+modal+' *:invalid').each(function () {
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

            function changedCategory(sel) {
                if (sel.value == 3) {
                    $('.tabMaterials').addClass('hide');
                    $('.tabService').removeClass('hide');
                } else {
                    $('.tabMaterials').removeClass('hide');
                    $('.tabService').addClass('hide');
                }
            }
            function changeIndustry(id, modal) {
                var country = $('#tabBasic_'+modal+' select[name="supplier_countries"]').val();
                if (id == 13 || id == 22 || id == 25) { id = id; }
                else { id = 0; }
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Supplier_Industry="+id+"&c="+country,
                    dataType: "html",                  
                    success: function(data){       
                        $('#tabDocuments_'+modal+' .mt-checkbox-list').html(data);
                        $('#tableData_Requirement_'+modal+' tbody').html('');
                    }
                });
            }
            function changeCountry(modal) {
                var industry = $('#tabBasic_'+modal+' select[name="supplier_countries"]').val();
                changeIndustry(industry, modal);
            }
            function changeFile(e, val) {
                if (val != '') {
                    $(e).parent().parent().find('td .document_filename').attr("required", true);
                    $(e).parent().parent().find('td .daterange').attr("required", true);
                } else {
                    $(e).parent().parent().find('td .document_filename').attr("required", false);
                    $(e).parent().parent().find('td .daterange').attr("required", false);
                }
            }
            function changeCost(val, type) {
                if (type === 1) {
                    var lb = 2.20462 * val;
                    var oz = 35.274 * val;

                    $('.cost_lb').val(lb.toFixed(2));
                    $('.cost_oz').val(oz.toFixed(2));
                } else if (type === 2) {
                    var kg = 0.453592 * val;
                    var oz = 16 * val;

                    $('.cost_kg').val(kg.toFixed(2));
                    $('.cost_oz').val(oz.toFixed(2));
                } else if (type == 3) {
                    var kg = 0.0283495 * val;
                    var lb = 0.0625 * val;

                    $('.cost_kg').val(kg.toFixed(2));
                    $('.cost_lb').val(lb.toFixed(2));
                }
            }

            function btnView(id) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_Supplier="+id,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalView .modal-body").html(data);
                        widget_tagInput();
                        widget_dates();
                    }
                });
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
                        url: "function.php?btnDelete_Supplier="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tableData_1 tbody #tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
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
            function widget_dates() {
                $('#tableData_Requirement_2 tbody .daterange').daterangepicker({
                    ranges: {
                        'Today': [moment().subtract(1, 'day'), moment().subtract(1, 'day')],
                        'One Month': [moment().subtract(1, 'day'), moment().add(1, 'month')],
                        'One Year': [moment().subtract(1, 'day'), moment().add(1, 'year')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto",
                    "opens": "left"
                }, function(start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
                $('#tableData_Requirement_2 tbody .daterange_empty').val('');
            }
            function widget_date(id, modal) {
                $('#tableData_Requirement_'+modal+' tbody .tr_'+id+' .daterange').daterangepicker({
                    ranges: {
                        'Today': [moment().subtract(1, 'day'), moment().subtract(1, 'day')],
                        'One Month': [moment().subtract(1, 'day'), moment().add(1, 'month')],
                        'One Year': [moment().subtract(1, 'day'), moment().add(1, 'year')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto",
                    "opens": "left"
                }, function(start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
            }
            function widget_date_other(id, modal) {
                $('#tableData_Requirement_'+modal+' tbody .tr_other_'+id+' .daterange').daterangepicker({
                    ranges: {
                        'Today': [moment().subtract(1, 'day'), moment().subtract(1, 'day')],
                        'One Month': [moment().subtract(1, 'day'), moment().add(1, 'month')],
                        'One Year': [moment().subtract(1, 'day'), moment().add(1, 'year')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto",
                    "opens": "left"
                }, function(start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
            }
            function widget_date_clears(e) {
                $(e).parent().prev('.daterange').val('');
            }
            function widget_date_clear(id, modal) {
                $('#tableData_Requirement_'+modal+' tbody .tr_'+id+' .daterange').val('');
            }
            function widget_date_clear_other(id, modal) {
                $('#tableData_Requirement_'+modal+' tbody .tr_other_'+id+' .daterange').val('');
            }

            $(".modalSave").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalSave') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier'));
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
                            var tbl_counter = $("#tableData_1 tbody > tr").length + 1;
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td>'+tbl_counter+'</td>';
                                html += '<td>'+obj.supplier_name+'</td>';
                                html += '<td>'+obj.category+'</td>';
                                html += '<td>'+obj.material+'</td>';
                                html += '<td>'+obj.contact_name+'</td>';
                                html += '<td>'+obj.contact_address+'</td>';
                                html += '<td class="text-center">'+obj.contact_info+'</td>';
                                html += '<td class="text-center">'+obj.reviewed_due+'</td>';
                                html += '<td class="text-center">'+obj.compliance+'%</td>';
                                html += '<td class="text-center">'+obj.status+'</td>';
                                html += '<td class="text-center">';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                        html += '<a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                    html += '</div>';
                                html += '</td>';
                            html += '</tr>';

                            $('#tableData_1 tbody').append(html);

                            // CounterUp Section
                            var pct_counter1 = (parseInt(obj.statusActive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter2 = (parseInt(obj.statusInactive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter3 = (parseInt(obj.statusInactiveMonth) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter4 = (parseInt(obj.statusTotal) / parseInt(obj.statusTotal)) * 100;
                            $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                            $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                            $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                            $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                            $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                            $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                            $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactiveMonth+'"></span>');
                            $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                            $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                            $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusTotal+'"></span>');
                            $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                            $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');
                            
                            $('.counterup').counterUp();
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
                formData.append('btnUpdate_Supplier',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Supplier'));
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
                            var tbl_counter = $("#tableData_1 tbody > tr").length + 1;
                            var html = '<td>'+tbl_counter+'</td>';
                            html += '<td>'+obj.supplier_name+'</td>';
                            html += '<td>'+obj.category+'</td>';
                            html += '<td>'+obj.material+'</td>';
                            html += '<td>'+obj.contact_name+'</td>';
                            html += '<td>'+obj.contact_address+'</td>';
                            html += '<td class="text-center">'+obj.contact_info+'</td>';
                            html += '<td class="text-center">'+obj.reviewed_due+'</td>';
                            html += '<td class="text-center">'+obj.compliance+'%</td>';
                            html += '<td class="text-center">'+obj.status+'</td>';
                            html += '<td class="text-center">';

                                if (obj.page == 2) {
                                    html += '<a href="#modalView" class="btn btn-outline btn-success btn-sm btn-circle btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                } else {
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                        html += '<a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                    html += '</div>';
                                }

                            html += '</td>';

                            $('#tableData_1 tbody #tr_'+obj.ID).html(html);

                            // CounterUp Section
                            var pct_counter1 = (parseInt(obj.statusActive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter2 = (parseInt(obj.statusInactive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter3 = (parseInt(obj.statusInactiveMonth) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter4 = (parseInt(obj.statusTotal) / parseInt(obj.statusTotal)) * 100;
                            $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                            $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                            $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                            $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                            $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                            $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                            $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactiveMonth+'"></span>');
                            $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                            $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                            $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusTotal+'"></span>');
                            $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                            $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');
                            
                            $('.counterup').counterUp();
                            $('#modalView').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));


            // Requirement Section
            function btnNew_Requirement(modal) {
                var requirement_other = $("#inputRequirementOther_"+modal).val();

                if (requirement_other != "") {
                    let x = Math.floor((Math.random() * 100) + 1);

                    var html = '<label class="mt-checkbox mt-checkbox-outline"> '+requirement_other;
                        html += '<input type="checkbox" value="'+requirement_other+'" name="document_other[]" data-id="'+x+'" onchange="checked_RequirementOther(this, '+modal+')" checked />';
                        html += '<span></span>';
                    html += '</label>';
                    $('#tabDocuments_'+modal+' .mt-checkbox-list').append(html);

                    var data = '<tr class="tr_other_'+x+'">';
                        data += '<td rowspan="2">';
                            data += '<input type="hidden" class="form-control" name="document_other_name[]" value="'+requirement_other+'" required />'+requirement_other;
                        data += '</td>';
                        data += '<td><input type="file" class="form-control hide" name="document_other_file[]" onchange="changeFile(this, this.value)" /><p style="margin: 0;"><button type="button" class="btn btn-link uploadNew" onclick="uploadNew(this)">Upload</button></p></td>';
                        data += '<td><input type="text" class="form-control" name="document_other_filename[]" placeholder="Document Name" /></td>';
                        data += '<td>';
                            data += '<div class="input-group">';
                                data += '<input type="text" class="form-control daterange" name="document_other_daterange[]" value="" />';
                                data += '<span class="input-group-btn">';
                                    data += '<button class="btn default date-range-toggle" type="button" onclick="widget_date_clears(this)">';
                                        data += '<i class="fa fa-close"></i>';
                                    data += '</button>';
                                data += '</span>';
                            data += '</div>';
                            data += '<input type="date" class="form-control hide" name="document_other_date[]" />';
                            data += '<input type="date" class="form-control hide" name="document_other_due[]" />';
                        data += '</td>';
                        data += '<td rowspan="2" class="text-center">NO</td>';
                        data += '<td rowspan="2" class="text-center">';
                            data += '<input type="file" class="form-control hide" name="document_other_template[]" /><p style="margin: 0;"><button type="button" class="btn btn-link uploadNew" onclick="uploadNew(this)">Upload</button></p>';
                        data += '</td>';
                    data += '</tr>';
                    data += '<tr class="tr_other_'+x+'">';
                        data += '<td colspan="3">';
                            data += '<input type="text" class="form-control" name="document_other_comment[]" placeholder="Comment" />';
                            data += '<div class="row margin-top-10">';
                                data += '<div class="col-md-6">';
                                    data += '<div class="form-group">';
                                        data += '<label class="control-label">Reviewed By</label>';
                                        data += '<input type="hidden" class="form-control" name="document_other_reviewed[]" value="0"/>';
                                        data += '<p style="margin: 0; font-weight: 700;">Not Yet</p>';
                                    data += '</div>';
                                data += '</div>';
                                data += '<div class="col-md-6">';
                                    data += '<div class="form-group">';
                                        data += '<label class="control-label">Approved By</label>';
                                        data += '<input type="hidden" class="form-control" name="document_other_approved[]" value="0"/>';
                                        data += '<p style="margin: 0; font-weight: 700;">Not Yet</p>';
                                    data += '</div>';
                                data += '</div>';
                            data += '</div>';
                        data += '</td>';
                    data += '</tr>';

                    $('#tableData_Requirement_'+modal+' tbody').append(data);
                    widget_date_other(x, modal);
                    widget_date_clear_other(x, modal);
                }
            }
            function checked_Requirement(id, modal) {
                if (id.checked == true) {
                    $.ajax({
                        type: "GET",
                        url: "function.php?modalView_Customer_Requirement="+id.value+"&modal="+modal,
                        dataType: "html",                  
                        success: function(data){
                            $('#tableData_Requirement_'+modal+' tbody').append(data);
                            widget_date(id.value, modal);
                            widget_date_clear(id.value, modal);
                        }
                    });
                } else {
                     $('#tableData_Requirement_'+modal+' tbody .tr_'+id.value).remove();
                }
            }
            function checked_RequirementOther(id, modal) {
                var x = $(id).attr("data-id");

                if (id.checked == true) {
                    var data = '<tr class="tr_other_'+x+'">';
                        data += '<td rowspan="2">';
                            data += '<input type="hidden" class="form-control" name="document_other_name[]" value="'+id.value+'"" required />'+id.value;
                        data += '</td>';
                        data += '<td><input type="file" class="form-control hide" name="document_other_file[]" onchange="changeFile(this, this.value)" /><p style="margin: 0;"><button type="button" class="btn btn-link uploadNew" onclick="uploadNew(this)">Upload</button></p></td>';
                        data += '<td><input type="text" class="form-control" name="document_other_filename[]" placeholder="Document Name" /></td>';
                        data += '<td>';
                            data += '<div class="input-group">';
                                data += '<input type="text" class="form-control daterange" name="document_other_daterange[]" value="" />';
                                data += '<span class="input-group-btn">';
                                    data += '<button class="btn default date-range-toggle" type="button" onclick="widget_date_clears(this)">';
                                        data += '<i class="fa fa-close"></i>';
                                    data += '</button>';
                                data += '</span>';
                            data += '</div>';
                            data += '<input type="date" class="form-control hide" name="document_other_date[]" />';
                            data += '<input type="date" class="form-control hide" name="document_other_due[]" />';
                        data += '</td>';
                        data += '<td rowspan="2" class="text-center">NO</td>';
                        data += '<td rowspan="2" class="text-center">';
                            data += '<input type="file" class="form-control hide" name="document_other_template[]" /><p style="margin: 0;"><button type="button" class="btn btn-link uploadNew" onclick="uploadNew(this)">Upload</button></p>';
                        data += '</td>';
                    data += '</tr>';
                    data += '<tr class="tr_other_'+x+'">';
                        data += '<td colspan="3">';
                            data += '<input type="text" class="form-control" name="document_other_comment[]" placeholder="Comment" />';
                            data += '<div class="row margin-top-10">';
                                data += '<div class="col-md-6">';
                                    data += '<div class="form-group">';
                                        data += '<label class="control-label">Reviewed By</label>';
                                        data += '<input type="hidden" class="form-control" name="document_other_reviewed[]" value="0"/>';
                                        data += '<p style="margin: 0; font-weight: 700;">Not Yet</p>';
                                    data += '</div>';
                                data += '</div>';
                                data += '<div class="col-md-6">';
                                    data += '<div class="form-group">';
                                        data += '<label class="control-label">Approved By</label>';
                                        data += '<input type="hidden" class="form-control" name="document_other_approved[]" value="0"/>';
                                        data += '<p style="margin: 0; font-weight: 700;">Not Yet</p>';
                                    data += '</div>';
                                data += '</div>';
                            data += '</div>';
                        data += '</td>';
                    data += '</tr>';

                    $('#tableData_Requirement_'+modal+' tbody').append(data);
                    widget_date_other(x, modal);
                    widget_date_clear_other(x, modal);
                } else {
                    $('#tableData_Requirement_'+modal+' tbody .tr_other_'+x).remove();
                }
            }

            // Contact Section
            $(".modalSave_Contact").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_Contact',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Contact'));
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
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td>'+obj.contact_name+'</td>';
                                html += '<td>'+obj.contact_title+'</td>';
                                html += '<td>'+obj.contact_address+'</td>';
                                html += '<td class="text-center">';
                                    html += '<ul class="list-inline">';
                                        if (obj.contact_email != "") { html += '<li><a href="mailto:'+obj.contact_email+'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
                                        if (obj.contact_phone != "") { html += '<li><a href="tel:'+obj.contact_phone+'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
                                        if (obj.contact_cell != "") { html += '<li><a href="tel:'+obj.contact_cell+'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
                                        if (obj.contact_fax != "") { html += '<li><a href="tel:'+obj.contact_fax+'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
                                    html += '</ul>';
                                html += '</td>';
                                html += '<td class="text-center hide">';
                                    html += '<input type="checkbox" class="make-switch" data-size="mini" name="contact_status_arr[]" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="default" />';
                                html += '</td>';
                                html += '<td class="text-center">';
                                    html += '<input type="hidden" class="form-control" name="contact_id[]" value="'+obj.ID+'" readonly />';
                                    html += '<div class="mt-action-buttons">';
                                        html += '<div class="btn-group btn-group-circle">';
                                            html += '<a href="#modalEditContact" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Contact" onclick="btnEdit_Contact('+obj.ID+', 1)">Edit</a>';
                                            html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Contact" onclick="btnRemove_Contact('+obj.ID+', 1)">Delete</a>';
                                        html += '</div>';
                                    html += '</div>';
                                html += '</td>';
                            html += '</tr>';

                            $('#tableData_Contact_'+obj.modal+' tbody').append(html);
                            $('#modalNewContact').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnNew_Contact(id, modal) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Supplier_Contact="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalNewContact .modal-body").html(data);
                    }
                });
            }
            $(".modalUpdate_Contact").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Supplier_Contact',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Supplier_Contact'));
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
                            var html = '<td>'+obj.contact_name+'</td>';
                            html += '<td>'+obj.contact_title+'</td>';
                            html += '<td>'+obj.contact_address+'</td>';
                            html += '<td class="text-center">';
                                html += '<ul class="list-inline">';
                                    if (obj.contact_email != "") { html += '<li><a href="mailto:'+obj.contact_email+'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
                                    if (obj.contact_phone != "") { html += '<li><a href="tel:'+obj.contact_phone+'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
                                    if (obj.contact_cell != "") { html += '<li><a href="tel:'+obj.contact_cell+'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
                                    if (obj.contact_fax != "") { html += '<li><a href="tel:'+obj.contact_fax+'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
                                html += '</ul>';
                            html += '</td>';
                            html += '<td class="text-center hide">';
                                html += '<input type="checkbox" class="make-switch" data-size="mini" name="contact_status_arr[]" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="default" />';
                            html += '</td>';
                            html += '<td class="text-center">';
                                html += '<input type="hidden" class="form-control" name="contact_id[]" value="'+obj.ID+'" readonly />';
                                html += '<div class="mt-action-buttons">';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalEditContact" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Contact" onclick="btnEdit_Contact('+obj.ID+', 1)">Edit</a>';
                                        html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Contact" onclick="btnRemove_Contact('+obj.ID+', 1)">Delete</a>';
                                    html += '</div>';
                                html += '</div>';
                            html += '</td>';

                            $('#tableData_Contact_'+obj.modal+' tbody #tr_'+obj.ID).html(html);
                            $('#modalEditContact').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnEdit_Contact(id, modal) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_Supplier_Contact="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalEditContact .modal-body").html(data);
                    }
                });
            }
            function btnRemove_Contact(id, modal) {
                $('#tableData_Contact_'+modal+' tbody #tr_'+id).remove();
            }

            // Material Section
            $(".modalSave_Material").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_Material',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Material'));
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
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td>'+obj.material_name+'</td>';
                                html += '<td>'+obj.material_id+'</td>';
                                html += '<td>'+obj.material_description+'</td>';
                                html += '<td class="text-center">';
                                    html += '<input type="hidden" class="form-control" name="material_id[]" value="'+obj.ID+'" readonly />';
                                    html += '<div class="mt-action-buttons">';
                                        html += '<div class="btn-group btn-group-circle">';
                                            html += '<a href="#modalEditMaterial" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Material" onclick="btnEdit_Material('+obj.ID+', 1)">Edit</a>';
                                            html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Material" onclick="btnRemove_Material('+obj.ID+', 1)">Delete</a>';
                                        html += '</div>';
                                    html += '</div>';
                                html += '</td>';
                            html += '</tr>';

                            $('#tableData_Material_'+obj.modal+' tbody').append(html);
                            $('#modalNewMaterial').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnNew_Material(id, modal) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Supplier_Material="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalNewMaterial .modal-body").html(data);
                        widget_formRepeater();
                    }
                });
            }
            $(".modalUpdate_Material").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Supplier_Material',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Supplier_Material'));
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
                            var html = '<td>'+obj.material_name+'</td>';
                            html += '<td>'+obj.material_id+'</td>';
                            html += '<td>'+obj.material_description+'</td>';
                            html += '<td class="text-center">';
                                html += '<input type="hidden" class="form-control" name="material_id[]" value="'+obj.ID+'" readonly />';
                                html += '<div class="mt-action-buttons">';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalEditMaterial" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Material" onclick="btnEdit_Material('+obj.ID+', 1)">Edit</a>';
                                        html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Material" onclick="btnRemove_Material('+obj.ID+', 1)">Delete</a>';
                                    html += '</div>';
                                html += '</div>';
                            html += '</td>';

                            $('#tableData_Material_'+obj.modal+' tbody #tr_'+obj.ID).html(html);
                            $('#modalEditMaterial').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnEdit_Material(id, modal) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_Supplier_Material="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalEditMaterial .modal-body").html(data);
                        widget_formRepeater();
                    }
                });
            }
            function btnRemove_Material(id, modal) {
                $('#tableData_Material_'+modal+' tbody #tr_'+id).remove();
            }

            // Service Section
            $(".modalSave_Service").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_Service',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Service'));
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
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td>'+obj.service_name+'</td>';
                                html += '<td>'+obj.service_id+'</td>';
                                html += '<td>'+obj.service_description+'</td>';
                                html += '<td class="text-center">';
                                    html += '<input type="hidden" class="form-control" name="service_id[]" value="'+obj.ID+'" readonly />';
                                    html += '<div class="mt-action-buttons">';
                                        html += '<div class="btn-group btn-group-circle">';
                                            html += '<a href="#modalEditService" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Service" onclick="btnEdit_Service('+obj.ID+', '+obj.modal+')">Edit</a>';
                                            html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Service" onclick="btnRemove_Service('+obj.ID+', '+obj.modal+')">Delete</a>';
                                        html += '</div>';
                                    html += '</div>';
                                html += '</td>';
                            html += '</tr>';

                            $('#tableData_Service_'+obj.modal+' tbody').append(html);
                            $('#modalNewService').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnNew_Service(id, modal) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Supplier_Service="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalNewService .modal-body").html(data);
                        widget_formRepeater();
                    }
                });
            }
            $(".modalUpdate_Service").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Supplier_Service',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Supplier_Service'));
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
                            var html = '<td>'+obj.service_name+'</td>';
                            html += '<td>'+obj.service_id+'</td>';
                            html += '<td>'+obj.service_description+'</td>';
                            html += '<td class="text-center">';
                                html += '<input type="hidden" class="form-control" name="service_id[]" value="'+obj.ID+'" readonly />';
                                html += '<div class="mt-action-buttons">';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalEditService" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Service" onclick="btnEdit_Service('+obj.ID+', '+obj.modal+')">Edit</a>';
                                        html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Service" onclick="btnRemove_Service('+obj.ID+', '+obj.modal+')">Delete</a>';
                                    html += '</div>';
                                html += '</div>';
                            html += '</td>';

                            $('#tableData_Service_'+obj.modal+' tbody #tr_'+obj.ID).html(html);
                            $('#modalEditService').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnEdit_Service(id, modal) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_Supplier_Service="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalEditService .modal-body").html(data);
                        widget_formRepeater();
                    }
                });
            }
            function btnRemove_Service(id, modal) {
                $('#tableData_Service_'+modal+' tbody #tr_'+id).remove();
            }

            //Template Section
            function btnTemplate(id, temp) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Supplier_Template="+id+"&temp="+temp,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalTemplate .modal-body").html(data);
                    }
                });
            }
            $(".modalSave_Template").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_Template',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Template'));
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
                            $('#tableData_3 tbody #tr_'+obj.ID+' > td:last-child').html(obj.view);

                            $('#modalTemplate').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnTemplate2(id, temp, modal) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Supplier_Template2="+id+"&temp="+temp+"&modal="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalTemplate2 .modal-body").html(data);
                    }
                });
            }
            $(".modalSave_Template2").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_Template2',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Template2'));
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
                            $('#tableData_Requirement_'+obj.modal+' tbody .tr_'+obj.ID+':first-child > td:last-child').html(obj.view2);
                            $('#tableData_3 tbody #tr_'+obj.ID+' > td:last-child').html(obj.view);

                            $('#modalTemplate2').modal('hide');
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