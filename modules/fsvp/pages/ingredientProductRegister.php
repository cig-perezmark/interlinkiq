<div class="d-flex margin-bottom-20" style="justify-content: end;">
    <a href="#modalIngProdReg" data-toggle="modal" class="btn green">
        <i class="fa fa-plus"></i>
    </a>
</div>

<table class="table table-bordered table-hover" id="tableIngredients">
    <thead>
        <tr>
            <th>Importer Name</th>
            <th>Product</th>
            <th>Description</th>
            <th>Ingredients List</th>
            <th>Brand Name</th>
            <th>Intended Use</th>
            <!-- <th>FSVP Activity Worksheet</th> -->
            <th data-nosort="true">Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<!-- modal -->
<div class="modal fade in" id="modalIngProdReg" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Ingredient Product Register Form</h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Find product </label>
                            <select name="" id="" class="form-control"></select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Importer </label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Brand Name </label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Description </label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Ingredients List </label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Food Product Description(s), <br>including Important Food Safety Characteristics:</label>
                            <textarea name="" id="" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Process Description <br> (Ingredients/Packaging Materials)
                            </label>
                            <textarea name="" id="" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Food Safety Hazard(s) Controlled by Foreign Supplier:</label>
                            <textarea name="" id="" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Description of Foreign Supplier Control(s)</label>
                            <textarea name="" id="" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Verification Activity(ies) and Frequency:</label>
                            <textarea name="" id="" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Justification for Verification Activity(ies) and Frequency:</label>
                            <textarea name="" id="" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Verification Records (i.e audit summaries, test results):</label>
                            <textarea name="" id="" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Assessment of Results of Verification Activity(ies):</label>
                            <textarea name="" id="" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Corrective Action(s), if needed</label>
                            <textarea name="" id="" class="form-control"></textarea>
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

<script defer src="modules/fsvp/js/ingredientsRegister.js"></script>