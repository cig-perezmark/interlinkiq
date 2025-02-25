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
<style type="text/css">
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
	.addIngredientsTable td:nth-of-type(3)::after {
	  content: 'Edit';
	  display: none;
	  position: absolute;
	  inset: auto 5px 5px auto;
	  font-size: .85em;
	  color: rgb(146, 201, 249);
	}

	.addIngredientsTable td:nth-of-type(3):hover::after {
	  display: block;
	}

	.addIngredientsTable td:nth-of-type(3):has(.amount-per-serving-in-ingredients-table:focus):hover::after {
	  display: none;
	}

	.addIngredientsTable tr:has(.amount-per-serving-in-ingredients-table:focus) {
	  background: #f3f4f6!important;
	}

	.amount-per-serving-in-ingredients-table {
	  position: absolute;
	  inset: 0;
	  text-align: center;
	  border: none;
	  background-color: transparent;
	}

	.amount-per-serving-in-ingredients-table:focus {
	  outline: none;
	  box-shadow: none;
	}

	.steps-list {
	  margin: 1rem;
	  margin-right: 0;
	  padding: 0;
	  padding-left: 1rem;
	}

	.steps-list .form-control {
	  border-top-color: transparent!important;
	  border-left-color: transparent!important;
	  border-right-color: transparent!important;
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


    /* DataTable*/
    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {
        position: relative;
    }
    .table thead tr th {
        vertical-align: middle;
    }
</style>

					<div class="row">
						<div class="col-md-12">
							<div class="portlet light portlet-fit">
								<div class="portlet-title">
									<div class="caption">
										<i class="icon-calculator font-dark"></i>
										<span class="caption-subject font-dark sbold uppercase pageTitleName">Formulation</span>
									</div>
									<div class="actions">
										<div class="btn-group">
											<a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"> Actions <i class="fa fa-angle-down"></i></a>
											<ul class="dropdown-menu pull-right">
												<li>
													<a href="#formulationModal" data-toggle="modal">Add new formula</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="portlet-body">
									<table class="table table-bordered" id="formulaTable">
										<thead>
											<tr>
												<th>Code/ID</th>
												<th>Version No.</th>
												<th>Formula Name</th>
												<th>Status</th>
												<th>Status Date</th>
												<th style="width: 135px;" class="text-center">Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$results = $conn->query("SELECT * FROM tbl_formulation_formulas WHERE id <> 0 AND status <> 0 AND user_id = $switch_user_id");
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
															<td class="text-center">
                                                                <div class="btn-group btn-group-circle">
                                                                    <a href="#viewFormulationModal" class="btn btn-outline dark btn-sm" data-toggle="modal" data-id="<?= $row['id'] ?>">Edit</a>
                                                                    <a href="javascript:;" class="btn btn-danger btn-sm removeFormulBtn" data-id="<?= $row['id'] ?>">Delete</a>
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
					<!-- END CONTENT BODY -->

					<!-- formula modal -->
					<div class="modal fade in bs-modal-lg" id="formulationModal" role="formulationModal" aria-hidden="true">
					  <div class="modal-dialog modal-lg">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Add new formula</h4>
						  </div>
						  <div class="modal-body">
							<ul class="nav nav-tabs">
							  <li class="active">
								<a href="#basicInformationTab" data-toggle="tab"> Information </a>
							  </li>
							  <li>
								<a href="#processesTab" data-toggle="tab">Instructions</a>
							  </li>
							</ul>
							<div class="tab-content">
							  <div class="tab-pane fade active in" id="basicInformationTab">
								<form style="margin-top: 3rem;" id="formulaForm">
								  <div class="form-body">
									<div class="row">
									  <div class="col-sm-6">
										<div class="form-group">
										  <label for="affFormulaName">
											Formula Name
											<span class="required">*</span>
										  </label>
										  <div>
											<input class="form-control" type="text" name="formula_name" id="affFormulaName"
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
											<input class="form-control" type="text" name="formula_code" id="affFomulaCode"
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
											<input class="form-control" type="text" name="version_number" id="affVersionNumber"
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
											<select name="status" id="affStatus" class="form-control">
											  <option value="" selected disabled>--Select--</option>
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
											<input class="form-control" type="date" name="status_date" id="affStatusDate"
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
											<input class="form-control" type="text" name="serving_size" id="affServingSize"
											  placeholder="Enter grams per serving (size)">
										  </div>
										</div>
									  </div>
									</div>
									<div class="row">
									  <div class="col-sm-12">
										<h4>Add ingredients:</h4>
										<p class="helper add-ingredient-helper hide">Please select an ingredient and provide the necessary
										  input to proceed!</p>
									  </div>
									  <div class="col-sm-6">
										<select id="ingredientsSearch" class="form-control">
										  <option value="" selected="selected">Find ingredients by its name, id or manufacturer</option>
										</select>
										<input type="hidden" id="selectedIngredientId">
									  </div>
									  <div class="col-sm-4">
										<input type="number" step="0.01" class="form-control" id="selectedIngredientAmountPerServing"
										  placeholder="Amount per serving, g">
									  </div>
									  <div class="col-sm-2">
										<button type="button" class="btn blue addIngredientBtn">
										  <i class="fa fa-plus"></i>
										  Add
										</button>
									  </div>
									</div>
									<div class="row" style="margin-top: 3rem;">
									  <div class="col-sm-12">
										<div class="table-responsive">
										  <table class="table table-bordered table-hover addIngredientsTable" style="margin-bottom: 0;">
											<thead>
											  <tr>
												<th rowspan="2"></th>
												<th rowspan="2">Ingredient</th>
												<th rowspan="2">Amt/srv, g</th>
												<th rowspan="2">Formulation</th>
												<th colspan="3">Cost per serving</th>
											  </tr>
											  <tr>
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
									</div>
								  </div>
								</form>
							  </div>
							  <div class=" tab-pane fade" id="processesTab">
								<h4 style="margin: 3rem 0 2rem 0;">Add instructions/processes of this formulation</h4>
								<button type="button" class="btn blue margin-bottom-20 addNewProcessBtn"> Add new process</button>
								<div id="processesList"></div>
							  </div>
							</div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							<button type="button" onclick="$('#formulaForm').submit()" class="btn green">
							  Submit
							</button>
						  </div>
						</div>
						<!-- /.modal-content -->
					  </div>
					  <!-- /.modal-dialog -->
					</div>

					<!-- view formula modal -->
					<div class="modal fade in bs-modal-lg" id="viewFormulationModal" role="viewFormulationModal" aria-hidden="true">
					  <div class="modal-dialog modal-lg">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Edit formula</h4>
						  </div>
						  <div class="modal-body">
							<form style="margin-top: 1rem;" id="editFormulaForm">
							  <input type="hidden" name="formula_id">
							  <div class="form-body">
								<div class="row">
								  <div class="col-sm-6">
									<div class="form-group">
									  <label for="effFormulaName">
										Formula Name
										<span class="required">*</span>
									  </label>
									  <div>
										<input class="form-control" type="text" name="formula_name" id="effFormulaName"
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
										<input class="form-control" type="text" name="formula_code" id="effFomulaCode"
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
										<input class="form-control" type="text" name="version_number" id="effVersionNumber"
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
										<select name="status" id="affStatus" class="form-control">
										  <option value="" selected disabled>--Select--</option>
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
										<input class="form-control" type="date" name="status_date" id="affStatusDate"
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
										<input class="form-control" type="text" name="serving_size" id="affServingSize"
										  placeholder="Enter grams per serving (size)">
									  </div>
									</div>
								  </div>
								</div>
								<div class="row">
								  <h4 class="col-sm-12">Ingredients</h4>
								  <div class="col-sm-12">
									<div class="table-responsive">
									  <table class="table table-bordered table-hover addIngredientsTable" style="margin-bottom: 0;">
										<thead>
										  <tr>
											<th rowspan="2"></th>
											<th rowspan="2">Ingredient</th>
											<th rowspan="2">Amt/srv, g</th>
											<th rowspan="2">Formulation</th>
											<th colspan="3">Cost per serving</th>
										  </tr>
										  <tr>
											<th>lb</th>
											<th>oz</th>
											<th>kg</th>
										  </tr>
										</thead>
										<tbody id="viewIngredientsListBody">
										  <tr id="viewIngredientsAddNewItem">
											<td>
											  <label class="mt-checkbox mt-checkbox-outline" style="visibility: hidden;">
												<input type="checkbox" checked class="ingredient-check">
												<span></span>
											  </label>
											</td>
											<td>
											  <select id="editIngredientsSearch" class="form-control">
												<option value="" selected="selected">Find ingredients by its name, id or manufacturer
												</option>
											  </select>
											  <input type="hidden" id="edit-selectedIngredientId">
											</td>
											<td>
											  <input type="number" class="form-control" value="0"
												id="edit-selectedIngredientAmountPerServing">
											</td>
											<td colspan="4">
											  <div style="text-align: left;">
												<button type="button" class="btn blue edit-addIngredientButton">
												  <i class="fa fa-plus"></i>
												  Add
												</button>
												<span class="text-danger hide edit-addIngredientButton-error">Select an item first</span>
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
										<input type="text" class="form-control semi-bold process-title edit-addNewInstructionInput"
										  placeholder="Enter new process name here...">
									  </div>
									  <div class="col-sm-3">
										<button type="button" class="btn blue edit-addNewInstructionBtn">
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
							<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							<button type="button" onclick="$('#editFormulaForm').submit()" class="btn green">
							  Submit
							</button>
						  </div>
						</div>
						<!-- /.modal-content -->
					  </div>
					  <!-- /.modal-dialog -->
					</div>

        <?php include_once ('footer.php'); ?>

        <script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

        <script type="text/javascript">
        	const convert = {
			    lb(g) {
			        return (0.00220462 * parseFloat(g)).toFixed(2);
			    },
			    oz(g) {
			        return (0.035274 * parseFloat(g)).toFixed(2);
			    },
			    kg(g) {
			        return (0.001 * parseFloat(g)).toFixed(2);
			    }
			}

			const POST = async function(jsonObj, formData = null) {
			  try {
			    const fData = formData ? new FormData(formData) : new FormData();
			    Object.keys(jsonObj).forEach(key => {
			      fData.append(key, jsonObj[key]);
			    });
			    
			    const response = await fetch('formulation-api.php', {
			        method: 'POST',
			        body: fData
			    })

			    return response.json();

			  } catch(err) {
			    console.error(err)
			  }
			}

			const checkIngredientsListSize = function() {
			  if($('#ingredientsListBody').find('tr').length == 0) {
			      $('.emptyIngredientsList').removeClass('hide');
			  } else {
			      $('.emptyIngredientsList').addClass('hide');
			  }
			}

			/**
			 * ===================================
			 * page functions
			 */

			// initializing ingredients search select2 element
			function init_ingredientsSearchSelect2() {
			   // @see https://select2.github.io/examples.html#data-ajax
			   function formatRepo(repo) {
                if (repo.loading) return repo.material_name;
            
                var markup =
                  "<div class='select2-result-repository clearfix'>" +
                  "<div class='select2-result-repository__meta'>" +
                  "<div class='select2-result-repository__title'>" +
                  (repo.material_name || "") +
                  "</div>";
            
                if (repo.description) {
                  markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
                }
            
                markup +=
                  "<div class='select2-result-repository__statistics'>" +
                  "<div class='select2-result-repository__forks'><span>PPU: </span> " +
                  (repo.material_ppu || "<i>Not set</i>") +
                  "</div>" +
                  "<div class='select2-result-repository__watchers'><span>Material ID: </span> " +
                  repo.material_id +
                  "</div>" +
                  "</div>" +
                  "</div></div>";
            
                return markup;
              }
            
              function formatRepoSelection(repo) {
                $("#selectedIngredientId").val(repo.id); // set the selected material id to the hidden input
                return repo.material_name || repo.description;
              }
              function editFormatRepoSelection(repo) {
                $("#edit-selectedIngredientId").val(repo.id); // set the selected material id to the hidden input
                return repo.material_name || repo.description;
              }

			  const ajaxObj = {
			      url: "formulation-api.php",
			      dataType: 'json',
			      method: 'POST',
			      delay: 250,
			      data: function(params) {
			          return {
			              q: params.term, // search term
			              page: params.page,
			              method: 'getAllMaterials'
			          };
			      },
			      processResults: function(data, page) {
			          // parse the results into the format expected by Select2.
			          // since we are using custom formatting functions we do not need to
			          // alter the remote JSON data
			          return {
			              results: data.items
			          };
			      },
			      cache: true
			  };

			  $("#ingredientsSearch").select2({
			      width: "100%",
			      ajax: ajaxObj,
			      escapeMarkup: function(markup) {
			          return markup;
			      }, // let our custom formatter work
			      minimumInputLength: 1,
			      templateResult: formatRepo,
			      templateSelection:formatRepoSelection
			  });

			  $("#editIngredientsSearch").select2({
			    width: "100%",
			    ajax: ajaxObj,
			    escapeMarkup: function(markup) {
			        return markup;
			    }, // let our custom formatter work
			    minimumInputLength: 1,
			    templateResult: formatRepo,
			    templateSelection:editFormatRepoSelection
			});
			}

			// =================================== start~
			// adding new ingredients to the list
			function init_addIngredientsButton() {
			    const materialId = $('#selectedIngredientId');
			    const amountPerServing = $('#selectedIngredientAmountPerServing');
			    const addIngredientHelper = $('.add-ingredient-helper');
			    const ingredientsList = $('#ingredientsListBody');

			    $('.addIngredientBtn').on('click', function() {
			        if(materialId.val() == '' || amountPerServing.val() == '') {
			            addIngredientHelper.removeClass('hide');
			            return;
			        }

			        POST({
			          method: 'getMaterialById',
			          id: materialId.val()
			        }).then(data => {
			            // writing data
			            ingredientsList.append(createIngredientRowItem(data, amountPerServing.val(), ingredientsList));
			            checkIngredientsListSize();
			            
			            // reseting the fields
			            materialId.val('');
			            amountPerServing.val('');
			            addIngredientHelper.addClass('hide');
			            $("#ingredientsSearch").val('').trigger('change');
			        })
			    })
			}
			// creating table row element
			function createIngredientRowItem(data, amountPerServing, container) {
			  const row = document.createElement('tr');
			  row.innerHTML = `
			      <td>
                    <input type="hidden" class="material-id" value="${data.ID}" />
                      <label class="mt-checkbox mt-checkbox-outline">
                          <input type="checkbox" checked class="ingredient-check">
                          <span></span>
                      </label>
                  </td>
                  <td>
                      <div class="ingredient-block">
                        <div>
                            <p class="ingredient-name">${data.material_name}</p>
                            <p class="ingredient-details">
                            Product Code:
                            <span>${data.material_id}</span>
                            </p>
                        </div>
                      </div>
                  </td>
                  <td>
                      <input type="number" step="0.01" class="amount-per-serving-in-ingredients-table" value="${amountPerServing}">
                  </td>
			      <td class="t-percentFormulation">0.00%</td>
			      <td class="t-cps-lb">${convert.lb(amountPerServing)}</td>
			      <td class="t-cps-oz">${convert.oz(amountPerServing)}</td>
			      <td class="t-cps-kg">${convert.kg(amountPerServing)}</td>`;

			  bindDOMEvents(row, container);
			  setTimeout(() => updateFormulationMath(container), 200);

			  return $(row);
			}
			// binding events to the row elements that need it
			function bindDOMEvents(el, container) {
			  $(el).find('.ingredient-check').on('change', function() {
			      if(!$(this).prop('checked')) {
			          if(confirm('Confirm remove this ingredient/item?')) {
			              el.remove();
			              updateFormulationMath(container);

			              if(container.prop('id') == 'ingredientsListBody')
			                checkIngredientsListSize();
			          } else {
			              $(this).prop('checked', true);
			          }
			      }
			  });

			  $(el).find('.amount-per-serving-in-ingredients-table').on('change', function() {
			      updateFormulationMath(container);
			  });

			  $(el).find('.amount-per-serving-in-ingredients-table').on('focusout', function() {
			      if($(this).val() == '') {
			          $(this).val(0);
			      }
			      updateFormulationMath(container);
			  });

			  return el;
			}
			// updating the total amount per serving display
			function updateFormulationMath(ingredientsList) {
			  let sum = 0;
			  ingredientsList.find('.amount-per-serving-in-ingredients-table').each((i, el) => {
			      const value = parseFloat($(el).val());
			      sum += value;
			  });

			  ingredientsList.find('.amount-per-serving-in-ingredients-table').each((i, el) => {
			      const value = parseFloat($(el).val());

			      $(el).parent().next().text(((value / sum) * 100).toFixed(2) + '%')

			      $(el).parent().siblings('.t-cps-lb').text(convert.lb(value));
			      $(el).parent().siblings('.t-cps-oz').text(convert.oz(value));
			      $(el).parent().siblings('.t-cps-kg').text(convert.kg(value));
			  });

			  $('.totalAmountPerServing').text(sum.toFixed(3));
			  $('.PercentFormulation').text('100%');
			}
			// =================================== end~

			// adding instructions
			function init_addInstructionsButton() {
			    const list = $('#processesList');

			    $('.addNewProcessBtn').on('click', function() {
			        createProcessBlock();
			    });

			    $('.addNewProcessBtn').click();

			    // creating process block element (dom)
			    function createProcessBlock() {
			        const row = document.createElement('div');
			        row.setAttribute('class', 'row process-block');
			        row.innerHTML = `
			              <div class="col-sm-2">
			                <h5>Process Name</h5>
			              </div>
			              <div class="col-sm-7">
			                <input type="text" class="form-control semi-bold process-title" placeholder="Enter new process name here...">
			              </div>
			              <div class="col-sm-3">
			                Actions:
			                <div class="btn-group btn-group-solid">
			                  <button type="button" class="btn white toggleStepViewBtn">
			                    <i class="fa fa-angle-down"></i>
			                    <i class="fa fa-angle-up hide"></i>
			                  </button>
			                  <button type="button" class="btn white removeProcessBtn">
			                    <i class="fa fa-trash-o"></i>
			                  </button>
			                  <div class="btn white dragProcessBtn">
			                    <i class="fa fa-hand-stop-o"></i>
			                  </div>
			                </div>
			              </div>
			              <div class="col-sm-12 stepsContainer" style="display: none;">
			                <div class="row">
			                  <div class="col-sm-2">
			                    <h5>Steps</h5>
			                  </div>
			                  <div class="col-sm-7">
			                    <ol class="steps-list">
			                        <li><textarea rows="2" class="form-control step-item" placeholder="Instruction..."></textarea></li>
			                    </ol>
			                  </div>
			                </div>
			              </div>`;
			        $(row).find('.steps-list li textarea').on('keypress', function(event) {
			            if(event.ctrlKey && event.key == '\n') {
			                createNewStepBlockElement($(this).parent());
			            }
			        });
			        
			        list.append(bindDOMEvents(row));
			    }

			    // binding events to the process block element
			    function bindDOMEvents(el) {
			        $(el).find('.toggleStepViewBtn').on('click',  function() {
			            $(this).find('.fa-angle-down').toggleClass('hide');
			            $(this).find('.fa-angle-up').toggleClass('hide');

			            if($(this).find('.fa-angle-down').hasClass('hide')) {
			                $(el).find('.stepsContainer').slideDown('linear');
			            } else {
			                $(el).find('.stepsContainer').hide();
			            }
			        });

			        $(el).find('.removeProcessBtn').on('click',  function() {
			            el.remove();
			        });

			        $(el).find('.dragProcessBtn').on('mousedown',  function() {
			            $(el).find('.fa-angle-down').removeClass('hide');
			            $(el).find('.fa-angle-up').addClass('hide');

			            if($(el).find('.fa-angle-down').hasClass('hide')) {
			                $(el).find('.stepsContainer').slideDown('linear');
			            } else {
			                $(el).find('.stepsContainer').hide();
			            }
			        });

			        // initializing draggable function
			        list.sortable({
			            connectWith: ".process-block",
			            items: ".process-block", 
			            opacity: 0.8,
			            handle : '.dragProcessBtn',
			            revert: 250, // animation in milliseconds
			        });
			        
			        return el;
			    }

			    // adding step element
			    function createNewStepBlockElement(el) {
			        const item = document.createElement('li');
			        item.innerHTML = `<textarea rows="2" class="form-control" placeholder="Instruction..."></textarea>`;

			        $(item).find('textarea').on('keypress', function(event) {
			            if(event.ctrlKey && event.key == '\n') {
			                createNewStepBlockElement($(item));
			            }
			        });

			        $(item).find('textarea').on('keydown', function(event) {
			            if(event.key == 'Backspace') {

			                if($(this).val() == '') {
			                    $(item).prev().find('textarea').focus();
			                    item.remove();
			                }
			            }
			        });

			        $(item).insertAfter($(el));
			        $(item).find('textarea').focus();
			    }
			}

			// initialize formula form validation
			function init_FormulaFormValidation() {
			    var form1 = $('#formulaForm');
			    var error1 = $('.alert-danger', form1);
			    var success1 = $('.alert-success', form1);

			    form1.validate({
			        errorElement: 'span', //default input error message container
			        errorClass: 'help-block help-block-error', // default input error message class
			        focusInvalid: false, // do not focus the last invalid input
			        ignore: "",  // validate all fields including form hidden input
			        rules: {
			            formula_name: {
			                required: true,
			            },
			            formula_code: {
			                required: true,
			            },
			            status: {
			                required: true,
			            },
			            status_date: {
			                required: true,
			            },
			            serving_size: {
			                required: true,
			                min: 0.001
			            }
			        },

			        invalidHandler: function (event, validator) { //display error alert on form submit              
			            success1.hide();
			            error1.show();
			            App.scrollTo(error1, -200);
			        },

			        errorPlacement: function (error, element) { // render error placement for each input type
			            var cont = $(element).parent('.input-group');
			            if (cont) {
			                cont.after(error);
			            } else {
			                element.after(error);
			            }
			        },

			        highlight: function (element) { // hightlight error inputs

			            $(element)
			                .closest('.form-group').addClass('has-error'); // set error class to the control group
			        },

			        unhighlight: function (element) { // revert the change done by hightlight
			            $(element)
			                .closest('.form-group').removeClass('has-error'); // set error class to the control group
			        },

			        success: function (label) {
			            label
			                .closest('.form-group').removeClass('has-error'); // set success class to the control group
			        },

			        submitHandler: function (form, event) {
			          event.preventDefault();

			          const ingredients = [];
			          const instructions = [];

			          // extracting ingredients data from table 
			          $('#ingredientsListBody tr').each((i, row) => {
			            ingredients.push({
			              id: $(row).find('.material-id').val(),
			              serving: $(row).find('.amount-per-serving-in-ingredients-table').val()
			            })
			          });

			          // extracting processes from the input
			          $('#processesList .process-block').each((i, el) => {
			            const steps = [];

			            $(el).find('.steps-list textarea').each((i, input) => steps.push($(input).val()));
			            
			            instructions.push({
			              title: $(el).find('.process-title').val(),
			              instructions: steps
			            })
			          });

			          POST({
			            method: 'addNewFormula',
			            ingredients: JSON.stringify(ingredients),
			            instructions: JSON.stringify(instructions)
			          }, event.target)
			          .then(data => {
			            if(data.success) {
			              alert('Added successfully')
			              location.reload();
			            } else {
			              console.log(data)
			            }
			          });
			        }
			    });
			}

			// initialize database
			function init_FormulaDataTable() {
			  var table = $('#formulaTable');
			  
			    table.dataTable({
			  
			        // Internationalisation. For more info refer to http://datatables.net/manual/i18n
			        "language": {
			            "aria": {
			                "sortAscending": ": activate to sort column ascending",
			                "sortDescending": ": activate to sort column descending"
			            },
			            "emptyTable": "No data available in table",
			            "info": "Showing _START_ to _END_ of _TOTAL_ items",
			            "infoEmpty": "No items found",
			            "infoFiltered": "(filtered1 from _MAX_ total items)",
			            "lengthMenu": "Show _MENU_",
			            "search": "Search:",
			            "zeroRecords": "No matching items found",
			            "paginate": {
			                "previous":"Prev",
			                "next": "Next",
			                "last": "Last",
			                "first": "First"
			            }
			        },
			  
			        // Or you can use remote translation file
			        //"language": {
			        //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
			        //},
			  
			        // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
			        // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
			        // So when dropdowns used the scrollable div should be removed. 
			        //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
			  
			        "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
			  
			        "lengthMenu": [
			            [10, 25, 50, -1],
			            [10, 25, 50., "All"] // change per page values here
			        ],
			        // set the initial value
			        "pageLength": 5,            
			        "pagingType": "bootstrap_full_number",
			        // "columnDefs": [
			        //     {  // set default column settings
			        //         'orderable': false,
			        //         'targets': 'all'
			        //     }, 
			        //     {
			        //         "searchable": false,
			        //         "targets": 'all'
			        //     }
			        // ],
			        "order": [
			            [0, "desc"]
			        ] // set first column as a default sort by asc
			    });
			}

			// display formula details in button click (edit button)
			function init_EditFormulaButton() {
			  $('#viewFormulationModal').on('hidden.bs.modal', function() {
			    appendViewModalFields({});
			    $('#viewIngredientsListBody tr:not(#viewIngredientsAddNewItem)').each((i, el) => {
			      el.remove();
			    })
			    $('.e-process-container > .e-process-block').each((i, el) => {
			      el.remove();
			    })
			  });
			  
			  const editFormulaForm = $('#editFormulaForm');
			  $('[href="#viewFormulationModal"]').on('click', function(event) {
			    event.preventDefault();
			    const formulaId = $(this).attr('data-id');
			    

			    POST({
			      method: 'getFormulaById',
			      id: formulaId
			    }).then(data => {
			      $('#editFormulaForm').find('[name=formula_id]').val(formulaId);
			      
			      appendViewModalFields(data);
			      data.ingredients.forEach(ing => {
			        const newItem = createIngredientRowItem(ing.material, ing.serving, $('#viewIngredientsListBody'));
			        newItem.insertBefore('#viewIngredientsAddNewItem');
			      });

			      data.instructions.forEach(ins => {
			        createInstructionBlockItem(ins, $('.e-process-container')).insertBefore('.e-process-block-add-new');
			      });

			      $('#viewFormulationModal').modal('show');
			    });
			  });

			  $('.edit-addIngredientButton').on('click', function() {
			    const materialId = $('#edit-selectedIngredientId');
			    const amountPerServing = $('#edit-selectedIngredientAmountPerServing');
			    const addIngredientHelper = $('.edit-addIngredientButton-error');
			    const ingredientsList = $('#viewIngredientsListBody');

			      if(materialId.val() == '' || amountPerServing.val() == '') {
			          addIngredientHelper.removeClass('hide');
			          return;
			      }

			      POST({
			        method: 'getMaterialById',
			        id: materialId.val()
			      }).then(data => {
			          // writing data
			          createIngredientRowItem(data, amountPerServing.val(), ingredientsList).insertBefore('#viewIngredientsAddNewItem');
			          checkIngredientsListSize();
			          
			          // reseting the fields
			          materialId.val('');
			          amountPerServing.val('');
			          addIngredientHelper.addClass('hide');
			          $("#editIngredientsSearch").val('').trigger('change');
			      })
			  });

			  $('.edit-addNewInstructionBtn').on('click', function() {
			    createInstructionBlockItem({title: '', instructions: ['']}, $('.e-process-container')).insertBefore('.e-process-block-add-new');
			  });

			  // create isntruction block
			  function createInstructionBlockItem(data, container) {
			    const block = document.createElement('div');
			    block.setAttribute('class',  'row e-process-block');
			    block.innerHTML  = `
			      <div class="col-sm-2">
			        <h5>Process Name</h5>
			      </div>
			      <div class="col-sm-7">
			        <input type="text" class="form-control semi-bold process-title"
			          placeholder="Enter new process name here..." value="${data.title}">
			      </div>
			      <div class="col-sm-3">
			        <div class="btn-group btn-group-solid">
			          <button type="button" class="btn white removeProcessBtn">
			            <i class="fa fa-trash-o"></i>
			          </button>
			        </div>
			      </div>
			      <div class="col-sm-12 stepsContainer">
			        <div class="row">
			          <div class="col-sm-2">
			            <h5>Steps</h5>
			          </div>
			          <div class="col-sm-7">
			            <ol class="steps-list"></ol>
			          </div>
			        </div>
			      </div>`;

			    data.instructions.forEach(i => {
			      createNewStepElement(i, $(block).find('.steps-list'));
			    });

			    // ===== events
			    $(block).find('.removeProcessBtn').on('click',  function() {
			      if(confirm('Remove this item?'))
			        block.remove();
			    });

			    return $(block);
			  }

			  // 
			  function createNewStepElement(text, container, currEl = null) {
			    const item = document.createElement('li');
			    item.innerHTML = `<textarea rows="2" class="form-control" placeholder="Instruction...">${text}</textarea>`;

			    $(item).find('textarea').on('keypress', function(event) {
			        if(event.ctrlKey && event.key == '\n') {
			          createNewStepElement('', container, item);
			        }
			    });

			    $(item).find('textarea').on('keydown', function(event) {
			        if(event.key == 'Backspace') {
			          if(container.find('li').length == 1)
			            return;
			          
			          if($(this).val() == '') {
			              $(item).prev().find('textarea').focus();
			              item.remove();
			          }
			        }
			    });

			    if(currEl)
			      $(item).insertAfter($(currEl));
			    else 
			      container.append(item);

			    $(item).find('textarea').focus();
			  }
			}
			// append formula details
			function appendViewModalFields(data) {
			  $('#editFormulaForm').find('[name=formula_name]').val(data.name || '');
			  $('#editFormulaForm').find('[name=formula_code]').val(data.formula_code || '');
			  $('#editFormulaForm').find('[name=version_number]').val(data.version_number || '');
			  $('#editFormulaForm').find('[name=status]').val(data.status || '');
			  $('#editFormulaForm').find('[name=status_date]').val(data.status_date || '');
			  $('#editFormulaForm').find('[name=serving_size]').val(data.serving_size || '');
			  $('#editFormulaForm').find('[name=formula_id]').val(data.id || '');
			}

			// initialize formula form validation for edit form
			function init_editFormulaFormValidation() {
			  var form1 = $('#editFormulaForm');
			  var error1 = $('.alert-danger', form1);
			  var success1 = $('.alert-success', form1);

			  form1.validate({
			      errorElement: 'span', //default input error message container
			      errorClass: 'help-block help-block-error', // default input error message class
			      focusInvalid: false, // do not focus the last invalid input
			      ignore: "",  // validate all fields including form hidden input
			      rules: {
			          formula_name: {
			              required: true,
			          },
			          formula_code: {
			              required: true,
			          },
			          status: {
			              required: true,
			          },
			          status_date: {
			              required: true,
			          },
			          serving_size: {
			              required: true,
			              min: 0.001
			          }
			      },

			      invalidHandler: function (event, validator) { //display error alert on form submit              
			          success1.hide();
			          error1.show();
			          App.scrollTo(error1, -200);
			      },

			      errorPlacement: function (error, element) { // render error placement for each input type
			          var cont = $(element).parent('.input-group');
			          if (cont) {
			              cont.after(error);
			          } else {
			              element.after(error);
			          }
			      },

			      highlight: function (element) { // hightlight error inputs

			          $(element)
			              .closest('.form-group').addClass('has-error'); // set error class to the control group
			      },

			      unhighlight: function (element) { // revert the change done by hightlight
			          $(element)
			              .closest('.form-group').removeClass('has-error'); // set error class to the control group
			      },

			      success: function (label) {
			          label
			              .closest('.form-group').removeClass('has-error'); // set success class to the control group
			      },

			      submitHandler: function (form, event) {
			        event.preventDefault();

			        const ingredients = [];
			        const instructions = [];

			        // extracting ingredients data from table 
			        $('#viewIngredientsListBody tr:not(#viewIngredientsAddNewItem)').each((i, row) => {
			          ingredients.push({
			            id: $(row).find('.material-id').val(),
			            serving: $(row).find('.amount-per-serving-in-ingredients-table').val()
			          });
			        });

			        // extracting processes from the input
			        $('.e-process-container .e-process-block').each((i, el) => {
			          const steps = [];

			          $(el).find('.steps-list textarea').each((i, input) => steps.push($(input).val()));
			          
			          instructions.push({
			            title: $(el).find('.process-title').val(),
			            instructions: steps
			          })
			        });

			        POST({
			          method: 'updateFormula',
			          ingredients: JSON.stringify(ingredients),
			          instructions: JSON.stringify(instructions)
			        }, event.target)
			        .then(data => {
			          if(data.success) {
			            alert('Updated successfully')
			            location.reload();
			          } else {
			            console.log(data)
			          }
			        });
			      }
			  });
			}

			// removing formula
			function init_RemoveFormulaBtn() {
			  $('.removeFormulBtn').on('click', function() {
			    if(confirm("Do you really wish to remove this formula?")) {
			      POST({
			        method: 'deleteFormula',
			        id: $(this).attr('data-id')
			      }).then(res => {
			        if(res.success) {
			          alert('Item removed!')
			          location.reload();
			        }
			      })
			    }
			  });
			}

			addEventListener('load', function() {
			  init_ingredientsSearchSelect2();
			  init_addIngredientsButton();
			  init_addInstructionsButton();
			  init_FormulaFormValidation();
			  init_FormulaDataTable();
			  init_EditFormulaButton();
			  init_editFormulaFormValidation();
			  init_RemoveFormulaBtn();
			})
        </script>

    </body>
</html>
