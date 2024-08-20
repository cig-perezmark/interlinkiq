am5.ready(function() {

    // Create root element
    var root = am5.Root.new("productsChartdiv");

    // Set themes
    root.setThemes([am5themes_Animated.new(root)]);

    // Create chart
    var chart = root.container.children.push(
        am5xy.XYChart.new(root, {
            panX: false, // Disable horizontal panning
            panY: false, // Disable vertical panning
            wheelX: "none", // Disable zooming on X axis
            wheelY: "none", // Disable zooming on Y axis
            paddingLeft: 5,
            paddingRight: 5,
            height: am5.percent(100) // Adjust the height to 80% of the container
        })
    );

    // Add cursor
    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
    cursor.lineY.set("visible", false);

    // Create axes
    var xRenderer = am5xy.AxisRendererX.new(root, { 
        minGridDistance: 60,
        minorGridEnabled: true
    });

    // Set rotation for category labels
    xRenderer.labels.template.setAll({
        rotation: -65,
        centerY: am5.p50, // Adjust label positioning
        centerX: am5.p100, // Align label with category
        paddingTop: 10 // Adjust for better spacing
    });

    var xAxis = chart.xAxes.push(
        am5xy.CategoryAxis.new(root, {
            maxDeviation: 0.3,
            categoryField: "category_name",
            renderer: xRenderer,
            tooltip: am5.Tooltip.new(root, {})
        })
    );

    xRenderer.grid.template.setAll({
        location: 1
    });

    var yAxis = chart.yAxes.push(
        am5xy.ValueAxis.new(root, {
            maxDeviation: 0.3,
            renderer: am5xy.AxisRendererY.new(root, {
                strokeOpacity: 0.1
            })
        })
    );

    // Create series
    var series = chart.series.push(
        am5xy.ColumnSeries.new(root, {
            name: "Total Products",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "total_products",
            sequencedInterpolation: true,
            categoryXField: "category_name"
        })
    );

    series.columns.template.setAll({
        width: am5.percent(120),
        fillOpacity: 0.9,
        strokeOpacity: 0
    });

    // Customize column shapes
    series.columns.template.set("draw", function(display, target) {
        var w = target.getPrivate("width", 0);
        var h = target.getPrivate("height", 0);
        display.moveTo(0, h);
        display.bezierCurveTo(w / 4, h, w / 4, 0, w / 2, 0);
        display.bezierCurveTo(w - w / 4, 0, w - w / 4, h, w, h);
    });

    // Add label bullets to display the count
    series.bullets.push(function() {
        return am5.Bullet.new(root, {
            locationY: 1,
            sprite: am5.Label.new(root, {
                text: "{valueY}",
                fill: am5.color(0x000000), // Black color for labels
                centerY: am5.p50,
                centerX: am5.p50,
                populateText: true,
                dy: -10 // Adjust to move the label above the bar
            })
        });
    });

    // Define a color palette and color mapping
    var colorPalette = am5.ColorSet.new(root, {});
    var colorMapping = {
        "Total Products": am5.color(0x21ccbb) // Light blue color for 'Total Products'
    };

    // Add color adapters
    series.columns.template.adapters.add("fill", (fill, target) => {
        let categoryName = target.dataItem.dataContext.category_name;
        if (categoryName === "Total") {
            categoryName = "Total Products"; // Rename "Total" to "Total Products"
        }
        if (!colorMapping[categoryName]) {
            colorMapping[categoryName] = colorPalette.next();
        }
        return colorMapping[categoryName];
    });

    series.columns.template.adapters.add("stroke", (stroke, target) => {
        let categoryName = target.dataItem.dataContext.category_name;
        if (categoryName === "Total") {
            categoryName = "Total Products"; // Rename "Total" to "Total Products"
        }
        if (!colorMapping[categoryName]) {
            colorMapping[categoryName] = colorPalette.next();
        }
        return colorMapping[categoryName];
    });

    // Fetch data and set to chart
    fetch('AnalyticsIQ/products_fetch_data.php') // Adjust the path to your PHP file
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(item => {
                    item.total_products = Number(item.total_products); // Convert total_products to number
                    if (item.category_name === "Total") {
                        item.category_name = "Total Products"; // Rename "Total" to "Total Products"
                    }
                });
                xAxis.data.setAll(data);
                series.data.setAll(data);
            } else {
                console.error('Data format is incorrect or empty');
            }
        })
        .catch(error => console.error('Error loading data:', error));

    // Animate on load
    series.appear(1000);
    chart.appear(1000, 100);

}); // end am5.ready()
