<?php
    include "database.php";
    
    
    // Get the from and to dates from the form submission
    $fromDate = $_POST['fromDate'];
    $toDate = $_POST['toDate'];
    
    // Prepare and execute your database query
    $sql = "SELECT * FROM leave_details INNER JOIN tbl_user ON tbl_user.ID = leave_details.payeeid INNER JOIN leave_types ON leave_types.leave_id = leave_details.leave_id  WHERE end_date BETWEEN '$fromDate' AND '$toDate'";
    $result = $conn->query($sql);
    
    // Set the headers for Excel file download
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="export.xls"');
    header('Cache-Control: max-age=0');
    
    // Create the Excel file
    $output = fopen('php://output', 'w');
    
    // Write the column headers
    fputcsv($output, ['Payee ID', 'Leave Type' ,'Start Date', 'End Date'], "\t");
    
    // Fetch and write the data from the database
    if ($result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
            fputcsv($output, [$data['first_name'].' '.$data['last_name'] , $data['leave_name'], $data['start_date'], $data['end_date']], "\t");
        }
    }
    
    // Close the file handle
    fclose($output);
    
    // Close the database connection
    $conn->close();

?>