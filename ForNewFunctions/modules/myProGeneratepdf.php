<?php
require_once 'dompdf/autoload.inc.php';
include "database.php";
use Dompdf\Dompdf;

// Function to generate the PDF
function generatePDF($htmlContent) {
    $dompdf = new Dompdf();
    $dompdf->loadHtml($htmlContent);

    // (Optional) Set any configuration options here
    // For example, you can set paper size, orientation, etc.
 $dompdf->setPaper('A4', 'landscape');

    $dompdf->render();
    return $dompdf->output();
}

// Check if the viewId parameter is provided
if (isset($_GET['viewId'])) {
    // Get the viewId from the URL
    $view_id = $_GET['viewId'];

       $htmlContent = '<!DOCTYPE html><html><head><title>PDF</title>';
    $htmlContent .= '<style>';
    $htmlContent .= 'table { width: 100%; border-collapse: collapse; }';
    $htmlContent .= 'th, td { border: 1px solid black; padding: 8px; }';
    $htmlContent .= '</style>';
    $htmlContent .= '</head><body>';
    $htmlContent .= '<table>';
    $htmlContent .= '<thead>';
    $htmlContent .= '<tr>';
    $htmlContent .= '<th>Title</th>';
    $htmlContent .= '<th>Description</th>';
    $htmlContent .= '<th>Assignee</th>';
    $htmlContent .= '<th>Compliance</th>';
    $htmlContent .= '<th>Due Date</th>';
    $htmlContent .= '<th>Sub task</th>';
    $htmlContent .= '<th>Comments</th>';
    $htmlContent .= '</tr>';
    $htmlContent .= '</thead>';
    $htmlContent .= '<tbody>';
     $sql = $conn->query("SELECT *,tbl_MyProject_Services_History.user_id as owner 
         FROM tbl_MyProject_Services_History 
         left join tbl_MyProject_Services_Action_Items on Action_Items_id = Action_taken
         left join tbl_hr_employee on Assign_to_history = ID 
         left join tbl_user on employee_id = tbl_hr_employee.ID 
         where tbl_MyProject_Services_History.is_deleted=0 AND MyPro_PK = $view_id");
    while ($data1 = $sql->fetch_array()) {
        $id_st = $data1['History_id'];
        $ck = 35;
        // $ck = $_COOKIE['employee_id'];
        $counter = 1;
        $counter_result = 0;
        $MyTask = '';
        $h_id = '';
        $ptc = '';

        $sql__MyTask = $conn->query("SELECT COUNT(*) as taskcount FROM tbl_MyProject_Services_Childs_action_Items WHERE Services_History_PK = '$id_st'");
        $data_MyTask = $sql__MyTask->fetch_array();
        $counter_result = $data_MyTask['taskcount'];


        $sql_counter = $conn->query("SELECT COUNT(*) as counter FROM tbl_MyProject_Services_Comment where Task_ids = '$id_st'");
        while ($data_counter = $sql_counter->fetch_array()) {
            $count_result = $data_counter['counter'];
        }
        $sql_compliance = $conn->query("SELECT COUNT(*) as compliance FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress = 2");
        while ($data_compliance = $sql_compliance->fetch_array()) {
            $comp = $data_compliance['compliance'];
        }
        $sql_none_compliance = $conn->query("SELECT COUNT(*) as non_comp FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress != 2");
        while ($data_none_compliance = $sql_none_compliance->fetch_array()) {
            $non = $data_none_compliance['non_comp'];
        }
        $ptc = 0;
        if (!empty($comp) && !empty($non)) {
            $percent = $comp / $counter_result;
            $ptc = number_format($percent * 100, 2) . '%';
        } elseif (empty($non) && !empty($comp)) {
            $ptc = '100%';
        } else {
            $ptc = '0%';
        }
        $owner  = $data1['Assign_to_history'];
        $query = "SELECT * FROM tbl_user where employee_id = '$owner'";
        $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_array($result)) {
               $selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$row['ID']."'");
                                                                            
                  if (mysqli_num_rows($selectUserInfo) > 0) {
                  $rowInfo = mysqli_fetch_assoc($selectUserInfo);
                  $current_userAvatar = $rowInfo['avatar'];
                   }
            $firstNameInitial = $row['first_name'];
            $lastNameInitial = $row['last_name'];
        }
        $initials = $firstNameInitial . '&nbsp;' . $lastNameInitial;
      
    $htmlContent .= '<tr>';
    $htmlContent .= '<td>' .$data1['filename']. '</td>';
    $htmlContent .= '<td>' . $data1['description'] . '</td>';
    $htmlContent .= '<td style="white-space: nowrap;">'.$initials.'</td>';
    $htmlContent .= '<td>' . $ptc . '</td>';
    $htmlContent .= '<td style="white-space: nowrap;">' . date("Y-m-d", strtotime($data1['Action_date'])) . '</td>';
    $htmlContent .= '<td style="white-space: nowrap;">' .  $counter_result . '</td>';
    $htmlContent .= '<td>' .  $count_result . '</td>';
    $htmlContent .= '</tr>';
    }
    $htmlContent .= '</tbody>';
    $htmlContent .= '</table>';
    $htmlContent .= '</body></html>';

    // Generate the PDF
    $pdfData = generatePDF($htmlContent);

    // Set the appropriate response headers for PDF download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="generated_pdf.pdf"');

    // Output the PDF
    echo $pdfData;
} else {
    // If the viewId parameter is not provided, handle the error appropriately.
    echo 'Error: Missing viewId parameter.';
}
?>
