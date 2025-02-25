<style>
.supplierlist-check .mtCheckUploadFileLink {
    display: none;
}

.supplierlist-check:has(input[value="1"]:checked) .mtCheckUploadFileLink {
    display: block !important;
}

.fileArrayDates {
    width: 180px !important;
    flex-shrink: 0;
}

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

.semibold {
    font-weight: 600;
}

td,
th {
    white-space: normal !important;
}

.file-viewer {
    width: 100%;
    height: 28rem;
}

#viewFileInfoForm.is-update [data-view-info]:not([data-view-info="upload_date"]),
#viewFileInfoForm.is-update .vfbtns {
    display: none !important;
}

#viewFileInfoForm .form-control,
#viewFileInfoForm .vfupdt {
    display: none;
}

#viewFileInfoForm.is-update .form-control,
#viewFileInfoForm.is-update .vfupdt {
    display: block !important;
}

.border-none {
    border: none !important;
}

#modalEvaluationDetails .modal-body [class^="col-md-6"] {
    margin-bottom: 20px;
}

[data-ed] {
    height: auto;
}

.preview-grid {
    display: grid;
    grid-template-columns: 5fr 7fr;
    gap: 10px;
    /* Optional: adds space between the columns */
}

.preview-grid .file-preview {
    height: 100%;
    width: 100%;
}

.liFP:hover {
    text-decoration: underline;
}

.liFP {
    cursor: default;
}

.p-0 {
    padding: 0;
}

img.signature__.display {
    width: 100%;
    height: auto;
    object-fit: contain;
    object-position: center;
} 
</style>

<div class="d-flex margin-bottom-20" style="justify-content: end;" id="fstToolbar">
    <a href="javascript:void(0)" class="btn green" id="toggleEvaluationBtn" style="display: none;">
        <i class="fa fa-table icon-margin-right"></i>
        <span data-label>View Evaluations Data</span>
        <input type="checkbox" style="display: none;" id="viewEvaluationsCheck">
    </a>
</div>

<!-- <tr>
    <th>Supplier Name</th>
    <th style="width: 220px;">Address</th>
    <th>Food Imported</th>
    <th style="max-width: 140px">
        Evaluation Date <br>
        <small class="text-muted margin-top-10 font-grey-salsa" style="font-weight: normal;line-height: 98%;display: inline-block;">Click the date to view evaluation details.</small>
    </th>
    <th style="max-width: 80px">Supplier Agreement</th>
    <th style="max-width: 80px;">FSVP Compliance Statement</th>
</tr> -->

<table class="table table-bordered table-hover" id="tableSupplierList">
    <thead></thead>
    <tbody></tbody>
</table>

<!-- modal -->
<div class="modal fade in" id="modalEvaluationForm" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" role="form" id="evaluationForm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" data-efm="eval">Foreign Supplier Evaluation Form</h4>
                <h4 class="modal-title" data-efm="reeval">Re-Evaluation Form</h4>
            </div>
            <div class="modal-body form-body">
                <input type="hidden" name="eval">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="effsname">Foreign Supplier Name <i class="text-muted">(auto-filled)</i></label>
                            <input type="text" class="form-control bg-white" id="effsname" placeholder="Enter foreign supplier name" readonly>
                            <input type="hidden" name="supplier">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="effsaddress">Address <i class="text-muted">(auto-filled)</i></label>
                            <input type="text" class="form-control bg-white" id="effsaddress" placeholder="Enter supplier address" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reefimporter">Importer Name <i class="text-muted">(auto-filled)</i></label>
                            <input type="text" class="form-control bg-white" id="reefimporter" placeholder="Enter importer name" readonly>
                            <input type="hidden" name="importer">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Address <i class="text-muted">(auto-filled)</i></label>
                            <input type="text" id="efImporterAddress" class="form-control bg-white" placeholder="Select an importer to fill this field" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" data-efm="eval">
                            <label for="efDescription">Description</label>
                            <textarea name="description" id="efDescription" class="form-control" placeholder="Enter description"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" data-efm="eval">
                            <label for="efEvaluation">Evaluation</label>
                            <textarea name="evaluation" id="efEvaluation" class="form-control" placeholder="Enter evaluation"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <h5 data-efm="eval"><strong>**Evaluation Consideration and Results</strong></h5>
                        <h5 style="display: none;" data-efm="reeval">
                            <div class="display:flex;align-items:center;">
                                <strong>**Re-Evaluation</strong>
                                <a href="javascript:void(0)" class="btn btn-link btn-smx p-0" id="viewPreviousEvalBtn">[View Previous Evaluation]</a>
                            </div>
                        </h5>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="efSPPP">Suppliers Procedures, Practices, & Processes</label>
                            <textarea name="sppp" id="efSPPP" class="form-control" placeholder="Enter suppliers procedures, practices, & processes"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row ynDocsUpl">
                    <div class="col-md-3">
                        <div class="semibold"> Import Alerts </div>
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="import_alerts" value="1"> Yes
                                <span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="import_alerts" value="0"> No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Upload document</label>
                            <input type="file" class="form-control" name="import_alerts-file">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Document date</label>
                            <input type="date" name="import_alerts-document_date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Expiration date</label>
                            <input type="date" name="import_alerts-expiration_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row ynDocsUpl">
                    <div class="col-md-3">
                        <div class="semibold"> Recalls </div>
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="recalls" value="1"> Yes
                                <span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="recalls" value="0"> No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Upload document</label>
                            <input type="file" class="form-control" name="recalls-file">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Document date</label>
                            <input type="date" name="recalls-document_date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Expiration date</label>
                            <input type="date" name="recalls-expiration_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row ynDocsUpl">
                    <div class="col-md-3">
                        <div class="semibold"> Warning Letters </div>
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="warning_letters" value="1"> Yes
                                <span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="warning_letters" value="0"> No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Upload document</label>
                            <input type="file" class="form-control" name="warning_letters-file">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Document date</label>
                            <input type="date" name="warning_letters-document_date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Expiration date</label>
                            <input type="date" name="warning_letters-expiration_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row ynDocsUpl">
                    <div class="col-md-3">
                        <div class="semibold"> Other Significant Compliance Action </div>
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="other_sca" value="1"> Yes
                                <span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="other_sca" value="0"> No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row margin-top-20">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Upload document</label>
                                    <input type="file" class="form-control" name="other_sca-file">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Document date</label>
                                    <input type="date" name="other_sca-document_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Expiration date</label>
                                    <input type="date" name="other_sca-expiration_date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ynDocsUpl">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="semibold"> Supplier's Corrective Actions </div>
                                <div class="mt-radio-inline">
                                    <label class="mt-radio mt-radio-outline">
                                        <input type="radio" name="supplier_corrective_actions" value="1"> Yes
                                        <span></span>
                                    </label>
                                    <label class="mt-radio mt-radio-outline">
                                        <input type="radio" name="supplier_corrective_actions" value="0"> No
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <textarea name="supplier_corrective_actions-note" class="form-control margin-top-20 margin-bottom-10" placeholder="Enter supplier's corrective actions"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Upload supporting doc...</label>
                            <input type="file" class="form-control" name="supplier_corrective_actions-file">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Document date</label>
                            <input type="date" name="supplier_corrective_actions-document_date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Expiration date</label>
                            <input type="date" name="supplier_corrective_actions-expiration_date" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row" data-efm="eval">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="efInfo">Information related to the safety of the food</label>
                            <textarea name="info_related" id="efInfo" class="form-control" placeholder="Enter information related to the safety of the food"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="efRejectionDate">Rejection Date</label>
                            <input type="date" name="rejection_date" id="efRejectionDate" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="efApprovalDate">Approval Date</label>
                            <input type="date" name="approval_date" id="efApprovalDate" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row" data-efm="eval">
                    <div class="col-md-12">
                        <div class="form-group margin-top-15x">
                            <label for="efAFE">Assessment of FSVP Evaluation</label>
                            <textarea name="assessment" id="efAFE" class="form-control" placeholder="Assessment of Results of Foreign Supplier Evaluation"></textarea>
                            <i class="help-block">
                                Note: If the evaluation was performed by another entity (other than the foreign supplier) include Entity's name, address, email, and date of evaluation.
                            </i>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="efEvalDate">Evaluation Date <span class="required">*</span></label>
                            <input type="date" name="evaluation_date" id="efEvalDate" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="efEvalDueDate">Evaluation Due Date <span class="required">*</span></label>
                            <input type="date" name="evaluation_due_date" id="efEvalDueDate" class="form-control" required>
                        </div>
                    </div>
                </div>

                <!-- reviewed bt -->
                <div class="row">
                    <div class="col-md-12"><strong>Reviewed By</strong></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="efReviewedBy">Name</label>
                            <input type="text" name="reviewed_by" id="efReviewedBy" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="efReviewDate">Date</label>
                            <input type="date" name="review_date" id="efReviewDate" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Signature</label>
                            <div id="reviewer_signature" class="signature__"></div>
                        </div>
                    </div>
                </div>

                <!-- approved by -->
                <div class="row">
                    <div class="col-md-12"><strong>Approved By</strong></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="efApprovedBy">Name</label>
                            <input type="text" name="approved_by" id="efApprovedBy" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="efApproveDate">Date</label>
                            <input type="date" name="approve_date" id="efApproveDate" class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Signature</label>
                            <div id="approver_signature" class="signature__"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="efComment">Comments</label>
                            <textarea name="comments" id="efComment" class="form-control" placeholder="Comments"></textarea>
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

<div class="modal fade in" id="modalNewSupplier" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" role="form" id="newSupplierForm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Supplier Form</h4>
            </div>
            <div class="modal-body form-body">
                <input type="hidden" name="fsvp_supplier_id">
                <div class="row">
                    <div class="col-md-12 margin-bottom-20">
                        <?php if(false): ?>
                        <div class="form-group">
                            <label for="findSupplierDd">Foreign Supplier <?= required() ?></label>
                            <select name="supplier" id="findSupplierDd" class="supplierdd">
                                <option value="" selected disabled>Search supplier name</option>
                                <?php
                                    $suppliers = getRawSuppliersByUser($conn, $switch_user_id);
                                    foreach($suppliers as $supplier) {
                                        echo '<option value="'.$supplier['id'].'">'.$supplier['name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label>Foreign Supplier</label>
                            <input type="text" class="form-control bg-white" id="fsName" readonly>
                            <input type="hidden" name="supplier">
                        </div>
                    </div>
                    <div class="col-md-12 margin-bottom-20">
                        <div>
                            <strong>Food/Product(s) imported:</strong>
                            <hr>
                            <p class="help-block" id="materialListHelpBlock">Please select a supplier first.</p>
                        </div>
                        <div class="mls-grid" id="materialListSelection"></div>
                    </div>
                </div>
                <div class="row margin-bottom-20 supplierlist-check">
                    <div class="col-md-12"> Supplier Agreement </div>
                    <div class="col-md-3">
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="supplier_agreement" value="1"> Yes
                                <span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="supplier_agreement" value="0"> No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mt-radio-inline">
                            <span class="mt-radio mt-radio-outline mtCheckUploadFileLink" style="padding-left: 0;">
                                <a href="javascript:void(0)" onclick="$('#assa').click()"> <i class="fa fa-upload"></i> Upload file(s) </a>
                                <input type="file" class="d-none asFileUpload" data-name="supplier_agreement" id="assa" multiple>
                            </span>
                        </div>
                        <div class="mtCheckUploadFileLink">
                            <hr>
                            <div class="filesArrayDisplay">
                                <div class="fileArrayItem">
                                    <span class="fileArrayName">File Name</span>
                                    <div class="fileArrayDates">Document Date</div>
                                    <div class="fileArrayDates">Expiration Date</div>
                                    <div class="fileArrayDates">Comment</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row margin-bottom-20 supplierlist-check">
                    <div class="col-md-12"> FSVP Compliance Statement </div>
                    <div class="col-md-3">
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="compliance_statement" value="1"> Yes
                                <span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="compliance_statement" value="0"> No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mt-radio-inline">
                            <span class="mt-radio mt-radio-outline mtCheckUploadFileLink" style="padding-left: 0;">
                                <a href="javascript:void(0)" onclick="$('#ascsf').click()"> <i class="fa fa-upload"></i> Upload file </a>
                                <input type="file" class="d-none asFileUpload" data-name="compliance_statement" id="ascsf">
                            </span>
                        </div>
                        <div class="mtCheckUploadFileLink">
                            <hr>
                            <div class="filesArrayDisplay">
                                <div class="fileArrayItem">
                                    <span class="fileArrayName">File Name</span>
                                    <div class="fileArrayDates">Document Date</div>
                                    <div class="fileArrayDates">Expiration Date</div>
                                    <div class="fileArrayDates">Comment</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger alert-dismissable" id="modalNewSupplierError" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Error!</strong> <span id="modalNewSupplierMessage"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Submit </button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade in" id="modalViewFiles" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Viewing: <span id="viewFileTitle"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <p><strong>File list:</strong></p>
                        <div class="mt-element-list">
                            <div class="mt-list-container list-simple ext-1">
                                <ul id="viewFileList"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5" style="border-left: 1px solid #eee">
                        <p><strong>Preview</strong></p>
                        <iframe src="about:blank" frameborder="0" class="file-viewer"></iframe>
                    </div>
                    <div class="col-md-12" style="margin: 1rem 0 2rem 0;">
                        <hr>
                    </div>
                </div>
                <form class="row" role="form" id="viewFileInfoForm">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2 bold">File</label>
                            <div class="col-md-7">
                                <span data-view-info="filename"></span>
                                <input type="file" name="file" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2 bold">Document date</label>
                            <div class="col-md-7">
                                <span data-view-info="document_date"></span>
                                <input type="date" name="document_date" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2 bold">Expiration date</label>
                            <div class="col-md-7">
                                <span data-view-info="expiration_date"></span>
                                <input type="date" name="expiration_date" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2 bold">Note</label>
                            <div class="col-md-7">
                                <span data-view-info="note"></span>
                                <textarea name="note" class="form-control" placeholder="Add note (optional)"></textarea>
                            </div>
                        </div>
                        <div class="form-group row" data-view-info>
                            <label class="col-form-label col-md-2 bold">Upload date</label>
                            <div class="col-md-8">
                                <span data-view-info="upload_date"></span>
                            </div>
                        </div>
                        <div class="row margin-bottom-20">
                            <div class="col-md-2"></div>
                            <div class="col-md-8 vfbtns">
                                <div style="display:flex;gap:.75rem;">
                                    <a href="javascript:void(0)" data-fancybox data-src="" data-type="iframe" class="btn btn-sm btn-circle default view-anchor">
                                        <i class="fa fa-external-link icon-margin-right"></i>
                                        View file
                                    </a>
                                    <button type="button" class="btn btn-sm default btn-circle hide" id="vfUpdateBtn">
                                        <i class="fa fa-edit icon-margin-right font-blue"></i>
                                        Update
                                    </button>
                                    <button type="button" class="btn btn-sm default text-danger btn-circle hide" id="vfRemoveBtn">
                                        <i class="fa fa-close icon-margin-right font-red"></i>
                                        Remove
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-8 vfupdt">
                                <div style="display:flex;gap:.75rem;">
                                    <button type="button" class="btn btn-sm default btn-circle">
                                        <i class="fa fa-check icon-margin-right font-green"></i>
                                        Save changes
                                    </button>
                                    <button type="button" class="btn btn-sm default text-danger btn-circle" id="vfCancelBtn">
                                        <i class="fa fa-close icon-margin-right"></i>
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="modalEvaluationDetails" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Evaluation Details <span class="label label-danger" id="edStatus"> current </span></h4>
            </div>
            <div class="modal-body">
                <div class="row margin-bottom-20">
                    <div class="col-md-2 semibold">IMPORTER NAME:</div>
                    <div class="col-md-4">
                        <div class="form-control grey-steel" data-ed="importer"> </div>
                    </div>
                    <div class="col-md-2 semibold">DATE:</div>
                    <div class="col-md-4">
                        <div class="form-control grey-steel" data-ed="date">Importer</div>
                    </div>
                </div>
                <div class="row margin-bottom-20">
                    <div class="col-md-2 semibold">Foreign Supplier Name:</div>
                    <div class="col-md-4">
                        <div class="form-control grey-steel" data-ed="supplier"> </div>
                    </div>
                    <div class="col-md-2 semibold">Foreign Supplier Address:</div>
                    <div class="col-md-4">
                        <div class="form-control grey-steel" data-ed="supplier_address"> </div>
                    </div>
                </div>
                <div class="row margin-bottom-20">
                    <div class="col-md-2 semibold">Food Product(s) Imported:</div>
                    <div class="col-md-4">
                        <div class="form-control grey-steel" data-ed="food_products"></div>
                    </div>
                    <div class="col-md-2 semibold">Food Product(s) Description(s), including Important Food Safety Characteristics:</div>
                    <div class="col-md-4">
                        <div class="form-control grey-steel" data-ed="food_products_description"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 margin-bottom-10">
                        <strong>Evaluation Considerations and Results</strong>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Supplier's Procedures, Practices, and Processes</th>
                                    <th>Import Alerts</th>
                                    <th>Recalls</th>
                                    <th>Warning Letters</th>
                                    <th style="width: 10rem;">Other Significant Compliance Action</th>
                                    <th style="width: 10rem;">Supplier's Corrective Actions</th>
                                    <th>Informmation related to the safety of the food</th>
                                    <th>Rejection Date</th>
                                    <th>Approval Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-ed="spp"></td>
                                    <td data-ed="import_alerts"></td>
                                    <td data-ed="recalls"></td>
                                    <td data-ed="warning_letters"></td>
                                    <td data-ed="osca"></td>
                                    <td data-ed="suppliers_ca"></td>
                                    <td data-ed="info_related"></td>
                                    <td data-ed="rejection_date"></td>
                                    <td data-ed="approval_date"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="evalFilePreviewPanel" class="col-md-12 margin-bottom-20 bg-grey-cararra-opacity" style="padding-top:10px; padding-bottom:10px; display: none;">
                        <div>
                            <i class="bold"><span id="evalFilename"></span> - Preview</i>
                            <a href="javascript:void(0)" class="btn btn-link btn-sm" id="evalFilePreviewClose">[Close]</a>
                        </div>
                        <div class="preview-grid">
                            <!-- style="border-right: 1px solid grey; padding-right: 10px;" -->
                            <div>
                                <table class="table">
                                    <tr>
                                        <th style="width: 8rem;">Filename</th>
                                        <td data-evalfile="filename">filename.txt</td>
                                    </tr>
                                    <tr>
                                        <th>Document Date</th>
                                        <td data-evalfile="document_date">filename.txt</td>
                                    </tr>
                                    <tr>
                                        <th>Expiration Date</th>
                                        <td data-evalfile="due_date">filename.txt</td>
                                    </tr>
                                    <tr class="evalFileCommentRow" style="display: none;">
                                        <th>Comment</th>
                                        <td data-evalfile="note">filename.txt</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <a href="javascript:void(0)" data-fancybox data-src="" data-type="iframe" id="evalFileIframeAnchor">View file</a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div>
                                <iframe src="about:blank" frameborder="0" class="file-preview" id="evalFileIframe"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Assessment of Results of Foreign Supplier Evaluation</label>
                            <div class="form-control" style="min-height: 7rem;" data-ed="assessment"></div>
                        </div>
                    </div>
                </div>

                <!-- reviewed by -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Reviewed By</label>
                            <div data-ed="reviewed_by" class="form-control"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Date</label>
                            <div data-ed="review_date" class="form-control"></div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Signature</label> <br>
                            <img src="#" id="reviewer_signature_display" class="signature__ display" />
                        </div>
                    </div>
                </div>

                <!-- approval -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Approved By</label>
                            <div data-ed="approved_by" class="form-control"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Date</label>
                            <div data-ed="approve_date"  class="form-control"></div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Signature</label> <br>
                            <img src="#" id="approver_signature_display" class="signature__ display" />
                        </div>
                    </div>
                </div>

                <!-- comment -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Comments</label>
                            <div data-ed="comments" class="form-control"></div>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <a href="about:blank" target="_blank" class="btn blue" id="pdfEvaluationForm">
                    <!-- <i class="fa fa-pdf-o"></i> -->
                    View PDF
                </a>
            </div>
        </div>
    </div>
</div>

<script defer src="modules/fsvp/js/supplierlist.js"></script>
