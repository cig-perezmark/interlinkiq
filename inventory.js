$(() => {
  const path = "inventory_functions.php";
  const DRAFTED_COLOR = "#5e738b"; // blue-dark
  const FOR_APPROVAL_COLOR = "#5dade2"; // blue
  const FOR_DELIVERY_COLOR = "#d2c522"; //yellow
  const CANCELLED_COLOR = "#cd6155"; // red
  const RECEIVED_COLOR = "#52be80"; // green

  const colors_arr = [
    DRAFTED_COLOR,
    FOR_APPROVAL_COLOR,
    FOR_DELIVERY_COLOR,
    RECEIVED_COLOR,
    CANCELLED_COLOR,
  ];
  const all_status = [
    "Drafted",
    "For Approval",
    "For Delivery",
    "Received",
    "Cancelled",
  ];

  init_all();

  function init_all() {
    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        get_suppliers_locations: true,
      },
      success: function (response) {
        suppliers = JSON.parse(response.suppliers);
        locations = JSON.parse(response.locations);

        var div = create_select_elem(locations, "Location");
        location_elem = `<select class="select_location form-control" style="width:200px;float:left;">${div}</select>`;
        purchase_init();
        warehouse_init();
        // -- JANUARY 10, 2024 -- JS PART 1 START --
        production_init();
        sales_init();
        // -- JANUARY 10, 2024 -- JS PART 1 END --
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });
  }

  // ------ PURCHASES ------
  var all_purchases_main_table,
    draft_main_table,
    for_approval_main_table,
    for_delivery_main_table,
    received_main_table,
    cancelled_main_table;

  function purchase_init() {
    all_purchases_main_table = $("#all_purchases .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_purchase_data: true,
          status: "all",
        },
      },
      columns: [
        {
          title: "Created Date", //0
          data: "created_date",
        },
        {
          title: "Purchase Order", //1
          data: "po",
        },
        {
          title: "Supplier", //2
          data: "supplier_name",
        },
        {
          title: "Location", //3
          data: "location",
        },
        {
          title: "Total Amount", //4
          data: "total_price",
        },
        {
          title: "Expected Arrival", //5
          data: "expected_arrival",
        },
        {
          title: "Status", //6
          data: "status",
        },
        {
          title: "#", //7
          data: "total_comments",
        },
        {
          title: "Action", //8
          sortable: false,
        },
      ],
      columnDefs: [
        {
          targets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
          className: "text-center",
        },
        {
          targets: 4,
          render: function (data, type, row) {
            return display_amount(data, row.currency);
          },
        },
        {
          targets: 6,
          render: function (data, type, row) {
            return display_status(data);
          },
        },
        {
          targets: 7,
          render: function (data, type, row) {
            return display_comment_btn(data);
          },
        },
        {
          targets: 8,
          render: function (data, type, row) {
            var div = view_po_btn();
            div += print_po_btn();
            return div;
          },
          width: "15%",
        },
      ],
      autoWidth: false,
      initComplete: function () {
        am5.ready(function () {
          generate_barchart();
        });
      },
    });

    draft_main_table = $("#draft .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_purchase_data: true,
          status: "drafted",
        },
      },
      columns: [
        {
          title: "Created Date", //0
          data: "created_date",
        },
        {
          title: "Purchase Order", //1
          data: "po",
        },
        {
          title: "Supplier", //2
          data: "supplier_name",
        },
        {
          title: "Location", //3
          data: "location",
        },
        {
          title: "Total Amount", //4
          data: "total_price",
        },
        {
          title: "Expected Arrival", //5
          data: "expected_arrival",
        },
        {
          title: "#", //6
          data: "total_comments",
        },
        {
          title: "Action", //7
          width: "25%",
          sortable: false,
        },
      ],
      columnDefs: [
        {
          targets: [0, 1, 2, 3, 4, 5, 6, 7],
          className: "text-center",
        },
        {
          targets: 4,
          render: function (data, type, row) {
            return display_amount(data, row.currency);
          },
        },
        {
          targets: 6,
          render: function (data, type, row) {
            return display_comment_btn(data);
          },
        },
        {
          targets: 7,
          render: function (data, type, row) {
            var div = update_po_btn();
            div += delete_po_btn();
            div += sign_po_btn(
              row.id,
              "for_approval",
              "drafted_by",
              "Push to : For Approval",
              1
            );
            div += print_po_btn();
            return div;
          },
        },
      ],
      autoWidth: false,
      initComplete: function () {
        var div = create_select_elem(suppliers, "Supplier");
        $("#add_po_modal [name='supplier_id']").html(div);

        div = create_select_elem(locations, "Location");
        $("#add_po_modal [name='location_id']").html(div);
        $("#add_stock_transfer_modal [name='location_id']").html(div);

        // $.ajax({
        //   url: path,
        //   type: "post",
        //   dataType: "json",
        //   data: {
        //     get_suppliers_locations: true,
        //   },
        //   success: function (response) {
        //     // console.log(location_elem)

        //     var suppliers = JSON.parse(response.suppliers)
        //     var locations = JSON.parse(response.locations)

        //     var div = create_select_elem(suppliers, "Supplier")
        //     $("#add_po_modal [name='supplier_id']").html(div)

        //     div = create_select_elem(locations, "Location")
        //     $("#add_po_modal [name='location_id']").html(div)
        //     $("#add_stock_transfer_modal [name='location_id']").html(div)
        //   },
        //   error: function (response) {
        //     console.log(response.responseText)
        //   }
        // })
      },
    });

    for_approval_main_table = $("#for_approval .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_purchase_data: true,
          status: "for_approval",
        },
      },
      columns: [
        {
          title: "Created Date", //0
          data: "created_date",
        },
        {
          title: "Purchase Order", //1
          data: "po",
        },
        {
          title: "Supplier", //2
          data: "supplier_name",
        },
        {
          title: "Location", //3
          data: "location",
        },
        {
          title: "Total Amount", //4
          data: "total_price",
        },
        {
          title: "Expected Arrival", //5
          data: "expected_arrival",
        },
        {
          title: "Drafted By", //6
          sortable: false,
        },
        {
          title: "#", //7
          data: "total_comments",
        },
        {
          title: "Action", //8
          sortable: false,
        },
      ],
      columnDefs: [
        {
          targets: [0, 1, 2, 3, 4, 5, 7, 8],
          className: "text-center",
        },
        {
          targets: 4,
          render: function (data, type, row) {
            return display_amount(data, row.currency);
          },
        },
        {
          targets: 6,
          render: function (data, type, row) {
            return display_name(
              row.drafted_by_name,
              row.drafted_by_position,
              row.date_drafted
            );
          },
          width: "15%",
        },
        {
          targets: 7,
          render: function (data, type, row) {
            return display_comment_btn(data);
          },
        },
        {
          targets: 8,
          render: function (data, type, row) {
            var div = view_po_btn();
            div += cancel_po_btn(row.id, row.po, 2);
            div += sign_po_btn(
              row.id,
              "for_delivery",
              "approved_by",
              "Push to : For Delivery",
              3
            );
            div += print_po_btn();
            return div;
          },
          width: "35%",
        },
      ],
      autoWidth: false,
    });

    for_delivery_main_table = $("#for_delivery .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_purchase_data: true,
          status: "for_delivery",
        },
      },
      columns: [
        {
          title: "Created Date", //0
          data: "created_date",
        },
        {
          title: "Purchase Order", //1
          data: "po",
        },
        {
          title: "Supplier", //2
          data: "supplier_name",
        },
        {
          title: "Location", //3
          data: "location",
        },
        {
          title: "Total Amount", //4
          data: "total_price",
        },
        {
          title: "Expected Arrival", //5
          data: "expected_arrival",
        },
        {
          title: "Approved By", //6
          sortable: false,
        },
        {
          title: "#", //7
          data: "total_comments",
        },
        {
          title: "Action", //8
          sortable: false,
        },
      ],
      columnDefs: [
        {
          targets: [0, 1, 2, 3, 4, 5, 7, 8],
          className: "text-center",
        },
        {
          targets: 4,
          render: function (data, type, row) {
            return display_amount(data, row.currency);
          },
        },
        {
          targets: 6,
          render: function (data, type, row) {
            return display_name(
              row.approved_by_name,
              row.approved_by_position,
              row.date_approved
            );
          },
          width: "15%",
        },
        {
          targets: 7,
          render: function (data, type, row) {
            return display_comment_btn(data);
          },
        },
        {
          targets: 8,
          render: function (data, type, row) {
            var div = view_po_btn();
            div += print_po_btn();
            return div;
          },
        },
      ],
      autoWidth: false,
    });

    received_main_table = $("#received .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_purchase_data: true,
          status: "received",
        },
      },
      columns: [
        {
          title: "Created Date", //0
          data: "created_date",
        },
        {
          title: "Purchase Order", //1
          data: "po",
        },
        {
          title: "Supplier", //2
          data: "supplier_name",
        },
        {
          title: "Location", //3
          data: "location",
        },
        {
          title: "Total Amount", //4
          data: "total_price",
        },
        {
          title: "Expected Arrival", //5
          data: "expected_arrival",
        },
        {
          title: "Received By", //6
          sortable: false,
        },
        {
          title: "#", //7
          data: "total_comments",
        },
        {
          title: "Action", //8
          sortable: false,
        },
      ],
      columnDefs: [
        {
          targets: [0, 1, 2, 3, 4, 5, 7, 8],
          className: "text-center",
        },
        {
          targets: 4,
          render: function (data, type, row) {
            return display_amount(data, row.currency);
          },
        },
        {
          targets: 6,
          render: function (data, type, row) {
            return display_name(
              row.po_received_by_name,
              row.po_received_by_position,
              row.date_po_received
            );
          },
          width: "15%",
        },
        {
          targets: 7,
          render: function (data, type, row) {
            return display_comment_btn(data);
          },
        },
        {
          targets: 8,
          render: function (data, type, row) {
            var div = view_po_btn();
            div += print_po_btn();
            return div;
          },
        },
      ],
      autoWidth: false,
    });

    cancelled_main_table = $("#cancelled .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_purchase_data: true,
          status: "cancelled",
        },
      },
      columns: [
        {
          title: "Created Date", //0
          data: "created_date",
        },
        {
          title: "Purchase Order", //1
          data: "po",
        },
        {
          title: "Supplier", //2
          data: "supplier_name",
        },
        {
          title: "Location", //3
          data: "location",
        },
        {
          title: "Total Amount", //4
          data: "total_price",
        },
        {
          title: "Expected Arrival", //5
          data: "expected_arrival",
        },
        {
          title: "Cancelled By", //6
          sortable: false,
        },
        {
          title: "#", //7
          data: "total_comments",
        },
        {
          title: "Action", //8
          sortable: false,
        },
      ],
      columnDefs: [
        {
          targets: [0, 1, 2, 3, 4, 5, 7, 8],
          className: "text-center",
        },
        {
          targets: 4,
          render: function (data, type, row) {
            return display_amount(data, row.currency);
          },
        },
        {
          targets: 6,
          render: function (data, type, row) {
            return display_name(
              row.cancelled_by_name,
              row.cancelled_by_position,
              row.date_cancelled
            );
          },
          width: "15%",
        },
        {
          targets: 7,
          render: function (data, type, row) {
            return display_comment_btn(data);
          },
        },
        {
          targets: 8,
          render: function (data, type, row) {
            return view_po_btn();
          },
        },
      ],
      autoWidth: false,
    });
  }

  var root1;
  function generate_barchart() {
    var drafted_total = 0,
      for_approval_total = 0,
      for_delivery_total = 0,
      received = 0,
      cancelled = 0;

    var all_purchases_data = all_purchases_main_table.rows().data().toArray();
    all_purchases_data.forEach((el) => {
      if (el.status == "drafted") {
        drafted_total++;
      } else if (el.status == "for_approval") {
        for_approval_total++;
      } else if (el.status == "for_delivery") {
        for_delivery_total++;
      } else if (el.status == "cancelled") {
        cancelled++;
      } else if (el.status == "received") {
        received++;
      }
    });
    var grand_total = all_purchases_data.length;

    var upper_widget = $(".widget-row1");
    upper_widget.html("");
    var widget1_colors = ["white", "blue-dark", "blue"];
    var widget1_totals = [grand_total, drafted_total, for_approval_total];
    var widget1_texts = ["Total POs", "Drafted", "For Approval"];

    widget1_texts.forEach((el, index) => {
      var div = `<div class="col-md-4">
                    <div class="stat4 dashboard-stat dashboard-stat-v2 ${widget1_colors[index]}">
                      <div class="visual">
                          <i class="fa fa-comments"></i>
                      </div>
                      <div class="details">
                          <div class="number">
                            <span data-value="">${widget1_totals[index]}</span>
                          </div>
                          <div class="desc">${el}</div>
                      </div>
                    </div>
                </div>`;
      upper_widget.append(div);
    });

    var lower_widget = $(".widget-row2");
    lower_widget.html("");
    var widget2_colors = ["yellow", "green", "red"];
    var widget2_totals = [for_delivery_total, received, cancelled];
    var widget2_texts = ["For Delivery", "Received", "Cancelled"];

    widget2_texts.forEach((el, index) => {
      var div = `<div class="col-md-4">
                    <div class="stat4 dashboard-stat dashboard-stat-v2 ${widget2_colors[index]}">
                      <div class="visual">
                          <i class="fa fa-comments"></i>
                      </div>
                      <div class="details">
                          <div class="number">
                            <span data-value="">${widget2_totals[index]}</span>
                          </div>
                          <div class="desc">${el}</div>
                      </div>
                    </div>
                </div>`;
      lower_widget.append(div);
    });

    series_data = [];
    var all_totals = [
      drafted_total,
      for_approval_total,
      for_delivery_total,
      received,
      cancelled,
    ];
    all_totals.forEach((el, index) => {
      series_data.push({
        category: all_status[index],
        value: el,
        columnSettings: {
          fill: am5.color(colors_arr[index]),
        },
      });
    });

    // chart 1
    root1 = am5.Root.new("chart1div");

    root1.setThemes([am5themes_Animated.new(root1)]);

    root1.numberFormatter.setAll({
      numberFormat: "#,###",
      numericFields: ["valueY"],
    });

    var chart1 = root1.container.children.push(am5xy.XYChart.new(root1, {}));

    var xAxis = chart1.xAxes.push(
      am5xy.CategoryAxis.new(root1, {
        renderer: am5xy.AxisRendererX.new(root1, {}),
        categoryField: "category",
      })
    );

    xaxis_data = [];
    all_status.forEach((el) => {
      xaxis_data.push({
        category: el,
      });
    });

    xAxis.data.setAll(xaxis_data);

    var yAxis = chart1.yAxes.push(
      am5xy.ValueAxis.new(root1, {
        maxPrecision: 0,
        renderer: am5xy.AxisRendererY.new(root1, {}),
      })
    );

    var series1 = chart1.series.push(
      am5xy.ColumnSeries.new(root1, {
        name: "Series",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        categoryXField: "category",
      })
    );

    series1.data.setAll(series_data);
    series1.columns.template.setAll({
      templateField: "columnSettings",
    });
    series1.appear(1000);
    chart1.appear(1000, 100);
  }

  $(document).on("click", ".total_comment_btn", function () {
    var comments_modal = "#comments_modal";
    $("#comments_area .portlet-body .timeline").html("");

    var tab_id = $(this).closest(".tab-pane").attr("id");
    var tr = $(this).closest("tr");
    var formdata = $(`#${tab_id} .main_table`).dataTable().fnGetData(tr);
    var data_type = $(this).attr("data-type");
    $("#comments_modal [name='po_id']").val(formdata.po_id);
    $("#comments_modal [name='comment_type']").val(data_type);

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        view_comments: true,
        po_id: formdata.po_id,
        data_type: data_type,
      },
      success: function (response) {
        var parents = response.parents;
        var replies = response.replies;

        parents.forEach((parent) => {
          var div = create_comment_div(parent, replies);
          $("#comments_area > .portlet-body > .timeline").append(div);
        });
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });
    var title = `Purchase Order : ${formdata.po}`;
    if (data_type == "str") {
      title = `Stock Transfer No : ${formdata.stock_no}`;
    }
    $(`${comments_modal} .modal-title`).text(title);
    $(comments_modal).modal("show");
  });

  $(document).on("click", ".reply_btn", function () {
    var comments_modal = "#comments_modal";

    $(".reply_btn").not(this).val("Reply").removeClass("active_reply");
    $(comments_modal + " [name='parent_id']").val("");

    var $this = $(this);
    if ($this.hasClass("active_reply")) {
      $this.removeClass("active_reply").val("Reply");
      $(comments_modal + " .submit")
        .val("Add Notes")
        .removeClass("btn-danger")
        .addClass("btn-primary");
      $this.removeClass("red").addClass("green");
    } else {
      $this.addClass("active_reply").val("Replying..");
      $(comments_modal + " [name='parent_id']").val($this.attr("data-id"));
      $(comments_modal + " .submit")
        .val("Add Reply")
        .removeClass("btn-primary")
        .addClass("btn-danger");
      $this.removeClass("green").addClass("red");
    }
  });

  $(document).on("click", "#comments_modal .submit", function () {
    var comment = $("#input_comment").val();
    if (!comment) {
      alert("Please enter comment");
      return;
    }

    var parent_id = $("#comments_modal [name='parent_id']").val();
    var po_id = $("#comments_modal [name='po_id']").val();
    var comment_type = $("#comments_modal [name='comment_type']").val();

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        add_comment: true,
        comment: comment,
        po_id: po_id,
        parent_id: parent_id,
        comment_type: comment_type,
      },
      success: function (response) {
        if (response == "error") {
          alert("Error Adding Comment");
        } else {
          if (parent_id) {
            // if input is a reply
            $(
              "#comments_area > .portlet-body > .timeline > .timeline-item"
            ).each(function () {
              var id = $(this).find(".reply_btn").attr("data-id");
              if (parent_id == id) {
                var div = reply_comment(response);
                $(this).append(div);
              }
            });

            $("#comments_modal [name='parent_id']").val("");
            $("#comments_modal .submit")
              .val("Add Notes")
              .removeClass("btn-danger")
              .addClass("btn-primary");
            $(".reply_btn")
              .val("Reply")
              .removeClass("active_reply")
              .removeClass("red")
              .addClass("green");
          } else {
            var div = create_comment_div(response);
            $("#comments_area > .portlet-body > .timeline").append(div);
          }
          reload_all_purchases();
          $("#input_comment").val("");
          warehouse_receiving_table.ajax.reload();
        }
      },
      error: function (response) {
        alert(response.responseText);
      },
    });
  });

  function create_comment_div({ id, comment, commenter, datetime }, replies) {
    var div = `<div class="timeline-item mb-0">
              <div class="timeline-badge">
                <div class="timeline-icon">
                    <i class="icon-user-following font-green-haze"></i>
                </div>
              </div>
              <div class="timeline-body">
                  <div class="timeline-body-arrow"></div>
                  <div class="timeline-body-head">
                      <div class="timeline-body-head-caption">
                          <span class="timeline-body-title font-blue-madison">${commenter}</span>
                          <span class="timeline-body-time font-grey-cascade">${datetime}</span>
                      </div>
                      <div class="timeline-body-head-actions">
                        <input type=button class="reply_btn btn btn-sm btn-circle green btn-outline" data-id=${id} value="Reply">
                      </div>
                  </div>
                  <div class="timeline-body-content">
                      <span class="font-grey-cascade">${comment}</span>  
                  </div>        
              </div>`;
    if (replies) {
      replies.forEach((reply) => {
        if (reply.parent_id == id) {
          div += reply_comment(reply);
        }
      });
    }
    div += `</div>`;
    return div;
  }

  function reply_comment(reply) {
    return `<div class="timeline-body"> 
              <div class="timeline-body-head">
                  <div class="timeline-body-head-caption">
                      <span class="timeline-body-title font-blue-madison">${reply.commenter}</span>
                      <span class="timeline-body-time font-grey-cascade">${reply.datetime}</span>
                  </div>
              </div>
              <div class="timeline-body-content">
                  <span class="font-grey-cascade">${reply.comment}</span>  
              </div>
            </div>`;
  }

  $(document).on("click", ".view_po", function () {
    var tab_id = $(this).closest(".tab-pane").attr("id");
    var tr = $(this).closest("tr");
    var formdata = $(`#${tab_id} .main_table`).dataTable().fnGetData(tr);
    view_po(formdata, false);
  });

  $(document).on("click", ".push_po", function () {
    var elem = $(this);
    var id = elem.attr("data-id");
    var status = elem.attr("data-status");
    var prefix = elem.attr("data-prefix");
    var modal_title = elem.attr("data-modal-title");
    var title_html = `<strong class='${
      prefix == "cancelled_by" ? "text-danger" : "text-primary"
    }'>${modal_title}</strong>`;
    var sig_counter = elem.attr("data-signature-counter");

    $("#signature_modal [name='id']").val(id);
    $("#signature_modal [name='status']").val(status);
    $("#signature_modal [name='prefix']").val(prefix);

    $("#signature_modal .modal-title").html(title_html);
    $("#signature_modal .modal-body .contents").html(
      sig_div(sig_counter, prefix, "Name")
    );
    $("#signature-pad-" + sig_counter).jSignature({ width: 300, height: 50 });
    $("#signature_modal").modal("show");
  });

  $(document).on("click", "#signature_modal .submit", function () {
    var modal_id = "#signature_modal";
    var id = $(`${modal_id} [name='id']`).val();
    var status = $(`${modal_id} [name='status']`).val();
    var prefix = $(`${modal_id} [name='prefix']`).val();
    var signature_value = $(`${modal_id} [name='${prefix}_sig']`).val();
    var name_value = $(`${modal_id} [name='${prefix}_name']`).val();
    var position_value = $(`${modal_id} [name='${prefix}_position']`).val();

    if (!signature_value || !name_value || !position_value) {
      alert("Enter signature, name and position of authorized personnel");
      return;
    }

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        update_status: true,
        id: id,
        status: status,
        prefix: prefix,
        signature_value: signature_value,
        name_value: name_value,
        position_value: position_value,
      },
      success: function (response) {
        reload_all_purchases();
        reload_whouse_tables();
        $("#signature_modal").modal("hide");
        growl(response.message, response.type);
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });
  });

  $(document).on("click", ".delete_po", function () {
    var tr = $(this).closest("tr");
    var formdata = $("#draft .main_table").dataTable().fnGetData(tr);

    confirm_action(
      `Delete ${formdata.po}`,
      `Are you sure you want to delete this PO?`,
      function () {
        $.ajax({
          url: path,
          type: "post",
          dataType: "json",
          data: {
            delete_po: true,
            id: formdata.id,
          },
          success: function (response) {
            reload_all_purchases();
            growl(response.message, response.type);
          },
          error: function (response) {
            console.log(response.responseText);
          },
        });
      }
    );
  });

  $(document).on("click", ".print_po", function () {
    var tab_id = $(this).closest(".tab-pane").attr("id");
    var tr = $(this).closest("tr");
    var formdata = $(`#${tab_id} .main_table`).dataTable().fnGetData(tr);
    var url = `print_po.php?id=${formdata.id}`;
    window.open(url, "_blank");
  });

  $(document).on("click", ".print_checklist", function () {
    var tr = $(this).closest("tr");
    var formdata = $(`#receiving .main_table`).dataTable().fnGetData(tr);
    var url = `print_checklist.php?id=${formdata.id}`;
    window.open(url, "_blank");
  });

  $(document).on("click", ".update_po", function () {
    var tr = $(this).closest("tr");
    var formdata = $("#draft .main_table").dataTable().fnGetData(tr);
    view_po(formdata, true);
  });

  $(document).on("change", "#add_po_modal [name='supplier_id']", function () {
    var supplier_id = $(this).val();
    $("#sub_total, #tax, #total_price").text("");

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        get_items_from_supplier: true,
        supplier_id: supplier_id,
      },
      success: function (response) {
        var div = "";
        response.forEach((el) => {
          div += `<tr>`;
          div += `<td><input type=checkbox class=form-control></td>`;
          div += `<td class=hidden><input type=text class=form-control name=raw_material_id value='${el.id}' readonly></td>`;
          div += `<td><input type=text class=form-control name=sku value='${el.sku}' readonly></td>`;
          div += `<td><input type=text class=form-control name=item value='${el.raw_materials}' readonly></td>`;
          div += `<td><input type=text class=form-control name=category value='${el.category}' readonly></td>`;
          div += `<td><input type=number class=form-control name=quantity value=1></td>`;
          div += `<td><input type=text class=form-control name=uom value='${el.uom}' readonly></td>`;
          div += `<td><input type=text class=form-control name=price_per_unit value='${el.price_per_unit}' readonly></td>`;
          div += `<td><span class=display_currency></span></td>`;
          div += `<td><input type=text class=form-control name=total_price value='${el.price_per_unit}' readonly></td>`;
          div += `<td><span class=display_currency></span></td>`;
          div += `<td><input type=text class=form-control name=tax></td>`;
          div += `</tr>`;
        });
        $("#add_po_modal .item_table tbody").html(div);
        $("#add_po_modal form [name='created_date']").val(current_date);
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });
  });

  $(document).on("click", "#add_po_modal .submit", function () {
    // confirm_action("Add Purchase Order", "Are you sure you want to add purchase order?", function(){

    // var po_form = $("#add_po_modal form").serializeArray();
    var modal_id = "#add_po_modal";
    var supplier_id = $(`${modal_id} [name='supplier_id']`).val();
    var location_id = $(`${modal_id} [name='location_id']`).val();
    var expected_arrival = $(`${modal_id} [name='expected_arrival']`).val();
    var created_date = $(`${modal_id} [name='created_date']`).val();
    var po = $(`${modal_id} [name='po']`).val();
    var currency = $(`${modal_id} [name='currency']`).val();

    if (
      !supplier_id ||
      !location_id ||
      !expected_arrival ||
      !created_date ||
      !po ||
      !currency
    ) {
      alert(
        "Please enter supplier, location, expected arrival, PO number, currency"
      );
      return;
    }

    var po_form = [];
    po_form.push(get_obj("expected_arrival", expected_arrival));
    po_form.push(get_obj("created_date", created_date));
    po_form.push(get_obj("po", po));
    po_form.push(get_obj("currency", currency));
    po_form.push(get_obj("location_id", location_id));
    po_form.push(get_obj("supplier_id", supplier_id));
    po_form.push(get_obj("remarks", $("#remarks").val()));
    // po_form.push(get_obj("supplier", $("#add_po_modal [name='supplier_id'] option:selected").text()))
    po_form.push(get_obj("sub_total", $("#sub_total").text()));
    po_form.push(get_obj("tax", $("#tax").text()));
    po_form.push(get_obj("total_price", $("#total_price").text()));
    po_form.push(get_obj("shipping", $("#shipping").val()));

    var items_form = [];
    $("#add_po_modal .item_table tbody tr").each(function () {
      var parent = $(this);
      var is_checked = parent.find("input[type='checkbox']").is(":checked");
      const names = [
        "raw_material_id",
        "item",
        "sku",
        "category",
        "quantity",
        "uom",
        "price_per_unit",
        "total_price",
        "tax",
      ];
      if (is_checked) {
        var row_item = [];
        names.forEach((name) => {
          row_item.push(get_obj(name, parent.find(`[name='${name}']`).val()));
        });
        items_form.push(row_item);
      }
    });

    if (items_form.length == 0) {
      alert("Select raw materials");
      return;
    }

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        add_po: true,
        po_form: JSON.stringify(po_form),
        items_form: JSON.stringify(items_form),
      },
      success: function (response) {
        if (response.type == "success") {
          reload_all_purchases();
          $("#add_po_modal").modal("hide");
          $("#add_po_modal [name], #shipping").val("");
          $("#add_po_modal .item_table tbody").html("");
          $("#sub_total, #tax, #total_price").text("");
          growl(response.message, response.type);
        } else {
          alert(response.message);
        }
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });
    // })
  });

  $(document).on("click", "#edit_po_modal .submit", function () {
    var id = $("#edit_po_modal [name='id']").val();
    var expected_arrival = $("#edit_po_modal [name='expected_arrival']").val();
    var remarks = $("#edit_po_modal [name='remarks']").val();

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        update_po: true,
        id: id,
        expected_arrival: expected_arrival,
        remarks: remarks,
      },
      success: function (response) {
        reload_all_purchases();
        $("#edit_po_modal").modal("hide");
        growl(response.message, response.type);
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });
  });

  function view_po(formdata, editable) {
    var modal_id = "#edit_po_modal";

    if (editable == false) {
      $(
        modal_id +
          " [name='expected_arrival'], " +
          modal_id +
          " [name='remarks']"
      ).prop("disabled", "disabled");
      $(modal_id + " .submit").hide();
    } else {
      $(
        modal_id +
          " [name='expected_arrival'], " +
          modal_id +
          " [name='remarks']"
      ).removeAttr("disabled");
      $(modal_id + " .submit").show();
    }

    populate(modal_id + " form", formdata);
    $(modal_id + " [name='sub_total']").text(formdata.sub_total);
    $(modal_id + " [name='tax']").text(formdata.tax);
    $(modal_id + " [name='shipping']").text(formdata.shipping);
    $(modal_id + " [name='total_price']").text(formdata.total_price);

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        get_po_items_details: true,
        po_id: formdata.id,
      },
      success: function (response) {
        var div = "";
        response.forEach((el) => {
          div += `<tr>`;
          div += `<td><input type=text class=form-control name=sku value='${el.sku}' readonly></td>`;
          div += `<td><input type=text class=form-control name=item value='${el.item}' readonly></td>`;
          div += `<td><input type=text class=form-control name=category value='${el.category}' readonly></td>`;
          div += `<td><input type=number class=form-control name=quantity value='${el.quantity}' readonly></td>`;
          div += `<td><input type=text class=form-control name=uom value='${el.uom}' readonly></td>`;
          div += `<td><input type=text class=form-control name=price_per_unit value='${el.price_per_unit}' readonly></td>`;
          div += `<td>${formdata.currency}</td>`;
          div += `<td><input type=text class=form-control name=total_price value='${el.total_price}' readonly></td>`;
          div += `<td>${formdata.currency}</td>`;
          div += `<td><input type=text class=form-control name=tax value='${el.tax}' readonly></td>`;
          div += `</tr>`;
        });
        $(modal_id + " .item_table tbody").html(div);
        $(modal_id + " .display_currency").text(formdata.currency);
        $(modal_id + "#edit_po_modal").modal("show");
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });
  }

  function reload_all_purchases() {
    all_purchases_main_table.ajax.reload(function () {
      root1.dispose();
      generate_barchart();
    });
    draft_main_table.ajax.reload();
    for_approval_main_table.ajax.reload();
    for_delivery_main_table.ajax.reload();
    received_main_table.ajax.reload();
    cancelled_main_table.ajax.reload();
  }

  $(document).on("keyup", "#add_po_modal .item_table input", function () {
    compute_total();
  });

  $(document).on(
    "change",
    "#add_po_modal .item_table [name='quantity']",
    function () {
      multiply_price(this);
      compute_total();
    }
  );

  $(document).on(
    "change",
    "#add_po_modal .item_table input[type='checkbox']",
    function () {
      compute_total();
    }
  );

  $(document).on(
    "keyup",
    "#add_po_modal .item_table [name='quantity'], #add_po_modal .item_table [name='price_per_unit']",
    function () {
      multiply_price(this);
      compute_total();
    }
  );

  $(document).on("keyup", "#shipping", function () {
    compute_total();
  });

  function multiply_price(elem) {
    var parent = $(elem).closest("tr");
    var quantity = parent.find("[name='quantity']").val();
    var price_per_unit = parent.find("[name='price_per_unit']").val();
    var total_price = parent.find("[name='total_price']");

    if (isNaN(quantity) || isNaN(price_per_unit)) {
      return;
    }

    var total = parseFloat(quantity) * parseFloat(price_per_unit);
    total_price.val(total);
  }

  function compute_total() {
    var subtotal = 0;
    var total_tax = 0;
    var total = 0;

    $("#add_po_modal .item_table tbody tr").each(function () {
      var parent = $(this);
      var is_checked = parent.find("input[type='checkbox']").is(":checked");

      if (is_checked) {
        var total_price = parent.find("[name='total_price']").val();
        if (!isNaN(total_price) && total_price) {
          total_price = parseFloat(total_price);
          subtotal += total_price;
          // total += total_price
        }
        var tax = parent.find("[name='tax']").val();
        if (!isNaN(tax) && tax) {
          var tax = parseFloat(tax);
          total_tax += (tax / 100) * total_price;
          // total += total_tax
        }
      }
    });

    total += subtotal + total_tax;
    var shipping = $("#shipping").val();
    if (!isNaN(shipping) && shipping) {
      total += parseFloat(shipping);
    }

    $("#sub_total").text(subtotal);
    $("#tax").text(total_tax);
    $("#total_price").text(total);
  }

  $(document).on("keyup", "[name='currency']", function () {
    var modal_id = $(this).parent(".modal").attr("id");
    $(`#${modal_id} .display_currency`).text($(this).val());
  });

  // ------ WAREHOUSE ------
  var warehouse_receiving_table,
    materials_inventory_table,
    stock_transfer_out_table,
    stock_transfer_in_table;
  var stock_card_table, raw_material_id, location_id;

  function warehouse_init() {
    warehouse_receiving_table = $("#receiving .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_warehouse_receiving_data: true,
        },
      },
      columns: [
        {
          title: "Order Date", //0
          data: "order_date",
        },
        {
          title: "Purchase Order", //1
        },
        {
          title: "Supplier Name", //2
          data: "supplier_name",
        },
        {
          title: "Location", // 3
          data: "location",
        },
        {
          title: "Expected Arrival", //4
          data: "expected_arrival",
        },
        {
          title: "Delivery Status", //5
          data: "status",
        },
        {
          title: "Checklist Status", //6
          data: "checklist_status",
        },
        {
          title: "#", //7
          data: "total_comments",
        },
        {
          title: "Print", //8
          width: "15%",
          sortable: false,
        },
      ],
      columnDefs: [
        {
          targets: 1,
          render: function (data, type, row) {
            if (row.record_type == 1) {
              return `<a href='#' class=whouse_view_po_modal>${row.po}</a>`;
            } else {
              return `<a href='#' class=receive_stock_transfer>${row.po}</a>`;
            }
          },
        },
        {
          targets: 2,
          render: function (data, type, row) {
            if (row.record_type == 1) {
              return `<a href='#' class=whouse_view_supplier_modal>${row.supplier_name}</a>`;
            } else {
              return ``;
            }
          },
        },
        {
          targets: 5,
          render: function (data, type, row) {
            return display_status(data);
          },
        },
        {
          targets: 6,
          render: function (data, type, row) {
            if (row.record_type == 1) {
              var span_color;
              switch (data) {
                case "For Inspection":
                  span_color = "text-danger";
                  break;
                case "Inspected":
                  span_color = "text-warning";
                  break;
                case "Completed":
                  span_color = "text-success";
                  break;
                default:
                  span_color = "text-primary";
              }
              return `<span class=${span_color}><strong>${data}</strong></data>`;
            } else {
              return ``;
            }
          },
        },
        {
          targets: 7,
          render: function (data, type, row) {
            if (row.record_type == 1) {
              return display_comment_btn(data);
            } else {
              return ``;
            }
          },
        },
        {
          targets: 8,
          render: function (data, type, row) {
            if (row.record_type == 1) {
              return `<input type=button class="btn btn-sm btn-warning print_po" value="PO">
                <input type=button class="btn btn-sm btn-info print_checklist" value="Checklist">`;
            } else {
              return ``;
            }
          },
        },
        {
          targets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
          className: "text-center",
        },
      ],
      dom: 'l<"toolbar">frtip',
      initComplete: function () {
        $("#receiving div.dataTables_filter").prepend(location_elem);
      },
      language: {
        search: "",
        searchPlaceholder: "Search",
      },
      autoWidth: false,
    });

    materials_inventory_table = $("#materials_inventory .main_table").DataTable(
      {
        ajax: {
          url: path,
          type: "post",
          dataType: "json",
          data: {
            get_materials_inventory: true,
          },
        },
        columns: [
          {
            title: "SKU/Item #", //0
            data: "sku",
          },
          {
            title: "Material Name", //1
            data: "material_name",
          },
          {
            title: "Category", //2
            data: "category",
          },
          {
            title: "Location", //3
            data: "location",
          },
          {
            title: "Lot/Batch No.", //4
            data: "lot_batch_no",
          },
          {
            title: "Supplier Lot Code", //4
            data: "supplier_lot_code",
          },
          {
            title: "Internal Lot Code", //5
            data: "internal_lot_code",
          },
          {
            title: "Mfg Date", //6
            data: "mfg_date",
          },
          {
            title: "UoM", //7
            data: "uom",
          },
          {
            title: "Incoming", //8
            data: "incoming",
          },
          {
            title: "Reorder", //9
            data: "reorder",
          },
          {
            title: "Price Per Unit", //10
            data: "price_per_unit",
          },
          {
            title: "Total Amount", //11
            // data: "total_amount",
          },
          {
            title: "Quantity", //12
            data: "quantity",
          },
          {
            title: "Stock Transfer In", //13
            data: "str_in",
          },
          {
            title: "Stock Transfer Out", //14
            data: "str_out",
          },
          {
            title: "Variance", //15
            data: "variance",
          },
        ],
        columnDefs: [
          {
            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
            className: "text-center",
          },
          {
            targets: 1,
            render: function (data, type, row) {
              return `<a href='#' class=view_stock_card>${data}</a>`;
            },
          },
          {
            targets: 10,
            render: function (data, type, row) {
              return `<div class="cell_item text-center">
                <a href="#" class="cell_value ${
                  data ? "text-primary" : "text-warning"
                }" data-column='reorder'>${data ? data : "Set"}</a>
              </div>`;
            },
          },
          {
            targets: 12,
            render: function (data, type, row) {
              var total = parseInt(row.price_per_unit) * parseInt(row.quantity);
              return total ? total : 0;
            },
          },
        ],
        initComplete: function () {
          $("#materials_inventory div.dataTables_filter").prepend(
            location_elem
          );
        },
        language: {
          search: "",
          searchPlaceholder: "Search",
        },
        autoWidth: false,
      }
    );

    stock_transfer_out_table = $("#stock_transfer_out .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_stock_transfers: true,
          transfer_type: "str_out",
        },
      },
      columns: [
        {
          title: "Lot/Batch #", //0
          data: "lot_batch_no",
        },
        {
          title: "Stock No", //1
          data: "stock_no",
        },
        {
          title: "Item Name", //2
          data: "item_name",
        },
        {
          title: "UoM", //3
          data: "uom",
        },
        {
          title: "Quantity", //4
          data: "quantity",
        },
        {
          title: "Destination", //5
          data: "location",
        },
        {
          title: "Trasferred Date", //6
          data: "transfer_date",
        },
        {
          title: "Transfer For", //7
          data: "transfer_for",
        },
        {
          title: "#", //8
          data: "total_comments",
        },
      ],
      columnDefs: [
        {
          targets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
          className: "text-center",
        },
        {
          targets: 8,
          render: function (data, type, row) {
            return display_comment_btn(data, "str");
          },
        },
      ],
      dom: 'l<"toolbar">frtip',
      initComplete: function () {
        $("#stock_transfer_out div.dataTables_filter").prepend(location_elem);
      },
      language: {
        search: "",
        searchPlaceholder: "Search",
      },
    });

    stock_transfer_in_table = $("#stock_transfer_in .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_stock_transfers: true,
          transfer_type: "str_out",
        },
      },
      columns: [
        {
          title: "Lot/Batch #", //0
          data: "lot_batch_no",
        },
        {
          title: "Stock No", //1
          data: "stock_no",
        },
        {
          title: "Item Name", //2
          data: "item_name",
        },
        {
          title: "UoM", //3
          data: "uom",
        },
        {
          title: "Quantity", //4
          data: "quantity",
        },
        {
          title: "Destination", //5
          data: "location",
        },
        {
          title: "Trasferred Date", //6
          data: "transfer_date",
        },
        {
          title: "Transfer For", //7
          data: "transfer_for",
        },
      ],
      columnDefs: [
        {
          targets: [0, 1, 2, 3, 4, 5, 6, 7],
          className: "text-center",
        },
      ],
      dom: 'l<"toolbar">frtip',
      initComplete: function () {
        $("#stock_transfer_in div.dataTables_filter").prepend(location_elem);
      },
      language: {
        search: "",
        searchPlaceholder: "Search",
      },
    });

    stock_card_table = $("#stock_card_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: function (d) {
          d.get_stock_card_details = true;
          d.raw_material_id = raw_material_id;
          d.location_id = location_id;
        },
      },
      columns: [
        {
          title: "Date", //0
          data: "formatted_date",
        },
        {
          title: "Quantity", //1
          data: "quantity",
        },
        {
          title: "Transfer Out", //2
          data: "transfer_out",
        },
        {
          title: "Transfer In", //3
          data: "transfer_in",
        },
        {
          title: "Deliveries", //4
          data: "deliveries",
        },
        {
          title: "Date", //5
          data: "dt",
          className: "hidden",
        },
      ],
      columnDefs: [
        {
          targets: [0, 1, 2, 3, 4],
          className: "text-center",
        },
      ],
      //  searching: false, paging: true, info: false
    });

    date_filter();
  }

  function reload_whouse_tables() {
    warehouse_receiving_table.ajax.reload();
    materials_inventory_table.ajax.reload();
  }

  $(document).on("click", ".whouse_view_po_modal", function (e) {
    e.preventDefault();

    var modal_id = "#view_warehouse_receiving_po_modal";

    var tr = $(this).closest("tr");
    var data = $("#receiving table").dataTable().fnGetData(tr);
    supply_data(
      modal_id,
      "id,po_id,supplier_name,location,po,expected_arrival",
      "id,po_id,supplier_name,location,po,expected_arrival",
      data
    );
    $(`${modal_id} [name='created_date']`).val(data.order_date);
    $(`${modal_id} [name='expected_arrival']`).val(data.expected_arrival);

    if (data.date_po_received) {
      $(`${modal_id} [name='remarks']`).val(data.remarks);
      $(
        `${modal_id} [name='remarks'], ${modal_id} [name='expected_arrival']`
      ).attr("disabled", "disabled");

      var sig_div1 = get_fsig(
        "Received By",
        data.po_received_by_sig,
        data.po_received_by_name,
        data.po_received_by_position,
        data.date_po_received
      );
      $("#whouse_received_container").html(sig_div1);
      $(`${modal_id} .submit`).addClass("hidden");
    } else {
      $(
        `${modal_id} [name='remarks'], ${modal_id} [name='expected_arrival']`
      ).removeAttr("disabled");

      $("#whouse_received_container").html(
        sig_div(4, "po_received_by", "Received By")
      );
      $("#signature-pad-" + 4).jSignature({ width: 300, height: 50 });
      $(`${modal_id} .submit`).removeClass("hidden");
    }

    var disabled = data.date_po_received ? "disabled" : "";

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        get_po_order_items: true,
        po_id: data.po_id,
      },
      success: function (response) {
        var items_table = $("#warehouse_receiving_items");
        items_table.find("tbody").html("");
        response.forEach((el) => {
          var div = `<tr id=${el.id}>
            <td><input type=text class=form-control value='${
              el.sku
            }' disabled></td>
            <td><input type=text class=form-control value='${
              el.item
            }' disabled></td>
            <td><input type=text class=form-control value='${
              el.category
            }' disabled></td>
            <td><input type=text class=form-control value='${
              el.quantity
            }' disabled></td>
            <td><input type=text class=form-control value='${
              el.uom
            }' disabled></td>
            <td><input type=date class=form-control name=mfg_date value="${
              el.mfg_date ? el.mfg_date : ""
            }" ${disabled}></td>
            <td><input type=text class=form-control name=quantity_received value="${
              el.quantity_received ? el.quantity_received : ""
            }" ${disabled}></td>
            <td><input type=text class=form-control name=supplier_lot_code value="${
              el.supplier_lot_code ? el.supplier_lot_code : ""
            }" ${disabled}></td>
            <td><input type=text class=form-control name=internal_lot_code value="${
              el.internal_lot_code ? el.internal_lot_code : ""
            }" ${disabled}></td>`;
          items_table.append(div);
        });
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });
    $(modal_id).modal("show");
  });

  $(document).on(
    "click",
    "#view_warehouse_receiving_po_modal .submit",
    function () {
      // confirm_action("Save Entries", "Are you sure you want to save entries?", function(){

      const modal_id = "#view_warehouse_receiving_po_modal";

      var table_items = [];
      $(`#warehouse_receiving_items tbody tr`).each(function () {
        // var name  = $(this).attr("id")
        // var value = $(this).find("[name='quantity_received']").val()
        // table_items.push(get_obj(name,value))
        var table_item = [];
        var value = $(this).attr("id");
        table_item.push(get_obj("id", value));

        value = $(this).find("[name='quantity_received']").val();
        table_item.push(get_obj("quantity_received", value));

        value = $(this).find("[name='lot_batch_no']").val();
        table_item.push(get_obj("lot_batch_no", value));

        value = $(this).find("[name='mfg_date']").val();
        table_item.push(get_obj("mfg_date", value));

        value = $(this).find("[name='supplier_lot_code']").val();
        table_item.push(get_obj("supplier_lot_code", value));

        table_item.push(get_obj("internal_lot_code", value));
        value = $(this).find("[name='internal_lot_code']").val();

        table_items.push(table_item);
      });

      var form_items = [];
      form_items.push(get_obj("id", $(`${modal_id} [name='id']`).val()));
      form_items.push(get_obj("po_id", $(`${modal_id} [name='po_id']`).val()));
      form_items.push(
        get_obj("remarks", $(`${modal_id} [name='remarks']`).val())
      );

      var po_received_by_name = $(
        `${modal_id} [name='po_received_by_name']`
      ).val();
      if (po_received_by_name) {
        po_received_by_name = po_received_by_name.trim();
        form_items.push(
          get_obj(
            "po_received_by_sig",
            $(`${modal_id} [name='po_received_by_sig']`).val()
          )
        );
        form_items.push(get_obj("po_received_by_name", po_received_by_name));
        form_items.push(
          get_obj(
            "po_received_by_position",
            $(`${modal_id} [name='po_received_by_position']`).val()
          )
        );
      } else {
        alert("Please provide name of receiver");
        return;
      }

      $.ajax({
        type: "post",
        url: path,
        dataType: "json",
        data: {
          whouse_po_save: true,
          form_items: JSON.stringify(form_items),
          table_items: JSON.stringify(table_items),
        },
        success: function (response) {
          $(modal_id).modal("hide");
          if (response.result === "error") {
            alert(response.message);
          } else {
            reload_whouse_tables();
            reload_all_purchases();
            growl(response.message, response.type);
          }
        },
        error: function (response) {
          alert(response.responseText);
        },
      });
      // })
    }
  );

  $(document).on("click", ".whouse_view_supplier_modal", function (e) {
    e.preventDefault();

    var modal_id = "#view_warehouse_supplier_modal";
    $(`${modal_id} [name!='data_type']`).val("");

    var tr = $(this).closest("tr");
    var data = $("#receiving table").dataTable().fnGetData(tr);
    // console.log(data)
    supply_data(
      modal_id,
      "id,date_received,arrival_time,po,supplier_name,invoice,trailer_no,trailer_plate,trailer_seal",
      "po,supplier_name",
      data,
      data.date_supplier_verified
    );
    $(modal_id + " [name='warehouse_receiving_id']").val(data.id);

    if (data.date_supplier_inspected) {
      var sig_div1 = get_fsig(
        "Inspected By",
        data.supplier_inspected_by_sig,
        data.supplier_inspected_by_name,
        data.supplier_inspected_by_position,
        data.date_supplier_inspected
      );
      $("#inspected2_container").html(sig_div1);
    } else {
      $("#inspected2_container").html(
        sig_div(6, "supplier_inspected_by", "Inspected By")
      );
      $("#signature-pad-" + 6).jSignature({ width: 300, height: 50 });
    }

    if (data.date_supplier_verified) {
      var sig_div2 = get_fsig(
        "Verified By",
        data.supplier_verified_by_sig,
        data.supplier_verified_by_name,
        data.supplier_verified_by_position,
        data.date_supplier_verified
      );
      $("#verified2_container").html(sig_div2);

      // hide submit button
      $(`${modal_id} .submit`).addClass("hidden");
      $(
        "#warehouse_receiving_table1 tfoot,#warehouse_receiving_table2 tfoot"
      ).addClass("hidden");
    } else {
      $("#verified2_container").html(
        sig_div(7, "supplier_verified_by", "Verified By")
      );
      $("#signature-pad-" + 7).jSignature({ width: 300, height: 50 });

      $(`${modal_id} .submit`).removeClass("hidden");
      $(
        "#warehouse_receiving_table1 tfoot,#warehouse_receiving_table2 tfoot"
      ).removeClass("hidden");
    }
    // console.log(data)

    // if(data.date_inspected){
    //   var content = get_fsig(data.performed_by_sig, data.performed_by_img, data.performed_by_name, data.date_performed);
    //   $("#inspected_container").html(content);
    // }else{
    //   var content = sig_div(1, "inspected_by")
    //   $("#inspected_container").html(content);
    //   $('#signature-pad-'+1).jSignature({'width': 250, 'height':50});
    // }

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        get_warehouse_receiving_checklist_details_by_warehouse_id: true,
        id: data.id,
      },
      success: function (response) {
        var warehouse_receiving_table1 = $("#warehouse_receiving_table1 tbody");
        var warehouse_receiving_table2 = $("#warehouse_receiving_table2 tbody");

        warehouse_receiving_table1.html("");
        warehouse_receiving_table2.html("");
        var counter1 = 1,
          counter2 = 1;
        response.forEach((el, index) => {
          var div = `<tr id=${el.id}>
              <td>${el.item_type == "1" ? counter1 : counter2}</td>
              <td>${el.description}</td>
              <td class=text-center colspan=3>
                <label class="radio-inline">
                  <input type="radio" name="inlineRadio${
                    index + el.id
                  }" value=1 ${el.value == 1 ? "checked" : ""} ${
            data.date_supplier_verified ? "disabled" : ""
          }> Yes
                </label>
                <label class="radio-inline">
                  <input type="radio" name="inlineRadio${
                    index + el.id
                  }" value=2 ${el.value == 2 ? "checked" : ""} ${
            data.date_supplier_verified ? "disabled" : ""
          }> No
                </label>
                <label class="radio-inline">
                  <input type="radio" name="inlineRadio${
                    index + el.id
                  }" value=3 ${el.value == 3 ? "checked" : ""} ${
            data.date_supplier_verified ? "disabled" : ""
          }> N/A
                </label>  
              </td>
              <td><input type=text class=form-control name=corrective_action value='${
                el.corrective_action
              }' ${data.date_supplier_verified ? "disabled" : ""}></td>
            </tr>`;

          if (el.item_type == "1") {
            warehouse_receiving_table1.append(div);
            counter1++;
          } else {
            warehouse_receiving_table2.append(div);
            counter2++;
          }
        });
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });

    $(modal_id).modal("show");
  });

  $(document).on(
    "click",
    "#view_warehouse_supplier_modal .submit",
    function () {
      var modal_id = "#view_warehouse_supplier_modal";

      var formdata = [];
      formdata.push(get_obj("id", $(`${modal_id} [name='id']`).val()));
      formdata.push(
        get_obj("date_received", $(`${modal_id} [name='date_received']`).val())
      );
      formdata.push(
        get_obj("arrival_time", $(`${modal_id} [name='arrival_time']`).val())
      );
      formdata.push(
        get_obj("invoice", $(`${modal_id} [name='invoice']`).val())
      );
      formdata.push(
        get_obj("trailer_no", $(`${modal_id} [name='trailer_no']`).val())
      );
      formdata.push(
        get_obj("trailer_plate", $(`${modal_id} [name='trailer_plate']`).val())
      );
      formdata.push(
        get_obj("trailer_seal", $(`${modal_id} [name='trailer_seal']`).val())
      );

      var supplier_inspected_by_name = $(
        `${modal_id} [name='supplier_inspected_by_name']`
      ).val();
      if (supplier_inspected_by_name) {
        supplier_inspected_by_name = supplier_inspected_by_name.trim();
        formdata.push(
          get_obj(
            "supplier_inspected_by_sig",
            $(`${modal_id} [name='supplier_inspected_by_sig']`).val()
          )
        );
        formdata.push(
          get_obj("supplier_inspected_by_name", supplier_inspected_by_name)
        );
        formdata.push(
          get_obj(
            "supplier_inspected_by_position",
            $(`${modal_id} [name='supplier_inspected_by_position']`).val()
          )
        );
      }

      var supplier_verified_by_name = $(
        `${modal_id} [name='supplier_verified_by_name']`
      )
        .val()
        .trim();
      if (supplier_verified_by_name) {
        formdata.push(
          get_obj(
            "supplier_verified_by_sig",
            $(`${modal_id} [name='supplier_verified_by_sig']`).val()
          )
        );
        formdata.push(
          get_obj("supplier_verified_by_name", supplier_verified_by_name)
        );
        formdata.push(
          get_obj(
            "supplier_verified_by_position",
            $(`${modal_id} [name='supplier_verified_by_position']`).val()
          )
        );
      }

      var checklist = [];
      $(
        "#warehouse_receiving_table1 tbody tr, #warehouse_receiving_table2 tbody tr"
      ).each(function () {
        var id = $(this).attr("id");
        var value = $(this).find('[type="radio"]:checked').val();
        var corrective_action = $(this)
          .find('[name="corrective_action"]')
          .val();
        if (value) {
          var obj = {
            id: id,
            value: value,
            corrective_action: corrective_action,
          };
          checklist.push(obj);
        }
      });
      // console.log(checklist)
      $.ajax({
        type: "post",
        url: path,
        dataType: "json",
        data: {
          whouse_supplier_save: true,
          formdata: JSON.stringify(formdata),
          checklist: JSON.stringify(checklist),
          supplier_inspected: $(
            `${modal_id} [name='supplier_inspected_by_name']`
          ).val()
            ? true
            : false,
          supplier_verified: $(
            `${modal_id} [name='supplier_verified_by_name']`
          ).val()
            ? true
            : false,
        },
        success: function (response) {
          $(modal_id).modal("hide");
          // swal.close();
          if (response.result === "error") {
            alert(response.message);
          } else {
            reload_whouse_tables();
          }
        },
        error: function (response) {
          alert(response.responseText);
        },
      });
    }
  );

  $(document).on("click", ".add_item_btn", function () {
    var tr = $(this).closest("tr");
    var input = tr.find('input[name="add_entry"]');
    var item_type = tr.find('input[name="data_type"]').val();

    $.ajax({
      type: "post",
      url: path,
      data: {
        add_entry: true,
        warehouse_receiving_id: tr
          .find('input[name="warehouse_receiving_id"]')
          .val(),
        item_type: item_type,
        description: input.val(),
      },
      dataType: "json",
      success: function (response) {
        if ((response.type = "success")) {
          var counter1 = $(
            `#warehouse_receiving_table${item_type} tbody tr`
          ).length;
          var div = `<tr id=${response.message}>
              <td>${counter1 + 1}</td>
              <td>${input.val()}</td>
              <td class=text-center colspan=3>
                <label class="radio-inline">
                  <input type="radio" name="inlineRadio${
                    counter1 + input.val()
                  }" value=1> Yes
                </label>
                <label class="radio-inline">
                  <input type="radio" name="inlineRadio${
                    counter1 + input.val()
                  }" value=2> No
                </label>
                <label class="radio-inline">
                  <input type="radio" name="inlineRadio${
                    counter1 + input.val()
                  }" value=3> N/A
                </label>  
              </td>
              <td><input type=text class=form-control name=corrective_action></td>
            </tr>`;
          $(`#warehouse_receiving_table${item_type} tbody`).append(div);
          input.val("");
        } else {
          alert(response.message);
        }
      },
      error: function (response) {
        alert(response.responseText);
      },
    });
  });

  $(document).on("click", ".cell_value", function (e) {
    e.preventDefault();

    var column = $(this).attr("data-column");
    var value = $(this).text();
    var parent = $(this).closest(".cell_item");
    parent.html(
      `<input type=${
        column == "location" ? "text" : "number"
      } class="form-control cell_input" data-column='${column}' value='${
        value == "Set" ? "" : value
      }'>`
    );
  });

  $(document).on("keypress", ".cell_input", function (event) {
    var keycode = event.keyCode ? event.keyCode : event.which;
    if (keycode == "13") {
      var value = $(this).val();
      var column = $(this).attr("data-column");
      var parent = $(this).closest(".cell_item");
      var tr = $(this).closest("tr");
      var formdata = $("#materials_inventory .main_table")
        .dataTable()
        .fnGetData(tr);

      $.ajax({
        url: path,
        type: "post",
        dataType: "json",
        data: {
          update_inventory_cell: true,
          id: formdata.id,
          column: column,
          value: value,
        },
        success: function (response) {
          parent.html(
            `<a href="#" class="cell_value text-primary" data-column='${column}'>${value}</a>`
          );
          materials_inventory_table.ajax.reload();
          growl(response.message, response.type);
        },
        error: function (response) {
          console.log(response.responseText);
        },
      });
    }
  });

  $(document).on(
    "change",
    '#add_stock_transfer_modal [name="location_id"]',
    function () {
      var modal_id = "#add_stock_transfer_modal";
      var value = $(this).val();
      if (!value) {
        [
          "raw_material_id",
          "current_stock",
          "uom",
          "quantity",
          "transfer_for",
          "transfer_date",
          "notes",
        ].forEach((el) => {
          $(`${modal_id} [name='${el}']`).val("");
        });
        $("#stock_transfer_sources tbody").html("");
        return;
      }

      $.ajax({
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_available_items: true,
          location_id: value,
        },
        success: function (response) {
          var div = create_select_elem(response, "Item");
          $('#add_stock_transfer_modal [name="raw_material_id"]').html(div);
        },
        error: function (response) {
          console.log(response.responseText);
        },
      });
    }
  );

  $(document).on(
    "change",
    '#add_stock_transfer_modal [name="raw_material_id"]',
    function () {
      var value = $(this).val();
      $("#stock_transfer_sources tbody").html("");
      if (!value) {
        [
          "current_stock",
          "uom",
          "quantity",
          "transfer_for",
          "transfer_date",
          "notes",
        ].forEach((el) => {
          $(`${modal_id} [name='${el}']`).val("");
        });
        return;
      }

      $.ajax({
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_current_stock: true,
          raw_material_id: value,
          location_id: $(
            '#add_stock_transfer_modal [name="location_id"]'
          ).val(),
        },
        success: function ({ item, sources }) {
          $('#add_stock_transfer_modal [name="current_stock"]').val(
            item.current_stock
          );
          $('#add_stock_transfer_modal [name="uom"]').val(item.uom);
          $('#add_stock_transfer_modal [name="transfer_date"]').val(
            current_date
          );

          sources.forEach((el) => {
            var div = `<tr data-id=${el.id}>
            <td><input type=text class=form-control value='${el.location}' readonly></td>
            <td><input type=text class="current_quantity form-control" value='${el.quantity}' readonly></td>
            <td><input type=number class="source form-control"></td>
          </tr>`;
            $("#stock_transfer_sources tbody").append(div);
          });
        },
        error: function (response) {
          console.log(response.responseText);
        },
      });
    }
  );

  $(document).on("keyup", "#stock_transfer_sources tbody .source", function () {
    update_stock_quantity();
  });

  $(document).on(
    "change",
    "#stock_transfer_sources tbody .source",
    function () {
      update_stock_quantity();
    }
  );

  function update_stock_quantity() {
    var total = 0;
    $("#stock_transfer_sources tbody .source").each(function () {
      var value = $(this).val().trim();
      if (value && !isNaN(value)) {
        total += parseInt(value);
      }
    });
    $("#add_stock_transfer_modal form [name='quantity']").val(total);
  }

  $(document).on("click", "#add_stock_transfer_modal .submit", function () {
    var modal_id = "#add_stock_transfer_modal";

    var with_errors = false;
    $(`${modal_id} form [name]`).each(function () {
      var $this = $(this);
      if ($this.prop("required") && !$this.val()) {
        with_errors = true;
      }
    });
    if (with_errors == true) {
      alert("Please enter all required data items");
      return;
    }

    var formdata = $(`${modal_id} form`).serializeArray();

    var itemlist = [];
    $("#stock_transfer_sources tbody tr").each(function () {
      var materials_inventory_id = $(this).attr("data-id");
      var current_quantity = $(this).find(".current_quantity").val();
      var quantity = $(this).find(".source").val().trim();

      if (quantity && parseInt(quantity) > 0) {
        var obj = {
          materials_inventory_id: materials_inventory_id,
          current_quantity: current_quantity,
          quantity: quantity,
        };
        itemlist.push(obj);
      }
    });

    $.ajax({
      type: "post",
      url: path,
      dataType: "json",
      data: {
        add_stock_transfer: true,
        formdata: JSON.stringify(formdata),
        itemlist: JSON.stringify(itemlist),
      },
      success: function (response) {
        $(modal_id).modal("hide");
        if (response.result === "error") {
          alert(response.message);
        } else {
          $(`${modal_id} [name]`).val("");
          stock_transfer_out_table.ajax.reload();
          stock_transfer_in_table.ajax.reload();
          reload_whouse_tables();
          growl(response.message, response.result);
        }
      },
      error: function (response) {
        alert(response.responseText);
      },
    });
  });

  $(document).on("click", ".receive_stock_transfer", function (e) {
    e.preventDefault();

    var modal_id = "#view_stock_transfer_modal";

    var tr = $(this).closest("tr");
    var data = $("#receiving .main_table").dataTable().fnGetData(tr);

    $.ajax({
      url: path,
      type: "post",
      dataType: "json",
      data: {
        get_stock_transfer_details: true,
        id: data.id,
      },
      success: function ({ details }) {
        // console.log(details)
        var elems = [
          "id",
          "stock_no",
          "lot_batch_no",
          "location",
          "raw_materials",
          "current_stock",
          "uom",
          "quantity",
          "transfer_for",
          "transfer_date",
        ];
        elems.forEach((el) => {
          $(`${modal_id} [name='${el}']`).val(details[el]);
        });

        if (details.date_received) {
          var sig_div1 = get_fsig(
            "Received By",
            details.received_by_sig,
            details.received_by_name,
            details.received_by_position,
            details.date_received
          );
          $("#sig_container").html(sig_div1);
          $(`${modal_id} .submit`).addClass("hidden");
        } else {
          $("#sig_container").html(sig_div(8, "received_by", "Received By"));
          $("#signature-pad-" + 8).jSignature({ width: 300, height: 50 });
          $(`${modal_id} .submit`).removeClass("hidden");
        }
      },
      error: function (response) {
        console.log(response.responseText);
      },
    });
    $(modal_id).modal("show");
  });

  $(document).on("click", "#view_stock_transfer_modal .submit", function () {
    var modal_id = "#view_stock_transfer_modal";

    var form_items = [];
    var received_by_name = $(`${modal_id} [name='received_by_name']`).val();
    if (received_by_name) {
      received_by_name = received_by_name.trim();
      form_items.push(get_obj("id", $(`${modal_id} [name='id']`).val()));
      form_items.push(
        get_obj(
          "received_by_sig",
          $(`${modal_id} [name='received_by_sig']`).val()
        )
      );
      form_items.push(get_obj("received_by_name", received_by_name));
      form_items.push(
        get_obj(
          "received_by_position",
          $(`${modal_id} [name='received_by_position']`).val()
        )
      );
    } else {
      alert("Please provide name of receiver");
      return;
    }

    $.ajax({
      type: "post",
      url: path,
      dataType: "json",
      data: {
        receive_stock_transfer: true,
        form_items: JSON.stringify(form_items),
      },
      success: function (response) {
        $(modal_id).modal("hide");
        if (response.result === "error") {
          alert(response.message);
        } else {
          reload_whouse_tables();
          reload_all_purchases();
          growl(response.message, response.type);
        }
      },
      error: function (response) {
        alert(response.responseText);
      },
    });
  });

  $(document).on("change", ".select_location", function () {
    var search_item = $(this).find("option:selected").text();
    if (search_item == "Select Location") {
      search_item = "";
    }

    var tab_id = $(this).closest(".tab-pane").attr("id");

    switch (tab_id) {
      case "receiving":
        warehouse_receiving_table.columns(3).search(search_item).ajax.reload();
        break;
      case "materials_inventory":
        materials_inventory_table.columns(3).search(search_item).ajax.reload();
        break;
      case "stock_transfer_out":
        stock_transfer_out_table.columns(5).search(search_item).ajax.reload();
        break;
      case "stock_transfer_in":
        stock_transfer_in_table.columns(5).search(search_item).ajax.reload();
        break;
    }
  });

  /**
   * MATERIALS INVENTORY - STOCK CARDS
   */

  $(document).on("click", ".view_stock_card", function (e) {
    e.preventDefault();

    var modal_id = "#view_stock_card";
    var tr = $(this).closest("tr");
    var row = $("#materials_inventory .main_table").dataTable().fnGetData(tr);

    raw_material_id = row.raw_material_id;
    location_id = row.location_id;

    stock_card_table.ajax.reload();

    $(`${modal_id} [name='material_name']`).val(row.material_name);
    $(`${modal_id} [name='location']`).val(row.location);
    $(modal_id).modal("show");
  });

  function date_filter() {
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
      if (settings.nTable.id != "stock_card_table") {
        return true;
      }

      var start_date = $("#view_stock_card [name='start_date']").val();
      var end_date = $("#view_stock_card [name='end_date']").val();
      var value = data[5];

      start_date = Date.parse(start_date);
      end_date = Date.parse(end_date);
      value = Date.parse(value);

      if (
        (value >= start_date && value <= end_date) ||
        (!start_date && !end_date)
      ) {
        return true;
      }
      return false;
    });
  }

  $(document).on("click", "#view_stock_card .filter", function () {
    stock_card_table.draw();
  });

  for (let id = 1; id <= 8; id++) {
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

  // -- JANUARY 10, 2024 -- JS PART 2 START --
  var production_in_progress_table,
    production_products_table,
    production_formulation_table;

  function production_init() {
    production_in_progress_table = $(
      "#production_in_progress .main_table"
    ).DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_production_in_progress_data: true,
        },
      },
      columns: [
        {
          title: "Order Date", //0
          data: "order_date",
        },
        {
          title: "Sales Order#", //1
          data: "sales_order",
        },
        {
          title: "Customer Name", // 2
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
        },
        {
          title: "Production Status", //7
          data: "production_status",
        },
        {
          title: "Action", //8
          width: "15%",
          sortable: false,
        },
      ],
      columnDefs: [
        {
          targets: 6,
          render: function (data, type, row) {
            return `<span class="label label-success">${data}</span>`;
          },
        },
        {
          targets: 7,
          render: function (data, type, row) {
            return `<span class="label label-success">${data}</span>`;
          },
        },
        {
          targets: [4, 5, 6, 7, 8],
          className: "text-center",
        },
        {
          targets: 8,
          render: function (data, type, row) {
            return `<input type=button class="btn btn-sm btn-primary view_production_in_progress" value="View Task">`;
          },
        },
      ],
    });

    production_products_table = $("#production_products .main_table").DataTable(
      {
        ajax: {
          url: path,
          type: "post",
          dataType: "json",
          data: {
            get_production_products_data: true,
          },
        },
        columns: [
          {
            title: "Product Name", //0
            data: "product_name",
          },
          {
            title: "Description", //1
            data: "description",
          },
          {
            title: "Product Category", // 2
            data: "product_category",
          },
          {
            title: "Code/ID", //3
            data: "code_id",
          },
          {
            title: "Action", //4
            width: "15%",
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
              return `<input type=button class="btn btn-sm btn-primary view_production_product" value="View">
                <input type=button class="btn btn-sm btn-danger delete_production_product" value="Delete">`;
            },
          },
        ],
      }
    );

    production_formulation_table = $(
      "#production_formulation .main_table"
    ).DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_production_formulation_data: true,
        },
      },
      columns: [
        {
          title: "Code/ID", //0
          data: "code_id",
        },
        {
          title: "Version No", //1
          data: "version_no",
        },
        {
          title: "Product Name", // 2
          data: "product_name",
        },
        {
          title: "Status", //3
          data: "status",
        },
        {
          title: "Status Date", //4
          data: "status_date",
        },
        {
          title: "Action", //5
          sortable: false,
        },
      ],
      columnDefs: [
        {
          target: 3,
          render: function (data, type, row) {
            return `<span class="label label-success">${data}</span>`;
          },
        },
        {
          targets: [3, 4, 5],
          className: "text-center",
        },
        {
          targets: 5,
          render: function (data, type, row) {
            return `<input type=button class="btn btn-sm btn-primary view_production_formulation" value="View">
                <input type=button class="btn btn-sm btn-success edit_production_formulation" value="Edit">
                <input type=button class="btn btn-sm btn-danger delete_production_formulation" value="Delete">`;
          },
          width: "35%",
        },
      ],
    });
  }

  $(document).on("click", ".view_production_in_progress", function () {
    $("#view_production_in_progress_modal").modal("show");
  });

  $(document).on("click", ".view_production_product", function () {
    $("#production_product_modal").modal("show");
  });

  $(document).on("click", ".delete_production_product", function () {
    var tr = $(this).closest("tr");
    var formdata = $("#production_products .main_table")
      .dataTable()
      .fnGetData(tr);

    confirm_action(
      `Delete ${formdata.product_name}`,
      `Are you sure you want to delete this product?`,
      function () {
        $.ajax({
          url: path,
          type: "post",
          dataType: "json",
          data: {
            delete_production_product: true,
            id: formdata.id,
          },
          success: function (response) {
            // reload_all_purchases()
            // growl(response.message, response.type)
          },
          error: function (response) {
            console.log(response.responseText);
          },
        });
      }
    );
  });

  $(document).on("click", ".view_production_formulation", function () {
    $("#view_production_formulation_modal").modal("show");
  });

  $(document).on("click", ".edit_production_formulation", function () {
    $("#view_production_formulation_modal").modal("show");
  });

  $(document).on("click", ".delete_production_formulation", function () {
    var tr = $(this).closest("tr");
    var formdata = $("#production_formulation .main_table")
      .dataTable()
      .fnGetData(tr);

    confirm_action(
      `Delete ${formdata.product_name}`,
      `Are you sure you want to delete this product?`,
      function () {
        $.ajax({
          url: path,
          type: "post",
          dataType: "json",
          data: {
            delete_production_product: true,
            id: formdata.id,
          },
          success: function (response) {
            // reload_all_purchases()
            // growl(response.message, response.type)
          },
          error: function (response) {
            console.log(response.responseText);
          },
        });
      }
    );
  });

  // -- SALES TAB --
  var sales_open, sales_done;

  function sales_init() {
    sales_open = $("#sales_open .main_table").DataTable({
      ajax: {
        url: path,
        type: "post",
        dataType: "json",
        data: {
          get_sales_open_data: true,
        },
      },
      columns: [
        {
          title: "Created Date", //0
          data: "created_date",
        },
        {
          title: "Sales Order#", //1
          data: "sales_order",
        },
        {
          title: "Customer Name", // 2
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
        },
        {
          title: "Order Status", //6
          data: "order_status",
        },
      ],
      columnDefs: [
        {
          targets: 5,
          render: function (data, type, row) {
            return `<span class="label label-success">${data}</span>`;
          },
        },
        {
          targets: 6,
          render: function (data, type, row) {
            return `<span class="label label-danger">${data}</span>`;
          },
        },
        {
          targets: [4, 5, 6],
          className: "text-center",
        },
      ],
    });
  }

  var suppliers, locations, location_elem;

  function add_comma(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  function display_amount(amount, currency) {
    return `${add_comma(amount)} ${currency}`;
  }

  function clean_data(data) {
    return data == null ? "" : data;
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

  function growl(title, type) {
    type = type == "error" ? "danger" : type;
    $.bootstrapGrowl(title, {
      type: type,
    });
  }

  function supply_data(
    modal_id,
    arr_string,
    exception_,
    data,
    check_for_disabled
  ) {
    var arr = arr_string.split(",");
    var exception = exception_.split(",");
    arr.forEach((el) => {
      var elem = $(`${modal_id} [name='${el}']`);
      elem.val(data[el]);
      if (check_for_disabled) {
        elem.attr("disabled", "disabled");
      } else {
        if (!exception.includes(el)) {
          elem.removeAttr("disabled");
        }
      }
    });
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

  function create_select_elem(data, label) {
    var div = `<option value=''>Select ${label}</option>`;
    data.forEach((item) => {
      div += `<option value='${item.id}'>${item.value}</option>`;
    });
    return div;
  }

  function display_name(name, position, date) {
    return `Name : <strong>${name}</strong><br>
            Position : <strong>${position}</strong><br>
            Date : <strong>${date}</strong>`;
  }

  function display_status(data) {
    var i;
    switch (data) {
      case "drafted":
        i = 0;
        break;
      case "for_approval":
        i = 1;
        break;
      case "for_delivery":
        i = 2;
        break;
      case "received":
        i = 3;
        break;
      case "cancelled":
        i = 4;
        break;
    }
    return `<span style="color:${colors_arr[i]}"><strong>${all_status[i]}</strong></span>`;
  }

  function display_comment_btn(total_comments, comment_type) {
    return `<input type=button data-type="${
      comment_type || "po"
    }" class="total_comment_btn btn btn-primary btn-sm" value=${total_comments}>`;
    // return `<input type=button class="total_comment_btn btn btn-primary btn-sm" value=${total_comments}>`
  }

  function view_po_btn() {
    return `<input type=button class="btn btn-sm btn-primary view_po" value="View">`;
  }

  function print_po_btn() {
    return `<input type=button class="btn btn-sm btn-warning print_po" value="Print">`;
  }

  function cancel_po_btn(id, po, counter) {
    return `<input type=button class="btn btn-sm btn-danger push_po" value="Cancel" data-id=${id} data-status='cancelled' data-prefix='cancelled_by' data-modal-title='Cancel PO : ${po}' data-signature-counter=${counter}>`;
  }

  function delete_po_btn() {
    return `<input type=button class="btn btn-sm btn-danger delete_po" value="Delete">`;
  }

  function sign_po_btn(id, status, prefix, title, counter) {
    return `<input type=button class="btn btn-sm btn-success push_po" value="Sign" data-id=${id} data-status='${status}' data-prefix='${prefix}' data-modal-title='${title}' data-signature-counter=${counter}>`;
  }

  function update_po_btn() {
    return `<input type=button class="btn btn-sm btn-primary update_po" value="Update">`;
  }
});
