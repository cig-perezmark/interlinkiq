const monthsInWords = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

jQuery(document).ready(function () {
    createEARChart();
    createSUChart();
    createMGRBarChart();
});


function selectUser(e) {
    console.log(e.value);
}

function formatSize(bytes) {
    if (bytes >= 1073741824) {
        bytes = bytes / 1073741824;
    } else if (bytes >= 1048576) {
        bytes = bytes / 1048576;
    } else if (bytes >= 1024) {
        bytes = bytes / 1024;
    } else if (bytes > 1) {
        bytes = bytes;
    } else if (bytes == 1) {
        bytes = bytes;
    } else {
        bytes = 0;
    }

    return bytes.toFixed(2);
} 
function formatSizeUnits(bytes) {
    if (bytes >= 1073741824) {
        bytes = 'GB';
    } else if (bytes >= 1048576) {
        bytes = 'MB';
    } else if (bytes >= 1024) {
        bytes = 'KB';
    } else if (bytes > 1) {
        bytes = 'bytes';
    } else if (bytes == 1) {
        bytes = 'byte';
    } else {
        bytes = 'bytes';
    }

    return bytes;
}

function createEARChart() {
    const totalAccounts = Object.values(dfdc.account)
        .reduce((acc, cv) => acc + cv, 0)
        .toLocaleString();
    $("#ear_donut").highcharts({
        chart: {
            type: "pie",
            style: {
                fontFamily: "Open Sans",
            },
        },
        title: null,
        subtitle: {
            useHTML: true,
            text: `<span style="font-size: 4rem; font-weight:bold;">${totalAccounts}</span>`,
            verticalAlign: "middle",
            y: -20,
        },
        plotOptions: {
            pie: {
                borderWidth: 0,
                colorByPoint: true,
                type: "pie",
                size: "100%",
                innerSize: "50%",
                dataLabels: {
                    enabled: true,
                    crop: false,
                    distance: "-10%",
                    style: {
                        fontWeight: "normal",
                        fontSize: "10px",
                    },
                    connectorWidth: 0,
                },
                showInLegend: false,
            },
        },
        series: [
            {
                name: "Total",
                data: [
                    {
                        name: "Subscriber",
                        y: dfdc.account.paid,
                        color: "#389848",
                    },
                    {
                        name: "Demo Account",
                        y: dfdc.account.demo,
                        color: "#00CCCC",
                    },
                    {
                        name: "Free Access",
                        y: dfdc.account.free,
                        color: "#E4DC11",
                    },
                ],
                size: "100%",
                dataLabels: {
                    formatter: function () {
                        console.log(this.point);
                        return this.y >= 5 ? this.point.percentage.toFixed(2) + "%" : null;
                    },
                    color: "#ffffff",
                    distance: -30,
                },
            },
        ],
    });
}

function createSUChart() {
    const totalStorageUsed = Object.values(dfdc.storage)
        .reduce((acc, cv) => acc + cv, 0)
        .toLocaleString();

    var total_storage = totalStorageUsed;
    total_storage = total_storage.replace(/\,/g,''); // 1125, but a string, so convert it to number
    total_storage = parseInt(total_storage, 10);

    $("#su_donut").highcharts({
        chart: {
            type: "pie",
            style: {
                fontFamily: "Open Sans",
            },
        },
        title: null,
        subtitle: {
            useHTML: true,
            text: `<span style="font-size: 2rem; font-weight:bold; display:flex; flex-direction:column; align-items:center;justify-content:center;">
                        <span>${formatSize(total_storage)}</span>
                        <span>${formatSizeUnits(total_storage)}</span>
                    </span>`,
            verticalAlign: "middle",
            y: -10,
        },
        plotOptions: {
            pie: {
                borderWidth: 0,
                colorByPoint: true,
                type: "pie",
                size: "100%",
                innerSize: "50%",
                dataLabels: {
                    enabled: true,
                    crop: false,
                    distance: "-10%",
                    style: {
                        fontWeight: "normal",
                        fontSize: "10px",
                    },
                    connectorWidth: 0,
                },
                showInLegend: false,
            },
        },
        tooltip: {
            headerFormat: '',
            pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
              'Total: <b>{point.y} {point.z}</b>'
        },
        series: [
            {
                name: "Total",
                data: [
                    {
                        name: "Subscriber",
                        y: parseFloat(formatSize(dfdc.storage.paid)),
                        z: formatSizeUnits(dfdc.storage.paid),
                        color: "#389848",
                    },
                    {
                        name: "Demo Account",
                        y: parseFloat(formatSize(dfdc.storage.demo)),
                        z: formatSizeUnits(dfdc.storage.demo),
                        color: "#00CCCC",
                    },
                    {
                        name: "Free Access",
                        y: parseFloat(formatSize(dfdc.storage.free)),
                        z: formatSizeUnits(dfdc.storage.free),
                        color: "#E4DC11",
                    },
                ],
                size: "100%",
                dataLabels: {
                    formatter: function () {
                        console.log(this.point);
                        return this.y > 5 ? this.point.percentage.toFixed(2) + "%" : null;
                    },
                    color: "#ffffff",
                    distance: -30,
                },
            },
        ],
    });
}

function createMGRBarChart() {
    $("#mgr_ear").highcharts({
        chart: {
            type: "column",
            style: {
                fontFamily: "Open Sans",
            },
        },
        title: {
            text: "",
        },
        xAxis: {
            categories: monthsInWords,
            crosshair: true,
            accessibility: {
                description: "Countries",
            },
        },
        yAxis: {
            allowDecimals: true,
            min: 0,
            title: {
                text: "Storage Size (MB)",
            },
        },

        tooltip: {
            valueSuffix: "",
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
            },
        },

        series: [
            {
                name: "Subscriber",
                data: monthlyGrowthReport["paid"] || [],
                color: "#389848",
            },
            {
                name: "Demo Account",
                data: monthlyGrowthReport["demo"] || [],
                color: "#00CCCC",
            },
            {
                name: "Free Access",
                data: monthlyGrowthReport["free"] || [],
                color: "#E4DC11",
            },
        ],
    });
}
