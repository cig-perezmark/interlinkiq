 <!-- add new -->
<div class="modal fade" id="modalAdd_details" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalAdd_details">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Jobs Post</h4>
                </div>
                <div class="modal-body">
                   <div class="form-group">
                       <div class="col-md-12">
                           <label>Jobs Title</label>
                           <input class="form-control" name="jobs_name">
                       </div>
                   </div>
                   <div class="form-group">
                       <div class="col-md-12">
                           <label>Candidates</label>
                           <select class="form-control mt-multiselect btn btn-default" type="text" name="candidates_pk[]" multiple>
                              
                                <?php
                                    $queryPres = "SELECT * FROM tbl_hr_crm_jobs_candidates where ownedby = $switch_user_id and is_hired = 0 order by full_name ASC";
                                    $resultPres = mysqli_query($conn, $queryPres);
                                    while($rowPres = mysqli_fetch_array($resultPres))
                                    { 
                                       echo '<option value="'.$rowPres['candidates_id'].'">'.$rowPres['full_name'].'</option>'; 
                                    }
                                 ?>
                                <option value="0">---Others---</option>
                            </select>
                       </div>
                   </div>
                   <div class="form-group">
                       <div class="col-md-6">
                           <label>Category</label>
                           <select class="form-control" name="jobs_category_pk">
                               <option value="0">---Select---</option>
                               <?php
                                    $query_subs = mysqli_query($conn,"select * from tbl_hr_crm_category where cat_ownedby = '$current_userEmployerID' order by category_name ASC");
                                    foreach($query_subs as $row_subs){?>
                                        <option value="<?= $row_subs['category_pk']; ?>"><?= $row_subs['category_name'];?></option>
                                    <?php } ?>
                               ?>
                           </select>
                       </div>
                       <div class="col-md-6">
                           <label>Status</label>
                           <select class="form-control" name="is_active">
                               <option value="0">Active</option>
                               <option value="1">In-Active</option>
                           </select>
                       </div>
                   </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnNew_added" id="btnNew_added" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Update Jobs-->
<div class="modal fade" id="modal_update_status" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_update_status">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Job Post Details</h4>
                </div>
                <div class="modal-body">
                   
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                   <input class="btn btn-info" type="submit" name="btnSave_status" id="btnSave_status" value="Save" >
                </div>
            </form>
        </div>
    </div>
</div>

 <!-- add new candidate-->
<div class="modal fade" id="modalAdd_candidate" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalAdd_candidate">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Candidate</h4>
                </div>
                <div class="modal-body">
                   <div class="form-group">
                          <div class="col-md-12">
                              <label>Name</label>
                              <input class="form-control" name="full_name" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-md-12">
                              <label>Email</label>
                              <input class="form-control" name="email" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-md-6">
                              <label>Status</label>
                              <select class="form-control" name="is_hired">
                                  <option value="0">Open</option>
                                  <option value="1">Hired</option>
                              </select>
                          </div>
                          <div class="col-md-6">
                              <label>Status</label>
                              <input class="form-control" type="date" name="invitation_date">
                          </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnNew_candidate" id="btnNew_candidate" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Update Candidates-->
<div class="modal fade" id="modal_update_candidates" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_update_candidates">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Candidate Details</h4>
                </div>
                <div class="modal-body">
                   
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                   <input class="btn btn-info" type="submit" name="btnSave_candidate" id="btnSave_candidate" value="Save" >
                </div>
            </form>
        </div>
    </div>
</div>

<!--delete Candidates-->
<div class="modal fade" id="modal_delete_candidates" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_delete_candidates">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <center><h4 class="modal-title"><b>Are You Sure You want to delete the details below?</b></h4></center>
                </div>
                <center>
                    <div class="modal-body"></div>
                </center>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="No" />
                   <input class="btn btn-danger" type="submit" name="btnDelete_candidate" id="btnDelete_candidate" value="Yes" >
                </div>
            </form>
        </div>
    </div>
</div>