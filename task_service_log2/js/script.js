Init.baseUrl = 'task_service_log/services/index.php?';
const ServiceLogsInstance = {};

jQuery(function () {
    ServiceLogsInstance.logs = initServiceLogs();
    const overtimeForApprovalLogs = initForApprovalLogs();
    
    $('#refreshServiceLogsTableBtn').on('click', function() {
        const btn = $(this);

        if(btn.hasClass('disabled-by-action')) {
            console.log('Refresh action has been cancelled, task is already in queue...')
            return;
        }

        btn.addClass('disabled-by-action');
        document.body.classList.add('is-loading');

        ServiceLogsInstance.logs.fetch(function() {
            btn.removeClass('disabled-by-action');
            document.body.classList.remove('is-loading');
        });
    })
});