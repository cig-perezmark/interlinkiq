tcTable.prototype.hazard_analysis_and_preventive_measures = function () {
    const processes = DiagramObject.getProcessStepsData();
    const table = this.tables.hazard_analysis_and_preventive_measures;

    if (!processes.length) {
        HRow.empty(table, 9);
        return;
    }

    processes.forEach((id) => {
        const d = planBuilder.processes[id];
        const ha = d.hazardAnalysis;
        const rows = {};

        Object.keys(ha).forEach((k, index) => {
            const rowAttr = { "data-id": id };
            const riskIndicator = document.createElement("span");

            index == 0 && (rowAttr["data-main-row"] = "");

            rows[k] = new HRow(table, rowAttr);

            index == 0 &&
                rows[k].cell(wProcessStep(d, table), {
                    class: "t-center",
                    rowspan: 6,
                });

            rows[k].cell(
                k,
                { class: "bold " + (index == 0 ? "" : "noborder") },
                { textAlign: "center" }
            );

            const phCell = rows[k].cell(ha[k].potentialHazards, null, {
                width: "22%",
            });
            const sD = severityDropdown(ha[k].severity);

            phCell.append(`<span></span>`);
            phCell.on(
                "input",
                `<div></div>`,
                (v) => (ha[k].potentialHazards = v)
            );
            phCell.append(sD.container);
            // hook severity selection
            sD.dropdown.addEventListener("change", function () {
                ha[k].severity = this.value;
                updateRiskIndicator(
                    riskIndicator,
                    parseInt(this.value) * parseInt(ha[k].likelihood) ?? ""
                );
            });

            rows[k]
                .cell(null, { "data-hazard": k }, { width: "8%" })
                .on(
                    "yesno",
                    ha[k].preventiveControl,
                    (v) => (ha[k].preventiveControl = v)
                );

            const lh = rows[k].cell(null, { class: "text-center" });
            const lD = likelihoodDropdown(ha[k].likelihood);

            lh.append(lD.container);
            lD.dropdown.addEventListener("change", function () {
                ha[k].likelihood = this.value;
                updateRiskIndicator(
                    riskIndicator,
                    parseInt(this.value) * parseInt(ha[k].severity) ?? ""
                );
            });

            rows[k]
                .cell(ha[k].justify, null)
                .on("input", (v) => (ha[k].justify = v));
            rows[k]
                .cell(ha[k].controlMeasures, null)
                .on("input", (v) => (ha[k].controlMeasures = v));
            rows[k]
                .cell(null, { "data-hazard": k }, { width: "8%" })
                .on("yesno", ha[k].applied, (v) => (ha[k].applied = v));
            let risk = rows[k].cell(null, { class: "text-center" });
            risk.append(riskIndicator);
        });
    });

    evaluateCCPperTable(processes, "ha");
};

function updateRiskIndicator(el, risk) {
    if (!risk) return;

    if (risk >= 1 && risk <= 4) {
        el.closest("td").setAttribute("data-risk", "low");
    } else if (risk >= 5 && risk <= 10) {
        el.closest("td").setAttribute("data-risk", "medium");
    } else if (risk >= 12 && risk <= 25) {
        el.closest("td").setAttribute("data-risk", "high");
    }

    el.innerText = risk;
}

function severityDropdown(initialValue) {
    const container = document.createElement("div");
    const dropdown = document.createElement("select");

    dropdown.innerHTML = `
        <option value="" ${
            !initialValue ? "selected" : ""
        } disabled>select</option>
        <option value="1" ${
            initialValue == 1 ? "selected" : ""
        }>Negligible (1)</option>
        <option value="2" ${
            initialValue == 2 ? "selected" : ""
        }>Minor (2)</option>
        <option value="3" ${
            initialValue == 3 ? "selected" : ""
        }>Moderate (3)</option>
        <option value="4" ${
            initialValue == 4 ? "selected" : ""
        }>Major (4)</option>
        <option value="5" ${
            initialValue == 5 ? "selected" : ""
        }>Extreme (5)</option>
    `;
    container.setAttribute("class", "cell-select margin-top-20");
    container.innerHTML = `<span>Severity: </span>`;
    container.append(dropdown);

    return { container, dropdown };
}

function likelihoodDropdown(initialValue) {
    const container = document.createElement("div");
    const dropdown = document.createElement("select");

    dropdown.style.width = "125px";
    dropdown.style.overflow = "hidden";
    dropdown.style.textOverflow = "ellipsis";
    dropdown.style.whiteSpace = "nowrap";
    dropdown.innerHTML = `
        <option value="" ${
            !initialValue ? "selected" : ""
        } disabled>select</option>
        <option value="1" ${
            initialValue == 1 ? "selected" : ""
        }>Very Unlikely (1)</option>
        <option value="2" ${
            initialValue == 2 ? "selected" : ""
        }>Rarely Occur (2)</option>
        <option value="3" ${
            initialValue == 3 ? "selected" : ""
        }>Possible (3)</option>
        <option value="4" ${
            initialValue == 4 ? "selected" : ""
        }>Likely Occur (4)</option>
        <option value="5" ${
            initialValue == 5 ? "selected" : ""
        }>Occurs Frequently (5)</option>
    `;
    container.setAttribute("class", "cell-select");
    container.append(dropdown);

    return { container, dropdown };
}

function checkCCPStep(id) {
    const { hazardAnalysis, ccpDetermination } = planBuilder.processes[id];
    const result = {
        ccpD: false,
        ha: false,
    };

    if (ccpDetermination.ccpNumber) {
        result.ccpD = true;
    }

    Object.entries(hazardAnalysis).forEach(([key, value]) => {
        if (value.severity * value.likelihood >= 12) {
            result.ha = true;
        }
    });

    return result;
}

function evaluateCCPperTable(processes, from) {
    let enforceCCPIds = { ha: [], ccp: [] };

    processes.forEach((id) => {
        const d = planBuilder.processes[id];
        const { ccpD, ha } = checkCCPStep(id);
        const data = {
            label: `(${d.process}) ${d.label}`,
            link: "stepselect_" + d.id,
        };

        if (ccpD && !ha) {
            enforceCCPIds.ha.push(data);
        }

        if (ha && !ccpD) {
            enforceCCPIds.ccp.push(data);
        }
    });

    const warning = from == "ha" ? $("#haWarning") : $("#ccpDWarning");
    warning.find(".affected-process-steps").html("");
    warning.css("display", "none");

    $(".ccp-error").removeClass("ccp-error");
    if (enforceCCPIds[from].length) {
        enforceCCPIds[from].forEach(({ label, link }) => {
            $("#" + link).addClass("ccp-error");
            warning
                .find(".affected-process-steps")
                .append(
                    `<li><a href="#${link}" style="color:inherit;">${label}</a></li>`
                );
        });

        warning.fadeIn();
    }
}
