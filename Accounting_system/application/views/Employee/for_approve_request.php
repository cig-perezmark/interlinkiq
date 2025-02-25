<div class="mobile-menu-overlay"></div>

<div class="main-container">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
<!-- Simple Datatable start -->
<div class="card-box mb-30">
                    
                <div class="pd-20 d-flex">
                    <!--<h4>Pay List - Status: <label style="color:basdlue"><?= $status?></label></h4>-->
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Previous Pay</th>
                                <th>Request Pay</th>
                                <th>Submitted By</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        <?php if($for_approval): ?>
                            <?php foreach($for_approval as $row):
                                $payee_id = $row['payeeid'];
                                $employee_user = $this->Interlink_model->query("SELECT * FROM tbl_user WHERE employee_id = '$payee_id'"); 
                            ?>
                            <tr>
                                <td><?= $employee_user[0]['first_name'] .' '. $employee_user[0]['last_name'] ?></td>
                                <td><?= $row['old_data'] ?></td>
                                <td><?= $row['new_data'] ?></td>
                                <td><?= $row['submitted_by'] ?></td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="<?php echo site_url('Pages/update_request/');?><?= $row['new_data'] ?><?="/" ?><?= $row['PK_id'] ?>"><i class="dw dw-check"></i>Approve</a>
                                            <a class="dropdown-item" href="<?php echo site_url('Pages/update_request_delete/');?><?= $row['new_data'] ?><?="/" ?><?= $row['PK_id'] ?>"><i class="dw dw-close"></i>Disapprove</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; endif;  ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Simple Datatable End -->
            </div>
        </div>
