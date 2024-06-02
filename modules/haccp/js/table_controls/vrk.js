tcTable.prototype.verification_and_record_keeping = function () {
    const processes = DiagramObject.getCCPData();
    const table = this.tables.verification_and_record_keeping;

    if (!processes.length) {
        HRow.empty(table, 7);
        return;
    }

    processes.forEach((id) => {
        const d = planBuilder.processes[id];
        const vrk = d.vrk;

        const row = new HRow(table, { "data-id": id });
        row.cell(wProcessStep(d, table), { class: "t-center" });
        row.cell(vrk.procedures.what).on("input", (v) => (vrk.procedures.what = v));
        row.cell(vrk.procedures.how).on("input", (v) => (vrk.procedures.how = v));
        row.cell(vrk.procedures.when).on("input", (v) => (vrk.procedures.when = v));
        const whoCell = row.cell(null);
        whoCell.append("<div>Performed by:</div>");
        whoCell.on(
            "input",
            `<div style='padding: var(--padOriginal)'></div>`,
            (v) => (vrk.procedures.who.performed = v)
        );
        whoCell.append("<div >Reviewed by:</div>");
        whoCell.on(
            "input",
            `<div style='padding: var(--padOriginal)'></div>`,
            (v) => (vrk.procedures.who.reviewed = v)
        );

        row.cell(vrk.records).on("input", (v) => (vrk.records = v));
    });
};
