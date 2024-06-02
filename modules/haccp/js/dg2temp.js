class DiagramObject {
    constructor() {}

    static getProcessStepsData() {
        const data = Object.keys(ProcessSteps);

        // Sorting the array numerically
        data.sort(function (a, b) {
            a = ProcessSteps[a].step;
            b = ProcessSteps[b].step;
            return parseInt(a) - parseInt(b);
        });

        // Sorting the array by alphanumeric order
        data.sort(function (a, b) {
            a = ProcessSteps[a].step;
            b = ProcessSteps[b].step;
            // Extracting numeric and non-numeric parts
            var numA = parseInt(a);
            var numB = parseInt(b);
            var strA = a.replace(/[^a-zA-Z]/g, "");
            var strB = b.replace(/[^a-zA-Z]/g, "");

            // If numeric parts are equal, sort by non-numeric parts
            if (numA === numB) {
                return strA.localeCompare(strB);
            }

            // Otherwise, sort by numeric parts
            return numA - numB;
        });

        Object.entries(ProcessSteps).forEach(([key, obj]) => {
            if (!planBuilder.processes[key]) {
                planBuilder.processes[key] = {
                    hazardAnalysis: {
                        B: {
                            potentialHazards: "",
                            rlto: null,
                            justification: "",
                            controlMeasures: "",
                        },
                        C: {
                            potentialHazards: "",
                            rlto: null,
                            justification: "",
                            controlMeasures: "",
                        },
                        P: {
                            potentialHazards: "",
                            rlto: null,
                            justification: "",
                            controlMeasures: "",
                        },
                    },
                    ccpDetermination: {
                        ccpNumber: null,
                        B: {
                            control: "",
                            q1: "",
                            q2: "",
                            q3: "",
                            q4: "",
                        },
                        C: {
                            control: "",
                            q1: "",
                            q2: "",
                            q3: "",
                            q4: "",
                        },
                        P: {
                            control: "",
                            q1: "",
                            q2: "",
                            q3: "",
                            q4: "",
                        },
                    },
                    clmca: {
                        criticalLimits: "",
                        monitoringProcedures: {
                            what: "",
                            who: "",
                            when: "",
                            how: "",
                        },
                        correctiveAction: "",
                    },
                    vrk: {
                        procedures: {
                            what: "",
                            when: "",
                            how: "",
                            who: {
                                performed: "",
                                reviewed: "",
                            },
                        },
                        records: "",
                    },
                };
            }

            planBuilder.processes[key].id = key;
            planBuilder.processes[key].process = obj.step;
            planBuilder.processes[key].label = obj.label;
        });

        return data;
    }

    static getCCPData() {
        return DiagramObject.getProcessStepsData().filter((x) => {
            const ccpD = planBuilder.processes[x].ccpDetermination;
            return ccpD.ccpNumber;
        });
    }

    static markCCP(id, ccp = true) {
        let counter = 0;
        return DiagramObject.getProcessStepsData().filter((x) => {
            const ccpD = planBuilder.processes[x].ccpDetermination;

            if (x == id) {
                ccpD.ccpNumber = ccp ? ++counter : null;
            } else if (ccpD.ccpNumber) {
                ccpD.ccpNumber = ++counter;
            }

            $(`[data-id=${x}] [data-ccpindicator]`).text(ccpD.ccpNumber || "");
            this.setCCP(x, ccpD.ccpNumber ? ccpD.ccpNumber : null);

            return ccpD.ccpNumber;
        });
    }

    static setCCP(id, value) {
        CCPs[id] = value;
        if (value === null) {
            delete CCPs[id];
        }
        setCCPToDiagram(id, value);
    }
}
