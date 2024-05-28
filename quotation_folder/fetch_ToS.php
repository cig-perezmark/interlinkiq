<?php 
include "../database.php";

if(isset($_POST["val"])) {  
  $get_id = $_POST["val"];
    $query = mysqli_query($conn,"select * from tblQuotation_TOS where tos_id = '$get_id'");
    foreach($query as $row){?>
      <tr class="data_tblterms<?= $row['tos_id']; ?>">
          <td>
              <input type="hidden" value="<?= $row['tos_id']; ?>" name="tos_id[]">
              <?= $row['tos_name']; ?>
            </td>
          <td><?= htmlspecialchars($row['tos_description']);?></td>
      </tr>
   <?php } 
    }
?>
