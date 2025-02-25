<?php

$hints = array(
    "foods_info"            => "<div class='form-hint'>
                                    What food(s)/ food product(s) Import (receive)?<br>
                                    <mark>Note: List each food/food product. Be specific, e.g., can size; size packages; bulk weight.</mark><br>
                                    For each food listed, will the food or food product made from the imported food be offered for sale in the U.S.?
                                </div>",
    "supplier_info"         => "<div class='form-hint'>
                                    From whom do purchase the food (i.e., Supplier's name, address, etc.)?<br>
                                    Is the Supplier a U.S. company or a foreign company?<br>
                                    Does the importer from whom directly purchases the food fit the FSVP definition of the foreign Supplier (i.e., grower, manufacturer)?
                                </div>",   
    "determining_importer"   => "<div class='form-hint'>
                                    Describe the current buying arrangement(s) (i.e., name all parties involved in obtaining the food product, including foreign Supplier, if known)<br>
                                    At the time of entry, the importer of the food, or have you purchased or agreed to purchase the food (i.e., do you fit the definition of “U.S. owner or consignee” and, therefore, FSVP “importer” for this food)? **<br>
                                    Who else involved in this arrangement fits the FSVP definition of importer?<br>
                                    <mark>Note: Be specific, e.g., are there multiple purchasers for the same line entry of food, do you purchase food from a U.S. importer/distributor?</mark>
                                </div>",
    "designated_importer"   => "<div class='form-hint'>
                                    If more than one person/entity fits the definition of the importer, negotiate with others to determine who will carry out FSVP requirements.<br>
                                    <mark>Note: Place name below and formalize the understanding (i.e., create an agreement identifying FSVP importer).</mark>
                                </div>",   
    "cbp_entry_filer"       => "<div class='form-hint'>
                                    Who fills out the CBP entry filing for this food/food product (i.e., name, address)?
                                    <mark>Note: Provide a copy of the agreement/understanding identifying the FSVP Importer* to be identified in CBP entry filing (i.e., name, address, email, and DUNS number of agreed-upon FSVP importer).</mark>
                                </div>",   
);

function showHint($hint) {
    echo '<div class="help-icon-group tooltips" data-html="true" data-placement="bottom" data-original-title="'.$hint.'"><i class="fa fa-question-circle"></i></div>';
}

?>

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
            <th>Supplier Name</th>
            <th>DUNS No.</th>
            <th>FDA Registration No.</th>
            <th>FSVPQI</th>
            <th>Evaluation Date</th>
            <th>CBP Filing Form</th>
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
                                    $suppliers = getRawImportersByUser($conn, $switch_user_id);
                                    foreach($suppliers as $supplier) {
                                        echo '<option value="'.$supplier['id'].'" data-address="'.$supplier['address'].'">'.$supplier['name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="text-muted">Address <i class="text-muted">(auto-filled)</i></label>
                            <input type="text" class="form-control bg-white" id="if_ImporterAddress" placeholder="Select an importer to fill this field" readonly>
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
                            <label for="">Foreign Supplier <?= required() ?></label>
                            <select name="supplier" id="supplierSelectDropdown" class="form-control">
                                <option value="" selected disabled>Select foreign supplier</option>
                                <?php
                                    $suppliers = getForeignSuppliersOnly($conn, $switch_user_id);
                                    foreach($suppliers as $supplier) {
                                        echo '<option value="'.$supplier['id'].'" data-address="'.$supplier['address'].'">'.$supplier['name'].'</option>';
                                    }
                                ?>
                            </select>
                            <small class="help-block">Directly associated with Foreign Suppliers List data.</small>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="text-muted">Address <i class="text-muted">(auto-filled)</i></label>
                            <input type="text" class="form-control bg-white" id="if_SupplierAddress" placeholder="Select a supplier to fill this field" readonly>
                        </div>
                    </div>
                </div>
                <div class="row margin-bottom-20x">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="fsvpqiSelect">FSVP Qualified Individual <span class="required">*</span></label>
                            <select name="fsvpqi" id="fsvpqiSelect" class="form-control"></select>
                            <small class="help-block">Correlates with FSVPQI Registry tab.</small>
                            <small class="help-block" id="fsvpqiSelectHelpBlock"></small>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="text-muted">Email <i class="text-muted">(auto-filled)</i></label>
                            <input type="text" class="form-control bg-white" id="id_fsvpqiEmail" placeholder="Select a FSVPQI to fill this field" readonly>
                        </div>
                    </div>
                </div>
                <div class="row margin-bottom-20">
                    <div class="col-md-12 margin-bottom-10">
                        <div>
                            <strong>Food/Product(s) Imported:</strong>
                            <hr>
                            <p class="help-block" id="productsHelpBlock">Select a foreign supplier first.</p>
                        </div>
                        <div class="mls-grid" id="productsListSelection"></div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="evalComments">Comments</label>
                            <textarea name="comments" id="evalComments" class="form-control" placeholder="Comments"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Signature</label>
                            <div id="signature"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dateSigned">Date Signed</label>
                            <input type="date" name="date_signed" id="dateSigned" class="form-control">
                        </div>
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

<div class="modal fade in" id="modalCBPFiling" role="dialog" aria-hidden="true" tabindex="1">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" role="form" id="CBPFilingForm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">FSVP CBP Filing Form</h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cfFoodInfo">
                                Imported Food(s)/Food Product(s) Information
                                <?= showHint($hints['foods_info']) ?>
                            </label>
                            <textarea name="foods_info" id="cfFoodInfo" class="form-control" placeholder="Imported Food(s)/Food Product(s) Information"></textarea>
                            <input type="hidden" name="importer">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cfSupplierInfo">
                                Supplier Information
                                <?= showHint($hints['supplier_info']) ?>
                            </label>
                            <textarea name="supplier_info" id="cfSupplierInfo" class="form-control" placeholder="Enter supplier information"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cfDetImporter">
                                Determining FSVP Importer
                                <?= showHint($hints['determining_importer']) ?>
                            </label>
                            <textarea name="determining_importer" id="cfDetImporter" class="form-control" placeholder="Enter determining FSVP importer"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cfDesImporter">
                                Designated FSVP Importer
                                <?= showHint($hints['designated_importer']) ?>
                            </label>
                            <textarea name="designated_importer" id="cfDesImporter" class="form-control" placeholder="Enter designated FSVP importer"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cfEntryFiler">
                                CBP Entry Filer
                                <?= showHint($hints['cbp_entry_filer']) ?>
                            </label>
                            <textarea name="cbp_entry_filer" id="cfEntryFiler" class="form-control" placeholder="Enter CBP entry filer"></textarea>
                        </div>
                    </div>
                </div>

                <!-- reviewed bt -->
                <div class="row">
                    <div class="col-md-12"><strong>Reviewed By</strong></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="revName">Name</label>
                            <input type="text" name="reviewed_by" id="revName" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="revDate">Date</label>
                            <input type="date" name="review_date" id="revDate" class="form-control">
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
                            <label for="apbName">Name</label>
                            <input type="text" name="approved_by" id="apbName" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="apbDate">Date</label>
                            <input type="date" name="approve_date" id="apbDate" class="form-control" >
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
                            <label for="cbpComment">Comments</label>
                            <textarea name="comments" id="cbpComment" class="form-control" placeholder="Comments"></textarea>
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

<div class="modal fade in" id="modalViewCBP" role="dialog" aria-hidden="true" tabindex="1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">View FSVP CBP Filing Form Data</h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Importer Name:</label>
                            <div class="form-control" data-viewcbp="importer"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Date</label>
                            <div class="form-control" data-viewcbp="date"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address:</label>
                            <div class="form-control" data-viewcbp="address"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                                Imported Food(s)/Food Product(s) Information
                                <?= showHint($hints['foods_info']) ?>
                            </label>
                            <div class="form-control" data-viewcbp="foods_info"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                                Supplier Information
                                <?= showHint($hints['supplier_info']) ?>
                            </label>
                            <div class="form-control" data-viewcbp="supplier_info"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                                Determining FSVP Importer
                                <?= showHint($hints['determining_importer']) ?>
                            </label>
                            <div class="form-control" data-viewcbp="determining_importer"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                                Designated FSVP Importer
                                <?= showHint($hints['designated_importer']) ?>
                            </label>
                            <div class="form-control" data-viewcbp="designated_importer"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                                CBP Entry Filer
                                <?= showHint($hints['cbp_entry_filer']) ?>
                            </label>
                            <div class="form-control" data-viewcbp="cbp_entry_filer"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <a href="about:blank" target="_blank" class="btn blue">
                    <!-- <i class="fa fa-pdf-o"></i> -->
                    View PDF
                </a>
            </div>
        </div>
    </div>
</div>

<script defer src="modules/fsvp/js/importerList.js"></script>
