<?php 
$date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
$today_tx = $date_default_tx->format('Y-m-d');
    $title = "Project Management Services";
    $site = "";
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
</style>


                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-users font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Executive Management Services
                                        </span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="#modalnew" data-toggle="modal"> Actions
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                     <!--<span class="loader"><span class="loader-inner"></span></span>-->
                                    <br>
                                        <!-- BEGIN HEADER SEARCH BOX -->
                                            <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search..." id="data_search">
                                                    <span class="input-group-btn">
                                                        <a href="javascript:;" class="btn submit">
                                                            <i class="icon-magnifier"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                            <!-- END HEADER SEARCH BOX -->
                                          <div class="table-scrollable"> 
                                            <table class="table table-striped table-bordered table-hover dt-responsive" style="table-layout: fixed; width: 100%" id="data_reload">
                                                	<thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Services</th>
                                                            <th>Category</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                     <tbody id="searched_data"></tbody>
                                                    <tbody id="services"></tbody>
                                            </table>
                                        </div>
                                </div>
                            </div>
                            <!-- END BORDERED TABLE PORTLET-->
                        </div>

                        
                      
                         <!-- / START MODAL AREA -->
                      <!-- modalGetHistory_Child add Child layer -->
                        <div class="modal fade" id="modalnew" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalnew">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Services</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Service</label>
                                                    <input class="form-control" name="services_name" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Category</label>
                                                    <select class="form-control" name="services_category" required>
                                                        <?php
                                                        $query = "SELECT * FROM tbl_Project_Category order by category_name ASC";
                                                         $result = mysqli_query($conn, $query);
                                                         if(mysqli_num_rows($result) > 0){
                                                             while($row = mysqli_fetch_assoc($result)) {?>
                                                                 <option value="<?php echo $row['category_name']; ?>"><?php echo $row['category_name']; ?></option>
                                                            <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave" id="btnSave" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!--update -->
                            <div class="modal fade" id="modalGet" tabindex="-1" role="basic" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="post" class="form-horizontal modalForm modalGet">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h4 class="modal-title">Update Service</h4>
                                            </div>
                                            <div class="modal-body"></div>
                                            <div class="modal-footer">
                                                <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                                <button type="submit" class="btn green ladda-button" name="btnSave_update" id="btnSave_update" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

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
        $(document).ready(function () {
            $('#tableData2').DataTable();
             getData('getServices');
        });
       
        //getDat CRM
        $(document).ready(function(){
            $("#data_search").keyup(function(){
                var search = $(this).val();
                if(search != ""){
                    $.ajax({
                        url:'Executive_Assistant/fetch_services.php',
                        method: 'POST',
                        data: {search:search},
                        success:function(data){
                            $("#searched_data").html(data);
                        }
                    });
                }else{
                    $("#searched_data").css("display","none");
                }
            });
          
           //submit data
           $(".modalnew").on('submit',(function(e) {
                e.preventDefault();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave',true);

                var l = Ladda.create(document.querySelector('#btnSave'));
                l.start();

                $.ajax({
                    url: "Executive_Assistant/add_services.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            location.reload();
                             $('#modalnew').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        bootstrapGrowl(msg);
                    }
                });
            }));
        });
        
        //fetch data
        function getData(key) {
            $.ajax({
               url:'Executive_Assistant/fetch_services.php',
               method: 'POST',
               dataType: 'text',
               data: {
                   key: key
               }, success: function (response) {
                   if (key == 'getServices')
                       $('#services').append(response);
               }
            });
        }
        
        // Update
            function btnUpdate(id) {
                $.ajax({
                    type: "GET",
                    url: "Executive_Assistant/fetch_services.php?modal_update="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet").on('submit',(function(e) {
                e.preventDefault();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_update',true);

                var l = Ladda.create(document.querySelector('#btnSave_update'));
                l.start();

                $.ajax({
                    url: "Executive_Assistant/fetch_services.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                             $('#modalGet').modal('hide');
                             location.reload();
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