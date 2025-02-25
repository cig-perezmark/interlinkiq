<?php
    $title = "Formulation";
    $site = "formulation";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style>
  .addIngredientsTable th,
  .addIngredientsTable td {
    text-align: center;
    vertical-align: middle !important;
  }

  .addIngredientsTable tr:nth-of-type(1) th:nth-of-type(2),
  .addIngredientsTable td:nth-of-type(2) {
    text-align: start;
    width: 45%;
  }

  .ingredient-block {
    display: flex;
    gap: 1rem;
  }

  .ingredient-block p {
    margin: 0;
  }

  .ingredient-image {
    width: 7.5rem;
    height: auto;
    object-fit: cover;
  }

  .ingredient-name {
    font-weight: 700;
    font-size: 1.1em;
  }

  .ingredient-details {
    font-size: .9em;
    color: gray;
  }

  .ingredient-details span {
    font-weight: 600;
  }

  .addIngredientsTable td:nth-of-type(3) {
    position: relative;
    width: 7rem;
  }

  .addIngredientsTable tr:has(.amount-per-serving-in-ingredients-table:focus) {
    background: #f3f4f6 !important;
  }

  tr:has(.amt-srv) .form-control::-webkit-inner-spin-button,
  tr:has(.amt-srv) .form-control::-webkit-outer-spin-button {
    -webkit-appearance: none;
    appearance: none;
    margin: 0;
  }

  tr:has(.amt-srv) .form-control {
    appearance: none;
    text-align: center;
  }

  .steps-list {
    margin: 1rem;
    margin-right: 0;
    padding: 0;
    padding-left: 1rem;
  }

  .steps-list .form-control {
    border-top-color: transparent !important;
    border-left-color: transparent !important;
    border-right-color: transparent !important;
  }

  .semi-bold {
    font-weight: 600 !important;
  }

  .helper {
    font-size: .875em;
    color: red;
    padding: 0;
    margin: 0;
  }

  .error-field {
    border-color: red !important;
  }

  .emptyIngredientsList {
    border: 1px solid #e7ecf1;
    border-top: none;
    /* margin-bottom: 50px;; */
    padding: 1rem;
    text-align: center;
    font-style: italic;
    color: gray;
  }

  .steps-list li {
    position: relative;
    margin-bottom: 1.5rem;
    background-color: white !important;
  }

  .steps-list li::after {
    content: '(Press ctrl + enter to add new field below)';
    font-size: .875em;
    display: none;
    position: absolute;
    color: gray;
    z-index: 10;
  }

  .steps-list li:has(.form-control:focus)::after {
    display: block;
  }

  .process-block,
  .e-process-block {
    margin-bottom: 15px;
  }

  #viewFormulationModal .steps-list .form-control {
    border: none;
  }
 </style>
 
 <link href="assets/global/plugins/datatables/datatables.min.css"
        rel="stylesheet"
        type="text/css" />
  <link href="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css"
        rel="stylesheet"
        type="text/css" />
  <link href="assets/global/plugins/select2/css/select2.min.css"
        rel="stylesheet"
        type="text/css" />
  <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css"
        rel="stylesheet"
        type="text/css" />

        <div class="row">
          <div class="col-md-12">
            <div class="portlet light portlet-fit">
              <div class="portlet-title">
                <div class="caption">
                  <i class="icon-calculator font-dark"></i>
                  <span class="caption-subject sbold uppercase">Formulation</span>
                </div>
                <div class="actions">
                  <div class="btn-group">
                    <a class="btn dark btn-outline btn-circle btn-sm"
                       href="javascript:;"
                       data-toggle="dropdown"
                       data-hover="dropdown"
                       data-close-others="true"
                       aria-expanded="false"> Actions
                      <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-right">
                      <li>
                        <a href="#formulationModal"
                           data-toggle="modal">Add new formula</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="portlet-body">
                <table class="table table-bordered"
                       id="formulaTable">
                  <thead>
                    <tr>
                      <th>Code/ID</th>
                      <th>Version No.</th>
                      <th>Formula Name</th>
                      <th>Status</th>
                      <th>Status Date</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                // $results = $conn->query("SELECT * FROM tbl_formulation_formulas WHERE id <> 0 AND user_id = 1 AND status <> 0");
                $results = $conn->query("SELECT * FROM tbl_formulation_formulas WHERE status > 0 AND user_id = $switch_user_id");
                if(mysqli_num_rows($results) > 0) {
                  while($row = $results->fetch_assoc()) {
                    ?>
                    <tr>
                      <td><?= $row['formula_code'] ?></td>
                      <td><?= $row['version_number'] ?></td>
                      <td><?= $row['name'] ?></td>
                      <td>
                        <?php
                    $status = json_decode($conn->query("SELECT status FROM tbl_formulation_formulas WHERE id = 0")->fetch_assoc()['status']);
                    echo $status[$row['status']];
                  ?>
                      </td>
                      <td><?= $row['status_date'] ?></td>
                      <td>
                        <div style="display: flex; justify-content: center;">
                          <div class="btn-group btn-group-circle">
                            <a href="javascript:void(0)"
                               onclick="viewFormulaFn(<?= $row['id'] ?>)"
                               class="btn btn-outline green btn-sm">View</a>
                            <a href="#viewFormulationModal"
                               data-id="<?= $row['id'] ?>"
                               class="btn btn-outlinex dark btn-sm">Edit</a>
                            <button type="button"
                                    data-id="<?= $row['id'] ?>"
                                    class="btn red btn-sm removeFormulBtn">Delete</button>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <?php
                  }
                }
              ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END CONTENT BODY -->

      <!-- formula modal -->
      <div class="modal fade in bs-modal-lg"
           id="formulationModal"
           role="formulationModal"
           aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button"
                      class="close"
                      data-dismiss="modal"
                      aria-hidden="true"></button>
              <h4 class="modal-title">Add new formula</h4>
            </div>
            <div class="modal-body">
              <ul class="nav nav-tabs">
                <li class="active">
                  <a href="#basicInformationTab"
                     data-toggle="tab"> Information </a>
                </li>
                <li>
                  <a href="#processesTab"
                     data-toggle="tab">Instructions</a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade active in"
                     id="basicInformationTab">
                  <form style="margin-top: 3rem;"
                        id="formulaForm">
                    <div class="form-body">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="affFormulaName">
                              Formula Name
                              <span class="required">*</span>
                            </label>
                            <div>
                              <input class="form-control"
                                     type="text"
                                     name="formula_name"
                                     id="affFormulaName"
                                     placeholder="Enter formula name">
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label for="affFomulaCode">
                              Formula Code/ID
                              <span class="required">*</span>
                            </label>
                            <div>
                              <input class="form-control"
                                     type="text"
                                     name="formula_code"
                                     id="affFomulaCode"
                                     placeholder="Enter formula code/id">
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="affVersionNumber">
                              Version No.
                              <span class="require">&nbsp;</span>
                            </label>
                            <div>
                              <input class="form-control"
                                     type="text"
                                     name="version_number"
                                     id="affVersionNumber"
                                     placeholder="Version No.">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="affStatus">
                              Status
                              <span class="required">*</span>
                            </label>
                            <div>
                              <select name="status"
                                      id="affStatus"
                                      class="form-control">
                                <option value=""
                                        selected
                                        disabled>--Select--</option>
                                <?php
                                  $stats = json_decode($conn->query("SELECT status FROM tbl_formulation_formulas WHERE id = 0")->fetch_assoc()['status']);

                                  foreach($stats as $key => $val) {
                                    if($key == 0)
                                      continue;
                                    echo "<option value='$key'>$val</option>";
                                  }
                                ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label for="affStatusDate">
                              Date
                              <span class="required">*</span>
                            </label>
                            <div>
                              <input class="form-control"
                                     type="date"
                                     name="status_date"
                                     id="affStatusDate"
                                     placeholder="Enter formula code/id">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="affServingSize">
                              Serving Size
                              <span class="required">*</span>
                            </label>
                            <div>
                              <input class="form-control"
                                     type="text"
                                     name="serving_size"
                                     id="affServingSize"
                                     placeholder="Enter grams per serving (size)">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          <h4>Add ingredients:</h4>
                          <p class="helper add-ingredient-helper hide">
                            Please select an ingredient and provide the necessaryinput to proceed!
                          </p>
                        </div>
                        <div class="col-sm-6">
                          <select id="ingredientsSearch"
                                  class="form-control">
                            <option value=""
                                    selected="selected">Select ingredient(s) to add </option>
                          </select>
                          <input type="hidden"
                                 id="selectedIngredientId">
                        </div>
                        <div class="col-sm-4">
                          <div class="amt-srv"
                               style="display:flex;gap: 0.75rem;align-items:center;">
                            amount:
                            <input type="number"
                                   class="form-control"
                                   value="0"
                                   style="min-width: 7rem!important;"
                                   step="0.01"
                                   min="0"
                                   id="selectedIngredientAmountPerServing">
                            unit:
                            <select class="form-control"
                                    id="units-o-m" style="min-width: 7rem!important;"></select>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <button type="button"
                                  class="btn blue addIngredientBtn">
                            <i class="fa fa-plus"></i>
                            Add
                          </button>
                        </div>
                      </div>
                      <div class="row"
                           style="margin-top: 3rem;">
                        <div class="col-sm-12">
                          <div class="table-responsive">
                            <table class="table table-bordered table-hover addIngredientsTable"
                                   style="margin-bottom: 0;">
                              <thead>
                                <tr>
                                  <th rowspan="2"
                                      style="width: 5%;"></th>
                                  <th rowspan="2">Ingredient</th>
                                  <th colspan="3">
                                    Amount Per Serving <br>
                                    <small class="text-muted"
                                           style="font-weight: normal;">
                                      Manually provide the conversion factor for each ingredient and unit. <br>
                                      1 qty unit = n grams (g/unit)
                                    </small>
                                  </th>
                                  <th rowspan="2">Price</th>
                                  <th rowspan="2">Formulation</th>
                                  <th colspan="3">Cost Per Serving</th>
                                </tr>
                                <tr>
                                  <th>qty</th>
                                  <th>unit</th>
                                  <th>g/unit</th>
                                  <th>lb</th>
                                  <th>oz</th>
                                  <th>kg</th>
                                </tr>
                              </thead>
                              <tbody id="ingredientsListBody"></tbody>
                            </table>
                            <div class="emptyIngredientsList">
                              No ingredient has been added yet.
                            </div>
                          </div>
                        </div>
                      </div>
                      <div>
                        <p>Total Amount/serving, g: <strong class="totalAmountPerServing">0</strong></p>
                        <p>% of Formulation: <strong class="PercentFormulation">0%</strong></p>
                        <p>Total Price: <strong class="TotalPrice">0</strong></p>
                      </div>
                    </div>
                  </form>
                </div>
                <div class=" tab-pane fade"
                     id="processesTab">
                  <h4 style="margin: 3rem 0 2rem 0;">Add instructions/processes of this formulation</h4>
                  <button type="button"
                          class="btn blue margin-bottom-20 addNewProcessBtn"> Add new process</button>
                  <div id="processesList"></div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button"
                      class="btn dark btn-outline"
                      data-dismiss="modal">Close</button>
              <button type="button"
                      onclick="$('#formulaForm').submit()"
                      class="btn green">
                Submit
              </button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- view formula modal -->
      <div class="modal fade in bs-modal-lg"
           id="viewFormulationModal"
           role="viewFormulationModal"
           aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button"
                      class="close"
                      data-dismiss="modal"
                      aria-hidden="true"></button>
              <h4 class="modal-title">Edit formula</h4>
            </div>
            <div class="modal-body">
              <form style="margin-top: 1rem;"
                    id="editFormulaForm">
                <input type="hidden"
                       name="formula_id">
                <div class="form-body">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="effFormulaName">
                          Formula Name
                          <span class="required">*</span>
                        </label>
                        <div>
                          <input class="form-control"
                                 type="text"
                                 name="formula_name"
                                 id="effFormulaName"
                                 placeholder="Enter formula name">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="effFomulaCode">
                          Formula Code/ID
                          <span class="required">*</span>
                        </label>
                        <div>
                          <input class="form-control"
                                 type="text"
                                 name="formula_code"
                                 id="effFomulaCode"
                                 placeholder="Enter formula code/id">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label for="effVersionNumber">
                          Version No.
                          <span class="require">&nbsp;</span>
                        </label>
                        <div>
                          <input class="form-control"
                                 type="text"
                                 name="version_number"
                                 id="effVersionNumber"
                                 placeholder="Version No.">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="affStatus">
                          Status
                          <span class="required">*</span>
                        </label>
                        <div>
                          <select name="status"
                                  id="affStatus"
                                  class="form-control">
                            <option value=""
                                    selected
                                    disabled>--Select--</option>
                            <?php
                            $stats = json_decode($conn->query("SELECT status FROM tbl_formulation_formulas WHERE id = 0")->fetch_assoc()['status']);

                            foreach($stats as $key => $val) {
                              if($key == 0)
                                continue;
                              echo "<option value='$key'>$val</option>";
                            }
                          ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="affStatusDate">
                          Date
                          <span class="required">*</span>
                        </label>
                        <div>
                          <input class="form-control"
                                 type="date"
                                 name="status_date"
                                 id="affStatusDate"
                                 placeholder="Enter formula code/id">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="affServingSize">
                          Serving Size
                          <span class="required">*</span>
                        </label>
                        <div>
                          <input class="form-control"
                                 type="text"
                                 name="serving_size"
                                 id="affServingSize"
                                 placeholder="Enter grams per serving (size)">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <h4 class="col-sm-12">Ingredients</h4>
                    <div class="col-sm-12">
                      <div class="table-responsive">
                        <table class="table table-bordered table-hover addIngredientsTable"
                               style="margin-bottom: 0;">
                          <thead>
                            <tr>
                              <th rowspan="2"
                                  style="width: 5%;"></th>
                              <th rowspan="2">Ingredient</th>
                              <th colspan="3">
                                Amount Per Serving <br>
                                <small class="text-muted"
                                       style="font-weight: normal;">
                                  Manually provide the conversion factor for each ingredient and unit. <br>
                                  1 qty unit = n grams (g/unit)
                                </small>
                              </th>
                              <th rowspan="2">Price</th>
                              <th rowspan="2">Formulation</th>
                              <th colspan="3">Cost Per Serving</th>
                            </tr>
                            <tr>
                              <th>qty</th>
                              <th>unit</th>
                              <th>g/unit</th>
                              <th>lb</th>
                              <th>oz</th>
                              <th>kg</th>
                            </tr>
                          </thead>
                          <tbody id="viewIngredientsListBody">
                            <tr id="viewIngredientsAddNewItem">
                              <td>
                                <label class="mt-checkbox mt-checkbox-outline"
                                       style="visibility: hidden;">
                                  <input type="checkbox"
                                         checked
                                         class="ingredient-check">
                                  <span></span>
                                </label>
                              </td>
                              <td>
                                <select id="editIngredientsSearch"
                                        class="form-control">
                                  <option value=""
                                          selected="selected">Select ingredient(s) to add
                                  </option>
                                </select>
                                <input type="hidden"
                                       id="edit-selectedIngredientId">
                                <span class="text-danger hide edit-addIngredientButton-error">
                                  Select an ingredient first
                                </span>
                              </td>
                              <td colspan="3">
                                <div class="amt-srv"
                                     style="display:flex;gap: 0.75rem;align-items:center;">
                                  amount:
                                  <input type="number"
                                         class="form-control"
                                         value="0"
                                         step="0.01"
                                         min="0"
                                         id="edit-selectedIngredientAmountPerServing"
                                         style="min-width: 7rem!important;">
                                  unit:
                                  <select class="form-control"
                                          id="edit-units-o-m" style="min-width: 7rem!important;">
                                  </select>
                                </div>
                              </td>
                              <td colspan="5">
                                <div style="text-align: left;">
                                  <button type="button"
                                          class="btn blue edit-addIngredientButton">
                                    <i class="fa fa-plus"></i>
                                    Add
                                  </button>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div>
                        <p>Total Amount/serving, g: <strong class="totalAmountPerServing">0</strong></p>
                        <p>% of Formulation: <strong class="PercentFormulation">0%</strong></p>
                        <p>Total Price: <strong class="TotalPrice">0</strong></p>
                      </div>
                      <div class="form-group">
                        <label for="editNote">
                          Add notes <span class="text-muted">(optional)</span>
                        </label>
                        <div>
                          <textarea name="notes"
                                    style="resize:vertical;"
                                    id="editNote"
                                    placeholder="Type to add note..."
                                    rows="5"
                                    class="form-control"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <h4 class="col-sm-12">Instructions</h4>
                    <div class="col-sm-12 e-process-container">
                      <div class="row e-process-block-add-new">
                        <div class="col-sm-2">
                          <h5>Process Name</h5>
                        </div>
                        <div class="col-sm-7">
                          <input type="text"
                                 class="form-control semi-bold process-title edit-addNewInstructionInput"
                                 placeholder="Enter new process name here...">
                        </div>
                        <div class="col-sm-3">
                          <button type="button"
                                  class="btn blue edit-addNewInstructionBtn">
                            <i class="fa fa-plus"></i>
                            Add new instruction
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button"
                      class="btn dark btn-outline"
                      data-dismiss="modal">Close</button>
              <button type="button"
                      onclick="$('#editFormulaForm').submit()"
                      class="btn green">
                Submit
              </button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade in"
           id="viewPrintFormulationModal"
           role="dialog"
           aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button"
                      class="close"
                      data-dismiss="modal"
                      aria-hidden="true"></button>
              <h4 class="modal-title">View formula</h4>
            </div>
            <style>
            .table-center :where(td, th) {
              vertical-align: middle !important;
              text-align: center !important;
            }
            </style>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-7"></div>
                <div class="col-md-5">
                  <div style="display: flex; align-items: center; gap: 1rem;">
                    <label for="batchSizeInput"
                           style="flex-shrink: 0; margin: 0;">
                      Batch size:
                    </label>
                    <input class="form-control"
                           type="number"
                           min="1"
                           id="batchSizeInput"
                           placeholder="Enter batch size"
                           value="1">
                    <button type="button"
                            onclick="refreshFormula()"
                            class="btn btn-primary">Refresh</button>
                  </div>
                </div>
              </div>
              <div class="formulaview"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <?php include_once('footer.php')?>
    <script src="formulationv2/js/index.js"></script>
    <script src="assets/global/scripts/datatable.js"
          type="text/javascript"></script>
  <script src="assets/global/plugins/datatables/datatables.min.js"
          type="text/javascript"></script>
  <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
          type="text/javascript"></script>
  <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js"
          type="text/javascript"></script>
  <script src="assets/global/plugins/jquery-ui/jquery-ui.min.js"
          type="text/javascript"></script>
  <script src="assets/global/plugins/select2/js/select2.full.min.js"
          type="text/javascript"></script>
  <!-- END PAGE LEVEL PLUGINS -->
  <script src="assets/global/scripts/app.min.js"
          type="text/javascript"></script>
  <!-- END PAGE LEVEL SCRIPTS -->
    </body>

</html>
