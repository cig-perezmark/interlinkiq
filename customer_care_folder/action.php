<?php
    include '../database.php';
    
    // GENERAL
    $base_url = "https://interlinkiq.com/";
    
    
    if (!empty($_COOKIE['switchAccount'])) {
    	$portal_user = $_COOKIE['ID'];
    	$user_id = $_COOKIE['switchAccount'];
    }
    else {
    	$portal_user = $_COOKIE['ID'];
    	$user_id = employerID($portal_user);
    }
    function employerID($ID) {
    	global $conn;

    	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $ID" );
        $rowUser = mysqli_fetch_array($selectUser);
        $current_userEmployeeID = $rowUser['employee_id'];

        $current_userEmployerID = $ID;
        if ($current_userEmployeeID > 0) {
            $selectEmployer = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID" );
            if ( mysqli_num_rows($selectEmployer) > 0 ) {
                $rowEmployer = mysqli_fetch_array($selectEmployer);
                $current_userEmployerID = $rowEmployer["user_id"];
            }
        }

        return $current_userEmployerID;
    }

    function fileExtension($file) {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $src = 'https://view.officeapps.live.com/op/embed.aspx?src=';
        $embed = '&embedded=true';
        $type = 'iframe';
    	if (strtolower($extension) == "pdf") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-pdf-o"; }
		else if (strtolower($extension) == "doc" OR strtolower($extension) == "docx") { $file_extension = "fa-file-word-o"; }
		else if (strtolower($extension) == "ppt" OR strtolower($extension) == "pptx") { $file_extension = "fa-file-powerpoint-o"; }
		else if (strtolower($extension) == "xls" OR strtolower($extension) == "xlsb" OR strtolower($extension) == "xlsm" OR strtolower($extension) == "xlsx" OR strtolower($extension) == "csv" OR strtolower($extension) == "xlsx") { $file_extension = "fa-file-excel-o"; }
		else if (strtolower($extension) == "gif" OR strtolower($extension) == "jpg"  OR strtolower($extension) == "jpeg" OR strtolower($extension) == "png" OR strtolower($extension) == "ico") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-image-o"; }
		else if (strtolower($extension) == "mp4" OR strtolower($extension) == "mov"  OR strtolower($extension) == "wmv" OR strtolower($extension) == "flv" OR strtolower($extension) == "avi" OR strtolower($extension) == "avchd" OR strtolower($extension) == "webm" OR strtolower($extension) == "mkv") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-video-o"; }
		else { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-code-o"; }

		$output['src'] = $src;
	    $output['embed'] = $embed;
	    $output['type'] = $type;
	    $output['file_extension'] = $file_extension;
	    $output['file_mime'] = $extension;
	    return $output;
    }
    
    // PHP MAILER FUNCTION
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';
	function php_mailer_1($to, $user, $subject, $body, $from, $name) {
		// require 'PHPMailer/src/Exception.php';
		// require 'PHPMailer/src/PHPMailer.php';
		// require 'PHPMailer/src/SMTP.php';

		$mail = new PHPMailer(true);
		try {
		    $mail->isSMTP();
			// $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
		    $mail->Host       = 'interlinkiq.com';
		    $mail->CharSet 	  = 'UTF-8';
		    $mail->SMTPAuth   = true;
		    $mail->Username   = 'admin@interlinkiq.com';
		    $mail->Password   = 'L1873@2019new';
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		    $mail->Port       = 465;
		    $mail->clearAddresses();
		    $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
		    $mail->addAddress($to, $user);
		    $mail->addReplyTo($from, $name);
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
    
    // add new
    if(isset($_POST['btnAdd_new'])) {
      
        $cookie = $_COOKIE['ID'];
       
        $care_date = mysqli_real_escape_string($conn,$_POST['care_date']);
        $cusEmail = mysqli_real_escape_string($conn,$_POST['cusEmail']);
        $cusName = mysqli_real_escape_string($conn,$_POST['cusName']);
        $cusAddress = mysqli_real_escape_string($conn,$_POST['cusAddress']);
        $phoneNo = mysqli_real_escape_string($conn,$_POST['phoneNo']);
        $METRC_package_id = mysqli_real_escape_string($conn,$_POST['METRC_package_id']);
        $product_name = mysqli_real_escape_string($conn,$_POST['product_name']);
        $reply_to_customer = mysqli_real_escape_string($conn,$_POST['reply_to_customer']);
        $resolution_desc = mysqli_real_escape_string($conn,$_POST['resolution_desc']);
        
        $investigation_started = $_POST['investigation_started'];
        if(!empty($investigation_started)){ $investigation_started = 1;}else{$investigation_started = 0;}
        
        // $complaint_type = mysqli_real_escape_string($conn,$_POST['complaint_type']);
        $complaint_type = 0;
        if ($_POST['complaint_type'] == 'customOption') {
            if (!empty($_POST['complaint_type_other'])) {
                $complaint_type = $_POST['complaint_type_other'];
            }
        } else {
            $complaint_type = $_POST['complaint_type'];
        }
        
        // $complaint_category = mysqli_real_escape_string($conn,$_POST['complaint_category']);
        $complaint_category = 0;
        if ($_POST['complaint_category'] == 'customOption') {
            if (!empty($_POST['complaint_category_other'])) {
                $complaint_category = $_POST['complaint_category_other'];
            }
        } else {
            $complaint_category = $_POST['complaint_category'];
        }
        
        // $reply_type = mysqli_real_escape_string($conn,$_POST['reply_type']);
        $reply_type = 0;
        if ($_POST['reply_type'] == 'customOption') {
            if (!empty($_POST['reply_type_other'])) {
                $reply_type = $_POST['reply_type_other'];
            }
        } else {
            $reply_type = $_POST['reply_type'];
        }
        
        $date_of_acknowledgement = mysqli_real_escape_string($conn,$_POST['date_of_acknowledgement']);
        
        $product_description = mysqli_real_escape_string($conn,$_POST['product_description']);
        $lot_code = mysqli_real_escape_string($conn,$_POST['lot_code']);
        
        $product_purchased_date = mysqli_real_escape_string($conn,$_POST['product_purchased_date']);
        $product_purchased_date_remarks = mysqli_real_escape_string($conn,$_POST['product_purchased_date_remarks']);
        
        $product_expiry = mysqli_real_escape_string($conn,$_POST['product_expiry']);
        $product_expiry_remarks = mysqli_real_escape_string($conn,$_POST['product_expiry_remarks']);
        
        $product_purchase_location = mysqli_real_escape_string($conn,$_POST['product_purchase_location']);
        $nature_complaint = mysqli_real_escape_string($conn,$_POST['nature_complaint']);
        $action_taken = mysqli_real_escape_string($conn,$_POST['action_taken']);
        $date_resolution = mysqli_real_escape_string($conn,$_POST['date_resolution']);
        
        // $person_contacted = mysqli_real_escape_string($conn,$_POST['person_contacted']);
        $person_contacted = 0;
        if ($_POST['person_contacted'] == 'customOption') {
            if (!empty($_POST['person_contacted_other'])) {
                $person_contacted = $_POST['person_contacted_other'];
            }
        } else {
            $person_contacted = $_POST['person_contacted'];
        }
        
        // $person_handling = mysqli_real_escape_string($conn,$_POST['person_handling']);
        $person_handling = 0;
        if ($_POST['person_handling'] == 'customOption') {
            if (!empty($_POST['person_handling_other'])) {
                $person_handling = $_POST['person_handling_other'];
            }
        } else {
            $person_handling = $_POST['person_handling'];
        }
        
		$filetype = $_POST['filetype'];
		if ($filetype == 1) {
			$files = $_FILES['file']['name'];
			if (!empty($files)) {
				$path = 'customer_care_file/';
				$tmp = $_FILES['file']['tmp_name'];
				$files = rand(1000,1000000) . ' - ' . $files;
				$path = $path.$files;
				move_uploaded_file($tmp,$path);
			}
		} else {
			$files = $_POST['fileurl'];
		}
        
		$filetype2 = $_POST['filetype2'];
		if ($filetype2 == 1) {
			$files2 = $_FILES['file2']['name'];
			if (!empty($files2)) {
				$path = 'customer_care_file/';
				$tmp = $_FILES['file']['tmp_name'];
				$files2 = rand(1000,1000000) . ' - ' . $files2;
				$path = $path.$files2;
				move_uploaded_file($tmp,$path);
			}
		} else {
			$files2 = $_POST['fileurl2'];
		}
        
        $sql = "INSERT INTO tbl_complaint_records(care_date,cusEmail,cusName,cusAddress,phoneNo,product_name,product_description,reply_to_customer,reply_type,date_of_acknowledgement,METRC_package_id,complaint_type,complaint_category,lot_code,product_expiry,product_expiry_remarks,product_purchased_date,product_purchased_date_remarks,product_purchase_location,person_contacted,person_handling,nature_complaint,action_taken,date_resolution,investigation_started,resolution_desc,care_addedby,care_ownedby, files, filetype, files2, filetype2, user_id, portal_user) 
        VALUES('$care_date','$cusEmail','$cusName','$cusAddress','$phoneNo','$product_name','$product_description','$reply_to_customer','$reply_type','$date_of_acknowledgement','$METRC_package_id','$complaint_type','$complaint_category','$lot_code','$product_expiry','$product_expiry_remarks','$product_purchased_date','$product_purchased_date_remarks','$product_purchase_location','$person_contacted','$person_handling','$nature_complaint','$action_taken','$date_resolution','$investigation_started','$resolution_desc','$cookie','$user_id', '$files', '$filetype', '$files2', '$filetype2','$cookie','$user_id')";
        if(mysqli_query($conn, $sql)){
            $last_id = mysqli_insert_id($conn);
            
            //to capa
            $sql_capa = "INSERT INTO tbl_complaint_capa(comp_record_id,capa_addedby,capa_ownedby) 
            VALUES('$last_id','$cookie','$user_id')";
            if(mysqli_query($conn, $sql_capa)){ $capa_last_id = mysqli_insert_id($conn);}
            
            //to scar
            $sql_scar = "INSERT INTO tbl_complaint_scar(scar_record_id,scar_addedby,scar_onwedby) 
            VALUES('$last_id','$cookie','$user_id')";
            if(mysqli_query($conn, $sql_scar)){ $scar_last_id = mysqli_insert_id($conn);}
            
            if (!empty($_COOKIE['switchAccount'])) {
                $portal_user = $_COOKIE['ID'];
                $user_id = $_COOKIE['switchAccount'];
            }
            else {
                $portal_user = $_COOKIE['ID'];
                $user_id = employerID($portal_user);
            }
            
            $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $user_id" );
            if ( mysqli_num_rows($selectUser) > 0 ) {
                $rowUser = mysqli_fetch_array($selectUser);
                $to = $rowUser["email"];
                $user = $rowUser["first_name"].' '.$rowUser["last_name"];
    
                $subject = 'New Complaint Record';
                $body = 'Hi '.$user.',<br><br>
    
                The following complaint record(s) have been added and are ready for your review:<br><br>
    
                Complaint Record #'.$last_id.'<br><br>';
    
                if ($_COOKIE['client'] == 1) {
                    $from = 'CannOS@begreenlegal.com';
                    $name = 'BeGreenLegal';
                    $body .= 'Cann OS Team';
                } else {
                    $from = 'services@interlinkiq.com';
                    $name = 'InterlinkIQ';
                    $body .= 'InterlinkIQ.com Team<br>Consultare Inc.';
                }
                php_mailer_1($to, $user, $subject, $body, $from, $name);
            }
            
            $query = "SELECT * FROM tbl_complaint_records where care_id = $last_id";
            $queryRes = mysqli_query($conn, $query);
            while($row = $queryRes->fetch_assoc()) {
            
                $complaint_type = $row['complaint_type'];
                if($row['complaint_type'] == 0){ $complaint_type = ''; }
                else if($row['complaint_type'] == 1){ $complaint_type = 'Electronic (Email)'; }
                else if($row['complaint_type'] == 2){ $complaint_type = 'Electronic (Social Media)'; }
                else if($row['complaint_type'] == 3){ $complaint_type = 'Oral'; }
                else if($row['complaint_type'] == 4){ $complaint_type = 'Written'; }
                
                $complaint_category = $row['complaint_category'];
                if($row['complaint_category'] == 0){ $complaint_category = ''; }
                else if($row['complaint_category'] == 1){ $complaint_category = 'Caused Illness or Injury'; }
                else if($row['complaint_category'] == 2){ $complaint_category = 'Foreign Material in Cannabis Product Container'; }
                else if($row['complaint_category'] == 3){ $complaint_category = 'Foul Odor'; }
                else if($row['complaint_category'] == 4){ $complaint_category = 'Improper Packaging'; }
                else if($row['complaint_category'] == 5){ $complaint_category = 'Incorrect Concentration of Cannabinoids'; }
                else if($row['complaint_category'] == 6){ $complaint_category = 'Mislabeling'; }
                                                
                $cam_date = $row['care_date'];
                $cam_date = new DateTime($cam_date);
                $cam_date = $cam_date->format('Y-m-d');
            ?>
                <tr id="care_row<?php echo $row['care_id'] ?>">
                    <td class="<?php echo $_COOKIE['client'] == 1 ? 'hide':''; ?>"><?php echo $row['care_id'] ?></td>
                    <td><?php echo $cam_date ?></td>
                    <td><?php echo $row['cusName'] ?></td>
                    <td class="<?php echo $_COOKIE['client'] == 1 ? '':'hide'; ?>"><?php echo $complaint_type ?></td>
                    <td class="<?php echo $_COOKIE['client'] == 1 ? '':'hide'; ?>"><?php echo $complaint_category ?></td>
                    <td class="<?php echo $_COOKIE['client'] == 1 ? 'hide':''; ?>"><?php echo $row['cusAddress'] ?></td>
                    <td class="<?php echo $_COOKIE['client'] == 1 ? 'hide':''; ?>"><?php echo $row['phoneNo'] ?></td>
                    <td><?php echo $row['product_name'] ?></td>
                    <td class="text-center <?php echo $_COOKIE['client'] == 1 ? 'hide':''; ?>">
                        <div class="btn-group btn-group">
                            <a  href="#modal_capa" data-toggle="modal" type="button" id="update_capa" data-id="<?= $row['care_id']; ?>" class="btn btn-outline dark btn-sm">ICAR</a>
    	                    <a href="#modal_capa_pdf" data-toggle="modal" type="button" id="pdf_capa" data-id="<?= $row['care_id']; ?>" class="btn btn-outline btn-danger btn-sm" onclick="">PDF</a>
                        </div>
                    </td>
                    <td class="text-center <?php echo $_COOKIE['client'] == 1 ? 'hide':''; ?>">
                        <div class="btn-group btn-group">
    	                    <a href="#modal_scar" data-toggle="modal" type="button" id="update_scar" data-id="<?= $row['care_id']; ?>" class="btn btn-outline dark btn-sm" onclick="">SCAR</a>
                            <a  href="#modal_scar_pdf" data-toggle="modal" type="button" id="pdf_scar" data-id="<?= $row['care_id']; ?>" class="btn btn-outline btn-danger btn-sm">PDF</a>
                        </div>
                    </td>
                    <td class="text-center <?php echo $_COOKIE['client'] == 1 ? '':'hide'; ?>">
                        <?php echo '<input type="checkbox" value="'.$row['capam'].'" onclick="btnCapam(this, '.$row['care_id'].')" '; echo $row['capam']==1 ? 'CHECKED':''; echo '/>'; ?>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_complaint" data-toggle="modal" type="button" id="update_complaint" data-id="<?= $row['care_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_complaint" data-toggle="modal" type="button" id="delete_complaint" data-id="<?= $row['care_id']; ?>" class="btn btn-warning btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php }
         } else {
            //  echo 'error';
             
            echo("Error description: " . mysqli_error($conn));
         }
    }

    //update complaint report
    if( isset($_GET['get_complaint_id']) ) {
    	$ID = $_GET['get_complaint_id'];

    	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
    	    ';
    	        $query = "SELECT * FROM tbl_complaint_records where care_id = $ID";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result))
                { 
                    $filetype = $row['filetype'];
        			$files = $row["files"];
        			$type = 'iframe';
        			if (!empty($files)) {
        				if ($filetype == 1) {
        				    $fileExtension = fileExtension($files);
        					$src = $fileExtension['src'];
        					$embed = $fileExtension['embed'];
        					$type = $fileExtension['type'];
        					$file_extension = $fileExtension['file_extension'];
        				    $url = $base_url.'customer_care_file/';
        
        				    $files = $src.$url.rawurlencode($files).$embed;
        				} else if ($filetype == 3) {
        					$files = preg_replace('#[^/]*$#', '', $files).'preview';
        				}
        			}
        			
                    $filetype2 = $row['filetype2'];
        			$files2 = $row["files2"];
        			$type2 = 'iframe';
        			if (!empty($files2)) {
        				if ($filetype2 == 1) {
        				    $fileExtension = fileExtension($files2);
        					$src = $fileExtension['src'];
        					$embed = $fileExtension['embed'];
        					$type2 = $fileExtension['type'];
        					$file_extension = $fileExtension['file_extension'];
        				    $url = $base_url.'customer_care_file/';
        
        				    $files2 = $src.$url.rawurlencode($files2).$embed;
        				} else if ($filetype2 == 3) {
        					$files2 = preg_replace('#[^/]*$#', '', $files2).'preview';
        				}
        			}
                ?>
                    <center><h4><b>CUSTOMER COMPLAINT REPORT</b></h4></center>
                    <div class="form-group">
                        <div class="col-md-12">
                           <label>Date:</label>
                           <input type="date" class="form-control" name="care_date" value="<?= date('Y-m-d', strtotime($row['care_date']));?>" required>
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-12">
                           <label>Customer Email:</label>
                           <input type="email" class="form-control" name="cusEmail" value="<?= $row['cusEmail']; ?>">
                       </div>
                   </div>
                    <div class="form-group">
                        <div class="col-md-6">
                           <label>Customer Name:</label>
                           <input type="text" class="form-control" name="cusName" value="<?= $row['cusName']; ?>">
                       </div>
                       <div class="col-md-6">
                           <label>Customer Phone#</label>
                           <input type="" class="form-control" name="phoneNo" value="<?= $row['phoneNo']; ?>">
                       </div>
                   </div>
                    <div class="form-group">
                        <div class="col-md-12">
                           <label>Customer Address:</label>
                           <input class="form-control" type="" name="cusAddress" value="<?= $row['cusAddress']; ?>">
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-6">
                           <label>Product Name:</label>
                           <input class="form-control" type="" name="product_name" value="<?= $row['product_name']; ?>">
                       </div>
                       <div class="col-md-6">
                           <label>Product Description:</label>
                           <textarea class="form-control" type="" name="product_description"><?= $row['product_description']; ?></textarea>
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-12">
                           <label>Package ID:</label>
                           <input type="text" class="form-control" name="METRC_package_id" value="<?= $row['METRC_package_id']; ?>">
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-6">
                           <label>Lot Code/Batch#:</label>
                           <input type="text" class="form-control" name="lot_code" value="<?= $row['lot_code']; ?>">
                       </div>
                        <div class="col-md-6">
                           <label>Product Purchase Location:</label>
                           <input class="form-control" type="" name="product_purchase_location" value="<?= $row['product_purchase_location']; ?>">
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-6">
                           <label>Product Purchased Date:</label>
                           <input class="form-control" type="date" name="product_purchased_date" value="<?= date('Y-m-d', strtotime($row['product_purchased_date']));?>">
                       </div>
                       <div class="col-md-6">
                           <label>Remarks:</label>
                           <textarea class="form-control" name="product_purchased_date_remarks"><?php echo $row['product_purchased_date_remarks']; ?></textarea>
                       </div>
                   </div>
                   <div class="form-group">
                       <div class="col-md-6">
                           <label>Product Expiration Date:</label>
                           <input type="date" class="form-control" name="product_expiry" value="<?php if(!empty($row['product_expiry'] OR $row['product_expiry'] != '')){ echo date('Y-m-d', strtotime($row['product_expiry']));} ?>">
                       </div>
                       <div class="col-md-6">
                           <label>Remarks:</label>
                           <textarea class="form-control" name="product_expiry_remarks"><?php echo $row['product_expiry_remarks']; ?></textarea>
                       </div>
                   </div>
                   <div class="form-group">
                       <div class="col-md-6">
                           <label>Complaint Type:</label>
                           <select class="form-control <?php echo is_numeric($row['complaint_type']) == 1 ? '':'hide'; ?>" name="complaint_type" onchange="if(this.options[this.selectedIndex].value=='customOption'){toggleField(this, 1);}">
                               <option value="0" <?php if($row['complaint_type']== 0){echo 'selected';}else{ echo ''; } ?>>--Select--</option>
                               <option value="1" <?php if($row['complaint_type']== 1){echo 'selected';}else{ echo ''; } ?>>Electronic (Email)</option>
                               <option value="2" <?php if($row['complaint_type']== 2){echo 'selected';}else{ echo ''; } ?>>Electronic (Social Media)</option>
                               <option value="3" <?php if($row['complaint_type']== 3){echo 'selected';}else{ echo ''; } ?>>Oral</option>
                               <option value="4" <?php if($row['complaint_type']== 4){echo 'selected';}else{ echo ''; } ?>>Written</option>
                                <option value="customOption" <?php echo is_numeric($row['complaint_type']) == 1 ? '':'SELECTED'; ?>>[Others]</option>
                           </select>
                            <input class="form-control <?php echo is_numeric($row['complaint_type']) == 1 ? 'hide':''; ?>" name="complaint_type_other" onblur="if(this.value==''){toggleField(this, 0);}" value="<?php echo $row['complaint_type']; ?>">
                       </div>
                       <div class="col-md-6">
                           <label>Complaint Category:</label>
                           <select class="form-control <?php echo is_numeric($row['complaint_category']) == 1 ? '':'hide'; ?>" name="complaint_category" onchange="if(this.options[this.selectedIndex].value=='customOption'){toggleField(this, 1);}">
                               <option value="0" <?php if($row['complaint_category']== 0){echo 'selected';}else{ echo ''; } ?>>--Select--</option>
                               <option value="1" <?php if($row['complaint_category']== 1){echo 'selected';}else{ echo ''; } ?>>Caused Illness or Injury</option>
                               <option value="2" <?php if($row['complaint_category']== 2){echo 'selected';}else{ echo ''; } ?>>Foreign Material in Cannabis Product Container</option>
                               <option value="3" <?php if($row['complaint_category']== 3){echo 'selected';}else{ echo ''; } ?>>Foul Odor</option>
                               <option value="4" <?php if($row['complaint_category']== 4){echo 'selected';}else{ echo ''; } ?>>Improper Packaging</option>
                               <option value="5" <?php if($row['complaint_category']== 5){echo 'selected';}else{ echo ''; } ?>>Incorrect Concentration of Cannabinoids</option>
                               <option value="6" <?php if($row['complaint_category']== 6){echo 'selected';}else{ echo ''; } ?>>Mislabeling</option>
                                <option value="customOption" <?php echo is_numeric($row['complaint_category']) == 1 ? '':'SELECTED'; ?>>[Others]</option>
                           </select>
                            <input class="form-control <?php echo is_numeric($row['complaint_category']) == 1 ? 'hide':''; ?>" name="complaint_category_other" onblur="if(this.value==''){toggleField(this, 0);}" value="<?php echo $row['complaint_category']; ?>">
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-12">
                           <label>Description of the Complaint:</label>
                           <textarea class="form-control" type="" name="nature_complaint" rows="3"><?= $row['nature_complaint']; ?></textarea>
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-12">
                           <label>Reply to Customer:</label>
                           <textarea class="form-control" type="" name="reply_to_customer" rows="3"><?= $row['reply_to_customer']; ?></textarea>
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-12">
                           <label>Reply Type:</label>
                            <select class="form-control <?php echo is_numeric($row['reply_type']) == 1 ? '':'hide'; ?>" name="reply_type" onchange="if(this.options[this.selectedIndex].value=='customOption'){toggleField(this, 1);}">
                                <option value="0" <?php if($row['reply_type']== 0){echo 'selected';}else{ echo ''; } ?>>---Select---</option>
                                <option value="1" <?php if($row['reply_type']== 1){echo 'selected';}else{ echo ''; } ?>>Electronic (Email)</option>
                                <option value="2" <?php if($row['reply_type']== 2){echo 'selected';}else{ echo ''; } ?>>Electronic (Social Media)</option>
                                <option value="3" <?php if($row['reply_type']== 3){echo 'selected';}else{ echo ''; } ?>>Phone</option>
                                <option value="4" <?php if($row['reply_type']== 4){echo 'selected';}else{ echo ''; } ?>>Written</option>
                                <option value="5" <?php if($row['reply_type']== 5){echo 'selected';}else{ echo ''; } ?>>Others</option>
                                <option value="customOption" <?php echo is_numeric($row['reply_type']) == 1 ? '':'SELECTED'; ?>>[Others]</option>
                            </select>
                            <input class="form-control <?php echo is_numeric($row['reply_type']) == 1 ? 'hide':''; ?>" name="reply_type_other" onblur="if(this.value==''){toggleField(this, 0);}" value="<?php echo $row['reply_type']; ?>">
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-6">
                           <label>Person Contacted:</label>
                           <select class="form-control <?php echo is_numeric($row['person_contacted']) == 1 ? '':'hide'; ?>" type="" name="person_contacted" onchange="if(this.options[this.selectedIndex].value=='customOption'){toggleField(this, 1);}">
                               <option value="">---Select---</option>
                               <?php
                                $handler = mysqli_query($conn, "select * from tbl_hr_employee where user_id = '$user_id' ORDER BY first_name ASC");
                                foreach($handler as $row_handler){?>
                                    <option value="<?= $row_handler['ID']; ?>" <?php if($row_handler['ID']== $row['person_contacted']){echo 'selected'; }else{ echo '';} ?>><?= $row_handler['first_name']; ?>&nbsp;<?= $row_handler['last_name']; ?></option>
                                <?php }
                               ?>
                                <option value="customOption" <?php echo is_numeric($row['person_contacted']) == 1 ? '':'SELECTED'; ?>>[Others]</option>
                           </select>
                            <input class="form-control <?php echo is_numeric($row['person_contacted']) == 1 ? 'hide':''; ?>" name="person_contacted_other" onblur="if(this.value==''){toggleField(this, 0);}" value="<?php echo $row['person_contacted']; ?>">
                       </div>
                        <div class="col-md-6">
                           <label>Person Handling the Complaint:</label>
                           <select class="form-control <?php echo is_numeric($row['person_handling']) == 1 ? '':'hide'; ?>" type="" name="person_handling" onchange="if(this.options[this.selectedIndex].value=='customOption'){toggleField(this, 1);}">
                               <option value="">---Select---</option>
                               <?php
                                $handler = mysqli_query($conn, "select * from tbl_hr_employee where user_id = '$user_id' ORDER BY first_name ASC");
                                foreach($handler as $row_handler){?>
                                    <option value="<?= $row_handler['ID']; ?>" <?php if($row_handler['ID']== $row['person_handling']){echo 'selected'; }else{ echo '';} ?>><?= $row_handler['first_name']; ?>&nbsp;<?= $row_handler['last_name']; ?></option>
                                <?php }
                               ?>
                                <option value="customOption" <?php echo is_numeric($row['person_handling']) == 1 ? '':'SELECTED'; ?>>[Others]</option>
                           </select>
                            <input class="form-control <?php echo is_numeric($row['person_handling']) == 1 ? 'hide':''; ?>" name="person_handling_other" onblur="if(this.value==''){toggleField(this, 0);}" value="<?php echo $row['person_handling']; ?>">
                       </div>
                   </div>
                   <div class="form-group">
                       <div class="col-md-12">
                           <label>
                           <input type="checkbox" name="investigation_started" value="1" <?php if($row['investigation_started'] == 1){ echo 'checked';} ?>>&nbsp;
                           Investigation Started</label>
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-6">
                           <label>Action(s) taken to prevent this from re-occurring:</label>
                           <textarea class="form-control" type="" name="action_taken"><?= $row['action_taken']; ?></textarea>
                       </div>
                        <div class="col-md-6">
                           <label>Action Document</label>
                           <?php
                                echo '<select class="form-control '; echo !empty($files2) ? 'hide':''; echo '" name="filetype2" onchange="changeType(this)" required>
                	            	<option value="0">Select option</option>
                	            	<option value="1">Manual Upload</option>
                	            	<option value="2">Youtube URL</option>
                	            	<option value="3">Google Drive URL</option>
                	            </select>
                	            <input class="form-control margin-top-15 fileUpload" type="file" name="file2" style="display: none;" />
                	            <input class="form-control margin-top-15 fileURL" type="url" name="fileurl2" style="display: none;" placeholder="https://" />
                                <p class="'; echo !empty($files2) ? '':'hide'; echo '" style="margin: 0;"><a href="'.$files2.'" data-src="'.$files.'" data-fancybox data-type="'.$type2.'" class="btn btn-link">View</a> | <button type="button" class="btn btn-link uploadNew" onclick="uploadNew(this)">Upload New</button></p>';
                           ?>
                        </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-6">
                           <label>Date of Acknowledgement</label>
                           <input class="form-control" type="date" name="date_of_acknowledgement" value="<?= date('Y-m-d', strtotime($row['date_of_acknowledgement']));?>">
                       </div>
                        <div class="col-md-6">
                           <label>Date of Resolution:</label>
                           <input class="form-control" type="date" name="date_resolution" value="<?= date('Y-m-d', strtotime($row['date_resolution']));?>">
                       </div>
                   </div>
                   <div class="form-group">
                        <div class="col-md-6">
                           <label>Resolution Description</label>
                           <textarea class="form-control" type="" name="resolution_desc" rows="3"><?= $row['resolution_desc']; ?></textarea>
                       </div>
                        <div class="col-md-6">
                           <label>Resolution Document</label>
                           <?php
                                echo '<select class="form-control '; echo !empty($files) ? 'hide':''; echo '" name="filetype" onchange="changeType(this)" required>
                	            	<option value="0">Select option</option>
                	            	<option value="1">Manual Upload</option>
                	            	<option value="2">Youtube URL</option>
                	            	<option value="3">Google Drive URL</option>
                	            </select>
                	            <input class="form-control margin-top-15 fileUpload" type="file" name="file" style="display: none;" />
                	            <input class="form-control margin-top-15 fileURL" type="url" name="fileurl" style="display: none;" placeholder="https://" />
                                <p class="'; echo !empty($files) ? '':'hide'; echo '" style="margin: 0;"><a href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'" class="btn btn-link">View</a> | <button type="button" class="btn btn-link uploadNew" onclick="uploadNew(this)">Upload New</button></p>';
                           ?>
                        </div>
                   </div>
        <?php } 
    }
    if( isset($_POST['btnSave_complaint']) ) {
      
        $cookie = $_COOKIE['ID'];
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $care_date = mysqli_real_escape_string($conn,$_POST['care_date']);
        $cusEmail = mysqli_real_escape_string($conn,$_POST['cusEmail']);
        $cusName = mysqli_real_escape_string($conn,$_POST['cusName']);
        $cusAddress = mysqli_real_escape_string($conn,$_POST['cusAddress']);
        $phoneNo = mysqli_real_escape_string($conn,$_POST['phoneNo']);
        $METRC_package_id = mysqli_real_escape_string($conn,$_POST['METRC_package_id']);
        $product_name = mysqli_real_escape_string($conn,$_POST['product_name']);
        $reply_to_customer = mysqli_real_escape_string($conn,$_POST['reply_to_customer']); 
        $investigation_started = mysqli_real_escape_string($conn,$_POST['investigation_started']);
        $resolution_desc = mysqli_real_escape_string($conn,$_POST['resolution_desc']);
        if(!empty($investigation_started)){ $investigation_started = 1;}else{$investigation_started = 0;}
        
        // $complaint_type = mysqli_real_escape_string($conn,$_POST['complaint_type']);
        $complaint_type = 0;
        if ($_POST['complaint_type'] == 'customOption') {
            if (!empty($_POST['complaint_type_other'])) {
                $complaint_type = $_POST['complaint_type_other'];
            }
        } else {
            $complaint_type = $_POST['complaint_type'];
        }
        
        // $complaint_category = mysqli_real_escape_string($conn,$_POST['complaint_category']);
        $complaint_category = 0;
        if ($_POST['complaint_category'] == 'customOption') {
            if (!empty($_POST['complaint_category_other'])) {
                $complaint_category = $_POST['complaint_category_other'];
            }
        } else {
            $complaint_category = $_POST['complaint_category'];
        }
        
        // $reply_type = mysqli_real_escape_string($conn,$_POST['reply_type']);
        $reply_type = 0;
        if ($_POST['reply_type'] == 'customOption') {
            if (!empty($_POST['reply_type_other'])) {
                $reply_type = $_POST['reply_type_other'];
            }
        } else {
            $reply_type = $_POST['reply_type'];
        }
        
        $date_of_acknowledgement = mysqli_real_escape_string($conn,$_POST['date_of_acknowledgement']);
        
        $product_description = mysqli_real_escape_string($conn,$_POST['product_description']);
        $lot_code = mysqli_real_escape_string($conn,$_POST['lot_code']);
        
        $product_purchased_date = mysqli_real_escape_string($conn,$_POST['product_purchased_date']);
        $product_purchased_date_remarks = mysqli_real_escape_string($conn,$_POST['product_purchased_date_remarks']);
        
        $product_expiry = mysqli_real_escape_string($conn,$_POST['product_expiry']);
        $product_expiry_remarks = mysqli_real_escape_string($conn,$_POST['product_expiry_remarks']);
        
        $product_purchase_location = mysqli_real_escape_string($conn,$_POST['product_purchase_location']);
        $nature_complaint = mysqli_real_escape_string($conn,$_POST['nature_complaint']);
        $action_taken = mysqli_real_escape_string($conn,$_POST['action_taken']);
        $date_resolution = mysqli_real_escape_string($conn,$_POST['date_resolution']);
        
        // $person_contacted = mysqli_real_escape_string($conn,$_POST['person_contacted']);
        $person_contacted = 0;
        if ($_POST['person_contacted'] == 'customOption') {
            if (!empty($_POST['person_contacted_other'])) {
                $person_contacted = $_POST['person_contacted_other'];
            }
        } else {
            $person_contacted = $_POST['person_contacted'];
        }
        
        // $person_handling = mysqli_real_escape_string($conn,$_POST['person_handling']);
        $person_handling = 0;
        if ($_POST['person_handling'] == 'customOption') {
            if (!empty($_POST['person_handling_other'])) {
                $person_handling = $_POST['person_handling_other'];
            }
        } else {
            $person_handling = $_POST['person_handling'];
        }
        
		$filetype = $_POST['filetype'];
		if ($filetype == 1) {
			$files = $_FILES['file']['name'];
			if (!empty($files)) {
				$path = 'customer_care_file/';
				$tmp = $_FILES['file']['tmp_name'];
				$files = rand(1000,1000000) . ' - ' . $files;
				$path = $path.$files;
				move_uploaded_file($tmp,$path);

				mysqli_query( $conn,"UPDATE tbl_complaint_records set files='". $files ."', filetype='". $filetype ."' WHERE care_id='". $IDs ."'" );
			}
		} else {
			$files = $_POST['fileurl'];
			if (!empty($files)) {
				mysqli_query( $conn,"UPDATE tbl_complaint_records set files='". $files ."', filetype='". $filetype ."' WHERE care_id='". $IDs ."'" );
			}
		}
        
		$filetype2 = $_POST['filetype2'];
		if ($filetype2 == 1) {
			$files2 = $_FILES['file2']['name'];
			if (!empty($files2)) {
				$path = 'customer_care_file/';
				$tmp = $_FILES['file2']['tmp_name'];
				$files2 = rand(1000,1000000) . ' - ' . $files2;
				$path = $path.$files2;
				move_uploaded_file($tmp,$path);

				mysqli_query( $conn,"UPDATE tbl_complaint_records set files2='". $files2 ."', filetype2='". $filetype2 ."' WHERE care_id='". $IDs ."'" );
			}
		} else {
			$files2 = $_POST['fileurl2'];
			if (!empty($files2)) {
				mysqli_query( $conn,"UPDATE tbl_complaint_records set files2='". $files2 ."', filetype2='". $filetype2 ."' WHERE care_id='". $IDs ."'" );
			}
		}
       
    	$sql = "UPDATE tbl_complaint_records set care_date='$care_date',cusEmail='$cusEmail',cusName='$cusName',cusAddress='$cusAddress',phoneNo='$phoneNo',product_name='$product_name',reply_type='$reply_type',date_of_acknowledgement='$date_of_acknowledgement',product_description='$product_description',reply_to_customer='$reply_to_customer',METRC_package_id='$METRC_package_id',complaint_type='$complaint_type',complaint_category='$complaint_category',lot_code='$lot_code',product_expiry='$product_expiry',product_expiry_remarks='$product_expiry_remarks',product_purchased_date='$product_purchased_date',product_purchased_date_remarks='$product_purchased_date_remarks',product_purchase_location='$product_purchase_location',person_contacted='$person_contacted',person_handling='$person_handling',nature_complaint='$nature_complaint',action_taken='$action_taken',date_resolution='$date_resolution',investigation_started ='$investigation_started',resolution_desc ='$resolution_desc',care_addedby='$cookie' where care_id = $IDs";
        if(mysqli_query($conn, $sql)){
            $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
            $queryr = "SELECT * FROM tbl_complaint_records where care_id = $IDs";
            $resultr = mysqli_query($conn, $queryr);
            while($row = mysqli_fetch_array($resultr)) { 
                
                $complaint_type = $row['complaint_type'];
                if($row['complaint_type'] == 0){ $complaint_type = ''; }
                else if($row['complaint_type'] == 1){ $complaint_type = 'Electronic (Email)'; }
                else if($row['complaint_type'] == 2){ $complaint_type = 'Electronic (Social Media)'; }
                else if($row['complaint_type'] == 3){ $complaint_type = 'Oral'; }
                else if($row['complaint_type'] == 4){ $complaint_type = 'Written'; }
                
                $complaint_category = $row['complaint_category'];
                if($row['complaint_category'] == 0){ $complaint_category = ''; }
                else if($row['complaint_category'] == 1){ $complaint_category = 'Caused Illness or Injury'; }
                else if($row['complaint_category'] == 2){ $complaint_category = 'Foreign Material in Cannabis Product Container'; }
                else if($row['complaint_category'] == 3){ $complaint_category = 'Foul Odor'; }
                else if($row['complaint_category'] == 4){ $complaint_category = 'Improper Packaging'; }
                else if($row['complaint_category'] == 5){ $complaint_category = 'Incorrect Concentration of Cannabinoids'; }
                else if($row['complaint_category'] == 6){ $complaint_category = 'Mislabeling'; }
                                                
                $cam_date = $row['care_date'];
                $cam_date = new DateTime($cam_date);
                $cam_date = $cam_date->format('Y-m-d');
            ?>
                <td class="<?php echo $_COOKIE['client'] == 1 ? 'hide':''; ?>"><?php echo $row['care_id'] ?></td>
                <td><?php echo $cam_date ?></td>
                <td><?php echo $row['cusName'] ?></td>
                <td class="<?php echo $_COOKIE['client'] == 1 ? '':'hide'; ?>"><?php echo $complaint_type ?></td>
                <td class="<?php echo $_COOKIE['client'] == 1 ? '':'hide'; ?>"><?php echo $complaint_category ?></td>
                <td class="<?php echo $_COOKIE['client'] == 1 ? 'hide':''; ?>"><?php echo $row['cusAddress'] ?></td>
                <td class="<?php echo $_COOKIE['client'] == 1 ? 'hide':''; ?>"><?php echo $row['phoneNo'] ?></td>
                <td><?php echo $row['product_name'] ?></td>
                <td class="text-center <?php echo $_COOKIE['client'] == 1 ? 'hide':''; ?>">
                    <div class="btn-group btn-group">
                        <a  href="#modal_capa" data-toggle="modal" type="button" id="update_capa" data-id="<?= $row['care_id']; ?>" class="btn btn-outline dark btn-sm">ICAR</a>
	                    <a href="#modal_capa_pdf" data-toggle="modal" type="button" id="pdf_capa" data-id="<?= $row['care_id']; ?>" class="btn btn-outline btn-danger btn-sm" onclick="">PDF</a>
                    </div>
                </td>
                <td class="text-center <?php echo $_COOKIE['client'] == 1 ? 'hide':''; ?>">
                    <div class="btn-group btn-group">
	                    <a href="#modal_scar" data-toggle="modal" type="button" id="update_scar" data-id="<?= $row['care_id']; ?>" class="btn btn-outline dark btn-sm" onclick="">SCAR</a>
                        <a  href="#modal_scar_pdf" data-toggle="modal" type="button" id="pdf_scar" data-id="<?= $row['care_id']; ?>" class="btn btn-outline btn-danger btn-sm">PDF</a>
                    </div>
                </td>
                <td class="text-center <?php echo $_COOKIE['client'] == 1 ? '':'hide'; ?>">
                    <?php echo '<input type="checkbox" value="'.$row['capam'].'" onclick="btnCapam(this, '.$row['care_id'].')" '; echo $row['capam']==1 ? 'CHECKED':''; echo '/>'; ?>
                </td>
                <td class="text-center">
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_complaint" data-toggle="modal" type="button" id="update_complaint" data-id="<?= $row['care_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_complaint" data-toggle="modal" type="button" id="delete_complaint" data-id="<?= $row['care_id']; ?>" class="btn btn-warning btn-sm" onclick="">Delete</a>
                    </div>
                </td>
            <?php }
              
              
        }
    }

    //delete pricing
    if( isset($_GET['delete_complaint_id']) ) {
    	$ID = $_GET['delete_complaint_id'];

    	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
    	    ';
    	        $query = "SELECT * FROM tbl_complaint_records where care_id = $ID";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result))
                { ?>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"><b>Date: </b></label>
                            <i><?= $row['care_date']; ?></i>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"><b>Customer Name: </b></label>
                            <i><?= $row['cusName']; ?></i>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"><b>Customer Address: </b></label>
                            <i><?= $row['cusAddress']; ?></i>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"><b>Phone#: </b></label>
                            <i><?= $row['phoneNo']; ?></i>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"><b>Product Name: </b></label>
                            <i><?= $row['product_name']; ?></i>
                        </div>
                    </div>
        <?php } 
    }
    if( isset($_POST['btndelete_complaint']) ) {
        $cookie = $_COOKIE['ID'];
      $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    	$sql = "UPDATE tbl_complaint_records set deleted = 1,care_addedby = '$cookie' where care_id = $IDs";
        if(mysqli_query($conn, $sql)){
              echo $IDs;
              
        }
    }

    //get capa report
    if( isset($_GET['get_capa_id']) ) {
    	$ID = $_GET['get_capa_id'];

    	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
    	    ';
    	        $query = "SELECT * FROM tbl_complaint_capa where comp_record_id = $ID";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result))
                { ?>
                     <div class="tabbable tabbable-tabdrop">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab1_capa" data-toggle="tab">Page 1</a>
                                </li>
                                <li>
                                    <a href="#tab2_capa" data-toggle="tab">Page 2</a>
                                </li>
                                <li>
                                    <a href="#tab3_capa" data-toggle="tab">Page 3</a>
                                </li>
                            </ul>
                            <div class="tab-content margin-top-20">
                                <div class="tab-pane active" id="tab1_capa">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                           <label>Initiated by:</label>
                                           <select class="form-control mt-multiselect btn btn-default" type="text" name="initiated_by" required>
                                                <option value="0">---Select---</option>
                                                <?php 
                                                    
                                                    $query_initiated = "SELECT *  FROM tbl_hr_employee where user_id = $user_id order by first_name ASC";
                                                    $result_initiated = mysqli_query($conn, $query_initiated);
                                                                                
                                                    while($row_initiated = mysqli_fetch_array($result_initiated))
                                                    { ?> 
                                                    <option value="<?php echo $row_initiated['ID']; ?>" <?php if($row_initiated['ID'] == $row['initiated_by']){ echo 'selected';} ?>><?php echo $row_initiated['first_name']; ?> <?php echo $row_initiated['last_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                        <div class="col-md-12">
                                           <label>Product Affected:</label>
                                           <input class="form-control" type="" name="product_affected" value="<?= $row['product_affected']; ?>">
                                       </div>
                                   </div>
                                   <div class="form-group">
                                        <div class="col-md-6">
                                           <label>Lot Code/Batch#:</label>
                                           <input class="form-control" type="" name="capa_lot_code" value="<?= $row['capa_lot_code']; ?>">
                                       </div>
                                       <div class="col-md-6">
                                           <label>Production Line:</label>
                                           <input class="form-control" type="" name="production_line" value="<?= $row['production_line']; ?>">
                                       </div>
                                   </div>
                                   <div class="form-group">
                                        <div class="col-md-12">
                                           <label>Summary of Complaint:</label>
                                           <textarea class="form-control border-bottom" type="" name="capa_summary_complaint" placeholder="Specify"><?= $row['capa_summary_complaint']; ?></textarea>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                        <div class="col-md-12">
                                           <label>Investigation & Quality Members:</label>
                                       </div>
                                   </div>
                                   <table class="table table-bordered">
                                       <tbody id="dynamic_field_no_emp">
                                           <?php
                                            $query_emp = mysqli_query($conn, "select * from tbl_complaint_quality_members where qm_ownedby = '$user_id'  and capa_record_id=$ID");
                                            foreach($query_emp as $row_emp){?>
                                                <tr id="row_emp_<?= $row_emp['qm_id']; ?>">
                                                       <td>
                                                            <?= $row_emp['quality_member']; ?>
                                                       </td>
                                                       <td>
                                                            <?= $row_emp['qm_desc']; ?>
                                                       </td>
                                                       <td width="50px">
                                                       </td>
                                                   </tr>
                                            <?php }
                                           ?>
                                           <tr>
                                               <td>
                                                    <input class="form-control" type="" name="quality_member[]" >
                                               </td>
                                               <td>
                                                    <input class="form-control" type="" name="qm_desc[]" >
                                               </td>
                                               <td width="50px">
                                                   <button type="button" name="add_no_emp_row" id="add_no_emp_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button>
                                               </td>
                                           </tr>
                                       </tbody>
                                   </table>
                                   <hr>
                                   <div class="form-group">
                                       <div class="col-md-12">
                                           <label class="col-md-4">Describe the Problem:</label>
                                           <label class="col-md-8 border-left">Please attach the image to the next page as much as possible.</label>
                                       </div>
                                        <div class="col-md-12">
                                           <textarea class="form-control border-bottom" type="" name="capa_describe" placeholder="Specify"><?= $row['capa_describe']; ?></textarea>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <div class="col-md-12">
                                           <label class="col-md-4">Root Cause:</label>
                                           <label class="col-md-8 border-left">Please attach the image to the next page as much as possible.</label>
                                       </div>
                                        <div class="col-md-12">
                                           <textarea class="form-control border-bottom" type="" name="root_cause" placeholder="Specify"><?= $row['root_cause']; ?></textarea>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <div class="col-md-12">
                                           <label class="col-md-4">Corrective Actions:</label>
                                           <label class="col-md-8 border-left">Please attach the image to the next page as much as possible.</label>
                                       </div>
                                        <div class="col-md-12">
                                           <textarea class="form-control border-bottom" type="" name="corrective_action" placeholder="Specify"><?= $row['corrective_action']; ?></textarea>
                                       </div>
                                   </div>
                            </div>
                            <div class="tab-pane" id="tab2_capa">
                               <div class="form-group">
                                    <div class="col-md-6">
                                       <label>PO#:</label>
                                       <input class="form-control border-bottom" type="" name="capa_po" value="<?= $row['capa_po']; ?>">
                                   </div>
                                   <div class="col-md-6">
                                       <label>Claim Received Date:</label>
                                       <input class="form-control border-bottom" type="date" name="claim_received_date" value="<?php if(!empty($row['claim_received_date'] OR $row['claim_received_date'] != '')){ echo date('Y-m-d', strtotime($row['claim_received_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>">
                                   </div>
                               </div>
                               <div class="form-group">
                                    <div class="col-md-6">
                                       <label>Client #:</label>
                                       <input class="form-control border-bottom" type="" name="capa_client" value="<?= $row['capa_client']; ?>">
                                   </div>
                                   <div class="col-md-6">
                                       <label>Claim & Defect QTY:</label>
                                       <input class="form-control border-bottom" type="" name="claim_defect_qty" value="<?= $row['claim_defect_qty']; ?>">
                                   </div>
                               </div>
                               <div class="form-group">
                                    <div class="col-md-12">
                                       <label>Remarks:</label>
                                       <textarea class="form-control border-bottom" type="" name="remarks" placeholder="Specify"><?= $row['remarks']; ?></textarea>
                                   </div>
                               </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Image of the Problem:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <?php
                                                    if ( empty($row['problem_img']) ) {
                                                        echo '<img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />';
                                                    } else {
                                                        echo '<img src="customer_care_file/'.$row['problem_img'].'" class="img-responsive" alt="Avatar" />';
                                                    }
                                                ?>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px; max-width: 200px; max-height: 150px;"> </div>
                                            <center>
                                                <div>
                                                    <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input class="form-control" type="file" name="problem_img" />
                                                        <input class="form-control" type="hidden" name="problem_img2" value="<?= $row['problem_img']; ?>">
                                                    </span>
                                                    <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                </div>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Image of Root Cause for Explanation:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <?php
                                                    if ( empty($row['root_cause_img']) ) {
                                                        echo '<img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />';
                                                    } else {
                                                        echo '<img src="customer_care_file/'.$row['root_cause_img'].'" class="img-responsive" alt="Avatar" />';
                                                    }
                                                ?>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px; max-width: 200px; max-height: 150px;"> </div>
                                            <center>
                                                <div>
                                                    <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input class="form-control" type="file" name="root_cause_img" />
                                                        <input class="form-control" type="hidden" name="root_cause_img2" value="<?= $row['root_cause_img']; ?>">
                                                    </span>
                                                    <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                </div>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Image for Corrective Actions:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <?php
                                                    if ( empty($row['corrective_action_img']) ) {
                                                        echo '<img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />';
                                                    } else {
                                                        echo '<img src="customer_care_file/'.$row['corrective_action_img'].'" class="img-responsive" alt="Avatar" />';
                                                    }
                                                ?>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px; max-width: 200px; max-height: 150px;"> </div>
                                            <center>
                                                <div>
                                                    <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input class="form-control" type="file" name="corrective_action_img" />
                                                        <input class="form-control" type="hidden" name="corrective_action_img2" value="<?= $row['corrective_action_img']; ?>">
                                                    </span>
                                                    <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                </div>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab3_capa">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <label>Status:</label>
                                        </div>
                                        <div class="col-md-4">
                                            <label>
                                                <input type="radio" name="status_comp" value="1" <?php if($row['status_comp']== 1){echo 'checked'; } ?>>
                                                Open
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <label>
                                                <input type="radio" name="status_comp" value="0" <?php if($row['status_comp']== 0){echo 'checked'; } ?>>
                                                Closed
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <label>
                                                <input type="radio" name="status_comp" value="2" <?php if($row['status_comp']== 2){echo 'checked'; } ?>>
                                                Follow Up
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 border-left">
                                        <div class="col-md-12">
                                            <label>Date:</label>
                                            <input type="date" class="form-control border-bottom" name="status_date" value="<?php if(!empty($row['status_date'] OR $row['status_date'] != '')){ echo date('Y-m-d', strtotime($row['status_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Date Performed:</label>
                                        <input type="date" class="form-control border-bottom" name="date_perform" value="<?php if(!empty($row['date_perform'] OR $row['date_perform'] != '')){ echo date('Y-m-d', strtotime($row['date_perform']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Investigated By:</label>
                                        <select class="form-control mt-multiselect btn btn-default" type="text" name="investigated_by">
                                            <option value="0">---Select---</option>
                                            <?php 
                                                
                                                $query_investigated = "SELECT *  FROM tbl_hr_employee where user_id = $user_id order by first_name ASC";
                                                $result_investigated = mysqli_query($conn, $query_investigated);
                                                                            
                                                while($row_investigated = mysqli_fetch_array($result_investigated))
                                                { ?> 
                                                <option value="<?php echo $row_investigated['ID']; ?>" <?php if($row_investigated['ID'] == $row['investigated_by']){ echo 'selected';} ?>><?php echo $row_investigated['first_name']; ?> <?php echo $row_investigated['last_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Date:</label>
                                        <input type="date" class="form-control border-bottom" name="investigated_date" value="<?php if(!empty($row['investigated_date'] OR $row['investigated_date'] != '')){ echo date('Y-m-d', strtotime($row['investigated_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Verified By:</label>
                                        <select class="form-control mt-multiselect btn btn-default" type="text" name="verified_by">
                                            <option value="0">---Select---</option>
                                            <?php 
                                                
                                                $query_verified_by = "SELECT *  FROM tbl_hr_employee where user_id = $user_id order by first_name ASC";
                                                $result_verified_by = mysqli_query($conn, $query_verified_by);
                                                                            
                                                while($row_verified_by = mysqli_fetch_array($result_verified_by))
                                                { ?> 
                                                <option value="<?php echo $row_verified_by['ID']; ?>" <?php if($row_verified_by['ID'] == $row['verified_by']){ echo 'selected';} ?>><?php echo $row_verified_by['first_name']; ?> <?php echo $row_verified_by['last_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Date:</label>
                                        <input type="date" class="form-control border-bottom" name="verified_date"  value="<?php if(!empty($row['verified_date'] OR $row['verified_date'] != '')){ echo date('Y-m-d', strtotime($row['verified_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Approved By:</label>
                                        <select class="form-control mt-multiselect btn btn-default border-bottom" type="text" name="approved_by">
                                            <option value="0">---Select---</option>
                                            <?php 
                                                
                                                $query_approved_by = "SELECT *  FROM tbl_hr_employee where user_id = $user_id order by first_name ASC";
                                                $result_approved_by = mysqli_query($conn, $query_approved_by);
                                                                            
                                                while($row_approved_by = mysqli_fetch_array($result_approved_by))
                                                { ?> 
                                                <option value="<?php echo $row_approved_by['ID']; ?>" <?php if($row_approved_by['ID'] == $row['approved_by']){ echo 'selected';} ?>><?php echo $row_approved_by['first_name']; ?> <?php echo $row_approved_by['last_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Date:</label>
                                        <input type="date" class="form-control border-bottom" name="approved_date" value="<?php if(!empty($row['approved_date'] OR $row['approved_date'] != '')){ echo date('Y-m-d', strtotime($row['approved_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php } 
    }
    if( isset($_POST['btnSave_capa']) ) {
      
        $cookie = $_COOKIE['ID'];
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $initiated_by = mysqli_real_escape_string($conn,$_POST['initiated_by']);
        $product_affected = mysqli_real_escape_string($conn,$_POST['product_affected']);
        $capa_lot_code = mysqli_real_escape_string($conn,$_POST['capa_lot_code']);
        $production_line = mysqli_real_escape_string($conn,$_POST['production_line']);
        
        $capa_summary_complaint = mysqli_real_escape_string($conn,$_POST['capa_summary_complaint']);
        $capa_describe = mysqli_real_escape_string($conn,$_POST['capa_describe']);
        $root_cause = mysqli_real_escape_string($conn,$_POST['root_cause']);
        $corrective_action = mysqli_real_escape_string($conn,$_POST['corrective_action']);
        $capa_po = mysqli_real_escape_string($conn,$_POST['capa_po']);
        $claim_received_date = mysqli_real_escape_string($conn,$_POST['claim_received_date']);
        $capa_client = mysqli_real_escape_string($conn,$_POST['capa_client']);
        $claim_defect_qty = mysqli_real_escape_string($conn,$_POST['claim_defect_qty']);
        $remarks = mysqli_real_escape_string($conn,$_POST['remarks']);
        $status_comp = mysqli_real_escape_string($conn,$_POST['status_comp']);
        $date_perform = mysqli_real_escape_string($conn,$_POST['date_perform']);
        
        $investigated_by = mysqli_real_escape_string($conn,$_POST['investigated_by']);
        $investigated_date = mysqli_real_escape_string($conn,$_POST['investigated_date']);
        $verified_by = mysqli_real_escape_string($conn,$_POST['verified_by']);
        $verified_date = mysqli_real_escape_string($conn,$_POST['verified_date']);
        $approved_by = mysqli_real_escape_string($conn,$_POST['approved_by']);
        $approved_date = mysqli_real_escape_string($conn,$_POST['approved_date']);
        
        $file1 = $_FILES['problem_img']['name'];
        if(!empty($file1)){
            $filename1 = pathinfo($file1, PATHINFO_FILENAME);
            $extension = end(explode(".", $_FILES['problem_img']['name']));
            $rand = rand(10,1000000);
            $problem_img =  mysqli_real_escape_string($conn,$rand." - ".$filename1.".".$extension);
            $to_File_Documents = $rand." - ".$filename1.".".$extension;
            move_uploaded_file($_FILES['problem_img']['tmp_name'],'../customer_care_file/'.$to_File_Documents);
        }else{ $problem_img = mysqli_real_escape_string($conn,$_POST['problem_img2']); }
        
        $file2 = $_FILES['root_cause_img']['name'];
        if(!empty($file2)){
            $filename2 = pathinfo($file2, PATHINFO_FILENAME);
            $extension = end(explode(".", $_FILES['root_cause_img']['name']));
            $rand = rand(10,1000000);
            $root_cause_img =  mysqli_real_escape_string($conn,$rand." - ".$filename2.".".$extension);
            $to_File_Documents = $rand." - ".$filename2.".".$extension;
            move_uploaded_file($_FILES['root_cause_img']['tmp_name'],'../customer_care_file/'.$to_File_Documents);
        }else{ $root_cause_img = mysqli_real_escape_string($conn,$_POST['root_cause_img2']); }
        
        $file3 = $_FILES['corrective_action_img']['name'];
        if(!empty($file3)){
            $filename3 = pathinfo($file3, PATHINFO_FILENAME);
            $extension = end(explode(".", $_FILES['corrective_action_img']['name']));
            $rand = rand(10,1000000);
            $corrective_action_img =  mysqli_real_escape_string($conn,$rand." - ".$filename3.".".$extension);
            $to_File_Documents = $rand." - ".$filename3.".".$extension;
            move_uploaded_file($_FILES['corrective_action_img']['tmp_name'],'../customer_care_file/'.$to_File_Documents);
        }else{ $corrective_action_img = mysqli_real_escape_string($conn,$_POST['corrective_action_img2']); }
       
        // for quality members
        $quality_member = implode(' | ', $_POST["quality_member"]);
        $quality_member = explode(' | ', $quality_member);
        foreach($quality_member as $con){$con;}
        $con;
        if(!empty($con))
        {
            $i = 0;
           foreach($quality_member as $val)
            {
                $qm_desc = $_POST["qm_desc"][$i];
                
                $sql_emp = "INSERT INTO tbl_complaint_quality_members(quality_member,qm_desc,capa_record_id,qm_addedby,qm_ownedby) 
                VALUES('".mysqli_real_escape_string($conn, $val)."','$qm_desc','$IDs','$cookie','$user_id')";
                if(mysqli_query($conn, $sql_emp)){
                    $last_id = mysqli_insert_id($conn);
                 }
                $i++;
            }
        }
        
    	$sql = "UPDATE tbl_complaint_capa set initiated_by='$initiated_by',product_affected='$product_affected',capa_lot_code='$capa_lot_code',production_line='$production_line',capa_summary_complaint='$capa_summary_complaint',capa_describe='$capa_describe',root_cause='$root_cause',corrective_action='$corrective_action',capa_po='$capa_po',claim_received_date='$claim_received_date',capa_client='$capa_client',claim_defect_qty='$claim_defect_qty',remarks='$remarks',status_comp='$status_comp',date_perform='$date_perform',investigated_by='$investigated_by',investigated_date='$investigated_date',verified_by='$verified_by',verified_date='$verified_date',approved_by='$approved_by',approved_date='$approved_date',problem_img='$problem_img',root_cause_img='$root_cause_img',corrective_action_img='$corrective_action_img',capa_addedby='$cookie' where comp_record_id = $IDs";
        if(mysqli_query($conn, $sql)){
            echo $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        }
    }

    //get capa report
    if( isset($_GET['get_scar_id']) ) {
    	$ID = $_GET['get_scar_id'];

    	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
    	    ';
    	        $query = "SELECT * FROM tbl_complaint_scar where scar_record_id = $ID";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result))
                { ?>
                    <div class="tabbable tabbable-tabdrop">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab1_scar" data-toggle="tab">Page 1</a>
                                </li>
                                <li>
                                    <a href="#tab2_scar" data-toggle="tab"> 2 </a>
                                </li>
                                <li>
                                    <a href="#tab3_scar" data-toggle="tab"> 3 </a>
                                </li>
                                <li>
                                    <a href="#tab4_scar" data-toggle="tab"> 4 </a>
                                </li>
                                <li>
                                    <a href="#tab5_scar" data-toggle="tab"> 5 </a>
                                </li>
                                <li>
                                    <a href="#tab6_scar" data-toggle="tab"> 6 </a>
                                </li>
                                <li>
                                    <a href="#tab7_scar" data-toggle="tab"> 7 </a>
                                </li>
                                <li>
                                    <a href="#tab8_scar" data-toggle="tab"> 8 </a>
                                </li>
                                <li>
                                    <a href="#tab9_scar" data-toggle="tab"> 9 </a>
                                </li>
                                <li>
                                    <a href="#tab10_scar" data-toggle="tab"> 10 </a>
                                </li>
                                <li>
                                    <a href="#tab11_scar" data-toggle="tab"> 11 </a>
                                </li>
                            </ul>
                            <div class="tab-content margin-top-20">
                                <div class="tab-pane active" id="tab1_scar">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                           <label>SCAR Number:</label>
                                           <input class="form-control border-bottom" type="" name="scar_number" value="<?= $row['scar_number']; ?>">
                                       </div>
                                       <div class="col-md-4">
                                           <label>Request Date:</label>
                                           <input class="form-control border-bottom" type="date" name="request_date" value="<?php if(!empty($row['request_date'] OR $row['request_date'] != '')){ echo date('Y-m-d', strtotime($row['request_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>">
                                       </div>
                                       <div class="col-md-4">
                                           <label>Received (SCAR Completed) Date:</label>
                                           <input class="form-control border-bottom" type="date" name="received_date" value="<?php if(!empty($row['received_date'] OR $row['received_date'] != '')){ echo date('Y-m-d', strtotime($row['received_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>">
                                       </div>
                                   </div>
                                   <hr>
                                   <div class="form-group">
                                        <div class="col-md-4">
                                           <label>Submitted By:</label>
                                           <input class="form-control border-bottom" type="" name="submitted_by" value="<?= $row['submitted_by']; ?>">
                                       </div>
                                       <div class="col-md-4">
                                           <label>Date / Time:</label>
                                           <input class="form-control border-bottom" type="date" name="date_time" value="<?php if(!empty($row['date_time'] OR $row['date_time'] != '')){ echo date('Y-m-d', strtotime($row['date_time']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>">
                                       </div>
                                       <div class="col-md-4">
                                           <label>Submitted To (Supplier):</label>
                                           <input class="form-control border-bottom" type="date" name="submitted_to" value="<?= $row['submitted_to']; ?>">
                                       </div>
                                   </div>
                                   <hr>
                                   <div class="form-group">
                                        <div class="col-md-12">
                                           <label>Customer Name:</label>
                                           <input class="form-control border-bottom" type="" name="customer_name" value="<?= $row['customer_name']; ?>">
                                       </div>
                                   </div>
                                   <div class="form-group">
                                        <div class="col-md-6">
                                           <label>Address:</label>
                                           <input class="form-control" type="" name="scar_address" value="<?= $row['scar_address']; ?>">
                                       </div>
                                       <div class="col-md-6">
                                           <label>Phone:</label>
                                           <input class="form-control" type="" name="scar_phone" value="<?= $row['scar_phone']; ?>">
                                       </div>
                                   </div>
                                   <div class="form-group">
                                        <div class="col-md-6">
                                           <label>Contact:</label>
                                           <input class="form-control" type="" name="scar_contact" value="<?= $row['scar_contact']; ?>">
                                       </div>
                                       <div class="col-md-6">
                                           <label>Email:</label>
                                           <input class="form-control" type="email" name="scar_email" value="<?= $row['scar_email']; ?>">
                                       </div>
                                   </div>
                                   <div class="form-group">
                                        <div class="col-md-12">
                                           <label>Location Issuing the SCAR:</label>
                                           <input class="form-control border-bottom" type="" name="location_issuing" value="<?= $row['location_issuing']; ?>">
                                       </div>
                                   </div>
                                   <div class="form-group">
                                        <div class="col-md-6">
                                           <label>Supplier Product:</label>
                                           <input class="form-control" type="" name="supplier_product" value="<?= $row['supplier_product']; ?>">
                                       </div>
                                       <div class="col-md-6">
                                           <label>Product Code:</label>
                                           <input class="form-control" type="" name="product_code" value="<?= $row['product_code']; ?>">
                                       </div>
                                   </div>
                                   <div class="form-group">
                                        <div class="col-md-6">
                                           <div class="col-md-6">
                                               <label>Product Lot:</label>
                                                <input class="form-control border-bottom" type="" name="product_lot" value="<?= $row['product_lot']; ?>">
                                           </div>
                                           <div class="col-md-6">
                                               <label>PO number</label>
                                                <input class="form-control border-bottom" type="" name="scar_po_number" value="<?= $row['scar_po_number']; ?>">
                                           </div>
                                       </div>
                                       <div class="col-md-6">
                                           <label>Product Quantity:</label>
                                           <input class="form-control border-bottom" type="" name="product_quantity" value="<?= $row['product_quantity']; ?>">
                                       </div>
                                   </div>
                                </div>
                            <div class="tab-pane" id="tab2_scar">
                                <center>
                                    <h5><b>STEP 1 – NON-CONFORMANCE DESCRIPTION:</b></h5>
                                    <p>Identify the finding / issue(s) which requires  Corrective Action (CA) <br> Preventative Action (PA) / and Root Cause Analysis (RCA).<br>
                                    Include the Requirement(s), the finding, and the “as evidence by” stated on the CAR.</p>
                                </center>
                                <hr>
                               <div class="form-group">
                                    <div class="col-md-12">
                                       <label>Description of Discrepancy (Required):</label>
                                       <textarea class="form-control border-bottom" type="" name="desc_discrepancy" placeholder="Specify"><?= $row['desc_discrepancy']; ?></textarea>
                                   </div>
                               </div>
                               <div class="form-group">
                                    <div class="col-md-12">
                                       <label>Findings:</label>
                                       <textarea class="form-control border-bottom" type="" name="findings" placeholder="Specify"><?= $row['findings']; ?></textarea>
                                   </div>
                               </div>
                               <div class="form-group">
                                    <div class="col-md-12">
                                       <label>As Evidenced By:</label>
                                       <textarea class="form-control border-bottom" type="" name="as_evidenced_by" placeholder="Specify"><?= $row['as_evidenced_by']; ?></textarea>
                                   </div>
                               </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Image Reference</label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <?php
                                                    if ( empty($row['image_reference']) ) {
                                                        echo '<img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive" alt="Avatar" />';
                                                    } else {
                                                        echo '<img src="customer_care_file/'.$row['image_reference'].'" class="img-responsive" alt="Avatar" />';
                                                    }
                                                ?>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px; max-width: 200px; max-height: 150px;"> </div>
                                            <center>
                                                <div>
                                                    <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input class="form-control" type="file" name="image_reference" />
                                                        <input class="form-control" type="hidden" name="image_reference2" / value="<?= $row['image_reference']; ?>">
                                                    </span>
                                                    <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                </div>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab3_scar">
                                <center>
                                    <h5><b>FOR SUPPLIER USE ONLY</b></h5>
                                    <p>Please complete Step 2 within 3 Business Days (72 HOURS) of the Issue Date</p>
                                </center>
                                <div>
                                    <b>STEP 2 – CONTAINMENT ACTIONS:</b>
                                    <p>Detail the containment Actions taken, the dates of containment ( if complete, just type “complete” ),
                                    and who performed the task for potential areas affected, at the customer, WIP, items in stock, at the supplier, and any other areas affected.</p>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <center><label><b>Respond to each question. If the question does not apply to this response, please put N/A.</b></label></center>
                                    </div>
                                    <div class="col-md-7 border-right">
                                        <div class="col-md-12"><label>Extent of Condition</label></div>
                                        <hr>
                                        <div class="col-md-2">1</div>
                                        <div class="col-md-5">
                                            a) How many total products were affected?
                                            <br><br>
                                            b) Where are they?
                                        </div>
                                        <div class="col-md-5">
                                            <div class="col-md-12">
                                                <label>Qty:</label>
                                                <input class="form-control border-bottom" name="scar_qty" value="<?= $row['scar_qty']; ?>">
                                            </div>
                                            <div class="col-md-12">
                                                <label>Shipping:</label>
                                                <input class="form-control border-bottom" name="scar_shipping" value="<?= $row['scar_shipping']; ?>">
                                            </div>
                                            <div class="col-md-12">
                                                <label>Stock In:</label>
                                                <input class="form-control border-bottom" name="stock_in" value="<?= $row['stock_in']; ?>">
                                            </div>
                                            <div class="col-md-12">
                                                <label>Transit:</label>
                                                <input class="form-control border-bottom" name="transit" value="<?= $row['transit']; ?>">
                                            </div>
                                            <div class="col-md-12">
                                                <label>Other:</label>
                                                <input class="form-control border-bottom" name="scar_other" value="<?= $row['scar_other']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="col-md-12"><label>Responsible Party</label></div>
                                        <hr>
                                        <textarea class="form-control border-none" rows="15" name="responsible_party1"><?= $row['responsible_party1']; ?></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-7 border-right">
                                        
                                        <div class="col-md-2">2</div>
                                        <div class="col-md-5">
                                            How many are conforming?
                                        </div>
                                        <div class="col-md-5">
                                            <div class="col-md-12">
                                                <label>Qty:</label>
                                                <input class="form-control border-bottom" name="conforming_qty" value="<?= $row['conforming_qty']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <textarea class="form-control border-none" rows="5" name="responsible_party2"><?= $row['responsible_party2']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab4_scar">
                                <div class="form-group">
                                    <div class="col-md-7 border-right"><div class="col-md-12"><label>Extent of Condition</label></div>
                                        <hr>
                                        <div class="col-md-2">3</div>
                                        <div class="col-md-5">
                                            How many are nonconforming (NC)?
                                        </div>
                                        <div class="col-md-5">
                                            <div class="col-md-12">
                                                <label>NC Tag #:</label>
                                                <input class="form-control border-bottom" name="nc_tag" value="<?= $row['nc_tag']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5"><div class="col-md-12"><label>Responsible Party</label></div>
                                        <hr>
                                        <textarea class="form-control border-none" rows="5" name="responsible_party3"><?= $row['responsible_party3']; ?></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-7 border-right">
                                        <div class="col-md-2">4</div>
                                        <div class="col-md-5">
                                           What steps were taken to ensure the nonconforming product does not leave suppliers’ premises (i.e., Quality Alert, Stop Shipment, etc.)?
                                        </div>
                                        <div class="col-md-5">
                                            <div class="col-md-12">
                                                <textarea class="form-control border-none" rows="5" name="nonconforming_step"><?= $row['nonconforming_step']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <textarea class="form-control border-none" rows="5" name="responsible_party4"><?= $row['responsible_party4']; ?></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-7 border-right">
                                        <div class="col-md-2">5</div>
                                        <div class="col-md-5">
                                          Was the sub-tier supplier at fault?
                                            <br><br>
                                            If yes, enter the Supplier CAR number.
                                        </div>
                                        <div class="col-md-5">
                                            <div class="col-md-12">
                                                <div class="col-md-6">
                                                    <label>
                                                        <input type="radio" name="is_yes" value="1" <?php if($row['is_yes']==1){echo 'checked';} ?>> Yes
                                                    </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>
                                                        <input type="radio" name="is_yes" value="0" <?php if($row['is_yes']==0){echo 'checked';} ?>> No
                                                    </label>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-md-12">
                                                <textarea class="form-control border-bottom" rows="3" name="supplier_car_number"><?= $row['supplier_car_number']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <textarea class="form-control border-none" rows="5" name="responsible_party5"><?= $row['responsible_party5']; ?></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-7 border-right">
                                        <div class="col-md-12">
                                            <b>Communication of non-conformance to ALL affected parties.</b>
                                            <p>List all parties notified of escape (internal and external) and the date notified.</p>
                                        </div>
                                        <div class="col-md-2">6</div>
                                        <div class="col-md-5">
                                         Was there a Post Delivery Notification issued to the customer?
                                         <br><br>
                                            If yes, enter the record number.
                                        </div>
                                        <div class="col-md-5">
                                            <div class="col-md-12">
                                                <div class="col-md-6">
                                                    <label>
                                                        <input type="radio" name="record_number_is_yes" value="1" <?php if($row['record_number_is_yes']==1){echo 'checked';} ?>> Yes
                                                    </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>
                                                        <input type="radio" name="record_number_is_yes" value="0" <?php if($row['record_number_is_yes']==0){echo 'checked';} ?>> No
                                                    </label>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-md-12">
                                                <textarea class="form-control border-bottom" rows="3" name="if_yes_car_number"><?= $row['if_yes_car_number']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="col-md-12">
                                            <label>Responsible Party</label>
                                        </div>
                                        <textarea class="form-control border-none" rows="5" name="responsible_party6"><?= $row['responsible_party6']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab5_scar">
                                <div class="table table-scrollable">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td></td>
                                                <td>Party or Persons Notified</td>
                                                <td>Date</td>
                                                <td>Responsible Party</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_person_notify">
                                            <?php 
                                                $count = 1;
                                                $query_notify = mysqli_query($conn, "select * from tbl_complaint_person_notify where scar_record_pk = '$ID'");
                                                foreach($query_notify as $row_notify){?>
                                                    <tr id="row_data_notify_<?= $row_notify['notify_id']; ?>">
                                                        <td><?= $count++; ?></td>
                                                        <td><?= $row_notify['person_notified']; ?></td>
                                                        <td><?= date('Y-m-d', strtotime($row_notify['date_notify'])); ?></td>
                                                        <td><?= $row_notify['responsible_party']; ?></td>
                                                        <td width="50px">
                                                       </td>
                                                    </tr>
                                                <?php }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><input class="form-control border-none" name="person_notified[]"></td>
                                                <td><input type="date" class="form-control border-none" name="date_notify[]"></td>
                                                <td><input class="form-control border-none" name="responsible_party[]"></td>
                                                <td width="50px">
                                                   <button type="button" name="add_notify_row" id="add_notify_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button>
                                               </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="table table-scrollable">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td></td>
                                                <td>Containment Actions were taken to correct the immediate non-conformance. <i style="color:red;">Include the activities. Include objective evidence that a completed response was acted on.</i></td>
                                                <td>Responsible Party</td>
                                                <td>Expected Completion</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_non_conformance">
                                            <?php 
                                                $count1 = 1;
                                                $query_non_conformance = mysqli_query($conn, "select * from tbl_complaint_non_conformance where scar_record_pk = '$ID'");
                                                foreach($query_non_conformance as $row_non){?>
                                                    <tr id="row_data_non_<?= $row_non['non_id']; ?>">
                                                        <td><?= $count1++; ?></td>
                                                        <td><?= $row_non['non_conformance']; ?></td>
                                                        <td><?= $row_non['responsible_party']; ?></td>
                                                        <td><?= date('Y-m-d', strtotime($row_non['expected_completion'])); ?></td>
                                                        <td width="50px">
                                                       </td>
                                                    </tr>
                                                <?php }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><input class="form-control border-none" name="non_conformance[]"></td>
                                                <td><input class="form-control border-none" name="responsible_party_non[]"></td>
                                                <td><input type="date" class="form-control border-none" name="expected_completion[]"></td>
                                                <td width="50px">
                                                   <button type="button" name="add_non_row" id="add_non_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button>
                                               </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab6_scar">
                                <div class="form-group">
                                    <center><h5><b>Please complete steps 3, 4, 5, and 6 within 7 days of Issue Date (or return of part)</b></h5></center>
                                </div>
                                <div class="col-md-12">
                                    <p><b>STEP 3 – ROOT CAUSE:</b><br>
                                    Perform a 5-Why analysis for each finding and each significant contributor to the problem. For escapes, include a 5-Why for the final inspection failure prior to shipping.</p>
                                </div>
                                <div class="table table-scrollable">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td width="100px">Finding 1</td>
                                                <td><input class="form-control border-none" name="finding1" value="<?= $row['finding1']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td><input class="form-control border-none" name="f1_why1" value="<?= $row['f1_why1']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td><input class="form-control border-none" name="f1_why2" value="<?= $row['f1_why2']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td><input class="form-control border-none" name="f1_why3" value="<?= $row['f1_why3']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td><input class="form-control border-none" name="f1_why4" value="<?= $row['f1_why4']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td><input class="form-control border-none" name="f1_why5" value="<?= $row['f1_why5']; ?>"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table table-scrollable">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td width="100px">Finding 2</td>
                                                <td><input class="form-control border-none" name="finding2" value="<?= $row['finding2']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td><input class="form-control border-none" name="f2_why1" value="<?= $row['f2_why1']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td><input class="form-control border-none" name="f2_why2" value="<?= $row['f2_why2']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td><input class="form-control border-none" name="f2_why3" value="<?= $row['f2_why3']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td><input class="form-control border-none" name="f2_why4" value="<?= $row['f2_why4']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td><input class="form-control border-none" name="f2_why5" value="<?= $row['f2_why5']; ?>"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table table-scrollable">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td width="100px">Finding 3</td>
                                                <td><input class="form-control border-none" name="finding3" value="<?= $row['finding3']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td><input class="form-control border-none" name="f3_why1" value="<?= $row['f3_why1']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td><input class="form-control border-none" name="f3_why2" value="<?= $row['f3_why2']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td><input class="form-control border-none" name="f3_why3" value="<?= $row['f3_why3']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td><input class="form-control border-none" name="f3_why4" value="<?= $row['f3_why4']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td><input class="form-control border-none" name="f3_why5" value="<?= $row['f3_why5']; ?>"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab7_scar">
                                <div class="form-group">
                                    <center><b>If another Root Cause methodology is used, other than the 5-Why, please attach to this form for objective evidence.<br></b></center>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <p>
                                             <b>Root Cause Statement:</b><br>
                                            The Root Cause is the most basic reason for a deficiency which, if eliminated, would prevent the problem from recurring.)
                                            – Include what failed in manufacturing and/or inspection. If you have identified a supplier is responsible, including the supplier’s Root Cause Corrective Action (RCCA) with this response.
                                        </p>
                                    </div>
                                </div>
                                <div class="table table-scrollable">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td width="150px">Finding 1</td>
                                                <td><textarea class="form-control border-none" rows="3" name="root_cause_finding1"><?= $row['root_cause_finding1']; ?></textarea></td>
                                            </tr>
                                            <tr>
                                                <td>Finding 2 (if utilized):</td>
                                                <td><textarea class="form-control border-none" rows="3" name="root_cause_finding2"><?= $row['root_cause_finding2']; ?></textarea></td>
                                            </tr>
                                            <tr>
                                                <td>Finding 3 (if utilized):</td>
                                                <td><textarea class="form-control border-none" rows="3" name="root_cause_finding3"><?= $row['root_cause_finding3']; ?></textarea></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <p>
                                             <b>STEP 4 – CORRECTIVE / PREVENTATIVE ACTION TASKS:</b><br>
                                            List all the corrective/preventative actions to be taken for each Root Cause. Ensure that the proposed actions address the identified root cause(s). 
                                            Include responsible parties and targeted completion dates in your response. Include either objective evidence that a completed response was acted on; this is required.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab8_scar">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <p>
                                             <b>NOTES:</b><br>
                                                1.) If your CA/PA actions reference attachments, they must be submitted with your response to [Enter Company Name]
                                                <br>
                                                2.) Is the CA/PA applicable to other areas? If so, identify the owner responsible for implementing Corrective Action in other areas.
                                        </p>
                                    </div>
                                </div>
                                <div class="table table-scrollable">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td></td>
                                                <td>CA/PA Required</td>
                                                <td>Responsible Party</td>
                                                <td>Expected Date of Completion</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody id="capa_data">
                                            <?php 
                                                $count1 = 1;
                                                $query_non_conformance = mysqli_query($conn, "select * from tbl_complaint_action_reference where scar_record_pk = '$ID'");
                                                foreach($query_non_conformance as $row_non){?>
                                                    <tr id="row_data_capa_<?= $row_non['cap_id']; ?>">
                                                        <td><?= $count1++; ?></td>
                                                        <td><?= $row_non['capa_required']; ?></td>
                                                        <td><?= $row_non['capa_responsible']; ?></td>
                                                        <td><?= date('Y-m-d', strtotime($row_non['capa_expected_completion'])); ?></td>
                                                        <td width="50px">
                                                       </td>
                                                    </tr>
                                                <?php }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><textarea class="form-control border-none" name="capa_required[]" rows="3"></textarea></td>
                                                <td><textarea class="form-control border-none" name="capa_responsible[]" rows="3"></textarea></td>
                                                <td><input class="form-control border-none" name="capa_expected_completion[]" type="date"></td>
                                                <td width="50px">
                                                   <button type="button" name="add_capa_row" id="add_capa_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button>
                                               </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-12">
                                       <label>Comments</label>
                                       <textarea class="form-control border-bottom" rows="3" name="step_4_comments"><?= $row['step_4_comments']; ?></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <center><b>List other products, processes, equipment, etc., that, upon review, may have similar issues. Does the identified problem in other products,
                                        processes, equipment, etc.? Does the problem affect other suppliers or vendor areas? Is it Plant-wide? Include these in your CA/PA actions</b></center>
                                    </div>
                                </div>
                                <div class="table table-scrollable">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td></td>
                                                <td>List other products, procedures, equipment, etc.</td>
                                                <td>Supplier / Vendor Affected</td>
                                                <td>Plant-wide?</td>
                                                <td>Responsible Party</td>
                                                <td>Expected Date of Completion</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody id="data_affected">
                                             <?php 
                                                $count1 = 1;
                                                $query_affected = mysqli_query($conn, "select * from tbl_complaint_affected where scar_record_pk = '$ID'");
                                                foreach($query_affected as $row_affected){?>
                                                    <tr id="row_data_capa_<?= $row_affected['affected_id']; ?>">
                                                        <td><?= $count1++; ?></td>
                                                        <td><?= $row_affected['list_other_products']; ?></td>
                                                        <td><?= $row_affected['supplier_vendor']; ?></td>
                                                        <td><?= $row_affected['plant_wide']; ?></td>
                                                        <td><?= $row_affected['affected_reponsible']; ?></td>
                                                        <td><?= date('Y-m-d', strtotime($row_affected['affected_completion'])); ?></td>
                                                        <td width="50px">
                                                       </td>
                                                    </tr>
                                                <?php }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><textarea class="form-control border-none" name="list_other_products[]" rows="3"></textarea></td>
                                                <td><textarea class="form-control border-none" name="supplier_vendor[]" rows="3"></textarea></td>
                                                <td><textarea class="form-control border-none" name="plant_wide[]" rows="3"></textarea></td>
                                                <td><textarea class="form-control border-none" name="affected_reponsible[]" rows="3"></textarea></td>
                                                <td><input class="form-control border-none" name="affected_completion[]" type="date"></td>
                                                <td width="50px">
                                                   <button type="button" name="add_affected_row" id="add_affected_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button>
                                               </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-12">
                                       <label>Comments</label>
                                       <textarea class="form-control border-bottom" rows="3" name="list_products_comments"><?= $row['list_products_comments']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab9_scar">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <p><b>STEP 5 – VERIFY THE EFFECTIVENESS OF THE CORRECTIVE/PREVENTATIVE ACTION:</b><br>
                                            Describe the process used to monitor/measure the CA/PA effectiveness in eliminating the Root Cause(s) and to ensure that the permanent actions taken have prevented the recurrence of the problem.
                                            <br><br>
                                            Evidence of completed action is mandatory; include changes in any process, procedures, equipment, training, including any rework documentation, policies, and work instructions with this document via attachment.
                                            <br><br>
                                            Ensure that the responsible party and the effective date are identified for each completed action
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <center>
                                            <b>List actions to verify each CA/PA action listed in Step 4.</b>
                                        </center>
                                    </div>
                                </div>
                                <div class="table table-scrollable">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td></td>
                                                <td>Verification Action Plan</td>
                                                <td>Responsible Party</td>
                                                <td>Expected Completion Date</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody id="data_verification">
                                            <?php 
                                                $count1 = 1;
                                                $query_verification = mysqli_query($conn, "select * from tbl_complaint_verification where scar_record_pk = '$ID'");
                                                foreach($query_verification as $row_verification){?>
                                                    <tr id="row_data_verification_<?= $row_verification['verification_id']; ?>">
                                                        <td><?= $count1++; ?></td>
                                                        <td><?= $row_verification['verification_plan']; ?></td>
                                                        <td><?= $row_verification['verification_party']; ?></td>
                                                        <td><?= date('Y-m-d', strtotime($row_verification['verification_date'])); ?></td>
                                                        <td width="50px">
                                                       </td>
                                                    </tr>
                                                <?php }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><textarea class="form-control border-none" name="verification_plan[]" rows="3"></textarea></td>
                                                <td><textarea class="form-control border-none" name="verification_party[]" rows="3"></textarea></td>
                                                <td><input class="form-control border-none" name="verification_date[]" type="date"></td>
                                                <td width="50px">
                                                   <button type="button" name="add_verification_row" id="add_verification_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button>
                                               </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <div class="col-md-12">
                                            Is a planning change required?
                                        </div>
                                        <br><br>
                                        <div class="col-md-12">
                                            If yes, identify who, where, when, and how the planning change was validated.
                                        </div>
                                        <br><br><hr>
                                        <div class="col-md-12">
                                            Are any documents to be modified relative to this response (i.e., Policies, SOPs, Forms, etc.)?
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <label>
                                                <input type="radio" name="is_planning_change" value="1" <?php if($row['is_planning_change']==1){echo 'checked';} ?>> Yes
                                            </label>
                                            <label>
                                                <input type="radio" name="is_planning_change" value="0" <?php if($row['is_planning_change']==0){echo 'checked';} ?>> No
                                            </label>
                                        </div>
                                        <br><br>
                                        <div class="col-md-12">
                                            <textarea class="form-control border-bottom" name="planning_specify" rows=""><?= $row['planning_specify']; ?></textarea>
                                        </div>
                                        <br><br><hr>
                                        <div class="col-md-12">
                                            <label>
                                                <input type="radio" name="is_document_modified" value="1" <?php if($row['is_document_modified']==1){echo 'checked';} ?>> Yes
                                            </label>
                                            <label>
                                                <input type="radio" name="is_document_modified" value="0" <?php if($row['is_document_modified']==0){echo 'checked';} ?>> No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab10_scar">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <center>
                                            <b>List the documents to be modified and the date of the modification: (documents will be sent electronically or via fax when they are approved and released)</b>
                                        </center>
                                    </div>
                                </div>
                                <div class="table table-scrollable">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td></td>
                                                <td>List of Documents</td>
                                                <td>Date</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody id="data_documents">
                                            <?php 
                                                $count1 = 1;
                                                $query_verification = mysqli_query($conn, "select * from tbl_complaint_documents where scar_record_pk = '$ID'");
                                                foreach($query_verification as $row_verification){?>
                                                    <tr id="row_data_documents_<?= $row_verification['list_id']; ?>">
                                                        <td><?= $count1++; ?></td>
                                                        <td><?= $row_verification['list_document']; ?></td>
                                                        <td><?= date('Y-m-d', strtotime($row_verification['list_date'])); ?></td>
                                                        <td width="50px">
                                                       </td>
                                                    </tr>
                                                <?php }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><input class="form-control border-none" name="list_document[]"></td>
                                                <td><input class="form-control border-none" name="list_date[]" type="date"></td>
                                                <td width="50px">
                                                   <button type="button" name="add_documents_row" id="add_documents_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button>
                                               </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Comments</label>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control border-bottom" rows="3" name="modified_comment"><?= $row['modified_comment']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab11_scar">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <p>
                                            <b>STEP 6 – FOLLOW-UP:</b>
                                            Determine and include any actions to ensure the corrective action continues to be effective in precluding recurrence of the non-conformance(s) – this may include
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="table table-scrollable">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td></td>
                                                <td>Follow-Up Actions</td>
                                                <td>Responsible Party</td>
                                                <td>Date Performed</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody id="data_followup">
                                            <?php 
                                                $count1 = 1;
                                                $query_verification = mysqli_query($conn, "select * from tbl_complaint_followup where scar_record_pk = '$ID'");
                                                foreach($query_verification as $row_verification){?>
                                                    <tr id="row_data_followup_<?= $row_verification['followup_id']; ?>">
                                                        <td><?= $count1++; ?></td>
                                                        <td><?= $row_verification['followup_action']; ?></td>
                                                        <td><?= $row_verification['followup_responsible']; ?></td>
                                                        <td><?= date('Y-m-d', strtotime($row_verification['followup_date_performed'])); ?></td>
                                                        <td width="50px">
                                                       </td>
                                                    </tr>
                                                <?php }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><input class="form-control border-none" name="followup_action[]"></td>
                                                <td><input class="form-control border-none" name="followup_responsible[]"></td>
                                                <td><input class="form-control border-none" name="followup_date_performed[]" type="date"></td>
                                                <td width="50px">
                                                   <button type="button" name="add_followup_row" id="add_followup_row" class="btn btn-success float-right"><i class="fa fa-plus"></i></button>
                                               </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Investigated by:</label>
                                        <select class="form-control mt-multiselect btn btn-default" type="text" name="scar_investigated_by">
                                            <option value="0">---Select---</option>
                                            <?php 
                                                
                                                $query_investigated = "SELECT *  FROM tbl_hr_employee where user_id = $user_id order by first_name ASC";
                                                $result_investigated = mysqli_query($conn, $query_investigated);
                                                                            
                                                while($row_investigated = mysqli_fetch_array($result_investigated))
                                                { ?> 
                                                <option value="<?php echo $row_investigated['ID']; ?>" <?php if($row_investigated['ID'] == $row['scar_investigated_by']){ echo 'selected';} ?>><?php echo $row_investigated['first_name']; ?> <?php echo $row_investigated['last_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Date:</label>
                                        <input type="date" class="form-control border-bottom" name="scar_investigated_date" value="<?php if(!empty($row['scar_investigated_date'] OR $row['scar_investigated_date'] != '')){ echo date('Y-m-d', strtotime($row['scar_investigated_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Verified by:</label>
                                        <select class="form-control mt-multiselect btn btn-default" type="text" name="scar_verified_by">
                                            <option value="0">---Select---</option>
                                            <?php 
                                                
                                                $query_verified_by = "SELECT *  FROM tbl_hr_employee where user_id = $user_id order by first_name ASC";
                                                $result_verified_by = mysqli_query($conn, $query_verified_by);
                                                                            
                                                while($row_verified_by = mysqli_fetch_array($result_verified_by))
                                                { ?> 
                                                <option value="<?php echo $row_verified_by['ID']; ?>" <?php if($row_verified_by['ID'] == $row['scar_verified_by']){ echo 'selected';} ?>><?php echo $row_verified_by['first_name']; ?> <?php echo $row_verified_by['last_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Date:</label>
                                        <input type="date" class="form-control border-bottom" name="scar_verified_date" value="<?php if(!empty($row['scar_verified_date'] OR $row['scar_verified_date'] != '')){ echo date('Y-m-d', strtotime($row['scar_verified_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Approved by:</label>
                                        <select class="form-control mt-multiselect btn btn-default border-bottom" type="text" name="scar_approved_by">
                                            <option value="0">---Select---</option>
                                            <?php 
                                                
                                                $query_approved_by = "SELECT *  FROM tbl_hr_employee where user_id = $user_id order by first_name ASC";
                                                $result_approved_by = mysqli_query($conn, $query_approved_by);
                                                                            
                                                while($row_approved_by = mysqli_fetch_array($result_approved_by))
                                                { ?> 
                                                <option value="<?php echo $row_approved_by['ID']; ?>" <?php if($row_approved_by['ID'] == $row['scar_approved_by']){ echo 'selected';} ?>><?php echo $row_approved_by['first_name']; ?> <?php echo $row_approved_by['last_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Date:</label>
                                        <input type="date" class="form-control border-bottom" name="scar_approved_date" value="<?php if(!empty($row['scar_approved_date'] OR $row['scar_approved_date'] != '')){ echo date('Y-m-d', strtotime($row['scar_approved_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d')));} ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php } 
    }
    if( isset($_POST['btnSave_scar']) ) {
      
        $cookie = $_COOKIE['ID'];
        $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $scar_number = mysqli_real_escape_string($conn,$_POST['scar_number']);
        $request_date = mysqli_real_escape_string($conn,$_POST['request_date']);
        $received_date = mysqli_real_escape_string($conn,$_POST['received_date']);
        $submitted_by = mysqli_real_escape_string($conn,$_POST['submitted_by']);
        $date_time  = mysqli_real_escape_string($conn,$_POST['date_time']);
        $submitted_to = mysqli_real_escape_string($conn,$_POST['submitted_to']);
        $customer_name = mysqli_real_escape_string($conn,$_POST['customer_name']);
        $scar_address = mysqli_real_escape_string($conn,$_POST['scar_address']);
        $scar_phone = mysqli_real_escape_string($conn,$_POST['scar_phone']);
        $scar_contact = mysqli_real_escape_string($conn,$_POST['scar_contact']);
        $scar_email = mysqli_real_escape_string($conn,$_POST['scar_email']);
        $location_issuing = mysqli_real_escape_string($conn,$_POST['location_issuing']);
        $supplier_product = mysqli_real_escape_string($conn,$_POST['supplier_product']);
        $product_code = mysqli_real_escape_string($conn,$_POST['product_code']);
        $product_lot = mysqli_real_escape_string($conn,$_POST['product_lot']);
        $scar_po_number = mysqli_real_escape_string($conn,$_POST['scar_po_number']);
        $product_quantity = mysqli_real_escape_string($conn,$_POST['product_quantity']);
        $desc_discrepancy = mysqli_real_escape_string($conn,$_POST['desc_discrepancy']);
        $findings = mysqli_real_escape_string($conn,$_POST['findings']);
        $as_evidenced_by = mysqli_real_escape_string($conn,$_POST['as_evidenced_by']);
         
        $file1 = $_FILES['image_reference']['name'];
        if(!empty($file1)){
            $filename1 = pathinfo($file1, PATHINFO_FILENAME);
            $extension = end(explode(".", $_FILES['image_reference']['name']));
            $rand = rand(10,1000000);
            $image_reference =  mysqli_real_escape_string($conn,$rand." - ".$filename1.".".$extension);
            $to_File_Documents = $rand." - ".$filename1.".".$extension;
            move_uploaded_file($_FILES['image_reference']['tmp_name'],'../customer_care_file/'.$to_File_Documents);
        }else{ $image_reference = mysqli_real_escape_string($conn,$_POST['image_reference2']); }
        
        $scar_qty = mysqli_real_escape_string($conn,$_POST['scar_qty']);
        $scar_shipping = mysqli_real_escape_string($conn,$_POST['scar_shipping']);
        $stock_in = mysqli_real_escape_string($conn,$_POST['stock_in']);
        $transit = mysqli_real_escape_string($conn,$_POST['transit']);
        $scar_other = mysqli_real_escape_string($conn,$_POST['scar_other']);
        $responsible_party1 = mysqli_real_escape_string($conn,$_POST['responsible_party1']);
        $conforming_qty = mysqli_real_escape_string($conn,$_POST['conforming_qty']);
        $responsible_party2 = mysqli_real_escape_string($conn,$_POST['responsible_party2']);
        $nc_tag = mysqli_real_escape_string($conn,$_POST['nc_tag']);
        $responsible_party3 = mysqli_real_escape_string($conn,$_POST['responsible_party3']);
        $nonconforming_step = mysqli_real_escape_string($conn,$_POST['nonconforming_step']);
        $responsible_party4 = mysqli_real_escape_string($conn,$_POST['responsible_party4']);
        $is_yes = mysqli_real_escape_string($conn,$_POST['is_yes']);
        $supplier_car_number = mysqli_real_escape_string($conn,$_POST['supplier_car_number']);
        $responsible_party5 = mysqli_real_escape_string($conn,$_POST['responsible_party5']);
        $record_number_is_yes = mysqli_real_escape_string($conn,$_POST['record_number_is_yes']);
        $if_yes_car_number = mysqli_real_escape_string($conn,$_POST['if_yes_car_number']);
        $responsible_party6 = mysqli_real_escape_string($conn,$_POST['responsible_party6']);
        $root_cause_finding1 = mysqli_real_escape_string($conn,$_POST['root_cause_finding1']);
        $root_cause_finding2 = mysqli_real_escape_string($conn,$_POST['root_cause_finding2']);
        $root_cause_finding3 = mysqli_real_escape_string($conn,$_POST['root_cause_finding3']);
        $step_4_comments = mysqli_real_escape_string($conn,$_POST['step_4_comments']);
        $list_products_comments = mysqli_real_escape_string($conn,$_POST['list_products_comments']);
        $is_planning_change = mysqli_real_escape_string($conn,$_POST['is_planning_change']);
        $planning_specify = mysqli_real_escape_string($conn,$_POST['planning_specify']);
        $is_document_modified = mysqli_real_escape_string($conn,$_POST['is_document_modified']);
        $modified_comment = mysqli_real_escape_string($conn,$_POST['modified_comment']);
        $scar_investigated_by = mysqli_real_escape_string($conn,$_POST['scar_investigated_by']);
        $scar_investigated_date = mysqli_real_escape_string($conn,$_POST['scar_investigated_date']);
        $scar_verified_by = mysqli_real_escape_string($conn,$_POST['scar_verified_by']);
        $scar_verified_date = mysqli_real_escape_string($conn,$_POST['scar_verified_date']);
        $scar_approved_by = mysqli_real_escape_string($conn,$_POST['scar_approved_by']);
        $scar_approved_date = mysqli_real_escape_string($conn,$_POST['scar_approved_date']);
        
        $finding1 = mysqli_real_escape_string($conn,$_POST['finding1']);
        $f1_why1 = mysqli_real_escape_string($conn,$_POST['f1_why1']);
        $f1_why2 = mysqli_real_escape_string($conn,$_POST['f1_why2']);
        $f1_why3 = mysqli_real_escape_string($conn,$_POST['f1_why3']);
        $f1_why4 = mysqli_real_escape_string($conn,$_POST['f1_why4']);
        $f1_why5 = mysqli_real_escape_string($conn,$_POST['f1_why5']);
        
        $finding2 = mysqli_real_escape_string($conn,$_POST['finding2']);
        $f2_why1 = mysqli_real_escape_string($conn,$_POST['f2_why1']);
        $f2_why2 = mysqli_real_escape_string($conn,$_POST['f2_why2']);
        $f2_why3 = mysqli_real_escape_string($conn,$_POST['f2_why3']);
        $f2_why4 = mysqli_real_escape_string($conn,$_POST['f2_why4']);
        $f2_why5 = mysqli_real_escape_string($conn,$_POST['f2_why5']);
        
        $finding3 = mysqli_real_escape_string($conn,$_POST['finding3']);
        $f3_why1 = mysqli_real_escape_string($conn,$_POST['f3_why1']);
        $f3_why2 = mysqli_real_escape_string($conn,$_POST['f3_why2']);
        $f3_why3 = mysqli_real_escape_string($conn,$_POST['f3_why3']);
        $f3_why4 = mysqli_real_escape_string($conn,$_POST['f3_why4']);
        $f3_why5 = mysqli_real_escape_string($conn,$_POST['f3_why5']);
       
        // for person notified
        $person_notified = implode(' | ', $_POST["person_notified"]);
        $person_notified = explode(' | ', $person_notified);
        foreach($person_notified as $con){$con;}
        $con;
        if(!empty($con))
        {
            $i = 0;
          foreach($person_notified as $val)
            {
                $date_notify = mysqli_real_escape_string($conn,$_POST["date_notify"][$i]);
                $responsible_party = mysqli_real_escape_string($conn,$_POST["responsible_party"][$i]);
                
                $sql_emp = "INSERT INTO tbl_complaint_person_notify(person_notified,date_notify,responsible_party,scar_record_pk,not_addedby,not_ownedby) 
                VALUES('".mysqli_real_escape_string($conn, $val)."','$date_notify','$responsible_party','$IDs','$cookie','$user_id')";
                if(mysqli_query($conn, $sql_emp)){
                    $last_id = mysqli_insert_id($conn);
                 }
                $i++;
            }
        }
        
        // for non-conformance
        $non_conformance = implode(' | ', $_POST["non_conformance"]);
        $non_conformance = explode(' | ', $non_conformance);
        foreach($non_conformance as $con){$con;}
        $con;
        if(!empty($con))
        {
            $i = 0;
          foreach($non_conformance as $val)
            {
                $expected_completion = mysqli_real_escape_string($conn,$_POST["expected_completion"][$i]);
                $responsible_party = mysqli_real_escape_string($conn,$_POST["responsible_party_non"][$i]);
                
                $sql_emp = "INSERT INTO tbl_complaint_non_conformance(non_conformance,expected_completion,responsible_party,scar_record_pk,non_addedby,non_onwedby) 
                VALUES('".mysqli_real_escape_string($conn, $val)."','$expected_completion','$responsible_party','$IDs','$cookie','$user_id')";
                if(mysqli_query($conn, $sql_emp)){
                    $last_id = mysqli_insert_id($conn);
                 }
                $i++;
            }
        }
        
        // for capa reference
        $capa_required = implode(' | ', $_POST["capa_required"]);
        $capa_required = explode(' | ', $capa_required);
        foreach($capa_required as $con){$con;}
        $con;
        if(!empty($con))
        {
            $i = 0;
          foreach($capa_required as $val)
            {
                $capa_responsible = mysqli_real_escape_string($conn,$_POST["capa_responsible"][$i]);
                $capa_expected_completion = mysqli_real_escape_string($conn,$_POST["capa_expected_completion"][$i]);
                
                $sql_emp = "INSERT INTO tbl_complaint_action_reference(capa_required,capa_responsible,capa_expected_completion,scar_record_pk,capa_addedby,capa_ownedby) 
                VALUES('".mysqli_real_escape_string($conn, $val)."','$capa_responsible','$capa_expected_completion','$IDs','$cookie','$user_id')";
                if(mysqli_query($conn, $sql_emp)){
                    $last_id = mysqli_insert_id($conn);
                 }
                $i++;
            }
        }
        
        // for affected
        $list_other_products = implode(' | ', $_POST["list_other_products"]);
        $list_other_products = explode(' | ', $list_other_products);
        foreach($list_other_products as $con){$con;}
        $con;
        if(!empty($con))
        {
            $i = 0;
          foreach($list_other_products as $val)
            {
                $supplier_vendor = mysqli_real_escape_string($conn,$_POST["supplier_vendor"][$i]);
                $plant_wide = mysqli_real_escape_string($conn,$_POST["plant_wide"][$i]);
                $affected_reponsible = mysqli_real_escape_string($conn,$_POST["affected_reponsible"][$i]);
                $affected_completion = mysqli_real_escape_string($conn,$_POST["affected_completion"][$i]);
                
                $sql_emp = "INSERT INTO tbl_complaint_affected(list_other_products,supplier_vendor,plant_wide,affected_reponsible,affected_completion,scar_record_pk,affected_addedby,affected_ownedby) 
                VALUES('".mysqli_real_escape_string($conn, $val)."','$supplier_vendor','$plant_wide','$affected_reponsible','$affected_completion','$IDs','$cookie','$user_id')";
                if(mysqli_query($conn, $sql_emp)){
                    $last_id = mysqli_insert_id($conn);
                 }
                $i++;
            }
        }
        
        // for verification
        $verification_plan = implode(' | ', $_POST["verification_plan"]);
        $verification_plan = explode(' | ', $verification_plan);
        foreach($verification_plan as $con){$con;}
        $con;
        if(!empty($con))
        {
            $i = 0;
          foreach($verification_plan as $val)
            {
                $verification_party = mysqli_real_escape_string($conn,$_POST["verification_party"][$i]);
                $verification_date = mysqli_real_escape_string($conn,$_POST["verification_date"][$i]);
                
                $sql_emp = "INSERT INTO tbl_complaint_verification(verification_plan,verification_party,verification_date,scar_record_pk,verification_addedby,verification_ownedby) 
                VALUES('".mysqli_real_escape_string($conn, $val)."','$verification_party','$verification_date','$IDs','$cookie','$user_id')";
                if(mysqli_query($conn, $sql_emp)){
                    $last_id = mysqli_insert_id($conn);
                 }
                $i++;
            }
        }
        
        // for documents
        $list_document = implode(' | ', $_POST["list_document"]);
        $list_document = explode(' | ', $list_document);
        foreach($list_document as $con){$con;}
        $con;
        if(!empty($con))
        {
            $i = 0;
          foreach($list_document as $val)
            {
                $list_date = mysqli_real_escape_string($conn,$_POST["list_date"][$i]);
                
                $sql_emp = "INSERT INTO tbl_complaint_documents(list_document,list_date,scar_record_pk,list_addedby,list_ownedby) 
                VALUES('".mysqli_real_escape_string($conn, $val)."','$list_date','$IDs','$cookie','$user_id')";
                if(mysqli_query($conn, $sql_emp)){
                    $last_id = mysqli_insert_id($conn);
                 }
                $i++;
            }
        }
        
        // for followup
        $followup_action = implode(' | ', $_POST["followup_action"]);
        $followup_action = explode(' | ', $followup_action);
        foreach($followup_action as $con){$con;}
        $con;
        if(!empty($con))
        {
            $i = 0;
          foreach($followup_action as $val)
            {
                $followup_responsible = mysqli_real_escape_string($conn,$_POST["followup_responsible"][$i]);
                $followup_date_performed = mysqli_real_escape_string($conn,$_POST["followup_date_performed"][$i]);
                
                $sql_emp = "INSERT INTO tbl_complaint_followup(followup_action,followup_responsible,followup_date_performed,scar_record_pk,followup_addedby,followup_ownedby) 
                VALUES('".mysqli_real_escape_string($conn, $val)."','$followup_responsible','$followup_date_performed','$IDs','$cookie','$user_id')";
                if(mysqli_query($conn, $sql_emp)){
                    $last_id = mysqli_insert_id($conn);
                 }
                $i++;
            }
        }
        
    	$sql = "UPDATE tbl_complaint_scar set scar_number='$scar_number',request_date='$request_date',received_date='$received_date',submitted_by='$submitted_by',date_time='$date_time',submitted_to='$submitted_to',customer_name='$customer_name',scar_address='$scar_address',scar_phone='$scar_phone',scar_contact='$scar_contact',scar_email='$scar_email',location_issuing='$location_issuing',supplier_product='$supplier_product',product_code='$product_code',product_lot='$product_lot',scar_po_number='$scar_po_number',product_quantity='$product_quantity',desc_discrepancy='$desc_discrepancy',findings='$findings',as_evidenced_by='$as_evidenced_by',image_reference='$image_reference',scar_qty='$scar_qty',scar_shipping='$scar_shipping',stock_in='$stock_in',transit='$transit',scar_other='$scar_other',responsible_party1='$responsible_party1',conforming_qty='$conforming_qty',responsible_party2='$responsible_party2',nc_tag='$nc_tag',responsible_party3='$responsible_party3',nonconforming_step='$nonconforming_step',responsible_party4='$responsible_party4',is_yes='$is_yes',supplier_car_number='$supplier_car_number',responsible_party5='$responsible_party5',record_number_is_yes='$record_number_is_yes',if_yes_car_number='$if_yes_car_number',responsible_party6='$responsible_party6',root_cause_finding1='$root_cause_finding1',root_cause_finding2='$root_cause_finding2',root_cause_finding3='$root_cause_finding3',step_4_comments='$step_4_comments',list_products_comments='$list_products_comments',is_planning_change='$is_planning_change',planning_specify='$planning_specify',is_document_modified='$is_document_modified',modified_comment='$modified_comment',finding1='$finding1',f1_why1='$f1_why1',f1_why2='$f1_why2',f1_why3='$f1_why3',f1_why4='$f1_why4',f1_why5='$f1_why5',finding2='$finding2',f2_why1='$f2_why1',f2_why2='$f2_why2',f2_why3='$f2_why3',f2_why4='$f2_why4',f2_why5='$f2_why5',finding3='$finding3',f3_why1='$f3_why1',f3_why2='$f3_why2',f3_why3='$f3_why3',f3_why4='$f3_why4',f3_why5='$f3_why5',scar_investigated_by='$scar_investigated_by',scar_investigated_date='$scar_investigated_date',scar_verified_by='$scar_verified_by',scar_verified_date='$scar_verified_date',scar_approved_by='$scar_approved_by',scar_approved_date='$scar_approved_date',scar_addedby='$cookie' where scar_record_id = $IDs";
        if(mysqli_query($conn, $sql)){
            echo $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        }
    }
    
    
	if( isset($_GET['complaint']) ) {
		$ID = $_GET['complaint'];
		$c = $_GET['c'];

        mysqli_query( $conn,"UPDATE tbl_complaint_records set capam = $c WHERE care_id = $ID" );
        // echo $ID;
    }
?>