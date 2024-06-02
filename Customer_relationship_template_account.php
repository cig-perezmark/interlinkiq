<?php
  header("Content-type: text/csv; charset=utf-8");
  header("Content-Disposition: attachment; filename=Accounts.csv");
  $output = fopen("php://output", "w");
  fputcsv($output, array('Account Name','Email','Phone','Source'));
?>
