<?php
    include_once ('../database.php');

    // GENERAL
    $base_url = "//interlinkiq.com/";
    
    // PHP MAILER FUNCTION
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	function php_mailer($to, $user, $subject, $body) {

		require 'PHPMailer/src/Exception.php';
		require 'PHPMailer/src/PHPMailer.php';
		require 'PHPMailer/src/SMTP.php';

		$mail = new PHPMailer(true);
		try {
		    $mail->isSMTP();
		  //  $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
		    $mail->Host       = 'interlinkiq.com';
		    $mail->SMTPAuth   = true;
		    $mail->Username   = 'admin@interlinkiq.com';
		    $mail->Password   = 'L1873@2019new';
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		    $mail->Port       = 465;
		    $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
		    $mail->addAddress($to, $user);

		    $mail->isHTML(true);
		    $mail->Subject = $subject;
		    $mail->Body    = $body;

		    $mail->send();
		    $msg = 'Message has been sent';
		} catch (Exception $e) {
		    $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}

		return $msg;
	}


	// LOGIN SECTION
	if( isset($_GET['logout']) ) {
		unset($_COOKIE['ID']);
    	setcookie('ID', '', time() - 3600, '/'); // empty value and old timestamp

		unset($_COOKIE['locked']);
    	setcookie('locked', '', time() - 3600, '/'); // empty value and old timestamp

		echo '<script>window.location.href = "login"</script>';
	}
	if( isset($_POST['btnSignIn']) ) {
		$username = $_POST['username'];
		$email = $_POST['username'];
		$password = $_POST['password'];
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		$exist = false;
		$exist_email = false;
		$exist_username = false;
		$isPasswordCorrect = false;
		$message = 'Incorrect details. Please try again';

		$selectEmail = mysqli_query( $conn,'SELECT * FROM tbl_user WHERE is_active=1 AND email="'. $username .'"' );
		if ( mysqli_num_rows($selectEmail) > 0 ) {
			while($rowUser = mysqli_fetch_array($selectEmail)) {
				$ID = $rowUser['ID'];
				$password_verify = $rowUser['password'];
				$is_verified = $rowUser['is_verified'];
				$is_active = $rowUser['is_active'];

				$isPasswordCorrect = password_verify($password, $password_verify);
				if ($isPasswordCorrect == true) {
					if ($is_active == 1 and $is_verified == 1) {
						$exist = true;
						$message = "Logged In successfully";

						setcookie('ID', $ID, time() + (86400 * 1), "/");  // 86400 = 1 day
					} else if ($is_active == 1 and $is_verified == 0) {
						$message = "Please check your email to verify this account";
					}
				}
			}
		}

		$selectUsername = mysqli_query( $conn,'SELECT * FROM tbl_user WHERE is_active=1 AND username="'. $username .'"' );
		if ( mysqli_num_rows($selectUsername) > 0 ) {
			while($rowUser = mysqli_fetch_array($selectUsername)) {
				$ID = $rowUser['ID'];
				$password_verify = $rowUser['password'];
				$is_verified = $rowUser['is_verified'];
				$is_active = $rowUser['is_active'];

				$isPasswordCorrect = password_verify($password, $password_verify);
				if ($isPasswordCorrect == true) {
					if ($is_active == 1 and $is_verified == 1) {
						$exist = true;
						$message = "Logged In successfully";

						setcookie('ID', $ID, time() + (86400 * 1), "/");  // 86400 = 1 day
					} else if ($is_active == 1 and $is_verified == 0) {
						$message = "Please check your email to verify this account";
					}
				}
			}
		}

		unset($_COOKIE['locked']);
    	setcookie('locked', '', time() - 3600, '/'); // empty value and old timestamp

		$output = array(
			'message' => $message,
			'password' => $isPasswordCorrect,
			'exist' => $exist
		);
		echo json_encode($output);
	}
	if( isset($_POST['btnSignUp']) ) {
		$ID = $_POST['ID'];
		if (empty($ID)) { $ID = 0; }
		
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		$exist = false;
		$message = 'Email/Username is already exist. Please try again.';

		$selectUsername = mysqli_query( $conn,'SELECT * FROM tbl_user WHERE username="'. $username .'"' );
		if ( mysqli_num_rows($selectUsername) > 0 ) { $exist = true; }

		$selectEmail = mysqli_query( $conn,'SELECT * FROM tbl_user WHERE email="'. $email .'"' );
		if ( mysqli_num_rows($selectEmail) > 0 ) { $exist = true; }

		if ($exist == false) {
			$sql = "INSERT INTO tbl_user (employee_id, first_name, last_name, email, username, password)
			VALUES ( '$ID', '$first_name', '$last_name', '$email', '$username', '$password_hash')";
			if (mysqli_query($conn, $sql)) {
				$last_id = mysqli_insert_id($conn);

				$to = $email;
				$user = $first_name .' '. $last_name;
				$subject = 'Welcome to InterlinkIQ.com';
				$body = 'Hi '. $first_name .', please click <a href="'.  $base_url .'login?c=1&i='. $last_id .'">here</a> to confirm your account';
				
				$mail = php_mailer($to, $user, $subject, $body);
				$message = 'Registration success. Please check your email for validation.';
            }
            // else {
            //     $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
            // }
		}
		$output = array(
			'exist' => $exist,
			'message' => $message
		);
		echo json_encode($output);
	}
	if( isset($_POST['btnReset']) ) {
		$email = $_POST['email'];
		$exist = false;

		$selectEmail = mysqli_query( $conn,'SELECT * FROM tbl_user WHERE is_active = 1 AND email="'. $email .'"' );
		if ( mysqli_num_rows($selectEmail) > 0 ) {
			while($rowUser = mysqli_fetch_array($selectEmail)) {
				$id = $rowUser['ID'];
				$to = $rowUser['email'];
				$user = $rowUser['first_name'] .' '. $rowUser['last_name'];
				$subject = 'Reset your password';
				$body = 'Did you request to Reset your Password? If yes, please click <a href="'.  $base_url .'login?f=1&i='. $id .'">here</a> to login your account and use your temporary password as Interlink2022. Then go to Account Setting to Enter Your New Password. Otherwise, ignore this message. Thanks';

				$mail = php_mailer($to, $user, $subject, $body);
				$message = 'Please check your email to reset your password.';
				$exist = true;
			}
		} else {
			$message = 'Email Address does not exist. Please try again';
		}
		$output = array(
			'exist' => $exist,
			'message' => $message
		);
		echo json_encode($output);
	}



	if( isset($_POST['btnSave_HR_Employee']) ) {
		$ID = $_POST['ID'];
		$email = $_POST['email'];	 
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$type_id = $_POST['type_id'];
		$id_number = $_POST['id_number'];
		$date_hired = $_POST['date_hired'];
		$department_id = $_POST['department_id'];
		$job_description_id = implode(", ",$_POST['job_description_id']);
		$reporting_to_id = $_POST['reporting_to_id'];
		$exist = false;

		$selectEmployee = mysqli_query( $conn,'SELECT * FROM tbl_hr_employee WHERE email="'. $email .'"' );
		if ( mysqli_num_rows($selectEmployee) > 0 ) {
			$exist = true;
		}
// 		$selectUser = mysqli_query( $conn,'SELECT * FROM tbl_user WHERE email="'. $email .'"' );
// 		if ( mysqli_num_rows($selectUser) > 0 ) {
// 			$exist = true;
// 		}

		if ($exist == false) {

			$sql = "INSERT INTO tbl_hr_employee (user_id, first_name, last_name, email, type_id, id_number, date_hired, department_id, job_description_id, reporting_to_id)
			VALUES ('$ID', '$first_name', '$last_name', '$email', '$type_id', '$id_number', '$date_hired', '$department_id', '$job_description_id', '$reporting_to_id')";
			
			if (mysqli_query($conn, $sql)) {

				$last_id = mysqli_insert_id($conn);
				$selectData = mysqli_query( $conn,'SELECT * FROM tbl_hr_employee WHERE user_id="'. $ID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );
				
				if ( mysqli_num_rows($selectData) > 0 ) {
					$rowData = mysqli_fetch_array($selectData);
					$data_ID = $rowData['ID'];
					$data_first_name = $rowData['first_name'];
					$data_last_name = $rowData['last_name'];
					$data_email = $rowData['email'];
					$data_date_hired = $rowData['date_hired'];
					$data_type_id = $rowData['type_id'];

					$to = $data_email;
					$user = $data_first_name .' '. $data_last_name;
					$subject = 'You are invited!';
					$body = 'Hi '. $data_first_name .'<br><br>You are invited to Interlink System. Please click <a href="http://interlinkiq.com/login?r=1&i='. $last_id .'">here</a> to join';

					$mail = php_mailer($to, $user, $subject, $body);

					$employment_type = array(
                        1 => 'Full-time',
                        2 => 'Part-time',
                        3 => 'OJT',
                        4 => 'Freelance',
                        5 => 'Intern'
                    );

	            	$counterup_tbl = counterup_tbl('employee');
					$output = array(
						"ID" => $data_ID,
						"first_name" => $data_first_name,
						"last_name" => $data_last_name,
						"email" => $data_email,
						"date_hired" => $data_date_hired,
						"employment_type" => $employment_type[$data_type_id]
					);

					$result = array_merge($counterup_tbl, $output);
				}
			} else {
				$result = '';
			}
			mysqli_close($conn);
		} else {
			$result = '';
		}
		echo json_encode($result);
	}

	if( isset($_POST['btnUpdate_HR_Employee']) ) {
		$ID = $_POST['ID'];	 	 
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$type_id = $_POST['type_id'];
		$id_number = $_POST['id_number'];
		$date_hired = $_POST['date_hired'];
		$department_id = $_POST['department_id'];
		$job_description_id = implode(", ",$_POST['job_description_id']);
		$reporting_to_id = $_POST['reporting_to_id'];
		$suspended = isset($_POST['suspended']) ? 1 : 0;
		$status = isset($_POST['status']) ? 1 : 0;
		$status_last_modified = date('Y-m-d');

		mysqli_query( $conn,"UPDATE tbl_hr_employee set first_name='". $first_name ."', last_name='". $last_name ."', email='". $email ."', type_id='". $type_id ."', id_number='". $id_number ."', date_hired='". $date_hired ."', department_id='". $department_id ."', job_description_id='". $job_description_id ."', reporting_to_id='". $reporting_to_id ."', suspended='". $suspended ."', status='". $status ."', last_modified='". $status_last_modified ."' WHERE ID='". $ID ."'" );
		
		if (!mysqli_error($conn)) {
			$employment_type = array(
                1 => 'Full-time',
                2 => 'Part-time',
                3 => 'OJT',
                4 => 'Freelance',
                5 => 'Intern'
            );
            
		    $counterup_tbl = counterup_tbl('employee');
			$output = array(
				'ID' => $ID,
				'first_name' => $first_name,
				'last_name' => $last_name,
				'email' => $email,
				'date_hired' => $date_hired,
				'employment_type' => $employment_type[$type_id],
				'suspended' => $suspended,
				'status' => $status
			);

			$result = array_merge($counterup_tbl, $output);
			echo json_encode($result);
		}

		mysqli_close($conn);
	}

	if( isset($_GET['modalView_HR_Employee']) ) {
		$id = $_GET['modalView_HR_Employee'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
            $user_id = $row['user_id'];
        }

		echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
        <div class="form-group">
            <label class="col-md-3 control-label">Email Address</label>
            <div class="col-md-8">
                <input class="form-control" type="email" name="email" value="'. $row['email'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">First Name</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="first_name" value="'. $row['first_name'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Last Name</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="last_name" value="'. $row['last_name'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Type</label>
            <div class="col-md-8">
                <select class="form-control" name="type_id" required >
                    <option value="">Select</option>
                    <option value="1" '; if ($row['type_id'] == 1) { echo 'selected'; } echo '>Full-time</option>
                    <option value="2" '; if ($row['type_id'] == 2) { echo 'selected'; } echo '>Part-time</option>
                    <option value="3" '; if ($row['type_id'] == 3) { echo 'selected'; } echo '>OJT</option>
                    <option value="4" '; if ($row['type_id'] == 4) { echo 'selected'; } echo '>Freelance</option>
                    <option value="5" '; if ($row['type_id'] == 5) { echo 'selected'; } echo '>Intern</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">ID Number</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="id_number" id="id_number" value="'. $row['id_number'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Date Hired</label>
            <div class="col-md-8">
                <input class="form-control" type="date" name="date_hired" id="date_hired" value="'. $row['date_hired'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Department</label>
            <div class="col-md-8">
                <select class="form-control" name="department_id" >';

	                $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE status = 1 AND user_id = $user_id" );
			        if ( mysqli_num_rows($selectDepartment) > 0 ) {
			        	echo '<option value="">Select</option>';
				        while($rowDepartment = mysqli_fetch_array($selectDepartment)) {
				        	if ( $rowDepartment["ID"] === $row["department_id"] ) {
				        		echo '<option value="'. $rowDepartment["ID"] .'" selected>'. $rowDepartment["title"] .'</option>';
				        	} else {
				        		echo '<option value="'. $rowDepartment["ID"] .'">'. $rowDepartment["title"] .'</option>';
				        	}
				        }
			        } else {
			        	echo '<option disabled>No Available</option>';
			        }

                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Job Description</label>
            <div class="col-md-8">
                <select multiple class="form-control" name="job_description_id[]" >';

                	$array_Job = explode(", ", $row["job_description_id"]);
                    $resultJob = mysqli_query( $conn,"SELECT * FROM tbl_hr_job_description WHERE status = 1 AND user_id = $user_id" );
                    if ( mysqli_num_rows($resultJob) > 0 ) {
                        while($rowJob = mysqli_fetch_array($resultJob)) {
							if (in_array($rowJob["ID"], $array_Job)) {
								echo '<option value="'. $rowJob["ID"] .'" selected>'. $rowJob["title"] .'</option>';
							} else {
								echo '<option value="'. $rowJob["ID"] .'">'. $rowJob["title"] .'</option>';
							}
                        }
                    } else {
                    	echo '<option value="" disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Reporting To</label>
            <div class="col-md-8">
                <select class="form-control" name="reporting_to_id" >';

	                $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $user_id" );
			        if ( mysqli_num_rows($selectEmployee) > 0 ) {
			        	echo '<option value="">Select</option>';
				        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
				        	if ( $rowEmployee["ID"] === $row["reporting_to_id"] ) {
				        		echo '<option value="'. $rowEmployee["ID"] .'" selected>'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
				        	} else {
				        		echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
				        	}
				        }
			        } else {
			        	echo '<option disabled>No Available</option>';
			        }

                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Suspended</label>
            <div class="col-md-8">
            	<input type="checkbox" class="make-switch" name="suspended" id="suspended" data-off-text="No" data-on-text="Yes" data-on-color="warning" data-off-color="default"'; echo $row['suspended'] === "1" ? "checked" : "";  echo '>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Status</label>
            <div class="col-md-8">
            	<input type="checkbox" class="make-switch" name="status" data-on-text="Active" data-off-text="Inactive" data-on-color="success" data-off-color="danger"'; echo $row['status'] === "1" ? "checked" : "";  echo '>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label"></label>
            <div class="col-md-10">
                <label>TRAINING PROGRESS</label>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Description</th>
                                    <th>Due Date</th>
                                    <th>Document</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>';

				                $selectTrainings = mysqli_query( $conn,"SELECT * FROM tbl_hr_trainings" );
						        if ( mysqli_num_rows($selectTrainings) > 0 ) {
						        	$countTraining = 0;
							        while($rowTraining = mysqli_fetch_array($selectTrainings)) {

							        	$found = null;
										$array_row = explode(", ", $row["job_description_id"]);
										$array_rowTraining = explode(", ", $rowTraining["job_description_id"]);
										foreach($array_row as $emp_JD) {
											if (in_array($emp_JD,$array_rowTraining)) {
												$found = true;
											}
										}

										if ( $found == true ) {
								        	echo '<tr>
			                                    <td >'. $rowTraining["ID"] .'</td>
			                                    <td >'. $rowTraining["title"] .'</td>
			                                    <td >07/20/2022</td>
			                                    <td>Document Here</td>';

												$trainings_id_status = $row['trainings_id_status'];
												$trainings_id = $rowTraining["ID"];

                                                if ( !empty($trainings_id_status) ) {

													$output = json_decode($trainings_id_status,true);

													if ( array_key_exists($trainings_id, $output) ) {
														if ( $output[$trainings_id] == 1 ) {
															echo '<td><a href="#" class="status" data-type="select" data-pk="'. $row['ID'] .'" data-url="function.php?training='. $trainings_id .'" data-name="status_'. $trainings_id .'" data-value="1" data-title="Select Status">Approved</a></td>';
														} else if ( $output[$trainings_id] == 2 ) {
		                                                	echo '<td><a href="#" class="status" data-type="select" data-pk="'. $row['ID'] .'" data-url="function.php?training='. $trainings_id .'" data-name="status_'. $trainings_id .'" data-value="2" data-title="Select Status">For Approval</a></td>';
														} else {
		                                                	echo '<td><a href="#" class="status" data-type="select" data-pk="'. $row['ID'] .'" data-url="function.php?training='. $trainings_id .'" data-name="status_'. $trainings_id .'" data-value="0" data-title="Select Status">Not Yet Started</a></td>';
														}
													} else {
	                                                	echo '<td><a href="#" class="status" data-type="select" data-pk="'. $row['ID'] .'" data-url="function.php?id='. $row['ID'] .'&training='. $trainings_id .'" data-name="status_'. $trainings_id .'" data-value="0" data-title="Select Status">Not Yet Started</a></td>';
													}
                                                } else {
                                                	echo '<td><a href="#" class="status" data-type="select" data-pk="'. $row['ID'] .'" data-url="function.php?training='. $trainings_id .'" data-name="status_'. $trainings_id .'" data-value="0" data-title="Select Status">Not Yet Started</a></td>';
                                                }

			                                echo '</tr>';

			                                $countTraining++;
										}
							        }

							        if ( $countTraining < 1 ) {
							        	echo '<tr class="text-center text-default"><td colspan="5">Empty Record</td></tr>';
							        }
						        } else {
						        	echo '<tr class="text-center text-default"><td colspan="5">Empty Record</td></tr>';
						        }

                             echo '</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_GET['training']) ) {
		$trainings_id = $_GET['training'];
		$ID = $_POST['pk'];
		$status = $_POST['value'];

		$selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID='". $ID ."'" );
		if ( mysqli_num_rows($selectEmployee) > 0 ) {
            $rowEmployee = mysqli_fetch_array($selectEmployee);

            $trainings_id_status = $rowEmployee['trainings_id_status'];

            if ( !empty($trainings_id_status) ) {
            	$output = json_decode($trainings_id_status,true);
				$output[$trainings_id] = $status;
				$value = $output;
            } else {

				$value = array ( $trainings_id=>$status );
            }

            $id_status = json_encode($value); 
            mysqli_query( $conn,"UPDATE tbl_hr_employee set trainings_id_status='". $id_status ."' WHERE ID='". $ID ."'" );
        }
	}

	if( isset($_POST['btnSave_HR_Job_Description']) ) {
		$ID = $_POST['ID'];
		$title = $_POST['title'];	 
		$description = $_POST['description'];
		$department_id = $_POST['department_id'];
		$files = "";

		$success = true;
		if( !empty( $_FILES['file']['name'] ) ) {
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
			$path = 'uploads/'; // upload directory
			$file = $_FILES['file']['name'];
			$tmp = $_FILES['file']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_file = rand(1000,1000000).' - '.$file;
			// check's valid format
			// if(in_array($ext, $valid_extensions)) {
				$files = $final_file;
				$path = $path.$final_file;
				if(move_uploaded_file($tmp,$path)) {
					$success = true;
				}
			// } else {
			// 	$success = false;
			// }
		}

		if ($success == true) {

			$sql = "INSERT INTO tbl_hr_job_description (user_id, title, description, department_id, files)
			VALUES ('$ID', '$title', '$description', '$department_id', '$files')";
		
			if (mysqli_query($conn, $sql)) {

				$last_id = mysqli_insert_id($conn);
				$selectData = mysqli_query( $conn,'SELECT * FROM tbl_hr_job_description WHERE user_id="'. $ID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );
				
				if ( mysqli_num_rows($selectData) > 0 ) {
					$rowData = mysqli_fetch_array($selectData);
					$data_ID = $rowData['ID'];
					$data_title = $rowData['title'];
					$data_description = $rowData['description'];

			        $countTraining = 0;
					$selectTrainings = mysqli_query( $conn,"SELECT * FROM tbl_hr_trainings" );
			        while($rowTraining = mysqli_fetch_array($selectTrainings)) {
			            $array_jd = explode(", ", $rowTraining["job_description_id"]);
			            foreach ($array_jd as $value) {
			                if ( $value == $data_ID ) {
			                    $countTraining++;
			                }
			            }
			        }

                	$counterup_tbl = counterup_tbl('job-description');
					$output = array(
						'ID' => $data_ID,
						'title' => $title,
						'description' => $description,
						'countTraining' => $countTraining
					);

					$result = array_merge($counterup_tbl, $output);
					echo json_encode($result);
				}
			}
			mysqli_close($conn);
		}
	}

	if( isset($_POST['btnUpdate_HR_Job_Description']) ) {
		$ID = $_POST['ID'];	 
		$title = $_POST['title'];	 
		$description = $_POST['description'];
		$files = $_POST['files'];
		$status = isset($_POST['status']) ? 1 : 0;
		$status_last_modified = date('Y-m-d');

		$success = true;
		if( empty( $files ) AND !empty( $_FILES['file']['name'] ) ) {
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
			$path = 'uploads/'; // upload directory
			$file = $_FILES['file']['name'];
			$tmp = $_FILES['file']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_file = rand(1000,1000000).' - '.$file;
			// check's valid format
			// if(in_array($ext, $valid_extensions)) {
				$files = $final_file;
				$path = $path.$final_file;
				if(move_uploaded_file($tmp,$path)) {
					$success = true;
				}
			// } else {
			// 	$success = false;
			// }
		}

		if ($success == true) {
			mysqli_query( $conn,"UPDATE tbl_hr_job_description set title='". $title ."', description='". $description ."', files='". $files ."', status='". $status ."', last_modified='". $status_last_modified ."' WHERE ID='". $ID ."'" );
			
			if (!mysqli_error($conn)) {

		        $countTraining = 0;
				$selectTrainings = mysqli_query( $conn,"SELECT * FROM tbl_hr_trainings" );
		        while($rowTraining = mysqli_fetch_array($selectTrainings)) {
		            $array_jd = explode(", ", $rowTraining["job_description_id"]);
		            foreach ($array_jd as $value) {
		                if ( $value == $ID ) {
		                    $countTraining++;
		                }
		            }
		        }

                $counterup_tbl = counterup_tbl('job-description');
				$output = array(
					'ID' => $ID,
					'title' => $title,
					'description' => $description,
					'countTraining' => $countTraining,
					'status' => $status
				);

				$result = array_merge($counterup_tbl, $output);
				echo json_encode($result);
			}

			mysqli_close($conn);
		}
	}

	if( isset($_GET['modalView_HR_Job_Description']) ) {
		$ID = $_GET['modalView_HR_Job_Description'];

        $selectData = mysqli_query( $conn,"SELECT * FROM tbl_hr_job_description WHERE ID = $ID" );
        if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
            $user_id = $row['user_id'];
        }

        echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
        <input class="form-control" type="hidden" name="files" id="files" value="'. $row['files'] .'" />
        <div class="form-group">
            <label class="col-md-3 control-label">Title</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="title" value="'. $row['title'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Description</label>
            <div class="col-md-8">
                <textarea class="form-control" name="description" style="height:100px !important;" required >'. $row['description'] .'</textarea>
            </div>
        </div>
		<div class="form-group">
		    <label class="col-md-3 control-label">Document</label>
		    <div class="col-md-8">
                <input class="form-control '; echo $row['files'] === "" ? "" : "hide"; echo '" type="file" id="file" name="file" />

                <ul class="list-unstyled '; echo $row['files'] === "" ? "hide" : ""; echo '">
                    <li class="list-items">
                        <div class="list-status">
                            <a class="removeFile"><i class="fa fa-close"></i></a>
                        </div>
                        <div class="list-content">
                            <a href="uploads/'. $row['files'] .'" target="_blank" style="margin-top: 10px;">'. $row['files'] .'</a>
                        </div>
                    </li>
                </ul>
            </div>
		</div>
        <script type="text/javascript">
            $(".removeFile").click(function() {
                var document = $(this).parent().parent().parent();
                var file = document.prev().toggleClass("hide");
                $("#files").val("");
                document.hide();
            });
        </script>
        <div class="form-group">
            <label class="control-label col-md-3">Status</label>
            <div class="col-md-8">
            	<input type="checkbox" class="make-switch" name="status" data-on-text="Active" data-off-text="Inactive" data-on-color="success" data-off-color="danger"'; echo $row['status'] === "1" ? "checked" : "";  echo '>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label"></label>
            <div class="col-md-10">
                <label>REQUIRED TRAINING</label>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Document</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>';
                                
                                $selectTrainings = mysqli_query( $conn,"SELECT * FROM tbl_hr_trainings WHERE status = 1 AND user_id = $user_id" );
                                if ( mysqli_num_rows($selectTrainings) > 0 ) {
	                                $countTraining = 0;
	                                while($rowTraining = mysqli_fetch_array($selectTrainings)) {
	                                    $array_jd = explode(", ", $rowTraining["job_description_id"]);
	                                    foreach ($array_jd as $value) {
	                                        if ( $value == $row["ID"] ) {
	                                            $countTraining++;

	                                            echo '<tr>
	                                                <td>'. $rowTraining["ID"] .'</td>
	                                                <td>'. $rowTraining["title"] .'</td>
	                                                <td>'. $rowTraining["description"] .'</td>
	                                                <td>Document Here</td>';

                                                    if ( $rowTraining["status"] == 0 ) {
                                                        echo '<td><span class="label label-sm label-danger">Inactive</span></td>';
                                                    } else if ( $rowTraining["status"] == 1 ) {
                                                        echo '<td><span class="label label-sm label-success">Active</span></td>';
                                                    } else {
                                                        echo '<td><span class="label label-sm label-warning">Suspended</span></td>';
                                                    }

	                                            echo '</tr>';
	                                        }
	                                    }
	                                }

							        if ( $countTraining < 1 ) {
							        	echo '<tr class="text-center text-default"><td colspan="5">Empty Record</td></tr>';
							        }
                            	} else {
						        	echo '<tr class="text-center text-default"><td colspan="5">Empty Record</td></tr>';
						        }
                                
                            echo '</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label"></label>
            <div class="col-md-10">
                <label>QUALIFIED EMPLOYEES</label>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Employee ID#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Is in Role (Y/N)</th>
                                </tr>
                            </thead>
                            <tbody>';
                            	$countEmployee = 0;
			                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE trainings_id_status <> '' " );
			                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
			                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {

									    $rowEmployeeJD = $rowEmployee['job_description_id'];
									    $rowEmployeeTrainingStatus = $rowEmployee['trainings_id_status'];

									    // List down all require training ids base on selected JD
			                            $array_list_training_ids_for_jd = array();
			                            $countRequiredTraining = 0;
	                                    $selectTrainings = mysqli_query( $conn,"SELECT * FROM tbl_hr_trainings" );
		                                if ( mysqli_num_rows($selectTrainings) > 0 ) {
			                                while($rowTraining = mysqli_fetch_array($selectTrainings)) {
			                                    $array_jd = explode(", ", $rowTraining["job_description_id"]);
			                                    foreach ($array_jd as $value) {
			                                        if ( $value == $row["ID"] ) {
			                                        	$array_list_training_ids_for_jd[] = $rowTraining["ID"];
			                                        	$countRequiredTraining++;
			                                        }
			                                    }
			                                }
			                            }

			                            // Compare result and check if approved
			                            $countRequiredTrainingChecking = 0;
			                            $output = json_decode($rowEmployeeTrainingStatus,true);
										foreach ($array_list_training_ids_for_jd as $training_jd) {
										    if (array_key_exists($training_jd, $output)) {
										        if ( $output[$training_jd] == 1 ) {
										        	$countRequiredTrainingChecking++;
										        }
										    }
										}

										// Check if it belongs to the selected JD
										$array_employeeJD = explode(", ", $rowEmployeeJD);
										if ($countRequiredTrainingChecking > 0 AND $countRequiredTraining > 0 AND $countRequiredTrainingChecking == $countRequiredTraining) {
											echo '<tr>
			                                    <td>'. $rowEmployee["ID"] .'</td>
			                                    <td>'. $rowEmployee["first_name"] .'</td>
			                                    <td>'. $rowEmployee["last_name"] .'</td>
			                                    <td>'. $rowEmployee["email"] .'</td>';

												if (in_array($row['ID'], $array_employeeJD)) {
													echo '<td><span class="label label-sm label-success">YES</span></td>';
												} else {
													echo '<td><span class="label label-sm label-danger">NO</span></td>';
												}

											echo '</tr>';

									        $countEmployee++;
										}
			                        }

			                        if ( $countEmployee < 1 ) {
			                        	echo '<tr class="text-center text-default"><td colspan="5">Empty Record</td></tr>';
			                        }
			                    } else {
			                    	echo '<tr class="text-center text-default"><td colspan="5">Empty Record</td></tr>';
			                    }

                            echo '</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_POST['btnSave_HR_Trainings']) ) {
		$ID = $_POST['ID'];
		$title = $_POST['title'];	 
		$description = $_POST['description'];
		$job_description_id = implode(", ",$_POST['job_description_id']);
		$files = "";

		$success = true;
		if( !empty( $_FILES['file']['name'] ) ) {
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
			$path = 'uploads/'; // upload directory
			$file = $_FILES['file']['name'];
			$tmp = $_FILES['file']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_file = rand(1000,1000000).' - '.$file;
			// check's valid format
			// if(in_array($ext, $valid_extensions)) {
				$files = $final_file;
				$path = $path.$final_file;
				if(move_uploaded_file($tmp,$path)) {
					$success = true;
				}
			// } else {
			// 	$success = false;
			// }
		}

		if ($success == true) {
			$sql = "INSERT INTO tbl_hr_trainings (user_id, title, description, job_description_id, files)
			VALUES ('$ID', '$title', '$description', '$job_description_id', '$files' )";
			
			if (mysqli_query($conn, $sql)) {

				$last_id = mysqli_insert_id($conn);
				$selectData = mysqli_query( $conn,'SELECT * FROM tbl_hr_trainings WHERE user_id="'. $ID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );

				if ( mysqli_num_rows($selectData) > 0 ) {
					$rowData = mysqli_fetch_array($selectData);
					$data_ID = $rowData['ID'];
					$data_title = $rowData['title'];
					$data_description = $rowData['description'];

					$array_jd = $_POST['job_description_id'];
		            $job_title = array();
		            foreach ($array_jd as $value) {
		                $selectData = mysqli_query( $conn,"SELECT * FROM tbl_hr_job_description WHERE ID=$value " );
		                while($rowJD = mysqli_fetch_array($selectData)) {
		                    $job_title[] = $rowJD["title"];
		                }
		            }

		            $countTraining = 0;
		            $countApproved = 0;
		            $countEmployee = 0;
		            $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee" );
		            if ( mysqli_num_rows($selectEmployee) > 0 ) {
		                while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
		                    $found = null;
		                    $array_rowEmployee = explode(", ", $rowEmployee["job_description_id"]);
		                    $array_rowTraining = explode(", ", $job_description_id);
		                    foreach($array_rowEmployee as $emp_JD) {
		                        if (in_array($emp_JD,$array_rowTraining)) {
		                            $found = true;
		                        }
		                    }

		                    if ( $found == true ) {
		                        $trainings_id = $data_ID;
		                        $trainings_id_status = $rowEmployee["trainings_id_status"];
		                        $output = json_decode($trainings_id_status,true);

		                        if ( !empty($trainings_id_status) ) {
		                            if ( array_key_exists($trainings_id, $output) ) {
		                                if ( $output[$trainings_id] == 1 ) {
		                                    $countApproved++;
		                                }
		                            }
		                        }

		                        $countEmployee++;
		                    }
		                }
		            }
		            $percentage = (100 / $countEmployee) * $countApproved;
		            $compliance = strval(intval($percentage)) .'% ('.  strval(intval($countApproved)) .'/'. strval(intval($countEmployee)) .')';

                	$counterup_tbl = counterup_tbl('trainings');
					$output = array(
						'ID' => $data_ID,
						'title' => $title,
						'description' => $description,
						'job_description_id' => implode(", ",$job_title),
						'compliance' => $compliance
					);

					$result = array_merge($counterup_tbl, $output);
					echo json_encode($result);
				}
			}
			mysqli_close($conn);
		}
	}

	if( isset($_POST['btnUpdate_HR_Trainings']) ) {
		$ID = $_POST['ID'];	 
		$title = $_POST['title'];	 
		$description = $_POST['description'];
		$job_description_id = implode(", ",$_POST['job_description_id']);
		$files = $_POST['files'];
		$status = isset($_POST['status']) ? 1 : 0;
		$status_last_modified = date('Y-m-d');

		$success = true;
		if( empty( $files ) AND !empty( $_FILES['file']['name'] ) ) {
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
			$path = 'uploads/'; // upload directory
			$file = $_FILES['file']['name'];
			$tmp = $_FILES['file']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_file = rand(1000,1000000).' - '.$file;
			// check's valid format
			// if(in_array($ext, $valid_extensions)) {
				$files = $final_file;
				$path = $path.$final_file;
				if(move_uploaded_file($tmp,$path)) {
					$success = true;
				}
			// } else {
			// 	$success = false;
			// }
		}

		if ($success == true) {
			mysqli_query( $conn,"UPDATE tbl_hr_trainings set title='". $title ."', description='". $description ."', job_description_id='". $job_description_id ."', files='". $files ."', status='". $status ."', last_modified='". $status_last_modified ."' WHERE ID='". $ID ."'" );
			
			if (!mysqli_error($conn)) {

				$array_jd = $_POST['job_description_id'];
	            $job_title = array();
	            foreach ($array_jd as $value) {
	                $selectData = mysqli_query( $conn,"SELECT * FROM tbl_hr_job_description WHERE ID=$value " );
	                while($rowJD = mysqli_fetch_array($selectData)) {
	                    $job_title[] = $rowJD["title"];
	                }
	            }

	            $countTraining = 0;
	            $countApproved = 0;
	            $countEmployee = 0;
	            $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee" );
	            if ( mysqli_num_rows($selectEmployee) > 0 ) {
	                while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
	                    $found = null;
	                    $array_rowEmployee = explode(", ", $rowEmployee["job_description_id"]);
	                    $array_rowTraining = explode(", ", $job_description_id);
	                    foreach($array_rowEmployee as $emp_JD) {
	                        if (in_array($emp_JD,$array_rowTraining)) {
	                            $found = true;
	                        }
	                    }

	                    if ( $found == true ) {
	                        $trainings_id = $ID;
	                        $trainings_id_status = $rowEmployee["trainings_id_status"];
	                        $output = json_decode($trainings_id_status,true);

	                        if ( !empty($trainings_id_status) ) {
	                            if ( array_key_exists($trainings_id, $output) ) {
	                                if ( $output[$trainings_id] == 1 ) {
	                                    $countApproved++;
	                                }
	                            }
	                        }

	                        $countEmployee++;
	                    }
	                }
	            }
	            $percentage = (100 / $countEmployee) * $countApproved;
	            $compliance = strval(intval($percentage)) .'% ('.  strval(intval($countApproved)) .'/'. strval(intval($countEmployee)) .')';

                $counterup_tbl = counterup_tbl('department');
				$output = array(
					'ID' => $ID,
					'title' => $title,
					'description' => $description,
					'job_description_id' => implode(", ",$job_title),
					'compliance' => $compliance,
					'status' => $status
				);

				$result = array_merge($counterup_tbl, $output);
				echo json_encode($result);
			}

			mysqli_close($conn);
		}
	}

	if( isset($_GET['modalView_HR_Trainings']) ) {
		$id = $_GET['modalView_HR_Trainings'];

        $selectData = mysqli_query( $conn,"SELECT * FROM tbl_hr_trainings WHERE ID = $id" );
        if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
            $user_id = $row['user_id'];
        }

        echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
        <input class="form-control" type="hidden" name="files" id="files" value="'. $row['files'] .'" />
        <div class="form-group">
            <label class="col-md-3 control-label">Title</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="title" value="'. $row['title'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Description</label>
            <div class="col-md-8">
                <textarea class="form-control" name="description" style="height:100px !important;" required >'. $row['description'] .'</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Job Description</label>
            <div class="col-md-8">
                <select class="form-control" multiple name="job_description_id[]" required >';
                    
                    $array_jd = explode(", ", $row["job_description_id"]);
                    $resultJD = mysqli_query( $conn,"SELECT * FROM tbl_hr_job_description WHERE status = 1 and user_id = $user_id" );
                    if ( mysqli_num_rows($resultJD) > 0 ) {
                        while($rowJD = mysqli_fetch_array($resultJD)) {
							if (in_array($rowJD["ID"], $array_jd)) {
								echo '<option value="'. $rowJD["ID"] .'" selected>'. $rowJD["title"] .'</option>';
							} else {
								echo '<option value="'. $rowJD["ID"] .'">'. $rowJD["title"] .'</option>';
							}
                        }
                    } else {
                    	echo '<option value="" disabled>No Available</option>';
                    }
                    
                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Document</label>
            <div class="col-md-8">
                <input class="form-control '; echo $row['files'] === "" ? "" : "hide"; echo '" type="file" id="file" name="file" />

                <ul class="list-unstyled '; echo $row['files'] === "" ? "hide" : ""; echo '">
                    <li class="list-items">
                        <div class="list-status">
                            <a class="removeFile"><i class="fa fa-close"></i></a>
                        </div>
                        <div class="list-content">
                            <a href="uploads/'. $row['files'] .'" target="_blank" style="margin-top: 10px;">'. $row['files'] .'</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <script type="text/javascript">
            $(".removeFile").click(function() {
                var document = $(this).parent().parent().parent();
                var file = document.prev().toggleClass("hide");
                $("#files").val("");
                document.hide();
            });
        </script>
        <div class="form-group">
            <label class="control-label col-md-3">Status</label>
            <div class="col-md-8">
            	<input type="checkbox" class="make-switch" name="status" data-on-text="Active" data-off-text="Inactive" data-on-color="success" data-off-color="danger"'; echo $row['status'] === "1" ? "checked" : "";  echo '>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label"></label>
            <div class="col-md-10">
                <label>TRAINING PROGRESS</label>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Employee ID#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Completed(Y/N)</th>
                                </tr>
                            </thead>
                            <tbody>';

	                            $countTraining = 0;
			                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $user_id" );
			                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
			                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {


			                        	// Option 1
										// $trainings_id = $row['ID'];
										// $trainings_id_status = $rowEmployee["trainings_id_status"];
										// $output = json_decode($trainings_id_status,true);

										// if ( !empty($trainings_id_status) ) {
										// 	if ( array_key_exists($trainings_id, $output) ) {
										// 		if ( $output[$trainings_id] == 1 ) {

										// 			echo '<tr>
										// 				<td>'. $rowEmployee["ID"] .'</td>
										// 				<td>'. $rowEmployee["first_name"] .'</td>
										// 				<td>'. $rowEmployee["last_name"] .'</td>
										// 				<td>'. $rowEmployee["email"] .'</td>
										// 				<td>
										// 				<span class="label label-sm label-success">YES</span>
										// 				</td>
										// 			</tr>';
					                                
										// 			$countTraining++;
										// 		}
										// 	}
										// }

			                        	// Option 2
										$found = null;
										$array_rowEmployee = explode(", ", $rowEmployee["job_description_id"]);
										$array_rowTraining = explode(", ", $row["job_description_id"]);
										foreach($array_rowEmployee as $emp_JD) {
											if (in_array($emp_JD,$array_rowTraining)) {
												$found = true;
											}
										}

										if ( $found == true ) {
											echo '<tr>
												<td>'. $rowEmployee["ID"] .'</td>
												<td>'. $rowEmployee["first_name"] .'</td>
												<td>'. $rowEmployee["last_name"] .'</td>
												<td>'. $rowEmployee["email"] .'</td>';

												$trainings_id = $row['ID'];
												$trainings_id_status = $rowEmployee["trainings_id_status"];
												$output = json_decode($trainings_id_status,true);

												if ( !empty($trainings_id_status) ) {
													if ( array_key_exists($trainings_id, $output) ) {
														if ( $output[$trainings_id] == 1 ) {
															echo '<td><span class="label label-sm label-success">YES</span></td>';
														} else {
															echo '<td><span class="label label-sm label-danger">NO</span></td>';
														}
													} else {
														echo '<td><span class="label label-sm label-danger">NO</span></td>';
													}

												} else {
													echo '<td><span class="label label-sm label-danger">NO</span></td>';
												}

											echo '</tr>';

											$countTraining++;
										}

			                        }

			                        if ( $countTraining < 1 ) {
			                        	echo '<tr class="text-center text-default"><td colspan="5">Empty Record</td></tr>';
			                        }
			                    } else {
			                    	echo '<tr class="text-center text-default"><td colspan="5">Empty Record</td></tr>';
			                    }
                                
                            echo '</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_POST['btnSave_HR_Department']) ) {
		$ID = $_POST['ID'];
		$title = $_POST['title'];	 
		$description = $_POST['description'];
		$files = "";
		$capacity = $_POST['capacity'];

		$success = true;
		if( !empty( $_FILES['file']['name'] ) ) {
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
			$path = 'uploads/'; // upload directory
			$file = $_FILES['file']['name'];
			$tmp = $_FILES['file']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_file = rand(1000,1000000).' - '.$file;
			// check's valid format
			// if(in_array($ext, $valid_extensions)) {
				$files = $final_file;
				$path = $path.$final_file;
				if(move_uploaded_file($tmp,$path)) {
					$success = true;
				}
			// } else {
			// 	$success = false;
			// }
		}

		if ($success == true) {
			$sql = "INSERT INTO tbl_hr_department (user_id, title, description, files, capacity)
			VALUES ('$ID', '$title', '$description', '$files', '$capacity')";

			if (mysqli_query($conn, $sql)) {

				$last_id = mysqli_insert_id($conn);
				$selectData = mysqli_query( $conn,'SELECT * FROM tbl_hr_department WHERE user_id="'. $ID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );

				if ( mysqli_num_rows($selectData) > 0 ) {
					$rowData = mysqli_fetch_array($selectData);
					$data_ID = $rowData['ID'];

                	$counterup_tbl = counterup_tbl('department');
					$output = array(
						"ID" => $data_ID,
						"title" => $title,
						"description" => $description,
						"capacity" => $capacity
					);

					$result = array_merge($counterup_tbl, $output);
					echo json_encode($result);
				}
			}
			mysqli_close($conn);
		}
	}

	if( isset($_POST['btnUpdate_HR_Department']) ) {
		$ID = $_POST['ID'];	 
		$title = $_POST['title'];	 
		$description = $_POST['description'];
		$files = $_POST['files'];
		//$files = "";
		// $capacity = $_POST['capacity'];
		$capacity = 0;
		$status = isset($_POST['status']) ? 1 : 0;
		$status_last_modified = date('Y-m-d');

		$success = true;
		if( empty( $files ) AND !empty( $_FILES['file']['name'] ) ) {
		// if( !empty( $_FILES['file']['name'] ) ) {
		// if ($_FILES['file']['size'] != 0 && $_FILES['file']['error'] != 0) {
			$valid_extensions = array('ppt'); // valid extensions
			$path = 'uploads/'; // upload directory
			$file = $_FILES['file']['name'];
			$tmp = $_FILES['file']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_file = rand(1000,1000000).' - '.$file;
			// check's valid format
			// if(in_array($ext, $valid_extensions)) {
				$files = $final_file;
				$path = $path.$final_file;
				if(move_uploaded_file($tmp,$path)) {
					$success = true;
				}
			// } else {
			// 	$success = false;
			// }
		}

		if ($success == true) {
			mysqli_query( $conn,"UPDATE tbl_hr_department set title='". $title ."', description='". $description ."', files='". $files ."', capacity='". $capacity ."', status='". $status ."', last_modified='". $status_last_modified ."' WHERE ID='". $ID ."'" );
			
			if (!mysqli_error($conn)) {
				//echo "Updated!" . mysqli_error($conn);

				// $dept_id = $row["ID"];
                $countDepartment = 0;
                $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE department_id = $ID " );
                if ( mysqli_num_rows($selectEmployee) > 0 ) {
                    while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                        $countDepartment++;
                    }
                }
                // $capacityPercentage = intval( ( $countDepartment / $capacity ) * 100);
                // $compliance = $capacityPercentage .'% ('. $countDepartment .'/'.$capacity.')';

                $counterup_tbl = counterup_tbl('department');
				$output = array(
					'ID' => $ID,
					'title' => $title,
					'description' => $description,
					// 'compliance' => $compliance,
					'status' => $status
				);

				$result = array_merge($counterup_tbl, $output);
				echo json_encode($result);
			}
			mysqli_close($conn);
		}
	}

	if( isset($_GET['modalView_HR_Department']) ) {
		$id = $_GET['modalView_HR_Department'];

        $selectData = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE ID = $id" );
        if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
        }

        echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
        <input class="form-control" type="hidden" name="files" id="files" value="'. $row['files'] .'" />
        <div class="form-group">
            <label class="col-md-3 control-label">Department Name</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="title" value="'. $row['title'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Description</label>
            <div class="col-md-8">
                <textarea class="form-control" name="description" style="height:100px !important;" required >'. $row['description'] .'</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Document</label>
            <div class="col-md-8">
	            <div class="'; echo $row['files'] === "" ? "" : "hide"; echo '">
	                <input class="form-control" type="file" id="file" name="file" />
				</div>
                <ul class="list-unstyled '; echo $row['files'] === "" ? "hide" : ""; echo '">
                    <li class="list-items">
                        <div class="list-status">
                            <a class="removeFile"><i class="fa fa-close"></i></a>
                        </div>
                        <div class="list-content">
                            <a href="uploads/'. $row['files'] .'" target="_blank" style="margin-top: 10px;">'. $row['files'] .'</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <script type="text/javascript">
            $(".removeFile").click(function() {
                var document = $(this).parent().parent().parent();
                var file = document.prev().toggleClass("hide");
                $("#files").val("");
                document.hide();
            });
        </script>';
        // echo '<div class="form-group">
        //     <label class="col-md-3 control-label">Employee Capacity</label>
        //     <div class="col-md-8">';

	            // $dept_id = $row["ID"];
	            // $countDepartment = 0;
	            // $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE department_id = $dept_id " );
	            // if ( mysqli_num_rows($selectEmployee) > 0 ) {
	            //     while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
	            //         $countDepartment++;
	            //     }
	            // }

        //         echo '<input class="form-control" type="number" name="capacity" value="'. $row['capacity'] .'" min="'. $countDepartment .'" placeholder="min. of '. $countDepartment .'" required />
        //     </div>
        // </div>';
        echo '<div class="form-group">
            <label class="control-label col-md-3">Status</label>
            <div class="col-md-8">
            	<input type="checkbox" class="make-switch" name="status" data-on-text="Active" data-off-text="Inactive" data-on-color="success" data-off-color="danger"'; echo $row['status'] === "1" ? "checked" : "";  echo '>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label"></label>
            <div class="col-md-10">
                <label>EMPLOYEE</label>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Employee ID#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>';

                            	$ID = $row["ID"];
			                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE department_id = $ID" );
			                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
			                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
			                        	echo '<tr>
		                                    <td>'. $rowEmployee["ID"] .'</td>
		                                    <td>'. $rowEmployee["first_name"] .'</td>
		                                    <td>'. $rowEmployee["last_name"] .'</td>
		                                    <td>'. $rowEmployee["email"] .'</td>
		                                </tr>';
			                        }
			                    } else {
			                    	echo '<tr class="text-center text-default"><td colspan="5">Empty Record</td></tr>';
			                    }
                                
                            echo '</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_POST['btnSave_Customer']) ) { 
		$ID = $_POST['ID'];
		$emergency_count = $_POST['emergency_count'];
		$name = $_POST['name'];
		$title = $_POST['title'];
		$company_name = $_POST['company_name'];
		$address = $_POST['address'];
		$mobile = $_POST['mobile'];
		$telephone = $_POST['telephone'];
		$fax = $_POST['fax'];
		$email = $_POST['email'];
		$employee_id = $_POST['employee_id'];

		$emergency_arr = array();
		for ($i=0; $i < $emergency_count; $i++) {
			$emergency_name = $_POST['emergency'][$i]['contact_name'];
			$emergency_number = $_POST['emergency'][$i]['contact_number'];
			$emergency_data = array (
				'e_name' => $emergency_name,
				'e_number' =>$emergency_number
			);

			array_push( $emergency_arr, $emergency_data );
		}
		$emergency = json_encode($emergency_arr); 


		$sql = "INSERT INTO tbl_customer (user_id, name, title, company_name, address, mobile, telephone, fax, email, employee_id, emergency)
		VALUES ('$ID', '$name', '$title', '$company_name', '$address', '$mobile', '$telephone', '$fax', '$email', '$employee_id', '$emergency')";
		
		if (mysqli_query($conn, $sql)) {

			$last_id = mysqli_insert_id($conn);
			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_customer WHERE user_id="'. $ID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );
			if ( mysqli_num_rows($selectData) > 0 ) {
				$rowData = mysqli_fetch_array($selectData);
				$data_ID = $rowData['ID'];
				$data_name = $rowData['name'];
				$data_title = $rowData['title'];
				$data_company_name = $rowData['company_name'];
				$data_address = $rowData['address'];
				$data_mobile = $rowData['mobile'];
				$data_telephone = $rowData['telephone'];
				$data_fax = $rowData['fax'];
				$data_email = $rowData['email'];
				$data_employee_id = $rowData['employee_id'];

				$selectEmployeeData = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $data_employee_id" );
                if ( mysqli_num_rows($selectEmployeeData) > 0 ) {
                    while($rowEmployeeData = mysqli_fetch_array($selectEmployeeData)) {
                        $data_coordinator = $rowEmployeeData['first_name'] .' '. $rowEmployeeData['last_name'];
                    }
                }

            	$counterup_tbl = counterup_tbl('customer');
				$output = array(
					"ID" => $data_ID,
					"name" => $data_name,
					"title" => $data_title,
					"company_name" => $data_company_name,
					"address" => $data_address,
					"mobile" => $data_mobile,
					"telephone" => $data_telephone,
					"fax" => $data_fax,
					"email" => $data_email,
					"coordinator" => $data_coordinator
				);
				
				$result = array_merge($counterup_tbl, $output);
				echo json_encode($result);
			}
		}
		mysqli_close($conn);
	}

	if( isset($_POST['btnUpdate_Customer']) ) {
		$ID = $_POST['ID'];	 
		$emergency_count = $_POST['emergency_count'];
		$name = $_POST['name'];
		$title = $_POST['title'];
		$company_name = $_POST['company_name'];
		$address = $_POST['address'];
		$mobile = $_POST['mobile'];
		$telephone = $_POST['telephone'];
		$fax = $_POST['fax'];
		$email = $_POST['email'];
		$employee_id = $_POST['employee_id'];
		$status = isset($_POST['status']) ? 1 : 0;
		$status_last_modified = date('Y-m-d');

		$emergency_arr = array();
		for ($i=0; $i < $emergency_count; $i++) {
			$emergency_name = $_POST['emergency'][$i]['contact_name'];
			$emergency_number = $_POST['emergency'][$i]['contact_number'];
			$emergency_data = array (
				'e_name' => $emergency_name,
				'e_number' =>$emergency_number
			);

			array_push( $emergency_arr, $emergency_data );
		}
		$emergency = json_encode($emergency_arr);

		mysqli_query( $conn,"UPDATE tbl_customer set name='". $name ."', title='". $title ."', company_name='". $company_name ."', address='". $address ."', mobile='". $mobile ."', telephone='". $telephone ."', fax='". $fax ."', email='". $email ."', employee_id='". $employee_id ."', emergency='". $emergency ."', status='". $status ."', last_modified='". $status_last_modified ."' WHERE ID='". $ID ."'" );
		
		if (!mysqli_error($conn)) {

			$selectEmployeeData = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $employee_id" );
            if ( mysqli_num_rows($selectEmployeeData) > 0 ) {
                while($rowEmployeeData = mysqli_fetch_array($selectEmployeeData)) {
                    $data_coordinator = $rowEmployeeData['first_name'] .' '. $rowEmployeeData['last_name'];
                }
            }

            $counterup_tbl = counterup_tbl('customer');
			$output = array(
				'ID' => $ID,
				'name' => stripcslashes($name),
				'title' => stripcslashes($title),
				'address' => stripcslashes($address),
				'mobile' => stripcslashes($mobile),
				'telephone' => stripcslashes($telephone),
				'fax' => stripcslashes($fax),
				'email' => stripcslashes($email),
				'coordinator' => $data_coordinator,
				'status' => $status
			);

			$result = array_merge($counterup_tbl, $output);
			echo json_encode($result);
		}

		mysqli_close($conn);
	}

	if( isset($_GET['modalView_Customer']) ) {
		$id = $_GET['modalView_Customer'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_customer WHERE ID = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
			$user_id = $row['user_id'];
			$emergency = $row['emergency'];
			$output = json_decode($emergency,true);
        }

		echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
		<input class="form-control" type="hidden" name="emergency_count" value="'. count($output) .'" />
		<div class="form-group">
            <label class="col-md-3 control-label">Name</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="name" value="'. $row['name'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Title</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="title" value="'. $row['title'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Company Name</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="company_name" value="'. $row['company_name'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Address</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="address" value="'. $row['address'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Cell No.</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="mobile" value="'. $row['mobile'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Phone</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="telephone" value="'. $row['telephone'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Fax</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="fax" value="'. $row['fax'] .'"required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Email Address</label>
            <div class="col-md-8">
                <input class="form-control" type="email" name="email" value="'. $row['email'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Coordinator</label>
            <div class="col-md-8">
                <select class="form-control" name="employee_id" required >';
                    
                        $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $user_id" );
                        if ( mysqli_num_rows($selectEmployee) > 0 ) {
                            echo '<option value="">Select</option>';
                            while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                echo '<option value="'. $rowEmployee["ID"] .'" '; if ($rowEmployee['ID'] == $row['employee_id']) { echo 'selected'; } echo '>'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                            }
                        } else {
                            echo '<option disabled>No Available</option>';
                        }
                    
                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Emergency Contact</label>
            <div class="col-md-8">
                <div class="mt-repeater">
                    <div data-repeater-list="emergency">';

				        foreach ($output as $key => $value) {
				        	echo '<div class="mt-repeater-item row" data-repeater-item>
	                            <div class="col-md-6">
	                                <input class="form-control" type="text" name="contact_name" placeholder="Name" value="'. $value['e_name']  .'" required />
	                            </div>
	                            <div class="col-md-4">
	                                <input class="form-control" type="text" name="contact_number" placeholder="Contact Number" value="'. $value['e_number']  .'" required />
	                            </div>
	                            <div class="col-md-2">
	                                <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
	                            </div>
	                        </div>';
				        }
                        
                    echo '</div>
                    <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add btnEmergency" onClick="addEmergency()"><i class="fa fa-plus"></i> Add new contact number</a>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">Status</label>
            <div class="col-md-8">
            	<input type="checkbox" class="make-switch" name="status" data-on-text="Active" data-off-text="Inactive" data-on-color="success" data-off-color="danger"'; echo $row['status'] === "1" ? "checked" : "";  echo '>
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_GET['modalCoordinator']) ) {
		$id = $_GET['modalCoordinator'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
            $user_id = $row['user_id'];
        }

		echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
        <div class="form-group">
            <label class="col-md-3 control-label">Email Address</label>
            <div class="col-md-8">
                <input class="form-control" type="email" name="email" value="'. $row['email'] .'" readonly />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">First Name</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="first_name" value="'. $row['first_name'] .'" readonly />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Last Name</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="last_name" value="'. $row['last_name'] .'" readonly />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Type</label>
            <div class="col-md-8">
                <select class="form-control" name="type_id" disabled >
                    <option value="">Select</option>
                    <option value="1" '; if ($row['type_id'] == 1) { echo 'selected'; } echo '>Full-time</option>
                    <option value="2" '; if ($row['type_id'] == 2) { echo 'selected'; } echo '>Part-time</option>
                    <option value="3" '; if ($row['type_id'] == 3) { echo 'selected'; } echo '>OJT</option>
                    <option value="4" '; if ($row['type_id'] == 4) { echo 'selected'; } echo '>Freelance</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">ID Number</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="id_number" id="id_number" value="'. $row['id_number'] .'" readonly />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Date Hired</label>
            <div class="col-md-8">
                <input class="form-control" type="date" name="date_hired" id="date_hired" value="'. $row['date_hired'] .'" readonly />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Department</label>
            <div class="col-md-8">
                <select class="form-control" name="department_id" disabled >';

	                $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE status = 1 AND user_id = $user_id" );
			        if ( mysqli_num_rows($selectDepartment) > 0 ) {
			        	echo '<option value="">Select</option>';
				        while($rowDepartment = mysqli_fetch_array($selectDepartment)) {
				        	if ( $rowDepartment["ID"] === $row["department_id"] ) {
				        		echo '<option value="'. $rowDepartment["ID"] .'" selected>'. $rowDepartment["title"] .'</option>';
				        	} else {
				        		echo '<option value="'. $rowDepartment["ID"] .'">'. $rowDepartment["title"] .'</option>';
				        	}
				        }
			        } else {
			        	echo '<option disabled>No Available</option>';
			        }

                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Job Description</label>
            <div class="col-md-8">
                <select multiple class="form-control" name="job_description_id[]" disabled >';

                	$array_Job = explode(", ", $row["job_description_id"]);
                    $resultJob = mysqli_query( $conn,"SELECT * FROM tbl_hr_job_description WHERE status = 1 AND user_id = $user_id" );
                    if ( mysqli_num_rows($resultJob) > 0 ) {
                        while($rowJob = mysqli_fetch_array($resultJob)) {
							if (in_array($rowJob["ID"], $array_Job)) {
								echo '<option value="'. $rowJob["ID"] .'" selected>'. $rowJob["title"] .'</option>';
							} else {
								echo '<option value="'. $rowJob["ID"] .'">'. $rowJob["title"] .'</option>';
							}
                        }
                    } else {
                    	echo '<option value="" disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Reporting To</label>
            <div class="col-md-8">
                <select class="form-control" name="reporting_to_id" disabled >';

	                $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $user_id" );
			        if ( mysqli_num_rows($selectEmployee) > 0 ) {
			        	echo '<option value="">Select</option>';
				        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
				        	if ( $rowEmployee["ID"] === $row["reporting_to_id"] ) {
				        		echo '<option value="'. $rowEmployee["ID"] .'" selected>'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
				        	} else {
				        		echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
				        	}
				        }
			        } else {
			        	echo '<option disabled>No Available</option>';
			        }

                echo '</select>
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_POST['btnSave_Supplier']) ) { 
		$ID = $_POST['ID'];
		$name = $_POST['name'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$fax = $_POST['fax'];
		$email = $_POST['email'];
		$website = $_POST['website'];
		$type = $_POST['type'];

		$sql = "INSERT INTO tbl_supplier (user_id, name, address, phone, fax, email, website, type)
		VALUES ('$ID', '$name', '$address', '$phone', '$fax', '$email', '$website', '$type')";
		
		if (mysqli_query($conn, $sql)) {

			$last_id = mysqli_insert_id($conn);
			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_supplier WHERE user_id="'. $ID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );
			if ( mysqli_num_rows($selectData) > 0 ) {
				$rowData = mysqli_fetch_array($selectData);
				$data_ID = $rowData['ID'];
				$data_name = $rowData['name'];
				$data_address = $rowData['address'];
				$data_phone = $rowData['phone'];
				$data_fax = $rowData['fax'];
				$data_email = $rowData['email'];
				$data_website = $rowData['website'];
				$data_type = $rowData['type'];

            	$counterup_tbl = counterup_tbl('supplier');
				$output = array(
					"ID" => $data_ID,
					"name" => $data_name,
					"address" => $data_address,
					"phone" => $data_phone,
					"fax" => $data_fax,
					"email" => $data_email,
					"website" => $data_website,
					"type" => $data_type
				);
				
				$result = array_merge($counterup_tbl, $output);
				echo json_encode($result);
			}
		}
		mysqli_close($conn);
	}

	if( isset($_POST['btnUpdate_Supplier']) ) {
		$ID = $_POST['ID'];
		$name = $_POST['name'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$fax = $_POST['fax'];
		$email = $_POST['email'];
		$website = $_POST['website'];
		$type = $_POST['type'];
		$status = isset($_POST['status']) ? 1 : 0;
		$status_last_modified = date('Y-m-d');

		mysqli_query( $conn,"UPDATE tbl_supplier set name='". $name ."', address='". $address ."', phone='". $phone ."', fax='". $fax ."', email='". $email ."', website='". $website ."', type='". $type ."', email='". $email ."', status='". $status ."', last_modified='". $status_last_modified ."' WHERE ID='". $ID ."'" );
		
		if (!mysqli_error($conn)) {

            $counterup_tbl = counterup_tbl('supplier');
			$output = array(
				'ID' => $ID,
				'name' => $name,
				'address' => $address,
				'phone' => $phone,
				'fax' => $fax,
				'email' => $email,
				'website' => $website,
				'type' => $type,
				'status' => $status
			);

			$result = array_merge($counterup_tbl, $output);
			echo json_encode($result);
		}

		mysqli_close($conn);
	}

	if( isset($_GET['modalView_Supplier']) ) {
		$id = $_GET['modalView_Supplier'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE ID = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
        }

		echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
        <div class="form-group">
            <label class="col-md-3 control-label">Supplier Name</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="name" value="'. $row['name'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Address</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="address" value="'. $row['address'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Phone</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="phone" value="'. $row['phone'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Fax</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="fax" value="'. $row['fax'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Email</label>
            <div class="col-md-8">
                <input class="form-control" type="email" name="email" value="'. $row['email'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Website</label>
            <div class="col-md-8">
                <input class="form-control" type="url" name="website" value="'. $row['website'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Type</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="type" value="'. $row['type'] .'" required />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">Status</label>
            <div class="col-md-8">
            	<input type="checkbox" class="make-switch" name="status" data-on-text="Active" data-off-text="Inactive" data-on-color="success" data-off-color="danger"'; echo $row['status'] === "1" ? "checked" : "";  echo '>
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_POST['btnSave_RD']) ) { 
		$ID = $_POST['ID'];
		$name = $_POST['name'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$fax = $_POST['fax'];
		$email = $_POST['email'];
		$website = $_POST['website'];
		$type = $_POST['type'];

		$sql = "INSERT INTO tbl_supplier (user_id, name, address, phone, fax, email, website, type)
		VALUES ('$ID', '$name', '$address', '$phone', '$fax', '$email', '$website', '$type')";
		
		if (mysqli_query($conn, $sql)) {

			$last_id = mysqli_insert_id($conn);
			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_supplier WHERE user_id="'. $ID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );
			if ( mysqli_num_rows($selectData) > 0 ) {
				$rowData = mysqli_fetch_array($selectData);
				$data_ID = $rowData['ID'];
				$data_name = $rowData['name'];
				$data_address = $rowData['address'];
				$data_phone = $rowData['phone'];
				$data_fax = $rowData['fax'];
				$data_email = $rowData['email'];
				$data_website = $rowData['website'];
				$data_type = $rowData['type'];

            	$counterup_tbl = counterup_tbl('supplier');
				$output = array(
					"ID" => $data_ID,
					"name" => $data_name,
					"address" => $data_address,
					"phone" => $data_phone,
					"fax" => $data_fax,
					"email" => $data_email,
					"website" => $data_website,
					"type" => $data_type
				);
				
				$result = array_merge($counterup_tbl, $output);
				echo json_encode($result);
			}
		}
		mysqli_close($conn);
	}

	if( isset($_POST['btnUpdate_RD']) ) {
		$ID = $_POST['ID'];
		$name = $_POST['name'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$fax = $_POST['fax'];
		$email = $_POST['email'];
		$website = $_POST['website'];
		$type = $_POST['type'];
		$status = isset($_POST['status']) ? 1 : 0;
		$status_last_modified = date('Y-m-d');

		mysqli_query( $conn,"UPDATE tbl_supplier set name='". $name ."', address='". $address ."', phone='". $phone ."', fax='". $fax ."', email='". $email ."', website='". $website ."', type='". $type ."', email='". $email ."', status='". $status ."', last_modified='". $status_last_modified ."' WHERE ID='". $ID ."'" );
		
		if (!mysqli_error($conn)) {

            $counterup_tbl = counterup_tbl('supplier');
			$output = array(
				'ID' => $ID,
				'name' => $name,
				'address' => $address,
				'phone' => $phone,
				'fax' => $fax,
				'email' => $email,
				'website' => $website,
				'type' => $type,
				'status' => $status
			);

			$result = array_merge($counterup_tbl, $output);
			echo json_encode($result);
		}

		mysqli_close($conn);
	}

	if( isset($_GET['modalView_RD']) ) {
		$id = $_GET['modalView_Supplier'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE ID = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
        }

		echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
        <div class="form-group">
            <label class="col-md-3 control-label">Supplier Name</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="name" value="'. $row['name'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Address</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="address" value="'. $row['address'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Phone</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="phone" value="'. $row['phone'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Fax</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="fax" value="'. $row['fax'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Email</label>
            <div class="col-md-8">
                <input class="form-control" type="email" name="email" value="'. $row['email'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Website</label>
            <div class="col-md-8">
                <input class="form-control" type="url" name="website" value="'. $row['website'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Type</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="type" value="'. $row['type'] .'" required />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">Status</label>
            <div class="col-md-8">
            	<input type="checkbox" class="make-switch" name="status" data-on-text="Active" data-off-text="Inactive" data-on-color="success" data-off-color="danger"'; echo $row['status'] === "1" ? "checked" : "";  echo '>
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_POST['btnSave_Services']) ) {
		$ID = $_POST['ID'];
		$category = addslashes($_POST['category']);
		$title = addslashes($_POST['title']);
		$description = addslashes($_POST['description']);
		$contact = addslashes($_POST['contact']);
		$email = addslashes($_POST['email']);
		$due_date = $_POST['due_date'];
		$files = "";

		$success = true;
		if( !empty( $_FILES['file']['name'] ) ) {
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
			$path = 'uploads/services/'; // upload directory
			$file = $_FILES['file']['name'];
			$tmp = $_FILES['file']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_file = rand(1000,1000000).' - '.$file;
			// check's valid format
			// if(in_array($ext, $valid_extensions)) {
				$files = $final_file;
				$path = $path.$final_file;
				if(move_uploaded_file($tmp,$path)) {
					$success = true;
				}
			// } else {
			// 	$success = false;
			// }
		}

		if ($success == true) {
			$sql = "INSERT INTO tbl_services (user_id, category, title, description, files, contact, email, due_date)
			VALUES ('$ID', '$category','$title', '$description', '$files', '$contact', '$email', '$due_date')";
			
			if (mysqli_query($conn, $sql)) {

				$to = 'greeggimongala@gmail.com';
				$user = 'Interlink IQ';
				$subject = 'New Service';
				$body = 'Please check your Service Dashboard';

				$mail = php_mailer($to, $user, $subject, $body);

				$last_id = mysqli_insert_id($conn);
				$selectData = mysqli_query( $conn,'SELECT * FROM tbl_services WHERE user_id="'. $ID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );
				if ( mysqli_num_rows($selectData) > 0 ) {
					$rowData = mysqli_fetch_array($selectData);
					$data_ID = $rowData['ID'];
					$data_title = $rowData['title'];
					$data_description = $rowData['description'];
					$data_files = $rowData['files'];
					$data_contact = $rowData['contact'];
					$data_email = $rowData['email'];
					$data_due_date = $rowData['due_date'];

	            	$counterup_tbl = counterup_tbl('supplier');
					$output = array(
						"ID" => $data_ID,
						"title" => $data_title,
						"description" => $data_description,
						"files" => $data_files,
						"contact" => $data_contact,
						"email" => $data_email,
						"due_date" => $data_due_date
					);

					echo json_encode($output);
				}
			}
			mysqli_close($conn);
		}
	}

	if( isset($_GET['btnDone']) ) {
		$id = $_GET['btnDone'];
		$last_modified = date('Y-m-d');

		mysqli_query( $conn,"UPDATE tbl_services set status=1, last_modified='".$last_modified."' WHERE ID=$id" );
		if (!mysqli_error($conn)) {
			$selectData = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE ID = $id" );
			if ( mysqli_num_rows($selectData) > 0 ) {
	            $row = mysqli_fetch_array($selectData);
	            $title = $row['title'];
	            $description = $row['description'];
	            $files = $row['files'];
	            $contact = $row['contact'];
	            $email = $row['email'];
	            $due_date = $row['due_date'];
	            $last_modified = $row['last_modified'];
	        }
	        
			$output = array(
				'ID' => $id,
				'title' => $title,
				'description' => $description,
				'files' => $files,
				'contact' => $contact,
				'email' => $email,
				'due_date' => $due_date,
				'last_modified' => $last_modified
			);
			echo json_encode($output);
		}
	}

	if( isset($_POST['btnUpdate_Service']) ) {
		$ID = $_POST['ID'];
		// $title = $_POST['title'];
		// $description = $_POST['description'];
		// $contact = $_POST['contact'];
		// $email = $_POST['email'];
		// $due_date = $_POST['due_date'];

		$assigned_to_id = $_POST['assigned_to_id'];
		$last_modified = date('Y-m-d');

		mysqli_query( $conn,"UPDATE tbl_services set assigned_to_id='". $assigned_to_id ."', last_modified='". $last_modified ."' WHERE ID='". $ID ."'" );
		
		if (!mysqli_error($conn)) {
			$selectData = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE ID = $ID" );
			if ( mysqli_num_rows($selectData) > 0 ) {
	            $row = mysqli_fetch_array($selectData);
	            $title = $row['title'];
	            $description = $row['description'];
	            $files = $row['files'];
	            $contact = $row['contact'];
	            $email = $row['email'];
	            $due_date = $row['due_date'];
	            $last_modified = $row['last_modified'];
	        }

			$output = array(
				'ID' => $ID,
				'title' => $title,
				'description' => $description,
				'files' => $files,
				'contact' => $contact,
				'email' => $email,
				'due_date' => $due_date,
				'last_modified' => $last_modified
			);
			echo json_encode($output);
		}

		mysqli_close($conn);
	}

	if( isset($_GET['modalView_Services']) ) {
		$id = $_GET['modalView_Services'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE ID = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
        }

        echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
        <div class="form-group">
            <label class="col-md-3 control-label">Title</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="title" value="'. $row['title'] .'" required readonly />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Description</label>
            <div class="col-md-8">
                <textarea class="form-control" name="description" required readonly>'. $row['description'] .'</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Contact Number</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="contact" value="'. $row['contact'] .'" required readonly />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Email</label>
            <div class="col-md-8">
                <input class="form-control" type="email" name="email" value="'. $row['email'] .'" required readonly />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Attached File</label>
            <div class="col-md-8">
                <label control-label" style="padding-top: 7px;"><a href="uploads/services/'. $row['files'] .'" target="_blank">'. $row['files'] .'</a></label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Due Date</label>
            <div class="col-md-8">
                <input class="form-control" type="date" name="due_date" min="'. date("Y-m-d") .'" value="'. $row['due_date'] .'" required readonly />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Assigned To</label>
            <div class="col-md-8">
                <select class="form-control mt-multiselect btn btn-default" name="assigned_to_id" required>';
                    
                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                            echo '<option value="'. $rowEmployee["ID"] .'" '; echo $rowEmployee["ID"] === $row['assigned_to_id'] ? 'SELECTED' : ''; echo '>'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        }
                    } else {
                        echo '<option disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_POST['btnSave_Products']) ) {
		$ID = $_POST['ID'];
		$name = addslashes($_POST['name']);
		$description = addslashes($_POST['description']);
		$files = "";

		$success = true;
		if( !empty( $_FILES['file']['name'] ) ) {
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
			$path = 'uploads/products/'; // upload directory
			$file = $_FILES['file']['name'];
			$tmp = $_FILES['file']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_file = rand(1000,1000000).' - '.$file;
			// check's valid format
			// if(in_array($ext, $valid_extensions)) {
				$files = $final_file;
				$path = $path.$final_file;
				if(move_uploaded_file($tmp,$path)) {
					$success = true;
				}
			// } else {
			// 	$success = false;
			// }
		}

		if ($success == true) {
			$sql = "INSERT INTO tbl_products (user_id, name, description, files)
			VALUES ('$ID', '$name', '$description', '$files')";

			if (mysqli_query($conn, $sql)) {

				$last_id = mysqli_insert_id($conn);
				$selectData = mysqli_query( $conn,'SELECT * FROM tbl_products WHERE user_id="'. $ID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );

				if ( mysqli_num_rows($selectData) > 0 ) {
					$rowData = mysqli_fetch_array($selectData);
					$data_ID = $rowData['ID'];
					$data_files = $rowData['files'];
					$data_last_modified = $rowData['last_modified'];

					$output = array(
						"ID" => $data_ID,
						"name" => stripcslashes($name),
						"description" => stripcslashes($description),
						"files" => $data_files,
						"last_modified" => $data_last_modified
					);
					echo json_encode($output);
				}
			}
			mysqli_close($conn);
		}
	}

	if( isset($_GET['btnDelete_Products']) ) {
		$id = $_GET['btnDelete_Products'];
		$last_modified = date('Y-m-d');

		mysqli_query( $conn,"UPDATE tbl_products set deleted=1, last_modified='".$last_modified."' WHERE ID=$id" );
		if (!mysqli_error($conn)) {
				        
			$output = array(
				'ID' => $id
			);
			echo json_encode($output);
		}
	}

	if( isset($_GET['modalView_Products']) ) {
		$id = $_GET['modalView_Products'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_products WHERE ID = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
        }

        echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
        <div class="form-group">
            <label class="col-md-3 control-label">Product Name</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="name" value="'. $row['name'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Description</label>
            <div class="col-md-8">
                <textarea class="form-control" name="description" required>'. $row['description'] .'</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Attached Picture</label>
            <div class="col-md-8">
                <input class="form-control" type="file" name="file" />
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_POST['btnUpdate_Products']) ) {
		$ID = $_POST['ID'];
		$name = addslashes($_POST['name']);
		$description = addslashes($_POST['description']);
		$last_modified = date('Y-m-d');
		$files = "";

		$success = true;
		if( !empty( $_FILES['file']['name'] ) ) {
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
			$path = 'uploads/products/'; // upload directory
			$file = $_FILES['file']['name'];
			$tmp = $_FILES['file']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_file = rand(1000,1000000).' - '.$file;
			// check's valid format
			// if(in_array($ext, $valid_extensions)) {
				$files = $final_file;
				$path = $path.$final_file;
				if(move_uploaded_file($tmp,$path)) {
					$success = true;
				}
			// } else {
			// 	$success = false;
			// }
		}

		if ($success == true) {
			if (!empty($files)) {
				mysqli_query( $conn,"UPDATE tbl_products set name='". $name ."', description='". $description ."', files='". $files ."', last_modified='". $last_modified ."' WHERE ID='". $ID ."'" );
			} else {
				mysqli_query( $conn,"UPDATE tbl_products set name='". $name ."', description='". $description ."', last_modified='". $last_modified ."' WHERE ID='". $ID ."'" );
			}
		
			if (!mysqli_error($conn)) {
				$selectData = mysqli_query( $conn,"SELECT * FROM tbl_products WHERE ID = $ID" );
				if ( mysqli_num_rows($selectData) > 0 ) {
		            $row = mysqli_fetch_array($selectData);
		            $data_name = $row['name'];
		            $data_description = $row['description'];
		            $data_files = $row['files'];
		            $data_last_modified = $row['last_modified'];
		        }

				$output = array(
					'ID' => $ID,
					'name' => $data_name,
					'description' => $data_description,
					'files' => $data_files,
					'last_modified' => $last_modified
				);
				echo json_encode($output);
			}

		}
		mysqli_close($conn);
	}

	if( isset($_GET['counterup']) ) {
		$page = $_GET['counterup'];

		echo json_encode(counterup_tbl($page));
	}

	function counterup_tbl($page){
		global $conn;
		global $current_userID;

		$statusActive = 0;
        $statusInactive = 0;
        $statusInactiveMonth = 0;
        $statusNotYetPerform = 0;
        $statusNoEmployee = 0;
        $statusNoTraining = 0;
        $statusFiles = 0;
        $statusTotal = 0;

        if ($page === "department") {
			$user_id = $_COOKIE['ID'];
	        $selectedDepartmentCounter = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE user_id = $user_id" );
	        if ( mysqli_num_rows($selectedDepartmentCounter) > 0 ) {
	            while($rowDepartmentCounter = mysqli_fetch_array($selectedDepartmentCounter)) {
	                $files = $rowDepartmentCounter["files"];
	                $status = $rowDepartmentCounter["status"];
	                $statusID = $rowDepartmentCounter["ID"];

	                if ( $status == 0 ) { $statusInactive++; }
	                else if ( $status == 1 ) { $statusActive++; }
	                $statusTotal++;

	                if ( $files === "" ) { $statusFiles++; }

	                // $selectEmployeeCounter = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE trainings_id_status <> '' " );
	                $selectEmployeeCounter = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee " );
	                if ( mysqli_num_rows($selectEmployeeCounter) > 0 ) {
	                    $countDepartmentChecking = 0;
	                    while($rowEmployeeCounter = mysqli_fetch_array($selectEmployeeCounter)) {
	                        $rowEmployeeDepartment = $rowEmployeeCounter['department_id'];
	                        if ($rowEmployeeDepartment == $statusID) {
	                            $countDepartmentChecking++;
	                        }
	                    }

	                    if ($countDepartmentChecking > 0) {
	                        $statusNotYetPerform++;
	                    }
	                } else {
	                    $statusNotYetPerform++;
	                }
	            }
	        }
		} else if ($page === "trainings") {
			$user_id = $_COOKIE['ID'];
            $selectTrainingCounter = mysqli_query( $conn,"SELECT * FROM tbl_hr_trainings WHERE user_id = $user_id" );
            if ( mysqli_num_rows($selectTrainingCounter) > 0 ) {
                while($rowTrainingCounter = mysqli_fetch_array($selectTrainingCounter)) {
                    $files = $rowTrainingCounter["files"];
                    $status = $rowTrainingCounter["status"];
                    $statusID = $rowTrainingCounter["ID"];

                    if ( $status == 0 ) { $statusInactive++; }
                    else if ( $status == 1 ) { $statusActive++; }
                    $statusTotal++;

                    if ( $files === "" ) { $statusFiles++; }

                    $selectEmployeeCounter = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE trainings_id_status <> '' " );
                    if ( mysqli_num_rows($selectEmployeeCounter) > 0 ) {
                        $countRequiredTrainingChecking = 0;
                        while($rowEmployeeCounter = mysqli_fetch_array($selectEmployeeCounter)) {
                            $rowEmployeeTrainingStatus = $rowEmployeeCounter['trainings_id_status'];
                            $output = json_decode($rowEmployeeTrainingStatus,true);
                            if (array_key_exists($statusID, $output)) {
                                if ( $output[$statusID] == 0 ) {
                                    $countRequiredTrainingChecking++;
                                }
                            } else {
                                 $countRequiredTrainingChecking++;
                            }
                        }

                        if ($countRequiredTrainingChecking > 0) {
                            $statusNotYetPerform++;
                        }
                    } else {
                        $statusNotYetPerform++;
                    }
                }
            }
		} else if ($page === "job-description") {
			$user_id = $_COOKIE['ID'];
            $selectJDCounter = mysqli_query( $conn,"SELECT * FROM tbl_hr_job_description WHERE user_id = $user_id" );
            if ( mysqli_num_rows($selectJDCounter) > 0 ) {
                while($rowJDCounter = mysqli_fetch_array($selectJDCounter)) {
                    $status = $rowJDCounter["status"];

                    if ( $status == 0 ) { $statusInactive++; }
                    else if ( $status == 1 ) { $statusActive++; }
                    $statusTotal++;


                    // TOTAL JOB DESC. W/NO TRAINING
                    $HasTrainings = false;
                    $selectTrainingsCounter = mysqli_query( $conn,"SELECT * FROM tbl_hr_trainings" );
                    while($rowTrainingCounter = mysqli_fetch_array($selectTrainingsCounter)) {
                        $array_jd_counter = explode(", ", $rowTrainingCounter["job_description_id"]);
                        foreach ($array_jd_counter as $value) {
                            if ( $value == $rowJDCounter["ID"] ) {
                                $HasTrainings = true;
                            }
                        }
                    }
                    if ( $HasTrainings == false ) { $statusNoTraining++; }

                    // TOTAL JOB DESC. W/NO EMPLOYEE
                    $HasEmployee = false;
                    // $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE trainings_id_status <> '' " );
                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {

                            $rowEmployeeJD = $rowEmployee['job_description_id'];


                            $array_employeeJD = explode(", ", $rowEmployeeJD);
                            if (in_array($rowJDCounter['ID'], $array_employeeJD)) {
                                $HasEmployee = true;
                            }
                        }
                    }

                    if ( $HasEmployee == false ) {
                        $statusNoEmployee++;
                    }
                }
            }
		} else if ($page === "employee") {
			$user_id = $_COOKIE['ID'];
            $selectEmployeeCounter = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE user_id = $user_id" );
            if ( mysqli_num_rows($selectEmployeeCounter) > 0 ) {
                while($rowEmployeeCounter = mysqli_fetch_array($selectEmployeeCounter)) {
                    $suspended = $rowEmployeeCounter["suspended"];
                    $status = $rowEmployeeCounter["status"];

                    if ($suspended != 1) {
                        if ( $status == 0 ) { $statusInactive++; }
                        else if ( $status == 1 ) { $statusActive++; }
                    }
                    $statusTotal++;
                }
            }

            $selectEmployeeMonthCounter = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE last_modified>=DATE_SUB( CURDATE(), INTERVAL 1 MONTH ) AND status = 0 AND user_id = $user_id" );
            if ( mysqli_num_rows($selectEmployeeMonthCounter) > 0 ) {
                while($rowEmployeeCounter = mysqli_fetch_array($selectEmployeeMonthCounter)) {
                    $statusInactiveMonth++;
                }
            }
		} else if ($page === "customer") {
            $selectCustomerCounter = mysqli_query( $conn,"SELECT * FROM tbl_customer" );
            if ( mysqli_num_rows($selectCustomerCounter) > 0 ) {
                while($rowCustomerCounter = mysqli_fetch_array($selectCustomerCounter)) {
                    $status = $rowCustomerCounter["status"];

                    if ( $status == 0 ) { $statusInactive++; }
                    else if ( $status == 1 ) { $statusActive++; }
                    $statusTotal++;
                }
            }

            $selectCustomerMonthCounter = mysqli_query( $conn,"SELECT * FROM tbl_customer WHERE last_modified>=DATE_SUB( CURDATE(), INTERVAL 1 MONTH ) AND status = 0" );
            if ( mysqli_num_rows($selectCustomerMonthCounter) > 0 ) {
                while($rowCustomerMonthCounter = mysqli_fetch_array($selectCustomerMonthCounter)) {
                    $statusInactiveMonth++;
                }
            }
		} else if ($page === "supplier") {
            $selectSupplierCounter = mysqli_query( $conn,"SELECT * FROM tbl_supplier" );
            if ( mysqli_num_rows($selectSupplierCounter) > 0 ) {
                while($rowSupplierCounter = mysqli_fetch_array($selectSupplierCounter)) {
                    $status = $rowSupplierCounter["status"];

                    if ( $status == 0 ) { $statusInactive++; }
                    else if ( $status == 1 ) { $statusActive++; }
                    $statusTotal++;
                }
            }

            $selectSupplierMonthCounter = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE last_modified>=DATE_SUB( CURDATE(), INTERVAL 1 MONTH ) AND status = 0" );
            if ( mysqli_num_rows($selectSupplierMonthCounter) > 0 ) {
                while($rowSupplierMonthCounter = mysqli_fetch_array($selectSupplierMonthCounter)) {
                    $statusInactiveMonth++;
                }
            }
		} else if ($page === "rd") {
            $selectSupplierCounter = mysqli_query( $conn,"SELECT * FROM tbl_rd" );
            if ( mysqli_num_rows($selectSupplierCounter) > 0 ) {
                while($rowSupplierCounter = mysqli_fetch_array($selectSupplierCounter)) {
                    $status = $rowSupplierCounter["status"];

                    if ( $status == 0 ) { $statusInactive++; }
                    else if ( $status == 1 ) { $statusActive++; }
                    $statusTotal++;
                }
            }

            $selectSupplierMonthCounter = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE last_modified>=DATE_SUB( CURDATE(), INTERVAL 1 MONTH ) AND status = 0" );
            if ( mysqli_num_rows($selectSupplierMonthCounter) > 0 ) {
                while($rowSupplierMonthCounter = mysqli_fetch_array($selectSupplierMonthCounter)) {
                    $statusInactiveMonth++;
                }
            }
		}

        //Error catching
        if ($statusTotal == 0) {
            $statusTotal = 100;
        }

		$output = array(
			'statusActive' => $statusActive,
			'statusInactive' => $statusInactive,
			'statusInactiveMonth' => $statusInactiveMonth,
			'statusNotYetPerform' => $statusNotYetPerform,
			'statusNoEmployee' => $statusNoEmployee,
			'statusNoTraining' => $statusNoTraining,
			'statusFiles' => $statusFiles,
			'statusTotal' => $statusTotal
		);
		return $output;
	}



	if( isset($_POST['btnSave_userInfo']) ) {
		$ID = $_POST['ID'];	 
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$mobile = $_POST['mobile'];
		$interest = $_POST['interest'];
		$occupation = $_POST['occupation'];
		$about = $_POST['about'];
		$website = $_POST['website'];
		$message = "Error";


		mysqli_query( $conn,"UPDATE tbl_user set first_name='". $first_name ."', last_name='". $last_name ."' WHERE ID='". $ID ."'" );

		$selectData = mysqli_query( $conn,'SELECT * FROM tbl_user_info WHERE user_id="'. $ID .'"' );
		if ( mysqli_num_rows($selectData) > 0 ) {
			$rowData = mysqli_fetch_array($selectData);
			$data_ID = $rowData['ID'];

			mysqli_query( $conn,"UPDATE tbl_user_info set mobile='". $mobile ."', interest='". $interest ."', occupation='". $occupation ."', about='". $about ."', website='". $website ."' WHERE ID='". $data_ID ."'" );
			$message = "Success";
		} else {
			$sql = "INSERT INTO tbl_user_info (user_id, mobile, interest, occupation, about, website)
			VALUES ('$ID', '$mobile', '$interest', '$occupation', '$about', '$website')";

			if (mysqli_query($conn, $sql)) {
				$message = "Success";
			}
		}
		
		$output = array(
			'ID' => $ID,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'mobile' => $mobile,
			'interest' => $interest,
			'occupation' => $occupation,
			'about' => $about,
			'website' => $website
		);
		echo json_encode($output);
		mysqli_close($conn);
	}

	if( isset($_POST['btnSave_userSocial']) ) {
		$ID = $_POST['ID'];
		$linkedin = $_POST['linkedin'];
		$facebook = $_POST['facebook'];
		$message = "Error";

		$selectData = mysqli_query( $conn,'SELECT * FROM tbl_user_social_media WHERE user_id="'. $ID .'"' );
		if ( mysqli_num_rows($selectData) > 0 ) {
			$rowData = mysqli_fetch_array($selectData);
			$data_ID = $rowData['ID'];

			mysqli_query( $conn,"UPDATE tbl_user_social_media set linkedin='". $linkedin ."', facebook='". $facebook ."' WHERE ID='". $data_ID ."'" );
			$message = "Success";
		} else {
			$sql = "INSERT INTO tbl_user_social_media (user_id, linkedin, facebook)
			VALUES ('$ID', '$linkedin', '$facebook')";

			if (mysqli_query($conn, $sql)) {
				$message = "Success";
			}
		}

		$output = array(
			'linkedin' => $linkedin,
			'facebook' => $facebook
		);
		echo json_encode($output);
		mysqli_close($conn);
	}

	if( isset($_POST['btnSave_userAvatar']) ) {
		$ID = $_POST['ID'];	 
		$files = "";
		$success = true;
		$message = "Error";

		if( !empty( $_FILES['file']['name'] ) ) {
			$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
			$path = 'uploads/avatar/'; // upload directory
			$file = $_FILES['file']['name'];
			$tmp = $_FILES['file']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_file = rand(1000,1000000).' - '.$file;
			// check's valid format
			// if(in_array($ext, $valid_extensions)) {
				$files = $final_file;
				$path = $path.$final_file;
				if(move_uploaded_file($tmp,$path)) {
					$success = true;
				}
			// } else {
			// 	$success = false;
			// }
		}

		if ($success == true) {

			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_user_info WHERE user_id="'. $ID .'"' );
			if ( mysqli_num_rows($selectData) > 0 ) {
				$rowData = mysqli_fetch_array($selectData);
				$data_ID = $rowData['ID'];

				mysqli_query( $conn,"UPDATE tbl_user_info set avatar='". $files ."' WHERE ID='". $data_ID ."'" );
				$message = "Success";
			} else {
				$sql = "INSERT INTO tbl_user_info (user_id, avatar) VALUES ('$ID', '$files')";

				if (mysqli_query($conn, $sql)) {
					$message = "Success";
				}
			}

			if (!mysqli_error($conn)) {
				$output = array(
					'avatar' => $files
				);
				echo json_encode($output);
			}
			mysqli_close($conn);
		}
	}

	if( isset($_POST['btnSave_userPassword']) ) {
		$ID = $_POST['ID'];
		$password = $_POST['password'];
		$password_new = $_POST['password_new'];
		$password_hash = password_hash($password_new, PASSWORD_DEFAULT);
		$message = "Error";

		$selectData = mysqli_query( $conn,'SELECT * FROM tbl_user WHERE ID="'. $ID .'"' );
		if ( mysqli_num_rows($selectData) > 0 ) {
			$rowData = mysqli_fetch_array($selectData);
			$data_ID = $rowData['ID'];
			$data_password = $rowData['password'];

			$isPasswordCorrect = password_verify($password, $data_password);
			if ($isPasswordCorrect == true) {
				mysqli_query( $conn,"UPDATE tbl_user set password='". $password_hash ."' WHERE ID='". $data_ID ."'" );
				$message = "Success";
			} else {
				$message = "Incorrect Password! Please try again";
			}
		}
		
		$output = array(
			'message' => $message
		);
		echo json_encode($output);
		mysqli_close($conn);
	}

	if( isset($_POST['btnSave_userPrivacy']) ) {
		$ID = $_POST['ID'];
		$optionPrivacy = array();
		array_push($optionPrivacy, $_POST['optionPrivacy1']);
		array_push($optionPrivacy, $_POST['optionPrivacy2']);
		array_push($optionPrivacy, $_POST['optionPrivacy3']);
		array_push($optionPrivacy, $_POST['optionPrivacy4']);
		$message = "Error";

		$optionPrivacy = implode(", ",$optionPrivacy);

		$selectData = mysqli_query( $conn,'SELECT * FROM tbl_user_info WHERE user_id="'. $ID .'"' );
		if ( mysqli_num_rows($selectData) > 0 ) {
			$rowData = mysqli_fetch_array($selectData);
			$data_ID = $rowData['ID'];

			mysqli_query( $conn,"UPDATE tbl_user_info set privacy='". $optionPrivacy ."' WHERE ID='". $data_ID ."'" );
			$message = "Success";
		} else {
			$sql = "INSERT INTO tbl_user_info (user_id, privacy) VALUES ('$ID', '$optionPrivacy')";

			if (mysqli_query($conn, $sql)) {
				$message = "Success";
			}
		}
		
		$output = array(
			'message' => $message
		);
		echo json_encode($output);
		mysqli_close($conn);
	}

	if( isset($_POST['btnSave_Settings']) ) {
		$ID = $_POST['ID'];
		$background = array();
		array_push($background, $_POST['bgHeader']);
		array_push($background, $_POST['bgHeaderLogo']);
		array_push($background, $_POST['bgSidebar']);
		array_push($background, $_POST['bgBody']);
		$message = "Error";

		$background = implode(", ",$background);

		$selectData = mysqli_query( $conn,'SELECT * FROM tbl_settings WHERE user_id="'. $ID .'"' );
		if ( mysqli_num_rows($selectData) > 0 ) {
			$rowData = mysqli_fetch_array($selectData);
			$data_ID = $rowData['ID'];

			mysqli_query( $conn,"UPDATE tbl_settings set background='". $background ."', reset='1' WHERE ID='". $data_ID ."'" );
			$message = "Success";
		} else {
			$sql = "INSERT INTO tbl_settings (user_id, background) VALUES ('$ID', '$background')";

			if (mysqli_query($conn, $sql)) {
				$message = "Success";
			}
		}

		$output = array(
			'message' => $message
		);
		echo json_encode($output);
		mysqli_close($conn);
	}
	
	if( isset($_POST['btnSave_SettingsDefault']) ) {
		$ID = $_POST['ID'];
		$message = "Error";

		$selectData = mysqli_query( $conn,'SELECT * FROM tbl_settings WHERE user_id="'. $ID .'"' );
		if ( mysqli_num_rows($selectData) > 0 ) {
			$rowData = mysqli_fetch_array($selectData);
			$data_ID = $rowData['ID'];

			mysqli_query( $conn,"UPDATE tbl_settings set reset='0' WHERE ID='". $data_ID ."'" );
			$message = "Success";
		} else {
			$message = "Success";
		}

		$output = array(
			'message' => $message
		);
		echo json_encode($output);
		mysqli_close($conn);
	}

	if( isset($_POST['btnSave_userJob']) ) {
		$ID = $_POST['ID'];

		// User Section
		$first_name = addslashes($_POST['first_name']);
		$last_name = addslashes($_POST['last_name']);
		mysqli_query( $conn,"UPDATE tbl_user set first_name='". $first_name ."', last_name='". $last_name ."' WHERE ID='". $ID ."'" );

		// Info Section
		$mobile = addslashes($_POST['mobile']);
		$address = addslashes($_POST['address']);
		$selectInfo = mysqli_query( $conn,"SELECT * FROM tbl_user_info WHERE user_id=$ID");
		if ( mysqli_num_rows($selectInfo) > 0 ) {
			mysqli_query( $conn,"UPDATE tbl_user_info set mobile='". $mobile ."', address='". $address ."' WHERE user_id='". $ID ."'" );
		} else {
			$sql = "INSERT INTO tbl_user_info (user_id, mobile, address) VALUES ( '$ID', '$mobile', '$address' )";
			mysqli_query($conn, $sql);
		}

		// Social Media
		$website = addslashes($_POST['website']);
		$linkedin = addslashes($_POST['linkedin']);
		$facebook = addslashes($_POST['facebook']);
		$twitter = addslashes($_POST['twitter']);
		$selectSocial = mysqli_query( $conn,"SELECT * FROM tbl_user_social_media WHERE user_id=$ID");
		if ( mysqli_num_rows($selectSocial) > 0 ) {
			mysqli_query( $conn,"UPDATE tbl_user_social_media set linkedin='". $linkedin ."', facebook='". $facebook ."', twitter='". $twitter ."', website='". $website ."' WHERE user_id='". $ID ."'" );
		} else {
			$sql = "INSERT INTO tbl_user_social_media (user_id, linkedin, facebook, twitter, website)
			VALUES ( '$ID', '$linkedin', '$facebook', '$twitter', '$website')";
			mysqli_query($conn, $sql);
		}

		$count_educ = addslashes($_POST['count_educ']);
		$arr_educ = array();
		for ($i=0; $i < $count_educ; $i++) {
			$educ_school = $_POST['education'][$i]['educ_school'];
			$educ_degree = $_POST['education'][$i]['educ_degree'];
			$educ_diploma = $_FILES['education']['name'][$i];

			if (!empty($educ_diploma)) {
				$path = 'uploads/job/';
				$tmp = implode('*', $_FILES['education']['tmp_name'][$i]);
				$files = implode('*', $educ_diploma);
				$files = rand(1000,1000000) . ' - ' . $files;
				$path = $path.$files;
				move_uploaded_file($tmp,$path);

				$educ_data = array (
					'educ_school' 	=> 	$educ_school,
					'educ_degree' 	=>	$educ_degree,
					'educ_diploma' 	=>	$files
				);
			} else {
				$educ_data = array (
					'educ_school' 	=> 	$educ_school,
					'educ_degree' 	=>	$educ_degree
				);
			}
			array_push( $arr_educ, $educ_data );
		}
		$education = json_encode($arr_educ);

		$count_ref = addslashes($_POST['count_ref']);
		$arr_ref = array();
		for ($i=0; $i < $count_ref; $i++) {
			$ref_name = $_POST['reference'][$i]['ref_name'];
			$ref_email = $_POST['reference'][$i]['ref_email'];
			$ref_phone = $_POST['reference'][$i]['ref_phone'];
			$ref_data = array (
				'ref_name'	=>	$ref_name,
				'ref_email' =>	$ref_email,
				'ref_phone' =>	$ref_phone
			);
			array_push( $arr_ref, $ref_data );
		}
		$reference = json_encode($arr_ref);

		$availability =$_POST["availability"];
        $availability = implode(", ", $availability);

		$preference = $_POST["preference"];
        $preference = implode(", ", $preference);

		$skill_set = addslashes($_POST["skill_set"]);

		$selectJob = mysqli_query( $conn,"SELECT * FROM tbl_user_job WHERE user_id=$ID");
		if ( mysqli_num_rows($selectJob) > 0 ) {
			mysqli_query( $conn,"UPDATE tbl_user_job set education='". $education ."', availability='". $availability ."', preference='". $preference ."', reference='". $reference ."', skill_set='". $skill_set ."' WHERE user_id='". $ID ."'" );
		} else {
			$sql = "INSERT INTO tbl_user_job (user_id, education, reference, availability, preference, skill_set)
			VALUES ( '$ID', '$education', '$reference', '$availability', '$preference', '$skill_set')";
			mysqli_query($conn, $sql);
		}
		
		$output = array(
			'ID' => $ID,
			'first_name' => stripcslashes($first_name),
			'last_name' => stripcslashes($last_name),

			'website' => stripcslashes($website),
			'linkedin' => stripcslashes($linkedin),
			'facebook' => stripcslashes($facebook),
			'twitter' => stripcslashes($twitter)
		);
		echo json_encode($output);
		mysqli_close($conn);
	}

	if( isset($_POST['btnSave_USER_Project']) ) {
		$ID = $_POST['ID'];
		$project_id = $_POST['project_id'];
		$project = $_POST['project'];
		$due_date = $_POST['due_date'];
		$priority = isset($_POST['priority']) ? 1 : 0;

		$assigned_to_id = array();
		for($i=0; $i<count($_POST['assigned_to_id']); $i++){
			array_push($assigned_to_id, $_POST['assigned_to_id'][$i]);
		}
		$assigned_to_id = implode(", ",$assigned_to_id);

		if ($project_id) {
			mysqli_query( $conn,"UPDATE tbl_user_project set project='". $project ."', assigned_to_id='". $assigned_to_id ."', due_date='". $due_date ."', priority='". $priority ."' WHERE ID='". $project_id ."'" );
			
			echo json_encode(select_project($ID));
		} else {
			$sql = "INSERT INTO tbl_user_project (user_id, project, assigned_to_id, due_date, priority)
			VALUES ( '$ID', '$project', '$assigned_to_id', '$due_date', '$priority' )";

			if (mysqli_query($conn, $sql)) {

				echo json_encode(select_project($ID));
			}
		}
	}

	function select_project($ID) {
		global $conn;

		$last_id = mysqli_insert_id($conn);
		$selectData = mysqli_query( $conn,'SELECT * FROM tbl_user_project WHERE user_id="'. $ID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );
		if ( mysqli_num_rows($selectData) > 0 ) {
			$rowData = mysqli_fetch_array($selectData);
			$data_ID = $rowData['ID'];
			$data_project = $rowData['project'];
			$data_due_date = $rowData['due_date'];
			$data_priority = $rowData['priority'];
			$data_status = $rowData['is_completed'];

			$data_assigned_to_id = array();
			$array_assigned_to_id = explode(", ", $rowData["assigned_to_id"]);

            $resultEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee" );
            if ( mysqli_num_rows($resultEmployee) > 0 ) {
                while($rowEmployee = mysqli_fetch_array($resultEmployee)) {
					if (in_array($rowEmployee["ID"], $array_assigned_to_id)) {
						array_push($data_assigned_to_id, $rowEmployee["first_name"] .' '. $rowEmployee["last_name"]);
					}
                }
            }
			$data_assigned_to_id = implode(", ",$data_assigned_to_id);

        	$sidebar_count = sidebar_count('project');
			$output = array(
				'ID' => $data_ID,
				'project' => $data_project,
				'assigned_to_id' => $data_assigned_to_id,
				'due_date' => $data_due_date,
				'priority' => $data_priority,
				'status' => intval($data_status)
			);

			$result = array_merge($sidebar_count, $output);
			return $result;
		}
	}

	if( isset($_GET['modalProject_Delete']) ) {
		$ID = $_GET['modalProject_Delete'];

        mysqli_query( $conn,"UPDATE tbl_user_project set is_removed='1' WHERE ID='". $ID ."'" );

	    $sidebar_count = sidebar_count('project');
	    echo json_encode($sidebar_count);
    }



	if( isset($_POST['btnSave_USER_Task']) ) {
		$ID = $_POST['ID'];
		$task_id = $_POST['task_id'];
		$task = $_POST['task'];
		$due_date = $_POST['due_date'];
		$priority = isset($_POST['priority']) ? 1 : 0;

		$assigned_to_id = $_POST['assigned_to_id'];

		if ($task_id) {
			mysqli_query( $conn,"UPDATE tbl_user_task set task='". $task ."', assigned_to_id='". $assigned_to_id ."', due_date='". $due_date ."', priority='". $priority ."' WHERE ID='". $task_id ."'" );
			
			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_user_task WHERE ID="'. $task_id .'" ORDER BY ID LIMIT 1' );
			if ( mysqli_num_rows($selectData) > 0 ) {
				$rowData = mysqli_fetch_array($selectData);
				
				echo json_encode(select_task($rowData));
			}
		} else {
			$sql = "INSERT INTO tbl_user_task (user_id, task, assigned_to_id, due_date, priority)
			VALUES ( '$ID', '$task', '$assigned_to_id', '$due_date', '$priority' )";

			if (mysqli_query($conn, $sql)) {

				$last_id = mysqli_insert_id($conn);
				$selectData = mysqli_query( $conn,'SELECT * FROM tbl_user_task WHERE user_id="'. $ID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );
				if ( mysqli_num_rows($selectData) > 0 ) {
					$rowData = mysqli_fetch_array($selectData);
					
					echo json_encode(select_task($rowData));
				}
			}
		}
	}

	function select_task($data) {
		global $conn;

		$rowData = $data;
		$data_ID = $rowData['ID'];
		$data_task = $rowData['task'];
		$data_due_date = $rowData['due_date'];
		$data_priority = $rowData['priority'];
		$data_status = $rowData['is_completed'];

		$data_assigned_to_id = array();
		$array_assigned_to_id = explode(", ", $rowData["assigned_to_id"]);

        $resultEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee" );
        if ( mysqli_num_rows($resultEmployee) > 0 ) {
            while($rowEmployee = mysqli_fetch_array($resultEmployee)) {
				if (in_array($rowEmployee["ID"], $array_assigned_to_id)) {
					array_push($data_assigned_to_id, $rowEmployee["first_name"] .' '. $rowEmployee["last_name"]);
				}
            }
        }
		$data_assigned_to_id = implode(", ",$data_assigned_to_id);

    	$sidebar_count = sidebar_count('task');
		$output = array(
			'ID' => $data_ID,
			'task' => $data_task,
			'assigned_to_id' => $data_assigned_to_id,
			'due_date' => $data_due_date,
			'priority' => $data_priority,
			'status' => intval($data_status)
		);

		$result = array_merge($sidebar_count, $output);
		return $result;
	}

	if( isset($_GET['modalTask_Delete']) ) {
		$ID = $_GET['modalTask_Delete'];

        mysqli_query( $conn,"UPDATE tbl_user_task set is_removed='1' WHERE ID='". $ID ."'" );

	    $sidebar_count = sidebar_count('task');
	    echo json_encode($sidebar_count);
    }



	if( isset($_POST['btnSave_USER_Upload']) ) {
		$ID = $_POST['ID'];	 
		$description = $_POST['description'];	 
		$files = "";

		$success = false;
		if( !empty( $_FILES['file']['name'] ) ) {
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
			$path = 'uploads/'; // upload directory
			$file = $_FILES['file']['name'];
			$tmp = $_FILES['file']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_file = rand(1000,1000000).' - '.$file;
			// check's valid format
			// if(in_array($ext, $valid_extensions)) {
				$files = $final_file;
				$path = $path.$final_file;
				if(move_uploaded_file($tmp,$path)) {
					$success = true;
				}
			// } else {
			// 	$success = false;
			// }
		}

		if ($success == true) {
			$sql = "INSERT INTO tbl_user_upload (user_id, description, files)
			VALUES ( '$ID', '$description', '$files' )";
			
			if (mysqli_query($conn, $sql)) {
				$last_id = mysqli_insert_id($conn);
				$selectData = mysqli_query( $conn,'SELECT * FROM tbl_user_upload WHERE user_id="'. $ID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );
				if ( mysqli_num_rows($selectData) > 0 ) {
					$rowData = mysqli_fetch_array($selectData);
					$data_ID = $rowData['ID'];
					$data_description = $rowData['description'];
					$data_file = $rowData['files'];

                	$sidebar_count = sidebar_count('upload');
					$output = array(
						'ID' => $data_ID,
						'description' => $data_description,
						'files' => $data_file
					);

					$result = array_merge($sidebar_count, $output);
					echo json_encode($result);
				}
			}
		}
	}

	if( isset($_GET['modalUpload_Remove']) ) {
		$ID = $_GET['modalUpload_Remove'];

        mysqli_query( $conn,"UPDATE tbl_user_upload set is_remove='1' WHERE ID='". $ID ."'" );

	    $sidebar_count = sidebar_count('upload');
	    echo json_encode($sidebar_count);
    }



	if( isset($_GET['profile_project']) ) {
		$userID = $_GET['profile_project'];

        $selectProject = mysqli_query( $conn,"SELECT * FROM tbl_user_project WHERE is_completed = 0 AND is_removed = 0" );
        if ( mysqli_num_rows($selectProject) > 0 ) {
            while($rowProject = mysqli_fetch_array($selectProject)) {

                $array_Project = explode(", ", $rowProject["assigned_to_id"]);
                if (in_array($userID, $array_Project)) {
                    $project_userID = $rowProject["user_id"];

                    $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $project_userID" );
                    if ( mysqli_num_rows($selectUser) > 0 ) {
                        while($rowUser = mysqli_fetch_array($selectUser)) {
                            $project_userName = $rowUser["first_name"] .' '. $rowUser["last_name"];
                        }
                    }

                    echo '<div class="mt-action" id="project_'. $rowProject["ID"] .'">
                        <div class="mt-action-body">
                            <div class="mt-action-row">
                                <div class="mt-action-info ">
                                    <div class="mt-action-details ">
                                        <span class="mt-action-author">'. $project_userName .'</span> ';

                                        if ($rowProject["priority"] == 1) {
			                                echo '<span class="project-bell"><i class="fa fa-bell-o"></i></span>';
			                            }
                                        
                                        echo '<p class="mt-action-desc">'. $rowProject["project"] .'</p>
                                    </div>
                                </div>
                                <div class="mt-action-datetime ">
                                    <span class="mt-action-date">'. $rowProject["due_date"] .'</span>
                                </div>
                                <div class="mt-action-buttons ">
                                    <div class="btn-group btn-group-circle">
                                        <button type="button" class="btn btn-outline green btn-sm btnProjectApprove" data-id="'. $rowProject["ID"] .'" onClick="btnProjectApprove('. $rowProject["ID"] .')">Appove</button>
                                        <button type="button" class="btn btn-outline red btn-sm btnProjectReject" data-id="'. $rowProject["ID"] .'" onClick="btnProjectReject('. $rowProject["ID"] .')">Reject</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                }

            }
        }

		mysqli_close($conn);
	}

	if( isset($_GET['profile_project_approve']) ) {
		$task_id = $_GET['profile_project_approve'];
		$task_remarks = $_GET['profile_project_remarks'];

		mysqli_query( $conn,"UPDATE tbl_user_project set is_completed='1', remarks = '". $task_remarks ."' WHERE ID='". $task_id ."'" );

	    $sidebar_count = sidebar_count('project');
	    echo json_encode($sidebar_count);
	}

	if( isset($_GET['profile_project_reject']) ) {
		$task_id = $_GET['profile_project_reject'];

		mysqli_query( $conn,"UPDATE tbl_user_project set is_completed='2' WHERE ID='". $task_id ."'" );

	    $sidebar_count = sidebar_count('project');
	    echo json_encode($sidebar_count);
	}



	if( isset($_GET['my_task']) ) {
		$userID = $_GET['my_task'];
		$task_user_id = false;
		$task_assigned_to_id = false;
		$myTask = 0;

        $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID=$userID" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
        	$rowUser = mysqli_fetch_array($selectUser);

        	$user_id = $rowUser["ID"];
        	$user_employee_id = $rowUser["employee_id"];

	        $selectTask = mysqli_query( $conn,"SELECT * FROM tbl_user_task WHERE is_removed = 0" );
	        if ( mysqli_num_rows($selectTask) > 0 ) {
	            while($rowTask = mysqli_fetch_array($selectTask)) {

	                $array_Task_userID = explode(", ", $rowTask["assigned_to_id"]);
	                $array_Task_assignedID = explode(", ", $rowTask["assigned_to_id"]);

	                if (in_array($user_id, $array_Task_userID)) {
	                	$task_user_id = true;
	                }

	                if (in_array($user_employee_id, $array_Task_assignedID)) {
	                	$task_assigned_to_id = true;
	                }

	                if ( $task_user_id == true OR $task_assigned_to_id == true ) {
	                	$myTask++;
	                }

	            }
	        }
        }
	    echo $myTask;

		mysqli_close($conn);
	}

	if( isset($_GET['profile_task']) ) {
		$userID = $_GET['profile_task'];

        $selectTask = mysqli_query( $conn,"SELECT * FROM tbl_user_task WHERE is_completed = 0 AND is_removed = 0" );
        if ( mysqli_num_rows($selectTask) > 0 ) {
            while($rowTask = mysqli_fetch_array($selectTask)) {
                $task_userID = $rowTask["user_id"];
                $task_type = $rowTask["type"];
                $task_target_id = $rowTask["target_id"];
                $array_Task = explode(", ", $rowTask["assigned_to_id"]);

                if ($task_type == 2) {
                	$selectDashboardFile = mysqli_query( $conn,"SELECT * FROM tbl_library_file WHERE ID = $task_target_id" );
                	if ( mysqli_num_rows($selectDashboardFile) > 0 ) {
                		$rowDashboardFile = mysqli_fetch_array($selectDashboardFile);
                        $task_assigned_to_action = $rowDashboardFile["assigned_to_action"];
                        $task_files = $rowDashboardFile["files"];

                        if (!empty($array_Task[$task_assigned_to_action])) {
	                        if ($userID == $array_Task[$task_assigned_to_action]) {
	                        	$selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $task_userID" );
			                    if ( mysqli_num_rows($selectUser) > 0 ) {
			                        while($rowUser = mysqli_fetch_array($selectUser)) {
			                            $task_userName = $rowUser["first_name"] .' '. $rowUser["last_name"];
			                        }
			                    }

			                    echo '<div class="mt-action" id="task_'. $rowTask["ID"] .'">
			                        <div class="mt-action-body">
			                            <div class="mt-action-row">
			                                <div class="mt-action-info ">
			                                    <div class="mt-action-details ">
			                                        <span class="mt-action-author">'. $task_userName .'</span>
													<p class="mt-action-desc">'. $rowTask["task"] .'</p>
													<p class="mt-action-file"><a href="uploads/library/'. $task_files .'" target="_blank">'. $task_files .'</a></p>
			                                    </div>
			                                </div>
			                                <div class="mt-action-datetime ">
			                                    <span class="mt-action-date">'. $rowTask["due_date"] .'</span>
			                                </div>
			                                <div class="mt-action-buttons ">
			                                    <div class="btn-group btn-group-circle">
			                                    	<a href="#modalAttachedEdit" type="button" class="btn btn-outline dark btn-sm btnAttachedEdit" data-toggle="modal" onclick="btnAttachedEdit('. $rowTask["target_id"] .')">Edit</a>
			                                    	<button type="button" class="btn btn-outline red btn-sm btnTaskReject" data-id="'. $rowTask["ID"] .'" onClick="btnTaskReject('. $rowTask["ID"] .')">Reject</button>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                    </div>';
	                        }
                        }
                	}
                } else {
	                if (in_array($userID, $array_Task)) {

	                    $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $task_userID" );
	                    if ( mysqli_num_rows($selectUser) > 0 ) {
	                        while($rowUser = mysqli_fetch_array($selectUser)) {
	                            $task_userName = $rowUser["first_name"] .' '. $rowUser["last_name"];
	                        }
	                    }

	                    echo '<div class="mt-action" id="task_'. $rowTask["ID"] .'">
	                        <div class="mt-action-body">
	                            <div class="mt-action-row">
	                                <div class="mt-action-info ">
	                                    <div class="mt-action-details ">
	                                        <span class="mt-action-author">'. $task_userName .'</span> ';

	                                        if ($rowTask["priority"] == 1) {
				                                echo '<span class="task-bell"><i class="fa fa-bell-o"></i></span>';
				                            }
	                                        
	                                        echo '<p class="mt-action-desc">'. $rowTask["task"] .'</p>
	                                    </div>
	                                </div>
	                                <div class="mt-action-datetime ">
	                                    <span class="mt-action-date">'. $rowTask["due_date"] .'</span>
	                                </div>
	                                <div class="mt-action-buttons ">
	                                    <div class="btn-group btn-group-circle">
	                                    	<button type="button" class="btn btn-outline green btn-sm btnTaskApprove" data-id="'. $rowTask["ID"] .'" onClick="btnTaskApprove('. $rowTask["ID"] .')">Appove</button>
	                                    	<button type="button" class="btn btn-outline red btn-sm btnTaskReject" data-id="'. $rowTask["ID"] .'" onClick="btnTaskReject('. $rowTask["ID"] .')">Reject</button>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>';
	                }
                }

            }
        }

		mysqli_close($conn);
	}

	if( isset($_GET['profile_task_approve']) ) {
		$task_id = $_GET['profile_task_approve'];
		$task_remarks = $_GET['profile_task_remarks'];

		mysqli_query( $conn,"UPDATE tbl_user_task set is_completed='1', remarks = '". $task_remarks ."' WHERE ID='". $task_id ."'" );

	    $sidebar_count = sidebar_count('task');
	    echo json_encode($sidebar_count);
	}

	if( isset($_GET['profile_task_reject']) ) {
		$task_id = $_GET['profile_task_reject'];

		mysqli_query( $conn,"UPDATE tbl_user_task set is_completed='2' WHERE ID='". $task_id ."'" );

	    $sidebar_count = sidebar_count('task');
	    echo json_encode($sidebar_count);
	}



    function sidebar_count($type) {
    	global $conn;
    	// global $current_userID;
    	$current_userID = $_COOKIE['ID'];

    	$profileProject = 0;
    	$profileTask = 0;
    	$profileUpload = 0;

    	if ($type === "project") {
    		$selectProject = mysqli_query( $conn,"SELECT * FROM tbl_user_project WHERE is_removed = 0 AND user_id = $current_userID " );
            if ( mysqli_num_rows($selectProject) > 0 ) {
                while($rowProject = mysqli_fetch_array($selectProject)) {
                    $profileProject++;
                }
            }
    	} else if ($type === "task") {
            $selectTask = mysqli_query( $conn,'SELECT * FROM tbl_user_task WHERE is_removed = 0 AND user_id ="'. $current_userID .'"' );
            if ( mysqli_num_rows($selectTask) > 0 ) {
                while($rowTask = mysqli_fetch_array($selectTask)) {
                    $profileTask++;
                }
            }
    	} else if ($type === "upload") {
            $selectUpload = mysqli_query( $conn,"SELECT * FROM tbl_user_upload WHERE is_remove = 0 AND user_id = $current_userID " );
            if ( mysqli_num_rows($selectUpload) > 0 ) {
                while($rowUpload = mysqli_fetch_array($selectUpload)) {
                    $profileUpload++;
                }
            }
    	}
		mysqli_close($conn);

    	$output = array(
			'profileProject' => $profileProject,
			'profileTask' => $profileTask,
			'profileUpload' => $profileUpload
		);
		return $output;
    }




	if( isset($_POST['btnSave_Area']) ) {
		$ID = $_POST['ID'];
		$description = addslashes($_POST['description']);
		$due_date = "0000-00-00";
		$files = "";
		$files_arr = array();

		$type = $_POST['type'];
		if ($type == 16 AND !empty($_POST['type_others'])) {
			$type_others = addslashes($_POST['type_others']);
			$sql = "INSERT INTO tbl_library_type (name) VALUES ('$type_others')";
			if (mysqli_query($conn, $sql)) { $type = mysqli_insert_id($conn); }
		}

		$category = $_POST['category'];
		if ($category == 9 AND !empty($_POST['category_others'])) {
			$category_others = addslashes($_POST['category_others']);
			$sql = "INSERT INTO tbl_library_category (name) VALUES ('$category_others')";
			if (mysqli_query($conn, $sql)) { $category = mysqli_insert_id($conn); }
		}

		$scope = $_POST['scope'];
		if ($scope == 5 AND !empty($_POST['scope_others'])) {
			$scope_others = addslashes($_POST['scope_others']);
			$sql = "INSERT INTO tbl_library_scope (name) VALUES ('$scope_others')";
			if (mysqli_query($conn, $sql)) { $scope = mysqli_insert_id($conn); }
		}

		$module = $_POST['module'];
		if ($module == 13 AND !empty($_POST['module_others'])) {
			$module_others = addslashes($_POST['module_others']);
			$sql = "INSERT INTO tbl_library_module (name) VALUES ('$module_others')";
			if (mysqli_query($conn, $sql)) { $module = mysqli_insert_id($conn); }
		}

		$name_id = array();
		array_push($name_id, $type);
		array_push($name_id, $category);
		array_push($name_id, $scope);
		array_push($name_id, $module);
		$name_id = implode(", ",$name_id);

		$sql = "INSERT INTO tbl_library (user_id, name, description, due_date)
		VALUES ('$ID', '$name_id', '$description', '$due_date')";
		
		if (mysqli_query($conn, $sql)) {

			$last_id = mysqli_insert_id($conn);

			if( !empty( $_FILES['file']['name'] ) ) {
				$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
				$path = 'uploads/library/'; // upload directory
				$file = $_FILES['file']['name'];
				$tmp = $_FILES['file']['tmp_name'];
				// get uploaded file's extension
				$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
				// can upload same image using rand function
				$final_file = rand(1000,1000000).' - '.$file;
				// check's valid format
				// if(in_array($ext, $valid_extensions)) {
					$files = $final_file;
					$path = $path.$final_file;
					if(move_uploaded_file($tmp,$path)) {

						$sql = "INSERT INTO tbl_library_file (user_id, library_id, files, name, due_date)
						VALUES ('$ID', '$last_id', '$files', 'Reference File', '$due_date')";
						if (mysqli_query($conn, $sql)) {
							$last_file_id = mysqli_insert_id($conn);
							$files_arr = array(
								"file_ID" => $last_file_id,
								"files" => $files,
								"file_name" => 'Reference File',
								"file_due" => $due_date
							);
						}
					}
				// }
			}

			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_library WHERE user_id="'. $ID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );
			if ( mysqli_num_rows($selectData) > 0 ) {
				$rowData = mysqli_fetch_array($selectData);
				$data_ID = $rowData['ID'];
				$data_name = $rowData['name'];
				$data_description = $rowData['description'];

				$selectUserInfo = mysqli_query( $conn,'SELECT * FROM tbl_user_info WHERE user_id="'. $ID .'"' );
				if ( mysqli_num_rows($selectUserInfo) > 0 ) {
					$rowDataUserInfo = mysqli_fetch_array($selectUserInfo);
					$data_avatar = $rowDataUserInfo['avatar'];
				} else {
					$data_avatar = "";
				}

				$data_name = array();
				if (!empty($type)) {
					$selectType = mysqli_query( $conn,'SELECT * FROM tbl_library_type WHERE ID="'. $type .'"' );
					$rowType = mysqli_fetch_array($selectType);
					$data_type = $rowType['name'];
					array_push($data_name, $data_type);
				}
				if (!empty($category)) {
					$selectCategory = mysqli_query( $conn,'SELECT * FROM tbl_library_category WHERE ID="'. $category .'"' );
					$rowCategory = mysqli_fetch_array($selectCategory);
					$data_category = $rowCategory['name'];
					array_push($data_name, $data_category);
				}
				if (!empty($scope)) {
					$selectScope = mysqli_query( $conn,'SELECT * FROM tbl_library_scope WHERE ID="'. $scope .'"' );
					$rowScope = mysqli_fetch_array($selectScope);
					$data_scope = $rowScope['name'];
					array_push($data_name, $data_scope);
				}
				if (!empty($module)) {
					$selecwModule = mysqli_query( $conn,'SELECT * FROM tbl_library_module WHERE ID="'. $module .'"' );
					$rowModule = mysqli_fetch_array($selecwModule);
					$data_module = $rowModule['name'];
					array_push($data_name, $data_module);
				}
				$data_name = implode(" - ",$data_name);

				$output = array(
					"ID" => $data_ID,
					"name" => stripcslashes($data_name),
					"description" => stripcslashes($data_description),
					"avatar" => $data_avatar
				);
				$result = array_merge($files_arr, $output);
				echo json_encode($result);
			}
		}
// 		else {
//           echo "Error: " . $sql . "<br>" . mysqli_error($conn);
//         }
		mysqli_close($conn);
	}

	if( isset($_POST['btnUpdate_Area']) ) {
		$ID = $_POST['ID'];
		$current_userID = $_COOKIE['ID'];
		$description = addslashes($_POST['description']);
		$last_modified = date('Y-m-d H:i:s');
		$files = "";
		$files_arr = array();

		$type = $_POST['type'];
		if ($type == 16 AND !empty($_POST['type_others'])) {
			$type_others = addslashes($_POST['type_others']);
			$sql = "INSERT INTO tbl_library_type (name) VALUES ('$type_others')";
			if (mysqli_query($conn, $sql)) { $type = mysqli_insert_id($conn); }
		}

		$category = $_POST['category'];
		if ($category == 9 AND !empty($_POST['category_others'])) {
			$category_others = addslashes($_POST['category_others']);
			$sql = "INSERT INTO tbl_library_category (name) VALUES ('$category_others')";
			if (mysqli_query($conn, $sql)) { $category = mysqli_insert_id($conn); }
		}

		$scope = $_POST['scope'];
		if ($scope == 5 AND !empty($_POST['scope_others'])) {
			$scope_others = addslashes($_POST['scope_others']);
			$sql = "INSERT INTO tbl_library_scope (name) VALUES ('$scope_others')";
			if (mysqli_query($conn, $sql)) { $scope = mysqli_insert_id($conn); }
		}

		$module = $_POST['module'];
		if ($module == 13 AND !empty($_POST['module_others'])) {
			$module_others = addslashes($_POST['module_others']);
			$sql = "INSERT INTO tbl_library_module (name) VALUES ('$module_others')";
			if (mysqli_query($conn, $sql)) { $module = mysqli_insert_id($conn); }
		}

		$name_id = array();
		array_push($name_id, $type);
		array_push($name_id, $category);
		array_push($name_id, $scope);
		array_push($name_id, $module);
		$name_id = implode(", ",$name_id);

		mysqli_query( $conn,"UPDATE tbl_library set name='". $name_id ."', description='". $description ."', last_modified='". $last_modified ."' WHERE ID='". $ID ."'" );
		
		if (!mysqli_error($conn)) {

			if( !empty( $_FILES['file']['name'] ) ) {
				$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
				$path = 'uploads/library/'; // upload directory
				$file = $_FILES['file']['name'];
				$tmp = $_FILES['file']['tmp_name'];
				// get uploaded file's extension
				$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
				// can upload same image using rand function
				$final_file = rand(1000,1000000).' - '.$file;
				// check's valid format
				// if(in_array($ext, $valid_extensions)) {
					$files = $final_file;
					$path = $path.$final_file;
					if(move_uploaded_file($tmp,$path)) {

						$selectFile = mysqli_query( $conn,'SELECT * FROM tbl_library_file WHERE type = 0 AND library_id="'. $ID .'"' );
						if ( mysqli_num_rows($selectFile) > 0 ) {
							$rowFile = mysqli_fetch_array($selectFile);
							$last_file_id = $rowFile['ID'];
							$file_new = 0;

							mysqli_query( $conn,"UPDATE tbl_library_file set files='". $files ."', last_modified='". $last_modified ."' WHERE ID='". $last_file_id ."'" );
						} else {
							$sql = "INSERT INTO tbl_library_file (user_id, library_id, files, name, due_date)
							VALUES ('$current_userID', '$ID', '$files', 'Reference File', '0000-00-00')";
							mysqli_query($conn, $sql);
							$last_file_id = mysqli_insert_id($conn);
							$file_new = 1;
						}

						$files_arr = array(
							"file_ID" => $last_file_id,
							"files" => $files,
							"file_name" => 'Reference File',
							"file_due" => '0000-00-00',
							"file_new" => $file_new
						);
					}
				// }
			}

			$data_name = array();
			if (!empty($type)) {
				$selectType = mysqli_query( $conn,'SELECT * FROM tbl_library_type WHERE ID="'. $type .'"' );
				$rowType = mysqli_fetch_array($selectType);
				$data_type = $rowType['name'];
				array_push($data_name, $data_type);
			}
			if (!empty($category)) {
				$selectCategory = mysqli_query( $conn,'SELECT * FROM tbl_library_category WHERE ID="'. $category .'"' );
				$rowCategory = mysqli_fetch_array($selectCategory);
				$data_category = $rowCategory['name'];
				array_push($data_name, $data_category);
			}
			if (!empty($scope)) {
				$selectScope = mysqli_query( $conn,'SELECT * FROM tbl_library_scope WHERE ID="'. $scope .'"' );
				$rowScope = mysqli_fetch_array($selectScope);
				$data_scope = $rowScope['name'];
				array_push($data_name, $data_scope);
			}
			if (!empty($module)) {
				$selecwModule = mysqli_query( $conn,'SELECT * FROM tbl_library_module WHERE ID="'. $module .'"' );
				$rowModule = mysqli_fetch_array($selecwModule);
				$data_module = $rowModule['name'];
				array_push($data_name, $data_module);
			}
			$data_name = implode(" - ",$data_name);

			$output = array(
				'ID' => $ID,
				'name' => stripcslashes($data_name),
				'description' => stripcslashes($description)
			);
			$result = array_merge($files_arr, $output);
			echo json_encode($result);
		}

		mysqli_close($conn);
	}

	if( isset($_GET['btnDelete_Area']) ) {
		$id = $_GET['btnDelete_Area'];
		$reason = $_GET['reason'];
		$last_modified = date('Y-m-d H:i:s');

		// mysqli_query( $conn,"UPDATE tbl_library SET deleted='1', remarks = '". $reason ."', last_modified='". $last_modified ."' WHERE ID='". $id ."'" );
// 		mysqli_query( $conn,"UPDATE tbl_library SET reason = '". $reason ."', last_modified='". $last_modified ."' WHERE ID='". $id ."'" );

// 		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE ID = $id" );
// 		if ( mysqli_num_rows($selectData) > 0 ) {
//             $row = mysqli_fetch_array($selectData);
//             $name = $row['name'];
//             $reason = $row['reason'];
//         }

		$to = 'greeggimongala@gmail.com';
		$user = 'Interlink IQ';
		$subject = 'Request to delete Dashboard Item';
// 		$body = 'Hi '. $user .', please check '. $name .' Dashboard Item with ID #'. $id .' for deletion approval. The reason is: '. $reason;
		$body = 'Hi '. $reason;

		$mail = php_mailer($to, $user, $subject, $body);

		$output = array(
			"ID" => $id
		);
	    echo json_encode($mail);
	}

	if( isset($_GET['modalEdit_Area']) ) {
		$id = $_GET['modalEdit_Area'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE ID = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
            $library_name = $row["name"];

            $array_name_id = explode(", ", $library_name);
            if ( count($array_name_id) == 4 ) {

            }
        }

		echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
		
		<div class="form-group">
            <label class="col-md-3 control-label">Business Type</label>
            <div class="col-md-8">
                <select class="form-control" name="type" onchange="changedType(this.value)">
                    <option value="">Select</option>';

                    $resultType = mysqli_query( $conn,"SELECT * FROM tbl_library_type WHERE ID<>16 ORDER BY name" );
                    if ( mysqli_num_rows($resultType) > 0 ) {
                        while($rowType = mysqli_fetch_array($resultType)) {
                            $type_ID = $rowType["ID"];
                            $type_name = $rowType["name"];

                            if ($array_name_id[0] == $type_ID) {
                            	echo '<option value="'.$type_ID.'" SELECTED>'.$type_name.'</option>';
                            } else {
                            	echo '<option value="'.$type_ID.'">'.$type_name.'</option>';
                            }
                        }
                    }

                	echo '<option value="16">Others</option>
                </select>
                <input type="text" class="form-control hide type_others" name="type_others" placeholder="Enter Business Type Name" style="margin-top: 15px;" />
                <span class="help-block" style="margin: 0;">Services / Product</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Category</label>
            <div class="col-md-8">
                <select class="form-control" name="category" onchange="changedCategory(this.value)">
                    <option value="">Select</option>';
                    
                    $resultCategory = mysqli_query( $conn,"SELECT * FROM tbl_library_category WHERE ID<>9 ORDER BY name" );
                    if ( mysqli_num_rows($resultCategory) > 0 ) {
                        while($rowCategory = mysqli_fetch_array($resultCategory)) {
                            $category_ID = $rowCategory["ID"];
                            $category_name = $rowCategory["name"];

                            if ($array_name_id[1] == $category_ID) {
                            	echo '<option value="'.$category_ID.'" SELECTED>'.$category_name.'</option>';
                            } else {
                            	echo '<option value="'.$category_ID.'">'.$category_name.'</option>';
                            }
                        }
                    }
                    
                	echo '<option value="9">Others</option>
                </select>
                <input type="text" class="form-control hide category_others" name="category_others" placeholder="Enter Category Name" style="margin-top: 15px;" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Scope</label>
            <div class="col-md-8">
                <select class="form-control" name="scope" onchange="changedScope(this.value)">
                    <option value="">Select</option>';
                    
                    $resultScope = mysqli_query( $conn,"SELECT * FROM tbl_library_scope WHERE ID<>5 ORDER BY name" );
                    if ( mysqli_num_rows($resultScope) > 0 ) {
                        while($rowScope = mysqli_fetch_array($resultScope)) {
                            $scope_ID = $rowScope["ID"];
                            $scope_name = $rowScope["name"];

                            if ($array_name_id[2] == $scope_ID) {
                            	echo '<option value="'.$scope_ID.'" SELECTED>'.$scope_name.'</option>';
                            } else {
                            	echo '<option value="'.$scope_ID.'">'.$scope_name.'</option>';
                            }
                        }
                    }
                    
                	echo '<option value="5">Others</option>
                </select>
                <input type="text" class="form-control hide scope_others" name="scope_others" placeholder="Enter Scope Name" style="margin-top: 15px;" />
                <span class="help-block" style="margin: 0;">Certification / Accreditation / Regulatory</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Module / Section</label>
            <div class="col-md-8">
                <select class="form-control" name="module" onchange="changedModule(this.value)">
                    <option value="">Select</option>';
                    
                    $resultModule = mysqli_query( $conn,"SELECT * FROM tbl_library_module WHERE ID<>13 ORDER BY name" );
                    if ( mysqli_num_rows($resultModule) > 0 ) {
                        while($rowModule = mysqli_fetch_array($resultModule)) {
                            $module_ID = $rowModule["ID"];
                            $module_name = $rowModule["name"];

                            if ($array_name_id[3] == $module_ID) {
                            	echo '<option value="'.$module_ID.'" SELECTED>'.$module_name.'</option>';
                            } else {
                            	echo '<option value="'.$module_ID.'">'.$module_name.'</option>';
                            }
                        }
                    }
                   	
                	echo '<option value="13">Others</option>
                </select>
                <input type="text" class="form-control hide module_others" name="module_others" placeholder="Enter Module / Section Name" style="margin-top: 15px;" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Description</label>
            <div class="col-md-8">
                <textarea class="form-control" name="description">'. $row['description'] .'</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Reference File</label>
            <div class="col-md-8">
                <input class="form-control" type="file" name="file" />
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_GET['modalSubItem_Area']) ) {
		$id = $_GET['modalSubItem_Area'];
		$type = $_GET['type'];
		$current_userID = $_COOKIE['ID'];

		echo '<input class="form-control" type="hidden" name="parent_id" value="'. $id .'" />
		<input class="form-control" type="hidden" name="type" value="'. $type .'" />
		<div class="form-group">
            <label class="col-md-3 control-label">Item Name</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="name" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Item Description</label>
            <div class="col-md-8">
                <textarea class="form-control" name="description" required></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Assigned To</label>
            <div class="col-md-8">
                <select class="form-control mt-multiselect btn btn-default" name="assigned_to_id" required>';

                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $current_userID" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                            echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        }
                    } else {
                        echo '<option disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Due Date</label>
            <div class="col-md-8">
                <input class="form-control" type="date" name="due_date" required />
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_GET['modalEdit_SubItem']) ) {
		$id = $_GET['modalEdit_SubItem'];
		$current_userID = $_COOKIE['ID'];

		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE ID = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
        }

		echo '<input class="form-control" type="hidden" name="parent_id" value="'. $id .'" />
		<div class="form-group">
            <label class="col-md-3 control-label">Item Type</label>
            <div class="col-md-8">
            	<select class="form-control" name="type" required>
            		<option value="1" '; echo $row['type'] === "1" ? "SELECTED" : ""; echo '>Program</option>
            		<option value="2" '; echo $row['type'] === "2" ? "SELECTED" : ""; echo '>Policy</option>
            		<option value="3" '; echo $row['type'] === "3" ? "SELECTED" : ""; echo '>Procedure</option>
            		<option value="4" '; echo $row['type'] === "4" ? "SELECTED" : ""; echo '>Training</option>
            		<option value="5" '; echo $row['type'] === "5" ? "SELECTED" : ""; echo '>Form</option>
            	</select>
            </div>
        </div>
		<div class="form-group">
            <label class="col-md-3 control-label">Item Name</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="name" value="'. $row['name'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Item Description</label>
            <div class="col-md-8">
                <textarea class="form-control" name="description" required>'. $row['description'] .'</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Assigned To</label>
            <div class="col-md-8">
                <select class="form-control mt-multiselect btn btn-default" name="assigned_to_id" required>';
                    
                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $current_userID" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                            if ( $rowEmployee["ID"] === $row['assigned_to_id'] ) {
                                echo '<option value="'. $rowEmployee["ID"] .'" selected>'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                            } else {
                                echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                            }
                        }
                    } else {
                        echo '<option disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Due Date</label>
            <div class="col-md-8">
                <input class="form-control" type="date" name="due_date" value="'. date("Y-m-d", strtotime($row['due_date'])) .'" required />
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_POST['btnSave_SubItem']) ) {
    	$current_userID = $_COOKIE['ID'];
		$parent_id = $_POST['parent_id'];
		$type = $_POST['type'];
		$name = addslashes($_POST['name']);
		$description = addslashes($_POST['description']);
		$assigned_to_id = $_POST['assigned_to_id'];
		$due_date = $_POST['due_date'];

		$sql = "INSERT INTO tbl_library (user_id, parent_id, type, name, description, assigned_to_id, due_date)
		VALUES ('$current_userID', '$parent_id', '$type', '$name', '$description', '$assigned_to_id', '$due_date')";
		
		if (mysqli_query($conn, $sql)) {
			$last_id = mysqli_insert_id($conn);

			// Select existing Child IDs and push to an array
			$selectParent = mysqli_query( $conn,'SELECT * FROM tbl_library WHERE ID="'. $parent_id .'"' );
			$rowParent = mysqli_fetch_array($selectParent);

			$child_id = array();
			if ( !empty($rowParent['child_id']) ) {
				array_push($child_id, $rowParent['child_id']);
			}
			array_push($child_id, $last_id);

			// Update parent's record
			$child_id = implode(", ",$child_id);
			mysqli_query( $conn,"UPDATE tbl_library set child_id='". $child_id ."' WHERE ID='". $parent_id ."'" );


			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_library WHERE user_id="'. $current_userID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );
			if ( mysqli_num_rows($selectData) > 0 ) {
				$rowData = mysqli_fetch_array($selectData);
				$data_ID = $rowData['ID'];
				$data_user_id = $rowData['user_id'];
				$data_parent_id = $rowData['parent_id'];
				$data_type = $rowData['type'];
				$data_name = $rowData['name'];
				$data_description = $rowData['description'];

				$selectUserInfo = mysqli_query( $conn,'SELECT * FROM tbl_user_info WHERE user_id="'. $data_user_id .'"' );
				if ( mysqli_num_rows($selectUserInfo) > 0 ) {
					$rowDataUserInfo = mysqli_fetch_array($selectUserInfo);
					$data_avatar = $rowDataUserInfo['avatar'];
				} else {
					$data_avatar = "";
				}

				$output = array(
					"item_id" => $data_ID,
					"parent_id" => $data_parent_id,
					"type" => $data_type,
					"name" => stripcslashes($data_name),
					"description" => stripcslashes($data_description),
					"avatar" => $data_avatar
				);
			}
		}
		mysqli_close($conn);

		echo json_encode($output);
	}

	if( isset($_POST['btnUpdate_Area_SubItem']) ) {
		$parent_id = $_POST['parent_id'];
		$type = $_POST['type'];
		$name = addslashes($_POST['name']);
		$description = addslashes($_POST['description']);
		$assigned_to_id = $_POST['assigned_to_id'];
		$due_date = $_POST['due_date'];
		$last_modified = date('Y-m-d H:i:s');

		mysqli_query( $conn,"UPDATE tbl_library SET type='". $type ."', name='". $name ."', description='". $description ."', assigned_to_id='". $assigned_to_id ."', due_date='". $due_date ."', last_modified='". $last_modified ."' WHERE ID='". $parent_id ."'" );
		if (!mysqli_error($conn)) {
			$output = array(
				'ID' => $parent_id,
				'type' => $type,
				'name' => stripcslashes($name),
				'description' => stripcslashes($description)
			);
			echo json_encode($output);
		}

		mysqli_close($conn);
	}

	if( isset($_GET['modalComment']) ) {
		$id = $_GET['modalComment'];

		echo '<input class="form-control" type="hidden" name="parent_id" value="'. $id .'" />
		<div class="form-group">
            <label class="col-md-3 control-label">Title</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="title" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Comment</label>
            <div class="col-md-8">
                <textarea class="form-control" name="comment" required></textarea>
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_POST['btnSave_Comment']) ) {
    	$current_userID = $_COOKIE['ID'];
		$parent_id = $_POST['parent_id'];
		$title = addslashes($_POST['title']);
		$comment = addslashes($_POST['comment']);

		$sql = "INSERT INTO tbl_library_comment (user_id, library_id, title, comment)
		VALUES ('$current_userID', '$parent_id', '$title', '$comment')";
		
		if (mysqli_query($conn, $sql)) {
			$last_id = mysqli_insert_id($conn);
			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_library_comment WHERE user_id="'. $current_userID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );
			if ( mysqli_num_rows($selectData) > 0 ) {
				$rowData = mysqli_fetch_array($selectData);
				$data_last_modified = $rowData['last_modified'];

	            $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $current_userID " );
	            $rowUser = mysqli_fetch_array($selectUser);
				$data_name = $rowUser['first_name'] .' '. $rowUser['last_name'];

				$selectUserInfo = mysqli_query( $conn,'SELECT * FROM tbl_user_info WHERE user_id="'. $current_userID .'"' );
				$rowDataUserInfo = mysqli_fetch_array($selectUserInfo);
				$data_avatar = $rowDataUserInfo['avatar'];

				$output = array(
					"parent_id" => $parent_id,
					"name" => $data_name,
					"date" => $data_last_modified,
					"title" => stripcslashes($title),
					"comment" => stripcslashes($comment),
					"avatar" => $data_avatar
				);
			}
		}
		mysqli_close($conn);

		echo json_encode($output);
	}

	if( isset($_GET['modalCompliance']) ) {
		$id = $_GET['modalCompliance'];
		$current_userID = $_COOKIE['ID'];

		echo '<input class="form-control" type="hidden" name="parent_id" value="'. $id .'" />
        <div class="form-group">
            <label class="col-md-3 control-label">Requirements</label>
            <div class="col-md-8">
            	<input type="text" class="form-control tagsinput" id="requirements" name="requirements" data-role="tagsinput" required />
                <span class="form-text text-muted">Enter multiple requirements separated by comma</span>
            </div>
        </div>
		<div class="form-group">
            <label class="col-md-3 control-label">Compliance Action Items</label>
            <div class="col-md-8">
            	<input type="text" class="form-control tagsinput" id="action_items" name="action_items" data-role="tagsinput" required />
                <span class="form-text text-muted">Enter multiple action items separated by comma</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Frequency</label>
            <div class="col-md-8">
            	<select class="form-control" name="frequency" onchange="changedFrequency(this.value)" required>
            		<option>Select</option>
            		<option value="1">Daily</option>
            		<option value="2">Weekly</option>
            		<option value="3">Monthly</option>
            		<option value="4">Yearly</option>
            	</select>
            </div>
        </div>
        <div class="form-group hide frequency frequency-container">
            <label class="col-md-3 control-label">Select Schedule</label>
            <div class="col-md-8" style="display: flex;">
		        <input class="form-control hide frequency frequency-time" name="time" type="time" />

				<select class="form-control hide frequency frequency-days" name="days">
					<option value>Select Day</option>
					<option value="1">Monday</option>
					<option value="2">Tuesday</option>
					<option value="3">Wednesday</option>
					<option value="4">Thursday</option>
					<option value="5">Friday</option>
					<option value="6">Saturday</option>
					<option value="7">Sunday</option>
				</select>

				<select class="form-control hide frequency frequency-day" name="day">
					<option value>Select Day</option>';

					for ($i=1; $i <= 28; $i++) {
						echo '<option value="'. $i .'">'. $i.date("S", mktime(0, 0, 0, 0, $i, 0)) .'</option>';
					}

				echo '</select>

		        <select class="form-control hide frequency frequency-month" name="month">
		        	<option value>Select Month</option>
		        	<option value="1">January</option>
		        	<option value="2">February</option>
		        	<option value="3">March</option>
		        	<option value="4">April</option>
		        	<option value="5">May</option>
		        	<option value="6">June</option>
		        	<option value="7">July</option>
		        	<option value="8">August</option>
		        	<option value="9">September</option>
		        	<option value="10">October</option>
		        	<option value="11">November</option>
		        	<option value="12">December</option>
		        </select>
            </div>
        </div>
        <div class="form-group">
            <p class="col-md-offset-3 col-md-8"><strong>ASSIGNED TO</strong></p>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">To be Performed By</label>
            <div class="col-md-8">
                <select class="form-control mt-multiselect btn btn-default" name="assigned_to_perform">
                	<option value="">Select Performer</option>';
                    
                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $current_userID" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                            echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        }
                    } else {
                        echo '<option disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">To be Verified By</label>
            <div class="col-md-8">
                <select class="form-control mt-multiselect btn btn-default" name="assigned_to_verify">
                	<option value="">Select Verifier</option>';
                    
                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $current_userID" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                            echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        }
                    } else {
                        echo '<option disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">To be Reviewed By</label>
            <div class="col-md-8">
                <select class="form-control mt-multiselect btn btn-default" name="assigned_to_review">
                	<option value="">Select Reviewer</option>';
                    
                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $current_userID" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                            echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        }
                    } else {
                        echo '<option disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_POST['btnSave_Compliance']) ) {
    	$current_userID = $_COOKIE['ID'];
		$parent_id = $_POST['parent_id'];
		$action_items = $_POST['action_items'];
		$requirements = $_POST['requirements'];
		$frequency = $_POST['frequency'];
		$time = $_POST['time'];
		$days = $_POST['days'];
		$day = $_POST['day'];
		$month = $_POST['month'];

		$frequency_id = array();
		array_push($frequency_id, $time);
		array_push($frequency_id, $days);
		array_push($frequency_id, $day);
		array_push($frequency_id, $month);
		$frequency_id = implode(", ",$frequency_id);


		$assigned_to_perform = $_POST['assigned_to_perform'];
		$assigned_to_verify = $_POST['assigned_to_verify'];
		$assigned_to_review = $_POST['assigned_to_review'];

		$assigned_to_id = array();
		array_push($assigned_to_id, $assigned_to_perform);
		array_push($assigned_to_id, $assigned_to_verify);
		array_push($assigned_to_id, $assigned_to_review);
		$assigned_to_id = implode(", ",$assigned_to_id);

		$sql = "INSERT INTO tbl_library_compliance (user_id, library_id, action_items, requirements, frequency, schedule, assigned_to_id)
		VALUES ('$current_userID', '$parent_id', '$action_items', '$requirements', '$frequency', '$frequency_id', '$assigned_to_id')";
		
		if (mysqli_query($conn, $sql)) {
			$last_id = mysqli_insert_id($conn);
			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_library_compliance WHERE user_id="'. $current_userID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );
			if ( mysqli_num_rows($selectData) > 0 ) {
				$rowData = mysqli_fetch_array($selectData);
                $compliance_frequency = $rowData['frequency'];
                $compliance_schedule_id = $rowData['schedule'];
                $array_schedule_id = explode(", ", $compliance_schedule_id);
				$days = array(
	                1 => 'Monday',
	                2 => 'Tuesday',
	                3 => 'Wednesday',
	                4 => 'Thursday',
	                5 => 'Friday',
	                6 => 'Saturday',
	                7 => 'Sunday'
	            );

				if ( count($array_schedule_id) == 4 ) {
                    $time=date_create($array_schedule_id[0]);

                    if ($compliance_frequency == 1) {             // Daily
                        $frequency = 'Every '. date_format($time,"g:i A") .' daily';
                    } else if ($compliance_frequency == 2) {      // Weekly
                        $frequency = 'Every '. $days[3] .' at '. date_format($time,"g:i A");
                    } else if ($compliance_frequency == 3) {      // Monthly
                        $frequency = 'Every '. $array_schedule_id[2].date("S", mktime(0, 0, 0, 0, $array_schedule_id[2], 0)) .' day of the Month at '. date_format($time,"g:i A");
                    } else if ($compliance_frequency == 4) {      // Yearly
                        $frequency = 'Every '. $array_schedule_id[2].date("S", mktime(0, 0, 0, 0, $array_schedule_id[2], 0)) .' day of '. date("F", mktime(0, 0, 0, $array_schedule_id[3]+1, 0, 0)) .' at '. date_format($time,"g:i A");
                    }
                } else {
                    $frequency = $compliance_frequency;
                }

				$output = array(
					"last_id" => $last_id,
					"parent_id" => $parent_id,
					"requirements" => $requirements,
					"action_items" => $action_items,
					"frequency" => $frequency
				);
			}
		}
		mysqli_close($conn);

		echo json_encode($output);
	}

	if( isset($_GET['modalCompliance_Edit']) ) {
		$id = $_GET['modalCompliance_Edit'];
    	$current_userID = $_COOKIE['ID'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_library_compliance WHERE ID = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
            $frequency = $row['frequency'];
            $schedule_id = $row['schedule'];
            $assigned_to_id = $row["assigned_to_id"];
            $array_schedule_id = explode(", ", $schedule_id);
            $array_assigned_to_id = explode(", ", $assigned_to_id);
        }

		echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
		<input class="form-control" type="hidden" name="parent_id" value="'. $row['library_id'] .'" />
		<div class="form-group">
            <label class="col-md-3 control-label">Requirements</label>
            <div class="col-md-8">
            	<input type="text" class="form-control tagsinput" id="requirements" name="requirements" data-role="tagsinput" value="'. $row['requirements'] .'" required />
                <span class="form-text text-muted">Enter multiple requirements separated by comma</span>
            </div>
        </div>
		<div class="form-group">
            <label class="col-md-3 control-label">Compliance Action Items</label>
            <div class="col-md-8">
            	<input type="text" class="form-control tagsinput" id="action_items" name="action_items" data-role="tagsinput" value="'. $row['action_items'] .'" required />
                <span class="form-text text-muted">Enter multiple action items separated by comma</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Frequency</label>
            <div class="col-md-8">
            	<select class="form-control" name="frequency" onchange="changedFrequency(this.value)" required>
            		<option>Select</option>
            		<option value="1" '; echo $frequency == 1 ? 'SELECTED' : ''; echo '>Daily</option>
            		<option value="2" '; echo $frequency == 2 ? 'SELECTED' : ''; echo '>Weekly</option>
            		<option value="3" '; echo $frequency == 3 ? 'SELECTED' : ''; echo '>Monthly</option>
            		<option value="4" '; echo $frequency == 4 ? 'SELECTED' : ''; echo '>Yearly</option>
            	</select>
            </div>
        </div>
        <div class="form-group frequency frequency-container '; echo empty($frequency) ? 'hide' : ''; echo '">
            <label class="col-md-3 control-label">Select Schedule</label>
            <div class="col-md-8" style="display: flex;">
		        <input class="form-control frequency frequency-time '; echo empty($array_schedule_id[0]) ? 'hide' : ''; echo '" name="time" type="time" value="'. $array_schedule_id[0] .'" />

				<select class="form-control frequency frequency-days '; echo empty($array_schedule_id[1]) ? 'hide' : ''; echo '" name="days">
					<option value>Select Day</option>
					<option value="1" '; echo $array_schedule_id[1] == 1 ? 'SELECTED' : ''; echo '>Monday</option>
					<option value="2" '; echo $array_schedule_id[1] == 2 ? 'SELECTED' : ''; echo '>Tuesday</option>
					<option value="3" '; echo $array_schedule_id[1] == 3 ? 'SELECTED' : ''; echo '>Wednesday</option>
					<option value="4" '; echo $array_schedule_id[1] == 4 ? 'SELECTED' : ''; echo '>Thursday</option>
					<option value="5" '; echo $array_schedule_id[1] == 5 ? 'SELECTED' : ''; echo '>Friday</option>
					<option value="6" '; echo $array_schedule_id[1] == 6 ? 'SELECTED' : ''; echo '>Saturday</option>
					<option value="7" '; echo $array_schedule_id[1] == 7 ? 'SELECTED' : ''; echo '>Sunday</option>
				</select>

				<select class="form-control frequency frequency-day '; echo empty($array_schedule_id[2]) ? 'hide' : ''; echo '" name="day">
					<option value>Select Day</option>';

					for ($i=1; $i <= 28; $i++) {
						echo '<option value="'. $i .'" '; echo $array_schedule_id[2] == $i ? 'SELECTED' : ''; echo '>'. $i.date("S", mktime(0, 0, 0, 0, $i, 0)) .'</option>';
					}

				echo '</select>

		        <select class="form-control frequency frequency-month '; echo empty($array_schedule_id[3]) ? 'hide' : ''; echo '" name="month">
		        	<option value>Select Month</option>
		        	<option value="1" '; echo $array_schedule_id[3] == 1 ? 'SELECTED' : ''; echo '>January</option>
		        	<option value="2" '; echo $array_schedule_id[3] == 2 ? 'SELECTED' : ''; echo '>February</option>
		        	<option value="3" '; echo $array_schedule_id[3] == 3 ? 'SELECTED' : ''; echo '>March</option>
		        	<option value="4" '; echo $array_schedule_id[3] == 4 ? 'SELECTED' : ''; echo '>April</option>
		        	<option value="5" '; echo $array_schedule_id[3] == 5 ? 'SELECTED' : ''; echo '>May</option>
		        	<option value="6" '; echo $array_schedule_id[3] == 6 ? 'SELECTED' : ''; echo '>June</option>
		        	<option value="7" '; echo $array_schedule_id[3] == 7 ? 'SELECTED' : ''; echo '>July</option>
		        	<option value="8" '; echo $array_schedule_id[3] == 8 ? 'SELECTED' : ''; echo '>August</option>
		        	<option value="9" '; echo $array_schedule_id[3] == 9 ? 'SELECTED' : ''; echo '>September</option>
		        	<option value="10" '; echo $array_schedule_id[3] == 10 ? 'SELECTED' : ''; echo '>October</option>
		        	<option value="11" '; echo $array_schedule_id[3] == 11 ? 'SELECTED' : ''; echo '>November</option>
		        	<option value="12" '; echo $array_schedule_id[3] == 12 ? 'SELECTED' : ''; echo '>December</option>
		        </select>
            </div>
        </div>
        <div class="form-group">
            <p class="col-md-offset-3 col-md-8"><strong>ASSIGNED TO</strong></p>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">To be Performed By</label>
            <div class="col-md-8">
                <select class="form-control mt-multiselect btn btn-default" name="assigned_to_perform">
                	<option value="">Select Performer</option>';
                    
                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $current_userID" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                            if ($array_assigned_to_id[0] == $rowEmployee["ID"]) {
                        		echo '<option value="'. $rowEmployee["ID"] .'" SELECTED>'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        	} else {
                        		echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        	}
                        }
                    } else {
                        echo '<option disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">To be Verified By</label>
            <div class="col-md-8">
                <select class="form-control mt-multiselect btn btn-default" name="assigned_to_verify">
                	<option value="">Select Verifier</option>';
                    
                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $current_userID" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                            if ($array_assigned_to_id[1] == $rowEmployee["ID"]) {
                        		echo '<option value="'. $rowEmployee["ID"] .'" SELECTED>'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        	} else {
                        		echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        	}
                        }
                    } else {
                        echo '<option disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">To be Reviewed By</label>
            <div class="col-md-8">
                <select class="form-control mt-multiselect btn btn-default" name="assigned_to_review">
                	<option value="">Select Reviewer</option>';
                    
                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $current_userID" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                            if ($array_assigned_to_id[2] == $rowEmployee["ID"]) {
                        		echo '<option value="'. $rowEmployee["ID"] .'" SELECTED>'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        	} else {
                        		echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        	}
                        }
                    } else {
                        echo '<option disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_POST['btnUpdate_Compliance']) ) {
    	$ID = $_POST['ID'];
		$parent_id = $_POST['parent_id'];
		$action_items = $_POST['action_items'];
		$requirements = $_POST['requirements'];
		$frequency = $_POST['frequency'];
		$time = $_POST['time'];
		$days = $_POST['days'];
		$day = $_POST['day'];
		$month = $_POST['month'];
		$last_modified = date('Y-m-d');

		$frequency_id = array();
		array_push($frequency_id, $time);
		array_push($frequency_id, $days);
		array_push($frequency_id, $day);
		array_push($frequency_id, $month);
		$frequency_id = implode(", ",$frequency_id);

		mysqli_query( $conn,"UPDATE tbl_library_compliance SET action_items='". $action_items ."', requirements='". $requirements ."', frequency='". $frequency ."', schedule='". $frequency_id ."', last_modified='". $last_modified ."' WHERE ID='". $ID ."'" );

		$selectData = mysqli_query( $conn,'SELECT * FROM tbl_library_compliance WHERE ID="'. $ID .'" ORDER BY ID LIMIT 1' );
		if ( mysqli_num_rows($selectData) > 0 ) {
			$rowData = mysqli_fetch_array($selectData);
            $compliant = $rowData['compliant'];
            $compliance_frequency = $rowData['frequency'];
            $compliance_schedule_id = $rowData['schedule'];
            $array_schedule_id = explode(", ", $compliance_schedule_id);
			$days = array(
                1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
                6 => 'Saturday',
                7 => 'Sunday'
            );

			if ( count($array_schedule_id) == 4 ) {
                $time=date_create($array_schedule_id[0]);

                if ($compliance_frequency == 1) {             // Daily
                    $frequency = 'Every '. date_format($time,"g:i A") .' daily';
                } else if ($compliance_frequency == 2) {      // Weekly
                    $frequency = 'Every '. $days[3] .' at '. date_format($time,"g:i A");
                } else if ($compliance_frequency == 3) {      // Monthly
                    $frequency = 'Every '. $array_schedule_id[2].date("S", mktime(0, 0, 0, 0, $array_schedule_id[2], 0)) .' day of the Month at '. date_format($time,"g:i A");
                } else if ($compliance_frequency == 4) {      // Yearly
                    $frequency = 'Every '. $array_schedule_id[2].date("S", mktime(0, 0, 0, 0, $array_schedule_id[2], 0)) .' day of '. date("F", mktime(0, 0, 0, $array_schedule_id[3]+1, 0, 0)) .' at '. date_format($time,"g:i A");
                }
            } else {
                $frequency = $compliance_frequency;
            }

			$output = array(
				"ID" => $ID,
				"parent_id" => $parent_id,
				"requirements" => $requirements,
				"action_items" => $action_items,
				"compliant" => $compliant,
				"frequency" => $frequency
			);
			echo json_encode($output);
		}
		mysqli_close($conn);
	}

	if( isset($_GET['btnDelete_Compliance']) ) {
		$id = $_GET['btnDelete_Compliance'];
		$reason = $_GET['reason'];

		mysqli_query( $conn,"UPDATE tbl_library_compliance SET deleted = 1, reason = '". $reason ."' WHERE ID='". $id ."'" );

		$output = array(
			"ID" => $id
		);
	    echo json_encode($output);
	}

	if( isset($_GET['compliant']) ) {
		$id = $_GET['compliant'];
		$val = $_GET['v'];

		mysqli_query( $conn,"UPDATE tbl_library_compliance SET compliant='". $val ."' WHERE ID='". $id ."'" );
	}

	if( isset($_GET['modalAttached']) ) {
		$id = $_GET['modalAttached'];
		$current_userID = $_COOKIE['ID'];

		echo '<input class="form-control" type="hidden" name="parent_id" value="'. $id .'" />
		<div class="form-group">
            <label class="col-md-3 control-label">Select File</label>
            <div class="col-md-8">
                <input class="form-control" type="file" name="file" required />
            </div>
        </div>
		<div class="form-group">
            <label class="col-md-3 control-label">File Name</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="name" required />
            </div>
        </div>
		<div class="form-group">
            <label class="col-md-3 control-label">Document Date</label>
            <div class="col-md-8">
                <input class="form-control" type="date" name="last_modified" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Due Date</label>
            <div class="col-md-8">
                <input class="form-control" type="date" name="due_date" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Comment</label>
            <div class="col-md-8">
                <textarea class="form-control" name="comment" required></textarea>
            </div>
        </div>
        <div class="form-group">
            <p class="col-md-offset-3 col-md-8"><strong>ASSIGNED TO</strong></p>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Drafted By</label>
            <div class="col-md-8">
                <select class="form-control mt-multiselect btn btn-default" name="assigned_to_drafting">
                	<option value="">Select Drafter</option>';
                    
                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $current_userID" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                            echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        }
                    } else {
                        echo '<option disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Reviewed By</label>
            <div class="col-md-8">
                <select class="form-control mt-multiselect btn btn-default" name="assigned_to_reviewer">
                	<option value="">Select Reviewer</option>';
                    
                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $current_userID" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                            echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        }
                    } else {
                        echo '<option disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Approved</label>
            <div class="col-md-8">
                <select class="form-control mt-multiselect btn btn-default" name="assigned_to_approver">
                	<option value="">Select Approver</option>';
                    
                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $current_userID" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                            echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        }
                    } else {
                        echo '<option disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_POST['btnSave_Attached']) ) {
    	$current_userID = $_COOKIE['ID'];
		$parent_id = $_POST['parent_id'];
		$name = addslashes($_POST['name']);
		$comment = addslashes($_POST['comment']);
		$last_modified = $_POST['last_modified'];
		$due_date = $_POST['due_date'];
		$files = "";
		$success = true;

		$assigned_to_drafting = $_POST['assigned_to_drafting'];
		$assigned_to_reviewer = $_POST['assigned_to_reviewer'];
		$assigned_to_approver = $_POST['assigned_to_approver'];

		$assigned_to_id = array();
		array_push($assigned_to_id, $assigned_to_drafting);
		array_push($assigned_to_id, $assigned_to_reviewer);
		array_push($assigned_to_id, $assigned_to_approver);
		$assigned_to_id = implode(", ",$assigned_to_id);

		$assigned_to_name = array();
		$selectDataDraft = mysqli_query( $conn,'SELECT * FROM tbl_hr_employee WHERE ID="'. $assigned_to_drafting .'"' );
		if ( mysqli_num_rows($selectDataDraft) > 0 ) {
			$rowDataDraft = mysqli_fetch_array($selectDataDraft);
			$name_draft = $rowDataDraft['first_name'] .' '. $rowDataDraft['last_name'];

			array_push($assigned_to_name, $name_draft .' (Drafter)');
		}
		$selectDataReview = mysqli_query( $conn,'SELECT * FROM tbl_hr_employee WHERE ID="'. $assigned_to_reviewer .'"' );
		if ( mysqli_num_rows($selectDataReview) > 0 ) {
			$rowDataReview = mysqli_fetch_array($selectDataReview);
			$name_review = $rowDataReview['first_name'] .' '. $rowDataReview['last_name'];
			
			array_push($assigned_to_name, $name_review .' (Reviewer)');
		}
		$selectDataApprove = mysqli_query( $conn,'SELECT * FROM tbl_hr_employee WHERE ID="'. $assigned_to_approver .'"' );
		if ( mysqli_num_rows($selectDataApprove) > 0 ) {
			$rowDataApprove = mysqli_fetch_array($selectDataApprove);
			$name_approve = $rowDataApprove['first_name'] .' '. $rowDataApprove['last_name'];
			
			array_push($assigned_to_name, $name_approve .' (Approver)');
		}
		$assigned_to_name = implode(", ",$assigned_to_name);

		if( !empty( $_FILES['file']['name'] ) ) {
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
			$path = 'uploads/library/'; // upload directory
			$file = $_FILES['file']['name'];
			$tmp = $_FILES['file']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_file = rand(1000,1000000).' - '.$file;
			// check's valid format
			// if(in_array($ext, $valid_extensions)) {
				$files = $final_file;
				$path = $path.$final_file;
				if(move_uploaded_file($tmp,$path)) {
					$success = true;
				}
			// } else {
			// 	$success = false;
			// }
		}

		if ($success == true) {

			$sql = "INSERT INTO tbl_library_file (user_id, library_id, type, files, name, comment, assigned_to_id, due_date, last_modified)
			VALUES ('$current_userID', '$parent_id', '1', '$files', '$name', '$comment', '$assigned_to_id', '$due_date', '$last_modified')";
		
			if (mysqli_query($conn, $sql)) {
				$last_id = mysqli_insert_id($conn);

				// Save copy to User Task
				$task = $name .' - '. $comment;
				$sql = "INSERT INTO tbl_user_task (user_id, type, target_id, task, assigned_to_id, due_date)
				VALUES ( '$current_userID', '2', '$last_id', '$task', '$assigned_to_id', '$due_date' )";
				mysqli_query($conn, $sql);

				$selectData = mysqli_query( $conn,'SELECT * FROM tbl_library_file WHERE user_id="'. $current_userID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );
				if ( mysqli_num_rows($selectData) > 0 ) {
					$rowData = mysqli_fetch_array($selectData);
					$data_ID = $rowData['ID'];
					$data_user_id = $rowData['user_id'];
					$data_library_id = $rowData['library_id'];
					$data_files = $rowData['files'];
					$data_name = $rowData['name'];
					$data_comment = $rowData['comment'];
					$data_due_date = $rowData['due_date'];
					$data_last_modified = $rowData['last_modified'];

					$output = array(
						'ID' => $data_ID,
						'user_id' => $data_user_id,
						'parent_id' => $data_library_id,
						'files' => $data_files,
						'name' => $data_name,
						'comment' => $data_comment,
						'assigned' => $assigned_to_name,
						'last_modified' => $data_last_modified,
						'due_date' => $data_due_date
					);
					echo json_encode($output);
				}
			}
			mysqli_close($conn);
		}
	}

	if( isset($_GET['modalAttached_Edit']) ) {
		global $current_userEmployeeID;

		$id = $_GET['modalAttached_Edit'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_library_file WHERE ID = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
            $current_userID = $_COOKIE['ID'];
            $user_id = $row["user_id"];
            $comment = $row["comment"];
            $assigned_to_action = $row["assigned_to_action"];
            $assigned_to_files = $row["assigned_to_files"];
            $assigned_to_id = $row["assigned_to_id"];
            $array_assigned_to_id = explode(", ", $assigned_to_id);
        }

		echo '<input class="form-control" type="hidden" name="ID" value="'. $row['ID'] .'" />
		<input class="form-control" type="hidden" name="user_id" value="'. $user_id .'" />
		<input class="form-control" type="hidden" name="parent_id" value="'. $row['library_id'] .'" />
		<div class="form-group">
            <label class="col-md-3 control-label">Select File</label>
            <div class="col-md-8">
                <input class="form-control" type="file" name="file"'; echo $user_id != $current_userID ? 'required' : ''; echo '/>
            </div>
        </div>
		<div class="form-group">
            <label class="col-md-3 control-label">File Name</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="name" value="'. $row['name'] .'" required />
            </div>
        </div>
		<div class="form-group">
            <label class="col-md-3 control-label">Document Date</label>
            <div class="col-md-8">
                <input class="form-control" type="date" name="last_modified" value="'. $row['last_modified'] .'" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Due Date</label>
            <div class="col-md-8">
                <input class="form-control" type="date" name="due_date" value="'. $row['due_date'] .'" required />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Select Action</label>
            <div class="col-md-8">
                <select class="form-control" name="assigned_to_action" required>
                	<option value="">Select</option>
                	<option value="0" '; echo $assigned_to_action == 0 ? 'SELECTED' : ''; echo '>For Drafting</option>
                	<option value="1" '; echo $assigned_to_action == 1 ? 'SELECTED' : ''; echo '>For Reviewing</option>
                	<option value="2" '; echo $assigned_to_action == 2 ? 'SELECTED' : ''; echo '>For Approval</option>
                	<option value="3" '; echo $assigned_to_action == 3 ? 'SELECTED' : ''; echo '>Completed</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Comment</label>
            <div class="col-md-8">
                <textarea class="form-control" name="comment"'; echo $user_id != $current_userID ? 'required' : ''; echo '>'; echo $user_id == $current_userID ? $comment : ''; echo '</textarea>
            </div>
        </div>';

        $selectDataUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $current_userID" );
        if ( mysqli_num_rows($selectDataUser) > 0 ) {
        	$rowUser = mysqli_fetch_array($selectDataUser);
        	$current_userEmployeeID = $rowUser["employee_id"];

	        if ($current_userEmployeeID != 0) {
	        	$selectDataEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $current_userEmployeeID" );
	        	if ( mysqli_num_rows($selectDataEmployee) > 0 ) {
	        		$rowFile = mysqli_fetch_array($selectDataEmployee);
	        		$user_id = $rowFile["user_id"];
	        	}
	        } else {
	        	$user_id = $current_userID;
	        }
        }
        
        echo '<div class="form-group" '. $assigned_to_files .' '. $user_id .'>
            <p class="col-md-offset-3 col-md-8"><strong>ASSIGNED TO</strong></p>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Drafted By</label>
            <div class="col-md-8">
                <select class="form-control mt-multiselect btn btn-default" name="assigned_to_drafting">
                	<option value="">Select Drafter</option>';
                    
                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $user_id" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                        	if ($array_assigned_to_id[0] == $rowEmployee["ID"]) {
                        		echo '<option value="'. $rowEmployee["ID"] .'" SELECTED>'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        	} else {
                        		echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        	}
                        }
                    } else {
                        echo '<option disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Reviewed By</label>
            <div class="col-md-8">
                <select class="form-control mt-multiselect btn btn-default" name="assigned_to_reviewer">
                	<option value="">Select Reviewer</option>';
                    
                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $user_id" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                            if ($array_assigned_to_id[1] == $rowEmployee["ID"]) {
                        		echo '<option value="'. $rowEmployee["ID"] .'" SELECTED>'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        	} else {
                        		echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        	}
                        }
                    } else {
                        echo '<option disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Approved By</label>
            <div class="col-md-8">
                <select class="form-control mt-multiselect btn btn-default" name="assigned_to_approver">
                	<option value="">Select Approver</option>';
                    
                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $user_id" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                            if ($array_assigned_to_id[2] == $rowEmployee["ID"]) {
                        		echo '<option value="'. $rowEmployee["ID"] .'" SELECTED>'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        	} else {
                        		echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                        	}
                        }
                    } else {
                        echo '<option disabled>No Available</option>';
                    }

                echo '</select>
            </div>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_POST['btnUpdate_Attached']) ) {
    	$current_userID = $_COOKIE['ID'];
    	$ID = $_POST['ID'];
		$user_id = $_POST['user_id'];
		$parent_id = $_POST['parent_id'];
		$name = addslashes($_POST['name']);
		$comment = addslashes($_POST['comment']);
		$assigned_to_action = $_POST['assigned_to_action'];
		$last_modified = $_POST['last_modified'];
		$due_date = $_POST['due_date'];
		$files = "";
		$success = true;
		$last_id = 0;
		$data_task_ID = 0;

		// if ($user_id == $current_userID) {
			$assigned_to_drafting = $_POST['assigned_to_drafting'];
			$assigned_to_reviewer = $_POST['assigned_to_reviewer'];
			$assigned_to_approver = $_POST['assigned_to_approver'];


			$assigned_to_id = array();
			array_push($assigned_to_id, $assigned_to_drafting);
			array_push($assigned_to_id, $assigned_to_reviewer);
			array_push($assigned_to_id, $assigned_to_approver);
			$assigned_to_id = implode(", ",$assigned_to_id);


			$assigned_to_name = array();
			$selectDataDraft = mysqli_query( $conn,'SELECT * FROM tbl_hr_employee WHERE ID="'. $assigned_to_drafting .'"' );
			if ( mysqli_num_rows($selectDataDraft) > 0 ) {
				$rowDataDraft = mysqli_fetch_array($selectDataDraft);
				$name_draft = $rowDataDraft['first_name'] .' '. $rowDataDraft['last_name'];

				array_push($assigned_to_name, $name_draft .' (Drafter)');
			}
			$selectDataReview = mysqli_query( $conn,'SELECT * FROM tbl_hr_employee WHERE ID="'. $assigned_to_reviewer .'"' );
			if ( mysqli_num_rows($selectDataReview) > 0 ) {
				$rowDataReview = mysqli_fetch_array($selectDataReview);
				$name_review = $rowDataReview['first_name'] .' '. $rowDataReview['last_name'];
				
				array_push($assigned_to_name, $name_review .' (Reviewer)');
			}
			$selectDataApprove = mysqli_query( $conn,'SELECT * FROM tbl_hr_employee WHERE ID="'. $assigned_to_approver .'"' );
			if ( mysqli_num_rows($selectDataApprove) > 0 ) {
				$rowDataApprove = mysqli_fetch_array($selectDataApprove);
				$name_approve = $rowDataApprove['first_name'] .' '. $rowDataApprove['last_name'];
				
				array_push($assigned_to_name, $name_approve .' (Approver)');
			}
			$assigned_to_name = implode(", ",$assigned_to_name);
		// }

		if( !empty( $_FILES['file']['name'] ) ) {
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
			$path = 'uploads/library/'; // upload directory
			$file = $_FILES['file']['name'];
			$tmp = $_FILES['file']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_file = rand(1000,1000000).' - '.$file;
			// check's valid format
			// if(in_array($ext, $valid_extensions)) {
				$files = $final_file;
				$path = $path.$final_file;
				if(move_uploaded_file($tmp,$path)) {
					$success = true;
				}
			// } else {
			// 	$success = false;
			// }
		}
 
		if ($success == true) {

			// Update function only else treat as new file
			if ($user_id == $current_userID) {
				if ( !empty($files) ) {
					mysqli_query( $conn,"UPDATE tbl_library_file SET files='". $files ."', name='". $name ."', comment='". $comment ."', assigned_to_id='". $assigned_to_id ."', assigned_to_action='". $assigned_to_action ."', due_date='". $due_date ."', last_modified='". $last_modified ."' WHERE ID='". $ID ."'" );
				} else {
					mysqli_query( $conn,"UPDATE tbl_library_file SET name='". $name ."', comment='". $comment ."', assigned_to_id='". $assigned_to_id ."', assigned_to_action='". $assigned_to_action ."', due_date='". $due_date ."', last_modified='". $last_modified ."' WHERE ID='". $ID ."'" );
				}

				// Update Copy for User task
				$task = $name .' - '. $comment;
				mysqli_query( $conn,"UPDATE tbl_user_task SET task='". $task ."', assigned_to_id='". $assigned_to_id ."', due_date='". $due_date ."' WHERE target_id='". $ID ."'" );

				$last_id = $ID;
				$new = 0;
			} else {
				if ( !empty($files) ) {
					$sql = "INSERT INTO tbl_library_file (user_id, library_id, type, files, name, comment, assigned_to_id, assigned_to_files, assigned_to_action, due_date, last_modified)
					VALUES ('$current_userID', '$parent_id', '1', '$files', '$name', '$comment', '$assigned_to_id', '$ID', '$assigned_to_action', '$due_date', '$last_modified')";
					if (mysqli_query($conn, $sql)) {
						$last_id = mysqli_insert_id($conn);
						$new = 1;

						// Update and Save New Copy for User task
						mysqli_query( $conn,"UPDATE tbl_user_task SET is_completed='1' WHERE target_id='". $ID ."'" );

						$task = $name .' - '. $comment;
						$sql = "INSERT INTO tbl_user_task (user_id, type, target_id, task, assigned_to_id, due_date)
						VALUES ( '$current_userID', '2', '$last_id', '$task', '$assigned_to_id', '$due_date' )";
						mysqli_query($conn, $sql);

						// mysqli_query( $conn,"UPDATE tbl_user_task SET target_id='". $last_id ."', task='". $task ."', due_date='". $due_date ."' WHERE target_id='". $ID ."'" );
					}
				}
			}

			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_library_file WHERE user_id="'. $current_userID .'" AND ID="'. $last_id .'" ORDER BY ID LIMIT 1' );
			if ( mysqli_num_rows($selectData) > 0 ) {
				$rowData = mysqli_fetch_array($selectData);
				$data_ID = $rowData['ID'];
				$data_user_id = $rowData['user_id'];
				$data_library_id = $rowData['library_id'];
				$data_files = $rowData['files'];
				$data_name = $rowData['name'];
				$data_comment = $rowData['comment'];
				$data_assigned_to_files = $rowData['assigned_to_files'];
				$data_assigned_to_action = $rowData['assigned_to_action'];
				$data_due_date = $rowData['due_date'];
				$data_last_modified = $rowData['last_modified'];

				if (!empty($data_assigned_to_files)) {
					
					$selectDataAssigned = mysqli_query( $conn,'SELECT * FROM tbl_library_file WHERE ID="'. $data_assigned_to_files .'" ORDER BY ID LIMIT 1' );
					if ( mysqli_num_rows($selectDataAssigned) > 0 ) {
						$rowDataAssigned = mysqli_fetch_array($selectDataAssigned);
						$data_assigned_to_id = $rowDataAssigned['assigned_to_id'];
			            $array_assigned_to_id = explode(", ", $data_assigned_to_id);
			            
			            if (!empty($array_assigned_to_id[$data_assigned_to_action])) {
			            	$selectDataAssigned = mysqli_query( $conn,'SELECT * FROM tbl_hr_employee WHERE ID="'. $array_assigned_to_id[$data_assigned_to_action] .'"' );
	                        if ( mysqli_num_rows($selectDataAssigned) > 0 ) {
	                            $rowDataAssigned = mysqli_fetch_array($selectDataAssigned);
	                            $assigned_to_name = $rowDataAssigned['first_name'] .' '. $rowDataAssigned['last_name'];
	                        }
			            } else {
			            	$assigned_to_name = "NA / Completed";
			            }
                    }
				}
			}

			$selectDataTask = mysqli_query( $conn,'SELECT * FROM tbl_user_task WHERE target_id="'. $last_id .'" ORDER BY ID LIMIT 1' );
			if ( mysqli_num_rows($selectDataTask) > 0 ) {
				$rowDataTask = mysqli_fetch_array($selectDataTask);
				$data_task_ID = $rowDataTask['ID'];
			}

			$output = array(
				'ID' => $data_ID,
				'user_id' => $data_user_id,
				'parent_id' => $data_library_id,
				'files' => $data_files,
				'name' => $data_name,
				'comment' => $data_comment,
				'assigned' => $assigned_to_name,
				'last_modified' => $data_last_modified,
				'due_date' => $data_due_date,
				'new' => $new,
				'data_task_ID' => $data_task_ID,

			);
			echo json_encode($output);
			mysqli_close($conn);
		}
	}

	if( isset($_GET['btnDelete_File']) ) {
		$id = $_GET['btnDelete_File'];
		$reason = $_GET['reason'];

		mysqli_query( $conn,"UPDATE tbl_library_file SET reason = '". $reason ."' WHERE ID='". $id ."'" );

		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_library_file WHERE ID = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
            $files = $row['files'];
            $reason = $row['reason'];
        }

		$to = 'greeggimongala@gmail.com';
		$user = 'Interlink IQ';
		$subject = 'Request to delete file in the Dashboard';
		$body = 'Hi '. $user .', please check '. $files .' in the Dashboard with ID #'. $id .' for deletion approval. The reason is: '. $reason;

		$mail = php_mailer($to, $user, $subject, $body);

		$output = array(
			"ID" => $id
		);
	    echo json_encode($output);
	}

	if( isset($_GET['modalReport']) ) {
		$id = $_GET['modalReport'];

	    echo '<div class="table-scrollable">
            <table class="table table-bordered table-hover" id="table2excel">
                <thead>
                    <tr>
                        <th>ITEM<br>NAME</th>
                        <th>ITEM<br>TYPE</th>
                        <th>LAST<br>COMMENT</th>
                        <th>DOCUMENT<br>ATTACHED</th>
                        <th>UPLOADED<br>DATE</th>
                        <th>REVIEW<br>DUE DATE</th>
                    </tr>
                </thead>
                <tbody>';

					$resultItem = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE deleted = 0 AND ID = $id" );
			        if ( mysqli_num_rows($resultItem) > 0 ) {
			            while($rowItem = mysqli_fetch_array($resultItem)) {
			                $item_ID = $rowItem["ID"];
			                $type_id = $rowItem["type"];
			                $type = "";
			                $name = $rowItem["name"];
			                $comment = "NS";
			                $files = "";
			                $files_uploaded = "";
			                $due_date = $rowItem['due_date'];
			                $new_parent_id = $rowItem["parent_id"];
			                $new_child_id = $rowItem["child_id"];
			                $reason = $rowItem["reason"];

			                $array_name_id = explode(", ", $name);
                            if ( count($array_name_id) == 4 ) {
                                $data_name = array();

                                $selectType = mysqli_query($conn,"SELECT * FROM tbl_library_type WHERE ID = '".$array_name_id[0]."'");
                                if ( mysqli_num_rows($selectType) > 0 ) {
                                    while($rowType = mysqli_fetch_array($selectType)) {
                                        array_push($data_name, $rowType["name"]);
                                    }
                                }

                                $selectCategory = mysqli_query($conn,"SELECT * FROM tbl_library_category WHERE ID = '".$array_name_id[1]."'");
                                if ( mysqli_num_rows($selectCategory) > 0 ) {
                                    while($rowCategory = mysqli_fetch_array($selectCategory)) {
                                        array_push($data_name, $rowCategory["name"]);
                                    }
                                }

                                $selectScope = mysqli_query($conn,"SELECT * FROM tbl_library_scope WHERE ID = '".$array_name_id[2]."'");
                                if ( mysqli_num_rows($selectScope) > 0 ) {
                                    while($rowScope = mysqli_fetch_array($selectScope)) {
                                        array_push($data_name, $rowScope["name"]);
                                    }
                                }

                                $selectModule = mysqli_query($conn,"SELECT * FROM tbl_library_module WHERE ID = '".$array_name_id[3]."'");
                                if ( mysqli_num_rows($selectModule) > 0 ) {
                                    while($rowModule = mysqli_fetch_array($selectModule)) {
                                        array_push($data_name, $rowModule["name"]);
                                    }
                                }

                                $name = implode(" - ",$data_name);
                            }

			                if ($type_id == 0) { $type = ""; }
			                else if ($type_id == 1) { $type = "Program"; }
			                else if ($type_id == 2) { $type = "Policy"; }
			                else if ($type_id == 3) { $type = "Procedure"; }
			                else if ($type_id == 4) { $type = "Training"; }
			                else if ($type_id == 5) { $type = "Form"; }

			                $resultItemComment = mysqli_query( $conn,"SELECT * FROM tbl_library_comment WHERE deleted = 0 AND library_id = $item_ID" );
					        if ( mysqli_num_rows($resultItemComment) > 0 ) {
					            while($rowItemComment = mysqli_fetch_array($resultItemComment)) {
					            	$comment = $rowItemComment["comment"];
					            }
					        }

			                $resultItemFile = mysqli_query( $conn,"SELECT * FROM tbl_library_file WHERE deleted = 0 AND library_id = $item_ID" );
					        if ( mysqli_num_rows($resultItemFile) > 0 ) {
					            while($rowItemComment = mysqli_fetch_array($resultItemFile)) {
					            	$files = $rowItemComment["files"];
					            	$file_comment = $rowItemComment["comment"];
					            	$files_uploaded = $rowItemComment["last_modified"];
					            }
					        }
					        
                            $url = 'uploads/library/';

			                echo '<tr>
		                        <td>'. $name .'</td>
		                        <td>'. $type .'</td>
		                        <td>'. $comment .'</td>
		                        <td><a href="'.$url.rawurlencode($files).'" target="_blank">'. $files .'</a></td>
		                        <td>'. $files_uploaded .'</td>
		                        <td>'. $due_date .'</td>
		                    </tr>';

		                    echo (itemReport($item_ID, $new_child_id));
			            }
			        } else {
			        	echo '<tr class="text-center text-default"><td colspan="6">Empty Record</td></tr>';
			        }                    
                    
                echo '</tbody>
            </table>
        </div>';

        mysqli_close($conn);
	}

	if( isset($_GET['btnClone']) ) {
		$id = $_GET['btnClone'];
		$req_user_id = 2;

		// PARENT CLONING
		$sql = "INSERT INTO tbl_library (user_id, parent_id, child_id, type, name, program, description, assigned_to_id, due_date, last_modified)
		SELECT $req_user_id, '0', '', type, name, program, description, assigned_to_id, due_date, last_modified
		FROM tbl_library
		WHERE ID = $id";

		if (mysqli_query($conn, $sql)) {
			$last_id = mysqli_insert_id($conn);

			cloneComment($req_user_id, $id, $last_id);
			cloneFile($req_user_id, $id, $last_id);

			$selectData = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE ID=$id");
			if ( mysqli_num_rows($selectData) > 0 ) {
				$rowData = mysqli_fetch_array($selectData);
				$data_child_id = $rowData['child_id'];

				// CHILD
				if (!empty($data_child_id)) {

					cloneChild($req_user_id, $id, $last_id);
					echo "done";
				}
			}
		}

        mysqli_close($conn);
	}

	function cloneChild($req_user_id, $parent_id, $last_id) {
		global $conn;

		$resultChild = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE deleted = 0 AND parent_id = $parent_id");
        if ( mysqli_num_rows($resultChild) > 0 ) {
            while($rowChild = mysqli_fetch_array($resultChild)) {

            	$new_parent_id = $rowChild["ID"];

            	// CHILD CLONING
            	$sql = "INSERT INTO tbl_library (user_id, parent_id, child_id, type, name, program, description, assigned_to_id, due_date, last_modified)
				SELECT $req_user_id, $last_id, '', type, name, program, description, assigned_to_id, due_date, last_modified
				FROM tbl_library
				WHERE ID = $new_parent_id";

				if (mysqli_query($conn, $sql)) {
					$new_last_id = mysqli_insert_id($conn);

					$selectData = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE ID = $last_id");
					if ( mysqli_num_rows($selectData) > 0 ) {
						$rowData = mysqli_fetch_array($selectData);

						$child_id = array();
						if ( !empty($rowData['child_id']) ) {
							array_push($child_id, $rowData['child_id']);
						}
						array_push($child_id, $new_last_id);

						// Update parent's record
						$child_id = implode(", ",$child_id);
						mysqli_query( $conn,"UPDATE tbl_library set child_id='". $child_id ."' WHERE ID='". $last_id ."'" );
					}

					cloneComment($req_user_id, $new_parent_id, $new_last_id);
					cloneFile($req_user_id, $new_parent_id, $new_last_id);
					cloneChild($req_user_id, $new_parent_id, $new_last_id);
				}
            }
        }
	}

	function cloneComment($req_user_id, $parent_id, $last_id) {
		global $conn;

		$resultComment = mysqli_query( $conn,"SELECT * FROM tbl_library_comment WHERE deleted = 0 AND library_id = $parent_id");
        if ( mysqli_num_rows($resultComment) > 0 ) {
            while($rowComment = mysqli_fetch_array($resultComment)) {

            	$new_comment_id = $rowComment["ID"];

            	// CHILD CLONING
            	$sql = "INSERT INTO tbl_library_comment (user_id, library_id, title, comment, last_modified)
				SELECT $req_user_id, $last_id, title, comment, last_modified
				FROM tbl_library_comment
				WHERE ID = $new_comment_id";

				mysqli_query($conn, $sql);
            }
        }
	}

	function cloneFile($req_user_id, $parent_id, $last_id) {
		global $conn;

		$resultFile = mysqli_query( $conn,"SELECT * FROM tbl_library_file WHERE deleted = 0 AND library_id = $parent_id");
        if ( mysqli_num_rows($resultFile) > 0 ) {
            while($rowFile = mysqli_fetch_array($resultFile)) {

            	$new_file_id = $rowFile["ID"];

            	// CHILD CLONING
            	$sql = "INSERT INTO tbl_library_file (user_id, library_id, files, comment, assigned_to_id, due_date, last_modified)
				SELECT $req_user_id, $last_id, files, comment, assigned_to_id, due_date, last_modified
				FROM tbl_library_file
				WHERE ID = $new_file_id";

				mysqli_query($conn, $sql);
            }
        }
	}

    function itemReport($parent_id, $child_id) {
        global $conn;

        $resultTreeItem = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE deleted = 0 AND parent_id = $parent_id" );
        $output = "";
        if ( mysqli_num_rows($resultTreeItem) > 0 ) {
            while($rowTreeItem = mysqli_fetch_array($resultTreeItem)) {
                $item_ID = $rowTreeItem["ID"];
                $new_parent_id = $rowTreeItem["parent_id"];
                $new_child_id = $rowTreeItem["child_id"];


                $type_id = $rowTreeItem["type"];
                $type = "";
                $name = $rowTreeItem["name"];
                $comment = "NS";
                $files = "";
                $files_uploaded = "";
			    $due_date = $rowTreeItem['due_date'];

			    $array_name_id = explode(", ", $name);
                if ( count($array_name_id) == 4 ) {
                    $data_name = array();

                    $selectType = mysqli_query($conn,"SELECT * FROM tbl_library_type WHERE ID = '".$array_name_id[0]."'");
                    if ( mysqli_num_rows($selectType) > 0 ) {
                        while($rowType = mysqli_fetch_array($selectType)) {
                            array_push($data_name, $rowType["name"]);
                        }
                    }

                    $selectCategory = mysqli_query($conn,"SELECT * FROM tbl_library_category WHERE ID = '".$array_name_id[1]."'");
                    if ( mysqli_num_rows($selectCategory) > 0 ) {
                        while($rowCategory = mysqli_fetch_array($selectCategory)) {
                            array_push($data_name, $rowCategory["name"]);
                        }
                    }

                    $selectScope = mysqli_query($conn,"SELECT * FROM tbl_library_scope WHERE ID = '".$array_name_id[2]."'");
                    if ( mysqli_num_rows($selectScope) > 0 ) {
                        while($rowScope = mysqli_fetch_array($selectScope)) {
                            array_push($data_name, $rowScope["name"]);
                        }
                    }

                    $selectModule = mysqli_query($conn,"SELECT * FROM tbl_library_module WHERE ID = '".$array_name_id[3]."'");
                    if ( mysqli_num_rows($selectModule) > 0 ) {
                        while($rowModule = mysqli_fetch_array($selectModule)) {
                            array_push($data_name, $rowModule["name"]);
                        }
                    }

                    $name = implode(" - ",$data_name);
                }

                if ($type_id == 0) { $type = "Company"; }
                else if ($type_id == 1) { $type = "Program"; }
                else if ($type_id == 2) { $type = "Policy"; }
                else if ($type_id == 3) { $type = "Procedure"; }
                else if ($type_id == 4) { $type = "Training"; }
                else if ($type_id == 5) { $type = "Form"; }

                $resultItemComment = mysqli_query( $conn,"SELECT * FROM tbl_library_comment WHERE deleted = 0 AND library_id = $item_ID" );
		        if ( mysqli_num_rows($resultItemComment) > 0 ) {
		            while($rowItemComment = mysqli_fetch_array($resultItemComment)) {
		            	$comment = $rowItemComment["comment"];
		            }
		        }

                $resultItemFile = mysqli_query( $conn,"SELECT * FROM tbl_library_file WHERE deleted = 0 AND library_id = $item_ID" );
		        if ( mysqli_num_rows($resultItemFile) > 0 ) {
		            while($rowItemComment = mysqli_fetch_array($resultItemFile)) {
		            	$files = $rowItemComment["files"];
		            	$file_comment = $rowItemComment["comment"];
		            	$files_uploaded = $rowItemComment["last_modified"];
		            }
		        }

                $url = 'uploads/library/';

                $array_child_id = explode(", ", $child_id);
                if (in_array($item_ID, $array_child_id)) {
                	$output .= '<tr>';
                        $output .= '<td>'. $name .'</td>';
                        $output .= '<td>'. $type .'</td>';
                        $output .= '<td>'. $comment .'</td>';
		                $output .= '<td><a href="'.$url.rawurlencode($files).'" target="_blank">'. $files .'</a></td>';
                        $output .= '<td>'. $files_uploaded .'</td>';
                        $output .= '<td>'. $due_date .'</td>';
                    $output .= '</tr>';
                    
                    $output .= itemReport($item_ID, $new_child_id);
                }
            }
        }

        return $output;
    }
?>
