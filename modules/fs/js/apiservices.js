let baseUrl = "food-safety-plan?api&";

function submits() {
    $("#saveHACCPForm").on("submit", function (evt) {
        evt.preventDefault();
        const saveMethod = evt.target.save_as?.value || null;

        saveSignatures().then(() => {
            var l = Ladda.create(document.querySelector(".saveVersion-btn"));
            l.start();

            DiagramObject.getProcessStepsData();
            const formData = toFormData(planBuilder, new FormData(evt.target));
            formData.append("diagram", JSON.stringify(window.getJSFDiagram()));

            $.ajax({
                url: baseUrl + "update",
                type: "POST",
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    $('#modal-saveHaccpChanges').modal('hide');
                    fetchVersionLogs();
                    if(!response.message) {
                        bootstrapGrowl('Something went wrong.');
                        return;
                    }
                    
                    if (saveMethod == "draft" || saveMethod == 'post_approval_change') {
                        bootstrapGrowl(response.message);
                        return;
                    }
                    
                    bootstrapGrowl(response.message + " Redirecting to dashboard...");
                        
                    if(saveMethod) {
                        setTimeout(() => {
                            location.href = "haccp";
                        }, 3000);
                    }
                },
                complete: function () {
                    l.stop();
                },
            });
        });
    });

    $("#haccp-clientUpdatesForm").on("submit", function (evt) {
        evt.preventDefault();
        const formData = new FormData(evt.target);
        var l = Ladda.create(document.querySelector(".saveSigns-btn"));
        l.start();

        $.ajax({
            url: baseUrl + "update-client-signatures=" + (evt.target.updateClientSigns.value || 0),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                $("#modal-clientUpdates").modal("hide");
                bootstrapGrowl(response.message);
                location.reload();
            },
            error: function() {
                bootstrapGrowl('Error!');
            },
            complete: function() {
                l.stop();
            }
        });
    });

    // haccp team form
    $("#haccp-teamForm").on("submit", function (e) {
        e.preventDefault();

        var l = Ladda.create($("#proxyteamformsubmit").get(0));
        l.start();

        let url = baseUrl + "add-haccp-team-roster";
        const rosterId = $("#modal-haccpTeamModal [type=submit]").val();
        const fd = new FormData(e.target);

        if (rosterId != "") {
            url = baseUrl + "update-haccp-team-roster=" + rosterId;
            $("#modal-haccpTeamModal [type=submit]").val("");
        }

        $.ajax({
            url,
            type: "POST",
            contentType: false,
            processData: false,
            data: fd,
            success: function (response) {
                l.stop();

                if (response.data && Array.isArray(response.data)) {
                    renderHACCPTeamTable(response.data);
                }

                $(".haccp-team-select").multiselect("deselectAll", false);
                $("#modal-haccpTeamModal").modal("hide");
                bootstrapGrowl(response.message || "Successfully saved.");
            },
            error: function (response) {
                l.stop();
                console.log(response);
            },
        });
    });

    // uploading organization charts
    $("#orgChartFileUpload").on("change", async function (event) {
        if (event.target.value === "") return;

        const orgChartDisplay = $("#orgChartDisplay");
        const file = event.target.files[0];
        const base64 = await getBase64FromImage(file);
        const formData = new FormData();
        formData.append("image", base64);

        var l = Ladda.create($("#uploadOrgChartBtn").get(0));
        l.start();
        event.target.value = "";

        $.ajax({
            url: baseUrl + "update-organization-chart",
            type: "POST",
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                l.stop();
                orgChartDisplay.find("img").attr("src", base64);
                bootstrapGrowl(response.message);
            },
            error: function (response) {
                l.stop();
                console.log(response);
            },
        });
    });

    // task form submission
    $("#taskForm").on("submit", function (e) {
        e.preventDefault();
        swal(
            {
                title: "Are you sure you want to add this task?",
                type: "warning",
                allowOutsideClick: false,
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonClass: "btn green",
                cancelButtonClass: "btn gray",
                closeOnConfirm: true,
                closeOnCancel: true,
                confirmButtonText: "Yes",
                cancelButtonText: "Cancel",
            },
            function (isConfirm) {
                if (isConfirm) {
                    const formData = new FormData(e.target);
                    formData.append("haccp_id", planBuilder.id);

                    var l = Ladda.create(e.target.querySelector("[type=submit]"));
                    l.start();

                    $.ajax({
                        url: baseUrl + "add-task",
                        type: "POST",
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            e.target.task_title.value = "";
                            e.target.task_description.value = "";
                            e.target.task_due.value = "";

                            bootstrapGrowl(response.message || "Successfully saved.");
                            response.data && createTaskDom(response.data || {});
                            
                            updateTasksContainer();
                        },
                        complete: function () {
                            l.stop();
                        },
                    });
                }
            }
        );
    });
}

// submitting haccp as draft (first creation of haccp plan)
function saveNewHaccp(btn) {
    swal(
        {
            title: "Confirm save as draft",
            type: "warning",
            allowOutsideClick: false,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonClass: "btn green",
            cancelButtonClass: "btn gray",
            closeOnConfirm: false,
            closeOnCancel: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
        },
        function (isConfirm) {
            if (isConfirm) {
                var l = Ladda.create(btn);
                l.start();
                DiagramObject.getProcessStepsData();

                const formData = toFormData(planBuilder);
                formData.append("diagram", JSON.stringify(window.getJSFDiagram()));

                $.ajax({
                    url: baseUrl + "create",
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        swal(
                            {
                                title: response.message || "Successfully saved!",
                                text: 'Click "OK" to proceed',
                                type: "success",
                                allowOutsideClick: false,
                                showConfirmButton: true,
                                showCancelButton: false,
                                confirmButtonClass: "btn btn-success",
                                closeOnConfirm: true,
                                confirmButtonText: "OK",
                            },
                            function (isConfirm) {
                                if (response.haccp) {
                                    location.href = "?edit=" + response.haccp;
                                } else {
                                    location.reload();
                                }
                            }
                        );
                    },
                    error: function (response) {
                        bootstrapGrowl("Error.");
                        console.error(response);
                    },
                    complete: function () {
                        l.stop();
                    },
                });
            }
        }
    );
}

// initializing haccp team table
function initHaccpTeamRosterTable() {
    $.ajax({
        url: baseUrl + "haccp-team-roster",
        type: "GET",
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.data && Array.isArray(response.data)) {
                renderHACCPTeamTable(response.data);
            }
        },
        error: function (response) {
            console.log(response);
        },
    });
}

// removing haccp team roster
function removeHaccpTeamRoster(btn) {
    swal(
        {
            title: "Confirm to remove this data",
            text: "Are you sure you want to remove this in the team roster?",
            type: "warning",
            allowOutsideClick: false,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonClass: "btn green",
            cancelButtonClass: "btn gray",
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonText: "Yes, proceed",
            cancelButtonText: "Cancel",
        },
        function (isConfirm) {
            if (isConfirm) {
                var l = Ladda.create(btn);
                l.start();

                $.ajax({
                    url: baseUrl + "remove-haccp-team-roster=" + btn.closest("tr").dataset.memberId,
                    type: "GET",
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        l.stop();
                        if (response.data && Array.isArray(response.data)) {
                            renderHACCPTeamTable(response.data);
                        }
                        bootstrapGrowl(response.message || "Successfully removed.");
                    },
                });
            }
        }
    );
}

// removing organization chart
function removeOrganizationalChart() {
    swal(
        {
            title: "Confirm action",
            text: "Are you sure you want to remove the current organizational chart?",
            type: "warning",
            allowOutsideClick: false,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonClass: "btn green",
            cancelButtonClass: "btn gray",
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonText: "Yes, proceed",
            cancelButtonText: "Cancel",
        },
        function (isConfirm) {
            if (isConfirm) {
                var l = Ladda.create($("#removeOrgChartBtn").get(0));
                l.start();

                $.ajax({
                    url: baseUrl + "remove-organization-chart",
                    type: "GET",
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        l.stop();
                        $("#orgChartDisplay img").attr("src", "#");
                        bootstrapGrowl(response.message || "Successfully removed.");
                    },
                });
            }
        }
    );
}

// updating task status to completed
function completeTaskStatus(btn) {
    swal(
        {
            title: "Please confirm to proceed",
            text: "Mark task as completed",
            type: "warning",
            allowOutsideClick: false,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonClass: "btn green",
            cancelButtonClass: "btn gray",
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
        },
        function (isConfirm) {
            if (isConfirm) {
                const taskEl = btn.closest(".todo-tasklist-item");
                const id = taskEl.dataset.taskid;
                const status = btn.dataset.status;
                const completedTasks = $("#completedTaskContainer");

                var l = Ladda.create(btn);
                l.start();

                $.ajax({
                    url: baseUrl + "complete-task=" + id,
                    type: "GET",
                    // dataType: "json",
                    contentType: false,
                    processData: false,
                    // data: formData,
                    success: function (response) {
                        $(taskEl).fadeOut("linear", function () {
                            $(taskEl).addClass("todo-tasklist-item-border-green");
                            $(taskEl).removeClass("todo-tasklist-item-border-red");
                            completedTasks.prepend(taskEl);
                            updateTasksContainer();
                            $(taskEl).fadeIn();
                        });
                        bootstrapGrowl(response.message || "Successfully saved.");
                    },
                    complete: function () {
                        l.stop();
                    },
                });
            }
        }
    );
}

// fetch all tasks
async function getAllTasks() {
    if (!planBuilder?.id) return false;

    try {
        const res = await fetch(baseUrl + "all-tasks=" + planBuilder.id || 0);
        const tasks = await res.json();

        if (tasks?.data) {
            tasks.data.forEach((d) => {
                createTaskDom(d);
            });
            updateTasksContainer();
        }
    } catch (err) {
        console.error(err);
        return err;
    }
}

// saving pfd verification signs
function saveSignatures() {
    return new Promise((resolv, reject) => {
        const formData = new FormData();
        formData.append("signsData", JSON.stringify(getEsignsUpdate()));
        formData.append("id", planBuilder.id);
        saveDiagramImage();

        $.ajax({
            url: baseUrl + "signatures",
            type: "POST",
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                resolv();
            },
            error: function (err) {
                reject(err);
            },
        });
    });
}

// products search dropdown
function initSelect2AddProducts() {
    const productDropdown = $("#select2-addProducts");
    function formatProduct(data) {
        if (data.loading) return data.name;

        return `<div class="select2-result-repository clearfix">
            <div class="select2-result-repository__avatar">
                <img src="${data.image}" alt="Product Image" />
            </div>
            <div class="select2-result-repository__meta"> 
                <div class="select2-result-repository__title">${data.name}</div>
                <div class="select2-result-repository__description">${data.description}</div>
                <div class="select2-result-repository__statistics"> 
                <div class="select2-result-repository__forks">
                    <span>Product Code: </span>  ${data.code || "<i>Not set</i>"}
                </div> 
                </div> 
            </div>
        </div>`;
    }

    function formatProductSelection(data) {
        __selectedProductData = data; // set the selected material id to the hidden input
        if (data.name) {
            $(".addProductBtn").removeAttr("disabled");
        } else {
            $(".addProductBtn").prop("disabled", true);
        }
        return data.name || data.text;
    }

    const ajaxObj = {
        url: baseUrl,
        dataType: "json",
        method: "POST",
        delay: 250,
        data: function (params) {
            return {
                "search-product": params.term, // search term
                products: JSON.stringify(planBuilder.products) || "[]",
                page: params.page,
            };
        },
        processResults: function (data, page) {
            return {
                results: data.results,
            };
        },
        cache: true,
    };

    productDropdown.select2({
        width: "100%",
        ajax: ajaxObj,
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatProduct,
        templateSelection: formatProductSelection,
    });
}

// fetching client signatures
function openClientSignatures(btn, id) {
    const updateModal = $("#modal-clientUpdates");
    var l = Ladda.create(btn);
    l.start();

    $.ajax({
        url: baseUrl + "post-signatures=" + id,
        type: "GET",
        contentType: false,
        processData: false,
        success: function ({ data }) {
            updateModal.find("input[name=updateClientSigns]").val(id);
            $(".upd-esign").eSign();

            if (data.developed_by) {
                updateModal.find(".upd-develop").removeClass("hide");
                updateModal.find(".upd-developer").val(data.developed_by);
            }

            if (data.developer_sign) {
                updateModal.find(".upd-develop .upd-esign").eSign("set", data.developer_sign);
            }

            if (data.reviewed_by) {
                updateModal.find(".upd-reviewer").multiselect("select", data.reviewed_by);
            }

            if (data.reviewer_sign) {
                updateModal.find(".upd-review .upd-esign").eSign("set", data.reviewer_sign);
            }

            if (data.approved_by) {
                updateModal.find(".upd-approver").multiselect("select", data.approved_by);
            }

            if (data.approver_sign) {
                updateModal.find(".upd-approve .upd-esign").eSign("set", data.approver_sign);
            }

            if (data.reviewed_at) {
                updateModal.find("input[name=review_date]").val(data.reviewed_at);
            }

            if (data.approved_at) {
                updateModal.find("input[name=approve_date]").val(data.approved_at);
            }

            updateModal.modal("show");
        },
        error: function (err) {
            console.error(err);
        },
        complete: function () {
            l.stop();
        },
    });
}

// populating history tab
function fetchVersionLogs(version = null, loader = null) {
    if(!planBuilder?.id) return;
    let url = baseUrl + "logs=" + planBuilder.id;

    if(version) {
        url += '&v=' + version;
    }
    
    $.ajax({
        url,
        type: "GET",
        contentType: false,
        processData: false,
        success: function (response) {
            if(response.data.length) {
                const data = response.data || [];
                $('#historyLogsList').html('');
                data.forEach((d) => {
                    $('#historyLogsList').append(`
                        <li class="mt-list-item" title="${d.category}">
                            <div class="list-item-content" style="padding-left: 0; font-weight:600;">${d.description || ''}</div>
                            <div class="list-datetime uppercasex small text-muted" style="padding-left: 0;margin-top:1rem;">
                                ${d.user} updated <span title="${d.datetime}">${d.time_elapsed}</span>
                            </div>
                        </li>
                    `); 
                });
                
                $('#historyStarted').html(data[data.length-1].datetime ?? '');
            }
            
            // writing versions in the dropdown
            if(response.versions.length) {
                const dropdown = $('#versionsDropdown');
                dropdown.html('');
                response.versions.forEach((v) => {
                   dropdown.append(`<option value="${v.id}" ${v.active ? 'selected' : ''}>${v.version}</option>`);
                   
                   if(v.active) {
                       $('#versionViewPDF').attr('href', `food-safety-plan?pdf=${$('#versionViewPDF').attr('data-pdflink')}&version=${v.id}`)[v.current ? 'fadeOut' : 'fadeIn']();
                   }
                });
            }
        },
        complete: function() {
            loader && loader.stop();
        }
    });
}

// change version event
function changeVersionEvt(el) {
    fetchVersionLogs(el.value);
}

// save diagram image
function saveDiagramImage() {
    ExportJSF(function(uri) {
        const formData = new FormData();
        formData.append("image", uri);

        $.ajax({
            url: baseUrl + "update-diagram-image=" + planBuilder.id,
            type: "POST",
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {},
            error: function (err) {
                console.error(err);
            },
        });
    });
}
