function showVASummary() {
    if($.fn.DataTable.isDataTable( '#va_summary_table' ))
        return;
    
    initVASummaryTable().then(data => {
        var dt = $('#va_summary_table').DataTable({
            // ajax:"views/task_service_log/data.json",
            data: data.dataSrc.data,
            language: {
                aria: { sortAscending: ": activate to sort column ascending", sortDescending: ": activate to sort column descending" },
                emptyTable: "No data available",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "No records found",
                infoFiltered: `<i>(filtered from _MAX_ records)</i>`, 
                lengthMenu: "Show _MENU_",
                search: "Search:",
                zeroRecords: "No records to show",
                paginate: { previous: "Prev", next: "Next", last: "Last", first: "First" },
            },
            autoWidth: false,
            bStateSave: true,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All'],
            ],
            pageLength: 10,
            pagingType: "bootstrap_full_number",
            columnDefs: [
                ...data.columnDefs,
                { orderable: true, targets: '0' }, { searchable: true, targets: 0 }, 
                { targets: [0], className: "w-200" }
            ],
            order: [[0, "asc"]],
            buttons: [
                { extend: 'csv', className: 'btn purple btn-outline ' },
                { extend: 'excel', className: 'btn yellow btn-outline ' }
            ]
        });

        // dt.on( 'stateLoaded.dt', function (e, settings, data) {
        //     dt.columns.adjust().draw();
        // });

        // export buttons (csv, excel)
        $('#vasummary_table_actions a.tool-action').on('click', function() {
            var action = $(this).attr('data-action') || null;
            if(action)
                dt.DataTable().button(action).trigger();
        });

                
        $('#va_summary_table').DataTable().on( 'draw', function () {
            evaluateTable();
        } );

        $('#va_summary_table tbody').on( 'click', 'tr', function () {
            const fd = new FormData();
            
            fd.append('method', 'fetchVAServicesLogs');
            fd.append('vaInfo', dt.DataTable().row(this).data().user_id);
            fetch('task_service_log/private/functions.php', {
                method: 'POST',
                body: fd
            }).then(res => {
                return res.json();
            }).then(va_servicelogs => {

                // to avoid multiple initialization error from double/multiple clicks of the user
                if($.fn.DataTable.isDataTable( '#VAServiceLogsViewDatatable' ))
                    return; 
            
                // create new datatable instance 
                // to display the selected VA's service logs data
                var vaview = $('#VAServiceLogsViewDatatable').dataTable({
                    data: va_servicelogs.data,
                    language: {
                        aria: { sortAscending: ": activate to sort column ascending", sortDescending: ": activate to sort column descending" },
                        emptyTable: "No data available",
                        info: "Showing _START_ to _END_ of _TOTAL_ records",
                        infoEmpty: "No records found",
                        infoFiltered: `<i>(filtered from _MAX_ records)</i>`,
                        lengthMenu: "Show _MENU_",
                        search: "Search:",
                        zeroRecords: "No records to show",
                        paginate: { previous: "Prev", next: "Next", last: "Last", first: "First" },
                    },
                    autoWidth: false,
                    bStateSave: true,
                    lengthMenu: [
                        [5, 10, 25, -1],
                        [5, 10, 25, 'All'],
                    ],
                    pageLength: 5,
                    pagingType: "bootstrap_full_number",
                    columnDefs: [
                        // Please replace "id" (line 154) to "task_id" or to the new column name version 
                        { data: 'task_id', title: 'Task ID', targets: 0},
                        { data: 'description', title: 'Description', targets: 1},
                        { data: 'action', title: 'Action', targets: 2},
                        { data: 'comment', title: 'Comment', targets: 3},
                        { data: 'account', title: 'Account', targets: 4},
                        { data: 'task_date', title: 'Date', targets: 5},
                        { data: 'minute', title: 'Time', targets: 6},
                        { data: 'reasons', title: 'Reasons', targets: 7},
                        { orderable: true, targets: '_all' }, { searchable: true, targets: '_all' }, { className: "dt-right" }
                    ],
                    order: [[0, "asc"]],
                    buttons: [
                        {
                            extend: 'csv',
                            filename: function() {
                                return `${va_servicelogs.info.name.ref()} - Services Logs ${va_servicelogs.info.dates.replaceAll('-', '').replace(' to ', '-')}`;
                            }
                        }
                    ]
                });

                $('#VAServiceLogsViewModal').find('.VAInfoDisplay').html(`
                <h4 style="margin: 0;">Task Owner: <span style="font-weight: 600;">${dt.DataTable().row(this).data().name}</span></h4>
                <h5 style="margin: .7rem 0 0 0;">Date Rendered: <span style="font-weight: 500;">${va_servicelogs.info.dates}</span></h5>
                <h5 style="margin: .7rem 0 0 0;">Total Tasks: <span style="font-weight: 500;">${va_servicelogs.data.length}</span></h5>`);
                
                $('#VAServiceLogsViewModal').modal('show');

                // export logs as csv file
                $('#VAServiceLogsViewModal .downloadLogs').on('click', function() {
                        vaview.DataTable().button(0).trigger();
                });
            })
        } );

    });
}


// during the va summary datatable initialization
$('#va_summary_table').on('init.dt', function() {
    evaluateTable();
})

// datatable instance on modal hide
$('#VAServiceLogsViewModal').on('hidden.bs.modal', function() {
    $('#VAServiceLogsViewDatatable').DataTable().destroy();
    $('#VAServiceLogsViewDatatable').html('');
    
    // remove click event
    $('#VAServiceLogsViewModal .downloadLogs').off('click');

    console.log('Service log view datatable has been destroyed through modal on-hide!');
});

// closing view modal through close button
$('#VAServiceLogsViewModal').find('button.closeModal').on('click', function() {
    $('#VAServiceLogsViewModal').modal('close');
})

// reformat strings
String.prototype.ref = function() {
    return this.replaceAll(/\s+/g, ' ').replaceAll(/^\s+|\s+$/g, '').toUpperCase();
}

// return hours and its percentage minute (e.g. 90 minutes = 1.50)
function toHours(minutes) {
    if(minutes == -1){
        return 'PTO';
    }
    else if(minutes == -5){
        return 'LWOP';
    }
    else if(minutes == -2){
        return 'SL';
    }
    else if(minutes == -3){
        return 'VL';
    }
    else if(minutes == -4){
        let hours = Math.floor(minutes / 60);
        if(hours.toString().length===1){
        	hours = '0' + hours;
        }
        
        let min = Math.round((minutes % 60));
        if(min.toString().length===1){
        	min = '0' + min;
        }
        return `${hours}:${min}/HD`;
    }
    else if(minutes == -8){
        return 'HD';
    }
    else if(minutes == -6){
        return 'EL';
    }
    else{
        // const hasDecimal = ((minutes % 60) / 60).toFixed(2) > 0.01;
        // return (hasDecimal ?  ((minutes / 60) + ((minutes % 60) / 60)).toFixed(2) : (minutes / 60));
        
        let hours = Math.floor(minutes / 60);
        if(hours.toString().length===1){
        	hours = '0' + hours;
        }
        
        let min = Math.round((minutes % 60));
        if(min.toString().length===1){
        	min = '0' + min;
        }
        
        return `${hours}:${min}`;
    }
}
eval
// reconstructing data for datatable use
async function initVASummaryTable() {
    const data = await VASummary();
    const va_summary = []; 
    const names = [];
    const dateColumns = [];
    
    data.forEach((log, index) => {
        const lastPos = names.indexOf(log.name.ref()) == -1 ? null : names.indexOf(log.name.ref());
        
        if(dateColumns.indexOf(log.task_date) == -1) {
            dateColumns.push(log.task_date);
        }
        
        // VA name do not exists yet=
        if(lastPos === null) {
            names.push(log.name.ref());
            
            // create new
            const va_object = { 
                name: log.name,
                user_id: log.user_id,
                type: log.type  // Add this line
            };
            va_object[log.task_date] = toHours(log.total_minutes);
            
            va_summary.push(va_object);
        }
        else {
            // append task_date as new key and its total minutes
            va_summary[lastPos][log.task_date] = toHours(log.total_minutes);
        }
    
    });
    
    // reconstruct value 
    return {
    dataSrc: { data: va_summary },
    columnDefs: [
        {
            data: 'name',
            title: 'Name',
            targets: 0,
        },
        {
            data: 'user_id',
            title: 'User ID#',
            targets: 1,
            className: 'hide'
        },
        {
            data: 'type',
            title: 'Type',
            targets: 2,
            className: 'hide'  // Hide this column since it's only for logic purposes
        },
        ...dateColumns.map((xcol, ind) => {
            return {
                data: xcol,
                title: xcol,
                targets: ind + 3,  // Changed from ind + 2 to ind + 3
                defaultContent: ""
            };
        })
    ]
};
}

// asynchronous function to fetch the VA Summary data from the database
async function VASummary() {
    // try {
    //     const response = await fetch('task_service_log/private/functions.php?method=getVASummary');
    //     console.log(response);
    // } catch(err) {
    //     console.error(err);
    // }
    
    
    try {
        const response = await fetch('task_service_log/private/functions.php?method=getVASummary');
        const data = await response.json();
        return data;
    } catch (err) {
        console.error(err);
    }
}

function evaluateTable() {
    const va_summaryTable = document.getElementById('va_summary_table');
    const dataTable = $('#va_summary_table').DataTable();

    /* ================================
       CELL VALUE EVALUATION (GREEN / RED)
    ================================= */
    va_summaryTable.querySelectorAll('tbody tr').forEach(row => {
        const rowData = dataTable.row(row).data();
        if (!rowData) return;

        const type = parseInt(rowData.type);

        row.querySelectorAll('td:nth-child(n+4)').forEach(cell => {
            const cellText = cell.innerText.trim();
            let cellValue;

            if (cellText.length > 0) {
                if (cellText.includes(':')) {
                    const [hours, minutes] = cellText.split(':').map(Number);
                    cellValue = hours + (minutes / 60);
                } else {
                    cellValue = parseFloat(cellText);
                }
            }

            cell.classList.remove('font-green-jungle', 'text-bold', 'font-red');

            if (cellValue !== undefined && !isNaN(cellValue)) {
                if (type === 1 && cellValue >= 8) {
                    cell.classList.add('font-green-jungle', 'text-bold');
                } else if (type !== 1 && cellValue >= 4) {
                    cell.classList.add('font-green-jungle', 'text-bold');
                } else {
                    cell.classList.add('font-red');
                }
            }
        });
    });

    /* ================================
       WEEKEND COLUMN HIGHLIGHTING
    ================================= */
    va_summaryTable.querySelectorAll('thead tr th').forEach((th, index) => {
        // Name column
        if (index === 0) {
            th.style.backgroundColor = '#2b3b55';
            th.style.color = 'white';
            return;
        }

        const dateText = th.innerText.trim();
        const date = new Date(dateText);

        // Guard against invalid dates
        const isValidDate = !isNaN(date.getTime());

        // Use UTC to avoid timezone shifting issues
        const isWeekend =
            isValidDate &&
            (date.getUTCDay() === 0 || date.getUTCDay() === 6);

        const columnNumber = index + 1;

        console.log(
            'Date:', dateText,
            'Valid:', isValidDate,
            'Weekend:', isWeekend,
            'Column:', columnNumber
        );

        if (isWeekend) {
            // Header styling
            th.style.backgroundColor = '#c6613f';
            th.style.color = 'white';

            // Column cells styling
            va_summaryTable
                .querySelectorAll(`tbody tr td:nth-child(${columnNumber})`)
                .forEach(cell => {
                    cell.style.backgroundColor = '#d3d3d3';
                });
        } else {
            // Reset non-weekend columns
            th.style.backgroundColor = '#2b3b55';
            th.style.color = 'white';

            va_summaryTable
                .querySelectorAll(`tbody tr td:nth-child(${columnNumber})`)
                .forEach(cell => {
                    cell.style.backgroundColor = '';
                    cell.style.color = '';
                });
        }
    });
}


$('a[href="#VA_SUMMARY"]').on('click', function() {
    showVASummary();
})

$('.nav-tabs [data-toggle=tab]').on('click', function() {
    // destroy datatable on tab close 
    if($(this).attr('href') != "#VA_SUMMARY" && $.fn.DataTable.isDataTable( '#va_summary_table' )) {
        $('#va_summary_table').DataTable().destroy();
        $('#va_summary_table').html('');
    }
});