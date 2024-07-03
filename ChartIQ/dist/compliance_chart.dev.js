"use strict";

document.addEventListener('DOMContentLoaded', function () {
  fetch('ChartIQ/compliance_data.php').then(function (response) {
    return response.json();
  }).then(function (data) {
    if (!data || !data.folderData || !data.folderData.length || !data.fileData) {
      console.error('Invalid data format:', data);
      alert('Received invalid data. Please check the server response.');
      return;
    }

    am5.ready(function () {
      var root = am5.Root["new"]("comchartdiv"); // Remove amCharts logo

      root._logo.dispose();

      root.setThemes([am5themes_Animated["new"](root)]);
      var chart = root.container.children.push(am5xy.XYChart["new"](root, {
        panX: false,
        panY: false,
        wheelX: "none",
        wheelY: "none",
        pinchZoomX: false,
        paddingTop: 50,
        layout: root.verticalLayout
      }));
      chart.set("colors", am5.ColorSet["new"](root, {
        colors: [am5.color(0xFFFF00), am5.color(0xFFA500), am5.color(0x228B22), // Color for non-expired
        am5.color(0xFF0000), am5.color(0xEE4B2B), am5.color(0xFF5C5C), am5.color(0xFF8A8A)]
      }));
      var xRenderer = am5xy.AxisRendererX["new"](root, {
        minGridDistance: 50,
        minorGridEnabled: true
      });
      xRenderer.grid.template.setAll({
        location: 1,
        strokeDasharray: [5, 5]
      });
      var yRenderer = am5xy.AxisRendererY["new"](root, {
        strokeOpacity: 0.1
      });
      yRenderer.grid.template.setAll({
        strokeDasharray: [5, 5]
      });
      xRenderer.labels.template.setAll({
        forceHidden: true
      });
      var xAxis = chart.xAxes.push(am5xy.CategoryAxis["new"](root, {
        categoryField: "category",
        renderer: xRenderer,
        tooltip: am5.Tooltip["new"](root, {})
      }));
      var yAxis = chart.yAxes.push(am5xy.ValueAxis["new"](root, {
        min: 0,
        renderer: yRenderer
      }));
      var series = chart.series.push(am5xy.ColumnSeries["new"](root, {
        name: "Series 1",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        categoryXField: "category",
        tooltip: am5.Tooltip["new"](root, {
          labelText: "{category}: {valueY}"
        })
      }));
      series.columns.template.setAll({
        tooltipY: 0,
        tooltipText: "{category}: {valueY}",
        shadowOpacity: 0.1,
        shadowOffsetX: 2,
        shadowOffsetY: 2,
        shadowBlur: 1,
        strokeWidth: 2,
        stroke: am5.color(0xffffff),
        shadowColor: am5.color(0x000000),
        cornerRadiusTL: 50,
        cornerRadiusTR: 50,
        fill: undefined,
        // Remove gradient fill
        fillOpacity: 1 // Set the transparency here

      });
      series.columns.template.states.create("hover", {
        shadowOpacity: 1,
        shadowBlur: 10,
        cornerRadiusTL: 10,
        cornerRadiusTR: 10
      });
      series.columns.template.adapters.add("fill", function (fill, target) {
        return chart.get("colors").getIndex(series.columns.indexOf(target));
      });
      var chartData = [{
        category: "Folders",
        value: Number(data.folderData[0].main_folder_count)
      }, {
        category: "Documents",
        value: Number(data.fileData.latest_files_count)
      }, {
        category: "Non Expired",
        value: Number(data.fileData.non_expired)
      }, // Add non-expired count
      {
        category: "Expired",
        value: Number(data.fileData.expired)
      }, {
        category: "Nearly Expired 30 Days",
        value: Number(data.fileData.nearly_expired_30_days)
      }, {
        category: "Nearly Expired 60 Days",
        value: Number(data.fileData.nearly_expired_60_days)
      }, {
        category: "Nearly Expired 90 Days",
        value: Number(data.fileData.nearly_expired_90_days)
      }];
      xAxis.data.setAll(chartData);
      series.data.setAll(chartData);
      var legend = chart.children.unshift(am5.Legend["new"](root, {
        centerX: am5.p50,
        x: am5.p50,
        y: am5.percent(-4),
        layout: root.gridLayout
      }));
      legend.data.setAll(series.dataItems);
      legend.labels.template.setAll({
        text: "{category}: {valueY}",
        maxWidth: 120,
        wrap: true,
        fill: am5.color(0x000000)
      });
      legend.set("width", am5.percent(100)); // Ensure the legend uses the full width of the chart

      legend.set("fixedWidthGrid", true); // Use a fixed width grid for the legend items

      series.appear(1000);
      chart.appear(1000, 100); // Handle window resize

      function handleResize() {
        if (window.innerWidth < 600) {
          legend.set("layout", root.verticalLayout);
          legend.set("y", am5.percent(0));
        } else if (window.innerWidth < 1024) {
          legend.set("layout", root.horizontalLayout);
          legend.set("y", am5.percent(2));
        } else {
          legend.set("layout", root.gridLayout);
          legend.set("y", am5.percent(-4));
        }
      }

      window.addEventListener('resize', function () {
        handleResize();
        chart.appear(0, 0);
      });
      handleResize(); // Initial call to set the correct layout
    });
  })["catch"](function (error) {
    console.error('Error fetching data:', error);
    alert('Failed to fetch compliance data. Please try again later.');
  });
}); //LEFT TO RIGHT ANALYTICS

document.addEventListener('DOMContentLoaded', function () {
  fetch('ChartIQ/compliance_data.php').then(function (response) {
    return response.json();
  }).then(function (data) {
    if (!data || !data.folderData || !data.folderData.length || !data.fileData) {
      console.error('Invalid data format:', data);
      alert('Received invalid data. Please check the server response.');
      return;
    }

    am5.ready(function () {
      // Create root element
      var root = am5.Root["new"]("comchartdiv1"); // Remove amCharts logo

      root._logo.dispose(); // Set themes


      root.setThemes([am5themes_Animated["new"](root)]); // Create chart

      var chart = root.container.children.push(am5xy.XYChart["new"](root, {
        panX: false,
        panY: false,
        wheelX: "none",
        wheelY: "none",
        pinchZoomX: false,
        paddingLeft: 0,
        layout: root.verticalLayout
      })); // Create axes

      var yAxis = chart.yAxes.push(am5xy.CategoryAxis["new"](root, {
        categoryField: "category",
        renderer: am5xy.AxisRendererY["new"](root, {
          inversed: true,
          cellStartLocation: 0.1,
          cellEndLocation: 0.9,
          minorGridEnabled: true
        })
      })); // Make the y-axis grid lines dashed

      yAxis.get("renderer").grid.template.setAll({
        strokeDasharray: [4, 4] // Adjust the pattern as needed

      }); // Find the maximum value in the dataset

      var maxValue = Math.max(Number(data.folderData[0].main_folder_count), Number(data.fileData.latest_files_count), Number(data.fileData.non_expired), Number(data.fileData.expired), Number(data.fileData.nearly_expired_30_days), Number(data.fileData.nearly_expired_60_days), Number(data.fileData.nearly_expired_90_days));
      var xAxis = chart.xAxes.push(am5xy.ValueAxis["new"](root, {
        renderer: am5xy.AxisRendererX["new"](root, {
          strokeOpacity: 0.1,
          minGridDistance: 50
        }),
        min: 0,
        max: maxValue > 100 ? maxValue : 100 // Set max to the greater value between maxValue and 100

      })); // Make the x-axis grid lines dashed

      xAxis.get("renderer").grid.template.setAll({
        strokeDasharray: [4, 4] // Adjust the pattern as needed

      }); // Data

      var chartData = [{
        category: "Folders",
        value: Number(data.folderData[0].main_folder_count)
      }, {
        category: "Documents",
        value: Number(data.fileData.latest_files_count)
      }, {
        category: "Non Expired",
        value: Number(data.fileData.non_expired) === 0 ? 100 : Number(data.fileData.non_expired)
      }, {
        category: "Expired",
        value: Number(data.fileData.expired) === 0 ? 100 : Number(data.fileData.expired)
      }, {
        category: "Nearly Expired 30 Days",
        value: Number(data.fileData.nearly_expired_30_days) === 0 ? 100 : Number(data.fileData.nearly_expired_30_days)
      }, {
        category: "Nearly Expired 60 Days",
        value: Number(data.fileData.nearly_expired_60_days) === 0 ? 100 : Number(data.fileData.nearly_expired_60_days)
      }, {
        category: "Nearly Expired 90 Days",
        value: Number(data.fileData.nearly_expired_90_days) === 0 ? 100 : Number(data.fileData.nearly_expired_90_days)
      }];
      yAxis.data.setAll(chartData); // Add series

      var series = chart.series.push(am5xy.ColumnSeries["new"](root, {
        xAxis: xAxis,
        yAxis: yAxis,
        valueXField: "value",
        categoryYField: "category",
        sequencedInterpolation: true,
        tooltip: am5.Tooltip["new"](root, {
          pointerOrientation: "horizontal",
          getFillFromSprite: false,
          autoTextColor: false,
          label: {
            fill: am5.color(0xFFFFFF)
          },
          background: am5.Rectangle["new"](root, {
            fill: am5.color(0x000000),
            fillOpacity: 0.7
          })
        })
      }));
      series.columns.template.setAll({
        height: am5.p100,
        strokeOpacity: 0
      });
      series.columns.template.adapters.add("tooltipText", function (text, target) {
        var dataItem = target.dataItem;

        if (dataItem) {
          var value = dataItem.get("valueX");

          if (value === 100) {
            return "[bold]{name}[/]\n{category}: {valueX}%";
          } else {
            return "[bold]{name}[/]\n{category}: {valueX}";
          }
        }

        return text;
      });
      series.columns.template.adapters.add("fill", function (fill, target) {
        var dataItem = target.dataItem;

        if (dataItem) {
          var category = dataItem.get("categoryY");
          var value = dataItem.get("valueX");

          if (value === 100) {
            return am5.color(0x228B22); // Green for 100%
          } else {
            switch (category) {
              case "Folders":
                return am5.color(0xFFFF00);

              case "Documents":
                return am5.color(0xFFA500);

              case "Non Expired":
                return am5.color(0x228B22);

              case "Nearly Expired 30 Days":
                return am5.color(0xEE4B2B);

              case "Nearly Expired 60 Days":
                return am5.color(0xFF5C5C);

              case "Nearly Expired 90 Days":
                return am5.color(0xFF8A8A);

              case "Expired":
                return value === 100 ? am5.color(0x228B22) : am5.color(0xFF0000);
              // Green for 100%, Red otherwise

              default:
                return am5.color(0x000000);
            }
          }
        }

        return fill;
      }); // Add bullets to display values inside or outside the bars

      series.bullets.push(function (root, series, dataItem) {
        var value = dataItem.get("valueX");
        var labelInside = value < 15 ? false : true; // Adjust threshold as needed

        var category = dataItem.get("categoryY"); // Check if the category is Expired, Nearly Expired 30 Days, Nearly Expired 60 Days, or Nearly Expired 90 Days

        var displayPercentage = ["Nearly Expired 30 Days", "Nearly Expired 60 Days", "Nearly Expired 90 Days"].includes(category);
        return am5.Bullet["new"](root, {
          locationX: labelInside ? 0.5 : 1.05,
          locationY: 0.5,
          sprite: am5.Label["new"](root, {
            centerX: labelInside ? am5.p50 : am5.p0,
            centerY: am5.p50,
            text: value === 100 ? "{valueX}%" : "{valueX}",
            fill: am5.color(0xFFFFFF),
            populateText: true
          })
        });
      });
      series.data.setAll(chartData);
      series.appear(); // Add legend

      var legend = chart.children.push(am5.Legend["new"](root, {
        centerX: am5.p50,
        x: am5.p50
      })); // Add legend items manually

      legend.data.setAll([{
        name: "Folders",
        fill: am5.color(0xFFFF00)
      }, {
        name: "Documents",
        fill: am5.color(0xFFA500)
      }, {
        name: "Non Expired",
        fill: am5.color(0x228B22)
      }, {
        name: "Expired",
        fill: am5.color(0xFF0000)
      }, {
        name: "Nearly Expired 30 Days",
        fill: am5.color(0xEE4B2B)
      }, {
        name: "Nearly Expired 60 Days",
        fill: am5.color(0xFF5C5C)
      }, {
        name: "Nearly Expired 90 Days",
        fill: am5.color(0xFF8A8A)
      }]); // Add cursor

      var cursor = chart.set("cursor", am5xy.XYCursor["new"](root, {
        behavior: "none" // No zooming on scroll

      }));
      cursor.lineY.set("forceHidden", true);
      cursor.lineX.set("forceHidden", true); // Make stuff animate on load

      chart.appear(1000, 100); // Handle window resize

      function handleResize() {
        if (window.innerWidth < 600) {
          legend.set("layout", root.verticalLayout);
        } else {
          legend.set("layout", root.horizontalLayout);
        }
      }

      window.addEventListener('resize', function () {
        handleResize();
        chart.appear(0, 0);
      });
      handleResize(); // Initial call to set the correct layout
    });
  })["catch"](function (error) {
    console.error('Error fetching data:', error);
    alert('Failed to fetch compliance data. Please try again later.');
  });
}); //COMPLIANCE AND NON COMPLIANCE ANALYTICS

$.ajax({
  url: 'ChartIQ/compliance_non_data.php',
  method: 'GET',
  dataType: 'json',
  success: function success(data) {
    am5.ready(function () {
      // Create root element
      var root = am5.Root["new"]("chartdiv4"); // Set themes

      root.setThemes([am5themes_Animated["new"](root)]); // Create chart

      var chart = root.container.children.push(am5percent.PieChart["new"](root, {
        layout: root.verticalLayout
      })); // Create series

      var series = chart.series.push(am5percent.PieSeries["new"](root, {
        valueField: "value",
        categoryField: "category"
      })); // Prepare data for the chart

      var chartData = [];

      if (data.compliantPercentage > 0 || data.nonCompliantPercentage > 0) {
        chartData = [{
          category: "Compliance",
          value: data.compliantPercentage
        }, {
          category: "Non-Compliance",
          value: data.nonCompliantPercentage
        }];
      } else {
        chartData = [{
          category: "No Data",
          value: 1
        }];
      } // Set data


      series.data.setAll(chartData); // Apply color to each slice explicitly

      series.slices.each(function (slice) {
        if (slice.dataItem.dataContext.category === "Compliance") {
          slice.set("fill", am5.color(0x5CFF5C)); // Green color for compliance

          slice.set("stroke", am5.color(0x5CFF5C));
        } else if (slice.dataItem.dataContext.category === "Non-Compliance") {
          slice.set("fill", am5.color(0xFF0000)); // Red color for non-compliance

          slice.set("stroke", am5.color(0xFF0000));
        } else {
          slice.set("fill", am5.color(0xCCCCCC)); // Grey color for no data

          slice.set("stroke", am5.color(0xCCCCCC));
        }
      }); // Add legend

      var legend = chart.children.push(am5.Legend["new"](root, {
        centerX: am5.percent(50),
        x: am5.percent(50),
        layout: root.horizontalLayout
      }));
      legend.data.setAll(series.dataItems);
    });
  },
  error: function error(xhr, status, _error) {
    console.error('AJAX request failed:', status, _error);
  }
}); //ANNUALL REVIEW ANALYTICS

$(document).ready(function () {
  $.ajax({
    url: 'ChartIQ/annual_review_data.php',
    type: 'GET',
    dataType: 'json',
    success: function success(data) {
      var reviewPercentage = data.review_percentage;
      am5.ready(function () {
        // Create root element
        var root = am5.Root["new"]("chartdiv3"); // Set themes

        root.setThemes([am5themes_Animated["new"](root)]); // Create chart

        var chart = root.container.children.push(am5percent.PieChart["new"](root, {
          endAngle: 270
        })); // Create series

        var series = chart.series.push(am5percent.PieSeries["new"](root, {
          valueField: "value",
          categoryField: "category",
          endAngle: 270
        }));
        series.data.setAll([{
          category: "Annual Review",
          value: reviewPercentage
        }, {
          category: "Remaining",
          value: 100 - reviewPercentage
        }]); // Add legend and position it below the chart, aligned horizontally

        var legend = root.container.children.push(am5.Legend["new"](root, {
          centerX: am5.percent(50),
          x: am5.percent(50),
          centerY: am5.percent(100),
          y: am5.percent(100),
          layout: root.horizontalLayout // Set layout to horizontal

        }));
        legend.data.setAll(series.dataItems);
        series.appear(1000, 100);
      }); // end am5.ready()
    },
    error: function error(xhr, status, _error2) {
      console.error('Error fetching data:', _error2);
    }
  });
});
//# sourceMappingURL=compliance_chart.dev.js.map
