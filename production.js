$(() => {
  const path = "production_functions.php";
  const add_so_sig_index = 1;
  const view_product_sig_index = 2;
  const view_task_sig_index = 3;
  const last_sig_index = 3;
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

  let prod_open_datatable;
  let prod_done_datatable;

  init_so_datatable();

  function init_so_datatable() {
    prod_open_datatable = $("#production_open .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_sales_order_products: true,
        },
      },
      columns: [
        {
          title: "Order Date", //0
          data: "order_date",
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
          title: "Product Name", //3
          data: "product_name",
        },
        {
          title: "Quantity", //4
          data: "quantity",
        },
        {
          title: "Delivery Deadline", //5
          data: "delivery_deadline",
        },
        {
          title: "Material Stocks", //6
          data: "material_stocks",
          sortable: false,
        },
        {
          title: "Production Status", //7
          data: "process_step",
          sortable: false,
        },
        {
          title: "Action", //8
          sortable: false,
        },
      ],
      createdRow: function (row, data, index) {
        $("td:eq(6)", row).css({
          "background-color":
            data.material_stocks == "Received" ? "Green" : "Red",
          color: "#fff",
        });
        $("td:eq(7)", row).css({
          "background-color":
            data.process_step == "Completed" ? "Green" : "Red",
          color: "#fff",
        });
      },
      columnDefs: [
        {
          targets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
          className: "text-center",
        },
        {
          targets: 3,
          render: function (data, type, row) {
            return `<input type="button" class='btn btn-sm btn-link view_product' value='${data}'>`;
          },
        },
        {
          targets: 8,
          render: function (data, type, row) {
            return `<input type="button" class='btn btn-sm btn-link view_task' value='View Task'}>`;
          },
        },
        // {
        //   targets: 3,
        //   render: function (data, type, row) {
        //     return display_amount(data, row.currency)
        //   }
        // }
      ],
    });

    prod_done_datatable = $("#production_done .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_sales_order_products: true,
          date_delivered: true,
        },
      },
      columns: [
        {
          title: "Order Date", //0
          data: "order_date",
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
          title: "Product Name", //3
          data: "product_name",
        },
        {
          title: "Quantity", //4
          data: "quantity",
        },
        {
          title: "Delivery Deadline", //5
          data: "delivery_deadline",
        },
        {
          title: "Material Stocks", //6
          data: "material_stocks",
          sortable: false,
        },
        {
          title: "Production Status", //7
          data: "production_status",
          sortable: false,
        },
        {
          title: "Action", //8
          sortable: false,
        },
      ],
      createdRow: function (row, data, index) {
        $("td:eq(6)", row).css({
          "background-color": data.stocks == IN_STOCK ? "Green" : "Red",
          color: "#fff",
        });
        $("td:eq(7)", row).css({
          "background-color": PROD_STATUS_GREEN.includes(data.order_status)
            ? "Green"
            : "Red",
          color: "#fff",
        });
      },
      columnDefs: [
        {
          targets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
          className: "text-center",
        },
        {
          targets: 3,
          render: function (data, type, row) {
            return `<input type="button" class='btn btn-sm btn-link view_product' value='${data}'>`;
          },
        },
        {
          targets: 8,
          render: function (data, type, row) {
            return `<input type="button" class='btn btn-sm btn-link view_task' value='View Task'>`;
          },
        },
        // {
        //   targets: 3,
        //   render: function (data, type, row) {
        //     return display_amount(data, row.currency)
        //   }
        // }
      ],
    });
  }

  $(document).on("click", ".view_product", function () {
    const tr = $(this).closest("tr");
    const row = $("#production_open .main_table").dataTable().fnGetData(tr);
    const id = row.id;
    const modal_id = "#view_product_modal";

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        get_product_details: true,
        id,
      },
      success: function (response) {
        populate(`${modal_id} form`, row);
        let div = "";
        response.forEach((elem) => {
          div += `<tr id=${elem.id}>
                    <td>
                      <input type=text class="form-control text-center" 
                      name=batch_lot_code 
                      ${elem.batch_lot_code && "disabled"} 
                      value=${elem.batch_lot_code ? elem.batch_lot_code : ""}>
                    </td>
                    <td class=text-center>${elem.raw_material_name}</td>
                    <td class=text-center>${elem.supplier_name}</td>
                    <td class=text-center>
                      <input type=date class="form-control text-center" 
                      name=expiration_date 
                      ${elem.expiration_date && "disabled"} 
                      value=${elem.expiration_date ? elem.expiration_date : ""}>
                    </td>
                    <td class=text-center>${elem.quantity}</td>
                    <td class=text-center>
                      <input type=text class="form-control text-center" 
                      name=quantity_received 
                      ${elem.quantity_received && "disabled"} 
                      value=${
                        elem.quantity_received ? elem.quantity_received : ""
                      }>
                    </td>
                    <td class=text-center>${elem.uom}</td>`;

          div +=
            elem.status == "Pending"
              ? `<td class=text-center>
                      <select class="form-control text-center" name=status>
                        <option value="Pending">Pending</option>
                        <option value="Received">Received</option>
                      </select>
                    </td>`
              : "<td class='bg-success text-center'>Received</td>";

          div += `</tr>`;
          // <td class="text-center ${PROD_STATUS_GREEN.includes(elem.production_status) ? 'bg-success' : 'bg-danger'}">${elem.status}</td>
        });
        $(`${modal_id} table tbody`).html(div);

        if (row.date_materials_received) {
          var sig_div1 = get_fsig(
            "Received By",
            row.materials_received_by_sig,
            row.materials_received_by_name,
            row.materials_received_by_position,
            row.date_materials_received
          );
          $("#view_product_sig_container").html(sig_div1);
          $(`${modal_id} [name='remarks_for_products']`).prop("disabled", true);
          $(`${modal_id} .submit`).addClass("hidden");
        } else {
          $("#view_product_sig_container").html(
            sig_div(
              view_product_sig_index,
              "materials_received_by",
              "Received By"
            )
          );
          $("#signature-pad-" + view_product_sig_index).jSignature(sig_css);
          $(`${modal_id} [name='remarks_for_products']`).prop(
            "disabled",
            false
          );
          $(`${modal_id} .submit`).removeClass("hidden");
        }

        $(modal_id).modal("show");
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });
  });

  $(document).on("change", "#view_product_modal select", function () {
    const tr = $(this).closest("tr");
    const id = tr.attr("id");
    const batch_lot_code_elem = tr.find("input[name='batch_lot_code']");
    const expiration_date_elem = tr.find("input[name='expiration_date']");
    const quantity_received_elem = tr.find("input[name='quantity_received']");
    const status_elem = $(this);

    const batch_lot_code = batch_lot_code_elem.val();
    const expiration_date = expiration_date_elem.val();
    const quantity_received = quantity_received_elem.val();
    const status = status_elem.val();

    if (status == "Pending") return;
    if (!batch_lot_code || !expiration_date || !quantity_received || !status)
      return;

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        update_product_raw_material_stocks: true,
        id,
        batch_lot_code,
        expiration_date,
        quantity_received,
        status,
      },
      success: function (response) {
        batch_lot_code_elem.text(batch_lot_code).prop("disabled", true);
        expiration_date_elem.text(expiration_date).prop("disabled", true);
        quantity_received_elem.text(quantity_received).prop("disabled", true);
        status_elem.closest("td").text(status).addClass("bg-success");
        prod_open_datatable.ajax.reload();
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });
  });

  $(document).on("click", "#view_product_modal .submit", function () {
    const id = $("#view_product_modal [name='id']").val();
    const remarks_for_products = $(
      "#view_product_modal [name='remarks_for_products']"
    ).val();
    const materials_received_by_sig = $(
      "#view_product_modal [name='materials_received_by_sig']"
    ).val();
    const materials_received_by_name = $(
      "#view_product_modal [name='materials_received_by_name']"
    ).val();
    const materials_received_by_position = $(
      "#view_product_modal [name='materials_received_by_position']"
    ).val();

    if (!materials_received_by_name || !materials_received_by_position) {
      alert("Enter name and position of signatory");
      return;
    }

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        received_all_materials_by_product_id: true,
        id,
        remarks_for_products,
        materials_received_by_sig,
        materials_received_by_name,
        materials_received_by_position,
      },
      success: function (response) {
        $("#view_product_modal").modal("hide");
        if (response.type == "success") {
          so_open_datatable.ajax.reload();
          prod_open_datatable.ajax.reload();
        } else {
          alert(response.message);
        }
      },
      error: function (response) {
        $("#view_product_modal").modal("hide");
        console.log(response.responseText);
      },
    });
  });

  $(document).on("click", ".view_task", function () {
    const tr = $(this).closest("tr");
    const row = $("#production_open .main_table").dataTable().fnGetData(tr);
    const id = row.id;
    const modal_id = "#view_processes_modal";

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        get_product_processes: true,
        id,
      },
      success: function (response) {
        populate(`${modal_id} form`, row);
        let div = "";
        response.forEach((elem) => {
          div += `<tr id=${elem.id}>
                    <td class=text-center>${elem.item_order}</td>
                    <td class=text-center>${elem.process_step}</td>
                    <td class=text-center>${elem.description}</td>
                    <td class=text-center>${elem.e_forms}</td>
                    <td class=text-center>
                      <select class=form-control name=status ${
                        row.date_process_completed && "disabled"
                      }>
                          <option value="">Select Status</option>
                          <option value="1" ${
                            elem.status == "1" && "selected"
                          }>Not Yet Started</option>
                          <option value="2" ${
                            elem.status == "2" && "selected"
                          }>Ongoing</option>
                          <option value="3" ${
                            elem.status == "3" && "selected"
                          }>Completed</option>
                      </status>
                    </td>
                </tr>`;
        });

        if (row.date_process_completed) {
          var sig_div1 = get_fsig(
            "Received By",
            row.process_completed_by_sig,
            row.process_completed_by_name,
            row.process_completed_by_position,
            row.date_process_completed
          );
          $("#view_processes_sig_container").html(sig_div1);
          $(`${modal_id} [name='remarks_for_processes']`).prop(
            "disabled",
            true
          );
          $(`${modal_id} .submit`).addClass("hidden");
        } else {
          $("#view_processes_sig_container").html(
            sig_div(view_task_sig_index, "process_completed_by", "Received By")
          );
          $("#signature-pad-" + view_task_sig_index).jSignature(sig_css);
          $(`${modal_id} [name='remarks_for_processes']`).prop(
            "disabled",
            false
          );
          $(`${modal_id} .submit`).removeClass("hidden");
        }

        $(`${modal_id} table tbody`).html(div);
        $(modal_id).modal("show");
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });
  });

  $(document).on("change", "#view_processes_modal select", function () {
    const id = $(this).closest("tr").attr("id");
    const status = $(this).val();
    // console.log(status)
    if (!status) return;

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        update_product_raw_material_steps: true,
        id,
        status,
      },
      success: function (response) {
        prod_open_datatable.ajax.reload();
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });
  });

  $(document).on("click", "#view_processes_modal .submit", function () {
    const id = $("#view_processes_modal [name='id']").val();
    const remarks_for_processes = $(
      "#view_processes_modal [name='remarks_for_processes']"
    ).val();
    const process_completed_by_sig = $(
      "#view_processes_modal [name='process_completed_by_sig']"
    ).val();
    const process_completed_by_name = $(
      "#view_processes_modal [name='process_completed_by_name']"
    ).val();
    const process_completed_by_position = $(
      "#view_processes_modal [name='process_completed_by_position']"
    ).val();

    if (!process_completed_by_name || !process_completed_by_position) {
      alert("Enter name and position of signatory");
      return;
    }

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        complete_all_processes_by_product_id: true,
        id,
        remarks_for_processes,
        process_completed_by_sig,
        process_completed_by_name,
        process_completed_by_position,
      },
      success: function (response) {
        $("#view_processes_modal").modal("hide");
        if (response.type == "success") {
          so_open_datatable.ajax.reload();
          prod_open_datatable.ajax.reload();
        } else {
          alert(response.message);
        }
      },
      error: function (response) {
        $("#view_product_view_processes_modalmodal").modal("hide");
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
