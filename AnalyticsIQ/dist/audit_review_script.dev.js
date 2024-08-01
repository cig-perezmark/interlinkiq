"use strict";

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === "[object Arguments]")) { return; } var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function fetchData() {
  var response, data, parseDate, cleanedData;
  return regeneratorRuntime.async(function fetchData$(_context) {
    while (1) {
      switch (_context.prev = _context.next) {
        case 0:
          _context.prev = 0;
          _context.next = 3;
          return regeneratorRuntime.awrap(fetch('AnalyticsIQ/audit_annual_data.php'));

        case 3:
          response = _context.sent;
          _context.next = 6;
          return regeneratorRuntime.awrap(response.json());

        case 6:
          data = _context.sent;
          console.log(data); // Log the fetched data
          // Helper function to parse date strings

          parseDate = function parseDate(dateString) {
            var _dateString$split$map = dateString.split('/').map(Number),
                _dateString$split$map2 = _slicedToArray(_dateString$split$map, 3),
                month = _dateString$split$map2[0],
                day = _dateString$split$map2[1],
                year = _dateString$split$map2[2];

            return new Date(year, month - 1, day);
          }; // Clean data to remove extra spaces and format correctly


          cleanedData = data.map(function (item) {
            var parseDuration = function parseDuration(start, end) {
              return (parseDate(end) - new Date(start)) / (1000 * 60 * 60 * 24);
            };

            return {
              reviewed_by: item.reviewed_by.trim(),
              annual_review_count: parseInt(item.annual_review_count, 10),
              total_audits: parseInt(item.total_audits, 10),
              audit_report_start: new Date(item['Audit Report Date']),
              audit_report_duration: parseDuration(item['Audit Report Date'], item['Audit Report End Date']),
              audit_certificate_start: new Date(item['Audit Certificate Date']),
              audit_certificate_duration: parseDuration(item['Audit Certificate Date'], item['Audit Certificate End Date']),
              audit_corrective_action_start: new Date(item['Audit Corrective Action Date']),
              audit_corrective_action_duration: parseDuration(item['Audit Corrective Action Date'], item['Audit Corrective Action End Date']),
              reviewed_start: new Date(item['Reviewed Date']),
              reviewed_duration: parseDuration(item['Reviewed Date'], item['Reviewed Due'])
            };
          });
          am5.ready(function () {
            var root = am5.Root["new"]("auditChartdiv123"); // Set themes

            root.setThemes([am5themes_Animated["new"](root)]); // Create chart

            var chart = root.container.children.push(am5xy.XYChart["new"](root, {
              panX: false,
              panY: false,
              wheelX: "none",
              // Disable zooming
              wheelY: "none",
              // Disable zooming
              layout: root.verticalLayout
            })); // Add legend

            var legend = chart.children.push(am5.Legend["new"](root, {
              centerX: am5.p50,
              x: am5.p50,
              marginTop: 20 // Add margin top to create space

            })); // Create axes

            var xAxis = chart.xAxes.push(am5xy.CategoryAxis["new"](root, {
              categoryField: "reviewed_by",
              renderer: am5xy.AxisRendererX["new"](root, {
                cellStartLocation: 0.1,
                cellEndLocation: 0.9,
                minGridDistance: 10
              }),
              tooltip: am5.Tooltip["new"](root, {})
            }));
            xAxis.get("renderer").labels.template.setAll({
              forceHidden: true
            });
            xAxis.get("renderer").grid.template.set("forceHidden", true);
            xAxis.data.setAll(cleanedData);
            var yAxis = chart.yAxes.push(am5xy.ValueAxis["new"](root, {
              renderer: am5xy.AxisRendererY["new"](root, {})
            }));
            var yAxis2 = chart.yAxes.push(am5xy.ValueAxis["new"](root, {
              renderer: am5xy.AxisRendererY["new"](root, {
                opposite: true
              }),
              syncWithAxis: yAxis
            })); // Add series

            function makeSeries(name, fieldName, color, stacked, baseFieldName, isDuration, addToLegend, yAxis) {
              var series = chart.series.push(am5xy.ColumnSeries["new"](root, {
                name: name,
                xAxis: xAxis,
                yAxis: yAxis,
                stacked: stacked,
                valueYField: fieldName,
                openValueYField: baseFieldName,
                categoryXField: "reviewed_by",
                stroke: color,
                fill: color
              }));
              series.columns.template.setAll({
                tooltipText: "{name}: {valueY}",
                width: am5.percent(50),
                // Adjusted width of bars
                tooltipY: 0,
                strokeWidth: 0 // Remove border

              }); // Change color based on duration

              if (isDuration) {
                series.columns.template.adapters.add("fill", function (fill, target) {
                  var duration = target.dataItem.get("valueY");
                  if (duration <= 30) return am5.color(0xFF0000); // Red for 30 days or less

                  if (duration <= 60) return am5.color(0xFFA500); // Orange for 60 days or less

                  if (duration <= 90) return am5.color(0xFFD700); // Yellow for 90 days or less

                  return am5.color(0x5bd75b); // Green for more than 90 days
                });
              }

              series.data.setAll(cleanedData);
              series.appear();
              if (addToLegend) legend.data.push(series);
            } // Create stacked series for each date pair


            makeSeries("Audit Report", "audit_report_start", am5.color(0x2c4e31), false, null, false, true, yAxis);
            makeSeries("Audit Report Duration", "audit_report_duration", am5.color(0xFFD700), true, "audit_report_start", true, false, yAxis);
            makeSeries("Audit Certificate", "audit_certificate_start", am5.color(0x3e6e45), false, null, false, true, yAxis);
            makeSeries("Audit Certificate Duration", "audit_certificate_duration", am5.color(0x4A731C), true, "audit_certificate_start", true, false, yAxis);
            makeSeries("Audit Corrective Action", "audit_corrective_action_start", am5.color(0x518f5a), false, null, false, true, yAxis);
            makeSeries("Audit Corrective Action Duration", "audit_corrective_action_duration", am5.color(0x883407), true, "audit_corrective_action_start", true, false, yAxis);
            makeSeries("Reviewed", "reviewed_start", am5.color(0x097969), false, null, false, true, yAxis);
            makeSeries("Reviewed Duration", "reviewed_duration", am5.color(0x32CD32), true, "reviewed_start", true, false, yAxis); // Individual series

            makeSeries("Annual Review", "annual_review_count", am5.color(0x0096FF), false, null, false, true, yAxis2);
            makeSeries("Audit", "total_audits", am5.color(0x87CEEB), false, null, false, true, yAxis2); // Make stuff animate on load

            chart.appear(1000, 100); // Add "Reviewed by:" label within the chart

            chart.children.push(am5.Label["new"](root, {
              text: "Reviewed by: " + cleanedData[0].reviewed_by,
              fontSize: 20,
              centerX: am5.p50,
              x: am5.p50,
              marginTop: 20,
              dy: 10
            }));
          });
          _context.next = 16;
          break;

        case 13:
          _context.prev = 13;
          _context.t0 = _context["catch"](0);
          console.error('Error fetching data:', _context.t0);

        case 16:
        case "end":
          return _context.stop();
      }
    }
  }, null, null, [[0, 13]]);
}

fetchData();
//# sourceMappingURL=audit_review_script.dev.js.map
