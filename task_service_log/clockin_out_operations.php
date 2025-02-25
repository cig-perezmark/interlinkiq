<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require '../database.php';
    
    // Sanitize Input Function
    function sanitizeInput($input, $conn) {
        return mysqli_real_escape_string($conn, trim($input));
    }
    
    function employerID($ID) {
    	global $conn;
    
    	$selectUser = mysqli_query( $conn,"SELECT employee_id from tbl_user WHERE ID = $ID" );
        $rowUser = mysqli_fetch_array($selectUser);
        $current_userEmployeeID = $rowUser['employee_id'];
    
        $current_userEmployerID = $ID;
        if ($current_userEmployeeID > 0) {
            $selectEmployer = mysqli_query( $conn,"SELECT user_id FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID" );
            if ( mysqli_num_rows($selectEmployer) > 0 ) {
                $rowEmployer = mysqli_fetch_array($selectEmployer);
                $current_userEmployerID = $rowEmployer["user_id"];
            }
        }
    
        return $current_userEmployerID;
    }
    
    $employeeid = $_COOKIE['ID'];
    $user_id = !empty($_COOKIE['switchAccount']) ? $_COOKIE['switchAccount'] : employerID($employeeid);
    
    // $type = 1;
    // if (empty($type)) {
    //     echo json_encode(["success" => false, "message" => "Type is required."]);
    //     exit;
    // }
    
    // $employee = "SELECT ID, CONCAT(last_name, ', ', first_name) AS fullname
    //              FROM tbl_hr_employee 
    //              WHERE user_id = ? 
    //              AND type_id = ? 
    //              AND suspended = 0 
    //              AND status = 1 
    //              AND first_name NOT IN ('Admin', 'Arnel') ORDER BY fullname ASC";
    
    // $stmt = $conn->prepare($employee);
    // $stmt->bind_param('ii', $user_id, $type);
    // $stmt->execute();
    // $employeeResult = $stmt->get_result();
    
    // $employees = [];
    // $userIds = [];
    
    // while ($employeeRowQuery = $employeeResult->fetch_assoc()) {
    //     $employees[$employeeRowQuery['ID']] = [
    //         'id' => $employeeRowQuery['ID'],
    //         'name' => $employeeRowQuery['fullname'],
    //         'dates' => []
    //     ];
    //     $userIds[] = $employeeRowQuery['ID'];
    // }
    
    // $stmt->close();
    
    // // If no employees found, return a valid JSON response with empty data
    // if (empty($userIds)) {
    //     echo json_encode(["success" => false, "message" => "No employees found", "data" => []]);
    //     exit;
    // }
    
    // // Step 1: Fetch distinct dates for the last 1 month
    // $datesQuery = "SELECT DISTINCT DATE_FORMAT(tbl_timein.time_in_datetime, '%Y-%m-%d') AS date 
    //               FROM tbl_timein 
    //               LEFT JOIN tbl_hr_employee 
    //               ON tbl_hr_employee.ID = tbl_timein.user_id 
    //               WHERE tbl_timein.time_in_datetime >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)
    //               AND tbl_timein.time_in_datetime <= CURRENT_DATE() 
    //               AND tbl_hr_employee.type_id = ? 
    //               AND tbl_hr_employee.suspended = 0 
    //               AND tbl_hr_employee.status = 1 
    //               ORDER BY tbl_timein.time_in_datetime DESC";
    
    // $stmt2 = $conn->prepare($datesQuery);
    // $stmt2->bind_param('i', $type);
    // $stmt2->execute();
    // $datesResult = $stmt2->get_result();
    
    // $dates = [];
    // while ($dateRow = $datesResult->fetch_assoc()) {
    //     $dates[] = $dateRow['date'];
    // }
    
    // $stmt2->close();
    
    // // If there are no dates found, return empty data
    // if (empty($dates)) {
    //     echo json_encode(["success" => false, "message" => "No data found for the last month", "data" => []]);
    //     exit;
    // }
    
    // // Step 2: Fetch time-in and time-out records for employees within the dates range (last month)
    // $idsPlaceholder = implode(',', array_fill(0, count($userIds), '?')); // Generate placeholders for IN clause
    // $timeins = "SELECT user_id, DATE_FORMAT(time_in_datetime, '%Y-%m-%d') AS date, 
    //                     MIN(CASE WHEN action = 'IN' THEN time_in_datetime END) AS timein,
    //                     MAX(CASE WHEN action = 'OUT' THEN time_in_datetime END) AS timeout
    //             FROM tbl_timein 
    //             WHERE user_id IN ($idsPlaceholder) 
    //             AND DATE_FORMAT(time_in_datetime, '%Y-%m-%d') IN (" . implode(',', array_fill(0, count($dates), '?')) . ") 
    //             AND time_in_datetime >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH) 
    //             AND time_in_datetime <= CURRENT_DATE() 
    //             GROUP BY user_id, date
    //             ORDER BY date DESC";
    
    // $stmt3 = $conn->prepare($timeins);
    // $paramTypes = str_repeat('i', count($userIds) + count($dates)); // Create type string for all parameters ('iiii...')
    // $stmt3->bind_param($paramTypes, ...array_merge($userIds, $dates));
    // $stmt3->execute();
    // $timeinResultQuery = $stmt3->get_result();
    
    // // Loop through all employees and fill in the dates with time-in and time-out data
    // while ($employeeRowQuery = $timeinResultQuery->fetch_assoc()) {
    //     $userId = $employeeRowQuery['user_id'];
    //     $date = $employeeRowQuery['date'];
    
    //     // Ensure we have a date entry for each distinct date within the last month
    //     if (!isset($employees[$userId]['dates'][$date])) {
    //         $employees[$userId]['dates'][$date] = [
    //             'date' => $date,
    //             'timein' => '-',
    //             'timeout' => '-'
    //         ];
    //     }
    
    //     // Update the time-in and time-out if available, else set to '-'
    //     $employees[$userId]['dates'][$date]['timein'] = !empty($employeeRowQuery['timein']) ? date('h:i A', strtotime($employeeRowQuery['timein'])) : '-';
    //     $employees[$userId]['dates'][$date]['timeout'] = !empty($employeeRowQuery['timeout']) ? date('h:i A', strtotime($employeeRowQuery['timeout'])) : '-';
    // }
    
    // $stmt3->close();
    
    // echo '<table id="table_type1" class="table records_table">
    //     <thead>
    //         <tr>
    //             <th class="text-center" width="1%">No.</th>
    //             <th class="text-center" width="10%">Names</th>';

    // // Get all unique dates from the first employee's records
    // $allDates = [];
    // if (!empty($employees)) {
    //     $firstEmployee = reset($employees);
    //     $allDates = array_keys($firstEmployee['dates']);
    // }
    
    // // Echo date headers as they are
    // foreach ($allDates as $date) {
    //     echo '<th class="text-center no-sort">' . $date . '</th>';
    // }
    
    // echo '    </tr>
    //         </thead>
    //         <tbody>';
    
    // $counter = 1;
    // foreach ($employees as $employee) {
    //     echo '<tr>
    //             <td class="text-center">' . $counter++ . '</td>
    //             <td>' . htmlspecialchars($employee['name']) . '</td>';
    
    //     foreach ($allDates as $date) {
    //         // Default values
    //         $timein = '-';
    //         $timeout = '-';
    //         $class = 'bg-danger';
    
    //         if (!empty($employee['dates'][$date])) {
    //             $record = $employee['dates'][$date];
    //             $timein = !empty($record['timein']) && $record['timein'] !== 'N/A' ? $record['timein'] : '-';
    //             $timeout = !empty($record['timeout']) && $record['timeout'] !== 'N/A' ? $record['timeout'] : '-';
    //             $class = ''; // Remove danger class if there's data
    //         }
    
    //         echo '<td class="text-center bold ' . $class . '">
    //                 <a style="text-decoration: none" href="#timeinRecord" data-toggle="modal" class="get_clockin_records" data-id="' . $employee['id'] . '" data-date="' . $date . '">
    //                     <div class="d-flex justify-content-center gap-2">
    //                         <span class="text-success dashed p-3">' . ($timein !== '-' ? 'IN <br>' . $timein : '') . '</span>
    //                         <span class="text-danger dashed p-3">' . ($timeout !== '-' ? 'OUT <br>' . $timeout : '') . '</span>
    //                     </div>
    //                 </a>
    //               </td>';
    //     }
    
    //     echo '</tr>';
    // }
    
    // // Show message if no records exist
    // if (empty($employees)) {
    //     echo '<tr><td colspan="' . (count($allDates) + 2) . '" class="text-center italic">No data found for the last month</td></tr>';
    // }
    
    // echo '</tbody></table>';
    
    // API Endpoints Handler
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        $action = $_POST['action'];
        
        switch($action) {
            case 'getEmploymentTitle':
                $employment_type = [
                    1 => 'Full-time',
                    2 => 'Part-Time',
                    3 => 'OJT',
                    4 => 'Freelance',
                    5 => 'Part-Time Apprentice',
                    6 => 'Trainee',
                    7 => 'Consultant',
                    8 => 'Contractor',
                    9 => 'Salaried',
                    10 => 'Seasonal'
                ];
                
                $stmt = $conn->prepare("SELECT DISTINCT type_id AS type
                                        FROM tbl_hr_employee
                                        WHERE user_id = ?
                                        AND ID NOT IN (1240, 1241, 1399)
                                        AND deleted = 0
                                        AND suspended = 0
                                        AND status = 1");
                
                if ($stmt === false) {
                    echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
                    exit;
                }
                
                $stmt->bind_param('i', $user_id);
                
                if (!$stmt->execute()) {
                    echo json_encode(["success" => false, "message" => "Error executing statement: " . $stmt->error]);
                    exit;
                }
                
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $records = [];
                    while ($row = $result->fetch_assoc()) {
                        $row['title'] = $employment_type[$row['type']] ?? 'Unknown';
                        $records[] = $row;
                    }
                
                    echo json_encode(["success" => true, "data" => $records]);
                } else {
                    echo json_encode(["success" => false, "message" => "No records found"]);
                }
                
                $stmt->close();
                break;
                
            case 'getTimeins':
                $type = sanitizeInput($_POST['type'], $conn);
                if (empty($type)) {
                    echo json_encode(["success" => false, "message" => "Type is required."]);
                    exit;
                }
                
                $employee = "SELECT ID, CONCAT(last_name, ', ', first_name) AS fullname
                             FROM tbl_hr_employee 
                             WHERE user_id = ? 
                             AND type_id = ? 
                             AND suspended = 0 
                             AND status = 1 
                             AND first_name NOT IN ('Admin', 'Arnel') ORDER BY fullname ASC";
                
                $stmt = $conn->prepare($employee);
                $stmt->bind_param('ii', $user_id, $type);
                $stmt->execute();
                $employeeResult = $stmt->get_result();
                
                $employees = [];
                $userIds = [];
                
                while ($employeeRowQuery = $employeeResult->fetch_assoc()) {
                    $employees[$employeeRowQuery['ID']] = [
                        'id' => $employeeRowQuery['ID'],
                        'name' => $employeeRowQuery['fullname'],
                        'dates' => []
                    ];
                    $userIds[] = $employeeRowQuery['ID'];
                }
                
                $stmt->close();
                
                // If no employees found, return a valid JSON response with empty data
                if (empty($userIds)) {
                    echo json_encode(["success" => false, "message" => "No employees found", "data" => []]);
                    exit;
                }
                
                // Step 1: Fetch distinct dates for the last 1 month
                $datesQuery = "SELECT DISTINCT DATE_FORMAT(tbl_timein.time_in_datetime, '%Y-%m-%d') AS date 
                              FROM tbl_timein 
                              LEFT JOIN tbl_hr_employee 
                              ON tbl_hr_employee.ID = tbl_timein.user_id 
                              WHERE tbl_timein.time_in_datetime BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW()
                              AND tbl_hr_employee.type_id = ? 
                              AND tbl_hr_employee.suspended = 0 
                              AND tbl_hr_employee.status = 1 
                              ORDER BY tbl_timein.time_in_datetime DESC";
                
                $stmt2 = $conn->prepare($datesQuery);
                $stmt2->bind_param('i', $type);
                $stmt2->execute();
                $datesResult = $stmt2->get_result();
                
                $dates = [];
                while ($dateRow = $datesResult->fetch_assoc()) {
                    $dates[] = $dateRow['date'];
                }
                
                $stmt2->close();
                
                // If there are no dates found, return empty data
                if (empty($dates)) {
                    echo json_encode(["success" => false, "message" => "No data found for the last month", "data" => []]);
                    exit;
                }
                
                // Step 2: Fetch time-in and time-out records for employees within the dates range (last month)
                $idsPlaceholder = implode(',', array_fill(0, count($userIds), '?')); // Generate placeholders for IN clause
                $timeins = "SELECT user_id, DATE_FORMAT(time_in_datetime, '%Y-%m-%d') AS date, 
                                    MIN(CASE WHEN action = 'IN' THEN time_in_datetime END) AS timein,
                                    MAX(CASE WHEN action = 'OUT' THEN time_in_datetime END) AS timeout
                            FROM tbl_timein 
                            WHERE user_id IN ($idsPlaceholder) 
                            AND DATE_FORMAT(time_in_datetime, '%Y-%m-%d') IN (" . implode(',', array_fill(0, count($dates), '?')) . ") 
                            GROUP BY user_id, date
                            ORDER BY date DESC";
                
                $stmt3 = $conn->prepare($timeins);
                $paramTypes = str_repeat('i', count($userIds) + count($dates)); // Create type string for all parameters ('iiii...')
                $stmt3->bind_param($paramTypes, ...array_merge($userIds, $dates));
                $stmt3->execute();
                $timeinResultQuery = $stmt3->get_result();
                
                // Loop through all employees and fill in the dates with time-in and time-out data
                while ($employeeRowQuery = $timeinResultQuery->fetch_assoc()) {
                    $userId = $employeeRowQuery['user_id'];
                    $date = $employeeRowQuery['date'];
                
                    // Ensure we have a date entry for each distinct date within the last month
                    if (!isset($employees[$userId]['dates'][$date])) {
                        $employees[$userId]['dates'][$date] = [
                            'date' => $date,
                            'timein' => '-',
                            'timeout' => '-'
                        ];
                    }
                
                    // Update the time-in and time-out if available, else set to '-'
                    $employees[$userId]['dates'][$date]['timein'] = !empty($employeeRowQuery['timein']) ? date('h:i A', strtotime($employeeRowQuery['timein'])) : '-';
                    $employees[$userId]['dates'][$date]['timeout'] = !empty($employeeRowQuery['timeout']) ? date('h:i A', strtotime($employeeRowQuery['timeout'])) : '-';
                }
                
                $stmt3->close();
                
                echo json_encode(["success" => true, "data" => $employees]);
                exit;
                break;
                
            default:
                echo json_encode(["success" => false, "message" => "Invalid action."]);
            break;
        }
    }
