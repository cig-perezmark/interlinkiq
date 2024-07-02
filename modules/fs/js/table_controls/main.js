function wProcessStep(data, table) {
    // populate step selectoor
    const dd = table.querySelector(".stepSelector select");
    let shortLabel = data.label.substring(0, 8);
    shortLabel += data.label.length > 8 ? "..." : "";
    dd?.insertAdjacentHTML(
        "beforeend",
        `<option title="${data.label}" value="${"stepselect_" + data.id}">(${data.process}) ${shortLabel}</option>`
    );

    const div = document.createElement("div");
    div.setAttribute("style", "scroll-margin-top: 16rem;");
    div.style.textAlign = "center";
    div.id = "stepselect_" + data.id;
    div.innerHTML = `<small class="text-muted" style="margin-right:1rem;">(${data.process})</small><br>${data.label}`;
    return div;
}

function tcTable(tabId) {
    const myinstance = this;
    Object.entries(this.tables).forEach(([tableId, tableElement]) => {
        const row = HRow.empty(tableElement);
        if (tabId == tableId) {
            row.table.querySelector("tbody").innerHTML = "";
            myinstance[tabId]();
        }
    });
}

tcTable.prototype = {
    tables: {
        hazard_analysis_and_preventive_measures: document.getElementById("hbHazardAnalysis"),
        ccp_determination: document.getElementById("hbCCPdetermination"),
        clm_and_ca: document.getElementById("hbCLMCA"),
        verification_and_record_keeping: document.getElementById("hbVRK"),
        master_sheet: document.getElementById("hbMasterSheet"),
    },
};

tcTable.prototype.master_sheet = function () {
    const processes = DiagramObject.getCCPData();
    const table = this.tables.master_sheet;

    if (!processes.length) {
        HRow.empty(table, 11);
        return;
    }

    processes.forEach((id) => {
        const d = planBuilder.processes[id];
        const vrk = d.vrk;

        const row = new HRow(table);
        row.cell(wProcessStep(d, table), { class: "t-center" });
        row.cell(
            `
            B - ${d.hazardAnalysis.B.potentialHazards}<br><br>
            C - ${d.hazardAnalysis.C.potentialHazards}<br><br>
            P - ${d.hazardAnalysis.P.potentialHazards}`,
            { align: "justify" }
        );
        row.cell(d.clmca.criticalLimits);
        row.cell(d.clmca.monitoringProcedures.what);
        row.cell(d.clmca.monitoringProcedures.how);
        row.cell(d.clmca.monitoringProcedures.when);
        row.cell(d.clmca.monitoringProcedures.who);
        row.cell(d.clmca.correctiveAction);
        row.cell(`
            ${d.vrk.procedures.what} <br><br>
            ${d.vrk.procedures.how} <br><br>
            ${d.vrk.procedures.when} <br><br>
            ${d.vrk.procedures.who.performed ? `<p>Performed by: <br> ${d.vrk.procedures.who.performed}</p>` : ""}<br>
            ${d.vrk.procedures.who.reviewed ? `<p>Reviewed by: <br> ${d.vrk.procedures.who.reviewed}</p>` : ""}
        `);
        row.cell(d.vrk.records);
    });
};
