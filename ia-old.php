<?php 
    $title = "Internal Audit";
    $site = "internal";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

<style>
    .modal .bs-select small {
        display: block;
    }
    .bootstrap-tagsinput { min-height: 100px; }

    .m-0 {
        margin: 0 !important;
    }

    .sorting_highlight {
        background: yellow;
        cursor: move;
        height: 50px;
    }

    @media only screen and (min-width: 600px) {
        #modalView table tr.bg-default {
            white-space: nowrap;
        }
    }
</style>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-notebook font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Internal Audit</span>
                                    </div>
                                    <?php
                                        if ($switch_user_id <> 163) {
                                            echo '<ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#tabTemplate" data-toggle="tab">Template</a>
                                                </li>
                                                <li>
                                                    <a href="#tabOpen" data-toggle="tab">Open</a>
                                                </li>
                                                <li>
                                                    <a href="#tabClose" data-toggle="tab">Close</a>
                                                </li>
                                            </ul>';
                                        }
                                    ?>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tabTemplate">
                                            <?php
                                                if ($switch_user_id == 1 OR $switch_user_id == 163) {
                                                    echo '<a href="#modalNew" data-toggle="modal" class="btn btn-circle btn-success pull-right margin-bottom-15" onclick="btnNewIA(1)">Add New Template</a>';
                                                }
                                            ?>
                                            
                                            <table class="table table-bordered table-hover" id="tableData" style="width:100%">
                                                <thead>
                                                    <tr class="bg-default">
                                                        <th>Audit Title</th>
                                                        <th>Description</th>
                                                        <th>Date</th>
                                                        <th class="text-center" style="width: 135px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $selectIA = mysqli_query( $conn,"SELECT * FROM tbl_ia WHERE is_generated = 0 AND user_id = $switch_user_id AND deleted = 0" );
                                                        if ( mysqli_num_rows($selectIA) > 0 ) {
                                                            while($ia = mysqli_fetch_array($selectIA)) {
                                                                $ia_ID = $ia['ID'];
                                                                $ia_title = $ia['title'];
                                                                $ia_description = $ia['description'];

                                                                $ia_last_modified = $ia['last_modified'];
                                                                $ia_last_modified = new DateTime($ia_last_modified);
                                                                $ia_last_modified = $ia_last_modified->format('M d, Y');

                                                                echo '<tr id="tr_'.$ia_ID.'">
                                                                    <td>'.stripcslashes($ia_title).'</td>
                                                                    <td>'.stripcslashes($ia_description).'</td>
                                                                    <td>'.$ia_last_modified.'</td>
                                                                    <td class="text-center">';

                                                                        if ($switch_user_id == 163) {
                                                                            echo '<a href="#modalEdit" data-toggle="modal" class="btn btn-xs dark m-0" onclick="btnEditIA('.$ia_ID.', 2)" title="Edit"><i class="fa fa-pencil"></i></a>
                                                                            <a href="#modalView" data-toggle="modal" class="btn btn-xs btn-success m-0" onclick="btnViewIA('.$ia_ID.')" title="View"><i class="fa fa-search"></i></a>
                                                                            <a href="javascript:;" class="btn btn-xs btn-danger m-0" onclick="btnDeleteIA(this, '.$ia_ID.')" title="Delete"><i class="fa fa-trash"></i></a>
                                                                            <a href="#modalClone" data-toggle="modal"" class="btn btn-xs btn-info m-0" onclick="btnCloneIA('.$ia_ID.')" title="Clone"><i class="fa fa-clone"></i></a>';
                                                                        } else {
                                                                            echo '<a href="#modalEdit" data-toggle="modal" class="btn btn-xs dark m-0" onclick="btnEditIA('.$ia_ID.', 2)" title="Edit"><i class="fa fa-pencil"></i></a>
                                                                            <a href="#modalView" data-toggle="modal" class="btn btn-xs btn-success m-0" onclick="btnViewIA('.$ia_ID.')" title="View"><i class="fa fa-search"></i></a>
                                                                            <a href="javascript:;" class="btn btn-xs btn-danger m-0" onclick="btnDeleteIA(this, '.$ia_ID.')" title="Delete"><i class="fa fa-trash"></i></a>
                                                                            <a href="#modalGenerate" data-toggle="modal" class="btn btn-xs btn-info m-0" onclick="btnGenerate('.$ia_ID.')" title="Generate Form"><i class="fa fa-file-text-o"></i></a>';
                                                                            
                                                                            if ($current_userID == 55 || $current_userID == 177 || $current_userID == 43 ) {
                                                                                echo '<a href="#modalClone" data-toggle="modal"" class="btn btn-xs btn-info m-0" onclick="btnCloneIA('.$ia_ID.')" title="Clone"><i class="fa fa-clone"></i></a>';
                                                                            }
                                                                        }
                                                                        
                                                                    echo ' </td>
                                                                </tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tabOpen">
                                            <table class="table table-bordered table-hover" id="tableDataOpen">
                                                <thead>
                                                    <tr class="bg-default">
                                                        <th>Audit Title</th>
                                                        <th>Organization</th>
                                                        <th>Audit Type</th>
                                                        <th>Inspected by</th>
                                                        <th>Auditee</th>
                                                        <th>Verified by</th>
                                                        <th class="text-center" style="width: 125px;">Start date</th>
                                                        <th class="text-center" style="width: 125px;">End date</th>
                                                        <th>Audit Scope</th>
                                                        <th class="text-center" style="width: 125px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $selectForm = mysqli_query( $conn,"SELECT * FROM tbl_ia_form WHERE status = 1 AND deleted = 0 AND user_id = $switch_user_id" );
                                                        if ( mysqli_num_rows($selectForm) > 0 ) {
                                                            while($rowForm = mysqli_fetch_array($selectForm)) {
                                                                $form_ID = $rowForm['ID'];
                                                                $form_organization = $rowForm['organization'];
                                                                $form_audit_type = $rowForm['audit_type'];
                                                                $form_inspected_by = $rowForm['inspected_by'];
                                                                $form_auditee = $rowForm['auditee'];
                                                                $form_verified_by = $rowForm['verified_by'];
                                                                $form_audit_scope = $rowForm['audit_scope'];

                                                                $form_date_start = $rowForm['date_start'];
                                                                $form_date_start = new DateTime($form_date_start);
                                                                $form_date_start = $form_date_start->format('M d, Y');
                                                                
                                                                $form_date_end = $rowForm['date_end'];
                                                                $form_date_end = new DateTime($form_date_end);
                                                                $form_date_end = $form_date_end->format('M d, Y');

                                                                $form_ia_id = $rowForm['ia_id'];
                                                                $selectFormIA = mysqli_query( $conn,"SELECT * FROM tbl_ia WHERE ID = $form_ia_id" );
                                                                if ( mysqli_num_rows($selectFormIA) > 0 ) {
                                                                    $rowFormIA = mysqli_fetch_array($selectFormIA);
                                                                    $form_title = $rowFormIA['title'];
                                                                }

                                                                echo '<tr id="tr_'.$form_ID.'">
                                                                    <td>'.stripcslashes($form_title).'</td>
                                                                    <td>'.stripcslashes($form_organization).'</td>
                                                                    <td>'.stripcslashes($form_audit_type).'</td>
                                                                    <td>'.stripcslashes($form_inspected_by).'</td>
                                                                    <td>'.stripcslashes($form_auditee).'</td>
                                                                    <td>'.stripcslashes($form_verified_by).'</td>
                                                                    <td class="text-center">'.$form_date_start.'</td>
                                                                    <td class="text-center">'.$form_date_end.'</td>
                                                                    <td>'.$form_audit_scope.'</td>
                                                                    <td class="text-center">
                                                                        <a href="#modalEditForm" data-toggle="modal" class="btn btn-xs dark m-0" onclick="btnEditForm('.$form_ID.')" title="Edit"><i class="fa fa-pencil"></i></a>
                                                                        <a href="'.$base_url.'pdf_dom?id='.$form_ID.'" class="btn btn-xs btn-success m-0" title="PDF" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                                                                        <a href="javascript:;" class="btn btn-xs btn-danger m-0" onclick="btnDeleteForm(this, '.$form_ID.')" title="Delete"><i class="fa fa-trash"></i></a>
                                                                        <a href="javascript:;" class="btn btn-xs btn-info m-0" onclick="btnCloseForm(this, '.$form_ID.')" title="Close"><i class="fa fa-check"></i></a>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tabClose">
                                            <table class="table table-bordered table-hover" id="tableDataClose">
                                                <thead>
                                                    <tr class="bg-default">
                                                        <th>Audit Title</th>
                                                        <th>Organization</th>
                                                        <th>Audit Type</th>
                                                        <th>Inspected by</th>
                                                        <th>Auditee</th>
                                                        <th>Verified by</th>
                                                        <th class="text-center" style="width: 125px;">Start date</th>
                                                        <th class="text-center" style="width: 125px;">End date</th>
                                                        <th>Audit Scope</th>
                                                        <th class="text-center" style="width: 125px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $selectForm = mysqli_query( $conn,"SELECT * FROM tbl_ia_form WHERE status = 0 AND deleted = 0 AND user_id = $switch_user_id" );
                                                        if ( mysqli_num_rows($selectForm) > 0 ) {
                                                            while($rowForm = mysqli_fetch_array($selectForm)) {
                                                                $form_ID = $rowForm['ID'];
                                                                $form_organization = $rowForm['organization'];
                                                                $form_audit_type = $rowForm['audit_type'];
                                                                $form_inspected_by = $rowForm['inspected_by'];
                                                                $form_auditee = $rowForm['auditee'];
                                                                $form_verified_by = $rowForm['verified_by'];
                                                                $form_audit_scope = $rowForm['audit_scope'];

                                                                $form_date_start = $rowForm['date_start'];
                                                                $form_date_start = new DateTime($form_date_start);
                                                                $form_date_start = $form_date_start->format('M d, Y');
                                                                
                                                                $form_date_end = $rowForm['date_end'];
                                                                $form_date_end = new DateTime($form_date_end);
                                                                $form_date_end = $form_date_end->format('M d, Y');

                                                                $form_ia_id = $rowForm['ia_id'];
                                                                $selectFormIA = mysqli_query( $conn,"SELECT * FROM tbl_ia WHERE ID = $form_ia_id" );
                                                                if ( mysqli_num_rows($selectFormIA) > 0 ) {
                                                                    $rowFormIA = mysqli_fetch_array($selectFormIA);
                                                                    $form_title = $rowFormIA['title'];
                                                                }

                                                                echo '<tr id="tr_'.$form_ID.'">
                                                                    <td>'.stripcslashes($form_title).'</td>
                                                                    <td>'.stripcslashes($form_organization).'</td>
                                                                    <td>'.stripcslashes($form_audit_type).'</td>
                                                                    <td>'.stripcslashes($form_inspected_by).'</td>
                                                                    <td>'.stripcslashes($form_auditee).'</td>
                                                                    <td>'.stripcslashes($form_verified_by).'</td>
                                                                    <td class="text-center">'.$form_date_start.'</td>
                                                                    <td class="text-center">'.$form_date_end.'</td>
                                                                    <td>'.$form_audit_scope.'</td>
                                                                    <td class="text-center">
                                                                        <a href="'.$base_url.'pdf_dom?id='.$form_ID.'" class="btn btn-xs btn-success m-0" title="PDF" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                                                                        <a href="javascript:;" class="btn btn-xs btn-danger m-0" onclick="btnDeleteForm(this, '.$form_ID.')" title="Delete"><i class="fa fa-trash"></i></a>
                                                                    </td>
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

                        <!-- MODAL AREA -->
                        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-full">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalNew">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Template</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_IA" id="btnSave_IA" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalEdit" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-full">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalEdit">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Template</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_IA" id="btnUpdate_IA" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalView" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-full">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalView">
                                        <div class="modal-body"></div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalNewSheet" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalNewSheet">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Sheet Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_Sheet" id="btnSave_Sheet" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalViewSheet" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalViewSheet">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Sheet Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Delete" onclick="btnDeleteSheet(this)" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_Sheet" id="btnUpdate_Sheet" data-style="zoom-out"><span class="ladda-label">Update</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalNewRow" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalNewRow">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Row Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_Row" id="btnSave_Row" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalEditRow" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalEditRow">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Row Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_Row" id="btnUpdate_Row" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
                                            <button type="submit" class="btn green ladda-button" name="btnClone_IA" id="btnClone_IA" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalGenerate" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-full">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalGenerate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Generate Form</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-danger ladda-button" name="btnGenerate2" id="btnGenerate2" data-style="zoom-out"><span class="ladda-label">Save as Draft</span></button>
                                            <button type="submit" class="btn btn-info ladda-button" name="btnGenerate" id="btnGenerate" data-style="zoom-out"><span class="ladda-label">Submit for Preliminary</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalEditForm" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-full">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalEditForm">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Generate Form</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-danger ladda-button" name="btnEdit_Form2" id="btnEdit_Form2" data-style="zoom-out"><span class="ladda-label">Save as Draft</span></button>
                                            <button type="submit" class="btn btn-info ladda-button" name="btnEdit_Form3" id="btnEdit_Form3" data-style="zoom-out"><span class="ladda-label">Submit for Preliminary</span></button>
                                            <button type="submit" class="btn green ladda-button" name="btnEdit_Form" id="btnEdit_Form" data-style="zoom-out"><span class="ladda-label">Submit for Final</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>

        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                // $('.bs-select').selectpicker();

                // fancyBoxes();
                // widget_inputTag();

                $('#tableData').DataTable();
            });

            function uploadNew(e) {
                $(e).parent().hide();
                $(e).parent().prev('.form-control').removeClass('hide');
            }
            function selectType(e) {
                if (e.value == 1 || e.value == 3 || e.value == 4) {
                    $(e).parent().next().html('<input type="hidden" name="formatID[]" value="0" /><input type="text" class="form-control" name="label[]" placeholder="Label" required />');
                } else if (e.value == 2) {
                    $(e).parent().next().html('<input type="hidden" name="formatID[]" value="0" /><input type="text" class="form-control tagsinput" name="label[]" data-role="tagsinput" placeholder="Enter Options" required />');
                    widget_inputTag();
                } else {
                    $(e).parent().next().html('');
                }
            }
            function changeRadio(val, row, formatID) {
                $('.radio_'+row+'_'+formatID).val(val);
            }
            function checkInclude(e, modal, type) {
                if (e.checked == true) {
                    $(e).parent().parent().parent().find('> input').show();
                    $(e).parent().parent().parent().find('> select').show();
                    $(e).parent().parent().parent().find('> div').not('.mt-checkbox-list').show();

                    widget_summernote(modal, type);
                } else {
                    $(e).parent().parent().parent().find('> input').hide();
                    $(e).parent().parent().parent().find('> select').hide();
                    $(e).parent().parent().parent().find('> div').not('.mt-checkbox-list').hide();
                }
            }
            function btnEdit_summernote(e, row, column) {
                $(e).next('.textarea_value').hide();
                widget_summernote(row, column);
            }
            function widget_summernote(modal, type) {
                $('#summernote_'+modal+'_'+type).summernote({
                    height: 100
                });
            }
            function widget_repeaterForm() {
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
            function widget_inputTag() {
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
            function widget_date() {
                $('.daterange').daterangepicker({
                    ranges: {
                        'Today': [moment().subtract(1, 'day'), moment().subtract(1, 'day')],
                        'One Month': [moment().subtract(1, 'day'), moment().add(1, 'month')],
                        'One Year': [moment().subtract(1, 'day'), moment().add(1, 'year')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "opens": "left",
                    "drops": "auto"
                }, function(start, end, label) {
                  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
            }
            function btnRepeaterAdd() {
                var data = '<div class="mt-repeater-item row" data-repeater-item>';
                    data += '<div class="col-md-3">';
                        data += '<select class="form-control" name="type[]" onchange="selectType(this)">';
                            data += '<option value="0" SELECTED>Select Type</option>';
                            data += '<option value="1">Text</option>';
                            data += '<option value="2">Radio Button</option>';
                            data += '<option value="3">Date</option>';
                            // data += '<option value="4">File Upload</option>';
                        data += '</select>';
                    data += '</div>';
                    data += '<div class="col-md-7"></div>';
                    data += '<div class="col-md-2 text-right">';
                        data += '<a href="javascript:;" data-repeater-delete class="btn btn-danger" onclick="btnRepeaterRemove(this)"><i class="fa fa-close"></i></a>';
                    data += '</div>';
                data += '</div>';

                $('.format').append(data);
            }
            function btnRepeaterRemove(e) {
                $(e).parents('.mt-repeater-item').remove();
            }
            function btnRepeaterFormAdd() {
                var data = '<div class="row">';
                    data += '<div class="col-md-4">';
                        data += '<div class="form-group">';
                            data += '<input type="text" class="form-control" name="label[]" placeholder="Label" required />';
                        data += '</div>';
                    data += '</div>';
                    data += '<div class="col-md-6">';
                        data += '<div class="form-group">';
                            data += '<input type="text" class="form-control" name="description[]" placeholder="Description" required />';
                        data += '</div>';
                    data += '</div>';
                    data += '<div class="col-md-2 text-right">';
                        data += '<div class="form-group">';
                            data += '<a href="javascript:;" class="btn btn-danger" onclick="btnRepeaterFormRemove(this)"><i class="fa fa-close"></i></a>';
                        data += '</div>';
                    data += '</div>';
                data += '</div>';

                $('.formCustom').append(data);
            }
            function btnRepeaterFormRemove(e) {
                $(e).parent().parent().parent().remove();
            }
            function btnNewSheet(modal) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNew_Sheet="+modal,
                    dataType: "html",
                    success: function(data){
                        $("#modalNewSheet .modal-body").html(data);

                        $('.modalNewSheet .format').sortable({
                            placeholder: 'sorting_highlight',
                            update: function(event, ui) {
                                var page_id_array = new Array();
                            }
                        });
                    }
                });
            }
            function btnViewSheet(id, modal) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Sheet="+id+"&modal="+modal,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewSheet .modal-body").html(data);
                        widget_inputTag();

                        $('.modalViewSheet .format').sortable({
                            placeholder: 'sorting_highlight',
                            update: function(event, ui) {
                                var page_id_array = new Array();
                            }
                        });
                    }
                });
            }
            function btnDeleteSheet(e) {
                var id = $(e).parent().prev().find('input[name="ID"]').val();

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
                        url: "function.php?btnDelete_Sheet="+id,
                        dataType: "html",
                        success: function(response){
                            $("#modalNew .modal-body .tabbable .nav-tabs #li_"+id).remove();
                            $("#modalNew .modal-body .tabbable .tab-content #tabSheet_"+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            function btnDeleteFormat(e, id) {
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
                        url: "function.php?btnDelete_Format="+id,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            function btnDeleteData(e) {
                $(e).parent().parent().remove();
            }
            function btnNewRow(id, row, modal) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNew_Row="+id+"&row="+row+"&modal="+modal,
                    dataType: "html",
                    success: function(data){
                        $("#modalNewRow .modal-body").html(data);
                        $('.summernoteOpen').summernote({
                            height: 100
                        });
                    }
                });
            }
            function btnEditRow(id, row, modal) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalEdit_Row="+id+"&row="+row+"&modal="+modal,
                    dataType: "html",
                    success: function(data){
                        $("#modalEditRow .modal-body").html(data);
                        $('.summernoteOpen').summernote({
                            height: 100
                        });
                    }
                });
            }
            function btnDeleteRow(e, row) {
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
                        url: "function.php?btnDelete_Row="+row,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            function btnNewIA(modal) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNew_IA="+modal,
                    dataType: "html",
                    success: function(data){
                        $("#modalNew .modal-body").html(data);
                    }
                });
            }
            function btnEditIA(id, modal) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalEdit_IA="+id+"&modal="+modal,
                    dataType: "html",
                    success: function(data){
                        $("#modalEdit .modal-body").html(data);

                        $("tr").on( "mousedown", function() {
                            tr_parent = $(this).parent().parent().parent().attr('id');
                            if (tr_parent != null) {
                                tr_parent_id = tr_parent.replace('tabSheet_', '');

                                $('#tabSheet_'+tr_parent_id+' tbody').sortable({
                                    placeholder: 'sorting_highlight',
                                    update: function(event, ui) {
                                        var page_id_array = new Array();

                                        $('#tabSheet_'+tr_parent_id+' tbody tr').each(function () {
                                            tr_row = $(this).attr('id');
                                            page_id_array.push(tr_row.replace('tr_', ''));
                                        });

                                        $.ajax({
                                            url: "function.php?modalSort_Row="+tr_parent_id,
                                            method: "POST",
                                            data: {page_id_array:page_id_array},
                                            success: function(data) {
                                                // alert(data);
                                            }
                                        })
                                    }
                                });
                            }
                        });
                    }
                });
            }
            function btnViewIA(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_IA="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                    }
                });
            }
            function btnDeleteIA(e, row) {
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
                        url: "function.php?btnDelete_IA="+row,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            function btnCloneIA(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalClone_IA="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalClone .modal-body").html(data);
                        selectMulti();
                    }
                });
            }
            function btnGenerate(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalGenerate="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGenerate .modal-body").html(data);
                        $('#summernote_audit_scope').summernote({
                            height: 100
                        });
                        widget_date();

                        $('.modalGenerate .formCustom').sortable({
                            placeholder: 'sorting_highlight',
                            update: function(event, ui) {
                                var page_id_array = new Array();
                            }
                        });
                    }
                });
            }
            function btnEditForm(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalEdit_Form="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalEditForm .modal-body").html(data);
                        $('#summernote_audit_scope2').summernote({
                            height: 100
                        });
                        widget_date();

                        $('.modalEditForm .formCustom').sortable({
                            placeholder: 'sorting_highlight',
                            update: function(event, ui) {
                                var page_id_array = new Array();
                            }
                        });
                    }
                });
            }
            function btnDeleteForm(e, row) {
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
                        url: "function.php?btnDelete_Form="+row,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            function btnCloseForm(e, row) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be closed!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnClose_Form="+row,
                        dataType: "html",
                        success: function(response){
                            // $(e).parent().parent().remove();

                            var view = '<a href="pdf_dom?id='+row+'" class="btn btn-xs btn-success m-0" title="PDF" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
                            view += ' <a href="javascript:;" class="btn btn-xs btn-danger m-0" onclick="btnDeleteForm(this, '+row+')" title="Delete"><i class="fa fa-trash"></i></a>';

                            $('#tableDataOpen tbody #tr_'+row+' td').last().html(view);
                            $('#tableDataOpen tbody #tr_'+row).appendTo('#tableDataClose tbody');
                        }
                    });
                    swal("Done!", "This item has been closed.", "success");
                });
            }

            $(".modalNewSheet").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Sheet',true);

                var l = Ladda.create(document.querySelector('#btnSave_Sheet'));
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
                            var sheet = '<li class="active" id="li_'+obj.ID+'">';
                                sheet += '<input type="hidden" name="sheetID[]" value="'+obj.ID+'" />';
                                sheet += '<a href="#tabSheet_'+obj.ID+'" data-toggle="tab" aria-expanded="true">'+obj.name+' <i class="fa fa-pencil text-danger" data-toggle="modal" href="#modalViewSheet" onclick="btnViewSheet('+obj.ID+', '+obj.modal+')"></i></a>';
                            sheet += '</li>';

                            if (obj.modal == 1) { modalView = 'modalNew'; }
                            else if (obj.modal == 2) { modalView = 'modalEdit'; }

                            $("#"+modalView+" .modal-body .tabbable .nav-tabs li").removeClass('active');
                            $("#"+modalView+" .modal-body .tabbable .nav-tabs").append(sheet);

                            $("#"+modalView+" .modal-body .tabbable .tab-content .tab-pane").removeClass('active');
                            $("#"+modalView+" .modal-body .tabbable .tab-content").append(obj.data);

                            $('#modalNewSheet').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalViewSheet").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Sheet',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Sheet'));
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
                            var sheet = '<input type="hidden" name="sheetID[]" value="'+obj.ID+'" />';
                            sheet += '<a href="#tabSheet_'+obj.ID+'" data-toggle="tab" aria-expanded="true">'+obj.name+' <i class="fa fa-pencil text-danger" data-toggle="modal" href="#modalViewSheet" onclick="btnViewSheet('+obj.ID+', '+obj.modal+')"></i></a>';
                        
                            if (obj.modal == 1) { modalView = 'modalNew'; }
                            else if (obj.modal == 2) { modalView = 'modalEdit'; }

                            $('#'+modalView+' .modal-body .tabbable .nav-tabs #li_'+obj.ID).html(sheet);
                            $('#'+modalView+' .modal-body .tabbable #tabSheet_'+obj.ID+' table').html(obj.data);

                            $('#'+modalView+' .modal-body .tabbable #tabSheet_'+obj.ID+' table tbody tr').on( "mousedown", function() {
                                tr_parent = $(this).parent().parent().parent().attr('id');
                                if (tr_parent != null) {
                                    tr_parent_id = tr_parent.replace('tabSheet_', '');

                                    $('#tabSheet_'+tr_parent_id+' tbody').sortable({
                                        placeholder: 'sorting_highlight',
                                        update: function(event, ui) {
                                            var page_id_array = new Array();

                                            $('#tabSheet_'+tr_parent_id+' tbody tr').each(function () {
                                                tr_row = $(this).attr('id');
                                                page_id_array.push(tr_row.replace('tr_', ''));
                                            });

                                            $.ajax({
                                                url: "function.php?modalSort_Row="+tr_parent_id,
                                                method: "POST",
                                                data: {page_id_array:page_id_array},
                                                success: function(data) {
                                                    // alert(data);
                                                }
                                            })
                                        }
                                    });
                                }
                            });

                            $('#modalViewSheet').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalNewRow").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Row',true);

                var l = Ladda.create(document.querySelector('#btnSave_Row'));
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
                            if (obj.modal == 1) { modalView = 'modalNew'; }
                            else if (obj.modal == 2) { modalView = 'modalEdit'; }

                            if (obj.parent_id == 0) {
                                $("#"+modalView+" .modal-body .tabbable .tab-content #tabSheet_"+obj.sheet_id+" tbody").append(obj.data);
                            } else {
                                var child = $("#"+modalView+" .modal-body .tabbable .tab-content #tabSheet_"+obj.sheet_id+" tbody > .child_"+obj.parent_id).length;
                                if (child > 0) {
                                    $(obj.data).insertAfter("#"+modalView+" .modal-body .tabbable .tab-content #tabSheet_"+obj.sheet_id+" tbody .child_"+obj.parent_id+":last");
                                } else {
                                    $(obj.data).insertAfter("#"+modalView+" .modal-body .tabbable .tab-content #tabSheet_"+obj.sheet_id+" tbody #tr_"+obj.parent_id);
                                }
                            }
                            
                            $('#modalNewRow').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalEditRow").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Row',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Row'));
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
                            if (obj.modal == 1) { modalView = 'modalNew'; }
                            else if (obj.modal == 2) { modalView = 'modalEdit'; }

                            $("#"+modalView+" .modal-body .tabbable .tab-content #tabSheet_"+obj.sheet_id+" tbody  #tr_"+obj.parent_id).html(obj.data);
                            
                            $('#modalEditRow').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalNew").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_IA',true);

                var l = Ladda.create(document.querySelector('#btnSave_IA'));
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
                            $("#tableData tbody").append(obj.data);
                            
                            $("#modalNew .modal-body").html('');
                            $('#modalNew').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalEdit").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_IA',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_IA'));
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
                            $("#tableData tbody #tr_"+obj.ID).html(obj.data);
                            
                            $('#modalEdit').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalClone").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnClone_IA',true);

                var l = Ladda.create(document.querySelector('#btnClone_IA'));
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
                            
                            $('#modalClone').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalGenerate").on('submit',(function(e) {
                e.preventDefault();

                var button = $(e.target).find("button[type=submit]:focus").attr("id");

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnGenerate',true);
                formData.append('btnType', button);

                var l = Ladda.create(document.querySelector('#'+button));
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
                            $("#tableDataOpen tbody").append(obj.data);
                            
                            $('#modalGenerate').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalEditForm").on('submit',(function(e) {
                e.preventDefault();

                var button = $(e.target).find("button[type=submit]:focus").attr("id");

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnEdit_Form',true);
                formData.append('btnType', button);

                var l = Ladda.create(document.querySelector('#'+button));
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
                            $("#tableDataOpen tbody #tr_"+obj.ID).html(obj.data);
                            
                            $('#modalEditForm').modal('hide');
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
