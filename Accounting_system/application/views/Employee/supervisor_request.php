<div class="mobile-menu-overlay"></div>

<div class="main-container">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
<!-- Simple Datatable start -->
<div class="card-box mb-30">
                    
                <div class="pd-20 d-flex">
                    <h4>PTO Request</h4>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Full name</th>
                                <th class="table-plus datatable-nosort">Position</th>
                                <th>Leave Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Notes</th>
                                <th>Number of Leave</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($pto): foreach($pto as $row): ?>
                            <tr>
                                <td style="" id="payeeid"><?= $row->fullname?></td>
                                <td class="table-plus" id="fullname"><?= $row->position?></td>
                                <td><?= $row->leave_type ?></td>
                                <td><?= $row->start_date ?></td>
                                <td><?= $row->end_date ?></td>
                                <td><?= $row->notes ?></td>
                                <td class="table-plus" id="fullname"><?=$row->leave_count ?></td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="<?php echo site_url('Pages/update_pto/');?><?= $row->id ?><?="/"?><?= $row->payeeid ?><?="/"?><?="1"?>"><i class="icon-copy ion-checkmark-round"></i> Approve</a>
                               
                                        </div>
                                    </div>
                                </td>
                            </tr>
                           <?php  endforeach; endif?> 

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Simple Datatable End -->
            </div>
        </div>
