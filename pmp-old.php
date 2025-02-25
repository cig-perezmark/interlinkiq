<?php 
    $title = "Preventive Maintenance Program";
    $site = "pmp";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Preventivce Maintenance Program';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';
    $cookie = $_COOKIE['ID'];

    include_once 'database_pmp.php';
    include("header.php");
?>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN TAB PORTLET-->
        <div class="portlet light ">
            <div class="portlet-title tabbable-line">
                
                <ul class="nav nav-tabs tab-drop">
                    <li class="active">
                        <a href="#calendars" data-toggle="tab">Calendar</a>
                    </li>
                    <li>
                        <a href="#maintenance_checklist" data-toggle="tab">Maintenance Checklist</a>
                    </li>
                    <li>
                        <a href="#parts_register" data-toggle="tab">Parts Register </a>
                    </li>
                    <li >
                        <a href="#equipment_register" data-toggle="tab">Equipment Register </a>
                    </li>
                    <li >
                        <a href="#list_of_areas" data-toggle="tab">List of Areas </a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane mt-5 active" id="calendars">
                        <div id="pmp_calendar">
                            
                        </div>
                    </div>
                    <div class="tab-pane  mt-5" id="maintenance_checklist">
                        <label style="font-weight:600">Add Equipment and Parts to be maintain</label>
                        <div style="display:flex;justify-content:flex-end;margin-right:10px;margin-bottom:20px">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="<?php echo $FreeAccess == false ? '#add_maintenance':'#modalService'; ?>">Add Maintenance</button>
                        </div>
                        <table class="table table-bordered" id="sample_2">
                            <thead>
                                <tr>
                                    <th>Job No.</th>
                                    <th>Assignee</th>
                                    <th>Equiment Name</th>
                                    <th>Equiment Part Name</th>
                                    <th>Maintenance Schedule</th>
                                    <th>Status</th>
                                    <th>Maintenance Action</th>
                                    <th>Due Date Schedule</th>
                                    <?php
                                        if($FreeAccess == false) {
                                            echo '<th width="132px">Action</th>';
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $get= mysqli_query($pmp_connection,"SELECT * FROM parts_maintainance 
                                    INNER JOIN equipment_reg ON parts_maintainance.equipment_PK_id = equipment_reg.equip_id
                                    INNER JOIN equipment_parts ON parts_maintainance.equipment_parts_PK_id = equipment_parts.equipment_parts_id
                                    WHERE equipment_reg.enterprise_owner = '$cookie' OR  equipment_reg.enterprise_owner = '$switch_user_id'
                                    ");
            
                                    while($row=mysqli_fetch_assoc($get)) {
                                ?>
                                <tr>
                                    <td><?= $row['job_no'] ?></td>
                                    <td><?= $row['assignee'] ?></td>
                                    <td><?= $row['equipment'] ?></td>
                                    <td><?= $row['equipment_name'] ?></td>
                                    <td><?= $row['frequency'] ?></td>
                                    <?php 
                                        if($row['parts_status']=='OK') {
                                            echo '<td style="color:green; font-weight:500">'.$row['parts_status'].'</td>';
                                        } else {
                                            echo '<td style="color:red; font-weight:500;">'.$row['parts_status'].'</td>';
                                        }
                                    ?>
                                    <td><?= $row['remarks'] ?></td>
                                    <td>
                                        <?php if($row['parts_status'] == "OK"): ?>
                                            <?= $row['next_maintainance'] ?>
                                        <?php else: ?>
                                            <span style="color:red;font-weight:500">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <?php
                                        if($FreeAccess == false) {
                                            echo '<td>';
                                            
                                                if($row['parts_status'] == "OK") {
                                                    echo '<a class="btn btn-outline blue"  id="update_maintenance_checklist" equip_id="'.$row['equip_id'].'" equipment_parts_PK_id="'.$row['equipment_parts_PK_id'].'" image_name="'.$row['equipment_file'].'" maintenance_id="'.$row['equipment_parts_id'].'" parts_id="'.$row['parts_id'].'" part_name = "'.$row['equipment_name'].'" job_no="'.$row['job_no'].'" assignee="'.$row['assignee'].'" parts_status="'.$row['parts_status'].'" frequency="'.$row['frequency'].'" equipment_name="'.$row['equipment_name'].'"  equipment="'.$row['equipment'].'" last_date_performed="'.$row['last_date_performed'].'"  data-toggle="modal" data-target="#update_equipment">Update</a>
                                                    <a id="parts_history" equipment="'.$row['equipment'].'"  parts_id="'.$row['parts_id'].'"  data-toggle="modal" data-target="#maintenance_history" class="btn btn-outline green">Records</a>';
                                                } else {
                                                    echo '<a class="btn btn-outline blue"  id="update_maintenance_checklist" equip_id="'.$row['equip_id'].'" equipment_parts_PK_id="'.$row['equipment_parts_PK_id'].'" image_name="'.$row['equipment_file'].'" maintenance_id="'.$row['equipment_parts_id'].'" parts_id="'.$row['parts_id'].'" part_name = "'.$row['equipment_name'].'" job_no="'.$row['job_no'].'" assignee="'.$row['assignee'].'" parts_status="'.$row['parts_status'].'" frequency="'.$row['frequency'].'" equipment_name="'.$row['equipment_name'].'"  equipment="'.$row['equipment'].'" last_date_performed="'.$row['last_date_performed'].'" disabled>Update</a>
                                                    <a id="parts_history" equipment="'.$row['equipment'].'"  parts_id="'.$row['parts_id'].'"  data-toggle="modal" data-target="#maintenance_history" class="btn btn-outline green">Records</a>';
                                                }
                                            
                                            echo '</td>';
                                        }
                                    ?>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane mt-5" id="parts_register">
                        <div style="display:flex;justify-content:flex-end;margin-right:10px;margin-bottom:20px">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="<?php echo $FreeAccess == false ? '#add_parts':'#modalService'; ?>">Add Parts</button>
                        </div>
                        <table class="table table-bordered" id="sample_4">
                            <thead>
                                <tr>
                                    <th>Parts Name</th>
                                    <th>Serail #</th>
                                    <th>Model No.</th>
                                    <?php
                                        if($FreeAccess == false) {
                                            echo '<th width="112px">Action</th>';
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $get= mysqli_query($pmp_connection,"SELECT * FROM equipment_parts WHERE enterprise_owner = '$switch_user_id' OR enterprise_owner = '$cookie' ");
                                    while($row=mysqli_fetch_array($get)) {
                                ?>
                                <tr>
                                    <td><?= $row['equipment_name'] ?></td>
                                    <td><?= $row['parts_serail'] ?></td>
                                    <td><?= $row['parts_id_no'] ?></td>
                                    <?php
                                        if($FreeAccess == false) {
                                            echo '<td>
                                                <a class="btn btn-outline blue edit_equipment_parts" equipment_parts_id="'. $row['equipment_parts_id'] .'" data-toggle="modal" data-target="#edit_equipment_parts">Edit</a>
                                                <a class="btn btn-outline red">Delete</a>
                                            </td>';
                                        }
                                    ?>
                                    
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="equipment_register">
                        <div style="display:flex;justify-content:flex-end;margin-right:10px;margin-bottom:20px">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="<?php echo $FreeAccess == false ? '#addmodal':'#modalService'; ?>">Add Equipment</button>
                        </div>
                        <table class="table table-bordered" id="sample_1">
                            <thead>
                                <tr>
                                    <th>Equipment</th>
                                    <th>Serial #</th>
                                    <th>Equipment ID No.</th>
                                    <th>Location</th>
                                    <th>Parts to Maintain</th>
                                    <th>Process Owner</th>
                                    <th>Frequency</th>
                                    <th>Status</th>
                                    <?php
                                        if($FreeAccess == false) {
                                            echo '<th width="112px">Action</th>';
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    
                                    $get= mysqli_query($pmp_connection,"SELECT * FROM equipment_reg WHERE enterprise_owner = '$cookie' OR enterprise_owner = '$switch_user_id' ");
                                    while($row=mysqli_fetch_array($get)) {
                                ?>
                                <tr>
                                    <td><?= $row['equipment'] ?></td>
                                    <td><?= $row['serial_no'] ?></td>
                                    <td><?= $row['equip_id_no'] ?></td>
                                    <td><?= $row['location'] ?></td>
                                    <td><?= $row['parts_to_maintain'] ?></td>
                                    <td><?= $row['process_owner'] ?></td>
                                    <td><?= $row['freq_maintain'] ?></td>
                                    <?php 
                                    if($row['status']=='In Use') {
                                    ?>
                                        <td style='color:green; font-weight:500;'><?php echo $row['status']; ?></td>
                                    <?php
                                        }
                                        else if($row['status']=='Not In Use') {
                                    ?>
                                        <td style='color:blue; font-weight:500;'><?php echo $row['status']; ?></td>
                                    <?php
                                        }
                                        else if($row['status']=='Out of Service') {
                                    ?>
                                        <td style='color:red; font-weight:500;'><?php echo $row['status']; ?></td>
                                    <?php
                                        }
                                        else if($row['status']=='Clean') {
                                    ?>
                                        <td style='color:orange; font-weight:500;'><?php echo $row['status']; ?></td>
                                    <?php
                                        }
                                        else if($row['status']=='Soiled') {
                                    ?>
                                        <td style='color:brown; font-weight:500;'><?php echo $row['status']; ?></td>
                                    <?php
                                        }
                                        else {
                                    ?>
                                        <td style='color:yellow; font-weight:500;'><?php echo $row['status']; ?></td>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                        if($FreeAccess == false) {
                                            echo '<td>
                                                <a href="#edit" data-toggle="modal" equipment_id="'. $row['equip_id'] .'" class="btn btn-outline blue edit">Edit</a>
                                                <a class="btn btn-outline red">Delete</a>
                                            </td>';
                                        }
                                    ?>
                                    
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane  mt-5" id="list_of_areas">
                        <label style="font-weight:600">List of Areas</label>
                        <div style="display:flex;justify-content:flex-end;margin-right:10px;margin-bottom:20px">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="<?php echo $FreeAccess == false ? '#add_area':'#modalService'; ?>">Add Area</button>
                        </div>
                        <table class="table table-bordered" id="sample_2">
                            <thead>
                                <tr>
                                    <th>Area</th>
                                    <?php
                                        if($FreeAccess == false) {
                                            echo '<th width="132px">Action</th>';
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $get= mysqli_query($pmp_connection,"SELECT * FROM area_list 
                                    WHERE area_list.enterprise_owner = '$cookie' OR  area_list.enterprise_owner = '$switch_user_id'
                                    ");
            
                                    while($row=mysqli_fetch_assoc($get)) {
                                ?>
                                <tr>
                                    <td><?= $row['area_name'] ?></td>
                                    <?php
                                        if($FreeAccess == false) {
                                            echo '<td>
                                                <a class="btn btn-outline green">Update</a>
                                            </td>';
                                        }
                                    ?>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- END TAB PORTLET-->
    </div>
</div>



<?php include("footer.php") ?>
    
<!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
<!--END -->
<!--Modal Start-->
<!-- edit Modal Form-->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="EquipmentDetails" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-info" id="content">
            
            
        </div>
    </div>
</div>

 <!--ADD equipment Form-->
<div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="EquipmentDetails" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-info">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="EquipmentDetails">Equipment Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline:none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--Code Here-->
            <form action="controller.php" method="post" enctype="multipart/form-data">
                <script>
                    $(document).ready(function() {
                        var i = 1;
                        $('#add').click(function(){  
                           i++;  
                           $('#dynamic_field').append('<div class="mt-2" id="row'+i+'"><div class="col-md-6"> <label for="inputParts">Manual Name<span style="color:red">*</span></label><input type="text" name="manual_name[]" class="form-control"  ></div><div class="col-md-6"><label>Manual File<span style="color:red">*</span></label><input type="file" name="manual_file[]" class="form-control"  ></div></div>');  
                      }); 
                    });
                </script>
                <input type="hidden" name="enterprise_owner" value="<?= $switch_user_id ?>">
                <div id="add-modal-body" class="modal-body bg-white">
                    <div class="form-group">
                        <label>Equipment Image</label>
                        <input type="file" name="equipment_image" class="form-control"  >
                    </div>
                    <div class="form-group">
                        <label for="inputEquipment">Equipment Name <span style="color:red">*</span></label>
                        <input type="text" name="equipment" class="form-control"  >
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputSerial">Serial # <span style="color:red">*</span></label>
                            <input type="text" name="serial" class="form-control"  >
                        </div>
                        <div class="col-md-6">
                            <label for="inputEquipmentID">Equipment ID No. <span style="color:red">*</span></label>
                            <input type="text" name="equipmentid" class="form-control"  >
                        </div>
                    </div>
                    <div class="row" style="margin-top:5px">
                        <div class="col-md-12">
                            <label for="inputLocation">Location <span style="color:red">*</span></label>
                            <select name="location" class="form-control"  >
                            <?php
                                $get= mysqli_query($pmp_connection,"SELECT * FROM area_list WHERE  enterprise_owner = '$cookie' OR enterprise_owner = '$switch_user_id' ");
                                while($row=mysqli_fetch_array($get)) { ?>
                                    <option value="<?= $row['area_name'] ?>"><?= $row['area_name'] ?></option>
                            <?php } ?>
                        </select>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:5px">
                        <label for="inputProcessOwner">Assign to <span style="color:red">*</span></label>
                        <input type="text" name="processowner" class="form-control"  >
                    </div>
                    <div class="form-group">
                        <label for="inputFrequency">Frequency of Maintenance <span style="color:red">*</span></label>
                        <select name="freq" class="custom-select form-control"  >
                            <option value"">Choose...</option>
                            <option value="Daily">Daily</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Quarterly">Quarterly</option>
                            <option value="Semi-Annual">Semi-Annual</option>
                            <option value="Annual">Annual</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="inputSupplier">Supplier Vendor <span style="color:red">*</span></label>
                            <input type="text" name="supplier" class="form-control"  >
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputStatus">Status <span style="color:red">*</span></label>
                            <select name="status" class="custom-select form-control"  >
                                <option value"">Choose...</option>
                                <option value="In Use">In Use</option>
                                <option value="Not In Use">Not In Use</option>
                                <option value="Out of Service">Out of Service</option>
                                <option value="Clean">Clean</option>
                                <option value="Soiled">Soiled</option>
                                <option value="Calibrated">Calibrated</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row" id="dynamic_field" style="margin-top:15px">
                        <div class="col-md-12">
                            <label for="inputParts">Equipment Manual</label><i class="fa fa-plus" style="font-size:15px;color:green;cursor:pointer" id="add"></i>
                        </div>
                        <div class="inputs_container" >
                            <div class="col-md-6">
                                <label for="inputParts">Manual File Name<span style="color:red">*</span></label>
                                <input type="text" name="manual_name[]" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Manual File<span style="color:red">*</span></label>
                                <input type="file" name="manual_file[]" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-light shadow-none" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info shadow-none" id="submit_equipments" name="submit_equipments">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End add equipment-->

<!--Add equipment parts start-->
<div class="modal fade" id="add_parts" tabindex="-1" aria-labelledby="EquipmentDetails" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-info">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="EquipmentDetails">Parts Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline:none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--Code Here-->
            <form action="controller.php" method="post" enctype="multipart/form-data">
                <script>
                    $(document).ready(function() {
                        var i = 1;
                        $('#add1').click(function(){  
                           i++;  
                           $('#checklist').append('<input type="text" class="form-control mt-2" name="checklist[]" style="margin-top:10px">');  
                      }); 
                      
                      $('#add_manual').click(function(){  
                           i++;  
                           $('#dynamic_field1').append('<div class="mt-2" id="row'+i+'"><div class="col-md-6"> <label for="inputParts">Manual Name<span style="color:red">*</span></label><input type="text" name="manual_name[]" class="form-control"  ></div><div class="col-md-6"><label>Manual File<span style="color:red">*</span></label><input type="file" name="manual_file[]" class="form-control"  ></div></div>');  
                      }); 
                    });
                </script>
                <input type="hidden" name="enterprise_owner" value="<?= $switch_user_id ?>">
                <div id="add-modal-body" class="modal-body bg-white">
                    <div class="form-group">
                        <label>Equipment Parts Image <span style="color:red">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="equipment_file" class="form-control"  >
                        </div>
                    </div>
                    <div class="row" id="dynamic_field1">
                        <div class="col-md-12">
                            <label for="inputParts">Parts Manual</label><i class="fa fa-plus" style="font-size:15px;color:green;cursor:pointer" id="add_manual"></i>
                        </div>
                        <div class="inputs_container" >
                            <div class="col-md-6">
                                <label for="inputParts">Manual File Name<span style="color:red">*</span></label>
                                <input type="text" name="manual_name[]" class="form-control"  >
                            </div>
                            <div class="col-md-6">
                                <label>Manual File<span style="color:red">*</span></label>
                                <input type="file" name="manual_file[]" class="form-control"  >
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <hr>
                        <label for="inputEquipment">Equipment Parts Name <span style="color:red">*</span></label>
                        <input type="text" name="equipment_parts_name" class="form-control"  >
                    </div>
                    <div class="form-group">
                        <label for="inputEquipment">Equipment Parts Supplier<span style="color:red">*</span></label>
                        <input type="text" name="parts_supplier" class="form-control"  >
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputSerial">Serial # <span style="color:red">*</span></label>
                            <input type="text" name="parts_serail" class="form-control"  >
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEquipmentID">Equipment Part Model No. <span style="color:red">*</span></label>
                            <input type="text" name="parts_id_no" class="form-control"  >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputFrequency">Assign Equipment Part Owner <span style="color:red">*</span></label>
                        <select name="equipment_name[]" class="form-control mt-multiselect btn btn-default"  multiple data-live-search="true"  >
                            <?php
                                $get= mysqli_query($pmp_connection,"SELECT * FROM equipment_reg WHERE  enterprise_owner = '$cookie' OR enterprise_owner = '$switch_user_id' ");
                                while($row=mysqli_fetch_array($get)) { ?>
                                    <option value="<?= $row['equip_id'] ?>"><?= $row['equipment'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group" id="checklist">
                        <label for="inputFrequency">Parts Checklist<span style="color:red">*</span></label><i class="fa fa-plus ml-4" style="font-size:15px;color:green;cursor:pointer" id="add1"></i>
                        <input type="text" name="checklist[]" class="form-control" style="margin-top:10px"  >
                    </div>
                </div>
                
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-light shadow-none" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info shadow-none " name="save_equipment_parts">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Add Equipment parts end-->

<!--Edit Equipment parts start-->
<div class="modal fade" id="edit_equipment_parts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Parts Information(Underdevelopment)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="equipment_parts_details">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" disabled>Update</button>
      </div>
    </div>
  </div>
</div>
<!--Edit Equipment parts end-->

<!--Add maintenance start-->
<div class="modal fade" id="add_maintenance" tabindex="-1" aria-labelledby="EquipmentDetails" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-info">
            <div class="modal-header">
                <h5 class="modal-title text-white">Maintenance Checklist </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline:none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--Code Here-->
            <form action="controller.php" method="post">
                <div id="add-modal-body" class="modal-body bg-white">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="inputJob">Job No. <span style="color:red">*</span></label>
                            <input type="text" name="job_no" class="form-control" required  >
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEngineer">Assignee <span style="color:red">*</span></label>
                            <select id="assignee" name="assignee" class="custom-select form-control"  >
                                <option disabled selected>Choose...</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDate">Last Date Performed <span style="color:red">*</span></label>
                        <input type="date" name="last_date_performed" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputEquipment">Equipment Name <span style="color:red">*</span></label>
                        <select name="equipment_PK_id" id="select_parts" class="custom-select form-control" required >
                            <option disabled selected>Choose...</option>
                            <?php
                                $get_equip=mysqli_query($pmp_connection,"SELECT * FROM equipment_reg WHERE enterprise_owner = '$switch_user_id' OR enterprise_owner = '$cookie'");
                                
                                while ($row=mysqli_fetch_array($get_equip)) {
                            ?>
                                <option equipment_id="<?= $row['equip_id'] ?>" value="<?php echo $row['equip_id']; ?>"><?php echo $row['equipment']; ?></option> 
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mt-3" >
                        <labe>Equipment parts to be maintain</labe>
                        <select name="equipment_parts_PK_id" id="equipment_parts" class="custom-select form-control" required  >
                            <!--<option>Choose...</option>-->
                            <!--<option>Choose...</option>-->
                        </select>
                    </div>
                    <div class="form-group mt-3" id="checklists" >
                        <labe>Equipment parts checklist</labe><br><br> 
                    </div>
                    <div class="form-group">
                        <label for="inputDate">Type of activity <span style="color:red">*</span></label>
                        <input type="text" name="type_of_activity" class="form-control"required  >
                    </div>
                    <div class="form-group">
                        <label for="inputDate">Description <span style="color:red">*</span></label>
                        <textarea name="description" class="form-control" style="height:70px" required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="inputFrequency">Next Maintenance Schedule <span style="color:red">*</span></label>
                            <input type="date" name="next_maintainance" class="form-control" required >
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputFrequency">Frequency of Maintenance</label>
                            <select id="inputFrequency" name="frequency" class="custom-select form-control" required >
                                <option selected>Choose...</option>
                                <option value="Daily">Daily</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Quarterly">Quarterly</option>
                                <option value="Semi-Annual">Semi-Annual</option>
                                <option value="Annual">Annual</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAction">Remarks <span style="color:red">*</span></label>
                        <textarea class="form-control" rows="5" name="remarks" required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-light shadow-none" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info shadow-none " name="save_maintainance">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
                
<!--Add maintenance end-->

<!--Update Maintenance Start-->

<div class="modal fade" id="maintenance_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">MAINTENANCE CHECKLIST HISTORY</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="dt" class="table table-borderless table-striped table-hover" width="100%">
            <thead>
                <tr>
                    <th>Part Name</th>
                    <th>Part Status</th>
                    <th>Performed Date</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody id="maintenance_history_table">
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--Update Maintenance end-->

<form action="controller.php" method="POST">
    <div class="modal fade" id="update_equipment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content ">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">EDIT MAINTENANCE CHECKLIST</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row" style="margin-left:7px">
                <label>Parts image</label>
                <div class="col-md-12">
                    <img id="my_image"  style="width:170px;margin-left:5px" >
                </div>
              </div>
             <div class="row mt-3" style="margin-top:15px">
                <div class="col-md-6">
                    <label>Parts Name</label>
                    <input type="hidden" id="equipment_parts_PK_id" name="equipment_parts_PK_id">
                    <input type="text" class="form-control" id="part_name" name="" readonly>
                    <input type="hidden" class="form-control" id="PK_id" name="PK_id">
                    <input type="hidden" class="form-control" id="equip_id" name="equip_id">
                    
                </div>
                <div class="col-md-6">
                    <label>Equipment Name</label>
                    <input type="text" class="form-control" id="equipment" name="history_equipment_name" readonly>
                </div>
            </div>
            <div class="row mt-3" style="margin-top:15px">
                <div class="col-md-6">
                    <label>Job no.</label>
                    <input type="text" class="form-control" id="job_no" name="" readonly>
                </div>
                <div class="col-md-6">
                    <label>Assigned to</label>
                    <input type="text" class="form-control" id="assignee" name="" readonly>
                </div>
            </div>
            <div class="row mt-3" style="margin-top:15px">
                <div class="col-md-6">
                    <label>Last Date Performed</label>
                    <input type="text" class="form-control" id="last_date_performed" name="" readonly>
                </div>
                <div class="col-md-6">
                    <label>Maintenance Frequency</label>
                    <input type="text" class="form-control" id="frequency" name="" readonly>
                </div>
            </div>
            <div class="row" id="check_list_container">
                    
            </div>
            <div class="row mt-3" style="margin-top:15px">
                <div class="col-md-6">
                    <label>Date</label>
                    <input type="date" class="form-control" name="date_performed">
                </div>
                <div class="col-md-6">
                    <label>Status</label>
                    <select class="form-control" id="parts_status" name="parts_status">
                        <option value="OK">OK</option>
                        <option value="DEFECT">Defect</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3" style="margin-top:15px">
                <div class="col-md-6">
                    <label>Remarks</label>
                    <textarea class="form-control" name="parts_remarks" style="height:70px"></textarea>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="save_new_maintenance" class="btn btn-info shadow-none">Update</button>
          </div>
        </div>
      </div>
    </div>
</form>
<!--Update Maintenance End-->

<!--Show Maintenance History Details Start-->

<div class="modal fade" id="show_maintenance_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">MAINTENANCE CHECKLIST HISTORY DETAILS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="maintenance_check_list_history_details">
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!--Show Maintenance History Details End-->

<!--Show parts details start-->
<form method="POST" action="controller.php">
    <div class="modal fade" id="change_parts" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content ">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">CHANGE PARTS</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="show_parts_details">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="update_change_parts" class="btn btn-info shadow-none">Update</button>
          </div>
        </div>
      </div>
    </div>
</form>
<!--Show parts details end-->

<!--Show new parts start-->
<form method="POST" action="controller.php">
    <div class="modal fade" id="new_parts" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content ">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">CHANGE PARTS</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" >
            <div class="row">
                <div class="col-md-6">
                    <label>Parts List</label>
                    <input type="hidden" id="equipment_parts_pk_id" name="old_equipment_parts">
                    <input type="hidden" id="equipment_PK_id" name="equipment_PK_id">
                    <select class="form-control" name="equip_id_parts">
                        <?php
                            $get_equip=mysqli_query($pmp_connection,"SELECT DISTINCT parts_PK_id,equipment_parts_id,equipment_name FROM equipment_parts_owned 
                            INNER JOIN equipment_reg ON equipment_reg.equip_id = equipment_parts_owned.equipment_parts_owned_name
                            INNER JOIN equipment_parts ON equipment_parts_owned.parts_PK_id = equipment_parts.equipment_parts_id
                            WHERE equipment_reg.enterprise_owner = '$switch_user_id' OR equipment_reg.enterprise_owner = '$cookie' ");
                            while ($row=mysqli_fetch_array($get_equip)) {
                        ?>
                            <option value="<?php echo $row['equipment_parts_id']; ?>"><?php echo $row['equipment_name']; ?></option> 
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" style="margin-top:15px;">
                    <label>Remarks</label>
                    <textarea class="form-control" name="remarks" style="height:70px"></textarea>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="update_new_change_parts" class="btn btn-info shadow-none">Update</button>
          </div>
        </div>
      </div>
    </div>
</form>
<!--Show new parts end-->

<!--add new parts details start-->

<form method="POST" action="controller.php">
    <div class="modal fade" id="add_parts_to_equipment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content ">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">ADD PARTS TO EQUIPMENT</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="">
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" id="new_parts_id" name="parts_id">
                    <label>Equipment Name</label>
                    <select class="form-control" name="equip_id">
                        <?php
                            $get_equip=mysqli_query($pmp_connection,"SELECT * FROM equipment_reg WHERE enterprise_owner = '$switch_user_id' OR enterprise_owner = '$cookie' ");
                            while ($row=mysqli_fetch_array($get_equip)) {
                        ?>
                            <option equipment_id="<?= $row['equip_id'] ?>" value="<?php echo $row['equip_id']; ?>"><?php echo $row['equipment']; ?></option> 
                        <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="add_new_parts" class="btn btn-info shadow-none">Update</button>
          </div>
        </div>
      </div>
    </div>
</form>
<!--add new parts details end-->

<!-- Edit Modal -->
<div class="modal fade" id="schedule-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Your Schedule</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Schedule Name:</label>
                        <input type="text" class="form-control">
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success">Save Your Schedule</button>
            </div>
        </div>
    </div>
</div>

<!--Add Area-->
<form method="POST" action="controller.php">
<div class="modal fade" id="add_area" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Area</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <label>Area Name</label>
            <input type="text" name="area_name" class="form-control">
            <input type="hidden" name="enterprise_owner" value="<?= $switch_user_id ?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="save_area">Save</button>
      </div>
    </div>
  </div>
</div>
<!--Add Area end-->
</form>

<!--Modal End-->
<script>
    $(document).ready(function(){
        var calendar = $('#pmp_calendar').fullCalendar({
            editable:true,
            header:{
                left:'prev,next today',
                center:'title',
                right:'month,agendaWeek,agendaDay'
            },
            events:'fetch-event.php',
            editable:true,
            eventDrop:function(event){
                // alert(event.title + " was dropped on " + event.start.toISOString());
        
                var start = event.start.toISOString();
                // var end = event.end.toISOString();
                var title = event.title;
                var equipment_parts_PK_id = event.equipment_parts_PK_id;
                var id = event.id;
                $.ajax({
                    url:"pmp_old/update.php",
                    type:"POST",
                    data:{
                        title:title,
                        start:start,
                        equipment_parts_PK_id:equipment_parts_PK_id,
                        id:id
                    },
                    success:function(data){
                        calendar.fullCalendar('refetchEvents');
                         //console.log('done : ' + data);
                    }
                });
                
            },
            eventClick:  function(event) {
                var modal = $("#schedule-edit");
                modal.modal();
            },
        });
        
        // $('#submit_equipments').click(function(e){
        //     e.preventDefault();
        // });
        $('.edit').click(function(){
            var equipment_id =  ($(this).attr('equipment_id'));
           $.get("controller.php", 
            {
                equipment_id: equipment_id,
                action:"view_equipment"
            },
              function(data){
                // Display the returned data in browser
                $('#content').html(data);
               // console.log('done : ' + data);  
            }); 
        });
        
        $(document).on('click', '.edit_equipment_parts', function() {
            var equipment_parts_id = $(this).attr('equipment_parts_id');
            var action = "get_equipment_parts_details";
            $.get("controller.php", 
            {
                equipment_parts_id: equipment_parts_id,
                action:action
            },
            function(data){
                // Display the returned data in browser
            $('#equipment_parts_details').html(data);
            //console.log('done : ' + data);
            });
            
        });
        
        $(document).on('change','#equipment_parts',function(){
            var parts_PK_id = $('option:selected', this).attr('parts_PK_id');
            var action = "get_parts_checklist";
            
            $.get("controller.php", 
            {
                parts_PK_id: parts_PK_id,
                action:action
            },
            function(data){
                // Display the returned data in browser
                 $('#checklists').html(data);
                 //console.log('done : ' + data);
            });
        });
        
        $(document).on('change','#select_parts',function(){
            var equipment_id = $('option:selected', this).attr('equipment_id');
            var action = "get_equipment_parts";
            
            $.get("controller.php", 
            {
                equipment_id: equipment_id,
                action:action
            },
            function(data){
                // Display the returned data in browser
                 $('#equipment_parts').html(data);
                // console.log('done : ' + data);
            });
        });
        
        $(document).on('click', '[id*="update_maintenance_checklist"]', function() {
           var equipment_parts_PK_id = $(this).attr('equipment_parts_PK_id');
           var job_no = $(this).attr('job_no');
           var assignee = $(this).attr('assignee');
           var parts_status = $(this).attr('parts_status');
           var frequency = $(this).attr('frequency');
           var equipment_name = $(this).attr('equipment_name');
           var equipment = $(this).attr('equipment');
           var last_date_performed = $(this).attr('last_date_performed');
           var part_name = $(this).attr('part_name');
           var parts_id = $(this).attr('parts_id');
           var maintenance_id = $(this).attr('maintenance_id');
           var equip_id = $(this).attr('equip_id');
           
           $('#job_no').val(job_no);
           $('#assignee').val(assignee);
           $('#parts_status').val(parts_status);
           $('#frequency').val(frequency);
           $('#equipment_name').val(equipment_name);
           $('#equipment').val(equipment);
           $('#part_name').val(part_name);
           $('#last_date_performed').val(last_date_performed);
           $('#PK_id').val(parts_id);
           $('#equipment_parts_PK_id').val(equipment_parts_PK_id);
           $("#parts_status option[value="+parts_status+"]").attr('selected','selected');
           $('#equip_id').val(equip_id);
           var pic_name = $(this).attr('image_name')
           $('#my_image').attr('src','uploads/pmp/'+pic_name+'');
           
            
           var action = "get_checklist";
            $.get("controller.php", 
            {
                maintenance_id: maintenance_id,
                action:action
            },
            function(data){
                // Display the returned data in browser
                $('#check_list_container').html(data);
            });
        });
        $(document).on('click', '[id*="parts_history"]', function() {
        var equipment = $(this).attr('equipment');
        var parts_id = $(this).attr('parts_id');
        var action = "get_parts_history";
            $.get("controller.php", 
            {
                parts_id: parts_id,
                equipment:equipment,
                action:action
            },
            function(data){
                // Display the returned data in browser
                $('#maintenance_history_table').html(data);
                
            });
        });
        $(document).on('click', '[class*="show_maintenance_history"]', function() {
            var maintenance_id = $(this).attr('maintenance_id');
           // alert(maintenance_id);
            $.get("controller.php", 
            {
                maintenance_id: maintenance_id,
                action:"get_maintenance_history_details"
            },
            function(data){
                // Display the returned data in browser
                $('#maintenance_check_list_history_details').html(data);
                //console.log(data);
                
            });
        });
        
        $(document).on('click', '[id*="update_equipment_parts"]', function() {
            var parts_id = $(this).attr('parts_id');
            var parts_status_value = $(this).attr('parts_status_value');
            
            $.get("controller.php", 
            {
                parts_id: parts_id,
                action:"show_change_parts"
            },
            function(data){
                // Display the returned data in browser
                $('#show_parts_details').html(data);
                //console.log(data);
                $("#parts_status_drop option[value="+parts_status_value+"]").attr('selected','selected');
            });
        });
        $(document).on('click', '[class*="add_parts_to_equipment"]', function() {
            var parts_id = $(this).attr('parts_id');
            $('#new_parts_id').val(parts_id);
        });
        $(document).on('click', '[class*="new_parts"]', function() {
            var equipment_PK_id = $(this).attr('equipment_PK_id');
            var equipment_parts_pk_id = $(this).attr('equipment_parts_pk_id');
            
            $('#equipment_parts_pk_id').val(equipment_parts_pk_id);
            $('#equipment_PK_id').val(equipment_PK_id);
            
        });
    });
</script>
    </body>
</html>
