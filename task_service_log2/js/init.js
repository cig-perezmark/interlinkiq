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