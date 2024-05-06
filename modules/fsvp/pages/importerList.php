<div class="d-flex margin-bottom-20" style="justify-content: end;">
    <a href="#modalNewImporter" data-toggle="modal" class="btn green">
        <i class="fa fa-plus"></i>
        New Importer
    </a>
    <a href="#modalCBPFiling" data-toggle="modal" class="btn green">
        <i class="fa fa-plus"></i>
        CBP Filing Form
    </a>
</div>

<table class="table table-bordered table-hover" id="tableImporterList">
    <thead>
        <tr>
            <th>Supplier Name</th>
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
        <form class="modal-content" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">New Importer Form</h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Importer </label>
                            <select name="" id="importerdd" class="form-control">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Evaluation Date </label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">DUNS No.</label>
                            <input type="text" class="form-control" placeholder="Enter DUNS number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">FDA Registration No.</label>
                            <input type="text" class="form-control" placeholder="Enter FDA Registration number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Supplier</label>
                            <input type="text" class="form-control" placeholder="Enter supplier">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Products</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">FSVPQI</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Address</label>
                            <input type="text" class="form-control">
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
                <button type="button" class="btn green saveSigns-btn">Submit </button>
            </div>
        </form>
    </div>
</div>

<script defer src="modules/fsvp/js/importerList.js"></script>