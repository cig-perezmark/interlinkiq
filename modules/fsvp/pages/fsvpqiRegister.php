<style>
.checkFileUpload {
    display: flex;
    width: 100%;
    gap: 2rem;
}

.checkFileUpload .input-group {
    flex: 1 0 auto;
}
</style>

<?php 

function yesNoRadio() {
    echo '<div class="mt-radio-list" style="padding: 0;">
        <label class="mt-radio mt-radio-outline">
            <input type="radio" name="optionsRadios" id="optionsRadios25" value="option1" checked=""> Yes
            <span></span>
        </label>
        <label class="mt-radio mt-radio-outline">
            <input type="radio" name="optionsRadios" id="optionsRadios26" value="option2" checked=""> No
            <span></span>
        </label>
    </div>';
}
?>

<div class="d-flex margin-bottom-20" style="justify-content: end;">
    <a href="#modalFSVPQIReg" data-toggle="modal" class="btn green">
        <i class="fa fa-plus"></i>
        New
    </a>
</div>

<table class="table table-bordered table-hover" id="tableSupplierList">
    <thead>
        <tr>
            <th>Name</th>
            <th>Course / Education / Seminars </th>
            <th>PCQI Certified</th>
            <th>Food Quality Auditing</th>
            <th>HACCP Training</th>
            <th>Food Safety Training Certificate</th>
            <th>GFSI Certificate</th>
            <th data-nosort="true">Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<!-- modal -->
<div class="modal fade in" id="modalFSVPQIReg" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">FSVPQI Register Form</h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Select </label>
                            <select name="" id="" class="form-control"></select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Position </label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Course / Education / Seminars </label>
                            <textarea name="" id="" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="help-block">Note: Upload necessary document(s) if applicable.</div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="">PCQI Certified </label>
                            <div class="checkFileUpload">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox">
                                        <span></span>
                                    </span>
                                    <input type="file" class="form-control">
                                </div>
                                <button class="btn btn-danger">
                                    <i class="fa fa-close"></i> Remove
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Food Quality Auditing </label>
                            <div class="checkFileUpload">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox">
                                        <span></span>
                                    </span>
                                    <input type="file" class="form-control">
                                </div>
                                <button class="btn btn-danger">
                                    <i class="fa fa-close"></i> Remove
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">HACCP Training </label>
                            <div class="checkFileUpload">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox">
                                        <span></span>
                                    </span>
                                    <input type="file" class="form-control">
                                </div>
                                <button class="btn btn-danger">
                                    <i class="fa fa-close"></i> Remove
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Food Safety Training Certificate </label>
                            <div class="checkFileUpload">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox">
                                        <span></span>
                                    </span>
                                    <input type="file" class="form-control">
                                </div>
                                <button class="btn btn-danger">
                                    <i class="fa fa-close"></i> Remove
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">GFSI Certificate </label>
                            <div class="checkFileUpload">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox">
                                        <span></span>
                                    </span>
                                    <input type="file" class="form-control">
                                </div>
                                <button class="btn btn-danger">
                                    <i class="fa fa-close"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="button" class="btn green saveSigns-btn">Submit </button>
            </div>
        </form>
    </div>
</div>