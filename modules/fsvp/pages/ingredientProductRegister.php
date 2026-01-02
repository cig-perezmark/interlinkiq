<div class="d-flex margin-bottom-20" style="display: none !important; justify-content: end;">
    <a href="#modalIngProdReg" id="iprAddProductBtn" data-toggle="modal" class="btn green">
        <i class="fa fa-plus"></i>
        Add product
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
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<!-- modal -->
<div class="modal fade in" id="modalIngProdReg" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" role="form" id="IngProdRegForm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Ingredient Product Register Form: <span id="iprTitle">Add Product</span></h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="productSelect2">Food/Product Name <?= required() ?></label>
                            <select id="productSelect2" class="form-control">
                                <option value="" selected disabled>Select product</option>
                            </select>
                            <small class="help-block">Select imported food/product from foreign suppliers. Try "sugar"</small>
                        </div>
                        <input type="hidden" name="ipr_id">
                        <input type="hidden" name="product_id">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="iprProductName">Food/Product Name <?= autofill() ?></label>
                            <textarea id="iprProductName" class="form-control" readonly placeholder="Auto-filled by product search"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="iprBrandName">Finished Product Brand Name </label>
                            <textarea name="brand_name" id="iprBrandName" class="form-control" placeholder="Enter finished product brand name"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Description <?= autofill() ?></label>
                            <textarea name="" id="iprDescription" class="form-control" readonly placeholder="Auto-filled by product search"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="importerSelect">Importer Name<?= required() ?></label>
                            <select name="importer" id="importerSelect"></select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="iprIngredientsList">Ingredients List <?= required() ?></label>
                            <textarea name="ingredients" id="iprIngredientsList" class="form-control" required placeholder="Enter ingredients"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="iprIntendedUse">Intended Use <?= required() ?></label>
                            <textarea name="intended_use" id="iprIntendedUse" class="form-control" required placeholder="Enter intended use"></textarea>
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
                <button type="submit" class="btn green saveSigns-btn">Submit </button>
            </div>
        </form>
    </div>
</div>

<script defer src="modules/fsvp/js/ingredientsRegister.js"></script>
