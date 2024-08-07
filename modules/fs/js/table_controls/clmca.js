tcTable.prototype.process_narrative = function () {
    const processes = DiagramObject.getCCPData();
    const table = this.tables.process_narrative;

    if (!processes.length) {
        HRow.empty(table, 8);
        return;
    }

    processes.forEach((id) => {
        const d = planBuilder.processes[id];

        const row = new HRow(table, { "data-id": id });
        row.cell(wProcessStep(d, table), { class: "t-center" });
        row.cell(clmca.criticalLimits).on("input", (v) => (d.processNarrative = v));
    });
};
