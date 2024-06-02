$(document).ready(function() {
    var universalId = $('#universal_id').data('id');

    // function initializeDataTable(selector) {
    //     if ($.fn.DataTable.isDataTable(selector)) {
    //         $(selector).DataTable().destroy();
    //     }
    //     return $(selector).dataTable({
    //         language: {
    //             aria: {
    //                 sortAscending: ": activate to sort column ascending",
    //                 sortDescending: ": activate to sort column descending"
    //             },
    //             emptyTable: "No data available in table",
    //             info: "Showing _START_ to _END_ of _TOTAL_ entries",
    //             infoEmpty: "No entries found",
    //             infoFiltered: "(filtered1 from _MAX_ total entries)",
    //             lengthMenu: "_MENU_ entries",
    //             search: "Search:",
    //             zeroRecords: "No matching records found"
    //         },
    //         buttons: [
    //             { extend: 'print', className: 'btn default' },
    //             { extend: 'pdf', className: 'btn red' },
    //             { extend: 'csv', className: 'btn green' }
    //         ],
    //         order: [
    //             [0, 'DESC']
    //         ],
    //         lengthMenu: [
    //             [5, 10, 15, 20],
    //             [5, 10, 15, 20]
    //         ],
    //         pageLength: 5,
    //         searching: true,
    //         dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
    //     });
    // }

    function formatDate(date) {
        // Split the date string into components
        var parts = date.split('/');
        var year = parts[0];
        var day = parts[1];
        var month = parts[2];
        return year + '/' + day + '/' + month;
    }

    function generateStatusHtml(response) {
        const statuses = [
            { value: "Active", label: "Active" },
            { value: "In-Active", label: "In-Active" },
            { value: "Manual", label: "Manual" },
            { value: "0", label: "Archive" }
        ];

        let selectedValue = response.flag == 0 ? "0" : response.account_status;

        let html = '<label class="control-label"><strong>Status</strong></label><br>';
        statuses.forEach((status, index) => {
            html += `<input type="radio" class="form-check-input" name="account_status" value="${status.value}" ${status.value === selectedValue ? 'checked' : ''}>`;
            html += `<label class="control-label"> &nbsp${status.label}</label> &nbsp;&nbsp;&nbsp;`;

            if ((index + 1) % 2 === 0) {
                html += '<br>';
            }
        });
        return html;
    }

    function generateDirectoryHtml(selectedValue) {
        const directories = [
            { value: "1", label: "Show" },
            { value: "0", label: "Hide" }
        ];

        let html = '<label class="control-label"><strong>Directory</strong></label><br>';
        directories.forEach(directory => {
            html += `<input type="radio" class="form-check-input" name="Account_Directory" value="${directory.value}" ${directory.value === selectedValue ? 'checked' : ''}>`;
            html += `<label class="control-label">&nbsp ${directory.label}</label> &nbsp;&nbsp;&nbsp;`;
        });
        return html;
    }

    $('#accountDetailsForm').on('submit', function(e) {
        e.preventDefault()
        const formData = new FormData(this)
        formData.append('update_contact_details', 'update_contact_details');

        $.post({
            url: 'crm/customer_details.php',
            processData: false,
            contentType: false, 
            data: formData,
            success: function(response) {
                $.bootstrapGrowl('Details updated!', {
                    ele: 'body',
                    type: 'success',
                    offset: { from: 'bottom', amount: 50 },
                    align: 'right',
                    width: 'auto',
                    delay: 4000,
                    allow_dismiss: true,
                    stackup_spacing: 10
                });
            }
        })
    })
    
    $('#taskForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('add_task', 'add_task');
        var btn = $('#taskFormBtn');
        var l = Ladda.create(btn[0]);
        l.start();
        $.ajax({
            url: 'crm/customer_details.php',
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
                $('#taskForm')[0].reset();
                get_tasks();
            }
        });
    });

    $(document).on('click', '.edit-btn', function(e) {
        e.preventDefault();
        var taskid = $(this).data('id');
        $.ajax({
            url: 'crm/customer_details.php',
            method: "POST",
            data: { get_task_details: true, taskid: taskid },
            success: function(response) {
                var response = JSON.parse(response);
                $('#task-name').val(response.name);
                $('#old-assigned').val(response.email);
                $('#description').val(response.description);
                $('#assigned-to').text(response.assignedto);
                $('#taskid').val(response.id);
                $('#startdate').val(response.startdate);
                $('#duedate').val(response.duedate);
                var status = response.status;
                $('#task-status option').removeAttr('selected');
                $('#task-status option[value="' + status + '"]').attr('selected', 'selected');
            }
        });
    });
    
    $('#updateTaskForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('update_task', 'update_task');
        
        $.ajax({
            url: 'crm/customer_details.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                try {
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
                    get_tasks();
                } catch (e) {
                    $.bootstrapGrowl('Invalid response from server.', {
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
            }
        });
    });

    $('#noteForm').on('submit', function(e) {
        e.preventDefault()
        const formData = new FormData(this);
        var id = $('#task-id').val()
        formData.append('add_notes', 'add_notes');
        var btn = $('#noteFormBtn');
        var l = Ladda.create(btn[0]);
        l.start();
        $.ajax({
            url: 'crm/customer_details.php',
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
                $('#noteForm')[0].reset();
                get_notes()
            }
        });
    })

    $(document).on('click', '.edit-notes-btn', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: 'crm/customer_details.php',
            method: "POST",
            data: { get_notes_details: true, id: id },
            success: function(response) {
                var response = JSON.parse(response);
                $('#notes-id').val(response.notesid);
                $('#notes').text(response.notes);
            }
        });
    });

    $('#updateNotesForm').on('submit', function(e) {
        e.preventDefault()
        const formData = new FormData(this)
        formData.append('update_notes', 'update_notes')
        var btn = $('#noteFormBtn');
        var l = Ladda.create(btn[0]);
        l.start();
        $.ajax({
            url: 'crm/customer_details.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response)
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
                get_notes()
                $('#updateNotesModal').modal('hide');
            }
        });
    })

    // Contacts
    $('#contactForm').on('submit', function(e) {
        e.preventDefault()
        const formData = new FormData(this);
        var id = $('#task-id').val()
        formData.append('add_contact', 'add_contact');
        var btn = $('#noteFormBtn');
        var l = Ladda.create(btn[0]);
        l.start();
        $.ajax({
            url: 'crm/customer_details.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $.bootstrapGrowl('Contact Added!', {
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
                $('#contactModal').modal('hide');
                $('#contactForm')[0].reset();
                get_contacts();
            }
        });
    })

    $(document).on('click', '.edit-contact-btn', function(e) {  
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: 'crm/customer_details.php',
            method: "POST",
            data: { get_contact_infos: true, id: id },
            success: function(response) {
                console.log(response)
                var response = JSON.parse(response);
                $('#contact_info_id').val(response.id);
                $('#contact_info_title').val(response.title);
                $('#contact_info_first').val(response.first);
                $('#contact_info_last').val(response.last);
                $('#contact_info_report').val(response.report_to);
                $('#contact_info_address').val(response.address);
                $('#contact_info_phone').val(response.phone);
                $('#contact_info_email').val(response.email);
                $('#contact_info_fax').val(response.fax);
                $('#contact_info_website').val(response.website);
                $('#contact_info_facebook').val(response.facebook);
                $('#contact_info_twitter').val(response.twitter);
                $('#contact_info_linkedin').val(response.linkedin);
                $('#contact_info_interlink').val(response.interlink);
            }
        });
    });

    $('#updateContact').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('update_contact', 'update_contact');
        var btn = $('#noteFormBtn');
        var l = Ladda.create(btn[0]);
        l.start();
        $.ajax({
            url: 'crm/customer_details.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $.bootstrapGrowl('Contact Updated Successfully!', {
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
                $('#updateContactModal').modal('hide');
                $('#updateContact')[0].reset();
                get_contacts();
            }
        });
    });

    $('#referenceForm').submit(function(e) {
        e.preventDefault();
        var fileInput = $('#referenceFile');
        var file = fileInput[0].files[0];

        // Check if a file is selected
        if (!file) {
            alert("Please select a file.");
            return;
        }

        // Validate file type
        var allowedTypes = ['image/jpeg', 'image/png', 'application/pdf', 'text/csv', 'application/msword', 'application/vnd.ms-excel'];
        if (allowedTypes.indexOf(file.type) === -1) {
            alert("Invalid file type. Please upload an image, PDF, CSV, Word document, or Excel spreadsheet.");
            return;
        }

        // Submit form if file is valid
        var formData = new FormData(this);
        formData.append('add_references', 'add_references');
        $.post({
            url: 'crm/customer_details.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $.bootstrapGrowl('Reference Added!', {
                    ele: 'body',
                    type: 'success',
                    offset: { from: 'bottom', amount: 50 },
                    align: 'right',
                    width: 'auto',
                    delay: 4000,
                    allow_dismiss: true,
                    stackup_spacing: 10
                });
                $('#addReference').modal('hide');
                $('#referenceForm')[0].reset();
                get_references()
            },
            error: function(xhr, status, error) {
                alert("Error uploading file.");
                console.error(xhr.responseText);
            }
        });
    });

    $('#updateReferenceForm').submit(function(e) {
        e.preventDefault();
        var fileInput = $('#updateReferenceFile');

        var file = fileInput[0].files[0];

        // Validate file type
        var allowedTypes = ['image/jpeg', 'image/png', 'application/pdf', 'text/csv', 'application/msword', 'application/vnd.ms-excel'];
        if (file && allowedTypes.indexOf(file.type) === -1) {
            alert("Invalid file type. Please upload an image, PDF, CSV, Word document, or Excel spreadsheet.");
            return;
        }

        var formData = new FormData(this);
        formData.append('update_references', 'update_references');

        $.ajax({
            url: 'crm/customer_details.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $.bootstrapGrowl('Reference Updated Successfully!', {
                    ele: 'body',
                    type: 'success',
                    offset: { from: 'bottom', amount: 50 },
                    align: 'right',
                    width: 'auto',
                    delay: 4000,
                    allow_dismiss: true,
                    stackup_spacing: 10
                });
                $('#updateReference').modal('hide');
                $('#updateReferenceForm')[0].reset();
                get_references()
            },
            error: function(xhr, status, error) {
                alert("Error updating file.");
                console.error(xhr.responseText);
            }
        });
    });

    $(document).on('click', '.edit-reference-btn', function(e) {  
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: 'crm/customer_details.php',
            method: "POST",
            data: { get_references_details: true, id: id },
            success: function(response) {
                console.log(response)
                var response = JSON.parse(response);
                $('#reference-id').val(response.id);
                $('#reference-old-file').val(response.documents);
                $('#reference-title').val(response.title);
                $('#old-document-container').html(
                    `<span><strong>Current: </strong> <i class="bi bi-file"></i> &nbsp; ${response.documents} </span><a href="Customer_Relationship_files_Folder/${response.documents}" target="_blank"> &nbsp; | &nbsp; View</a>`
                    );
                $('#response-title').val(response.title);
                $('#reference-description').val(response.description);
                $('#reference-added').val(response.added);
                $('#reference-ended').val(response.end);
            }
        });
    });

    $('#updateAbout').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('update_about', 'update_about');
        var btn = $('#aboutBtn');
        var l = Ladda.create(btn[0]);
        l.start();
        $.ajax({
            url: 'crm/customer_details.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $.bootstrapGrowl('Details Updated Successfully!', {
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
            }
        });
    });
    
    $('#updateProduct').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('update_product_services', 'update_product_services');
        var btn = $('#productBtn');
        var l = Ladda.create(btn[0]);
        l.start();
        $.ajax({
            url: 'crm/customer_details.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response)
                $.bootstrapGrowl('Details Updated Successfully!', {
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
            }
        });
    });

    $('#campaignForm').on('submit', function(e) {
        e.preventDefault()
        const formData = new FormData(this);
        var id = $('#task-id').val()
        formData.append('add_notes', 'add_notes');
        var btn = $('#noteFormBtn');
        var l = Ladda.create(btn[0]);
        l.start();
        $.ajax({
            url: 'crm/customer_details.php',
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
                $('#addCampaignModal').modal('hide');
                $('#campaignForm')[0].reset();
                get_contact_campaigns()
            }
        });
    })

    $(document).on('click', '.edit-campaign-btn', function(e) {  
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: 'crm/customer_details.php',
            method: "POST",
            data: { get_campaign_details: true, id: id },
            success: function(response) {
                var response = JSON.parse(response);
                $('#campaign-id').val(response.id);
                $('#campaign-name').val(response.campaign);
                $('#campaign-recipient').val(response.recipient);
                $('#campaign-subject').val(response.subject);
                $('#campaign-message').summernote('code', response.message);
                $('#campaign-status').val(response.status == 0 ? '0' : '1');
            }
        });
    });

    $('#updateCampaignForm').on('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('update_campaign', 'update_campaign');

    $.ajax({
        url: 'crm/customer_details.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response);
            response = JSON.parse(response);

            if(response.status === "success") {
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
            } else if(response.status === "info") {
                $.bootstrapGrowl(response.message, {
                    ele: 'body',
                    type: 'info',
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

            $('#campaignDetailsModal').modal('hide');
            get_contact_campaigns();
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ' + status + error);
            $.bootstrapGrowl('An error occurred while updating the campaign.', {
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
});

})

    
