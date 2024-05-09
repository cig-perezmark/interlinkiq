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
</style>

<div class="d-flex margin-bottom-20" style="justify-content: end;">
    <a href="#modalNewSupplier" data-toggle="modal" class="btn green">
        <i class="fa fa-plus"></i>
        New
    </a>
</div>

<table class="table table-bordered table-hover" id="tableSupplierList">
    <thead>
        <tr>
            <th>Supplier Name</th>
            <th>Food Imported</th>
            <th style="width: 220px;">Address</th>
            <th style="width: 100px">Evaluation Date</th>
            <th style="max-width: 80px">Supplier Agreement</th>
            <th style="max-width: 80px;">FSVP Compliance Statement</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<!-- modal -->
<div class="modal fade in" id="modalEvaluationForm" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Foreign Supplier Evaluation Form</h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="effsname">Foreign Supplier Name</label>
                            <input type="text" class="form-control bg-white" id="effsname" placeholder="Enter foreign supplier name" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="effsaddress">Address</label>
                            <input type="text" class="form-control bg-white" id="effsaddress" placeholder="Enter supplier address" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Importer Name</label>
                            <input type="text" class="form-control" placeholder="Enter importer name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Address</label>
                            <input type="text" class="form-control" placeholder="Enter importer address">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="" id="" class="form-control" placeholder="Enter description"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Evaluation</label>
                            <textarea name="" id="" class="form-control" placeholder="Enter evaluation"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Evaluation Date</label>
                            <input type="date" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Evaluation Due Date</label>
                            <input type="date" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <h5>
                            <strong>Evaluation Consideration and Results</strong>
                            <button type="button" class="btn blue-madison btn-xs" title="Add row(s)">
                                <i class="fa fa-plus"></i>
                            </button>
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-align-top fsvp-table">
                                <thead>
                                    <tr>
                                        <th>Supplier's Procedures, Practices, and Processes</th>
                                        <th>Import Alerts</th>
                                        <th>Recalls</th>
                                        <th>Warning Letters</th>
                                        <th>Other Signigicant Compliance Action</th>
                                        <th>Supplier's Corrective Actions</th>
                                        <th>Information related to the Safety of the Food</th>
                                        <th>Rejection Date</th>
                                        <th>Approval Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="form-group margin-top-15">
                            <label for="">Assessment of FSVP Evaluation</label>
                            <textarea name="" id="" class="form-control" placeholder="Assessment of Results of Foreign Supplier Evaluation"></textarea>
                            <span class="help-block">
                                Note: If the evaluation was performed by another entity (other than the foreign supplier) include Entity's name, address, email, and date of evaluation.
                            </span>
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

<div class="modal fade in" id="modalNewSupplier" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" role="form" id="newSupplierForm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">New Supplier Form</h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-12 margin-bottom-20">
                        <div class="form-group">
                            <label for="findSupplierDd">Find supplier </label>
                            <select name="supplier" id="findSupplierDd" class="supplierdd">
                                <option value="" selected disabled>Select supplier name</option>
                                <?php
                                    $suppliers = getSuppliersByUser($conn, $switch_user_id);
                                    foreach($suppliers as $supplier) {
                                        echo '<option value="'.$supplier['id'].'">'.$supplier['name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 margin-bottom-20">
                        <div>
                            <strong>Food imported:</strong>
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
                                    <div class="fileArrayDates">Note</div>
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
                                    <div class="fileArrayDates">Note</div>
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
                                    <button type="button" class="btn btn-sm default btn-circle" id="vfUpdateBtn">
                                        <i class="fa fa-edit icon-margin-right font-blue"></i>
                                        Update
                                    </button>
                                    <button type="button" class="btn btn-sm default text-danger btn-circle" id="vfRemoveBtn">
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

<script defer src="modules/fsvp/js/supplierlist.js"></script>