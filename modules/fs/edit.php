<?php
include_once __DIR__ . '/../../header.php';
include_once __DIR__ . '/init.php';
?>
<link href="assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/jquery-notific8/jquery.notific8.min.css" rel="stylesheet" type="text/css" />
<link href="assets/apps/css/todo-2.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="modules/haccp/style.css">

<script>
    window.HACCPDIAGRAM = <?= json_encode($diagram); ?>;
    var planBuilder = <?= json_encode($planBuiderResource); ?>;
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
                        Edit HACCP Plan
                    </span>
                </div>
                <div style="display: flex; justify-content: end; gap:1rem;">
                    <a href="haccp?pdf=<?= hash('md5', $haccp->id) ?>" class="btn btn-outline black btn-circlex" style="border:none;" target="_blank">
                        <i class="fa fa-file-pdf-o" style="margin-right: .75rem;"></i> View PDF
                    </a>
                    <?php $status = $haccpResource['status'];
                    if ($session == 'allowed'): ?>
                        <?php if ($status == 'Approved by Client' || $status == 'Reviewed by Client') { ?>
                            <a href="#modal-saveHaccpChanges" style="margin-right: 1rem;" data-toggle="modal" class="btn red">
                                <i class="fa fa-save" style="margin-right:.75rem"></i>
                                Create new version
                            </a>
                        <?php } else /* if($status != 'Approved by CIG') */ { ?>
                            <a href="#modal-saveHaccpChanges" style="margin-right: 1rem;" data-toggle="modal" class="btn blue-chambray">
                                <i class="fa fa-save" style="margin-right:.75rem"></i>
                                Save changes
                            </a>
                        <?php } ?>
                    <?php elseif ($session != null): ?>
                        <a href="#modal-saveHaccpChanges" style="margin-right: 1rem;" data-toggle="modal" class="btn blue">
                            <i class="fa fa-angle-double-right"></i>
                            Proceed to next step
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="portlet-body">
                <?php include __DIR__ . '/builder.php'; ?>

                <!-- used for initializing diagram element -->
                <div class="jsf-container" style="height: 700px; border-top: 1px solid #ccc; background-color: #f4f6f782;">
                    <svg id="jsfdiagram"></svg>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- start of modals -->
<div class="modal fade in" id="modal-saveHaccpChanges" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <?php $status = $resource('status');
                if ($status == 'Reviewed by Client' || $status == 'Approved by Client'): ?>
                    <h4 class="modal-title">Create a new version from this document</h4>
                <?php elseif ($status == 'Approved by CIG'): ?>
                    <h4 class="modal-title">Update this document</h4>
                <?php else: ?>
                    <h4 class="modal-title">Indicate how you want to proceed with the document:</h4>
                <?php endif; ?>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="saveHACCPForm" role="form">
                    <?php if ($session != 'allowed'): /* haccp is restricted access */ ?>
                        <input type="hidden" name="session" value="<?= $session ?>">
                    <?php endif; ?>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-12 control-label" style="text-align: start;">Add description (optional)</label>
                            <div class="col-md-12">
                                <textarea class="form-control" name="change_description" rows="3" placeholder="Describe your update..."></textarea>
                            </div>
                        </div>
                        <?php if ($status == 'Approved by CIG'): ?>
                            <input type="hidden" class="hide" name="save_as" value="post_approval_change" />
                        <?php endif; ?>
                        <?php if ($status != 'Reviewed by Client' && $status != 'Approved by Client' && $status != 'Approved by CIG'): ?>
                            <label>Select an action:</label>
                        <?php endif; ?>
                        <?php if ($status == 'Draft' || $status == 'For Revision'): ?>
                            <label class="save-status-choice">
                                <input type="radio" class="hide" name="save_as" value="draft" checked />
                                <i class="fa fa-file-text-o" style="font-size: 3rem;"></i>
                                <div>Save as draft <br> <small class="text-muted">Continue drafting the HACCP Plan</small></div>
                            </label>
                            <label class="save-status-choice">
                                <input type="radio" class="hide" name="save_as" value="submit_for_review" />
                                <i class="fa fa-search" style="font-size: 3rem; align-self:start; line-height:normal!important;"></i>
                                <div style="flex-grow:1;">Submit for review <br> <small class="text-muted">Assign a reviewer to review and finalize the document for the next stage</small>
                                    <div class="margin-top-20 bg-white hidden-container" style="padding:2rem;">
                                        <div class="form-group" style="margin-bottom:0!important;">
                                            <label class="col-md-4 control-label">Select a reviewer</label>
                                            <div class="col-md-8">
                                                <div class="select-container">
                                                    <select name="reviewer" class="form-control mt-multiselect btn btn-default" data-internal>
                                                        <option value="" selected disabled>--Select--</option>
                                                        <?php foreach ($cigEmployees as $e) {
                                                            echo "<option value='{$e['ID']}'>{$e['name']}</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="hide select-container">
                                                    <select class="form-control mt-multiselect btn btn-default" data-haccp>
                                                        <option value="" selected disabled>--Select--</option>
                                                        <?php foreach ($employees as $e) {
                                                            echo "<option value='{$e['ID']}'>{$e['name']}</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="mt-radio-inline">
                                                    <label class="mt-radio mt-radio-outline">
                                                        <input type="radio" name="assignee_pool" value="internal" checked onchange="selectAssignee(this)"> Internal <span></span>
                                                    </label>
                                                    <label class="mt-radio mt-radio-outline">
                                                        <input type="radio" name="assignee_pool" value="haccp" onchange="selectAssignee(this)"> HACCP Team <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="session_id" value="<?php echo $haccpSession['validation_id'] ?? 0; ?>" />
                            </label>
                        <?php elseif ($status == 'For Review'): ?>
                            <label class="save-status-choice">
                                <input type="radio" class="hide" name="save_as" value="accept_review" checked />
                                <i class="fa fa-thumbs-o-up" style="font-size: 3rem; align-self:start; line-height:normal!important;"></i>
                                <div style="flex-grow:1;">Accept <br> <small class="text-muted">Assign an approver, proceed to the next stage</small>
                                    <div class="margin-top-20 bg-white hidden-container" style="padding:2rem;">
                                        <div class="form-group" style="margin-bottom:0!important;">
                                            <label class="col-md-4 control-label">Select an approver</label>
                                            <div class="col-md-8">
                                                <div class="select-container">
                                                    <select name="approver" class="form-control mt-multiselect btn btn-default" data-internal>
                                                        <option value="" selected disabled>--Select--</option>
                                                        <?php foreach ($cigEmployees as $e) {
                                                            echo "<option value='{$e['ID']}'>{$e['name']}</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="hide select-container">
                                                    <select class="form-control mt-multiselect btn btn-default" data-haccp>
                                                        <option value="" selected disabled>--Select--</option>
                                                        <?php foreach ($employees as $e) {
                                                            echo "<option value='{$e['ID']}'>{$e['name']}</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="mt-radio-inline">
                                                    <label class="mt-radio mt-radio-outline">
                                                        <input type="radio" name="assignee_pool" value="internal" checked onchange="selectAssignee(this)"> Internal <span></span>
                                                    </label>
                                                    <label class="mt-radio mt-radio-outline">
                                                        <input type="radio" name="assignee_pool" value="haccp" onchange="selectAssignee(this)"> HACCP Team <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            <label class="save-status-choice">
                                <input type="radio" class="hide" name="save_as" value="reject_review" />
                                <i class="fa fa-close" style="font-size: 3rem; align-self:start; line-height:normal!important;"></i>
                                <div style="flex-grow:1;">Reject document<br> <small class="text-muted">Return for revision</small>
                                    <div class="margin-top-20 bg-white hidden-container" style="padding:2rem;">
                                        <div class="form-group" style="margin-bottom:0!important;">
                                            <label class="col-md-12 control-label" style="text-align: start;">Comment</label>
                                            <div class="col-md-12">
                                                <textarea class="form-control" name="comment" rows="3" placeholder="Add comment for revision..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        <?php elseif ($status == 'For Approval'): ?>
                            <label class="save-status-choice">
                                <input type="radio" class="hide" name="save_as" value="accept_approval" checked />
                                <i class="fa fa-thumbs-o-up" style="font-size: 3rem;"></i>
                                <div>Approve document <br> <small class="text-muted">Approve this HACCP Plan</small></div>
                            </label>
                            <label class="save-status-choice">
                                <input type="radio" class="hide" name="save_as" value="reject_approval" />
                                <i class="fa fa-close" style="font-size: 3rem; align-self:start; line-height:normal!important;"></i>
                                <div style="flex-grow:1;">Reject document<br> <small class="text-muted">Return to reviewer</small>
                                    <div class="margin-top-20 bg-white hidden-container" style="padding:2rem;">
                                        <div class="form-group" style="margin-bottom:0!important;">
                                            <label class="col-md-12 control-label" style="text-align: start;">Comment</label>
                                            <div class="col-md-12">
                                                <textarea class="form-control" name="comment" rows="3" placeholder="Add comment to the reviewer..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            <label class="save-status-choice">
                                <input type="radio" class="hide" name="save_as" value="assign_drafter" />
                                <i class="fa fa-user" style="font-size: 3rem; align-self:start; line-height:normal!important;"></i>
                                <div style="flex-grow:1;">Reassign to drafter <br> <small class="text-muted">For thorough examination and enhancement</small>
                                    <div class="margin-top-20 bg-white hidden-container" style="padding:2rem;">
                                        <div class="form-group" style="margin-bottom:0!important;">
                                            <label class="col-md-4 control-label">Select a drafter</label>
                                            <div class="col-md-8">
                                                <div class="select-container">
                                                    <select name="drafter" class="form-control mt-multiselect btn btn-default" data-internal>
                                                        <option value="" selected disabled>--Select--</option>
                                                        <?php foreach ($cigEmployees as $e) {
                                                            echo "<option value='{$e['ID']}'>{$e['name']}</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="hide select-container">
                                                    <select class="form-control mt-multiselect btn btn-default" data-haccp>
                                                        <option value="" selected disabled>--Select--</option>
                                                        <?php foreach ($employees as $e) {
                                                            echo "<option value='{$e['ID']}'>{$e['name']}</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="mt-radio-inline">
                                                    <label class="mt-radio mt-radio-outline">
                                                        <input type="radio" name="assignee_pool" value="internal" checked onchange="selectAssignee(this)"> Internal <span></span>
                                                    </label>
                                                    <label class="mt-radio mt-radio-outline">
                                                        <input type="radio" name="assignee_pool" value="haccp" onchange="selectAssignee(this)"> HACCP Team <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        <?php endif; ?>
                    </div>
                    <input type="submit" id="submitSaveHACCPFormBtn" class="hide">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="button" onclick="$('#submitSaveHACCPFormBtn').click()" class="btn green saveVersion-btn">Proceed</button>
            </div>
        </div>
    </div>
</div>
<!-- end of modals -->

<?php include __DIR__ . '/footer.php'; ?>

<script>
    getAllTasks();
    fetchVersionLogs();
</script>