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

<div class="d-flex margin-bottom-20 tab-toolbar" style="justify-content: end;">
    <div class="stat-loading"> <img src="assets/global/img/loading.gif" alt="loading"> </div>
    <a href="#modalActWorksheet" style="display: none;" data-toggle="modal" class="btn green" id="newAWBtn">
        <i class="fa fa-plus"></i>
        New
    </a>
</div>

<table class="table table-bordered table-hover" id="tableActivitiesWorksheet">
    <thead>
        <tr>
            <th>Importer Name</th>
            <th>Foreign Supplier </th>
            <th>Product(s) </th>
            <th>QI Approval</th>
            <th>Approval Date</th>
            <th>Evaluation Date</th>
            <th>Actions</th>
            <!-- <th data-nosort="true">Actions</th> -->
        </tr>
    </thead>
    <tbody></tbody>
</table>

<!-- modals -->
<div class="modal fade in" id="modalActWorksheet" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" role="form" id="newActivityWorksheetForm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">FSVP Activity(ies) Worksheet</h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awImporterSelect">Importer Name <?= required() ?></label>
                            <select name="importer_id" id="awImporterSelect" class="form-control">
                                <option value="" selected disabled>Select an importer</option>
                                <?php
                                    $suppliers = getImportersByUser($conn, $switch_user_id);
                                    foreach($suppliers as $supplier) {
                                        echo '<option value="'.$supplier['id'].'" data-address="'.$supplier['address'].'">'.$supplier['name'].'</option>';
                                    }
                                    if(count($suppliers) == 0) {
                                        echo'';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Address <?= autofill() ?></label>
                            <textarea class="form-control" placeholder="Select an importer to fill this field" id="awImporterAddress" readonly></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awVerificationDate">Verification Date</label>
                            <input type="date" name="verification_date" id="awVerificationDate" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awSupplierEvaluationDate">Supplier Evaluation Date</label>
                            <input type="date" name="supplier_evaluation_date" id="awSupplierEvaluationDate" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awFSVPQISelect">FSVP Qualified Individual <?= required() ?></label>
                            <select name="fsvpqi_id" id="awFSVPQISelect" class="form-control">
                                <option value="" selected disabled>Select FSVPQI</option>
                                <?php
                                    $fsvpqi = myFSVPQIs($conn, $switch_user_id);
                                    foreach($fsvpqi as $f) {
                                        echo '<option value="'.$f['id'].'" data-email="'.$f['email'].'">'.$f['name'].'</option>';
                                    }
                                    if(count($fsvpqi) == 0) {
                                        echo'';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awApprovalDate">Approval Date</label>
                            <input type="date" name="approval_date" id="awApprovalDate" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awForeignSupplierSelect">Foreign Supplier Name <?= required() ?></label>
                            <select name="supplier_id" id="awForeignSupplierSelect" class="form-control">
                                <option value="" selected disabled>Select foreign supplier</option>
                                <?php
                                    $suppliers = getSuppliersByUser($conn, $switch_user_id);
                                    foreach($suppliers as $supplier) {
                                        echo '<option value="'.$supplier['id'].'" data-address="'.$supplier['address'].'">'.$supplier['name'].'</option>';
                                    }
                                    if(count($suppliers) == 0) {
                                        echo'';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Address <?= autofill() ?></label>
                            <textarea class="form-control" placeholder="Select an importer to fill this field" id="awForeignSupplierAddress" readonly></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Food Product(s) Imported <?= autofill() ?></label>
                            <textarea id="awProductsImported" class="form-control bg-white" placeholder="Select a foreign supplier to fill this field" readonly></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awFPD">Food Product Description(s), including Important Food Safety Characteristics</label>
                            <textarea name="fdfsc" id="awFPD" class="form-control" placeholder="Enter food product description(s)"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awPDIPM">Process Description (Ingredients/Packaging Materials)</label>
                            <textarea name="pdipm" id="awPDIPM" class="form-control" placeholder="Enter process description"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awFSHC">Food Safety Hazard(s) Controlled by Foreign Supplier</label>
                            <textarea name="fshc" id="awFSHC" class="form-control" placeholder="Enter Food Safety Hazard(s)"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awDFSC">Description of Foreign Supplier Control(s)</label>
                            <textarea name="dfsc" id="awDFSC" class="form-control" placeholder="Enter Description of Foreign Supplier Control(s)"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awVAF">Verification Activity(ies) and Frequency</label>
                            <textarea name="vaf" id="awVAF" class="form-control" placeholder="Enter Verification Activity(ies) and Frequency"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awJVAF">Justification for Verification Activity(ies) and Frequency</label>
                            <textarea name="justification_vaf" id="awJVAF" class="form-control" placeholder="Justification for Verification Activity(ies) and Frequency"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awVR">Verification Records (i.e audit summaries, test results)</label>
                            <textarea name="verification_records" id="awVR" class="form-control" placeholder="Enter Verification Records"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awARVA">Assessment of Results of Verification Activity(ies)</label>
                            <textarea name="assessment_results" id="awARVA" class="form-control" placeholder="Enter Assessment of Results of Verification Activity(ies)"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awCA">Corrective Action(s), if needed</label>
                            <textarea name="corrective_actions" id="awCA" class="form-control" placeholder="Enter Corrective Action(s)"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="awReevaluationDate">Re-evaluation Date</label>
                            <input type="date" name="reevaluation_date" id="awReevaluationDate" class="form-control">
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


<script defer src="modules/fsvp/js/activitiesWorksheet.js"></script>