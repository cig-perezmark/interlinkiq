<?php
    include_once __DIR__ . '/../../header.php';
    include_once __DIR__ . '/init.php';
?>
<link href="assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/jquery-notific8/jquery.notific8.min.css" rel="stylesheet" type="text/css" />
<link href="assets/apps/css/todo-2.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="modules/haccp/style.css">

<script>
var planBuilder = {
    processes: {},
    products: []
}
window.setCCPToDiagram = null;
window.ProcessSteps = {};
window.CCPs = {};
window.DataSet4HACCP = {};
window.getJSFDiagram = null;
</script>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-folder font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">
                        HACCP Plan
                    </span>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#overview" data-toggle="tab">Summary</a></li>
                    <li><a href="#haccp_team" data-toggle="tab">HACCP Team</a></li>
                    <li><a href="#haccp_builder" data-toggle="tab">Plan Builder</a></li>
                </ul>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="overview">
                        <div class="table-responsivex">
                            <table class="table table-bordered table-hoverx order-column table-v-middle" id="haccp-overview_table">
                                <thead>
                                    <tr>
                                        <th style="width: 35%;"> HACCP Plan(s) </th>
                                        <th style="width: 7%;"> Status </th>
                                        <th style="width: 20%;"> History </th>
                                        <th style="width: 17%;"> Task </th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach($haccps as $h) {
                                            $res = $h->getResource();
                                            $logs = $h->getLogs($portal_user)[0] ?? [];
                                            $task = $h->getAllTasks();
                                            $task = $task[count($task) - 1] ?? [];
                                    ?>
                                    <tr>
                                        <td>
                                            <div style="padding: .75rem 0;"><?= $res['description'] ?></div>
                                            <div class="d-flex-center">
                                                <div style="margin-right: 1rem;" class="mul-container">
                                                    <?php 
                                                        $pp = $res['products']; 
                                                        if(count($pp)) { 
                                                            $pIQs = '(' .implode(',', $pp). ')'; 
                                                            $productImages = $conn->query("SELECT image FROM tbl_products WHERE ID in $pIQs"); 
                                                            $piCount = 0; 
                                                            while($pr = $productImages->fetch_assoc()) { 
                                                                if(++$piCount <= 4) { 
                                                                    $img = explode(',', $pr['image'])[0]; 
                                                                    $img = empty($img) ? null : '//interlinkiq.com/uploads/products/' . $img; 
                                                                    $img = !empty($img) ? $img : "https://via.placeholder.com/200x200/EFEFEF/AAAAAA.png?text=No+Image"; 
                                                                    echo '<img class="img-circle user-pic mul-preview" src="'.$img.'">'; 
                                                                } 
                                                            } 
                                                            if($piCount > 4) 
                                                                echo '<div class="mul-preview end"><span>+'.($piCount - 4).'</span></div>'; 
                                                        } 
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                                $color = match($res['status']) {
                                                    'For Review' => 'warning',
                                                    'For Approval' => 'info',
                                                    'Approved by CIG' => 'primary',
                                                    'Approved by Client' => 'success',
                                                    default => 'danger',
                                                };
                                            ?>
                                            <span class="label label-sm label-<?= $color ?>"> <?= $res['status'] ?> </span>
                                        </td>
                                        <td>
                                            <div class="mt-list-item" title="<?= $logs['category'] ?>">
                                                <div class="list-item-content" style="padding-left: 0; font-weight:600;"><?php $s = substr($logs['description'], 0, 32); echo $s . (strlen($logs['description']) > 32 ? '...' : ''); ?></div>
                                                <div class="list-datetime uppercasex small text-muted" style="padding-left: 0;margin-top:.2rem;">
                                                    <?= $logs['user'] ?> updated <span title="<?= $logs['datetime'] ?>"><?= $logs['time_elapsed'] ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if(count($task)): ?>
                                            <div class="mt-list-item" title="<?= $logs['category'] ?>">
                                                <div class="list-item-content" style="padding-left: 0; font-weight:600;"><?php $s = substr($task['title'], 0, 32); echo $s . (strlen($task['title']) > 32 ? '...' : ''); ?></div>
                                                <div class="list-item-content small" style="padding-left: 0; font-weight:500;"><?php $s = substr($task['description'], 0, 32); echo $s . (strlen($task['description']) > 32 ? '...' : ''); ?></div>
                                                <div class="list-datetime uppercasex small text-muted" style="padding-left: 0;margin-top:.2rem;">
                                                    <?= $task['assignee_name'] ?? '(No assignee)' ?> | <span><?= $task['due_date'] ?? '(No due date)' ?></span>
                                                </div>
                                            </div>
                                            <?php else: ?>
                                            <span class="italic text-muted">No task has been added.</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-circle" style="position: initial; margin-top: 0;">
                                                <a href="<?= $pageUrl . '?edit='. hash('md5', $res['id']) ?>" class="btn btn-outline dark btn-sm" title="Open in builder">Open</a>
                                                <?php if($res['status'] == 'Approved by CIG'): ?>
                                                <a href="javascript:void(0)" onclick="openClientSignatures(this, <?= $res['id'] ?>)" class="btn btn-outlinex green btn-sm" title="Update signatures">Sign</a>
                                                <?php endif; ?>
                                                <a href="haccp?pdf=<?= hash('md5', $h->id) ?>" target="_blank" class="btn blue btn-sm">PDF</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="haccp_builder" style="min-height: 100vh;">
                        <?php include __DIR__ . '/builder.php'; ?>
                    </div>
                    <div class="tab-pane" id="haccp_team">
                        <div class="d-flex-center-between">
                            <h4><strong>The HACCP Team</strong></h4>
                            <a href="#modal-haccpTeamModal" data-toggle="modal" class="btn blue">
                                <i class="fa fa-user"></i> Add member
                            </a>
                        </div>
                        <section class="margin-top-20">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover t-v-mid" id="haccp-teamTable">
                                    <thead>
                                        <tr class="bg-grey-cararra">
                                            <th colspan="3" style="width: 43%; text-align:center!important;"> Primary Member </th>
                                            <th colspan="3" style="width: 43%; text-align:center!important;"> Alternate Member </th>
                                            <th rowspan="2" style="width: 14%; text-align:center!important;"> Actions </th>
                                        </tr>
                                        <tr class="bg-grey-cararra">
                                            <th style="width: 14%; text-align:center!important;"> Department </th>
                                            <th style="width: 14%; text-align:center!important;"> Position Title </th>
                                            <th style="width: 15%; text-align:center!important;"> Name </th>
                                            <th style="width: 14%; text-align:center!important;"> Department </th>
                                            <th style="width: 14%; text-align:center!important;"> Position Title </th>
                                            <th style="width: 15%; text-align:center!important;"> Name </th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </section>
                        <hr class="margin-top-20">
                        <div class="d-flex-center-between" style="margin-top:3rem;">
                            <h4><strong>Organizational Chart</strong></h4>
                            <div>
                                <button type="button" id="uploadOrgChartBtn" title="JPEG/JPG/PNG only" onclick="$('#orgChartFileUpload').click()" class="btn blue">
                                    <i class="fa fa-file-image-o"></i> Upload
                                </button>
                                <button type="button" id="removeOrgChartBtn" title="Remove" onclick="removeOrganizationalChart()" class="btn red">
                                    <i class="fa fa-close"></i> Delete chart
                                </button>
                            </div>
                        </div>
                        <input class="hide" type="file" accept=".jpg, .jpeg, .png" id="orgChartFileUpload" />
                        <section class="margin-top-20" style="padding: 2rem;" id="orgChartDisplay">
                            <div class="text-center image-container">
                                <img style="max-width: 100%; height: auto; margin:0 auto; object-fit: contain; object-position: center;" src="<?= $organizationalChart ?? '#' ?>" alt="Organization Chart" />
                            </div>
                            <div class="no-display">
                                <h5 class="font-gray" style="padding: 3rem 0;">No chart has been uploaded yet.</h5>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- used for initializing diagram element -->
                <div class="jsf-container" style="height: 700px; border-top: 1px solid #ccc; background-color: #f4f6f782;">
                    <svg id="jsfdiagram"></svg>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- start of modals -->
<div class="modal fade in" id="modal-haccpTeamModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add member</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="haccp-teamForm" role="form">
                    <div class="form-body">
                        <h5><strong>Primary Member</strong></h5>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <label for="haccp-team-postitle1">
                                    Title <span class="required">*</span>
                                </label>
                                <input type="text" name="primary_title" id="haccp-team-postitle1" class="form-control" placeholder="Enter new title">
                            </div>
                            <div class="col-md-5">
                                <label><br></label>
                                <select name="primary_member" id="haccp-team-primary_member" class="form-control haccp-multiselect haccp-team-select primary">
                                    <option value="" selected disabled>--Select--</option>
                                    <?php foreach($employees as $e) { echo '<option value="'.$e['ID'].'">'.$e['name'].'</option>'; } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label style="color: rgba(0,0,0,0%)">*</label>
                                <button type="button" class="btn btn-danger btn-reset-haccp-team" data-reset="primary">Reset</button>
                            </div>
                        </div>
                        <h5><strong>Alternate Member</strong></h5>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <label for="haccp-team-postitle2">
                                    Title <span class="required">*</span>
                                </label>
                                <input type="text" name="alternate_title" id="haccp-team-postitle2" class="form-control" placeholder="Enter new title">
                            </div>
                            <div class="col-md-5">
                                <label><br></label>
                                <select name="alternate_member" id="haccp-team-alternate_member" class="form-control haccp-multiselect haccp-team-select alternate">
                                    <option value="" selected disabled>--Select--</option>
                                    <?php foreach($employees as $e) { echo '<option value="'.$e['ID'].'">'.$e['name'].'</option>'; } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label style="color: rgba(0,0,0,0%)">*</label>
                                <button type="button" class="btn btn-danger btn-reset-haccp-team" data-reset="alternate">Reset</button>
                            </div>
                        </div>
                        <input type="submit" class="hide">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="button" onclick="$('#haccp-teamForm [type=submit]').click()" class="btn green" id="proxyteamformsubmit">
                    Submit </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade in" id="modal-clientUpdates" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Update</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="haccp-clientUpdatesForm" role="form">
                    <input type="hidden" name="updateClientSigns" />
                    <div class="form-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Assigned</th>
                                    <th style="width: 280px;">Name</th>
                                    <th style="width: 320px;">Signature & Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="upd-develop hide">
                                    <td style="text-align:center; vertical-align: middle;"><strong>Developed by</strong></td>
                                    <td><input type="text" class="upd-developer form-control" readonly /></td>
                                    <td>
                                        <div class="upd-esign" data-name="developer_sign"></div>
                                    </td>
                                </tr>
                                <tr class="upd-review">
                                    <td style="text-align:center; vertical-align: middle;"><strong>Reviewed by</strong></td>
                                    <td>
                                        <div class="">
                                            <select name="reviewer_id" class="form-control haccp-multiselect upd-reviewer">
                                                <option value="" selected disabled>Select reviewer</option>
                                                <?php foreach($employees as $e) { echo '<option value="'.$e['ID'].'">'.$e['name'].'</option>'; } ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="upd-esign" data-name="reviewer_sign"></div>
                                        <input type="date" class="form-control" name="review_date" />
                                    </td>
                                </tr>
                                <tr class="upd-approve">
                                    <td style="text-align:center; vertical-align: middle;"><strong>Approved by</strong></td>
                                    <td>
                                        <div class="">
                                            <select name="approver_id" id="haccp-team-alternate_member" class="form-control haccp-multiselect upd-approver">
                                                <option value="" selected disabled>Select approver</option>
                                                <?php foreach($employees as $e) { echo '<option value="'.$e['ID'].'">'.$e['name'].'</option>'; } ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="upd-esign" data-name="approver_sign"></div>
                                        <input type="date" class="form-control" name="approve_date" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="submit" class="hide">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="button" onclick="$('#haccp-clientUpdatesForm [type=submit]').click()" class="btn green saveSigns-btn">Submit </button>
            </div>
        </div>
    </div>
</div>
<!-- end of modals -->

<?php include __DIR__ . '/footer.php'; ?>