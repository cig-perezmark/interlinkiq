function addNewServiceLog() {
    $.ajax({
        url: "task_service_log2/services/index.php?add_log",
        type: "GET",
        contentType: false,
        processData: false,
        success: function({data}) {
            // sl.update(data);
        },
        error: function() {
            bootstrapGrowl('Error fetching service logs!');
        },
        complete: () => {
            // callback && callback();
        }
    });
}

jQuery(function() {
    $('#addServiceLogModal').on('submit', function(e) {
        e.preventDefault();

        const form = e.currentTarget;
        
    })
})