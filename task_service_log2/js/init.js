function initServiceLogs() {
    const serviceLogs = {
        datatable: Init.dataTable('#service_logs_table', {
            columnDefs: [
                {
                    targets: [1],
                    visible: false,
                }, 
                {
                    className: 'text-center',
                    targets: [0,3,5,6,7]
                }
            ],
            columns: [
                {width: '120px'},
                {width: '13rem'},
                null,
                {width: '10rem'},
                null,
                {width: '12rem'},
                {width: '10rem'},
                {width: '58px'},
            ]
        }),
        update: function(data) {
            const {dt} = this.datatable;
            dt.clear().draw();
            data.forEach((d) => {
                dt.row.add([
                    d.task_id,
                    d.name || '',
                    d.description,
                    d.action,
                    d.comment, 
                    d.account,
                    d.task_date,
                    d.minute
                ]);
            });
            dt.draw();
        },
        fetch: function(callback = null) {
            const sl = this;
            $.ajax({
                url: Init.baseUrl + "logs",
                type: "GET",
                contentType: false,
                processData: false,
                success: function({data}) {
                    sl.update(data);
                },
                error: function() {
                    bootstrapGrowl('Error fetching service logs!');
                },
                complete: () => {
                    callback && callback();
                }
            });
        },
        add: function (d) {
            const {dt} = this.datatable;
            dt.row.add([
                d.task_id,
                d.name || '',
                d.description,
                d.action,
                d.comment, 
                d.account,
                d.task_date,
                d.minute
            ]).draw();

            // Reorder the table to place the new row at the top
            dt.order([0, 'desc']).draw();   
        }
    }

    // transer buttons to datatable toolbar
    $('#service_logs_table_wrapper .dt-buttons').append($('#refreshServiceLogsTableBtn').attr('class', 'dt-button buttons-collection').show());
    $('#service_logs_table_wrapper .dt-buttons').append($('#addNewTaskBtn').attr('class', 'dt-button buttons-collection').show());

    serviceLogs.fetch();

    return serviceLogs;
}

function initForApprovalLogs() {
    const init = {
        datatable: Init.dataTable('#for_approval_logs_table', {
            columnDefs: [
                {
                    targets: [1],
                    visible: false,
                }, 
                {
                    className: 'text-center',
                    targets: [0,1,4,6,7,8]
                },
                {
                    sortable: false,
                    targets: [0]
                }
            ],
        }),
    };

    return init;
}

function initVASummaryTable() {
    const init = {
        datatable: Init.dataTable('#vasummary_table', {
            columnDefs: [
                {
                    targets: [0,1,2,3],
                    className: 'text-center',
                }, 
                // {
                //     className: 'text-center',
                //     targets: [0,1,4,6,7,8]
                // },
                {
                    sortable: false,
                    targets: [0]
                }
            ],
        }),
        fetch(callback = null) {
            const self = this;
            $.ajax({
                url: Init.baseUrl + "va_summary",
                type: "GET",
                contentType: false,
                processData: false,
                success: function({data}) {
                    self.update(data);
                },
                error: function() {
                    bootstrapGrowl('Error fetching data!');
                },
                complete: () => {
                    callback && callback();
                }
            });
        },
        update(data) {
            const {dt} = this.datatable;
            dt.clear().draw();
            data.forEach((d) => {
                dt.row.add([
                    d.date,
                    // `<strong>${d.date}</strong>`,
                    evaluateTotalRenderedHours(d.minutes),
                    evaluateOvertimeHours(d.minutes, d.overtime),
                    `<strong>${d.tasks}</strong>`,
                ]);
            });
            dt.draw();
        },
    };

    function evaluateTotalRenderedHours(minutes) {
        let hours = Math.floor(minutes / 60);
        let mins = minutes % 60;
        
        if (minutes < 0) {
            return `<strong class="font-red">&lt;0</strong>`;
        }
        
        return `<strong>${hours}:${mins.toString().padStart(2, '0')}</strong>`;
    }

    function evaluateOvertimeHours(total, overtime) {
        if (overtime == 0 && total <= 480) {
            return `<strong>0</strong>`;
        }

        let overtimeHours = Math.floor(overtime / 60);
        let overtimeMinutes = overtime % 60;

        if(overtime && total > 480) {
            return `<strong class="font-red" title="Pending for approval">${overtimeHours}:${overtimeMinutes.toString().padStart(2, '0')}</strong>`;
        }
        
        return `<strong class="font-red" title="Pending for approval">${overtimeHours}:${overtimeMinutes.toString().padStart(2, '0')}</strong>`;
    }

    init.fetch();
    return init;
}