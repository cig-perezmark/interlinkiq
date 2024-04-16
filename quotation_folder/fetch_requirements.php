<?php 
include "../database.php";

if(isset($_POST["val"])) {  
  $get_id = $_POST["val"];
 $query = mysqli_query($conn,"select * from tblQuotation where quote_id = '$get_id'");
    foreach($query as $row){?>
      <tr class="data_<?= $row['quote_id']; ?>">
          <td>
              <input type="hidden" value="<?= $row['quote_id']; ?>" name="requirement_id[]">
              <?= $row['quote_name']; ?>
            </td>
          <td>$<?= number_format((float)$row['estimated_cost'], 2, '.', '');?></td>
      </tr>
   <?php } 
    }
?>
