<style>
.checkFileUpload {
    display: flex;
    width: 100%;
    gap: 2rem;
}

.checkFileUpload .input-group {
    flex: 1 0 auto;
}

.frfUplDoc .row {
    display: none;
    margin-bottom: 20px;
}

.frfUplDoc:has(input:checked) .row {
    display: block;
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

<table class="table table-bordered table-hover" id="tableFSVPQI">
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
        <form class="modal-content" role="form" id="fsvpqiRegForm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">FSVPQI Register Form</h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="fsvpqiSelect">Select FSVQI</label>
                            <select name="fsvpqi" id="fsvpqiSelect" class="form-control">
                                <option value="" selected disabled>Select FSVPQI</option>
                            </select>
                            <small class="help-block" id="fsvpqiSelectHelpBlock"></small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Course / Education / Seminars </label>
                            <textarea name="" id="" class="form-control" placeholder="Course / Education / Seminars"></textarea>
                        </div>
                    </div>
                </div>
                <h5 class="margin-bottom-20"><strong>**Certifications</strong></h5>
                <div class="row">
                    <div class="col-md-12 frfUplDoc">
                        <label class="mt-checkbox mt-checkbox-outline">
                            <input type="checkbox" value="true" name="c_pcqi_certified"> PCQI Certified
                            <span></span>
                        </label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Upload document</label>
                                    <input type="file" class="form-control" name="c_pcqi_certified-file">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Document date</label>
                                    <input type="date" name="c_pcqi_certified-document_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Expiration date</label>
                                    <input type="date" name="c_pcqi_certified-expiration_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Comment</label>
                                    <input type="text" name="c_pcqi_certified-note" class="form-control" placeholder="(Optional)" data-note>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 frfUplDoc">
                        <label class="mt-checkbox mt-checkbox-outline">
                            <input type="checkbox" value="true" name="c_food_quality_auditing"> Food Quality Auditing
                            <span></span>
                        </label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Upload document</label>
                                    <input type="file" class="form-control" name="c_food_quality_auditing-file">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Document date</label>
                                    <input type="date" name="c_food_quality_auditing-document_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Expiration date</label>
                                    <input type="date" name="c_food_quality_auditing-expiration_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Comment</label>
                                    <input type="text" name="c_food_quality_auditing-note" class="form-control" placeholder="(Optional)" data-note>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 frfUplDoc">
                        <label class="mt-checkbox mt-checkbox-outline">
                            <input type="checkbox" value="true" name="c_haccp_training"> HACCP Training
                            <span></span>
                        </label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Upload document</label>
                                    <input type="file" class="form-control" name="c_haccp_training-file">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Document date</label>
                                    <input type="date" name="c_haccp_training-document_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Expiration date</label>
                                    <input type="date" name="c_haccp_training-expiration_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Comment</label>
                                    <input type="text" name="c_haccp_training-note" class="form-control" placeholder="(Optional)" data-note>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 frfUplDoc">
                        <label class="mt-checkbox mt-checkbox-outline">
                            <input type="checkbox" value="true" name="c_fs_training_certificate"> Food Safety Training Certificate
                            <span></span>
                        </label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Upload document</label>
                                    <input type="file" class="form-control" name="c_fs_training_certificate-file">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Document date</label>
                                    <input type="date" name="c_fs_training_certificate-document_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Expiration date</label>
                                    <input type="date" name="c_fs_training_certificate-expiration_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Comment</label>
                                    <input type="text" name="c_fs_training_certificate-note" class="form-control" placeholder="(Optional)" data-note>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 frfUplDoc">
                        <label class="mt-checkbox mt-checkbox-outline">
                            <input type="checkbox" value="true" name="c_gfsi_certificate"> GFSI Certificate
                            <span></span>
                        </label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Upload document</label>
                                    <input type="file" class="form-control" name="c_gfsi_certificate-file">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Document date</label>
                                    <input type="date" name="c_gfsi_certificate-document_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Expiration date</label>
                                    <input type="date" name="c_gfsi_certificate-expiration_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Comment</label>
                                    <input type="text" name="c_gfsi_certificate-note" class="form-control" placeholder="(Optional)" data-note>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green saveSigns-btn">Submit </button>
            </div>
        </form>
    </div>
</div>

<script defer src="modules/fsvp/js/fsvpqi.js"></script>