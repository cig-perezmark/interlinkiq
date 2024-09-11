const generateRandomString = (length = 5) => {
    const characters = "abcdefghijklmnopqrstuvwxyz0123456789";
    let randomString = "";
    for (let i = 0; i < length; i++) {
        randomString += characters[Math.floor(Math.random() * characters.length)];
    }
    return randomString;
};

var __selectedProductData = null;

// for uploading diagram image separately
function uploadDiagramAsImage(hid, vid, callback = null) {
    ExportJSF(function (uri) {
        const formData = new FormData();
        formData.append("saveDiagramAsImage", uri);
        formData.append("version_id", vid);
        formData.append("haccp_id", hid);
        fetch("module-haccp/api.php", {
            method: "POST",
            body: formData,
        })
            .then((r) => r.json())
            .then((d) => {
                console.log(d);
                callback && callback();
            });
    });
}

// for toggling internal/client assignee accounts pool
function selectAssignee(el) {
    const val = el.value;
    const oldSelect = $(el).closest(".form-group").find("select[name]");
    const selectName = oldSelect.attr("name");
    oldSelect.removeAttr("name").closest(".select-container").addClass("hide");
    $(`select[data-${val}]`).attr("name", selectName).closest(".select-container").removeClass("hide");
}

function openHistoryModal(id) {
    const historyModal = $("#modal-viewHACCPHistory");
    fetch("module-haccp/api.php?getHistory=" + id)
        .then((res) => res.text())
        .then((data) => {
            historyModal.find(".form-body").html(data);
            historyModal.modal("show");
        });
}

function statusOnChange(evt) {
    planBuilder.status = evt.target.value;
}

// updating plan builder data from form inputs
function updBuilderData(el, key) {
    if (planBuilder && el && key) {
        planBuilder[key] = el.value;
    }
}

function toFormData(obj, formData = null) {
    !formData && (formData = new FormData());

    Object.entries(obj).forEach(([k, v]) => {
        // encode arrays or json objects
        let data = [];
        if (Array.isArray(v)) {
            data = v;
        } else if (typeof v === "object" && v !== null) {
            data = {};
            Object.entries(v).forEach(([k, val]) => {
                data[k] = val;
            });
        }
        formData.append(k, (typeof v === "object" && v !== null) || Array.isArray(v) ? JSON.stringify(data) : v);
    });

    return formData;
}

// writiing haccp team roster data to table
function renderHACCPTeamTable(data) {
    const tbody = $("#haccp-teamTable tbody");
    tbody.html("");

    data.forEach((d) => {
        const { primary: p, alternate: a, roster_id } = d;
        tbody.append(`
            <tr data-member-id="${roster_id}">
                <td style="text-align:center;">${p.department || ""}</td>
                <td style="font-weight: 600; text-align:center;" data-primary-title>${p.position || ""}</td>
                <td style="text-align:center;font-weight:bold;" data-primary-id="${p.id}">${p.name || ""}</td>
                <td style="text-align:center;">${a.department || ""}</td>
                <td style="font-weight: 600; text-align:center;" data-alternate-title>${a.position || ""}</td>
                <td style="text-align:center;font-weight:bold;" data-alternate-id="${a.id}">${a.name || ""}</td>
                <td>
                    <div class="btn-group btn-group-circle" style="position: initial; margin-top: 0;">
                        <a href="javascript:void(0)" onclick="viewHaccpTeamRosterDetails(this)" class="btn btn-outline dark btn-sm">Update</a>
                        <a href="javascript:void(0)" onclick="removeHaccpTeamRoster(this)" class="btn btn-outlinex red btn-sm">Remove</a>
                    </div>
                </td>
            </tr>
        `);
    });
}

// rewriting haccp team row to form
function viewHaccpTeamRosterDetails(e) {
    const tr = e.closest("tr");

    $("#modal-haccpTeamModal [type=submit]").val($(tr).data("member-id"));
    $("#modal-haccpTeamModal [name=primary_title]").val($(tr).find("[data-primary-title]").text());
    $("#modal-haccpTeamModal [name=alternate_title]").val($(tr).find("[data-alternate-title]").text());
    $("#haccp-team-alternate_member").multiselect("select", $(tr).find("[data-alternate-id]").data("alternate-id"));
    $("#haccp-team-primary_member").multiselect("select", $(tr).find("[data-primary-id]").data("primary-id"));

    $("#modal-haccpTeamModal").modal("show");
    $("#modal-haccpTeamModal .modal-title").text("Update HACCP Team Roster");
}

// extracting base64 from images
function getBase64FromImage(imageFile) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(imageFile);
        reader.onload = () => resolve(reader.result);
        reader.onerror = (error) => reject(error);
    });
}

// tasks functions
function createTaskDom(data) {
    const pendingTasks = $("#pendingTaskContainer");
    const completedTasks = $("#completedTaskContainer");
    const pendingCounter = $("[data-pendingtask-count]").get(0);
    const completedCounter = $("[data-completedtask-count]").get(0);
    const div = document.createElement("div");

    div.style.display = "none";
    div.setAttribute("data-taskid", data.id);
    $(div).html(`
        <div class="todo-tasklist-item-title" title="Task title">${data.title || "(Untitled task)"}</div>
        <div class="todo-tasklist-item-text" title="Task description"> ${data.description || '<small class="text-muted">(No description has been added.)</small>'} </div>
        <div class="todo-tasklist-controls pull-left" style="display:flex; align-items:center;justify-content:space-between;width:100%;">
            <div>
                <span class="todo-tasklist-date" title="Due date"><i class="fa fa-calendar"></i> ${data.due_date || '<small class="text-muted">(No due date)</small>'} </span>
                <span class="todo-tasklist-date" title="Assigned to"><i class="fa fa-user"></i> ${data.assignee_name || '<small class="text-muted">(No assignee)</small>'} </span>
            </div>
            <div class="task-btns">
                <a href="javascript:;" class="btn btn-xs red hide" style="border:none!important;"><i class="fa fa-times"></i></a>
                <a href="javascript:;" class="btn btn-xs green btn-outline" style="border:none!important;" onclick="completeTaskStatus(this)" data-status="completed">Mark as completed</a>
            </div>
        </div>
    `);

    if (data.status == "pending") {
        div.setAttribute("class", "todo-tasklist-item todo-tasklist-item-border-red");
        pendingCounter.innerText = Number(pendingCounter.innerText) + 1 || 0;
        pendingTasks.prepend(div);
        pendingTasks.removeClass("is-empty");
    } else if (data.status == "completed") {
        completedTasks.removeClass("is-empty");
        div.setAttribute("class", "todo-tasklist-item todo-tasklist-item-border-green");
        completedCounter.innerText = Number(completedCounter.innerText) + 1 || 0;
        completedTasks.prepend(div);
    }

    $(div).fadeIn();
}

function resetTasks() {
    const pendingTasks = $("#pendingTaskContainer");
    const completedTasks = $("#completedTaskContainer");
    const pendingCounter = $("[data-pendingtask-count]").get(0);
    const completedCounter = $("[data-completedtask-count]").get(0);

    pendingTasks.find(".todo-tasklist-item").remove();
    completedTasks.find(".todo-tasklist-item").remove();
    pendingTasks.addClass("is-empty");
    completedTasks.addClass("is-empty");
}

function updateTasksContainer() {
    const pendingTasks = $("#pendingTaskContainer");
    const completedTasks = $("#completedTaskContainer");
    const pendingCounter = $("[data-pendingtask-count]").get(0);
    const completedCounter = $("[data-completedtask-count]").get(0);

    if (pendingTasks.find(".todo-tasklist-item").length) {
        pendingTasks.removeClass("is-empty");
        pendingCounter.innerText = pendingTasks.find(".todo-tasklist-item").length;
    } else {
        pendingTasks.addClass("is-empty");
        pendingCounter.innerText = 0;
    }

    const badge = $("[data-tasksbadge]");
    badge.text(pendingCounter.innerText);
    badge.attr("data-tasksbadge", pendingCounter.innerText);

    if (completedTasks.find(".todo-tasklist-item").length) {
        completedTasks.removeClass("is-empty");
        completedCounter.innerText = completedTasks.find(".todo-tasklist-item").length;
    } else {
        completedTasks.addClass("is-empty");
        completedCounter.innerText = 0;
    }
}

function vfdDateChange(el) {
    if (el.value != "") {
        $(el).addClass("vfd-date");
    }
}

function getEsignsUpdate() {
    const newData = [];
    const table = $("#verificationFDTable");
    table.find("td[data-vfd-id]").each((index, el) => {
        const container = $(el);
        const sign = container.find(".vfd-esign").eSign("getData");

        const data = {
            id: parseInt(container.attr("data-vfd-id")),
            account: parseInt(container.attr("data-account-id")) || null,
            date: container.find(".vfd-date").val() || null,
            sign,
        };

        newData.push(data);
    });
    return newData;
}

function addProductBtnClick() {
    if (__selectedProductData && __selectedProductData.hasOwnProperty("id")) {
        if (planBuilder.products.includes(__selectedProductData.id)) {
            alert("You have already added this product in this plan");
            $("#select2-addProducts").val("").trigger("change");
            return;
        }

        const tableBody = $("#addedProductsList");
        tableBody.append(`
            <tr>
s                <td style="width: 18%">
                    <div class="d-flex-center">
                        <img src="${__selectedProductData.image}" alt="Product Image" style="width: 8rem; margin-right: 1rem">
                        <div>
                            <span class="bold">${__selectedProductData.name}</span> <br>
                            <span class="text-muted">${__selectedProductData.category || ""}</span>
                        </div>
                    </div>
                </td>
                <td style="width: 12%">
                    <div class="d-flex-center">
                        <a href="javascript:void(0)" class="btn btn-outlinex btn-circle red btn-sm" onclick="removeProductBtnClick(event, ${__selectedProductData.id})">Remove</a>
                    </div>
                </td>
            </tr>
        `);
        planBuilder.products.push(Number(__selectedProductData.id));
    }
    $("#select2-addProducts").val("").trigger("change");

    evalProductsTable();
}

function removeProductBtnClick(evt, id) {
    swal(
        {
            title: "Are you sure you want to remove this product?",
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
                planBuilder.products = planBuilder.products.filter((p) => p != id);
                evt.target.closest("tr").remove();
                evalProductsTable();
            }
        }
    );
}

function evalProductsTable() {
    if (planBuilder.products.length === 0) {
        $("#addedProductsList").find("tr.no-products").removeClass("hide");
    } else {
        $("#addedProductsList").find("tr.no-products").addClass("hide");
    }
}
