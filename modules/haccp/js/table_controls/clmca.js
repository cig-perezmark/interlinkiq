tcTable.prototype.clm_and_ca = function () {
    const processes = DiagramObject.getCCPData();
    const table = this.tables.clm_and_ca;

    if (!processes.length) {
        HRow.empty(table, 8);
        return;
    }

    processes.forEach((id) => {
        const d = planBuilder.processes[id];
        const clmca = d.clmca;

        const row = new HRow(table, { "data-id": id });
        row.cell(wProcessStep(d, table), { class: "t-center" });
        row.cell(clmca.criticalLimits).on("input", (v) => (clmca.criticalLimits = v));
        row.cell(clmca.monitoringProcedures.what).on("input", (v) => (clmca.monitoringProcedures.what = v));
        row.cell(clmca.monitoringProcedures.how).on("input", (v) => (clmca.monitoringProcedures.how = v));
        row.cell(clmca.monitoringProcedures.when).on("input", (v) => (clmca.monitoringProcedures.when = v));
        row.cell(clmca.monitoringProcedures.who).on("input", (v) => (clmca.monitoringProcedures.who = v));
        row.cell(clmca.correctiveAction).on("input", (v) => (clmca.correctiveAction = v));
    });
};
