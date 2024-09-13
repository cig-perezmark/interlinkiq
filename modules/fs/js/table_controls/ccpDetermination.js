tcTable.prototype.ccp_determination = function () {
    const processes = DiagramObject.getProcessStepsData();
    const table = this.tables.ccp_determination;

    if (!processes.length) {
        HRow.empty(table, 8);
        return;
    }

    HCell.prototype.setStatus = function (status) {
        let icon = this.cell.querySelector("[data-editor-icon]");
        if (status) {
            this.cell.removeAttribute("data-editing");
            icon && icon.classList.remove("status-off");
        } else {
            this.cell.setAttribute("data-editing", true);
            icon && icon.classList.add("status-off");
        }
    };

    processes.forEach((id) => {
        const d = planBuilder.processes[id];
        const ccp = d.ccpDetermination;
        const ha = d.hazardAnalysis;

        const rowB = new HRow(table, { "data-id": id, "data-main-row": "", "data-hazard": "B" });
        rowB.cell(wProcessStep(d, table), { class: "t-center", rowspan: 3 });
        rowB.cell("B", { class: "bold" }, { textAlign: "center" });
        rowB.cell(ha.B.potentialHazards, null, { width: "16%" });
        let q1 = rowB.cell(null, { "data-question": "q1" });
        let q2 = rowB.cell(null, { "data-question": "q2" });
        let q3 = rowB.cell(null, { "data-question": "q3" });
        let q4 = rowB.cell(null, { "data-question": "q4" });
        let ccpCell = rowB.cell(null, { rowspan: 3, class: "text-center" });
        let ccpIndicator = ccpCell.append(`<div style="text-align: center; margin: 0 0 1rem 0;" data-ccpindicator>${ccp.ccpNumber || ""}</div>`);

        const updCCPInput = () => {
            let isCCP = false;

            Object.entries(ccp).forEach(([key, val]) => {
                if (key == "B" || key == "C" || key == "P") {
                    (val.q1 == "y" && val.q2 == "y" && (isCCP = true)) || (val.q1 == "y" && val.q2 == "n" && val.q3 == "y" && val.q4 == "n" && (isCCP = true));
                    val.q1 == "n" || val.q3 == "n" || val.q4 == "n";
                }
            });

            const ccpId = DiagramObject.markCCP(id, isCCP).filter((x) => id == x)[0];
            if (isCCP) {
                // task: identify what ccp number is  this
                const ccpNumber = planBuilder.processes[ccpId].ccpDetermination.ccpNumber;
                ccpIndicator.innerText = ccpNumber;
                evaluateCCPperTable(processes, "ccp");
            } else {
                ccpIndicator.innerText = "";
                evaluateCCPperTable(processes, "ccp");
            }
        };
        qChain(q1, q2, q3, q4, updCCPInput, ccp.B);

        // continue C & P rows
        const rowC = new HRow(table, { "data-id": id, "data-hazard": "C" });
        rowC.cell("C", { class: "bold noborder" }, { textAlign: "center" });
        rowC.cell(ha.C.potentialHazards, null, { width: "16%" });
        q1 = rowC.cell(null, { "data-question": "q1" });
        q2 = rowC.cell(null, { "data-question": "q2" });
        q3 = rowC.cell(null, { "data-question": "q3" });
        q4 = rowC.cell(null, { "data-question": "q4" });
        qChain(q1, q2, q3, q4, updCCPInput, ccp.C);

        const rowP = new HRow(table, { "data-id": id, "data-hazard": "P" });
        rowP.cell("P", { class: "bold noborder" }, { textAlign: "center" });
        rowP.cell(ha.P.potentialHazards, null, { width: "16%" });
        q1 = rowP.cell(null, { "data-question": "q1" });
        q2 = rowP.cell(null, { "data-question": "q2" });
        q3 = rowP.cell(null, { "data-question": "q3" });
        q4 = rowP.cell(null, { "data-question": "q4" });
        qChain(q1, q2, q3, q4, updCCPInput, ccp.P);
    });

    evaluateCCPperTable(processes, "ccp");
};

function qChain(q1, q2, q3, q4, updateCCP, ccp) {
    let rtTimeoutId = null;
    const q1a = q1.on("yesno", (v) => {
        if (v == "n") {
            ccp.q1 = "";
            // no, display follow up question
            // q1b
            $(ft).fadeIn("linear", function () {
                q1b.style.display = "block";
            });
            displayControlHazard(false);
            // reset other questions
            (ccp.q2 = ""), (q2yn.style.display = "none"), dispatchAnswer(q2yn, null, true);
            (ccp.q3 = ""), (q3yn.style.display = "none"), dispatchAnswer(q3yn, null, true);
            (ccp.q4 = ""), (q4yn.style.display = "none"), dispatchAnswer(q4yn, null, true);
        } else if (v == "y") {
            ccp.q1 = "y";
            // yes, proceed to next question
            // hide follow up questions
            $(q2yn).fadeIn();
            removeFollowUps();
            displayControlHazard();
            rtTimeoutId && (clearTimeout(rtTimeoutId), (rtTimeoutId = null)); // remove timeout
        }
        updateCCP();
    });
    const ft = q1.append(`<div style="text-align: center; margin: 0 0 1rem 0;">Is control at this step necessary for safety?</div>`);
    const q1b = q1.on("yesno", (v) => {
        if (v == "n") {
            ccp.q1 = "n";
            // no, then stop
            // not a ccp
            rt.innerText = "This is not a CCP.";
            $(rt).fadeIn();
            displayControlHazard();
            rtTimeoutId && (clearTimeout(rtTimeoutId), (rtTimeoutId = null)); // remove timeout
        } else if (v == "y") {
            ccp.q1 = "";
            // yes, return to q1a
            rt.innerText = "Modify step, process or product... return to Question 1.";
            // reset question 1
            // expires 3 seconds
            displayControlHazard(false);
            $(rt).fadeIn("linear", function () {
                if (rtTimeoutId) return;
                rtTimeoutId = setTimeout(() => {
                    removeFollowUps();
                    dispatchAnswer(q1a, null, true);
                    rtTimeoutId = null;
                }, 3000);
            });
        }
        updateCCP();
    });
    const rt = q1.append(`<div class="text-muted italic text-center" style="margin: 0 0 1rem 0;"></div>"`);
    const cq = q1.append(`<div class="text-center" style='margin-bottom: 1rem;'>Identify how and where this hazard will be controlled.</div>"`);
    const ci = q1.on("input", `<div style="padding: var(--padBordered);">${ccp.control || ""}</div>`, (v) => {
        ccp.control = v;
    });

    const q2yn = q2.on("yesno", (v) => {
        if (v == "n") {
            ccp.q2 = "n";
            // no, proceed to the next question
            $(q3yn).fadeIn();
        } else if (v == "y") {
            // this is a ccp
            ccp.q2 = "y";
            // remove following questions
            (ccp.q3 = ""), (q3yn.style.display = "none"), dispatchAnswer(q3yn, null, true);
            (ccp.q4 = ""), (q4yn.style.display = "none"), dispatchAnswer(q4yn, null, true);
        }
        updateCCP();
    });
    const q3yn = q3.on("yesno", (v) => {
        if (v == "n") {
            // no, stop
            // not a CCP
            ccp.q3 = "n";
            (ccp.q4 = ""), (q4yn.style.display = "none"), dispatchAnswer(q4yn, null, true);
        } else if (v == "y") {
            // proceed to the next question
            $(q4yn).fadeIn();
            ccp.q3 = "y";
        }
        updateCCP();
    });
    const q4yn = q4.on("yesno", (v) => {
        if (v == "n") {
            // this is a CCP
            ccp.q4 = "n";
        } else if (v == "y") {
            // not a CCP
            ccp.q4 = "y";
        }
        updateCCP();
    });

    ft.style.display = "none";
    q1b.style.display = "none";
    rt.style.display = "none";
    displayControlHazard(false);

    q2yn.style.display = "none";
    q3yn.style.display = "none";
    q4yn.style.display = "none";

    // reassigning previous values
    const ccpQ1 = ccp.q1;
    dispatchAnswer(q1a, ccp.q1, true);
    if (ccpQ1 == "n") dispatchAnswer(q1b, ccpQ1, true);
    dispatchAnswer(q2yn, ccp.q2, true);
    dispatchAnswer(q3yn, ccp.q3, true);
    dispatchAnswer(q4yn, ccp.q4, true);

    function removeFollowUps() {
        rt.innerText = "";
        rt.style.display = "none";
        q1b.style.display = "none";
        ft.style.display = "none";
        dispatchAnswer(q1b, null);
    }

    function displayControlHazard(status = true) {
        cq.style.display = status ? "block" : "none";
        ci.style.display = status ? "block" : "none";
        let icon = cq.closest("td").querySelector("[data-editor-icon]");

        icon && icon.classList[status ? "remove" : "add"]("status-off");
    }
}

function dispatchAnswer(el, value, simulate = false) {
    let radio;
    (radio = el.querySelector("input[type=radio]:checked")) && (radio.checked = false);

    if ("y" == value || "n" == value) {
        (radio = el.querySelector(`input[type=radio][value=${value}]`)) && (radio.checked = true);
    }

    if (simulate) {
        el.querySelectorAll("input[type=radio]:checked").forEach((e) => e.dispatchEvent(new Event("change")));
    }
}
