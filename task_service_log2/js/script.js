Init.baseUrl = 'task_service_log2/services/index.php?';
const ServiceLogsInstance = {};

jQuery(function () {
    ServiceLogsInstance.logs = initServiceLogs();
    const overtimeForApprovalLogs = initForApprovalLogs();
    const vaSummaryTable = initVASummaryTable();
    
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

    $('[data-service-log-tab]').on('click', function() {
        const tabTitle = this.dataset.serviceLogTab || 'Service Logs';
        $('#serviceLogsCardTitle').text(tabTitle);
    });
});