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
        colors: [am5.color(0xFFFF00), am5.color(0xFFA500), am5.color(0x228B22), am5.color(0xFF0000), am5.color(0xEE4B2B), am5.color(0xFF5C5C), am5.color(0xFF8A8A)]
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
        fillOpacity: 1
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
        category: "Files",
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
      legend.set("width", am5.percent(100));
      legend.set("fixedWidthGrid", true);
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
      handleResize();
    });
  })["catch"](function (error) {
    console.error('Error fetching data:', error);
    alert('Failed to fetch compliance data. Please try again later.');
  });
});
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
      var root = am5.Root["new"]("comchartdiv1");

      root._logo.dispose();

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
      }));
      var xAxis = chart.xAxes.push(am5xy.ValueAxis["new"](root, {
        renderer: am5xy.AxisRendererX["new"](root, {
          strokeOpacity: 0.1,
          minGridDistance: 50
        }),
        min: 0,
        max: 100
      })); // Data

      var chartData = [{
        category: "Folders",
        value: Number(data.folderData[0].main_folder_count)
      }, {
        category: "Files",
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
          labelText: "[bold]{name}[/]\n{category}: {valueX}%"
        })
      }));
      series.columns.template.setAll({
        height: am5.p100,
        strokeOpacity: 0
      });
      series.columns.template.adapters.add("fill", function (fill, target) {
        var dataItem = target.dataItem;

        if (dataItem) {
          var category = dataItem.get("categoryY");
          var value = dataItem.get("valueX");

          if (value === 100 && ["Non Expired", "Expired", "Nearly Expired 30 Days", "Nearly Expired 60 Days", "Nearly Expired 90 Days"].includes(category)) {
            return am5.color(0x228B22);
          } else {
            switch (category) {
              case "Folders":
                return am5.color(0xFFFF00);

              case "Files":
                return am5.color(0xFFA500);

              case "Non Expired":
                return am5.color(0x228B22);

              case "Expired":
                return am5.color(0xFF0000);

              case "Nearly Expired 30 Days":
                return am5.color(0xEE4B2B);

              case "Nearly Expired 60 Days":
                return am5.color(0xFF5C5C);

              case "Nearly Expired 90 Days":
                return am5.color(0xFF8A8A);

              default:
                return am5.color(0x000000);
            }
          }
        }

        return fill;
      });
      series.bullets.push(function (root, series, dataItem) {
        return am5.Bullet["new"](root, {
          locationX: 1,
          locationY: 0.5,
          sprite: am5.Label["new"](root, {
            centerX: am5.p100,
            centerY: am5.p50,
            text: dataItem.get("valueX") + "%",
            fill: am5.color(0xffffff),
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
        name: "Files",
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
});
//# sourceMappingURL=compliance_chart.dev.js.map
