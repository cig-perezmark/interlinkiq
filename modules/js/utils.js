function initMultiSelect(el, options = {}) {
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
}