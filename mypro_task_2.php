<?php 
    if(!isset($_COOKIE['ID'])){
        echo '<script>
            if (document.referrer == "") {
                window.location.href = "login";
            } else {
                window.history.back();
            }
        </script>';
    }
    $title = "My Pro";
    $site = "MyPro";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';
    $base_url = "https://interlinkiq.com/";
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php');
?>
<style type="text/css">
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

	.txta {
		width: 100%;
		max-width: 500px;
		min-height: 26px;
		font-family: Arial, sans-serif;
		font-size: 16px;
		overflow: hidden;
		line-height: 1.4;
		border: 0;
		resize: none;
	}
    table.table-bordered.dataTable th:last-child {
		border-right-width: unset;
	}
	#tableData_category tfoot input {
	    border: 1px solid #ccc;
	    padding: 1rem;
	    width: 100%;
	}

    /*Start meeting minutes*/
    @media screen {
        #pdf_generate {
            display: none;
        }
    }

    @media print {
        body * {
            visibility:hidden;
        }
        #pdf_generate, #pdf_generate * {
            visibility:visible;
        }
        #pdf_generate {
            font-size:12px !important;
            position:absolute;
            left:0;
            top:0;
        }
    }
    .parentTbls{
        color:;
        border:solid grey 1px;
        padding: 0px 10px;
        width:;
    }
    .child_border{
        font-weight:;
        border:solid #ccc 1px;
        padding: 0px 10px;
    }
    .child_1{
        background-color:;
        color:;
        font-weight:;
        border:;
        padding: 0px 10px;
    }
    .child_2{
        background-color:#008E89;
        color:#fff;
        font-weight:;
        border:solid #ccc 1px;
        padding: 0px 10px;
    }
    .child_3{
        background-color:#18978F;
        color:#fff;
        font-weight:;
        border:solid #fff 2px;
        padding: 0px 10px;
    }
</style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <!--<div class="portlet-title tabbable-line" style="min-height: 40px !important;">-->
                <!--    <div class="caption">-->
                <!--        <i class="icon-earphones-alt font-dark"></i>-->
                <!--        <span class="caption-subject font-dark bold uppercase"><a href="https://interlinkiq.com/MyPro.php#tab_Me">My Pro</a></span>-->
                <!--    </div>-->
                <!--</div>-->
                <div class="portlet-body" style="padding: 0px !important;">
                    <?php
                        $i_user = $_COOKIE['ID'];
                        $myProMain = $_GET['view_id'];
                         
                        // $queryMain = "SELECT * FROM tbl_MyProject_Services left join tbl_MyProject_Services_Assigned on MyPro_PK = MyPro_id where MyPro_id = $myProMain";
                        $resultMain = mysqli_query($conn, "
                            SELECT 
                            m.MyPro_id AS m_ID,
                            m.Project_Name AS m_name,
                            m.Project_Description AS m_description,
                            m.Start_Date AS m_date_start,
                            m.Desired_Deliver_Date AS m_date_end,
                            c.completed AS c_completed,
                            c.not_started AS c_not_started,
                            c.in_progress AS c_in_progress


                            FROM tbl_MyProject_Services AS m

                            LEFT JOIN (
                                SELECT
                                Parent_MyPro_PK,
                                SUM(CASE WHEN CIA_progress = 2 THEN 1 ELSE 0 END) AS completed,
                                SUM(CASE WHEN CIA_progress = 1 THEN 1 ELSE 0 END) AS in_progress,
                                SUM(CASE WHEN CIA_progress = 0 THEN 1 ELSE 0 END) AS not_started
                                FROM tbl_MyProject_Services_Childs_action_Items 

                                WHERE 
                                Parent_MyPro_PK = $myProMain
                            ) AS c
                            ON c.Parent_MyPro_PK > 0

                            WHERE m.MyPro_id = $myProMain
                        ");
                        if ( mysqli_num_rows($resultMain) > 0 ) {
                            $rowMain = mysqli_fetch_array($resultMain);
                            echo '<div class="row" style="padding: 0px !important;">
                                <div class="col-md-12" style="padding-top: 0px !important;">
                                    <div class="table-scrollable" style="padding: 0px !important;">
                                    <table class="table dt-responsive" style="background-color:#1F4690;color:#fff;padding-top: 0px;" width="100%">
                                        <thead>
                                            <tr style="color:#fff;font-size:16px;font-weight:800;">
                                                <th>Ticket#</th>
                                                <th>Project Name</th>
                                                <th>Task Description</th>
                                                <th>Request Date</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>No.: '.htmlentities($rowMain['m_ID'] ?? '').'</td>
                                                <td>'.htmlentities($rowMain['m_name'] ?? '').'</td>
                                                <td>'.htmlentities($rowMain['m_description'] ?? '').'</td>
                                                <td>'.date("Y-m-d", strtotime($rowMain['m_date_start'])).'</td>
                                                <td>'.date("Y-m-d", strtotime($rowMain['m_date_end'])).'</td>
                                                <td>Compliance(';

                                                    $c_completed = $rowMain['c_completed'];
                                                    $c_not_started = $rowMain['c_not_started'];
                                                    $c_in_progress = $rowMain['c_in_progress'];
                                                    $c_not_completed = $c_not_started + $c_in_progress;
                                                    $percentage = 0;
                                                    if ($c_not_completed == 0 AND $c_completed > 0) {
                                                        $percentage = 100;
                                                    } else if ($c_not_completed > 0 AND $c_completed > 0) {
                                                        $percentage = number_format(($c_completed / ($c_not_completed + $c_completed)) * 100, 2);
                                                    }
                                                    echo $percentage;

                                                echo '%)</td>
                                                <td>
                                                    <a style="color:#fff;" href="#modalAddActionItem" data-toggle="modal" class="btn green btn-outline btn-xs" onclick="btnNew_File('.$rowMain['m_ID'].')">Add New</a>
                                                    <a style="color:#fff;" class="btn blue btn-outline btn-xs btnViewMyPro_update" data-toggle="modal" href="#modalGetMyPro_update" data-id="'.$rowMain["m_ID"].'>">View</a>
                                                </td>
                                            </tr>
                                    </table>
                                    </div>
                                </div>
                            </div>';
                        }
                    ?>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6">
                                <select id="single-append-radio" class="form-control select2-allow-clear" onchange="search_filter(this.value)">
                                    <option></option>
                                    <?php
                                        $resultType = mysqli_query($conn, "SELECT CAI_id, CAI_filename, CAI_description FROM tbl_MyProject_Services_Childs_action_Items where Parent_MyPro_PK = $myProMain order by CAI_filename ASC");
                                        while($rowType = mysqli_fetch_array($resultType)) { 
                                           echo '<option value="'.$rowType['CAI_id'].'" >'.htmlentities($rowType['CAI_filename'] ?? '').', '.htmlentities($rowType['CAI_description'] ?? '').'</option>'; 
                                        } 
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <a style="font-weight:600;color:;" href="#modalGet_filter_notstarted" data-toggle="modal" class="btn dark btn-outline form-control" onclick="filter_notstarted(<?php echo $myProMain; ?>)">
                                    Not Started <i style="color:#C0B236;">(<?php echo $c_not_started; ?>)</i>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a style="font-weight:600;color:;" href="#modalGet_filter_progress" data-toggle="modal" class="btn dark btn-outline form-control" onclick="filter_progress(<?php echo $myProMain; ?>)">
                                    In-Progress <i style="color:#C0B236;">(<?php echo $c_in_progress; ?>)</i>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a style="font-weight:600;color:;" href="#modalGet_filter_completed" data-toggle="modal" class="btn dark btn-outline form-control" onclick="filter_completed(<?php echo $myProMain; ?>)">
                                    Completed <i style="color:#C0B236;">(<?php echo $c_completed; ?>)</i>
                                </a>
                            </div>
                        </div>
                    </div>
                               
                    <div class="table-scrollable">
                        <input type="hidden" id="data_search" value="<?php echo $myProMain; ?>">
                        <table class="parentTbls">
                            <tbody>
                                <tr id="data_items" class="childTbls"></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- / START MODAL AREA -->
            <?php include "mypro_function/mypro_modals.php"; ?>
        <!-- / END MODAL AREA -->
                         
        </div>
        <!-- END CONTENT BODY -->
            <div id="pdf_generate">
            
        </div>
        <?php include_once ('footer.php'); ?>
        <script src="assets/global/plugins/datatables/datatable_custom.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>

        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>

        <script src="assets/pages/scripts/table-datatables-responsive.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
        <script src="assets/pages/scripts/jquery.table2excel.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        <script type="text/javascript">
            // print
            $(document).on('click', '#pdf_report_notstarted', function(){
                var pdf_notstarted_id = $(this).attr('data-id');
                $.ajax({
                    url:'mypro_function/pdf_generate.php',
                    method: 'POST',
                    data: {pdf_notstarted_id:pdf_notstarted_id},
                    success:function(data){
                        $("#pdf_generate").empty();
                        $("#pdf_generate").html(data);
                        window.print();
                    }
                });
            });
            
            $(document).on('click', '#pdf_report_inprogress', function(){
                var pdf_inprogress_id = $(this).attr('data-id');
                $.ajax({
                    url:'mypro_function/pdf_generate.php',
                    method: 'POST',
                    data: {pdf_inprogress_id:pdf_inprogress_id},
                    success:function(data){
                        $("#pdf_generate").empty();
                        $("#pdf_generate").html(data);
                        window.print();
                    }
                });
            });
            
            $(document).on('click', '#pdf_report_completed', function(){
                var pdf_completed_id = $(this).attr('data-id');
                $.ajax({
                    url:'mypro_function/pdf_generate.php',
                    method: 'POST',
                    data: {pdf_completed_id:pdf_completed_id},
                    success:function(data){
                        $("#pdf_generate").empty();
                        $("#pdf_generate").html(data);
                        window.print();
                    }
                });
            });
             
            $(document).ready(function(){
                getData('ids');
            });
            
            // View project
            $(".btnViewMyPro_update").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "mypro_function/fetch_MyPro.php?modalView="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetMyPro_update .modal-body").html(data);
                        selectMulti();
                    }
                });
            });
            function uiBlock(get_id) {
                $('#'+get_id).block({
                    message: '<div class="loading-message loading-message-boxed bg-white"><img src="assets/global/img/loading-spinner-grey.gif" align=""><span>&nbsp;&nbsp;LOADING...</span></div>', 
                    css: { border: '0', width: 'auto' } 
                });
            }
            function getData(key) {
                // reviewed code
                var view_id = <?= $_GET['view_id'] ?>;
                $.ajax({
                    url:'mypro_function/fetch_task_function.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        view_id:view_id,
                        key: key
                    }, success: function (response) {
                        if (key == 'ids')
                        $('#data_items').append(response);
                    }
                });
            }
            function view_more(get_id){
                // alert(id);
                var newwParent = $('#data_child'+get_id+' > tr');

                $("#hide_box tr").empty();
                $("#main_task > tr").empty();
                $('html,body').animate({scrollTop:$("#center_"+get_id).offset().top}, 'slow');
                if (newwParent.length == 0) {

                    var view_id = <?= $_GET['view_id'] ?>;
                    uiBlock(get_id);
                    $.ajax({
                        url:'mypro_function/fetch_task_function.php',
                        method: 'POST',
                        dataType: 'text',
                        data: {
                            view_id:view_id,
                            get_id:get_id,
                            key: 'child_two'
                        }, success: function (response) {
                            if (get_id == get_id)
                            $('#data_child'+get_id).empty();
                            $('#data_child'+get_id).append(response);
                            $('html,body').animate({scrollTop:$("#center_"+get_id).offset().top}, 'slow');
                            $('#'+get_id).unblock();
                        }
                    });
                }
            }
            //search 
            function search_filter(search_field){
               var search_val = $('#single-append-radio').val();
               var ids = <?= $_GET['view_id'] ?>;
               let url = "mypro_task.php";
                $.ajax({
                    url:'mypro_function/search_task.php',
                    method: 'POST',
                    data: {search_val:search_val},
                    success:function(data){
                        $("#hide_box tr").empty();
                        $("#main_task > tr").empty();
                        $("#main_ > tbody").empty();
                        $("#searched_data"+search_val).html(data);
                        $('html,body').animate({scrollTop:$("#searched_data"+search_val).offset().top}, 'slow');
                    }
                });
            }
            
            
            // new parent
            function btnNew_File(id) {
                $.ajax({
                    type: "GET",
                    url: "mypro_function/function.php?modalNew_File="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalAddActionItem .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalAddActionItem").on('submit',(function(e) {
                e.preventDefault();
                 var project_id = $("#project_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_History',true);

                var l = Ladda.create(document.querySelector('#btnSave_History'));
                l.start();

                $.ajax({
                    url: "mypro_function/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            $('#data_items').append(response);
                             $('#modalAddActionItem').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            
            // File Section
            function btnNew_History(id) {
                $.ajax({
                    type: "GET",
                    url: "mypro_function/mypro_action.php?modalAddHistory_1b="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetHistoryb .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGetHistoryb").on('submit',(function(e) {
                e.preventDefault();
                var parent_id = $("#parent_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_AddChildItemb',true);

                var l = Ladda.create(document.querySelector('#btnSave_AddChildItemb'));
                l.start();

                $.ajax({
                    url: "mypro_function/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        console.log(response);
                        if ($.trim(response)) {
                            
                            msg = "Sucessfully Save!";
                                $('#data_child'+parent_id).append(response);
                                 $('#modalGetHistoryb').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        bootstrapGrowl(msg);
                    }
                });
            }));
             // See more parent Item
            function get_moreDetails(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?seemoreId="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_more_detail .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            
            // See more sub Item 2
            function get_moreDetails2(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?seemoreId2="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_more_detail2 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            
            function get_moreDetails_sub2(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?seemore_subId2="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_more_detail_sub2 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            // See more sub Item 3
            function get_moreDetails3(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?seemoreId3="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_more_detail3 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            function get_moreDetails_sub3(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?seemore_subId3="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_more_detail_sub3 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            
            function get_moreDetails_sub4(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?seemore_subId4="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_more_detail_sub4 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            
            function get_moreDetails_sub5(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?seemore_subId5="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_more_detail_sub5 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            
            function get_moreDetails_sub6(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?seemore_subId6="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_more_detail_sub6 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            
            // See more parent Item
            function get_moreDetails4(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?seemoreId4="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_more_detail4 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            
            // See more parent Item
            function get_moreDetails5(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?seemoreId5="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_more_detail5 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            
            // See more parent Item
            function get_moreDetails6(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?seemoreId6="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_more_detail6 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            
            
            // Update parent Item
            function onclick_parent(id) {
                $.ajax({
                    type: "GET",
                    url: "mypro_function/mypro_action.php?getParentId_2="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_parent .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_parent").on('submit',(function(e) {
                //e.preventDefault();
                 var parent_ids = $("#parent_ids").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSubmit_parent',true);

                var l = Ladda.create(document.querySelector('#btnSubmit_parent'));
                l.start();

                $.ajax({
                    url: "mypro_function/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            $('#parents_'+parent_ids).empty();
                            $('#parents_'+parent_ids).append(response);
                             $('#modalGet_parent').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // Update child 2 Item
            function onclick_2(id) {
                $.ajax({
                    type: "GET",
                    url: "mypro_function/mypro_action.php?getId_2b="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_child2b .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_child2b").on('submit',(function(e) {
                e.preventDefault();
                 var ids = <?= $_GET['view_id'] ?>;
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSubmit_2b',true);

                var l = Ladda.create(document.querySelector('#btnSubmit_2b'));
                l.start();

                $.ajax({
                    url: "mypro_function/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            
                            var obj = jQuery.parseJSON(response);
                                var data = '<td class="child_border" width="80px" style="border:solid yellow 1px;">'+obj.CAI_id+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">From: '+obj.CAI_User_PK+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_filename+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_description+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_Accounts+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.Action_Items_name+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Assign to: '+obj.CAI_Assign_to+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;"><b>'+obj.CIA_progress+'</b></td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Rendered: '+obj.CAI_Rendered_Minutes+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Start: '+obj.CAI_Action_date+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Due: '+obj.CAI_Action_due_date+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_files+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.comment+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.action_btn+'</td>';
                                $('#sub_two_'+obj.CAI_id).empty();
                            $('#sub_two_'+obj.CAI_id).append(data);
                             $('#modalGet_child2b').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // Update shortcut
            function onclick_shortcut(id) {
                $.ajax({
                    type: "GET",
                    url: "mypro_function/mypro_action.php?getId_shortcut="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_shortcut .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_shortcut").on('submit',(function(e) {
                e.preventDefault();
                var ids = <?= $_GET['view_id'] ?>;
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSubmit_shortcut',true);

                var l = Ladda.create(document.querySelector('#btnSubmit_shortcut'));
                l.start();

                $.ajax({
                    url: "mypro_function/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            
                            var obj = jQuery.parseJSON(response);
                                var data = '<td class="child_border" width="80px" style="border:solid yellow 1px;">'+obj.CAI_id+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">From: '+obj.CAI_User_PK+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_filename+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_description+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_Accounts+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.Action_Items_name+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Assign to: '+obj.CAI_Assign_to+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;"><b>'+obj.CIA_progress+'</b></td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Rendered: '+obj.CAI_Rendered_Minutes+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Start: '+obj.CAI_Action_date+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Due: '+obj.CAI_Action_due_date+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_files+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.comment+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.action_btn+'</td>';
                                $('#shortcut_'+obj.CAI_id).empty();
                            $('#shortcut_'+obj.CAI_id).append(data);
                             $('#modalGet_shortcut').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // Update child 3 Item
            function onclick_3(id) {
                $.ajax({
                    type: "GET",
                    url: "mypro_function/mypro_action.php?getId_3b="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_child3b .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_child3b").on('submit',(function(e) {
                e.preventDefault();
                 var ids = <?= $_GET['view_id'] ?>;
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSubmit_3b',true);

                var l = Ladda.create(document.querySelector('#btnSubmit_3b'));
                l.start();

                $.ajax({
                    url: "mypro_function/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            
                            var obj = jQuery.parseJSON(response);
                                var data = '<td class="child_border" width="80px" style="border:solid yellow 1px;">'+obj.CAI_id+'</td>';
                                data += '<td class="child_border" width="80px" style="border:solid yellow 1px;"></td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">From: '+obj.CAI_User_PK+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_filename+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_description+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_Accounts+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.Action_Items_name+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Assign to: '+obj.CAI_Assign_to+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;"><b>'+obj.CIA_progress+'</b></td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Rendered: '+obj.CAI_Rendered_Minutes+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Start: '+obj.CAI_Action_date+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Due: '+obj.CAI_Action_due_date+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_files+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.comment+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.action_btn+'</td>';
                                $('#sub_three_main'+obj.CAI_id).empty();
                            $('#sub_three_main'+obj.CAI_id).append(data);
                             $('#modalGet_child3b').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // Update child 4 Item
            function onclick_4(id) {
                $.ajax({
                    type: "GET",
                    url: "mypro_function/mypro_action.php?getId_4b="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_child4b .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_child4b").on('submit',(function(e) {
                e.preventDefault();
                 var ids = <?= $_GET['view_id'] ?>;
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSubmit_4b',true);

                var l = Ladda.create(document.querySelector('#btnSubmit_4b'));
                l.start();

                $.ajax({
                    url: "mypro_function/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            
                            var obj = jQuery.parseJSON(response);
                                var data = '<td class="child_border" width="80px" style="border:solid yellow 1px;">'+obj.CAI_id+'</td>';
                                data += '<td class="child_border" width="80px" style="border:solid yellow 1px;"></td>';
                                data += '<td class="child_border" width="80px" style="border:solid yellow 1px;"></td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">From: '+obj.CAI_User_PK+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_filename+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_description+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_Accounts+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.Action_Items_name+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Assign to: '+obj.CAI_Assign_to+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;"><b>'+obj.CIA_progress+'</b></td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Rendered: '+obj.CAI_Rendered_Minutes+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Start: '+obj.CAI_Action_date+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Due: '+obj.CAI_Action_due_date+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_files+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.comment+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.action_btn+'</td>';
                                $('#sub_four_'+obj.CAI_id).empty();
                            $('#sub_four_'+obj.CAI_id).append(data);
                             $('#modalGet_child4b').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        bootstrapGrowl(msg);
                    }
                });
            }));
            
             // Update child 5 Item
            function onclick_5(id) {
                $.ajax({
                    type: "GET",
                    url: "mypro_function/mypro_action.php?getId_5b="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_child5b .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_child5b").on('submit',(function(e) {
                e.preventDefault();
                 var ids = <?= $_GET['view_id'] ?>;
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSubmit_5b',true);

                var l = Ladda.create(document.querySelector('#btnSubmit_5b'));
                l.start();

                $.ajax({
                    url: "mypro_function/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            
                            var obj = jQuery.parseJSON(response);
                                var data = '<td class="child_border" width="80px" style="border:solid yellow 1px;">'+obj.CAI_id+'</td>';
                                data += '<td class="child_border" width="80px" style="border:solid yellow 1px;"></td>';
                                data += '<td class="child_border" width="80px" style="border:solid yellow 1px;"></td>';
                                data += '<td class="child_border" width="80px" style="border:solid yellow 1px;"></td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">From: '+obj.CAI_User_PK+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_filename+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_description+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_Accounts+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.Action_Items_name+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Assign to: '+obj.CAI_Assign_to+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;"><b>'+obj.CIA_progress+'</b></td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Rendered: '+obj.CAI_Rendered_Minutes+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Start: '+obj.CAI_Action_date+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Due: '+obj.CAI_Action_due_date+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_files+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.comment+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.action_btn+'</td>';
                                $('#sub_five_'+obj.CAI_id).empty();
                            $('#sub_five_'+obj.CAI_id).append(data);
                             $('#modalGet_child5b').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // Update child 6 Item
            function onclick_6(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?getId_6="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_child6 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_child6").on('submit',(function(e) {
                e.preventDefault();
                 var ids = <?= $_GET['view_id'] ?>;
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSubmit_6',true);

                var l = Ladda.create(document.querySelector('#btnSubmit_6'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            
                            var obj = jQuery.parseJSON(response);
                                var data = '<td class="child_border" width="80px" style="border:solid yellow 1px;">'+obj.CAI_id+'</td>';
                                data += '<td class="child_border" width="80px" style="border:solid yellow 1px;"></td>';
                                data += '<td class="child_border" width="80px" style="border:solid yellow 1px;"></td>';
                                data += '<td class="child_border" width="80px" style="border:solid yellow 1px;"></td>';
                                data += '<td class="child_border" width="80px" style="border:solid yellow 1px;"></td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">From: '+obj.CAI_User_PK+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_filename+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_description+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_files+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.CAI_Accounts+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.Action_Items_name+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Assign to: '+obj.CAI_Assign_to+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;"><b>'+obj.CIA_progress+'</b></td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Rendered: '+obj.CAI_Rendered_Minutes+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Start: '+obj.CAI_Action_date+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">Due: '+obj.CAI_Action_due_date+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.comment+'</td>';
                                data += '<td class="child_2" style="border:solid yellow 1px;">'+obj.action_btn+'</td>';
                                $('#sub_six_'+obj.CAI_id).empty();
                            $('#sub_six_'+obj.CAI_id).append(data);
                             $('#modalGet_child6').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // add new Child 2 function
            function btnNew_History_Child2(id) {
                $.ajax({
                    type: "GET",
                    url: "mypro_function/mypro_action.php?modalAddHistory_Child2b="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetHistory_Child2b .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGetHistory_Child2b").on('submit',(function(e) {
                e.preventDefault();
               var layer_2 = $("#layer_2").val();
               var last_sudId3 = $("#last_sudId3").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_AddChildItem_layer2b',true);

                var l = Ladda.create(document.querySelector('#btnSave_AddChildItem_layer2b'));
                l.start();

                $.ajax({
                    url: "mypro_function/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            if(last_sudId3 == ''){
                                $(response).insertAfter('#sub_two_'+layer_2).parent().parent();}
                            else{
                                $(response).insertAfter('#sub_three_main'+last_sudId3).parent().parent();}
                             $('#modalGetHistory_Child2b').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // add new Child 3 function
            function btnNew_History_Child3(id) {
                $.ajax({
                    type: "GET",
                    url: "mypro_function/mypro_action.php?modalAddHistory_Child3b="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetHistory_Child3b .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGetHistory_Child3b").on('submit',(function(e) {
                e.preventDefault();
               var layer_3 = $("#layer_3").val();
               var last_sudId4 = $("#last_sudId4").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_AddChildItem_layer3b',true);

                var l = Ladda.create(document.querySelector('#btnSave_AddChildItem_layer3b'));
                l.start();

                $.ajax({
                    url: "mypro_function/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            if(last_sudId4 == ''){
                                $(response).insertAfter('#sub_three_main'+layer_3).parent().parent();}
                            else{
                                $(response).insertAfter('#sub_four_'+last_sudId4).parent().parent();}
                             $('#modalGetHistory_Child3b').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // add new Child 4 function
            function btnNew_History_Child4(id) {
                $.ajax({
                    type: "GET",
                    url: "mypro_function/mypro_action.php?modalAddHistory_Child4b="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetHistory_Child4b .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGetHistory_Child4b").on('submit',(function(e) {
                e.preventDefault();
               var layer_4 = $("#layer_4").val();
               var last_sudId5 = $("#last_sudId5").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_AddChildItem_layer4b',true);

                var l = Ladda.create(document.querySelector('#btnSave_AddChildItem_layer4b'));
                l.start();

                $.ajax({
                    url: "mypro_function/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            if(last_sudId5 == ''){
                                $(response).insertAfter('#sub_four_'+layer_4).parent().parent();}
                            else{
                                $(response).insertAfter('#sub_five_'+last_sudId5).parent().parent();}
                             $('#modalGetHistory_Child4b').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // add new Child 4 function
            function btnNew_History_Child5(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?modalAddHistory_Child5="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetHistory_Child5 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGetHistory_Child5").on('submit',(function(e) {
                e.preventDefault();
               var layer_5 = $("#layer_5").val();
               var last_sudId6 = $("#last_sudId6").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_AddChildItem_layer5',true);

                var l = Ladda.create(document.querySelector('#btnSave_AddChildItem_layer5'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            if(last_sudId6 == ''){
                                $(response).insertAfter('#sub_five_'+layer_5).parent().parent();}
                            else{
                                $(response).insertAfter('#sub_six_'+last_sudId6).parent().parent();}
                             $('#modalGetHistory_Child5').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            // Comments status
            function btn_Comments_filter(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?modal_Comments_filter="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_Comments_filter .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_Comments_filter").on('submit',(function(e) {
                
                e.preventDefault();
                 var comment_filter_2 = $("#comment_filter_2").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Comments_filter',true);

                var l = Ladda.create(document.querySelector('#btnSave_Comments_filter'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            $('#shortcut_'+comment_filter_2).empty();
                            $('#shortcut_'+comment_filter_2).append(response);
                             $('#modalGet_Comments_filter').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            // Comments status
            function btn_Comments(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?modal_Comments="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_Comments .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_Comments").on('submit',(function(e) {
                
                e.preventDefault();
                 var comment_2 = $("#comment_2").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Comments',true);

                var l = Ladda.create(document.querySelector('#btnSave_Comments'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            $('#sub_two_'+comment_2).empty();
                            $('#sub_two_'+comment_2).append(response);
                             $('#modalGet_Comments').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            // Comments status 3
            function btn_Comments3(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?modal_Comments3="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_Comments3 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_Comments3").on('submit',(function(e) {
                
                e.preventDefault();
                 var comment_3 = $("#comment_3").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Comments3',true);

                var l = Ladda.create(document.querySelector('#btnSave_Comments3'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            $('#sub_three_main'+comment_3).empty();
                            $('#sub_three_main'+comment_3).append(response);
                             $('#modalGet_Comments3').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // Comments status 4
            function btn_Comments4(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?modal_Comments4="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_Comments4 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_Comments4").on('submit',(function(e) {
                
                e.preventDefault();
                 var comment_4 = $("#comment_4").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Comments4',true);

                var l = Ladda.create(document.querySelector('#btnSave_Comments4'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            $('#sub_four_'+comment_4).empty();
                            $('#sub_four_'+comment_4).append(response);
                             $('#modalGet_Comments4').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // Comments status 5
            function btn_Comments5(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?modal_Comments5="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_Comments5 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_Comments5").on('submit',(function(e) {
                
                e.preventDefault();
                 var comment_5 = $("#comment_5").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Comments5',true);

                var l = Ladda.create(document.querySelector('#btnSave_Comments5'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            $('#sub_five_'+comment_5).empty();
                            $('#sub_five_'+comment_5).append(response);
                             $('#modalGet_Comments5').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // Comments status 6
            function btn_Comments6(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/mypro_action.php?modal_Comments6="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_Comments6 .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_Comments6").on('submit',(function(e) {
                
                e.preventDefault();
                 var comment_6 = $("#comment_6").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Comments6',true);

                var l = Ladda.create(document.querySelector('#btnSave_Comments6'));
                l.start();

                $.ajax({
                    url: "MyPro_Folders/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            $('#sub_six_'+comment_6).empty();
                            $('#sub_six_'+comment_6).append(response);
                             $('#modalGet_Comments6').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // Not Started
            function filter_notstarted(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/fetch_task.php?modal_filter_status="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_filter_notstarted .modal-body").html(data);
                        $(".modalForm").validate();
                        
            			$('#tableData22').DataTable({
            		        dom: 'lBfrtip',
            		        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
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
                    }
                });
            }
            
            // inprogress
            function filter_progress(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/fetch_task.php?modal_filter_status_progress="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_filter_progress .modal-body").html(data);
                        $(".modalForm").validate();
                        
            			$('#sample_11').DataTable({
            		        dom: 'lBfrtip',
            		        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
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
                    }
                });
            }
            
            // Completed
            function filter_completed(id) {
                $.ajax({
                    type: "GET",
                    url: "MyPro_Folders/fetch_task.php?modal_filter_status_completed="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_filter_completed .modal-body").html(data);
                        $(".modalForm").validate();
                        
                        
            			$('#sample_44').DataTable({
            		        dom: 'lBfrtip',
            		        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
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
                    }
                });
            }
            
            // File Section
            function get_myTask(users_id,h_id) {
                // alert(h_id);
                $.ajax({
                    type: "GET",
                    url: "mypro_function/search_task.php?post_id="+users_id+"&h_id="+h_id,
                    dataType: "html",
                    success: function(data){
                      $("#hide_box tr").empty();
                      $("#main_ > tbody").empty();
                        $("#my_task_"+h_id).html(data);
                        
                    }
                });
            }
        </script>
    </body>
</html>