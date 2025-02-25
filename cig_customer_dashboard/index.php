<style>
.donut-legend {
    display: flex;
    align-items: center;
    justify-content: space-evenly;
    gap: 1rem;
    margin-top: 2rem;
}

.donut-legend>span {
    display: inline-flex;
    align-items: center;
    font-weight: bold;
}

.donut-legend>span>span {
    display: inline-block;
    width: 2rem;
    height: 1.25rem;
    margin-right: 1rem;
}
</style>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-jungle">
                        <span data-counter="counterup" data-value="<?php echo $dashboardAccounts['paid'] ?>">0</span>
                    </h3>
                    <small>PAID SUBSCRIBERS</small>
                </div>
                <div class="icon">
                    <i class="icon-check"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="status">
                    <div class="status-title"> Storage Usage </div>
                    <div class="status-number"> <span data-counter="counterup" data-value="<?php echo formatSize($dashboardStorage['paid']); ?>">0</span> <?php echo formatSizeUnits($dashboardStorage['paid']); ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green">
                        <span data-counter="counterup" data-value="<?php echo $dashboardAccounts['demo'] ?>">0</span>
                    </h3>
                    <small>DEMO ACCOUNTS</small>
                </div>
                <div class="icon">
                    <i class="icon-graph"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="status">
                    <div class="status-title"> Storage Usage </div>
                    <div class="status-number"> <span data-counter="counterup" data-value="<?php echo formatSize($dashboardStorage['demo']); ?>">0</span> <?php echo formatSizeUnits($dashboardStorage['demo']); ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-yellow-saffron">
                        <span data-counter="counterup" data-value="<?php echo $dashboardAccounts['free'] ?>">0</span>
                    </h3>
                    <small>FREE ACCESS</small>
                </div>
                <div class="icon">
                    <i class="icon-tag"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="status">
                    <div class="status-title"> Storage Usage </div>
                    <div class="status-number"> <span data-counter="counterup" data-value="<?php echo formatSize($dashboardStorage['free']); ?>">0</span> <?php echo formatSizeUnits($dashboardStorage['free']); ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span data-counter="counterup" data-value="<?php echo $totalAccounts ?>">0</span>
                    </h3>
                    <small>OVERALL TOTAL ACCOUNTS</small>
                </div>
                <div class="icon">
                    <i class="icon-user-following"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="status">
                    <div class="status-title"> Overall Total Storage </div>
                    <div class="status-number"> <span data-counter="counterup" data-value="<?php echo formatSize($totalStorage); ?>">0</span> <?php echo formatSizeUnits($totalStorage); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="portlet light portlet-fit ">
            <div class="portlet-body">
                <div class="row">

                    <div class="col-md-6">
                        <h5><strong>Enterprise Account Registration</strong></h5>
                        <div style="padding: 0rem;">
                            <div id="ear_donut"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Storage Usage</strong></h5>
                        <div style="padding: 0;">
                            <div id="su_donut"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="donut-legend">
                            <span><span style="background-color: #389848;"></span>Subscriber</span>
                            <span><span style="background-color: #00CCCC;"></span>Demo Account</span>
                            <span><span style="background-color: #E4DC11;"></span>Free Access</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="portlet light portlet-fit ">
            <div class="portlet-body">
                <h5><strong>Monthly Growth Report</strong></h5>
                <select class="form-control mt-multiselect" onchange="selectUser(this)">
                    <option value="0">All</option>
                    <?php
                        $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE employee_id  = 0 ORDER BY first_name");
                        if ( mysqli_num_rows($selectUser) > 0 ) {
                            while($rowUser = mysqli_fetch_array($selectUser)) {
                                $user_ID = $rowUser["ID"];
                                $user_name = $rowUser["first_name"] .' '. $rowUser["last_name"];

                                echo '<option value="'.$user_ID.'">'.$user_name.'</option>';
                            }
                        }
                    ?>
                </select>
                <figure class="highcharts-figure" style="margin-top: 6px;">
                    <div id="mgr_ear"></div>
                </figure>
            </div>
        </div>
    </div>
</div>
