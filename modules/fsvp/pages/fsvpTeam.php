<div class="alert alert-danger">
    <strong>Important:</strong> The FSVP Team Roster needs verification.
</div>

<div class="d-flex margin-bottom-20" style="justify-content: space-between;">
    <a href="#modalAddMember" data-toggle="modal" class="btn green">
        <i class="fa fa-plus"></i>
        Member
    </a>
    <a href="#" class="btn btn-default">History</a>
</div>

<table class="table table-bordered table-hover" id="tableSupplierList">
    <thead>
        <tr>
            <th>Name</th>
            <th>Title / Position</th>
            <th>Phone </th>
            <th>Email</th>
            <th>Primary</th>
            <th>Alternate</th>
            <th data-nosort="true">Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<hr>
<div class="row">
    <div class="col-md-12">
        <h4>
            <strong>Verification</strong>
        </h4>
        <p class="text-mute hide">
            Note: When reviewing, please return the form within 24 hours to the Quality Specialist. “Yes” - means that the revision has been approved and is okay to implement, the effective date of approval. For “No”, please enter comments.
        </p>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Reviewed by:</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Approved by:</label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Comment(s):</label>
            <textarea name="" id="" class="form-control" placeholder="Add comment..."></textarea>
        </div>
    </div>
</div>

<!-- modal -->

<div class="modal fade in" id="modalAddMember" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" role="form" id="newSupplierForm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add member</h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Search employee</label>
                            <select name="" id="employeeSearchDd" class="form-control">
                                <option value="" selected disabled>Type employee name</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Submit </button>
            </div>
        </form>
    </div>
</div>

<script defer src="modules/fsvp/js/fsvpTeam.js"></script>