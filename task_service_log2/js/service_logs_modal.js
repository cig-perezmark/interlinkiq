
jQuery(function() {
    $('#addServiceLogModalForm').on('submit', function(e) {
        e.preventDefault();

        const form = e.currentTarget;
        const inputError = checkServiceLogsFormInputs(form);

        if(inputError !== true) {
            return showServiceLogFormAlert('error', inputError);
        }

        // remove alerts
        showServiceLogFormAlert(null);

        const data = new FormData(form);

        $.ajax({
            url: "task_service_log2/services/index.php?add_log",
            type: "POST",
            contentType: false,
            processData: false,
            data,
            success: function({ data, message }) {
                form.description.value = '';
                form.comment.value = '';
                form.minute.value = '';
                $('#task_action').multiselect('select', '');
                $('#task_action').multiselect('refresh');

                // append new log to the table
                ServiceLogsInstance?.logs.add(data);

                $('#addServiceLogModal').modal('hide');
                bootstrapGrowl(message || 'Successfully recorded.');
            },
            error: function() {
                showServiceLogFormAlert('error', 'An error has occured. Unable to save your task.');
            },
        });
    });
});

function showServiceLogFormAlert(type /* error | success */, message = '') {
    // reset alerts
    $('[data-service-log-alert]').hide();
    $('[data-service-log-alert] [data-message]').html('');

    if(type === null) {
        return;
    }
    
    // show intended alert
    $(`[data-service-log-alert="${type}"] [data-message]`).html(message);
    $(`[data-service-log-alert="${type}"]`).fadeIn();
}

// Check if service log form fields are filled
function checkServiceLogsFormInputs(form) {
    if (form.description.value.trim() === '') {
        return 'Task <strong>description</strong> is required.';
    } else if (form.action.value.trim() === '') {
        return 'Please select an appropriate <strong>action</strong> for the task.'; 
    } else if (form.comment.value.trim() === '') {
        return 'A <strong>comment</strong> is required.';
    } else if (form.account.value.trim() === '') {
        return '<strong>Account</strong> information is required.';
    } else if (form.task_date.value.trim() === '') {
        return 'Please select a valid <strong>task date</strong>.';
    } else if ((parseFloat(form.minute.value) || 0) <= 0) {
        return 'Please enter a valid number of <strong>minutes</strong> greater than zero.';
    }
    
    return true;
}