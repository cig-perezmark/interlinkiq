<?php
  include("connection.php");
  $query = "SELECT * FROM products ORDER BY productAddedTime DESC";
  $result = mysqli_query($con, $query);
?>