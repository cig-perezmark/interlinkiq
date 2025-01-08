<!-- Add New-->
<div class="modal fade" id="addNew_complaint" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm addNew_complaint">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <!--<h4 class="modal-title">Complaint Management Program</h4>-->
                </div>
                <div class="modal-body">
                    <center><h4><b>CUSTOMER COMPLAINT REPORT</b></h4></center>
                    <div class="form-group">
                        <div class="col-md-6">
                           <label>Date:</label>
                           <input type="date" class="form-control" name="care_date" value="<?= date('Y-m-d', strtotime(date('Y-m-d')));?>" required>
                       </div>
                        <div class="col-md-6">
                           <label>Date and Time of Incident:</label>
                           <input type="datetime-local" class="form-control" name="care_date_time" required>
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-12">
                           <label>Customer Email:</label>
                           <input type="email" class="form-control" name="cusEmail" required>
                       </div>
                   </div>
                    <div class="form-group">
                        <div class="col-md-6">
                           <label>Customer Name:</label>
                           <input type="text" class="form-control" name="cusName" required>
                       </div>
                       <div class="col-md-6">
                           <label>Customer Phone#:</label>
                           <input type="" class="form-control" name="phoneNo" >
                       </div>
                   </div>
                    <div class="form-group">
                        <div class="col-md-12">
                           <label>Customer Address:</label>
                           <input class="form-control" type="" name="cusAddress" required>
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-6">
                           <label>Product Name:</label>
                           <input class="form-control" type="" name="product_name" required>
                       </div>
                       <div class="col-md-6">
                           <label>Product Description:</label>
                           <textarea class="form-control" type="" name="product_description" required></textarea>
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-6">
                           <label>Product Code:</label>
                           <input type="text" class="form-control" name="product_code" >
                       </div>
                        <div class="col-md-6">
                           <label>Package ID:</label>
                           <input type="text" class="form-control" name="METRC_package_id" >
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-6">
                           <label>Lot Code/Batch#:</label>
                           <input type="text" class="form-control" name="lot_code" >
                       </div>
                        <div class="col-md-6">
                           <label>Product Purchase Location:</label>
                           <input class="form-control" type="" name="product_purchase_location">
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-6">
                           <label>Product Purchased Date:</label>
                           <input class="form-control" type="date" name="product_purchased_date" value="<?= date('Y-m-d', strtotime(date('Y-m-d')));?>">
                       </div>
                       <div class="col-md-6">
                           <label>Remarks:</label>
                           <textarea class="form-control" name="product_purchased_date_remarks"></textarea>
                       </div>
                   </div>
                   <div class="form-group">
                       <div class="col-md-6">
                           <label>Product Expiration Date:</label>
                           <input type="date" class="form-control" name="product_expiry" value="<?= date('Y-m-d', strtotime(date('Y-m-d')));?>">
                       </div>
                       <div class="col-md-6">
                           <label>Remarks:</label>
                           <textarea class="form-control" name="product_expiry_remarks"></textarea>
                       </div>
                   </div>
                   
                   <div class="form-group">
                       <div class="col-md-6">
                           <label>Complaint Type:</label>
                           <select class="form-control" name="complaint_type" onchange="if(this.options[this.selectedIndex].value=='customOption'){toggleField(this, 1);}">
                               <option value="0">--Select--</option>
                               <option value="1">Electronic (Email)</option>
                               <option value="2">Electronic (Social Media)</option>
                               <option value="3">Oral</option>
                               <option value="4">Written</option>
                                <option value="customOption">[Others]</option>
                           </select>
                           <input class="form-control hide" name="complaint_type_other" onblur="if(this.value==''){toggleField(this, 0);}">
                       </div>
                       <div class="col-md-6">
                           <label>Complaint Category:</label>
                           <select class="form-control" name="complaint_category" onchange="if(this.options[this.selectedIndex].value=='customOption'){toggleField(this, 1);}">
                               <option value="0">--Select--</option>
                               <option value="1">Caused Illness or Injury</option>
                               <option value="2">Foreign Material in Cannabis Product Container</option>
                               <option value="3">Foul Odor</option>
                               <option value="4">Defective or Damaged Packaging</option>
                               <option value="6">Mislabeling</option>
                                <option value="customOption">[Others]</option>
                           </select>
                           <input class="form-control hide" name="complaint_category_other" onblur="if(this.value==''){toggleField(this, 0);}">
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-12">
                           <label>Description of the Complaint:</label>
                           <textarea class="form-control" type="" name="nature_complaint" rows="3"></textarea>
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-12">
                           <label>Reply to Customer:</label>
                           <textarea class="form-control" type="" name="reply_to_customer" rows="3"></textarea>
                       </div>
                   </div>
                   
                   <div class="form-group">
                        <div class="col-md-12">
                           <label>Reply Type:</label>
                            <select class="form-control" name="reply_type" onchange="if(this.options[this.selectedIndex].value=='customOption'){toggleField(this, 1);}">
                                <option value="0">---Select---</option>
                                <option value="1">Electronic (Email)</option>
                                <option value="2">Electronic (Social Media)</option>
                                <option value="3">Phone</option>
                                <option value="4">Written</option>
                                <option value="customOption">[Others]</option>
                            </select>
                           <input class="form-control hide" name="reply_type_other" onblur="if(this.value==''){toggleField(this, 0);}">
                       </div>
                   </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Person Contacted:</label>
                            <select class="form-control" type="" name="person_contacted" onchange="if(this.options[this.selectedIndex].value=='customOption'){toggleField(this, 1);}">
                                <option value="">---Select---</option>
                                <?php
                                    $handler = mysqli_query($conn, "select * from tbl_hr_employee where user_id = '$switch_user_id' ORDER BY first_name ASC");
                                    foreach($handler as $row){
                                        echo '<option value="'.$row['ID'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
                                    }
                                ?>
                                <option value="customOption">[Others]</option>
                            </select>
                           <input class="form-control hide" name="person_contacted_other" onblur="if(this.value==''){toggleField(this, 0);}">
                        </div>
                        <div class="col-md-6">
                            <label>Person Handling the Complaint:</label>
                            <select class="form-control" type="" name="person_handling" onchange="if(this.options[this.selectedIndex].value=='customOption'){toggleField(this, 1);}">
                                <option value="">---Select---</option>
                                <?php
                                    $handler = mysqli_query($conn, "select * from tbl_hr_employee where user_id = '$switch_user_id' ORDER BY first_name ASC");
                                    foreach($handler as $row){
                                        echo '<option value="'.$row['ID'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
                                    }
                                ?>
                                <option value="customOption">[Others]</option>
                            </select>
                           <input class="form-control hide" name="person_handling_other" onblur="if(this.value==''){toggleField(this, 0);}">
                        </div>
                    </div>
                   <div class="form-group">
                       <div class="col-md-12">
                           <label>
                           <input type="checkbox" name="investigation_started" value="1">&nbsp;
                           Investigation Started</label>
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-6">
                           <label>Action(s) taken to prevent this from re-occurring:</label>
                           <textarea class="form-control" type="" name="action_taken"></textarea>
                       </div>
                        <div class="col-md-6">
                           <label>Resolution Document:</label>
                           <select class="form-control valid" name="filetype2" onchange="changeType(this)" required="" aria-required="true" aria-invalid="false">
                                <option value="0">Select option</option>
                                <option value="1">Manual Upload</option>
                                <option value="2">Youtube URL</option>
                                <option value="3">Google Drive URL</option>
                            </select>
                            <input class="form-control margin-top-15 fileUpload" type="file" name="file2" style="display: none;">
                            <input class="form-control margin-top-15 fileURL" type="url" name="fileurl2" style="display: none;" placeholder="https://">
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-6">
                           <label>Date of Acknowledgement:</label>
                           <input class="form-control" type="date" name="date_of_acknowledgement" value="<?= date('Y-m-d', strtotime(date('Y-m-d')));?>">
                       </div>
                        <div class="col-md-6">
                           <label>Date of Resolution:</label>
                           <input class="form-control" type="date" name="date_resolution" value="<?= date('Y-m-d', strtotime(date('Y-m-d')));?>">
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-6">
                           <label>Resolution Description:</label>
                           <textarea class="form-control" type="" name="resolution_desc" rows="3"></textarea>
                       </div>
                        <div class="col-md-6">
                           <label>Resolution Document:</label>
                           <select class="form-control valid" name="filetype" onchange="changeType(this)" required="" aria-required="true" aria-invalid="false">
                                <option value="0">Select option</option>
                                <option value="1">Manual Upload</option>
                                <option value="2">Youtube URL</option>
                                <option value="3">Google Drive URL</option>
                            </select>
                            <input class="form-control margin-top-15 fileUpload" type="file" name="file" style="display: none;">
                            <input class="form-control margin-top-15 fileURL" type="url" name="fileurl" style="display: none;" placeholder="https://">
                       </div>
                   </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="btnAdd_new" id="btnAdd_new" value="Save" class="btn btn-info">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Complaint -->
<div class="modal fade" id="modal_update_complaint" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_update_complaint">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <!--<h4 class="modal-title">Customer Complait Report Details</h4>-->
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="submit" name="btnSave_complaint" id="btnSave_complaint" value="Update" class="btn btn-info">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- delete Complaint -->
<div class="modal fade" id="modal_delete_complaint" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_delete_complaint">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Are You sure You want to delete the details below?</h4>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <input type="submit" name="btndelete_complaint" id="btndelete_complaint" value="Delete" class="btn red">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- capa -->
<div class="modal fade" id="modal_capa" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_capa">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <center><h4 class="modal-title"><b>INVESTIGATION CORRECTIVE ACTION REPORT</b></h4></center>
                </div>
                <div class="modal-body">
                   
                </div>
                <div class="modal-footer">
                    <input type="submit" name="btnSave_capa" id="btnSave_capa" value="Save" class="btn btn-info">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- scar -->
<div class="modal fade" id="modal_scar" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_scar">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <center><h4 class="modal-title"><b>Supplier Corrective Action Request (SCAR)<br>CUSTOMER SERVICE USE ONLY</b></h4></center>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <input type="submit" name="btnSave_scar" id="btnSave_scar" value="Save" class="btn btn-info">
                </div>
            </form>
        </div>
    </div>
</div>