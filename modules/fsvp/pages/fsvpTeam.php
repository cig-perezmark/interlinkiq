<style>
[data-avatar] {
    width: 100%;
    height: auto;
    object-fit: cover;
    object-position: center;
    border: 1px solid #ddd;
}

.fsvp-trmt {
    display: flex;
    align-items: center;
    justify-content: center;
}


#tableFSVPTeamRoster .fsvp-trmt input[type=radio],
#tableFSVPTeamRoster.for-display .fsvp-trmt i {
    display: inline-block;
}

#tableFSVPTeamRoster.for-display .fsvp-trmt input[type=radio],
#tableFSVPTeamRoster .fsvp-trmt i {
    display: none;
}

#tableFSVPTeamRoster.for-display .fsvp-trmt i.fa {
    display: none;
}

#tableFSVPTeamRoster.for-display .fsvp-trmt:has(input:checked) i.fa {
    display: inline;
}
</style>

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

<table class="table table-bordered table-hover for-display" id="tableFSVPTeamRoster">
    <thead>
        <tr>
            <th>Name</th>
            <th>Title / Position</th>
            <th>Phone </th>
            <th>Email</th>
            <th class="text-center" style="width: 75px;">Primary</th>
            <th class="text-center" style="width: 75px;">Alternate</th>
            <th>Actions</th>
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
        <form class="modal-content" role="form" id="newMemberForm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add member</h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="employeeSearchDd">Search employee</label>
                            <select name="employee" id="employeeSearchDd" class="form-control">
                                <option value="" selected disabled>Type employee name</option>
                            </select>
                        </div>
                    </div>
                    <h5 class="col-md-12 margin-bottom-20"><strong>Employee Details:</strong></h5>
                    <div class="col-md-3">
                        <img src="https://via.placeholder.com/100x100/EFEFEF/AAAAAA.png?text=no+image" alt="User" data-avatar>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group row">
                            <label class="col-form-label col-md-4">Name</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" data-name readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-4">Title / Position</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" data-title readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-4">Email Address</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" data-email readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-4">Phone</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" data-phone readonly>
                            </div>
                        </div>
                        <div class="form-group row margin-top-30">
                            <label class="col-form-label col-md-4 bold">Member Type?</label>
                            <div class="col-md-8">
                                <div class="mt-radio-list" style="padding: 0;">
                                    <label class="mt-radio not-this mt-radio-outline"> Primary
                                        <input type="radio" value="primary" name="member_type" checked>
                                        <span></span>
                                    </label>
                                    <label class="mt-radio not-this mt-radio-outline"> Alternate
                                        <input type="radio" value="alternate" name="member_type">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissable" id="modalNewMemberError" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Error!</strong> <span id="modalNewMemberErrorMessage"></span>
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