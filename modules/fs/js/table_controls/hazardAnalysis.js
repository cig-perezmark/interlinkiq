tcTable.prototype.hazard_analysis_and_preventive_measures = function () {
    const processes = DiagramObject.getProcessStepsData();
    const table = this.tables.hazard_analysis_and_preventive_measures;

    if (!processes.length) {
        HRow.empty(table, 8);
        return;
    }

    processes.forEach((id) => {
        const d = planBuilder.processes[id];
        const ha = d.hazardAnalysis;

        const rowB = new HRow(table, { "data-id": id, "data-main-row": "" });
        rowB.cell(wProcessStep(d, table), { class: "t-center", rowspan: 3 });
        rowB.cell("B", { class: "bold" }, { textAlign: "center" });
        rowB.cell(ha.B.potentialHazards, null, { width: "22%" }).on("input", (v) => (ha.B.potentialHazards = v));
        rowB.cell(`<span class="sl-rating-score" data-risk="${ha.B.slRisk}">${ha.B.sl || ""}</span>`, {
            "data-sl-rating-cell": "",
        }).on("click", (e) => openSelectSLRating(e, ha.B));
        rowB.cell(null, { "data-hazard": "B" }).on("yesno", ha.B.rlto, (v) => (ha.B.rlto = v));
        rowB.cell(ha.B.justification).on("input", (v) => (ha.B.justification = v));
        rowB.cell(ha.B.controlMeasures).on("input", (v) => (ha.B.controlMeasures = v));
        rowB.cell(haSlResult(ha.B), { "data-sl-result-cell": "" });

        const rowC = new HRow(table, { "data-id": id });
        rowC.cell("C", { class: "bold noborder" }, { textAlign: "center" });
        rowC.cell(ha.C.potentialHazards, null, { width: "22%" }).on("input", (v) => (ha.C.potentialHazards = v));
        rowC.cell(`<span class="sl-rating-score" data-risk="${ha.C.slRisk}">${ha.C.sl || ""}</span>`, {
            "data-sl-rating-cell": "",
        }).on("click", (e) => openSelectSLRating(e, ha.C));
        rowC.cell(null, { "data-hazard": "C" }).on("yesno", ha.C.rlto, (v) => (ha.C.rlto = v));
        rowC.cell(ha.C.justification).on("input", (v) => (ha.C.justification = v));
        rowC.cell(ha.C.controlMeasures).on("input", (v) => (ha.C.controlMeasures = v));
        rowC.cell(haSlResult(ha.C), { "data-sl-result-cell": "" });

        const rowP = new HRow(table, { "data-id": id });
        rowP.cell("P", { class: "bold noborder" }, { textAlign: "center" });
        rowP.cell(ha.P.potentialHazards, null, { width: "22%" }).on("input", (v) => (ha.P.potentialHazards = v));
        rowP.cell(`<span class="sl-rating-score" data-risk="${ha.P.slRisk}">${ha.P.sl || ""}</span>`, {
            "data-sl-rating-cell": "",
        }).on("click", (e) => openSelectSLRating(e, ha.P));
        rowP.cell(null, { "data-hazard": "P" }).on("yesno", ha.P.rlto, (v) => (ha.P.rlto = v));
        rowP.cell(ha.P.justification).on("input", (v) => (ha.P.justification = v));
        rowP.cell(ha.P.controlMeasures).on("input", (v) => (ha.P.controlMeasures = v));
        rowP.cell(haSlResult(ha.P), { "data-sl-result-cell": "" });
    });

    evaluateCCPperTable(processes, "ha");
};

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
    if (!e || e.target.closest("#s-l-rating-selection")) return `<span class="sl-rating-score" data-risk="${slRisk}">${sl || ""}</span>`;

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
    e.target.closest("tr[data-id]").querySelector("[data-sl-result-cell]").innerText = slRate && slRate != "" ? (risk == "high" ? "CCP" : risk == "significant" ? "Preventive Control" : "Control not required.") : "";
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
            warning.find(".affected-process-steps").append(`<li><a href="#${link}" style="color:inherit;">${label}</a></li>`);
        });

        warning.fadeIn();
    }
}
