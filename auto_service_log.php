<?php 
    $title = "Auto Service Log";
    $site = "auto_service_log";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
    include_once ('task_service_log/private/connection.php');
?>
 
  <!-- END PAGE HEADER-->
  <div class="row">
    <div class="col-md-12">
      <div class="portlet light">
        <div class="portlet-title tabbable-line">
          <div class="caption caption-md">
            <i class="icon-globe theme-font hide"></i>
            <span class="caption-subject font-blue-madison bold uppercase">Auto Services Time Log (<i style="color:gray;font-size:10px;">kindly review your time before uploading to services..</i>)</span>
          </div>
          <ul class="nav nav-tabs">
            <li class="active">
              <a href="#SERVICES" data-toggle="tab">Services</a>
            </li>
          </ul>
        </div>
        <div class="portlet-body">
          <div class="tab-content">
            <div class="tab-pane active" id="SERVICES">
              <div class="">
                <h3 style="margin: 0 0 1rem 0;"> Total Action:<span id="total_pending_count" class="circle"></span> Total Time(hours):<span class="circle" id="total_time_hours"></span></h3>
                <div class="alert alert-success alert-dismissable" id="advSearchAlert" style="display: none;">
                  <button type="button" class="close" aria-hidden="true"></button>
                  <strong>
                    <i class="fa fa-info-circle"
                      style="margin-right: .2rem; border-right: 1px solid inherit; font-size: 1.5rem; align-self: center;"></i>
                    Advance searching
                  </strong>
                  <br>
                  <span style="font-size: .9em; margin-top: .5rem;">
                    <span class="_stmt"></span>
                  </span>
                </div>
              </div>
              <div class="d-flex align-items-right" style="margin: 0 0 2rem 0; gap: 1rem;">
              
                <a data-toggle="modal" href="" class="btn blue">
                  <i class="fa fa-upload"></i>
                  Upload All
                </a><i style="color:lightgray;">Upload All button function is still in progress please upload your service log by pressing the individual upload button for now..</i>
              </div>
                <!--START CAPTURED LOGS DISPLAY-->
                <div class="container" style="width:100%;">
                    <div id="table" class="table-responsive table-editable">
                        <table id="pendinglogs_display"class="table">
                          <tr>
                            <th>Description</th>
                            <th>Action</th>
                            <th>Comment</th>
                            <th>Account</th>
                            <th>Date</th>
                            <th>Time(min)</th>
                            <th></th>
                          </tr>
   
                

                          <!--$query_autologs = "SELECT * tbl_service_logs_draft";-->

                                            <?php
                                    $actions = $con->query("SELECT * FROM tbl_service_logs_draft where user_id = $current_userID AND status is NULL ORDER BY task_date DESC ");
                                    if(mysqli_num_rows($actions) > 0) {
                                        while($row = $actions->fetch_assoc()) {
                                        ?>
                                           
                                                <tr id="<?php echo $row['task_id']."rowid"; ?>">
                                                <td class="task_description" rowid="<?php echo $row['task_id']; ?>" contenteditable="true"><i style='display:none !important;' id="<?php echo $row['task_id']."like"; ?>" class="fa fa-thumbs-up fa-flip-horizontal"></i>&nbsp;&nbsp;<?php echo $row['description']; ?></td>
                                                <td contenteditable="false"><?php echo $row['action']; ?></td>
                                                <td rowid="<?php echo $row['task_id']; ?>" contenteditable="true" class="task_comment"><?php echo $row['comment']; ?></td>
                                                <td contenteditable="false"><?php echo $row['account']; ?></td>
                                                <td contenteditable="false"><?php echo $row['task_date']; ?></td>
                                                <td rowid="<?php echo $row['task_id']; ?>" class="task_minute" contenteditable="true"><?php echo $row['minute']; ?></td>
                                                <td> <button class="btn-success upload_btn" id="<?php echo $row['task_id']; ?>" rowid="<?php echo $row['task_id']; ?>" indiminutes="<?php echo $row['minute']; ?>" ><i class="fa fa-upload"></i>&nbsp;Upload</button></td>
                                                <td> <button class="btn-danger delete_btn" delete_id="<?php echo $row['task_id']; ?>" rowid="<?php echo $row['task_id']; ?>" indiminutes="<?php echo $row['minute']; ?>" ><i class="fa fa-trash"></i>&nbsp;Delete</button></td>
                                               </tr>
                                            
                                        
                                        <?php
                                        }
                                    }
                                    else {
                                        echo "<option><i>No items found.</i></option>";
                                    }
                                ?>
                            
                          
                          
      
                        
                        </table>
                    </div>
                </div>
                
                
             <!--END CAPTURED LOG DISPLAY-->
            </div>
            
            
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END CONTENT BODY -->
<?php if($_COOKIE['ID'] == 34 || $_COOKIE['ID'] == 189): ?>
  <!--  -->
  <div class="modal fade in" id="VAServiceLogsViewModal" tabindex="-1" role="dialog" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">VA Services Logs View</h4>
        </div>
        <div class="modal-body">
          <div class="VAInfoDisplay" style="margin: 1rem 0 3rem 0;"></div>
          <table id="VAServiceLogsViewDatatable"
            class="table table-striped table-bordered order-column dataTable no-footer">
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn green closeModal" data-dismiss="modal" aria-hidden="true">Close</button>
          <button type="button" class="btn blue downloadLogs">Download CSV File</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<?php endif; ?>
  <!-- advance search modal -->
  <div class="modal fade bs-modal-sm" id="advSearchModal" tabindex="-1" role="dialog" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog modal-sm">
      <form role="form" style="border-radius: 0;" class="modal-content" id="advSearchForm">
        <div class="modal-header" style="border-bottom: none;">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Advanced Search</h4>
        </div>
        <div class="modal-body" style="padding-top: 0; padding-bottom: 0;">
          <div class="form-body">
            <div class="font-grey-cascade" style="font-size: .9em; margin: 0 0 .5rem 0;">Filter by:</div>
            <div class="form-group">
              <label for="">Keyword</label>
              <div class="input-icon right">
                <i class="fa fa-search tooltips" data-original-title="Please enter a keyword" data-container="body"></i>
                <input type="text" class="form-control" name="keyword" autocomplete="false">
              </div>
            </div>
            <div class="form-group">
              <label for="">Account</label>
              <div>
                <select class="mt-multiselect btn btn-default" id="ASAccountMS" name="accounts[]"
                  multiple="multiple"></select>
              </div>
            </div>
            <div class="form-group">
              <label for="">Action</label>
              <div>
                <select class="mt-multiselect btn btn-default" name="actions[]" id="ASActionMS"
                  multiple="multiple"></select>
              </div>
            </div>
            <div class="font-grey-cascade" style="font-size: .9em; margin: 0 0 .5rem 0;">
              Filter by date range:
            </div>
            <div class="advDateRangeSearch">
              <div class="form-group">
                <label for="startDateADVS">Start date</label>
                <input type="date" id="startDateADVS" class="form-control " name="startDate">
              </div>
              <div class="form-group">
                <label for="endDateADVS">End date</label>
                <input type="date" id="endDateADVS" class="form-control" name="endDate">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-top: none;">
          <button type="submit" class="btn green">Search</button>
        </div>
      </form>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <!-- new task modal -->
  <div class="modal fade in" id="newTask" tabindex="-1" role="newTask" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">New Task</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form" id="task_form">
            <div class="form-body">
              <input type="hidden" name="_token"
                value="<?= isset($_COOKIE['ID']) ? $_COOKIE['ID'] : 'none' ?>">
              <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                Please provide the complete information of the task.
              </div>
              <div class="alert alert-success display-hide">
                <button class="close" data-close="alert"></button>
                Data submitted successfuly!
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Task Owner</label>
                <div class="col-md-8">
                  <p class="form-control-static" style="font-weight: 600;">
                    <?php   
                    
                    $i = 1;
                    $users = $_COOKIE['ID'];
                    $query = "SELECT * from tbl_user where ID = $users ";
                    $result = mysqli_query($conn, $query);
                                                
                    while($row = mysqli_fetch_array($result))
                    {?>
                        <?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?>
                    <?php } ?>
                    </p>
                </div>
              </div>
              <div class="form-group">
                <label for="task_description" class="col-md-3 control-label">Description</label>
                <div class="col-md-8">
                  <textarea class="form-control" name="description" id="task_description" rows="3"
                    placeholder="Describe your task"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="task_action" class="col-md-3 control-label">Action</label>
                <div class="col-md-8">
                  <select class="form-control" name="action" id="task_action">
                    <?php
                                        $actions = $con->query("SELECT * FROM tbl_service_logs_actions");
                                        if(mysqli_num_rows($actions) > 0) {
                                            while($row = $actions->fetch_assoc()) {
                                                echo "<option value='{$row['name']}'>{$row['name']}</option>";
                                            }
                                        }
                                        else {
                                            echo "<option><i>No items found.</i></option>";
                                        }
                                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="task_comment" class="col-md-3 control-label">Comment</label>
                <div class="col-md-8">
                  <textarea class="form-control" name="comment" id="task_comment" placeholder="Add comment"
                    rows="3"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="task_account" class="col-md-3 control-label">Account</label>
                <div class="col-md-8">
                  <select class="form-control" name="account" id="task_account">
                    <?php
                        $accounts = $con->query("SELECT * FROM tbl_service_logs_accounts");
                        if(mysqli_num_rows($accounts) > 0) {
                            while($row = $accounts->fetch_assoc()) {
                                echo "<option value='{$row['name']}'>{$row['name']}</option>";
                            }
                        }
                        else {
                            echo "<option><i>No items found.</i></option>";
                        }
                                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="taskdate" class="col-md-3 control-label">Task Date</label>
                <div class="col-md-8">
                  <input class="form-control" type="date" name="task_date" id="taskdate">
                </div>
              </div>
              <div class="form-group">
                <label for="task_minute" class="col-md-3 control-label">Minute</label>
                <div class="col-md-8">
                  <input class="form-control" name="minute" id="task_minute" type="number" min="0.1" step="0.1">
                </div>
              </div>
              <button type="submit" id="task_submit_btn" style="display: none;"></button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          
          <?php if(!empty($_COOKIE['ID'])){ ?>
          <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
          <button type="button" onclick="$('#task_submit_btn').trigger('click')" class="btn green">Save
            Task</button>
            <?php }else{ ?>
            <i>Your Cookies has expired please relogin. Thank you</i>
          <?php } ?>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- END CONTENT BODY -->
  
  <?php include_once ('footer.php'); ?>
    <script src='assets/global/plugins/jquery-validation/js/jquery.validate.min.js' type='text/javascript'></script>
    <script src='assets/global/plugins/jquery-validation/js/additional-methods.min.js' type='text/javascript'></script>

    <!-- TOASTR SCRIPT PLUGINS -->
    <script src='assets/global/plugins/bootstrap-toastr/toastr.min.js'></script>
    <script src='assets/pages/scripts/ui-toastr.min.js'></script>

    <!-- JQUERY DATATABLES SCRIPT PLUGINS -->
    <script src='assets/global/scripts/datatable.js' type='text/javascript'></script>
    <script src='assets/global/plugins/datatables/datatables.min.js' type='text/javascript'></script>
    <script src='assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js' type='text/javascript'></script>

    <!-- SWEETALERT SCRIPT -->
    <script src='assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js' type='text/javascript'></script>

    <!-- ADVANCE SEARCH FIELD TYPEAHEAD -->
    <script src='assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js' type='text/javascript'></script>

    
    <script src='assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js' type='text/javascript'></script>

    <!-- CUSTOM SCRIPT -->
    <script src='task_service_log/script.js'></script>
    <script src='task_service_log/va_summ_script.js'></script>
        <script>
        </script>
        <style>
            .form-horizontal .checkbox {
  padding: 3px 20px 3px 40px;
}

textarea {
  resize: vertical !important;
  /* text-align: left; */
}

.mm-action-items {
  display: flex;
  align-items: center;
  gap: .7rem;
  margin-top: .75rem;
}

.mm-action-items * {
  font-size: .95em !important;
}

.mm-action-items .btn {
  border-color: transparent !important;
  /* background-color: transparent;
  padding: 0; */
}

#mm-actionItemsList .well {
  position: relative;
}

#mm-actionItemsList .well::before {
  content: '';
  display: inline-block;
  width: 0;
  height: 0;
  position: absolute;
  inset: 0 auto auto 0;
  border-top: 10px solid red;
  border-left: 10px solid red;
  border-right: 10px solid transparent !important;
  border-bottom: 10px solid transparent !important;
}

#mm-actionItemsList .well[data-status="OPEN"]::before {
  border-color: #26C281;
}

#mm-actionItemsList .well[data-status="CLOSED"]::before {
  border-color: #E7505A;
}

#mm-actionItemsList .well[data-status="FOLLOW-UP"]::before {
  border-color: #C49F47;
}

#meetingListTable td:nth-of-type(4) {
  width: 100%;
  max-height: 3rem !important;
  text-overflow: ellipsis;
  /* white-space: nowrap; */
  overflow: hidden;
}
.d-flex {
    display: flex;
    color: inherit;
}

.d-flex.justify-content-between {
    justify-content: space-between;   
}

.d-flex.align-items-center {
    align-items: center;
}

.d-flex.justify-content-end {
    justify-content: end;
}

.d-flex.d-flex.align-items-start {
    align-items: flex-start;
}

.gap-5px {
    gap: 5px;
}

textarea {
    resize: vertical;
}

#tbl-services-time-log thead tr:first-child th {
    position: relative;
    cursor: pointer;
    padding-right: 2.35rem !important;
    -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Old versions of Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none;
}

table th::after {
    content: none !important;
}

.lowercase {
    text-transform: lowercase !important;
}

.widget-thumb-body-stat {
    font-weight: 600;
    margin-top: 5px;
    font-size: 1.95rem !important;
}

.d-inline-block {
    display: inline-block !important;
}

.dateinput {
    position: relative;
}

.dateinput [readonly] {
    background-color: #fff;
    cursor: pointer;
}

.dateinput .date-picker {
    position: absolute;
    inset: 0;
    z-index: 10;
    opacity: 0;
}

.w-200 {
    min-width: 20rem !important;
}

.text-bold {
    font-weight: 700
}

#va_summary_table tbody tr td:not(:first-child) {
    text-align: center !important;
}

table.massUploadTBL * {
    border-color: #2F353B !important;
    transition: all .15s ease-in-out;
    cursor: pointer;
}

table.massUploadTBL td:focus {
    background-color: #798995 !important;
    color: #fff;
    border-radius: 3px !important;
    /* outline: 2px solid #2F353B !important; */
    cursor: text;
}

table.massUploadTBL tr:hover td:focus {
    background-color: #798995 !important;
}

.weekend {
    background-color: #e750500d !important;
    /* font-weight: 600 !important; */
    position: relative;
}

.weekend::after {
    display: inline-block;
    padding: 2px;
    font-size: 0.75rem;
    position: absolute;
    inset: auto 0 0 auto;
    opacity: .75;
    color: #e7505a !important;
}

.weekend.d-6::after {
    content: 'Sun';
}

.weekend.d-5::after {
    content: 'Sat';
}

.noservicelog {
    /* background-color: #e7505005; */
    color: #444;
}

.error-input {
    color: #e7505a !important;
}

tr:hover .error-input {
    color: #e7505a !important;
}

.circle{
    display:inline-block;
    border:solid lightgray 1px;
    width:auto;
    padding:10px;
    height:50px;
    border-radius:25px;
    line-height:30px;
    text-align:center;
}
.fa-thumbs-up{
    display:inline-block;
    color:#DAA520;
    font-size:40px;
    float:left;
    margin-left:-40px;
}
        </style>
    </body>
</html>
<!--Total summary for pending logs-->
<script>
$(document).ready(function(){
    
function refreshcountfigures() {
    
            var TotalValue = 0;
            var FinalTotal = 0;

            $("tr .task_minute").each(function(index,value){
                currentRow = parseFloat($(this).text());
                TotalValue += currentRow
            });
               FinalTotal =  TotalValue/60;
            var numb = FinalTotal;
                numb = numb.toFixed(2);

            document.getElementById('total_time_hours').textContent = numb;
            
            // getting number of rows in a table
            var pending_count = document.getElementById("pendinglogs_display").rows.length -1;
            document.getElementById('total_pending_count').textContent = pending_count;
  
}

refreshcountfigures.call();

           


$(".upload_btn").click(function(){
    var btnid = $(this).attr("id");
    var likeid = $(this).attr("id") + "like";
    var originalrowid =  $(this).attr("rowid") + "rowid";
    var indiminute =0;
    indiminute = $(this).attr("indiminutes")/60;

    
    var currenttotalminute = 0;
    var newtotalminute = 0;
    var newtotalminuterounded = 0;
    var newpendingcount = 0;
    var currentpendingcount = 0;
    
    currentpendingcount = parseFloat(document.getElementById('total_pending_count').textContent);
    
    newpendingcount = currentpendingcount -1;
    currenttotalminute =  parseFloat(document.getElementById('total_time_hours').textContent);
    newtotalminute = currenttotalminute - indiminute;
    newtotalminuterounded = newtotalminute.toFixed(2);
    
    document.getElementById('total_time_hours').textContent = newtotalminuterounded;
    document.getElementById('total_pending_count').textContent = newpendingcount;
    
    
    $('#' + originalrowid).hide(500);
    $('#' + likeid).show();
    
     $.ajax({  
                     url:"uploadindi_auto_service_log.php",  
                     method:"POST",  
                     data:{row_id:btnid},  
                     dataType:"text",  
                     success:function(data)  
                     {  
                         
                     }  
    });  
    
    
    $('#' + btnid).attr('disabled' , 'disabled');
    
    
}); 

$(".delete_btn").click(function(){
    var btnid = $(this).attr("delete_id");
    var likeid = $(this).attr("delete_id") + "like";
    var originalrowid =  $(this).attr("rowid") + "rowid";
    var indiminute =0;
    indiminute = $(this).attr("indiminutes")/60;

    
    var currenttotalminute = 0;
    var newtotalminute = 0;
    var newtotalminuterounded = 0;
    var newpendingcount = 0;
    var currentpendingcount = 0;
    
    currentpendingcount = parseFloat(document.getElementById('total_pending_count').textContent);
    
    newpendingcount = currentpendingcount -1;
    currenttotalminute =  parseFloat(document.getElementById('total_time_hours').textContent);
    newtotalminute = currenttotalminute - indiminute;
    newtotalminuterounded = newtotalminute.toFixed(2);
    
    document.getElementById('total_time_hours').textContent = newtotalminuterounded;
    document.getElementById('total_pending_count').textContent = newpendingcount;
    
    
    $('#' + originalrowid).hide(500);
    $('#' + likeid).show();
    
     $.ajax({  
                     url:"deleteindi_auto_service_log.php",  
                     method:"POST",  
                     data:{row_id:btnid},  
                     dataType:"text",  
                     success:function(data)  
                     {  
                         
                     }  
    });  
    
    
    $('#' + btnid).attr('disabled' , 'disabled');
    
    
}); 

$(".task_minute").on("change keyup paste", function(){
   var rowid = $(this).attr("rowid");
    var newValue = $(this).text();
    

    
    $.ajax({  
                     url:"updateminute_auto_service_log.php",  
                     method:"POST",  
                     data:{row_id:rowid, new_value:newValue},  
                     dataType:"text",  
                     success:function(data)  
                     {  
                         
                     }  
    });  
    
    refreshcountfigures.call();
    
});
$(".task_comment").on("change keyup paste", function(){
   var rowid = $(this).attr("rowid");
    var newValue = $(this).text();
    

    
    $.ajax({  
                     url:"updatecomment_auto_service_log.php",  
                     method:"POST",  
                     data:{row_id:rowid, new_value:newValue},  
                     dataType:"text",  
                     success:function(data)  
                     {  
                         
                     }  
    });  
    
});

$(".task_description").on("change keyup paste", function(){
   var rowid = $(this).attr("rowid");
    var newValue = $(this).text();
    

    
    $.ajax({  
                     url:"updatedescription_auto_service_log.php",  
                     method:"POST",  
                     data:{row_id:rowid, new_value:newValue},  
                     dataType:"text",  
                     success:function(data)  
                     {  
                         
                     }  
    });  
    
});
    
});
    
</script>
