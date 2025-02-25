<div class="mobile-menu-overlay"></div>

<div class="main-container">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
<!-- Simple Datatable start -->
<div class="card-box mb-30">
                    
                <div class="pd-20 d-flex">
                  
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Pay Id</th>
                                <th class="table-plus datatable-nosort">Amount</th>
                                <th>Paid Date</th>
                                <th>Reference No</th>
                                <th>Pay Source</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if($pay_list): ?>
                            <?php foreach($pay_list as $row): ?>
                            <tr>
                                <td style="" id="payeeid"><?=$row->payid?></td>
                                <td class="table-plus" id="fullname"><?="$"?><?=$row->amount ?></td>
                                <td><?= $row->paiddate ?></td>
                                 <td><?= $row->refno ?></td>
                                <td><?=$row->sourcename?></td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                               <a class="dropdown-item" href="<?php echo site_url('Pages/employee_pay_details/'.$row->sourcename.'/'.$row->paiddate.'/'.$row->refno.'');?>"><i class="dw dw-eye"></i> View/Pay</a>
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
