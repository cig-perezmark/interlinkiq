<?php 
$date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
$today_tx = $date_default_tx->format('Y-m-d');
    $title = "MyPro";
    $site = "todoList";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php');
?>

<div class="row">
    <div class="col-md-12">
        <div class="todo-ui">
            <!-- BEGIN TODO SIDEBAR -->
            <div class="todo-sidebar">
                
                <!--your projects-->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption" data-toggle="collapse" data-target=".YOUR">
                            <span class="caption-subject font-blue-sharp bold uppercase">PROJECTS</span>
                            <span class="caption-helper visible-sm-inline-block visible-xs-inline-block">click to view project list</span>
                        </div>
                        <div class="actions">
                            <div class="btn-group">
                                <a class="btn blue btn-circle btn-outline btn-sm todo-projects-config" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-settings"></i> &nbsp;
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:;"> New Project </a>
                                    </li>
                                    <li class="divider"> </li>
                                    <li>
                                        <a href="javascript:;"> Pending
                                            <span class="badge badge-danger"> 4 </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;"> Completed
                                            <span class="badge badge-success"> 12 </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;"> Overdue
                                            <span class="badge badge-warning"> 9 </span>
                                        </a>
                                    </li>
                                    <li class="divider"> </li>
                                    <li>
                                        <a href="javascript:;"> Archived Projects </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body todo-project-list-content YOUR">
                        <!--<div class="scroller">-->
                        <div class="scroller" style="height:25vh;" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
                            <div class="todo-project-list" id="your_projects">
                            </div>
                        </div>
                        <!--</div>-->
                    </div>
                </div>
                
                <!--collab projects-->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption" data-toggle="collapse" data-target=".COLLAB">
                            <span class="caption-subject font-blue-sharp bold uppercase">COLLABORATOR</span>
                        </div>
                    </div>
                    <div class="portlet-body todo-project-list-content COLLAB">
                        <!--<div class="scroller">-->
                        <div class="scroller" style="height:25vh;" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
                            <div class="todo-project-list" id="collab_projects">
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
                            <span class="caption-helper">Your Tasks:</span> &nbsp;
                            <span class="caption-subject font-blue-sharp bold uppercase">Dashboard</span>
                        </div>
                        
                        <!--<div class="actions">-->
                        <!--    <div class="btn-group">-->
                        <!--        <a class="btn blue btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> MANAGE-->
                        <!--            <i class="fa fa-angle-down"></i>-->
                        <!--        </a>-->
                        <!--        <ul class="dropdown-menu pull-right">-->
                        <!--            <li>-->
                        <!--                <a href="javascript:;"> New Task </a>-->
                        <!--            </li>-->
                        <!--            <li class="divider"> </li>-->
                        <!--            <li>-->
                        <!--                <a href="javascript:;"> Pending-->
                        <!--                    <span class="badge badge-danger"> 4 </span>-->
                        <!--                </a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="javascript:;"> Completed-->
                        <!--                    <span class="badge badge-success"> 12 </span>-->
                        <!--                </a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="javascript:;"> Overdue-->
                        <!--                    <span class="badge badge-warning"> 9 </span>-->
                        <!--                </a>-->
                        <!--            </li>-->
                        <!--            <li class="divider"> </li>-->
                        <!--            <li>-->
                        <!--                <a href="javascript:;"> Delete Project </a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                    <!-- end PROJECT HEAD -->
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-5 col-sm-4">
                                <!--default display-->
        			            <div class="scroller" style="height:60vh;" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
                                    <div class="todo-tasklist" id="your_task">
                                    </div>
                                </div>
                            </div>
                            <div class="todo-tasklist-devider"> </div>
                                <div class="col-md-7 col-sm-8">
                                    <!-- TASK HEAD -->
                                    <form action="#" class="form-horizontal">
                                        <div class="form">
                                                <div class="row" id="sortable_portlets">
                                                </div>
                                            </div>
                                    </form>
                                </div> 
                        </div>
                    </div>
                </div>
            </div>
            <!-- END TODO CONTENT -->
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
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
<!--todo script-->
<script src="assets/apps/scripts/todo-2.min.js" type="text/javascript"></script>
<script src="assets/pages/scripts/portlet-draggable.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
    getData('get_default');
    getData('get_your_project');
    getData('get_collab_project');
});

function getData(key){
    $.ajax({
       url:'todolist_folder/fetch_account.php',
       method: 'POST',
       dataType: 'text',
       data: {
           key: key
       }, success: function (response) {
           if (key == 'get_default'){
               $('#your_task').append(response);
           }
           else if (key == 'get_your_project'){
               $('#your_projects').append(response);
           }
           else if (key == 'get_collab_project'){
               $('#collab_projects').append(response);
           }
       }
    });
}

//view todo
$(document).on('click', '#view_task', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "todolist_folder/fetch_todo_list.php?get_data="+id,
        dataType: "html",
        success: function(data){
            $("#sortable_portlets").empty();
            $("#sortable_portlets").append(data);
        }
    });
});
</script>
<style>
/*.todo-project-list-content{*/
/*    max-height:32vh;*/
/*    overflow-y:hidden;*/
/*}*/
/*.todo-project-list-content:hover{*/
/*    max-height:32vh;*/
/*    overflow-y:scroll;*/
/*}*/
#sortable_portlets{
    max-height:65vh;
    overflow-y:scroll;
}
/*.todo-tasklist:hover{*/
/*    max-height:70vh;*/
/*    overflow-y:scroll;*/
/*}*/
/*.a{*/
/*    text-decoration: none;*/
/*}*/
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
