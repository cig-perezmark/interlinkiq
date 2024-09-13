//Supplier Requirements, Materials, Audit & Review for Modal Analytics

let currentRoot = null;
let complianceRoot = null;
let materialsRoot = null;
let auditRoot = null;

function displayChart(data) {
    // Dispose of the existing chart instances if they exist
    [currentRoot, complianceRoot, materialsRoot, auditRoot].forEach(root => {
        if (root) {
            root.dispose();
        }
    });

    // Update the modal title with the vendor's name
    document.querySelector("#modalChart .modal-title").innerText = "Vendor's Name: " + data.vendor_name;

    // Create root element for requirement chart
    currentRoot = am5.Root.new("requirementChartDiv");
    currentRoot.setThemes([am5themes_Animated.new(currentRoot)]);

    var chart = currentRoot.container.children.push(am5xy.XYChart.new(currentRoot, {
        panX: false,
        panY: false,
        wheelX: "none",
        wheelY: "none",
        pinchZoomX: false
    }));

    var cursor = chart.set("cursor", am5xy.XYCursor.new(currentRoot, {
        behavior: "none"
    }));
    cursor.lineY.set("visible", false);

    var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(currentRoot, {
        categoryField: "category",
        renderer: am5xy.AxisRendererX.new(currentRoot, { minGridDistance: 30 })
    }));

    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(currentRoot, {
        renderer: am5xy.AxisRendererY.new(currentRoot, {})
    }));

    xAxis.get("renderer").labels.template.setAll({
        rotation: -30,
        centerY: am5.p50,
        centerX: am5.p100
    });

    var series = chart.series.push(am5xy.ColumnSeries.new(currentRoot, {
        name: "Requirements",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        categoryXField: "category"
    }));

    const totalDocuments = data.document_count + data.document_other_count;
    const chartData = [
        { category: "Requirements", value: totalDocuments, color: am5.color(0x4da6ff) },
        { category: "Non Expired", value: data.non_expired, color: am5.color(0x32CD32) },
        { category: "Expired", value: data.expired, color: am5.color(0xFF0000) },
        { category: "Nearly Expired 30 days", value: data.nearly_expired_30, color: am5.color(0xff3434) },
        { category: "Nearly Expired 60 days", value: data.nearly_expired_60, color: am5.color(0xffb733) },
        { category: "Nearly Expired 90 days", value: data.nearly_expired_90, color: am5.color(0xFFD700) }
    ];
    series.data.setAll(chartData);
    xAxis.data.setAll(chartData);

    series.columns.template.setAll({
        tooltipText: "{category}: {valueY}",
        fill: function(target) {
            return target.dataItem.dataContext.color;
        },
        stroke: function(target) {
            return target.dataItem.dataContext.color;
        },
        width: am5.percent(120),
        fillOpacity: 0.8,
        strokeOpacity: 0.8
    });

    series.columns.template.adapters.add("fill", (fill, target) => {
        return target.dataItem.dataContext.color;
    });
    series.columns.template.adapters.add("stroke", (stroke, target) => {
        return target.dataItem.dataContext.color;
    });

    series.columns.template.set("draw", function(display, target) {
        var w = target.getPrivate("width", 0);
        var h = target.getPrivate("height", 0);
        display.moveTo(0, h);
        display.bezierCurveTo(w / 4, h, w / 4, 0, w / 2, 0);
        display.bezierCurveTo(w - w / 4, 0, w - w / 4, h, w, h);
    });

    series.appear(1000);
    chart.appear(1000, 100);

    complianceRoot = am5.Root.new("complianceChartDiv");
    complianceRoot.setThemes([am5themes_Animated.new(complianceRoot)]);
    var complianceChart = complianceRoot.container.children.push(am5percent.PieChart.new(complianceRoot, {
        radius: am5.percent(65)  // Adjust the size of the pie chart
    }));
    var complianceSeries = complianceChart.series.push(am5percent.PieSeries.new(complianceRoot, {
        valueField: "value",
        categoryField: "category",
        colors: am5.ColorSet.new(complianceRoot, {
            colors: [am5.color(0x32CD32), am5.color(0xFF0000)]
        })
    }));
    complianceSeries.data.setAll([
        { category: "Compliance", value: data.compliant_count },
        { category: "Non-Compliance", value: data.non_compliant_count }
    ]);
    complianceSeries.slices.template.setAll({
        tooltipText: "{category}: {value}"
    });

    materialsRoot = am5.Root.new("materialsChartDiv");
    materialsRoot.setThemes([am5themes_Animated.new(materialsRoot)]);
    var materialsChart = materialsRoot.container.children.push(am5percent.PieChart.new(materialsRoot, {
        radius: am5.percent(65),  // Adjust the size of the donut chart
        innerRadius: am5.percent(50)
    }));
    var materialsSeries = materialsChart.series.push(am5percent.PieSeries.new(materialsRoot, {
        valueField: "value",
        categoryField: "category",
        colors: am5.ColorSet.new(materialsRoot, {
            colors: [am5.color(0x32CD32), am5.color(0xFF0000)]
        })
    }));
    materialsSeries.data.setAll([
        { category: "Active Material", value: data.active_material_count },
        { category: "Inactive Material", value: data.inactive_material_count }
    ]);
    materialsSeries.slices.template.setAll({
        tooltipText: "{category}: {value}"
    });
    materialsSeries.labels.template.set("text", "[regular]{category}[/]\n{value}");

    var totalLabel = materialsChart.seriesContainer.children.push(am5.Label.new(materialsRoot, {
        text: `Materials\n${data.material_count}`,
        fontSize: 18,  // Adjust the size of the total label
        centerX: am5.p50,
        centerY: am5.p50,
        populateText: true,
        textAlign: "center",
        fontWeight: "bold",  // Make the font bold
        fill: am5.color(0x0000FF)  // Set the font color to blue
    }));

    // Integrate original audit chart script if audit_data exists
    const auditData = [{
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
        am5.ready(function() {
            try {
                auditRoot = am5.Root.new("auditChartdiv");

                // Set themes
                auditRoot.setThemes([am5themes_Animated.new(auditRoot)]);

                // Create chart
                var auditChart = auditRoot.container.children.push(am5xy.XYChart.new(auditRoot, {
                    panX: false,
                    panY: false,
                    wheelX: "none",
                    wheelY: "none",
                    layout: auditRoot.verticalLayout,
                    marginTop: 20 
                }));

                // Add legend
                var legend = auditChart.children.push(
                    am5.Legend.new(auditRoot, {
                        centerX: am5.p50,
                        x: am5.p50,
                        marginTop: 20
                    })
                );

                // Create axes
                var auditXAxis = auditChart.xAxes.push(am5xy.CategoryAxis.new(auditRoot, {
                    categoryField: "reviewed_by",
                    renderer: am5xy.AxisRendererX.new(auditRoot, {
                        cellStartLocation: 0.1,
                        cellEndLocation: 0.9
                    })
                }));
                auditXAxis.data.setAll(auditData);
                auditXAxis.get("renderer").labels.template.adapters.add("text", function(text, target) {
                    return "Reviewed by: " + text;
                });
                auditXAxis.get("renderer").labels.template.setAll({
                    fontSize: 16 
                });

                var auditYAxis = auditChart.yAxes.push(am5xy.ValueAxis.new(auditRoot, {
                    renderer: am5xy.AxisRendererY.new(auditRoot, {})
                }));

                var auditYAxis2 = auditChart.yAxes.push(am5xy.ValueAxis.new(auditRoot, {
                    renderer: am5xy.AxisRendererY.new(auditRoot, { opposite: true })
                }));

                function makeSeries(name, fieldName, color, isDuration, stacked, yAxis) {
                    var series = auditChart.series.push(am5xy.ColumnSeries.new(auditRoot, {
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
                        fillOpacity: 10,
                    });

                    if (isDuration) {
                        series.columns.template.adapters.add("fill", (fill, target) => {
                            const duration = target.dataItem.get("valueY");
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
                    }

                    // Add label count on top of the bars
                    series.bullets.push(function() {
                        return am5.Bullet.new(auditRoot, {
                            locationY: 0.5,
                            sprite: am5.Label.new(auditRoot, {
                                text: isDuration ? "Duration: {valueY} days \n" : "Start: {valueY} \n",
                                fill: auditRoot.interfaceColors.get("alternativeText"),
                                centerY: am5.p50,
                                centerX: am5.p50,
                                populateText: true,
                                adapters: {
                                    text: function(text, target) {
                                        var value = target.dataItem.get("valueY");
                                        return value != null ? text : "";
                                    }
                                }
                            })
                        });
                    });

                    return series;
                }

                // Create series for each date pair with start series first and then duration series
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
}

// Helper function to parse date strings
function parseDate(dateString) {
    const [month, day, year] = dateString.split('/').map(Number);
    return new Date(year, month - 1, day);
}

// Helper function to calculate duration between two dates
function calculateDuration(startDate, endDate) {
    const start = parseDate(startDate.trim());
    const end = parseDate(endDate.trim());
    const duration = (end - start) / (1000 * 60 * 60 * 24);
    return duration;
}

// Event listener for when the modal is shown
$('#modalChart').on('shown.bs.modal', function (e) {
    var id = $(e.relatedTarget).data('id');
    fetch('AnalyticsIQ/fetch_supplier_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'id=' + id
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        // console.log(data);  // Log data for debugging
        displayChart(data);
    })
    .catch(error => {
        console.error('Error fetching or processing data:', error);
        alert('An error occurred while fetching the data. Please try again later.');
    });
});

//Send Tab
am5.ready(function() {
  // First Waterfall Chart
  var root1 = am5.Root.new("waterfallChart1");

  root1.setThemes([
    am5themes_Animated.new(root1)
  ]);

  var chart1 = root1.container.children.push(am5xy.XYChart.new(root1, {
    panX: false,
    panY: false,
    paddingLeft: 0
  }));

  var xRenderer1 = am5xy.AxisRendererX.new(root1, {
    minGridDistance: 30,
    minorGridEnabled: true
  });

  var xAxis1 = chart1.xAxes.push(am5xy.CategoryAxis.new(root1, {
    maxDeviation: 0,
    categoryField: "category",
    renderer: xRenderer1,
    tooltip: am5.Tooltip.new(root1, {})
  }));

  xRenderer1.labels.template.setAll({
    rotation: -45,
    centerY: am5.p50,
    centerX: am5.p100
  });

  xRenderer1.grid.template.setAll({
    location: 1
  });

  var yAxis1 = chart1.yAxes.push(am5xy.ValueAxis.new(root1, {
    maxDeviation: 0,
    min: 0,
    renderer: am5xy.AxisRendererY.new(root1, { strokeOpacity: 0.1 }),
    tooltip: am5.Tooltip.new(root1, {})
  }));

  var cursor1 = chart1.set("cursor", am5xy.XYCursor.new(root1, {
    xAxis: xAxis1,
    yAxis: yAxis1
  }));

  var series1 = chart1.series.push(am5xy.ColumnSeries.new(root1, {
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

  series1.bullets.push(function() {
    return am5.Bullet.new(root1, {
      sprite: am5.Label.new(root1, {
        text: "{displayValue}",
        centerY: am5.p50,
        centerX: am5.p50,
        populateText: true
      })
    });
  });

  var stepSeries1 = chart1.series.push(am5xy.StepLineSeries.new(root1, {
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

  var colorSet1 = am5.ColorSet.new(root1, {});

  fetch('AnalyticsIQ/supplier_send_data.php')
    .then(response => response.json())
    .then(data => {
      var data1 = [
        { category: "Total Send", value: parseInt(data.donutData.total_send), open: 0, stepValue: parseInt(data.donutData.total_send), columnConfig: { fill: am5.color(0x4da6ff) }, displayValue: parseInt(data.donutData.total_send) },
        { category: "Pending", value: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending), open: parseInt(data.donutData.total_send), stepValue: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending), columnConfig: { fill: am5.color(0xf4b943) }, displayValue: parseInt(data.donutData.pending) },
        { category: "Approved", value: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved), open: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending), stepValue: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved), columnConfig: { fill: am5.color(0x32CD32) }, displayValue: parseInt(data.donutData.approved) },
        { category: "Non Approved", value: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved), open: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved), stepValue: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved), columnConfig: { fill: am5.color(0xff0000) }, displayValue: parseInt(data.donutData.non_approved) },
        { category: "Emergency Use Only", value: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved) + parseInt(data.donutData.emergency_use_only), open: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved), stepValue: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved) + parseInt(data.donutData.emergency_use_only), columnConfig: { fill: am5.color(0xff8080) }, displayValue: parseInt(data.donutData.emergency_use_only) },
        { category: "Do Not Use", value: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved) + parseInt(data.donutData.emergency_use_only), open: 0, columnConfig: { fill: am5.color(0xffff00) }, displayValue: parseInt(data.donutData.do_not_use) }
      ];

      xAxis1.data.setAll(data1);
      series1.data.setAll(data1);
      stepSeries1.data.setAll(data1);
    })
    .catch(error => console.error('Error fetching data:', error));
});

//Receive Tab
am5.ready(function() {
  var root = am5.Root.new("receivedchartdiv");

  root.setThemes([ am5themes_Animated.new(root) ]);

  var chart = root.container.children.push(
      am5xy.XYChart.new(root, {
          panX: false, // Disable horizontal panning
          panY: false, // Disable vertical panning
          wheelX: "none", // Disable wheel zooming on X axis
          wheelY: "none", // Disable wheel zooming on Y axis
          pinchZoomY: false // Disable pinch zoom on Y axis
      })
  );

  var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
  cursor.lineX.set("visible", false); // Hide vertical cursor line

  var yRenderer = am5xy.AxisRendererY.new(root, { minGridDistance: 30 });
  var yAxis = chart.yAxes.push(
      am5xy.CategoryAxis.new(root, {
          maxDeviation: 0.3,
          categoryField: "name",
          renderer: yRenderer
      })
  );

  var xAxis = chart.xAxes.push(
      am5xy.ValueAxis.new(root, {
          renderer: am5xy.AxisRendererX.new(root, {})
      })
  );

  // Fetch data from PHP script using fetch API
  fetch('AnalyticsIQ/supplier_received_data.php')
      .then(function(response) {
          return response.json();
      })
      .then(function(data) {
          // console.log('Data received:', data); // Log the received data

          if (data.length === 0) {
              console.error('No data received');
              return;
          }

          // Aggregate data counts
          var aggregatedData = [
              { name: "Compliance", value: data.reduce((sum, item) => sum + parseFloat(item.compliance_percentage), 0), color: am5.color(0x00FF00) }, // Green
              { name: "Non Compliance", value: data.reduce((sum, item) => sum + parseInt(item.d_non_compliance), 0), color: am5.color(0xFF0000) }, // Red
              { name: "Pending", value: data.reduce((sum, item) => sum + parseInt(item.pending_count), 0), color: am5.color(0xFFA500) }, // Orange
              { name: "Approved", value: data.reduce((sum, item) => sum + parseInt(item.approved_count), 0), color: am5.color(0x32CD32) }, // Lime Green
              { name: "Non Approved", value: data.reduce((sum, item) => sum + parseInt(item.non_approved_count), 0), color: am5.color(0xFF6347) }, // Light Red
              { name: "Emergency Use Only", value: data.reduce((sum, item) => sum + parseInt(item.emergency_use_only_count), 0), color: am5.color(0xFFC0CB) }, // Pink
              { name: "Do Not Use", value: data.reduce((sum, item) => sum + parseInt(item.do_not_use_count), 0), color: am5.color(0xFFFF00) }, // Yellow
              { name: "Total Received", value: data.reduce((sum, item) => sum + parseInt(item.received_count), 0), color: am5.color(0x4da6ff) } // Blue
          ];

          var series = chart.series.push(
              am5xy.ColumnSeries.new(root, {
                  xAxis: xAxis,
                  yAxis: yAxis,
                  valueXField: "value", // Change to valueXField for horizontal bar chart
                  categoryYField: "name", // Change to categoryYField for horizontal bar chart
                  tooltip: am5.Tooltip.new(root, {
                      labelText: "{name}: {valueX}" // Change to valueX for horizontal bar chart
                  })
              })
          );

          series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusBL: 5 }); // Adjust corner radius for horizontal bars
          series.columns.template.adapters.add("fill", function(fill, target) {
              return target.dataItem.dataContext.color;
          });

          series.columns.template.adapters.add("stroke", function(stroke, target) {
              return target.dataItem.dataContext.color;
          });

          series.data.setAll(aggregatedData);
          yAxis.data.setAll(aggregatedData); // Set data for yAxis instead of xAxis for horizontal bar chart

          // Add labels at the end of each bar
          series.bullets.push(function() {
              return am5.Bullet.new(root, {
                  locationX: 1,
                  sprite: am5.Label.new(root, {
                      text: "{valueX}",
                      fill: am5.color(0x000000), // Color of the label text
                      centerX: am5.p0, // Align label to the right of the bar
                      centerY: am5.p50,
                      populateText: true,
                      dx: 10 // Adjust distance from the end of the bar
                  })
              });
          });

      })
      .catch(function(error) {
          console.error('Error fetching data:', error);
      });
});

//Requiremnets Tab
am5.ready(function() {
    function createChart(rootElementId, chartData, maxVal) {
      var root = am5.Root.new(rootElementId);
  
      root.setThemes([
        am5themes_Animated.new(root)
      ]);
  
      var chart = root.container.children.push(am5radar.RadarChart.new(root, {
        panX: false,
        panY: false,
        wheelX: "panX",
        wheelY: "zoomX",
        innerRadius: am5.percent(20),
        startAngle: -90,
        endAngle: 180
      }));
  
      var cursor = chart.set("cursor", am5radar.RadarCursor.new(root, {
        behavior: "zoomX"
      }));
  
      cursor.lineY.set("visible", false);
  
      var xRenderer = am5radar.AxisRendererCircular.new(root, {});
      xRenderer.labels.template.setAll({
        radius: 10
      });
      xRenderer.grid.template.setAll({
        forceHidden: true
      });
      var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
        renderer: xRenderer,
        min: 0,
        max: maxVal,
        strictMinMax: true,
        numberFormat: "#'%'",
        tooltip: am5.Tooltip.new(root, {})
      }));
  
      var yRenderer = am5radar.AxisRendererRadial.new(root, {
        minGridDistance: 20
      });
      yRenderer.labels.template.setAll({
        centerX: am5.p100,
        fontWeight: "500",
        fontSize: 18,
        templateField: "columnSettings"
      });
      yRenderer.grid.template.setAll({
        forceHidden: true
      });
      var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
        categoryField: "category",
        renderer: yRenderer
      }));
      yAxis.data.setAll(chartData);
  
      var series1 = chart.series.push(am5radar.RadarColumnSeries.new(root, {
        xAxis: xAxis,
        yAxis: yAxis,
        clustered: false,
        valueXField: "full",
        categoryYField: "category",
        fill: root.interfaceColors.get("alternativeBackground")
      }));
      series1.columns.template.setAll({
        width: am5.p100,
        fillOpacity: 0.08,
        strokeOpacity: 0,
        cornerRadius: 20
      });
      series1.data.setAll(chartData);
  
      var series2 = chart.series.push(am5radar.RadarColumnSeries.new(root, {
        xAxis: xAxis,
        yAxis: yAxis,
        clustered: false,
        valueXField: "value",
        categoryYField: "category"
      }));
      series2.columns.template.setAll({
        width: am5.p100,
        strokeOpacity: 0,
        tooltipText: "{category}: {valueX}%",
        cornerRadius: 20,
        templateField: "columnSettings"
      });
      series2.data.setAll(chartData);
  
      series1.appear(1000);
      series2.appear(1000);
      chart.appear(1000, 100);
    }
  
    fetch('AnalyticsIQ/supplier_requirements_data.php')
      .then(response => response.json())
      .then(data => {
        var totalRequirements = data.total_requirements;
        var complianceValue = data.compliance_count;
        var nonComplianceValue = data.non_compliance_count;
        var requirementData = [{
          category: totalRequirements + " Total Requirements",
          value: totalRequirements,
          full: totalRequirements,
          columnSettings: {
            fill: am5.color(0x4da6ff)
          }
        }, {
          category: complianceValue + " Compliance",
          value: totalRequirements === 0 ? 100 : (complianceValue / totalRequirements) * 100,
          full: 100,
          columnSettings: {
            fill: am5.color(0x32CD32)
          }
        }, {
          category: nonComplianceValue + " Non-Compliance",
          value: totalRequirements === 0 ? 100 : (nonComplianceValue / totalRequirements) * 100,
          full: 100,
          columnSettings: {
            fill: am5.color(0xff0000)
          }
        }];
  
        createChart("requirementchartdiv", requirementData, 100);
      })
      .catch(error => console.error('Error fetching data:', error));
  }); 
  
//Materials Tab
am5.ready(function() {
    function createChart(rootElementId, chartData, maxVal) {
      var root = am5.Root.new(rootElementId);
  
      root.setThemes([
        am5themes_Animated.new(root)
      ]);
  
      var chart = root.container.children.push(am5radar.RadarChart.new(root, {
        panX: false,
        panY: false,
        wheelX: "panX",
        wheelY: "zoomX",
        innerRadius: am5.percent(20),
        startAngle: -90,
        endAngle: 180
      }));
  
      var cursor = chart.set("cursor", am5radar.RadarCursor.new(root, {
        behavior: "zoomX"
      }));
  
      cursor.lineY.set("visible", false);
  
      var xRenderer = am5radar.AxisRendererCircular.new(root, {});
      xRenderer.labels.template.setAll({
        radius: 10
      });
      xRenderer.grid.template.setAll({
        forceHidden: true
      });
      var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
        renderer: xRenderer,
        min: 0,
        max: maxVal,
        strictMinMax: true,
        numberFormat: "#'%'",
        tooltip: am5.Tooltip.new(root, {})
      }));
  
      var yRenderer = am5radar.AxisRendererRadial.new(root, {
        minGridDistance: 20
      });
      yRenderer.labels.template.setAll({
        centerX: am5.p100,
        fontWeight: "500",
        fontSize: 18,
        templateField: "columnSettings"
      });
      yRenderer.grid.template.setAll({
        forceHidden: true
      });
      var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
        categoryField: "category",
        renderer: yRenderer
      }));
      yAxis.data.setAll(chartData);
  
      var series1 = chart.series.push(am5radar.RadarColumnSeries.new(root, {
        xAxis: xAxis,
        yAxis: yAxis,
        clustered: false,
        valueXField: "full",
        categoryYField: "category",
        fill: root.interfaceColors.get("alternativeBackground")
      }));
      series1.columns.template.setAll({
        width: am5.p100,
        fillOpacity: 0.08,
        strokeOpacity: 0,
        cornerRadius: 20
      });
      series1.data.setAll(chartData);
  
      var series2 = chart.series.push(am5radar.RadarColumnSeries.new(root, {
        xAxis: xAxis,
        yAxis: yAxis,
        clustered: false,
        valueXField: "value",
        categoryYField: "category"
      }));
      series2.columns.template.setAll({
        width: am5.p100,
        strokeOpacity: 0,
        tooltipText: "{category}: {valueX}%",
        cornerRadius: 20,
        templateField: "columnSettings"
      });
      series2.data.setAll(chartData);
  
      series1.appear(1000);
      series2.appear(1000);
      chart.appear(1000, 100);
    }
  
    fetch('AnalyticsIQ/supplier_materials_data.php')
      .then(response => response.json())
      .then(data => {
        var totalMaterials = data.total_materials;
        var activeMaterialsValue = data.total_active_materials;
        var inactiveMaterialsValue = data.total_inactive_materials;
        var materialData = [{
          category: totalMaterials + " Total Materials",
          value: totalMaterials,
          full: totalMaterials,
          columnSettings: {
            fill: am5.color(0x4da6ff)
          }
        }, {
          category: activeMaterialsValue + " Active Materials",
          value: totalMaterials === 0 ? 100 : (activeMaterialsValue / totalMaterials) * 100,
          full: 100,
          columnSettings: {
            fill: am5.color(0x32CD32)
          }
        }, {
          category: inactiveMaterialsValue + " Inactive Materials",
          value: totalMaterials === 0 ? 100 : (inactiveMaterialsValue / totalMaterials) * 100,
          full: 100,
          columnSettings: {
            fill: am5.color(0xff0000)
          }
        }];
  
        createChart("materialchartdiv", materialData, 100);
      })
      .catch(error => console.error('Error fetching data:', error));
});

//Frequency 
am5.ready(function() {
  // Second Donut Chart
  var root2 = am5.Root.new("donutChart2");
  root2.setThemes([
    am5themes_Animated.new(root2)
  ]);

  var chart2 = root2.container.children.push(
    am5percent.PieChart.new(root2, {
      layout: root2.verticalLayout,
      innerRadius: am5.percent(50)
    })
  );

  var series2 = chart2.series.push(
    am5percent.PieSeries.new(root2, {
      valueField: "value",
      categoryField: "category"
    })
  );

  fetch('AnalyticsIQ/supplier_send_data.php')
    .then(response => response.json())
    .then(data => {
      series2.data.setAll([
        { category: "Once Per Day", value: parseInt(data.lineData.once_per_day), color: am5.color(0xc0ff80) },
        { category: "Once Per Week", value: parseInt(data.lineData.once_per_week), color: am5.color(0x90EE90) },
        { category: "1st and 15th", value: parseInt(data.lineData.first_and_fifteenth) },
        { category: "Once Per Month", value: parseInt(data.lineData.once_per_month) },
        { category: "Once Per Year", value: parseInt(data.lineData.once_per_year) }
      ]);

      series2.labels.template.set("text", "{category}: {value}");
    })
    .catch(error => console.error('Error fetching data:', error));
});

// end am5.ready()