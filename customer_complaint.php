<?php 
    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    $today_tx = $date_default_tx->format('Y-m-d');
    $title = "Customer Complaint Management";
    $site = "customer_complaint";
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
    #tableData_Contact input,
    #tableData_Material input,
    #tableData_Service input {
        border: 0 !important;
        background: transparent;
        outline: none;
    }
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
</style>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-users font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Customer Complaint Management</span>
                                        <a class="btn btn-primary btn-xs" data-toggle="modal" href="#addNew_complaint">Add New</a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-bordered" id="datatable">
                                        <thead>
                                            <tr>
                                                <th class="text-center <?php echo $current_client == 1 ? 'hide':''; ?>">Ticket#</th>
                                                <th style="width: 60px;">Date</th>
                                                <th>Customer Name</th>
                                                <th class="<?php echo $current_client == 1 ? '':'hide'; ?>">Complaint Type</th>
                                                <th class="<?php echo $current_client == 1 ? '':'hide'; ?>">Complaint Category</th>
                                                <th class="<?php echo $current_client == 1 ? 'hide':''; ?>" style="width: 150px;">Customer Address</th>
                                                <th class="<?php echo $current_client == 1 ? 'hide':''; ?>" style="width: 100px;">Phone#</th>
                                                <th>Product Name</th>
                                                <th class="text-center <?php echo $current_client == 1 ? 'hide':''; ?>" style="width:150px;">ICAR</th>
                                                <th class="text-center <?php echo $current_client == 1 ? 'hide':''; ?>" style="width:150px;">SCAR</th>
                                                <th class="text-center <?php echo $current_client == 1 ? '':'hide'; ?>" style="width:150px;">ICAR</th>
                                                <th class="text-center" style="width:150px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="care_data">
                                            <?php
                                            $query = "SELECT * FROM tbl_complaint_records where deleted = 0 and care_ownedby = '$switch_user_id'";
                                            $queryRes = mysqli_query($conn, $query);
                                            while($row = $queryRes->fetch_assoc())
                                            {
                                                $complaint_type = $row['complaint_type'];
                                                if($row['complaint_type'] == 0){ $complaint_type = ''; }
                                                else if($row['complaint_type'] == 1){ $complaint_type = 'Electronic (Email)'; }
                                                else if($row['complaint_type'] == 2){ $complaint_type = 'Electronic (Social Media)'; }
                                                else if($row['complaint_type'] == 3){ $complaint_type = 'Oral'; }
                                                else if($row['complaint_type'] == 4){ $complaint_type = 'Written'; }
                                                
                                                $complaint_category = $row['complaint_category'];
                                                if($row['complaint_category'] == 0){ $complaint_category = ''; }
                                                else if($row['complaint_category'] == 1){ $complaint_category = 'Caused Illness or Injury'; }
                                                else if($row['complaint_category'] == 2){ $complaint_category = 'Foreign Material in Cannabis Product Container'; }
                                                else if($row['complaint_category'] == 3){ $complaint_category = 'Foul Odor'; }
                                                else if($row['complaint_category'] == 4){ $complaint_category = 'Improper Packaging'; }
                                                else if($row['complaint_category'] == 5){ $complaint_category = 'Incorrect Concentration of Cannabinoids'; }
                                                else if($row['complaint_category'] == 6){ $complaint_category = 'Mislabeling'; }
                                                
                                                $cam_date = $row['care_date'];
                                                $cam_date = new DateTime($cam_date);
                                                $cam_date = $cam_date->format('Y-m-d');
                                            ?>
                                                <tr id="care_row<?php echo $row['care_id'] ?>">
                                                    <td class="<?php echo $current_client == 1 ? 'hide':''; ?>"><?php echo $row['care_id'] ?></td>
                                                    <td><?php echo $cam_date ?></td>
                                                    <td><?php echo $row['cusName'] ?></td>
                                                    <td class="<?php echo $current_client == 1 ? '':'hide'; ?>"><?php echo $complaint_type ?></td>
                                                    <td class="<?php echo $current_client == 1 ? '':'hide'; ?>"><?php echo $complaint_category ?></td>
                                                    <td class="<?php echo $current_client == 1 ? 'hide':''; ?>"><?php echo $row['cusAddress'] ?></td>
                                                    <td class="<?php echo $current_client == 1 ? 'hide':''; ?>"><?php echo $row['phoneNo'] ?></td>
                                                    <td><?php echo $row['product_name'] ?></td>
                                                    <td class="text-center <?php echo $current_client == 1 ? 'hide':''; ?>">
                                                        <div class="btn-group btn-group">
                            	                            <a  href="#modal_capa" data-toggle="modal" type="button" id="update_capa" data-id="<?= $row['care_id']; ?>" class="btn btn-outline dark btn-sm">ICAR</a>
                                    	                    <a href="#modal_capa_pdf" data-toggle="modal" type="button" id="pdf_capa" data-id="<?= $row['care_id']; ?>" class="btn btn-outline btn-danger btn-sm" onclick="">PDF</a>
                                                        </div>
                                                    </td>
                                                    <td class="text-center <?php echo $current_client == 1 ? 'hide':''; ?>">
                                                        <div class="btn-group btn-group">
                                    	                    <a href="#modal_scar" data-toggle="modal" type="button" id="update_scar" data-id="<?= $row['care_id']; ?>" class="btn btn-outline dark btn-sm" onclick="">SCAR</a>
                            	                            <a  href="#modal_scar_pdf" data-toggle="modal" type="button" id="pdf_scar" data-id="<?= $row['care_id']; ?>" class="btn btn-outline btn-danger btn-sm">PDF</a>
                                                        </div>
                                                    </td>
                                                    <td class="text-center <?php echo $current_client == 1 ? '':'hide'; ?>">
                                                        <?php echo '<input type="checkbox" value="'.$row['capam'].'" onclick="btnCapam(this, '.$row['care_id'].')" '; echo $row['capam']==1 ? 'CHECKED':''; echo '/>'; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group btn-group-circle">
                            	                            <a  href="#modal_update_complaint" data-toggle="modal" type="button" id="update_complaint" data-id="<?= $row['care_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
                                    	                    <a href="#modal_delete_complaint" data-toggle="modal" type="button" id="delete_complaint" data-id="<?= $row['care_id']; ?>" class="btn btn-warning btn-sm" onclick="">Delete</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END BORDERED TABLE PORTLET-->
                        </div>
                        <!-- MODAL AREA-->
                        <?php include "customer_care_folder/modals.php"; ?>
                        <!-- / END MODAL AREA -->           
                    </div>
                    <div id="capa_field_print"></div>

        <?php include_once ('footer.php'); ?>
         <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        <script>
            function toggleField(e, type){
                $(e).prop('required', false);
                $(e).addClass('hide');
                
                if (type == 1) {
                    $(e).next('.form-control').prop('required', true);
                    $(e).next('.form-control').removeClass('hide')
                    $(e).next('.form-control').focus();
                } else {
                    $(e).prev('.form-control').prop('required', true);
                    $(e).prev('.form-control').removeClass('hide')
                    $(e).prev('.form-control').focus();
                    $(e).prev('.form-control').val(0).trigger('change');
                }
            }
            function uploadNew(e) {
                $(e).parent().hide();
                $(e).parent().parent().find('select').removeClass('hide');
            }
            function changeType(e) {
                $(e).parent().find('input').hide();
                $(e).parent().find('input').prop('required',false);
                if($(e).val() == 1) {
                    $(e).parent().find('.fileUpload').show();
                    $(e).parent().find('.fileUpload').prop('required',true);
                } else if($(e).val() == 2 || $(e).val() == 3) {
                    $(e).parent().find('.fileURL').show();
                    $(e).parent().find('.fileURL').prop('required',true);
                }
            }
            function btnCapam(e, id) {
                // alert(id);
                // alert($(e).prop('checked') == true ? 1:0);
                // alert $(e).prop('checked');
                // if ($(this).prop('checked')==true){ 
                c = $(e).prop('checked') == true ? 1:0;
                $.ajax({
                    type: "GET",
                    url: "customer_care_folder/action.php?complaint="+id+"&c="+c,
                    dataType: "html",
                    success: function(response){
                        // alert(response);
                    }
                });
            }
            
            // add new modal
            $(".addNew_complaint").on('submit',(function(e) {
                e.preventDefault();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnAdd_new',true);

                var l = Ladda.create(document.querySelector('#btnAdd_new'));
                l.start();

                $.ajax({
                    url: "customer_care_folder/action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Added Sucessfully!";
                            $('#care_data').append(response);
                            $('#addNew_complaint').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        bootstrapGrowl(msg);
                    }
                });
            }));

            //delete officer
            $(document).on('click', '#delete_complaint', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "customer_care_folder/action.php?delete_complaint_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_delete_complaint .modal-body").html(data);
                    }
                });
            });
            $(".modal_delete_complaint").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                var Status_row = $("#Status").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btndelete_complaint',true);

                var l = Ladda.create(document.querySelector('#btndelete_complaint'));
                l.start();

                $.ajax({
                    url: "customer_care_folder/action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Deleted!!!";
                            $('#care_row'+row_id).empty();
                             $('#modal_delete_complaint').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //update complaint
            $(document).on('click', '#update_complaint', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "customer_care_folder/action.php?get_complaint_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_update_complaint .modal-body").html(data);
                    }
                });
            });
            $(".modal_update_complaint").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_complaint',true);

                var l = Ladda.create(document.querySelector('#btnSave_complaint'));
                l.start();

                $.ajax({
                    url: "customer_care_folder/action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Successfully Save!";
                            $('#care_row'+row_id).empty();
                             $('#care_row'+row_id).append(response);
                             $('#modal_update_complaint').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //perform capa
            $(document).on('click', '#update_capa', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "customer_care_folder/action.php?get_capa_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_capa .modal-body").html(data);
                        selectMulti();
                    }
                });
            });
            $(".modal_capa").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_capa',true);

                var l = Ladda.create(document.querySelector('#btnSave_capa'));
                l.start();

                $.ajax({
                    url: "customer_care_folder/action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Successfully Save!";
                            $('#modal_capa').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //print capa
            $(document).on('click', '#pdf_capa', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "customer_care_folder/print_capa.php?get_capa_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#capa_field_print").html(data);
                        window.print();
                    }
                });
            });

            //multiple table Employees
            $(document).on('click', '#add_no_emp_row', function(){
                var key = 'ids';
              $.ajax({
                  url:'customer_care_folder/fetch_dynamic_field.php',
                  method: 'POST',
                  dataType: 'html',
                  data: {
                      key: key
                  }, success: function (response) {
                    $('#dynamic_field_no_emp').append(response);
                  }
                });
            }); 

            $(document).ready(function(){
                var key = 'ids';
                $(document).on('click', '.btn_remove_no_emp_row', function(){
                    var button_id = $(this).attr("id");
                    $('#row_tbl_no_emp'+button_id+'').remove();
                });
            });


            //perform scar
            $(document).on('click', '#update_scar', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "customer_care_folder/action.php?get_scar_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_scar .modal-body").html(data);
                        selectMulti();
                    }
                });
            });
            $(".modal_scar").on('submit',(function(e) {
                e.preventDefault();
                 var row_id = $("#row_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_scar',true);

                var l = Ladda.create(document.querySelector('#btnSave_scar'));
                l.start();

                $.ajax({
                    url: "customer_care_folder/action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Successfully Save!";
                            $('#modal_scar').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //print scar
            $(document).on('click', '#pdf_scar', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "customer_care_folder/print_scar.php?get_scar_id="+id,
                    dataType: "html",
                    success: function(data){
                        $("#capa_field_print").html(data);
                        window.print();
                    }
                });
            });

            //multiple person notify
            $(document).on('click', '#add_notify_row', function(){
                var key = 'get_notify';
              $.ajax({
                  url:'customer_care_folder/fetch_dynamic_field.php',
                  method: 'POST',
                  dataType: 'html',
                  data: {
                      key: key
                  }, success: function (response) {
                    $('#tbl_person_notify').append(response);
                  }
                });
            }); 

            $(document).ready(function(){
                 var key = 'get_notify';
                $(document).on('click', '.btn_remove_notify_row', function(){
                    var button_id = $(this).attr("id");
                    $('#row_notify'+button_id+'').remove();
                });
            });

            //multiple non-conformance
            $(document).on('click', '#add_non_row', function(){
                var key = 'get_non';
              $.ajax({
                  url:'customer_care_folder/fetch_dynamic_field.php',
                  method: 'POST',
                  dataType: 'html',
                  data: {
                      key: key
                  }, success: function (response) {
                    $('#tbl_non_conformance').append(response);
                  }
                });
            }); 

            $(document).ready(function(){
                var key = 'get_non';
                $(document).on('click', '.btn_remove_non_row', function(){
                    var button_id = $(this).attr("id");
                    $('#row_non'+button_id+'').remove();
                });
            });

            //multiple capa reference
            $(document).on('click', '#add_capa_row', function(){
                var key = 'get_capa';
              $.ajax({
                  url:'customer_care_folder/fetch_dynamic_field.php',
                  method: 'POST',
                  dataType: 'html',
                  data: {
                      key: key
                  }, success: function (response) {
                    $('#capa_data').append(response);
                  }
                });
            }); 

            $(document).ready(function(){
                var key = 'get_capa';
                $(document).on('click', '.btn_remove_capa_row', function(){
                    var button_id = $(this).attr("id");
                    $('#row_capa'+button_id+'').remove();
                });
            });

            //multiple affected
            $(document).on('click', '#add_affected_row', function(){
                var key = 'get_affected';
              $.ajax({
                  url:'customer_care_folder/fetch_dynamic_field.php',
                  method: 'POST',
                  dataType: 'html',
                  data: {
                      key: key
                  }, success: function (response) {
                    $('#data_affected').append(response);
                  }
                });
            }); 

            $(document).ready(function(){
                var key = 'get_affected';
                $(document).on('click', '.btn_remove_affected_row', function(){
                    var button_id = $(this).attr("id");
                    $('#row_affected'+button_id+'').remove();
                });
            });

            //multiple verification
            $(document).on('click', '#add_verification_row', function(){
                var key = 'get_verify';
              $.ajax({
                  url:'customer_care_folder/fetch_dynamic_field.php',
                  method: 'POST',
                  dataType: 'html',
                  data: {
                      key: key
                  }, success: function (response) {
                    $('#data_verification').append(response);
                  }
                });
            }); 

            $(document).ready(function(){
                var key = 'get_verify';
                $(document).on('click', '.btn_remove_verification_row', function(){
                    var button_id = $(this).attr("id");
                    $('#row_verification'+button_id+'').remove();
                });
            });

            //multiple documents
            $(document).on('click', '#add_documents_row', function(){
                var key = 'get_documents';
              $.ajax({
                  url:'customer_care_folder/fetch_dynamic_field.php',
                  method: 'POST',
                  dataType: 'html',
                  data: {
                      key: key
                  }, success: function (response) {
                    $('#data_documents').append(response);
                  }
                });
            }); 

            $(document).ready(function(){
                var key = 'get_documents';
                $(document).on('click', '.btn_remove_documents_row', function(){
                    var button_id = $(this).attr("id");
                    $('#row_documents'+button_id+'').remove();
                });
                
                
				$('#datatable').DataTable({
			        dom: 'Bfrtip',
			        buttons: [
			            {
			                extend: 'print',
			                exportOptions: {
			                    columns: ':visible'
			                }
			            },
			            {
			                extend: 'pdf',
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
			            'colvis'
			        ]
			    });
            });

            //multiple followup
            $(document).on('click', '#add_followup_row', function(){
                var key = 'get_followup';
              $.ajax({
                  url:'customer_care_folder/fetch_dynamic_field.php',
                  method: 'POST',
                  dataType: 'html',
                  data: {
                      key: key
                  }, success: function (response) {
                    $('#data_followup').append(response);
                  }
                });
            }); 

            $(document).ready(function(){
                var key = 'get_followup';
                $(document).on('click', '.btn_remove_followup_row', function(){
                    var button_id = $(this).attr("id");
                    $('#row_followup'+button_id+'').remove();
                });
            });
        </script>
        <style>
            /*Start meeting minutes*/
            @media screen {
              #capa_field_print {
                  display: none;
              }
            }

            @media print {
              body * {
                visibility:hidden;
              }
              #capa_field_print, #capa_field_print * {
                visibility:visible;
              }
              #capa_field_print {
                position:absolute;
                font-size:12px;
                left:0;
                top:0;
              }
            }
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
            .border-left{
                border-left:solid grey 1px;
            }
            .border-right{
                border-right:solid grey 1px;
            }
            .border-both-side{
                border-right:solid grey 1px;
                border-left:solid grey 1px;
            }
            .border-none{
                border:none;
            }
            .border-bottom{
                border:none;
                border-bottom:solid grey 1px;
            }
            textarea{
                text-align: left !mportant;
            }
        </style>
    </body>
</html>