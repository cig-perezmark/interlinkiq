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
                                                                    ?>
                                                                    <li class="mt-list-item">
                                                                        <div class="list-todo-icon bg-white">
                                                                            <i class="fa fa-file"></i>
                                                                        </div>
                                                                        <div class="list-todo-item grey">
                                                                            <a class="list-toggle-container font-white" data-toggle="collapse" href="#task-<?= $eforms_row['PK_id'] ?>" aria-expanded="false">
                                                                                <div class="list-toggle done uppercase">
                                                                                    <div class="list-toggle-title bold"><?= $eforms_row['afl_form_name'] ?>	</div>
                                                                                    <!--<div class="badge badge-default pull-right bold">3</div>-->
                                                                                </div>
                                                                            </a>
                                                                            <div class="task-list panel-collapse collapse" id="task-<?= $eforms_row['PK_id'] ?>" aria-expanded="false">
                                                                                
                                                                                <div class="task-content">
                                                                                    <div id="chartdiv" style="width: 100%"></div>
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
                                                                                            <a class="task-add" onclick="show_trend()">
                                                                                                <i class="fa fa-line-chart"></i>
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    
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

        <?php include_once ('footer.php'); ?>
        <style>
            #chartdiv {
              width: 100%;
              height: 200px;
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
            $(document).ready(function(){
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
            am5.ready(function() {
            
            // Create root element
            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
            var root = am5.Root.new("chartdiv");
            
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

    </body>
</html>