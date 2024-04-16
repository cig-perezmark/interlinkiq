<?php 
    $title = "Sidebar Settings";
    $site = "sidebar";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {
        position: inherit;
    }
</style>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-login font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Sidebar Settings</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-bordered table-hover tableDataModal" id="tableData">
                                        <thead>
                                            <tr>
                                                <th>Module</th>
                                                <th class="text-center" style="width: 135px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if ($current_userEmployerID == 27) {
                                                    $selectMenu = mysqli_query( $conn,"SELECT
                                                        m.ID AS ID,
                                                        m.description AS description
                                                        FROM tbl_menu_subscription AS ms

                                                        LEFT JOIN (
                                                            SELECT
                                                            ID,
                                                            description
                                                            FROM tbl_menu

                                                            WHERE deleted = 0
                                                            AND module = 1
                                                            AND type = 0
                                                        ) AS m
                                                        ON ms.menu_ID = m.ID

                                                        WHERE deleted = 0
                                                        AND ms.user_id = 27

                                                        ORDER BY m.description");
                                                } else {
                                                    $selectMenu = mysqli_query( $conn,"SELECT * FROM tbl_menu WHERE module = 1 AND type = 0 AND deleted = 0 ORDER BY description ASC");
                                                }
                                                if ( mysqli_num_rows($selectMenu) > 0 ) {
                                                    while($rowMenu = mysqli_fetch_array($selectMenu)) {
                                                        $menu_ID = $rowMenu["ID"];
                                                        $menu_description = $rowMenu["description"];

                                                        echo '<tr id="tr_'.$menu_ID.'">
                                                            <td>'.$menu_description.'</td>
                                                            <td class="text-center">';
                                                                if ($current_userEmployerID == 27) {
                                                                    echo '<a href="#modalView" class="btn btn-outline dark btn-sm btn-circle" data-toggle="modal" onclick="btnView('. $menu_ID .')">View</a>';
                                                                } else {
                                                                    echo '<div class="btn-group btn-group-circle">
                                                                        <a href="#modalView" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnView('. $menu_ID .')">View</a>
                                                                        <a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnDelete('. $menu_ID .')">Delete</a>
                                                                    </div>';
                                                                }
                                                            echo '</td>
                                                        </tr>';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END BORDERED TABLE PORTLET-->
                        </div>


                        <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalView">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Sidebar Setting</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalNew" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalNew">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Accounts</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_New_Account" id="btnSave_New_Account" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalEdit" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalEdit">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Accounts</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_New_Account" id="btnUpdate_New_Account" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>

        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        
        <script type="text/javascript">
            $(document).ready(function(){
                $('.tableDataModal').DataTable();
            });

            function widget_dateRange() {
                var ComponentsDateTimePickers=function(){ var o=function(){jQuery().daterangepicker&&($("#defaultrange").daterangepicker({opens:App.isRTL()?"left":"right",format:"MM/DD/YYYY",separator:" to ",startDate:moment().subtract("days",29),endDate:moment(),ranges:{Today:[moment(),moment()],Yesterday:[moment().subtract("days",1),moment().subtract("days",1)],"Last 7 Days":[moment().subtract("days",6),moment()],"Last 30 Days":[moment().subtract("days",29),moment()],"This Month":[moment().startOf("month"),moment().endOf("month")],"Last Month":[moment().subtract("month",1).startOf("month"),moment().subtract("month",1).endOf("month")]},minDate:"01/01/2012",maxDate:"12/31/2018"},function(t,e){$("#defaultrange input").val(t.format("MMMM D, YYYY")+" - "+e.format("MMMM D, YYYY"))}),$("#defaultrange_modal").daterangepicker({opens:App.isRTL()?"left":"right",format:"MM/DD/YYYY",separator:" to ",startDate:moment().subtract("days",29),endDate:moment(),minDate:"01/01/2012",maxDate:"12/31/2018"},function(t,e){$("#defaultrange_modal input").val(t.format("MMMM D, YYYY")+" - "+e.format("MMMM D, YYYY"))}),$("#defaultrange_modal").on("click",function(){$("#daterangepicker_modal").is(":visible")&&0==$("body").hasClass("modal-open")&&$("body").addClass("modal-open")}),$("#reportrange").daterangepicker({opens:App.isRTL()?"left":"right",startDate:moment().subtract("days",29),endDate:moment(),dateLimit:{days:60},showDropdowns:!0,showWeekNumbers:!0,timePicker:!1,timePickerIncrement:1,timePicker12Hour:!0,ranges:{Today:[moment(),moment()],Yesterday:[moment().subtract("days",1),moment().subtract("days",1)],"Last 7 Days":[moment().subtract("days",6),moment()],"Last 30 Days":[moment().subtract("days",29),moment()],"This Month":[moment().startOf("month"),moment().endOf("month")],"Last Month":[moment().subtract("month",1).startOf("month"),moment().subtract("month",1).endOf("month")]},buttonClasses:["btn"],applyClass:"green",cancelClass:"default",format:"MM/DD/YYYY",separator:" to ",locale:{applyLabel:"Apply",fromLabel:"From",toLabel:"To",customRangeLabel:"Custom Range",daysOfWeek:["Su","Mo","Tu","We","Th","Fr","Sa"],monthNames:["January","February","March","April","May","June","July","August","September","October","November","December"],firstDay:1}},function(t,e){$("#reportrange span").html(t.format("MMMM D, YYYY")+" - "+e.format("MMMM D, YYYY"))}),$("#reportrange span").html(moment().subtract("days",29).format("MMMM D, YYYY")+" - "+moment().format("MMMM D, YYYY")))}; return{init:function(){o()}}}();App.isAngularJsApp()===!1&&jQuery(document).ready(function(){ComponentsDateTimePickers.init()});
            }
            function widget_date() {
                $('.daterange').daterangepicker({
                    ranges: {
                        'Today': [moment().subtract(1, 'day'), moment().subtract(1, 'day')],
                        'One Month': [moment().subtract(1, 'day'), moment().add(1, 'month')],
                        'One Year': [moment().subtract(1, 'day'), moment().add(1, 'year')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto"
                }, function(start, end, label) {
                  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
            }

            // Main
            function btnView(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Sidebar="+id,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalView .modal-body").html(data);
                        selectMulti();
                        $('.tableDataModal').DataTable();
                    }
                });
            }
            function btnDelete(id) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be deleted!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_Sidebar="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tableData tbody #tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }

            // Account
            function btnNew(id, type) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNew_SidebarAccount="+id+"&type="+type,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalNew .modal-body").html(data);
                        selectMulti();
                        widget_dateRange();
                        widget_date();
                    }
                });
            }
            $(".modalNew").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_New_Account',true);

                var l = Ladda.create(document.querySelector('#btnSave_New_Account'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            var result = '<tr class="tr_'+obj.ID+'">';
                                result += '<td>'+obj.name+'</td>';
                                result += '<td class="text-center">'+obj.date_start+'</td>';
                                result += '<td class="text-center">'+obj.date_end+'</td>';
                                result += '<td class="text-center"><span class="label label-sm label-info btn-circle">Initializing</span></td>';
                                result += '<td class="text-center">';
                                    result += '<div class="btn-group btn-group-circle">';
                                        result += '<a href="#modalEdit" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnEdit('+obj.ID+', '+obj.type+')">Edit</a>';
                                        result += '<a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnDeleteAccount('+obj.ID+', '+obj.type+')">Delete</a>';
                                    result += '</div>';
                                result += '</td>';
                            result += '</tr>';

                            $('#tableData_'+obj.type+' tbody').append(result);
                            $('#modalNew').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnEdit(id, type) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalEdit_SidebarAccount="+id+"&type="+type,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalEdit .modal-body").html(data);
                        selectMulti();
                        widget_date();
                    }
                });
            }
            $(".modalEdit").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_New_Account',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_New_Account'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            var result = '<td>'+obj.name+'</td>';
                            result += '<td class="text-center">'+obj.date_start+'</td>';
                            result += '<td class="text-center">'+obj.date_end+'</td>';
                            result += '<td class="text-center"><span class="label label-sm label-info btn-circle">Initializing</span></td>';
                            result += '<td class="text-center">';
                                result += '<div class="btn-group btn-group-circle">';
                                    result += '<a href="#modalEdit" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnEdit('+obj.ID+', '+obj.type+')">Edit</a>';
                                    result += '<a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnDeleteAccount('+obj.ID+', '+obj.type+')">Delete</a>';
                                result += '</div>';
                            result += '</td>';

                            $('#tableData_'+obj.type+' tbody .tr_'+obj.ID).html(result);
                            $('#modalEdit').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnDeleteAccount(id, type) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be deleted!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_SidebarAccount="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tableData_'+type+' tbody .tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
        </script>
    </body>
</html>