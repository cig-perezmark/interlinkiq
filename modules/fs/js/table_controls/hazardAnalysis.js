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
            
            index == 0 && (rowAttr['data-main-row'] = '');

            rows[k] = new HRow(table, rowAttr);
            
            index == 0 && rows[k].cell(wProcessStep(d, table), { class: "t-center", rowspan: 6 });

            rows[k].cell(k, { class: "bold " + (index == 0 ?'': 'noborder') }, { textAlign: "center" });

            const phCell = rows[k].cell(ha[k].potentialHazards, null, { width: "22%" }).on("input", (v) => (ha[k].potentialHazards = v));
            const sD = severityDropdown();
    
            phCell.append(sD.container);

            rows[k].cell(null, { "data-hazard": k }).on("yesno", ha[k].preventiveControl, (v) => (ha[k].preventiveControl = v));
            
            rows[k].cell(null, { class: "text-center" });
            rows[k].cell(ha[k].justify, null).on("input", (v) => (ha[k].justify = v));
            rows[k].cell(ha[k].controlMeasures, null).on("input", (v) => (ha[k].controlMeasures = v));
            rows[k].cell(null, { "data-hazard": k }).on("yesno", ha[k].applied, (v) => (ha[k].applied = v));
            let risk = rows[k].cell(null, { class: "text-center" });
            risk.append(
                `<div style="text-align: center; margin: 0 0 1rem 0;" data-ccpindicator></div>`
            );
        });
    });

    evaluateCCPperTable(processes, "ha");
};

function severityDropdown() {
    const container = document.createElement('div');
    const dropdown = document.createElement('select');

    dropdown.innerHTML = `
        <option value="">1</option>
        <option value="">2</option>
        <option value="">3</option>
        <option value="">4</option>
        <option value="">5</option>
    `;
    container.setAttribute('class', 'cell-select');
    container.innerHTML = `<span>Severity:</span>`;
    container.append(dropdown);

    return {container, dropdown};
}

function haSlResult(rating) {
    switch (rating.slRisk) {
        case "high":
            return "CCP";
        case "significant":
            return "Preventive Control";
        case "acceptable":
            return "Control not required.";
        case "low":
            return "Control not required.";
    }
    return "";
}

function openSelectSLRating(e, { slRisk, sl }) {
    if (!e || e.target.closest("#s-l-rating-selection"))
        return `<span class="sl-rating-score" data-risk="${slRisk}">${sl || ""}</span>`;

    const slRatingSelection = document.getElementById("s-l-rating-selection");
    const td = e.target.closest("td");
    td.classList.toggle("sl-selection-active");

    if (td.classList.contains("sl-selection-active")) {
        closeSLRatingSelection();
        const slRatingElement = document.createElement("div");
        slRatingElement.classList.add("slRating", "btn-group", "btn-group-xs", "open");
        slRatingElement.append(slRatingSelection);
        td.append(slRatingElement);
    } else {
        $("#s-l-rating-selection-container").append(slRatingSelection);
        $(td).find(".slRating").remove();
    }
}

function selectSLRatingClickEvt(e) {
    const td = e.target.closest("[data-sl-rating-cell]");
    const tdRate = e.target.closest("td");
    const tempArr = tdRate.innerText.split("\n");
    const ratingSelected = tempArr[0];

    let rating = td.querySelector("span.sl-rating-score");

    if (!rating) {
        rating = document.createElement("span");
        rating.classList.add("sl-rating-score");
        td.append(rating);
    }

    // record
    const tr = td.closest("tr[data-id]");
    const processId = tr.dataset.id;
    const hazard = tr.querySelector("[data-hazard]").dataset.hazard;
    const risk = tdRate.dataset.risk;
    const slRate = ratingSelected.replace(/—/g, "&#8212;");

    planBuilder.processes[processId].hazardAnalysis[hazard].sl = slRate;
    planBuilder.processes[processId].hazardAnalysis[hazard].slScore = Number(tempArr[1].replace(/\(|\)/g, ""));
    planBuilder.processes[processId].hazardAnalysis[hazard].slRisk = risk;

    rating.setAttribute("data-risk", risk);
    rating.innerText = ratingSelected;
    e.target.closest("tr[data-id]").querySelector("[data-sl-result-cell]").innerText =
        slRate && slRate != ""
            ? risk == "high"
                ? "CCP"
                : risk == "significant"
                ? "Preventive Control"
                : "Control not required."
            : "";
    closeSLRatingSelection();
    evaluateCCPperTable(DiagramObject.getProcessStepsData(), "ha");
}

function closeSLRatingSelection() {
    const slRatingSelection = document.getElementById("s-l-rating-selection");
    const td = slRatingSelection.closest("[data-sl-rating-cell]");

    if (td) {
        td.classList.remove("sl-selection-active");
        $("#s-l-rating-selection-container").append(slRatingSelection);
        $(td).find(".slRating").remove();
    }
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
        if (value.slRisk == "high") {
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
                .append(`<li><a href="#${link}" style="color:inherit;">${label}</a></li>`);
        });

        warning.fadeIn();
    }
}
