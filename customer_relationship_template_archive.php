<?php
    header("Content-type: text/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=Archive_template.csv");
    $output = fopen("php://output", "w");
    fputcsv($output, array('Email'));
