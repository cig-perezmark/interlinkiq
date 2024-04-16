const convert = {
  lb(g) {
    return (0.00220462 * parseFloat(g)).toFixed(2);
  },
  oz(g) {
    return (0.035274 * parseFloat(g)).toFixed(2);
  },
  kg(g) {
    return (0.001 * parseFloat(g)).toFixed(2);
  },
};

const foodUnits = "g,c,lb,tbsp,tsp,oz,fl. oz,mL,L,pt,gal,qt,pc";

const POST = async function (jsonObj, formData = null) {
  try {
    const fData = formData ? new FormData(formData) : new FormData();
    Object.keys(jsonObj).forEach((key) => {
      fData.append(key, jsonObj[key]);
    });

    const response = await fetch("formulationv2/api/index.php", {
      method: "POST",
      body: fData,
    });

    return response.json();
  } catch (err) {
    console.error(err);
  }
};

const checkIngredientsListSize = function () {
  if ($("#ingredientsListBody").find("tr").length == 0) {
    $(".emptyIngredientsList").removeClass("hide");
  } else {
    $(".emptyIngredientsList").addClass("hide");
  }
};

/**
 * ===================================
 * page functions
 */

// initializing ingredients search select2 element
function init_ingredientsSearchSelect2() {
  // @see https://select2.github.io/examples.html#data-ajax
  function formatRepo(repo) {
    if (repo.loading) return repo.material_name;

    var markup = `
      <div class="select2-result-repository clearfixx"> 
        <div class="select2-result-repository__metax"> 
          <div class="select2-result-repository__title">${repo.material_name || ""}</div>
          ${repo.description ? `<div class="select2-result-repository__description">${repo.description}</div>` : ""}
          <div class="select2-result-repository__statistics"> 
            <div class="select2-result-repository__forks">
              <span>PPU: </span> ${repo.material_ppu || "<i>Not set</i>"} 
            </div> 
            <div class="select2-result-repository__watchers">
              <span>Material ID: </span> ${repo.material_id} 
            </div>
            <br>
            <div class="select2-result-repository__watchers">
                <span>Supplier: </span> ${repo.s_name} 
            </div> <br>
            <div class="select2-result-repository__watchers">
                <span>Status: </span> ${repo.s_status} 
            </div>
          </div> 
        </div>
      </div>
    `;

    return markup;
  }

  function formatRepoSelection(repo) {
    $("#selectedIngredientId").val(repo.id); // set the selected material id to the hidden input
    return repo.material_name || repo.text;
  }
  function editFormatRepoSelection(repo) {
    $("#edit-selectedIngredientId").val(repo.id); // set the selected material id to the hidden input
    if (repo.material_name) {
      $(".edit-addIngredientButton-error").addClass("hide");
    }
    return repo.material_name || repo.text;
  }

  const ajaxObj = {
    url: "formulationv2/api/index.php",
    dataType: "json",
    method: "POST",
    delay: 250,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page,
        method: "getAllMaterials",
      };
    },
    processResults: function (data, page) {
      // parse the results into the format expected by Select2.
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data
      return {
        results: data.items,
      };
    },
    cache: true,
  };

  $("#ingredientsSearch").select2({
    width: "100%",
    ajax: ajaxObj,
    escapeMarkup: function (markup) {
      return markup;
    }, // let our custom formatter work
    minimumInputLength: 1,
    templateResult: formatRepo,
    templateSelection: formatRepoSelection,
  });

  $("#editIngredientsSearch").select2({
    width: "100%",
    ajax: ajaxObj,
    escapeMarkup: function (markup) {
      return markup;
    }, // let our custom formatter work
    minimumInputLength: 1,
    templateResult: formatRepo,
    templateSelection: editFormatRepoSelection,
  });
}

// =================================== start~
// adding new ingredients to the list
function init_addIngredientsButton() {
  const materialId = $("#selectedIngredientId");
  const amountPerServing = $("#selectedIngredientAmountPerServing");
  const addIngredientHelper = $(".add-ingredient-helper");
  const ingredientsList = $("#ingredientsListBody");

  $(".addIngredientBtn").on("click", function () {
    // $("#materialConversionModal").modal("show");
    // return;
    if (materialId.val() == "") {
      addIngredientHelper.removeClass("hide");
      return;
    }

    POST({
      method: "getMaterialById",
      id: materialId.val(),
    }).then((data) => {
      // writing data
      ingredientsList.append(
        createIngredientRowItem(
          data,
          {
            amount: Number(amountPerServing.val()) || 0,
            unit: $("#units-o-m").val(),
            grams: 0,
          },
          ingredientsList
        )
      );
      checkIngredientsListSize();

      // reseting the fields
      materialId.val("");
      amountPerServing.val("");
      addIngredientHelper.addClass("hide");
      $("#ingredientsSearch").val("").trigger("change");
    });
  });
}
// creating table row element
function createIngredientRowItem(data, serving, container) {
  let grams, amount, unit;
  if (typeof serving === "string") {
    grams = 1;
    amount = Number(serving) || 0;
    unit = "g";
  } else if (typeof serving === "object") {
    grams = serving.unit == "g" ? 1 : serving.grams;
    amount = serving.amount;
    unit = serving.unit;
  }
  const row = document.createElement("tr");
  const price = (Number(data.material_ppu) * grams * amount) / Number(data.material_count) || 0;
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
                  SKU: <span>${data.material_id}</span>
                </p>
            </div>
          </div>
      </td>
      <td data-amount-serving class="amt-srv">
        <input type="number" style="width: 6rem" step="0.01" 
          class="amount-per-serving-in-ingredients-table form-control"
          data-amount="${amount}" data-ppu="${data.material_ppu || 1}" 
          data-count="${data.material_count || 1}" value="${amount}">
      </td>
      <td>
        <select style="width:5.5rem" class="form-control" data-unit onchange="showConversion(event)">
          ${foodUnits
            .split(",")
            .map((x) => `<option value="${x}" ${unit == x ? "selected" : ""}>${x}</option>`)
            .join("")}
        </select>
      </td>
      <td>
        <input data-converter type="number" style="width: 6rem" class="form-control" data-grams value="${grams}" 
        ${unit == "g" ? "disabled" : ""} />
      </td>
      <td class="t-price">${price.toFixed(2)}</td>
      <td class="t-percentFormulation">0.00%</td>
      <td class="t-cps-lb">${convert.lb(amount)}</td>
      <td class="t-cps-oz">${convert.oz(amount)}</td>
      <td class="t-cps-kg">${convert.kg(amount)}</td>`;

  bindDOMEvents(row, container);
  setTimeout(() => updateFormulationMath(container), 200);
  return $(row);
}
function hideConversion(evt) {
  const table = evt.target.closest("table");
  evt.target.closest("a").classList.toggle("is-hide");
  $(table).find("[data-converter]")[evt.target.closest("a").classList.contains("is-hide") ? "fadeOut" : "fadeIn"]();
}
function showConversion(evt) {
  const parent = evt.target.closest("tr");
  if (evt.target.value == "g") {
    $(parent).find("[data-grams]").val("1").prop("disabled", true);
  } else {
    $(parent).find("[data-grams]").removeAttr("disabled");
  }
}
// binding events to the row elements that need it
function bindDOMEvents(el, container) {
  $(el)
    .find(".ingredient-check")
    .on("change", function () {
      if (!$(this).prop("checked")) {
        if (confirm("Confirm remove this ingredient/item?")) {
          el.remove();
          updateFormulationMath(container);

          if (container.prop("id") == "ingredientsListBody") checkIngredientsListSize();
        } else {
          $(this).prop("checked", true);
        }
      }
    });

  $(el)
    .find(".form-control")
    .on("keyup change", function () {
      updateFormulationMath(container);
    });
  return el;
}
// updating the total amount per serving display
function updateFormulationMath(ingredientsList) {
  let sum = 0;
  let totalPrice = 0;
  ingredientsList.find("tr:has([data-amount-serving])").each((i, el) => {
    const amount = parseFloat($(el).find("[data-amount]").val()) || 0;
    const grams = parseFloat($(el).find("[data-grams]").val()) || 0;
    const ppu = parseFloat($(el).find("[data-ppu]").data("ppu")) || 0;
    const count = parseFloat($(el).find("[data-count]").data("count")) || 0;
    sum += amount * grams;
    totalPrice += (ppu * (amount * grams)) / count;
  });

  ingredientsList.find("tr:has([data-amount-serving])").each((i, el) => {
    const amount = parseFloat($(el).find("[data-amount]").val()) || 0;
    const grams = parseFloat($(el).find("[data-grams]").val()) || 0;
    const ppu = parseFloat($(el).find("[data-ppu]").data("ppu")) || 0;
    const count = parseFloat($(el).find("[data-count]").data("count")) || 0;
    const row = $(el.closest("tr"));
    const value = amount * grams;

    const formula = value / sum || 0;

    $(row)
      .find(".t-percentFormulation")
      .text((formula * 100).toFixed(2) + "%");

    $(row)
      .find(".t-price")
      .text(((Number(ppu) * grams * amount) / Number(count)).toFixed(2));

    $(row).find(".t-cps-lb").text(convert.lb(value));
    $(row).find(".t-cps-oz").text(convert.oz(value));
    $(row).find(".t-cps-kg").text(convert.kg(value));
  });

  $(".totalAmountPerServing").text(sum.toFixed(3));
  $(".TotalPrice").text(totalPrice.toFixed(2));
  $(".PercentFormulation").text("100%");
}
// =================================== end~

// adding instructions
function init_addInstructionsButton() {
  const list = $("#processesList");

  $(".addNewProcessBtn").on("click", function () {
    createProcessBlock();
  });

  $(".addNewProcessBtn").click();

  // creating process block element (dom)
  function createProcessBlock() {
    const row = document.createElement("div");
    row.setAttribute("class", "row process-block");
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
    $(row)
      .find(".steps-list li textarea")
      .on("keypress", function (event) {
        if (event.ctrlKey && event.key == "\n") {
          createNewStepBlockElement($(this).parent());
        }
      });

    list.append(bindDOMEvents(row));
  }

  // binding events to the process block element
  function bindDOMEvents(el) {
    $(el)
      .find(".toggleStepViewBtn")
      .on("click", function () {
        $(this).find(".fa-angle-down").toggleClass("hide");
        $(this).find(".fa-angle-up").toggleClass("hide");

        if ($(this).find(".fa-angle-down").hasClass("hide")) {
          $(el).find(".stepsContainer").slideDown("linear");
        } else {
          $(el).find(".stepsContainer").hide();
        }
      });

    $(el)
      .find(".removeProcessBtn")
      .on("click", function () {
        el.remove();
      });

    $(el)
      .find(".dragProcessBtn")
      .on("mousedown", function () {
        $(el).find(".fa-angle-down").removeClass("hide");
        $(el).find(".fa-angle-up").addClass("hide");

        if ($(el).find(".fa-angle-down").hasClass("hide")) {
          $(el).find(".stepsContainer").slideDown("linear");
        } else {
          $(el).find(".stepsContainer").hide();
        }
      });

    // initializing draggable function
    list.sortable({
      connectWith: ".process-block",
      items: ".process-block",
      opacity: 0.8,
      handle: ".dragProcessBtn",
      revert: 250, // animation in milliseconds
    });

    return el;
  }

  // adding step element
  function createNewStepBlockElement(el) {
    const item = document.createElement("li");
    item.innerHTML = `<textarea rows="2" class="form-control" placeholder="Instruction..."></textarea>`;

    $(item)
      .find("textarea")
      .on("keypress", function (event) {
        if (event.ctrlKey && event.key == "\n") {
          createNewStepBlockElement($(item));
        }
      });

    $(item)
      .find("textarea")
      .on("keydown", function (event) {
        if (event.key == "Backspace") {
          if ($(this).val() == "") {
            $(item).prev().find("textarea").focus();
            item.remove();
          }
        }
      });

    $(item).insertAfter($(el));
    $(item).find("textarea").focus();
  }
}

// initialize formula form validation
function init_FormulaFormValidation() {
  var form1 = $("#formulaForm");
  var error1 = $(".alert-danger", form1);
  var success1 = $(".alert-success", form1);

  form1.validate({
    errorElement: "span", //default input error message container
    errorClass: "help-block help-block-error", // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    ignore: "", // validate all fields including form hidden input
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
        min: 0.001,
      },
    },

    invalidHandler: function (event, validator) {
      //display error alert on form submit
      success1.hide();
      error1.show();
      App.scrollTo(error1, -200);
    },

    errorPlacement: function (error, element) {
      // render error placement for each input type
      var cont = $(element).parent(".input-group");
      if (cont) {
        cont.after(error);
      } else {
        element.after(error);
      }
    },

    highlight: function (element) {
      // hightlight error inputs

      $(element).closest(".form-group").addClass("has-error"); // set error class to the control group
    },

    unhighlight: function (element) {
      // revert the change done by hightlight
      $(element).closest(".form-group").removeClass("has-error"); // set error class to the control group
    },

    success: function (label) {
      label.closest(".form-group").removeClass("has-error"); // set success class to the control group
    },

    submitHandler: function (form, event) {
      event.preventDefault();

      const ingredients = [];
      const instructions = [];

      // extracting ingredients data from table
      $("#ingredientsListBody tr").each((i, row) => {
        ingredients.push({
          id: $(row).find(".material-id").val(),
          serving: $(row).find(".amount-per-serving-in-ingredients-table").val(),
        });
      });

      // extracting processes from the input
      $("#processesList .process-block").each((i, el) => {
        const steps = [];

        $(el)
          .find(".steps-list textarea")
          .each((i, input) => steps.push($(input).val()));

        instructions.push({
          title: $(el).find(".process-title").val(),
          instructions: steps,
        });
      });

      POST(
        {
          method: "addNewFormula",
          ingredients: JSON.stringify(ingredients),
          instructions: JSON.stringify(instructions),
        },
        event.target
      ).then((data) => {
        if (data.success) {
          alert("Added successfully");
          location.reload();
        } else {
          console.log(data);
        }
      });
    },
  });
}

// initialize database
function init_FormulaDataTable() {
  var table = $("#formulaTable");

  table.dataTable({
    // Internationalisation. For more info refer to http://datatables.net/manual/i18n
    language: {
      aria: {
        sortAscending: ": activate to sort column ascending",
        sortDescending: ": activate to sort column descending",
      },
      emptyTable: "No data available in table",
      info: "Showing _START_ to _END_ of _TOTAL_ items",
      infoEmpty: "No items found",
      infoFiltered: "(filtered1 from _MAX_ total items)",
      lengthMenu: "Show _MENU_",
      search: "Search:",
      zeroRecords: "No matching items found",
      paginate: {
        previous: "Prev",
        next: "Next",
        last: "Last",
        first: "First",
      },
    },

    // Or you can use remote translation file
    //"language": {
    //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
    //},

    // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
    // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
    // So when dropdowns used the scrollable div should be removed.
    //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

    bStateSave: true, // save datatable state(pagination, sort, etc) in cookie.

    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "All"], // change per page values here
    ],
    // set the initial value
    pageLength: 5,
    pagingType: "bootstrap_full_number",
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
    order: [[0, "desc"]], // set first column as a default sort by asc
  });
}

// display formula details in button click (edit button)
function init_EditFormulaButton() {
  $("#viewFormulationModal").on("hidden.bs.modal", function () {
    appendViewModalFields({});
    $("#viewIngredientsListBody tr:not(#viewIngredientsAddNewItem)").each((i, el) => {
      el.remove();
    });
    $(".e-process-container > .e-process-block").each((i, el) => {
      el.remove();
    });
  });

  const editFormulaForm = $("#editFormulaForm");
  $('[href="#viewFormulationModal"]').on("click", function (event) {
    event.preventDefault();
    const formulaId = $(this).attr("data-id");

    POST({
      method: "getFormulaById",
      id: formulaId,
    }).then((data) => {
      $("#editFormulaForm").find("[name=formula_id]").val(formulaId);

      appendViewModalFields(data);
      data.ingredients.forEach((ing) => {
        const newItem = createIngredientRowItem(ing.material, ing.serving, $("#viewIngredientsListBody"));
        newItem.insertBefore("#viewIngredientsAddNewItem");
      });

      data.instructions.forEach((ins) => {
        createInstructionBlockItem(ins, $(".e-process-container")).insertBefore(".e-process-block-add-new");
      });

      $("#viewFormulationModal").modal("show");
    });
  });

  $(".edit-addIngredientButton").on("click", function () {
    const materialId = $("#edit-selectedIngredientId");
    const amountPerServing = $("#edit-selectedIngredientAmountPerServing");
    const addIngredientHelper = $(".edit-addIngredientButton-error");
    const ingredientsList = $("#viewIngredientsListBody");

    if (materialId.val() == "") {
      addIngredientHelper.removeClass("hide");
      return;
    }

    POST({
      method: "getMaterialById",
      id: materialId.val(),
    }).then((data) => {
      // writing data
      createIngredientRowItem(
        data,
        {
          amount: Number(amountPerServing.val()) || 0,
          unit: $("#edit-units-o-m").val(),
          grams: 0,
        },
        ingredientsList
      ).insertBefore("#viewIngredientsAddNewItem");
      checkIngredientsListSize();

      // reseting the fields
      materialId.val("");
      amountPerServing.val("");
      addIngredientHelper.addClass("hide");
      $("#editIngredientsSearch").val("").trigger("change");
    });
  });

  $(".edit-addNewInstructionBtn").on("click", function () {
    createInstructionBlockItem({ title: "", instructions: [""] }, $(".e-process-container")).insertBefore(
      ".e-process-block-add-new"
    );
  });

  // create isntruction block
  function createInstructionBlockItem(data, container) {
    const block = document.createElement("div");
    block.setAttribute("class", "row e-process-block");
    block.innerHTML = `
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

    data.instructions.forEach((i) => {
      createNewStepElement(i, $(block).find(".steps-list"));
    });

    // ===== events
    $(block)
      .find(".removeProcessBtn")
      .on("click", function () {
        if (confirm("Remove this item?")) block.remove();
      });

    return $(block);
  }

  //
  function createNewStepElement(text, container, currEl = null) {
    const item = document.createElement("li");
    item.innerHTML = `<textarea rows="2" class="form-control" placeholder="Instruction...">${text}</textarea>`;

    $(item)
      .find("textarea")
      .on("keypress", function (event) {
        if (event.ctrlKey && event.key == "\n") {
          createNewStepElement("", container, item);
        }
      });

    $(item)
      .find("textarea")
      .on("keydown", function (event) {
        if (event.key == "Backspace") {
          if (container.find("li").length == 1) return;

          if ($(this).val() == "") {
            $(item).prev().find("textarea").focus();
            item.remove();
          }
        }
      });

    if (currEl) $(item).insertAfter($(currEl));
    else container.append(item);

    $(item).find("textarea").focus();
  }
}
// append formula details
function appendViewModalFields(data) {
  $("#editFormulaForm")
    .find("[name=formula_name]")
    .val(data.name || "");
  $("#editFormulaForm")
    .find("[name=formula_code]")
    .val(data.formula_code || "");
  $("#editFormulaForm")
    .find("[name=version_number]")
    .val(data.version_number || "");
  $("#editFormulaForm")
    .find("[name=status]")
    .val(data.status || "");
  $("#editFormulaForm")
    .find("[name=status_date]")
    .val(data.status_date || "");
  $("#editFormulaForm")
    .find("[name=serving_size]")
    .val(data.serving_size || "");
  $("#editFormulaForm")
    .find("[name=formula_id]")
    .val(data.id || "");
  $("#editFormulaForm")
    .find("[name=notes]")
    .val(data.notes || "");
}

// initialize formula form validation for edit form
function init_editFormulaFormValidation() {
  var form1 = $("#editFormulaForm");
  var error1 = $(".alert-danger", form1);
  var success1 = $(".alert-success", form1);

  form1.validate({
    errorElement: "span", //default input error message container
    errorClass: "help-block help-block-error", // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    ignore: "", // validate all fields including form hidden input
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
        min: 0.001,
      },
    },

    invalidHandler: function (event, validator) {
      //display error alert on form submit
      success1.hide();
      error1.show();
      App.scrollTo(error1, -200);
    },

    errorPlacement: function (error, element) {
      // render error placement for each input type
      var cont = $(element).parent(".input-group");
      if (cont) {
        cont.after(error);
      } else {
        element.after(error);
      }
    },

    highlight: function (element) {
      // hightlight error inputs

      $(element).closest(".form-group").addClass("has-error"); // set error class to the control group
    },

    unhighlight: function (element) {
      // revert the change done by hightlight
      $(element).closest(".form-group").removeClass("has-error"); // set error class to the control group
    },

    success: function (label) {
      label.closest(".form-group").removeClass("has-error"); // set success class to the control group
    },

    submitHandler: function (form, event) {
      event.preventDefault();

      const ingredients = [];
      const instructions = [];

      // extracting ingredients data from table
      $("#viewIngredientsListBody tr:not(#viewIngredientsAddNewItem)").each((i, row) => {
        ingredients.push({
          id: $(row).find(".material-id").val(),
          serving: {
            amount: $(row).find("[data-amount]").val(),
            unit: $(row).find("[data-unit]").val(),
            grams: $(row).find("[data-grams]").val(),
          },
        });
      });

      // extracting processes from the input
      $(".e-process-container .e-process-block").each((i, el) => {
        const steps = [];

        $(el)
          .find(".steps-list textarea")
          .each((i, input) => steps.push($(input).val()));

        instructions.push({
          title: $(el).find(".process-title").val(),
          instructions: steps,
        });
      });

      POST(
        {
          method: "updateFormula",
          ingredients: JSON.stringify(ingredients),
          instructions: JSON.stringify(instructions),
        },
        event.target
      ).then((data) => {
        if (data.success) {
          alert("Updated successfully");
          location.reload();
        } else {
          console.log(data);
        }
      });
    },
  });
}

// removing formula
function init_RemoveFormulaBtn() {
  $(".removeFormulBtn").on("click", function () {
    if (confirm("Do you really wish to remove this formula?")) {
      POST({
        method: "deleteFormula",
        id: $(this).attr("data-id"),
      }).then((res) => {
        if (res.success) {
          alert("Item removed!");
          location.reload();
        }
      });
    }
  });
}

function viewFormulaFn(id) {
  $("#batchSizeInput").val(1);
  const fd = new FormData();
  fd.append("method", "viewFormula");
  fd.append("id", id);
  fetch("formulationv2/api/index.php", {
    method: "POST",
    body: fd,
  })
    .then((t) => t.text())
    .then((data) => {
      $("#viewPrintFormulationModal").find(".formulaview").html(data);
      $("#viewPrintFormulationModal").modal("show");
    });
}

function refreshFormula() {
  const batchSize = Number($("#batchSizeInput").val());

  $(".formulaview [data-batch]").each((i, el) => {
    let batch = 0;

    if (!$(el).data("original-value")) {
      $(el).attr("data-original-value", el.innerText);
      batch = Number(el.innerText) * batchSize;
    } else {
      batch = Number($(el).data("original-value")) * batchSize;
    }

    $(el).text(Number.isInteger(batch) ? batch : batch.toFixed(2));
  });
}

addEventListener("load", function () {
  init_ingredientsSearchSelect2();
  init_addIngredientsButton();
  init_addInstructionsButton();
  init_FormulaFormValidation();
  init_FormulaDataTable();
  init_EditFormulaButton();
  init_editFormulaFormValidation();
  init_RemoveFormulaBtn();

  $("#edit-units-o-m, #units-o-m").append(
    foodUnits
      .split(",")
      .map((x) => `<option value="${x}">${x}</option>`)
      .join("")
  );
});
