<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    header("Content-Type: application/json"); // Ensure JSON response

    require_once '../../database.php';
    require_once __DIR__ . '/Database.php';

    // Sanitize Input Function
    function sanitizeInput($input, $conn) {
        return mysqli_real_escape_string($conn, trim($input));
    }
    
    // API Endpoints Handler
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        $action = $_POST['action'];
        
        switch($action) {
            
            case 'get_details':
                $employee = 290;
                $fullname = $_COOKIE['last_name'] . ', ' . $_COOKIE['first_name'];
                
                $stmt1 = $conn->prepare("SELECT personal_email, company_email, address, contact_no, emergency_name, emergency_address, emergency_contact_no, emergency_email, emergency_relation 
                                         FROM others_employee_details 
                                         WHERE employee_id = ?");
                
                if ($stmt1 === false) {
                    die("Error preparing statement 1: " . $conn->error);
                }
                
                $stmt1->bind_param('i', $employee);
                
                if (!$stmt1->execute()) {
                    die("Error executing statement 1: " . $stmt1->error);
                }
                
                $stmt1->bind_result($personal_email, $company_email, $address, $contact_no, $e_name, $e_address, $e_contact, $e_email, $e_relation);
                
                $employeeData = [];
                
                if ($stmt1->fetch()) {
                    $cleanedFullAddress = trim(preg_replace('/\s*\|\s*/', ' ', $address));
            
                    $employeeData = [
                        "va_name"   =>  $fullname,
                        "personal_email" => $personal_email,
                        "company_email" => $company_email,
                        "address" => $cleanedFullAddress,
                        "contact_no" => $contact_no,
                        "emergency_name" => $e_name,
                        "emergency_address" => $e_address,
                        "emergency_contact_no" => $e_contact,
                        "emergency_email" => $e_email,
                        "emergency_relation" => $e_relation
                    ];
                }
                
                $stmt1->close();
                
                $stmt2 = $payroll_conn->prepare("SELECT accountname, accountno, bankno FROM payee WHERE payeeid = ?");
                
                if ($stmt2 === false) {
                    die("Error preparing statement 2: " . $payroll_conn->error);
                }
                
                $stmt2->bind_param('i', $employee);
                
                if (!$stmt2->execute()) {
                    die("Error executing statement 2: " . $stmt2->error);
                }
                
                $stmt2->bind_result($accountname, $accountno, $bankno);
                
                $payeeData = [];
                
                if ($stmt2->fetch()) {
                    $payeeData = [
                        "account_name" => $accountname,
                        "account_no" => $accountno,
                        "bank_no" => $bankno
                    ];
                }
                
                $stmt2->close();
                
                $result = [
                    "employee_details" => array_merge((array) $employeeData, (array) $payeeData),
                ];
                
                echo json_encode(["success" => true, "data" => $result]);
                $conn->close();
                $payroll_conn->close();
                break;
                
            default:
                echo json_encode(["success" => false, "message" => "Invalid action."]);
            break;
        }
    }