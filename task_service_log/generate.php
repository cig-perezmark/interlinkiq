<?php
	require '../database_iiq.php';
	if(isset($_POST['daterange'])){
        $date = $_POST['daterange'];
        $date = explode(' - ', $date);
        $data = '';
        
        $date_start = $date[0];
        $date_start = date("Y-m-d", strtotime($date_start));

        $date_end = $date[1];
        $date_end = date("Y-m-d", strtotime($date_end));
        
        $account = '';
        if (!empty($_POST['account'])) {
            $account = ' AND s.account = "'.$_POST['account'].'" ';
        }
        
        $user_id = '';
        if (!empty($_POST['user_id'])) {
            $user_id = ' AND s.user_id = "'.$_POST['user_id'].'" ';
        }
        
        $selectData = mysqli_query( $conn,"
            SELECT 
            u.first_name,
            u.last_name,
            s.account,
            s.action,
            s.services,
            s.description,
            s.comment,
            s.task_date,
            s.minute
            
            FROM tbl_service_logs AS s
            
            LEFT JOIN (
            	SELECT
                ID,
                first_name,
                last_name
                FROM tbl_user
            ) AS u
            ON s.user_id = u.ID
            
            WHERE s.task_date BETWEEN '".$date_start."' AND '".$date_end."'
            $account
            $user_id
        " );
        if ( mysqli_num_rows($selectData) > 0 ) {
            while($rowData = mysqli_fetch_array($selectData)) {
                $description = stripslashes($rowData['description']);
                $comment = str_replace('\r',"\r",str_replace('\n',"\n",$description));
                $description = nl2br(str_replace('\\', "", $description));
                
                $comment = stripslashes($rowData['comment']);
                $comment = str_replace('\r',"\r",str_replace('\n',"\n",$comment));
                $comment = nl2br(str_replace('\\', "", $comment));
                
                $data .= '<tr>
                    <td>'.htmlentities($rowData['first_name'] ?? '').' '.htmlentities($rowData['last_name'] ?? '').'</td>
                    <td>'.htmlentities($rowData['account'] ?? '').'</td>
                    <td>'.htmlentities($rowData['action'] ?? '').'</td>
                    <td>'.htmlentities($rowData['services'] ?? '').'</td>
                    <td>'.$description.'</td>
                    <td>'.$comment.'</td>
                    <td>'.htmlentities($rowData['task_date'] ?? '').'</td>
                    <td>'.htmlentities($rowData['minute'] ?? '').'</td>
                </tr>';
            }
            $output = array(
                "data" => $data
            );
            echo json_encode($output);
        }
        
        // echo $date_start;
    }
    
    if(isset($_GET['s'])) {
        $dataUser = '';
        $dataAccount = '';
        
        if ($_GET['s'] == 1) {
            $selectUser = mysqli_query( $conn,"
                SELECT 
                e.ID, e.first_name, e.last_name,
                u.ID AS user_id
                
                FROM tbl_hr_employee AS e
                
                RIGHT JOIN (
                	SELECT
                    ID,
                    employee_id
                    FROM tbl_user
                ) AS u
                ON e.ID = u.employee_ID
                
                WHERE e.user_id = 34
                AND e.deleted = 0
                
                ORDER BY e.first_name
            " );
            $selectAccount = mysqli_query( $conn,"SELECT account FROM tbl_service_logs WHERE account IS NOT NULL AND account != '' GROUP BY account ORDER BY account" );
        } else {
            $selectUser = mysqli_query( $conn,"
                SELECT 
                e.ID, e.first_name, e.last_name,
                u.ID AS user_id
                
                FROM tbl_hr_employee AS e
                
                RIGHT JOIN (
                	SELECT
                    ID,
                    employee_id
                    FROM tbl_user
                ) AS u
                ON e.ID = u.employee_ID
                
                WHERE e.user_id = 34
                AND e.deleted = 0 
                AND e.suspended = 0
                AND e.status = 1
                
                ORDER BY e.first_name
            " );
            $selectAccount = mysqli_query( $conn,"SELECT name AS account FROM tbl_service_logs_accounts WHERE owner_pk = 34 AND deleted = 0 ORDER BY name" );
        }
        
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $dataUser .= '<option value="">Select VA</option>';
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $dataUser .= '<option value="'.$rowUser['user_id'].'">'.htmlentities($rowUser['first_name'] ?? '').' '.htmlentities($rowUser['last_name'] ?? '').'</option>';
            }
        }
        if ( mysqli_num_rows($selectAccount) > 0 ) {
            $dataAccount .= '<option value="">Select Account</option>';
            while($rowAccount = mysqli_fetch_array($selectAccount)) {
                $dataAccount .= '<option value="'.$rowAccount['account'].'">'.$rowAccount['account'].'</option>';
            }
        }
        
        
        $output = array(
            "dataUser" => $dataUser,
            "dataAccount" => $dataAccount
        );

        echo json_encode($output);
    }
?>