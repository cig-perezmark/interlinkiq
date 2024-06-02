<?php 
    $title = "Service Log";
    $site = "service_log";
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
            <span class="caption-subject font-blue-madison bold uppercase">Services Time Log</span>
          </div>
          <ul class="nav nav-tabs">
            <li class="active">
              <a href="#SERVICES" data-toggle="tab">Services</a>
            </li>
            <!-- if ($current_userEmployerID == 34 || $_COOKIE['ID'] == 34) -->
            <?php if($_COOKIE['ID'] == 38 || $_COOKIE['ID'] == 185 || $_COOKIE['ID'] == 100 || $_COOKIE['ID'] == 344 || $_COOKIE['ID'] == 41){ ?>
            <li>
              <a href="#MASS_UPLOAD" data-toggle="tab">Mass Upload</a>
            </li>
            <?php } ?>
            <li>
              <a href="#PERFORMANCE" data-toggle="tab">Performance</a>
            </li>
            <li>
              <a href="#VA_SUMMARY" data-toggle="tab">VA Summary</a>
            </li>
          </ul>
        </div>
        <div class="portlet-body">
          <div class="tab-content">
            <div class="tab-pane active" id="SERVICES">
              <div class="">
                <h3 style="margin: 0 0 1rem 0;"> Total records for one month period </h3>
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
              <div class="d-flex align-items-center justify-content-between" style="margin: 0 0 2rem 0; gap: 1rem;">
                <div class="btn-group">
                  <a class="btn grey-cascade" href="javascript:;" data-toggle="dropdown">
                    <span class="hidden-xs"> Actions </span>
                    <i class="fa fa-angle-down"></i>
                  </a>
                  <ul class="dropdown-menu" id="servicelog_table_actions">
                    <li>
                      <a href="javascript:;" data-action="1" class="tool-action">
                        <i class="icon-check"></i> Copy</a>
                    </li>
                    <li>
                      <a href="javascript:;" data-action="0" class="tool-action">
                        <i class="icon-printer"></i> Print</a>
                    </li>
                    <li>
                      <a href="javascript:;" data-action="4" class="tool-action">
                        <i class="icon-cloud-upload"></i> CSV</a>
                    </li>
                    <li>
                      <a href="javascript:;" data-action="3" class="tool-action">
                        <i class="icon-paper-clip"></i> Excel</a>
                    </li>
                    <li>
                      <a href="javascript:;" data-action="2" class="tool-action">
                        <i class="icon-doc"></i> PDF</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <a href="#advSearchModal" data-toggle="modal" class="tool-action">
                        <i class="icon-magnifier"></i> Advanced search</a>
                    </li>
                  </ul>
                </div>
                <a data-toggle="modal" href="#newTask" class="btn blue">
                  <i class="fa fa-plus"></i>
                  New Task
                </a>
              </div>
              <div class="portlet-body">
                <table id="service_time_logs_table" style="border-bottom: none;"
                  class="table table-striped table-bordered table-hover order-column dataTable no-footer">
                </table>
              </div>
            </div>
            <div class="tab-pane" id="MASS_UPLOAD">
              <div class="">
                <h3 style="margin: 0 0 1rem 0;"> Upload service log </h3>
                <p class="default"> Supports multiple services/logs to be uploaded at once. Use the
                  provided template document file to breakdown
                  task details.
                </p>
              </div>
              <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Note:</strong>
                <p> Not using the template will cause problem on your service
                  time </p>
              </div>
              <div class="d-flex align-items-start justify-content-between">
                <a href="task_service_log/SERVICES_LOG_TEMPLATE_UTF8.csv" class="btn green">
                  <i class="fa fa-download"></i>
                  Download template
                </a>
              </div>
              <!-- BEGIN Portlet PORTLET-->
              <div class="portlet light">
                <div class="portlet-title" style="border: none; margin-bottom: 0;">
                  <div class="caption font-grey-cascade" style="padding-bottom: 0;">
                    <i class="fa fa-tasks font-grey-cascade"></i>
                    <span class="caption-subject bold uppercase"> Tasks Table</span>
                    <span class="caption-helper">(click cell to edit)</span>
                  </div>
                  <div class="actions" style="padding-bottom: 0;">
                    <button type="button" id="massUploadCSVFileForm" class="btn btn-circle btn-outline green btn-sm">
                      <input type="file" accept=".csv" style="display: none;" id="massUploadCSVFileInput">
                      <i class="fa fa-upload"></i> Upload CSV file
                    </button>
                    <button type="button" id="massUploadImportBtn" disabled class="btn btn-circle blue btn-sm">
                      <i class="fa fa-save"></i> Save/Import
                    </button>
                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
                  </div>
                </div>
                <div class="portlet-body">
                  <div id="csv_file_data"></div>
                </div>
              </div>
              <!-- END Portlet PORTLET-->
            </div>
            <div class="tab-pane" id="PERFORMANCE">
              <div class="">
                <h3 style="margin: 0 0 1rem 0;">
                  Performance Summary
                </h3>
                <h5 class="font-grey-cascade">Last render date: <span data-performance="current_date"></span></h5>
              </div>
              <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Reminder!</strong>
                <p>
                  Don't forget to log your tasks! It is important for your compensation and company's
                  sales.
                </p>
              </div>
              <div class="m-grid">
                <div class="row">
                  <div class="col-lg-7 col-xs-12 col-sm-12">
                    <div class="dashboard-stat dashboard-stat-v2 grey-cararra">
                      <div class="visual">
                        <i class="fa fa-briefcase"></i>
                      </div>
                      <div class="details">
                        <div class="number" data-performance="overall_time">0</div>
                        <div class="desc"> Overall Time Spent </div>
                      </div>
                    </div>
                    <div class="row widget-row">
                      <div class="col-md-6">
                        <!-- BEGIN WIDGET THUMB -->
                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                          <h4 class="widget-thumb-heading">Completed Tasks</h4>
                          <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon font-green-jungle icon-check"></i>
                            <div class="widget-thumb-body">
                              <span class="widget-thumb-subtitle">total</span>
                              <span class="widget-thumb-body-stat" data-performance="total_completed_tasks">0</span>
                            </div>
                          </div>
                        </div>
                        <!-- END WIDGET THUMB -->
                      </div>
                      <div class="col-md-6">
                        <!-- BEGIN WIDGET THUMB -->
                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                          <h4 class="widget-thumb-heading">Days Worked</h4>
                          <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon font-blue-dark icon-calendar"></i>
                            <div class="widget-thumb-body">
                              <span class="widget-thumb-subtitle">total</span>
                              <span class="widget-thumb-body-stat" data-performance="total_days_worked">0</span>
                            </div>
                          </div>
                        </div>
                        <!-- END WIDGET THUMB -->
                      </div>
                      <div class="col-md-6">
                        <!-- BEGIN WIDGET THUMB -->
                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                          <h4 class="widget-thumb-heading">Average Hours/Day</h4>
                          <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon font-blue-madison icon-clock">
                            </i>
                            <div class="widget-thumb-body">
                              <span class="widget-thumb-subtitle">time</span>
                              <span class="widget-thumb-body-stat" data-performance="avg_hours_day">0</span>
                            </div>
                          </div>
                        </div>
                        <!-- END WIDGET THUMB -->
                      </div>
                      <div class="col-md-6">
                        <!-- BEGIN WIDGET THUMB -->
                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                          <h4 class="widget-thumb-heading">Average hours/week</h4>
                          <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon font-blue-dark icon-bar-chart"></i>
                            <div class="widget-thumb-body">
                              <span class="widget-thumb-subtitle">time</span>
                              <span class="widget-thumb-body-stat" data-performance="avg_hours_week">0</span>
                            </div>
                          </div>
                        </div>
                        <!-- END WIDGET THUMB -->
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-5 col-xs-12 col-sm-12">
                    <div class="portlet light blue-steel font-white">
                      <div class="portlet-title">
                        <div class="caption">
                          <i class="icon-cursor font-white "></i>
                          <span class="caption-subject font-white bold uppercase">
                            daily Report
                          </span>
                        </div>
                      </div>
                      <div class="portlet-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="easy-pie-chart">
                              <div class="number" data-performance="daily_time"
                                style="width: 100%; height: 50px; font-weight: 600; font-size: 1.5em !important;">
                                0
                              </div>
                              <div class="title font-white" style="font-size: .9em">
                                Time Rendered
                              </div>
                            </div>
                          </div>
                          <div class="margin-bottom-10 visible-sm"> </div>
                          <div class="col-md-6">
                            <div class="easy-pie-chart">
                              <div class="number" data-performance="daily_tasks"
                                style="width: 100%; height: 50px; font-weight: 600; font-size: 1.5em !important;">
                                0
                              </div>
                              <div class="title font-white" style="font-size: .9em">
                                Tasks Completed
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="portlet light bordered" style="background-color:;">
                      <div class="portlet-title">
                        <div class="caption">
                          <i class="icon-calendar font-dark"></i>
                          <span class="caption-subject font-dark bold uppercase">
                            Weekly reports
                          </span>
                        </div>
                      </div>
                      <div class="portlet-body" >
                        <div class="row">
                          <div class="col-md-6">
                            <div class="easy-pie-chart">
                              <div class="number" data-performance="weekly_time"
                                style="width: 100%; height: 50px; font-weight: 600; font-size: 1.5em !important;">
                                0
                              </div>
                              <div class="title font-dark" style="font-size: .9em">
                                Total Time Rendered
                              </div>
                            </div>
                          </div>
                          <div class="margin-bottom-10 visible-sm"> </div>
                          <div class="col-md-6">
                            <div class="easy-pie-chart">
                              <div class="number" data-performance="weekly_tasks"
                                style="width: 100%; height: 50px; font-weight: 600; font-size: 1.5em !important;">
                                0
                              </div>
                              <div class="title font-dark" style="font-size: .9em">
                                Total Tasks Completed
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="VA_SUMMARY">
              <div class="">
                <h3 style="margin: 0 0 1rem 0;"> Employee List</h3>
                <p class="default">
                  Service logs summary of your employees.
                </p>
              </div>
              <div class="portlet light" style="padding-left:0; padding-right: 0;">
                <div class="portlet-title" style="border: none; margin-bottom: 0;">
                  <div class="btn-group">
                    <a class="btn grey-cascade" href="javascript:;" data-toggle="dropdown">
                      <span class="hidden-xs"> Export </span>
                      <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu" id="vasummary_table_actions">
                      <li>
                        <a href="javascript:;" data-action="0" class="tool-action">
                          <i class="icon-cloud-upload"></i> CSV</a>
                      </li>
                      <li>
                        <a href="javascript:;" data-action="1" class="tool-action">
                          <i class="icon-paper-clip"></i> Excel</a>
                      </li>
                    </ul>
                  </div>
                  <div class="actions" style="padding-bottom: 0;">
                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
                  </div>
                </div>
                <div class="portlet-body">
                  <table id="va_summary_table"
                    class="table table-bordered table-hover order-column dataTable no-footer">
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END CONTENT BODY -->
<?php if($_COOKIE['ID'] == 34 || $_COOKIE['ID'] == 189 || $_COOKIE['ID'] == 387): ?>
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
                  <select class="form-control mt-multiselect" name="account" id="task_account">
                    <?php
                        $accounts = $con->query("SELECT * FROM tbl_service_logs_accounts order by name ASC");
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
        </style>
    </body>
</html>