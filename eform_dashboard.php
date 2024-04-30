<?php 
    $title = "EForm";
    $site = "eform_dashboard";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>E-Forms</span></li>';
    include_once ('database_afia_forms.php'); 
    include_once ('database_forms.php'); 
    include_once ('header.php'); 
?>
<?php
    $performer_count = 0;
    // Construct your SQL query
    $count_performer = "SELECT COUNT(*) as count FROM kpi_performer";
    
    // Execute the query
    $count_result = mysqli_query($e_connection, $count_performer);
    
    if (mysqli_num_rows($count_result) > 0) {
        // Output data of each row
        $row_count_result = mysqli_fetch_assoc($count_result);
        $performer_count = $row_count_result["count"];
    } else {
        echo "0 results";
    }
    
    $record_count = 0;
    $sql_record = "SELECT COUNT(PK_id) AS count FROM tbl_fscs_records WHERE DATE(date) = CURDATE()";
    
    $record_result = mysqli_query($e_connection,$sql_record);
    if (mysqli_num_rows($record_result) > 0) {
        // Output data of each row
        $record_counts = mysqli_fetch_assoc($record_result);
        $record_count = $record_counts["count"];
    }
    $count = 0;
    // Construct your SQL query
    $sql_count = "SELECT COUNT(DISTINCT employee_id) AS count FROM kpi_daily_perform WHERE DATE(date_perform) = CURDATE();";
    
    // Execute the query
    $sql_result = mysqli_query($e_connection, $sql_count);
    
    if (mysqli_num_rows($sql_result) > 0) {
        // Output data of each row
        $row_count = mysqli_fetch_assoc($sql_result);
        $count = $row_count["count"];
    }
    
    
    
    $not_review_count = 0;
    $sql_not_review = "SELECT COUNT(PK_id) AS count FROM tbl_fscs_records WHERE DATE(date) = CURDATE() AND approver_name IS NULL";
    $not_review_result = mysqli_query($e_connection,$sql_not_review);
    if (mysqli_num_rows($not_review_result) > 0) {
        // Output data of each row
        $not_review_counts = mysqli_fetch_assoc($not_review_result);
        $not_review_count = $not_review_counts["count"];
    }
    $review_count = $record_count - $not_review_count;
    
    $total_not_perform = $performer_count - $count;
;
?>
<style type="text/css">
    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {
        position: relative;
    }
</style>

<!-- Include Spectrum CSS -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.css">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light portlet-fit">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-folder-alt font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">E-Form Dashboard</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a  data-toggle="modal" data-target="#add_category" href="#" >Add Category</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable" style="border: 0;">
                                        <div class="row">
                                            <?php
                                                $sql = "SELECT * FROM tbl_eforms_category";
                                                $result = mysqli_query($conn,$sql);
                                                foreach($result as $row):
                                            ?>
                                            <div class="col-lg-6">
                                                <div class="portlet light portlet-fit ">
                                                    <div class="portlet-body">
                                                        <div class="mt-element-list">
                                                            <div class="mt-list-head list-todo" style="background-color:<?= $row['label_color'] ?> !important">
                                                                <div class="list-head-title-container">
                                                                    <h3 class="list-title"><?= $row['category_name'] ?></h3>
                                                                </div>
                                                                <a href="#" data_id="<?= $row['id'] ?>" data-toggle="modal" data-target="#assign_modal">
                                                                    <div class="list-count pull-right blue" style="height:35px">
                                                                        <i class="fa fa-plus"></i>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="mt-list-container list-todo">
                                                                <div class="list-todo-line"></div>
                                                                <ul>
                                                                    <?php
                                                                        $forms = "SELECT * FROM tbl_eforms_forms WHERE PK_id = {$row['id']}";
                                                                        $forms_result = mysqli_query($conn,$forms);
                                                                        foreach($forms_result as $forms_row):
                                                                        $eforms = "SELECT * FROM tbl_afia_forms_list WHERE PK_id = {$forms_row['form_id']}";
                                                                        $eforms_result = mysqli_query($e_connection,$eforms);
                                                                        $eforms_row = mysqli_fetch_assoc($eforms_result);
                                                                        
                                                                        $performer_count = 0;
                                                                        // Construct your SQL query
                                                                        $count_performer = "SELECT COUNT(*) as count FROM kpi_performer WHERE form_code = '{$eforms_row['afl_form_code']}'";
                                                                        
                                                                        // Execute the query
                                                                        $count_result = mysqli_query($e_connection, $count_performer);
                                                                        
                                                                        if($count_result){
                                                                            if (mysqli_num_rows($count_result) > 0) {
                                                                                // Output data of each row
                                                                                $row_count_result = mysqli_fetch_assoc($count_result);
                                                                                $performer_count = $row_count_result["count"];
                                                                            } else {
                                                                                echo "0 results";
                                                                            }
                                                                        }
                                                                        
                                                                    ?>
                                                                    <li class="mt-list-item">
                                                                        <div class="list-todo-icon bg-white">
                                                                            <?php if($_COOKIE['ID'] == 481): ?>
                                                                                <a href="#" data-toggle="modal" data-target="#collab_modal"><i class="fa fa-file" ></i></a>
                                                                                <a href="#" eforms_id="<?= $eforms_row['PK_id'] ?>" class="open-modal" data-toggle="modal" data-target="#form_desc"><i class="fa fa-pencil" ></i></a>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <div class="list-todo-item grey">
                                                                            <a class="list-toggle-container font-white" data-toggle="collapse" href="#task-<?= $row['id'].'_'.$eforms_row['PK_id'] ?>" aria-expanded="false">
                                                                                <div class="list-toggle done uppercase">
                                                                                    <div class="list-toggle-title bold"><?= $eforms_row['afl_form_name'] ?>	</div>
                                                                                    <!--<div class="badge badge-default pull-right bold">3</div>-->
                                                                                </div>
                                                                            </a>
                                                                            <div class="task-list panel-collapse collapse" id="task-<?= $row['id'].'_'.$eforms_row['PK_id'] ?>" aria-expanded="false">
                                                                                
                                                                                <div class="task-content">
                                                                                    <div id="chartdiv_<?= $row['id'].'_'.$eforms_row['PK_id'] ?>" style="width: 100%"></div>
                                                                                    <div class="form_desc" style="padding:10px">
                                                                                        <label eforms_id="<?= $eforms_row['PK_id'] ?>" contenteditable><?= $eforms_row['form_desc'] ?></label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="task-footer bg-grey">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-4">
                                                                                            <a class="task-add" onclick="myfunction('<?= $switch_user_id ?>', '<?= $enterp_logo ?>')" target="_blank" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $eforms_row['afl_form_code'] ?>/add_records/<?= $eforms_row['PK_id'] ?>">
                                                                                                <i class="fa fa-plus"></i>
                                                                                            </a>
                                                                                        </div>
                                                                                        <div class="col-xs-4">
                                                                                            <a class="task-trash" onclick="myfunction1('<?= $switch_user_id ?>', '<?= $enterp_logo ?>')" target="_blank" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/<?= $eforms_row['afl_form_code'] ?>/view_records/<?= $eforms_row['PK_id'] ?>">
                                                                                                <i class="fa icon-docs"></i>
                                                                                            </a>
                                                                                        </div>
                                                                                        <div class="col-xs-4">
                                                                                            <a class="task-add" data-toggle="modal" data-target="#show_trend">
                                                                                                <i class="fa fa-line-chart"></i>
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <style>
                                                                        #chartdiv_<?= $row['id'].'_'.$eforms_row['PK_id'] ?> {
                                                                          width: 100%;
                                                                          height: 200px;
                                                                          z-index:999;
                                                                        }
                                                                    </style>
                                                                    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
                                                                    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
                                                                    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
                                                                    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
                                                                    <script>
                                                                        am5.ready(function() {
            
                                                                            // Create root element
                                                                            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                                                                            var root = am5.Root.new("chartdiv_<?= $row['id'].'_'.$eforms_row['PK_id'] ?>");
                                                                            
                                                                            // Set themes
                                                                            // https://www.amcharts.com/docs/v5/concepts/themes/
                                                                            root.setThemes([
                                                                              am5themes_Animated.new(root)
                                                                            ]);
                                                                            
                                                                            // Create chart
                                                                            // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                                                                            var chart = root.container.children.push(
                                                                              am5percent.PieChart.new(root, {
                                                                                endAngle: 270
                                                                              })
                                                                            );
                                                                            
                                                                            // Create series
                                                                            // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                                                                            var series = chart.series.push(
                                                                              am5percent.PieSeries.new(root, {
                                                                                valueField: "value",
                                                                                categoryField: "category",
                                                                                endAngle: 270
                                                                              })
                                                                            );
                                                                            
                                                                            series.states.create("hidden", {
                                                                              endAngle: -90
                                                                            });
                                                                            
                                                                            // Set data
                                                                            // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
                                                                            series.data.setAll([
                                                                              {
                                                                              category: "Not Performed",
                                                                              value: <?= $total_not_perform ?>
                                                                            }, {
                                                                              category: "Performed",
                                                                              value: <?= $count ?>
                                                                            }]);
                                                                            
                                                                            series.appear(1000, 100);
                                                                            
                                                                            }); // end am5.ready()
                                                                    </script>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- Modal -->
                    <form action="controller.php" method="POST">
                        <div class="modal fade" id="assign_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Assign Form - ONGOING UPDATE </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="parent_id" id="row_id_input">
                                    <div class="col-md-12">
                                        <label>Select Form</label>
                                        <select  class="form-control mt-multiselect btn btn-default" name="eform_id[]" multiple="multiple">
                                            <?php
                                                if($current_userEmployeeID == 0){
                                                    $check_form_owned = mysqli_query($conn,"SELECT * FROM tbl_forms_owned WHERE user_id = '" . $_COOKIE['ID'] . "' AND enterprise_id = '" . $_COOKIE['ID'] . "'"); 
                                                }
                                                else{
                                                        $check_form_owned = mysqli_query($conn,"SELECT * FROM tbl_forms_owned WHERE enterprise_id = '$switch_user_id' AND user_id = {$_COOKIE['ID']}"); 
                                                }
                                                $num_rows = mysqli_num_rows($check_form_owned);
                                                 if($num_rows > 0 ):
                                                     $check_result = mysqli_fetch_array($check_form_owned);
                                                    $array_counter = explode(",", $check_result["form_owned"]); 
                                                    foreach($array_counter as $value):
                                                        $query = "SELECT * FROM tbl_afia_forms_list WHERE PK_id = '$value'";
                                                        $result = mysqli_query($e_connection, $query);
                                                        while($row = mysqli_fetch_array($result)):
                                            ?>
                                            <option value="<?= $row['PK_id'] ?>"><?= $row['afl_form_name']; ?></option>
                                            <?php endwhile;endforeach;endif; ?>
                                        </select>
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="submit_eform_category" class="btn btn-primary">Save</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="add_category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                  <div class="row">
                                        <div class="col-md-12">
                                            <label>Category Name</label>
                                            <input type="text" name="category_name" class="form-control">
                                        </div>
                                  </div>
                                <div class="row" style="margin-top:15px">
                                    <div class="col-md-6">
                                        <button type="button" id="color_picker_btn" class="btn btn-secondary">Choose Color</button>
                                        <div id="choosen_color" style="border:solid 1px #ffff;width:100px;height:50px">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="label_color" id="color_input" readonly>
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="save_category" class="btn btn-primary">Save</button>
                              </div>
                            </div>
                          </div>
                        </div>

                    </form>        
                    </div><!-- END CONTENT BODY -->
                    
                    <!-- Modal -->
                    <div class="modal fade" id="show_trend" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog"  style="width:1100px">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Trend Analysis</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12"  style="width: 100%; overflow-x: auto;">
                                    <div id="chartdiv5" style="width: 1200px"></div>
                                </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <form method="POST" id="kpi_reviewer_form">
                        <!-- Modal -->
                        <div class="modal fade" id="collab_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Collaborator</h5>
                              </div>
                              <div class="modal-body">
                                  <div class="row">
                                      <div class="col-md-12">
                                            <label>Collaborator Type</label>
                                            <select name="collab_type" class="form-control" id="select_collab_type">
                                                <option>-- Please Select --</option>
                                                <option value="performer">Performer</option>
                                                <option value="reviewer">Reviewer</option>
                                            </select>
                                      </div>
                                  </div>
                                  <div id="performer_type" style="display:none;margin-top:15px">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Collaborator Name</label>
                                                <select name="employee_id_performer" class="form-control" >
                                                    <option>-- Please Select --</option>
                                                    <?php
                                                        $result_employee = mysqli_query($conn,"SELECT * FROM `tbl_hr_employee` WHERE user_id = ".$_COOKIE['user_company_id']." AND status != 0 AND type_id = 1");
                                                        foreach($result_employee as $rows):
                                                            $employee = mysqli_query($conn,"SELECT * FROM `tbl_user` WHERE employee_id = '" . $rows['ID'] . "' ");
                                                            foreach($employee as $employee_rows):
                                                    ?>
                                                    <option value="<?= $employee_rows['employee_id'] ?>"><?= $employee_rows['first_name'] .' '.$employee_rows['last_name'] ?></option>
                                                    <?php endforeach; endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px">
                                            <div class="col-md-12">
                                                <label>Frequency</label>
                                                <select name="performer_frequency" class="form-control">
                                                    <option value="Daily">Daily</option>
                                                    <option value="Weekly">Weekly</option>
                                                    <option value="Monthly">Monthly</option>
                                                    <option value="Quarterly">Quarterly</option>
                                                    <option value="Annualy">Annualy</option>
                                                </select>
                                            </div>
                                        </div>
                                  </div>
                                <div id="reviewer_type" style="display:none;margin-top:15px">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Collaborator Name</label>
                                            <select name="employee_id" class="form-control">
                                                <option>-- Please Select --</option>
                                                <?php
                                                    $result2 = mysqli_query($conn,"SELECT * FROM `tbl_hr_employee` WHERE user_id = ".$_COOKIE['user_company_id']." AND status != 0 AND type_id = 1");
                                                    foreach($result2 as $rows):
                                                        $employee2 = mysqli_query($conn,"SELECT * FROM `tbl_user` WHERE employee_id = '" . $rows['ID'] . "' ");
                                                        foreach($employee2 as $employee_rows):
                                                ?>
                                                <option value="<?= $employee_rows['employee_id'] ?>"><?= $employee_rows['first_name'] .' '.$employee_rows['last_name'] ?></option>
                                                <?php endforeach; endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px">
                                        <div class="col-md-12">
                                            <label>Frequency</label>
                                            <select name="frequency" class="form-control">
                                                <option>-- Please Select --</option>
                                                <option value="1">Daily</option>
                                                <option value="2">Weekly</option>
                                                <option value="3">Monthly</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px">
                                        <div class="col-md-6">
                                            <label>From</label>
                                            <input name="time_from" type="time" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>To</label>
                                            <input name="time_to" type="time" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px">
                                        <div class="col-md-12">
                                            <label>Reviewer Position</label>
                                            <select name="reviewer" class="form-control">
                                                <option>-- Please Select --</option>
                                                <option value="1">Primary</option>
                                                <option value="2">Subtitute</option>
                                                <option value="3">Alternate</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px">
                                        <div class="col-md-12">
                                            <label>Action Items <span style="color:green;cursor:pointer;font-size:14px" id="add-action-item">+</span></label>
                                            <div id="action-items-container">
                                                <input type="text" class="form-control" name="action_items[]">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="save_kpi_reviewer">Update</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        </form>
                        
                        <form action="controller.php" method="POST">
                        <!-- Modal -->
                        <div class="modal fade" id="form_desc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Form Description</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <input type="hidden" id="eforms_id_input" name="eforms_id">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Form Description</label>
                                        <textarea class="form-control" name="form_desc"></textarea>
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="save_form_desc">Update</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        </form>
        <?php include_once ('footer.php'); ?>
        <style>
            #chartdiv {
              width: 100%;
              height: 200px;
              z-index:999;
            }
            #chartdiv5 {
              width: 100%;
              height: 400px;
              z-index:999;
            }
        </style>
        <!-- Include Spectrum JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.js"></script>
        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>

        <script>
        // Add event listener to the button
          // Select all elements with the class 'open-modal'
          var modalTriggers = document.querySelectorAll('.open-modal');
        
          // Loop through each modal trigger
          modalTriggers.forEach(function(trigger) {
            // Add event listener to each trigger
            trigger.addEventListener('click', function() {
              // Retrieve eforms_id value for this specific trigger
              var eforms_id = this.getAttribute('eforms_id');
              // Assign eforms_id value to the input field inside the modal
              document.getElementById('eforms_id_input').value = eforms_id;
            });
          });
            $(document).ready(function(){
                $('#save_kpi_reviewer').click(function(e) {
                    e.preventDefault(); // Prevent the default button click behavior
                        
                    // Serialize form data
                    var formData = new FormData($('#kpi_reviewer_form')[0]);
                    formData.append('save_kpi_reviewer', '1'); // Add the form submission key dynamically
            
                    $.ajax({
                        url: 'controller',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            // Close the modal
                            $('#collab_modal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Cheers!',
                                    text: 'Performer Successfully Added',
                                    padding: '4em',
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                        },
                        error: function(xhr, status, error) {
                            // Handle errors or display messages as needed
                        }
                    });
                });
                $('label[contenteditable]').on('input', function() {
                    var newValue = $(this).text(); // Get the new value of the label
                    var eformsId = $(this).attr('eforms_id'); // Get the eforms_id
            
                    // Send an AJAX request to update the database
                    $.ajax({
                        url: 'controller.php', // Your PHP script to update the database
                        method: 'POST',
                        data: {
                            save_form_desc:1,
                            eforms_id: eformsId,
                            form_desc: newValue
                        },
                        success: function(response) {
                            console.log('Database updated successfully!');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error updating database:', error);
                        }
                    });
                });
                 // Get references to the divs
                var performerDiv = $('#performer_type');
                var reviewerDiv = $('#reviewer_type');
                
                // Add change event listener to the select element
                $('#select_collab_type').change(function() {
                    // Get the selected option value
                    var selectedValue = $(this).val();
                    
                    // Hide both divs
                    performerDiv.hide();
                    reviewerDiv.hide();
                    
                    // Show the selected div based on the option value
                    if (selectedValue === 'performer') {
                        performerDiv.show();
                    } else if (selectedValue === 'reviewer') {
                        reviewerDiv.show();
                    }
                });
            
                // Get the container where action items will be appended
                var actionItemsContainer = $('#action-items-container');
                
                // Add click event listener to the add button
                $('#add-action-item').click(function() {
                    // Create a new input element
                    var newInput = $('<input type="text" class="form-control mt-2" name="action_items[]">');
                    
                    // Append the new input element to the container
                    actionItemsContainer.append(newInput);
                });
        
                $('#assign_modal').on('show.bs.modal', function (e) {
                    var id = $(e.relatedTarget).attr('data_id'); // Get the id from data-id attribute
                    $('#row_id_input').val(id); // Set the value of input field
                });
                $("#color_picker_btn").spectrum({
                    preferredFormat: "hex",
                    showInput: true,
                    showInitial: true,
                    showPalette: true,
                    palette: [ ['#000', '#fff', '#ff0000', '#00ff00', '#0000ff'] ], // Example palette colors
                    change: function(color) {
                        $("#color_input").val(color.toHexString()); // Update input field value
                        $("#choosen_color").css("background-color", color.toHexString()); // Set chosen color div background color
                    }
                });
            });
            function show_trend(){
                alert("Trend analysis ongoing development");
            }
            function myfunction(id,enterpriseLogo){
              const d = new Date();
              d.setTime(d.getTime() + (1*24*60*60*1000));
              let expires = "expires="+ d.toUTCString();
              document.cookie = `enterprise_logo=${enterpriseLogo}; user_company_id=${id};  ${expires}; path=/`;
              document.cookie = `user_company_id=${id}; ${expires}; path=/`;
             }
        </script>
    <script>
        am5.ready(function() {
        
        
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chartdiv5");
        
        
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
          am5themes_Animated.new(root)
        ]);
        
        
        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
          panX: false,
          panY: false,
          paddingLeft: 0,
          wheelX: "panX",
          wheelY: "zoomX",
          layout: root.verticalLayout
        }));
        
        
        // Add legend
        // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
        var legend = chart.children.push(
          am5.Legend.new(root, {
            centerX: am5.p50,
            x: am5.p50
          })
        );
        
        var data = [{
          "year": "I received food safety training\nbefore they allow me to work.",
          "s_agree": 10,
          "agree": 7,
          "disagree": 2,
          "s_disagree": 1
        }, {        
          "year": "I appreciate when a co-worker\npoints out to me if I am doing something\nthat could affect food safety in a bad way",
          "s_agree": 8,
          "agree": 12,
          "disagree": 1,
          "s_disagree": 0
        },
        {
          "year": "I am comfortable stopping \n the line whenever I see something that might \n harm the quality and safety of the food we make. ",
          "s_agree": 11,
          "agree": 12,
          "disagree": 2,
          "s_disagree": 2
        },
        {
          "year": "I think my supervisor always puts\nfood safety ahead of production.",
          "s_agree": 9,
          "agree": 5,
          "disagree": 4,
          "s_disagree": 1
        }]
        
        
        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root, {
          cellStartLocation: 0.1,
          cellEndLocation: 0.9,
          minorGridEnabled: true
        })
        
        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
          categoryField: "year",
          renderer: xRenderer,
          tooltip: am5.Tooltip.new(root, {})
        }));
        
        xRenderer.grid.template.setAll({
          location: 1
        })
        
        xAxis.data.setAll(data);
        
        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
          renderer: am5xy.AxisRendererY.new(root, {
            strokeOpacity: 0.1
          })
        }));
        
        
        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        function makeSeries(name, fieldName) {
          var series = chart.series.push(am5xy.ColumnSeries.new(root, {
            name: name,
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: fieldName,
            categoryXField: "year"
          }));
        
          series.columns.template.setAll({
            tooltipText: "{name}, {categoryX}:{valueY}",
            width: am5.percent(90),
            tooltipY: 0,
            strokeOpacity: 0
          });
        
          series.data.setAll(data);
        
          // Make stuff animate on load
          // https://www.amcharts.com/docs/v5/concepts/animations/
          series.appear();
        
          series.bullets.push(function () {
            return am5.Bullet.new(root, {
              locationY: 0,
              sprite: am5.Label.new(root, {
                text: "{valueY}",
                fill: root.interfaceColors.get("alternativeText"),
                centerY: 0,
                centerX: am5.p50,
                populateText: true
              })
            });
          });
        
          legend.data.push(series);
        }
        
        makeSeries("Strongly Agree", "s_agree");
        makeSeries("Agree", "agree");
        makeSeries("Disagree", "disagree");
        makeSeries("Strongly Disagree", "s_disagree");
        
        
        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        chart.appear(1000, 100);
        
        }); // end am5.ready()
        </script>
    </body>
</html>