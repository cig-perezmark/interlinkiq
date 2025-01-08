<?php 
    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    $today_tx = $date_default_tx->format('Y-m-d');
    $title = "E-forms Library";
    $site = "form-catalog";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
    include_once ('database_forms.php');
?>
<style type="text/css">
    /*Loader*/
    .loader {
      display: inline-block;
      width: 30px;
      height: 30px;
      position: relative;
      border: 4px solid #Fff;
      top: 50%;
      animation: loader 2s infinite ease;
    }
    
    .loader-inner {
      vertical-align: top;
      display: inline-block;
      width: 100%;
      background-color: #fff;
      animation: loader-inner 2s infinite ease-in;
    }
    
    @keyframes loader {
      0% {
        transform: rotate(0deg);
      }
      
      25% {
        transform: rotate(180deg);
      }
      
      50% {
        transform: rotate(180deg);
      }
      
      75% {
        transform: rotate(360deg);
      }
      
      100% {
        transform: rotate(360deg);
      }
    }
    
    @keyframes loader-inner {
      0% {
        height: 0%;
      }
      
      25% {
        height: 0%;
      }
      
      50% {
        height: 100%;
      }
      
      75% {
        height: 100%;
      }
      
      100% {
        height: 0%;
      }
    }
    .bootstrap-tagsinput { min-height: 100px; }
    .mt-checkbox-list {
        column-count: 3;
        column-gap: 40px;
    }
    #tableData_Contact input,
    #tableData_Material input,
    #tableData_Service input {
        border: 0 !important;
        background: transparent;
        outline: none;
    }
    /* Define spinning animation */
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Apply spinning animation to glyphicon-refresh class */
    .glyphicon-spin {
        display: inline-block;
        -webkit-animation: spin 1s infinite linear;
        animation: spin 1s infinite linear;
    }
    .d-none {
        display:none!important;
    }
    .margin-5 {
        margin-top: 5em;
    }
    .modal-xxl {
        width: 1700px;
    }
    .list-group-item {
        border:none;
    }
    .border {
        border: 1px solid #e7ecf1;
        margin-top:3.28;
    }
    .filter-flex {
        display:flex;
        flex-direction: column;
    }
    .filter--title {
        margin-top: 2rem;
    }
    table th{
        text-transform: uppercase;
        /*text-align: center;*/
    }
    .d-flex {
        display: flex;
    }
    .justify-content-end{
        justify-content: end;
    }
    .mt-2{
        margin-top: 2rem;
    }
    .nav-tabs {
        border-bottom: 1px solid transparent;
    }
    #actionBtn {
        position: fixed;
        right: 0;
        bottom: 0;
        padding: 0 100px 25px 0;
        z-index: 4;
    }
    
    .col1{
        padding: 1rem 0;
    }
    .col2 {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem 0;
    }
    .d-flex {
        display: flex;
    }
    .justify-content-center {
        justify-content: center;
    }
    .justify-content-between {
        justify-content: space-between;
    }
    .dt-buttons {
        margin: 2rem 0;
    }
    .page-container-bg-solid .tabbable-line>.tab-content {
        border-top: 1px solid transparent;
    }
    .tabbable-line>.tab-content {
        padding: 0;
    }
    /* .widget-thumb .widget-thumb-wrap {
        overflow: unset;
    }
    .table-scrollable {
        overflow: unset;
        z-index: 2;
    } */
    .swal2-container {
        z-index: 9999;
    }

    .table-scrollable {
        overflow-y: auto;
    }
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="widget-thumb widget-bg-color-white margin-bottom-20">
                <div class="widget-thumb-wrap">
                    <?php if($_COOKIE['ID'] != 1552 && $_COOKIE['ID'] != 1556): ?>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFormModal">Add New Form</button>
                    </div>
                    <?php endif?>
                    <table class="table table-bordered table-hover" id="dataTable_1">
                        <thead class="bg-primary py-3">
                            <tr>
                                <th style="padding: 1rem">Form</th>
                                <th style="padding: 1rem" class="text-center" width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Fetch form_owned values for the user
                                $query_owned = $conn->prepare("SELECT id, file, form_name FROM tbl_eform_library WHERE enterprise_id = ? AND status = 1");
                                
                                if (!$query_owned) {
                                    die('Error: ' . $conn->error);
                                }
                            
                                // Bind the parameter and execute the query
                                $query_owned->bind_param('i', $switch_user_id);
                                $query_owned->execute();
                            
                                // Bind the result columns to separate variables
                                $query_owned->bind_result($id, $file, $form_name);
                            
                                // Fetch the rows and display them in a table
                                while ($query_owned->fetch()) {
                                    echo '<tr>';
                                    echo '<td>'.$form_name.'</td>';
                                    echo '<td class="text-center">';
                                    if(!empty($file)) {
                                        echo '<a class="btn btn-success btn-sm preview-button" data-value="library/eforms/files/'. $file .'" data-toggle="modal" data-target="#previewFile">Preview</a> ';
                                        echo '<a href="library/eforms/files/'. $file .'" class="btn btn-danger btn-sm" download="" >Download</a>';
                                    }
                                    // manual forbid user for accessing this button (lizbeth id)
                                    if($_COOKIE['ID'] != 1552 && $_COOKIE['ID'] != 1556) {
                                        echo '<a class="btn btn-info btn-sm reupload-file" data-id="'. $id .'" data-toggle="modal" data-target="#uploadFile">Upload</a>';
                                    }
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                $query_owned->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- ADD FORM  -->
    <div class="modal fade" id="addFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add new Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="?" id="addForm" enctype="multipart/form-data">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Form name</label>
                <input type="text" class="form-control" name="name" required>
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">File</label>
                <input type="file" class="form-control" name="file" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
        </div>
      </div>
    </div>
    
    <!-- UPLOAD FORM FILE -->
    <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="uploadFileLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFileLabel">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="uploadFileForm" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="file">Choose file</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <input type="hidden" name="id" id="fileId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="uploadFileForm">Upload</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- PREVIEW FORM FILE -->
    <div class="modal fade" id="previewFile" tabindex="-1" role="dialog" aria-labelledby="previewFileLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 90%!important">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewFileLabel">File Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="filePreview" style="width:100%; height:900px;" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
    
    <script>
        $(document).ready(function() {
            $(document).on('click', '.preview-button', function() {
                var fileUrl = $(this).data('value');
                $('#filePreview').attr('src', fileUrl);
            });
            
            $(document).on('click', '.reupload-file', function() {
                var id = $(this).data('id');
                
                $('#fileId').val(id);
                
                $('#uploadFileForm').off('submit').on('submit', function(e) {
                    e.preventDefault();
                    
                    var formData = new FormData(this);
                    formData.append('update_file', 'update_file');
            
                    $.ajax({
                        url: 'eform-library/api/functions.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#uploadFileForm')[0].reset();
                            $('#uploadFile').modal('hide');
                            location.reload();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log('Error: ' + textStatus);
                        }
                    });
                });
            });

            
            $('#addForm').on('submit', function(e) {
                e.preventDefault();
            
                var formData = new FormData(this);
                formData.append('add_form', 'add_form');
        
                $.ajax({
                    url: 'eform-library/api/functions.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#addForm')[0].reset();
                        $('#addFormModal').modal('hide');
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error: ' + textStatus);
                    }
                });
            });
        });
    </script>
    
    <script>
        function initializeDataTable(selector) {
            return $(selector).dataTable({
                // DataTable initialization options here
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [
                    { extend: 'print', className: 'btn default' },
                    { extend: 'pdf', className: 'btn red' },
                    { extend: 'csv', className: 'btn green' }
                ],
                // columnDefs: [
                //     { targets: [0, 8], orderable: false }
                // ],
                order: [
                    [0, 'asc']
                ],
                lengthMenu: [
                    [5, 10, 15, 25, -1],
                    [5, 10, 15, 25, 'All']
                ],
                pageLength: 15,
                searching: true,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
             
            });
        }
        
       
        $(document).ready(function(){
            initializeDataTable('#dataTable_1');
        })
        
    </script>
    <?php include_once ('footer.php'); ?>
    </body>
</html>