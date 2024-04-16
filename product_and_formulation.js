$(() => {
  const path = "product_and_formulation_functions.php";
  const img_path = "uploads/product_and_formulation/";
  const exception =
    "img_main,img_top,img_front,img_left,img_bottom,img_back,img_right";

  // MODAL ID
  const PRODUCT_MODAL_ID = "#add_product_modal";
  const FORMULATION_MODAL_ID = "#formulation_modal";
  // MODAL TAB IDS
  const BASIC_DETAILS_TAB = "#production_product_modal_tab1";
  const PRODUCT_DESCRIPTION_TAB = "#production_product_modal_tab2";
  const INFORMATION_TAB = "#production_formulation_modal_tab1";
  const PROCESS_TAB = "#production_formulation_modal_tab2";
  // MODAL LOAD ELEMS
  const PRODUCT_MODAL_LOADING = `${PRODUCT_MODAL_ID} .loading`;
  const FORMULATION_MODAL_LOADING = `${FORMULATION_MODAL_ID} .loading`;
  // SIGNATURE INDEXES
  const PRODUCT_PREPARED_SIG = 1;
  const PRODUCT_REVIEWED_SIG = 2;
  const PRODUCT_VERIFIED_SIG = 3;
  const INFO_PREPARED_SIG = 4;
  const INFO_REVIEWED_SIG = 5;
  const INFO_VERIFIED_SIG = 6;
  const PROCESS_PREPARED_SIG = 7;
  const PROCESS_REVIEWED_SIG = 8;
  const PROCESS_VERIFIED_SIG = 9;
  const LAST_SIG_INDEX = 9;
  // SIGNATURE CSS
  const SIG_CSS = { width: 300, height: 100 };
  // SIGNATURE STATES
  const PRODUCT_STATE_PREPARE = 101;
  const PRODUCT_STATE_REVIEW = 102;
  const PRODUCT_STATE_VERIFY = 103;
  const INFO_STATE_PREPARE = 201;
  const INFO_STATE_REVIEW = 202;
  const INFO_STATE_VERIFY = 203;
  const PROCESS_STATE_PREPARE = 301;
  const PROCESS_STATE_REVIEW = 302;
  const PROCESS_STATE_VERIFY = 303;
  // DROPDOWN VALUES
  const VENDOR_CODES = ["code1", "code2", "code3"];
  const VENDOR_NAMES = ["vendor1", "vendor2", "vendor3"];
  const PRODUCT_CATEGORY = ["category1", "category2", "category3"];
  // OTHER VARIABLES
  let product_datatable;
  let formulation_datatable;
  let raw_materials;
  let packagings;
  let current_modal_id;

  let raw_material_list;
  let packaging_list;
  let product_state;
  let current_table_row_obj = null;
  let signature_confirmed = false;

  let activeTab = null;

  init();

  function init() {
    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        get_raw_materials_and_packagings: true,
      },
      success: function (response) {
        // RAW MATERIALS
        raw_materials = response.filter((item) => {
          if (item.material_type === "raw_material") return item;
        });

        let div = raw_materials.map(
          (item) =>
            `<option value=${item.id}>${item.raw_materials} - ${item.supplier_name}</option>`
        );
        div.unshift("<option value=''>Select Material</option>");
        $("#select_raw_materials").html(div);

        // PACKAGINGS
        packagings = response.filter((item) => {
          if (item.material_type === "packaging") return item;
        });

        div = packagings.map(
          (item) =>
            `<option value=${item.id}>${item.raw_materials} - ${item.supplier_name}</option>`
        );
        div.unshift("<option value=''>Select Packaging</option>");
        $("#select_packagings").html(div);

        // SETUP DROPDOWNS
        const vendor_codes_elem = create_dropdowns(
          "vendor_code",
          "vendor code",
          VENDOR_CODES
        );
        const vendor_names_elem = create_dropdowns(
          "vendor_name",
          "vendor name",
          VENDOR_NAMES
        );
        const product_categories_elem = create_dropdowns(
          "product_category",
          "product category",
          PRODUCT_CATEGORY
        );

        // POPULATE DROPDOWNS
        $("#vendor_code_container").html(vendor_codes_elem);
        $("#vendor_name_container").html(vendor_names_elem);
        $("#product_category_container").html(product_categories_elem);

        init_datatable();
      },
      error: function (response) {
        alert(response.responseText);
      },
    });
  }

  function create_dropdowns(name, init_value, arr) {
    let options = arr.map(
      (value) => `<option value=${value}>${value}</option>`
    );
    options.unshift(`<option value="">Select ${init_value}</option>`);
    return `<select class=form-control name=${name}>${options}</select>`;
  }

  function init_datatable() {
    product_datatable = $("#product_tab .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_products: true,
        },
      },
      columns: [
        {
          title: "Product Name", //0
          data: "product_name",
        },
        {
          title: "Description", //1
          data: "product_description",
        },
        {
          title: "Category", //2
          data: "product_category",
        },
        {
          title: "Code/ID", //3
          data: "product_code",
        },
        {
          title: "Action", //4
          sortable: false,
        },
      ],
      columnDefs: [
        {
          targets: [2, 3, 4],
          className: "text-center",
        },
        {
          targets: 4,
          render: function (data, type, row) {
            return `<input type="button" class='btn btn-sm btn-primary view_product' value='View'>
            <input type="button" class="btn btn-sm btn-info" value="Print" onclick='window.open("print_product_info.php?id=${row.id}")'>
            <input type="button" class='btn btn-sm btn-danger delete_product' value='Delete'>`;
          },
        },
      ],
    });

    formulation_datatable = $("#formulation_tab .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_products: true,
        },
      },
      columns: [
        {
          title: "Product Name", //0
          data: "product_name",
        },
        {
          title: "Description", //1
          data: "product_description",
        },
        {
          title: "Category", //2
          data: "product_category",
        },
        {
          title: "Code/ID", //3
          data: "product_code",
        },
        {
          title: "Action", //4
          sortable: false,
        },
      ],
      columnDefs: [
        {
          targets: [2, 3, 4],
          className: "text-center",
        },
        {
          targets: 4,
          render: function (data, type, row) {
            return `<input type="button" class='btn btn-sm btn-primary view_formulation' value='View'>
            <input type="button" class="btn btn-sm btn-info" value="Print" onclick='window.open("print_product_info.php?id=${row.id}")'>`;
          },
        },
      ],
    });
  }

  $(document).on("click", "#add_product_btn", function () {
    clear_modal_tab_data();
    goto_first(PRODUCT_MODAL_ID);
    $(`${PRODUCT_MODAL_ID} .nav-tabs li:not(:first)`).hide();
    $(PRODUCT_MODAL_ID).modal("show");
  });

  function clear_modal_tab_data() {
    raw_material_list = [];
    packaging_list = [];
    product_state = PRODUCT_STATE_PREPARE;
    current_table_row_obj = null;
    signature_confirmed = false;
    // REMOVE ENTRIES
    clear_form(PRODUCT_MODAL_ID);
    // REMOVE IMAGES
    exception.split(",").forEach((item) => {
      $(`${PRODUCT_MODAL_ID} [name='${item}']`)
        .parent()
        .find("img")
        .removeAttr("src");
    });
    // REMOVE INGREDIENTS AND PACKAGINGS
    $(
      "#add_product_ingredients_table tbody, #add_product_packagings_table tbody"
    ).html("");

    // PREPARED BY SIG AREA
    $("#product_prepared_sig_container").html(
      sig_div(PRODUCT_PREPARED_SIG, "product_prepared_by", "Prepared By")
    );
    $("#signature-pad-" + PRODUCT_PREPARED_SIG).jSignature(SIG_CSS);

    $("#product_reviewed_sig_container, #product_verified_sig_container").html(
      ""
    );
    // ENABLE VIEWS
    $(
      `#production_product_modal_tab1 input:not(".sig_elem"), #production_product_modal_tab1 textarea, #production_product_modal_tab1 select`
    ).attr("disabled", false);
    $("#select_raw_materials,#select_packagings").show();

    // $(`#add_product_modal .submit`).removeClass("hidden");
    $(PRODUCT_MODAL_LOADING).text("");
  }

  function goto_first(modal_id) {
    $(modal_id + " .nav-tabs li:eq(0) a").tab("show");
  }

  $(document).on(
    "change",
    "#select_raw_materials, #select_packagings",
    function () {
      const select_type = $(this).attr("id");
      const value = $(this).val();
      let elem;

      if (select_type === "select_raw_materials") {
        elem = raw_materials.filter((item) => {
          return item.id == value;
        })[0];

        if (!elem) return;
        raw_material_list = [...raw_material_list, elem];
      } else if (select_type === "select_packagings") {
        elem = packagings.filter((item) => {
          return item.id == value;
        })[0];

        if (!elem) return;
        packaging_list = [...packaging_list, elem];
      }

      const div = create_elem(elem);
      $(
        `#add_product_${
          select_type === "select_raw_materials" ? "ingredients" : "packagings"
        }_table tbody`
      ).append(div);
    }
  );

  $(document).on("click", `${PRODUCT_MODAL_ID} .submit`, function () {
    if (activeTab === BASIC_DETAILS_TAB) {
      if (current_table_row_obj?.date_product_verified) {
        show_error_message("Updating is not allowed");
        return;
      }

      if (signature_confirmed === false) {
        show_error_message("Please enter signature");
        return;
      }

      if (raw_material_list.length === 0) {
        show_error_message("Please select raw materials");
        return;
      }

      if (packaging_list.length === 0) {
        show_error_message("Please select packaging");
        return;
      }

      if (current_table_row_obj?.date_product_verified) {
        show_error_message("Updating is not allowed.");
        return;
      }

      const formdata = new FormData();
      formdata.append("ingredients", JSON.stringify(raw_material_list));
      formdata.append("packagings", JSON.stringify(packaging_list));

      if (product_state === PRODUCT_STATE_PREPARE) {
        formdata.append(
          "product_prepared_by_sig",
          $(`${PRODUCT_MODAL_ID} [name='product_prepared_by_sig']`).val()
        );
      } else if (product_state === PRODUCT_STATE_REVIEW) {
        formdata.append(
          "product_reviewed_by_sig",
          $(`${PRODUCT_MODAL_ID} [name='product_reviewed_by_sig']`).val()
        );
      } else if (product_state === PRODUCT_STATE_VERIFY) {
        formdata.append(
          "product_verified_by_sig",
          $(`${PRODUCT_MODAL_ID} [name='product_verified_by_sig']`).val()
        );
      }

      formdata.append(
        current_table_row_obj ? "update_product" : "add_product",
        true
      );
      current_table_row_obj && formdata.append("id", current_table_row_obj.id);

      $(`${PRODUCT_MODAL_ID} [name]:not('.raw-material-item')`).each(
        function () {
          let $this = $(this);
          let name = $this.attr("name");
          let el_type = $this.attr("type");

          if (el_type == "file") {
            formdata.append(name, $this[0].files[0]);
          } else if (el_type == "checkbox") {
            formdata.append(name, $(this).is(":checked") ? 1 : 0);
          } else if (!$this.hasClass("sig_elem")) {
            formdata.append(name, $this.val());
          }
        }
      );

      $.ajax({
        url: path,
        type: "post",
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        data: formdata,
        success: function (response) {
          // clear_modal_tab_data();
          product_datatable.ajax.reload();
          formulation_datatable.ajax.reload();
          show_success_message("Saved!");
        },
        error: function (response) {
          show_error_message(response);
        },
        beforeSend: function () {
          show_loading_message("Saving...");
        },
      });
    }
  });

  $(document).on("click", ".delete_product", function () {
    var tr = $(this).closest("tr");
    var formdata = $("#product_tab .main_table").dataTable().fnGetData(tr);

    confirm_action(
      `Delete ${formdata.product_name}`,
      `Are you sure you want to delete this product?`,
      function () {
        $.ajax({
          url: path,
          type: "post",
          dataType: "json",
          data: {
            delete_product: true,
            id: formdata.id,
          },
          success: function (response) {
            product_datatable.ajax.reload();
            growl(response.message, response.type);
          },
          error: function (response) {
            growl(response.responseText, "error");
          },
        });
      }
    );
  });

  $(document).on("click", ".delete_selected_material", function () {
    const parent_table_id = $(this).closest("table").attr("id");
    const tr = $(this).closest("tr");
    const tr_index = tr.index();
    if (parent_table_id === "add_product_ingredients_table") {
      raw_material_list = raw_material_list.filter((value, index) => {
        if (index !== tr_index) return value;
      });
    } else if (parent_table_id === "add_product_packagings_table") {
      packaging_list = packaging_list.filter((value, index) => {
        if (index !== tr_index) return value;
      });
    }
    tr.remove();
  });

  $(document).on("change", ".image-file", function (e) {
    const imgURL = URL.createObjectURL(e.target.files[0]);
    const div = $(this).parent().find("img");
    div.attr("src", imgURL);
  });

  $(document).on("click", ".view_product", function () {
    signature_confirmed = false;
    current_modal_id = PRODUCT_MODAL_ID; //"#" + $(this).closest(".modal").attr("id");

    const tr = $(this).closest("tr");
    current_table_row_obj = $("#product_tab .main_table")
      .dataTable()
      .fnGetData(tr);

    goto_first(PRODUCT_MODAL_ID);
    load_product_tab();
    $(`${PRODUCT_MODAL_ID} .nav-tabs li:not(:first)`).show();
    $(PRODUCT_MODAL_ID).modal("show");
  });

  function load_product_tab() {
    if (activeTab === BASIC_DETAILS_TAB) {
      raw_material_list = JSON.parse(current_table_row_obj.ingredients);
      packaging_list = JSON.parse(current_table_row_obj.packagings);

      // SET SIGNATURES
      if (current_table_row_obj.date_product_prepared) {
        product_state = PRODUCT_STATE_REVIEW;
        let sig_value = get_fsig(
          "Prepared By",
          current_table_row_obj.product_prepared_by_sig,
          current_table_row_obj.product_prepared_by_name,
          current_table_row_obj.product_prepared_by_position,
          current_table_row_obj.date_product_prepared
        );
        $("#product_prepared_sig_container").html(sig_value);
      }

      if (current_table_row_obj.date_product_reviewed) {
        product_state = PRODUCT_STATE_VERIFY;
        let sig_value = get_fsig(
          "Reviewed By",
          current_table_row_obj.product_reviewed_by_sig,
          current_table_row_obj.product_reviewed_by_name,
          current_table_row_obj.product_reviewed_by_position,
          current_table_row_obj.date_product_reviewed
        );
        $("#product_reviewed_sig_container").html(sig_value);
      } else {
        $("#product_reviewed_sig_container").html(
          sig_div(PRODUCT_REVIEWED_SIG, "product_reviewed_by", "Reviewed By")
        );
        $("#signature-pad-" + PRODUCT_REVIEWED_SIG).jSignature(SIG_CSS);
      }

      if (current_table_row_obj.date_product_verified) {
        product_state = PRODUCT_STATE_VERIFY;
        let sig_value = get_fsig(
          "Verified By",
          current_table_row_obj.product_verified_by_sig,
          current_table_row_obj.product_verified_by_name,
          current_table_row_obj.product_verified_by_position,
          current_table_row_obj.date_product_verified
        );
        $("#product_verified_sig_container").html(sig_value);
      } else if (current_table_row_obj.date_product_reviewed) {
        $("#product_verified_sig_container").html(
          sig_div(PRODUCT_VERIFIED_SIG, "product_verified_by", "Verified By")
        );
        $("#signature-pad-" + PRODUCT_VERIFIED_SIG).jSignature(SIG_CSS);
      } else {
        $("#product_verified_sig_container").html("");
      }

      // SET ENTRIES
      populate(PRODUCT_MODAL_ID, current_table_row_obj, exception);
      // SET IMAGES
      exception.split(",").forEach((item) => {
        let image = current_table_row_obj[item];
        let item_image = $(`${PRODUCT_MODAL_ID} [name='${item}']`)
          .parent()
          .find("img");
        if (image) {
          item_image.attr("src", img_path + image);
        } else {
          item_image.removeAttr("src");
        }
      });
      // load ingredients
      const item_ingredients = JSON.parse(current_table_row_obj["ingredients"]);
      let ingredients_table_tbody = $("#add_product_ingredients_table tbody");
      ingredients_table_tbody.html("");
      if (item_ingredients) {
        item_ingredients.forEach((elem) => {
          let div = create_elem(elem);
          ingredients_table_tbody.append(div);
        });
      }
      // load packagings
      const item_packagings = JSON.parse(current_table_row_obj["packagings"]);
      let packagings_table_tbody = $("#add_product_packagings_table tbody");
      packagings_table_tbody.html("");
      if (item_packagings) {
        item_packagings.forEach((elem) => {
          let div = create_elem(elem);
          packagings_table_tbody.append(div);
        });
      }

      if (current_table_row_obj.date_product_verified) {
        // DISABLE VIEWS
        $(
          `#production_product_modal_tab1 input:not('.sig_elem'), 
          #production_product_modal_tab1 textarea, 
          #production_product_modal_tab1 select`
        ).attr("disabled", true);
        $("#select_raw_materials, #select_packagings").hide();
        $(".last_col").hide();
      } else {
        $(
          `#production_product_modal_tab1 input:not('.sig_elem'), 
          #production_product_modal_tab1 textarea, 
          #production_product_modal_tab1 select`
        ).attr("disabled", false);
        $("#select_raw_materials, #select_packagings").show();
        $(".last_col").show();
      }
    }
  }

  $(document).on("click", ".view_formulation", function () {
    signature_confirmed = false;
    current_modal_id = FORMULATION_MODAL_ID;

    const tr = $(this).closest("tr");
    current_table_row_obj = $("#formulation_tab .main_table")
      .dataTable()
      .fnGetData(tr);

    goto_first(FORMULATION_MODAL_ID);
    load_formulation_tab();

    // SET ENTRIES
    $(FORMULATION_MODAL_ID + " .modal-title").html(`
      <strong>${current_table_row_obj.product_name}</strong>
    `);
    $(FORMULATION_MODAL_ID).modal("show");
  });

  $(document).on("click", "#add_process_btn", function () {
    const parent = $(this).closest(".row");
    const process_step = parent.find('[name="process_step"]').val();
    const description = parent.find('[name="description"]').val();

    if (process_step && description) {
      const div = main_process_elem(process_step, description);
      $("#process_accordion").append(div);
      parent.find("input[type='text']").val("");
    }
  });

  function main_process_elem(process_step, description, table_data = []) {
    const current_time = randomstring();

    let div = `<div class="panel panel-default">
    <div class="panel-heading" role="tab">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse${current_time}" aria-expanded="true" aria-controls="collapseOne">
          <strong><span class="process_elem">${process_step}</span> - <span class="description_elem">${description}</span></strong>
        </a>
      </h4>
    </div>
    <div id="collapse${current_time}" class="panel-collapse collapse in" role="tabpanel">
      <div class="panel-body">
        <div class=row>
            <div class="co-lg-6 ml12 mr12">`;
    if (current_table_row_obj.date_process_verified === null)
      div += `<form class=form-inline>
            <div class=form-group>
              <input type=text class="form-control subtask" name=subtask placeholder="Subtask">
            </div>
            <div class=form-group>
              <input type=text class="form-control eform" name=eform placeholder="e-form">
            </div>
            <input type=button class="btn btn-sm btn-primary add_subprocess_btn" value="Add Subtask">
          </form>
          <br>`;
    div += `<table class="subtask_table table table-bordered table-condensed">
                <thead>
                  <tr>
                      <th width="25%">Subtask</th>
                      <th width="45%">E-Form</th>`;
    if (current_table_row_obj.date_process_verified === null)
      div += `<th class="text-center">Action</th>`;

    div += `</tr>
                </thead>
                <tbody>`;
    if (table_data.length > 0) div += table_data;
    div += `</tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
  </div>`;
    return div;
  }

  function randomstring() {
    var s = "";
    var randomchar = function () {
      var n = Math.floor(Math.random() * 62);
      if (n < 10) return n; //1-10
      if (n < 36) return String.fromCharCode(n + 55); //A-Z
      return String.fromCharCode(n + 61); //a-z
    };
    while (s.length < 5) s += randomchar();
    return s;
  }

  $(document).on("click", ".add_subprocess_btn", function () {
    const parent = $(this).closest(".panel-body");
    const elem1 = parent.find(".subtask");
    const elem2 = parent.find(".eform");
    const subtask_table = parent.find("table tbody");

    const row = subtask_elem(elem1.val(), elem2.val());
    subtask_table.append(row);
    elem1.val("");
    elem2.val("");
  });

  function subtask_elem(value1, value2) {
    let div = `<tr>
    <td class=subtask_description>${value1}</td>
    <td class=eform_description>${value2}</td>`;
    if (current_table_row_obj.date_process_verified === null)
      div += `<td class=text-center><input type=button class="btn btn-sm btn-danger delete_subtask" value="Delete"></td>`;
    div += `</tr>`;
    return div;
  }

  $(document).on("click", ".delete_subtask", function () {
    $(this).closest("tr").remove();
  });

  $(document).on("click", `${FORMULATION_MODAL_ID} .submit`, function () {
    if (activeTab === INFORMATION_TAB) {
      if (current_table_row_obj?.date_info_verified) {
        show_error_message("Updating is not allowed.");
        return;
      }

      if (signature_confirmed === false) {
        show_error_message("Please enter signature");
        return;
      }

      let withError = false;
      $(
        `${FORMULATION_MODAL_ID} .formulation_ingredients_table tbody tr, ${FORMULATION_MODAL_ID} .formulation_packagings_table tbody tr`
      ).each(function () {
        let elem = $(this).find("[name='quantity']");
        let quantity = elem.val();
        if (!quantity) {
          withError = true;
          elem.addClass("has-error");
        } else {
          elem.removeClass("has-error");
        }
      });

      if (withError === true) {
        show_error_message(
          "Please provide quantity for all ingredients and packagings"
        );
        return;
      }

      let formdata = new FormData();
      let form_items = [];
      $(`${FORMULATION_MODAL_ID} .formulation_ingredients_table tbody tr`).each(
        function () {
          let obj = {
            id: $(this).attr("id"),
            raw_materials: $(this).find("[name='raw_materials']").val(),
            supplier_name: $(this).find("[name='supplier_name']").val(),
            price_per_unit: $(this).find("[name='price_per_unit']").val(),
            uom: $(this).find("[name='uom']").val(),
            quantity: $(this).find("[name='quantity']").val(),
            material_type: "raw_material",
          };
          form_items.push(obj);
        }
      );
      formdata.append("ingredients", JSON.stringify(form_items));

      form_items = [];
      let order = 1;
      $(`${FORMULATION_MODAL_ID} .formulation_packagings_table tbody tr`).each(
        function () {
          let obj = {
            id: order,
            raw_materials: $(this).find("[name='raw_materials']").val(),
            supplier_name: $(this).find("[name='supplier_name']").val(),
            price_per_unit: $(this).find("[name='price_per_unit']").val(),
            uom: $(this).find("[name='uom']").val(),
            quantity: $(this).find("[name='quantity']").val(),
            material_type: "packaging",
          };
          form_items.push(obj);
          order++;
        }
      );
      formdata.append("packagings", JSON.stringify(form_items));
      formdata.append("update_information", true);
      formdata.append("id", current_table_row_obj.id);

      if (product_state === INFO_STATE_PREPARE) {
        formdata.append(
          "info_prepared_by_sig",
          $(`${FORMULATION_MODAL_ID} [name='info_prepared_by_sig']`).val()
        );
      } else if (product_state === INFO_STATE_REVIEW) {
        formdata.append(
          "info_reviewed_by_sig",
          $(`${FORMULATION_MODAL_ID} [name='info_reviewed_by_sig']`).val()
        );
      } else if (product_state === INFO_STATE_VERIFY) {
        formdata.append(
          "info_verified_by_sig",
          $(`${FORMULATION_MODAL_ID} [name='info_verified_by_sig']`).val()
        );
      }

      $.ajax({
        url: path,
        type: "post",
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        data: formdata,
        success: function (response) {
          formulation_datatable.ajax.reload();
          show_success_message("Saved!");
        },
        error: function (response) {
          show_error_message(response.responseText);
        },
      });
    } else if (activeTab === PROCESS_TAB) {
      if (current_table_row_obj?.date_process_verified) {
        show_error_message("Updating is not allowed.");
        return;
      }

      if (signature_confirmed === false) {
        show_error_message("Please enter signature");
        return;
      }

      let formdata = new FormData();
      let form_items = [];
      let order = 1;
      $("#process_accordion .panel").each(function () {
        let obj = {
          item_order: order,
          process_step: $(this).find(".process_elem").text(),
          description: $(this).find(".description_elem").text(),
        };

        let subtasks = [];
        let sub_order = 1;
        $(this)
          .find(".subtask_table tbody tr")
          .each(function () {
            const subtask_data = $(this);
            let subtask_obj = {
              item_order: sub_order,
              subtask: subtask_data.find(".subtask_description").text(),
              eform: subtask_data.find(".eform_description").text(),
            };
            subtasks.push(subtask_obj);
            sub_order++;
          });
        obj.subtasks = subtasks;
        form_items.push(obj);
        order++;
      });

      // if (order === 1) {
      //   show_error_message("Please enter process");
      //   return;
      // }

      formdata.append("processes", JSON.stringify(form_items));

      if (product_state === PROCESS_STATE_PREPARE) {
        formdata.append(
          "process_prepared_by_sig",
          $(`${FORMULATION_MODAL_ID} [name='process_prepared_by_sig']`).val()
        );
      } else if (product_state === PROCESS_STATE_REVIEW) {
        formdata.append(
          "process_reviewed_by_sig",
          $(`${FORMULATION_MODAL_ID} [name='process_reviewed_by_sig']`).val()
        );
      } else if (product_state === PROCESS_STATE_VERIFY) {
        formdata.append(
          "process_verified_by_sig",
          $(`${FORMULATION_MODAL_ID} [name='process_verified_by_sig']`).val()
        );
      }

      formdata.append("update_process", true);
      formdata.append("id", current_table_row_obj.id);

      $.ajax({
        url: path,
        type: "post",
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        data: formdata,
        success: function (response) {
          formulation_datatable.ajax.reload();
          show_success_message("Saved!");
        },
        error: function (response) {
          show_error_message(response.responseText);
        },
      });
    }
  });

  function load_formulation_tab() {
    // --- INFORMATION TAB --- //
    if (activeTab === INFORMATION_TAB) {
      // INFORMATION AREA
      populate(FORMULATION_MODAL_ID, current_table_row_obj, exception);

      // INGREDIENTS AREA
      let formulation_ingredients_tbody = $(
        `${FORMULATION_MODAL_ID} .formulation_ingredients_table tbody`
      );
      formulation_ingredients_tbody.html("");
      const item_ingredients = JSON.parse(current_table_row_obj["ingredients"]);
      if (item_ingredients) {
        item_ingredients.forEach((elem) => {
          let div = create_formulation_elem(
            elem,
            current_table_row_obj.date_info_verified
          );
          formulation_ingredients_tbody.append(div);
        });
      }

      // PACKAGINGS AREA
      let formulation_packagings_tbody = $(
        `${FORMULATION_MODAL_ID} .formulation_packagings_table tbody`
      );
      formulation_packagings_tbody.html("");
      const item_packagings = JSON.parse(current_table_row_obj["packagings"]);
      if (item_packagings) {
        item_packagings.forEach((elem) => {
          let div = create_formulation_elem(
            elem,
            current_table_row_obj.date_info_verified
          );
          formulation_packagings_tbody.append(div);
        });
      }

      // SIGNATURES AREA
      if (current_table_row_obj.date_info_prepared) {
        product_state = INFO_STATE_REVIEW;
        let sig_value = get_fsig(
          "Prepared By",
          current_table_row_obj.info_prepared_by_sig,
          current_table_row_obj.info_prepared_by_name,
          current_table_row_obj.info_prepared_by_position,
          current_table_row_obj.date_info_prepared
        );
        $("#info_prepared_sig_container").html(sig_value);
      } else {
        product_state = INFO_STATE_PREPARE;
        $("#info_prepared_sig_container").html(
          sig_div(INFO_PREPARED_SIG, "info_prepared_by", "Prepared By")
        );
        $("#signature-pad-" + INFO_PREPARED_SIG).jSignature(SIG_CSS);
      }

      if (current_table_row_obj.date_info_reviewed) {
        product_state = INFO_STATE_VERIFY;
        let sig_value = get_fsig(
          "Reviewed By",
          current_table_row_obj.info_reviewed_by_sig,
          current_table_row_obj.info_reviewed_by_name,
          current_table_row_obj.info_reviewed_by_position,
          current_table_row_obj.date_info_reviewed
        );
        $("#info_reviewed_sig_container").html(sig_value);
      } else if (current_table_row_obj.date_info_prepared) {
        $("#info_reviewed_sig_container").html(
          sig_div(INFO_REVIEWED_SIG, "info_reviewed_by", "Reviewed By")
        );
        $("#signature-pad-" + INFO_REVIEWED_SIG).jSignature(SIG_CSS);
      } else {
        $("#info_reviewed_sig_container").html("");
      }

      if (current_table_row_obj.date_info_verified) {
        product_state = INFO_STATE_VERIFY;
        let sig_value = get_fsig(
          "Verified By",
          current_table_row_obj.info_verified_by_sig,
          current_table_row_obj.info_verified_by_name,
          current_table_row_obj.info_verified_by_position,
          current_table_row_obj.date_info_verified
        );
        $("#info_verified_sig_container").html(sig_value);
      } else if (current_table_row_obj.date_info_reviewed) {
        $("#info_verified_sig_container").html(
          sig_div(INFO_VERIFIED_SIG, "info_verified_by", "Verified By")
        );
        $("#signature-pad-" + INFO_VERIFIED_SIG).jSignature(SIG_CSS);
      } else {
        $("#info_verified_sig_container").html("");
      }

      // --- PROCESS TAB --- //
    } else if (activeTab === PROCESS_TAB) {
      // PROCESS AREA
      if (current_table_row_obj.date_process_verified) {
        $("#process_container").hide();
      } else {
        $("#process_container").show();
      }
      const process_accordion = $("#process_accordion");
      process_accordion.html("");
      const item_processes = JSON.parse(current_table_row_obj["processes"]);
      if (item_processes) {
        item_processes.map((item) => {
          let subtasks = "";
          item.subtasks.map((subtask_data) => {
            subtasks += subtask_elem(subtask_data.subtask, subtask_data.eform);
          });
          const data = main_process_elem(
            item.process_step,
            item.description,
            subtasks
          );
          process_accordion.append(data);
        });
      }

      // SIGNATURES AREA
      if (current_table_row_obj.date_process_prepared) {
        product_state = PROCESS_STATE_REVIEW;
        let sig_value = get_fsig(
          "Prepared By",
          current_table_row_obj.process_prepared_by_sig,
          current_table_row_obj.process_prepared_by_name,
          current_table_row_obj.process_prepared_by_position,
          current_table_row_obj.date_process_prepared
        );
        $("#process_prepared_sig_container").html(sig_value);
      } else {
        product_state = PROCESS_STATE_PREPARE;
        $("#process_prepared_sig_container").html(
          sig_div(PROCESS_PREPARED_SIG, "process_prepared_by", "Prepared By")
        );
        $("#signature-pad-" + PROCESS_PREPARED_SIG).jSignature(SIG_CSS);
      }

      if (current_table_row_obj.date_process_reviewed) {
        product_state = PROCESS_STATE_VERIFY;
        let sig_value = get_fsig(
          "Reviewed By",
          current_table_row_obj.process_reviewed_by_sig,
          current_table_row_obj.process_reviewed_by_name,
          current_table_row_obj.process_reviewed_by_position,
          current_table_row_obj.date_process_reviewed
        );
        $("#process_reviewed_sig_container").html(sig_value);
      } else if (current_table_row_obj.date_process_prepared) {
        $("#process_reviewed_sig_container").html(
          sig_div(PROCESS_REVIEWED_SIG, "process_reviewed_by", "Reviewed By")
        );
        $("#signature-pad-" + PROCESS_REVIEWED_SIG).jSignature(SIG_CSS);
      } else {
        $("#process_reviewed_sig_container").html("");
      }

      if (current_table_row_obj.date_process_verified) {
        product_state = PROCESS_STATE_VERIFY;
        let sig_value = get_fsig(
          "Verified By",
          current_table_row_obj.process_verified_by_sig,
          current_table_row_obj.process_verified_by_name,
          current_table_row_obj.process_verified_by_position,
          current_table_row_obj.date_process_verified
        );
        $("#process_verified_sig_container").html(sig_value);
      } else if (current_table_row_obj.date_process_reviewed) {
        $("#process_verified_sig_container").html(
          sig_div(PROCESS_VERIFIED_SIG, "process_verified_by", "Verified By")
        );
        $("#signature-pad-" + PROCESS_VERIFIED_SIG).jSignature(SIG_CSS);
      } else {
        $("#process_verified_sig_container").html("");
      }
    }
  }

  $(".nav-tabs li a").on("shown.bs.tab", function () {
    activeTab = $(this).attr("href");
    reset_loading();
    if (current_modal_id === PRODUCT_MODAL_ID) {
      load_product_tab();
    } else if (current_modal_id === FORMULATION_MODAL_ID) {
      load_formulation_tab();
    }
  });

  function add_comma(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  function show_loading_message(message) {
    load_message("sending", message);
  }

  function show_success_message(message) {
    load_message("success", message, true);
  }

  function show_error_message(message) {
    load_message("error", message);
  }

  function reset_loading() {
    signature_confirmed = false;
    load_message("sending", "");
  }

  function load_message(type, message, timeout = false) {
    let elem = $(`${current_modal_id} .loading`);
    elem.text(message);
    if (type === "sending") {
      elem.addClass("text-primary").removeClass("text-success text-danger");
    } else if (type === "success") {
      elem.addClass("text-success").removeClass("text-primary text-danger");
    } else {
      elem.addClass("text-danger").removeClass("text-primary text-success");
    }
    if (timeout === true) {
      window.setTimeout(() => {
        elem.text("");
      }, 3000);
    }
  }

  function clean_data(data) {
    return data == null ? "" : data;
  }

  function clear_form(form) {
    $(`${form} input, ${form} select, ${form} textarea`).val("");
    $(`${form} [type='checkbox']`).prop("checked", false);
  }

  function confirm_action(title, message, action) {
    swal(
      {
        title: title,
        text: message ? message : "",
        type: "info",
        confirmButtonClass: "btn-primary",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Yes",
        showCancelButton: true,
        cancelButtonColor: "#d33",
      },
      function (result) {
        if (result) {
          action();
        }
      }
    );
  }

  function display_amount(amount, currency) {
    return `${currency} ${add_comma(amount)}`;
  }

  function create_elem(elem) {
    let div = `<tr id=${elem.id}>
        <th><input type=text class="form-control raw-material-item" value='${elem.supplier_name}' readonly></th>
        <th><input type=text class="form-control raw-material-item" value='${elem.raw_materials}' readonly></th>`;
    if (!current_table_row_obj?.date_product_verified)
      div += `<th><input type=button class="btn btn-danger btn-sm delete_selected_material text-center" value="Delete"></th>`;
    div += `</tr>`;
    return div;
  }

  function create_formulation_elem(elem, disabled = null) {
    return `<tr id=${elem.id}>
          <th><input type=text class="form-control raw-material-item" name=raw_materials value='${
            elem.raw_materials
          }' readonly></th>
          <th><input type=text class="form-control raw-material-item" name=supplier_name value='${
            elem.supplier_name
          }' readonly></th>
          <th><input type=text class="form-control raw-material-item text-center" name=price_per_unit value='${
            elem.price_per_unit
          }' readonly></th>
          <th><input type=text class="form-control raw-material-item text-center" name=uom value='${
            elem.uom
          }' disabled></th>
          <th><input type=text class="form-control raw-material-item text-center" name=quantity value='${
            elem.quantity ? elem.quantity : ""
          }' ${disabled && "disabled"}></th>
      </tr>`;
  }

  function get_fsig(label, signature, name_entered, position, date_entered) {
    var sig = "";
    if (date_entered) {
      sig += `<div class="fw-bold mt-2 mb-1"><strong>${label}</strong></div>`;
      sig += `<div><img style="height:75px;width:200px;" src="${signature}" class="mt-2"></div>`;
      sig += `<div>${clean_data(name_entered)}</div>`;
      sig += `<div>${clean_data(position)}</div>`;

      let date = new Date(date_entered);
      const new_date = date.toLocaleString("en", {
        month: "long",
        day: "numeric",
        year: "numeric",
      });

      sig += `<div>${clean_data(new_date)}</div>`;
    }
    return sig;
  }

  function growl(title, type) {
    type = type == "error" ? "danger" : type;
    $.bootstrapGrowl(title, {
      type: type,
    });
  }

  function populate(form, data, exception) {
    const exp = exception.split(",").map((item) => item.trim());
    $.each(data, function (key, value) {
      if (!exp.includes(key)) {
        var ctrl = $("[name=" + key + "],#" + key, form);
        switch (ctrl.prop("type")) {
          case "radio":
          case "checkbox":
            ctrl.each(function () {
              if ($(this).attr("value") == value || value == 1)
                $(this).attr("checked", value);
            });
            break;
          default:
            ctrl.val(value);
        }
      }
    });
  }

  function sig_div(index, name, label) {
    return `<div id="showD${index}" class="signature${index} text-center mt-2">
                  <div class="signature-pad-container">
                    <div class="signature-pad mb-1 sig_bg" id="signature-pad-${index}" style="xborder:1px solid black;"></div>
                    <button type="button" class="border-1 bg-success text-light sig-submitBtn${index}">Confirm Signature</button>
                    <button type="button" class="clear-btn${index} border-1">Clear</button>
                    <textarea type="text" class="signature-data-text${index} hidden d-none" name="${name}_sig" readonly></textarea>
                  </div>
              </div>
              
              <div id="image-sig-${index}" class="hidden text-center mt-2">
                  <div class="img-signature${index}"></div><br>
                  <button class="border-1 mt-1" type="button" id="clear-image${index}">Remove Signature</button>
              </div>
              
              <div class="form-group mt12">
                <label class="col-lg-5 control-label">${label}</label>
                <div class="col-lg-7">
                  <input type="text" class="form-control sig_elem" name="${name}_name" value="${SESSION_NAME}" disabled>
                </div>
              </div>
              <div class="form-group mt12">
                <label class="col-lg-5 control-label mt12">Position</label>
                <div class="col-lg-7">
                  <input type="text" class="form-control sig_elem mt12" name="${name}_position" value="${SESSION_POSITION}" disabled>
                </div>
              </div>`;
  }

  for (let id = 1; id <= LAST_SIG_INDEX; id++) {
    $(document).on("click", ".clear-btn" + id, function () {
      $(this)
        .siblings("#signature-pad-" + id)
        .jSignature("clear");
      $(this)
        .siblings(".signature-data-text" + id)
        .val("");
      //  $('#main-sig-selection'+id).attr('disabled', false);
    });

    $(document).on("change", "#signature-pad-" + id, function () {
      // $('#signature-pad-'+id).on('change', function(){
      var signatureData = $(this).jSignature("getData", "default");
      $(this)
        .siblings(".signature-data-text" + id)
        .val(signatureData);
      //  $('#main-sig-selection'+id).attr('disabled', true)
    });

    $(document).on("click", ".sig-submitBtn" + id, function () {
      // $('.sig-submitBtn'+id).on('click', function(){
      $("#image-sig-" + id).toggleClass("hidden");
      $("#showD" + id).toggleClass("hidden");
      var data = $("#signature-pad-" + id).jSignature("getData", "default");
      var image = new Image();
      image.src = data;
      $(".img-signature" + id).append(image);
      signature_confirmed = true;
    });

    $(document).on("click", "#clear-image" + id, function () {
      // $('#clear-image'+id).on('click', function(){
      $("#showD" + id).toggleClass("hidden");
      $("#image-sig-" + id).toggleClass("hidden");
      $("#signature-pad-" + id).jSignature("clear");
      $(".signature-data-text" + id).val("");
      $(".img-signature" + id).empty();
      signature_confirmed = false;
    });
  }
});
