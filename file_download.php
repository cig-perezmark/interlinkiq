<?php
$filename = 'corogiedor.jpg'; // Specify the filename or path to the file

// Set the appropriate headers
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Provide the file's URL
$file_url = 'http://interlinkiq.com/' . $filename;

// Output the anchor tag
echo '<a href="' . $file_url . '">Download File</a>';
?>