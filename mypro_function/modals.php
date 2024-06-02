<!--New Project-->
<div class="modal fade" id="addNew" tabindex="-1" role="dialog" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="post" class="form-horizontal modalForm addNew">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Project</h4>
				</div>
				<div class="modal-body">
				   	<?php if($switch_user_id==34){$colNum =6;}else{$colNum=12;}?>
					<div class="form-group">
						<div class="col-md-<?php echo $colNum; ?>">
							<label>Project Name</label>
							<input class="form-control" type="text" name="Project_Name" required />
						</div>
						<?php if($switch_user_id==34){?>
							<div class="col-md-6" >
								<label>Account</label>
								<select class="form-control mt-multiselect btn btn-default" type="text" name="h_accounts">
									<option value="NONE">--Select--</option>
									<?php
										$query_accounts = "SELECT * FROM tbl_service_logs_accounts where owner_pk = '$switch_user_id' and  is_status = 0 order by name ASC";
										$result_accounts = mysqli_query($conn, $query_accounts);
										while($row_accounts = mysqli_fetch_array($result_accounts)) { 
											echo '<option value="'.$row_accounts['name'].'" '; echo 'CONSULTAREINC' == $row_accounts['name'] ? 'selected':''; echo'>'.$row_accounts['name'].'</option>'; 
										} 
									?>
								</select>
							</div>
						<?php }?>
					</div>
					<div class="form-group">
						 <div class="col-md-12">
							<label>Descriptions</label>
						</div>
						<div class="col-md-12">
							<textarea class="form-control" type="text" name="Project_Description" rows="4" required /></textarea>
						</div>
					</div>
					<div class="form-group">
						 <div class="col-md-12">
							<label>Image/file </label>
						</div>
						<div class="col-md-12">
							<input class="form-control" type="file" name="Sample_Documents">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<label>Start Date</label>
							<input class="form-control" type="date" name="Start_Date" value="<?php echo date("Y-m-d", strtotime(date("Y/m/d"))); ?>" required />
						</div>
						<div class="col-md-6" >
							<label>Desired Due Date</label>
							<input class="form-control" type="date" name="Desired_Deliver_Date" value="<?php echo date("Y-m-d", strtotime(date("Y/m/d"))); ?>" required />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<label>Collaborator</label>
							<select class="form-control mt-multiselect btn btn-default" type="text" name="Collaborator[]" multiple required>
								<option value="">---Select---</option>
								
								<?php
									$queryCollab = "SELECT *  FROM tbl_hr_employee where user_id = $switch_user_id order by first_name ASC";
									$resultCollab = mysqli_query($conn, $queryCollab);
									while($rowCollab = mysqli_fetch_array($resultCollab)) {
										echo '<option value="'.$rowCollab['ID'].'">'.$rowCollab['first_name'] .' '. $rowCollab['last_name'].'</option>';
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
<div class="modal fade" id="modalEdit_Project" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalEdit_Project">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Project</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <input type="submit" class="btn green" name="btnUpdate_Project" id="btnUpdate_Project" value="Save" />
                </div>
            </form>
        </div>
    </div>
</div>

<!--  Modal Calendar -->
<div class="modal fade" id="calendarModal" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="post" class="form-horizontal modalForm calendarModal">
				<div class="modal-body" id="get_calendar_data">
				</div>
				<div class="modal-footer">
					<input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
					<button type="submit" class="btn green ladda-button" name="btnSubmit_calendar" id="btnSubmit_calendar" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
				</div>
			</form>
		</div>
	</div>
</div>

<!--add PAYROLL PERIODS-->
<div class="modal fade" id="addNew_payroll_periods" tabindex="-1" role="dialog" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="post" class="form-horizontal modalForm addNew_payroll_periods">
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Add Event</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="col-md-12">
						   <label>Title</label>
						   <input class="form-control" name="CAI_filename">
					   </div>
				   </div>
					<div class="form-group">
						<div class="col-md-12">
						   <label>Description</label>
						   <textarea class="form-control" name="CAI_description" id="your_summernotes" rows="3"></textarea>
					   </div>
				   </div>
					<div class="form-group">
						<div class="col-md-6">
						   <label>Start</label>
						   <input class="form-control" type="date" name="CAI_Action_date" value="<?= date('Y-m-d', strtotime(date('Y-m-d')));?>">
					   </div>
					   <div class="col-md-6">
						   <label>End</label>
						   <input class="form-control" type="date" name="CAI_Action_due_date" value="<?= date('Y-m-d', strtotime(date('Y-m-d')));?>">
					   </div>
				   </div>
				   <div class="form-group">
						
				   </div>
				</div>
				<div class="modal-footer">
					<input type="submit" name="btnAdd_payroll_periods" id="btnAdd_payroll_periods" value="Add" class="btn btn-info">
				</div>
			</form>
		</div>
	</div>
</div>