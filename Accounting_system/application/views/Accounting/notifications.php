<div class="mobile-menu-overlay"></div>

	<div class="main-container">
	
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	<!-- Simple Datatable start -->
	<div class="card-box mb-30">
						
					<div class="pd-20 d-flex">
					    <div class="col-md-4">
					        <h4 class="text-blue h4">Consultare - Pay Period</h4>
					    </div>
						<div class="col-md-4"></div>
						<div class="col-md-4"><button class="btn btn-primary"  data-toggle="modal" data-target="#bd-example-modal-lg1" style="position:absolute;right:4%">Start Process</button></div>
					</div>
					<div class="pb-20">
						<table class="table stripe hover nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">Full Name</th>
									<th>Updated</th>
									<th  class="datatable-nosort">Action</th>
								</tr>
							</thead>
							<tbody>
							    <?php
							        $notification = $this->Interlink_model->query("SELECT n.* FROM others_notification AS n INNER JOIN ( SELECT employee_id, MAX(id) AS max_id FROM others_notification WHERE notification_message != ''  GROUP BY employee_id ) AS max_ids ON n.id = max_ids.max_id ORDER BY n.id DESC");
							        if($notification):
							        foreach($notification as $row):
							                $font = '';
							                $employee_id = $row['employee_id'];
							                if($this->session->userdata('fullname') == 'Accounting Department'){
							                   $is_read = $row['is_read']; 
							                }
							                if($this->session->userdata('fullname') == 'Dahino, Cristina'){
							                   $is_read = $row['user_1']; 
							                }
							                if($this->session->userdata('fullname') == 'Pena, Christine Joy'){
							                   $is_read = $row['user_2']; 
							                }
							                if($is_read == 0){
							                   $font = "bold";
							                }
							                $notification_message = $row['notification_message'];
							                $updated_date = $row['updated_date']; 
							                $data = $this->Interlink_model->query("SELECT * FROM tbl_hr_employee WHERE ID = '$employee_id' AND status = 1 ");
							                if($data):
							    ?>
							        <tr>
							            <td>
							                <p class="font-weight-<?= $font ?>"><?= $data[0]['first_name'] ?> <?= " " ?><?= $data[0]['last_name'] ?><?= $is_read ?> </p>
							            </td>
							            <td><p>Hi, <?= $data[0]['first_name'] ?> <?= " " ?><?= $data[0]['last_name'] ?> updated his/her <?= $notification_message ?> <br> <span style="font-size:9px">On <?= $updated_date ?></span></p></td>
							            <td><a href="<?php echo site_url('Pages/bank_comparison/'.$employee_id); ?>">View</a></td>
							        </tr>
							    <?php
								     endif;endforeach; endif;
								?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->
				</div>
			</div>
