<?php
require '../database.php';
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
if (isset($_POST['key'])) {
	$response = "";

	if ($_POST['key'] == 'get_customer') {
		$sql = $conn->query("SELECT * FROM tbl_Customer_Relationship where account_name != '' and account_category like '%Customer%' order by time_stamp DESC");
		while($data = $sql->fetch_array()) {
 	        $userID = $data["userID"];
 	        
 	        if(employerID($userID) == $user_id) {
    		    $default_added = date_create($data['crm_date_added']);
    			$response .= '
    				<tr>
    					<td style="word-wrap: break-word">'.$data['account_rep'].'</td>
    					<td style="word-wrap: break-word">'.date_format($default_added,"Y/m/d h:i:s a").'</td>
    					<td style="word-wrap: break-word">'.$data['account_name'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_email'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_phone'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_address'].'</td>
    					<td style="word-wrap: break-word">';
    					    $current_task  = $data['userID'];
                            $queriesGEt = "SELECT * FROM tbl_user where ID = $current_task ";
                            $resultQueryGEt = mysqli_query($conn, $queriesGEt);
                            while($rowGEt = mysqli_fetch_array($resultQueryGEt)){ 
                                echo $rowGEt['first_name'];
                                echo ' ';
                                echo $rowGEt['last_name'];
                            }
    					$response .= '</td>
    					<td style="word-wrap: break-word">'.$data['account_certification'].'</td>
    					<td style="word-wrap: break-word">'.$data['Account_Source'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_category'].'</td>
    					<td style="word-wrap: break-word">
    					 <a href="customer_relationship_View.php?view_id='.$data['crm_id'].'" class="btn blue btn-outline" >
                                                                View
                            </a>
                        </td>
    				</tr>
    			';
 	        }
		}
	}
	
	if ($_POST['key'] == 'get_contact') {
		$sql = $conn->query("SELECT * FROM tbl_Customer_Relationship where account_name != '' and account_category like '%Contact%' order by time_stamp DESC");
		while($data = $sql->fetch_array()) {
 	        $userID = $data["userID"];
 	        
 	        if(employerID($userID) == $user_id) {
    		    $default_added = date_create($data['crm_date_added']);
    			$response .= '
    				<tr>
    					<td style="word-wrap: break-word">'.$data['account_rep'].'</td>
    					<td style="word-wrap: break-word">'.date_format($default_added,"Y/m/d h:i:s a").'</td>
    					<td style="word-wrap: break-word">'.$data['account_name'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_email'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_phone'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_address'].'</td>
    					<td style="word-wrap: break-word">';
    					    $current_task  = $data['userID'];
                            $queriesGEt = "SELECT * FROM tbl_user where ID = $current_task ";
                            $resultQueryGEt = mysqli_query($conn, $queriesGEt);
                            while($rowGEt = mysqli_fetch_array($resultQueryGEt)){ 
                                echo $rowGEt['first_name'];
                                echo ' ';
                                echo $rowGEt['last_name'];
                            }
    					$response .= '</td>
    					<td style="word-wrap: break-word">'.$data['account_certification'].'</td>
    					<td style="word-wrap: break-word">'.$data['Account_Source'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_category'].'</td>
    					<td style="word-wrap: break-word">
    					 <a href="customer_relationship_View.php?view_id='.$data['crm_id'].'" class="btn blue btn-outline" >
                                                                View
                            </a>
                        </td>
    				</tr>
    			';
 	        }
		}
	}
    
    if ($_POST['key'] == 'get_prospect') {
		$sql = $conn->query("SELECT * FROM tbl_Customer_Relationship where account_name != '' and account_category like '%Prospect%' order by time_stamp DESC");
		while($data = $sql->fetch_array()) {
 	        $userID = $data["userID"];
 	        
 	        if(employerID($userID) == $user_id) {
    		    $default_added = date_create($data['crm_date_added']);
    			$response .= '
    				<tr>
    					<td style="word-wrap: break-word">'.$data['account_rep'].'</td>
    					<td style="word-wrap: break-word">'.date_format($default_added,"Y/m/d h:i:s a").'</td>
    					<td style="word-wrap: break-word">'.$data['account_name'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_email'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_phone'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_address'].'</td>
    					<td style="word-wrap: break-word">';
    					    $current_task  = $data['userID'];
                            $queriesGEt = "SELECT * FROM tbl_user where ID = $current_task ";
                            $resultQueryGEt = mysqli_query($conn, $queriesGEt);
                            while($rowGEt = mysqli_fetch_array($resultQueryGEt)){ 
                                echo $rowGEt['first_name'];
                                echo ' ';
                                echo $rowGEt['last_name'];
                            }
    					$response .= '</td>
    					<td style="word-wrap: break-word">'.$data['account_certification'].'</td>
    					<td style="word-wrap: break-word">'.$data['Account_Source'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_category'].'</td>
    					<td style="word-wrap: break-word">
    					 <a href="customer_relationship_View.php?view_id='.$data['crm_id'].'" class="btn blue btn-outline" >
                                                                View
                            </a>
                        </td>
    				</tr>
    			';
 	        }
		}
	}
	
	if ($_POST['key'] == 'get_presentation') {
		$sql = $conn->query("SELECT * FROM tbl_Customer_Relationship where account_name != '' and account_category like '%Presentation%' order by time_stamp DESC");
		while($data = $sql->fetch_array()) {
 	        $userID = $data["userID"];
 	        
 	        if(employerID($userID) == $user_id) {
    		    $default_added = date_create($data['crm_date_added']);
    			$response .= '
    				<tr>
    					<td style="word-wrap: break-word">'.$data['account_rep'].'</td>
    					<td style="word-wrap: break-word">'.date_format($default_added,"Y/m/d h:i:s a").'</td>
    					<td style="word-wrap: break-word">'.$data['account_name'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_email'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_phone'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_address'].'</td>
    					<td style="word-wrap: break-word">';
    					    $current_task  = $data['userID'];
                            $queriesGEt = "SELECT * FROM tbl_user where ID = $current_task ";
                            $resultQueryGEt = mysqli_query($conn, $queriesGEt);
                            while($rowGEt = mysqli_fetch_array($resultQueryGEt)){ 
                                echo $rowGEt['first_name'];
                                echo ' ';
                                echo $rowGEt['last_name'];
                            }
    					$response .= '</td>
    					<td style="word-wrap: break-word">'.$data['account_certification'].'</td>
    					<td style="word-wrap: break-word">'.$data['Account_Source'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_category'].'</td>
    					<td style="word-wrap: break-word">
    					 <a href="customer_relationship_View.php?view_id='.$data['crm_id'].'" class="btn blue btn-outline" >
                                                                View
                            </a>
                        </td>
    				</tr>
    			';
 	        }
		}
	}
	
	if ($_POST['key'] == 'get_follow_up') {
		$sql = $conn->query("SELECT * FROM tbl_Customer_Relationship where account_name != '' and account_category like '%Follow Up%' order by time_stamp DESC");
		while($data = $sql->fetch_array()) {
 	        $userID = $data["userID"];
 	        
 	        if(employerID($userID) == $user_id) {
    		    $default_added = date_create($data['crm_date_added']);
    			$response .= '
    				<tr>
    					<td style="word-wrap: break-word">'.$data['account_rep'].'</td>
    					<td style="word-wrap: break-word">'.date_format($default_added,"Y/m/d h:i:s a").'</td>
    					<td style="word-wrap: break-word">'.$data['account_name'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_email'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_phone'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_address'].'</td>
    					<td style="word-wrap: break-word">';
    					    $current_task  = $data['userID'];
                            $queriesGEt = "SELECT * FROM tbl_user where ID = $current_task ";
                            $resultQueryGEt = mysqli_query($conn, $queriesGEt);
                            while($rowGEt = mysqli_fetch_array($resultQueryGEt)){ 
                                echo $rowGEt['first_name'];
                                echo ' ';
                                echo $rowGEt['last_name'];
                            }
    					$response .= '</td>
    					<td style="word-wrap: break-word">'.$data['account_certification'].'</td>
    					<td style="word-wrap: break-word">'.$data['Account_Source'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_category'].'</td>
    					<td style="word-wrap: break-word">
    					 <a href="customer_relationship_View.php?view_id='.$data['crm_id'].'" class="btn blue btn-outline" >
                                                                View
                            </a>
                        </td>
    				</tr>
    			';
 	        }
		}
	}
	
	if ($_POST['key'] == 'tbody_close') {
		$sql = $conn->query("SELECT * FROM tbl_Customer_Relationship where account_name != '' and account_category like '%Close the lead%' order by time_stamp DESC");
		while($data = $sql->fetch_array()) {
 	        $userID = $data["userID"];
 	        
 	        if(employerID($userID) == $user_id) {
    		    $default_added = date_create($data['crm_date_added']);
    			$response .= '
    				<tr>
    					<td style="word-wrap: break-word">'.$data['account_rep'].'</td>
    					<td style="word-wrap: break-word">'.date_format($default_added,"Y/m/d h:i:s a").'</td>
    					<td style="word-wrap: break-word">'.$data['account_name'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_email'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_phone'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_address'].'</td>
    					<td style="word-wrap: break-word">';
    					    $current_task  = $data['userID'];
                            $queriesGEt = "SELECT * FROM tbl_user where ID = $current_task ";
                            $resultQueryGEt = mysqli_query($conn, $queriesGEt);
                            while($rowGEt = mysqli_fetch_array($resultQueryGEt)){ 
                                echo $rowGEt['first_name'];
                                echo ' ';
                                echo $rowGEt['last_name'];
                            }
    					$response .= '</td>
    					<td style="word-wrap: break-word">'.$data['account_certification'].'</td>
    					<td style="word-wrap: break-word">'.$data['Account_Source'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_category'].'</td>
    					<td style="word-wrap: break-word">
    					 <a href="customer_relationship_View.php?view_id='.$data['crm_id'].'" class="btn blue btn-outline" >
                                                                View
                            </a>
                        </td>
    				</tr>
    			';
 	        }
		}
	}
	
	if ($_POST['key'] == 'get_null') {
		$sql = $conn->query("SELECT * FROM tbl_Customer_Relationship where account_name != '' and account_category = '' order by time_stamp DESC");
		while($data = $sql->fetch_array()) {
 	        $userID = $data["userID"];
 	        
 	        if(employerID($userID) == $user_id) {
    		    $default_added = date_create($data['crm_date_added']);
    			$response .= '
    				<tr>
    					<td style="word-wrap: break-word">'.$data['account_rep'].'</td>
    					<td style="word-wrap: break-word">'.date_format($default_added,"Y/m/d h:i:s a").'</td>
    					<td style="word-wrap: break-word">'.$data['account_name'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_email'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_phone'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_address'].'</td>
    					<td style="word-wrap: break-word">';
    					    $current_task  = $data['userID'];
                            $queriesGEt = "SELECT * FROM tbl_user where ID = $current_task ";
                            $resultQueryGEt = mysqli_query($conn, $queriesGEt);
                            while($rowGEt = mysqli_fetch_array($resultQueryGEt)){ 
                                echo $rowGEt['first_name'];
                                echo ' ';
                                echo $rowGEt['last_name'];
                            }
    					$response .= '</td>
    					<td style="word-wrap: break-word">'.$data['account_certification'].'</td>
    					<td style="word-wrap: break-word">'.$data['Account_Source'].'</td>
    					<td style="word-wrap: break-word">'.$data['account_category'].'</td>
    					<td style="word-wrap: break-word">
    					 <a href="customer_relationship_View.php?view_id='.$data['crm_id'].'" class="btn blue btn-outline" >
                                                                View
                            </a>
                        </td>
    				</tr>
    			';
 	        }
		}
	}
	exit($response);
}
	
?>
