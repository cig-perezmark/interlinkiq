<?php 
    $title = "Certificate of Analysis Management";
    $site = "coa";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
    include_once 'alt-setup/setup.php';
    
    $categories = $conn->execute("SELECT * FROM tbl_coa_categories WHERE in_dropdown = 1 AND deleted_at IS NULL")->fetchAll();
    $analysisTypes = $conn->execute("SELECT * FROM tbl_coa_analysis_types WHERE in_dropdown = 1 AND deleted_at IS NULL")->fetchAll();
?>
<style type="text/css">
/* DataTable*/
/* .table-scrollable .dataTable td>.btn-group,
.table-scrollable .dataTable th>.btn-group {
    position: relative;
} */

.btn-category {
    width: 100%;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: none;
    border-left: none;
    border-right: none;
}

.filtermenu {
    overflow-y: auto;
    overflow-x: hidden;
    max-height: 250px;
}

.filter .filtermenu,
.filter [data-other] {
    display: none;
}

.filter:has(.showmenu:checked) .filtermenu {
    display: block;
}

.filter:has([value=others]:checked) [data-other] {
    display: block;
}

.dt-buttons {
    display: flex;
    align-items: center;
}

table {
    width: 100% !important;
}
</style>

<div class="row">
    <?php
        function get_remote_file_info($url) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_NOBODY, TRUE);
            $data = curl_exec($ch);
            $fileSize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
            $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return [
                'fileExists' => (int) $httpResponseCode == 200,
                'fileSize' => (int) $fileSize
            ];
        }

        // for ($i = 22; $i <= 22; $i++) {

        // }
    ?>
    <div class="col-md-3">
        <div class="portlet light portlet-fit">
            <form class="portlet-body" id="filterRecords" style="text-wrap: wrap; word-break:break-word;">
                <div>Filter by:</div>
                <div class="form-group filter margin-top-15">
                    <label class="btn btn-default btn-category">
                        Category <i class="fa fa-angle-down"></i>
                        <input type="checkbox" class="hide showmenu" checked />
                    </label>
                    <div class="filtermenu">
                        <div class="mt-checkbox-list" id="categoriesFilter"></div>
                    </div>
                </div>
                <div class="form-group filter">
                    <label class="btn btn-default btn-category">
                        Analysis Type <i class="fa fa-angle-down"></i>
                        <input type="checkbox" class="hide showmenu" checked />
                    </label>
                    <div class="filtermenu">
                        <div class="mt-checkbox-list" id="analysisTypesFilter"></div>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 1rem; ">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-success filterBtns">Filter results</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-9">
        <div class="portlet light portlet-fit">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-docs font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">Records
                        <span id="currentLabNameDisplay"></span>
                    </span>
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
                    <div style="display:flex; align-items:center; gap:1rem;">
                        <div id="customCon"></div>
                        <div class="btn-group">
                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a data-toggle="modal" href="<?php echo $FreeAccess == false ? '#modalNew':'#modalNew'; ?>">Add new</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-bordered table-hover" id="tableData">
                    <thead>
                        <tr>
                            <th>Product/Item Name</th>
                            <th>Document Date</th>
                            <th>Received By</th>
                            <th data-orderable="false" style="min-width: 135px;">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL SERVICE -->
    <div class="modal fade" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" enctype="multipart/form-data" class="modalForm modalNew">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Certificate of Analysis Management</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Product/Item Name</label>
                                    <input type="type" class="form-control" name="product" placeholder="Enter product/item name" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Category</label>
                                    <select class="form-control" id="categorySelect" name="category" onchange="catOnChange(this)" required>
                                        <option value="" selected disabled>Select category</option>
                                        <?php foreach($categories ?? [] as $c) echo '<option value="'.$c['id'].'" '.(empty($c['name']) ? 'disabled' : '' ).'>'.(empty($c['name']) ? '(empty)' : $c['name']).'</option>'; ?>
                                        <option value="others">Others</option>
                                    </select>
                                    <input type="text" name="other_category" class="form-control margin-top-15 hide" placeholder="Others (please specify)" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Type of Analysis</label>
                                    <select class="form-control" id="analysisTypeSelect" name="analysis_type" onchange="toaOnchangeEvt(this)" required>
                                        <option value="" selected disabled>Select type</option>
                                        <?php foreach($analysisTypes ?? [] as $c) echo '<option value="'.$c['id'].'" '.(empty($c['name']) ? 'disabled' : '' ).'>'.(empty($c['name']) ? '(empty)' : $c['name']).'</option>'; ?>
                                        <option value="others">Others</option>
                                    </select>
                                    <input type="text" name="other_analysis_type" class="form-control margin-top-15 hide" placeholder="Others (please specify)" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Laboratory Type</label>
                                    <select class="form-control" name="laboratory_type" required>
                                        <option value="" selected disabled>Select type</option>
                                        <option value="in-house">In house</option>
                                        <option value="third-party">Third Party</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Upload Document</label>
                                    <select class="form-control" name="filetype" onchange="changeType(this)" required>
                                        <option value="" selected disabled>Select option</option>
                                        <option value="1">Manual Upload</option>
                                        <option value="3">Google Drive URL</option>
                                    </select>
                                    <input class="form-control margin-top-15 fileUpload" type="file" name="file" style="display: none;" />
                                    <input class="form-control margin-top-15 fileURL" type="url" name="fileurl" style="display: none;" placeholder="https://" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="ccontrol-label">Document Date</label>
                                    <input class="form-control" type="date" name="file_date" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Frequency of Collection</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mt-radio-list">
                                                <label class="mt-radio mt-radio-outline"> Daily
                                                    <input type="radio" value="0" name="frequency" checked />
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio mt-radio-outline"> Weekly
                                                    <input type="radio" value="1" name="frequency" />
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio mt-radio-outline"> Monthly
                                                    <input type="radio" value="2" name="frequency" />
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mt-radio-list">
                                                <label class="mt-radio mt-radio-outline"> Quarterly
                                                    <input type="radio" value="3" name="frequency" />
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio mt-radio-outline"> Biannual
                                                    <input type="radio" value="4" name="frequency" />
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio mt-radio-outline"> Annually
                                                    <input type="radio" value="5" name="frequency" />
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <label>Others</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="radio" value="6" name="frequency" />
                                            <span></span>
                                        </span>
                                        <input class="form-control " type="text" name="frequency_other" placeholder="Please specify">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label">Received By</label>
                                    <input class="form-control" type="text" name="received" required placeholder="Enter received by" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Comment/Notes</label>
                                    <textarea class="form-control" name="notes" placeholder="Write some comment or notes here" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                        <button type="submit" class="btn green ladda-button" name="btnSave_Eforms" id="btnSave_Eforms" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Certificate of Analysis Management</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                        <button type="submit" class="btn green ladda-button" name="btnUpdate_EForms" id="btnUpdate_EForms" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalViewFile" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Certificate of Analysis Management</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            file
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <td>Record Name</td>
                                        <td><strong>q</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td><strong>w</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Filled Out</td>
                                        <td><strong>e</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Signed</td>
                                        <td><strong>r</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Frequency of Collection</td>
                                        <td><strong>t</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Compliance</td>
                                        <td><strong>y</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Date Uploaded</td>
                                        <td><strong>u</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Verified By</td>
                                        <td><strong>i</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Notes</td>
                                        <td><strong>o</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                </div>
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

</div><!-- END CONTENT BODY -->

<?php include_once ('footer.php'); ?>

<script type="text/javascript">
var recordDT;
var freeAccess = <?= $FreeAccess ?>;
var isFetching = false;

$(document).ready(function() {
    // Emjay script starts here
    fancyBoxes();
    $('#save_video').click(function() {
        $('#save_video').attr('disabled', 'disabled');
        $('#save_video_text').text("Uploading...");
        var action_data = "supplier";
        var user_id = $('#switch_user_id').val();
        var privacy = $('#privacy').val();
        var file_title = $('#file_title').val();

        var fd = new FormData();
        var files = $('#file')[0].files;
        fd.append('file', files[0]);
        fd.append('action_data', action_data);
        fd.append('user_id', user_id);
        fd.append('privacy', privacy);
        fd.append('file_title', file_title);
        $.ajax({
            method: "POST",
            url: "controller.php",
            data: fd,
            processData: false,
            contentType: false,
            timeout: 6000000,
            success: function(data) {
                console.log('done : ' + data);
                if (data == 1) {
                    window.location.reload();
                } else {
                    $('#message').html('<span class="text-danger">Invalid Video Format</span>');
                }
            }
        });
    });

    // Emjay script ends here

    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

    $('#modalView, #modalViewFile').on('hide.bs.modal', function() {
        $(this).find('.modal-body').html('');
    })

    $('.select2').select2();
    recordDT = $('#tableData').DataTable({
        lengthMenu: [
            [5, 15, 20, -1],
            [5, 15, 20, "All"],
        ],
        pageLength: 15,
        columnDefs: [{
                orderable: false,
                targets: [-1],
            },
            {
                searchable: false,
                targets: [-1],
            },
        ],
        dom: 'lBfrtip',
        buttons: [{
                extend: 'excel',
                className: 'btn btn-secondary',
                text: 'Excel',
                title: 'COA Records',
                filename: 'COA_Records',
                attr: {
                    'data-bs-toggle': "tooltip",
                    'data-bs-placement': "top",
                    'title': "Convert to Excel  file"
                },
                exportOptions: {
                    columns: ':visible:not(:last-child)'
                }
            }, {
                extend: 'pdf',
                className: 'btn btn-secondary',
                text: 'PDF',
                title: 'COA Records',
                filename: 'COA_Records',
                attr: {
                    'data-bs-toggle': "tooltip",
                    'data-bs-placement': "top",
                    'title': "Download as PDF"
                },
                exportOptions: {
                    columns: ':visible:not(:last-child)'
                }
            },
            'colvis'
        ],
    });


    recordDT.buttons().containers().appendTo('#customCon');

    fancyBoxes();
    fetchRecords();
});

function uploadNew(e) {
    $(e).parent().hide();
    $(e).parent().parent().find('select').removeClass('hide');
}

function changeType(e) {
    $(e).parent().find('input').hide();
    $(e).parent().find('input').prop('required', false);
    if ($(e).val() == 1) {
        $(e).parent().find('.fileUpload').show();
        $(e).parent().find('.fileUpload').prop('required', true);
    } else if ($(e).val() == 2 || $(e).val() == 3) {
        $(e).parent().find('.fileURL').show();
        $(e).parent().find('.fileURL').prop('required', true);
    }
}

function btnEdit(id) {
    $.ajax({
        type: "GET",
        url: "coa-function.php?view_coa=" + id,
        dataType: "html",
        success: function(data) {
            $("#modalView .modal-body").html(data);
            $('.select2').select2();
            selectMulti();
        }
    });
}

function btnView(id, freeaccess) {
    $.ajax({
        type: "GET",
        url: "coa-function.php?coa_view_file=" + id + "&freeaccess=" + freeaccess,
        dataType: "html",
        success: function(data) {
            $("#modalViewFile .modal-body").html(data);
        }
    });
}

function viewLaboratoryRecords(el, id = null, freeaccess = null) {
    // reset search
    recordDT.column(0).search('').draw();
    $('[data-labname]').removeClass('bold');
    $('#currentLabNameDisplay').text('')
    // search
    id && recordDT.column(0).search('search_me@' + id).draw();
    if (el.dataset.labname) {
        el.classList.add('bold');
        $('#currentLabNameDisplay').text(' - ' + el.dataset.labname)
    }
}

function otherFilterChangeEvt(el) {
    if (!el.checked) {
        $(el).closest('.filter').find('[data-other]').val("");
    }
}

function createActionBtns(id) {
    if (!freeAccess) {
        return `
            <div class="btn-group btn-group-circle">
                <a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit(${id})">Edit</a>
                <a href="#modalViewFile" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnView(${id}, ${freeAccess})">View</a>
            </div>
        `;
    } else {
        return `<a href="#modalViewFile" class="btn btn-success btn-sm btnView btn-circle" data-toggle="modal" onclick="btnView(${id}, ${freeAccess})">View</a>`;
    }
}

function fetchRecords(formData = null) {
    if (isFetching) {
        console.log('Already fetching...');
        return;
    }

    isFetching = true;
    formData = formData || new FormData();
    formData.append('fetch_coa', true);

    var l = Ladda.create(document.querySelector('.filterBtns'));
    l.start();

    $.ajax({
        method: "POST",
        url: "coa-function.php",
        data: formData,
        processData: false,
        contentType: false,
        timeout: 6000000,
        success: function({
            data,
            categories,
            analysis_types
        }) {
            recordDT.clear().draw();
            if (data) {
                data.forEach((d) => {
                    recordDT.row.add([
                        d.product_name,
                        d.files_date || '',
                        d.received_by || '',
                        createActionBtns(d.id),
                    ]).draw();
                })
            }

            let dropdownSelect = $('#categorySelect');
            let listContainer = $('#categoriesFilter');
            listContainer.html('');
            dropdownSelect.html('');
            dropdownSelect.append('<option value="" selected disabled>Select category</option>');

            categories && categories.forEach((c) => {
                if (c.name.trim() == '') return;

                // writing the filters
                listContainer.append(`
                    <label class="mt-checkbox mt-checkbox-outline"> 
                        <div style="width:100%; display:flex; justify-content:space-between;">
                            ${c.name} <span class="badge badge-default hide"> 0 </span>
                        </div>
                        <input type="checkbox" value="${c.id}" name="category[]" ${c.filtered ? 'checked' : ''}>
                        <span></span>
                    </label>
                `);

                // populating the dropdown
                dropdownSelect.append(`<option value="${c.id}" ${c.name.trim() == '' ? 'disabled' : ''}>${c.name.trim() == '' ? '(empty)' : c.name}</option>`)
            });
            dropdownSelect.append('<option value="others">Others</option>');

            listContainer = $('#analysisTypesFilter');
            listContainer.html('');
            dropdownSelect = $('#analysisTypeSelect');
            dropdownSelect.html('');
            dropdownSelect.append('<option value="" selected disabled>Select category</option>');

            analysis_types && analysis_types.forEach((c) => {
                if (c.name.trim() == '') return;

                listContainer.append(`
                    <label class="mt-checkbox mt-checkbox-outline"> 
                        <div style="width:100%; display:flex; justify-content:space-between;">
                            ${c.name} <span class="badge badge-default hide"> 0 </span>
                        </div>
                        <input type="checkbox" value="${c.id}" name="analysis_type[]" ${c.filtered ? 'checked' : ''}>
                        <span></span>
                    </label>
                `);

                // populating the dropdown
                dropdownSelect.append(`<option value="${c.id}" ${c.name.trim() == '' ? 'disabled' : ''}>${c.name.trim() == '' ? '(empty)' : c.name}</option>`)
            });
            dropdownSelect.append('<option value="others">Others</option>');
        },
        complete: function() {
            l.stop();
            isFetching = false;
        }
    });
}

function catOnChange(el) {
    if (el.value == 'others') {
        $(el).closest('.form-group').find('[name=other_category]').removeClass('hide').attr('required', true);
    } else {
        $(el).closest('.form-group').find('[name=other_category]').addClass('hide').val('').removeAttr('required');
    }
}

function toaOnchangeEvt(el) {
    if (el.value == 'others') {
        $(el).closest('.form-group').find('[name=other_analysis_type]').removeClass('hide').attr('required', true);
    } else {
        $(el).closest('.form-group').find('[name=other_analysis_type]').addClass('hide').val('').removeAttr('required');
    }
}

$(".modalNew").on('submit', (function(e) {
    e.preventDefault();

    formObj = $(this);
    if (!formObj.validate().form()) return false;

    var formData = new FormData(this);
    formData.append('save_new_coa', true);

    var l = Ladda.create(document.querySelector('#btnSave_Eforms'));
    l.start();

    $.ajax({
        url: "coa-function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
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
                fetchRecords();
                $('#modalNew').modal('hide');
                e.target.reset();
                $(e.target).find('select').val('').trigger('change');
            } else {
                msg = "Error!"
            }

            bootstrapGrowl(msg);
        },
        error: function() {
            bootstrapGrowl('Error!');
        },
        complete: function() {
            l.stop();
        }
    });
}));
$(".modalUpdate").on('submit', (function(e) {
    e.preventDefault();

    formObj = $(this);
    if (!formObj.validate().form()) return false;

    var formData = new FormData(this);
    formData.append('coa_update', true);

    var l = Ladda.create(document.querySelector('#btnUpdate_EForms'));
    l.start();

    $.ajax({
        url: "coa-function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
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
            if (response.data) {
                msg = "Sucessfully saved!";

                fetchRecords();
                $('#modalView').modal('hide');
                e.target.reset();

            } else {
                msg = "Error!"
            }

            bootstrapGrowl(msg);
        },
        error: function() {
            bootstrapGrowl('Error!');
        },
        complete: function() {
            l.stop();
        }
    });
}));
$('#filterRecords').on('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    fetchRecords(formData);
});
$('#filterRecords').on('reset', function(e) {
    fetchRecords();
});
</script>
</body>

</html>