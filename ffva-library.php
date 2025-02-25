<?php 
    $title = "Food Fraud Vulnerability Assessment Library";
    $site = "ffva-library";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    .dt-buttons {
        margin: unset !important;
        float: left !important;
        margin-left: 15px !important;
    }
    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {
        position: relative;
    }
</style>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-doc font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">FFVA Library</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tabSupplier" data-toggle="tab">Suppliers</a>
                                        </li>
                                        <li>
                                            <a href="#tabIngredients" data-toggle="tab">Ingredients</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tabSupplier">
                                            <table class="table table-bordered table-hover" id="tableData_1">
                                                <thead>
                                                    <tr>
                                                        <th>ID#</th>
                                                        <th>Supplier Name</th>

                                                        <?php
                                                            if ($FreeAccess != 1) {
                                                                echo '<th class="text-center">Attached File</th>';
                                                            }
                                                        ?>
                                                        
                                                        <th class="text-center">Vulnerability</th>
                                                        <th class="text-center">Date Performed</th>
                                                        <th class="text-center">Due Date</th>
                                                        <th style="width: 90px;" class="text-center">Status</th>
                                                        <th style="width: 85px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        // $resultSupplier = mysqli_query( $conn,"SELECT * FROM tbl_ffva WHERE deleted = 0 AND type = 1 AND updated = 0 AND user_id = $switch_user_id" );
                                                        // if ( mysqli_num_rows($resultSupplier) > 0 ) {
                                                        //     while($rowSupplier = mysqli_fetch_array($resultSupplier)) {
                                                        //         $supplier_user_id = htmlentities($rowSupplier["user_id"] ?? '');
                                                        //         $supplier_reviewed_by = htmlentities($rowSupplier["reviewed_by"] ?? '');
                                                        //         $supplier_approved_by = htmlentities($rowSupplier["approved_by"] ?? '');

                                                        //         $int_review_assigned_name = '';
                                                        //         $int_review_assigned = htmlentities($rowSupplier["int_review_assigned"] ?? '');
                                                        //         $int_review_status = htmlentities($rowSupplier["int_review_status"] ?? '');
                                                        //         $int_review_comment = htmlentities($rowSupplier["int_review_comment"] ?? '');

                                                        //         if (!empty($int_review_assigned)) {
                                                        //             $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $int_review_assigned" );
                                                        //             if ( mysqli_num_rows($selectUser) > 0 ) {
                                                        //                 $rowUser = mysqli_fetch_array($selectUser);
                                                        //                 $int_review_assigned_name = htmlentities($rowUser["first_name"] ?? '') .' '. htmlentities($rowUser["last_name"] ?? '');
                                                        //             }
                                                        //         }

                                                        //         $int_verify_assigned_name = '';
                                                        //         $int_verify_assigned = htmlentities($rowSupplier["int_verify_assigned"] ?? '');
                                                        //         $int_verify_status = htmlentities($rowSupplier["int_verify_status"] ?? '');
                                                        //         $int_verify_comment = htmlentities($rowSupplier["int_verify_comment"] ?? '');

                                                        //         if (!empty($int_verify_assigned)) {
                                                        //             $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $int_verify_assigned" );
                                                        //             if ( mysqli_num_rows($selectUser) > 0 ) {
                                                        //                 $rowUser = mysqli_fetch_array($selectUser);
                                                        //                 $int_verify_assigned_name = htmlentities($rowUser["first_name"] ?? '') .' '. htmlentities($rowUser["last_name"] ?? '');
                                                        //             }
                                                        //         }

                                                        //         $supplier_id = htmlentities($rowSupplier["ID"] ?? '');
                                                        //         $supplier_company = htmlentities($rowSupplier["company"] ?? '');

                                                        //         // $data_status = $rowSupplier['status'];
                                                        //         // $status = "Pending";
                                                        //         // if ($data_status == 1) { $status = "Completed"; }

                                                        //         $status = "Pending";
                                                        //         if (!empty($rowSupplier['approved_date'])) { $status = "Completed"; }

                                                        //         $data_last_modified = $rowSupplier['last_modified'];
                                                        //         $data_last_modified = new Dat
