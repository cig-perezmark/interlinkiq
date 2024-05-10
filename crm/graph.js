    am5.ready(function() {
        // First Graph - Pie Chart
        var root1 = am5.Root.new("chartdiv1");
        root1.setThemes([
            am5themes_Animated.new(root1)
        ]);
    
        var chart1 = root1.container.children.push(am5percent.PieChart.new(root1, {
            layout: root1.verticalLayout
        }));
    
        // Define Pie Series 1
        var series1 = chart1.series.push(
            am5percent.PieSeries.new(root1, {
                categoryField: "category",
                valueField: "value",
                legendLabelText: "[{fill}]{category}[/]",
                alignLabels: true,
                legendValueText: "[bold][/]"
            })
        );
    
        series1.slices.template.setAll({
            strokeWidth: 0.2,
            stroke: am5.color(0xffffff)
        });
    
        series1.labels.template.setAll({
            centerX: 0,
            centerY: 35,
            text: "[{fill}]{category}[/] : \n[bold]{value}[/] Uploaded Contacts"
        });
    
        // Legend for Pie Chart 1
        var legend1 = chart1.children.push(am5.Legend.new(root1, {
            centerX: am5.percent(50),
            x: am5.percent(50),
            marginTop: 15,
            marginBottom: 15
        }));
        legend1.data.setAll(series1.dataItems);
        legend1.markerRectangles.template.setAll({
            cornerRadiusTL: 5,
            cornerRadiusTR: 5,
            cornerRadiusBL: 5,
            cornerRadiusBR: 5
        });
    
        // Second Graph - Pie Chart
        var root2 = am5.Root.new("chartdiv2");
        root2.setThemes([
            am5themes_Animated.new(root2)
        ]);
    
        var chart2 = root2.container.children.push(am5percent.PieChart.new(root2, {
            layout: root2.verticalLayout
        }));
    
        var series2 = chart2.series.push(
            am5percent.PieSeries.new(root2, {
                categoryField: "category",
                valueField: "value",
                legendLabelText: "[{fill}]{category}[/]",
                alignLabels: true,
                legendValueText: "[bold][/]"
            })
        );
    
        series2.slices.template.setAll({
            strokeWidth: 0.2,
            stroke: am5.color(0xffffff)
        });
    
        series2.labels.template.setAll({
            centerX: 0,
            centerY: 35,
            text: "[{fill}]{category}[/] : \n[bold]{value}[/] Campaign Sent"
        });
    
        // Legend for Pie Chart 2
        var legend2 = chart2.children.push(am5.Legend.new(root2, {
            centerX: am5.percent(50),
            x: am5.percent(50),
            marginTop: 15,
            marginBottom: 15
        }));
        legend2.data.setAll(series2.dataItems);
        legend2.markerRectangles.template.setAll({
            cornerRadiusTL: 5,
            cornerRadiusTR: 5,
            cornerRadiusBL: 5,
            cornerRadiusBR: 5
        });
    
        // Fetch data function
        function fetchData() {
            $.ajax({
                url: 'crm/controller_functions.php',
                type: 'POST',
                data: { get_graphs: true },
                success: function(response) {
                    var data = JSON.parse(response);

                    console.log(data.contact)
                    console.log(data.campaign)
                    console.log(data.user_daily_campaign)
    
                    var contactSeries = chart1.series.getIndex(0);
                    contactSeries.data.setAll(data.contact);
    
                    var campaignSeries = chart2.series.getIndex(0);
                    campaignSeries.data.setAll(data.campaign);
    
                    var series3 = chart3.series.getIndex(0);
                    series3.data.setAll(data.daily_campaign);
                    
                    var series4 = chart4.series.getIndex(0);
                    series4.data.setAll(data.user_daily_campaign);
    
                    legend1.data.setAll(series1.dataItems);
                    legend2.data.setAll(series2.dataItems);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }
    
        fetchData();
    
         // Third Graph - XY Chart
        var root3 = am5.Root.new("chartdiv3");
        const myTheme = am5.Theme.new(root3);
    
        myTheme.rule("AxisLabel", ["minor"]).setAll({
            dy:1
        });
    
        myTheme.rule("AxisLabel").setAll({
            fontSize:"0.9em"
        });
    
        root3.setThemes([
            am5themes_Animated.new(root3),
            myTheme,
            am5themes_Responsive.new(root3)
        ]);
    
        var chart3 = root3.container.children.push(am5xy.XYChart.new(root3, {
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX: true,
            paddingLeft: 0,
            scrollable: true, // Enable scrolling
            focusable: true,
            panX: true,
            panY: true
        }));
    
        var cursor = chart3.set("cursor", am5xy.XYCursor.new(root3, {
            behavior: "none"
        }));
        cursor.lineY.set("visible", false);
    
        var xAxis = chart3.xAxes.push(am5xy.DateAxis.new(root3, {
            maxDeviation: 0.2,
            baseInterval: {
                timeUnit: "day",
                count: 1
            },
            renderer: am5xy.AxisRendererX.new(root3, {
                minorGridEnabled: false,
                minorLabelsEnabled: false
            }),
            tooltip: am5.Tooltip.new(root3, {})
        }));
    
        xAxis.set("minorDateFormats", {
            "day":"dd",
            "month":"MMM"
        });
    
        var yAxis = chart3.yAxes.push(am5xy.ValueAxis.new(root3, {
            renderer: am5xy.AxisRendererY.new(root3, {
                pan: "zoom"
            })
        }));
    
        var series3 = chart3.series.push(am5xy.LineSeries.new(root3, {
            name: "Series",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value",
            valueXField: "date",
            tooltip: am5.Tooltip.new(root3, {
                labelText: "Campaign sent: {valueY}"
            })
        }));
        
        series3.bullets.push(function () {
          var bulletCircle = am5.Circle.new(root3, {
            radius: 5,
            fill: series3.get("fill")
          });
          return am5.Bullet.new(root3, {
            sprite: bulletCircle
          })
        })
    
        series3.appear(1000);
        chart3.appear(1000, 100);
        
        // 
        
        var root4 = am5.Root.new("chartdiv4");
        const myTheme2 = am5.Theme.new(root4);
    
        myTheme2.rule("AxisLabel", ["minor"]).setAll({
            dy:1
        });
    
        myTheme2.rule("AxisLabel").setAll({
            fontSize:"0.9em"
        });
    
        root4.setThemes([
            am5themes_Animated.new(root4),
            myTheme2,
            am5themes_Responsive.new(root4)
        ]);
    
        var chart4 = root4.container.children.push(am5xy.XYChart.new(root4, {
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX: true,
            paddingLeft: 0,
            scrollable: true, // Enable scrolling
            focusable: true,
            panX: true,
            panY: true
        }));
    
        var cursor = chart4.set("cursor", am5xy.XYCursor.new(root4, {
            behavior: "none"
        }));
        cursor.lineY.set("visible", false);
    
        var xAxis = chart4.xAxes.push(am5xy.DateAxis.new(root4, {
            maxDeviation: 0.2,
            baseInterval: {
                timeUnit: "day",
                count: 1
            },
            renderer: am5xy.AxisRendererX.new(root4, {
                minorGridEnabled: false,
                minorLabelsEnabled: false
            }),
            tooltip: am5.Tooltip.new(root4, {})
        }));
    
        xAxis.set("minorDateFormats", {
            "day":"dd",
            "month":"MMM"
        });
    
        var yAxis = chart4.yAxes.push(am5xy.ValueAxis.new(root4, {
            renderer: am5xy.AxisRendererY.new(root4, {
                pan: "zoom"
            })
        }));
    
        var series4 = chart4.series.push(am5xy.LineSeries.new(root4, {
            name: "Series",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value",
            valueXField: "date",
            tooltip: am5.Tooltip.new(root4, {
                labelText: "Campaign sent: {valueY}"
            })
        }));
        
        series4.bullets.push(function () {
          var bulletCircle = am5.Circle.new(root4, {
            radius: 5,
            fill: series4.get("fill")
          });
          return am5.Bullet.new(root4, {
            sprite: bulletCircle
          })
        })
    
        series4.appear(1000);
        chart4.appear(1000, 100);
        
    });