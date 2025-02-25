<?php
    $servername = 'localhost';
    $username = 'brandons_apps';
    $password = 'interlinkapps2022';
    $database = 'brandons_payroll_demo';
    
    $payroll_conn = mysqli_connect($servername, $username, $password, $database);
    
    if (!$payroll_conn) {
        die('Could not connect to MySQL: ' . mysqli_connect_error());
    }
