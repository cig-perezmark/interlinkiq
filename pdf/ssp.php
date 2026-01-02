<?php

	require_once __DIR__ . '/vendor/autoload.php';
    include_once ('../database_iiq.php');

	$mpdf = new \Mpdf\Mpdf();
    $base_url = "https://interlinkiq.com/";
	$html = '';
    
	$id = 0;
	$facility_switch_user_id = 0;
    // $facility_switch_user_id = $_GET['f'];
    // $current_client = 0;
    // if (!empty($_COOKIE['client'])) { $current_client = $_COOKIE['client']; }

    
    $selectAPI = mysqli_query( $conn,"SELECT ID FROM tbl_api_keys" );
    if ( mysqli_num_rows($selectAPI) > 0 ) {
        $rowAPI = mysqli_fetch_array($selectAPI);
        $api_key = $rowAPI["ID"]; // 32 chars for AES-256
    }
    $encoded = urlencode($_GET['i']);
    $encoded2 = urlencode($_GET['f']);
    if (!empty($encoded) AND !empty($encoded2)) {
        $decoded = base64_decode(urldecode($encoded));
        $decoded2 = base64_decode(urldecode($encoded2));

        // Extract IV (first 16 bytes) and ciphertext
        $api_iv = substr($decoded, 0, 16);
        $api_ciphertext = substr($decoded, 16);
        $api_ciphertext2 = substr($decoded2, 16);

        $id = openssl_decrypt($api_ciphertext, 'aes-256-cbc', $api_key, OPENSSL_RAW_DATA, $api_iv);
        $facility_switch_user_id = openssl_decrypt($api_ciphertext2, 'aes-256-cbc', $api_key, OPENSSL_RAW_DATA, $api_iv);
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
	function userFullname($ID) {
		global $conn;

		$selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $ID" );
		$rowUser = mysqli_fetch_array($selectUser);
		$user_fullname = $rowUser['first_name'] .' '. $rowUser['last_name'];

		return $user_fullname;
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
	
	if (ctype_digit($id) AND ctype_digit($facility_switch_user_id)) {
	    $id = intval($id);
    	$selectData = mysqli_query( $conn,"
    	    SELECT
            e.businessname AS e_name,
            e.businessemailAddress AS e_email,
            CONCAT(e.Bldg, ' ', e.city, ' ', e.States, ' ', e.ZipCode, ' ', e.country) AS e_address,
            e.businesstelephone AS e_phone,
            e.BusinessPurpose AS e_general_description,
            e.federal AS e_federal,
            e.dod AS e_dod,
            s.topology_type AS s_topology_type,
            s.topology_file AS s_topology_file,
            s.hardware_type AS s_hardware_type,
            s.hardware_file AS s_hardware_file,
            s.software_type AS s_software_type,
            s.software_file AS s_software_file,
            s.maintenance_type AS s_maintenance_type,
            s.maintenance_explaination AS s_maintenance_explaination,
            SUM(emp.admin) AS emp_admin,
            SUM(emp.status) AS emp_status
            
            FROM tblEnterpiseDetails AS e
            
            LEFT JOIN (
            	SELECT
                *
                FROM tblEnterpiseDetails_System_Environment
            ) AS s
            ON s.user_id = e.users_entities
            
            LEFT JOIN (
            	SELECT
                user_id,
                status,
                admin
                FROM tbl_hr_employee
                WHERE status = 1
            ) AS emp
            ON emp.user_id = e.users_entities
            
            WHERE e.users_entities = $id
    	" );
    	if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
            $e_name = htmlentities($row['e_name'] ?? '');
            $e_email = htmlentities($row['e_email'] ?? '');
            $e_address = htmlentities($row['e_address'] ?? '');
            $e_phone = htmlentities($row['e_phone'] ?? '');
            $e_general_description = htmlentities($row['e_general_description'] ?? '');
        
            $e_federal = $row['e_federal'];
            $e_dod = $row['e_dod'];
            
            $topology_type = $row['s_topology_type'];
            $topology_file = $row['s_topology_file'];
            $s_topology_file = $row['s_topology_file'];
            $t_type = 'iframe';
            $t_target = '';
            $t_datafancybox = 'data-fancybox';
            if (!empty($topology_file)) {
                if ($topology_type == 1) {
                    $fileExtension = fileExtension($topology_file);
                    $src = $fileExtension['src'];
                    $embed = $fileExtension['embed'];
                    $t_type = $fileExtension['type'];
                    $url = $base_url.'uploads/enterprise/';
        
                    $topology_file = $src.$url.rawurlencode($topology_file).$embed;
                } else if ($topology_type == 3) {
                    $topology_file = preg_replace('#[^/]*$#', '', $topology_file).'preview';
                } else if ($topology_type == 4) {
                    $t_target = '_blank';
                    $t_datafancybox = '';
                }
            }
            
            $hardware_type = $row['s_hardware_type'];
            $hardware_file = $row['s_hardware_file'];
            $h_type = 'iframe';
            $h_target = '';
            $h_datafancybox = 'data-fancybox';
            if (!empty($hardware_file)) {
                if ($hardware_type == 1) {
                    $fileExtension = fileExtension($hardware_file);
                    $src = $fileExtension['src'];
                    $embed = $fileExtension['embed'];
                    $h_type = $fileExtension['type'];
                    $url = $base_url.'uploads/enterprise/';
        
                    $hardware_file = $src.$url.rawurlencode($hardware_file).$embed;
                } else if ($hardware_type == 3) {
                    $hardware_file = preg_replace('#[^/]*$#', '', $hardware_file).'preview';
                } else if ($hardware_type == 4) {
                    $h_target = '_blank';
                    $h_datafancybox = '';
                }
            }
            
            $software_type = $row['s_software_type'];
            $software_file = $row['s_software_file'];
            $s_type = 'iframe';
            $s_target = '';
            $s_datafancybox = 'data-fancybox';
            if (!empty($software_file)) {
                if ($software_type == 1) {
                    $fileExtension = fileExtension($software_file);
                    $src = $fileExtension['src'];
                    $embed = $fileExtension['embed'];
                    $s_type = $fileExtension['type'];
                    $url = $base_url.'uploads/enterprise/';
        
                    $software_file = $src.$url.rawurlencode($software_file).$embed;
                } else if ($software_type == 3) {
                    $software_file = preg_replace('#[^/]*$#', '', $software_file).'preview';
                } else if ($software_type == 4) {
                    $s_target = '_blank';
                    $s_datafancybox = '';
                }
            }
            
            $s_maintenance_type = $row['s_maintenance_type'];
            $s_maintenance_explaination = $row['s_maintenance_explaination'];
            $emp_admin = $row['emp_admin'];
            $emp_status = $row['emp_status'];
    
        	$html = '<html>
            	<head>
            		<title>System Security Plan</title>
            		<style>
            			table {
            				width: 100%;
            			}
            			table td {
            				border: 1px solid;
            			}
            			.text-bold {
            				font-width: 700;
            			}
            		</style>
            	</head>
            	<body>
            		<div class="list-order">
            			<div>
            				<p><strong>1. <span style="text-decoration: underline;">SYSTEM IDENTIFICATION</span></strong></p>
            				<div>
            					<div>
            						<p><strong>1.1. System Name/Title:</strong> '.$e_name.'</p>
        		    				<div>
        		    					<div>
        		    						<p><strong>1.1.1. System Categorization:</strong> Moderate Impact for Confidentiality</p>
        		    					</div>
        		    					<div>
        		    						<p><strong>1.1.2. System Unique Identifier:</strong> '.$e_email.'</p>
        		    					</div>
        		    				</div>
            					</div>
            					<div>
            						<p><strong>1.2. <span class="text-bold">Responsible Organization:</span></strong></p>
            						<table cellpadding="7" cellspacing="0" border="0">
        				    			<tr>
        				    				<td style="width: 100px;">Name:</td>
        				    				<td>'.$e_name.'</td>
        				    			</tr>
        				    			<tr>
        				    				<td style="width: 100px;">Address:</td>
        				    				<td>'.$e_address.'</td>
        				    			</tr>
        				    			<tr>
        				    				<td style="width: 100px;">Phone:</td>
        				    				<td>'.$e_phone.'</td>
        				    			</tr>
        				    		</table>
        
        				    		<div>
        		    					<div>
        		    						<p><strong>1.2.1. Information Owner</strong> (Government point of contact responsible for providing and/or receiving CUI):</p>';
        
                                            $selectDataIO = mysqli_query( $conn,"SELECT CONCAT(contactpersonname, ' ', contactpersonlastname) AS name, titles AS title, contactpersonOfficeAddress AS official_address, contactpersonphone AS phone, contactpersonemailAddress AS email FROM tblEnterpiseDetails_Contact WHERE user_cookies = $id AND contactpersonType = 1" );
                                    		if ( mysqli_num_rows($selectDataIO) > 0 ) {
                                                while($rowIO = mysqli_fetch_array($selectDataIO)) {
                                                    $html .= '<table cellpadding="7" cellspacing="0" border="0">
                						    			<tr>
                						    				<td style="width: 100px;">Name:</td>
                						    				<td>'.$rowIO['name'].'</td>
                						    			</tr>
                						    			<tr>
                						    				<td style="width: 100px;">Title:</td>
                						    				<td>'.$rowIO['title'].'</td>
                						    			</tr>
                						    			<tr>
                						    				<td style="width: 100px;">Office Address:</td>
                						    				<td>'.$rowIO['official_address'].'</td>
                						    			</tr>
                						    			<tr>
                						    				<td style="width: 100px;">Work Phone:</td>
                						    				<td>'.$rowIO['phone'].'</td>
                						    			</tr>
                						    			<tr>
                						    				<td style="width: 100px;">e-Mail Address:</td>
                						    				<td>'.$rowIO['email'].'</td>
                						    			</tr>
                						    		</table>';
                                                }
                                            } else {
                                                $html .= '<table cellpadding="7" cellspacing="0" border="0">
            						    			<tr>
            						    				<td style="width: 100px;">Name:</td>
            						    				<td></td>
            						    			</tr>
            						    			<tr>
            						    				<td style="width: 100px;">Title:</td>
            						    				<td></td>
            						    			</tr>
            						    			<tr>
            						    				<td style="width: 100px;">Office Address:</td>
            						    				<td></td>
            						    			</tr>
            						    			<tr>
            						    				<td style="width: 100px;">Work Phone:</td>
            						    				<td></td>
            						    			</tr>
            						    			<tr>
            						    				<td style="width: 100px;">e-Mail Address:</td>
            						    				<td></td>
            						    			</tr>
            						    		</table>';
                                            }
        
        						    		$html .= '<div>
        				    					<div>
        				    						<p><strong>1.2.1.1. System Owner</strong> (assignment of security responsibility):</p>';
        				    						
                                                    $selectDataSO = mysqli_query( $conn,"SELECT CONCAT(contactpersonname, ' ', contactpersonlastname) AS name, titles AS title, contactpersonOfficeAddress AS official_address, contactpersonphone AS phone, contactpersonemailAddress AS email FROM tblEnterpiseDetails_Contact WHERE user_cookies = $id AND contactpersonType = 2" );
                                            		if ( mysqli_num_rows($selectDataSO) > 0 ) {
                                                        while($rowSO = mysqli_fetch_array($selectDataSO)) {
                                                            $html .= '<table cellpadding="7" cellspacing="0" border="0">
                        						    			<tr>
                        						    				<td style="width: 100px;">Name:</td>
                        						    				<td>'.$rowSO['name'].'</td>
                        						    			</tr>
                        						    			<tr>
                        						    				<td style="width: 100px;">Title:</td>
                        						    				<td>'.$rowSO['title'].'</td>
                        						    			</tr>
                        						    			<tr>
                        						    				<td style="width: 100px;">Office Address:</td>
                        						    				<td>'.$rowSO['official_address'].'</td>
                        						    			</tr>
                        						    			<tr>
                        						    				<td style="width: 100px;">Work Phone:</td>
                        						    				<td>'.$rowSO['phone'].'</td>
                        						    			</tr>
                        						    			<tr>
                        						    				<td style="width: 100px;">e-Mail Address:</td>
                        						    				<td>'.$rowSO['email'].'</td>
                        						    			</tr>
                        						    		</table>';
                                                        }
                                                    } else {
                                                        $html .= '<table cellpadding="7" cellspacing="0" border="0">
                    						    			<tr>
                    						    				<td style="width: 100px;">Name:</td>
                    						    				<td></td>
                    						    			</tr>
                    						    			<tr>
                    						    				<td style="width: 100px;">Title:</td>
                    						    				<td></td>
                    						    			</tr>
                    						    			<tr>
                    						    				<td style="width: 100px;">Office Address:</td>
                    						    				<td></td>
                    						    			</tr>
                    						    			<tr>
                    						    				<td style="width: 100px;">Work Phone:</td>
                    						    				<td></td>
                    						    			</tr>
                    						    			<tr>
                    						    				<td style="width: 100px;">e-Mail Address:</td>
                    						    				<td></td>
                    						    			</tr>
                    						    		</table>';
                                                    }
        
        				    					$html .= '</div>
        				    					<div>
        				    						<p><strong>1.2.1.2. System Security Officer:</strong></p>';
        
                                                    $selectDataSSP = mysqli_query( $conn,"SELECT CONCAT(contactpersonname, ' ', contactpersonlastname) AS name, titles AS title, contactpersonOfficeAddress AS official_address, contactpersonphone AS phone, contactpersonemailAddress AS email FROM tblEnterpiseDetails_Contact WHERE user_cookies = $id AND contactpersonType = 3" );
                                            		if ( mysqli_num_rows($selectDataSSP) > 0 ) {
                                                        while($rowSSP = mysqli_fetch_array($selectDataSSP)) {
                                                            $html .= '<table cellpadding="7" cellspacing="0" border="0">
                        						    			<tr>
                        						    				<td style="width: 100px;">Name:</td>
                        						    				<td>'.$rowSSP['name'].'</td>
                        						    			</tr>
                        						    			<tr>
                        						    				<td style="width: 100px;">Title:</td>
                        						    				<td>'.$rowSSP['title'].'</td>
                        						    			</tr>
                        						    			<tr>
                        						    				<td style="width: 100px;">Office Address:</td>
                        						    				<td>'.$rowSSP['official_address'].'</td>
                        						    			</tr>
                        						    			<tr>
                        						    				<td style="width: 100px;">Work Phone:</td>
                        						    				<td>'.$rowSSP['phone'].'</td>
                        						    			</tr>
                        						    			<tr>
                        						    				<td style="width: 100px;">e-Mail Address:</td>
                        						    				<td>'.$rowSSP['email'].'</td>
                        						    			</tr>
                        						    		</table>';
                                                        }
                                                    } else {
                                                        $html .= '<table cellpadding="7" cellspacing="0" border="0">
                    						    			<tr>
                    						    				<td style="width: 100px;">Name:</td>
                    						    				<td></td>
                    						    			</tr>
                    						    			<tr>
                    						    				<td style="width: 100px;">Title:</td>
                    						    				<td></td>
                    						    			</tr>
                    						    			<tr>
                    						    				<td style="width: 100px;">Office Address:</td>
                    						    				<td></td>
                    						    			</tr>
                    						    			<tr>
                    						    				<td style="width: 100px;">Work Phone:</td>
                    						    				<td></td>
                    						    			</tr>
                    						    			<tr>
                    						    				<td style="width: 100px;">e-Mail Address:</td>
                    						    				<td></td>
                    						    			</tr>
                    						    		</table>';
                                                    }
                                                    
        				    					$html .= '</div>
        				    				</div>
        		    					</div>
        		    				</div>
            					</div>
            					<div>
            						<p><strong>1.3. General Description/Purpose of System:</strong> What is the function/purpose of the system?</p>';
            						
            						if (!empty($e_general_description)) {
            						    $html .= '<p>'.nl2br($e_general_description).'</p>';
            						}
        
            						$html .= '<div>
        		    					<div>
        		    						<p><strong>1.3.1. Number of end users and privileged users:<strong></p>
        
        		    						<p class="text-bold">Roles of Users and Number of Each Type:</p>
        		    						<table cellpadding="7" cellspacing="0" border="0">
        						    			<tr>
        						    				<td style="width: 50%; background: #cbcbcb; font-weight: 700;">Number of Users</td>
        						    				<td style="width: 50%; background: #cbcbcb; font-weight: 700;">Number of Administrators/Privileged Users</td>
        						    			</tr>
        						    			<tr>
        						    				<td>'.$emp_status.'</td>
        						    				<td>'.$emp_admin.'</td>
        						    			</tr>
        						    		</table>
        		    					</div>
        		    				</div>
            					</div>
            					<div>
            						<p><strong>1.4. General Description of Information:</strong> CUI information types processed, stored, or transmitted by the system are determined and documented.</p>
            						<table cellpadding="7" cellspacing="0" border="0">
                                        <tr style="background: #29393b; font-weight: 700;">
        				    				<td style="width: 20%; background: #cbcbcb; font-weight: 700;">Source</td>
        				    				<td style="width: 30%; background: #cbcbcb; font-weight: 700;">Organizational Index</td>
        				    				<td style="width: 50%; background: #cbcbcb; font-weight: 700;">Categories</td>
                                        </tr>';
                                        
                                        if (!empty($e_federal)) {
                                            $selectFederal = mysqli_query( $conn,"
                                                SELECT 
                                                f.ID AS f_ID,
                                                f.name AS f_name
                                                FROM tblEnterpiseDetails_Federal_sub AS fs
                                                
                                                LEFT JOIN (
                                                	SELECT
                                                    *
                                                    FROM tblEnterpiseDetails_Federal
                                                    WHERE deleted = 0
                                                ) AS f
                                                ON f.ID = fs.parent_id
                                                
                                                WHERE fs.deleted = 0
                                                AND fs.ID IN ($e_federal)
                                                
                                                GROUP BY f.ID
                                                
                                                ORDER BY f.name
                                            " );
                                            if ( mysqli_num_rows($selectFederal) > 0 ) {
                                                $rspan_f = 0;
                                                while($rowFederal = mysqli_fetch_array($selectFederal)) {
                                                    $f_ID = $rowFederal["f_ID"];
                                                    $f_name = $rowFederal["f_name"];
                                                    
                                                    $html .= '<tr>';
                                                    
                                                        if ($rspan_f == 0) { $html .= '<td rowspan="'.mysqli_num_rows($selectFederal).'">Federal</td>'; $rspan_f = 1; }
                                                        
                                                        $html .= '<td>'.$f_name.'</td>
                                                        <td>';
                                                        
                                                            $selectFederalSub = mysqli_query( $conn,"
                                                                SELECT
                                                                fs.ID AS fs_ID,
                                                                fs.name AS fs_name
                                                                FROM tblEnterpiseDetails_Federal_sub AS fs
                                                                
                                                                WHERE fs.deleted = 0
                                                                AND fs.ID IN ($e_federal)
                                                                AND fs.parent_id = $f_ID
                                                                
                                                                ORDER BY fs.name
                                                            " );
                                                            if ( mysqli_num_rows($selectFederalSub) > 0 ) {
                                                                $html .= '<ul>';
                                                                while($rowFederalSub = mysqli_fetch_array($selectFederalSub)) {
                                                                    $fs_name = $rowFederalSub["fs_name"];
                                                                    $html .= '<li>'.$fs_name.'</li>';
                                                                }
                                                                $html .= '</ul>';
                                                            }
                                                            
                                                        $html .= '</td>
                                                    </tr>';
                                                }
                                            }
                                        }
                                        
                                        if (!empty($e_dod)) {
                                            $selectDOD = mysqli_query( $conn,"
                                                SELECT 
                                                d.ID AS d_ID,
                                                d.name AS d_name
                                                FROM tblEnterpiseDetails_DOD_sub AS ds
                                                
                                                LEFT JOIN (
                                                	SELECT
                                                    *
                                                    FROM tblEnterpiseDetails_DOD
                                                    WHERE deleted = 0
                                                ) AS d
                                                ON d.ID = ds.parent_id
                                                
                                                WHERE ds.deleted = 0
                                                AND ds.ID IN ($e_dod)
                                                
                                                GROUP BY d.ID
                                                
                                                ORDER BY d.name
                                            " );
                                            if ( mysqli_num_rows($selectDOD) > 0 ) {
                                                $rspan_d = 0;
                                                while($rowDOD = mysqli_fetch_array($selectDOD)) {
                                                    $d_ID = $rowDOD["d_ID"];
                                                    $d_name = $rowDOD["d_name"];
                                                    
                                                    $html .= '<tr>';
                                                    
                                                        if ($rspan_d == 0) { $html .= '<td rowspan="'.mysqli_num_rows($selectDOD).'">Department of Defense</td>'; $rspan_d = 1; }
                                                        
                                                        $html .= '<td>'.$d_name.'</td>
                                                        <td>';
                                                        
                                                            $selectDODSub = mysqli_query( $conn,"
                                                                SELECT
                                                                ds.ID AS ds_ID,
                                                                ds.name AS ds_name
                                                                FROM tblEnterpiseDetails_DOD_sub AS ds
                                                                
                                                                WHERE ds.deleted = 0
                                                                AND ds.ID IN ($e_dod)
                                                                AND ds.parent_id = $d_ID
                                                                
                                                                ORDER BY ds.name
                                                            " );
                                                            if ( mysqli_num_rows($selectDODSub) > 0 ) {
                                                                $html .= '<ul>';
                                                                while($rowDODSub = mysqli_fetch_array($selectDODSub)) {
                                                                    $ds_name = $rowDODSub["ds_name"];
                                                                    $html .= '<li>'.$ds_name.'</li>';
                                                                }
                                                                $html .= '</ul>';
                                                            }
                                                            
                                                        $html .= '</td>
                                                    </tr>';
                                                }
                                            }
                                        }
                                        
                                    $html .= '</table>
            					</div>
            				</div>
            			</div>
            			<div>
            				<p><strong>2. <span style="text-decoration: underline;">SYSTEM ENVIRONMENT</span></strong></p>
        
            				<p>Include a detailed topology narrative and graphic that clearly depicts the system boundaries, system interconnections, and key devices. (Note: this does not require depicting every workstation or desktop, but include an instance for each operating system in use, an instance for portable components (if applicable), all virtual and physical servers (e.g., file, print, web, database, application), as well as any networked workstations (e.g., Unix, Windows, Mac, Linux), firewalls, routers, switches, copiers, printers, lab equipment, handhelds). If components of other systems that interconnect/interface with this system need to be shown on the diagram, denote the system boundaries by referencing the security plans or names and owners of the other system(s) in the diagram.</p>';
        
        					if (!empty($topology_file)) {
        					    $html .= '<img src="../uploads/enterprise/'.$s_topology_file.'" style="width: 100%; max-width: 300px;"><br>
        					    <a href="'.$topology_file.'" target="_blank" class="btn btn-link" style="display:none;">View</a>';
        					}
            				
            				$html .= '<div>
            					<div>
            						<strong>2.1.</strong> <span>Include or reference a complete and accurate listing of all hardware (a reference to the organizational component inventory database is acceptable) and software (system software and application software) components, including make/OEM, model, version, service packs, and person or role responsible for the component.</span>';
            						
            						if (!empty($hardware_file)) {
            						    $s_hardware_file = $row['s_hardware_file'];
            						    $pos_hardware = strpos($s_hardware_file, "-");
                                        $s_hardware_file = trim(substr($s_hardware_file, $pos_hardware + 1));
            						    
            						    $html .= '<a href="'.$hardware_file.'" target="_blank" class="btn btn-link" style="display:none;">View</a>';
            						    $html .= '<p><em>Refer to the Hardware component list/inventory/'.$s_hardware_file.'</em></p>';
        
            						}
            						
            					$html .= '</div>
            					<div>
            						<strong>2.2.</strong> <span>List all software components installed on the system.</span>';
            						
            						if (!empty($software_file)) {
            						    $s_software_file = $row['s_software_file'];
            						    $pos_software = strpos($s_software_file, "-");
                                        $s_software_file = trim(substr($s_software_file, $pos_software + 1));
                                        
            						    $html .= '<a href="'.$software_file.'" target="_blank" class="btn btn-link" style="display:none;">View</a>';
            						    $html .= '<p><em>Refer to the Software component list/inventory/'.$s_software_file.'</em></p>';
            						}
            						
            					$html .= '</div>
            					<div>
            						<strong>2.3.</strong> <span>Hardware and Software Maintenance and Ownership - Is all hardware and software maintained and owned by the organization?</span> ';
            						
            						if ($s_maintenance_type == 1) {
            						    $html .= 'Yes';
            						} else {
            						    $html .= 'No - '.$s_maintenance_explaination;
            						}
            						
            					$html .= '</div>
            				</div>
            			</div>
            			<div>
            				<p><strong>3. <span style="text-decoration: underline;">REQUIREMENTS</span></strong></p>
        
            				<p class="text-bold">(Note: The source of the requirements is NIST Special Publication 800-171, dated December 2016)</p>
        
            				<p>Provide a thorough description of how all of the security requirements are being implemented or planned to be implemented. The description for each security requirement contains: 1) the security requirement number and description; 2) how the security requirement is being implemented or planned to be implemented; and 3) any scoping guidance that has been applied (e.g., compensating mitigations(s) in place due to implementation constraints in lieu of the stated requirement). If the requirement is not applicable to the system, provide rationale.</p>';
            				
            					
                        	$selectLibrary = mysqli_query( $conn,"
                                WITH RECURSIVE numbers AS (
                                    SELECT 1 AS n
                                    UNION ALL
                                    SELECT n + 1 FROM numbers WHERE n < 10
                                )
                                SELECT
                                l_name_id,
                                l_idx,
                                l_ID,
                                l_child_id,
                                l_ordering,
                                CONCAT(COALESCE(t.name, ''), ' ', COALESCE(c.name, ''), ' ', COALESCE(s.name, ''), ' ', COALESCE(m.name, '')) AS l_name
                                FROM (
                                    SELECT 
                                        SUBSTRING_INDEX(SUBSTRING_INDEX(l.name, ',', numbers.n), ',', -1) AS l_name_id,
                                        numbers.n AS l_idx,
                                        l.ID AS l_ID,
                                        l.child_id AS l_child_id,
                                        l.ordering AS l_ordering
                                    FROM tbl_library AS l
                                    JOIN numbers ON CHAR_LENGTH(l.name)
                                          -CHAR_LENGTH(REPLACE(l.name, ',', '')) >= numbers.n - 1
                                
                                    WHERE l.deleted = 0
                                    AND l.parent_id = 0
                                    AND l.user_id = $id
                                    AND l.facility_switch = $facility_switch_user_id
                                ) r
                                
                                LEFT JOIN tbl_library_type AS t ON r.l_idx = 1 AND t.ID = r.l_name_id
                                LEFT JOIN tbl_library_category AS c ON r.l_idx = 2 AND c.ID = r.l_name_id
                                LEFT JOIN tbl_library_scope AS s ON r.l_idx = 3 AND s.ID = r.l_name_id
                                LEFT JOIN tbl_library_module AS m ON r.l_idx = 4 AND m.ID = r.l_name_id
                                
                                WHERE r.l_name_id IS NOT NULL
                                AND r.l_name_id != ''
                                
                                ORDER BY r.l_ordering
                        	" );
                        	if ( mysqli_num_rows($selectLibrary) > 0 ) {
                        	    $x = 1;
                        	    $html .= '<div>';
                                while($rowLib = mysqli_fetch_array($selectLibrary)) {
                                    $l_ID = $rowLib['l_ID'];
                                    $l_name = htmlentities($rowLib['l_name'] ?? '');
                                    
                        	        $html .= '<div><p><strong>3.'.$x.'. '.$l_name.'</strong></p>';
                        	        
                            	        $selectLibraryChild = mysqli_query( $conn,"SELECT ID, child_id, applicable, na_reason, name, description FROM tbl_library WHERE deleted = 0 AND parent_id = $l_ID ORDER BY FIELD(type,1,2,3,5,4) ASC, ordering ASC, ID ASC");
                            	        if ( mysqli_num_rows($selectLibraryChild) > 0 ) {
                            	            $xx = 1;
                            	            $html .= '<div>';
                            	            while($rowLibChild = mysqli_fetch_array($selectLibraryChild)) {
                            	                $lc_ID = $rowLibChild['ID'];
                            	                $lc_child_id = $rowLibChild['child_id'];
                            	                $lc_applicable = $rowLibChild['applicable'];
                            	                $lc_na_reason = htmlentities($rowLibChild['na_reason'] ?? '');
                            	                $lc_name = htmlentities($rowLibChild['name'] ?? '');
                            	                $lc_description = $rowLibChild['description'];
                                                $lc_name_desc = '';
                                                // preg_match_all('/<[^>]+>.*?<\/[^>]+>/', $lc_description, $matches);
                                                preg_match_all('/<(\w+)[^>]*>.*?<\/\1>/', $lc_description, $matches);
                                                if (isset($matches[0][1])) {
                                                    $lc_name_desc = $matches[0][1]; // Outputs: <p>world</p>
                                                }
                            	                
                            	                $html .= '<div>
                            	                    <p><strong>3.'.$x.'.'.$xx++.'.</strong> '.$lc_name_desc.'</p>
                            	                    <p>
                                	                    <label class="checkbox-inline">
                                                            <input type="checkbox" value="1" '; if($lc_applicable == 1) { $html .= 'checked="checked"'; } $html .= ' disabled> Implemented
                                                        </label>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" value="2" '; if($lc_applicable == 2) { $html .= 'checked="checked"'; } $html .= ' disabled> Planned to be Implemented
                                                        </label>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" value="0" '; if($lc_applicable == 0) { $html .= 'checked="checked"'; } $html .= ' disabled> Not Applicable
                                                        </label>
                                                    </p>';
                                                    
                                                    if ($lc_applicable == 0) {
                                                        $html .= '<p>'.$lc_na_reason.'</p>';
                                                    } else if ($lc_applicable == 1) {
                                                        // $selectLibraryNarrative = mysqli_query( $conn,"SELECT description FROM tbl_library WHERE deleted = 0 AND description IS NOT NULL AND description != '' AND ID IN ($lc_child_id)");
                                                        $selectLibraryNarrative = mysqli_query( $conn,"
                                                            SELECT
                                                            l2.name AS l2_name,
                                                            l2.description AS l2_description,
                                                            l2.ID AS l2_ID,
                                                            GROUP_CONCAT(f.name SEPARATOR '|') AS f_name
                                                            FROM tbl_library AS l1
                                                            
                                                            LEFT JOIN (
                                                            	SELECT
                                                                ID,
                                                                name,
                                                                description
                                                                FROM tbl_library
                                                                WHERE deleted = 0
                                                            ) AS l2
                                                            ON FIND_IN_SET(l2.ID, REPLACE(l1.child_id, ' ', ''))

                                                            LEFT JOIN (
                                                            	SELECT
                                                                library_id,
                                                                library_ids,
                                                                name
                                                                FROM tbl_library_file
                                                            ) AS f
                                                            ON FIND_IN_SET(l2.ID, REPLACE(f.library_id, ' ', ''))
                                                            OR FIND_IN_SET(l2.ID, REPLACE(f.library_ids, ' ', ''))
                                                            
                                                            WHERE l1.deleted = 0
                                                            AND l1.ID = $lc_ID
                                                            
                                                            GROUP BY l2.ID
                                                        ");
                                                        if ( mysqli_num_rows($selectLibraryNarrative) > 0 ) {
                                                            $html .= '<table cellpadding="7" cellspacing="0" border="0">
                                                                <tr style="background: #29393b; font-weight: 700;">
                                                        			<td style="background: #cbcbcb; font-weight: 700;">Implementation Narrative</td>
                                                                </tr>';
                                                                
                                                                $req_array = array();
                                                                while($rowLibNarrative = mysqli_fetch_array($selectLibraryNarrative)) {
                                                                    $html .= '<tr>
                                                                        <td>
                                                                            <b>'.$rowLibNarrative['l2_name'].'</b><br>
                                                                            '.$rowLibNarrative['l2_description'];
                                                                            
                                                                            if (isset($_GET['a']) AND $_GET['a'] == 1) {
                                                                                if (!empty($rowLibNarrative['f_name'])) {
                                                                                    $items = explode('|', $rowLibNarrative['f_name']);
                                                                                    
                                                                                    $html .= '<br><i>Reference/Artifacts/Evidence:</i>
                                                                                    <ul>';
                                                                                        foreach ($items as $item) {
                                                                                            $html .= '<li><i>' . htmlspecialchars($item) . '</i></li>';
                                                                                        }
                                                                                    $html .= '</ul>';
                                                                                }
                                                                            }
                                                                            
                                                                        $html .= '</td>
                                                                    </tr>';
                                                                }
                                                                
                                                            $html .= '</table>';
                                                        }
                                                    }
                                                    
                            	                $html .= '</div>';
                            	            }
                            	            $html .= '</div>';
                            	        }
                            	        
                        	        $html .= '</div>';
                        	        $x++;
                                }
                        	    $html .= '</div>';
                        	}
            			$html .= '</div>';
                        
                        if (isset($_GET['r']) AND $_GET['r'] == 1) {
                			$html .= '<div>
                				<p><strong>4. <span style="text-decoration: underline;">RECORD OF CHANGES</span></strong></p>
            
            		    		<table cellpadding="7" cellspacing="0" border="0">
            		    			<tr style="background: #cbcbcb; font-weight: 700;">
            		    				<td>Date</td>
            		    				<td>Description</td>
            		    				<td>Made By:</td>
            		    			</tr>';
            		    			
            		    			$c_date_added = '';
            		    			$selectHistory = mysqli_query( $conn,"
            		    			    SELECT
                                        c.user_id AS c_user_id,
                                        c.portal_user AS c_portal_user,
                                        c.description AS c_description,
                                        c.date_added AS c_date_added,
                                        u.name AS u_name
                                        FROM tbl_cmmc_history AS c
                                        
                                        LEFT JOIN (
                                        	SELECT
                                            ID,
                                            CONCAT(first_name, ' ', last_name) AS name
                                            FROM tbl_user
                                        ) AS u
                                        ON u.ID = c.portal_user
                                        
                                        WHERE c.user_id = $id
                                        AND c.facility_switch = $facility_switch_user_id
            		    			");
                        	        if ( mysqli_num_rows($selectHistory) > 0 ) {
                        	            while($rowHistory = mysqli_fetch_array($selectHistory)) {
                        	                $u_name = $rowHistory['u_name'];
                        	                
                        	                $c_date_added = $rowHistory['c_date_added'];
                                            $c_date_added = date("Y-m-d", strtotime($c_date_added));
                                            
                        	               // $c_description = $rowHistory['c_description '];
                        	               // 1 | 116740764 | 2 | 2 | 1 | 
                        	               
                        	               
                                            $c_description = explode(' | ', $rowHistory["c_description"]);
                                            $cmmc_section = $c_description[0];
                                            $cmmc_ID = $c_description[1];
                                            $cmmc_comment = $c_description[5];
                                            $l_name = '';
                                            
                                            if ($cmmc_section == 1) {
                                                $selectSection = mysqli_query( $conn,"
                                                    WITH RECURSIVE numbers AS (
                                                        SELECT 1 AS n
                                                        UNION ALL
                                                        SELECT n + 1 FROM numbers WHERE n < 10
                                                    )
                                                    SELECT
                                                    CASE WHEN l_parent_id > 0 THEN l_name_id ELSE CONCAT(COALESCE(t.name, ''), ' ', COALESCE(c.name, ''), ' ', COALESCE(s.name, ''), ' ', COALESCE(m.name, '')) END AS l_name
                                                    FROM (
                                                        SELECT 
                                                            SUBSTRING_INDEX(SUBSTRING_INDEX(l.name, ',', numbers.n), ',', -1) AS l_name_id,
                                                            numbers.n AS l_idx,
                                                            l.ID AS l_ID,
                                                            l.child_id AS l_child_id,
                                                            l.ordering AS l_ordering,
                                                        	l.parent_id AS l_parent_id
                                                        FROM tbl_library AS l
                                                        JOIN numbers ON CHAR_LENGTH(l.name)
                                                              -CHAR_LENGTH(REPLACE(l.name, ',', '')) >= numbers.n - 1
                                                    
                                                        WHERE l.deleted = 0
                                                        AND l.facility_switch = 0
                                                        AND l.ID = $cmmc_ID
                                                    ) r
                                                    
                                                    LEFT JOIN tbl_library_type AS t ON r.l_idx = 1 AND t.ID = r.l_name_id
                                                    LEFT JOIN tbl_library_category AS c ON r.l_idx = 2 AND c.ID = r.l_name_id
                                                    LEFT JOIN tbl_library_scope AS s ON r.l_idx = 3 AND s.ID = r.l_name_id
                                                    LEFT JOIN tbl_library_module AS m ON r.l_idx = 4 AND m.ID = r.l_name_id
                                                    
                                                    WHERE r.l_name_id IS NOT NULL
                                                    AND r.l_name_id != ''
                                                    
                                                    ORDER BY r.l_ordering
                                                ");
                                                if ( mysqli_num_rows($selectSection) > 0 ) {
                                                    $rowSection = mysqli_fetch_array($selectSection);
                                                    $l_name = $rowSection['l_name'];
                                                }
                                            }
                        	                
                                            $cmmc_action = $c_description[2];
                                            $action_type = array(
                                                1 => 'added',
                                                2 => 'updated',
                                                3 => 'deleted'
                                            );
                                            
                                            $cmmc_from = $c_description[3];
                                            $cmmc_to = $c_description[4];
                                            $cmmc_type = array(
                                                1 => 'Implemented',
                                                2 => 'Planned to be Implemented ',
                                                0 => 'deleted'
                                            );
                                            
                                            $cmmc_description = $l_name.' was '.$action_type[$cmmc_action].' from "'.$cmmc_type[$cmmc_from].'" to "'.$cmmc_type[$cmmc_to].'".';
                                            if ($cmmc_to == 0 AND !empty($cmmc_comment)) {
                                                $cmmc_description .= 'And the reason is '.$cmmc_comment.'.';
                                            }
                                            
                        	                $html .= '<tr>
                    		    				<td>'.$c_date_added.'</td>
                    		    				<td>'.$cmmc_description.'</td>
                    		    				<td>'.$u_name.'</td>
                    		    			</tr>';
                        	            }
                        	        }
                        	        
            		    		$html .= '</table>
                			</div>';
                        }
            			
            		$html .= '</div>
            	</body>
            </html>';
    	}
	}

    $mpdf->SetHTMLHeader('
	<table width="100%" cellpadding="7" cellspacing="0" border="0">
	    <tr>
	        <td width="50%" style="border: 0;">'.$e_name.' SYSTEM SECURITY PLAN</td>
	        <td width="50%" style="border: 0; text-align: right;">Last Update: '.$c_date_added.'</td>
	    </tr>
	</table>');
    $mpdf->SetHTMLFooter('<div style="text-align: right;">{PAGENO}</div>');
    $mpdf->AddPageByArray([
        'margin-top' => '30px'
    ]);
    $mpdf->WriteHTML($html);
    $mpdf->Output();
    
    // $title = htmlentities($topic ?? '').' - '.date('mdy');
    // $mpdf->SetDisplayMode('fullpage');
    // $mpdf->WriteHTML($html);
    // $mpdf->Output($title.'.pdf', 'I');
    
?>