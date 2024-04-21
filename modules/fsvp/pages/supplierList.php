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
            <th>Address</th>
            <th>Evaluation Date</th>
            <th>Supplier Agreement</th>
            <th>FSVP Compliance Statement</th>
            <th data-nosort="true"></th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Foreign Supplier Name</label>
                            <input type="text" class="form-control" placeholder="Enter foreign supplier name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Address</label>
                            <input type="text" class="form-control" placeholder="Enter supplier address">
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
                                <tbody>
                                    <tr>
                                        <td>
                                            <textarea name="" id="" class="form-control"></textarea>
                                        </td>
                                        <td><?= yesNoRadio(); ?></td>
                                        <td><?= yesNoRadio(); ?></td>
                                        <td><?= yesNoRadio(); ?></td>
                                        <td><?= yesNoRadio(); ?></td>
                                        <td><?= yesNoRadio(); ?></td>
                                        <td>
                                            <textarea name="" id="" class="form-control"></textarea>
                                        </td>
                                        <td><input type="date" name="" id="" class="form-control"></td>
                                        <td><input type="date" name="" id="" class="form-control"></td>
                                    </tr>
                                </tbody>
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
        <form class="modal-content" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">New Supplier Form</h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Find supplier </label>
                            <select name="" id="" class="multi-select">
                                <?php
                                    $suppliers = getSuppliersByUser($conn, $switch_user_id);
                                    foreach($suppliers as $supplier) {
                                        echo '<option value="'.$supplier['id'].'">'.$supplier['name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h5><strong>Food imported:</strong></h5>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="" class="col-form-label col-md-2">Select</label>
                            <div class="col-md-10">
                                <select name="" id="" class="form-control"></select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Supplier Agreement</label>
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline">
                                    <input type="radio" name="optionsRadios" id="optionsRadios4" value="option1"> Yes
                                    <span></span>
                                </label>
                                <label class="mt-radio mt-radio-outline">
                                    <input type="radio" name="optionsRadios" id="optionsRadios5" value="option2"> No
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>FSVP Compliance Statement</label>
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline">
                                    <input type="radio" name="optionsRadios" id="optionsRadios4" value="option1"> Yes
                                    <span></span>
                                </label>
                                <label class="mt-radio mt-radio-outline">
                                    <input type="radio" name="optionsRadios" id="optionsRadios5" value="option2"> No
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="button" class="btn green saveSigns-btn">Submit </button>
            </div>
        </form>
    </div>
</div>