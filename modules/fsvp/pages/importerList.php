<div class="d-flex margin-bottom-20" style="justify-content: end;">
    <a href="#modalNewImporter" data-toggle="modal" class="btn green">
        <i class="fa fa-plus"></i>
        New Importer
    </a>
    <a href="#modalCBPFiling" data-toggle="modal" class="btn green hide">
        <i class="fa fa-plus"></i>
        CBP Filing Form
    </a>
</div>

<table class="table table-bordered table-hover" id="tableImporterList">
    <thead>
        <tr>
            <th>Importer Name</th>
            <th>Food Imported</th>
            <th>Address</th>
            <th>Evaluation Date</th>
            <th>Supplier Agreement</th>
            <th>FSVP Compliance Statement</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<!-- modals -->
<div class="modal fade in" id="modalNewImporter" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" role="form" id="newImporterForm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">New Importer Form</h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="importerdd">Importer <span class="required">*</span></label>
                            <select name="importer" id="importerdd" class="form-control">
                                <option value="" selected disabled>Select importer</option>
                                <?php
                                    $suppliers = getSuppliersByUser($conn, $switch_user_id);
                                    foreach($suppliers as $supplier) {
                                        echo '<option value="'.$supplier['id'].'">'.$supplier['name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="text-muted">Address</label>
                            <input type="text" class="form-control bg-white" placeholder="Select an importer to fill this field" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="fdarno">FDA Registration No.</label>
                            <input type="text" name="fda_registration" id="fdarno" class="form-control" placeholder="Enter FDA Registration number">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="dunsno">DUNS No.</label>
                            <input type="text" class="form-control" name="duns_no" id="dunsno" placeholder="Enter DUNS number">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="">Supplier</label>
                            <select name="supplier" id="supplierSelectDropdown" class="form-control">
                                <option value="" selected disabled>Select supplier</option>
                                <?php
                                    $suppliers = getSuppliersByUser($conn, $switch_user_id);
                                    foreach($suppliers as $supplier) {
                                        echo '<option value="'.$supplier['id'].'">'.$supplier['name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="text-muted">Address</label>
                            <input type="text" class="form-control bg-white" placeholder="Select a supplier to fill this field" readonly>
                        </div>
                    </div>
                </div>
                <div class="row margin-bottom-20x">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="fsvpqiSelect">FSVPQI <span class="required">*</span></label>
                            <select name="fsvpqi" id="fsvpqiSelect" class="form-control"></select>
                            <small class="help-block" id="fsvpqiSelectHelpBlock"></small>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="text-muted">Email</label>
                            <input type="text" class="form-control bg-white" placeholder="Select a FSVPQI to fill this field" readonly>
                        </div>
                    </div>
                </div>
                <div class="row margin-bottom-20">
                    <div class="col-md-12 margin-bottom-10">
                        <div>
                            <strong>Product(s):</strong>
                            <hr>
                            <p class="help-block" id="productsHelpBlock">Select importer first.</p>
                        </div>
                        <div class="mls-grid" id="productsListSelection"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="evalDate">Evaluation Date <span class="required">*</span></label>
                            <input type="date" name="evaluation_date" id="evalDate" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger alert-dismissable" id="modalNewImporterError" style="display: none;">
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

<div class="modal fade in" id="modalCBPFiling" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">FSVP CBP Filing Form</h4>
            </div>
            <div class="modal-body form-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Imported Food(s) / Food Product(s) Information</th>
                            <th>Supplier Information</th>
                            <th>Determining FSVP Importer</th>
                            <th>Designated FSVP Importer</th>
                            <th>CBP Entry Filer</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="button" class="btn green">Submit </button>
            </div>
        </form>
    </div>
</div>

<script defer src="modules/fsvp/js/importerList.js"></script>