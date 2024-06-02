
	<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include PHPExcel library
// require_once 'PHPExcel/PHPExcel.php';

// // Create new PHPExcel object
// $objPHPExcel = new PHPExcel();

// // Set default properties
// $objPHPExcel->getProperties()->setCreator('Your Name')
//     ->setLastModifiedBy('Your Name')
//     ->setTitle('Leave Details')
//     ->setSubject('Leave Details')
//     ->setDescription('Leave details exported from the database')
//     ->setKeywords('leave details')
//     ->setCategory('Leave Details');

// // Add data to the Excel file
// $objPHPExcel->setActiveSheetIndex(0);
// $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Payee ID');
// $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Leave Count');
// $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Leave Type');
// $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Start Date');
// $objPHPExcel->getActiveSheet()->setCellValue('E1', 'End Date');
// $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Leave ID');
// $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Approved By');
// $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Notes');
// $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Approve Status');

// // Fetch data from the database
// // Replace with your database connection code
// $dbHost = 'localhost';
// $dbUsername = 'brandons_interlinkiq';
// $dbPassword = 'L1873@2019new';
// $dbName = 'brandons_interlinkiq';

// $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// $sql = "SELECT payeeid, leave_count, leave_type, start_date, end_date, leave_id, approved_by, notes, approve_status FROM leave_details";
// $result = mysqli_query($conn, $sql);

// $rowNumber = 2; // Start from row 2 to leave space for the header row

// if (mysqli_num_rows($result) > 0) {
//     while ($row = mysqli_fetch_assoc($result)) {
//         $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowNumber, $row['payeeid']);
//         $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowNumber, $row['leave_count']);
//         $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowNumber, $row['leave_type']);
//         $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowNumber, $row['start_date']);
//         $objPHPExcel->getActiveSheet()->setCellValue('E' . $rowNumber, $row['end_date']);
//         $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowNumber, $row['leave_id']);
//         $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowNumber, $row['approved_by']);
//         $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowNumber, $row['notes']);
//         $objPHPExcel->getActiveSheet()->setCellValue('I' . $rowNumber, $row['approve_status']);

//         $rowNumber++;
//     }
// }

// // Set column widths
// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
// $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
// $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
// $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
// $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
// $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
// $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

// // Set header row styles
// $headerStyle = $objPHPExcel->getActiveSheet()->getStyle('A1:I1');
// $headerStyle->getFont()->setBold(true);
// $headerStyle->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
// $headerStyle->getFill()->getStartColor()->setARGB('FFC0C0C0'); // Light Gray

// // Save Excel file
// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $filename = 'leave_details.xlsx';
// $objWriter->save($filename);

// // Download the Excel file
// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment;filename="' . $filename . '"');
// header('Cache-Control: max-age=0');
// ob_end_clean();
// $objWriter->save('php://output');
// exit();


$data = array( 
    array("NAME" => "John Doe", "EMAIL" => "john.doe@gmail.com", "GENDER" => "Male", "COUNTRY" => "United States"), 
    array("NAME" => "Gary Riley", "EMAIL" => "gary@hotmail.com", "GENDER" => "Male", "COUNTRY" => "United Kingdom"), 
    array("NAME" => "Edward Siu", "EMAIL" => "siu.edward@gmail.com", "GENDER" => "Male", "COUNTRY" => "Switzerland"), 
    array("NAME" => "Betty Simons", "EMAIL" => "simons@example.com", "GENDER" => "Female", "COUNTRY" => "Australia"), 
    array("NAME" => "Frances Lieberman", "EMAIL" => "lieberman@gmail.com", "GENDER" => "Female", "COUNTRY" => "United Kingdom") 
);
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}
// Excel file name for download 
$fileName = "codexworld_export_data-" . date('Ymd') . ".xlsx"; 
 
// Headers for download 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
header("Content-Type: application/vnd.ms-excel"); 
 
$flag = false; 
foreach($data as $row) { 
    if(!$flag) { 
        // display column names as first row 
        echo implode("\t", array_keys($row)) . "\n"; 
        $flag = true; 
    } 
    // filter data 
    array_walk($row, 'filterData'); 
    echo implode("\t", array_values($row)) . "\n"; 
} 
 
exit;

?>
