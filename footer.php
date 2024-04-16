
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
                                                <select class="form-control" name="category" onchange="serviceCat(this.value)"  required>
                                                    <option value="">Select</option>
                                                    <option value="1">IT Services</option>
                                                    <option value="2">Technical Services</option>
                                                    <option value="3">Sales</option>
                                                    <option value="4">Request Demo</option>
                                                    <option value="5">Suggestion</option>
                                                    <option value="6">Problem</option>
                                                    <option value="7">Praise</option>
                                                </select>
                                            </div>
                                        </div>
										<div class="form-group">
											<label class="col-md-3 control-label">Name</label>
											<div class="col-md-8">
												<input class="form-control" type="text" name="name" placeholder="Enter your Name" value="<?php echo $current_userFName .' '. $current_userLName; ?>" required />
											</div>
										</div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Request Title</label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="title" placeholder="Example: Website, SOP, etc." required />
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
                                            <label class="col-md-3 control-label">Attach Reference File</label>
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
                                        <input type="submit" class="btn green" name="btnSave_Services" id="btnSave_Services" value="Submit" />
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
                                                    $switch_ID = 1;
                                                    $switch_name = 'Company Name';
                                                    $switch_email = 'company@gmail.com';
                                                    $switch_logo = 'no_images.png';

                                                    $selectEnterprise = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails WHERE businessemailAddress = '".$user_email."'" );
                                                    if ( mysqli_num_rows($selectEnterprise) > 0 ) {
                                                        $rowEnterprise = mysqli_fetch_array($selectEnterprise);
                                                        $switch_ID = $rowEnterprise["users_entities"];
                                                        $switch_name = $rowEnterprise["businessname"];
                                                        $switch_logo = $rowEnterprise["BrandLogos"];

                                                        echo '<div class="mt-action">
                                                            <div class="mt-action-img"><img src="'.$base_url.'companyDetailsFolder/'.$switch_logo.'" style="width: 39px; height: 39px; object-fit: cover; object-position: center; border: 1px solid #ccc;"></div>
                                                            <div class="mt-action-body">
                                                                <div class="mt-action-row">
                                                                    <div class="mt-action-info ">
                                                                        <div class="mt-action-details ">
                                                                            <span class="mt-action-author">'.$switch_name.'</span><br>
                                                                            <span class="text-muted">'.$user_email.'</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-right">
                                                                        <input type="button" class="btn btn-success btn-sm btn-circle" onclick="btnSwitch('.$switch_ID.')" value="Select" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>';
                                                    }
                                                }
                                                
                                                // List all customer
												if ($current_client = 1) {
													$selectSupplier = mysqli_query( $conn,"SELECT * from tbl_supplier WHERE page = 2 AND is_deleted = 0 AND status = 1 AND user_id = $current_userEmployerID ORDER BY name" );
													$selectSupplier = mysqli_query( $conn,"SELECT
                                                        s.name AS s_name,
                                                        s.email AS s_email,
                                                        s.employee_id AS s_employee_id,
                                                        e.users_entities AS e_users_entities,
                                                        e.businessname AS e_businessname,
                                                        e.BrandLogos AS e_BrandLogos
                                                        FROM tbl_supplier AS s
                                                        
                                                        INNER JOIN (
                                                        	SELECT
                                                            *
                                                            FROM tblEnterpiseDetails
                                                        ) AS e
                                                        ON s.email = e.businessemailAddress
                                                        
                                                        WHERE s.page = 2 
                                                        AND s.is_deleted = 0 
                                                        AND s.status = 1 
                                                        AND s.user_id = $current_userEmployerID
                                                        AND FIND_IN_SET($current_userEmployeeID, REPLACE(s.employee_id, ' ', ''))
                                                        
                                                        ORDER BY e.businessname" );
												} else {
													// $selectSupplier = mysqli_query( $conn,"SELECT * from tbl_supplier WHERE page = 2 AND category = 3 AND is_deleted = 0 AND status = 1 AND user_id = $current_userEmployerID ORDER BY name" );
													$selectSupplier = mysqli_query( $conn,"SELECT
                                                        s.name AS s_name,
                                                        s.email AS s_email,
                                                        s.employee_id AS s_employee_id,
                                                        e.users_entities AS e_users_entities,
                                                        e.businessname AS e_businessname,
                                                        e.BrandLogos AS e_BrandLogos
                                                        FROM tbl_supplier AS s
                                                        
                                                        INNER JOIN (
                                                        	SELECT
                                                            *
                                                            FROM tblEnterpiseDetails
                                                        ) AS e
                                                        ON s.email = e.businessemailAddress
                                                        
                                                        WHERE s.page = 2 
                                                        AND s.category = 3 
                                                        AND s.is_deleted = 0 
                                                        AND s.status = 1 
                                                        AND s.user_id = $current_userEmployerID
                                                        AND FIND_IN_SET($current_userEmployeeID, REPLACE(s.employee_id, ' ', ''))
                                                        
                                                        ORDER BY e.businessname" );
												}
                                                if ( mysqli_num_rows($selectSupplier) > 0 ) {
                                                    while($rowSupplier = mysqli_fetch_array($selectSupplier)) {
                                                        $switch_name = $rowSupplier["e_businessname"];
                                                        $switch_email = $rowSupplier["s_email"];
                                                        $switch_ID = $rowSupplier["e_users_entities"];
                                                        $switch_logo = $rowSupplier["e_BrandLogos"];
                                                        
                                                        echo '<div class="mt-action">
                                                            <div class="mt-action-img"><img src="'.$base_url.'companyDetailsFolder/'.$switch_logo.'" style="width: 39px; height: 39px; object-fit: cover; object-position: center;"></div>
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
                    

                    <a href="#modalService" class="icon-btn btn btn-lg green noprint" data-toggle="modal" style="position: fixed; bottom: 10px; right: 10px; border-radius: 50% !important; width: 60px; height: 60px; min-width: auto; padding-top: 8px;">
                        <i class="icon-earphones-alt"></i>
                        <div class="font-white" style="margin: 0;">Request<br>Service</div>
                    </a>
                    <?php //include "Chat_Bot/chatbox.php"; ?>
                    <!--chatbot start-->
                    <link rel="stylesheet" href="Chat_Bot/assets/style.css">
                    <!--<a href="#open_chatbot">-->
                    <!--<div class="bot-icon" style="margin-top:-9rem;margin-right:1rem;">-->
                    <!--    <img src="Chat_Bot/assets/img/chatbot.png" alt="">-->
                        <!--<i class="fa fa-comments-o" style="display: flex;justify-content: center;font-size:46px; text-decoration: none;"></i>-->
                    <!--</div>-->
                    <!--</a>-->
                    <div class="chatbox-wrap bg-white" id="chatbotBox" style="height: 480px; width: 330px; display: none;">
                    <div class="chatbox-content">
                        <div class="chatbox-header bg-blue">
                            <div class="bot-icon">
                                <img src="Chat_Bot/assets/img/chatbot.png" alt="">
                                <span class="active"></span>
                            </div>
                            <div>
                                <h4 style="font-weight: 500; margin: 0;">InterlinkIQ Bot</h4>
                                <h6 style="margin: 0;">Online</h6>
                            </div>
                            <div class="font-white">
                                <button type="button" class="chatbox-close"></button>
                            </div>
                        </div>
                        <div class="chatbox-body">
                            <div class="messages-wrap">
                                <div class="messages">
                                    <div class="post in">
                                        <img class="avatar" alt="" src="Chat_Bot/assets/img/chatbot.png">
                                        <div class="post-body">
                                            <span class="name">InterlinkIQ Bot</span>
                                            <div class="message">
                                                <?php
                                                         $i_user = $_COOKIE['ID'];
                                                        $query = "SELECT * from tbl_user where ID = '$i_user'";
                                                        $result = mysqli_query($conn, $query);
                                                                                    
                                                        while($row = mysqli_fetch_array($result))
                                                        {?>
                                                    Hello <?php echo $row['first_name']; ?>, What can I help you with? ðŸ˜Š
                                                    <?php } ?>
                                            </div>
                                            <!--<div class="message">-->
                                            
                                            <!--</div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form id="chatbotComposeMessage" class="chatbox-footer">
                            <div style="width: 100%;">
                                <textarea style="resize: none; border: none;" name="message" class="form-control" rows="1"
                                    placeholder="Write a message..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-link btn-lg" style="padding: 0 10px 0 0;">
                                <i class="fa fa-send"></i>
                            </button>
                        </form>
                    </div>
                    </div>
                    <!--chat bot end-->


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

                    <!-- BEGIN QUICK SIDEBAR -->
                    <a href="javascript:;" class="page-quick-sidebar-toggler">
                        <i class="icon-login"></i>
                    </a>
                    <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
                        <div class="page-quick-sidebar">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"> Users
                                        <span class="badge badge-danger">2</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" data-target="#quick_sidebar_tab_2" data-toggle="tab"> Alerts
                                        <span class="badge badge-success">7</span>
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> More
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                                <i class="icon-bell"></i> Alerts </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                                <i class="icon-info"></i> Notifications </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                                <i class="icon-speech"></i> Activities </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                                <i class="icon-settings"></i> Settings </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                                    <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                                        <h3 class="list-heading">Staff</h3>
                                        <ul class="media-list list-items">
                                            <li class="media">
                                                <div class="media-status">
                                                    <span class="badge badge-success">8</span>
                                                </div>
                                                <img class="media-object" src="<?=$base_url?>assets/layouts/layout/img/avatar3.jpg" alt="...">
                                                <div class="media-body">
                                                    <h4 class="media-heading">Bob Nilson</h4>
                                                    <div class="media-heading-sub"> Project Manager </div>
                                                </div>
                                            </li>
                                            <li class="media">
                                                <img class="media-object" src="<?=$base_url?>assets/layouts/layout/img/avatar1.jpg" alt="...">
                                                <div class="media-body">
                                                    <h4 class="media-heading">Nick Larson</h4>
                                                    <div class="media-heading-sub"> Art Director </div>
                                                </div>
                                            </li>
                                            <li class="media">
                                                <div class="media-status">
                                                    <span class="badge badge-danger">3</span>
                                                </div>
                                                <img class="media-object" src="<?=$base_url?>assets/layouts/layout/img/avatar4.jpg" alt="...">
                                                <div class="media-body">
                                                    <h4 class="media-heading">Deon Hubert</h4>
                                                    <div class="media-heading-sub"> CTO </div>
                                                </div>
                                            </li>
                                            <li class="media">
                                                <img class="media-object" src="<?=$base_url?>assets/layouts/layout/img/avatar2.jpg" alt="...">
                                                <div class="media-body">
                                                    <h4 class="media-heading">Ella Wong</h4>
                                                    <div class="media-heading-sub"> CEO </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <h3 class="list-heading">Customers</h3>
                                        <ul class="media-list list-items">
                                            <li class="media">
                                                <div class="media-status">
                                                    <span class="badge badge-warning">2</span>
                                                </div>
                                                <img class="media-object" src="<?=$base_url?>assets/layouts/layout/img/avatar6.jpg" alt="...">
                                                <div class="media-body">
                                                    <h4 class="media-heading">Lara Kunis</h4>
                                                    <div class="media-heading-sub"> CEO, Loop Inc </div>
                                                    <div class="media-heading-small"> Last seen 03:10 AM </div>
                                                </div>
                                            </li>
                                            <li class="media">
                                                <div class="media-status">
                                                    <span class="label label-sm label-success">new</span>
                                                </div>
                                                <img class="media-object" src="<?=$base_url?>assets/layouts/layout/img/avatar7.jpg" alt="...">
                                                <div class="media-body">
                                                    <h4 class="media-heading">Ernie Kyllonen</h4>
                                                    <div class="media-heading-sub"> Project Manager,
                                                        <br> SmartBizz PTL </div>
                                                </div>
                                            </li>
                                            <li class="media">
                                                <img class="media-object" src="<?=$base_url?>assets/layouts/layout/img/avatar8.jpg" alt="...">
                                                <div class="media-body">
                                                    <h4 class="media-heading">Lisa Stone</h4>
                                                    <div class="media-heading-sub"> CTO, Keort Inc </div>
                                                    <div class="media-heading-small"> Last seen 13:10 PM </div>
                                                </div>
                                            </li>
                                            <li class="media">
                                                <div class="media-status">
                                                    <span class="badge badge-success">7</span>
                                                </div>
                                                <img class="media-object" src="<?=$base_url?>assets/layouts/layout/img/avatar9.jpg" alt="...">
                                                <div class="media-body">
                                                    <h4 class="media-heading">Deon Portalatin</h4>
                                                    <div class="media-heading-sub"> CFO, H&D LTD </div>
                                                </div>
                                            </li>
                                            <li class="media">
                                                <img class="media-object" src="<?=$base_url?>assets/layouts/layout/img/avatar10.jpg" alt="...">
                                                <div class="media-body">
                                                    <h4 class="media-heading">Irina Savikova</h4>
                                                    <div class="media-heading-sub"> CEO, Tizda Motors Inc </div>
                                                </div>
                                            </li>
                                            <li class="media">
                                                <div class="media-status">
                                                    <span class="badge badge-danger">4</span>
                                                </div>
                                                <img class="media-object" src="<?=$base_url?>assets/layouts/layout/img/avatar11.jpg" alt="...">
                                                <div class="media-body">
                                                    <h4 class="media-heading">Maria Gomez</h4>
                                                    <div class="media-heading-sub"> Manager, Infomatic Inc </div>
                                                    <div class="media-heading-small"> Last seen 03:10 AM </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="page-quick-sidebar-item">
                                        <div class="page-quick-sidebar-chat-user">
                                            <div class="page-quick-sidebar-nav">
                                                <a href="javascript:;" class="page-quick-sidebar-back-to-list">
                                                    <i class="icon-arrow-left"></i>Back</a>
                                            </div>
                                            <div class="page-quick-sidebar-chat-user-messages">
                                                <div class="post out">
                                                    <img class="avatar" alt="" src="<?=$base_url?>assets/layouts/layout/img/avatar3.jpg" />
                                                    <div class="message">
                                                        <span class="arrow"></span>
                                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                                        <span class="datetime">20:15</span>
                                                        <span class="body"> When could you send me the report ? </span>
                                                    </div>
                                                </div>
                                                <div class="post in">
                                                    <img class="avatar" alt="" src="<?=$base_url?>assets/layouts/layout/img/avatar2.jpg" />
                                                    <div class="message">
                                                        <span class="arrow"></span>
                                                        <a href="javascript:;" class="name">Ella Wong</a>
                                                        <span class="datetime">20:15</span>
                                                        <span class="body"> Its almost done. I will be sending it shortly </span>
                                                    </div>
                                                </div>
                                                <div class="post out">
                                                    <img class="avatar" alt="" src="<?=$base_url?>assets/layouts/layout/img/avatar3.jpg" />
                                                    <div class="message">
                                                        <span class="arrow"></span>
                                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                                        <span class="datetime">20:15</span>
                                                        <span class="body"> Alright. Thanks! :) </span>
                                                    </div>
                                                </div>
                                                <div class="post in">
                                                    <img class="avatar" alt="" src="<?=$base_url?>assets/layouts/layout/img/avatar2.jpg" />
                                                    <div class="message">
                                                        <span class="arrow"></span>
                                                        <a href="javascript:;" class="name">Ella Wong</a>
                                                        <span class="datetime">20:16</span>
                                                        <span class="body"> You are most welcome. Sorry for the delay. </span>
                                                    </div>
                                                </div>
                                                <div class="post out">
                                                    <img class="avatar" alt="" src="<?=$base_url?>assets/layouts/layout/img/avatar3.jpg" />
                                                    <div class="message">
                                                        <span class="arrow"></span>
                                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                                        <span class="datetime">20:17</span>
                                                        <span class="body"> No probs. Just take your time :) </span>
                                                    </div>
                                                </div>
                                                <div class="post in">
                                                    <img class="avatar" alt="" src="<?=$base_url?>assets/layouts/layout/img/avatar2.jpg" />
                                                    <div class="message">
                                                        <span class="arrow"></span>
                                                        <a href="javascript:;" class="name">Ella Wong</a>
                                                        <span class="datetime">20:40</span>
                                                        <span class="body"> Alright. I just emailed it to you. </span>
                                                    </div>
                                                </div>
                                                <div class="post out">
                                                    <img class="avatar" alt="" src="<?=$base_url?>assets/layouts/layout/img/avatar3.jpg" />
                                                    <div class="message">
                                                        <span class="arrow"></span>
                                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                                        <span class="datetime">20:17</span>
                                                        <span class="body"> Great! Thanks. Will check it right away. </span>
                                                    </div>
                                                </div>
                                                <div class="post in">
                                                    <img class="avatar" alt="" src="<?=$base_url?>assets/layouts/layout/img/avatar2.jpg" />
                                                    <div class="message">
                                                        <span class="arrow"></span>
                                                        <a href="javascript:;" class="name">Ella Wong</a>
                                                        <span class="datetime">20:40</span>
                                                        <span class="body"> Please let me know if you have any comment. </span>
                                                    </div>
                                                </div>
                                                <div class="post out">
                                                    <img class="avatar" alt="" src="<?=$base_url?>assets/layouts/layout/img/avatar3.jpg" />
                                                    <div class="message">
                                                        <span class="arrow"></span>
                                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                                        <span class="datetime">20:17</span>
                                                        <span class="body"> Sure. I will check and buzz you if anything needs to be corrected. </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="page-quick-sidebar-chat-user-form">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Type a message here..." />
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn green">
                                                            <i class="icon-paper-clip"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane page-quick-sidebar-alerts" id="quick_sidebar_tab_2">
                                    <div class="page-quick-sidebar-alerts-list">
                                        <h3 class="list-heading">General</h3>
                                        <ul class="feeds list-items">
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-info">
                                                                <i class="fa fa-check"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> You have 4 pending tasks.
                                                                <span class="label label-sm label-warning "> Take action
                                                                    <i class="fa fa-share"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"> Just now </div>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <div class="col1">
                                                        <div class="cont">
                                                            <div class="cont-col1">
                                                                <div class="label label-sm label-success">
                                                                    <i class="fa fa-bar-chart-o"></i>
                                                                </div>
                                                            </div>
                                                            <div class="cont-col2">
                                                                <div class="desc"> Finance Report for year 2013 has been released. </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col2">
                                                        <div class="date"> 20 mins </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-danger">
                                                                <i class="fa fa-user"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"> 24 mins </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-info">
                                                                <i class="fa fa-shopping-cart"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> New order received with
                                                                <span class="label label-sm label-success"> Reference Number: DR23923 </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"> 30 mins </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-user"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"> 24 mins </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-info">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> Web server hardware needs to be upgraded.
                                                                <span class="label label-sm label-warning"> Overdue </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"> 2 hours </div>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <div class="col1">
                                                        <div class="cont">
                                                            <div class="cont-col1">
                                                                <div class="label label-sm label-default">
                                                                    <i class="fa fa-briefcase"></i>
                                                                </div>
                                                            </div>
                                                            <div class="cont-col2">
                                                                <div class="desc"> IPO Report for year 2013 has been released. </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col2">
                                                        <div class="date"> 20 mins </div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                        <h3 class="list-heading">System</h3>
                                        <ul class="feeds list-items">
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-info">
                                                                <i class="fa fa-check"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> You have 4 pending tasks.
                                                                <span class="label label-sm label-warning "> Take action
                                                                    <i class="fa fa-share"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"> Just now </div>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <div class="col1">
                                                        <div class="cont">
                                                            <div class="cont-col1">
                                                                <div class="label label-sm label-danger">
                                                                    <i class="fa fa-bar-chart-o"></i>
                                                                </div>
                                                            </div>
                                                            <div class="cont-col2">
                                                                <div class="desc"> Finance Report for year 2013 has been released. </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col2">
                                                        <div class="date"> 20 mins </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-default">
                                                                <i class="fa fa-user"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"> 24 mins </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-info">
                                                                <i class="fa fa-shopping-cart"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> New order received with
                                                                <span class="label label-sm label-success"> Reference Number: DR23923 </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"> 30 mins </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-user"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"> 24 mins </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-warning">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> Web server hardware needs to be upgraded.
                                                                <span class="label label-sm label-default "> Overdue </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"> 2 hours </div>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <div class="col1">
                                                        <div class="cont">
                                                            <div class="cont-col1">
                                                                <div class="label label-sm label-info">
                                                                    <i class="fa fa-briefcase"></i>
                                                                </div>
                                                            </div>
                                                            <div class="cont-col2">
                                                                <div class="desc"> IPO Report for year 2013 has been released. </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col2">
                                                        <div class="date"> 20 mins </div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane page-quick-sidebar-settings" id="quick_sidebar_tab_3">
                                    <div class="page-quick-sidebar-settings-list">
                                        <h3 class="list-heading">General Settings</h3>
                                        <ul class="list-items borderless">
                                            <li> Enable Notifications
                                                <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF" /> </li>
                                            <li> Allow Tracking
                                                <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" /> </li>
                                            <li> Log Errors
                                                <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF" /> </li>
                                            <li> Auto Sumbit Issues
                                                <input type="checkbox" class="make-switch" data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF" /> </li>
                                            <li> Enable SMS Alerts
                                                <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF" /> </li>
                                        </ul>
                                        <h3 class="list-heading">System Settings</h3>
                                        <ul class="list-items borderless">
                                            <li> Security Level
                                                <select class="form-control input-inline input-sm input-small">
                                                    <option value="1">Normal</option>
                                                    <option value="2" selected>Medium</option>
                                                    <option value="e">High</option>
                                                </select>
                                            </li>
                                            <li> Failed Email Attempts
                                                <input class="form-control input-inline input-sm input-small" value="5" /> </li>
                                            <li> Secondary SMTP Port
                                                <input class="form-control input-inline input-sm input-small" value="3560" /> </li>
                                            <li> Notify On System Error
                                                <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF" /> </li>
                                            <li> Notify On SMTP Error
                                                <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF" /> </li>
                                        </ul>
                                        <div class="inner-content">
                                            <button class="btn btn-success"><i class="icon-settings"></i> Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END QUICK SIDEBAR -->
                </div>
                <!-- END CONTAINER -->

                <!-- BEGIN FOOTER -->
                <div class="page-footer">
                    <div class="page-footer-inner"> 2022 &copy;
                        <a target="_blank" href="https://Consultareinc.com">INTERLINKIQ. V1</a> 
                        <div class="scroll-to-top hide">
                            <i class="icon-arrow-up"></i>
                        </div>
                    </div>
                </div>
                <!-- END FOOTER -->
            </div>
        </div>
        <!--[if lt IE 9]>
        <script src="../assets/global/plugins/respond.min.js"></script>
        <script src="../assets/global/plugins/excanvas.min.js"></script> 
        <script src="../assets/global/plugins/ie8.fix.min.js"></script> 
        <![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?=$base_url?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>

        <script src='//htmlguyllc.github.io/jAlert/dist/jAlert.min.js'></script>
        <script src='<?=$base_url?>Chat_Bot/assets/algo.js'></script>
        <script src='<?=$base_url?>Chat_Bot/assets/script.js'></script>
        <script src='<?=$base_url?>jTimeout.js'></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?=$base_url?>assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

        <script src="<?=$base_url?>assets/global/plugins/jquery.mockjax.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/bootstrap-editable/inputs-ext/address/address.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/bootstrap-editable/inputs-ext/wysihtml5/wysihtml5.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/bootstrap-typeahead/bootstrap3-typeahead.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

        <script src="<?=$base_url?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

        <script src="<?=$base_url?>assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js" type="text/javascript"></script>
        
        <script src="<?=$base_url?>assets/global/plugins/jquery-repeater/jquery.repeater.js" type="text/javascript"></script>

        <script src="<?=$base_url?>assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>

        <script src="<?=$base_url?>assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>

        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
        
        <script src="<?=$base_url?>assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>

        <script src="<?=$base_url?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
		<script src="<?=$base_url?>assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>

		<script src="//www.codehim.com/demo/checkall-select-all-checkboxes-in-table-column/js/checkAll.min.js"></script>

        <script src="<?=$base_url?>assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?=$base_url?>assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?=$base_url?>assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?=$base_url?>assets/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?=$base_url?>assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        
        <script src="<?=$base_url?>assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        
        <!-- END THEME LAYOUT SCRIPTS -->


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


                selectMulti();

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
        		// setInterval(function() {
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
				// }, 1000);
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
                window.location.href = '<?=$base_url?>function.php?logout='+id;
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

            function fancyBoxes() {
                Fancybox.bind('[data-fancybox]', {
                    Toolbar: {
                        display: [
                            { id: "prev", position: "center" },
                            { id: "counter", position: "center" },
                            { id: "next", position: "center" },
                            "zoom",
                            "slideshow",
                            "fullscreen",
                            "download",
                            "thumbs",
                            "close",
                        ],
                    },
                });
            }

            function selectMulti() {
                $('.mt-multiselect').multiselect({
                    widthSynchronizationMode: 'ifPopupIsSmaller',
                    buttonTextAlignment: 'left',
                    buttonWidth: '100%',
                    maxHeight: 200,
                    enableResetButton: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering: true,
                    includeSelectAllOption: true,
                    nonSelectedText: 'None selected'
                });
                $('.multiselect-container .multiselect-filter', $('.mt-multiselect').parent()).css({
                    'position': 'sticky', 'top': '0px', 'z-index': 1,
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
							html += '<td class="text-center">Pending</td>';
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


			// Instructions Section
            function selectInstruction(id) {
                $('.selInstruction').addClass('hide');
                if (id == 0) { $('#selFile').removeClass('hide'); }
                else { $('#selURL').removeClass('hide'); }
            }
            function btnInstruction() {
				var site = '<?php echo $site; ?>';
                $.ajax({
                    type: "GET",
                    url: "function.php?modalInstruction="+site,
                    dataType: "html",
                    success: function(data){
                        $("#modalInstruction .modal-body").html(data);
                    }
                });
            }
            $(".modalInstruction").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Instruction',true);

                var l = Ladda.create(document.querySelector('#btnSave_Instruction'));
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
                            $('#modalInstruction').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));

            // Speakup Section
            function btnSpeakup(id) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalSpeakup="+id,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalSpeakUpView .modal-body").html(data);
                    }
                });
            }
            function btnSpeakupAll(id) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalSpeakupAll="+id,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalSpeakUpViewAll .modal-body table tbody").html(data);
                		$('#tableData_Speakup').DataTable();
                    }
                });
            }
            $(".modalSpeakUp").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Speakup',true);

                var l = Ladda.create(document.querySelector('#btnSave_Speakup'));
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
                            msg = "Sucessfully Sent!";

							var obj = jQuery.parseJSON(response);
							$('#speakup_employee .dropdown-menu-list').prepend(obj.data);
                            $('#modalSpeakUp').modal('hide');
                        	$('.modalSpeakUp').trigger("reset");
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            $(".modalSpeakUpView").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_SpeakupView',true);

                var l = Ladda.create(document.querySelector('#btnSave_SpeakupView'));
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
                            msg = "Sucessfully Sent!";

							var obj = jQuery.parseJSON(response);
							var html = '<li>'+obj.comment+'<br>'+obj.last_modified+'</li>';
							alert(html);
							$('#modalSpeakUpView .modal-body ul').append(html);
							alert(html);
                        	$('.modalSpeakUpView').trigger("reset");
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));

            // Sticky Notes
            function noteView(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNotes_view="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalNotesView .modal-body").html(data);
                        selectMulti();
                    }
                });
            }
            function noteViewCopy(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNotes_view="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalNotesViewCopy .modal-body").html(data);
                        selectMulti();
                    }
                });
            }
            function noteDelete(id) {
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
                        url: "function.php?modalNotes_delete="+id,
                        dataType: "html",
                        success: function(response){
                        	$('#note_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            $(".modalNotes").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Notes',true);

                var l = Ladda.create(document.querySelector('#btnSave_Notes'));
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
							$('#userNotes').prepend(obj.data);
                            $('#modalNotes').modal('hide');
                        	$('.modalNotes').trigger("reset");
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            $(".modalNotesView").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Notes',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Notes'));
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
                            $('#userNotes #note_'+obj.ID).html(obj.data);
                            $('#modalNotesView').modal('hide');
                        	$('.modalNotesView').trigger("reset");
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
        </script>


        <!-- SET AUTO LOGOUT -->
        <script>
            function storageChange (event) {
                if(event.key === 'islogin') {
                    window.location.href = "login";
                }
            }
            window.addEventListener('storage', storageChange, false)
        </script>


        <!--SET AUTO LOCK-->
        <script type="text/javascript">
            $(function(){
                var id = '<?php echo $current_userID; ?>';
                $('.60Left').on('click', function(e){
                    e.preventDefault();
                    $.jTimeout.reset(10);
                    $('#secondsRemaining').val( $.jTimeout().getSecondsTillExpiration() );
                });

                $('.1440Left').on('click', function(e){
                    e.preventDefault();
                    $.jTimeout.reset();
                    $('#secondsRemaining').val( $.jTimeout().getSecondsTillExpiration() );
                });

                $('.0Left').on('click', function(e){
                    e.preventDefault();
                    $.jTimeout.reset(0);
                    $('#secondsRemaining').val( $.jTimeout().getSecondsTillExpiration() );
                });
                $.jTimeout({
                    /* For this example only */
                    flashTitle: false,
                    'onClickExtend': function(jTimeout)
                    {
                        $('.jAlert').closeAlert();
                        $.jTimeout().resetExpiration();
                    },
                    'timeoutAfter': 6000,
                    'extendOnMouseMove': true,
                    'mouseDebounce': 5,
                    'logoutUrl': 'function.php?logout='+id,
                    'onTimeout': function(jTimeout)
                    {
                        window.location.href = "locked";
                    },
                    secondsPrior: 30
                });

                var timer,
                setTimer = function(){
                    timer = window.setInterval(function(){
                        $('#secondsRemaining').val( $.jTimeout().getSecondsTillExpiration() );
                    }, 1000);
                };

                setTimer();
            });
        </script>