

$(document).ready(function() {
    load_data();
    $(".summernoteEditor").summernote({
        placeholder:'',
        height: 400
    });
    
    $('.dropdown-toggle').dropdown();
    
    function resetAllCheckBoxText() {
        var checkbox = $('input[type="checkbox"]');
        var input = $('input[type="text"]');
        checkbox.prop('false');
        input.val('');
    }
    
    function changeStatus() {
        $('.contact-row input[type="checkbox"]:checked').each(function() {
            $(this).find('.status-contact').text('Archived').addClass('text-red')
        })
    }
    
    function hideContactRow() {
        $('.contact-row input[type="checkbox"]:checked').each(function() {
            $(this).closest('.contact-row').find('.status-contact').remove()
        })
    }
    
    function initializeDataTable(selector) {
        return $(selector).dataTable({
            // DataTable initialization options here
            language: {
                aria: {
                    sortAscending: ": activate to sort column ascending",
                    sortDescending: ": activate to sort column descending"
                },
                emptyTable: "No data available in table",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries found",
                infoFiltered: "(filtered1 from _MAX_ total entries)",
                lengthMenu: "_MENU_ entries",
                search: "Search:",
                zeroRecords: "No matching records found"
            },
            buttons: [
                { extend: 'print', className: 'btn default' },
                { extend: 'pdf', className: 'btn red' },
                { extend: 'csv', className: 'btn green' }
            ],
            columnDefs: [
                { targets: [0, 8], orderable: false }
            ],
            order: [
                [6, 'desc']
            ],
            lengthMenu: [
                [5, 10, 15, 25, 50],
                [5, 10, 15, 25, 50]
            ],
            pageLength: 15,
            searching: true,
            dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
         
        });
    }
    
    function initializeDataTable2(selector) {
        if ($.fn.DataTable.isDataTable(selector)) {
            // Destroy the existing DataTable instance
            $(selector).DataTable().destroy();
        }
        return $(selector).dataTable({
            // DataTable initialization options here
            language: {
                aria: {
                    sortAscending: ": activate to sort column ascending",
                    sortDescending: ": activate to sort column descending"
                },
                emptyTable: "No data available in table",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries found",
                infoFiltered: "(filtered1 from _MAX_ total entries)",
                lengthMenu: "_MENU_ entries",
                search: "Search:",
                zeroRecords: "No matching records found"
            },
            buttons: [
                { extend: 'print', className: 'btn default' },
                { extend: 'pdf', className: 'btn red' },
                { extend: 'csv', className: 'btn green' }
            ],
            order: [
                [0, 'asc']
            ],
            lengthMenu: [
                [5, 10, 15, 20],
                [5, 10, 15, 20]
            ],
            pageLength: 5,
            searching: true,
            dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });
    }
    
    function destroy_dataTable() {
        if ($.fn.DataTable.isDataTable('#dataTable_1')) {
            $('#dataTable_1').DataTable().destroy();
            $('#dataTable_1').addClass('d-none');
            }
        if ($.fn.DataTable.isDataTable('#dataTable_2')) {
            $('#dataTable_2').DataTable().destroy();
            $('#dataTable_2').addClass('d-none');
        }
    }

    function load_data() {
        if ($.fn.DataTable.isDataTable('#dataTable_2')) {
            $('#dataTable_1').DataTable().destroy();
        }
        $.ajax({
            url: "crm/controller_functions.php",
            method: "POST",
            data: { query: true },
            success: function(data) {
                $('#dataTable_1 tbody').html(data);
                initializeDataTable('#dataTable_1');
                $('#site_activities_loading, #spinner-text').addClass('d-none');
                $('.portlet-body').addClass('margin-5');
                $('#search, #dataTable_1, #filter-side').removeClass('d-none');
            }
        });
    }
    
    function destroyDataTable(dataTable) {
        if (dataTable) {
            dataTable.destroy();
        }
    }
               
    $(document).on('change', '.checkbox_action', function() {
        var checkedCheckboxes = $('.checkbox_action:checked');
        var button = $('#actionBtn');
        button.toggleClass('d-none', checkedCheckboxes.length === 0);
    });
    
    $('.select-all').click(function(event) {   
        if(this.checked) {
            $('.checkbox_action').each(function() {
                this.checked = true;
                $('#actionBtn').removeClass('d-none');
            });
        } else {
            $('.checkbox_action').each(function() {
                this.checked = false;     
                $('#actionBtn').addClass('d-none');
            });
        }
    });
    
    $('#addContactForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('add_contact', 'add_contact');

        $.ajax({
            url: 'crm/controller_functions.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false, 
            success: function (response) {
                response = JSON.parse(response);
                $('#modalNew').modal('hide');
                $('#addContactForm')[0].reset();
                $.bootstrapGrowl(response.message, {
                  ele: 'body',
                  type: 'success',
                  offset: {from: 'bottom', amount: 50},
                  align: 'right',
                  width: 'auto',
                  delay: 4000,
                  allow_dismiss: true,
                  stackup_spacing: 10
                });
            },
            error: function (error) {
                response = JSON.parse(response);
                $.bootstrapGrowl(response.message, {
                  ele: 'body',
                  type: 'danger',
                  offset: {from: 'bottom', amount: 50},
                  align: 'right',
                  width: 'auto',
                  delay: 4000,
                  allow_dismiss: true,
                  stackup_spacing: 10
                });
            }
        })
    })
    
    $(document).on('submit', '#emailCampaignForm', function(e){
        e.preventDefault();
        // Disable the submit button to prevent multiple submissions
        $('#sendCampaignMessage').attr('disabled', true).text('Sending ...');

        var selectedIds = [];
        var action = 'campaign';
        var body = $('#campaign-body-multi').val();
        var subject = $('#campaign-subject-multi').val();
        var name = $('#campaign-name-multi').val();
        var frequency = $('#campaign-frequency').val();
        var from = $('#current-email').val();
        
        $('.checkbox_action:checked').each(function () {
            selectedIds.push($(this).val());
        });
        
        if (selectedIds.length > 0) {
            $.ajax({
                url: 'crm/controller_functions.php',
                type: 'POST',
                data: { 
                    manage_contacts: true,
                    action: action,
                    body: body,
                    subject: subject,
                    name: name,
                    frequency: frequency,
                    from: from,
                    ids: selectedIds 
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        $.bootstrapGrowl(response.message, {
                            ele: 'body',
                            type: 'success',
                            offset: {from: 'bottom', amount: 50},
                            align: 'right',
                            width: 'auto',
                            delay: 4000,
                            allow_dismiss: true,
                            stackup_spacing: 10
                        });
                        $('.summernoteEditor').summernote('code', '');
                        $('#emailCampaignForm')[0].reset();
                        $('#sendCampaign').modal('hide');
                    } else {
                        // Error handling: Show an error notification
                        $.bootstrapGrowl(response.message, {
                            ele: 'body',
                            type: 'danger',
                            offset: {from: 'bottom', amount: 50},
                            align: 'right',
                            width: 'auto',
                            delay: 4000,
                            allow_dismiss: true,
                            stackup_spacing: 10
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // AJAX error handling: Show a generic error notification
                    $.bootstrapGrowl('An error occurred during the request.', {
                        ele: 'body',
                        type: 'danger',
                        offset: {from: 'bottom', amount: 50},
                        align: 'right',
                        width: 'auto',
                        delay: 4000,
                        allow_dismiss: true,
                        stackup_spacing: 10
                    });
                },
                complete: function () {
                    // Re-enable the submit button after processing
                    $('#sendCampaignMessage').attr('disabled', false).text('Send');
                }
            });
        } else {
            alert('Please select at least one record.');
            // Re-enable the submit button if there's an error
            $('#sendCampaignMessage').attr('disabled', false).text('Send');
        }
    });

    
    $(document).on('click', '#sendEmailGreetings', function(){
        var selectedIds = [];
        var action = $(this).data('id');
        
        $('.checkbox_action:checked').each(function () {
            selectedIds.push($(this).val());
        });
        
        console.log(selectedIds)
    })
    
    $(document).on('click', '#sendEmail', function(){
        var selectedIds = [];
        var action = $(this).data('id');
        
        $('.checkbox_action:checked').each(function () {
            selectedIds.push($(this).val());
        });
    })
    
    $(document).on('click', '#archiveContact', function(){
        var selectedIds = [];
        var action = $(this).data('id');
        
        $('.checkbox_action:checked').each(function () {
            selectedIds.push($(this).val());
        });
        
        if (selectedIds.length > 0) {
            Swal.fire({
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes, archive it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'crm/controller_functions.php',
                        type: 'POST',
                        data: { 
                            manage_contacts: true,
                            action: action,
                            ids: selectedIds 
                        },
                        success: function (response) {
                            response = JSON.parse(response);
                            if (response.status === 'success') {
                                $('#modalNew').modal('hide');
                                $('#addContactForm')[0].reset();
                                $.bootstrapGrowl(response.message, {
                                    ele: 'body',
                                    type: 'success',
                                    offset: {from: 'bottom', amount: 50},
                                    align: 'right',
                                    width: 'auto',
                                    delay: 4000,
                                    allow_dismiss: true,
                                    stackup_spacing: 10
                                });
                                 resetAllCheckBoxText();
                                changeStatus();
                                removeStatus();
                            } else {
                                $.bootstrapGrowl(response.message, {
                                    ele: 'body',
                                    type: 'danger',
                                    offset: {from: 'bottom', amount: 50},
                                    align: 'right',
                                    width: 'auto',
                                    delay: 4000,
                                    allow_dismiss: true,
                                    stackup_spacing: 10
                                });
                            }
                        },
                        error: function (error) {
                            console.log(error);
                            $.bootstrapGrowl('Error occurred while processing your request.', {
                                ele: 'body',
                                type: 'danger',
                                offset: {from: 'bottom', amount: 50},
                                align: 'right',
                                width: 'auto',
                                delay: 4000,
                                allow_dismiss: true,
                                stackup_spacing: 10
                            });
                        }
                    });
                }
            });
        } else {
            alert('Please select at least one record.');
        }
    })
    
    $(document).on('click', '#restoreContact', function(){
        var selectedIds = [];
        var action = $(this).data('id');
        
        $('.checkbox_action:checked').each(function () {
            selectedIds.push($(this).val());
        });
        
        if (selectedIds.length > 0) {
            Swal.fire({
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes, restore it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'crm/controller_functions.php',
                        type: 'POST',
                        data: { 
                            manage_contacts: true,
                            action: action,
                            ids: selectedIds 
                        },
                        success: function (response) {
                            response = JSON.parse(response);
            
                            if (response.status === 'success') {
                                $('#modalNew').modal('hide');
                                $('#addContactForm')[0].reset();
                                $.bootstrapGrowl(response.message, {
                                    ele: 'body',
                                    type: 'success',
                                    offset: {from: 'bottom', amount: 50},
                                    align: 'right',
                                    width: 'auto',
                                    delay: 4000,
                                    allow_dismiss: true,
                                    stackup_spacing: 10
                                });
                                hideContactRow()
                            } else {
                                $.bootstrapGrowl(response.message, {
                                    ele: 'body',
                                    type: 'danger',
                                    offset: {from: 'bottom', amount: 50},
                                    align: 'right',
                                    width: 'auto',
                                    delay: 4000,
                                    allow_dismiss: true,
                                    stackup_spacing: 10
                                });
                            }
                        },
                        error: function (error) {
                            console.log(error);
                            $.bootstrapGrowl('Error occurred while processing your request.', {
                                ele: 'body',
                                type: 'danger',
                                offset: {from: 'bottom', amount: 50},
                                align: 'right',
                                width: 'auto',
                                delay: 4000,
                                allow_dismiss: true,
                                stackup_spacing: 10
                            });
                        }
                    });
                }
            });
        } else {
            alert('Please select at least one record.');
        }
    })
    
    $(document).on('click', '#deleteContact', function(){
        var selectedIds = [];
        var action = $(this).data('id');
        
        $('.checkbox_action:checked').each(function () {
            selectedIds.push($(this).val());
        });
        
        if (selectedIds.length > 0) {
            Swal.fire({
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'crm/controller_functions.php',
                        type: 'POST',
                        data: { 
                            manage_contacts: true,
                            action: action,
                            ids: selectedIds 
                        },
                        success: function (response) {
                            response = JSON.parse(response);
            
                            if (response.status === 'success') {
                                $('#modalNew').modal('hide');
                                $('#addContactForm')[0].reset();
                                $.bootstrapGrowl(response.message, {
                                    ele: 'body',
                                    type: 'success',
                                    offset: {from: 'bottom', amount: 50},
                                    align: 'right',
                                    width: 'auto',
                                    delay: 4000,
                                    allow_dismiss: true,
                                    stackup_spacing: 10
                                });
                            } else {
                                $.bootstrapGrowl(response.message, {
                                    ele: 'body',
                                    type: 'danger',
                                    offset: {from: 'bottom', amount: 50},
                                    align: 'right',
                                    width: 'auto',
                                    delay: 4000,
                                    allow_dismiss: true,
                                    stackup_spacing: 10
                                });
                            }
                        },
                        error: function (error) {
                            console.log(error);
                            $.bootstrapGrowl('Error occurred while processing your request.', {
                                ele: 'body',
                                type: 'danger',
                                offset: {from: 'bottom', amount: 50},
                                align: 'right',
                                width: 'auto',
                                delay: 4000,
                                allow_dismiss: true,
                                stackup_spacing: 10
                            });
                        }
                    });
                }
            });
        } else {
            alert('Please select at least one record.');
        }
    })
    
    $(document).on('click', '.manageContacts', function () {
        var selectedIds = [];
        
        
        var action = $(this).data('id');
        var name = $('#campaign-name').val();
        var email = $('#current-email').val();
        var subject = $('#campaign-subject').val();
        var body = $('#campaign-body').val();
        var frequency = $('#campaign-frequency').val();
        var action_value = name.trim();
        var taken_action = (action_value === '') ? 0 : 1;

    
        $('.checkbox_action:checked').each(function () {
            selectedIds.push($(this).val());
        });
        
        var btn = $('#sendCampaignMessage')
        btn.on('click', function (e) {
         e.preventDefault(); 
         alert(1)
        var name = $('#campaign-name').val();
        var subject = $('#campaign-subject').val();
        var body = $('#campaign-body').val();
        console.log(name)
        console.log(subject)
        console.log(body)
        })
        console.log(name)
        console.log(subject)
        console.log(email)
        console.log(body)
        console.log(frequency)
    
        if (selectedIds.length > 0) {
            $.ajax({
                url: 'crm/controller_functions.php',
                type: 'POST',
                data: { 
                    manage_contacts: true,
                    action: action,
                    campaign_name: name,
                    email: email,
                    body: body,
                    subject: subject,
                    taken_action: taken_action,
                    ids: selectedIds 
                },
                success: function (response) {
                    response = JSON.parse(response);
    
                    if (response.status === 'success') {
                        $('#modalNew').modal('hide');
                        $('#addContactForm')[0].reset();
                        $.bootstrapGrowl(response.message, {
                            ele: 'body',
                            type: 'success',
                            offset: {from: 'bottom', amount: 50},
                            align: 'right',
                            width: 'auto',
                            delay: 4000,
                            allow_dismiss: true,
                            stackup_spacing: 10
                        });
                    } else {
                        $.bootstrapGrowl(response.message, {
                            ele: 'body',
                            type: 'danger',
                            offset: {from: 'bottom', amount: 50},
                            align: 'right',
                            width: 'auto',
                            delay: 4000,
                            allow_dismiss: true,
                            stackup_spacing: 10
                        });
                    }
                },
                error: function (error) {
                    console.log(error);
                    $.bootstrapGrowl('Error occurred while processing your request.', {
                        ele: 'body',
                        type: 'danger',
                        offset: {from: 'bottom', amount: 50},
                        align: 'right',
                        width: 'auto',
                        delay: 4000,
                        allow_dismiss: true,
                        stackup_spacing: 10
                    });
                }
            });
        } else {
            alert('Please select at least one record.');
        }
    });

    $(document).on('click', '.manageContact', function() {
        var contact_id = $(this).data('id'); // Use .data() to retrieve the data-id attribute
        // alert(contact_id)
        $.post({
            url: 'crm/controller_functions.php',
            data: {
                get_notification_count: true,
                contact_id: contact_id
            },
            success: function(response) {
                $('#notifCount' + contact_id).html(response);
            }
        });
    });

    $(document).on('click', '.addRemarks', function(e) {
        e.preventDefault()
        $('#add_remarks').modal('show'); 
        var contact_id = $(this).data('id');
        $('#contactid').val(contact_id)
        $.post({
            url: 'crm/controller_functions.php',
            data: {
                get_crm_remarks: true,
                contact_id: contact_id
            },
            success: function(response) {
                $('#chatThreads').html(response);
            }
        })
    })
    
    $('#sendMessage').on('click', function() {
        var contactid = $('#contactid').val();
        var message = $('#messageContent').val()
        console.log(contactid)
        console.log(message)
    })
    
    $('.replyMessage').on('click', function(e) {
        e.preventDefault()
        var contactid = $()
        var parentid = $()
        var message = $()
        var action = $()
        
        $.post({
            url: '',
            data: {
                add_remarks: true,
                contactid: contactid,
                parentid: parentid,
                message: message,
                action:action
            },
            success:function(response) {
                alert('Message send');
            }
        })
    })
    
    $(document).on('click', '.delete_contact', function(e) {
        let id = $(this).attr('id')
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        }).then((result) => {
          if (result.isConfirmed) {
            $.bootstrapGrowl('Contact deleted successfully', {
              ele: 'body',
              type: 'success',
              offset: {from: 'bottom', amount: 50},
              align: 'right',
              width: 'auto',
              delay: 4000,
              allow_dismiss: true,
              stackup_spacing: 10
            });
          }
        });
    })
    
    $('#filter-via-date').on('submit', function(e) {
        e.preventDefault();
        var from = $('#date-from').val();
        var to = $('#date-to').val();
        if (!from.length || !to.length) {
            alert('Date input are required');
            return;
        }
        
        if ($.fn.DataTable.isDataTable('#dataTable_1')) {
            $('#dataTable_1').DataTable().destroy();
            $('#dataTable_1').addClass('d-none');
        }
        if ($.fn.DataTable.isDataTable('#dataTable_2')) {
            $('#dataTable_2').DataTable().destroy();
            $('#dataTable_2').addClass('d-none');
        }
        $('#site_activities_loading, #spinner-text').removeClass('d-none');
        
        $('#dataTable_2').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "crm/controller_functions.php",
                "type": "POST",
                "data": {
                    filter_range: true,
                    from: from,
                    to: to
                }
            },
            "columns": [
                { "data": "crm_id", "render": function(data, type, row) {
                    return `<label class="mt-checkbox ${row.checkbox_display || ''}">
                                <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="${data || ''}"/>
                                <span></span>
                            </label>`;
                }},
                { "data": "account_name", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "account_email", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "contact_phone", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "Account_Source", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "status", "render": function(data, type, row) {
                    return `<span class="contact-status">${data || ''}</span>`;
                }},
                { "data": "activity_date", "render": function(data, type, row) {
                    if (data === 'Expired') {
                        return '<span class="font-red bold">Expired Campaign</span>';
                    } else {
                        return data || '';
                    }
                }},
                { "data": "performer_name", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "crm_id", "render": function(data, type, row) {
                    return `<div class="clearfix">
                                <div class="">
                                    <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_details.php?view_id=${data || ''}"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm blue tooltips d-none" data-original-title="Add Task" href="customer_details.php?view_id=${data || ''}"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm red tooltips activity-history" id="${data || ''}" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                </div>
                            </div>`;
                }}
            ],
            "initComplete": function(settings, json) {
                $('#dataTable_2').removeClass('d-none');
                $('#site_activities_loading, #spinner-text').addClass('d-none');
            }
        });
    });
    
    $('.filter_value').on('click', function(e) {
        var isChecked = $(this).prop('checked');
        if(isChecked == true) {
            var column = $(this).attr('data-value');
            var value = $(this).val();
            if ($.fn.DataTable.isDataTable('#dataTable_1')) {
                $('#dataTable_1').DataTable().destroy();
                $('#dataTable_1').addClass('d-none');
            }
            if ($.fn.DataTable.isDataTable('#dataTable_2')) {
                $('#dataTable_2').DataTable().destroy();
                $('#dataTable_2').addClass('d-none');
            }
            $('#site_activities_loading, #spinner-text').removeClass('d-none');
            
            $('#dataTable_2').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "crm/controller_functions.php",
                    "type": "POST",
                    "data": {
                        filter_value: true,
                        column: column,
                        value: value
                    }
                },
                "columns": [
                    { "data": "crm_id", "render": function(data, type, row) {
                        return `<label class="mt-checkbox ${row.checkbox_display || ''}">
                                    <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="${data || ''}"/>
                                    <span></span>
                                </label>`;
                    }},
                    { "data": "account_name", "render": function(data, type, row) {
                        return data || '';
                    }},
                    { "data": "account_email", "render": function(data, type, row) {
                        return data || '';
                    }},
                    { "data": "contact_phone", "render": function(data, type, row) {
                        return data || '';
                    }},
                    { "data": "Account_Source", "render": function(data, type, row) {
                        return data || '';
                    }},
                    { "data": "status", "render": function(data, type, row) {
                        return `<span class="contact-status">${data || ''}</span>`;
                    }},
                    { "data": "activity_date", "render": function(data, type, row) {
                        if (data === 'Expired') {
                            return '<span class="font-red bold">Expired Campaign</span>';
                        } else {
                            return data || '';
                        }
                    }},
                    { "data": "performer_name", "render": function(data, type, row) {
                        return data || '';
                    }},
                    { "data": "crm_id", "render": function(data, type, row) {
                        return `<div class="clearfix">
                                    <div class="">
                                        <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_details.php?view_id=${data || ''}"><i class="icon-eye"></i> View</a>
                                        <a class="btn btn-sm blue tooltips d-none" data-original-title="Add Task" href="customer_details.php?view_id=${data || ''}"><i class="icon-eye"></i> View</a>
                                        <a class="btn btn-sm red tooltips activity-history" id="${data || ''}" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                    </div>
                                </div>`;
                    }}
                ],
                "initComplete": function(settings, json) {
                    $('#dataTable_2').removeClass('d-none');
                    $('#site_activities_loading, #spinner-text').addClass('d-none');
                }
            });
        }
    })
    
    $('.filter_value_campaign').on('click', function(e) {
        var isChecked = $(this).prop('checked');
        if(isChecked == true) {
            var value = $(this).val();
            if ($.fn.DataTable.isDataTable('#dataTable_1')) {
                $('#dataTable_1').DataTable().destroy();
                $('#dataTable_1').addClass('d-none');
            }
            if ($.fn.DataTable.isDataTable('#dataTable_2')) {
                $('#dataTable_2').DataTable().destroy();
                $('#dataTable_2').addClass('d-none');
            }
            $('#site_activities_loading, #spinner-text').removeClass('d-none');
            
            $('#dataTable_2').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "crm/controller_functions.php",
                    "type": "POST",
                    "data": {
                        filter_campaign: true,
                        slug: value
                    }
                },
                "columns": [
                    { "data": "crm_id", "render": function(data, type, row) {
                        return `<label class="mt-checkbox ${row.checkbox_display || ''}">
                                    <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="${data || ''}"/>
                                    <span></span>
                                </label>`;
                    }},
                    { "data": "account_name", "render": function(data, type, row) {
                        return data || '';
                    }},
                    { "data": "account_email", "render": function(data, type, row) {
                        return data || '';
                    }},
                    { "data": "contact_phone", "render": function(data, type, row) {
                        return data || '';
                    }},
                    { "data": "Account_Source", "render": function(data, type, row) {
                        return data || '';
                    }},
                    { "data": "status", "render": function(data, type, row) {
                        return `<span class="contact-status">${data || ''}</span>`;
                    }},
                    { "data": "activity_date", "render": function(data, type, row) {
                        if (data === 'Expired') {
                            return '<span class="font-red bold">Expired Campaign</span>';
                        } else {
                            return data || '';
                        }
                    }},
                    { "data": "performer_name", "render": function(data, type, row) {
                        return data || '';
                    }},
                    { "data": "crm_id", "render": function(data, type, row) {
                        return `<div class="clearfix">
                                    <div class="">
                                        <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_details.php?view_id=${data || ''}"><i class="icon-eye"></i> View</a>
                                        <a class="btn btn-sm blue tooltips d-none" data-original-title="Add Task" href="customer_details.php?view_id=${data || ''}"><i class="icon-eye"></i> View</a>
                                        <a class="btn btn-sm red tooltips activity-history" id="${data || ''}" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                    </div>
                                </div>`;
                    }}
                ],
                "initComplete": function(settings, json) {
                    $('#dataTable_2').removeClass('d-none');
                    $('#site_activities_loading, #spinner-text').addClass('d-none');
                }
            });
        }
    });
    
    // $('.filter_value_campaign').on('click', function(e) {
    //     var isChecked = $(this).prop('checked');
    //     if(isChecked == true) {
    //         var value = $(this).val();
            
    //         destroy_dataTable()
    //         $('#site_activities_loading, #spinner-text').removeClass('d-none');
        
    //         $.post({
    //             url: "crm/controller_functions.php",
    //             data: {
    //                 filter_campaign: true,
    //                 slug: value
    //             },
    //             success: function(response) {
    //                 // $('#dataTable_1 tbody').html(response);
    //             $('#dataTable_1').removeClass('d-none');
    //             $('#dataTable_1 tbody').html(response);
    //             initializeDataTable('#dataTable_1');
                
    //             $('#site_activities_loading, #spinner-text').addClass('d-none');
    //                 $(this).prop('checked', false);
    //             }
    //         })
    //     } else if(isChecked == false) {
    //         $('#site_activities_loading, #spinner-text').removeClass('d-none');
    //         destroy_dataTable()
    //         load_data()
    //     }
    // })
    
    $(document).on('click', '.contactHistory', function(e) {
        e.preventDefault()
        $('#history_modal').modal('show'); 
        const contact_id = $(this).attr('data-id');
        if ($.fn.DataTable.isDataTable('#dataTable_3')) {
            $('#dataTable_3').DataTable().destroy();
        }
        console.log(contact_id)
        $.post({
            url: 'crm/controller_functions.php',
            data: {
                get_history_data: true,
                contact_id: contact_id
            },
            success: function(response) {
                $('#contactHistoryDetails').html(response);
                initializeDataTable('#dataTable_3');
            }
        })
    })
    
    $('.filter_value').on('change', function() {
        // Uncheck all other checkboxes with the same class
        $('.filter_value').not(this).prop('checked', false);
        $('.filter_value_campaign').not(this).prop('checked', false);
    });
    
    $('.filter_value_campaign').on('change', function() {
        // Uncheck all other checkboxes with the same class
        $('.filter_value_campaign').not(this).prop('checked', false);
        $('.filter_value').not(this).prop('checked', false);
    });
    
    $('#searchParent').on('submit', function(e) {
        e.preventDefault();
        var parentValue = $('#searchParentValue').val();

        // Destroy any existing DataTable instance to initialize a new one
        if ($.fn.DataTable.isDataTable('#dataTable_1')) {
            $('#dataTable_1').DataTable().destroy();
            $('#dataTable_1').addClass('d-none');
        }
        if ($.fn.DataTable.isDataTable('#dataTable_2')) {
            $('#dataTable_2').DataTable().destroy();
            $('#dataTable_2').addClass('d-none');
        }
        $('#site_activities_loading, #spinner-text').removeClass('d-none');

        // Initialize the DataTable with server-side processing
        $('#dataTable_2').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "crm/controller_functions.php",
                "type": "POST",
                "data": {
                    search_parent: true,
                    searchVal: parentValue,
                }
            },
            "columns": [
                { "data": "crm_id", "render": function(data, type, row) {
                    return `<label class="mt-checkbox ${row.checkbox_display || ''}">
                                <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="${data || ''}"/>
                                <span></span>
                            </label>`;
                }},
                { "data": "account_name", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "account_email", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "contact_phone", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "Account_Source", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "status", "render": function(data, type, row) {
                    return `<span class="contact-status">${data || ''}</span>`;
                }},
                { "data": "activity_date", "render": function(data, type, row) {
                    if (data === 'Expired') {
                        return '<span class="font-red bold">Expired Campaign</span>';
                    } else {
                        return data || '';
                    }
                }},
                { "data": "performer_name", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "crm_id", "render": function(data, type, row) {
                    return `<div class="clearfix">
                                <div class="">
                                    <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_details.php?view_id=${data || ''}"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm red tooltips activity-history" id="${data || ''}" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                </div>
                            </div>`;
                }}
            ],
            "initComplete": function(settings, json) {
                $('#dataTable_2').removeClass('d-none');
                $('#site_activities_loading, #spinner-text').addClass('d-none');
            }
        });
    });
    
    $('#searchFormEmail').on('submit', function(e) {
        e.preventDefault();
        var searchVal = $('#searchEmailValue').val();

        if ($.fn.DataTable.isDataTable('#dataTable_1')) {
            $('#dataTable_1').DataTable().destroy();
            $('#dataTable_1').addClass('d-none');
        }
        if ($.fn.DataTable.isDataTable('#dataTable_2')) {
            $('#dataTable_2').DataTable().destroy();
            $('#dataTable_2').addClass('d-none');
        }
        $('#site_activities_loading, #spinner-text').removeClass('d-none');

        $('#dataTable_2').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "crm/controller_functions.php",
                "type": "POST",
                "data": {
                    search_contact_email: true,
                    searchEmailVal: searchVal,
                }
            },
            "columns": [
                { "data": "crm_id", "render": function(data, type, row) {
                    return `<label class="mt-checkbox ${row.checkbox_display || ''}">
                                <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="${data || ''}"/>
                                <span></span>
                            </label>`;
                }},
                { "data": "account_name", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "account_email", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "contact_phone", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "Account_Source", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "status", "render": function(data, type, row) {
                    return `<span class="contact-status">${data || ''}</span>`;
                }},
                { "data": "activity_date", "render": function(data, type, row) {
                    if (data === 'Expired') {
                        return '<span class="font-red bold">Expired Campaign</span>';
                    } else {
                        return data || '';
                    }
                }},
                { "data": "performer_name", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "crm_id", "render": function(data, type, row) {
                    return `<div class="clearfix">
                                <div class="">
                                    <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_details.php?view_id=${data || ''}"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm red tooltips activity-history" id="${data || ''}" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                </div>
                            </div>`;
                }}
            ],
            "initComplete": function(settings, json) {
                $('#dataTable_2').removeClass('d-none');
                $('#site_activities_loading, #spinner-text').addClass('d-none');
            }
        });
    });
    
    $('#searchFormNo').on('submit', function(e) {
        e.preventDefault();
        var searchVal = $('#searchNoValue').val();

        if ($.fn.DataTable.isDataTable('#dataTable_1')) {
            $('#dataTable_1').DataTable().destroy();
            $('#dataTable_1').addClass('d-none');
        }
        if ($.fn.DataTable.isDataTable('#dataTable_2')) {
            $('#dataTable_2').DataTable().destroy();
            $('#dataTable_2').addClass('d-none');
        }
        $('#site_activities_loading, #spinner-text').removeClass('d-none');

        $('#dataTable_2').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "crm/controller_functions.php",
                "type": "POST",
                "data": {
                    search_contact_phone: true,
                    searchPhoneVal: searchVal,
                }
            },
            "columns": [
                { "data": "crm_id", "render": function(data, type, row) {
                    return `<label class="mt-checkbox ${row.checkbox_display || ''}">
                                <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="${data || ''}"/>
                                <span></span>
                            </label>`;
                }},
                { "data": "account_name", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "account_email", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "contact_phone", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "Account_Source", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "status", "render": function(data, type, row) {
                    return `<span class="contact-status">${data || ''}</span>`;
                }},
                { "data": "activity_date", "render": function(data, type, row) {
                    if (data === 'Expired') {
                        return '<span class="font-red bold">Expired Campaign</span>';
                    } else {
                        return data || '';
                    }
                }},
                { "data": "performer_name", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "crm_id", "render": function(data, type, row) {
                    return `<div class="clearfix">
                                <div class="">
                                    <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_details.php?view_id=${data || ''}"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm red tooltips activity-history" id="${data || ''}" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                </div>
                            </div>`;
                }}
            ],
            "initComplete": function(settings, json) {
                $('#dataTable_2').removeClass('d-none');
                $('#site_activities_loading, #spinner-text').addClass('d-none');
            }
        });
    });
    
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        var searchVal = $('#searchValue').val();

        // Destroy any existing DataTable instance to initialize a new one
        if ($.fn.DataTable.isDataTable('#dataTable_1')) {
            $('#dataTable_1').DataTable().destroy();
            $('#dataTable_1').addClass('d-none');
        }
        if ($.fn.DataTable.isDataTable('#dataTable_2')) {
            $('#dataTable_2').DataTable().destroy();
            $('#dataTable_2').addClass('d-none');
        }
        $('#site_activities_loading, #spinner-text').removeClass('d-none');

        // Initialize the DataTable with server-side processing
        $('#dataTable_2').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "crm/controller_functions.php",
                "type": "POST",
                "data": {
                    search_contact: true,
                    searchVal: searchVal,
                }
            },
            "columns": [
                { "data": "crm_id", "render": function(data, type, row) {
                    return `<label class="mt-checkbox ${row.checkbox_display || ''}">
                                <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="${data || ''}"/>
                                <span></span>
                            </label>`;
                }},
                { "data": "account_name", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "account_email", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "contact_phone", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "Account_Source", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "status", "render": function(data, type, row) {
                    return `<span class="contact-status">${data || ''}</span>`;
                }},
                { "data": "activity_date", "render": function(data, type, row) {
                    if (data === 'Expired') {
                        return '<span class="font-red bold">Expired Campaign</span>';
                    } else {
                        return data || '';
                    }
                }},
                { "data": "performer_name", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "crm_id", "render": function(data, type, row) {
                    return `<div class="clearfix">
                                <div class="">
                                    <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_details.php?view_id=${data || ''}"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm red tooltips activity-history" id="${data || ''}" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                </div>
                            </div>`;
                }}
            ],
            "initComplete": function(settings, json) {
                $('#dataTable_2').removeClass('d-none');
                $('#site_activities_loading, #spinner-text').addClass('d-none');
            }
        });
    });
    
    $('#searchFormSource').on('submit', function(e) {
        e.preventDefault();
        var searchVal = $('#searchSourceValue').val();
        
        if ($.fn.DataTable.isDataTable('#dataTable_1')) {
            $('#dataTable_1').DataTable().destroy();
            $('#dataTable_1').addClass('d-none');
        }
        if ($.fn.DataTable.isDataTable('#dataTable_2')) {
            $('#dataTable_2').DataTable().destroy();
            $('#dataTable_2').addClass('d-none');
        }
        $('#site_activities_loading, #spinner-text').removeClass('d-none');
        
        $('#dataTable_2').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "crm/controller_functions.php",
                "type": "POST",
                "data": {
                    search_contact_source: true,
                    searchSourceVal: searchVal,
                }
            },
            "columns": [
                { "data": "crm_id", "render": function(data, type, row) {
                    return `<label class="mt-checkbox ${row.checkbox_display || ''}">
                                <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="${data || ''}"/>
                                <span></span>
                            </label>`;
                }},
                { "data": "account_name", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "account_email", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "contact_phone", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "Account_Source", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "status", "render": function(data, type, row) {
                    return `<span class="contact-status">${data || ''}</span>`;
                }},
                { "data": "activity_date", "render": function(data, type, row) {
                    if (data === 'Expired') {
                        return '<span class="font-red bold">Expired Campaign</span>';
                    } else {
                        return data || '';
                    }
                }},
                { "data": "performer_name", "render": function(data, type, row) {
                    return data || '';
                }},
                { "data": "crm_id", "render": function(data, type, row) {
                    return `<div class="clearfix">
                                <div class="">
                                    <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_details.php?view_id=${data || ''}"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm blue tooltips d-none" data-original-title="Add Task" href="customer_details.php?view_id=${data || ''}"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm red tooltips activity-history" id="${data || ''}" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                </div>
                            </div>`;
                }}
            ],
            "initComplete": function(settings, json) {
                $('#dataTable_2').removeClass('d-none');
                $('#site_activities_loading, #spinner-text').addClass('d-none');
            }
        });
    });
    
    $('#massUploadForm').on('submit', function(e) {
        e.preventDefault();
    
        const formData = new FormData(this);
        var btn = $('#massUploadFormBtn');
        var l = Ladda.create(btn[0]);
    
        l.start();
        formData.append('upload_multiple_contacts', 'upload_multiple_contacts');
        $.ajax({
            url: 'crm/controller_functions.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
    
            success: function(response) {
                var responseParts = response.split('|');
                var status = responseParts[0];
                var message = responseParts[1];
                var success_data = responseParts[2];
                var skipped_data = responseParts[3];
                if (status === 'success') {
                    $.bootstrapGrowl('All contact entries uploaded successfully!', {
                        ele: 'body',
                        type: 'success',
                        offset: { from: 'bottom', amount: 50 },
                        align: 'right',
                        width: 'auto',
                        delay: 4000,
                        allow_dismiss: true,
                        stackup_spacing: 10
                    });
                    $('#modalMultiUpload').modal('hide');
                    $('#massUploadForm')[0].reset();
                } else if (status === 'error') {
                    $('#massUploadResult').modal('show');
                    // Destroy existing DataTable instances before reinitializing
                    initializeDataTable2('#existContactEntriesResult');
                    initializeDataTable2('#insertedContactEntriesResult');
    
                    // Reinitialize DataTable with the new data
                    $('#existContactEntriesResult').DataTable().clear().destroy();
                    $('#insertedContactEntriesResult').DataTable().clear().destroy();
                    $('#existContactEntriesResult tbody').html(skipped_data);
                    $('#insertedContactEntriesResult tbody').html(success_data);
                    initializeDataTable2('#existContactEntriesResult');
                    initializeDataTable2('#insertedContactEntriesResult');
    
                    $('#modalMultiUpload').modal('hide');
                    $('#massUploadForm')[0].reset();
                }
    
                l.stop();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
                l.stop();
            }
        });
    });

    $('#massArchiveForm').on('submit', function(e) {
        e.preventDefault();
    
        const formData = new FormData(this);
        var btn = $('#massArchiveFormBtn');
        var l = Ladda.create(btn[0]);
    
        l.start();
        formData.append('archive_multiple_contacts', 'archive_multiple_contacts');
        $('#modalArchiveContact').modal('hide');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'crm/controller_functions.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
            
                    success: function(response) {
                        var responseParts = response.split('|');
                        var status = responseParts[0];
                        var message = responseParts[1];
                        var success_data = responseParts[2];
                        var notfound_data = responseParts[3];
                        var archive_data = responseParts[4];
                        if (status === 'success') {
                            $.bootstrapGrowl('All contact entries uploaded successfully!', {
                                ele: 'body',
                                type: 'success',
                                offset: { from: 'bottom', amount: 50 },
                                align: 'right',
                                width: 'auto',
                                delay: 4000,
                                allow_dismiss: true,
                                stackup_spacing: 10
                            });
                            $('#massArchiveForm')[0].reset();
                        } else if (status === 'error') {
                            $('#massArchivedResult').modal('show');
                            initializeDataTable2('#notfound_result');
                            initializeDataTable2('#archive_result');
                            initializeDataTable2('#skipped_result');
                            $('#notfound_result').DataTable().clear().destroy();
                            $('#archive_result').DataTable().clear().destroy();
                            $('#skipped_result').DataTable().clear().destroy();
                            $('#notfound_result tbody').html(notfound_data);
                            $('#archive_result tbody').html(success_data);
                            $('#skipped_result tbody').html(archive_data);
                            initializeDataTable2('#notfound_result');
                            initializeDataTable2('#archive_result');
                            initializeDataTable2('#skipped_result');
                            $('#massArchiveForm')[0].reset();
                        }
            
                        l.stop();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                        l.stop();
                    }
                });
            } else {
                $('#modalArchiveContact').modal('show');
                l.stop();
            }
          });
    });
    
    get_counts()
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
    function get_counts() {
        $.ajax({
            url: "crm/controller_functions.php",
            type: "POST",
            data: { get_counts: true },
            success: function(response) {
                response = JSON.parse(response);
                var campaign = numberWithCommas(response.campaignCount);
                var contact = numberWithCommas(response.relationshipCount);
                var campainer = numberWithCommas(response.campaignerCount);
                var average = numberWithCommas(response.campaignAverage);
                var expires = numberWithCommas(response.expiredCampaigns);
                var archives = numberWithCommas(response.archivedContacts);
              
                $('#campaignCount').text(campaign);
                $('#contactCount').text(contact);
                $('#activeCampaignerCount').text(campainer);
                $('#monthlyCampaignAverage').text(average);
                $('#archivedContacts').text(archives);
                $('#expiredCampaigns').text(expires);
            }
        });
    }

    get_campaigns()
        function get_campaigns() {
            if ($.fn.DataTable.isDataTable('#campaignsArea')) {
            $('#campaignsArea').DataTable().destroy();
        }
        $.ajax({
            url: "crm/controller_functions.php",
            type: "POST",
            data: { get_campaigns_per_subject: true },
            success: function(response) {
                $('#campaignsArea tbody').html(response);
                initializeDataTable2('#campaignsArea');
            }
        });
    }

    $(document).on('click', '#stop-campaigns', function(e) {
        e.preventDefault()
        $.ajax({
            url: "crm/controller_functions.php",
            method: "POST",
            data: { stop_campaigns: true},
            success: function(response) {
               console.log(response)
            }
        });
    });
    
    graphs();
        function graphs() {
        $.ajax({
            url: "crm/controller_functions.php",
            type: "POST",
            data: { get_graphs: true },
            success: function(responses) {
                var response = JSON.parse(responses);
            }
        });
    }
    
    get_task()
    function get_task() {
        if ($.fn.DataTable.isDataTable('#pendingTaskTable')) {
            $('#pendingTaskTable').DataTable().destroy();
        }
        if ($.fn.DataTable.isDataTable('#completedTaskTable')) {
            $('#completedTaskTable').DataTable().destroy();
        }
        $.ajax({
            url: "crm/controller_functions.php",
            method: "POST",
            data: { get_user_task: true },
            success: function(response) {
                var response = JSON.parse(response) 
                $('#pendingTaskTable tbody').html(response.pending);
                $('#completedTaskTable tbody').html(response.completed);
                initializeDataTable2('#pendingTaskTable');
                initializeDataTable2('#completedTaskTable');
            }
        });
    }
    
    get_user_campaigns()
    function get_user_campaigns() {
        if ($.fn.DataTable.isDataTable('#userCampaignListResult')) {
            $('#userCampaignListResult').DataTable().destroy();
        }
        $.ajax({
            url: "crm/controller_functions.php",
            method: "POST",
            data: { get_user_campaigns: true },
            success: function(response) {
                $('#userCampaignListResult tbody').html(response);
                initializeDataTable2('#userCampaignListResult');
            }
        });
    }
    
    $(document).on('click', '.campaignListPerSubject', function(e) {
        e.preventDefault()
        var subject_name = $(this).data('value');
        $('#site_activities_loading, #spinner-text').removeClass('d-none');
        $('#campaignListAsPerSubject').addClass('d-none');
        if ($.fn.DataTable.isDataTable('#campaignListAsPerSubject')) {
            $('#campaignListAsPerSubject').DataTable().destroy();
        }
        $.ajax({
            url: "crm/controller_functions.php",
            method: "POST",
            data: { group_campaign_list_by_subject: true, subject: subject_name },
            success: function(response) {
                $('#campaignListAsPerSubject tbody').html(response);
                initializeDataTable2('#campaignListAsPerSubject');
                $('#site_activities_loading, #spinner-text').addClass('d-none');
                $('#campaignListAsPerSubject').removeClass('d-none');
            }
        });
    });
    
    $(document).on('click', '.viewCampaignMessage', function(e) {
        e.preventDefault()
        var campaignid = $(this).data('id');
        $('#site_campaign_loading, #campaign-text').removeClass('d-none');
        $('#campaignMessageBody').addClass('d-none');
        $.ajax({
            url: "crm/controller_functions.php",
            method: "POST",
            data: { get_campaign_message_content: true, campaignid: campaignid },
            success: function(response) {
                $('#campaignMessageBody').html(response);
                $('#site_campaign_loading, #campaign-text').addClass('d-none');
                $('#campaignMessageBody').removeClass('d-none');
            }
        });
    })
    
    $(document).on('click', '.edit-assigned-task', function(e) {
        e.preventDefault();
        var taskid = $(this).data('id');
        $.ajax({
            url: "crm/controller_functions.php",
            method: "POST",
            data: { get_task_details: true, taskid: taskid },
            success: function(response) {
                var response = JSON.parse(response);
                $('#task-name').val(response.name);
                $('#old-assigned').val(response.email);
                $('#description').val(response.description);
                $('#assigned-to').text(response.assignedto);
                $('#taskid').val(response.id);
                // Format start date and due date
                $('#startdate').val(formatDate(response.startdate));
                $('#duedate').val(formatDate(response.duedate));
                var status = response.status;
                $('#task-status option').removeAttr('selected');
                $('#task-status option[value="' + status + '"]').attr('selected', 'selected');
            }
        });
    });
    
    $('#updateTaskForm').on('submit', function(e) {
        e.preventDefault()
        const formData = new FormData(this);
        formData.append('update_task', 'update_task');
        
        $.ajax({
            url: 'crm/controller_functions.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false, 
            success: function (response) {
                response = JSON.parse(response);
                $.bootstrapGrowl('Task updated successfully!', {
                  ele: 'body',
                  type: 'success',
                  offset: {from: 'bottom', amount: 50},
                  align: 'right',
                  width: 'auto',
                  delay: 4000,
                  allow_dismiss: true,
                  stackup_spacing: 10
                });
                $('#modalEditTaskForm').modal('hide');
                get_task()
            },
            error: function (error) {
                response = JSON.parse(response);
                $.bootstrapGrowl('Something went wrong! Please try again.', {
                  ele: 'body',
                  type: 'danger',
                  offset: {from: 'bottom', amount: 50},
                  align: 'right',
                  width: 'auto',
                  delay: 4000,
                  allow_dismiss: true,
                  stackup_spacing: 10
                });
            }
        })
    })
    
    $('#updateCampaignForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('update_campaign', 'update_campaign');
        var subject = $('#campaign-subject').val();
        
        $.ajax({
            url: 'crm/controller_functions.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false, 
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    $.bootstrapGrowl('Campaign updated successfully!', {
                        ele: 'body',
                        type: 'success',
                        offset: {from: 'bottom', amount: 50},
                        align: 'right',
                        width: 'auto',
                        delay: 4000,
                        allow_dismiss: true,
                        stackup_spacing: 10
                    });
                    $('#modalCampaignDetails').modal('hide');
                    // get_campaign_by_name(subject);
                } catch (e) {
                    console.error("Error parsing JSON response:", e);
                }
            },
            error: function (error) {
                try {
                    error = JSON.parse(error);
                    console.log(error);
                    $.bootstrapGrowl('Something went wrong! Please try again.', {
                        ele: 'body',
                        type: 'danger',
                        offset: {from: 'bottom', amount: 50},
                        align: 'right',
                        width: 'auto',
                        delay: 4000,
                        allow_dismiss: true,
                        stackup_spacing: 10
                    });
                } catch (e) {
                    console.error("Error parsing JSON error response:", e);
                }
            }
        });
    });
    
    get_user_contributions()
    function get_user_contributions() {
        $.ajax({
            url: "crm/controller_functions.php",
            type: "POST",
            data: { user_contributions: true },
            success: function(response) {
                response = JSON.parse(response);
                var campaign    =   numberWithCommas(response.campaignCount);
                var contact     =   numberWithCommas(response.userContacts);
                var today       =   numberWithCommas(response.campaignSentToday);
                var average     =   numberWithCommas(response.dailyAverage);
                var expires     =   numberWithCommas(response.expiredCampaigns);
                var archives     =   numberWithCommas(response.archivedContacts);
              
                $('#userCampaigns').text(campaign);
                $('#userContacts').text(contact);
                $('#userSentToday').text(today);
                $('#userDailyAverage').text(average);
                $('#userExpiredCampaigns').text(expires);
                $('#userArchiveContacts').text(archives);
            }
        });
    }

    function formatDate(date) {
        var formattedDate = new Date(date);
        var year = formattedDate.getFullYear();
        var month = (formattedDate.getMonth() + 1).toString().padStart(2, '0');
        var day = formattedDate.getDate().toString().padStart(2, '0');
        return year + '-' + day + '-' + month;
    }
    
    $(document).on('click', '.campaignDetails', function(e) {
        e.preventDefault();
        var campaignid = $(this).data('id');
        $.ajax({
            url: "crm/controller_functions.php",
            method: "POST",
            data: { get_campaign_details: true, id: campaignid },
            success: function(response) {
                var response = JSON.parse(response);
                $('#campaignid').val(response.id);
                $('#campaign-name').val(response.name);
                $('#campaign-subject').val(response.subject);
                $('#campaign-recipient').val(response.recipient);
    
                var frequency = response.frequency;
                $('#campaign-frequency option').removeAttr('selected');
                $('#campaign-frequency option[value="' + frequency + '"]').attr('selected', 'selected');
                var status = response.status;
                $('#campaign-status option').removeAttr('selected');
                $('#campaign-status option[value="' + status + '"]').attr('selected', 'selected');
                $('#campaign-message').summernote({
                    height: 800
                });
                $('#campaign-message').summernote('code', response.message);
                
            }
        });
    });
    
    $(document).on('click', '.activity-history', function() {
        let id = $(this).attr('id');
        $.ajax({
            url: '/crm/controller_functions.php',
            type: 'POST',
            data: {
                id: id,
                get_activity_history: true
            },
            success: function(response) {
                $('#activity-history .modal-body').html(response);
            }
        })
    })

    $(document).on('click', '.get-task-notes', function(e) {
        e.preventDefault();
        var taskid = $(this).data('id');
        var contactid = $(this).data('value');
        $('#task-id').val(taskid)
        $('#contact-id').val(contactid)
        $('#site_activities_loading, #spinner-text').removeClass('d-none');
        $('#noteList').addClass('d-none');
        $.ajax({
            url: 'crm/controller_functions.php',
            type: 'POST',
            data: {
                get_task_notes: true,
                taskid: taskid
            },
            success: function(response) {
                if ($.fn.DataTable.isDataTable('#noteList')) {
                    $('#noteList').DataTable().destroy();
                }
                $('#noteList tbody').html(response);
                initializeDataTable2('#noteList');
                $('#site_activities_loading, #spinner-text').addClass('d-none');
                $('#noteList').removeClass('d-none');
            }
        });
    });

    function get_tasknotes_by_id(id) {
        $.ajax({
            url: 'crm/controller_functions.php',
            type: 'POST',
            data: {
                get_task_notes: true,
                taskid: id
            },
            success:function(response) {
                if ($.fn.DataTable.isDataTable('#noteList')) {
                    $('#noteList').DataTable().destroy();
                }
                $('#noteList tbody').html(response);
                initializeDataTable2('#noteList');
            }
        })
    }

    function get_campaign_by_name(subject) {
        $.ajax({
            url: 'crm/controller_functions.php',
            type: 'POST',
            data: {
                group_campaign_list_by_subject: true,
                subject: subject
            },
            success:function(response) {
                if ($.fn.DataTable.isDataTable('#dataTable_5')) {
                    $('#dataTable_5').DataTable().destroy();
                }
                $('#dataTable_5 tbody').html(response);
                initializeDataTable2('#dataTable_5');
            }
        })
    }
    
    $('#noteForm').on('submit', function(e) {
        e.preventDefault()
        const formData = new FormData(this);
        var id = $('#task-id').val()
        formData.append('add_notes', 'add_notes');
        var btn = $('#noteFormBtn');
        var l = Ladda.create(btn[0]);
        l.start();
        $.ajax({
            url: 'crm/controller_functions.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $.bootstrapGrowl('Notes Added!', {
                    ele: 'body',
                    type: 'success',
                    offset: { from: 'bottom', amount: 50 },
                    align: 'right',
                    width: 'auto',
                    delay: 4000,
                    allow_dismiss: true,
                    stackup_spacing: 10
                });
                l.stop();
                $('#modalAddNotes').modal('hide');
                get_tasknotes_by_id(id)
            }
        });
    })

    $('#taskForm').on('submit', function(e) {
        e.preventDefault()
        const formData = new FormData(this);
        formData.append('add_task', 'add_task');
        var btn = $('#taskFormBtn');
        var l = Ladda.create(btn[0]);
        l.start();
        $.ajax({
            url: 'crm/controller_functions.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $.bootstrapGrowl('Task Added!', {
                    ele: 'body',
                    type: 'success',
                    offset: { from: 'bottom', amount: 50 },
                    align: 'right',
                    width: 'auto',
                    delay: 4000,
                    allow_dismiss: true,
                    stackup_spacing: 10
                });
                l.stop();
                $('#modalTaskForm').modal('hide');
                get_task()
            }
        });
    })

    $(document).on('click', '.get-note-details', function() {
        var noteid = $(this).data('id')
        $.ajax({
            url: 'crm/controller_functions.php',
            type: 'POST',
            data: {
                get_note_details: true,
                noteid: noteid
            },
            success: function(response) {
                var response = JSON.parse(response);
                $('#notes-v').val(response.notes);
                $('#notes-id').val(response.notesid);
            }
        })
    })

    $('#updateNotesForm').on('submit', function(e) {
        e.preventDefault()
        const formData = new FormData(this)
        formData.append('update_notes', 'update_notes')
        var btn = $('#noteFormBtn');
        var l = Ladda.create(btn[0]);
        var id = $('#task-id').val()
        l.start();
        $.ajax({
            url: 'crm/controller_functions.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $.bootstrapGrowl('Notes Updated Successfully!', {
                    ele: 'body',
                    type: 'success',
                    offset: { from: 'bottom', amount: 50 },
                    align: 'right',
                    width: 'auto',
                    delay: 4000,
                    allow_dismiss: true,
                    stackup_spacing: 10
                });
                l.stop();
                get_tasknotes_by_id(id)
                $('#modalNoteDetails').modal('hide');
            }
        });
    })
    
    $(document).on('click', '.view-content', function() {
        let type = $(this).data('id');
        let action_id = $(this).attr('id');
        console.log(type)
        console.log(action_id)
        $.ajax({
            url: '/crm/controller_functions.php',
            type: 'POST',
            data: {
                type: type,
                action_id: action_id,
                get_content_message: true
            },
            success: function(response) {
                $('#view-content .modal-body').html(response);
            }
        })
    })
    // end Marvin's script
    
    // Emjay script starts here
    fancyBoxes();
    $('#save_video').click(function(){
        
        $('#save_video').attr('disabled','disabled');
        $('#save_video_text').text("Uploading...");
        var action_data = "supplier";
        var user_id = $('#switch_user_id').val();
        var privacy = $('#privacy').val();
        var file_title = $('#file_title').val();
        
         var fd = new FormData();
         var files = $('#file')[0].files;
         fd.append('file',files[0]);
         fd.append('action_data',action_data);
         fd.append('user_id',user_id);
         fd.append('privacy',privacy);
         fd.append('file_title',file_title);
         
		 $.ajax({
			method:"POST",
			url:"controller.php",
			data:fd,
			processData: false, 
            contentType: false,  
            timeout: 6000000,
			success:function(data) {
				console.log('done : ' + data);
				if(data == 1){
				    window.location.reload();
				}
				else{
				    $('#message').html('<span class="text-danger">Invalid Video Format</span>');
				}
			}
	    });
	}); // Emjay script ends here 
});