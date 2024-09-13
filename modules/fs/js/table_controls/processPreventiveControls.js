tcTable.prototype.process_preventive_control = function () {
    const processes = DiagramObject.getCCPData();
    const table = this.tables.process_preventive_control;

    if (!processes.length) {
        HRow.empty(table, 9);
        return;
    }

    processes.forEach((id) => {
        const d = planBuilder.processes[id];
        const ppc = d.ppc;

        const row = new HRow(table, { "data-id": id });
        row.cell(wProcessStep(d, table), { class: "t-center" });
        row.cell(ppc.criticalLimits).on("input", (v) => (ppc.criticalLimits = v));
        row.cell(ppc.procedures.what).on("input", (v) => (ppc.procedures.what = v));
        row.cell(ppc.procedures.how).on("input", (v) => (ppc.procedures.how = v));
        row.cell(ppc.procedures.when).on("input", (v) => (ppc.procedures.when = v));
        const whoCell = row.cell(null);
        whoCell.append("<div>Performed by:</div>");
        whoCell.on("input", `<div style='padding: var(--padOriginal)'></div>`, (v) => (ppc.procedures.who.performed = v));
        whoCell.append("<div >Reviewed by:</div>");
        whoCell.on("input", `<div style='padding: var(--padOriginal)'></div>`, (v) => (ppc.procedures.who.reviewed = v));

        row.cell(ppc.correctiveActions).on("input", (v) => (ppc.correctiveActions = v));
        row.cell(ppc.verification).on("input", (v) => (ppc.verification = v));
        row.cell(ppc.records).on("input", (v) => (ppc.records = v));
    });
};
