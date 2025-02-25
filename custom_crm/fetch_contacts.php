<?php
require '../database.php';

$ouput = '';
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

// update contact
// if(isset($_POST['update_contact'])) {
    
// }

// Filter data through date and category/status
if(isset($_POST['filter_value'])) {
    $column = $_POST['column'];
    $value = $_POST['value'];
    // Filter data by date 
    if($column == 'crm_date_added') {
        $sql = "SELECT
                    crm_id, 
                    userID, 
                    crm_date_added, 
                    account_rep, 
                    account_name, 
                    account_email, 
                    account_phone, 
                    account_address, 
                    account_certification, 
                    Account_Source, 
                    account_category 
                FROM tbl_Customer_Relationship
                WHERE LENGTH(account_name) > 0
                AND crm_date_added >= DATE_SUB(NOW(), INTERVAL $value)";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                    $default_added = date_create($row['crm_date_added']);
                    $output .= '
                    <tr>
                        <td>'.$row["account_name"].'</td>
                        <td>';
                        if($row['userID']== $_COOKIE['ID']) {
                            $output .= '<a class="btn btn-sm green" href="customer_relationship_View.php?view_id='.$row['crm_id'].'">
                                <i class="icon-eye"></i> Manage 
                            </a>';
                        }
                      $output .= ' </td>
                    </tr>';
            }
            echo $output;
        }
    // Filter data by category/status 
    } elseif($column == 'account_category') {
        $sql = "SELECT
                    crm_id, 
                    userID, 
                    crm_date_added, 
                    account_rep, 
                    account_name, 
                    account_email, 
                    account_phone, 
                    account_address, 
                    account_certification, 
                    Account_Source, 
                    account_category 
                FROM tbl_Customer_Relationship
                WHERE $column = '$value'"; // Enclose string values in single quotes
        $result = mysqli_query($conn, $sql); // Corrected variable name
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                    $default_added = date_create($row['crm_date_added']);
                    $output .= '
                    <tr>
                        <td>'.$row["account_name"].'</td>
                        <td>';
                        if($row['userID']== $_COOKIE['ID']) {
                            $output .= '<a class="btn btn-sm green" href="customer_relationship_View.php?view_id='.$row['crm_id'].'">
                                <i class="icon-eye"></i> Manage 
                            </a>';
                        }
                      $output .= ' </td>
                    </tr>';
            }
            echo $output;
        }
    } else {
        // Handle other cases if needed
    }
}

// filter contacts by date ranges
if (isset($_POST['filter_range'])) {
    
    $from = $_POST['from'];
    $from_date = date_create($from);
    $rfrom = date_format($from_date, "Y-m-d");

    $to = $_POST['to'];
    $to_date = date_create($to);
    $rto = date_format($to_date, "Y-m-d");

    $sql = "SELECT 
                crm_id, 
                userID, 
                crm_date_added, 
                account_rep, 
                account_name, 
                account_email, 
                account_phone, 
                account_address, 
                account_certification, 
                Account_Source, 
                account_category 
            FROM tbl_Customer_Relationship 
            WHERE crm_date_added BETWEEN ? AND ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $rfrom, $rto);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $crm_date_added = date_create($row["crm_date_added"]);
            $output .= '
                <tr>
                    <td>'.$row["account_name"].'</td>
                    <td>';
                    if($row['userID']== $_COOKIE['ID']) {
                        $output .= '<a class="btn btn-sm green" href="customer_relationship_View.php?view_id='.$row['crm_id'].'">
                            <i class="icon-eye"></i> Manage 
                        </a>';
                    }
                  $output .= ' </td>
                </tr>';
        }

        echo $output;
    } else {
        echo 'No data Found!';
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

// get all contact
if(isset($_POST['query'])) {
    $query = "SELECT crm_id, 
                userID, crm_date_added, 
                account_rep, 
                account_name, 
                account_email, 
                account_phone, 
                account_address, 
                account_certification, 
                Account_Source, 
                account_category 
            FROM tbl_Customer_Relationship 
            WHERE LENGTH(account_name) > 0 
            AND crm_date_added >= DATE_SUB(NOW(), INTERVAL 1 YEAR)
            ORDER BY account_name LIMIT 200";
            
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
                $default_added = date_create($row['crm_date_added']);
                $output .= '
                <tr>
                    <td>'.$row["account_name"].'</td>
                    <td>';
                    if($row['userID']== $_COOKIE['ID']) {
                        $output .= '<a class="btn btn-sm green" href="customer_relationship_View.php?view_id='.$row['crm_id'].'">
                            <i class="icon-eye"></i> Manage 
                        </a>';
                    }
                  $output .= ' </td>
                </tr>';
        }
     echo $output;
    } else {
     echo 'Data Not Found';
    }
}

if(isset($_POST['search_contact'])) {
    $searchValue = $_POST['searchVal'];
    $query = "
        SELECT account_name FROM tbl_Customer_Relationship 
        WHERE  account_name LIKE '%".$searchValue."%'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            $output .= '
                <tr>
                    <td>'.$row["account_name"].'</td>
                    <td>';
                    if($row['userID']== $_COOKIE['ID']) {
                        $output .= '<a class="btn btn-sm green" href="customer_relationship_View.php?view_id='.$row['crm_id'].'">
                            <i class="icon-eye"></i> Manage 
                        </a>';
                    }
                  $output .= ' </td>
                </tr>';
        }
     echo $output;
    } else {
     echo 'Data Not Found';
    } 
}

// Search function through input
// if(isset($_POST['search_contacts'])) {
//     $searchValue = $_POST['searchVal'];
//     $query = "
//         SELECT * FROM tbl_Customer_Relationship 
//         WHERE  account_name LIKE '%".$searchValue."%'
//         OR account_email LIKE '%".$searchValue."%' 
//         OR account_phone LIKE '%".$searchValue."%' 
//         OR account_address LIKE '%".$searchValue."%' 
//         OR Account_Source LIKE '%".$searchValue."%'
//         OR account_rep LIKE '%".$searchValue."%'
//         OR account_certification LIKE '%".$searchValue."%'
//         OR account_category LIKE '%".$searchValue."%'
//     LIMIT 100";
    
//     $result = mysqli_query($conn, $query);
//     if(mysqli_num_rows($result) > 0) {
//         while($row = mysqli_fetch_array($result)) {
//             $userID = $row["userID"];
//             if(employerID($userID) == $user_id) {
//                 $default_added = date_create($row['crm_date_added']);
//                 $output .= '
//                 <tr>
//                     <td>'.$row["account_rep"].'</td>
//                     <td>'.date_format($default_added,"F d, Y").'</td>
//                     <td>'.$row["account_name"].'</td>
//                     <td width="250px">'.$row["account_email"].'</td>
//                     <td>'.$row["account_phone"].'</td>
//                     <td>'.$row["account_address"].'</td>
//                     <td>'.$row["account_certification"].'</td>
//                     <td>'.$row["Account_Source"].'</td>
//                     <td>'.$row["account_category"].'</td>
//                     <td>
//                         <div class="btn-group">
//                             <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
//                                 <i class="fa fa-angle-down"></i>
//                             </button>
//                             <ul class="dropdown-menu pull-left" role="menu">
//                                 <li>
//                                     <a href="href="customer_relationship_View.php?view_id='.$row['crm_id'].'"">
//                                         <i class="icon-docs"></i> View </a>
//                                 </li>
//                                 <li>
//                                     <a href="javascript:;">
//                                         <i class="icon-tag"></i> Add Remarks </a>
//                                 </li>
//                                 <li class="divider"> </li>
//                                 <li>
//                                     <a href="javascript:;">
//                                         <i class="icon-flag"></i> Remarks
//                                         <span class="badge badge-success">4</span>
//                                     </a>
//                                 </li>
//                             </ul>
//                         </div>
//                     </td>
//                 </tr>';
//             }
//         }
//      echo $output;
//     } else {
//      echo 'Data Not Found';
//     }
    
// }

// History
if(isset($_POST['get_history_data'])) {
    $contact_id = $_POST['contact_id'];
    
    $sql = "SELECT * FROM tbl_crm_history_data WHERE contact_id = $contact_id ORDER BY history_id DESC";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)) {
        while($row = mysqli_fetch_array($result)) {
            $dateTime = new DateTime($row['updated_at']);
            $formattedDate = $dateTime->format("F d, Y  D, g:i:s A");
            $output .= '
            <tr>
                <td>'.$row["history_id"].'</td>
                <td>'.$row["action_taken"].'</td>
                <td>'.$row["performer_name"].'</td>
                <td>'.$formattedDate.'</td>
            </tr>';
        }
        echo $output;
    }
}


// add comment/chat/remarks
if(isset($_POST['add_remarks'])) {
    $id = $_POST['contactid'];
    $parentid = $_POST['parentid'];
    $userid = $_COOKIE['ID'];
    $commentator = $_COOKIE['first_name'] . ' ' . $_COOKIE['last_name'];
    $action = $_POST['action'];
    $remark = $_POST['message'];
    
    $sql = "INSERT INTO (contact_id,user_id,parent_id,action,commentator,remarks) VALUES ('$id','$userid','$action','$commentator','$remark')";
    $result = mysqli_query($conn,$sql);
    if(!result) {
        die("Query failed: " . mysqli_error($conn));
    }
}

// Notification Count
if (isset($_POST['get_notification_count'])) {
    $id = $_POST['contact_id'];
    $sql = "SELECT COUNT(*) FROM tbl_crm_remarks WHERE contact_id = $id AND status = 1";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_row($result);
        $count = $row[0];
        echo $count;
    } else {
        die("Query failed: " . mysqli_error($conn));
    }
}

// Message/Chat/Remarks Threads
if (isset($_POST['get_crm_remarks'])) {
    $id = $_POST['contact_id'];
    $output = '<ul class="chats">';
    $sql = "SELECT * FROM tbl_crm_remarks WHERE contact_id = $id";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $word = $row['commentator'];
            $dateTime = new DateTime($row['remarked_at']);
            $formattedDate = $dateTime->format(" D g:i A, F d, Y ");

            $type = ($row['user_id'] != $_COOKIE['ID']) ? 'in' : 'out';
            $bg = ($type == 'in') ? 'style="background-color:#e9eff3"' : '';
            $placement = ($type == 'in') ? 'right' : 'left';
            $reply_style = ($type == 'in') ? 'display: flex; justify-content: start; margin-left: 6.3rem; margin-top: 0.3rem;' : 'display: flex; justify-content: end; margin-right: 6.3rem; margin-top: 0.3rem;';
            $areply_style = ($type == 'in') ? 'display: flex; justify-content: start; margin-left: 6.3rem; margin-bottom: 0.3rem; padding: 5px;' : 'display: flex; justify-content: end; margin-right: 6.3rem; margin-bottom: 0.3rem; padding: 5px;';
            $action = (!empty($row['action'])) ? $row['action'] : '';
            $output .= '
                <li class="' . $type . '">
                    <a class="btn btn-circle btn-icon-only btn-default uppercase avatar">
                        <span style="font-size: 2rem; font-weight: bolder" class="toggler tooltips" data-container="body" data-placement="' . $placement . '" data-html="true" data-original-title="' . $row['commentator'] . '">' . $firstLetter = $word[0] . '</span>
                    </a>
                    <span style="'.$areply_style.'">'.$action.'</span>
                    <div class="message" ' . $bg . '>
                        <span class="arrow"> </span>
                        <a href="javascript:;" class="name"> ' . $row['commentator'] . ' </a>
                        <span class="datetime"> at ' . $formattedDate . ' </span>
                        <span class="body"> ' . $row['remarks'] . ' </span>
                    </div>
                    <a class="replyMessage" data-id="'. $row['remarks_id'] .'" style="'.$reply_style.'">Reply<a>
                </li>';
        }
        $output .= '</ul>';
        echo $output;
    } else {
        echo '<div class="note note-success">
                <p><i class="fa fa-exclamation-circle"></i> No Message/Remarks. </p>
              </div>';
    }
}
?>
