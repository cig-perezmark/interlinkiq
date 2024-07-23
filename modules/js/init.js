(function($) {
    const Init = {
        baseUrl: '',
        multiSelect (el, options = {}) {
            $(el).multiselect({
                widthSynchronizationMode: 'ifPopupIsSmaller',
                buttonTextAlignment: 'left',
                buttonWidth: '100%',
                maxHeight: 200,
                enableResetButton: true,
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                includeSelectAllOption: true,
                nonSelectedText: 'None selected',
                ...options
            });
        
            $('.multiselect-container .multiselect-filter', $(el).parent()).css({
                'position': 'sticky', 'top': '0px', 'z-index': 1,
            });

            return {
                el,
                reset() {
                   $(this.el).multiselect('select', ''); 
                   $(this.el).multiselect('refresh'); 
                }
            }
        },
        dataTable(el, options = {}) {
            const dt = $(el).DataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending",
                    },
                    emptyTable: "No data available.",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    infoEmpty: "No records found",
                    infoFiltered: "(filtered from _MAX_ total records)",
                    lengthMenu: "Show _MENU_",
                    search: "Search:",
                    zeroRecords: "No matching records found",
                    paginate: {
                        previous: "Prev",
                        next: "Next",
                        last: "Last",
                        first: "First",
                    },
                },
                bStateSave: false,
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"],
                ],
                pageLength: 25,
                pagingType: "bootstrap_full_number",
                columnDefs: [{
                        orderable: false,
                        targets: [-1],
                    },
                    {
                        searchable: false,
                        targets: [-1],
                    },
                    {
                        className: "dt-right",
                    },
                ],
                order: [],
                dom: 'lBfrtip',
                buttons: [
                    // {
                    //     extend: 'excel',
                    //     className: 'btn btn-secondary',
                    //     text: 'Excel',
                    //     title: 'COA Records',
                    //     filename: 'COA_Records',
                    //     attr: {
                    //         'data-bs-toggle': "tooltip",
                    //         'data-bs-placement': "top",
                    //         'title': "Convert to Excel  file"
                    //     },
                    //     exportOptions: {
                    //         columns: ':visible:not(:last-child)'
                    //     }
                    // }, 
                    // {
                    //     extend: 'pdf',
                    //     className: 'btn btn-secondary',
                    //     text: 'PDF',
                    //     title: 'COA Records',
                    //     filename: 'COA_Records',
                    //     attr: {
                    //         'data-bs-toggle': "tooltip",
                    //         'data-bs-placement': "top",
                    //         'title': "Download as PDF"
                    //     },
                    //     exportOptions: {
                    //         columns: ':visible:not(:last-child)'
                    //     }
                    // }, 
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-cog"></i>',
                    }, 
                ],
                ...options,
            });

            return {
                dt,
                addRow(arr) {
                    dt.row.add(arr);
                    return dt;
                }
            };
        },
        createAlert(element, content = '', timeout = 3000, alertType = 'alert-danger') {
            if(
                !(element instanceof HTMLElement) &&
                !(typeof element === 'object' && element instanceof $ && element.length > 0 && element[0] instanceof HTMLElement)
            ) {
                console.error('Invalid element.');
                return;
            }

            const alert = $.parseHTML(`
                <div class="alert ${alertType} alert-dismissable" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <div class="alert-content">${content}</div>
                </div>
            `);

            $(element).append(alert);
            let id = null;

            return {
                alert: $(alert),
                id,
                timeout,
                show: function() {
                    const myAlert = this;
                    if(myAlert.id) {
                        console.log(myAlert)
                        clearTimeout(myAlert.id);
                        myAlert.id = null;
                    }
                    
                    $(myAlert.alert).fadeIn('linear', function() {
                        myAlert.id = setTimeout(() => {myAlert.hide()}, myAlert.timeout);
                    });
                    return this;
                },
                hide: function() {
                    const myAlert = this;
                    $(myAlert.alert).fadeOut('linear', () => myAlert.id = null)
                    return this;
                },
                destroy: function () {
                    if(this.id) {
                        clearTimeout(this.id);
                        this.id = null;
                    }
                    this.alert.remove();
                },
                setContent: function(content) {
                    $(this.alert).find('.alert-content').html(content);
                    return this;
                },
                isShowing: function() {
                    return this.id != null;
                },
                setTimeout: function(timeout) {
                    this.timeout = timeout;
                }
            };
        },
        idFancyBoxType(src, jqEl) {
            if(src.search('fancybox_type=no_iframe')) {
                jqEl.removeAttr('data-type');
            } else {
                jqEl.attr('data-type', 'iframe');
            }
        }
    };

    if(typeof window !== 'undefined') {
        window.Init = Init;
    }
})(jQuery);