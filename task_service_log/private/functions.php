<?php 

if(!isset($_COOKIE['ID'])) {
    die("invalid user access");
}

// include "connection.php";
include_once __DIR__ . '../../../alt-setup/setup.php';
$con = $conn;

// error_reporting(E_ALL);
default_timezone();

$method = $_SERVER['REQUEST_METHOD'] == 'GET' ? $_GET['method'] : $_POST['method'];

if(function_exists($method)) 
    call_user_func($method);
else exit("function do not exist");

function getActions() {
    global $con;
    $data = array();
    $results = $con->query("SELECT DISTINCT(action) FROM tbl_service_logs WHERE user_id = {$_COOKIE['ID']} AND not_approved = 0");
    
    if(mysqli_num_rows($results) > 0)
        while($row = $results->fetch_assoc())
            $data[] = $row['action'];

    echo json_encode($data);
    $con->close();
}

function getAccounts() {
    global $con;
    $data = array();
    $results = $con->query("SELECT DISTINCT(account) FROM tbl_service_logs WHERE user_id = {$_COOKIE['ID']} AND not_approved = 0");
    
    if(mysqli_num_rows($results) > 0)
        while($row = $results->fetch_assoc())
            $data[] = $row['account'];

    echo json_encode($data);
    $con->close();
}


// va summary functions



function getVASummary() {
    global $con, $portal_user;
    // $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    // $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    // $today = $date_default_tx->format('Y-m-d');
    
    $today = date("Y-m-d");
    $last_month = date('Y-m-d', strtotime('-30 days'));

    $showAllClause = "AND user_id = $portal_user";
    if(
        // $portal_user == 1105 || 
        $portal_user == 54 || // ms tin
        $portal_user == 387 || // ms girl
        $portal_user == 34 // hr
    ) {
        $showAllClause = "";
    }
     
    $results = $con->query("SELECT 
            *,
            user_id,
            CONCAT(first_name,' ',last_name) AS name, 
            SUM(minute) AS total_minutes 
        FROM tbl_service_logs 
        LEFT JOIN tbl_user on ID = user_id
        WHERE task_date >= '$last_month' 
            AND task_date <= '$today' 
            AND is_active = 1 
            AND not_approved = 0 
            $showAllClause
        GROUP BY task_date, user_id 
        ORDER BY task_date DESC
    ");
    $data = array();

    if(mysqli_num_rows($results) > 0) {
        while($row = $results->fetch_assoc()){
           if(!empty($row['user_id'])){
                $data[] = $row;
           }
        }
            
    }

    echo json_encode($data);
    $con->close();
}

function fetchVAServicesLogs() {
    global $con;
    // $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    // $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    // $today = $date_default_tx->format('Y-m-d');
    $today = date("Y-m-d");
    $last_month = date('Y-m-d', strtotime('-30 days'));

    $va_ = $_POST['vaInfo'];

    $pst = $con->prepare("SELECT * FROM tbl_service_logs WHERE user_id = ? 
                        AND (task_date >= '$last_month' AND task_date <= '$today' AND not_approved = 0)");
                        
    // $pst = $con->prepare("SELECT
    //     *
    //     FROM tbl_service_logs AS s 
    //     INNER JOIN (
    //     	SELECT
    //         ID AS u_ID,
    //         employee_id as u_employee_id
    //         FROM tbl_user
    //     	WHERE is_active = 1
    //     ) AS u 
    //     ON u.u_ID = s.user_id
        
    //     INNER JOIN (
    //     	SELECT
    //         ID AS e_ID,
    //         user_id AS e_user_id
    //         FROM tbl_hr_employee 
    //         WHERE suspended = 0
    //         AND status = 1
    //     ) AS e 
    //     ON e.e_ID = u.u_employee_id
        
    //     WHERE e.e_user_id = $switch_user_id
    //     AND s.not_approved = 0
    //     AND s.user_id = ?
    //     AND (s.task_date >= '$last_month' AND s.task_date <= '$today')");
    $pst->bind_param('s', $va_);
    $pst->execute();
    $results = $pst->get_result();

    $servicelogs = array( "data" => [] );

    if(mysqli_num_rows($results) > 0) {
        while($row = $results->fetch_assoc())
            $servicelogs['data'][] = $row;
    }

    $servicelogs['info'] = array(
        "name" => $va_,
        "dates" => $last_month . " to " . $today
    );

    echo json_encode($servicelogs);

    $pst->close();
    $con->close();
}