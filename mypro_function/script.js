// Helper function to determine row hierarchy level based on colspan
function getRowLevel(row) {
    let level = 0;
    
    // Look for td elements with colspan attribute (excluding the first td with ID)
    row.find('td').each(function(index) {
        let td = $(this);
        // Skip the first td (which contains the ID)
        if (index === 0) return true;
        
        // Check if this td has colspan and has class "child_border"
        if (td.hasClass('child_border') && td.attr('colspan')) {
            level = parseInt(td.attr('colspan')) || 0;
            return false; // Stop after finding the first colspan
        }
    });
    
    console.log('Row level for', row.attr('id'), ':', level);
    return level;
}

/**
 * Build HTML content for history logs display
 * @param {Array} logs - Array of log entries
 * @param {Number} totalLogs - Total number of logs
 * @returns {String} HTML content
 */
function buildHistoryLogsHTML(logs, totalLogs) {
    let html = '<div class="history-logs-container" style="max-height: 500px; overflow-y: auto; text-align: left;">';
    
    logs.forEach(function(log, index) {
        html += `
            <div class="log-entry" style="background: #f8f9fa; padding: 15px; margin-bottom: 15px; border-radius: 8px; border-left: 4px solid #667eea;">
                <div style="margin-bottom: 10px;">
                    <strong style="color: #333; font-size: 16px;">Log #${log.log_id}</strong>
                    <span style="float: right; color: #666; font-size: 13px;">${log.deleted_at || 'N/A'}</span>
                </div>
                
                <div style="margin: 8px 0; color: #555;">
                    <strong>Deleted by:</strong> ${log.deleted_by || 'Unknown'}
                </div>
                
                <div style="margin: 8px 0; color: #555;">
                    <strong>Reason:</strong> ${log.reasons || 'No reason provided'}
                </div>
        `;
        
        // Add deleted items details if available
        if (log.deleted_items_details && log.deleted_items_details.length > 0) {
            html += `
                <div style="margin-top: 12px;">
                    <strong style="color: #333;">Deleted Items (${log.total_deleted_items}):</strong>
                    <ul style="list-style: none; padding-left: 0; margin-top: 8px;">
            `;
            
            log.deleted_items_details.forEach(function(item) {
                let typeLabel = getItemTypeLabel(item.prefix);
                let badgeColor = getItemTypeBadgeColor(item.prefix);
                
                html += `
                    <li style="padding: 8px; margin: 5px 0; background: white; border-radius: 5px; font-size: 14px;">
                        <span style="display: inline-block; background: ${badgeColor}; color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: bold; margin-right: 8px;">
                            ${item.prefix.toUpperCase()}
                        </span>
                        <span style="color: #333; font-weight: 500;">${item.item_name}</span>
                        <span style="color: #999; font-size: 12px; margin-left: 8px;">(${typeLabel})</span>
                    </li>
                `;
            });
            
            html += `
                    </ul>
                </div>
            `;
        } else {
            html += `
                <div style="margin-top: 12px; color: #999; font-style: italic;">
                    No item details available
                </div>
            `;
        }
        
        html += `</div>`; // Close log-entry
    });
    
    html += '</div>';
    
    return html;
}

/**
 * Get human-readable label for item type based on prefix
 * @param {String} prefix - Item prefix (s, h, or i)
 * @returns {String} Type label
 */
function getItemTypeLabel(prefix) {
    switch(prefix) {
        case 's': return 'Service';
        case 'h': return 'History';
        case 'i': return 'Action Item';
        default: return 'Unknown';
    }
}

/**
 * Get badge color for item type based on prefix
 * @param {String} prefix - Item prefix (s, h, or i)
 * @returns {String} Color hex code
 */
function getItemTypeBadgeColor(prefix) {
    switch(prefix) {
        case 's': return '#4CAF50'; // Green for Service
        case 'h': return '#2196F3'; // Blue for History
        case 'i': return '#FF9800'; // Orange for Action Item
        default: return '#999';     // Gray for Unknown
    }
}

$(document).ready(function () {
    
    // handles view logs activities
    $(document).on('click', '.view-logs', function(e) {
        e.preventDefault()
        let id = $(this).data('id')
        
        
    })
    
    
    // handles view logs activities
    $(document).on('click', '.view-logs', function(e) {
        e.preventDefault();
        let id = $(this).data('id');  // this is the reference id
        
        // Show loading modal
        swal({
            title: "Loading...",
            text: "Fetching history logs",
            type: "info",
            showConfirmButton: false,
            allowEscapeKey: false,
            allowOutsideClick: false
        });
        
        // Fetch history logs via AJAX
        $.ajax({
            url: "mypro_function/get_logs_history.php",
            method: "POST",
            dataType: 'json',
            data: {
                removeItems: true,
                itemId: id
            },
            success: function(response) {
                console.log('History Logs Response:', response);
                
                if (response.success && response.history_logs && response.history_logs.length > 0) {
                    // Build HTML content for the modal
                    let htmlContent = buildHistoryLogsHTML(response.history_logs, response.total_logs);
                    
                    // Display in SweetAlert modal
                    swal({
                        title: `History Logs (${response.total_logs})`,
                        text: htmlContent,
                        html: true,
                        confirmButtonText: "Close",
                        customClass: "history-logs-modal"
                    });
                } else if (response.success && response.total_logs === 0) {
                    // No logs found
                    swal({
                        title: "No Logs Found",
                        text: `No history logs found for MyPro ID: ${id}`,
                        type: "info",
                        confirmButtonText: "OK"
                    });
                } else {
                    // Error from API
                    swal({
                        title: "Error",
                        text: response.error || "Unable to fetch history logs",
                        type: "error",
                        confirmButtonText: "OK"
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", {
                    status: status,
                    error: error,
                    response: xhr.responseText
                });
                
                swal({
                    title: "Error",
                    text: "Failed to fetch history logs. Please try again.",
                    type: "error",
                    confirmButtonText: "OK"
                });
            }
        });
    });
    
    // handle remove mypro script
    $(document).on('click', '.remove-mypro', function (e) {
        e.preventDefault();

        let table = $(this).data('table');
        let id = $(this).data('id');
        let mainId = $(this).data('key');
        let rowElement = $(this).closest("tr"); // <--- keep reference!
        
        console.log(mainId)

        swal({
            title: "Confirmation Required",
            text: "Please provide a reason for this action:",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            inputPlaceholder: "Enter your reason here"
        }, function (inputValue) {
            if (inputValue === false) return false;

            if (inputValue.trim() === "") {
                swal.showInputError("Reason cannot be empty. Please type something!");
                return false;
            }

            swal({
                title: "Processing...",
                text: "Please wait",
                type: "info",
                showConfirmButton: false
            });

            $.ajax({
                url: "mypro_function/remove_mypro.php",
                method: "POST",
                dataType: 'json',
                data: {
                    removeItems: true,
                    itemId: id,
                    mainId: mainId,
                    table: table,
                    reason: inputValue
                },                success: function (json) {
                    if (json.success) {
                        // Handle different table hierarchical deletions
                        if (table === "tbl_MyProject_Services_History") {
                            // Parent level - hide panel-heading and panel-collapse
                            let panelHeading = $('[onclick="onclick_parent(' + json.deleted_id + ')"]').closest('.panel-heading');
                            let panelCollapse = $('#' + json.deleted_id + '.panel-collapse');
                            
                            panelHeading.fadeOut(300, function () {
                                $(this).remove();
                            });
                            panelCollapse.fadeOut(300, function () {
                                $(this).remove();
                            });                        } else if (table === "tbl_MyProject_Services_Childs_action_Items") {
                            // Child level - hide current row and all child rows below it
                            let currentRow = $("#sub_two_" + json.deleted_id);
                            let currentLevel = getRowLevel(currentRow);
                            
                            // Hide current row first
                            currentRow.fadeOut(300, function () {
                                $(this).remove();
                            });
                            
                            // Hide all child rows (rows with higher indentation level or equal level if current is 0)
                            let nextRow = currentRow.next('tr');
                            while (nextRow.length > 0) {
                                let nextLevel = getRowLevel(nextRow);
                                
                                // If current level is 0, delete all subsequent rows
                                // Otherwise, only delete rows with higher level
                                if (currentLevel === 0 || nextLevel > currentLevel) {
                                    let rowToHide = nextRow;
                                    nextRow = nextRow.next('tr');
                                    rowToHide.fadeOut(300, function () {
                                        $(this).remove();
                                    });
                                } else {
                                    // Stop if we encounter a row at same or lower level (sibling or parent)
                                    break;
                                }
                            }                        } else if (table === "tbl_MyProject_Services") {
                            // Show success message first, then redirect
                            swal({
                                title: "Success",
                                text: "Record deleted successfully.",
                                type: "success",
                                confirmButtonText: "OK"
                            }, function() {
                                // Redirect after user clicks OK
                                window.location.href = "https://interlinkiq.com/MyPro#tab_Dashboard";
                            });
                            return;
                        } else {
                            // Default behavior for other tables
                            $("#sub_two_" + json.deleted_id).fadeOut(300, function () {
                                $(this).remove();
                            });
                        }
                        
                        swal("Success", "Record deleted successfully.", "success");
                    } else {
                        swal("Error", json.error || "Unable to delete the record.", "error");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });
                    swal("Error", "A network or server error occurred.", "error");
                }
            });
        });
    });
});