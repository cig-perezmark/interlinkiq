function taskFormValidationInit() {
    var taskform = $('#task_form');
    var error2 = $('.alert-danger', taskform);
    var success2 = $('.alert-success', taskform);

    var validator = taskform.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",  // validate all fields including form hidden input
        rules: {
            description: {
                required: true
            },
            comment: {
                required: true
            },
            task_date: {
                required: true
            },
            minute: {
                required: true
            },
            account: {
                required: true
            },
            action: {
                required: true
            }
        },

        invalidHandler: function (event, validator) { //display error alert on form submit              
            success2.hide();
            error2.fadeIn();
            App.scrollTo(error2, -1);
        },

        errorPlacement: function (error, element) { // render error placement for each input type
            // var icon = $(element).parent('.input-icon').children('i');
            // icon.removeClass('fa-check').addClass("fa-warning");  
            // icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
        },

        highlight: function (element) { // hightlight error inputs
            // $(element)
            //     .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
        },

        unhighlight: function (element) { // revert the change done by hightlight
            
        },

        success: function (label, element) {
            // var icon = $(element).parent('.input-icon').children('i');
            // $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
            // icon.removeClass("fa-warning").addClass("fa-check");
        },

        submitHandler: function (form, event) {
            //window.reload();
            success2.fadeIn('slow');
            error2.hide();
            event.preventDefault();

            fetch('task_service_log/private/add_new_task.php', {
                method: 'POST',
                body: new FormData(event.target)
            }).then(res => {
                return res.json();
            }).then(data => {
                if(data.success) {
                    // append data to table row
                    $("#service_time_logs_table").DataTable().row.add(data.task_details).draw();

                    $('#advSearchAlert').find('.close').click();
                    $('#newTask').modal('hide');
                    destroyTaskForm();
                    // toastr['success'](data.success, "Added successfully");
                    bootstrapGrowl('Added successfully!');
                     console.log('testing');
                }
                else if(data.error) {
                    $('#newTask').modal('hide');
                    toastr['error'](data.error, "Error")
                }
            });
        }
    });

    //reset new task form
    function destroyTaskForm() {
        taskform.find('.alert').css('display', 'none');
        taskform.find('.has-error').removeClass('has-error');
        taskform.find('.has-success').removeClass('has-success');
        taskform.find('#task_description').val("");
        taskform.find('#task_comment').val("");
        taskform.find('#task_minute').val("");
        // taskform.find('.fa').prop('class', 'fa'); // if using icons
        validator.destroy();
    }
    
    // current date init (new task form)
    document.getElementById('taskdate').value = new Date().toISOString().split('T')[0];
}

function repopulateServiceLogTable(data) {
    const slt  = $('#service_time_logs_table');
    const sltSettings = slt.dataTable().fnSettings();
    const totalRecords = sltSettings.fnRecordsTotal();

    // delete all table rows
    for(let i=0; i<=totalRecords; i++) {
        slt.dataTable().fnDeleteRow(0, null, true);
    }

    // repopulate table with the new data
    $("#service_time_logs_table").DataTable().rows.add(data).draw();
}

addEventListener('DOMContentLoaded', function() {
    // task option initialization (copy to clipboard)
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-bottom-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    // datatable
    var e = $("#service_time_logs_table");
    var dt = e.dataTable({
        // ajax:"views/task_service_log/data.json",
        ajax: {
            url: "task_service_log/private/fetch_service_logs.php",
            // dataSrc: ""
        },
        language: {
            aria: { sortAscending: ": activate to sort column ascending", sortDescending: ": activate to sort column descending" },
            emptyTable: "No service logs available",
            info: "Showing _START_ to _END_ of _TOTAL_ records",
            infoEmpty: "No records found",
            infoFiltered: `<i>(filtered <span id="searchItemInput"></span> from _MAX_ records)</i>`,
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
            { data: 'task_id', title: 'Task ID', targets: 0},
            { data: 'description', title: 'Description', targets: 1},
            { data: 'action', title: 'Action', targets: 2},
            { data: 'comment', title: 'Comment', targets: 3},
            { data: 'account', title: 'Account', targets: 4},
            { data: 'task_date', title: 'Date', targets: 5},
            { data: 'minute', title: 'Time', targets: 6},
            { orderable: true, targets: '_all' }, { searchable: true, targets: '_all' }, { className: "dt-right" }
        ],
        order: [[0, "desc"]],
        buttons: [
            { extend: 'print', className: 'btn dark btn-outline' },
            { extend: 'copy', className: 'btn red btn-outline' },
            { extend: 'pdf', className: 'btn green btn-outline' },
            { extend: 'excel', className: 'btn yellow btn-outline ' },
            { extend: 'csv', className: 'btn purple btn-outline ' }
        ]
    });
    jQuery("#service_time_logs_table_wrapper");

    dt.on( 'stateLoaded.dt', function (e, settings, data) {
        dt.columns.adjust().draw();
    });

    // handle datatable custom tools
    $('#servicelog_table_actions a.tool-action').on('click', function() {
        var action = $(this).attr('data-action') || null;
        if(action)
            dt.DataTable().button(action).trigger();
    });

    dt.on( 'buttons-action.dt', function ( e, buttonApi, dataTable, node, config ) {
        if(buttonApi.text() === "Copy") {
            $('#datatables_buttons_info').remove(); // prevent default jQUery copy-to-clipboard notif from showing
            toastr['info'](`Copied ${dataTable.data().length} rows to clipboard!`, "Copy to clipboard");
            // console.log(dataTable.data().length)
        }
    });

    dt.on( 'search.dt', function (e) {
        setTimeout(() => {
            $('#searchItemInput').html(`'${$('.dataTables_filter input').val()}'`);
        }, 50);
    });

    taskFormValidationInit();
    $('#newTask').on('hidden.bs.modal', function() {
        taskFormValidationInit(); // reinitialize form validation
    });
    
    // trigger file upload on button click
    $('#massUploadCSVFileForm').on('click', function() {
        document.querySelector('#massUploadCSVFileInput').click();
    });

    // read and fetch content of CSV File in the server
    $('#massUploadCSVFileInput').on('change', function(event) {
        setTimeout(function() {
            const formData = new FormData();
            formData.append('servicelog_file', event.target.files[0]);
            
            fetch('task_service_log/private/fetch_csv_content.php', {
                method: "post",
                body: formData
            }).then(res => {
                return res.json();
            }).then(data => {
                var html = '<table class="table table-striped table-bordered table-hover massUploadTBL">';
    
                if(data.column) {
                    html += '<tr>';
                    for(var count = 0; count < data.column.length; count++) {
                        html += '<th>'+data.column[count]+'</th>';
                    }
                    html += '</tr>';
                }

                $('#massUploadImportBtn').prop('disabled', false);
    
                if(data.row_data) {
                    for(var count = 0; count < data.row_data.length; count++) {
                        var servicedate = data.row_data[count].service_date;      
                        var servicedescription =  data.row_data[count].service_description;
                        var finaldescription = "";
                        var comment = data.row_data[count].service_comment;
                        var finalcomment = "";
                        
                        finalcomment  = comment.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');
                        
                        finaldescription = servicedescription.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');
                        
                        html += `<tr>`;
                        html += `<td class="service_description" contenteditable>${finaldescription}</td>`;
                        html += `<td class="service_action" contenteditable>${data.row_data[count].service_action}</td>`;
                        html += `<td class="service_comment" contenteditable>${finalcomment}</td>`;
                        html += `<td class="service_account" contenteditable>${data.row_data[count].service_account}</td>`;
                        html += `<td class="service_date" contenteditable>${formatDate(servicedate)}</td>`;
                        html += `<td class="service_time ${data.row_data[count].service_time.search(/^[0-9]*$/g) == -1 ? "error-input" : "" }" contenteditable>${data.row_data[count].service_time}</td></tr>`;

                        if(data.row_data[count].service_time.search(/^[0-9]*$/g) == -1)
                            $('#massUploadImportBtn').prop('disabled', true);
                    }  
                }
    
                html += '</table>';
                // html += '<div align="center"><button type="button" id="import_data" class="btn btn-success">Import</button></div>';
    
                $('#csv_file_data').html(html);

                //checking a valid input for time
                $('#csv_file_data').find('.service_time').on('blur', function() {
                    $('#massUploadImportBtn').prop('disabled', false);

                    $('#csv_file_data').find('.service_time').each((i, el) => {

                        if($(el).text().search(/^[0-9]*$/g) == -1) {
                            $('#massUploadImportBtn').prop('disabled', true);
                            $(el).addClass("error-input");
                        }
                        else {
                            $(el).removeClass("error-input");
                        }
                    });
                });
                
                $('#massUploadCSVFileInput').val("");
                $('#massUploadCSVFileForm').blur();

                // sir brandon's
                // upload event
                // every file upload/renewal of table data due to next upload
                $('#massUploadImportBtn').off('click');
                $('#massUploadImportBtn').on('click', function() {
                    var service_id = [];
                    var service_description = [];
                    var service_action = [];
                    var service_comment = [];
                    var service_account = [];
                    var service_date = [];
                    var service_time = [];
                    
                    $('.service_id').each(function(){
                        service_id.push($(this).text());
                    });
                    $('.service_description').each(function(){
                        service_description.push($(this).text());
                    });
                    $('.service_action').each(function(){
                        service_action.push($(this).text());
                    });
                    $('.service_comment').each(function(){
                        service_comment.push($(this).text());
                    });
                    $('.service_account').each(function(){
                        service_account.push($(this).text());
                    });
                    $('.service_date').each(function(){
                        service_date.push($(this).text());
                    });
                    $('.service_time').each(function(){
                        service_time.push($(this).text());
                    });
                    $.ajax({
                        url:"task_service_log/private/import_data_from_table.php",
                        method:"post",
                        data:{
                            service_id:service_id,
                            service_description:service_description,
                            service_action:service_action,
                            service_comment:service_comment,
                            service_account:service_account,
                            service_date:service_date,
                            service_time:service_time
                        },
                        success:function(data) {
                            if(data.length > 0) {
                                $('#massUploadImportBtn').off('click');
                                $('#massUploadImportBtn').prop('disabled', true);
                                $('#csv_file_data').html("");
                                // $('#csv_file_data').html('<div class="alert alert-success">Data Imported Successfully</div>');
                                
                                $("#service_time_logs_table").DataTable().rows.add(JSON.parse(data)).draw();

                                $('#advSearchAlert').find('.close').click();

                                swal({
                                    title: "Data imported successfully",
                                    text: "",
                                    type: "success",
                                    allowOutsideClick: true,
                                    showConfirmButton: "btn-success",
                                });
                            }
                        }
                    })
                });
            });
        }, 50);
    });

    // init performance summary updates
    $(`a[data-toggle='tab'][href='#PERFORMANCE']`).on('click', function() {
        fetch('task_service_log/private/performance_summary.php').
        then(res => {return res.json()}).
        then(data => {
            if(Object.keys(data).length > 0) {
                const container = $('#PERFORMANCE');
                
                Object.keys(data).forEach(key => {
                    container.find(`[data-performance='${key}']`).html(data[key]);
                });
            }
        }).catch(err => {
            console.error(err);
        });
    });

    // reset all fields of advance search modal on hide
    $('#advSearchModal').on('hide.bs.modal', function() {
        var advSearchForm = $('#advSearchForm');
        advSearchForm.find('input.form-control').val("");
        $('#ASActionMS').multiselect('deselectAll', false);
        $('#ASAccountMS').multiselect('deselectAll', false);
        $('#ASActionMS').multiselect('refresh');
        $('#ASAccountMS').multiselect('refresh');
        advSearchForm.find('[name=endDate]').removeAttr('min');
        advSearchForm.find('[name=startDate]').removeAttr('max');
    });

    $('#advSearchModal').on('shown.bs.modal', function() {
        $('#advSearchForm').find('[name="keyword"]').focus();
    });

    // adv search input enter key pressed
    $('#advSearchForm').find('input[name="keyword"]').on('keyup', function(event) {
        if(event.key === "Enter") {
            $('#advSearchForm').submit();
        }
    });

    // adv search alert
    $('#advSearchAlert').find('.close').on('click', function() {
        $('#advSearchAlert').fadeOut('slow', function() {
            $('#advSearchAlert').find('._kw').html('');

            // if closed, repopulate table with normal data
            fetch('task_service_log/private/fetch_service_logs.php').
            then(res => {return res.json()}).
            then(dataResults => {
                if(dataResults.data) {
                    repopulateServiceLogTable(dataResults.data);
                }
            }).catch(err => {
                console.error(err);
            })
        });
    });

    // advance search date range events
    $('.advDateRange input[name=startDate]').on('change', function() {
        $('.advDateRange input[name=endDate]').prop('min', $(this).val());
    });

    $('.advDateRange input[name=endDate]').on('change', function() {
        $('.advDateRange input[name=startDate]').prop('max', $(this).val());
    });

    // advance search form submit
    $('#advSearchForm').on('submit', function(event) {
        event.preventDefault();

        fetch('task_service_log/private/advance_search_results.php', {
            method: 'POST',
            body: new FormData(event.target)
        }).then(res => {
            return res.json();
        }).then(data => {
            const alert = $('#advSearchAlert');

            if(data.length > 0) {
                alert.removeClass('alert-danger').addClass('alert-success');
                alert.find('._stmt').html(`Filtered ${data.length} result${data.length > 1 ? "s" : ""} from records`);

            }
            else {
                alert.find('._stmt').html('No match found')
                alert.removeClass('alert-success').addClass('alert-danger');
            }
            
            repopulateServiceLogTable(data);
            alert.fadeIn('slow');
            $('#advSearchModal').modal('hide');
        });
    });

    populateMultiSelects();
});

function populateMultiSelects() {
    $.ajax({ // fetching actions select menu
        url: "task_service_log/private/functions.php?method=getActions",
        dataType: "json",
        success: function(data) {
            if(data.length > 0) {
                let opts = ``;
                data.forEach(d => {
                    opts += `<option value="${d}">${d}</option>`;
                });
                $('#ASActionMS').html(opts);
            }     
            
            // multiselect
            $('#ASActionMS').multiselect({   
                buttonWidth: '100%',
                includeSelectAllOption: true,
                buttonClass: 'mt-multiselect btn btn-default',
            });               
        }
    });

    $.ajax({ // fetching accounts select menu
        url: "task_service_log/private/functions.php?method=getAccounts",
        dataType: "json",
        success: function(data) {
            if(data.length > 0) {
                let opts = ``;
                data.forEach(d => {
                    opts += `<option value="${d}">${d}</option>`;
                });
                $('#ASAccountMS').html(opts);
            }                    

            // multiselect
            $('#ASAccountMS').multiselect({   
                buttonWidth: '100%',
                includeSelectAllOption: true,
                buttonClass: 'mt-multiselect btn btn-default'
            });
        }
    });

}

function formatDate(userDate) {
    // Step 1: attempt to convert parameter to a date!
    var returnDate = new Date(userDate);
    
    // Step 2: now that this is a date, we can grab the day, month and year
    // portions with ease!
    var y = returnDate.getFullYear();
    var m = returnDate.getMonth() + 1; // Step 6
    var d = returnDate.getDate();
    
    // Step 3: The bit we did above returned integer values. Because we are
    // *formatting*, we should really use strings
    y = y.toString();
    m = m.toString();
    d = d.toString();

    // Step 4: The value of our month and day variables can be either 1 or 2
    // digits long. We need to force them to always be 2 digits.
    // There are lots of ways to achieve this. Here's just one option:
    if (m.length == 1) {
        m = '0' + m;
    }
    if (d.length == 1) {
        d = '0' + d;
    }

    // Step 5: combine our new string values back together!
    returnDate = y + '-' + m + '-' + d;
    
    // Step 6: did you notice a problem with the output value?
    // The month is wrong! This is because getMonth() returns a value
    // between 0 and 11 i.e. it is offset by 1 each time!
    // Look back up at Step 2 and see the extra piece of code
    
    // Step 7: Looks pretty good, huh? Well, it might pass you your quiz
    // question, but it's still not perfect.
    // Do you know why?
    // Well, it assumes that the parameter value is
    //    a) always an actual date (e.g. not "dave")
    //    b) our Step1 correctly converts the value (e.g. the client, where
    //       the JS is run, uses the date format m/d/y).
    //       I am in the UK, which doesn't like m/d/y, so my results will
    //       be different to yours!
    // I'm not going to solve this here, but is more food for thought for you.
    // Consider it extra credit!
    
    return returnDate;
}

function initDateRangeSearch() {
    const startDate = $('.advDateRangeSearch input[name=startDate]');
    const endDate = $('.advDateRangeSearch input[name=endDate]');

    startDate.on('change', function() {
        const value = startDate.val();

        endDate.prop('min', value);
    })

    
    endDate.on('change', function() {
        const value = endDate.val();

        startDate.prop('max', value);
    })
}

initDateRangeSearch();