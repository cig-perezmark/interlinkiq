// am5.ready(function() {
//   // First Waterfall Chart
//   var root1 = am5.Root.new("waterfallChart1");
//   root1.setThemes([
//     am5themes_Animated.new(root1)
//   ]);
//   var chart1 = root1.container.children.push(am5xy.XYChart.new(root1, {
//     panX: false,
//     panY: false,
//     paddingLeft: 0
//   }));
//   var xRenderer1 = am5xy.AxisRendererX.new(root1, {
//     minGridDistance: 30,
//     minorGridEnabled: true
//   });
//   var xAxis1 = chart1.xAxes.push(am5xy.CategoryAxis.new(root1, {
//     maxDeviation: 0,
//     categoryField: "category",
//     renderer: xRenderer1,
//     tooltip: am5.Tooltip.new(root1, {})
//   }));
//   xRenderer1.grid.template.setAll({
//     location: 1
//   });
//   var yAxis1 = chart1.yAxes.push(am5xy.ValueAxis.new(root1, {
//     maxDeviation: 0,
//     min: 0,
//     renderer: am5xy.AxisRendererY.new(root1, { strokeOpacity: 0.1 }),
//     tooltip: am5.Tooltip.new(root1, {})
//   }));
//   var cursor1 = chart1.set("cursor", am5xy.XYCursor.new(root1, {
//     xAxis: xAxis1,
//     yAxis: yAxis1
//   }));
//   var series1 = chart1.series.push(am5xy.ColumnSeries.new(root1, {
//     xAxis: xAxis1,
//     yAxis: yAxis1,
//     valueYField: "value",
//     openValueYField: "open",
//     categoryXField: "category"
//   }));
//   series1.columns.template.setAll({
//     templateField: "columnConfig",
//     strokeOpacity: 0
//   });
//   series1.bullets.push(function() {
//     return am5.Bullet.new(root1, {
//       sprite: am5.Label.new(root1, {
//         text: "{displayValue}",
//         centerY: am5.p50,
//         centerX: am5.p50,
//         populateText: true
//       })
//     });
//   });
//   var stepSeries1 = chart1.series.push(am5xy.StepLineSeries.new(root1, {
//     xAxis: xAxis1,
//     yAxis: yAxis1,
//     valueYField: "stepValue",
//     categoryXField: "category",
//     noRisers: true,
//     locationX: 0.65,
//     stroke: root1.interfaceColors.get("alternativeBackground")
//   }));
//   stepSeries1.strokes.template.setAll({
//     strokeDasharray: [3, 3]
//   });
//   var colorSet1 = am5.ColorSet.new(root1, {});
//   fetch('AnalyticsIQ/supplier_sample.php')
//     .then(response => response.json())
//     .then(data => {
//       var data1 = [
//         { category: "Total Send", value: parseInt(data.donutData.total_send), open: 0, stepValue: parseInt(data.donutData.total_send), columnConfig: { fill: am5.color(0x4da6ff) }, displayValue: parseInt(data.donutData.total_send) },
//         { category: "Pending", value: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending), open: parseInt(data.donutData.total_send), stepValue: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending), columnConfig: { fill: am5.color(0xf4b943) }, displayValue: parseInt(data.donutData.pending) },
//         { category: "Approved", value: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved), open: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending), stepValue: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved), columnConfig: { fill: am5.color(0x32CD32) }, displayValue: parseInt(data.donutData.approved) },
//         { category: "Non Approved", value: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved), open: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved), stepValue: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved), columnConfig: { fill: am5.color(0xff0000) }, displayValue: parseInt(data.donutData.non_approved) },
//         { category: "Emergency Use Only", value: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved) + parseInt(data.donutData.emergency_use_only), open: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved), stepValue: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved) + parseInt(data.donutData.emergency_use_only), columnConfig: { fill: am5.color(0xff8080) }, displayValue: parseInt(data.donutData.emergency_use_only) },
//         { category: "Do Not Use", value: parseInt(data.donutData.total_send) - parseInt(data.donutData.pending) - parseInt(data.donutData.approved) - parseInt(data.donutData.non_approved) + parseInt(data.donutData.emergency_use_only), open: 0, columnConfig: { fill: am5.color(0xffff00) }, displayValue: parseInt(data.donutData.do_not_use) }
//       ];
//       xAxis1.data.setAll(data1);
//       series1.data.setAll(data1);
//       stepSeries1.data.setAll(data1);
//     })
//     .catch(error => console.error('Error fetching data:', error));
// });
// am5.ready(function() {
//   // Second Donut Chart
//   var root2 = am5.Root.new("donutChart2");
//   root2.setThemes([
//     am5themes_Animated.new(root2)
//   ]);
//   var chart2 = root2.container.children.push(
//     am5percent.PieChart.new(root2, {
//       layout: root2.verticalLayout,
//       innerRadius: am5.percent(50)
//     })
//   );
//   var series2 = chart2.series.push(
//     am5percent.PieSeries.new(root2, {
//       valueField: "value",
//       categoryField: "category"
//     })
//   );
//   fetch('AnalyticsIQ/supplier_sample.php')
//     .then(response => response.json())
//     .then(data => {
//       series2.data.setAll([
//         { category: "Once Per Day", value: parseInt(data.lineData.once_per_day), color: am5.color(0xc0ff80) },
//         { category: "Once Per Week", value: parseInt(data.lineData.once_per_week), color: am5.color(0x90EE90) },
//         { category: "1st and 15th", value: parseInt(data.lineData.first_and_fifteenth) },
//         { category: "Once Per Month", value: parseInt(data.lineData.once_per_month) },
//         { category: "Once Per Year", value: parseInt(data.lineData.once_per_year) }
//       ]);
//       series2.labels.template.set("text", "{category}: {value}");
//     })
//     .catch(error => console.error('Error fetching data:', error));
// });
// fetch('AnalyticsIQ/supplier_sample.php')
//     .then(response => response.json())
//     .then(data => {
//         // console.log(data); // Check fetched data in the console
//         // Donut Chart
//         am5.ready(function() {
//             var root = am5.Root.new("donutChart");
//             root.setThemes([
//                 am5themes_Animated.new(root)
//             ]);
//             var chart = root.container.children.push(
//                 am5percent.PieChart.new(root, {
//                     layout: root.verticalLayout,
//                     innerRadius: am5.percent(50)
//                 })
//             );
//             var series = chart.series.push(
//                 am5percent.PieSeries.new(root, {
//                     valueField: "value",
//                     categoryField: "category"
//                 })
//             );
//             series.data.setAll([
//                 { category: "Total Send", value: parseInt(data.donutData.total_send) },
//                 { category: "Pending", value: parseInt(data.donutData.pending) },
//                 { category: "Approved", value: parseInt(data.donutData.approved) },
//                 { category: "Non Approved", value: parseInt(data.donutData.non_approved) },
//                 { category: "Emergency Use Only", value: parseInt(data.donutData.emergency_use_only) },
//                 { category: "Do Not Use", value: parseInt(data.donutData.do_not_use) }
//             ]);
//             // Configure labels to show count
//             series.labels.template.set("text", "{category}: {value}");
//         });
//         // Second Donut Chart
//         am5.ready(function() {
//             var root = am5.Root.new("barChart");
//             root.setThemes([
//                 am5themes_Animated.new(root)
//             ]);
//             var chart = root.container.children.push(
//                 am5percent.PieChart.new(root, {
//                     layout: root.verticalLayout,
//                     innerRadius: am5.percent(50)
//                 })
//             );
//             var series = chart.series.push(
//                 am5percent.PieSeries.new(root, {
//                     valueField: "value",
//                     categoryField: "category"
//                 })
//             );
//             series.data.setAll([
//                 { category: "Once Per Day", value: parseInt(data.lineData.once_per_day) },
//                 { category: "Once Per Week", value: parseInt(data.lineData.once_per_week) },
//                 { category: "1st and 15th", value: parseInt(data.lineData.first_and_fifteenth) },
//                 { category: "Once Per Month", value: parseInt(data.lineData.once_per_month) },
//                 { category: "Once Per Year", value: parseInt(data.lineData.once_per_year) }
//             ]);
//             // Configure labels to show count
//             series.labels.template.set("text", "{category}: {value}");
//         });
//     })
//     .catch(error => console.error('Error fetching data:', error));
// Fetch the JSON data from PHP
// fetch('AnalyticsIQ/supplier_sample2_data.php')
//     .then(response => response.json())
//     .then(chartData => {
//         // Create chart
//         am5.ready(function() {
//             var root = am5.Root.new("sample2chartdiv");
//             root.setThemes([
//                 am5themes_Animated.new(root)
//             ]);
//             var chart = root.container.children.push(am5xy.XYChart.new(root, {
//                 panX: true,
//                 panY: true,
//                 wheelX: "panX",
//                 wheelY: "zoomX",
//                 pinchZoomX: true
//             }));
//             var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
//             cursor.lineY.set("visible", false);
//             var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
//             xRenderer.labels.template.setAll({
//                 rotation: -45,
//                 centerY: am5.p50,
//                 centerX: am5.p100
//             });
//             var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
//                 maxDeviation: 0.3,
//                 categoryField: "category",
//                 renderer: xRenderer,
//                 tooltip: am5.Tooltip.new(root, {})
//             }));
//             var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
//                 maxDeviation: 0.3,
//                 renderer: am5xy.AxisRendererY.new(root, {})
//             }));
//             var series = chart.series.push(am5xy.ColumnSeries.new(root, {
//                 name: "Counts",
//                 xAxis: xAxis,
//                 yAxis: yAxis,
//                 valueYField: "count",
//                 sequencedInterpolation: true,
//                 categoryXField: "category",
//                 tooltip: am5.Tooltip.new(root, {
//                     labelText: "{valueY}"
//                 })
//             }));
//             series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5 });
//             series.columns.template.adapters.add("fill", function(fill, target) {
//                 return chart.get("colors").getIndex(series.columns.indexOf(target));
//             });
//             series.columns.template.adapters.add("stroke", function(stroke, target) {
//                 return chart.get("colors").getIndex(series.columns.indexOf(target));
//             });
//             xAxis.data.setAll(chartData);
//             series.data.setAll(chartData);
//             series.appear(1000);
//             chart.appear(1000, 100);
//         });
//     })
//     .catch(error => console.error('Error fetching the data:', error));
"use strict";
//# sourceMappingURL=supplier_chart1.dev.js.map
