<?php
  header("Content-type: text/csv; charset=utf-8");
  header("Content-Disposition: attachment; filename=Internal Audit Template.csv");
  $output = fopen("php://output", "w");
  fputcsv($output, array('Department','Area','Descriptions','Account'));
?>
