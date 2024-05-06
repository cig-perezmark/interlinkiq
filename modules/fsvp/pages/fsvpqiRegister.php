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
        <form class="modal-content" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">FSVPQI Register Form</h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="fsvpqiSelect">Select </label>
                            <select name="" id="fsvpqiSelect" class="form-control">
                                <option value="" selected disabled>Select FSVPQI</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-7">
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
                            <input type="checkbox"> PCQI Certified
                            <span></span>
                        </label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Upload document</label>
                                    <input type="file" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Document date</label>
                                    <input type="date" name="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Expiration date</label>
                                    <input type="date" name="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Comment</label>
                                    <input type="text" name="" id="" class="form-control" placeholder="(Optional)">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 frfUplDoc">
                        <label class="mt-checkbox mt-checkbox-outline">
                            <input type="checkbox"> Food Quality Auditing
                            <span></span>
                        </label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Upload document</label>
                                    <input type="file" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Document date</label>
                                    <input type="date" name="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Expiration date</label>
                                    <input type="date" name="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Comment</label>
                                    <input type="text" name="" id="" class="form-control" placeholder="(Optional)">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 frfUplDoc">
                        <label class="mt-checkbox mt-checkbox-outline">
                            <input type="checkbox"> HACCP Training
                            <span></span>
                        </label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Upload document</label>
                                    <input type="file" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Document date</label>
                                    <input type="date" name="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Expiration date</label>
                                    <input type="date" name="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Comment</label>
                                    <input type="text" name="" id="" class="form-control" placeholder="(Optional)">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 frfUplDoc">
                        <label class="mt-checkbox mt-checkbox-outline">
                            <input type="checkbox"> Food Safety Training Certificate
                            <span></span>
                        </label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Upload document</label>
                                    <input type="file" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Document date</label>
                                    <input type="date" name="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Expiration date</label>
                                    <input type="date" name="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Comment</label>
                                    <input type="text" name="" id="" class="form-control" placeholder="(Optional)">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 frfUplDoc">
                        <label class="mt-checkbox mt-checkbox-outline">
                            <input type="checkbox"> GFSI Certificate
                            <span></span>
                        </label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Upload document</label>
                                    <input type="file" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Document date</label>
                                    <input type="date" name="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Expiration date</label>
                                    <input type="date" name="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Comment</label>
                                    <input type="text" name="" id="" class="form-control" placeholder="(Optional)">
                                </div>
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

<script defer src="modules/fsvp/js/fsvpqi.js"></script>