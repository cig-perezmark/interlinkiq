<div class="modal fade bs-modal-lg" id="modalGetMyPro_update" enctype="multipart/form-data" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm addNew">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Project</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Project Name</label>
                            <input class="form-control" type="text" name="Project_Name" required />
                        </div>
                        <div class="col-md-6">
                            <label>Account</label>
                            <select class="form-control mt-multiselect btn btn-default" id="shitdog" data-width="100%" type="text" name="h_accounts">
                                <option value="NONE">--Select--</option>
                                <?php
                                $switch_user_id = 34;
                                $query_accounts = "SELECT * FROM tbl_service_logs_accounts where owner_pk = '$switch_user_id' and is_status = 0 order by name ASC";
                                $result_accounts = mysqli_query($conn, $query_accounts);
                                while ($row_accounts = mysqli_fetch_array($result_accounts)) {
                                    $isSelected = $row_accounts['name'] === 'CONSULTAREINC' ? 'selected' : '';
                                    echo "<option value='{$row_accounts['name']}' {$isSelected}>{$row_accounts['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Descriptions</label>
                        </div>
                        <div class="col-md-12">
                            <textarea class="form-control" type="text" name="Project_Description" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Image/file</label>
                        </div>
                        <div class="col-md-12">
                            <input class="form-control" type="file" name="Sample_Documents">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Start Date</label>
                            <input class="form-control" type="date" name="Start_Date" value="<?= date("Y-m-d", strtotime(date("Y/m/d"))) ?>" required />
                        </div>
                        <div class="col-md-6">
                            <label>Desired Deliver Date</label>
                            <input class="form-control" type="date" name="Desired_Deliver_Date" value="<?= date("Y-m-d", strtotime(date("Y/m/d"))) ?>" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Collaborator</label>
                            <select class="mt-multiselect btn btn-default form-control" id="dogshit" multiple="multiple" data-select-all="true" name="Collaborator[]" data-width="100%">
                                <option value="">---Select---</option>
                                <?php
                                $switch_user_id = 34;
                                $queryCollab = "SELECT * FROM tbl_hr_employee where user_id = $switch_user_id order by first_name ASC";
                                $resultCollab = mysqli_query($conn, $queryCollab);

                                while ($rowCollab = mysqli_fetch_array($resultCollab)) {
                                    echo "<option value='{$rowCollab['ID']}'>{$rowCollab['first_name']} {$rowCollab['last_name']}</option>";
                                }

                                $query = "SELECT * FROM tbl_user where ID = $switch_user_id";
                                $result = mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value='{$row['ID']}'>{$row['first_name']} {$row['last_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top:10px;">
                    <input type="submit" name="btnCreate_Project" id="btnCreate_Project" value="Create" class="btn btn-info">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- 
<div id="todo-members-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Select a Member</h4>
            </div>
            <div class="modal-body">
                <form action="#" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-md-4">Selected Members</label>
                        <div class="col-md-8">
                            <select id="select2_sample2" class="form-control select2 select-height" multiple>
                                <optgroup label="Senior Developers">
                                    <option>Rudy</option>
                                    <option>Shane</option>
                                    <option>Sean</option>
                                </optgroup>
                                <optgroup label="Technical Team">
                                    <option>Kathy</option>
                                    <option>Luke</option>
                                    <option>John</option>
                                    <option>Darren</option>
                                </optgroup>
                                <optgroup label="Design Team">
                                    <option>Bob</option>
                                    <option>Carolina</option>
                                    <option>Randy</option>
                                    <option>Michael</option>
                                </optgroup>
                                <optgroup label="Testers">
                                    <option>Chris</option>
                                    <option>Louis</option>
                                    <option>Greg</option>
                                    <option>Ashe</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn green" data-dismiss="modal">Submit</button>
            </div>
        </div>
    </div>
</div> -->