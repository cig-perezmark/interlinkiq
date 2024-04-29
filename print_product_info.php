<head>
    <title>Product Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<style>
    @media print {
        @page {
            size: auto;
            margin: 0;
            width: 100%;
        }
    }

    .mt-12 {
        margin-top: 12px;
    }
</style>

<body>
    <div class="container">
        <div class="row">
            <?= create_el(12, "", '<h1 class="text-center mt-3">Product Information</h1><input type=button class="btn btn-md btn-primary d-print-none float-end" onClick="window.print()" value="Print">'); ?>
        </div>
        <!-- <hr> -->
        <form>
            <div class="row">
                <?= create_el(9, "Product Name", '<input type="text" class="form-control" name="name" disabled>'); ?>
                <?= create_el(3, "Product Code", '<input type="text" class="form-control" name="code" disabled>'); ?>
            </div>
            <div class="row">
                <?= create_el(12, "Product Description", '<input type=text class=form-control name="description" disabled>'); ?>
            </div>
        </form>
        <div class="row">
            <?= create_el(12, "<span>List of Ingredients</span>", '<span id=ingredients_container></span>'); ?>
        </div>
        <div class="row">
            <?= create_el(12, "<span>List of Packagings</span>", '<span id=packagings_container></span>'); ?>
        </div>
        <div class="row">
            <?= create_el(12, "<span>Instructions</span>", '<span id=processes_container></span>'); ?>
        </div>
    </div>
</body>
<?php
function create_el($col_num, $label, $input)
{
    $el = '<div class="col-' . $col_num . ' mt-2">';
    $el .= '<div class="form-group">';
    $el .= '<label class="form-label fw-bold">' . $label . '</label>';
    $el .= $input;
    $el .= '</div>';
    $el .= '</div>';
    return $el;
}
?>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"
    integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
<script>
    $(() => {
        const path = "product_and_formulation_functions.php";
        const img_path = "product_and_formulation/images/";
        var id = `<?php echo $_GET['id']; ?>`

        $.ajax({
            url: path,
            type: "post",
            dataType: "json",
            data: {
                get_product_info: true,
                id: id
            },
            success: function (response) {
                console.log(response)
                populate("form", response, "");
                let order = 1;
                const ingredients = JSON.parse(response.ingredients);
                let ingredients_ol = `<table class="table table-bordered table-sm table-striped"><thead class="table-secondary">
                <tr class="text-center align-middle">
                <th width="30%">Raw Material</th>
                <th width="10%">Price Per Unit</th>
                <th width="10%">Unit of Measure</th>
                <th width="10%">Quantity</th>
                <th width="10%">Quantity Received</th>
                <th width="20%">Remarks</th>
                </tr></thead><tbody>`;
                ingredients.map(ingredient => {
                    ingredients_ol += `<tr>`;
                    ingredients_ol += `<td>${order}. ${ingredient.raw_materials}</td>`;
                    ingredients_ol += `<td class=text-center>${ingredient.price_per_unit}</td>`;
                    ingredients_ol += `<td class=text-center>${ingredient.uom}</td>`;
                    ingredients_ol += `<td class=text-center>${ingredient.quantity ? ingredient.quantity : ""}</td>`;
                    ingredients_ol += `<td></td>`;
                    ingredients_ol += `<td></td>`;
                    ingredients_ol += `</tr>`;
                    order++;
                })
                ingredients_ol += `</tbody></table>`;
                $("#ingredients_container").html(ingredients_ol);

                order = 1;
                const packagings = JSON.parse(response.packagings);
                let packagings_ol = `<table class="table table-bordered table-sm table-striped"><thead class="table-secondary">
                <tr class="text-center align-middle">
                <th width="30%">Packaging</th>
                <th width="10%">Price Per Unit</th>
                <th width="10%">Unit of Measure</th>
                <th width="10%">Quantity</th>
                <th width="10%">Quantity Received</th>
                <th width="20%">Remarks</th>
                </tr></thead><tbody>`;
                packagings.map(packaging => {
                    packagings_ol += `<tr>`;
                    packagings_ol += `<td>${order}. ${packaging.raw_materials}</td>`;
                    packagings_ol += `<td class=text-center>${packaging.price_per_unit}</td>`;
                    packagings_ol += `<td class=text-center>${packaging.uom}</td>`;
                    packagings_ol += `<td class=text-center>${packaging.quantity ? packaging.quantity : ""}</td>`;
                    packagings_ol += `<td></td>`;
                    packagings_ol += `<td></td>`;
                    packagings_ol += `</tr>`;
                    order++;
                })
                packagings_ol += `</tbody></table>`;
                $("#packagings_container").html(packagings_ol);

                order = 1;
                const processes = JSON.parse(response.processes);
                let processes_ol = `<table class="table table-bordered table-sm"><thead class="table-secondary">
                <tr class="text-center align-middle">
                <th width="30%">Process</th>
                <th width="50%">Description</th>
                <th width="20%">Remarks</th>
                </tr></thead><tbody>`;
                processes.map(process => {
                    processes_ol += `<tr class=table-light>`;
                    processes_ol += `<td>${order}. ${process.process_step}</td>`;
                    processes_ol += `<td>${process.description}</td>`;
                    processes_ol += `<td></td>`;
                    processes_ol += `</tr>`;
                    let sub_order = 1;
                    process.subtasks.map(subtask => {
                        processes_ol += `<tr>`;
                        processes_ol += `<td>${order}.${sub_order}. ${subtask.subtask}</td>`;
                        processes_ol += `<td>${subtask.eform}</td>`;
                        processes_ol += `<td></td>`;
                        processes_ol += `</tr>`;
                        sub_order++;
                    })
                    order++;
                })
                processes_ol += `</tbody></table>`;
                $("#processes_container").html(processes_ol);

            },
            error: function (response) {
                alert(response.responseText)
            }
        })

        function get_fsig(label, signature, name_entered, position, date_entered) {

            var sig = "";
            if (date_entered) {
                sig += `<div class="fw-bold mt-2 mb-3">${label}</div>`
                sig += `<div><img style="height:50px;width:150px;" src="${signature}" class="mt-3"></div>`
                sig += `<div>${clean_data(name_entered)}</div>`
                sig += `<div>${clean_data(position)}</div>`
                sig += `<div>${clean_data(date_entered)}</div>`
            }
            return sig
        }

        function clean_data(data) {
            return data == null ? "" : data;
        }

        function add_comma(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        function display_amount(amount, currency) {
            return `${add_comma(amount)} ${currency}`
        }

        function populate(form, data, exception) {
            const exp = exception.split(",").map((item) => item.trim());
            $.each(data, function (key, value) {
                if (!exp.includes(key)) {
                    var ctrl = $("[name=" + key + "],#" + key, form);
                    switch (ctrl.prop("type")) {
                        case "radio":
                        case "checkbox":
                            ctrl.each(function () {
                                if ($(this).attr("value") == value || value == 1)
                                    $(this).attr("checked", value);
                            });
                            break;
                        default:
                            ctrl.val(value);
                    }
                }
            });
        }
    })
</script>