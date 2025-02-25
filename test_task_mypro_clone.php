<?php 
if(!isset($_COOKIE['ID'])){
    echo '<script>
            if (document.referrer == "") {
                window.location.href = "login";
            } else {
                window.history.back();
            }
        </script>';
}
    $title = "My Pro";
    $site = "MyPro";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';
    $base_url = "https://interlinkiq.com/";
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('ForNewFunctions/resources/templates/_task_mypro_header_clone.php'); 
	$employer_id = employerID($user_id);
	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $user_id" );
    $rowUser = mysqli_fetch_array($selectUser);
    $current_client = $rowUser['client'];
?>

   <body class="page-sidebar-closed-hide-logo page-container-bg-solid">
       <!-- modal  -->		
					<!-- MODAL SERVICE -->
					<div class="modal fade" id="modalService" tabindex="-1" role="basic" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalService">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h4 class="modal-title">Service Request</h4>
									</div>
									<div class="modal-body">
										<input class="form-control" type="hidden" name="ID" value="<?php echo $current_userID; ?>" />
										<div class="form-group">
											<label class="col-md-3 control-label">Category</label>
											<div class="col-md-8">
												<select class="form-control" name="category" onchange="serviceCat(this.value)" required>
													<option value=""></option>
													<option value="1">IT Services</option>
													<option value="2">Techinical Services</option>
													<option value="3">Sales</option>
													<option value="4">Request Demo</option>
													<option value="5">Suggestion</option>
													<option value="6">Problem</option>
													<option value="7">Praise</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Request Title</label>
											<div class="col-md-8">
												<input class="form-control" type="text" name="title" placeholder="Example: Website, SOP, etc" required />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Description</label>
											<div class="col-md-8">
												<textarea class="form-control" name="description" placeholder="Describe your service request here" required></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Contact Number</label>
											<div class="col-md-8">
												<input class="form-control" type="text" name="contact" value="<?php echo $current_userMobile; ?>" required />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Email</label>
											<div class="col-md-8">
												<input class="form-control" type="email" name="email" value="<?php echo $current_userEmail; ?>" required />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Attached Reference File</label>
											<div class="col-md-8">
												<input class="form-control" type="file" name="file" />
											</div>
										</div>
										<div class="form-group" id="serviceDesiredDueDate">
											<label class="col-md-3 control-label">Desired Due Date</label>
											<div class="col-md-8">
												<input class="form-control" type="date" name="due_date" min="<?php echo date("Y-m-d"); ?>" />
											</div>
										</div>
									</div>

									<div class="modal-footer">
										<button type="submit" class="btn green ladda-button" name="btnSave_Services" id="btnSave_Services" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="modal fade" id="modalCollab" tabindex="-1" role="basic" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<form method="post" class="form-horizontal modalForm modalCollab">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h4 class="modal-title">Collaborator</h4>
									</div>
									<div class="modal-body">
										<input class="form-control" type="hidden" name="ID" value="<?php echo $switch_user_id; ?>" />
										<input class="form-control" type="hidden" name="site" value="<?php echo $site; ?>" />
										<div class="form-group">
											<label class="col-md-3 control-label">Select Users</label>
											<div class="col-md-8">
												<select class="form-control mt-multiselect btn btn-default" name="assigned_to_id[]" multiple="multiple">
													<?php
														$selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id=$switch_user_id" );
														if ( mysqli_num_rows($selectEmployee) > 0 ) {
															while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
																$rowEmployeeID = $rowEmployee["ID"];
																$rowEmployeeFName = $rowEmployee["first_name"];
																$rowEmployeeLName = $rowEmployee["last_name"];
																$rowEmployeeSelected = "";

																// Base on Current Page
																$selectMenu = mysqli_query( $conn,"SELECT * FROM tbl_menu WHERE name='".$site."'" );
																if ( mysqli_num_rows($selectMenu) > 0 ) {
																	$rowMenu = mysqli_fetch_array($selectMenu);
																	$assigned_to_id = $rowMenu['assigned_to_id'];

																	if (!empty($assigned_to_id)) {
																		$output = json_decode($assigned_to_id, true);
																		$exist = 0;
																		foreach ($output as $key => $value) {
																			if ($switch_user_id == $key) {
																				if (in_array($rowEmployeeID, $value['assigned_to_id'])) {
																					$exist++;
																					break;
																				}
																			}
																		}

																		if ($exist > 0) { $rowEmployeeSelected = "SELECTED"; }
																	}
																}

																echo '<option value="'. $rowEmployeeID .'" '. $rowEmployeeSelected .'>'. $rowEmployeeFName .' '. $rowEmployeeLName .'</option>';
															}
														} else {
															echo '<option disabled>No Available</option>';
														}
													?>
												</select>
											</div>
										</div>
									</div>

									<div class="modal-footer">
										<button type="submit" class="btn green ladda-button" name="btnSave_Collab" id="btnSave_Collab" data-style="zoom-out"><span class="ladda-label">Save</span></button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="modal fade" id="modalSwitch" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<form method="post" enctype="multipart/form-data" class="modalForm modalSave_Service">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h4 class="modal-title">Switch Account</h4>
									</div>
									<div class="modal-body">
										<div class="mt-actions">
											<?php
												$selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $current_userEmployerID" );
												if ( mysqli_num_rows($selectUser) > 0 ) {
													$rowUser = mysqli_fetch_array($selectUser);
													$user_email = $rowUser["email"];
													$switch_ID = 5;
													$switch_name = 'Company Name';
													$switch_email = 'company@gmail.com';
													$switch_logo = 'no_images.png';

													// $selectEnterprise = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails WHERE businessemailAddress = '".$user_email."'" );
													// if ( mysqli_num_rows($selectEnterprise) > 0 ) {
													//     $rowEnterprise = mysqli_fetch_array($selectEnterprise);
													//     $switch_ID = $rowEnterprise["users_entities"];
													//     $switch_name = $rowEnterprise["businessname"];
													//     $switch_logo = $rowEnterprise["BrandLogos"];

														echo '<div class="mt-action">
															<div class="mt-action-img"><img src="companyDetailsFolder/'.$switch_logo.'" style="width: 39px; height: 39px; object-fit: cover; object-position: center; border: 1px solid #ccc;"></div>
															<div class="mt-action-body">
																<div class="mt-action-row">
																	<div class="mt-action-info ">
																		<div class="mt-action-details ">
																			<span class="mt-action-author">'.$switch_name.'</span><br>
																			<span class="text-muted">'.$switch_email.'</span>
																		</div>
																	</div>
																	<div class="text-right">
																		<input type="button" class="btn btn-success btn-sm btn-circle" onclick="btnSwitch('.$switch_ID.')" value="Select" />
																	</div>
																</div>
															</div>
														</div>';
													// }
												}


												// List all customer
												if ($current_client = 1) {
													$selectSupplier = mysqli_query( $conn,"SELECT * from tbl_supplier WHERE page = 2 AND is_deleted = 0 AND status = 1 AND user_id = $current_userEmployerID ORDER BY name" );
												} else {
													$selectSupplier = mysqli_query( $conn,"SELECT * from tbl_supplier WHERE page = 2 AND category = 3 AND is_deleted = 0 AND status = 1 AND user_id = $current_userEmployerID ORDER BY name" );
												}
												if ( mysqli_num_rows($selectSupplier) > 0 ) {
													while($rowSupplier = mysqli_fetch_array($selectSupplier)) {
														$switch_ID = $rowSupplier["ID"];
														$switch_ID = 5;
														$switch_name = $rowSupplier["name"];
														$switch_email = $rowSupplier["email"];
														$switch_employee_id = $rowSupplier["employee_id"];
														$switch_logo = 'no_images.png';

														if (!empty($switch_employee_id)) {
															$switch_employee_id_arr = explode(", ", $switch_employee_id);
															if (in_array($current_userEmployeeID, $switch_employee_id_arr)) {

																// $selectEnterprise = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails WHERE businessemailAddress = '".$switch_email."'" );
																// if ( mysqli_num_rows($selectEnterprise) > 0 ) {
																//     $rowEnterprise = mysqli_fetch_array($selectEnterprise);
																//     $switch_ID = $rowEnterprise["users_entities"];
																//     $switch_name = $rowEnterprise["businessname"];
																//     $switch_logo = $rowEnterprise["BrandLogos"];

																	echo '<div class="mt-action">
																		<div class="mt-action-img"><img src="companyDetailsFolder/'.$switch_logo.'" style="width: 39px; height: 39px; object-fit: cover; object-position: center; border: 1px solid #ccc;"></div>
																		<div class="mt-action-body">
																			<div class="mt-action-row">
																				<div class="mt-action-info ">
																					<div class="mt-action-details ">
																						<span class="mt-action-author">'.$switch_name.'</span><br>
																						<span class="text-muted">'.$switch_email.'</span>
																					</div>
																				</div>
																				<div class="text-right">
																					<input type="button" class="btn btn-success btn-sm btn-circle" onclick="btnSwitch('.$switch_ID.')" value="Select" />
																				</div>
																			</div>
																		</div>
																	</div>';
																// }
															}
														}
													}
												}
											?>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>


                    <!-- Instruction Section -->
                    <div class="modal fade" id="modalInstruction" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalInstruction">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add New Instruction</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Instruction" id="btnSave_Instruction" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalInstructionEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalInstructionEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Instruction</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Instruction" id="btnUpdate_Instruction" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

					<a href="#modalService" class="icon-btn btn btn-lg green" data-toggle="modal" style="position: fixed; bottom: 10px; right: 10px; border-radius: 50% !important; width: 60px; height: 60px; min-width: auto; padding-top: 8px;">
						<i class="icon-earphones-alt"></i>
						<div class="font-white" style="margin: 0;">Request<br>Service</div>
					</a>

					<!-- MODAL CHAT -->
                    <div class="modal fade" id="sendMessage2" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalMessage2">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Chat</h4>
                                    </div>
				                    <div class="modal-body overflow-auto d-flex flex-column-reverse justify-content-endx" style="height: 100vh; max-height: 45vh;"></div>
                                    <div class="modal-footer">
                                    	<div class="input-group">
                                            <input type="text" class="form-control" placeholder="Write message here..." aria-label="Write message here..." aria-describedby="btnSend_Chat" name="message">
                                            <span class="input-group-btn">
                                                <button class="btn btn-success" type="submit" id="btnSend_Chat"><i class="fa fa-paper-plane"></i> Send</button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Speakup -->
                    <div class="modal fade" id="modalSpeakUp" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalSpeakUp">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 512 512" style="margin-bottom: -6px; margin-right: 10px;"><path fill="#48677E" d="M292.834 280.647a8.344 8.344 0 0 0 3.415 11.305c4.577 2.457 13.948 4.158 20.393 5.094c3.623.526 6.089 4.226 5.041 7.734c-10.601 35.504-41.8 50.113-82.55 55.398v25.865c52.399 4.923 93.405 49.025 93.405 102.711c0 9.525-7.721 17.246-17.246 17.246H59.747c-9.525 0-17.246-7.721-17.246-17.246c0-53.686 41.006-97.789 93.405-102.711v-34.758C103.807 336.26 83.351 308.4 70.313 278.99c-1.909.367-3.115.417-3.408.103c-19.506-20.89-38.863-74.881-38.863-128.64c0-53.76 36.755-147.634 137.924-147.634c58.21 0 139.255 13.239 141.821 15.35c2.587 2.128-5.389 18.791-2.83 21.231c5.335 5.086 10.637 10.871 16.016 17.45c4.545 5.558-1.443 8.837-21.675 10.114c18.337 19.668 28.944 46.551 28.944 80.468l-.372 18.779l.004-.008c-.002.001-.002.007-.004.01l-.006.295c.464 3.721 12.114 40.293 19.704 56.085c8.582 17.858-2.743 21.798-21.257 22.374l-.602 30.426c0 5.576-16.126 4.762-21.571 1.844c-4.119-2.184-9.159-.638-11.304 3.41zm80.636-27.338l91.264-42.482a3.279 3.279 0 0 0 1.326-4.771l-14.046-21.22a3.28 3.28 0 0 0-4.91-.644l-75.219 66.701c-1.259 1.117.059 3.126 1.585 2.416zm-1.207 62.314l73.979 66.62a3.279 3.279 0 0 0 4.912-.651l13.992-21.242a3.279 3.279 0 0 0-1.341-4.77l-89.943-42.363c-1.52-.716-2.848 1.282-1.599 2.406zm3.159-30.571l112.456 14.619a3.28 3.28 0 0 0 3.702-3.251v-25.535a3.278 3.278 0 0 0-3.702-3.251l-112.456 14.619c-1.64.213-1.64 2.586 0 2.799z"></path></svg><span class="sbold text-info">Speak</span><span class="sbold text-primary">Up</span></h4>
                                    </div>
                                    <div class="modal-body">
                                    	<textarea class="form-control" name="comment" rows="10"></textarea>
                                    	<p class="text-center text-danger"><i>We are stronger when we listen, and smarter when we share.</i></p>
                                    </div>
				                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Speakup" id="btnSave_Speakup" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalSpeakUpViewAll" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalSpeakUpViewAll">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 512 512" style="margin-bottom: -6px; margin-right: 10px;"><path fill="#48677E" d="M292.834 280.647a8.344 8.344 0 0 0 3.415 11.305c4.577 2.457 13.948 4.158 20.393 5.094c3.623.526 6.089 4.226 5.041 7.734c-10.601 35.504-41.8 50.113-82.55 55.398v25.865c52.399 4.923 93.405 49.025 93.405 102.711c0 9.525-7.721 17.246-17.246 17.246H59.747c-9.525 0-17.246-7.721-17.246-17.246c0-53.686 41.006-97.789 93.405-102.711v-34.758C103.807 336.26 83.351 308.4 70.313 278.99c-1.909.367-3.115.417-3.408.103c-19.506-20.89-38.863-74.881-38.863-128.64c0-53.76 36.755-147.634 137.924-147.634c58.21 0 139.255 13.239 141.821 15.35c2.587 2.128-5.389 18.791-2.83 21.231c5.335 5.086 10.637 10.871 16.016 17.45c4.545 5.558-1.443 8.837-21.675 10.114c18.337 19.668 28.944 46.551 28.944 80.468l-.372 18.779l.004-.008c-.002.001-.002.007-.004.01l-.006.295c.464 3.721 12.114 40.293 19.704 56.085c8.582 17.858-2.743 21.798-21.257 22.374l-.602 30.426c0 5.576-16.126 4.762-21.571 1.844c-4.119-2.184-9.159-.638-11.304 3.41zm80.636-27.338l91.264-42.482a3.279 3.279 0 0 0 1.326-4.771l-14.046-21.22a3.28 3.28 0 0 0-4.91-.644l-75.219 66.701c-1.259 1.117.059 3.126 1.585 2.416zm-1.207 62.314l73.979 66.62a3.279 3.279 0 0 0 4.912-.651l13.992-21.242a3.279 3.279 0 0 0-1.341-4.77l-89.943-42.363c-1.52-.716-2.848 1.282-1.599 2.406zm3.159-30.571l112.456 14.619a3.28 3.28 0 0 0 3.702-3.251v-25.535a3.278 3.278 0 0 0-3.702-3.251l-112.456 14.619c-1.64.213-1.64 2.586 0 2.799z"></path></svg><span class="sbold text-info">Speak</span><span class="sbold text-primary">Up</span></h4>
                                    </div>
                                    <div class="modal-body">
                                    	<table class="table table-bordered table-hover" id="tableData_Speakup">
                                    		<thead>
                                    			<tr>
                                    				<th>Comment</th>
                                    				<th class="text-center" style="width: 85px;">Date</th>
                                    				<th class="text-center" style="width: 85px;">Action</th>
                                    			</tr>
                                    		</thead>
                                    		<tbody></tbody>
                                    	</table>
                                    </div>
				                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalSpeakUpView" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalSpeakUpView">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 512 512" style="margin-bottom: -6px; margin-right: 10px;"><path fill="#48677E" d="M292.834 280.647a8.344 8.344 0 0 0 3.415 11.305c4.577 2.457 13.948 4.158 20.393 5.094c3.623.526 6.089 4.226 5.041 7.734c-10.601 35.504-41.8 50.113-82.55 55.398v25.865c52.399 4.923 93.405 49.025 93.405 102.711c0 9.525-7.721 17.246-17.246 17.246H59.747c-9.525 0-17.246-7.721-17.246-17.246c0-53.686 41.006-97.789 93.405-102.711v-34.758C103.807 336.26 83.351 308.4 70.313 278.99c-1.909.367-3.115.417-3.408.103c-19.506-20.89-38.863-74.881-38.863-128.64c0-53.76 36.755-147.634 137.924-147.634c58.21 0 139.255 13.239 141.821 15.35c2.587 2.128-5.389 18.791-2.83 21.231c5.335 5.086 10.637 10.871 16.016 17.45c4.545 5.558-1.443 8.837-21.675 10.114c18.337 19.668 28.944 46.551 28.944 80.468l-.372 18.779l.004-.008c-.002.001-.002.007-.004.01l-.006.295c.464 3.721 12.114 40.293 19.704 56.085c8.582 17.858-2.743 21.798-21.257 22.374l-.602 30.426c0 5.576-16.126 4.762-21.571 1.844c-4.119-2.184-9.159-.638-11.304 3.41zm80.636-27.338l91.264-42.482a3.279 3.279 0 0 0 1.326-4.771l-14.046-21.22a3.28 3.28 0 0 0-4.91-.644l-75.219 66.701c-1.259 1.117.059 3.126 1.585 2.416zm-1.207 62.314l73.979 66.62a3.279 3.279 0 0 0 4.912-.651l13.992-21.242a3.279 3.279 0 0 0-1.341-4.77l-89.943-42.363c-1.52-.716-2.848 1.282-1.599 2.406zm3.159-30.571l112.456 14.619a3.28 3.28 0 0 0 3.702-3.251v-25.535a3.278 3.278 0 0 0-3.702-3.251l-112.456 14.619c-1.64.213-1.64 2.586 0 2.799z"></path></svg><span class="sbold text-info">Speak</span><span class="sbold text-primary">Up</span></h4>
                                    </div>
                                    <div class="modal-body"></div>
				                    <div class="modal-footer">
                                    	<div class="input-group">
                                            <input type="text" class="form-control" placeholder="Write something here..." aria-label="Write something here..." aria-describedby="btnSend_Chat" name="comment">
                                            <span class="input-group-btn">
                                                <button class="btn btn-success" type="submit" id="btnSave_SpeakupView"><i class="fa fa-paper-plane"></i> Reply</button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- Sticky Notes -->
                    <div class="modal fade" id="modalNotes" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalNotes">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">My Notes</h4>
                                    </div>
                                    <div class="modal-body">
                                    	<div class="form-group">
                                            <textarea class="form-control" name="description" rows="5"></textarea>
                                       	</div>
                                    	<div class="form-group hide">
                                            <label>Endorse To</label>
                                            <select class="form-control mt-multiselect" name="assigned_to[]" multiple="multiple">
                                            	<?php
                                                    $selectEmployeee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $current_userEmployerID ORDER BY first_name" );
                                                    if ( mysqli_num_rows($selectEmployeee) > 0 ) {
                                                        while($rowEmployee = mysqli_fetch_array($selectEmployeee)) {
                                                            echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                       	</div>
                                    	<div class="form-group hide">
                                            <label>Copy To</label>
                                            <select class="form-control mt-multiselect" name="copy_to[]" multiple="multiple">
                                            	<?php
                                                    $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE is_verified = 1 AND is_active = 1 AND ID IN ($current_userEmployerID, 189) ORDER BY first_name" );
                                                    if ( mysqli_num_rows($selectUser) > 0 ) {
                                                        while($rowUser = mysqli_fetch_array($selectUser)) {
                                                            echo '<option value="'. $rowUser["ID"] .'">'. $rowUser["first_name"] .' '. $rowUser["last_name"] .'</option>';
                                                        }
                                                    }
                                                    // 34 - hr@consultareinc.com
                                                    // 189 - accounting@consultareinc.com
                                                    // $selectEmployeee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $current_userEmployerID ORDER BY first_name" );
                                                    $selectEmployeee = mysqli_query( $conn,"SELECT USER.ID AS userID, USER.employee_id AS userEMPID, USER.first_name AS userFN, USER.last_name AS userLN, USER.email AS userEmail, USER.is_verified AS userVerified, USER.is_active AS userActive, EMPLOYEE.ID AS empID, EMPLOYEE.user_id AS empUSERID, EMPLOYEE.suspended AS empSUSPENDED, EMPLOYEE.status AS empSTATUS, EMPLOYEE.verified AS empVERIFIED
														FROM tbl_user AS USER
														INNER JOIN tbl_hr_employee AS EMPLOYEE
														ON USER.employee_id = EMPLOYEE.ID
														WHERE USER.is_verified = 1 AND USER.is_active = 1 AND EMPLOYEE.user_id = $current_userEmployerID AND EMPLOYEE.suspended = 0 AND EMPLOYEE.status = 1 AND EMPLOYEE.verified = 0
														ORDER BY USER.first_name" );
                                                    if ( mysqli_num_rows($selectEmployeee) > 0 ) {
                                                        while($rowEmployee = mysqli_fetch_array($selectEmployeee)) {
                                                            echo '<option value="'. $rowEmployee["userID"] .'">'. $rowEmployee["userFN"] .' '. $rowEmployee["userLN"] .'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                       	</div>
                                    	<div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                            	<option value="0"></option>
                                            	<option value="1">Pending</option>
                                            	<option value="2">Completed</option>
                                            	<option value="3">Not Completed</option>
                                            </select>
                                       	</div>
                                    </div>
				                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnSave_Notes" id="btnSave_Notes" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalNotesView" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalNotesView">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">My Notes</h4>
                                    </div>
                                    <div class="modal-body"></div>
				                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Notes" id="btnUpdate_Notes" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalNotesViewCopy" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalNotesViewCopy">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">My Notes</h4>
                                    </div>
                                    <div class="modal-body"></div>
				                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

       <!-- testing sidebar -->
       <div class="modal fade" id="modalGetHistoryb" tabindex="-1" role="basic" aria-hidden="true">
           <div class="modal-dialog modal-lg">
               <div class="modal-content">
                   <form method="post" class="form-horizontal modalForm modalGetHistoryb">
                       <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h4 class="modal-title">New Action Item</h4>
                       </div>
                       <div class="modal-body">
                           <div id="childForm">

                           </div>
                       </div>
                       <div class="modal-footer">
                           <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                           <button type="submit" class="btn green ladda-button" name="btnSave_AddChildItemb" id="btnSave_AddChildItemb" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                       </div>
                   </form>
               </div>
           </div>
       </div>

       <div class="modal fade" id="modalDocumentForm" tabindex="-1" role="basic" aria-hidden="true">
           <div class="modal-dialog modal-lg">
               <div class="modal-content">
                   <form method="post" class="form-horizontal modalForm modalDocumentForm">
                       <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h4 class="modal-title">New Action Item</h4>
                       </div>
                       <div class="modal-body">
                           <div id="childDocumentForm">

                           </div>
                       </div>
                       <div class="modal-footer">
                           <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                           <button type="submit" class="btn green ladda-button" name="btnSave_AddChildItemdocument" id="btnSave_AddChildItemdocument" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
       <div class="modal fade" id="collaborator" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                       <h4 class="modal-title">Project Collaborator(s)</h4>
                       
                   </div>
                   <?php
                      $myProMain = $_GET['view_id'];
                                $selectData = mysqli_query($conn, "SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $myProMain");
                                if (mysqli_num_rows($selectData) > 0) {
                                    $row = mysqli_fetch_array($selectData);
                                }
                   ?>
                   <div class="modal-body">
                       
                       <?php
                       $i_user = $_COOKIE['ID'];
                      if (isset($_COOKIE['switchAccount'])) { $i_user = $_COOKIE['switchAccount']; }
                       if($row['user_cookies'] == $i_user){?>
                       <form id="addCollaborator" class="form-horizontal" role="form">
                           <div class="form-group">
                               <div class="col-md-10">
                                   <input type="hidden" name="viewid" value="<?php echo $_GET['view_id']; ?>">
                                   <select id="select2_sample2" name="collaboratorSelect[]" placeholder="Select member" class="form-control select2 select-height" multiple required>
                                       <?php
                                         if (!empty($_COOKIE['switchAccount'])) {
                                                	$p_user = $_COOKIE['ID'];
                                                	$u_id = $_COOKIE['switchAccount'];
                                                }
                                                else {
                                                	$p_user = $_COOKIE['ID'];
                                                	$u_id = employerID($p_user);
                                                }
                                         $queryCollab = "SELECT *  FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $u_id";
                                         $resultCollab = mysqli_query($conn, $queryCollab);
                                                                    
                                        while($rowCollab = mysqli_fetch_array($resultCollab))
                                        {
                                            $array_busi = explode(", ", $row["Collaborator_PK"]); 
                                        echo '<option value="'.$rowCollab['ID'].'" '; echo in_array($rowCollab['ID'], $array_busi) ? 'selected': ''; echo'>'.$rowCollab['first_name'].' '.$rowCollab['last_name'].'</option>';
                                        }
                                        ?>
                                   </select>
                               </div>
                               <div class="col-md-2">
                               <button type="submit" class="btn green">Share</button>
                               </div>
                           </div>
                       </form>
                       <?php }else{ ?>
                    <div class="clearfix"></div>    
                    <div class="scroller" style="height:150px;overflow:auto;">
                    <div class="row">
                    <div class="col-md-12">
                         <div class="text-info">
                              <p style="font-style:italic;font-size:12px;">Only project creator can share this project..</p>
                         </div>
                            <div class="p-2 bd-highlight">
                             <?php
                                    $myProMain = $_GET['view_id'];
                                    
                                    $selectData = mysqli_query($conn, "SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $myProMain");
                                    if (mysqli_num_rows($selectData) > 0) {
                                        $row = mysqli_fetch_array($selectData);
                                    }
                                    
                                    $queryCollabs = "SELECT * FROM tbl_hr_employee WHERE status = 1 ORDER BY first_name ASC";
                                    $stmt = mysqli_prepare($conn, $queryCollabs);
                                    mysqli_stmt_execute($stmt);
                                    $resultCollabs = mysqli_stmt_get_result($stmt);
                                    
                                    while ($rowCollabs = mysqli_fetch_array($resultCollabs)) {
                                        $array_collab = explode(", ", $row["Collaborator_PK"]); 
                                        if (in_array($rowCollabs['ID'], $array_collab)) {
                                            echo ' <span style="margin-top:7px;background-color:#e7ecf1;" class="btn gray btn-circle  text-gray px-2">';
                                            echo '<a target="_blank" data-toggle="tooltip" title="" data-original-title="View profile">';
                                            echo '<strong>' . $rowCollabs['first_name'] . '&nbsp;' . $rowCollabs['last_name'] . '</strong>';
                                            echo '</a>';
                                            echo '</span>';
                                        }
                                    }
                                    ?>
                             </div>
                        </div>
                    </div>
                    </div>
                    <?php } ?>
                 <?php 
                      $i_user = $_COOKIE['ID'];
                      if (isset($_COOKIE['switchAccount'])) { $i_user = $_COOKIE['switchAccount']; }
                    if($row['user_cookies'] == $i_user){?>
                         <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12">
                            <div class="text-info">
                            <hr>
                              <p style="font-style:italic;font-size:12px;">If you want to pass this project, please select an option and click the "Proceed" button.</p>
                            </div>
                          </div>
                          <form id="updateCookiesForm">
                              <div class="col-md-9">
                                <div class="form-group">
                                  <input type="hidden" name="viewid" value="<?php echo $_GET['view_id']; ?>">
                                  <select class="form-control mt-multiselect btn btn-default" id="Assign_to_history" name="Assign_to_history" type="text">
                                    <option value="0" selected>---Select---</option>
                                       <?php
                                $queryCollabs = "SELECT * FROM tbl_hr_employee WHERE status = 1 ORDER BY first_name ASC";
                                $stmt = mysqli_prepare($conn, $queryCollabs);
                                mysqli_stmt_execute($stmt);
                                $resultCollabs = mysqli_stmt_get_result($stmt);
                                
                                while ($rowCollabs = mysqli_fetch_array($resultCollabs)) {
                                    $array_collab = explode(", ", $row["Collaborator_PK"]); 
                                    if (in_array($rowCollabs['ID'], $array_collab)) {
                                        echo '<option value="' . $rowCollabs['ID'] . '">' . $rowCollabs['first_name'] . ' ' . $rowCollabs['last_name'] . '</option>';
                                    }
                                }
                                     echo '<option value="0">Others</option>';
                                ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <input type="button" class="btn green" value="Proceed" onclick="updateCookies()">
                                </div>
                              </div>
                            </form>
                        </div>
                        <?php } ?>
                   </div>
                   <div class="modal-footer">
                       <button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
                   </div>
               </div>
           </div>
       </div>
       <!-- end of collaborator -->
       <div class="modal fade" id="modalAddActionItem" tabindex="-1" role="basic" aria-hidden="true">
           <div class="modal-dialog">
               <div class="modal-content">
                   <form method="post" id="actionItem" class="form-horizontal modalForm modalAddActionItem">
                       <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h4 class="modal-title">New Action Item</h4>
                       </div>
                       <div class="modal-body" id="newparent"></div>
                       <div class="modal-footer">
                           <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                           <button type="submit" class="btn green ladda-button" name="btnSave_History" id="btnSave_History" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
       <!-- end of modal -->
       <!-- viewHistoryForeditmodal -->
       <div class="modal fade" id="ViewHistoryForEdits" tabindex="-1" role="basic" aria-hidden="true">
           <div class="modal-dialog">
               <div class="modal-content">
                   <form id="ViewHistoryForEdits" class="form-horizontal">
                       <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h4 class="modal-title">Edit Action Item</h4>
                       </div>
                       <div class="modal-body">
                           <div class="form-group">
                               <div class="col-md-12">
                                   <label>Task Name</label>
                               </div>
                               <div class="col-md-12">
                                   <input class="form-control" type="text" name="filename" id="filename" />
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="col-md-12">
                                   <label>Supporting File</label>
                               </div>
                               <div class="col-md-12">
                                   <input class="form-control" name="file" type="file" id="file">
                               </div>
                           </div>
                      <?php if($current_client != 1){?>
                           <div class="form-group">
                               <div class="col-md-6">
                                   <label>Action Items</label>
                                   <select name="Action_taken" class="form-control mt-multiselect btn btn-default" type="text" id="Action_taken">
                                       <option value="" selected>---Select---</option>';
                                       <?php
                                        $queryType = "SELECT * FROM tbl_MyProject_Services_Action_Items ORDER BY Action_Items_name ASC";
                                        $resultType = mysqli_query($conn, $queryType);

                                        while ($rowType = mysqli_fetch_array($resultType)) {
                                            echo '<option value="' . $rowType['Action_Items_id'] . '">' . $rowType['Action_Items_name'] . '</option>';
                                        }

                                        echo '<option value="0">Others</option>';
                                        ?>
                                   </select>
                               </div>
                               <div class="col-md-6">
                                   <label>Account</label>
                                   <select id="h_accounts" name="h_accounts" class="form-control mt-multiselect btn btn-default" type="text">
                                       <option value="">---Select---</option>';
                                       <?php
                                        $query_accounts = "SELECT * FROM tbl_service_logs_accounts WHERE is_status = 0 ORDER BY name ASC";
                                        $stmt_accounts = mysqli_prepare($conn, $query_accounts);
                                        mysqli_stmt_execute($stmt_accounts);
                                        $result_accounts = mysqli_stmt_get_result($stmt_accounts);

                                        while ($row_accounts = mysqli_fetch_array($result_accounts)) {
                                            echo '<option value="' . $row_accounts['name'] . '"><span>' . $row_accounts['name'] . '</span></option>';
                                        }
                                        ?>
                                   </select>
                               </div>
                           </div>
                           <?php } ?>
                           <div class="form-group">
                               <div class="col-md-12">
                                   <label>Description</label>
                               </div>
                               <div class="col-md-12">
                                   <textarea class="form-control" name="description" id="description"></textarea>
                               </div>
                           </div>
                           <div class="form-group">
                         <?php if($current_client != 1){?>
                               <div class="col-md-6">
                                   <label>Estimated Time (minutes)</label>
                                   <input class="form-control" type="number" name="Estimated_Time" id="Estimated_Time" value="0" />
                               </div>
                         <?php } ?>
                               <div class="col-md-6">
                                   <label>Desired Due Date</label>
                                   <input class="form-control" type="date" name="Action_date" id="Action_date" value="<?php echo date(" Y-m-d", strtotime(date("Y/m/d"))) ?>" />
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="col-md-12">
                                   <label>Assign to</label>
                               </div>
                               <div class="col-md-12">
                                   <select class="form-control mt-multiselect btn btn-default" id="Assign_to_history" name="Assign_to_history" type="text">
                                       <option value="0" selected>---Select---</option>
                                       <?php
                                        // $user_id = 34;
                                        $queryAssignto = "SELECT * FROM tbl_hr_employee WHERE user_id = $employer_id AND status = 1 ORDER BY first_name ASC";
                                        $resultAssignto = mysqli_query($conn, $queryAssignto);
                                        while ($rowAssignto = mysqli_fetch_array($resultAssignto)) {
                                            echo '<option value="' . $rowAssignto['ID'] . '">' . $rowAssignto['first_name'] . ' ' . $rowAssignto['last_name'] . '</option>';
                                        }
                                        echo '<option value="0">Others</option>';
                                        ?>
                                   </select>
                               </div>
                           </div>
                       </div>
                       <input type="hidden" name="History_id" id="History_id" value="">
                       <div class="modal-footer">
                           <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                           <button type="submit" class="btn green ladda-button" name="SaveHistoryEdit" id="SaveHistoryEdit" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
       <!-- end of it -->
       <!-- viewSubTaskforEdit -->
       <!-- viewHistoryForeditmodal -->
       <div class="modal fade" id="ViewSubTaskForEdit" tabindex="-1" role="basic" aria-hidden="true">
           <div class="modal-dialog">
               <div class="modal-content">
                   <form id="ViewSubTaskForEdits" class="form-horizontal">
                       <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h4 class="modal-title">Edit Action Item</h4>
                       </div>
                       <div class="modal-body">
                           <div class="form-group">
                               <div class="col-md-12">
                                   <label>Task Name</label>
                               </div>
                               <div class="col-md-12">
                                   <input class="form-control" type="text" name="CAI_filename" id="CAI_filename" required />
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="col-md-12">
                                   <label>Supporting File</label>
                               </div>
                               <div class="col-md-12">
                                   <input class="form-control" type="file" id="CAI_files" name="CAI_files">
                               </div>
                           </div>
                          <?php if($current_client != 1){?>
                           <div class="form-group">
                               <div class="col-md-6">
                                   <label>Action Types</label>
                                   <select class="form-control mt-multiselect btn btn-default" id="CAI_Action_taken" type="text" name="CAI_Action_taken" required>
                                       <option value="">---Select---</option>';

                                       <?php
                                        $queryType = "SELECT * FROM tbl_MyProject_Services_Action_Items ORDER BY Action_Items_name ASC";
                                        $resultType = mysqli_query($conn, $queryType);

                                        while ($rowType = mysqli_fetch_array($resultType)) {
                                            echo '<option value="' . $rowType['Action_Items_id'] . '">' . $rowType['Action_Items_name'] . '</option>';
                                        } ?>
                                       <option value="0">Others</option>
                                   </select>
                               </div>
                               <div class="col-md-6">
                                   <label>Account</label>
                                   <select name="CAI_Accounts" id="CAI_Accounts" class="form-control mt-multiselect btn btn-default" type="text">
                                       <option value="">---Select---</option>';
                                       <option value="0">Others</option>
                                       <?php $query_accounts = "SELECT * FROM tbl_service_logs_accounts WHERE  is_status = 0 ORDER BY name ASC";
                                        $stmt_accounts = mysqli_prepare($conn, $query_accounts);
                                        mysqli_stmt_execute($stmt_accounts);
                                        $result_accounts = mysqli_stmt_get_result($stmt_accounts);

                                        while ($row_accounts = mysqli_fetch_array($result_accounts)) {
                                            echo '<option value="' . $row_accounts['name'] . '"><span>' . $row_accounts['name'] . '</span></option>';
                                        } ?>
                                   </select>
                               </div>
                           </div>
                           <?php } ?>
                           <div class="form-group">
                               <div class="col-md-12">
                                   <label>Description</label>
                               </div>
                               <div class="col-md-12">
                                   <textarea class="form-control" id="CAI_description" name="CAI_description" required></textarea>
                               </div>
                           </div>

                           <?php if ($employer_id == 34) {
                                echo '
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>(<i style="color:red;font-size:12px;"><b style="color:black;">"Yes"</b> it will automatically be reflected in your Service logs. If <b style="color:black;"> "NO"</b> to Auto logs for your review.</i>) </label><br>
                                        <label><input type="radio" name="checked_choice" value="yes" checked> Yes</label> &nbsp; <label><input type="radio" name="checked_choice" value="no" > No</label>
                                    </div>
                                </div>';
                            } ?>

                           <div class="form-group">
                             <?php if($current_client != 1){?>
                               <div class="col-md-6">
                                   <label>Estimated Time (minutes)</label>
                                   <input class="form-control" id="CAI_Estimated_Time" type="number" name="CAI_Estimated_Time" value="0" required />
                               </div>
                               <?php }?>
                               <div class="col-md-6">
                                   <label>Date</label>
                                   <input class="form-control" id="CAI_Action_due_date" type="date" name="CAI_Action_due_date" value="" required />
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="col-md-12">
                                   <label>Status</label>
                               </div>
                               <div class="col-md-12">
                                   <select class="form-control" id="CIA_progress" name="CIA_progress">
                                       <option value="0">Not Started</option>
                                       <option value="1">Inprogress</option>
                                       <option value="2">Completed</option>
                                   </select>
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="col-md-12">
                                   <label>Assign to</label>
                               </div>
                               <div class="col-md-12">
                                   <select class="form-control mt-multiselect btn btn-default" type="text" id="CAI_Assign_to" name="CAI_Assign_to" required>
                                       <option value="">---Select---</option>';
                                      <?php
                                        function getEmployerID($ID) {
                                            global $conn;
                                        
                                            $selectUser = mysqli_query($conn, "SELECT * FROM tbl_user WHERE ID = $ID");
                                            $rowUser = mysqli_fetch_array($selectUser);
                                            $current_userEmployeeID = $rowUser['employee_id'];
                                        
                                            $current_userEmployerID = $ID;
                                            if ($current_userEmployeeID > 0) {
                                                $selectEmployer = mysqli_query($conn, "SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID = $current_userEmployeeID");
                                                if (mysqli_num_rows($selectEmployer) > 0) {
                                                    $rowEmployer = mysqli_fetch_array($selectEmployer);
                                                    $current_userEmployerID = $rowEmployer["user_id"];
                                                }
                                            }
                                        
                                            return $current_userEmployerID;
                                        }
                                        
                                        $portal_user = $_COOKIE['ID'];
                                        $user_id = getEmployerID($portal_user);
                                        
                                        $queryCollab = "SELECT * FROM tbl_hr_employee WHERE user_id = $user_id ORDER BY first_name ASC";
                                        $resultCollab = mysqli_query($conn, $queryCollab);
                                        
                                        while ($rowCollab = mysqli_fetch_array($resultCollab)) {
                                            echo "<option value='{$rowCollab['ID']}'>{$rowCollab['first_name']} {$rowCollab['last_name']}</option>";
                                        }
                                        
                                        $query = "SELECT * FROM tbl_user WHERE ID = $user_id";
                                        $result = mysqli_query($conn, $query);
                                        
                                        while ($row = mysqli_fetch_array($result)) {
                                            echo "<option value='{$row['ID']}'>{$row['first_name']} {$row['last_name']}</option>";
                                        }
                                        ?>
                                       <option value="0">Others</option>
                                   </select>
                               </div>
                           </div>
                       </div>
                       <input type="hidden" name="History_id" id="History_id" value="">
                       <input type="hidden" name="CAI_id" id="CAI_id" value="">
                       <input type="hidden" name="parent_MyPro_PK" id="parent_MyPro_PK" value="">
                       <div class="modal-footer">
                           <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                           <button type="submit" class="btn green ladda-button" name="SaveEditedSubTask" id="SaveEditedSubTask" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
       <!-- end of it -->
       <!-- END HEADER & CONTENT DIVIDER -->
       <!-- BEGIN CONTAINER -->
         <div class="row">
        <div class="col-md-12">
              <ul class="nav nav-tabs">
                                 <li class="active">
                                     <a type="button" class="btn default" href="https://interlinkiq.com/test_MyPro.php#tab_Calendar" > Calendar </a>
                                </li>
                                <li>
                                    <a type="button" class="btn default" href="https://interlinkiq.com/test_MyPro.php#tab_Dashboard"> Project </a>
                                </li>
                                <?php if($current_client != 1 ){ ?>
                                <li>
                                    <a type="button" class="btn default" href="https://interlinkiq.com/test_MyPro.php#tab_Me">My Task</a>
                                </li>
                                <?php }?>
                                <li>
                                    <a type="button" class="btn default" href="https://interlinkiq.com/test_MyPro.php#tab_Collaborator_Task">Collaborator Task </a>
                                </li>
                                </ul>
            <div class="portlet light ">
                    
                           <div class="row">
                               <div class="col-md-12">
                                   <div class="portlet light portlet-fit">
                               <?php
                                $i_user = $_COOKIE['ID'];
                                $myProMain = $_GET['view_id'];
                                $queryMain = "SELECT *  FROM tbl_MyProject_Services left join tbl_MyProject_Services_Assigned on MyPro_PK = MyPro_id where MyPro_id = $myProMain";
                                $resultMain = mysqli_query($conn, $queryMain);
                                while ($rowMain = mysqli_fetch_array($resultMain)) { ?>
                                       <div class="portlet-title">
                                           <div class="caption">
                                               <div class="col-md-2 mt-step-col">
                                                   <svg width="38" height="42" viewBox="0 0 38 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                       <path d="M33.7778 4.20038H24.9533C24.5211 2.97282 23.716 1.90922 22.6494 1.15671C21.5829 0.40421 20.3076 0 19 0C17.6924 0 16.4171 0.40421 15.3506 1.15671C14.284 1.90922 13.4789 2.97282 13.0467 4.20038H4.22222C3.10345 4.20371 2.03145 4.64727 1.24035 5.43419C0.449254 6.22112 0.00334131 7.28746 0 8.40034V37.8C0.00334131 38.9129 0.449254 39.9793 1.24035 40.7662C2.03145 41.5531 3.10345 41.9967 4.22222 42H33.7778C34.8966 41.9967 35.9686 41.5531 36.7597 40.7662C37.5507 39.9793 37.9967 38.9129 38 37.8V8.40034C37.9967 7.28746 37.5507 6.22112 36.7597 5.43419C35.9686 4.64727 34.8966 4.20371 33.7778 4.20038ZM19 4.20038C19.4175 4.20038 19.8257 4.32354 20.1729 4.55429C20.52 4.78504 20.7906 5.11301 20.9504 5.49673C21.1102 5.88046 21.152 6.30269 21.0705 6.71005C20.9891 7.1174 20.788 7.49158 20.4928 7.78527C20.1975 8.07896 19.8214 8.27896 19.4119 8.35999C19.0023 8.44102 18.5779 8.39943 18.1921 8.24049C17.8064 8.08155 17.4766 7.81239 17.2447 7.46705C17.0127 7.12171 16.8889 6.7157 16.8889 6.30036C16.8906 5.74392 17.1135 5.21075 17.5091 4.81729C17.9046 4.42383 18.4406 4.20204 19 4.20038ZM14.7778 14.7003L20.6678 20.5676L25.9878 15.2757L23.2222 12.6003H31.6667V21.0002L28.9729 18.2471L20.672 26.5106L14.7778 20.6432L9.31845 26.0696L6.33333 23.1002L14.7778 14.7003ZM33.7778 35.7001H4.22222V31.5001H33.7778V35.7001Z" fill="#26344B" />
                                                   </svg>
                                               </div>
                                               <div class="col-md-8 mt-step-col">
                                                   <div class="mt-step-title uppercase font-blue" style="font-size:1.2rem"><?php echo $rowMain['Project_Name']; ?></div>
                                                   <div class="mt-step-content font-grey-cascade" style="font-size:1rem">Due Date: <?php echo date("Y-m-d", strtotime($rowMain['Desired_Deliver_Date'])); ?></div>
                                               </div>
                                               <div class="col-md-1 mt-step-col">
                                                   <div class="mt-step-title uppercase font-green" style="font-size:1.6rem">
                                                       <?php
                                                        $myProMain = $_GET['view_id'];
                                                        $counter = 1;
                                                        $sql_MyTask = $conn->query("SELECT * FROM tbl_MyProject_Services_Childs_action_Items where Parent_MyPro_PK = $myProMain ");
                                                        while ($data_MyTask = $sql_MyTask->fetch_array()) {
                                                            $MyTask = $data_MyTask['CAI_Assign_to'];
                                                            $h_id = $data_MyTask['Services_History_PK'];
                                                            $counter_result = $counter++;
                                                        }
                                                        $sql_compliance = $conn->query("SELECT COUNT(*) as compliance FROM tbl_MyProject_Services_Childs_action_Items where Parent_MyPro_PK = $myProMain and CIA_progress = 2");
                                                        while ($data_compliance = $sql_compliance->fetch_array()) {
                                                            $comp = $data_compliance['compliance'];
                                                        }
                                                        $sql_none_compliance = $conn->query("SELECT COUNT(*) as non_comp FROM tbl_MyProject_Services_Childs_action_Items where Parent_MyPro_PK = $myProMain and CIA_progress != 2");
                                                        while ($data_none_compliance = $sql_none_compliance->fetch_array()) {
                                                            $non = $data_none_compliance['non_comp'];
                                                        }
                                                        $ptc = 0;
                                                        if (!empty($comp) && !empty($non)) {
                                                            $percent = $comp / $counter_result;
                                                            $ptc = number_format($percent * 100, 2) . '%';
                                                        } else if (empty($non) && !empty($comp)) {
                                                            $ptc = '100%';
                                                        } else {
                                                            $ptc = '0%';
                                                        }
                                                        echo $ptc;
                                                        ?>
                                                   </div>
                                                   <div class="mt-step-content font-grey-cascade" style="font-size:1.2rem">Compliance</div>
                                               </div>
                                           </div>
                                           
                                            <div class="actions">
                                                <ul class="list-inline" style="display: inline-block;">
                                                    <li style="padding-right:70px;">
                                                            <form class="search-form" id="main_search_form">
                                                                    <div class="portlet-input input-inline">
                                                                        <div class="input-icon right">
                                                                            <i class="icon-magnifier"></i>
                                                                             <input hidden value="<?php echo $_GET['view_id'];?>" id="projectId">
                                                                            <input type="text" id="search_input" class="form-control input-circle" placeholder="search...ID# or Name">
                                                                        </div>
                                                                        <div id="search_results" width="30%"></div>
                                                                    </div>
                                                            </form>
                                                    </li>
                                                    <li>
                                                        <div class="photo" style="padding-right:20px;">
                                                           <ul class="image-list">
                                                                 <?php
                                                                     if (!empty($_COOKIE['switchAccount'])) {
                                                                        	$p_user = $_COOKIE['ID'];
                                                                        	$u_id = $_COOKIE['switchAccount'];
                                                                        }
                                                                        else {
                                                                        	$p_user = $_COOKIE['ID'];
                                                                        	$u_id = employerID($p_user);
                                                                        }
                                                                        $selectData = mysqli_query($conn, "SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $myProMain");
                                                                        
                                                                        if (mysqli_num_rows($selectData) > 0) {
                                                                            $row = mysqli_fetch_array($selectData);
                                                                        }
                                                                        
                                                                        $queryCollab = "SELECT * FROM tbl_hr_employee WHERE user_id = $u_id AND status = 1 ORDER BY first_name ASC";
                                                                        $resultCollab = mysqli_query($conn, $queryCollab);
                                                                        
                                                                        // Initialize the counter
                                                                        $counter = 0;
                                                                        $remainingUsersNames = []; // Array to store the names of remaining users
                                                                        
                                                                        while ($rowCollab = mysqli_fetch_array($resultCollab)) {
                                                                            $sql = mysqli_query($conn, "SELECT * FROM tbl_user WHERE is_active = 1 AND employee_id = '" . $rowCollab['ID'] . "'");
                                                                        
                                                                            if (mysqli_num_rows($sql) > 0) {
                                                                                $rows = mysqli_fetch_assoc($sql);
                                                                        
                                                                                $selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '" . $rows['ID'] . "'");
                                                                        
                                                                                if (mysqli_num_rows($selectUserInfo) > 0) {
                                                                                    $rowInfo = mysqli_fetch_assoc($selectUserInfo);
                                                                                    $current_userAvatar = $rowInfo['avatar'];
                                                                                }
                                                                            }
                                                                        
                                                                            $firstNameInitial = strtoupper(substr($rowCollab['first_name'], 0, 1));
                                                                            $lastNameInitial = strtoupper(substr($rowCollab['last_name'], 0, 1));
                                                                            $initials = $firstNameInitial . $lastNameInitial;
                                                                        
                                                                            $randomColor = '#' . substr(md5(rand()), 0, 6);
                                                                        
                                                                            $profilePicture = !empty($current_userAvatar) ? $base_url . 'uploads/avatar/' . $current_userAvatar : '';
                                                                        
                                                                            $array_collab = explode(", ", $row["Collaborator_PK"]);
                                                                            if (in_array($rowCollab['ID'], $array_collab)) {
                                                                                $counter++; // Increment the counter after checking a user's eligibility
                                                                        
                                                                                if ($counter <= 5) {
                                                                                    echo '<li>';
                                                                                    echo '<span tooltip="' . $rowCollab['first_name'] . '&nbsp;' . $rowCollab['last_name'] . '">';
                                                                        
                                                                                    if (!empty($profilePicture)) {
                                                                                        echo '<a href="#">';
                                                                                        echo '<img src="' . $profilePicture . '" class="img-circle image--cover" alt="' . $initials . '" width="27px" height="27px">';
                                                                                        echo '</a>';
                                                                                    } else {
                                                                                        echo '<label class="img-circle image--cover" style="color:white;padding:0.3rem;align-items: center; justify-content: center; text-align: center; width: 27px; height: 27px; background-color: ' . $randomColor . ';">' . $initials . '</label>';
                                                                                    }
                                                                        
                                                                                    echo '</span>';
                                                                                    echo '</li>';
                                                                                } else {
                                                                                    $remainingUsersNames[] = $rowCollab['first_name'] . ' ' . $rowCollab['last_name'];
                                                                                }
                                                                            }
                                                                        }
                                                                        
                                                                        $remainingUsers = count($array_collab) - $counter;
                                                                        
                                                                        if ($remainingUsers > 0) {
                                                                            echo '<li>';
                                                                            echo '<span tooltip="' . implode(', ', $remainingUsersNames) . '">';
                                                                            echo '<label class="img-circle image--cover" style="color:white;padding:0.3rem;align-items: center; justify-content: center; text-align: center; width: 27px; height: 27px;background-color:black;">5+</label>';
                                                                            echo '</span>';
                                                                            echo '</li>';
                                                                        }
                                                                        ?>

                                                                    </ul>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="btn-group share-dropdown">
                                                            <a class="btn red btn-circle" data-toggle="modal" data-target="#collaborator">
                                                                <i class="fa fa-users"></i>
                                                                <span class="hidden-xs"> Share </span>
                                                                <i class="fa fa-share-alt"></i>
                                                            </a>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="btn-group">
                                                            <a class="btn green btn-circle" href="javascript:;" data-toggle="dropdown">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <ul class="dropdown-menu pull-right">
                                                                <li>
                                                                    <a style="color:#fffff;font-size:12px" href="#modalAddActionItem" data-toggle="modal" class="btn-xs" onclick="btnNew_File(<?php echo  $rowMain['MyPro_id']; ?>)"><i class="fa fa-plus-circle">&nbsp;</i>Add Task</a>
                                                                </li>
                                                                  <li>
                                                                    <a href="javascript:;" data-id="<?php echo $_GET['view_id'];?>" id="PrintToPdf" class="btn-xs">
                                                                    <i class="fa fa-file-pdf-o"></i> Save as PDF </a>
                                                                 </li>
                                                                           <li>
                                                                    <?php  
                                                                $selectData = mysqli_query($conn, "SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = '{$_GET['view_id']}'");
                                                                if (mysqli_num_rows($selectData) > 0) {
                                                                $row = mysqli_fetch_array($selectData);
                                                                $disabledbutton = ($row['user_cookies'] == $user_id) ? 'disabled' : '';
                                                                echo '<a href="javascript:;" class="'.$disabledbutton.' btn-xs" onclick="btnDeleteProject(' . $_GET['view_id'] . ')"><i class="fa fa-trash" aria-hidden="true"></i>Delete</a>';
                                                                  }
                                                                  ?>

                                                              </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                       </div>
                                   <?php } ?>
                                   <!-- end of portflet header -->
                                   <div class="portlet-body">
                                       <div class="mt-element-card mt-element-overlay">
                                           <div class="row">
                                               <div class="board">
                                                   <div class="board-column todo" data-column-id="0">
                                                       <div class="board-column-header">
                                                             <span class="caption-subject font-blue sbold uppercase">Not Started</span> &nbsp;
                                                       <a class="btn green btn-outline btn-circle">
                                                           <span class="caption-subject font-grey-cascade sbold uppercase" id="columnStatus1"> </span>
                                                       </a>
                                                       </div>
                                                       <div class="board-column-content-wrapper">
                                                           <div class="board-column-content">
                                                                                                       
                                                               <!-- <div class="board-item">
                                                                   <div class="board-item-content"><span>Item #</span>1</div>
                                                               </div> -->
                                                               <?php
                                                                $portal_user = $_COOKIE['ID'];
                                                            	$user_id = employerID($portal_user);
                                                                $selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
                                                                $rowUser = mysqli_fetch_array($selectUser);
                                                                $current_client = $rowUser['client'];
                                                                
                                                                
                                                                $view_id = $_GET['view_id'];
                                                                $sql = $conn->query("SELECT *,tbl_MyProject_Services_History.user_id as owner
                                                                     FROM tbl_MyProject_Services_History 
                                                                     left join tbl_MyProject_Services_Action_Items on tbl_MyProject_Services_Action_Items.Action_Items_id = tbl_MyProject_Services_History.Action_taken
                                                                     where tbl_MyProject_Services_History.tmsh_column_status=0 AND tbl_MyProject_Services_History.MyPro_PK = $view_id AND tbl_MyProject_Services_History.is_deleted=0 ORDER BY order_index");
                                                                //  $i = 0;
                                                                $response = '';
                                                                while ($data1 = $sql->fetch_array()) {
                                                                    
                                                                    $id_st = $data1['History_id'];
                                                                    $ck = 786;
                                                                    // $ck = $_COOKIE['employee_id'];
                                                                    $counter_result = 0;
                                                                    $MyTask = '';
                                                                    $h_id = '';
                                                                    $ptc = '';
                                                                    //  AND CAI_Assign_to = $ck 
                                                                    //    $view_id = $_POST['view_id'];
                                                                    $sql__MyTask = $conn->query("SELECT COUNT(*) as taskcount FROM tbl_MyProject_Services_Childs_action_Items WHERE Services_History_PK = '$id_st' AND is_deleted = 0");
                                                                    $data_MyTask = $sql__MyTask->fetch_array();
                                                                    $counter_result = $data_MyTask['taskcount'];
                                                            
                                                                 
                                                                    $sql_counters = $conn->query("SELECT COUNT(*) as counter FROM tbl_MyProject_Services_Comment where Task_ids = '$id_st'");
                                                                    while ($data_counters = $sql_counters->fetch_array()) {
                                                                        $count_result = $data_counters['counter'];
                                                                    }
                                                                    $sql_compliance = $conn->query("SELECT COUNT(*) as compliance FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress = 2 AND is_deleted = 0");
                                                                    while ($data_compliance = $sql_compliance->fetch_array()) {
                                                                        $comp = $data_compliance['compliance'];
                                                                    }
                                                                    $sql_none_compliance = $conn->query("SELECT COUNT(*) as non_comp FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress != 2 AND is_deleted = 0");
                                                                    while ($data_none_compliance = $sql_none_compliance->fetch_array()) {
                                                                        $non = $data_none_compliance['non_comp'];
                                                                    }
                                                                    $ptc = 0;
                                                                    if (!empty($comp) && !empty($non)) {
                                                                        $percent = $comp / $counter_result;
                                                                        $ptc = number_format($percent * 100, 2) . '%';
                                                                    } elseif (empty($non) && !empty($comp)) {
                                                                        $ptc = '100%';
                                                                    } else {
                                                                        $ptc = '0%';
                                                                    }
                                                                    if($data1['Assign_to_history']==NULL){
                                                                          $initials = "N/A";
                                                                         $profilePicture = "";  
                                                                    }else{
                                                                      $owner  = $data1['Assign_to_history'];
                                                                       $query = "SELECT * FROM tbl_user where employee_id = '$owner'";
                                                                                $result = mysqli_query($conn, $query);
                                                                                while ($row = mysqli_fetch_array($result)) {
                                                                                       $selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$row['ID']."'");
                                                                                                                                                    
                                                                                          if (mysqli_num_rows($selectUserInfo) > 0) {
                                                                                          $rowInfo = mysqli_fetch_assoc($selectUserInfo);
                                                                                          $current_userAvatar = $rowInfo['avatar'];
                                                                                           }
                                                                                    $firstNameInitial = strtoupper(substr($row['first_name'], 0, 1));
                                                                                    $lastNameInitial = strtoupper(substr($row['last_name'], 0, 1));
                                                                                    $initials = $firstNameInitial.''.$lastNameInitial;
                                                                                }
                                                                                 $profilePicture = !empty($current_userAvatar) ? $base_url.'uploads/avatar/'.$current_userAvatar : '';
                                                                    }
                                                               
                                                                    
                                                                    $randomColor = '#' . substr(md5(rand()), 0, 6);
                                                                     $title = $data1['filename'];
                                                                    $max_length = 35; // Maximum length of the truncated title
                                                                    
                                                                    if (strlen($title) > $max_length) {
                                                                        $truncated_title = substr($title, 0, $max_length) . '...';
                                                                    } else {
                                                                        $truncated_title = $title;
                                                                    }
                                                                    $currentDay = date('j');
                                                                    $disabledClass = ($currentDay <=12 && $currentDay > 15) ? 'disabled' : '';
                                                                     $disabledbutton = ($portal_user == $data1['owner']) ? '' : 'disabled';
                                                                     $response .= '
                                                                            <div id="cardData" data-task-id="' . $id_st . '" data-id="' . $id_st . '" class="board-item card">
                                                                            <div class="board-item-content table">
                                                                                  <div class="ftr">
                                                                                            <div class="author">
                                                                                                <a href="#">  
                                                                                               <h6 class="category text-danger">
                                                                                                           <i class="fa fa-check-circle-o"></i>&nbsp;<span>' . $truncated_title . '</span>
                                                                                                </h6>
                                                                                                    <div class="ripple-cont">
                                                                                                        <div class="ripple ripple-on ripple-out" style="left: 574px; top: 364px; background-color: rgb(60, 72, 88); transform: scale(11.875);"></div>
                                                                                                    </div>
                                                                                                </a>
                                                                                            </div>
                                                                                            <div class="stats"> 
                                                                                              <span tooltip="Compliance" class="uppercase font-green">' . $ptc .
                                                                                           '</span>
                                                                                            </div>
                                                                                        </div>
                                                                                <h5 class="card-caption">
                                                                    <p>';
                                                                    $stringProduct = strip_tags($data1['description']);
                                                                    if (strlen($stringProduct) > 76) {
                                                                        $stringCut = substr($stringProduct, 0, 76);
                                                                        $endPoint = strrpos($stringCut, ' ');
                                                                        $stringProduct = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                                        $hiddenContent = substr($stringProduct, strlen($stringCut));

                                                                        $stringProduct .= '&nbsp;<a class="see-more" style="font-size:12px; cursor: pointer;">
                                                                         <i style="color:black;">See more...</i></a>';

                                                                        $response .= "<div id='hidden-content' style='display: none;'>$hiddenContent</div>";
                                                                        $response .= "<script>
                                                                         document.addEventListener('DOMContentLoaded', function() {
                                                                         var seeMoreLink = document.querySelector('.see-more');
                                                                         var hiddenContent = document.getElementById('hidden-content');
                                                                         seeMoreLink.addEventListener('click', function() {
                                                                         hiddenContent.style.display = 'block';
                                                                         seeMoreLink.style.display = 'none';
                                                                         });
                                                                          });
                                                                         </script>";
                                                                    }
                                                                    $response .= "$stringProduct";
                                                                    $response .= '</p>
                                                                                        </h5>
                                                                                <div class="ftr">
                                                                                    <div class="author">';
                                                                                    if (!empty($profilePicture)) {
                                                                                        $response .= '<a href="#">';
                                                                                        $response .= '<img src="' . $profilePicture . '" class="avatar img-circle"  alt="' . $initials . '" width="27px" height="27px">';
                                                                                        $response .= '</a>';
                                                                                    } else {
                                                                                        $response .= '<label class="img-circle" style="color:white;padding:0.3rem;align-items: center; justify-content: center; text-align: center; width: 27px; height: 27px; background-color: ' . $randomColor . ';">' . $initials . '</label>';
                                                                                    }
                                                                                       $response.= '<a href="#">
                                                                                         <span tooltip="Due Date">&nbsp;' . date("Y-m-d", strtotime($data1['Action_date'])) . '</span>
                                                                                            <div class="ripple-cont">
                                                                                                <div class="ripple ripple-on ripple-out" style="left: 574px; top: 364px; background-color: rgb(60, 72, 88); transform: scale(11.875);"></div>
                                                                                            </div>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="stats">  <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                                                                           <path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C7.46957 2 6.96086 2.21071 6.58579 2.58579C6.21071 2.96086 6 3.46957 6 4H10C10 3.46957 9.78929 2.96086 9.41421 2.58579C9.03914 2.21071 8.53043 2 8 2ZM5.354 1C6.059 0.378 6.986 0 8 0C9.014 0 9.94 0.378 10.646 1H14C14.5304 1 15.0391 1.21071 15.4142 1.58579C15.7893 1.96086 16 2.46957 16 3V18C16 18.5304 15.7893 19.0391 15.4142 19.4142C15.0391 19.7893 14.5304 20 14 20H2C1.46957 20 0.960859 19.7893 0.585786 19.4142C0.210714 19.0391 0 18.5304 0 18V3C0 2.46957 0.210714 1.96086 0.585786 1.58579C0.960859 1.21071 1.46957 1 2 1H5.354ZM4.126 3H2V18H14V3H11.874C11.956 3.32 12 3.655 12 4V5C12 5.26522 11.8946 5.51957 11.7071 5.70711C11.5196 5.89464 11.2652 6 11 6H5C4.73478 6 4.48043 5.89464 4.29289 5.70711C4.10536 5.51957 4 5.26522 4 5V4C4 3.655 4.044 3.32 4.126 3ZM4 9C4 8.73478 4.10536 8.48043 4.29289 8.29289C4.48043 8.10536 4.73478 8 5 8H11C11.2652 8 11.5196 8.10536 11.7071 8.29289C11.8946 8.48043 12 8.73478 12 9C12 9.26522 11.8946 9.51957 11.7071 9.70711C11.5196 9.89464 11.2652 10 11 10H5C4.73478 10 4.48043 9.89464 4.29289 9.70711C4.10536 9.51957 4 9.26522 4 9ZM4 13C4 12.7348 4.10536 12.4804 4.29289 12.2929C4.48043 12.1054 4.73478 12 5 12H8C8.26522 12 8.51957 12.1054 8.70711 12.2929C8.89464 12.4804 9 12.7348 9 13C9 13.2652 8.89464 13.5196 8.70711 13.7071C8.51957 13.8946 8.26522 14 8 14H5C4.73478 14 4.48043 13.8946 4.29289 13.7071C4.10536 13.5196 4 13.2652 4 13Z" fill="#C2B7B7" />
                                                                                                        </svg> ' . $counter_result . ' &nbsp; 
                                                                                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                                         <path d="M7 20C6.73478 20 6.48043 19.8946 6.29289 19.7071C6.10536 19.5196 6 19.2652 6 19V16H2C1.46957 16 0.960859 15.7893 0.585786 15.4142C0.210714 15.0391 0 14.5304 0 14V2C0 1.46957 0.210714 0.960859 0.585786 0.585786C0.960859 0.210714 1.46957 0 2 0H18C18.5304 0 19.0391 0.210714 19.4142 0.585786C19.7893 0.960859 20 1.46957 20 2V14C20 14.5304 19.7893 15.0391 19.4142 15.4142C19.0391 15.7893 18.5304 16 18 16H11.9L8.2 19.71C8 19.9 7.75 20 7.5 20H7ZM8 14V17.08L11.08 14H18V2H2V14H8ZM14 12H6V11C6 9.67 8.67 9 10 9C11.33 9 14 9.67 14 11V12ZM10 4C10.5304 4 11.0391 4.21071 11.4142 4.58579C11.7893 4.96086 12 5.46957 12 6C12 6.53043 11.7893 7.03914 11.4142 7.41421C11.0391 7.78929 10.5304 8 10 8C9.46957 8 8.96086 7.78929 8.58579 7.41421C8.21071 7.03914 8 6.53043 8 6C8 5.46957 8.21071 4.96086 8.58579 4.58579C8.96086 4.21071 9.46957 4 10 4Z" fill="#C2B7B7" />
                                                                                                         </svg>
                                                                                                        </i> ' . $count_result . ' </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                     ';
                                                                }
                                                                echo $response;

                                                                ?>
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div class="board-column working" data-column-id="1">
                                                       <div class="board-column-header">
                                                             <span class="caption-subject font-blue sbold uppercase">IN-Progress</span> &nbsp;
                                                       <a class="btn green btn-outline btn-circle">
                                                           <span class="caption-subject font-grey-cascade sbold uppercase" id="columnStatus2"> </span>
                                                       </a>
                                                       </div>
                                                       <div class="board-column-content-wrapper">
                                                           <div class="board-column-content">
                                                               <?php
                                                                $portal_user = $_COOKIE['ID'];
                                                            	$user_id = employerID($portal_user);
                                                                $selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
                                                                $rowUser = mysqli_fetch_array($selectUser);
                                                                $current_client = $rowUser['client'];
                                                                
                                                                
                                                                $view_id = $_GET['view_id'];
                                                                $sql = $conn->query("SELECT *,tbl_MyProject_Services_History.user_id as owner
                                                                     FROM tbl_MyProject_Services_History 
                                                                     left join tbl_MyProject_Services_Action_Items on tbl_MyProject_Services_Action_Items.Action_Items_id = tbl_MyProject_Services_History.Action_taken
                                                                     where tbl_MyProject_Services_History.tmsh_column_status=1 AND tbl_MyProject_Services_History.MyPro_PK = $view_id AND tbl_MyProject_Services_History.is_deleted=0 ORDER BY order_index");
                                                                //  $i = 0;
                                                                $response = '';
                                                                while ($data1 = $sql->fetch_array()) {
                                                                    
                                                                    $id_st = $data1['History_id'];
                                                                    $ck = 786;
                                                                    // $ck = $_COOKIE['employee_id'];
                                                                    $counter_result = 0;
                                                                    $MyTask = '';
                                                                    $h_id = '';
                                                                    $ptc = '';
                                                                    //  AND CAI_Assign_to = $ck 
                                                                    //    $view_id = $_POST['view_id'];
                                                                    $sql__MyTask = $conn->query("SELECT COUNT(*) as taskcount FROM tbl_MyProject_Services_Childs_action_Items WHERE Services_History_PK = '$id_st' AND is_deleted = 0");
                                                                    $data_MyTask = $sql__MyTask->fetch_array();
                                                                    $counter_result = $data_MyTask['taskcount'];
                                                            
                                                                 
                                                                    $sql_counters = $conn->query("SELECT COUNT(*) as counter FROM tbl_MyProject_Services_Comment where Task_ids = '$id_st'");
                                                                    while ($data_counters = $sql_counters->fetch_array()) {
                                                                        $count_result = $data_counters['counter'];
                                                                    }
                                                                    $sql_compliance = $conn->query("SELECT COUNT(*) as compliance FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress = 2 AND is_deleted = 0");
                                                                    while ($data_compliance = $sql_compliance->fetch_array()) {
                                                                        $comp = $data_compliance['compliance'];
                                                                    }
                                                                    $sql_none_compliance = $conn->query("SELECT COUNT(*) as non_comp FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress != 2 AND is_deleted = 0");
                                                                    while ($data_none_compliance = $sql_none_compliance->fetch_array()) {
                                                                        $non = $data_none_compliance['non_comp'];
                                                                    }
                                                                    $ptc = 0;
                                                                    if (!empty($comp) && !empty($non)) {
                                                                        $percent = $comp / $counter_result;
                                                                        $ptc = number_format($percent * 100, 2) . '%';
                                                                    } elseif (empty($non) && !empty($comp)) {
                                                                        $ptc = '100%';
                                                                    } else {
                                                                        $ptc = '0%';
                                                                    }
                                                                    if($data1['Assign_to_history']==NULL){
                                                                          $initials = "N/A";
                                                                         $profilePicture = "";  
                                                                    }else{
                                                                      $owner  = $data1['Assign_to_history'];
                                                                       $query = "SELECT * FROM tbl_user where employee_id = '$owner'";
                                                                                $result = mysqli_query($conn, $query);
                                                                                while ($row = mysqli_fetch_array($result)) {
                                                                                       $selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$row['ID']."'");
                                                                                                                                                    
                                                                                          if (mysqli_num_rows($selectUserInfo) > 0) {
                                                                                          $rowInfo = mysqli_fetch_assoc($selectUserInfo);
                                                                                          $current_userAvatar = $rowInfo['avatar'];
                                                                                           }
                                                                                    $firstNameInitial = strtoupper(substr($row['first_name'], 0, 1));
                                                                                    $lastNameInitial = strtoupper(substr($row['last_name'], 0, 1));
                                                                                    $initials = $firstNameInitial.''.$lastNameInitial;
                                                                                }
                                                                                 $profilePicture = !empty($current_userAvatar) ? $base_url.'uploads/avatar/'.$current_userAvatar : '';
                                                                    }
                                                               
                                                                    
                                                                    $randomColor = '#' . substr(md5(rand()), 0, 6);
                                                                     $title = $data1['filename'];
                                                                    $max_length = 35; // Maximum length of the truncated title
                                                                    
                                                                    if (strlen($title) > $max_length) {
                                                                        $truncated_title = substr($title, 0, $max_length) . '...';
                                                                    } else {
                                                                        $truncated_title = $title;
                                                                    }
                                                                    $currentDay = date('j');
                                                                    $disabledClass = ($currentDay <=12 && $currentDay > 15) ? 'disabled' : '';
                                                                     $disabledbutton = ($portal_user == $data1['owner']) ? '' : 'disabled';
                                                                     $response .= '
                                                                            <div id="cardData" data-task-id="' . $id_st . '" data-id="' . $id_st . '" class="board-item card">
                                                                            <div class="board-item-content table">
                                                                                  <div class="ftr">
                                                                                            <div class="author">
                                                                                                <a href="#">  
                                                                                               <h6 class="category text-danger">
                                                                                                           <i class="fa fa-check-circle-o"></i>&nbsp;<span>' . $truncated_title . '</span>
                                                                                                </h6>
                                                                                                    <div class="ripple-cont">
                                                                                                        <div class="ripple ripple-on ripple-out" style="left: 574px; top: 364px; background-color: rgb(60, 72, 88); transform: scale(11.875);"></div>
                                                                                                    </div>
                                                                                                </a>
                                                                                            </div>
                                                                                            <div class="stats"> 
                                                                                              <span tooltip="Compliance" class="uppercase font-green">' . $ptc .
                                                                                           '</span>
                                                                                            </div>
                                                                                        </div>
                                                                                <h5 class="card-caption">
                                                                    <p>';
                                                                    $stringProduct = strip_tags($data1['description']);
                                                                    if (strlen($stringProduct) > 76) {
                                                                        $stringCut = substr($stringProduct, 0, 76);
                                                                        $endPoint = strrpos($stringCut, ' ');
                                                                        $stringProduct = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                                        $hiddenContent = substr($stringProduct, strlen($stringCut));

                                                                        $stringProduct .= '&nbsp;<a class="see-more" style="font-size:12px; cursor: pointer;">
                                                                         <i style="color:black;">See more...</i></a>';

                                                                        $response .= "<div id='hidden-content' style='display: none;'>$hiddenContent</div>";
                                                                        $response .= "<script>
                                                                         document.addEventListener('DOMContentLoaded', function() {
                                                                         var seeMoreLink = document.querySelector('.see-more');
                                                                         var hiddenContent = document.getElementById('hidden-content');
                                                                         seeMoreLink.addEventListener('click', function() {
                                                                         hiddenContent.style.display = 'block';
                                                                         seeMoreLink.style.display = 'none';
                                                                         });
                                                                          });
                                                                         </script>";
                                                                    }
                                                                    $response .= "$stringProduct";
                                                                    $response .= '</p>
                                                                                        </h5>
                                                                                <div class="ftr">
                                                                                    <div class="author">';
                                                                                    if (!empty($profilePicture)) {
                                                                                        $response .= '<a href="#">';
                                                                                        $response .= '<img src="' . $profilePicture . '" class="avatar img-circle"  alt="' . $initials . '" width="27px" height="27px">';
                                                                                        $response .= '</a>';
                                                                                    } else {
                                                                                        $response .= '<label class="img-circle" style="color:white;padding:0.3rem;align-items: center; justify-content: center; text-align: center; width: 27px; height: 27px; background-color: ' . $randomColor . ';">' . $initials . '</label>';
                                                                                    }
                                                                                       $response.= '<a href="#">
                                                                                         <span tooltip="Due Date">&nbsp;' . date("Y-m-d", strtotime($data1['Action_date'])) . '</span>
                                                                                            <div class="ripple-cont">
                                                                                                <div class="ripple ripple-on ripple-out" style="left: 574px; top: 364px; background-color: rgb(60, 72, 88); transform: scale(11.875);"></div>
                                                                                            </div>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="stats">  <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                                                                           <path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C7.46957 2 6.96086 2.21071 6.58579 2.58579C6.21071 2.96086 6 3.46957 6 4H10C10 3.46957 9.78929 2.96086 9.41421 2.58579C9.03914 2.21071 8.53043 2 8 2ZM5.354 1C6.059 0.378 6.986 0 8 0C9.014 0 9.94 0.378 10.646 1H14C14.5304 1 15.0391 1.21071 15.4142 1.58579C15.7893 1.96086 16 2.46957 16 3V18C16 18.5304 15.7893 19.0391 15.4142 19.4142C15.0391 19.7893 14.5304 20 14 20H2C1.46957 20 0.960859 19.7893 0.585786 19.4142C0.210714 19.0391 0 18.5304 0 18V3C0 2.46957 0.210714 1.96086 0.585786 1.58579C0.960859 1.21071 1.46957 1 2 1H5.354ZM4.126 3H2V18H14V3H11.874C11.956 3.32 12 3.655 12 4V5C12 5.26522 11.8946 5.51957 11.7071 5.70711C11.5196 5.89464 11.2652 6 11 6H5C4.73478 6 4.48043 5.89464 4.29289 5.70711C4.10536 5.51957 4 5.26522 4 5V4C4 3.655 4.044 3.32 4.126 3ZM4 9C4 8.73478 4.10536 8.48043 4.29289 8.29289C4.48043 8.10536 4.73478 8 5 8H11C11.2652 8 11.5196 8.10536 11.7071 8.29289C11.8946 8.48043 12 8.73478 12 9C12 9.26522 11.8946 9.51957 11.7071 9.70711C11.5196 9.89464 11.2652 10 11 10H5C4.73478 10 4.48043 9.89464 4.29289 9.70711C4.10536 9.51957 4 9.26522 4 9ZM4 13C4 12.7348 4.10536 12.4804 4.29289 12.2929C4.48043 12.1054 4.73478 12 5 12H8C8.26522 12 8.51957 12.1054 8.70711 12.2929C8.89464 12.4804 9 12.7348 9 13C9 13.2652 8.89464 13.5196 8.70711 13.7071C8.51957 13.8946 8.26522 14 8 14H5C4.73478 14 4.48043 13.8946 4.29289 13.7071C4.10536 13.5196 4 13.2652 4 13Z" fill="#C2B7B7" />
                                                                                                        </svg> ' . $counter_result . ' &nbsp; 
                                                                                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                                         <path d="M7 20C6.73478 20 6.48043 19.8946 6.29289 19.7071C6.10536 19.5196 6 19.2652 6 19V16H2C1.46957 16 0.960859 15.7893 0.585786 15.4142C0.210714 15.0391 0 14.5304 0 14V2C0 1.46957 0.210714 0.960859 0.585786 0.585786C0.960859 0.210714 1.46957 0 2 0H18C18.5304 0 19.0391 0.210714 19.4142 0.585786C19.7893 0.960859 20 1.46957 20 2V14C20 14.5304 19.7893 15.0391 19.4142 15.4142C19.0391 15.7893 18.5304 16 18 16H11.9L8.2 19.71C8 19.9 7.75 20 7.5 20H7ZM8 14V17.08L11.08 14H18V2H2V14H8ZM14 12H6V11C6 9.67 8.67 9 10 9C11.33 9 14 9.67 14 11V12ZM10 4C10.5304 4 11.0391 4.21071 11.4142 4.58579C11.7893 4.96086 12 5.46957 12 6C12 6.53043 11.7893 7.03914 11.4142 7.41421C11.0391 7.78929 10.5304 8 10 8C9.46957 8 8.96086 7.78929 8.58579 7.41421C8.21071 7.03914 8 6.53043 8 6C8 5.46957 8.21071 4.96086 8.58579 4.58579C8.96086 4.21071 9.46957 4 10 4Z" fill="#C2B7B7" />
                                                                                                         </svg>
                                                                                                        </i> ' . $count_result . ' </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                     ';
                                                                }
                                                                echo $response;

                                                                ?>
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div class="board-column done" data-column-id="2">
                                                       <div class="board-column-header">
                                                             <span class="caption-subject font-blue sbold uppercase">Completed</span> &nbsp;
                                                       <a class="btn green btn-outline btn-circle">
                                                           <span class="caption-subject font-grey-cascade sbold uppercase" id="columnStatus3"> </span>
                                                       </a>
                                                       </div>
                                                       <div class="board-column-content-wrapper">
                                                           <div class="board-column-content">
                                                              <?php
                                                                $portal_user = $_COOKIE['ID'];
                                                            	$user_id = employerID($portal_user);
                                                                $selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
                                                                $rowUser = mysqli_fetch_array($selectUser);
                                                                $current_client = $rowUser['client'];
                                                                
                                                                
                                                                $view_id = $_GET['view_id'];
                                                                $sql = $conn->query("SELECT *,tbl_MyProject_Services_History.user_id as owner
                                                                     FROM tbl_MyProject_Services_History 
                                                                     left join tbl_MyProject_Services_Action_Items on tbl_MyProject_Services_Action_Items.Action_Items_id = tbl_MyProject_Services_History.Action_taken
                                                                     where tbl_MyProject_Services_History.tmsh_column_status=2 AND tbl_MyProject_Services_History.MyPro_PK = $view_id AND tbl_MyProject_Services_History.is_deleted=0 ORDER BY order_index");
                                                                //  $i = 0;
                                                                $response = '';
                                                                while ($data1 = $sql->fetch_array()) {
                                                                    
                                                                    $id_st = $data1['History_id'];
                                                                    $ck = 786;
                                                                    // $ck = $_COOKIE['employee_id'];
                                                                    $counter_result = 0;
                                                                    $MyTask = '';
                                                                    $h_id = '';
                                                                    $ptc = '';
                                                                    //  AND CAI_Assign_to = $ck 
                                                                    //    $view_id = $_POST['view_id'];
                                                                    $sql__MyTask = $conn->query("SELECT COUNT(*) as taskcount FROM tbl_MyProject_Services_Childs_action_Items WHERE Services_History_PK = '$id_st' AND is_deleted = 0");
                                                                    $data_MyTask = $sql__MyTask->fetch_array();
                                                                    $counter_result = $data_MyTask['taskcount'];
                                                            
                                                                 
                                                                    $sql_counters = $conn->query("SELECT COUNT(*) as counter FROM tbl_MyProject_Services_Comment where Task_ids = '$id_st'");
                                                                    while ($data_counters = $sql_counters->fetch_array()) {
                                                                        $count_result = $data_counters['counter'];
                                                                    }
                                                                    $sql_compliance = $conn->query("SELECT COUNT(*) as compliance FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress = 2 AND is_deleted = 0");
                                                                    while ($data_compliance = $sql_compliance->fetch_array()) {
                                                                        $comp = $data_compliance['compliance'];
                                                                    }
                                                                    $sql_none_compliance = $conn->query("SELECT COUNT(*) as non_comp FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress != 2 AND is_deleted = 0");
                                                                    while ($data_none_compliance = $sql_none_compliance->fetch_array()) {
                                                                        $non = $data_none_compliance['non_comp'];
                                                                    }
                                                                    $ptc = 0;
                                                                    if (!empty($comp) && !empty($non)) {
                                                                        $percent = $comp / $counter_result;
                                                                        $ptc = number_format($percent * 100, 2) . '%';
                                                                    } elseif (empty($non) && !empty($comp)) {
                                                                        $ptc = '100%';
                                                                    } else {
                                                                        $ptc = '0%';
                                                                    }
                                                                    if($data1['Assign_to_history']==NULL){
                                                                          $initials = "N/A";
                                                                         $profilePicture = "";  
                                                                    }else{
                                                                      $owner  = $data1['Assign_to_history'];
                                                                       $query = "SELECT * FROM tbl_user where employee_id = '$owner'";
                                                                                $result = mysqli_query($conn, $query);
                                                                                while ($row = mysqli_fetch_array($result)) {
                                                                                       $selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$row['ID']."'");
                                                                                                                                                    
                                                                                          if (mysqli_num_rows($selectUserInfo) > 0) {
                                                                                          $rowInfo = mysqli_fetch_assoc($selectUserInfo);
                                                                                          $current_userAvatar = $rowInfo['avatar'];
                                                                                           }
                                                                                    $firstNameInitial = strtoupper(substr($row['first_name'], 0, 1));
                                                                                    $lastNameInitial = strtoupper(substr($row['last_name'], 0, 1));
                                                                                    $initials = $firstNameInitial.''.$lastNameInitial;
                                                                                }
                                                                                 $profilePicture = !empty($current_userAvatar) ? $base_url.'uploads/avatar/'.$current_userAvatar : '';
                                                                    }
                                                               
                                                                    
                                                                    $randomColor = '#' . substr(md5(rand()), 0, 6);
                                                                     $title = $data1['filename'];
                                                                    $max_length = 35; // Maximum length of the truncated title
                                                                    
                                                                    if (strlen($title) > $max_length) {
                                                                        $truncated_title = substr($title, 0, $max_length) . '...';
                                                                    } else {
                                                                        $truncated_title = $title;
                                                                    }
                                                                    $currentDay = date('j');
                                                                    $disabledClass = ($currentDay <=12 && $currentDay > 15) ? 'disabled' : '';
                                                                     $disabledbutton = ($portal_user == $data1['owner']) ? '' : 'disabled';
                                                                     $response .= '
                                                                            <div id="cardData" data-task-id="' . $id_st . '" data-id="' . $id_st . '" class="board-item card">
                                                                            <div class="board-item-content table">
                                                                                  <div class="ftr">
                                                                                            <div class="author">
                                                                                                <a href="#">  
                                                                                               <h6 class="category text-danger">
                                                                                                           <i class="fa fa-check-circle-o"></i>&nbsp;<span>' . $truncated_title . '</span>
                                                                                                </h6>
                                                                                                    <div class="ripple-cont">
                                                                                                        <div class="ripple ripple-on ripple-out" style="left: 574px; top: 364px; background-color: rgb(60, 72, 88); transform: scale(11.875);"></div>
                                                                                                    </div>
                                                                                                </a>
                                                                                            </div>
                                                                                            <div class="stats"> 
                                                                                              <span tooltip="Compliance" class="uppercase font-green">' . $ptc .
                                                                                           '</span>
                                                                                            </div>
                                                                                        </div>
                                                                                <h5 class="card-caption">
                                                                    <p>';
                                                                    $stringProduct = strip_tags($data1['description']);
                                                                    if (strlen($stringProduct) > 76) {
                                                                        $stringCut = substr($stringProduct, 0, 76);
                                                                        $endPoint = strrpos($stringCut, ' ');
                                                                        $stringProduct = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                                        $hiddenContent = substr($stringProduct, strlen($stringCut));

                                                                        $stringProduct .= '&nbsp;<a class="see-more" style="font-size:12px; cursor: pointer;">
                                                                         <i style="color:black;">See more...</i></a>';

                                                                        $response .= "<div id='hidden-content' style='display: none;'>$hiddenContent</div>";
                                                                        $response .= "<script>
                                                                         document.addEventListener('DOMContentLoaded', function() {
                                                                         var seeMoreLink = document.querySelector('.see-more');
                                                                         var hiddenContent = document.getElementById('hidden-content');
                                                                         seeMoreLink.addEventListener('click', function() {
                                                                         hiddenContent.style.display = 'block';
                                                                         seeMoreLink.style.display = 'none';
                                                                         });
                                                                          });
                                                                         </script>";
                                                                    }
                                                                    $response .= "$stringProduct";
                                                                    $response .= '</p>
                                                                                        </h5>
                                                                                <div class="ftr">
                                                                                    <div class="author">';
                                                                                    if (!empty($profilePicture)) {
                                                                                        $response .= '<a href="#">';
                                                                                        $response .= '<img src="' . $profilePicture . '" class="avatar img-circle"  alt="' . $initials . '" width="27px" height="27px">';
                                                                                        $response .= '</a>';
                                                                                    } else {
                                                                                        $response .= '<label class="img-circle" style="color:white;padding:0.3rem;align-items: center; justify-content: center; text-align: center; width: 27px; height: 27px; background-color: ' . $randomColor . ';">' . $initials . '</label>';
                                                                                    }
                                                                                       $response.= '<a href="#">
                                                                                         <span tooltip="Due Date">&nbsp;' . date("Y-m-d", strtotime($data1['Action_date'])) . '</span>
                                                                                            <div class="ripple-cont">
                                                                                                <div class="ripple ripple-on ripple-out" style="left: 574px; top: 364px; background-color: rgb(60, 72, 88); transform: scale(11.875);"></div>
                                                                                            </div>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="stats">  <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                                                                           <path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C7.46957 2 6.96086 2.21071 6.58579 2.58579C6.21071 2.96086 6 3.46957 6 4H10C10 3.46957 9.78929 2.96086 9.41421 2.58579C9.03914 2.21071 8.53043 2 8 2ZM5.354 1C6.059 0.378 6.986 0 8 0C9.014 0 9.94 0.378 10.646 1H14C14.5304 1 15.0391 1.21071 15.4142 1.58579C15.7893 1.96086 16 2.46957 16 3V18C16 18.5304 15.7893 19.0391 15.4142 19.4142C15.0391 19.7893 14.5304 20 14 20H2C1.46957 20 0.960859 19.7893 0.585786 19.4142C0.210714 19.0391 0 18.5304 0 18V3C0 2.46957 0.210714 1.96086 0.585786 1.58579C0.960859 1.21071 1.46957 1 2 1H5.354ZM4.126 3H2V18H14V3H11.874C11.956 3.32 12 3.655 12 4V5C12 5.26522 11.8946 5.51957 11.7071 5.70711C11.5196 5.89464 11.2652 6 11 6H5C4.73478 6 4.48043 5.89464 4.29289 5.70711C4.10536 5.51957 4 5.26522 4 5V4C4 3.655 4.044 3.32 4.126 3ZM4 9C4 8.73478 4.10536 8.48043 4.29289 8.29289C4.48043 8.10536 4.73478 8 5 8H11C11.2652 8 11.5196 8.10536 11.7071 8.29289C11.8946 8.48043 12 8.73478 12 9C12 9.26522 11.8946 9.51957 11.7071 9.70711C11.5196 9.89464 11.2652 10 11 10H5C4.73478 10 4.48043 9.89464 4.29289 9.70711C4.10536 9.51957 4 9.26522 4 9ZM4 13C4 12.7348 4.10536 12.4804 4.29289 12.2929C4.48043 12.1054 4.73478 12 5 12H8C8.26522 12 8.51957 12.1054 8.70711 12.2929C8.89464 12.4804 9 12.7348 9 13C9 13.2652 8.89464 13.5196 8.70711 13.7071C8.51957 13.8946 8.26522 14 8 14H5C4.73478 14 4.48043 13.8946 4.29289 13.7071C4.10536 13.5196 4 13.2652 4 13Z" fill="#C2B7B7" />
                                                                                                        </svg> ' . $counter_result . ' &nbsp; 
                                                                                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                                         <path d="M7 20C6.73478 20 6.48043 19.8946 6.29289 19.7071C6.10536 19.5196 6 19.2652 6 19V16H2C1.46957 16 0.960859 15.7893 0.585786 15.4142C0.210714 15.0391 0 14.5304 0 14V2C0 1.46957 0.210714 0.960859 0.585786 0.585786C0.960859 0.210714 1.46957 0 2 0H18C18.5304 0 19.0391 0.210714 19.4142 0.585786C19.7893 0.960859 20 1.46957 20 2V14C20 14.5304 19.7893 15.0391 19.4142 15.4142C19.0391 15.7893 18.5304 16 18 16H11.9L8.2 19.71C8 19.9 7.75 20 7.5 20H7ZM8 14V17.08L11.08 14H18V2H2V14H8ZM14 12H6V11C6 9.67 8.67 9 10 9C11.33 9 14 9.67 14 11V12ZM10 4C10.5304 4 11.0391 4.21071 11.4142 4.58579C11.7893 4.96086 12 5.46957 12 6C12 6.53043 11.7893 7.03914 11.4142 7.41421C11.0391 7.78929 10.5304 8 10 8C9.46957 8 8.96086 7.78929 8.58579 7.41421C8.21071 7.03914 8 6.53043 8 6C8 5.46957 8.21071 4.96086 8.58579 4.58579C8.96086 4.21071 9.46957 4 10 4Z" fill="#C2B7B7" />
                                                                                                         </svg>
                                                                                                        </i> ' . $count_result . ' </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                     ';
                                                                }
                                                                echo $response;

                                                                ?>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   </div>
                               </div>
                           </div>
                            <!-- / The Context Menu -->
                        <div class="context" hidden>
                          <div class="context_item"> 
                            <div class="inner_item">
                             <a style="text-decoration: none" class="edit-button" data-id="" href="#ViewHistoryForEdits" data-toggle="modal" id="ViewHistoryForEdit">Edit </a>
                            </div> 
                          </div>
                          <div class="context_item"> 
                            <div class="inner_item">
                              <a style="text-decoration: none" class="delete-button" data-id="" id="DeleteHistory">Delete</a>
                            </div> 
                          </div>
                        </div>
                        <!-- End # Context Menu -->
                           <div id="todo-task-modal" class="modal" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">

                           </div>
                           <!-- END CONTENT BODY -->
                   </div>
                   <!-- END CONTENT -->
               </div>
               <!-- collaborator -->
               <!-- Modal -->


               <!-- END FOOTER -->
               <!-- testing sidebar -->
               <div class="page-quick-sidebar-wrapper" id="contact-slider" data-close-on-body-click="true" style="box-shadow: -7px 7px 20px 0px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
                   <a href="javascript:;" class="page-quick-sidebar-toggler">
                       <i class="icon-login"></i>
                   </a>
                   <div class="page-quick-sidebar">
                       <div class="tab-content">
                           <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                               <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                                   <div style="overflow-y: scroll;padding: 0 24px 24px 24px;height: 800px;">
                                       <div id="todo_task" style="padding-top: 75px;">
                                       </div>
                                   </div>
                                   
                                   
                                   <form id="commentForm">
                                       <div class="chat-form">
                                           <input class="form-control" type="hidden" id="Task_ids" name="Task_ids" value="" />
                                           <input class="form-control" type="hidden" name="user_id" value="<?php echo $current_userID; ?>" />
                                           <!--<div class="input-cont">-->
                                           <!--    <input id="mentionUser" class="mentionUser col-md-7 form-control" name="commentinput" type="text" placeholder="Type a message here..." />-->
                                           <!--</div>-->
                                           <div class="dx-viewport demo-container">
                                                <div id="html-editor"></div>
                                            </div>
                                           <div class="btn-cont">
                                               <span class="arrow"> </span>
                                               <button type="submit" class="btn blue icn-only">
                                                   <i class="fa fa-check icon-white"></i>
                                               </button>
                                           </div>
                                       </div>
                                   </form>
                               </div>
                               <div class="page-quick-sidebar-item" >
                                   <div class="page-quick-sidebar-chat-user" data-wrapper-class="page-quick-sidebar-list" style="overflow-y: scroll;height: :400px;padding: 75px 24px 24px 24px;height: 830px;">
                                      
                                       <div class="page-quick-sidebar-nav">
                                           <a href="javascript:;" class="page-quick-sidebar-back-to-list">
                                               <i class="icon-arrow-left"></i>Back</a>
                                       </div>
                                       <hr>
                                       <div id="SubTaskViewData"></div>    
                                   </div>
                                     <form id="commentFormSub">
                                           <div class="chat-form">
                                               <input class="form-control" type="hidden" id="subTask_ids" name="subTask_ids" value="" />
                                               <input class="form-control" type="hidden" name="subtaskuser_id" value="<?php echo $current_userID; ?>" />
                                                <div class="dx-viewport demo-container">
                                                <div id="html-editor2"></div>
                                            </div>
                                               
                                               <div class="btn-cont">
                                                   <span class="arrow"> </span>
                                                   <button type="submit" class="btn blue icn-only">
                                                       <i class="fa fa-check icon-white"></i>
                                                   </button>
                                               </div>
                                           </div>
                                           
                                       </form>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <!-- end of test sidebar -->
               <!-- BEGIN CORE PLUGINS -->
               <!-- <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script> -->
               <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
               <script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.umd.min.js"></script>
               <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
               <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
               <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js" type="text/javascript"></script>
               <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
               <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
               <!-- END CORE PLUGINS -->
               <!-- BEGIN PAGE LEVEL PLUGINS -->
               <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

               <script src="assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
               <!-- END PAGE LEVEL PLUGINS -->
               <!-- BEGIN THEME GLOBAL SCRIPTS -->
               <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
               <!-- BEGIN PAGE LEVEL PLUGINS -->
               <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
               <!-- END PAGE LEVEL PLUGINS -->
               <script src="assets/apps/scripts/todo.min.js" type="text/javascript"></script>
               <script src="assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
               <!-- END PAGE LEVEL SCRIPTS -->
               <!-- BEGIN THEME LAYOUT SCRIPTS -->
               <script src="assets/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
               <script src="assets/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
               <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
               <script src="assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
               <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
               <script src="https://cdn.rawgit.com/nnattawat/slideReveal/master/dist/jquery.slidereveal.min.js"></script>
               <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
                <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
               <script src="ForNewFunctions/js/process_clone.js"></script>
                 <!-- BEGIN PAGE LEVEL PLUGINS -->
                <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
                <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
                <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
                <!-- END PAGE LEVEL PLUGINS -->
               <script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
               <script src="https://rawcdn.githack.com/riktar/jkanban/d6b20fc9912b90fd9783b1ac1187754057dd2f1c/dist/jkanban.min.js"></script>
               
                <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
                <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
                <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
                <!-- Include WaitMe.js (you can adjust the paths if needed) -->
                
                <!--drag and drop with task reordering-->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/web-animations/2.3.1/web-animations.min.js"></script>
               <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
               <script src="https://cdnjs.cloudflare.com/ajax/libs/muuri/0.5.3/muuri.min.js"></script>
               <!--<link href="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.css" rel="stylesheet" type="text/css" />-->
               <!--<script src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.js"></script>-->
                <!--end of it-->
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.6/quill.min.js"></script>
                <script src="https://cdn3.devexpress.com/jslib/19.1.5/js/dx.all.js"></script>
                <script src="https://cdn.ckeditor.com/4.14.0/full-all/ckeditor.js"></script>
               <!-- END THEME LAYOUT SCRIPTS -->
               <!-- personal script -->
             <script>
               $(document).ready(function() {
                    $(document).on("contextmenu", ".card", function(event) {
                        event.preventDefault();
                        var contextMenu = $(".context");
                        var card = $(this);
                        
                        // Get the card's ID
                        var cardId = card.data("id");
                        console.log(cardId);
                        var cardTop = card.offset().top;
                        var contextTop = cardTop - contextMenu.outerHeight() - 5;
                        var cardLeft = card.offset().left;
                        var contextLeft = cardLeft - 10;
                
                        contextMenu.css({
                            top: contextTop,
                            left: contextLeft
                        });
                        contextMenu.data("cardId", cardId);
                        contextMenu.find(".edit-button").attr("data-id", cardId);
                        contextMenu.find(".delete-button").attr("data-id", cardId);
                
                        contextMenu.show();
                    });
                
                    $(document).click(function(event) {
                        var contextMenu = $(".context");
                        if (!contextMenu.is(event.target) && contextMenu.has(event.target).length === 0) {
                            contextMenu.hide();
                        }
                    });
                });
                $(function() {
                            var employees; 
                            $.ajax({
                                 url: 'ForNewFunctions/modules/process_clone.php',
                                method: 'POST',
                                data: {
                                    action: 'GetThisFormentionuser'
                                },
                                dataType: 'json',
                                success: function(users) {
                                    employees = users.map(user => ({
                                        text: user.name,
                                        icon: user.avatar,
                                    }));
                                    var editor = $("#html-editor").dxHtmlEditor({
                                        mentions: [{
                                            dataSource: employees,
                                            searchExpr: "text",
                                            displayExpr: "text",
                                             itemTemplate: function (itemData) {
                                                    return '<div class="mention-item">' +
                                                        '<img class="mention-avatar" src="' + itemData.icon + '" />' +
                                                        '<span class="mention-text">' + itemData.text + '</span>' +
                                                        '</div>';
                                            }
                                        }]
                                    }).dxHtmlEditor("instance");
                                         $("#commentForm").submit(function(event) {
                                            event.preventDefault();
                                             var editorContent = editor.option('value');
                                             console.log(editorContent);
                                            var formData = {
                                                Task_ids: $('input[name=Task_ids]').val(),
                                                user_id: $('input[name=user_id]').val(),
                                                comment: editorContent,
                                                action: 'AddComment'
                                            };
                                            console.log(formData);
                                            $.ajax({
                                                type: 'POST',
                                                   url: 'ForNewFunctions/modules/process_clone.php',
                                                data: formData,
                                                success: function(response) {
                                                    console.log(response);
                                                    $('input[name=commentinput]').val('');
                                                    var id = $('input[name=Task_ids]').val();
                                                    ListOfComment(id);
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error(error);
                                                }
                                            });
                                        });
                                        
                                        
                                },
                                error: function(error) {
                                    console.error('Error fetching users:', error);
                                }
                            });
                        });
                        // subtask
                          $(function() {
                            var employees; 
                            $.ajax({
                                 url: 'ForNewFunctions/modules/process_clone.php',
                                method: 'POST',
                                data: {
                                    action: 'GetThisFormentionuser'
                                },
                                dataType: 'json',
                                success: function(users) {
                                    employees = users.map(user => ({
                                        text: user.name,
                                        icon: user.avatar,
                                    }));
                                    var editor = $("#html-editor2").dxHtmlEditor({
                                        mentions: [{
                                            dataSource: employees,
                                            searchExpr: "text",
                                            displayExpr: "text",
                                             itemTemplate: function (itemData) {
                                                    return '<div class="mention-item">' +
                                                        '<img class="mention-avatar" src="' + itemData.icon + '" />' +
                                                        '<span class="mention-text">' + itemData.text + '</span>' +
                                                        '</div>';
                                            }
                                        }]
                                    }).dxHtmlEditor("instance");
                                            $("#commentFormSub").submit(function(event) {
                                            event.preventDefault();
                                            var editorContent = editor.option('value');
                                            var formData = {
                                                Task_ids: $('input[name=subTask_ids]').val(),
                                                user_id: $('input[name=subtaskuser_id]').val(),
                                                comment: editorContent,
                                                action: 'AddCommentSubtask'
                                            };
                                            console.log(formData);
                                            $.ajax({
                                                type: 'POST',
                                                   url: 'ForNewFunctions/modules/process_clone.php',
                                                data: formData,
                                                success: function(response) {
                                                    console.log(response);
                                                    $('input[name=subTaskcommentinput]').val('');
                                                    var id = $('input[name=subTask_ids]').val();
                                                    ListOfCommentSubtask(id);
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error(error);
                                                }
                                            });
                                        });
                                },
                                error: function(error) {
                                    console.error('Error fetching users:', error);
                                }
                            });
                        });
                </script>
               <script>
                  function makeEditable(id) {
                    const editableText = document.getElementById('editableText' + id);
                    const text = editableText.innerText;
                
                    editableText.innerHTML = `<textarea id="editField${id}" cols="70">${text}</textarea>`;
                
                    const editField = document.getElementById('editField' + id);
                    editField.focus();
                    editField.addEventListener('blur', function() {
                      saveTaskNameHistoryChanges(id);
                    });
                  }
                
                  function saveTaskNameHistoryChanges(id) {
                    const editField = document.getElementById('editField' + id);
                    const newText = editField.value;
                    const editableText = document.getElementById('editableText' + id);
                    editableText.innerText = newText;
                    const action = "editTaskNameHistory";
                    
                    $.ajax({
                      method: 'POST',
                      url: 'ForNewFunctions/modules/process_clone.php',
                      data: { newText: newText, history_id: id, action: action },
                      success: function(response) {
                        console.log(response);
                      },
                      error: function(error) {
                        console.error('Error updating text in the database:', error);
                      }
                    });
                  }
                  
               function makeEditableDescription(id) {
                  const editableTextDescription = document.getElementById('editableTextDescription' + id);
                  const text = editableTextDescription.innerText;
                
                  editableTextDescription.innerHTML = `<textarea id="editFieldDescription${id}" cols="80">${text}</textarea>`;
                
                  const editFieldDescription = document.getElementById('editFieldDescription' + id);
                  editFieldDescription.focus();
                  editFieldDescription.addEventListener('blur', function() {
                    saveTaskDescriptionHistoryChanges(id);
                  });
                }
                
                function saveTaskDescriptionHistoryChanges(id) {
                  const editFieldDescription = document.getElementById('editFieldDescription' + id);
                  const newText = editFieldDescription.value;
                  const editableTextDescription = document.getElementById('editableTextDescription' + id);
                  editableTextDescription.innerText = newText;
                  const action = "editTaskDescriptionHistory";
                  
                  $.ajax({
                    method: 'POST',
                    url: 'ForNewFunctions/modules/process_clone.php',
                    data: { newText: newText, history_id: id, action: action },
                    success: function(response) {
                      console.log(response);
                    },
                    error: function(error) {
                      console.error('Error updating text in the database:', error);
                    }
                  });
                }
                // for subtask
                  function makeEditableSubtask(id) {
                  const editableTextSubtask = document.getElementById('editableTextSubtask' + id);
                  const text = editableTextSubtask.innerText;
                
                  editableTextSubtask.innerHTML = `<textarea id="editFieldSubtask${id}" cols="80">${text}</textarea>`;
                
                  const editFieldSubtask = document.getElementById('editFieldSubtask' + id);
                  editFieldSubtask.focus();
                  editFieldSubtask.addEventListener('blur', function() {
                    saveSubtaskChanges(id);
                  });
                }
                
                function saveSubtaskChanges(id) {
                  const editFieldSubtask = document.getElementById('editFieldSubtask' + id);
                  const newText = editFieldSubtask.value;
                  const editableTextSubtask = document.getElementById('editableTextSubtask' + id);
                  editableTextSubtask.innerText = newText;
                  const action = "editSubtaskName";
                
                  
                  $.ajax({
                    method: 'POST',
                    url: 'ForNewFunctions/modules/process_clone.php',
                    data: { newText: newText, subtask_id: id, action: action },
                    success: function(response) {
                      console.log(response);
                    },
                    error: function(error) {
                      console.error('Error updating text in the database:', error);
                    }
                  });
                }
                
                function makeEditableSubDescription(id) {
                  const editableTextSubDescription = document.getElementById('editableTextSubDescription' + id);
                  const text = editableTextSubDescription.innerText;
                
                  editableTextSubDescription.innerHTML = `<textarea id="editFieldSubDescription${id}" cols="80">${text}</textarea>`;
                
                  const editFieldSubDescription = document.getElementById('editFieldSubDescription' + id);
                  editFieldSubDescription.focus();
                  editFieldSubDescription.addEventListener('blur', function() {
                    saveSubDescriptionChanges(id);
                  });
                }
                
                function saveSubDescriptionChanges(id) {
                  const editFieldSubDescription = document.getElementById('editFieldSubDescription' + id);
                  const newText = editFieldSubDescription.value;
                  const editableTextSubDescription = document.getElementById('editableTextSubDescription' + id);
                  editableTextSubDescription.innerText = newText;
                  const action = "editSubTaskDescription";
                  console.log(id);
                  console.log(newText);
                  $.ajax({
                    method: 'POST',
                    url: 'ForNewFunctions/modules/process_clone.php',
                    data: { newText: newText, subtask_id: id, action: action },
                    success: function(response) {
                      console.log(response);
                    },
                    error: function(error) {
                      console.error('Error updating text in the database:', error);
                    }
                  });
                }
                </script>
                <script>
                   function updateTaskOrder(updatedOrder, columnId) {
                       var action = "orderUpdate";
                       $.ajax({
                            url: 'ForNewFunctions/modules/process_clone.php',
                           type: 'POST',
                           data: {
                               updatedOrder: updatedOrder,
                               action: action,
                               columnId: columnId
                           },
                           dataType: 'json',
                           success: function(response) {
                               if (response.success) {
                                   // Update the UI if needed
                               } else {
                                   console.log(response.message);
                               }
                           },
                           error: function(xhr, status, error) {
                               console.log(error);
                           }
                       });
                   }

                   // Function to handle the task status update using AJAX
                   function updateTaskStatus(taskId, newStatus) {
                       var action = "changeStatusClone";
                       $.ajax({
                            url: 'ForNewFunctions/modules/process_clone.php',
                           type: 'POST',
                           data: {
                               task_id: taskId,
                               status: newStatus,
                               action: action
                           },
                           dataType: 'json',
                           success: function(response) {
                               // Check if the response contains the 'success' key
                               if (response.success) {
                                    updateColumnStatus();
                                   // Update the task item in the UI based on the new status (e.g., change color or label).
                                   // However, ideally, you should fetch updated data from the server to ensure consistency.
                               } else {
                                   console.log(response.message); // Error message
                               }
                           },
                           error: function(xhr, status, error) {
                               console.log(error);
                           }
                       });
                   }
                   var itemContainers = [].slice.call(document.querySelectorAll('.board-column-content'));
                   var columnGrids = [];
                   var boardGrid;

                   // Define the column grids so we can drag those items around.
                   itemContainers.forEach(function(container) {
                       // Instantiate column grid.
                       var grid = new Muuri(container, {
                               items: '.board-item',
                               layoutDuration: 400,
                               layoutEasing: 'ease',
                               dragEnabled: true,
                               dragSort: function() {
                                   return columnGrids;
                               },
                               dragSortInterval: 0,
                               dragContainer: document.body,
                               dragReleaseDuration: 100,
                               dragReleaseEasing: 'ease'
                           })
                           .on('dragStart', function(item) {
                               item.getElement().style.width = item.getWidth() + 'px';
                               item.getElement().style.height = item.getHeight() + 'px';
                               console.log(item.getHeight());
                           })
                           .on('dragReleaseEnd', function(item) {
                               // Let's remove the fixed width/height from the
                               // dragged item now that it is back in a grid
                               // column and can freely adjust to it's
                               // surroundings.
                               item.getElement().style.width = '';
                               item.getElement().style.height = '';
                               // Just in case, let's refresh the dimensions of all items
                               // in case dragging the item caused some other items to
                               // be different size.
                               columnGrids.forEach(function(grid) {
                                   grid.refreshItems();
                               });
                           })
                           .on('layoutStart', function() {
                               // Let's keep the board grid up to date with the
                               // dimensions changes of column grids.
                               boardGrid.refreshItems().layout();
                           });

                       // Add the column grid reference to the column grids
                       // array, so we can access it later on.
                       columnGrids.push(grid);

                       // Add the 'dragReleaseEnd' event handler
                       grid.on('dragReleaseEnd', function(item) {
                           // ... Your existing Muuri dragReleaseEnd code ...
                           var updatedOrder = [];
                           grid.getItems().forEach(function(task) {
                               updatedOrder.push(task.getElement().dataset.taskId);
                           });
                           // Get the task ID and the new status based on the target column
                           var taskId = parseInt(item.getElement().dataset.taskId);
                           var newStatus = parseInt(item.getElement().closest('.board-column').getAttribute('data-column-id'));
                           console.log(updatedOrder);
                           // Call the function to update the task status using AJAX
                           updateTaskStatus(taskId, newStatus);
                           updateTaskOrder(updatedOrder, newStatus);
                           // Just in case, let's refresh the dimensions of all items
                           // in case dragging the item caused some other items to
                           // be a different size.
                           columnGrids.forEach(function(grid) {
                               grid.refreshItems();
                           });
                       });

                       // Add the column grid reference to the column grids
                       // array, so we can access it later on.
                       columnGrids.push(grid);

                   });

                   // Instantiate the board grid so we can drag those
                   // columns around.
                   boardGrid = new Muuri('.board', {
                       layout: {
                           horizontal: true,
                       },
                       layoutDuration: 400,
                       layoutEasing: 'ease',
                       dragEnabled: true,
                       dragSortInterval: 0,
                       dragStartPredicate: {
                           handle: '.board-column-header'
                       },
                       dragReleaseDuration: 400,
                       dragReleaseEasing: 'ease'
                   });
               </script>
               <script>
                   function toggleHiddenContent(link) {
                       var hiddenContent = link.parentNode.querySelector('.hidden-content');
                       hiddenContent.style.display = (hiddenContent.style.display === 'none') ? 'inline' : 'none';
                   }
               </script>
               <script>
               function btnDeleteProject(id) {
                    var action = "processparentDeletion";
                            Swal.fire({
                                title: 'Delete Task?',
                                html: '<input type="text" id="deletionReason" class="swal2-input" placeholder="Enter reason for deletion">',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Delete',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var reason = $('#deletionReason').val();
                        
                                    // AJAX request
                                    $.ajax({
                                        url: 'ForNewFunctions/modules/process_clone.php',
                                        method: 'POST',
                                        data: { id: id, reason: reason, action: action },
                                        dataType: 'json',
                                        success: function(response) {
                                            console.log(response);
                                            Swal.fire({
                                                title: 'Deleted!',
                                                text: 'Success',
                                                icon: 'success'
                                            }).then(() => {
                                                window.location.href = "https://interlinkiq.com/test_MyPro";
                                            });
                                        },
                                        error: function(xhr, status, error) {
                                            Swal.fire({
                                                title: 'Error',
                                                text: 'An error occurred while deleting the item.',
                                                icon: 'error'
                                            });
                                            console.log(error);
                                        }
                                    });
                                }
                            });
                        }

                   $(document).ready(function() {
                            $(document).on('click', '.checkbox-effect', function(e) {
                            e.preventDefault();
                             var id = $(this).val();
                             var view = $(this).data('view');
                            
                            <?php if($current_client != 1){ ?>
                          if (!$(this).prop('checked')) {
                            var action = "updatecompleteSelectedsubTask";
                                Swal.fire({
                                    title: 'Select task status',
                                    input: 'select',
                                    inputOptions: {
                                        '0': 'Not Started',
                                        '1': 'In Progress',
                                    },
                                    showCancelButton: true,
                                    confirmButtonText: 'Update Status',
                                    cancelButtonText: 'Cancel',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        const selectedOption = result.value;
                                        Swal.fire({
                                            title: 'Update Rendered Estimated Time',
                                            text: 'Do you want to update the rendered estimated time?',
                                            showCancelButton: true,
                                            confirmButtonText: 'Yes',
                                            cancelButtonText: 'No',
                                        }).then((confirmResult) => {
                                            if (confirmResult.isConfirmed) {
                                                Swal.fire({
                                                    title: 'Enter the rendered estimated time:',
                                                    input: 'text',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Complete Task',
                                                    cancelButtonText: 'Cancel',
                                                }).then((inputResult) => {
                                                    if (inputResult.isConfirmed) {
                                                        const renderedEstimated = inputResult.value;
                                                        if (!renderedEstimated || renderedEstimated.trim() === '') {
                                                            Swal.fire('Invalid Input', 'Please enter the rendered estimated time.', 'error');
                                                            return;
                                                        }
                                                        $.ajax({
                                                             url: 'ForNewFunctions/modules/process_clone.php',
                                                            method: 'POST',
                                                            data: {
                                                                subTaskId: id,
                                                                action: action,
                                                                status: selectedOption,
                                                                renderedEstimated: renderedEstimated,
                                                            },
                                                            success: function(response) {
                                                                console.log(response);
                                                                ListOfSubTaskChild(view);
                                                                ListOfSubTask(view);
                                                                Swal.fire('Task Status Updated', 'The task status has been updated successfully.', 'success');
                                                            },
                                                            error: function(xhr, status, error) {
                                                                console.log(error);
                                                                Swal.fire('Error', 'An error occurred while updating the task status.', 'error');
                                                            },
                                                        });
                                                    }
                                                });
                                            } else {
                                                $.ajax({
                                                    url: 'ForNewFunctions/modules/process_clone.php',
                                                    method: 'POST',
                                                    data: {
                                                        subTaskId: id,
                                                        action: action,
                                                        status: selectedOption,
                                                    },
                                                    success: function(response) {
                                                        console.log(response);
                                                        ListOfSubTaskChild(view);
                                                        ListOfSubTask(view);
                                                        Swal.fire('Task Status Updated', 'The task status has been updated successfully.', 'success');
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.log(error);
                                                        Swal.fire('Error', 'An error occurred while updating the task status.', 'error');
                                                    },
                                                });
                                            }
                                        });
                                    }
                                });
                            } else {
                                var action = "completeSelectedsubTask";
                                Swal.fire({
                                    title: 'Are you sure you want to complete this task?',
                                    text: 'Enter the rendered estimated time:',
                                    input: 'text',
                                    showCancelButton: true,
                                    confirmButtonText: 'Complete Task',
                                    cancelButtonText: 'Cancel',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        const renderedEstimated = result.value;
                                        if (!renderedEstimated || renderedEstimated.trim() === '') {
                                            Swal.fire('Invalid Input', 'Please enter the rendered estimated time.', 'error');
                                            return;
                                        }
                                        $.ajax({
                                            url: 'ForNewFunctions/modules/process_clone.php',
                                            method: 'POST',
                                            data: {
                                                subTaskId: id,
                                                action: action,
                                                renderedEstimated: renderedEstimated,
                                            },
                                            success: function(response) {
                                                console.log(response);
                                                ListOfSubTaskChild(view);
                                                ListOfSubTask(view);
                                                Swal.fire('Task Completed', 'The task has been completed successfully.', 'success');
                                            },
                                            error: function(xhr, status, error) {
                                                console.log(error);
                                                Swal.fire('Error', 'An error occurred while completing the task.', 'error');
                                            },
                                        });
                                    }
                                });
                            }
                            <?php } else { ?>
                          if (!$(this).prop('checked')) {
                                 Swal.fire({
                                    title: 'Select task status',
                                    input: 'select',
                                    inputOptions: {
                                        '0': 'Not Started',
                                        '1': 'In Progress',
                                    },
                                    showCancelButton: true,
                                    confirmButtonText: 'Update Status',
                                    cancelButtonText: 'Cancel',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        const selectedOption = result.value;
                                        $.ajax({
                                            url: 'ForNewFunctions/modules/process_clone.php',
                                            method: 'POST',
                                            data: {
                                                subTaskId: id,
                                                action: 'updateTaskStatus',
                                                status: selectedOption,
                                            },
                                            success: function(response) {
                                                   ListOfSubTask(view);
                                                   ListOfSubTaskChild(view);
                                            },
                                            error: function(xhr, status, error) {
                                                console.log(error);
                                            },
                                        });
                                    }
                                });
                            } else {
                                 swal({
                                    text: 'Want to complete?',
                                }).then((value) => {
                                    if (value === null) {
                                        return;
                                    } else {
                                        completeTask(id, view);
                                    }
                                });
                            }
                            <?php } ?>
                        });
                        
                        function completeTask(id, view, estimatedTime) {
                            var iconsContainerOtherAction = $('#iconsContainerOtherAction');
                            var action = "completeSelectedsubTask";
                            var data = { subTaskId: id, action: action };
                            if (estimatedTime !== undefined) {
                                data.estimatedTime = estimatedTime;
                            }
                            $.ajax({
                                url: 'ForNewFunctions/modules/process_clone.php',
                                method: "POST",
                                data: data,
                                success: function(response) {
                                    console.log(response);
                                    ListOfSubTask(view);
                                    iconsContainerOtherAction.fadeOut();
                                    swal('Success', 'Task completed successfully!', 'success');
                                },
                                error: function(xhr, status, error) {
                                    console.log(error);
                                    swal('Error', 'An error occurred. Ongoing Troubleshooting.', 'error');
                                }
                            });
                        }

                    //   $(document).on(' click', '.card #more-btn', function(e) {
                    //       e.preventDefault();
                    //       var $btn = $(this);
                    //       var $el = $btn.closest('.more');
                    //       var $menu = $el.find('.more-menu');
                    //       var visible = $el.hasClass('show-more-menu');
                    //       if (!visible) {
                    //           visible = true;
                    //           $el.addClass('show-more-menu');
                    //           $menu.attr('aria-hidden', false);
                    //           $(document).on('mousedown', hideMenu);
                    //           console.log('Menu shown');
                    //       } else {
                    //           visible = false;
                    //           $el.removeClass('show-more-menu');
                    //           $menu.attr('aria-hidden', true);
                    //           $(document).off('mousedown', hideMenu);
                    //           console.log('Menu hidden');
                    //       }

                    //       function hideMenu(e) {
                    //           if (!$btn.is(e.target) && !$el.has(e.target).length) {
                    //               visible = false;
                    //               $el.removeClass('show-more-menu');
                    //               $menu.attr('aria-hidden', true);
                    //               $(document).off('mousedown', hideMenu);
                    //               console.log('Menu hidden');
                    //           }
                    //       }
                    //   });
                    //   $(document).on('mouseenter', '.card', function() {
                    //       var $el = $(this).find('.more');
                    //       var $btn = $el.find('.more-btn');
                    //       var visible = $el.hasClass('show-more-menu');
                    //       if (!visible) {
                    //           $btn.css('display', 'block');
                    //           $btn.attr('aria-hidden', false);
                    //       }
                    //   }).on('mouseleave', '.card', function() {
                    //       var $el = $(this).find('.more');
                    //       var $btn = $el.find('.more-btn');
                    //       var $menu = $el.find('.more-menu');
                    //       var visible = $el.hasClass('show-more-menu');
                    //       setTimeout(function() {
                    //           $btn.css('display', 'none');
                    //       }, 200);
                    //       if (visible) {
                    //           $el.removeClass('show-more-menu');
                    //           $btn.attr('aria-hidden', true);
                    //       }
                    //   });
                   });
               </script>
               <script>
                   function formatDate(dateStr) {
                       var date = new Date(dateStr);
                       var month = String(date.getMonth() + 1).padStart(2, '0');
                       var day = String(date.getDate()).padStart(2, '0');
                       return month + '/' + day;
                   }
                   document.querySelectorAll('.js-anchor-link').forEach(function(anchor) {
                       anchor.addEventListener('click', function(e) {
                           e.preventDefault();
                           var target = document.querySelector(this.getAttribute('href'));
                           if (target) {
                               target.scrollIntoView({
                                   behavior: 'smooth'
                               });
                           }
                       });
                   });
               </script>
               <script>
                   $(document).ready(function() {
                       var slider = $("#contact-slider").slideReveal({
                           trigger: $("#cardData"),
                           position: "right",
                           push: false,
                           overlay: true,
                           width: 680,
                           speed: 300
                       });

                       $(document).on('click', '#cloaserightpanel', function(e) {
                           e.preventDefault();
                           $("#contact-slider").slideReveal("hide");
                       });

                       $(document).on('click', '#cardData', function(e) {
                           e.preventDefault();
                           $("#contact-slider").slideReveal("show");
                       });
                   });
               </script>
               <script>
                   const properties = [
                       'direction',
                       'boxSizing',
                       'width',
                       'height',
                       'overflowX',
                       'overflowY',

                       'borderTopWidth',
                       'borderRightWidth',
                       'borderBottomWidth',
                       'borderLeftWidth',
                       'borderStyle',

                       'paddingTop',
                       'paddingRight',
                       'paddingBottom',
                       'paddingLeft',

                       'fontStyle',
                       'fontVariant',
                       'fontWeight',
                       'fontStretch',
                       'fontSize',
                       'fontSizeAdjust',
                       'lineHeight',
                       'fontFamily',

                       'textAlign',
                       'textTransform',
                       'textIndent',
                       'textDecoration',

                       'letterSpacing',
                       'wordSpacing',

                       'tabSize',
                       'MozTabSize',
                   ]

                   const isFirefox = typeof window !== 'undefined' && window['mozInnerScreenX'] != null

                   /**
                    * @param {HTMLTextAreaElement} element
                    * @param {number} position
                    */
                   function getCaretCoordinates(element, position) {
                       const div = document.createElement('div')
                       document.body.appendChild(div)

                       const style = div.style
                       const computed = getComputedStyle(element)

                       style.whiteSpace = 'pre-wrap'
                       style.wordWrap = 'break-word'
                       style.position = 'absolute'
                       style.visibility = 'hidden'
                       style.overflow = 'auto'

                       properties.forEach(prop => {
                           style[prop] = computed[prop]
                       })

                       if (isFirefox) {
                           if (element.scrollHeight > parseInt(computed.height))
                               style.overflowY = 'scroll'
                       } else {
                           style.overflow = 'hidden'
                       }

                       div.textContent = element.value.substring(0, position)

                       const span = document.createElement('span')
                       span.textContent = element.value.substring(position) || '.'
                       div.appendChild(span)

                       const coordinates = {
                           top: span.offsetTop + parseInt(computed['borderTopWidth']),
                           left: span.offsetLeft + parseInt(computed['borderLeftWidth']),
                           // height: parseInt(computed['lineHeight'])
                           height: span.offsetHeight
                       }

                       div.remove()

                       return coordinates
                   }

                   class Mentionify {
                       constructor(ref, menuRef, resolveFn, replaceFn, menuItemFn) {
                           this.ref = ref
                           this.menuRef = menuRef
                           this.resolveFn = resolveFn
                           this.replaceFn = replaceFn
                           this.menuItemFn = menuItemFn
                           this.options = []

                           this.makeOptions = this.makeOptions.bind(this)
                           this.closeMenu = this.closeMenu.bind(this)
                           this.selectItem = this.selectItem.bind(this)
                           this.onInput = this.onInput.bind(this)
                           this.onKeyDown = this.onKeyDown.bind(this)
                           this.renderMenu = this.renderMenu.bind(this)

                           this.ref.addEventListener('input', this.onInput)
                           this.ref.addEventListener('keydown', this.onKeyDown)
                       }

                       async makeOptions(query) {
                           const options = await this.resolveFn(query)
                           if (options.lenght !== 0) {
                               this.options = options
                               this.renderMenu()
                           } else {
                               this.closeMenu()
                           }
                       }

                       closeMenu() {
                           setTimeout(() => {
                               this.options = []
                               this.left = undefined
                               this.top = undefined
                               this.triggerIdx = undefined
                               this.renderMenu()
                           }, 0)
                       }

                       selectItem(active) {
                           return () => {
                               const preMention = this.ref.value.substr(0, this.triggerIdx)
                               const option = this.options[active]
                               const mention = this.replaceFn(option, this.ref.value[this.triggerIdx])
                               const postMention = this.ref.value.substr(this.ref.selectionStart)
                               const newValue = `${preMention}${mention}${postMention}`
                               this.ref.value = newValue
                               const caretPosition = this.ref.value.length - postMention.length
                               this.ref.setSelectionRange(caretPosition, caretPosition)
                               this.closeMenu()
                               this.ref.focus()
                           }
                       }

                       onInput(ev) {
                           const positionIndex = this.ref.selectionStart
                           const textBeforeCaret = this.ref.value.slice(0, positionIndex)
                           const tokens = textBeforeCaret.split(/\s/)
                           const lastToken = tokens[tokens.length - 1]
                           const triggerIdx = textBeforeCaret.endsWith(lastToken) ?
                               textBeforeCaret.length - lastToken.length :
                               -1
                           const maybeTrigger = textBeforeCaret[triggerIdx]
                           const keystrokeTriggered = maybeTrigger === '@'

                           if (!keystrokeTriggered) {
                               this.closeMenu()
                               return
                           }

                           const query = textBeforeCaret.slice(triggerIdx + 1)
                           this.makeOptions(query)

                           const coords = getCaretCoordinates(this.ref, positionIndex)
                           const {
                               top,
                               left
                           } = this.ref.getBoundingClientRect()

                           setTimeout(() => {
                               this.active = 0
                               this.left = window.scrollX + coords.left + left + this.ref.scrollLeft
                               this.top = window.scrollY + coords.top + top + coords.height - this.ref.scrollTop
                               this.triggerIdx = triggerIdx
                               this.renderMenu()
                           }, 0)
                       }
                       onKeyDown(ev) {
                           let keyCaught = false
                           if (this.triggerIdx !== undefined) {
                               switch (ev.key) {
                                   case 'ArrowDown':
                                       this.active = Math.min(this.active + 1, this.options.length - 1)
                                       this.renderMenu()
                                       keyCaught = true
                                       break
                                   case 'ArrowUp':
                                       this.active = Math.max(this.active - 1, 0)
                                       this.renderMenu()
                                       keyCaught = true
                                       break
                                   case 'Enter':
                                   case 'Tab':
                                       this.selectItem(this.active)()
                                       keyCaught = true
                                       break
                               }
                           }

                           if (keyCaught) {
                               ev.preventDefault()
                           }
                       }

                       renderMenu() {
                           if (this.top === undefined) {
                               this.menuRef.hidden = true
                               return
                           }

                           //    this.menuRef.style.left = this.left + 'px'
                           //    this.menuRef.style.top = this.top + 'px'
                           this.menuRef.innerHTML = ''

                           this.options.forEach((option, idx) => {
                               this.menuRef.appendChild(this.menuItemFn(
                                   option,
                                   this.selectItem(idx),
                                   this.active === idx))
                           })

                           this.menuRef.hidden = false
                       }
                   }

                   function getUserMentionData() {
                       return new Promise((resolve, reject) => {
                           const xhr = new XMLHttpRequest();
                           xhr.open('GET', 'ForNewFunctions/modules/getUsermention.php', true);
                           xhr.onreadystatechange = function() {
                               if (xhr.readyState === 4) {
                                   if (xhr.status === 200) {
                                       const responseData = JSON.parse(xhr.responseText);
                                       resolve(responseData);
                                   } else {
                                       reject(xhr.statusText);
                                   }
                               }
                           };
                           xhr.onerror = function() {
                               reject('Network error');
                           };
                           xhr.send();
                       });
                   }
                   getUserMentionData()
                       .then((user_data) => {
                           const users = user_data.map((item) => ({
                               username: item.name
                           }));
                           const resolveFn = (prefix) =>
                               prefix === '' ?
                               users :
                               users.filter((user) =>
                                   user.username.toLowerCase().startsWith(prefix.toLowerCase())
                               );
                           const replaceFn = (user, trigger) => `${trigger}${user.username} `;
                           const menuItemFn = (user, setItem, selected) => {
                               const div = document.createElement('div');
                               div.setAttribute('role', 'option');
                               div.className = 'menu-item_mention';
                               if (selected) {
                                   div.classList.add('selected');
                                   div.setAttribute('aria-selected', '');
                               }
                               div.textContent = user.username;
                               div.onclick = setItem;
                               return div;
                           };
                           new Mentionify(
                               document.getElementById('mentionUser'),
                               document.getElementById('menu_mention'),
                               resolveFn,
                               replaceFn,
                               menuItemFn
                           );
                       })
                       .catch((error) => {
                           console.error('Error fetching user mention data:', error);
                       });
               </script>
               <script>
                   $(function() {
                       $('#select2_sample2').each(function() {
                           $(this).select2({
                               theme: 'bootstrap4',
                               width: '100%',
                               placeholder: $(this).attr('placeholder'),
                               allowClear: Boolean($(this).data('allow-clear')),
                           });
                       });
                   });
                   $(document).ready(function() {
                       $(document).on('click', '.see-more', function() {
                           $('#hidden-content').css('display', 'block');
                           $(this).css('display', 'none');
                       });
                   });
               </script>
               <script>
                   $(document).ready(function() {
                       updateColumnStatus();
                   });

                   function updateColumnStatus() {
                       var view_id = <?= $_GET['view_id'] ?>;
                       var action = "CountNumberOfColumn";
                       $.ajax({
                           url: 'ForNewFunctions/modules/process_clone.php',
                           type: "GET",
                           dataType: "json",
                           data: {
                               action: action,
                               view_id: view_id
                           },
                           success: function(data) {
                               $("#columnStatus1").html(data[0]);
                               $("#columnStatus2").html(data[1]);
                               $("#columnStatus3").html(data[2]);
                           }
                       });
                   }
               </script>
               <script>
                   function getData(key) {
                       var view_id = <?= $_GET['view_id'] ?>;
                       var action = "ParentTask";
                       $.ajax({
                           url: 'ForNewFunctions/modules/process_clone.php',
                           method: 'POST',
                           dataType: 'text',
                           data: {
                               action: action,
                               view_id: view_id,
                               key: key
                           },
                           success: function(response) {
                               $('#data_items').html(response);
                           },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                       });
                   }

                   function getData1(key) {
                       var view_id = <?= $_GET['view_id'] ?>;
                       var action = "ParentTask1";
                       $.ajax({
                           url: 'ForNewFunctions/modules/process_clone.php',
                           method: 'POST',
                           dataType: 'text',
                           data: {
                               action: action,
                               view_id: view_id,
                               key: key
                           },
                           success: function(response) {
                               $('#data_items1').html(response);
                           },
                        error: function(xhr, status, error) {
                            console.log("Error: " + error); // Print the error message to the console
                        }
                       });
                   }

                   function getData2(key) {
                       var view_id = <?= $_GET['view_id'] ?>;
                       var action = "ParentTask2";
                       $.ajax({
                           url: 'ForNewFunctions/modules/process_clone.php',
                           method: 'POST',
                           dataType: 'text',
                           data: {
                               action: action,
                               view_id: view_id,
                               key: key
                           },
                           success: function(response) {
                               $('#data_items2').html(response);
                           },
                            error: function(xhr, status, error) {
                                console.log("Error: " + error); // Print the error message to the console
                            }
                       });
                   }

                   function btnNew_File(id) {
                       var modalNew_File = id;
                       var action = "viewParentcontrols";
                       console.log(modalNew_File);
                       $.ajax({
                           type: "POST",
                           url: "ForNewFunctions/modules/process_clone.php",
                           data: {
                               modalNew_File: modalNew_File,
                               action: action
                           },
                           dataType: "html",
                           success: function(data) {
                               $("#modalAddActionItem .modal-body").html(data);
                               $(".modalForm").validate();
                           }
                       });
                   }
               </script>
               <script>
                 
                   $(document).ready(function() {
                       $('.js-select2').select2({
                           closeOnSelect: false,
                           tags: true,
                       });

                   });
                   $("#todo-task-modal").on("show.bs.modal", function() {
                       $(this).find(".modal-dialog").css({
                           transform: "translateX(100%)",
                           opacity: 0,
                           "transition": "transform 0.3s ease-in-out, opacity 0.3s ease-in-out"
                       });
                   });

                   $("#todo-task-modal").on("shown.bs.modal", function() {
                       $(this).find(".modal-dialog").css({
                           transform: "translateX(0)",
                           opacity: 1
                       });
                   });
                   $("#todo-task-modal").on("hide.bs.modal", function() {
                       $(this).find(".modal-dialog").css({
                           transform: "translateX(100%)",
                           opacity: 0,
                           "transition": "transform 0.6s ease-in-out, opacity 0.6s ease-in-out"
                       });
                   });
               </script>
               <script>
                    const profilePictures = document.getElementsByClassName('profile-picture-container');
                    for (let i = 0; i < profilePictures.length; i++) {
                        profilePictures[i].addEventListener('mouseover', function() {
                            this.querySelector('.delete-button').style.display = 'block';
                        });
                        profilePictures[i].addEventListener('mouseout', function() {
                            this.querySelector('.delete-button').style.display = 'none';
                        });
                    }
                </script>

               <!-- end of personal script -->

		<script type="text/javascript">
            $(document).ready(function(){
                $(".modalForm").validate();
                $(".modalService").validate();
                $(".modalCollab").validate();
                
                // var id = '<?php echo $current_userID; ?>';
                // $.ajax({
                //     url: 'function.php?my_task='+id,
                //     dataType: "html",
                //     success: function(data){
                //         $(".dropdown-menu .myTask").html(data);
                //     }
                // });
				$(".dropdown-menu .myTask").html(0);

                var count_Facility = $('#menuFacility ul > li.hide').length;
                if (count_Facility < 4) {
                    $('#menuFacility').removeClass('hide');
                }

                var count_HR = $('#menuHR ul > li.hide').length;
                var count_HR_total = $('#menuHR ul > li').length;
                if (count_HR < count_HR_total) {
                    $('#menuHR').removeClass('hide');
                }
                
                 var count_CMA = $('#menuCMA ul > li.hide').length;
                if (count_CMA < 5) {
                    $('#menuCMA').removeClass('hide');
                }

                const myTimeout = setTimeout(googleExtras, 5000);


        		var id = '<?php echo $current_userID; ?>';
        		setInterval(function() {
	                $.ajax({
	                    type: "GET",
	                    url: "function.php?modalChat_Refresh="+id,
	                    dataType: "html",
	                    success: function(data){
	                    	var countNotif = $('#countNotif');
	                    	var sendMessage2 = $('#sendMessage2').hasClass('in');
	                    	
	                    	if (data > 0) {
		                    	if (countNotif.html() != data) {
	                    			$('#countNotif').removeClass('hide');
		                    		countNotif.html(data);
		                    		offCanvasChat(id);

			                    	if (sendMessage2 == true) {
			                    		var to_id = $('#sendMessage2 input[name*="to_id"]').val();
			                    		var from_id = $('#sendMessage2 input[name*="from_id"]').val();
			                    		
			                    		sendChat(to_id, from_id)
			                    	}
		                    	}
	                    	} else {
		                    	if (countNotif.html() != data) {
	                    			$('#countNotif').addClass('hide');
		                    		countNotif.html(data);
		                    		offCanvasChat(id);

			                    	if (sendMessage2 == true) {
			                    		var to_id = $('#sendMessage2 input[name*="to_id"]').val();
			                    		var from_id = $('#sendMessage2 input[name*="from_id"]').val();
			                    		
			                    		sendChat(to_id, from_id)
			                    	}
		                    	}
	                    	}
	                    }
	                });
				}, 1000);
            });


			// OFFCANVAS
			function offCanvas(id) {
				if (id == 1) {
					$('#chatbox').toggleClass('show');
					$('#chatboxDrop').toggleClass('show');
				} else if (id == 2) {
					$('#stickyNote').toggleClass('show');
					$('#stickyNoteDrop').toggleClass('show');
				}
				// $('.offcanvas').modal({backdrop: 'static', keyboard: false}, 'show');
			}
			function offCanvasChat(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalChatBox_Refresh="+id+"&p=1",
                    dataType: "html",
                    success: function(data){
                    	$('#chatbox #userList').html(data);
                    }
                });
			}
        	function sendChat(id, id2) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNew_Chat="+id+"&chat="+id2,
                    dataType: "html",
                    success: function(data){
                        $("#sendMessage2 .modal-body").html(data);
                        $('.modalMessage2').trigger("reset");
                    }
                });
        	}
            $("#txtSearch").keyup(function() {

				// Retrieve the input field text and reset the count to zero
				var filter = $(this).val(),
				count = 0;

				// Loop through the comment list
				$('#userList > div .userData').each(function() {

					// If the list item does not contain the text phrase fade it out
					if ($(this).text().search(new RegExp(filter, "i")) < 0) {
						$(this).parent().parent().hide();

					// Show the list item if the phrase matches and increase the count by 1
					} else {
						$(this).parent().parent().show();
						count++;
					}
				});
			});
        	$(".modalMessage2").on('submit',(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append('btnSend_Chat',true);

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                    	var obj = jQuery.parseJSON(response);
                    	var secContainer = $('#sendMessage2 .modal-body .secContainer').first().hasClass('secSender');

                    	if (secContainer == true) {
                    		$('#sendMessage2 .modal-body .secContainer').first().find('.secMessage').prepend(obj.data_2);
                    	} else {
                    		$('#sendMessage2 .modal-body').prepend(obj.data_1);
                    	}
                        $('.modalMessage2').trigger("reset");
                        offCanvasChat(obj.current_userID);
                    }
                });
            }));


            // FOR GOOGLE TRANSLATE
            function googleExtras() {
                $('#google_translate_element > div > span').remove(); // remove Google Logo
                $('#google_translate_element > div').first().contents().eq(1).remove(); // remove Text
            }
            
            function btnLogout() {
                var id = '<?php echo $current_userID; ?>';
                window.location.href = 'function.php?logout='+id;
                localStorage.setItem('islogin','no');
                
                // $.ajax({
                //     url: 'function.php?logout='+id,
                //     context: document.body,
                //     contentType: false,
                //     processData:false,
                //     cache: false,
                //     success: function(response) {
                //         window.location.href = response;
                //     }
                // });
            }
            function btnLocked() {
                $.jTimeout.reset(0);
                $('#secondsRemaining').val( $.jTimeout().getSecondsTillExpiration() );
            }

            function bootstrapGrowl(msg) {
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
            
            function serviceCat(val) {
                if (val == 7) {
                    $('#serviceDesiredDueDate').addClass('hide');
                } else {
                    $('#serviceDesiredDueDate').removeClass('hide');
                } 
            }

            function btnSwitch(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalSwitch="+id,
                    dataType: "html",                  
                    success: function(data){
                        window.location.href = 'dashboard';
                    }
                });
            }
            
            function set_newCookie(id){
              const d = new Date();
              d.setTime(d.getTime() + (1*24*60*60*1000));
              let expires = "expires="+ d.toUTCString();
              document.cookie = 'user_company_id' + "=" + id + ";" + expires + ";path=/";
             }

            $(".modalService").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Services',true);

                var l = Ladda.create(document.querySelector('#btnSave_Services'));
                l.start();
                
                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);

                            var html = '<tr id="tr_'+obj.ID+'">';
                            html += '<td>'+obj.ID+'</td>';
                            html += '<td>'+obj.category+'</td>';
                            html += '<td>';
                                html += '<p style="margin: 0;"><b>'+obj.title+'</b></p>';
                                html += '<p style="margin: 0;">'+obj.description+'</p>';

                                if (obj.files != "") { html += '<p style="margin: 0;">'+obj.files+'</p>'; }

                            html += '</td>';
                            html += '<td>';
                                html += '<p style="margin: 0;">'+obj.contact+'</p>';
                                html += '<p style="margin: 0;"><a href="mailto:'+obj.email+'" target="_blank">'+obj.email+'</a></p>';
                            html += '</td>';
                            html += '<td class="text-center">'+obj.last_modified+'</td>';
                            html += '<td class="text-center">'+obj.due_date+'</td>';
                            html += '<td class="text-center">';
                                html += '<div class="btn-group btn-group-circle">';
                                    html += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-id="'+obj.ID+'" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                    html += '<a href="javascript:;" class="btn btn-outlinex green btn-sm btnDone" data-id="'+obj.ID+'" onclick="btnDone('+obj.ID+')">Done</a>';
                                html += '</div>';
                            html += '</td>';
                            html += '</tr>';

                            $('#tableDataServices tbody').append(html);
                            $('#modalService').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            $(".modalCollab").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Collab',true);

                var l = Ladda.create(document.querySelector('#btnSave_Collab'));
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
                            $('#modalCollab').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
        </script>
   </body>

   </html>
