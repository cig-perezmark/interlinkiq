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
    if(isset($_POST['search'])){
    	    $search = $_POST['search'];
     	    $query = "SELECT * FROM tbl_Customer_Relationship where account_rep LIKE '{$search}%' OR crm_date_added LIKE '{$search}%' OR account_name LIKE '{$search}%' OR
     	    account_name LIKE '{$search}%' OR account_email LIKE '{$search}%' OR account_phone LIKE '{$search}%' OR account_address LIKE '{$search}%' OR account_country LIKE '{$search}%' OR 
     	    account_certification LIKE '{$search}%' OR Account_Source LIKE '{$search}%' OR account_category LIKE '{$search}%'";
     		$result = mysqli_query($conn, $query);
     		if(mysqli_num_rows($result) > 0){
     		    while($row = mysqli_fetch_assoc($result)) {
     		        $userID = $row["userID"];
     		        
     		        if(employerID($userID) == $user_id) {
     		            $default_added = date_create($row['crm_date_added']);
     		    ?>
     		        
     		        <tr>
     					<td style="word-wrap: break-word"><?php echo $row['account_rep']; ?></td>
     					<td style="word-wrap: break-word"><?php echo date_format($default_added,"Y/m/d h:i:s"); ?></td>
     					<td style="word-wrap: break-word"><?php echo $row['account_name']; ?></td>
     					<td style="word-wrap: break-word"><?php echo $row['account_email']; ?></td>
     					<td style="word-wrap: break-word"><?php echo $row['account_phone']; ?></td>
     					<td style="word-wrap: break-word"><?php echo $row['account_address']; ?></td>
     					<td style="word-wrap: break-word">
     					    <?php 
                                $current_task  = $row['userID'];
                                $queriesGEt = "SELECT * FROM tbl_user where ID = $current_task ";
                                $resultQueryGEt = mysqli_query($conn, $queriesGEt);
                                while($rowGEt = mysqli_fetch_array($resultQueryGEt)){ 
                                    echo $rowGEt['first_name'];
                                    echo ' ';
                                    echo $rowGEt['last_name'];
                                }
                            ?>
     					</td>
     					<td style="word-wrap: break-word"><?php echo $row['account_certification']; ?></td>
     					<td style="word-wrap: break-word"><?php echo $row['Account_Source']; ?></td>
     					<td style="word-wrap: break-word"><?php echo $row['account_category']; ?></td>
     					<td style="word-wrap: break-word">
     					    <a href="customer_relationship_View.php?view_id=<?php echo $row['crm_id'];  ?>" class="btn blue btn-outline" >
                                                                View
                            </a>
     					</td>
     				</tr>
    				
    	        <?php }	}
     		}
     		else{
     		    echo '<h6>No data found</h6>';
     		}
             
    }
    if (isset($_POST['key'])) {
    	$response = "";
    
        $search = $POST['search'];
        //  where account_rep LIKE '{$search}%'
    	if ($_POST['key'] == 'getCRM') {
    		$sql = $conn->query("SELECT * FROM tbl_Customer_Relationship where account_name != '' order by time_stamp DESC");
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