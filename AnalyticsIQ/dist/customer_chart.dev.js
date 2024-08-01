"use strict";

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === "[object Arguments]")) { return; } var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

//Customer Requirements, Audit & Review for Modal Analytics
var currentRoot = null;
var complianceRoot = null;
var auditRoot = null;

function displayChart(data) {
  // Dispose of the existing chart instances if they exist
  [currentRoot, complianceRoot, auditRoot].forEach(function (root) {
    if (root) {
      root.dispose();
    }
  }); // Update the modal title with the vendor's name

  document.querySelector("#modalChart .modal-title").innerText = "Customer Name: " + data.vendor_name; // Create root element for requirement chart

  currentRoot = am5.Root["new"]("requirementChartDiv");
  currentRoot.setThemes([am5themes_Animated["new"](currentRoot)]);
  var chart = currentRoot.container.children.push(am5xy.XYChart["new"](currentRoot, {
    panX: false,
    panY: false,
    wheelX: "none",
    wheelY: "none",
    pinchZoomX: false
  }));
  var cursor = chart.set("cursor", am5xy.XYCursor["new"](currentRoot, {
    behavior: "none"
  }));
  cursor.lineY.set("visible", false);
  var xAxis = chart.xAxes.push(am5xy.CategoryAxis["new"](currentRoot, {
    categoryField: "category",
    renderer: am5xy.AxisRendererX["new"](currentRoot, {
      minGridDistance: 30
    })
  }));
  var yAxis = chart.yAxes.push(am5xy.ValueAxis["new"](currentRoot, {
    renderer: am5xy.AxisRendererY["new"](currentRoot, {})
  }));
  xAxis.get("renderer").labels.template.setAll({
    rotation: -30,
    centerY: am5.p50,
    centerX: am5.p100
  });
  var series = chart.series.push(am5xy.ColumnSeries["new"](currentRoot, {
    name: "Requirements",
    xAxis: xAxis,
    yAxis: yAxis,
    valueYField: "value",
    categoryXField: "category"
  }));
  var totalDocuments = data.document_count + data.document_other_count;
  var chartData = [{
    category: "Requirements",
    value: totalDocuments,
    color: am5.color(0x4da6ff)
  }, {
    category: "Non Expired",
    value: data.non_expired,
    color: am5.color(0x32CD32)
  }, {
    category: "Expired",
    value: data.expired,
    color: am5.color(0xFF0000)
  }, {
    category: "Nearly Expired 30 days",
    value: data.nearly_expired_30,
    color: am5.color(0xff3434)
  }, {
    category: "Nearly Expired 60 days",
    value: data.nearly_expired_60,
    color: am5.color(0xffb733)
  }, {
    category: "Nearly Expired 90 days",
    value: data.nearly_expired_90,
    color: am5.color(0xFFD700)
  }];
  series.data.setAll(chartData);
  xAxis.data.setAll(chartData);
  series.columns.template.setAll({
    tooltipText: "{category}: {valueY}",
    fill: function fill(target) {
      return target.dataItem.dataContext.color;
    },
    stroke: function stroke(target) {
      return target.dataItem.dataContext.color;
    },
    width: am5.percent(120),
    fillOpacity: 0.8,
    strokeOpacity: 0.8
  });
  series.columns.template.adapters.add("fill", function (fill, target) {
    return target.dataItem.dataContext.color;
  });
  series.columns.template.adapters.add("stroke", function (stroke, target) {
    return target.dataItem.dataContext.color;
  });
  series.columns.template.set("draw", function (display, target) {
    var w = target.getPrivate("width", 0);
    var h = target.getPrivate("height", 0);
    display.moveTo(0, h);
    display.bezierCurveTo(w / 4, h, w / 4, 0, w / 2, 0);
    display.bezierCurveTo(w - w / 4, 0, w - w / 4, h, w, h);
  });
  series.appear(1000);
  chart.appear(1000, 100);
  complianceRoot = am5.Root["new"]("complianceChartDiv");
  complianceRoot.setThemes([am5themes_Animated["new"](complianceRoot)]);
  var complianceChart = complianceRoot.container.children.push(am5percent.PieChart["new"](complianceRoot, {
    radius: am5.percent(65) // Adjust the size of the pie chart

  }));
  var complianceSeries = complianceChart.series.push(am5percent.PieSeries["new"](complianceRoot, {
    valueField: "value",
    categoryField: "category",
    colors: am5.ColorSet["new"](complianceRoot, {
      colors: [am5.color(0x32CD32), am5.color(0xFF0000)]
    })
  }));
  complianceSeries.data.setAll([{
    category: "Compliance",
    value: data.compliant_count
  }, {
    category: "Non-Compliance",
    value: data.non_compliant_count
  }]);
  complianceSeries.slices.template.setAll({
    tooltipText: "{category}: {value}"
  }); // Integrate original audit chart script if audit_data exists

  var auditData = [{
    reviewed_by: data.reviewed_by,
    annual_review_count: data.annual_review_count,
    total_audits: data.total_audits,
    audit_report_start: parseDate(data.audit_report_date.trim()),
    audit_report_duration: calculateDuration(data.audit_report_date, data.audit_report_end_date),
    audit_certificate_start: parseDate(data.audit_certificate_date.trim()),
    audit_certificate_duration: calculateDuration(data.audit_certificate_date, data.audit_certificate_end_date),
    audit_corrective_action_start: parseDate(data.audit_action_date.trim()),
    audit_corrective_action_duration: calculateDuration(data.audit_action_date, data.audit_action_end_date),
    reviewed_start: parseDate(data.reviewed_date.trim()),
    reviewed_duration: calculateDuration(data.reviewed_date, data.reviewed_due)
  }];

  if (auditData.length > 0) {
    am5.ready(function () {
      try {
        var makeSeries = function makeSeries(name, fieldName, color, isDuration, stacked, yAxis) {
          var series = auditChart.series.push(am5xy.ColumnSeries["new"](auditRoot, {
            name: name,
            xAxis: auditXAxis,
            yAxis: yAxis,
            valueYField: fieldName,
            categoryXField: "reviewed_by",
            stacked: stacked,
            fill: color
          }));
          series.columns.template.setAll({
            tooltipText: isDuration ? "{name}: {valueY} days" : "{name}: {valueY}",
            width: am5.percent(90),
            strokeOpacity: 0,
            fillOpacity: 10
          });

          if (isDuration) {
            series.columns.template.adapters.add("fill", function (fill, target) {
              var duration = target.dataItem.get("valueY");
              if (duration <= 30) return am5.color(0xFF0000);
              if (duration <= 60) return am5.color(0xFFA500);
              if (duration <= 90) return am5.color(0xFFD700);
              return am5.color(0x32CD32);
            });
          }

          series.data.setAll(auditData);
          series.appear();

          if (name !== "Audit Report Duration" && name !== "Audit Certificate Duration" && name !== "Audit Corrective Action Duration" && name !== "Reviewed Duration") {
            legend.data.push(series);
          } // Add label count on top of the bars


          series.bullets.push(function () {
            return am5.Bullet["new"](auditRoot, {
              locationY: 0.5,
              sprite: am5.Label["new"](auditRoot, {
                text: isDuration ? "Duration: {valueY} days \n" : "Start: {valueY} \n",
                fill: auditRoot.interfaceColors.get("alternativeText"),
                centerY: am5.p50,
                centerX: am5.p50,
                populateText: true,
                adapters: {
                  text: function text(_text, target) {
                    var value = target.dataItem.get("valueY");
                    return value != null ? _text : "";
                  }
                }
              })
            });
          });
          return series;
        }; // Create series for each date pair with start series first and then duration series


        auditRoot = am5.Root["new"]("auditChartdiv"); // Set themes

        auditRoot.setThemes([am5themes_Animated["new"](auditRoot)]); // Create chart

        var auditChart = auditRoot.container.children.push(am5xy.XYChart["new"](auditRoot, {
          panX: false,
          panY: false,
          wheelX: "none",
          wheelY: "none",
          layout: auditRoot.verticalLayout,
          marginTop: 20 // Adjust this value for more/less space

        })); // Add legend

        var legend = auditChart.children.push(am5.Legend["new"](auditRoot, {
          centerX: am5.p50,
          x: am5.p50,
          marginTop: 20
        })); // Create axes

        var auditXAxis = auditChart.xAxes.push(am5xy.CategoryAxis["new"](auditRoot, {
          categoryField: "reviewed_by",
          renderer: am5xy.AxisRendererX["new"](auditRoot, {
            cellStartLocation: 0.1,
            cellEndLocation: 0.9
          })
        }));
        auditXAxis.data.setAll(auditData);
        auditXAxis.get("renderer").labels.template.adapters.add("text", function (text, target) {
          return "Reviewed by: " + text;
        });
        auditXAxis.get("renderer").labels.template.setAll({
          fontSize: 16
        });
        var auditYAxis = auditChart.yAxes.push(am5xy.ValueAxis["new"](auditRoot, {
          renderer: am5xy.AxisRendererY["new"](auditRoot, {})
        }));
        var auditYAxis2 = auditChart.yAxes.push(am5xy.ValueAxis["new"](auditRoot, {
          renderer: am5xy.AxisRendererY["new"](auditRoot, {
            opposite: true
          })
        }));
        makeSeries("Audit Report Start", "audit_report_start", am5.color(0x7c6ed3), false, false, auditYAxis);
        makeSeries("Audit Report Duration", "audit_report_duration", am5.color(0xFFD700), true, true, auditYAxis);
        makeSeries("Audit Certificate Start", "audit_certificate_start", am5.color(0x0096FF), false, false, auditYAxis);
        makeSeries("Audit Certificate Duration", "audit_certificate_duration", am5.color(0x4A731C), true, true, auditYAxis);
        makeSeries("Audit Corrective Action Start", "audit_corrective_action_start", am5.color(0xd981cd), false, false, auditYAxis);
        makeSeries("Audit Corrective Action Duration", "audit_corrective_action_duration", am5.color(0x883407), true, true, auditYAxis);
        makeSeries("Reviewed Start", "reviewed_start", am5.color(0xFA8072), false, false, auditYAxis);
        makeSeries("Reviewed Duration", "reviewed_duration", am5.color(0x32CD32), true, true, auditYAxis);
        auditChart.appear(1000, 100);
      } catch (err) {
        console.log(err);
      }
    });
  }

  $('#modalChart').modal('show');
} // Helper function to parse date strings


function parseDate(dateString) {
  var _dateString$split$map = dateString.split('/').map(Number),
      _dateString$split$map2 = _slicedToArray(_dateString$split$map, 3),
      month = _dateString$split$map2[0],
      day = _dateString$split$map2[1],
      year = _dateString$split$map2[2];

  return new Date(year, month - 1, day);
} // Helper function to calculate duration between two dates


function calculateDuration(startDate, endDate) {
  var start = parseDate(startDate.trim());
  var end = parseDate(endDate.trim());
  var duration = (end - start) / (1000 * 60 * 60 * 24);
  return duration;
} // Event listener for when the modal is shown


$('#modalChart').on('shown.bs.modal', function (e) {
  var id = $(e.relatedTarget).data('id');
  fetch('AnalyticsIQ/fetch_customer_data.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'id=' + id
  }).then(function (response) {
    if (!response.ok) {
      throw new Error('Network response was not ok ' + response.statusText);
    }

    return response.json();
  }).then(function (data) {
    console.log(data); // Log data for debugging

    displayChart(data);
  })["catch"](function (error) {
    console.error('Error fetching or processing data:', error);
    alert('An error occurred while fetching the data. Please try again later.');
  });
}); //Send Tab

am5.ready(function () {
  // First Waterfall Chart
  var root1 = am5.Root["new"]("waterfallChart1");
  root1.setThemes([am5themes_Animated["new"](root1)]);
  var chart1 = root1.container.children.push(am5xy.XYChart["new"](root1, {
    panX: false,
    panY: false,
    paddingLeft: 0
  }));
  var xRenderer1 = am5xy.AxisRendererX["new"](root1, {
    minGridDistance: 30,
    minorGridEnabled: true
  });
  var xAxis1 = chart1.xAxes.push(am5xy.CategoryAxis["new"](root1, {
    maxDeviation: 0,
    categoryField: "category",
    renderer: xRenderer1,
    tooltip: am5.Tooltip["new"](root1, {})
  }));
  xRenderer1.grid.template.setAll({
    location: 1
  });
  var yAxis1 = chart1.yAxes.push(am5xy.ValueAxis["new"](root1, {
    maxDeviation: 0,
    min: 0,
    renderer: am5xy.AxisRendererY["new"](root1, {
      strokeOpacity: 0.1
    }),
    tooltip: am5.Tooltip["new"](root1, {})
  }));
  var cursor1 = chart1.set("cursor", am5xy.XYCursor["new"](root1, {
    xAxis: xAxis1,
    yAxis: yAxis1
  }));
  var series1 = chart1.series.push(am5xy.ColumnSeries["new"](root1, {
    xAxis: xAxis1,
    yAxis: yAxis1,
    valueYField: "value",
    openValueYField: "open",
    categoryXField: "category"
  }));
  series1.columns.template.setAll({
    templateField: "columnConfig",
    strokeOpacity: 0
  });
  series1.bullets.push(function () {
    return am5.Bullet["new"](root1, {
      sprite: am5.Label["new"](root1, {
        text: "{displayValue}",
        centerY: am5.p50,
        centerX: am5.p50,
        populateText: true
      })
    });
  });
  var stepSeries1 = chart1.series.push(am5xy.StepLineSeries["new"](root1, {
    xAxis: xAxis1,
    yAxis: yAxis1,
    valueYField: "stepValue",
    categoryXField: "category",
    noRisers: true,
    locationX: 0.65,
    stroke: root1.interfaceColors.get("alternativeBackground")
  }));
  stepSeries1.strokes.template.setAll({
    strokeDasharray: [3, 3]
  });
  var colorSet1 = am5.ColorSet["new"](root1, {});
  fetch('AnalyticsIQ/customer_send_data.php').then(function (response) {
    return response.json();
  }).then(function (data) {
    var data1 = [{
      category: "Total Send",
      value: parseInt(data.donutData.total_send),
      open: 0,
      stepValue: parseInt(data.donutData.total_send),
      columnConfig: {
        fill: am5.color(0x4da6ff)
      },
      displayValue: parseInt(data.donutData.total_send)
    }, {
      category: "Pending",
      value: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending),
      open: parseInt(data.donutData.total_send),
      stepValue: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending),
      columnConfig: {
        fill: am5.color(0xf4b943)
      },
      displayValue: parseInt(data.donutData.pending)
    }, {
      category: "Approved",
      value: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved),
      open: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending),
      stepValue: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved),
      columnConfig: {
        fill: am5.color(0x32CD32)
      },
      displayValue: parseInt(data.donutData.approved)
    }, {
      category: "Non Approved",
      value: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved),
      open: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved),
      stepValue: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved),
      columnConfig: {
        fill: am5.color(0xff0000)
      },
      displayValue: parseInt(data.donutData.non_approved)
    }, {
      category: "Emergency Use Only",
      value: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved) + parseInt(data.donutData.emergency_use_only),
      open: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved),
      stepValue: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved) + parseInt(data.donutData.emergency_use_only),
      columnConfig: {
        fill: am5.color(0xff8080)
      },
      displayValue: parseInt(data.donutData.emergency_use_only)
    }, {
      category: "Do Not Use",
      value: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved) + parseInt(data.donutData.emergency_use_only),
      open: 0,
      columnConfig: {
        fill: am5.color(0xffff00)
      },
      displayValue: parseInt(data.donutData.do_not_use)
    }];
    xAxis1.data.setAll(data1);
    series1.data.setAll(data1);
    stepSeries1.data.setAll(data1);
  })["catch"](function (error) {
    return console.error('Error fetching data:', error);
  });
}); //RECEIVED Tab

am5.ready(function () {
  var root = am5.Root["new"]("receivedchartdiv");
  root.setThemes([am5themes_Animated["new"](root)]);
  var chart = root.container.children.push(am5xy.XYChart["new"](root, {
    panX: false,
    // Disable horizontal panning
    panY: false,
    // Disable vertical panning
    wheelX: "none",
    // Disable wheel zooming on X axis
    wheelY: "none",
    // Disable wheel zooming on Y axis
    pinchZoomY: false // Disable pinch zoom on Y axis

  }));
  var cursor = chart.set("cursor", am5xy.XYCursor["new"](root, {}));
  cursor.lineX.set("visible", false); // Hide vertical cursor line

  var yRenderer = am5xy.AxisRendererY["new"](root, {
    minGridDistance: 30
  });
  var yAxis = chart.yAxes.push(am5xy.CategoryAxis["new"](root, {
    maxDeviation: 0.3,
    categoryField: "name",
    renderer: yRenderer
  }));
  var xAxis = chart.xAxes.push(am5xy.ValueAxis["new"](root, {
    renderer: am5xy.AxisRendererX["new"](root, {})
  })); // Fetch data from PHP script using fetch API

  fetch('AnalyticsIQ/customer_received_data.php').then(function (response) {
    return response.json();
  }).then(function (data) {
    // console.log('Data received:', data); // Log the received data
    if (data.length === 0) {
      console.error('No data received');
      return;
    } // Aggregate data counts


    var aggregatedData = [{
      name: "Compliance",
      value: data.reduce(function (sum, item) {
        return sum + parseFloat(item.compliance_percentage);
      }, 0),
      color: am5.color(0x00FF00)
    }, // Green
    {
      name: "Non Compliance",
      value: data.reduce(function (sum, item) {
        return sum + parseInt(item.d_non_compliance);
      }, 0),
      color: am5.color(0xFF0000)
    }, // Red
    {
      name: "Pending",
      value: data.reduce(function (sum, item) {
        return sum + parseInt(item.pending_count);
      }, 0),
      color: am5.color(0xFFA500)
    }, // Orange
    {
      name: "Approved",
      value: data.reduce(function (sum, item) {
        return sum + parseInt(item.approved_count);
      }, 0),
      color: am5.color(0x32CD32)
    }, // Lime Green
    {
      name: "Non Approved",
      value: data.reduce(function (sum, item) {
        return sum + parseInt(item.non_approved_count);
      }, 0),
      color: am5.color(0xFF6347)
    }, // Light Red
    {
      name: "Emergency Use Only",
      value: data.reduce(function (sum, item) {
        return sum + parseInt(item.emergency_use_only_count);
      }, 0),
      color: am5.color(0xFFC0CB)
    }, // Pink
    {
      name: "Do Not Use",
      value: data.reduce(function (sum, item) {
        return sum + parseInt(item.do_not_use_count);
      }, 0),
      color: am5.color(0xFFFF00)
    }, // Yellow
    {
      name: "Total Received",
      value: data.reduce(function (sum, item) {
        return sum + parseInt(item.received_count);
      }, 0),
      color: am5.color(0x4da6ff)
    } // Blue
    ];
    var series = chart.series.push(am5xy.ColumnSeries["new"](root, {
      xAxis: xAxis,
      yAxis: yAxis,
      valueXField: "value",
      // Change to valueXField for horizontal bar chart
      categoryYField: "name",
      // Change to categoryYField for horizontal bar chart
      tooltip: am5.Tooltip["new"](root, {
        labelText: "{name}: {valueX}" // Change to valueX for horizontal bar chart

      })
    }));
    series.columns.template.setAll({
      cornerRadiusTL: 5,
      cornerRadiusBL: 5
    }); // Adjust corner radius for horizontal bars

    series.columns.template.adapters.add("fill", function (fill, target) {
      return target.dataItem.dataContext.color;
    });
    series.columns.template.adapters.add("stroke", function (stroke, target) {
      return target.dataItem.dataContext.color;
    });
    series.data.setAll(aggregatedData);
    yAxis.data.setAll(aggregatedData); // Set data for yAxis instead of xAxis for horizontal bar chart
  })["catch"](function (error) {
    console.error('Error fetching data:', error);
  });
});
//# sourceMappingURL=customer_chart.dev.js.map
