$(() => {
  const path = "sales_functions.php";
  const add_so_sig_index = 1;
  const view_product_sig_index = 2;
  // const view_task_sig_index = 3;
  const last_sig_index = 2;
  const sig_css = { width: 300, height: 100 };

  // AVAILABILITY
  const IN_STOCK = "In Stock";
  const NOT_AVAILABLE = "Not Available";
  // ORDER STATUS
  const PRODUCTION = "Production";
  const FOR_SHIPPING = "For Shipping";
  const IN_TRANSIT = "In Transit";
  const DELIVERED = "Delivered";
  const INGREDIENTS_ORDERED = "Ingredients Ordered";
  const CANCELLED = "Cancelled";
  const PROD_STATUS_GREEN = [PRODUCTION, FOR_SHIPPING, IN_TRANSIT];

  let product_selection;
  let so_open_datatable;
  let so_done_datatable;
  // let prod_open_datatable;
  // let prod_done_datatable;

  $(document).on("click", "#add_so_btn", function () {
    clear_form("#add_so_modal form");
    $("#add_so_modal tbody").html("");
    $("#add_so_modal [name='created_date']").val(current_date);
    $("#create_so_sig_container").html(
      sig_div(add_so_sig_index, "approved_by", "Approved By")
    );
    $("#signature-pad-" + add_so_sig_index).jSignature(sig_css);
    $("#add_so_modal").modal("show");
  });

  init();

  function init() {
    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        get_product_selection: true,
      },
      success: function (response) {
        product_selection = response;
        const div = response.map(
          (item) => `<option value=${item.id}>${item.product_name}</option>`
        );
        div.unshift("<option value=''>Select Product</option>");
        $("#product_select").html(div);

        // init so table
        init_so_datatable();
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });
  }

  function init_so_datatable() {
    so_open_datatable = $("#sales_open .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_sales_orders: true,
          order_status: "ALL",
        },
      },
      columns: [
        {
          title: "Created Date", //0
          data: "created_date",
        },
        {
          title: "Sales Order #", //1
          data: "sales_order",
        },
        {
          title: "Customer Name", //2
          data: "customer_name",
        },
        {
          title: "Total Amount", //3
          data: "total_amount",
        },
        {
          title: "Delivery Deadline", //4
          data: "delivery_deadline",
        },
        {
          title: "Stocks", //5
          data: "stocks",
          sortable: false,
        },
        {
          title: "Order Status", //6
          data: "order_status",
          sortable: false,
        },
      ],
      createdRow: function (row, data, index) {
        $("td:eq(5)", row).css({
          "background-color": data.stocks == IN_STOCK ? "Green" : "Red",
          color: "#fff",
        });
        $("td:eq(6)", row).css({
          "background-color": PROD_STATUS_GREEN.includes(data.order_status)
            ? "Green"
            : "Red",
          color: "#fff",
        });
      },
      columnDefs: [
        {
          targets: [0, 1, 2, 3, 4, 5, 6],
          className: "text-center",
        },
        {
          targets: 1,
          render: function (data, type, row) {
            return `<input type="button" class='btn btn-sm btn-link view_so' value='${data}'>`;
          },
        },
        {
          targets: 3,
          render: function (data, type, row) {
            return display_amount(data, row.currency);
          },
        },
      ],
    });

    so_done_datatable = $("#sales_done .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_sales_orders: true,
          order_status: DELIVERED,
        },
      },
      columns: [
        {
          title: "Created Date", //0
          data: "created_date",
        },
        {
          title: "Sales Order #", //1
          data: "sales_order",
        },
        {
          title: "Customer Name", //2
          data: "customer_name",
        },
        {
          title: "Total Amount", //3
          data: "total_amount",
        },
        {
          title: "Date Delivered", //4
          data: "date_delivered",
        },
      ],
      columnDefs: [
        {
          targets: [0, 1, 2, 3, 4],
          className: "text-center",
        },
        {
          targets: 1,
          render: function (data, type, row) {
            return `<input type="button" class='btn btn-sm btn-link view_so' value='${data}'>`;
          },
        },
        {
          targets: 3,
          render: function (data, type, row) {
            return display_amount(data, row.currency);
          },
        },
      ],
    });
  }

  $(document).on("change", "#product_select", function () {
    const id = $(this).val();
    const elem = product_selection.filter((item) => {
      return item.id == id;
    })[0];

    if (!elem) return;

    const div = `<tr id=${elem.id}>
                  <th><input type=text class=form-control name=name value='${elem.product_name}' disabled></th>
                  <th><input type=text class=form-control name=description value='${elem.product_description}' disabled></th>
                  <th><input type=text class="form-control text-center" name=quantity value=0></th>
                  <th><input type=text class="form-control text-center" name=uom value='${elem.uom}' readonly></th>
                  <th><input type=text class="form-control text-center" name=unit_price value='${elem.unit_price}' readonly></th>
                  <th><input type=text class="form-control text-center" name=total_price readonly></th>
                  <th><input type=text class="form-control text-center" name=material_stocks readonly></th>
                  <th><input type=button class="btn btn-danger btn-sm delete_selected_product" value="Delete"></th>
               </tr>`;
    $("#add_so_modal .products_table tbody").append(div);
  });

  $(document).on("click", ".delete_selected_product", function () {
    $(this).closest("tr").remove();
  });

  $(document).on(
    "keyup",
    "#add_so_modal .products_table tbody input[name='quantity']",
    function () {
      const value = Number($(this).val());
      const avail_el = $(this).closest("tr").find("[name='material_stocks']");
      // set row availability
      if (value > 10) {
        avail_el
          .val(NOT_AVAILABLE)
          .addClass("text-danger")
          .removeClass("text-success");
      } else {
        avail_el
          .val(IN_STOCK)
          .addClass("text-success")
          .removeClass("text-danger");
      }

      // set row total price
      const unit_price = Number(
        $(this).closest("tr").find("[name='unit_price']").val()
      );
      var total_price_el = $(this).closest("tr").find("[name='total_price']");
      total_price_el.val(unit_price * value);

      // set modal total and availability
      let total_amount = 0;
      let stocks = IN_STOCK;

      $("#add_so_modal .products_table tbody tr").each(function () {
        const current = $(this).find("[name='total_price']").val();
        total_amount += Number(current);
        $("#add_so_modal [name='total_amount']").val(total_amount);

        const material_stocks = $(this).find("[name='material_stocks']").val();
        if (material_stocks == NOT_AVAILABLE) stocks = material_stocks;
        $("#add_so_modal [name='stocks']").val(stocks);
        if (stocks == IN_STOCK) {
          $("#add_so_modal [name='stocks']")
            .addClass("text-success")
            .removeClass("text-danger");
        } else {
          $("#add_so_modal [name='stocks']")
            .addClass("text-danger")
            .removeClass("text-success");
        }
      });
    }
  );

  $(document).on("click", "#add_so_modal .submit", function () {
    const sales_order = $("#add_so_modal [name='sales_order']").val();
    const customer_name = $("#add_so_modal [name='customer_name']").val();
    const created_date = $("#add_so_modal [name='created_date']").val();
    const delivery_deadline = $(
      "#add_so_modal [name='delivery_deadline']"
    ).val();
    const remarks = $("#add_so_modal [name='remarks']").val();
    const currency = $("#add_so_modal [name='currency']").val();
    const total_amount = $("#add_so_modal [name='total_amount']").val();
    const stocks = $("#add_so_modal [name='stocks']").val();
    const approved_by_sig = $("#add_so_modal [name='approved_by_sig']").val();
    const approved_by_name = $("#add_so_modal [name='approved_by_name']").val();
    const approved_by_position = $(
      "#add_so_modal [name='approved_by_position']"
    ).val();

    if (!approved_by_name || !approved_by_position) {
      alert("Enter name and position of signatory");
      return;
    }

    var items_form = [];
    $("#add_so_modal .products_table tbody tr").each(function () {
      var parent = $(this);
      const names = [
        "name",
        "description",
        "uom",
        "quantity",
        "unit_price",
        "total_price",
        "material_stocks",
      ];
      var row_item = [];
      row_item.push(get_obj("product_id", parent.attr("id")));
      names.forEach((name) => {
        row_item.push(get_obj(name, parent.find(`[name='${name}']`).val()));
      });
      items_form.push(row_item);
    });

    if (items_form.length == 0) {
      alert("Please Select Products");
      return;
    }

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        add_so: true,
        sales_order,
        customer_name,
        created_date,
        delivery_deadline,
        remarks,
        currency,
        total_amount,
        stocks,
        approved_by_sig,
        approved_by_name,
        approved_by_position,
        items_form: JSON.stringify(items_form),
      },
      success: function (response) {
        if (response.type == "success") {
          $("#add_so_modal").modal("hide");
          so_open_datatable.ajax.reload();
          prod_open_datatable.ajax.reload();
        } else {
          alert(response.message);
        }
      },
      error: function (response) {
        $("#add_so_modal").modal("hide");
        console.log(response.responseText);
      },
    });
  });

  $(document).on("click", ".view_so", function () {
    const tr = $(this).closest("tr");
    const row = $("#sales_open .main_table").dataTable().fnGetData(tr);
    const id = row.id;

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        get_so_details: true,
        id,
      },
      success: function (response) {
        populate("#view_so_modal form", row);
        let div = "";
        response.forEach((elem) => {
          div += `<tr>
                    <td>${elem.name}</td>
                    <td>${elem.description}</td>
                    <td class=text-center>${elem.quantity}</td>
                    <td class=text-center>${elem.uom}</td>
                    <td class=text-center>${display_amount(
                      elem.unit_price,
                      row.currency
                    )}</td>
                    <td class=text-center>${display_amount(
                      elem.total_price,
                      row.currency
                    )}</td>
                    <td class="text-center ${
                      elem.material_stocks == IN_STOCK
                        ? "bg-success"
                        : "bg-danger"
                    }">${elem.material_stocks}</td>
                    <td class="text-center ${
                      PROD_STATUS_GREEN.includes(elem.production_status)
                        ? "bg-success"
                        : "bg-danger"
                    }">${elem.production_status}</td>
                    <td class=text-center><input type=button class="btn btn-primary btn-sm view_raw_materials" value="View Raw Materials"></td>
                </tr>`;
        });

        $("#view_so_modal [name='stocks']").val(row.stocks);
        $("#view_so_modal [name='total_amount']").val(
          display_amount(row.total_amount, row.currency)
        );
        const view_so_sig = get_fsig(
          "Approved By",
          row.approved_by_sig,
          row.approved_by_name,
          row.approved_by_position,
          row.date_approved
        );
        $("#view_so_sig_container").html(view_so_sig);
        $("#view_so_modal table tbody").html(div);
        $("#view_so_modal").modal("show");
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });
  });

  function add_comma(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  function clean_data(data) {
    return data == null ? "" : data;
  }

  function clear_form(form) {
    $(`${form} input, ${form} remarks`).val("");
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

  function get_fsig(label, signature, name_entered, position, date_entered) {
    var sig = "";
    if (date_entered) {
      sig += `<div class="fw-bold mt-2 mb-1"><strong>${label}</strong></div>`;
      sig += `<div><img style="height:75px;width:200px;" src="${signature}" class="mt-2"></div>`;
      sig += `<div>${clean_data(name_entered)}</div>`;
      sig += `<div>${clean_data(position)}</div>`;
      sig += `<div>${clean_data(date_entered)}</div>`;
    }
    return sig;
  }

  function get_obj(name, value) {
    return {
      name: name,
      value: value,
    };
  }

  function growl(title, type) {
    type = type == "error" ? "danger" : type;
    $.bootstrapGrowl(title, {
      type: type,
    });
  }

  function populate(form, data) {
    $.each(data, function (key, value) {
      var ctrl = $("[name=" + key + "],#" + key, form);
      switch (ctrl.prop("type")) {
        case "radio":
        case "checkbox":
          ctrl.each(function () {
            if ($(this).attr("value") == value) $(this).attr("checked", value);
          });
          break;
        default:
          ctrl.val(value);
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
                  <input type="text" class="form-control" name="${name}_name">
                </div>
              </div>
              <div class="form-group mt12">
                <label class="col-lg-5 control-label mt12">Position</label>
                <div class="col-lg-7">
                  <input type="text" class="form-control mt12" name="${name}_position">
                </div>
              </div>`;
  }

  for (let id = 1; id <= last_sig_index; id++) {
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
    });

    $(document).on("click", "#clear-image" + id, function () {
      // $('#clear-image'+id).on('click', function(){
      $("#showD" + id).toggleClass("hidden");
      $("#image-sig-" + id).toggleClass("hidden");
      $("#signature-pad-" + id).jSignature("clear");
      $(".signature-data-text" + id).val("");
      $(".img-signature" + id).empty();
    });
  }
});
