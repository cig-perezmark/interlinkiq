<div id="formulation_tab" class="tab-pane fade">   
   <div class="row">
      <div class="col-lg-6">
         <h3 class=product_title>Formulation</h3> - <a onclick="myfunction(<?= $switch_user_id; ?>)" href="https://interlinkiq.com/e-forms/Welcome/index/<?= $switch_user_id ?>/<?= $_COOKIE['ID'] ?>/gmp_formula/add_records/<?= $row['PK_id'] ?>" target="_blank" class="btn green btn-outline">Add Records</a>
      </div>
   </div>
   <div class="row mt12">
      <div class="col-12">
         <div class="panel panel-default">
            <div class="panel-body">
                <table class="main_table table table-bordered">
                     <thead>
                        <tr>
        					<th>Formula No.</th>
        					<th>Formula Name</th>
        					<th>Formula Description</th>
        					<th>Formula for</th>
        					<th>Status</th>
        					<th>Date and Time</th>
        					<th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $formulas_query = "SELECT * FROM tbl_formula WHERE owner_id = {$switch_user_id}";
                            $formulas = mysqli_query($e_connection,$formulas_query);
                            if (!empty($formulas)): foreach ($formulas as $formula): 
                        ?>
                            <tr>
                                <td><?php echo $formula['number']; ?></td>
                                <td><?php echo $formula['name']; ?></td>
        						<td><?php echo $formula['description']; ?></td>
                                <td><?php echo $formula['formulated_for']; ?></td>
                                <td><?php echo $formula['status']; ?></td>
                                <td><?php echo $formula['date_time']; ?></td>
                                <td>
                                    <a href="https://interlinkiq.com/e-forms/Consultare_records/Consultare/gmp_formula/details?id=<?= $formula['PK_id'] ?>"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
                </div>
         </div> 
      </div>
   </div>   
</div>

<script>
    function myfunction(id, enterpriseLogo) {
        const d = new Date();
        d.setTime(d.getTime() + (1 * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = `enterprise_logo=${enterpriseLogo}; user_company_id=${id};  ${expires}; path=/`;
        document.cookie = `user_company_id=${id}; ${expires}; path=/`;
    }
</script>