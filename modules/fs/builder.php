<?php

/** @var Array $employees */

/** @var Array $cigEmployees */

/** @var Array $facilities */

/** @var Array $teamSigns */

/** @var mysqli_extended $conn */

$builderTabs = [
    [
        'title' => 'Raw Product List',
        'link' => 'product_information',
        'active' => true,
    ],
    [
        'title' => 'Process Flow Diagram',
        'link' => 'process_flow_diagram'
    ],
    [
        'title' => 'Process Narrative',
        'link' => 'process_narrative'
    ],
    [
        'title' => 'Hazard Analysis',
        'link' => 'hazard_analysis_and_preventive_measures'
    ],
    [
        'title' => 'CCP Determination',
        'link' => 'ccp_determination'
    ],
    [
        'title' => 'Process Preventive Controls',
        'link' => 'process_preventive_control'
    ],
    [
        'title' => 'Food Allergen Preventive Controls',
        'link' => 'process_preventive_control'
    ],
    [
        'title' => 'Sanitation Preventive Controls',
        'link' => 'process_preventive_control'
    ],
    [
        'title' => 'Supply Chain Preventive Controls',
        'link' => 'process_preventive_control'
    ],
    [
        'title' => 'Validation',
        'link' => 'process_preventive_control'
    ],
];

?>

<style>
    .mt-timeline-2>.mt-container>.mt-item>.mt-timeline-content>.mt-content-container::before {
        top: auto;
        bottom: 28px;
    }

    .mt-timeline-2>.mt-container>.mt-item>.mt-timeline-icon {
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }

    .mt-timeline-2>.mt-container>.mt-item {
        position: relative;
        padding-bottom: 0;
        padding-top: 60px;
    }

    body,
    html {
        scroll-behavior: smooth;
    }
</style>

<div style="padding: .5rem 1.5rem; margin-bottom: 20px; display:flex; justify-content:space-between;" class="bg-default">
    <h4><strong>**BASIC INFORMATION</strong></h4>
    <?php if (isset($haccpResource)) : ?>
        <h5>
            <strong>STATUS:<i><?= $haccpResource['status'] ?></i></strong>
        </h5>
    <?php endif; ?>
</div>
<section class="row margin-bottom-20">
    <div class="form-group col-md-9">
        <label for="haccp-builder-documentCode">Select Facility</label>
        <select class="form-control" name="facility" <?= count($facilities) == 1 ? 'disabled' : '' ?> onchange="updBuilderData(this, 'facility')">
            <option value="" disabled>--Select--</option>
            <?php
            foreach ($facilities as $f) {
                echo '<option value="' . $f['facility_id'] . '">' . $f['facility_category'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group col-md-9">
        <label for="haccp-builder-description">Food Safety Plan Title </label>
        <textarea id="haccp-builder-description" rows="3" class="form-control" data-inputkey="description" placeholder="Add title..."><?= $resource('description') ?></textarea>
    </div>
    <div class="form-group col-md-9">
        <label for="haccp-builder-description">Scope </label>
        <textarea id="haccp-builder-description" rows="3" class="form-control" data-inputkey="scope" placeholder="Enter scope of the Food Safety Plan..."><?= $resource('scope') ?></textarea>
    </div>
    <div class="col-md-12"></div>
    <div class="form-group col-md-3">
        <label for="haccp-builder-documentCode">Document Code </label>
        <input type="text" id="haccp-builder-documentCode" class="form-control" data-inputkey="document_code" placeholder="Enter document code" value="<?= $resource('document_code') ?>">
    </div>
    <div class="form-group col-md-3">
        <label for="haccp-builder-issueDate">Issue Date </label>
        <input type="date" id="haccp-builder-issueDate" class="form-control" data-inputkey="issue_date" value="<?= $resource('issue_date') ?>">
    </div>
    <?php if (!isset($haccpResource)) : ?>
        <div class="col-md-12">
            <div style="display: flex; justify-content: start;">
                <button type="button" id="haccpBuilderSaveBtn" class="btn btn-danger" onclick="saveNewHaccp(this)" disabled> Save as draft </button>
            </div>
        </div>
    <?php endif; ?>
</section>
<div style="padding: .5rem 1.5rem; margin-bottom: 20px; margin-top: 50px;" class="bg-default">
    <h4 class="d-flex-center-between">
        <strong>**SECTIONS</strong>
        <div>
            <div class="hb-help">
                <i class="fa fa-question-circle"></i>
                <div class="btn-group open">
                    <div class="dropdown-menu pull-right hold-on-click" style="padding: 8px 16px 8px 12px;">
                        <ul style="margin:0;padding:inherit;" class="text-muted">
                            <li style="line-height: 112%;  font-size: smaller; margin-bottom: .75rem;">
                                Click on the cells with <i class="fa fa-edit" style="color: #3598dc;"></i> icon to start editing.
                            </li>
                            <li style="line-height: 112%;  font-size: smaller; margin-bottom: .75rem;">
                                You can search/find a specific process under the "Process Step" column of the table.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </h4>
</div>
<div class="tabbable tabbable-tabdrop">
    <ul class="nav nav-tabs builder-toc-navs">
        <li class="dropdown pull-right tabdrop hbtabsmall">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fa fa-ellipsis-v"></i>&nbsp;<i class="fa fa-angle-down"></i>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <?php foreach ($builderTabs as $index => $tab) : ?>
                    <?php if ($index == 0) continue; ?>
                    <li>
                        <a href="#<?= $tab['link'] ?>" data-toggle="tab"><?= $tab['title'] ?></a>
                    </li>
                <?php endforeach; ?>
                <?php if (isset($haccpResource)) : ?>
                    <li>
                        <a href="#process_monitoring_forms" data-toggle="tab"> Process Monitoring Forms </a>
                    </li>
                    <li>
                        <a href="#haccptasks" data-toggle="tab"> Tasks <span class="badge badge-danger" data-tasksbadge="0">0</span> </a>
                    </li>
                    <li>
                        <a href="#history" data-toggle="tab"> History </a>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
        <?php foreach ($builderTabs as $index => $tab) : ?>
            <li class="<?= (isset($tab['active']) && $tab['active'] ? 'active' : '') . ($index >= 1 ? ' hbtabwide' : '') ?>">
                <a href="#<?= $tab['link'] ?>" data-toggle="tab"><?= $tab['title'] ?></a>
            </li>
        <?php endforeach; ?>
        <?php if (isset($haccpResource)) : ?>
            <li class="hbtabwide">
                <a href="#process_monitoring_forms" data-toggle="tab"> Process Monitoring Forms </a>
            </li>
            <li class="hbtabwide">
                <a href="#haccptasks" data-toggle="tab"> Tasks <span class="badge badge-danger" data-tasksbadge="0">0</span> </a>
            </li>
            <li class="hbtabwide">
                <a href="#history" data-toggle="tab"> History </a>
            </li>
        <?php endif; ?>
    </ul>
</div>
<h4 class="bold" id="builder-title">Raw Product List </h4>
<div class="tab-content">
    <div class="tab-pane active" id="product_information">
        <div class="row">
            <div class="col-md-9">
                <div class="form-group row">
                    <label class="col-md-12 control-label">Select new product </label>
                    <div class="col-md-9">
                        <select id="select2-addProducts" class="form-control">
                            <option value="" selected>Search product name </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="hidden" id="selectedProductId">
                        <button type="button" class="btn btn-primary btn-block addProductBtn" onclick="addProductBtnClick()" disabled>
                            <i class="fa fa-plus"></i> Add product</button>
                    </div>
                </div>
                <h4 style="padding-top: 0;"><strong>Product(s)</strong></h4>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Enter product(s) name" data-inputkey="products_name" value="<?= $resource('products_name') ?>">
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody id="addedProductsList">
                            <?php
                            if (isset($haccpResource) && count($haccpResource['products'])) {
                                $haccpProducts = '(' . implode(',', $haccpResource['products']) . ')';
                                $products = $conn->query("SELECT p.ID as id,p.image,p.description,p.name,c.name as category FROM tbl_products p LEFT JOIN tbl_products_category c ON p.category = c.ID  WHERE p.ID in $haccpProducts");
                                if ($products->num_rows) {
                                    while ($row = $products->fetch_assoc()) {
                                        $img = explode(',', $row['image'])[0];
                                        $img = empty($img) ? null : '//interlinkiq.com/uploads/products/' . $img;
                                        $img = !empty($img) ? $img : "https://via.placeholder.com/120x90/EFEFEF/AAAAAA.png?text=No+Image";
                                        echo '<tr>
                                                <td style="width: 88%">
                                                    <div class="d-flex-center">
                                                        <img src="' . $img . '" alt="Product Image" style="width: 8rem; margin-right: 1rem">
                                                        <div>
                                                            <span class="bold">' . $row['name'] . '</span> <br>
                                                            <span class="text-muted">Category: ' . $row['category'] . '</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width: 12%">
                                                    <div class="d-flex-center">
                                                        <a href="javascript:void(0)" class="btn btn-outlinex btn-circle red btn-sm" onclick="removeProductBtnClick(event, ' . $row['id'] . ')">Remove</a>
                                                    </div>
                                                </td>
                                            </tr>';
                                    }
                                }
                            }

                            if (isset($haccpResource) && count($haccpResource['products']) == 0) {
                                echo '<tr class="no-products"><td>No product(s) added.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div data-section="diagram" class="tab-pane" id="process_flow_diagram">
        <div class="d-flex-column" style="min-height: inherit;">
            <div id="haccp-pfd-container" class="flex-grow">
                <div id="jsfDiagramContainment">
                    <h5 style="padding: 1rem; margin: 0; font-weight: 600;">Diagram Maker</h5>
                    <div id="jsf-toolbar" style="display: flex; align-items:center; gap: 1rem; padding: 1rem;">
                        <section>
                            <div style="margin-bottom: 0.5rem;">Shapes</div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" data-btn-shape="Rectangle" title="Rectangle">
                                    <img src="<?= $base_url ?>modules/haccp/icons/rectangle.svg" class="jsf-icon" alt="">
                                </button>
                                <button type="button" class="btn btn-default" data-btn-shape="Ellipse" title="Ellipse">
                                    <img src="<?= $base_url ?>modules/haccp/icons/ellipse.svg" class="jsf-icon" alt="">
                                </button>
                                <button type="button" class="btn btn-default" data-btn-shape="Circle" title="Circle">
                                    <img src="<?= $base_url ?>modules/haccp/icons/circle.svg" class="jsf-icon" alt="">
                                </button>
                                <button type="button" class="btn btn-default" data-btn-shape="Diamond" title="Diamond">
                                    <img src="<?= $base_url ?>modules/haccp/icons/diamond.svg" class="jsf-icon" alt="">
                                </button>
                                <button type="button" class="btn btn-default" data-btn-shape="Text" title="Text">
                                    <img src="<?= $base_url ?>modules/haccp/icons/text.svg" class="jsf-icon" alt="">
                                </button>
                            </div>
                        </section>
                        <section>
                            <div class="btn-group">
                                <div style="margin-bottom: 0.5rem;">Lines</div>
                                <button type="button" class="btn btn-default" data-btn-connector="line" title="Line">
                                    <img src="<?= $base_url ?>modules/haccp/icons/line.svg" class="jsf-icon" alt="">
                                </button>
                                <button type="button" class="btn btn-default" data-btn-connector="arrow" title="Arrow">
                                    <img src="<?= $base_url ?>modules/haccp/icons/arrowline.svg" class="jsf-icon" alt="">
                                </button>
                                <button type="button" class="btn btn-default" data-btn-connector="double-arrow" title="Double Arrow">
                                    <img src="<?= $base_url ?>modules/haccp/icons/doublearrow.svg" class="jsf-icon" alt="">
                                </button>
                                <button type="button" class="btn btn-default" data-btn-connector="elbow" title="Elbow Line / Coming soon" disabled>
                                    <img src="<?= $base_url ?>modules/haccp/icons/elbow.svg" class="jsf-icon" alt="">
                                </button>
                                <button type="button" class="btn btn-default" data-btn-connector="arrow-elbow" title="Arrow Elbow Line / Coming soon" disabled>
                                    <img src="<?= $base_url ?>modules/haccp/icons/arrowelbow.svg" class="jsf-icon" alt="">
                                </button>
                                <button type="button" class="btn btn-default" data-btn-connector="double-arrow-elbow" title="Double Arrow Elbow / Coming soon" disabled>
                                    <img src="<?= $base_url ?>modules/haccp/icons/doublearrowelbow.svg" class="jsf-icon" alt="">
                                </button>
                            </div>
                        </section>
                        <section>
                            <div class="btn-group">
                                <div style="margin-bottom: 0.5rem;">Zoom</div>
                                <button type="button" class="btn btn-default" data-btn-fn="zoomout">
                                    <i class="fa fa-search-minus"></i>
                                </button>
                                <button type="button" class="btn btn-default" data-btn-fn="zoomin">
                                    <i class="fa fa-search-plus"></i>
                                </button>
                                <button type="button" class="btn btn-default" data-btn-fn="zoomreset">Reset</button>
                            </div>
                        </section>
                    </div>
                    <div class="btn-group btn-group-xs open jsf-menu">
                        <div class="dropdown-menu jsf-menu-box hide" id="objectSettingsMenu">
                            <div style="font-weight: 600; user-select:none; cursor: pointer" class="jsfboxdraggable">Object settings <small class="text-muted font-normal">(Drag on this pane)</small></div>
                            <hr style="margin: .5rem 0;">
                            <div class="form-group" id="omProcessSection">
                                <label for="isProcessStepCheckbox" class="d-flex-center" style="gap: 1rem;">
                                    <input type="checkbox" class="m-0" id="isProcessStepCheckbox">
                                    is a process step
                                </label>
                                <input type="text" id="isProcessStepInput" class="form-control" placeholder="Enter step/order">
                            </div>
                            <div class="form-group">
                                <label for="omTextInput">Edit text</label>
                                <textarea id="omTextInput" rows="2" style="max-height: 12rem;" class="form-control" placeholder="Enter description..."></textarea>
                            </div>
                            <div class="form-group" id="omOutlineSection">
                                <div style="margin-bottom: 0.5rem;">Outline</div>
                                <div class="btn-group btn-group-sm btn-group-justified" id="omOutlineBtnGrp">
                                    <a href="javascript:void(0)" class="btn btn-default" data-value="solid" title="Solid">
                                        <img src="<?= $base_url ?>modules/haccp/icons/outlinesolid.svg" class="jsf-icon" alt="">
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-default" data-value="dot" title="Dotted">
                                        <img src="<?= $base_url ?>modules/haccp/icons/outlinedot.svg" class="jsf-icon" alt="">
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-default" data-value="dash" title="Dashed">
                                        <img src="<?= $base_url ?>modules/haccp/icons/outlinedash.svg" class="jsf-icon" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <div style="margin-bottom: 0.5rem;" id="omSmallNote">
                                    Colors<small class="text-muted">(Background | Outline | Text)</small>
                                </div>
                                <div style=" display:flex; gap:.5rem; justify-content:stretch;">
                                    <div class="border-default border" style="flex-grow:1;" title="Background color">
                                        <input type="hidden" id="bgColorInput" class="colorSelector" value="#000000">
                                    </div>
                                    <div class="border-default border" style="flex-grow:1;" title="Outline color">
                                        <input type="hidden" id="outlineColorInput" class="colorSelector" value="#000000">
                                    </div>
                                    <div class="border-default border" style="flex-grow:1;" title="Text color">
                                        <input type="hidden" id="textColorInput" class="colorSelector" value="#000000">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn red btn-xs" data-jsfmenu-remove="objectMenu" title="Remove object">Remove</button>
                                <button type="button" class="btn default btn-xs" data-jsfmenu-close="objectMenu" title="Close settings">Close</button>
                            </div>
                        </div>
                        <div class="dropdown-menu jsf-menu-box hide" id="lineSettingsMenu">
                            <div style="font-weight: 600;">Line settings</div>
                            <hr style="margin: .5rem 0;">
                            <div class="form-group">
                                <div style="margin-bottom: 0.5rem;">Type</div>
                                <div class="btn-group btn-group-justified" id="lmTypeBtnGrp">
                                    <a href="javascript:void(0)" class="btn btn-default" data-value="solid" title="Solid">
                                        <img src="<?= $base_url ?>modules/haccp/icons/outlinesolid.svg" class="jsf-icon" alt="">
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-default" data-value="dot" title="Dotted">
                                        <img src="<?= $base_url ?>modules/haccp/icons/outlinedot.svg" class="jsf-icon" alt="">
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-default" data-value="dash" title="Dashed">
                                        <img src="<?= $base_url ?>modules/haccp/icons/outlinedash.svg" class="jsf-icon" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Stroke/Color</label>
                                <input type="hidden" id="lineColorInput" class="colorSelector" value="#000000">
                            </div>
                            <div>
                                <button type="button" class="btn red btn-xs" data-jsfmenu-remove="lineMenu" title="Remove line">Remove</button>
                                <button type="button" class="btn default btn-xs" data-jsfmenu-close="lineMenu" title="Close settings">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row margin-top-40">
                <div class="col-md-12">
                    <h4><strong>Verification of Flow Diagram</strong></h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 30%">Members</th>
                                    <th>Position/Title</th>
                                    <th style="width: 20%">Signature/Date</th>
                                </tr>
                            </thead>
                            <tbody id="verificationFDTable">
                                <?php foreach ($teamSigns as $e) { ?>
                                    <tr>
                                        <td style="vertical-align:middle; text-align:center; font-weight:bold;"><?= $e['name'] ?></td>
                                        <td style="vertical-align:middle; text-align:center; font-weight:bold;"><?= $e['position'] ?></td>
                                        <td data-vfd-id="<?= $e['id'] ?? '' ?>" data-account-id="<?= $e['signee_id'] ?>">
                                            <div class="vfd-esign" <?= $e['sign'] ? 'data-value="' . $e['sign'] . '"' : '' ?>></div>
                                            <input type="date" class="form-control" onchange="vfdDateChange(this)" <?= $e['date'] ? 'value="' . $e['date'] . '"' : '' ?> />
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div data-section="hazardAnalysis" class="tab-pane" id="hazard_analysis_and_preventive_measures">
        <div class="alert alert-danger" style="display:none;" id="haWarning">
            <div style="display:flex;">
                <i class="fa fa-warning bold" style="margin-top: 4px;margin-right: .75rem;"></i>
                <div>
                    <strong>Warning: CCP Determination Required</strong> <br><br>
                    A specific process step has been recognized as a <strong>Critical Control Point (CCP)</strong> in the <strong>CCP DETERMINATION</strong> table, yet it is not currently identified as such within this table. Please update.
                    <div> <br>
                        <span style="font-weight:600;">Process Step(s):</span> <br>
                        <ul class="affected-process-steps"></ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 2rem;">
            <div class="col-md-12">
                <p class="">
                    Hazard identification (column 2) considers known or reasonably foreseeable hazards (i.e., potential hazards) that may be present in the food because the hazard occurs naturally, the hazard may be unintentionally introduced, or the hazard may be intentionally introduced for economic gain.
                </p>
            </div>
            <div class="col-md-6">
                <ul style="list-style-type: none; font-weight: 600; display:grid; gap:.5rem">
                    <li>
                        B = Biological hazards including bacteria, viruses, parasites, and environmental pathogens
                    </li>
                    <li>
                        C = Chemical hazards, including radiological hazards, food allergens, substances such as pesticides and drug residues, natural toxins, decomposition, and unapproved food or color additives
                    </li>
                    <li>
                        P = Physical hazards include potentially harmful extraneous matter that may cause choking, injury, or other adverse health effects
                    </li>
                    <li>
                        A = Allergen Hazards
                    </li>
                    <li>
                        I = Intentional Contamination
                    </li>
                    <li>
                        E = Economic Fraud
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table hazardAssessmentTable">
                        <tbody>
                            <tr>
                                <td colspan="3">Risk Assessment Control Measure</td>
                                <td colspan="5" class="bold" style="text-align:center;">Severity</td>
                            </tr>
                            <tr>
                                <td colspan="3" data-risk="low">1 &mdash; 4 = Low Risk</td>
                                <td rowspan="2" style="width: 14%;" class="ll">Negligible</td>
                                <td rowspan="2" style="width: 14%;" class="ll">Minor</td>
                                <td rowspan="2" style="width: 14%;" class="ll">Moderate</td>
                                <td rowspan="2" style="width: 14%;" class="ll">Major</td>
                                <td rowspan="2" style="width: 14%;" class="ll">Extreme</td>
                            </tr>
                            <tr>
                                <td colspan="3" data-risk="medium">5 &mdash; 10 = Medium Risk</td>
                            </tr>
                            <tr>
                                <td colspan="3" data-risk="high">12 &mdash; 25 = High Risk</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td rowspan="5" class="bold" style="text-orientation: mixed;writing-mode: vertical-lr;transform: rotate(180deg); text-align:center;">
                                    (Probability) <br> Likelihood
                                </td>
                                <td>Very Unlikely</td>
                                <td>1</td>
                                <td data-risk="low">1</td>
                                <td data-risk="low">2</td>
                                <td data-risk="low">3</td>
                                <td data-risk="low">4</td>
                                <td data-risk="medium">5</td>
                            </tr>
                            <tr>
                                <td>Rarely Occur</td>
                                <td>2</td>
                                <td data-risk="low">2</td>
                                <td data-risk="low">4</td>
                                <td data-risk="medium">6</td>
                                <td data-risk="medium">8</td>
                                <td data-risk="medium">10</td>
                            </tr>
                            <tr>
                                <td>Possible</td>
                                <td>3</td>
                                <td data-risk="low">3</td>
                                <td data-risk="medium">6</td>
                                <td data-risk="medium">9</td>
                                <td data-risk="high">12</td>
                                <td data-risk="high">15</td>
                            </tr>
                            <tr>
                                <td>Likely Occur</td>
                                <td>4</td>
                                <td data-risk="low">4</td>
                                <td data-risk="medium">8</td>
                                <td data-risk="high">12</td>
                                <td data-risk="high">16</td>
                                <td data-risk="high">20</td>
                            </tr>
                            <tr>
                                <td>Occurs Frequently</td>
                                <td>5</td>
                                <td data-risk="medium">5</td>
                                <td data-risk="medium">10</td>
                                <td data-risk="high">15</td>
                                <td data-risk="high">20</td>
                                <td data-risk="high">25</td>
                            </tr>
                            <tr>
                                <td colspan="8"></td>
                            </tr>
                            <tr>
                                <td colspan="8">Risk = Severity x Likelihood (Probability)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="haccpTableContainer">
            <table id="hbHazardAnalysis">
                <thead>
                    <tr>
                        <th style="width: 13%;" rowspan="2">
                            <div style="display:flex; align-items:center;flex-direction:column; justify-content:space-between;gap:3rem;">
                                <span>Process Step </span>
                                <label class="stepSelector">
                                    Find:
                                    <select class="">
                                        <option selected disabled>None</option>
                                    </select>
                                </label>
                            </div>
                        </th>
                        <th colspan="2" style="width: 26%;" rowspan="2">
                            Identify potential hazards introduced, controlled, or enhanced at this step <br>
                            <small class="text-muted font-normal">
                                Severity Level (S): <br>
                                <ul style="list-style-type:none; margin:0;padding:0;">
                                    <li>1 = Negligible</li>
                                    <li>2 = Minor</li>
                                    <li>3 = Moderate</li>
                                    <li>4 = Major</li>
                                    <li>5 = Extreme</li>
                                </ul>
                            </small>
                        </th>
                        <th style="width: 11%;" colspan="2">
                            Do any potential food safety hazards require preventive control?
                        </th>
                        <th style="width: 10%;" rowspan="2">
                            Justify your decision
                        </th>
                        <th style="width: 20%;" rowspan="2">
                            What preventive control measure(s) can be applied to significantly minimize or prevent the food safety hazard?<br>
                            Process including CCPs, Allergen, Sanitation, Supply-chain, other preventive control
                        </th>
                        <th style="width: 10%;" colspan="2">
                            Is the preventive control applied at this step?
                        </th>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="noborder">Yes/No</td>
                        <td>Likelihood (L)</td>
                        <td>Yes/No</td>
                        <td>Risk</td>
                    </tr>
                </thead>
                <tbody class="haccp-builder-table-body"></tbody>
            </table>
        </div>
    </div>
    <div data-section="ccpDetermination" class="tab-pane" id="ccp_determination">
        <div class="alert alert-danger" style="display:none;" id="ccpDWarning">
            <div style="display:flex;">
                <i class="fa fa-warning bold" style="margin-top: 4px;margin-right: .75rem;"></i>
                <div>
                    <strong>Warning: CCP Determination Required</strong> <br><br>
                    A specific process step has been recognized as a <strong>Critical Control Point (CCP)</strong> in the <strong>HAZARD ANALYSIS</strong> table, yet it is not currently identified as such within this table. Please update.
                    <div> <br>
                        <span style="font-weight:600;">Process Step(s):</span> <br>
                        <ul class="affected-process-steps"></ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="note note-info">
            <strong>Tip!</strong>
            Hover on each column header to view instructions/description.
        </div>
        <div class="haccpTableContainer">
            <table id="hbCCPdetermination">
                <thead>
                    <tr>
                        <th style="width: 13%;">
                            <div style="display:flex; align-items:center;flex-direction:column; justify-content:space-between;gap:3rem;">
                                <span>Process Step </span>
                                <label class="stepSelector">
                                    Find:
                                    <select class="">
                                        <option selected disabled>None</option>
                                    </select>
                                </label>
                            </div>
                        </th>
                        <th colspan="2" style="width: 20%;">Significant Hazards</th>
                        <th style="width: 15%;" class="tooltips" data-container="body" data-placement="bottom" data-html="true" data-original-title="<div class='text-left'>*If yes, move to the next questions. <br>
                                                    *If no, is control at this step necessary for safety? <br>
                                                    *If yes, modify step, process or product and return to Q1. <br>
                                                    *If no, stop; it is not a CCP. <br>
                                                    Identify how and where this hazard will be controlled.</div>">
                            Q1. Do preventative measures exist at this step for the identified hazard? </th>
                        <th style="width: 15%;" class="tooltips" data-container="body" data-placement="bottom" data-html="true" data-original-title="<div class='text-left'> * If no, move to the next question. <br>
                                                    * If yes, this is a CCP.</div>">
                            Q2. Does this step eliminate the hazard or reduce the likelihood of its occurrence to an acceptable level? </th>
                        <th style="width: 15%;" class="tooltips" data-container="body" data-placement="bottom" data-html="true" data-original-title="<div class='text-left'>* If no, stop, not a CCP. <br>
                                                     * If yes, proceed to the next question</div>">
                            Q3. Could contamination with the identified hazard occur in excess of acceptable levels or increase to unacceptable levels? </th>
                        <th style="width: 15%;" class="tooltips" data-container="body" data-placement="bottom" data-html="true" data-original-title="<div class='text-left'>* If no, this is a CCP. <br>
                                                     * If yes, stop, not a CCP.</div>">
                            Q4. Will a subsequent step eliminate the hazard or reduce the likelihood of its occurrence to an acceptable level? </th>
                        <th style="width: 7%;">CCP Number</th>
                    </tr>
                </thead>
                <tbody class="haccp-builder-table-body"></tbody>
            </table>
        </div>
    </div>
    <div data-section="processNarrative" class="tab-pane" id="process_narrative">
        <div class="haccpTableContainer">
            <table id="hbProcessNarrative">
                <thead>
                    <tr>
                        <th style="width: 20%;">
                            <div style="display:flex; align-items:center;flex-direction:column; justify-content:space-between;gap:3rem;">
                                <span>Process Step / CCP </span>
                                <label class="stepSelector">
                                    Find:
                                    <select class="">
                                        <option selected disabled>None</option>
                                    </select>
                                </label>
                            </div>
                        </th>
                        <th>Process Narrative</th>
                    </tr>
                </thead>
                <tbody class="haccp-builder-table-body"></tbody>
            </table>
        </div>
    </div>
    <div data-section="ppc" class="tab-pane" id="process_preventive_control">
        <div class="haccpTableContainer">
            <table id="hbPPC">
                <thead></thead>
                <tbody class="haccp-builder-table-body"></tbody>
            </table>
        </div>
    </div>

    <?php if (isset($haccpResource)) : ?>
        <div class="tab-pane" id="process_monitoring_forms">
            e-forms
        </div>
        <div class="tab-pane" id="haccptasks">
            <div class="row">
                <div class="col-md-6">
                    <h5 style="font-weight: bold; margin:0 0 .75rem 0; display:flex; align-items:center; justify-content:start; gap: 1.2rem">
                        <span>Pending </span>
                        <span class="text-muted" style="font-weight:normal;"><span data-pendingtask-count>0</span> item(s)</span>
                    </h5>
                    <div class="todo-tasklist" id="pendingTaskContainer" style="overflow:auto; max-height: 90vh;">
                        <p class="text-muted empty-list">There are no pending task(s) yet.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 style="font-weight: bold; margin:0 0 .75rem 0;">Add new task</h5>
                    <form class="row" style="margin-bottom: 2rem;" id="taskForm">
                        <div class="form-group col-md-12">
                            <label for="taskTtabTitle">Task title <span class="required">*</span></label>
                            <input type="text" id="taskTtabTitle" class="form-control" placeholder="Enter task title" name="task_title" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="tasktabDescription">Description</label>
                            <textarea class="form-control" name="task_description" rows="5" id="tasktabDescription" placeholder="Describe the task..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label">Assign to</label>
                            <div class="col-md-12">
                                <div class="select-container">
                                    <select name="assigned_to" class="form-control mt-multiselect btn btn-default" data-internal>
                                        <option value="" selected disabled>--Select--</option>
                                        <?php foreach ($cigEmployees as $e) {
                                            echo "<option value='{$e['ID']}'>{$e['name']}</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="hide select-container">
                                    <select class="form-control mt-multiselect btn btn-default" data-haccp>
                                        <option value="" selected disabled>--Select--</option>
                                        <?php foreach ($employees as $e) {
                                            echo "<option value='{$e['ID']}'>{$e['name']}</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="mt-radio-inline">
                                    <label class="mt-radio mt-radio-outline">
                                        <input type="radio" name="assignee_pool" value="internal" checked onchange="selectAssignee(this)"> Internal <span></span>
                                    </label>
                                    <label class="mt-radio mt-radio-outline">
                                        <input type="radio" name="assignee_pool" value="haccp" onchange="selectAssignee(this)"> HACCP Team <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="taskTtabDueDate">Desired due date</label>
                            <input type="date" id="taskTtabDueDate" name="task_due" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn green">Submit</button>
                        </div>
                    </form>
                    <h5 style="font-weight: bold; margin:0 0 .75rem 0; display:flex; align-items:center; justify-content:start; gap: 1.2rem">
                        <span>Completed tasks </span>
                        <span class="text-muted" style="font-weight:normal;"><span data-completedtask-count>0</span> item(s)</span>
                    </h5>
                    <div class="todo-tasklist" id="completedTaskContainer" style="overflow:auto; max-height: 40vh;">
                        <p class="text-muted empty-list">No task has been completed yet.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="history">
            <div class="note note-info hide">
                <h4 class="block">Note</h4>
                <p>Changes were traced from every tab/section (Product Description, Process Flow Diagram, Hazard Analysis, and etc.) except for the Overview section above. Every update from the overview fields will affect the whole document and not by history/version.</p>
            </div>
            <div id="myHistoryLogs">
                <div style="display: flex; align-items:center; justify-content:space-between; margin-bottom:2rem;">
                    <div class="">
                        <select id="versionsDropdown" class="form-control" onchange="changeVersionEvt(this)"></select>
                    </div>
                    <a href="#" id="versionViewPDF" data-pdflink="<?= hash('md5', $haccpResource['id']) ?>" class="btn btn-sm blue" style="display:none;" target="_blank">
                        <i class="fa fa-file-pdf-o" style="margin-right: .75rem;"></i>
                        View PDF
                    </a>
                </div>
                <div style="max-height:100vh; overflow-y: auto;">
                    <div class="mt-element-list">
                        <div class="mt-list-container list-news ext-1">
                            <ul style="border-top: 1px solid #e7ecf1;" id="historyLogsList">
                                <li class="mt-list-item hide">
                                    <div class="list-item-content" style="padding-left: 0; font-weight:600;">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec elementum gravida mauris, a tincidunt dolor porttitor eu.
                                    </div>
                                    <div class="list-datetime uppercasex small text-muted" style="padding-left: 0;margin-top:1rem;">
                                        John Doe updated 3 weeks ago
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div style="padding: 0 4rem; ">
                        <h6 class="history-footer text-muted" style="border-left: 1px solid #e7ecf1; padding:2rem 1rem; font-weight:600;">
                            Date started: <span id="historyStarted"></span>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>