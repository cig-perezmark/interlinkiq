<?php 
$date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
$today_tx = $date_default_tx->format('Y-m-d');
    $title = "Candidate Recruiting Management";
    $site = "candidate_recruiting_management";
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
.no-border{
    border:none;
}
.bottom-border{
    border:none;
    border-bottom:solid #ccc 1px;
}
.requirements_box{
    overflow:scroll;
    height:68vh;
}
.todo-sidebar{
    min-width:25%;
}
</style>

<!--START MAIN ROW-->
<div class="row">
    <div class="col-md-12">
        <div class="todo-ui">
            <!-- BEGIN TODO SIDEBAR -->
            <div class="todo-sidebar">
                
                <!--your projects-->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption" data-toggle="collapse" data-target=".YOUR">
                            <span class="caption-subject font-blue-sharp bold uppercase">Category</span>
                            <span class="caption-helper visible-sm-inline-block visible-xs-inline-block">click to add Category</span>
                        </div>
                        <div class="actions">
                            <div class="btn-group">
                                <a class="btn blue btn-xs todo-projects-config" href="javascript:;" >
                                    Add
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body todo-project-list-content YOUR">
                        <!--<div class="scroller">-->
                        <div class="scroller" style="height:25vh;" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
                            <div class="todo-project-list">
                              <?php
                                    $query_subs = mysqli_query($conn,"select * from tbl_hr_crm_category where cat_ownedby = '$current_userEmployerID' order by category_name ASC");
                                    foreach($query_subs as $row_subs){?>
                                    <div class="form-group">
                                        <br>
                                            <div class="col-md-10">
                                                <label class="category_label<?= $row_subs['category_pk'];?>">
                                                    <input type="checkbox" onclick="get_category(this)" value="<?= $row_subs['category_pk'];?>">
                                                    <?= $row_subs['category_name'];?>
                                                </label>
                                            </div>
                                            <div class="col-md-2">
                                                <a class="btn green btn-xs btn-outline btnView_payment" data-toggle="modal" href="#modalGet_payment" data-id="<?php echo $row_subs["category_pk"]; ?>">
                                                    <i class="icon-pencil"></i>
                                                </a>
                                            </div>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                        <!--</div>-->
                    </div>
                </div>
            </div>
            <!-- END TODO SIDEBAR -->
            <!-- BEGIN TODO CONTENT -->
            <div class="todo-content">
                <div class="portlet light ">
                    <!-- PROJECT HEAD -->
                    <div class="portlet-title">
                        
                        <div class="tools">
                            <a href="" class="collapse"> </a>
                            <a href="" class="fullscreen"> </a>
                        </div>
                        <div class="caption">
                            <i class="icon-bar-chart font-blue-sharp hide"></i>
                            <span class="caption-subject font-blue-sharp bold uppercase">Dashboard</span>
                        </div>
                        <div class="caption">
                            &nbsp;&nbsp;&nbsp;
                            <i class="icon-bar-chart font-blue-sharp hide"></i>
                            <span class="caption-helper"><a class="btn dark btn-outline btn-xs border-bottom"><b>Jobs Post ( <i style="color:blue;" id="count_jobs"></i> )</b></a></span> 
                            <span class="caption-helper"><a class="btn dark btn-outline btn-xs border-bottom"><b>Candidates Available ( <i style="color:blue;" id="available_candidate"></i> )</b></a></span> 
                        </div>
                    </div>
                    <!-- end PROJECT HEAD -->
                    <div class="portlet-body">
                        <div class="tabbable tabbable-tabdrop">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tabJobs" data-toggle="tab">Jobs</a>
                                </li>
                                <li>
                                    <a href="#tabCandidates" data-toggle="tab" onclick="candidate_btn();">Candidates</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabJobs"> 
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input class="form-control data_Jobs_search" placeholder="Search">
                                        </div>
                                        <div class="col-md-2">
                                            <div class="btn-group">
                                                <a class="btn dark btn-outline btn btn-sm" href="#modalAdd_details" data-toggle="modal" class="btn btn-outline dark btn-sm"  data-close-others="true"> 
                                                    Add New
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-scrollable">
                                        <table class="table table-bordered" id="table_data_tr">
                                            <thead>
                                                <tr>
                                                    <th>Jobs Title</th>
                                                    <th>Candidates</th>
                                                    <th>Category</th>
                                                    <th>Jobs Status</th>
                                                    <th width="10px">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="jobs_data">
                                            </tbody>
                                            <tbody class="jobs_data2">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabCandidates">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input class="form-control data_candidate_search" placeholder="Search">
                                        </div>
                                        <div class="col-md-2">
                                            <div class="btn-group">
                                                <a class="btn dark btn-outline btn btn-sm" href="#modalAdd_candidate" data-toggle="modal" class="btn btn-outline dark btn-sm"  data-close-others="true"> 
                                                    Add New
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-scrollable">
                                        <table class="table table-bordered" id="table_candidate_tr">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                    <th>Invitation Date</th>
                                                    <th width="10px">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="candidate_data">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- END TODO CONTENT -->
        </div>
    </div>
</div>
<!--modal here-->
<?php include "candidate_recruitment_folder/modals.php"; ?>
<!--modal end-->
<!-- END MAIN ROW -->
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
 
<script>
//jobs search
$(document).ready(function(){
    $('.data_Jobs_search').keyup(function(){
		search_table($(this).val());
	});
	function search_table(value){
		$('#table_data_tr tr').each(function(){
			var found = 'false';
			$(this).each(function(){
				if($(this).text().toLowerCase().indexOf(value.toLowerCase())>=0)
				{
					found = 'true';
				}
			});
			if(found =='true')
			{
				$(this).show();
			}
			else{
				$(this).hide();
			}
		});
	}
});
//candidate search
$(document).ready(function(){
    $('.data_candidate_search').keyup(function(){
		search_table($(this).val());
	});
	function search_table(value){
		$('#table_candidate_tr tr').each(function(){
			var found = 'false';
			$(this).each(function(){
				if($(this).text().toLowerCase().indexOf(value.toLowerCase())>=0)
				{
					found = 'true';
				}
			});
			if(found =='true')
			{
				$(this).show();
			}
			else{
				$(this).hide();
			}
		});
	}
});

$(document).ready(function(){
    getData('get_default');
    getData('get_count_jobs');
    getData('get_count_candidates');
});

function getData(key){
    $.ajax({
       url:'candidate_recruitment_folder/fetch_category.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
          if (key == 'get_default'){
              $('.jobs_data').append(response);
          }
          else if (key == 'get_count_jobs'){
              $('#count_jobs').append(response);
          }
          else if (key == 'get_count_candidates'){
              $('#available_candidate').append(response);
          }
       }
    });
}

// get_payment
function get_category(val){
    if(val.checked == true){
         $.ajax({  
            url:"candidate_recruitment_folder/fetch_jobs.php",  
            method:"POST",  
            data:{ val:val.value},  
            success:function(data){
                // $(".category_label"+val.value).css({"color":"green","text-decoration": "line-through"});
                 $('.jobs_data').empty();  
                $('.jobs_data2').append(data);  
            }  
       }); 
    }
    else{
        // $(".category_label"+val.value).css({"color":"","text-decoration": "none"});
       $('.data_row'+val.value).remove();
    }
} 
// candidates
function candidate_btn(id) {
    $.ajax({
        type: "GET",
        url: "candidate_recruitment_folder/function.php?get_candidate="+id,
        dataType: "html",
        success: function(data){
            $("#candidate_data").html(data);
        }
    });
}
// new added
$(".modalAdd_details").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnNew_added',true);

    var l = Ladda.create(document.querySelector('#btnNew_added'));
    l.start();

    $.ajax({
        url: "candidate_recruitment_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Sucessfully Save!";
                $('.jobs_data').append(response);
                 $('#modalAdd_details').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));

//update Jobs
$(document).on('click', '#update_status', function(){
    var ids = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "candidate_recruitment_folder/function.php?GetAI="+ids,
        dataType: "html",
        success: function(data){
            $("#modal_update_status .modal-body").html(data);
            $(".modalForm").validate();
            selectMulti();
        }
    });
});
$(".modal_update_status").on('submit',(function(e) {
    e.preventDefault();
     var job_id = $("#job_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_status',true);

    var l = Ladda.create(document.querySelector('#btnSave_status'));
    l.start();

    $.ajax({
        url: "candidate_recruitment_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Sucessfully Save!";
                    $('#data_'+job_id).empty();
                    $('#data_'+job_id).append(response);
                 $('#modal_update_status').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));


// new added candidates
$(".modalAdd_candidate").on('submit',(function(e) {
    e.preventDefault();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnNew_candidate',true);

    var l = Ladda.create(document.querySelector('#btnNew_candidate'));
    l.start();

    $.ajax({
        url: "candidate_recruitment_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Sucessfully Save!";
                $('#candidate_data').append(response);
                 $('#modalAdd_candidate').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();
            bootstrapGrowl(msg);
        }
    });
}));
//update candidates
$(document).on('click', '#update_candidate', function(){
    var ids = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "candidate_recruitment_folder/function.php?GetCandidates="+ids,
        dataType: "html",
        success: function(data){
            $("#modal_update_candidates .modal-body").html(data);
            $(".modalForm").validate();
            selectMulti();
        }
    });
});
$(".modal_update_candidates").on('submit',(function(e) {
    e.preventDefault();
     var candidates_update_id = $("#candidates_update_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnSave_candidate',true);

    var l = Ladda.create(document.querySelector('#btnSave_candidate'));
    l.start();

    $.ajax({
        url: "candidate_recruitment_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Sucessfully Save!";
                    $('#row1_'+candidates_update_id).empty();
                    $('#row1_'+candidates_update_id).append(response);
                 $('#modal_update_candidates').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));

//delete candidates
$(document).on('click', '#delete_candidate', function(){
    var ids = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "candidate_recruitment_folder/function.php?GetCandidates_delete="+ids,
        dataType: "html",
        success: function(data){
            $("#modal_delete_candidates .modal-body").html(data);
            $(".modalForm").validate();
            selectMulti();
        }
    });
});
$(".modal_delete_candidates").on('submit',(function(e) {
    e.preventDefault();
     var candidates_delete_id = $("#candidates_delete_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;
        
    var formData = new FormData(this);
    formData.append('btnDelete_candidate',true);

    var l = Ladda.create(document.querySelector('#btnDelete_candidate'));
    l.start();

    $.ajax({
        url: "candidate_recruitment_folder/function.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData:false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                console.log(response);
                msg = "Sucessfully Deleted!";
                    $('#row1_'+candidates_delete_id).empty();
                    $('#modal_delete_candidates').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
</script>
<style>
.border-bottom{
    border-top:none;
    border-left:none;
    border-right:none;
}

/*end meeting minutes*/
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
        </style>
    </body>
</html>