<?php 
    $title = "Consultare FSMS";
    $site = "customer";

    include_once ('header.php'); 
?>


                    <div class="row">
                        <div class="col-md-3">
                            <div class="dashboard-stat2 ">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-green-sharp">
                                            <span data-counter="counterup" data-value="7800">0</span>
                                        </h3>
                                        <small>Total Active Customer</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-pie-chart"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: 76%;" class="progress-bar progress-bar-success green-sharp">
                                            <span class="sr-only">76% percentage</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title"> percentage </div>
                                        <div class="status-number"> 76% </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 ">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-red-haze">
                                            <span data-counter="counterup" data-value="1349">0</span>
                                        </h3>
                                        <small>Total Inactive Customer</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-pie-chart"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: 85%;" class="progress-bar progress-bar-success red-haze">
                                            <span class="sr-only">85% percentage</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title"> percentage </div>
                                        <div class="status-number"> 85% </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 ">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-red-haze">
                                            <span data-counter="counterup" data-value="1349">0</span>
                                        </h3>
                                        <small>Current Inactive Customer</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-pie-chart"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: 85%;" class="progress-bar progress-bar-success red-haze">
                                            <span class="sr-only">85% percentage</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title"> percentage for this current month </div>
                                        <div class="status-number"> 85% </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 ">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-blue-sharp">
                                            <span data-counter="counterup" data-value="567"></span>
                                        </h3>
                                        <small>TOTAL Customer</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-pie-chart"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: 45%;" class="progress-bar progress-bar-success blue-sharp">
                                            <span class="sr-only">45% percentage</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title"> percentage </div>
                                        <div class="status-number"> 45% </div>
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
                                        <i class="icon-bubble font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">List of Customer</span>
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
                                                    <th>Company Name</th>
                                                    <th>Address	</th>
                                                    <th>Phone</th>
                                                    <th>Fax</th>
                                                    <th>Email</th>
                                                    <th>Website</th>
                                                    <th>Emergency</th>
                                                    <th>Contact Person</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>XYZ Company</td>
                                                    <td>hidden ST. POPUP CITY </td>
                                                    <td>+0000 000 123</td>
                                                    <td>+0000 000 123</td>
                                                    <td>sample@gmail.com</td>
                                                    <td>website links</td>
                                                    <td>
                                                        <a class="btn btn-danger btn-sm btn-outline sbold uppercase btnView" data-toggle="modal" href="#modalNew" data-id="'. $row["ID"] .'">
                                                            <i class="fa fa-share"></i> View</a>
                                                    </td>
                                                    <td class="text-center">
                                                    <a class="btn dark btn-sm btn-outline sbold uppercase btnView" data-toggle="modal" href="#modalcontact" data-id="'. $row["ID"] .'">
                                                        <i class="fa fa-share"></i> View
                                                    </a>
                                                    </td>
                                                    <td><span class="label label-sm label-danger">Inactive</span></td>
                                                    </tr>

                                                    <tr>
                                                        <td>2</td>
                                                        <td>CBC Company</td>
                                                        <td>hidden ST. POPUP CITY </td>
                                                        <td>+000 123</td>
                                                        <td>+000 009</td>
                                                        <td>cbc@gmail.com</td>
                                                        <td>website links</td>
                                                        <td>
                                                            <a class="btn btn-danger btn-sm btn-outline sbold uppercase btnView" data-toggle="modal" href="#modalNew" data-id="'. $row["ID"] .'">
                                                                <i class="fa fa-share"></i> View</a>
                                                        </td>
                                                        <td class="text-center">
                                                        <a class="btn dark btn-sm btn-outline sbold uppercase btnView" data-toggle="modal" href="#modalcontact" data-id="'. $row["ID"] .'">
                                                            <i class="fa fa-share"></i> View
                                                        </a>
                                                        </td>
                                                        <td><span class="label label-sm label-danger">Inactive</span></td>
                                                        </tr>

                                                        <tr>
                                                            <td>3</td>
                                                            <td>ABC Company</td>
                                                            <td>street ST. cebu CITY </td>
                                                            <td>+0000 000 321</td>
                                                            <td>+0000 000 123</td>
                                                            <td>abc@gmail.com</td>
                                                            <td>website links</td>
                                                            <td>
                                                                <a class="btn btn-sm btn-outline btn-danger sbold uppercase btnView" data-toggle="modal" href="#modalNew" data-id="'. $row["ID"] .'">
                                                                    <i class="fa fa-share"></i> View</a>
                                                            </td>
                                                            <td class="text-center">
                                                            <a class="btn dark btn-sm btn-outline sbold uppercase btnView" data-toggle="modal" href="#modalcontact" data-id="'. $row["ID"] .'">
                                                                <i class="fa fa-share"></i> View
                                                            </a>
                                                            </td>
                                                            <td><span class="label label-sm label-success">Active</span></td>
                                                            </tr>
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
                                    <form method="post" class="form-horizontal modalSave">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Emergency  Contact Person(s)</h4>
                                        </div>
                                        <div class="modal-body"> 
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Name</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="email" name="email" id="email" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Title:</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="first_name" id="first_name" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Address</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="last_name" id="last_name" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Cell No.</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="" name="date_hired" id="date_hired" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Phone</label>
                                                <div class="col-md-8">
                                                        <input class="form-control" type="" name="date_hired" id="date_hired" required />
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Fax</label>
                                                <div class="col-md-8">
                                                        <input class="form-control" type="" name="date_hired" id="date_hired" required />
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email</label>
                                                <div class="col-md-8">
                                                            <input class="form-control" type="" name="date_hired" id="date_hired" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <input type="submit" class="btn green" name="" id="" value="Save" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade bs-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Customer Details</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                <label for="">Nae</label>
                                                <input type="text">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <input type="submit" class="btn green" name="" id="" value="Save" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- / END MODAL AREA -->

                          <!-- MODAL AREA-->
                          <div class="modal fade" id="modalcontact" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalSave">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Contact Person(s)</h4>
                                        </div>
                                        <div class="modal-body"> 
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Name</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="email" name="email" id="email" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Title:</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="first_name" id="first_name" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Address</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="last_name" id="last_name" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Cell No.</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="" name="date_hired" id="date_hired" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Phone</label>
                                                <div class="col-md-8">
                                                        <input class="form-control" type="" name="date_hired" id="date_hired" required />
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Fax</label>
                                                <div class="col-md-8">
                                                        <input class="form-control" type="" name="date_hired" id="date_hired" required />
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email</label>
                                                <div class="col-md-8">
                                                            <input class="form-control" type="" name="date_hired" id="date_hired" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <input type="submit" class="btn green" name="" id="" value="Save" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade bs-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Customer Details</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                <label for="">Nae</label>
                                                <input type="text">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <input type="submit" class="btn green" name="" id="" value="Save" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>

        <script>
            $('#username').editable();
        </script>
        
        <script type="text/javascript">
            // Data Save
            $(document).ready(function(){
                BtnSave.init()
                BtnUpdate.init()
                $(".modalForm").validate();
            });
            var BtnSave=function(){
                return{
                    init:function(){
                        $("#btnSave_HR_Employee").click(function(event){
                            event.preventDefault();

                            formObj = $(this).parents().parents();
                            if (!formObj.validate().form()) return false;

                            var data = $('.modalSave').serialize()+'&btnSave_HR_Employee=btnSave_HR_Employee';
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
                                        html += '<td>'+response.first_name+'</td>';
                                        html += '<td>'+response.last_name+'</td>';
                                        html += '<td>'+response.email+'</td>';
                                        html += '<td>'+response.date_hired+'</td>';
                                        html += '<td>0</td>';
                                        html += '<td>0</td>';
                                        html += '<td><span class="label label-sm label-success">Active</span></td>';
                                        html += '<td class="text-center"><a  class="btn dark btn-sm btn-outline sbold uppercase btnView" data-toggle="modal" href="#modalView" data-id="'+response.ID+'"><i class="fa fa-share"></i> View</a></td></tr>';
                                        html += '</tr>';

                                        $('#tableData tbody').append(html);
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
                    url: "admin_2/function.php?modalView_HR_Employee="+id,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalView .modal-body").html(data);
                        $(".make-switch").bootstrapSwitch();
                        $(function(){
                            $('.status').editable({
                                source: [
                                      {value: 0, text: 'Not Yet Started'},
                                      {value: 1, text: 'Approved'},
                                      {value: 2, text: 'For Approval'}
                                ],
                                success: function(response, newValue) {
                                    //userModel.set('username', newValue); //update backbone model
                                    if(response.status == 'error') return response.msg; //msg will be shown in editable form
                                }
                            });
                        });
                    }
                });
            });

            // Data Update
            var BtnUpdate=function(){
                return{
                    init:function(){
                        $("#btnUpdate_HR_Employee").click(function(event){
                            event.preventDefault();

                            formObj = $(this).parents().parents();
                            if (!formObj.validate().form()) return false;

                            var data = $('.modalUpdate').serialize()+'&btnUpdate_HR_Employee=btnUpdate_HR_Employee';
                            $.ajax({
                                url:'admin_2/function.php',
                                type:'post',
                                data:data,
                                dataType:'JSON',
                                success:function(response) {

                                    if ($.trim(response)) {
                                        msg = "Sucessfully Save!";

                                        var data = '<td>'+response.ID+'</td>';
                                        data += '<td>'+response.first_name+'</td>';
                                        data += '<td>'+response.last_name+'</td>';
                                        data += '<td>'+response.email+'</td>';
                                        data += '<td>'+response.date_hired+'</td>';
                                        data += '<td>0</td>';
                                        data += '<td>0</td>';

                                        if ( response.status == 1) {
                                            data += '<td><span class="label label-sm label-success">Active</span></td>';
                                        } else {
                                            data += '<td><span class="label label-sm label-danger">Inactive</span></td>';
                                        }
                                        
                                        data += '<td class="text-center"><a  class="btn dark btn-sm btn-outline sbold uppercase btnView" data-toggle="modal" href="#modalView" data-id="'+response.ID+'"><i class="fa fa-share"></i> View</a></td></tr>';
                                        
                                        $('#tableData tbody #tr_'+response.ID).html(data);

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
        </script>

    </body>
</html>