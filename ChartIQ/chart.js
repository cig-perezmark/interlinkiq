//DRAG AND DROP 
am5.ready(function() {

    var root = am5.Root.new("chartdiv");

    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    var chart = root.container.children.push(
        am5percent.PieChart.new(root, {
            layout: root.verticalLayout
        })
    );

    var series = chart.series.push(
        am5percent.PieSeries.new(root, {
            valueField: "value",
            categoryField: "category",
            alignLabels: false,
            labels: {
                template: {
                    textType: "circular",
                    inside: true,
                    radius: 30
                }
            }
        })
    );

    series.data.setAll([{ category: "No Data", value: 1 }]);

    var fieldLabels = {
        filled_out: ['Properly Filled Out', 'Not Filled Out'],
        signed: ['Properly Signed', 'Not Properly Signed'],
        compliance: ['Compliant', 'Non-Compliant'],
        frequency: ['Daily', 'Weekly', 'Monthly', 'Quarterly', 'Biannual', 'Annually'],
        assigned_count: []
    };

    document.querySelectorAll('.draggable').forEach(item => {
        item.addEventListener('dragstart', dragStart);
        item.addEventListener('click', handleClick);
    });

    document.getElementById('chart-container').addEventListener('dragover', dragOver);
    document.getElementById('chart-container').addEventListener('drop', drop);

    function dragStart(event) {
        event.dataTransfer.setData('text', event.target.getAttribute('data-field'));
    }

    function dragOver(event) {
        event.preventDefault();
    }

    function drop(event) {
        event.preventDefault();
        var field = event.dataTransfer.getData('text');
        fetchData(field);
    }

    function handleClick(event) {
        var field = event.target.getAttribute('data-field');
        fetchData(field);
    }
   
    function fetchData(field) {
        $.ajax({
            url: 'ChartIQ/rvm_data.php',
            method: 'GET',
            data: { field: field },
            dataType: 'json',
            success: function(response) {
                updateChart(field, response);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    function updateChart(field, data) {
        document.getElementById('initial-message').style.display = 'none';
        series.data.clear();

        var chartData = [];

        if (field === 'filled_out' || field === 'signed' || field === 'compliance') {
            chartData.push({ category: fieldLabels[field][0] + ' (' + data[0].count_1 + ')', value: data[0].count_1 });
            chartData.push({ category: fieldLabels[field][1] + ' (' + data[0].count_0 + ')', value: data[0].count_0 });
        } else if (field === 'frequency') {
            chartData.push({ category: fieldLabels[field][0] + ' (' + data[0].daily + ')', value: data[0].daily });
            chartData.push({ category: fieldLabels[field][1] + ' (' + data[0].weekly + ')', value: data[0].weekly });
            chartData.push({ category: fieldLabels[field][2] + ' (' + data[0].monthly + ')', value: data[0].monthly });
            chartData.push({ category: fieldLabels[field][3] + ' (' + data[0].quarterly + ')', value: data[0].quarterly });
            chartData.push({ category: fieldLabels[field][4] + ' (' + data[0].biannual + ')', value: data[0].biannual });
            chartData.push({ category: fieldLabels[field][5] + ' (' + data[0].annually + ')', value: data[0].annually });
        } else if (field === 'assigned_count') {
            data.forEach(row => {
                chartData.push({ category: row.full_name + ' (' + row.assigned_count + ')', value: row.assigned_count });
            });
        }

        series.data.setAll(chartData);
    }
});



  // Nelmar CHART Fetch data from the server

  async function fetchData() {
    try {
        const response = await fetch('ChartIQ/fetch_rvm_data.php');
        const data = await response.json();
        console.log("Fetched Data:", data); // Log the fetched data
        return data;
    } catch (error) {
        console.error("Error fetching data:", error);
    }
}

// Function to create charts
function createCharts(data) {
    console.log("Creating charts with data:", data); // Log the data used for creating charts

    // Create filled out chart
    createDonutChart("filledOutChart", [
        { category: `Filled Out (${data.filled_out.filled_out_1})`, value: parseInt(data.filled_out.filled_out_1), isNotFilledOut: false },
        { category: `Not Filled Out (${data.filled_out.filled_out_0})`, value: parseInt(data.filled_out.filled_out_0), isNotFilledOut: true }
    ], "Filled Out Status");

    // Create signed chart
    createDonutChart("signedChart", [
        { category: `Signed (${data.signed.signed_1})`, value: parseInt(data.signed.signed_1), isNotSigned: false },
        { category: `Not Signed (${data.signed.signed_0})`, value: parseInt(data.signed.signed_0), isNotSigned: true }
    ], "Signed Status");

    // Create compliance chart
    createBarChart("complianceChart", [
        { category: `Compliant (${data.compliance.compliance_1})`, value: parseInt(data.compliance.compliance_1) },
        { category: `Non Compliant (${data.compliance.compliance_0})`, value: parseInt(data.compliance.compliance_0), isNonCompliant: true }
    ], "Compliance Status");

    // Create frequency chart
    createCurvedColumnChart("frequencyChart", [
        { category: `Daily (${data.frequency.frequency_0})`, value: parseInt(data.frequency.frequency_0) },
        { category: `Weekly (${data.frequency.frequency_1})`, value: parseInt(data.frequency.frequency_1) },
        { category: `Monthly (${data.frequency.frequency_2})`, value: parseInt(data.frequency.frequency_2) },
        { category: `Quarterly (${data.frequency.frequency_3})`, value: parseInt(data.frequency.frequency_3) },
        { category: `Biannual (${data.frequency.frequency_4})`, value: parseInt(data.frequency.frequency_4) },
        { category: `Annually (${data.frequency.frequency_5})`, value: parseInt(data.frequency.frequency_5) }
    ], "Frequency");
}

// Function to create a donut chart with radial gradient
function createDonutChart(divId, data, title) {
    am5.ready(function() {
        console.log(`Creating donut chart in ${divId} with data:`, data); // Log the data for each chart
        var root = am5.Root.new(divId);

        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        var chart = root.container.children.push(am5percent.PieChart.new(root, {
            innerRadius: am5.percent(50)
        }));

        var series = chart.series.push(am5percent.PieSeries.new(root, {
            valueField: "value",
            categoryField: "category",
            alignLabels: false
        }));

        series.labels.template.setAll({
            textType: "circular",
            radius: 10
        });

        series.slices.template.setAll({
            strokeWidth: 2,
            strokeOpacity: 1,
            radialGradient: am5.RadialGradient.new(root, {
                stops: [{
                    brighten: -0.8
                }, {
                    brighten: -0.3
                }]
            })
        });

        // Set slice colors based on the data condition
        series.slices.template.adapters.add("fill", function(fill, target) {
            if (target.dataItem.dataContext.isNotFilledOut || target.dataItem.dataContext.isNotSigned) {
                return am5.color(0xff8080); // Light red color for not filled out or not signed
            }
            return fill;
        });

        series.slices.template.adapters.add("stroke", function(stroke, target) {
            if (target.dataItem.dataContext.isNotFilledOut || target.dataItem.dataContext.isNotSigned) {
                return am5.color(0xff8080); // Light red color for not filled out or not signed
            }
            return stroke;
        });

        series.data.setAll(data);

        // Create legend
        var legend = chart.children.push(am5.Legend.new(root, {
            centerX: am5.percent(50),
            x: am5.percent(50),
            y: am5.percent(1), // Position the legend above the chart
            layout: root.horizontalLayout
        }));

        legend.data.setAll(series.dataItems);
    });
}

// Function to create a bar chart
function createBarChart(divId, data, title) {
    am5.ready(function() {
        console.log(`Creating bar chart in ${divId} with data:`, data); // Log the data for each chart
        var root = am5.Root.new(divId);

        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX: true
        }));

        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
        cursor.lineY.set("visible", false);

        var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
            maxDeviation: 0.3,
            categoryField: "category",
            renderer: xRenderer,
            tooltip: am5.Tooltip.new(root, {})
        }));

        xRenderer.labels.template.setAll({
            rotation: -45,
            centerY: am5.p50,
            centerX: 0
        });

        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererY.new(root, {})
        }));

        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
            name: title,
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value",
            sequencedInterpolation: true,
            categoryXField: "category",
            tooltip: am5.Tooltip.new(root, {
                labelText: "{valueY}"
            })
        }));

        series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5 });
        series.columns.template.adapters.add("fill", function(fill, target) {
            if (target.dataItem.dataContext.isNonCompliant) {
                return am5.color(0xff8080); // Light red color for non compliant
            }
            return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        series.columns.template.adapters.add("stroke", function(stroke, target) {
            if (target.dataItem.dataContext.isNonCompliant) {
                return am5.color(0xff8080); // Light red color for non compliant
            }
            return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        xAxis.data.setAll(data);
        series.data.setAll(data);

        // Create legend
        var legend = chart.children.push(am5.Legend.new(root, {
            centerX: am5.percent(50),
            x: am5.percent(50),
            y: am5.percent(-2), // Position the legend above the chart
            layout: root.horizontalLayout
        }));

        legend.data.setAll(series.dataItems);
        legend.labels.template.setAll({
            text: "{categoryX}: {valueY}"
        });

        series.appear(1000);
        chart.appear(1000, 100);
    });
}

// Function to create a curved column chart
function createCurvedColumnChart(divId, data, title) {
    am5.ready(function() {
        console.log(`Creating curved column chart in ${divId} with data:`, data); // Log the data for each chart
        var root = am5.Root.new(divId);

        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX: true
        }));

        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
        cursor.lineY.set("visible", false);

        var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
            maxDeviation: 0.3,
            categoryField: "category",
            renderer: xRenderer,
            tooltip: am5.Tooltip.new(root, {})
        }));

        xRenderer.labels.template.setAll({
            rotation: -45,
            centerY: am5.p50,
            centerX: 0
        });

        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererY.new(root, {})
        }));

        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
            name: title,
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value",
            sequencedInterpolation: true,
            categoryXField: "category",
            tooltip: am5.Tooltip.new(root, {
                labelText: "{valueY}"
            })
        }));

        series.columns.template.setAll({
            cornerRadiusTL: 10,
            cornerRadiusTR: 10,
            cornerRadiusBL: 10,
            cornerRadiusBR: 10
        });

        series.columns.template.adapters.add("fill", function(fill, target) {
            return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        series.columns.template.adapters.add("stroke", function(stroke, target) {
            return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        xAxis.data.setAll(data);
        series.data.setAll(data);

        // Create legend
        var legend = chart.children.push(am5.Legend.new(root, {
            centerX: am5.percent(50),
            x: am5.percent(50),
            y: am5.percent(-2), // Position the legend above the chart
            layout: root.horizontalLayout
        }));

        legend.data.setAll(series.dataItems);
        legend.labels.template.setAll({
            text: "{categoryX}: {valueY}"
        });

        series.appear(1000);
        chart.appear(1000, 100);
    });
}

// Fetch data and create charts when the page loads
window.onload = async function() {
    const data = await fetchData();
    if (data) {
        createCharts(data);
    }
}
    
// END CHART


//ASSIGNED TO CHART
document.addEventListener('DOMContentLoaded', async () => {
    try {
        const response = await fetch('ChartIQ/chart_data.php');

        console.log(response)

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const chartData = await response.json();
        console.log("Chart Data:", chartData);

        // Check if data is empty
        if (chartData.length === 0) {
            console.log("No data available for the chart.");
            var chartDiv = document.getElementById("chartdiv3");
            chartDiv.innerHTML = "<p style='font-size: 20px; text-align: center;'>No data available to display.</p>";
            return;
        }

        // Create root and chart
        am5.ready(function() {
            var root = am5.Root.new("chartdiv3");

            root.setThemes([
                am5themes_Animated.new(root)
            ]);

            // Create a pie chart
            var chart = root.container.children.push(
                am5percent.PieChart.new(root, {
                    layout: root.verticalLayout
                })
            );

            // Create series
            var series = chart.series.push(
                am5percent.PieSeries.new(root, {
                    name: "Assigned Forms",
                    valueField: "assigned_forms",
                    categoryField: "employee",
                    innerRadius: am5.percent(50) // This makes it a donut chart
                })
            );

            series.data.setAll(chartData);

            series.slices.template.setAll({
                tooltipText: "{category}: {value} forms",
                tooltipY: 0,
                tooltipX: 0
            });

            // Add legend
            var legend = chart.children.push(am5.Legend.new(root, {}));
            legend.data.setAll(series.dataItems);

            series.appear(1000, 100);
            chart.appear(1000, 100);
        });
    } catch (error) {
        console.error("Error fetching chart data:", error);
    }
});



//Assigned to #2

document.addEventListener('DOMContentLoaded', (event) => {
    // Fetch data using AJAX
    fetch('ChartIQ/assigned_to_data.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                document.getElementById("assignedtochart").innerHTML = "<p style='font-size: 20px; text-align: center;'>No data available to display.</p>";
                return;
            }

            // Debugging: Check fetched data
            console.log("Chart Data:", data);

            // Check if data is empty
            if (data.length === 0) {
                console.log("No data available for the chart.");
                document.getElementById("assignedtochart").innerHTML = "<p style='font-size: 20px; text-align: center;'>No data available to display.</p>";
                return;
            }

            // Create root and chart
            am5.ready(function() {
                var root = am5.Root.new("assignedtochart");

                root.setThemes([
                    am5themes_Animated.new(root)
                ]);

                // Create a pie chart
                var chart = root.container.children.push(
                    am5percent.PieChart.new(root, {
                        layout: root.verticalLayout
                    })
                );

                // Create series
                var series = chart.series.push(
                    am5percent.PieSeries.new(root, {
                        name: "Assigned Forms",
                        valueField: "assigned_forms",
                        categoryField: "employee",
                        innerRadius: 0
                        // innerRadius: am5.percent(50) // This makes it a donut chart
                    })
                );

                series.data.setAll(data);

                series.slices.template.setAll({
                    tooltipText: "{category}: {value} forms",
                    tooltipY: 0,
                    tooltipX: 0
                });

                // Add legend
                var legend = chart.children.push(am5.Legend.new(root, {}));
                legend.data.setAll(series.dataItems);

                series.appear(1000, 100);
                chart.appear(1000, 100);
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            document.getElementById("assignedtochart").innerHTML = "<p style='font-size: 20px; text-align: center;'>Error fetching data.</p>";
        });
});




// document.addEventListener('DOMContentLoaded', (event) => {
//     // Fetch data using AJAX
//     fetch('db_query.php')
//         .then(response => response.json())
//         .then(data => {
//             if (data.error) {
//                 console.error(data.error);
//                 document.getElementById("chartdiv3").innerHTML = "<p style='font-size: 20px; text-align: center;'>No data available to display.</p>";
//                 return;
//             }

//             // Debugging: Check fetched data
//             console.log("Chart Data:", data);

//             // Check if data is empty
//             if (data.length === 0) {
//                 console.log("No data available for the chart.");
//                 document.getElementById("chartdiv3").innerHTML = "<p style='font-size: 20px; text-align: center;'>No data available to display.</p>";
//                 return;
//             }

//             // Create root and chart
//             am5.ready(function() {
//                 var root = am5.Root.new("chartdiv3");

//                 root.setThemes([
//                     am5themes_Animated.new(root)
//                 ]);

//                 // Create a pie chart
//                 var chart = root.container.children.push(
//                     am5percent.PieChart.new(root, {
//                         layout: root.verticalLayout
//                     })
//                 );

//                 // Create series
//                 var series = chart.series.push(
//                     am5percent.PieSeries.new(root, {
//                         name: "Assigned Forms",
//                         valueField: "assigned_forms",
//                         categoryField: "employee",
//                         innerRadius: am5.percent(50) // This makes it a donut chart
//                     })
//                 );

//                 series.data.setAll(data);

//                 series.slices.template.setAll({
//                     tooltipText: "{category}: {value} forms",
//                     tooltipY: 0,
//                     tooltipX: 0
//                 });

//                 // Add legend
//                 var legend = chart.children.push(am5.Legend.new(root, {}));
//                 legend.data.setAll(series.dataItems);

//                 series.appear(1000, 100);
//                 chart.appear(1000, 100);
//             });
//         })
//         .catch(error => {
//             console.error('Error fetching data:', error);
//             document.getElementById("chartdiv3").innerHTML = "<p style='font-size: 20px; text-align: center;'>Error fetching data.</p>";
//         });
// });





//  // NELMAR BAR CHART Fetch data from the server
//  async function fetchData() {
//     try {
//         const response = await fetch('ChartIQ/fetch_rvm_data.php');
//         const data = await response.json();
//         console.log("Fetched Data:", data); // Log the fetched data
//         return data;
//     } catch (error) {
//         console.error("Error fetching data:", error);
//     }
// }

// // Function to create charts
// function createCharts(data) {
//     console.log("Creating charts with data:", data); // Log the data used for creating charts

//     // Create filled out chart
//     createBarChart("filledOutChart", [
//         { category: `Filled Out (${data.filled_out.filled_out_1})`, value: parseInt(data.filled_out.filled_out_1) },
//         { category: `Not Filled Out (${data.filled_out.filled_out_0})`, value: parseInt(data.filled_out.filled_out_0) }
//     ], "Filled Out Status");

//     // Create signed chart
//     createBarChart("signedChart", [
//         { category: `Signed (${data.signed.signed_1})`, value: parseInt(data.signed.signed_1) },
//         { category: `Not Signed (${data.signed.signed_0})`, value: parseInt(data.signed.signed_0) }
//     ], "Signed Status");

//     // Create compliance chart
//     createBarChart("complianceChart", [
//         { category: `Compliant (${data.compliance.compliance_1})`, value: parseInt(data.compliance.compliance_1) },
//         { category: `Non Compliant (${data.compliance.compliance_0})`, value: parseInt(data.compliance.compliance_0) }
//     ], "Compliance Status");

//     // Create frequency chart
//     createBarChart("frequencyChart", [
//         { category: `Daily (${data.frequency.frequency_0})`, value: parseInt(data.frequency.frequency_0) },
//         { category: `Weekly (${data.frequency.frequency_1})`, value: parseInt(data.frequency.frequency_1) },
//         { category: `Monthly (${data.frequency.frequency_2})`, value: parseInt(data.frequency.frequency_2) },
//         { category: `Quarterly (${data.frequency.frequency_3})`, value: parseInt(data.frequency.frequency_3) },
//         { category: `Biannual (${data.frequency.frequency_4})`, value: parseInt(data.frequency.frequency_4) },
//         { category: `Annually (${data.frequency.frequency_5})`, value: parseInt(data.frequency.frequency_5) }
//     ], "Frequency");
// }


// // Function to create a bar chart
// function createBarChart(divId, data, title) {
//     am5.ready(function() {
//         console.log(`Creating bar chart in ${divId} with data:`, data); // Log the data for each chart
//         var root = am5.Root.new(divId);

//         root.setThemes([
//             am5themes_Animated.new(root)
//         ]);

//         var chart = root.container.children.push(am5xy.XYChart.new(root, {
//             panX: true,
//             panY: true,
//             wheelX: "panX",
//             wheelY: "zoomX",
//             pinchZoomX: true
//         }));

//         var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
//         cursor.lineY.set("visible", false);

//         var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
//         var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
//             maxDeviation: 0.3,
//             categoryField: "category",
//             renderer: xRenderer,
//             tooltip: am5.Tooltip.new(root, {})
//         }));

//         xRenderer.labels.template.setAll({
//             rotation: -45,
//             centerY: am5.p50,
//             centerX: 0
//         });

//         var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
//             renderer: am5xy.AxisRendererY.new(root, {})
//         }));

//         var series = chart.series.push(am5xy.ColumnSeries.new(root, {
//             name: title,
//             xAxis: xAxis,
//             yAxis: yAxis,
//             valueYField: "value",
//             sequencedInterpolation: true,
//             categoryXField: "category",
//             tooltip: am5.Tooltip.new(root, {
//                 labelText: "{valueY}"
//             })
//         }));

//         series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5 });
//         series.columns.template.adapters.add("fill", function(fill, target) {
//             return chart.get("colors").getIndex(series.columns.indexOf(target));
//         });

//         series.columns.template.adapters.add("stroke", function(stroke, target) {
//             return chart.get("colors").getIndex(series.columns.indexOf(target));
//         });

//         xAxis.data.setAll(data);
//         series.data.setAll(data);

//         var legend = chart.children.push(am5.Legend.new(root, {
//             centerX: am5.percent(50),
//             x: am5.percent(50),
//             layout: root.horizontalLayout
//         }));

//         legend.data.setAll(series.dataItems);
//         legend.labels.template.setAll({
//             text: "{categoryX}: {valueY}"
//         });

//         series.appear(1000);
//         chart.appear(1000, 100);
//     });
// }

// // Fetch data and create charts when the page loads
// window.onload = async function() {
//     const data = await fetchData();
//     if (data) {
//         createCharts(data);
//     }
// }
//END BAR CHART




//BLUE CHART COLOR
// async function fetchData() {
//     try {
//         const response = await fetch('ChartIQ/fetch_rvm_data.php');
//         const data = await response.json();
//         console.log("Fetched Data:", data); // Log the fetched data
//         return data;
//     } catch (error) {
//         console.error("Error fetching data:", error);
//     }
// }

// // Function to create charts
// function createCharts(data) {
//     console.log("Creating charts with data:", data); // Log the data used for creating charts

//     // Create filled out chart
//     createDonutChart("filledOutChart", [
//         { category: `Filled Out (${data.filled_out.filled_out_1})`, value: parseInt(data.filled_out.filled_out_1) },
//         { category: `Not Filled Out (${data.filled_out.filled_out_0})`, value: parseInt(data.filled_out.filled_out_0) }
//     ], "Filled Out Status");

//     // Create signed chart
//     createDonutChart("signedChart", [
//         { category: `Signed (${data.signed.signed_1})`, value: parseInt(data.signed.signed_1) },
//         { category: `Not Signed (${data.signed.signed_0})`, value: parseInt(data.signed.signed_0) }
//     ], "Signed Status");

//     // Create compliance chart
//     createBarChart("complianceChart", [
//         { category: `Compliant (${data.compliance.compliance_1})`, value: parseInt(data.compliance.compliance_1) },
//         { category: `Non Compliant (${data.compliance.compliance_0})`, value: parseInt(data.compliance.compliance_0) }
//     ], "Compliance Status");

//     // Create frequency chart
//     createCurvedColumnChart("frequencyChart", [
//         { category: `Daily (${data.frequency.frequency_0})`, value: parseInt(data.frequency.frequency_0) },
//         { category: `Weekly (${data.frequency.frequency_1})`, value: parseInt(data.frequency.frequency_1) },
//         { category: `Monthly (${data.frequency.frequency_2})`, value: parseInt(data.frequency.frequency_2) },
//         { category: `Quarterly (${data.frequency.frequency_3})`, value: parseInt(data.frequency.frequency_3) },
//         { category: `Biannual (${data.frequency.frequency_4})`, value: parseInt(data.frequency.frequency_4) },
//         { category: `Annually (${data.frequency.frequency_5})`, value: parseInt(data.frequency.frequency_5) }
//     ], "Frequency");
// }

// // Function to create a donut chart with radial gradient
// function createDonutChart(divId, data, title) {
//     am5.ready(function() {
//         console.log(`Creating donut chart in ${divId} with data:`, data); // Log the data for each chart
//         var root = am5.Root.new(divId);

//         root.setThemes([
//             am5themes_Animated.new(root)
//         ]);

//         var chart = root.container.children.push(am5percent.PieChart.new(root, {
//             innerRadius: am5.percent(50)
//         }));

//         var series = chart.series.push(am5percent.PieSeries.new(root, {
//             valueField: "value",
//             categoryField: "category",
//             alignLabels: false
//         }));

//         series.labels.template.setAll({
//             textType: "circular",
//             radius: 10
//         });

//         series.slices.template.setAll({
//             strokeWidth: 2,
//             strokeOpacity: 1,
//             radialGradient: am5.RadialGradient.new(root, {
//                 stops: [{
//                     brighten: -0.8
//                 }, {
//                     brighten: -0.3
//                 }]
//             })
//         });

//         series.data.setAll(data);

//         var legend = chart.children.push(am5.Legend.new(root, {
//             centerX: am5.percent(50),
//             x: am5.percent(50),
//             layout: root.horizontalLayout
//         }));

//         legend.data.setAll(series.dataItems);
//     });
// }

// // Function to create a bar chart
// function createBarChart(divId, data, title) {
//     am5.ready(function() {
//         console.log(`Creating bar chart in ${divId} with data:`, data); // Log the data for each chart
//         var root = am5.Root.new(divId);

//         root.setThemes([
//             am5themes_Animated.new(root)
//         ]);

//         var chart = root.container.children.push(am5xy.XYChart.new(root, {
//             panX: true,
//             panY: true,
//             wheelX: "panX",
//             wheelY: "zoomX",
//             pinchZoomX: true
//         }));

//         var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
//         cursor.lineY.set("visible", false);

//         var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
//         var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
//             maxDeviation: 0.3,
//             categoryField: "category",
//             renderer: xRenderer,
//             tooltip: am5.Tooltip.new(root, {})
//         }));

//         xRenderer.labels.template.setAll({
//             rotation: -45,
//             centerY: am5.p50,
//             centerX: 0
//         });

//         var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
//             renderer: am5xy.AxisRendererY.new(root, {})
//         }));

//         var series = chart.series.push(am5xy.ColumnSeries.new(root, {
//             name: title,
//             xAxis: xAxis,
//             yAxis: yAxis,
//             valueYField: "value",
//             sequencedInterpolation: true,
//             categoryXField: "category",
//             tooltip: am5.Tooltip.new(root, {
//                 labelText: "{valueY}"
//             })
//         }));

//         series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5 });
//         series.columns.template.adapters.add("fill", function(fill, target) {
//             return chart.get("colors").getIndex(series.columns.indexOf(target));
//         });

//         series.columns.template.adapters.add("stroke", function(stroke, target) {
//             return chart.get("colors").getIndex(series.columns.indexOf(target));
//         });

//         xAxis.data.setAll(data);
//         series.data.setAll(data);

//         var legend = chart.children.push(am5.Legend.new(root, {
//             centerX: am5.percent(50),
//             x: am5.percent(50),
//             layout: root.horizontalLayout
//         }));

//         legend.data.setAll(series.dataItems);
//         legend.labels.template.setAll({
//             text: "{categoryX}: {valueY}"
//         });

//         series.appear(1000);
//         chart.appear(1000, 100);
//     });
// }

// // Function to create a curved column chart
// function createCurvedColumnChart(divId, data, title) {
//     am5.ready(function() {
//         console.log(`Creating curved column chart in ${divId} with data:`, data); // Log the data for each chart
//         var root = am5.Root.new(divId);

//         root.setThemes([
//             am5themes_Animated.new(root)
//         ]);

//         var chart = root.container.children.push(am5xy.XYChart.new(root, {
//             panX: true,
//             panY: true,
//             wheelX: "panX",
//             wheelY: "zoomX",
//             pinchZoomX: true
//         }));

//         var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
//         cursor.lineY.set("visible", false);

//         var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
//         var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
//             maxDeviation: 0.3,
//             categoryField: "category",
//             renderer: xRenderer,
//             tooltip: am5.Tooltip.new(root, {})
//         }));

//         xRenderer.labels.template.setAll({
//             rotation: -45,
//             centerY: am5.p50,
//             centerX: 0
//         });

//         var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
//             renderer: am5xy.AxisRendererY.new(root, {})
//         }));

//         var series = chart.series.push(am5xy.ColumnSeries.new(root, {
//             name: title,
//             xAxis: xAxis,
//             yAxis: yAxis,
//             valueYField: "value",
//             sequencedInterpolation: true,
//             categoryXField: "category",
//             tooltip: am5.Tooltip.new(root, {
//                 labelText: "{valueY}"
//             })
//         }));

//         series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5, radius: 10 });
//         series.columns.template.adapters.add("fill", function(fill, target) {
//             return chart.get("colors").getIndex(series.columns.indexOf(target));
//         });

//         series.columns.template.adapters.add("stroke", function(stroke, target) {
//             return chart.get("colors").getIndex(series.columns.indexOf(target));
//         });

//         xAxis.data.setAll(data);
//         series.data.setAll(data);

//         var legend = chart.children.push(am5.Legend.new(root, {
//             centerX: am5.percent(50),
//             x: am5.percent(50),
//             layout: root.horizontalLayout
//         }));

//         legend.data.setAll(series.dataItems);
//         legend.labels.template.setAll({
//             text: "{categoryX}: {valueY}"
//         });

//         series.appear(1000);
//         chart.appear(1000, 100);
//     });
// }

// // Fetch data and create charts when the page loads
// window.onload = async function() {
//     const data = await fetchData();
//     if (data) {
//         createCharts(data);
//     }
// }