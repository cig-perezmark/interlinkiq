Init.baseUrl = 'task_service_log/services/index.php?';

jQuery(function () {
    const serviceLogs = initServiceLogs();
    
    $('#refreshServiceLogsTableBtn').on('click', function() {
        const btn = $(this);

        if(btn.hasClass('disabled-by-action')) {
            console.log('Refresh action has been cancelled, task is already in queue...')
            return;
        }

        btn.addClass('disabled-by-action');
        document.body.classList.add('is-loading');

        serviceLogs.fetch(function() {
            btn.removeClass('disabled-by-action');
            document.body.classList.remove('is-loading');
        });
    })
});