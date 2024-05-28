<?php 
include "../database.php";

if(isset($_POST["val"])) {  
  $get_id = $_POST["val"];
 $query = mysqli_query($conn,"select * from tblQuotation_sublinks where links_id = '$get_id'");
    foreach($query as $row){?>
      <tr class="data_pay<?= $row['links_id']; ?>">
          <td>
              <input type="hidden" value="<?= $row['links_id']; ?>" name="payment_ids[]">
              <?= $row['links_price']; ?>
            </td>
          <td><?= htmlspecialchars($row['links']);?></td>
      </tr>
   <?php } 
    }
?>
