<script>
function checkAll() {
    // Get the checkbox that represents "Check All"
    var checkAllCheckbox = document.getElementById("checkAll");

    // Get all checkboxes with the class "checkbox-item"
    var checkboxes = document.getElementsByClassName("update_scope");

    // Loop through each checkbox and set its checked property
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = checkAllCheckbox.checked;
    }
}
var TableDatatablesRowreorderTimeIn = function() {
    var initTable1 = function() {
        var table = $('#timein_ft');

        var oTable = table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "_MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found"
            },

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            // setup buttons extentension: http://datatables.net/extensions/buttons/
            buttons: [{
                    extend: 'print',
                    className: 'btn default'
                },
                {
                    extend: 'pdf',
                    className: 'btn red'
                },
                {
                    extend: 'csv',
                    className: 'btn green '
                }
            ],

            // setup rowreorder extension: http://datatables.net/extensions/rowreorder/
            // rowReorder: {

            // },

            "order": [
                [0, 'asc']
            ],

            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });
    }

    var initTable2 = function() {
        var table = $('#timein_fl');

        var oTable = table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "_MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found"
            },

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            buttons: [{
                    extend: 'print',
                    className: 'btn default'
                },
                {
                    extend: 'pdf',
                    className: 'btn red'
                },
                {
                    extend: 'csv',
                    className: 'btn green '
                }
            ],

            // setup colreorder extension: http://datatables.net/extensions/colreorder/
            // colReorder: {
            //     reorderCallback: function () {
            //         console.log( 'callback' );
            //     }
            // },

            // // setup rowreorder extension: http://datatables.net/extensions/rowreorder/
            // rowReorder: {

            // },

            "order": [
                [0, 'asc']
            ],

            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });
    }

    var initTable3 = function() {
        var table = $('#timein_ojt');

        var oTable = table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "_MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found"
            },

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            // setup buttons extentension: http://datatables.net/extensions/buttons/
            buttons: [{
                    extend: 'print',
                    className: 'btn default'
                },
                {
                    extend: 'pdf',
                    className: 'btn red'
                },
                {
                    extend: 'csv',
                    className: 'btn green '
                }
            ],

            // setup rowreorder extension: http://datatables.net/extensions/rowreorder/
            // rowReorder: {

            // },

            "order": [
                [0, 'asc']
            ],

            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });
    }

    return {

        //main function to initiate the module
        init: function() {

            if (!jQuery().dataTable) {
                return;
            }

            initTable1();
            initTable2();
            initTable3();
        }

    };

}();

jQuery(document).ready(function() {
    TableDatatablesRowreorderTimeIn.init();
});
</script>
<script>
var TableDatatablesManaged = function() {

    var initTable1_2 = function() {

        var table = $('#sample_1_2');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "Show _MENU_",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous": "Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": false, // save datatable state(pagination, sort, etc) in cookie.

            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],

            // set the initial value
            "pageLength": 5,
            "pagingType": "bootstrap_full_number",
            "columnDefs": [{ // set default column settings
                    'orderable': false,
                    'targets': [0]
                },
                {
                    "searchable": false,
                    "targets": [0]
                },
                {
                    "className": "dt-right",
                    //"targets": [2]
                }
            ],

            "order": [
                [1, "asc"]
            ], // set first column as a default sort by asc

            initComplete: function() {

                // username column
                this.api().column(1).every(function() {
                    var column = this;
                    var select = $('<select class="form-control input-sm"><option value="">Select</option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });

            }
        });

        var tableWrapper = jQuery('#sample_1_2_wrapper');

        table.find('.group-checkable').change(function() {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function() {
                if (checked) {
                    $(this).prop("checked", true);
                    $(this).parents('tr').addClass("active");
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
                }
            });
        });

        table.on('change', 'tbody tr .checkboxes', function() {
            $(this).parents('tr').toggleClass("active");
        });
    }

    var initTable2 = function() {

        var table = $('#sample_2');

        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "Show _MENU_",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous": "Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            "pagingType": "bootstrap_extended",

            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 5,
            "columnDefs": [{ // set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#sample_2_wrapper');

        table.find('.group-checkable').change(function() {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function() {
                if (checked) {
                    $(this).prop("checked", true);
                } else {
                    $(this).prop("checked", false);
                }
            });
        });
    }

    var initTable3 = function() {

        var table = $('#sample_3');

        // begin: third table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "Show _MENU_",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous": "Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "lengthMenu": [
                [6, 15, 20, -1],
                [6, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 6,
            "columnDefs": [{ // set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#sample_3_wrapper');

        table.find('.group-checkable').change(function() {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function() {
                if (checked) {
                    $(this).prop("checked", true);
                } else {
                    $(this).prop("checked", false);
                }
            });
        });
    }

    var initTable4 = function() {

        var table = $('#sample_4');

        // begin: third table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "Show _MENU_",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous": "Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },


            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "lengthMenu": [
                [6, 15, 20, -1],
                [6, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 6,
            "columnDefs": [{ // set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#sample_4_wrapper');

        table.find('.group-checkable').change(function() {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function() {
                if (checked) {
                    $(this).prop("checked", true);
                } else {
                    $(this).prop("checked", false);
                }
            });
        });
    }

    var initTable5 = function() {

        var table = $('#sample_5');

        // begin: third table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "Show _MENU_",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous": "Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },

            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total = api
                    .column(3)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(3, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(3).footer()).html(
                    '$' + pageTotal + ' ( $' + total + ' total)'
                );
            },

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "lengthMenu": [
                [6, 15, 20, -1],
                [6, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 6,
            "columnDefs": [{ // set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#sample_5_wrapper');

        table.find('.group-checkable').change(function() {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function() {
                if (checked) {
                    $(this).prop("checked", true);
                } else {
                    $(this).prop("checked", false);
                }
            });
        });
    }

    return {

        //main function to initiate the module
        init: function() {
            if (!jQuery().dataTable) {
                return;
            }

            initTable1_2();
            initTable2();
            initTable3();
            initTable4();
            initTable5();
        }

    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        TableDatatablesManaged.init();
    });
}

$(document).on('click', '#add_status', function() {
    $('#tableData_12').DataTable();
    var ids = $(this).attr('data-id');
    $.ajax({
        type: "GET",
        url: "task_service_log/filter_task.php?GetAI=" + ids,
        dataType: "html",
        success: function(data) {
            $("#modal_update_status .modal-body").html(data);
            $(".modalForm").validate();
            selectMulti();
        }
    });
});

$(document).ready(function() {

    $('.input-daterange').datepicker({
        todayBtn: 'linked',
        format: "yyyy-mm-dd",
        autoclose: true
    });

    $('#search_date1').click(function() {
        var start_date_filter1 = $('#start_date_filter1').val();
        var end_date_filter1 = $('#end_date_filter1').val();
        if (start_date_filter1 != '' && end_date_filter1 != '') {
            $.ajax({
                url: 'task_service_log/filter_task.php',
                method: 'POST',
                data: {
                    start_date_filter1: start_date_filter1,
                    end_date_filter1: end_date_filter1
                },
                success: function(data) {
                    alert(data);
                    $("#filter_data_range").empty();
                    $("#filter_data_range").html(data);
                }
            });
        } else {
            alert("Both Date is Required");
        }
    });

});

$(document).on('click', '#btn_appr_update', function() {

    var scope_update_id = [];

    $('.update_scope:checked').each(function(i) {
        scope_update_id[i] = $(this).val();
    });

    if (scope_update_id.length === 0) //tell you if the array is empty
    {
        alert("Please Select atleast one checkbox");
    } else {
        $.ajax({
            url: 'task_service_log/action_approved.php',
            method: 'POST',
            data: {
                scope_update_id: scope_update_id
            },
            success: function() {
                for (var i = 0; i < scope_update_id.length; i++) {
                    $('tr#scope_' + scope_update_id[i] + '').css('background-color', '#ccc');
                    $('tr#scope_' + scope_update_id[i] + '').fadeOut('slow');
                }
            }
        });
    }
});

$(document).on('click', '#disapprove_btn', function() {
    var task_id = $(this).attr('data-id');
    $('#task_id').val(task_id);
});

$(document).on('click', '#btn_disapprove_update', function() {

    var task_id = $('#task_id').val();
    var comment = $('#comment').val();

    if (comment != '') {
        $.ajax({
            url: 'task_service_log/action_approved.php',
            method: 'POST',
            data: {
                task_id: task_id,
                comment: comment,
                action: "disapprove"

            },
            success: function(response) {
                $('tr#scope_' + task_id).css('background-color', '#ccc');
                $('tr#scope_' + task_id).fadeOut('slow');
            }
        });
    } else {
        alert("Please input comment")
    }
});

$(document).on('click', '#btn_d_update', function() {

    var scope_update_id = [];

    $('.update_scope:checked').each(function(i) {
        scope_update_id[i] = $(this).val();
    });

    if (scope_update_id.length === 0) //tell you if the array is empty
    {
        alert("Please Select atleast one checkbox");
    } else {
        $.ajax({
            url: 'task_service_log/action_approved.php',
            method: 'POST',
            data: {
                scope_update_id: scope_update_id
            },
            success: function() {
                for (var i = 0; i < scope_update_id.length; i++) {
                    $('tr#scope_' + scope_update_id[i] + '').css('background-color', '#ccc');
                    $('tr#scope_' + scope_update_id[i] + '').fadeOut('slow');
                }
            }
        });
    }
});

$(document).on('click', '#btn_send_appr', function() {

    var send_update_id = [];

    $('.send_appr:checked').each(function(i) {
        send_update_id[i] = $(this).val();
    });

    if (send_update_id.length === 0) //tell you if the array is empty
    {
        alert("Please Select atleast one checkbox");
    } else {
        $.ajax({
            url: 'task_service_log/action_approved.php',
            method: 'POST',
            data: {
                send_update_id: send_update_id
            },
            success: function() {
                for (var i = 0; i < send_update_id.length; i++) {
                    $('tr#scope_' + send_update_id[i] + '').css('background-color', '#ccc');
                    $('tr#scope_' + send_update_id[i] + '').fadeOut('slow');
                }
            }
        });
    }
});

$(".modalGet_details_logs").on('submit', (function(e) {
    e.preventDefault();
    //  var details_id = $("#details_id").val();
    formObj = $(this);
    if (!formObj.validate().form()) return false;

    var formData = new FormData(this);
    formData.append('btnSave_reference', true);

    var l = Ladda.create(document.querySelector('#btnSave_reference'));
    l.start();

    $.ajax({
        url: "task_service_log/actions.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        success: function(response) {
            if ($.trim(response)) {
                msg = "Sucessfully Save!";
                $('#modalGet_details_logs').modal('hide');
            } else {
                msg = "Error!"
            }
            l.stop();

            bootstrapGrowl(msg);
        }
    });
}));
//----------------------
$(document).ready(function() {
    //fetch data
    $('#modalGet_details_logs').modal('show');
    get_all_report('get_wreport');
});

function get_all_report(key) {
    $.ajax({
        url: 'task_service_log/weekly_report.php',
        method: 'POST',
        dataType: 'text',
        data: {
            key: key
        },
        success: function(response) {
            if (key == 'get_wreport') {
                $('#weekly_data').append(response);
            }
        }
    });
}

//jobs search
$(document).ready(function() {
    $('.data_users_search').keyup(function() {
        search_table($(this).val());
    });

    function search_table(value) {
        $('#weekly_data_tr tr').each(function() {
            var found = 'false';
            $(this).each(function() {
                if ($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) {
                    found = 'true';
                }
            });
            if (found == 'true') {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
});
</script>