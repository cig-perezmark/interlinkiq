<?php

// DB Connection 
$host = "localhost"; 
$username = "brandons_interlinkiq";   
$password = "iz8gbjBQqhcy~+WNSj"; // Change as needed  
$database = "brandons_interlinkiq";   

$conn = mysqli_connect($host, $username, $password, $database); 
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = 1211; 
$file_path = './uploads/supplier/';   
// $file_path = './uploads/';  
$file_zip_name = date('Y-m-d') . '_user_' . $user_id . '_supplier_regulatory.zip'; 
$file_names = array();  

// Avoid any output before headers
ob_clean(); 


$query = " 
    SELECT files 
    FROM tbl_supplier_regulatory
    WHERE deleted = 0
      AND user_id = $user_id
      AND filetype = 1
      AND files IS NOT NULL
      AND files != ''
"; 
// $query = " 
//     SELECT file as files
//     FROM tbl_supplier_template
//     WHERE user_id = $user_id
//       AND filetype = 1
//       AND file IS NOT NULL
//       AND file != ''
// ";


$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // $files = $row['files'];
        $files = $row['files']; 

        // If multiple files stored as comma-separated
        $individual_files = explode(',', $files);

        foreach ($individual_files as $file) {
            $trimmed_file = trim($file);
            if (!empty($trimmed_file)) {
                $file_names[] = $trimmed_file;
            }
        }
    }

    if (!empty($file_names)) {
        zipFilesAndDownload($file_names, $file_zip_name, $file_path);
    } else {
        die("No valid files found.");
    }
} else {
    die("No records found.");
}

function zipFilesAndDownload($file_names, $zip_file_name, $base_path)
{
    $zip = new ZipArchive();
    $tmp_file = tempnam(sys_get_temp_dir(), 'zip');

    if ($zip->open($tmp_file, ZipArchive::OVERWRITE) !== true) {
        die("Failed to create ZIP file.");
    }

    foreach ($file_names as $file) {
        $file_full_path = rtrim($base_path, '/') . '/' . $file;
        if (file_exists($file_full_path)) {
            $zip->addFile($file_full_path, basename($file));
        }
    }

    $zip->close();

    // Send ZIP file headers
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $zip_file_name . '"');
    header('Content-Length: ' . filesize($tmp_file));
    readfile($tmp_file);
    unlink($tmp_file);
    exit;
}