<div class="d-flex margin-bottom-20" style="justify-content: end;">
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
                <h4 class="modal-title">Ingredient Product Register Form: Add Product</h4>
            </div>
            <div class="modal-body form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="productSelect2">Find product <?= required() ?></label>
                            <select name="product_id" id="productSelect2" class="form-control">
                                <option value="" selected disabled>Select product</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="iprProductName">Product Name <?= autofill() ?></label>
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
                        <!-- <div class="form-group">
                            <label for="iprImporter">Importer</label>
                            <textarea id="iprImporter" class="form-control" style="height: 42px;" placeholder="Auto-filled by product search"></textarea>
                            <input type="hidden" name="importer" id="iprImporterId">
                        </div> -->
                        <div class="form-group">
                            <label for="importerSelect">Importer <?= required() ?></label>
                            <select name="importer" id="importerSelect">
                                <option value="" selected disabled>Select importer</option>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green saveSigns-btn">Submit </button>
            </div>
        </form>
    </div>
</div>

<script defer src="modules/fsvp/js/ingredientsRegister.js"></script>


<!-- <div class="row">
    <div class="col-md-12 margin-bottom-10">
        <strong>Foreign Supplier Activity Worksheet</strong>
        <hr>
    </div>

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
</div> -->