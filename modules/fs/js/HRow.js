class HRow {
    constructor(table, attr = null) {
        this.table = table;
        this.cells = [];

        const tr = document.createElement("tr");
        if (attr && typeof attr === "object") {
            Object.entries(attr).forEach(([key, value]) => {
                if (key === "style") {
                    Object.entries(value).forEach(([kk, vv]) => {
                        tr.style[kk] = vv;
                    });
                } else {
                    tr.setAttribute(key, value);
                }
            });
        }
        this.table.querySelector("tbody").appendChild(tr);
        this.row = tr;
    }

    cell(content, attr, style) {
        const hcell = new HCell(content, attr, style);
        this.row.appendChild(hcell.cell);
        this.cells.push(hcell);
        return hcell;
    }

    static empty(
        table,
        colsize = null,
        text = "No process step(s) has been added yet."
    ) {
        // reset tbody
        const tbody = table.querySelector("tbody");
        tbody && (tbody.innerHTML = "");

        // populate with default row
        const hrow = new this(table);
        hrow.cell(`<i class="text-muted">${text}</i>`, { colspan: colsize });
        return hrow;
    }
}

class HCell {
    constructor(content, attr = {}, style = {}) {
        const td = document.createElement("td");

        // assigning attributes
        attr &&
            Object.entries(attr).forEach(([name, value]) =>
                td.setAttribute(name, value)
            );

        // assigning styles
        style &&
            Object.entries(style).forEach(
                ([name, value]) => (td.style[name] = value)
            );

        // writing content
        if (content instanceof HTMLElement) {
            td.appendChild(content);
        } else {
            td.innerHTML = content || "";
        }
        this.cell = td;
    }

    on(eventName, arg1 = null, arg2 = null, inputType = "textarea") {
        let callback = typeof arg1 === "function" ? arg1 : arg2;
        let hcell = this;

        // check if the string is a valid HTML string
        if (typeof arg1 === "string" && /<[a-z][\s\S]*>/i.test(arg1)) {
            // converting arg1 to html element instance
            const temp = document.createElement("template");
            temp.innerHTML = arg1;
            // reassigning the html element to arg1
            arg1 = temp.content.firstElementChild;
            this.cell.appendChild(arg1);
        } else if (typeof arg1 !== "string" || arg1 === "") {
            arg1 = this.cell;
        }

        // table cell clicks trigger input/editor in cell
        if (eventName == "input") {
            const icon = document.createElement("span");
            icon.setAttribute("data-editor-icon", "");
            icon.setAttribute("title", "Edit cell");
            this.cell.appendChild(icon);

            const editor = document.createElement(inputType);
            editor.classList.add("form-control", "border-blue-hoki");
            editor.style.zIndex = 2;
            editor.style.padding = "var(--padOriginal) ";
            editor.placeholder = "Add text content...";

            editor.addEventListener("blur", function () {
                arg1.innerHTML = this.value.replaceAll("\n", "<br>");
                arg1.style.padding = "var(--padBordered)";
                arg1.removeAttribute("data-editing");

                // send the value
                callback && callback(this.value);
                // remove editor from dom
                hcell.cell.appendChild(icon);
                this.remove();
            });

            editor.addEventListener("input", function () {
                callback && callback(this.value);
            });

            arg1.setAttribute("data-celleditable", "");
            arg1.addEventListener("click", clickEvt);
            icon.addEventListener("click", clickEvt);

            function clickEvt() {
                if (arg1.dataset.editing) return; // avoid triggering when already in focus

                icon.remove();
                // assign editor value
                editor.value = arg1.innerText.replaceAll("<br>", "\n");
                // editor size
                editor.style.minHeight = arg1.clientHeight - 1 + "px";
                editor.style.minWidth = arg1.clientWidth - 1 + "px";
                editor.style.width = arg1.clientWidth - 1 + "px";
                arg1.style.padding = 0;
                arg1.setAttribute("data-editing", true);

                arg1.innerHTML = "";
                arg1.appendChild(editor);
                editor.focus();
            }

            if (inputType != "textarea") {
                return { cell: arg1, input: editor };
            }
        }

        // adds yes or no radio buttons
        else if (eventName == "yesno") {
            const name = "y_n_" + generateRandomString(6);
            const ynContainer = document.createElement("div");
            ynContainer.style.textAlign = "center";
            ynContainer.innerHTML = `
                <div class="table-yn-container">
                    <label class="mt-radio mt-radio-outline ">
                        Yes<input type="radio" value="y" name="${name}" ${
                arg1 == "y" ? "checked" : ""
            }><span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                                No<input type="radio" value="n" name="${name}" ${
                arg1 == "n" ? "checked" : ""
            }><span></span>
                            </label>
                        </div>
                `;
            ynContainer
                .querySelectorAll("input[type=radio]")
                .forEach((radio) => {
                    radio.addEventListener("change", function () {
                        this.checked && callback && callback(this.value, this);
                    });
                });

            this.cell.appendChild(ynContainer);
            ynContainer
                .querySelector("input[type=radio]:checked")
                ?.dispatchEvent(new Event("change"));
            return ynContainer;
        }

        // casual click event
        else if (eventName == "click") {
            arg1.addEventListener("click", (e) => {
                callback && callback(e);
            });
        }

        return arg1;
    }

    append(arg1) {
        if (typeof arg1 === "string" && /<[a-z][\s\S]*>/i.test(arg1)) {
            const temp = document.createElement("template");
            temp.innerHTML = arg1;
            arg1 = temp.content.firstElementChild;
        }
        arg1 instanceof HTMLElement && this.cell.appendChild(arg1);
        return arg1;
    }
}
