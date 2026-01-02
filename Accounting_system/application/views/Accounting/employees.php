<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
    	<div class="card-box mb-30">
    			<div class="pd-20 d-flex">
    				<h4 class="text-blue h4">Employee List </h4>
    				
    			</div>
    			<div class="pb-20">
    				<table class="data-table table stripe hover nowrap">
    					<thead>
    						<tr>
    							<th class="table-plus datatable-nosort">Name</th>
    							<th>Position</th>
    							<th>Pay Rate</th>
    							<th>Bank Name</th>
    							<th class="datatable-nosort">Action</th>
    							<th style="display:none">Net Pay</th>
    						</tr>
    					</thead>
    					<tbody>
    					    <?php foreach($employee_list as $row):
    					        $user_id = $row['ID'];
    					        $bank_name = "Not Set";
    					        $fetch_pay_table = $this->User_model->query("SELECT * FROM payee INNER JOIN bankname ON payee.bankno = bankname.bankno WHERE payee.payeeid = '$user_id' ");
    					        if($fetch_pay_table){
    					            $bank_name = $fetch_pay_table[0]['bankname'];
    					        }
    					    ?>
    					    <tr>
    					        <td><?= $row['last_name'] .", ".  $row['first_name'] ?></td>
    					        <td></td>
    					        <td></td>
    					        <td><?= $bank_name ?></td>
    					        <td>
    					            <div class="dropdown">
										<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
											<i class="dw dw-more"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
											<a class="dropdown-item" href="<?php echo site_url('Pages/employees_details/');?><?= $row['ID'] ?>"><i class="dw dw-eye"></i> View/set</a>
										</div>
									</div>
    					        </td>
    					    </tr>
    					    <?php  endforeach; ?>
    					</tbody>
    				</table>
    			</div>
    		</div>
    	</div>
	</div>
<script>
    $(document).ready(function() {
        
        var tbody = $('tbody');

        var rows = tbody.find('tr').get();
        rows.sort(function(a, b) {
            var keyA = $(a).find('td:first').text().toUpperCase();
            var keyB = $(b).find('td:first').text().toUpperCase();

            return keyA.localeCompare(keyB);
        });

        $.each(rows, function(index, row) {
            tbody.append(row);
        });
    });
</script>
