<div class="main-container">
    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
        <!-- Bootstrap Select End -->
        <div class="row">
            <!-- Bootstrap Switchery Start -->
            <div class="col-md-6 col-sm-12 mb-30">
                <div class="pd-20 card-box height-100-p">
                    <div class="clearfix mb-30">
                        <div class="pull-left">
                            <h4 class="text-blue h4">New Data</h4>
                        </div>
                    </div>
                    <?php
                    $employee_id = $this->uri->segment(3);
                    $employee_old_details = $this->User_model->query("SELECT * FROM payee_old_details INNER JOIN bankname ON bankname.bankno = payee_old_details.bankno WHERE payeeid = '$employee_id'");
                    $employee_new_details = $this->User_model->query("SELECT * FROM payee INNER JOIN bankname ON bankname.bankno = payee.bankno WHERE payeeid = '$employee_id'");
                    $employee_old_other_details = $this->Interlink_model->query("SELECT * FROM others_employee_details_old WHERE employee_id = '$employee_id'");
                    $employee_new_other_details = $this->Interlink_model->query("SELECT * FROM others_employee_details WHERE employee_id = '$employee_id'");
                    ?>
                    <form>
                        <div class="mb-30">
                            <h5 class="h5">Account Name</h5>
                            <p <?php if($employee_old_details): ?> class="<?= $employee_new_details[0]['accountname'] != $employee_old_details[0]['accountname'] ? 'text-warning' : '' ?>" <?php endif; ?> >
                                <?= $employee_new_details[0]['accountname'] ?>
                            </p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Account Number</h5>
                            <p <?php if($employee_old_details): ?> class="<?= $employee_new_details[0]['accountno'] != $employee_old_details[0]['accountno'] ? 'text-warning' : '' ?>" <?php endif; ?>>
                                <?= $employee_new_details[0]['accountno'] ?>
                            </p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Account Name</h5>
                            <p <?php if($employee_old_details): ?> class="<?= $employee_new_details[0]['bankname'] != $employee_old_details[0]['bankname'] ? 'text-warning' : '' ?>" <?php endif; ?>>
                                <?= $employee_new_details[0]['bankname'] ?>
                            </p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Other Details</h5>
                            <hr>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Address</h5>
                                <p <?php if($employee_old_other_details): ?> class="<?= $employee_new_other_details[0]['address'] != $employee_old_other_details[0]['address'] ? 'text-warning' : '' ?>" <?php endif; ?>>
                                    <?= $employee_new_other_details[0]['address'] ?>
                                </p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Contact Number</h5>
                            <p <?php if($employee_old_other_details): ?> class="<?= $employee_new_other_details[0]['contact_no'] != $employee_old_other_details[0]['contact_no'] ? 'text-warning' : '' ?>" <?php endif; ?>>
                                <?= $employee_new_other_details[0]['contact_no'] ?>
                            </p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Personal Email</h5>
                            <p  <?php if($employee_old_other_details): ?> class="<?= $employee_new_other_details[0]['personal_email'] != $employee_old_other_details[0]['personal_email'] ? 'text-warning' : '' ?>" <?php endif; ?> >
                                <?= $employee_new_other_details[0]['personal_email'] ?>
                            </p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Comapany Email</h5>
                            <p <?php if($employee_old_other_details): ?> class="<?= $employee_new_other_details[0]['company_email'] != $employee_old_other_details[0]['company_email'] ? 'text-warning' : '' ?>" <?php endif; ?> >
                                <?= $employee_new_other_details[0]['company_email'] ?>
                            </p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Emergency Contact Details</h5>
                            <hr>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Name</h5>
                            <p  <?php if($employee_old_other_details): ?> class="<?= $employee_new_other_details[0]['emergency_name'] != $employee_old_other_details[0]['emergency_name'] ? 'text-warning' : '' ?>" <?php endif; ?> >
                                <?= $employee_new_other_details[0]['emergency_name'] ?>
                            </p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Number</h5>
                            <p <?php if($employee_old_other_details): ?> class="<?= $employee_new_other_details[0]['emergency_contact_no'] != $employee_old_other_details[0]['emergency_contact_no'] ? 'text-warning' : '' ?>" <?php endif; ?> >
                                <?= $employee_new_other_details[0]['emergency_contact_no'] ?>
                            </p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Address</h5>
                            <p <?php if($employee_old_other_details): ?> class="<?= $employee_new_other_details[0]['emergency_address'] != $employee_old_other_details[0]['emergency_address'] ? 'text-warning' : '' ?>" <?php endif; ?> >
                                <?= $employee_new_other_details[0]['emergency_address'] ?>
                            </p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Email</h5>
                            <p <?php if($employee_old_other_details): ?> class="<?= $employee_new_other_details[0]['emergency_email'] != $employee_old_other_details[0]['emergency_email'] ? 'text-warning' : '' ?>"  <?php endif; ?> >
                                <?= $employee_new_other_details[0]['emergency_email'] ?>
                            </p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Relation</h5>
                            <p <?php if($employee_old_other_details): ?> class="<?= $employee_new_other_details[0]['emergency_relation'] != $employee_old_other_details[0]['emergency_relation'] ? 'text-warning' : '' ?>" <?php endif; ?> >
                                <?= $employee_new_other_details[0]['emergency_relation'] ?>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Bootstrap Switchery End -->
            <!-- Bootstrap Tags Input Start -->
            <div class="col-md-6 col-sm-12 mb-30">
                <div class="pd-20 card-box height-100-p">
                    <div class="clearfix mb-30">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Old Data</h4>
                        </div>
                    </div>
                    <form>
                        <div class="mb-30">
                            <h5 class="h5">Account Name</h5>
                            <?php if($employee_old_details): ?>
                                <p><?= $employee_old_details[0]['accountname'] ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Account Number</h5>
                            <?php if($employee_old_details): ?>
                                <p><?= $employee_old_details[0]['accountno'] ?></p>
                            <?php endif ?>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Account Name</h5>
                            <?php if($employee_old_details): ?>
                                <p><?= $employee_old_details[0]['bankname'] ?></p>
                            <?php endif ?>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Other Details</h5>
                            <hr>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Address</h5>
                            <p>
                                <?php if($employee_old_other_details): ?>
                                    <?= $employee_old_other_details[0]['address'] ?>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Contact Number</h5>
                            <p><?php if($employee_old_other_details): ?><?= $employee_old_other_details[0]['contact_no'] ?><?php endif; ?></p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Personal Email</h5>
                            <p><?php if($employee_old_other_details): ?><?= $employee_old_other_details[0]['personal_email'] ?><?php endif; ?></p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Company Email</h5>
                            <p><?php if($employee_old_other_details): ?><?= $employee_old_other_details[0]['company_email'] ?><?php endif; ?></p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Emergency Contact Details</h5>
                            <hr>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Name</h5>
                            <p><?php if($employee_old_other_details): ?><?= $employee_old_other_details[0]['emergency_name'] ?><?php endif; ?></p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Number</h5>
                            <p><?php if($employee_old_other_details): ?><?= $employee_old_other_details[0]['emergency_contact_no'] ?><?php endif; ?></p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Address</h5>
                            <p><?php if($employee_old_other_details): ?><?= $employee_old_other_details[0]['emergency_address'] ?><?php endif; ?></p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Email</h5>
                            <p><?php if($employee_old_other_details): ?><?= $employee_old_other_details[0]['emergency_email'] ?><?php endif; ?></p>
                        </div>
                        <div class="mb-30">
                            <h5 class="h5">Relation</h5>
                            <p><?php if($employee_old_other_details): ?><?= $employee_old_other_details[0]['emergency_relation'] ?><?php endif; ?></p>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Bootstrap Tags Input End -->
        </div>
        <!-- Simple Datatable End -->
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="upload_invoice_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method='POST' action="<?php echo site_url('Pages/importFile'); ?>" enctype="multipart/form-data">
         <input type='file' name='file' >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type='submit'  class="btn btn-primary" value='Upload' name='upload' >
       </form>
      </div>
    </div>
  </div>
</div>
