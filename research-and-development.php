<?php 
    $title = "Research and Development";
    $site = "rd";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_1">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-green-sharp"><span>0</span></h3>
                                        <small>Formulator Personnel</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-user-following"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success green-sharp"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_2">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-red-haze"><span>0</span></h3>
                                        <small>Total Receipe</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-user-unfollow"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success red-haze"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2  counterup_3">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-blue-sharp"><span>0</span></h3>
                                        <small>Raw Materials / Ingredients</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-calendar"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success blue-sharp"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage for this month</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_4">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-purple-soft"><span>0</span></h3>
                                        <small>Total Supplier</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-users"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success purple-soft"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-puzzle font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Research & Development</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#modalNew" > Add New Customer</a>
                                                </li>
                                                <li class="divider"> </li>
                                                <li>
                                                    <a href="javascript:;">Option 2</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">Option 3</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">Option 4</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered table-hover" id="tableData">
                                            <thead>
                                                <tr>
                                                    <th>ID#</th>
                                                    <th>Receipe</th>
                                                    <th>Formulator Personnel</th>
                                                    <th>Raw Materials / Ingredients</th>
                                                    <th>Supplier</th>
                                                    <th>Supplier Approval Program</th>
                                                    <th>Status</th>
                                                    <th>File</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $result = mysqli_query( $conn,"SELECT * FROM tbl_supplier" );
                                                    if ( mysqli_num_rows($result) > 0 ) {
                                                        while($row = mysqli_fetch_array($result)) {
                                                            echo '<tr id="tr_'. $row["ID"] .'">
                                                                <td>'. $row["ID"] .'</td>
                                                                <td>'. $row["name"] .'</td>
                                                                <td>'. $row["address"] .'</td>
                                                                <td>'. $row["phone"] .'</td>
                                                                <td>'. $row["fax"] .'</td>
                                                                <td>'. $row["email"] .'</td>
                                                                <td>'. $row["website"] .'</td>
                                                                <td>'. $row["type"] .'</td>';

                                                                if ( $row["status"] == 0 ) {
                                                                    echo '<td><span class="label label-sm label-danger">Inactive</span></td>';
                                                                } else if ( $row["status"] == 1 ) {
                                                                    echo '<td><span class="label label-sm label-success">Active</span></td>';
                                                                }
                                                                
                                                                echo '<td class="text-center">
                                                                    <a class="btn dark btn-sm btn-outline sbold uppercase btnView" data-toggle="modal" href="#modalView" data-id="'. $row["ID"] .'"><i class="fa fa-share"></i> View</a>
                                                                </td>
                                                            </tr>';
                                                        }
                                                        
                                                    } else {
                                                        echo '<tr class="text-center text-default"><td colspan="10">Empty Record</td></tr>';
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- END BORDERED TABLE PORTLET-->
                        </div>

                        <!-- MODAL AREA-->
                        <div class="modal fade" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalSave">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Supplier Form</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input class="form-control" type="hidden" name="ID" value="<?php echo $current_userID; ?>" />
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Supplier Name</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="name" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Address</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="address" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Phone</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="phone" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Fax</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="fax" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="email" name="email" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Website</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="url" name="website" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Type</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="type" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <input type="submit" class="btn green" name="btnSave_Supplier" id="btnSave_Supplier" value="Save" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade bs-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Supplier Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <input type="submit" class="btn green" name="btnUpdate_Supplier" id="btnUpdate_Supplier" value="Save" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
        
        <script type="text/javascript">
            // Data Save
            $(document).ready(function(){
                BtnSave.init()
                BtnUpdate.init()
                $(".modalForm").validate();

                var site = '<?php echo $site; ?>';
                $.ajax({
                    url: 'admin_2/function.php?counterup='+site,
                    context: document.body,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        var obj = jQuery.parseJSON(response);
                        var pct_counter1 = (parseInt(obj.statusActive) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter2 = (parseInt(obj.statusInactive) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter3 = (parseInt(obj.statusInactiveMonth) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter4 = (parseInt(obj.statusTotal) / parseInt(obj.statusTotal)) * 100;
                        $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                        $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                        $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                        $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                        $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                        $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                        $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactiveMonth+'"></span>');
                        $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                        $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                        $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusTotal+'"></span>');
                        $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                        $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');
                        
                        $('.counterup').counterUp();
                    }
                });
            });

            var BtnSave=function(){
                return{
                    init:function(){
                        $("#btnSave_Supplier").click(function(event){
                            event.preventDefault();

                            formObj = $(this).parents().parents();
                            if (!formObj.validate().form()) return false;

                            var data = $('.modalSave').serialize()+'&btnSave_Supplier=btnSave_Supplier';
                            $.ajax({
                                url:'admin_2/function.php',
                                type:'post',
                                dataType:'JSON',
                                data:data,
                                success:function(response) {

                                    if ($.trim(response)) {
                                        msg = "Sucessfully Save!";

                                        var html = '<tr id="tr_'+response.ID+'">';
                                        html += '<td>'+response.ID+'</td>';
                                        html += '<td>'+response.name+'</td>';
                                        html += '<td>'+response.address+'</td>';
                                        html += '<td>'+response.phone+'</td>';
                                        html += '<td>'+response.fax+'</td>';
                                        html += '<td>'+response.email+'</td>';
                                        html += '<td>'+response.website+'</td>';
                                        html += '<td>'+response.type+'</td>';
                                        html += '<td><span class="label label-sm label-success">Active</span></td>';
                                        html += '<td class="text-center"><a  class="btn dark btn-sm btn-outline sbold uppercase btnView" data-toggle="modal" href="#modalView" data-id="'+response.ID+'"><i class="fa fa-share"></i> View</a></td>';
                                        html += '</tr>';

                                        $('#tableData tbody').append(html);

                                        // CounterUp Section
                                        var pct_counter1 = (parseInt(response.statusActive) / parseInt(response.statusTotal)) * 100;
                                        var pct_counter2 = (parseInt(response.statusInactive) / parseInt(response.statusTotal)) * 100;
                                        var pct_counter3 = (parseInt(response.statusInactiveMonth) / parseInt(response.statusTotal)) * 100;
                                        var pct_counter4 = (parseInt(response.statusTotal) / parseInt(response.statusTotal)) * 100;
                                        $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusActive+'"></span>');
                                        $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                                        $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                                        $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusInactive+'"></span>');
                                        $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                                        $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                                        $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusInactiveMonth+'"></span>');
                                        $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                                        $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                                        $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusTotal+'"></span>');
                                        $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                                        $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');
                                        
                                        $('.counterup').counterUp();
                                    } else {
                                        msg = "Error!"
                                    }

                                    $.bootstrapGrowl(msg,{
                                        ele:"body",
                                        type:"success",
                                        offset:{
                                            from:"top",
                                            amount:100
                                        },
                                        align:"right",
                                        width:250,
                                        delay:5000,
                                        allow_dismiss:1,
                                        stackup_spacing:10
                                    })
                                }
                            });
                        })
                    }
                }
            }();

            // Data Update
            var BtnUpdate=function(){
                return{
                    init:function(){
                        $("#btnUpdate_Supplier").click(function(event){
                            event.preventDefault();

                            formObj = $(this).parents().parents();
                            if (!formObj.validate().form()) return false;

                            var data = $('.modalUpdate').serialize()+'&btnUpdate_Supplier=btnUpdate_Supplier';
                            $.ajax({
                                url:'admin_2/function.php',
                                type:'post',
                                data:data,
                                dataType:'JSON',
                                success:function(response) {

                                    if ($.trim(response)) {
                                        msg = "Sucessfully Save!";

                                        var data = '<td>'+response.ID+'</td>';
                                        data += '<td>'+response.name+'</td>';
                                        data += '<td>'+response.address+'</td>';
                                        data += '<td>'+response.phone+'</td>';
                                        data += '<td>'+response.fax+'</td>';
                                        data += '<td>'+response.email+'</td>';
                                        data += '<td>'+response.website+'</td>';
                                        data += '<td>'+response.type+'</td>';

                                        if ( response.status == 1) {
                                            data += '<td><span class="label label-sm label-success">Active</span></td>';
                                        } else {
                                            data += '<td><span class="label label-sm label-danger">Inactive</span></td>';
                                        }
                                        
                                        data += '<td class="text-center"><a  class="btn dark btn-sm btn-outline sbold uppercase btnView" data-toggle="modal" href="#modalView" data-id="'+response.ID+'"><i class="fa fa-share"></i> View</a></td>';
                                        
                                        $('#tableData tbody #tr_'+response.ID).html(data);

                                        // CounterUp Section
                                        var pct_counter1 = (parseInt(response.statusActive) / parseInt(response.statusTotal)) * 100;
                                        var pct_counter2 = (parseInt(response.statusInactive) / parseInt(response.statusTotal)) * 100;
                                        var pct_counter3 = (parseInt(response.statusInactiveMonth) / parseInt(response.statusTotal)) * 100;
                                        var pct_counter4 = (parseInt(response.statusTotal) / parseInt(response.statusTotal)) * 100;
                                        $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusActive+'"></span>');
                                        $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                                        $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                                        $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusInactive+'"></span>');
                                        $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                                        $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                                        $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusInactiveMonth+'"></span>');
                                        $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                                        $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                                        $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusTotal+'"></span>');
                                        $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                                        $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');
                                        
                                        $('.counterup').counterUp();
                                    } else {
                                        msg = "Error!"
                                    }

                                    $.bootstrapGrowl(msg,{
                                        ele:"body",
                                        type:"success",
                                        offset:{
                                            from:"top",
                                            amount:100
                                        },
                                        align:"right",
                                        width:250,
                                        delay:5000,
                                        allow_dismiss:1,
                                        stackup_spacing:10
                                    })
                                }
                            });
                        })
                    }
                }
            }();

            // Data Fetch
            $(".btnView").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "admin_2/function.php?modalView_Supplier="+id,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalView .modal-body").html(data);
                        $(".make-switch").bootstrapSwitch();
                    }
                });
            });

            function addEmergency() {
                var FormRepeater=function(){
                    return{
                        init:function(){
                            $(".mt-repeater").each(function(){
                                $(this).repeater({
                                    show:function(){
                                        $(this).slideDown();
                                        emergency_counting();
                                    },
                                    hide:function(e){
                                        let text = "Are you sure you want to delete this row?";
                                        if (confirm(text) == true) {
                                            $(this).slideUp(e);
                                            setTimeout(function() { 
                                                emergency_counting()
                                            }, 500);
                                        }
                                    },
                                    ready:function(e){}
                                })
                            })
                        }
                    }
                }();
            }
        </script>

    </body>
</html>