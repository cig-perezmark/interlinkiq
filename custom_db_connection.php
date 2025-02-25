<?php
    $servername = 'localhost';
    $username = 'brandons_interlinkiq';
    $password = 'iz8gbjBQqhcy~+WNSj';
    $dbname = "brandons_interlinkiq";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    if (!$conn) {
        die('Could not connect to MySQL: ' . mysqli_connect_error());
    }
    
    mysqli_set_charset($conn, 'utf8mb4');
