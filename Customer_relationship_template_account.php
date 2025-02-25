<?php
  header("Content-type: text/csv; charset=utf-8");
  header("Content-Disposition: attachment; filename=Mass Upload Template.csv");
  $output = fopen("php://output", "w");
  fputcsv($output, array('Company Name', 'Contact Number', 'Email', 'Fax', 'Product/s', 'Address', 'State', 'Zip Code', 'Country', 'Source/Tag', 'Website'));
?>
